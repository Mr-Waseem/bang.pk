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
		<div><b id="voucherName">STOCK SINGLE ITEM ({{$product[0]->product_name}})</b></div>
	<div class="panel-body" style="border-top:2px solid;">
	<table style="width:100%;">
		<thead>
			<tr >	
			  <th style="width:5%; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">Serial</th>
			  
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Date</th>
			  <th style="width:5%; border-top: 2px solid;border-bottom: 2px solid;">V.No</th>
			  
			  <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid;">Party.Name</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Type</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">IN(Qty)</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">OUT(Qty)</th>
			  {{-- <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">IN(Weight)</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">OUT(Weight)</th> --}}
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;">STOCK</th>
			</tr>
		</thead>
		 <tbody>
		 	<?php $totalOpening = 0; $adjustment = -29742;?>
 	<!-- <tr id="datafont" style="color: red;">
		<td id="tabledata"></td>
		<td id="tabledata"></td>
		
		<td id="tabledata" colspan="3">OPENING STOCK</td>
		
		
		
		<td id="tabledata">{{number_format($openingStock[0]->stockin, 2)}}</td>
		<td id="tabledata">{{number_format($openingStock[0]->stockout, 2)}}</td>
		<td id="tabledata"></td>
		<td id="tabledata"></td>
		
		<?php $totalOpening = $openingStock[0]->stockin-$openingStock[0]->stockout ?>
		<td id="tabledata">{{number_format($totalOpening, 2)}}</td>
	</tr> -->
		 <?php $grandIn=0; $grandOut=0; $sum=0;?>
		 @if(count($items) > 0)
			@foreach($items as $item)
			<?php $totalIn = 0; $totalOut = 0;?>
			<?php $sum = $sum + 1?>
					<tr>
						<td id="tabledata">{{$sum}}</td>
							<td id="tabledata">{{ date("d/m/Y", strtotime($item->date)) }}</td>
						<td id="tabledata">{{$item->voucher_no}}</td>
						<td id="tabledata">
							{{-- @if($item->warehouse != null)
							{{ $item->warehouse->name}}
							@endif --}}
							@if($item->parties != null)
							{{ $item->parties->party_name}}
							@endif
							
						</td>
						<td id="tabledata">
							{{ $item->type}}

						</td>
						<td id="tabledata">
							@if($item->stockin!=null)
								{{ $item->stockin}} {{ $item->uoms->uom}}
								@php $grandIn = $grandIn + $item->stockin; @endphp
							@endif
						</td>
						<td id="tabledata">
							@if($item->stockout!=null)
								{{ $item->stockout}} {{ $item->uoms->uom}}
								@php $grandOut = $grandOut + $item->stockout; @endphp
							@endif
						</td>
						
					<td id="tabledata">{{number_format($grandIn-$grandOut, 2)}} {{ $item->products->uom}}</td>
				</tr>
			@endforeach
			<!-- <tr id="datafont">
					<td colspan="7" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;"><center><b>Total Without Opening Balance</b></center></td>

					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$totalIn)}}</b></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$totalOut)}}</b></td>
					
					<td style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$totalIn-$totalOut)}}</b></td>
				</tr> -->
			  <tr id="datafont">
					<td colspan="3" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;"><center><b>Total</b></center></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>
						<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format($grandIn, 2)}} {{$product[0]->uom}}</b></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format($grandOut, 2)}} {{$product[0]->uom}}</b></td>


					<td style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;"><b>{{number_format($grandIn-$grandOut, 2)}} {{$product[0]->uom}}</b></td>
				</tr>


				@else
			<tr><td colspan="10" style="color:#FF0000;text-align:center;">No Records found</td></tr>


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

