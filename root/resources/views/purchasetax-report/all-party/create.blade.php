@extends("app")
@section("contents")
<h1 class="page-title">PurchaseTax Register</h1>
			<!-- Breadcrumb -->
			<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
				<li class="active"><strong>PurchaseTax Register</strong></li> 
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
						<input id="token" type="hidden" value="{{$encrypted_token}}">
							@include('errors.validation')
							{!! Form::open(['url' => 'purchasetax-report\all-party', 'class' => 'form-horizontal' ]) !!}
								<!-- <div class="form-group"> 
									<label class="col-sm-3 control-label">Select Party/Customer</label>  
									<div class="col-sm-5"> 
									{!! Form::select('party_name', $parties, null, ['id' => 'party_name','class'=>'form-control livesearch', 'required' => 'required']) !!}
									</div> 
								</div> -->
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
									<!-- {!! Form::date('to_date', null, ['id' => 'to_date','class'=>'form-control',]) !!} -->
									<input type="date" name="to_date" id="to_date" value="<?php echo date("Y-m-d");?>" class="form-control">
									</div> 
								</div>
								<div class="row">
                        <div class="form-group" style="margin-left: 1%; margin-right: 1%;"> <label
                                class="col-sm-1 control-label"></label>
                            <div class="col-sm-2">
                                <div id="year-view" class="input-group date"></div>
                            </div>
                            <label class="radio-inline"><input type="radio" name="ReportDetail" id="ReportDetail"
                                    value="1" checked>Detail</label>
                            <label class="radio-inline"><input type="radio" name="ReportDetail" id="ReportDetail"
                                    value="2">Summary</label>
                                    <!-- <label class="radio-inline"><input type="radio" name="ReportDetail" id="ReportDetail"
                                        value="3">Excel Report</label> -->
                        </div>
                    </div>
                    <div class="line-dashed"></div>
								<center><div class="form-actions">
							  <button type="submit" target="_blank" class="btn btn-primary">Find</button>
							</div></center>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>

@stop

