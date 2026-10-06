@extends("app")
@section("head")
<link href="/css/plugins/datatables/jquery.dataTables.css" rel="stylesheet">
<link href="/js/plugins/datatables/extensions/Buttons/css/buttons.dataTables.css" rel="stylesheet">
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
	<h1 class="page-title pull-left">Employees</h1><a href="{{ asset('employees/create') }}" class="btn btn-primary btn-sm btn-add" role="button">Add Employee</a>
</div>
	</div>
	<!-- <div class="col-sm-3">
		<div class="page-heading clearfix">
			
		</div>
	</div>
	<div class="col-sm-4">
		<a href="parties/print" target="__blank" class="btn btn-default btn-md">
		  <span class="glyphicon glyphicon-print"></span> Print 
		</a>
		<a href="parties/pdf" class="btn btn-danger btn-md">
		  <span class="glyphicon glyphicon-save-file"></span> PDF 
		</a>
		<a href="parties/downloadExcel" class="btn btn-success btn-md">
		  <span class="glyphicon glyphicon-file"></span> Excel 
		</a>
	</div> -->
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
	<!-- <li><a href="/parties">Clients</a></li>  -->
	<li class="active"><strong>Employees</strong></li> 
</ol>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading clearfix">
				<h3 class="panel-title">Manage Employees</h3>
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
								<th>Serial #</th>
							    <th>Employee.ID</th>
							    <th>Employee Name</th>
								<th>Phone</th>
								<th>Salary</th>
								<th>Status</th>
								<th>City</th>
								<th>Address</th>
								<th>Type</th>
							    <th>Actions</th>
							</tr>
						</thead>
						 <tbody>
			  <?php $sum = 1; ?>
			  @foreach($party as $parties)

				<tr>
					<td><?php echo $sum; ?></td>
					<td class="center">{{$parties->code}}</td>
					<td class="center">{{$parties->party_name}}</td>
					<td class="center">{{$parties->phone}}</td>
					<td class="center">{{$parties->salary}}</td>
					<td class="center">{{$parties->employee_status}}</td>
					<td class="center">{{$parties->city}}</td>
					<td class="center">{{$parties->address}}</td>
					<td class="center">{{$parties->name}}</td>
					
					<td class="size-100 text-center">
						<div class="dropdown">
							<a class="more-link" data-toggle="dropdown" href="#/"><i class="icon-dot-3 ellipsis-icon"></i></a>
							<ul class="dropdown-menu dropdown-menu-right">
								<!-- <li><a href="/ledger/{{$parties->id}}" target="__blank">Ledger</a></li>
								<li><a href="/ledger/print/{{$parties->id}}" target="__blank">Print Ledger</a></li> -->
								<li><a href="{{ asset('/employees/'.$parties->id.'/edit') }}">Edit</a></li>
								<li><a onclick="return confirm('Are you sure you want to delete?')"
									href="{{ asset('employees/'.$parties->id.'/destroy') }}">Delete</a> </li>
							</ul>
						</div>
					</td>
				</tr>
				<?php $sum = $sum + 1;?>
			  @endforeach
			  </tbody>
						<tfoot>
							<tr>
								<th>Serial #</th>
								<th>Code</th>
							    <th>Client Name</th>
								<th>Phone</th>
								<th>Salary</th>
								<th>Status</th>
								<th>City</th>
								<th>Address</th>
								<th>Type</th>
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