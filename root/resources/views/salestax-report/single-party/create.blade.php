@extends("app")
@section('contents')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css"
        type="text/css" />
    <h1 class="page-title">SalesTax Register Single Party</h1>
    <!-- Breadcrumb -->
    <ol class="breadcrumb breadcrumb-2">
        <li><a href="{{ asset('dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
        <li class="active"><strong>SalesTax Register Single Party</strong></li>
    </ol>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">Select Date</h3>
                </div>
                <div class="panel-body">
                    <input id="token" type="hidden" value="{{ $encrypted_token }}">
                    @include('errors.validation')
                    {!! Form::open(['url' => 'salestax-report/single-party/add/report', 'class' => 'form-horizontal']) !!}
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Select Party/Customer</label>
                        <div class="col-sm-5">
                            {!! Form::select('party_name', $parties, null, ['id' => 'party_name', 'class' => 'form-control', 'required' => 'required', 'autofocus' => 'autofocus']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">From</label>
                        <div class="col-sm-5">
                            <!-- {!! Form::date('from_date', null, ['id' => 'from_date', 'class' => 'form-control', 'required' => 'required']) !!} -->
                            <input type="date" name="from_date" id="from_date" value="<?php echo date('Y-m-d'); ?>"
                                class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">To</label>
                        <div class="col-sm-5">
                            <!-- {!! Form::date('to_date', null, ['id' => 'to_date', 'class' => 'form-control', 'required' => 'required']) !!} -->
                            <input type="date" name="to_date" id="to_date" value="<?php echo date('Y-m-d'); ?>"
                                class="form-control">
                        </div>
                    </div>
                    <div class="line-dashed"></div>
                    <center>
                        <div class="form-actions">
                            <button type="submit" name="btnSave" id="btnSave" target="_blank"
                                class="btn btn-primary">Find</button>
                        </div>
                    </center>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
    <!-- Select2-->
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <script>
        $("#party_name").select2();
        $("#party_name").next(".select2").find(".select2-selection").focus(function() {
            $("#party_name").select2("open");
        });
    </script>
@stop
