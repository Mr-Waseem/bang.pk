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
		<div><b id="voucherName">SALEPOINT REPORT(BILL WISE)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SHOP: {{$shop[0]->name}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;User: {{$user[0]->name}}</b></div>
	<div class="panel-body" style="border-top:2px solid;">
	<!-- <table class="table table-striped table-bordered table-hover dataTables-example" > -->
	<table style="width:100%;">
		<thead>
			<tr >	
			  <th style="width:10%; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">Date</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid; text-align: left;">Ivnoice#</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Party</th>
			  <th style="width:30%; border-top: 2px solid;border-bottom: 2px solid;">Product&nbsp;Name</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Quantity</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Sale&nbsp;Price</th>
			  
			  <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;">Total&nbsp;Sale</th>
			</tr>
		</thead>
		 <tbody>
		 <?php $pprice = 0; $sprice = 0; $quantity = 0; $total = 0; ?>
				 
					 @if(count($sales) > 0)
						@foreach($sales as $sale)
						@foreach($sale->sale_details as $products)
					<tr id="datafont">
						<td id="tabledata">{{ date("d/m/Y", strtotime($sale->date)) }}</td>
						<td id="tabledata">{{ $sale->invoice_no}}</td>
						<td id="tabledata">{{$sale->parties->party_name}}</td>
						<td id="tabledata">
							@if($products->products != null)
								 {{ $products->products->product_name }} ({{ $products->products->product_code }})
								 @endif</td>
						<td id="tabledata">{{ $products->quantity }}</td>
						<td id="tabledata">{{ $products->sale_rate }}</td>
						<td id="tabledata">{{ $products->sale_amount }}</td>
						<?php
								//$pprice = $pprice + $products->products->product_cost;
							$sprice = $sprice + (int)$products->sale_rate;
							$quantity = $quantity + (int)$products->quantity;
							$total = $total + (int)$products->sale_amount;
							?>
					</tr>
					@endforeach
					@endforeach	
				
				 <tr id="datafont">
					<td colspan="4" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;"><center><b>Total</b></center></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$quantity)}}</b></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$sprice)}}</b></td>
					
					<td style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$total)}}</b></td>
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

