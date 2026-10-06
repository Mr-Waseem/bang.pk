<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PURCHASE REPORT</title>
    <link rel="stylesheet" href="{{ asset('bootstrap4/bootstrap.min.css') }}">
    <script src="{{ asset('bootstrap4/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap4/popper.min.js') }}"></script>
    <script src="{{ asset('bootstrap4/bootstrap.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        tr {
            line-height: 0px;
            border: 1px solid black;
        }

        .table thead tr th,
        .table tbody tr td,
        .table tfoot tr td {
            border: 1px solid black;
        }

    </style>
</head>

<body>
    @if (isset($general_voucher))
        @if (count($general_voucher) > 0)
            @include('print-reports.partials.toolbar', ['printOnclick' => 'printInvoice()', 'printLabel' => 'Print <i class="fa fa-print"></i>'])
            @foreach ($general_voucher as $value)
                <div class="container">
                    <div class="row flex-lg-nowrap">
                        <div class="col">
                            <div class="row">
                                <div class="col mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="e-profile">
                                                @include('include.header-new')
                                                <h2 class="text-center"><u>GENERAL VOUCHER</u></h2>
                                                <br>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr.#</th>
                                                            <th>Account Name</th>
                                                            <th>Description</th>
                                                            <th>Debit</th>
                                                            <th>Credit</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $sum = 1;
                                                        $quantity = 0;
                                                        $rate = 0;
                                                        $ValueExcTax = 0;
                                                        $STValue = 0;
                                                        $debit = 0;
                                                        $credit = 0; ?>
                                                        @foreach ($value->voucher_details as $details)
                                                            @if ($details->credit != null)
                                                                <tr>
                                                                    <td>{{ $sum }}</td>
                                                                    <td>{{ $details->parties->party_name }}</td>
                                                                    <td>{{ $details->narration }}</td>
                                                                    <td>{{ $details->debit }}</td>
                                                                    <td>{{ $details->credit }}</td>
                                                                </tr>
                                                            @endif
                                                            <?php
                                                            
                                                            $quantity = $quantity + $details->quantity;
                                                            $rate = $rate + $details->price;
                                                            $ValueExcTax = $ValueExcTax + $details->quantity * $details->rate;
                                                            $STValue = $STValue + $details->taxvalue;
                                                            $debit = $debit + $details->debit;
                                                            $credit = $credit + $details->credit;
                                                            if ($details->credit != null) {
                                                                $sum = $sum + 1;
                                                            }
                                                            ?>
                                                        @endforeach

                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="3" align="center"><b>Total</b></th>
                                                            <td>{{ $debit }}</td>
                                                            <td>{{ $credit }}</td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
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
