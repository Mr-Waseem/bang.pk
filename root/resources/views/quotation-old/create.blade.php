@extends("app")
@section("contents")
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="index.html">Home</a>
					<i class="icon-angle-right"></i> 
				</li>
				<li>
					<i class="icon-edit"></i>
					<a href="/quotation">Quotation</a>
				</li>
			</ul>
			<div class="container-fluid">
				@if (Session::has('flash_message'))
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="margin-right: 20px;margin-top: 15px;">&times;</button>
					<div class="alert alert-success"> {{ Session::get('flash_message') }} </div>
				@endif
			</div>
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon edit"></i><span class="break"></span>Add Quotation</h2>
						<div class="box-icon">
							<a href="#" class="btn-setting"><i class="halflings-icon wrench"></i></a>
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
					@include('errors.validation')
					{!! Form::open(['url' => 'quotation', 'class' => 'form-horizontal' ]) !!}
						  <fieldset>
							<div class="control-group">
							  <label class="control-label" for="date01">Product Name</label>
							  <div class="controls">
							  {!! Form::text('product_name', null, ['id' => 'product_name','class'=>'span6 typeahead']) !!}
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="typeahead">Weight </label>
							  <div class="controls">
							  {!! Form::text('weight', null, ['id' => 'weight','class'=>'span6 typeahead']) !!}
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="typeahead">Price </label>
							  <div class="controls">
							  {!! Form::text('price', null, ['id' => 'price', 'class'=>'span6 typeahead']) !!}
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="typeahead">Origin </label>
							  <div class="controls">
							  {!! Form::text('origin', null, ['id' => 'origin','class'=>'span6 typeahead']) !!}
							  </div>
							</div>
							<div class="control-group">
							  <label class="control-label" for="typeahead">Sales Tax </label>
							  <div class="controls">
							  {!! Form::text('sales_tax', null, ['id' => 'sales_tax','class'=>'span6 typeahead']) !!}
							  </div>
							</div>

							<div class="form-actions">
							  <button type="submit" class="btn btn-primary">Save changes</button>
							  <button type="reset" class="btn">Cancel</button>
							</div>
						  </fieldset>
						{!! Form::close() !!} 

					</div>
				</div><!--/span-->

			</div><!--/row-->

@stop