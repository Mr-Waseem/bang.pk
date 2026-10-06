@extends('app')
<head>
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
@section('contents')
    <body>
        <div class="container-fluid">
            @if (Session::has('flash_message'))
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"
                    style="margin-right: 20px;margin-top: 15px;">&times;</button>
                <div class="alert alert-success"> {{ Session::get('flash_message') }} </div>
            @endif
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix" id="panelbg">
                        <h2 class="panel-title"><b>Add Sale</b></h2>
                    </div>
                    <div class="panel-body">
                        <input id="token" type="hidden" value="{{ $encrypted_token }}">
                        @include('errors.validation')
                        {!! Form::open(['url' => 'sales', 'class' => 'form-horizontal']) !!}
                        {!! Form::hidden('company_id', session()->get('company_id'), ['id' => 'company_id']) !!}
                        <div class="row">
                            <div class="form-group" style="margin-left: 1%; margin-right: 1%;">
                                <label class="col-sm-1 control-label">Date</label>
                                <div class="col-sm-2">
                                    <div id="year-view" class="input-group date">
                                        <input id="date" type="date" name="date" value="<?php echo date('Y-m-d'); ?>"
                                            class="form-control" onkeyup="focusNext(event);" autofocus>
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>

                                <label class="col-sm-1 control-label">Bill&nbsp;No</label>
                            <div class="col-sm-2" style="margin-left: -6px;">
                                {!! Form::text('invoice_no1', $codes, [
                                    'id' => 'invoice_no1',
                                    'class' => 'form-control',
                                    'disabled' => 'disabled',
                                ]) !!}
                                {!! Form::hidden('invoice_no', $codes, [
                                    'id' => 'invoice_no',
                                    'class' => 'form-control',
                                    'required' => 'required',
                                    'onkeyup' => 'focusNext(event);',
                                    'autofocus' => 'autofocus',
                                ]) !!}
                            </div>
                                <label class="col-sm-3 control-label" style="display:none;">Bill Type</label>
                                <div class="col-sm-2" style="display:none;">
                                    {!! Form::select('localExport', ['Local' => 'Local', 'Export' => 'Export'], null, [
                                        'id' => 'localExport',
                                        'onkeydown' => 'focusNext(event);',
                                        'class' => 'form-control',
                                    ]) !!}
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
                                <label class="col-sm-3 control-label">Description</label>
                                <div class="col-sm-2">
                                    {!! Form::text('particulars', null, [
                                        'id' => 'particulars',
                                        'placeholder' => 'Description',
                                        'class' => 'form-control',
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="margin-left: 0px; display:none;">
                            
                            <label class="col-sm-3 control-label">Shop Name</label>
                            <div class="col-sm-2">
                                {!! Form::select('warehouse_id', $warehouse, null, ['id' => 'warehouse_id', 'class' => 'form-control']) !!}
                            </div>

                        </div>
                        <div class="form-group" style="display:none;">
                            <label class="col-sm-3 control-label">Biller</label>
                            <div class="col-sm-5">
                                <select name="biller" id="biller" class="form-control" disabled>
                                    <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="display: none;">
                            <div class="form-group" style="margin-left: 1%; margin-right: 1%;">
                                <label class="col-sm-1 control-label">Sale Type</label>
                                <div class="col-sm-2">
                                    {!! Form::select('sale_list', ['Sale Bill' => 'Sale Bill', 'Sample' => 'Sample'], null, [
                                        'id' => 'sale_list',
                                        'onchange' => 'SampleDescription($(this).val());',
                                        'class' => 'form-control livesearch',
                                    ]) !!}
                                </div>
                                <!-- 	<label class="col-sm-3 control-label">Warehouse</label>
                                  <div class="col-sm-2">
                                   {!! Form::select('warehouse_id', $warehouse, null, [
                                       'id' => 'warehouse_id',
                                       'class' => 'form-control livesearch',
                                   ]) !!}
                                  </div> -->

                            </div>
                        </div>
                        <div class="form-group" id="sample_div" style="margin-left: 0%; display:none;">
                            <label class="col-sm-1 control-label">Description</label>
                            <div class="col-sm-2">
                                {!! Form::text('sample_description', null, ['id' => 'sample_description', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group" style="margin-left: 1%; margin-right: 1%;">
                                {!! Form::hidden('party_id', null, ['id' => 'party_id', 'class' => 'form-control']) !!}
                                <label class="col-sm-1 control-label">Account</label>
                                <div class="col-sm-2">
                                    {!! Form::select('party_name', $customers, null, [
                                        'id' => 'party_name',
                                        'onchange' => 'javascript:PartyKeyUp($(this).val());',
                                        'onkeydown' => 'focusNext(event);',
                                        'class' => 'form-control',
                                        'required' => 'required',
                                    ]) !!}
                                </div>
                                <!-- <label class="col-sm-1 control-label">Address</label>  -->
                                <div class="col-sm-3">
                                    {!! Form::text('address', null, [
                                        'id' => 'address',
                                        'class' => 'form-control',
                                        'placeholder' => 'Address',
                                        'disabled' => 'disabled',
                                        'placeholder' => 'Walking Costomer',
                                    ]) !!}
                                </div>
                                <!-- <label class="col-sm-1 control-label">NTN</label>  -->
                                <div class="col-sm-2">
                                    {!! Form::text('city', null, [
                                        'id' => 'city',
                                        'class' => 'form-control',
                                        'placeholder' => 'City',
                                        'disabled' => 'disabled',
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <table id="myTable">
                                        <div class="container-fluid">
                                            <div class="row">
                                                <tr>
                                                    <!-- <div class="col-md-3">
                             <div class="form-group">
                              <label for="H.S" class="control-label">Id</label> -->
                                                    {!! Form::hidden('product_id', null, ['id' => 'product_id', 'class' => 'form-control']) !!}
                                                    <!-- </div>
                            </div>  -->
                                                    <div class="col-md-1" style="margin-left: 1%; margin-right: 1%;">
                                                        <div class="form-group">
                                                            <label for="H.S" class="control-label">Code</label>
                                                            <!-- {!! Form::text('product_code', null, [
                                                                'id' => 'product_code',
                                                                'onkeyup' => 'CodeKeyUp($(this).val());',
                                                                'class' => 'form-control',
                                                            ]) !!} -->
                                                            {!! Form::text('product_code', null, [
                                                                'id' => 'product_code',
                                                                'onkeydown' => 'focusNext(event);',
                                                                'class' => 'form-control',
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2" style="margin-right: 1%;">
                                                        <div class="form-group">
                                                            <label for="Name" class="control-label">Product
                                                                Name</label>
                                                            {!! Form::select('product_name', $products, null, [
                                                                'id' => 'product_name',
                                                                'onchange' => 'ProductKeyUp($(this).val().split("_")[0]);',
                                                                'onkeydown' => 'focusNext(event);',
                                                                'class' => 'form-control',
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1" style="margin-right: 1%; display:none;">
                                                        <div class="form-group">
                                                            <label for="Name" class="control-label">Unit</label>
                                                             {!! Form::text('uom_id', 1, [
                                                                'id' => 'uom_id',
                                                                'class' => 'form-control',
                                                                'onkeydown' => 'focusNext(event);',
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1" style="margin-right: 1%;">
                                                        <div class="form-group">
                                                            <label for="Name" class="control-label">Unit</label>
                                                            {!! Form::text('uom', null, [
                                                                'id' => 'uom',
                                                                'class' => 'form-control',
                                                                'onkeydown' => 'focusNext(event);', 'disabled' => 'disabled'
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1" style="margin-right: 1%;">
                                                        <div class="form-group">
                                                            <label for="password" class="control-label">Cost</label>
                                                            <!-- <input type="checkbox" id="checkbox7" checked="checked"> -->
                                                            {!! Form::text('product_cost', null, [
                                                                'id' => 'product_cost',
                                                                'class' => 'form-control',
                                                                'disabled' => 'disabled',
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1" style="margin-right: 1%;">
                                                        <div class="form-group">
                                                            <label for="password" class="control-label">Quantity</label>
                                                            {!! Form::text('quantity', null, [
                                                                'id' => 'quantity',
                                                                'onkeyup' => 'QuantityKeyUp($(this).val())',
                                                                'onkeypress' => 'return onlyNumberKey(event)',
                                                                'onpaste' => 'return false;',
                                                                'ondrop' => 'return false;',
                                                                'autocomplete' => 'off',
                                                                'class' => 'form-control',
                                                                'onkeydown' => 'focusNext(event);',
                                                                'onfocus'=>'this.value=""'
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1" style="margin-right: 1%;">
                                                        <div class="form-group">
                                                            <label for="password" class="control-label">Cost
                                                                Amount</label>
                                                            {!! Form::text('cost_amount', null, [
                                                                'id' => 'cost_amount',
                                                                'class' => 'form-control',
                                                                'disabled' => 'disabled',
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1" style="margin-right: 1%;">
                                                        <div class="form-group">
                                                            <label for="Name" class="control-label">Discount</label>
                                                            {!! Form::select('discount_id', $discounts, null, [
                                                                'id' => 'discount_id',
                                                                'onchange' => 'DiscountKeyUp($(this).val().split("_").pop(), $(this).val().split("_")[0]);',
                                                                'disabled' => 'disabled',
                                                                'class' => 'form-control',
                                                                'onkeydown' => 'focusNext(event);',
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1" style="margin-right: 1%;">
                                                        <div class="form-group">
                                                            <label for="password" class="control-label">Sale Rate</label>
                                                            {!! Form::text('price_per_unit', null, [
                                                                'id' => 'price_per_unit',
                                                                'onkeyup' => 'SaleRate($(this).val())',
                                                                'class' => 'form-control',
                                                                'onkeydown' => 'focusNext(event);', 'onkeypress' => 'return onlyNumberKey(event)',
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1" style="margin-right: 1%;">
                                                        <div class="form-group">
                                                            <label for="password" class="control-label">Sale
                                                                Amount</label>
                                                            {!! Form::text('balance', null, ['id' => 'balance', 'onkeyup' => 'TotalKeyUp()', 'class' => 'form-control']) !!}
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-success" type="button" onkeyup="AddGridData();" onclick="AddGridData();"
                                                        style="margin-top:2%;">Add</button>
                                                    <!-- <input type="text" class="form-control" Value="Add" id="add" name="add" onkeydown="focusNext(event);" onkeyup="AddGridData();" style="background-color: green; width: 50%; color: white;"> -->

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
                                <!-- <div class="panel panel-default"> -->
                                <div class="panel panel-default">
                                    <div class="panel-heading clearfix">
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">Driver</label>
                                                    <div class="col-sm-2">
                                                        {!! Form::text('driver', null, ['id' => 'driver', 'class' => 'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">Vehicle</label>
                                                    <div class="col-sm-2">
                                                        {!! Form::text('vehicle', null, ['id' => 'vehicle', 'class' => 'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">Freight</label>
                                                    <div class="col-sm-2">
                                                        {!! Form::text('freight', null, ['id' => 'freight', 'class' => 'form-control']) !!}
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">Returnable</label>
                                                    <div class="col-sm-2">
                                                        {!! Form::text('returnable', null, ['id' => 'returnable', 'class' => 'form-control']) !!}
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="row">
                                                <div class="form-group">

                                                    <div class="col-sm-6">
                                                        .
                                                    </div>
                                                </div>
                                                <!-- <div class="form-group">
                                  <label class="col-sm-1 control-label">Description</label>
                                  <div class="col-sm-2">
                                  {!! Form::text('sample_description', null, ['id' => 'sample_description', 'class' => 'form-control']) !!}
                                  </div>
                                 </div> -->
                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">Total Qty</label>
                                                    <div class="col-sm-2">

                                                        <input type="text" id="TotalRate" name="TotalRate"
                                                            value="0" style="color: black;" class="form-control"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-1 control-label">Total Amount</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" id="TotalAmount" name="TotalAmount"
                                                            value="0" style="color: black;" class="form-control"
                                                            disabled>
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
                                <button type="button" class="btn btn-primary" id="btnSave"
                                    name="btnSave">Save</button>
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
    <!-- Select2-->
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <script type="text/javascript">
        function TotalKeyUp() {
            var Total = document.getElementById('balance').value;
            var SaleRate = document.getElementById('price_per_unit').value;
            var Quantity = parseFloat(Total / SaleRate).toFixed(3);
            //alert(Quantity)
            document.getElementById('quantity').value = Quantity;
            // var cost = document.getElementById('product_cost').value;
            // totalCost = (Quantity * cost);
            // document.getElementById('cost_amount').value = totalCost;
        }

        function TotalKeyUpGrid(Total, RowIndex) {
         var SaleRate = $('tr:eq(' + RowIndex + ')', myData).find("td:eq('10')").find('input').val();
          var Quantity = parseFloat(Total / SaleRate).toFixed(3);
         $('tr:eq(' + RowIndex + ')', myData).find("td:eq('6')").find('input').val(Quantity);
        // var cost = document.getElementById('product_cost').value;
        // totalCost = (Quantity * cost);
        // document.getElementById('cost_amount').value = totalCost;
        }

        function QtyChange(qty, RowIndex) {
            var cost = $('tr:eq(' + RowIndex + ')', myData).find("td:eq('5')").find('input').val();
            var totalcost = cost * qty;
            //totalcose
            $('tr:eq(' + RowIndex + ')', myData).find("td:eq('7')").find('input').val(totalcost);

            var rate = $('tr:eq(' + RowIndex + ')', myData).find("td:eq('10')").find('input').val();
            var totalrate = rate * qty;
            $('tr:eq(' + RowIndex + ')', myData).find("td:eq('11')").find('input').val(totalrate);
        }

        function salerate(rate, RowIndex) {
            var qty = $('tr:eq(' + RowIndex + ')', myData).find("td:eq('6')").find('input').val();
            var totalrate = rate * qty;
            $('tr:eq(' + RowIndex + ')', myData).find("td:eq('11')").find('input').val(totalrate);
        }


        $("#party_name").select2();
        $("#party_name").next(".select2").find(".select2-selection").focus(function() {
            $("#party_name").select2("open");
        });


        $("#product_name").select2();
        $("#product_name").next(".select2").find(".select2-selection").focus(function() {
            $("#product_name").select2("open");
        });


        $('#party_name').change(function() {
            $('#party_name').select2().trigger('select2:close');
            $("#product_code").focus();
        });

        function submitForm() {
            $("#productsForm").submit();
        }

        function SaleKeyUp(SaleValue, RowIndex) {
            var quantity = $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('5')").text();
            // alert(quantity)
            var total = SaleValue * quantity;
            $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('8')").text(total);
        }

        // on javascript onclick on product dropdown 
        function ProductKeyUp(productID) {
            $.ajax({
                url: "{{ asset('productkeyup-ajax') }}?prodID=" + productID,
                type: "GET",
                success: function(result) {
                    if (result.length > 0) {
                        $('#product_code').val(result[0].product_code);
                        $('#product_id').val(result[0].id);
                        //$("#product_cost").val(result[0].unit_cost);
                        $("#product_cost").val(result[0].product_cost);
                        $("#price_per_unit").val(result[0].product_price);
                        $("#uom").val(result[0].uom);

                        var price = $("#price_per_unit").val();
                        var quantity = $("#quantity").val();
                        var cost = $("#product_cost").val();
                        var CostAmount = cost * quantity;
                        var SaleAmount = price * quantity;
                        // var totalDiscount = ((discountnew / 100) * quantity * price);
                        var totalDiscount = ((1000 / 100) * quantity * price);
                        document.getElementById('cost_amount').value = CostAmount;
                        document.getElementById('balance').value = SaleAmount;
                        $("#quantity").focus();
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
            var price = document.getElementById('price_per_unit').value;
            var discount = document.getElementById('discount_id').value.split("_").pop();
            var total = quantity * salerate;
            // alert(total)
            var totalDiscount = (discount / 100 * price * quantity);
            document.getElementById('balance').value = total - totalDiscount;
        }

        function QuantityKeyUp(quantity) {
            var price = document.getElementById('price_per_unit').value;
            var cost = document.getElementById('product_cost').value;
            var CostAmount = quantity * cost;
            document.getElementById('cost_amount').value = CostAmount;
            total = (quantity * price);
            document.getElementById('balance').value = total;
        }

        function DiscountKeyUp(discount, discountID) {
            var price = document.getElementById('price_per_unit').value;
            var cost = document.getElementById('product_cost').value;
            var quantity = document.getElementById('quantity').value;
            var CostAmount = quantity * cost;
            var totalDiscount = discount / 100 * price * quantity;
            //alert(totalDiscount)
            document.getElementById('cost_amount').value = CostAmount;
            total = (quantity * price);
            document.getElementById('balance').value = total - totalDiscount;
        }

        function DiscountNew(discount, rowIndex) {
            var quantity = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('3')").find('input').val();
            var discountnew = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('select').val().split("_")
                .pop();
            var price = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('5')").find('input').val();
            // var totalDiscount = ((discountnew / 100) * quantity * price);
            var totalDiscount = ((1000 / 100) * quantity * price);
            var total = quantity * price;
            //document.getElementById('total_costnew').value = totalDiscount;
            $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val(total - totalDiscount);
        }

        function PartyKeyUp(partyId) {
            $.ajax({
                url: "{{ asset('partyonchange-ajax') }}?party_id=" + partyId,
                type: "GET",
                success: function(result) {
                    if (result.length > 0) {
                        $('#party_id').val(result[0].id);
                        $('#address').val(result[0].address);
                        $('#strn').val(result[0].strn);
                        $('#ntn').val(result[0].ntn);
                        $('#city').val(result[0].city);
                    }
                }
            });
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
                    var rate = $(row).find("td:eq('6')").find("input").val(); //qty
                    var amount = $(row).find("td:eq('11')").find("input").val();
                    //alert(rate)
                    //alert(amount)
                    var grandRate = parseInt(TotalRate) - parseInt(rate);
                    var grandAmount = parseInt(TotalAmount) - parseInt(amount);
                    document.getElementById('TotalRate').value = grandRate;
                    document.getElementById('TotalAmount').value = grandAmount;
                    $(row).remove();
                    // alertify.alert("File is Removed!");
                }
            });
        }

        function onlyNumberKey(evt) {
        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
        }

        function AddGridData() {
            
            var date = document.getElementById('date').value;
            var InvoiceNo = document.getElementById('invoice_no').value;
            var ProductId = document.getElementById('product_id').value;
            var ProductCode = document.getElementById('product_code').value;
            var ProductName = document.getElementById('product_name').value.split("_").pop();
            var UOMID = document.getElementById('uom_id').value.split("_")[0];
            // var UOM = document.getElementById('uom_id').value.split("_").pop();
            var UOM = document.getElementById('uom').value;
            var Cost = document.getElementById('product_cost').value;
            var Quantity = document.getElementById('quantity').value;
            //  alert(Quantity)
            var CostAmount = document.getElementById('cost_amount').value;
            var discountID = document.getElementById('discount_id').value.split("_")[0];
            var discount = document.getElementById('discount_id').value.split("_").pop();
            var Price = document.getElementById('price_per_unit').value;
            var Amount = document.getElementById('balance').value;
            ///document.getElementById('TotalRate').value = Price;
            //document.getElementById('TotalAmount').value = Amount;
            //var totalPrice = document.getElementById('Price').value;
            var TotalRate = document.getElementById('TotalRate').value;
            var totalAmount = document.getElementById('TotalAmount').value;

            //var grandPrice = parseInt(Price) + parseInt(totalPrice);
            var grandRate = parseInt(Quantity) + parseInt(TotalRate);
            var grandAmount = parseInt(Amount) + parseInt(totalAmount);
            //document.getElementById('TotalRate').value = grandPrice;
            document.getElementById('TotalRate').value = grandRate;
            document.getElementById('TotalAmount').value = grandAmount;

            if((ProductId) == "" || (ProductId) == 0){
                document.getElementById("product_code").focus();
                Swal.fire('Select Product First!');
                 e.preventdefault();
            }

            if((Quantity) == "" || (Quantity) == 0 || (Quantity) == 'NaN' ){
                document.getElementById("quantity").focus();
                Swal.fire('Quantity Cant be Empty or 0!');
                    e.preventdefault();
            }

            if((Price) == "" || (Price) == 0 || (Price) == 'NaN' ){
                    document.getElementById("price_per_unit").focus();
                // alert('Price Cant be Empty or 0!');
                Swal.fire('Price Cant be Empty or 0!');
                    e.preventdefault();
            }

            var tableHtml = '<tr>';
            //0
            //tableHtml += '<td>'+ ProductId +'</td>';
            tableHtml +=
                `<td style="display:none;"><input id="test" value="${ProductId}" type="text" class="form-control" disabled></td>`;
            //1
            //tableHtml += '<td>'+ ProductCode +'</td>';
            tableHtml +=
                `<td style="padding-top:20px;"><input id="test" value="${ProductCode}" type="text" class="form-control" style="margin-left: 7%; width: 80%;" disabled></td>`;
            //2
            //tableHtml += '<td>'+ ProductName +'</td>';
            tableHtml += `<td style="padding-top:20px;"><input id="test" value="${ProductName}" type="text" class="form-control" style="margin-left: -4%;
    width: 157%;" disabled></td>`;
            //3
            tableHtml += `<td style="display:none;"><input id="test" value="${UOMID}" type="text" class="form-control" style="margin-left: -25%;
    width: 120%;" disabled></td>`;
            //4
            tableHtml += `<td style="padding-top:20px;"><input id="test" value="${UOM}" type="text" class="form-control" style="margin-left: 60%;
    width: 79%;" disabled></td>`;
            //5
            //tableHtml += '<td>'+ Cost +'</td>';
            tableHtml +=
                `<td style="padding-top:20px;"><input id="test" value="${Cost}" type="text" class="form-control" style="margin-left: 48%; width: 78%;" disabled></td>`;
            //6
            //tableHtml += '<td>'+ Quantity +'</td>';
            tableHtml +=
                `<td style="padding-top:20px;"><input id="test" value="${Quantity}" type="text" class="form-control" style="margin-left: 34%; width: 79%;" onkeypress = "return onlyNumberKey(event)",  onkeyup="QtyChange($(this).val(), $(this).closest('tr').index());"></td>`;
            //tableHtml += '<td>'+ CostAmount +'</td>';
            //7
            tableHtml +=
                `<td style="padding-top:20px;"><input id="test" value="${CostAmount}" type="text" class="form-control" style="width:78%; margin-left: 21%;" disabled></td>`;
            //8
            tableHtml +=
                `<td style="display:none;"><input id="test" value="${discountID}" type="text" class="form-control" style="" disabled></td>`;
            //9
            tableHtml += `<td style="padding-top:20px;"><input id="test" value="${discount}%" type="text" class="form-control" style="margin-left: 8%;
    width: 79%;" disabled></td>`;
            //10
            // tableHtml += '<td>'+ Price +'</td>';
            tableHtml +=
                `<td style="padding-top:20px;"><input id="test" value="${Price}" type="text" class="form-control" style="margin-left:-5%; width: 78%;" onkeypress = "return onlyNumberKey(event)", onkeyup="salerate($(this).val(), $(this).closest('tr').index());"></td>`;
            //11
            tableHtml += `<td style="padding-top:20px;"><input id="test" value="${Amount}" type="text" class="form-control" onkeypress = "return onlyNumberKey(event)", onkeyup = "TotalKeyUpGrid($(this).val(), $(this).closest('tr').index());", style="margin-left: -19%;
    width: 78%;"></td>`;
            // document.getElementById('test').value=Price;
            // tableHtml += '<td>'+ Amount +'</td>';
            //12
            tableHtml +=
                '<td style="padding-top: 20px;"><button class="btn btn-red" type="button" style="margin-left: -80%;"> <i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-trash" title="Delete Row"></i></button></td>';
            tableHtml += '</tr></br>';
            $('#myData').append(tableHtml);
            document.getElementById("product_code").focus();
        }

        $("#btnSave").click(function() {
            if ($("#party_id").val() == "") {
                Swal.fire('Select Customer First');
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
                    purchase.date = $("#date").val();

                    if ($("#due_date").val() != "") {
                        purchase.due_date = $("#due_date").val();
                        purchase.particulars = $("#particulars").val();
                        purchase.driver = $("#driver").val();
                        purchase.vehicle = $("#vehicle").val();
                        purchase.freight = $("#freight").val();
                        purchase.returnable = $("#returnable").val();
                    }
                    purchase.party_id = $("#party_id").val();
                    // purchase.sale_type = $("#sale_type").val();
                    if ($("#party_id").val() == "1") {
                        purchase.sale_type = "Cash Sale";
                    } else {
                        purchase.sale_type = "Credit Sale";
                    }
                    purchase.sale_list = $("#sale_list").val();
                    purchase.sample_description = $("#sample_description").val();
                    // purchase.dcn_no = $("#dcn_no").val();
                    purchase.dcn_no = 1;
                    purchase.warehouse_id = $("#warehouse_id").val();
                    purchase.invoice_no = $("#invoice_no").val();
                    purchase.localExport = $("#localExport").val();
                    purchase.biller = $("#biller").val();
                    purchase.company_id = $('#company_id').val();


                    var products = [];
                    $.each($("#myData tr"), function(index, row) {
                        var columns = $(row).find("td");
                        var product = new Object();
                        product.party_id = $("#party_id").val();
                        product.product_id = $(columns[0]).find("input").val();
                        product.uom_id = $(columns[3]).find("input").val();
                        product.product_cost = $(columns[5]).find("input").val();
                        product.quantity = $(columns[6]).find("input").val();
                        product.cost_amount = $(columns[7]).find("input").val();
                        product.discount_id = $(columns[8]).find("input").val();
                        product.sale_rate = $(columns[10]).find("input").val();
                        product.balance = $(columns[11]).find("input").val();
                        //product.balance = $(columns[8]).text();
                        products.push(product);
                    });

                    var $_token = jQuery('#token').val();
                    // console.log(purchase);

                    if(products != ""){
                    jQuery.ajax({
                        url: "{{ asset('sales') }}",
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
                            //if(result == "inserted")
                            if (parseInt(result) > 0) {
                                window.open("{{ asset('sales/print') }}/" + result);
                                window.location.href = "{{ asset('sales/create') }}";
                                //window.open("/sales/print/"+result);
                                //alert("Sale successfully saved.");
                                //Session::flash('flash_message', 'Sale Added Successfully!');
                                //window.location.href = "/sales";

                            }
                        },
                        error: function(xhr, ajaxOptions, thrownError) {
                            $("#spanWait").hide();
                            alert(xhr.status);
                            alert(thrownError);
                        }
                    });
                }else{
                    Swal.fire('Add your products in Grid');
                    
                    e.preventdefault();
                }
               
                }
            });
        });
    </script>
@stop
