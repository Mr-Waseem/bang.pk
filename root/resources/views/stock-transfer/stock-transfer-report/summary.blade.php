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
		<div><b id="voucherName">STOCK TRANSFER REPORT(CATEGORY WISE)</b></div>
	<div class="panel-body" style="border-top:2px solid;">
	<table style="width:100%;">
		<thead>
			<tr >	
			  <th style="width:10%; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">SERIAL</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid; text-align: left;">CODE</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">PRODUCT&nbsp;NAME</th>
			  <th style="width:30%; border-top: 2px solid;border-bottom: 2px solid;">STOCK.TRANSFER</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">SALE.OUT</th>
			  <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;">TOTAL.STOCK</th>
			</tr>
		</thead>
		 <tbody>
	
			    @foreach($catagories as $cat)
			   @php $grandIn=0; $grandOut=0; $grandStock=0; @endphp
			   <tr style="background: #a0c6ff;">
					<td colspan="6" style="color:green;border-bottom: 2px solid black;"><b>CATAGORY NAME:</b> <span style="color:blue;">{{$cat->catagory_name}}</span>
				</tr>
				
				<?php $sum = 0; $categoryIn=0; $categoryOut=0; $categoryStock=0; ?>
				@foreach($product as $catagories)
				
			   @if(($catagories->products)!= null)

			  	@if($cat->catagory_name == $catagories->catagory_name)
			  	@php $sum = $sum + 1;
			  		$categoryIn = $categoryIn + $catagories->Stockin;
			  		$categoryOut = $categoryOut + $catagories->Stockout;
			  		$categoryStock = $catagories->Stockin - $catagories->Stockout;
			  	 @endphp
					<tr id="datafont">
						<td id="tabledata"><?php echo $sum; ?></td>
						<td id="tabledata">{{$catagories->product_code}}</td>
						<td id="tabledata">{{$catagories->product_name}}</td>
						<td id="tabledata">{{$catagories->Stockin}}</td>
						<td id="tabledata">{{$catagories->Stockout}}</td>
						<td id="tabledata">{{$catagories->Stockin-$catagories->Stockout}}</td>
					</tr>
					@endif
				@php
			  		$grandIn = $grandIn + $catagories->Stockin;
			  		$grandOut = $grandOut + $catagories->Stockout;
			  		$grandStock = $catagories->Stockin - $catagories->Stockout;
			  @endphp
			  @else
			  <tr><td colspan="6" style="color:#FF0000;text-align:center;">No Records found</td></tr>
			  @endif

			  
			  @endforeach
			   <tr id="datafont">
			<td colspan="3" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;"><center><b>Total</b></center></td>
			<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$categoryIn)}}</b></td>
			<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$categoryOut)}}</b></td>
			<td style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$categoryStock)}}</b></td>
		</tr>
			  @endforeach	

			   <tr id="datafont">
			<td colspan="3" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;"><center><b>Total</b></center></td>
			<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$grandIn)}}</b></td>
			<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$grandOut)}}</b></td>
			<td style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$grandStock)}}</b></td>
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

