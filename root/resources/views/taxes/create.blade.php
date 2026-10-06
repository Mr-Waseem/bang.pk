@extends("app")
@section("contents")
<h1 class="page-title">Add Tax Rate</h1>
			<!-- Breadcrumb -->
			<ol class="breadcrumb breadcrumb-2"> 
				<li><a href="/dashboard"><i class="fa fa-home"></i>Home</a></li> 
				<li><a href="/taxes">Tax Rates</a></li> 
				<li class="active"><strong>Add Tax Rate</strong></li> 
			</ol>
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">Add Tax Rate</h3>
							<ul class="panel-tool-options"> 
								<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
								<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
								<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
							</ul>
						</div>
						<div class="panel-body">
							@include('errors.validation')
							{!! Form::open(['url' => 'taxes', 'class' => 'form-horizontal' ]) !!}
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Tax Title</label>  
									<div class="col-sm-5"> 
									{!! Form::text('tax_title', null, ['id' => 'tax_title','class'=>'form-control',]) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Tax Rate</label>
									<div class="col-sm-5"> 
									{!! Form::text('tax_rate', null, ['id' => 'tax_rate','class'=>'form-control',]) !!}
									</div> 
								</div>
								<div class="form-group"> 
									<label class="col-sm-3 control-label">Tax Type</label>
									<div class="col-sm-5"> 
									{!! Form::select('tax_type', array('Percentage (%)' => 'Percentage (%)', 'Fixed ($)' =>  'Fixed ($)'), null, ['id' => 'tax_type', 'class'=>'form-control',]) !!}
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