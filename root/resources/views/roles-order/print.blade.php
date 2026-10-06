@include("/include.config")
<?php	
	$que="select * from general_settings";
	$run=@mysql_query($que);

	$row=@mysql_fetch_array($run);
	$name = $row['system_name'];
?>
<html>
	<head>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body onload="window.print();">
	  <div class="content-wrapper">
        <section class="content">
			<center><b><?php echo $name; ?></b></center>
			<span style="float: right;margin-top: -19px;">
				<?php $t=time(); ($t . "<br>"); echo(date("d-m-y",$t)); ?>
			</span>
			<div class="panel panel-default">
				<div class="panel-heading"><b>Manage Teachers</b></div>
				<div class="panel-body">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Photo</th>
								<th>Name</th>
								<th>Gender</th>
								<th>Phone</th>
								<th>BirthDay</th>
								<th>Email</th>
								<!--<th>Address</th>-->
							</tr>
						</thead>
						<tbody>
								  @if(count($teachers) > 0)
								  @foreach($teachers as $teacher)
									<tr>
										<td>
										<img src="\upload\teachers\{{ $teacher->image }}" alt="Teacher Image" class="online" style="border-radius: 70px;width: 40px; height: 40px;border: 2px solid green;">
										</td>
										<td> {{ $teacher->name}} </td>
										<td> {{ $teacher-> gender}} </td>
										<td> {{ $teacher->phone }} </td>
										<td> {{ $teacher->birthday}} </td>
										<td> {{ $teacher-> email}} </td>
										<!--<td> {{ $teacher->address }} </td>-->
									</tr>
								  @endforeach
								  @else
								     <tr>
										 <td colspan="6" class="text-center" style="color:#FF0000;">No Records found.</td>
									 </tr>						
								@endif
					  </tbody>
					</table>
				</div>
			</div> 
		 </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
	</body>
</html>

