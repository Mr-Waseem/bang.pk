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
		<div><b id="voucherName">STOCK WASTAGE | ADJUST REPORT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;BRANCH NAME: 
			@if(Count($shops) > 0)
			{{$shops[0]->name}}
			@else
			{{"ALL BRANCHES"}}
			@endif

			
		</b></div>
	<div class="panel-body" style="border-top:2px solid;">
	<!-- <table class="table table-striped table-bordered table-hover dataTables-example" > -->
	<table style="width:100%;">
		<thead>
			<tr >	
			  <th style="width:10%; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">Date</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid; text-align: left;">Ivnoice#</th>
			  <!-- <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Party</th> -->
			  <th style="width:30%; border-top: 2px solid;border-bottom: 2px solid;">Product&nbsp;Name</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Qty.Waste</th>
			  <!-- <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Qty.Adjust</th> -->
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Qty.Adjust</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Cost Rate</th>
			  <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;">Total Cost</th>
			</tr>
		</thead>
		 <tbody>
		 <?php $quantityWaste = 0; $quantityAdjust = 0; $CostRate =0; $TotalCost =0; ?>
				 
					 @if(count($sales) > 0)
						@foreach($sales as $sale)
						
					<tr id="datafont">
						<td id="tabledata">{{ date("d/m/Y", strtotime($sale->wastages->date)) }}</td>
						<td id="tabledata">{{ $sale->wastages->invoice_no}}</td>
						<!-- <td id="tabledata">{{$sale->parties->party_name}}</td> -->
						
						<td id="tabledata">{{ $sale->products->product_name}}</td>
						
						<td id="tabledata">
							@if( $sale->wastages->sale_list == "Wastage")
							{{ $sale->quantity }}
							@php $quantityWaste = $quantityWaste + $sale->quantity; @endphp
							@endif
						</td>
						<td id="tabledata">
							@if( $sale->wastages->sale_list == "Adjust")
							{{ $sale->quantity }}
							@php $quantityAdjust = $quantityAdjust + $sale->quantity; @endphp
							@endif
						</td>
						<td id="tabledata">
							
							{{ $sale->sale_rate }}
							
						</td>
						<td id="tabledata">
							
							{{ $sale->sale_amount }}
							@php
							 $CostRate = $CostRate + $sale->sale_rate; 
							 $TotalCost = $TotalCost + $sale->sale_amount; 
							 @endphp
						
						</td>
						

					</tr>
					
					@endforeach	
				
				 <tr id="datafont">
					<td colspan="3" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;"><center><b>Total</b></center></td>
					
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format($quantityWaste, 2)}}</b></td>
					
					<td style="border-top: 2px solid;border-bottom: 2px solid; text-align:center;"><b>{{number_format($quantityAdjust, 2)}}</b></td>
					<td style="border-top: 2px solid;border-bottom: 2px solid; text-align:center;"><b>{{number_format($CostRate, 2)}}</b></td>
					<td style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;"><b>{{number_format($TotalCost, 2)}}</b></td>
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

