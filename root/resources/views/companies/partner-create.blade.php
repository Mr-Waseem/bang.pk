<title>Add Company</title>
@extends('app')
<link rel="stylesheet" href="{{ URL::asset('css/multi-select/jquery.multiselect.css') }}">
<style type="text/css">
        ul,
        li {
            margin: 0;
            /* padding: 0; */
            list-style: inline;
        }

        .label {
            color: #000;
            font-size: 16px;
        }

        select+.select2-container {
            width: 100% !important;
        }
    </style>
@section('contents')
    <div class="container-fluid">
        @if (Session::has('flash_message'))
            <div class="alert alert-success alert-dismissible fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right: 4%;">&times;</a>
                <strong>Success!</strong> {{ Session::get('flash_message') }}
            </div>
        @endif
    </div>
    <!-- <h1 class="page-title">Add Company</h1> -->
    <!-- Breadcrumb -->
    <ol class="breadcrumb breadcrumb-2">
        <li><a href="{{ asset('dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
        <li class="active"><strong>Add Company</strong></li>
    </ol>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">Add Company</h3>
                    <!-- <ul class="panel-tool-options">
                <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                <li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
               </ul> -->
                </div>
                <div class="panel-body">
                    @include('errors.validation')
                    {!! Form::open([
                        'url' => 'company',
                        'class' => 'form-horizontal',
                        'files' => 'true',
                        'enctype' => 'multipart/form-data',
                    ]) !!}
                    {!! Form::hidden('status', 'company', ['id' => 'status']) !!}
                    @include('companies.partner-form', ['submitbutton' => 'save'])
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
<script src="{{ URL::asset('css/multi-select/jquery.multiselect.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <script type="text/javascript">
        $("#sale_type").select2();
        $("#sale_type").next(".select2").find(".select2-selection").focus(function() {
        $("#sale_type").select2("open");
        });
   
        $("#partner_id").select2();
        $("#partner_id").next(".select2").find(".select2-selection").focus(function() {
        $("#partner_id").select2("open");
        });
        $("#province").select2();
        $("#province").next(".select2").find(".select2-selection").focus(function() {
        $("#province").select2("open");
        });
        $("#category").select2();
        $("#category").next(".select2").find(".select2-selection").focus(function() {
        $("#category").select2("open");
        });
        $("#system_type").select2();
        $("#system_type").next(".select2").find(".select2-selection").focus(function() {
        $("#system_type").select2("open");
        });
        $("#Businesstype").select2();
        $("#Businesstype").next(".select2").find(".select2-selection").focus(function() {
        $("#Businesstype").select2("open");
        });
        
        $("#invoice_type").select2();
        $("#invoice_type").next(".select2").find(".select2-selection").focus(function() {
        $("#invoice_type").select2("open");
        });
        $("#type").select2();
        $("#type").next(".select2").find(".select2-selection").focus(function() {
        $("#type").select2("open");
        });
        $("#payment_terms").select2();
        $("#payment_terms").next(".select2").find(".select2-selection").focus(function() {
        $("#payment_terms").select2("open");
        });
        
        $("#scenario").select2();
        $("#scenario").next(".select2").find(".select2-selection").focus(function() {
        $("#scenario").select2("open");
        });

        $('#langOpt3').multiselect({
            columns: 1,
            placeholder: 'Select Scenarios',
            search: true,
            selectAll: true
        });

        
    </script>
@stop
