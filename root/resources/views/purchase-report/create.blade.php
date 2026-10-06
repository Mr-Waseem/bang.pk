@extends("app")
@section("contents")
<h1 class="page-title">Purchase Report</h1>
			<!-- Breadcrumb -->
			<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
				<li class="active"><strong>Purchase Report</strong></li> 
			</ol>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">Select Date</h3>
							<!-- <ul class="panel-tool-options"> 
								<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
								<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
								<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
							</ul> -->
						</div>
						<div class="panel-body">
						<input id="token" type="hidden" value="{{$encrypted_token}}">
							@include('errors.validation')
							{!! Form::open(['url' => 'purchase-report', 'class' => 'form-horizontal' ]) !!}
								<div class="form-group"> 
									<label class="col-sm-3 control-label">From</label>  
									<div class="col-sm-5"> 
									<!-- {!! Form::date('from_date', null, ['id' => 'from_date','class'=>'form-control',]) !!} -->
									<input type="date" name="from_date" id="from_date" value="<?php echo date("Y-m-d");?>" class="form-control">
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">To</label>  
									<div class="col-sm-5"> 
									<!-- {!! Form::date('to_date', null, ['id' => 'to_date','class'=>'form-control',]) !!} -->
									<input type="date" name="to_date" id="to_date" value="<?php echo date("Y-m-d");?>" class="form-control">
									</div> 
								</div>
								<div class="line-dashed"></div>
								<center><div class="form-actions">
							  <button type="submit" name="btnSave" id="btnSave" target="_blank" class="btn btn-primary">Find</button>
							</div></center>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
			<div class="row" style="display: none">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">Purchase Report</h3>
							<!-- <ul class="panel-tool-options"> 
								<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
								<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
								<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
							</ul> -->
						</div>
						<div class="panel panel-default">
						<div class="panel-body">
							<div class="table-responsive">
							<!--<a href="/purchase-report/print" class="btn btn-warning" role="button" style="float:right;">
							<i class="fa fa-print"></i><span class="bold">Print</span></a>-->
								<table class="table table-striped table-bordered table-hover dataTables-example" >
									<thead>
										<tr>	
											  <th>Date</th>
											  <th>Supplier</th>
											  <th>Product&nbsp;Name</th>
											  <th>Purchase&nbsp;Price</th>
											  <!--<th>Sale&nbsp;Price</th>-->
											  <th>Quantity</th>
											  <th>Total&nbsp;Purchase</th>
										</tr>
									</thead>
									 <tbody>
									 <?php $pprice = 0; $sprice = 0; $quantity = 0; $total = 0; ?>
									 @if(isset($purchases))
										 @if(count($purchases) > 0)
											@foreach($purchases as $purchase)
												<!--<tr><td colspan="5">Purchase Date: {{ $purchase->date }}</td></tr>
												<tr><td colspan="5">Supplier: </td></tr>-->												
												<tr>
													@foreach($purchase->purchase_details as $products)
													<td>{{ date("d-m-Y", strtotime($purchase->date)) }}</td>
													<td>{{ $products->party->party_name }}</td>
													<td>@if($products->products!=null)
													    {{ $products->products->product_name }} ({{ $products->products->product_code }})
													    @endif
													</td>
													<td>{{ $products->unit_cost }}</td>
													<!--<td>{{ $products->product_price }}</td>-->
													<td>{{ $products->quantity }}</td>
													<td>{{ $products->total_cost }}</td>
													<?php
													$pprice = $pprice + $products->unit_cost;
												
													$quantity = $quantity + $products->quantity;
													$total = $total + $products->total_cost;
													?>
													</tr>
													@endforeach
													
											@endforeach
											<tr>
											<td colspan="3"><center><b>Total</b></center></td>
											<td>{{$pprice}}</td>
										
											<td>{{$quantity}}</td>
											<td>{{$total}}</td>
											</tr>
										 @endif	
										 @else
											<tr><td colspan="7" style="color:#FF0000;text-align:center;">No purchases found</td></tr>
										 @endif
									 </tbody>
								</table>
							</div>
						</div>
						</div>
					</div>
				</div>
			</div>
@stop

