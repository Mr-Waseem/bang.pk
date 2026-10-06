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
		
	<div style="border:2px solid;">
		<div><b id="voucherName">All Products Stock</b></div>
	<div class="panel-body" style="border-top:2px solid;">
	<table style="width:100%;">
		<thead>
			<tr >	
			  <th style="width:10%; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">Serial</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid; text-align: left;">Code</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Product&nbsp;Name</th>
			  <th style="width:30%; border-top: 2px solid;border-bottom: 2px solid;">Product&nbsp;Cost</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Stock&nbsp;Cost</th>
			  <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;">C.Stock</th>
			</tr>
		</thead>
		 <tbody>
		
				<?php $sum = 1; $count=1;?>
			   @foreach($product as $catagories)
			   @if(count($catagories->products[0]->products_detail) >0 || count($catagories->products[0]->sale_detail) >0)
			   <tr style="background: #a0c6ff;">
					<td colspan="6" style="color:green;border-bottom: 2px solid black;"><b>CATAGORY NAME:</b> <span style="color:blue;">{{$catagories->catagory_name}}</span>
				</tr>
			   @foreach($catagories->products as $items)
			   	@if(count($items->products_detail) >0 || count($items->sale_detail) >0)
			   	
			  <?php $quantity_purchase = 0; $quantity_sale = 0; $challan = 0; $SReturn = 0; $PReturn = 0; $totalStock=0; $totalcost=0; $pstockin = 0; $pstockout = 0;?>
					@foreach($items->products_detail as $detail)
					<?php $quantity_purchase = $quantity_purchase + $detail->quantity; ?>
					@endforeach
					@foreach($items->sale_detail as $detail)
					<?php $quantity_sale = $quantity_sale + $detail->quantity; ?>
					@endforeach
					@foreach($items->challan_detail as $Challandetail)
					<?php $challan = $challan + $Challandetail->quantity; ?>
					@endforeach
					@foreach($items->sale_return_detail as $SaleReturndetail)
					<?php $SReturn = $SReturn + $SaleReturndetail->quantity; ?>
					@endforeach
					@foreach($items->purchase_return_detail as $PurReturndetail)
					<?php $PReturn = $PReturn + $PurReturndetail->quantity; ?>
					@endforeach

					@foreach($items->production_stockin as $ProStockIn)
					<?php $pstockin = $pstockin + $ProStockIn->quantitys; ?>
					@endforeach
					@foreach($items->production_stockout as $ProStockOut)
					<?php $pstockout = $pstockout + $ProStockOut->quantity; ?>
					@endforeach


					<?php $totalStock = $quantity_purchase - $quantity_sale - $challan + $SReturn - $PReturn + $pstockin - $pstockout;?>
					<tr id="datafont">
						<td id="tabledata"><?php echo $sum; ?></td>
						<td id="tabledata">{{$items->product_code}}</td>
						<td id="tabledata">{{$items->product_name}}</td>
						<td id="tabledata">{{$items->product_cost}}</td>
						
						<?php $totalcost = $items->product_cost*$totalStock ?>
						<td id="tabledata">{{$totalcost}}</td>
						<td id="tabledata">{{$totalStock}} {{$items->uom}}</td>
					</tr>
					<?php $sum = $sum + 1;?>
				<!-- <?php $count = $count+1;?> -->
				@endif
			  @endforeach
			  @endif
			  @endforeach
			   
				


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

