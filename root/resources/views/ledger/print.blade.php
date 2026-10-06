
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
</head>
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
								<span style="float: right;margin-top: -19px;">
									<?php $t=time(); ($t . "<br>"); echo(date("d-m-Y",$t)); ?>
								</span>
								<!-- Card content -->
								<div class="card-content">
									<h3><strong>{{$company_detail[0]->system_name}}</strong></br></h3>
									<h5><strong>Address : </strong>{{$company_detail[0]->address}}</br></h4>
									<h5><strong>Email : </strong>{{$company_detail[0]->email}}</h5>
									<h5><strong>Phone : </strong>{{$company_detail[0]->phone}}</h5>
									
								</div>
								
								<div class="card-content" style="float: right; margin-top: -120px; margin-right: 100px;">
									<h3><strong>Ledger</strong></h3>
									<h5><strong>Customer : </strong>{{$party[0]->party_name}}</br></h5>
									<h5><strong>Tel : </strong>{{$party[0]->phone}}</br></h5>
									<h5><strong>City : </strong>{{$party[0]->city}}</br></h5>
								</div>
								<!-- /card content -->
					
							<div class="panel-body">
					<table class="table table-bordered">
						<thead>
							<tr>
								 <th>Serial</th>
								 <th>Invoice&nbsp;No</th>
								 <th>Due&nbsp;Date</th>
								  <th>Particulars</th>
								  <th>Check&nbsp;No</th>
								  <th>Debit</th>
								  <th>Credit</th>
								  <th>Total</th>
							</tr>
						</thead>
						<tbody>
						  <?php 
						  $count = 1;
						  $total=0;
						  ?>
						  
						  @if(count($ledgers) > 0)
						  
						  @foreach($ledgers as $ledger)
							<tr class="gradeX">
								<td><?php echo $count;?></td>
								<td>{{$ledger->invoice_no}}</td>
								<td>{{date("d-m-Y", strtotime($ledger->date))}}</td>
								<td>{{$ledger->particulars}}</td>
								<td>{{$ledger->bill_no}}</td>
								<td>{{$ledger->debit}}
								</td>
								<td>{{$ledger->credit}}
								</td>
								<td>{{ $total = $total + $ledger->credit - $ledger->debit }}
								</td>
							</tr>
							<?php $count = $count + 1;?>
							@endforeach
							<tr>
								<td colspan="7">Total Balance</td>
								<td>{{$total}}</td>
							</tr>
							@else
							<tr>
								<td colspan="7" class="text-center" style="color:#FF0000;">No Records found.</td>
							</tr>						
							@endif
						  </tbody>
					  <!-- <thead>
							<tr>
								<th>Serial</th>
								 <th>Date</th>
								  <th>Particulars</th>
								  <th>Bill No</th>
								  <th>Debit</th>
								  <th>Credit</th>
								  <th>Total</th>
							</tr>
						</thead> -->
					</table>
				</div>
							</div>
							<!-- /card -->	
						</div>
					</div>
				</div>
				<!-- /card grid view -->
			</div>
		</div>	
</body>
