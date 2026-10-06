@extends("app")
@section("contents")
<h1 class="page-title" style="color: white">Edit Appointment</h1>
			<!-- Breadcrumb -->
			<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="{{ asset('dashboard') }}"><i class="fa fa-home"></i>Home</a></li> 
				<li><a href="{{ asset('appointments') }}">Appointment</a></li> 
				<li class="active"><strong>Edit Appointment</strong></li> 
			</ol>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">Edit Appointment</h3>
							<!-- <ul class="panel-tool-options"> 
								<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
								<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
								<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
							</ul> -->
						</div>
						<div class="panel-body">
							@include('errors.validation')
{!! Form::model($edit, ['method' => 'PATCH', 'action' => ['App\Http\Controllers\AppointmentController@update', $edit->id], 'class' => 'form-horizontal', 'id' => 'productsForm', 'files' => 'true', 'enctype' => 'multipart/form-data' ]) !!}
								<div class="form-group"> 
					<label class="col-sm-3 control-label">Appointment No</label>  
					<div class="col-sm-5"> 
					{!! Form::text('voucher_no', null, ['id' => 'voucher_no', 'class'=>'form-control', 'autofocus' => 'autofocus']) !!}
					</div> 
				</div>
				<div class="form-group"> 
					<label class="col-sm-3 control-label">Date</label>  
					<div class="col-sm-5"> 
					<!-- <input id="date" type="date" name="date" class="form-control" value="<?php echo date('d/m/Y');?>"> -->

					{!! Form::date('date', null, ['id' => 'date', 'class'=>'form-control']) !!}
					</div> 
				</div>
				<div class="form-group"> 
					<label class="col-sm-3 control-label">Select Employee</label>  
					<div class="col-sm-5"> 
					{!! Form::select('employee_id', $employess, null, ['id' => 'employee_id', 'class'=>'form-control']) !!}
					</div> 
				</div>
				<div class="form-group"> 
					<label class="col-sm-3 control-label">Designation (Use Capital Words)</label>  
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
			  <button type="submit" onkeydown="submitForm();" class="btn btn-primary">Save Phase</button>
			</div></center>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
@stop
@section("scripts")
<script type="text/javascript">
function submitForm(){
	$( "#productsForm" ).submit();
}
</script>
@stop