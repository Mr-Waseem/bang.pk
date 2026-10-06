<html>
<head>
  <link href="{{ asset('css/bg.css') }}" rel="stylesheet">
</head>
	<body style="border:double;" onload="window.print();">
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
						<u style="color: #1e00c6"><strong>PURCHASE INVOICE</strong></u></h3>
					</div>
				</div>
			</div></br></br>

			<div class="row">
				<div >
					<div style="float:left; color: #1e00c6;margin-left: 2%;">
						{{-- <b>{{$company_detail[0]->title}}</b> --}}
					</div>
					<div style="float: right;color: black;padding: 0px 8%;border: 2px solid #1e00c6;background: #1e00c6;margin-right: 2%;">
						DATE
					</div>
				</div>
			</div></br>
			<div class="row" style="margin-top: 3px;">
				<div >
					<div style="float:left; color: #1e00c6;padding: 0px 2%;">
						{{$company_detail[0]->address}}
					</div>
					<div style="float: right;margin-right: -16%;">
						{{date("d/m/Y", Strtotime($newsale_detail->date))}}
					
					</div>
				</div>
			</div></br>
			<div class="row" style="margin-top: 3px;">
				<div >
					<div style="float:left; color: #1e00c6;padding: 0px 2%;">
						{{$company_detail[0]->phone}}
					</div>
					<div style="float: right;color: black;padding: 0px 4%;border: 2px solid #1e00c6;background: #1e00c6;margin-right: 2%;">
						INVOICE&nbsp;&nbsp;NO.
					</div>
				</div>
			</div>
			</br>
			<div class="row" style="margin-top: 3px;">
				<div >
					<div style="float:left; color: #1e00c6;padding: 0px 2%;">
						{{$company_detail[0]->email}}
					</div>
					<div style="float: right;margin-right: -12%;">
						{{$newsale_detail->bill_no}}
					</div>
				</div>
			</div>
			</br>

			<div class="row" style="margin-top: 3px;">
				<div >
					<div style="float:left; color: #1e00c6;padding: 0px 2%; color:blue;">
						<b>BILL TO: 
							@if($newsale_detail->parties)
							{{$newsale_detail->parties->party_name}}
							@endif
						</b>
					</div>
					<!-- <div style="float: right;margin-right: -12%; color:blue;">
						<b>{{$newsale_detail->parties->id}}</b>
					</div> -->
				</div>
			</div>
			</br>
			<!-- <div class="row" style="margin-top: 3px;">
				<center><u><b style="text-transform: uppercase;">{{$newsale_detail->sale_type}}</b></center></u></center>
			</div> -->
	<table style="width: 98%; border:2px solid; padding: 10px 20px; margin-left: 1%;
    margin-right: 1%;">
		<thead>
		<tr style="background:#1e00c6;" >
			<th style="width:1%; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">SR#</th>
			<!--<th style="border:2px solid; width:50px;"><center>Code</center></th>-->
			<th style="width:340px; border-top: 2px solid;border-bottom: 2px solid;"><center>Item&nbsp;Description</center></th>
			<th style="width:100px; border-top: 2px solid;border-bottom: 2px solid;"><center>Qty</center></th>
			<th style="width:100px; border-top: 2px solid;border-bottom: 2px solid;"><center>Rate&nbsp;Amount</center></th>
			<th style="width:100px; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;"><center>Total&nbsp;Amount</center></th>
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
		<?php $sum = 1; $quantity = 0; $rate = 0; $amount = 0;  $grossamount=0; ?>
			@foreach ($newsale_detail->purchase_details as $details)
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
			<td id="tabledata" style=""><center>{{number_format($details->quantity)}}&nbsp;&nbsp;&nbsp;<!-- {{$details->unit->uom}} --></center></td>
			@php

			$gross = $details->sale_rate*$details->quantity;
			@endphp
			<td id="tabledata" style=" width:100px;"><center>{{number_format((int)$details->unit_cost)}}</center></td>
			<td id="tabledata" style=" width:100px;"><center>{{number_format((int)$details->total_cost)}}</center></td>
		</tr>
		<?php 
		

		$quantity = $quantity + (float)$details->quantity;
		$rate = $rate + (float)$details->unit_cost;
		$grossamount = $grossamount + (float)$details->total_cost;
		$sum = $sum + 1;
		?>
		@endforeach
		{{-- <tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<!-- <td id="tabledata"><center></center></td> -->
			<td id="tabledata"><center></center></td>
		</tr>
		<tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<!-- <td id="tabledata"><center></center></td> -->
			<td id="tabledata"><center></center></td>
		</tr><tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<!-- <td id="tabledata"><center></center></td> -->
			<td id="tabledata"><center></center></td>
		</tr>
		<tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<!-- <td id="tabledata"><center></center></td> -->
			<td id="tabledata"><center></center></td>
		</tr>
		<tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<!-- <td id="tabledata"><center></center></td> -->
			<td id="tabledata"><center></center></td>
		</tr>
		<tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<!-- <td id="tabledata"><center></center></td> -->
			<td id="tabledata"><center></center></td>
		</tr>
		<tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<!-- <td id="tabledata"><center></center></td> -->
			<td id="tabledata"><center></center></td>
		</tr>
		<tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<!-- <td id="tabledata"><center></center></td> -->
			<td id="tabledata"><center></center></td>
		</tr><tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<!-- <td id="tabledata"><center></center></td> -->
			<td id="tabledata"><center></center></td>
		</tr><tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<!-- <td id="tabledata"><center></center></td> -->
			<td id="tabledata"><center></center></td>
		</tr><tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<!-- <td id="tabledata"><center></center></td> -->
			<td id="tabledata"><center></center></td>
		</tr>
		<tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<!-- <td id="tabledata"><center></center></td> -->
			<td id="tabledata"><center></center></td>
		</tr><tr id="datafont">
			<td id="tabledata"><center>&nbsp;</center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<td id="tabledata"><center></center></td>
			<!-- <td id="tabledata"><center></center></td> -->
			<td id="tabledata"><center></center></td>
		</tr> --}}
		<tr id="datafont">
			<td>Remarks</td>
			<td><center></center></td>
			<!-- <td><center></center></td> -->
			<td id="tabledata" colspan="2" style="background: #b2dee8;"><center>GROSS TOTAL</center></td>
			<td id="tabledata" style="background: #b2dee8;"><center>{{$company_detail[0]->currency}}: {{number_format($grossamount)}}</center></td>

		</tr>

		<tr id="datafont">
			<td><center></center></td>
			<td><center></center></td>
			<!-- <td><center></center></td> -->
			<td id="tabledata" colspan="2" style="background: #b2dee8;"><center>NET TOTAL</center></td>
			<td id="tabledata" style="background: #b2dee8;"><center>{{$company_detail[0]->currency}}: {{number_format($grossamount)}}</center></td>
		</tr></br>
		</tbody>
	</table>

	
	</body>
</br>
@php $debit = 0; $credit = 0;@endphp
	
	


	{{-- <p><center style="color: #1e00c6; font-size: 12px; font-family: monospace;">NOTE: PRODUCTS ONCE SOLD ARE NOT RETURNABLE OR EXCHANGEABLE.</center></p>
	 <p><center style="color: #1e00c6; font-size: 12px; font-family: monospace;">Note: You need to pay server charges per year. It may be increased or decreased according to dollar fluctuation.</center></p>
	<p><center style="color: #1e00c6; font-size: 12px; font-family: monospace;">If you have any question about this invoice, please contact</center></p> --}}
	<p><center style="color: #1e00c6; font-size: 12px; font-family: monospace;">Issued&nbsp;By: 
		
		
		@if($newsale_detail->billers)
		{{$newsale_detail->billers->name}}
		@endif
		Phone: {{$company_detail[0]->phone}} Email: {{$company_detail[0]->email}}</center></p>
	<h4><center><b style="color: #1e00c6; font-family: monospace;">THANKYOU FOR YOUR BUSINESS WITH {{$company_detail[0]->title}}!</b></center></h4>
</html>
</br>
<!-- <b style="float:right; margin-right: 0px;">Developed by <u style="color:blue;">www.itlife.com.pk</u> | 0321 4197290</b> -->
