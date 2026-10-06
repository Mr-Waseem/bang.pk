@extends("app")
@section("contents")
	<!-- start: Content -->
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="index.html">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="/ledger">Ledger</a></li>
				<a href="/getPDF" class="btn btn-default" id="print" role="button">PDF download</a>
				<h3><span class="label label-default" id="create"><span ><a href="/quotation/create" id="link"> <center style=" margin-top: 6px;">Add Entry</center></a></span></h3>
			</ul>
			<div class="container-fluid">
				@if (Session::has('flash_message'))
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="margin-right: 20px;margin-top: 15px;">&times;</button>
					<div class="alert alert-success"> {{ Session::get('flash_message') }} </div>
				@endif
			</div>
			
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>M.Yousaf Chemicals</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>Serial#</th>
								  <th>Product Name</th>
								  <th>Weight</th>
								  <th>Price</th>
								  <th>Origin</th>
								  <th>Sales Tax</th>
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						  <?php 
						  $count = 1;
						  ?>
						  @foreach($quotations as $quotation)
							<tr>
								<td><?php echo $count;?></td>
								<td class="center">{{$quotation->product_name}}</td>
								<td class="center">{{$quotation->weight}}</td>
								<td class="center">{{$quotation->price}}</td>
								<td class="center">
									<span class="label label-default">{{$quotation->origin}}</span>
								</td>
								<td class="center">
									<span class="label label-warning">{{$quotation->sales_tax}}</span>
								</td>
								<td class="center">
									<a class="btn btn-info" href="/quotation/{{$quotation->id}}/edit">
										<i class="halflings-icon white edit"></i>  
									</a>
									<a class="btn btn-danger" href="javascript:checkDelete({{ $quotation->id }}, '/quotation/{{ $quotation->id }}/destroy', '/quotation');">
										<i class="halflings-icon white trash"></i> 
									</a>
								</td>
							</tr>
							<?php $count = $count + 1;?>
							
							@endforeach
						  </tbody>
					  </table>            
					</div>
				</div><!--/span-->
			
@stop
