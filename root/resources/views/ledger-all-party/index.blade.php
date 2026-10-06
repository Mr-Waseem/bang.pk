@extends("app")
<head>
  <link href="{{Asset('css/select2.min.css')}}" rel="stylesheet" />

</head>
@section('contents')
    <h1 class="page-title">All Customers Balance</h1>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">All Customers Balance</h3>
                </div>
                <div class="panel-body">

                    @include('errors.validation')
                    {!! Form::open(['url' => 'ledger-all-party/report', 'class' => 'form-horizontal']) !!}
                    <div class="form-group" style="display:none;">
                        <label class="col-sm-3 control-label">Select Account</label>
                        <div class="col-sm-5">
                            {!! Form::select('warehouse_id', $Warehouse, null, ['id' => 'warehouse_id', 'class' => 'form-control livesearch']) !!}
                        </div>
                    </div>
                    <div class="form-group" style="display:none;">
                        <label class="col-sm-3 control-label">Type</label>
                        <div class="col-sm-5">
                            {!! Form::select('saletype', ['Credit Sale' => 'CREDIT CUSTOMERS', 'Cash Sale' => 'CASH CUSTOMERS'], null, ['id' => 'saletype', 'class' => 'form-control livesearch']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Type</label>
                        <div class="col-sm-5">
                            {!! Form::select('groupID', $group, null, ['id' => 'groupID', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">From</label>
                        <div class="col-sm-5">
                            <input type="date" name="from_date" id="from_date" value="<?php echo date('Y-m-d'); ?>"
                                class="form-control" autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">To</label>
                        <div class="col-sm-5">
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

@stop
@section("scripts")
<!-- Select2-->
<script src="{{Asset('js/plugins/select2/select2.full.min.js')}}"></script>
<script type="text/javascript">
	$("#groupID").select2();
	$("#groupID").next(".select2").find(".select2-selection").focus(function() {
	$("#groupID").select2("open");
	   });
</script>
@stop