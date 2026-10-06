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
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Recipe</th>
			  
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Shop.Name</th>
			  <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid;">Account.Name</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Type</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">IN(Qty)</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">OUT(Qty)</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;">STOCK</th>
			</tr>
		</thead>
		 <tbody>
		 	<?php $totalOpening = 0;?>
		 	<tr id="datafont" style="color: red;">
				<td id="tabledata"></td>
				<td id="tabledata"></td>
				<td id="tabledata"></td>

				<td id="tabledata" style="font-size: initial;">OPENING STOCK</td>
				<td id="tabledata"></td>
				<td id="tabledata"></td>
				<td id="tabledata" style="font-size: initial;">{{number_format((int)$openingStock[0]->Purchase)}}</td>
				<td id="tabledata" style="font-size: initial;">{{number_format((int)$openingStock[0]->Sale)}}</td>
				
				<?php $totalOpening = $openingStock[0]->Purchase-$openingStock[0]->Sale ?>
				<td id="tabledata">{{number_format((int)$totalOpening)}}</td>
			</tr>
		 <?php $totalPurchase = 0; $totalPurReturn = 0; $totalSale=0; $totalSaleReturn=0; $sum=0; $rate=0;?>
		 @if(count($items) > 0)
			@foreach($items as $item)
			@if($item->sale_id ==null)
			<?php $sum = $sum + 1?>
					<tr>
						<td id="tabledata">{{$sum}}</td>
							<td id="tabledata">{{ date("d/m/Y", strtotime($item->date)) }}</td>
							<td id="tabledata">
								@if($item->recipe_name != null)
							{{$item->recipe_name->product_name}}
							@endif</td>
						<td id="tabledata">
							<!-- @if($item->parties != null)
							{{$item->parties->party_name}}
							@endif -->
							@if($item->shops != null)
							{{$item->shops->name}}
							@endif
						</td>
						<td id="tabledata">
							 @if($item->parties != null)
							{{$item->parties->party_name}} ({{$item->parties->code}})
							@endif
							
						</td>

						<td id="tabledata">
							@if ($item->voucher_type == "Cash Purchase")
							{{"PURCHASE"}}
							@endif
							@if ($item->voucher_type == "Sale Bill")
							{{"SALE"}}
							@endif
							@if ($item->voucher_type == "SalesTax Invoice")
							{{"STV"}}
							@endif
							@if ($item->voucher_type == "General Voucher")
							{{"JV"}}
							@endif
							@if ($item->voucher_type == "Cash Receipt")
							{{"CR"}}
							@endif
							@if ($item->voucher_type == "Cash Payment")
							{{"CP"}}
							@endif
							@if ($item->voucher_type == "Bank Receipt")
							{{"BR"}}
							@endif
							@if ($item->voucher_type == "Bank Payment")
							{{"BP"}}
							@endif
							@if ($item->voucher_type == "Sample")
							{{"Sample"}}
							@endif
							@if ($item->voucher_type == "Delivery Challan")
							{{"DC"}}
							@endif
							@if ($item->voucher_type == "Sale Return")
							{{"SR"}}
							@endif
							@if ($item->voucher_type == "Purchase Return")
							{{"PR"}}
							@endif
							@if ($item->voucher_type == "GRN")
							{{"GR"}}
							@endif
							@if ($item->voucher_type == "Production Stockin")
							{{"PRO.IN"}}
							@endif
							@if ($item->voucher_type == "Production StockOut")
							{{"PRO.OUT"}}
							@endif
							@if ($item->voucher_type == "Stock Direct Transfer")
							{{"STOCK.TRANSFER.D"}}
							@endif
							@if ($item->voucher_type == "OPENING STOCK")
							{{"OPENING STOCK"}}
							@endif
							@if ($item->voucher_type == "Wastage")
							{{"WASTAGE"}}
							@endif
							@if ($item->voucher_type == "Adjust")
							{{"ADJUST"}}
							@endif
							@if ($item->voucher_type == "Stock Transfer")
							{{"STOCK.TRANSFER.P"}}
							@endif
							@if ($item->voucher_type == "Credit Sale")
							{{"CREDIT.SALE"}}
							@endif
						</td>
						<td id="tabledata">
							@if($item->purchase_quantity!=null)
								{{number_format($item->purchase_quantity, 2)}} {{ $item->uoms->uom}} 
							@endif
						</td>
						<td id="tabledata">
							@if($item->sale_quantity!=null)
								{{number_format($item->sale_quantity, 2)}} {{ $item->uoms->uom}}
							@endif
						</td>
						

						<?php $totalPurchase = $totalPurchase + (int)$item->purchase_quantity?>
						<?php $totalPurReturn = $totalPurReturn + (int)$item->pur_ret_quantity?>
						<?php $totalSale = $totalSale + (int)$item->sale_quantity?>
						<?php $totalSaleReturn = $totalSaleReturn + (int)$item->sale_ret_quantity?>
					<?php $rate = $rate + $item->cost_rate?>
					<td id="tabledata">{{number_format($totalPurchase-$totalSale+$openingStock[0]->Purchase-$openingStock[0]->Sale, 2)}} {{ $item->uoms->uom}}</td>
				</tr>
				@endif
			@endforeach
			<tr id="datafont">
					<td colspan="6" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;"><center><b>Total Without Opening Balance</b></center></td>

					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$totalPurchase)}}</b></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$totalSale)}}</b></td>
					
					<td style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$totalPurchase-$totalSale)}}</b></td>
				</tr>
			  <tr id="datafont">
					<td colspan="6" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;"><center><b>Total</b></center></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format($totalPurchase+$openingStock[0]->Purchase, 2)}} {{$product[0]->uom}}</b></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format($totalSale+$openingStock[0]->Sale, 2)}} {{$product[0]->uom}}</b></td>
					<?php
			$CStock = 0;
			$CStock = $totalPurchase-$totalSale+$totalSaleReturn-$totalPurReturn+$openingStock[0]->Purchase-$openingStock[0]->Sale;
			?>

					<td style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;"><b>{{number_format($CStock, 2)}} {{$product[0]->uom}}</b></td>
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

