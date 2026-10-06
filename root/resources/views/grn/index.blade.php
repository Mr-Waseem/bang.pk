@include("/include.config")

@extends("app")
@section("head")
<link href="{{asset('css/plugins/datatables/jquery.dataTables.css')}}" rel="stylesheet">
<link href="{{asset('js/plugins/datatables/extensions/Buttons/css/buttons.dataTables.css')}}" rel="stylesheet">
<style>
	.badge-info{
		color: #ffffff;
	}
    /* Custom styling for a beautiful table */
    .panel {
        border: none;
        box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
        border-radius: 8px;
    }
    
    .panel-heading {
        background: linear-gradient(120deg, #4b6cb7 0%, #182848 100%);
        color: white;
        border-radius: 8px 8px 0 0;
        padding: 15px 20px;
    }
    
    .panel-title {
        font-weight: 600;
        font-size: 18px;
    }
    
    .table thead th {
        background-color: #f8f9fa;
        color: #495057;
        font-weight: 600;
        border-bottom: 2px solid #e9ecef;
        padding: 12px 15px;
    }
    
    .table tbody td {
        padding: 12px 15px;
        vertical-align: middle;
    }
    
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0, 0, 0, 0.02);
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(75, 108, 183, 0.06);
    }
    
    .btn-action {
        padding: 5px 10px;
        margin: 0 3px;
        border-radius: 4px;
        font-size: 13px;
    }
    
    .btn-print {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }
    
    .btn-edit {
        background-color: #343a40;
        border-color: #343a40;
    }
    
    .btn-delete {
        background-color: #dc3545;
        border-color: #dc3545;
    }
    
    .badge-status {
        padding: 5px 10px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }
    
    /* .page-heading {
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eaeaea;
    } */
    
    .btn-add {
        border-radius: 6px;
        padding: 8px 20px;
        font-weight: 500;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }
    
    .dataTables_wrapper {
        padding: 0;
    }
    
    .alert-success {
        border-left: 4px solid #28a745;
        border-radius: 0 4px 4px 0;
    }
</style>
@stop
@section("contents")
<div class="container-fluid">
    @if (Session::has('flash_message'))
        <div class="alert alert-success alert-dismissible fade show mt-3">
            {{ Session::get('flash_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
</div>
<div class="page-heading clearfix">
    <h1 class="page-title pull-left"><i class="fa fa-truck mr-2"></i>Manage GRN's</h1>
    <a href="grn/create" class="btn btn-primary btn-sm btn-add pull-right" role="button">
        <i class="fa fa-plus mr-1"></i> Add GRN
    </a>
</div>

<!-- Breadcrumb -->
<!-- <ol class="breadcrumb breadcrumb-2"> 
    <li><a href="/dashboard"><i class="fa fa-home"></i> Home</a></li> 
    <li class="active"><strong>Manage Delivery Challans</strong></li> 
</ol> -->

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <h3 class="panel-title"><i class="fa fa-list mr-2"></i>GRN's List</h3>
            </div>
            
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                            <tr>
                                <th width="5%">Sr#</th>
                                <th width="15%">VR#</th>
                                <th width="15%">Date</th>
                                <th width="25%">Account</th>
                                <th width="10%">Quantity</th>
                                <th width="15%">Status</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchases as $purchase)
                            @if($purchase->dcn_no != "0")
                            <tr>
                                <td class="text-center">{{$loop->iteration}}</td>
                                <td class="font-weight-bold">{{$purchase->vr_no}}</td>
                                <td>{{date("d/m/Y", strtotime($purchase->date))}}</td>
                                <td>
                                    @if($purchase->parties != null)
                                    {{$purchase->parties->party_name}}
                                    @else
                                    <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <?php 
                                    $Quantity = 0; 
                                    foreach($purchase->challan_details as $details) {
                                        $Quantity += (int)$details->quantity;
                                    }
                                ?>
                                <td class="text-center">{{$Quantity}}</td>
                                <td class="text-center">
									@if($purchase->status == 0)
                                    <span class="badge-status badge-info">Pending</span>
									@else
                                    <span class="badge-status badge-success">Completed</span>
									@endif
                                    
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="grn/print/{{$purchase->id}}" target="_blank" class="btn btn-action btn-print" title="Print" style="color: #ffffff;">
                                            <i class="fa fa-print"></i>
                                        </a>
                                        <a href="grn/{{$purchase->id}}/edit" class="btn btn-action btn-edit" title="Edit" style="color: #ffffff;">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0);" onclick="checkDelete({{ $purchase->id }}, 'grn/{{ $purchase->id }}/destroy', 'grn');" class="btn btn-action btn-delete" title="Delete" style="color: #ffffff;">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section("scripts")
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<!-- <script src="{{asset('js/plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js')}}"></script> -->
<!-- <script src="{{asset('js/plugins/datatables/jszip.min.js')}}"></script>
<script src="{{asset('js/plugins/datatables/pdfmake.min.js')}}"></script>
<script src="{{asset('js/plugins/datatables/vfs_fonts.js')}}"></script> -->
<!-- <script src="{{asset('js/plugins/datatables/extensions/Buttons/js/buttons.html5.js')}}"></script> -->
<!-- <script src="{{asset('js/plugins/datatables/extensions/Buttons/js/buttons.colVis.js')}}"></script> -->
<script>
	$(document).ready(function () {
		$('.dataTables-example').DataTable({
			dom: '<"html5buttons" B>lTfgitp',
			buttons: [
				{
					extend: 'copyHtml5',
					exportOptions: {
						columns: [ 0, ':visible' ]
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
						columns: [ 0, 1, 2, 3, 4 ]
					}
				},
				'colvis'
			]
		});
	});

    
    function checkDelete(id, url, redirect) {
        if (confirm('Are you sure you want to delete this delivery challan?')) {
            window.location.href = url;
        }
    }
</script>
@stop