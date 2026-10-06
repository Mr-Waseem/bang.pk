@extends("app")
@section("head")
<!-- Entypo font stylesheet -->
<link href="/css/entypo.css" rel="stylesheet">
<!-- /entypo font stylesheet -->

<!-- Font awesome stylesheet -->
<link href="/css/font-awesome.min.css" rel="stylesheet">
<!-- /font awesome stylesheet -->

<!-- Bootstrap stylesheet min version -->
<link href="/css/bootstrap.min.css" rel="stylesheet">
<!-- /bootstrap stylesheet min version -->

<!-- Mouldifi core stylesheet -->
<link href="/css/mouldifi-core.css" rel="stylesheet">
<!-- /mouldifi core stylesheet -->

<link href="/css/plugins/datepicker/bootstrap-datepicker.css" rel="stylesheet">
<link href="/css/plugins/colorpicker/bootstrap-colorpicker.css" rel="stylesheet">
<link href="/css/plugins/nouislider/nouislider.css" rel="stylesheet">
<link href="/css/plugins/select2/select2.css" rel="stylesheet">
<link href="/css/mouldifi-forms.css" rel="stylesheet" >
@stop
@section("contents")
			<div class="container-fluid">
				@if (Session::has('flash_message'))
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="margin-right: 20px;margin-top: 15px;">&times;</button>
					<div class="alert alert-success"> {{ Session::get('flash_message') }} </div>
				@endif
			</div>
			<h1 class="page-title">Edit Ledger</h1>
			<!-- Breadcrumb -->
			<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
				<li><a href="/ledger/create">Ledger</a></li> 
				<li class="active"><strong>Add Entry</strong></li> 
			</ol>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">Edit Ledger</h3>
							<ul class="panel-tool-options"> 
								<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
								<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
								<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
							</ul>
						</div>
						<div class="panel-body">
							@include('errors.validation')
					{!! Form::model($edit, ['method' => 'PATCH', 'action' => ['LedgerController@update', $edit->id], 'class' => 'form-horizontal' ]) !!}
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Date</label>  
									<div class="col-sm-3"> 
										<div id="year-view" class="input-group date"> 
											<input id="date" type="text" name="date" value="{{$edit->date}}" class="form-control"> 
											<span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
										</div>
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Party Name</label>  
									<div class="col-sm-5"> 
									{!! Form::select('party_id', $parties, null, ['id' => 'party_id','class'=>'form-control']) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Particulars</label>  
									<div class="col-sm-5"> 
									{!! Form::textarea('particulars', null, ['id' => 'particulars', 'rows' => '3', 'class'=>'form-control']) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Bill No</label>  
									<div class="col-sm-5"> 
									{!! Form::text('bill_no', null, ['id' => 'bill_no','class'=>'form-control']) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Debit</label>  
									<div class="col-sm-5"> 
									{!! Form::text('debit', null, ['id' => 'address','class'=>'form-control',]) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Credit</label>  
									<div class="col-sm-5"> 
									{!! Form::text('credit', null, ['id' => 'credit','class'=>'form-control',]) !!}
									</div> 
								</div>
								
								<div class="line-dashed"></div>
								<center><div class="form-actions">
							  <button type="submit" class="btn btn-primary">Save</button>
							</div></center>
							{!! Form::close() !!}
						</div>
					</div>
				</div>
			</div>
@stop
@section("scripts")
<script src="/js/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/plugins/metismenu/jquery.metisMenu.js"></script>
<script src="/js/plugins/blockui-master/jquery-ui.js"></script>
<script src="/js/plugins/blockui-master/jquery.blockUI.js"></script>
<!--nouiSlider-->
<script src="/js/plugins/nouislider/nouislider.min.js"></script>
<!-- Input Mask-->
<script src="/js/plugins/jasny/jasny-bootstrap.min.js"></script>
<!-- Select2-->
<script src="/js/plugins/select2/select2.full.min.js"></script>
<!--Bootstrap ColorPicker-->
<script src="/js/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
<!--Bootstrap DatePicker-->
<script src="/js/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
$('#date').datepicker({
			startView: 2,
			keyboardNavigation: false,
			forceParse: false,
			format: "dd/mm/yyyy"
		});
</script>
@stop