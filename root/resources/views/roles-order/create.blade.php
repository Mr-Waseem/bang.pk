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
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Create User
            <!--<small>Control panel</small>-->
          </h1>
          <ol class="breadcrumb">
            <li><a href="{{asset('/roles')}}"><i class="fa fa-dashboard"></i>Users</a></li>
            <li class="active" style="color:white;">Create User</li>
          </ol>
		  
        </section>

        <!-- Main content -->
        <section class="content">
			<div class="panel panel-default">
				<div class="panel-heading">Create User
				<p style="float: right;"><a href="{{asset('/roles')}}">Home</a></p>
				</div></br>
				@include('errors.validation')
					{!! Form::open(['url' => 'roles/adduser', 'class'=>'form-horizontal', 'files' => 'true', 'enctype' => 'multipart/form-data']) !!}
							@include('roles._form', ['submitbutton' => 'save'])
						{!! Form::close() !!}
			</div>          
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@stop	  
