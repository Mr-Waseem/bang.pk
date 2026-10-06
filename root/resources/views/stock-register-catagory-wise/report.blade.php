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
	<div class="panel-heading" style="color:green;"><b>CATAGORY NAME:</b> <span style="color:blue;">{{$catagory[0]->catagory_name}}</span></div>
	<div class="panel-body">
		<!-- <tr>
			<td colspan="6" style="color:green;"><b>CATAGORY NAME:</b> <span style="color:blue;">{{$catagory[0]->catagory_name}}</span><!-
		</tr> -->
	<table class="table table-striped table-bordered table-hover dataTables-example" >

		<thead>
			<tr>
				<th>Serial#</th>
				<th>Product&nbsp;Code</th>
				<th>Product&nbsp;Name</th>
				<th>Product&nbsp;Cost</th>
				<th>Stock&nbsp;Cost</th>
				<th>C.Stock</th>  
			</tr>
		</thead>
		<tbody>
			  <?php $sum = 1; $count=1; $ProductCost=0; $StockCost=0; $CStock=0; ?>
			 	 
				@if(count($product) > 0)
				@foreach($product as $items)
				<tr>
					<td><?php echo $sum; ?></td>
					<td class="center">{{$items->product_code}}</td>
					<td class="center">{{$items->product_name}}</td>
					<td class="center">{{$items->product_cost}}</td>
					<?php $quantity_purchase = 0; $quantity_sale = 0; $challan = 0; $SReturn = 0; $PReturn = 0; $totalStock=0; $totalcost=0;?>
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
					<?php $totalStock = $quantity_purchase - $quantity_sale - $challan + $SReturn - $PReturn;?>
					<?php $totalcost = $items->product_cost*$totalStock ?>
					<td class="center">{{$totalcost}}</td>
					<td class="center">{{$totalStock}}</td>
				</tr>
				
				<?php 
				$ProductCost = $ProductCost + $items->product_cost;
				$StockCost = $StockCost + $totalcost;
				$CStock = $CStock + $totalStock;
				?>
			  @endforeach
			  <tr style="color:red;">
					<td colspan="3"><center>Total</center></td>
					<td>{{$ProductCost}}</td>
					<td>{{$StockCost}}</td>
					<td>{{$CStock}}</td>
					
				</tr>
			  @else
			<tr><td colspan="6" style="color:#FF0000;text-align:center;">No Records found</td>
			</tr>
			 @endif
			  </tbody>
				<!-- <tfoot>
					<tr>
					  <th>Serial#</th>
					  <th>Product&nbsp;Code</th>
					  <th>Product&nbsp;Name</th>
					  <th>Product&nbsp;Cost</th>
					  <th>Stock&nbsp;Cost</th>
					 <th>C.Stock</th>  
					</tr>
				</tfoot> -->
		</table>
		</div>
	</div>
	</section>
	</div>
</body>
</html>


