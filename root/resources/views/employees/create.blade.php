@extends("app")
<head>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

</head>
@section("contents")

<h1 class="page-title">Add New Employee</h1>
<!-- Breadcrumb -->
<ol class="breadcrumb breadcrumb-2"> 
	<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
	<li><a href="/employees">Employees</a></li> 
	<li class="active"><strong>Add Employee</strong></li> 
</ol>
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
				<h3 class="panel-title">Add Employee</h3>
				<!-- <ul class="panel-tool-options"> 
					<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
					<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
					<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
				</ul> -->
			</div>
			<div class="panel-body">
				@include('errors.validation')
				{!! Form::open(['url' => 'employees', 'class' => 'form-horizontal', 'id' => 'PartyForm']) !!}
				<div class="form-group"> 
						<label class="col-sm-3 control-label">Employee ID</label>  
						<div class="col-sm-5"> 
						{!! Form::text('code', null, ['id' => 'code','class'=>'form-control', 'autofocus' => 'autofocus', 'onkeydown' => 'focusNext(event);']) !!}
						</div> 
					</div>
					<div class="form-group"> 
						<label class="col-sm-3 control-label">Employee Name</label>  
						<div class="col-sm-5"> 
						{!! Form::text('party_name', null, ['id' => 'party_name','class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
						</div> 
					</div>
					<div class="form-group" style="width: -webkit-fill-available;"> 
						<label class="col-sm-3 control-label">Account&nbsp;Type</label>  
						<div class="col-sm-5"> 
							{!! Form::select('account_show_id', $AccountGroups, null, ['id' => 'account_show_id', 'onchange' => 'AccountName($(this).val().split("_").pop(), $(this).val().split("_")[0]);', 'class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
						</div> 
					</div>
					<div class="form-group" id="SalaryDiv" style=""> 
						<label class="col-sm-3 control-label">Salary</label>  
						<div class="col-sm-5"> 
						{!! Form::text('salary', 0, ['id' => 'salary','class'=>'form-control', 'onkeydown' => 'focusNext(event);', 'onfocus' => 'this.value=""']) !!}
						</div> 
					</div>
					<div class="form-group" id="EmployeeStatusDiv" style=""> 
						<label class="col-sm-3 control-label">Status</label>  
						<div class="col-sm-5"> 
						{!! Form::select('employee_status', array('ACTIVE' => 'ACTIVE', 'INACTIVE' => 'INACTIVE'), null, ['id' => 'employee_status', 'class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
						</div> 
					</div>
					<div class="form-group" style="display: none;"> 
						<label class="col-sm-3 control-label">Account ID</label>  
						<div class="col-sm-5"> 
						{!! Form::text('account_group_id', null, ['id' => 'account_group_id','class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
						</div> 
					</div>
					<div class="form-group" style="display: none;"> 
						<label class="col-sm-3 control-label">Account Type</label>  
						<div class="col-sm-5"> 
						{!! Form::text('account_type', null, ['id' => 'account_type','class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
						</div> 
					</div>
					<div class="form-group"> 
						<label class="col-sm-3 control-label">Phone</label>  
						<div class="col-sm-5"> 
						{!! Form::text('phone', null, ['id' => 'phone','class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
						</div> 
					</div>
					<div class="form-group"> 
						<label class="col-sm-3 control-label">NTN</label>  
						<div class="col-sm-5"> 
						{!! Form::text('ntn', null, ['id' => 'ntn','class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
						</div> 
					</div>
					<div class="form-group"> 
						<label class="col-sm-3 control-label">STRN</label>  
						<div class="col-sm-5"> 
						{!! Form::text('strn', null, ['id' => 'strn','class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
						</div> 
					</div>
					<div class="form-group"> 
						<label class="col-sm-3 control-label">City</label>  
						<div class="col-sm-5"> 
						{!! Form::text('city', null, ['id' => 'city','class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
						</div> 
					</div>
					<div class="form-group"> 
						<label class="col-sm-3 control-label">Address</label>  
						<div class="col-sm-5"> 
						{!! Form::text('address', null, ['id' => 'address','class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
						</div> 
					</div>
					
								
					<div class="line-dashed"></div>
					<center><div class="form-actions">
				  <button type="submit" id="saveButton" onkeydown="submitForm();" class="btn btn-primary">Save Account</button>
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

      $("#account_show_id").select2();
       $("#account_show_id").next(".select2").find(".select2-selection").focus(function() {
       $("#account_show_id").select2("open");
   });



    $('#party_name').on('keydown', function (e) {
        if (e.keyCode === 13)
        {
            $("#account_show_id").select2();
			 $("#account_show_id").next(".select2").find(".select2-selection").focus(function() {
			     $("#account_show_id").select2("open");
			 });
        }
    });

   



	 $('.account_show_id').select2();

	function AccountName(TypeValue, TypeId){
		document.getElementById('account_group_id').value = TypeId;
		document.getElementById('account_type').value = TypeValue;

		if(TypeValue == "EMPLOYEES"){
	 		$('#SalaryDiv').show();
	 		$('#EmployeeStatusDiv').show();
	 	}else{
	 		$('#SalaryDiv').hide();
    			$('#EmployeeStatusDiv').hide();
	 	}
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