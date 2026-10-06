@extends('app')

<head>
<link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
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
                        <h3 class="panel-title">Stock Issue</h3>
                    </div>
                    <div class="panel-body">
                        <input id="token" type="hidden" value="{{ $encrypted_token }}">
                        @include('errors.validation')
                        {!! Form::open(['url' => 'stock-issue', 'class' => 'form-horizontal']) !!}
                        
                        <div class="row">
                            <div class="form-group" style="margin-left: 1%; margin-right: 1%;">
                                <label class="col-sm-1 control-label">Date</label>
                                <div class="col-sm-2">
                                    <div id="year-view" class="input-group date">
                                        <input id="date" type="date" name="date" value="<?php echo date('Y-m-d'); ?>"
                                            class="form-control">
                                    </div>
                                </div>

                                <label class="col-sm-1 control-label" style="display: none;">Purchase&nbsp;Type</label>
                                <div class="col-sm-2" style="display: none;">
                                    <select class="form-control" onchange="LedgerValues();" id="purchase_type"
                                        name="purchase_type">
                                        <option value="Stock Issue">Stock Issue</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="ledgerRow" style="display:none;">
                            <div class="form-group" style="margin-left: 1%; margin-right: 1%;">
                                <label class="col-sm-1 control-label">Due&nbsp;Date</label>
                                <div class="col-sm-2">
                                    <div id="year-view" class="input-group date">
                                        <input id="due_date" type="date" value="<?php echo date('Y-m-d'); ?>" name="due_date"
                                            class="form-control">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>

                                <label class="col-sm-1 control-label"></label>
                                <div class="col-sm-2">
                                    {!! Form::text('particulars', null, [
                                        'id' => 'particulars',
                                        'placeholder' => 'Description',
                                        'class' => 'form-control',
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group" style="margin-left: 1%; margin-right: 1%;">
                                <label class="col-sm-1 control-label">Warehouse</label>
                                <div class="col-sm-2">
                                    {!! Form::select('warehouse_id', $warehouse, null, ['id' => 'warehouse_id', 'class' => 'form-control']) !!}
                                </div>
                                <label class="col-sm-1 control-label">Bill No</label>
                                <div class="col-sm-2">
                                    {!! Form::text('bill_no', $codes, ['id' => 'bill_no', 'class' => 'form-control', 'autofocus' => 'autofocus']) !!}
                                </div>


                            </div>
                        </div>
                        <div class="row" style="display: none;">
                            <div class="form-group" style="margin-left: 1%; margin-right: 1%;">
                                <label class="col-sm-1 control-label">Account ID</label>
                                <div class="col-sm-5" style="height: 40px;">
                                    {!! Form::text('account_id', 1, ['id' => 'account_id', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row" style="display:none;">
                            <div class="form-group" style="margin-left: 1%; margin-right: 1%;">
                                <label class="col-sm-1 control-label">Account</label>
                                <div class="col-sm-5" style="height: 40px;">
                                    {!! Form::select('suppliers_id', $Account, null, [
                                        'id' => 'suppliers_id',
                                        'onchange' => 'GetSupplierID($(this).val());',
                                        'class' => 'form-control',
                                    ]) !!}
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
                                                            <div class="col-md-1"
                                                                style="margin-left: 1%; margin-right: 1%;">
                                                                <div class="form-group">
                                                                    <label for="H.S" class="control-label">Code</label>
                                                                    {!! Form::hidden('product_id', null, ['id' => 'product_id']) !!}
                                                                    {!! Form::text('product_code', null, [
                                                                        'id' => 'product_code',
                                                                        'onkeyup' => 'CodeKeyUp($(this).val());',
                                                                        'class' => 'form-control',
                                                                    ]) !!}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3"
                                                                style="margin-left: 1%; margin-right: 1%;">
                                                                <div class="form-group">
                                                                    <label for="Name" class="control-label">Product
                                                                        Name</label>
                                                                        
                                                                    {!! Form::select('product_name', $products, null, [
                                                                        'id' => 'product_name',
                                                                        'onchange' => 'productMouseUp($(this).val().split("_")[0]);',
                                                                        'class' => 'form-control',
                                                                    ]) !!}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2" style="display:none;">
                                                                <div class="form-group">
                                                                    <label for="Name" class="control-label">Tax
                                                                        Rate</label>
                                                                    {!! Form::select('tax_id', $taxes, null, [
                                                                        'id' => 'tax_id',
                                                                        'onchange' => 'javascript:CalculateTax($(this).val().split("_").pop(), $(this).closest(\'tr\').index())',
                                                                        'class' => 'form-control',
                                                                    ]) !!}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1"
                                                                style="margin-left: 1%; margin-right: 1%; display:none;">
                                                                <div class="form-group">
                                                                    <label for="Name"
                                                                        class="control-label">Unit</label>
                                                                    {!! Form::select('uom_id', $uoms, null, ['id' => 'uom_id', 'class' => 'form-control']) !!}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1"
                                                                style="margin-left: 1%; margin-right: 1%;">
                                                                <div class="form-group">
                                                                    <label for="Name"
                                                                        class="control-label">Unit</label>
                                                                    {!! Form::text('unit', null, ['id' => 'unit', 'class' => 'form-control', 'disabled'=>'disabled']) !!}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1"
                                                                style="margin-left: 1%; margin-right: 1%;">
                                                                <div class="form-group">
                                                                    <label for="password"
                                                                        class="control-label">Quantity</label>
                                                                    {!! Form::text('quantity', null, [
                                                                        'id' => 'quantity',
                                                                        'onkeyup' => 'QuantityKeyUp($(this).val())',
                                                                        'onfocus' => 'this.value=""', 'onkeypress' => 'return onlyNumberKey(event)',
                                                                        'class' => 'form-control',
                                                                    ]) !!}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1"
                                                                style="margin-left: 1%; margin-right: 1%;">
                                                                <div class="form-group">
                                                                    <label for="password" class="control-label">Cost
                                                                        (PKR)</label>
                                                                    {!! Form::text('price', null, [
                                                                        'id' => 'price',
                                                                        'onkeyup' => 'PriceKeyUp($(this).val())',
                                                                        'onkeypress' => 'return onlyNumberKey(event)',
                                                                        'class' => 'form-control',
                                                                    ]) !!}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-1"
                                                                style="margin-left: 1%; margin-right: 1%; display:none;">
                                                                <div class="form-group">
                                                                    <label for="Warehouse"
                                                                        class="control-label">Warehouse</label>
                                                                    {!! Form::select('warehouse_id', $warehouse, null, [
                                                                        'id' => 'warehouse_id',
                                                                        'class' => 'form-control livesearch',
                                                                    ]) !!}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2" style="display:none;">
                                                                <div class="form-group">
                                                                    <label for="password"
                                                                        class="control-label">Total</label>
                                                                    {!! Form::text('total', null, ['id' => 'total', 'class' => 'form-control']) !!}
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="password"
                                                                        class="control-label">Total</label>
                                                                    {!! Form::text('totals', null, ['id' => 'totals', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                                                </div>
                                                            </div>

                                                            <div class="col-md-1" style="margin-left: 1%;">
                                                        <div class="form-group" style="margin-top: 26px;">
                                                            <!-- <label for="password" class="control-label">Add</label> -->
                                                            <button class="btn btn-success" onkeyup = 'AddGridData();', onclick = 'AddGridData();', type="button">+</button>
                                                        </div>
                                                    </div>
                                                        </tr>
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
                                                    <div class="col-lg-5"><button type="button" onclick="TotalRecords()"
                                                            class="btn btn-warning">Total
                                                            Records</button> </div>
                                                    <div class="col-lg-2"> <b style="color: black;">Total Rate</b>
                                                        <input type="text" id="TotalRate" name="TotalRate"
                                                            value="0" style="color: black;" disabled>
                                                    </div>
                                                    <div class="col-lg-3"> <b style="color: black;">Total Amount</b>
                                                        <input type="text" id="TotalAmount" name="TotalAmount"
                                                            value="0" style="color: black;" disabled>
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
                                <button type="submit" class="btn btn-primary" id="btnSave"
                                    name="btnSave">Save</button>
                            </div>
                        </center>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </body>
@stop
@section('scripts')
<script src="{{asset('js/plugins/select2/select2.full.min.js')}}"></script>

    <script type="text/javascript">
        var sum = 0;
        $("#warehouse_id").select2();
        $("#warehouse_id").next(".select2").find(".select2-selection").focus(function() {
            $("#warehouse_id").select2("open");
        });

        $("#suppliers_id").select2();
        $("#suppliers_id").next(".select2").find(".select2-selection").focus(function() {
            $("#suppliers_id").select2("open");
        });

        $("#product_name").select2();
        $("#product_name").next(".select2").find(".select2-selection").focus(function() {
            $("#product_name").select2("open");
        });

        $("#uom_id").select2();
        $("#uom_id").next(".select2").find(".select2-selection").focus(function() {
            $("#uom_id").select2("open");
        });

        $("#purchase_type").select2();
        $("#purchase_type").next(".select2").find(".select2-selection").focus(function() {
            $("#purchase_type").select2("open");
        });

        function TotalRecords() {
            var rowCount = document.getElementById('myData').rows.length;
            alert("Total Number of Records Are: " + rowCount);
        }



        function GetSupplierID(value) {
            document.getElementById('account_id').value = value;
        }

        function QuantityKeyUp(quantity) {
            var price = document.getElementById('price').value;
            var tax = document.getElementById('tax_id').value.split("_").pop();
            var taxvalue = tax / 100 * price * quantity;
            total = (quantity * price) + taxvalue;
            document.getElementById('total').value = total;
            document.getElementById('totals').value = total;
        }

        function PriceKeyUp(price) {
            var quantity = document.getElementById('quantity').value;
            var tax = document.getElementById('tax_id').value.split("_").pop();
            var taxvalue = tax / 100 * price * quantity;
            total = (quantity * price) + taxvalue;
            document.getElementById('total').value = total;
            document.getElementById('totals').value = total;
        }

        function CalculateTax(tax) {

            var quantity = document.getElementById('quantity').value;
            var price = document.getElementById('price').value;
            var taxvalue = tax / 100 * price * quantity;
            total = (quantity * price) + taxvalue;
            document.getElementById('total').value = total;
            document.getElementById('totals').value = total;
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

                    var rate = $(row).find("td:eq('6')").find("input").val();
                    var amount = $(row).find("td:eq('8')").find("input").val();

                    var grandRate = parseInt(TotalRate) - parseInt(rate);
                    var grandAmount = parseInt(TotalAmount) - parseInt(amount);
                    document.getElementById('TotalRate').value = grandRate;
                    document.getElementById('TotalAmount').value = grandAmount;
                    $(row).remove();
                    // alertify.alert("File is Removed!");
                }
            });
        }

        function AddGridData() {

            if ($("#product_id").val() == "") {
                document.getElementById("product_code").focus();
                Swal.fire('Product Cant be Empty!');
                e.preventdefault();
            }
            if ($("#quantity").val() == "") {
                document.getElementById("quantity").focus();
                Swal.fire('Quantity Cant be Empty!');
                e.preventdefault();
            }
            if ($("#price").val() == "") {
                document.getElementById("price").focus();
                Swal.fire('Rate Cant be Empty!');
                e.preventdefault();
            }
            var ProductId = document.getElementById('product_id').value;
            var ProductCode = document.getElementById('product_code').value;
            var ProductName = document.getElementById('product_name').value.split("_").pop();
            var UOMID = document.getElementById('uom_id').value.split("_")[0];
            var UOM = document.getElementById('uom_id').value.split("_").pop();
            var Quantity = document.getElementById('quantity').value;
            var Price = document.getElementById('price').value;
            var warehouse_id = document.getElementById('warehouse_id').value;

            var Total = document.getElementById('total').value;

            var TotalRate = document.getElementById('TotalRate').value;
            var totalAmount = document.getElementById('TotalAmount').value;

            var grandRate = parseInt(Price) + parseInt(TotalRate);
            var grandAmount = parseInt(Total) + parseInt(totalAmount);

            document.getElementById('TotalRate').value = grandRate;
            document.getElementById('TotalAmount').value = grandAmount;

            var tableHtml = '<tr>';
            // tableHtml += '<td class="text-center"><i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-cancel icon-larger red-color" title="Delete Row"></i> </td>';var TotalRate = document.getElementById('TotalRate').value;
            //tableHtml += '<td>'+ ProductId +'</td>';
            tableHtml +=
                `<td style="display:none;">
					<input id="test" value="${ProductId}" type="text" class="form-control" disabled>
					<input id="product_id1" name="product_id1[]" value="${ProductId}" type="hidden">
				</td>`;
            //tableHtml += '<td>'+ ProductCode +'</td>';
            tableHtml +=
                `<td style="padding-top:20px;">
					<input id="test" value="${ProductCode}" type="text" class="form-control" style="margin-left: 7%; width: 53%;" disabled>
					<input id="product_code" name="product_code[]" value="${ProductCode}" type="hidden">
				</td>`;
            //tableHtml += '<td>'+ ProductName +'</td>';
            tableHtml +=
                `<td style="padding-top:20px;">
					<input id="test" value="${ProductName}" type="text" class="form-control" style="margin-left:-27%; width: 160%;" disabled>
					<input id="product_name" name="product_name[]" value="${ProductName}" type="hidden">
				</td>`;
            //tableHtml += '<td>'+ UOMID +'</td>';
            tableHtml +=
                `<td style="display:none;">
					<input id="test" value="${UOMID}" type="text" class="form-control" disabled>
					<input id="uom_id" name="uom_id[]" value="${UOMID}" type="hidden">	
				</td>`;
            //tableHtml += '<td>'+ UOM +'</td>';
            tableHtml +=
                `<td style="padding-top:20px;">
					<input id="test" value="${UOM}" type="text" class="form-control" style="margin-left:46%; width: 54%;" disabled>	
				</td>`;
            //tableHtml += '<td>'+ Quantity +'</td>';
            //5
            tableHtml +=
                `<td style="padding-top:20px;">
					<input id="test" value="${Quantity}" type="text" class="form-control" style="margin-left:13%; width: 54%;" disabled>
					<input id="quantity" name="quantity[]" value="${Quantity}" type="hidden">		
				</td>`;
            //6
            //tableHtml += '<td>'+ Price +'</td>';
            tableHtml +=
                `<td style="padding-top:20px;">
					<input id="test" value="${Price}" type="text" class="form-control" style="margin-left:-21%; width: 56%;" disabled>
					<input id="unit_cost" name="unit_cost[]" value="${Price}" type="hidden">		
				</td>`;
            //7
            tableHtml +=
                `<td style="padding-top:20px; display:none;">
					<input id="test" value="${warehouse_id}" type="text" class="form-control" style="margin-left:-32%; width: 103%;" disabled>
					<input id="warehouse_id" name="warehouse_id" value="${warehouse_id}" type="hidden">	
				</td>`;
            //tableHtml += '<td>'+ Total +'</td>';
            //8
            tableHtml +=
                `<td style="padding-top:20px;">
					<input id="test" value="${Total}" type="text" class="form-control" style="margin-left:-59%; width: 109%;" disabled>
					<input id="total_cost" name="total_cost[]" value="${Total}" type="hidden">		
				</td>`;
            tableHtml +=
                '<td style="padding-top: 20px;"><button class="btn btn-red" type="button" style="margin-left: -210%;"> <i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-trash" title="Delete Row"></i></button></td>';
            tableHtml += '</tr><br>';
            $('#myData').append(tableHtml);
            document.getElementById("product_code").focus();
        }



        function productMouseUp(productID, rowIndex) {
            $('#product_name').select2().trigger('select2:close');
             $("#quantity").focus();
            $.ajax({
                type: "GET",
                url: "{{ asset('productmouseup-ajax') }}?product_ID=" + productID,
                success: function(result) {
                    if (result.length > 0) {
                        $('#product_code').val(result[0].product_code);
                        $('#unit').val(result[0].uom);
                        $('#product_id').val(result[0].id);
                        $('#price').val(result[0].product_cost);
                        var price = $("#price").val();
                        var quantity = $("#quantity").val();
                        var total = price * quantity;
                        document.getElementById('total').value = total;
                        document.getElementById('totals').value = total;
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }
    </script>
@stop
