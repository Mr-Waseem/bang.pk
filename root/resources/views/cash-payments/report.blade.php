<html>
	<head>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body onload="window.print();">
		<div class="content-wrapper">
        <section class="content">
		@include("/header.report")
			
	<div class="panel panel-default">
		<div class="panel-heading"><b>General Voucher Report ({{$GeneralVoucher[0]->title}})</b></div>
	<div class="panel-body">
		
		<!--<a href="/purchase-report/print" class="btn btn-warning" role="button" style="float:right;">
		<i class="fa fa-print"></i><span class="bold">Print</span></a>-->
	<table class="table table-striped table-bordered table-hover dataTables-example" >
		<thead>
			<tr>	
			  <th>Date</th>
			  <th>Voucher&nbsp;No</th>
			  <th>Amount</th>
			  <th>Balance</th>
			</tr>
		</thead>
		 <tbody>
		 <?php $totalDebit = 0; $totalCredit = 0;?>
		 @if(isset($GeneralVoucher))
			 @if(count($GeneralVoucher) > 0)
				@foreach($GeneralVoucher as $GeneralVouchers)
				<tr>
					<td>{{ date("d/m/Y", strtotime($GeneralVouchers->date)) }}</td>
					<td>{{$GeneralVouchers->voucher_no}}</td>
					<td>{{ $GeneralVouchers->amount }} </td>
					<!-- <td>{{ $GeneralVouchers->credit }}</td> -->
					<?php $totalDebit = $totalDebit + $GeneralVouchers->amount;?>
					<td>{{$totalDebit}}</td>
					</tr>
				@endforeach
				<tr>
				<td colspan="3"><center><b style="float:right;">Total</b></center></td>
				<!-- <td>{{$totalDebit}}</td> -->
				<td>{{$totalDebit-$totalCredit}}</td>
				</tr>
			 @endif	
			 @else
				<tr><td colspan="7" style="color:#FF0000;text-align:center;">No Vouchers found</td></tr>
			 @endif
		 </tbody>
	</table>
		</div>
	</div>
</section>
	</div>

		
	
		</body>
		</html>


