@extends("app")
@section("head")
<!-- Entypo font stylesheet -->
<link href="/css/entypo.css" rel="stylesheet">
<!-- /entypo font stylesheet -->

<!-- Font awesome stylesheet -->
<link href="/css/font-awesome.min.css" rel="stylesheet">
<!-- /font awesome stylesheet -->

<!-- Bootstrap stylesheet min version -->
<link href="/css/bootstrap.min.css" rel="stylesheet">
<!-- /bootstrap stylesheet min version -->

<!-- Mouldifi core stylesheet -->
<link href="/css/mouldifi-core.css" rel="stylesheet">
<!-- /mouldifi core stylesheet -->

<link href="/css/plugins/datepicker/bootstrap-datepicker.css" rel="stylesheet">
<link href="/css/plugins/colorpicker/bootstrap-colorpicker.css" rel="stylesheet">
<link href="/css/plugins/nouislider/nouislider.css" rel="stylesheet">
<link href="/css/plugins/select2/select2.css" rel="stylesheet">
<link href="/css/mouldifi-forms.css" rel="stylesheet" >
@stop
@section("contents")
			<div class="container-fluid">
				@if (Session::has('flash_message'))
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="margin-right: 20px;margin-top: 15px;">&times;</button>
					<div class="alert alert-success"> {{ Session::get('flash_message') }} </div>
				@endif
			</div>
			<h1 class="page-title">Edit Sale</h1>
			<!-- Breadcrumb -->
			<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
				<li><a href="/sales">Sales</a></li> 
				<li class="active"><strong>Edit Sale</strong></li> 
			</ol>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">Edit Sale</h3>
							<ul class="panel-tool-options"> 
								<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
								<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
								<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
							</ul>
						</div>
						<div class="panel-body">
							@include('errors.validation')
							{!! Form::model($edit, ['method' => 'PATCH', 'action' => ['SalesController@update', $edit->id], 'class' => 'form-horizontal' ]) !!}						
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Date</label>  
									<div class="col-sm-3"> 
										<div id="year-view" class="input-group date"> 
											<input id="date" type="text" name="date" value="{{ date('m/d/Y',strtotime($edit->date)) }}" class="form-control"> 
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
										</div>
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Reference No</label>  
									<div class="col-sm-5"> 
									{!! Form::text('reference_no', null, ['id' => 'reference_no','class'=>'form-control']) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Biller</label>  
									<div class="col-sm-5"> 
									  <select name="biller" id="biller" class="form-control" disabled>
										<option value="{{ Auth::user()->id }}">{{ Auth::user()->name}}</option>
									  </select>
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Customer</label>  
									<div class="col-sm-5"> 
									{!! Form::select('party_id', $customer, $edit->party_id, ['id' => 'party_id', 'class'=>'form-control']) !!}
									</div> 
								</div>
								<div class="row">
								<div class="col-lg-12">
								<div class="panel panel-default">

								<div class="panel-body">	
									<div class="form-group">
										<div class="col-sm-12">
											<div class="row">
												<div class="col-md-2"><h3>Product Name</h3></div>
												<div class="col-md-2"><h3 style="margin-left: 60px;">Discount</h3></div>
												<div class="col-md-2"><h3 style="margin-left: 60px;">Quantity</h3></div>
												<div class="col-md-2"><h3 style="margin-left: 45px;">Unit Price</h3></div>
												<div class="col-md-2"><h3 style="margin-left: 43px;">Total Price</h3></div>
											</div>
											<table  id="myTable">
											<div class="row">
											@foreach($edit->sale_details as $saleDetail)
											<tr>
												<td>
												<div class="col-md-60" style="width: 200px; padding:10px;">
												{!! Form::select('product_id',  $products, $saleDetail->product_id, ['id' => 'product_id','class'=>'form-control']) !!}
												</div>
												</td>
												<td>
												<div class="col-md-60" style="width: 160px; padding: 0px 20px;">
												{!! Form::text('discount', $saleDetail->discount, ['id' => 'discount', 'onkeyup' => 'Calculate()', 'class'=>'form-control']) !!}
												</div>
												</td>
												<td>
												<div class="col-md-10">
												{!! Form::text('quantity', $saleDetail->quantity, ['id' => 'quantity', 'onkeyup' => 'Calculate()','class'=>'form-control']) !!}
												</div>
												</td>
												<td>
												<div class="col-md-12">
												{!! Form::text('unit_cost', $saleDetail->unit_cost, ['id' => 'unit_cost', 'disabled' => 'disabled', 'class'=>'form-control']) !!}
												</div>
												</td>
												<td>
												<div class="col-md-14">
												{!! Form::text('total_cost', $saleDetail->total_cost, ['id' => 'total_cost', 'disabled' => 'disabled','class'=>'form-control']) !!}
												</div>
												</td>
												<td>
													<div class="col-md-2">														
														<button onclick="javascript:myDeleteFunction($(this).closest('tr'));" class="btn btn-red" title="Delete Row" type="button"> <i class="icon-trash"></i> </button>
													</div>												
												</td>	
												</tr>
												@endforeach
											</div>
											
											</table>
											
										</div>
									</div>
							</div>
						</div>
					</div>
				</div>
				<center><div class="form-actions">
			  <button type="button" class="btn btn-primary" id="btnSave" name="btnSave">Save</button>
			</div></center>								
		</div>
		{!! Form::close() !!}
		<div class="col-lg-2">
			<button onclick="AddRowFunction()" class="btn btn-success"><i class="fa fa-plus"></i> </button>
		</div>
	</div>
</div>
</div>

@stop
@section("scripts")
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css" type="text/css" />
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
<script src="/js/plugins/nouislider/nouislider.min.js"></script>
<!-- Input Mask-->
<script src="/js/plugins/jasny/jasny-bootstrap.min.js"></script>
<!-- Select2-->
<script src="/js/plugins/select2/select2.full.min.js"></script>
<!--Bootstrap ColorPicker-->
<script src="/js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!--Bootstrap DatePicker-->
<script src="/js/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
function AddRowFunction() {

	var productsOptionsText = "";
	$.each($("#product_id option"), function(index, option){
		productsOptionsText = productsOptionsText + "<option value='" + $(option).val() + "'>";
		productsOptionsText = productsOptionsText + $(option).text() + "</option>";
	});
	
	var html = '<tr style="padding-top:20px;">';
	html = html + '<td style="padding-top:20px;">';
	html = html + '<div class="col-md-60" style="width: 190px; padding-left: 10px;">';
	html = html + '<select  onchange="javascript:getProductCost($(this).val(), $(this).closest(\'tr\').index());" class="form-control">';
	html = html + productsOptionsText;
	html = html + '</select>';
	html = html + '</div>';
	html = html + '</td>';
	html = html + '<td style="padding-top:20px;">';
	html = html + '<div class="col-md-60" style="width: 160px; padding: 0px 20px;">';
	html = html + '{!! Form::text('discount_idnew', 0, ['id' => 'discount_idnew', 'onkeyup' => 'javascript:DiscountNew($(this).val(), $(this).closest(\'tr\').index())', 'class'=>'form-control']) !!}';
	html = html + '</div>';
	html = html + '</td>';
	html = html + '<td style="padding-top:20px;">';
	html = html + '<div class="col-md-10">';
	html = html + '<input id="quantitynew" value="1" onkeyup="javascript:getquantityCost($(this).val(), $(this).closest(\'tr\').index());" class="form-control" name="quantity" type="text">';
	html = html + '</div>';
	html = html + '</td>';
	html = html + '<td style="padding-top:20px;">';
	html = html + '<div class="col-md-12">';
	html = html + '<input id="unit_costnew" class="form-control" disabled="disabled" name="unit_costnew" type="text">';
	html = html + '</div>';
	html = html + '</td>';
	html = html + '<td style="padding-top:20px;">';
	html = html + '<div class="col-md-14">';
	html = html + '<input id="totalcostnew" class="form-control" disabled="disabled" name="totalcostnew" type="text">';
	html = html + '</div>';
	html = html + '</td>';
	html = html + '<td style="padding-top:20px;">';
	html = html + '<div class="col-md-12">';
	html = html + '<button onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="btn btn-red" title="Delete 	Row" type="button"> <i class="icon-trash"></i> </button>';
	html = html + '</div>';									
	html = html + '</td>';
	html = html + '</tr>';
	$("#myTable").append(html);
	
}
	function myDeleteFunction(row) {
		if(confirm("Are you sure you want to delete this row?"))
		{
			$(row).remove();
		}
	}

	// show the total cost on product & quantity & tax
	function Calculate(){
		var quantity = document.getElementById('quantity').value;
		var cost = document.getElementById('unit_cost').value;
		var discount = document.getElementById('discount').value;
		var grand = (quantity*cost) - discount;
		document.getElementById('total_cost').value = grand;
	}
	
		function Discount(){
		var quantity = document.getElementById('quantity').value;
		var cost = document.getElementById('unit_cost').value;
		var discount = document.getElementById('discount').value;
		var grand = (quantity*cost) - discount;
		document.getElementById('total_cost').value = grand;
	}


	function CalculateNew(tax, rowIndex){	
		var discount = $('tr:eq(' + rowIndex +')', myTable).find("td:eq('1')").find('select').val().split("_").pop();	
		var quantity = $('tr:eq(' + rowIndex +')', myTable).find("td:eq('3')").find('input').val();		
		//quantity = (quantity == "" || quantity == null) ? 0.00 : quantity;
		var unitPrice = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('input').val();
		///if(parseFloat(tax) > 0)
		//{
			var totalPrice = ((unitPrice * (tax/100)) * quantity) + (unitPrice * quantity);
			var total_dis = ((discount/100)*quantity*unitPrice);
			var grand = totalPrice - total_dis;
			$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('5')").find('input').val(grand);
		//}
		//else
		//{
			//$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('5')").find('input').val(unitPrice);
		//}	
				
}

	function DiscountNew(discount, rowIndex){	
		var quantity = $('tr:eq(' + rowIndex +')', myTable).find("td:eq('2')").find('input').val();		
		var unitPrice = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('3')").find('input').val();
		///if(parseFloat(tax) > 0)
		//{
			var grand = (quantity*unitPrice) - discount;
			$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('input').val(grand);
		//}
		//else
		//{
			//$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('5')").find('input').val(unitPrice);
		//}	
				
}

// ajax call for product, it will show cost value & calculate total cost
	$("#product_id").change(function(){
			if($("#product_id").val() != "0")
			{
				$.ajax({
					type: "GET",
					url: "/purchasetab-ajax?purchasetab_id=" + $("#product_id").val(),
					success: function(result) {
						if(result.length > 0)
						{
						$("#unit_cost").val(result[0].product_price);
							var quantity = document.getElementById('quantity').value;
							var cost = document.getElementById('unit_cost').value;
							var discount = document.getElementById('discount').value;
							var grand = (quantity*cost) - discount;
							document.getElementById('total_cost').value = grand;
						}	
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.status);
						alert(thrownError);
					}				
				});				
			}		
		});

// on javascript onclick on product dropdown
	function getProductCost(productId, rowIndex){
		$.ajax({
			type: "GET",
			url: "/saletab-ajax?purchase_id=" + productId,
			success: function(result) {
				if(result.length > 0)
				{
					$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('3')").find('input').val(result[0].product_newprice);
					var newdiscount = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('1')").find('input').val();
					var newquantity = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('2')").find('input').val();
					var newPrice = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('3')").find('input').val();
					var grand = (newquantity*newPrice) - newdiscount;
					if(parseInt(newPrice) == 0 && parseFloat(newPrice) > 0)
					{
						totalPrice = parseFloat(grand).toFixed(2);
					}
					$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('input').val(grand);		
				}	
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}				
		});
}

// on javascript onclick on product dropdown
	function getquantityCost(quantity, rowIndex){		
		var discount = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('1')").find('input').val();
		var unitPrice = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('3')").find('input').val();
		var grand = (quantity*unitPrice) - discount;
		if(parseInt(quantity) > 0)
		{	
			$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('input').val(grand);
		}
		else
		{
			$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('input').val(unitPrice);
		}	
				
}

$("#btnSave").click(function()
{
	//debugger;
	var purchase = new Object();
	purchase.date = $("#date").val();
	purchase.reference_no = $("#reference_no").val();
	purchase.biller = $("#biller").val();
	purchase.party_id = $("#party_id").val();
	
	var products = [];
	$.each($("#myTable tr"), function(index, row){
		var columns = $(row).find("td");
		var product = new Object();
		product.party_id = $("#party_id").val();
		product.product_id = $(columns[0]).find("select").val();
		product.discount = $(columns[1]).find("input").val();
		product.quantity = $(columns[2]).find("input").val();
		product.unit_cost = $(columns[3]).find("input").val();
		product.total_cost = $(columns[4]).find("input").val();
		products.push(product);
	});
	//var $_token = jQuery('#token').val();
		var $_token = $("input[name='_token']").val();
		jQuery.ajax({
		method: "PATCH",
		cache: false,
		headers: { 'X-CSRF-TOKEN' : $_token },
		data: { purchase: JSON.stringify(purchase), product_data:products },
		url: "/sales/<?php echo $edit->id ?>",
		
		success: function(result) {
			if(result == "updated")
			{
				alert("Sale successfully updated.");
				window.location.href = "/sales";
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			$("#spanWait").hide();
			alert(xhr.status);
			alert(thrownError);
		}
	});
});

		$('#date').datepicker({
					startView: 0,
					keyboardNavigation: false,
					forceParse: false,
					format: "dd/mm/yyyy"
				});

</script>
@stop