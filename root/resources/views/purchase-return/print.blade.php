@include("/include.config")
<?php	
	$que="select * from system_logos";
	$run=@mysqli_query($que);
	$row=@mysqli_fetch_array($run);
	$image = $row['image'];
?>
<head>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

	</head>

<body onload="window.print();">					
	<div class="row">
		<div class="col-sm-12">
			<div class="col-sm-5">
				<div class="card-header">
					<div class="card-short-description">
						<center><span class="user-name"><img src="/upload/logo/{{$logo[0]->image}}" style="float: left; margin-left: 20px;"></span></center>
					</div>
				</div>
			</div>
			<div class="col-sm-2">
				<div class="card-content">
				</br></br>
				<!-- <h4><strong><u style="margin-left: 20px;float: left;">{{"cases"}}</u></strong></h4> -->
					
					
				</div>
			</div>
			<center><h4 style="margin-top: -40px; margin-right: -130px;"><strong>Purchase Return Invoice</strong></h4></center>
			<div class="col-sm-5">
				</br></br>
				<div class="col-sm-3" style="float:right; margin-right:20%; margin-top: -50;">
						<!--<h5><strong>Customer Details</strong></h5>--->
					<b><strong>Name</strong></b>&nbsp;:&nbsp;{{$purchase_detail->parties->party_name}}
					<h6><strong>City : </strong>{{$purchase_detail->parties->city}}</br></h6>
					<h6><strong>Tel&nbsp;:&nbsp;</strong>{{$purchase_detail->parties->phone}}</h6>
				</div>
				<div class="col-sm-2" style="float:right; margin-right:-40%; margin-top: -50px;">
					<!--<h5><strong>Customer Details</strong></h5>--->
					<h6><strong>Date&nbsp;:&nbsp;</strong>{{date("d/m/Y", strtotime($purchase_detail->date))}}</h6>
					<h6><strong>Reference&nbsp;No&nbsp;:&nbsp;</strong>{{$purchase_detail->reference_no}}</br></h6>
					<h6><strong>Invoice&nbspNo&nbsp:&nbsp</strong>{{$purchase_detail->id}}</br></h6>
					
				</div>
			</div>
		</div>
	</div>
	<div class="panel-body">
			<table class="table table-bordered">
				<thead>
					<th>No</th>
					<th>code</th>
					<th>Product</th>
					<!-- <th>Tax%</th> -->
					<!-- <th>Book English</th> -->
					<th>Qty</th>
					<th>Purchase Price</th>
					<!--<th style="border: 1px solid;">Tax</th>--->
					<th>Total</th>
				</thead>
													<tbody>
			<?php $sum = 1; $nettotal = 0; $totaltax = 0; $totalcost = 0; ?>
			@foreach ($purchase_detail->purchase_return_detail as $details)
			
				<tr class="gradeX">
					<td><?php echo $sum; ?></td>
					<td>{{$details->products->product_code}}</td>
					<td>{{$details->products->product_name }}</td>
					
					
					<td>{{$details->quantity}} {{$details->unit->uom}}</td>
					<td>{{$details->unit_cost}}</td>
					
					<td>{{$details->unit_cost * $details->quantity}}</td>
				</tr>
				<?php 
				$nettotal = $nettotal + $details->unit_cost * $details->quantity;
				$totalcost = $totalcost + $details->total_cost;
				
				?>
				<?php $sum = $sum + 1; ?>
			
			@endforeach
				<tr class="gradeX">
					<center><td colspan="5">Total</td></center>
					<td><?php echo (int)$nettotal; ?></td>
				</tr>
				<tr class="gradeX" style="display:none;">
					<center><td colspan="5">Total Tax</td></center>
					<td><?php echo (int)$totaltax; ?></td>
				</tr>
				<tr class="gradeX">
					<center><td colspan="5">Total Amount</td></center>
					<td><?php echo (int)$totalcost; ?></td>
				</tr>
			</tbody>
			 
			</table>
		</div>
</br>
<b style="float:right; margin-right: 0px;">Developed by <u style="color:blue;">www.itlife.com.pk</u> | 0321 4197290</b>
</body>	