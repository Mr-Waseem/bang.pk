@extends("app")
<head>
  <link href="{{Asset('css/select2.min.css')}}" rel="stylesheet" />

</head>
@section("contents")
<h1 class="page-title">Stock Report</h1><!-- <a href="bank-payments/create" class="btn btn-primary btn-sm btn-add" role="button">Add Bank Payment</a> -->
			<!-- Breadcrumb -->
			<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
				<li class="active"><strong>Stock Report</strong></li> 
			</ol>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">Stock Report</h3>
							<!-- <ul class="panel-tool-options"> 
								<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
								<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
								<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
							</ul> -->
						</div>
						<div class="panel-body">
						
							@include('errors.validation')
							{!! Form::open(['url' => 'raw-material', 'class' => 'form-horizontal' ]) !!}
							
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Select Item</label>  
									<div class="col-sm-5"> 
									{!! Form::select('product_id', $products, null, ['id' => 'product_id','class'=>'form-control']) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">From</label>  
									<div class="col-sm-5"> 
									<input type="date" name="from_date" id="from_date" value="<?php echo date("Y-m-d");?>" class="form-control" autofocus>
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">To</label>  
									<div class="col-sm-5"> 
									<input type="date" name="to_date" id="to_date" value="<?php echo date("Y-m-d");?>" class="form-control">
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Report Type</label>  
									<div class="col-sm-5"> 
										<div class="radio">
											<label><input type="radio" name="report_type" value="product_wise" checked> Product Wise </label>
										</div>
										<div class="radio">
											<label><input type="radio" name="report_type" value="hs_code_wise"> HS Code Wise</label>
										</div>
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
<script src="{{Asset('js/plugins/select2/select2.full.min.js')}}"></script>
<script type="text/javascript">
	$("#product_id").select2();
	$("#product_id").next(".select2").find(".select2-selection").focus(function() {
	$("#product_id").select2("open");
	   });
</script>
@stop
