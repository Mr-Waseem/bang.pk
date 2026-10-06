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
			
	<div class="panel panel-default">
		<div class="panel-heading"><b>Account All Report&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Account ID: {{$party[0]->id}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Name: {{$party[0]->party_name}}</b></div>
	<div class="panel-body">
	<table class="table table-striped table-bordered table-hover dataTables-example" >
		<thead>
			<tr>	
			  <th>Vr.No</th>
			  <th>Vr.Type</th>
			  <th>Date</th>
			  <th>Cheque</th>
			  <th>Bank</th>
			  <th>Narration</th>
			  <th>Debit</th>
			  <th>Credit</th>
			  <th>Balance</th>
			</tr>
		</thead>
		 <tbody>
		 <?php $totalDebit = 0; $totalCredit = 0;?>
		 
			 @if(count($GeneralVoucher) > 0)
				@foreach($GeneralVoucher as $GeneralVouchers)
				<tr>
					<td>{{$GeneralVouchers->voucher_no}}</td>
					<td>
						@if ($GeneralVouchers->v_type == "Cash Purchase")
						{{"PB"}}
						@endif
						@if ($GeneralVouchers->v_type == "Sale Bill")
						{{"SB"}}
						@endif
						@if ($GeneralVouchers->v_type == "PurchaseTax Invoice")
						{{"PTV"}}
						@endif
						@if ($GeneralVouchers->v_type == "SalesTax Invoice")
						{{"STV"}}
						@endif
						@if ($GeneralVouchers->v_type == "Journal Voucher")
						{{"JV"}}
						@endif
						@if ($GeneralVouchers->v_type == "Cash Receipt")
						{{"CR"}}
						@endif
						@if ($GeneralVouchers->v_type == "Cash Payment")
						{{"CP"}}
						@endif
						@if ($GeneralVouchers->v_type == "Bank Receipt")
						{{"BR"}}
						@endif
						@if ($GeneralVouchers->v_type == "Bank Payment")
						{{"BP"}}
						@endif
						@if ($GeneralVouchers->v_type == "Post Dated Cheque")
						{{"PDC"}}
						@endif
						@if ($GeneralVouchers->v_type == "Purchase Return")
						{{"PR"}}
						@endif
						@if ($GeneralVouchers->v_type == "Credit Sale")
						{{"SB | CR"}}
						@endif
						@if ($GeneralVouchers->v_type == "Cash Sale")
						{{"SB | CASH"}}
						@endif
						@if ($GeneralVouchers->v_type == "Sale Return")
						{{"SR"}}
						@endif
						
					</td>
					<td>{{ date("d/m/Y", strtotime($GeneralVouchers->date)) }}</td>
					<td>{{ $GeneralVouchers->cheque_no }}</td>
					<td>@if($GeneralVouchers->banks != null)
						{{ $GeneralVouchers->banks->name }}
						@endif
					</td>
					<td>
						@if ($GeneralVouchers->narration == null)
						INV#:{{$GeneralVouchers->invoice_no}}|Dated:{{ date("d/m/Y", strtotime($GeneralVouchers->date)) }}
					@endif
						{{ $GeneralVouchers->narration }} </td>
					<td>{{ number_format((int)$GeneralVouchers->debit) }} </td>
					<td>{{ number_format((int)$GeneralVouchers->credit) }}</td>
					<?php $totalDebit = $totalDebit + $GeneralVouchers->debit;
					if ($GeneralVouchers->v_type != "Cash Sale"){
					$totalCredit = $totalCredit + $GeneralVouchers->credit; 
				}
				?>
					
					<td>{{ number_format((int)$totalDebit-$totalCredit)}}</td>
					</tr>
				@endforeach
				<tr>
				<td colspan="6"><center><b style="float:right;">Total</b></center></td>
				
				<td>{{number_format((int)$totalDebit)}}</td>
				<td>{{number_format((int)$totalCredit)}}</td>
				<td>{{number_format((int)$totalDebit-$totalCredit)}}</td>
				</tr>
			 
			 @else
				<tr><td colspan="9" style="color:#FF0000;text-align:center;">No Records found</td></tr>
			 @endif
		 </tbody>
	</table>
		</div>
	</div>
</section>
	</div>

		
	
		</body>
		</html>


