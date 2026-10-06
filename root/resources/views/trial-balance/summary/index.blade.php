<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>TRIAL BALANCE REPORT</title>
	<link rel="stylesheet" href="{{ asset('bootstrap4/bootstrap.min.css') }}">
	<style>
    tr {
        /* line-height: 0px; */
        border: 1px solid black;
    }

    .table thead th,
    .table tbody tr td {
        border: 1px solid black;
        padding: 0px !important;
        padding-left: 5px !important;
    }
    </style>
</head>
	</br>
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
									<h2 class="text-center"><u>TRIAL BALANCE SUMMARY REPORT</u></h2>
									<p class="text-center font-italic"><b>From:</b> {{
										date('d/m/Y',strtotime($fromDate)) }} && <b>To:</b> {{
										date('d/m/Y',strtotime($toDate)) }}</p>
									<br>
									<div class="table-responsive">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>Serial</th>
												<!-- <th>Account.ID</th> -->
												<th>Account.Name</th>
												<th>Debit</th>
												<th>Credit</th>
												<!-- <th>Amount</th> -->
											</tr>
										</thead>
										<tbody>

											@php $granddebit =0; $grandcredit=0; $sum=0; $grandsumAmount=0; @endphp
											@if(isset($debit))
											@if(count($debit) > 0)
											@foreach($debit as $debits)
											<?php  $Debittotal = 0; $Credittotal=0; $sumAmount=0; ?>
											<tr>
												<td>{{$sum= $sum+1; }}</td>
												<td>{{$debits->name}}</td>

												@foreach($debits->parties as $party)

												@if(count($party->general_vouchers) > 0)

												@foreach($party->general_vouchers as $last)
												<?php $Debittotal = $Debittotal + (int)$last->debit?>
												<?php $Credittotal = $Credittotal + (int)$last->credit?>
												<?php $sumAmount = $Debittotal-$Credittotal ?>
												@endforeach
												@endif
												@endforeach
												<!-- <td>{{number_format($Debittotal)}}</td>
												<td>{{number_format($Credittotal)}}</td> -->
												<td>
												@if($debits->trialType == 'd')
													{{number_format($sumAmount)}}
													<?php $granddebit = $granddebit + $sumAmount?>
													@endif

													
												</td>
												<td>
												@if($debits->trialType == 'c')
													{{number_format($sumAmount)}}
													<?php $grandcredit = $grandcredit + $sumAmount?>
													@endif
													</td>


												@endforeach
											</tr>
											<tr>
												<td></td>
												<td><b>Total</b></td>
												<!-- <td><b>{{number_format($granddebit)}}</b></td>
												<td><b>{{number_format($grandcredit)}}</b></td> -->
												<td><b>
												
													{{number_format($granddebit)}}
													
												</b></td>
												<td><b>
												
													{{number_format($grandcredit)}}
													
												</b></td>
											</tr>

											@endif
											@else
											<tr>
												<td colspan="7" style="color:#FF0000;text-align:center;">No Records
													found</td>
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
	</div>
	@include('include.powerdby')
</body>

</html>