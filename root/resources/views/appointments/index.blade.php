@extends("app")
@section('head')
    <link href="/css/plugins/datatables/jquery.dataTables.css" rel="stylesheet">
    <link href="/js/plugins/datatables/extensions/Buttons/css/buttons.dataTables.css" rel="stylesheet">
    <style>
        .html5buttons {
            display: none;
        }

    </style>
@stop
@section('contents')
    <div class="container-fluid">
        @if (Session::has('flash_message'))
            <div class="alert alert-success alert-dismissible fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close"
                    style="margin-right: 4%;">&times;</a>
                <strong>Success!</strong> {{ Session::get('flash_message') }}
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-sm-5">
            <div class="page-heading clearfix">
                <h1 class="page-title pull-left" style="color: white">Appointment Information</h1><a href="appointments/create"
                    class="btn btn-primary btn-sm btn-add" role="button">Add New Appointment</a>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="page-heading clearfix">

            </div>
        </div>
        <!-- <div class="col-sm-4">
      <a href="products/print" target="__blank" class="btn btn-default btn-md">
      <span class="glyphicon glyphicon-print"></span> Print 
      </a>
      <a href="products/pdf" class="btn btn-danger btn-md">
      <span class="glyphicon glyphicon-save-file"></span> PDF 
      </a>
      <a href="products/downloadExcel" class="btn btn-success btn-md">
      <span class="glyphicon glyphicon-file"></span> Excel 
      </a>
     </div> -->
    </div>
    <!-- <ol class="breadcrumb breadcrumb-2"> 
     <li><a href="
     /dashboard"><i class="fa fa-home"></i>Home</a></li> 
     <li><a href="/products">Products</a></li> 
     <li class="parties"><strong>Product</strong></li> 
    </ol> -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix" id="panelbg">
                    <h3 class="panel-title">Manage Appointments</h3>
                    <!-- <ul class="panel-tool-options"> 
         <li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
         <li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>
         <li><a data-rel="close" href="#"><i class="icon-cancel"></i></a></li>
        </ul> -->
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" id="example3">
                            <thead>
                                <tr>
                                    <th>Serial#</th>
                                    <th>App.No</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Salary</th>
                                    <th>Created.By</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sum = 1; ?>
                                @foreach ($data as $appointment)

                                    <tr id="example3">
                                        <td><?php echo $sum; ?></td>
                                        <td class="center">
                                            <span>{{ $appointment->voucher_no }}</span>
                                        </td>
                                        <td class="center">
                                            <span>{{ date('d/m/Y', Strtotime($appointment->date)) }}</span>
                                        </td>
                                        <td class="center">
                                            @if ($appointment->employee)
                                                <span>{{ $appointment->employee->party_name }}</span>
                                            @endif
                                        </td>
                                        <td class="center">
                                            <span>{{ $appointment->type }}</span>
                                        </td>
                                        <td class="center">
                                            @if ($appointment->employee)
                                                <span>{{ $appointment->employee->salary }}</span>
                                            @endif
                                        </td>
                                        <td class="center">
                                            <span>{{ $appointment->created_by }}</span>
                                        </td>
                                        <td class="center">
                                            <a href="{{ asset('appointments') }}/{{ $appointment->id }}"><button
                                                    class="btn btn-info">LETTER</button></a>
                                            <a href="{{ asset('appointments') }}/{{ $appointment->id }}/edit"><button
                                                    class="btn btn-primary">EDIT</button></a>
                                            <a href="{{ asset('appointments') }}/{{ $appointment->id }}/destroy"><button
                                                    class="btn btn-danger">DELETE</button></a>
                                        </td>
                                    </tr>
                                    <?php $sum = $sum + 1; ?>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Serial#</th>
                                    <th>App.No</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Salary</th>
                                    <th>Created.By</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="/js/jquery.min.js"></script>
    <!--<script src="/js/bootstrap.min.js"></script>
    <script src="/js/plugins/metismenu/jquery.metisMenu.js"></script>
    <script src="/js/plugins/blockui-master/jquery-ui.js"></script>
    <script src="/js/plugins/blockui-master/jquery.blockUI.js"></script>
    <script src="/js/functions.js"></script>
    --->
    <script src="/js/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/js/plugins/datatables/dataTables.bootstrap.min.js"></script>
    <script src="/js/plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
    <script src="/js/plugins/datatables/jszip.min.js"></script>
    <script src="/js/plugins/datatables/pdfmake.min.js"></script>
    <script src="/js/plugins/datatables/vfs_fonts.js"></script>
    <script src="/js/plugins/datatables/extensions/Buttons/js/buttons.html5.js"></script>
    <script src="/js/plugins/datatables/extensions/Buttons/js/buttons.colVis.js"></script>
    <script>
        $(document).ready(function() {
            $('.dataTables-example').DataTable({
                dom: '<"html5buttons" B>lTfgitp',
                buttons: [{
                        extend: 'copyHtml5',
                        exportOptions: {
                            columns: [0, ':visible']
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
                            columns: [0, 1, 2, 3, 4]
                        }
                    },
                    'colvis'
                ]
            });
        });
    </script>
    <script>
        function ProductName(name, ID) {
            jQuery.ajax({
                type: "GET",
                data: {
                    name: JSON.stringify(name)
                },
                url: "products/update-name/update?product_name=" + ID,
                success: function(result) {
                    if (parseInt(result) > 0) {
                        alert("done")
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    $("#spanWait").hide();
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }

        function ProductWeight(weight, ID) {
            //alert(cost)
            jQuery.ajax({
                type: "GET",
                data: {
                    weight: JSON.stringify(weight)
                },
                url: "products/update-weight/update?product_id=" + ID,
                success: function(result) {
                    if (parseInt(result) > 0) {
                        alert("done")
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    $("#spanWait").hide();
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }

        function ProductCost(cost, ID) {
            //alert(cost)
            jQuery.ajax({
                type: "GET",
                data: {
                    cost: JSON.stringify(cost)
                },
                url: "products/update-cost/update?product_id=" + ID,
                success: function(result) {
                    if (parseInt(result) > 0) {
                        alert("done")
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    $("#spanWait").hide();
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }


        function ProductPrice(price, ID) {
            jQuery.ajax({
                type: "GET",
                data: {
                    price: JSON.stringify(price)
                },
                url: "products/update-price/update?product_id=" + ID,
                success: function(result) {
                    if (parseInt(result) > 0) {
                        alert("done")
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    $("#spanWait").hide();
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }

        function ProductAlert(alertvalue, ID) {
            jQuery.ajax({
                type: "GET",
                data: {
                    alertvalue: JSON.stringify(alertvalue)
                },
                url: "products/update-alert/update?product_id=" + ID,
                success: function(result) {
                    if (parseInt(result) > 0) {
                        alert("done")
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    $("#spanWait").hide();
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }
    </script>

@stop
