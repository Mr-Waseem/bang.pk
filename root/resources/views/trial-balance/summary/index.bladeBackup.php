<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="content-wrapper">
    <section class="content">
	@include("/header.report")
	<center id="systemDetail" >FROM:{{date("d/m/Y", Strtotime($fromDate))}} TO:{{date("d/m/Y", Strtotime($toDate))}}</center>		
	<div class="panel panel-default">
		<div class="panel-heading"><b>Trial Balance Summary Report</b></div>
	<div class="panel-body">
		<table class="table table-bordered" >
			<thead>
				<tr>	
				  <th>SERIAL</th>
				  <th>CODE</th>
				  <th>ACCOUNT NAME</th>
				  <th>DEBIT</th>
				  <th>CREDIT</th>
				  <th>CLOSING TRIAL</th>
				</tr>
			</thead>
			 <tbody>
			 	<div class="col-sm-12">
			 
			 		@php $granddebit =0; $grandcredit=0; @endphp
			 @if(isset($debit))
				 @if(count($debit) > 0)
					@foreach($debit as $debits)		
					<?php  $Debittotal = 0; $Credittotal=0; $sum=0;  ?>	
						<tr>
						<th colspan="4">{{$debits->name}}</th>	
						</tr>
						
						@foreach($debits->parties as $party)
						@if(count($party->general_vouchers) > 0)
						@php $sum = $sum+1; @endphp
						<tr>
							<td>{{$sum}}</td>
							<td>{{$party->code}}</td>
							<td><a href="client-all-report/ledger-for-trial/{{$party->id}}">{{$party->party_name}}</a></td>
							<?php $Debit = 0; $credit = 0;  ?>
							@foreach($party->general_vouchers as $last)
								<?php $Debit = $Debit + (int)$last->debit?>
								<?php $credit = $credit + (int)$last->credit?>
								<?php $Debittotal = $Debittotal + (int)$last->debit?>
								<?php $Credittotal = $Credittotal + (int)$last->credit?>
								<?php $granddebit = $granddebit + (int)$last->debit?>
								<?php $grandcredit = $grandcredit + (int)$last->credit?>
							@endforeach
							<td>{{number_format($Debit)}}</td>
							<td>{{number_format($credit)}}</td>
							<td>{{number_format($Debit-$credit)}}</td>
							@endif
						@endforeach
							
							
						</tr>
						 <tr style="background: #e0e0e0;">
							<th colspan="3">Total</th>
							<td style="color:red;">{{number_format($Debittotal)}}</td>
							<td style="color:red;">{{number_format($Credittotal)}}</td>
							<td style="color:red;">{{number_format($Debittotal-$Credittotal)}}</td>
						</tr>
					@endforeach
					
					<tr style="color:green;">
					<th colspan="3"><b>Total</b></th>
					<td><b>{{number_format($granddebit)}}</b></td>
					<td><b>{{number_format($grandcredit)}}</b></td>
					<td><b>{{number_format($granddebit-$grandcredit)}}</b></td>
					</tr>

					 <!-- <tr style="color:red;">
					<td colspan="3"><b>Grand Total</b></td>
					<td><b>{{$Debittotal-$Credittotal}}</b></td>
					</tr> -->
				 @endif	
				 @else
					<tr><td colspan="7" style="color:#FF0000;text-align:center;">No Records found</td></tr>
				 @endif
				</div>
			 </tbody>
		</table>
		</div>
	</div>
</section>
</div>

</body>
	</html>


