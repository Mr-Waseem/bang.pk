<html>
<head>
  <link href="/css/bg.css" rel="stylesheet">
</head>
<!-- <body onload="window.print();"> -->
<body>
	<div>
	<section class="content">
	@include("/header.report")
		
	<div style="border:2px solid;">
		<div><b id="voucherName">TRIAL BALANCE</b></div>
	<div class="panel-body" style="border-top:2px solid;">
	<!-- <table class="table table-striped table-bordered table-hover dataTables-example" > -->
	<table style="width: 100%;">
			<thead>
				<tr>	
				  <th style="width:40%; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid; background: deeppink;" colspan="2" rowspan="2"><center>ACCOUNT HEADS</center></th>
				  <th style="border-top: 2px solid;border-left: 2px solid; border-right: 2px solid; border-bottom: 2px solid; background: cyan;" colspan="2"><center>OPENING&nbsp;BALANCE</center></th>
				  <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid; background: cyan; border-right: 2px solid;" colspan="2" ><center>FOR&nbsp;THE&nbsp;PERIOD</center></th>
				  <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid; background: cyan; border-left: 2px solid;" colspan="2" ><center>CLOSING&nbsp;BALANCE</center></th>
				</tr>
				 <tr>	
				  
				  <th style="width:10%; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid; background: lawngreen;">DEBIT</th>
				  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid; background: lawngreen; border-right: 2px solid;">CREDIT</th>
				  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid; background: lawngreen; border-left: 2px solid;">DEBIT</th>
				  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid; background: lawngreen; border-right: 2px solid;">CREDIT</th>
				  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid; background: lawngreen; border-left: 2px solid;">DEBIT</th>
				  <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid; background: lawngreen;">CREDIT</th>
				</tr>
			</thead>
			 <tbody>
			 	<div class="col-sm-12">
			 
			 		@php 
			 			$TotalOpeningdebit =0; $TotalOpeningcredit  =0;
			 			$TotalPerioddebit =0; $TotalPeriodcredit  =0;
			 			$TotalClosingdebit =0; $TotalClosingcredit  =0;
			 		@endphp
			 @if(isset($debit))
				 @if(count($debit) > 0)
					@foreach($debit as $debits)		
					<?php  $Debittotal = 0; $Credittotal=0; $sum=0;  ?>	
					@php 
					$grandOpeningdebit =0; $grandOpeningcredit=0; 
			 		$grandYeardebit =0; $grandYearcredit=0; 
			 		$grandClosingdebit =0; $grandClosingcredit=0; 
			 		@endphp
						<tr id="datafont">
						<th colspan="8" id="tabledata" style="font-size: 18px; border-bottom: 2px solid;"><b style="float:left; margin-left: 10%;">{{$debits->name}}</b></th>

						</tr>
						
						@foreach($debits->parties as $party)
						@php $sum = $sum+1; @endphp
						<tr id="datafont">
							<td id="tabledata">{{$sum}}</td>
							<td id="tabledata" style="border-right: 2px solid;"><a href="client-all-report/ledger-for-trial/{{$party->id}}">{{$party->party_name}}</a></td>

							<?php $Debit = 0; $credit = 0; $openingDebit = 0; $openingCredit = 0;
							$periodDebit = 0; $periodCredit = 0;
							  ?>

							@foreach($party->general_vouchers as $last)
								@if($last->narration == "OPENING BALANCE")
								@php $openingDebit = $openingDebit + (int)$last->debit @endphp
								@php $openingCredit = $openingCredit + (int)$last->credit @endphp
								@endif
							@endforeach

							@foreach($party->general_vouchers as $last)
								@if($last->narration != "OPENING BALANCE")
								@php 
									$periodDebit = $periodDebit + (int)$last->debit @endphp
								@php 
								$periodCredit = $periodCredit + (int)$last->credit @endphp
								@endif

							@endforeach

							
							<td id="tabledata" style="border-right: 1px dashed;">{{number_format($openingDebit)}}</td>
							<td id="tabledata" style="border-right: 2px solid;">{{number_format($openingCredit)}}</td>
							<td id="tabledata" style="border-right: 1px dashed;">{{number_format($periodDebit)}}</td>
							<td id="tabledata" style="border-right: 2px solid;">{{number_format($periodCredit)}}</td>
							<td id="tabledata" style="border-right: 1px dashed;">{{number_format($openingDebit+$periodDebit)}}</td>
							<td id="tabledata">{{number_format($openingCredit+$periodCredit)}}</td>
							<!-- <td>{{number_format($Debit-$credit)}}</td> -->
							@php 
							$grandOpeningdebit = $grandOpeningdebit + $openingDebit;
							$grandOpeningcredit = $grandOpeningcredit + $openingCredit;

							$grandYeardebit = $grandYeardebit + $periodDebit;
							$grandYearcredit = $grandYearcredit + $periodCredit;

							$grandClosingdebit = $grandClosingdebit + $openingDebit+$periodDebit;
							$grandClosingcredit = $grandClosingcredit + $openingCredit+$periodCredit;
							 @endphp
						@endforeach
							
							
						</tr>
						 <tr style="background: #e0e0e0; border-bottom: 2px solid black;">
							<th colspan="2" style="border-right: 2px solid black; border-bottom: 2px solid black;">Total</th>
							<td style="color:red; border-right: 1px dashed black; border-bottom: 2px solid black;">{{number_format($grandOpeningdebit)}}</td>
							 <td style="color:red; border-right: 2px solid black; border-bottom: 2px solid black;">{{number_format($grandOpeningcredit)}}</td>
							<td style="color:red; border-right: 1px dashed black; border-bottom: 2px solid black;">{{number_format($grandYeardebit)}}</td>
							<td style="color:red; border-right: 2px solid black; border-bottom: 2px solid black;">{{number_format($grandYearcredit)}}</td>
							<td style="color:red; border-right: 1px dashed black; border-bottom: 2px solid black;">{{number_format($grandClosingdebit)}}</td>
							<td style="color:red; border-bottom: 2px solid black;">{{number_format($grandClosingcredit)}}</td>
						</tr>
						@php 
						$TotalOpeningdebit = $TotalOpeningdebit + $grandOpeningdebit;
						$TotalOpeningcredit = $TotalOpeningcredit + $grandOpeningcredit;
						$TotalPerioddebit = $TotalPerioddebit + $grandYeardebit;
						$TotalPeriodcredit = $TotalPeriodcredit + $grandYearcredit; 
						$TotalClosingdebit = $TotalClosingdebit + $grandClosingdebit; 
						$TotalClosingcredit = $TotalClosingcredit + $grandClosingcredit; 
						@endphp
					@endforeach
					
					<tr style="color:green;">
					<th colspan="2" style="border-right: 2px solid black;"><b>Grand Total</b></th>
					<td style="border-right: 1px dashed black;"><b>{{number_format($TotalOpeningdebit)}}</b></td>
					<td style="border-right: 2px solid black;"><b>{{number_format($TotalOpeningcredit)}}</b></td>
					<td style="border-right: 1px dashed black;"><b>{{number_format($TotalPerioddebit)}}</b></td>
					<td style="border-right: 2px solid black;"><b>{{number_format($TotalPeriodcredit)}}</b></td>
					<td style="border-right: 1px dashed black;"><b>{{number_format($TotalClosingdebit)}}</b></td>
					<td><b>{{number_format($TotalClosingcredit)}}</b></td>
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


