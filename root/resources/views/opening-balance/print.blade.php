﻿﻿@include("/include.config")
<?php	
	$que="select * from system_logos";
	$run=@mysql_query($que);

	$row=@mysql_fetch_array($run);
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
	  <div class="content-wrapper">
        <section class="content">
			<span style="float: right;margin-top: -19px;">
				<?php $t=time(); ($t . "<br>"); echo(date("d-m-Y",$t)); ?>
			</span>
			
			<div class="panel panel-default">
				<!---<div class="panel-heading"><div class="card-header">
									<div class="card-short-description">
										<center><span class="user-name"><img src="/upload/logo/<?php echo $image;?>" style="height:100px; weight: 200px;"></span></center>
									</div>
								</div></div>--->
															<!-- Card -->
							<div class="card">
							
								<!-- Card header -->
								<div class="card-header">
									<div class="card-short-description">
										<h3 style=" margin-left:20px;"><u><strong>SALE INVOICE</strong></u></h3>
										<!--<center><span class="user-name"><img src="/upload/logo/<?php echo $image;?>" style="height:100px; weight: 200px;"></span></center>-->
									</div>
								</div>
								<!-- /card header -->

								<!-- Card content -->
								<div class="card-content">
								<h4 style=" margin-left:20px;"><u>Supplier Name & Address</u></h4>
									<h4 style="margin-top:-10px; margin-left:20px;"><u><strong>{{$company_detail[0]->system_name}}<strong></u></h4>
									<h5 style="margin-top:-8px; margin-left:20px;"><u>{{$company_detail[0]->address}}</h4>
									<h5 style="margin-top:-8px; margin-left:20px;"><u>S.T. Reg.No : {{$company_detail[0]->city}}</u></h5>
									<h5 style="margin-top:-8px; margin-left:20px;"><u>NTN : {{$company_detail[0]->state}}</u></h5>
									
									
								</div>
								<h5 style="float:right; margin-top: -155px; margin-left:20px;"><u>ORIGINAL / DUPLICATE</u></h5>
								<!--<h5 style="float:right; margin-top: -155px; margin-left:20px;"><u>Sale Type</u></h5>-->
								<div class="card-content" style=" margin-top: 5px; border:1px solid; border-radius:10px;">
									<h4 style="margin-left:20px;"><u>Buyer Name & Address</u></h4>
									<h4 style="float:right; margin-top: -40px; margin-right: 20px;">Invoice No: <u>{{$newsale_detail[0]->invoice_no}}</u></h4>
									<h4 style="float:right; margin-top: -20px; margin-right: 20px;">Date: <u>{{date("d/m/Y", strtotime($newsale_detail[0]->date))}}</u></h4>
									<h5 style="margin-top:-8px; margin-left:20px;"><strong>Attn : </strong>{{$newsale_detail[0]->parties->party_name}}</br></h5>
									<h5 style="margin-top:-8px; margin-left:20px;"><strong>Address : </strong>{{$newsale_detail[0]->parties->address}}</br></h5>
									<h5 style="margin-top:-8px; margin-left:20px;"><strong>City : </strong>{{$newsale_detail[0]->parties->city}}</br></h5>
									<h5 style="margin-top:-8px; margin-left:20px;"><strong>S.T. Reg. No : </strong>{{$newsale_detail[0]->parties->strn}}</br></h5>
									<h5 style="margin-top:-8px; margin-left:20px;"><strong>NTN : </strong>{{$newsale_detail[0]->parties->ntn}}</br></h5>
									
									<!--<h4 style="margin-top: -15px;"><strong>Reference No : </strong>{{$newsale_detail[0]->reference_no}}</br></h4>--->
								</div></br>
				<div class="panel-body">
					<table class="table table-bordered" style="width:100%;">
						<thead>
							<tr>
								<th>Product&nbsp;Code</th>
								<th>Product&nbsp;Name</th>
								<th>Qty</th>
								<th>Price</th>
								<th>Total</th>
							</tr>
						</thead>
						<tbody>
									<?php $sum = 1; $nettotal = 0; $totaldiscount = 0; $totaltax = 0; $total = 0; $extratax =0; ?>
									@foreach ($newsale_detail[0]->sale_details as $details)
									
										<tr>
											<td>{{$details->products->product_code}}</td>
											<td>{{$details->products->product_name}}</td>
											<td>{{$details->quantity}}</td>
											<td>{{$details->sale_rate}}</td>
											<td>{{$details->sale_amount}}</td>
											
										</tr>
										<?php 
										$nettotal = $nettotal + $details->total_cost;
										$totaltax = $totaltax + $details->taxvalue;
										$extratax = $extratax + $details->extraTaxValue;
										//$totaldiscount = $totaldiscount + $details->discount;
										
										$total = $total + $details->sale_amount;
										
										?>
										<?php $sum = $sum + 1; ?>
									
									@endforeach
									<tr class="gradeX">
											<center><td>-</td></center>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											
					
										</tr>
										<tr class="gradeX">
											<center><td>-</td></center>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr class="gradeX">
											<center><td>-</td></center>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr class="gradeX">
											<center><td>-</td></center>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr class="gradeX">
											<center><td>-</td></center>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr class="gradeX">
											<center><td>-</td></center>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										<tr class="gradeX">
											<center><td>-</td></center>
											<td></td>
											<td></td>
											<td></td>
											<td></td>
										</tr>
										
										<tr class="gradeX">
											<center><td colspan="4" style="padding-left: 500px;">Total Amount</td></center>
											<td><?php echo (int)$total; ?>.00</td>
										</tr>
										<!--<tr class="gradeX">
											<center><td colspan="6" style="padding-left: 450px; border:1px solid;">Total Discount</td></center>
											<td style="border:1px solid;"><?php echo (int)$totaldiscount; ?>.00</td>
										</tr>--->
										<!-- <tr class="gradeX">
											<td colspan="4" style="padding-left: 740px;">Total Tax</td>
											<td><?php echo (int)$totaltax; ?>.00</td>
										</tr>
										<tr class="gradeX">
											<center><td colspan="9" style="padding-left: 740px;">Extra Tax</td></center>
											<td><?php echo (int)$extratax; ?>.00</td>
										</tr> -->
										<!-- <tr class="gradeX">
											<center><td colspan="4" style="padding-left: 500px;">Grand Total</td></center>
											<td><?php echo (int)$nettotal; ?>.00</td>
										</tr> -->
	
					  </tbody>
					</table>
				</div>
			</div> 
		 </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
	</body>
</html>

<b style="float:right; margin-right: 0px;">Developed by <u style="color:blue;">www.itlife.com.pk</u> | 0321 4197290</b>
