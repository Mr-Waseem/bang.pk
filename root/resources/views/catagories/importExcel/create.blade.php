@extends("app")
@section("contents")
<div class="container-fluid">
				@if (Session::has('flash_message'))
					 <div class="alert alert-success alert-dismissible fade in">
			 			<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right: 4%;">&times;</a>
			 			<strong>Success!</strong> {{ Session::get('flash_message') }}
			  		</div>
				@endif
			</div>
<h1 class="page-title">Import Catagories</h1>
			<!-- Breadcrumb -->
			<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="{{asset('/dashboard')}}"><i class="fa fa-home"></i>Home</a></li> 
				<li><a href="{{asset('/catagories')}}">Catagories</a></li> 
				<li class="active"><strong>Add Catagory</strong></li> 
			</ol>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">Upload File</h3>
							<ul class="panel-tool-options"> 
								<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
								<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
								<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
							</ul>
						</div>
						<div class="panel-body">
							@include('errors.validation')
							{!! Form::open(['url' => 'catagories/importExcel', 'class' => 'form-horizontal', 'files' => 'true', 'enctype' => 'multipart/form-data' ]) !!}

								<div class="form-group"> 
									<label class="col-sm-3 control-label">Upload&nbsp;File</label>
									<div class="col-sm-5"> 
									{!! Form::file('import_file', null, ['id' => 'import_file','class'=>'form-control',]) !!}
									</div> 
								</div>
								<input type="hidden" value="{{ csrf_token() }}" name="_token" />
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