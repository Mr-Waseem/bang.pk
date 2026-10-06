@extends("app")
@section("contents")
<h1 class="page-title">Edit Client</h1>
<!-- Breadcrumb -->
<ol class="breadcrumb breadcrumb-2"> 
	<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
	<li><a href="/clients">Clients</a></li> 
	<li class="active"><strong>Edit Client</strong></li> 
</ol>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading clearfix">
				<h3 class="panel-title">Edit Client</h3>
			</div>
			<div class="panel-body">
				@include('errors.validation')
				{!! Form::model($edit, ['method' => 'PATCH', 'action' => ['App\Http\Controllers\ClientsController@update', $edit->id], 'class' => 'form-horizontal', 'files' => true ]) !!}
					<div class="form-group"> 
						<label class="col-sm-3 control-label">Name</label>  
						<div class="col-sm-5"> 
						{!! Form::text('name', null, ['id' => 'name','class'=>'form-control']) !!}
						</div> 
					</div>

					<div class="form-group"> 
						<label class="col-sm-3 control-label">Current Logo</label>  
						<div class="col-sm-5"> 
							@if($edit->logo)
							<img src="{{ asset('upload/clients/' . $edit->logo) }}" style="max-height:100px;">
						@else
							No logo uploaded
						@endif
					</div>
						<div class="col-sm-5"> 
                        {!! Form::file('logo', ['id' => 'logoInput','class'=>'form-control']) !!}
                        </div> 
                    </div>

                    <div class="form-group" id="logoPreviewGroup" style="display:none;"> 
                        <label class="col-sm-3 control-label">New Logo Preview</label>  
                        <div class="col-sm-5"> 
                            <img id="logoPreview" src="" style="max-height:100px; max-width:200px;">
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