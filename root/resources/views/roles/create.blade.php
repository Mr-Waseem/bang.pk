
@extends("app")

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
  <title>Add Role</title>
</head>
@section('contents')
    <div class="container-fluid">
        @if (Session::has('flash_message'))
            <div class="alert alert-success alert-dismissible fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close"
                    style="margin-right: 4%;">&times;</a>
                <strong>Success!</strong> {{ Session::get('flash_message') }}
            </div>
        @endif
    </div>
    <div class="content-wrapper" style="">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1 style="color:white">
                Create User

            </h1>
            <ol class="breadcrumb">
                <li><a href="{{ asset('roles') }}"><i class="fa fa-dashboard"></i>Users Management</a></li>
                <li class="active">Create User</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="panel panel-default">
                <div class="panel-heading">Create User

                </div></br>
               <div class="panel-body">
                @include('errors.validation')
                {!! Form::open(['url' => 'roles/adduser', 'class' => 'form-horizontal', 'files' => 'true', 'enctype' => 'multipart/form-data']) !!}
                @include('roles._user_form', ['submitbutton' => 'save'])
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
        $("#shop_id").select2();
        $("#shop_id").next(".select2").find(".select2-selection").focus(function() {
            $("#shop_id").select2("open");
        });

        $("#location_id").select2();
        $("#location_id").next(".select2").find(".select2-selection").focus(function() {
            $("#location_id").select2("open");
        });
    </script>
@stop
