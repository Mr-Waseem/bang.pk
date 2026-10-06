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
				<h1 class="page-title pull-left">Users Management</h1><a href="roles/create" class="btn btn-primary btn-sm btn-add" role="button">Add User</a>
			</div>
				</div>
				<div class="col-sm-3">
					<div class="page-heading clearfix">
						
					</div>
				</div>
				<!-- <div class="col-sm-4">
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
			<!-- <ol class="breadcrumb breadcrumb-2"> 
				<li><a href="
				/dashboard"><i class="fa fa-home"></i>Home</a></li> 
				<li class="parties"><strong>User Roles</strong></li> 
			</ol> -->
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">User Roles</h3>
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
										<th>Name</th>
										<th>Email</th>
										<th>Password</th>
										<th>Status</th>
										<th>Normal</th>
										<th>Manager</th>
										<th>Admin </th>
										<th>Roles</th>
										<th>Action</th>
										</tr>
									</thead>
									 <tbody>
						  <?php $sum = 0; ?>
				@foreach($users as $user)
				<tr>
					{!! Form::open(['url' => 'roles', 'class'=>'form-horizontal', 'files' => 'true']) !!}
						
							@if($user->status == "company")
							<td><span class="text-primary">{{$user->name}}</span></td>
							<td><span class="text-primary">{{ $user->email}} <input type="hidden" name="email" value="{{$user->email}}"></span></td>
							<td><span class="text-primary">{{ $user->show_password}}</span></td>
							<td><span class="text-primary">{{ $user->type}}</span></td>
							@else
							<td>{{$user->name}}</td>
							<td> {{ $user->email}} <input type="hidden" name="email" value="{{$user->email}}"></td>
							<td> {{ $user->show_password}}</td>
							<td> {{ $user->type}}</td>
							@endif
						</td>
						
						<!-- <td> <input type="checkbox" {{ $user->hasRole('Supervisor') ? 'checked' : ''}} name="role_supervisor"> </td>
						<td> <input type="checkbox" {{ $user->hasRole('Center') ? 'checked' : ''}} name="role_center"> </td>
						<td> <input type="checkbox" {{ $user->hasRole('Driver') ? 'checked' : ''}} name="role_driver"> </td> -->
						<td> <input type="checkbox" {{ $user->hasRole('Editor') ? 'checked' : ''}} name="role_editor"> </td>
						<td> <input type="checkbox" {{ $user->hasRole('Author') ? 'checked' : ''}} name="role_author"> </td>
						<td> <input type="checkbox" {{ $user->hasRole('Admin') ? 'checked' : ''}} name="role_admin"> </td>
						{{ csrf_field() }}
						<td><button type="submit" class="btn btn-warning btn-md" style="color:white;">Assign Roles</button></td>
						<td>
							<a href="roles/{{$user->id}}/edit" style="color:white;">
							<button class="btn btn-black" type="button"> <i class="fa fa-paste" title="Edit User"></i></button></a>
							@if($user->status == "company")
							<button class="btn btn-red">Default</button>
							@else
							<a href="roles/{{$user->id }}/destroy"><button class="btn btn-red" type="button"> <i class="icon-trash" title="Delete Invoice"></i></button></a>
							@endif
						</td>
					{!! Form::close() !!}
				</tr>
				 <?php $sum = $sum + 1; ?>
				@endforeach
						  </tbody>
									<tfoot>
										<tr>
											<th>Name</th>
										<th>Email</th>
										<th>Password</th>
										<th>Status</th>
										<!-- <th>Supervisor</th>
										<th>Center</th>
										<th>Driver</th> -->
										<th>Normal</th>
										<th>Manager</th>
										<th>Admin </th>
										<th>Roles</th>
										<th>Action</th>
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