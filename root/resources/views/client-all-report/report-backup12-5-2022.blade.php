<html>

<head>
    <link href="{{ asset('css/bg.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }
        
        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
</head>

<body>
    <button onclick="goBack()" class="btn" id="Backbutton" autofocus>Go Back</button>
    <button class="btn btn-primary" id="Printbutton" onclick="hideBtn()">Print <i class="fa fa-print"></i></button>
    <div>
        <section class="content">
            <center>
                <h3><u><b id="systemTitle">{{ session()->get('company_name') }}</b></u></h3>
            </center>
            <center><b id="systemDetail">{{ session()->get('company_address') }}</b></center>
            <center><b id="systemDetail">PH :{{ session()->get('company_phone') }}</b>
                <center>
                    <center><b id="systemDetail">Email: {{ session()->get('company_email') }}</b>
                        <center>
                            </br>
                            <span style="float: right;margin-top: -19px " id="systemDetail">@php
                                $t = time();
                                $t . '<br>';
                                echo date('d/m/Y', $t);
                            @endphp
                            </span> @include("header.supplier-info")
                            <center id="systemDetail">FROM:{{ date('d/m/Y', Strtotime($fromDate)) }} TO:{{ date('d/m/Y', Strtotime($toDate)) }}</center>
                            <div style="border:2px solid;">
                                <div><b id="voucherName">SINGLE PARTY LEDGER (SUMMARY)</b></div>
                                <div class="panel-body" style="border-top:2px solid;">
                                    <table style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th style="width:10%; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">
                                                    Vr.No</th>
                                                <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid; text-align: left;">
                                                    Vr.Type</th>
                                                <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">
                                                    Date</th>
                                                <th style="width:30%; border-top: 2px solid;border-bottom: 2px solid;">
                                                    Narration</th>
                                                <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">
                                                    Debit</th>
                                                <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">
                                                    Credit</th>
                                                <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;">
                                                    Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $totalOpening = 0; ?>
                                            <tr id="datafont" style="color: red;">
                                                <td id="tabledata"></td>
                                                <td id="tabledata"></td>
                                                <td id="tabledata"></td>
                                                <td id="tabledata">OPENING CASH</td>

                                                <td id="tabledata">
                                                    {{ number_format((int) $openingBalance[0]->OpeningOUT) }}</td>
                                                <td id="tabledata">
                                                    {{ number_format((int) $openingBalance[0]->OpeningIN) }}</td>

                                                <?php $totalOpening = $openingBalance[0]->OpeningOUT - $openingBalance[0]->OpeningIN; ?>
                                                <td id="tabledata">{{ number_format((int) $totalOpening) }}</td>
                                            </tr>
                                            <?php $totalDebit = 0;
                                            $totalCredit = 0;
                                            $sum = 0;
                                            $totalIn = 0;
                                            $totalOut = 0; ?> @if (count($GeneralVoucher) > 0) @foreach ($GeneralVoucher as $GeneralVouchers)
                                            <tr id="datafont">
                                                <td id="tabledata">{{ $GeneralVouchers->voucher_no }}</td>
                                                <td id="tabledata" style="text-align: left;">
                                                    @if ($GeneralVouchers->v_type == 'Cash Purchase') {{ 'Cash|Purchase' }} @endif @if ($GeneralVouchers->v_type == 'Credit Purchase') {{ 'Cr|Purchase' }} @endif @if ($GeneralVouchers->v_type == 'Sale Bill') {{ 'SB' }} @endif @if ($GeneralVouchers->v_type
                                                    == 'PurchaseTax Invoice') {{ 'PTV' }} @endif @if ($GeneralVouchers->v_type == 'SalesTax Invoice') {{ 'STV' }} @endif @if ($GeneralVouchers->v_type == 'Journal Voucher') {{ 'JV' }} @endif @if ($GeneralVouchers->v_type
                                                    == 'Cash Receipt') {{ 'CR' }} @endif @if ($GeneralVouchers->v_type == 'Cash Payment') {{ 'Cash Payment' }} @endif @if ($GeneralVouchers->v_type == 'Bank Receipt') {{ 'Bank Receipt' }} @endif @if ($GeneralVouchers->v_type
                                                    == 'Bank Payment') {{ 'Bank Payment' }} @endif @if ($GeneralVouchers->v_type == 'Post Dated Cheque') {{ 'PostDated Cheque' }} @endif @if ($GeneralVouchers->v_type == 'Purchase Return') {{ 'Purchase Return'
                                                    }} @endif @if ($GeneralVouchers->v_type == 'Credit Sale') {{ 'Sale | CR' }} @endif @if ($GeneralVouchers->v_type == 'Cash Sale') {{ 'Sale | CASH' }} @endif @if ($GeneralVouchers->v_type == 'Sale Return')
                                                    {{ 'Sale Return' }} @endif @if ($GeneralVouchers->v_type == 'Payment on Credit Bill') {{ 'Payment on Credit Bill' }} @endif @if ($GeneralVouchers->v_type == 'Salary') {{ 'Salary' }} @endif @if ($GeneralVouchers->v_type
                                                    == '13TS') {{ 'Purchase Milk| 13TS' }} @endif @if ($GeneralVouchers->v_type == 'FAT5') {{ 'Purchase Milk| FAT5' }} @endif
                                                </td>

                                                <td id="tabledata">
                                                    {{ date('d/m/Y', strtotime($GeneralVouchers->date)) }}
                                                </td>
                                                <!-- <td id="tabledata">
															{{ $GeneralVouchers->cheque_no }}
															</td>
															<td id="tabledata">@if ($GeneralVouchers->banks != null)
														{{ $GeneralVouchers->banks->name }}
														@endif</td> -->

                                                <td id="tabledata">
                                                    @if ($GeneralVouchers->narration == null) INV#:{{ $GeneralVouchers->invoice_no }}|Dated:{{ date('d/m/Y', strtotime($GeneralVouchers->date)) }} @endif {{ $GeneralVouchers->narration }}
                                                </td>
                                                <td id="tabledata">
                                                    {{ number_format((int) $GeneralVouchers->debit) }}</td>
                                                <td id="tabledata">
                                                    {{ number_format((int) $GeneralVouchers->credit) }}</td>
                                                <?php
                                                        $totalDebit = $totalDebit + (int) $GeneralVouchers->debit;
                                                        
                                                        $totalCredit = $totalCredit + (int) $GeneralVouchers->credit;
                                                        
                                                        ?>
                                                    <td id="tabledata">
                                                        {{ number_format((int) $totalDebit - $totalCredit) }}</td>
                                            </tr>
                                            @endforeach
                                            <tr id="datafont">
                                                <td colspan="4" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">
                                                    <center><b>Total Without Opening Balance</b></center>
                                                </td>
                                                <td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;">
                                                    <b>{{ number_format((int) $totalDebit) }}</b></td>
                                                <td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;">
                                                    <b>{{ number_format((int) $totalCredit) }}</b></td>

                                                <td style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;">
                                                    <b>{{ number_format((int) $totalDebit - $totalCredit) }}</b></td>
                                            </tr>
                                            <tr id="datafont">
                                                <td colspan="4" style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">
                                                    <center><b>Total</b></center>
                                                </td>
                                                <td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;">
                                                    <b>{{ number_format((int) $openingBalance[0]->OpeningOUT + $totalDebit) }}</b>
                                                </td>
                                                <td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;">
                                                    <b>{{ number_format((int) $openingBalance[0]->OpeningIN + $totalCredit) }}</b>
                                                </td>
                                                <td style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;">
                                                    <b>{{ number_format((int) $openingBalance[0]->OpeningOUT - $openingBalance[0]->OpeningIN + $totalDebit - $totalCredit) }}</b>
                                                </td>
                                            </tr>

                                            @else
                                            <tr>
                                                <td colspan="7" style="color:#FF0000;text-align:center;">No Records found
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
        </section>
    </div>
    @include('include.powerdby2')


</body>

</html>
<script>
    function goBack() {
        window.history.back()
    }

    function hideBtn() {
        document.getElementById('Backbutton').style.display = 'none';
        document.getElementById('Printbutton').style.display = 'none';
        window.print();
    }
</script>