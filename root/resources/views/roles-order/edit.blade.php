@extends("app")
@section("contents")
      <div class="content-wrapper" style="">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Edit Teacher
            <!--<small>Control panel</small>-->
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Edit Teacher</a></li>
            <li class="active">Home</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
			<div class="panel panel-default">
				<div class="panel-heading">Edit Teacher
				<p style="float: right;"><a href="/teachers">Home</a></p>
				</div></br>
				@include('errors.validation')
					{!! Form::model($edit, ['method' => 'PATCH', 'action' => ['TeacherController@update', $edit->id], 'class'=>'form-horizontal','files' => 'true', 'enctype' => 'multipart/form-data']) !!}
							<div class="form-group">
								{!! Form::label('image', 'Photo', ['class' => 'col-md-4 control-label']) !!} 
								<div class="col-md-6">
									<!--{!! Form::file('image', null, ['id' => 'image','class'=>'uploader']) !!}---->
								<img src="\upload\teachers\{{ $edit->image }}" alt="Teacher Image" class="online" style="border-radius: 10px;width: 150px;height: 150px;border: 2px solid rgba(85, 82, 95, 0.27);">
								
								</div>
							</div>
							<div class="form-group">
								{!! Form::label('image', 'Update Image', ['class' => 'col-md-4 control-label']) !!} 
								<div class="col-md-6">
									<!--{!! Form::file('image', null, ['id' => 'image','class'=>'uploader']) !!}---->
								<span class="btn btn-default btn-file"><span>Choose Image</span><input type="file" name="image" id="image" /></span>
								
								</div>
							</div>
							
							<div class="form-group">
								{!! Form::label('name', 'Name', ['class' => 'col-md-4 control-label']) !!} 
								<div class="col-md-6">
									{!! Form::text('name', null, ['id' => 'name', 'class'=>'form-control']) !!}
								</div>
							</div>
							<div class="form-group">
								{!! Form::label('birthday', 'Birth Date', ['class' => 'col-md-4 control-label']) !!} 
								<div class="col-md-6">
									{!! Form::date('birthday', null, ['id' => 'birthday','class'=>'form-control']) !!}
								</div>
							</div>
							<div class="form-group">
							{!! Form::label('gender', 'Gender', ['class' => 'col-md-4 control-label']) !!} 
								<div class="col-md-6">
									{!! Form::select('gender', array('Male' => 'Male', 'Female' => 'Female') , null, ['id'=>'gender', 'class'=>'form-control']) !!}
								</div>
							</div>
							<div class="form-group">
								{!! Form::label('address', 'Address', ['class' => 'col-md-4 control-label']) !!} 
								<div class="col-md-6">
									{!! Form::text('address', null, ['id' => 'address','class'=>'form-control']) !!}
								</div>
							</div>
							<div class="form-group">
								{!! Form::label('phone', 'Phone', ['class' => 'col-md-4 control-label']) !!} 
								<div class="col-md-6">
									{!! Form::text('phone', null, ['id' => 'phone','class'=>'form-control']) !!}
								</div>
							</div><div class="form-group">
								{!! Form::label('email', 'Email', ['class' => 'col-md-4 control-label']) !!} 
								<div class="col-md-6">
									{!! Form::text('email', null, ['id' => 'email','class'=>'form-control']) !!}
								</div>
							</div>
							<!--
							<div class="form-group">
								{!! Form::label('password', 'Password', ['class' => 'col-md-4 control-label']) !!} 
								<div class="col-md-6">
								<input type="password" id="password" name="password" style="width: 529px; height: 34px; border: 1px solid #ccc;">
								</div>
							</div>--->
							
							
							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									{!! Form::submit('Update',['class' => 'btn btn-primary']) !!}
								</div>
							</div>
						{!! Form::close() !!}
			</div>          
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@stop	  