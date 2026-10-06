@include("/include.config")
<html>
	<head>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>
		<table style="width: 100%;">
		<tr style="border:2px solid;">
			<td style="border:2px solid; width: 100%"><center><b><h3 style="color:blue;">{{$company_detail[0]->title}}</h3></b></center></br>
				<center><b>{{$company_detail[0]->address}}, Lahore. Ph: {{$company_detail[0]->phone}}</b><center>
					<center><b>NTN No: {{$company_detail[0]->state}} Sales Tax No: {{$company_detail[0]->city}}</b><center>
				</br>
			</td>
		</tr>
	</table>
	<center><h3><u><strong>Quotation</strong></u></h3></center>
	<table style="width: 100%;">
		<tr style="border:2px solid;">
			<td style="font-size: 12px;"><b>Company Name:</b> {{$newsale_detail[0]->parties->party_name}}</td>
			<td style="font-size: 12px;"><b>Quotation No:</b> {{$newsale_detail[0]->vr_no}}</td>
		</tr>
		<tr style="border:2px solid;">
			<td style="font-size: 12px;"><b>Address:</b> {{$newsale_detail[0]->parties->address}}</td>
			<td style="font-size: 12px;"><b>Quotation Date:</b> {{date("d/m/Y", Strtotime($newsale_detail[0]->from_date))}}</td>
		</tr>
		<tr style="border:2px solid;">
			<td style="font-size: 12px;"><b>Tel:</b> {{$newsale_detail[0]->parties->phone}}</td>
			<td style="font-size: 12px;"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;To</b></td>
		</tr>
		<tr style="border:2px solid;">
			<td style="font-size: 12px;"><b>NTN:</b> {{$newsale_detail[0]->parties->ntn}}</td>
			
		</tr>
		<tr style="border:2px solid;">
			<td style="font-size: 12px;"><b>GST No:</b> {{$newsale_detail[0]->parties->strn}}</td>
			<td style="font-size: 12px;"><b>Validity Date</b> {{date("d/m/Y", Strtotime($newsale_detail[0]->to_date))}}</td>
		</tr>
		<tr style="border:2px solid;">
			<td style="font-size: 12px;"><b>Reference:</b> {{$newsale_detail[0]->reference}}</td>
		</tr>
		<tr style="border:2px solid;">
			<td style="font-size: 12px;"><b>Our Best Prices On:</b> {{$newsale_detail[0]->best_prices}}</td>
			<td>{{ $newsale_detail->links() }}</td>
		</tr>
	</table>
	<h6></h6>
	<table style="width: 100%;">
		<tr style="background: grey;">
			<th style="border:2px solid; width:10%;"><center>SR</center></th>
			<th style="border:2px solid; width:40%;"><center>Product & Description</center></th>
			<th style="border:2px solid; width:20%;"><center>Rate(KG/Litter)</center></th>
			<th style="border:2px solid; width:20%;"><center>GST%</center></th>
			<th style="border:2px solid; width:20%;"><center>Inclusive GST</center></th>
		</tr>
		<?php $sum = 1;?>
			@foreach ($newsale_detail[0]->quotation_details as $details)
		<tr style="">
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:10%;font-size: 12px;"><center>{{$sum}}</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:40%; font-size: 12px;"><center style="float: left; margin-left:5px;">{{$details->products->product_name}}, {{$details->description}}</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:20%;font-size: 12px;"><center>{{(int)$details->rate}}</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:20%;font-size: 12px;"><center>{{(int)$details->gst}}</center></td>
			<td style="border-bottom:1px solid; border-right:2px solid; border-left:2px solid; width:20%;font-size: 12px;"><center>{{(int)$details->amount}}</center></td>
		</tr>
		@php $sum = $sum + 1; @endphp
		@endforeach
	</br>
	</table>
	<h6></h6>
	<span style="margin-top: 30px;"><b>Note:</b> {{$newsale_detail[0]->note}}</span>
	<span style="margin-top: 30px;"><b><h4>With Best Regards:</h4></b></span>
	<span><b><h4>{{$newsale_detail[0]->best_regards}}</h4></b></span>
	<h6><b>.</b></h6>
	<h6><b>.</b></h6>
	<center><b>THANK YOU FOR YOUR BUSINESS</b></center>
	<center><b>Email:</b> {{$company_detail[0]->email}}</center>
	</body>
</html>
<!-- <b style="float:right; margin-right: 0px;">Developed by <u style="color:blue;">www.itlife.com.pk</u> | 0321 4197290</b> -->
