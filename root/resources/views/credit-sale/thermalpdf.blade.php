<html>
<head>
  <link href="/css/bg.css" rel="stylesheet">
</head>
	<body onload="window.print();">
	
		<?php $sum = 1; $quantity = 0; $rate = 0; $amount = 0; $discount = 0; $discountvalue=0; $grossamount=0; ?>
			@foreach ($newsale_detail[0]->sale_details as $details)
			<table style="width: 10px important!;">
			<tbody>
			<thead>
				<tr>
					<th><button onclick="goBack()" autofocus>SALE&nbsp;INVOICE</button></th>
					<th></th>
					<th>DATE:{{date("d/m/Y", Strtotime($newsale_detail[0]->created_at))}}</th>
				</tr>
				<tr>
					<th>{{$company_detail[0]->title}}</th>
					<th></th>
					<th>TIME: {{date("H:i", Strtotime($newsale_detail[0]->created_at))}}</th>
				</tr>
		<tr style="background:#1e00c6;" >
			<!-- <th style="width:1px; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">SR#</th> -->
			<th style="width:1px; border-top: 2px solid; border-left: 2px solid;border-bottom: 2px solid;"><center>Description</center></th>
			<th style="width:1px; border-top: 2px solid;border-bottom: 2px solid;"><center>Qty</center></th>
			<th style="width:1px; border-top: 2px solid;border-bottom: 2px solid;"><center>Rate</center></th>
			<th style="width:100px; border-top: 2px solid;border-bottom: 2px solid; border-right:1px solid;"><center>Total</center></th>
		</tr>
	</thead>
		<tr id="datafont" style="border:2px solid;">
			<!-- <td id="tabledata"><center>{{$sum}}</center></td> -->
			<th id="tabledata"><center>
				@if($details->products!=null)
			   <b> {{$details->products->product_name}}</b>
			    @endif
			</center></th>
			<th id="tabledata" style=""><center>  <b>{{$details->quantity}}  </b><!-- {{$details->products->uom}} --></center></th>
			@php
			$value = $details->discount->discount/100*($details->sale_rate*$details->quantity);
			$gross = $details->sale_rate*$details->quantity;
			@endphp
			<th id="tabledata" style=""><center><b>{{number_format((int)$details->sale_rate)}}</b></center></th>
			<th id="tabledata" style=""><center><b>{{number_format((int)$details->sale_amount)}}</b></center></th>
		</tr>
		<?php 
		$discount = $discount + $details->discount->discount;
		$discountvalue = $discountvalue + $value;
		// $grossamount = $grossamount + $gross;
		$quantity = $quantity + $details->quantity;
		$rate = $rate + $details->sale_rate;
		$grossamount = $grossamount + $details->sale_amount;
		$sum = $sum + 1;
		?>
		<tr>
		<td colspan="2">Issued&nbsp;By:{{$newsale_detail[0]->billers->name}}</td>
		<td colspan="2">Phone:{{$company_detail[0]->phone}}</td>
	</tr>

	<tr><td colspan="5">---------------------------------------------------------------</td></tr>
		</tbody>
		<!-- <div class="break"></div> -->
		<p style="page-break-after: always; height: auto;"></p>
		</table>
		@endforeach
	


	

	</body>

</html>
</br>

<script>
function goBack() {
  window.close()
}
</script>
	