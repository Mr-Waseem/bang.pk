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
		<div><b id="voucherName">DAILY CASH BOOK SHOP: {{$shop[0]->name}}</b></div>
	<div class="panel-body" style="border-top:2px solid;">
	<!-- <table class="table table-striped table-bordered table-hover dataTables-example" > -->
	<table style="width:100%;">
		<thead>
			<tr >	
			  <th style="width:10%; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">SR.NO</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid; text-align: left;">Date</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">VR.NO</th>
			  <th style="width:30%; border-top: 2px solid;border-bottom: 2px solid;">VR.TYPE</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">PARTY&nbsp;NAME</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">IN</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">OUT</th>
			  <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;">BALANCE</th>
			</tr>
		</thead>
		 <tbody>
		 	<?php $totalOpening = 0;?>
		 	<tr id="datafont" style="color: red;">
				<td id="tabledata"></td>
				<td id="tabledata"></td>
				<td id="tabledata"></td>
				<td id="tabledata">OPENING CASH</td>
				<td id="tabledata"></td>
				<td id="tabledata">{{number_format((int)$openingCash[0]->OpeningIN)}}</td>
				<td id="tabledata">{{number_format((int)$openingCash[0]->OpeningOUT)}}</td>
				<?php $totalOpening = $openingCash[0]->OpeningIN-$openingCash[0]->OpeningOUT ?>
				<td id="tabledata">{{number_format((int)$totalOpening)}}</td>
			</tr>
		 <?php $sum=0; $totalIn = 0; $totalOut = 0;?>
		 @if(isset($Payment))
			 @if(count($Payment) > 0)
				@foreach($Payment as $Payments)
				@php  $sum= $sum + 1; @endphp
					<tr id="datafont">
						<td id="tabledata">{{$sum}}</td>
						<td id="tabledata">{{ date("d/m/Y", strtotime($Payments->date)) }}</td>
						<td id="tabledata">{{$Payments->vr_no}}</td>
						<td id="tabledata">{{$Payments->vr_type}}</td>
						<td id="tabledata">{{$Payments->party_name}}</td>

						<td id="tabledata">{{$Payments->in}}</td>
						<td id="tabledata">{{$Payments->out}}</td>
						<?php $totalIn = $totalIn  + (int)$Payments->in; ?>
						<?php $totalOut = $totalOut  + (int)$Payments->out; ?>
						<td id="tabledata">{{ number_format((int)$totalIn-$totalOut) }}</td>
					</tr>
					@endforeach
						
				
				 <tr id="datafont">
					<td colspan="5" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;"><center><b>Total Without Opening Balance</b></center></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$totalIn)}}</b></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$totalOut)}}</b></td>
					<td style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$totalIn-$totalOut)}}</b></td>
				</tr>
				<tr id="datafont">
					<td colspan="5" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;"><center><b>TOTAL</b></center></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$openingCash[0]->OpeningIN + $totalIn)}}</b></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$openingCash[0]->OpeningOUT + $totalOut)}}</b></td>
					<td style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;"><b>{{number_format((int)$openingCash[0]->OpeningIN-$openingCash[0]->OpeningOUT+$totalIn-$totalOut)}}</b></td>
				</tr>
				@endif	
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

