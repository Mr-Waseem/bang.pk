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
	<center id="systemDetail" >FROM:{{date("d/m/Y", Strtotime($fromDate))}} &nbsp;&nbsp;&nbsp;&nbsp;TO:{{date("d/m/Y", Strtotime($toDate))}}</center>	
	<div class="panel panel-default">
		<div class="panel-heading"><b>Expense Report</b></div>
	<div class="panel-body">
		<table class="table table-bordered" >
			<thead>
				<tr>	
				  <th style="color:#ff0000;">Particulars</th>
				  <th style="color:#ff0000;">Amount</th>
				  <!-- <th style="color:#ff0000;">Particulars</th>
				  <th style="color:#ff0000;">Amount</th> -->
				</tr>
			</thead>
			 <tbody>


		
				<tr>	
				  <th style="color:#ff0000;">Expenses</th>
				  <th style="color:#ff0000;">Amount</th>
				</tr>
				@php $totalexpense = 0; @endphp
				@if(count($expenses) > 0)
				@foreach($expenses as $exp)
				
					<tr>
						<td>{{$exp->party_name}}</td>
						@php $total =0; @endphp
						<td class="center">
						@if($exp->debit != 0)
							{{number_format($exp->debit)}}
						@endif
					</td>
					</tr>
					@php $totalexpense = $totalexpense + $exp->debit; @endphp
					@endforeach
					@endif
				<tr>	
				  <th style="color:#ff0000;">Total Expenses</th>
				  <th  style="color:#ff0000;">
				  	@if($totalexpense != 0)
				  {{number_format($totalexpense)}}
				  @endif
				</th>
				</tr>


				<!-- <tr>	
				  <th style="color:#ff0000;">SALARY</th>
				  <th style="color:#ff0000;">Amount</th>
				</tr>
				@php $totalSalary = 0; @endphp
				@if(count($salary) > 0)
				@foreach($salary as $sal)
				
					<tr>
						<td>{{$sal->party_name}}</td>
						@php $total =0; @endphp
						<td class="center">
						@if($sal->debit != 0)
							{{number_format($sal->debit)}}
						@endif
					</td>
					</tr>
					@php $totalSalary = $totalSalary + $sal->debit; @endphp
					@endforeach
					@endif
				<tr>	
				  <th style="color:#ff0000;">Total Salary</th>
				  <th style="color:#ff0000;">
				  	@if($totalSalary != 0)
				  {{number_format($totalSalary)}}
				  @endif
				</th>
				</tr>	
				<tr style="background: grey;">	
				  <th style="color:#ff0000;">Total</th>
					<?php $AllExpense = $totalexpense + $totalSalary;?>
					<th style="color:#ff0000;">
						@if($AllExpense != 0)
					{{number_format($AllExpense)}}
					@endif
				</th>
				</tr> -->
			 </tbody>
		</table>
		</div>
	</div>
</section>
</div>

</body>
	</html>


