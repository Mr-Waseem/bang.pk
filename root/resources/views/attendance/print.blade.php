﻿<html>
	<head>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	  <link href="/css/bg.css" rel="stylesheet">
	</head>
	<body onload="window.print()">
	<!-- <body> -->
			<!-- <span style="float: right;margin-top: -19px;">
				<?php $t=time(); ($t . "<br>"); echo(date("d-m-Y",$t)); ?>
			</span> -->

			<center><h1><b id="systemTitle">{{$company_detail[0]->system_name}}</b></h1></center>
			<center><b><strong id="systemDetail">{{$company_detail[0]->address}}</strong></b></br></center>
			<center><b><strong id="systemDetail">GST No.{{$company_detail[0]->city}}, NTN No.{{$company_detail[0]->state}}</strong></b></center>
			<center><h3><u><strong id="voucherName">Journal Voucher</strong></u></h3></center></br>
	<!-- <div class="row">
		<div class="col-sm-3">
		<img src="\upload\logo\{{$logo[0]->image}}" style="width: 160px;height: 60px;border-radius: 5px;border-image: solid 2px;" />
		</div>
	<div class="col-sm-6" style="margin-top: -80px;">
		<center><h3><b>{{$company_detail[0]->system_name}}</b></h3>
		<b>{{$company_detail[0]->address}}</b></br>
		<b>GST No.{{$company_detail[0]->city}}, NTN No.{{$company_detail[0]->state}}</b></center>
	</div>
	</div> -->

	<table style="width:100%;">
		<tr style="background: grey;">
			<th id="tableth" style="width:5%;"><center>Sr.#</center></th>
			<th id="tableth" style="width:30%;"><center>Account&nbsp;Name</center></th>
			<th id="tableth" style="width:40%;"><center>Description</center></th>
			<th id="tableth" style="width:15%;"><center>Debit</center></th>
			<th id="tableth" style="width:15%;"><center>Credit</center></th>
		</tr>
		<?php $sum = 1; $quantity = 0; $rate = 0; $ValueExcTax = 0; $STValue = 0; $debit = 0; $credit=0; ?>
			@foreach ($newsale_detail[0]->voucher_details as $details)
			@if($details->credit!=null)
		<tr id="datafont">
			<td style="border-right:1px solid; border-left:1px solid; width:50px; "><center>{{$sum}}</center></td>
			<td style="border-right:1px solid; border-left:1px solid; width:50px; "><center>{{$details->parties->party_name}}</center></td>
			
			<td style="border-right:1px solid; border-left:1px solid; width:50px;"><center>{{$details->narration}}</center></td>
			<td style="border-right:1px solid; border-left:1px solid; width:20px;"><center>{{$details->debit}}</center></td>
			<td style="border-right:1px solid; border-left:1px solid; width:20px;"><center>{{$details->credit}}</center></td>
		</tr>
		@endif
		<?php 
		
		$quantity = $quantity + $details->quantity;
		$rate = $rate + $details->price;
		$ValueExcTax = $ValueExcTax + $details->quantity*$details->rate;
		$STValue = $STValue + $details->taxvalue;
		$debit = $debit + $details->debit;
		$credit = $credit + $details->credit;
		if($details->credit!=null){
		$sum = $sum + 1;
	}	
		?>
		@endforeach
		<tr id="datafont" style="background: grey;">
			<th style="border:1px solid; width:50px;" colspan="3"><center>
			  Total</center></th>

			<!-- <th style="border:2px solid; width:100px;"><center></center></th> -->
			<th style="border:1px solid; width:100px;"><center>{{$debit}}</center></th>
			<th style="border:1px solid; width:100px;"><center>{{$credit}}</center></th>
		</tr>
	</table></br>	<table>
	</table></br></br>
	 <p style="margin-left: 10%;"><strong></strong></p>
	  <p id="voucherCheckedBy" style="margin-top: -28px; margin-left: 7%;"><strong>PREPARED BY</strong></p>
	  <p id="voucherCheckedBy" style="margin-top: -29px; margin-left: 30%;"><strong>CHECKED BY</strong></p>
	  <p id="voucherCheckedBy" style="margin-top: -30px; margin-left: 55%;"><strong>APPROVED BY</strong></p>
	  <p id="voucherCheckedBy" style="margin-top: -30px; margin-left: 80%;"><strong>RECIEVED BY</strong></p>
</br>
	<p style="margin-left: 10%;"><strong></strong></p>
	 <p style="margin-top: -28px; margin-left: 7%;"><strong>___________</strong></p>
	 <p style="margin-top: -29px; margin-left: 30%;"><strong>___________</strong></p>
	 <p style="margin-top: -30px; margin-left: 55%;"><strong>___________</strong></p>
	 <p style="margin-top: -30px; margin-left: 80%;"><strong>___________</strong></p>
</br>			
</body>
</br><!-- <b style="float:right; margin-right: 0px;">Develed by <u style="color:blue;">www.itlife.com.pk</u> | 0321 4197290<