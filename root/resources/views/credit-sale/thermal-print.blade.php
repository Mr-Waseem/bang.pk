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
					<!-- <th><button onclick="goBack()" autofocus>SALE&nbsp;INVOICE</button></th> -->
					<th style="font-family: sans-serif;">{{$company_detail[0]->title}}</th>
					
					<th style="font-family: sans-serif;"></th>
					<th style="font-family: sans-serif;">DATE:{{date("d/m/Y", Strtotime($newsale_detail[0]->date))}}</th>
				</tr>
				<tr>
					<th style="font-family: sans-serif;"><button onclick="goBack()" autofocus>BILL NO: {{$newsale_detail[0]->invoice_no}}</button></th>
					<th></th>
					<th style="font-family: sans-serif;">TIME: {{date("H:i", Strtotime($newsale_detail[0]->created_at))}}</th>
				</tr>
		<tr style="background:#1e00c6;" >
			<!-- <th style="width:1px; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">SR#</th> -->
			<th style="width:1px; border-top: 2px solid; border-left: 2px solid;border-bottom: 2px solid; font-family: sans-serif;"><center>Description</center></th>
			<th style="width:1px; border-top: 2px solid;border-bottom: 2px solid; font-family: sans-serif;"><center>Qty</center></th>
			<th style="width:1px; border-top: 2px solid;border-bottom: 2px solid; font-family: sans-serif;"><center>Rate</center></th>
			<th style="width:100px; border-top: 2px solid;border-bottom: 2px solid; border-right:1px solid; font-family: sans-serif;"><center>Total</center></th>
		</tr>
	</thead>
		<tr id="datafont" style="border:2px solid;">
			<!-- <td id="tabledata"><center>{{$sum}}</center></td> -->
			<th style="font-family: sans-serif;" id="tabledata"><center>
				@if($details->products!=null)
			    {{$details->products->product_name}}
			    @endif
			</center></th>
			<th style="font-family: sans-serif;" id="tabledata" style=""><center>{{$details->quantity}}<!-- {{$details->products->uom}} --></center></th>
			@php
			$value = $details->discount->discount/100*($details->sale_rate*$details->quantity);
			$gross = $details->sale_rate*$details->quantity;
			@endphp
			<th style="font-family: sans-serif;" id="tabledata" style=""><center>{{number_format((int)$details->sale_rate)}}</center></th>
			<th style="font-family: sans-serif;" id="tabledata" style=""><center>{{number_format((int)$details->sale_amount)}}</center></th>
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
		<td style="font-family: sans-serif;" colspan="2">Issued&nbsp;By:{{$newsale_detail[0]->billers->name}}</td>
		<td style="font-family: sans-serif;" colspan="2">Phone:{{$company_detail[0]->phone}}</td>
	</tr>

	<tr><td colspan="5">------------------------------------------------------------------</td></tr>
		</tbody>
		<!-- <div class="break"></div> -->
		<p style="page-break-before: always; height: auto;"></p>
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
	