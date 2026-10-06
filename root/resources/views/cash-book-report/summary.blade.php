<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CASH BOOK</title>
    <link rel="stylesheet" href="{{ asset('bootstrap4/bootstrap.min.css') }}">
    <style>
    tr {
        /* line-height: 0px; */
        border: 1px solid black;
    }

    .table thead th,
    .table tbody tr td {
        border: 1px solid black;
        padding: 0px !important;
        padding-left: 5px !important;
    }
    </style>
</head>
</br>
<body>
    <div class="container">
        <div class="row flex-lg-nowrap">
            <div class="col">
                <div class="row">
                    <div class="col mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="e-profile">
                                    @include('include.header')
                                    <h2 class="text-center"><u>CASH BOOK</u></h2>
                                    <p class="text-center font-italic"><b>From:</b> {{
										date('d/m/Y',strtotime($fromDate)) }} && <b>To:</b> {{
										date('d/m/Y',strtotime($toDate)) }}</p>
                                    <div class="row">
                                        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                                            <h5>ACCOUNT NAME: {{$CashAccount->party_name}}</h5>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                            <h5>ACCOUNT CODE: {{$CashAccount->code}}</h5>
                                        </div>
                                        <!-- <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                            <h5 class="text-left">Type: </h5>
                                        </div> -->
                                    </div>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>SR.NO</th>
                                                    <th>PARTY&nbsp;NAME</th>
                                                    <th>Debit</th>
                                                    <th>Credit</th>
                                                    <th>Balance</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <!-- <td></td> -->
                                                    <td colspan="2" style="text-align:center;">OPENING CASH</td>
                                                    <td>{{ number_format((int) $openingCash[0]->OpeningDebit) }}</td>
                                                    <td>{{ number_format((int) $openingCash[0]->OpeningCredit) }}</td>
                                                    @php
                                                    $TotalOpening = 0;
                                                    $TotalOpening = $openingCash[0]->OpeningDebit -
                                                    $openingCash[0]->OpeningCredit;
                                                    @endphp
                                                    <td>{{ number_format($TotalOpening) }}</td>
                                                </tr>
                                                <?php $sum = 0; $totalIn = 0; $totalOut = 0; ?>
                                                @if (isset($Payment))
                                                @if (count($Payment) > 0)
                                                @foreach ($Payment as $Payments)
                                                @php $sum= $sum + 1; @endphp
                                                <t>
                                                    <td>{{ $sum }}</td>
                                                    <td id="tabledata">{{ $Payments->party_name }}</td>

                                                    <td>{{ $Payments->debit }}</td>
                                                    <td>{{ $Payments->credit }}</td>
                                                    <?php $totalIn = $totalIn + (int) $Payments->debit; ?>
                                                    <?php $totalOut = $totalOut + (int) $Payments->credit; ?>
                                                    <td>
                                                        {{ number_format((int) $totalIn - $totalOut + $TotalOpening) }}
                                                    </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="2">
                                                            <center><b>Total Without Opening Balance</b></center>
                                                        </td>
                                                        <td>
                                                            <b>{{ number_format((int) $totalIn) }}</b>
                                                        </td>
                                                        <td>
                                                            <b>{{ number_format((int) $totalOut) }}</b>
                                                        </td>
                                                        <td>
                                                            <b>{{ number_format((int) $totalIn - $totalOut + $TotalOpening) }}</b>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="2">
                                                            <center><b>TOTAL</b></center>
                                                        </td>
                                                        <td>
                                                            <b>{{ number_format((int) $openingCash[0]->OpeningDebit + $totalIn) }}</b>
                                                        </td>
                                                        <td>
                                                            <b>{{ number_format((int) $openingCash[0]->OpeningCredit + $totalOut) }}</b>
                                                        </td>
                                                        <td>
                                                            <b>{{ number_format($totalIn - $totalOut + $TotalOpening) }}</b>
                                                        </td>
                                                    </tr>
                                                    @else
                                                    <tr>
                                                        <td colspan="5" style="color:#FF0000;text-align:center;">No
                                                            Records found</td>
                                                    </tr>
                                                    @endif

                                                    @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('include.powerdby')
</body>
</html>