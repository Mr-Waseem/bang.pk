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
	<h1 class="page-title pull-left">Sales</h1><a href="sales/create" class="btn btn-primary btn-sm btn-add" role="button">Add Sale</a>
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
	<li><a href="/sales">Sales</a></li> 
	<li class="active"><strong>Sales</strong></li> 
</ol>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading clearfix" id="panelbg">
				<h3 class="panel-title">Manage Sales</h3>
				<!-- <ul class="panel-tool-options"> 
					<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
					<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
					<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
				</ul> -->
			</div>
			<div class="panel-body">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTables-example" >
						<thead>
						<tr>
							<th>Sr#</th>
							 <th>Date</th>
							  <th>Bill&nbsp;No</th>
							  <!-- <th>Biller</th> -->
							  <!-- <th>Sale&nbsp;Type</th> -->
							  <th>Cost&nbsp;Amount</th>
							  <th>Sale&nbsp;Amount</th>
							  <th>Account&nbsp;Name</th>
							  <th>Print</th>
							  <th>Actions</th>
						</tr>
						</thead>
						 <tbody>
			<?php $sum = 0; ?>
			  @foreach($sales as $sale)
			  <?php $sum = $sum + 1; ?>
				<tr><td class="center">{{$sum}}</td>
					<td class="center">{{date("m/d/Y", strtotime($sale->date))}}</td>
					<td class="center">{{$sale->invoice_no}}</td>
					<?php $total = 0; $CoutAmount = 0; $SaleAmount = 0; $discount = 0;?>
					@foreach($sale->sale_details as $details)
						<?php $total = $total + (int)$details->product_cost * (int)$details->quantity;
						     
							  //$discount = $discount + (($details->discount/100)*$details->quantity*$details->unit_cost);
							  $CoutAmount = $CoutAmount + (int)$details->cost_amount;
							  $SaleAmount = $SaleAmount + (int)$details->sale_amount;
							  
						?>
						
					@endforeach
					<td class="center">{{(int)$total}}</td>
					<td class="center">{{(int)$SaleAmount}}</td>
				
					<!-- <td class="center">{{$discount}}</td> -->
					
					<td class="center">
						@if(($sale->parties)!=null)
							{{$sale->parties->party_name}}
						@endif
					</td>
					<!-- <td class="center">
							@if(($sale->parties)!=null)
								{{$sale->parties->ntn}}
							@endif
						</td> -->
					<td class="size-80 text-center">
						<div class="row">
							<a href="/sales/print/{{$sale->id}}" target="__blank" style="color:white;">
							<button class="btn btn-info" type="button"> <i class="icon-print" title="Print Invoice"></i></button></a>
							<a href="{{asset('/sales/salespdf')}}/{{$sale->id}}" style="color:white;">
							<button class="btn btn-danger" type="button"> <i class="fa fa-file-pdf-o" title="Print PDF"></i></button></a>
							
						</div>
					</td>
					<td class="size-80 text-center">
						<div class="row">
							<a href="/sales/{{$sale->id}}/edit" style="color:white;">
							<button class="btn btn-black" type="button"> <i class="fa fa-paste" title="Edit Invoice"></i></button></a>
							<a href="javascript:checkDelete({{ $sale->id }}, '/sales/{{ $sale->id }}/destroy', '/sales');" target="__blank">
							<button class="btn btn-red" type="button"> <i class="icon-trash" title="Delete Invoice"></i></button></a>
						</div>
					</td>
				</tr>
			  
			  @endforeach
			  </tbody>
						<tfoot>
							<tr>
								<th>Sr#</th>
								 <th>Date</th>
								  <th>Bill&nbsp;No</th>
								  <!-- <th>Biller</th> -->
								  <!-- <th>Sale&nbsp;Type</th> -->
								  <th>Cost&nbsp;Amount</th>
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