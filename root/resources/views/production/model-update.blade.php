	<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!-- Modal content-->
    <div class="modal-content" style="width: 150%;float: left;margin-left: -25%;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Production Voucher</h4>
      </div>
      <div class="modal-body">
      {!! Form::model($sale->id, ['method' => 'PATCH', 'action' => ['App\Http\Controllers\ProductionController@update', $sale->id], 'class' => 'form-horizontal' ]) !!}

        {!! Form::hidden('id', null, ['id' => 'id','class'=>'form-control',]) !!}
        {!! Form::hidden('biller', Auth::User()->id,  ['id' => 'biller','class'=>'form-control']) !!}
        	<div class="row">
				<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
					<label class="col-sm-1 control-label">Voucher #</label>  
					<div class="col-sm-2"> 
						{!! Form::text('vr_no', null, ['id' => 'vr_no','class'=>'form-control', 'required' => 'required', 'autofocus' => 'autofocus']) !!} 
					</div>
					<div class="col-sm-2"> </div>
					<!-- <label class="col-sm-1 control-label">Date</label>  
					<div class="col-sm-2"> 
						<div class='input-group date' id='datetimepicker1'>
							<input id="date" type="text" name="date" class="form-control"> 
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</div>
					</div> -->							
				</div>
			</div>
			
				<div class="row">
					<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
						<label class="col-md-1 control-label">Date</label>  
						<div class="col-sm-2"> 
							<div id="year-view" class="input-group date"> 
								<input id="date" type="date" name="date" value="<?php echo date('Y-m-d');?>" class="form-control" onkeyup = "focusNext(event);" autofocus> 
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</div>
						</div>
						<div class="col-sm-2"> </div>
						<label class="col-md-1 control-label">Product&nbsp;Code</label>  
						<div class="col-md-2">
							{!! Form::text('products_code', null, ['id' => 'products_code', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control']) !!}
						</div> 						
					</div>
				</div>
				
				<div class="row">
					<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
						<label class="col-md-1 control-label">Select&nbsp;Product</label>  
						<div class="col-md-2"> 
							{!! Form::select('products_name', $products, $sale->products_id, ['id' => 'products_name', 'onchange' => 'ProductKeyUp($(this).val());', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control']) !!}  
						</div>
						<div class="col-sm-2"> </div>
						<label class="col-md-1 control-label">Quantity</label>  
						<div class="col-md-2">
							{!! Form::text('quantitys', null, ['id' => 'quantitys', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control']) !!}
						</div> 						
					</div>
				</div>
			
				<div class="row">
					<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
						<label class="col-md-1 control-label">Select UOM</label>  
						<div class="col-md-2"> 
							{!! Form::select('uoms_id', $uoms, $sale->uoms_id, ['id' => 'uoms_id', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control']) !!}  
						</div>
						<div class="col-sm-2"> </div>
						<label class="col-md-1 control-label">Rate</label>  
						<div class="col-md-2">
							{!! Form::text('rates', null, ['id' => 'rates', 'onkeydown' => 'focusNext(event);', 'onkeyup' => 'RateKeyUp($(this).val());', 'class'=>'form-control']) !!}
						</div> 	
						<div class="col-md-2">
							{!! Form::text('amounts', null, ['id' => 'amounts', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control']) !!}
						</div> 					
					</div>
				</div>
				</br>
					<div class="row">
					<div class="col-lg-12">

<div class="panel panel-default">
 <div class="panel-body">	
  <div class="form-group">
   <table  id="myTable">
    <div class="container-fluid">
     <div class="row">
	<tr> 							
<div class="col-md-1" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="Tracking" class="control-label">Code#</label>
		{!! Form::text('product_code', null, ['id' => 'product_code',  'class'=>'form-control']) !!}
	</div>
</div> 
<div class="col-md-2" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="Sender" class="control-label">Product&nbsp;Name</label> 
		{!! Form::select('product_name', $products, null, ['id' => 'product_name',  'onchange' => 'ProductKeyUps($(this).val().split("_")[0]);', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control']) !!}
	</div> 
</div> 
<div class="col-md-2" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="Delivery" class="control-label">Unit</label> 
		{!! Form::select('uom_id', $uoms, null, ['id' => 'uom_id',  'class'=>'form-control']) !!}
	</div> 
</div> 
<div class="col-md-2" style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="Destination" class="control-label">Quantity</label> 
		{!! Form::text('quantity', null, ['id' => 'quantity', 'onkeyup' => 'QuantityKeyUp($(this).val())',  'class'=>'form-control']) !!}
	</div> 
</div>
<div class="col-md-1"style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="Weight" class="control-label">Rates</label> 
		{!! Form::text('rate', null, ['id' => 'rate', 'onkeyup' => 'SaleRate($(this).val())', 'class'=>'form-control']) !!}
	</div> 
</div>
<div class="col-md-1"style="margin-left: 1%; margin-right: 1%;"> 
	<div class="form-group"> 
		<label for="Pieces" class="control-label">Amount</label> 
		{!! Form::text('amount', null, ['id' => 'amount',  'class'=>'form-control']) !!}
	</div> 
</div>
<div class="col-md-1"> 
	<div class="form-group"> 
		<label for="password" class="control-label">Add</label>
		<button class="form-control" type="button" class="btn btn-success" onkeyup="AddGridData();" style="background: #28ef10;">Add</button>
	</div> 
</div>

</tr>
<div id="myData">

</div>
</div>
</div>
</table></br></br>
	</div>
		</div>
		</div>
		<div class="row" style="display: none;">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading clearfix">
						<div class="container">
						  <div class="col-xs-5">  </div>
						  <div class="col-xs-3"> <b>Total InPCS</b> <input type="text" id="TotalIN" value="{{'1'}}" name="TotalIN" disabled	> </div>
						  <div class="col-xs-3"> <b>Total OutPCS</b> <input type="text" id="TotalOUT" value="{{'1'}}" name="TotalOUT" disabled> </div>
						</div> 
					</div>
				</div>
			</div>
		</div>


		</div>
	</div>

			<!-- <div class="line-dashed"></div> -->
			<center><div class="form-actions">
		  <!-- <button type="submit" class="btn btn-primary">Save</button> -->
		</div></center>
		<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
		{!! Form::close() !!}
      </div>
      
    </div>
  </div>
</div>