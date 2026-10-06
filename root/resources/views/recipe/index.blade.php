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
<!-- <div class="row">
	<div class="col-sm-5">
	<div class="page-heading clearfix">
		<h1 class="page-title pull-left">Recipes Information</h1><a href="recipe/create" class="btn btn-primary btn-sm btn-add" role="button">Add New Recipes</a>
	</div>
	</div>
	<div class="col-sm-3">
		<div class="page-heading clearfix">
			
		</div>
	</div>

</div> -->
<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">Add Recipe</h3>
							<!-- <ul class="panel-tool-options"> 
								<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
								<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
								<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
							</ul> -->
						</div>
						<div class="panel-body">
							@include('errors.validation')
							{!! Form::open(['url' => 'recipe', 'class' => 'form-horizontal' ]) !!}
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Recipe Code</label>  
									<div class="col-sm-5"> 
									{!! Form::text('code', null, ['id' => 'code','class'=>'form-control',]) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Recipe Name</label>  
									<div class="col-sm-5"> 
									{!! Form::text('name', null, ['id' => 'name','class'=>'form-control',]) !!}
									</div> 
								</div>
								
								<div class="line-dashed"></div>
								<center><div class="form-actions">
							  <button type="submit" class="btn btn-primary">Save Recipe</button>
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
				<h3 class="panel-title">Manage Recipes</h3>
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
							  <th>Code</th>
							  <th>Recipe&nbsp;Name</th>
							  <th>Actions</th>
							</tr>
						</thead>
						 <tbody>
			  <?php $sum = 1; ?>
			  @foreach($recipe as $recipes)
				<tr>
					<td><?php echo $sum; ?></td>
					<td class="center">{{$recipes->code}}</td>
					<td class="center">{{$recipes->name}}</td>
					<td class="size-85">
						<div class="row">
							&nbsp;<a href="#" style="color:white; padding-left: 2%;">
							<button class="openModel btn btn-black" data-toggle="modal" data-id="{{$recipes->id}}" 
							data-code="{{$recipes->code}}"
							data-name="{{$recipes->name}}"
							data-target="#myModal" type="button"> <i class="fa fa-paste" title="Edit Record"></i></button></a>&nbsp;

							<a href="javascript:checkDelete({{ $recipes->id }}, '/recipe/{{ $recipes->id }}/destroy', '/recipe');">
							<button class="btn btn-red" type="button"> <i class="icon-trash" title="Delete Record"></i></button></a>
						</div>
					</td>
					<!-- <td class="size-80 text-center">
						<div class="dropdown">
							<a class="more-link" data-toggle="dropdown" href="#/"><i class="icon-dot-3 ellipsis-icon"></i></a>
							<ul class="dropdown-menu dropdown-menu-right">
								<li><a href="/recipe/{{$recipes->id}}/edit">Edit</a></li>
								<li><a href="javascript:checkDelete({{ $recipes->id }}, '/recipe/{{ $recipes->id }}/destroy', '/recipe');">Delete</a> </li>
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
							  <th>Code</th>
							  <th>Recipe&nbsp;Name</th>
							  <th>Actions</th>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

			<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Division</h4>
      </div>
      <div class="modal-body">
     
        {!! Form::model($recipes->id, ['method' => 'PATCH', 'action' => ['RecipeController@update', $recipes->id], 'class' => 'form-horizontal' ]) !!}

        	{!! Form::hidden('id', null, ['id' => 'id','class'=>'form-control',]) !!}
			<div class="form-group"> 
			<label class="col-sm-3 control-label">Recipe Code</label>  
			<div class="col-sm-5"> 
			{!! Form::text('code', null, ['id' => 'code','class'=>'form-control',]) !!}
			</div> 
		</div>
		<div class="form-group"> 
			<label class="col-sm-3 control-label">Recipe Name</label>  
			<div class="col-sm-5"> 
			{!! Form::text('name', null, ['id' => 'name','class'=>'form-control',]) !!}
			</div> 
		</div>
			<!-- <div class="line-dashed"></div> -->
			<center><div class="form-actions">
		  <!-- <button type="submit" class="btn btn-primary">Save</button> -->
		</div></center>
		<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
		{!! Form::close() !!}
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

		$(document).on("click", ".openModel", function () {
     var recipeId = $(this).data('id');
     var recipeCode = $(this).data('code');
     var recipeName = $(this).data('name');
     $(".modal-body #id").val( recipeId );
     $(".modal-body #code").val( recipeCode );
     $(".modal-body #name").val( recipeName );
    //$('#addBookDialog').modal('show');
});
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