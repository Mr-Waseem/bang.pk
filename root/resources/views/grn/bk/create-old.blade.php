@extends("app")
@section("contents")
<body onload="AddRowFunction()">
<div class="container-fluid">
	@if (Session::has('flash_message'))
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="margin-right: 20px;margin-top: 15px;">&times;</button>
		<div class="alert alert-success"> {{ Session::get('flash_message') }} </div>
	@endif
</div>
<h1 class="page-title">Add Stock</h1>
<!-- Breadcrumb -->
<ol class="breadcrumb breadcrumb-2"> 
	<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
	<li><a href="/purchases">Stock</a></li> 
	<li class="active"><strong>Add Stock</strong></li> 
</ol>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading clearfix">
				<h3 class="panel-title">Add Stock</h3>
				<ul class="panel-tool-options"> 
					<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
					<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
					<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
				</ul>
			</div>
			<div class="panel-body">
				<input id="token" type="hidden" value="{{$encrypted_token}}">
				@include('errors.validation')
				{!! Form::open(['url' => 'purchases', 'class' => 'form-horizontal' ]) !!}
				<div class="row">
					<div class="form-group"> 
						<label class="col-sm-3 control-label">Date</label>  
						<div class="col-sm-2"> 
							<div id="year-view" class="input-group date"> 
								<input id="date" type="text" name="date" value="<?php echo date('m/d/Y');?>" class="form-control" autofocus> 
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
							</div>
						</div>
					
						<label class="col-sm-1 control-label">Purchase&nbsp;Type</label>  
						<div class="col-sm-2"> 
							<select class="form-control" onchange="LedgerValues();" id="purchase_type" name="purchase_type">
								<option value="Cash Purchase">Cash Purchase</option>
								<option value="Credit Purchase">Credit Purchase</option>
							</select>
						</div> 							
					</div>
				</div>
				<div class="row" id="ledgerRow" style="display:none;">
					<div class="form-group"> 
						<label class="col-sm-3 control-label">Due&nbsp;Date</label>  
						<div class="col-sm-2"> 
							<div id="year-view" class="input-group date"> 
								<input id="due_date" type="date" name="due_date" class="form-control"> 
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
							</div>
						</div>
					
						<label class="col-sm-1 control-label"></label>  
						<div class="col-sm-2">
							{!! Form::text('particulars', null, ['id' => 'particulars', 'placeholder' => 'Description','class'=>'form-control']) !!}
						</div> 							
					</div>
				</div>
					<!-- <div class="form-group"> 
						<label class="col-sm-3 control-label">Date</label>  
						<div class="col-sm-3"> 
							<div id="year-view" class="input-group date"> 
								<input id="date" type="text" name="date" value="<?php echo date('m/d/y');?>" class="form-control"> 
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
							</div>
						</div> 
					</div> -->
					<div class="form-group"> 
						<label class="col-sm-3 control-label">GRN No</label>  
						<div class="col-sm-5"> 
						{!! Form::text('reference_no', null, ['id' => 'reference_no','class'=>'form-control']) !!}
						</div> 
					</div>
					<div class="form-group"> 
						<label class="col-sm-3 control-label">Supplier</label>  
						<div class="col-sm-5" style="height: 40px;"> 
						{!! Form::select('supplier_id', $suppliers, null, ['id' => 'supplier_id', 'class'=>'form-control livesearch']) !!}
						</div> 
					</div>
					<div class="row">
					<div class="col-lg-12">
					<div class="panel panel-default">

					<div class="panel-body">	
						<div class="form-group">
							<div class="col-sm-12">
								<div class="row">
									<div class="col-sm-2"><h5><b><center>Code</center></b></h5></div>
									<div class="col-sm-2"><h5><b><center>Product Name</center></b></h5></div>
									<div class="col-sm-2"><h5><b><center>Tax</center></b></h5></div>
									<div class="col-sm-1"><h5><b><center>Quantity</center></b></h5></div>
									<div class="col-sm-2"><h5><b><center>Price</center></b></h5></div>
									<div class="col-sm-1"><h5><b><center>Total&nbsp;Cost</center></b></h5></div>
								</div>
								<table  id="myTable">
								<div class="row">
								<!-- <tr>
									<div class="col-sm-1">
										<td style="width:15%;">
											{!! Form::text('code', null, ['id' => 'code', 'onkeyup' => 'Calculate()','class'=>'form-control']) !!}
										</td>
									</div>
									<div class="col-sm-1">
										<td style="width:15%;">
										{!! Form::text('product_name', null, ['id' => 'product_name','class'=>'form-control']) !!}
										</td>
									</div>
									
									<div class="col-sm-1">
										<td style="width:15%;">
									{!! Form::select('tax_id', $taxes, null, ['id' => 'tax_id', 'onchange' => 'Calculate()', 'class'=>'form-control']) !!}
									</div>
									</td>
									<div class="col-sm-1">
										<td style="width:15%;">
									{!! Form::text('quantity', 1, ['id' => 'quantity', 'onkeyup' => 'Calculate()','class'=>'form-control']) !!}
									</td>
									</div>
									<div class="col-sm-1">
										<td style="width:15%;">
									{!! Form::text('unit_cost', null, ['id' => 'unit_cost', 'disabled' => 'disabled', 'class'=>'form-control']) !!}
									</td>
									</div>
									<div class="col-sm-1">
										<td style="width:15%;">
									{!! Form::text('total_cost', null, ['id' => 'total_cost', 'disabled' => 'disabled','class'=>'form-control']) !!}
									</td>
									</div>
									<td>
										<div class="col-md-1">														
											<button onclick="javascript:myDeleteFunction($(this).closest('tr'));" class="btn btn-red" title="Delete Row" type="button"> <i class="icon-trash"></i> </button>
										</div>												
									</td>	
									</tr> -->
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
			<div class="col-lg-3">
				<button type="button" onclick="AddRowFunction()" class="btn btn-success"><i class="fa fa-plus"></i> </button>
				<button type="button" onclick="TotalRecords()" class="btn btn-success">Total Records</button>
			</div>			
			{!! Form::close() !!}		
		</div>
	</div>
</div>
</div>
</body>
@stop
@section("scripts")
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css" type="text/css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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
	var sum=0;
function AddRowFunction() {
	sum = sum + 1;

	var productsOptionsText = "";
	$.each($("#product_id option"), function(index, option){
		productsOptionsText = productsOptionsText + "<option value='" + $(option).val() + "'>";
		productsOptionsText = productsOptionsText + $(option).text() + "</option>";
	});
	
	var html = '<tr>';
	html = html + '<td style="display:none;">';
	html = html + '{!! Form::text('product_id', null, ['id' => 'product_id', 'class'=>'form-control']) !!}';
	html = html + '</td>';

	html = html + '<div class="col-sm-1">';
	html = html + '<td style="width:15%;">';
	html = html + '{!! Form::text('code', null, ['id' => 'code', 'onkeyup' => 'javascript:codeMouseUp($(this).val(), $(this).closest(\'tr\').index())', 'class'=>'form-control', 'autofocus' => 'autofocus' ]) !!}';
	html = html + '</td>';
	html = html + '</div>';

	html = html + '<div class="col-sm-1">';
	html = html + '<td style="width:15%;">';
	// html = html + '<select  onchange="javascript:getProductCost($(this).val(), $(this).closest(\'tr\').index());" class="form-control">';
	// html = html + productsOptionsText;
	// html = html + '</select>';
	html = html + '{!! Form::select('product_name', $products, null, ['id' => 'product_name', 'onchange' => 'javascript:productMouseUp($(this).val(), $(this).closest(\'tr\').index())', 'class'=>'form-control livesearch']) !!}';
	html = html + '</td>';
	html = html + '</div>';
	
	html = html + '<div class="col-sm-1">';
	html = html + '<td style="width:15%;">';
	html = html + '{!! Form::select('tax_idnew', $taxes, null, ['id' => 'tax_idnew', 'onchange' => 'javascript:CalculateNew($(this).val().split("_").pop(), $(this).closest(\'tr\').index())', 'class'=>'form-control']) !!}';
	html = html + '</td>';
	html = html + '</div>';
	
	html = html + '<div class="col-sm-1">';
	html = html + '<td style="width:15%;">';
	html = html + '<input id="quantitynew" value="1" onkeyup="javascript:getquantityCost($(this).val(), $(this).closest(\'tr\').index());" class="form-control" name="quantity" type="text">';
	html = html + '</td>';
	html = html + '</div>';
	
	html = html + '<div class="col-sm-1">';
	html = html + '<td style="width:15%;">';
	html = html + '<input id="unit_costnew" onkeyup="javascript:getPriceValue($(this).val(), $(this).closest(\'tr\').index());" class="form-control" name="unit_costnew" type="text">';
	html = html + '</td>';
	html = html + '</div>';
	
	html = html + '<div class="col-sm-1">';
	html = html + '<td style="width:15%;">';
	html = html + '<input id="totalcostnew" class="form-control" onkeyup="AddRowFunction()" name="totalcostnew" type="text">';
	html = html + '</td>';
	html = html + '</div>';
	
	html = html + '<td>';
	html = html + '<div class="col-md-1">';
	html = html + '<button onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="btn btn-red" title="Delete Row" type="button" id="DltButton"> <i class="icon-trash"></i></button>';
	html = html + '</div>';									
	html = html + '</td>';
	html = html + '</tr>';
	$("#myTable").append(html);
	
}

function LedgerValues(){
	 $value = $("#purchase_type").val();
	 if($value == "Cash Purchase"){
	 	$('#ledgerRow').hide();
	 }
	  if($value == "Credit Purchase"){
   $('#ledgerRow').show();
}
}
function getPriceValue(price, rowIndex){
	


	var quantity = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('input').val();

	var tax = $('tr:eq(' + rowIndex +')', myTable).find("td:eq('3')").find('select').val().split("_").pop();

					//quantity = (quantity == "" || quantity == null) ? 0.00 : quantity;

	var totalcost = (quantity*price) + ((tax/100)*quantity*price);
	$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val(parseInt(totalcost));
}

	function TotalRecords() {
		var rowCount = document.getElementById('myTable').rows.length;
		alert("Total Number of Records Are: " + rowCount);
	}

	function myDeleteFunction(row) {
		if(confirm("Are you sure you want to delete this row?"))
		{
			$(row).remove();
		}
	}

		// Code Mouse Up 
	function codeMouseUp(code, rowIndex){
		$.ajax({
			type: "GET",
			url: "/codemouseup-ajax?entered_code=" + code,
			success: function(result) {
				if(result.length > 0)
				{
					$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('0')").find('input').val(result[0].id);
					$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('2')").find('input').val(result[0].product_name);
					$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('5')").find('input').val(result[0].product_cost);
					// $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('2')").find('input').val(result[0].product_name);
					
					var tax = $('tr:eq(' + rowIndex +')', myTable).find("td:eq('3')").find('select').val().split("_").pop();
					var quantity = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('input').val();
					//quantity = (quantity == "" || quantity == null) ? 0.00 : quantity;
					var cost = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('5')").find('input').val();
					var totalcost = (quantity*cost) + ((tax/100)*quantity*cost);
					$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val(parseInt(totalcost));
					 // if(parseInt(cost) == 0 && parseFloat(totalcost) > 0)
					 // {
					 // 	totalcost = parseInt(totalcost).toFixed(2);
					 // }
					 // $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val(parseInt(totalcost));
					 // $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('input').val(totalPrice);		
				//}
				}	
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}				
		});
}

	function productMouseUp(productName, rowIndex){
		$.ajax({
			type: "GET",
			url: "/productmouseup-ajax?product_name=" + productName,
			success: function(result) {
				if(result.length > 0)
				{
					$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('0')").find('input').val(result[0].id);
					$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('1')").find('input').val(result[0].product_code);

					$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('5')").find('input').val(result[0].product_cost);
					// $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('2')").find('input').val(result[0].product_name);


					var tax = $('tr:eq(' + rowIndex +')', myTable).find("td:eq('3')").find('select').val().split("_").pop();
					var quantity = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('input').val();
					//quantity = (quantity == "" || quantity == null) ? 0.00 : quantity;
					var cost = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('5')").find('input').val();
					var totalcost = (quantity*cost) + ((tax/100)*quantity*cost);
					$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val(parseInt(totalcost));
					 // if(parseInt(cost) == 0 && parseFloat(totalcost) > 0)
					 // {
					 // 	totalcost = parseInt(totalcost).toFixed(2);
					 // }
					 // $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val(parseInt(totalcost));
					 // $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('input').val(totalPrice);		
				//}
				}	
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}				
		});
}

	// show the total cost on product & quantity & tax
	function Calculate(){
		var quantity = document.getElementById('quantity').value;
		var cost = document.getElementById('unit_cost').value;
		var tax = document.getElementById('tax_id').value.split("_").pop();
		// 2nd part total tax & 1st multiply to quantity
		var total = (quantity*cost) + ((tax/100)*quantity*cost);
		document.getElementById('total_cost').value = total;
	}


	function CalculateNew(tax, rowIndex){	
		var quantity = $('tr:eq(' + rowIndex +')', myTable).find("td:eq('4')").find('input').val();		
		//quantity = (quantity == "" || quantity == null) ? 0.00 : quantity;
		var unitPrice = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('5')").find('input').val();
		if(parseFloat(tax) > 0)
		{
			var totalPrice = ((unitPrice * (tax/100)) * quantity) + (unitPrice * quantity);
			$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val(totalPrice);
		}
		else
		{
			$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val(unitPrice);
		}	
				
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
						$("#unit_cost").val(result[0].product_cost);
							var quantity = document.getElementById('quantity').value;
							var cost = document.getElementById('unit_cost').value;
							var tax = document.getElementById('tax_id').value.split("_").pop();
							// 2nd part total tax & 1st multiply to quantity
							var total = (quantity*cost) + ((tax/100)*quantity*cost);
							//var total =((tax/100)*quantity*cost);
							$("#total_cost").val(total);
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
			url: "/products-ajax?purchase_id=" + productId,
			success: function(result) {
				if(result.length > 0)
				{
					$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('3')").find('input').val(result[0].product_newcost);
					
					var newtax = $('tr:eq(' + rowIndex +')', myTable).find("td:eq('1')").find('select').val().split("_").pop();
					var newquantity = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('2')").find('input').val();
					//quantity = (quantity == "" || quantity == null) ? 0.00 : quantity;
					var newPrice = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('3')").find('input').val();
					var totalPrice = (newquantity*newPrice) + ((newtax/100)*newquantity*newPrice);
					if(parseInt(newPrice) == 0 && parseFloat(newPrice) > 0)
					{
						totalPrice = parseFloat(unitPrice).toFixed(2);
					}
					$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('input').val(totalPrice);		
				//}
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
		var newtax = $('tr:eq(' + rowIndex +')', myTable).find("td:eq('3')").find('select').val().split("_").pop();		
		//quantity = (quantity == "" || quantity == null) ? 0.00 : quantity;
		var unitPrice = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('5')").find('input').val();
		if(parseInt(quantity) > 0)
		{
			var totalPrice = ((unitPrice * (newtax/100)) * quantity) + (unitPrice * quantity);
			$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val(totalPrice);
		}
		else
		{
			$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val(unitPrice);
		}	
				
}

$("#btnSave").click(function()
{
	debugger;
	var purchase = new Object();
	purchase.supplier_id = $("#supplier_id").val();
	purchase.date = $("#date").val();
	purchase.reference_no = $("#reference_no").val();
	purchase.purchase_type = $("#purchase_type").val();
	if($("#due_date").val() != ""){
	 purchase.due_date = $("#due_date").val();
	 purchase.particulars = $("#particulars").val();
	}

	var products = [];
	$.each($("#myTable tr"), function(index, row){
		var columns = $(row).find("td");
		var product = new Object();
		product.product_id = $(columns[0]).find("input").val();
		product.tax_id = $(columns[3]).find("select").val().split("_")[0];
		product.quantity = $(columns[4]).find("input").val();
		product.unit_cost = $(columns[5]).find("input").val();
		product.total_cost = $(columns[6]).find("input").val();

		//Code & product only for validation, not insertion
		product.code = $(columns[1]).find("input").val();
		product.product_name = $(columns[2]).find("input").val();
		if($(columns[1]).find("input").val()=="" || $(columns[2]).find("input").val()==""){
			alert('Fill the Code & Product Correctly First!');
           e.preventdefault();
			}
		//validation
		if($(columns[3]).find("input").val() =="" || $(columns[4]).find("input").val() =="" | $(columns[5]).find("input").val() =="" || $(columns[6]).find("input").val() ==""){
			alert('Fill the Fields Correctly First!');
           e.preventdefault();
			}
		products.push(product);
	});
	var $_token = jQuery('#token').val();
	jQuery.ajax({
		method: "POST",
		cache: false,
		headers: { 'X-XSRF-TOKEN' : $_token },
		data: {purchase: JSON.stringify(purchase), product_data:products},
		url: "/purchases",
		
		success: function(result) {
			if(parseInt(result) > 0)
			{
				alert("Purchase successfully saved.");
				window.open("/purchases/print/"+result);
				window.location.href = "/purchases/create";
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