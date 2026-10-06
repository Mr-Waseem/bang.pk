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
        	
		@include("/header.pdf")
		<!---<center><span class="user-name"><img src="/upload/logo/{{$company_detail[0]->image}}" style="width: 400px;"></span></center>--->
			<div class="panel panel-default">
				<div class="panel-heading"><b>All Products Information</b></div>
				
				<div class="panel-body">
					<table class="table table-bordered">
						<thead>
							<tr>
								 <th>S.NO.</th>
								  <th>Code</th>
								  <!--<th>Book&nbsp;Title</th>--->
								  <th>Product Title</th>
								  <th>UOM</th>
								  <th>Alert</th>
								  <!-- <th>Author</th>
								  <th>Publisher</th>
								  <th>Year</th>
								  <th>Price</th> -->
							 </tr>
						</thead>
 <tbody>
						  <?php 
						  $count = 1;
						  $total=0;
						  ?>
						  @foreach($products as $product)
						   
							<tr>
								<td><?php echo $count;?></td>
								<td class="center">{{$product->product_code}}</td>
								<td class="center">{{$product->product_name}}</td>
								<td class="center">{{$product->uom}}</td>
								<td class="center">{{$product->alert}}</td>
								<!-- <td class="center">{{$product->product_english}}</td>
								<td class="center">{{$product->author}}</td>
								<td class="center">{{$product->publisher_detail->name}}</td>
								<td class="center">{{date("d/m/Y", strtotime($product->year))}}</td>
								<td class="center">{{$product->product_price}} --></td>
							</tr>
							<?php $count = $count + 1;?>
							 
							@endforeach
						  </tbody>

						</table>
					
				</div>
			</div> 
			<h5 style="float:right;">{{$company_detail[0]->footer_line}}</h5>
		 </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
	</body>
	
</html>

