@extends("app")
@section('head')
    @php
    use App\Models\SystemLogo;
    $system = SystemLogo::first();
    $image = $system->image;
    @endphp
    <!-- Site favicon -->
    <link rel='/shortcut icon' type='image/x-icon' href='{{ asset('images/favicon.ico') }}' />
    <!-- /site favicon -->

    <!-- Entypo font stylesheet -->
    <link href="{{ asset('css/entypo.css') }}" rel="stylesheet">
    <!-- /entypo font stylesheet -->

    <!-- Font awesome stylesheet -->
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- /font awesome stylesheet -->

    <!-- Bootstrap stylesheet min version -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- /bootstrap stylesheet min version -->

    <!-- Mouldifi core stylesheet -->
    <link href="{{ asset('css/mouldifi-core.css') }}" rel="stylesheet">
    <!-- /mouldifi core stylesheet -->

    <link href="{{ asset('css/plugins/select2/select2.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mouldifi-forms.css') }}" rel="stylesheet">
@stop
@section('contents')
    <div class="row">
        <div class="col-md-12">
            <a href="{{ asset('parties/print') }}/{{ $party[0]->id }}" class="btn btn-warning" role="button"
                style="float:right;"><i class="fa fa-print"></i><span class="bold">Print</span></a>
            <!-- Card grid view -->
            <div class="cards-container box-view grid-view">
                <div class="row">
                    <div class="col-lg-12 col-sm-6 ">

                        <!-- Card -->
                        <div class="card">

                            <!-- Card header -->
                            <div class="card-header">
                                <div class="card-short-description">
                                    <center>
                                        <span class="user-name">
                                            <img src="{{ asset('upload/logo/' . $image) }}"
                                                style="height:100px; weight: 200px;">
                                        </span>
                                    </center>
                                </div>
                            </div>
                            <!-- /card header -->

                            <!-- Card content -->
                            <div class="card-content">
                                <h3><strong>{{ $company_detail[0]->system_name }}</strong></br></h3>
                                <h5><strong>Address : </strong>{{ $company_detail[0]->address }}</br></h4>
                                    <h5><strong>Email : </strong>{{ $company_detail[0]->email }}</h5>
                                    <h5><strong>Phone : </strong>{{ $company_detail[0]->phone }}</h5>

                            </div>

                            <div class="card-content" style="float: right; margin-top: -135px; margin-right: 100px;">
                                <h3><strong>Ledger</strong></h3>
                                <h5><strong>Customer : </strong>{{ $party[0]->party_name }}</br></h5>
                                <h5><strong>Tel : </strong>{{ $party[0]->phone }}</br></h5>
                                <h5><strong>City : </strong>{{ $party[0]->city }}</br></h5>
                            </div>
                            <!-- /card content -->
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Description</th>
                                                <th>Quantity</th>
                                                <th>Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $sum = 1;
                                            $nettotal = 0;
                                            $totaldiscount = 0;
                                            $totaltax = 0;
                                            $total = 0; ?>
                                            @foreach ($party[0]->party as $parties)
                                                <tr class="gradeX">
                                                    <td><?php echo $sum; ?></td>
                                                    <td></td>
                                                    <td>{{ $parties->quantity }}</td>

                                                    <td>{{ $parties->total_cost }}</td>
                                                </tr>
                                                <?php
                                                $nettotal = $nettotal + $parties->total_cost;
                                                
                                                ?>
                                                <?php $sum = $sum + 1; ?>

                                            @endforeach
                                            <tr class="gradeX">
                                                <center>
                                                    <td colspan="3" style="padding-left: 780px;">Total</td>
                                                </center>
                                                <td><?php echo $nettotal; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- /card -->
                    </div>
                </div>
            </div>
            <!-- /card grid view -->
        </div>
    </div>


@stop
