<html>

<head>
    <link href="{{ asset('css/bg.css') }}" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
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
    <div class="content-wrapper">
        <section class="content">
            @include('header.report')
            <!-- <center><span id="systemDetail">FROM {{ date('d/m/Y', Strtotime($fromDate)) }} TO {{ date('d/m/Y', Strtotime($toDate)) }}</span> </center> -->
            <div id="systemDetail"><b>FROM {{ date('d/m/Y', Strtotime($fromDate)) }} TO
                    {{ date('d/m/Y', Strtotime($toDate)) }}</b></div>
            <div style="border:2px solid;">
                <div id="voucherName"><b>ALL ACCOUNTS REPORT</b></div>
                <div class="panel-body" style="border-top:2px solid;">
                    <table>
                        <thead>
                            <tr>
                                <th
                                    style="width:1%;border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid; font-size: small;">
                                    SR.No</th>
                                <th
                                    style="width:20%; border-top: 2px solid;border-bottom: 2px solid; font-size: small; text-align: left;">
                                    CUSTOMER&nbsp;NAME</th>
                                <th
                                    style="width:10%; border-top: 2px solid;border-bottom: 2px solid; font-size: small;">
                                    CELL</th>
                                <th
                                    style="width:10%; border-top: 2px solid;border-bottom: 2px solid; font-size: small; text-align: left;">
                                    ADDRESS</th>
                                <th style="width:5%; border-top: 2px solid;border-bottom: 2px solid; font-size: small;">
                                    DEBIT</th>
                                <th style="width:5%; border-top: 2px solid;border-bottom: 2px solid; font-size: small;">
                                    CREDIT</th>
                                <th
                                    style="width:20%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid; font-size: small;">
                                    BALANCE</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sum = 0;
                            $granddebit = 0;
                            $grandcredit = 0; ?>
                            @foreach ($party as $parties)
                                <?php $totalDebit = 0;
                                $totalCredit = 0; ?>
                                @php $sum = $sum + 1; @endphp
                                <tr id="datafont">
                                    <td id="tabledata">{{ $sum }}</td>
                                    <td id="tabledata" style="text-align: left;">{{ $parties->party_name }}</td>
                                    <td id="tabledata">{{ $parties->phone }}</td>
                                    <td id="tabledata" style="text-align: left;">{{ $parties->address }}</td>
                                    <td id="tabledata">{{ number_format($parties->debit) }}</td>
                                    <td id="tabledata">{{ number_format($parties->credit) }}</td>
                                    <?php
                                    
                                    $totalDebit = $totalDebit + $parties->debit;
                                    $totalCredit = $totalCredit + $parties->credit;
                                    $granddebit = $granddebit + $parties->debit;
                                    $grandcredit = $grandcredit + $parties->credit;
                                    
                                    // if ($parties->v_type != "Cash Sale"){
                                    // 		$totalDebit = $totalDebit + $parties->debit;
                                    // $totalCredit = $totalCredit + $parties->credit;
                                    // $granddebit = $granddebit + $parties->debit;
                                    // $grandcredit = $grandcredit + $parties->credit;
                                    // 		}
                                    
                                    ?>



                                    <td id="tabledata">{{ number_format($totalDebit - $totalCredit) }}</td>
                                </tr>
                            @endforeach
                            <tr id="datafont">
                                <td colspan="4"
                                    style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">
                                    <center><b style="float:right;">Total</b></center>
                                </td>

                                <td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;">
                                    {{ number_format($granddebit) }}</td>
                                <td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;">
                                    {{ number_format($grandcredit) }}</td>
                                <td
                                    style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;">
                                    {{ number_format($granddebit - $grandcredit) }}</td>
                            </tr>


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
