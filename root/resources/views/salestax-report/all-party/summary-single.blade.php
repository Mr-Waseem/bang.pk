<html>
<head>
  <link href="/css/bg.css" rel="stylesheet">
</head>
<!-- <body onload="window.print();"> -->
<body>
	<div>
	@if(Count($warehouse) > 0)
	<section class="content">
	  <center><h3><u><b id="systemTitle">{{$warehouse[0]->name}}</b></u></h3></center>
	<center><b id="systemDetail">{{$warehouse[0]->address}}</b></center>
	<center><b id="systemDetail">PH :{{$warehouse[0]->phone}}</b><center>
	<center><b id="systemDetail">Email :{{$warehouse[0]->email}}</b><center>
	</br>
		<span style="float: right;margin-top: -19px " id="systemDetail">@php
				$t=time(); ($t . "<br>"); echo(date("d/m/Y",$t));
			@endphp
		</span>
	@else
	<section class="content">
	  <center><h3><u><b id="systemTitle">ALL BRANCHES</b></u></h3></center>

	</br>
		<span style="float: right;margin-top: -19px " id="systemDetail">@php
				$t=time(); ($t . "<br>"); echo(date("d/m/Y",$t));
			@endphp
		</span>
	@endif
	<center id="systemDetail">FROM:{{date("d/m/Y", Strtotime($fromDate))}} TO:{{date("d/m/Y", Strtotime($toDate))}}</center>	
	<div style="border:2px solid;">
		<div><b id="voucherName"><center>All Parties SaleTax Report</center></b></div>
	<div class="panel-body" style="border-top:2px solid;">
	<!-- <table class="table table-striped table-bordered table-hover dataTables-example" > -->
	<table>
		<thead>
			<tr >	
			  <th style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">Date</th>
			  <th style="width:5%; border-top: 2px solid;border-bottom: 2px solid;">Ivn#</th>
			  <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid;">Party&nbsp;Name</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">NTN</th>
			<th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">WEIGHT</th>
			  
			  <!-- <th>Purchase&nbsp;Price</th> -->
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Tax&nbsp;Value</th>
			    <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid;">Value.Exclusive.Tax</th>
			  <!-- <th style="width:5%; border-top: 2px solid;border-bottom: 2px solid;">Total</th> -->
			  <th style="width:40%; border-top: 2px solid;border-bottom: 2px solid;">Grand.Total</th>
			  <!-- <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">ST%</th>
			  <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid;">S.Tax&nbsp;Value</th>
			  <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;">Total&nbsp;Value</th> -->
			</tr>
		</thead>
		 <tbody>
		 <?php $grand = 0; $grandValExcST=0; $grandSTValue=0; $GrandWeight=0;  ?>
		 @if(isset($sales))
			 @if(count($sales) > 0)
				@foreach($sales as $sale)											<?php $ValExcST=0; $STValue=0; $total = 0; $TotalWeight=0; ?>
					<tr id="datafont">
						<td id="tabledata">{{ date("d/m/Y", strtotime($sale->date)) }}</td>
						<td id="tabledata">{{ $sale->invoice_no}}</td>
						<td id="tabledata">
							@if($sale->parties!=null)
							{{$sale->parties->party_name}}
							@endif
						</td>
						<td id="tabledata">
							@if($sale->parties!=null)
							{{$sale->parties->ntn}}
							@endif
						</td>

						@foreach($sale->saletax_details as $products)
						<?php
						$TotalWeight = $TotalWeight + $products->quantity;
						$ValExcST = $ValExcST + $products->taxvalue;
						$STValue = $STValue + $products->price;
						$total = $total + $products->total;
					
						?>
						@endforeach
						

						
						<td id="tabledata">{{number_format($TotalWeight)}}</td>
						<td id="tabledata">{{number_format($STValue)}}</td>
						<td id="tabledata">{{number_format($ValExcST)}}</td>
						<td id="tabledata">{{number_format($total)}}</td>
						<?php
						$GrandWeight = $GrandWeight + $TotalWeight;
						$grandValExcST = $grandValExcST + $ValExcST;
						$grandSTValue = $grandSTValue + $STValue;
						$grand = $grand + $total;
						?>

					</tr>
						
				@endforeach
				<tr id="datafont">
					<td colspan="4" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;"><center><b>Total</b></center></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format($GrandWeight)}}</b></td>
					
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format($grandValExcST)}}</b></td>
					
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format($grandSTValue)}}</b></td>
					<td style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;"><b>{{number_format($grand)}}</b></td>
				</tr>
				
			 @endif	
			 @else
				<tr><td colspan="7" style="color:#FF0000;text-align:center;">No Sales found</td></tr>
			 @endif
		 </tbody>
	</table>
	</div>
	</div>
</section>
	</div>

	

</body>
</html>


