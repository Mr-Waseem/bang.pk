@section("head")
@include("/include.config")
<?php	
	$que="select * from system_logos";
	$run=@mysql_query($que);

	$row=@mysql_fetch_array($run);
	$image = $row['image'];
?>

<!-- Site favicon -->
<link rel='/shortcut icon' type='image/x-icon' href='images/favicon.ico' />
<!-- /site favicon -->

<!-- Entypo font stylesheet -->
<link href="/css/entypo.css" rel="stylesheet">
<!-- /entypo font stylesheet -->

<!-- Font awesome stylesheet -->
<link href="/css/font-awesome.min.css" rel="stylesheet">
<!-- /font awesome stylesheet -->

<!-- Bootstrap stylesheet min version -->
<link href="/css/bootstrap.min.css" rel="stylesheet">
<!-- /bootstrap stylesheet min version -->

<!-- Mouldifi core stylesheet -->
<link href="/css/mouldifi-core.css" rel="stylesheet">
<!-- /mouldifi core stylesheet -->

<link href="/css/plugins/select2/select2.css" rel="stylesheet">
<link href="/css/mouldifi-forms.css" rel="stylesheet">


<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
<![endif]-->
@stop
<body onload="window.print();">
		<div class="row">
			<div class="col-md-12">
			
				<!-- Card grid view -->
				<div class="cards-container box-view grid-view">
					<div class="row">						
						<div class="col-lg-12 col-sm-6 ">
						
							<!-- Card -->
							<div class="card">
							
								<!-- Card header -->
								<div class="card-header">
									<div class="card-short-description">
										<center><span class="user-name"><img src="/upload/logo/<?php echo $image;?>" style="height:100px; weight: 200px;"></span></center>
									</div>
								</div>
								<!-- /card header -->

								<!-- Card content -->
								<div class="card-content">
									<h3><strong>{{$company_detail[0]->system_name}}</strong></br></h3>
									<h5 style="margin-top: -20px;"><strong>Address : </strong>{{$company_detail[0]->address}}</br></h4>
									<h5 style="margin-top: -20px;"><strong>Phone : </strong>{{$company_detail[0]->phone}}</h5>
									<h5 style="margin-top: -20px;"><strong>Email : </strong>{{$company_detail[0]->email}}</br></h5>
									<h4 style="margin-top: -20px;"><strong>Date : </strong>{{$newsale_detail[0]->date}}</br></h4>
									<h4 style="margin-top: -20px;"><strong>Invoice No : </strong>{{$newsale_detail[0]->id}}</br></h4>
									
								</div>
								
								<div class="card-content" style="float: right; margin-top: -150px; margin-right: 100px;">
									<h3><strong>Customer Name</strong></h3>
									<h5 style="margin-top: -20px;"><strong>Attn : </strong>{{$newsale_detail[0]->parties->party_name}}</br></h5>
									<h5 style="margin-top: -20px;"><strong>Tel : </strong>{{$newsale_detail[0]->parties->phone}}</br></h5>
									<h5 style="margin-top: -20px;"><strong>City : </strong>{{$newsale_detail[0]->parties->city}}</br></h5>
									<h4 style="margin-top: -20px;"><strong>Reference No : </strong>{{$newsale_detail[0]->reference_no}}</br></h4>
								</div>
								<!-- /card content -->
							<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover dataTables-example" >
									<thead>
										<tr>
											<th style="border:1px solid;">No</th>
											<th style="border:1px solid;">Description</th>
											<th style="border:1px solid;">Quantity</th>
											<th style="border:1px solid;">Charges</th>
										</tr>
									</thead>
									<tbody>
									<?php $sum = 1; $nettotal = 0; $totaldiscount = 0; $totaltax = 0; $total = 0; ?>
									@foreach ($newsale_detail[0]->repairing_details as $details)
									
										<tr class="gradeX">
											<td style="border:1px solid;"><?php echo $sum; ?></td>
											<td style="border:1px solid;">{{$details->products->product_name}} ({{$details->products->product_code}})</td>
											<td style="border:1px solid;">{{$details->quantity}}</td>
											<td style="border:1px solid;">{{$details->charges}}</td>
										</tr>
										<?php 
										$nettotal = $nettotal + $details->charges;
			
										
										?>
										<?php $sum = $sum + 1; ?>
									
									@endforeach
										<tr class="gradeX">
											<center><td colspan="3" style="padding-left: 700px; border:1px solid;">Total</td></center>
											<td style="border:1px solid;"><?php echo $nettotal; ?></td>
										</tr>
									</tbody>
									</table>
								</div>
							</div>
							</div>
							<!-- /card -->	
						</div>
					</div>
				</div>
				<!-- /card grid view -->
			</div>
		</div>		</br>
		<div class="row">
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
		</div>
		<p style="float:right; margin-right: 100px; size:12px;">Developed by <u style="color:blue;">www.stechsofts.com</u></p>
</body>	