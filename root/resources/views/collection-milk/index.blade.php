@extends("app")
@section("contents")
<!-- <h1 class="page-title">Find Sale Bill</h1>
		
			<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
				<li class="active"><strong>Find Sale Bill</strong></li> 
			</ol> -->
			<div class="container-fluid">
	@if (Session::has('flash_message'))
		 <div class="alert alert-success alert-dismissible fade in">
 			<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right: 4%;">&times;</a>
 			<strong>Success!</strong> {{ Session::get('flash_message') }}
  		</div>
	@endif
</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">Find Collection Milk</h3>
							<!-- <ul class="panel-tool-options"> 
								<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
								<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
								<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
							</ul> -->
						</div>
						<div class="panel-body">
						
							@include('errors.validation')
							{!! Form::open(['url' => 'collection-milk/find', 'class' => 'form-horizontal' ]) !!}
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Bill No</label>  
									<div class="col-sm-5"> 
									<!-- {!! Form::date('from_date', null, ['id' => 'from_date','class'=>'form-control',]) !!} -->
									<input type="text" name="search" id="search" placeholder="Search By Bill No, Date & Volume" class="form-control">
									</div>
								</div>

								<div class="line-dashed"></div>
								<center><div class="form-actions">
							  <button type="submit" target="_blank" class="btn btn-primary">Find</button>
							</div></center>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">Collection Milk</h3>
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
											  <th>Sr#</th>
							 <th>Date</th>
							  <th>Bill&nbsp;No</th>
							  <!-- <th>Biller</th> -->
							  <!-- <th>Sale&nbsp;Type</th> -->
							  <th>Supplier&nbsp;Name</th>
							  <th>Volume</th>
							  <th>Fat</th>
							  <th>Lr</th>
							  <th>Rate</th>
							  <th>Created&nbsp;By</th>
							  <!-- <th>Print</th> -->
							  <th>Actions</th>
										</tr>
									</thead>
									 <tbody>
									 <?php $sum = 0; ?>
									 @if(isset($sales))
										 @if(count($sales) > 0)
			  @foreach($sales as $sale)
			  @if($sale->invoice_no!="0")
			  <?php $sum = $sum + 1; ?>
				<tr><td class="center">{{$sum}}</td>
					<td class="center">{{date("m/d/Y", strtotime($sale->date))}}</td>
					<td class="center">{{$sale->bill_no}}</td>
					<?php $total = 0; $CoutAmount = 0; $SaleAmount = 0; $discount = 0;?>
					<td class="center">
						@if(($sale->supplier)!=null)
							{{$sale->supplier->party_name}}
						@endif
					</td>
					<td class="center">{{number_format($sale->volume, 2)}}</td>
					<td class="center">{{number_format($sale->fat, 2)}}</td>
					<td class="center">{{number_format($sale->lr, 2)}}</td>
					<td class="center">{{number_format($sale->rate, 2)}}</td>
					<td class="center">{{$sale->billers->name}}</td>
					
				
					
					
					<!-- <td class="size-80 text-center">
						<div class="row">
							<a href="/sales/print/{{$sale->id}}" target="__blank" style="color:white;">
							<button class="btn btn-info" type="button"> <i class="icon-print" title="Print Invoice"></i></button></a>
							<a href="{{asset('/sales/salespdf')}}/{{$sale->id}}" style="color:white;">
							<button class="btn btn-danger" type="button"> <i class="fa fa-file-pdf-o" title="Print PDF"></i></button></a>
							
						</div>
					</td> -->
					<td class="size-100 text-center">
						<div class="row">
							<a href="/collection-milk/{{$sale->id}}/edit" style="color:white;">
							<button class="btn btn-black" type="button"> <i class="fa fa-paste" title="Edit Invoice"></i></button></a>
							<a href="javascript:checkDelete({{ $sale->id }}, '/collection-milk/{{ $sale->id }}/destroy', '/collection-milk');">
							<button class="btn btn-red" type="button"> <i class="icon-trash" title="Delete Invoice"></i></button></a>
						</div>
					</td>
				</tr>
			  @endif
			  @endforeach
			  @else
				<tr><td colspan="9" style="color:#FF0000;text-align:center;">No Records Found</td></tr>
			  @endif
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

