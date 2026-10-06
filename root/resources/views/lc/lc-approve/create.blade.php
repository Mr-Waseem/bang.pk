@extends("app")
@section("contents")
<!-- <body onload="AddRowFunction()"> -->
<body>
<div class="container-fluid">
@if (Session::has('flash_message'))
	 <div class="alert alert-success alert-dismissible fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right: 4%;">&times;</a>
			<strong>Success!</strong> {{ Session::get('flash_message') }}
		</div>
@endif
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading clearfix" id="panelbg">
				<h2 class="panel-title"><b>Add Approve Information</b></h2>

			</div>
		<div class="panel-body">
			<input id="token" type="hidden" value="{{$encrypted_token}}">
			@include('errors.validation')
			{!! Form::open(['url' => 'lc-approved', 'class' => 'form-horizontal' ]) !!}
			<input type="hidden" name="biller_id" id="biller_id" value="{{Auth::User()->id}}">
			<input type="hidden" name="status" id="status" value="APPROVED">
				<div class="row">
					<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
					<label class="col-sm-1 control-label">Voucher#</label>  
					<div class="col-sm-2"> 
						<div id="year-view" class="input-group date"> 
							{!! Form::text('voucher_no', $codes, ['id' => 'voucher_no','class'=>'form-control', 'required' => 'required', 'autofocus'=>'autofocus']) !!} 
						</div>
					</div>
					<div class="col-sm-2">
					</div>
					<label class="col-sm-3 control-label">Party Code#</label>  
					<div class="col-sm-4"> 
						{!! Form::text('party_id', null, ['id' => 'party_id','class'=>'form-control', 'required' => 'required']) !!} 
					</div> 							
					</div>
				</div>
				<div class="form-group" style="margin-left: 0px;"> 
					<label class="col-sm-1 control-label">V.Date</label>  
					<div class="col-sm-2"> 
						<div id="year-view" class="input-group date"> 
							<input id="voucher_date" type="date" name="voucher_date" value="<?php echo date('Y-m-d');?>" class="form-control"> 
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</div>
					</div>
					<div class="col-sm-4">	
					</div>
					 <label class="col-sm-1 control-label">Party&nbsp;Name</label>
					<div class="col-sm-4" style="margin-left: -12px;"> 
						{!! Form::select('party_name', $customers, null, ['id' => 'party_name',  'onchange' => 'javascript:PartyKeyUp($(this).val());','class'=>'form-control livesearch', 'required' => 'required']) !!}
					</div>  
				</div>
				<div class="row">
					<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
						<label class="col-sm-1 control-label">LC.NO</label>
						<div class="col-sm-2"> 
							{!! Form::text('lc_no', null, ['id' => 'lc_no',  'class'=>'form-control', 'required' => 'required']) !!} 
						</div>  
						<div class="col-sm-2">
							{!! Form::text('indentor_no', null, ['id' => 'indentor_no','class'=>'form-control', 'placeholder' => 'Indentor No']) !!}
						</div> 
						<div class="col-sm-2">
						</div>
						 <label class="col-sm-1 control-label">Address</label> 
						<div class="col-sm-4">
							{!! Form::text('address', null, ['id' => 'address','class'=>'form-control', 'placeholder' => 'Address', 'disabled' => 'disabled']) !!} 
						</div>							
					</div>
				</div>
				<div class="row">
					<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
						<label class="col-sm-1 control-label">LC.Date</label>
						<div class="col-sm-2"> 
							<input id="lc_date" type="date" name="lc_date" value="<?php echo date('Y-m-d');?>" class="form-control">
						</div>  
						<div class="col-sm-2">
							{!! Form::select('lc_type', array('Sight' => 'Sight', 'FATR' => 'FATR','DA' => 'DA','ADV By TT' => 'ADV By TT',), null, ['id' => 'lc_type','class'=>'form-control livesearch', 'placeholder' => 'Select Type', 'required' => 'required']) !!}
						</div> 
						<div class="col-sm-2">
							
						</div>
						 <label class="col-sm-1 control-label">Indentor</label> 
						<div class="col-sm-4">
							 
							{!! Form::select('indentor_id', $indentor, null, ['id' => 'indentor_id', 'class'=>'form-control livesearch', 'required' => 'required'])!!}
						</div>							
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
						<label class="col-sm-1 control-label">Bank&nbsp;Name</label>
						<div class="col-sm-4"> 
								{!! Form::select('bank_id', $banks, null, ['id' => 'bank_id', 'class'=>'form-control livesearch'])!!}
						</div>
						<div class="col-sm-2"> 
							
						</div> 
						<label class="col-sm-1 control-label">ETD</label>
						<div class="col-sm-2"> 
							<!-- {!! Form::date('etd', null, ['id' => 'etd',  'class'=>'form-control', 'required' => 'required']) !!} -->
							<input id="etd" type="date" name="etd" value="<?php echo date('Y-m-d');?>" class="form-control" required> 
						</div> 
						<!-- <label class="col-sm-1 control-label">Address</label> --> 
						<div class="col-sm-2">
							<input id="eta" type="date" name="eta" value="<?php echo date('Y-m-d');?>" class="form-control" required> 
							
						</div> 		

					</div>
				</div>
				<div class="row">
					<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
						<label class="col-sm-1 control-label">Currency</label>
						<div class="col-sm-2"> 
							{!! Form::select('currency', array('POUND' => 'POUND', '$DOLLAR' => '$DOLLAR','EURO' => 'EURO'), null, ['id' => 'currency','class'=>'form-control livesearch', 'placeholder' => 'Select Currency']) !!} 
						</div> 
						<!-- <label class="col-sm-1 control-label">Address</label> --> 
						<div class="col-sm-2">
							{!! Form::text('conversion_rate', null, ['id' => 'conversion_rate', 'onkeyup' => 'CurrencyKeyup($(this).val())', 'class'=>'form-control', 'placeholder' => 'Conversion Rate']) !!}
						</div> 
						<div class="col-sm-2">
							
						</div>
						 <label class="col-sm-1 control-label">Maturity&nbsp;Date</label>
						<div class="col-sm-2"> 
							<!-- {!! Form::date('etd', null, ['id' => 'etd',  'class'=>'form-control', 'required' => 'required']) !!} -->
							<input id="maturity_date" type="date" name="maturity_date" value="<?php echo date('Y-m-d');?>" class="form-control" required> 
						</div> 
						<!-- <label class="col-sm-1 control-label">Address</label> --> 
						<div class="col-sm-2">
							{!! Form::text('tracking_no', null, ['id' => 'tracking_no','class'=>'form-control', 'placeholder' => 'Tracking No']) !!} 
							
						</div>							
					</div>
				</div>
				 <div class="row">
					<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
						<label class="col-sm-1 control-label">Destination</label>
						<div class="col-sm-4"> 
								{!! Form::text('destination', null, ['id' => 'destination', 'class'=>'form-control'])!!}
						</div> 		

					</div>
				</div>
				<div class="row">
					<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
						<label class="col-sm-1 control-label">Origin</label>
						<div class="col-sm-4"> 
								{!! Form::text('origin', null, ['id' => 'origin', 'class'=>'form-control'])!!}
						</div> 		

					</div>
				</div>
				<!-- <div class="row">
					<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
						{!! Form::hidden('party_id', 1, ['id' => 'party_id', 'class'=>'form-control']) !!} 
						<label class="col-sm-1 control-label">Account</label>
						<div class="col-sm-2"> 
								{!! Form::select('party_name', $customers, null, ['id' => 'party_name',  'onchange' => 'javascript:PartyKeyUp($(this).val());','class'=>'form-control livesearch', 'required' => 'required']) !!} 
						</div> 
						<label class="col-sm-1 control-label">Address</label>
						<div class="col-sm-3">
							{!! Form::text('address', null, ['id' => 'address','class'=>'form-control', 'placeholder' => 'Address', 'disabled' => 'disabled', 'placeholder' => 'Walking Costomer']) !!}
						</div> 
						<label class="col-sm-1 control-label">NTN</label> 
						<div class="col-sm-2">
							{!! Form::text('city', null, ['id' => 'city','class'=>'form-control', 'placeholder' => 'City', 'disabled' => 'disabled']) !!} 
						</div>							
					</div>
				</div> -->	
<div class="panel panel-default">
 <div class="panel-body">	
  <div class="form-group">
   <table  id="myTable">
	<div class="container-fluid">
	 <div class="row">
	<tr> 							
<!-- <div class="col-md-3"> 
	<div class="form-group"> 
		<label for="H.S" class="control-label">Id</label> -->
		{!! Form::hidden('product_id', null, ['id' => 'product_id','class'=>'form-control']) !!}
	<!-- </div>
</div>  -->
<div class="col-md-1" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="H.S" class="control-label">Code</label>
		{!! Form::text('product_code', null, ['id' => 'product_code', 'onkeyup' => 'CodeKeyUp($(this).val());', 'class'=>'form-control']) !!}
	</div>
</div> 
<div class="col-md-2" style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="Name" class="control-label">Product Name</label> 
		{!! Form::select('product_name', $products, null, ['id' => 'product_name',  'onchange' => 'ProductKeyUp($(this).val().split("_")[0]);','class'=>'form-control livesearch']) !!}
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
		<label for="password" class="control-label">QTY in M.T</label> 
		<!-- <input type="checkbox" id="checkbox7" checked="checked"> -->
		{!! Form::text('qty_mt', null, ['id' => 'qty_mt', 'onkeyup' => 'qtyMtKeyUp($(this).val())', 'class'=>'form-control']) !!}
	</div> 
</div>
<div class="col-md-1"style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Qty in KG</label> 
		{!! Form::text('qty_kg', 1, ['id' => 'qty_kg', 'onkeyup' => 'QtykgKeyUp($(this).val())', 'class'=>'form-control']) !!}
	</div> 
</div>
<div class="col-md-1" style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Rate in US $</label> 
		{!! Form::text('us_rate', null, ['id' => 'us_rate', 'onkeyup' => 'usRateKeyUp($(this).val())', 'class'=>'form-control']) !!}
	</div> 
</div>
<div class="col-md-1"style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Rate in RS</label> 
		{!! Form::text('rs_rate', null, ['id' => 'rs_rate', 'onkeyup' => 'rsRateKeyUp($(this).val())','class'=>'form-control']) !!}
	</div> 
</div>
<div class="col-md-1"style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Total Amount $</label> 
		{!! Form::text('us_amount', null, ['id' => 'us_amount',  'class'=>'form-control']) !!}
	</div> 
</div>
<div class="col-md-1"style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Total&nbsp;Amount&nbsp;Rs</label> 
		{!! Form::text('rs_amount', null, ['id' => 'rs_amount', 'onkeyup' => 'AddGridData()', 'class'=>'form-control']) !!}
	</div> 
</div>
</tr></br>
<div id="myData">
</div>
</div>
</div>
	</table></br></br>
	 </div>
	  </div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<div class="panel-heading clearfix" id="panelbg">
			  		<div class="col-sm-3">
				  	 	<label class="radio-inline"><input type="checkbox" name="autocash" id="autocash" value="yes" checked>Bank&nbsp;effect</label>
				  	</div>
				  	<div class="col-sm-3">
				  	 		<b>Total</b><input type="text" id="TotalRateus" name="TotalRateus" value="0" disabled	> 
				  	</div>
				  	<div class="col-sm-2" style="float: left;margin-left: -9%;"> 
				  		<input type="text" id="TotalAmountus" name="TotalAmountus" value="0" disabled> 
				  </div>
				  <div class="col-lg-3" style="float: left;margin-left: 5%;"> 
				  	<b>Total</b><input type="text" id="TotalRaters" name="TotalRaters" value="0" disabled	> 
				  </div>
				  <div class="col-lg-2" style="float: left;margin-left: -9%;"> 
				  	<input type="text" id="TotalAmountrs" name="TotalAmountrs" value="0" disabled> 
				  </div>
			</div>
		</div>		
	</div></br>
			<div class="row">
			<div class="col-sm-12">
				<div class="panel-heading clearfix" id="panelbg">
			  		<div class="col-sm-3">
				  	 	<!-- <label class="radio-inline"><input type="checkbox" name="autocash" id="autocash" value="yes">Bank&nbsp;effect</label> -->
				  	</div>
				  	<div class="col-sm-3">
				  	 		<!-- <b>Total</b><input type="text" id="TotalRateus" name="TotalRateus" value="0" disabled	> --> 
				  	</div>
				  	<div class="col-sm-2" style="float: left;margin-left: -9%;"> 
				  		<!-- <input type="text" id="TotalAmountus" name="TotalAmountus" value="0" disabled>  -->
				  </div>
				  <div class="col-lg-3" style="float: left;margin-left: 3.6%;"> 
				  	<b>Margin</b><input type="text" onkeyup="marginkeyup($(this).val());" id="LCmargin" name="LCmargin" value="0"> 
				  </div>
				  <div class="col-lg-2" style="float: left;margin-left: -7.6%;"> 
				  	<input type="text" id="MarginAmount" name="MarginAmount" value="0"> 
				  </div>
			</div>
		</div>		
	</div></br>
	<center><div class="form-actions">
			  <button type="submit" class="btn btn-primary" id="btnSaveS" name="btnSaveS">Save</button>
			</div></center>			
			{!! Form::close() !!}		
		
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
<script type="text/javascript">

	// function CurrencyKeyup(CurrencyRate)
	// {
	// 	document.getElementById('us_rate').value = CurrencyRate;
	// }

	function marginkeyup(margin){

		var totalAmountrs = document.getElementById('TotalAmountrs').value;
		var totallcMargin = margin/100* totalAmountrs;
		document.getElementById('MarginAmount').value = parseInt(totallcMargin);
	}


	function TotalRecords() {
		var rowCount = document.getElementById('myTable').rows.length;
		alert("Total Number of Records Are: " + rowCount);
	}


	// on javascript onclick on product dropdown 
	function ProductKeyUp(productID){
		//alert(productID)
		$.ajax({
			type: "GET",
			url: "/productkeyup-ajax?prodID=" + productID,
			success: function(result) {
				if(result.length > 0)
				{
					$('#product_code').val(result[0].product_code);
					$('#product_id').val(result[0].id);
					$("#product_cost").val(result[0].unit_cost);
					//$("#product_cost").val(result[0].product_cost);
					$("#price_per_unit").val(result[0].product_price);

					var price = $("#price_per_unit").val();
					var quantity = $("#quantity").val();
					var cost = $("#product_cost").val();
					var CostAmount= cost * quantity;
					var SaleAmount = price * quantity;
					var totalDiscount = ((discountnew/100)*quantity*price);
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



		function qtyMtKeyUp(qty){
			var totalkg = qty*1000;
			document.getElementById('qty_kg').value = parseInt(totalkg);

			var usrate = document.getElementById('us_rate').value;
			
			var Currencyrate = document.getElementById('conversion_rate').value;
			var total = qty*usrate;
			
			document.getElementById('us_amount').value = parseInt(total);
			var totalRsRate = usrate*Currencyrate;
			document.getElementById('rs_rate').value = parseInt(totalRsRate);

			var rsrate = document.getElementById('rs_rate').value;
			var totalRsAmount = qty*rsrate;
			document.getElementById('rs_amount').value = parseInt(totalRsAmount);
		}

		function usRateKeyUp(usrate){
			var Currencyrate = document.getElementById('conversion_rate').value;
			var totalRsRate = usrate*Currencyrate;
			document.getElementById('rs_rate').value = parseInt(totalRsRate);


			var qty = document.getElementById('qty_mt').value;
			var total = qty*usrate;
			document.getElementById('us_amount').value = parseInt(total);

			var rsrate = document.getElementById('rs_rate').value;
			var totalRsAmount = qty*rsrate;
			document.getElementById('rs_amount').value = parseInt(totalRsAmount);
		}


		function QtykgKeyUp(quantity){
			var totalmt = quantity/1000;
			document.getElementById('qty_mt').value = parseInt(totalmt);
		}

		

		// function rsRateKeyUp(rate){
		// 	var qtykg = document.getElementById('qty_kg').value;
		// 	var TotalRsAmount = qtykg*rate;
		// 	document.getElementById('rs_amount').value = TotalRsAmount;
		// }


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
					$('#city').val(result[0].city);
				}
			}
		})
	}


		function myDeleteFunction(row) {
		alertify.confirm("Are you sure you want to delete this row?", function (e) {
		    if (e) {
		    	 var TotalRateus = document.getElementById('TotalRateus').value;
		    	 var TotalAmountus= document.getElementById('TotalAmountus').value;
		    	 var TotalRaters = document.getElementById('TotalRaters').value;
		    	 var TotalAmountrs = document.getElementById('TotalAmountrs').value;
				var Rateus = $(row).find("td:eq('5')").find("input").val();
				var Amountus = $(row).find("td:eq('6')").find("input").val();
				var Raters = $(row).find("td:eq('9')").find("input").val();
				var Amountrs = $(row).find("td:eq('10')").find("input").val();
				var grandRateus = parseInt(TotalRateus) - parseInt(Rateus);
				var grandAmountus = parseInt(TotalAmountus) - parseInt(Amountus);
				var grandRaters = parseInt(TotalRaters) - parseInt(Raters);
				var grandAmountrs = parseInt(TotalAmountrs) - parseInt(Amountrs);
				document.getElementById('TotalRateus').value = grandRateus;
				document.getElementById('TotalAmountus').value = grandAmountus;
				document.getElementById('TotalRaters').value = grandRaters;
				document.getElementById('TotalAmountrs').value = grandAmountrs;
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

	function AddGridData(){
		var ProductId = document.getElementById('product_id').value;
		var ProductCode = document.getElementById('product_code').value;
		var ProductName = document.getElementById('product_name').value.split("_").pop();
		var UOMID = document.getElementById('uom_id').value.split("_")[0];
		var UOM = document.getElementById('uom_id').value.split("_").pop();
		var Qtymt = document.getElementById('qty_mt').value;
		var Qtykg = document.getElementById('qty_kg').value;
		var USRate = document.getElementById('us_rate').value;
		var RSRate = document.getElementById('rs_rate').value;
		var USAmount = document.getElementById('us_amount').value;
		var RSAmount = document.getElementById('rs_amount').value;

		var Rateus = document.getElementById('TotalRateus').value;
		var Amountus = document.getElementById('TotalAmountus').value;
		var Raters = document.getElementById('TotalRaters').value;
		var Amountrs = document.getElementById('TotalAmountrs').value;

		var TotalRateus = parseInt(Qtymt) + parseInt(Rateus);
		var TotalAmountus = parseInt(Qtykg) + parseInt(Amountus);
		var TotalRaters = parseInt(USAmount) + parseInt(Raters);
		var TotalAmountrs = parseInt(RSAmount) + parseInt(Amountrs);

		document.getElementById('TotalRateus').value = TotalRateus;
		document.getElementById('TotalAmountus').value = TotalAmountus;
		document.getElementById('TotalRaters').value = TotalRaters;
		document.getElementById('TotalAmountrs').value = TotalAmountrs;
		var tableHtml = '<tr>';
		//0
		//tableHtml += '<td>'+ ProductId +'</td>';
		tableHtml += `<td style="display:none;"><input id="product_id" value="${ProductId}" name="product_id[]" type="text" class="form-control" disabled></td>`;
		//1
		//tableHtml += '<td>'+ ProductCode +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="product_code" value="${ProductCode}" name="product_code[]" type="text" class="form-control" style="margin-left: 7%; width: 80%;"></td>`;
    	//2
		//tableHtml += '<td>'+ ProductName +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="product_name" value="${ProductName}" name="product_name[]" type="text" class="form-control" style="margin-left: -4%;
    width: 157%;"></td>`;
    	//3
    tableHtml += `<td style="display:none;"><input id="uom_id" value="${UOMID}" name="uom_id[]" type="text" class="form-control" style="margin-left: -25%;
    width: 120%;"></td>`;
    	//4
    tableHtml += `<td style="padding-top:20px;"><input id="uom" value="${UOM}" name="uom[]" type="text" class="form-control" style="margin-left: 60%;
    width: 79%;" disabled></td>`;
    	//5
		//tableHtml += '<td>'+ Cost +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="qty_mt" value="${Qtymt}" name="qty_mt[]" type="text" class="form-control" style="margin-left: 48%; width: 78%;"></td>`;
		//6
		//tableHtml += '<td>'+ Quantity +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="qty_kg" value="${Qtykg}" name="qty_kg[]"  type="text" class="form-control" style="margin-left: 34%; width: 79%;"></td>`;
		//tableHtml += '<td>'+ CostAmount +'</td>';
		//7
		tableHtml += `<td style="padding-top:20px;"><input id="us_rate" value="${USRate}" name="us_rate[]" type="text" class="form-control" style="width:78%; margin-left: 21%;"></td>`;
		//8
		// tableHtml += `<td style="display:none;"><input id="rs_rate" value="${RSRate}" name="rs_rate[]" type="text" class="form-control" style="" disabled></td>`;
		//9
		tableHtml += `<td style="padding-top:20px;"><input id="rs_rate" value="${RSRate}" name="rs_rate[]" type="text" class="form-control" style="margin-left: 8%;
    width: 79%;"></td>`;
    	//10
		// tableHtml += '<td>'+ Price +'</td>';
		 tableHtml += `<td style="padding-top:20px;"><input id="us_amount" value="${USAmount}" name="us_amount[]" type="text" class="form-control" style="margin-left:-5%; width: 78%;"></td>`;
		 //11
		 tableHtml += `<td style="padding-top:20px;"><input id="rs_amount" value="${RSAmount}" name="rs_amount[]" type="text" class="form-control" style="margin-left: -19%;
    width: 78%;"></td>`;
		// document.getElementById('test').value=Price;
		// tableHtml += '<td>'+ Amount +'</td>';
		//12
		tableHtml += '<td><button class="btn btn-red" type="button" style="margin-left: -80%;"> <i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-trash" title="Delete Row"></i></button></td>';
		tableHtml += '</tr></br>';
		$('#myData').append(tableHtml);
		document.getElementById("product_code").focus();
	}
</script>
@stop