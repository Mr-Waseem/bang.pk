@extends("app")
@section("contents")

      <div class="content-wrapper">
        <section class="content-header">
          <h1><span class="glyphicon glyphicon-hand-right"> Teachers</span></h1>
          <h3><span class="label label-default" style=" float: right;margin-top: -15px;background: #060606;"><span ><a href="/teachers/create" style="font-size: 12px;font-family: arial;color:white;"> Add New Teacher</a></span></h3>
        </section>
        <!-- Main content -->
        <section class="content">
			<div class="panel panel-default">
				<div class="panel-heading"><b>Manage Teachers</b>
					 <div class="btn-group" style="margin-left: 720px;">
						<form class="form-search" id="text" action="/teachers/search" enctype="multipart/form-data" method="get" style="float:right; width: 200px;">
								<div class="input-group input-group-sm">
									<input type="text" name="search" id="search" placeholder="Search" class="form-control">
									<span class="input-group-btn">
									  <button class="btn btn-info btn-flat" type="submit">Go</button>
									</span>
								</div>
						  </form>
					 </div>
					
				</div>
				<div class="panel-body">
					 <table class="table table-bordered">
						<thead>
							<tr>
								<th>Photo</th>
								<th>Name</th>
								<th>Gender</th>
								<th>Phone</th>
								<th>Details </th>
								<th>Action</th>
							 </tr>
						</thead>
						<tbody>
								  <?php
								  $sum = 0;
								  ?>
								  @if(count($teachers) > 0)
								  
									@foreach($teachers as $teacher)
										<tr>
											<td>
											<img src="\upload\teachers\{{ $teacher->image }}" alt="Teacher Image" class="online" style="border-radius: 70px;width: 70px; height: 70px;border: 2px solid green;">
											</td>
											<td> {{ $teacher->name}} </td>
											<td> {{ $teacher-> gender}} </td>
											<td> {{ $teacher->phone }} </td>
											<td><a href="/teachers/{{ $teacher->id }}/"> Details </a></td>
											<td><a href="/teachers/{{ $teacher->id }}/edit"><span class="fa fa-edit" title="Edit"> <!--edit---> </span></a> &nbsp;&nbsp; / &nbsp;&nbsp;<a id="hrefDelete" onclick ="deleteRecord({{ $teacher->id}});" href=""><span class="glyphicon glyphicon-trash" title="Delete"> <!--Delete---> </span></a></td>
										</tr>
										  <?php
										  $sum = $sum + 1;
										  ?>
									@endforeach
									@else
										<tr>
											<td colspan="6" class="text-center" style="color:#FF0000;">No Records found.</td>
										</tr>						
									@endif
					  </tbody>
					</table>
					 <!-------------Total Teachers--------------->
					 <p style="color: #c72d2d;">Showing <span class="badge"> 0 </span> to <span class="badge"><?php echo $sum; ?></span> of <span class="badge"><?php echo $sum; ?></span> enteries</p>
					<!--------------pagination function---------->
						
				</div>
			</div> 
		 </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@stop	  

@section('scripts')
<script>
	function deleteRecord(teacherid)
	{

		if(confirm("Are you sure you want to delete this Teacher?"))
		{

			window.location.href="/teachers/" + teacherid;
		}
	}

</script>
@stop