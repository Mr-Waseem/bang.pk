<div class="form-group">
	{!! Form::label('code', 'User&nbsp;Code*', ['class' => 'col-md-4 control-label']) !!} 
	<div class="col-md-6">
		{!! Form::text('code', null, ['id' => 'code', 'class'=>'form-control']) !!}
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
			<div class="col-sm-12">
				<div class="form-group">
					{!! Form::label('Store Name', 'Store&nbsp;Name&nbsp;*', ['class' => 'col-sm-4 control-label']) !!} 
					<div class="col-sm-2">
					{!! Form::text('store_name', null, ['id' => 'store_name', 'class'=>'form-control']) !!}
					</div>
				</div>
			</div>
		<div class="col-sm-12">
			<div class="form-group">
			{!! Form::label('Full Name', 'Full&nbsp;Name&nbsp;*', ['class' => 'col-sm-4 control-label']) !!} 
			<div class="col-sm-2">
			{!! Form::text('full_name', null, ['id' => 'full_name','class'=>'form-control']) !!}
			</div>
			</div>
		</div>
	</div>
</div>
<div class="form-group">
	{!! Form::label('Address', 'Address&nbsp;*', ['class' => 'col-md-4 control-label']) !!} 
	<div class="col-md-6">
		{!! Form::text('address', null, ['id' => 'address', 'class'=>'form-control']) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('Zip Code', 'Zip&nbsp;Code', ['class' => 'col-md-4 control-label']) !!} 
	<div class="col-md-6">
		{!! Form::text('zip_code', null, ['id' => 'zip_code', 'class'=>'form-control']) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('Phone', 'Phone', ['class' => 'col-md-4 control-label']) !!} 
	<div class="col-md-6">
		{!! Form::text('phone', null, ['id' => 'phone', 'class'=>'form-control']) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('Mobile', 'Mobile&nbsp;*', ['class' => 'col-md-4 control-label']) !!} 
	<div class="col-md-6">
		{!! Form::text('mobile', null, ['id' => 'mobile', 'class'=>'form-control']) !!}
	</div>
</div>			
<div class="form-group">
	{!! Form::label('email', 'Email&nbsp;*', ['class' => 'col-md-4 control-label']) !!} 
	<div class="col-md-6">
		{!! Form::email('email', null, ['id' => 'email','class'=>'form-control']) !!}
	</div>
</div>
<div class="form-group">
	{!! Form::label('password', 'Password&nbsp;*', ['class' => 'col-md-4 control-label']) !!} 
	<div class="col-md-6">
	<input type="password" id="password" name="password" style="width: 529px; height: 34px; border: 1px solid #ccc;">
	</div>
</div>
<div class="form-group">
	<div class="col-md-6 col-md-offset-4">
		{!! Form::submit($submitbutton, ['class' => 'btn btn-primary']) !!}
	</div>
</div>
							
							


						
						