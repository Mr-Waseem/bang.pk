@extends("app")
@section("contents")
<h1 class="page-title">Add Client</h1>
<div class="container-fluid">
				@if (Session::has('flash_message'))
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="margin-right: 20px;margin-top: 15px;">&times;</button>
					<div class="alert alert-success"> {{ Session::get('flash_message') }} </div>
				@endif
			</div>
			<!-- Breadcrumb -->
			<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
				<li><a href="/client">Client</a></li> 
				<li class="active"><strong>Add Client</strong></li> 
			</ol>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">Add Client</h3>
							<!-- <ul class="panel-tool-options"> 
								<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
								<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
								<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
							</ul> -->
						</div>
						<div class="panel-body">
							@include('errors.validation')
							{!! Form::open(['url' => 'clients', 'class' => 'form-horizontal', 'files' => true ]) !!}
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Name</label>  
									<div class="col-sm-5"> 
									{!! Form::text('name', null, ['id' => 'name','class'=>'form-control',]) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Logo</label>  
									<div class="col-sm-5"> 
								{!! Form::file('logo', ['id' => 'logoInput','class'=>'form-control']) !!}
								</div> 
							</div>
							<div class="form-group" id="logoPreviewGroup" style="display:none;"> 
								<label class="col-sm-3 control-label">Preview</label>  
								<div class="col-sm-5"> 
									<img id="logoPreview" src="" style="max-height:100px; max-width:200px;">
							<div class="line-dashed"></div>
							<center><div class="form-actions">
						  <button type="submit" class="btn btn-primary">Save</button>
						</div></center>
						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
<script>
	document.getElementById('logoInput').addEventListener('change', function(e) {
		const file = e.target.files[0];
		if (file) {
			const reader = new FileReader();
			reader.onload = function(event) {
				document.getElementById('logoPreview').src = event.target.result;
				document.getElementById('logoPreviewGroup').style.display = 'block';
			};
			reader.readAsDataURL(file);
		}
	});
</script>
@stop