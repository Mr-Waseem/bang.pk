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
		<div><b id="voucherName">SINGLE EMPLOYEE ATTENDANCE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SALARY: {{$party[0]->salary}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Name: {{$party[0]->party_name}}</b></div>
	<div class="panel-body" style="border-top:2px solid;">
	<!-- <table class="table table-striped table-bordered table-hover dataTables-example" > -->
	<table style="width:100%;">
		<thead>
			<tr >	
			  <th style="width:10%; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">Sr.No</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid; text-align: left;">Vr.No</th>
			  <!-- <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Cheque</th>
			  <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid;">Bank</th> -->
			  
			  <!-- <th>Purchase&nbsp;Price</th> -->
			  <th style="width:30%; border-top: 2px solid;border-bottom: 2px solid;">IN.TIME</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">OUT.TIME</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">STATUS</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">DEBIT</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">CREDIT</th>
			  <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;">BALANCE</th>
			</tr>
		</thead>
		 <tbody>
		 <?php $salary = 0; $totalSalary = 0; $totalDebit = 0; $totalCredit =0; $Balance =0; $sum=0; $singleSalary=0;?>
			 @if(count($items) > 0)
				@foreach($items[0]->attendance_details as $employee)
				@php $sum = $sum + 1 @endphp
					<tr id="datafont">
						<td id="tabledata">{{$sum}}</td>
						<td id="tabledata">
							@if($employee->attendances != null)
							{{$employee->attendances->vr_no}}
							@endif
						</td>
						<td id="tabledata">
							@if($employee->in_time != null)
							{{ date("d/m/Y H:i", strtotime($employee->in_time)) }}
							@else
							{{"CASH PAYMENT"}}
							@endif
						</td>
						<td id="tabledata">
							@if($employee->in_time != null)
							{{ date("d/m/Y H:i", strtotime($employee->out_time)) }}
							@endif</td>
						<td id="tabledata">{{$employee->status}}</td>
						<td id="tabledata">{{$employee->cash_payment}}</td>
						@php $salary = $party[0]->salary/30; @endphp
						<td id="tabledata">
							@if($employee->status == "Present")
							@php 

								$totalSalary = $totalSalary + $salary;
								$totalCredit = $totalCredit + $salary;	
							@endphp
						{{ number_format((int)$salary) }}
						@php $singleSalary = $singleSalary + $salary; @endphp
						@endif
					</td>
					@php
						
						$totalDebit = $totalDebit + $employee->cash_payment;

						
					@endphp
					<td id="tabledata">
						
						{{ number_format((int)$totalSalary-$totalDebit) }}
						

							
					</td>
					</tr>
					@endforeach
						
				<tr id="datafont">
				<td colspan="5" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;"><center><b style="float:right;">Total</b></center></td>
				
				
				
				<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;">{{number_format($totalDebit)}}</td>
				<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center; color:red;">{{number_format($totalCredit)}}</td>
				<td style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;">{{number_format($totalCredit -$totalDebit)}}</td>
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

