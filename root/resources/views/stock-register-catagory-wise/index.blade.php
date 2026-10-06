@extends("app")
@section("contents")
<h1 class="page-title">Stock Register (Catagory Wise)</h1><!-- <a href="bank-payments/create" class="btn btn-primary btn-sm btn-add" role="button">Add Bank Payment</a> -->
			<!-- Breadcrumb -->
<ol class="breadcrumb breadcrumb-2"> 
	<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
	<li class="active"><strong>Catagory Wise</strong></li> 
</ol>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading clearfix">
				<h3 class="panel-title">Stock Register (Catagory Wise)</h3>
			</div>
			<div class="panel-body">
			<input id="token" type="hidden" value="{{$encrypted_token}}">
				@include('errors.validation')
				{!! Form::open(['url' => 'stock-register-catagory-wise', 'class' => 'form-horizontal' ]) !!}
					<div class="form-group"> 
						<label class="col-sm-3 control-label">Select Catagory</label>  
						<div class="col-sm-5"> 
						{!! Form::select('catagory_id', $catagories, null, ['id' => 'catagory_id','class'=>'form-control livesearch']) !!}
						</div> 
					</div>
					<!-- <div class="form-group"> 
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

