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

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading clearfix" id="panelbg">
				<h2 class="panel-title"><b>Edit Attendance</b></h2>

			</div>
		<div class="panel-body">
			<input id="token" type="hidden" value="{{$encrypted_token}}">
			@include('errors.validation')
			
			{!! Form::model($edit, ['method' => 'PATCH', 'action' => ['AttendanceController@update', $edit[0]->id], 'class' => 'form-horizontal' ]) !!}
			<div class="row">
				<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
					<label class="col-sm-1 control-label">Vr. No</label>  
					<div class="col-sm-2"> 
						<div id="year-view" class="input-group date"> 
							{!! Form::text('vr_no', $edit[0]->vr_no,  ['id' => 'vr_no','class'=>'form-control']) !!} 
						</div>
					</div>						
				</div>	
			</div>
			<div class="row">
				<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
					<label class="col-sm-1 control-label">Vr. Date</label>  
					<div class="col-sm-2"> 
						<div id="year-view" class="input-group date"> 
							<!-- <input id="vr_date" type="date" name="vr_date" value="<?php echo date('Y-m-d');?>" class="form-control"> -->

							{!! Form::date('vr_date', $edit[0]->vr_date,  ['id' => 'vr_date','class'=>'form-control']) !!} 
						</div>
					</div>
					<label class="col-sm-1 control-label">Attendance.Date</label>  
					<div class="col-sm-2"> 
						<div id="year-view" class="input-group date"> 
							<!-- <input id="attendance_date" type="date" name="attendance_date" value="<?php echo date('Y-m-d');?>" class="form-control" autofocus> -->

							{!! Form::date('attendance_date', $edit[0]->attendance_date,  ['id' => 'attendance_date','class'=>'form-control', 'autofocus' => 'autofocus']) !!} 
						</div>
					</div>					
				</div>
			</div>

			<div class="row">
				<div class="form-group" style="margin-left: 1%; margin-right: 1%;"> 
					<label class="col-sm-1 control-label">Select&nbsp;Shop</label>
					<div class="col-sm-3"> 
					{!! Form::select('shop_id', $shops, $edit[0]->shop_id, ['id' => 'shop_id',  'onchange' => 'ShopKeyUp($(this).val())', 'onkeydown' => 'focusNext(event);', 'class'=>'form-control']) !!} 
					</div> 					
				</div>
			</div>
	
			{!! Form::hidden('biller_id', Auth::user()->id, ['id' => 'biller_id','class'=>'form-control']) !!}

<div class="panel panel-default">
	<div class="panel-body">	
	<div class="form-group">
		
	
		
	 
	 	<table id="myData">
	 		
	 			@foreach($edit[0]->attendance_details as $detail)
	 			
	 				<div class="container">
         <div class="row">
         <tr>
          
          <!-- <div class="col-md-3" style="margin-left: 1%; margin-right: 1%;">
          <div class="form-group">
          <input id="date" type="datetime-local" name="date[]" value="<?php echo date('Y-m-d\TH:i');?>" class="form-control">
          </div>
          </div> -->
       <input type="hidden" name="employee_id[]" id="employee_id" value="{{$detail->employees->id}}" class="form-control">
       <div class="col-md-2" style="margin-left: 1%; margin-right: 1%;">
       <div class="form-group">
       <input type="text" name="employee_code[]" id="employee_code" value="{{$detail->employees->code}}" class="form-control" disabled>
       </div>
       </div>

        <div class="col-md-4" style="margin-left: 1%; margin-right: 1%;">
        <div class="form-group"> 
        <input type="text" name="employee_name[]" id="employee_name" value="{{$detail->employees->party_name}}" class="form-control" disabled>
        </div>
        </div>

        <div class="col-md-2" style="margin-left: 1%; margin-right: 1%;">
        <div class="form-group"> 
        {!! Form::select('status[]' , array('Present' => 'Present', 'Absent' => 'Absent'), $detail->status , ['id' => 'status', 'class'=>'form-control']) !!}
        <!-- <select id="employee_name" name="employee_name[]" class="form-control">
        <option value="">Present</option>
        <option value="">AB</option>
    	</select>
        <input type="text" name="employee_name[]" id="employee_name" value="{{$detail->employees->party_name}}" class="form-control"> -->
        </div>
        </div>
          </tr>

            
            </div>
            </div>
            
	 			@endforeach
	 		
	</table>

	</div>
	</div>
		</div>


			<center><div class="form-actions">
			  <button type="submit" class="btn btn-primary">Save</button>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.5.1/chosen.min.css">
<script src="/js/plugins/select2/select2.full.min.js"></script>
<script type="text/javascript">

	

	 $("#shop_id").select2();
	 $("#shop_id").next(".select2").find(".select2-selection").focus(function() {
	 $("#shop_id").select2("open");
	    });

	 function ShopKeyUp(ShopsID){
	 	//alert(ShopsID)
	 	$("#myData div").remove();
	 	//$("#myData tr").remove();
	 
	 	

	 	var elem = document.getElementById("myData");
 		elem.parentElement.removeChild(elem);

	 	$.ajax({
			type: "GET",
			url: "/attendance-keyup?ShopID=" + ShopsID,
			success: function(data) {
				if(data.length > 0)
				{
				$.each(data, function(key, value){

            
           var newRow = '<div class="container">';
           newRow += '<div class="row">';
           newRow += '<tr>';
           //date with time
          // newRow +=`<div class="col-md-3" style="margin-left: 1%; margin-right: 1%;">`;
          // newRow +=`<div class="form-group"> `;
          // newRow +=`<input id="date" type="datetime-local" name="date[]" value="<?php echo date('Y-m-d\TH:i');?>" class="form-control">`;
          // newRow +=`</div>`;
          // newRow +=`</div>`;
          newRow +=`<input type="hidden" name="employee_id[]" id="employee_id" value="${data[key].id}" class="form-control">`;
          newRow +=`<div class="col-md-2" style="margin-left: 1%; margin-right: 1%;">`;
          newRow +=`<div class="form-group"> `;
          newRow +=`<input type="text" name="employee_name[]" id="employee_name" value="${data[key].code}" class="form-control" disabled>`;
          newRow +=`</div>`;
          newRow +=`</div>`;

          newRow +=`<div class="col-md-4" style="margin-left: 1%; margin-right: 1%;">`;
          newRow +=`<div class="form-group"> `;
          newRow +=`<input type="text" name="employee_name[]" id="employee_name" value="${data[key].party_name}" class="form-control" disabled>`;
          newRow +=`</div>`;
          newRow +=`</div>`;

          newRow +=`<div class="col-md-2" style="margin-left: 1%; margin-right: 1%;">`;
          newRow +=`<div class="form-group"> `;
          newRow +=`{!! Form::select('status[]', array('Present' => 'Present', 'Absent' => 'Absent'), null, ['id' => 'status', 'class'=>'form-control']) !!}`;
          newRow +=`</div>`;
          newRow +=`</div>`;
          

            '</tr>';
            '</div>';
            '</div>';
            
      			$('#myData').append(newRow);                
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
	 }



</script>
@stop