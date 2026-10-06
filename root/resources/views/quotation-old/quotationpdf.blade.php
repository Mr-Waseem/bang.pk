<html>
	<head>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
			<span>
				<?php
					$t=time(); ($t . "<br>"); echo(date("d-m-y",$t));
				?>
			</span>
	  <div class="content-wrapper">
        <section class="content">
		<center><h3> M.Yousaf Chemicals</h3></center></br>
		<center><b>Opp Ibrahim Masjid 21-K.M Ferozepur Road Lahore</b></center></br>
		<center><b>PH :04235953328</b><center></br>
		<center><h4>Quotation</h4><center></br>

			<div class="panel panel-default">
				<div class="panel-body">
					<table class="table table-bordered" style="border: 2px solid; width: 690px;">
						<thead>
								  <tr>
								  <th>Serial#</th>
								  <th>Product Name</th>
								  <th>Weight</th>
								  <th>Price</th>
								  <th>Origin</th>
								  <th>Sales Tax</th>
							  </tr>
						</thead>
						<tbody>
						  <?php 
						  $count = 1;
						  ?>
						  @foreach($quotations as $quotation)
							<tr>
								<td style="border: 2px solid;"><?php echo $count;?></td>
								<td class="center" style="border: 2px solid;">{{$quotation->product_name}}</td>
								<td class="center" style="border: 2px solid;">{{$quotation->weight}}</td>
								<td class="center" style="border: 2px solid;">{{$quotation->price}}</td>
								<td class="center" style="border: 2px solid;">{{$quotation->origin}}
								</td>
								<td class="center" style="border: 2px solid;">{{$quotation->sales_tax}}
								</td>
							</tr>
							<?php $count = $count + 1;?>
							
							@endforeach
						  </tbody>

						</table>

				</div>
			</div> 
		 </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
	<h5 style="float:right; margin-right:400px;">© 2016 Developed By Sammar 0321-4197290</h5>
</html>

