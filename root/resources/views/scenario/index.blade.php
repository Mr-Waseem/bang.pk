@extends("app")
@section("head")
<link href="{{asset('css/plugins/datatables/jquery.dataTables.css')}}" rel="stylesheet">
<link href="{{asset('js/plugins/datatables/extensions/Buttons/css/buttons.dataTables.css')}}" rel="stylesheet">
@stop
@section("contents")
<div class="container-fluid">
    @if (Session::has('flash_message'))
        <div class="alert alert-success alert-dismissible show" role="alert" style="position: relative;">
            {{ Session::get('flash_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%); padding: 0.5rem; line-height: 1; background: transparent; border: 0; font-size: 1.5rem;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
</div>
			<div class="page-heading clearfix">
				<h1 class="page-title pull-left">Scenarios</h1><a href="scenarios/create" class="btn btn-primary btn-sm btn-add" role="button">Add New</a>
			</div>
			<!--
			<div class="btn-group" style="float: right; margin-top: -32px;">
				<a href="parties/create" class="btn btn-primary btn-sm btn-add" role="button">Excel</a>
				<a href="parties/create" class="btn btn-primary btn-sm btn-add" role="button">PDF</a>
				<a href="parties/create" class="btn btn-primary btn-sm btn-add" role="button">Print</a>
		  </div>
		  --->
			<!-- Breadcrumb -->
			<!-- <ol class="breadcrumb breadcrumb-2"> 
				<li><a href="
				/dashboard"><i class="fa fa-home"></i>Home</a></li> 
				<li><a href="/taxes">Taxes</a></li> 
				<li class="active"><strong>Tax</strong></li> 
			</ol> -->
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">Manage Scenario</h3>
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
										    <th>Name</th> 
											<th>Sale Type</th>
										    <th>Actions</th>
										</tr>
									</thead>
									 <tbody>
						  <?php $sum = 1; ?>
						  @foreach($taxes as $tax)

							<tr>
								<td><?php echo $sum; ?></td>
								<td class="center">{{$tax->name}}</td>
								<td class="center">{{$tax->sale_type}}</td>
								<td class="size-80 text-center">
									<div class="dropdown">
										<a class="more-link" data-toggle="dropdown" href="#/"><i class="icon-dot-3 ellipsis-icon"></i></a>
										<ul class="dropdown-menu dropdown-menu-right">
										<li><a href="{{ asset('scenarios/' . $tax->id . '/edit') }}">Edit</a>
										</li>
											<li><a href="{{ asset('scenarios/' . $tax->id . '/destroy') }}">Delete</a> </li>
										</ul>
									</div>
								</td>
							</tr>
							<?php $sum = $sum + 1;?>
						  @endforeach
						  </tbody>
									<tfoot>
									<th>Serial #</th>
										    <th>Name</th> 
											<th>Sale Type</th>
										    <th>Actions</th>
									</tfoot>
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
</script>

@stop