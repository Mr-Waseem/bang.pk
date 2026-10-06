@extends("app")
<head>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
</head>
@section("contents")
<body>
<!-- <body onload="AddRowFunction()"> -->
<div class="container-fluid">
	@if (Session::has('flash_message'))
		 <div class="alert alert-success alert-dismissible fade in">
 			<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right: 4%;">&times;</a>
 			<strong>Success!</strong> {{ Session::get('flash_message') }}
  		</div>
	@endif
</div>
<!-- <h1 class="page-title">Purchase Bill</h1>
<ol class="breadcrumb breadcrumb-2"> 
	<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
	<li><a href="/purchases">Purchases</a></li> 
	<li class="active"><strong>Purchase Bill</strong></li> 
</ol> -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading clearfix">
				<h3 class="panel-title">Order Form</h3>
			</div>
			<div class="panel-body">
				<input id="token" type="hidden" value="{{$encrypted_token}}">
				@include('errors.validation')
				{!! Form::open(['url' => 'order-form', 'class' => 'form-horizontal' ]) !!}
				<div class="row">
					<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
						<label class="col-sm-1 control-label">Date</label>  
						<div class="col-sm-2"> 
							<div id="year-view" class="input-group date"> 
								<input id="voucher_date" type="date" name="voucher_date" value="<?php echo date('Y-m-d');?>" class="form-control"> 
								<!-- <span class="input-group-addon"><i class="fa fa-calendar"></i></span>  -->
							</div>
						</div>

						<div class="col-sm-2">
						
						</div>

						<label class="col-sm-1 control-label">Delivery&nbsp;Date</label>  
						<div class="col-sm-2"> 
							<div id="year-view" class="input-group date"> 
								<input id="delivery_date" type="date" name="delivery_date" value="<?php echo date('Y-m-d');?>" class="form-control" autofocus> 
								<!-- <span class="input-group-addon"><i class="fa fa-calendar"></i></span>  -->
							</div>
						</div>
					
													
					</div>
				</div>
			

					<div class="row">
					<div class="form-group" style="margin-left: 1%; margin-right: 1%;">
						<label class="col-sm-1 control-label">Remarks</label>  
						<div class="col-sm-2">
						
							
							{!! Form::text('remarks', null,  ['id' => 'remarks','class'=>'form-control']) !!} 
						</div>
						<div class="col-sm-2" style="display: none;">
						{!! Form::select('shop_id', $warehouse, null, ['id' => 'shop_id', 'class'=>'form-control']) !!}
					</div>
						<label class="col-sm-3 control-label">Bill No</label>  
						<div class="col-sm-2"> 
							 
								{!! Form::text('voucher_no', $codes,  ['id' => 'voucher_no','class'=>'form-control']) !!} 
							
						</div>
					
						 							
					</div>
				</div>
					<!-- <div class="form-group"> 
						<label class="col-sm-3 control-label">Bill No</label>  
						<div class="col-sm-5"> 
						{!! Form::text('bill_no', null, ['id' => 'bill_no','class'=>'form-control']) !!}
						</div> 
					</div> -->
					{!! Form::hidden('biller_id', 1, ['id' => 'biller_id', 'class'=>'form-control']) !!} 
					{!! Form::hidden('v_type', "ORDER FORM", ['id' => 'v_type', 'class'=>'form-control']) !!}
					<input type="hidden" name="biller_id" id="biller_id" value="{{Auth::User()->id}}">
					<div class="row">
					<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
						{!! Form::hidden('account_id', 1, ['id' => 'account_id', 'class'=>'form-control']) !!} 
						<label class="col-sm-1 control-label">Account</label>
						<div class="col-sm-2"> 
								{!! Form::select('suppliers_id', $Account, null, ['id' => 'suppliers_id',  'onchange' => 'javascript:PartyKeyUp($(this).val());', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control', 'required' => 'required']) !!} 
						</div> 
						<!-- <label class="col-sm-1 control-label">Address</label>  --> 
						<div class="col-sm-3">
							{!! Form::text('address', null, ['id' => 'address','class'=>'form-control', 'placeholder' => 'Address', 'disabled' => 'disabled', 'placeholder' => 'Walking Costomer']) !!}
						</div> 
						<!-- <label class="col-sm-1 control-label">NTN</label>  --> 
						<div class="col-sm-2">
							{!! Form::text('city', null, ['id' => 'city','class'=>'form-control', 'placeholder' => 'City', 'disabled' => 'disabled']) !!} 
						</div>							
					</div>
				</div>
					<!-- <div class="row">
					<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
						<label class="col-sm-1 control-label">Account</label>  
						<div class="col-sm-5" style="height: 40px;"> 
						{!! Form::select('suppliers_id', $Account, null, ['id' => 'suppliers_id', 'onchange' =>'GetSupplierID($(this).val());', 'class'=>'form-control']) !!}

						</div> 
					</div>
					</div> -->
					
					<div class="row">
					<div class="col-lg-12">

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
		{!! Form::text('product_codes', null, ['id' => 'product_codes', 'onkeyup' => 'CodeKeyUp($(this).val());', 'class'=>'form-control']) !!}
	</div>
</div> 
<div class="col-md-3" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="Name" class="control-label">Product Name</label> 
		{!! Form::select('product_name', $products, null, ['id' => 'product_name',  'onchange' => 'productMouseUp($(this).val().split("_")[0]);','class'=>'form-control']) !!}
	</div> 
</div> 
 
<div class="col-md-1" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="Name" class="control-label">Packing</label> 
		{!! Form::select('uom_id', $uoms, null, ['id' => 'uom_id', 'class'=>'form-control']) !!}
	</div> 
</div>
<div class="col-md-1" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Quantity</label> 
		{!! Form::text('quantity', 1, ['id' => 'quantity', 'class'=>'form-control']) !!}
	</div> 
</div>
<div class="col-md-1" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Price</label> 
		{!! Form::text('price', null, ['id' => 'price', 'class'=>'form-control']) !!}
	</div> 
</div>
 <div class="col-md-1" style="margin-left: 1%; margin-right: 1%; display:none;"> 
	<div class="form-group"> 
		<label for="Warehouse" class="control-label">Warehouse</label> 
		{!! Form::select('warehouse_id', $warehouse, null, ['id' => 'warehouse_id', 'class'=>'form-control livesearch'])!!}
	</div> 
</div>
<div class="col-md-2"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Payment&nbsp;Terms</label> 
		{!! Form::text('total', null, ['id' => 'total', 'class'=>'form-control']) !!}
	</div> 
</div>

<div class="col-md-1" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Add</label>
		 <button class="form-control" style="background: #27ba39;" type="button" onkeyup="AddGridData();">Add</button> 
		 <!-- <button type="button" onclick="AddGridData()" class="btn btn-red"><i class="fa fa-plus"></i> </button> -->
	</div> 
</div>



</tr>
<table id="myData">
</table>
</div>
</div>
</table></br></br>
	</div>
		</div>
		</div>
		 <div class="row" style="display: none;">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading clearfix" id="panelbg">
						<div class="container">
						  <div class="col-lg-5"><button type="button" onclick="TotalRecords()" class="btn btn-warning">Total Records</button>  </div>
						  
						  <div class="col-lg-2"> <b style="color: black;">Total Rate</b> <input type="text" id="TotalRate" name="TotalRate" value="0" style="color: black;" disabled> </div>
						  <div class="col-lg-3"> <b style="color: black;">Total Amount</b> <input type="text" id="TotalAmount" name="TotalAmount" value="0" style="color: black;" disabled> </div>
						</div> 
					</div>
				</div>
			</div>
		</div>


		</div>
	</div>
				<center><div class="form-actions">
			  <button type="submit" class="btn btn-primary">Save</button>
			</div></center>		
			<!-- <div class="col-lg-3">
				<button type="button" onclick="AddRowFunction()" class="btn btn-success"><i class="fa fa-plus"></i> </button>
				<button type="button" onclick="TotalRecords()" class="btn btn-success">Total Records</button>
			</div> -->			
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

	$("#warehouse_id").select2();
       $("#warehouse_id").next(".select2").find(".select2-selection").focus(function() {
       $("#warehouse_id").select2("open");
   });

       $("#suppliers_id").select2();
       $("#suppliers_id").next(".select2").find(".select2-selection").focus(function() {
       $("#suppliers_id").select2("open");
   });

        $("#product_name").select2();
       $("#product_name").next(".select2").find(".select2-selection").focus(function() {
       $("#product_name").select2("open");
   });

       $("#uom_id").select2();
       $("#uom_id").next(".select2").find(".select2-selection").focus(function() {
       $("#uom_id").select2("open");
   });

       $("#purchase_type").select2();
       $("#purchase_type").next(".select2").find(".select2-selection").focus(function() {
       $("#purchase_type").select2("open");
   });

       function TotalRecords() {
		var rowCount = document.getElementById('myData').rows.length;
		alert("Total Number of Records Are: " + rowCount);
	}



function GetSupplierID(value)
{
	document.getElementById('account_id').value = value;
}

	function PartyKeyUp(partyId){
		$.ajax({
			type: "GET",
			url: "/partyonchange-ajax?party_id=" + partyId,
			success:function(result)
			{
				if(result.length > 0){
					$('#account_id').val(result[0].id);
					$('#address').val(result[0].address);
					$('#strn').val(result[0].strn);
					$('#ntn').val(result[0].ntn);
					$('#city').val(result[0].city);
				}
			}
		})
	}



function QuantityKeyUp(quantity){
			var price = document.getElementById('price').value;
			var tax = document.getElementById('tax_id').value.split("_").pop();
			var taxvalue = tax/100*price*quantity;
			total = (quantity * price) + taxvalue;
			document.getElementById('total').value = total;
		}
function PriceKeyUp(price){
			var quantity = document.getElementById('quantity').value;
			var tax = document.getElementById('tax_id').value.split("_").pop();
			var taxvalue = tax/100*price*quantity;
			total = (quantity * price) + taxvalue;
			document.getElementById('total').value = total;
		}
		function CalculateTax(tax){
			
			var quantity = document.getElementById('quantity').value;
			var price = document.getElementById('price').value;
			var taxvalue = tax/100*price*quantity;
			total = (quantity * price) + taxvalue;
			document.getElementById('total').value = total;
		}
		

	

	function myDeleteFunction(row) {
		alertify.confirm("Are you sure you want to delete this Record?", function (e) {
    if (e) {
    		var TotalRate = document.getElementById('TotalRate').value;
	    	var TotalAmount = document.getElementById('TotalAmount').value;

			var rate = $(row).find("td:eq('6')").find("input").val();
			var amount = $(row).find("td:eq('8')").find("input").val();

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
		var ProductId = document.getElementById('product_id').value;
		var ProductCode = document.getElementById('product_codes').value;
		var ProductName = document.getElementById('product_name').value.split("_").pop();
		//var Tax = document.getElementById('tax_id').value.split("_").pop();
		// var TaxID = document.getElementById('tax_id').value.split("_")[0];
		//var UOM = document.getElementById('uom').value;
		var UOMID = document.getElementById('uom_id').value.split("_")[0];
		var UOM = document.getElementById('uom_id').value.split("_").pop();
		var Quantity = document.getElementById('quantity').value;
		var Price = document.getElementById('price').value;
		var warehouse_id = document.getElementById('warehouse_id').value;
		var Total = document.getElementById('total').value;

		// document.getElementById('TotalRate').value = Price;
		// document.getElementById('TotalAmount').value = Total;

		var TotalRate = document.getElementById('TotalRate').value;
		var totalAmount = document.getElementById('TotalAmount').value;
		// alert(TotalRate)
		// alert(totalAmount)


		var grandRate = parseInt(Price) + parseInt(TotalRate);
		var grandAmount = parseInt(Total) + parseInt(totalAmount);

		document.getElementById('TotalRate').value = grandRate;
		document.getElementById('TotalAmount').value = grandAmount;

		var tableHtml = '<tr>';
		// tableHtml += '<td class="text-center"><i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-cancel icon-larger red-color" title="Delete Row"></i> </td>';var TotalRate = document.getElementById('TotalRate').value;
		//tableHtml += '<td>'+ ProductId +'</td>';
		tableHtml += `<td style="display:none;"><input id="product_id" name="product_id[]" value="${ProductId}" type="text"  class="form-control"></td>`;
		//tableHtml += '<td>'+ ProductCode +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input value="${ProductCode}" type="text" class="form-control" style="margin-left: 7%; width: 53%;" disabled></td>`;
		//tableHtml += '<td>'+ ProductName +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input value="${ProductName}" type="text" class="form-control" style="margin-left:-27%; width: 160%;" disabled></td>`;
		//tableHtml += '<td>'+ UOMID +'</td>';
		tableHtml += `<td style="display:none;"><input type="text"  id="packing_id" name="packing_id[]" value="${UOMID}" class="form-control"></td>`;
		//tableHtml += '<td>'+ UOM +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input value="${UOM}" type="text" class="form-control" style="margin-left:46%; width: 54%;" disabled></td>`;
		//tableHtml += '<td>'+ Quantity +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input type="text" id="quantity" name="quantity[]" value="${Quantity}" class="form-control" style="margin-left:13%; width: 54%;"></td>`;
		//tableHtml += '<td>'+ Price +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="price" name="price[]" value="${Price}" type="text" class="form-control" style="margin-left:-21%; width: 107%;"></td>`;


		//tableHtml += '<td>'+ Total +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="terms" name="terms[]" value="${Total}" type="text" class="form-control" style="margin-left:-7%; width: 109%;"></td>`;
		tableHtml += '<td style="padding-top: 20px;"><button class="btn btn-red" type="button" style="margin-left: 80%;"> <i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-trash" title="Delete Row"></i></button></td>';
		tableHtml += '</tr></br>';
		$('#myData').append(tableHtml);
		document.getElementById("product_code").focus();
	}

	function GRNMouseUp(value){
	$.ajax({
		type: "GET",
		url: "/grnmouseup-ajax?grn_no=" + value,
		success: function(data){
			if(data.length > 0)
			{
				var partyID = data[0].account_id;
				//var partyName = data[0].party_name;
				document.getElementById("account_id").value = partyID;
				//document.getElementById("suppliers_id").value = partyName;
				document.getElementById("suppliers_id").value = partyID;

				$.each(data, function(key, value){
					var tableHtml = '<tr>';
		// tableHtml += '<td class="text-center"><i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-cancel icon-larger red-color" title="Delete Row"></i> </td>';
		//tableHtml += '<td>'+ ProductId +'</td>';
		tableHtml += `<td style="display:none;"><input id="test" value="" type="text" class="form-control" disabled></td>`;
		//tableHtml += '<td>'+ ProductCode +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="test" value="" type="text" class="form-control" style="margin-left: 7%; width: 60%;" disabled></td>`;
		//tableHtml += '<td>'+ ProductName +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="test" value="" type="text" class="form-control" style="margin-left:-19%; width: 180%;" disabled></td>`;
		//tableHtml += '<td>'+ UOMID +'</td>';
		tableHtml += `<td style="display:none;"><input id="test" value="" type="text" class="form-control" disabled></td>`;
		//tableHtml += '<td>'+ UOM +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="test" value="" type="text" class="form-control" style="margin-left:74%; width: 60%;" disabled></td>`;
		//tableHtml += '<td>'+ Quantity +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="test" value="" type="text" class="form-control" style="margin-left:48%; width: 60%;" disabled></td>`;
		//tableHtml += '<td>'+ Price +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="test" value="" type="text" class="form-control" style="margin-left:22%; width: 120%;" disabled></td>`;
		//tableHtml += '<td>'+ Total +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="test" value="" type="text" class="form-control" style="margin-left:49%; width: 118%;" disabled></td>`;
		tableHtml += '<td><button class="btn btn-red" type="button" style="margin-left: 320%;"> <i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-trash" title="Delete Row"></i></button></td>';
		tableHtml += '</tr></br>';
		$('#myData').append(tableHtml);
                    // $("#GridTable tr").append("<td>" +
                    //                     "ID :" + value.pr_no +
                    //                     "Name :"+ value.pr_no +
                    //                     "Age :" + value.pr_no + 
                    //                     "</td>");
                                      
                });
			}
		}
	})

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

	function productMouseUp(productID, rowIndex){
		
		//var productID = document.getElementById('product_name').value.split("_")[0];
		//alert(productID)
		$.ajax({
			type: "GET",
			url: "/productmouseup-ajax?product_ID=" + productID,
			success: function(result) {
				if(result.length > 0)
				{
				$('#product_codes').val(result[0].product_code);
				$('#uom').val(result[0].uom);
				$('#product_id').val(result[0].id);
				$('#price').val(result[0].product_cost);
				var price = $("#price").val();
				var quantity = $("#quantity").val();
				//var total = price * quantity;
				//document.getElementById('total').value = total;
				}	
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}				
		});
}



$("#btnSave").click(function()
{
	 if($("#account_id").val() ==""){
	  	alert('Select Supplier Account First!');
         e.preventdefault();
	  }
	  alertify.confirm("Are you sure you want add Purchase Bill?", function (e) {
	if (e)
	{
	var purchase = new Object();
	purchase.account_id = $("#account_id").val();
	
	purchase.warehouse_id = $("#warehouse_id").val();
	purchase.date = $("#date").val();
	purchase.bill_no = $("#bill_no").val();
	purchase.grn_no = $("#grn_no").val();
	if($("#account_id").val() == "1"){
	purchase.purchase_type = "Cash Purchase";
}else{
	purchase.purchase_type = "Credit Purchase";
}
	if($("#due_date").val() != ""){
	 purchase.due_date = $("#due_date").val();
	 purchase.particulars = $("#particulars").val();
	}

	var products = [];
	$.each($("#myData tr"), function(index, row){
		var columns = $(row).find("td");
		var product = new Object();
		product.product_id = $(columns[0]).find("input").val();
		// product.tax_id = $(columns[3]).find("select").val().split("_")[0];
		// product.tax_id = $(columns[9]).text();
		product.uom_id = $(columns[3]).find("input").val();
		product.quantity = $(columns[5]).find("input").val();
		product.unit_cost = $(columns[6]).find("input").val();
		product.warehouse_id = $(columns[7]).find("select").val();
		product.total_cost = $(columns[8]).find("input").val();

		//Code & product only for validation, not insertion
		//product.code = $(columns[1]).find("input").val();
		//product.product_name = $(columns[2]).find("input").val();
		// if($(columns[1]).find("input").val()=="" || $(columns[2]).find("input").val()==""){
		// 	alert('Fill the Code & Product Correctly First!');
  //          e.preventdefault();
		// 	}
		//validation
		// if($(columns[3]).find("input").val() =="" || $(columns[4]).find("input").val() =="" | $(columns[5]).find("input").val() =="" || $(columns[6]).find("input").val() ==""){
		// 	alert('Fill the Fields Correctly First!');
  //          e.preventdefault();
		// 	}
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
				//alert("Purchase successfully saved.");
				//window.open("/purchases/print/"+result);
				window.location.href = "/purchases/create";
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
});

		// $('#date').datepicker({
		// 			startView: 0,
		// 			keyboardNavigation: false,
		// 			forceParse: false,
		// 			format: "dd/mm/yyyy"
		// 		});

</script>
@stop