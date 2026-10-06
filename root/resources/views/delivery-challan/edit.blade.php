@extends("app")
@section("contents")

<head>
    <link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <style>
    td {
        padding: 5px;
    }

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
    </style>
</head>

<body>
    <!-- <body onload="AddRowFunction()"> -->
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
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">Edit Delivery Challan</h3>
                </div>
                <div class="panel-body">
                    <input id="token" type="hidden" value="{{$encrypted_token}}">
                    @include('errors.validation')
                    <!-- {!! Form::model($edit, ['method' => 'PATCH', 'action' => ['App\Http\Controllers\DeliveryChallanController@update', $edit->id], 'class' => 'form-horizontal' ]) !!}	 -->
                    {!! Form::model($edit, ['method' => 'PATCH', 'action' =>
                    ['App\Http\Controllers\DeliveryChallanController@update', $edit->id], 'class' => 'form-horizontal',
                    'id' => 'form-submission']) !!}
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-row align-items-center">
                                <div class="col-md-1 col-12 mb-2 mb-md-0">
                                    <label class="form-label fw-bold">Date</label>
                                </div>
                                <div class="col-md-2 col-6 mb-2 mb-md-0">
                                    <input id="date" type="date" name="date" value="<?php echo date('Y-m-d'); ?>"
                                        class="form-control form-control-sm" autofocus>
                                </div>

                                <div class="col-md-1 col-12 mb-2 mb-md-0">
                                    <label class="form-label fw-bold">DC NO</label>
                                </div>
                                <div class="col-md-2 col-6 mb-2 mb-md-0">
                                    {!! Form::text('vr_no', null, ['id' => 'vr_no', 'class'=>'form-control']) !!}
                                </div>
                                <div class="col-md-1 col-12 mb-2 mb-md-0">
                                    <label class="form-label fw-bold">PO NO</label>
                                </div>
                                  <div class="col-md-2 col-6 mb-2 mb-md-0">
                                     {!! Form::text('po_no', null, ['id' => 'po_no', 'class'=>'form-control']) !!}
                                </div>
                                 <div class="col-md-1 col-12 mb-2 mb-md-0">
                                    <label class="form-label fw-bold">Vehicle#</label>
                                </div>
                                <div class="col-md-2 col-6 mb-2 mb-md-0">
                                     {!! Form::text('vehicle_no', null, ['id' => 'vehicle_no', 'class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-row align-items-center">
                                <div class="col-md-1 col-12 mb-2 mb-md-0">
                                    <label class="form-label fw-bold">Account</label>
                                </div>
                                <div class="col-md-2 col-6 mb-2 mb-md-0">
                                    {!! Form::select('party_id', $parties, null, ['id' => 'party_id', 'class' =>
                                    'form-control', 'required' => 'required']) !!}
                                </div>
                                 <div class="col-md-1 col-12 mb-2 mb-md-0">
                                    <label class="form-label fw-bold">Remarks</label>
                                </div>
                                <div class="col-md-2 col-6 mb-2 mb-md-0">
                                     {!! Form::text('remarks', null, ['id' => 'remarks', 'class'=>'form-control']) !!}
                                </div>
                                   <div class="col-md-1 col-12 mb-2 mb-md-0">
                                    <label class="form-label fw-bold">Driver Name</label>
                                </div>
                                <div class="col-md-2 col-6 mb-2 mb-md-0">
                                     {!! Form::text('driver_name', null, ['id' => 'driver_name', 'class'=>'form-control']) !!}
                                </div>
                                 <div class="col-md-1 col-12 mb-2 mb-md-0">
                                    <label class="form-label fw-bold">Driver Phone</label>
                                </div>
                                <div class="col-md-2 col-6 mb-2 mb-md-0">
                                     {!! Form::text('driver_phone', null, ['id' => 'driver_phone', 'class'=>'form-control']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <br />



                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="form-group">
                                        <table id="myTable" class="table table-condensed" style="margin-bottom: 0px;">
                                            <thead>
                                                <tr>
                                                    <th width="15%">H.S Code</th>
                                                    <th width="35%">Product Name</th>
                                                    <th width="5%">Unit</th>
                                                    <th width="10%">Qty</th>
                                                    <th width="10%">Pack</th>
                                                    <th width="10%">Pack.Qty</th>
                                                    <th width="10%">Rate</th>
                                                    <th width="10%">Amount</th>
                                                    <th width="15%">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    {!! Form::hidden('product_id', null, ['id' =>
                                                    'product_id','class'=>'form-control']) !!}
                                                    <td>{!! Form::text('product_code', null, ['id' => 'product_code',
                                                        'class'=>'form-control']) !!}</td>

                                                    <td>
                                                        {!! Form::select('product_name', $products, null, ['id' =>
                                                        'product_name', 'onchange' =>
                                                        'ProductKeyUp($(this).val().split("_").pop(),
                                                        $(this).val().split("_")[0]);','class'=>'form-control']) !!}
                                                    </td>


                                                    <td>
                                                        {!! Form::hidden('uom_id', null, ['id' => 'uom_id',
                                                        'class'=>'form-control']) !!}
                                                        {!! Form::text('uom', null, ['id' => 'uom',
                                                        'class'=>'form-control', 'readonly' => 'readonly']) !!}
                                                    </td>

                                                    <td>
                                                        {!! Form::text('quantity', 1, ['id' => 'quantity', 'onkeyup' =>
                                                        'QuantityKeyUp($(this).val())', 'class'=>'form-control']) !!}
                                                    </td>
                                                     <td>
                                                        {!! Form::text('pack', null, ['id' => 'pack', 'onkeyup' =>
                                                        'PackKeyUp($(this).val())',
														'onkeypress' => 'return onlyNumberKey(event)', 'class'=>'form-control']) !!}
                                                    </td>
                                                    <td>
                                                        {!! Form::text('pack_qty', null, ['id' => 'pack_qty',
														'onkeypress' => 'return onlyNumberKey(event)', 'class'=>'form-control']) !!}
                                                    </td>
                                                    <td>
                                                        {!! Form::text('price', null, ['id' => 'price','onkeyup' =>
                                                        'PriceKeyUp($(this).val())', 'class'=>'form-control']) !!}
                                                    </td>
                                                    <td>
                                                        {!! Form::text('total', null, ['id' => 'total', 'class'=>'form-control']) !!}
                                                    </td>
                                                    <td>
                                                        <button type="button" onclick="AddGridData()"
                                                            onkeyup="AddGridData()" class="btn btn-success btn-sm">
                                                            Add
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="form-group">
                                        <table id="myData" class="table table-condensed">
                                            <?php $totalQty = 0; $totalAmount = 0; ?>
                                            @foreach($edit->challan_details as $ChallanDetail)
                                            <tr>
                                                <td style="display:none;">
                                                    <input id="product_id1" name="product_id1[]"
                                                        value="{{$ChallanDetail->product_id}}" type="text"
                                                        class="form-control" readonly>
                                                </td>
                                                <td width="15%">
                                                    <input id="product_code1" name="product_code1[]"
                                                        value="{{$ChallanDetail->products->product_code}}" type="text"
                                                        class="form-control" readonly>
                                                </td>
                                                <td width="35%">
                                                    <input id="product_name1" name="product_name1[]"
                                                        value="{{$ChallanDetail->products->product_name}}" type="text"
                                                        class="form-control" readonly>
                                                </td>
                                                <td style="display:none;">
                                                    <input id="uom_id1" name="uom_id1[]"
                                                        value="{{$ChallanDetail->uom_id}}" type="text"
                                                        class="form-control" readonly>
                                                </td>
                                                <td width="5%">
                                                    <input id="uom1" name="uom1[]" value="{{$ChallanDetail->uom}}"
                                                        type="text" class="form-control" readonly>
                                                </td>

                                                <td width="10%">
                                                    <input id="quantity1" name="quantity1[]"
                                                        value="{{$ChallanDetail->quantity}}" type="text"
                                                        class="form-control" readonly>
                                                </td>
                                                <td width="10%">
                                                    <input id="pack1" name="pack1[]"
                                                        value="{{$ChallanDetail->pack}}" type="text"
                                                        class="form-control" readonly>
                                                </td>
                                                                                       <td width="10%">
                                                    <input id="pack_qty1" name="pack_qty1[]"
                                                        value="{{$ChallanDetail->pack_qty}}" type="text"
                                                        class="form-control" readonly>
                                                </td>
                                                <td width="10%">
                                                    <input id="price1" name="price1[]" value="{{$ChallanDetail->rate}}"
                                                        type="text" class="form-control" readonly>
                                                </td>
                                                <td width="10%">
                                                    <input id="amount1" name="amount1[]"
                                                        value="{{$ChallanDetail->amount}}" type="text"
                                                        class="form-control" readonly>
                                                </td>
                                                <td width="15%"><button class="btn btn-red" type="button"> <i
                                                            onclick="javascript:myDeleteFunction($(this).closest('tr'));"
                                                            class="icon-trash" title="Delete Row"></i></button></td>
                                                <?php $totalQty = $totalQty + $ChallanDetail->quantity; ?>
                                                <?php $totalAmount = $totalAmount + $ChallanDetail->amount; ?>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row">
                                <div class="col-lg-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading clearfix">
                                            <div class="container">
                                                <div class="col-xs-3" style=""> </div>
                                                <div class="col-xs-3" style=""> </div>
                                                <div class="col-xs-3" style=""> <b>Total Rate</b> <input type="text"
                                                        id="TotalRate" name="TotalRate" value="" disabled> </div>
                                                <div class="col-xs-3" style="background-color:lavenderblush;"> <b>Total
                                                        Amount</b> <input type="text" id="TotalAmount"
                                                        name="TotalAmount" value="" disabled> </div>
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
                                                            <input type="text" class="form-control stat-value"
                                                                value="{{number_format($totalQty)}}" id="TotalQty"
                                                                name="TotalQty" readonly>
                                                        </div>
                                                    </div>


                                                    <div class="col-6 col-md-3 stat-item">
                                                        <div class="d-flex flex-column align-items-center">
                                                            <span class="stat-label">
                                                                <i class="fas fa-money-bill-wave fa-xs"></i>Total Amount
                                                            </span>
                                                            <input type="text" class="form-control stat-value"
                                                                value="{{number_format($totalAmount)}}" id="TotalAmount"
                                                                name="TotalAmount" readonly>
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
                                    <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm">
                                        <i class="fa fa-save mr-2"></i> Save
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="col-lg-3">
				<button type="button" onclick="AddRowFunction()" class="btn btn-success"><i class="fa fa-plus"></i> </button>
				<button type="button" onclick="TotalRecords()" class="btn btn-success">Total Records</button>
			</div> -->
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</body>
@stop
@section("scripts")
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<script>
$("#product_name").select2();
$("#product_name").next(".select2").find(".select2-selection").focus(function() {
    $("#product_name").select2("open");
});
$("#party_id").select2();
$("#party_id").next(".select2").find(".select2-selection").focus(function() {
    $("#party_id").select2("open");
});
</script>
<script type="text/javascript">
var sum = 0;

function AddGridData() {
    var ProductId = document.getElementById('product_id').value;
    var ProductCode = document.getElementById('product_code').value;
    // var ProductID = document.getElementById('product_name').value.split("_")[0];
    // var ProductName = document.getElementById('product_name').value.split("_").pop();

    var ProductID = document.getElementById('product_name').value.split("_")[0];
    var ProductName = document.getElementById('product_name').value.split("_")[2];
    // var UOMID = document.getElementById('uom_id').value.split("_")[0];
    // var UOM = document.getElementById('uom_id').value.split("_").pop();
    var UOM = document.getElementById('uom').value;
    var UOMID = document.getElementById('uom_id').value;
    var Quantity = document.getElementById('quantity').value;
    var pack = document.getElementById('pack').value;
    var packqty = document.getElementById('pack_qty').value;
    var CostRate = document.getElementById('price').value;
    var Amount = document.getElementById('total').value;
    // document.getElementById('TotalQty').value = CostRate;
    // document.getElementById('TotalAmount').value = Amount;

    var tableHtml = '<tr>';
    //tableHtml += '<td style="display:none;">'+ ProductId +'</td>';
    //0
    tableHtml +=
        `<td style="display:none;"><input id="product_id1" name="product_id1[]" value="${ProductId}" type="text" class="form-control" readonly></td>`;
    //tableHtml += '<td>'+ ProductCode +'</td>';
    //1
    tableHtml +=
        `<td width="15%"><input id="product_code1" name="product_code1[]" value="${ProductCode}" type="text" class="form-control" readonly></td>`;
    //tableHtml += '<td>'+ ProductName +'</td>';
    //2
    tableHtml +=
        `<td width="35%"><input id="product_name1" name="product_name1[]" value="${ProductName}" type="text" class="form-control" readonly></td>`;
    //3
    tableHtml +=
        `<td style="display:none;"><input id="uom_id1" name="uom_id1[]" value="${UOMID}" type="text" class="form-control"  readonly></td>`;
    //4
    tableHtml +=
        `<td width="5%"><input id="uom1" name="uom1[]" value="${UOM}" type="text" class="form-control" readonly></td>`;

    //tableHtml += '<td>'+ Quantity +'</td>';
    //5
    tableHtml +=
        `<td width="10%"><input id="quantity1" name="quantity1[]" value="${Quantity}" type="text" class="form-control" readonly></td>`;
    //tableHtml += '<td>'+ CostRate +'</td>';
    //6
     tableHtml += `<td width="10%">
		              <input id="pack1" name="pack1[]" value="${pack}" type="text" class="form-control input-sm" readonly>
					  </td>`;

    tableHtml += `<td width="10%">
		              <input id="pack_qty1" name="pack_qty1[]" value="${packqty}" type="text" class="form-control input-sm" readonly>
					  </td>`;
    tableHtml +=
        `<td width="10%"><input id="price1" name="price1[]" value="${CostRate}" type="text" class="form-control" readonly></td>`;
    //tableHtml += '<td>'+ Amount +'</td>';
    //7
    tableHtml +=
        `<td width="10%"><input id="amount1" name="amount1[]" value="${Amount}" type="text" class="form-control" readonly></td>`;
    //8
    tableHtml +=
        '<td width="15%"><button class="btn btn-red" type="button"> <i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-trash" title="Delete Row"></i></button></td>';
    tableHtml += '</tr>';
    $('#myData').append(tableHtml);
	$('#product_name').select2('open');
	// document.getElementById("product_code").focus();
    TotalQuantity();
    TotalAmount1();
}

function TotalQuantity() {
    var tableData = document.getElementById('myData');
    var sum = 0;
    for (var i = 0; i < tableData.rows.length; i++) {
        if (tableData.rows[i].cells[5].getElementsByTagName('input')[0].value == '') {
            sum += 0;
        } else {
            sum += parseFloat(tableData.rows[i].cells[5].getElementsByTagName('input')[0].value);
            // alert(sum);
        }
    }
    document.getElementById('TotalQty').value = sum.toLocaleString('en-US');
}

function TotalAmount1() {
    var tableData = document.getElementById('myData');
    var sum = 0;
    for (var i = 0; i < tableData.rows.length; i++) {
        if (tableData.rows[i].cells[7].getElementsByTagName('input')[0].value == '') {
            sum += 0;
        } else {
            sum += parseFloat(tableData.rows[i].cells[7].getElementsByTagName('input')[0].value);
            // alert(sum);
        }
    }
    document.getElementById('TotalAmount').value = sum.toLocaleString('en-US');
}

function LedgerValues() {
    $value = $("#purchase_type").val();
    if ($value == "Cash Purchase") {
        $('#ledgerRow').hide();
    }
    if ($value == "Credit Purchase") {
        $('#ledgerRow').show();
    }
}

function QuantityKeyUp(quantity) {
    var price = document.getElementById('price').value;
    //var tax = document.getElementById('tax_id').value.split("_").pop();
    //var taxvalue = tax/100*price*quantity;
    //total = (quantity * price) + taxvalue;
    total = (quantity * price);
    document.getElementById('total').value = total;
}

function PackKeyUp(){
    var pack = document.getElementById('pack').value;
    var quantity = document.getElementById('quantity').value;

    var packqty = quantity / pack;
    document.getElementById('pack_qty').value = packqty;
}

function PriceKeyUp(price) {
    var quantity = document.getElementById('quantity').value;
    //var tax = document.getElementById('tax_id').value.split("_").pop();
    //var taxvalue = tax/100*price*quantity;
    //total = (quantity * price) + taxvalue;
    total = (quantity * price);
    document.getElementById('total').value = total;
}

function CalculateTax(tax) {

    var quantity = document.getElementById('quantity').value;
    var price = document.getElementById('price').value;
    var taxvalue = tax / 100 * price * quantity;
    total = (quantity * price) + taxvalue;
    document.getElementById('total').value = total;
}


function TotalRecords() {
    var rowCount = document.getElementById('myTable').rows.length;
    alert("Total Number of Records Are: " + rowCount);
}

function myDeleteFunction(row) {
    if (confirm("Are you sure you want to delete this row?")) {
        $(row).remove();
        TotalQuantity();
        TotalAmount1();
    }
}

// Code Mouse Up 
function codeMouseUp(code, rowIndex) {
    $.ajax({
        type: "GET",
        url: "/codemouseup-ajax?entered_code=" + code,
        success: function(result) {
            if (result.length > 0) {
                $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('0')").find('input').val(result[0].id);
                $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('2')").find('input').val(result[0]
                    .product_name);
                $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('5')").find('input').val(result[0]
                    .product_cost);
                // $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('2')").find('input').val(result[0].product_name);

                var tax = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('3')").find('select').val()
                    .split("_").pop();
                var quantity = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('input').val();
                //quantity = (quantity == "" || quantity == null) ? 0.00 : quantity;
                var cost = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('5')").find('input').val();
                var totalcost = (quantity * cost) + ((tax / 100) * quantity * cost);
                $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val(parseInt(
                    totalcost));
                // if(parseInt(cost) == 0 && parseFloat(totalcost) > 0)
                // {
                // 	totalcost = parseInt(totalcost).toFixed(2);
                // }
                // $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val(parseInt(totalcost));
                // $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('input').val(totalPrice);		
                //}
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

function ProductKeyUp(ProductName, ProductID) {
    // alert("dfsd");
    $.ajax({
        type: "GET",
        url: "{{ asset('purchasetaxproductkeyup-ajax') }}?product_ID=" + ProductID,
        success: function(result) {
            if (result.length > 0) {

                $('#product_code').val(result[0].product_code);
                $('#product_id').val(result[0].id);
                $("#uom_id").val(result[0].uom_id);
                $("#uom").val(result[0].uom);

                $("#quantity").select();
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status);
            alert(thrownError);
        }
    });
}

$("#btnSave").click(function() {
    var grn = new Object();
    grn.party_id = $("#party_id").val();
    grn.date = $("#date").val();
    grn.dcn_no = $("#dcn_no").val();
    grn.type = $("#type").val();
    grn.outward_gpn = $("#outward_gpn").val();
    grn.status = $("#status").val();
    var GRNDetails = [];
    $.each($("#myData tr"), function(index, row) {
        var columns = $(row).find("td");
        var details = new Object();
        //details.challan_id = $(columns[1]).text();
        details.product_id = $(columns[0]).find("input").val();
        details.uom_id = $(columns[3]).find("input").val();
        // product.tax_id = $(columns[3]).find("select").val().split("_")[0];
        // product.tax_id = $(columns[9]).text();
        details.quantity = $(columns[5]).find("input").val();
        details.rate = $(columns[6]).find("input").val();
        details.amount = $(columns[7]).find("input").val();

        //Code & product only for validation, not insertion
        //product.code = $(columns[1]).find("input").val();
        //product.product_name = $(columns[2]).find("input").val();
        // if($(columns[1]).find("input").val()=="" || $(columns[2]).find("input").val()==""){
        // 	alert('Fill the Code & Product Correctly First!');
        //          e.preventdefault();
        // 	}
        //validation
        // if($(columns[3]).find("input").val() =="" || $(columns[4]).find("input").val() =="" | $(columns[5]).find("input").val() =="" || $(columns[6]).find("input").val() ==""){
        // 	alert('Fill the Fields Correctly First!');
        //          e.preventdefault();
        // 	}
        GRNDetails.push(details);
    });
    var $_token = jQuery('#token').val();
    jQuery.ajax({
        method: "PATCH",
        cache: false,
        headers: {
            'X-XSRF-TOKEN': $_token
        },
        data: {
            grn: JSON.stringify(grn),
            details_data: GRNDetails
        },
        url: "/delivery-challan/<?php echo $edit->id ?>",

        success: function(result) {
            if (parseInt(result) > 0) {
                alert("Delivery Challan successfully Updated.");
                //window.open("/grn/print/"+result);
                window.location.href = "/delivery-challan";
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            $("#spanWait").hide();
            alert(xhr.status);
            alert(thrownError);
        }
    });
});

// $('#date').datepicker({
// 			startView: 0,
// 			keyboardNavigation: false,
// 			forceParse: false,
// 			format: "dd/mm/yyyy"
// 		});
</script>
@stop