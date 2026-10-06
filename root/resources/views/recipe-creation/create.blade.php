@extends("app")
<head>
    <link href="{{Asset('css/select2.min.css')}}" rel="stylesheet" />
</head>
@section('contents')
    <body>
        <div class="container-fluid">
            @if (Session::has('flash_message'))
                <div class="alert alert-success alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close"
                        style="margin-right: 4%;">&times;</a>
                    <strong>Success!</strong> {{ Session::get('flash_message') }}
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix" id="panelbg">
                        <h2 class="panel-title"><b>Create Recipe</b></h2>
                    </div>
                    <div class="panel-body">
                        <input id="token" type="hidden" value="{{ $encrypted_token }}">
                        @include('errors.validation')
                        {!! Form::open(['url' => 'recipe-creation', 'class' => 'form-horizontal', 'id' => 'RecipeForm']) !!}
						<input type="hidden" name="company_id" id="company_id" value="{{session()->get('company_id')}}">
                        <div class="row">
                            <div class="form-group" style="margin-left: 5%; margin-right: 1%;">
                                <label class="col-sm-1 control-label">Date</label>
                                <div class="col-sm-2">
                                <div id="year-view" class="input-group date">
                                        <input id="date" type="date" name="date" value="<?php echo date('Y-m-d'); ?>"
                                            class="form-control" onkeyup="focusNext(event);" autofocus>
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                   
                                </div>
                                <label class="col-sm-4 control-label">Voucher&nbsp;#</label>
                                <div class="col-sm-2">
                                {!! Form::text('vr_no', $codes, ['id' => 'vr_no', 'class' => 'form-control', 'required' => 'required', 'onkeyup' => 'focusNext(event);']) !!}
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group" style="margin-left: 5%; margin-right: 1%;">
                                <label class="col-sm-1 control-label">Select.Recipe</label>
                                <div class="col-sm-2">
                                    

                                    {!! Form::select('recipe_name', $recipe, null, ['id' => 'recipe_name', 'onchange' => 'RecipeKeyUp($(this).val().split("_")[0]), ProductKeyUpBelow($(this).val().split("_")[0]);', 'onkeydown' => 'focusNext(event);', 'class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                                {!! Form::hidden('recipe_id', null, ['id' => 'recipe_id', 'class' => 'form-control']) !!}
                                <label class="col-sm-4 control-label">Recipe&nbsp;Code</label>
                                <div class="col-sm-2">
                                {!! Form::hidden('recipe_code', null, ['id' => 'recipe_code', 'class' => 'form-control']) !!}
                                {!! Form::text('recipe_codes', null, ['id' => 'recipe_codes', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="display:none;">
                            <label class="col-sm-3 control-label">Biller</label>
                            <div class="col-sm-5">
                                <select name="biller" id="biller" class="form-control">
                                    <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group" style="margin-left: 5%; margin-right: 1%;">
                                
                            </div>
                        </div>
                        <!-- <div class="row">
                     <div class="form-group" style="margin-left: 5%; margin-right: 1%;">
                      <label class="col-sm-1 control-label">Select&nbsp;UOM</label>
                      <div class="col-sm-3">
                        {!! Form::select('uoms_id', $uoms, null, ['id' => 'uoms_id', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                      </div>
                      <label class="col-sm-3 control-label">Rate</label>
                      <div class="col-sm-2">
                       {!! Form::text('rates', null, ['id' => 'rates', 'class' => 'form-control', 'required' => 'required', 'onkeyup' => 'rateKeyUp($(this).val());']) !!}
                      </div>

                      <div class="col-sm-2">
                       {!! Form::text('amounts', null, ['id' => 'amounts', 'class' => 'form-control', 'placeholder' => 'Amount']) !!}
                      </div>
                     </div>
                    </div> -->
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <table id="myTable">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <tr>
                                                    {!! Form::hidden('products_id', null, ['id' => 'products_id', 'class' => 'form-control']) !!}
                                                    <div class="col-md-1" style="margin-left: 1%; margin-right: 1%;">
                                                        <div class="form-group">
                                                            <label for="H.S" class="control-label">Code</label>
                                                            <!-- {!! Form::text('product_code', null, ['id' => 'product_code', 'onkeyup' => 'CodeKeyUp($(this).val());', 'class' => 'form-control']) !!} -->
                                                            {!! Form::text('product_code', null, ['id' => 'product_code', 'onkeydown' => 'focusNext(event);', 'class' => 'form-control']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3" style="margin-right: 1%;">
                                                        <div class="form-group">
                                                            <label for="Name" class="control-label">Product Name</label>
                                                            {!! Form::select('product_name', $products, null, ['id' => 'product_name', 'onchange' => 'ProductKeyUps($(this).val().split("_")[0]);', 'onkeydown' => 'focusNext(event);', 'class' => 'form-control']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1" style="margin-right: 1%; display:none;">
                                                        <div class="form-group">
                                                            <label for="Name" class="control-label">Unit</label>
                                                            {!! Form::select('uom_id', $uomss, null, ['id' => 'uom_id', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1" style="margin-right: 1%;">
                                                        <div class="form-group">
                                                            <label for="Name" class="control-label">Unit</label>
                                                            {!! Form::text('unit', null, ['id' => 'unit', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1" style="margin-right: 1%;">
                                                        <div class="form-group">
                                                            <label for="password" class="control-label">Quantity</label>
                                                            {!! Form::text('quantity', null, ['id' => 'quantity', 'onkeyup' => 'QuantityKeyUp($(this).val())', 'onfocus' => 'this.value=""', 'onkeypress' => 'return onlyNumberKey(event)', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2" style="margin-right: 1%;">
                                                        <div class="form-group">
                                                            <label for="password" class="control-label">Rate</label>
                                                            {!! Form::text('price_per_unit', null, ['id' => 'price_per_unit', 'onkeyup' => 'SaleRate($(this).val())', 'onkeypress' => 'return onlyNumberKey(event)', 'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2" style="margin-right: 1%;">
                                                        <div class="form-group">
                                                            <label for="password" class="control-label">Amount</label>
                                                            {!! Form::text('balance', null, ['id' => 'balance',  'class' => 'form-control', 'onkeydown' => 'focusNext(event);']) !!}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1" style="margin-right: 1%;">
                                                        <div class="form-group" style="margin-top: 26px;">
                                                            <!-- <label for="password" class="control-label">Add</label> -->
                                                            <button class="btn btn-success" onkeyup = 'AddGridData();', onclick = 'AddGridData();', type="button">+</button>
                                                        </div>
                                                    </div>

                                                    <!-- <td style="padding-top: 20px;"><button class="btn btn-red" type="button" style="margin-left: -80%;"> <i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-trash" title="Delete Row"></i></button></td> -->
                                                </tr></br>
                                                <table id="myData">
                                                </table>
                                            </div>
                                        </div>
                                    </table></br></br>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading clearfix" id="panelbg">
                                        <div class="container">
                                            <div class="col-xs-5"><button type="button" onclick="TotalRecords()"
                                                    class="btn btn-warning">Total Records</button> </div>
                                            <div class="col-xs-3"> <b style="color: black;">Total Quantity</b> <input
                                                    type="text" id="Totalqty" name="Totalqty" value="0"
                                                    style="color: black;" disabled> </div>
                                            <div class="col-xs-3"> <b style="color: black;">Total Amount</b> <input
                                                    type="text" id="TotalAmount" name="TotalAmount" value="0"
                                                    style="color: black;"> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <center>
                            <div class="form-actions">
                                <button type="button" onclick="submitForm();" class="btn btn-primary">Save</button>
                            </div>
                        </center>
                        <div class="col-lg-3">
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </body>
@stop
@section('scripts')
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <script type="text/javascript">

// $('#product_name').change(function() {
//             $('#product_name').select2().trigger('select2:close');
//             $("#quantity").focus();
//         });

        function RecipeKeyUp(RecipeID) {
            var RecipeID = document.getElementById('recipe_name').value.split("_")[0];
            var RecipeCode = document.getElementById('recipe_name').value.split("_")[1];
            var RecipeName = document.getElementById('recipe_name').value.split("_")[2];
            document.getElementById('recipe_id').value = RecipeID;
            document.getElementById('recipe_code').value = RecipeCode;
            document.getElementById('recipe_codes').value = RecipeCode;
            $.ajax({
                type: "GET",
                url: "{{ asset('recipekeyup-recipe') }}?recID=" + RecipeID,
                success: function(result) {
                    if (result.length > 0) {
                        $('#vr_no').val(result[0].vr_no);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }

        function ProductKeyUpBelow(productID) {
            $("#myData tr").remove();
            $.ajax({
                type: "GET",
                url: "{{ asset('productkeyup-change') }}?prodID=" + productID,
                success: function(data) {
                    if (data.length > 0) {
                        var Grandamount = 0;
                        var quantity = 0;
                        $("#myData tr").remove();

                        $.each(data, function(key, value) {

                            var newRow = '<tr>';
                            newRow +=
                                `<td style="padding-top:20px; display:none"><input id="product_id" name="product_id[]" value="${data[key].products.id}" type="text" class="form-control" style="margin-left: 7%; width: 53%;"></td>`;

                            newRow +=
                                `<td style="padding-top:20px;"><input id="product_code" name="product_code[]" value="${data[key].products.product_code}" type="text" class="form-control" style="margin-left: 7%; width: 53%;"></td>`;

                            newRow +=
                                `<td style="padding-top:20px;"><input id="product_name" name="product_name[]" value="${data[key].products.product_name}" type="text" class="form-control" style="margin-left: -33%; width: 161%;"></td>`;


                            newRow +=
                                `<td style="display:none;"><input id="uom_id" name="uom_id[]" value="${data[key].uom_id}" type="text" class="form-control" style="margin-left: -25%; width: 120%;"></td>`;

                            newRow +=
                                `<td style="padding-top:20px;"><input id="" name="[]" value="KG" type="text" class="form-control" style="margin-left: 34%; width: 53%;">`;

                            newRow +=
                                `<td style="padding-top:20px; display:none;"><input id="quantityshow" name="quantityshow[]"  type="text" class="form-control" style="margin-left: -6%; width: 53%;" value="${data[key].quantity}"></td>`;

                            newRow +=
                                `<td style="padding-top:20px;"><input id="quantity" name="quantity[]"  type="text" class="form-control" onkeyup="javascript:CalculateAmount($(this).val(), $(this).closest(\'tr\').index());" style="margin-left: -6%; width: 53%;" value="${data[key].quantity}"></td>`;


                            newRow +=
                                `<td style="padding-top:20px;"><input id="rate" name="rate[]" value="${data[key].products.product_cost}" type="text" class="form-control" style="margin-left:-45%; width: 106%;"></td>`;


                            var sum = sum + parseFloat(data[key].amount).toFixed(2);
                            var total = parseFloat(data[key].quantity).toFixed(2) * parseFloat(data[key]
                                .products.product_cost).toFixed(2);

                            newRow +=
                                `<td style="padding-top:20px;"><input id="amount" name="amount[]" value="${total}" type="text" class="form-control" style="margin-left: -31%; width: 106%;"></td>`;
                            Grandamount = parseFloat(Grandamount) + parseFloat(total);
                            quantity = parseFloat(quantity) + parseFloat(data[key].quantity);

                            newRow +=
                                `<td style="padding-top: 20px;"><button class="btn btn-red" type="button" style="margin-left: -80%;"> <i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-trash" title="Delete Row"></i></button></td>`;

                            '</tr>';
                            $('#myData').append(newRow);
                            document.getElementById("product_code").focus();
                            //below
                            document.getElementById('TotalAmount').value = parseFloat(Grandamount)
                                .toFixed(2);
                            document.getElementById('Totalqty').value = parseFloat(quantity).toFixed(4);
                        });
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }

        function CalculateAmount(qty, rowIndex) {
            var rate = $('tr:eq(' + rowIndex + ')', myData).find("td:eq('7')").find('input').val();
            var grand = rate * qty;
            $('tr:eq(' + rowIndex + ')', myData).find("td:eq('8')").find('input').val(grand);
        }

        function rateKeyUp(rate) {
            var qty = document.getElementById('quantitys').value;
            var amount = qty * rate;
            document.getElementById('amounts').value = amount;
        }


        $("#recipe_name").select2();
        $("#recipe_name").next(".select2").find(".select2-selection").focus(function() {
            $("#recipe_name").select2("open");
        });

        $("#product_name").select2();
        $("#product_name").next(".select2").find(".select2-selection").focus(function() {
            $("#product_name").select2("open");
        });

        $("#uom_id").select2();
        $("#uom_id").next(".select2").find(".select2-selection").focus(function() {
            $("#uom_id").select2("open");
        });

        $("#uoms_id").select2();
        $("#uoms_id").next(".select2").find(".select2-selection").focus(function() {
            $("#uoms_id").select2("open");
        });

        function TotalRecords() {
            var rowCount = document.getElementById('myData').rows.length;
            alert("Total Number of Records Are: " + rowCount);
        }
        // on javascript onclick on product dropdown 
        function ProductKeyUps(recipeID) {
            $('#product_name').select2().trigger('select2:close');
             $("#quantity").focus();
            // alert('sss')
            $.ajax({
                type: "GET",
                url: "{{ asset('productkeyup-recipe') }}?prodID=" + recipeID,
                success: function(result) {
                    if (result.length > 0) {
                        $('#product_code').val(result[0].product_code);
                        $('#price_per_unit').val(result[0].product_cost);
                        $('#products_id').val(result[0].id);
                        $('#unit').val(result[0].uom);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }
        function SaleRate(salerate) {
            var quantity = document.getElementById('quantity').value;
            var total = parseFloat(quantity * salerate).toFixed(2);
            document.getElementById('balance').value = total;
        }
        function QuantityKeyUp(quantity) {
            var price = document.getElementById('price_per_unit').value;
            total = parseFloat(quantity * price).toFixed(2);
            document.getElementById('balance').value = total;
        }
        function myDeleteFunction(row) {
            alertify.confirm("Are you sure you want to delete this row?", function(e) {
                if (e) {
                    var TotalQty = parseFloat(document.getElementById('Totalqty').value).toFixed(2);
                    var TotalAmount = parseFloat(document.getElementById('TotalAmount').value).toFixed(2);

                    var qty = $(row).find("td:eq('5')").find("input").val();
                    var amount = $(row).find("td:eq('8')").find("input").val();

                    var grandQty = parseFloat(TotalQty).toFixed(2) - parseFloat(qty).toFixed(2);
                    var grandAmount = parseFloat(TotalAmount).toFixed(2) - parseFloat(amount).toFixed(2);

                    document.getElementById('Totalqty').value = parseFloat(grandQty).toFixed(2);
                    document.getElementById('TotalAmount').value = parseFloat(grandAmount).toFixed(2);
                    $(row).remove();
                    document.getElementById("product_code").focus();
                } else {
                    alertify.alert("File is safe!");
                }
            });
        }
        function AddGridData() {
            if ($("#products_id").val() == "") {
                document.getElementById("product_code").focus();
                Swal.fire('Product Cant be Empty!');
                e.preventdefault();
            }
            if ($("#quantity").val() == "") {
                document.getElementById("quantity").focus();
                Swal.fire('Quantity Cant be Empty!');
                e.preventdefault();
            }
            if ($("#price_per_unit").val() == "") {
                document.getElementById("price_per_unit").focus();
                Swal.fire('Rate Cant be Empty!');
                e.preventdefault();
            }
            var date = document.getElementById('date').value;
            var InvoiceNo = document.getElementById('vr_no').value;
            var ProductId = document.getElementById('products_id').value;
            var ProductCode = document.getElementById('product_code').value;
            var ProductName = document.getElementById('product_name').value.split("_").pop();
            var UOMID = document.getElementById('uom_id').value.split("_")[0];
            var UOM = document.getElementById('uom_id').value.split("_").pop();
            var Quantity = document.getElementById('quantity').value;
            var Price = document.getElementById('price_per_unit').value;
            var Amounts = document.getElementById('balance').value;
            var Amount = parseFloat(Amounts).toFixed(2);
            var Totalqty = document.getElementById('Totalqty').value;
            var totalAmount = document.getElementById('TotalAmount').value;
            var grandQty = parseFloat(Quantity) + parseFloat(Totalqty);
            var grandAmount = parseFloat(Amount) + parseFloat(totalAmount);
            document.getElementById('Totalqty').value = grandQty;
            document.getElementById('TotalAmount').value = grandAmount;
            var tableHtml = '<tr>';
            //0
            tableHtml +=
                `<td style="display:none;"><input id="product_id" name="product_id[]" value="${ProductId}" type="text" class="form-control"></td>`;
            //1
            tableHtml +=
                `<td style="padding-top:20px;"><input id="product_code" name="product_code[]" value="${ProductCode}" type="text" class="form-control" style="margin-left: 7%; width: 53%;"></td>`;
            //2
            tableHtml += `<td style="padding-top:20px;"><input id="" name="[]" value="${ProductName}" type="text" class="form-control" style="margin-left: -33%;
    width: 161%;"></td>`;
            //3
            tableHtml += `<td style="display:none;"><input id="uom_id" name="uom_id[]" value="${UOMID}" type="text" class="form-control" style="margin-left: -25%;
    width: 120%;"></td>`;
            //4
            tableHtml += `<td style="padding-top:20px;"><input id="" name="[]" value="${UOM}" type="text" class="form-control" style="margin-left: 34%;
    width: 53%;"></td>`;

            //6
            tableHtml +=
                `<td style="padding-top:20px;"><input id="quantity" name="quantity[]" value="${Quantity}" type="text" class="form-control" style="margin-left: -6%; width: 53%;"></td>`;
            //7
            //10
            tableHtml +=
                `<td style="padding-top:20px;"><input id="rate" name="rate[]" value="${Price}" type="text" class="form-control" style="margin-left:-45%; width: 106%;"></td>`;
            //11
            tableHtml += `<td style="padding-top:20px;"><input id="amount" name="amount[]" value="${Amount}" type="text" class="form-control" style="margin-left: -31%;
    width: 106%;"></td>`;
            //12
            tableHtml +=
                '<td style="padding-top: 20px;"><button class="btn btn-red" type="button" style="margin-left: -80%;"> <i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-trash" title="Delete Row"></i></button></td>';
            tableHtml += '</tr></br>';
            $('#myData').append(tableHtml);
            document.getElementById("product_code").focus();
        }

        function submitForm() {
    // alert('dd')
            $("#RecipeForm").submit();
        }
    </script>
@stop
