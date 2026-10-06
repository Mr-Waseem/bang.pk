@extends("app")
@section('contents')

<head>
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <style>
    .alert-container {
        margin-bottom: 20px;
    }
    .stat-label{
        font-size: 14px !important;
        font-weight: 700 !important;
        color: #495057 !important;
        letter-spacing: 0.02em !important;
    }
    .stat-value {
        font-size: 18px !important;
        font-weight: 700 !important;
    }

    .alert-danger {
        border-left: 4px solid #dc3545;
    }

    .error-detail {
        font-size: 0.9em;
        color: #6c757d;
    }

    .error-code {
        font-size: 14px;
        font-weight: bold;
        color: #343a40;
    }

    body {
        background-color: #f8f9fa;
        /* padding: 20px; */
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    }

    .summary-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 15px;
    }

    .summary-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05), 0 1px 3px rgba(0, 0, 0, 0.1);
        background: #fff;
        transition: all 0.3s ease;
    }

    .summary-card:hover {
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08), 0 2px 6px rgba(0, 0, 0, 0.05);
        transform: translateY(-2px);
    }

    .card-body {
        padding: 1.5rem;
    }

    .stat-item {
        padding: 1rem 0.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
    }

    .stat-item:not(:last-child):after {
        content: '';
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        height: 40%;
        width: 1px;
        background: linear-gradient(to bottom, transparent, #e9ecef 50%, transparent);
    }

    .stat-label {
        color: #495057;
        font-size: 14px !important;
        font-weight: 700;
        letter-spacing: 0.02em;
        text-transform: uppercase;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .stat-value {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        text-align: center;
        font-weight: 700;
        font-size: 18px !important;
        color: #212529;
        padding: 0.75rem 0.5rem;
        width: 100%;
        max-width: 160px;
        transition: all 0.2s ease;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.03);
    }

    @media (min-width: 768px) {
        .stat-value {
            font-size: 18px !important;
            padding: 0.9rem 0.5rem;
        }

        .stat-label {
            font-size: 14px !important;
        }
    }

    @media (max-width: 767.98px) {
        .stat-item:after {
            display: none;
        }

        .stat-item {
            margin-bottom: 1rem;
        }

        .stat-item:last-child {
            margin-bottom: 0;
        }
    }
    /* Sales Tax form + grid (aligned with Opening Stock UI) */
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
    .st-wrap .st-meta-row:last-child {
        margin-bottom: 0;
    }
    .st-wrap .st-meta-field {
        min-width: 0;
    }
    .st-wrap .st-meta-field label {
        display: block;
        margin-bottom: 3px;
        font-size: 11px;
        font-weight: 600;
        color: #495057;
        letter-spacing: 0.02em;
        text-transform: uppercase;
    }
    /* Compact top row: Date | Remarks | DC | Vr# | Scenario | FBR Invoice # */
    .st-wrap .st-meta-row--1 .st-meta-field--date { grid-column: span 2; }
    .st-wrap .st-meta-row--1 .st-meta-field--remarks { grid-column: span 2; }
    .st-wrap .st-meta-row--1 .st-meta-field--dc { grid-column: span 2; }
    .st-wrap .st-meta-row--1 .st-meta-field--vr { grid-column: span 1; }
    .st-wrap .st-meta-row--1 .st-meta-field--scenario { grid-column: span 2; }
    .st-wrap .st-meta-row--1 .st-meta-field--fbr { grid-column: span 3; }
    /* Party row */
    .st-wrap .st-meta-row--3 .st-meta-field--party { grid-column: span 4; }
    .st-wrap .st-meta-row--3 .st-meta-field--address { grid-column: span 5; }
    .st-wrap .st-meta-row--3 .st-meta-field--ntn { grid-column: span 3; }
    .st-wrap .st-meta-row--3.st-meta-row--unreg .st-meta-field--party { grid-column: span 3; }
    .st-wrap .st-meta-row--3.st-meta-row--unreg .st-meta-field--address { grid-column: span 3; }
    .st-wrap .st-meta-row--3.st-meta-row--unreg .st-meta-field--ntn { grid-column: span 2; }
    .st-wrap .st-meta-row--3.st-meta-row--unreg .st-meta-field--cusname { grid-column: span 2; }
    .st-wrap .st-meta-row--3.st-meta-row--unreg .st-meta-field--cnic { grid-column: span 2; }
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
    .st-wrap .st-meta-field .select2-selection__arrow {
        height: 30px !important;
    }
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
        min-width: 1100px;
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
    .st-wrap .st-table tr.st-entry td {
        background: #f0f7ff;
    }
    .st-wrap .st-table tr.st-data-row td {
        background: #fff;
    }
    .st-wrap .st-table tr.st-data-row:hover td {
        background: #fafbfc;
    }
    .st-wrap .st-table .form-control {
        height: 36px;
        padding: 4px 6px;
        font-size: 14px;
        margin: 0;
    }
    .st-wrap .st-table .select2-container .select2-selection--single {
        height: 36px !important;
    }
    .st-wrap .st-table .select2-selection__rendered {
        line-height: 34px !important;
        font-size: 14px;
    }
    .st-wrap .st-table .select2-selection__arrow {
        height: 34px !important;
    }
    .st-wrap .st-num input {
        text-align: right;
    }
    .st-wrap .st-table .btn-add-line {
        min-width: 64px;
        padding: 4px 10px;
        font-size: 14px;
        font-weight: 600;
    }
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
        max-width: none;
        margin: 0 0 1rem;
        padding: 0;
    }
    @media (max-width: 991px) {
        .st-wrap .st-meta-row--1 .st-meta-field--date,
        .st-wrap .st-meta-row--1 .st-meta-field--vr { grid-column: span 4; }
        .st-wrap .st-meta-row--1 .st-meta-field--remarks,
        .st-wrap .st-meta-row--1 .st-meta-field--dc,
        .st-wrap .st-meta-row--1 .st-meta-field--scenario,
        .st-wrap .st-meta-row--1 .st-meta-field--fbr { grid-column: span 4; }
    }
    @media (max-width: 767px) {
        .st-wrap .st-meta-row--1 .st-meta-field,
        .st-wrap .st-meta-row--3 .st-meta-field {
            grid-column: span 12 !important;
        }
        .st-wrap .st-table {
            min-width: 980px;
        }
        .st-wrap .st-table .form-control {
            min-width: 70px;
        }
        .st-wrap .st-table td:nth-child(2) .form-control,
        .st-wrap .st-table th:nth-child(2) {
            min-width: 140px;
        }
    }
    </style>
</head>

<body>
    <div class="container-fluid">
        @if (Session::has('flash_message'))
        <div class="alert alert-success alert-dismissible show" role="alert" style="position: relative;">
            {{ Session::get('flash_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%); padding: 0.5rem; line-height: 1; background: transparent; border: 0; font-size: 1.5rem;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix" id="panelbg">
                    <h2 class="panel-title"><b>Debit Note</b>
                        @if($sellerCompany->st_held ==1)
                        <span style="font-size: 14px;color: #ffffff;font-weight: 600;">ST Withheld At Source enabled -
                            20% of tax value</span>
                        @endif
                    </h2>
                </div>
                @if(Session::has('error'))
                <div class="alert alert-danger">
                    <strong>Error!</strong> {{ Session::get('error') }}
                    @if(Session::has('error_details'))
                    <br>Details: {{ Session::get('error_details') }}
                    @endif
                    @if(Session::has('error_code'))
                    <br>Code: {{ Session::get('error_code') }}
                    @endif
                </div>
                @endif
                @if(request()->has('error'))
                <br />
                <div class="alert alert-danger alert-dismissible show">
                    Sale Invoice could not be Submitted. Check HS Code, Product Name, Party CNIC / NTN etc.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                <!-- @if(Session::has('error') || request()->has('error'))
                    <div class="alert-container">
                        @if(Session::has('error'))
                            <div class="alert alert-danger alert-dismissible show">
                                <strong>Error!</strong> {{ Session::get('error') }}
                                @if(Session::has('error_details'))
                                    <br><span class="error-detail">Details: {{ Session::get('error_details') }}</span>
                                @endif
                                @if(Session::has('error_code'))
                                    <br><span class="error-code">Code: {{ Session::get('error_code') }}</span>
                                @endif
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        
                        @if(request()->has('error'))
                            <div class="alert alert-danger alert-dismissible show">
                                Sale Invoice could not be Submitted. Check HS Code, Product Name, Party CNIC / NTN etc.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
                @endif -->

                <div class="panel-body">
                    <input id="token" type="hidden" value="{{ $encrypted_token }}">
                    @include('errors.validation')
                    {!! Form::open(['url' => 'debit-note', 'class' => 'form-horizontal', 'id' => 'form-submission']) !!}
                    {!! Form::hidden('company_id', session()->get('company_id'), ['id' => 'company_id']) !!}
                    {!! Form::hidden('biller', Auth::User()->id, ['id' => 'biller']) !!}
                    {!! Form::hidden('warehouse_id', 1, ['id' => 'warehouse_id']) !!}

                    {!! Form::hidden('sale_type', 'Debit Note', ['id' => 'sale_type']) !!}

                    <div class="st-wrap">
                    <div class="st-meta-section">
                        <div class="st-meta-row st-meta-row--1">
                            <div class="st-meta-field st-meta-field--date">
                                <label for="date">Date</label>
                                <input id="date" type="date" name="date" value="<?php echo date('Y-m-d'); ?>"
                                    class="form-control form-control-sm" autofocus>
                            </div>
                            <div class="st-meta-field st-meta-field--remarks">
                                <label for="remarks">Remarks</label>
                                {!! Form::text('remarks', null, ['id' => 'remarks', 'class' => 'form-control form-control-sm']) !!}
                            </div>
                            <div class="st-meta-field st-meta-field--dc">
                                <label for="dcn_no">DC NO</label>
                                {!! Form::select('dcn_no', $DeliveryChallan, null, ['id' => 'dcn_no',
                                'onchange' => 'dcKeyUp($(this).val());',
                                'class' => 'form-control form-control-sm']) !!}
                            </div>
                            <div class="st-meta-field st-meta-field--vr">
                                <label for="invoice_no">Vr#</label>
                                {!! Form::text('invoice_no', $codes, ['id' => 'invoice_no', 'class' => 'form-control form-control-sm', 'required' => 'required', 'readonly' => 'readonly']) !!}
                            </div>
                            <div class="st-meta-field st-meta-field--scenario">
                                <label for="scenario_id">Scenario</label>
                                {!! Form::select('scenario_id', $scenarios, null, ['id' => 'scenario_id', 'class' => 'form-select form-select-sm', 'required' => 'required']) !!}
                            </div>
                            <div class="st-meta-field st-meta-field--fbr">
                                <label for="ref_usin">FBR Invoice #</label>
                                {!! Form::text('ref_usin', null, ['id' => 'ref_usin', 'class' => 'form-control form-control-sm']) !!}
                            </div>
                        </div>
                        <div class="st-meta-row st-meta-row--3">
                            <div class="st-meta-field st-meta-field--party">
                                <label for="party_name">Select Party</label>
                                {!! Form::hidden('party_id', null, ['id' => 'party_id', 'class' => 'form-control']) !!}
                                {!! Form::select('party_name', $customers, null, [
                                'id' => 'party_name',
                                'onchange' => 'PartyKeyUp($(this).val());',
                                'class' => 'form-control']) !!}
                            </div>
                            <div class="st-meta-field st-meta-field--address">
                                <label for="address">Address</label>
                                {!! Form::text('address', null, ['id' => 'address', 'class' => 'form-control form-control-sm st-readonly', 'placeholder' => 'Address', 'disabled' => 'disabled']) !!}
                            </div>
                            <div class="st-meta-field st-meta-field--ntn">
                                <label for="ntn">NTN</label>
                                {!! Form::text('ntn', null, ['id' => 'ntn', 'class' => 'form-control form-control-sm st-readonly', 'placeholder' => 'NTN', 'disabled' => 'disabled']) !!}
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
                                            <th width="5%">Extra%</th>
                                            <th width="8%">Val ExTax</th>
                                            <th width="10%">Total</th>
                                            <th width="8%">SRO.sch#</th>
                                            <th width="8%">SRO.Item#</th>
                                            <th width="8%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="st-entry">
                                            {!! Form::hidden('product_id', null, ['id' => 'product_id', 'class' =>
                                            'form-control']) !!}
                                            <td>{!! Form::text('product_code', null, ['id' => 'product_code', 'class' =>
                                                'form-control input-sm']) !!}</td>

                                            <td>
                                                {!! Form::select('product_name', $products, null, [
                                                'id' => 'product_name',
                                                'class' => 'form-control input-sm',
                                                'onchange' => 'ProductKeyUp($(this).val().split("_").pop(),
                                                $(this).val().split("_")[0]);'
                                                ]) !!}
                                            </td>

                                            <td style="display:none;">
                                                {!! Form::text('uom_id', null, [
                                                'id' => 'uom_id',
                                                'class' => 'form-control input-sm',
                                                'readonly' => 'readonly'
                                                ]) !!}
                                            </td>

                                            <td>
                                                {!! Form::text('uom', null, [
                                                'id' => 'uom',
                                                'class' => 'form-control input-sm',
                                                'readonly' => 'readonly'
                                                ]) !!}
                                            </td>

                                            <td>
                                                {!! Form::text('quantity', null, [
                                                'id' => 'quantity',
                                                'class' => 'form-control input-sm',
                                                'oninput' => 'validateTwoDecimals(this)',
                                                'onkeyup' => 'QuantityKeyUp($(this).val())',
                                                'onkeypress' => 'return onlyNumberKey(event)',
                                                'onpaste' => 'return false;',
                                                'ondrop' => 'return false;',
                                                'autocomplete' => 'off',
                                                'onfocus' => 'this.value=""'
                                                ]) !!}
                                            </td>
                                            <td>
                                                {!! Form::text('price_per_unit', null, [
                                                'id' => 'price_per_unit',
                                                'class' => 'form-control input-sm',
                                                'onkeypress' => 'return onlyNumberKey(event)',
                                                'oninput' => 'validateTwoDecimals(this)',
                                                'onkeyup' => 'SaleRateKeyUpForm($(this).val())',
                                                'onpaste' => 'return false;',
                                                'ondrop' => 'return false;',
                                                'autocomplete' => 'off',
                                                ]) !!}
                                            </td>
                                            <td>
                                                {!! Form::text('stvalue', null, [
                                                'id' => 'stvalue',
                                                'class' => 'form-control input-sm',
                                                'disabled' => 'disabled'
                                                ]) !!}
                                            </td>
                                            <td>
                                                {!! Form::text('taxvalue', null, [
                                                'id' => 'taxvalue',
                                                'class' => 'form-control input-sm',
                                                'disabled' => 'disabled'
                                                ]) !!}
                                            </td>
                                            <td>
                                                {!! Form::text('extratax', null, [
                                                'id' => 'extratax',
                                                'class' => 'form-control input-sm',
                                                'onkeyup' => 'ExtraTaxkeyup($(this).val());',
                                                'onkeypress' => 'return onlyNumberKey(event)',
                                                'onfocus' => 'this.value=""'
                                                ]) !!}
                                            </td>

                                            <td style="display:none">
                                                {!! Form::text('extraTaxValue', null, [
                                                'id' => 'extraTaxValue',
                                                'class' => 'form-control input-sm',
                                                'disabled' => 'disabled'
                                                ]) !!}
                                            </td>

                                            <td>
                                                {!! Form::text('ValueExTax', null, [
                                                'id' => 'ValueExTax',
                                                'class' => 'form-control input-sm',
                                                'disabled' => 'disabled'
                                                ]) !!}
                                            </td>

                                            <td>
                                                {!! Form::text('amount', null, [
                                                'id' => 'amount',
                                                'class' => 'form-control input-sm',
                                                'disabled' => 'disabled'
                                                ]) !!}
                                            </td>
                                            <td>
                                                {!! Form::select('sro_schd_no1', $sroschedule, null, [
                                                'id' => 'sro_schd_no1',
                                                'class' => 'form-control input-sm'
                                                ]) !!}
                                            </td>
                                            <td>
                                                {!! Form::select('sro_item_no1', $sroitem, null, [
                                                'id' => 'sro_item_no1',
                                                'class' => 'form-control input-sm'
                                                ]) !!}
                                            </td>

                                            <td>
                                                <button type="button" onclick="AddGridData()" onkeyup="AddGridData()"
                                                    class="btn btn-success btn-sm btn-add-line">
                                                    Add
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
                    <!-- <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading clearfix">
                                        <div class="container">
                                            <div class="col-xs-2">
                                            </div>
                                            <div class="col-xs-2" style=""><b>Total Qty</b> <input type="text"
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
                                <button type="button" class="btn btn-primary submit-form" id="btnSave" name="btnSave">Save</button>
                               
                            </div>
                        </center> -->
                    <!-- <div class="row mb-4">
                            <div class="col-12">
                                <div class="card border-0 shadow">
                                    <div class="card-body py-3">
                                        <div class="row align-items-center text-center">
                                            <div class="col-6 col-md-2 mb-3 mb-md-0">
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="text-secondary small font-weight-bold mb-1">TOTAL QTY</span>
                                                    <input type="text" class="form-control bg-light text-center border-0 font-weight-bold fs-5" 
                                                        value="0" id="TotalQty" name="TotalQty" readonly>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-2 mb-3 mb-md-0">
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="text-secondary small font-weight-bold mb-1">TOTAL TAX</span>
                                                    <input type="text" class="form-control bg-light text-center border-0 font-weight-bold fs-5" 
                                                        value="0" id="TotalTaxValue" name="TotalTaxValue" readonly>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-2">
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="text-secondary small font-weight-bold mb-1">VALUE EX.TAX</span>
                                                    <input type="text" class="form-control bg-light text-center border-0 font-weight-bold fs-5" 
                                                        value="0" id="TotalExTax" name="TotalExTax" readonly>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-2">
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="text-secondary small font-weight-bold mb-1">VALUE INC.TAX</span>
                                                    <input type="text" class="form-control bg-light text-center border-0 font-weight-bold fs-5" 
                                                        value="0" id="TotalAmount" name="TotalAmount" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    <div class="summary-container">
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card summary-card">
                                    <div class="card-body py-3">
                                        <div class="row align-items-center text-center">
                                            <div class="col-6 col-md-3 stat-item">
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="stat-label">
                                                        <i class="fas fa-cube fa-xs"></i>TOTAL QTY
                                                    </span>
                                                    <input type="text" class="form-control stat-value" value="0"
                                                        id="TotalQty" name="TotalQty" readonly>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3 stat-item">
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="stat-label">
                                                        <i class="fas fa-receipt fa-xs"></i>TOTAL TAX
                                                    </span>
                                                    <input type="text" class="form-control stat-value" value="0"
                                                        id="TotalTaxValue" name="TotalTaxValue" readonly>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3 stat-item">
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="stat-label">
                                                        <i class="fas fa-file-invoice-dollar fa-xs"></i>VALUE EX.TAX
                                                    </span>
                                                    <input type="text" class="form-control stat-value" value="0"
                                                        id="TotalExTax" name="TotalExTax" readonly>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3 stat-item">
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="stat-label">
                                                        <i class="fas fa-money-bill-wave fa-xs"></i>VALUE INC.TAX
                                                    </span>
                                                    <input type="text" class="form-control stat-value" value="0"
                                                        id="TotalAmount" name="TotalAmount" readonly>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3 stat-item">
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="stat-label">
                                                        <i class="fas fa-money-bill-wave fa-xs"></i>Advance Income Tax %
                                                    </span>
                                                    <input type="text" id="advance_income_tax" name="advance_income_tax"
                                                        onkeyup="AdvanceIncomeTax($(this).val())"
                                                        class="form-control stat-value" style="background-color: white">
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3 stat-item">
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="stat-label">
                                                        <i class="fas fa-money-bill-wave fa-xs"></i>Total Income Tax
                                                    </span>
                                                    <input type="text" id="total_income_tax" name="total_income_tax"
                                                        class="form-control stat-value" readonly>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3 stat-item">
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="stat-label">
                                                        <i class="fas fa-money-bill-wave fa-xs"></i>Total Amount
                                                    </span>
                                                    <input type="text" id="GrandAmount" name="GrandAmount"
                                                        class="form-control stat-value" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-12 text-center">
                            <button type="button" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm"
                                id="btnSave" name="btnSave">
                                <i class="fa fa-save mr-2"></i> Save Invoice
                            </button>
                        </div>
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

<script>
$("#party_name").select2();
$("#party_name").next(".select2").find(".select2-selection").focus(function() {
    $("#party_name").select2("open");
});


$("#scenario_id").select2();
$("#scenario_id").next(".select2").find(".select2-selection").focus(function() {
    $("#scenario_id").select2("open");
});


$("#dcn_no").select2();
$("#dcn_no").next(".select2").find(".select2-selection").focus(function() {
    $("#dcn_no").select2("open");
});

$("#product_name").select2();
$("#product_name").next(".select2").find(".select2-selection").focus(function() {
    $("#product_name").select2("open");
});


$("#sro_schd_no1").select2();
$("#sro_schd_no1").next(".select2").find(".select2-selection").focus(function() {
    $("#sro_schd_no1").select2("open");
});
$("#sro_item_no1").select2();
$("#sro_item_no1").next(".select2").find(".select2-selection").focus(function() {
    $("#sro_item_no1").select2("open");
});
</script>



<script type="text/javascript">
// $('#party_name').change(function() {
//     $('#party_name').select2().trigger('select2:close');
//     $("#product_code").focus();
// });

// $('#product_name').change(function() {
//      $('#product_name').select2().trigger('select2:close');
//     //  $('#product_name').select2('open');
//     $("#quantity").focus();
// });

// $('#product_name').onkeyup(function() {
//     // $('#product_name').select2().trigger('select2:close');
//     $('#product_name').select2('open');
// });



function FurtherTaxes() {
    var checkbox = document.getElementById('FurtherTax');
    if (checkbox.checked = true) {
        document.getElementById('extratax').value = 3;

    }
}

function AddGridData() {
    var date = document.getElementById('date').value;
    // var InvoiceNo = document.getElementById('voucher_no').value;
    var ProductId = document.getElementById('product_id').value;
    var ProductCode = document.getElementById('product_code').value;
    var ProductID = document.getElementById('product_name').value.split("_")[0];
    var ProductName = document.getElementById('product_name').value.split("_")[2];
    var UOM = document.getElementById('uom').value;
    var UOMID = document.getElementById('uom_id').value;
    var Quantity = document.getElementById('quantity').value;
    var Price = document.getElementById('price_per_unit').value;
    var STValue = document.getElementById('stvalue').value;
    var TaxValue = document.getElementById('taxvalue').value;
    var ExtraTax = document.getElementById('extratax').value;
    var ExtraTaxValue = document.getElementById('extraTaxValue').value;
    var ValueExTax = document.getElementById('ValueExTax').value;
    var SroSchd = document.getElementById('sro_schd_no1').value.split("_")[1] ?? "";
    var SroItem = document.getElementById('sro_item_no1').value;
    var Amount = document.getElementById('amount').value;
    var TotalTax = parseInt(TaxValue) + parseInt(ExtraTaxValue);

    if ((ProductId) == "" || (ProductId) == 0) {
        // alert('Select Product First!');
        document.getElementById("product_code").focus();
        Swal.fire('Select Product First!');
        e.preventdefault();
    }

    if ((Quantity) == "" || (Quantity) == 0 || (Quantity) == 'NaN') {
        // alert('Quantity Cant be Empty or 0!');
        document.getElementById("quantity").focus();
        Swal.fire('Quantity Cant be Empty or 0!');
        e.preventdefault();
    }

    if ((Price) == "" || (Price) == 0 || (Price) == 'NaN') {
        document.getElementById("price_per_unit").focus();
        // alert('Price Cant be Empty or 0!');
        Swal.fire('Price Cant be Empty or 0!');
        e.preventdefault();
    }
    // alert(ProductId)
    // alert(ProductID)

    var tableHtml = '<tr>';

    tableHtml += `<td style="display:none;">
                <input id="test" value="${ProductId}" type="text" class="form-control input-sm" disabled>
                <input id="product_id1" name="product_id1[]" value="${ProductId}" type="hidden">
              </td>`;

    tableHtml += `<td width="7%">
                <input id="test" value="${ProductCode}" type="text" class="form-control input-sm" disabled>
                <input id="product_code" name="product_code[]" value="${ProductCode}" type="hidden">
              </td>`;

    tableHtml += `<td style="display:none;">
                <input id="test" value="${ProductID}" type="text" class="form-control input-sm" disabled>
              </td>`;

    tableHtml += `<td width="15%">
                <input id="test" value="${ProductName}" type="text" class="form-control input-sm" disabled>
                <input id="product_name" value="${ProductName}" name="product_name[]" type="hidden">
              </td>`;

    tableHtml += `<td style="display:none;">
                <input id="uom_id" name="uom_id[]" value="${UOMID}" type="hidden">
              </td>`;

    tableHtml += `<td width="5%">
                <input id="uom" name="uom[]" value="${UOM}" type="text" class="form-control input-sm" readonly>
              </td>`;

    tableHtml += `<td width="6%">
                <input id="test" value="${Quantity}" type="text" class="form-control input-sm" onkeyup="salequantity($(this).val(), $(this).closest('tr').index());">
                <input id="quantity" name="quantity[]" value="${Quantity}" type="hidden">
              </td>`;

    tableHtml += `<td width="6%">
                <input id="test" value="${Price}" type="text" class="form-control input-sm" disabled>
                <input id="rate" name="rate[]" value="${Price}" type="hidden">
              </td>`;

    tableHtml += `<td width="5%">
                <input id="test" value="${STValue}" type="text" class="form-control input-sm" disabled>
                <input id="stvalue" name="stvalue[]" value="${STValue}" type="hidden">
              </td>`;

    tableHtml += `<td width="8%">
                <input id="test" value="${TaxValue}" type="text" class="form-control input-sm" disabled>
                <input id="taxvalue" name="taxvalue[]" value="${TaxValue}" type="hidden">
              </td>`;

    tableHtml += `<td width="5%">
                <input id="test" value="${ExtraTax}" type="text" class="form-control input-sm" disabled>
                <input id="extratax" name="extratax[]" value="${ExtraTax}" type="hidden">
              </td>`;

    tableHtml += `<td style="display:none;">
                <input id="test" value="${ExtraTaxValue}" type="text" class="form-control input-sm" disabled>
                <input id="extraTaxValue" name="extraTaxValue[]" value="${ExtraTaxValue}" type="hidden">
              </td>`;

    tableHtml += `<td width="8%">
                <input id="test" value="${ValueExTax}" type="text" class="form-control input-sm" disabled>
                <input id="excvalue" name="excvalue[]" value="${ValueExTax}" type="hidden">
              </td>`;

    tableHtml += `<td width="10%">
                <input id="test" value="${Amount}" type="text" class="form-control input-sm" disabled>
                <input id="incvalue" name="incvalue[]" value="${Amount}" type="hidden">
              </td>`;

    tableHtml += `<td style="display:none;">
                <input id="test" value="${TotalTax}" type="text" class="form-control input-sm" disabled>
                <input id="TotalTax" name="TotalTax[]" value="${TotalTax}" type="hidden">
              </td>`;

    tableHtml += `<td width="8%">
                <input id="sro_schd_no" value="${SroSchd}" name="sro_schd_no[]" type="text" class="form-control input-sm" readonly>
              </td>`;

    tableHtml += `<td width="8%">
                <input id="sro_item_no" value="${SroItem}" name="sro_item_no[]" type="text" class="form-control input-sm" readonly>
              </td>`;

    tableHtml += `<td width="8%">
                <button type="button" onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="btn btn-danger btn-sm">
                  Delete
                </button>
              </td>`;

    tableHtml += '</tr>';
    $('#myData').append(tableHtml);
    $('#product_code').val(null);
    $('#product_name').val(null);
    $('#product_name').select2('open');

    $('#quantity').val(null);
    $('#price_per_unit').val(null);
    $('#stvalue').val(null);
    $('#taxvalue').val(null);
    $('#extratax').val(null);
    $('#ValueExTax').val(null);
    $('#amount').val(null);
    TotalQuantity();
    TotalTaxes();
    TotalExTax();
    TotalAmount();
    // $('#product_name').val(0).select2();
    // document.getElementById("product_code").focus();
}

function TotalQuantity() {
    var tableData = document.getElementById('myData');
    var sum = 0;
    for (var i = 0; i < tableData.rows.length; i++) {
        if (tableData.rows[i].cells[6].getElementsByTagName('input')[0].value == '') {
            sum += 0;
        } else {
            sum += parseFloat(tableData.rows[i].cells[6].getElementsByTagName('input')[0].value);
            // alert(sum);
        }
    }
    document.getElementById('TotalQty').value = sum.toLocaleString('en-US');
}


function TotalTaxes() {
    var tableData = document.getElementById('myData');
    var sum = 0;
    for (var i = 0; i < tableData.rows.length; i++) {
        if (tableData.rows[i].cells[9].getElementsByTagName('input')[0].value == '') {
            sum += 0;
        } else {
            sum += parseFloat(tableData.rows[i].cells[9].getElementsByTagName('input')[0].value);
            // alert(sum);
        }
    }
    document.getElementById('TotalTaxValue').value = sum.toLocaleString('en-US');
}


function TotalExTax() {
    var tableData = document.getElementById('myData');
    var sum = 0;
    for (var i = 0; i < tableData.rows.length; i++) {
        if (tableData.rows[i].cells[12].getElementsByTagName('input')[0].value == '') {
            sum += 0;
        } else {
            sum += parseFloat(tableData.rows[i].cells[12].getElementsByTagName('input')[0].value);
            // alert(sum);
        }
    }
    document.getElementById('TotalExTax').value = sum.toLocaleString('en-US');
}


function TotalAmount() {
    var tableData = document.getElementById('myData');
    var sum = 0;
    for (var i = 0; i < tableData.rows.length; i++) {
        if (tableData.rows[i].cells[13].getElementsByTagName('input')[0].value == '') {
            sum += 0;
        } else {
            sum += parseFloat(tableData.rows[i].cells[13].getElementsByTagName('input')[0].value);
            // alert(sum);
        }
    }
    document.getElementById('TotalAmount').value = sum.toLocaleString('en-US');
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
    document.getElementById('taxvalue').value = totaltax.toFixed(2);
    document.getElementById('extraTaxValue').value = extratax;
    var valueWithoutTax = quantity * price;
    document.getElementById('ValueExTax').value = valueWithoutTax.toFixed(2);
    total = (quantity * price) + totaltax + extratax;
    document.getElementById('amount').value = total.toFixed(2);
}

function AdvanceIncomeTax(advancetax) {
    // alert(advancetax);
    var TotalAmount1 = document.getElementById('TotalAmount').value;
    TotalAmount = TotalAmount1.replace(/[^0-9.-]/g, '');
    // alert(TotalAmount);

    var totaladvancetax = TotalAmount / 100 * advancetax;
    document.getElementById('total_income_tax').value = totaladvancetax.toFixed(2);

    var grandtotal1 = parseFloat(TotalAmount) + parseFloat(totaladvancetax);
    // alert(grandtotal1);
    document.getElementById('GrandAmount').value = grandtotal1;

    // alert(totaladvancetax);
}

function SaleRateKeyUpForm(price) {
    var quantity = document.getElementById('quantity').value;
    // var stvalue = document.getElementById('stvalue').value;
    var stvalue = document.getElementById('stvalue').value;
    // alert(quantity)
    // alert(price)
    // alert(stvalue)
    // var price = document.getElementById('price_per_unit').value;
    //tax value
    var tax = (stvalue / 100 * price) * quantity;
    document.getElementById('taxvalue').value = tax.toFixed(2);

    //extra tax value
    var extrataxvalue = document.getElementById('extratax').value;
    var extratax = (extrataxvalue / 100 * price) * quantity;
    document.getElementById('extraTaxValue').value = extratax.toFixed(2);

    var total = quantity * price;
    var totalValue = total + tax + extratax;
    document.getElementById('ValueExTax').value = total.toFixed(2);
    document.getElementById('amount').value = totalValue.toFixed(2);
}

function validateTwoDecimals(input) {
    // Get current value
    let value = input.value;

    // Remove any non-digit or non-decimal characters (except first decimal)
    value = value.replace(/[^0-9.]/g, '');

    // Ensure only one decimal point
    const decimalCount = (value.match(/\./g) || []).length;
    if (decimalCount > 1) {
        value = value.substring(0, value.lastIndexOf('.'));
    }

    // Restrict to 2 decimal places
    if (value.includes('.')) {
        const [integerPart, decimalPart] = value.split('.');
        if (decimalPart.length > 2) {
            value = `${integerPart}.${decimalPart.substring(0, 2)}`;
        }
    }

    // Update the input value
    input.value = value;
}

function ExtraTaxkeyup(taxvalue) {
    var quantity = document.getElementById('quantity').value;
    var price = document.getElementById('price_per_unit').value;
    var stvalue = document.getElementById('stvalue').value;
    var tax = (stvalue / 100 * price) * quantity;
    var extratax = (taxvalue / 100 * price) * quantity;

    document.getElementById('extraTaxValue').value = extratax.toFixed(2);
    var total = quantity * price;
    var totalValue = total + tax + extratax;
    document.getElementById('ValueExTax').value = total.toFixed(2);
    document.getElementById('amount').value = totalValue.toFixed(2);
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

function taxcalculations(row){
    // alert(row);

    var quantity = $(row).find("td:eq('6')").find('input').val();
    var price = $(row).find("td:eq('7')").find('input').val();
    var tax = $(row).find("td:eq('8')").find('input').val();
    var extratax = $(row).find("td:eq('10')").find('input').val();

    // var tax = document.getElementById('stvalue').value;
    // var extratax = document.getElementById('extratax').value;
    // var price = document.getElementById('price_per_unit').value;
    var totaltax = parseFloat((price / 100 * tax) * quantity).toFixed(2);
    var extratax = parseFloat((price / 100 * extratax) * quantity).toFixed(2);
    $(row).find("td:eq('9')").find('input').val(totaltax)
    $(row).find("td:eq('11')").find('input').val(extratax)
    // document.getElementById('extraTaxValue').value = extratax;
    var valueWithoutTax = parseFloat(quantity * price).toFixed(2);
    $(row).find("td:eq('12')").find('input').val(valueWithoutTax)
    // document.getElementById('ValueExTax').value = valueWithoutTax.toFixed(2);
    total = parseFloat((quantity * price) + parseFloat(totaltax) + parseFloat(extratax)).toFixed(2);
    $(row).find("td:eq('13')").find('input').val(total)
    // document.getElementById('amount').value = total.toFixed(2);
        TotalQuantity();
    TotalTaxes();
    TotalExTax();
    TotalAmount();
}


// on javascript onclick on product dropdown 
function ProductKeyUp(ProductName, ProductID) {
    // alert("dfsd");
    $.ajax({
        type: "GET",
        url: "{{ asset('purchasetaxproductkeyup-ajax') }}?product_ID=" + ProductID,
        success: function(result) {
            if (result.length > 0) {

                $('#product_code').val(result[0].product_code);
                $('#product_id').val(result[0].id);
                $("#packing_type").val(result[0].catagory_name);
                $("#price_per_unit").val(result[0].product_price);
                $("#uom_id").val(result[0].uom_id);
                $("#uom").val(result[0].uom);

                if (result[0].tax == 999) {
                    $("#stvalue").val("0");
                    var stvalue = $("#stvalue").val("0");
                } else {
                    $("#stvalue").val(result[0].tax);
                    var stvalue = $("#stvalue").val();
                }

                var price = $("#price_per_unit").val();
                var quantity = $("#quantity").val();
                var extratax = $("#extratax").val();
                var tax = parseInt((stvalue / 100 * price) * quantity);
                var extratax = parseInt((extratax / 100 * price) * quantity);
                document.getElementById('taxvalue').value = tax;
                document.getElementById('extraTaxValue').value = extratax;
                var total = price * quantity;
                var grand = tax + extratax + total;
                // alert(total+2);
                // document.getElementById('value').value = total;
                document.getElementById('amount').value = grand;

                // $('#product_name').select2().trigger('select2:close');
                //     //  $('#product_name').select2('open');
                $("#quantity").focus();
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

function PartyKeyUp(partyID) {
    // alert(partyID);
    $.ajax({
        type: "GET",
        url: "{{ asset('taxpartyonchange-ajax') }}?party_ID=" + partyID,
        success: function(result) {
            if (result.length > 0) {
                $("#product_code").focus();
                $('#party_id').val(result[0].id);
                $('#address').val(result[0].address);
                $('#strn').val(result[0].strn);
                $('#ntn').val(result[0].ntn);
            } else {
                $('#party_id').val("");
                $('#address').val("");
                $('#strn').val("");
                $('#ntn').val("");
            }
        }
    });
}

function dcKeyUp(dnco) {
    //  alert(dnco);
    $.ajax({
        type: "GET",
        url: "{{ asset('dconchange-ajax') }}?dc=" + dnco,
        success: function(result) {
         $.each(result.data.challan_details, function(i, v) {
            // alert("dfsd");
            var tableHtml = '<tr>';

            tableHtml += `<td style="display:none;">
                <input id="product_id1" name="product_id1[]" value="${v.product_id}" class="form-control input-sm" type="hidden">
              </td>`;

            tableHtml += `<td width="7%">
                <input id="product_code" name="product_code[]" value="${v.products.product_code}" class="form-control input-sm" readonly>
              </td>`;

            tableHtml += `<td style="display:none;">
                <input id="test" value="${v.product_id}" type="text" class="form-control input-sm" disabled>
              </td>`;

            tableHtml += `<td width="15%">
                <input id="product_name" name="product_name[]" value="${v.products.product_name}" class="form-control input-sm" readonly>
              </td>`;

            tableHtml += `<td style="display:none;">
                <input id="uom_id" name="uom_id[]" value="${v.uom_id}" type="hidden">
              </td>`;

            tableHtml += `<td width="5%">
                <input id="uom" name="uom[]" value="${v.uom}" type="text" class="form-control input-sm" readonly>
              </td>`;

            tableHtml += `<td width="6%">
                <input id="quantity" name="quantity[]" value="${v.quantity}" class="form-control input-sm" onkeyup="taxcalculations($(this).closest('tr'));">
              </td>`;

            tableHtml += `<td width="6%">
                <input id="rate" name="rate[]" class="form-control input-sm" onkeyup="taxcalculations($(this).closest('tr'));">
              </td>`;

            tableHtml += `<td width="5%">
                <input id="stvalue" name="stvalue[]" value="${v.products.tax}" class="form-control input-sm" readonly>
              </td>`;

            tableHtml += `<td width="8%">
                <input id="taxvalue" name="taxvalue[]" type="text" class="form-control input-sm" readonly>
              </td>`;

            tableHtml += `<td width="5%">
                <input id="extratax" name="extratax[]" class="form-control input-sm" onkeyup="taxcalculations($(this).closest('tr'));">
              </td>`;

            tableHtml += `<td style="display:none;">
                <input id="extraTaxValue" name="extraTaxValue[]" class="form-control input-sm" type="hidden">
              </td>`;

            tableHtml += `<td width="8%">
                <input id="excvalue" name="excvalue[]" class="form-control input-sm" readonly>
              </td>`;

            tableHtml += `<td width="10%">
                <input id="incvalue" name="incvalue[]" class="form-control input-sm" readonly>
              </td>`;

            tableHtml += `<td style="display:none;">
                <input id="TotalTax" name="TotalTax[]" class="form-control input-sm">
              </td>`;

            tableHtml += `<td width="8%">
                <input id="sro_schd_no" value="" name="sro_schd_no[]" type="text" class="form-control input-sm" readonly>
              </td>`;

            tableHtml += `<td width="8%">
                <input id="sro_item_no" value="" name="sro_item_no[]" type="text" class="form-control input-sm" readonly>
              </td>`;

            tableHtml += `<td width="8%">
                <button type="button" onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="btn btn-danger btn-sm">
                  Delete
                </button>
              </td>`;

            tableHtml += '</tr>';
            $('#myData').append(tableHtml);
          });
    TotalQuantity();
    TotalTaxes();
    TotalExTax();
    TotalAmount();




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
            $(row).remove();
            TotalQuantity();
            TotalTaxes();
            TotalExTax();
            TotalAmount();

            //alertify.alert("File is Removed!");
        }

    });
}

$('#scenario_id').change(function() {
    var scenario_id = $(this).val();
    $.ajax({
        url: "{{ asset('sro-item/getsroitem/scenarion') }}",
        type: 'get',
        data: {
            scenario_id: scenario_id
        },
        dataType: 'json',
        success: function(response) {
            if (response.data != '') {
                // alert("suc");
                var option = '';
                option += `<option value="">Select Schedule</option>`;
                $.each(response.data, function(i, v) {
                    option +=
                        `<option value="${v.id}_${v.sro_schedule_name}">${v.sro_schedule_name}</option>`;
                });
                $('#sro_schd_no1').html(option);
                // $("#sro_schd_no1").select2('open');
            } else {
                var option = '';
                option += `<option value="0">No Records Found</option>`;
                $('#sro_schd_no1').html(option);
            }
        }
    });
});

$('#sro_schd_no1').change(function() {
    // var sro_schd_id = $(this).val();
    var sro_schd_id = $(this).val().split("_")[0];
    var scenario_id = $("#scenario_id").val();
    $.ajax({
        url: "{{ asset('sro-item/getsroschd/getsroitem') }}",
        type: 'get',
        data: {
            sro_schd_id: sro_schd_id,
            scenario_id: scenario_id
        },
        dataType: 'json',
        success: function(response) {
            if (response.data != '') {
                // alert("suc");
                var option = '';
                option += `<option value="">Choose</option>`;
                $.each(response.data, function(i, v) {
                    option += `<option value="${v.sro_item_no}">${v.sro_item_no}</option>`;
                });
                $('#sro_item_no1').html(option);
                // $("#sro_schd_no1").select2('open');
            } else {
                var option = '';
                option += `<option value="">No Records Found</option>`;
                $('#sro_item_no1').html(option);
            }
        }
    });
});



$("#btnSave").click(function() {
    // alert("dd");
    // $('#btnSave').attr('disabled', true);
        if($('#scenario_id').val() == '') {
        //  alert('Please Select Supplier');
        Swal.fire('Select Scenario First');
        //  $('#party_name').select2('open');
        return false;
    }
         if ($('#ref_usin').val() == '') {
        //  alert('Please Select Supplier');
        Swal.fire('FBR Invoice No Required!');
        //  $('#party_name').select2('open');
        return false;
    }
    if ($('#party_id').val() == '') {
        //  alert('Please Select Supplier');
        Swal.fire('Select Party First');
        //  $('#party_name').select2('open');
        return false;
    }



    var products = [];
    $.each($("#myData tr"), function(index, row) {
        var columns = $(row).find("td");
        var product = new Object();
        product.party_id = $("#party_id").val();
        product.product_code = $(columns[1]).find("input").val();

        products.push(product);
    });
    if (products != "") {
        $('#form-submission').submit();
        $('.submit-form').attr('disabled', true);
    } else {
        Swal.fire('Add your products in Grid');
        //  $('#product_name').select2('open');
        // e.preventdefault();
    }

});

// $("#btnSave").click(function() {
//     // $('#btnSave').attr('disabled', true);
//     if ($('#party_id').val() == '') {
//                 //  alert('Please Select Supplier');
//                  Swal.fire('Select Party First');
//                 //  $('#party_name').select2('open');
//                  return false;
//             }

//     Swal.fire({
//             title: "Are You Sure?",
//             text: "Confirm Transaction?",
//             icon: 'warning',
//             showCancelButton: true,
//             confirmButtonText: 'Yes, Create it!',
//             confirmButtonColor: '#28A745',
//             cancelButtonText: 'No, cancel!',
//             cancelButtonColor: '#DC3545',
//         }).then((result) => {
//             if (result.isConfirmed) {
//                 // $('#btnSave').attr('disabled', true);
//                 var purchase = new Object();
//             purchase.date = $("#date").val();
//             purchase.warehouse_id = $("#warehouse_id").val();
//             purchase.invoice_no = $("#invoice_no").val();
//             purchase.dcn_no = $("#dcn_no").val();
//             purchase.scenario_id = $("#scenario_id").val();
//             purchase.p_order = $("#p_order").val();
//             purchase.sale_type = $("#sale_type").val();
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
//                 product.product_code = $(columns[1]).find("input").val();
//                 product.product_id = $(columns[2]).find("input").val();
//                 product.product_name = $(columns[3]).find("input").val();
//                 product.uom_id = $(columns[4]).find("input").val();
//                 product.uom = $(columns[5]).find("input").val();
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
//                 url: "{{ asset('salestax') }}",
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
//                         window.open("../salestax/" + result);
//                         window.location.href = "{{ asset('salestax/create') }}";
//                         //window.open("/sales/print/"+result);
//                         //alert("Sale successfully saved.");
//                         //Session::flash('flash_message', 'Sale Added Successfully!');
//                         //window.location.href = "/sales";

//                     }else{
//                         // alert(1);
//                         // window.location.href = "{{ asset('salestax/create') }}?error=1";
//                     }
//                 },
//                 error: function(xhr, ajaxOptions, thrownError) {
//                     $("#spanWait").hide();
//                     alert(xhr.status);
//                     alert(thrownError);
//                 }
//             });
//         }else{
//             // alert("Add your product in Grid");
//             Swal.fire('Add your products in Grid');
//             //  $('#product_name').select2('open');
//             // e.preventdefault();
//         }
//             }
//         });







// });
</script>
@stop