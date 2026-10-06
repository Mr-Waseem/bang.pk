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
	<div><b id="voucherName">SALE COST ANALYSIS(CATEGORY WISE)</b></div>
<div class="panel-body" style="border-top:2px solid;">
<table style="width:100%;">
	<thead>
		<tr >	
		  <th style="width:10%; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">Serial</th>
		  
		  <th style="width:30%; border-top: 2px solid;border-bottom: 2px solid;text-align: left;">Product&nbsp;Name</th>
		  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Qty</th>
		  <th style="width:00%; border-top: 2px solid;border-bottom: 2px solid;">Cost</th>
		  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">CostAmount</th>
		  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Rate</th>
		  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">RateAmount</th>
		  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;">Margin</th>
		</tr>
	</thead>
	 <tbody>
	 <?php $sum = 1; $totalMargin=0;?>
	 @php $Totalqty=0; $Totalcost=0; $TotalcostAmount=0; $Totalrate=0; $TotalrateAmount=0; $Totalmargin=0; @endphp
		   @foreach($product as $catagories)
		   <tr style="background: #a0c6ff;">
				<td colspan="9" style="color:green;border-bottom: 2px solid black;"><b>CATAGORY NAME:</b> <span style="color:blue;">{{$catagories->catagory_name}}</span>
			</tr>
			<?php $categoryqty=0; $categoryCost=0; $categoryCostAmount=0; $categoryRate=0; $categoryRateAmount=0; $categoryMargin=0;?>

				@foreach($catagories->products as $product)
				@if(count($product->sale_detail) > 0)
				<?php $qty=0; $cost=0; $costAmount=0; $rate=0; $rateAmount=0; $margin=0;?>
				<tr>
					<td id="tabledata">{{$sum}}</td>
						<td id="tabledata" style="text-align: left;">
							{{$product->product_name}}</td>

		@foreach($product->sale_detail as $details)
		@if(( (float)$details->quantity) > 0) 
			@php
			
				$qty = $qty +  (float)$details->quantity; 

				$costAmount = $costAmount +  (int)$details->cost_amount;
				$rateAmount = $rateAmount +  (int)$details->sale_amount;
				$cost = $costAmount / $qty; 
				$rate = $rateAmount / $qty; 
				$margin = (int)$rateAmount -  (int)$costAmount;
			@endphp
			@endif 
		@endforeach
				
		<td id="tabledata">{{$qty}}</td>
		<td id="tabledata">{{number_format((float)$cost, 2, '.', '')}}</td>
		<td id="tabledata">{{number_format((int)$costAmount)}}</td>
		<td id="tabledata">{{number_format((float)$rate, 2, '.', '')}}</td>
		<td id="tabledata">{{number_format((int)$rateAmount)}}</td>
		<td id="tabledata">{{number_format((int)$margin)}}</td>
		</tr>
		@php 
			$sum = $sum + 1; 
			$Totalqty = $Totalqty + (int)$qty; 
			$Totalcost = $Totalcost + (int)$cost; 
			$TotalcostAmount = $TotalcostAmount + (int)$costAmount; 
			$Totalrate = $Totalrate + (int)$rate; 
			$TotalrateAmount = $TotalrateAmount + (int)$rateAmount; 
			$Totalmargin = $Totalmargin + (int)$margin; 
			 

		@endphp
		@php 
			$categoryqty = $categoryqty + $qty;
			$categoryCost = $categoryCost + $cost;
			$categoryCostAmount = $categoryCostAmount + $costAmount;
			$categoryRate = $categoryRate + $rate;
			$categoryRateAmount = $categoryRateAmount + $rateAmount;
			$categoryMargin = $categoryMargin + $margin;

		 @endphp
		 @endif
		@endforeach
		<tr id="datafont">
					<td colspan="2" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid; color:blue;"><center><b>Total</b></center></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;color:blue;"><b>{{number_format($categoryqty)}}</b></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;color:blue;"><b>{{number_format($categoryCost)}}</b></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;color:blue;"><b>{{number_format($categoryCostAmount)}}</b></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;color:blue;"><b>{{number_format($categoryRate)}}</b></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;color:blue;"><b>{{number_format($categoryRateAmount)}}</b></td>
					<td style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;color:blue;"><b>{{number_format($categoryMargin)}}</b></td>
				</tr>
		
  @endforeach

  <tr id="datafont">
					<td colspan="2" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid; color:red;"><center><b>Grand Total</b></center></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center; color:red;"><b>{{number_format((int)$Totalqty)}}</b></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center; color:red;"><b>{{number_format((int)$Totalcost)}}</b></td>
					
					<td style="border-top: 2px solid;border-bottom: 2px solid; text-align:center; color:red;"><b>{{number_format((int)$TotalcostAmount)}}</b></td>
					<td style="border-top: 2px solid;border-bottom: 2px solid; text-align:center; color:red;"><b>{{number_format((int)$Totalrate)}}</b></td>
					<td style="border-top: 2px solid;border-bottom: 2px solid; text-align:center; color:red;"><b>{{number_format((int)$TotalrateAmount)}}</b></td>
					<td style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center; color:red;"><b>{{number_format((int)$Totalmargin)}}</b></td>
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

