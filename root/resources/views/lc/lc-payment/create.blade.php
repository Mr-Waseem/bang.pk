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
				<h2 class="panel-title"><b>LC Payment Voucher</b></h2>
			</div>
		<div class="panel-body">
			<input id="token" type="hidden" value="{{$encrypted_token}}">
			@include('errors.validation')
			{!! Form::open(['url' => 'lc-payment', 'class' => 'form-horizontal' ]) !!}
			<input type="hidden" name="biller_id" id="biller_id" value="{{ Auth::user()->id }}">
			<div class="row">
				<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
					<label class="col-sm-1 control-label">Vr. No</label>  
					<div class="col-sm-2"> 
						<div id="year-view" class="input-group date"> 
							{!! Form::text('voucher_no', $codes,  ['id' => 'voucher_no','class'=>'form-control']) !!} 
						</div>
					</div>						
				</div>
			</div>
			<div class="row">
				<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
					<label class="col-sm-1 control-label">Vr. Date</label>  
					<div class="col-sm-2"> 
						<div id="year-view" class="input-group date"> 
							<input id="voucher_date" type="date" name="voucher_date" value="<?php echo date('Y-m-d');?>" class="form-control" autofocus>
							<!-- <span class="input-group-addon"><i class="fa fa-calendar"></i></span>  -->
						</div>
					</div>					
				</div>
			</div>
			<div class="row" style="display: none;">
				<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
					<label class="col-sm-1 control-label">Voucher Type</label>  
					<div class="col-sm-5" style="height: 40px;"> 
					{!! Form::text('v_type', "LC Expense", ['id' => 'v_type', 'class'=>'form-control']) !!}
					</div> 
				</div>
			</div>			
			<div class="row">
				<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
					<label class="col-sm-1 control-label">Cash&nbsp;Account</label>  
					<div class="col-sm-3" style="height: 40px;"> 
					{!! Form::select('cash_account_id', $cashAccount, null, ['id' => 'cash_account_id', 'class'=>'form-control livesearch']) !!}
					</div> 
				</div>
			</div>
			<!-- <div class="row">
				<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
					<label class="col-sm-1 control-label">LC&nbsp;No</label>  
					<div class="col-sm-3" style="height: 40px;"> 
					{!! Form::select('lc_id', $lcNo, null, ['id' => 'lc_id', 'class'=>'form-control livesearch']) !!}
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
<div class="col-md-1" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="H.S" class="control-label">Party Code</label>
		<input id="party_code" type="text" name="party_code" value="123456" class="form-control">
	</div>
</div> 

<div class="col-md-2" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="Name" class="control-label">LC&nbsp;No</label>
		{!! Form::select('lc_id', $lcNo, null, ['id' => 'lc_id', 'class'=>'form-control livesearch']) !!}
	</div> 
</div> 

<div class="col-md-2" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="Name" class="control-label">Party&nbsp;/&nbsp;Customer</label>
		{!! Form::select('account_head_id', $Accounts, null, ['id' => 'account_head_id', 'class'=>'form-control livesearch']) !!}
	</div> 
</div> 
<div class="col-md-2" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Description</label> 
		{!! Form::text('narration', "CASH RECIEVED", ['id' => 'narration', 'class'=>'form-control']) !!}
	</div> 
</div>
<div class="col-md-2" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Amount</label> 
		{!! Form::text('amount', null, ['id' => 'amount', 'class'=>'form-control']) !!}
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
<div class="col-lg-12">
	<div class="panel panel-default">
		<div class="panel-heading clearfix" id="panelbg">
			<div class="container">
			  <div class="col-lg-5">  </div>
			  <!-- <div class="col-xs-3">  </div> -->
			  <!-- <div class="col-xs-3"> <b>Total Rate</b> <input type="text" id="TotalRate" name="TotalRate" value="" disabled	></div> -->
			  <div class="col-lg-3"> <b>Total&nbsp;Amount</b> <input type="text" id="TotalAmount" name="TotalAmount" value="0" disabled> </div>
			</div> 
		</div>

	</div>
</div>
</div>
			<center><div class="form-actions">
			  <button type="submit" class="btn btn-primary" id="btnSaves" name="btnSaves">Save</button>
			</div></center>		
			<div class="col-lg-3">
				<!-- <button type="button" onclick="AddRowFunction()" class="btn btn-success"><i class="fa fa-plus"></i> </button> -->
				<!-- <button type="button" onclick="AddGridData()" class="btn btn-success"><i class="fa fa-plus"></i> </button>
				<button type="button" onclick="TotalRecords()" class="btn btn-success">Total Records</button> -->
			</div>			
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">
<script type="text/javascript">

	function AddGridData(){
		if($("#amount").val() =="" || $("#account_head_id").val() ==""){
	  	alert('Account Name or Amount Value Cant be Empty!');
	  	document.getElementById("amount").focus();
         e.preventdefault();
	  }
		var PartyCode = document.getElementById('party_code').value;
		var VoucherNo = document.getElementById('voucher_no').value;
		var v_type = document.getElementById('v_type').value;
		var LCTitle = document.getElementById('lc_id').value.split("_").pop();
		var LCId = document.getElementById('lc_id').value.split("_")[0];
		var HeadTitle = document.getElementById('account_head_id').value.split("_").pop();
		var HeadId = document.getElementById('account_head_id').value.split("_")[0];

		var Narration = document.getElementById('narration').value;
		var Amount = document.getElementById('amount').value;
		var total = document.getElementById('TotalAmount').value;
		var grand = parseInt(Amount) + parseInt(total);
		document.getElementById('TotalAmount').value = grand;
		// var Credit = document.getElementById('credit').value;

		var tableHtml = '<tr>';
		//0
		tableHtml += `<td><input id="party_code" value="${PartyCode}" name="party_code[]" type="text" class="form-control" style="margin-left: 7%; width: 59%;"></td>`;
		//1
		tableHtml += `<td style="display:none;"><input id="lc_id" value="${LCId}" name="lc_id[]" type="text" class="form-control" style="margin-left: 7%; width: 118%;"></td>`;
		//2
		tableHtml += `<td style="padding-top:20px;"><input id="lc_title" value="${LCTitle}" name="lc_title[]" type="text" class="form-control" style="margin-left: -20%; width: 120%;"></td>`;
		//1
		tableHtml += `<td style="display:none;"><input id="account_id" value="${HeadId}" name="account_id[]" type="text" class="form-control" style="margin-left: 7%; width: 118%;"></td>`;
		//2
		tableHtml += `<td style="padding-top:20px;"><input id="account_title" value="${HeadTitle}" name="account_title[]" type="text" class="form-control" style="margin-left: 14%; width: 119%;"></td>`;
    	//3
		tableHtml += `<td style="padding-top:20px;"><input id="desc" value="${Narration}" name="desc[]" type="text" class="form-control" style="margin-left: 48%;width: 119%;"></td>`;
    	//4
    	tableHtml += `<td style="padding-top:20px;"><input id="payment" value="${Amount}" name="payment[]" type="text" class="form-control" style="margin-left: 80%; width: 120%;"></td>`;

		tableHtml += '<td><button class="btn btn-red" type="button" style="margin-left: 460%;"> <i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-trash" title="Delete Row"></i></button></td>';
		tableHtml += '</tr></br>';
		$('#myData').append(tableHtml);
	}


	function myDeleteFunction(row) {
		alertify.confirm("Are you sure you want to delete this Record?", function (e) {
		    if (e) {
			var total = document.getElementById('TotalAmount').value;
			var amount = $(row).find("td:eq('6')").find("input").val();
			var grand = parseInt(total) - parseInt(amount);
			document.getElementById('TotalAmount').value = grand;
			$(row).remove();
		} else {
		        alertify.alert("Row Not Deleted!");
		    }
		});
	}
</script>
@stop