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
                <h1 class="page-title pull-left">Chart Of Account</h1><a href="{{ asset('parties/create') }}"
                    class="btn btn-primary btn-sm btn-add" role="button">Add Account</a>
                <button type="button" id="bulk-delete-btn" class="btn btn-danger btn-sm" style="margin-left: 10px;">Bulk Delete</button>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="page-heading clearfix">

            </div>
        </div>
        <div class="col-sm-4">
            <a href="{{ asset('parties/print') }}" target="_blank" style="float: right;" class="btn btn-default btn-md">
                <span class="glyphicon glyphicon-print"></span> Print
            </a>  

            <a href="{{ asset('parties/customers/print') }}" target="_blank" style="float: right;" class="btn btn-default btn-md">
                <span class="glyphicon glyphicon-print"></span> Customers
            </a>
            <a href="{{ asset('parties/suppliers/print') }}" target="_blank" style="float: right;" class="btn btn-default btn-md">
                <span class="glyphicon glyphicon-print"></span> Suppliers
            </a>
            {{-- <a href="{{ asset('parties/pdf') }}" class="btn btn-danger btn-md">
                <span class="glyphicon glyphicon-save-file"></span> PDF
            </a>
            <a href="{{ asset('parties/downloadExcel') }}" class="btn btn-success btn-md">
                <span class="glyphicon glyphicon-file"></span> Excel
            </a> --}}
        </div>
    </div>
<!-- <div class="page-heading clearfix">
    <h1 class="page-title pull-left">Parties</h1><a href="parties/create" class="btn btn-primary btn-sm btn-add"
        role="button">Add New</a>
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
                <h3 class="panel-title">Manage Parties</h3>
            
            </div>
            <div class="panel-body">
                <form id="bulk-delete-form" action="{{ asset('parties/bulk-destroy') }}" method="POST">
                    @csrf
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                            <tr>
                                <th class="no-export"><input type="checkbox" id="select-all"></th>
                                <th>Sr.#</th>
                                <th>Code</th>
                                <th>Party Name</th>
                                <!-- <th>Phone</th> -->
                                <th>NTN</th>
                                <!-- {{-- <th>STRN</th> --}} -->
                                <!-- <th>City</th> -->
                                <th>Address</th>
                                <th>Type</th>
                                <th class="no-export">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sum = 1; ?>
                            @foreach($party as $parties)

                            <tr>
                                <td><input type="checkbox" name="ids[]" value="{{ $parties->id }}" class="party-checkbox"></td>
                                <td><?php echo $sum; ?></td>
                                <td class="center">{{ $parties->code }}</td>
                                <td class="center">{{ $parties->party_name }}</td>
                                <!-- <td class="center">{{ $parties->phone }}</td> -->
                                <td class="center">{{ $parties->ntn }}</td>
                                {{-- <td class="center">{{ $parties->strn }}</td> --}}
                                <!-- <td class="center">{{ $parties->city }}</td> -->
                                <td class="center">{{ $parties->address }}</td>
                                {{-- <td class="center">
                                            @if ($parties->location != null)
                                                {{ $parties->location->name }}
                                @endif
                                </td> --}}
                                <td class="center">{{ $parties->name }}</td>

                                <td class="size-80 text-center">
                                    <div class="dropdown">
                                        <a class="more-link" data-toggle="dropdown" href="#/"><i
                                                class="icon-dot-3 ellipsis-icon"></i></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <!-- <li><a href="/ledger/{{ $parties->id }}" target="__blank">Ledger</a></li>
                           <li><a href="/ledger/print/{{ $parties->id }}" target="__blank">Print Ledger</a></li> -->
                                            <li><a href="{{ asset('parties/' . $parties->id . '/edit') }}">Edit</a>
                                            </li>
                                            <li><a href="{{ asset('parties/' . $parties->id . '/destroy') }}">Delete</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <?php $sum = $sum + 1; ?>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th>Sr.#</th>
                                <th>Code</th>
                                <th>Party Name</th>
                                <!-- <th>Phone</th> -->
                                <th>NTN</th>
                                <!-- {{-- <th>STRN</th> --}} -->
                                <!-- <th>City</th> -->
                                <th>Address</th>
                                <th>Type</th>
                                <th class="no-export">Actions</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                </form>
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
$(document).ready(function() {
    $('.dataTables-example').DataTable({
        dom: '<"html5buttons" B>lTfgitp',
        columnDefs: [
            { "orderable": false, "targets": 0 }
        ],
        buttons: [{
                extend: 'copyHtml5',
                exportOptions: {
                    columns: ':visible:not(.no-export)'
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible:not(.no-export)'
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5, 6]
                }
            },
            'colvis'
        ]
    });

    // Select All functionality
    $('#select-all').on('click', function() {
        $('.party-checkbox').prop('checked', this.checked);
    });

    // Bulk Delete button click
    $('#bulk-delete-btn').on('click', function() {
        if ($('.party-checkbox:checked').length > 0) {
            if (confirm('Are you sure you want to delete selected parties?')) {
                $('#bulk-delete-form').submit();
            }
        } else {
            alert('Please select at least one party to delete.');
        }
    });
});
</script>

@stop