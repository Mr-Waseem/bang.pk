@extends("app")
@section('contents')
    <h1 class="page-title">Cash Book Report</h1>
    <!-- Breadcrumb -->
    <ol class="breadcrumb breadcrumb-2">
        <li><a href="{{ asset('dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
        <li class="active"><strong>Cash Book Report</strong></li>
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
                    {!! Form::open(['url' => 'cash-book-report', 'class' => 'form-horizontal']) !!}


 
                    <div class="form-group">
                        <label class="col-sm-3 control-label">From</label>
                        <div class="col-sm-5">
                            <input type="date" name="from_date" id="from_date" value="<?php echo date('Y-m-d'); ?>"
                                class="form-control" required autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">To</label>
                        <div class="col-sm-5">
                            <input type="date" name="to_date" id="to_date" value="<?php echo date('Y-m-d'); ?>"
                                class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Select Account</label>
                        <div class="col-sm-5">
                            {!! Form::select('account_id', $PettyCash, null, ['id' => 'account_id', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group" style="margin-left: 1%; margin-right: 1%;"> <label
                                class="col-sm-1 control-label"></label>
                            <div class="col-sm-2">
                                <div id="year-view" class="input-group date">

                                </div>
                            </div>
                            <label class="radio-inline"><input type="radio" name="cash_report" id="cash_report" value="1"
                                    checked><b>DETAIL</b></label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <label class="radio-inline"><input type="radio" name="cash_report" id="cash_report"
                                    value="2">SUMMARY</label>
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

@stop
@section('scripts')

    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <script type="text/javascript">
        $("#account_group_id").select2();
        $("#account_group_id").next(".select2").find(".select2-selection").focus(function() {
            $("#account_group_id").select2("open");
        });
    </script>
@stop
