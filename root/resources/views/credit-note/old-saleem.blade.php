<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sales Tax Invoice</title>
    <link rel="stylesheet" href="{{ asset('bootstrap4/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            margin: 0%;
            padding: 0%;
        }

        .heading-title,
        .invoice-title {
            background-color: #DCE6F2;
            font-weight: 700;
            border: 2px solid black;
        }

        .invoice-heading {
            margin-top: -10px;
        }

        .invoice-title {
            padding-left: 60px;
            padding-right: 60px;
            font-weight: 900;
        }

        .ntn {
            margin-top: -10px;
        }

        .invoice-box1 {
            border: 2px solid black;
            float: left;
            width: 69.7%;
            margin-right: 2px;
            padding: 10px;
            margin-bottom: 7px;
        }

        .invoice-box2 {
            border: 2px solid black;
            float: right;
            width: 29.7%;
            margin-left: 2px;
            padding: 10px;
        }


        .salestax-details-table {
            width: 100%;
            margin-top: 5px;
        }

        .table-responsive>.table-bordered,
        .salestax-details-table>thead>tr>th,
        .salestax-details-table>tbody>tr>td,
        .salestax-details-table>tfoot>tr>td {
            border-left: 2px solid black !important;
            color: black;
        }

        .less-discount-box,
        .net-invoice-value-box,
        .alpha-rs {
            border: 2px solid black;
        }

        .net-invoice-value-box {
            background-color: #DCE6F1;
            font-weight: bold;
        }

        .alpha-rs {
            margin-top: -62px;
            margin-right: 1px;
            background-color: #DAEEF3;
        }

        hr {
            height: 2px;
            background-color: black;
        }

        .bottom-address {
            position: relative;
            top: -17px;
        }

        .bottom-phone {
            position: relative;
            top: -37px;
        }

        .authorize-signature {
            margin-top: 80px;
            margin-bottom: 40px;
        }
    </style>
</head>

<body>
    <button class="btn btn-primary" onclick="this.style.display='none';window.print()">Print <i
            class="fa fa-print"></i></button>
    <div class="container">
        <div class="row flex-lg-nowrap">
            <div class="col">
                <div class="row">
                    <div class="col mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="e-profile">
                                    <h2 class="text-center heading-title pt-2 pb-2">
                                        {{ session()->get('company_name') }}</h2>
                                    <h5 class="text-center pt-2 pb-2 invoice-heading">
                                        <span class="invoice-title">SALES TAX INVOICE</span>
                                    </h5>
                                    <p class="text-center font-weight-bold ntn">NTN #:
                                        {{ session()->get('company_ntn') }}</p>
                                    {{-- <div class="container"> --}}
                                    <div class="invoice-box1">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td><b>Invoice to: {{ $newsale_detail[0]->parties->party_name }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Address: {{ $newsale_detail[0]->parties->address }}</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>&emsp;</b></td>
                                                </tr>
                                                <tr>
                                                    <td><b>NTN: {{ $newsale_detail[0]->parties->ntn }}</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="invoice-box2">
                                        <table>
                                            <tbody>
                                                <tr>
                                                    <td><b>Invoice No.: </b></td>
                                                    <td><b>&emsp;{{ $newsale_detail[0]->invoice_no }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Invoice Date:</b></td>
                                                    <td><b>&emsp;{{ date('d/m/Y', Strtotime($newsale_detail[0]->date)) }}</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>P.O. No.:</b></td>
                                                    <td><b>&emsp;{{ $newsale_detail[0]->p_order }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td><b>DC.:</b></td>
                                                    <td><b>&emsp;{{ $newsale_detail[0]->dcn_no }}</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <br>
                                    <table class="salestax-details-table" cellpadding="5">
                                        <thead>
                                            <tr class="text-center">
                                                <th rowspan="2"
                                                    style="padding: 0px;border-top: 2px solid black!important;border-bottom: 2px solid black!important;">
                                                    Sr.No.</th>
                                                <th rowspan="2"
                                                    style="border-top: 2px solid black!important;border-bottom: 2px solid black!important;">
                                                    Description</th>
                                                <th rowspan="2"
                                                    style="padding: 0px;width: 5%;border-top: 2px solid black!important;border-bottom: 2px solid black!important;">
                                                    Unit</th>
                                                <th rowspan="2"
                                                    style="padding: 0px;width: 5%;border-top: 2px solid black!important;border-bottom: 2px solid black!important;">
                                                    Qty.</th>
                                                <th rowspan="2" style="padding: 0px;width: 9%;border-top: 2px solid black!important;border-bottom: 2px solid black!important;">
                                                    Unit Price</th>
                                                <th rowspan="2" style="padding: 0px;width: 9%;border-top: 2px solid black!important;border-bottom: 2px solid black!important;">
                                                    Amount<br /> Excl./Tax</th>
                                                <th colspan="2" style="text-align: center;border-top: 2px solid black!important;border-bottom: 2px solid black!important;">
                                                    SALES TAX</th>
                                                <th rowspan="2" style="padding: 0px;width: 9%;border-top: 2px solid black!important;border-bottom: 2px solid black!important;">
                                                    F.TAX</th>
                                                <th rowspan="2" style="padding: 0px;width: 9%;border-top: 2px solid black!important;border-bottom: 2px solid black!important;border-right: 2px solid black!important;">
                                                    Total Inclusive Tax</th>
                                            </tr>
                                            <tr class="text-center">
                                                <th style="text-align: center;padding: 0px;border-top: 2px solid black!important;border-bottom: 2px solid black!important;">
                                                    Rate%</th>
                                                <th style="text-align: center;padding: 0px;border-top: 2px solid black!important;border-bottom: 2px solid black!important;">
                                                    Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sum = 1;
                                            $quantity = 0;
                                            $rate = 0;
                                            $ValueExcTax = 0;
                                            $STValue = 0;
                                            $ExtraSTValue = 0;
                                            $amount = 0;
                                            ?>
                                            @foreach ($newsale_detail[0]->saletax_details as $details)
                                                <tr class="text-center">
                                                    <td>{{ $sum }}</td>
                                                    <td align="left">
                                                        @if ($details->products)
                                                            {{ $details->products->product_name }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $details->unit->uom }}</td>
                                                    <td style="text-align:right;">{{ number_format($details->quantity, 2) }}</td>
                                                    <td style="text-align:right;">{{ number_format($details->rate, 2) }}</td>
                                                    <td style="text-align:right;">{{ number_format($details->quantity * $details->rate) }}</td>
                                                    <td style="text-align:right;">{{ number_format((int) $details->stvalue) }}</td>
                                                    <td style="text-align:right;">{{ number_format($details->taxvalue) }}</td>
                                                    <td style="text-align:right;">{{ number_format($details->extraTaxValue) }}</td>
                                                    <td id="tabledataright" style="border-right: 2px solid black!important;">
                                                        {{ number_format($details->total) }}</td>
                                                </tr>
                                                <?php
                                                $quantity = $quantity + $details->quantity;
                                                $rate = $rate + $details->rate;
                                                $ValueExcTax = $ValueExcTax + $details->quantity * $details->rate;
                                                $STValue = $STValue + $details->taxvalue;
                                                $ExtraSTValue = $ExtraSTValue +  $details->extraTaxValue;
                                                $amount = $amount +  $details->total;
                                                $sum = $sum + 1;
                                                ?>
                                            @endforeach
                                            @if (isset($newsale_detail[0]->saletax_details))
                                                @if (count($newsale_detail[0]->saletax_details) > 5)
                                                    @for ($i = 0; $i < 10; $i++)
                                                        <tr>
                                                            <td>&emsp;</td>
                                                            <td>&emsp;</td>
                                                            <td>&emsp;</td>
                                                            <td>&emsp;</td>
                                                            <td>&emsp;</td>
                                                            <td>&emsp;</td>
                                                            <td>&emsp;</td>
                                                            <td>&emsp;</td>
                                                            <td>&emsp;</td>
                                                            <td style="border-right: 2px solid black!important;">&emsp;
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                @else
                                                    @for ($i = 0; $i < 5; $i++)
                                                        <tr>
                                                            <td>&emsp;</td>
                                                            <td>&emsp;</td>
                                                            <td>&emsp;</td>
                                                            <td>&emsp;</td>
                                                            <td>&emsp;</td>
                                                            <td>&emsp;</td>
                                                            <td>&emsp;</td>
                                                            <td>&emsp;</td>
                                                            <td>&emsp;</td>
                                                            <td style="border-right: 2px solid black!important;">&emsp;
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                @endif
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr class="text-center font-weight-bold">
                                                <td style="border-top:2px solid black!important;border-bottom:2px solid black!important;" colspan="3">Total</td>
                                                <td style="border-top:2px solid black!important;border-bottom:2px solid black!important;">
                                                    {{ number_format($quantity, 2) }}</td>
                                                <td style="border-top:2px solid black!important;border-bottom:2px solid black!important;"></td>
                                                <td style="border-top:2px solid black!important;border-bottom:2px solid black!important;">
                                                    {{ number_format($ValueExcTax) }}</td>
                                                <td style="border-top:2px solid black!important;border-bottom:2px solid black!important;"></td>
                                                <td style="border-top:2px solid black!important;border-bottom:2px solid black!important;">
                                                    {{ number_format($STValue) }}</td>
                                                <td style="border-top:2px solid black!important;border-bottom:2px solid black!important;">
                                                    {{ number_format($ExtraSTValue) }}</td>
                                                <td style="border-right: 2px solid black!important;border-top:2px solid black!important;border-bottom:2px solid black!important;">
                                                    {{ number_format($amount) }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                     <br>
                                    
                                    <!--<div style="text-align: right;font-weight: bold;">
                                        Less Discount: &emsp;
                                        <div
                                            style="float: right;width:17.93%;text-align: right;border:2px solid black;">
                                            &emsp;
                                        </div>
                                    </div>
                                    <br> -->
                                    <!-- <div style="text-align: right;font-weight: bold;position: relative;top:-22px;">
                                        Freight: &emsp;
                                        <div
                                            style="float: right;width:17.93%;text-align: right;border:2px solid black;">
                                            &emsp;
                                        </div>
                                    </div>
                                    <br> -->
                                    <div style="text-align: right;font-weight: bold;">
                                        Net Invoice Value: &emsp;
                                        <div
                                            style="float: right;width:17.93%;text-align: right;border:2px solid black;background-color: #DCE6F1;">
                                            {{ number_format($amount) }} &emsp;
                                        </div>
                                    </div></br>
                                    <div style="text-align: right;font-weight: bold;">
                                    Amount in Words: &emsp;
                                        <div style="float: right;text-align: right;border:2px solid black;background-color: #DCE6F1;">
                                            {{ NumConvert::word($amount) }} &emsp;
                                        </div>
                                    </div>
                                    <!-- <div class="row mt-3 text-right">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <p class="alpha-rs text-capitalize"> {{ NumConvert::word($amount) }}</p>
                                        </div>
                                    </div> -->
                                    <br>
                                    <br>
                                    <br>
                                    @if($newsale_detail[0]->fbr_invoice_no==!null)
                                        <div class="row mt-3">
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <p class="text-capitalize">FBR Invoice No: {{ $newsale_detail[0]->fbr_invoice_no }}</p>
                                                <img id='barcode' style='margin-left:20px' 
                                                src="https://api.qrserver.com/v1/create-qr-code/?data= {{ $newsale_detail[0]->fbr_invoice_no }}&amp;size=50x50'" 
                                                alt="" 
                                                title="FBR Invoice" 
                                                width="100" 
                                                height="100" />
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                            <img src="{{Asset('root\upload\logo\fbrlogo.jpg')}}" style="height: 100px; margin-left: 150px;">
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row text-right">
                                        <!-- <div class="col-lg-12 col-md-12 col-sm-12">
                                            <p class="alpha-rs text-capitalize">Amount in Words: {{ NumConvert::word($amount) }}</p>
                                        </div> -->
                                        <!-- <div class="col-lg-12 col-md-12 col-sm-12">
                                            <h6 class="font-weight-bold mr-5 authorize-signature">Authorized
                                                Signature&emsp;&emsp;</h6>
                                        </div> -->
                                        <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                            <hr>
                                            <p><small 
                                                    class="text-center font-weight-bold bottom-address">{{ session()->get('company_address') }}</small>
                                            </p>
                                            <p><small class="bottom-phone font-weight-bold">Phone #
                                                    {{ session()->get('company_phone') }}</small></p>
                                            <p class="text-center text-capitalize" style="margin-top: -55px;"><small
                                                    class="font-weight-bold">This is system generated invoice no signature required</small></p>
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
@if($company_detail[0]->white_label == 0)
    @include('include.powerdby2')
@endif
    <script src="{{ asset('bootstrap4/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap4/popper.min.js') }}"></script>
    <script src="{{ asset('bootstrap4/bootstrap.min.js') }}"></script>
</body>

</html>
