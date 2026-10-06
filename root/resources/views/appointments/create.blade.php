@extends("app")
<head>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
</head>
@section("contents")
<h1 class="page-title" style="color: white">Create Appointment</h1>
<div class="container-fluid">
@if (Session::has('flash_message'))
	 <div class="alert alert-success alert-dismissible fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right: 4%;">&times;</a>
			<strong>Success!</strong> {{ Session::get('flash_message') }}
		</div>
@endif
</div>
<!-- Breadcrumb -->
<ol class="breadcrumb breadcrumb-2"> 
<li><a href="{{ asset('dashboard') }}"><i class="fa fa-home"></i>Home</a></li> 
<li><a href="{{ asset('appointments') }}">Appointment</a></li> 
<li class="active"><strong>Create Appointment</strong></li> 
</ol>
<div class="row">
<div class="col-lg-12">
	<div class="panel panel-default">
		<div class="panel-heading clearfix">
			<h3 class="panel-title">Create Appointment</h3>
		</div>
		<div class="panel-body">
			@include('errors.validation')
			{!! Form::open(['url' => 'appointments', 'class' => 'form-horizontal', 'id' => 'productsForm', 'files' => 'true', 'enctype' => 'multipart/form-data']) !!}
				<div class="form-group"> 
					<label class="col-sm-3 control-label">Appointment No</label>  
					<div class="col-sm-5"> 
					{!! Form::text('voucher_no', $codes, ['id' => 'voucher_no', 'class'=>'form-control', 'autofocus' => 'autofocus']) !!}
					</div> 
				</div>
				<div class="form-group"> 
					<label class="col-sm-3 control-label">Date</label>  
					<div class="col-sm-5"> 
					<!-- <input id="date" type="date" name="date" class="form-control" value="<?php echo date('d/m/Y');?>"> -->

					<input id="date" type="date" name="date" value="<?php echo date('Y-m-d');?>" class="form-control">
					</div> 
				</div>
				<div class="form-group"> 
					<label class="col-sm-3 control-label">Select Employee</label>  
					<div class="col-sm-5"> 
					{!! Form::select('employee_id', $employess, null, ['id' => 'employee_id', 'class'=>'form-control']) !!}
					</div> 
				</div>
				<div class="form-group"> 
					<label class="col-sm-3 control-label">Type</label>  
					<div class="col-sm-5"> 
					{!! Form::text('type', null, ['id' => 'type', 'class'=>'form-control']) !!}
					</div> 
				</div>
				<div class="form-group"> 
					<label class="col-sm-3 control-label">Image</label>  
					<div class="col-sm-5"> 
					{{-- {!! Form::file('image', null, ['id' => 'image', 'class'=>'form-control']) !!} --}}
						<input type="file" name="image" id="image" class="form-control">
				</div> 
				</div>
				<div class="form-group"> 
					<label class="col-sm-3 control-label">ID Front</label>  
					<div class="col-sm-5"> 
					{{-- {!! Form::file('id_front', null, ['id' => 'id_front', 'class'=>'form-control']) !!} --}}
					<input type="file" name="id_front" id="id_front" class="form-control">
					</div> 
				</div>
				<div class="form-group"> 
					<label class="col-sm-3 control-label">ID Back</label>  
					<div class="col-sm-5"> 
					{{-- {!! Form::file('id_back', null, ['id' => 'id_back', 'class'=>'form-control']) !!} --}}
					<input type="file" name="id_back" id="id_back" class="form-control">
					</div> 
				</div>
				
				<div class="line-dashed"></div>
				<center><div class="form-actions">
			  <button type="submit" onkeydown="submitForm();" class="btn btn-primary">Save</button>
			</div></center>
			{!! Form::close() !!}
		</div>
	</div>
</div>
</div>
@stop
@section("scripts")
<script src="/js/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript">

function submitForm(){
	$( "#productsForm" ).submit();
}

	 $("#employee_id").select2();
       $("#employee_id").next(".select2").find(".select2-selection").focus(function() {
       $("#employee_id").select2("open");
   });
</script>
@stop