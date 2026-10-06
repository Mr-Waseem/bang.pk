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
				<h2 class="panel-title"><b>Create Rate</b></h2>
			</div>
		<div class="panel-body">
			<input id="token" type="hidden" value="{{$encrypted_token}}">
			@include('errors.validation')
			{!! Form::open(['url' => 'product-rates', 'class' => 'form-horizontal' ]) !!}
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
						<label class="col-sm-4 control-label">Customer&nbsp;Code</label>  
						<div class="col-sm-2"> 
							{!! Form::text('customer_code', null, ['id' => 'customer_code','class'=>'form-control']) !!} 
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
						{!! Form::hidden('customer_id', null, ['id' => 'customer_id', 'class'=>'form-control']) !!} 
						<label class="col-sm-1 control-label">Select&nbsp;Customer</label>
						<div class="col-sm-3"> 
						<!-- {!! Form::select('customer_name', $customer, null, ['id' => 'customer_name',  'onchange' => 'RecipeKeyUp($(this).val());', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control', 'required' => 'required']) !!}  -->

						{!! Form::select('customer_name', $customer, null, ['id' => 'customer_name',  'onchange' => 'RecipeKeyUp($(this).val().split("_")[0]), ProductKeyUpBelow($(this).val().split("_")[0]);', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control', 'required' => 'required']) !!}
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
<div class="col-md-2" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="H.S" class="control-label">Code</label>
		<!-- {!! Form::text('product_code', null, ['id' => 'product_code', 'onkeyup' => 'CodeKeyUp($(this).val());', 'class'=>'form-control']) !!} -->
		{!! Form::text('product_code', null, ['id' => 'product_code', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control', 'onfocus' => 'this.value=""']) !!}
	</div>
</div> 
<div class="col-md-5" style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="Name" class="control-label">Product Name</label> 
		{!! Form::select('product_name', $products, null, ['id' => 'product_name',  'onchange' => 'ProductKeyUps($(this).val().split("_")[0]); if(event.keyCode == 187) form.Submit()', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control']) !!}
	</div> 
</div> 


 
<div class="col-md-3"style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Rate</label> 
		{!! Form::text('rate', null, ['id' => 'rate', 'class'=>'form-control', 'onkeydown' => 'focusNext(event);', 'onfocus' => 'this.value=""']) !!}
	</div> 
</div>

<div class="col-md-1"style="margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Add Record</label> 
		<!-- <button class="btn btn-success" id="add" onkeyup="AddGridData();" onkeydown="focusNext(event)" type="button" style=""> <i  class="icon-plus" title="Delete Row"></i></button> -->
		<input type="text" class="form-control" Value="Add" id="add" name="add" onkeydown="focusNext(event);" onkeyup="AddGridData();" style="background-color: green; width: 50%; color: white;">
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

		function RecipeKeyUp(CustomerID){
		var RecipeID = document.getElementById('customer_name').value.split("_")[0];
		var RecipeCode = document.getElementById('customer_name').value.split("_")[1];
		var RecipeName = document.getElementById('customer_name').value.split("_")[2];
		document.getElementById('customer_id').value = RecipeID;
		document.getElementById('customer_code').value = RecipeCode;
		// document.getElementById('products_name').value = productName;

		$.ajax({
			type: "GET",
			url: "/ratekeyup-ajax?cusID=" + CustomerID,
			success: function(result) {
				if(result.length > 0)
				{
					$('#vr_no').val(result[0].vr_no);
					
				}	
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}				
		});
		
	}



		function ProductKeyUpBelow(CustomerID){
					
			$("#myData tr").remove();
			$.ajax({
			type: "GET",
			url: "/customer-rate-change?cusID=" + CustomerID,
			success: function(data) {
				if(data.length > 0)
				{
					var Grandamount =0;
					var quantity =0;
					$("#myData tr").remove();

					$.each(data, function(key, value){

            var newRow = '<tr>';
          // newRow +=`<td style="padding-top:20px; display:none"><input id="product_id" name="product_id[]" value="${data[key].product.id}" type="text" class="form-control" style="margin-left: 7%; width: 53%;"></td>`;

            newRow +=`<td style="padding-top:20px;"><input id="product_code" name="product_code[]" value="${data[key].product.product_code}" type="text" class="form-control" style="margin-left: 7%; width: 106%;"></td>`;

            newRow +=`<td style="padding-top:20px; display:none;"><input id="product_id" name="product_id[]" value="${data[key].product.id}" type="hidden" class="form-control"></td>`;

			newRow +=`<td style="padding-top:20px;"><input id="product_name" name="product_name[]" value="${data[key].product.product_name}" type="text" class="form-control" style="margin-left: 21%; width: 267%;"></td>`;

			newRow +=`<td style="padding-top:20px;"><input id="product_rate" name="product_rate[]" value="${data[key].rate}" type="text" class="form-control" style="margin-left: 195%; width: 161%;"></td>`;

            newRow +=`<td style="padding-top: 20px;"><button class="btn btn-red" type="button" style="margin-left: 1280%;"> <i onclick="javascript:myDeleteFunction($(this).closest('tr'));" class="icon-trash" title="Delete Row"></i></button></td>`;

            '</tr>';
      			$('#myData').append(newRow);
                    document.getElementById("product_code").focus();
                });

				}	
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}				
		});
	}




	    $("#customer_name").select2();
	    $("#customer_name").next(".select2").find(".select2-selection").focus(function() {
	    $("#customer_name").select2("open");
	   });

       $("#product_name").select2();
       $("#product_name").next(".select2").find(".select2-selection").focus(function() {
       $("#product_name").select2("open");
   });



	function TotalRecords() {
		var rowCount = document.getElementById('myData').rows.length;
		alert("Total Number of Records Are: " + rowCount);
	}


	// on javascript onclick on product dropdown 

	function ProductKeyUps(recipeID){
		// alert(recipeID)
		$.ajax({
			type: "GET",
			url: "/productkeyup-recipe?prodID=" + recipeID,
			success: function(result) {
				if(result.length > 0)
				{
					$('#product_code').val(result[0].product_code);
					$('#rate').val(result[0].product_price);
					$('#product_id').val(result[0].id);
				}	
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}				
		});
}







		function myDeleteFunction(row) {
		alertify.confirm("Are you sure you want to delete this row?", function (e) {
		    if (e) {
		    	
		    	$(row).remove();
		    	document.getElementById("product_code").focus();
		        // alertify.alert("File is Removed!");
		    } 
		    else {
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
		var Price = document.getElementById('rate').value;

		var tableHtml = '<tr>';
		//0
		//tableHtml += '<td>'+ ProductId +'</td>';
		tableHtml += `<td style="display:none;"><input id="product_id" name="product_id[]" value="${ProductId}" type="text" class="form-control"></td>`;
		//1
		//tableHtml += '<td>'+ ProductCode +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="product_code" name="product_code[]" value="${ProductCode}" type="text" class="form-control" style="margin-left: 7%; width: 106%;"></td>`;
    	//2
		//tableHtml += '<td>'+ ProductName +'</td>';
		tableHtml += `<td style="padding-top:20px;"><input id="product_name" name="product_name[]" value="${ProductName}" type="text" class="form-control" style="margin-left: 20%;
    width: 268%;"></td>`;
    	//3
		 tableHtml += `<td style="padding-top:20px;"><input id="product_rate" name="product_rate[]" value="${Price}" type="text" class="form-control" style="margin-left:195%; width: 161%;"></td>`;

		tableHtml += '<td style="padding-top: 20px;"><button class="btn btn-red" type="button" style="margin-left: 1290%;"> <i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-trash" title="Delete Row"></i></button></td>';
		tableHtml += '</tr></br>';
		$('#myData').append(tableHtml);
		document.getElementById("product_code").focus();
	}
</script>
@stop