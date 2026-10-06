﻿<html>
	<head>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body onload="window.print();">
	<!-- <body> -->
			<!-- <span style="float: right;margin-top: -19px;">
				<?php $t=time(); ($t . "<br>"); echo(date("d-m-Y",$t)); ?>
			</span> -->

			<center><h1><b>{{$company_detail[0]->system_name}}</b></h1></center>
			<center><b><strong>{{$company_detail[0]->address}}</strong></b></br></center>
			<center><b><strong>GST No.{{$company_detail[0]->city}}, NTN No.{{$company_detail[0]->state}}</strong></b></center>
			<center><h3><u><strong>Cash Receipt Voucher</strong></u></h3></center></br>
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
	 <div class="row">
		<div class="col-sm-3">
			<b>Account&nbsp;Name: {{$newsale_detail[0]->parties->party_name}}</b></br>
			<b>Vourcher&nbsp;Date:{{date("d/m/Y", Strtotime($newsale_detail[0]->voucher_date))}}</b></br>
		</div>
	<div class="col-sm-6" style="float: right; margin-top: -20px;">
<!-- 		<center><h3><b>{{$newsale_detail[0]->voucher_date}}</b></h3> -->
		
		<b>VoucherNO.{{$newsale_detail[0]->voucher_no}}</b>
	</div>
	</div>
	<table>
		<tr style="background: grey;">
			<th style="border:1px solid; width:10%;"><center>Sr.#</center></th>
			<th style="border:1px solid; width:10%;"><center>Account&nbsp;Name</center></th>
			<th style="border:1px solid; width:80%;"><center>Description</center></th>
			<th style="border:1px solid; width:40%;"><center>Amount</center></th>
			<!-- <th style="border:2px solid; width:20px;"><center>Rate</center></th>
			<th style="border:2px solid; width:150px;"><center>Value Exc.Sales Tax</center></th>
			<th style="border:2px solid; width:7%;"><center>S.T%</center></th>
			<th style="border:2px solid; width:100px;"><center>S.T Value</center></th>
			<th style="border:2px solid; width:200px;"><center>Value Inc.ST & Rate</center></th> -->
		</tr>
		<?php $sum = 1; $quantity = 0; $rate = 0; $ValueExcTax = 0; $STValue = 0; $amount = 0; ?>
			@foreach ($newsale_detail[0]->voucher_details as $details)
			@if($details->credit!=null)
		<tr style="">
			<td style="border-bottom:1px dotted; border-right:1px solid; border-left:1px solid; width:50px;"><center>{{$sum}}</center></td>
			<td style="border-bottom:1px dotted; border-right:1px solid; border-left:1px solid; width:50px;"><center>{{$details->parties->party_name}}</center></td>
			<td style="border-bottom:1px dotted; border-right:1px solid; border-left:1px solid; width:50px;"><center>{{$details->narration}}</center></td>
			<td style="border-bottom:1px dotted; border-right:1px solid; border-left:1px solid; width:20px;"><center>{{$details->credit}}</center></td>
		</tr>
		@endif
		<?php 
		
		$quantity = $quantity + $details->quantity;
		$rate = $rate + $details->price;
		$ValueExcTax = $ValueExcTax + $details->quantity*$details->rate;
		$STValue = $STValue + $details->taxvalue;
		$amount = $amount + $details->credit;
		if($details->credit!=null){
		$sum = $sum + 1;
	}	
		?>
		@endforeach
		<!-- <tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:20px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:20px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
			
		</tr>
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:20px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:20px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:20px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:20px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:20px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:20px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:20px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:20px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:20px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:20px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:20px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:20px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:20px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:20px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
		</tr> -->
		<tr style="background: grey;">
			<td style="border:1px solid; width:50px;" colspan="3"><center>
			  Total</center></td>

			<!-- <th style="border:2px solid; width:100px;"><center></center></th> -->
			<th style="border:1px solid; width:100px;"><center>{{$amount}}</center></th>		</tr>

		<!-- <tr style="height:30px; border:2px sold;">
			<td style="border:2px solid;" colspan="3">Remarks</td>
			<td style="" colspan="3">
			<p style="margin-top:10px; margin-left: 10px; margin-bottom:10px; ">Driver Name:</p> </br></hr> 
			<p style="margin-left: 10px;">Vehicle No:</p>
			</td>
		</tr></br> -->
		
	</table></br>	<table>
		<!-- <tr>
			<td style="border:2px solid;     float: right;
    margin-right: -530px; padding: 5px 20px;">Total Tax: {{$STValue}}</td>
			<td style="border:2px solid;     float: right;
    margin-right: -730px; padding: 5px 20px;">Total Amount: {{$amount}} </td>
		</tr> -->
	</table></br></br>
	 <p style="margin-left: 10%;"><strong></strong></p>
	  <p style="margin-top: -28px; margin-left: 7%;"><strong>PREPARED BY</strong></p>
	  <p style="margin-top: -29px; margin-left: 30%;"><strong>CHECKED BY</strong></p>
	  <p style="margin-top: -30px; margin-left: 55%;"><strong>APPROVED BY</strong></p>
	  <p style="margin-top: -30px; margin-left: 80%;"><strong>RECIEVED BY</strong></p>
<!--
	<p style="float:right; margin-top: -33px; margin-right: 120px;"><strong>RECEIVED BY&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong></p> --></br>

	<p style="margin-left: 10%;"><strong></strong></p>
	 <p style="margin-top: -28px; margin-left: 7%;"><strong>___________</strong></p>
	 <p style="margin-top: -29px; margin-left: 30%;"><strong>___________</strong></p>
	 <p style="margin-top: -30px; margin-left: 55%;"><strong>___________</strong></p>
	 <p style="margin-top: -30px; margin-left: 80%;"><strong>___________</strong></p>
	<!--<p style="float:right; margin-top: -33px; margin-right: 120px;"><strong>_________________</strong></p> --></br>
	

			
	</body>
</br><!-- <b style="float:right; margin-right: 0px;">Develed by <u style="color:blue;">www.itlife.com.pk</u> | 0321 4197290<