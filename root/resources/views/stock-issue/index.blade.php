@extends('app')
@section('head')
    <link href="{{ asset('css/plugins/datatables/jquery.dataTables.css') }}" rel="stylesheet">
    <link href="{{ asset('js/plugins/datatables/extensions/Buttons/css/buttons.dataTables.css') }}" rel="stylesheet">
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
        <h1 class="page-title pull-left">Manage Stock</h1><a href="{{ asset('stock-issue/create') }}"
            class="btn btn-primary btn-sm btn-add" role="button">Add Stock Issue</a>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">Manage Issued Stock</h3>

                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>SR#</th>
                                    <th>Date</th>
                                    <th>Bill No</th>
                                    <th>Account</th>
                                    <th>Total</th>
                                    <th>Grand Total</th>
                                    <th>Print</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sum = 0; ?>
                                @foreach ($purchases as $purchase)
                                    @if ($purchase->bill_no != '0' && $purchase->purchase_type != 'Commercial' && $purchase->purchase_type != 'Sales Tax' && $purchase->purchase_type != 'LC')
                                        <?php $sum = $sum + 1; ?>
                                        <tr>
                                            <td>{{ $sum }}</td>
                                            <td class="center">{{ date('d-m-Y', strtotime($purchase->date)) }}
                                            </td>
                                            <td class="center">{{ $purchase->bill_no }}</td>
                                            <td class="center">
                                                @if ($purchase->parties != null)
                                                    {{ $purchase->parties->party_name }}
                                                @endif
                                            </td>
                                            <?php $total = 0;
                                            $tax = 0;
                                            $grandtotal = 0; ?>
                                            @foreach ($purchase->purchase_details as $details)
                                                <?php $total = $total + $details->unit_cost * $details->quantity;
                                                $grandtotal = $grandtotal + $details->total_cost;
                                                ?>
                                            @endforeach
                                            <td class="center">{{ (int) $total }}</td>
                                            <td class="center">{{ (int) $grandtotal }}</td>
                                            <td class="size-80 text-center">
                                                <div class="row">
                                                    <a href="{{ asset('stock-issue/print') }}/{{ $purchase->id }}"
                                                        target="_blank" style="color:white;">
                                                        <button class="btn btn-info" type="button"> <i
                                                                class="icon-print"
                                                                title="Print Invoice"></i></button></a>

                                                </div>
                                            </td>
                                            <td class="size-80 text-center">
                                                <div class="row">
                                                    {{-- <a href="{{ asset('stock-issue') }}/{{ $purchase->id }}/edit"
                                                        style="color:white;">
                                                        <button class="btn btn-black" type="button"> <i
                                                                class="fa fa-paste"
                                                                title="Edit Invoice"></i></button></a> --}}
                                                    <a
                                                        href="javascript:checkDelete({{ $purchase->id }}, '{{ asset('stock-issue') }}/{{ $purchase->id }}/destroy', '{{ asset('stock-issue') }}');">
                                                        <button class="btn btn-red" type="button"> <i
                                                                class="icon-trash"
                                                                title="Delete Invoice"></i></button></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>SR#</th>
                                    <th>Date</th>
                                    <th>Reference No</th>
                                    <th>Account</th>
                                    <th>Total</th>
                                    <th>Grand Total</th>
                                    <th>Print</th>
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
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/extensions/Buttons/js/buttons.html5.js') }}"></script>
    <script src="{{ asset('js/plugins/datatables/extensions/Buttons/js/buttons.colVis.js') }}"></script>
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
