@extends("app")
@section('head')
    <link href="{{asset('css/plugins/datatables/jquery.dataTables.css')}}" rel="stylesheet">
@stop
@section('contents')
<div class="container-fluid">
    @if (Session::has('flash_message'))
        <div class="alert alert-success alert-dismissible fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close"
                style="margin-right: 4%;">&times;</a>
            <strong>Success!</strong> {{ Session::get('flash_message') }}
        </div>
    @endif
</div>
    <!-- <div class="page-heading clearfix">
        <h1 class="page-title pull-left">Sales</h1><a href="{{ asset('sales/create') }}" class="btn btn-primary btn-sm btn-add"
            role="button">Add Sale</a>
    </div>
    <ol class="breadcrumb breadcrumb-2">
        <li><a href="{{ asset('dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
        <li><a href="{{ asset('sales') }}">Sales</a></li>
        <li class="active"><strong>Sales</strong></li>
    </ol> -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix" id="panelbg">
                    <h3 class="panel-title">Manage Sales</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>Sr#</th>
                                    <th>Date</th>
                                    <th>Bill&nbsp;No</th>
                                    <!-- <th>Cost&nbsp;Amount</th> -->
                                    <th>Sale&nbsp;Amount</th>
                                    <th>Account&nbsp;Name</th>
                                    <th>Print</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sum = 0; ?>
                                @foreach ($sales as $sale)
                                    @if ($sale->invoice_no != '0')
                                        <?php $sum = $sum + 1; ?>
                                        <tr>
                                            <td class="center">{{ $sum }}</td>
                                            <td class="center">{{ date('m/d/Y', strtotime($sale->date)) }}</td>
                                            <td class="center">{{ $sale->invoice_no }}</td>
                                            <?php $total = 0;
                                            $CoutAmount = 0;
                                            $SaleAmount = 0;
                                            $discount = 0; ?>
                                            @foreach ($sale->sale_details as $details)
                                                <?php $total = $total + (int) $details->product_cost * (int) $details->quantity;
                                                $CoutAmount = $CoutAmount + (int) $details->cost_amount;
                                                $SaleAmount = $SaleAmount + (int) $details->sale_amount;
                                                ?>
                                            @endforeach
                                            <!-- <td class="center">{{ (int) $total }}</td> -->
                                            <td class="center">{{ (int) $SaleAmount }}</td>
                                            <td class="center">
                                                @if ($sale->parties != null)
                                                    {{ $sale->parties->party_name }}
                                                @endif
                                            </td>
                                            <td class="size-100 text-center">
                                                <div class="row">
                                                    <a href="{{ asset('sales/print') }}/{{ $sale->id }}" target="__blank"
                                                        style="color:white;">
                                                        <button class="btn btn-success" type="button"> <i
                                                                class="icon-print"
                                                                title="Print Invoice"></i></button></a>
                                                    <a href="{{ asset('sales') }}/{{ $sale->id }}" target="__blank"
                                                        style="color:white;">
                                                        <button class="btn btn-info" type="button">DC</button></a>
                                                    <!-- <a href="{{ asset('/sales/salespdf') }}/{{ $sale->id }}" style="color:white;">
           <button class="btn btn-danger" type="button"> <i class="fa fa-file-pdf-o" title="Print PDF"></i></button></a> -->

                                                </div>
                                            </td>
                                            <td class="size-100 text-center">
                                                <div class="row">
                                                    <a href="{{ asset('sales') }}/{{ $sale->id }}/edit" style="color:white;">
                                                        <button class="btn btn-black" type="button"> <i
                                                                class="fa fa-paste"
                                                                title="Edit Invoice"></i></button></a>
                                                    <a
                                                        href="javascript:checkDelete({{ $sale->id }}, '{{asset('/sales')}}/{{ $sale->id }}/destroy', '{{Asset('/sales')}}');">
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
                                    <th>Sr#</th>
                                    <th>Date</th>
                                    <th>Bill&nbsp;No</th>
                                    <!-- <th>Cost&nbsp;Amount</th> -->
                                    <th>Sale&nbsp;Amount</th>
                                    <th>Account&nbsp;Name</th>
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
    <script src="{{asset('/js/jquery.min.js')}}"></script>
    <script src="{{asset('/js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('/js/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
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
