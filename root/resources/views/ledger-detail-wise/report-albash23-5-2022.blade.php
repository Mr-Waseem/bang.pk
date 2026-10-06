<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SINGLE PARTY LEDGER (DETAIL WISE)</title>
    <link rel="stylesheet" href="{{ asset('bootstrap4/bootstrap.min.css') }}">
    <script src="{{ asset('bootstrap4/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap4/popper.min.js') }}"></script>
    <script src="{{ asset('bootstrap4/bootstrap.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        tr {
            /* line-height: 0px; */
            border: 2px solid black;
        }

        .table thead th {
            border-bottom: 2px solid black;
        }

    </style>
</head>

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
                                    <h2 class="text-center"><u>SINGLE PARTY LEDGER (DETAIL WISE)</u></h2>
                                    <p class="text-center">
                                        <i><b>From:</b> {{ date('d/m/Y', Strtotime($fromDate)) }}</i> &&
                                        <i><b>To:</b> {{ date('d/m/Y', Strtotime($toDate)) }}</i>
                                    </p>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <h5>PARTY CODE: {{ $party[0]->code }}</h5>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <h5 class="text-right">PARTY NAME: {{ $party[0]->party_name }}</h5>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <h5 class="text-left">Type: {{ $party[0]->account_type }}</h5>
                                        </div>
                                    </div>
                                    <br>
                                    <table class="table table-bordered">
                                        <thead>
                                            <thead>
                                                <tr>
                                                    <th>Vr.No</th>
                                                    <th>Vr.Type</th>
                                                    <th>Date</th>
                                                    <th>Narration</th>
                                                    <th>Comments</th>
                                                    <th>Qty</th>
                                                    <th>Rate</th>
                                                    <th>Debit</th>
                                                    <th>Credit</th>
                                                    <th>Balance</th>
                                                </tr>
                                            </thead>
                                        </thead>
                                        <tbody>
                                            <?php $totalOpening = 0; ?>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>OPENING CASH</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>{{ number_format((int) $openingBalance[0]->OpeningOUT) }}</td>
                                                <td>{{ number_format((int) $openingBalance[0]->OpeningIN) }}</td>

                                                @php
                                                    $totalOpening = $openingBalance[0]->OpeningOUT - $openingBalance[0]->OpeningIN;
                                                @endphp
                                                <td>{{ number_format((int) $totalOpening) }}</td>
                                            </tr>
                                            @php
                                                $totalDebit = 0;
                                                $totalCredit = 0;
                                                $sum = 0;
                                                $totalIn = 0;
                                                $totalOut = 0;
                                                $TotalQTY = 0;
                                                $TotalRate = 0;
                                            @endphp
                                            @if (count($items) > 0)
                                                @foreach ($items as $item)
                                                    <?php $sum = $sum + 1; ?>
                                                    <tr>
                                                        <td>{{ $item->voucher_no }}</td>
                                                        <td>
                                                            @if ($item->v_type == 'Cash Purchase')
                                                                {{ 'Cash|Purchase' }}
                                                            @endif
                                                            @if ($item->voucher_type == 'Credit Purchase')
                                                                {{ 'Cr|Purchase' }}
                                                            @endif
                                                            @if ($item->voucher_type == 'Sale Bill')
                                                                {{ 'SB' }}
                                                            @endif
                                                            @if ($item->voucher_type == 'PurchaseTax Invoice')
                                                                {{ 'PTV' }}
                                                            @endif
                                                            @if ($item->voucher_type == 'SalesTax Invoice')
                                                                {{ 'STV' }}
                                                            @endif
                                                            @if ($item->voucher_type == 'Journal Voucher')
                                                                {{ 'JV' }}
                                                            @endif
                                                            @if ($item->voucher_type == 'Cash Receipt')
                                                                {{ 'CR' }}
                                                            @endif
                                                            @if ($item->voucher_type == 'Cash Payment')
                                                                {{ 'Cash Payment' }}
                                                            @endif
                                                            @if ($item->voucher_type == 'Bank Receipt')
                                                                {{ 'Bank Receipt' }}
                                                            @endif
                                                            @if ($item->voucher_type == 'Bank Payment')
                                                                {{ 'Bank Payment' }}
                                                            @endif
                                                            @if ($item->voucher_type == 'Post Dated Cheque')
                                                                {{ 'PostDated Cheque' }}
                                                            @endif
                                                            @if ($item->voucher_type == 'Purchase Return')
                                                                {{ 'Purchase Return' }}
                                                            @endif
                                                            @if ($item->voucher_type == 'Credit Sale')
                                                                {{ 'Sale | CR' }}
                                                            @endif
                                                            @if ($item->voucher_type == 'Cash Sale')
                                                                {{ 'Sale | CASH' }}
                                                            @endif
                                                            @if ($item->voucher_type == 'Sale Return')
                                                                {{ 'Sale Return' }}
                                                            @endif
                                                            @if ($item->voucher_type == 'Payment on Credit Bill')
                                                                {{ 'Payment on Credit Bill' }}
                                                            @endif
                                                            @if ($item->voucher_type == 'Salary')
                                                                {{ 'Salary' }}
                                                            @endif
                                                            @if ($item->voucher_type == '13TS')
                                                                {{ 'Purchase Milk | 13TS' }}
                                                            @endif
                                                            @if ($item->voucher_type == 'FAT5')
                                                                {{ 'Purchase Milk | FAT5' }}
                                                            @endif
                                                        </td>
                                                        <td>{{ date('d/m/Y', strtotime($item->date)) }}</td>
                                                        <td>
                                                            @if ($item->products != null)
                                                                {{ $item->products->product_name }}
                                                            @endif
                                                        </td>
                                                        <td>{{ $item->other }}</td>
                                                        <td>{{ number_format((float) $item->quantity) }}</td>
                                                        <td>{{ number_format((float) $item->rate) }}</td>
                                                        <td>{{ number_format((float) $item->debit) }}</td>
                                                        <td>{{ number_format((float) $item->credit) }}</td>
                                                        @php
                                                            $totalDebit = $totalDebit + (float) $item->debit;
                                                            $totalCredit = $totalCredit + (float) $item->credit;
                                                            $TotalQTY = $TotalQTY + (float) $item->quantity;
                                                            $TotalRate = $TotalRate + (float) $item->rate;
                                                            // if ($item->voucher_type != "Cash Sale"){
                                                            // $totalCredit = $totalCredit + $item->credit;
                                                            // }
                                                        @endphp
                                                        <td>{{ number_format($totalDebit - $totalCredit) }}</td>
                                                    </tr>
                                                @endforeach

                                                <tr>
                                                    <td colspan="5">
                                                        <center><b>Total Without Opening Balance</b></center>
                                                    </td>
                                                    <td><b>{{ number_format((int) $TotalQTY) }}</b></td>
                                                    <td><b>{{ number_format((int) $TotalRate) }}</b></td>
                                                    <td><b>{{ number_format((int) $totalDebit) }}</b></td>
                                                    <td><b>{{ number_format((int) $totalCredit) }}</b></td>
                                                    <td><b>{{ number_format((int) $totalDebit - $totalCredit) }}</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7">
                                                        <center><b>Total</b></center>
                                                    </td>
                                                    <td>
                                                        <b>{{ number_format((int) $openingBalance[0]->OpeningOUT + $totalDebit) }}</b>
                                                    </td>
                                                    <td>
                                                        <b>{{ number_format((int) $openingBalance[0]->OpeningIN + $totalCredit) }}</b>
                                                    </td>
                                                    <td>
                                                        <b>{{ number_format((int) $openingBalance[0]->OpeningOUT - $openingBalance[0]->OpeningIN + $totalDebit - $totalCredit) }}</b>
                                                    </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td colspan="7" style="color:#FF0000;text-align:center;">No Records
                                                        found</td>
                                                </tr>
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
    @include('include.powerdby')
</body>

</html>
