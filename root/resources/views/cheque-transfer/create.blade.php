@extends("app")
<head>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

</head>
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
			<h2 class="panel-title"><b>Cheque Transfer Voucher</b></h2>
			<!-- <ul class="panel-tool-options"> 
				<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
				<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
				<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
			</ul> -->
		</div>
		<div class="panel-body">
			<input id="token" type="hidden" value="{{$encrypted_token}}">
			@include('errors.validation')
			{!! Form::open(['url' => 'cheque-transfer', 'class' => 'form-horizontal' ]) !!}

				<div class="row">
				<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
					<label class="col-sm-1 control-label">Vr. No</label>  
					<div class="col-sm-2"> 
						<div id="year-view" class="input-group date"> 
							{!! Form::text('voucher_no', $codes,  ['id' => 'voucher_no','class'=>'form-control', 'autofocus'=>'autofocus', 'disabled' => 'disabled']) !!} 
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
					{!! Form::text('v_type', "Cheque Transfer", ['id' => 'v_type', 'class'=>'form-control']) !!}
					</div> 
				</div>
			</div>			
			<div class="row">
				<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
					<label class="col-sm-1 control-label">Transfer&nbsp;From</label>  
					<div class="col-sm-3" style="height: 40px;"> 
					{!! Form::select('from_id', $Heads, null, ['id' => 'from_id', 'class'=>'form-control']) !!}
					</div> 
				</div>
			</div>
			<div class="row">
				<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
					<label class="col-sm-1 control-label">Transfer&nbsp;To</label>  
					<div class="col-sm-3" style="height: 40px;"> 
					{!! Form::select('to_id', $Heads, null, ['id' => 'to_id', 'class'=>'form-control']) !!}
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

			<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover dataTables-example" >
					<thead>
						<tr>
							<th>Serial#</th>
						    <th>Vr.No</th>
							<th>Acc.ID</th>
							<th>Account</th>
							<th>Bank</th>
							<th>Description</th>
							<th>Cheque.No</th>
							<th>Date</th>
							<th>Amount</th>
						    <th>Actions</th>
						</tr>
					</thead>
					 <tbody id="myData">
		  <?php $sum = 1; ?>
		  @if(count($cheques) > 0)
		   @foreach($cheques as $chequesDet)
		   @if($chequesDet->status=="NotClear")
		  <tr>
		  <td><?php echo $sum; ?></td>
		  
		  <td class="center">{{$chequesDet->voucher_no}}</td>
		  <td class="center">{{$chequesDet->party->id}}</td>
		  <td class="center">{{$chequesDet->party->party_name}}</td>
		  <td class="center" style="display:none;">{{$chequesDet->banks->id}}</td>
		  <td class="center">{{$chequesDet->banks->name}}</td>
		  <td class="center">{{$chequesDet->narration}}</td>
		  <td class="center">{{$chequesDet->cheque_no}}</td>
		  <td class="center">{{date("d/m/Y", strtotime($chequesDet->date))}}</td>
		  <td class="center">{{$chequesDet->credit}}</td>
		  <td class="center"><input type="checkbox" name="checkedValue" id="checkedValue" value="yes"></td>
		  <td style="display: none;" class="center">{{$chequesDet->id}}</td>
		  <td style="display: none;" class="center">{{$chequesDet->post_dated->id}}</td>
			<?php $sum = $sum + 1;?>
		  </tr>
		  @endif
		  @endforeach
		  @else
		  <tr>
		  	<td colspan="10" class="center" style="color:red;"><center>No Data Found!</center></td>
		  </tr>
		  @endif


		  </tbody>
				<tfoot>
					<tr>
						<th>Serial #</th>
					    <th>Vr.No</th>
						<th>Code</th>
						<th>Account</th>
						<th>Bank</th>
						<th>Description</th>
						<th>Cheque No</th>
						<th>Date</th>
						<th>Amount</th>
					    <th>Actions</th>
					</tr>
				</tfoot>
				</table>
			</div>
		</div>
			<center><div class="form-actions">
			  <button type="button" class="btn btn-primary" id="btnSave" name="btnSave">Transfer</button>
			</div></center>				
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
<script src="/js/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript">
	$("#from_id").select2();
	$("#from_id").next(".select2").find(".select2-selection").focus(function() {
	$("#from_id").select2("open");
	   });

	$("#to_id").select2();
	$("#to_id").next(".select2").find(".select2-selection").focus(function() {
	$("#to_id").select2("open");
	   });
</script>
<script type="text/javascript">
$("#btnSave").click(function()
{
	var voucher = new Object();
	voucher.voucher_no = $("#voucher_no").val();
  	voucher.voucher_date = $("#voucher_date").val();
  	voucher.account_from_id = $("#from_id").val().split("_")[0];
  	voucher.account_id = $("#to_id").val().split("_")[0];
  	voucher.v_type = $("#v_type").val();
  	voucher.biller = $("#biller").val();
  	//voucher.cheque_id = $("#biller").val();
	 
	var products = [];
	$.each($("#myData tr"), function(index, row){
		var columns = $(row).find("td");
		var product = new Object();
		//product.party_id = $("#party_id").val();
		product.voucher_no = $(columns[1]).text();
		product.head_id = $(columns[2]).text();
		product.bank_id = $(columns[4]).text();
		product.narration = $(columns[6]).text();
		product.cheque_no = $(columns[7]).text();
		product.date = $(columns[8]).text();
		product.v_type = "Post Dated Cheque";
		product.amount = $(columns[9]).text();
		// product.checkedValue = $(columns[10]).find("input").val();
		product.checkedValue = $(columns[10]).find("input").is(":checked");
		product.cheque_id = $(columns[11]).text();
		product.postdated_id = $(columns[12]).text();
		products.push(product);
	});
	
	var $_token = jQuery('#token').val();
	jQuery.ajax({
		method: "POST",
		cache: false,
		headers: { 'X-XSRF-TOKEN' : $_token },
		data: {voucher: JSON.stringify(voucher),product_data:products},
		url: "/cheque-transfer",
		
		success: function(result) {
			//if(result == "saved")
			if(parseInt(result) > 0)
			{
				//window.open("/sales/print/"+result);
				window.location.href = "/cheque-transfer/create";
				alert("Cheque successfully transferred!.");
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
</script>
@stop