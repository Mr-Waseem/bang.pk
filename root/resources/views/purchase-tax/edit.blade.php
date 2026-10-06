@extends("app")
@section('contents')
<head>
<link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <style>
    body {
        background-color: #f8f9fa;
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
    }
    .summary-container { width: 100%; max-width: none; margin: 6px 0 16px; padding: 0; }
    .summary-card { border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05), 0 1px 3px rgba(0,0,0,0.1); background: #fff; }
    .summary-card .card-body { padding: 1rem 1.25rem !important; }
    .summary-row { display: flex; flex-wrap: nowrap; align-items: stretch; gap: 8px; overflow-x: auto; }
    .summary-row .stat-item { flex: 1 1 0; min-width: 115px; padding: 4px 2px; display: flex; flex-direction: column; align-items: stretch; justify-content: flex-end; }
    .summary-row .stat-label { color: #343a40; font-size: 12px !important; font-weight: 700; text-transform: uppercase; margin-bottom: 6px; text-align: center; line-height: 1.25; display: block; }
    .summary-row .stat-value { background-color: #f8f9fa; border: 1px solid #ced4da; border-radius: 8px; text-align: center; font-weight: 700; font-size: 18px !important; color: #212529; padding: 0.5rem 0.35rem; width: 100%; min-height: 44px; box-shadow: inset 0 1px 2px rgba(0,0,0,0.03); }
    .st-wrap .st-meta-section { background: #f8f9fa; border: 1px solid #e9ecef; border-radius: 8px; padding: 10px 12px; margin-bottom: 14px; }
    .st-wrap .st-meta-row { display: grid; grid-template-columns: repeat(12, 1fr); gap: 6px 8px; align-items: end; margin-bottom: 10px; }
    .st-wrap .st-meta-row:last-child { margin-bottom: 0; }
    .st-wrap .st-meta-field { min-width: 0; }
    .st-wrap .st-meta-field label { display: block; margin-bottom: 3px; font-size: 11px; font-weight: 600; color: #495057; text-transform: uppercase; }
    .st-wrap .st-meta-row--1 .st-meta-field--date { grid-column: span 2; }
    .st-wrap .st-meta-row--1 .st-meta-field--remarks { grid-column: span 3; }
    .st-wrap .st-meta-row--1 .st-meta-field--vr { grid-column: span 2; }
    .st-wrap .st-meta-row--1 .st-meta-field--grn { grid-column: span 3; }
    .st-wrap .st-meta-row--1 .st-meta-field--invoice { grid-column: span 2; }
    .st-wrap .st-meta-row--3 .st-meta-field--party { grid-column: span 4; }
    .st-wrap .st-meta-row--3 .st-meta-field--address { grid-column: span 5; }
    .st-wrap .st-meta-row--3 .st-meta-field--ntn { grid-column: span 3; }
    .st-wrap .st-meta-field .form-control, .st-wrap .st-meta-field .select2-container { width: 100% !important; max-width: 100%; }
    .st-wrap .st-meta-field .form-control { height: 32px; font-size: 13px; padding: 4px 8px; border-color: #ced4da; }
    .st-wrap .st-meta-field .select2-container .select2-selection--single { height: 32px !important; border-color: #ced4da; }
    .st-wrap .st-meta-field .select2-selection__rendered { line-height: 30px !important; font-size: 13px; }
    .st-wrap .st-readonly { background-color: #f1f3f5 !important; color: #495057; }
    .st-wrap .st-grid-panel { border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; margin-bottom: 12px; background: #fff; }
    .st-wrap .st-grid-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .st-wrap .st-table { width: 100%; min-width: 1100px; margin-bottom: 0; border-collapse: collapse; table-layout: fixed; }
    .st-wrap .st-table th { background: #3498db; color: #fff; font-size: 13px; font-weight: 600; padding: 10px 6px; border: 1px solid #2980b9; white-space: nowrap; }
    .st-wrap .st-table td { padding: 4px 5px; vertical-align: middle; border: 1px solid #e9ecef; font-size: 14px; }
    .st-wrap .st-table tr.st-entry td { background: #f0f7ff; }
    .st-wrap .st-table tr.st-data-row td { background: #fff; }
    .st-wrap .st-table .form-control { height: 36px; padding: 4px 6px; font-size: 14px; margin: 0; width: 100%; box-sizing: border-box; }
    .st-wrap .st-table .btn-sm { min-width: 64px; height: 36px; padding: 4px 10px; font-size: 13px; }
    .st-wrap .st-num input { text-align: right; }
    .st-wrap .st-table .btn-add-line { min-width: 64px; padding: 4px 10px; font-size: 14px; font-weight: 600; }
    @media (max-width: 991px) {
        .st-wrap .st-meta-row--1 .st-meta-field--date,
        .st-wrap .st-meta-row--1 .st-meta-field--vr,
        .st-wrap .st-meta-row--1 .st-meta-field--invoice { grid-column: span 4; }
        .st-wrap .st-meta-row--1 .st-meta-field--remarks,
        .st-wrap .st-meta-row--1 .st-meta-field--grn { grid-column: span 6; }
    }
    @media (max-width: 767px) {
        .st-wrap .st-meta-row--1 .st-meta-field, .st-wrap .st-meta-row--3 .st-meta-field { grid-column: span 12 !important; }
    }
    </style>
</head>
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
                    <div class="panel-heading clearfix">
                        <h2 class="panel-title"><b>Edit PurchaseTax Invoice</b></h2>
                    </div>
                    <div class="panel-body">
                        <input id="token" type="hidden" value="{{ $encrypted_token }}">
                        @include('errors.validation')
                        {!! Form::open(['url' => 'sales', 'class' => 'form-horizontal']) !!}
                        {!! Form::hidden('company_id', session()->get('company_id'), ['id' => 'company_id']) !!}
                        <div class="st-wrap">
                        <div class="st-meta-section">
                            <div class="st-meta-row st-meta-row--1">
                                <div class="st-meta-field st-meta-field--date">
                                    <label for="date">Date</label>
                                    <input id="date" type="date" name="date" value="{{ date('Y-m-d',strtotime($edit->date))}}" class="form-control form-control-sm" autofocus>
                                </div>
                                <div class="st-meta-field st-meta-field--remarks">
                                    <label for="remarks">Remarks</label>
                                    {!! Form::text('remarks', $edit->remarks, ['id' => 'remarks', 'class' => 'form-control form-control-sm']) !!}
                                    {!! Form::hidden('purchase_type', "PurchaseTax Invoice", ['id' => 'purchase_type']) !!}
                                </div>
                                <div class="st-meta-field st-meta-field--vr">
                                    <label for="voucher_no">Voucher No#</label>
                                    {!! Form::text('voucher_no', $edit->voucher_no, ['id' => 'voucher_no', 'class' => 'form-control form-control-sm', 'required' => 'required', 'disabled' => 'disabled']) !!}
                                </div>
                                <div class="st-meta-field st-meta-field--grn">
                                    <label for="p_order">GRN</label>
                                    {!! Form::text('p_order', $edit->p_order, ['id' => 'p_order', 'class' => 'form-control form-control-sm', 'readonly' => 'readonly']) !!}
                                    {!! Form::hidden('biller', Auth::user()->id, ['id' => 'biller']) !!}
                                </div>
                                <div class="st-meta-field st-meta-field--invoice">
                                    <label for="invoice_no1">Invoice#</label>
                                    {!! Form::text('invoice_no1', $edit->invoice_no1, ['id' => 'invoice_no1', 'class' => 'form-control form-control-sm', 'required' => 'required']) !!}
                                </div>
                            </div>
                            <div class="st-meta-row st-meta-row--3">
                                <div class="st-meta-field st-meta-field--party">
                                    <label for="party_name">Select Party</label>
                                    {!! Form::hidden('party_id', $edit->party_id, ['id' => 'party_id']) !!}
                                    {!! Form::select('party_name', $customers, $edit->party_id, ['id' => 'party_name', 'onchange' => 'javascript:PartyKeyUp($(this).val());', 'class' => 'form-control form-control-sm']) !!}
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
                                            <th>H.S Code</th>
                                            <th>Product Name</th>
                                            <th>Unit</th>
                                            <th class="st-num">Qty</th>
                                            <th class="st-num">Rate</th>
                                            <th class="st-num">S.T%</th>
                                            <th class="st-num">Tax.Val</th>
                                            <th class="st-num">Fur.Tax%</th>
                                            <th class="st-num">Exc Val</th>
                                            <th class="st-num">Inc Val</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="st-entry">
                                            {!! Form::hidden('product_id', null, ['id' => 'product_id']) !!}
                                            <td>{!! Form::text('product_code', null, ['id' => 'product_code', 'class' => 'form-control']) !!}</td>
                                            <td>{!! Form::select('product_name', $products, null, ['id' => 'product_name', 'onchange' => 'ProductKeyUp($(this).val().split("_").pop(), $(this).val().split("_")[0]);', 'class' => 'form-control']) !!}</td>
                                            <td style="display:none;">{!! Form::select('uom_id', $uoms, null, ['id' => 'uom_id', 'class' => 'form-control']) !!}</td>
                                            <td>{!! Form::text('uom', null, ['id' => 'uom', 'class' => 'form-control', 'disabled' => 'disabled']) !!}</td>
                                            <td class="st-num">{!! Form::text('quantity', null, ['id' => 'quantity', 'onkeyup' => 'QuantityKeyUp($(this).val())', 'onkeypress' => 'return onlyNumberKey(event)', 'class' => 'form-control', 'onfocus'=>'this.value=""']) !!}</td>
                                            <td class="st-num">{!! Form::text('price_per_unit', null, ['id' => 'price_per_unit', 'onkeyup' => 'SaleRateKeyUpForm($(this).val())', 'onkeypress' => 'return onlyNumberKey(event)', 'onfocus'=>'this.value=""', 'onpaste' => 'return false;', 'ondrop' => 'return false;', 'autocomplete' => 'off', 'class' => 'form-control']) !!}</td>
                                            <td class="st-num">{!! Form::text('stvalue', null, ['id' => 'stvalue', 'class' => 'form-control', 'disabled' => 'disabled']) !!}</td>
                                            <td class="st-num">{!! Form::text('taxvalue', null, ['id' => 'taxvalue', 'class' => 'form-control', 'disabled' => 'disabled']) !!}</td>
                                            <td class="st-num">{!! Form::text('extratax', null, ['id' => 'extratax', 'onkeyup' => 'ExtraTaxkeyup($(this).val());', 'onfocus'=>'this.value=""', 'onkeypress' => 'return onlyNumberKey(event)', 'class' => 'form-control']) !!}</td>
                                            <td style="display:none;">{!! Form::text('extraTaxValue', null, ['id' => 'extraTaxValue', 'onkeypress' => 'return onlyNumberKey(event)', 'onkeyup' => 'AddGridData()', 'class' => 'form-control']) !!}</td>
                                            <td class="st-num">{!! Form::text('ValueExTax', null, ['id' => 'ValueExTax', 'class' => 'form-control', 'disabled' => 'disabled']) !!}</td>
                                            <td class="st-num">{!! Form::text('amount', null, ['id' => 'amount', 'class' => 'form-control', 'disabled' => 'disabled']) !!}</td>
                                            <td><button type="button" onkeyup="AddGridData()" onclick="AddGridData()" class="btn btn-success btn-sm btn-add-line">Add</button></td>
                                                </tr>
                                    <?php $totalPrice = 0; $totalTax = 0; $totalExTax = 0; $totalIncTax = 0; ?>
                                                    @foreach ($edit->purchasetax_details as $PurchaseDetail)
                                    <?php
                                    $totalPrice += $PurchaseDetail->quantity;
                                    $totalTax += $PurchaseDetail->taxvalue;
                                    $totalExTax += $PurchaseDetail->price;
                                    $totalIncTax += $PurchaseDetail->total;
                                    ?>
                                    <tr class="st-data-row">
                                        <td style="display:none;"><input id="test" value="{{ $PurchaseDetail->product_id }}" type="text" class="form-control" disabled></td>
                                        <td><input id="test" value="{{ $PurchaseDetail->products->product_code }}" type="text" class="form-control" disabled></td>
                                        <td><input id="test" value="{{ $PurchaseDetail->products->product_name }}" type="text" class="form-control" disabled></td>
                                        <td style="display:none;"><input id="test" value="{{ $PurchaseDetail->products->uom }}" type="text" class="form-control" disabled></td>
                                        <td><input id="test" value="{{ $PurchaseDetail->products->uom }}" type="text" class="form-control" disabled></td>
                                        <td class="st-num"><input id="test" value="{{ $PurchaseDetail->quantity }}" type="text" class="form-control" disabled></td>
                                        <td class="st-num"><input id="test" value="{{ $PurchaseDetail->rate }}" type="text" class="form-control" disabled></td>
                                        <td class="st-num"><input id="test" value="{{ $PurchaseDetail->stvalue }}" type="text" class="form-control" disabled></td>
                                        <td class="st-num"><input id="test" value="{{ $PurchaseDetail->taxvalue }}" type="text" class="form-control" disabled></td>
                                        <td class="st-num"><input id="test" value="{{ $PurchaseDetail->extratax }}" type="text" class="form-control" disabled></td>
                                        <td style="display:none;"><input id="test" value="{{ $PurchaseDetail->extraTaxValue }}" type="text" class="form-control" disabled></td>
                                        <td class="st-num"><input id="test" value="{{ $PurchaseDetail->price }}" type="text" class="form-control" disabled></td>
                                        <td class="st-num"><input id="test" value="{{ $PurchaseDetail->total }}" type="text" class="form-control" disabled></td>
                                        <td style="display:none;"><input id="test" value="{{ $PurchaseDetail->other }}" type="text" class="form-control" disabled></td>
                                        <td><button type="button" onclick="javascript:myDeleteFunction($(this).closest('tr'));" class="btn btn-danger btn-sm">Delete</button></td>
                                                        </tr>
                                                    @endforeach
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
                                            <input type="text" class="form-control stat-value" id="TotalRate" name="TotalRate" value="{{ $totalPrice }}" readonly>
                                                     </div>
                                        <div class="stat-item">
                                            <span class="stat-label">EXC VALUE</span>
                                            <input type="text" class="form-control stat-value" id="TotalExTax" name="TotalExTax" value="{{ $totalExTax }}" readonly>
                                            </div>
                                        <div class="stat-item">
                                            <span class="stat-label">TAX VALUE</span>
                                            <input type="text" class="form-control stat-value" id="TotalTax" name="TotalTax" value="{{ $totalTax }}" readonly>
                                            </div>
                                        <div class="stat-item">
                                            <span class="stat-label">INCLUSIVE VALUE</span>
                                            <input type="text" class="form-control stat-value" id="TotalAmount" name="TotalAmount" value="{{ $totalIncTax }}" readonly>
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
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<script>
        $("#party_name").select2();
        $("#party_name").next(".select2").find(".select2-selection").focus(function() {
            $("#party_name").select2("open");
        });

        $("#product_name").select2();
        $("#product_name").next(".select2").find(".select2-selection").focus(function() {
            $("#product_name").select2("open");
        });

    </script>

    <script type="text/javascript">
        var myData = '#myTable tbody';

         $('#party_name').change(function() {
            $('#party_name').select2().trigger('select2:close');
            $("#product_code").focus();
        });

        //  $('#product_name').change(function() {
        //      $('#product_name').select2().trigger('select2:close');
        //     //  $('#product_name').select2('open');
        //     $("#quantity").focus();
        // });

        function AddGridData() {
            var date = document.getElementById('date').value;
            // var InvoiceNo = document.getElementById('invoice_no').value;
            var ProductId = document.getElementById('product_id').value;
            var ProductCode = document.getElementById('product_code').value;
            var ProductID = document.getElementById('product_name').value.split("_")[0];
            var ProductName = document.getElementById('product_name').value.split("_").pop();
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

            var totalPrice = parseInt(TotalRate) + parseInt(Quantity);
            var TotalTaxAmount = parseInt(TotalTax) + parseInt(TaxValue);
            var TotalExTaxAmount = parseInt(TotalExTax) + parseInt(ValueExTax);
            var TotalincTaxAmount = parseInt(TotalAmount) + parseInt(Amount);

            document.getElementById('TotalRate').value = totalPrice;
            document.getElementById('TotalTax').value = TotalTaxAmount;
            document.getElementById('TotalExTax').value = TotalExTaxAmount;
            document.getElementById('TotalAmount').value = TotalincTaxAmount;

            if((ProductId) == "" || (ProductId) == 0){
                document.getElementById("product_code").focus();
                Swal.fire('Select Product First!');
                    e.preventdefault();
            }

            if((Quantity) == "" || (Quantity) == 0 || (Quantity) == 'NaN' ){
                // alert('Quantity Cant be Empty or 0!');
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
            var tableHtml = '<tr class="st-data-row">';
            tableHtml += `<td style="display:none;"><input id="test" value="${ProductId}" type="text" class="form-control" disabled></td>`;
            tableHtml += `<td><input id="test" value="${ProductCode}" type="text" class="form-control" disabled></td>`;
            tableHtml += `<td><input id="test" value="${ProductName}" type="text" class="form-control" disabled></td>`;
            tableHtml += `<td style="display:none;"><input id="test" value="${UOMID}" type="text" class="form-control" disabled></td>`;
            tableHtml += `<td><input id="test" value="${UOM}" type="text" class="form-control" disabled></td>`;
            tableHtml += `<td class="st-num"><input id="test" value="${Quantity}" type="text" class="form-control" disabled></td>`;
            tableHtml += `<td class="st-num"><input id="test" value="${Price}" type="text" class="form-control" disabled></td>`;
            tableHtml += `<td class="st-num"><input id="test" value="${STValue}" type="text" class="form-control" disabled></td>`;
            tableHtml += `<td class="st-num"><input id="test" value="${TaxValue}" type="text" class="form-control" disabled></td>`;
            tableHtml += `<td class="st-num"><input id="test" value="${ExtraTax}" type="text" class="form-control" disabled></td>`;
            tableHtml += `<td style="display:none;"><input id="test" value="${ExtraTaxValue}" type="text" class="form-control" disabled></td>`;
            tableHtml += `<td class="st-num"><input id="test" value="${ValueExTax}" type="text" class="form-control" disabled></td>`;
            tableHtml += `<td class="st-num"><input id="test" value="${Amount}" type="text" class="form-control" disabled></td>`;
            tableHtml += `<td style="display:none;"><input id="test" value="${TotalTax}" type="text" class="form-control" disabled></td>`;
            tableHtml += `<td><button type="button" onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="btn btn-danger btn-sm">Delete</button></td>`;
                tableHtml += '</tr>';
            $('#myTable tbody').append(tableHtml);
            // document.getElementById("product_code").focus();
            $('#product_name').select2('open');
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

        // on javascript onclick on product dropdown 
        function ProductKeyUp(ProductName, ProductID) {
            // alert(ProductID)
            // $("#quantity").focus();
            $.ajax({
                type: "GET",
                url: "{{ asset('taxproductkeyup-ajax') }}?product_ID=" + ProductID,
                success: function(result) {
                    if (result.length > 0) {
                        $('#product_code').val(result[0].product_code);
                        $('#product_id').val(result[0].id);
                        $("#packing_type").val(result[0].catagory_name);
                        $("#price_per_unit").val(result[0].price_per_unit);
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
                        // document.getElementById('value').value = total;
                        document.getElementById('amount').value = grand;
                      
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
            });
        }

        // function myDeleteFunction(row) {
        //     alertify.confirm("Are you sure you want to delete this row?", function(e) {
        //         if (e) {
        //             var TotalRate = document.getElementById('TotalRate').value;
        //             var rate = $(row).find("td:eq('6')").find("input").val();
        //             var grandRate = parseInt(TotalRate) - parseInt(rate);
        //             document.getElementById('TotalRate').value = grandRate;

        //             var TotalTax = document.getElementById('TotalTax').value;
        //             var tax = $(row).find("td:eq('8')").find("input").val();
        //             var grandTax = parseInt(TotalTax) - parseInt(tax);
        //             document.getElementById('TotalTax').value = grandTax;

        //             var TotalExTax = document.getElementById('TotalExTax').value;
        //             var Extax = $(row).find("td:eq('11')").find("input").val();
        //             var grandExTax = parseInt(TotalExTax) - parseInt(Extax);
        //             document.getElementById('TotalExTax').value = grandExTax;

        //             var TotalAmount = document.getElementById('TotalAmount').value;
        //             var Inctax = $(row).find("td:eq('12')").find("input").val();

        //             var grandIncTax = parseInt(TotalAmount) - parseInt(Inctax);
        //             document.getElementById('TotalAmount').value = grandIncTax;

        //             $(row).remove();
        //         } else {
        //             alertify.alert("Row Deleting Cancelled!");
        //         }
        //     });
        // }

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
                    var rate = $(row).find("td:eq('5')").find("input").val(); //qty, not rate
                    var grandRate = parseInt(TotalRate) - parseInt(rate);
                    document.getElementById('TotalRate').value = grandRate;

                    var TotalTax = document.getElementById('TotalTax').value;
                    var tax = $(row).find("td:eq('8')").find("input").val();
                    var grandTax = parseInt(TotalTax) - parseInt(tax);
                    document.getElementById('TotalTax').value = grandTax;

                    var TotalExTax = document.getElementById('TotalExTax').value;
                    var Extax = $(row).find("td:eq('11')").find("input").val();
                    var grandExTax = parseInt(TotalExTax) - parseInt(Extax);
                    document.getElementById('TotalExTax').value = grandExTax;

                    var TotalAmount = document.getElementById('TotalAmount').value;
                    var Inctax = $(row).find("td:eq('12')").find("input").val();
                    // alert(TotalAmount)
                    // alert(Inctax)
                    var grandIncTax = parseInt(TotalAmount) - parseInt(Inctax);
                    document.getElementById('TotalAmount').value = grandIncTax;



                    $(row).remove();
                    //alertify.alert("File is Removed!");
                }
                    
            });
        }

        $("#btnSave").click(function() {
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
                    purchase.party_id = $("#party_id").val();
                    purchase.voucher_no = $("#voucher_no").val();
                    purchase.p_order = $("#p_order").val();
                    purchase.invoice_no = $("#voucher_no").val();
                    purchase.invoice_no1 = $("#invoice_no1").val();
                    purchase.date = $("#date").val();
                    purchase.purchase_type = $("#purchase_type").val();
                    purchase.remarks = $("#remarks").val();
                    purchase.lessCommercial = $("#lessCommercial").is(":checked");
                    purchase.autocash = $("#autocash").is(":checked");
                    purchase.biller = $("#biller").val();
                    purchase.company_id = $('#company_id').val();

                    var products = [];
                    $.each($("#myTable tbody tr.st-data-row"), function(index, row) {
                        var columns = $(row).find("td");
                        var product = new Object();
                        product.party_id = $("#party_id").val();
                        product.product_id = $(columns[0]).find("input").val();
                        product.uom_id = $(columns[3]).find("input").val().split("_")[0];
                        product.quantity = $(columns[5]).find("input").val();
                        product.rate = $(columns[6]).find("input").val();
                        product.stvalue = $(columns[7]).find("input").val();
                        product.taxvalue = $(columns[8]).find("input").val();
                        product.extratax = $(columns[9]).find("input").val();
                        product.extraTaxValue = $(columns[10]).find("input").val();
                        product.excvalue = $(columns[11]).find("input").val();
                        product.incvalue = $(columns[12]).find("input").val();
                        product.TotalTax = $(columns[13]).find("input").val();
                        product.company_id = $('#company_id').val();
                        products.push(product);
                    });

                    var $_token = jQuery('#token').val();
                    if(products != ""){
                    jQuery.ajax({
                        method: "PATCH",
                        cache: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            purchase: JSON.stringify(purchase),
                            product_data: products
                        },
                        url: "{{ asset('purchase-tax') }}/<?php echo $edit->id; ?>",
                        success: function(result) {
                            //if(result == "inserted")
                            if (parseInt(result) > 0) {
                                // window.open("/salestax/print/"+result);
                                localStorage.setItem("flash_message", result.message);
                                window.location.href = "{{ asset('purchase-tax') }}";
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
