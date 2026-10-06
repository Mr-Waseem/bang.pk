@include("/include.config")

@extends("app")
@section("head")
<link href="/css/plugins/datatables/jquery.dataTables.css" rel="stylesheet">
<link href="/js/plugins/datatables/extensions/Buttons/css/buttons.dataTables.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
@stop
@section("contents")
<div class="container-fluid">
	@if (Session::has('flash_message'))
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="margin-right: 20px;margin-top: 15px;">&times;</button>
		<div class="alert alert-success"> {{ Session::get('flash_message') }} </div>
	@endif
</div>
<div class="page-heading clearfix">
	<h1 class="page-title pull-left">Customer Rates</h1><a href="product-rates/create" class="btn btn-primary btn-sm btn-add" role="button">Create Rate</a>
</div>
<!--
<div class="btn-group" style="float: right; margin-top: -32px;">
	<a href="parties/create" class="btn btn-primary btn-sm btn-add" role="button">Excel</a>
	<a href="parties/create" class="btn btn-primary btn-sm btn-add" role="button">PDF</a>
	<a href="parties/create" class="btn btn-primary btn-sm btn-add" role="button">Print</a>
</div>
--->
<!-- Breadcrumb -->
<ol class="breadcrumb breadcrumb-2"> 
	<li><a href="
	/dashboard"><i class="fa fa-home"></i>Home</a></li> 
	<!-- <li><a href="/sales">Sales</a></li>  -->
	<li class="active"><strong>All Customer Rates</strong></li> 
</ol>
<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
	<div class="panel-heading clearfix">
		<h3 class="panel-title">Manage Customer Rates</h3>

	</div>
	<div class="panel-body">
		<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover dataTables-example" >
		<thead>
		<tr>
			<th>Sr#</th>
			<th>Date</th>
			<th>Voucher#</th>
			<th>Customer Code</th>
			<th>Customer Name</th>
			<th>Milk Price</th>
			
			
			<th>Biller</th>
			<th>Actions</th>
		</tr>
		</thead>
		 <tbody>
		<?php $sum = 0; ?>
	 	@foreach($sales as $sale)
	 	@if($sale->vr_no!= "0")
	    <?php $sum = $sum + 1; ?>
		<tr><td class="center">{{$sum}}</td>
			<td class="center">{{date("d/m/Y", strtotime($sale->date))}}</td>
			<td class="center">{{$sale->vr_no}}</td>

			<?php $total = 0; $discount = 0; $tax = 0; $extratax = 0; 
			$grandtotal = 0; ?>
			@foreach($sale->rate_details as $details)
				<?php 
					$total = $total + (int)$details->rate * (int)$details->quantity;
					  $tax = $tax + (int)$details->taxvalue;
					  $extratax = $extratax + (int)$details->extraTaxValue;
					  $grandtotal = $grandtotal + (int)$details->total;
				?>
				
			@endforeach
			<td class="center">
				@if($sale->party!=null)
				{{$sale->party->code}}
				@endif
			</td>
			<td class="center">
				@if($sale->party!=null)
				{{$sale->party->party_name}}
				@endif
			</td>
			<td class="center" contenteditable="true" 
			onkeyup="MilkPrice($(this).text(), {{$sale->id}});">
				
				@if(Count($sale->rate_details) > 0)
			    {{$sale->rate_details[0]->rate}}
			    @endif
			</td>
			
			<td class="center">{{$sale->billers->name}}</td>

			<td>
				<a href="/product-rates/{{$sale->id}}" target="__blank"
				 style="color:white;">
				<button class="btn btn-info" type="button"> <i class="icon-print" title="Print Invoice"></i></button></a>
				<!-- <a href="{{asset('/production/salestaxpdf')}}/{{$sale->id}}" style="color:white;"><button class="btn btn-danger" type="button"> <i class="fa fa-file-pdf-o" title="Print PDF"></i></button></a> -->
				
				<!-- <button class="openModel btn btn-black" id="editmodals" data-toggle="modal" 
					data-id="{{$sale->id}}"  
					data-vr_no="{{$sale->vr_no}}"  
					data-date="{{$sale->date}}"  
					data-products_id="{{$sale->products_id}}"  
					data-uoms_id="{{$sale->uoms_id}}"  
					data-quantitys="{{$sale->quantitys}}"  
					data-rates="{{$sale->rates}}"  
					data-amounts="{{$sale->amounts}}"  
				  	data-target="#myModal" onclick="EditClicks({{$sale->id}})" type="button"> <i class="fa fa-edit" title="Edit Record"></i></button> -->

					<a href="javascript:checkDelete({{ $sale->id }}, '/product-rates/{{ $sale->id }}/destroy', '/product-rates');">
					<button class="btn btn-red" type="button"> <i class="icon-trash" title="Delete Invoice"></i></button></a>
			</td>
			<!-- <td class="size-80 text-center">
				<div class="row">
					
				</div>
			</td> -->
		</tr>
	  @endif
	  @endforeach
	  </tbody>
			<tfoot>
				<tr>
					<th>Sr#</th>
					<th>Date</th>
					<th>Voucher#</th>
					<th>Customer Code</th>
					<th>Customer Name</th>
				
					<th>Milk Price</th>
					<th>Biller</th>
					<th>Actions</th>
				</tr>
			</tfoot>
		</table>
		</div>
	</div>
	</div>
</div>
</div>

<div class="row">
<div class="col-lg-12">
<div class="panel panel-default">
	<div class="panel-heading clearfix">
		<h3 class="panel-title">Milk Supplier Rates</h3>

	</div>
	<div class="panel-body">
		<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover dataTables-example" >
		<thead>
		<tr>
			<th>Sr#</th>
			<th>Code</th>
			<th>S.Name</th>
			<th>Phone</th>
			<th>City</th>
			<th>Location</th>
			<th>Rate</th>
			<!-- <th>Actions</th> -->
		</tr>
		</thead>
		 <tbody>
		<?php $sum = 0; ?>
	 	@foreach($party as $sale)
	 
	    <?php $sum = $sum + 1; ?>
		<tr><td class="center">{{$sum}}</td>
			<td class="center">{{$sale->code}}</td>
			<td class="center">{{$sale->party_name}}</td>

			<td class="center">
				{{$sale->phone}}
			</td>
			<td class="center">
				
				{{$sale->city}}
				
			</td>
			<td class="center">
				@if($sale->location != null)
				{{$sale->location->name}}
				@endif
			</td>
			<td class="center" contenteditable="true" onkeyup="MilkSupplierPrice($(this).text(), {{$sale->id}});">{{$sale->fatrate}}</td>
			
			

			<!-- <td>
				<a href="/product-rates/{{$sale->id}}" target="__blank"
				 style="color:white;">
				<button class="btn btn-info" type="button"> <i class="icon-print" title="Print Invoice"></i></button></a>


					<a href="javascript:checkDelete({{ $sale->id }}, '/product-rates/{{ $sale->id }}/destroy', '/product-rates');">
					<button class="btn btn-red" type="button"> <i class="icon-trash" title="Delete Invoice"></i></button></a>
			</td> -->
			<!-- <td class="size-80 text-center">
				<div class="row">
					
				</div>
			</td> -->
		</tr>
	 
	  @endforeach
	  </tbody>
			<tfoot>
				<tr>
					<th>Sr#</th>
			<th>Code</th>
			<th>S.Name</th>
			<th>Phone</th>
			<th>City</th>
			<th>Location</th>
			<th>Rate</th>
			<!-- <th>Actions</th> -->
				</tr>
			</tfoot>
		</table>
		</div>
	</div>
	</div>
</div>
</div>

@stop

@section("scripts")
<script src="/js/jquery.min.js"></script>
<script src="/js/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/js/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="/js/plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
<script src="/js/plugins/datatables/jszip.min.js"></script>
<script src="/js/plugins/datatables/pdfmake.min.js"></script>
<script src="/js/plugins/datatables/vfs_fonts.js"></script>
<script src="/js/plugins/datatables/extensions/Buttons/js/buttons.html5.js"></script>
<script src="/js/plugins/datatables/extensions/Buttons/js/buttons.colVis.js"></script>
<!-- Select2-->
<script src="/js/plugins/select2/select2.full.min.js"></script>
<script>
	$(document).on("click", ".openModel", function () {
	  		var VId = $(this).data('id');
      		var VRNo = $(this).data('vr_no');
      		var DateTime = $(this).data('date');
      		var ProductID = $(this).data('products_id');
      		var uomID = $(this).data('uoms_id');
      		var quantitys = $(this).data('quantitys');
      		var rates = $(this).data('rates');
      		var amountss = $(this).data('amounts');

      		$(".modal-body #id").val(VId);
      		$(".modal-body #vr_no").val(VRNo);
      		$(".modal-body #date").val(DateTime);
      		$(".modal-body #products_id").val(ProductID);
      		$(".modal-body #uoms_id").val(uomID);
      		$(".modal-body #quantitys").val(quantitys);
      		$(".modal-body #rates").val(rates);
      		$(".modal-body #amounts").val(amountss);

 });
		function MilkPrice(cost, ID){
		//alert(cost)
		//alert(ID)
		jQuery.ajax({
			type: "GET",
			data: {cost: JSON.stringify(cost)},
			url: "rates/update-rate/update?product_id=" + ID,
			success: function(result) {
			if(parseInt(result) > 0)
			{
				alert("done")
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			$("#spanWait").hide();
			alert(xhr.status);
			alert(thrownError);
		}
		});	
	}

			function MilkSupplierPrice(cost, ID){
		jQuery.ajax({
			type: "GET",
			data: {cost: JSON.stringify(cost)},
			url: "rates/update-supplier-rate/update?product_id=" + ID,
			success: function(result) {
			if(parseInt(result) > 0)
			{
				alert("done")
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			$("#spanWait").hide();
			alert(xhr.status);
			alert(thrownError);
		}
		});	
	}

	function ProductKeyUp(ProductID){
		$.ajax({
	  	type: "GET",
	  	url: "/productkeyup-production?production_id=" + ProductID,
	  	success: function(data){
	  		var ProductCode = data[0].product_code;
	  		document.getElementById('products_code').value = ProductCode;
	  		}
	  	})
	}

	function RateKeyUp(Rate){

		var quantitys = document.getElementById('quantitys').value;
		var amount = quantitys*Rate;
		document.getElementById('amounts').value = amount;
	}


	 function EditClicks(ID){
	 	$("#myData tr").remove();
	  $.ajax({
	  	type: "GET",
	  	url: "/editproduction-modal?production_id=" + ID,
	  	success: function(data){
	  		$('#myData').append(data);
	  		}
	  	})
	  }

		// $("#products_name").select2();
	 //    $("#products_name").next(".select2").find(".select2-selection").focus(function() {
	 //    $("#products_name").select2("open");
	 //   });

       // $("#product_name").select2();
       // $("#product_name").next(".select2").find(".select2-selection").focus(function() {
       // $("#product_name").select2("open");
   	   // });

       // $("#uom_id").select2();
       // $("#uom_id").next(".select2").find(".select2-selection").focus(function() {
       // $("#uom_id").select2("open");
       // });

       function SaleRate(salerate){
			var quantity = document.getElementById('quantity').value;
			var total = quantity*salerate;
			document.getElementById('amount').value = total;

		}

		function QuantityKeyUp(quantity){
			var rate = document.getElementById('rate').value;
			total = (quantity * rate);
			document.getElementById('amount').value = total;
		}

	function ProductKeyUps(productID){
		$.ajax({
			type: "GET",
			url: "/productkeyup-ajax?prodID=" + productID,
			success: function(result) {
				if(result.length > 0)
				{
					$('#product_code').val(result[0].product_code);
					$('#product_id').val(result[0].id);
				}	
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}				
		});
}

	function AddGridData(){
		
		var date = document.getElementById('date').value;
		var InvoiceNo = document.getElementById('vr_no').value;
		var ProductId = document.getElementById('product_id').value;
		var ProductCode = document.getElementById('product_code').value;
		var ProductName = document.getElementById('product_name').value.split("_").pop();
		var UOMID = document.getElementById('uom_id').value.split("_")[0];
		var UOM = document.getElementById('uom_id').value.split("_").pop();
		var Quantity = document.getElementById('quantity').value;
		var Price = document.getElementById('price_per_unit').value;
		var Amount = document.getElementById('balance').value;
		///document.getElementById('TotalRate').value = Price;
		//document.getElementById('TotalAmount').value = Amount;
		//var totalPrice = document.getElementById('Price').value;
		var TotalRate = document.getElementById('TotalRate').value;
		var totalAmount = document.getElementById('TotalAmount').value;

		//var grandPrice = parseInt(Price) + parseInt(totalPrice);
		var grandRate = parseInt(Price) + parseInt(TotalRate);
		var grandAmount = parseInt(Amount) + parseInt(totalAmount);
		//document.getElementById('TotalRate').value = grandPrice;
		document.getElementById('TotalRate').value = grandRate;
		document.getElementById('TotalAmount').value = grandAmount;

		var tableHtml = '<tr>';
		//0
		//tableHtml += '<td>'+ ProductId +'</td>';
		tableHtml += `<td style="display:none;"><input id="product_id" name="product_id[]" value="${ProductId}" type="text" class="form-control"></td>`;
		//1
		//tableHtml += '<td>'+ ProductCode +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="" name="[]" value="${ProductCode}" type="text" class="form-control" style="margin-left: 7%; width: 53%;"></td>`;
    	//2
		//tableHtml += '<td>'+ ProductName +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="" name="[]" value="${ProductName}" type="text" class="form-control" style="margin-left: -33%;
    width: 161%;"></td>`;
    	//3
    tableHtml += `<td style="display:none;"><input id="uom_id" name="uom_id[]" value="${UOMID}" type="text" class="form-control" style="margin-left: -25%;
    width: 120%;"></td>`;
    	//4
    tableHtml += `<td style="padding-top:20px;"><input id="" name="[]" value="${UOM}" type="text" class="form-control" style="margin-left: 34%;
    width: 53%;"></td>`;

		//6
		//tableHtml += '<td>'+ Quantity +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="quantity" name="quantity[]" value="${Quantity}" type="text" class="form-control" style="margin-left: -6%; width: 53%;"></td>`;
		//tableHtml += '<td>'+ CostAmount +'</td>';
		//7
    	//10
		// tableHtml += '<td>'+ Price +'</td>';
		 tableHtml += `<td style="padding-top:20px;"><input id="rate" name="rate[]" value="${Price}" type="text" class="form-control" style="margin-left:-45%; width: 106%;"></td>`;
		 //11
		 tableHtml += `<td style="padding-top:20px;"><input id="amount" name="amount[]" value="${Amount}" type="text" class="form-control" style="margin-left: -31%;
    width: 106%;"></td>`;
		// document.getElementById('test').value=Price;
		// tableHtml += '<td>'+ Amount +'</td>';
		//12
		tableHtml += '<td style="padding-top: 20px;"><button class="btn btn-red" type="button" style="margin-left: -80%;"> <i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-trash" title="Delete Row"></i></button></td>';
		tableHtml += '</tr></br>';
		$('#myData').append(tableHtml);
		document.getElementById("product_code").focus();
	}
       // $("#uoms_id").select2();
       // $("#uoms_id").next(".select2").find(".select2-selection").focus(function() {
       // $("#uoms_id").select2("open");
       // });

	$(document).ready(function () {
		$('.dataTables-example').DataTable({
			dom: '<"html5buttons" B>lTfgitp',
			buttons: [
				{
					extend: 'copyHtml5',
					exportOptions: {
						columns: [ 0, ':visible' ]
					}
				},
				{
					extend: 'excelHtml5',
					exportOptions: {
						columns: ':visible'
					}
				},
				{
					extend: 'pdfHtml5',
					exportOptions: {
						columns: [ 0, 1, 2, 3, 4 ]
					}
				},
				'colvis'
			]
		});
	});
</script>

@stop