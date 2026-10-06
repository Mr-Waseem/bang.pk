@extends("app")

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{Asset('css/select2.min.css')}}" rel="stylesheet" />
</head>
@section('contents')
    <body>
        <style>
        .st-wrap .st-meta-section {
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 10px 12px;
            margin-bottom: 14px;
        }
        .st-wrap .st-meta-row {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 6px 8px;
            align-items: end;
            margin-bottom: 10px;
        }
        .st-wrap .st-meta-row:last-child { margin-bottom: 0; }
        .st-wrap .st-meta-field { min-width: 0; }
        .st-wrap .st-meta-field label {
            display: block;
            margin-bottom: 3px;
            font-size: 11px;
            font-weight: 600;
            color: #495057;
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }
        .st-wrap .st-meta-row--1 .st-meta-field--date { grid-column: span 4; }
        .st-wrap .st-meta-row--1 .st-meta-field--invoice { grid-column: span 4; }
        .st-wrap .st-meta-row--1 .st-meta-field--tax { grid-column: span 4; }
        .st-wrap .st-meta-row--2 .st-meta-field--party { grid-column: span 5; }
        .st-wrap .st-meta-row--2 .st-meta-field--address { grid-column: span 5; }
        .st-wrap .st-meta-row--2 .st-meta-field--ntn { grid-column: span 2; }
        .st-wrap .st-meta-field .form-control,
        .st-wrap .st-meta-field .select2-container {
            width: 100% !important;
            max-width: 100%;
        }
        .st-wrap .st-meta-field .form-control {
            height: 32px;
            font-size: 13px;
            padding: 4px 8px;
            border-color: #ced4da;
        }
        .st-wrap .st-meta-field .select2-container .select2-selection--single {
            height: 32px !important;
            border-color: #ced4da;
        }
        .st-wrap .st-meta-field .select2-selection__rendered {
            line-height: 30px !important;
            font-size: 13px;
        }
        .st-wrap .st-meta-field .select2-selection__arrow { height: 30px !important; }
        .st-wrap .st-readonly {
            background-color: #f1f3f5 !important;
            color: #495057;
        }
        .st-wrap .st-grid-panel {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 12px;
            background: #fff;
        }
        .st-wrap .st-grid-scroll {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .st-wrap .st-table {
            width: 100%;
            min-width: 980px;
            margin-bottom: 0;
            border-collapse: collapse;
        }
        .st-wrap .st-table th {
            background: #3498db;
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            padding: 10px 6px;
            border: 1px solid #2980b9;
            white-space: nowrap;
            vertical-align: middle;
        }
        .st-wrap .st-table td {
            padding: 4px 5px;
            vertical-align: middle;
            border: 1px solid #e9ecef;
            font-size: 14px;
        }
        .st-wrap .st-table tr.st-entry td { background: #f0f7ff; }
        .st-wrap .st-table tr.st-data-row td { background: #fff; }
        .st-wrap .st-table tr.st-data-row:hover td { background: #fafbfc; }
        .st-wrap .st-table .form-control {
            height: 36px;
            padding: 4px 6px;
            font-size: 14px;
            margin: 0;
            width: 100%;
            max-width: 100%;
        }
        .st-wrap .st-num input { text-align: right; }
        .st-wrap .st-data-table {
            width: 100%;
            min-width: 980px;
            margin-bottom: 0;
        }
        .st-wrap .st-data-table th,
        .st-wrap .st-data-table td {
            padding: 4px 5px;
            vertical-align: middle;
            border: 1px solid #e9ecef;
            font-size: 14px;
        }
        .st-wrap .st-table .select2-container .select2-selection--single { height: 36px !important; }
        .st-wrap .st-table .select2-selection__rendered { line-height: 34px !important; font-size: 14px; }
        .st-wrap .st-table .select2-selection__arrow { height: 34px !important; }
        .st-wrap .st-data-table-wrap {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 12px;
            background: #fff;
            border-top: 2px solid #3498db;
        }
        .st-wrap .st-data-table-wrap .st-grid-scroll {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .st-wrap .summary-container {
            max-width: 920px;
            margin: 0 auto 1rem;
            padding: 0;
        }
        .st-wrap .summary-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05), 0 1px 3px rgba(0, 0, 0, 0.1);
            background: #fff;
        }
        .st-wrap .summary-card .card-body {
            padding: 16px 18px !important;
        }
        .st-wrap .summary-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px 16px;
            align-items: stretch;
        }
        .st-wrap .stat-item {
            padding: 8px 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1 1 140px;
            max-width: 180px;
            min-width: 130px;
        }
        .st-wrap .stat-label {
            color: #495057;
            font-size: 14px !important;
            font-weight: 700;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            margin-bottom: 0.45rem;
            text-align: center;
            line-height: 1.25;
        }
        .st-wrap .stat-value {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            text-align: center;
            font-weight: 700;
            font-size: 18px !important;
            color: #212529;
            padding: 0.7rem 0.5rem;
            width: 100%;
            max-width: none;
            height: 46px;
        }
        @media (max-width: 767px) {
            .st-wrap .st-meta-row--1 .st-meta-field,
            .st-wrap .st-meta-row--2 .st-meta-field {
                grid-column: span 12 !important;
            }
            .st-wrap .st-table .form-control { min-width: 70px; }
            .st-wrap .st-table td:nth-child(2) .form-control { min-width: 140px; }
        }
        </style>
        {{-- <div class="container-fluid">
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
        </div> --}}
        <div class="container-fluid">
            @if (Session::has('flash_message'))
                <div class="alert alert-success alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close"
                        style="margin-right: 4%;">&times;</a>
                    <strong>Success!</strong> {{ Session::get('flash_message') }}
                </div>
            @endif
            @if (Session::has('error_message'))
                <div class="alert alert-danger alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close"
                        style="margin-right: 4%;">&times;</a>
                    <strong>Success!</strong> {{ Session::get('error_message') }}
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix" id="panelbg">
                        <h2 class="panel-title"><b>Credit Note</b></h2>
                    </div>
                    <div class="panel-body">
                        <input id="token" type="hidden" value="{{ $encrypted_token }}">
                        @include('errors.validation')
                        {!! Form::open(['url' => 'pos-credit-note', 'class' => 'form-horizontal']) !!}
                        <div class="st-wrap">
                        <div class="st-meta-section">
                            <div class="st-meta-row st-meta-row--1">
                                <div class="st-meta-field st-meta-field--date">
                                    <label for="date">Date</label>
                                    <input id="date" type="date" name="date" class="form-control form-control-sm"
                                        data-index=0 value="<?php echo date('Y-m-d'); ?>" autofocus>
                                </div>
                                <div class="st-meta-field st-meta-field--invoice">
                                    <label for="invoice_no1">Credit.Note#</label>
                                    {!! Form::text('invoice_no1', $codes, [
                                        'id' => 'invoice_no1',
                                        'class' => 'form-control form-control-sm st-readonly',
                                        'disabled' => 'disabled',
                                    ]) !!}
                                    {!! Form::hidden('invoice_no', $codes, ['id' => 'invoice_no', 'class' => 'form-control']) !!}
                                    {!! Form::hidden('company_id', $codes, ['id' => 'company_id', 'class' => 'form-control']) !!}
                                </div>
                                <div class="st-meta-field st-meta-field--tax">
                                    <label for="ref_usin">SalesTax Inv#</label>
                                    {!! Form::text('ref_usin', null, ['id' => 'ref_usin','data-index' => '1','onkeypress' => 'return onlyNumberKey(event)', 'class' => 'form-control form-control-sm']) !!}
                                </div>
                                <select style="display:none;" class="form-control" onchange="LedgerValues();"
                                    id="sale_type" name="sale_type">
                                    <option style="display:none;" value="Credit Note">SalesTax Invoice</option>
                                </select>
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
                                        {!! Form::text('particulars', null, [
                                            'id' => 'particulars',
                                            'placeholder' => 'Description',
                                            'class' => 'form-control',
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                            <div style="display:none;">
                                {!! Form::text('dcn_no', null, ['id' => 'dcn_no', 'class' => 'form-control']) !!}
                                {!! Form::text('p_order', null, ['id' => 'p_order', 'class' => 'form-control']) !!}
                                {!! Form::text('remarks', null, ['id' => 'remarks', 'class' => 'form-control']) !!}
                                {!! Form::text('todayRate', 2200, ['id' => 'todayRate', 'class' => 'form-control']) !!}
                                <label class="radio-inline"><input type="checkbox" name="lessCommercial" id="lessCommercial"
                                        value="yes" checked>Less&nbsp;Commercial</label>
                                <label class="radio-inline"><input type="radio" name="FurtherTax" id="FurtherTax"
                                        value="yess" onclick="FurtherTaxes()">Further&nbsp;Tax</label>
                                <select name="biller" id="biller" class="form-control">
                                    <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
                                </select>
                            </div>
                            <div class="st-meta-row st-meta-row--2">
                                <div class="st-meta-field st-meta-field--party">
                                    <label for="party_name">Select Party</label>
                                    {!! Form::hidden('party_id', null, ['id' => 'party_id', 'class' => 'form-control']) !!}
                                    {!! Form::select('party_name', $customers, null, [
                                        'id' => 'party_name',
                                        'onchange' => 'javascript:PartyKeyUp($(this).val());',
                                        'data-index' => '2',
                                        'class' => 'form-control form-control-sm',
                                        'required' => 'required',
                                    ]) !!}
                                </div>
                                <div class="st-meta-field st-meta-field--address">
                                    <label for="address">Address</label>
                                    {!! Form::text('address', null, [
                                        'id' => 'address',
                                        'class' => 'form-control form-control-sm st-readonly',
                                        'placeholder' => 'Address',
                                        'disabled' => 'disabled',
                                    ]) !!}
                                </div>
                                <div class="st-meta-field st-meta-field--ntn">
                                    <label for="ntn">NTN</label>
                                    {!! Form::text('ntn', null, [
                                        'id' => 'ntn',
                                        'class' => 'form-control form-control-sm st-readonly',
                                        'placeholder' => 'NTN',
                                        'disabled' => 'disabled',
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                        <div class="st-grid-panel">
                            <div class="st-grid-scroll">
            <table id="myTable" class="table st-table">
                <thead>
                <tr>
                    <th width="7%">H.S Code</th>
                    <th width="15%">Product Name</th>
                    <th width="5%">Unit</th>
                    <th width="6%">Qty</th>
                    <th width="6%">Price</th>
                    <th width="5%">S.T%</th>
                    <th width="8%">Tax Value</th>
                    <th width="5%">Extra%</th>
                    <th width="8%">ExtraVal</th>
                    <th width="8%">Val ExTax</th>
                    <th width="10%">IncTax</th>
                    <th width="8%">Action</th>
                </tr>
                </thead>
                <tbody>
                    <tr class="st-entry">
                        {!! Form::hidden('product_id', null, ['id' => 'product_id', 'class' => 'form-control']) !!}
                        {!! Form::hidden('invoice_no', $codes, ['id' => 'invoice_no', 'class' => 'form-control']) !!}
                        {!! Form::hidden('sale_type1', 'Credit Note', ['id' => 'sale_type1', 'class' => 'form-control']) !!}
                        {{-- {!! Form::hidden('company_id', $codes_new, ['id' => 'company_id', 'class' => 'form-control']) !!} --}}

                        <td>
                            {!! Form::text('product_code', null, [
                                'id' => 'product_code',
                                'data-index' => '3',
                                'onkeypress' => 'return onlyNumberKey(event)',
                                'class' => 'form-control',
                            ]) !!}
                        </td>

                        <td>
                            {!! Form::select('product_name', $products, null, [
                                'id' => 'product_name',
                                'data-index' => '4',
                                'onchange' => 'ProductKeyUp($(this).val())',
                                'class' => 'form-control',
                            ]) !!}
                            {{-- {!! Form::select('product_name', $products, null, ['id' => 'product_name', 'onchange' => 'ProductKeyUp($(this).val().split("_").pop(), $(this).val().split("_")[0]);', 'class' => 'form-control']) !!}  --}}
                        </td>

                        <td>
                            {{-- {!! Form::select('uom_id', $uoms, null, ['id' => 'uom_id','onkeyup' => 'UomKeyUp($(this).val())', 'class' => 'form-control']) !!} --}}
                            {!! Form::text('uom_id', null, ['id' => 'uom_id', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                        </td>

                        <td>
                            {!! Form::text('quantity', null, [
                                'id' => 'quantity',
                                'data-index' => '5',
                                'onkeypress' => 'return onlyNumberKey(event)',
                                'onkeyup' => 'QuantityKeyUp($(this).val())',
                                'class' => 'form-control',
                            ]) !!}
                        </td>

                        <td>
                            {!! Form::text('price_per_unit', null, [
                                'id' => 'price_per_unit',
                                'data-index' => '6',
                                'onkeypress' => 'return onlyNumberKey(event)',
                                'onkeyup' => 'SaleRateKeyUpForm($(this).val())',
                                'class' => 'form-control',
                            ]) !!}
                        </td>

                        <td>
                            {!! Form::text('stvalue', null, ['id' => 'stvalue', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                        </td>

                        <td>
                            {!! Form::text('taxvalue', null, ['id' => 'taxvalue', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                        </td>

                        <td>
                            {!! Form::text('extratax', null, [
                                'id' => 'extratax',
                                'data-index' => '7',
                                'onkeyup' => 'ExtraTaxkeyup($(this).val());',
                                'onkeypress' => 'return onlyNumberKey(event)',
                                'class' => 'form-control',
                            ]) !!}
                        </td>

                        <td>
                            {!! Form::text('extraTaxValue1', null, [
                                'id' => 'extraTaxValue1',
                                // 'data-index' => '8',
                                'onkeypress' => 'return onlyNumberKey(event)',
                                // 'onkeyup' => 'AddGridData()',
                                'class' => 'form-control',
                                'disabled'=>'disabled'
                            ]) !!}
                            {!! Form::hidden('extraTaxValue', null, [
                                'id' => 'extraTaxValue',
                                // 'data-index' => '8',
                                'onkeypress' => 'return onlyNumberKey(event)',
                                // 'onkeyup' => 'AddGridData()',
                                'class' => 'form-control',
                            ]) !!}
                        </td>

                        <td>
                            {!! Form::text('ValueExTax', null, ['id' => 'ValueExTax', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                        </td>

                        <td>
                            {!! Form::text('amount', null, ['id' => 'amount', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                        </td>

                        <td>
                            <button style="margin-top:0;" class="btn btn-success btn-sm btn-add-line" type="button" onclick="AddGridDataClick()" data-index="8">
                                <i class="icon-plus" title="Add Row"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
                            </div>
                        </div>

                        <div class="st-data-table-wrap">
                            <div class="st-grid-scroll">
                                <table id="myData" class="table st-table st-data-table"></table>
                            </div>
                        </div>

                        <div class="summary-container">
                            <div class="card summary-card">
                                <div class="card-body">
                                    <div class="summary-row">
                                            <div style="display:none;"><label class="radio-inline"
                                                    style=""><input type="checkbox" name="autocash" id="autocash"
                                                        value="yes">Auto&nbsp;Cash</label> </div>
                                            <div class="stat-item">
                                                <span class="stat-label">Total Qty</span>
                                                <input type="text" class="form-control stat-value"
                                                    value="0" id="TotalRate" name="TotalRate" disabled>
                                            </div>
                                            <div class="stat-item">
                                                <span class="stat-label">Total Tax</span>
                                                <input type="text" class="form-control stat-value"
                                                    value="0" id="TotalTax1" name="TotalTax1" disabled>
                                            </div>
                                            <div class="stat-item">
                                                <span class="stat-label">Value Ex.Tax</span>
                                                <input type="text" class="form-control stat-value"
                                                    value="0" id="TotalExTax" name="TotalExTax" disabled>
                                            </div>
                                            <div class="stat-item">
                                                <span class="stat-label">Value Inc.Tax</span>
                                                <input type="text" class="form-control stat-value"
                                                    value="0" id="TotalAmount" name="TotalAmount" disabled>
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
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection
@section('scripts')
    <script src="{{ asset('js/plugins/nouislider/nouislider.min.js') }}"></script>
    <!-- Input Mask-->
    <script src="{{ asset('js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>
    <!-- Select2-->
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <!--Bootstrap ColorPicker-->
    <script src="{{ asset('js/plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <script>

$(document).ready(function() {
            var $dateField = $('#date');
            if ($dateField.length && typeof $dateField.datepicker === 'function') {
                try { $dateField.datepicker('destroy'); } catch (e) {}
            }

            $(window).keydown(function(event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    var $this = $(event.target);
                    if ($this.closest('.btn-add-line').length || $this.hasClass('btn-add-line')) {
                        AddGridDataClick();
                        return false;
                    }
                    var index = parseFloat($this.attr('data-index'));
                    if (!isNaN(index)) {
                        $('[data-index="' + (index + 1).toString() + '"]').focus();
                    }
                    return false;
                }
            });

            $('.btn-add-line').on('keydown', function (e) {
                if (e.key === 'Enter' || e.keyCode === 13 || ((e.key === 'Tab' || e.keyCode === 9) && !e.shiftKey)) {
                    e.preventDefault();
                    e.stopPropagation();
                    AddGridDataClick();
                }
            });
        });




        $(document).ready(function() {
            $("#party_name").select2();
            $("#party_name").next(".select2").find(".select2-selection").focus(function() {
                $("#party_name").select2("open");
            });
            $("#party_name").on("focus", function() {
                $(document).ready(function() {
                    $(window).keydown(function(event) {
                        if (event.keyCode == 13) {
                            event.preventDefault();
                            var $this = $(event.target);
                            var index = parseFloat($this.attr('data-index'));
                            // alert('inside');
                            $("#product_code").focus();
                            $('[data-index="' + (index + 1).toString() + '"]').focus();
                            return false;
                        }
                    });
                });
                $("#party_name").select2("open")
                //  event.preventDefault();
            });
        });
        $(document).ready(function() {

            $("#product_name").select2();
            $("#product_name").next(".select2").find(".select2-selection").focus(function() {
                $("#product_name").select2("open");
            });

            $("#product_name").on("focus", function() {
                $(document).ready(function() {
                    $(window).keydown(function(event) {
                        if (event.keyCode == 13) {

                            event.preventDefault();
                            var $this = $(event.target);
                            var index = parseFloat($this.attr('data-index'));
                            // alert('inside');
                            $("#quantity").focus();
                            $('[data-index="' + (index + 1).toString() + '"]').focus();
                            return false;
                        }
                    });
                });
                $("#product_name").select2("open");
            });
        });

        // function onlyNumberKey(evt) {

        //     // Only ASCII character in that range allowed
        //     var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        //     if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        //         return false;
        //     return true;
        // }
        function onlyNumberKey(evt) { 
              // Only ASCII character in that range allowed 
              var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
          }
    </script>


    <script type="text/javascript">
       

        function FurtherTaxes() {
            var checkbox = document.getElementById('FurtherTax');
            if (checkbox.checked = true) {
                document.getElementById('extratax').value = 3;
            }
        }

       

        function AddGridData() {
            var date = document.getElementById('date').value;
            var InvoiceNo = document.getElementById('invoice_no').value;
            var Party = document.getElementById('party_name').value;
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

          
            // document.getElementById('extraTaxValue1').value  =ExtraTaxValue;
          
          
        
            var TotalRate = document.getElementById('TotalRate').value;
            var TotalTax = document.getElementById('TotalTax1').value;
            var TotalExTax = document.getElementById('TotalExTax').value;
            var TotalAmount = document.getElementById('TotalAmount').value;
            //    alert(Party);
            if(Party==0){
                // alert("Product Not Selected.");
                $("#party_name").focus();
               $(document).ready(function() {
                    $(window).keydown(function(event) {
                        if (event.keyCode == 13) {

                            event.preventDefault();
                            var $this = $(event.target);
                            var index = parseFloat($this.attr('data-index'));
                            // alert('inside');
                            $("#product_code").focus();
                            $('[data-index="' + (index + 1).toString() + '"]').focus();
                            return false;
                        }
                    });
                });
            }
          else if(ProductID==0)
            {
                // alert("Product Not Selected.");
               $("#product_name").focus();
               $(document).ready(function() {
                    $(window).keydown(function(event) {
                        if (event.keyCode == 13) {

                            event.preventDefault();
                            var $this = $(event.target);
                            var index = parseFloat($this.attr('data-index'));
                            // alert('inside');
                            $("#quantity").focus();
                            $('[data-index="' + (index + 1).toString() + '"]').focus();
                            return false;
                        }
                    });
                });
            }
           else if(Quantity==0)
            {
                // alert("Quantity Cannot Be Zero.");
               $("#quantity").focus();
            }
           else if(Price==0)
            {
                // alert("Price Cannot Be Zero.");
               $("#price_per_unit").focus();
            }
            else
            {

            // var totalPrice = parseInt(TotalRate) + parseInt(Price);
            // var TotalTaxAmount = parseInt(TotalTax) + parseInt(TaxValue);
            // var TotalExTaxAmount = parseInt(TotalExTax) + parseInt(ValueExTax);
            // var TotalincTaxAmount = parseInt(TotalAmount) + parseInt(Amount);
        
            // document.getElementById('TotalRate').value = totalPrice;
            // document.getElementById('TotalTax').value = TotalTaxAmount;
            // document.getElementById('TotalExTax').value = TotalExTaxAmount;
            // document.getElementById('TotalAmount').value = TotalincTaxAmount;
            
          
          
           
           var divhtml = '<table>';
            var tableHtml = '<tr class="st-data-row">';
            //0
            tableHtml +=
                `<td style="display:none;">
                    <input name="product_id1[]" value="${ProductId}" type="hidden">
                </td>`;
            //1
            tableHtml +=
                `<td>
                    <input value="${ProductCode}" type="text" class="form-control input-sm" disabled>
                    <input name="product_code[]" value="${ProductCode}" type="hidden">
                </td>`;
            //2
            tableHtml +=
                `<td style="display:none;">
                    <input value="${ProductID}" type="hidden">
                </td>`;
            //3
            tableHtml +=
                `<td>
                    <input value="${ProductName}" type="text" class="form-control input-sm" disabled>
                    <input value="${ProductName}" name="product_name[]" type="hidden">
                </td>`;
            //4
            tableHtml +=
                `<td style="display:none;">
                    <input name="uom_id[]" value="${UOMID}" type="hidden">
                </td>`;
            //5
            tableHtml +=
                `<td>
                    <input value="${UOM}" type="text" class="form-control input-sm" disabled>
                </td>`;
            //6
            tableHtml +=
                `<td class="st-num">
                    <input value="${Quantity}" type="text" class="form-control input-sm" onkeyup="salequantity($(this).val(), $(this).closest('tr').index());">
                    <input name="quantity[]" value="${Quantity}" type="hidden">
                </td>`;
            //7
            tableHtml +=
                `<td class="st-num">
                    <input value="${Price}" type="text" class="form-control input-sm" onkeyup="salerate($(this).val(), $(this).closest('tr').index());">
                    <input name="rate[]" value="${Price}" type="hidden">
                </td>`;
            //8
            tableHtml +=
                `<td class="st-num">
                    <input value="${STValue}" type="text" class="form-control input-sm" disabled>
                    <input name="stvalue[]" value="${STValue}" type="hidden">
                </td>`;
            //9
            tableHtml +=
                `<td class="st-num">
                    <input value="${TaxValue}" type="text" class="form-control input-sm" disabled>
                    <input name="taxvalue[]" value="${TaxValue}" type="hidden">
                </td>`;
            //10
            tableHtml +=
                `<td>
                    <input value="${ExtraTax}" type="text" class="form-control input-sm" disabled>
                    <input name="extratax[]" value="${ExtraTax}" type="hidden">
                </td>`;
            //11
            tableHtml +=
                `<td class="st-num">
                    <input value="${ExtraTaxValue}" type="text" class="form-control input-sm" disabled>
                    <input name="extraTaxValue[]" value="${ExtraTaxValue}" type="hidden">
                </td>`;
            //12
            tableHtml +=
                `<td class="st-num">
                    <input value="${ValueExTax}" type="text" class="form-control input-sm" disabled>
                    <input name="excvalue[]" value="${ValueExTax}" type="hidden">
                </td>`;
            //13
            tableHtml +=
                `<td class="st-num">
                    <input value="${Amount}" type="text" class="form-control input-sm" disabled>
                    <input name="incvalue[]" value="${Amount}" type="hidden">
                </td>`;
            //14
            tableHtml +=
                `<td style="display:none;">
                    <input name="TotalTax[]" value="${TotalTax}" type="hidden">
                </td>`;
            //15
            tableHtml +=
                `<td>
                    <button class="btn btn-danger btn-sm" type="button" onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" title="Delete Row">
                        <i class="icon-trash"></i>
                    </button>
                </td>`;
            tableHtml += '</tr>';
            divhtml += '</table>';
            $('#myData').append(tableHtml);
            // document.getElementById("product_code").focus();
            $('#product_name').select2('open');
            TotalQty1();
            TotalTax1();
            TotalExTax1();
            TotalGrandAmount();
            
        }
        }

        function TotalQty1() {
            var tableData = document.getElementById('myData');
            var sum = 0;
            for (var i = 0; i < tableData.rows.length; i++) {
                if (tableData.rows[i].cells[6].getElementsByTagName('input')[0].value == '') {
                    sum += 0;
                } else {
                    sum += parseFloat(tableData.rows[i].cells[6].getElementsByTagName('input')[0].value);
                }   
            }
            document.getElementById('TotalRate').value = sum.toLocaleString('en-US');
        }

        function TotalTax1() {
            var tableData = document.getElementById('myData');
            var sum = 0;
            for (var i = 0; i < tableData.rows.length; i++) {
                if (tableData.rows[i].cells[9].getElementsByTagName('input')[0].value == '') {
                    sum += 0;
                } else {
                    sum += parseFloat(tableData.rows[i].cells[9].getElementsByTagName('input')[0].value);
                }   
            }
            document.getElementById('TotalTax1').value = sum.toLocaleString('en-US');
        }

        function TotalExTax1() {
            var tableData = document.getElementById('myData');
            var sum = 0;
            for (var i = 0; i < tableData.rows.length; i++) {
                // alert(34);
                if (tableData.rows[i].cells[12].getElementsByTagName('input')[0].value == '') {
                    sum += 0;
                } else {
                    sum += parseFloat(tableData.rows[i].cells[12].getElementsByTagName('input')[0].value);
                    // alert(sum);
                }   
            }
            document.getElementById('TotalExTax').value = sum.toLocaleString('en-US');
        }

        function TotalGrandAmount() {
            var tableData = document.getElementById('myData');
            var sum = 0;
            for (var i = 0; i < tableData.rows.length; i++) {
                // alert(34);
                if (tableData.rows[i].cells[13].getElementsByTagName('input')[0].value == '') {
                    sum += 0;
                } else {
                    sum += parseFloat(tableData.rows[i].cells[13].getElementsByTagName('input')[0].value);
                    // alert(sum);
                }   
            }
            document.getElementById('TotalAmount').value = sum.toLocaleString('en-US');
        }
        function AddGridDataClick() {
            var date = document.getElementById('date').value;
            var InvoiceNo = document.getElementById('invoice_no').value;
            var Party = document.getElementById('party_name').value;
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

          
            // document.getElementById('extraTaxValue1').value  =ExtraTaxValue;
          
          
          
          
            var TotalRate = document.getElementById('TotalRate').value;
            var TotalTax = document.getElementById('TotalTax1').value;
            var TotalExTax = document.getElementById('TotalExTax').value;
            var TotalAmount = document.getElementById('TotalAmount').value;
            //    alert(Party);
            if(Party==0){
                // alert("Product Not Selected.");
                $("#party_name").focus();
               $(document).ready(function() {
                    $(window).keydown(function(event) {
                        if (event.keyCode == 13) {

                            event.preventDefault();
                            var $this = $(event.target);
                            var index = parseFloat($this.attr('data-index'));
                            // alert('inside');
                            $("#product_code").focus();
                            $('[data-index="' + (index + 1).toString() + '"]').focus();
                            return false;
                        }
                    });
                });
            }
          else if(ProductID==0)
            {
                // alert("Product Not Selected.");
               $("#product_name").focus();
               $(document).ready(function() {
                    $(window).keydown(function(event) {
                        if (event.keyCode == 13) {

                            event.preventDefault();
                            var $this = $(event.target);
                            var index = parseFloat($this.attr('data-index'));
                            // alert('inside');
                            $("#quantity").focus();
                            $('[data-index="' + (index + 1).toString() + '"]').focus();
                            return false;
                        }
                    });
                });
            }
           else if(Quantity==0)
            {
                // alert("Quantity Cannot Be Zero.");
               $("#quantity").focus();
            }
           else if(Price==0)
            {
                // alert("Price Cannot Be Zero.");
               $("#price_per_unit").focus();
            }
            else
            {

                
            // var totalPrice = parseInt(TotalRate) + parseInt(Price);
            // var TotalTaxAmount = parseInt(TotalTax) + parseInt(TaxValue);
            // var TotalExTaxAmount = parseInt(TotalExTax) + parseInt(ValueExTax);
            // var TotalincTaxAmount = parseInt(TotalAmount) + parseInt(Amount);
            

            // document.getElementById('TotalRate').value = totalPrice;
            // document.getElementById('TotalTax1').value = TotalTaxAmount;
            // document.getElementById('TotalExTax').value = TotalExTaxAmount;
            // document.getElementById('TotalAmount').value = TotalincTaxAmount;
          
          
           
           var divhtml = '<table>';
            var tableHtml = '<tr class="st-data-row">';
            //0
            tableHtml +=
                `<td style="display:none;">
                    <input name="product_id1[]" value="${ProductId}" type="hidden">
                </td>`;
            //1
            tableHtml +=
                `<td>
                    <input value="${ProductCode}" type="text" class="form-control input-sm" disabled>
                    <input name="product_code[]" value="${ProductCode}" type="hidden">
                </td>`;
            //2
            tableHtml +=
                `<td style="display:none;">
                    <input value="${ProductID}" type="hidden">
                </td>`;
            //3
            tableHtml +=
                `<td>
                    <input value="${ProductName}" type="text" class="form-control input-sm" disabled>
                    <input value="${ProductName}" name="product_name[]" type="hidden">
                </td>`;
            //4
            tableHtml +=
                `<td style="display:none;">
                    <input name="uom_id[]" value="${UOMID}" type="hidden">
                </td>`;
            //5
            tableHtml +=
                `<td>
                    <input value="${UOM}" type="text" class="form-control input-sm" disabled>
                </td>`;
            //6
            tableHtml +=
                `<td class="st-num">
                    <input value="${Quantity}" type="text" class="form-control input-sm" onkeyup="salequantity($(this).val(), $(this).closest('tr').index());">
                    <input name="quantity[]" value="${Quantity}" type="hidden">
                </td>`;
            //7
            tableHtml +=
                `<td class="st-num">
                    <input value="${Price}" type="text" class="form-control input-sm" onkeyup="salerate($(this).val(), $(this).closest('tr').index());">
                    <input name="rate[]" value="${Price}" type="hidden">
                </td>`;
            //8
            tableHtml +=
                `<td class="st-num">
                    <input value="${STValue}" type="text" class="form-control input-sm" disabled>
                    <input name="stvalue[]" value="${STValue}" type="hidden">
                </td>`;
            //9
            tableHtml +=
                `<td class="st-num">
                    <input value="${TaxValue}" type="text" class="form-control input-sm" disabled>
                    <input name="taxvalue[]" value="${TaxValue}" type="hidden">
                </td>`;
            //10
            tableHtml +=
                `<td>
                    <input value="${ExtraTax}" type="text" class="form-control input-sm" disabled>
                    <input name="extratax[]" value="${ExtraTax}" type="hidden">
                </td>`;
            //11
            tableHtml +=
                `<td class="st-num">
                    <input value="${ExtraTaxValue}" type="text" class="form-control input-sm" disabled>
                    <input name="extraTaxValue[]" value="${ExtraTaxValue}" type="hidden">
                </td>`;
            //12
            tableHtml +=
                `<td class="st-num">
                    <input value="${ValueExTax}" type="text" class="form-control input-sm" disabled>
                    <input name="excvalue[]" value="${ValueExTax}" type="hidden">
                </td>`;
            //13
            tableHtml +=
                `<td class="st-num">
                    <input value="${Amount}" type="text" class="form-control input-sm" disabled>
                    <input name="incvalue[]" value="${Amount}" type="hidden">
                </td>`;
            //14
            tableHtml +=
                `<td style="display:none;">
                    <input name="TotalTax[]" value="${TotalTax}" type="hidden">
                </td>`;
            //15
            tableHtml +=
                `<td>
                    <button class="btn btn-danger btn-sm" type="button" onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" title="Delete Row">
                        <i class="icon-trash"></i>
                    </button>
                </td>`;
            tableHtml += '</tr>';
            divhtml += '</table>';
            $('#myData').append(tableHtml);
            // document.getElementById("product_code").focus();
            $('#product_name').select2('open');
            TotalQty1();
            TotalTax1();
            TotalExTax1();
            TotalGrandAmount();
        }
        }
        function salequantity(quantity, RowIndex) {
            console.log(quantity);
            
            var rate = $('tr:eq(' + RowIndex + ')', myData).find("td:eq('7')").find('input').val();
            var tax = ((($('tr:eq(' + RowIndex + ')', myData).find("td:eq('8')").find('input').val())*rate)/100)*quantity;
            // var tax =( $('tr:eq(' + RowIndex + ')', myData).find("td:eq('9')").find('input').val())/(qty);
            var totalrate = quantity *rate;
            var totalinctax = parseFloat(totalrate)+parseFloat(tax);
            // alert(RowIndex);
            // alertify.confirm(totalinctax);
            $('tr:eq(' + RowIndex + ')', myData).find("td:eq('9')").find('input').val(tax);
            $('tr:eq(' + RowIndex + ')', myData).find("td:eq('12')").find('input').val(totalrate);
            $('tr:eq(' + RowIndex + ')', myData).find("td:eq('13')").find('input').val(totalinctax);
            $(document).ready(function() {
                    $(window).keydown(function(event) {
                        if (event.keyCode == 13) {

                            event.preventDefault();
                            var $this = $(event.target);
                            var index = parseFloat($this.attr('data-index'));
                            // alert('inside');
                            $("#ratee").focus();
                            $('[data-index="' + (index + 1).toString() + '"]').focus();
                            return false;
                        }
                    });
                });
        }
        function salerate(rate, RowIndex) {
            
            var qty = $('tr:eq(' + RowIndex + ')', myData).find("td:eq('6')").find('input').val();
            var tax = ((($('tr:eq(' + RowIndex + ')', myData).find("td:eq('8')").find('input').val())*rate)/100)*qty;
            // var tax =( $('tr:eq(' + RowIndex + ')', myData).find("td:eq('9')").find('input').val())/(qty);
            var totalrate = qty *rate;
            var totalinctax = parseFloat(totalrate)+parseFloat(tax);
            // console.log(totalinctax);
            // alertify.confirm(totalinctax);
            $('tr:eq(' + RowIndex + ')', myData).find("td:eq('9')").find('input').val(tax);
            $('tr:eq(' + RowIndex + ')', myData).find("td:eq('12')").find('input').val(totalrate);
            $('tr:eq(' + RowIndex + ')', myData).find("td:eq('13')").find('input').val(totalinctax);
            $(document).ready(function() {
                    $(window).keydown(function(event) {
                        if (event.keyCode == 13) {

                            event.preventDefault();
                            var $this = $(event.target);
                            var index = parseFloat($this.attr('data-index'));
                            // alert('inside');
                            $("#product_code").focus();
                            $('[data-index="' + (index + 1).toString() + '"]').focus();
                            return false;
                        }
                    });
                });
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
            // if (event.keyCode == 13) {
            //         // event.preventDefault();
            //         var $this = $(event.target);
            //         var index = parseFloat($this.attr('data-index'));
            //         // alert(index);
            //         $('[data-index="' + (index + 1).toString() + '"]').focus();
            //         return false;
            //     }

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
            document.getElementById('extraTaxValue1').value = extratax;
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
            var unit = document.getElementById('product_name').value.split("_")[5];
            // var productTax = document.getElementById('product_name').value.split("_").pop();
            // alert(productID)
            // alert(productCode)
            // alert(productName)
            // alert(productTax)
            var TodayRate = document.getElementById('todayRate').value;
            //alert(TodayRate)
            var totalRate = TodayRate * productName;

            document.getElementById('product_id').value = productID;
            document.getElementById('product_code').value = productCode;
            document.getElementById('price_per_unit').value = productprice;
            document.getElementById('stvalue').value = productTax;
            document.getElementById('uom_id').value = unit;
            // $("#product_code").focus();


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
                    // alert();
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
                    // var TotalRate = document.getElementById('TotalRate').value;
                    // var rate = $(row).find("td:eq('7')").find("input").val();
                    // var grandRate = parseInt(TotalRate) - parseInt(rate);
                    // document.getElementById('TotalRate').value = grandRate;

                    // var TotalTax = document.getElementById('TotalTax').value;
                    // var tax = $(row).find("td:eq('9')").find("input").val();
                    // var grandTax = parseInt(TotalTax) - parseInt(tax);
                    // document.getElementById('TotalTax').value = grandTax;

                    // var TotalExTax = document.getElementById('TotalExTax').value;
                    // var Extax = $(row).find("td:eq('12')").find("input").val();
                    // var grandExTax = parseInt(TotalExTax) - parseInt(Extax);
                    // document.getElementById('TotalExTax').value = grandExTax;

                    // var TotalAmount = document.getElementById('TotalAmount').value;
                    // var Inctax = $(row).find("td:eq('13')").find("input").val();
                    // var grandIncTax = parseInt(TotalAmount) - parseInt(Inctax);
                    // document.getElementById('TotalAmount').value = grandIncTax;

                    $(row).remove();
                    TotalQty1();
                        TotalTax1();
                        TotalExTax1();
                        TotalGrandAmount();
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





        // function handleEnter(event) {
        //    if (event.key==="Enter") {
        //       const form = document.getElementById('form')
        //       const index = [...form].indexOf(event.target);
        //       form.elements[index + 1].focus();
        //       event.preventDefault();
        //     }
        // }

        // $("#btnSave").click(function() {
        //     alertify.confirm("Are you sure you want add Purchase Tax Bill?", function(e) {
        //         if (e) {
        //             if ($('#party_id').val() == '') {
        //                 alert('Please Select Supplier');
        //                 return false;
        //             }

        //             var purchase = new Object();
        //             purchase.date = $("#date").val();
        //             purchase.voucher_no = $("#voucher_no").val();
        //             purchase.p_order = $("#p_order").val();
        //             purchase.purchase_type = $("#purchase_type").val();
        //             purchase.invoice_no = $("#voucher_no").val();
        //             purchase.remarks = $("#remarks").val();
        //             purchase.lessCommercial = $("#lessCommercial").is(":checked");
        //             purchase.autocash = $("#autocash").is(":checked");
        //             purchase.biller = $("#biller").val();
        //             purchase.party_id = $("#party_id").val();
        //             purchase.company_id = $('#company_id').val();

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
        //                 product.extratax = $(columns[10]).find("input").val();
        //                 product.extraTaxValue = $(columns[11]).find("input").val();
        //                 product.excvalue = $(columns[12]).find("input").val();
        //                 product.incvalue = $(columns[13]).find("input").val();
        //                 product.TotalTax = $(columns[14]).find("input").val();
        //                 product.company_id = $('#company_id').val();
        //                 products.push(product);
        //             });
        //             if(products != ""){
        //             var $_token = jQuery('#token').val();
        //             jQuery.ajax({
        //                 url: "{{ asset('purchase-tax') }}",
        //                 method: "POST",
        //                 cache: false,
        //                 headers: {
        //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //                 },
        //                 data: {
        //                     purchase: JSON.stringify(purchase),
        //                     product_data: products
        //                 },
        //                 success: function(result) {
        //                     console.log(result);
        //                     //if(result == "inserted")
        //                     if (parseInt(result) > 0) {
        //                         window.open("../purchase-tax/" + result);
        //                         window.location.href = "{{ asset('purchase-tax/create') }}";
        //                         //window.open("/sales/print/"+result);
        //                         //alert("Sale successfully saved.");
        //                         //Session::flash('flash_message', 'Sale Added Successfully!');
        //                         //window.location.href = "/sales";

        //                     }
        //                 },
        //                 error: function(xhr, ajaxOptions, thrownError) {
        //                     $("#spanWait").hide();
        //                     alert(xhr.status);
        //                     alert(thrownError);
        //                 }
        //             });
        //         }else{
        //             alert("Add your product in Grid");
        //             e.preventdefault();
        //         }
        //         } else {
        //             alertify.alert("Not Saved!");
        //         }
        //     });
        // });






















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
