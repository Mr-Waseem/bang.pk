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
                <u style="color: #1e00c6"><strong>SALES BILL</strong></u></h3>
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
                {{ date('d/m/Y', Strtotime($newsale_detail[0]->date)) }}

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
                {{ $newsale_detail[0]->invoice_no }}
            </div>
        </div>
    </div>
    </br>
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
                <b>BILL TO: {{ $newsale_detail[0]->parties->party_name }}</b>
            </div>
        </div>
    </div>
    <table style="width: 98%; border:2px solid; padding: 10px 20px; margin-left: 1%;
    margin-right: 1%;">
        <thead>
            <tr>
                <th style="width:1%; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">SR#</th>
                <th style="width:75%; border-top: 2px solid;border-bottom: 2px solid;">
                    <center>Item&nbsp;Description</center>
                </th>
                <th style="width:70px; border-top: 2px solid;border-bottom: 2px solid;">
                    <center>Quantity</center>
                </th>

                <th style="width:70px; border-top: 2px solid;border-bottom: 2px solid;">
                    <center>Rate</center>
                </th>
                <th style="width:100px; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;">
                    <center>Amount</center>
                </th>
            </tr>
        </thead>

        <tbody>
            <?php $sum = 1;
            $quantity = 0;
            $rate = 0;
            $amount = 0;
            $discount = 0;
            $discountvalue = 0;
            $grossamount = 0;
            $Weight = 0; ?>
            @foreach ($newsale_detail[0]->sale_details as $details)
                <tr id="datafont" style="border:2px solid;">
                    <td id="tabledata">
                        <center style=" font-size:16px; font-weight: 600;">{{ $sum }}</center>
                    </td>

                    <td id="tabledata">
                        <center style="float: left; margin-left:5px; font-size:16px; font-weight: 600;">
                            @if ($details->products != null)
                                {{ $details->products->product_name }}
                            @endif
                            @if ($details->products->product_urdu != null)
                                - {{ $details->products->product_urdu }}
                            @endif

                        </center>
                        <span style="float:right;">{{ $details->products->uom}}</span>
                    </td>
                    <td id="tabledata" style="font-size:16px; font-weight: 600;">
                        <center>{{ number_format($details->quantity, 3) }}</center>
                    </td>

                    @php
                        $value = ($details->discount->discount / 100) * ($details->sale_rate * $details->quantity);
                        $gross = $details->sale_rate * $details->quantity;
                        
                    @endphp
                    <td id="tabledata" style="font-size:16px; font-weight: 600;">
                        <center>{{ number_format((int) $details->sale_rate) }}</center>
                    </td>
                    <td id="tabledata" style="font-size:16px; font-weight: 600;">
                        <center>{{ number_format((int) $details->sale_amount) }}</center>
                    </td>
                </tr>
                <?php
                
                $discount = $discount + (int) $details->discount->discount;
                $discountvalue = $discountvalue + (int) $value;
                
                $quantity = $quantity + (float) $details->quantity;
                $rate = $rate + (float) $details->sale_rate;
                $grossamount = $grossamount + (float) $details->sale_amount;
                $sum = $sum + 1;
                ?>
            @endforeach

            @if (isset($newsale_detail[0]->sale_details))
                @if (count($newsale_detail[0]->sale_details) > 5)
                    @for ($i = 0; $i < 10; $i++)
                        <tr>
                            <td>&emsp;</td>
                            <td>&emsp;</td>
                            <td>&emsp;</td>
                            <td>&emsp;</td>
                            <td>&emsp;</td>
                        </tr>
                    @endfor
                @else
                    @for ($i = 0; $i < 15; $i++)
                        <tr>
                            <td>&emsp;</td>
                            <td>&emsp;</td>
                            <td>&emsp;</td>
                            <td>&emsp;</td>
                            <td>&emsp;</td>
                        </tr>
                    @endfor
                @endif
            @endif



            <tr id="datafont">
                <td>
                    <center></center>
                </td>
                <td>
                    <center></center>
                </td>

                <td id="tabledata" colspan="2" style="background: #b2dee8; font-size:12px; font-weight: 600;">
                    <center>TOTAL QUANTITY</center>
                </td>
                <td id="tabledata" colspan="2" style="background: #b2dee8; font-size:12px; font-weight: 600;">
                    <center> {{ number_format($quantity, 2) }}</center>
                </td>
            </tr><br>

            <tr id="datafont">
                <td>Remarks</td>
                <td>
                    <center></center>
                </td>

                <td id="tabledata" colspan="2" style="background: #b2dee8; font-size:12px; font-weight: 600;">
                    <center>GROSS TOTAL</center>
                </td>
                <td id="tabledata" colspan="2" style="background: #b2dee8; font-size:12px; font-weight: 600;">
                    <center>{{ $company_detail[0]->currency }}: {{ number_format($grossamount) }}</center>
                </td>

            </tr>

            <tr id="datafont">
                <td>
                    <center></center>
                </td>
                <td>
                    <center></center>
                </td>

                <td id="tabledata" colspan="2" style="background: #b2dee8; font-size:12px; font-weight: 600;">
                    <center>NET TOTAL</center>
                </td>
                <td id="tabledata" colspan="2" style="background: #b2dee8; font-size:16px; font-weight: 600;">
                    <center>{{ $company_detail[0]->currency }}: {{ number_format($grossamount - $discount) }}
                    </center>
                </td>
            </tr><br>

        </tbody>
    </table>
</body>
<br>
@php
$debit = 0;
$credit = 0;
@endphp
@foreach ($ledgers as $ledger)
    @php
        $debit = $debit + (int) $ledger->debit;
        $credit = $credit + (int) $ledger->credit;
    @endphp
@endforeach
@php $totalBalance = $debit-$credit;@endphp
@if ($newsale_detail[0]->parties->id != 1)
    <table style="width:100%; border-bottom:2px dotted;">
        <tr>
            <td style="font-size: 12px; font-family: monospace;">&nbsp;&nbsp;&nbsp;PREVIOUS
                BALANCE:{{ $company_detail[0]->currency }}:
                {{ number_format($totalBalance - $grossamount - $discount) }}
            </td>
            <td style="font-size: 12px; font-family: monospace;">G.Total: {{ $company_detail[0]->currency }}:
                {{ number_format($grossamount - $discount) }}</td>
        </tr>
        <tr>
            <td style="font-size: 12px; font-family: monospace;">&nbsp;&nbsp;&nbsp;TOTAL BALANCE:
                {{ $company_detail[0]->currency }}: {{ number_format($totalBalance) }}</td>
        </tr>
    </table>
    <br />
@endif
<table style="width:100%; border-bottom:2px solid;">

    <tr>
        <td style="font-size: 12px; font-family: monospace;">&nbsp;&nbsp;&nbsp;Driver:
            {{ $newsale_detail[0]->driver }}
        </td>
        <td></td>
        <td style="font-size: 12px; font-family: monospace;">Vehicle#: {{ $newsale_detail[0]->vehicle }}</td>
    </tr>
    <tr>
        <td style="font-size: 12px; font-family: monospace;">&nbsp;&nbsp;&nbsp;Freight:
            {{ $newsale_detail[0]->freight }}</td>
        <td></td>
        <td style="font-size: 12px; font-family: monospace;">Returnable: {{ $newsale_detail[0]->returnable }}</td>
    </tr>
</table>
<table style="width:100%;">



    <tr>
        <td style="font-size: 12px; font-family: monospace;">&nbsp;&nbsp;&nbsp;Created By</td>
        <td style="font-size: 12px; font-family: monospace;">Checked By</td>
        <td style="font-size: 12px; font-family: monospace;">Approved By</td>
    </tr>
    <tr>
        <td style="font-size: 12px; font-family: monospace;">
            &nbsp;&nbsp;&nbsp;{{ $newsale_detail[0]->billers->name }}
        </td>
        <td style="font-size: 12px; font-family: monospace;">__________________</td>
        <td style="font-size: 12px; font-family: monospace;">__________________</td>
    </tr>

</table>

</html>
<br>
