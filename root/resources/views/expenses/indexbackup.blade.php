@extends("app")
@section("contents")
	<!-- start: Content -->
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="/dashboard">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="/products/">Product</a></li>
				<a href="/products/getPDF/" class="btn btn-default" id="pdf" role="button">PDF Download</a>
				<a href="/products/print/" class="btn btn-default" id="print" role="button">Print</a>
				<h3><span class="label label-default" id="create"><span ><a href="/products/create" id="link"> <center style=" margin-top: 6px;">Add Product</center></a></span></h3>
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
						<h2><i class="halflings-icon user"></i><span class="break"></span>Products List</h2>
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
								  <th>Product Code</th>
								  <th>Product Name</th>
								  <th>Product Cost</th>
								  <th>Product Price</th>
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						  <?php 
						  $count = 1;
						  ?>
						  {{ $total=0 }}
						  @foreach($products as $product)
						   
							<tr>
								<td><?php echo $count;?></td>
								<td class="center">{{$product->product_code}}</td>
								<td class="center">{{$product->product_name}}</td>
								<td class="center">{{$product->product_cost}}</td>
								<td class="center">{{$product->product_price}}
								</td>
								<td class="center">
									<a class="btn btn-info" href="/products/{{$product->id}}/edit">
										<i class="halflings-icon white edit"></i>  
									</a>
									<a class="btn btn-danger" href="javascript:checkDelete({{ $product->id }}, '/products/{{ $product->id }}/destroy', '/products');">
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
