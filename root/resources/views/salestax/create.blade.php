@extends("app")
@section('contents')

<head>
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <style>
    .alert-container {
        margin-bottom: 20px;
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
        width: 100%;
        max-width: 720px;
        margin: 8px auto 16px;
        padding: 0;
        display: block;
    }
    .summary-card {
        border: 1px solid #e9ecef;
        border-radius: 6px;
        box-shadow: none;
        background: #fff;
    }
    .summary-card .card-body {
        padding: 8px 10px !important;
    }
    .st-req {
        color: #dc3545;
        font-weight: 700;
        margin-left: 2px;
    }
    /* Datepicker tray: solid overlay (fadeIn breaks under global CSS transitions) */
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
    #ui-datepicker-div .ui-datepicker-next {
        cursor: pointer;
        top: 4px;
    }
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
    .summary-row {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: flex-end;
        gap: 6px 8px;
    }
    .summary-row + .summary-row {
        margin-top: 6px;
        padding-top: 0;
        border-top: none;
    }
    .summary-row .stat-item {
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
    .summary-row .stat-label {
        color: #495057;
        font-size: 10px !important;
        font-weight: 600;
        letter-spacing: 0.02em;
        text-transform: uppercase;
        margin-bottom: 2px;
        text-align: left;
        line-height: 1.2;
        display: block;
        min-height: 0;
    }
    .summary-row .stat-value {
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: 3px;
        text-align: left;
        font-weight: 600;
        font-size: 12px !important;
        color: #212529;
        padding: 2px 6px;
        width: 100%;
        max-width: none !important;
        height: 28px;
        min-height: 28px;
        line-height: 22px;
        box-shadow: none;
    }
    .summary-row .stat-value[readonly],
    .summary-row .stat-value:disabled,
    .summary-row .stat-value[disabled] {
        background-color: #f1f3f5 !important;
        color: #495057;
    }
    .summary-row select.stat-value {
        padding-top: 2px;
        padding-bottom: 2px;
    }
    @media (max-width: 991px) {
        .summary-container { max-width: 100%; }
        .summary-row .stat-item { flex-basis: calc(50% - 6px); width: calc(50% - 6px); max-width: none; }
    }
    @media (max-width: 575px) {
        .summary-row .stat-item { flex-basis: 100%; width: 100%; max-width: none; }
    }
    .ajax-loader {
        position: fixed;
        inset: 0;
        display: none;
        background: rgba(255, 255, 255, 0.6);
        z-index: 9999;
    }
    .ajax-loader.is-active {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .ajax-loader__spinner {
        width: 52px;
        height: 52px;
        border: 5px solid #e0e0e0;
        border-top-color: #2c7be5;
        border-radius: 50%;
        animation: ajax-spin 0.9s linear infinite;
    }
    .retail-price {
        color: #28a745;
        font-weight: 700;
    }
    @keyframes ajax-spin {
        to { transform: rotate(360deg); }
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
    /* Compact top row: Date | Invoice No | Scenario | P Order | Remarks | DC | Customer Type */
    .st-wrap .st-meta-row--1 .st-meta-field--date { grid-column: span 2; }
    .st-wrap .st-meta-row--1 .st-meta-field--vr { grid-column: span 2; }
    .st-wrap .st-meta-row--1 .st-meta-field--scenario { grid-column: span 2; }
    .st-wrap .st-meta-row--1 .st-meta-field--porder { grid-column: span 1; }
    .st-wrap .st-meta-row--1 .st-meta-field--remarks { grid-column: span 2; }
    .st-wrap .st-meta-row--1 .st-meta-field--dc { grid-column: span 1; }
    .st-wrap .st-meta-row--1 .st-meta-field--ctype { grid-column: span 2; }
    /* Party row: Party | Address | NTN */
    .st-wrap .st-meta-row--3 .st-meta-field--party { grid-column: span 4; }
    .st-wrap .st-meta-row--3 .st-meta-field--address { grid-column: span 5; }
    .st-wrap .st-meta-row--3 .st-meta-field--ntn { grid-column: span 3; }
    /* Party row unregistered */
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
    .st-wrap .st-table tr.st-entry td {
        background: #f0f7ff;
    }
    .st-wrap .st-table tr.st-data-row td {
        background: #fff;
    }
    .st-wrap .st-table tr.st-data-row:hover td {
        background: #fafbfc;
    }
    .st-wrap .st-table .form-control,
    .st-wrap .st-table .form-control.input-sm {
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
        width: 100%;
        max-width: 720px;
        margin: 8px auto 16px;
        padding: 0;
        display: block;
    }
    @media (max-width: 991px) {
        .st-wrap .st-meta-row--1 .st-meta-field--date,
        .st-wrap .st-meta-row--1 .st-meta-field--vr,
        .st-wrap .st-meta-row--1 .st-meta-field--porder { grid-column: span 4; }
        .st-wrap .st-meta-row--1 .st-meta-field--remarks,
        .st-wrap .st-meta-row--1 .st-meta-field--dc,
        .st-wrap .st-meta-row--1 .st-meta-field--scenario,
        .st-wrap .st-meta-row--1 .st-meta-field--ctype { grid-column: span 4; }
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
    <div id="ajax-loader" class="ajax-loader" aria-hidden="true">
        <div class="ajax-loader__spinner" role="status" aria-label="Loading"></div>
    </div>
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
        <div class="container-fluid">
        @if (Session::has('error_message'))
        <div class="alert alert-danger alert-dismissible show" role="alert" style="position: relative;">
            {{ Session::get('error_message') }}
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
                    <h2 class="panel-title"><b>Sales Tax Invoice</b>
                        @if($sellerCompany->st_held ==1)
                        <span style="font-size: 14px;color: #ffffff;font-weight: 600;">ST Withheld At Source (manual amount)</span>
                        {{-- FUTURE: ST Withheld At Source enabled - 20% of tax value --}}
                        @endif
                    </h2>
                </div>
                <!-- @if(Session::has('error'))
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
                @endif -->

    @if(Session::has('error'))
    <div class="alert alert-danger">
        <strong>Error!</strong> {{ Session::get('error') }}
        @if(Session::has('error_details'))
            <br>Details: {{ Session::get('error_details') }}
        @endif
        @if(Session::has('error'))
            <br>Code: {{ Session::get('error') }}
        @endif
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

{{-- Add this new section for validation response errors --}}
@if(isset($responseData) && isset($responseData['validationResponse']) && $responseData['validationResponse']['statusCode'] !== '00')
    @php
        $validationResponse = $responseData['validationResponse'];
        $statusCode = $validationResponse['statusCode'] ?? 'Unknown';
        $status = $validationResponse['status'] ?? 'Error';
    @endphp
    
    <div class="alert alert-danger alert-dismissible show">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        
        <h5 class="alert-heading">Validation Error!</h5>
        <p class="mb-2"><strong>Code:</strong> {{ $statusCode }} | <strong>Status:</strong> {{ $status }}uuuuuuu</p>
        
        @if(isset($validationResponse['invoiceStatuses']) && is_array($validationResponse['invoiceStatuses']))
            <hr>
            <h6>Detailed Errors:</h6>
            <ul class="mb-0 pl-3">
                @foreach($validationResponse['invoiceStatuses'] as $error)
                    <li>
                        <strong>Item {{ $error['itemSNo'] ?? '' }}:</strong> 
                        {{ $error['error'] ?? 'Unknown error' }}
                        @if(isset($error['errorCode']))
                            (Error Code: {{ $error['errorCode'] }})kkkkkkkk
                        @endif
                    </li>
                @endforeach
            </ul>
        @elseif(isset($validationResponse['error']) && !empty($validationResponse['error']))
            <hr>
            <p class="mb-0"><strong>Error:</strong> {{ $validationResponse['error'] }}jjjjjjj</p>
        @endif
    </div>
@endif

{{-- Optional: Success message for validation --}}
@if(isset($responseData) && isset($responseData['validationResponse']) && $responseData['validationResponse']['statusCode'] === '00')
    <div class="alert alert-success alert-dismissible show">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Success!</strong> Validation completed successfully.
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
                    {!! Form::open(['url' => 'salestax', 'class' => 'form-horizontal', 'id' => 'form-submission']) !!}
                    {!! Form::hidden('company_id', session()->get('company_id'), ['id' => 'company_id']) !!}
                    {!! Form::hidden('biller', Auth::User()->id, ['id' => 'biller']) !!}
                    {!! Form::hidden('warehouse_id', 1, ['id' => 'warehouse_id']) !!}

                    {!! Form::hidden('sale_type', 'SalesTax Invoice', ['id' => 'sale_type']) !!}

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
                            <div class="st-meta-field st-meta-field--vr">
                                <label for="invoice_no">Invoice No <span class="st-req">*</span></label>
                                {!! Form::text('invoice_no', $codes, ['id' => 'invoice_no', 'class' => 'form-control form-control-sm', 'required' => 'required', 'onkeypress' => 'return onlyNumberKey(event)']) !!}
                            </div>
                            <div class="st-meta-field st-meta-field--scenario">
                                <label for="scenario_id">Scenario <span class="st-req">*</span></label>
                                {!! Form::select('scenario_id', $scenarios, null, ['id' => 'scenario_id', 'class' => 'form-control form-control-sm', 'required' => 'required']) !!}
                            </div>
                            <div class="st-meta-field st-meta-field--porder">
                                <label for="p_order">P Order</label>
                                {!! Form::text('p_order', null, ['id' => 'p_order', 'class' => 'form-control form-control-sm', 'required' => 'required']) !!}
                            </div>
                            <div class="st-meta-field st-meta-field--remarks">
                                <label for="remarks">Remarks</label>
                                {!! Form::text('remarks', null, ['id' => 'remarks', 'class' => 'form-control form-control-sm']) !!}
                            </div>
                            <div class="st-meta-field st-meta-field--dc">
                                <label for="dcn_no">DC NO</label>
                                @if(count($DeliveryChallan) > 1)
                                    {!! Form::select('dcn_no', $DeliveryChallan, null, ['id' => 'dcn_no', 'onchange' => 'dcKeyUp($(this).val());', 'class' => 'form-control form-control-sm']) !!}
                                @else
                                    {!! Form::text('dcn_no', null, ['id' => 'dcn_no', 'class' => 'form-control form-control-sm']) !!}
                                @endif
                            </div>
                            <div class="st-meta-field st-meta-field--ctype">
                                <label for="customer_type">Customer Type</label>
                                {!! Form::text('customer_type', null, ['id' => 'customer_type', 'class' => 'form-control form-control-sm st-readonly', 'placeholder' => 'Customer Type', 'disabled' => 'disabled', 'readonly' => 'readonly']) !!}
                            </div>
                        </div>
                        <div class="st-meta-row st-meta-row--3" id="stMetaRow3">
                            <div class="st-meta-field st-meta-field--party">
                                <label for="party_name">Select Party <span class="st-req">*</span></label>
                                {!! Form::hidden('party_id', null, ['id' => 'party_id']) !!}
                                {!! Form::select('party_name', $customers, null, [
                                    'id' => 'party_name',
                                    'onchange' => 'PartyKeyUp($(this).val());',
                                    'class' => 'form-control form-control-sm']) !!}
                            </div>
                            <div class="st-meta-field st-meta-field--address">
                                <label for="address">Address <span class="st-req">*</span></label>
                                {!! Form::text('address', null, ['id' => 'address', 'class' => 'form-control form-control-sm st-readonly', 'placeholder' => 'Address', 'disabled' => 'disabled', 'readonly' => 'readonly']) !!}
                            </div>
                            <div class="st-meta-field st-meta-field--ntn">
                                <label for="ntn">NTN <span class="st-req">*</span></label>
                                {!! Form::text('ntn', null, ['id' => 'ntn', 'class' => 'form-control form-control-sm st-readonly', 'placeholder' => 'NTN', 'disabled' => 'disabled', 'readonly' => 'readonly']) !!}
                            </div>
                            <div class="st-meta-field st-meta-field--cusname d-none" id="CusName" style="display: none;">
                                <label for="customer_name">Customer (Unregistered)</label>
                                {!! Form::text('customer_name', null, ['id' => 'customer_name', 'class' => 'form-control form-control-sm', 'placeholder' => 'Unregistered Customer Name']) !!}
                            </div>
                            <div class="st-meta-field st-meta-field--cnic" id="CusCnic" style="display: none;">
                                <label for="customer_cnic">CNIC (Unregistered)</label>
                                {!! Form::text('customer_cnic', null, ['id' => 'customer_cnic', 'class' => 'form-control form-control-sm',
                                    'placeholder' => '_____________',
                                    'pattern' => '[0-9]{13}',
                                    'data-slots' => '_']) !!}
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
                                            <th width="10%">Remarks</th>
                                            <th width="5%">Unit</th>
                                            <th width="6%">Qty</th>
                                            <th id="price_header" width="6%">Price</th>
                                            <th width="8%">Exc Val</th>
                                            <th width="5%">S.T%</th>
                                            <th width="8%">Tax.Val</th>
                                            <th width="5%">F.Tax%</th>
                                            
                                            @if($sellerCompany->discount == 1 || $sellerCompany->discount_fixed == 1)
                                            <th width="5%">
                                                @if($sellerCompany->discount == 1 && $sellerCompany->discount_fixed == 1)
                                                    Disc%/Disc
                                                @elseif($sellerCompany->discount == 1)
                                                    Disc%
                                                @else
                                                    Disc
                                                @endif
                                            </th>
                                            @endif
                                            @if($sellerCompany->discount2 == 1 || $sellerCompany->discount_fixed2 == 1)
                                            <th width="5%">
                                                @if($sellerCompany->discount2 == 1 && $sellerCompany->discount_fixed2 == 1)
                                                    Disc2%/Disc2
                                                @elseif($sellerCompany->discount2 == 1)
                                                    Disc2%
                                                @else
                                                    Disc2
                                                @endif
                                            </th>
                                            @endif
                                           
                                            <th width="10%">Inc Val</th>
                                             @if($sellerCompany->show_fbr_qty ==1)
                                            <th width="6%">FBR.Qty</th>
                                            @endif
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
                                                'form-control']) !!}</td>

                                            <td>
                                                {!! Form::select('product_name', $products, null, [
                                                'id' => 'product_name',
                                                'class' => 'form-control',
                                                'onchange' => 'ProductKeyUp($(this).val().split("_").pop(),
                                                $(this).val().split("_")[0]);'
                                                ]) !!}
                                            </td>
                                              <td>
                                                {!! Form::text('remarks1', null, [
                                                'id' => 'remarks1',
                                                'class' => 'form-control'
                                                ]) !!}
                                            </td>

                                            <td>
                                                {!! Form::hidden('uom_id', null, ['id' => 'uom_id']) !!}
                                                {!! Form::text('uom', null, [
                                                'id' => 'uom',
                                                'class' => 'form-control',
                                                'readonly' => 'readonly'
                                                ]) !!}
                                            </td>

                                            <td class="st-num">
                                                {!! Form::text('quantity', null, [
                                                'id' => 'quantity',
                                                'class' => 'form-control',
                                                'oninput' => 'validateFourDecimals(this)',
                                                'onkeyup' => 'QuantityKeyUp()',
                                                'onkeypress' => 'return onlyNumberKey(event)',
                                                'onpaste' => 'setTimeout(function(){ QuantityKeyUp(); validateFourDecimals(document.getElementById("quantity")); }, 0);',
                                                'autocomplete' => 'off',
                                                'onfocus' => 'this.value=""'
                                                ]) !!}
                                            </td>
                                            <td class="st-num">
                                                {!! Form::text('price_per_unit', null, [
                                                'id' => 'price_per_unit',
                                                'class' => 'form-control',
                                                'onkeypress' => 'return onlyNumberKey(event)',
                                                'oninput' => 'validateEightDecimals(this)',
                                                'onkeyup' => 'QuantityKeyUp()',
                                                'onpaste' => 'setTimeout(function(){ QuantityKeyUp(); validateEightDecimals(document.getElementById("price_per_unit")); }, 0);',
                                                'autocomplete' => 'off',
                                                ]) !!}
                                            </td>
                                              <!-- exclusive value -->
                                            <td class="st-num">
                                                {!! Form::text('ValueExTax', null, [
                                                'id' => 'ValueExTax',
                                                'class' => 'form-control',
                                                'onkeyup' => 'SaleValKeyUp()',
                                                'onkeypress' => 'return onlyNumberKey(event)',
                                                ]) !!}
                                            </td>
                                            <!-- exclusive value end -->
                                            <td class="st-num">
                                                {!! Form::text('stvalue', null, [
                                                'id' => 'stvalue',
                                                'class' => 'form-control',
                                                'disabled' => 'disabled'
                                                ]) !!}
                                            </td>
                                            <td class="st-num">
                                                {!! Form::text('taxvalue', null, [
                                                'id' => 'taxvalue',
                                                'class' => 'form-control',
                                                'disabled' => 'disabled'
                                                ]) !!}
                                            </td>
                                            <td class="st-num">
                                                {!! Form::hidden('extraTaxValue', null, ['id' => 'extraTaxValue']) !!}
                                                {!! Form::text('extratax', null, [
                                                'id' => 'extratax',
                                                'class' => 'form-control',
                                                'onkeyup' => 'ExtraTaxkeyup($(this).val());',
                                                'onkeypress' => 'return onlyNumberKey(event)',
                                                'onfocus' => 'this.value=""'
                                                ]) !!}
                                            </td>
                                          
                                            @if($sellerCompany->discount == 1 || $sellerCompany->discount_fixed == 1)
                                            <td class="st-num">
                                                {!! Form::hidden('discount_value', null, ['id' => 'discount_value']) !!}
                                                {!! Form::text('discount', null, [
                                                'id' => 'discount',
                                                'onkeyup' => 'QuantityKeyUp()',
                                                'class' => 'form-control'
                                                ]) !!}
                                            </td>
                                            @endif
                                        
                                            
                                            @if($sellerCompany->discount2 == 1 || $sellerCompany->discount_fixed2 == 1)
                                            <td class="st-num">
                                                {!! Form::hidden('discount_value2', null, ['id' => 'discount_value2']) !!}
                                                {!! Form::text('discount2', null, [
                                                'id' => 'discount2',
                                                'onkeyup' => 'QuantityKeyUp()',
                                                'class' => 'form-control'
                                                ]) !!}
                                            </td>
                                            @endif
                                            <td class="st-num">
                                                {!! Form::text('amount', null, [
                                                'id' => 'amount',
                                                'class' => 'form-control',
                                                'disabled' => 'disabled'
                                                ]) !!}
                                            </td>
                                            @if($sellerCompany->show_fbr_qty ==1)
                                                <td class="st-num">
                                                {!! Form::text('fbr_qty', null, [
                                                'id' => 'fbr_qty',
                                                'class' => 'form-control'
                                                ]) !!}
                                                </td>
                                            @endif
                                            <td>
                                                {!! Form::select('sro_schd_no1', $sroschedule, null, [
                                                'id' => 'sro_schd_no1',
                                                'class' => 'form-control'
                                                ]) !!}
                                            </td>
                                            <td>
                                                {!! Form::select('sro_item_no1', $sroitem, null, [
                                                'id' => 'sro_item_no1',
                                                'class' => 'form-control'
                                                ]) !!}
                                            </td>

                                            <td>
                                                <button type="button" onclick="AddGridData()"
                                                    class="btn btn-success btn-sm btn-add-line">
                                                    Add
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                        </div>
                    </div>

                    <div class="summary-container">
                        <div class="card summary-card">
                            <div class="card-body py-3">
                                <div class="summary-row">
                                    <div class="stat-item">
                                        <span class="stat-label">TOTAL QTY</span>
                                        <input type="text" class="form-control stat-value" value="0"
                                            id="TotalQty" name="TotalQty" readonly>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">EXC VALUE</span>
                                        <input type="text" class="form-control stat-value" value="0"
                                            id="TotalExTax" name="TotalExTax" readonly>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">TAX VALUE</span>
                                        <input type="text" class="form-control stat-value" value="0"
                                            id="TotalTaxValue" name="TotalTaxValue" readonly>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">INCLUSIVE VALUE</span>
                                        <input type="text" class="form-control stat-value" value="0"
                                            id="TotalAmount" name="TotalAmount" readonly>
                                    </div>
                                </div>
                                <div class="summary-row">
                                    <div class="stat-item">
                                        <span class="stat-label">Advance Income Tax %<br>236G/236H</span>
                                        <input type="text" id="advance_income_tax" name="advance_income_tax"
                                            onkeyup="AdvanceIncomeTax($(this).val())"
                                            class="form-control stat-value" style="background-color: white">
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">Total Income Tax</span>
                                        <input type="text" id="total_income_tax" name="total_income_tax"
                                            class="form-control stat-value" readonly>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">Discount Amount</span>
                                        <input type="text" id="discount_amount" name="discount_amount"
                                            onkeyup="recalculateGrandAmount()" oninput="validateTwoDecimals(this)"
                                            class="form-control stat-value" style="background-color: white" value="0">
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">Total Amount</span>
                                        <input type="text" id="GrandAmount" name="GrandAmount"
                                            class="form-control stat-value" readonly>
                                    </div>
                                    <div class="stat-item" id="petroleum_levy_wrapper" style="display:none;">
                                        <span class="stat-label">Petroleum Levy Rate</span>
                                        <select id="petroleum_levy_rate" name="petroleum_levy_rate"
                                            class="form-control stat-value" style="background-color: white">
                                            <option value="">Select</option>
                                            <option value="No Levy">No Levy</option>
                                            <option value="Direct Sale">Direct Sale</option>
                                            <option value="Retail Sale">Retail Sale</option>
                                            <option value="Differential">Differential</option>
                                        </select>
                                    </div>
                                </div>
                                @if($sellerCompany->st_held ==1)
                                <div class="summary-row">
                                    <div class="stat-item">
                                        <span class="stat-label" style="color: red;">ST Withheld At Source</span>
                                        <input type="text" id="withheld_at_source_amount" name="withheld_at_source_amount"
                                            value="0" class="form-control stat-value"
                                            oninput="validateTwoDecimals(this)">
                                    </div>
                                </div>
                                @endif
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
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css">

<script>
@include('partials.salestax-remote-select2')

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
function setInvoiceDate(ymd) {
    if (!ymd) return;
    var raw = String(ymd).substring(0, 10);
    if (/^\d{4}-\d{2}-\d{2}$/.test(raw)) {
        $('#date').val(raw);
        $('#date_display').val(ymdToDmy(raw));
        return;
    }
    if (/^\d{1,2}[-/]\d{1,2}[-/]\d{4}$/.test(raw)) {
        $('#date_display').val(raw.replace(/\//g, '-'));
        syncInvoiceDateFromDisplay();
    }
}
function initInvoiceDatePicker() {
    var $display = $('#date_display');
    if (!$display.length) return;
    if (typeof $display.datepicker === 'function') {
        try { $display.datepicker('destroy'); } catch (e) {}
        $display.datepicker({
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
    $display.on('change blur', syncInvoiceDateFromDisplay);
    syncInvoiceDateFromDisplay();
}
initInvoiceDatePicker();

$("#scenario_id").select2();
$("#scenario_id").next(".select2").find(".select2-selection").focus(function() {
$("#scenario_id").select2("open");
});
$("#scenario_id").on('select2:select', function () {
    setTimeout(function () { $('#p_order').focus(); }, 0);
});
 const deliveryChallanCount = {{ count($DeliveryChallan) }};
    // Now use the JS variable in your condition
if (deliveryChallanCount > 1) {
    $("#dcn_no").select2();
    $("#dcn_no").next(".select2").find(".select2-selection").focus(function() {
    $("#dcn_no").select2("open");
    });
}

$("#sro_schd_no1").select2();
$("#sro_schd_no1").next(".select2").find(".select2-selection").focus(function() {
    $("#sro_schd_no1").select2("open");
});
$("#sro_item_no1").select2();
</script>



<script type="text/javascript">
var myData = '#myTable tbody';

$(function () {
    $('.btn-add-line').on('keydown', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13 || ((e.key === 'Tab' || e.keyCode === 9) && !e.shiftKey)) {
            e.preventDefault();
            AddGridData();
        }
    });
});
function syncUnregMetaRow() {
    var $row = $('#stMetaRow3');
    if (!$row.length) {
        return;
    }
    if ($('#CusName').is(':visible')) {
        $row.addClass('st-meta-row--unreg');
    } else {
        $row.removeClass('st-meta-row--unreg');
    }
}
function initGridSroSelects($context) {
    $context.find('.js-sro-schedule, .js-sro-item').each(function() {
        var $select = $(this);
        if (!$select.hasClass('select2-hidden-accessible')) {
            $select.select2({
                width: '100%'
            });
        }
    });
}
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
    var remarks1 = document.getElementById('remarks1').value;
    // alert(remarks1);
    var UOM = document.getElementById('uom').value;
    var UOMID = document.getElementById('uom_id').value;
    var Quantity = document.getElementById('quantity').value;
   
    var Price = document.getElementById('price_per_unit').value;
    var STValue = document.getElementById('stvalue').value;
    var TaxValue = document.getElementById('taxvalue').value;
    var ExtraTax = document.getElementById('extratax').value;
    var ExtraTaxValue = document.getElementById('extraTaxValue').value;
    var ValueExTax = document.getElementById('ValueExTax').value;
    var discountCheck = <?php echo json_encode($sellerCompany->discount); ?>;
    var discountCheck2 = <?php echo json_encode($sellerCompany->discount2); ?>;
    var discountFixed = <?php echo json_encode($sellerCompany->discount_fixed); ?>;
    var discountFixed2 = <?php echo json_encode($sellerCompany->discount_fixed2); ?>;
    var showfbrqty = <?php echo json_encode($sellerCompany->show_fbr_qty); ?>;
    // alert(discount);
    if(discountCheck == 1 || discountFixed == 1){
    var discount = document.getElementById('discount').value;
    var discountValue = document.getElementById('discount_value').value;
    }
   if(discountCheck2 == 1 || discountFixed2 == 1){
    var discount2 = document.getElementById('discount2').value;
    var discountValue2 = document.getElementById('discount_value2').value;
    }
    if(showfbrqty == 1){
     var FBRQty = document.getElementById('fbr_qty').value;
    }
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

    var tableHtml = '<tr class="st-data-row">';

    tableHtml += `<td width="7%">
                <input id="product_id1" name="product_id1[]" value="${ProductId}" type="hidden">
                <input value="${ProductCode}" type="text" class="form-control" disabled>
                <input name="product_code[]" value="${ProductCode}" type="hidden">
              </td>`;

    tableHtml += `<td width="15%">
                <input value="${ProductName}" type="text" class="form-control" disabled>
                <input name="product_name[]" value="${ProductName}" type="hidden">
              </td>`;

        tableHtml += `<td width="10%">
                <input value="${remarks1}" name="remarks1[]" type="text" class="form-control">
              </td>`;

    tableHtml += `<td width="5%">
                <input name="uom_id[]" value="${UOMID}" type="hidden">
                <input name="uom[]" value="${UOM}" type="text" class="form-control" readonly>
              </td>`;

    tableHtml += `<td width="6%" class="st-num">
                <input id="quantity" name="quantity[]" value="${Quantity}" type="text" class="form-control"
                onkeyup="QuantityKeyUp1($(this).closest('tr').index());">
              </td>`;

    tableHtml += `<td width="6%" class="st-num">
                <input id="rate" name="rate[]" value="${Price}" type="text" class="form-control"
                onkeyup="QuantityKeyUp1($(this).closest('tr').index());">
              </td>`;
    tableHtml += `<td width="8%" class="st-num">
                <input id="excvalue" name="excvalue[]" value="${ValueExTax}" type="text" class="form-control" readonly
                 onkeyup="SaleValKeyUp1($(this).closest('tr').index());">
              </td>`;
    tableHtml += `<td width="5%" class="st-num">
                <input id="stvalue" name="stvalue[]" value="${STValue}" type="text" class="form-control" readonly>
              </td>`;

    tableHtml += `<td width="8%" class="st-num">
                <input id="taxvalue" name="taxvalue[]" value="${TaxValue}" type="text" class="form-control" readonly>
              </td>`;

    tableHtml += `<td width="5%" class="st-num">
                <input id="extraTaxValue" name="extraTaxValue[]" value="${ExtraTaxValue}" type="hidden">
                <input id="extratax" name="extratax[]" value="${ExtraTax}" type="text" class="form-control" 
                onkeyup="QuantityKeyUp1($(this).closest('tr').index());">
              </td>`;


    if(discountCheck == 1 || discountFixed == 1){
   tableHtml += `<td width="5%" class="st-num">
                <input id="discount" name="discount[]" value="${discount}" type="text" class="form-control" 
                onkeyup="QuantityKeyUp1($(this).closest('tr').index());">
                <input id="discount_value" name="discount_value[]" value="${discountValue}" type="hidden">
              </td>`;
    }
    if(discountCheck2 == 1 || discountFixed2 == 1){
    tableHtml += `<td width="5%" class="st-num">
                <input id="discount2" name="discount2[]" value="${discount2}" type="text" class="form-control" 
                onkeyup="QuantityKeyUp1($(this).closest('tr').index());">
                <input id="discount2_value" name="discount2_value[]" value="${discountValue2}" type="hidden">
              </td>`;
    }          
 

    tableHtml += `<td width="10%" class="st-num">
                <input name="TotalTax[]" value="${TotalTax}" type="hidden">
                <input id="incvalue" name="incvalue[]" value="${Amount}" type="text" class="form-control" readonly>
              </td>`;
              


    if(showfbrqty == 1){
        tableHtml += `<td width="6%" class="st-num">
                <input id="fbr_qty" name="fbr_qty[]" value="${FBRQty}" type="text" class="form-control">
              </td>`;
    }
        tableHtml += `<td width="8%">
                                <select name="sro_schd_no[]" class="form-control js-sro-schedule" data-selected="${SroSchd}">
                                        <option value="${SroSchd}" selected>${SroSchd || 'Select Schedule'}</option>
                                </select>
                            </td>`;

        tableHtml += `<td width="8%">
                                <select name="sro_item_no[]" class="form-control js-sro-item" data-selected="${SroItem}">
                                        <option value="${SroItem}" selected>${SroItem || 'Choose'}</option>
                                </select>
                            </td>`;

    tableHtml += `<td width="8%">
                <button type="button" onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="btn btn-danger btn-sm">
                  Delete
                </button>
              </td>`;

    tableHtml += '</tr>';
    $('#myTable tbody').append(tableHtml);
    initGridSroSelects($('#myTable tbody'));
    refreshGridSroSchedules($('#scenario_id').val());
    $('#product_code').val(null);
    $('select#product_name').val(null).trigger('change.select2');
    setTimeout(function () {
        try {
            $('select#product_name').select2('open');
            var $search = $('.select2-container--open .select2-search__field');
            if ($search.length) $search.focus();
        } catch (err) {}
    }, 80);
    
    $('#quantity').val(null);
    $('#price_per_unit').val(null);
    $('#ValueExTax').val(null);
    $('#extratax').val(null);
    $('#discount').val(null);
    // $('#product_name').val(null).select2();
    // $('#product_name').select2('open');

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

// function TotalQuantity() {
//     var tableData = document.getElementById('myData');
//     var sum = 0;
//     for (var i = 0; i < tableData.rows.length; i++) {
//         if (tableData.rows[i].cells[7].getElementsByTagName('input')[0].value == '') {
//             sum += 0;
//         } else {
//             sum += parseFloat(tableData.rows[i].cells[7].getElementsByTagName('input')[0].value);
//             // alert(sum);
//         }
//     }
//     document.getElementById('TotalQty').value = sum.toLocaleString('en-US');
// }

function TotalQuantity() {
    var tableData = document.getElementById('myTable');
    var sum = 0;
    var rateInputs = tableData.querySelectorAll('tr.st-data-row input[name="quantity[]"]');
    for (var i = 0; i < rateInputs.length; i++) {
        var value = rateInputs[i].value.trim();
        if (value === '') {
            sum += 0;
        } else {
            sum += parseFloat(value);
        }
    } 
    document.getElementById('TotalQty').value = sum.toLocaleString('en-US');
}


function TotalTaxes() {
    var tableData = document.getElementById('myTable');
    var sum = 0;
    var rateInputs = tableData.querySelectorAll('tr.st-data-row input[name="taxvalue[]"]');
    for (var i = 0; i < rateInputs.length; i++) {
        var value = rateInputs[i].value.trim();
        if (value === '') {
            sum += 0;
        } else {
            sum += parseFloat(value);
        }
    } 
    document.getElementById('TotalTaxValue').value = sum.toLocaleString('en-US');
    // FUTURE: updateWithheldAtSourceAmount(); // auto 20% of TotalTax
}

function TotalExTax() {
    var tableData = document.getElementById('myTable');
    var sum = 0;
    var rateInputs = tableData.querySelectorAll('tr.st-data-row input[name="excvalue[]"]');
    for (var i = 0; i < rateInputs.length; i++) {
        var value = rateInputs[i].value.trim();
        if (value === '') {
            sum += 0;
        } else {
            sum += parseFloat(value);
        }
    } 
    document.getElementById('TotalExTax').value = sum.toLocaleString('en-US');
}

function TotalAmount() {
    var tableData = document.getElementById('myTable');
    var sum = 0;
    var rateInputs = tableData.querySelectorAll('tr.st-data-row input[name="incvalue[]"]');
    for (var i = 0; i < rateInputs.length; i++) {
        var value = rateInputs[i].value.trim();
        if (value === '') {
            sum += 0;
        } else {
            sum += parseFloat(value);
        }
    } 
    document.getElementById('TotalAmount').value = sum.toLocaleString('en-US');
    recalculateGrandAmount();
}

function recalculateGrandAmount() {
    var totalAmountRaw = document.getElementById('TotalAmount').value || '0';
    var totalAmount = parseFloat(totalAmountRaw.toString().replace(/,/g, '').replace(/[^0-9.-]/g, '')) || 0;

    var incomeTaxElement = document.getElementById('total_income_tax');
    var incomeTaxRaw = incomeTaxElement ? incomeTaxElement.value : '0';
    var incomeTax = parseFloat(incomeTaxRaw.toString().replace(/,/g, '').replace(/[^0-9.-]/g, '')) || 0;

    var discountElement = document.getElementById('discount_amount');
    var discountRaw = discountElement ? discountElement.value : '0';
    var grandDiscount = parseFloat(discountRaw.toString().replace(/,/g, '').replace(/[^0-9.-]/g, '')) || 0;

    document.getElementById('GrandAmount').value = (totalAmount + incomeTax - grandDiscount).toFixed(2);
}


// function TotalAmount() {
//     var tableData = document.getElementById('myData');
//     var sum = 0;
//     var discountCheck = <?php echo json_encode($sellerCompany->discount); ?>;
//     var discountCheck2 = <?php echo json_encode($sellerCompany->discount2); ?>;
//     if(discountCheck == 1){
//         var rateInputs = tableData.querySelectorAll('input[id*="discount"]');
//        for (var i = 0; i < rateInputs.length; i++) {
//         var value = rateInputs[i].value.trim();
//         if (value === '') {
//             sum += 0;
//         } else {
//             sum += parseFloat(value);
//         }
//     }
//     }
//     else if(discountCheck2 == 1){
//           for (var i = 0; i < tableData.rows.length; i++) {
//             if (tableData.rows[i].cells[16].getElementsByTagName('input')[0].value == '') {
//                 sum += 0;
//             } else {
//                 sum += parseFloat(tableData.rows[i].cells[16].getElementsByTagName('input')[0].value);
//                 // alert(sum);
//             }
//         }
//     }else{
//    for (var i = 0; i < tableData.rows.length; i++) {
//                 if (tableData.rows[i].cells[14].getElementsByTagName('input')[0].value == '') {
//                     sum += 0;
//                 } else {
//                     sum += parseFloat(tableData.rows[i].cells[14].getElementsByTagName('input')[0].value);
//                     // alert(sum);
//                 }
//             }
//     }

  
//     document.getElementById('TotalAmount').value = sum.toLocaleString('en-US');
// }



function SaleRateKeyUp(SaleRate, RowIndex) {
    var quantity = $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('6')").text();
    var tax = $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('9')").val();
}

function SaleValKeyUp(){
    var quantity = parseFloat(document.getElementById('quantity').value) || 0;
    var saleValue = parseFloat(document.getElementById('ValueExTax').value) || 0;
    var scenario = document.getElementById('scenario_id').value;
    var rate = 0;
    // For scenarios 14/28 do NOT derive price from EXC; keep entered price_per_unit
    if(scenario == 14 || scenario == 28){
        rate = parseFloat(document.getElementById('price_per_unit').value) || 0;
    } else {
        rate = quantity > 0 ? (saleValue / quantity) : 0;
        document.getElementById('price_per_unit').value = rate.toFixed(8);
    }

    var tax = parseFloat(document.getElementById('stvalue').value) || 0;
    var taxx = tax / 100;
    var totaltax = 0;
    if(scenario == 14 || scenario == 28){
        totaltax = rate * taxx; // computed but we'll use DOM value for final amount
    } else {
        totaltax = (rate * quantity) * taxx;
    }

    // set taxvalue input from calculated total-tax (keep existing behaviour)
    document.getElementById('taxvalue').value = totaltax.toFixed(2);
    // If scenario 14 or 28 (3rd Schedule), EXC stays manual; INC = EXC + TAX + Extra - Disc
    if(scenario == 14 || scenario == 28){
        var excEl = document.getElementById('ValueExTax');
        if(excEl && (excEl.value === '' || excEl.value === null)) excEl.value = '0.00';
        var exc = parseFloat(excEl.value.toString().replace(/,/g,'')) || 0;
        var taxFromDom = parseFloat(document.getElementById('taxvalue').value) || 0;
        var extra = parseFloat(document.getElementById('extraTaxValue') ? document.getElementById('extraTaxValue').value : 0) || 0;
        var discEl = document.getElementById('discount');
        var disc2El = document.getElementById('discount2');
        var discValEl = document.getElementById('discount_value');
        var discVal2El = document.getElementById('discount_value2');
        var computed = computeThirdScheduleInclusive(
            exc, taxFromDom, extra,
            discEl ? discEl.value : 0,
            disc2El ? disc2El.value : 0
        );
        if (discValEl) discValEl.value = computed.discountValue.toFixed(2);
        if (discVal2El) discVal2El.value = computed.discountValue2.toFixed(2);
        document.getElementById('amount').value = computed.inc.toFixed(2);
        return;
    }
}

function QuantityKeyUp() {

    var DiscPer = '{{ $sellerCompany->discount }}';
    var DiscPer2 = '{{ $sellerCompany->discount2 }}';
    var DiscFixed = '{{ $sellerCompany->discount_fixed }}';
    var DiscFixed2 = '{{ $sellerCompany->discount_fixed2 }}';

    var quantity = document.getElementById('quantity').value;
    var tax = document.getElementById('stvalue').value;
    var extratax = document.getElementById('extratax').value;
    var price = document.getElementById('price_per_unit').value;
    var scenario = document.getElementById('scenario_id').value;
    // alert(scenario);
    var taxx = tax / 100;
    if(scenario == 14 || scenario == 28){
    //  var totaltax = (price * quantity) * taxx;
    // Safdar sb
    var totaltax = price * taxx;
    // Razzak sb
    //var subtotal = price * quantity;
    //var roundedTax = subtotal * taxx;
    //var totaltax = parseFloat(roundedTax.toFixed(3));
    }else{
    // var totaltax = (price / 100 * tax) * quantity;
    // var totaltax = parseFloat((price * quantity) * taxx.toFixed(2));
    var subtotal = price * quantity;
    var roundedTax = subtotal * taxx;
    var totaltax = parseFloat(roundedTax.toFixed(3));
    }
    // alert(totaltax);    
    var extratax = (price / 100 * extratax) * quantity;
    // document.getElementById('taxvalue').value = totaltax.toFixed(2);
    // document.getElementById('taxvalue').value = parseFloat(totaltax.toFixed(2));
    document.getElementById('taxvalue').value = roundTo(totaltax, 2).toFixed(2);
    document.getElementById('extraTaxValue').value = extratax;

    var valueWithoutTax = parseFloat(quantity * price) || 0;
    // Discount % applies on INC (EXC + TAX + ExtraTax), not just EXC
    var taxVal = parseFloat(roundTo(totaltax, 2).toFixed(2)) || 0;
    var extraVal = parseFloat(extratax) || 0;
    var incBeforeDiscount = valueWithoutTax + taxVal + extraVal;

    var discountElement = document.getElementById('discount');
    var discountValueElement = document.getElementById('discount_value');
    var discount = discountElement ? (parseFloat(discountElement.value) || 0) : 0;
    var discountValue = 0;

    if (discount > 0) {
        if (DiscPer == 1) {
            discountValue = incBeforeDiscount / 100 * discount;
        }
        if (DiscFixed == 1) {
            discountValue = discount;
        }
        discountValue = Math.min(discountValue, incBeforeDiscount);
    }

    if (discountValueElement) {
        discountValueElement.value = discountValue.toFixed(2);
    }

    var discount2Element = document.getElementById('discount2');
    var discountValue2Element = document.getElementById('discount_value2');
    var discount2 = discount2Element ? (parseFloat(discount2Element.value) || 0) : 0;
    var discountValue2 = 0;
    var incAfterDiscount1 = incBeforeDiscount - discountValue;

    if (discount2 > 0) {
        if (DiscPer2 == 1) {
            discountValue2 = incAfterDiscount1 / 100 * discount2;
        }

        if (DiscFixed2 == 1) {
            discountValue2 = discount2;
        }

        discountValue2 = Math.min(discountValue2, incAfterDiscount1);
    }

    if (discountValue2Element) {
        discountValue2Element.value = discountValue2.toFixed(2);
    }

    // If scenario 14/28, do not auto-overwrite EXC value; keep manual input. If empty, default to 0.
    if(!(scenario == 14 || scenario == 28)){
        // EXC VAL = raw value without tax (discount does NOT reduce EXC, only INC)
        document.getElementById('ValueExTax').value = valueWithoutTax.toFixed(2);
        var totalDiscount = discountValue + discountValue2;
        var total = incBeforeDiscount - totalDiscount;
        document.getElementById('amount').value = total.toFixed(2);
    } else {
        // 3rd Schedule: keep manual EXC; INC = (EXC + TAX + Extra) - Disc
        var excEl = document.getElementById('ValueExTax');
        if(excEl && (excEl.value === '' || excEl.value === null)) excEl.value = '0.00';
        var exc = parseFloat(excEl.value.toString().replace(/,/g,'')) || 0;
        var taxFromDom = parseFloat(document.getElementById('taxvalue').value) || 0;
        var extra = parseFloat(document.getElementById('extraTaxValue').value) || 0;
        var computed = computeThirdScheduleInclusive(exc, taxFromDom, extra, discount, discount2);
        if (discountValueElement) discountValueElement.value = computed.discountValue.toFixed(2);
        if (discountValue2Element) discountValue2Element.value = computed.discountValue2.toFixed(2);
        document.getElementById('amount').value = computed.inc.toFixed(2);
    }
}

 function QuantityKeyUp1(RowIndex) {
    var DiscPer = '{{ $sellerCompany->discount }}';
    var DiscPer2 = '{{ $sellerCompany->discount2 }}';
    var DiscFixed = '{{ $sellerCompany->discount_fixed }}';
    var DiscFixed2 = '{{ $sellerCompany->discount_fixed2 }}';
    // alert(DiscPer);
        // var quantity = $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('6')").val();
        var quantity = $('tr:eq(' + RowIndex + ')', myData).find('[id*="quantity"]').val();
        var tax = $('tr:eq(' + RowIndex + ')', myData).find('[id*="stvalue"]').val();
        var extratax = $('tr:eq(' + RowIndex + ')', myData).find('[id*="extratax"]').val();
        var price = $('tr:eq(' + RowIndex + ')', myData).find('[id*="rate"]').val();
        // var totaltax = (price / 100 * tax) * quantity;
        var scenario = document.getElementById('scenario_id').value;
        var taxx = tax / 100;
            if(scenario == 14 || scenario == 28){
            // var totaltax = (price / 100 * tax);
            // var totaltax = (price * quantity) * taxx;
            //Safdar sb
            var totaltax = price * taxx;
            //Razzak sb
            // var subtotal = price * quantity;
            // var roundedTax = subtotal * taxx;
            // var totaltax = parseFloat(roundedTax.toFixed(3));
            }else{
            // var totaltax = (price / 100 * tax) * quantity;
            // var totaltax = (price * quantity) * taxx;
            var subtotal = price * quantity;
            var roundedTax = subtotal * taxx;
            var totaltax = parseFloat(roundedTax.toFixed(3));
            }
        var extratax = (price / 100 * extratax) * quantity;
        // document.getElementById('taxvalue').value = totaltax.toFixed(2);
        // $('tr:eq(' + RowIndex + ')', myData).find('[id*="taxvalue"]').val(totaltax.toFixed(2));
        $('tr:eq(' + RowIndex + ')', myData).find('[id*="taxvalue"]').val(roundTo(totaltax, 2).toFixed(2));
        // document.getElementById('extraTaxValue').value = extratax;
        $('tr:eq(' + RowIndex + ')', myData).find('[id*="extraTaxValue"]').val(extratax.toFixed(2));

        var valueWithoutTax = parseFloat(quantity * price) || 0;
        // Discount % applies on INC (EXC + TAX + ExtraTax), not just EXC
        var taxVal1 = parseFloat(roundTo(totaltax, 2).toFixed(2)) || 0;
        var extraVal1 = parseFloat(extratax) || 0;
        var incBeforeDiscount = valueWithoutTax + taxVal1 + extraVal1;

        var discount = parseFloat($('tr:eq(' + RowIndex + ')', myData).find('[id*="discount"]').val()) || 0;
        var discountValue = 0;

        if (discount > 0) {
            if (DiscPer == 1) {
                discountValue = incBeforeDiscount / 100 * discount;
            }

            if (DiscFixed == 1) {
                discountValue = discount;
            }

            discountValue = Math.min(discountValue, incBeforeDiscount);
        }

        $('tr:eq(' + RowIndex + ')', myData).find('[id*="discount_value"]').val(discountValue.toFixed(2));

        var discount2 = parseFloat($('tr:eq(' + RowIndex + ')', myData).find('[id*="discount2"]').val()) || 0;
        var discountValue2 = 0;
        var incAfterDiscount1 = incBeforeDiscount - discountValue;

        if (discount2 > 0) {
            if (DiscPer2 == 1) {
                discountValue2 = incAfterDiscount1 / 100 * discount2;
            }

            if (DiscFixed2 == 1) {
                discountValue2 = discount2;
            }

            discountValue2 = Math.min(discountValue2, incAfterDiscount1);
        }

        $('tr:eq(' + RowIndex + ')', myData).find('[id*="discount_value2"]').val(discountValue2.toFixed(2));

        // If scenario 14/28, do NOT auto-overwrite excvalue; allow manual input instead.
        var scenario = document.getElementById('scenario_id').value;
        if(!(scenario == 14 || scenario == 28)){
            // EXC VAL = raw value without tax (discount does NOT reduce EXC, only INC)
            $('tr:eq(' + RowIndex + ')', myData).find('[id*="excvalue"]').val(valueWithoutTax.toFixed(2));
            var totalDiscount = discountValue + discountValue2;
            var total = incBeforeDiscount - totalDiscount;
            $('tr:eq(' + RowIndex + ')', myData).find('[id*="incvalue"]').val(total.toFixed(2));
        } else {
                // 3rd Schedule: keep manual EXC; INC = (EXC + TAX + Extra) - Disc
                var excEl = $('tr:eq(' + RowIndex + ')', myData).find('[id*="excvalue"]');
                if(!excEl.val()) excEl.val('0.00');
                var excManual = parseFloat(excEl.val().toString().replace(/,/g,'')) || 0;
                var taxFromRow = parseFloat($('tr:eq(' + RowIndex + ')', myData).find('[id*="taxvalue"]').val()) || 0;
                var extraManual = parseFloat($('tr:eq(' + RowIndex + ')', myData).find('[id*="extraTaxValue"]').val()) || 0;
                var computed = computeThirdScheduleInclusive(excManual, taxFromRow, extraManual, discount, discount2);
                $('tr:eq(' + RowIndex + ')', myData).find('[id*="discount_value"]').val(computed.discountValue.toFixed(2));
                $('tr:eq(' + RowIndex + ')', myData).find('[id*="discount_value2"]').val(computed.discountValue2.toFixed(2));
                $('tr:eq(' + RowIndex + ')', myData).find('[id*="incvalue"]').val(computed.inc.toFixed(2));
        }
    }

    function SaleValKeyUp1(RowIndex){
       
    var quantity = $('tr:eq(' + RowIndex + ')', myData).find('[id*="quantity"]').val();
    var saleValue = $('tr:eq(' + RowIndex + ')', myData).find('[id*="excvalue"]').val();
    var scenario = document.getElementById('scenario_id').value;
    // Only set row rate from exc when not scenario 14/28
    if(!(scenario == 14 || scenario == 28)){
        var rate = (quantity > 0) ? (saleValue / quantity) : 0;
        $('tr:eq(' + RowIndex + ')', myData).find('[id*="rate"]').val(rate.toFixed(2));
    }
    // If scenario 14/28, recompute inclusive using manual exc + tax + extra - Disc
    if(scenario == 14 || scenario == 28){
        var taxVal = parseFloat($('tr:eq(' + RowIndex + ')', myData).find('[id*="taxvalue"]').val()) || 0;
        var extraVal = parseFloat($('tr:eq(' + RowIndex + ')', myData).find('[id*="extraTaxValue"]').val()) || 0;
        var exc = parseFloat(saleValue.toString().replace(/,/g,'')) || 0;
        var discount = parseFloat($('tr:eq(' + RowIndex + ')', myData).find('[id*="discount"]').val()) || 0;
        var discount2 = parseFloat($('tr:eq(' + RowIndex + ')', myData).find('[id*="discount2"]').val()) || 0;
        var computed = computeThirdScheduleInclusive(exc, taxVal, extraVal, discount, discount2);
        $('tr:eq(' + RowIndex + ')', myData).find('[id*="discount_value"]').val(computed.discountValue.toFixed(2));
        $('tr:eq(' + RowIndex + ')', myData).find('[id*="discount_value2"]').val(computed.discountValue2.toFixed(2));
        $('tr:eq(' + RowIndex + ')', myData).find('[id*="incvalue"]').val(computed.inc.toFixed(2));
    }
}

function AdvanceIncomeTax(advancetax) {
    // alert(advancetax);
    var TotalAmount1 = document.getElementById('TotalAmount').value;
    TotalAmount = TotalAmount1.replace(/[^0-9.-]/g, '');
    // alert(TotalAmount);

    var totaladvancetax = TotalAmount / 100 * advancetax;
    document.getElementById('total_income_tax').value = totaladvancetax.toFixed(2);

    recalculateGrandAmount();

    // alert(totaladvancetax);
}

// FUTURE: restore auto 20% ST Withheld when checkbox is enabled again
// function toggleWithheldAtSourceAmount() {
//     var checkbox = document.getElementById('withheld_at_source');
//     var amountInput = document.getElementById('withheld_at_source_amount');
//     if (!checkbox || !amountInput) {
//         return;
//     }
//     amountInput.readOnly = false;
//     if (checkbox.checked) {
//         updateWithheldAtSourceAmount();
//     }
// }
//
// function updateWithheldAtSourceAmount() {
//     var checkbox = document.getElementById('withheld_at_source');
//     var amountInput = document.getElementById('withheld_at_source_amount');
//     if (!checkbox || !amountInput || !checkbox.checked) {
//         return;
//     }
//     var totalTaxRaw = document.getElementById('TotalTaxValue')
//         ? document.getElementById('TotalTaxValue').value
//         : '0';
//     var totalTax = parseFloat(totalTaxRaw.toString().replace(/,/g, '').replace(/[^0-9.-]/g, '')) || 0;
//     amountInput.value = Math.round(totalTax * 0.20);
// }

function togglePetroleumLevyField() {
    var scenarioId = document.getElementById('scenario_id') ? document.getElementById('scenario_id').value : '';
    var wrapper = document.getElementById('petroleum_levy_wrapper');
    var field = document.getElementById('petroleum_levy_rate');
    if (!wrapper || !field) {
        return;
    }
    if (String(scenarioId) === '18') {
        wrapper.style.display = '';
    } else {
        wrapper.style.display = 'none';
        field.value = '';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // FUTURE: toggleWithheldAtSourceAmount();
    togglePetroleumLevyField();
});

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


function validateFourDecimals(input) {
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
        if (decimalPart.length > 4) {
            value = `${integerPart}.${decimalPart.substring(0, 4)}`;
        }
    }

    // Update the input value
    input.value = value;
}

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

// Robust rounding helper to avoid floating-point ties issues.
// Use: roundTo(number, 2) and then .toFixed(2) if you need exactly two decimals as string.
function roundTo(value, decimals) {
    var factor = Math.pow(10, decimals || 0);
    var scaledEps = Number.EPSILON * Math.abs(value) * factor;
    return Math.round(value * factor + scaledEps) / factor;
}

// SN008/SN027 (ids 14/28) = 3rd Schedule Goods: INC = (EXC + TAX + Extra) - Disc
function isThirdScheduleScenario(scenario) {
    return scenario == 14 || scenario == 28 || scenario == '14' || scenario == '28';
}

function computeThirdScheduleInclusive(exc, tax, extra, discountInput, discount2Input) {
    var DiscPer = '{{ $sellerCompany->discount }}';
    var DiscPer2 = '{{ $sellerCompany->discount2 }}';
    var DiscFixed = '{{ $sellerCompany->discount_fixed }}';
    var DiscFixed2 = '{{ $sellerCompany->discount_fixed2 }}';
    var incBefore = (parseFloat(exc) || 0) + (parseFloat(tax) || 0) + (parseFloat(extra) || 0);
    var discount = parseFloat(discountInput) || 0;
    var discountValue = 0;
    if (discount > 0) {
        if (DiscPer == 1) {
            discountValue = incBefore / 100 * discount;
        }
        if (DiscFixed == 1) {
            discountValue = discount;
        }
        discountValue = Math.min(discountValue, incBefore);
    }
    var discount2 = parseFloat(discount2Input) || 0;
    var discountValue2 = 0;
    var after1 = incBefore - discountValue;
    if (discount2 > 0) {
        if (DiscPer2 == 1) {
            discountValue2 = after1 / 100 * discount2;
        }
        if (DiscFixed2 == 1) {
            discountValue2 = discount2;
        }
        discountValue2 = Math.min(discountValue2, after1);
    }
    return {
        inc: incBefore - discountValue - discountValue2,
        discountValue: discountValue,
        discountValue2: discountValue2
    };
}

function ExtraTaxkeyup(taxvalue) {
    var quantity = document.getElementById('quantity').value;
    var price = document.getElementById('price_per_unit').value;
    var stvalue = document.getElementById('stvalue').value;
    var scenario = document.getElementById('scenario_id').value;
     if(scenario == 14 || scenario == 28){
    //  var tax = (stvalue / 100 * price);
    var tax = (stvalue / 100 * price) * quantity;
    }else{
    var tax = (stvalue / 100 * price) * quantity;
    }
    // var tax = (stvalue / 100 * price) * quantity;
    var extratax = (taxvalue / 100 * price) * quantity;

    document.getElementById('extraTaxValue').value = extratax.toFixed(2);
    // Use authoritative tax value from DOM to avoid transient recalculation issues on focus/tab
    var taxFromDom = parseFloat(document.getElementById('taxvalue').value) || 0;
    // For scenarios 14/28 do not overwrite ValueExTax; INC = EXC + TAX + Extra - Disc
    if(scenario == 14 || scenario == 28){
        var exc = parseFloat(document.getElementById('ValueExTax').value.toString().replace(/,/g,'')) || 0;
        var discEl = document.getElementById('discount');
        var disc2El = document.getElementById('discount2');
        var discValEl = document.getElementById('discount_value');
        var discVal2El = document.getElementById('discount_value2');
        var computed = computeThirdScheduleInclusive(
            exc, taxFromDom, parseFloat(extratax || 0),
            discEl ? discEl.value : 0,
            disc2El ? disc2El.value : 0
        );
        if (discValEl) discValEl.value = computed.discountValue.toFixed(2);
        if (discVal2El) discVal2El.value = computed.discountValue2.toFixed(2);
        document.getElementById('amount').value = computed.inc.toFixed(2);
    } else {
        var total = quantity * price;
        var totalValue = total + taxFromDom + extratax;
        document.getElementById('ValueExTax').value = total.toFixed(2);
        document.getElementById('amount').value = totalValue.toFixed(2);
    }
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
    var $row = $(row);
    var quantity = $row.find('input[name="quantity[]"]').val();
    var price = $row.find('input[name="rate[]"]').val();
    var tax = $row.find('input[name="stvalue[]"]').val();
    var extrataxPct = $row.find('input[name="extratax[]"]').val();

    var totaltax = parseFloat((price / 100 * tax) * quantity).toFixed(2);
    var extrataxVal = parseFloat((price / 100 * extrataxPct) * quantity).toFixed(2);
    $row.find('input[name="taxvalue[]"]').val(totaltax);
    $row.find('input[name="extraTaxValue[]"]').val(extrataxVal);
    var valueWithoutTax = parseFloat(quantity * price).toFixed(2);
    $row.find('input[name="excvalue[]"]').val(valueWithoutTax);
    var total = parseFloat((quantity * price) + parseFloat(totaltax) + parseFloat(extrataxVal)).toFixed(2);
    $row.find('input[name="incvalue[]"]').val(total);
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
                // alert(result[0].customer_type);
                $("#product_code").focus();
                $('#party_id').val(result[0].id);
                $('#address').val(result[0].address);
                $('#strn').val(result[0].strn);
                $('#ntn').val(result[0].ntn);
                $('#customer_type').val(result[0].customer_type);
                if(result[0].customer_type == "Unregistered"){
                    $('#CusName').show();
                    $('#CusCnic').show();
                }else{
                    $('#customer_name').val("");
                    $('#customer_cnic').val("");
                    $('#CusName').hide(); 
                    $('#CusCnic').hide(); 
                }
                syncUnregMetaRow();
            } else {
                $('#party_id').val("");
                $('#address').val("");
                $('#strn').val("");
                $('#ntn').val("");
                $('#customer_type').val("");
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
            
            $('#date').val(result.data.date);
            setInvoiceDate(result.data.date);
            setPartySelectValue(result.data.party_id, result.data.parties.party_name);
            $('#party_id').val(result.data.party_id);
            $('#address').val(result.data.parties.address);
            $('#ntn').val(result.data.parties.ntn);
            $("#myTable tbody tr.st-data-row").remove(); 
         $.each(result.data.challan_details, function(i, v) {
            // alert("dfsd");
            var tableHtml = '<tr class="st-data-row">';

            tableHtml += `<td width="7%">
                <input name="product_id1[]" value="${v.product_id}" type="hidden">
                <input name="product_code[]" value="${v.products.product_code}" class="form-control" readonly>
              </td>`;

            tableHtml += `<td width="15%">
                <input name="product_name[]" value="${v.products.product_name}" class="form-control" readonly>
              </td>`;

            tableHtml += `<td width="10%">
                <input name="remarks1[]" value="" type="text" class="form-control">
              </td>`;

            tableHtml += `<td width="5%">
                <input name="uom_id[]" value="${v.uom_id}" type="hidden">
                <input name="uom[]" value="${v.uom}" type="text" class="form-control" readonly>
              </td>`;

            tableHtml += `<td width="6%" class="st-num">
                <input id="quantity" name="quantity[]" value="${v.quantity}" class="form-control" onkeyup="taxcalculations($(this).closest('tr'));">
              </td>`;

            tableHtml += `<td width="6%" class="st-num">
                <input id="rate" name="rate[]" class="form-control" onkeyup="taxcalculations($(this).closest('tr'));">
              </td>`;

            tableHtml += `<td width="8%" class="st-num">
                <input id="excvalue" name="excvalue[]" class="form-control" readonly>
              </td>`;

            tableHtml += `<td width="5%" class="st-num">
                <input id="stvalue" name="stvalue[]" value="${v.products.tax}" class="form-control" readonly>
              </td>`;

            tableHtml += `<td width="8%" class="st-num">
                <input id="taxvalue" name="taxvalue[]" type="text" class="form-control" readonly>
              </td>`;

            tableHtml += `<td width="5%" class="st-num">
                <input id="extraTaxValue" name="extraTaxValue[]" type="hidden">
                <input id="extratax" name="extratax[]" class="form-control" onkeyup="taxcalculations($(this).closest('tr'));">
              </td>`;

            if (<?php echo json_encode($sellerCompany->discount == 1 || $sellerCompany->discount_fixed == 1); ?>) {
            tableHtml += `<td width="5%" class="st-num">
                <input id="discount" name="discount[]" type="text" class="form-control" onkeyup="taxcalculations($(this).closest('tr'));">
                <input id="discount_value" name="discount_value[]" type="hidden">
              </td>`;
            }
            if (<?php echo json_encode($sellerCompany->discount2 == 1 || $sellerCompany->discount_fixed2 == 1); ?>) {
            tableHtml += `<td width="5%" class="st-num">
                <input id="discount2" name="discount2[]" type="text" class="form-control" onkeyup="taxcalculations($(this).closest('tr'));">
                <input id="discount2_value" name="discount2_value[]" type="hidden">
              </td>`;
            }

            tableHtml += `<td width="10%" class="st-num">
                <input name="TotalTax[]" type="hidden">
                <input id="incvalue" name="incvalue[]" class="form-control" readonly>
              </td>`;

            if (<?php echo json_encode($sellerCompany->show_fbr_qty == 1); ?>) {
            tableHtml += `<td width="6%" class="st-num">
                <input id="fbr_qty" name="fbr_qty[]" type="text" class="form-control">
              </td>`;
            }

            tableHtml += `<td width="8%">
                <input name="sro_schd_no[]" value="" type="text" class="form-control" readonly>
              </td>`;

            tableHtml += `<td width="8%">
                <input name="sro_item_no[]" value="" type="text" class="form-control" readonly>
              </td>`;

            tableHtml += `<td width="8%">
                <button type="button" onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="btn btn-danger btn-sm">
                  Delete
                </button>
              </td>`;

            tableHtml += '</tr>';
            $('#myTable tbody').append(tableHtml);
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
        text: "Confirm to Remove this item?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Remove it!',
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

    // Remove disabled state from SRO dropdowns on scenario change
    $('#sro_schd_no1').prop('disabled', false);
    $('#sro_item_no1').prop('disabled', false);
    $('#sro_item_no1').html('<option value="">Choose</option>').val('').trigger('change');

    $.ajax({
        url: "{{ asset('sro-item/getsroitem/scenarion') }}",
        type: 'get',
        data: {
            scenario_id: scenario_id
        },
        dataType: 'json',
        success: function(response) {
            if (response.data != '') {
                var option = '';
                option += `<option value="">Select Schedule</option>`;
                $.each(response.data, function(i, v) {
                    option += `<option value="${v.id}_${v.sro_schedule_name}">${v.sro_schedule_name}</option>`;
                });
                $('#sro_schd_no1').html(option);
            } else {
                var option = '';
                option += `<option value="0">No Records Found</option>`;
                $('#sro_schd_no1').html(option);
            }
        }
    });
    refreshGridSroSchedules(scenario_id);
    updatePriceHeader(scenario_id);
    togglePetroleumLevyField();
    setTimeout(function () { $('#p_order').focus(); }, 0);
});

// initialize header on page load
updatePriceHeader($('#scenario_id').val());

$('#sro_schd_no1').change(function() {
    // var sro_schd_id = $(this).val();
    var sro_schd_id = $(this).val().split("_")[0];
    var scenario_id = $("#scenario_id").val();
    if (!sro_schd_id) {
        $('#sro_item_no1').html('<option value="">Choose</option>').val('').trigger('change');
        return;
    }
    $('#sro_item_no1')
        // .prop('disabled', true)
        .html('<option value="">Loading...</option>')
        .val('')
        .trigger('change');
    $.ajax({
        url: "{{ asset('sro-item/getsroschd/getsroitem') }}",
        type: 'get',
        data: {
            sro_schd_id: sro_schd_id,
            scenario_id: scenario_id
        },
        dataType: 'json',
        success: function(response) {
            $('#sro_item_no1').prop('disabled', false);
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
            $('#sro_item_no1').select2('open');
        }
    });
});

function refreshGridSroSchedules(scenarioId) {
    if (!scenarioId) {
        $('.js-sro-schedule').each(function() {
            $(this).html('<option value="">Select Schedule</option>').val('').trigger('change');
        });
        $('.js-sro-item').each(function() {
            $(this).html('<option value="">Choose</option>').val('').trigger('change');
        });
        return;
    }
    $.ajax({
        url: "{{ asset('sro-item/getsroitem/scenarion') }}",
        type: 'get',
        data: {
            scenario_id: scenarioId
        },
        dataType: 'json',
        success: function(response) {
            if (response.data != '') {
                $('.js-sro-schedule').each(function() {
                    var $select = $(this);
                    var selectedName = $select.data('selected') || $select.val() || '';
                    var option = '<option value="">Select Schedule</option>';
                    $.each(response.data, function(i, v) {
                        option += `<option value="${v.sro_schedule_name}" data-id="${v.id}">${v.sro_schedule_name}</option>`;
                    });
                    $select.html(option);

                    if (selectedName) {
                        $select.val(selectedName);
                        var selectedOption = $select.find('option:selected');
                        var scheduleId = selectedOption.data('id') || '';
                        var $row = $select.closest('tr');
                        var selectedItem = $row.find('.js-sro-item').data('selected') || '';
                        loadGridSroItems($row, scenarioId, scheduleId, selectedItem);
                    } else {
                        $select.val('');
                        $select.trigger('change');
                    }
                });
                initGridSroSelects($(document));
            } else {
                $('.js-sro-schedule').each(function() {
                    $(this).html('<option value="0">No Records Found</option>').val('0').trigger('change');
                });
                $('.js-sro-item').each(function() {
                    $(this).html('<option value="">No Records Found</option>').val('').trigger('change');
                });
            }
        }
    });
}

function loadGridSroItems($row, scenarioId, scheduleId, selectedItemNo, autoOpenItem) {
    if (!scheduleId) {
        $row.find('.js-sro-item').html('<option value="">Choose</option>').val('').trigger('change');
        return;
    }
    var $itemSelect = $row.find('.js-sro-item');
    $itemSelect
        // .prop('disabled', true)
        .html('<option value="">Loading...</option>')
        .val('')
        .trigger('change');
    $.ajax({
        url: "{{ asset('sro-item/getsroschd/getsroitem') }}",
        type: 'get',
        data: {
            sro_schd_id: scheduleId,
            scenario_id: scenarioId
        },
        dataType: 'json',
        success: function(response) {
            $itemSelect.prop('disabled', false);
            if (response.data != '') {
                var option = '<option value="">Choose</option>';
                $.each(response.data, function(i, v) {
                    option += `<option value="${v.sro_item_no}">${v.sro_item_no}</option>`;
                });
                $itemSelect.html(option);
                if (selectedItemNo) {
                    $itemSelect.val(selectedItemNo).trigger('change');
                } else {
                    $itemSelect.val('').trigger('change');
                }
            } else {
                $itemSelect.html('<option value="">No Records Found</option>').val('').trigger('change');
            }
            if (autoOpenItem) {
                $itemSelect.select2('open');
            }
        }
    });
}

$(document).on('change', '.js-sro-schedule', function() {
    var $select = $(this);
    var $row = $select.closest('tr');
    var scenarioId = $('#scenario_id').val();
    var selectedOption = $select.find('option:selected');
    var scheduleId = selectedOption.data('id') || '';
    $select.data('selected', $select.val());
    var $itemSelect = $row.find('.js-sro-item');
    $itemSelect
        // .prop('disabled', true)
        .html('<option value="">Loading...</option>')
        .val('')
        .trigger('change');
    loadGridSroItems($row, scenarioId, scheduleId, $row.find('.js-sro-item').data('selected'), true);
});

$(document).on('change', '.js-sro-item', function() {
    $(this).data('selected', $(this).val());
});


function updatePriceHeader(scenario_id){
    var th = document.getElementById('price_header');
    if(!th) return;
    if(scenario_id == 14 || scenario_id == '14' || scenario_id == 28 || scenario_id == '28'){
        th.textContent = 'Retail Price';
        th.classList.add('retail-price');
    } else {
        th.textContent = 'Price';
        th.classList.remove('retail-price');
    }
}



$("#btnSave").click(function() {
    // alert("dd");
    // $('#btnSave').attr('disabled', true);

         if ($('#scenario_id').val() == '') {
        //  alert('Please Select Supplier');
        Swal.fire('Select Scenario First');
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
    $.each($("#myTable tbody tr.st-data-row"), function(index, row) {
        var columns = $(row).find("td");
        var product = new Object();
        product.party_id = $("#party_id").val();
        product.product_code = $(columns[1]).find("input").val();

        products.push(product);
    });
    if (products != "") {
        $('#ajax-loader').addClass('is-active');
        $('#btnSave').prop('disabled', true);
        setTimeout(function() {
            $('#ajax-loader').removeClass('is-active');
            $('#btnSave').prop('disabled', false);
        }, 3000);
        $('#form-submission').submit();
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
@include('partials.enter-as-tab')
@stop