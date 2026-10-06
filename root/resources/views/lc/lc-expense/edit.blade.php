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
				<h2 class="panel-title"><b>Edit Cash Receipt</b></h2>
				<!-- <ul class="panel-tool-options"> 
					<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
					<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
					<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
				</ul> -->
			</div>
		<div class="panel-body">
			<input id="token" type="hidden" value="{{$encrypted_token}}">
			@include('errors.validation')
			{!! Form::model($edit, ['method' => 'PATCH', 'action' => ['CashReceiptController@update', $edit->id], 'class' => 'form-horizontal' ]) !!}
				<div class="row">
				<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
					<label class="col-sm-1 control-label">Vr. No</label>  
					<div class="col-sm-2"> 
						<div id="year-view" class="input-group date"> 
							{!! Form::text('voucher_no', null,  ['id' => 'voucher_no','class'=>'form-control', 'disabled' => 'disabled']) !!} 
						</div>
					</div>						
				</div>
			</div>
			<div class="row">
				<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
					<label class="col-sm-1 control-label">Vr. Date</label>  
					<div class="col-sm-2"> 
						<div id="year-view" class="input-group date"> 
							<input id="voucher_date" type="date" name="voucher_date" value="<?php echo date('Y-m-d');?>" class="form-control">
							<!-- <span class="input-group-addon"><i class="fa fa-calendar"></i></span>  -->
						</div>
					</div>					
				</div>
			</div>
			<div class="row" style="display: none;">
				<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
					<label class="col-sm-1 control-label">Voucher Type</label>  
					<div class="col-sm-5" style="height: 40px;"> 
					{!! Form::text('v_type', "Cash Receipt", ['id' => 'v_type', 'class'=>'form-control']) !!}
					</div> 
				</div>
			</div>			
			<div class="row">
				<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
					<label class="col-sm-1 control-label">Cash&nbsp;Account</label>  
					<div class="col-sm-3" style="height: 40px;"> 
					{!! Form::select('account_id', $cashAccount, null, ['id' => 'account_id', 'class'=>'form-control livesearch']) !!}
					</div> 
				</div>
			</div>
			<div class="row" style="display:none;">
				<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
					<label class="col-sm-1 control-label">Biller</label>  
					<div class="col-sm-3" style="height: 40px;"> 
					<select name="biller" id="biller" class="form-control" disabled>
					<option value="{{ Auth::user()->id }}">{{ Auth::user()->name}}</option>
				  </select>
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
								
<!-- <div class="col-md-3"> 
	<div class="form-group"> 
		<label for="H.S" class="control-label">Id</label> -->
		{!! Form::hidden('product_id', null, ['id' => 'product_id','class'=>'form-control']) !!}
	<!-- </div>
</div>  -->
<div class="col-md-2" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="H.S" class="control-label">Date</label>
		<input id="date" type="date" name="date" value="<?php echo date('Y-m-d');?>" class="form-control" autofocus>
	</div>
</div> 
<div class="col-md-1" style="display:none; margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Voucher&nbsp;No</label> 
		{!! Form::text('voucher_no', $codes, ['id' => 'voucher_no', 'class'=>'form-control']) !!}
	</div> 
</div>
<div class="col-md-2" style="display:none;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Type</label> 
		{!! Form::text('v_type', "Cash Receipt", ['id' => 'v_type', 'class'=>'form-control']) !!}
	</div> 
</div>
<div class="col-md-3" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="Name" class="control-label">Party&nbsp;/&nbsp;Customer</label> 
		{!! Form::select('account_head_id', $Accounts, null, ['id' => 'account_head_id', 'class'=>'form-control livesearch']) !!}
	</div> 
</div> 
<div class="col-md-2" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Narration</label> 
		{!! Form::text('narration', "CASH RECIEVED", ['id' => 'narration', 'class'=>'form-control']) !!}
	</div> 
</div>
<div class="col-md-2" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Amount</label> 
		{!! Form::text('amount', 0, ['id' => 'amount', 'class'=>'form-control']) !!}
	</div> 
</div>
<!-- <div class="col-md-2"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Credit</label> 
		{!! Form::text('credit', 0, ['id' => 'credit', 'class'=>'form-control']) !!}
	</div> 
</div> -->
 <div class="col-md-1"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Add</label>
		 <button class="form-control" type="button" class="btn btn-red" onkeyup="AddGridData();" style="background: #e20707;">Add</button>
	</div> 
</div>
</tr>
	</div></br>
	<table id="myData">
		<?php $totalRate = 0; $totalAmount = 0; ?>
		@foreach($edit->voucher_details as $details) 
		@if($details->credit!=null)
		<tr>
			<td style="display:none;">
				<input id="account_head_id" value="{{$details->account_head_id}}" type="text" class="form-control" disabled>
			</td>
			<td style="margin-left: 1%; margin-right: 1%; padding-top:2%">
				<input id="product_id" value="{{$details->date}}" style="margin-left: 7%; width: 102%;" type="text" class="form-control" disabled>
			</td>
			<td style="display:none;">
				<input id="voucher_no" value="{{$details->voucher_no}}" type="text" class="form-control" disabled>
			</td>
			<td style="display:none;">
				<input id="v_type" value="Cash Receipt" type="text" class="form-control" disabled>
			</td>
			<td style="margin-left: 1%; margin-right: 1%; padding-top:2%">
				<input id="account_head_name" value="{{$details->parties->party_name}}" style="margin-left: 22%; width: 154%;" type="text" class="form-control" disabled>
			</td>
			<td style="margin-left: 1%; margin-right: 1%; padding-top:2%">
				<input id="product_id" value="{{$details->narration}}" style="margin-left: 88%; width: 104%;" type="text" class="form-control" disabled>
			</td>
			<td style="margin-left: 1%; margin-right: 1%; padding-top:2%">
				<input id="product_id" value="{{$details->credit}}" style="margin-left: 105%; width: 103%;" type="text" class="form-control" disabled>
			</td>
			<td style="padding-top:2%"><button class="btn btn-red" type="button" style="margin-left: 500%;"> <i onclick="javascript:myDeleteFunction($(this).closest('tr'));" class="icon-trash" title="Delete Row"></i></button></td>

	    <?php $totalAmount = $totalAmount + $details->credit; ?>

<!-- <div class="col-md-1" style="display:none; margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Voucher&nbsp;No</label> 
		<input id="account_head_id" value="{{$details->account_head_id}}" type="account_head_id" class="form-control"style="" disabled>
	</div> 
</div>
<div class="col-md-2" style="display:none;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Type</label> 
		{!! Form::text('v_type', "Cash Receipt", ['id' => 'v_type', 'class'=>'form-control']) !!}
	</div> 
</div>
<td style="padding-top:20px;">
	    	<input id="test" value="{{$details->parties->party_name}}" type="text" class="form-control" style="margin-left: 60%;
	    	width: 79%;" disabled>
		</td>
<div class="col-md-3" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<input id="date" value="{{$details->parties->party_name}}" type="text" class="form-control" style="" disabled>
	</div> 
</div> 
<div class="col-md-2" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<input id="date" value="{{$details->narration}}" type="text" class="form-control"style="" disabled>
	</div> 
</div>
<div class="col-md-2" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<input id="date" value="{{$details->credit}}" type="text" class="form-control"style="" disabled>
	</div> 
</div> -->
<!--  <div class="col-md-1"> 
	<div class="form-group"> 
		 <button class="btn btn-red" type="button"> <i onclick="javascript:myDeleteFunction($(this).closest('tr'));" class="icon-trash" title="Delete Row"></i></button>

	</div> 
</div> -->

		</tr> </br>
		@endif
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
			  <div class="col-lg-5">  </div>
			  <!-- <div class="col-xs-3">  </div> -->
			  <!-- <div class="col-xs-3"> <b>Total Rate</b> <input type="text" id="TotalRate" name="TotalRate" value="{{$totalRate}}" disabled	></div> -->
			  <div class="col-lg-3"> <b>Total&nbsp;Amount</b> <input type="text" id="TotalAmount" name="TotalAmount" value="{{$totalAmount}}" disabled> </div>
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
		var VoucherNo = document.getElementById('voucher_no').value;
		var v_type = document.getElementById('v_type').value
		var HeadTitle = document.getElementById('account_head_id').value.split("_").pop();
		var HeadId = document.getElementById('account_head_id').value.split("_")[0];
		var Narration = document.getElementById('narration').value;
		var Amount = document.getElementById('amount').value;
		var TotalAmount = document.getElementById('TotalAmount').value;
		var grand = parseInt(Amount) + parseInt(TotalAmount);
		document.getElementById('TotalAmount').value = grand;
		// var Credit = document.getElementById('credit').value;
		var tableHtml = '</br><tr>';
		//1
		tableHtml += `<td style="display:none;"><input id="product_id" value="${HeadId}" type="text" class="form-control" disabled></td>`;
		//2
		tableHtml += `<td style="margin-left: 1%; margin-right: 1%; padding-top:2%;"><input id="product_id" value="${date}" style="margin-left: 7%; width: 102%;" type="text" class="form-control" disabled></td>`;
		//3
		tableHtml += `<td style="display:none;"><input id="product_id" value="${VoucherNo}" type="text" class="form-control" disabled></td>`;
		//4
		tableHtml += `<td style="display:none;"><input id="product_id" value="${v_type}" type="text" class="form-control" disabled></td>`;
		
		//5
		tableHtml += `<td style="margin-left: 1%; margin-right: 1%; padding-top:2%;"><input id="product_id" value="${HeadTitle}" style="margin-left: 22%; width: 154%;" type="text" class="form-control" disabled></td>`;
		//6
		tableHtml += `<td style="margin-left: 1%; margin-right: 1%; padding-top:2%;"><input id="product_id" value="${Narration}" style="margin-left: 88%; width: 104%;" type="text" class="form-control" disabled></td>`;
		//7
		tableHtml += `<td style="margin-left: 1%; margin-right: 1%; padding-top:2%;"><input id="product_id" value="${Amount}" style="margin-left: 105%; width: 103%;" type="text" class="form-control" disabled></td>`;
		//7
		tableHtml += '<td style="padding-top:2%;"><button class="btn btn-red" type="button" style="margin-left: 500%;"> <i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-trash" title="Delete Row"></i></button></td>';
		tableHtml += '</tr>';
		$('#myData').append(tableHtml);
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
		alertify.confirm("Are you sure you want to delete this Record?", function (e) {
		    if (e) {
				var TotalAmount = document.getElementById('TotalAmount').value;
		    	var CurrentValue = $(row).find("td:eq('6')").find('input').val();
		    	var grand = parseInt(TotalAmount) - parseInt(CurrentValue);
				document.getElementById('TotalAmount').value = grand;
		    	$(row).remove();
		        alertify.alert("Row is Removed!");
		    } else {
		        alertify.alert("Row Not Deleted!");
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
alertify.confirm("Are you sure you want update Cash Receipt Voucher?", function (e) {
	if (e)
	{
  var voucher = new Object();
  voucher.account_id = $("#account_id").val().split("_")[0];
  voucher.voucher_no = $("#voucher_no").val();
  voucher.voucher_date = $("#voucher_date").val();
  voucher.v_type = $("#v_type").val();
  voucher.biller = $("#biller").val();
	 
	
	var products = [];
	$.each($("#myData tr"), function(index, row){
		var columns = $(row).find("td");
		var product = new Object();
		// product.party_id = $("#party_id").val();
		product.head_id = $(columns[0]).find("input").val();
		product.date = $(columns[1]).find("input").val();
		product.voucher_no = $(columns[2]).find("input").val();
		product.v_type = $(columns[3]).find("input").val();
		product.narration = $(columns[5]).find("input").val();
		product.amount = $(columns[6]).find("input").val();
		products.push(product);
	});
	
	var $_token = jQuery('#token').val();
	jQuery.ajax({
		method: "PATCH",
		cache: false,
		headers: { 'X-XSRF-TOKEN' : $_token },
		data: {voucher: JSON.stringify(voucher), product_data:products},
		//url: "/cash-receipts",
		url: "/cash-receipts/<?php echo $edit->id ?>",
		
		success: function(result) {
			if(parseInt(result) > 0)
			//if(parseInt(result) > 0)
			{
				//window.open("/sales/print/"+result);
				window.location.href = "/cash-receipts";
				//alert("Cash Receipt successfully saved.");
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
</script>
@stop