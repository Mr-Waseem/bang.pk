@extends("app")
<head>
  <link href="{{Asset('css/select2.min.css')}}" rel="stylesheet" />

</head>
@section("contents")
<h1 class="page-title">Companies Report</h1><!-- <a href="bank-payments/create" class="btn btn-primary btn-sm btn-add" role="button">Add Bank Payment</a> -->
			<!-- Breadcrumb -->
			<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
				<li class="active"><strong>Companies Report</strong></li> 
			</ol>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">Companies Report</h3>
							<!-- <ul class="panel-tool-options"> 
								<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
								<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
								<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
							</ul> -->
						</div>
						<div class="panel-body">
						
							@include('errors.validation')
							{!! Form::open(['url' => 'admin-company-report', 'class' => 'form-horizontal' ]) !!}
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Select Partner</label>  
									<div class="col-sm-5"> 
									{!! Form::select('partner_id', $partners, null, ['id' => 'partner_id','class'=>'form-control']) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Select Type</label>  
									<div class="col-sm-5"> 
									{!! Form::select('type', ['0' => 'All','Monthly' => 'Monthly', 'Annual' => 'Annual'], null, ['id' => 'type','class'=>'form-control']) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">From</label>  
									<div class="col-sm-5"> 
									<input type="date" name="from_date" id="from_date" value="<?php echo date("2020-07-01");?>" class="form-control" autofocus>
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
                            <label class="radio-inline"><input type="radio" name="report_type" id="report_type" value="1"
                                    checked><b>Integrations</b></label>&nbsp;&nbsp;&nbsp;&nbsp;

                            <label class="radio-inline"><input type="radio" name="report_type" id="report_type"
                                    value="2"><b>Invoices</b></label>

                        </div>
                    </div>
                    <!-- <div class="line-dashed"></div> -->
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
	$("#partner_id").select2();
	$("#partner_id").next(".select2").find(".select2-selection").focus(function() {
	$("#partner_id").select2("open");
	   });

	$("#type").select2();
	$("#type").next(".select2").find(".select2-selection").focus(function() {
	$("#type").select2("open");
	   });
</script>
@stop
