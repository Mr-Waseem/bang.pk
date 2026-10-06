<title>Companies</title>
@extends('app')
@section('head')
    <link href="/css/plugins/datatables/jquery.dataTables.css" rel="stylesheet">
    <link href="/js/plugins/datatables/extensions/Buttons/css/buttons.dataTables.css" rel="stylesheet">
@stop
@section('contents')
    <div class="container-fluid">
        @if (Session::has('flash_message'))
            <div class="alert alert-success alert-dismissible fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right: 4%;">&times;</a>
                <strong>Success!</strong> {{ Session::get('flash_message') }}
            </div>
        @endif
    </div>
    <div class="page-heading clearfix">
        <h1 class="page-title pull-left">Companies</h1>
        @if($loginuser->status == "Admin")
        <a href="{{ asset('company/create') }}" class="btn btn-primary btn-sm btn-add">Add Company</a>
        @endif
    </div>
    <!--
                <div class="btn-group" style="float: right; margin-top: -32px;">
                 <a href="parties/create" class="btn btn-primary btn-sm btn-add" role="button">Excel</a>
                 <a href="parties/create" class="btn btn-primary btn-sm btn-add" role="button">PDF</a>
                 <a href="parties/create" class="btn btn-primary btn-sm btn-add" role="button">Print</a>
                </div>
                --->

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">Companies</h3>
                    <ul class="panel-tool-options">
                        <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
                        <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
                        <li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>Serial #</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach ($data as $value)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $value->CompanyName }}</td>
                                        <td>{{ $value->type }}</td>
                                        <td>
                                            <a href="company/{{ $value->id }}/destroy"
                                                class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                                @if($loginuser->status == "Admin")
                                                <a href="{{ asset('company/' . $value->id . '/edit') }}" class="btn btn-info"><i
                                                    class="fa fa-edit"></i></a>
                                                @endif
                                            <a href="{{ asset('company/assign/' . $value->id) }}" class="btn btn-primary"><i
                                                    class="fa fa-sign-in"></i></a>
                                        </td>
                                    </tr>
                                    @php $i++; @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Serial #</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="/js/jquery.min.js"></script>
    <!--<script src="/js/bootstrap.min.js"></script>
                <script src="/js/plugins/metismenu/jquery.metisMenu.js"></script>
                <script src="/js/plugins/blockui-master/jquery-ui.js"></script>
                <script src="/js/plugins/blockui-master/jquery.blockUI.js"></script>
                <script src="/js/functions.js"></script>
                --->
    <script src="/js/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/js/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="/js/plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
    <script src="/js/plugins/datatables/jszip.min.js"></script>
    <script src="/js/plugins/datatables/pdfmake.min.js"></script>
    <script src="/js/plugins/datatables/vfs_fonts.js"></script>
    <script src="/js/plugins/datatables/extensions/Buttons/js/buttons.html5.js"></script>
    <script src="/js/plugins/datatables/extensions/Buttons/js/buttons.colVis.js"></script>
    <script>
        $(document).ready(function() {
            $('.dataTables-example').DataTable({
                dom: '<"html5buttons" B>lTfgitp',
                buttons: [{
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [0, ':visible']
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    },
                    'colvis'
                ]
            });
        });
    </script>

@stop
