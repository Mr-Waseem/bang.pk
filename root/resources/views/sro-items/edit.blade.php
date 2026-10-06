@extends("app")
@section("contents")
<h1 class="page-title">Edit SRO Item</h1>

			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">Edit SRO Item</h3>
						</div>
						<div class="panel-body">
							@include('errors.validation')
							{!! Form::model($edit, ['method' => 'PATCH', 'action' => ['App\Http\Controllers\SROItemnoController@update', $edit->id], 'class' => 'form-horizontal' ]) !!}
							<div class="form-group"> 
									<label class="col-sm-3 control-label">SRO Item No</label>  
									<div class="col-sm-5"> 
									{!! Form::text('sro_item_no', null, ['id' => 'sro_item_no','class'=>'form-control',]) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Choose Scenario</label>
									<div class="col-sm-5"> 
									{!! Form::select('scenario_id', $scenario, null, ['id' => 'scenario_id','class'=>'form-control',]) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Choose SRO Schedule</label>
									<div class="col-sm-5"> 
									{!! Form::select('sro_schedule_id', $sroschedule, null, ['id' => 'sro_schedule_id','class'=>'form-control',]) !!}
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
@section('scripts')
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <script type="text/javascript">
        $("#scenario_id").select2();
        $("#scenario_id").next(".select2").find(".select2-selection").focus(function() {
            $("#scenario_id").select2("open");
        });
		$("#sro_schedule_id").select2();
        $("#sro_schedule_id").next(".select2").find(".select2-selection").focus(function() {
            $("#sro_schedule_id").select2("open");
        });
		
		</script>
@stop