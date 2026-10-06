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
		<div><b id="voucherName">SALE POINT STOCK SINGLE ITEM ({{$product[0]->product_name}}) SHOP: {{$warehouse[0]->name}}</b></div>
	<div class="panel-body" style="border-top:2px solid;">
	<table style="width:100%;">
		<thead>
			<tr >	
			  <th style="width:5%; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">Serial</th>
			  
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Date</th>
			  
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Vr.No</th>
			  <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid;">Type</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">IN(Qty)</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">OUT(Qty)</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Cost</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;">STOCK</th>
			</tr>
		</thead>
		 <tbody>
		 	<?php $totalOpening = 0; $adjustment = -29742;?>
 	<tr id="datafont" style="color: red;">
		<td id="tabledata"></td>
		<td id="tabledata"></td>
		
		<td id="tabledata" colspan="2">OPENING STOCK</td>
		
		
		
		<td id="tabledata">{{number_format($openingStock[0]->stockin, 2)}}</td>
		<td id="tabledata">{{number_format($openingStock[0]->stockout, 2)}}</td>
		<td id="tabledata"></td>
		<?php $totalOpening = $openingStock[0]->stockin-$openingStock[0]->stockout ?>
		<td id="tabledata">{{number_format($totalOpening, 2)}}</td>
	</tr>
		 <?php $totalIn = 0; $totalOut = 0; $sum=0;?>
		 @if(count($items) > 0)
			@foreach($items as $item)
			<?php $sum = $sum + 1?>
					<tr>
						<td id="tabledata">{{$sum}}</td>
							<td id="tabledata">{{ date("d/m/Y", strtotime($item->date)) }}</td>
						
						<td id="tabledata">
							@if($item->vr_no != null)
							{{ $item->vr_no}}
							@endif
						</td>
						<td id="tabledata">
							@if ($item->sale_id != null)
							{{"SALE"}}
							@endif
							@if ($item->wastage_id != null)
							{{"WASTAGE | ADJUST"}}
							@endif
							@if ($item->pro_transfer_id != null)
							{{"PRODUCTION TRANSFER"}}
							@endif
							@if ($item->direct_transferID != null)
							{{"DIRECT TRANSFER"}}
							@endif

						</td>
						<td id="tabledata">
							@if($item->stockin!=null)
								{{ $item->stockin}} {{ $item->uoms->uom}}
							@endif
						</td>
						<td id="tabledata">
							@if($item->stockout!=null)
								{{ $item->stockout}} {{ $item->uoms->uom}}
							@endif
						</td>
						<td id="tabledata">
							@if($item->cost_amount!=null)
								{{ $item->cost_amount}}
							@endif
						</td>
						

						<?php $totalIn = $totalIn + $item->stockin?>

						<?php $totalOut = $totalOut + $item->stockout?>

				
					<td id="tabledata">{{number_format($totalIn-$totalOut+$totalOpening, 2)}} {{ $item->uoms->uom}}</td>
				</tr>
			@endforeach
			  <tr id="datafont">
					<td colspan="4" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;"><center><b>Total</b></center></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format($totalIn+$openingStock[0]->stockin, 2)}} {{$product[0]->uom}}</b></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format($totalOut+$openingStock[0]->stockout, 2)}} {{$product[0]->uom}}</b></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b></b></td>
					<?php
			$CStock = 0;
			$CStock = $totalIn-$totalOut;
			?>

					<td style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;"><b>{{number_format($CStock+$totalOpening, 2)}} {{$product[0]->uom}}</b></td>
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

