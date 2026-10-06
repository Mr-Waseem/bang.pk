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
	<div><b id="voucherName">CONSUMED SINGLE ITEM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PRODUCT ID: {{$Product[0]->product_code}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Name: {{$Product[0]->product_name}}</b></div>
<div class="panel-body" style="border-top:2px solid;">
<!-- <table class="table table-striped table-bordered table-hover dataTables-example" > -->
<table style="width:100%;">
	<thead>
	<tr >	
	  <th style="width:10%; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">Vr.No</th>
	   <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">DATE</th>
	  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid; text-align: left;">QTY</th>
	  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid; text-align: left;">Product.Name</th>
	  <th style="width:30%; border-top: 2px solid;border-bottom: 2px solid;">RATE</th>
	  <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;">AMOUNT</th>
	</tr>
	</thead>
	 <tbody>
	 <?php $sumQTY = 0; $sumRate = 0; $sumAmount = 0;?>
		 @if(count($production) > 0)
			@foreach($production as $GeneralVouchers)
			<tr id="datafont">
				<td id="tabledata"><a href="production/{{$GeneralVouchers->production->id}}" target="__blank"><b>00{{$GeneralVouchers->production->vr_no}}</b></a></td>
				<td id="tabledata">
					{{ date("d/m/Y", strtotime($GeneralVouchers->created_at)) }}
				</td>
				<td id="tabledata" style="text-align: left;">{{$GeneralVouchers->quantity}} {{$GeneralVouchers->uom_pro_details->uom}}</td>
				<td id="tabledata">{{$GeneralVouchers->production->products->product_name}}</td>
				<td id="tabledata">{{ number_format((int)$GeneralVouchers->rate)}}</td>
				<td id="tabledata">{{ number_format((int)$GeneralVouchers->amount) }}</td>
			</tr>
			<?php 
				$sumQTY = $sumQTY + $GeneralVouchers->quantity;
				$sumRate = $sumRate + $GeneralVouchers->rate;
				$sumAmount = $sumAmount + $GeneralVouchers->amount; 
			?>
			@endforeach
					
			
		 <tr id="datafont">
			<td colspan="2" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;"><center><b>Total</b></center></td>
			<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$sumQTY)}}</b></td>
			<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b></b></td>
			<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$sumRate)}}</b></td>
			<td style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$sumAmount)}}</b></td>
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

