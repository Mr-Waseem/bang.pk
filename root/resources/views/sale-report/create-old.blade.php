@extends("app")
@section("contents")
<!-- <h1 class="page-title">Sale Report</h1> -->
<!-- Breadcrumb -->
<!-- <ol class="breadcrumb breadcrumb-2"> 
	<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
	<li class="active"><strong>Sale Report</strong></li> 
</ol> -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading clearfix">
				<h3 class="panel-title">Sale Report</h3>
				<!-- <ul class="panel-tool-options"> 
					<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
					<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
					<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
				</ul> -->
			</div>
			<div class="panel-body">
			<input id="token" type="hidden" value="{{$encrypted_token}}">
				@include('errors.validation')
				{!! Form::open(['url' => 'sale-report', 'class' => 'form-horizontal' ]) !!}
					<div class="form-group"> 
						<label class="col-sm-3 control-label">From</label>  
						<div class="col-sm-5"> 
						<!-- {!! Form::date('from_date', null, ['id' => 'from_date','class'=>'form-control',]) !!} -->
						<input type="date" name="from_date" id="from_date" value="<?php echo date("Y-m-d");?>" class="form-control">
						</div> 
					</div>
					<div class="form-group"> 
						<label class="col-sm-3 control-label">To</label>  
						<div class="col-sm-5"> 
						<input type="date" name="to_date" id="to_date" value="<?php echo date("Y-m-d");?>" class="form-control">
						</div> 
					</div>
					<div class="line-dashed"></div>
					<center><div class="form-actions">
				  <button type="submit" class="btn btn-primary">Find</button>
				</div></center>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading clearfix">
				<h3 class="panel-title">Sale Report ({{$shop[0]->name}})</h3>
			</div>
			<div class="panel panel-default">
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTables-example" >
						<thead>
							<tr>	
							  <th>Date</th>
							  <th>BILL NO</th>
							  <th>Product Name</th>
							  <th>Quantity</th>
							  <th>Sale Price</th>
							  <th>Total Sale</th>
							</tr>
						</thead>
						 <tbody>
						 <?php $SaleRate = 0; $quantity = 0; $SaleRatetotal = 0; ?>
@if(isset($sales))
 @if(count($sales) > 0)
	@foreach($sales as $sale)	
	@foreach($sale->sale_details as $products)	
			<tr>					
			<td>{{ date("d/m/Y", strtotime($sale->date)) }}</td>
			<td>{{$sale->invoice_no}}</td>
			<!-- <td>{{$sale->invoice_no}}</td> -->
			<td>@if($products->products != "")
			{{ $products->products->product_name }} ({{ $products->products->product_code }})
			@endif</td>
			<td>{{ $products->quantity }}</td>
			<td>{{ $products->sale_rate }}</td>
			<td>{{ $products->sale_amount }}</td>
			<?php
			$SaleRate = $SaleRate + (int)$products->sale_rate;
			$quantity = $quantity + (int)$products->quantity;
			$SaleRatetotal = $SaleRatetotal + (int)$products->sale_amount;
			?>
			</tr>
			@endforeach	
	@endforeach
	<tr>
	<td colspan="3"><center><b>Total</b></center></td>
	
	<td><b>{{number_format((int)$quantity)}}</b></td>
	<td><b>{{number_format((int)$SaleRate)}}</b></td>
	<td><b>{{number_format((int)$SaleRatetotal)}}</b></td>
	</tr>
							 
	 @else
		<tr><td colspan="7" style="color:#FF0000;text-align:center;">No purchases found</td></tr>
	 @endif
	 @endif
	 </tbody>
</table>
	</div>
</div>
</div>
</div>
</div>
</div>
@stop

@section("scripts")
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css" type="text/css" />
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
$("#btnSave").click(function()
{
	debugger;
	var purchase = new Object();
	purchase.from_date = $("#from_date").val();
	purchase.to_date = $("#to_date").val();
	
	var $_token = jQuery('#token').val();
	jQuery.ajax({
		method: "POST",
		cache: false,
		headers: { 'X-XSRF-TOKEN' : $_token },
		data: {purchase: JSON.stringify(purchase)},
		url: "/purchase-report",
		
		success: function(result) {
			if(result == "inserted")
			{
				alert("Sale successfully saved.");
				//Session::flash('flash_message', 'Sale Added Successfully!');
				window.location.href = "/sales";
				
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
