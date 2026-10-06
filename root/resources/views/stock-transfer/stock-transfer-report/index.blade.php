<html>
<head>
  <link href="/css/bg.css" rel="stylesheet">
</head>
<!-- <body onload="window.print();"> -->
<body>
	<button onclick="goBack()" autofocus>Go Back</button>
	<div>
	<section class="content">
	@include("/header.report")
	<center id="systemDetail" >FROM:{{date("d/m/Y", Strtotime($fromDate))}} TO:{{date("d/m/Y", Strtotime($toDate))}}</center>	
	<div style="border:2px solid;">
		<div><b id="voucherName">STOCK TRANSFER REPORT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; BRANCH:{{$warehouse[0]->name}} </b></div>
	<div class="panel-body" style="border-top:2px solid;">
	<!-- <table class="table table-striped table-bordered table-hover dataTables-example" > -->
	<table style="width:100%;">
		<thead>
			<tr >	
			  <th style="width:10%; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">Date</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">VR.No</th>
			  <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid;">VOUCHER.TYPE</th>
			  <th style="width:30%; border-top: 2px solid;border-bottom: 2px solid; text-align: left;">Product&nbsp;Name</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">STOCK.IN</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">STOCK.OUT</th>
			  
			  <!-- <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;">TOTAL.STOCK</th> -->
			</tr>
		</thead>
		 <tbody>
		 <?php $totalIn = 0; $totalOut = 0; $total = 0; ?>
				 
					 @if(count($SalePoint) > 0)
						@foreach($SalePoint as $sale)
						
					<tr id="datafont">
						<td id="tabledata">{{ date("d/m/Y", strtotime($sale->created_at)) }}</td>
						<td id="tabledata">{{ $sale->vr_no}}</td>
						<td id="tabledata">
							@if($sale->pro_transfer_id != null)
							{{"PRODUCTION"}}
							@endif
							@if($sale->direct_transferID != null)
							{{"DIRECT"}}
							@endif

							@if($sale->sale_id != null)
							{{"SALE BILL"}}
							@endif
							@if($sale->wastage_id != null)
							{{"WASTAGE|ADJUST"}}
							@endif

						</td>
						<td id="tabledata" style="text-align: left;">
							
								 {{ $sale->product_name }} ({{ $sale->product_code }})
								</td>
						<td id="tabledata">{{ $sale->stockin }}</td>
						<td id="tabledata">{{ $sale->stockout }}</td>
						<!-- <td id="tabledata">{{ $sale->sale_amount }}</td> -->
						<?php
								//$pprice = $pprice + $products->products->product_cost;
							$totalIn = $totalIn + (int)$sale->stockin;
							$totalOut = $totalOut + (int)$sale->stockout;
							// $total = $total + (int)$sale->sale_amount;
							?>
					</tr>
					
					@endforeach	
				
				 <tr id="datafont">
					<td colspan="4" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;"><center><b>Total</b></center></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$totalIn)}}</b></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$totalOut)}}</b></td>
					
					<!-- <td style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$total)}}</b></td> -->
				</tr>
				
			 @else
				<tr><td colspan="7" style="color:#FF0000;text-align:center;">No Records found</td></tr>
			 @endif
		 </tbody>
	</table>
	</div>
	</div>
</section>
	</div>

	

</body>
</html>
<script>
function goBack() {
  window.history.back()
}
</script>

