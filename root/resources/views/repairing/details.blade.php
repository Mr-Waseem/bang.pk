@extends("app")
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
@section("contents")
		<div class="row">
			<div class="col-md-12">
				<a href="/repairing/print/{{$newsale_detail[0]->id}}" class="btn btn-warning" role="button" style="float:right;"><i class="fa fa-print"></i><span class="bold">Print</span></a>
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
									<h5><strong>Address : </strong>{{$company_detail[0]->address}}</br></h4>
									<h5><strong>Phone : </strong>{{$company_detail[0]->phone}}</h5>
									<h5><strong>Email : </strong>{{$company_detail[0]->email}}</br></h5>
									<h4><strong>Date : </strong>{{$newsale_detail[0]->date}}</br></h4>
									<h4><strong>Invoice No : </strong>{{$newsale_detail[0]->id}}</br></h4>
									
								</div>
								
								<div class="card-content" style="float: right; margin-top: -210px; margin-right: 100px;">
									<h3><strong>Customer Name</strong></h3>
									<h5><strong>Attn : </strong>{{$newsale_detail[0]->parties->party_name}}</br></h5>
									<h5><strong>Tel : </strong>{{$newsale_detail[0]->parties->phone}}</br></h5>
									<h5><strong>City : </strong>{{$newsale_detail[0]->parties->city}}</br></h5>
									<h4><strong>Reference No : </strong>{{$newsale_detail[0]->reference_no}}</br></h4>
								</div>
								<!-- /card content -->
							<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover dataTables-example" >
									<thead>
										<tr>
											<th>No</th>
											<th>Description</th>
											<th>Quantity</th>
											<th>Charges</th>
										</tr>
									</thead>
									<tbody>
									<?php $sum = 1; $nettotal = 0; $totaldiscount = 0; $totaltax = 0; $total = 0; ?>
									@foreach ($newsale_detail[0]->repairing_details as $details)
									
										<tr class="gradeX">
											<td><?php echo $sum; ?></td>
											<td>{{$details->products->product_name}} ({{$details->products->product_code}})</td>
											<td>{{$details->quantity}}</td>
											<td>{{$details->charges}}</td>
										</tr>
										<?php 
										$nettotal = $nettotal + $details->charges;
			
										
										?>
										<?php $sum = $sum + 1; ?>
									
									@endforeach
										<tr class="gradeX">
											<center><td colspan="3" style="padding-left: 800px;">Total</td></center>
											<td><?php echo $nettotal; ?></td>
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
