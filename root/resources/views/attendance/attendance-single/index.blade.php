@extends("app")
<head>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

</head>
@section("contents")
<h1 class="page-title">ShopWise Attendance Report</h1>
			<!-- <ol class="breadcrumb breadcrumb-2"> 
				<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
				<li class="active"><strong>Ledger All Customers</strong></li> 
			</ol>
 -->			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">ShopWise Attendance Report</h3>

						</div>
						<div class="panel-body">
					
							@include('errors.validation')
							{!! Form::open(['url' => 'attendance-single', 'class' => 'form-horizontal' ]) !!}
						
								<div class="form-group"> 
						<label class="col-sm-3 control-label">Select Shop</label>  
						<div class="col-sm-5"> 
						{!! Form::select('shop_id', $shops, null, ['id' => 'shop_id','class'=>'form-control', 'autofocus' => 'autofocus']) !!}
						</div> 
					</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Date</label>  
									<div class="col-sm-5"> 
									<input type="date" name="from_date" id="from_date" value="<?php echo date("Y-m-d");?>" class="form-control" autofocus>
									</div> 
								</div>

								<!-- <div class="form-group"> 
									<label class="col-sm-3 control-label">To</label>  
									<div class="col-sm-5"> 
									{!! Form::date('to_date', null, ['id' => 'to_date','class'=>'form-control', 'required' => 'required']) !!}
									</div> 
								</div> -->
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
