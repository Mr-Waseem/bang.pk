@extends("app")
@section("head")
<link href="{{asset('css/plugins/datatables/jquery.dataTables.css')}}" rel="stylesheet">
<link href="{{asset('js/plugins/datatables/extensions/Buttons/css/buttons.dataTables.css')}}" rel="stylesheet">
@stop
@section("contents")
			<div class="container-fluid">
				@if (Session::has('flash_message'))
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="margin-right: 20px;margin-top: 15px;">&times;</button>
					<div class="alert alert-success"> {{ Session::get('flash_message') }} </div>
				@endif
			</div>
			<div class="page-heading clearfix">
				<h1 class="page-title pull-left">Partners</h1><a href="partners/create" class="btn btn-primary btn-sm btn-add" role="button">Add New</a>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">Manage Partners</h3>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover dataTables-example" >
									<thead>
										<tr>
											<th>Serial #</th>
											<th>Name</th>
											<th>Email</th>
											<th>Password</th>
											<th>Contact</th>
											<th>Status</th>
										    <th>Actions</th>
										</tr>
									</thead>
									 <tbody>
						  <?php $sum = 1; ?>
						  @foreach($taxes as $tax)

							<tr>
								<td><?php echo $sum; ?></td>
								<td class="center">{{$tax->name}}</td>
								<td class="center">{{$tax->email}}</td>
								<td class="center">{{$tax->show_password}}</td>
								<td class="center">{{$tax->phone}}</td>
								<td class="center">
									@if($tax->type == "ACTIVE")
									<button class="btn btn-sm btn-success py-0 px-2">ACTIVE</button>
									@else
									<button class="btn btn-sm btn-danger py-0 px-2">DEACTIVE</button>
									@endif
								</td>
								<td class="size-80 text-center">
									<div class="dropdown">
										<a class="more-link" data-toggle="dropdown" href="#/"><i class="icon-dot-3 ellipsis-icon"></i></a>
										<ul class="dropdown-menu dropdown-menu-right">
										<li><a href="{{ asset('partners/' . $tax->id . '/edit') }}">Edit</a>
										</li>
											<li><a href="{{ asset('partners/' . $tax->id . '/destroy') }}">Delete</a> </li>
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
											<th>Name</th>
											<th>Email</th>
											<th>Password</th>
											<th>Contact</th>
											<th>Status</th>
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