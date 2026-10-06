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
	<!-- <center id="systemDetail" >FROM:</center>	 -->
	<div style="border:2px solid;">
		<div><b id="voucherName">SALE POINT STOCK ({{$warehouse[0]->name}})</b></div>
	<div class="panel-body" style="border-top:2px solid;">
	<!-- <table class="table table-striped table-bordered table-hover dataTables-example" > -->
	<table style="width:100%;">
		<thead>
			<tr >	
			  <th style="width:10%; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">SR#</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Product&nbsp;Code</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Product&nbsp;Name</th>
			  <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid;">C.Stock</th>
			   <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Product&nbsp;Cost</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;">Total&nbsp;Cost</th>
			  
			</tr>
		</thead>
		 <tbody>
		 <?php $sum = 1; $stock=0; $totalCost = 0; $GrandCost = 0; $totalStock = 0; $cost=0;?>
			 @if(count($SalePoint) > 0)
				@foreach($SalePoint as $items)
				@php $stock = $items->stockin-$items->stockout;
							 $cost = $stock*$items->product_cost;

						 @endphp
						 @if($stock != "0.00")
					<tr id="datafont">
						<td id="tabledata">{{$sum}}</td>
						<td id="tabledata">{{$items->product_code}}</td>
						<td id="tabledata">{{$items->product_name}}</td>
						<td id="tabledata">{{number_format($stock, 2)}}</td>
						 <td id="tabledata">{{number_format($items->product_cost,2)}}</td>
						<!-- <td id="tabledata">{{number_format($items->cost,2)}}</td> -->
						@php $totalCost = $stock*$items->product_cost; @endphp
						<td id="tabledata">{{number_format($totalCost, 2)}}</td>

						
					</tr>
					@php $sum = $sum + 1;
						$GrandCost = $GrandCost + $totalCost;
						$totalStock = $totalStock + $items->stockin-$items->stockout;
					 @endphp
					 @endif
					@endforeach
					<tr id="datafont">
						<td id="tabledata">Total</td>
						<td id="tabledata"></td>
						<td id="tabledata"></td>
						<td id="tabledata">{{$totalStock}}</td>
						<td id="tabledata"></td>
						<td id="tabledata">{{$GrandCost}}</td>
						
					</tr>
						
				
				
			 @else
				<tr><td colspan="7" style="color:#FF0000;text-align:center;">No Records found</td></tr>
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

