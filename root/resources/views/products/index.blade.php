@extends("app")
@section("head")
<link href="{{asset('css/plugins/datatables/jquery.dataTables.css')}}" rel="stylesheet">
<link href="{{asset('js/plugins/datatables/extensions/Buttons/css/buttons.dataTables.css')}}" rel="stylesheet">
@stop
@section("contents")
<div class="container-fluid">
    @if (Session::has('flash_message'))
        <div class="alert alert-success alert-dismissible show" role="alert" style="position: relative;">
            {{ Session::get('flash_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%); padding: 0.5rem; line-height: 1; background: transparent; border: 0; font-size: 1.5rem;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (Session::has('flash_error'))
        <div class="alert alert-danger alert-dismissible show" role="alert" style="position: relative;">
            {{ Session::get('flash_error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%); padding: 0.5rem; line-height: 1; background: transparent; border: 0; font-size: 1.5rem;">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
</div>
            <div class="row">
        <div class="col-sm-5">
            <div class="page-heading clearfix">
                <h1 class="page-title pull-left">{{ !empty($isServiceTaxAuthority) ? $systemType . ' Service Information' : 'Product Information' }}</h1><a href="{{ asset('products/create') }}"
                    class="btn btn-primary btn-sm btn-add" role="button">Add New {{ !empty($isServiceTaxAuthority) ? 'Service' : 'Product' }}</a>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="page-heading clearfix">

            </div>
        </div>
        <div class="col-sm-4">
            <a href="{{ asset('products/print') }}" target="_blank" class="btn btn-default btn-md" style="float: right">
                <span class="glyphicon glyphicon-print"></span> Print
            </a>
            {{-- <a href="{{ asset('products/pdf') }}" class="btn btn-danger btn-md">
                <span class="glyphicon glyphicon-save-file"></span> PDF
            </a>
            <a href="{{ asset('products/downloadExcel') }}" class="btn btn-success btn-md">
                <span class="glyphicon glyphicon-file"></span> Excel
            </a> --}}
        </div>
    </div>
			<!-- <div class="page-heading clearfix">
				<h1 class="page-title pull-left">Products</h1><a href="taxes/create" class="btn btn-primary btn-sm btn-add" role="button">Add New</a>
			</div> -->
			<!--
			<div class="btn-group" style="float: right; margin-top: -32px;">
				<a href="parties/create" class="btn btn-primary btn-sm btn-add" role="button">Excel</a>
				<a href="parties/create" class="btn btn-primary btn-sm btn-add" role="button">PDF</a>
				<a href="parties/create" class="btn btn-primary btn-sm btn-add" role="button">Print</a>
		  </div>
		  --->
			<!-- Breadcrumb -->
	
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading clearfix" id="panelbg">
							<h3 class="panel-title">Manage {{ !empty($isServiceTaxAuthority) ? 'Services' : 'Products' }}</h3>
							<!-- <ul class="panel-tool-options"> 
								<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
								<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
								<li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
							</ul> -->
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover dataTables-example" >
									<thead>
                                    <tr>
                                    <th>Serial#</th>
                                    <th>{{ !empty($isServiceTaxAuthority) ? 'Service Code' : 'Code' }}</th>
                                    <th>{{ !empty($isServiceTaxAuthority) ? 'Service Name' : 'Product Name' }}</th>
                                    <!-- <th>CATEGORY</th> -->
                                    <th>{{ !empty($isServiceTaxAuthority) ? 'Service UOM' : 'UOM' }}</th>
                                    <th>Tax%</th>
                                    <th>Actions</th>
                                </tr>
									</thead>
									 <tbody>
						  <?php $sum = 1; ?>
						  @foreach($products as $product)

                          <tr id="example3">
                                        <td><?php echo $sum; ?></td>
                                            <td class="center">
                                            {{ $product->product_code }}</td>
                                            <td class="center">
                                            {{ $product->product_name }}</td>
                                        <!-- <td class="center">
                                            @if ($product->catagories != null)
                                                {{ $product->catagories->catagory_name }}
                                            @else
                                                <span style="color:red;">{{ 'NO CATAGORY' }}</span>
                                            @endif
                                        </td> -->
                                        <td class="center">{{ $product->uom }}</td>
                                            <td class="center">
                                                @if($product->tax == "999")
                                                {{ "Exempt" }}
                                                @elseif($product->tax == 0)
                                                {{ "Zero Rated" }}
                                                @else
                                                {{ $product->tax }} %
                                                @endif
                                                </td>
                                       
                                        <td class="size-80 text-center">
                                            <div class="dropdown">
                                                <a class="more-link" data-toggle="dropdown" href="#/"><i
                                                        class="icon-dot-3 ellipsis-icon"></i></a>
                                                <ul class="dropdown-menu dropdown-menu-right">
                                                    <li><a
                                                            href="{{ asset('products') }}/{{ $product->id }}/edit">Edit</a>
                                                    </li>
                                                    <li><a href="{{ asset('products/' . $product->id . '/destroy') }}">Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
							<?php $sum = $sum + 1;?>
						  @endforeach
						  </tbody>
									<tfoot>
                                    <tr>
                                    <th>Serial#</th>
                                    <th>{{ !empty($isServiceTaxAuthority) ? 'Service Code' : 'Code' }}</th>
                                    <th>{{ !empty($isServiceTaxAuthority) ? 'Service Name' : 'Product Name' }}</th>
                                    <!-- <th>CATEGORY</th> -->
                                    <th>{{ !empty($isServiceTaxAuthority) ? 'Service UOM' : 'UOM' }}</th>
                                    <th>Tax%</th>
                                    <th>Actions</th>
                                </tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
@stop

@section("scripts")
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('js/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
<!-- <script src="{{asset('js/plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js')}}"></script> -->
<!-- <script src="{{asset('js/plugins/datatables/jszip.min.js')}}"></script>
<script src="{{asset('js/plugins/datatables/pdfmake.min.js')}}"></script>
<script src="{{asset('js/plugins/datatables/vfs_fonts.js')}}"></script> -->
<!-- <script src="{{asset('js/plugins/datatables/extensions/Buttons/js/buttons.html5.js')}}"></script> -->
<!-- <script src="{{asset('js/plugins/datatables/extensions/Buttons/js/buttons.colVis.js')}}"></script> -->
<script>
	$(document).ready(function () {
		$('.dataTables-example').DataTable({
			dom: '<"html5buttons" B>lTfgitp',
			buttons: [
				{
					extend: 'copyHtml5',
					exportOptions: {
						columns: [ 0, ':visible' ]
					}
				},
				{
					extend: 'excelHtml5',
					exportOptions: {
						columns: ':visible'
					}
				},
				{
					extend: 'pdfHtml5',
					exportOptions: {
						columns: [ 0, 1, 2, 3, 4 ]
					}
				},
				'colvis'
			]
		});
	});
</script>

@stop
