@extends("app")
@section("contents")
<div class="container-fluid">
	@if (Session::has('flash_message'))
	<div class="alert alert-success alert-dismissible fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right: 4%;">&times;</a>
		<strong><i class="fa fa-check-circle"></i> Success!</strong> {{ Session::get('flash_message') }}
	</div>
	@endif

	@if (Session::has('flash_success'))
	<div class="alert alert-success alert-dismissible fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right: 4%;">&times;</a>
		<strong><i class="fa fa-check-circle"></i> Partial Success!</strong> {{ Session::get('flash_success') }}
	</div>
	@endif

	@if (Session::has('flash_error'))
	<div class="alert alert-danger alert-dismissible fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right: 4%;">&times;</a>
		<strong><i class="fa fa-exclamation-triangle"></i> Error!</strong> {{ Session::get('flash_error') }}
	</div>
	@endif

	@if (Session::has('flash_errors') && count(Session::get('flash_errors')) > 0)
	<div class="alert alert-warning alert-dismissible fade in">
		<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right: 4%;">&times;</a>
		<strong><i class="fa fa-exclamation-circle"></i> Import Errors:</strong>
		<ul style="margin-top: 10px; margin-bottom: 0;">
			@foreach(Session::get('flash_errors') as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	@endif
</div>
<h1 class="page-title">Import Products</h1>
<!-- Breadcrumb -->
<ol class="breadcrumb breadcrumb-2">
	<li><a href="{{asset('/dashboard')}}"><i class="fa fa-home"></i>Home</a></li>
	<li><a href="{{asset('/products')}}">Products</a></li>
	<li class="active"><strong>Add Product</strong></li>
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
				<!-- Instructions Panel -->
				<div class="alert alert-info" style="border-left: 4px solid #31708f;">
					<h4 style="margin-top: 0;"><i class="fa fa-info-circle"></i> <strong>Important Instructions</strong></h4>
					<ul style="margin-bottom: 0; padding-left: 20px;">
						<li><strong>HS Code Validation:</strong> Every product must have a valid HS Code that exists in the system. Invalid HS codes will result in import errors for those rows.</li>
						<li><strong>Product Name Uniqueness:</strong> Product names must be unique within your company. Duplicate product names will be skipped.</li>
						<li><strong>Partial Import Support:</strong> If some rows fail validation, valid rows will still be imported. You'll see a detailed error report for failed rows.</li>
						<li><strong>FBR Compliance:</strong> Ensure that Product Units align with FBR regulations.</li>
						<li><strong>Excel Format:</strong> Download the sample format below to ensure your Excel file has the correct structure.</li>
					</ul>
				</div>

				@include('errors.validation')
				{!! Form::open(['url' => 'products/import-excel', 'class' => 'form-horizontal', 'files' => 'true', 'enctype' => 'multipart/form-data' ]) !!}

				<div class="form-group">
					<label class="col-sm-3 control-label">Upload&nbsp;File</label>
					<div class="col-sm-5">
						{!! Form::file('import_file', null, ['id' => 'import_file','class'=>'form-control',]) !!}
					</div>
				</div>
				<input type="hidden" value="{{ csrf_token() }}" name="_token" />
				<div class="line-dashed"></div>
				<center>
					<div class="form-actions">
						<a href="{{asset('root/upload/product-sample.xlsx')}}" style="color:white;"><button type="button" class="btn btn-success"><i class="fa fa-download"></i> Download Format</button></a>
						<button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Upload File</button>
					</div>
				</center>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
@stop