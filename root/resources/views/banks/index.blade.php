@extends("app")
@section('head')
    <link href="/css/plugins/datatables/jquery.dataTables.css" rel="stylesheet">
    <link href="/js/plugins/datatables/extensions/Buttons/css/buttons.dataTables.css" rel="stylesheet">
    <style>
        .html5buttons {
            display: none;
        }

    </style>
@stop
@section('contents')
    <div class="container-fluid">
        @if (Session::has('flash_message'))
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"
                style="margin-right: 20px;margin-top: 15px;">&times;</button>
            <div class="alert alert-success"> {{ Session::get('flash_message') }} </div>
        @endif
    </div>
    <div class="row">
        <div class="col-sm-5">
            <div class="page-heading clearfix">
                <h1 class="page-title pull-left">Banks Information</h1><a href="{{ asset('banks/create') }}"
                    class="btn btn-primary btn-sm btn-add" role="button">Add New Bank</a>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="page-heading clearfix">

            </div>
        </div>
        <!-- 	<div class="col-sm-4">
      <a href="warehouses/print" target="__blank" class="btn btn-default btn-md">
      <span class="glyphicon glyphicon-print"></span> Print 
      </a>
      <a href="warehouses/pdf" class="btn btn-danger btn-md">
      <span class="glyphicon glyphicon-save-file"></span> PDF 
      </a>
      <a href="warehouses/downloadExcel" class="btn btn-success btn-md">
      <span class="glyphicon glyphicon-file"></span> Excel 
      </a>
     </div> -->
    </div>
    <ol class="breadcrumb breadcrumb-2">
        <li><a href="{{ asset('dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
        <!-- <li><a href="/products">Products</a></li>  -->
        <li class="active"><strong>Banks</strong></li>
    </ol>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">Manage Banks</h3>
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
                                    <th>Serial#</th>
                                    <th>Code</th>
                                    <th>Bank&nbsp;Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sum = 1; ?>
                                @foreach ($banks as $bank)
                                    <tr>
                                        <td><?php echo $sum; ?></td>
                                        <td class="center">{{ $bank->code }}</td>
                                        <td class="center">{{ $bank->name }}</td>
                                        <td class="size-80 text-center">
                                            <div class="dropdown">
                                                <a class="more-link" data-toggle="dropdown" href="#/"><i
                                                        class="icon-dot-3 ellipsis-icon"></i></a>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a href="{{ asset('banks') }}/{{ $bank->id }}/edit">Edit</a></li>
                                                    <li><a
                                                            href="javascript:checkDelete({{ $bank->id }}, '/banks/{{ $bank->id }}/destroy', '/banks');">Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php $sum = $sum + 1; ?>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Serial#</th>
                                    <th>Code</th>
                                    <th>Bank&nbsp;Name</th>
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
