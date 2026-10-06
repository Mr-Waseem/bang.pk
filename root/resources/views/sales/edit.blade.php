@extends("app")

<head>
<link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
</head>
@section('contents')

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
                    <div class="panel-heading clearfix" id="panelbg">
                        <h2 class="panel-title"><b>Edit Sale</b></h2>
                    </div>
                    <div class="panel-body">
                        <input id="token" type="hidden" value="{{ $encrypted_token }}">
                        @include('errors.validation')
                        {!! Form::model($edit, ['method' => 'PATCH', 'action' => ['App\Http\Controllers\SalesController@update', $edit->id], 'class' => 'form-horizontal']) !!}
                        {!! Form::hidden('company_id', session()->get('company_id'), ['id' => 'company_id']) !!}
                        <div class="row">
                            <div class="form-group" style="margin-left: 1%; margin-right: 1%;">
                                <label class="col-sm-1 control-label">Date</label>
                                <div class="col-sm-2">
                                    <div id="year-view" class="input-group date">
                                        <!-- <input id="date" type="date" name="date"  class="form-control" required autofocus> -->
                                        {!! Form::date('date', null, ['id' => 'date', 'placeholder' => 'Description', 'class' => 'form-control', 'autofocus' => 'autofocus']) !!}
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                <label class="col-sm-1 control-label">Bill No</label>
                            <div class="col-sm-2">
                                <div id="year-view" class="input-group date">
                                    {!! Form::text('invoice_no', null, ['id' => 'invoice_no', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                </div>
                            </div>
                                <label class="col-sm-3 control-label" style="display:none;">Bill&nbsp;Type</label>
                                <div class="col-sm-2" style="display:none;">
                                    <!-- {!! Form::text('particulars', null, ['id' => 'particulars', 'placeholder' => 'Description', 'class' => 'form-control']) !!} -->
                                    {!! Form::select('localExport', ['Local' => 'Local', 'Export' => 'Export'], null, ['id' => 'localExport', 'onkeydown' => 'focusNext(event);', 'class' => 'form-control']) !!}
                                </div>

                            </div>
                        </div>

                        <div class="row" id="ledgerRow" style="display:none;">
                            <div class="form-group" style="margin-left: 1%; margin-right: 1%;">
                                <label class="col-sm-1 control-label">Due&nbsp;Date</label>
                                <div class="col-sm-2">
                                    <div id="year-view" class="input-group date">
                                        <!-- <input id="due_date" type="date" value="<?php echo date('Y-m-d'); ?>" name="due_date" class="form-control">  -->
                                        {!! Form::date('due_date', $edit->due_date, ['id' => 'due_date', 'class' => 'form-control']) !!}
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>

                                <label class="col-sm-3 control-label">Description</label>
                                <div class="col-sm-2">
                                    {!! Form::text('particulars', null, ['id' => 'particulars', 'placeholder' => 'Description', 'class' => 'form-control']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="form-group" style="margin-left: 0px;">
                           
                            <label class="col-sm-3 control-label" style="display:none;">Select&nbsp;Shop</label>
                            <div class="col-sm-2" style="margin-left: -6px; display:none;">
                                {!! Form::select('warehouse_id', $warehouse, null, ['id' => 'warehouse_id', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group" style="display:none;">
                            <label class="col-sm-3 control-label">Biller</label>
                            <div class="col-sm-5">
                                <select name="biller" id="biller" class="form-control" disabled>
                                    <option value="{{ Auth::user()->id }}">{{ Auth::user()->name }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="row" style="display: none;">
                            <div class="form-group" style="margin-left: 1%; margin-right: 1%;">
                                <label class="col-sm-1 control-label">Sale Type</label>
                                <div class="col-sm-2">

                                    {!! Form::select('sale_list', ['Sale Bill' => 'Sale Bill', 'Sample' => 'Sample'], null, ['id' => 'sale_list', 'onchange' => 'SampleDescription($(this).val());', 'class' => 'form-control']) !!}

                                </div>

                            </div>
                        </div>

                        <div class="form-group" id="sample_div" style="margin-left: 0%; display:none;">
                            <label class="col-sm-1 control-label">Description</label>
                            <div class="col-sm-2">
                                {!! Form::text('sample_description', null, ['id' => 'sample_description', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        @if ($edit->sample_description == 'Sample')
                        @endif
                        <div class="row">
                            <div class="form-group" style="margin-left: 1%; margin-right: 1%;">
                                {!! Form::hidden('party_id', $edit->party_id, ['id' => 'party_id', 'class' => 'form-control']) !!}
                                <label class="col-sm-1 control-label">Account</label>
                                <div class="col-sm-2">
                                    {!! Form::select('party_name', $customers, $edit->party_id, ['id' => 'party_name', 'onchange' => 'javascript:PartyKeyUp($(this).val());', 'class' => 'form-control', 'required' => 'required']) !!}
                                </div>
                                <!-- <label class="col-sm-1 control-label">Address</label>  -->
                                <div class="col-sm-3">
                                    {!! Form::text('address', $edit->parties->address, ['id' => 'address', 'class' => 'form-control', 'placeholder' => 'Address', 'disabled' => 'disabled']) !!}
                                </div>
                                <!-- <label class="col-sm-1 control-label">NTN</label>  -->
                                <div class="col-sm-2">
                                    {!! Form::text('ntn', $edit->parties->ntn, ['id' => 'ntn', 'class' => 'form-control', 'placeholder' => 'NTN', 'disabled' => 'disabled']) !!}
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <table>
                                        <div class="container-fluid">
                                            <div class="row" id="myTable">
                                                <tr>
                                                    {!! Form::hidden('product_id', null, ['id' => 'product_id', 'class' => 'form-control']) !!}
                                                    <div class="col-md-1" style="margin-left: 1%; margin-right: 1%;">
                                                        <div class="form-group">
                                                            <label for="H.S" class="control-label">Code</label>
                                                            {!! Form::text('product_code', null, ['id' => 'product_code', 'onkeyup' => 'CodeKeyUp($(this).val());', 'class' => 'form-control']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2" style="margin-right: 1%;">
                                                        <div class="form-group">
                                                            <label for="Name" class="control-label">Product Name</label>
                                                            {!! Form::select('product_name', $products, null, ['id' => 'product_name', 'onchange' => 'ProductKeyUp($(this).val().split("_")[0]);', 'class' => 'form-control']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1" style="margin-right: 1%; display:none;">
                                                        <div class="form-group">
                                                            <label for="Name" class="control-label">Unit</label>
                                                             {!! Form::text('uom_id', 1, [
                                                                'id' => 'uom_id',
                                                                'class' => 'form-control',
                                                                'onkeydown' => 'focusNext(event);',
                                                            ]) !!}
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1" style="margin-right: 1%;">
                                                        <div class="form-group">
                                                            <label for="Name" class="control-label">Unit</label>
                                                            
                                                            {!! Form::text('uom', null, [
                                                                'id' => 'uom',
                                                                'class' => 'form-control',
                                                                'onkeydown' => 'focusNext(event);', 'disabled' => 'disabled'
                                                            ]) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1" style="margin-right: 1%;">
                                                        <div class="form-group">
                                                            <label for="password" class="control-label">Cost</label>
                                                            <!-- <input type="checkbox" id="checkbox7" checked="checked"> -->
                                                            {!! Form::text('product_cost', null, ['id' => 'product_cost', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1" style="margin-right: 1%;">
                                                        <div class="form-group">
                                                            <label for="password" class="control-label">Quantity</label>
                                                            {!! Form::text('quantity', null, ['id' => 'quantity', 'onkeyup' => 'QuantityKeyUp($(this).val())',
                                                                 'class' => 'form-control', 'onkeypress' => 'return onlyNumberKey(event)', 'onfocus'=>'this.value=""']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1" style="margin-right: 1%;">
                                                        <div class="form-group">
                                                            <label for="password" class="control-label">Cost Amount</label>
                                                            {!! Form::text('cost_amount', null, ['id' => 'cost_amount', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1" style="margin-right: 1%;">
                                                        <div class="form-group">
                                                            <label for="Name" class="control-label">Discount</label>
                                                            {!! Form::select('discount_id', $discounts, null, ['id' => 'discount_id', 'onchange' => 'DiscountKeyUp($(this).val().split("_").pop(), $(this).val().split("_")[0]);', 'class' => 'form-control', 'disabled' => 'disabled']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1" style="margin-right: 1%;">
                                                        <div class="form-group">
                                                            <label for="password" class="control-label">Sale Rate</label>
                                                            {!! Form::text('price_per_unit', null, ['id' => 'price_per_unit', 'onkeyup' => 'SaleRate($(this).val())', 'class' => 'form-control', 'onkeypress' => 'return onlyNumberKey(event)',]) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1" style="margin-right: 1%;">
                                                        <div class="form-group">
                                                            <label for="password" class="control-label">Sale Amount</label>
                                                            {!! Form::text('balance', null, ['id' => 'balance', 'class' => 'form-control', 'onkeypress' => 'return onlyNumberKey(event)']) !!}
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-success" type="button" onkeyup="AddGridData();" onclick="AddGridData();"
                                                        style="margin-top:2%;">Add</button>
                                                </tr>
                                            </div></br>
                                            <table id="myData">
                                                <?php $totalRate = 0;
                                                $totalAmount = 0;
                                                $totalQty = 0; ?>
                                                @foreach ($edit->sale_details as $saleDetail)
                                                    <tr>
                                                        <td style="display:none;">
                                                            <input id="test" value="{{ $saleDetail->product_id }}"
                                                                type="text" class="form-control" disabled>
                                                        </td>
                                                        <td style="padding-top:20px;">
                                                            <input id="test"
                                                                value="{{ $saleDetail->products->product_code }}"
                                                                type="text" class="form-control"
                                                                style="margin-left: 7%; width: 80%;" disabled>
                                                        </td>
                                                        <td style="padding-top:20px;">
                                                            <input id="test"
                                                                value="{{ $saleDetail->products->product_name }}"
                                                                type="text" class="form-control"
                                                                style="margin-left: -4%; width: 157%;" disabled>
                                                        </td>
                                                        <td style="display:none;">
                                                            <input id="test" value="{{ $saleDetail->uoms->id }}"
                                                                type="text" class="form-control" style="margin-left: -25%;
                         width: 120%;" disabled>
                                                        </td>
                                                        <td style="padding-top:20px;">
                                                            <input id="test" value="{{ $saleDetail->products->uom }}"
                                                                type="text" class="form-control" style="margin-left: 60%;
                         width: 79%;" disabled>
                                                        </td>
                                                        <td style="padding-top:20px;">
                                                            <input id="test" value="{{ $saleDetail->product_cost }}"
                                                                type="text" class="form-control"
                                                                style="margin-left: 48%; width: 78%;" disabled>
                                                        </td>
                                                        <td style="padding-top:20px;">
                                                            <input id="test" value="{{ $saleDetail->quantity }}"
                                                                type="text" class="form-control"
                                                                onkeyup="QtyChange($(this).val(), $(this).closest('tr').index());",
                                                                onkeypress = "return onlyNumberKey(event)",
                                                                style="margin-left: 34%; width: 79%;">
                                                        </td>
                                                        <td style="padding-top:20px;">
                                                            <input id="test" value="{{ $saleDetail->cost_amount }}"
                                                                type="text" class="form-control"
                                                                style="width:78%; margin-left: 21%;" disabled>
                                                        </td>
                                                        <td style="display:none;">
                                                            <input id="test" value="{{ $saleDetail->discount->id }}"
                                                                type="text" class="form-control" style="" disabled>
                                                        </td>
                                                        <td style="padding-top:20px;">
                                                            <input id="test"
                                                                value="{{ $saleDetail->discount->discount }}%"
                                                                type="text" class="form-control" style="margin-left: 8%;
                         width: 79%;" disabled>
                                                        </td>
                                                        <td style="padding-top:20px;">
                                                            <input id="test" value="{{ $saleDetail->sale_rate }}"
                                                                type="text" class="form-control"
                                                                onkeyup="salerate($(this).val(), $(this).closest('tr').index());",
                                                                onkeypress = "return onlyNumberKey(event)",
                                                                style="margin-left:-5%; width: 78%;">
                                                        </td>
                                                        <td style="padding-top:20px;">
                                                            <input id="test" value="{{ $saleDetail->sale_amount }}"
                                                                type="text" class="form-control" style="margin-left: -19%;
                         width: 78%;" disabled>
                                                        </td>
                                                        <td onclick="javascript:myDeleteFunction($(this).closest('tr'));"
                                                            style="padding-top:20px;"><button class="btn btn-red"
                                                                type="button" style="margin-left: -80%;"> <i
                                                                    class="icon-trash" title="Delete Row"></i></button>
                                                        </td>
                                                        <?php $totalQty = $totalQty + $saleDetail->quantity; ?>
                                                        <?php $totalRate = $totalRate + $saleDetail->sale_rate; ?>
                                                        <?php $totalAmount = $totalAmount + $saleDetail->sale_amount; ?>
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </table>
                                        </div>
                                    </table><br><br>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading clearfix" id="panelbg">
                                        <div class="container">
                                            <!-- <div class="col-xs-5"><b>Total Quantity</b> <input type="text" id="totalQty" name="totalQty" value="{{ $totalQty }}" disabled	>   </div> -->
                                             <div class="col-xs-6">  </div>
                                            <div class="col-sm-2"> <b>Total Quantity</b> <input type="text"
                                                    id="totalQty" name="totalQty" value="{{ $totalQty }}" disabled>
                                            </div>
                                             <div class="col-sm-2" style="display:none;"> <b>Total Rate</b> <input type="text"
                                                    id="TotalRate" name="TotalRate" value="{{ $totalRate }}" disabled>
                                            </div>
                                            <div class="col-sm-3"> <b>Total Amount</b> <input type="text"
                                                    id="TotalAmount" name="TotalAmount" value="{{ $totalAmount }}"
                                                    disabled> </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <center>
                            <div class="form-actions">
                                <button type="button" class="btn btn-primary" id="btnSave" name="btnSave">Save</button>
                            </div>
                        </center>
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
    <script type="text/javascript">
        $("#party_name").select2();
        $("#party_name").next(".select2").find(".select2-selection").focus(function() {
            $("#party_name").select2("open");
        });

        $("#product_name").select2();
        $("#product_name").next(".select2").find(".select2-selection").focus(function() {
            $("#product_name").select2("open");
        });

        $('#party_name').change(function() {
            $('#party_name').select2().trigger('select2:close');
            $("#product_code").focus();
        });


        function onlyNumberKey(evt) {
        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
        }

        function QtyChange(qty, RowIndex) {
            var cost = $('tr:eq(' + RowIndex + ')', myData).find("td:eq('5')").find('input').val();
            var totalcost = cost * qty;
            //totalcose
            $('tr:eq(' + RowIndex + ')', myData).find("td:eq('7')").find('input').val(totalcost);

            var rate = $('tr:eq(' + RowIndex + ')', myData).find("td:eq('10')").find('input').val();
            var totalrate = rate * qty;
            $('tr:eq(' + RowIndex + ')', myData).find("td:eq('11')").find('input').val(totalrate);
        }

        function salerate(rate, RowIndex) {
            var qty = $('tr:eq(' + RowIndex + ')', myData).find("td:eq('6')").find('input').val();
            var totalrate = rate * qty;
            $('tr:eq(' + RowIndex + ')', myData).find("td:eq('11')").find('input').val(totalrate);

            var TotalRate = document.getElementById('TotalRate').value;
            // alert(TotalRate)
            // var totalAmount = document.getElementById('TotalAmount').value;
            //alert(totalAmount)
            var currentrateMinus = parseInt(TotalRate) - parseInt(rate);
            // alert(currentrateMinus)
            // var grandRate = parseInt(rate) + parseInt(currentrateMinus);
            // alert(rate)
            // var grandAmount = parseInt(totalrate) + parseInt(totalAmount);
            //alert(grandRate)
            document.getElementById('TotalRate').value = currentrateMinus;
            // document.getElementById('TotalAmount').value = grandAmount;
        }


        function submitForm() {
            $("#productsForm").submit();
        }

        function AddGridData() {
            var date = document.getElementById('date').value;
            var InvoiceNo = document.getElementById('invoice_no').value;
            var ProductId = document.getElementById('product_id').value;
            var ProductCode = document.getElementById('product_code').value;
            var ProductName = document.getElementById('product_name').value.split("_").pop();
            var UOMID = document.getElementById('uom_id').value.split("_")[0];
            // var UOM = document.getElementById('uom_id').value.split("_").pop();
            var UOM = document.getElementById('uom').value;
            var Cost = document.getElementById('product_cost').value;
            var Quantity = document.getElementById('quantity').value;
            var CostAmount = document.getElementById('cost_amount').value;
            var discountID = document.getElementById('discount_id').value.split("_")[0];
            var discount = document.getElementById('discount_id').value.split("_").pop();
            var Price = document.getElementById('price_per_unit').value;
            var Amount = document.getElementById('balance').value;

            // document.getElementById('TotalRate').value = Price;
            // document.getElementById('TotalAmount').value = Amount;

            var TotalQty = document.getElementById('totalQty').value;

            var TotalRate = document.getElementById('TotalRate').value;

            var totalAmount = document.getElementById('TotalAmount').value;

            var GrandQty = parseInt(Quantity) + parseInt(TotalQty);
            var grandRate = parseInt(Price) + parseInt(TotalRate);
            var grandAmount = parseInt(Amount) + parseInt(totalAmount);

            document.getElementById('totalQty').value = GrandQty;
            document.getElementById('TotalRate').value = grandRate;
            document.getElementById('TotalAmount').value = grandAmount;

            if((ProductId) == "" || (ProductId) == 0){
                document.getElementById("product_code").focus();
                Swal.fire('Select Product First!');
                 e.preventdefault();
            }

            if((Quantity) == "" || (Quantity) == 0 || (Quantity) == 'NaN' ){
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

            var tableHtml = '<tr>';
            //0
            //tableHtml += '<td>'+ ProductId +'</td>';
            tableHtml +=
                `<td style="display:none;"><input id="test" value="${ProductId}" type="text" class="form-control" disabled></td>`;
            //1
            //tableHtml += '<td>'+ ProductCode +'</td>';
            tableHtml +=
                `<td style="padding-top:20px;"><input id="test" value="${ProductCode}" type="text" class="form-control" style="margin-left: 7%; width: 80%;" disabled></td>`;
            //2
            //tableHtml += '<td>'+ ProductName +'</td>';
            tableHtml +=
                `<td style="padding-top:20px;"><input id="test" value="${ProductName}" type="text" class="form-control" style="margin-left: -4%; width: 157%;" disabled></td>`;
            //3
            tableHtml += `<td style="display:none;"><input id="test" value="${UOMID}" type="text" class="form-control" style="margin-left: -25%;
    		width: 120%;" disabled></td>`;
            //4
            tableHtml += `<td style="padding-top:20px;"><input id="test" value="${UOM}" type="text" class="form-control" style="margin-left: 60%;
	    width: 79%;" disabled></td>`;
            //5
            //tableHtml += '<td>'+ Cost +'</td>';
            tableHtml +=
                `<td style="padding-top:20px;"><input id="test" value="${Cost}" type="text" class="form-control" style="margin-left: 48%; width: 78%;" disabled></td>`;
            //6
            //tableHtml += '<td>'+ Quantity +'</td>';
            tableHtml +=
                `<td style="padding-top:20px;"><input id="test" value="${Quantity}" type="text" class="form-control" style="margin-left: 34%; width: 79%;" onkeypress = "return onlyNumberKey(event)",  onkeyup="QtyChange($(this).val(), $(this).closest('tr').index());"></td>`;
            //tableHtml += '<td>'+ CostAmount +'</td>';
            //7
            tableHtml +=
                `<td style="padding-top:20px;"><input id="test" value="${CostAmount}" type="text" class="form-control" style="width:78%; margin-left: 21%;" disabled></td>`;
            //8
            tableHtml +=
                `<td style="display:none;"><input id="test" value="${discountID}" type="text" class="form-control" style="" disabled></td>`;
            //9
            tableHtml +=
                `<td style="padding-top:20px;"><input id="test" value="${discount}%" type="text" class="form-control" style="margin-left: 8%; width: 79%;" disabled></td>`;
            //10
            // tableHtml += '<td>'+ Price +'</td>';
            tableHtml +=
                `<td style="padding-top:20px;"><input id="test" value="${Price}" type="text" class="form-control" style="margin-left:-5%; width: 78%;"  onkeypress = "return onlyNumberKey(event)", onkeyup="salerate($(this).val(), $(this).closest('tr').index());"></td>`;
            //11
            tableHtml +=
                `<td style="padding-top:20px;"><input id="test" value="${Amount}" type="text" class="form-control" style="margin-left: -19%; width: 78%;" disabled></td>`;
            // document.getElementById('test').value=Price;
            // tableHtml += '<td>'+ Amount +'</td>';
            //12
            tableHtml +=
                '<td><button class="btn btn-red" type="button" style="    margin-left: -34px; margin-top: 20px;"> <i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-trash" title="Delete Row"></i></button></td>';
            tableHtml += '</tr></br>';
            $('#myData').append(tableHtml);
            document.getElementById("product_code").focus();
        }

        function SaleKeyUp(SaleValue, RowIndex) {
            var quantity = $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('5')").text();
            // alert(quantity)
            var total = SaleValue * quantity;
            $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('8')").text(total);
        }

        // on javascript onclick on product dropdown 
        function ProductKeyUp(productID) {
            // alert('sss')
            
            $.ajax({
                type: "GET",
                url: "{{ asset('productkeyup-ajax') }}?prodID=" + productID,
                success: function(result) {
                    if (result.length > 0) {
                        $('#product_code').val(result[0].product_code);
                        $('#product_id').val(result[0].id);
                        //$("#product_cost").val(result[0].unit_cost);
                        $("#product_cost").val(result[0].product_cost);
                        $("#price_per_unit").val(result[0].product_price);
                        $("#uom").val(result[0].uom);

                         var price = $("#price_per_unit").val();
                         var quantity = $("#quantity").val();
                         var cost = $("#product_cost").val();
                         var CostAmount = cost * quantity;
                         var SaleAmount = price * quantity;
                        //  var totalDiscount = ((discountnew / 100) * quantity * price);
                         document.getElementById('cost_amount').value = CostAmount;
                         document.getElementById('balance').value = SaleAmount;
                        $("#quantity").focus();
                        
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }

        function SaleRate(salerate) {
            var quantity = document.getElementById('quantity').value;
            var price = document.getElementById('price_per_unit').value;
            var discount = document.getElementById('discount_id').value.split("_").pop();
            var total = quantity * salerate;
            var totalDiscount = (discount / 100 * price * quantity);
            document.getElementById('balance').value = total - totalDiscount;
        }

        function QuantityKeyUp(quantity) {
            var price = document.getElementById('price_per_unit').value;
            var cost = document.getElementById('product_cost').value;
            var CostAmount = quantity * cost;
            document.getElementById('cost_amount').value = CostAmount;
            total = (quantity * price);
            document.getElementById('balance').value = total;
        }

        function DiscountKeyUp(discount, discountID) {
            var price = document.getElementById('price_per_unit').value;
            var cost = document.getElementById('product_cost').value;
            var quantity = document.getElementById('quantity').value;
            var CostAmount = quantity * cost;
            var totalDiscount = discount / 100 * price * quantity;
            //alert(totalDiscount)
            document.getElementById('cost_amount').value = CostAmount;
            total = (quantity * price);
            document.getElementById('balance').value = total - totalDiscount;
        }

        function PartyKeyUp(partyId) {
            $.ajax({
                type: "GET",
                url: "{{ asset('partyonchange-ajax') }}?party_id=" + partyId,
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
                    var TotalQty = document.getElementById('totalQty').value;
                    var TotalRate = document.getElementById('TotalRate').value;
                    var TotalAmount = document.getElementById('TotalAmount').value;
                    var quantity = $(row).find("td:eq('6')").find("input").val();
                    var rate = $(row).find("td:eq('10')").find("input").val();
                    var amount = $(row).find("td:eq('11')").find("input").val();
                    //alert(rate)
                    //alert(amount)
                    var grandQty = parseInt(TotalQty) - parseInt(quantity);
                    var grandRate = parseInt(TotalRate) - parseInt(rate);
                    var grandAmount = parseInt(TotalAmount) - parseInt(amount);
                    document.getElementById('totalQty').value = grandQty;
                    document.getElementById('TotalRate').value = grandRate;
                    document.getElementById('TotalAmount').value = grandAmount;
                    $(row).remove();
                    // alertify.alert("Record is Removed!");
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
            //document.getElementById('total_costnew').value = totalDiscount;
            $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val(total - totalDiscount);
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
                    purchase.date = $("#date").val();
                    if ($("#due_date").val() != "") {
                        purchase.due_date = $("#due_date").val();
                        purchase.particulars = $("#particulars").val();
                    }
                    purchase.party_id = $("#party_id").val();
                    if ($("#party_id").val() == "1") {
                        purchase.sale_type = "Cash Sale";
                    } else {
                        purchase.sale_type = "Credit Sale";
                    }
                    purchase.sale_list = $("#sale_list").val();
                    purchase.sample_description = $("#sample_description").val();
                    purchase.dcn_no = $("#dcn_no").val();
                    purchase.warehouse_id = $("#warehouse_id").val();
                    purchase.invoice_no = $("#invoice_no").val();
                    purchase.localExport = $("#localExport").val();
                    purchase.biller = $("#biller").val();
                    purchase.company_id = $('#company_id').val();

                    var products = [];
                    debugger;
                    $.each($("#myData tr"), function(index, row) {
                        var columns = $(row).find("td");
                        var product = new Object();
                        product.party_id = $("#party_id").val();
                        product.product_id = $(columns[0]).find("input").val();
                        product.uom_id = $(columns[3]).find("input").val();
                        product.product_cost = $(columns[5]).find("input").val();
                        product.quantity = $(columns[6]).find("input").val();
                        product.cost_amount = $(columns[7]).find("input").val();
                        product.discount_id = $(columns[8]).find("input").val();
                        product.sale_rate = $(columns[10]).find("input").val();
                        product.balance = $(columns[11]).find("input").val();
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
                        url: "{{ asset('sales') }}/<?php echo $edit->id; ?>",

                        success: function(result) {
                            //if(result == "inserted")
                            if (parseInt(result) > 0) {
                                window.open("{{ asset('sales/print') }}/" + result);
                                window.location.href = "{{ asset('sales') }}";
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
                    Swal.fire('Add your products in Grid');
                    e.preventdefault();
                }
                }
            });
        });
    </script>
@stop
