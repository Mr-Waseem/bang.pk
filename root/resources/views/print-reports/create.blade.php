@extends("app")

<head>
    <title>Print Report</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="{{ asset('login-form-assets/js/jquery.min.js') }}"></script>
</head>
@section('contents')
    <h1 class="page-title">Print Report</h1>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">Select Date</h3>
                </div>
                <div class="panel-body">
                    @include('errors.validation')
                    {!! Form::open(['url' => 'print-reports/find-report', 'class' => 'form-horizontal']) !!}
                    <div class="form-group" style="display: none">
                        <label class="col-sm-3 control-label">Select Category</label>
                        <div class="col-sm-5">
                            {!! Form::select('account_group_id', $AccountGroups, null, ['id' => 'account_group_id', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <script>
                        $(document).ready(function(){
                            $('#account_group_id').change(function(){
                                var account_group_id = $(this).val();
                                $.ajax({
                                    url:"{{ asset('get-selected-category-accounts') }}?account_group_id="+account_group_id,
                                    type:'get',
                                    dataType:'json',
                                    success:function(response){
                                        if(response.length!=0)
                                        {
                                            var option = '<option value="" selected>Select Account</option>';
                                            $.each(response,function(i,v){
                                                option+="<option value='"+v.id+"'>"+v.party_name+"</option>";
                                            });
                                            $('#head_id').html(option);
                                        }else{
                                            $('#head_id').html('<option value="" selected>Account Not Found</option>');
                                        }
                                    }
                                });
                            });
                        });
                    </script>
                    <div class="form-group" style="display: none">
                        <label class="col-sm-3 control-label">Select Account</label>
                        <div class="col-sm-5">
                            {!! Form::select('head_id', $Heads, null, ['id' => 'head_id', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">From</label>
                        <div class="col-sm-5">
                            <!-- {!! Form::date('from_date', null, ['id' => 'from_date', 'class' => 'form-control']) !!} -->
                            <input type="date" name="from_date" id="from_date" value="<?php echo date('Y-m-d'); ?>"
                                class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">To</label>
                        <div class="col-sm-5">
                            <!-- {!! Form::date('to_date', null, ['id' => 'to_date', 'class' => 'form-control']) !!} -->
                            <input type="date" name="to_date" id="to_date" value="<?php echo date('Y-m-d'); ?>"
                                class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Select Parties</label>
                        <div class="col-sm-5">
                            {!! Form::select('party_id', $currentWarehouseParties, '', ['id' => 'party_id', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Report Type</label>
                        <div class="col-sm-5">
                            <label class="control-label hidden">
                                <input type="radio" name="report_type" id="report_type" value="cr" checked style="position: relative;top:2px;">
                                CR
                            </label>
                            <!-- &emsp; -->
                            <label class="control-label hidden">
                                <input type="radio" name="report_type" id="report_type" value="cp" style="position: relative;top:2px;">
                                CP
                            </label>
                            <!-- &emsp; -->
                            <label class="control-label hidden">
                                <input type="radio" name="report_type" id="report_type" value="br" style="position: relative;top:2px;">
                                BR
                            </label>
                            <!-- &emsp; -->
                            <label class="control-label hidden">
                                <input type="radio" name="report_type" id="report_type" value="bp" style="position: relative;top:2px;">
                                BP
                            </label>
                            <!-- &emsp; -->
                            <label class="control-label hidden">
                                <input type="radio" name="report_type" id="report_type" value="pt" style="position: relative;top:2px;">
                                PT
                            </label>
                            <!-- &emsp; -->
                            <label class="control-label">
                                <input type="radio" name="report_type" id="report_type" value="st" checked style="position: relative;top:2px;">
                                ST
                            </label>
                            &emsp;
                            <label class="control-label hidden">
                                <input type="radio" name="report_type" id="report_type" value="jv" style="position: relative;top:2px;">
                                JV
                            </label>
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
    <!-- Select2-->
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <script type="text/javascript">
        $("#account_id").select2();
        $("#account_id").next(".select2").find(".select2-selection").focus(function() {
            $("#account_id").select2("open");
        });

        $("#account_group_id").select2();
        $("#account_group_id").next(".select2").find(".select2-selection").focus(function() {
            $("#account_group_id").select2("open");
        });

        $("#head_id").select2();
        $("#head_id").next(".select2").find(".select2-selection").focus(function() {
            $("#head_id").select2("open");
        });

        $("#party_id").select2();
        $("#party_id").next(".select2").find(".select2-selection").focus(function() {
            $("#party_id").select2("open");
        });
    </script>
@stop
