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
		<div class="panel-heading"><b>Profit & Loss Account&nbsp;&nbsp;&nbsp;&nbsp;
			@if(Count($ShopName) > 0)
			Shop Name: {{$ShopName[0]->name}}
			@else
			{{"ALL BRANCHES"}}
		@endif
		</b></div>
	<div class="panel-body">
		<table class="table table-bordered" >
			<thead>
				<tr>	
				  <th style="color:#ff0000;">Particulars</th>
				  <th style="color:#ff0000;">Amount</th>
				  <th style="color:#ff0000;">Particulars</th>
				  <th style="color:#ff0000;">Amount</th>
				</tr>
			</thead>
			 <tbody>
			 	<tr>	
				  <td>Cost of Goods Sold</td>
				  <td>@if($purchases != 0)
				  {{number_format($purchases)}}
				  @endif
				</td>
				  <td>Sales</td>
				  <td>
				  	@if($sales != 0)
				  {{number_format($sales)}}
				  @endif
				</td>
				</tr>

				<tr style="background: grey;">	
				  <th style="color:#ff0000;">Gross Profit</th>
				  <?php $GrossProfit = $sales - $purchases;?>
				  <th style="color:#ff0000;">
				  	@if($GrossProfit != 0)
				  {{number_format($GrossProfit)}}
				  @endif
				</th>
				   <td colspan="2"></td>
				</tr>
				<tr>	
				  <th style="color:#ff0000;">Serial</th>
				  <th style="color:#ff0000;"  colspan="2">Expenses</th>
				  <th style="color:#ff0000;">Amount</th>
				</tr>
				@php $totalexpense = 0; $sum=0; @endphp
				@if(count($expenses) > 0)
				@foreach($expenses as $exp)
				@php $sum = $sum + 1; @endphp
					<tr>
						<td>{{$sum}}</td>
						<td  colspan="2">{{$exp->party_name}}</td>
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
				  <th style="color:#ff0000;" colspan="3">Total Expenses</th>
				  <th  style="color:#ff0000;">
				  	@if($totalexpense != 0)
				  {{number_format($totalexpense)}}
				  @endif
				</th>
				</tr>
	
				<tr>
				<th style="color:#ff0000;">Serial</th>	
				  <th style="color:#ff0000;" colspan="2">EMPLOYESS</th>
				  <th style="color:#ff0000;">Amount</th>
				</tr>


				@php $totalEmployee = 0; $totals =0;  @endphp
				@if(count($employees) > 0)
				@foreach($employees as $employee)
					@php $totals = $totals + 1; @endphp
					<tr>
						<td>{{$totals}}</td>
						<td colspan="2">{{$employee->party_name}}</td>
						@php $total =0; $sum=0; $salary =0; @endphp
						<td class="center">
							@foreach($employee->attendance_details as $detail)
							@if($detail->status == "Present")
							
							@php 
							$salary = $salary+ $employee->salary/30;
							$sum = $sum + 1;
							@endphp
							@endif	
							
						@endforeach
						{{$salary}}
						@php $totalEmployee = $totalEmployee + $salary; @endphp
					</td>
					</tr>

					
					
					@endforeach
					@endif
				<tr>

					<tr style="background: grey;">	
				  <th style="color:#ff0000;" colspan="3">Total</th>
					
					<th style="color:#ff0000;">
						
					{{number_format($totalEmployee)}}
					
				</th>
				</tr


				<tr style="background: grey;">	
				  <th style="color:#ff0000;" colspan="3">Net Profit</th>
					<?php $NewProfit = $GrossProfit - $totalexpense -  $totalEmployee?>
					<th style="color:#ff0000;">
						@if($NewProfit != 0)
					{{number_format($NewProfit)}}
					@endif
				</th>
				</tr>
				
			 </tbody>
		</table>
		</div>
	</div>
</section>
</div>

</body>
	</html>


