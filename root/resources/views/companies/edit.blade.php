<title>Edit Company</title>
@extends('app')
<link rel="stylesheet" href="{{ URL::asset('css/multi-select/jquery.multiselect.css') }}">
<style type="text/css">
    ul,
    li {
        margin: 0;
        /* padding: 0; */
        list-style: inline;
    }

    .label {
        color: #000;
        font-size: 16px;
    }

    .company-form,
    .company-form * {
        box-sizing: border-box;
    }

    .company-form .row {
        min-width: 0;
    }

    .company-form .form-group {
        min-width: 0;
    }

    .company-form .form-control,
    .company-form .select2-container,
    .company-form .ms-options-wrap {
        max-width: 100%;
    }

    select + .select2-container {
        width: 100% !important;
    }

    @media (max-width: 991.98px) {
        .company-form .col-md-6,
        .company-form .col-md-4,
        .company-form .col-md-8,
        .company-form .col-md-12 {
            flex: 0 0 100%;
            max-width: 100%;
            width: 100%;
        }

        .company-form > .row {
            margin-left: 0;
            margin-right: 0;
        }

        .company-form .form-group.row {
            flex-direction: column;
            margin-bottom: 0.75rem;
        }

        .company-form .col-form-label {
            text-align: left;
            padding-top: 0;
            margin-bottom: 0.35rem;
        }

        .company-form .form-control,
        .company-form input[size] {
            width: 100% !important;
            max-width: 100%;
        }

        .company-form .select2-container,
        .company-form .ms-options-wrap,
        .company-form .ms-options-wrap > button {
            width: 100% !important;
        }

        .panel-body {
            padding: 15px 12px;
            overflow-x: hidden;
        }
    }
</style>
@section('contents')
<h1 class="page-title">Edit Company</h1>

<!-- Breadcrumb -->
<ol class="breadcrumb breadcrumb-2">
    <li><a href="{{ asset('dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
    <li><a href="{{ asset('account-group') }}">Companies</a></li>
    <li class="active"><strong>Edit Company</strong></li>
</ol>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <h3 class="panel-title">Edit Company</h3>
            </div>

            <div class="panel-body">
                @include('errors.validation')

                {!! Form::model($edit, [
                'method' => 'PATCH',
                'action' => ['App\Http\Controllers\CompanyController@update', $edit->id],
                'class' => 'form-horizontal',
                'files' => 'true',
                'enctype' => 'multipart/form-data',
                ]) !!}


                {!! Form::hidden('biller_id', Auth::User()->id, ['id' => 'biller_id', 'class' => 'form-control']) !!}
                <div class="company-form">
                <!-- Company Information Section -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('name', 'Company Name', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                <small class="text-danger d-block mb-1">SRB: use exact registered business name (no special characters)</small>
                                {!! Form::text('CompanyName', null, ['id' => 'CompanyName', 'class' => 'form-control', 'autofocus' => 'autofocus']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('phone', 'Phone', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::text('phone', null, ['id' => 'phone', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('Category', 'Category', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::select('category', [
                                'Other' => 'Other',
                                'Importer' => 'Importer',
                                'Exporter' => 'Exporter',
                                'Manufacturer' => 'Manufacturer',
                                'Distributor' => 'Distributor',
                                'Wholesaler' => 'Wholesaler',
                                'Journal order supplier' => 'Journal order supplier',
                                'Retailer' => 'Retailer',
                                ], null, ['id' => 'category', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('System Type', 'System Type', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::select('system_type', [
                                'DI' => 'DIGITAL INVOICE',
                                'POS' => 'POS',
                                'PRA' => 'PRA',
                                'KPRA' => 'KPRA (RIMS)',
                                'SRB' => 'SRB (Cloud POS)'
                                ], old('system_type', $edit->system_type), ['id' => 'system_type', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Address Section -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('address', 'Address', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::text('address', null, ['id' => 'address', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('Province', 'Province', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::select('province', [
                                'PUNJAB' => 'PUNJAB',
                                'SINDH' => 'SINDH',
                                'BALOCHISTAN' => 'BALOCHISTAN',
                                'KHYBER PAKHTUNKHWA' => 'KHYBER PAKHTUNKHWA',
                                'AZAD JAMMU AND KASHMIR' => 'AZAD JAMMU AND KASHMIR',
                                'CAPITAL TERRITORY' => 'CAPITAL TERRITORY',
                                'GILGIT BALTISTAN' => 'GILGIT BALTISTAN',
                                ], null, ['id' => 'province', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Business Type Section -->


                <!-- Tax Information Section -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('Ntn', 'NTN - CNIC', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                <small class="text-danger d-block mb-1">NTN for PTV LTD & AOP(9937038) - CNIC for Individual (3520133847501)</small>
                                {!! Form::text('ntn', null, ['id' => 'ntn', 'class' => 'form-control', 'placeholder' => 'NTN 7 Digits or CNIC 13 Digits without dashes']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('POSID', 'POS ID', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                <small class="text-danger d-block mb-1">In case of POS / PRA / KPRA / SRB</small>
                                {!! Form::text('pos_id', null, ['id' => 'pos_id', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>


                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('sandbox_token', 'SandBox Token / SRB Password', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                <small class="text-danger d-block mb-1">FBR: SandBox Token. SRB: POS password from SRB</small>
                                {!! Form::text('sandbox_token', null, ['id' => 'sandbox_token', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('token', 'Live TOKEN / KPRA Key / SRB User', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                <small class="text-danger d-block mb-1">FBR/PRA: Live TOKEN. KPRA: API key. SRB: POS username</small>
                                {!! Form::text('token', null, ['id' => 'token', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('invoice_type', 'Invoice Type', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                <small class="text-danger d-block mb-1">SRB: SandBox = Test mode, Live = Live mode</small>
                                {!! Form::select('invoice_type', [
                                'SandBox' => 'SandBox',
                                'Live' => 'Live'
                                ], null, ['id' => 'invoice_type', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('sale_type', 'Partner', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::select('partner_id', $partners, null, ['id' => 'partner_id', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group row">
                                {!! Form::label('name', 'Name', ['class' => 'col-md-4 col-form-label']) !!}
                                <div class="col-md-8">
                                    {!! Form::text('name', null, ['id' => 'name', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group row">
                                {!! Form::label('email', 'Email', ['class' => 'col-md-4 col-form-label']) !!}
                                <div class="col-md-8">
                                    {!! Form::text('email', null, ['id' => 'email', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div> -->

                <div class="row mt-3">
                    <!-- <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('password', 'Password', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                <input type="password" id="password" class="form-control" name="password">
                            </div>
                        </div>
                    </div> -->

                    <div class="col-md-6">
                        <div class="form-group row">

                            {!! Form::label('type', 'Business Type', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::select('Businesstype', [
                                'Invoice Only' => 'Invoice Only',
                                'Inventory' => 'Inventory',
                                'Trader' => 'Trader',
                                'Manufacturer' => 'Manufacturer'
                                ], $edit->type, ['id' => 'Businesstype', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    @php
                    // Decode the JSON string and extract size values
                    $selectedSizes = json_decode($edit->scenario, true);
                    $selectedSizeValues = array_column($selectedSizes, 'scenario');
                    @endphp
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('Scenario', 'Scenario', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                <!-- {!! Form::select('scenario', $Scenario, null, ['id' => 'scenario', 'class' => 'form-control']) !!} -->
                                {!! Form::select('scenario[]', $Scenario, $selectedSizeValues, [
                                'id' => 'langOpt3',
                                'class' => 'form-control',
                                'multiple' => 'multiple',
                                'style' => 'width: auto; display: inline-block;'
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('name', 'Number of Invoices', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::text('number_of_invoices', 100000, ['id' => 'number_of_invoices', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('Strn', 'SalesTax With held At Source', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::select('st_held', [0 => 'No', 1 => 'Yes'], null, ['id' => 'st_held', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('strn_show', 'FED Payable', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::select('fed_payable', [0 => 'No', 1 => 'Yes'], null, ['id' => 'fed_payable', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('discount', 'Discount %', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::select('discount', ['0' => 'No', '1' => 'Yes'], null, ['id' => 'discount', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('Discount 2', 'Discount 2 %', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::select('discount2', ['0' => 'No', '1' => 'Yes'], null, ['id' => 'discount2', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('discount', 'Discount Fixed', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::select('discount_fixed', ['0' => 'No', '1' => 'Yes'], null, ['id' => 'discount_fixed', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('Discount 2', 'Discount Fixed 2', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::select('discount_fixed2', ['0' => 'No', '1' => 'Yes'], null, ['id' => 'discount_fixed2', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('prefix', 'Invoice No Prefix', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::text('invoiceno_prefix', null, ['id' => 'invoiceno_prefix', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('qrcode', 'Invoice Qr Code', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::select('invoice_qrcode', ['1' => 'Top', '0' => 'Bottom'], null, ['id' => 'invoice_qrcode', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('invoice_serial', 'Invoice Serial#', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::text('invoice_serial', null, ['id' => 'invoice_serial', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('Approval', 'Approval', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::select('approval', ['1' => 'Yes', '0' => 'No'], null, ['id' => 'approval', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>


                <hr class="my-4">
                <!-- Payment Information Section -->
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('Contact_Person', 'Contact Person', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::text('contact_person', null, ['id' => 'contact_person', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('Contact_Phone', 'Contact Person Phone', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                <!-- {!! Form::text('contact_person_phone', null, ['id' => 'contact_person_phone', 'class' => 'form-control']) !!} -->
                                {!! Form::text('contact_person_phone', null, ['id' => 'contact_person_phone', 'class' => 'form-control',
                                'placeholder' => '+92__________',
                                'data-slots' => '_',
                                'data-accept' => '\w',
                                'size' => '9',
                                'onkeydown' => 'focusNext(event);']) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('Contact_Person_email', 'Contact Person Email', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::email('contact_person_email', null, ['id' => 'contact_person_email', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('Contact_Phone_add', 'Contact Person Address', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                <!-- {!! Form::text('contact_person_phone', null, ['id' => 'contact_person_phone', 'class' => 'form-control']) !!} -->
                                {!! Form::text('contact_person_address', null, ['id' => 'contact_person_address', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('client_payment', 'Client Payment', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::text('client_payment', null, ['id' => 'client_payment', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('payment_terms', 'Payment Terms', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::select('payment_terms', [
                                'Monthly' => 'Monthly',
                                'Annual' => 'Annual'
                                ], null, ['id' => 'payment_terms', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3" style="display: none;">
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('ntn_show', 'Show Customer NTN', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::select('ntn_show', [1 => 'Yes', 0 => 'No'], null, ['id' => 'ntn_show', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('type', 'Account Status', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::select('type', [
                                'ACTIVE' => 'ACTIVE',
                                'INACTIVE' => 'INACTIVE'
                                ], null, ['id' => 'type', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>





                <!-- User Information Section -->

                <div class="row mt-3">


                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('bill_type', 'Bill Type', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::select('bill_type', [
                                'A4' => 'A4',
                                'Thermal' => 'Thermal',
                                'Thermal2' => 'Thermal2'
                                ], null, ['id' => 'bill_type', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('is_active', 'Company Status', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::select('is_active', [
                                '1' => 'Active',
                                '0' => 'Deactive'
                                ], null, ['id' => 'is_active', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row mt-3" style="display: none;">
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('start_date', 'Start Date', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::date('start_date', null, ['id' => 'start_date', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('expire_date', 'Expiry Date', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::date('expire_date', null, ['id' => 'expire_date', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('Strn', 'STRN', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::text('strn', null, ['id' => 'strn', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('strn_show', 'Show Customer STRN', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::select('strn_show', [1 => 'Yes', 0 => 'No'], null, ['id' => 'strn_show', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                </div>




                <!-- Submit Button -->
                <!-- <div class="row mt-4">
                    <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary px-4">Update</button>
                    </div>
                </div> -->



                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('Email', 'Email', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::text('email12345', $user->email, ['id' => 'email12345', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group row">
                            {!! Form::label('Password', 'Password', ['class' => 'col-md-4 col-form-label']) !!}
                            <div class="col-md-8">
                                {!! Form::text('password12345', $user->show_password, ['id' => 'password12345', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="row mt-4">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-primary px-4">Update</button>
                    </div>
                </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
<script src="{{ URL::asset('css/multi-select/jquery.multiselect.js') }}"></script>
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<script type="text/javascript">
    $("#sale_type").select2();
    $("#sale_type").next(".select2").find(".select2-selection").focus(function() {
        $("#sale_type").select2("open");
    });
    $("#partner_id").select2();
    $("#partner_id").next(".select2").find(".select2-selection").focus(function() {
        $("#partner_id").select2("open");
    });
    $("#province").select2();
    $("#province").next(".select2").find(".select2-selection").focus(function() {
        $("#province").select2("open");
    });
    $("#Businesstype").select2();
    $("#Businesstype").next(".select2").find(".select2-selection").focus(function() {
        $("#Businesstype").select2("open");
    });

    $("#invoice_type").select2();
    $("#invoice_type").next(".select2").find(".select2-selection").focus(function() {
        $("#invoice_type").select2("open");
    });
    $("#type").select2();
    $("#type").next(".select2").find(".select2-selection").focus(function() {
        $("#type").select2("open");
    });
    $("#payment_terms").select2();
    $("#payment_terms").next(".select2").find(".select2-selection").focus(function() {
        $("#payment_terms").select2("open");
    });
    $("#scenario").select2();
    $("#scenario").next(".select2").find(".select2-selection").focus(function() {
        $("#scenario").select2("open");
    });

    $('#langOpt3').multiselect({
        columns: 1,
        placeholder: 'Select Size',
        search: true,
        selectAll: true
    });

    document.addEventListener('DOMContentLoaded', () => {
        for (const el of document.querySelectorAll("[placeholder][data-slots]")) {
            const pattern = el.getAttribute("placeholder"),
                slots = new Set(el.dataset.slots || "_"),
                prev = (j => Array.from(pattern, (c, i) => slots.has(c) ? j = i + 1 : j))(0),
                first = [...pattern].findIndex(c => slots.has(c)),
                accept = new RegExp(el.dataset.accept || "\\d", "g"),
                clean = input => {
                    input = input.match(accept) || [];
                    return Array.from(pattern, c =>
                        input[0] === c || slots.has(c) ? input.shift() || c : c
                    );
                },
                format = () => {
                    const [i, j] = [el.selectionStart, el.selectionEnd].map(i => {
                        i = clean(el.value.slice(0, i)).findIndex(c => slots.has(c));
                        return i < 0 ? prev[prev.length - 1] : back ? prev[i - 1] || first : i;
                    });
                    el.value = clean(el.value).join``;
                    el.setSelectionRange(i, j);
                    back = false;
                };
            let back = false;
            el.addEventListener("keydown", (e) => back = e.key === "Backspace");
            el.addEventListener("input", format);
            el.addEventListener("focus", format);
            el.addEventListener("blur", () => el.value === pattern && (el.value = ""));
        }
    });
</script>
@stop
