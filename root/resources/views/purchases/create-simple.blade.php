@extends("app")

<head>
<link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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
                    <div class="panel-heading clearfix">
                        <h3 class="panel-title">Add Purchase Bill</h3>
                    </div>
                    <div class="panel-body">
                        <input id="token" type="hidden" value="{{ $encrypted_token }}">
                        @include('errors.validation')
                        {!! Form::open(['url' => 'purchases', 'class' => 'form-horizontal']) !!}
                        {!! Form::hidden('company_id', session()->get('company_id'), ['id' => 'company_id']) !!}
                        <div class="row">
                            <div class="form-group" style="margin-left: 1%; margin-right: 1%;">
                                <label class="col-sm-1 control-label">Date</label>
                                <div class="col-sm-2">
                                    <div id="year-view" class="input-group date">
                                        <input id="date" type="date" name="date" value="<?php echo date('Y-m-d'); ?>"
                                            class="form-control" , autofocus>
                                        <!-- <span class="input-group-addon"><i class="fa fa-calendar"></i></span>  -->
                                    </div>
                                </div>

                                <label class="col-sm-3 control-label">Bill No</label>
                                <div class="col-sm-2">

                                    {!! Form::text('bill_no', $codes, ['id' => 'bill_no', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                    {!! Form::hidden('bill_no', $codes, ['id' => 'bill_no', 'class' => 'form-control']) !!}
                                </div>


                            </div>
                        </div>
                        <div class="row" id="ledgerRow" style="display:none;">
                            <div class="form-group" style="margin-left: 1%; margin-right: 1%;">
                                <label class="col-sm-1 control-label">Due&nbsp;Date</label>
                                <div class="col-sm-2">
                                    <div id="year-view" class="input-group date">
                                        <!-- <input id="due_date" type="date" name="due_date" class="form-control">  -->
                                        <input id="due_date" type="date" value="<?php echo date('Y-m-d'); ?>" name="due_date"
                                            class="form-control">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>

                                <label class="col-sm-1 control-label"></label>
                                <div class="col-sm-2">
                                    {!! Form::text('particulars', null, ['id' => 'particulars', 'placeholder' => 'Description', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row" style="display:none;">
                            <div class="form-group" style="margin-left: 1%; margin-right: 1%;">
                                <label class="col-sm-1 control-label">Warehouse</label>
                                <div class="col-sm-2">
                                    <!-- {!! Form::select('grn_no', $grns, null, ['id' => 'grn_no', 'onchange' => 'GRNMouseUp($(this).val());', 'class' => 'form-control livesearch']) !!} -->
                                    {!! Form::select('warehouse_id', $warehouse, null, ['id' => 'warehouse_id', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group" style="margin-left: 1%; margin-right: 1%;">
                                {!! Form::hidden('account_id', 1, ['id' => 'account_id', 'class' => 'form-control']) !!}
                                <label class="col-sm-1 control-label">Account</label>
                                <div class="col-sm-2">
                                    {!! Form::select('suppliers_id', $Account, null, ['id' => 'suppliers_id', 'onchange' => 'javascript:PartyKeyUp($(this).val());', 'onkeydown' => 'focusNext(event);', 'class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                                <!-- <label class="col-sm-1 control-label">Address</label>  -->
                                <div class="col-sm-3">
                                    {!! Form::text('address', null, ['id' => 'address', 'class' => 'form-control', 'placeholder' => 'Address', 'disabled' => 'disabled', 'placeholder' => 'Walking Costomer']) !!}
                                </div>
                                <!-- <label class="col-sm-1 control-label">NTN</label>  -->
                                <div class="col-sm-2">
                                    {!! Form::text('city', null, ['id' => 'city', 'class' => 'form-control', 'placeholder' => 'City', 'disabled' => 'disabled']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <table id="myTable">
                                                <div class="container-fluid">
                                                    <div class="row">
                                                        <tr>
                                                            {!! Form::hidden('product_id', null, ['id' => 'product_id', 'class' => 'form-control']) !!}
                                                            <div class="col-md-1"
                                                                style="margin-left: 1%; margin-right: 1%;">
                                                                <div class="form-group">
                                                                    <label for="H.S" class="control-label">Code</label>
                                                                    {!! Form::text('product_code', null, ['id' => 'product_code', 'class' => 'form-control']) !!}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3"
                                                                style="margin-left: 1%; margin-right: 1%;">
                                                                <div class="form-group">
                                                                    <label for="Name" class="control-label">Product
                                                                        Name</label>
                                                                    {!! Form::select('product_name', $products, null, ['id' => 'product_name', 'onchange' => 'productMouseUp($(this).val().split("_")[0]);', 'class' => 'form-control']) !!}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2" style="display:none;">
                                                                <div class="form-group">
                                                                    <label for="Name" class="control-label">Tax
                                                                        Rate</label>
                                                                    {!! Form::text('tax_id', 0, ['id' => 'tax_id', 'onchange' => 'javascript:CalculateTax($(this).val().split("_").pop(), $(this).closest(\'tr\').index())', 'class' => 'form-control']) !!}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1"
                                                                style="margin-left: 1%; margin-right: 1%; display:none;">
                                                                <div class="form-group">
                                                                    <label for="Name" class="control-label">Unit</label>
                                                                    {!! Form::select('uom_id', $uoms, null, ['id' => 'uom_id', 'class' => 'form-control']) !!}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1"
                                                                style="margin-left: 1%; margin-right: 1%;">
                                                                <div class="form-group">
                                                                    <label for="Name" class="control-label">Unit</label>
                                                                    {!! Form::text('uom', null, ['id' => 'uom', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1"
                                                                style="margin-left: 1%; margin-right: 1%;">
                                                                <div class="form-group">
                                                                    <label for="password"
                                                                        class="control-label">Quantity</label>
                                                                    {!! Form::text('quantity', null, ['id' => 'quantity', 'onkeyup' => 'QuantityKeyUp($(this).val())', 'onkeypress' => 'return onlyNumberKey(event)', 'onpaste' => 'return false;', 'ondrop' => 'return false;', 'autocomplete' => 'off', 'class' => 'form-control', 'onfocus'=>'this.value=""']) !!}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2"
                                                                style="margin-left: 1%; margin-right: 1%;">
                                                                <div class="form-group">
                                                                    <label for="password"
                                                                        class="control-label">Price</label>
                                                                    {!! Form::text('price', null, ['id' => 'price', 'onkeyup' => 'PriceKeyUp($(this).val())', 'onkeypress' => 'return onlyNumberKey(event)', 'onpaste' => 'return false;', 'ondrop' => 'return false;', 'autocomplete' => 'off', 'class' => 'form-control']) !!}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1"
                                                                style="margin-left: 1%; margin-right: 1%; display:none;">
                                                                <div class="form-group">
                                                                    <label for="Warehouse"
                                                                        class="control-label">Warehouse</label>
                                                                    {!! Form::select('warehouse_id', $warehouse, null, ['id' => 'warehouse_id', 'class' => 'form-control livesearch']) !!}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="password"
                                                                        class="control-label">Total</label>
                                                                    {!! Form::text('total', null, ['id' => 'total', 'class' => 'form-control', 'onkeypress' => 'return onlyNumberKey(event)', 'disabled' => 'disabled']) !!}
                                                                </div>
                                                            </div>&nbsp;
                                                            <button class="btn btn-success" type="button" onkeyup="AddGridData();" onclick="AddGridData();"
                                                        style="margin-top:2%;">Add</button>

                                                        </tr>
                                                        
                                                    </div>
                                                </div>
                                            </table>
                                            <table id="myData">
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading clearfix" id="panelbg">
                                                <div class="container">
                                                    <div class="col-lg-5"><button type="button"
                                                            onclick="TotalRecords()" class="btn btn-warning">Total
                                                            Records</button> </div>
                                                    <!-- <div class="col-xs-3">  </div> -->
                                                    <div class="col-lg-2"> <b style="color: black;">Total Qty</b>
                                                        <input type="text" id="TotalRate" name="TotalRate" value="0"
                                                            style="color: black;" disabled>
                                                    </div>
                                                    <div class="col-lg-3"> <b style="color: black;">Total Amount</b>
                                                        <input type="text" id="TotalAmount" name="TotalAmount" value="0"
                                                            style="color: black;" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <center>
                            <div class="form-actions">
                                <button type="button" class="btn btn-primary" id="btnSave" name="btnSave">Save</button>
                            </div>
                        </center>
                        <!-- <div class="col-lg-3">
                                            <button type="button" onclick="AddRowFunction()" class="btn btn-success"><i class="fa fa-plus"></i> </button>
                                            <button type="button" onclick="TotalRecords()" class="btn btn-success">Total Records</button>
                                        </div> -->
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
        var sum = 0;


        $("#suppliers_id").select2();
        $("#suppliers_id").next(".select2").find(".select2-selection").focus(function() {
            $("#suppliers_id").select2("open");
        });

        $("#product_name").select2();
        $("#product_name").next(".select2").find(".select2-selection").focus(function() {
            $("#product_name").select2("open");
        });

        $('#suppliers_id').change(function() {
            $('#suppliers_id').select2().trigger('select2:close');
            $("#product_code").focus();
        });



        function onlyNumberKey(evt) {
        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
        }

        function TotalRecords() {
            var rowCount = document.getElementById('myData').rows.length;
            alert("Total Number of Records Are: " + rowCount);
        }

        function GetSupplierID(value) {
            document.getElementById('account_id').value = value;
        }

        function PartyKeyUp(partyId) {
            $.ajax({
                type: "GET",
                url: "{{ asset('partyonchange-ajax') }}?party_id=" + partyId,
                success: function(result) {
                    if (result.length > 0) {
                        $('#account_id').val(result[0].id);
                        $('#address').val(result[0].address);
                        $('#strn').val(result[0].strn);
                        $('#ntn').val(result[0].ntn);
                        $('#city').val(result[0].city);
                    }
                }
            })
        }

        function QuantityKeyUp(quantity) {
            var price = document.getElementById('price').value;
            var tax = document.getElementById('tax_id').value.split("_").pop();
            var taxvalue = tax / 100 * price * quantity;
            total = (quantity * price) + taxvalue;
            document.getElementById('total').value = total;
        }

        function PriceKeyUp(price) {
            var quantity = document.getElementById('quantity').value;
            var tax = document.getElementById('tax_id').value.split("_").pop();
            var taxvalue = tax / 100 * price * quantity;
            total = (quantity * price) + taxvalue;
            document.getElementById('total').value = total;
        }

        function CalculateTax(tax) {
            var quantity = document.getElementById('quantity').value;
            var price = document.getElementById('price').value;
            var taxvalue = tax / 100 * price * quantity;
            total = (quantity * price) + taxvalue;
            document.getElementById('total').value = total;
        }

        function myDeleteFunction(row) {
            Swal.fire({
                    title: "Are You Sure?",
                    text: "Confirm Transaction?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Create it!',
                    confirmButtonColor: '#28A745',
                    cancelButtonText: 'No, cancel!',
                    cancelButtonColor: '#DC3545',
                }).then((result) => {
                    if (result.isConfirmed) {
                    var TotalRate = document.getElementById('TotalRate').value;
                    var TotalAmount = document.getElementById('TotalAmount').value;

                    var rate = $(row).find("td:eq('5')").find("input").val();
                    var amount = $(row).find("td:eq('8')").find("input").val();

                    var grandRate = parseInt(TotalRate) - parseInt(rate);
                    var grandAmount = parseInt(TotalAmount) - parseInt(amount);
                    document.getElementById('TotalRate').value = grandRate;
                    document.getElementById('TotalAmount').value = grandAmount;
                    $(row).remove();
                    // alertify.alert("File is Removed!");
                }
            });
            // if(confirm("Are you sure you want to delete this row?"))
            // {
            // 	$(row).remove();
            // }
        }

        function AddGridData() {
            var ProductId = document.getElementById('product_id').value;
            var ProductCode = document.getElementById('product_code').value;
            var ProductName = document.getElementById('product_name').value.split("_").pop();
            //var Tax = document.getElementById('tax_id').value.split("_").pop();
            // var TaxID = document.getElementById('tax_id').value.split("_")[0];
            var UOM = document.getElementById('uom').value;
            var UOMID = document.getElementById('uom_id').value.split("_")[0];
            // var UOM = document.getElementById('uom_id').value.split("_").pop();
            var Quantity = document.getElementById('quantity').value;
            var Price = document.getElementById('price').value;
            var warehouse_id = document.getElementById('warehouse_id').value;
            var Total = document.getElementById('total').value;

            // document.getElementById('TotalRate').value = Price;
            // document.getElementById('TotalAmount').value = Total;

            var TotalRate = document.getElementById('TotalRate').value;
            var totalAmount = document.getElementById('TotalAmount').value;
            // alert(TotalRate)
            // alert(totalAmount)


            var grandRate = Quantity + parseInt(TotalRate);
            // alert(grandRate)
            var grandAmount = parseInt(Total) + parseInt(totalAmount);

            document.getElementById('TotalRate').value = grandRate;
            document.getElementById('TotalAmount').value = grandAmount;


            if((ProductId) == "" || (ProductId) == 0){
                Swal.fire('Select Product First!');
                document.getElementById("product_code").focus();
                    e.preventdefault();
            }

            if((Quantity) == "" || (Quantity) == 0 || (Quantity) == 'NaN' ){
                document.getElementById("quantity").focus();
                Swal.fire('Quantity Cant be Empty or 0!');
                    e.preventdefault();
            }

            if((Price) == "" || (Price) == 0 || (Price) == 'NaN' ){
                document.getElementById("price").focus();
                // alert('Price Cant be Empty or 0!');
                Swal.fire('Price Cant be Empty or 0!');
                    e.preventdefault();
            }

            var tableHtml = '<tr>';
            // tableHtml += '<td class="text-center"><i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-cancel icon-larger red-color" title="Delete Row"></i> </td>';var TotalRate = document.getElementById('TotalRate').value;
            //tableHtml += '<td>'+ ProductId +'</td>';
            tableHtml +=
                `<td style="display:none;"><input id="test" value="${ProductId}" type="text" class="form-control" disabled></td>`;
            //tableHtml += '<td>'+ ProductCode +'</td>';
            tableHtml +=
                `<td style="padding-top:20px;"><input id="test" value="${ProductCode}" type="text" class="form-control" style="margin-left: 7%; width: 53%;" disabled></td>`;
            //tableHtml += '<td>'+ ProductName +'</td>';
            tableHtml +=
                `<td style="padding-top:20px;"><input id="test" value="${ProductName}" type="text" class="form-control" style="margin-left:-27%; width: 160%;" disabled></td>`;
            //tableHtml += '<td>'+ UOMID +'</td>';
            tableHtml +=
                `<td style="display:none;"><input id="test" value="${UOMID}" type="text" class="form-control" disabled></td>`;
            //tableHtml += '<td>'+ UOM +'</td>';
            tableHtml +=
                `<td style="padding-top:20px;"><input id="test" value="${UOM}" type="text" class="form-control" style="margin-left:46%; width: 54%;" disabled></td>`;
            //tableHtml += '<td>'+ Quantity +'</td>';
            tableHtml +=
                `<td style="padding-top:20px;"><input id="test" value="${Quantity}" type="text" class="form-control" style="margin-left:13%; width: 54%;" onkeypress = "return onlyNumberKey(event)",  onkeyup="QtyChange($(this).val(), $(this).closest('tr').index());"></td>`;
            //tableHtml += '<td>'+ Price +'</td>';
            tableHtml +=
                `<td style="padding-top:20px;"><input id="test" value="${Price}" type="text" class="form-control" style="margin-left:-21%; width: 107%;" onkeypress = "return onlyNumberKey(event)",  onkeyup="RateChange($(this).val(), $(this).closest('tr').index());"></td>`;

            tableHtml +=
                `<td style="padding-top:20px; display:none;"><input id="test" value="${warehouse_id}" type="text" class="form-control" style="margin-left:-32%; width: 103%;" disabled></td>`;
            //tableHtml += '<td>'+ Total +'</td>';
            tableHtml +=
                `<td style="padding-top:20px;"><input id="test" value="${Total}" type="text" class="form-control" style="margin-left:-7%; width: 109%;" disabled></td>`;
            tableHtml +=
                '<td style="padding-top: 20px;"><button class="btn btn-red" type="button" style="margin-left: 80%;"> <i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-trash" title="Delete Row"></i></button></td>';
            tableHtml += '</tr></br>';
            $('#myData').append(tableHtml);
            $('#product_name').select2('open');
            // document.getElementById("product_code").focus();
        }

        function QtyChange(qty, RowIndex) {
            var Rate = $('tr:eq(' + RowIndex + ')', myData).find("td:eq('6')").find('input').val();
            // alert(Rate)
             var total = Rate * qty;
             $('tr:eq(' + RowIndex + ')', myData).find("td:eq('8')").find('input').val(total);
        }

        function RateChange(Rate, RowIndex) {
            var Qty = $('tr:eq(' + RowIndex + ')', myData).find("td:eq('5')").find('input').val();
            // alert(Rate)
             var total = Rate * Qty;
             $('tr:eq(' + RowIndex + ')', myData).find("td:eq('8')").find('input').val(total);
        }


        function productMouseUp(productID, rowIndex) {
            $.ajax({
                type: "GET",
                url: "{{ asset('productmouseup-ajax') }}?product_ID=" + productID,
                success: function(result) {
                    if (result.length > 0) {
                        $('#product_code').val(result[0].product_code);
                        $('#uom').val(result[0].uom);
                        $('#product_id').val(result[0].id);
                        $('#price').val(parseInt(result[0].product_cost));
                        $('#uom').val(result[0].uom);
                        var price = $("#price").val();
                        var quantity = $("#quantity").val();
                        var total = price * quantity;
                        document.getElementById('total').value = total;
                        $("#quantity").focus();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }

        $("#btnSave").click(function() {
            if ($('#suppliers_id').val() == '') {
                Swal.fire('Select Supplier First');
                        return false;
                    }
                    Swal.fire({
                    title: "Are You Sure?",
                    text: "Confirm Transaction?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Create it!',
                    confirmButtonColor: '#28A745',
                    cancelButtonText: 'No, cancel!',
                    cancelButtonColor: '#DC3545',
                }).then((result) => {
                    if (result.isConfirmed) {
                   

                    var purchase = new Object();
                    purchase.account_id = $("#account_id").val();
                    purchase.warehouse_id = $("#warehouse_id").val();
                    purchase.date = $("#date").val();
                    purchase.bill_no = $("#bill_no").val();
                    purchase.grn_no = $("#grn_no").val();
                    if ($("#account_id").val() == "1") {
                        purchase.purchase_type = "Cash Purchase";
                    } else {
                        purchase.purchase_type = "Credit Purchase";
                    }
                    if ($("#due_date").val() != "") {
                        purchase.due_date = $("#due_date").val();
                        purchase.particulars = $("#particulars").val();
                        purchase.company_id = $('#company_id').val();
                    }

                    var products = [];
                    $.each($("#myData tr"), function(index, row) {
                        var columns = $(row).find("td");
                        var product = new Object();
                        product.product_id = $(columns[0]).find("input").val();
                        // product.tax_id = $(columns[3]).find("select").val().split("_")[0];
                        // product.tax_id = $(columns[9]).text();
                        product.uom_id = $(columns[3]).find("input").val();
                        product.quantity = $(columns[5]).find("input").val();
                        product.unit_cost = $(columns[6]).find("input").val();
                        product.warehouse_id = $(columns[7]).find("select").val();
                        product.total_cost = $(columns[8]).find("input").val();
                        product.company_id = $('#company_id').val();

                        //Code & product only for validation, not insertion
                        //product.code = $(columns[1]).find("input").val();
                        //product.product_name = $(columns[2]).find("input").val();
                        // if($(columns[1]).find("input").val()=="" || $(columns[2]).find("input").val()==""){
                        // 	alert('Fill the Code & Product Correctly First!');
                        //          e.preventdefault();
                        // 	}
                        //validation
                        // if($(columns[3]).find("input").val() =="" || $(columns[4]).find("input").val() =="" | $(columns[5]).find("input").val() =="" || $(columns[6]).find("input").val() ==""){
                        // 	alert('Fill the Fields Correctly First!');
                        //          e.preventdefault();
                        // 	}
                        products.push(product);
                    });
                    var $_token = jQuery('#token').val();
                    
                    //Empty products
                    if(products != ""){
                    jQuery.ajax({
                        url: "{{ asset('purchases') }}",
                        method: "POST",
                        cache: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            purchase: JSON.stringify(purchase),
                            product_data: products
                        },
                        success: function(result) {
                            if (parseInt(result) > 0) {
                                //alert("Purchase successfully saved.");
                                //window.open("/purchases/print/"+result);
                                window.location.href = "{{ asset('purchases/create') }}";
                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            $("#spanWait").hide();
                            alert(xhr.status);
                            alert(thrownError);
                        }
                    });
                }else{
                    // alert("Add your product in Grid");
                    Swal.fire('Add your products in Grid');
                    //  $('#product_name').select2('open');
                    // e.preventdefault();
                }
                    }
            });
        });
    </script>
@stop
