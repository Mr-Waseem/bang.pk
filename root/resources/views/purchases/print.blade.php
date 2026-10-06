<html>

<head>
    <link href="{{ asset('css/bg.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body style="border:double;">
    <button style="margin-bottom:10px;margin-left:30px;" onclick="this.style.display='none';window.print()">Print <i
            class="fa fa-print"></i></button>
    <br>
    <div class="row">
        <div>
            <div style="float:left; color: #1e00c6;margin-left: 2%; ">
                <b style="font-size: 23px;">{{ session()->get('company_name') }}</b>
            </div>
            <div style="float: right;padding: 0px 4%;">
                <u style="color: #1e00c6"><strong>PURCHASE INVOICE</strong></u></h3>
            </div>
        </div>
    </div><br><br>

    <div class="row">
        <div>
            <div style="float:left; color: #1e00c6;margin-left: 2%;">

            </div>
            <div style="float: right;color: black;padding: 0px 8%;border: 2px solid black;margin-right: 2%;">
                DATE
            </div>
        </div>
    </div><br>
    <div class="row" style="margin-top: 3px;">
        <div>
            <div style="float:left; color: #1e00c6;padding: 0px 2%;">
                <b>Address: </b>{{ session()->get('company_address') }}
            </div>
            <div style="float: right;margin-right: -16%;">
                {{ date('d/m/Y', strtotime($purchase_detail->date)) }}

            </div>
        </div>
    </div><br>
    <div class="row" style="margin-top: 3px;">
        <div>
            <div style="float: right;color: black;padding: 0px 4%;border: 2px solid black; margin-right: 2%;">
                INVOICE&nbsp;&nbsp;NO.
            </div>
        </div>
    </div>
    <br>
    <div class="row" style="margin-top: 3px;">
        <div>
            <div style="float:left; color: #1e00c6;padding: 0px 2%;margin-top:-20px;">
                <b>Phone: </b>{{ session()->get('company_phone') }}
            </div>
            <div style="float: right;margin-right: -12%;">
                {{ $purchase_detail->bill_no }}
            </div>
        </div>
    </div>
    <br>
    <div class="row" style="margin-top: 3px;">
        <div>
            <div style="float:left; color: #1e00c6;padding: 0px 2%;margin-top:-20px;">
                <b>Email: </b>{{ session()->get('company_email') }}
            </div>
        </div>
    </div><br>
    <div class="row" style="margin-top: 3px;">
        <div>
            <div style="float:left; color: #1e00c6;padding: 0px 2%; color:blue;margin-top:-20px;">
                <b>BILL TO: {{ $purchase_detail->parties->party_name }}</b>
            </div>
        </div>
    </div>
    <table style="width: 98%; border:2px solid; padding: 10px 20px; margin-left: 1%;margin-right: 1%;"
        cellspacing="0px">
        <thead>
            <tr align="left">
                <th
                    style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding:10px;">
                    No</th>
                <th
                    style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding:10px;">
                    code</th>
                <th
                    style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding:10px;">
                    Product</th>
                <th
                    style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding:10px;">
                    Qty</th>
                <th
                    style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;padding:10px;">
                    Purchase Price</th>
                <th
                    style="border-left: 1px solid black;border-top: 1px solid black;border-bottom: 1px solid black;border-right: 1px solid black;padding:10px;">
                    Total</th>
            </tr>
        </thead>

        <tbody>
            <?php $sum = 1;
            $nettotal = 0;
            $totaltax = 0;
            $totalcost = 0; ?>
            @foreach ($purchase_detail->purchase_details as $details)
                <tr class="gradeX">
                    <td style="border-left: 1px solid black;padding:10px;"><?php echo $sum; ?></td>
                    <td style="border-left: 1px solid black;padding:10px;">{{ $details->products->product_code }}</td>
                    <td style="border-left: 1px solid black;padding:10px;">{{ $details->products->product_name }}</td>


                    <td style="border-left: 1px solid black;padding:10px;">{{ number_format($details->quantity, 2) }}
                    {{ $details->products->uom }}</td>
                    <td style="border-left: 1px solid black;padding:10px;">{{ number_format($details->unit_cost) }}</td>

                    <td style="border-left: 1px solid black;border-right: 1px solid black;padding:10px;">
                        {{ number_format($details->unit_cost * $details->quantity) }}</td>
                </tr>
                <?php
                $nettotal = $nettotal + $details->unit_cost * $details->quantity;
                $totalcost = $totalcost + $details->total_cost;
                
                ?>
                <?php $sum = $sum + 1; ?>
            @endforeach


            @if (isset($purchase_detail->purchase_details))
                @if (count($purchase_detail->purchase_details) > 5)
                    @for ($i = 0; $i < 5; $i++)
                        <tr>
                            <td style="border-left: 1px solid black;padding:10px;">&emsp;</td>
                            <td style="border-left: 1px solid black;padding:10px;">&emsp;</td>
                            <td style="border-left: 1px solid black;padding:10px;">&emsp;</td>
                            <td style="border-left: 1px solid black;padding:10px;">&emsp;</td>
                            <td style="border-left: 1px solid black;padding:10px;">&emsp;</td>
                            <td style="border-left: 1px solid black;border-right: 1px solid black;padding:10px;">&emsp;
                            </td>
                        </tr>
                    @endfor
                @else
                    @for ($i = 0; $i < 10; $i++)
                        <tr>
                            <td style="border-left: 1px solid black;padding:10px;">&emsp;</td>
                            <td style="border-left: 1px solid black;padding:10px;">&emsp;</td>
                            <td style="border-left: 1px solid black;padding:10px;">&emsp;</td>
                            <td style="border-left: 1px solid black;padding:10px;">&emsp;</td>
                            <td style="border-left: 1px solid black;padding:10px;">&emsp;</td>
                            <td style="border-left: 1px solid black;border-right: 1px solid black;padding:10px;">&emsp;
                            </td>
                        </tr>
                    @endfor
                @endif
            @endif
        </tbody>
        <tfoot>
            <tr class="gradeX">
                <center>
                    <td align="center" colspan="5"
                        style="border-left: 1px solid black;border-top: 1px solid black;padding:10px;"><b>Total</b></td>
                </center>
                <td
                    style="border-top: 1px solid black;border-left: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">
                    &nbsp;&nbsp;{{number_format($nettotal)}}</td>
            </tr>
            <tr class="gradeX" style="display:none;">
                <center>
                    <td colspan="5">Total Tax</td>
                </center>
                <td style="border-left: 1px solid black;border-top: 1px solid black;padding:10px;">{{number_format($totaltax)}}
                </td>
            </tr>
            <tr class="gradeX">
                <center>
                    <td align="center" colspan="5"
                        style="border-left: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;padding:10px;border-bottom: 1px solid black;">
                        <b>Total Amount</b></td>
                </center>
                <td
                    style="border-left: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;border-bottom: 1px solid black;padding:10px;">
                    {{number_format($totalcost)}}</td>
            </tr>
        </tfoot>
    </table>
    <br>
    
    @include('include.powerdby')

    <!-- <p style="text-align: right;margin-right:15px;margin-bottom:50px;">POWERED BY: PROFESSIONAL ACCOUNTING SERVICES
        &emsp;&emsp; EMAIL: info@paservices.pk</p>
    <p style="text-align: center;">This is system generated invoice no signature required</p>
    <br> -->

</body>

</html>
