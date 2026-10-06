@extends("app")
<head>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
</head>
@section("contents")
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
			<div class="panel-heading clearfix">
				<h3 class="panel-title">Collection Milk(Center)</h3>
			</div>
			<div class="panel-body">
				@include('errors.validation')
			{!! Form::model($edit, ['method' => 'PATCH', 'action' => ['CollectionMilkController@update', $edit->id], 'class' => 'form-horizontal' ]) !!}
				{!! Form::hidden('biller_id', null, ['id' => 'biller_id','class'=>'form-control']) !!}

				{!! Form::hidden('location_id', null, ['id' => 'location_id','class'=>'form-control']) !!}
				<div class="row">
					<div class="col-sm-12">
						<label class="col-sm-1 control-label">BillNo</label>  
						<div class="col-sm-1"> 
						{!! Form::text('bill_no', null, ['id' => 'bill_no','class'=>'form-control','autofocus' => 'autofocus', 'onkeydown' => 'focusNext(event);']) !!}
						</div> 
						
						<label class="col-sm-1 control-label">Date</label>  
						<div class="col-sm-2"> 
						@if(Auth::User()->shop_id != 1)
						<input id="date" type="date" value="{{$edit->date}}" name="date" class="form-control" disabled> 
						<!-- {!! Form::text('date', null, ['id' => 'date','class'=>'form-control' , 'disabled' => '']) !!} --> 
						<!-- <input id="date" type="date" value="<?php echo date('Y-m-d');?>" name="date" class="form-control" style="display: none;"> -->
						<input id="date" type="date" value="{{$edit->date}}" name="date" class="form-control" style="display: none;"> 
						@else
						<!-- <input id="date" type="date" value="<?php echo date('Y-m-d');?>" name="date" class="form-control">  -->
						<input id="date" type="date" value="{{$edit->date}}" name="date" class="form-control"> 
						@endif  
						</div> 
						{!! Form::hidden('supplier_id', null, ['id' => 'supplier_id','class'=>'form-control']) !!}
						<label class="col-sm-1 control-label">Code</label>  
						<div class="col-sm-2"> 
						{!! Form::select('suppliers_id', $supplier, null, ['id' => 'suppliers_id', 'onchange' => 'SupplierName($(this).val())', 'class'=>'form-control']) !!}
						
						</div>

						<label class="col-sm-1 control-label">Name</label>  
						<div class="col-sm-3"> 
						{!! Form::text('name', $party[0]->party_name, ['id' => 'name','class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
						</div> 

						 
					</div>
				</div><br>

				<div class="row">
					<div class="col-sm-12">
					<!-- 	<label class="col-sm-1 control-label">Type</label>  
						<div class="col-sm-3"> 
						{!! Form::text('type', null, ['id' => 'type','class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
						</div>  -->
					
						<label class="col-sm-1 control-label">Volume</label>  
						<div class="col-sm-2"> 
						{!! Form::text('volume', null, ['id' => 'volume','class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
						</div>
						<label class="col-sm-1 control-label">Fat</label>  
						<div class="col-sm-2"> 
						{!! Form::text('fat', null, ['id' => 'fat','class'=>'form-control', 'autofocus' => 'autofocus', 'onkeydown' => 'focusNext(event);']) !!}
						</div>

						<label class="col-sm-1 control-label">Lr</label>  
						<div class="col-sm-2"> 
						{!! Form::text('lr', null, ['id' => 'lr','class'=>'form-control', 'onkeyup' => 'calculateFat($(this).val())', 'onkeydown' => 'focusNext(event);']) !!}
						</div>  

						<label class="col-sm-1 control-label">SNF</label>  
						<div class="col-sm-2"> 
						{!! Form::text('snf', null, ['id' => 'snf','class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
						</div>

						
					</div>
				</div><br>

				<div class="row">
					<div class="col-sm-12">
						<label class="col-sm-1 control-label">RATE</label>  
						<div class="col-sm-2"> 
						{!! Form::text('rate', null, ['id' => 'rate','class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
						</div> 
					
						<label class="col-sm-1 control-label">RS-5</label>  
						<div class="col-sm-2"> 
						{!! Form::text('rs5', null, ['id' => 'rs5','class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
						</div>

						<label class="col-sm-1 control-label">RS-13</label>  
						<div class="col-sm-2"> 
						{!! Form::text('rs13', null, ['id' => 'rs13','class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
						</div>  

						<!-- <label class="col-sm-1 control-label">SNF</label>  
						<div class="col-sm-2"> 
						{!! Form::text('snf', null, ['id' => 'snf','class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
						</div> -->
					</div>
				</div><br>

				<div class="row">
					<div class="col-sm-12">
						<!-- <label class="col-sm-1 control-label">FAT RATE</label>  
						<div class="col-sm-2"> 
						{!! Form::text('fat_rate', null, ['id' => 'fat_rate','class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
						</div> --> 
					
						<label class="col-sm-1 control-label">FAT 5%
							<input type="radio" name="type" id="fat5" value="FAT5" {{ $edit->type == 'FAT5' ? 'checked' : '' }} class="check-male"> 
						</label>

						<div class="col-sm-5"> 

						{!! Form::text('fat5p', null, ['id' => 'fat5p','class'=>'form-control', 'onkeydown' => 'focusNext(event)']) !!}
						</div>

						<label class="col-sm-1 control-label">13-TS
							<input type="radio" name="type" id="fat5" value="13TS" {{ $edit->type == '13TS' ? 'checked' : '' }} class="check-female"> 
						</label>  
						<div class="col-sm-5"> 
						{!! Form::text('ts13', null, ['id' => 'ts13','class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
						</div> 

						<!-- <label class="col-sm-1 control-label">Vehicle</label>   -->
						<div class="col-sm-5" style="display: none;"> 
						{!! Form::select('vehicle_id', $vehicles, null, ['id' => 'vehicle_id', 'class'=>'form-control']) !!}
						</div> 

						<!-- <label class="col-sm-1 control-label">TOTAL STOCK</label>  
						<div class="col-sm-2"> 
						{!! Form::text('total', null, ['id' => 'total','class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
						</div> -->
					</div>
				</div><br>
				<div class="row">
					<div class="col-sm-12">
						<label class="col-sm-1 control-label">Comments</label>  
						<div class="col-sm-11"> 
						<!-- {!! Form::textarea('comments', null, ['id' => 'comments','class'=>'form-control', 'row' => '10', 'onkeydown' => 'focusNext(event);']) !!} -->

						<textarea id="comments" name="comments" class="form-control rounded-0" rows="6"></textarea>
						</div> 
					</div>
				</div><br>


							
					<div class="line-dashed"></div>
					<center><div class="form-actions">
				  <button type="submit" id="saveButton" onkeydown="submitForm();" class="btn btn-primary">Save Record</button>
				</div></center>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>
@stop
@section("scripts")
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/jquery-ui.min.js"></script>
<script src="/js/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript">

	function calculateFat(lr){
		var fat = document.getElementById('fat').value;
		//var rate = document.getElementById('rate').value;
		var calculate = 0.25*lr+0.72;
		var calculate2 = 0.22*fat;

		var snf = parseFloat(calculate+calculate2).toFixed(2);

		//var RS5 = snf*rate;
		document.getElementById('snf').value = snf;
		//document.getElementById('rs5').value = RS5;



	}

	$(document).ready(function(){
    $(".check-male").click(function(){
    	var volume = document.getElementById('volume').value;
    	var fat = document.getElementById('fat').value;
    	var fat5 = volume*fat/5;
        document.getElementById('fat5p').value = fat5;
		//RS 5  
        var fatRate = document.getElementById('rate').value;
        var Rs5 = parseFloat(volume*fat/5*fatRate).toFixed(2);
        document.getElementById('rs5').value = Rs5;
    });
    $(".check-female").click(function(){
     
        var snf = parseFloat(document.getElementById('snf').value).toFixed(2);
        
        
        var fat = parseFloat(document.getElementById('fat').value).toFixed(2);
        var volume = parseFloat(document.getElementById('volume').value).toFixed(2);

        var calculate = volume/13;
        // var calculate2 = snf + fat;
        var calculate2 = (parseFloat(snf) + parseFloat(fat)).toFixed(2);
        //alert(calculate)
        
        var TS13 = parseFloat(calculate*calculate2).toFixed(2);
        //var TS13 = (parseFloat(calculate) + parseFloat(calculate2)).toFixed(2);

        document.getElementById('ts13').value = TS13;

		var rate = parseFloat(document.getElementById('rate').value).toFixed(2);
        var totalRs13 = TS13*rate;
        document.getElementById('rs13').value = totalRs13;
        
    });
});



      $("#suppliers_id").select2();
       $("#suppliers_id").next(".select2").find(".select2-selection").focus(function() {
       $("#suppliers_id").select2("open");
   });

       $("#vehicle_id").select2();
       $("#vehicle_id").next(".select2").find(".select2-selection").focus(function() {
       $("#vehicle_id").select2("open");
   });

       $("#shop_id").select2();
       $("#shop_id").next(".select2").find(".select2-selection").focus(function() {
       $("#shop_id").select2("open");
   });

	function SupplierName(SupplierID){
		//alert(SupplierID)
		var SupplierID = document.getElementById('suppliers_id').value.split("_")[0];
		var LocationCode = document.getElementById('suppliers_id').value.split("_")[1];
		var LocationName = document.getElementById('suppliers_id').value.split("_")[2];
		var Rate = document.getElementById('suppliers_id').value.split("_")[3];
		var LocationID = document.getElementById('suppliers_id').value.split("_")[4];
		document.getElementById('supplier_id').value = SupplierID;
		document.getElementById('name').value = LocationName;
		document.getElementById('rate').value = Rate;
		document.getElementById('location_id').value = LocationID;
	}

	var idArray = [
	'code',
	'party_name',
	'account_show_id',
	'phone',
	'ntn',
	'strn',
	'city',
	'address',
	'saveButton'
	];
function focusNext(e){
	try{
	for(var i = 0; i < idArray.length; i++){
		if(e.keyCode === 13 && e.target.id === idArray[i]){
		document.querySelector(`#${idArray[i+1]}`).focus();
		}
	}
	} catch(error){}
}

function submitForm(){
	$( "#PartyForm" ).submit();
}
</script>
@stop