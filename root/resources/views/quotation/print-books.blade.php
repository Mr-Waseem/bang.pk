﻿@include("/include.config")
<?php	
	$que="select * from system_logos";
	$run=@mysql_query($que);

	$row=@mysql_fetch_array($run);
	$image = $row['image'];
	
	$que="select * from settings";
	$run=@mysql_query($que);

	$row=@mysql_fetch_array($run);
	$ntn = $row['state'];
?>
   <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="js/respond.min.js"></script>
</head>

<body onload="window.print();">
	<div class="row">
		<div class="col-sm-12">
			<div class="col-sm-5">
				<div class="card-header">
					<div class="card-short-description">
						<center><span class="user-name"><img src="/upload/logo/<?php echo $image;?>" style="width: 400px;float: left; margin-left: 20px;"></span></center>
					</div>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="card-content">
				</br></br>
				<h4><strong><u style="margin-left: 20px;float: left;">{{$newsale_detail[0]->sale_type}}</u></strong></h4>
					
					<!--<h6><strong>Address : </strong>{{$company_detail[0]->address}}</h6>
					<h6><strong>Email : </strong>{{$company_detail[0]->email}}</h6>
					<h6><strong>Phone : </strong>{{$company_detail[0]->phone}}</h6>
					<h6><strong>Sale Type : </strong>{{$newsale_detail[0]->sale_type}}</h6>
					<h5><strong>Invoice No : </strong>{{$newsale_detail[0]->id}}</br></h5>	-->	
				</div>
			</div>
			<center><h4 style="margin-top: -40px; margin-right: -130px;"><strong>Bill / Invoice</strong></h4></center>
			<div class="col-sm-5">
				</br></br>
				<div class="col-sm-3" style="float:right; margin-right:20%; margin-top: -50;">
						<!--<h5><strong>Customer Details</strong></h5>--->
					<b><strong>Attn</strong></b>&nbsp;:&nbsp;{{$newsale_detail[0]->parties->party_name}}
					<h6><strong>Address : </strong>{{$newsale_detail[0]->parties->address}}</br></h6>
					<h6><strong>City : </strong>{{$newsale_detail[0]->parties->city}}</br></h6>
					<h6><strong>Tel&nbsp;:&nbsp;</strong>{{$newsale_detail[0]->parties->phone}}</h6>
					@if($newsale_detail[0]->due_date != null)
					<h6><strong>Due&nbsp;Date&nbsp;:&nbsp;</strong>{{date('d/m/Y', strtotime($newsale_detail[0]->due_date))}}</h6>
					@endif
				</div>
				<div class="col-sm-2" style="float:right; margin-right:-40%; margin-top: -50px;">
					<!--<h5><strong>Customer Details</strong></h5>--->
					<h6><strong>Date&nbsp;:&nbsp;</strong>{{date("d/m/y", strtotime($newsale_detail[0]->date))}}</h6>
					<h6><strong>Reference&nbsp;No&nbsp;:&nbsp;</strong>{{$newsale_detail[0]->reference_no}}</br></h6>
					<h6><strong>Invoice&nbspNo&nbsp:&nbsp</strong>{{$newsale_detail[0]->id}}</br></h6>
					<h6><strong>NTN&nbsp:&nbsp</strong><?php echo $ntn;?></br></h6>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<div class="card-header">
				<div class="card-short-description">
					<center><span class="user-name"><img src="/upload/logo/logopik.png" style="width: 98%;"></span></center>
				</div>
			</div>
		</div>	
	</div>
	<div class="panel-body">
	<!--<table class="table table-bordered">--->
		<table class="table table-dashed" style="border: 2px solid; width: 100%;">
			<thead>
			<tr style="border:1px solid black !important;">
					<th style="border-bottom: 1px solid;">Sr.</th>
					<!--<th>Code</th>
					<th>Book</th>-->
					<th style="border-bottom: 1px solid;">Product&nbsp;Code</th>
					<th style="border-bottom: 1px solid">Product&nbsp;Name</th>
					<th style="border-bottom: 1px solid">Publisher</th>
					<th style="border-bottom: 1px solid">Qty</th>
					<th style="border-bottom: 1px solid">Price</th>
					<th style="border-bottom: 1px solid">Disc(%)</th>
					<th style="border-bottom: 1px solid">Rate</th>
					<th style="border-bottom: 1px solid">Amount</th>
				</tr>
			</thead>
			<tbody>
			<?php $sum = 1; $nettotal = 0; $totaldiscount = 0; $totaltax = 0; $total = 0; $qty = 0; ?>
				@foreach ($newsale_detail[0]->sale_details as $details)
				<tr class="gradeX" style="border:1px dashed !important; border-bottom: 1px dashed black !important;">
					<center><td style="border-top: none;padding: 2px;"><?php echo $sum; ?></td></center>
					<!--<td>{{$details->products->product_code}}</td>--->
					<td style="border-top: none;padding: 2px;">{{$details->products->product_code}}</td>
					<td style="border-top: none;padding: 2px;">{{$details->products->product_name}}</td>
					<!--<td>{{$details->products->product_english}}</td>---->
					<td style="border-top: none;padding: 2px;">{{$details->products->publishers->name}}</td>
					<td style="border-top: none;padding: 2px;"><center>{{$details->quantity}}<center></td>
					<td style="border-top: none;padding: 2px;">{{$details->unit_cost}}</td>
					<td style="border-top: none;padding: 2px;">{{$details->discount->title}}</td>
					<td style="border-top: none;padding: 2px;">{{$details->discount->discount/100*$details->unit_cost}}</td>
					<td style="border-top: none;padding: 2px;">{{$details->total_cost}}</td>
				</tr>
				<?php 
				$nettotal = $nettotal + $details->total_cost;
				$totaldiscount = $totaldiscount + (($details->discount->discount/100)*$details->quantity*$details->unit_cost);
				//$totaltax = $totaltax + $details->taxes->tax_rate/100 * $details->unit_cost * $details->quantity;
				$qty = $qty + $details->quantity;
				$total = $total + $details->unit_cost * $details->quantity;
				?>
				<?php $sum = $sum + 1; ?>
				
				@endforeach
				<tr class="gradeX" style="border:1px dashed !important;">
					<center><td colspan="8" style="padding-left: 70%; border-top: none;"><b>Total Qty</b></td></center>
					<td style="border-top: none;"><b><?php echo $qty; ?></b></td>
				</tr>
				<tr class="gradeX" style="border:1px dashed !important;">
					<center><td colspan="8" style="padding-left: 70%; border-top: none;"><b>Total Amount</b></td></center>
					<td style="border-top: none;"><b><?php echo $total; ?></b></td>
				</tr>
				<tr class="gradeX" style="border:1px dashed !important;">
					<center><td colspan="8" style="padding-left: 70%; border-top: none;"><b>Total Discount</b></td></center>
					<td style="border-top: none;"><b><?php echo $totaldiscount; ?></b></td>
				</tr>

				<tr class="gradeX" style="border:1px dashed !important;">
					<center><td colspan="8" style="padding-left: 70%; border-top: none;"><b>Payable Amount</b></td></center>
					<td style="border-top: none;"><b><?php echo $nettotal; ?></b></td>
				</tr>
			</tbody>
		</table>
		<hr style="border-color:black;">
	</div>	
		<div class="row">					
			<div class="col-sm-6" style="float:left; margin-left: 10%;">
				<img src="/img/line.png" style="width:200px;height: 2px;"> </img></br>
				Signature
			</div>
								
			<div class="col-sm-6" style="float:right; margin-right: 10%;">
				<img src="/img/line.png" style="width:200px;height: 2px;"> </img></br>
				Checked By
			</div>
		</div>
		<!--<div class="row">
			<div class="col-md-12">
				<div class="cards-container box-view grid-view">
					<div class="row">						
						<div class="col-lg-6 col-sm-6 ">
							<?php $debit = 0; $credit = 0;?>
							@foreach($ledgers as $ledger)
							<?php
								$debit = $debit + $ledger->debit;
								$credit = $credit + $ledger->credit;
							?>
							@endforeach
							
							Previous Balance: <?php echo $credit - $debit;?> </br>
							Current Bill Total: <?php echo $nettotal; ?></br>
							<img src="/img/line.png" style="width: 150px;height: 2px;"> </img></br>
							Total Payable: <?php echo $credit - $debit + $nettotal; ?>
						</div>
					</div>
					<div class="row" style="float:right; margin-right:70px; margin-top: -80px;">						
						<div class="col-lg-6 col-sm-6 ">
							<?php $debit = 0; $credit = 0;?>
							@foreach($ledgers as $ledger)
							<?php
								$debit = $debit + $ledger->debit;
								$credit = $credit + $ledger->credit;
							?>
							@endforeach
							
							Payable Before Discount: <?php echo $total; ?> </br>
							Discount Amount: <?php echo $totaldiscount; ?></br>
							<img src="/img/line.png" style="width: 200px;height: 2px;"> </img></br>
							Total Payable After Doscount: <?php echo $nettotal; ?>
						</div>
					</div>
			</div>
		</div>
		</div>---></br>
		<p style="float:right; margin-right: 20px; size:12px;">Developed by <u style="color:blue;">www.itlife.com.pk</u> | 0321 4197290</p>
</body>	