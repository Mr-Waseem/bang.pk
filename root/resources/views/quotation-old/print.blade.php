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
		<center><b> M.Yousaf Chemicals</b></center>
			<span style="float: right;margin-top: -19px;">
				<?php
					$t=time(); ($t . "<br>"); echo(date("d-m-y",$t));
				?>
			</span>
			<div class="panel panel-default">
				<div class="panel-heading"><b>{{$party[0]->party_name}}</b></div>
				<div class="panel-body">
					<table class="table table-bordered">
						<thead>
							<tr>
								 <th>Serial#</th>
								  <th>Date</th>
								  <th>Particulars</th>
								  <th>Debit</th>
								  <th>Credit</th>
								  <th>Total</th>
							 </tr>
						</thead>
 <tbody>
						  <?php 
						  $count = 1;
						  ?>
						  {{ $total=0 }}
						  @foreach($ledgers as $ledger)
						   {{$total = $total + $ledger->credit - $ledger->debit}}
							<tr>
								<td><?php echo $count;?></td>
								<td class="center">{{date("d-m-y", strtotime($ledger->date))}}</td>
								<td class="center">{{$ledger->particulars}}</td>
								<td class="center">
									<span class="label label-warning">{{$ledger->debit}}</span>
								</td>
								<td class="center">
									<span class="label label-success">{{$ledger->credit}}</span>
								</td>
								<td class="center">
									<span class="label label-success">{{ $total}}</span>
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
	</body>
	<h5 style="float:right;">© 2016 Developed By Sammar 0321-4197290</h5>
</html>

