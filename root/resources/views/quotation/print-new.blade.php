<html>
<head>
  <link href="/css/bg.css" rel="stylesheet">
</head>
	<body style="border:double;" onload="window.print();">
			<!--<span style="float: right;margin-top: -19px;">-->
			<!--	<?php $t=time(); ($t . "<br>"); echo(date("d-m-Y",$t)); ?>-->
			<!--</span>-->
			<!-- <h3 style="margin-left: 1250px;"><u><strong>SALE INVOICE</strong></u></h3> -->
			</br><div class="row">
				<div >
					<div style="float:left; color: #1e00c6;margin-left: 2%; ">
						JADEED HOMEO CLINIC
					</div>
					<div style="float: right;padding: 0px 4%;">
						<u style="color: #1e00c6"><strong>SALES INVOICE</strong></u></h3>
					</div>
				</div>
			</div></br></br>

			<div class="row">
				<div >
					<div style="float:left; color: #1e00c6;margin-left: 2%;">
						JADEED HOMEO CLINIC
					</div>
					<div style="float: right;color: white;padding: 0px 8%;border: 2px solid #1e00c6;background: #1e00c6;margin-right: 2%;">
						Date
					</div>
				</div>
			</div></br>
			<div class="row" style="margin-top: 3px;">
				<div >
					<div style="float:left; color: #1e00c6;padding: 0px 2%;">
						M SAMMAR ABBAS
					</div>
					<div style="float: right;margin-right: -16%;">
						10/12/2019
					</div>
				</div>
			</div></br>
			<div class="row" style="margin-top: 3px;">
				<div >
					<div style="float:left; color: #1e00c6;padding: 0px 2%;">
						HELLO MAN
					</div>
					<div style="float: right;color: white;padding: 0px 8%;border: 2px solid #1e00c6;background: #1e00c6;margin-right: 2%;">
						Date
					</div>
				</div>
			</div>
			</br>
			<div class="row" style="margin-top: 3px;">
				<div >
					<div style="float:left; color: #1e00c6;padding: 0px 2%;">
						M SAMMAR ABBAS
					</div>
					<div style="float: right;margin-right: -16%;">
						10/12/2019
					</div>
				</div>
			</div>
			</br>
			<div class="row" style="margin-top: 3px;">
				<div >
					<div style="float:left; color: #1e00c6;padding: 0px 2%;">
						HELLO MAN
					</div>
					<div style="float: right;color: white;padding: 0px 8%;border: 2px solid #1e00c6;background: #1e00c6;margin-right: 2%;">
						Date
					</div>
				</div>
			</div></br>

			<div class="row" style="margin-top: 3px;">
				<div >
					<div style="float:left; color: white;padding: 0px 2%; border: 2px solid #1e00c6;background: #1e00c6; width: 40%;">
						HELLO MANksksklsksj
					</div>
					<div style="float: right;color: white;padding: 0px 8%;border: 2px solid #1e00c6;background: #1e00c6;margin-right: 2%;">
						Date
					</div>
				</div>
			</div></br>

			<!-- <p style="color: #5fadf1;padding: 0px 2%;">Company Name</p>
			<p style="color: #5fadf1;padding: 0px 2%;">Company Name</p> -->
	<!-- <table style="width: 1000px; border:double;">
		<tr style="border:double; width: 950px;">
			<td><h3><b><center>{{$company_detail[0]->system_name}}</center></b></h3>
				<center>{{$company_detail[0]->phone}}</center>
				<center>{{$company_detail[0]->email}}</center>
				<center>{{$company_detail[0]->address}}</center>
			</td>
			<td style="border:double;"><center>Bill No: <b>{{$newsale_detail[0]->invoice_no}}</b></center></br>
				<center>Date: <b>{{date("d/m/Y", strtotime($newsale_detail[0]->date))}}</b></center>
				<center>Time: <b>{{date("H:i:s A", strtotime($newsale_detail[0]->created_at))}}</b></center>
				</br>
			</td>
		</tr>
		<tr style="height:60px; border:double;">
		    <td style="margin-left: 10%;float: left;margin-top: 3.5%;"><b><u>CUSTOMER&nbsp;NAME: {{$newsale_detail[0]->parties->party_name}}</u><b></td>
		    <td style=""><b>&nbsp;<u>CITY: {{$newsale_detail[0]->parties->city}}</u><b></td>
		</tr>
	</table></br> -->
	<table style="width: 98%; border:2px solid; padding: 10px 20px; margin-left: 1%;
    margin-right: 1%;">
		<thead>
		<tr style="background:#1e00c6;" >
			<th style="width:50px; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;"><center>SR</center></th>
			<!--<th style="border:2px solid; width:50px;"><center>Code</center></th>-->
			<th style="width:340px; border-top: 2px solid;border-bottom: 2px solid;"><center>Item Description</center></th>
			<th style="width:100px; border-top: 2px solid;border-bottom: 2px solid;"><center>Quantity</center></th>

			<th style="width:100px; border-top: 2px solid;border-bottom: 2px solid;"><center>Discount</center></th>
			<th style="width:100px; border-top: 2px solid;border-bottom: 2px solid;"><center>Rate</center></th>
			<th style="width:100px; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;"><center>Amount</center></th>
		</tr>
	</thead>

		<!-- <tr style="background:  #1e00c6;">
			<th style="border:2px solid; width:50px;"><center>SR</center></th>
			<th style="border:2px solid; width:340px;"><center>Item Description</center></th>
			<th style="border:2px solid; width:100px;"><center>Quantity</center></th>

			<th style="border:2px solid; width:100px;"><center>Discount</center></th>
			<th style="border:2px solid; width:100px;"><center>Rate</center></th>
			<th style="border:2px solid; width:100px;"><center>Amount</center></th>
		</tr> -->
		<tbody>
		<?php $sum = 1; $quantity = 0; $rate = 0; $amount = 0; $discount = 0; $discountvalue=0; $grossamount=0; ?>
			@foreach ($newsale_detail[0]->sale_details as $details)
		<tr id="datafont" style="border:2px solid;">
			<td id="tabledata"><center>{{$sum}}</center></td>
			<!--<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>
			@if($details->products!=null)
			    {{$details->products->product_code}}
			    @endif</center></td>-->
			<td id="tabledata"><center style="float: left; margin-left:5px;">
				@if($details->products!=null)
			    {{$details->products->product_name}}
			    @endif
			</center></td>
			<td id="tabledata" style=""><center>{{$details->quantity}}&nbsp;&nbsp;&nbsp;{{$details->uoms->uom}}</center></td>
			<td id="tabledata" style=" "><center>{{$details->discount->discount}}%</center></td>
			@php
			$value = $details->discount->discount/100*($details->sale_rate*$details->quantity);
			$gross = $details->sale_rate*$details->quantity;
			@endphp
			
 			<!-- <td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;font-size: 12px;"><center>{{$gross}}</center></td> -->
			<td id="tabledata" style=" width:100px;"><center>{{(int)$details->sale_rate}}</center></td>
			<td id="tabledata" style=" width:100px;"><center>{{(int)$details->sale_amount}}</center></td>
		</tr>
		<?php 
		
		$discount = $discount + $details->discount->discount;
		$discountvalue = $discountvalue + $value;
		$grossamount = $grossamount + $gross;
		$quantity = $quantity + $details->quantity;
		$rate = $rate + $details->sale_rate;
		$amount = $amount + $details->sale_amount;
		$sum = $sum + 1;
		?>
		@endforeach
		<tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
		
		</tr>
		<tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
		
		</tr>
		<tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
		
		</tr>
		<tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
		
		</tr>
		<tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
		
		</tr>
		<!-- <tr>
			<td><center>&nbsp;</center></td>
			<td><center></center></td>
			<td><center></center></td>
			<td><center></center></td>
			<td><center></center></td>
			<td><center></center></td>
		
		</tr> -->

		<tr id="datafont">
			<td>Remarks&nbsp;/&nbsp;Instructions:</td>
			<td><center></center></td>
			<td><center></center></td>
			<td id="tabledata" colspan="2" style="background: #b2dee8;"><center>GROSS TOTAL</center></td>
			<td id="tabledata" style="background: #b2dee8;"><center></center></td>
		</tr>
		<tr id="datafont">
			<td><center></center></td>
			<td><center></center></td>
			<td><center></center></td>
			<td id="tabledata" colspan="2" style="background: #b2dee8;"><center>DISCOUNT</center></td>
			<td id="tabledata" style="background: #b2dee8;"><center></center></td>
		</tr>
		<tr id="datafont">
			<td>Issud By: {{$newsale_detail[0]->billers->name}}</td>
			<td><center></center></td>
			<td><center></center></td>
			<td id="tabledata" colspan="2" style="background: #b2dee8;"><center>NET TOTAL</center></td>
			<td id="tabledata" style="background: #b2dee8;"><center></center></td>
		</tr>
	<!-- 	<tr id="datafont">
			<td><center></center></td>
			<td><center></center></td>
			<td><center></center></td>
			<td id="tabledata" colspan="2" style="background: #0cbee6;"><center>SUBTOTAL</center></td>
			<td id="tabledata" style="background: #0cbee6;"><center></center></td>
		</tr>
		<tr id="datafont">
			<td><center></center></td>
			<td><center></center></td>
			<td><center></center></td>
			<td id="tabledata" colspan="2" style="background: #0cbee6;"><center>SUBTOTAL</center></td>
			<td id="tabledata" style="background: #0cbee6;"><center></center></td>
		</tr> -->

<!-- 		<tr style="background: #1e00c6;">
			<td style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid; width:50px;" colspan="2"><center>GROSS TOTAL</center></td>
			<th style="border-top: 2px solid;border-bottom: 2px solid; width:100px;"><center>{{$quantity}}</center></th>
			<th style="border-top: 2px solid;border-bottom: 2px solid; width:100px;" colspan="2"><center></center></th>
			<th style="border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid; width:100px;"><center>RS: {{(int)$grossamount}}</center></th>
		</tr>

		<tr style="background: #1e00c6;">
			<td style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid; width:50px;" colspan="2"><center>DISCOUNT</center></td>
			<th style="border-top: 2px solid;border-bottom: 2px solid; width:100px;" colspan="3"><center></center></th>
			<th style="border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid; width:100px;"><center>RS: {{(int)$discountvalue}}</center></th>
		</tr>
		<tr style="background: #1e00c6;">
			<td style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid; width:50px;" colspan="2"><center>NET TOTAL</center></td>
			<th style="border-top: 2px solid;border-bottom: 2px solid; width:100px;" colspan="3"><center></center></th>
			<th style="border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid; width:100px;"><center>RS: {{(int)$grossamount-(int)$discountvalue}}</center></th>
		</tr> -->
		<!-- <tr style="height:30px; border:2px solid;">
			<td style="border:2px solid;" colspan="3">Remarks</td>
			<td style="border-right: 2px solid;" colspan="3">
			<p style="margin-top:10px; margin-left: 10px; margin-bottom:10px; ">Driver Name:</p> </br></hr> 
			<p style="margin-left: 10px;">Vehicle No:</p>
			</td>
		</tr> --></br>
		</tbody>
	</table></br>
	<!-- <p><strong>ISSUED BY</strong></p> -->
	<!-- <p><center style="margin-top: -28px;"><strong>APPROVED BY</strong></center></p>
	<p style="float:right; margin-top: -33px;"><strong>RECIEVED BY</strong></p></br> -->
	<!-- <p><strong><u>{{$newsale_detail[0]->billers->name}}</u></strong></p> -->
<!-- 	<p><center style="margin-top: -28px;"><strong>___________</strong></center></p>
	<p style="float:right; margin-top: -33px;"><strong>___________</strong></p></br> -->
	</body>
	<p><center style="color: #1e00c6; font-size: 12px; font-family: monospace;">If you have any question about this invoice, please contact</center></p>
	<p><center style="color: #1e00c6; font-size: 12px; font-family: monospace;">Name: {{$newsale_detail[0]->billers->name}} Phone: {{$company_detail[0]->phone}} Email: {{$company_detail[0]->email}}</center></p>
	<h4><center><b style="color: #1e00c6; font-family: monospace;">THANKYOU FOR YOUR VISIT AT {{$company_detail[0]->title}}!</b></center></h4>
</html>
</br>
<!-- <b style="float:right; margin-right: 0px;">Developed by <u style="color:blue;">www.itlife.com.pk</u> | 0321 4197290</b> -->
