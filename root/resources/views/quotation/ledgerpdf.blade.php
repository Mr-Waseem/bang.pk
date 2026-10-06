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
		<center><h4>{{$party[0]->party_name}}</h4><center></br>

			<div class="panel panel-default">
				<div class="panel-body">
					<table class="table table-bordered" style="border: 2px solid; width: 675px;">
						<thead>
								  <tr>
								  <th>Serial#</th>
								  <th>Date</th>
								  <th>Particulars</th>
								  <th>Bill No</th>
								  <th>Debit</th>
								  <th>Credit</th>
								  <th>Balance</th>
							  </tr>
						</thead>
						  <tbody>
						  <?php 
						  $count = 1;
						  $total=0;
						  ?>
						  @foreach($ledgers as $ledger)
						   
							<tr>
								<td><?php echo $count;?></td>
								<td class="center">{{date("d-m-y", strtotime($ledger->date))}}</td>
								<td class="center">{{$ledger->particulars}}</td>
								<td class="center">{{$ledger->bill_no}}</td>
								<td class="center">{{$ledger->debit}}
								</td>
								<td class="center">{{$ledger->credit}}
								</td>
								<td class="center">{{ $total = $total + $ledger->credit - $ledger->debit }}
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
	<h5><span style="float:right; margin-right:100px;">© 2016 Developed By Sammar 0321-4197290</span></h5>
</html>

