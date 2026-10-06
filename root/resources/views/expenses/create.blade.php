@extends("app")
@section("contents")
<div class="container-fluid">
	@if (Session::has('flash_message'))
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="margin-right: 20px;margin-top: 15px;">&times;</button>
		<div class="alert alert-success"> {{ Session::get('flash_message') }} </div>
	@endif
</div>
<h1 class="page-title">Add Expense</h1>
			<!-- Breadcrumb -->
			<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
				<li><a href="/expenses">Expenses</a></li> 
				<li class="active"><strong>Add Expense</strong></li> 
			</ol>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">Add Expense</h3>
							<ul class="panel-tool-options"> 
								<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
								<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
								<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
							</ul>
						</div>
						<div class="panel-body">
							@include('errors.validation')
							{!! Form::open(['url' => 'expenses', 'class' => 'form-horizontal' ]) !!}
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Date</label>  
									<div class="col-sm-5"> 
									<div id="year-view" class="input-group date"> 
										<input id="date" type="date" name="date" value="<?php echo date('d/m/Y');?>" class="form-control"> 
										<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
									</div>
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Expense Head</label>  
									<div class="col-sm-5"> 
									{!! Form::select('expensehead_id', $expenseHeads, null, ['id' => 'expensehead_id','class'=>'form-control livesearch']) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Expense</label>  
									<div class="col-sm-5"> 
									{!! Form::text('expense', null, ['id' => 'expense','class'=>'form-control',]) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Descripton</label>  
									<div class="col-sm-5"> 
									{!! Form::text('description', null, ['id' => 'description','class'=>'form-control',]) !!}
									</div> 
								</div>
								
								<div class="line-dashed"></div>
								<center><div class="form-actions">
							  <button type="submit" class="btn btn-primary">Save</button>
							</div></center>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
@stop