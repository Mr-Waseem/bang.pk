<head>
  <link href="/css/select2.min.css" rel="stylesheet" />

</head>
<html>
	<head>
		<meta charset="utf-8">
		<title>Invoice</title>
		<link rel="stylesheet" href="style.css">
		<link rel="license" href="https://www.opensource.org/licenses/mit-license/">
		<script src="script.js"></script>
		<style>
/* reset */

*
{
	/*border: 0;*/
	box-sizing: content-box;
	color: inherit;
	font-family: inherit;
	font-size: inherit;
	font-style: inherit;
	font-weight: inherit;
	line-height: inherit;
	list-style: none;
	margin: 0;
	padding: 0;
	text-decoration: none;
	vertical-align: top;
}

/* content editable */

*[data-prefix] { border-radius: 0.25em; min-width: 1em; outline: 0; }

*[data-prefix] { cursor: pointer; }

*[data-prefix]:hover, *[data-prefix]:focus, td:hover *[data-prefix], td:focus *[data-prefix], img.hover { background: #DEF; box-shadow: 0 0 1em 0.5em #DEF; }

span[data-prefix] { display: inline-block; }

/* heading */

h1 { font: bold 100% sans-serif; letter-spacing: 0.5em; text-align: center; text-transform: uppercase; }

/* table */

table { font-size: 75%; table-layout: fixed; width: 100%; }
table { border-collapse: separate; border-spacing: 2px; }
th, td { border-width: 1px; padding: 0.5em; position: relative; text-align: left; }
th, td { border-radius: 0.25em; border-style: solid; }
th { background: #EEE; border-color: #BBB; }
td { border-color: #DDD; }

/* page */

html { font: 16px/1 'Open Sans', sans-serif; overflow: auto; padding: 0.5in; }
html { background: #999; cursor: default; }

body { box-sizing: border-box; height: 11in; margin: 0 auto; overflow: hidden; padding: 0.5in; width: 8.5in; }
body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }

/* header */

header { margin: 0 0 3em; }
header:after { clear: both; content: ""; display: table; }

header h1 { background: #000; border-radius: 0.25em; color: #FFF; margin: 0 0 1em; padding: 0.5em 0; }
header address { float: left; font-size: 75%; font-style: normal; line-height: 1.25; margin: 0 1em 1em 0; }
header address p { margin: 0 0 0.25em; }
header span, header img { display: block; float: right; }
header span { margin: 0 0 1em 1em; max-height: 25%; max-width: 60%; position: relative; }
header img { max-height: 100%; max-width: 100%; }
header input { cursor: pointer; -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; height: 100%; left: 0; opacity: 0; position: absolute; top: 0; width: 100%; }

/* article */

article, article address, table.meta, table.inventory { margin: 0 0 3em; }
article:after { clear: both; content: ""; display: table; }
article h1 { clip: rect(0 0 0 0); position: absolute; }

article address { float: left; font-size: 125%; font-weight: bold; }

/* table meta & balance */

table.meta, table.balance { float: left; width: 33%; }
table.meta:after, table.balance:after { clear: both; content: ""; display: table; }

/* table meta */

table.meta th { width: 40%; }
table.meta td { width: 60%; }

/* table items */

table.inventory { clear: both; width: 100%; }
table.inventory th { font-weight: bold; text-align: center; }

table.inventory td:nth-child(1) { width: 26%; }
table.inventory td:nth-child(2) { width: 38%; }
table.inventory td:nth-child(3) { text-align: right; width: 12%; }
table.inventory td:nth-child(4) { text-align: right; width: 12%; }
table.inventory td:nth-child(5) { text-align: right; width: 12%; }

/* table balance */

table.balance th, table.balance td { width: 50%; }
table.balance td { text-align: right; }

/* aside */

aside h1 { border: none; border-width: 0 0 1px; margin: 0 0 1em; }
aside h1 { border-color: #999; border-bottom-style: solid; }

/* javascript */

.add, .cut
{
	border-width: 1px;
	display: block;
	font-size: .8rem;
	padding: 0.25em 0.5em;	
	float: left;
	text-align: center;
	width: 0.6em;
}

.add, .cut
{
	background: #9AF;
	box-shadow: 0 1px 2px rgba(0,0,0,0.2);
	background-image: -moz-linear-gradient(#00ADEE 5%, #0078A5 100%);
	background-image: -webkit-linear-gradient(#00ADEE 5%, #0078A5 100%);
	border-radius: 0.5em;
	border-color: #0076A3;
	color: #FFF;
	cursor: pointer;
	font-weight: bold;
	text-shadow: 0 -1px 2px rgba(0,0,0,0.333);
}

.add { margin: -2.5em 0 0; }

.add:hover { background: #00ADEE; }

.cut { opacity: 0; position: absolute; top: 0; left: -1.5em; }
.cut { -webkit-transition: opacity 100ms ease-in; }

tr:hover .cut { opacity: 1; }

@media print {
	* { -webkit-print-color-adjust: exact; }
	html { background: none; padding: 0; }
	body { box-shadow: none; margin: 0; }
	span:empty { display: none; }
	.add, .cut { display: none; }
}

@page { margin: 0; }
		</style>
	</head>
	<body style="width: 10.5in;">
		<a href="javascript:window.print();"><header>
			<h1>Recipe</h1>
			<!-- <address data-prefix>
				<p>Jonathan Neal</p>
				<p>101 E. Chapman Ave<br>Orange, CA 92866</p>
				<p>(800) 555-1234</p>
			</address>
			<span><img alt="" src="http://www.jonathantneal.com/examples/invoice/logo.png"><input type="file" accept="image/*"></span> -->
		</header></a>
		<article>
			<h1>Recipient</h1>

			<table class="meta">
				<tr>
					<th><span data-prefix>Voucher#</span></th>
					<td><span>{!! Form::text('vr_no', $codes, ['id' => 'vr_no', 'required' => 'required', 'onkeyup' => 'focusNext(event);']) !!} </span></td>
				</tr>
				<tr>
					<th><span data-prefix>Date</span></th>
					<td><span><?php echo date('d/m/Y');?></span></td>
				</tr>
				<tr>
					<th><span>Recipe Code</span></th>
					<td><span>{!! Form::text('products_code', null, ['id' => 'products_code','class'=>'form-control', 'disabled' => 'disabled']) !!}</span></td>
				</tr>
				{!! Form::hidden('products_id', null, ['id' => 'products_id', 'class'=>'form-control']) !!}
				<tr>
					<th><span>Recipe Name</span></th>
					<td><span>	{!! Form::select('products_name', $products, null, ['id' => 'products_name',  'onchange' => 'ProductKeyUp($(this).val().split("_")[0]), ProductKeyUpAbove($(this).val());', 'class'=>'form-control']) !!} </span></td>
				</tr>
			</table>
			<table class="meta">
				<!-- <tr>
					<th><span data-prefix>Invoice #</span></th>
					<td><span data-prefix>101138</span></td>
				</tr>
				<tr>
					<th><span data-prefix>Date</span></th>
					<td><span data-prefix>January 1, 2012</span></td>
				</tr>
				<tr>
					<th><span data-prefix>Amount Due</span></th>
					<td><span id="prefix" data-prefix>$</span><span>600.00</span></td>
				</tr> -->
			</table>
			<table class="meta">
				<tr>
					<th><span data-prefix>Quantity</span></th>
					<td><span data-prefix>{!! Form::text('quantitys', 1, ['id' => 'quantitys','class'=>'form-control', 'onkeyup' => 'Quantitykeyupsaa($(this).val()); if(event.keyCode == 187) SaveFunction()', 'required' => 'required']) !!}</span></td>
				</tr>
				<tr>
					<th><span data-prefix>Uom</span></th>
					<td><span data-prefix>{!! Form::select('uoms_id', $uoms, null, ['id' => 'uoms_id', 'class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!} </span></td>
				</tr>
				<tr>
					<th><span data-prefix>Cost.Rate</span></th>
					<td><span>{!! Form::text('rates', null, ['id' => 'rates','class'=>'form-control', 'required' => 'required', 'onkeyup' => 'rateKeyUp($(this).val());']) !!} </span></td>
				</tr>
				<tr>
					<th><span data-prefix>Total.Cost</span></th>
					<td><span>{!! Form::text('amounts', null, ['id' => 'amounts','class'=>'form-control', 'placeholder' => 'Amount']) !!}</span></td>
				</tr>
			</table>
			<table class="inventory">
				<thead>
					<tr>
						<th><span data-prefix>CODE</span></th>
						<th style="width:40%; text-align: left;"><span data-prefix>PRODUCT&nbsp;NAME</span></th>
						<th><span data-prefix>UNIT</span></th>
						<th><span data-prefix>Quantity</span></th>
						<th><span data-prefix>RATE</span></th>
						<th><span data-prefix>AMOUNT</span></th>
						<th><span data-prefix>STOCK</span></th>
					</tr>
				</thead>
				<tbody id="myData">
					<!-- <tr>
						<td><span data-prefix>Front End Consultation</span></td>
						<td><span data-prefix>Experience Review</span></td>
						<td><span data-prefix>$</span><span data-prefix>150.00</span></td>
						<td><span data-prefix>4</span></td>
						<td><span data-prefix>$</span><span>600.00</span></td>
						<td><span data-prefix>$</span><span>600.00</span></td>
						
					</tr> -->
				</tbody>
			</table>
			<!-- <a class="add">+</a> -->
			<table class="balance">
				<tr>
					<th><span data-prefix>Total Cost</span></th>
					<td><span data-prefix><input type="text" id="TotalAmount" name="TotalAmount" value="0" style="color: black; background: none; border:none;" disabled></span></td>
				</tr>
				<tr style="display: none;">
					<th><span data-prefix>Amount Paid</span></th>
					<td><span data-prefix><input type="text" id="rates" name="rates" value="0" style="color: black;" disabled></span></td>
				</tr>
				<tr style="display: none;">
					<th><span data-prefix>Balance Due</span></th>
					<td><span data-prefix>$</span><span><input type="text" id="amounts" name="amounts" value="0" style="color: black;" disabled></span></td>
				</tr>
			</table>
		</article>
		<aside>
			<h1><span data-prefix>Additional Notes</span></h1>
			<div data-prefix>
				<p>Do not share this document to others without the permission of CEO.</p>
			</div>
		</aside>
	</body>
</html>

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

	function Quantitykeyupsaa(qty){
	var rates = document.getElementById("rates").value;
	

	var amounts = parseFloat(qty * rates).toFixed(2);

	document.getElementById("amounts").value = parseFloat(amounts).toFixed(2);


  	var table = document.getElementById("myData");
	var i = 0;
	var sum = 0;
	while (i < table.rows.length) {
    //var quantity =(table.rows[i].cells[5];
    //alert("up")
    	var quantity = table.rows[i].cells[3].firstChild.value;
    	
    	
    	var rate = table.rows[i].cells[5].firstChild.value;
    	 //alert(qty)
    	   //alert(quantity)
    	 // alert(rate)
    	var Totalqty = qty * quantity;
    	//alert(Totalqty)
    	var TotalAmount = rate * Totalqty;
    	table.rows[i].cells[4].firstChild.value = parseFloat(Totalqty).toFixed(4);
    	table.rows[i].cells[6].firstChild.value = parseFloat(TotalAmount).toFixed(2);

    	var amount = table.rows[i].cells[6].firstChild.value;
    	sum = sum + parseInt(amount);
    	
    //alert(Totalqty)
    i++;
    
}
//alert(sum)
document.getElementById('TotalAmount').value = sum;
		// var code = $('tr:eq(' + rowIndex + ')', myData).find("td:eq('1')").find('input').val();
	}

		function ProductKeyUp(productID){
			//alert("hjhj")
			$("#myData tr").remove();

			$.ajax({
			type: "GET",
			url: "/productkeyup-change-print?prodID=" + productID,
			success: function(data) {
				if(data.length > 0)
				{
					var Grandamount =0;
					$("#myData tr").remove();

					$.each(data, function(key, value){
			var sum = 0;
			var stock = 0;
			var stockOut = 0;
            var newRow = '<tr>';
           // newRow +=`<td style="padding-top:20px; display:none"><input id="product_id" name="product_id[]" value="${data[key].products.id}" type="text" class="form-control" style="margin-left: 7%; width: 53%;"></td>`;
          newRow +='<td>' + data[key].products.product_code + '</td>';
          newRow +='<td>' + data[key].products.product_name + '</td>';
          newRow +='<td style="text-align: center;">KG</td>';
          newRow +=`<td style="display:none;"><input id="product_id" name="product_id[]" value="${data[key].quantity}" type="text" style="border: none; background: none;" disabled></td>`;
          newRow +=`<td style="text-align: center;"><input id="product_id" name="product_id[]" value="${data[key].quantity}" type="text" style="border: none; background: none;" disabled></td>`;
          newRow +=`<td style="text-align: center;"><input id="product_id" name="product_id[]" value="${data[key].products.product_cost}" type="text" style="border: none; background: none;" disabled></td>`;
          var sum = sum + data[key].amount;
          var amounts = data[key].quantity * data[key].products.product_cost;
           newRow +=`<td style="text-align: center;"><input id="product_id" name="product_id[]" value="${amounts}" type="text" style="border: none; background: none;" disabled></td>`;

             for(i = 0; i < data[key].products.rawmaterial_stock.length; i++){
             			if(data[key].products.rawmaterial_stock[i].stockin != null){
             				var stock = stock + parseInt(data[key].products.rawmaterial_stock[i].stockin);
             				//alert(stock)
             			}
             			if(data[key].products.rawmaterial_stock[i].stockout != null){
             				var stockOut = stockOut + parseInt(data[key].products.rawmaterial_stock[i].stockout);
             			}
				 	   	var total = stock-stockOut;

						 

					  }

         	newRow +=`<td style="text-align: center;"><input id="amount" name="amount[]" value="${total}" type="text" class="form-control" style="border: none; background: none;" disabled></td>`;
            Grandamount = parseFloat(Grandamount) + parseFloat(amounts);


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
			error: function (xhr, ajaxOptions, thrownError) {
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


		function ProductKeyUpAbove(product){
		 var productID = document.getElementById('products_name').value.split("_")[0];
		 var productCode = document.getElementById('products_name').value.split("_")[1];
		 var productCost = document.getElementById('products_name').value.split("_")[2];
		 document.getElementById('products_id').value = productID;
		 document.getElementById('products_code').value = productCode;
		 document.getElementById('rates').value = productCost;

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

   //     $("#product_name").select2();
   //     $("#product_name").next(".select2").find(".select2-selection").focus(function() {
   //     $("#product_name").select2("open");
   // });

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


	// on javascript onclick on product dropdown 

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
</script>