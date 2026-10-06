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
				<h1 class="page-title pull-left">Parties Ledger</h1><a href="ledger/create" class="btn btn-primary btn-sm btn-add" role="button">Add New</a>
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
			<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
			<li><a href="/ledger">Parties Ledger</a></li> 
			<li class="/ledger/create"><strong>Create</strong></li> 
		</ol>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">Parties Ledgers</h3>
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
											 <th>Serial#</th>
											  <th>Party&nbsp;Name</th>
											  <th>Ledger</th>
											 <th>Print</th>
										</tr>
									</thead>
									 <tbody>
						  <?php $sum = 1; ?>
						  @foreach($ledger as $ledgers)
							<tr>
								<td><?php echo $sum; ?></td>
								<td class="center">{{$ledgers->party_name}}</td>
								<td class="center"><a href="/ledger/{{$ledgers->id}}" target="__blank" role="button" class="btn btn-success">View Ledger</a></td>
								<td class="center"><a href="/ledger/print/{{$ledgers->id}}" target="__blank" role="button" class="btn btn-info">Print Ledger</a></td>
								<!-- <td class="size-80 text-center">
									<div class="dropdown">
										<a class="more-link" data-toggle="dropdown" href="#/"><i class="icon-dot-3 ellipsis-icon"></i></a>
										<ul class="dropdown-menu dropdown-menu-right">
											<li><a href="/expenses/{{$ledgers->id}}/edit">Edit</a></li>
											<li><a href="javascript:checkDelete({{ $ledgers->id }}, '/expenses/{{ $ledgers->id }}/destroy', '/expenses');">Delete</a> </li>
										</ul>
									</div>
								</td> -->
							</tr>
							<?php $sum = $sum + 1;?>
						  @endforeach
						  </tbody>
									<tfoot>
										<tr>
											  <th>Serial#</th>
											  <th>Party&nbsp;Name</th>
											  <th>Ledger</th>
											  <th>Print</th>
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