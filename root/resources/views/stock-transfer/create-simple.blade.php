@extends("app")
<head>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

</head>
@section("contents")
<!-- <body onload="AddRowFunction()"> -->
<!-- <body onload="myFunction()"> -->
<body>
<div class="container-fluid">
	@if (Session::has('flash_message'))
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="margin-right: 20px;margin-top: 15px;">&times;</button>
		<div class="alert alert-success"> {{ Session::get('flash_message') }} </div>
	@endif
</div>
<!-- <h1 class="page-title">Add Sale</h1>
<ol class="breadcrumb breadcrumb-2"> 
	<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
	<li><a href="/sales">Sales</a></li> 
	<li class="active"><strong>Add Sale</strong></li> 
</ol> -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading clearfix" id="panelbg">
				<h2 class="panel-title"><b>Transfer Production Stock</b></h2>
			</div>
		<div class="panel-body">
			<input id="token" type="hidden" value="{{$encrypted_token}}">
			@include('errors.validation')
			{!! Form::open(['url' => 'stock-transfer', 'class' => 'form-horizontal' ]) !!}
			<input type="hidden" name="biller" id="biller" value="{{ Auth::user()->id }}">
				
				<div class="row">
					<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
						<label class="col-sm-1 control-label">Date</label>  
						<div class="col-sm-2"> 
							<div id="year-view" class="input-group date"> 
								<input id="date" type="date" name="date" value="<?php echo date('Y-m-d');?>" class="form-control" onkeyup = "focusNext(event);"> 
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</div>
						</div>						
					</div>
				</div>
				<div class="form-group" style="margin-left: 0px;"> 
					<label class="col-sm-1 control-label">Bill&nbsp;No#</label>  
					<div class="col-sm-2"> 
						{!! Form::text('invoice_no', $codes, ['id' => 'invoice_no','class'=>'form-control', 'required' => 'required', 'onkeyup' => 'focusNext(event);', 'autofocus' => 'autofocus']) !!}
							
					</div>
				</div>
				<div class="row" style="">
					<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
						<label class="col-sm-1 control-label">From</label>
						<div class="col-sm-3"> 
								{!! Form::select('from_warehouse_id', $warehouseFrom, null, ['id' => 'from_warehouse_id', 'class'=>'form-control']) !!}
						</div> 
						<label class="col-sm-2 control-label">TO</label>  
						<div class="col-sm-3">
							
							{!! Form::select('to_warehouse_id', $warehouseTo, null, ['id' => 'to_warehouse_id', 'class'=>'form-control']) !!}
						</div> 		

					</div>
				</div>
				 	
<div class="panel panel-default">
 <div class="panel-body">	
  <div class="form-group">
   <table  id="myTable">
	<div class="container-fluid">
	 <div class="row">
	<tr> 							
<!-- <div class="col-md-3"> 
	<div class="form-group"> 
		<label for="H.S" class="control-label">Id</label> -->
		{!! Form::hidden('product_id', null, ['id' => 'product_id','class'=>'form-control']) !!}
	<!-- </div>
</div>  -->
<div class="col-md-1" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="H.S" class="control-label">Code</label>
		<!-- {!! Form::text('product_code', null, ['id' => 'product_code', 'onkeyup' => 'CodeKeyUp($(this).val());', 'class'=>'form-control']) !!} -->
		{!! Form::text('product_code', null, ['id' => 'product_code', 'onkeyup' => 'ProductKeyUp($(this).val()); if(event.keyCode == 32) SaveFunction()', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control', 'onfocus' => 'this.value=""']) !!}
	</div>
</div> 
<div class="col-md-3" style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="Name" class="control-label">Product Name</label> 
		{!! Form::text('product_name', null, ['id' => 'product_name', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control']) !!}
	</div> 
</div> 
<div class="col-md-1" style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="Name" class="control-label">Unit</label> 
		{!! Form::select('uom_id', $uoms, null, ['id' => 'uom_id', 'class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
	</div> 
</div> 

<div class="col-md-1"style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Quantity</label> 
		{!! Form::text('quantity', null, ['id' => 'quantity', 'onkeyup' => 'QuantityKeyUp($(this).val())', 'class'=>'form-control', 'onkeydown' => 'focusNext(event);', 'onfocus' => 'this.value=""']) !!}
	</div> 
</div>

<div class="col-md-2"style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Cost Rate</label> 
		{!! Form::text('price_per_unit', null, ['id' => 'price_per_unit', 'onkeyup' => 'SaleRate($(this).val())','class'=>'form-control', 'onkeydown' => 'focusNext(event);', 'disabled' => 'disabled']) !!}
	</div> 
</div>
<div class="col-md-2"style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Cost Amount</label> 
		{!! Form::text('balance', null, ['id' => 'balance', 'class'=>'form-control', 'onkeydown' => 'focusNext(event);', 'onkeyup' => 'TotalKeyUp();']) !!}
	</div> 
</div>
<div class="col-md-1"style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Add Record</label> 
		<!-- <button class="btn btn-success" id="add" onkeyup="AddGridData();" onkeydown="focusNext(event)" type="button" style=""> <i  class="icon-plus" title="Delete Row"></i></button> -->
		<input type="text" class="form-control" Value="Add" id="add" name="add" onkeydown="focusNext(event);" onkeyup="AddGridData();" style="background-color: green; width: 50%; color: white;">
	</div> 
</div>

<!-- <td style="padding-top: 20px;"><button class="btn btn-red" type="button" style="margin-left: -80%;"> <i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-trash" title="Delete Row"></i></button></td> -->
</tr></br>
<table id="myData">
</table>
</div>
</div>
	</table></br></br>
	 </div>
	  </div>
		</div>
<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading clearfix" id="panelbg">
						<div class="container">
						  <div class="col-lg-5"><button type="button" onclick="TotalRecords()" class="btn btn-warning">Total Records</button>  </div>
						  <!-- <div class="col-xs-3">  </div> -->
						  <div class="col-lg-2"> <b style="color: black;">Total Rate</b> <input type="text" id="TotalRate" name="TotalRate" value="0" style="color: black;" disabled> </div>
						  <div class="col-lg-3"> <b style="color: black;">Total Amount</b> <input type="text" id="TotalAmount" name="TotalAmount" value="0" style="color: black;" disabled> </div>
						</div> 
					</div>
				</div>
			</div>
		</div>
			<center><div class="form-actions">
			  <button type="button" class="btn btn-primary" onclick="SaveFunction();" id="btnSave" name="btnSave">Save</button>
			</div></center>		
			<div class="col-lg-3">
				<!-- <button type="button" onclick="AddRowFunction()" class="btn btn-success"><i class="fa fa-plus"></i> </button> -->
				<!-- <button type="button" onclick="AddGridData()" class="btn btn-success"><i class="fa fa-plus"></i> </button>
				<button type="button" onclick="TotalRecords()" class="btn btn-success">Total Records</button> -->
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

function myFunction(RecipeID)
{
	//alert(RecipeID)
	// $("#myData tr").remove(); 
		$.ajax({
			type: "GET",
			url: "/loadproducts-ajax",
			success: function(result) {
				$('#myData').append(result);	
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}				
		});
}

	function ProductKeyUp(productCode){
		//alert(Code)
		$.ajax({
			type: "GET",
			url: "/productkeyup-ajax?prodCode=" + productCode,
			success: function(result) {
				if(result.length > 0)
				{
					// $('#product_code').val(result[0].product_code);
					$('#product_name').val(result[0].product_name);
					$('#product_id').val(result[0].id);
					//$("#product_cost").val(result[0].unit_cost);
					// $("#product_cost").val(result[0].product_cost);
					$("#price_per_unit").val(result[0].product_cost);

					var price = $("#price_per_unit").val();
					var quantity = $("#quantity").val();
					var cost = $("#product_cost").val();
					var CostAmount= cost * quantity;
					var SaleAmount = price * quantity;
					var totalDiscount = ((discountnew/100)*quantity*price);
					document.getElementById('cost_amount').value = CostAmount;
					document.getElementById('balance').value = SaleAmount;
				}	
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}				
		});
}

var idArray = ["date", "sale_type", "invoice_no", "localExport", "party_name", "product_code", "product_name", "uom_id", "quantity", "balance", "add"];
function focusNext(e){
	try{
	for(var i = 0; i < idArray.length; i++){
		if(e.keyCode === 13 && e.target.id === idArray[i]){
		document.querySelector(`#${idArray[i+1]}`).focus();
		//document.getElementById(nextFieldID).focus();
		}
	}
	} catch(error){}
}

      $("#from_warehouse_id").select2();
       $("#from_warehouse_id").next(".select2").find(".select2-selection").focus(function() {
       $("#from_warehouse_id").select2("open");
   });

        $("#to_warehouse_id").select2();
       $("#to_warehouse_id").next(".select2").find(".select2-selection").focus(function() {
       $("#to_warehouse_id").select2("open");
   });


       $("#uom_id").select2();
       $("#uom_id").next(".select2").find(".select2-selection").focus(function() {
       $("#uom_id").select2("open");
   });


function submitForm(){
	$( "#productsForm" ).submit();
}

function TotalKeyUp(){
	
	var Total = document.getElementById('balance').value;
	var SaleRate = document.getElementById('price_per_unit').value;
			var Quantity = parseFloat(Total/SaleRate).toFixed(2);
			document.getElementById('quantity').value = Quantity;
}


function SaleKeyUp(SaleValue, RowIndex)
{
var quantity = $('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('5')").text();
// alert(quantity)
var total = SaleValue * quantity;
$('tr:eq(' + RowIndex + ')', GridTable).find("td:eq('8')").text(total);

}


	function TotalRecords() {
		var rowCount = document.getElementById('myData').rows.length;
		alert("Total Number of Records Are: " + rowCount);
	}


		function SaleRate(salerate){
			var quantity = document.getElementById('quantity').value;
			var price = document.getElementById('price_per_unit').value;
			var total = quantity*salerate;
			document.getElementById('balance').value = total;

		}



		function QuantityKeyUp(quantity){
			var price = document.getElementById('price_per_unit').value;
			total = (quantity * price);
			document.getElementById('balance').value = total;
		}



	function PartyKeyUp(partyId){
		$.ajax({
			type: "GET",
			url: "/partyonchange-ajax?party_id=" + partyId,
			success:function(result)
			{
				if(result.length > 0){
					$('#party_id').val(result[0].id);
					$('#address').val(result[0].address);
					$('#strn').val(result[0].strn);
					$('#ntn').val(result[0].ntn);
					$('#city').val(result[0].city);
				}
			}
		})
	}

		function myDeleteFunction(row) {
		alertify.confirm("Are you sure you want to delete this row?", function (e) {
		    if (e) {
		    	var TotalRate = document.getElementById('TotalRate').value;
		    	var TotalAmount = document.getElementById('TotalAmount').value;
				var rate = $(row).find("td:eq('10')").find("input").val();
				var amount = $(row).find("td:eq('11')").find("input").val();
				//alert(rate)
				//alert(amount)
				var grandRate = parseInt(TotalRate) - parseInt(rate);
				var grandAmount = parseInt(TotalAmount) - parseInt(amount);
				document.getElementById('TotalRate').value = grandRate;
				document.getElementById('TotalAmount').value = grandAmount;
		    	$(row).remove();
		        // alertify.alert("File is Removed!");
		    } else {
		        alertify.alert("File is safe!");
		    }
		});
		// if(confirm("Are you sure you want to delete this row?"))
		// {
		// 	$(row).remove();
		// }
	}

	function AddGridData(){
		var date = document.getElementById('date').value;
		var InvoiceNo = document.getElementById('invoice_no').value;
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

		// if($("#ProductCode").val() ==" "){
	 //  	alert('Select Product First!');
	 //  	document.getElementById("product_code").focus();
  //        e.preventdefault();

	 //  }
		var tableHtml = '<tr>';
		//0
		//tableHtml += '<td>'+ ProductId +'</td>';
		tableHtml += `<td style="display:none;"><input id="test" value="${ProductId}" type="text" class="form-control" disabled></td>`;
		//1
		//tableHtml += '<td>'+ ProductCode +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="test" value="${ProductCode}" type="text" class="form-control" style="margin-left: 7%; width: 53%;" disabled></td>`;
    	//2
		//tableHtml += '<td>'+ ProductName +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="test" value="${ProductName}" type="text" class="form-control" style="margin-left: -33%;
    width: 161%;" disabled></td>`;
    	//3
    tableHtml += `<td style="display:none;"><input id="test" value="${UOMID}" type="text" class="form-control" style="margin-left: -25%;
    width: 120%;" disabled></td>`;
    	//4
    tableHtml += `<td style="padding-top:20px;"><input id="test" value="${UOM}" type="text" class="form-control" style="margin-left: 34%;
    width: 53%;" disabled></td>`;
    	//5
		//tableHtml += '<td>'+ Quantity +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="test" value="${Quantity}" type="text" class="form-control" style="margin-left: -6%; width: 54%;" disabled></td>`;
		//tableHtml += '<td>'+ CostAmount +'</td>';

    	//6
		// tableHtml += '<td>'+ Price +'</td>';
		 tableHtml += `<td style="padding-top:20px;"><input id="test" value="${Price}" type="text" class="form-control" style="margin-left:-45%; width: 107%;" disabled></td>`;
		 //7
		 tableHtml += `<td style="padding-top:20px;"><input id="test" value="${Amount}" type="text" class="form-control" style="margin-left: -32%;
    width: 107%;" disabled></td>`;
		// document.getElementById('test').value=Price;
		// tableHtml += '<td>'+ Amount +'</td>';
		//12
		tableHtml += '<td style="padding-top: 20px;"><button class="btn btn-red" type="button" style="margin-left: -80%;"> <i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-trash" title="Delete Row"></i></button></td>';
		tableHtml += '</tr></br>';
		$('#myData').append(tableHtml);
		document.getElementById("product_code").focus();
	}

// $("#btnSave").click(function()
//{
	function SaveFunction(){
	alertify.confirm("Are you sure you want to Transfer Stock?", function (e) {
	if (e)
	{
	var purchase = new Object();
	purchase.date = $("#date").val();
	purchase.invoice_no = $("#invoice_no").val();
	purchase.from_warehouse_id = $("#from_warehouse_id").val();
	purchase.to_warehouse_id = $("#to_warehouse_id").val();
	purchase.biller = $("#biller").val();
	 
	var products = [];

	$.each($("#myData tr"), function(index, row){
		debugger;
		var columns = $(row).find("td");
		var product = new Object();
		product.product_id = $(columns[0]).find("input").val();
		product.uom_id = $(columns[3]).find("input").val();
		product.quantity = $(columns[5]).find("input").val();
		product.sale_rate = $(columns[6]).find("input").val();
		product.balance = $(columns[7]).find("input").val();
		//product.balance = $(columns[8]).text();
		products.push(product);
	});
	
	var $_token = jQuery('#token').val();
	jQuery.ajax({
		method: "POST",
		cache: false,
		headers: { 'X-XSRF-TOKEN' : $_token },
		data: {purchase: JSON.stringify(purchase), product_data:products},
		url: "/stock-transfer",
		success: function(result) {
			//if(result == "inserted")
			if(parseInt(result) > 0)
			{
				// window.open("/stock-transfer/print/"+result);
				window.location.href = "/stock-transfer/create";
				
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			$("#spanWait").hide();
			alert(xhr.status);
			alert(thrownError);
		}
	});
	} else {
		        alertify.alert("Not Saved!");
		    }
		});
}
// });

</script>
@stop