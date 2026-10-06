@extends("app")
@section("contents")
<h1 class="page-title">Add PhoneBook</h1>
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
				<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
				<li><a href="/phonebook"> PhoneBook Information</a></li> 
				<li class="active"><strong>Add PhoneBook</strong></li> 
			</ol>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">Add PhoneBook</h3>
							<!-- <ul class="panel-tool-options"> 
								<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
								<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
								<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
							</ul> -->
						</div>
						<div class="panel-body">
							@include('errors.validation')
							{!! Form::open(['url' => 'phonebook', 'class' => 'form-horizontal' ]) !!}
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Date</label>  
									<div class="col-sm-5"> 
									<!-- {!! Form::date('date', null, ['id' => 'date','class'=>'form-control',]) !!} -->
									<input id="date" type="date" name="date" value="<?php echo date('Y-m-d');?>" class="form-control">
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Name</label>  
									<div class="col-sm-5"> 
									{!! Form::text('name', null, ['id' => 'name','class'=>'form-control', '']) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Phone</label>  
									<div class="col-sm-5"> 
									{!! Form::text('phone', null, ['id' => 'phone','class'=>'form-control',]) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Email</label>  
									<div class="col-sm-5"> 
									{!! Form::text('email', null, ['id' => 'email','class'=>'form-control',]) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Type</label>  
									<div class="col-sm-5"> 
									{!! Form::text('type', null, ['id' => 'type','class'=>'form-control',]) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Address</label>  
									<div class="col-sm-5"> 
									{!! Form::text('address', null, ['id' => 'address','class'=>'form-control',]) !!}
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