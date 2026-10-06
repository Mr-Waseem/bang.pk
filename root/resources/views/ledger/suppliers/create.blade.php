@extends("app")
@section("contents")
<h1 class="page-title">Add Purchase Ledger</h1>
<div class="container-fluid">
				@if (Session::has('flash_message'))
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="margin-right: 20px;margin-top: 15px;">&times;</button>
					<div class="alert alert-success"> {{ Session::get('flash_message') }} </div>
				@endif
			</div>
			<!-- Breadcrumb -->
			<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
				<li><a href="/ledger/supplier">Purchase Ledger</a></li> 
				<li class="active"><strong>Add Purchase Ledger</strong></li> 
			</ol>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">Add Purchase Ledger</h3>
							<ul class="panel-tool-options"> 
								<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
								<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
								<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
							</ul>
						</div>
						<div class="panel-body">
							@include('errors.validation')
							{!! Form::open(['url' => 'ledger/suppliers', 'class' => 'form-horizontal' ]) !!}
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Date</label>  
									<div class="col-sm-3"> 
										<div id="year-view" class="input-group date"> 
											<input id="date" type="text" name="date" value="<?php echo date('d-m-Y');?>" class="form-control"> 
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
										</div>
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Party Name</label>  
									<div class="col-sm-5"> 
									{!! Form::select('supplier_id', $suppliers, null, ['id' => 'supplier_id','class'=>'form-control livesearch', 'allow_single_deselect'=>'true']) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Particulars</label>  
									<div class="col-sm-5"> 
									{!! Form::textarea('particulars', null, ['id' => 'particulars', 'rows' => '3', 'class'=>'form-control']) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Bill No</label>  
									<div class="col-sm-5"> 
									{!! Form::text('bill_no', null, ['id' => 'bill_no','class'=>'form-control']) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Debit</label>  
									<div class="col-sm-5"> 
									{!! Form::text('debit', null, ['id' => 'address','class'=>'form-control',]) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Credit</label>  
									<div class="col-sm-5"> 
									{!! Form::text('credit', null, ['id' => 'credit','class'=>'form-control',]) !!}
									</div> 
								</div>
								<div class="line-dashed"></div>
								<center><div class="form-actions">
							  <button type="submit" class="btn btn-primary">Save Ledger</button>
							</div></center>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
@stop