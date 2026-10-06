@extends("app")
<head>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

</head>
@section("contents")
<!-- <body onload="AddRowFunction()"> -->
<body>
<div class="container-fluid">
	@if (Session::has('flash_message'))
	 <div class="alert alert-success alert-dismissible fade in">
			<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right: 4%;">&times;</a>
			<strong>Success!</strong> {{ Session::get('flash_message') }}
		</div>
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
				<h2 class="panel-title"><b>Quotation Voucher</b></h2>
			</div>
		<div class="panel-body">
			<input id="token" type="hidden" value="{{$encrypted_token}}">
			@include('errors.validation')
			{!! Form::open(['url' => 'quotation', 'class' => 'form-horizontal' ]) !!}
				<div class="row">
					<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
						<label class="col-sm-1 control-label">Vr.No#</label>  
					<div class="col-sm-2"> 
						<div id="year-view" class="input-group date"> 
							{!! Form::text('vr_no', $codes, ['id' => 'vr_no','class'=>'form-control', 'required' => 'required', 'onkeyup' => 'focusNext(event);', 'autofocus' => 'autofocus']) !!} 
						</div>
					</div>
						<!-- <label class="col-sm-4 control-label">Sale&nbsp;Type</label>  
						<div class="col-sm-2"> 
							<select class="form-control" onchange="LedgerValues();" id="sale_type" name="sale_type" onkeyup = "focusNext(event);">
								<option value="Cash Sale">Cash Sale</option>
								<option value="Credit Sale">Credit Sale</option>	
							</select>
						</div> --> 							
					</div>
				</div>

				<div class="form-group" style="margin-left: 0px;"> 
					<label class="col-sm-1 control-label">From&nbsp;Date</label>  
						<div class="col-sm-2"> 
							<div id="year-view" class="input-group date"> 
								<input id="from_date" type="date" name="from_date" value="<?php echo date('Y-m-d');?>" class="form-control" onkeyup = "focusNext(event);"> 
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</div>
						</div>
					<label class="col-sm-4 control-label">To&nbsp;Date</label>  
					<div class="col-sm-2" style="margin-left: -6px;"> 
						<div id="year-view" class="input-group date"> 
							<input id="to_date" type="date" name="to_date" value="<?php echo date('Y-m-d');?>" class="form-control" onkeyup = "focusNext(event);" autofocus> 
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</div>
					</div>  
				</div>
				<div class="form-group" style="display: none;"> 
					<label class="col-sm-3 control-label">Biller</label>  
					<div class="col-sm-5"> 
					  <select name="biller" id="biller" class="form-control">
						<option value="{{ Auth::user()->id }}">{{ Auth::user()->name}}</option>
					  </select>
					</div> 
				</div>
				<div class="row">
					<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
						<!-- {!! Form::text('account_id', 1, ['id' => 'party_id', 'class'=>'form-control']) !!}  -->
						<label class="col-sm-1 control-label">Account</label>
						<div class="col-sm-3"> 
								{!! Form::select('account_id', $customers, null, ['id' => 'account_id', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control', 'required' => 'required']) !!} 
								<!-- {!! Form::select('party_name', $customers, null, ['id' => 'party_name',  'onchange' => 'javascript:PartyKeyUp($(this).val());', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control', 'required' => 'required']) !!} -->
						</div> 
						<label class="col-sm-3 control-label">Reference</label>
						<div class="col-sm-3"> 
								{!! Form::select('reference', array('' => 'With Reference','With Referance our telephonic conversation regarding chemicals' => 'With Referance our telephonic conversation regarding chemicals', 'With Referance our meeting in your office regarding chemicals'=> 'With Referance our meeting in your office regarding chemicals', 'With Reference to your email regarding chemicals'=>'With Reference to your email regarding chemicals', 'Other' => 'Other'), null, ['id' => 'reference', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control', 'required' => 'required']) !!}
						</div>
					</div>
				</div>	
				<div class="row">
					<div class="form-group" style="margin-left: 1%; margin-right: 1%;">  
						<label class="col-sm-1 control-label">Our&nbsp;Best&nbsp;Prices&nbsp;On</label>
						<div class="col-sm-3"> 
								{!! Form::select('best_prices', array('' => 'Our&nbsp;Best&nbsp;Prices&nbsp;On','Cash Basis Are Given Below' => 'Cash Basis Are Given Below', '30 Days Credit Basis are given below'=> '30 Days Credit Basis are given below', '60 Days Credit basis are given below'=>'60 Days Credit basis are given below'), null, ['id' => 'best_prices', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control', 'required' => 'required']) !!} 
						</div> 
						<label class="col-sm-3 control-label">Note</label>
						<div class="col-sm-3"> 
								{!! Form::select('note', array('' => 'Select our best prices on', 'Our Prices are on Shop basis' => 'Our Prices are on Shop basis', 'Our Prices are on Factory Deliverd Basis' => 'Our Prices are on Factory Deliverd Basis', 'Our Prices are on City Adda to Adda Deliverd Basis' => 'Our Prices are on City Adda to Adda Deliverd Basis'), null, ['id' => 'note',  'onchange' => 'javascript:PartyKeyUp($(this).val());', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control', 'required' => 'required']) !!} 
						</div>
						
					</div>
				</div>
				<div class="row">
					<div class="form-group" style="margin-left: 1%; margin-right: 1%;">  
						<label class="col-sm-1 control-label">With&nbsp;Best&nbsp;Regards</label>
						<div class="col-sm-3">
							{!! Form::select('best_regards', $users, null, ['id' => 'best_regards', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control', 'required' => 'required']) !!}
						<!-- {!! Form::select('best_regards', array('' => 'Select With Best Regards','Muhammad Parus Butt' => 'Muhammad Parus Butt', 'Muhammad Fahim Butt'=> 'Muhammad Fahim Butt', 'Sarfraz Butt'=>'Sarfraz Butt', 'Moeen Safdar' => 'Moeen Safdar', 'Zaigham Choudhry' => 'Zaigham Choudhry'), null, ['id' => 'best_regards', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control', 'required' => 'required']) !!} --> 
								<!-- {!! Form::select('best_regards', array('' => 'Select With Best Regards','Muhammad Aurangzeb Butt' => 'Muhammad Aurangzeb Butt', 'Muhammad Yasin Janjua'=> 'Muhammad Yasin Janjua', 'Mubassar Ali Butt'=>'Mubassar Ali Butt', 'Shoaib Iqbal Butt' => 'Shoaib Iqbal Butt'), null, ['id' => 'best_regards', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control', 'required' => 'required']) !!} -->
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
		{!! Form::hidden('product_ids', null, ['id' => 'product_ids','class'=>'form-control']) !!}
<div class="col-md-1" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="H.S" class="control-label">Code</label>
		<!-- {!! Form::text('product_code', null, ['id' => 'product_code', 'onkeyup' => 'CodeKeyUp($(this).val());', 'class'=>'form-control']) !!} -->
		{!! Form::text('product_codes', null, ['id' => 'product_codes', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control']) !!}
	</div>
</div> 
<div class="col-md-3" style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="Name" class="control-label">Product Name</label> 
		{!! Form::select('product_names', $products, null, ['id' => 'product_names',  'onchange' => 'ProductKeyUp($(this).val().split("_")[0]);', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control']) !!}
	</div> 
</div> 
<div class="col-md-1" style="margin-right: 1%; display:none;"> 
	<div class="form-group"> 
		<label for="Name" class="control-label">Unit</label> 
		{!! Form::select('uom_ids', $uoms, null, ['id' => 'uom_ids', 'class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
	</div> 
</div> 
<div class="col-md-2"style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Description</label> 
		<!-- <input type="checkbox" id="checkbox7" checked="checked"> -->
		{!! Form::text('descriptions', null, ['id' => 'descriptions', 'class'=>'form-control']) !!}
	</div> 
</div>
<div class="col-md-1"style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Rate(KG/Litter)</label> 
		{!! Form::text('rates', null, ['id' => 'rates', 'onkeyup' => 'SaleRate($(this).val())','class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
	</div> 
</div>
<div class="col-md-1"style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">GST%</label> 
		{!! Form::text('gsts', 17, ['id' => 'gsts', 'onkeyup' => 'GstKeyUp($(this).val())', 'class'=>'form-control', 'onkeydown' => 'focusNext(event);',]) !!}
	</div> 
</div>
<div class="col-md-2"style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Amount</label> 
		{!! Form::text('amounts', null, ['id' => 'amounts', 'onkeyup' => 'AddGridData()', 'class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
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
		<!-- <div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading clearfix" id="panelbg">
						<div class="container">
						  <div class="col-xs-5"><button type="button" onclick="TotalRecords()" class="btn btn-warning">Total Records</button>  </div>
						 
						  <div class="col-xs-3"> <b style="color: black;">Total Rate</b> <input type="text" id="TotalRate" name="TotalRate" value="0" style="color: black;" disabled> </div>
						  <div class="col-xs-3"> <b style="color: black;">Total Amount</b> <input type="text" id="TotalAmount" name="TotalAmount" value="0" style="color: black;" disabled> </div>
						</div> 
					</div>
				</div>
			</div>
		</div> -->
			<center><div class="form-actions">
			  <button type="submit" class="btn btn-primary" id="btnSaves" name="btnSaves">Save</button>
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
<script src="/js/plugins/jasny/jasny-bootstrap.min.js"></script>
<script src="/js/plugins/select2/select2.full.min.js"></script>
<script src="/js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<script src="/js/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
var idArray = ["date", "sale_type", "invoice_no", "localExport", "party_name", "product_code", "product_name", "uom_id", "quantity", "discount_id", "price_per_unit", "balance"];
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

      $("#account_id").select2();
       $("#account_id").next(".select2").find(".select2-selection").focus(function() {
       $("#account_id").select2("open");
   });

       $("#product_names").select2();
       $("#product_names").next(".select2").find(".select2-selection").focus(function() {
       $("#product_names").select2("open");
   });

        $("#reference").select2();
       $("#reference").next(".select2").find(".select2-selection").focus(function() {
       $("#reference").select2("open");
   });

       $("#best_prices").select2();
       $("#best_prices").next(".select2").find(".select2-selection").focus(function() {
       $("#best_prices").select2("open");
   });

       $("#note").select2();
       $("#note").next(".select2").find(".select2-selection").focus(function() {
       $("#note").select2("open");
   });

       $("#best_regards").select2();
       $("#best_regards").next(".select2").find(".select2-selection").focus(function() {
       $("#best_regards").select2("open");
   });

function submitForm(){
	$( "#productsForm" ).submit();
}

function TotalRecords() {
	var rowCount = document.getElementById('myData').rows.length;
	alert("Total Number of Records Are: " + rowCount);
}



	// on javascript onclick on product dropdown 
	function ProductKeyUp(productID){
		//alert(productID)
		$.ajax({
			type: "GET",
			url: "/productkeyup-ajax?prodID=" + productID,
			success: function(result) {
				if(result.length > 0)
				{
					$('#product_codes').val(result[0].product_code);
					$('#product_ids').val(result[0].id);
					$("#rates").val(result[0].product_price);

					var gst = $("#gsts").val();
					var rates = $("#rates").val();

					var totaltax = ((gst/100)*rates);
					var totalAmount = parseInt(totaltax) + parseInt(rates);
					document.getElementById('amounts').value = totalAmount;
				}	
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}				
		});
}

		function GstKeyUp(gst){
			var rates = document.getElementById('rates').value;
			var totaltax = ((gst/100)*rates);
			var totalAmount = parseInt(totaltax) + parseInt(rates);
			document.getElementById('amounts').value = totalAmount;
		}

		function SaleRate(rates){
			var gst = document.getElementById('gsts').value;
			var totaltax = ((gst/100)*rates);
			var totalAmount = parseInt(totaltax) + parseInt(rates);
			document.getElementById('amounts').value = totalAmount;
		}

	function PartyKeyUp(partyId){
		$.ajax({
			type: "GET",
			url: "/partyonchange-ajax?party_id=" + partyId,
			success:function(result)
			{
				if(result.length > 0){
					$('#party_ids').val(result[0].id);
					$('#addresss').val(result[0].address);
					$('#strns').val(result[0].strn);
					$('#ntns').val(result[0].ntn);
					$('#citys').val(result[0].city);
				}
			}
		})
	}

		function myDeleteFunction(row) {
		alertify.confirm("Are you sure you want to delete this row?", function (e) {
		    if (e) {
		    	$(row).remove();
		        // alertify.alert("Record is Removed!");
		    } else {
		        alertify.alert("Record is safe!");
		    }
		});
		// if(confirm("Are you sure you want to delete this row?"))
		// {
		// 	$(row).remove();
		// }
	}

	function AddGridData(){
		var ProductId = document.getElementById('product_ids').value;
		var ProductCode = document.getElementById('product_codes').value;
		var ProductName = document.getElementById('product_names').value.split("_").pop();
		var UOMID = document.getElementById('uom_ids').value.split("_")[0];
		var UOM = document.getElementById('uom_ids').value.split("_").pop();
		var Description = document.getElementById('descriptions').value;
		var Rate = document.getElementById('rates').value;
		var GST = document.getElementById('gsts').value;
		var Amount = document.getElementById('amounts').value;
		

		// var grandRate = parseInt(Price) + parseInt(TotalRate);
		// var grandAmount = parseInt(Amount) + parseInt(totalAmount);
		// document.getElementById('TotalRate').value = grandRate;
		// document.getElementById('TotalAmount').value = grandAmount;

		var tableHtml = '<tr>';
		//0
		//tableHtml += '<td>'+ ProductId +'</td>';
		tableHtml += `<td style="display:none;"><input id="product_id" name="product_id[]" value="${ProductId}" type="text" class="form-control"></td>`;
		//1
		//tableHtml += '<td>'+ ProductCode +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="product_code" name="product_code[]" value="${ProductCode}" type="text" class="form-control" style="margin-left: 7%; width: 53%;"></td>`;
    	//2
		//tableHtml += '<td>'+ ProductName +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="product_name" name="product_name[]" value="${ProductName}" type="text" class="form-control" style="margin-left: -35%; width: 156%;"></td>`;
    	//3
    tableHtml += `<td style="display:none;"><input id="uom_id" name="uom_id[]" value="${UOMID}" type="text" class="form-control" style="margin-left: -25%;
    width: 120%;"></td>`;
    	//4
    tableHtml += `<td style="padding-top:20px;display:none;"><input id="uom" name="uom[]" value="${UOM}" type="text" class="form-control" style="margin-left: 60%;
    width: 79%;"></td>`;
    	//5

    	tableHtml += `<td style="padding-top:20px;"><input id="description" name="description[]" value="${Description}" type="text" class="form-control" style="margin-left: 28%;
	    	width: 103%;"></td>`;
		 //11
		 tableHtml += `<td style="padding-top:20px;"><input id="rate" name="rate[]" value="${Rate}" type="text" class="form-control" style="margin-left: 38%; width: 51%;"></td>`;
		 tableHtml += `<td style="padding-top:20px;"><input id="gst" name="gst[]" value="${GST}" type="text" class="form-control" style="margin-left:-4%; width: 51%;"></td>`;
		 //11
		 tableHtml += `<td style="padding-top:20px;"><input id="amount" name="amount[]" value="${Amount}" type="text" class="form-control" style="margin-left: -46%;
	    	width: 102%;"></td>`;
		// document.getElementById('test').value=Price;
		// tableHtml += '<td>'+ Amount +'</td>';
		//12
		tableHtml += '<td style="padding-top: 20px;"><button class="btn btn-red" type="button" style="margin-left: -160%;"> <i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-trash" title="Delete Row"></i></button></td>';
		tableHtml += '</tr></br>';
		$('#myData').append(tableHtml);
		document.getElementById("product_codes").focus();
	}
</script>
@stop