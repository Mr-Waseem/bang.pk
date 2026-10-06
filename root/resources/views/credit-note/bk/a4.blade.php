<html>

<head>
    <meta charset="utf-8">
    <title>Credit Note Invoice</title>
    <link rel="stylesheet" href="style.css">
    <link rel="license" href="https://www.opensource.org/licenses/mit-license/">
    <script src="script.js"></script>
    <style>
        /* reset */

        * {
            border: 0;
            box-sizing: content-box;
            color: inherit;
            font-family: inherit;
            font-size: inherit;
            font-style: inherit;
            font-weight: inherit;
            line-height: inherit;
            list-style: none;
            margin: 0;
            padding: 0;
            text-decoration: none;
            vertical-align: top;
        }

        /* content editable */

        *[data-prefix] {
            border-radius: 0.25em;
            min-width: 1em;
            outline: 0;
        }

        *[data-prefix] {
            cursor: pointer;
        }

        *[data-prefix]:hover,
        *[data-prefix]:focus,
        td:hover *[data-prefix],
        td:focus *[data-prefix],
        img.hover {
            background: #DEF;
            box-shadow: 0 0 1em 0.5em #DEF;
        }

        span[data-prefix] {
            display: inline-block;
        }

        /* heading */

        h1 {
            font: bold 100% sans-serif;
            letter-spacing: 0.5em;
            text-align: center;
            text-transform: uppercase;
        }

        /* table */

        table {
            font-size: 75%;
            table-layout: fixed;
            width: 100%;
        }

        table {
            border-collapse: separate;
            border-spacing: 2px;
        }

        th,
        td {
            border-width: 1px;
            padding: 0.5em;
            position: relative;
            text-align: left;
        }

        th,
        td {
            border-radius: 0.25em;
            border-style: solid;
        }

        th {
            background: #EEE;
            border-color: #BBB;
        }

        td {
            border-color: #DDD;
        }

        /* page */

        html {
            font: 16px/1 'Open Sans', sans-serif;
            overflow: auto;
            padding: 0.5in;
        }

        html {
            background: #999;
            cursor: default;
        }

        body {
            box-sizing: border-box;
            height: 11in;
            margin: 0 auto;
            overflow: hidden;
            padding: 0.5in;
            width: 8.5in;
        }

        body {
            background: #FFF;
            border-radius: 1px;
            box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
        }

        /* header */

        header {
            margin: 0 0 3em;
        }

        header:after {
            clear: both;
            content: "";
            display: table;
        }

        header h1 {
            background: #000;
            border-radius: 0.25em;
            color: #FFF;
            margin: 0 0 1em;
            padding: 0.5em 0;
        }

        header address {
            float: left;
            font-size: 75%;
            font-style: normal;
            line-height: 1.25;
            margin: 0 1em 1em 0;
        }

        header address p {
            margin: 0 0 0.25em;
        }

        header span,
        header img {
            display: block;
            float: right;
        }

        header span {
            margin: 0 0 1em 1em;
            max-height: 25%;
            max-width: 60%;
            position: relative;
        }

        header img {
            max-height: 100%;
            max-width: 100%;
        }

        header input {
            cursor: pointer;
            -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
            height: 100%;
            left: 0;
            opacity: 0;
            position: absolute;
            top: 0;
            width: 100%;
        }

        /* article */

        article,
        article address,
        table.meta,
        table.inventory {
            margin: 0 0 3em;
        }

        article:after {
            clear: both;
            content: "";
            display: table;
        }

        article h1 {
            clip: rect(0 0 0 0);
            position: absolute;
        }

        article address {
            float: left;
            font-size: 125%;
            font-weight: bold;
        }

        /* table meta & balance */

        table.meta,
        table.balance {
            float: right;
            width: 36%;
        }

        table.meta:after,
        table.balance:after {
            clear: both;
            content: "";
            display: table;
        }

        /* table meta */

        table.meta th {
            width: 40%;
        }

        table.meta td {
            width: 60%;
        }

        /* table items */

        table.inventory {
            clear: both;
            width: 100%;
        }

        table.inventory th {
            font-weight: bold;
            text-align: center;
        }

        table.inventory td:nth-child(1) {
            width: 26%;
        }

        table.inventory td:nth-child(2) {
            width: 38%;
        }

        table.inventory td:nth-child(3) {
            text-align: right;
            width: 12%;
        }

        table.inventory td:nth-child(4) {
            text-align: right;
            width: 12%;
        }

        table.inventory td:nth-child(5) {
            text-align: right;
            width: 12%;
        }

        /* table balance */

        table.balance th,
        table.balance td {
            width: 50%;
        }

        table.balance td {
            text-align: right;
        }

        /* aside */

        aside h1 {
            border: none;
            border-width: 0 0 1px;
            margin: 0 0 1em;
        }

        aside h1 {
            border-color: #999;
            border-bottom-style: solid;
        }

        /* javascript */

        .add,
        .cut {
            border-width: 1px;
            display: block;
            font-size: .8rem;
            padding: 0.25em 0.5em;
            float: left;
            text-align: center;
            width: 0.6em;
        }

        .add,
        .cut {
            background: #9AF;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            background-image: -moz-linear-gradient(#00ADEE 5%, #0078A5 100%);
            background-image: -webkit-linear-gradient(#00ADEE 5%, #0078A5 100%);
            border-radius: 0.5em;
            border-color: #0076A3;
            color: #FFF;
            cursor: pointer;
            font-weight: bold;
            text-shadow: 0 -1px 2px rgba(0, 0, 0, 0.333);
        }

        .add {
            margin: -2.5em 0 0;
        }

        .add:hover {
            background: #00ADEE;
        }

        .cut {
            opacity: 0;
            position: absolute;
            top: 0;
            left: -1.5em;
        }

        .cut {
            -webkit-transition: opacity 100ms ease-in;
        }

        tr:hover .cut {
            opacity: 1;
        }

        @media print {
            * {
                -webkit-print-color-adjust: exact;
            }

            html {
                background: none;
                padding: 0;
            }

            body {
                box-shadow: none;
                margin: 0;
            }

            span:empty {
                display: none;
            }

            .add,
            .cut {
                display: none;
            }
        }

        @page {
            margin: 0;
        }

    </style>
</head>

<body style="width: 10.5in; height: auto;" onload="window.print(); setTimeout(window.close, 0.00);">

    <header>
        <!-- <h1>SalesTax Invoice</h1> -->
        <address data-prefix style="float: right;">
            <!-- <p style="font-size: 14px;"><b>{{ $company_detail[0]->system_name }}</b></p>
     <p style="font-size: 14px;">{{ $company_detail[0]->address }}</p>
     <p style="font-size: 14px;">{{ $company_detail[0]->phone }}</p> -->
            
        </address>
        <!-- <span><img alt="" src="http://www.jonathantneal.com/examples/invoice/logo.png"><input type="file" accept="image/*"></span> -->
     </header>
     @include('include.company-header')
     {{-- @include('include.header',['company_detail'=>$company_detail]) --}}
     <h2 style="font-size: 25px;text-align:center; font-family: system-ui;font-weight:700;margin-top:10px;">CREDIT NOTE</h2><br /><br /><br />
     <article>
        <h1>Recipient</h1>
        <address data-prefix>
            <p style="font-weight: 500; font-size: 24px;">BUYER NAME: {{ $newsale_detail[0]->parties->party_name }}</p>
            <br />
            <p style="font-weight: 500; font-size: 16px;"><b>Address:</b> {{ $newsale_detail[0]->parties->address }}</p>
            <br />
            <p style="font-weight: 500; font-size: 24px;">
                @if( session()->get('company_ntn_show')==1)
                <b>NTN:</b>
                 {{ $newsale_detail[0]->parties->ntn }}
             
             @else
                 <b style='display:none'></b>
             
             @endif
                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
             @if( session()->get('company_strn_show')==1)
                 <b>STRN:</b>
                 {{ $newsale_detail[0]->parties->strn }}
             @else
                 <b style='display:none'></b>
             
             @endif
             </p>
        </address>
        <!-- <address>
    
     </address> -->

        <table class="meta">
            <tr>
                <th style="border: 2px solid; font-size: medium;"><span data-prefix>Invoice #</span></th>
                <td style="border: 1px solid; font-size: medium;"><span
                        data-prefix>{{ $newsale_detail[0]->invoice_no }}</span></td>
            </tr>
            {{-- <tr>
                <th style="border: 2px solid; font-size: medium;"><span data-prefix>FBR.Inv #</span></th>
                <td style="border: 1px solid; font-size: medium;"><span
                        data-prefix>{{ $newsale_detail[0]->fbr_invoice_no }}</span></td>
            </tr> --}}
            <tr>
                <th style="border: 2px solid;"><span data-prefix>Date</span></th>
                <td style="border: 1px solid;"><span
                        data-prefix>{{ date('d/m/Y', Strtotime($newsale_detail[0]->date)) }}</span></td>
            </tr>
            <!-- <tr>
     <th><span data-prefix>Amount Due</span></th>
     <td><span id="prefix" data-prefix>$</span><span>600.00</span></td>
     </tr> -->
        </table>
        <table class="inventory">
            <thead>
                <tr style="font-size: medium;">
                    <th style="border: 2px solid;"><span data-prefix><b style="font-weight: 500;">Qty</b></span></th>
                    <th style="width:30%; border: 2px solid;"><span data-prefix>Description</span></th>
                    <th style="border: 2px solid;"><span data-prefix>Rate</span></th>
                    <th style="border: 2px solid;"><span data-prefix>Value Exc.Sales Tax</span></th>
                    <th style="border: 2px solid;"><span data-prefix>S.T%</span></th>
                    <th style="border: 2px solid;"><span data-prefix>S.T Value</span></th>
                    <th style="border: 2px solid;"><span data-prefix>Value Inc.ST & Rate</span></th>
                    <!-- <th><span data-prefix>Price</span></th>
      <th><span data-prefix>Price</span></th> -->
                </tr>
            </thead>
            <tbody>
                <?php $sum = 1;
                $quantity = 0;
                $rate = 0;
                $ValueExcTax = 0;
                $STValue = 0;
                $amount = 0; ?>
                @foreach ($newsale_detail[0]->saletax_details as $details)
                    <tr>
                        <td style="border: 1px solid; height: 40px;padding-top: 14px; text-align: center;"><span
                                data-prefix><b style="font-weight: 500;">{{ $details->quantity }}
                                    {{ $details->products->uom }}
                                </b></span></td>
                        <td style="border: 1px solid; height: 40px;padding-top: 14px; text-align: center;"><span
                                data-prefix><b
                                    style="font-weight: 500;">{{ $details->products->product_name }}</b></span></td>
                        <td style="border: 1px solid; height: 40px;padding-top: 14px; text-align: center;"><span
                                data-prefix></span><span data-prefix><b
                                    style="font-weight: 500;">{{ $details->rate }}</b></span></td>
                        <td style="border: 1px solid; height: 40px;padding-top: 14px; text-align: center;"><span
                                data-prefix><b
                                    style="font-weight: 500;">{{ number_format((int) $details->quantity * $details->rate) }}</b></span>
                        </td>
                        <td style="border: 1px solid; height: 40px;padding-top: 14px; text-align: center;"><span
                                data-prefix></span><span><b
                                    style="font-weight: 500;">{{ $details->stvalue }}</b></span></td>
                        <td style="border: 1px solid; height: 40px;padding-top: 14px; text-align: center;"><span
                                data-prefix></span><span><b
                                    style="font-weight: 500;">{{ number_format((int) $details->taxvalue) }}</b></span>
                        </td>
                        <td style="border: 1px solid; height: 40px;padding-top: 14px; text-align: center;"><span
                                data-prefix></span><span><b
                                    style="font-weight: 500;">{{ number_format((int) $details->total) }}</b></span></td>
                        <!-- <td><span data-prefix>$</span><span>600.00</span></td>
      <td><span data-prefix>$</span><span>600.00</span></td> -->
                    </tr>





                    <?php
                    
                    $quantity = $quantity + $details->quantity;
                    $rate = $rate + $details->price;
                    $ValueExcTax = $ValueExcTax + $details->quantity * $details->rate;
                    $STValue = $STValue + $details->taxvalue;
                    $amount = $amount + $details->total;
                    $sum = $sum + 1;
                    ?>
                @endforeach

                <tr>
                    <td style="border: 1px solid;"><span data-prefix>.</span></td>
                    <td style="border: 1px solid;"><span data-prefix></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span data-prefix></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span></span></td>
                    <!-- <td><span data-prefix>$</span><span>600.00</span></td>
      <td><span data-prefix>$</span><span>600.00</span></td> -->
                </tr>
                <tr>
                    <td style="border: 1px solid;"><span data-prefix>.</span></td>
                    <td style="border: 1px solid;"><span data-prefix></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span data-prefix></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span></span></td>
                    <!-- <td><span data-prefix>$</span><span>600.00</span></td>
      <td><span data-prefix>$</span><span>600.00</span></td> -->
                </tr>
                
            </tbody>
        </table>
        <!-- <a class="add">+</a> -->
        <table class="balance">
            <tr>
                <th style="border: 2px solid; font-size: medium;"><span data-prefix>Total Exc.ST</span></th>
                <td style="border: 1px solid; font-weight: 500;"><span
                        data-prefix>Rs:&nbsp;</span><span>{{ number_format((int) $ValueExcTax) }}</span></td>
            </tr>
            <tr>
                <th style="border: 2px solid; font-size: medium;"><span data-prefix>Total Tax</span></th>
                <td style="border: 1px solid; font-weight: 500;"><span
                        data-prefix>Rs:&nbsp;</span><span>{{ number_format((int) $STValue) }}</span></td>
            </tr>
            <tr>
                <th style="border: 2px solid; font-size: medium;"><span data-prefix>Total Amount</span></th>
                <td style="border: 1px solid; font-weight: 500;"><span data-prefix>Rs:&nbsp;</span><span
                        data-prefix>{{ number_format((int) $amount) }}</span></td>
            </tr>
            <!-- <tr>
     <th><span data-prefix>Balance Due</span></th>
     <td><span data-prefix>$</span><span>600.00</span></td>
     </tr> -->
        </table>

        <table>
            <tr>

                <!-- <th style="border:2px solid; font-size:20px;"><span data-prefix>ISSED BY: </span></th>
     <td style="border-bottom: 2px solid; border-top: none;" colspan="3"><span data-prefix></span></td> -->
                <th style="border:2px solid; font-size:20px;" colspan=""><span data-prefix>SIGNATURE: </span></th>
                <td style="border-bottom: 2px solid; border-top: none;" colspan="3"><span data-prefix></span></td>

            </tr>
            <!-- <tr>
     <th style="border: 2px solid;"><span data-prefix>RECIEVED BY</span></th>
     <td style="border: 2px solid;"><span data-prefix></span></td>
        </tr> -->

            <!-- <tr>
     <th><span data-prefix>Balance Due</span></th>
     <td><span data-prefix>$</span><span>600.00</span></td>
          </tr> -->
        </table>
         </article>
         @if ($newsale_detail[0]->fbr_invoice_no==!null)
    <div>
        <h4>FBR Invoice No: {{ $newsale_detail[0]->fbr_invoice_no }}</h4><br><br>
        <img id='barcode' style='margin-left:20px' 
            {{-- src= {{ $newsale_detail[0]->fbr_invoice_no }}  --}}
            src="https://api.qrserver.com/v1/create-qr-code/?data= {{ $newsale_detail[0]->fbr_invoice_no }}&amp;size=50x50'" 
            alt="" 
            title="FBR Invoice" 
            width="100" 
            height="100" />
        {{-- {{ QRCode::text({{ $newsale_detail[0]->fbr_invoice_no }})->svg() }} --}}
        <img src="{{Asset('root\upload\logo\fbrlogo.jpg')}}" style="height: 100; margin-left: 650px;">
    </div>
    @else
        
    @endif
    <aside>
        <h1><span data-prefix>THANK YOU FOR YOUR BUSINESS</span></h1>
        @if($company_detail[0]->white_label == 0)
        <div data-prefix style="float:right;">
            <p>DEVELOPED BY <b style="font-weight: 500; font-size: 18;">IT LIFE</b> | +92 321 4197290 | www.itlifee.net </p>
        </div>
        @endif
       
    </aside>
</body>

</html>
