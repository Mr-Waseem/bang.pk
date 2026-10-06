@extends("app")
@section('contents')
<head>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css"
        type="text/css" />
</head>
@section("contents")
<div class="container-fluid">
	@if (Session::has('error_message'))
		<div class="alert alert-danger alert-dismissible fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close"
				style="margin-right: 4%;">&times;</a>
			<strong>Error!</strong> {{ Session::get('error_message') }}
		</div>
	@endif
</div>
<h1 class="page-title">Product Report</h1><!-- <a href="bank-payments/create" class="btn btn-primary btn-sm btn-add" role="button">Add Bank Payment</a> -->
			<!-- Breadcrumb -->
<ol class="breadcrumb breadcrumb-2"> 
	<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
	<li class="active"><strong>Product Report</strong></li> 
</ol>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading clearfix">
				<h3 class="panel-title">Select Date</h3>
				<!-- <ul class="panel-tool-options"> 
					<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
					<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
					<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
				</ul> -->
			</div>
			{{-- @if (Session::has('error_message'))
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true"
				style="margin-right: 20px;margin-top: 15px;">&times;</button>
			<div class="alert alert-danger"> {{ Session::get('error_message') }} </div>
		@endif --}}
			<div class="panel-body">
				@include('errors.validation')
				{!! Form::open(['url' => 'product-report/print', 'class' => 'form-horizontal' ]) !!}
					<div class="form-group">
						 
						<label class="col-sm-3 control-label">Select Product</label>  
						<div class="col-sm-5"> 
						{!! Form::select('product_id', $products, null, ['id' => 'product_id','class'=>'form-control', 'autofocus' => 'autofocus']) !!}
						</div> 
					</div>
					<div class="form-group">
						 
						<label class="col-sm-3 control-label">Sale&nbsp;Type</label>
						<div class="col-sm-5">
							<select  class="form-control"  id="sale_type" name="sale_type">
								<option  value=0>SalesTax Invoice</option>
								<option  value=1>Debit Note</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Report Type</label>
						<div class="col-sm-5">
							<label class="radio-inline" style="margin-right:15px;"><input type="radio" name="report_type" value="detailed" checked> Detailed</label>
							<label class="radio-inline"><input type="radio" name="report_type" value="summary"> Summary</label>
						</div>
					</div>
					<div class="form-group"> 
									<label class="col-sm-3 control-label">From</label>  
									<div class="col-sm-5"> 
									 {{-- {!! Form::date('from_date', null, ['id' => 'from_date','class'=>'form-control',]) !!} --}}
									<input type="date" name="from_date" id="from_date" value="<?php echo date('Y-m-d');?>" class="form-control" autofocus>
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">To</label>  
									<div class="col-sm-5"> 
									 {{-- {!! Form::date('to_date', null, ['id' => 'to_date','class'=>'form-control',]) !!} --}}
									<input type="date" name="to_date" id="to_date" value="<?php echo date('Y-m-d');?>" class="form-control">
									</div> 
								</div>

					
					<div class="row">
						<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> <label class="col-sm-1 control-label"></label>
							<div class="col-sm-2"> 
								<div id="year-view" class="input-group date"> 
									
								</div>
							</div>
							<!-- <label class="radio-inline"><input type="radio" name="ReportDetail" id="ReportDetail" value="1" checked>Summary</label>
							<label class="radio-inline"><input type="radio" name="ReportDetail" id="ReportDetail" value="2">Detail</label> -->

							{{-- <label class="radio-inline"><input type="radio" name="ReportDetail" id="ReportDetail" value="1" checked><b>READY STOCK DETAIL</b></label>&nbsp;&nbsp;&nbsp;&nbsp; --}}
							{{-- <label class="radio-inline"><input type="radio" name="ReportDetail" id="ReportDetail" value="2"><b>CONSUMED STOCK DETAIL</b></label>					 --}}
						</div>
					</div>
					<div class="line-dashed"></div>
					<center><div class="form-actions">
				  <button type="submit" class="btn btn-primary" >Find</button>
				</div></center>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

@stop
@section("scripts")
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    <!-- Select2-->
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <script>
        $("#product_id").select2();
        $("#product_id").next(".select2").find(".select2-selection").focus(function() {
        $("#product_id").select2("open");
        });
		  $("#sale_type").select2();
        $("#sale_type").next(".select2").find(".select2-selection").focus(function() {
        $("#sale_types").select2("open");
        });
    </script>
@stop
