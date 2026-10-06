@include("/include.config")
<?php	
	$que="select * from system_logos";
	$run=@mysql_query($que);

	$row=@mysql_fetch_array($run);
	$image = $row['image'];
?>
@extends("app")
@section("contents")
		<div class="row">
			<div class="col-md-12">
			<a href="/purchases/print/{{$purchase_detail->id}}" class="btn btn-warning" role="button" style="float:right;"><i class="fa fa-print"></i><span class="bold">Print</span></a>
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
									<h4><strong>Name : </strong>{{$purchase_detail->suppliers->name}}</br></h4>
									<h5><strong>City : </strong>{{$purchase_detail->suppliers->city}}</h5>
									<h5><strong>Phone : </strong>{{$purchase_detail->suppliers->phone}}</h5>
									
								</div>
								
								<div style="float: right; margin-top: -95px; margin-right: 350px;">
									
									<!--<button style="float:right; margin-right: -220px;" type="button" class="btn btn-warning"><i class="fa fa-print"></i> <span class="bold"><a href="/purchases/print/{{$purchase_detail->id}}">Print</a></span></button>--->
									<h3><strong>Invoice No : </strong>{{$purchase_detail->id}}</br></h3>
									<h5><strong>Date : </strong>{{$purchase_detail->date}}</br></h5>
									<h4><strong>Reference No : </strong>{{$purchase_detail->reference_no}}</br></h4>
								</div>
								<!-- /card content -->
							<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover dataTables-example" >
									<thead>
										<tr>
											<th>No</th>
											<th>Product</th>
											<th>Quantity</th>
											<th>Purchase Price</th>
											<!--<th>Tax</th>-->
											<th>Sub Total</th>
										</tr>
									</thead>
									<tbody>
									<?php $sum = 1; $nettotal = 0; $totaltax = 0; $totalcost = 0; ?>
									@foreach ($purchase_detail->purchase_details as $details)
									
										<tr class="gradeX">
											<td><?php echo $sum; ?></td>
											<td>{{$details->products->product_name }}  {{$details->products->product_code}}</td>
											<td>{{$details->quantity}}</td>
											<td>{{$details->unit_cost}}</td>
											<!--<td>{{$details->purchase_tax->tax_rate/100 * $details->unit_cost * $details->quantity}}</td>--->
											<td>{{$details->unit_cost * $details->quantity}}</td>
										</tr>
										<?php 
										$nettotal = $nettotal + $details->unit_cost * $details->quantity;
										$totalcost = $totalcost + $details->total_cost;
										//$totaltax = $totaltax + $details->purchase_tax->tax_rate/100 * $details->unit_cost * $details->quantity;
										?>
										<?php $sum = $sum + 1; ?>
									
									@endforeach
										<tr class="gradeX">
											<center><td colspan="4" style="padding-left: 800px;">Total</td></center>
											<td><?php echo $nettotal; ?></td>
										</tr>
										<!--<tr class="gradeX">
											<center><td colspan="5" style="padding-left: 755px;">Products Tax</td></center>
											<td><?php echo $totaltax; ?></td>
										</tr>--->
										<tr class="gradeX">
											<center><td colspan="4" style="padding-left: 745px;">Total Amount</td></center>
											<td><?php echo $totalcost; ?></td>
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
		</div>	
		

@stop
