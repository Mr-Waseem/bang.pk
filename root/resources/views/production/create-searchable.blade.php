@extends("app")
<head>
	<link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
</head>
@section("contents")
<body>
<div class="container-fluid">
	@if (Session::has('flash_message'))
		 <div class="alert alert-success alert-dismissible fade in">
 			<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right: 4%;">&times;</a>
 			<strong>Success!</strong> {{ Session::get('flash_message') }}
  		</div>
	@endif
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading clearfix" id="panelbg">
				<h2 class="panel-title"><b>Production Voucher</b></h2>
			</div>
		<div class="panel-body">
			<input id="token" type="hidden" value="{{$encrypted_token}}">
			@include('errors.validation')
			{!! Form::open(['url' => 'production', 'class' => 'form-horizontal' ]) !!}
			<input type="hidden" name="company_id" id="company_id" value="{{session()->get('company_id')}}">
			<div class="row">
					<div class="form-group" style="margin-left: 5%; margin-right: 1%;"> 
						<label class="col-sm-1 control-label">Voucher&nbsp;#</label>  
						<div class="col-sm-2"> 
							{!! Form::text('vr_no', $codes, ['id' => 'vr_no','class'=>'form-control', 'required' => 'required', 'onkeyup' => 'focusNext(event);']) !!} 
						</div> 							
					</div>
				</div>
				<div class="row">
					<div class="form-group" style="margin-left: 5%; margin-right: 1%;"> 
						<label class="col-sm-1 control-label">Date</label>  
						<div class="col-sm-2"> 
							<div id="year-view" class="input-group date"> 
								<input id="date" type="date" name="date" value="<?php echo date('Y-m-d');?>" class="form-control" onkeyup = "focusNext(event);" autofocus> 
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</div>
						</div>
						<label class="col-sm-4 control-label">Product&nbsp;Code</label>  
						<div class="col-sm-2"> 
							{!! Form::text('products_code', null, ['id' => 'products_code','class'=>'form-control', 'disabled' => 'disabled']) !!} 
						</div> 							
					</div>
				</div>
				<div class="form-group" style="display:none;"> 
					<label class="col-sm-3 control-label">Biller</label>  
					<div class="col-sm-5"> 
					  <select name="biller" id="biller" class="form-control">
						<option value="{{ Auth::user()->id }}">{{ Auth::user()->name}}</option>
					  </select>
					</div> 
				</div>
				<div class="row">
					<div class="form-group" style="margin-left: 5%; margin-right: 1%;"> 
						{!! Form::hidden('products_id', null, ['id' => 'products_id', 'class'=>'form-control']) !!} 
						<label class="col-sm-1 control-label">Select&nbsp;Product</label>
						<div class="col-sm-3"> 
						{!! Form::select('products_name', $products, null, ['id' => 'products_name',  'onchange' => 'ProductKeyUp($(this).val().split("_")[0]), ProductKeyUpAbove($(this).val());', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control', 'required' => 'required']) !!}
						{{-- {!! Form::select('products_name', $products, null, ['id' => 'products_name',  'onchange' =>  'ProductKeyUpAbove($(this).val());', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control', 'required' => 'required']) !!}  --}}
						</div> 
						<!-- <label class="col-sm-1 control-label">NTN</label>  --> 
						<label class="col-sm-3 control-label">Quantity</label>  
						<div class="col-sm-2"> 
						{!! Form::text('quantitys', null, ['id' => 'quantitys','class'=>'form-control', 'onkeyup' => 'Quantitykeyupsaa($(this).val()); if(event.keyCode == 187) SaveFunction()',
							 'onfocus' => 'this.value=""', 'onkeypress' => 'return onlyNumberKey(event)', 'required' => 'required']) !!}
						</div>							
					</div>
				</div>
				<div class="row">
					<div class="form-group" style="margin-left: 5%; margin-right: 1%;">  
						<label class="col-sm-1 control-label">Select&nbsp;UOM</label>
						<div class="col-sm-3" style="display:none;"> 
								{!! Form::select('uoms_id', $uoms, null, ['id' => 'uoms_id', 'class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!} 
						</div> 

						<div class="col-sm-3"> 
								{!! Form::text('unit', null, ['id' => 'unit', 'class'=>'form-control', 'disabled' => 'disabled']) !!} 
						</div> 
						 
						<!-- <label class="col-sm-1 control-label">NTN</label>  --> 
						<label class="col-sm-3 control-label">Cost Rate</label>  
						<div class="col-sm-2"> 
							{!! Form::text('rates', null, ['id' => 'rates','class'=>'form-control', 'required' => 'required', 'onkeyup' => 'rateKeyUp($(this).val());']) !!} 
						</div>	

						<!-- <label class="col-sm-3 control-label">Amount</label>  --> 
						<div class="col-sm-2"> 
							{!! Form::text('amounts', null, ['id' => 'amounts','class'=>'form-control', 'placeholder' => 'Amount']) !!} 
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
		{!! Form::text('product_code', null, ['id' => 'product_code', 'onkeyup' => 'ProductKeyUps($(this).val()); if(event.keyCode == 32) $("form").submit()', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control', 'autofocus' => 'autofocus', 'onfocus' => 'this.value=""']) !!}
	</div>
</div> 
<div class="col-md-3" style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="Name" class="control-label">Product Name</label> 
		{!! Form::select('product_name', $Rawproducts, null, ['id' => 'product_name',  'onchange' => 'ProductKeyUp($(this).val().split("_")[0]);', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control']) !!}
	</div> 
</div> 
<div class="col-md-1" style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="Name" class="control-label">Unit</label> 
		{!! Form::select('uom_id', $uomss, null, ['id' => 'uom_id', 'class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
	</div> 
</div> 

<div class="col-md-1"style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Quantity</label> 

		{!! Form::text('quantity', 1, ['id' => 'quantity', 'onkeyup' => 'QuantityKeyUp($(this).val())', 'class'=>'form-control', 'onkeydown' => 'focusNext(event);',]) !!}
	</div> 
</div> 
<div class="col-md-2"style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Rate</label> 
		{!! Form::text('price_per_unit', null, ['id' => 'price_per_unit', 'onkeyup' => 'SaleRate($(this).val())','class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
	</div> 
</div>
<div class="col-md-2"style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Amount</label> 
		{!! Form::text('balance', null, ['id' => 'balance', 'onkeyup' => 'AddGridData()', 'class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
	</div> 
</div>
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
						  <div class="col-xs-5"><button type="button" onclick="TotalRecords()" class="btn btn-warning">Total Records</button>  </div>
						  <!-- <div class="col-xs-3">  </div> -->
						  <!-- <div class="col-xs-3"> <b style="color: black;">Total Rate</b> <input type="text" id="TotalRate" name="TotalRate" value="0" style="color: black;" disabled> </div> -->
						  <div class="col-xs-6"> <b style="color: black;">PRODUCTION TOTAL COST</b> <input type="text" id="TotalAmount" name="TotalAmount" value="0" style="color: black;" disabled> </div>
						</div> 
					</div>
				</div>
			</div>
		</div>
			<center><div class="form-actions">
			  <button type="submit" class="btn btn-primary" id="btnSaves" name="btnSaves">Save</button>
			</div></center>		
			<div class="col-lg-3">
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
<script src="{{asset('js/plugins/select2/select2.full.min.js')}}"></script>
<script type="text/javascript">
	function Quantitykeyupsaa(qty){
	var rates = document.getElementById("rates").value;
	var amounts = parseFloat(qty * rates).toFixed(2);
	document.getElementById("amounts").value = parseFloat(amounts).toFixed(2);
  	var table = document.getElementById("myData");
	var i = 0;
	var sum = 0;
	while (i < table.rows.length) {
    //var quantity =(table.rows[i].cells[5];
    	var quantity = table.rows[i].cells[5].firstChild.value;
    	var rate = table.rows[i].cells[7].firstChild.value;
    	var Totalqty = qty * quantity;
    	var TotalAmount = rate * Totalqty;
    	table.rows[i].cells[6].firstChild.value = parseFloat(Totalqty).toFixed(4);
    	table.rows[i].cells[8].firstChild.value = parseFloat(TotalAmount).toFixed(2);
    	var amount = table.rows[i].cells[8].firstChild.value;
    	sum = sum + parseInt(amount);
    i++;  
}

document.getElementById('TotalAmount').value = sum;
		// var code = $('tr:eq(' + rowIndex + ')', myData).find("td:eq('1')").find('input').val();
	}

	function ProductKeyUp(productID) {
            //alert("hjhj")
			$('#products_name').select2().trigger('select2:close');
             $("#quantitys").focus();
            $("#myData tr").remove();

            $.ajax({
                type: "GET",
                url: "{{ asset('productkeyup-change') }}?prodID=" + productID,
                success: function(data) {
                    if (data.length > 0) {
                        var Grandamount = 0;
                        $("#myData tr").remove();

                        $.each(data, function(key, value) {
                            var sum = 0;
                            var newRow = '<tr>';
                            newRow +=
                                `<td style="padding-top:20px; display:none"><input id="product_id" name="product_id[]" value="${data[key].products.id}" type="text" class="form-control" style="margin-left: 7%; width: 53%;"></td>`;

                            newRow +=
                                `<td style="padding-top:20px;"><input id="product_code" name="product_code[]" value="${data[key].products.product_code}" type="text" class="form-control" style="margin-left: 7%; width: 53%;"></td>`;

                            newRow +=
                                `<td style="padding-top:20px;"><input id="product_name" name="product_name[]" value="${data[key].products.product_name}" type="text" class="form-control" style="margin-left: -33%; width: 161%;"></td>`;


                            newRow +=
                                `<td style="display:none;"><input id="uom_id" name="uom_id[]" value="${data[key].uom_id}" type="text" class="form-control" style="margin-left: -25%; width: 120%;"></td>`;

                            // '<td style="padding-top:20px;"><input id="destination" name="destination[]" value="'.$overallstocke->destinations->catagory_name.'" type="text" class="form-control" style="margin-left: 13%;width: 107%;"></td>'.

                            newRow +=
                                `<td style="padding-top:20px;"><input id="" name="[]" value="${data[key].products.uom}" type="text" class="form-control" style="margin-left: 34%; width: 53%;">`;

                            newRow +=
                                `<td style="padding-top:20px; display:none;"><input id="quantityshow" name="quantityshow[]"  type="text" class="form-control" style="margin-left: -6%; width: 53%;" value="${data[key].quantity}"></td>`;

                            newRow +=
                                `<td style="padding-top:20px;"><input id="quantity" name="quantity[]"  type="text" class="form-control" style="margin-left: -6%; width: 53%;" value="${data[key].quantity}"></td>`;


                            newRow +=
                                `<td style="padding-top:20px;"><input id="rate" name="rate[]" value="${data[key].products.product_cost}" type="text" class="form-control" style="margin-left:-45%; width: 106%;"></td>`;


                            var sum = sum + data[key].amount;
                            var amounts = data[key].quantity * data[key].products.product_cost;
                            //alert(sum)
                            newRow +=
                                `<td style="padding-top:20px;"><input id="amount" name="amount[]" value="${amounts}" type="text" class="form-control" style="margin-left: -31%; width: 106%;"></td>`;
                            Grandamount = parseFloat(Grandamount) + parseFloat(amounts);
                            //Grandamount = parseFloat(Grandamount) + parseFloat(data[key].amount);
                            //alert(total)
                            newRow +=
                                `<td style="padding-top: 20px;"><button class="btn btn-red" type="button" style="margin-left: -80%;"> <i onclick="javascript:myDeleteFunction($(this).closest('tr'));" class="icon-trash" title="Delete Row"></i></button></td>`;

                            '</tr>';
                            $('#myData').append(newRow);
                            //below
                            document.getElementById('TotalAmount').value = Grandamount;
                            //top rate
                            document.getElementById('rates').value = Grandamount;
                            //top amount
                            document.getElementById('amounts').value = Grandamount;


                        });
                        // $("#myData tr").remove(); 
                        // $('#myData').append(result);
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
            // var productID = document.getElementById('products_name').value.split("_")[0];
            // var productCode = document.getElementById('products_name').value.split("_")[1];
            // var productName = document.getElementById('products_name').value.split("_")[2];
            // document.getElementById('products_id').value = productID;
            // document.getElementById('products_code').value = productCode;

        }
	// on javascript onclick on product dropdown 
	function ProductKeyUpp(productID){
		//alert(productID)
		$.ajax({
			type: "GET",
			url: "{{asset('productkeyup-ajax?prodID')}}=" + productID,
			success: function(result) {
				if(result.length > 0)
				{
					$('#product_code').val(result[0].product_code);
					$('#product_id').val(result[0].id);
					//$("#product_cost").val(result[0].unit_cost);
					$("#product_cost").val(result[0].product_cost);
					$("#price_per_unit").val(result[0].product_price);

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
		function ProductKeyUpAbove(product){
		 var productID = document.getElementById('products_name').value.split("_")[0];
		 var productCode = document.getElementById('products_name').value.split("_")[1];
		 var productCost = document.getElementById('products_name').value.split("_")[2];
		 var uom = document.getElementById('products_name').value.split("_")[4];
		 document.getElementById('products_id').value = productID;
		 document.getElementById('products_code').value = productCode;
		 document.getElementById('unit').value = uom;

	}
	function rateKeyUp(rate){
		var qty = document.getElementById('quantitys').value;
		var amount = qty*rate;
		document.getElementById('amounts').value = amount;
	}

	    $("#products_name").select2();
	    $("#products_name").next(".select2").find(".select2-selection").focus(function() {
	    $("#products_name").select2("open");
	   });
        $("#product_name").select2();
        $("#product_name").next(".select2").find(".select2-selection").focus(function() {
        $("#product_name").select2("open");
    });
       $("#uom_id").select2();
       $("#uom_id").next(".select2").find(".select2-selection").focus(function() {
       $("#uom_id").select2("open");
   });
        $("#uoms_id").select2();
       $("#uoms_id").next(".select2").find(".select2-selection").focus(function() {
       $("#uoms_id").select2("open");
   });
	function TotalRecords() {
		var rowCount = document.getElementById('myData').rows.length;
		alert("Total Number of Records Are: " + rowCount);
	}
	function ProductKeyUps(productCode){
		//alert(productCode)
		$.ajax({
			type: "GET",
			url: "/productkeyup-ajax?prodCode=" + productCode,
			success: function(result) {
				if(result.length > 0)
				{
					$('#product_code').val(result[0].product_code);
					$('#product_name').val(result[0].product_name);
					$('#price_per_unit').val(result[0].product_cost);
					$('#balance').val(result[0].product_cost);
					$('#product_id').val(result[0].id);
					//$("#product_cost").val(result[0].unit_cost);
					// $("#product_cost").val(result[0].product_cost);
					// $("#price_per_unit").val(result[0].product_price);

					// var price = $("#price_per_unit").val();
					// var quantity = $("#quantity").val();
					// var cost = $("#product_cost").val();
					// var CostAmount= cost * quantity;
					// var SaleAmount = price * quantity;
					// var totalDiscount = ((discountnew/100)*quantity*price);
					// document.getElementById('cost_amount').value = CostAmount;
					// document.getElementById('balance').value = SaleAmount;
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
			var total = quantity*salerate;
			document.getElementById('balance').value = total;

		}
		function QuantityKeyUp(quantity){
			var price = document.getElementById('price_per_unit').value;
			total = (quantity * price);
			document.getElementById('balance').value = total;
		}
		function myDeleteFunction(row) {
		alertify.confirm("Are you sure you want to delete this row?", function (e) {
		    if (e) {
		    	//var TotalRate = document.getElementById('TotalRate').value;
		    	var TotalAmount = document.getElementById('TotalAmount').value;
		    	//alert(TotalRate)
		    	//alert(TotalAmount)
				//var rate = $(row).find("td:eq('10')").find("input").val();
				var amount = $(row).find("td:eq('11')").find("input").val();
				//alert(rate)
				//alert(amount)
				//var grandRate = parseInt(TotalRate) - parseInt(rate);
				var grandAmount = parseInt(TotalAmount) - parseInt(amount);
				//document.getElementById('TotalRate').value = grandRate;
				document.getElementById('TotalAmount').value = grandAmount;
		    	$(row).remove();
		        //alertify.alert("File is Removed!");
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
		var InvoiceNo = document.getElementById('vr_no').value;
		var ProductId = document.getElementById('product_id').value;
		var ProductCode = document.getElementById('product_code').value;
		var ProductName = document.getElementById('product_name').value.split("_").pop();
		var UOMID = document.getElementById('uom_id').value.split("_")[0];
		var UOM = document.getElementById('uom_id').value.split("_").pop();
		var Quantity = document.getElementById('quantity').value;
		var Price = document.getElementById('price_per_unit').value;
		var Amount = document.getElementById('balance').value;
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
</script>
@stop