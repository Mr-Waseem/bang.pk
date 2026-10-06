<html>
	<head>
<link href="/css/bg.css" rel="stylesheet">
	</head>
	<body>
		<button onclick="goBack()" autofocus>Go Back</button>
		<div class="content-wrapper">
        <section class="content">
		@include("/header.report")
			<div id="systemDetail"><b>Date: {{date('d/m/Y', Strtotime($fromDate))}}</b></div>
	<div style="border:2px solid;">
		<div id="voucherName"><b>ATTENDANCE REPORT &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SHOP: {{$shop[0]->name}}</b></div>
	<div class="panel-body" style="border-top:2px solid;">
	<table>
		<thead>
			<tr>	
			  <th style="width:5%;border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid; font-size: small;">SR.No</th>
			  <th style="width:30%; border-top: 2px solid;border-bottom: 2px solid; font-size: small; text-align: left;">EMPLOYEE&nbsp;NAME</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid; font-size: small;">CELL</th>
			  <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid; font-size: small; text-align: left;">ADDRESS</th>
			  <th style="width:4%; border-top: 2px solid;border-bottom: 2px solid; font-size: small; text-align: left;">TOTAL&nbsp;SALARY</th>
			  <!-- <th style="width:5%; border-top: 2px solid;border-bottom: 2px solid; font-size: small;">TOTAL&nbsp;DAYS</th>
			  <th style="width:5%; border-top: 2px solid;border-bottom: 2px solid; font-size: small;">PRESENT&nbsp;DAYS</th>
			  <th style="width:5%; border-top: 2px solid;border-bottom: 2px solid; font-size: small;">ABSENT&nbsp;DAYS</th> -->
			  <th style="width:25%; border-top: 2px solid;border-bottom: 2px solid; font-size: small; color:green;">PAYABLE</th>
			  <!-- <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid; font-size: small;">EXPECTED SALARY</th> -->

			</tr>
		</thead>
		 <tbody>
		 <?php $sum=0;  $granddebit=0; $grandcredit=0; $TotalSalary = 0; $ExpectedSalary = 0; $TotalPayable=0; ?>
		 @foreach($party as $parties)
		 <?php $OneDaySalary = 0; $AbsentDaySalary = 0; $totalPresent =0; $totalAbsent = 0; $CashPayment=0;?>
		 @php $sum = $sum + 1; @endphp
		 @if(count($parties->attendance_details) > 0)
		 		 		@php
		 			$salary = 0;
		 			@endphp
		 			@foreach($parties->attendance_details as $detail)

		 			@php
		 			$CashPayment = $CashPayment + $detail->cash_payment;
		 			@endphp

		 			@if($detail->status == "Present")
		 				@php 
		 				$totalPresent =  $totalPresent + 1;
		 				$salary = $salary+ $parties->salary/30;

		 				 @endphp
		 			@endif
		 			@if($detail->status == "Absent")
		 				@php $totalAbsent =  $totalAbsent + 1; @endphp
		 			@endif
		 			@endforeach
		 			<?php

		 		 	$OneDaySalary = $parties->salary / 30;
					 $AbsentDaySalary = $OneDaySalary * $totalAbsent;
					 $CalculatedSalary = $parties->salary - $AbsentDaySalary;
					 $TotalSalary = $TotalSalary + $parties->salary;
					 $PayableSalary = $OneDaySalary * $totalPresent;
					 $TotalPayable = $TotalPayable + $PayableSalary;
					 $ExpectedSalary = $ExpectedSalary + $CalculatedSalary;

					 
				
					?>

					@if($salary > "0.00")
		 <tr id="datafont">
		 		<td id="tabledata">{{$sum}}</td>
		 		<td id="tabledata" style="text-align: left;">{{$parties->party_name}}</td>
		 		<td id="tabledata">{{$parties->phone}}</td>
		 		<td id="tabledata" style="text-align: left;">{{$parties->address}}</td>
		 		<td id="tabledata" style="text-align: left;">{{$parties->salary}}</td>
		 		<!-- <td id="tabledata">{{$days}}</td> -->
		 		

		 			<!-- <td id="tabledata">{{ $totalPresent }}
		 			<td id="tabledata">{{ $totalAbsent }} -->
		 			<td id="tabledata" style="color:green;">{{number_format($salary, 2)}}
		 		</td>
				<!-- <td id="tabledata">{{number_format($CalculatedSalary)}}</td> -->
				</tr>
				@endif
				@else
				
				
				@endif
		@endforeach
				<tr id="datafont">
				<td colspan="5" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;"><center><b style="float:right;">Total</b></center></td>
				
				<!-- <td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center; text-align: left;">{{number_format($TotalSalary)}}</td>
				<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;">{{number_format($grandcredit)}}</td>
				<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;">{{number_format($grandcredit)}}</td>
				<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;">{{number_format($grandcredit)}}</td> -->
				<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center; color:green;">{{number_format($TotalPayable)}}</td>
				<!-- <td style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;">{{number_format($ExpectedSalary)}}</td> -->
				</tr>
			 
			 
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

