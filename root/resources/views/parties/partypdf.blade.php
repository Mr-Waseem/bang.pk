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
        	
		@include("/header.pdf")
		<!---<center><span class="user-name"><img src="/upload/logo/{{$company_detail[0]->image}}" style="width: 400px;"></span></center>--->
			<div class="panel panel-default">
				<div class="panel-heading"><b>All Expense</b></div>
				<div class="panel-body">
					<table class="table table-bordered">
						<thead>
							<tr>
								 <th>Serial#</th>
								  <th>Name</th>
								  <th>Phone</th>
								  <th>NTN</th>
								  <th>STRN</th>
								  <th>City</th>
								  <th>Address</th>
								  <th>Type</th>
							 </tr>
						</thead>
 						<tbody>
						  <?php 
						  $count = 1;
						  $total=0;
						  ?>
						  @foreach($parties as $party)
						   
							<tr>
								<td><?php echo $count;?></td>
<!-- 								<td class="center">{{date("d/m/Y", strtotime($party->date))}}</td> -->
								<td class="center">{{$party->party_name}}</td>
								<td class="center">{{$party->phone}}</td>
								<td class="center">{{$party->ntn}}</td>
								<td class="center">{{$party->strn}}</td>
								<td class="center">{{$party->city}}</td>
								<td class="center">{{$party->address}}</td>
								<td class="center">{{$party->type}}</td>
								
							</tr>
							@endforeach
						  </tbody>

						</table>

					
				</div>
			</div> 
			<h5 style="float:right;">{{$company_detail[0]->footer_line}}</h5>
		 </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
	</body>
	
</html>

