﻿<html>
	<head>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body onload="window.print();">
			<span style="float: right;margin-top: -19px;">
				<?php $t=time(); ($t . "<br>"); echo(date("d-m-Y",$t)); ?>
			</span>
			<center><h3><u><strong>SALE Bill</strong></u></h3></center>
	<table>
		<tr style="border:2px solid;">
			<td style="border:2px solid; width: 150px;"><img src="/upload/logo/{{$logo[0]->image}}" style="width: 130px;float: left; margin-left: 20px;"></td>
			<td><h3><b>From:{{$company_detail[0]->system_name}}</b></h3></br>
				Address: {{$company_detail[0]->address}}
			</td>
			<td style="border:2px solid; width: 150px;"><center>Bill No: <b>{{$newsale_detail[0]->invoice_no}}</b></center></br>
				<center>Date: <b>{{date("d/m/Y", strtotime($newsale_detail[0]->date))}}</b><center>
				</br>
				<center>OGP: <b>{{date("d/m/Y", strtotime($newsale_detail[0]->date))}}</b><center>
			</td>
		</tr>
		<tr style="height:60px;"><td style="border:2px solid;" colspan="3"><b><u><center>TO M/S: {{$newsale_detail[0]->parties->party_name}} ({{$newsale_detail[0]->parties->phone}})</center></u><b></td></tr>
	</table></br>
	<table>
		<tr style="background: grey;">
			<th style="border:2px solid; width:50px;"><center>SR</center></th>
			<th style="border:2px solid; width:50px;"><center>Code</center></th>
			<th style="border:2px solid; width:340px;"><center>Item Description</center></th>
			<th style="border:2px solid; width:100px;"><center>Quantity</center></th>
			<th style="border:2px solid; width:100px;"><center>Rate</center></th>
			<th style="border:2px solid; width:100px;"><center>Amount</center></th>
		</tr>
		<?php $sum = 1; $quantity = 0; $rate = 0; $amount = 0; ?>
			@foreach ($newsale_detail[0]->sale_details as $details)
		<tr style="">
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; solid; width:50px;"><center>{{$sum}}</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>{{$details->products->product_code}}</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:340px;"><center>{{$details->products->product_name}}</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center>{{$details->quantity}}</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center>{{$details->sale_rate}}</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center>{{$details->sale_amount}}</center></td>
		</tr>
		<?php 
		
		$quantity = $quantity + $details->quantity;
		$rate = $rate + $details->sale_rate;
		$amount = $amount + $details->sale_amount;
		$sum = $sum + 1;
		?>
		@endforeach
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:340px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:340px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:340px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:340px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:340px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:340px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:340px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:340px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:340px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
		</tr>
		<tr style="background: grey;">
			<td style="border:2px solid; width:50px;" colspan="3"><center>
				@if($newsale_detail[0]->sale_type =="Credit Sale")
				Payment Due Date: <u>{{date("d/m/Y", strtotime($newsale_detail[0]->due_date))}}</u></h5>
				@endif
			 / Total</center></td>

			<th style="border:2px solid; width:100px;"><center>{{$quantity}}</center></th>
			<th style="border:2px solid; width:100px;"><center>{{$rate}}</center></th>
			<th style="border:2px solid; width:100px;"><center>{{$amount}}</center></th>
		</tr>
		<tr style="height:30px; border:2px solid;">
			<td style="border:2px solid;" colspan="3">Remarks</td>
			<td style="" colspan="3">
			<p style="margin-top:10px; margin-left: 10px; margin-bottom:10px; ">Driver Name:</p> </br></hr> 
			<p style="margin-left: 10px;">Vehicle No:</p>
			</td>
		</tr></br>
		
	</table></br>
	<p><strong>Balance</strong></p>
	<p><center style="margin-top: -28px;"><strong>Approved By</strong></center></p>
	<p style="float:right; margin-top: -33px;"><strong>Recieved By</strong></p></br>
		<?php $debit = 0; $credit = 0;?>
		@foreach($ledgers as $ledger)
		<?php
			$debit = $debit + $ledger->debit;
			$credit = $credit + $ledger->credit;
		?>
		@endforeach
	<p><strong>Current Bill Total: <?php echo $amount;?> </br>
	Total Balance: <?php echo $debit-$credit; ?></br></strong></p>
	<p><center style="margin-top: -28px;"><strong>___________</strong></center></p>
	<p style="float:right; margin-top: -33px;"><strong>___________</strong></p></br>
	

			
	</body>
</html>
</br>
<!-- <b style="float:right; margin-right: 0px;">Developed by <u style="color:blue;">www.itlife.com.pk</u> | 0321 4197290</b> -->
