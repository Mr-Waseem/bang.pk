@extends("app")
@section("contents")
<h1 class="page-title">Ledger(Detail Wise)</h1><!-- <a href="bank-payments/create" class="btn btn-primary btn-sm btn-add" role="button">Add Bank Payment</a> -->
			<!-- Breadcrumb -->
			<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
				<li class="active"><strong>Ledger(Detail Wise)</strong></li> 
			</ol>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">Ledger(Detail Wise)</h3>
							<!-- <ul class="panel-tool-options"> 
								<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
								<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
								<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
							</ul> -->
						</div>
						<div class="panel-body">
						<input id="token" type="hidden" value="{{$encrypted_token}}">
							@include('errors.validation')
							{!! Form::open(['url' => 'ledger-detail-wise/report', 'class' => 'form-horizontal' ]) !!}
								
								<!-- <div class="form-group"> 
									<label class="col-sm-3 control-label">From</label>  
									<div class="col-sm-5"> 
									{!! Form::date('from_date', null, ['id' => 'from_date','class'=>'form-control', 'value' => "<?php echo date('m-d-Y') ?>", 'required' => 'required']) !!}
								
									</div> 
								</div> -->
								<div class="form-group"> 
									<label class="col-sm-3 control-label">From</label>  
									<div class="col-sm-5"> 
									<input type="date" name="from_date" id="from_date" value="<?php echo date("2020-01-01");?>" class="form-control">
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
									{!! Form::select('party_id', $parties, null, ['id' => 'party_id','class'=>'form-control livesearch', 'autofocus' => 'autofocus']) !!}
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

