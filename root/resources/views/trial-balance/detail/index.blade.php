<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>TRIAL BALANCE REPORT</title>
	<link rel="stylesheet" href="{{ asset('bootstrap4/bootstrap.min.css') }}">
	<script src="{{ asset('bootstrap4/jquery.min.js') }}"></script>
	<script src="{{ asset('bootstrap4/popper.min.js') }}"></script>
	<script src="{{ asset('bootstrap4/bootstrap.min.js') }}"></script>
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
	<style>
		tr {
			line-height: 0px;
			border: 1px solid black;
		}

		.table thead th,
		.table tbody tr td {
			border: 1px solid black;
		}
	</style>
</head>

<body>
	<div class="container">
		<div class="row flex-lg-nowrap">
			<div class="col">
				<div class="row">
					<div class="col mb-3">
						<div class="card">
							<div class="card-body">
								<div class="e-profile">
									@include('include.header')
									<h2 class="text-center"><u>TRIAL BALANCE DETAIL REPORT</u></h2>
									<p class="text-center font-italic"><b>From:</b> {{
										date('d/m/Y',strtotime($fromDate)) }} && <b>To:</b> {{
										date('d/m/Y',strtotime($toDate)) }}</p>
									<br>
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>SERIAL #</th>
												<th>CODE</th>
												<th>ACCOUNT NAME</th>
												<th>DEBIT</th>
												<th>CREDIT</th>
												<th>CLOSING TRIAL</th>
											</tr>
										</thead>
										<tbody>


											@php $granddebit =0; $grandcredit=0; @endphp
											@if(isset($debit))
											@if(count($debit) > 0)
											@foreach($debit as $debits)
											<?php  $Debittotal = 0; $Credittotal=0;  $sum=0; ?>
											<tr>
                                                {{-- <td colspan="2"><b>Group Type</b></td> --}}
                                                
												<td colspan="6"><b>&emsp;&emsp;Group Type: &emsp;&emsp;{{$debits->name}}</b></td>
											</tr>

											@foreach($debits->parties as $party)
											@if(count($party->general_vouchers) > 0)
											@php $sum = $sum+1; @endphp
											<tr>
												<td>{{$sum}}</td>
												<td>{{$party->code}}</td>
												<td>
													{{-- <a href="client-all-report/ledger-for-trial/{{$party->id}}">{{$party->party_name}}</a> --}}
													{{$party->party_name}}
												</td>
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
											<tr>
												<td></td>
												<td colspan="2">Total</td>
												<td>{{number_format($Debittotal)}}</td>
												<td>{{number_format($Credittotal)}}</td>
												<td>{{number_format($Debittotal-$Credittotal)}}</td>
											</tr>
											@endforeach

											<tr>
												<td></td>
												<td></td>
												<td colspan="1"><b>Total</b></td>
												<td><b>{{number_format($granddebit)}}</b></td>
												<td><b>{{number_format($grandcredit)}}</b></td>
												<td><b>{{number_format($granddebit-$grandcredit)}}</b></td>
											</tr>


											@endif
											@else
											<tr>
												<td colspan="7">No Records found</td>
											</tr>
											@endif

										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@include('include.powerdby')
</body>

</html>