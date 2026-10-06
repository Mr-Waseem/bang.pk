@extends("app")
@section("head")
<link href="/css/plugins/datatables/jquery.dataTables.css" rel="stylesheet">
<link href="/js/plugins/datatables/extensions/Buttons/css/buttons.dataTables.css" rel="stylesheet">
<style>
.html5buttons{display:none;}
</style>
@stop
@section("contents")
<div class="container-fluid">
	@if (Session::has('flash_message'))
		 <div class="alert alert-success alert-dismissible fade in">
 			<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right: 4%;">&times;</a>
 			<strong>Success!</strong> {{ Session::get('flash_message') }}
  		</div>
	@endif
</div>
	<div class="row">
	<div class="col-sm-5">
	<div class="page-heading clearfix">
		<h1 class="page-title pull-left">Manage Cash Receipt</h1><a href="/cash-receipts/create" class="btn btn-primary btn-sm btn-add" role="button">Add Cash Receipt</a>
	</div>
	</div>
	<div class="col-sm-3">
		<div class="page-heading clearfix">
			
		</div>
	</div>
	<!-- <div class="col-sm-4">
		
			<a href="products/print" target="__blank" class="btn btn-default btn-md">
			  <span class="glyphicon glyphicon-print"></span> Print 
			</a>
			<a href="products/pdf" class="btn btn-danger btn-md">
			  <span class="glyphicon glyphicon-save-file"></span> PDF 
			</a>
			<a href="products/downloadExcel" class="btn btn-success btn-md">
			  <span class="glyphicon glyphicon-file"></span> Excel 
			</a>
			
		
	</div> -->
</div>
<ol class="breadcrumb breadcrumb-2"> 
	<li><a href="
	/dashboard"><i class="fa fa-home"></i>Home</a></li> 
	<!-- <li><a href="/products">Products</a></li> --> 
	<li class="parties"><strong>Cash Receipt</strong></li> 
</ol>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading clearfix">
				<h3 class="panel-title">Manage Cash Receipt</h3>
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
						<th>Serial#</th>
						  <th>Date</th>
						  <th>V.No</th>
						  <th>Amount</th>
						  <th>Type</th>
						  <th>Print</th>
						  <th>Actions</th>
						</tr>
					</thead>
				 <tbody>
			  <?php $sum = 1; ?>
	@foreach($Vouchers as $Voucher)
<?php $Totoldebit=0;?>
<tr>
	<td><?php echo $sum; ?></td>
	<td class="center">{{date("d/m/Y", strtotime($Voucher->voucher_date))}}</td>
	<td class="center">{{$Voucher->voucher_no}}</td>
	@foreach($Voucher->voucher_details as $data)
	<?php $Totoldebit = $Totoldebit+$data->debit; ?>
	@endforeach
	<td class="center">{{$Totoldebit}}</td>
	<td class="center">{{$Voucher->v_type}}</td>
	<!-- <td class="center">{{$Voucher->narration}}</td>
	<td class="center">{{$Voucher->debit}}</td>
	<td class="center">{{$Voucher->credit}}</td> -->
	<td class="size-80 text-center">
		<div class="row">
			<a href="/cash-receipts/{{$Voucher->id}}" target="__blank" style="color:white;">
			<button class="btn btn-info" type="button"> <i class="icon-print" title="Print Invoice"></i></button></a>
			
		</div>
	</td>

	<td class="size-80 text-center">
		
			<a href="/cash-receipts/{{$Voucher->id}}/edit" style="color:white;">
				<button class="btn btn-black" data-toggle="modal" data-target="#myModal" type="button"> <i class="fa fa-paste" title="Edit Invoice"></i></button></a>

			<a href="javascript:checkDelete({{ $Voucher->id }}, '/cash-receipts/{{ $Voucher->id }}/destroy', '/cash-receipts');" target="__blank">
			<button class="btn btn-red" type="button"> <i class="icon-trash" title="Delete Voucher"></i></button></a>
		
	</td>
</tr>
<?php $sum = $sum + 1;?>
@endforeach
  </tbody>
	<tfoot>
		<tr>
		  <th>Serial#</th>
		  <th>Date</th>
		  <th>V.No</th>
		  <th>Amount</th>
		  <th>Type</th>
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