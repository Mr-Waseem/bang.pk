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
		<div><b id="voucherName">Salary Sheet</b></div>
	<div class="panel-body" style="border-top:2px solid;">
	<!-- <table class="table table-striped table-bordered table-hover dataTables-example" > -->
	<table style="width:100%;">
		<thead>
			<tr >	
			  <th style="width:10%; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">Sr#</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">..........Employee.Name..........</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Designation</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">D.O.J</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Gross.Salary</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Total.Days</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Working.Days</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Late.Hour</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Absent</th>
			  {{-- <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">House.No</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">.....Member.Status.....</th> --}}
			  <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;">........Net.Pay........</th>
			</tr>
		</thead>
		 <tbody>


		 <?php $sum = 0; $OldName=0; $ChangeName = 0; $totalGross = 0; $totalNet = 0; ?>
			 @if(count($data) > 0)
				@foreach($data as $phones)
				
				@php $sum = $sum + 1; @endphp
					<tr id="datafont" style="font-size: 14px;">
						<td id="tabledata">{{$sum}}</td>
						<td id="tabledata">{{$phones->party_name}}</td>
						
						<td id="tabledata">
							@if($phones->appointments)
							{{$phones->appointments->name}}
							@endif
						</td>
						<td id="tabledata">
							@if($phones->appointments)
							{{$phones->appointments->date}}
							@endif
						</td>
						{{-- <td id="tabledata">
							@if($phones->meeting_date)
							{{date("d/m/Y", Strtotime($phones->meeting_date))}} | {{$phones->meeting_time}} 
							@endif
						</td> --}}
						<td id="tabledata">{{number_format($phones->salary)}} </td>

						@php $days=0; $workingDays = 0; $AbsentDays=0; $salary=0; $totalLate=0; @endphp
						@foreach($phones->attendance_details as $TotalDays)
						@php $days = $days + 1;@endphp
						 @if($TotalDays->intime)
						 	@php  $workingDays = $workingDays + 1; @endphp
						 @endif
						 @if(!($TotalDays->intime))
						 	@php  $AbsentDays = $AbsentDays + 1; @endphp
						 @endif
						 @if($TotalDays->late)
						 	@php  $totalLate = $totalLate + $TotalDays->late; @endphp
						 @endif

						@endforeach
						{{-- <td id="tabledata">{{$days}} </td> --}}
						<td id="tabledata">{{$NumberOfDays}} </td>
						<td id="tabledata">{{$workingDays}} </td>
						<td id="tabledata">{{number_format($totalLate/60)}}:{{$totalLate%60}} </td>
						
						<td id="tabledata">{{$AbsentDays}} </td>
						@php
							$salary = $phones->salary/31*$workingDays;
						@endphp
						
						<td id="tabledata">{{number_format($salary)}}</td>
					</tr>
					@php 
					$OldName = $phones->created_by; 
					$ChangeName = $phones->created_by; 
					
					@endphp
				{{-- -----------------------------------------------
				@if($phones->created_by == $phones->created_by)
					@endif --}}
					@php 
					$totalGross = $totalGross + $phones->salary; 
					$totalNet = $totalNet + $salary; 
					@endphp
					@endforeach
						
				


				 <tr id="datafont">
					<td colspan="4" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;"><center><b>Total</b></center></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b>{{number_format($totalGross) }}</b></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b></b></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b></b></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b></b></td>
					<td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"><b></b></td>
					<td style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;"><b>{{ number_format($totalNet) }}</b></td>
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

