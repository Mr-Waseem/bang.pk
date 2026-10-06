@extends("app")
@section("head")
@include("/include.config")
<?php	
	$que="select * from system_logos";
	$run=@mysql_query($que);

	$row=@mysql_fetch_array($run);
	$image = $row['image'];
?>
@stop
@section("contents")
		<div class="row">
			<div class="col-md-12">
				
				<a href="/ledger/suppliers/print/{{$id}}" class="btn btn-warning" role="button" style="float:right;">

				<i class="fa fa-print"></i><span class="bold">Print</span></a>
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
								<div class="card-content">
									<h3><strong>{{$company_detail[0]->system_name}}</strong></br></h3>
									<h5><strong>Address : </strong>{{$company_detail[0]->address}}</br></h4>
									<h5><strong>Email : </strong>{{$company_detail[0]->email}}</h5>
									<h5><strong>Phone : </strong>{{$company_detail[0]->phone}}</h5>
									
								</div>
								<div class="card-content" style="float: right; margin-top: -135px; margin-right: 100px;">
									<h3><strong>Ledger</strong></h3>
									<h5><strong>Supplier : </strong>{{$party[0]->name}}</br></h5>
									<h5><strong>Tel : </strong>{{$party[0]->phone}}</br></h5>
									<h5><strong>City : </strong>{{$party[0]->city}}</br></h5>
								</div>
								<!-- /card content -->
							<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover dataTables-example" >
						  <thead>
							  <tr>
								  <th>Serial#</th>
								  <th>Date</th>
								  <th>Particulars</th>
								  <th>Bill No</th>
								  <th>Debit</th>
								  <th>Credit</th>
								  <th>Total</th>
								  <!--<th>Actions</th>--->
							  </tr>
						  </thead>   
						  <tbody>
						  <?php 
						  $count = 1;
						  $total = 0;
						  ?>				  
							  @if(count($ledgers) > 0)
							  @foreach($ledgers as $ledger)
								<tr>
									<td><?php echo $count;?></td>
									<td class="center">{{date("d-m-Y", strtotime($ledger->date))}}</td>
									<td class="center">{{$ledger->particulars}}</td>
									<td class="center">{{$ledger->bill_no}}</td>
									<td class="center">
										<span class="label label-warning">{{$ledger->debit}}</span>
									</td>
									<td class="center">
										<span class="label label-primary">{{$ledger->credit}}</span>
									</td>
									<td class="center">
										<span class="label label-success">{{ $total = $total + $ledger->credit - $ledger->debit }}</span>
									</td>
									<!--<td class="size-80 text-center">
										<div class="dropdown">
											<a class="more-link" data-toggle="dropdown" href="#/"><i class="icon-dot-3 ellipsis-icon"></i></a>
											<ul class="dropdown-menu dropdown-menu-right">
												<li><a href="/ledger/{{$ledger->id}}/edit">Edit</a></li>
												<li><a href="javascript:checkDelete({{ $ledger->id }}, '/ledger/{{ $ledger->id }}/destroy', '/ledger');">Delete</a> </li>
											</ul>
										</div>
									</td>-->
								</tr>
								<?php $count = $count + 1;?>
								@endforeach
								<tr>
									<td colspan="6">Total Balance</td>
									<td>{{$total}}</td>
								</tr>
								@else
								<tr>
									<td colspan="7" class="text-center" style="color:#FF0000;">No Records found.</td>
								</tr>						
								@endif
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
