@include("/include.config")

@extends("app")
@section("head")
<link href="/css/plugins/datatables/jquery.dataTables.css" rel="stylesheet">
<link href="/js/plugins/datatables/extensions/Buttons/css/buttons.dataTables.css" rel="stylesheet">
@stop
@section("contents")
			<div class="container-fluid">
				@if (Session::has('flash_message'))
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="margin-right: 20px;margin-top: 15px;">&times;</button>
					<div class="alert alert-success"> {{ Session::get('flash_message') }} </div>
				@endif
			</div>
			<div class="page-heading clearfix">
				<h1 class="page-title pull-left">Repairing</h1><a href="repairing/create" class="btn btn-primary btn-sm btn-add" role="button">Add Repairing</a>
			</div>
			<!--
			<div class="btn-group" style="float: right; margin-top: -32px;">
				<a href="parties/create" class="btn btn-primary btn-sm btn-add" role="button">Excel</a>
				<a href="parties/create" class="btn btn-primary btn-sm btn-add" role="button">PDF</a>
				<a href="parties/create" class="btn btn-primary btn-sm btn-add" role="button">Print</a>
		  </div>
		  --->
			<!-- Breadcrumb -->
			<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="
				/dashboard"><i class="fa fa-home"></i>Home</a></li> 
				<li><a href="/repairing">Repairing</a></li> 
				<li class="active"><strong>Repairing</strong></li> 
			</ol>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">Manage Repairing</h3>
							<ul class="panel-tool-options"> 
								<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
								<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
								<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
							</ul>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover dataTables-example" >
									<thead>
										<tr>
											  <th>Date</th>
											  <th>Reference No</th>
											  <th>Customer</th>
					
											  <th>Quantity</th>
											  <th>Charges</th>
											  <th>Actions</th>
										</tr>
									</thead>
									 <tbody>
						  @foreach($sales as $sale)
							<tr>
								<td class="center">{{date('d-m-y', strtotime($sale->date))}}</td>
								<td class="center">{{$sale->reference_no}}</td>
								<td class="center">{{$sale->parties->party_name}}</td>
								<?php $quantity = 0; $charges = 0; $grandtotal = 0; ?>
								@foreach($sale->repairing_details as $details)
									
									<?php $quantity = $quantity + $details->quantity;
										  $charges = $charges + $details->charges;
										  $grandtotal = $grandtotal + $details->total_cost;
									?>
								@endforeach
								<td class="center">{{$quantity}}</td>
								<td class="center">{{$charges}}</td>
								<td class="size-80 text-center">
									<div class="dropdown">
										<a class="more-link" data-toggle="dropdown" href="#/"><i class="icon-dot-3 ellipsis-icon"></i></a>
										<ul class="dropdown-menu dropdown-menu-right">
											<li><a href="/repairing/{{$sale->id}}">Invoice</a></li>
											<li><a href="/repairing/print/{{$sale->id}}">Print Invoice</a></li>
											<!--<li><a href="/repairing/{{$sale->id}}/edit">Edit</a></li>
											<li><a href="javascript:checkDelete({{ $sale->id }}, '/repairing/{{ $sale->id }}/destroy', '/repairing');">Delete</a> </li>--->
										</ul>
									</div>
								</td>
							</tr>
						  
						  @endforeach
						  </tbody>
									<tfoot>
										<tr>
											  <th>Date</th>
											  <th>Reference No</th>
											  <th>Customer</th>
											  <th>Quantity</th>
											  <th>Charges</th>
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

@section("scripts")
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
</script>

@stop