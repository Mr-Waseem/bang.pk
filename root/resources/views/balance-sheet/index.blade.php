<html>
	<head>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="content-wrapper">
        <section class="content">
		@include("/header.report")		
		<div class="panel panel-default">
			<div class="panel-heading"><b>Balance Sheet</b></div>
		<div class="panel-body">
			<!--<a href="/purchase-report/print" class="btn btn-warning" role="button" style="float:right;">
			<i class="fa fa-print"></i><span class="bold">Print</span></a>-->
				<table class="table table-bordered" >
					<thead>
						<tr>	
						  <th>Assets</th>
						  <th>Amount</th>
						  
						</tr>
					</thead>
					 <tbody>
					 	<div class="col-sm-12">
					 <?php $Assettotal = 0; $Liabilitytotal=0; ?>
					 @if(isset($asset))
						 @if(count($asset) > 0)
							@foreach($asset as $assets)
							<div class="col-sm-6">				
							<tr>
								<td><a href="client-all-report/ledger-for-trial/{{$assets->id}}">{{$assets->party_name}}</a></td>
								<td>{{$assets->total}}</td>
								<?php $Assettotal = $Assettotal + $assets->total?>
							</tr>
							
							</div>
							@endforeach
							<tr style="color:blue;">
							<td><b>Total Assets </b></td>
							<td><b>{{$Assettotal}}</b></td>
							</tr>

							<th>Liabilities</th>
						 	 <th>Amount</th>
							@foreach($liabilitity as $liabilitits)
							<div class="col-sm-6">				
							<tr>
								<td><a href="client-all-report/ledger-for-trial/{{$liabilitits->id}}">{{$liabilitits->party_name}}</a></td>
								<td>{{$liabilitits->total}}</td>
								<?php $Liabilitytotal = $Liabilitytotal + $liabilitits->total?>
							</tr>
							</div>
							@endforeach
							<tr style="color:blue;">
							<td><b>Total Liabilities </b></td>
							<td><b>{{$Liabilitytotal}}</b></td>
							</tr>

							<!-- <tr style="color:red;">
							<td><b>Grand Total</b></td>
							<td><b>{{$Assettotal-$Liabilitytotal}}</b></td>
							</tr> -->
						 @endif	
						 @else
							<tr><td colspan="7" style="color:#FF0000;text-align:center;">No purchases found</td></tr>
						 @endif
						 <tr><td colspan="2"><a style="color:red;" href="trial-balance/receiveables/all">ALL RECEIVEABLES</a></td></tr>
						</div>
					 </tbody>
				</table>
			</div>
		</div>
	</section>
</div>

		
	
		</body>
		</html>


