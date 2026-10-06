@include("/include.config")
<?php	
	$que="select * from system_logos";
	$run=@mysqli_query($que);
	$row=@mysqli_fetch_array($run);
	$image = $row['image'];
?>
<html>
	<head>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body onload="window.print();">
			<!--<span style="float: right;margin-top: -19px;">-->
			<!--	<?php $t=time(); ($t . "<br>"); echo(date("d-m-Y",$t)); ?>-->
			<!--</span>-->
			<center><h3><u><strong>SALE BILL</strong></u></h3></center>
	<table style="width: 100%;">
		<tr style="border:2px solid;">
			
			<td><h3><b><center>{{$company_detail[0]->system_name}}</center></b></h3>
				<center>{{$company_detail[0]->phone}}</center>
				<center>{{$company_detail[0]->email}}</center>
				<center>{{$company_detail[0]->address}}</center>
			</td>
			<td style="border:2px solid; width: 150px;"><center>Bill No: <b>{{$newsale_detail[0]->invoice_no}}</b></center></br>
				<center>Date: <b>{{date("d/m/Y", strtotime($newsale_detail[0]->date))}}</b><center>
					<center>Time: <b>{{date("H:i:s A", strtotime($newsale_detail[0]->created_at))}}</b><center>
				</br>
				<!--<center>OGP: <b>{{date("d/m/Y", strtotime($newsale_detail[0]->date))}}</b><center>-->
			</td>
		</tr>
		<tr style="height:60px; border:2px solid;">
		    <td style="margin-left: 10%;float: left;margin-top: 3.5%;"><b><u>CUSTOMER&nbsp;NAME: {{$newsale_detail[0]->parties->party_name}}</u><b></td>
		    <td style=""><b>&nbsp;<u>CITY: {{$newsale_detail[0]->parties->city}}</u><b></td>
		</tr>
	</table></br>
	<table style="width: 100%;">
		<tr style="background: grey;">
			<th style="border:2px solid; width:50px;"><center>SR</center></th>
			<!--<th style="border:2px solid; width:50px;"><center>Code</center></th>-->
			<th style="border:2px solid; width:340px;"><center>Item Description</center></th>
			<th style="border:2px solid; width:100px;"><center>Quantity</center></th>

			<th style="border:2px solid; width:100px;"><center>Discount</center></th>
			<th style="border:2px solid; width:100px;"><center>Rate</center></th>
			<th style="border:2px solid; width:100px;"><center>Amount</center></th>
		</tr>
		<?php $sum = 1; $quantity = 0; $rate = 0; $amount = 0; $discount = 0; $discountvalue=0; $grossamount=0; ?>
			@foreach ($newsale_detail[0]->sale_details as $details)
		<tr style="">
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; solid; width:50px;font-size: 12px;"><center>{{$sum}}</center></td>
			<!--<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>
			@if($details->products!=null)
			    {{$details->products->product_code}}
			    @endif</center></td>-->
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:340px; font-size: 12px;"><center style="float: left; margin-left:5px;">
				@if($details->products!=null)
			    {{$details->products->product_name}}
			    @endif
			</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;font-size: 12px;"><center>{{$details->quantity}}&nbsp;&nbsp;&nbsp;{{$details->uoms->uom}}</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;font-size: 12px;"><center>{{$details->discount->discount}}%</center></td>
			@php
			$value = $details->discount->discount/100*($details->sale_rate*$details->quantity);
			$gross = $details->sale_rate*$details->quantity;
			@endphp
			
 			<!-- <td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;font-size: 12px;"><center>{{$gross}}</center></td> -->
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;font-size: 12px;"><center>{{(int)$details->sale_rate}}</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;font-size: 12px;"><center>{{(int)$details->sale_amount}}</center></td>
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
			<!--<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>-->
		</tr>
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:340px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<!--<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>-->
		</tr>
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:340px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<!-- <td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td> -->
		</tr>
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:340px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<!--<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>-->
		</tr>
		<tr>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>-</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:340px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td>
			<!-- <td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:100px;"><center></center></td> -->
		</tr>

		<tr style="background: grey;">
			<td style="border:2px solid; width:50px;" colspan="2"><center>GROSS TOTAL</center></td>
			<th style="border:2px solid; width:100px;"><center>{{$quantity}}</center></th>
			<!-- <th style="border:2px solid; width:100px;"><center>{{$discount}}</center></th>
			<th style="border:2px solid; width:100px;"><center>{{(int)$rate}}</center></th> -->
			<th style="border:2px solid; width:100px;" colspan="2"><center></center></th>
			<!-- <th style="border:2px solid; width:100px;"><center></center></th> -->
			<th style="border:2px solid; width:100px;"><center>RS: {{(int)$grossamount}}</center></th>
		</tr>

		<tr style="background: grey;">
			<td style="border:2px solid; width:50px;" colspan="2"><center>DISCOUNT</center></td>
			<th style="border:2px solid; width:100px;" colspan="3"><center></center></th>
			<th style="border:2px solid; width:100px;"><center>RS: {{(int)$discountvalue}}</center></th>
		</tr>
		<tr style="background: grey;">
			<td style="border:2px solid; width:50px;" colspan="2"><center>NET TOTAL</center></td>
			<th style="border:2px solid; width:100px;" colspan="3"><center></center></th>
			<th style="border:2px solid; width:100px;"><center>RS: {{(int)$grossamount-(int)$discountvalue}}</center></th>
		</tr>
		<!-- <tr style="height:30px; border:2px solid;">
			<td style="border:2px solid;" colspan="3">Remarks</td>
			<td style="border-right: 2px solid;" colspan="3">
			<p style="margin-top:10px; margin-left: 10px; margin-bottom:10px; ">Driver Name:</p> </br></hr> 
			<p style="margin-left: 10px;">Vehicle No:</p>
			</td>
		</tr> --></br>
		
	</table></br>
	<p><strong>ISSUED BY</strong></p>
	<!-- <p><center style="margin-top: -28px;"><strong>APPROVED BY</strong></center></p>
	<p style="float:right; margin-top: -33px;"><strong>RECIEVED BY</strong></p></br> -->
	<p><strong><u>{{$newsale_detail[0]->billers->name}}</u></strong></p>
<!-- 	<p><center style="margin-top: -28px;"><strong>___________</strong></center></p>
	<p style="float:right; margin-top: -33px;"><strong>___________</strong></p></br> -->
	</body>
	<h4><center><b>THANKYOU FOR VISIT {{$company_detail[0]->title}}!</b></center></h4>
</html>
</br>
<!-- <b style="float:right; margin-right: 0px;">Developed by <u style="color:blue;">www.itlife.com.pk</u> | 0321 4197290</b> -->
