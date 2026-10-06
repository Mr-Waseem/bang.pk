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
		@include("/header.print")
			<!-- <center><span class="user-name"><img src="/upload/logo/{{$company_detail[0]->image}}" style="width: 400px;"></span></center>
			<div class="row">
				<div class="col-sm-12">
					<div class="card-header">
						<div class="card-short-description">
							<center><span class="user-name"><img src="/upload/logo/logopik.png" style="width: 98%;"></span></center>
						</div>
					</div>
				</div>	
			</div> -->
			<div class="panel panel-default">
				<div class="panel-heading"><b>All Expense</b></div>
				<div class="panel-body">
					<table class="table table-bordered">
						<thead>
							<tr>
								 <th>Serial#</th>
								  <th>Date</th>
								  <th>Description</th>
								  <th>Expense</th>
							 </tr>
						</thead>
 						<tbody>
						  <?php 
						  $count = 1;
						  $total=0;
						  ?>
						  @foreach($expenses as $expense)
						   
							<tr>
								<td><?php echo $count;?></td>
								<td class="center">{{date("d/m/Y", strtotime($expense->date))}}</td>
								<td class="center">{{$expense->description}}</td>
								<td class="center">{{$expense->expense}}</td>
								
							</tr>
							<?php $count = $count + 1;
							$total = $total + $expense->expense;
							?>
							@endforeach
							<tr>
								<td colspan="3">Total Expense</td>
								<td class="center">{{$total}}</td>
							</tr>
						  </tbody>

						</table>

				</div>
			</div> 
		 </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
	</body>
	<h5 style="float:right;">{{$company_detail[0]->footer_line}}</h5>
</html>

