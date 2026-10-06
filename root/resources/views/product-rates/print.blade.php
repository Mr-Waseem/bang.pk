<html>
<head>
  <link href="/css/bg.css" rel="stylesheet">
</head>
	<body style="border:double;">
			<!--<span style="float: right;margin-top: -19px;">-->
			<!--	<?php $t=time(); ($t . "<br>"); echo(date("d-m-Y",$t)); ?>-->
			<!--</span>-->
			<!-- <h3 style="margin-left: 1250px;"><u><strong>SALE INVOICE</strong></u></h3> -->
			</br><div class="row">
				<div >
					<div style="float:left; color: #1e00c6;margin-left: 2%; ">
						<b style="font-size: 23px;">{{$company_detail[0]->system_name}}</b>
					</div>
					<div style="float: right;padding: 0px 4%;">
						<u style="color: #1e00c6"><strong>RATE DETAILS</strong></u></h3>
					</div>
				</div>
			</div></br></br>

			<div class="row">
				<div >
					<div style="float:left; color: #1e00c6;margin-left: 2%;">
						<b>{{$company_detail[0]->title}}</b>
					</div>
					<div style="float: right;color: black;padding: 0px 4%;border: 2px solid #1e00c6;background: #1e00c6;margin-right: 2%;">
						CUSTOMER NAME
					</div>
				</div>
			</div></br>
			<div class="row" style="margin-top: 3px;">
				<div >
					<div style="float:left; color: #1e00c6;padding: 0px 2%;">
						{{$company_detail[0]->address}}
					</div>
					<div style="float: right;margin-right: -16%;">
						{{$newsale_detail[0]->party->party_name}}
					
					</div>
				</div>
			</div></br>
			<!-- <div class="row" style="margin-top: 3px;">
				<div >
					<div style="float:left; color: #1e00c6;padding: 0px 2%;">
						PUNJAB, PAKISTAN.
					</div>
					<div style="float: right;color: black;padding: 0px 4%;border: 2px solid #1e00c6;background: #1e00c6;margin-right: 2%;">
						RECIPE QTY
					</div>
				</div>
			</div>
			</br> -->
			<div class="row" style="margin-top: 3px;">
				<div >
					<div style="float:left; color: #1e00c6;padding: 0px 2%;">
						{{$company_detail[0]->phone}}
					</div>
					<div style="float: right;margin-right: -12%;">
						{{$newsale_detail[0]->quantitys}}
					</div>
				</div>
			</div>
			</br>
			<div class="row" style="margin-top: 3px;">
				<div >
					<div style="float:left; color: #1e00c6;padding: 0px 2%;">
						{{$company_detail[0]->email}}
					</div>
					<div style="float: right;color: black;padding: 0px 4%;border: 2px solid #1e00c6;background: #1e00c6;margin-right: 2%;">
						CUSTOMER CODE
					</div>
				</div>
			</div></br>
			<div class="row" style="margin-top: 3px;">
				<div >
					<div style="float:left; color: #1e00c6;padding: 0px 2%; color:blue;">
						<b>Creation Date:{{date("d/m/Y", Strtotime($newsale_detail[0]->date))}}</b>
					</div>
					<div style="float: right;margin-right: -12%;">
						{{$newsale_detail[0]->party->code}}
					</div>
				</div>
			</div>
			</br>
			<!-- <div class="row" style="margin-top: 3px;">
				<center><u><b style="text-transform: uppercase;">{{$newsale_detail[0]->sale_type}}</b></center></u></center>
			</div> -->
	<table style="width: 98%; border:2px solid; padding: 10px 20px; margin-left: 1%;
    margin-right: 1%;">
		<thead>
		<tr style="background:#1e00c6;" >
			<th style="width:1%; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">SR#</th>
			<!--<th style="border:2px solid; width:50px;"><center>Code</center></th>-->
			<th style="width:340px; border-top: 2px solid;border-bottom: 2px solid;"><center>Item&nbsp;Description</center></th>
			

			<!-- <th style="width:100px; border-top: 2px solid;border-bottom: 2px solid;"><center>Discount</center></th> -->
			<th style="width:100px; border-top: 2px solid;border-bottom: 2px solid;"><center>Rate&nbsp;Amount</center></th>
			
		</tr>
	</thead>
		<tbody>
		<?php $sum = 1; $quantity = 0; $rate = 0; $amount = 0; $discount = 0; $discountvalue=0; $grossamount=0; ?>
			@foreach ($newsale_detail[0]->rate_details as $details)
		<tr id="datafont" style="border:2px solid;">
			<td id="tabledata"><center>{{$sum}}</center></td>
			<td id="tabledata"><center>
				@if($details->product!=null)
			    {{$details->product->product_name}}
			    @endif
			</center></td>
			

			<td id="tabledata" style=" width:100px;"><center>{{(int)$details->rate}}</center></td>
			
		</tr>
		<?php 
		
		// $grossamount = $grossamount + $gross;
		$quantity = $quantity + $details->quantity;
		$rate = $rate + $details->rate;
		$grossamount = $grossamount + $details->amount;
		$sum = $sum + 1;
		?>
		@endforeach
		<tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>

			<td id="tabledata"><center></center></td>
		</tr>
		<tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>

			<td id="tabledata"><center></center></td>
		</tr><tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>

			<td id="tabledata"><center></center></td>
		</tr>
		<tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>
		
			<td id="tabledata"><center></center></td>
		</tr>
		<tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>
	
			<td id="tabledata"><center></center></td>
		</tr>
		<tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>

			<td id="tabledata"><center></center></td>
		</tr>
		<tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>
	
			<td id="tabledata"><center></center></td>
		</tr>
		<tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>

			<td id="tabledata"><center></center></td>
		</tr><tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>

			<td id="tabledata"><center></center></td>
		</tr><tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>

			<td id="tabledata"><center></center></td>
		</tr><tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>
		
			<td id="tabledata"><center></center></td>
		</tr>
		<tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>
		
			<td id="tabledata"><center></center></td>
		</tr><tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>
		
			<td id="tabledata"><center></center></td>
		</tr>
		<!-- <tr id="datafont">
			<td>REMARKS</td>
			<td><center></center></td>
			
			<td id="tabledata"  style="background: #b2dee8;"><center>GROSS.TOT</center></td>

			<td id="tabledata"  style="background: #b2dee8;"><center>{{$company_detail[0]->currency}}: {{$rate}}</center></td>
			<td id="tabledata" style="background: #b2dee8;"><center>{{$company_detail[0]->currency}}: {{$grossamount}}</center></td>

		</tr>
		<tr id="datafont">
			<td>CREATED&nbsp;BY:&nbsp;{{$newsale_detail[0]->billers->name}}</td>
			
			<td><center></center></td>
			
			<td id="tabledata" colspan="2" style="background: #b2dee8;"><center>NET TOTAL</center></td>
			<td id="tabledata" style="background: #b2dee8;"><center>{{$company_detail[0]->currency}}: {{$grossamount-$discount}}</center></td>
		</tr></br> -->
		</tbody>
	</table>
	</body>
</br>
	<p><center style="color: #1e00c6; font-size: 12px; font-family: monospace;">If you have any question about this invoice, please contact</center></p>
	<p><center style="color: #1e00c6; font-size: 12px; font-family: monospace;">Issued&nbsp;By: {{$newsale_detail[0]->billers->name}} Phone: {{$company_detail[0]->phone}} Email: {{$company_detail[0]->email}}</center></p>
	<h4><center><b style="color: #1e00c6; font-family: monospace;">THANKYOU FOR YOUR BUSINESS WITH {{$company_detail[0]->title}}!</b></center></h4>
</html>
</br>
<!-- <b style="float:right; margin-right: 0px;">Developed by <u style="color:blue;">www.itlife.com.pk</u> | 0321 4197290</b> -->
