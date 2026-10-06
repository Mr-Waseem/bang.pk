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
        font-size: 1.2rem !important;
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
            color: #6c757d;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.05em;
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
            font-size: 1.1rem;
            color: #212529;
            padding: 0.75rem 0.5rem;
            width: 100%;
            max-width: 160px;
            transition: all 0.2s ease;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.03);
        }

        @media (min-width: 768px) {
            .stat-value {
                font-size: 1.25rem;
                padding: 0.9rem 0.5rem;
            }

            .stat-label {
                font-size: 0.85rem;
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

        #myTable th.sro-col,
        #myData td.sro-col {
            min-width: 140px;
        }

        #myTable th.sro-item-col,
        #myData td.sro-item-col {
            min-width: 120px;
        }

        #myTable th.action-col,
        #myData td.action-col {
            min-width: 90px;
        }

        #myData .form-control {
            min-width: 100%;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        @if (Session::has('flash_message'))
        <div class="alert alert-success alert-dismissible show" role="alert" style="position: relative;">
            {{ Session::get('flash_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%); padding: 0.5rem; line-height: 1; background: transparent; border: 0; font-size: 1.5rem;">
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
                        <span style="font-size: 14px;color: #ffffff;font-weight: 600;">ST Withheld At Source enabled - 20% of tax value</span>
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
                    {!! Form::model($edit, ['method' => 'PATCH', 'action' => ['App\Http\Controllers\SalesTaxController@update', $edit->id], 'class' => 'form-horizontal', 'id' => 'form-submission']) !!}
                    {!! Form::hidden('company_id', session()->get('company_id'), ['id' => 'company_id']) !!}
                    {!! Form::hidden('warehouse_id', $edit->warehouse_id, ['id' => 'warehouse_id']) !!}
                    {!! Form::hidden('biller', Auth::User()->id, ['id' => 'biller']) !!}
                    {!! Form::hidden('sale_type', 'SalesTax Invoice', ['id' => 'sale_type']) !!}

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-row align-items-center">
                                <div class="col-md-1 col-12 mb-2 mb-md-0">
                                    <label class="form-label fw-bold">Date</label>
                                </div>
                                <div class="col-md-2 col-6 mb-2 mb-md-0">
                                    <input id="date" type="date" name="date" value="{{ date('Y-m-d',strtotime($edit->date))}}"
                                        class="form-control form-control-sm" autofocus>
                                </div>
                                <div class="col-md-1 col-12 mb-2 mb-md-0">
                                    <label class="form-label fw-bold">Remarks</label>
                                </div>
                                <div class="col-md-3 col-6 mb-2 mb-md-0">
                                    {!! Form::text('remarks', $edit->remarks, ['id' => 'remarks', 'class' => 'form-control form-control-sm']) !!}
                                </div>
                                <div class="col-md-1 col-12 mb-2 mb-md-0">
                                    <label class="form-label fw-bold">DC NO</label>
                                </div>
                                <div class="col-md-2 col-6 mb-2 mb-md-0">
                                    {!! Form::text('dcn_no', $edit->dcn_no, ['id' => 'dcn_no', 'class' => 'form-control form-control-sm', 'readonly' => 'readonly']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-row align-items-center">
                                <div class="col-md-1 col-12 mb-2 mb-md-0">
                                    <label class="form-label fw-bold">Vr#</label>
                                </div>
                                <div class="col-md-2 col-6 mb-2 mb-md-0">
                                    {!! Form::text('invoice_no', $edit->invoice_no, ['id' => 'invoice_no', 'class' => 'form-control form-control-sm', 'required' => 'required', 'readonly' => 'readonly']) !!}
                                </div>
                                <div class="col-md-1 col-12 mb-2 mb-md-0">
                                    <label class="form-label fw-bold">Scenario</label>
                                </div>
                                <div class="col-md-3 col-6 mb-2 mb-md-0">
                                    {!! Form::select('scenario_id', $scenarios, $edit->scenario_id, ['id' => 'scenario_id', 'class' => 'form-select form-select-sm', 'required' => 'required']) !!}
                                </div>
                                <div class="col-md-1 col-12 mb-2 mb-md-0">
                                    <label class="form-label fw-bold">P Order</label>
                                </div>
                                <div class="col-md-2 col-6 mb-2 mb-md-0">
                                    {!! Form::text('p_order', $edit->p_order, ['id' => 'p_order', 'class' => 'form-control form-control-sm', 'required' => 'required']) !!}
                                </div>
                                   <div class="col-md-2 col-6 mb-2 mb-md-0">
                                    {!! Form::text('customer_type', $edit->parties->customer_type, ['id' => 'customer_type', 'class' => 'form-control
                                    form-control-sm','placeholder' => 'Customer Type', 'disabled' => 'disabled']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-row align-items-center">
                                <div class="col-md-1 col-12 mb-2 mb-md-0">
                                    <span class="input-group-text bg-light border-end-0">&nbsp;</span> 
                                    <label class="form-label fw-bold">Select Party</label>
                                </div>
                                <div class="col-md-3 col-6 mb-2 mb-md-0">
                                    <span class="input-group-text bg-light border-end-0">&nbsp;</span>
                                    {!! Form::hidden('party_id', $edit->party_id, ['id' => 'party_id', 'class' => 'form-control']) !!}
                                    {!! Form::select('party_name', $customers, $edit->party_id, [
                                    'id' => 'party_name',
                                    'onchange' => 'PartyKeyUp($(this).val());',
                                    'class' => 'form-control']) !!}
                                </div>
                                <div class="col-md-3 col-6 mb-2 mb-md-0">
                                    <span class="input-group-text bg-light border-end-0">Address</span> 
                                    {!! Form::text('address', $edit->parties->address, ['id' => 'address', 'class' => 'form-control form-control-sm', 'placeholder' => 'Address', 'disabled' => 'disabled']) !!}
                                </div>
                                <div class="col-md-1 col-6 mb-2 mb-md-0">
                                     <span class="input-group-text bg-light border-end-0">NTN</span> 
                                    {!! Form::text('ntn', $edit->parties->ntn, ['id' => 'ntn', 'class' => 'form-control form-control-sm', 'placeholder' => 'NTN', 'disabled' => 'disabled']) !!}
                                </div>

                                   <div class="col-md-2 col-6 mb-2 mb-md-0 d-none" id="CusName" style="display: none;">
                                    <span class="input-group-text bg-light border-end-0">Customer (Unregistered)</span> 
                                   {!! Form::text('customer_name', $edit->customer_name, ['id' => 'customer_name', 'class' => 'form-control
                                    form-control-sm', 'placeholder' => 'Customer Name, Optional']) !!}
                                </div>
                                 <div class="col-md-2 col-6 mb-2 mb-md-0" id="CusCnic" style="display: none;">
                                    <span class="input-group-text bg-light border-end-0">CNIC (Unregistered)</span>   
                                    {!! Form::text('customer_cnic', null, ['id' => 'customer_cnic', 'class' => 'form-control
                                    form-control-sm', 
                                    'placeholder' => '_____________',
                                    'pattern' => '[0-9]{13}',
                                    'data-slots' => '_'
                                    ]) !!}
                                </div>

                            </div>
                        </div>
                    </div><br />

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group" style="margin-bottom: 0px;">
                                <table id="myTable" class="table table-condensed" style="margin-bottom: 0px;">
                                    <thead>
                                        <tr>
                                            <th width="7%">H.S Code</th>
                                            <th width="15%">Product Name</th>
                                            <th width="10%">Remarks</th>
                                            <th width="5%">Unit</th>
                                            <th width="6%">Qty</th>
                                            <th width="6%">Price</th>
                                            <th width="8%">Exc Val</th>
                                            <th width="5%">S.T%</th>
                                            <th width="8%">Tax.Val</th>
                                            <th width="5%">F.Tax%</th>
                                            
                                            @if($sellerCompany->discount == 1)
                                            <th width="5%">DISC</th>
                                            @endif
                                            @if($sellerCompany->discount2 == 1)
                                            <th width="5%">Discount2</th>
                                            @endif
                                            @if($sellerCompany->discount_fixed == 1)
                                            <th width="5%">Disc</th>
                                            @endif
                                             @if($sellerCompany->discount_fixed2 == 1)
                                            <th width="5%">Disc2</th>
                                            @endif
                                            <th width="10%">Inc Val</th>
                                             @if($sellerCompany->show_fbr_qty ==1)
                                            <th width="6%">FBR.Qty</th>
                                            @endif
                                            <th width="8%" class="sro-col">SRO.sch#</th>
                                            <th width="8%" class="sro-item-col">SRO.Item#</th>
                                            <th width="8%" class="action-col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            {!! Form::hidden('product_id', null, ['id' => 'product_id', 'class' => 'form-control']) !!}

                                            <td>
                                                {!! Form::text('product_code', null, [
                                                'id' => 'product_code',
                                                'class' => 'form-control input-sm',
                                                'onfocus' => 'this.value=""'
                                                ]) !!}
                                            </td>

                                            <td>
                                                {!! Form::select('product_name', $products, null, [
                                                'id' => 'product_name',
                                                'class' => 'form-control input-sm',
                                                'style' => 'width:100%',
                                                'onchange' => 'ProductKeyUp($(this).val().split("_").pop(), $(this).val().split("_")[0]);'
                                                ]) !!}
                                            </td>
                                             <td>
                                                {!! Form::text('remarks1', null, [
                                                'id' => 'remarks1',
                                                'class' => 'form-control input-sm'
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
                                                'oninput' => 'validateFourDecimals(this)',
                                                'onkeyup' => 'QuantityKeyUp3($(this).val())',
                                                'onkeypress' => 'return onlyNumberKey(event)',
                                                'onpaste' => 'return false;',
                                                'ondrop' => 'return false;',
                                                'autocomplete' => 'off',
                                                ]) !!}
                                            </td>

                                            <td>
                                                {!! Form::text('price_per_unit', null, [
                                                'id' => 'price_per_unit',
                                                'class' => 'form-control input-sm',
                                                'onkeypress' => 'return onlyNumberKey(event)',
                                                'oninput' => 'validateFourDecimals(this)',
                                                'onkeyup' => 'QuantityKeyUp($(this).val())',
                                                'onpaste' => 'return false;',
                                                'ondrop' => 'return false;',
                                                'autocomplete' => 'off',
                                                ]) !!}
                                            </td>
                                            <td>
                                                {!! Form::text('ValueExTax', null, [
                                                'id' => 'ValueExTax',
                                                'class' => 'form-control input-sm',
                                                'onkeyup' => 'SaleValKeyUp()',
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

                                        
                                            @if($sellerCompany->discount == 1 || $sellerCompany->discount_fixed == 1)
                                            <td>
                                                {!! Form::text('discount', null, [
                                                'id' => 'discount',
                                                'onkeyup' => 'QuantityKeyUp()',
                                                'class' => 'form-control input-sm'
                                                ]) !!}
                                            </td>
                                            <td style="display: none;">
                                                {!! Form::text('discount_value', null, [
                                                'id' => 'discount_value',
                                                'class' => 'form-control input-sm'
                                                ]) !!}
                                            </td>
                                            @endif
                                            @if($sellerCompany->discount2 == 1 || $sellerCompany->discount_fixed2 == 1)
                                            <td>
                                                {!! Form::text('discount2', null, [
                                                'id' => 'discount2',
                                                'onkeyup' => 'QuantityKeyUp()',
                                                'class' => 'form-control input-sm'
                                                ]) !!}
                                            </td>
                                            <td style="display: none;">
                                                {!! Form::text('discount_value2', null, [
                                                'id' => 'discount_value2',
                                                'class' => 'form-control input-sm'
                                                ]) !!}
                                            </td>
                                            @endif
                                            <td>
                                                {!! Form::text('amount', null, [
                                                'id' => 'amount',
                                                'class' => 'form-control input-sm',
                                                'disabled' => 'disabled'
                                                ]) !!}
                                            </td>
                                             @if($sellerCompany->show_fbr_qty ==1)
                                                <td>
                                                {!! Form::text('fbr_qty', null, [
                                                'id' => 'fbr_qty',
                                                'class' => 'form-control input-sm'
                                                ]) !!}
                                                </td>
                                            @endif
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
                                                <button type="button"
                                                    onclick="AddGridData()"
                                                    onkeyup="AddGridData()"
                                                    class="btn btn-success btn-sm">
                                                    Add
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                            <div class="form-group">
                                <table id="myData" class="table table-condensed">
                                    @php $totalqty = 0; $totaltax = 0; $totalexclusive = 0; $totalinclusive = 0; @endphp
                                    @foreach($edit->saletax_details as $details)
                                    @php
                                    $totalqty += $details->quantity;
                                    $totaltax += $details->taxvalue;
                                    $totalexclusive += $details->price;
                                    $totalinclusive += $details->total;
                                    @endphp
                                    <tr>
                                        <td style="display:none;">
                                            @if($details->products)
                                            <input id="test" value="{{$details->products->id}}" type="text" class="form-control input-sm" disabled>
                                            <input id="product_id1" name="product_id1[]" value="{{$details->products->id}}" type="hidden">
                                            @else
                                            <input id="test" type="text" class="form-control input-sm" disabled>
                                            @endif
                                        </td>

                                        <td width="7%">
                                            @if($details->products)
                                            <input id="test" value="{{$details->products->product_code}}" type="text" class="form-control input-sm" disabled>
                                            <input id="product_code" name="product_code[]" value="{{$details->products->product_code}}" type="hidden">
                                            @else
                                            <input id="test" type="text" class="form-control input-sm" disabled>
                                            @endif
                                        </td>
                                        @if($details->products)
                                        <td style="display:none;">
                                            <input id="test" value="{{$details->products->id}}" type="text" class="form-control input-sm" disabled>
                                        </td>
                                        @else
                                        <td style="display:none;">
                                            <input id="test" type="text" class="form-control input-sm" disabled>
                                        </td>
                                        @endif

                                        <td width="15%">
                                            @if($details->products)
                                            <input id="test" value="{{$details->products->product_name}}" type="text" class="form-control input-sm" disabled>
                                            <input id="product_name" value="{{$details->products->product_name}}" name="product_name[]" type="hidden">
                                            @else
                                            <input id="test" type="text" class="form-control input-sm" disabled>
                                            @endif
                                        </td>

                                         <td width="10%">
                                            <input id="remarks1" name="remarks1[]" value="{{$details->remarks}}" type="text" class="form-control input-sm">
                                        </td>

                                        <td style="display:none;">
                                            <input id="uom_id" name="uom_id[]" value="{{$details->uom_id}}" type="hidden">
                                        </td>

                                        <td width="5%">
                                            <input id="uom" name="uom[]" value="{{$details->fbr_uom_desc}}" type="text" class="form-control input-sm" readonly>
                                        </td>

                                        <td width="6%">
                                            <input id="quantity" name="quantity[]" value="{{$details->quantity}}" type="text" class="form-control input-sm"
                                                onkeyup="QuantityKeyUp1($(this).closest('tr').index());">
                                            <!-- <input id="quantity" name="quantity[]" value="{{$details->quantity}}" type="hidden"> -->
                                        </td>

                                        <td width="6%">
                                            <input id="rate" name="rate[]" value="{{$details->rate}}" type="text" class="form-control input-sm"
                                            onkeyup="QuantityKeyUp1($(this).closest('tr').index());">
                                            <!-- <input id="rate" name="rate[]" value="{{$details->rate}}" type="hidden"> -->
                                        </td>
                                        <td width="8%">
                                            <!-- <input id="excvalue" name="excvalue[]" value="{{$details->price}}" type="text" class="form-control input-sm" readonly onkeyup="SaleValKeyUp1($(this).closest('tr').index());"> -->
                                            <input id="excvalue" name="excvalue[]" value="{{$details->price}}" type="text" class="form-control input-sm" readonly>
                                            <!-- <input id="excvalue" name="excvalue[]" value="{{$details->price}}" type="hidden"> -->
                                        </td>
                                        <td width="5%">
                                            <input id="stvalue" name="stvalue[]" value="{{$details->stvalue}}" type="text" class="form-control input-sm" readonly>
                                            <!-- <input id="stvalue" name="stvalue[]" value="{{$details->stvalue}}" type="hidden"> -->
                                        </td>

                                        <td width="8%">
                                            <input id="taxvalue" name="taxvalue[]" value="{{$details->taxvalue}}" type="text" class="form-control input-sm">
                                            <!-- <input id="taxvalue" name="taxvalue[]" value="{{$details->taxvalue}}" type="hidden"> -->
                                        </td>

                                        <td width="5%">
                                            <input id="extratax" name="extratax[]" value="{{$details->extratax}}" type="text" class="form-control input-sm" 
                                            onkeyup="QuantityKeyUp1($(this).closest('tr').index());">
                                            <!-- <input id="extratax" name="extratax[]" value="{{$details->extratax}}" type="hidden"> -->
                                        </td>

                                        <td style="display:none;">
                                            <input id="extraTaxValue" name="extraTaxValue[]" value="{{$details->extraTaxValue}}" type="text" class="form-control input-sm" readonly>
                                            <!-- <input id="extraTaxValue" name="extraTaxValue[]" value="{{$details->extraTaxValue}}" type="hidden"> -->
                                        </td>

                                      
                                        @if($sellerCompany->discount == 1 || $sellerCompany->discount_fixed == 1)
                                        <td width="5%">
                                            <input id="discount" name="discount[]" value="{{$details->discount}}" type="text" class="form-control input-sm" 
                                            onkeyup="QuantityKeyUp1($(this).closest('tr').index());">
                                            <!-- <input id="discount" name="discount[]" value="{{$details->discount}}" type="hidden"> -->
                                            <input id="discount_value" name="discount_value[]" value="{{$details->discount_value}}" type="hidden">
                                        </td>
                                        @endif
                                        @if($sellerCompany->discount2 == 1 || $sellerCompany->discount_fixed2 == 1)
                                        <td width="5%">
                                            <input id="discount2" name="discount2[]" value="{{$details->discount2}}" type="text" class="form-control input-sm" 
                                            onkeyup="QuantityKeyUp1($(this).closest('tr').index());">
                                            <!-- <input id="discount2" name="discount2[]" value="{{$details->discount2}}" type="hidden"> -->
                                            <input id="discount2_value" name="discount2_value[]" value="{{$details->discount2_value}}" type="hidden">
                                        </td>
                                        @endif
                                        <td width="10%">
                                            <input id="incvalue" name="incvalue[]" value="{{$details->total}}" type="text" class="form-control input-sm" readonly>
                                            <!-- <input id="incvalue" name="incvalue[]" value="{{$details->total}}" type="hidden"> -->
                                        </td>
                                        <td style="display:none;">
                                            <input id="TotalTax" name="TotalTax[]" value="{{$details->taxvalue + $details->extraTaxValue}}" type="text" class="form-control input-sm" readonly>
                                            <!-- <input id="TotalTax" name="TotalTax[]" value="{{$details->taxvalue + $details->extraTaxValue}}" type="hidden"> -->
                                        </td>

                                        @if($sellerCompany->show_fbr_qty == 1)
                                        <td width="6%">
                                            <input id="fbr_qty" name="fbr_qty[]" value="{{$details->fbr_qty}}" type="text" class="form-control input-sm">
                                            <!-- <input id="incvalue" name="incvalue[]" value="{{$details->total}}" type="hidden"> -->
                                        </td>
                                        @endif

                                        <td width="8%" class="sro-col">
                                            <select name="sro_schd_no[]" class="form-control input-sm js-sro-schedule" data-selected="{{$details->sro_schd_no}}">
                                                @if($details->sro_schd_no)
                                                    <option value="{{$details->sro_schd_no}}" selected>{{$details->sro_schd_no}}</option>
                                                @else
                                                    <option value="" selected>Select Schedule</option>
                                                @endif
                                            </select>
                                        </td>

                                        <td width="8%" class="sro-item-col">
                                            <select name="sro_item_no[]" class="form-control input-sm js-sro-item" data-selected="{{$details->sro_item_no}}">
                                                @if($details->sro_item_no)
                                                    <option value="{{$details->sro_item_no}}" selected>{{$details->sro_item_no}}</option>
                                                @else
                                                    <option value="" selected>Choose</option>
                                                @endif
                                            </select>
                                        </td>

                                        <td width="8%" class="action-col">
                                            <button type="button" onclick="javascript:myDeleteFunction($(this).closest('tr'));" class="btn btn-danger btn-sm">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="summary-container">
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card summary-card">
                                    <div class="card-body py-3">
                                        <div class="row align-items-center text-center">
                                            <div class="col-6 col-md-3 stat-item">
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="stat-label">
                                                        <i class="fas fa-file-invoice-dollar fa-xs"></i>TOTAL QTY
                                                    </span>

                                                    <input type="text" class="form-control stat-value"
                                                        value="{{number_format($totalqty)}}" id="TotalQty" name="TotalQty" readonly>
                                                </div>
                                            </div>
                                              <div class="col-6 col-md-3 stat-item">
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="stat-label">
                                                        <i class="fas fa-file-invoice-dollar fa-xs"></i>EXC VALUE
                                                    </span>
                                                    <input type="text" class="form-control stat-value"
                                                        value="{{number_format($totalexclusive)}}" id="TotalExTax" name="TotalExTax" readonly>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3 stat-item">
                                                <div class="d-flex flex-column align-items-center">

                                                    <span class="stat-label">
                                                        <i class="fas fa-receipt fa-xs"></i>TAX VALUE
                                                    </span>

                                                    <input type="text" class="form-control stat-value"
                                                        value="{{number_format($totaltax)}}" id="TotalTaxValue" name="TotalTaxValue" readonly>
                                                </div>
                                            </div>
                                          
                                            <div class="col-6 col-md-3 stat-item">
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="stat-label">
                                                        <i class="fas fa-money-bill-wave fa-xs"></i>INCLUSIVE VALUE
                                                    </span>
                                                    <input type="text" class="form-control stat-value"
                                                        value="{{number_format($totalinclusive)}}" id="TotalAmount" name="TotalAmount" readonly>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3 stat-item">
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="stat-label">
                                                        <i class="fas fa-money-bill-wave fa-xs"></i>Advance Income Tax % <br/> 236G/236H
                                                    </span>
                                                    <input type="text" id="advance_income_tax" value="{{$edit->advance_income_tax}}" name="advance_income_tax"
                                                        onkeyup="AdvanceIncomeTax($(this).val())"
                                                        class="form-control stat-value" style="background-color: white">
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3 stat-item">
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="stat-label">
                                                        <i class="fas fa-money-bill-wave fa-xs"></i>Total Income Tax
                                                    </span>
                                                    <input type="text" id="total_income_tax" name="total_income_tax" value="{{number_format($edit->total_income_tax)}}" class="form-control stat-value" readonly>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3 stat-item">
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="stat-label">
                                                        <i class="fas fa-money-bill-wave fa-xs"></i>Total Amount
                                                    </span>
                                                    <input type="text" value="{{number_format($totalinclusive+$edit->total_income_tax)}}" id="GrandAmount" name="GrandAmount" class="form-control stat-value" readonly>
                                                </div>
                                            </div>
                                               @if($sellerCompany->st_held ==1)
                                            <div class="col-6 col-md-3 stat-item">
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="stat-label" style="color: red;">
                                                        <i class="fas fa-money-bill-wave fa-xs"></i>20% ST Withheld At Source 
                                                    </span>
                                                   <input class="form-check-input" type="checkbox" value="1" id="withheld_at_source" name="withheld_at_source" <?= $edit->withheld_at_source == 1 ? 'checked' : '' ?>>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="row">
                        <div class="col-12 text-center">
                            <button type="button" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm" id="btnSave" name="btnSave">
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
 var customerType = "{{ $edit->parties->customer_type }}";
    if(customerType == "Unregistered"){
        $('#CusName').show();
        $('#CusCnic').show();
    }else{
        $('#CusName').hide(); 
        $('#CusCnic').hide(); 
    }

    var initialSroSchedule = @json(optional($edit->saletax_details->first())->sro_schd_no);
    var initialSroItem = @json(optional($edit->saletax_details->first())->sro_item_no);

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
function SaleValKeyUp(){
    var quantity = document.getElementById('quantity').value;
    var saleValue = document.getElementById('ValueExTax').value;
    var rate = saleValue / quantity;
    document.getElementById('price_per_unit').value = rate.toFixed(4);

    var tax = document.getElementById('stvalue').value;
    // var totaltax = (rate / 100 * tax) * quantity;
    var scenario = document.getElementById('scenario_id').value;
    var taxx = tax / 100;
    if(scenario == 14 || scenario == 28){
    // var totaltax = rate * taxx;
    var totaltax = (rate * quantity) * taxx;
    }else{
    // var totaltax = (rate / 100 * tax) * quantity;
    var totaltax = (rate * quantity) * taxx;
    }
    // document.getElementById('taxvalue').value = totaltax.toFixed(2);
    document.getElementById('taxvalue').value = Math.round(totaltax * 100) / 100;
}

    function QuantityKeyUp() {
    var DiscPer = '{{ $sellerCompany->discount }}';
    var DiscPer2 = '{{ $sellerCompany->discount2 }}';
    var DiscFixed = '{{ $sellerCompany->discount_fixed }}';
    var DiscFixed2 = '{{ $sellerCompany->discount_fixed2 }}';
    // alert(DiscPer);
    // alert(DiscPer2);
    // alert(DiscFixed);
    // alert(DiscFixed2);
    var quantity = document.getElementById('quantity').value;
    var tax = document.getElementById('stvalue').value;
    var extratax = document.getElementById('extratax').value;
    var price = document.getElementById('price_per_unit').value;
    // var totaltax = (price / 100 * tax) * quantity;
      var scenario = document.getElementById('scenario_id').value;
    // alert(scenario);
    var taxx = tax / 100;
    if(scenario == 14 || scenario == 28){
     var totaltax = price * taxx;
    //   var subtotal = price * quantity;
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
    document.getElementById('taxvalue').value = totaltax.toFixed(2);
    // document.getElementById('taxvalue').value = Math.round(totaltax * 100) / 100;
    // document.getElementById('taxvalue').value = Math.round((totaltax + Number.EPSILON) * 100) / 100;
    document.getElementById('extraTaxValue').value = extratax;
    var valueWithoutTax = quantity * price;
    document.getElementById('ValueExTax').value = valueWithoutTax.toFixed(2);
    total = (quantity * price) + totaltax + extratax;
    document.getElementById('amount').value = total.toFixed(2);

     var discount = document.getElementById('discount').value;
     if(discount){
        if(DiscPer == 1){
                    //percentage
        var discountValue = total / 100 * discount;
        var grandamount = total - discountValue;
        document.getElementById('discount_value').value = discountValue;
        document.getElementById('amount').value = grandamount.toFixed(2);
        }

        if(DiscFixed == 1){
        //Fixed
        var grandamount = total - discount;
        document.getElementById('discount_value').value = discount;
        document.getElementById('amount').value = grandamount.toFixed(2);
        }
     }
      var discount2 = document.getElementById('discount2').value;
     if(discount2){
        if(DiscPer2 == 1){
        //percentage
        var discountValue = total / 100 * discount;
        var grandamount = total - discountValue;
        var discountValue2 = grandamount / 100 * discount2;
        var grandamount2 = grandamount - discountValue2;
        document.getElementById('discount_value2').value = discountValue2;
        document.getElementById('amount').value = grandamount2.toFixed(2);
        }

         if(DiscFixed2 == 1){
        //Fixed
            var discountValue = total - discount;
            var grandamount2 = discountValue - discount2;
            document.getElementById('discount_value2').value = discount2;
            document.getElementById('amount').value = grandamount2.toFixed(2);
         }
     }
}



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
        if (discountCheck == 1 || discountFixed == 1) {
            var discount = document.getElementById('discount').value;
            var discountValue = document.getElementById('discount_value').value;
        }
        if (discountCheck2 == 1 || discountFixed2 == 1) {
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
        tableHtml += `<td width="10%">
                <input id="remarks1" value="${remarks1}" name="remarks1[]" type="text" class="form-control input-sm">
              </td>`;

        tableHtml += `<td style="display:none;">
                <input id="uom_id" name="uom_id[]" value="${UOMID}" type="hidden">
              </td>`;

        tableHtml += `<td width="5%">
                <input id="uom" name="uom[]" value="${UOM}" type="text" class="form-control input-sm" readonly>
              </td>`;

        tableHtml += `<td width="6%">
                <input id="quantity" name="quantity[]" value="${Quantity}" type="text" class="form-control input-sm" 
                onkeyup="QuantityKeyUp1($(this).closest('tr').index());">
              </td>`;

        tableHtml += `<td width="6%">
                <input id="rate" name="rate[]" value="${Price}" type="text" class="form-control input-sm" 
                onkeyup="QuantityKeyUp1($(this).closest('tr').index());">
              </td>`;
            //    onkeyup="SaleValKeyUp1($(this).closest('tr').index());
         tableHtml += `<td width="8%">
                <input id="excvalue" name="excvalue[]" value="${ValueExTax}" type="text" class="form-control input-sm" readonly>
              </td>`;
        tableHtml += `<td width="5%">
                <input id="stvalue" name="stvalue[]" value="${STValue}" type="text" class="form-control input-sm" readonly>
              </td>`;

        tableHtml += `<td width="8%">
                <input id="taxvalue" name="taxvalue[]" value="${TaxValue}" type="text" class="form-control input-sm" readonly>
              </td>`;

        tableHtml += `<td width="5%">
                <input id="extratax" name="extratax[]" value="${ExtraTax}" type="text" class="form-control input-sm" 
                onkeyup="QuantityKeyUp1($(this).closest('tr').index());">
              </td>`;

        tableHtml += `<td style="display:none;">
                <input id="extraTaxValue" name="extraTaxValue[]" value="${ExtraTaxValue}" type="text" class="form-control input-sm" readonly>
              </td>`;

       
        if (discountCheck == 1 || discountFixed == 1) {
            tableHtml += `<td width="5%">
                <input id="discount" name="discount[]" value="${discount}" type="text" class="form-control input-sm" 
                onkeyup="QuantityKeyUp1($(this).closest('tr').index());">
                <input id="discount_value" name="discount_value[]" value="${discountValue}" type="hidden">
              </td>`;
        }
        if (discountCheck2 == 1 || discountFixed2 == 1) {
            tableHtml += `<td width="5%">
                <input id="discount2" name="discount2[]" value="${discount2}" type="text" class="form-control input-sm"
                onkeyup="QuantityKeyUp1($(this).closest('tr').index());">
                <input id="discount2_value" name="discount2_value[]" value="${discountValue2}" type="hidden">
              </td>`;
        }

        tableHtml += `<td width="10%">
                <input id="incvalue" name="incvalue[]" value="${Amount}" type="text" class="form-control input-sm" readonly>
              </td>`;

        tableHtml += `<td style="display:none;">
                <input id="TotalTax" name="TotalTax[]" value="${TotalTax}" type="text" class="form-control input-sm" readonly>
              </td>`;
        if(showfbrqty == 1){
            tableHtml += `<td width="6%">
                <input id="fbr_qty" name="fbr_qty[]" value="${FBRQty}" type="text" class="form-control input-sm">
              </td>`;
            }
                tableHtml += `<td width="8%" class="sro-col">
                                <select name="sro_schd_no[]" class="form-control input-sm js-sro-schedule" data-selected="${SroSchd}">
                                        <option value="${SroSchd}" selected>${SroSchd || 'Select Schedule'}</option>
                                </select>
                            </td>`;

                tableHtml += `<td width="8%" class="sro-item-col">
                                <select name="sro_item_no[]" class="form-control input-sm js-sro-item" data-selected="${SroItem}">
                                        <option value="${SroItem}" selected>${SroItem || 'Choose'}</option>
                                </select>
                            </td>`;

                tableHtml += `<td width="8%" class="action-col">
                <button type="button" onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="btn btn-danger btn-sm">
                  Delete
                </button>
              </td>`;

        tableHtml += '</tr>';
        $('#myData').append(tableHtml);
        initGridSroSelects($('#myData'));
        refreshGridSroSchedules($('#scenario_id').val());

        TotalQuantity();
        TotalTaxes();
        TotalExTax();
        TotalAmount();
        // $('#product_name').val(0).select2();
        $('#quantity').val(null);
        $('#price_per_unit').val(null);
        $('#ValueExTax').val(null);
        $('#extratax').val(null);
        $('#discount').val(null);
        $('#product_name').val(null).select2();
        $('#product_name').select2('open');
        
        
        // document.getElementById("product_code").focus();

    }



function TotalQuantity() {
    var tableData = document.getElementById('myData');
    var sum = 0;
    // Get all input elements that contain "rate" in their ID
    var rateInputs = tableData.querySelectorAll('input[id*="quantity"]');
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


// function TotalTaxes() {
//     var tableData = document.getElementById('myData');
//     var sum = 0;
//     for (var i = 0; i < tableData.rows.length; i++) {
//         if (tableData.rows[i].cells[10].getElementsByTagName('input')[0].value == '') {
//             sum += 0;
//         } else {
//             sum += parseFloat(tableData.rows[i].cells[10].getElementsByTagName('input')[0].value);
//             // alert(sum);
//         }
//     }
//     document.getElementById('TotalTaxValue').value = sum.toLocaleString('en-US');
// }


function TotalTaxes() {
    var tableData = document.getElementById('myData');
    var sum = 0;
    // Get all input elements that contain "rate" in their ID
    var rateInputs = tableData.querySelectorAll('input[id*="taxvalue"]');
    for (var i = 0; i < rateInputs.length; i++) {
        var value = rateInputs[i].value.trim();
        if (value === '') {
            sum += 0;
        } else {
            sum += parseFloat(value);
        }
    } 
    document.getElementById('TotalTaxValue').value = sum.toLocaleString('en-US');
}


// function TotalExTax() {
//     var tableData = document.getElementById('myData');
//     var sum = 0;
//     for (var i = 0; i < tableData.rows.length; i++) {
//         if (tableData.rows[i].cells[13].getElementsByTagName('input')[0].value == '') {
//             sum += 0;
//         } else {
//             sum += parseFloat(tableData.rows[i].cells[13].getElementsByTagName('input')[0].value);
//             // alert(sum);
//         }
//     }
//     document.getElementById('TotalExTax').value = sum.toLocaleString('en-US');
// }

function TotalExTax() {
    var tableData = document.getElementById('myData');
    var sum = 0;
    // Get all input elements that contain "rate" in their ID
    var rateInputs = tableData.querySelectorAll('input[id*="excvalue"]');
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
    var tableData = document.getElementById('myData');
    var sum = 0;
    // Get all input elements that contain "rate" in their ID
    var rateInputs = tableData.querySelectorAll('input[id*="incvalue"]');
    for (var i = 0; i < rateInputs.length; i++) {
        var value = rateInputs[i].value.trim();
        if (value === '') {
            sum += 0;
        } else {
            sum += parseFloat(value);
        }
    } 
    document.getElementById('TotalAmount').value = sum.toLocaleString('en-US');
}



    function SaleRateKeyUp(SaleRate, RowIndex) {
        var quantity = $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('6')").text();
        var tax = $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('9')").val();
    }

    function QuantityKeyUp1(RowIndex) {
          var DiscPer = '{{ $sellerCompany->discount }}';
    var DiscPer2 = '{{ $sellerCompany->discount2 }}';
    var DiscFixed = '{{ $sellerCompany->discount_fixed }}';
    var DiscFixed2 = '{{ $sellerCompany->discount_fixed2 }}';
        // var quantity = $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('6')").val();
        var quantity = $('tr:eq(' + RowIndex + ')', myData).find('[id*="quantity"]').val();
        var tax = $('tr:eq(' + RowIndex + ')', myData).find('[id*="stvalue"]').val();
        var extratax = $('tr:eq(' + RowIndex + ')', myData).find('[id*="extratax"]').val();
        var price = $('tr:eq(' + RowIndex + ')', myData).find('[id*="rate"]').val();
        // var totaltax = (price / 100 * tax) * quantity;
          var scenario = document.getElementById('scenario_id').value;
           var taxx = tax / 100;
          if(scenario == 14 || scenario == 28){
            var totaltax = price * taxx;
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
        $('tr:eq(' + RowIndex + ')', myData).find('[id*="taxvalue"]').val(Math.round(totaltax * 100) / 100);
        // document.getElementById('extraTaxValue').value = extratax;
        $('tr:eq(' + RowIndex + ')', myData).find('[id*="extraTaxValue"]').val(extratax.toFixed(2));
        var valueWithoutTax = quantity * price;
        // document.getElementById('ValueExTax').value = valueWithoutTax.toFixed(2);
        $('tr:eq(' + RowIndex + ')', myData).find('[id*="excvalue"]').val(valueWithoutTax.toFixed(2));
        total = (quantity * price) + totaltax + extratax;
        // document.getElementById('amount').value = total.toFixed(2);
        $('tr:eq(' + RowIndex + ')', myData).find('[id*="incvalue"]').val(total.toFixed(2));


        var discount = $('tr:eq(' + RowIndex + ')', myData).find('[id*="discount"]').val();
        if(discount){
            if(DiscPer == 1){
            //Percentage
                var discountValue = total / 100 * discount;
                var grandamount = total - discountValue;
                $('tr:eq(' + RowIndex + ')', myData).find('[id*="discount_value"]').val(discountValue.toFixed(2));
                $('tr:eq(' + RowIndex + ')', myData).find('[id*="incvalue"]').val(grandamount.toFixed(2));
            }
            
            if(DiscFixed == 1){
                //Fixed
                var grandamount = total - discount;
                $('tr:eq(' + RowIndex + ')', myData).find('[id*="discount_value"]').val(discount);
                $('tr:eq(' + RowIndex + ')', myData).find('[id*="incvalue"]').val(grandamount.toFixed(2));
                // document.getElementById('discount_value').value = discount;
                // document.getElementById('amount').value = grandamount.toFixed(2);
            }

        }
        var discount2 = $('tr:eq(' + RowIndex + ')', myData).find('[id*="discount2"]').val();
        if(discount2){
            if(DiscPer2 == 1){
                //Percent
                var discountValue = total / 100 * discount;
                var grandamount = total - discountValue;
                var discountValue2 = grandamount / 100 * discount2;
                var grandamount2 = grandamount - discountValue2;
                // document.getElementById('discount_value2').value = discountValue2;
                // document.getElementById('amount').value = grandamount2;
                $('tr:eq(' + RowIndex + ')', myData).find('[id*="discount_value2"]').val(discountValue2.toFixed(2));
                $('tr:eq(' + RowIndex + ')', myData).find('[id*="incvalue"]').val(grandamount2.toFixed(2));
            }
            

            if(DiscFixed2 == 1){
                //Fixed
                var discountValue = total - discount;
                var grandamount2 = discountValue - discount2;
                $('tr:eq(' + RowIndex + ')', myData).find('[id*="discount_value2"]').val(discount2.toFixed(2));
                $('tr:eq(' + RowIndex + ')', myData).find('[id*="incvalue"]').val(grandamount2.toFixed(2));
                // document.getElementById('discount_value2').value = discount2;
                // document.getElementById('amount').value = grandamount2.toFixed(2);
            }

        }
    }

    function SaleValKeyUp1(RowIndex){
       
    var quantity = $('tr:eq(' + RowIndex + ')', myData).find('[id*="quantity"]').val();
    var saleValue = $('tr:eq(' + RowIndex + ')', myData).find('[id*="excvalue"]').val();
    var rate = saleValue / quantity;
    $('tr:eq(' + RowIndex + ')', myData).find('[id*="rate"]').val(rate.toFixed(2));
    // document.getElementById('rate').value = rate.toFixed(2);

    //  var tax = document.getElementById('stvalue').value;
    // var totaltax = (rate / 100 * tax) * quantity;


    var tax = $('tr:eq(' + RowIndex + ')', myData).find('[id*="stvalue"]').val();
    var rate1 = (rate / 100 * tax) * quantity;
    $('tr:eq(' + RowIndex + ')', myData).find('[id*="taxvalue"]').val(rate1.toFixed(2));
    // document.getElementById('taxvalue').value = totaltax.toFixed(2);
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

    function ExtraTaxkeyup(taxvalue) {
        var quantity = document.getElementById('quantity').value;
        var price = document.getElementById('price_per_unit').value;
        var stvalue = document.getElementById('stvalue').value;
        // var tax = (stvalue / 100 * price) * quantity;
        var scenario = document.getElementById('scenario_id').value;
         var taxx = stvalue / 100;
        if(scenario == 14 || scenario == 28){
        // var tax = price * taxx;
        var tax = (price * quantity) * taxx;
        }else{
        // var tax = (stvalue / 100 * price) * quantity;
        var tax = (price * quantity) * taxx;
        }
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
                    $("#price_per_unit").val(result[0].price_per_unit);
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
                } else {
                    $('#party_id').val("");
                    $('#address').val("");
                    $('#strn').val("");
                    $('#ntn').val("");
                    $('#customer_type').val("");
                    $('#customer_name').val("");
                    $('#customer_cnic').val("");
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
                $(row).remove();
                TotalQuantity();
                TotalTaxes();
                TotalExTax();
                TotalAmount();

                //alertify.alert("File is Removed!");
            }

        });
    }

    function loadSroScheduleOptions(scenarioId, selectedScheduleName, selectedItemNo) {
        if (!scenarioId) {
            $('#sro_schd_no1').html('<option value="">Select Schedule</option>').val('').trigger('change');
            $('#sro_item_no1').html('<option value="">Choose</option>').val('').trigger('change');
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
                    var option = '';
                    option += `<option value="">Select Schedule</option>`;
                    $.each(response.data, function(i, v) {
                        option += `<option value="${v.id}_${v.sro_schedule_name}">${v.sro_schedule_name}</option>`;
                    });
                    $('#sro_schd_no1').html(option);

                    if (selectedScheduleName) {
                        var selectedValue = '';
                        $('#sro_schd_no1 option').each(function() {
                            if ($(this).text().trim() === selectedScheduleName) {
                                selectedValue = $(this).val();
                                return false;
                            }
                        });
                        if (selectedValue) {
                            $('#sro_schd_no1').val(selectedValue).trigger('change');
                            loadSroItemOptions(selectedValue.split('_')[0], scenarioId, selectedItemNo);
                            return;
                        }
                    }

                    $('#sro_schd_no1').val('').trigger('change');
                    $('#sro_item_no1').html('<option value="">Choose</option>').val('').trigger('change');
                } else {
                    $('#sro_schd_no1').html('<option value="0">No Records Found</option>').val('0').trigger('change');
                    $('#sro_item_no1').html('<option value="">No Records Found</option>').val('').trigger('change');
                }
            }
        });
    }

    function loadSroItemOptions(sroScheduleId, scenarioId, selectedItemNo) {
        if (!sroScheduleId) {
            $('#sro_item_no1').html('<option value="">Choose</option>').val('').trigger('change');
            return;
        }
        $('#sro_item_no1')
            .prop('disabled', true)
            .html('<option value="">Loading...</option>')
            .val('')
            .trigger('change');
        if ($('#sro_item_no1').hasClass('select2-hidden-accessible')) {
            $('#sro_item_no1').select2('open');
        }
        $.ajax({
            url: "{{ asset('sro-item/getsroschd/getsroitem') }}",
            type: 'get',
            data: {
                sro_schd_id: sroScheduleId,
                scenario_id: scenarioId
            },
            dataType: 'json',
            success: function(response) {
                $('#sro_item_no1').prop('disabled', false);
                if (response.data != '') {
                    var option = '';
                    option += `<option value="">Choose</option>`;
                    $.each(response.data, function(i, v) {
                        option += `<option value="${v.sro_item_no}">${v.sro_item_no}</option>`;
                    });
                    $('#sro_item_no1').html(option);

                    if (selectedItemNo) {
                        $('#sro_item_no1').val(selectedItemNo).trigger('change');
                    } else {
                        $('#sro_item_no1').val('').trigger('change');
                    }
                } else {
                    $('#sro_item_no1').html('<option value="">No Records Found</option>').val('').trigger('change');
                }
                if ($('#sro_item_no1').hasClass('select2-hidden-accessible')) {
                    $('#sro_item_no1').select2('open');
                }
            }
        });
    }

    $('#scenario_id').change(function() {
        loadSroScheduleOptions($(this).val(), '', '');
        refreshGridSroSchedules($(this).val());
    });

    $('#sro_schd_no1').change(function() {
        var sro_schd_id = $(this).val().split("_")[0];
        var scenario_id = $("#scenario_id").val();
        $('#sro_item_no1')
            .prop('disabled', true)
            .html('<option value="">Loading...</option>')
            .val('')
            .trigger('change');
        if ($('#sro_item_no1').hasClass('select2-hidden-accessible')) {
            $('#sro_item_no1').select2('open');
        }
        loadSroItemOptions(sro_schd_id, scenario_id, '');
    });

    loadSroScheduleOptions($('#scenario_id').val(), initialSroSchedule, initialSroItem);
    initGridSroSelects($(document));
    loadInitialGridSroOptions($('#scenario_id').val());

    function loadInitialGridSroOptions(scenarioId) {
        if (!scenarioId) return;
        
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
                        var selectedName = $select.data('selected') || '';
                        
                        if (selectedName) {
                            var option = '<option value="">Select Schedule</option>';
                            var matchedId = '';
                            
                            $.each(response.data, function(i, v) {
                                option += `<option value="${v.sro_schedule_name}" data-id="${v.id}">${v.sro_schedule_name}</option>`;
                                if (v.sro_schedule_name === selectedName) {
                                    matchedId = v.id;
                                }
                            });
                            
                            $select.html(option);
                            $select.val(selectedName);
                            
                            if (matchedId) {
                                var $row = $select.closest('tr');
                                var selectedItem = $row.find('.js-sro-item').data('selected') || '';
                                loadGridSroItems($row, scenarioId, matchedId, selectedItem);
                            }
                        }
                    });
                    initGridSroSelects($(document));
                }
            }
        });
    }

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

    function loadGridSroItems($row, scenarioId, scheduleId, selectedItemNo) {
        if (!scheduleId) {
            $row.find('.js-sro-item').html('<option value="">Choose</option>').val('').trigger('change');
            return;
        }
        var $itemSelect = $row.find('.js-sro-item');
        $itemSelect
            .prop('disabled', true)
            .html('<option value="">Loading...</option>')
            .val('')
            .trigger('change');
        if ($itemSelect.hasClass('select2-hidden-accessible')) {
            $itemSelect.select2('open');
        }
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
                if ($itemSelect.hasClass('select2-hidden-accessible')) {
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
            .prop('disabled', true)
            .html('<option value="">Loading...</option>')
            .val('')
            .trigger('change');
        if ($itemSelect.hasClass('select2-hidden-accessible')) {
            $itemSelect.select2('open');
        }
        loadGridSroItems($row, scenarioId, scheduleId, $row.find('.js-sro-item').data('selected'));
    });

    $(document).on('change', '.js-sro-item', function() {
        $(this).data('selected', $(this).val());
    });



    $("#btnSave").click(function() {
        // alert("dd");
        // $('#btnSave').attr('disabled', true);
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