@extends("app")
@section("contents")
<div class="container-fluid">
				@if (Session::has('flash_message'))
					 <div class="alert alert-success alert-dismissible fade in">
			 			<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right: 4%;">&times;</a>
			 			<strong>Success!</strong> {{ Session::get('flash_message') }}
			  		</div>
				@endif
				
				@if (Session::has('error'))
					<div class="alert alert-danger alert-dismissible fade in">
						<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right: 4%;">&times;</a>
						<strong>Error!</strong> {{ Session::get('error') }}
						@if (Session::has('error_details'))
							<ul style="margin-top: 10px; list-style-type: disc; padding-left: 20px;">
								@foreach (Session::get('error_details') as $detail)
									@if(!empty(trim($detail)))
										<li>{{ $detail }}</li>
									@endif
								@endforeach
							</ul>
						@endif
					</div>
				@endif
			</div>
		<h1 class="page-title">Import Sales</h1>

			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">Upload File</h3>
						</div>
						<div class="panel-body">
							@include('errors.validation')
							{!! Form::open(['url' => 'salestax/import-excel', 'class' => 'form-horizontal', 'files' => 'true', 'enctype' => 'multipart/form-data' ]) !!}

								<div class="form-group"> 
									<label class="col-sm-3 control-label">Upload&nbsp;File</label>
									<div class="col-sm-5"> 
									{!! Form::file('import_file', null, ['id' => 'import_file','class'=>'form-control',]) !!}
									</div> 
								</div>
								<input type="hidden" value="{{ csrf_token() }}" name="_token" />
								<div class="line-dashed"></div>
								<center><div class="form-actions">
								<a href="{{asset('root/upload/sales-sample.xlsx')}}" style="color:white;"><button type="button" class="btn btn-success">Download Format</button></a>
							  <button type="submit" class="btn btn-primary">Upload File</button>
							</div></center>

										<!-- Overlay shown during upload to indicate progress -->
										<div id="import-overlay" style="display:none;position:fixed;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,0.5);z-index:2000;">
											<div style="position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);color:#fff;text-align:center;">
												<div class="spinner-border" role="status" style="width:3rem;height:3rem;color:#fff;">
													<span class="sr-only">Loading...</span>
												</div>
												<div style="margin-top:10px;font-size:16px;">Uploading, please wait...</div>
											</div>
										</div>

										<script>
											(function(){
												var form = document.querySelector('form.form-horizontal');
												if(!form) return;
												form.addEventListener('submit', function(e){
													var overlay = document.getElementById('import-overlay');
													if(overlay) overlay.style.display = 'block';
													var submitBtn = form.querySelector('button[type=submit]');
													if(submitBtn){
														submitBtn.disabled = true;
														submitBtn.textContent = 'Uploading...';
													}
												});
											})();
										</script>
							<p style="color:red;"><b>Please note:<br/> </b>                                                                                 
1: Type Correct Scenario of invoice.<br/>                                                                               
2: Customer NTN must be 7 digits. If customer doesn't exist, it will be created automatically.<br/>                                                                              
3: Column 28 (AB) is for Customer Address, Column 29 (AC) is for Customer Type (e.g., Registered, Unregistered).<br/>
4: Product Description Should be same as entered in ERP Software.  <br/>                                                                            
5: UOM should be according to FBR.      </p>							
							{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
@stop