@extends("app")
@section("head")
<link href="{{asset('/css/plugins/datatables/jquery.dataTables.css')}}" rel="stylesheet">
<link href="{{asset('/js/plugins/datatables/extensions/Buttons/css/buttons.dataTables.css')}}" rel="stylesheet">
@stop
@section("contents")
<div class="row">
	<div class="col-sm-5">
	<div class="page-heading clearfix">
	<h1 class="page-title pull-left">User Roles</h1> <a href="{{asset('/roles/create')}}" class="btn btn-primary btn-sm btn-add" role="button">Add User</a>
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
<ol class="breadcrumb breadcrumb-2"> 
	<li><a href="
	{{asset('/dashboard')}}"><i class="fa fa-home"></i>Home</a></li> 
	<li class="active"><strong>User Management</strong></li> 
</ol>
<div class="row">
	<div class="col-lg-12">
	<div class="panel panel-default">
	<div class="panel-heading clearfix">
		<h3 class="panel-title">User Management</h3>
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
			<th>User&nbsp;Code</th>
			<th>Store&nbsp;Name</th>
			<th>Email</th>
			<th>Address</th>
			<th>User</th>
			<th>Author</th>
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
	<td>{{$user->code}}</td>
	<td>{{$user->store_name}}</td>
	<td> {{ $user->email}} <input type="hidden" name="email" value="{{$user->email}}"></td>
	<td>{{$user->address}}</td>
	<td> <input type="checkbox" {{ $user->hasRole('Student') ? 'checked' : ''}} name="role_student"> </td>
	<td> <input type="checkbox" {{ $user->hasRole('Teacher') ? 'checked' : ''}} name="role_teacher"> </td>
	<td> <input type="checkbox" {{ $user->hasRole('Admin') ? 'checked' : ''}} name="role_admin"> </td>
	{{ csrf_field() }}
	<td><button type="submit" class="btn btn-warning btn-md" style="color:white;">Assign Roles</button></td>
	<td><a href="javascript:checkDelete({{$user->id}}, '/roles/{{$user->id }}/destroy', '/roles');" target="__blank">
	<button class="btn btn-red" type="button"> <i class="icon-trash" title="Delete Invoice"></i></button></a></td>
{!! Form::close() !!}
</tr>
<?php $sum = $sum + 1; ?>
@endforeach
	  </tbody>
		<tfoot>
			<tr>
				<th>User&nbsp;Code</th>
				<th>Store&nbsp;Name</th>
				<th>Email</th>
				<th>Address</th>
				<th>User</th>
				<th>Author</th>
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
<script src="{{asset('/js/jquery.min.js')}}"></script>
<!--<script src="/js/bootstrap.min.js"></script>
<script src="/js/plugins/metismenu/jquery.metisMenu.js"></script>
<script src="/js/plugins/blockui-master/jquery-ui.js"></script>
<script src="/js/plugins/blockui-master/jquery.blockUI.js"></script>
<script src="/js/functions.js"></script>
--->
<script src="{{asset('/js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/js/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('/js/plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('/js/plugins/datatables/jszip.min.js')}}"></script>
<script src="{{asset('/js/plugins/datatables/pdfmake.min.js')}}"></script>
<script src="{{asset('/js/plugins/datatables/vfs_fonts.js')}}"></script>
<script src="{{asset('/js/plugins/datatables/extensions/Buttons/js/buttons.html5.js')}}"></script>
<script src="{{asset('/js/plugins/datatables/extensions/Buttons/js/buttons.colVis.js')}}"></script>
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