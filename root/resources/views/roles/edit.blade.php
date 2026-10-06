@extends('app')

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
</head>

@section('contents')
    <div class="content-wrapper" style="min-height: 100vh;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1 style="color:white">
                Edit User
            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ asset('roles') }}"><i class="fa fa-dashboard"></i> Users Management</a></li>
                <li class="active">Edit User</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit User
                </div>
                <div class="panel-body">
                    @include('errors.validation')
                    
                    {!! Form::model($edit, [
                        'method' => 'PATCH',
                        'action' => ['App\Http\Controllers\RoleController@update', $edit->id],
                        'class' => 'form-horizontal',
                        'files' => 'true',
                        'enctype' => 'multipart/form-data',
                    ]) !!}

                    <!-- User Information Section -->
                    <div class="row">
                        <!-- First Column -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                {!! Form::label('name', 'Name', ['class' => 'col-md-4 col-form-label']) !!}
                                <div class="col-md-8">
                                    {!! Form::text('name', null, [
                                        'id' => 'name',
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter full name'
                                    ]) !!}
                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                {!! Form::label('email', 'Email', ['class' => 'col-md-4 col-form-label']) !!}
                                <div class="col-md-8">
                                    {!! Form::email('email', null, [
                                        'id' => 'email',
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter email address'
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <!-- Second Column -->
                        <div class="col-md-6">
                            <div class="form-group row">
                                {!! Form::label('Password', 'Password', ['class' => 'col-md-4 col-form-label']) !!}
                                <div class="col-md-8">
                                    {!! Form::text('show_password', null, [
                                        'id' => 'show_password',
                                        'class' => 'form-control',
                                        'placeholder' => 'Enter new password'
                                    ]) !!}

                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                {!! Form::label('type', 'Status', ['class' => 'col-md-4 col-form-label']) !!}
                                <div class="col-md-8">
                                    {!! Form::select('type', [
                                        'ACTIVE' => 'ACTIVE', 
                                        'INACTIVE' => 'INACTIVE'
                                    ], null, [
                                        'id' => 'type',
                                        'class' => 'form-control'
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="row mt-4">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fa fa-save"></i> Update
                            </button>
                        </div>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@stop

@section('scripts')
    <!-- Select2-->
    <script src="/js/plugins/select2/select2.full.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Initialize Select2
            $("#shop_id").select2();
            $("#location_id").select2();

            // Open dropdown on focus
            $("#shop_id").next(".select2").find(".select2-selection").focus(function() {
                $("#shop_id").select2("open");
            });

            $("#location_id").next(".select2").find(".select2-selection").focus(function() {
                $("#location_id").select2("open");
            });
        });
    </script>
@stop