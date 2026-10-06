@extends("app")
@section('contents')
    @include("/include.config")
    <div class="content-wrapper">
        <div class="container-fluid">
            @if (Session::has('flash_message'))
                <div class="alert alert-success alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close"
                        style="margin-right: 4%;">&times;</a>
                    <strong>Success!</strong> {{ Session::get('flash_message') }}
                </div>
            @endif
        </div>
        @include('errors.validation')
        <div class="container">
            <div class="panel-group">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="panel panel-default">
                            <div class="panel-heading" id="panelbg"><b>Profile Management</b></div>
                            <div class="panel-body">

                                {!! Form::model($company, ['method' => 'PATCH', 'action' => ['App\Http\Controllers\DeveloperModeController@update', $company->id], 'class' => 'form-horizontal', 'files' => 'true', 'enctype' => 'multipart/form-data']) !!}
                                <div class="box-body">
                                    <div class="form-group has-success">
                                        <label for="inputEmail3" class="col-sm-2 control-label">Debug Mode</label>
                                        <div class="col-sm-10">
                                            {!! Form::hidden('id', null, ['id' => 'id', 'class' => 'form-control']) !!}
                                            {!! Form::text('debug_mode', null, ['id' => 'debug_mode', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
           
                                </div></br><!-- /.box-body -->
                                <div class="box-footer">
                                    <button type="submit" id="profile" name="profile" value="profile"
                                        class="btn btn-primary">Update Profile</button>
                                </div><!-- /.box-footer --></br></br>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
        <!-- Main content -->

    </div><!-- /.content-wrapper -->
@stop
@section('scripts')

@stop
