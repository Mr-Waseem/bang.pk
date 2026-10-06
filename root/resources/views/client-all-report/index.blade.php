@extends("app")
<head>
    <script src="{{ asset('login-form-assets/js/jquery.min.js') }}"></script>
</head>
@section('contents')
    <h1 class="page-title">Account Report</h1>
    <!-- Breadcrumb -->
    <!-- <ol class="breadcrumb breadcrumb-2">
        <li><a href="{{ asset('dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
        <li class="active"><strong>Account Report</strong></li>
    </ol> -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">Select Date</h3>
                </div>
                <div class="panel-body">
                    <input id="token" type="hidden" value="{{ $encrypted_token }}">
                    @include('errors.validation')
                    {!! Form::open(['url' => 'client-all-report', 'class' => 'form-horizontal']) !!}
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
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Select Category</label>
                        <div class="col-sm-5">
                            {!! Form::select('account_group_id', $AccountGroups, null, ['id' => 'account_group_id', 'class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Select Account</label>
                        <div class="col-sm-5">
                            {!! Form::select('head_id', $Heads, null, ['id' => 'head_id', 'class' => 'form-control']) !!}
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
                                            $("#head_id").select2("open");
                                        }else{
                                            $('#head_id').html('<option value="" selected>Account Not Found</option>');
                                        }
                                    }
                                });
                            });
                        });
                    </script>


                    <div class="row">
                        <div class="form-group" style="margin-left: 1%; margin-right: 1%;"> <label
                                class="col-sm-1 control-label"></label>
                            <div class="col-sm-2">
                                <div id="year-view" class="input-group date">

                                </div>
                            </div>
                            <label class="radio-inline"><input type="radio" name="ReportDetail" id="ReportDetail"
                                    value="1" checked>Summary</label>
                            <label class="radio-inline"><input type="radio" name="ReportDetail" id="ReportDetail"
                                    value="2">Detail</label>
                        </div>
                    </div>
                    <div class="line-dashed"></div>
                    <center>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Find</button>
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
        $("#head_id").select2();
        $("#head_id").next(".select2").find(".select2-selection").focus(function() {
            $("#head_id").select2("open");
        });
    </script>
@stop
