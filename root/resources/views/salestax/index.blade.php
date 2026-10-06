@extends("app")
@section('head')
<link href="{{asset('css/plugins/datatables/jquery.dataTables.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css" type="text/css" />
@stop
@section('contents')
<div class="container-fluid">
    @if (Session::has('flash_message'))
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"
        style="margin-right: 20px;margin-top: 15px;">&times;</button>
    <div class="alert alert-success"> {{ Session::get('flash_message') }} </div>
    @endif
    @if (Session::has('error_message'))
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"
        style="margin-right: 20px;margin-top: 15px;">&times;</button>
    <div class="alert alert-danger"> {{ Session::get('error_message') }} </div>
    @endif
</div>
<div class="page-heading clearfix">
    <h1 class="page-title pull-left">Sales Tax</h1><a href="{{ asset('salestax/create') }}"
        class="btn btn-primary btn-sm btn-add" role="button">Add Sale Tax Invoice</a>
</div>
<ol class="breadcrumb breadcrumb-2">
    <li><a href="{{ asset('dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
    <!-- <li><a href="/sales">Sales</a></li>  -->
    <li class="active"><strong>Sales Tax</strong></li>
</ol>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <h3 class="panel-title">Manage Sales Tax</h3>
            </div>
            <div class="panel-body">
                <form method="GET" action="{{ asset('salestax') }}" class="form-inline" style="margin-bottom: 20px;">
                    <div class="form-group" style="margin-right: 10px; margin-bottom: 10px;">
                        <label for="from_date" style="margin-right: 8px;">From</label>
                        <input type="text" name="from_date" id="from_date" class="form-control sales-tax-date"
                            value="{{ $fromDateInput }}" placeholder="dd/mm/yyyy" autocomplete="off" required>
                    </div>
                    <div class="form-group" style="margin-right: 10px; margin-bottom: 10px;">
                        <label for="to_date" style="margin-right: 8px;">To</label>
                        <input type="text" name="to_date" id="to_date" class="form-control sales-tax-date"
                            value="{{ $toDateInput }}" placeholder="dd/mm/yyyy" autocomplete="off" required>
                    </div>
                    <button type="submit" name="find" value="1" class="btn btn-primary" style="margin-bottom: 10px;">
                        <i class="fa fa-search"></i> Find
                    </button>
                </form>
                <input type="hidden" id="has_searched_flag" value="{{ $hasSearched ? 1 : 0 }}">

                @if($hasSearched)
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                            <tr>
                                <th>Sr#</th>
                                <th>Date</th>
                                <th>DC#</th>
                                <th>Inv#</th>
                                <th>Exc.Val</th>
                                <th>Tax&nbsp;Val</th>
                                <!-- <th>Ex.Tax&nbsp;Value</th> -->
                                <th>Inc.Val</th>
                                <th>Party</th>
                                <th>Party&nbsp;NTN</th>
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
                                <td class="center">{{ date('d/m/Y', strtotime($sale->date)) }}</td>
                                <td class="center">{{ $sale->dcn_no }}</td>
                                <td class="center">{{ $sale->invoice_no }}</td>
                                <?php $total = 0;
                                $discount = 0;
                                $tax = 0;
                                $extratax = 0;
                                $grandtotal = 0; ?>
                                @foreach ($sale->saletax_details as $details)
                                <?php
                                $total = $total + $details->price;
                                $tax = $tax + (int) $details->taxvalue;
                                $extratax = $extratax + (int) $details->extraTaxValue;
                                $grandtotal = $grandtotal + (int) $details->total;
                                ?>
                                @endforeach
                                <td class="center">{{number_format($total) }}</td>
                                <td class="center">{{number_format($tax) }}</td>
                                <!-- <td class="center">{{ (int) $extratax }}</td> -->
                                <td class="center">{{number_format($grandtotal) }}</td>
                                <td class="center">@if ($sale->parties != null){{ $sale->parties->party_name }}@endif</td>
                                <td class="center">@if ($sale->parties != null){{ $sale->parties->ntn }}@endif</td>
                                <td style="display: flex; gap: 5px;">
                                    <a href="{{ asset('salestax/dcn') }}/{{ $sale->id }}"
                                        target="__blank" style="color:white;">
                                        <button class="btn btn-primary" type="button">DC</button></a>
                                    <a href="{{ asset('salestax') }}/{{ $sale->id }}"
                                        target="__blank" style="color:white;">
                                        <button class="btn btn-info" type="button"> <i class="icon-print"
                                                title="Print Invoice"></i></button></a>
                                    <a href="{{ asset('salestax/' . $sale->id . '/pdf') }}" style="color:white;">
                                        <button class="btn btn-danger" type="button" title="Download PDF">
                                            <i class="fa fa-file-pdf-o"></i></button></a>
                                </td>
                                <td class="size-100 text-center">
                                    <div class="row">
                                        <button class="btn btn-success js-email-invoice" type="button"
                                            data-url="{{ asset('salestax/' . $sale->id . '/email') }}"
                                            data-invoice="{{ $sale->invoice_no }}"
                                            title="Email Invoice">
                                            <i class="fa fa-envelope"></i>
                                        </button>
                                       @if($sale->fbr_invoice_no == null)
                                        <a href="{{ asset('salestax') }}/{{ $sale->id }}/edit"
                                            target="__blank" style="color:white;">
                                            <button class="btn btn-black" type="button"> <i
                                                    class="fa fa-paste"
                                                    title="Edit Invoice"></i></button></a>
                                        
                                        <a href="{{ asset('salestax/' . $sale->id . '/destroy') }}">
                                            <button class="btn btn-red" type="button"> <i
                                                    class="icon-trash"
                                                    title="Delete Invoice"></i></button></a>
                                        @endif
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
                                <th>DC#</th>
                                <th>Invoice No</th>
                                <th>Tax&nbsp;Value</th>
                                <th>Total</th>
                                <th>Grand Total</th>
                                <th>Party</th>
                                <th>Party&nbsp;NTN</th>
                                <th>Print</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <div class="alert alert-info" style="margin-bottom: 0;">
                    Select date range and click <strong>Find</strong> to load records.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
<script src="{{asset('/js/jquery.min.js')}}"></script>
<script src="{{asset('/js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/js/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
<script>
    $(document).ready(function() {
        var hasSearched = $('#has_searched_flag').val() === '1';

        $('.sales-tax-date').datepicker({
            dateFormat: 'dd/mm/yy',
            changeMonth: true,
            changeYear: true
        });

        if (hasSearched) {
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
        }
    });
</script>
@include('partials.email-invoice-modal')

@stop