<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="content-wrapper">
    <section class="content">
	@include("/header.report")		
	<div class="panel panel-default">
	<div class="panel-heading"><b>All Products Stock</b></div>
	<div class="panel-body">
	<table class="table table-striped table-bordered table-hover dataTables-example" >
		<thead>
			<tr>
				<th>Serial#</th>
				<th>Product&nbsp;Code</th>
				<th>Product&nbsp;Name</th>
				<th>Product&nbsp;Cost</th>
				<th>Stock&nbsp;Cost</th>
				<th>C.Stock</th>  
			</tr>
		</thead>
		<tbody>
			  <?php $sum = 1; $count=1;?>
			   
			 	 <tr style="background: #a0c6ff;">
					<td colspan="6" style="color:green;"><b>WAREHOUSE NAME: {{$warehouse[0]->name}}</b> <span style="color:blue;"></span><!---&nbsp;&nbsp;&nbsp;&nbsp;<b style="color:green;">TOTAL :</b> <span style="color:blue;">{{$count}}</span></td> -->

				</tr>
			  @foreach($product as $items)	
			 		 
				<tr>
					<td><?php echo $count; ?></td>
					<td class="center">{{$items->product_code}}</td>
					<td class="center">{{$items->product_name}}</td>
					<td class="center">{{$items->cost}}</td>
					<td class="center">{{$items->total_cost}}</td>
					<td class="center">{{$items->stock}}</td>
					
				</tr>
				
			
				
				<?php $count = $count+1;?>
			  @endforeach
			 


			  
			  </tbody>
				<tfoot>
					<tr>
					  <th>Serial#</th>
					  <th>Product&nbsp;Code</th>
					  <th>Product&nbsp;Name</th>
					  <th>Product&nbsp;Cost</th>
					  <th>Stock&nbsp;Cost</th>
					 <th>C.Stock</th>  
					</tr>
				</tfoot>
		</table>
		</div>
	</div>
	</section>
	</div>
</body>
</html>


