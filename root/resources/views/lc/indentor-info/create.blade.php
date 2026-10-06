@extends("app")
@section("head")
<link href="/css/plugins/datatables/jquery.dataTables.css" rel="stylesheet">
<link href="/js/plugins/datatables/extensions/Buttons/css/buttons.dataTables.css" rel="stylesheet">
<style>
.html5buttons{display:none;}
</style>
@stop
@section("contents")
<h1 class="page-title">Add Indentor</h1>
<div class="container-fluid">
@if (Session::has('flash_message'))
	 <div class="alert alert-success alert-dismissible fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right: 4%;">&times;</a>
			<strong>Success!</strong> {{ Session::get('flash_message') }}
		</div>
@endif
</div>
<!-- Breadcrumb -->
<ol class="breadcrumb breadcrumb-2"> 
	<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
	<li class="active"><strong>Add Indentor</strong></li> 
</ol>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading clearfix">
				<h3 class="panel-title">Add Indentor</h3>
			</div>
			<div class="panel-body">
				@include('errors.validation')
				{!! Form::open(['url' => 'indentor-info', 'class' => 'form-horizontal' ]) !!}
					<div class="form-group"> 
						<label class="col-sm-3 control-label">Indentor Name</label>
						<div class="col-sm-5"> 
						{!! Form::text('indentor_name', null, ['id' => 'indentor_name','class'=>'form-control',]) !!}
						</div> 
					</div>
				
					<div class="line-dashed"></div>
					<center><div class="form-actions">
				  <button type="submit" class="btn btn-primary">Save</button>
				</div></center>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading clearfix">
				<h3 class="panel-title">Indentor Management</h3>
				<!-- <ul class="panel-tool-options"> 
					<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
					<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
					<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
				</ul> -->
			</div>
			<div class="panel panel-default">
			<div class="panel-body">
				<div class="table-responsive">
				<!--<a href="/purchase-report/print" class="btn btn-warning" role="button" style="float:right;">
				<i class="fa fa-print"></i><span class="bold">Print</span></a>-->
					<table class="table table-striped table-bordered table-hover dataTables-example" >
						<thead>
							<tr>	
							  <th>Serial#</th>
							  <th>Indentor&nbsp;Name</th>
							  <th>Action</th>
							  <th>Action</th>
							</tr>
							</tr>
						</thead>
						 <tbody>
						 <?php $total = 1; ?>
						 @if(isset($indentors))
							 @if(count($indentors) > 0)
								@foreach($indentors as $indentor)
									<tr>
										<td>{{$total}}</td>
										<td>{{ $indentor->indentor_name }}</td>
										
										<td class="size-80 text-center">
											
												<a href="/indentor-info/{{$indentor->id}}/edit" style="color:white;">
												<button class="btn btn-black" type="button"> <i class="fa fa-paste" title="Edit Indentor"></i></button></a>
												
											
										</td>
										<td class="size-80 text-center">
											
												
												<a href="javascript:checkDelete({{ $indentor->id }}, '/indentor-info/{{ $indentor->id }}/destroy', '/indentor-info/create');" target="__blank">
												<button class="btn btn-red" type="button"> <i class="icon-trash" title="Delete Indentor"></i></button></a>
											
										</td>
										<?php $total = $total + 1; ?>
									</tr>
								@endforeach
							 @endif	
							 @else
								<tr><td colspan="7" style="color:#FF0000;text-align:center;">No purchases found</td></tr>
							 @endif
						 </tbody>
					</table>
				</div>
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
