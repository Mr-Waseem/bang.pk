@extends("app")
@section('contents')
    @include("/include.config")
    <div class="content-wrapper">
        <div class="container-fluid">
            @if (Session::has('flash_message'))
                <div class="alert alert-danger alert-dismissible fade in">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close"
                        style="margin-right: 4%;">&times;</a>
                    <strong>Alert!</strong> {{ Session::get('flash_message') }}
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

                                {!! Form::model($edit, ['method' => 'PATCH', 'action' => ['App\Http\Controllers\AccountSettingController@update', $edit->id], 'class' => 'form-horizontal', 'files' => 'true', 'enctype' => 'multipart/form-data']) !!}
                                <div class="box-body">
                                    <div class="form-group has-success">
                                        <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
                                        <div class="col-sm-10">
                                            {!! Form::text('name', null, ['id' => 'name', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group has-success">
                                        <label for="inputPassword3" class="col-sm-2 control-label">Email</label>
                                        <div class="col-sm-10">
                                            {!! Form::text('email', null, ['id' => 'email', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>


                                    @if ($user[0]->image)
                                    <div class="form-group has-success">
                                        <label for="inputPassword3" class="col-sm-2 control-label">Image</label>
                                        <div class="col-sm-10">
                                            <img src="{{ URL::asset('root/upload/users/'.$user[0]->image) }}"
                                                style="width: 120px;height: 140px;border-radius: 5px;border-image: solid 2px;border: solid 3px;border-color: #00a65a;" />
                                        </div>
                                    </div>
                            @else
                                <!-- <img src="{{ URL::asset('root/upload/logo/userlogo.png') }}"
                                    style="width: 40px;height: 40px;border-radius: 25px;border-image: solid 2px;border: solid 3px;border-color: #00a65a;" /> -->

                                    <div class="form-group has-success">
                                        <label for="inputPassword3" class="col-sm-2 control-label">Image</label>
                                        <div class="col-sm-10">
                                            <img src="{{ URL::asset('root/upload/logo/userlogo.png') }}"
                                                style="width: 120px;height: 140px;border-radius: 5px;border-image: solid 2px;border: solid 3px;border-color: #00a65a;" />
                                        </div>
                                    </div>
                            @endif
                                    <div class="form-group has-success">
                                        <label for="inputPassword3" class="col-sm-2 control-label">Update&nbsp;Image</label>
                                        <div class="col-sm-10">
                                            <span class="btn btn-default btn-file"><span></span><input type="file"
                                                    name="image" id="image" /></span>
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
                    <div class="col-sm-6">
                        <div class="panel panel-default">
                            <div class="panel-heading" id="panelbg"><b>Change Password</b></div>
                            <div class="panel-body">

                                {!! Form::model($edit, ['method' => 'PATCH', 'action' => ['App\Http\Controllers\AccountSettingController@update', $edit->id], 'class' => 'form-horizontal']) !!}
                                <div class="box-body">
                                    <div class="form-group has-success">
                                        <label for="Old Password"
                                            class="col-sm-2 control-label">Current&nbsp;Password</label></br></br>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="old_password"
                                                name="old_password">
                                        </div>
                                    </div>
                                    <div class="form-group has-success">
                                        <label for="New Password"
                                            class="col-sm-2 control-label">New&nbsp;Password</label></br></br>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="new_password"
                                                name="new_password">
                                        </div>
                                    </div>
                                    <div class="form-group has-success">
                                        <label for="Confirm Password"
                                            class="col-sm-2 control-label">Confirm&nbsp;Password</label></br></br>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="confirm_confirmation"
                                                name="confirm_password">
                                        </div>
                                    </div></br></br>
                                </div><!-- /.box-body -->
                                <div class="form-actions">
                                    <button type="submit" id="PasswordSubmit" name="PasswordSubmit" value="PasswordSubmit"
                                        class="btn btn-primary">Update Password</button>
                                </div><!-- /.box-footer --></br></br></br>
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
