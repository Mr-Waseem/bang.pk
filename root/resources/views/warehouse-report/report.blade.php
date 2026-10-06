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
			<!-- <b></b> -->
	<div class="panel panel-default">
		<div class="panel-heading"><b>Warehouse Report<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Warehouse Code: {{$party[0]->id}} &nbsp;&nbsp;&nbsp;&nbsp;  Warehouse Name: {{$party[0]->name}}</b></div>
	<div class="panel-body">
		
		<!--<a href="/purchase-report/print" class="btn btn-warning" role="button" style="float:right;">
		<i class="fa fa-print"></i><span class="bold">Print</span></a>-->
	<table class="table table-striped table-bordered table-hover dataTables-example" >
		<thead>
			<tr>	
			  <th>Sr#</th>
			 <th>Date</th>
			  <th>Bill&nbsp;No</th>
			  <!-- <th>Biller</th> -->
			  <!-- <th>Sale&nbsp;Type</th> -->
			  <!-- <th>Cost&nbsp;Amount</th> -->
			  <th>Account&nbsp;Name</th>
			  <th>Purchase&nbsp;Amount</th>
			  <th>Sale&nbsp;Amount</th>
			  <th>Balance</th>
			  
			</tr>
		</thead>
		 <tbody>
<?php $sum = 0; $totalPurchase=0; $totalSale=0; ?>
			  @foreach($sales as $sale)
			  <?php $sum = $sum + 1; ?>
				<tr><td class="center">{{$sum}}</td>
					<td class="center">{{date("m/d/Y", strtotime($sale->date))}}</td>
					<td class="center">{{$sale->invoice_no}}</td>
					<?php $total = 0; $CoutAmount = 0; $SaleAmount = 0; $discount = 0;?>
					@foreach($sale->sale_details as $details)
						<?php 
						$total = $total + (int)$details->product_cost * (int)$details->quantity;
						$CoutAmount = $CoutAmount + (int)$details->cost_amount;
						$SaleAmount = $SaleAmount + (int)$details->sale_amount;
						?>
						
					@endforeach
					<!-- <td class="center">{{(int)$total}}</td> -->
					<td class="center">
						@if(($sale->parties)!=null)
							{{$sale->parties->party_name}}
						@endif
					</td>
					<td class="center">{{(int)$CoutAmount}}</td>
					<td class="center">{{(int)$SaleAmount}}</td>
					<td class="center">{{(int)$SaleAmount-(int)$CoutAmount}}</td>
				
					<!-- <td class="center">{{$discount}}</td> -->
					
					<!-- <td class="center">
							@if(($sale->parties)!=null)
								{{$sale->parties->ntn}}
							@endif
						</td> -->
				</tr>
			  <?php $totalPurchase = $totalPurchase + $CoutAmount;?>
			  <?php $totalSale = $totalSale + $SaleAmount;?>
			  @endforeach
			  <tr>
			  	<td colspan="4">Total</td>
			  	<td>{{$totalPurchase}}</td>
			  	<td>{{$totalSale}}</td>
			  	<td>{{$totalSale-$totalPurchase}}</td>
			  </tr>
		 </tbody>
	</table>
		</div>
	</div>
</section>
	</div>

		
	
		</body>
		</html>


