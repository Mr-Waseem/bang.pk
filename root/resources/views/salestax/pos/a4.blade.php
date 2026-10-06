<html>

<head>
    <meta charset="utf-8">
    <title>SalesTax Invoice</title>
    <style>
        * {
            box-sizing: border-box;
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

        html {
            font: 12.5px/1.35 "Segoe UI", Tahoma, sans-serif;
            overflow: auto;
            padding: 0.15in;
            background: #ececec;
            cursor: default;
            color: #111;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        body {
            box-sizing: border-box;
            height: auto;
            min-height: 11in;
            margin: 0 auto;
            overflow: visible;
            padding: 0.28in 0.32in;
            width: 210mm;
            max-width: 100%;
            background: #fff;
            box-shadow: 0 1px 10px rgba(0, 0, 0, 0.1);
        }

        span[data-prefix] {
            display: inline-block;
            outline: 0;
            min-width: 0;
        }

        header {
            margin: 0;
        }

        header:after {
            clear: both;
            content: "";
            display: table;
        }

        .company-header {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 0 0 8px;
            border-bottom: 1px solid #333;
        }

        .company-header td {
            border: none;
            padding: 0 0 8px;
            vertical-align: middle;
        }

        .company-header .ch-info {
            text-align: left;
            width: 72%;
        }

        .company-header .ch-logo {
            text-align: right;
            width: 28%;
            padding-left: 12px;
        }

        .company-header .ch-name {
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 0.2px;
            color: #111;
            font-family: Georgia, "Times New Roman", serif;
            line-height: 1.2;
        }

        .company-header .ch-meta {
            font-weight: 600;
            margin-top: 3px;
            font-size: 12px;
            color: #333;
        }

        .company-header .ch-address {
            margin-top: 3px;
            font-size: 11px;
            color: #555;
            line-height: 1.35;
            font-style: normal;
        }

        .company-header .ch-logo img {
            max-width: 140px;
            max-height: 56px;
            object-fit: contain;
        }

        .company-header--plain .ch-info {
            width: 100%;
            text-align: center;
        }

        .invoice-title {
            font-family: Georgia, "Times New Roman", serif;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-align: center;
            text-transform: uppercase;
            color: #111;
            margin: 0 0 10px;
            padding: 0;
            border: none;
        }

        article {
            margin: 0 0 0.5em;
        }

        article:after {
            clear: both;
            content: "";
            display: table;
        }

        article > h1 {
            clip: rect(0 0 0 0);
            position: absolute;
        }

        .recipient {
            float: left;
            width: 58%;
            font-style: normal;
            margin: 0 0 0.65em;
            padding-right: 0.6em;
        }

        .recipient .party-name {
            font-size: 13px;
            font-weight: 700;
            color: #111;
            margin: 0 0 2px;
            line-height: 1.3;
        }

        .recipient .party-line {
            font-size: 11.5px;
            font-weight: 500;
            color: #333;
            margin: 0 0 1px;
            line-height: 1.35;
        }

        .recipient .party-line b {
            font-weight: 700;
            color: #111;
        }

        table {
            font-size: 11px;
            table-layout: fixed;
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
        }

        th,
        td {
            padding: 4px 6px;
            text-align: left;
            vertical-align: middle;
        }

        /*
         * Chrome Save-as-PDF drops 1px hairlines at some zoom levels.
         * Use collapse + 1.5px solid on EVERY cell, plus inset shadow backup.
         */
        table.meta,
        table.inventory,
        table.balance {
            border: 1.5px solid #000;
            border-collapse: collapse;
            border-spacing: 0;
            empty-cells: show;
        }

        table.meta th,
        table.meta td,
        table.inventory th,
        table.inventory td,
        table.balance th,
        table.balance td {
            border: 1.5px solid #000;
            background-clip: padding-box;
            box-shadow: inset 0 0 0 1px #000;
        }

        table.meta {
            float: right;
            width: 36%;
            margin: 0 0 0.65em;
        }

        table.meta th,
        table.meta td {
            font-size: 11px;
            vertical-align: middle;
            padding: 4px 7px;
        }

        table.meta th {
            width: 38%;
            background-color: #f2f2f2;
            color: #222;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.02em;
            font-size: 9.5px;
        }

        table.meta td {
            width: 62%;
            background-color: #fff;
            font-weight: 600;
            color: #111;
        }

        table.inventory {
            clear: both;
            width: 100%;
            margin: 0 0 0.55em;
        }

        table.inventory th,
        table.inventory td {
            padding: 4px 5px;
        }

        table.inventory thead th {
            background-color: #f0f0f0;
            color: #111;
            font-weight: 700;
            text-align: center;
            font-size: 10px;
            letter-spacing: 0;
        }

        table.inventory tbody td {
            font-weight: 600;
            color: #111;
            background-color: #fff;
        }

        table.inventory tbody tr:nth-child(even) td {
            background-color: #fafafa;
        }

        table.inventory .col-desc {
            text-align: left;
            width: 28%;
        }

        table.inventory .col-num {
            text-align: right;
        }

        table.inventory .col-qty {
            text-align: center;
            width: 11%;
        }

        table.balance {
            float: right;
            width: 36%;
            margin: 0 0 0.65em;
        }

        table.balance th,
        table.balance td {
            font-size: 11px;
            padding: 4px 7px;
            width: 50%;
        }

        table.balance th {
            background-color: #f2f2f2;
            font-weight: 700;
            color: #222;
        }

        table.balance td {
            text-align: right;
            font-weight: 600;
            background-color: #fff;
        }

        table.balance tr.total-row th,
        table.balance tr.total-row td {
            background-color: #e8e8e8;
            color: #111;
            font-weight: 700;
        }

        table.balance tr.total-row td {
            font-size: 12px;
        }

        .authority-block {
            clear: both;
            margin: 0.5em 0 0.65em;
            padding-top: 0.25em;
        }

        .authority-block h4 {
            font-size: 11.5px;
            font-weight: 700;
            color: #111;
            margin: 0 0 6px;
        }

        .authority-block .qr-row {
            display: table;
            width: 100%;
        }

        .authority-block .qr-row img {
            display: inline-block;
            vertical-align: top;
        }

        .authority-block img#barcode {
            margin-left: 0 !important;
            border: 1px solid #999;
            padding: 2px;
        }

        .authority-block .auth-logo {
            height: 80px;
            margin-left: 24px !important;
            object-fit: contain;
        }

        aside {
            clear: both;
            margin-top: 1em;
            padding-top: 0;
            border-top: none;
            text-align: center;
        }

        aside h1 {
            border: none;
            margin: 0 0 0.45em;
            font-family: Georgia, "Times New Roman", serif;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-align: center;
            text-transform: uppercase;
            color: #555;
        }

        aside .dev-footer {
            float: none;
            display: block;
            text-align: center;
            font-size: 10px;
            line-height: 1.45;
            color: #333;
            margin-top: 4px;
        }

        aside .dev-footer b {
            font-weight: 700;
            color: #111;
            font-size: 11px;
        }

        .add,
        .cut {
            display: none;
        }

        @media print {
            html,
            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            html {
                background: none;
                padding: 0;
            }

            body {
                box-shadow: none;
                margin: 0;
                width: 100%;
                max-width: none;
                padding: 0;
            }

            table.meta,
            table.inventory,
            table.balance {
                border-collapse: collapse !important;
                border-spacing: 0 !important;
                border: 1.5px solid #000 !important;
            }

            table.meta th,
            table.meta td,
            table.inventory th,
            table.inventory td,
            table.balance th,
            table.balance td {
                border: 1.5px solid #000 !important;
                box-shadow: inset 0 0 0 1px #000 !important;
                background-clip: padding-box !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
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
            margin: 0.4in;
        }
    </style>
</head>

<body style="width: 210mm; height: auto;" onload="window.print(); setTimeout(window.close, 0.00);">
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
    <h2 class="invoice-title">SALES TAX INVOICE</h2>
    <article>
        <h1>Recipient</h1>
        <address data-prefix class="recipient">
            @php
                $headerSystem = $company->system_type ?? ($sellerCompany->system_type ?? session()->get('system_type'));
            @endphp
            <p class="party-name">@if($headerSystem == 'PRA' || auth()->id() == 637) Service Recipient: @else BUYER NAME: @endif {{ $newsale_detail[0]->parties->party_name }}</p>
            @php
                $partyAddress = trim((string) ($newsale_detail[0]->parties->address ?? ''));
                $partyNtn = trim((string) ($newsale_detail[0]->parties->ntn ?? ''));
                $partyStrn = trim((string) ($newsale_detail[0]->parties->strn ?? ''));
            @endphp
            @if(filled($partyAddress))
            <p class="party-line"><b>Address:</b> {{ $partyAddress }}</p>
            @endif
            @if((session()->get('company_ntn_show') == 1 && filled($partyNtn)) || (session()->get('company_strn_show') == 1 && filled($partyStrn)))
            <p class="party-line">
               @if(session()->get('company_ntn_show') == 1 && filled($partyNtn))
               <b>NTN:</b> {{ $partyNtn }}
               @endif
               @if(session()->get('company_ntn_show') == 1 && filled($partyNtn) && session()->get('company_strn_show') == 1 && filled($partyStrn))
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               @endif
               @if(session()->get('company_strn_show') == 1 && filled($partyStrn))
                <b>STRN:</b> {{ $partyStrn }}
               @endif
            </p>
            @endif
        </address>
        <!-- <address>
    
   </address> -->

        <table class="meta">
            <tr>
                <th><span data-prefix>Invoice #</span></th>
                <td><span
                        data-prefix>{{ ($company->invoiceno_prefix ?? '') }}{{ $newsale_detail[0]->invoice_no }}</span></td>
            </tr>
            {{-- <tr>
                <th style="border: 2px solid; font-size: medium;"><span data-prefix>FBR.Inv #</span></th>
                <td style="border: 1px solid; font-size: medium;"><span
                        data-prefix>{{ $newsale_detail[0]->fbr_invoice_no }}</span></td>
            </tr> --}}
            <tr>
                <th><span data-prefix>Date</span></th>
                <td><span
                        data-prefix>{{ date('d/m/Y', Strtotime($newsale_detail[0]->date)) }}</span></td>
            </tr>
            @if($newsale_detail[0]->dcn_no)
            <tr>
                <th><span data-prefix>DC No</span></th>
                <td><span data-prefix>{{ $newsale_detail[0]->dcn_no }}</span></td>
            </tr>
            @endif
            @if($newsale_detail[0]->p_order)
            <tr>
                <th><span data-prefix>PO No</span></th>
                <td><span data-prefix>{{ $newsale_detail[0]->p_order }}</span></td>
            </tr>
            @endif
            @if($newsale_detail[0]->remarks)
            <tr>
                <th><span data-prefix>Remarks</span></th>
                <td><span data-prefix>{{ $newsale_detail[0]->remarks }}</span></td>
            </tr>
            @endif
            <!-- <tr>
     <th><span data-prefix>Amount Due</span></th>
     <td><span id="prefix" data-prefix>$</span><span>600.00</span></td>
    </tr> -->
        </table>
        <table class="inventory">
            <thead>
                <tr>
                    <th class="col-qty"><span data-prefix>Qty</span></th>
                    <th class="col-desc"><span data-prefix>Description</span></th>
                    <th class="col-num"><span data-prefix>Rate</span></th>
                    <th class="col-num"><span data-prefix>Value Exc.Sales Tax</span></th>
                    <th class="col-num"><span data-prefix>S.T%</span></th>
                    <th class="col-num"><span data-prefix>S.T Value</span></th>
                    <th class="col-num"><span data-prefix>Value Inc.ST & Rate</span></th>
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
                        <td class="col-qty"><span
                                data-prefix>{{ $details->quantity }}
                                    {{ $details->products->uom }}</span></td>
                        <td class="col-desc"><span
                                data-prefix>{{ $details->products->product_name }}</span></td>
                        <td class="col-num"><span data-prefix></span><span data-prefix>{{ $details->rate }}</span></td>
                        <td class="col-num"><span
                                data-prefix>{{ number_format((int) $details->quantity * $details->rate) }}</span>
                        </td>
                        <td class="col-num"><span
                                data-prefix></span><span>{{ $details->stvalue }}</span></td>
                        <td class="col-num"><span
                                data-prefix></span><span>{{ number_format($details->taxvalue, 2) }}</span>
                        </td>
                        <td class="col-num"><span
                                data-prefix></span><span>{{ number_format($details->total, 2) }}</span></td>
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

                <!-- <tr>
                    <td style="border: 1px solid;"><span data-prefix>.</span></td>
                    <td style="border: 1px solid;"><span data-prefix></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span data-prefix></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span></span></td>
                </tr>
                <tr>
                    <td style="border: 1px solid;"><span data-prefix>.</span></td>
                    <td style="border: 1px solid;"><span data-prefix></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span data-prefix></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span></span></td>
                </tr>
                <tr>
                    <td style="border: 1px solid;"><span data-prefix>.</span></td>
                    <td style="border: 1px solid;"><span data-prefix></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span data-prefix></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span></span></td>
                </tr>
                <tr>
                    <td style="border: 1px solid;"><span data-prefix>.</span></td>
                    <td style="border: 1px solid;"><span data-prefix></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span data-prefix></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span></span></td>
                </tr>
                <tr>
                    <td style="border: 1px solid;"><span data-prefix>.</span></td>
                    <td style="border: 1px solid;"><span data-prefix></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span data-prefix></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span></span></td>
                </tr>
                <tr>
                    <td style="border: 1px solid;"><span data-prefix>.</span></td>
                    <td style="border: 1px solid;"><span data-prefix></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span data-prefix></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span></span></td>
                    <td style="border: 1px solid;"><span data-prefix></span><span></span></td>
                </tr> -->

            </tbody>
        </table>
        <!-- <a class="add">+</a> -->
        <table class="balance">
            <tr>
                <th><span data-prefix>Total Exc.ST</span></th>
                <td><span
                        data-prefix>Rs:&nbsp;</span><span>{{ number_format($ValueExcTax, 2) }}</span></td>
            </tr>
            <tr>
                <th><span data-prefix>Total Tax</span></th>
                <td><span
                        data-prefix>Rs:&nbsp;</span><span>{{ number_format($STValue, 2) }}</span></td>
            </tr>
            <tr class="total-row">
                <th><span data-prefix>Total Amount</span></th>
                <td><span data-prefix>Rs:&nbsp;</span><span
                        data-prefix>{{ number_format($amount, 2) }}</span></td>
            </tr>
            <!-- <tr>
     <th><span data-prefix>Balance Due</span></th>
     <td><span data-prefix>$</span><span>600.00</span></td>
    </tr> -->
        </table>

    </article>
    @if ($newsale_detail[0]->fbr_invoice_no==!null)
    <div class="authority-block">
        @if($company->system_type == "POS")
                <h4>FBR Invoice No: {{ $newsale_detail[0]->fbr_invoice_no }}</h4>
        @endif
        @if($company->system_type == "PRA")
                <h4>PRA Invoice No: {{ $newsale_detail[0]->fbr_invoice_no }}</h4>
        @endif
        @if($company->system_type == "KPRA")
                <h4>KPRA Transaction ID: {{ $newsale_detail[0]->fbr_invoice_no }}</h4>
        @endif
        
        @php
            $qrData = $newsale_detail[0]->fbr_invoice_no;
            if (($company->system_type ?? '') === 'KPRA') {
                $qrData = \App\Services\KpraRimsClient::verificationUrl($company->pos_id, $newsale_detail[0]->invoice_no);
            }
        @endphp
        <div class="qr-row">
        <img id='barcode'
            src="https://api.qrserver.com/v1/create-qr-code/?data={{ urlencode($qrData) }}&amp;size=100x100" 
            alt="QR" 
            title="{{ ($company->system_type ?? '') === 'KPRA' ? 'KPRA Invoice' : 'FBR Invoice' }}" 
            width="100" 
            height="100" />
        @if($company->system_type == "POS")
                <img class="auth-logo" src="{{Asset('root\upload\logo\fbrlogo.jpg')}}" style="height: 100;">
        @endif
        @if($company->system_type == "PRA")
                <img class="auth-logo" src="{{Asset('root\upload\logo\pra.png')}}" style="height: 100;">
        @endif
        </div>
        
    </div>
    @else
        
    @endif
    {{-- <div> --}}
     {{-- @if($newsale_detail[0]->fbr_invoice_no)
        <h4>FBR Invoice No: {{ $newsale_detail[0]->fbr_invoice_no }}</h4>
        {{ QRCode::text($newsale_detail[0]->fbr_invoice_no)->svg() }}
        <img src="{{Asset('root\upload\logo\fbrlogo.jpg')}}" style="height: 130; margin-left: 50px;">
    @endif --}}
    
        {{-- <h4>FBR Invoice No: 45567800988989</h4>
        {{ QRCode::text(45567800988989)->svg() }}
        <img src="{{Asset('root\upload\logo\fbrlogo.jpg')}}" style="height: 130; margin-left: 50px;"> --}}
   
    {{-- </div> --}}
    <aside>
        <h1><span data-prefix>THANK YOU FOR YOUR BUSINESS</span></h1>
        <div data-prefix class="dev-footer">
            <p>Digital Invoicing POS Software</p>
            <p><b>Bang.pk</b> | +92 321 4197290</p>
        </div>
    </aside>
</body>

</html>
