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
			<div class="panel-heading"><b>All Parties Purchase Report</b></div>
		<div class="panel-body">
			
			<!--<a href="/purchase-report/print" class="btn btn-warning" role="button" style="float:right;">
			<i class="fa fa-print"></i><span class="bold">Print</span></a>-->
				<table class="table table-bordered" >
					<thead>
						<tr>	
						  <th>Date</th>
						  <th>Supplier</th>
						  <th>Product&nbsp;Name</th>
						  <th>Purchase&nbsp;Price</th>
						  <th>Sale&nbsp;Price</th>
						  <th>Quantity</th>
						  <th>Total&nbsp;Purchase</th>
						</tr>
					</thead>
					 <tbody>
					 <?php $pprice = 0; $sprice = 0; $quantity = 0; $total = 0; ?>
					 @if(isset($purchases))
						 @if(count($purchases) > 0)
							@foreach($purchases as $purchase)
							<!--<tr><td colspan="5">Purchase Date: {{ $purchase->date }}</td></tr>
							<tr><td colspan="5">Supplier: {{ $purchase->suppliers->name }}</td></tr>-->												
							<tr>
								@foreach($purchase->purchase_details as $products)
								<td>{{ date("d/m/Y", strtotime($purchase->date)) }}</td>
								<td>{{$purchase->suppliers->name}}</td>
								<td>{{ $products->products->product_name }} ({{ $products->products->product_code }})</td>
								<td>{{ $products->products->product_cost }}</td>
								<td>{{ $products->products->product_price }}</td>
								<td>{{ $products->quantity }}</td>
								<td>{{ $products->total_cost }}</td>
								<?php
								$pprice = $pprice + $products->products->product_cost;
								$sprice = $sprice + $products->products->product_price;
								$quantity = $quantity + $products->quantity;
								$total = $total + $products->total_cost;
								?>
								</tr>
								@endforeach
									
							@endforeach
							<tr>
							<td colspan="3"><center><b>Total</b></center></td>
							<td>{{$pprice}}</td>
							<td>{{$sprice}}</td>
							<td>{{$quantity}}</td>
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


