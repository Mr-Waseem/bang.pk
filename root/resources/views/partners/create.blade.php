@extends("app")
@section("contents")
<h1 class="page-title">Add Partner</h1>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">Add Partner</h3>
						</div>
						<div class="panel-body">
							@include('errors.validation')
							{!! Form::open(['url' => 'partners', 'class' => 'form-horizontal' ]) !!}
							<input type="hidden" id="status" name="status" value="Partner">
							<input type="hidden" id="type" name="type" value="ACTIVE">
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Name</label>  
									<div class="col-sm-5"> 
									{!! Form::text('name', null, ['id' => 'name','class'=>'form-control',]) !!}
									</div> 
								</div>
								
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Phone</label>
									<div class="col-sm-5"> 
									{!! Form::text('phone', null, ['id' => 'phone','class'=>'form-control',]) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">City</label>
									<div class="col-sm-5"> 
									{!! Form::text('city', null, ['id' => 'city','class'=>'form-control',]) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Address</label>
									<div class="col-sm-5"> 
									{!! Form::text('address', null, ['id' => 'address','class'=>'form-control',]) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Email</label>
									<div class="col-sm-5"> 
									{!! Form::text('email', null, ['id' => 'email','class'=>'form-control',]) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Password</label>
									<div class="col-sm-5"> 
									<input type="password" id="password" class="form-control" name="password">
									</div> 
								</div>
								<!-- <div class="form-group"> 
									<label class="col-sm-3 control-label">Tax Type</label>
									<div class="col-sm-5"> 
									{!! Form::select('tax_type', array('Percentage (%)' => 'Percentage (%)', 'Fixed ($)' =>  'Fixed ($)'), null, ['id' => 'tax_type', 'class'=>'form-control',]) !!}
									</div> 
								</div> -->
							
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