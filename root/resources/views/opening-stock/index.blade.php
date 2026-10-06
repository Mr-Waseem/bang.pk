@extends("app")
@section('head')
    <link href="{{Asset('css/plugins/datatables/jquery.dataTables.css')}}" rel="stylesheet">
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
    <div class="page-heading clearfix">
        <h1 class="page-title pull-left">Opening Stock</h1><a href="{{ asset('opening-stock/create') }}"
            class="btn btn-primary btn-sm btn-add" role="button">Add Opening Stock</a>
    </div>
    <ol class="breadcrumb breadcrumb-2">
        <li><a href="{{ asset('dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
        <!-- <li><a href="/purchases">Manage Purchases</a></li>  -->
        <li class="active"><strong>Manage Opening Stock</strong></li>
    </ol>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">Manage Opening Stock</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>SR#</th>
                                    <th>Date</th>
                                    <th>Bill No</th>
                                    <th>Total</th>
                                    <th>Grand Total</th>
                                    <th>Print</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sum = 0; ?>
                                @foreach ($purchases as $purchase)
                                    @if ($purchase->bill_no != '0')
                                        <?php $sum = $sum + 1; ?>
                                        <tr>
                                            <td>{{ $sum }}</td>
                                            <td class="center">{{ date('d/m/Y', strtotime($purchase->date)) }}
                                            </td>
                                            <td class="center">{{ $purchase->bill_no }}</td>
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
                                            <td class="size-100 text-center">
                                                <div class="row">
                                                    <a href="{{ asset('opening-stock') }}/{{ $purchase->id }}"
                                                        target="__blank" style="color:white;">
                                                        <button class="btn btn-info" type="button"> <i
                                                                class="icon-print"
                                                                title="Print Invoice"></i></button></a>

                                                </div>
                                            </td>
                                            <td class="size-80 text-center">
                                                <div class="row">
                                                    <a href="{{ asset('opening-stock') }}/{{ $purchase->id }}/edit"
                                                        style="color:white;">
                                                        <button class="btn btn-black" type="button"> <i
                                                                class="fa fa-paste"
                                                                title="Edit Invoice"></i></button></a>
                                                    <a
                                                        href="javascript:checkDelete({{ $purchase->id }}, '{{Asset('/opening-stock')}}/{{ $purchase->id }}/destroy', '{{Asset('/opening-stock')}}');">
                                                        <button class="btn btn-red" type="button"> <i
                                                                class="icon-trash"
                                                                title="Delete Invoice"></i></button></a>
                                                </div>
                                            </td>
                                            <!-- <td class="size-80 text-center">
               <div class="dropdown">
                <a class="more-link" data-toggle="dropdown" href="#/"><i class="icon-dot-3 ellipsis-icon"></i></a>
                <ul class="dropdown-menu dropdown-menu-right">
                 <li><a href="/purchases/{{ $purchase->id }}" target="__blank">Invoice</a></li>
                 <li><a href="/purchases/print/{{ $purchase->id }}" target="__blank">Print Invoice</a></li>
                 <li><a href="/purchases/{{ $purchase->id }}/edit">Edit</a></li>
                 <li><a href="javascript:checkDelete({{ $purchase->id }}, '/purchases/{{ $purchase->id }}/destroy', '/purchases');">Delete</a> </li>
                </ul>
               </div>
              </td> -->
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>SR#</th>
                                    <th>Date</th>
                                    <th>Reference No</th>
                                    <!-- <th>Account</th> -->
                                    <th>Total</th>
                                    <!--<th>Product Tax</th>--->
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
