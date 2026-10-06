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
	<body>
	<center><h3><u><strong>SALE BILL</strong></u></h3></center>
	<table style="width: 100%;">
		<tr style="border:2px solid;">
			<td><h3><b><center>{{$company_detail[0]->system_name}}</center></b></h3></br>
				<center>Address: {{$company_detail[0]->address}}</center>
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
			<th style="border:2px solid; width:10%;"><center>SR</center></th>
			<!--<th style="border:2px solid; width:50px;"><center>Code</center></th>-->
			<th style="border:2px solid; width:40%;"><center>Item Description</center></th>
			<th style="border:2px solid; width:10%;"><center>Quantity</center></th>
			<th style="border:2px solid; width:10%;"><center>Discount</center></th>
			<th style="border:2px solid; width:20%;"><center>Rate</center></th>
			<th style="border:2px solid; width:20%;"><center>Amount</center></th>
		</tr>
		<?php $sum = 1; $quantity = 0; $rate = 0; $amount = 0; $discount = 0; ?>
			@foreach ($newsale_detail[0]->sale_details as $details)
		<tr style="">
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:10%;font-size: 12px;"><center>{{$sum}}</center></td>
			<!--<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:50px;"><center>{{$details->products->product_code}}</center></td>-->
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:40%; font-size: 12px;"><center style="float: left; margin-left:5px;">{{$details->products->product_name}}</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:10%;font-size: 12px;"><center>{{$details->quantity}}&nbsp;{{$details->uoms->uom}}</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:10%;font-size: 12px;"><center>{{$details->discount->discount}}%</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:20%;font-size: 12px;"><center>{{(int)$details->sale_rate}}</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:20%;font-size: 12px;"><center>{{(int)$details->sale_amount}}</center></td>
		</tr>
		<?php 
		$discount = $discount + $details->discount->discount;
		$quantity = $quantity + $details->quantity;
		$rate = $rate + $details->sale_rate;
		$amount = $amount + $details->sale_amount;
		$sum = $sum + 1;
		?>
		@endforeach

		<tr style="background: grey;">
			<th colspan="2"><center>Total</center></th>
			<th><center>{{$quantity}}</center></th>
			<th><center>{{$discount}}</center></th>
			<th><center>{{(int)$rate}}</center></th>
			<th><center>{{(int)$amount}}</center></th>
		</tr>
	</br>
		
	</table></br>
	<p><strong>ISSUED BY</strong></p>
	<!-- <p><center style="margin-top: -100px;"><strong>APPROVED BY</strong></center></p>
	<p style="float:right; margin-top: -33px;"><strong>RECIEVED BY</strong></p></br> -->
	<p><strong><u>{{$newsale_detail[0]->billers->name}}</u></strong></p>
	<!-- <p><center><strong style="margin-top: -28px;">___________</strong></center></p>
	<p style="float:right; margin-top: -33px; margin-right: -30px;"><strong>___________</strong></p></br> -->
	

			
	</body>
</html>
</br>
<!-- <b style="float:right; margin-right: 0px;">Developed by <u style="color:blue;">www.itlife.com.pk</u> | 0321 4197290</b> -->
