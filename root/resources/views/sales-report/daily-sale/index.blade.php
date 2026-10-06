<html>
<head>
  <link href="/css/bg.css" rel="stylesheet">
</head>
<body>
	<button onclick="goBack()" autofocus>Go Back</button>
	<div>
	<section class="content">
	@include("/header.report")
	<center id="systemDetail" >FROM:{{date("d/m/Y", Strtotime($fromDate))}} TO:{{date("d/m/Y", Strtotime($toDate))}}</center>	
	<div style="border:2px solid;">
		<div><b id="voucherName">SALE REPORT SINGLE PARTY Party Code: {{$party[0]->id}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Party Name: {{$party[0]->party_name}}</b></div>
	<div class="panel-body" style="border-top:2px solid;">
	<table style="width:100%;">
		<thead>
			<tr >	
			  <th style="width:10%; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">Date</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid; text-align: left;">Bill No</th>
			  <th style="width:30%; border-top: 2px solid;border-bottom: 2px solid;">Product&nbsp;Name</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Quantity</th>
			 
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Sale&nbsp;Price</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;">Total&nbsp;Sale</th>
			</tr>

		</thead>
		 <tbody>
		 <?php $SaleRate = 0; $quantity = 0; $SaleRatetotal = 0; ?>
		 
			 @if(count($sales) > 0)
				@foreach($sales as $sale)	
				@foreach($sale->sale_details as $products)				
					<tr id="datafont">
						
						<td id="tabledata">{{ date("d/m/Y", strtotime($sale->date)) }}</td>
						<td id="tabledata">{{$sale->invoice_no}}</td>
						<td id="tabledata">@if($products->products != "")
						{{ $products->products->product_name }} ({{ $products->products->product_code }})
						@endif</td>
						<td id="tabledata">{{ $products->quantity }}</td>
						<td id="tabledata">{{ $products->sale_rate }}</td>
						
						<td id="tabledata">{{ $products->sale_amount }}</td>
						
						
					<?php
					$SaleRate = $SaleRate + (int)$products->sale_rate;
					$quantity = $quantity + (int)$products->quantity;
					$SaleRatetotal = $SaleRatetotal + (int)$products->sale_amount;
					?>
					</tr>
					@endforeach
						
				@endforeach


			  <tr id="datafont">
					<td colspan="3" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;"><center><b>Total</b></center></td>
					
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$quantity)}}</b></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$SaleRate)}}</b></td>
					<td style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$SaleRatetotal)}}</b></td>
				</tr>

				@else
				<tr><td colspan="9" style="color:#FF0000;text-align:center;">No Records found</td></tr>
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

