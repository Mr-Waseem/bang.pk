@extends("app")
@section("head")
<!-- <link href="/css/entypo.css" rel="stylesheet">
<link href="/css/font-awesome.min.css" rel="stylesheet">
<link href="/css/bootstrap.min.css" rel="stylesheet">
<link href="/css/mouldifi-core.css" rel="stylesheet">
<link href="/css/plugins/datepicker/bootstrap-datepicker.css" rel="stylesheet">
<link href="/css/plugins/colorpicker/bootstrap-colorpicker.css" rel="stylesheet">
<link href="/css/plugins/nouislider/nouislider.css" rel="stylesheet">
<link href="/css/plugins/select2/select2.css" rel="stylesheet">
<link href="/css/mouldifi-forms.css" rel="stylesheet" >
<link rel='stylesheet' type='text/css' href='http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css'>
    <link rel='stylesheet' href='/css/immybox.css'>
    <script src='http://code.jquery.com/jquery-1.10.2.min.js'></script>
    <script src='/js/jquery.immybox.min.js'></script> -->

@stop
@section("contents")
<body onload="AddRowFunction()">
<div class="container-fluid">
	@if (Session::has('flash_message'))
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="margin-right: 20px;margin-top: 15px;">&times;</button>
		<div class="alert alert-success"> {{ Session::get('flash_message') }} </div>
	@endif
</div>
<h1 class="page-title">Add Sale</h1>
<!-- Breadcrumb -->
<ol class="breadcrumb breadcrumb-2"> 
	<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
	<li><a href="/sales">Sales</a></li> 
	<li class="active"><strong>Add Sale</strong></li> 
</ol>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading clearfix">
				<h3 class="panel-title">Add Sale</h3>
				<ul class="panel-tool-options"> 
					<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
					<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
					<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
				</ul>
			</div>
		<div class="panel-body">
			<input id="token" type="hidden" value="{{$encrypted_token}}">
			@include('errors.validation')
			{!! Form::open(['url' => 'sales', 'class' => 'form-horizontal' ]) !!}
				<div class="row">
					<div class="form-group"> 
						<label class="col-sm-3 control-label">Date</label>  
						<div class="col-sm-2"> 
							<div id="year-view" class="input-group date"> 
								<input id="date" type="text" name="date" value="<?php echo date('m/d/Y');?>" class="form-control" autofocus> 
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
							</div>
						</div>
						<label class="col-sm-1 control-label">Sale&nbsp;Type</label>  
						<div class="col-sm-2"> 
							<select class="form-control" onchange="LedgerValues();" id="sale_type" name="sale_type">
								<option value="Cash Sale">Cash Sale</option>
								<option value="Credit Sale">Credit Sale</option>
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
					<label class="col-sm-3 control-label">GRN No</label>  
					<div class="col-sm-5"> 
					{!! Form::text('country', null, ['id' => 'autocomplete-ajax','class'=>'form-control', 'required' => 'required']) !!}
					</div> 
				</div> -->
				<div class="form-group"> 
					<label class="col-sm-3 control-label">Invoice No#</label>  
						<div class="col-sm-2"> 
							<div id="year-view" class="input-group date"> 
								{!! Form::text('invoice_no', null, ['id' => 'invoice_no','class'=>'form-control', 'required' => 'required']) !!} 
							</div>
						</div>
						<label class="col-sm-1 control-label">Local&nbsp;or&nbsp;Export?</label>  
						<div class="col-sm-2"> 
							<select class="form-control" onchange="LedgerValues();" id="sale_type" name="sale_type">
								<option value="Local">Local</option>
								<option value="Export">Export</option>
							</select>
						</div>  
				</div>
				<div class="form-group" style="display:none;"> 
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
					{!! Form::select('party_id', $customers, null, ['id' => 'party_id', 'class'=>'form-control livesearch']) !!}
					</div> 
				</div>	
			<div class="panel panel-default">
				<div class="panel-body">	
				<div class="form-group">
					<div class="row">
						<div class="col-sm-1"><h5><b><center>Code</center></b></h5></div>
						<div class="col-sm-2"><h5><b><center>Name</center></b></h5></div>
						<div class="col-sm-1"><h5><b><center>Quantity</center></b></h5></div>
						<div class="col-sm-1"><h5><b><center>Discount</center></b></h5></div>
						<div class="col-sm-2"><h5><b><center>Purchase&nbsp;Price</center></b></h5></div>
						<div class="col-sm-1"><h5><b><center>Sale&nbsp;Price</center></b></h5></div>
						<div class="col-sm-2"><h5><b><center>Amount</center></b></h5></div>
						<div class="col-sm-1"><h5><b><center>Stock</center></b></h5></div>
					</div>
					<table  id="myTable">
						<div class="row">
						<!-- <tr>
								<td style="display:none;">
								{!! Form::hidden('product_id', null, ['id' => 'product_id','class'=>'form-control']) !!}
								</td>
							<div class="col-sm-2">	
								<td>
									{!! Form::text('product_code', null, ['id' => 'product_code','class'=>'form-control']) !!}
								</td>
							</div>
							<div class="col-sm-2">
								<td>	
									{!! Form::select('product_name', $products, null, ['id' => 'product_name','class'=>'form-control livesearch']) !!}
								</td>
							</div>
							<div class="col-sm-2">
								<td>
								{!! Form::text('quantity', 1, ['id' => 'quantity', 'onkeyup' => 'Calculate()','class'=>'form-control']) !!}
								</td>
							</div>
							<div class="col-sm-2">
								<td>
								{!! Form::select('discount_id', $discounts, null, ['id' => 'discount_id', 'onchange' => 'Discount()', 'class'=>'form-control livesearch']) !!}
								</td>
							</div>
							
							<div class="col-sm-2">
								<td>
								{!! Form::text('unit_cost', null, ['id' => 'unit_cost', 'disabled' => 'disabled', 'class'=>'form-control']) !!}
								</td>
							</div>
							<div class="col-sm-2">
								<td>
								{!! Form::text('total_cost', null, ['id' => 'total_cost', 'disabled' =>'disabled','class'=>'form-control']) !!}
								</td>
							</div>
							<td>
							<div>														
								<button onclick="javascript:myDeleteFunction($(this).closest('tr'));" class="btn btn-red" title="Delete Row" type="button"> <i class="icon-trash"></i> </button>
							</div>										
							</td>	
								<input type="hidden" id="customer_id" name="customer_id" value="">
						</tr> -->
						
						</div>
					</table></br></br>
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.jquery.min.js"></script>
<script type="text/javascript">
	$(".livesearch").chosen();
</script>

<script type="text/javascript">
	var sum=0;
function AddRowFunction() {
	sum = sum + 1;

	var productsOptionsText = "";
	$.each($("#product_name option"), function(index, option){
		productsOptionsText = productsOptionsText + "<option value='" + $(option).val() + "'>";
		productsOptionsText = productsOptionsText + $(option).text() + "</option>";
	});
	
	var html = '<tr style="padding-top:20px;">';
	// html = html + '<div>';
	// html = html + '<td>';
	// html = html + '<select  onchange="javascript:getProductCoste($(this).val(), $(this).closest(\'tr\').index());" class="form-control livesearch" class="selectpicker" data-show-subtext="true" data-live-search="true">';
	// html = html + productsOptionsText;
	// html = html + '</select>';
	html = html + '<div>';
	html = html + '<td style="display:none;">';
	html = html + '{!! Form::text('product_idnew', null, ['id' => 'product_idnew', 'class'=>'form-control']) !!}';
	html = html + '</td>';
	html = html + '</div>';
	html = html + '<div>';
	html = html + '<td>';
	html = html + '{!! Form::text('product_codenew', null, ['id' => 'product_codenew', 'onkeyup' => 'javascript:codeMouseUp($(this).val(), $(this).closest(\'tr\').index())', 'class'=>'form-control']) !!}';
	html = html + '</td>';
	html = html + '</div>';
	html = html + '<div>';
	html = html + '<td>';
	html = html + '{!! Form::text('product_namenew', null, ['id' => 'product_namenew', 'onkeyup' => 'javascript:productMouseUp($(this).val(), $(this).closest(\'tr\').index())', 'class'=>'form-control livesearch']) !!}';
	html = html + '</td>';
	html = html + '</div>';
	html = html + '<div>';
	html = html + '<td>';
	html = html + '<input id="quantity" value="1" onkeyup="javascript:quantityMouseUp($(this).val(), $(this).closest(\'tr\').index());" class="form-control" name="quantity" type="text">';
	html = html + '</td>';
	html = html + '</div>';
	
	html = html + '<div>';
	html = html + '<td>';
	html = html + '{!! Form::select('discount_idnew', $discounts, null, ['id' => 'discount_idnew', 'onchange' => 'javascript:DiscountNew($(this).val(), $(this).closest(\'tr\').index())', 'class'=>'form-control']) !!}';
	//html = html + '{!! Form::text('discount_idnew', 0, ['id' => 'discount_idnew', 'onkeyup' => 'javascript:DiscountNew($(this).val().split("_").pop(), $(this).closest(\'tr\').index())', 'class'=>'form-control livesearch']) !!}';
	html = html + '</td>';
	html = html + '</div>';

	html = html + '<div>';
	html = html + '<td>';
	html = html + '<input id="unit_costnew" class="form-control" name="unit_costnew" type="text">';
	html = html + '</td>';
	html = html + '</div>';
	html = html + '<div>';
	html = html + '<td>';
	html = html + '<input id="sale_price" onkeyup="javascript:salepriceMouseUp($(this).val(), $(this).closest(\'tr\').index());" class="form-control" name="sale_price" type="text">';
	html = html + '</td>';
	html = html + '</div>';
	html = html + '<div>';
	html = html + '<td>';
	html = html + '<input id="totalcostnew" class="form-control" name="totalcostnew" type="text">';
	html = html + '</td>';
	html = html + '</div>';
	html = html + '<div>';
	html = html + '<td>';
	html = html + '<input id="remaining_quantity" class="form-control" name="remaining_quantity" type="text" disabled>';
	html = html + '</td>';
	html = html + '</div>';
	html = html + '<div>';
	html = html + '<td>';
	html = html + '<button onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" onkeyup="AddRowFunction()" class="btn btn-red" title="Delete Row" type="button"> <i class="icon-trash"></i> </button>';								
	html = html + '</td>';
	html = html + '</div>';
	html = html + '</tr>';
	$("#myTable").append(html);
	
}
function LedgerValues(){
	 $value = $("#sale_type").val();
	 if($value == "Cash Sale"){
	 	$('#ledgerRow').hide();
	 }
	  if($value == "Credit Sale"){
   $('#ledgerRow').show();
}
}


	function TotalRecords() {
		var rowCount = document.getElementById('myTable').rows.length;
		alert("Total Number of Records Are: " + rowCount);
	}

	// on javascript onclick on product dropdown
	/*function getProductCost(productId, rowIndex){
		
		$.ajax({
			type: "GET",
			url: "/saletab-ajax?code_id=" + productId,
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
}*/
// on javascript onclick on product dropdown 
	function codeMouseUp(productId, quantity, rowIndex){
		$.ajax({
			type: "GET",
			url: "/saletab-ajax?code_id=" + productId,
			success: function(result) {
				if(result.length > 0)
				{
		$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('0')").find('input').val(result[0].id);
		$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('2')").find('input').val(result[0].product_english);
		$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('3')").find('input').val(result[0].remaining_quantity);
		$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('5')").find('input').val(result[0].unit_cost);
		$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('8')").find('input').val(result[0].remaining_quantity);

		//var newtax = $('tr:eq(' + rowIndex +')', myTable).find("td:eq('3')").find('select').val().split("_").pop();
		var discount = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('select').val().split("_").pop();
		var quantity = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('3')").find('input').val();
		var price = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val();
		var totalDiscount = ((discount/100)*quantity*price);
		var total = quantity * price;
		//document.getElementById('total_costnew').value = totalDiscount;
		$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('7')").find('input').val(total-totalDiscount);
		//var grand = (newquantity*newPrice) + ((newdiscount/100)*newquantity*newPrice);
		//$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('7')").find('input').val(newquantity);
		//var grand = (newquantity*newPrice) - newdiscount;
		//var grand = (newquantity*cost) + ((newtax/100)*newquantity*cost) - newdiscount;
		//if(parseInt(newPrice) == 0 && parseFloat(newPrice) > 0)
		//{
			//totalPrice = parseFloat(grand).toFixed(2);
		//}
		//$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('input').val(grand);
		//$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val(newPrice);
				}	
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}				
		});
}


	//on product Mouse up 
	function productMouseUp(productName, rowIndex){
		$.ajax({
			type: "GET",
			url: "/productonchange-ajax?product_name=" + productName,
			success: function(result) {
				if(result.length > 0)
				{
					$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('0')").find('input').val(result[0].id);
					$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('1')").find('input').val(result[0].product_code);
					$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('3')").find('input').val(result[0].remaining_quantity);
					$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('5')").find('input').val(result[0].unit_cost);

					var salePrice = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val();

					var discount = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('select').val().split("_").pop();
					var quantity = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('3')").find('input').val();
					var price = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val();
					var grand = (price * quantity) - (((discount/100))*price * quantity);
					$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('7')").find('input').val(grand);

				}	
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}				
		});
}

function salepriceMouseUp(salePrice, rowIndex){
	var quantity = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('3')").find('input').val();
	var saleprice = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val();
	var grand = quantity*saleprice;
	$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('7')").find('input').val(grand);
}
		
	$("#product_code").keyup(function(){
			if($("#product_code").val() != "0")
			{
				$.ajax({
					type: "GET",
					url: "/getfirstProduct-ajax?saletab_id=" + $("#product_code").val(),
					success: function(result) {
						if(result.length > 0)
						{
						$("#product_id").val(result[0].id);
						$("#product_name").val(result[0].product_english);
						$("#unit_cost").val(result[0].product_price);
						
							var quantity = document.getElementById('quantity').value;
							var cost = document.getElementById('unit_cost').value;
							var discount = document.getElementById('discount_id').value.split("_").pop();
							//var tax = document.getElementById('tax_id').value.split("_").pop();
							var totalDiscount = ((discount/100)*quantity*cost);
							var total = quantity * cost;
							document.getElementById('total_cost').value = total - totalDiscount;
							
						}	
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.status);
						alert(thrownError);
					}				
				});				
			}		
		});
	
	function getProductdata(ProductID, RowIndex)
	{
		$.ajax({
			type: "GET",
			url: "/saletab-ajax?sale_id=" + ProductID,
			success: function(result) {
				if(result.length > 0)
				{
					$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('1')").find('input').val(result[0].product_name);
					$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('0')").find('input').val(result[0].id);
					$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('2')").find('input').val(result[0].product_name);
					$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val(result[0].product_price);
					
					//debugger;
					var newtax = $('tr:eq(' + rowIndex +')', myTable).find("td:eq('3')").find('select').val().split("_").pop();
					var newdiscount = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('input').val();
					var newquantity = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('5')").find('input').val();
					var newPrice = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val();;
					var grand = (newquantity*newPrice) + ((newtax/100)*newquantity*newPrice) - newdiscount;
					$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('7')").find('input').val(grand);
					//var grand = (newquantity*newPrice) - newdiscount;
					//var grand = (newquantity*cost) + ((newtax/100)*newquantity*cost) - newdiscount;
					//if(parseInt(newPrice) == 0 && parseFloat(newPrice) > 0)
					//{
						//totalPrice = parseFloat(grand).toFixed(2);
					//}
					//$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('input').val(grand);
					//$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('5')").find('input').val(grand);
				}	
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}				
		});
	}

	function myDeleteFunction(row) {
		if(confirm("Are you sure you want to delete this row?"))
		{
			$(row).remove();
		}
	}


	function DiscountNew(discount, rowIndex){
		var quantity = $('tr:eq(' + rowIndex +')', myTable).find("td:eq('3')").find('input').val();
		var discountnew = $('tr:eq(' + rowIndex +')', myTable).find("td:eq('4')").find('select').val().split("_").pop();		
		var price = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('5')").find('input').val();
		var totalDiscount = ((discountnew/100)*quantity*price);
		var total = quantity * price;
		//document.getElementById('total_costnew').value = totalDiscount;
		$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val(total-totalDiscount);
		///if(parseFloat(tax) > 0)
		//{
			//var grand = (quantity*unitPrice) - discount;
			
		//}
		//else
		//{
			//$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('5')").find('input').val(unitPrice);
		//}	
				
}

// on javascript onclick on product dropdown
	function quantityMouseUp(quantity, rowIndex){	
		
		

		var code = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('1')").find('input').val();
		alert(code);
		var remainingquantity = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('8')").find('input').val();
		if (quantity > remainingquantity) {
		    alert("Invalid! Your Remaining Stock is: " + quantity);
		   e.preventdefault();
		}
		var price = $('tr:eq(' + rowIndex + ')', myTable).find("td:eq('6')").find('input').val();
		var discount = $('tr:eq(' + rowIndex +')', myTable).find("td:eq('4')").find('select').val().split("_").pop();
		
		var totalDiscount = ((discount/100)*quantity*price);
		var total = quantity * price;
		$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('7')").find('input').val(total-totalDiscount);
		//if(parseInt(quantity) > 0)
		//{	
			//$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('input').val(grand);
		//}
		//else
		//{
			//$('tr:eq(' + rowIndex + ')', myTable).find("td:eq('4')").find('input').val(price);
		//}	
				
}

// ajax call for product, it will show cost value & calculate total cost
	/*$("#product_id").change(function(){
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
							var grand = ((discount/100)*quantity*unitPrice);
							document.getElementById('total_cost').value = grand;
						}	
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.status);
						alert(thrownError);
					}				
				});				
			}		
		});*/


$("#btnSave").click(function()
{
	 var purchase = new Object();
	 purchase.date = $("#date").val();
	 if($("#due_date").val() != ""){
	 purchase.due_date = $("#due_date").val();
	 purchase.particulars = $("#particulars").val();
	}
	 purchase.reference_no = $("#reference_no").val();
	 purchase.biller = $("#biller").val();
	 purchase.sale_type = $("#sale_type").val();
	 purchase.party_id = $("#party_id").val();
	
	var products = [];
	$.each($("#myTable tr"), function(index, row){
		var columns = $(row).find("td");
		var product = new Object();
		product.party_id = $("#party_id").val();
		product.product_id = $(columns[0]).find("input").val();
		product.quantity = $(columns[3]).find("input").val();
		product.discount_id = $(columns[4]).find("select").val().split("_")[0];
		product.unit_cost = $(columns[6]).find("input").val();
		product.total_cost = $(columns[7]).find("input").val();

		//Code & product only for validation, not insertion
		product.code = $(columns[1]).find("input").val();
		product.product_name = $(columns[2]).find("input").val();
		if($(columns[1]).find("input").val()=="" || $(columns[2]).find("input").val()==""){
			alert('Fill the Code & Product Correctly First!');
           e.preventdefault();
			}
		//validation
		if($(columns[3]).find("input").val() =="" || $(columns[5]).find("input").val() =="" || $(columns[6]).find("input").val() ==""){
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
		url: "/sales",
		
		success: function(result) {
			//if(result == "inserted")
			if(parseInt(result) > 0)
			{
				window.open("/sales/print/"+result);
				window.location.href = "/sales/create";
				//window.open("/sales/print/"+result);
				//alert("Sale successfully saved.");
				//Session::flash('flash_message', 'Sale Added Successfully!');
				//window.location.href = "/sales";
				
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			$("#spanWait").hide();
			alert(xhr.status);
			alert(thrownError);
		}
	});
});

		$('#datee').datepicker({
					startView: 0,
					keyboardNavigation: false,
					forceParse: false,
					format: "dd/mm/yyyy"
				});



</script>
@stop