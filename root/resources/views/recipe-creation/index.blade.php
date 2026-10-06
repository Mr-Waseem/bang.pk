@include("/include.config")
@extends("app")
@section('head')
    <link href="{{asset('css/plugins/datatables/jquery.dataTables.css')}}" rel="stylesheet">
@stop
@section('contents')
    <div class="container-fluid">
        @if (Session::has('flash_message'))
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"
                style="margin-right: 20px;margin-top: 15px;">&times;</button>
            <div class="alert alert-success"> {{ Session::get('flash_message') }} </div>
        @endif
    </div>
    <div class="page-heading clearfix">
        <h1 class="page-title pull-left">All Recipes</h1><a href="{{ asset('recipe-creation/create') }}"
            class="btn btn-primary btn-sm btn-add" role="button">Create | Edit Recipe</a>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">Manage All Recipes</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>Sr#</th>
                                    <th>Date</th>
                                    <th>Voucher#</th>
                                    <th>Product</th>
                                    <th>Biller</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sum = 0; ?>
                                @foreach ($sales as $sale)
                                    @if ($sale->vr_no != '0')
                                        <?php $sum = $sum + 1; ?>
                                        <tr>
                                            <td class="center">{{ $sum }}</td>
                                            <td class="center">{{ date('d/m/Y', strtotime($sale->date)) }}</td>
                                            <td class="center">{{ $sale->vr_no }}</td>
                                            <td class="center">
                                                @if ($sale->recipes)
                                                    {{ $sale->recipes->product_name }}
                                                @endif
                                            </td>
                                            <td class="center">{{ $sale->billers->name }}</td>
                                            <td>
                                                <a href="{{ asset('recipe-creation') }}/{{ $sale->id }}" target="_blank"
                                                    style="color:white;">
                                                    <button class="btn btn-info" type="button"> <i class="icon-print"
                                                            title="Print Invoice"></i></button></a>
                                                <a href="javascript:checkDelete({{ $sale->id }}, '{{ asset('recipe-creation') }}/{{ $sale->id }}/destroy', '{{ asset('recipe-creation') }}');">
                                                    <button class="btn btn-red" type="button"> <i class="icon-trash"
                                                            title="Delete Invoice"></i></button></a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Sr#</th>
                                    <th>Date</th>
                                    <th>Voucher#</th>
                                    <th>Product</th>
                                    <th>Biller</th>
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
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
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
