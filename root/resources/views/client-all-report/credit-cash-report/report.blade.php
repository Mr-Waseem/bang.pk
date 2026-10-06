<html>
	<head>
<link href="/css/bg.css" rel="stylesheet">
	</head>
	<body>
		<div class="content-wrapper">
        <section class="content">
		@include("/header.report")
			<!-- <center><span id="systemDetail">FROM {{date('d/m/Y', Strtotime($fromDate))}} TO {{date('d/m/Y', Strtotime($toDate))}}</span> </center> -->
			<div id="systemDetail"><b>FROM {{date('d/m/Y', Strtotime($fromDate))}} TO {{date('d/m/Y', Strtotime($toDate))}}</b></div>
	<div style="border:2px solid;">
		<div id="voucherName"><b>ALL ACCOUNTS REPORT</b></div>
	<div class="panel-body" style="border-top:2px solid;">
	<table>
		<thead>
			<tr>	
			  <th style="width:5%;border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid; font-size: small;">SR.No</th>
			  <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid; font-size: small;">CUSTOMER&nbsp;NAME</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid; font-size: small;">CELL</th>
			  <th style="width:5%; border-top: 2px solid;border-bottom: 2px solid; font-size: small;">TOTAL&nbsp;SALE</th>
			  <th style="width:5%; border-top: 2px solid;border-bottom: 2px solid; font-size: small;">TOTAL&nbsp;CASH</th>
			  <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid; font-size: small;">BALANCE</th>
			</tr>
		</thead>
		 <tbody>
		 <?php $sum=0; $granddebit=0; $grandcredit=0;?>
		 @foreach($party as $parties)
		 <?php $totalDebit = 0; $totalCredit = 0;?>
		 @php $sum = $sum + 1; @endphp
		 <tr id="datafont">
		 		<td id="tabledata">{{$sum}}</td>
		 		<td id="tabledata">{{$parties->party_name}}</td>
		 		<td id="tabledata">{{$parties->phone}}</td>
		 		<td id="tabledata">{{$parties->debit}}</td>
		 		<td id="tabledata">{{$parties->credit}}</td>
		 		<?php
					$totalDebit = $totalDebit + $parties->debit;
					$totalCredit = $totalCredit + $parties->credit;
					$granddebit = $granddebit + $parties->debit;
					$grandcredit = $grandcredit + $parties->credit;
					?>
			
		<td id="tabledata">{{$totalDebit-$totalCredit}}</td>
				</tr>
		@endforeach
				<tr id="datafont">
				<td colspan="3" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;"><center><b style="float:right;">Total</b></center></td>
				
				<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;">{{$granddebit}}</td>
				<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;">{{$grandcredit}}</td>
				<td style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;">{{$granddebit-$grandcredit}}</td>
				</tr>
			 
			 
		 </tbody>
	</table>
		</div>
	</div>
</section>
	</div>

		
	
		</body>
		</html>


