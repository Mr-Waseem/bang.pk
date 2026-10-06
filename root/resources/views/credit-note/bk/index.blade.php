@include("/include.config")

@extends("app")
@section('head')
    <link href="/css/plugins/datatables/jquery.dataTables.css" rel="stylesheet">
    <link href="/js/plugins/datatables/extensions/Buttons/css/buttons.dataTables.css" rel="stylesheet">
@stop
@section('contents')
    {{-- <div class="container-fluid">
        @if (Session::has('flash_message'))
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"
                style="margin-right: 20px;margin-top: 15px;">&times;</button>
            <div class="alert alert-success"> {{ Session::get('flash_message') }} </div>
        @endif
    </div> --}}
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
        <h1 class="page-title pull-left">Credit Note</h1><a href="{{ asset('credit-note/create') }}" class="btn btn-primary btn-sm btn-add"
            role="button">Add Credit Note</a>
    </div>
    <ol class="breadcrumb breadcrumb-2">
        <li><a href="
     {{ asset('dashboard') }}"><i class="fa fa-home"></i>Home</a></li>
        <!-- <li><a href="/sales">Sales</a></li>  -->
        <li class="active"><strong>Sales Tax</strong></li>
    </ol>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <h3 class="panel-title">Manage Credit Notes</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <form method="get" action="credit-note/multidelete">
                            <button type="submit" id="saveButton" class="btn btn-danger" style="margin-bottom:10px">DELETE</button>
                        <table class="table table-striped table-bordered table-hover dataTables-example">
                            <thead>
                                <tr>
                                    
                                        <th>
                                            <input type="checkbox" id="checkall" name="checkall"  onchange="selects();">
                                        </th>
                                    
                                    <th>Sr#</th>
                                    <th>Date</th>
                                    <th style="display:none;">DC#</th>
                                    <th>Inv#</th>
                                    <th>Tax&nbsp;Value</th>
                                    <!-- <th>Ex.Tax&nbsp;Value</th> -->
                                    <th>Total</th>
                                    <th>Grand Total</th>
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
                                            <td>
                                                <input type="checkbox" id="Dltid" name="Dltid[]" value="{{$sale->id}}">
                                            </td>
                                            <td class="center">{{ $sum }}</td>
                                            <td class="center">{{ date('d/m/Y', strtotime($sale->date)) }}</td>
                                            <td style="display:none;" class="center">{{ $sale->dcn_no }}</td>
                                            <td class="center">{{ $sale->invoice_no }}</td>

                                            <?php $total = 0;
                                            $discount = 0;
                                            $tax = 0;
                                            $extratax = 0;
                                            $grandtotal = 0; ?>
                                            @foreach ($sale->saletax_details as $details)
                                                <?php
                                                $total = $total + (int) $details->rate * (int) $details->quantity;
                                                //$discount = $discount + (($details->discount/100)*(int)$details->quantity*(int)$details->unit_cost);
                                                $tax = $tax + (int) $details->taxvalue;
                                                $extratax = $extratax + (int) $details->extraTaxValue;
                                                $grandtotal = $grandtotal + (int) $details->total;
                                                ?>
                                            @endforeach
                                            <td class="center">{{ (int) $tax }}</td>
                                            <!-- <td class="center">{{ (int) $extratax }}</td> -->
                                            <td class="center">{{ (int) $total }}</td>
                                            <!-- <td class="center">{{ $discount }}</td> -->
                                            <td class="center">{{ (int) $grandtotal }}</td>
                                            <td class="center">
                                                @if ($sale->parties != null)
                                                    {{ $sale->parties->party_name }}
                                                @endif
                                            </td>
                                            <td class="center">
                                                @if ($sale->parties != null)
                                                    {{ $sale->parties->ntn }}
                                                @endif
                                            </td>
                                            <td>
                                                <a style="display:none;"href="{{ asset('credit-note/dcn') }}/{{ $sale->id }}" target="_blank"
                                                    style="color:white;">
                                                    <button class="btn btn-primary" type="button">DC</button></a>
                                                <a  href="{{ asset('credit-note/print') }}/{{ $sale->id }}" target="_blank"
                                                    style="color:white;">
                                                    <button class="btn btn-info" type="button"> <i class="icon-print"
                                                            title="Print Credit Note"></i></button></a>
                                                <!-- <a href="{{ asset('/credit-note/credit-note-pdf') }}/{{ $sale->id }}"
                                                    style="color:white;"><button class="btn btn-danger" type="button"> <i
                                                            class="fa fa-file-pdf-o" title="Print PDF"></i></button></a> -->
                                            </td>
                                            <td class="size-80 text-center">
                                                <div class="row">
                                                    <a  style="display:none;"href="{{ asset('credit-note') }}/{{ $sale->id }}/edit" target="_blank"
                                                        style="color:white;">
                                                        <button class="btn btn-black" type="button"> <i
                                                                class="fa fa-paste"
                                                                title="Edit Invoice"></i></button></a>
                                                    {{-- <a
                                                        href="javascript:checkDelete({{ $sale->id }}, '{{ asset('credit-note') }}/{{ $sale->id }}/destroy', '{{ asset('credit-note') }}');"> --}}
                                                    <a
                                                        href="{{ asset('credit-note') }}/{{ $sale->id }}/destroy">
                                                        <button class="btn btn-red" type="button" onclick="return confirm('Are you sure you want to Delete this Record?')"> <i
                                                                class="icon-trash"
                                                                title="Delete Note"></i></button></a>
                                                </div>
                                                <!-- <div class="dropdown">
         <a class="more-link" data-toggle="dropdown" href="#/"><i class="icon-dot-3 ellipsis-icon"></i></a>
         <ul class="dropdown-menu dropdown-menu-right">
          <li><a href="/sales/{{ $sale->id }}" target="__blank">Invoice</a></li>
          <li><a href="/sales/print/{{ $sale->id }}" target="__blank">Print Invoice</a></li>
          <li><a href="/sales/{{ $sale->id }}/edit">Edit</a></li>
          <li><a href="javascript:checkDelete({{ $sale->id }}, '/sales/{{ $sale->id }}/destroy', '/sales');">Delete</a> </li>
         </ul>
        </div> -->
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>
                                        {{-- <input type="checkbox" id="checkall" name="checkall"  onchange="selects();"> --}}
                                    </th>
                                    <th>Sr#</th>
                                    <th>Date</th>
                                    <th style="display:none;">DC#</th>
                                    <th>Invoice No</th>
                                    <!-- <th>Biller</th> -->
                                    <!-- <th>Sale&nbsp;Type</th> -->
                                    <th>Tax&nbsp;Value</th>
                                    <!-- <th>Ex.Tax&nbsp;Value</th> -->
                                    <th>Total</th>
                                    <!--<th>Product Tax</th>-->
                                    <th>Grand Total</th>
                                    <th>Party</th>
                                    <th>Party&nbsp;NTN</th>
                                    <th>Print</th>
                                    <th>Actions</th>
                                </tr>
                            </tfoot>
                        </table>
                        </form>
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
        function selects(){
     
     var check =  document.getElementsByName('checkall');
     if(check[0].checked==false){
      // alert('in');
      var ele=document.getElementsByName('Dltid[]');
                  // alert(ele);  
                  for(var i=0; i<ele.length; i++){  
                      if(ele[i].type=='checkbox') 
                      // alert(ele[i]);
                          ele[i].checked=false;  
                  }  
     }
    else{
      var ele=document.getElementsByName('Dltid[]');
                  // alert(ele);  
                  for(var i=0; i<ele.length; i++){  
                      if(ele[i].type=='checkbox') 
                      // alert(ele[i]);
                          ele[i].checked=true;  
                  }  
              }
  
    }
    </script>

@stop
