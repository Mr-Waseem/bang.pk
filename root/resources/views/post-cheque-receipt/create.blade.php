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
<!-- <h1 class="page-title">Add Sale</h1>
<ol class="breadcrumb breadcrumb-2"> 
	<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
	<li><a href="/sales">Sales</a></li> 
	<li class="active"><strong>Add Sale</strong></li> 
</ol> -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading clearfix">
				<h2 class="panel-title"><b>Post Dated Cheque Voucher</b></h2>
				<!-- <ul class="panel-tool-options"> 
					<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
					<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
					<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
				</ul> -->
			</div>
		<div class="panel-body">
			<input id="token" type="hidden" value="{{$encrypted_token}}">
			@include('errors.validation')
			{!! Form::open(['url' => 'post-cheque-receipt', 'class' => 'form-horizontal' ]) !!}

				<div class="row">
				<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
					<label class="col-sm-1 control-label">Vr. No</label>  
					<div class="col-sm-2"> 
						<div id="year-view" class="input-group date"> 
							{!! Form::text('voucher_no', $codes,  ['id' => 'voucher_no','class'=>'form-control', 'disabled' => 'disabled']) !!} 
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
					{!! Form::text('v_type', "Post Dated Cheque", ['id' => 'v_type', 'class'=>'form-control']) !!}
					</div> 
				</div>
			</div>			
			<div class="row">
				<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
					<label class="col-sm-1 control-label">Debit&nbsp;Account</label>  
					<div class="col-sm-3" style="height: 40px;"> 
					{!! Form::select('account_id', $debitAccount, null, ['id' => 'account_id', 'class'=>'form-control livesearch']) !!}
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
			<div class="row" style="display:none;">
				<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
					<label class="col-sm-1 control-label">Biller</label>  
					<div class="col-sm-3" style="height: 40px;"> 
					{!! Form::text('status', "NotClear", ['id' => 'status', 'class'=>'form-control']) !!}
					</div> 
				</div>
			</div>
			

<div class="panel panel-default">
	<div class="panel-body">	
	<div class="form-group">
	<table  id="myTable">
		<div class="container-fluid">
		<div class="row">
		<tr> 							
	{!! Form::hidden('product_id', null, ['id' => 'product_id','class'=>'form-control']) !!}
<div class="col-md-2" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="H.S" class="control-label">Date</label>
		<input id="date" type="date" name="date" value="<?php echo date('Y-m-d');?>" class="form-control">
	</div>
</div> 
<div class="col-md-1" style="display:none;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Voucher&nbsp;No</label> 
		{!! Form::text('voucher_no', $codes, ['id' => 'voucher_no', 'class'=>'form-control']) !!}
	</div> 
</div>
<div class="col-md-1" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Cheque&nbsp;No</label> 
		{!! Form::text('cheque_no', null, ['id' => 'cheque_no', 'class'=>'form-control', 'autofocus'=>'autofocus']) !!}
	</div> 
</div>
<div class="col-md-2" style="display:none;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Type</label> 
		{!! Form::text('vchr_type', "Post Dated Cheque", ['id' => 'vchr_type', 'class'=>'form-control']) !!}
	</div> 
</div>
<div class="col-md-2" style="display:none;"> 
	<div class="form-group"> 
		<label for="status" class="control-label">Status</label> 
		{!! Form::text('status', "NotClear", ['id' => 'status', 'class'=>'form-control']) !!}
	</div> 
</div>
<div class="col-md-2" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="Name" class="control-label">Account&nbsp;Name</label> 
		{!! Form::select('account_head_id', $Accounts, null, ['id' => 'account_head_id', 'class'=>'form-control livesearch']) !!}
	</div> 
</div> 
<div class="col-md-1" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="Name" class="control-label">Bank&nbsp;Name</label> 
		{!! Form::select('bank_id', $banks, null, ['id' => 'bank_id', 'class'=>'form-control livesearch']) !!}
	</div> 
</div>
<div class="col-md-2" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Description</label> 
		{!! Form::text('narration', null, ['id' => 'narration', 'class'=>'form-control']) !!}
	</div> 
</div>
<!-- <div class="col-md-2"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Debit</label> 
		{!! Form::text('debit', 0, ['id' => 'debit', 'class'=>'form-control']) !!}
	</div> 
</div> -->
<div class="col-md-1" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Amount</label> 
		{!! Form::text('credit', null, ['id' => 'credit', 'class'=>'form-control']) !!}
	</div> 
</div>
<div class="col-md-1"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Add</label>
		
		 <button class="form-control" style="background: #e20707;" type="button" class="btn btn-red" onkeyup="AddGridData();">Add</button> 
		 <!-- <button type="button" onclick="AddGridData()" class="btn btn-red"><i class="fa fa-plus"></i> </button> -->
	</div> 
</div>
</tr>
</div>
</div>
	</table></br></br>
	</div>
	</div>
		</div>
			<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading clearfix">
						<h3 class="panel-title">Post Dated Cheque Grid</h3>
					</div>
					<div class="panel-body">
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead> 
									<tr> 
										<th>Dlt</th>  
										<th style="display:none;">Head&nbsp;ID</th>  
										<th>Date</th>  
										<th style="display:none;">Voucher&nbsp;No</th>
										<th>Cheque&nbsp;No</th> 
										<th style="display:none;">Type</th> 
										<th style="display:none;">Status</th> 
										<th>Account&nbsp;Name</th> 
										<th style="display:none;">BankID</th>
										<th>Bank</th>
										<th>Narration</th>
										<!-- <th>Debit</th> -->
										<th>Amount</th> 
									</tr> 
								</thead> 
								<tbody id="GridTable"> 
									<div class="row"> 
										<!-- <th scope="row">1</th> 
										<td>Mark</td> 
										<td>Otto</td> 
										<td>@mdo</td> 
										<td>Mark</td> 
										<td>Otto</td> 
										<td>@mdo</td> 
										<td>Mark</td> 
										<td>Otto</td> 
										<td>@mdo</td> 
										<td>Mark</td> 
										<td>Otto</td>  -->
									</div> 
								</tbody> 
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
			<center><div class="form-actions">
			  <button type="button" class="btn btn-primary" id="btnSave" name="btnSave">Save</button>
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
<script src="/js/plugins/jasny/jasny-bootstrap.min.js"></script>
<script src="/js/plugins/select2/select2.full.min.js"></script>
<script src="/js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<script src="/js/plugins/datepicker/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">
<script type="text/javascript">
function AddGridData(){
	var date = document.getElementById('date').value;
	var VoucherNo = document.getElementById('voucher_no').value;
	var ChequeNo = document.getElementById('cheque_no').value;
	var v_type = document.getElementById('vchr_type').value;
	var status = document.getElementById('status').value;
	var HeadTitle = document.getElementById('account_head_id').value.split("_").pop();
	var HeadId = document.getElementById('account_head_id').value.split("_")[0];
	var BankTitle = document.getElementById('bank_id').value.split("_").pop();
	var BankId = document.getElementById('bank_id').value.split("_")[0];
	var Narration = document.getElementById('narration').value;
	// var Debit = document.getElementById('debit').value;
	var Credit = document.getElementById('credit').value;
	var tableHtml = '<tr>';
	tableHtml += '<td class="text-center"><i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-cancel icon-larger red-color" title="Delete Row"></i> </td>';
	tableHtml += '<td style="display:none;">'+ HeadId +'</td>';
	tableHtml += '<td>'+ date +'</td>';
	tableHtml += '<td style="display:none;">'+ VoucherNo +'</td>';
	tableHtml += '<td>'+ ChequeNo +'</td>';
	tableHtml += '<td style="display:none;">'+ v_type +'</td>';
	tableHtml += '<td style="display:none;">'+ status +'</td>';
	tableHtml += '<td>'+ HeadTitle +'</td>';
	tableHtml += '<td style="display:none;">'+ BankId +'</td>';
	tableHtml += '<td>'+ BankTitle +'</td>';
	tableHtml += '<td>'+ Narration +'</td>';
	// tableHtml += '<td>'+ Debit +'</td>';
	tableHtml += '<td>'+ Credit +'</td>';
	tableHtml += '</tr>';
	$('#GridTable').append(tableHtml);
}

	// function TotalRecords() {
	// 	var rowCount = document.getElementById('myTable').rows.length;
	// 	alert("Total Number of Records Are: " + rowCount);
	// }

	// function PartyKeyUp(partyId){
	// 	$.ajax({
	// 		type: "GET",
	// 		url: "/partyonchange-ajax?party_id=" + partyId,
	// 		success:function(result)
	// 		{
	// 			if(result.length > 0){
	// 				$('#party_id').val(result[0].id);
	// 				$('#address').val(result[0].address);
	// 				$('#strn').val(result[0].strn);
	// 				$('#ntn').val(result[0].ntn);
	// 			}
	// 		}
	// 	})
	// }

	function myDeleteFunction(row) {
		if(confirm("Are you sure you want to delete this Record?"))
		{
			$(row).remove();
		}
	}

$("#btnSave").click(function()
{
	var voucher = new Object();
	voucher.voucher_no = $("#voucher_no").val();
  	voucher.voucher_date = $("#voucher_date").val();
  	voucher.account_id = $("#account_id").val().split("_")[0];
  	voucher.v_type = $("#v_type").val();
  	voucher.biller = $("#biller").val();
  	voucher.status = $("#status").val();
	 
	var products = [];
	$.each($("#GridTable tr"), function(index, row){
		var columns = $(row).find("td");
		var product = new Object();
		// product.party_id = $("#party_id").val();
		product.head_id = $(columns[1]).text();
		product.date = $(columns[2]).text();
		product.voucher_no = $(columns[3]).text();
		product.cheque_no = $(columns[4]).text();
		product.v_type = $(columns[5]).text();
		product.status = $(columns[6]).text();
		product.bank_id = $(columns[8]).text();
		product.narration = $(columns[10]).text();
		//product.debit = $(columns[7]).text();
		product.credit = $(columns[11]).text();
		products.push(product);
	});
	
	var $_token = jQuery('#token').val();
	jQuery.ajax({
		method: "POST",
		cache: false,
		headers: { 'X-XSRF-TOKEN' : $_token },
		data: {voucher: JSON.stringify(voucher), product_data:products},
		url: "/post-cheque-receipt",
		
		success: function(result) {
			if(result == "saved")
			//if(parseInt(result) > 0)
			{
				//window.open("/sales/print/"+result);
				window.location.href = "/post-cheque-receipt/create";
				alert("Cheque successfully saved.");
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
});

		// $('#date').datepicker({
		// 			startView: 0,
		// 			keyboardNavigation: false,
		// 			forceParse: false,
		// 			format: "dd/mm/yyyy"
		// 		});



</script>
@stop