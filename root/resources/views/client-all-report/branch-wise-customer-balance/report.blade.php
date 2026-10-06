<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<!-- <body onload="window.print();"> -->
<body>
<div class="content-wrapper">
<section class="content">
@include("/header.report")		
<div class="panel panel-default">
<div class="panel-heading"><b>ALL PRODUCTS STOCK&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;WAREHOUSE NAME:{{$warehouse[0]->name}}</b></div>
<div class="panel-body">
<table class="table table-striped table-bordered table-hover dataTables-example" >
<thead>
	<tr>
		<th>Serial#</th>
		<th>Product&nbsp;Code</th>
		<th>Product&nbsp;Name</th>
		<th>Qty&nbsp;In&nbsp;Pack</th>
		<th>Qty&nbsp;Out&nbsp;Pack</th>
		<th style="border: 1px solid red;">C.Stock(Pack)</th> 
		<th>Weight&nbsp;In&nbsp;KG</th>
		<th>Weight&nbsp;Out&nbsp;KG</th>
		<th style="border: 1px solid blue;">C.Stock(Weight)</th>  
	</tr>
</thead>
<tbody>
  <?php $sum = 1; ?>
  @foreach($products as $product)
	<tr>
		<td><?php echo $sum; ?></td>
		<td class="center">{{$product->product_code}}</td>
		<td class="center">{{$product->product_name}}</td>
<?php $challan = 0; $SReturn = 0; $PReturn = 0; $QtyInPackKg = 0; $QtyInPackBag = 0; $totalQtyInPackKg = 0; $totalPackQtyBag = 0; $totalWeightInKg = 0; $totalWeightInBag = 0; $PackQtyBag = 0; $QtyWeightInKg = 0; $QtyWeightInBag = 0; $PackQtyOutKg=0; $TotalQtyOutPackBag=0; $totalPackQtyOutKg=0; $QtyWeightOutBag=0; $GrandQtyInPack=0; $GrandWeightInKg =0; $GrandQtyOutPack=0; $GrandWeightOutKg =0; $TotalQtyWeightOutKg=0; $WeightOutKg = 0; ?>
		<!------------Qty In Pack----------------->
		@foreach($product->products_detail as $detail)
		@if($detail->warehouse_id == $warehouse[0]->id)
		@if($detail->unit->uom == "KG" || $detail->unit->uom == "PCS")
			<?php 
			//2
			$QtyInPackKg = (int)$detail->quantity/(int)$product->pack_weight;
			$totalQtyInPackKg = $totalQtyInPackKg+$QtyInPackKg;
			//100
			$QtyWeightInKg = (int)$detail->quantity;
			$totalWeightInKg = $totalWeightInKg+$QtyWeightInKg;
			?>
		@endif
		@if($detail->unit->uom == "BAG" || $detail->unit->uom == "CANS" || $detail->unit->uom == "COTTON")
			<?php
			//3
			$QtyInPackBag = (int)$detail->quantity;
			$totalPackQtyBag = $totalPackQtyBag+$QtyInPackBag;
			//150
			$QtyWeightInBag = (int)$detail->quantity*(int)$product->pack_weight;
			$totalWeightInBag = $totalWeightInBag+$QtyWeightInBag;
			?>
		@endif
		@endif
		@endforeach
		<?php 
		$GrandQtyInPack = $totalPackQtyBag+$totalQtyInPackKg;
		$GrandWeightInKg = $totalWeightInKg+$totalWeightInBag;
		//$GrandqtyinCans = $totalQtyInPackKg+$totalPackQtyCan;
		?>
		<!--------------------Qty Out Pack------------------------->
		@foreach($product->sale_detail as $sale_details)
		@if($sale_details->warehouse_id == $warehouse[0]->id)
		@if($sale_details->unit->uom == "KG" || $sale_details->unit->uom == "PCS")
			<?php
			//0.5
			 $PackQtyOutKg = (int)$sale_details->quantity/(int)$product->pack_weight;
			$totalPackQtyOutKg = $totalPackQtyOutKg+$PackQtyOutKg;
			//25
			$QtyWeightOutKG = (int)$sale_details->quantity;
			$TotalQtyWeightOutKg = $TotalQtyWeightOutKg;
			$TotalQtyWeightOutKg = $TotalQtyWeightOutKg+$QtyWeightOutKG;
			?>
		@endif
		 @if($sale_details->unit->uom == "BAG" || $sale_details->unit->uom == "CANS" || $sale_details->unit->uom == "COTTON")
			<?php
			//1 bag
			 $QtyOutPackBag = (int)$sale_details->quantity;
			$TotalQtyOutPackBag = $TotalQtyOutPackBag+$QtyOutPackBag;
			//50kg
			$QtyWeightOutBag = (int)$sale_details->quantity*(int)$product->pack_weight;
			?>
		@endif 
		@endif 
		@endforeach
		<!-------End quantity out pack---------------------------->
		<?php 
		$GrandQtyOutPack = $TotalQtyOutPackBag+$totalPackQtyOutKg;
		$GrandWeightOutKg = $QtyWeightOutBag+$TotalQtyWeightOutKg;
		?>
		<?php $purchaseQtyBag = 0; $totalPurchaseQtyBag = 0; 
			  $purchaseQtyKg = 0; $totalPurchaseQtyKg = 0;
			  $purchaseQtyBags = 0; $totalPurchaseQtyBags = 0;
			  $purchaseQtyKgs = 0; $totalPurchaseQtyKgs = 0;
			  $PurchaseReturnInKg=0; $PurchaseReturnInBag =0;  ?>

		@foreach($product->purchase_return_detail as $PurReturndetail)
		@if($PurReturndetail->warehouse_id == $warehouse[0]->id)
		@if($PurReturndetail->unit->uom == "KG" || $PurReturndetail->unit->uom == "PCS")
			<?php
			//1Bag
			 $purchaseQtyKgs = (int)$PurReturndetail->quantity/(int)$product->pack_weight;
			$totalPurchaseQtyKgs = $totalPurchaseQtyKgs+$purchaseQtyKgs;
			//50Kg
			$purchaseQtyBags = (int)$PurReturndetail->quantity;
			$totalPurchaseQtyBags = $totalPurchaseQtyBags+$purchaseQtyBags;

			?>
		@endif

		@if($PurReturndetail->unit->uom == "BAG" || $PurReturndetail->unit->uom == "CANS" || $PurReturndetail->unit->uom == "COTTON")
			<?php
			//2bag
			$purchaseQtyBag = (int)$PurReturndetail->quantity;
			$totalPurchaseQtyBag = $totalPurchaseQtyBag+$purchaseQtyBag;
			//100 kg
			$purchaseQtyKg = (int)$PurReturndetail->quantity*(int)$product->pack_weight;
			$totalPurchaseQtyKg = $totalPurchaseQtyKg+$purchaseQtyKg;
			?>
		@endif
		@endif
		@endforeach
		<?php 
		//Total kg return
		$PurchaseReturnInKg = $totalPurchaseQtyBags + $totalPurchaseQtyKg;
		//Total Bags Return
		$PurchaseReturnInBag = $totalPurchaseQtyKgs + $totalPurchaseQtyBag;
		 ?>

		<?php $saleQtyBag = 0; $totalsaleQtyBag = 0; 
			  $saleQtyKg = 0; $totalsaleQtyKg = 0;
			  $saleQtyBags = 0; $totalsaleQtyBags = 0;
			  $saleQtyKgs = 0; $totalsaleQtyKgs = 0;
			  $saleReturnInKg=0; $saleReturnInBag =0;  ?>
		@foreach($product->sale_return_detail as $SaleReturndetail)
		@if($SaleReturndetail->warehouse_id == $warehouse[0]->id)
		@if($SaleReturndetail->uoms->uom == "KG" || $SaleReturndetail->uoms->uom == "PCS")
			<?php
			//1.6 Bags
			 $saleQtyBags = (int)$SaleReturndetail->quantity/(int)$product->pack_weight;
			$totalsaleQtyBags = $totalsaleQtyBags+$saleQtyBags;
			//80Kg
			$saleQtyKgs = (int)$SaleReturndetail->quantity;
			$totalsaleQtyKgs = $totalsaleQtyKgs+$saleQtyKgs;

			?>
		@endif
		@if($SaleReturndetail->uoms->uom == "BAG" || $SaleReturndetail->uoms->uom == "CANS" || $SaleReturndetail->uoms->uom == "COTTON")
			<?php
			//2bag
			$saleQtyBag = (int)$SaleReturndetail->quantity;
			$totalsaleQtyBag = $totalsaleQtyBag+$saleQtyBag;
			//100 kg
			$saleQtyKg = (int)$SaleReturndetail->quantity*(int)$product->pack_weight;
			$totalsaleQtyKg = $totalsaleQtyKg+$saleQtyKg;
			?>
		@endif
		@endif
		@endforeach
		<?php 
		//Total kg return
		$saleReturnInKg = $totalsaleQtyKg + $totalsaleQtyKgs;
		//Total Bags Return
		$saleReturnInBag = $saleQtyBag + $saleQtyBags;
		$grandQtyInPacks=0;
		$grandQtyInPacks=$GrandQtyInPack-$PurchaseReturnInBag;
		//$grandQtyInPacksCans=$GrandqtyinCans;
		$grandQtyoutPacks=$GrandQtyOutPack+$saleReturnInBag;
		$grandWeightInKgs=$GrandWeightInKg-$PurchaseReturnInKg;
		$grandWeightOutKgs=$GrandWeightOutKg+$saleReturnInKg;
		 ?>
		<!--  <td style="background: red;">{{$saleReturnInBag}}</td> -->
		<td class="center">
			<!-- @if($product->pack_type=="CANS")
			{{number_format($grandQtyInPacks, 2)}} {{$product->pack_type}}
			@endif -->
			{{number_format($grandQtyInPacks, 2)}} {{$product->pack_type}}
		</td>
		<!--------------Qty OuT Pack--------------->
		<td class="center">{{number_format($grandQtyoutPacks, 2)}} {{$product->pack_type}}</td>
		<!--------------Pack Quantity--------------->
		<td class="center" style="border: 1px solid red;">{{number_format($grandQtyInPacks-$grandQtyoutPacks, 2)}} {{$product->pack_type}}</td>
		<!--------------Weight In KG--------------->
		<td class="center">{{$grandWeightInKgs}} {{$product->uom}}</td>
		<!--------------Weight Out KG--------------->
		<td class="center">{{$grandWeightOutKgs}} {{$product->uom}}</td>
		
		<td class="center" style="border: 1px solid blue;">{{number_format($grandWeightInKgs-$grandWeightOutKgs, 2)}} {{$product->uom}}</td>
	</tr>
	<?php $sum = $sum + 1;?>
  @endforeach
  </tbody>
	<tfoot>
		<tr>
			<th>Serial#</th>
			<th>Product&nbsp;Code</th>
			<th>Product&nbsp;Name</th>
			<th>Qty&nbsp;In&nbsp;Pack</th>
			<th>Qty&nbsp;Out&nbsp;Pack</th>
			<th style="border: 1px solid red;">C.Stock(Pack)</th>  
			<th>Weight&nbsp;In&nbsp;KG</th>
			<th>Weight&nbsp;Out&nbsp;KG</th>
			<!-- <th>Pack&nbsp;Quantity</th> --> 
			
			<th style="border: 1px solid blue;">C.Stock(Weight)</th>  
		</tr>
	</tfoot>
</table>
	</div>
</div>
</section>
</div>
</body>
</html>


