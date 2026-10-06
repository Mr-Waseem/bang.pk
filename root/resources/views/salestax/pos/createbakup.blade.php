@extends("app")

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{Asset('css/select2.min.css')}}" rel="stylesheet" />
</head>
@section('contents')
    <body>
        <div class="container-fluid">
            @if (Session::has('flash_message'))
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"
                    style="margin-right: 20px;margin-top: 15px;">&times;</button>
                <div class="alert alert-success"> {{ Session::get('flash_message') }} </div>
            @endif
            @if (Session::has('error_message'))
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"
                    style="margin-right: 20px;margin-top: 15px;">&times;</button>
                <div class="alert alert-danger"> {{ Session::get('error_message') }} </div>
            @endif
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix" id="panelbg">
                        <h2 class="panel-title"><b>Sales Tax Invoice</b></h2>
                    </div>
                    <div class="panel-body">
                        <input id="token" type="hidden" value="{{ $encrypted_token }}">
                        @include('errors.validation')
                        {!! Form::open(['url' => 'salestax', 'class' => 'form-horizontal']) !!}
                        <div class="row">
                            <div class="form-group" style="margin-left: 1%; margin-right: 1%;">
                                <label class="col-sm-1 control-label">Date</label>
                                <div class="col-sm-2">
                                    <div id="year-view" class="input-group date">
                                        <input id="date" type="date" name="date" class="form-control"
                                            value="<?php echo date('Y-m-d'); ?>" autofocus>
                                    </div>
                                </div>
                                <label class="col-sm-1 control-label">Invoice&nbsp;No#</label>
                                <div class="col-sm-2">
                                    <div id="year-view" class="input-group date">
                                        {!! Form::text('invoice_no1', $codes, ['id' => 'invoice_no1', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                        {!! Form::hidden('invoice_no', $codes, ['id' => 'invoice_no', 'class' => 'form-control']) !!}
                                        {!! Form::hidden('company_id', $codes, ['id' => 'company_id', 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <label class="col-sm-1 control-label" style="display:none;">Sale&nbsp;Type</label>
                                <div class="col-sm-2">
                                    <select style="display:none;" class="form-control" onchange="LedgerValues();" id="sale_type"
                                        name="sale_type">
                                        <option style="display:none;" value="SalesTax Invoice">SalesTax Invoice</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="ledgerRow" style="display:none;">
                            <div class="form-group">
                             
                                <label class="col-sm-3 control-label">Due&nbsp;Date</label>
                                <div class="col-sm-2">
                                    <div id="year-view" class="input-group date">
                                        <input id="due_date" type="date" name="due_date" class="form-control">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                
                                <label class="col-sm-1 control-label"></label>
                                <div class="col-sm-2">
                                    {!! Form::text('particulars', null, ['id' => 'particulars', 'placeholder' => 'Description', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group" style="margin-left: 1%; margin-right: 1%;">
                               
                                <label style="display:none;" class="col-sm-1 control-label">OutWard&nbsp;No</label>
                                <div class="col-sm-2" style="display:none;">
                                    <!-- {!! Form::select('dcns_no', $DeliveryChallan, null, ['id' => 'dcns_no', 'onchange' => 'DCMouseUp($(this).val());', 'class' => 'form-control livesearch', 'disabled' => 'disabled']) !!} -->
                                    {!! Form::text('dcn_no', null, ['id' => 'dcn_no', 'class' => 'form-control']) !!}
                                </div>
                                <label  style="display:none;" class="col-sm-1 control-label" >P&nbsp;Order</label>
                                <div class="col-sm-2"  style="display:none;" >
                                    <div id="year-view" class="input-group date">
                                        {!! Form::text('p_order', null, ['id' => 'p_order', 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="display:none;">
                            <div class="form-group" style="margin-left: 1%; margin-right: 1%;"> <label
                                    class="col-sm-1 control-label" >Remarks</label>
                                <div class="col-sm-2">
                                    <div id="year-view" class="input-group date">
                                        {!! Form::text('remarks', null, ['id' => 'remarks', 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <label
                                    class="col-sm-1 control-label">Todays Rate</label>
                                <div class="col-sm-2">
                                    <div id="year-view" class="input-group date">
                                        {!! Form::text('todayRate', 2200, ['id' => 'todayRate', 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <label class="radio-inline"><input type="checkbox" name="lessCommercial"
                                        id="lessCommercial" value="yes" checked>Less&nbsp;Commercial</label>
                                <label class="radio-inline"><input type="radio" name="FurtherTax" id="FurtherTax"
                                        value="yess" onclick="FurtherTaxes()">Further&nbsp;Tax</label>

                            </div>
                        </div>
                        <div class="row" style="display:none;">
                            <div class="form-group" style="margin-left: 1%; margin-right: 1%;">
                                <label class="col-sm-1 control-label">Biller</label>
                                <div class="col-sm-5">
                                    <select name="biller" id="biller" class="form-control">
                                        <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group" style="margin-left: 1%; margin-right: 1%;">
                                <label class="col-sm-1 control-label">Select&nbsp;Party</label>
                                {!! Form::hidden('party_id', 1, ['id' => 'party_id', 'class' => 'form-control']) !!}
                                <div class="col-sm-2">
                                    <div id="year-view" class="input-group date">
                                        {!! Form::select('party_name', $customers, null, ['id' => 'party_name', 'onchange' => 'javascript:PartyKeyUp($(this).val());', 'class' => 'form-control', 'required' => 'required']) !!}

                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    {!! Form::text('address', null, ['id' => 'address', 'class' => 'form-control', 'placeholder' => 'Address', 'disabled' => 'disabled']) !!}
                                </div>
                                <div class="col-sm-2">
                                    {!! Form::text('ntn', null, ['id' => 'ntn', 'class' => 'form-control', 'placeholder' => 'NTN', 'disabled' => 'disabled']) !!}
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
                                                    {!! Form::hidden('product_id', null, ['id' => 'product_id', 'class' => 'form-control']) !!}
                                                    <div class="col-md-1">
                                                        <div class="form-group"
                                                            style="margin-left: 1%; margin-right: 1%;">
                                                            <label for="H.S" class="control-label">H.S Code</label>
                                                            {!! Form::text('product_code', null, ['id' => 'product_code', 'class' => 'form-control']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group"
                                                            style="margin-left: 1%; margin-right: 1%;">
                                                            <label for="Name" class="control-label">Select Product</label>
                                                            {!! Form::select('product_name', $products, null, ['id' => 'product_name', 'onchange' => 'ProductKeyUp($(this).val())', 'class' => 'form-control']) !!}
                                                             {{-- {!! Form::select('product_name', $products, null, ['id' => 'product_name', 'onchange' => 'ProductKeyUp($(this).val().split("_").pop(), $(this).val().split("_")[0]);', 'class' => 'form-control']) !!}  --}}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group"
                                                            style="margin-left: 1%; margin-right: 1%;">
                                                            <label for="Name" class="control-label">Unit</label>
                                                            {!! Form::select('uom_id', $uoms, null, ['id' => 'uom_id', 'class' => 'form-control']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group"
                                                            style="margin-right: 1%;margin-left: 1%;">
                                                            <label for="password" class="control-label">Quantity</label>
                                                            {!! Form::text('quantity', 1, ['id' => 'quantity', 'onkeyup' => 'QuantityKeyUp($(this).val())', 'class' => 'form-control']) !!}
                                                        </div>
                                                    </div>

                                                    <div class="col-md-1">
                                                        <div class="form-group"
                                                            style="margin-right: 1%;width: 100%;margin-left: 1%;">
                                                            <label for="password" class="control-label">Price</label>
                                                            {!! Form::text('price_per_unit', null, ['id' => 'price_per_unit', 'onkeyup' => 'SaleRateKeyUpForm($(this).val())', 'class' => 'form-control']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group"
                                                            style="margin-right: 1%;width: 100%;margin-left: 1%;">
                                                            <label for="password" class="control-label">S.T%</label>
                                                            {!! Form::text('stvalue', null, ['id' => 'stvalue', 'class' => 'form-control']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group"
                                                            style="margin-right: 1%;width: 100%;margin-left: 1%;">
                                                            <label for="password" class="control-label">Tax Value</label>
                                                            {!! Form::text('taxvalue', null, ['id' => 'taxvalue', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group"
                                                            style="margin-right: 1px; margin-left: 1px;">
                                                            <label for="password" class="control-label">Extra%</label>
                                                            {!! Form::text('extratax', null, ['id' => 'extratax', 'onkeyup' => 'ExtraTaxkeyup($(this).val());', 'class' => 'form-control']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group"
                                                            style="margin-right: 1px; margin-left: 1px;">
                                                            <label for="password" class="control-label">ExtraVal</label>
                                                            {!! Form::text('extraTaxValue', null, ['id' => 'extraTaxValue', 'onkeyup' => 'AddGridData()', 'class' => 'form-control']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group"
                                                            style="margin-right: 1px; margin-left: 1px;">
                                                            <label for="password" class="control-label">Val ExTax</label>
                                                            {!! Form::text('ValueExTax', null, ['id' => 'ValueExTax', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <div class="form-group"
                                                            style="margin-right: 1px; margin-left: 1px;">
                                                            <label for="password" class="control-label">IncTax</label>
                                                            {!! Form::text('amount', null, ['id' => 'amount', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                                        </div>
                                                    </div>
                                                </tr>
                                                <div id="myData">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <tr>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                        </div>
                                                    </div>
                                                </tr>
                                            </div>
                                        </div>
                                    </table><br><br>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading clearfix">

                                        <div class="container">

                                            <div class="col-xs-2" style="display:none;"><label class="radio-inline" style=""><input
                                                        type="checkbox" name="autocash" id="autocash"
                                                        value="yes">Auto&nbsp;Cash</label> </div>
                                            <div class="col-xs-2" style=""><b>Total Price</b> <input type="text"
                                                    value="0" id="TotalRate" name="TotalRate" disabled> </div>
                                            <div class="col-xs-2" style=""><b>Total Tax</b> <input type="text"
                                                    value="0" id="TotalTax" name="TotalTax" disabled> </div>
                                            <div class="col-xs-2" style=""> <b>Value Ex.Tax</b> <input type="text"
                                                    value="0" id="TotalExTax" name="TotalExTax" disabled> </div>
                                            <div class="col-xs-2"> <b>Value Inc.Tax</b> <input type="text" value="0"
                                                    id="TotalAmount" name="TotalAmount" disabled> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <center>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary" id="btnSave" name="btnSave">Save</button>
                            </div>
                        </center>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection
@section('scripts')
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css"
        type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    <script src="{{ asset('js/plugins/nouislider/nouislider.min.js') }}"></script>
    <!-- Input Mask-->
    <script src="{{ asset('js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>
    <!-- Select2-->
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <!--Bootstrap ColorPicker-->
    <script src="{{ asset('js/plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <!--Bootstrap DatePicker-->
    <script src="{{ asset('js/plugins/datepicker/bootstrap-datepicker.js') }}"></script>

    <!---------------------date picker---------------------------------->
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet"
        type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $("#date").datepicker({
                dateFormat: "dd/mm/yy"
            }).val();
        });

        $("#party_name").select2();
        $("#party_name").next(".select2").find(".select2-selection").focus(function() {
            $("#party_name").select2("open");
        });

        $("#product_name").select2();
        $("#product_name").next(".select2").find(".select2-selection").focus(function() {
            $("#product_name").select2("open");
        });

        $("#uom_id").select2();
        $("#uom_id").next(".select2").find(".select2-selection").focus(function() {
            $("#uom_id").select2("open");
        });

        function FurtherTaxes() {
            var checkbox = document.getElementById('FurtherTax');
            if (checkbox.checked = true) {
                document.getElementById('extratax').value = 3;
            }
        }

        function AddGridData() {
            var date = document.getElementById('date').value;
            var InvoiceNo = document.getElementById('invoice_no').value;
            var ProductId = document.getElementById('product_id').value;
            var ProductCode = document.getElementById('product_code').value;
            var ProductID = document.getElementById('product_name').value.split("_")[0];
            var ProductName = document.getElementById('product_name').value.split("_")[2];
            // var ProductName = document.getElementById('product_name').value.split("_").pop();
            var UOM = document.getElementById('uom_id').value.split("_").pop();
            var UOMID = document.getElementById('uom_id').value.split("_")[0];
            var Quantity = document.getElementById('quantity').value;
            var Price = document.getElementById('price_per_unit').value;
            var STValue = document.getElementById('stvalue').value;
            var TaxValue = document.getElementById('taxvalue').value;
            var ExtraTax = document.getElementById('extratax').value;
            var ExtraTaxValue = document.getElementById('extraTaxValue').value;
            var ValueExTax = document.getElementById('ValueExTax').value;
            var Amount = document.getElementById('amount').value;
            var TotalTax = parseInt(TaxValue) + parseInt(ExtraTaxValue);

            var TotalRate = document.getElementById('TotalRate').value;
            var TotalTax = document.getElementById('TotalTax').value;
            var TotalExTax = document.getElementById('TotalExTax').value;
            var TotalAmount = document.getElementById('TotalAmount').value;

            var totalPrice = parseInt(TotalRate) + parseInt(Price);
            var TotalTaxAmount = parseInt(TotalTax) + parseInt(TaxValue);
            var TotalExTaxAmount = parseInt(TotalExTax) + parseInt(ValueExTax);
            var TotalincTaxAmount = parseInt(TotalAmount) + parseInt(Amount);

            document.getElementById('TotalRate').value = totalPrice;
            document.getElementById('TotalTax').value = TotalTaxAmount;
            document.getElementById('TotalExTax').value = TotalExTaxAmount;
            document.getElementById('TotalAmount').value = TotalincTaxAmount;

            var tableHtml = '<tr onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));">';
            // tableHtml += '<td class="text-center"><i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-cancel icon-larger red-color" title="Delete Row"></i> </td>';
            //tableHtml += '<td>'+ ProductId +'</td>';
            //0
            tableHtml +=
                `<td style="display:none;">
                    <input id="test" value="${ProductId}" type="text" class="form-control" disabled>
                    <input id="product_id1" name="product_id1[]" value="${ProductId}" type="hidden">
                </td>`;
            //tableHtml += '<td>'+ ProductCode +'</td>';
            //1
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="test" value="${ProductCode}" type="text" class="form-control" style="margin-left: 14%; width: 65%;" disabled>
                    <input id="product_code" name="product_code[]" value="${ProductCode}" type="hidden">
                </td>`;
            //tableHtml += '<td>'+ ProductName +'</td>';
            //2
            tableHtml +=
                `<td style="display:none;">
                    <input id="test" value="${ProductID}" type="text" class="form-control" disabled>
                </td>`;
            //3
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="test" value="${ProductName}" type="text" class="form-control" style="margin-left: 7%; width: 153%;" disabled>
                    <input id="product_name" value="${ProductName}" name="product_name[]" type="hidden" >
                </td>`;
            //tableHtml += '<td>'+ PackingType +'</td>';
            //tableHtml += '<td>'+ UOM +'</td>';
            //4
            tableHtml +=
                `<td style="display:none;">
                    <input id="test" value="${UOMID}" type="text" class="form-control" disabled>
                    <input id="uom_id" name="uom_id[]" value="${UOMID}" type="hidden">
                </td>`;
            //5
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="test" value="${UOM}" type="text" class="form-control" style="margin-left: 88%; width: 65%;" disabled>
                </td>`;
            //tableHtml += '<td>'+ Quantity +'</td>';
            //6
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="test" value="${Quantity}" type="text" class="form-control" style="margin-left: 80%;width: 65%;" disabled>
                    <input id="quantity" name="quantity[]" value="${Quantity}" type="hidden">
                </td>`;
            //tableHtml += '<td>'+ Price +'</td>';
            //7
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="test" value="${Price}" type="text" class="form-control" style="margin-left:72%; width: 65%;" disabled>
                    <input id="rate" name="rate[]" value="${Price}" type="hidden">
                </td>`;
            //tableHtml += '<td>'+ STValue +'</td>';
            //8
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="test" value="${STValue}" type="text" class="form-control" style="margin-left:64%; width: 65%;" disabled>
                    <input id="stvalue" name="stvalue[]" value="${STValue}" type="hidden">
                </td>`;
            //tableHtml += '<td>'+ TaxValue +'</td>';
            //9
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="test" value="${TaxValue}" type="text" class="form-control" style="margin-left:56%; width: 65%;" disabled>
                    <input id="taxvalue" name="taxvalue[]" value="${TaxValue}" type="hidden">
                </td>`;
            //tableHtml += '<td>'+ ExtraTax +'</td>';
            //10
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="test" value="${ExtraTax}" type="text" class="form-control" style="margin-left:47%; width: 65%;" disabled>
                    <input id="extratax" name="extratax[]" value="${ExtraTax}" type="hidden">
                </td>`;
            //tableHtml += '<td>'+ ExtraTaxValue +'</td>';
            //11
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="test" value="${ExtraTaxValue}" type="text" class="form-control" style="margin-left:39%; width: 65%;" disabled>
                    <input id="extraTaxValue" name="extraTaxValue[]" value="${ExtraTaxValue}" type="hidden">
                </td>`;
            //12
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="test" value="${ValueExTax}" type="text" class="form-control" style="margin-left:29%; width: 65%;" disabled>
                    <input id="excvalue" name="excvalue[]" value="${ValueExTax}" type="hidden">
                </td>`;
            //tableHtml += '<td>'+ Amount +'</td>';
            //13
            tableHtml +=
                `<td style="padding-top:20px;">
                    <input id="test" value="${Amount}" type="text" class="form-control" style="margin-left:21%; width: 65%;" disabled>
                    <input id="incvalue" name="incvalue[]" value="${Amount}" type="hidden">    
                </td>`;
            //14
            tableHtml +=
                `<td style="display:none;">
                    <input id="test" value="${TotalTax}" type="text" class="form-control" style="margin-left:21%; width: 65%;" disabled>
                    <input id="TotalTax" name="TotalTax[]" value="${TotalTax}" type="hidden">      
                </td>`;
            tableHtml += '</tr>';
            $('#myData').append(tableHtml);
            document.getElementById("product_code").focus();
        }

        function LedgerValues() {
            $value = $("#sale_type").val();
            if ($value == "Cash Sale") {
                $('#ledgerRow').hide();
            }
            if ($value == "Credit Sale") {
                $('#ledgerRow').show();
            }
        }

        function TotalRecords() {
            var rowCount = document.getElementById('myTable').rows.length;
            alert("Total Number of Records Are: " + rowCount);
        }

        function DCMouseUp(value) {
            $.ajax({
                type: "GET",
                url: "{{ asset('dcmouseup-ajax') }}?dc_no=" + value,
                success: function(data) {
                    if (data.length > 0) {

                        var partyID = data[0].party_id;
                        var partyName = data[0].party_name;
                        var partyAddress = data[0].address;
                        var partyNTN = data[0].ntn;
                        document.getElementById("party_id").value = partyID;
                        document.getElementById("party_name").value = partyName;
                        document.getElementById("address").value = partyAddress;
                        document.getElementById("ntn").value = partyNTN;

                        $.each(data, function(key, value) {
                            var newRow =
                                '<tr>' +
                                '<td style="display:none;"><input id="test" value="${ProductId}" type="text" class="form-control" disabled></td>' +
                                '<td style="padding-top:20px;"><input id="test" value="${ProductCode}" type="text" class="form-control" style="margin-left: 14%; width: 65%;" disabled></td>' +

                                '<td style="padding-top:20px;"><input id="test" value="${ProductName}" type="text" class="form-control" style="margin-left: 7%; width: 153%;" disabled></td>' +
                                '<td style="display:none;"><input id="test" value="${UOMID}" type="text" class="form-control" disabled></td>' +
                                '<td style="padding-top:20px;"><input id="test" value="${UOM}" type="text" class="form-control" style="margin-left: 88%; width: 65%;" disabled></td>' +
                                '<td style="padding-top:20px;"><input id="test" value="${Quantity}" type="text" class="form-control" style="    margin-left: 80%;width: 65%;" disabled></td>' +
                                '<td style="padding-top:20px;"><input id="test" value="${Price}" type="text" class="form-control" style="margin-left:72%; width: 65%;" disabled></td>' +
                                '<td style="padding-top:20px;"><input id="test" value="${STValue}" type="text" class="form-control" style="margin-left:64%; width: 65%;" disabled></td>' +
                                '<td style="padding-top:20px;"><input id="test" value="${TaxValue}" type="text" class="form-control" style="margin-left:56%; width: 65%;" disabled></td>' +

                                '<td style="padding-top:20px;"><input id="test" value="${ExtraTax}" type="text" class="form-control" style="margin-left:47%; width: 65%;" disabled></td>' +
                                '<td style="padding-top:20px;"><input id="test" value="${ExtraTaxValue}" type="text" class="form-control" style="margin-left:39%; width: 65%;" disabled></td>' +
                                '<td style="padding-top:20px;"><input id="test" value="${ValueExTax}" type="text" class="form-control" style="margin-left:29%; width: 65%;" disabled></td>' +
                                '<td style="padding-top:20px;"><input id="test" value="${Amount}" type="text" class="form-control" style="margin-left:21%; width: 65%;" disabled></td>' +
                                '<td style="display:none;"><input id="test" value="${TotalTax}" type="text" class="form-control" style="margin-left:21%; width: 65%;" disabled></td>' +
                                '</tr>';
                            $('#myData').append(newRow);

                        });
                    }
                }
            })
        }

        function SaleRateKeyUp(SaleRate, RowIndex) {

            var quantity = $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('6')").text();
            var tax = $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('9')").val();
        }

        function QuantityKeyUp(quantity) {
            var tax = document.getElementById('stvalue').value;
            var extratax = document.getElementById('extratax').value;
            var price = document.getElementById('price_per_unit').value;
            var totaltax = (price / 100 * tax) * quantity;
            var extratax = (price / 100 * extratax) * quantity;
            document.getElementById('taxvalue').value = totaltax;
            document.getElementById('extraTaxValue').value = extratax;
            var valueWithoutTax = quantity * price;
            document.getElementById('ValueExTax').value = valueWithoutTax;
            total = (quantity * price) + totaltax + extratax;
            document.getElementById('amount').value = total;
        }

        function SaleRateKeyUpForm(price) {
            var quantity = document.getElementById('quantity').value;
            var stvalue = document.getElementById('stvalue').value;
            //tax value
            var tax = (stvalue / 100 * price) * quantity;
            document.getElementById('taxvalue').value = tax;

            //extra tax value
            var extrataxvalue = document.getElementById('extratax').value;
            var extratax = (extrataxvalue / 100 * price) * quantity;
            document.getElementById('extraTaxValue').value = extratax;

            var total = quantity * price;
            var totalValue = total + tax + extratax;
            document.getElementById('ValueExTax').value = total;
            document.getElementById('amount').value = totalValue;
        }

        function ExtraTaxkeyup(taxvalue) {

            var quantity = document.getElementById('quantity').value;
            var price = document.getElementById('price_per_unit').value;
            var stvalue = document.getElementById('stvalue').value;
            var tax = (stvalue / 100 * price) * quantity;
            var extratax = (taxvalue / 100 * price) * quantity;

            document.getElementById('extraTaxValue').value = extratax;
            var total = quantity * price;
            var totalValue = total + tax + extratax;
            document.getElementById('ValueExTax').value = total;
            document.getElementById('amount').value = totalValue;

        }

        function TaxValueKeyUp(TaxValue, RowIndex) {
            var quantity = $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('6')").text();
            var price = $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('8')").find('input').val();
            var ExtraTax = $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('11')").find('input').val();

            var TotalTax = parseInt(TaxValue / 100 * price * quantity);
            var TotalExtraTax = parseInt(ExtraTax / 100 * price * quantity);
            var TotalValue = price * quantity;
            var InclusiveValue = TotalTax + TotalValue;
            $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('10')").text(TotalTax);
            $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('12')").text(TotalExtraTax);
            $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('13')").text(InclusiveValue);

        }

        // on javascript onclick on product dropdown 
        function CodeKeyUp(codeValue) {
            $.ajax({
                type: "GET",
                url: "{{ asset('saletab-ajax') }}?code=" + codeValue,
                success: function(result) {
                    if (result.length > 0) {
                        $('#product_name').val(result[0].product_name);
                        $('#product_id').val(result[0].id);
                        $("#packing_type").val(result[0].catagory_name);
                        $("#price_per_unit").val(result[0].price_per_unit);
                        $("#uom").val(result[0].uom);
                        $("#stvalue").val(result[0].stvalue);

                        var price = $("#price_per_unit").val();
                        var quantity = $("#quantity").val();
                        var stvalue = $("#stvalue").val();
                        var tax = parseInt((stvalue / 100 * price) * quantity);

                        document.getElementById('taxvalue').value = tax;
                        valueWithoutTax = quantity * price;
                        document.getElementById('value').value = valueWithoutTax;
                        var total = price * quantity;
                        var grand = tax + total;
                        document.getElementById('amount').value = grand;
                        document.getElementById('grand_total').value = grand;
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }

        function ProductKeyUp(product) {
            // alert(product)
            var productID = document.getElementById('product_name').value.split("_")[0];
            var productCode = document.getElementById('product_name').value.split("_")[1];
            var productName = document.getElementById('product_name').value.split("_")[2];
            var productTax = document.getElementById('product_name').value.split("_")[3];
            var productprice = document.getElementById('product_name').value.split("_")[4];
            // var productTax = document.getElementById('product_name').value.split("_").pop();
            // alert(productID)
            // alert(productCode)
            // alert(productName)
            // alert(productTax)
            var TodayRate = document.getElementById('todayRate').value;
            //alert(TodayRate)
            var totalRate = TodayRate*productName;

            document.getElementById('product_id').value = productID;
            document.getElementById('product_code').value = productCode;
            document.getElementById('price_per_unit').value = productprice;
            document.getElementById('stvalue').value = productTax;
        }

        // on javascript onclick on product dropdown 
        function ProductKeyUps(ProductName, ProductID) {
            $.ajax({
                type: "GET",
                url: "{{ asset('taxproductkeyup-ajax') }}?product_ID=" + ProductID,
                success: function(result) {
                    if (result.length > 0) {
                        $('#product_code').val(result[0].product_code);
                        $('#product_id').val(result[0].id);
                        $("#packing_type").val(result[0].catagory_name);
                        $("#price_per_unit").val(result.product_price);
                        $("#uom").val(result[0].uom);
                        $("#stvalue").val(result[0].tax);


                        var price = $("#price_per_unit").val();
                        var quantity = $("#quantity").val();
                        var stvalue = $("#stvalue").val();
                        var extratax = $("#extratax").val();
                        var tax = parseInt((stvalue / 100 * price) * quantity);
                        var extratax = parseInt((extratax / 100 * price) * quantity);
                        document.getElementById('taxvalue').value = tax;
                        document.getElementById('extraTaxValue').value = extratax;
                        var total = price * quantity;
                        var grand = tax + extratax + total;
                        document.getElementById('value').value = total;
                        document.getElementById('amount').value = grand;
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }

        function PartyKeyUp(partyID) {
            $.ajax({
                type: "GET",
                url: "{{ asset('taxpartyonchange-ajax') }}?party_ID=" + partyID,
                success: function(result) {
                    if (result.length > 0) {
                        $('#party_id').val(result[0].id);
                        $('#address').val(result[0].address);
                        $('#strn').val(result[0].strn);
                        $('#ntn').val(result[0].ntn);
                    }
                }
            })
        }

        //on product Mouse up 
        function productMouseUp(productName, rowIndex) {
            $.ajax({
                type: "GET",
                url: "{{ asset('productonchange-ajax') }}?product_name=" + productName,
                success: function(result) {
                    if (result.length > 0) {
                        $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('0')").find('input').val(result[0]
                            .id);
                        $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('1')").find('input').val(result[0]
                            .product_code);
                        $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('3')").find('input').val(result[0]
                            .remaining_quantity);
                        $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('5')").find('input').val(result[0]
                            .unit_cost);

                        var salePrice = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input')
                            .val();

                        var discount = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('select')
                            .val().split("_").pop();
                        var quantity = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('3')").find('input')
                            .val();
                        var price = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input')
                            .val();
                        var grand = (price * quantity) - (((discount / 100)) * price * quantity);
                        $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('7')").find('input').val(grand);

                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }

        function salepriceMouseUp(salePrice, rowIndex) {
            var quantity = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('3')").find('input').val();
            var saleprice = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val();
            var grand = quantity * saleprice;
            $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('7')").find('input').val(grand);
        }

        $("#product_codess").keyup(function() {
            if ($("#product_code").val() != "0") {
                $.ajax({
                    type: "GET",
                    url: "{{ asset('getfirstProduct-ajax') }}?saletab_id=" + $("#product_code").val(),
                    success: function(result) {
                        if (result.length > 0) {
                            $("#product_id").val(result[0].id);
                            $("#product_name").val(result[0].product_english);
                            $("#unit_cost").val(result[0].product_price);

                            var quantity = document.getElementById('quantity').value;
                            var cost = document.getElementById('unit_cost').value;
                            var discount = document.getElementById('discount_id').value.split("_")
                                .pop();
                            //var tax = document.getElementById('tax_id').value.split("_").pop();
                            var totalDiscount = ((discount / 100) * quantity * cost);
                            var total = quantity * cost;
                            document.getElementById('total_cost').value = total - totalDiscount;
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });
            }
        });

        function myDeleteFunction(row) {
            alertify.confirm("Are you sure you want to delete this row?", function(e) {
                if (e) {
                    var TotalRate = document.getElementById('TotalRate').value;
                    var rate = $(row).find("td:eq('7')").find("input").val();
                    var grandRate = parseInt(TotalRate) - parseInt(rate);
                    document.getElementById('TotalRate').value = grandRate;

                    var TotalTax = document.getElementById('TotalTax').value;
                    var tax = $(row).find("td:eq('9')").find("input").val();
                    var grandTax = parseInt(TotalTax) - parseInt(tax);
                    document.getElementById('TotalTax').value = grandTax;

                    var TotalExTax = document.getElementById('TotalExTax').value;
                    var Extax = $(row).find("td:eq('12')").find("input").val();
                    var grandExTax = parseInt(TotalExTax) - parseInt(Extax);
                    document.getElementById('TotalExTax').value = grandExTax;

                    var TotalAmount = document.getElementById('TotalAmount').value;
                    var Inctax = $(row).find("td:eq('13')").find("input").val();
                    var grandIncTax = parseInt(TotalAmount) - parseInt(Inctax);
                    document.getElementById('TotalAmount').value = grandIncTax;

                    $(row).remove();
                } else {
                    alertify.alert("Row Deleting Cancelled!");
                }
            });
        }

        function DiscountNew(discount, rowIndex) {
            var quantity = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('3')").find('input').val();
            var discountnew = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('select').val().split("_")
                .pop();
            var price = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('5')").find('input').val();
            var totalDiscount = ((discountnew / 100) * quantity * price);
            var total = quantity * price;
            $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val(total - totalDiscount);
        }

        // on javascript onclick on product dropdown
        function quantityMouseUp(quantity, rowIndex) {
            var code = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('1')").find('input').val();
            var remainingquantity = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('8')").find('input').val();
            if (quantity > remainingquantity) {
                alert("Invalid! Your Remaining Stock is: " + quantity);
                e.preventdefault();
            }
            var price = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val();
            var discount = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('select').val().split("_").pop();

            var totalDiscount = ((discount / 100) * quantity * price);
            var total = quantity * price;
            $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('7')").find('input').val(total - totalDiscount);
        }

        // $("#btnSave").click(function() {
        //     if ($("#party_id").val() == "") {
        //         alert('Select Customer Account First!');
        //         e.preventdefault();
        //     }
        //     alertify.confirm("Are you sure you want add Sale Bill?", function(e) {
        //         if (e) {
        //             var purchase = new Object();
        //             purchase.date = $("#date").val();
        //             purchase.sale_type = $("#sale_type").val();
        //             purchase.invoice_no = $("#invoice_no").val();
        //             purchase.dcn_no = $("#dcn_no").val();
        //             purchase.p_order = $("#p_order").val();
        //             purchase.remarks = $("#remarks").val();
        //             purchase.lessCommercial = $("#lessCommercial").is(":checked");
        //             purchase.biller = $("#biller").val();
        //             purchase.party_id = $("#party_id").val();
        //             purchase.autocash = $("#autocash").is(":checked");

        //             var products = [];
        //             $.each($("#myData tr"), function(index, row) {
        //                 var columns = $(row).find("td");
        //                 var product = new Object();
        //                 product.party_id = $("#party_id").val();
        //                 product.product_id = $(columns[2]).find("input").val();
        //                 product.uom_id = $(columns[4]).find("input").val();
        //                 product.quantity = $(columns[6]).find("input").val();
        //                 product.rate = $(columns[7]).find("input").val();
        //                 product.stvalue = $(columns[8]).find("input").val();
        //                 product.taxvalue = $(columns[9]).find("input").val();
        //                 if ($(columns[10]).find("input").val() == '') {
        //                     product.extratax = 0;
        //                 } else {
        //                     product.extratax = $(columns[10]).find("input").val();
        //                 }
        //                 if ($(columns[11]).find("input").val() == '') {
        //                     product.extraTaxValue = 0;
        //                 } else {
        //                     product.extraTaxValue = $(columns[11]).find("input").val();
        //                 }

        //                 product.excvalue = $(columns[12]).find("input").val();
        //                 product.incvalue = $(columns[13]).find("input").val();
        //                 product.TotalTax = $(columns[14]).find("input").val();
        //                 products.push(product);
        //             });

        //             var $_token = jQuery('#token').val();
        //             jQuery.ajax({
        //                 method: "POST",
        //                 cache: false,
        //                 headers: {
        //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //                 },
        //                 data: {
        //                     purchase: JSON.stringify(purchase),
        //                     product_data: products
        //                 },
        //                 url: "{{ asset('salestax') }}",

        //                 success: function(result) {
        //                     console.log(result);
        //                     if (parseInt(result) > 0) {
        //                         window.open("{{ asset('salestax/print') }}/" + result);
        //                         window.location.href = "{{ asset('salestax') }}";
        //                     }
        //                 },
        //                 error: function(xhr, ajaxOptions, thrownError) {
        //                     $("#spanWait").hide();
        //                     alert(xhr.status);
        //                     alert(thrownError);
        //                 }
        //             });
        //         } else {
        //             alertify.alert("Not Saved!");
        //         }
        //     });
        // });
    </script>
@stop