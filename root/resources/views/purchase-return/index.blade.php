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
	<h1 class="page-title pull-left">Manage Purchase Returns</h1><a href="purchase-return/create" class="btn btn-primary btn-sm btn-add" role="button">Add Purchase Return</a>
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
	<!-- <li><a href="/purchases">Manage Purchases</a></li>  -->
	<li class="active"><strong>Manage Purchase Returns</strong></li> 
</ol>
<div class="row">
<div class="col-lg-12">
	<div class="panel panel-default">
		<div class="panel-heading clearfix">
			<h3 class="panel-title">Manage Purchase Returns</h3>
			<!--<ul class="panel-tool-options"> -->
			<!--	<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>-->
			<!--	<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>-->
			<!--	<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>-->
			<!--</ul>-->
		</div>
<div class="panel-body">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover dataTables-example" >
			<thead>
				<tr>
					 <th>SR#</th>
					 <th>Date</th>
					  <th>Bill No</th>
					  <th>Account</th>
					  <th>Total</th>
					  <!--<th>Product Tax</th>-->
					  <th>Grand Total</th>
					  <th>Print</th>
					  <th>Actions</th>
				</tr>
			</thead>
			 <tbody>
	<?php $sum = 0; ?>
  @foreach($purchases as $purchase)
  @if($purchase->bill_no!="0")
  <?php $sum = $sum + 1; ?>
	<tr>
		<td>{{$sum}}</td>
		<td class="center">{{date("d-m-Y", strtotime($purchase->date))}}</td>
		<td class="center">{{$purchase->bill_no}}</td>
		@if($purchase->parties != null)
		{{$purchase->parties->party_name}}
		@endif
		<?php $total = 0; $tax = 0; $grandtotal = 0; ?>
		@foreach($purchase->purchase_return_detail as $details)
			<?php $total = $total + (int)$details->unit_cost * (int)$details->quantity;
				  //$tax = $tax + (int)$details->purchase_tax->tax_rate;
				  $grandtotal = $grandtotal + (int)$details->total_cost;
			?>
		@endforeach
		<td class="center">{{(int)$total}}</td>

		<!--<td class="center">{{$tax}}</td>-->
		<td class="center">{{(int)$grandtotal}}</td>
		<td class="size-80 text-center">
			<div class="row">
				<a href="/purchase-return/print/{{$purchase->id}}" target="__blank" style="color:white;">
				<button class="btn btn-info" type="button"> <i class="icon-print" title="Print Invoice"></i></button></a>
				
			</div>
		</td>
		<td class="size-80 text-center">
			<div class="row">
				<a href="/purchase-return/{{$purchase->id}}/edit" style="color:white;">
				<button class="btn btn-black" type="button"> <i class="fa fa-paste" title="Edit Invoice"></i></button></a>
				<a href="javascript:checkDelete({{ $purchase->id }}, '/purchase-return/{{ $purchase->id }}/destroy', '/purchase-return');">
				<button class="btn btn-red" type="button"> <i class="icon-trash" title="Delete Invoice"></i></button></a>
			</div>
		</td>
		<!-- <td class="size-80 text-center">
			<div class="dropdown">
				<a class="more-link" data-toggle="dropdown" href="#/"><i class="icon-dot-3 ellipsis-icon"></i></a>
				<ul class="dropdown-menu dropdown-menu-right">
					<li><a href="/purchases/{{$purchase->id}}" target="__blank">Invoice</a></li>
					<li><a href="/purchases/print/{{$purchase->id}}" target="__blank">Print Invoice</a></li>
					<li><a href="/purchases/{{$purchase->id}}/edit">Edit</a></li>
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
				  <th>Account</th>
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