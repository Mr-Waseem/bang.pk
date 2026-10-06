@extends("app")
@section('contents')
    @include("/include.config")
    <div class="content-wrapper">
        <div class="container-fluid">
            @if (Session::has('flash_message'))
                <div class="alert alert-success alert-dismissible fade in">
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
                            <div class="panel-heading" id="panelbg"><b>Copy Parties</b></div>
                            <div class="panel-body">
                                @include('errors.validation')
							    {!! Form::open(['url' => 'copy-customer', 'class' => 'form-horizontal', 'files' => true ]) !!}
                                <div class="box-body">
                                    <div class="form-group has-success">
                                        <label for="inputEmail3" class="col-sm-2 control-label">From</label>
                                        <div class="col-sm-10">
                                            {!! Form::select('from_companyid', $company, null, ['id' => 'from_companyid', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
                    
                                </div></br>
                                  <div class="box-body">
                                    <div class="form-group has-success">
                                        <label for="inputEmail3" class="col-sm-2 control-label">To</label>
                                        <div class="col-sm-10">
                                            {!! Form::select('to_companyid', $company, null, ['id' => 'to_companyid', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
                    
                                </div></br>
                                <div class="box-footer">
                                    <button type="submit" id="parties" name="parties" value="parties"
                                        class="btn btn-primary">Copy Parties</button>
                                </div><!-- /.box-footer --></br></br>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="panel panel-default">
                            <div class="panel-heading" id="panelbg"><b>Copy Products</b></div>
                            <div class="panel-body">

                               {!! Form::open(['url' => 'copy-customer', 'class' => 'form-horizontal', 'files' => true ]) !!}
                                 <div class="box-body">
                                    <div class="form-group has-success">
                                        <label for="inputEmail3" class="col-sm-2 control-label">From</label>
                                        <div class="col-sm-10">
                                            {!! Form::select('from_companyidp', $company, null, ['id' => 'from_companyidp', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
                    
                                </div></br>
                                  <div class="box-body">
                                    <div class="form-group has-success">
                                        <label for="inputEmail3" class="col-sm-2 control-label">To</label>
                                        <div class="col-sm-10">
                                            {!! Form::select('to_companyidp', $company, null, ['id' => 'to_companyidp', 'class' => 'form-control']) !!}
                                        </div>
                                    </div>
                    
                                </div></br>
                                <div class="form-actions">
                                    <button type="submit" id="products" name="products" value="products"
                                        class="btn btn-primary">Copy Products</button>
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
<script src="{{ URL::asset('css/multi-select/jquery.multiselect.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <script type="text/javascript">
        $("#from_companyid").select2();
        $("#from_companyid").next(".select2").find(".select2-selection").focus(function() {
        $("#from_companyid").select2("open");
        });

        $("#to_companyid").select2();
        $("#to_companyid").next(".select2").find(".select2-selection").focus(function() {
        $("#to_companyid").select2("open");
        });
        $("#from_companyidp").select2();
        $("#from_companyidp").next(".select2").find(".select2-selection").focus(function() {
        $("#from_companyidp").select2("open");
        });

        $("#to_companyidp").select2();
        $("#to_companyidp").next(".select2").find(".select2-selection").focus(function() {
        $("#to_companyidp").select2("open");
        });
    </script>
@stop
