@extends("app")
@section("contents")
<h1 class="page-title">Add SRO Item</h1>

			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix">
							<h3 class="panel-title">Add SRO Item</h3>
						
						</div>
						<div class="panel-body">
							@include('errors.validation')
							{!! Form::open(['url' => 'sro-items', 'class' => 'form-horizontal' ]) !!}
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

		$('#scenario_id').change(function() {
            var scenario_id = $(this).val();
            // alert(scenario_id)
            $.ajax({
                url: "{{ asset('sro-item/getsroitem/scenarion') }}",
                type: 'get',
                data: {
                    scenario_id: scenario_id
                },
                dataType: 'json',
                success: function(response) {
                    if (response.data != '') {
						// alert("suc");
                        var option = '';
                        option +=`<option value="">Select Schedule</option>`;
                        $.each(response.data, function(i, v) {
                            option +=`<option value="${v.id}">${v.sro_schedule_name}</option>`;
                        });
                        $('#sro_schedule_id').html(option);
                        $("#sro_schedule_id").select2('open');
                        }else{
                            var option = '';
                            option +=`<option value="0">No Records Found</option>`; 
                            $('#sro_schedule_id').html(option);  
                        }
                    // if (response.company == false) {
                    //     // alert("1")
                    //     if (response.products.length > 0) {
                    //         $('#unit1').val(response.products[0].product.uom);
                    //         $('#packing1').val(parseFloat(response.products[0].product.packing));
                    //         $('#s_tax1').val(parseFloat(response.products[0].product.tax));

                            
                    //         var option = `<option value="" selected>Select Customer Products</option>`;
                    //         $.each(response.products, function(i, v) {
                    //             option +=
                    //                 // `<option value="${v.id}_${v.product.uom}_${v.product.packing}_${v.product.tax}_${v.product_name}">${v.product_name}</option>`;
                    //                 `<option value="${v.product.id}_${v.product.uom}_${v.product.packing}_${v.product.tax}_${v.product_name}_${v.product_code}">${v.product_code} - ${v.product_name}</option>`;
                    //                 // `<option value="${v.id}_${v.uom}_${v.packing}_${v.tax}_${v.product_name}_${v.code}">${v.product_name}</option>`;
                    //                 // `<option value="${v.id}">${v.product_name}</option>`;

                    //         });
                    //         $('#product_id1').html(option);
                    //     }
                    // } else {
                    //     // alert("11")
                    //     if (response.products.length > 0) {
                    //         $('#unit1').val('');
                    //         $('#packing1').val('');
                    //         $('#s_tax1').val();
                    //         var option = `<option value="" selected>Select Product</option>`;
                    //         $.each(response.products, function(i, v) {
                    //             option +=
                    //                 // `<option value="${v.id}_${v.uom}_${v.packing}_${v.tax}_${v.product_name}">${v.product_name}</option>`;
                    //                 `<option value="${v.id}_${v.uom}_${v.packing}_${v.tax}_${v.product_name}_${v.code}">${v.code} - ${v.product_name}</option>`;
                    //                 // `<option value="${v.id}_${v.id}_${v.id}_${v.id}_${v.product_name}_${v.product_code}">${v.product_name}</option>`;
                    //                 // `<option value="${v.id}">${v.product_name}</option>`;

                    //         });
                    //         $('#product_id1').html(option);

                    //     }
                    // }
                }
            });
        });

		</script>
@stop