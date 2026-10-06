<html>
<head>
  <link href="{{ asset('css/bg.css') }}" rel="stylesheet">
</head>
<!-- <body onload="window.print();"> -->
<body>
	<button onclick="goBack()" autofocus>Go Back</button>
	<div>
	<section class="content">
	@include("header.report")
	<center id="systemDetail" >FROM:{{date("d/m/Y", Strtotime($fromDate))}} TO:{{date("d/m/Y", Strtotime($toDate))}}</center>	
	<div style="border:2px solid;">
		<div><b id="voucherName">SALE REPORT(CATEGORY WISE)</b></div>
	<div class="panel-body" style="border-top:2px solid;">
	<table style="width:100%;">
		<thead>
			<tr >	
			  <th style="width:10%; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">Serial</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid; text-align: left;">Code</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Product&nbsp;Name</th>
			  <th style="width:30%; border-top: 2px solid;border-bottom: 2px solid;">Quantity</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Rate</th>
			  <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;">Total</th>
			</tr>
		</thead>
		 <tbody>
		
				@php $grandqty=0; $grandrate=0; $grandamount=0; @endphp
			   @foreach($product as $catagories)
			    <?php $sum = 1; $TotalQTY=0; $TotalRate=0; $TotalAmount=0;  ?>
			   @if(($catagories->products)!= null)
			   <tr style="background: #a0c6ff;">
					<td colspan="6" style="color:green;border-bottom: 2px solid black;"><b>CATAGORY NAME:</b> <span style="color:blue;">{{$catagories->catagory_name}}</span>
				</tr>
			   @foreach($catagories->products as $items)
			  			<?php $quantity_sale = 0; $rate =0; $amount = 0;?>
			  			@if(($items->sale_detail) != null)
						@foreach($items->sale_detail as $detail)

							<?php $quantity_sale = $quantity_sale + (float)$detail->quantity; ?>
							<?php $rate = $rate + (float)$detail->sale_rate; ?>
							<?php $amount = $amount + (float)$detail->sale_amount; ?>
						@endforeach
						
					@if($quantity_sale!=0)
					<tr id="datafont">
						<td id="tabledata"><?php echo $sum; ?></td>
						<td id="tabledata">{{$items->product_code}}</td>
						<td id="tabledata">{{$items->product_name}}</td>
						<td id="tabledata">{{$quantity_sale}}</td>
						<!-- <td id="tabledata">{{$rate}}</td> -->
						<td id="tabledata">{{number_format($amount/$quantity_sale, 2)}}</td>
						<td id="tabledata">{{$amount}}</td>
					</tr>
					@endif
				@php 
				$sum = $sum + 1;
					$TotalQTY = $TotalQTY + (int)$quantity_sale;
				
					$TotalRate = $TotalRate + (int)$items->product_price;
				
					$TotalAmount = $TotalAmount + (int)$amount;
				@endphp
				@endif
			  @endforeach
			   @if($TotalQTY != 0)
			   <tr id="datafont">
					<td colspan="3" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;"><center><b>Total</b></center></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format($TotalQTY)}}</b></td>
					<!-- <td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format($TotalRate)}}</b></td> -->
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b></b></td>
					
					<td style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;"><b>{{number_format($TotalAmount)}}</b></td>
				</tr>
				 @endif
			  @else
			  <tr><td colspan="6" style="color:#FF0000;text-align:center;">No Records found</td></tr>
			  @endif

			  @php

			  $grandqty = $grandqty + $TotalQTY;
			  $grandrate = $grandrate + $TotalRate;
			  $grandamount = $grandamount + $TotalAmount;
			  @endphp
			  @endforeach	

			  <tr id="datafont">
					<td colspan="3" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;"><center><b>Grand Total</b></center></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format($grandqty)}}</b></td>
					<!-- <td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format($grandrate)}}</b></td> -->
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b></b></td>
					<td style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;"><b>{{number_format($grandamount)}}</b></td>
				</tr>
				


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

