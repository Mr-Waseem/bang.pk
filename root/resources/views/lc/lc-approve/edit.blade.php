@extends("app")
@section("contents")
<!-- <body onload="AddRowFunction()"> -->
<body>
<div class="container-fluid">
	@if (Session::has('flash_message'))
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="margin-right: 20px;margin-top: 15px;">&times;</button>
		<div class="alert alert-success"> {{ Session::get('flash_message') }} </div>
	@endif
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading clearfix" id="panelbg">
				<h2 class="panel-title"><b>Edit Sale</b></h2>
				<!-- <ul class="panel-tool-options"> 
					<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
					<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
					<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
				</ul> -->
			</div>
		<div class="panel-body">
			<input id="token" type="hidden" value="{{$encrypted_token}}">
			@include('errors.validation')
			{!! Form::model($edit, ['method' => 'PATCH', 'action' => ['SalesController@update', $edit->id], 'class' => 'form-horizontal' ]) !!}	
				<div class="row">
					<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
						<label class="col-sm-1 control-label">Date</label>  
						<div class="col-sm-2"> 
							<div id="year-view" class="input-group date"> 
								<!-- <input id="date" type="date" name="date"  class="form-control" required autofocus> --> 
								{!! Form::date('date', $edit->date, ['id' => 'date', 'placeholder' => 'Description','class'=>'form-control']) !!}
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</div>
						</div>
						<label class="col-sm-3 control-label">Sale&nbsp;Type</label>  
						<div class="col-sm-2"> 
							{!! Form::select('sale_type', array('Cash Sale' => 'Cash Sale', 'Credit Sale' => 'Credit Sale'), $edit->sale_type, ['id' => 'sale_type', 'onchange' => 'LedgerValues($(this).val())', 'class'=>'form-control livesearch']) !!}
							 <!-- <select class="form-control livesearch" onchange="LedgerValues($(this).val());" id="sale_type" name="sale_type">
								<option value="Cash Sale">Cash Sale</option>
								<option value="Credit Sale">Credit Sale</option>
							</select> -->
						</div> 							
					</div>
				</div>
				
				<div class="row" id="ledgerRow" style="display:none;">
					<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
						<label class="col-sm-1 control-label">Due&nbsp;Date</label>  
						<div class="col-sm-2"> 
							<div id="year-view" class="input-group date"> 
								<!-- <input id="due_date" type="date" value="<?php echo date('Y-m-d');?>" name="due_date" class="form-control">  -->
								{!! Form::date('due_date', $edit->due_date, ['id' => 'due_date', 'class'=>'form-control']) !!}
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
							</div>
						</div>
					
						<label class="col-sm-3 control-label">Description</label>
						<div class="col-sm-2">
							{!! Form::text('particulars', null, ['id' => 'particulars', 'placeholder' => 'Description','class'=>'form-control']) !!}
						</div> 							
					</div>
				</div>
				@if($edit->sale_type == "Credit Sale")
				@endif
				<div class="form-group" style="margin-left: 0px;"> 
					<label class="col-sm-1 control-label">Bill No#</label>  
						<div class="col-sm-2"> 
							<div id="year-view" class="input-group date"> 
								{!! Form::text('invoice_no', null, ['id' => 'invoice_no','class'=>'form-control', 'required' => 'required']) !!} 
							</div>
						</div>
						<label class="col-sm-3 control-label">Bill&nbsp;Type</label>  
						<div class="col-sm-2" style="margin-left: -6px;">
							<select class="form-control livesearch" id="localExport" name="localExport">
								<option value="Local">Local</option>
								<option value="Export">Export</option>
							</select>
						</div>  
				</div>
				<div class="form-group" style="display:none;"> 
					<label class="col-sm-3 control-label">Biller</label>  
					<div class="col-sm-5"> 
					  <select name="biller" id="biller" class="form-control" disabled>
						<option value="{{ Auth::user()->id }}">{{ Auth::user()->name}}</option>
					  </select>
					</div> 
				</div>
				<div class="row">
					<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
						<label class="col-sm-1 control-label">Sale Type</label>
						<div class="col-sm-2">
							 
								{!! Form::select('sale_list', array('Sale Bill' => 'Sale Bill', 'Sample' => 'Sample'), null, ['id' => 'sale_list', 'onchange' => 'SampleDescription($(this).val());', 'class'=>'form-control livesearch']) !!}
							
						</div>
						<label class="col-sm-3 control-label">Warehouse</label>  
						<div class="col-sm-2">
							<!-- {!! Form::select('dcn_no', $DeliveryChallan, null, ['id' => 'dcn_no', 'onchange' => 'DCMouseUp($(this).val());', 'class'=>'form-control livesearch', 'disabled' => 'disabled']) !!} -->
							{!! Form::select('warehouse_id', $warehouse, $edit->warehouse_id, ['id' => 'warehouse_id', 'class'=>'form-control livesearch']) !!}
						</div>  							
					</div>
				</div>
				
				 <div class="form-group" id="sample_div" style="margin-left: 0%; display:none;">
					<label class="col-sm-1 control-label">Description</label>  
					<div class="col-sm-2"> 
					{!! Form::text('sample_description', null, ['id' => 'sample_description', 'class'=>'form-control']) !!}
					</div> 
				</div>
				@if($edit->sample_description == "Sample")
				@endif
				<div class="row">
					<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
						{!! Form::hidden('party_id', $edit->party_id, ['id' => 'party_id', 'class'=>'form-control']) !!} 
						<label class="col-sm-1 control-label">Account</label>
						<div class="col-sm-2"> 
								{!! Form::select('party_name', $customers, $edit->party_id, ['id' => 'party_name',  'onchange' => 'javascript:PartyKeyUp($(this).val());','class'=>'form-control livesearch', 'required' => 'required', 'placeholder' => 'Start Typing......']) !!} 
						</div> 
						<!-- <label class="col-sm-1 control-label">Address</label>  --> 
						<div class="col-sm-3">
							{!! Form::text('address', $edit->parties->address, ['id' => 'address','class'=>'form-control', 'placeholder' => 'Address', 'disabled' => 'disabled']) !!}
						</div> 
						<!-- <label class="col-sm-1 control-label">NTN</label>  --> 
						<div class="col-sm-2">
							{!! Form::text('ntn', $edit->parties->ntn, ['id' => 'ntn','class'=>'form-control', 'placeholder' => 'NTN', 'disabled' => 'disabled']) !!} 
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
		{!! Form::hidden('product_id', null, ['id' => 'product_id','class'=>'form-control']) !!}
			<div class="col-md-1" style="margin-left: 1%; margin-right: 1%;"> 
				<div class="form-group"> 
					<label for="H.S" class="control-label">Code</label>
					{!! Form::text('product_code', null, ['id' => 'product_code', 'onkeyup' => 'CodeKeyUp($(this).val());', 'class'=>'form-control']) !!}
				</div>
			</div> 
			<div class="col-md-2" style="margin-right: 1%;"> 
				<div class="form-group"> 
					<label for="Name" class="control-label">Product Name</label> 
					{!! Form::select('product_name', $products, null, ['id' => 'product_name',  'onchange' => 'ProductKeyUp($(this).val());','class'=>'form-control livesearch']) !!}
				</div> 
			</div> 
			<div class="col-md-1" style="margin-right: 1%;"> 
				<div class="form-group"> 
					<label for="Name" class="control-label">Unit</label> 
					{!! Form::select('uom_id', $uoms, null, ['id' => 'uom_id', 'class'=>'form-control']) !!}
				</div> 
			</div> 
			<div class="col-md-1"style="margin-right: 1%;"> 
				<div class="form-group"> 
					<label for="password" class="control-label">Cost</label> 
					<input type="checkbox" id="checkbox7" checked="checked">
					{!! Form::text('product_cost', null, ['id' => 'product_cost', 'class'=>'form-control']) !!}
				</div> 
			</div>
			<div class="col-md-1"style="margin-right: 1%;"> 
				<div class="form-group"> 
					<label for="password" class="control-label">Quantity</label> 
					{!! Form::text('quantity', 1, ['id' => 'quantity', 'onkeyup' => 'QuantityKeyUp($(this).val())', 'class'=>'form-control']) !!}
				</div> 
			</div>
			<div class="col-md-1" style="margin-right: 1%;"> 
				<div class="form-group"> 
					<label for="password" class="control-label">Cost Amount</label> 
					{!! Form::text('cost_amount', null, ['id' => 'cost_amount', 'class'=>'form-control']) !!}
				</div> 
			</div>
			<div class="col-md-1" style="margin-right: 1%;"> 
				<div class="form-group"> 
					<label for="Name" class="control-label">Discount</label> 
					{!! Form::select('discount_id', $discounts, null, ['id' => 'discount_id',  'onchange' => 'DiscountKeyUp($(this).val().split("_").pop(), $(this).val().split("_")[0]);','class'=>'form-control']) !!}
				</div> 
			</div> 
			<div class="col-md-1"style="margin-right: 1%;"> 
				<div class="form-group"> 
					<label for="password" class="control-label">Sale Rate</label> 
					{!! Form::text('price_per_unit', null, ['id' => 'price_per_unit', 'onkeyup' => 'SaleRate($(this).val())','class'=>'form-control']) !!}
				</div> 
			</div>
			<div class="col-md-1"style="margin-right: 1%;"> 
				<div class="form-group"> 
					<label for="password" class="control-label">Sale Amount</label> 
					{!! Form::text('balance', null, ['id' => 'balance', 'onkeyup' => 'AddGridData()', 'class'=>'form-control']) !!}
				</div> 
			</div>
		</tr>
	</div></br>
	<table id="myData">
		<?php $totalRate = 0; $totalAmount = 0; ?>
		@foreach($edit->sale_details as $saleDetail) 
		<tr>
		<td style="display:none;">
			<input id="test" value="{{$saleDetail->product_id}}" type="text" class="form-control" disabled>
		</td>
		<td style="padding-top:20px;">
			<input id="test" value="{{$saleDetail->products->product_code}}" type="text" class="form-control"style="margin-left: 7%; width: 80%;" disabled>
		</td> 
		<td style="padding-top:20px;">
			<input id="test" value="{{$saleDetail->products->product_name}}" type="text" class="form-control" style="margin-left: -4%; width: 157%;" disabled>
		</td>
		<td style="display:none;">
			<input id="test" value="{{$saleDetail->uoms->id}}" type="text" class="form-control" style="margin-left: -25%;
	    	width: 120%;" disabled>
		</td>
	    <td style="padding-top:20px;">
	    	<input id="test" value="{{$saleDetail->uoms->uom}}" type="text" class="form-control" style="margin-left: 60%;
	    	width: 79%;" disabled>
		</td>
	    <td style="padding-top:20px;">
	    	<input id="test" value="{{$saleDetail->product_cost}}" type="text" class="form-control" style="margin-left: 48%; width: 78%;" disabled>
	    </td>
	    <td style="padding-top:20px;">
	    	<input id="test" value="{{$saleDetail->quantity}}" type="text" class="form-control" style="margin-left: 34%; width: 79%;" disabled>
	    </td>
	    <td style="padding-top:20px;">
	    	<input id="test" value="{{$saleDetail->cost_amount}}" type="text" class="form-control" style="width:78%; margin-left: 21%;" disabled>
	    </td>
	    <td style="display:none;">
	    	<input id="test" value="{{$saleDetail->discount->id}}" type="text" class="form-control" style="" disabled>
	    </td>
	    <td style="padding-top:20px;">
	    	<input id="test" value="{{$saleDetail->discount->discount}}%" type="text" class="form-control" style="margin-left: 8%;
	   		width: 79%;" disabled>
		</td>
	    <td style="padding-top:20px;">
	    	<input id="test" value="{{$saleDetail->sale_rate}}" type="text" class="form-control" style="margin-left:-5%; width: 78%;" disabled>
	    </td>
	    <td style="padding-top:20px;">
	    	<input id="test" value="{{$saleDetail->sale_amount}}" type="text" class="form-control" style="margin-left: -19%;
	    	width: 78%;" disabled>
		</td>
	    <td style="padding-top:20px;"><button class="btn btn-red" type="button" style="margin-left: -80%;"> <i onclick="javascript:myDeleteFunction($(this).closest('tr'));" class="icon-trash" title="Delete Row"></i></button></td>
	    <?php $totalRate = $totalRate + $saleDetail->sale_rate; ?>
	    <?php $totalAmount = $totalAmount + $saleDetail->sale_amount; ?>
		</td> 
		</tr> 
		@endforeach
	
	</table>
	</div>
	</table></br></br>
				</div>
				</div>
			</div>
<div class="row">
<div class="col-lg-12">
	<div class="panel panel-default">
		<div class="panel-heading clearfix" id="panelbg">
			<div class="container">
			  <div class="col-xs-5">  </div>
			  <!-- <div class="col-xs-3">  </div> -->
			  <div class="col-xs-3"> <b>Total Rate</b> <input type="text" id="TotalRate" name="TotalRate" value="{{$totalRate}}" disabled	> </div>
			  <div class="col-xs-3"> <b>Total Amount</b> <input type="text" id="TotalAmount" name="TotalAmount" value="{{$totalAmount}}" disabled> </div>
			</div>
		</div>
<!-- 		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead> 
						<tr> 
							<th></th>  
							<th>Product&nbsp;ID</th>  
							<th>Code</th>  
							<th>Product&nbsp;Name</th> 
							<th>Cost</th> 
							<th>Quantity</th>
							<th>Cost&nbsp;Amount</th>
							<th>Sale&nbsp;Rate</th> 
							<th>Sale&nbsp;Amount</th>  
						</tr> 
					</thead> 
					<tbody id="GridTable">
					
					</tbody> 
				</table>
			</div>
		</div> -->
	</div>
</div>
</div>
			<center><div class="form-actions">
			  <button type="button" class="btn btn-primary" id="btnSave" name="btnSave">Save</button>
			</div></center>		
			<!-- <div class="col-lg-3">
				<button type="button" onclick="AddRowFunction()" class="btn btn-success"><i class="fa fa-plus"></i> </button>
				<button type="button" onclick="AddGridData()" class="btn btn-success"><i class="fa fa-plus"></i> </button>
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
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
<script src="/js/plugins/nouislider/nouislider.min.js"></script>
<!-- Input Mask-->
<script src="/js/plugins/jasny/jasny-bootstrap.min.js"></script>
<!-- Select2-->
<script src="/js/plugins/select2/select2.full.min.js"></script>
<!--Bootstrap ColorPicker-->
<script src="/js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!--Bootstrap DatePicker-->
<script src="/js/plugins/datepicker/bootstrap-datepicker.js"></script>

<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>
<script type="text/javascript">
	$(".livesearch").chosen();
</script> -->

<script type="text/javascript">

	function AddGridData(){
		var date = document.getElementById('date').value;
		var InvoiceNo = document.getElementById('invoice_no').value;
		var ProductId = document.getElementById('product_id').value;
		var ProductCode = document.getElementById('product_code').value;
		var ProductName = document.getElementById('product_name').value.split("_").pop();
		var UOMID = document.getElementById('uom_id').value.split("_")[0];
		var UOM = document.getElementById('uom_id').value.split("_").pop();
		var Cost = document.getElementById('product_cost').value;
		var Quantity = document.getElementById('quantity').value;
		var CostAmount = document.getElementById('cost_amount').value;
		var discountID = document.getElementById('discount_id').value.split("_")[0];
		var discount = document.getElementById('discount_id').value.split("_").pop();
		var Price = document.getElementById('price_per_unit').value;
		var Amount = document.getElementById('balance').value;
		//alert(Amount)
		// document.getElementById('TotalRate').value = Price;
		// document.getElementById('TotalAmount').value = Amount;

		var TotalRate = document.getElementById('TotalRate').value;
		var totalAmount = document.getElementById('TotalAmount').value;

		var grandRate = parseInt(Price) + parseInt(TotalRate);
		var grandAmount = parseInt(Amount) + parseInt(totalAmount);

		document.getElementById('TotalRate').value = grandRate;
		document.getElementById('TotalAmount').value = grandAmount;

		var tableHtml = '<tr>';
		//0
		//tableHtml += '<td>'+ ProductId +'</td>';
		tableHtml += `<td style="display:none;"><input id="test" value="${ProductId}" type="text" class="form-control" disabled></td>`;
		//1
		//tableHtml += '<td>'+ ProductCode +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="test" value="${ProductCode}" type="text" class="form-control" style="margin-left: 7%; width: 80%;" disabled></td>`;
    	//2
		//tableHtml += '<td>'+ ProductName +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="test" value="${ProductName}" type="text" class="form-control" style="margin-left: -4%; width: 157%;" disabled></td>`;
    	//3
    	tableHtml += `<td style="display:none;"><input id="test" value="${UOMID}" type="text" class="form-control" style="margin-left: -25%;
    		width: 120%;" disabled></td>`;
    	//4
	    tableHtml += `<td style="padding-top:20px;"><input id="test" value="${UOM}" type="text" class="form-control" style="margin-left: 60%;
	    width: 79%;" disabled></td>`;
    	//5
		//tableHtml += '<td>'+ Cost +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="test" value="${Cost}" type="text" class="form-control" style="margin-left: 48%; width: 78%;" disabled></td>`;
		//6
		//tableHtml += '<td>'+ Quantity +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="test" value="${Quantity}" type="text" class="form-control" style="margin-left: 34%; width: 79%;" disabled></td>`;
		//tableHtml += '<td>'+ CostAmount +'</td>';
		//7
		tableHtml += `<td style="padding-top:20px;"><input id="test" value="${CostAmount}" type="text" class="form-control" style="width:78%; margin-left: 21%;" disabled></td>`;
		//8
		tableHtml += `<td style="display:none;"><input id="test" value="${discountID}" type="text" class="form-control" style="" disabled></td>`;
		//9
		tableHtml += `<td style="padding-top:20px;"><input id="test" value="${discount}%" type="text" class="form-control" style="margin-left: 8%; width: 79%;" disabled></td>`;
    	//10
		// tableHtml += '<td>'+ Price +'</td>';
		 tableHtml += `<td style="padding-top:20px;"><input id="test" value="${Price}" type="text" class="form-control" style="margin-left:-5%; width: 78%;" disabled></td>`;
		 //11
		 tableHtml += `<td style="padding-top:20px;"><input id="test" value="${Amount}" type="text" class="form-control" style="margin-left: -19%; width: 78%;" disabled></td>`;
		// document.getElementById('test').value=Price;
		// tableHtml += '<td>'+ Amount +'</td>';
		//12
		tableHtml += '<td><button class="btn btn-red" type="button" style="    margin-left: -34px; margin-top: 20px;"> <i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-trash" title="Delete Row"></i></button></td>';
		tableHtml += '</tr></br>';
		$('#myData').append(tableHtml);
		document.getElementById("product_code").focus();
	}

function LedgerValues(values){
	// alert("sammmr")
	// 	 $value = $("#sale_type").val();
	//  alert(value)
	 if(values == "Cash Sale"){
	 	$('#ledgerRow').hide();
	 }
	  if(values == "Credit Sale"){
   $('#ledgerRow').show();
}

}

function SampleDescription(val){
	// alert(val)
	// $value = $("#sale_list").val();
	// alert(value)
	if(val == "Sample"){
	 	$('#sample_div').show();
	 }
	 if(val == "Sale Bill" || val == "Sale Invoice"){
	 	$('#sample_div').hide();
	 }
}


	function DCMouseUp(value){
	$.ajax({
		type: "GET",
		url: "/dcmouseup-ajax?dc_no=" + value,
		success: function(data){
			if(data.length > 0)
			{
				$.each(data, function(key, value){
					var newRow = '<tr>'+
									'<td class="text-center"><i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-cancel icon-larger red-color" title="Delete Row"></i> </td>'+
									 '<td>' + data[key].product_id + '</td>'+
									 '<td>' + data[key].product_code + '</td>'+
									 '<td>' + data[key].product_name + '</td>'+
									 '<td>' + data[key].rate + '</td>'+
									 '<td id="quantity">' + data[key].quantity + '</td>'+
									 '<td>' + data[key].amount + '</td>'+
									 '<td><input type="text" onkeyup="SaleKeyUp($(this).val(), $(this).closest(\'tr\').index())"></td>'+
									 '<td></td>'+
									 // '<td style="display:none;">' + data[0].tax_id + '</td>'+
									
								  '</tr>';
      					$('#GridTable').append(newRow);
                    // $("#GridTable tr").append("<td>" +
                    //                     "ID :" + value.pr_no +
                    //                     "Name :"+ value.pr_no +
                    //                     "Age :" + value.pr_no + 
                    //                     "</td>");
                                      
                });
			}
		}
	})

}

function SaleKeyUp(SaleValue, RowIndex)
{
var quantity = $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('5')").text();
// alert(quantity)
var total = SaleValue * quantity;
$('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('8')").text(total);

}

function SaleKeyUpOne(SaleValue)
{
	alert(SaleValue)
}


	function TotalRecords() {
		var rowCount = document.getElementById('myTable').rows.length;
		alert("Total Number of Records Are: " + rowCount);
	}

// on javascript onclick on product dropdown 
// 	function CodeKeyUp(codeValue){
// 		$.ajax({
// 			type: "GET",
// 			url: "/saletab-ajax?code=" + codeValue,
// 			success: function(result) {
// 				if(result.length > 0)
// 				{
// 					$('#product_name').val(result[0].product_name);
// 					$('#product_id').val(result[0].id);
// 					$("#packing_type").val(result[0].catagory_name);
// 					$("#price_per_unit").val(result[0].price_per_unit);
// 					$("#uom").val(result[0].uom);
// 					$("#stvalue").val(result[0].stvalue);

// 					var price = $("#price_per_unit").val();
// 					var quantity = $("#quantity").val();
// 					var stvalue = $("#stvalue").val();
// 					var tax = parseInt((stvalue/100*price)*quantity);
					
// 					document.getElementById('taxvalue').value = tax;
// 					valueWithoutTax = quantity * price;
// 					document.getElementById('value').value = valueWithoutTax;
// 					var total = price * quantity;
// 					var grand = tax + total;
// 					document.getElementById('amount').value = grand;
// 					document.getElementById('grand_total').value = grand;
// 				}	
// 			},
// 			error: function (xhr, ajaxOptions, thrownError) {
// 				alert(xhr.status);
// 				alert(thrownError);
// 			}				
// 		});
// }

	// on javascript onclick on product dropdown 
	function ProductKeyUp(productID){
		$.ajax({
			type: "GET",
			url: "/productkeyup-ajax?prodID=" + productID,
			success: function(result) {
				if(result.length > 0)
				{
					$('#product_code').val(result[0].product_code);
					$('#product_id').val(result[0].id);
					$("#product_cost").val(result[0].unit_cost);
					$("#price_per_unit").val(result[0].price_per_unit);

					var price = $("#price_per_unit").val();
					var quantity = $("#quantity").val();
					var cost = $("#product_cost").val();
					var CostAmount= cost * quantity;
					var SaleAmount = price * quantity;
					document.getElementById('cost_amount').value = CostAmount;
					document.getElementById('balance').value = SaleAmount;
				}	
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}				
		});
}

		// function SaleRate(salerate){
		// 	var quantity = document.getElementById('quantity').value;
		// 	var price = document.getElementById('price_per_unit').value;
		// 	var total = quantity*salerate;
		// 	document.getElementById('balance').value = total;

		// }

			function SaleRate(salerate){
			var quantity = document.getElementById('quantity').value;
			var price = document.getElementById('price_per_unit').value;
			var discount = document.getElementById('discount_id').value.split("_").pop();
			var total = quantity*salerate;
			var totalDiscount = (discount/100*price*quantity);
			document.getElementById('balance').value = total-totalDiscount;

		}

		function QuantityKeyUp(quantity){
			var price = document.getElementById('price_per_unit').value;
			var cost = document.getElementById('product_cost').value;
			var CostAmount = quantity * cost;
			document.getElementById('cost_amount').value = CostAmount;
			total = (quantity * price);
			document.getElementById('balance').value = total;
		}

				function DiscountKeyUp(discount, discountID){
			var price = document.getElementById('price_per_unit').value;
			var cost = document.getElementById('product_cost').value;
			var quantity = document.getElementById('quantity').value;
			var CostAmount = quantity * cost;
			var totalDiscount = discount/100*price*quantity;
			//alert(totalDiscount)
			document.getElementById('cost_amount').value = CostAmount;
			total = (quantity * price);
			document.getElementById('balance').value = total-totalDiscount;
		}

	function PartyKeyUp(partyId){
		$.ajax({
			type: "GET",
			url: "/partyonchange-ajax?party_id=" + partyId,
			success:function(result)
			{
				if(result.length > 0){
					$('#party_id').val(result[0].id);
					$('#address').val(result[0].address);
					$('#strn').val(result[0].strn);
					$('#ntn').val(result[0].ntn);
				}
			}
		})
	}


	//on product Mouse up 
	function productMouseUp(productName, rowIndex){
		$.ajax({
			type: "GET",
			url: "/productonchange-ajax?product_name=" + productName,
			success: function(result) {
				if(result.length > 0)
				{
					$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('0')").find('input').val(result[0].id);
					$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('1')").find('input').val(result[0].product_code);
					$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('3')").find('input').val(result[0].remaining_quantity);
					$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('5')").find('input').val(result[0].unit_cost);

					var salePrice = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val();

					var discount = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('select').val().split("_").pop();
					var quantity = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('3')").find('input').val();
					var price = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val();
					var grand = (price * quantity) - (((discount/100))*price * quantity);
					$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('7')").find('input').val(grand);

				}	
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}				
		});
}

function salepriceMouseUp(salePrice, rowIndex){
	var quantity = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('3')").find('input').val();
	var saleprice = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val();
	var grand = quantity*saleprice;
	$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('7')").find('input').val(grand);
}
		
	$("#product_codess").keyup(function(){
			if($("#product_code").val() != "0")
			{
				$.ajax({
					type: "GET",
					url: "/getfirstProduct-ajax?saletab_id=" + $("#product_code").val(),
					success: function(result) {
						if(result.length > 0)
						{
						$("#product_id").val(result[0].id);
						$("#product_name").val(result[0].product_english);
						$("#unit_cost").val(result[0].product_price);
						
							var quantity = document.getElementById('quantity').value;
							var cost = document.getElementById('unit_cost').value;
							var discount = document.getElementById('discount_id').value.split("_").pop();
							//var tax = document.getElementById('tax_id').value.split("_").pop();
							var totalDiscount = ((discount/100)*quantity*cost);
							var total = quantity * cost;
							document.getElementById('total_cost').value = total - totalDiscount;
							
						}	
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.status);
						alert(thrownError);
					}				
				});				
			}		
		});
	

		function myDeleteFunction(row) {
		alertify.confirm("Are you sure you want to delete this row?", function (e) {
		    if (e) {
		    	var TotalRate = document.getElementById('TotalRate').value;
		    	var TotalAmount = document.getElementById('TotalAmount').value;
				var rate = $(row).find("td:eq('10')").find("input").val();
				var amount = $(row).find("td:eq('11')").find("input").val();
				//alert(rate)
				//alert(amount)
				var grandRate = parseInt(TotalRate) - parseInt(rate);
				var grandAmount = parseInt(TotalAmount) - parseInt(amount);
				document.getElementById('TotalRate').value = grandRate;
				document.getElementById('TotalAmount').value = grandAmount;
		    	$(row).remove();
		        alertify.alert("File is Removed!");
		    } else {
		        alertify.alert("File is safe!");
		    }
		});
		// if(confirm("Are you sure you want to delete this row?"))
		// {
		// 	$(row).remove();
		// }
	}


	function DiscountNew(discount, rowIndex){
		var quantity = $('tr:eq(' + rowIndex +')', myTable).find("td:eq('3')").find('input').val();
		var discountnew = $('tr:eq(' + rowIndex +')', myTable).find("td:eq('4')").find('select').val().split("_").pop();		
		var price = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('5')").find('input').val();
		var totalDiscount = ((discountnew/100)*quantity*price);
		var total = quantity * price;
		//document.getElementById('total_costnew').value = totalDiscount;
		$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val(total-totalDiscount);
		///if(parseFloat(tax) > 0)
		//{
			//var grand = (quantity*unitPrice) - discount;
			
		//}
		//else
		//{
			//$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('5')").find('input').val(unitPrice);
		//}	
				
}

// on javascript onclick on product dropdown
	function quantityMouseUp(quantity, rowIndex){	
		

		var code = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('1')").find('input').val();
		alert(code);
		var remainingquantity = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('8')").find('input').val();
		if (quantity > remainingquantity) {
		    alert("Invalid! Your Remaining Stock is: " + quantity);
		   e.preventdefault();
		}
		var price = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val();
		var discount = $('tr:eq(' + rowIndex +')', myTable).find("td:eq('4')").find('select').val().split("_").pop();
		
		var totalDiscount = ((discount/100)*quantity*price);
		var total = quantity * price;
		$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('7')").find('input').val(total-totalDiscount);
		//if(parseInt(quantity) > 0)
		//{	
			//$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('input').val(grand);
		//}
		//else
		//{
			//$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('input').val(price);
		//}	
				
}

$("#btnSave").click(function()
{
	alertify.confirm("Are you sure you want update Sale Bill?", function (e) {
	if (e)
	{
	var test = $("#party_id").val();
	var purchase = new Object();
	purchase.date = $("#date").val();
	if($("#due_date").val() != ""){
	purchase.due_date = $("#due_date").val();
	purchase.particulars = $("#particulars").val();
	}
	purchase.party_id = $("#party_id").val();
	purchase.sale_type = $("#sale_type").val();
	purchase.sale_list = $("#sale_list").val();
	purchase.sample_description = $("#sample_description").val();
	purchase.dcn_no = $("#dcn_no").val();
	purchase.invoice_no = $("#invoice_no").val();
	purchase.localExport = $("#localExport").val();
	purchase.biller = $("#biller").val();
	 
	
	var products = [];
	debugger;
	$.each($("#myData tr"), function(index, row){
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
		products.push(product);
	});
	
	var $_token = jQuery('#token').val();
	jQuery.ajax({
		method: "PATCH",
		cache: false,
		headers: { 'X-XSRF-TOKEN' : $_token },
		data: {purchase: JSON.stringify(purchase), product_data:products},
		url: "/sales/<?php echo $edit->id ?>",
		
		success: function(result) {
			//if(result == "inserted")
			if(parseInt(result) > 0)
			{
				window.open("/sales/print/"+result);
				window.location.href = "/sales";
				//window.open("/sales/print/"+result);
				//alert("Sale successfully saved.");
				//Session::flash('flash_message', 'Sale Added Successfully!');
				//window.location.href = "/sales";
				
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			$("#spanWait").hide();
			alert(xhr.status);
			alert(thrownError);
		}
	});
	} else {
		        alertify.alert("Not Saved!");
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