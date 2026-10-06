@extends("app")
@section('contents')
    <h1 class="page-title">Edit Bank</h1>
    <!-- Breadcrumb -->
    <ol class="breadcrumb breadcrumb-2">
        <li><a href="{{ asset('dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
        <li><a href="{{ asset('banks') }}">Banks</a></li>
        <li class="active"><strong>Edit Bank</strong></li>
    </ol>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">Edit Bank</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                        <li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    @include('errors.validation')
                    {!! Form::model($edit, ['method' => 'PATCH', 'action' => ['App\Http\Controllers\BanksController@update', $edit->id], 'class' => 'form-horizontal']) !!}
                    {!! Form::hidden('company_id', session()->get('company_id'), ['id' => 'company_id']) !!}
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Code</label>
                        <div class="col-sm-5">
                            {!! Form::text('code', null, ['id' => 'code', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Name</label>
                        <div class="col-sm-5">
                            {!! Form::text('name', null, ['id' => 'name', 'class' => 'form-control']) !!}
                        </div>
                    </div>


                    <div class="line-dashed"></div>
                    <center>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Update Bank</button>
                        </div>
                    </center>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
