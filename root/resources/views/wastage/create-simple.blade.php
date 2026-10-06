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
<div class="row" style="margin-top: -2%;">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading clearfix" id="panelbg">
				<h2 class="panel-title"><b>Add Wastage</b></h2>
				<!-- <ul class="panel-tool-options"> 
					<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
					<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
					<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
				</ul> -->
			</div>
		<div class="panel-body">
			<input id="token" type="hidden" value="{{$encrypted_token}}">
			@include('errors.validation')
			{!! Form::open(['url' => 'wastage', 'class' => 'form-horizontal' ]) !!}
				<div class="row">
					<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
						<label class="col-sm-1 control-label">Date</label>  
						<div class="col-sm-2"> 
							<div id="year-view" class="input-group date"> 
								<input id="date" type="date" name="date" value="<?php echo date('Y-m-d');?>" class="form-control" onkeyup = "focusNext(event);"> 
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</div>
						</div>

						<label class="col-sm-3 control-label">Bill&nbsp;No#</label>  
					<div class="col-sm-2" style="margin-left: -6px;"> 
						{!! Form::text('invoice_no', $codes, ['id' => 'invoice_no','class'=>'form-control', 'required' => 'required', 'onkeyup' => 'focusNext(event);']) !!}
					</div> 						
					</div>
				</div>


				<div class="form-group" style="margin-left: 0px;"> 
					<label class="col-sm-1 control-label">Account</label>
						<div class="col-sm-2"> 
								{!! Form::select('party_name', $customers, null, ['id' => 'party_name',  'onchange' => 'javascript:PartyKeyUp($(this).val());', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control', 'required' => 'required']) !!}   
				</div>
					<label class="col-sm-1 control-label">Shop</label>  
					<div class="col-sm-2"> 
						

					  {!! Form::select('warehouse_id', $warehouse, null, ['id' => 'warehouse_id', 'class'=>'form-control', 'required' => 'required']) !!} 
							 
						
					</div>
					
				<div class="form-group" style="display:none;"> 
					<label class="col-sm-3 control-label">Biller</label>  
					<div class="col-sm-5"> 
					  <select name="biller" id="biller" class="form-control" disabled>
						<option value="{{ Auth::user()->id }}">{{ Auth::user()->name}}</option>
					  </select>
					</div> 
				</div>
				<div class="row" style="">
					<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
						<label class="col-sm-1 control-label">Voucher&nbsp;Type</label>
						<div class="col-sm-2"> 
								{!! Form::select('sale_list', array('Wastage' => 'Wastage', 'Adjust' => 'Adjust'), null, ['id' => 'sale_list', 'class'=>'form-control']) !!}
						</div> 
						 		

					</div>
				</div>
				
				{!! Form::hidden('party_id', 1, ['id' => 'party_id', 'class'=>'form-control']) !!}
					
<div class="panel panel-default">
 	
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
		{!! Form::text('product_code', null, ['id' => 'product_code', 'onkeyup' => 'ProductKeyUp($(this).val()); if(event.keyCode == 107) SaveFunction()', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control', 'autofocus' => 'autofocus', 'onfocus' => 'this.value=""']) !!}
	</div>
</div> 
<div class="col-md-3" style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="Name" class="control-label">Product Name</label> 
		{!! Form::text('product_name', null, ['id' => 'product_name', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control']) !!}
	</div> 
</div>
<div id="countryList">
    </div> 
<div class="col-md-1" style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="Name" class="control-label">Unit</label> 
		{!! Form::select('uom_id', $uoms, null, ['id' => 'uom_id', 'class'=>'form-control', 'onkeydown' => 'focusNext(event);', 'disabled' => 'disabled']) !!}
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
		<label for="password" class="control-label">Sale Rate</label> 
		{!! Form::text('price_per_unit', null, ['id' => 'price_per_unit', 'onkeyup' => 'SaleRate($(this).val())','class'=>'form-control', 'onkeydown' => 'focusNext(event);', 'disabled' => 'disabled']) !!}
	</div> 
</div>
<div class="col-md-2"style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Sale Amount</label> 
		{!! Form::text('balance', null, ['id' => 'balance', 'class'=>'form-control', 'onkeydown' => 'focusNext(event);', 'onkeyup' => 'TotalKeyUp();']) !!}
	</div> 
</div>
{!! Form::hidden('product_cost', null, ['id' => 'product_cost', 'class'=>'form-control']) !!}
{!! Form::hidden('cost_amount', null, ['id' => 'cost_amount', 'class'=>'form-control']) !!}
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
	</table>
	
	  </div>
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading clearfix" id="panelbg">
						<div class="container">
						  <div class="col-lg-5"><button type="button" onclick="TotalRecords()" class="btn btn-warning">Total Records</button>  </div>
						  <!-- <div class="col-xs-3">  </div> -->
						  <div class="col-lg-2" style="display: none;"> <b style="color: black;">Total Rate</b> <input type="text" id="TotalRate" name="TotalRate" value="0" style="color: black;" disabled> </div>
						  <div class="col-lg-3"> <b style="color: black;">Total Amount</b> <input type="text" id="TotalAmount" name="TotalAmount" value="0" style="color: black; font-size: 20px;" disabled> </div>
						  <div class="col-lg-2"> <b style="color: black;">Receive Amount</b> <input type="text" id="ReceiveAmount" name="ReceiveAmount" value="0" style="color: black; font-size: 20px;"> </div>
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

<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>
<script type="text/javascript">
	$(".livesearch").chosen();
</script> -->

<script type="text/javascript">

	$(document).ready(function(){

 $('#product_name').keyup(function(){ 
        var query = $(this).val();
        if(query != '')
        {
         var _token = $('input[name="_token"]').val();
         $.ajax({
          url:"{{ route('autocomplete.fetch') }}",
          method:"POST",
          data:{query:query, _token:_token},
          success:function(data){
           $('#countryList').fadeIn();  
                    $('#countryList').html(data);
          }
         });
        }
    });

    $(document).on('click', 'li', function(){  
        $('#country_name').val($(this).text());  
        $('#countryList').fadeOut();  
    });  

});

function QtyChange(qty, RowIndex){
	 var cost = $('tr:eq(' + RowIndex + ')', myData).find("td:eq('5')").find('input').val();
	 var totalcost = cost*qty;
	 //totalcose
	 $('tr:eq(' + RowIndex + ')', myData).find("td:eq('7')").find('input').val(totalcost);

	 var rate = $('tr:eq(' + RowIndex + ')', myData).find("td:eq('10')").find('input').val();
	var totalrate = rate*qty;
	$('tr:eq(' + RowIndex + ')', myData).find("td:eq('11')").find('input').val(totalrate);
}

function salerate(rate, RowIndex){
	var qty = $('tr:eq(' + RowIndex + ')', myData).find("td:eq('6')").find('input').val();
	var totalrate = rate*qty;
	$('tr:eq(' + RowIndex + ')', myData).find("td:eq('11')").find('input').val(totalrate);
}

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

var idArray = ["date", "sale_type", "invoice_no", "localExport", "party_name", "product_code", "product_name", "quantity", "balance", "add"];
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

      $("#party_name").select2();
       $("#party_name").next(".select2").find(".select2-selection").focus(function() {
       $("#party_name").select2("open");
   });

        $("#sale_list").select2();
       $("#sale_list").next(".select2").find(".select2-selection").focus(function() {
       $("#sale_list").select2("open");
   });

       $("#warehouse_id").select2();
       $("#warehouse_id").next(".select2").find(".select2-selection").focus(function() {
       $("#warehouse_id").select2("open");
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



	var cost = document.getElementById('product_cost').value;
			totalCost = (Quantity * cost);
			document.getElementById('cost_amount').value = totalCost;
}


	function TotalRecords() {
		var rowCount = document.getElementById('myData').rows.length;
		alert("Total Number of Records Are: " + rowCount);
	}

		// For Differnt Product Rate  
	function ProductKeyUp(productCode){
		var Customerid = document.getElementById('party_id').value;
		$.ajax({
			type: "GET",
			// url: "/productkeyup-ajax?prodCode=" + productCode,
			url: "/productrate-ajax",
			//data: 'prodCode='+productCode+'Customerid='+Customerid,
			data: { prodCode: productCode, Customerid: Customerid },
			success: function(result) {
				if(result.length > 0)
				{
					//$('#product_code').val(result[0].product_code);
					// $('#product_name').val(result[0].product.product_name);
					$('#product_name').val(result[0].product.product_name);
					$('#product_id').val(result[0].product.id);
					//$("#product_cost").val(result[0].unit_cost);
					$("#product_cost").val(result[0].product.product_cost);
					$("#price_per_unit").val(result[0].rate);

					var price = $("#price_per_unit").val();
					var quantity = $("#quantity").val();
					var cost = $("#product_cost").val();
					var CostAmount= cost * quantity;
					//alert(CostAmount)
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



	// For Normal Product 
	function ProductKeyUp_BACKUP(productCode){
		$.ajax({
			type: "GET",
			url: "/productkeyup-ajax?prodCode=" + productCode,

			success: function(result) {
				if(result.length > 0)
				{
					//$('#product_code').val(result[0].product_code);
					$('#product_name').val(result[0].product_name);
					$('#product_id').val(result[0].id);
					//$("#product_cost").val(result[0].unit_cost);
					$("#product_cost").val(result[0].product_cost);
					$("#price_per_unit").val(result[0].product_price);

					var price = $("#price_per_unit").val();
					var quantity = $("#quantity").val();
					var cost = $("#product_cost").val();
					var CostAmount= cost * quantity;
					//alert(CostAmount)
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


		function SaleRate(salerate){
			var quantity = document.getElementById('quantity').value;
			var price = document.getElementById('price_per_unit').value;
			var total = quantity*salerate;
			document.getElementById('balance').value = total;


		}

		function QuantityKeyUp(quantity){
			var price = document.getElementById('price_per_unit').value;
			var cost = document.getElementById('product_cost').value;
			total = (quantity * price);
			totalCost = (quantity * cost);
			document.getElementById('cost_amount').value = totalCost;
			document.getElementById('balance').value = total;
		}

		function DiscountKeyUp(discount, discountID){
			var price = document.getElementById('price_per_unit').value;
			var cost = document.getElementById('product_cost').value;
			var quantity = document.getElementById('quantity').value;
			var CostAmount = quantity * cost;
			var totalDiscount = discount/100*price*quantity;
			//alert(totalDiscount)
			document.getElementById('cost_amount').value = CostAmount;
			total = (quantity * price);
			document.getElementById('balance').value = total-totalDiscount;
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
				var rate = $(row).find("td:eq('6')").find("input").val();
				var amount = $(row).find("td:eq('7')").find("input").val();
				// alert(rate)
				// alert(amount)
				// alert(TotalRate)
				// alert(TotalAmount)
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
		var Cost = document.getElementById('product_cost').value;
		var CostAmount = document.getElementById('cost_amount').value;
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
		tableHtml += `<td style="padding-top:6px;"><input id="test" value="${ProductCode}" type="text" class="form-control" style="margin-left: 7%; width: 53%;" disabled></td>`;
    	//2
		//tableHtml += '<td>'+ ProductName +'</td>';
		tableHtml += `<td style="padding-top:6px;"><input id="test" value="${ProductName}" type="text" class="form-control" style="margin-left: -33%;
    width: 161%;" disabled></td>`;
    	//3
    tableHtml += `<td style="display:none;"><input id="test" value="${UOMID}" type="text" class="form-control" style="margin-left: -25%;
    width: 120%;" disabled></td>`;
    	//4
    tableHtml += `<td style="padding-top:6px;"><input id="test" value="${UOM}" type="text" class="form-control" style="margin-left: 34%;
    width: 53%;" disabled></td>`;
    	//5
		//6
		//tableHtml += '<td>'+ Quantity +'</td>';
		tableHtml += `<td style="padding-top:6px;"><input id="test" value="${Quantity}" type="text" class="form-control" style="margin-left: -6%; width: 54%;" disabled></td>`;
		//tableHtml += '<td>'+ CostAmount +'</td>';

    	//10
		// tableHtml += '<td>'+ Price +'</td>';
		 tableHtml += `<td style="padding-top:6px;"><input id="test" value="${Price}" type="text" class="form-control" style="margin-left:-45%; width: 107%;" disabled></td>`;
		 //11
		 tableHtml += `<td style="padding-top:6px;"><input id="test" value="${Amount}" type="text" class="form-control" style="margin-left: -32%;
    width: 107%;" disabled></td>`;

    tableHtml += `<td style="padding-top:6px; display:none;"><input id="test" value="${Cost}" type="text" class="form-control" style="margin-left: -32%;
    width: 107%;" disabled></td>`;

    tableHtml += `<td style="padding-top:6px; display:none;"><input id="test" value="${CostAmount}" type="text" class="form-control" style="margin-left: -32%;
    width: 107%;" disabled></td>`;
		// document.getElementById('test').value=Price;
		// tableHtml += '<td>'+ Amount +'</td>';
		//12

		tableHtml += '<td style="padding-top: 6px;"><button class="btn btn-red" type="button" style="margin-left: -80%;"> <i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-trash" title="Delete Row"></i></button></td>';
		tableHtml += '</tr>';
		$('#myData').append(tableHtml);
		document.getElementById("product_code").focus();
	}

// $("#btnSave").click(function()
//{
	function SaveFunction(){
	if($("#party_id").val() ==""){
	  	alert('Select Customer Account First!');
         e.preventdefault();
	  }

	var test = $("#party_id").val();
	var purchase = new Object();
	purchase.date = $("#date").val();
	if($("#due_date").val() != ""){
	purchase.due_date = $("#due_date").val();
	purchase.particulars = $("#particulars").val();
	}
	purchase.party_id = $("#party_id").val();
	if($("#party_id").val() == "1"){
	purchase.sale_type = "Cash Sale";
}else{
	purchase.sale_type = "Credit Sale";
}
	purchase.sale_list = $("#sale_list").val();
	purchase.sample_description = $("#sample_description").val();
	purchase.dcn_no = $("#dcn_no").val();
	purchase.warehouse_id = $("#warehouse_id").val();
	purchase.invoice_no = $("#invoice_no").val();
	purchase.localExport = $("#localExport").val();
	purchase.biller = $("#biller").val();
	purchase.ReceiveAmount = $("#ReceiveAmount").val();
	 
	var products = [];
	$.each($("#myData tr"), function(index, row){
		var columns = $(row).find("td");
		var product = new Object();
		product.party_id = $("#party_id").val();
		product.product_id = $(columns[0]).find("input").val();
		product.product_code = $(columns[1]).find("input").val();
		product.uom_id = $(columns[3]).find("input").val();
		product.product_cost = 0.00;
		product.quantity = $(columns[5]).find("input").val();
		product.cost_amount = 0.00;
		product.discount_id = 1;
		product.sale_rate = $(columns[6]).find("input").val();
		product.balance = $(columns[7]).find("input").val();
		product.product_cost = $(columns[8]).find("input").val();
		product.cost_amount = $(columns[9]).find("input").val();
		//product.balance = $(columns[8]).text();
		products.push(product);
	});
	
	var $_token = jQuery('#token').val();
	jQuery.ajax({
		method: "POST",
		cache: false,
		headers: { 'X-XSRF-TOKEN' : $_token },
		data: {purchase: JSON.stringify(purchase), product_data:products},
		url: "/wastage",
		
		success: function(result) {
			//if(result == "inserted")
			if(parseInt(result) > 0)
			{
				// window.open("/sales/print/"+result);
				window.location.href = "/wastage/create";
				//window.open("/sales/print/"+result);
				
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			$("#spanWait").hide();
			alert(xhr.status);
			alert(thrownError);
		}
	});

}




</script>
@stop