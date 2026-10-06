@extends("app")
@section('head')
    <link href="{{ asset('css/plugins/datatables/jquery.dataTables.css') }}" rel="stylesheet">
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
        <h1 class="page-title pull-left">Purchases Tax</h1><a href="purchase-tax/create"
            class="btn btn-primary btn-sm btn-add" role="button">Add Purchase Tax Invoice</a>
    </div>
    <!-- Breadcrumb -->
    <ol class="breadcrumb breadcrumb-2">
        <li><a href="{{ asset('dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
        <li class="active"><strong>Purchases Tax</strong></li>
    </ol>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">Manage Purchases Tax</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    <th>Sr#</th>
                                    <th>Date</th>
                                    <th>Invoice&nbsp;No</th>
                                    <th style="display: none;">Exc.Val</th>
                                    <th>Ex.Tax&nbsp;Value</th>
                                    <th>Tax&nbsp;Value</th>
                                    <th>Inc.Val</th>
                                    <th>Party</th>
                                    <th>Party&nbsp;NTN</th>
                                    <th>Print</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sum = 0; ?>
                                @foreach ($purchases as $purchase)
                                    @if ($purchase->invoice_no != 0)
                                        <?php $sum = $sum + 1; ?>
                                        <tr>
                                            <td class="center">{{ $sum }}</td>
                                            <td class="center">{{ date('m/d/Y', strtotime($purchase->date)) }}</td>
                                            <td class="center">{{ $purchase->invoice_no }}</td>

                                            <?php $total = 0;
                                            $discount = 0;
                                            $tax = 0;
                                            $extratax = 0;
                                            $grandtotal = 0; ?>
                                            @foreach ($purchase->purchasetax_details as $details)
                                                <?php $total = $total + $details->price * $details->quantity;
                                                
                                                //$discount = $discount + (($details->discount/100)*$details->quantity*$details->unit_cost);
                                                $tax = $tax + (int) $details->taxvalue;
                                                $extratax = $extratax + (int) $details->extraTaxValue;
                                                $grandtotal = $grandtotal + (int) $details->total;
                                                ?>

                                            @endforeach
                                            <td class="center" style="display: none;">{{ (int) number_format($total) }}</td>
                                            <td class="center">{{ (int) $extratax }}</td>
                                            <td class="center">{{ (int) $tax }}</td>
                                            <!-- <td class="center">{{ $discount }}</td> -->
                                            <td class="center">{{ (int) $grandtotal }}</td>
                                            <td class="center">
                                                @if ($purchase->parties != null)
                                                    {{ $purchase->parties->party_name }}
                                                @endif
                                            </td>
                                            <td class="center"> @if ($purchase->parties != null){{ $purchase->parties->ntn }}@endif</td>
                                            <td><a href="{{ asset('purchase-tax') }}/{{ $purchase->id }}" target="__blank"
                                                    style="color:white;">
                                                    <button class="btn btn-info" type="button"> <i class="icon-print"
                                                            title="Print Invoice"></i></button></a>
                                            </td>
                                            <td class="size-100 text-center">
                                                <div class="row">
                                                    <a href="{{ asset('purchase-tax') }}/{{ $purchase->id }}/edit" style="color:white;">
                                                        <button class="btn btn-black" type="button"> <i
                                                                class="fa fa-paste"
                                                                title="Edit Invoice"></i></button></a>
                                                    <a
                                                        href="{{ asset('purchase-tax/' . $purchase->id . '/destroy') }}">
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
                                    <th>Invoice&nbsp;No</th>
                                    <th style="display: none;">Exc.Val</th>
                                    <th>Ex.Tax&nbsp;Value</th>
                                    <th>Tax&nbsp;Value</th>
                                    <th>Inc.Val</th>
                                    <th>Party</th>
                                    <th>Party&nbsp;NTN</th>
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