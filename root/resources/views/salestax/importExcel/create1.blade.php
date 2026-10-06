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
							<p style="color:red;"><b>Please note:<br/> </b>                                                                                 
1: Type Correct Scenario of invoice.<br/>                                                                               
2: Customer NTN must be 7 digits..  <br/>                                                                              
3: Product Description Should be same as entered in ERP Software.  <br/>                                                                            
4: UOM should be according to FBR.      </p>							
							{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
@stop