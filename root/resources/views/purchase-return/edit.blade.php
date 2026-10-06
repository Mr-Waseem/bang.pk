@extends("app")
@section("contents")
<body>
<!-- <body onload="AddRowFunction()"> -->
<div class="container-fluid">
	@if (Session::has('flash_message'))
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="margin-right: 20px;margin-top: 15px;">&times;</button>
		<div class="alert alert-success"> {{ Session::get('flash_message') }} </div>
	@endif
</div>
<h1 class="page-title">Edit Purchase Bill</h1>
<!-- Breadcrumb -->
<ol class="breadcrumb breadcrumb-2"> 
	<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
	<li><a href="/purchases">Purchases</a></li> 
	<li class="active"><strong>Edit Purchase Bill</strong></li> 
</ol>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading clearfix">
				<h3 class="panel-title">Edit Purchase Bill</h3>
				<!-- <ul class="panel-tool-options"> 
					<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
					<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
					<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
				</ul> -->
			</div>
			<div class="panel-body">
				<input id="token" type="hidden" value="{{$encrypted_token}}">
				@include('errors.validation')
				{!! Form::open(['url' => 'purchases', 'class' => 'form-horizontal' ]) !!}
				<div class="row">
					<div class="form-group"> 
						<label class="col-sm-1 control-label">Date</label>  
						<div class="col-sm-2"> 
							<div id="year-view" class="input-group date"> 
								<!-- <input id="date" type="date" name="date" value="<?php echo date('Y-m-d');?>" class="form-control"> -->
								 {!! Form::date('date', $edit->date, ['id' => 'date', 'class'=>'form-control']) !!}
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</div>
						</div>
					
						<label class="col-sm-1 control-label">Purchase&nbsp;Type</label>  
						<div class="col-sm-2"> 
							<select class="form-control" onchange="LedgerValues();" id="purchase_type" name="purchase_type">
								<option value="Purchase Return">Purchase Return</option>
								<!-- <option value="Credit Purchase">Credit Purchase</option> -->
							</select>
							<!-- {!! Form::select('purchase_type', array('Cash Purchase' => 'Cash Purchase', 'Credit Purchase' => 'Credit Purchase'), $edit->purchase_type, ['id' => 'purchase_type', 'onchange' => 'LedgerValues($(this).val())', 'class'=>'form-control']) !!} -->
						</div> 							
					</div>
				</div>
				<div class="row" id="ledgerRow" style="display:none;">
					<div class="form-group"> 
						<label class="col-sm-1 control-label">Due&nbsp;Date</label>  
						<div class="col-sm-2"> 
							<div id="year-view" class="input-group date"> 
								<!-- <input id="due_date" type="date" name="due_date" class="form-control"> -->
								{!! Form::date('due_date', $edit->due_date, ['id' => 'due_date', 'class'=>'form-control']) !!} 
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
							</div>
						</div>
					
						<label class="col-sm-1 control-label"></label>  
						<div class="col-sm-2">
							{!! Form::text('particulars', $edit->particulars, ['id' => 'particulars', 'placeholder' => 'Description','class'=>'form-control']) !!}
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
					<div class="row">
					<div class="form-group"> 
						<label class="col-sm-1 control-label">Bill No</label>  
						<div class="col-sm-2"> 
							<div id="year-view" class="input-group date"> 
								{!! Form::text('bill_no', $edit->bill_no, ['id' => 'bill_no','class'=>'form-control', 'autofocus'=>'autofocus']) !!} 
							</div>
						</div>
					
						<label class="col-sm-1 control-label">GRN No</label>  
						<div class="col-sm-2">
							{!! Form::select('grn_no', $grns, $edit->grn_no, ['id' => 'grn_no', 'onchange' => 'GRNMouseUp($(this).val());', 'class'=>'form-control livesearch', 'disabled' => 'disabled']) !!}
						</div> 							
					</div>
				</div>
					<!-- <div class="form-group"> 
						<label class="col-sm-3 control-label">Bill No</label>  
						<div class="col-sm-5"> 
						{!! Form::text('bill_no', null, ['id' => 'bill_no','class'=>'form-control']) !!}
						</div> 
					</div> -->
					<div class="form-group" style="display:none;"> 
						<label class="col-sm-1 control-label">Account ID</label>  
						<div class="col-sm-5" style="height: 40px;"> 
						{!! Form::text('account_id', $edit->account_id, ['id' => 'account_id', 'class'=>'form-control']) !!}

						</div> 
					</div>
					<div class="form-group"> 
						<label class="col-sm-1 control-label">Account</label>  
						<div class="col-sm-5" style="height: 40px;"> 
						{!! Form::select('suppliers_id', $Account, $edit->account_id, ['id' => 'suppliers_id', 'onchange' =>'GetSupplierID($(this).val());', 'class'=>'form-control livesearch']) !!}

						</div> 
					</div>
					
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
		{!! Form::text('product_code', null, ['id' => 'product_code', 'onkeyup' => 'CodeKeyUp($(this).val());', 'class'=>'form-control']) !!}
	</div>
</div> 
<div class="col-md-3" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="Name" class="control-label">Product Name</label> 
		{!! Form::select('product_name', $products, null, ['id' => 'product_name',  'onchange' => 'productMouseUp($(this).val());','class'=>'form-control livesearch']) !!}
	</div> 
</div> 
<div class="col-md-2" style="display:none;"> 
	<div class="form-group"> 
		<label for="Name" class="control-label">Tax Rate</label> 
		{!! Form::select('tax_id', $taxes, null, ['id' => 'tax_id',  'onchange' => 'javascript:CalculateTax($(this).val().split("_").pop(), $(this).closest(\'tr\').index())','class'=>'form-control']) !!}
	</div> 
</div> 
<div class="col-md-1" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="Name" class="control-label">Unit</label> 
		{!! Form::select('uom_id', $uoms, null, ['id' => 'uom_id', 'class'=>'form-control']) !!}
	</div> 
</div>
<div class="col-md-1" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Quantity</label> 
		{!! Form::text('quantity', 1, ['id' => 'quantity', 'onkeyup' => 'QuantityKeyUp($(this).val())', 'class'=>'form-control']) !!}
	</div> 
</div>
<div class="col-md-2" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Price</label> 
		{!! Form::text('price', null, ['id' => 'price','onkeyup' => 'PriceKeyUp($(this).val())', 'class'=>'form-control']) !!}
	</div> 
</div>
<div class="col-md-2" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Total</label> 
		{!! Form::text('total', null, ['id' => 'total','onkeyup' => 'AddGridData()', 'class'=>'form-control']) !!}
	</div> 
</div>

</tr>
</div>
<table id="myData">
		<?php $totalRate = 0; $totalAmount = 0; ?>
		@foreach($edit->purchase_return_detail as $purchaseDetail) 
		<tr>
		<td style="display:none;">
			<input id="test" value="{{$purchaseDetail->product_id}}" type="text" class="form-control" disabled>
		</td>
		<td style="padding-top:20px;">
			<input id="test" value="{{$purchaseDetail->products->product_code}}" type="text" class="form-control" style="margin-left: 7%; width: 60%;" disabled>
		</td> 
		<td style="padding-top:20px;">
			<input id="test" value="{{$purchaseDetail->products->product_name}}" type="text" class="form-control" style="margin-left:-19%; width: 180%;" disabled>
		</td>
		<td style="display:none;">
			<input id="test" value="{{$purchaseDetail->uom_id}}" type="text" class="form-control" style="margin-left: -25%;
	    	width: 120%;" disabled>
		</td>
	    <td style="padding-top:20px;">
	    	<input id="test" value="{{$purchaseDetail->unit->uom}}" type="text" class="form-control" style="margin-left:74%; width: 60%;" disabled>
		</td>
	    <td style="padding-top:20px;">
	    	<input id="test" value="{{$purchaseDetail->quantity}}" type="text" class="form-control" style="margin-left:48%; width: 60%;" disabled>
	    </td>
	    <td style="padding-top:20px;">
	    	<input id="test" value="{{$purchaseDetail->unit_cost}}" type="text" class="form-control" style="margin-left:22%; width: 120%;" disabled>
	    </td>

	    <td style="padding-top:20px;">
	    	<input id="test" value="{{$purchaseDetail->total_cost}}" type="text" class="form-control" style="margin-left:55%; width: 119%;" disabled>
	    </td>
	    <!-- <td style="padding-top:20px;">
	    	<input id="test" value="{{$purchaseDetail->sale_amount}}" type="text" class="form-control" style="margin-left: -19%;
	    	width: 78%;" disabled>
		</td> -->
	    <td style="padding-top:20px;"><button class="btn btn-red" type="button" style="margin-left: 345%;"> <i onclick="javascript:myDeleteFunction($(this).closest('tr'));" class="icon-trash" title="Delete Row"></i></button></td>
		</td> 
		<?php $totalRate = $totalRate + $purchaseDetail->unit_cost; ?>
	    <?php $totalAmount = $totalAmount + $purchaseDetail->total_cost; ?>
		</tr> 
		@endforeach
	
	</table>

</div>
</table></br></br>
	</div>
		</div>
		</div>
<div class="row">
<div class="col-lg-12">
	<div class="panel panel-default">
		<div class="panel-heading clearfix">
			<div class="container">
			  <div class="col-xs-3" style="">  </div>
			  <div class="col-xs-3" style="">  </div>
			  <div class="col-xs-3" style=""> <b>Total Rate</b> <input type="text" id="TotalRate" name="TotalRate" value="{{$totalRate}}" disabled	> </div>
			  <div class="col-xs-3" style="background-color:lavenderblush;"> <b>Total Amount</b> <input type="text" id="TotalAmount" name="TotalAmount" value="{{$totalAmount}}" disabled> </div>
			</div> 
		</div>
<!-- 		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead> 
						<tr> 
							<th></th>  
							<th>Product&nbsp;ID</th>  
							<th>Code</th>  
							<th>Product&nbsp;Name</th> 
							<th>Cost</th> 
							<th>Quantity</th>
							<th>Cost&nbsp;Amount</th>
							<th>Sale&nbsp;Rate</th> 
							<th>Sale&nbsp;Amount</th>  
						</tr> 
					</thead> 
					<tbody id="GridTable">
					
					</tbody> 
				</table>
			</div>
		</div> -->
	</div>
</div>
</div>
				<center><div class="form-actions">
			  <button type="button" class="btn btn-primary" id="btnSave" name="btnSave">Save</button>
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
		function AddGridData(){
		var ProductId = document.getElementById('product_id').value;
		var ProductCode = document.getElementById('product_code').value;
		var ProductName = document.getElementById('product_name').value;
		//var Tax = document.getElementById('tax_id').value.split("_").pop();
		// var TaxID = document.getElementById('tax_id').value.split("_")[0];
		var UOMID = document.getElementById('uom_id').value.split("_")[0];
		var UOM = document.getElementById('uom_id').value.split("_").pop();
		var Quantity = document.getElementById('quantity').value;
		var Price = document.getElementById('price').value;
		var Total = document.getElementById('total').value;
		var tableHtml = '<tr>';
		// tableHtml += '<td class="text-center"><i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-cancel icon-larger red-color" title="Delete Row"></i> </td>';
		//tableHtml += '<td>'+ ProductId +'</td>';
		tableHtml += `<td style="display:none;"><input id="test" value="${ProductId}" type="text" class="form-control" disabled></td>`;
		//tableHtml += '<td>'+ ProductCode +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="test" value="${ProductCode}" type="text" class="form-control" style="margin-left: 7%; width: 60%;" disabled></td>`;
		//tableHtml += '<td>'+ ProductName +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="test" value="${ProductName}" type="text" class="form-control" style="margin-left:-19%; width: 180%;" disabled></td>`;
		//tableHtml += '<td>'+ UOMID +'</td>';
		tableHtml += `<td style="display:none;"><input id="test" value="${UOMID}" type="text" class="form-control" disabled></td>`;
		//tableHtml += '<td>'+ UOM +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="test" value="${UOM}" type="text" class="form-control" style="margin-left:74%; width: 60%;" disabled></td>`;
		//tableHtml += '<td>'+ Quantity +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="test" value="${Quantity}" type="text" class="form-control" style="margin-left:48%; width: 60%;" disabled></td>`;
		//tableHtml += '<td>'+ Price +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="test" value="${Price}" type="text" class="form-control" style="margin-left:22%; width: 120%;" disabled></td>`;
		//tableHtml += '<td>'+ Total +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="test" value="${Total}" type="text" class="form-control" style="margin-left:55%; width: 119%;" disabled></td>`;
		tableHtml += '<td style="padding-top:20px;"><button class="btn btn-red" type="button" style="margin-left: 345%;"> <i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-trash" title="Delete Row"></i></button></td>';
		tableHtml += '</tr>';
		$('#myData').append(tableHtml);
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

function GetSupplierID(value)
{
	document.getElementById('account_id').value = value;
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
					var newRow = '<tr>'+
									'<td class="text-center"><i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-cancel icon-larger red-color" title="Delete Row"></i> </td>'+
									 '<td>' + data[key].product_id + '</td>'+
									 '<td>' + data[key].product_code + '</td>'+
									 '<td>' + data[key].product_name + '</td>'+
									 '<td>' + data[key].uom + '</td>'+
									 '<td>' + data[key].quantity + '</td>'+
									 '<td>' + data[key].rate + '</td>'+
									 '<td>' + data[key].amount + '</td>'+
								  '</tr>';
      					$('#GridTable').append(newRow);
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

	function productMouseUp(productName, rowIndex){
		$.ajax({
			type: "GET",
			url: "/productmouseup-ajax?product_name=" + productName,
			success: function(result) {
				if(result.length > 0)
				{
				$('#product_code').val(result[0].product_code);
				$('#uom').val(result[0].uom);
				$('#product_id').val(result[0].id);
				var price = $("#price").val();
				var quantity = $("#quantity").val();
				var total = price * quantity;
				document.getElementById('total').value = total;
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
	var purchase = new Object();
	var test = $("#account_id").val();
	purchase.account_id = $("#account_id").val();
	purchase.date = $("#date").val();
	purchase.bill_no = $("#bill_no").val();
	purchase.grn_no = $("#grn_no").val();
	purchase.purchase_type = $("#purchase_type").val();
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
		product.total_cost = $(columns[7]).find("input").val();

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
		method: "PATCH",
		cache: false,
		headers: { 'X-XSRF-TOKEN' : $_token },
		data: {purchase: JSON.stringify(purchase), product_data:products},
		url: "/purchase-return/<?php echo $edit->id ?>",
		success: function(result) {
			if(parseInt(result) > 0)
			{
				alert("Purchase Return successfully Updated.");
				//window.open("/purchases/print/"+result);
				window.location.href = "/purchase-return";
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			$("#spanWait").hide();
			alert(xhr.status);
			alert(thrownError);
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