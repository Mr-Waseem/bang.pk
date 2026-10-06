<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bank Receipt Voucher</title>
    <link rel="stylesheet" href="{{ asset('bootstrap4/bootstrap.min.css') }}">
    <script src="{{ asset('bootstrap4/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap4/popper.min.js') }}"></script>
    <script src="{{ asset('bootstrap4/bootstrap.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        tr {
            line-height: 0px;
            border: 2px solid black;
        }

        .table thead th {
            border-bottom: 2px solid black;
        }

    </style>
</head>

<body>
    @if (isset($bank_receipt_detail))
        @if (count($bank_receipt_detail) > 0)
            @include('print-reports.partials.toolbar', ['printOnclick' => 'printInvoice()', 'printLabel' => 'Print <i class="fa fa-print"></i>'])
            @foreach ($bank_receipt_detail as $value)
                <div class="container">
                    <div class="row flex-lg-nowrap">
                        <div class="col">
                            <div class="row">
                                <div class="col mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="e-profile">
                                                @include('include.header-new')
                                                <h2 class="text-center"><u>Bank Receipt Voucher</u></h2>
                                                <p class="text-right"><i><b>V.Date:</b>
                                                        {{ date('d/m/Y', Strtotime($value->voucher_date)) }}</i></p>
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <h3>ACCOUNT NAME: {{ $value->parties->party_name }}</h3>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <h5 class="text-right">VOUCHER#: {{ $value->voucher_no }}
                                                        </h5>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <h5 class="text-left">Address:
                                                            {{ $value->parties->address }}</h5>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <h5 class="text-right">NTN: {{ $value->parties->ntn }}
                                                        </h5>
                                                    </div>
                                                </div>
                                                <br>
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>Sr.#</th>
                                                        <th>Account Name</th>
                                                        <th>Cheque#</th>
                                                        {{-- <th>Bank Name</th> --}}
                                                        <th>Description</th>
                                                        <th>Amount</th>
                                                    </tr>
                                                    <?php
                                                    $sum = 1;
                                                    $quantity = 0;
                                                    $rate = 0;
                                                    $ValueExcTax = 0;
                                                    $STValue = 0;
                                                    $amount = 0; ?>
                                                    @foreach ($value->voucher_details as $details)
                                                        @if ($details->credit != null)
                                                            <tr>
                                                                <td>{{ $sum }}</td>
                                                                <td>{{ $details->parties->party_name }}</td>
                                                                <td>{{ $details->cheque_no }}</td>
                                                                {{-- <td>
                                                                @if ($details->banks)
                                                                    {{ $details->banks->name }}
                                                                @endif
                                                            </td> --}}
                                                                <td>{{ $details->narration }}</td>
                                                                <td>{{ $details->credit }}</td>
                                                            </tr>
                                                        @endif
                                                        <?php
                                                        
                                                        $quantity = $quantity + $details->quantity;
                                                        $rate = $rate + $details->price;
                                                        $ValueExcTax = $ValueExcTax + $details->quantity * $details->rate;
                                                        $STValue = $STValue + $details->taxvalue;
                                                        $amount = $amount + $details->credit;
                                                        if ($details->credit != null) {
                                                            $sum = $sum + 1;
                                                        }
                                                        ?>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="4"><b>Total</b></td>
                                                        <th>{{ $amount }}</th>
                                                    </tr>
                                                </table>
                                                <div class="row mt-5">
                                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                                        <span>&emsp;&emsp;&emsp;</span><br>
                                                        <hr
                                                            style="float:left;width:200px;background:black;margin-top:0px;">
                                                        <br>
                                                        <span style="position: relative;top:-10px;">PREPARED BY</span>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                                        <br>
                                                        <hr
                                                            style="float:left;width:200px;background:black;margin-top:0px;">
                                                        <br>
                                                        <span style="position: relative;top:-10px;">CHECKED BY</span>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                                        <br>
                                                        <hr
                                                            style="float:left;width:200px;background:black;margin-top:0px;">
                                                        <br>
                                                        <span style="position: relative;top:-10px;">APPROVED BY</span>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                                        <br>
                                                        <hr
                                                            style="float:left;width:200px;background:black;margin-top:0px;">
                                                        <br>
                                                        <span style="position: relative;top:-10px;">RECIEVED BY</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('include.powerdby3')
                <p style="page-break-after: always;"></p>
            @endforeach
        @else
            <h1>Record Not Found</h1>
        @endif
    @endif
</body>

</html>
