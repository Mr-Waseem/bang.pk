@extends('app')


</head>
@section('contents')

    <body>
        <head>
            <meta name="csrf-token" content="{{ csrf_token() }}" />
            <link href="{{ Asset('css/select2.min.css') }}" rel="stylesheet" />
            <style>
        .col-md-1 {
            width: 7.9%;
        }
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
        /* Compact top row: Date | Invoice | Tax% | DC | PO | Remarks */
        .st-wrap .st-meta-row--1 .st-meta-field--date { grid-column: span 2; }
        .st-wrap .st-meta-row--1 .st-meta-field--invoice { grid-column: span 2; }
        .st-wrap .st-meta-row--1 .st-meta-field--tax { grid-column: span 1; }
        .st-wrap .st-meta-row--1 .st-meta-field--dc { grid-column: span 2; }
        .st-wrap .st-meta-row--1 .st-meta-field--po { grid-column: span 2; }
        .st-wrap .st-meta-row--1 .st-meta-field--remarks { grid-column: span 3; }
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
            table-layout: fixed;
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
            box-sizing: border-box;
        }
        .st-wrap .st-table .btn-sm {
            min-width: 64px;
            height: 36px;
            padding: 4px 10px;
            font-size: 13px;
            line-height: 1.2;
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
        .st-wrap .st-req {
            color: #dc3545;
            font-weight: 700;
            margin-left: 2px;
        }
        #ui-datepicker-div {
            z-index: 99999 !important;
            background: #fff !important;
            opacity: 1 !important;
            transition: none !important;
            -webkit-transition: none !important;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
            border: 1px solid #c5c5c5;
        }
        #ui-datepicker-div .ui-widget-header {
            background: #3498db !important;
            color: #fff !important;
            border: none;
        }
        #ui-datepicker-div .ui-datepicker-title select {
            color: #212529 !important;
            background: #fff !important;
            border: 1px solid #ced4da;
            border-radius: 3px;
            font-size: 12px;
            margin: 0 2px;
            padding: 1px 4px;
            height: 24px;
        }
        #ui-datepicker-div .ui-datepicker-prev,
        #ui-datepicker-div .ui-datepicker-next { cursor: pointer; top: 4px; }
        #ui-datepicker-div .ui-datepicker-prev span,
        #ui-datepicker-div .ui-datepicker-next span {
            background-image: none !important;
            text-indent: 0 !important;
            overflow: visible !important;
            width: auto !important;
            height: auto !important;
            display: block;
            color: transparent;
            font-size: 0;
            line-height: 1.2;
            margin: 2px 6px;
        }
        #ui-datepicker-div .ui-datepicker-prev span:before {
            content: "‹";
            color: #fff;
            font-size: 18px;
            font-weight: 700;
        }
        #ui-datepicker-div .ui-datepicker-next span:before {
            content: "›";
            color: #fff;
            font-size: 18px;
            font-weight: 700;
        }
        #ui-datepicker-div .ui-state-default {
            background: #f7f9fc !important;
            border: 1px solid #e3e8ef !important;
            color: #212529 !important;
            text-align: center;
        }
        #ui-datepicker-div .ui-state-highlight,
        #ui-datepicker-div .ui-state-active {
            background: #3498db !important;
            color: #fff !important;
        }
        .st-wrap .summary-container {
            width: 100%;
            max-width: 720px;
            margin: 8px auto 16px;
            padding: 0;
        }
        .st-wrap .summary-card {
            border: 1px solid #e9ecef;
            border-radius: 6px;
            box-shadow: none;
            background: #fff;
        }
        .st-wrap .summary-card .card-body {
            padding: 8px 10px !important;
        }
        .st-wrap .summary-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: flex-end;
            gap: 6px 8px;
        }
        .st-wrap .summary-row + .summary-row {
            margin-top: 6px;
            padding-top: 0;
            border-top: none;
        }
        .st-wrap .stat-item {
            flex: 0 1 calc(25% - 6px);
            width: calc(25% - 6px);
            min-width: 120px;
            max-width: 170px;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: stretch;
            justify-content: flex-end;
        }
        .st-wrap .stat-label {
            color: #495057;
            font-size: 10px !important;
            font-weight: 600;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            margin-bottom: 2px;
            text-align: left;
            line-height: 1.2;
            min-height: 0;
        }
        .st-wrap .stat-value {
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 3px;
            text-align: left;
            font-weight: 600;
            font-size: 12px !important;
            color: #212529;
            padding: 2px 6px;
            width: 100%;
            max-width: none;
            height: 28px;
            min-height: 28px;
            line-height: 22px;
            box-shadow: none;
        }
        .st-wrap .stat-value[readonly],
        .st-wrap .stat-value:disabled,
        .st-wrap .stat-value[disabled] {
            background-color: #f1f3f5 !important;
            color: #495057;
        }
        @media (max-width: 991px) {
            .st-wrap .summary-container { max-width: 100%; }
            .st-wrap .stat-item { flex-basis: calc(50% - 6px); width: calc(50% - 6px); max-width: none; }
        }
        @media (max-width: 575px) {
            .st-wrap .stat-item { flex-basis: 100%; width: 100%; max-width: none; }
        }
        @media (max-width: 991px) {
            .st-wrap .st-meta-row--1 .st-meta-field--date,
            .st-wrap .st-meta-row--1 .st-meta-field--invoice,
            .st-wrap .st-meta-row--1 .st-meta-field--dc,
            .st-wrap .st-meta-row--1 .st-meta-field--po { grid-column: span 4; }
            .st-wrap .st-meta-row--1 .st-meta-field--tax { grid-column: span 4; }
            .st-wrap .st-meta-row--1 .st-meta-field--remarks { grid-column: span 8; }
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
                        <h2 class="panel-title"><b>Sales Tax Invoice</b></h2>
                    </div>
                    <div class="panel-body">
                        <input id="token" type="hidden" value="{{ $encrypted_token }}">
                        @include('errors.validation')
                        {!! Form::open(['id' => 'form', 'url' => 'pos-salestax', 'class' => 'form-horizontal']) !!}
                        <div class="st-wrap">
                        <div class="st-meta-section">
                            <div class="st-meta-row st-meta-row--1">
                                <div class="st-meta-field st-meta-field--date">
                                    <label for="date_display">Date <span class="st-req">*</span></label>
                                    <input id="date_display" type="text" value="<?php echo date('d-m-Y'); ?>"
                                    class="form-control form-control-sm" autofocus autocomplete="off"
                                    placeholder="DD-MM-YYYY" maxlength="10">
                                    <input id="date" type="hidden" name="date" value="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                <div class="st-meta-field st-meta-field--invoice">
                                    <label for="invoice_no1">Invoice No <span class="st-req">*</span></label>
                                        {!! Form::text('invoice_no1', $codes, [
                                            'id' => 'invoice_no1',
                                            'class' => 'form-control form-control-sm st-readonly',
                                            'disabled' => 'disabled',
                                        ]) !!}
                                        {!! Form::hidden('invoice_no', $codes, ['id' => 'invoice_no', 'class' => 'form-control']) !!}
                                        {!! Form::hidden('company_id', $codes, ['id' => 'company_id', 'class' => 'form-control']) !!}
                                    </div>
                                <div class="st-meta-field st-meta-field--tax">
                                    <label for="tax_percent">Tax%</label>
                                        {!! Form::text('tax_percent', null, [
                                            'id' => 'tax_percent',
                                            'onkeypress' => 'return onlyNumberKey(event)',
                                            'class' => 'form-control form-control-sm'
                                        ]) !!}
                                    </div>
                                    <select style="display:none;" class="form-control" onchange="LedgerValues();"
                                        id="sale_type" name="sale_type">
                                        <option style="display:none;" value="SalesTax Invoice">SalesTax Invoice</option>
                                    </select>
                                <div class="st-meta-field st-meta-field--dc">
                                    <label for="dcn_no">DC No</label>
                                    {!! Form::text('dcn_no', null, ['id' => 'dcn_no', 'class' => 'form-control form-control-sm']) !!}
                                </div>
                                <div class="st-meta-field st-meta-field--po">
                                    <label for="p_order">PO No</label>
                                    {!! Form::text('p_order', null, ['id' => 'p_order', 'class' => 'form-control form-control-sm']) !!}
                                </div>
                                <div class="st-meta-field st-meta-field--remarks">
                                    <label for="remarks">Remarks</label>
                                    {!! Form::text('remarks', null, ['id' => 'remarks', 'class' => 'form-control form-control-sm']) !!}
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
                                    {!! Form::text('particulars', null, [
                                        'id' => 'particulars',
                                        'placeholder' => 'Description',
                                        'class' => 'form-control',
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                                <div style="display:none;">
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
                                    <label for="party_name">Select Party <span class="st-req">*</span></label>
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
                                    <label for="address">Address <span class="st-req">*</span></label>
                                    {!! Form::text('address', null, [
                                        'id' => 'address',
                                        'class' => 'form-control form-control-sm st-readonly',
                                        'placeholder' => 'Address',
                                        'disabled' => 'disabled',
                                    ]) !!}
                                </div>
                                <div class="st-meta-field st-meta-field--ntn">
                                    <label for="ntn">NTN <span class="st-req">*</span></label>
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
                    <th width="8%">Tax.Val</th>
                    <th width="5%">Fur.Tax%</th>
                    <th width="8%">Fur.Val</th>
                    <th width="8%">Val ExTax</th>
                    <th width="10%">IncTax</th>
                    <th width="8%">Action</th>
                </tr>
                </thead>
                <tbody>
                    <tr class="st-entry">
                        {!! Form::hidden('product_id', null, ['id' => 'product_id', 'class' => 'form-control']) !!}
                        {!! Form::hidden('invoice_no', $codes, ['id' => 'invoice_no', 'class' => 'form-control']) !!}
                        {!! Form::hidden('sale_type1', 'SalesTax Invoice', ['id' => 'sale_type1', 'class' => 'form-control']) !!}
                        
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
                        </td>
                        
                        <td>
                            {!! Form::text('uom_id', null, [
                                'id' => 'uom_id', 
                                'class' => 'form-control', 
                                'disabled' => 'disabled'
                            ]) !!}
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
                                'oninput' => 'validateEightDecimals(this)',
                                'onkeyup' => 'QuantityKeyUp($(this).val())',
                                'class' => 'form-control',
                            ]) !!}
                        </td>
                        
                        <td>
                            {!! Form::text('stvalue', null, [
                                'id' => 'stvalue', 
                                'class' => 'form-control', 
                                'disabled' => 'disabled'
                            ]) !!}
                        </td>
                        
                        <td>
                            {!! Form::text('taxvalue', null, [
                                'id' => 'taxvalue', 
                                'class' => 'form-control', 
                                'disabled' => 'disabled'
                            ]) !!}
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
                                'class' => 'form-control',
                                'disabled' => 'disabled'
                            ]) !!}
                            {!! Form::hidden('extraTaxValue', null, [
                                'id' => 'extraTaxValue',
                                'class' => 'form-control'
                            ]) !!}
                        </td>
                        
                        <td>
                            {!! Form::text('ValueExTax', null, [
                                'id' => 'ValueExTax', 
                                'class' => 'form-control', 
                                'onkeyup' => 'ValueExTaxkeyup($(this).val());',
                            ]) !!}
                        </td>
                        
                        <td>
                            {!! Form::text('amount', null, [
                                'id' => 'amount', 
                                'class' => 'form-control', 
                                'disabled' => 'disabled'
                            ]) !!}
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
                                    <div class="summary-row">
                                            @if((int)($sellerCompany->discount_fixed ?? 0) === 1)
                                            <div class="stat-item">
                                                <span class="stat-label">Total Discount</span>
                                                <input type="text" class="form-control stat-value" style="background-color:#fff;"
                                                        value="0" id="discount_amount" name="discount_amount"
                                                        oninput="applyFixedDiscountToTotal()" onkeyup="applyFixedDiscountToTotal()">
                                            </div>
                                            @else
                                                <input type="hidden" id="discount_amount" name="discount_amount" value="0">
                                            @endif
                                            <input type="hidden" id="TotalAmountRaw" name="TotalAmountRaw" value="0">
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
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css">
    <script src="{{ asset('js/plugins/nouislider/nouislider.min.js') }}"></script>
    <!-- Input Mask-->
    <script src="{{ asset('js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>
    <!-- Select2-->
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <!--Bootstrap ColorPicker-->
    <script src="{{ asset('js/plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <script>
        var myData = '#myTable tbody';

$(document).ready(function() {
            function ymdToDmy(ymd) {
                if (!ymd) return '';
                var s = String(ymd).substring(0, 10);
                var p = s.split('-');
                if (p.length === 3 && p[0].length === 4) {
                    return p[2] + '-' + p[1] + '-' + p[0];
                }
                return s;
            }
            function pad2(n) {
                n = String(n);
                return n.length < 2 ? '0' + n : n;
            }
            function dmyToYmd(dmy) {
                if (!dmy) return '';
                var s = String(dmy).trim();
                var p = s.split(/[-/]/);
                if (p.length === 3 && p[2].length === 4) {
                    return p[2] + '-' + pad2(p[1]) + '-' + pad2(p[0]);
                }
                return s;
            }
            function syncInvoiceDateFromDisplay() {
                var ymd = dmyToYmd($('#date_display').val());
                if (/^\d{4}-\d{2}-\d{2}$/.test(ymd)) {
                    $('#date').val(ymd);
                }
            }
            var $dateDisplay = $('#date_display');
            if ($dateDisplay.length && typeof $dateDisplay.datepicker === 'function') {
                try { $dateDisplay.datepicker('destroy'); } catch (e) {}
                $dateDisplay.datepicker({
                    dateFormat: 'dd-mm-yy',
                    changeMonth: true,
                    changeYear: true,
                    yearRange: '2000:2100',
                    showAnim: '',
                    duration: 0,
                    beforeShow: function (input, inst) {
                        setTimeout(function () {
                            $(inst.dpDiv).css({ zIndex: 99999, opacity: 1, display: 'block' });
                        }, 0);
                    },
                    onSelect: function () { syncInvoiceDateFromDisplay(); },
                    onClose: function () { syncInvoiceDateFromDisplay(); }
                });
            }
            $dateDisplay.on('change blur', syncInvoiceDateFromDisplay);
            syncInvoiceDateFromDisplay();

            $(window).keydown(function(event) {
                // Enter→next focus handled by partials.enter-as-tab
                if (event.keyCode == 13) {
                    return;
                }
            });

            $('.btn-add-line').on('keydown', function (e) {
                if (e.key === 'Enter' || e.keyCode === 13 || ((e.key === 'Tab' || e.keyCode === 9) && !e.shiftKey)) {
                    e.preventDefault();
                    e.stopPropagation();
                    AddGridDataClick();
                }
            });

            $('#myTable tr.st-entry #amount').on('keydown', function (e) {
                if (e.key === 'Enter' || e.keyCode === 13 || ((e.key === 'Tab' || e.keyCode === 9) && !e.shiftKey)) {
                    e.preventDefault();
                    e.stopPropagation();
                    AddGridDataClick();
                }
            });
        });

        function getPosPartyValue() {
            return ($('select#party_name').val() || $('#party_id').val() || '').toString();
        }

        function getPosProductValue() {
            return ($('select#product_name').val() || $('#myTable tr.st-entry #product_id').val() || '').toString();
        }

        function focusPosProductAfterAdd() {
            var $entry = $('#myTable tr.st-entry');
            var $product = $('select#product_name');
            var onchangeAttr = $product.attr('onchange');
            $product.removeAttr('onchange');
            $product.val(null).trigger('change.select2');
            if (onchangeAttr) {
                $product.attr('onchange', onchangeAttr);
            }

            $entry.find('#product_id, #product_code, #uom_id, #quantity, #price_per_unit, #stvalue, #taxvalue, #extratax, #extraTaxValue, #extraTaxValue1, #ValueExTax, #amount').val('');

            setTimeout(function () {
                $entry.find('#product_id, #product_code, #uom_id, #quantity, #price_per_unit, #stvalue, #taxvalue, #extratax, #extraTaxValue, #extraTaxValue1, #ValueExTax, #amount').val('');
                try {
                    $product.select2('open');
                    var $search = $('.select2-container--open .select2-search__field');
                    if ($search.length) $search.focus();
                } catch (err) {
                    $product.next('.select2').find('.select2-selection').focus();
                }
            }, 80);
        }


      
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
                $("#party_name").select2("open");
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
        // if (event.keyCode == 13) {

        // }

       

        

        // $("#party_name").select2();
        // $("#party_name").next(".select2").find(".select2-selection").focus(function() {
        //     $("#party_name").select2("open");

        // });



        // $("#product_name").select2();
        // $("#product_name").next(".select2").find(".select2-selection").focus(function() {
        //     $("#product_name").select2("open");
        // });

        // $("#uom_id").select2();
        // $("#uom_id").next(".select2").find(".select2-selection").focus(function() {
        //     $("#uom_id").select2("open");
        // });
        function FurtherTaxes() {
            var checkbox = document.getElementById('FurtherTax');
            if (checkbox.checked = true) {
                document.getElementById('extratax').value = 3;
            }
        }
       
       

        function posEntryEl(id) {
            return document.querySelector('#myTable tr.st-entry #' + id) || document.getElementById(id);
        }

        function AddGridData() {
            var date = document.getElementById('date').value;
            var InvoiceNo = document.getElementById('invoice_no').value;
            var Party = getPosPartyValue();
            var ProductId = posEntryEl('product_id').value;
            var ProductCode = posEntryEl('product_code').value;
            var productVal = getPosProductValue();
            var ProductID = productVal ? productVal.split("_")[0] : (ProductId || '');
            var ProductName = productVal ? (productVal.split("_")[2] || productVal.split("_").pop()) : '';
            var UOM = (posEntryEl('uom_id').value || '').split("_").pop();
            var UOMID = (posEntryEl('uom_id').value || '').split("_")[0];
            var Quantity = posEntryEl('quantity').value;
            var Price = posEntryEl('price_per_unit').value;
            var STValue = posEntryEl('stvalue').value;
            var TaxValue = posEntryEl('taxvalue').value;
            var ExtraTax = posEntryEl('extratax').value;
            var ExtraTaxValue = posEntryEl('extraTaxValue').value;
            var ValueExTax = posEntryEl('ValueExTax').value;
            var Amount = posEntryEl('amount').value;
            var TotalTax = parseInt(TaxValue) + parseInt(ExtraTaxValue);

          
            // document.getElementById('extraTaxValue1').value  =ExtraTaxValue;
          
          
        
            var TotalRate = document.getElementById('TotalRate').value;
            var TotalTax = document.getElementById('TotalTax1').value;
            var TotalExTax = document.getElementById('TotalExTax').value;
            var TotalAmount = document.getElementById('TotalAmount').value;
            //    alert(Party);
            if(!Party || Party === '0'){
                $("select#party_name").select2('open');
            }
          else if(!ProductID || ProductID === '0')
            {
               $("select#product_name").select2('open');
            }
           else if(!Quantity || Quantity==0)
            {
               $("#myTable tr.st-entry #quantity").focus();
            }
           else if(!Price || Price==0)
            {
               $("#myTable tr.st-entry #price_per_unit").focus();
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
            
          
          
           
            var tableHtml = '<tr class="st-data-row">';
            tableHtml +=
                `<td>
                    <input name="product_id1[]" value="${ProductId}" type="hidden">
                    <input value="${ProductCode}" type="text" class="form-control" disabled>
                    <input name="product_code[]" value="${ProductCode}" type="hidden">
                </td>`;
            tableHtml +=
                `<td>
                    <input value="${ProductName}" type="text" class="form-control" disabled>
                    <input name="product_name[]" value="${ProductName}" type="hidden">
                </td>`;
            tableHtml +=
                `<td>
                    <input name="uom_id[]" value="${UOMID}" type="hidden">
                    <input value="${UOM}" type="text" class="form-control" disabled>
                </td>`;
            tableHtml +=
                `<td class="st-num">
                    <input value="${Quantity}" type="text" class="form-control" onkeyup="salequantity($(this).val(), $(this).closest('tr').index());">
                    <input name="quantity[]" value="${Quantity}" type="hidden">
                </td>`;
            tableHtml +=
                `<td class="st-num">
                    <input value="${Price}" type="text" class="form-control" onkeyup="salerate($(this).val(), $(this).closest('tr').index());">
                    <input name="rate[]" value="${Price}" type="hidden">
                </td>`;
            tableHtml +=
                `<td class="st-num">
                    <input value="${STValue}" type="text" class="form-control" disabled>
                    <input name="stvalue[]" value="${STValue}" type="hidden">
                </td>`;
            tableHtml +=
                `<td class="st-num">
                    <input value="${TaxValue}" type="text" class="form-control" disabled>
                    <input name="taxvalue[]" value="${TaxValue}" type="hidden">
                </td>`;
            tableHtml +=
                `<td>
                    <input value="${ExtraTax}" type="text" class="form-control" disabled>
                    <input name="extratax[]" value="${ExtraTax}" type="hidden">
                </td>`;
            tableHtml +=
                `<td class="st-num">
                    <input value="${ExtraTaxValue}" type="text" class="form-control" disabled>
                    <input name="extraTaxValue[]" value="${ExtraTaxValue}" type="hidden">
                </td>`;
            tableHtml +=
                `<td class="st-num">
                    <input value="${ValueExTax}" type="text" class="form-control" disabled>
                    <input name="excvalue[]" value="${ValueExTax}" type="hidden">
                </td>`;
            tableHtml +=
                `<td class="st-num">
                    <input value="${Amount}" type="text" class="form-control" disabled>
                    <input name="incvalue[]" value="${Amount}" type="hidden">
                </td>`;
            tableHtml +=
                `<td>
                    <button class="btn btn-danger btn-sm" type="button" onclick="javascript:myDeleteFunction($(this).closest('tr'));" title="Delete Row">
                        <i class="icon-trash"></i>
                    </button>
                </td>`;
            tableHtml += '</tr>';
            $('#myTable tbody').append(tableHtml);
            focusPosProductAfterAdd();
            TotalQty1();
            TotalTax1();
            TotalExTax1();
            TotalGrandAmount();
            
        }
        }

        function posNum(val) {
            return parseFloat(String(val || '').replace(/,/g, '').replace(/[^0-9.-]/g, '')) || 0;
        }

        function sumGridInputs(name) {
            var tableData = document.getElementById('myTable');
            if (!tableData) {
                return 0;
            }
            var inputs = tableData.querySelectorAll('tr.st-data-row input[name="' + name + '"]');
            var sum = 0;
            for (var i = 0; i < inputs.length; i++) {
                sum += posNum(inputs[i].value);
            }
            return sum;
        }

        function recalculatePosTotals() {
            var totalQty = sumGridInputs('quantity[]');
            var totalTax = sumGridInputs('taxvalue[]');
            var totalExTax = sumGridInputs('excvalue[]');
            var totalInc = sumGridInputs('incvalue[]');

            document.getElementById('TotalRate').value = totalQty.toLocaleString('en-US');
            document.getElementById('TotalTax1').value = totalTax.toLocaleString('en-US');
            document.getElementById('TotalExTax').value = totalExTax.toLocaleString('en-US');
            document.getElementById('TotalAmountRaw').value = totalInc;
            applyFixedDiscountToTotal();
        }

        function TotalQty1() {
            recalculatePosTotals();
        }

        function TotalTax1() {
            recalculatePosTotals();
        }

        function TotalExTax1() {
            recalculatePosTotals();
        }

        function TotalGrandAmount() {
            recalculatePosTotals();
        }

        function applyFixedDiscountToTotal() {
            var rawElement = document.getElementById('TotalAmountRaw');
            var rawValue = rawElement ? rawElement.value : document.getElementById('TotalAmount').value;
            var rawAmount = parseFloat(rawValue.toString().replace(/,/g, '').replace(/[^0-9.-]/g, '')) || 0;

            var discountElement = document.getElementById('discount_amount');
            var discountRaw = discountElement ? discountElement.value : '0';
            var discountAmount = parseFloat(discountRaw.toString().replace(/,/g, '').replace(/[^0-9.-]/g, '')) || 0;

            var netAmount = rawAmount - discountAmount;
            if (netAmount < 0) {
                netAmount = 0;
            }
            document.getElementById('TotalAmount').value = netAmount.toLocaleString('en-US');
        }

        document.getElementById('form').addEventListener('submit', function () {
            var partyId = document.getElementById('party_id').value;
            if (!partyId) {
                var partySelect = document.getElementById('party_name');
                if (partySelect && partySelect.value) {
                    document.getElementById('party_id').value = partySelect.value;
                }
            }
        });
        function AddGridDataClick() {
            AddGridData();
        }
        function salequantity(quantity, RowIndex) {
            var $row = $('#myTable tbody tr').eq(RowIndex);
            var rate = $row.find('input[name="rate[]"]').val() || $row.find('td:eq(4) input:visible').val();
            var stPct = $row.find('input[name="stvalue[]"]').val() || $row.find('td:eq(5) input:visible').val();
            var tax = ((stPct * rate) / 100) * quantity;
            var totalrate = quantity * rate;
            var totalinctax = parseFloat(totalrate) + parseFloat(tax);
            $row.find('td:eq(6) input:visible').val(tax);
            $row.find('input[name="taxvalue[]"]').val(tax);
            $row.find('td:eq(9) input:visible').val(totalrate);
            $row.find('input[name="excvalue[]"]').val(totalrate);
            $row.find('td:eq(10) input:visible').val(totalinctax);
            $row.find('input[name="incvalue[]"]').val(totalinctax);
            recalculatePosTotals();
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
            var $row = $('#myTable tbody tr').eq(RowIndex);
            var qty = $row.find('input[name="quantity[]"]').val() || $row.find('td:eq(3) input:visible').val();
            var stPct = $row.find('input[name="stvalue[]"]').val() || $row.find('td:eq(5) input:visible').val();
            var tax = ((stPct * rate) / 100) * qty;
            var totalrate = qty * rate;
            var totalinctax = parseFloat(totalrate) + parseFloat(tax);
            $row.find('td:eq(6) input:visible').val(tax);
            $row.find('input[name="taxvalue[]"]').val(tax);
            $row.find('td:eq(9) input:visible').val(totalrate);
            $row.find('input[name="excvalue[]"]').val(totalrate);
            $row.find('td:eq(10) input:visible').val(totalinctax);
            $row.find('input[name="incvalue[]"]').val(totalinctax);
            recalculatePosTotals();
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
                            $('#myTable tbody').append(newRow);

                        });
                    }
                }
            })
        }

        function SaleRateKeyUp(SaleRate, RowIndex) {

            var quantity = $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('6')").text();
            var tax = $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('9')").val();
        }

        function QuantityKeyUp() {
            var quantity = document.getElementById('quantity').value;
            var tax = document.getElementById('stvalue').value;
            var extratax = document.getElementById('extratax').value;
            var price = document.getElementById('price_per_unit').value;
            if (quantity === '' || quantity === null || String(quantity) === 'undefined' || price === '' || price === null || String(price) === 'undefined') {
                return;
            }
            var totaltax = (price / 100 * tax) * quantity;
            var extratax = (price / 100 * extratax) * quantity;
            if (isNaN(totaltax) || isNaN(extratax)) {
                return;
            }
            document.getElementById('taxvalue').value = totaltax;
            document.getElementById('extraTaxValue').value = extratax;
            // document.getElementByNamw('extraTaxValue1').value = extratax;
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

        function ValueExTaxkeyup(){
            var quantity = document.getElementById('quantity').value;
            var price = document.getElementById('price_per_unit').value;
            var ExclusiveValue = document.getElementById('ValueExTax').value;
            var rate = ExclusiveValue / quantity;
            document.getElementById('price_per_unit').value = rate;
            var tax = document.getElementById('stvalue').value;
            // alert(tax);
            var extratax = document.getElementById('extratax').value;
            var totaltax = (rate / 100 * tax) * quantity;
            // alert(totaltax);
            var extratax = (rate / 100 * extratax) * quantity;
            document.getElementById('taxvalue').value = totaltax;
            document.getElementById('extraTaxValue').value = extratax;
            total = (quantity * rate) + totaltax + extratax;
            document.getElementById('amount').value = total;
        }

        function SaleRateKeyUpForm(price) {
            var quantity = document.getElementById('quantity').value;
            var stvalue = document.getElementById('stvalue').value;
            if (price === '' || price === null || String(price) === 'undefined' || quantity === '' || quantity === null || String(quantity) === 'undefined') {
                return;
            }
            //tax value
            var tax = (stvalue / 100 * price) * quantity;
            if (isNaN(tax)) {
                return;
            }
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
            var raw = ($('select#product_name').val() || document.getElementById('product_name').value || '').toString();
            if (!raw || raw === '0') {
                return;
            }
            // alert(product)
            var productID = raw.split("_")[0];
            var productCode = raw.split("_")[1];
            var productName = raw.split("_")[2];
            var productTax = raw.split("_")[3];
            var productprice = raw.split("_")[4];
            var unit = raw.split("_")[5];
            // var productTax = document.getElementById('product_name').value.split("_").pop();
            // alert(productID)
            // alert(productCode)
            // alert(productName)
            // alert(productTax)
            var TodayRate = document.getElementById('todayRate').value;
            
            var totalRate = TodayRate * productName;

            document.getElementById('product_id').value = productID || '';
            document.getElementById('product_code').value = productCode || '';
            document.getElementById('price_per_unit').value = productprice || '';
            var taxper = document.getElementById('tax_percent').value;
            if(taxper > 0){
            document.getElementById('stvalue').value = taxper;
            }else{
            document.getElementById('stvalue').value = productTax || '';
            }
            
            document.getElementById('uom_id').value = unit || '';
            // $("#quantity").focus();


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
            // $("#quantity").focus();
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

                    // var TotalTax = document.getElementById('TotalTax1').value;
                    // var tax = $(row).find("td:eq('9')").find("input").val();
                    // var grandTax = parseInt(TotalTax) - parseInt(tax);
                    // document.getElementById('TotalTax1').value = grandTax;

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
        //     // if ($("#party_id").val() == "") {
        //     //     alert('Select Customer Account First!');
        //     //     e.preventdefault();
        //     // }
        //     // if ($("#product_name").val() == "") {
        //     //     alert('Product Name Not Selected!');
        //         // e.preventdefault();
        //     // }
        //     alertify.confirm("Are you sure you want add Sale Bill?", function(e) {
        //         if (e) {
        //             e.preventdefault();
        //             // console.log(111111111111);
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
        //             // alertify.confirm("eelo");
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

        function validateEightDecimals(input) {
            // Get current value
            let value = input.value;

            // Remove any non-digit or non-decimal characters (except first decimal)
            value = value.replace(/[^0-9.]/g, '');

            // Ensure only one decimal point
            const decimalCount = (value.match(/\./g) || []).length;
            if (decimalCount > 1) {
                value = value.substring(0, value.lastIndexOf('.'));
            }

            // Restrict to 8 decimal places
            if (value.includes('.')) {
                const [integerPart, decimalPart] = value.split('.');
                if (decimalPart.length > 8) {
                    value = `${integerPart}.${decimalPart.substring(0, 8)}`;
                }
            }

            // Update the input value
            input.value = value;
        }
    </script>
    @include('partials.enter-as-tab')
     
@stop
