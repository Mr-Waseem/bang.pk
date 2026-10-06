@include("/include.config")
<?php	
	$que="select * from system_logos";
	$run=@mysql_query($que);

	$row=@mysql_fetch_array($run);
	$image = $row['image'];
?>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>   <script src="js/respond.min.js"></script>

<body onload="window.print();">
	
							
								<!-- Card header -->
								<div class="card-header">
									<div class="card-short-description">
										<center><span class="user-name"><img src="/upload/logo/<?php echo $image;?>" style="height:100px; weight: 200px;"></span></center>
									</div>
								</div>
								<!-- /card header -->
								</br>
								<div class="row">
									<div class="col-md-12">
										<div class="col-sm-6">
											<div class="card-content">
												<strong>Address : </strong>{{$company_detail[0]->address}}</h4>
												<h5><strong>Email : </strong>{{$company_detail[0]->email}}</h5>
												<h5><strong>Phone : </strong>{{$company_detail[0]->phone}}</h5>
												<h5><strong>Email : </strong>{{$company_detail[0]->email}}</h5>
												<h5><strong>Sale Type : </strong>{{$newsale_detail[0]->sale_type}}</h5></br>
												<h4><strong>Invoice No : </strong>{{$newsale_detail[0]->id}}</br></h4>		
											</div>
										</div>
										<div class="col-sm-6">
											<div style="float: right; margin-top: -25%; margin-right: 10%;">
												<h4><strong>Customer Company Name</strong></h4>
												<h5><strong>Attn : </strong>{{$newsale_detail[0]->parties->party_name}}</br></h5>
												<h5><strong>Tel : </strong>{{$newsale_detail[0]->parties->phone}}</br></h5>
												<h5><strong>City : </strong>{{$newsale_detail[0]->parties->city}}</br></h5>
												<h6><strong>Date : </strong>{{$newsale_detail[0]->date}}</br></h6>
												<h6><strong>Reference No : </strong>{{$newsale_detail[0]->reference_no}}</br></h6>
											</div>
										</div>
									</div>
								</div>
								<!-- Card content -->
								<!---<div class="card-content">
									<h3><strong>{{$company_detail[0]->system_name}}</strong></h3>
									<h5><strong>Address : </strong>{{$company_detail[0]->address}}</h4>
									<h5><strong>Email : </strong>{{$company_detail[0]->email}}</h5>
									<h5><strong>Phone : </strong>{{$company_detail[0]->phone}}</h5>
									<h5><strong>Email : </strong>{{$company_detail[0]->email}}</h5></br>
									<h4><strong>Invoice No : </strong>{{$newsale_detail[0]->id}}</br></h4>
									
								</div>
								
								<div class="card-content" style="float: right; margin-top: -195px; margin-right: 100px;">
									<h3><strong>Customer Company Name</strong></h3>
									<h5><strong>Attn : </strong>{{$newsale_detail[0]->parties->party_name}}</br></h5>
									<h5><strong>Tel : </strong>{{$newsale_detail[0]->parties->phone}}</br></h5>
									<h5><strong>City : </strong>{{$newsale_detail[0]->parties->city}}</br></h5>
									<h4><strong>Date : </strong>{{$newsale_detail[0]->date}}</br></h4>
									<h4><strong>Reference No : </strong>{{$newsale_detail[0]->reference_no}}</br></h4>
								</div>--->
								<!-- /card content -->
							<div class="panel-body">
								<table class="table table-bordered">
									<thead>
											<th>No</th>
											<th>Code</th>
											<th>Book</th>
											<th>Book English</th>
											<th>Quantity</th>
											<th>Price</th>
											<th>Discount</th>
											<th>Sub Total</th>
										</tr>
									</thead>
									<tbody>
									<?php $sum = 1; $nettotal = 0; $totaldiscount = 0; $totaltax = 0; $total = 0; ?>
									@foreach ($newsale_detail[0]->sale_details as $details)
									
										<tr class="gradeX" border="1px solid;">
											<center><td><?php echo $sum; ?></td></center>
											<td>{{$details->products->product_code}}</td>
											<td>{{$details->products->product_name}}</td>
											<td>{{$details->products->product_english}}</td>
											<td>{{$details->quantity}}</td>
											<td>{{$details->unit_cost}}</td>
											<td>{{$details->discount}}</td>
											<td>{{$details->total_cost}}</td>
										</tr>
										<?php 
										$nettotal = $nettotal + $details->total_cost;
										$totaldiscount = $totaldiscount + $details->discount;
										//$totaltax = $totaltax + $details->taxes->tax_rate/100 * $details->unit_cost * $details->quantity;
										$total = $total + $details->unit_cost * $details->quantity;
										
										?>
										<?php $sum = $sum + 1; ?>
									
									@endforeach
										<tr class="gradeX">
											<center><td colspan="7" style="padding-left: 70%;">Total Amount</td></center>
											<td><?php echo $total; ?></td>
										</tr>
										<tr class="gradeX">
											<center><td colspan="7" style="padding-left: 70%;">Total Discount</td></center>
											<td><?php echo $totaldiscount; ?></td>
										</tr>
		
										<tr class="gradeX">
											<center><td colspan="7" style="padding-left: 70%;">Grand Total</td></center>
											<td><?php echo $nettotal; ?></td>
										</tr>
									</tbody>
									</table>
								</div>
							
			</br>
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
		</div>--->
		<p style="float:right; margin-right: 100px; size:12px;">Developed by <u style="color:blue;">www.stechsofts.com</u> | 0321 4197290</p>
</body>	