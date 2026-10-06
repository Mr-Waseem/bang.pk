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
		@include("/header.report")		
		<div class="panel panel-default">
			<div class="panel-heading"><b>Expense Head Report</b></div>
		<div class="panel-body">
			
			<!--<a href="/purchase-report/print" class="btn btn-warning" role="button" style="float:right;">
			<i class="fa fa-print"></i><span class="bold">Print</span></a>-->
				<table class="table table-bordered" >
					<thead>
						<tr>	
						  <th>Date</th>
						  <th>Expense</th>
						  <th>Description</th>
						</tr>
					</thead>
					 <tbody>
					 <?php $total = 0; ?>
					 @if(isset($expenses))
						 @if(count($expenses) > 0)
							@foreach($expenses as $expense)
												
							<tr>
								
								<td>{{ date("d/m/Y", strtotime($expense->date)) }}</td>
								<td>{{$expense->description}}</td>
								<td>{{$expense->expense}}</td>
								<?php $total = $total + $expense->expense?>
								</tr>
								
									
							@endforeach
							<tr>
							<td colspan="2"><center><b>Total</b></center></td>
							<td>{{$total}}</td>
							</tr>
						 @endif	
						 @else
							<tr><td colspan="7" style="color:#FF0000;text-align:center;">No purchases found</td></tr>
						 @endif
					 </tbody>
				</table>
			</div>
		</div>
	</section>
</div>

		
	
		</body>
		</html>


