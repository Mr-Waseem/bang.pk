@extends("app")
<head>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

</head>
@section("contents")
<h1 class="page-title">Salary Report</h1><!-- <a href="bank-payments/create" class="btn btn-primary btn-sm btn-add" role="button">Add Bank Payment</a> -->
			<!-- Breadcrumb -->
<ol class="breadcrumb breadcrumb-2"> 
	<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
	<li class="active"><strong>Salary Report</strong></li> 
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
			<div class="panel-body">
			
				@include('errors.validation')
				{!! Form::open(['url' => 'attendance-report', 'class' => 'form-horizontal' ]) !!}
					
					
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
						<label class="col-sm-3 control-label">Select Account</label>  
						<div class="col-sm-5"> 
						{!! Form::select('employee_id', $users, null, ['id' => 'employee_id','class'=>'form-control']) !!}
						</div> 
					</div>
					<!-- <div class="row">
						<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> <label class="col-sm-1 control-label"></label>
							<div class="col-sm-2"> 
								<div id="year-view" class="input-group date"> 
									
								</div>
							</div>
							<label class="radio-inline"><input type="radio" name="ReportDetail" id="ReportDetail" value="1" checked>Summary</label>
							<label class="radio-inline"><input type="radio" name="ReportDetail" id="ReportDetail" value="2">Detail</label>						
						</div>
					</div> -->
					<div class="line-dashed"></div>
					<center><div class="form-actions">
				  <button type="submit" class="btn btn-primary">Find</button>
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
	$("#head_id").select2();
	$("#head_id").next(".select2").find(".select2-selection").focus(function() {
	$("#head_id").select2("open");
	   });
</script>
@stop
