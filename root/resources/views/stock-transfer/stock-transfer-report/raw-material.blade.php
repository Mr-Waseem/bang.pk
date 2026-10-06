<html>
<head>
  <link href="/css/bg.css" rel="stylesheet">
</head>
<!-- <body onload="window.print();"> -->
<body>
	<button onclick="goBack()" autofocus>Go Back</button>
	<div>
	<section class="content">
	@include("/header.report")
	<!-- <center id="systemDetail" >FROM:</center>	 -->
	<div style="border:2px solid;">
		<div><b id="voucherName">WAREHOUSE STOCK REPORT (RAW MATERIAL)</b></div>
	<div class="panel-body" style="border-top:2px solid;">
	<!-- <table class="table table-striped table-bordered table-hover dataTables-example" > -->
	<table style="width:100%;">
		<thead>
			<tr >	
			  <th style="width:10%; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">SR#</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Product&nbsp;Code</th>
			  <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Product&nbsp;Name</th>
			  <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;">C.Stock</th>
			</tr>
		</thead>
		 <tbody>
		 <?php $sum = 1; $totalCredit = 0;?>
			 @if(count($RawMaterial) > 0)
				@foreach($RawMaterial as $items)
					<tr id="datafont">
						<td id="tabledata">{{$sum}}</td>
						<td id="tabledata">{{$items->product_code}}</td>
						<td id="tabledata">{{$items->product_name}}</td>

						<td id="tabledata">{{$items->stockin-$items->stockout}}</td>
					</tr>
					@php $sum = $sum + 1; @endphp
					@endforeach
						
				
				
			 @else
				<tr><td colspan="7" style="color:#FF0000;text-align:center;">No Records found</td></tr>
			 @endif
		 </tbody>
	</table>
	</div>
	</div>
</section>
	</div>

	

</body>
</html>
<script>
function goBack() {
  window.history.back()
}
</script>

