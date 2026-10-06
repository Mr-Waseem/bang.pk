@extends("app")
@section("contents")
<h1 class="page-title">Edit Account</h1>
<!-- Breadcrumb -->
<ol class="breadcrumb breadcrumb-2"> 
	<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
	<li><a href="/parties">Chart Of Account</a></li> 
	<li class="active"><strong>Edit Account</strong></li> 
</ol>
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading clearfix">
				<h3 class="panel-title">Edit Account</h3>
				<!-- <ul class="panel-tool-options"> 
					<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
					<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
					<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
				</ul> -->
			</div>
			<div class="panel-body">
				@include('errors.validation')
		{!! Form::model($edit, ['method' => 'PATCH', 'action' => ['App\Http\Controllers\EmployeeController@update', $edit->id], 'class' => 'form-horizontal' ]) !!}
		<div class="form-group"> 
						<label class="col-sm-3 control-label">Account Name</label>  
						<div class="col-sm-5"> 
						{!! Form::text('party_name', null, ['id' => 'party_name','class'=>'form-control', 'autofocus' => 'autofocus']) !!}
						</div> 
					</div>
					<div class="form-group" style="width: -webkit-fill-available;"> 
						<label class="col-sm-3 control-label">Account&nbsp;Type</label>  
						<div class="col-sm-5"> 
							{!! Form::select('account_show_id', $AccountGroups, $edit->id, ['id' => 'account_show_id', 'onchange' => 'AccountName($(this).val().split("_").pop(), $(this).val().split("_")[0]);', 'class'=>'form-control livesearch']) !!}
						</div> 
					</div>
					<div class="form-group" style="display:none;"> 
						<label class="col-sm-3 control-label">Account ID</label>  
						<div class="col-sm-5"> 
						{!! Form::text('account_group_id', null, ['id' => 'account_group_id','class'=>'form-control',]) !!}
						</div> 
					</div>
					<div class="form-group"> 
						<label class="col-sm-3 control-label">Account Type</label>  
						<div class="col-sm-5"> 
						{!! Form::text('account_type', null, ['id' => 'account_type','class'=>'form-control', 'disabled' => 'disabled']) !!}
						</div> 
					</div>
					<div class="form-group" id="SalaryDiv" style=""> 
						<label class="col-sm-3 control-label">Salary</label>  
						<div class="col-sm-5"> 
						{!! Form::text('salary', null, ['id' => 'salary','class'=>'form-control', 'onkeydown' => 'focusNext(event);', 'onfocus' => 'this.value=""']) !!}
						</div> 
					</div>
					<div class="form-group" id="EmployeeStatusDiv" style=""> 
						<label class="col-sm-3 control-label">Status</label>  
						<div class="col-sm-5"> 
						{!! Form::select('employee_status', array('ACTIVE' => 'ACTIVE', 'INACTIVE' => 'INACTIVE'), null, ['id' => 'employee_status', 'class'=>'form-control', 'onkeydown' => 'focusNext(event);']) !!}
						</div> 
					</div>
					<div class="form-group"> 
						<label class="col-sm-3 control-label">Phone</label>  
						<div class="col-sm-5"> 
						{!! Form::text('phone', null, ['id' => 'phone','class'=>'form-control',]) !!}
						</div> 
					</div>
					<div class="form-group"> 
						<label class="col-sm-3 control-label">NTN</label>  
						<div class="col-sm-5"> 
						{!! Form::text('ntn', null, ['id' => 'ntn','class'=>'form-control',]) !!}
						</div> 
					</div>
					<div class="form-group"> 
						<label class="col-sm-3 control-label">STRN</label>  
						<div class="col-sm-5"> 
						{!! Form::text('strn', null, ['id' => 'strn','class'=>'form-control',]) !!}
						</div> 
					</div>
					<div class="form-group"> 
						<label class="col-sm-3 control-label">City</label>  
						<div class="col-sm-5"> 
						{!! Form::text('city', null, ['id' => 'city','class'=>'form-control',]) !!}
						</div> 
					</div>
					<div class="form-group"> 
						<label class="col-sm-3 control-label">Address</label>  
						<div class="col-sm-5"> 
						{!! Form::text('address', null, ['id' => 'address','class'=>'form-control',]) !!}
						</div> 
					</div>	
		<div class="line-dashed"></div>
		<center><div class="form-actions">
	  <button type="submit" class="btn btn-primary">Update Client</button>
	</div></center>
	{!! Form::close() !!}
</div>
	</div>
</div>
</div>
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
	function AccountName(TypeValue, TypeId){
		document.getElementById('account_group_id').value = TypeId;
		document.getElementById('account_type').value = TypeValue;
	}
</script>
@stop