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
		<div><b id="voucherName">PRODUCTION REPORT(CATEGORY WISE)</b></div>
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
	
			    @foreach($catagories as $cat)
			   @php $grandqty=0; $grandrate=0; $grandamount=0; @endphp
			   <tr style="background: #a0c6ff;">
					<td colspan="6" style="color:green;border-bottom: 2px solid black;"><b>CATAGORY NAME:</b> <span style="color:blue;">{{$cat->catagory_name}}</span>
				</tr>
				
				<?php $sum = 0; $categoryqty=0; $categoryRate=0; $categoryAmount=0; ?>
				@foreach($product as $catagories)
				
			   @if(($catagories->products)!= null)

			  	@if($cat->catagory_name == $catagories->catagory_name)
			  	@php $sum = $sum + 1;
			  		$categoryqty = $categoryqty + $catagories->quantity;
			  	
			  		$categoryAmount = $categoryAmount + $catagories->amount;

			  		$categoryRate = $categoryAmount / $categoryqty;
			  	 @endphp
					<tr id="datafont">
						<td id="tabledata"><?php echo $sum; ?></td>
						<td id="tabledata">{{$catagories->product_code}}</td>
						<td id="tabledata">{{$catagories->product_name}}</td>
						<td id="tabledata">{{$catagories->quantity}}</td>

						<!-- <td id="tabledata">{{$catagories->rate}}</td> -->
						<td id="tabledata">{{$catagories->amount / $catagories->quantity}}</td>
						<td id="tabledata">{{$catagories->amount}}</td>
					</tr>
					@endif
				@php
			  		$grandqty = $grandqty + $catagories->quantity;
			  		$grandamount = $grandamount + $catagories->amount;
 						$grandrate = $grandamount / $grandqty;

			  @endphp
			  @else
			  <tr><td colspan="6" style="color:#FF0000;text-align:center;">No Records found</td></tr>
			  @endif

			  
			  @endforeach
			   <tr id="datafont">
			<td colspan="3" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;"><center><b>Total</b></center></td>
			<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$categoryqty)}}</b></td>
			<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$categoryRate)}}</b></td>
			<td style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$categoryAmount)}}</b></td>
		</tr>
			  @endforeach	

			   <tr id="datafont">
			<td colspan="3" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;"><center><b>Total</b></center></td>
			<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$grandqty)}}</b></td>
			<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$grandrate)}}</b></td>
			<td style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$grandamount)}}</b></td>
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

