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
<div class="panel-heading"><b>Stock Register Specific Item ({{$items[0]->product_name}})</b></div>
<div class="panel-body">
<table class="table table-striped table-bordered table-hover dataTables-example" >
	<thead>
		<tr>	
		  <th>Sr#</th>
		  <th>Date</th>
		  <th>Code</th>
		  <th>Account.Name</th>
		  <th>Type</th>
		  <th>Purchase(Qty)</th>
		  <th>Ret.Pur(Qty)</th>
		  <th>Sale(Qty)</th>
		  <th>Ret.Sale(Qty)</th>
		  <th>Total&nbsp;Rate</th>
		</tr>
	</thead>
	 <tbody>
	 <?php $totalPurchase = 0; $totalPurReturn = 0; $totalSale=0; $totalSaleReturn=0; $sum=0;?>
	 
		 @if(count($items) > 0)
			@foreach($items as $item)
			<?php $sum = $sum + 1?>
			<tr>
				<td>{{$sum}}</td>
				<td>{{ date("d/m/Y", strtotime($item->date)) }}</td>
				<td>{{$item->id}}</td>
				<td>{{$item->party_name}}</td>
				<td>
					@if ($item->voucher_type == "Cash Purchase")
					{{"PB"}}
					@endif
					@if ($item->voucher_type == "Sale Bill")
					{{"SB"}}
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
				</td>
				<td>{{ $item->purchase_quantity}} </td>
				<td>{{ $item->pur_ret_quantity}}</td>
				<td>{{ $item->sale_quantity}}</td>
				<td>{{ $item->sale_ret_quantity}}</td>
				<td>{{ $item->cost_rate}}</td>
<?php $totalPurchase = $totalPurchase + $item->purchase_quantity?>
<?php $totalPurReturn = $totalPurReturn + $item->pur_ret_quantity?>
<?php $totalSale = $totalSale + $item->sale_quantity?>
<?php $totalSaleReturn = $totalSaleReturn + $item->sale_ret_quantity?>
				</tr>
			@endforeach
			<tr>
			<td colspan="5"><center><b style="float:right;">Total</b></center></td>
			<td>{{$totalPurchase}}</td>
			<td>{{$totalPurReturn}}</td>
			<td>{{$totalSale}}</td>
			<td>{{$totalSaleReturn}}</td>
			<td>{{$totalSaleReturn}}</td>
			</tr>
			<tr>
			<td colspan="9"><center><b style="float:right;">C.Stock</b></center></td>
			<?php
			$CStock = 0;
			$CStock = $totalPurchase-$totalSale+$totalSaleReturn-$totalPurReturn;
			?>
			<td>{{$CStock}}</td>
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


