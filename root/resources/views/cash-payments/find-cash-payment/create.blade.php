@extends("app")
@section('contents')
    <!-- <h1 class="page-title">Find Sale Bill</h1>
      
       <ol class="breadcrumb breadcrumb-2"> 
        <li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
        <li class="active"><strong>Find Sale Bill</strong></li> 
       </ol> -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">Find Cash Payment</h3>
                    <!-- <ul class="panel-tool-options"> 
            <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
            <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
            <li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
           </ul> -->
                </div>
                <div class="panel-body">

                    @include('errors.validation')
                    {!! Form::open(['url' => 'find-cash-payments', 'class' => 'form-horizontal']) !!}
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Voucher No</label>
                        <div class="col-sm-5">
                            <!-- {!! Form::date('from_date', null, ['id' => 'from_date', 'class' => 'form-control']) !!} -->
                            <input type="text" name="search" id="search" class="form-control">
                        </div>
                    </div>

                    <div class="line-dashed"></div>
                    <center>
                        <div class="form-actions">
                            <button type="submit" name="btnSave" id="btnSave" target="_blank"
                                class="btn btn-primary">Find</button>
                        </div>
                    </center>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">Cash Payment Management</h3>
                    <!-- <ul class="panel-tool-options"> 
            <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
            <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
            <li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
           </ul> -->
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <!--<a href="/purchase-report/print" class="btn btn-warning" role="button" style="float:right;">
           <i class="fa fa-print"></i><span class="bold">Print</span></a>-->
                            <table class="table table-striped table-bordered table-hover dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Sr#</th>
                                        <th>Date</th>
                                        <th>Bill&nbsp;No</th>
                                        <th>Amount</th>
                                        <th>Type</th>
                                        <th>Created.By</th>
                                        <th>Print</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sum = 1; ?>
                                    @if (isset($sales))
                                        @if (count($sales) > 0)
                                            @foreach ($sales as $Voucher)
                                                <?php $Totolcredit = 0; ?>
                                                <tr>
                                                    <td><?php echo $sum; ?></td>
                                                    <td class="center">
                                                        {{ date('d/m/Y', strtotime($Voucher->voucher_date)) }}</td>
                                                    <td class="center">{{ $Voucher->voucher_no }}</td>

                                                    @foreach ($Voucher->voucher_details as $data)
                                                        <?php $Totolcredit = $Totolcredit + (int) $data->credit; ?>
                                                    @endforeach
                                                    <td class="center">{{ $Totolcredit }}</td>
                                                    <td class="center">{{ $Voucher->v_type }}</td>
                                                    <td class="center">
                                                        @if ($Voucher->billers != null)
                                                            {{ $Voucher->billers->name }}
                                                        @endif
                                                    </td>
                                                    <!--<td class="center">{{ $Voucher->debit }}</td>
     <td class="center">{{ $Voucher->credit }}</td> -->
                                                    <td class="size-80 text-center">
                                                        <div class="row">
                                                            <a href="{{ asset('cash-payments') }}/{{ $Voucher->id }}" target="__blank"
                                                                style="color:white;">
                                                                <button class="btn btn-info" type="button"> <i
                                                                        class="icon-print"
                                                                        title="Print Invoice"></i></button></a>

                                                        </div>
                                                    </td>

                                                    <td class="size-80 text-center">

                                                        <a href="{{ asset('cash-payments') }}/{{ $Voucher->id }}/edit"
                                                            style="color:white;">
                                                            <button class="btn btn-black" data-toggle="modal"
                                                                data-target="#myModal" type="button"> <i
                                                                    class="fa fa-paste"
                                                                    title="Edit Invoice"></i></button></a>

                                                        <a
                                                            href="javascript:checkDelete({{ $Voucher->id }}, '/cash-payments/{{ $Voucher->id }}/destroy', '/cash-payments');">
                                                            <button class="btn btn-red" type="button"> <i
                                                                    class="icon-trash"
                                                                    title="Delete Voucher"></i></button></a>

                                                    </td>
                                                </tr>
                                                <?php $sum = $sum + 1; ?>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8" style="color:#FF0000;text-align:center;">No Records Found
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
