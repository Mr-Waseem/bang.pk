@extends("app")
<head>
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
@section('contents')
<style>
    .os-wrap .panel-body { padding: 12px 15px; }
    .os-wrap .meta-row {
        display: flex !important;
        flex-wrap: wrap;
        align-items: flex-end;
        gap: 40px;
        margin: 0 0 14px 15px !important;
        padding: 0 !important;
        float: none;
    }
    .os-wrap .meta-row .meta-field {
        float: none !important;
        width: 200px;
        max-width: 100%;
        margin: 0;
        padding: 0 !important;
    }
    .os-wrap .meta-row .form-group { margin-bottom: 0; }
    .os-wrap .meta-row label { display: block; margin-bottom: 4px; font-weight: 600; }
    .os-wrap .os-table th:first-child,
    .os-wrap .os-table td:first-child { padding-left: 6px; }
    .os-wrap .os-table { width: 100%; margin-bottom: 0; table-layout: fixed; border-collapse: collapse; }
    .os-wrap .os-table th {
        background: #3498db; color: #fff; font-size: 12px; font-weight: 600;
        padding: 8px 6px; border: 1px solid #2980b9; text-align: left;
    }
    .os-wrap .os-table td { padding: 5px 4px; vertical-align: middle; border: 1px solid #e0e0e0; }
    .os-wrap .os-table .form-control { height: 32px; padding: 4px 6px; width: 100%; margin: 0; }
    .os-wrap .os-table .select2-container { width: 100% !important; }
    .os-wrap .os-table .select2-selection--single { height: 32px !important; }
    .os-wrap .os-table .select2-selection__rendered { line-height: 30px !important; }
    .os-wrap .os-table .select2-selection__arrow { height: 30px !important; }
    .os-wrap .os-entry td { background: #f8fbff; }
    .os-wrap .totals-bar {
        display: flex; justify-content: flex-end; align-items: center; gap: 20px;
        padding: 8px 12px; background: #3498db; color: #fff; margin-top: 0;
    }
    .os-wrap .totals-bar label { margin: 0 6px 0 0; font-weight: 600; }
    .os-wrap .totals-bar input {
        width: 130px; height: 30px; border: none; border-radius: 3px;
        padding: 4px 8px; color: #333;
    }
    .os-wrap .btn-add-row { padding: 4px 10px; }
</style>

<div class="os-wrap">
        @if (Session::has('flash_message'))
        <div class="alert alert-success alert-dismissible fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <strong>Success!</strong> {{ Session::get('flash_message') }}
        </div>
        @endif

    <h1 class="page-title">Edit Opening Stock</h1>
            <div class="panel panel-default">
                <div class="panel-heading clearfix" id="panelbg">
                    <h3 class="panel-title">Edit Opening Stock</h3>
                </div>
                <div class="panel-body">
                    <input id="token" type="hidden" value="{{ $encrypted_token }}">
                    @include('errors.validation')
            {!! Form::model($edit, ['method' => 'PATCH', 'action' => ['App\Http\Controllers\OpeningStockController@update', $edit->id], 'class' => 'form-horizontal', 'id' => 'StockForm']) !!}
                    {!! Form::hidden('company_id', session()->get('company_id'), ['id' => 'company_id']) !!}

            <div class="meta-row">
                <div class="meta-field">
                        <div class="form-group">
                        <label>Date</label>
                                    {!! Form::date('date', $edit->date, ['id' => 'date', 'class' => 'form-control']) !!}
                    </div>
                   </div>
                <div class="meta-field">
                        <div class="form-group">
                        <label>Bill No</label>
                        {!! Form::text('bill_no', $edit->bill_no, ['id' => 'bill_no', 'class' => 'form-control', 'autofocus' => 'autofocus']) !!}
                    </div>
                        </div>
                    </div>

            <div style="display:none;">
                <select class="form-control" id="purchase_type" name="purchase_type"><option value="ADJUST" selected>ADJUST</option></select>
                {!! Form::text('account_id', 0, ['id' => 'account_id', 'class' => 'form-control']) !!}
                {!! Form::select('warehouse_id', $warehouse, $edit->warehouse_id, ['id' => 'warehouse_id', 'class' => 'form-control']) !!}
                {!! Form::select('tax_id', $taxes, null, ['id' => 'tax_id', 'class' => 'form-control']) !!}
                                                                {!! Form::select('uom_id', $uoms, null, ['id' => 'uom_id', 'class' => 'form-control']) !!}
                {!! Form::hidden('product_id', null, ['id' => 'product_id']) !!}
                {!! Form::hidden('total', null, ['id' => 'total']) !!}
                                                        </div>

            <?php $totalQty = 0; $totalAmount = 0; ?>
            <table class="os-table" id="osTable">
                <thead>
                    <tr>
                        <th style="width:12%;">Code</th>
                        <th style="width:30%;">Product Name</th>
                        <th style="width:8%;">Unit</th>
                        <th style="width:12%;">Quantity</th>
                        <th style="width:12%;">Rate</th>
                        <th style="width:14%;">Total</th>
                        <th style="width:8%;"></th>
                    </tr>
                </thead>
                <tbody id="osEntry">
                    <tr class="os-entry">
                        <td>{!! Form::text('product_code', null, ['id' => 'product_code', 'class' => 'form-control', 'readonly' => 'readonly']) !!}</td>
                        <td>{!! Form::select('product_name', $products, null, ['id' => 'product_name', 'onchange' => 'var v=$(this).val(); if(v){ productMouseUp(v.split("_")[0]); }', 'class' => 'form-control']) !!}</td>
                        <td>{!! Form::text('uoms', null, ['id' => 'uoms', 'class' => 'form-control', 'readonly' => 'readonly']) !!}</td>
                        <td>{!! Form::text('quantity', 1, ['id' => 'quantity', 'onkeyup' => 'PriceKeyUp()', 'class' => 'form-control']) !!}</td>
                        <td>{!! Form::text('price', null, ['id' => 'price', 'onkeyup' => 'PriceKeyUp()', 'class' => 'form-control']) !!}</td>
                        <td>{!! Form::text('totals', null, ['id' => 'totals', 'class' => 'form-control', 'readonly' => 'readonly']) !!}</td>
                        <td class="text-center">
                            <button class="btn btn-success btn-add-row" type="button" onclick="AddGridData()">+</button>
                        </td>
                                                    </tr>
                </tbody>
                <tbody id="myData">
                                                    @foreach ($edit->purchase_details as $purchaseDetail)
                    <?php
                        $totalQty += (float) $purchaseDetail->quantity;
                        $totalAmount += (float) $purchaseDetail->total_cost;
                    ?>
                    <tr>
                        <td style="display:none;"><input name="products_id[]" value="{{ $purchaseDetail->product_id }}" type="hidden"></td>
                        <td style="display:none;"><input name="uoms_id[]" value="{{ $purchaseDetail->uom_id }}" type="hidden"></td>
                        <td style="display:none;"><input name="warehouse_id" value="{{ $purchaseDetail->warehouse_id }}" type="hidden"></td>
                        <td style="display:none;"><input name="total[]" value="{{ $purchaseDetail->total_cost }}" type="hidden" class="row-total-hidden"></td>
                        <td><input name="product_code[]" value="{{ optional($purchaseDetail->products)->product_code }}" type="text" class="form-control" readonly></td>
                        <td><input name="product_name[]" value="{{ optional($purchaseDetail->products)->product_name }}" type="text" class="form-control" readonly></td>
                        <td><input name="uoms" value="{{ optional($purchaseDetail->unit)->uom }}" type="text" class="form-control" readonly></td>
                        <td><input name="quantity[]" value="{{ $purchaseDetail->quantity }}" type="text" class="form-control row-qty" onkeyup="recalcRow($(this).closest('tr'));"></td>
                        <td><input name="price[]" value="{{ $purchaseDetail->unit_cost }}" type="text" class="form-control row-price" onkeyup="recalcRow($(this).closest('tr'));"></td>
                        <td><input value="{{ $purchaseDetail->total_cost }}" type="text" class="form-control row-total" readonly></td>
                        <td class="text-center">
                            <button class="btn btn-danger btn-sm" type="button" onclick="myDeleteFunction($(this).closest('tr'));">
                                <i class="icon-trash"></i>
                            </button>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                </tbody>
                                                </table>

            <div class="totals-bar">
                <div>
                    <label>Total Qty</label>
                    <input type="text" id="TotalQty" name="TotalQty" value="{{ $totalQty }}" disabled>
                                            </div>
                <div>
                    <label>Total Amount</label>
                    <input type="text" id="TotalAmount" name="TotalAmount" value="{{ number_format($totalAmount, 2, '.', '') }}" disabled>
                                            </div>
                                        </div>

            <div class="text-center" style="margin-top: 14px;">
                <button type="submit" class="btn btn-primary" id="btnSaves" name="btnSaves">Save</button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
@stop

@section('scripts')
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<script type="text/javascript">
@include('partials.opening-stock-remote-select2')

function PriceKeyUp() {
    var total = parseFloat(document.getElementById('quantity').value || 0) * parseFloat(document.getElementById('price').value || 0);
    document.getElementById('total').value = total.toFixed(2);
    document.getElementById('totals').value = total.toFixed(2);
}

function recalcTotals() {
    var totalQty = 0, totalAmount = 0;
    $('#myData tr').each(function() {
        totalQty += parseFloat($(this).find('.row-qty').val() || 0);
        totalAmount += parseFloat($(this).find('.row-total-hidden').val() || $(this).find('.row-total').val() || 0);
    });
    document.getElementById('TotalQty').value = totalQty;
    document.getElementById('TotalAmount').value = totalAmount.toFixed(2);
}

function clearEntry() {
    $('#product_id').val('');
    $('#product_code').val('');
    $('#uoms').val('');
    $('#quantity').val('1');
    $('#price').val('');
    $('#total').val('');
    $('#totals').val('');
    $('#product_name').val(null).trigger('change.select2');
}

function focusOpeningStockProduct() {
    setTimeout(function () {
        $('#product_name').select2('open');
    }, 50);
}

function parseOpeningStockProductValue(value) {
    var parts = (value || '').split('_');
    if (parts.length >= 3) {
        return { id: parts[0], code: parts[1], name: parts.slice(2).join('_') };
    }
    return { id: parts[0] || '', code: '', name: parts.slice(1).join('_') || parts.pop() || '' };
}

    function AddGridData() {
        var selectedProduct = parseOpeningStockProductValue(document.getElementById('product_name').value);
        var ProductId = document.getElementById('product_id').value || selectedProduct.id;
        var ProductCode = document.getElementById('product_code').value || selectedProduct.code;
    var ProductName = selectedProduct.name;
    var UOMID = (document.getElementById('uom_id').value || '').split("_")[0];
    var UOM = document.getElementById('uoms').value || (document.getElementById('uom_id').value || '').split("_").pop();
        var Quantity = document.getElementById('quantity').value;
        var Price = document.getElementById('price').value;
        var warehouse_id = document.getElementById('warehouse_id').value;
        var Total = document.getElementById('total').value;

    if (!ProductId || ProductId == 0) { Swal.fire('Select Product First!'); return false; }
    if (!Quantity || Quantity == 0) { Swal.fire('Quantity Cant be Empty or 0!'); return false; }
    if (!Price || Price == 0) { Swal.fire('Price Cant be Empty or 0!'); return false; }

    var html = '<tr>';
    html += `<td style="display:none;"><input name="products_id[]" value="${ProductId}" type="hidden"></td>`;
    html += `<td style="display:none;"><input name="uoms_id[]" value="${UOMID}" type="hidden"></td>`;
    html += `<td style="display:none;"><input name="warehouse_id" value="${warehouse_id}" type="hidden"></td>`;
    html += `<td style="display:none;"><input name="total[]" value="${Total}" type="hidden" class="row-total-hidden"></td>`;
    html += `<td><input name="product_code[]" value="${ProductCode}" type="text" class="form-control" readonly></td>`;
    html += `<td><input name="product_name[]" value="${ProductName}" type="text" class="form-control" readonly></td>`;
    html += `<td><input name="uoms" value="${UOM}" type="text" class="form-control" readonly></td>`;
    html += `<td><input name="quantity[]" value="${Quantity}" type="text" class="form-control row-qty" onkeyup="recalcRow($(this).closest('tr'));"></td>`;
    html += `<td><input name="price[]" value="${Price}" type="text" class="form-control row-price" onkeyup="recalcRow($(this).closest('tr'));"></td>`;
    html += `<td><input value="${Total}" type="text" class="form-control row-total" readonly></td>`;
    html += '<td class="text-center"><button class="btn btn-danger btn-sm" type="button" onclick="myDeleteFunction($(this).closest(\'tr\'));"><i class="icon-trash"></i></button></td>';
    html += '</tr>';

    $('#myData').append(html);
    recalcTotals();
    clearEntry();
    focusOpeningStockProduct();
    return true;
}

function recalcRow($row) {
    var total = (parseFloat($row.find('.row-qty').val() || 0) * parseFloat($row.find('.row-price').val() || 0)).toFixed(2);
    $row.find('.row-total').val(total);
    $row.find('.row-total-hidden').val(total);
    recalcTotals();
    }

    function myDeleteFunction(row) {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: "Are You Sure?",
            text: "Delete this row?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                $(row).remove();
                recalcTotals();
            }
        });
    } else if (confirm("Delete this row?")) {
        $(row).remove();
        recalcTotals();
    }
}

function productMouseUp(productID) {
    if (!productID) return;
        $.ajax({
            type: "GET",
            url: "{{ asset('productmouseup-ajax') }}?product_ID=" + productID,
            success: function(result) {
                if (result.length > 0) {
                    $('#product_code').val(result[0].product_code);
                $('#uoms').val(result[0].uom);
                    $('#product_id').val(result[0].id);
                    $('#price').val(result[0].product_cost);
                if (result[0].uom_id) {
                    $('#uom_id').val(result[0].uom_id + '_' + (result[0].uom || ''));
                }
                PriceKeyUp();
                $("#quantity").focus();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    }

$('#osEntry').on('keydown', 'input', function (e) {
    if (e.key === 'Enter' || e.keyCode === 13) {
        e.preventDefault();
        AddGridData();
    }
});

$('.btn-add-row').on('keydown', function (e) {
    if (e.key === 'Enter' || e.keyCode === 13) {
        e.preventDefault();
        AddGridData();
        return;
    }
    if (e.key === 'Tab' && !e.shiftKey) {
        e.preventDefault();
        AddGridData();
    }
});
</script>
@stop
