@extends("app")
<head>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
</head>
@section("contents")
<h1 class="page-title">SalePoint Sale Report</h1>
			<!-- Breadcrumb -->
			<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
				<li class="active"><strong>SalePoint Sale Report</strong></li> 
			</ol>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">Select Date</h3>
						
						</div>
						<div class="panel-body">
						<input id="token" type="hidden" value="{{$encrypted_token}}">
							@include('errors.validation')
							{!! Form::open(['url' => 'sale-report', 'class' => 'form-horizontal' ]) !!}
								
								<div class="form-group"> 
									<label class="col-sm-3 control-label">From</label>  
									<div class="col-sm-5"> 
									<input type="date" name="from_date" id="from_date" value="<?php echo date("Y-m-d");?>" class="form-control">
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">To</label>  
									<div class="col-sm-5"> 

									<input type="date" name="to_date" id="to_date" value="<?php echo date("Y-m-d");?>" class="form-control">
									</div> 
								</div>


								<div class="row">
						<div class="form-group" style="margin-left: 1%; margin-right: 1%;">
						 <label class="col-sm-1 control-label"></label>
							<div class="col-sm-2"> 
								<div id="year-view" class="input-group date"> 
									
								</div>
							</div>
							<label class="radio-inline"><input type="radio" name="sale_report" id="sale_report" value="1" checked><b>BILL WISE</b></label>&nbsp;&nbsp;&nbsp;&nbsp;
							<label class="radio-inline"><input type="radio" name="sale_report" id="sale_report" value="2">CATEGORY WISE</label>		&nbsp;&nbsp;&nbsp;&nbsp;
							<!-- <label class="radio-inline"><input type="radio" name="sale_report" id="sale_report" value="3"><b>SALE COST</b></label>
							&nbsp;&nbsp;&nbsp;&nbsp;
							<label class="radio-inline"><input type="radio" name="sale_report" id="sale_report" value="4">CATEGORY WISE</label>	 -->	
						</div>
					</div>
					<div class="line-dashed"></div>
					<center><div class="form-actions">
				  <button type="submit" name="btnSave" id="btnSave" target="_blank" class="btn btn-primary">Find</button>
				</div></center>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>

@stop
@section("scripts")
<!-- Select2-->
<script src="/js/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript">
	$("#shop_id").select2();
	$("#shop_id").next(".select2").find(".select2-selection").focus(function() {
	$("#shop_id").select2("open");
	   });
</script>
@stop

