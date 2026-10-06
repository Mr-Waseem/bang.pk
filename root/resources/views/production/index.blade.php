@include("/include.config")

@extends("app")
@section('contents')
    <div class="container-fluid">
        @if (Session::has('flash_message'))
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"
                style="margin-right: 20px;margin-top: 15px;">&times;</button>
            <div class="alert alert-success"> {{ Session::get('flash_message') }} </div>
        @endif
    </div>
    <div class="page-heading clearfix">
        <h1 class="page-title pull-left">Production</h1><a href="{{ asset('production/create') }}"
            class="btn btn-primary btn-sm btn-add" role="button">Add Production Voucher</a>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">Manage Production</h3>
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
                                    <th>Quantity</th>
                                    <th>Rate</th>
                                    <th>Biller</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sum = 0; ?>
                                @if(isset($sales))
                                @foreach ($sales as $sale)
                                   
                                        <?php $sum = $sum + 1; ?>
                                        <tr>
                                            <td class="center">{{ $sum }}</td>
                                            <td class="center">{{ date('d/m/Y', strtotime($sale->date)) }}</td>
                                            <td class="center">{{ $sale->vr_no }}</td>


                                            <td class="center">
                                                @if ($sale->products != null)
                                                    {{ $sale->products->product_name }}
                                                @endif
                                            </td>
                                            <td class="center">{{ $sale->quantitys }} {{ $sale->uoms->uom }}</td>
                                            <td class="center">{{ $sale->rates }}</td>
                                            <td class="center">
                                                @if ($sale->billers != null)
                                                    {{ $sale->billers->name }}
                                                @endif
                                            </td>

                                            <td>
                                                <a href="production/{{ $sale->id }}" target="__blank"
                                                    style="color:white;">
                                                    <button class="btn btn-info" type="button"> <i class="icon-print"
                                                            title="Print Invoice"></i></button></a>
                                                <!-- <a href="{{ asset('/production/salestaxpdf') }}/{{ $sale->id }}" style="color:white;"><button class="btn btn-danger" type="button"> <i class="fa fa-file-pdf-o" title="Print PDF"></i></button></a> -->

                                                <button class="openModel btn btn-black" id="editmodals" data-toggle="modal"
                                                    data-id="{{ $sale->id }}" data-vr_no="{{ $sale->vr_no }}"
                                                    data-date="{{ $sale->date }}"
                                                    data-products_id="{{ $sale->products_id }}"
                                                    data-uoms_id="{{ $sale->uoms_id }}"
                                                    data-quantitys="{{ $sale->quantitys }}"
                                                    data-rates="{{ $sale->rates }}" data-amounts="{{ $sale->amounts }}"
                                                    data-target="#myModal" onclick="EditClicks({{ $sale->id }})"
                                                    type="button"> <i class="fa fa-edit"
                                                        title="Edit Record"></i></button>
                                                <a href="javascript:checkDelete({{ $sale->id }}, 'production/{{ $sale->id }}/destroy', 'production');">
                                                    <button class="btn btn-red" type="button"> <i class="icon-trash"
                                                            title="Delete Invoice"></i></button></a>
                                            </td>
                                        </tr>
                                   
                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Sr#</th>
                                    <th>Date</th>
                                    <th>Voucher#</th>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Rate</th>
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
