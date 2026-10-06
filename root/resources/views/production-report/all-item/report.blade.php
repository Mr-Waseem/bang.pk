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
	<div><b id="voucherName">PRODUCTION REPORT (ALL ITEMS) </b></div>
<div class="panel-body" style="border-top:2px solid;">
<!-- <table class="table table-striped table-bordered table-hover dataTables-example" > -->
<table style="width:100%;">
	<thead>
	<tr >	
	  <th style="width:10%; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">Vr.No</th>
	   <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">DATE</th>
	   <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">ITEM CODE</th>
	   <th style="width:30%; border-top: 2px solid;border-bottom: 2px solid; text-align: left;">ITEM NAME</th>
	  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">QTY</th>
	  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">RECIPE RATE</th>
	  <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;">AMOUNT</th>
	</tr>
	</thead>
	 <tbody>
	 <?php $sumQTY = 0; $sumRate = 0; $sumAmount = 0;?>
		 @if(count($production) > 0)
			@foreach($production as $GeneralVouchers)
			<tr id="datafont">
				<td id="tabledata"><a href="/production/{{$GeneralVouchers->id}}" target="__blank"><b>00{{$GeneralVouchers->vr_no}}</b></a></td>
				<td id="tabledata">
					{{ date("d/m/Y", strtotime($GeneralVouchers->date)) }}
				</td>
				<td id="tabledata">{{$GeneralVouchers->products->product_code}}</td><td id="tabledata" style="text-align: left;">{{$GeneralVouchers->products->product_name}}</td>
				<td id="tabledata">{{$GeneralVouchers->quantitys}} {{$GeneralVouchers->uoms->uom}}</td>
				<td id="tabledata">{{ number_format((int)$GeneralVouchers->rates)}}</td>
				<td id="tabledata">{{ number_format((int)$GeneralVouchers->amounts) }}</td>
			</tr>
			<?php 
				$sumQTY = $sumQTY + $GeneralVouchers->quantitys;
				$sumRate = $sumRate + $GeneralVouchers->rates;
				$sumAmount = $sumAmount + $GeneralVouchers->amounts; 
			?>
			@endforeach
					
			
		 <tr id="datafont">
			<td colspan="4" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;"><center><b>Total</b></center></td>
			<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$sumQTY)}}</b></td>
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

