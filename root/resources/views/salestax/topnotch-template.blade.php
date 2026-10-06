<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Tax Invoice</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Times New Roman', Times, serif;
            background: #f0f0f0;
            color: #000;
            font-size: 13px;
            line-height: 1.5;
        }

        .page-wrapper {
            max-width: 900px;
            margin: 20px auto;
            background: #fff;
            padding: 35px 40px 30px 40px;
            box-shadow: 0 0 12px rgba(0,0,0,0.12);
        }

        /* Print button */
        .print-controls { margin-bottom: 12px; display: flex; gap: 8px; align-items: center; }
        .print-controls button {
            background: #333; color: #fff; border: none;
            padding: 6px 14px; cursor: pointer; font-size: 12px;
            border-radius: 3px; display: flex; align-items: center; gap: 6px;
        }
        .print-controls button:hover { background: #555; }
        .print-controls a {
            background: #c0392b; color: #fff; border: none;
            padding: 6px 14px; cursor: pointer; font-size: 12px;
            border-radius: 3px; display: flex; align-items: center; gap: 6px;
            text-decoration: none;
        }
        .print-controls a:hover { background: #a93226; color: #fff; text-decoration: none; }

        /* ── TOP HEADER: Logo | Company Name+Details | (empty right) ── */
        .top-header {
            display: flex;
            align-items: flex-start;
            margin-bottom: 6px;
        }

        .header-logo {
            width: 130px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding-top: 4px;
        }

        .header-logo img {
            max-width: 110px;
            max-height: 90px;
            object-fit: contain;
        }

        .header-logo .logo-text-fallback {
            font-size: 11px;
            font-weight: bold;
            text-align: center;
            border: 2px solid #000;
            padding: 10px 8px;
            letter-spacing: 1px;
        }

        .header-company {
            flex: 1;
            text-align: center;
            padding: 0 10px;
        }

        .header-company .co-name {
            font-size: 17px;
            font-weight: bold;
            letter-spacing: 1px;
            font-family: Arial, sans-serif;
            text-transform: uppercase;
            line-height: 1.2;
            margin-bottom: 5px;
            white-space: nowrap;
            overflow: visible;
        }

        .header-company .co-address {
            font-size: 12px;
            line-height: 1.6;
        }

        /* Right spacer same width as logo for symmetry */
        .header-right {
            width: 130px;
            flex-shrink: 0;
        }

        /* ── INVOICE TITLE (centered, underlined) ── */
        .invoice-title-row {
            text-align: center;
            margin: 14px 0 10px 0;
        }

        .invoice-title-row .inv-title {
            font-size: 17PX;
            font-weight: bold;
            font-family: Arial, sans-serif;
            letter-spacing: 1px;
            /* text-decoration: underline; */
        }

        /* ── INVOICE NO + DATE (right aligned) ── */
        .invoice-meta-row {
            text-align: right;
            font-size: 13px;
            margin-bottom: 16px;
            line-height: 1.9;
        }

        /* ── CUSTOMER SECTION ── */
        .customer-section {
            margin-bottom: 16px;
            font-size: 13px;
            /*line-height: 1.8;*/
        }

        /* ── TABLE ── */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
            font-family: 'Times New Roman', Times, serif;
        }

        .items-table thead tr th {
            border: 1px solid #000;
            padding: 6px 6px;
            text-align: center;
            font-weight: bold;
            font-size: 12px;
            background: #fff;
            line-height: 1.3;
        }

        .items-table tbody tr td {
            border: 1px solid #000;
            padding: 5px 6px;
            font-size: 12px;
            vertical-align: top;
        }

        .items-table tbody tr td.td-center { text-align: center; }
        .items-table tbody tr td.td-right  { text-align: right; }
        .items-table tbody tr td.td-left   { text-align: left; }

        /* ── TOTALS (right-side summary after table) ── */
        .totals-wrapper {
            display: flex;
            justify-content: flex-end;
            margin-top: 0;
        }

        .totals-table {
            border-collapse: collapse;
            width: 55%;
            font-size: 12.5px;
        }

        .totals-table tr td {
            border: 1px solid #000;
            padding: 5px 8px;
        }

        .totals-table tr td.tot-label {
            text-align: right;
            font-weight: normal;
        }

        .totals-table tr td.tot-value {
            text-align: right;
            white-space: nowrap;
            width: 140px;
        }

        .totals-table tr.grand-total td {
            font-weight: bold;
        }

        /* ── FBR SECTION ── */
        .fbr-section {
            display: flex;
            justify-content: flex-end;
            align-items: flex-start;
            margin-top: 20px;
            gap: 14px;
        }

        .fbr-logo-box {
            width: 82px;
            height: 82px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 5px;
        }

        .fbr-logo-box .fbr-text {
            font-size: 20px;
            font-weight: 900;
            font-family: Arial Black, sans-serif;
            letter-spacing: 3px;
            color: #c8a84b;
            line-height: 1;
        }

        .fbr-logo-box .fbr-sub1 {
            font-size: 7px;
            color: #fff;
            font-weight: bold;
            letter-spacing: 1px;
            text-align: center;
            margin-top: 3px;
            line-height: 1.4;
        }

        .fbr-logo-box .fbr-sub2 {
            font-size: 5.5px;
            color: #c8a84b;
            font-weight: bold;
            letter-spacing: 0.5px;
            text-align: center;
            margin-top: 2px;
        }

        .qr-column {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .qr-box {
            width: 82px;
            height: 82px;
            border: 1px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qr-box img { width: 78px; height: 78px; }

        .fbr-invoice-no {
            font-size: 9.5px;
            text-align: center;
            margin-top: 4px;
            font-weight: bold;
            font-family: 'Courier New', monospace;
            line-height: 1.5;
        }

        /* ── FOOTER ── */
        .footer-note {
            margin-top: 50px;
            text-align: center;
            font-size: 15.5px;
            font-style: italic;
            color: #555;
        }

        @media print {
            @page { size: A4; margin: 10mm; }
            body { background: white; }
            .page-wrapper { margin: 0; padding: 12px 15px; box-shadow: none; }
            .print-controls { display: none; }
        }
    </style>
</head>
<body>
<div class="page-wrapper">

    <div class="print-controls">
        <button onclick="window.print()">🖨️ Print Invoice</button>
        <a href="{{ asset('salestax/' . $id . '/pdf') }}">📄 Download PDF</a>
    </div>

    {{-- ══ TOP HEADER: Logo | Center Company Info | Spacer ══ --}}
    <div class="top-header">

        {{-- LEFT: Logo --}}
        <div class="header-logo">
            @if(!empty($sellerCompany->company_logo))
                <img src="{{ asset($sellerCompany->company_logo) }}" alt="Logo">
            @else
                <div class="logo-text-fallback">{{ strtoupper(substr($sellerCompany->CompanyName, 0, 3)) }}</div>
            @endif
        </div>

        {{-- CENTER: Company Name + Details --}}
        <div class="header-company">
            <div class="co-name">{{ $sellerCompany->CompanyName }}</div>
            @if(auth()->id() == 637)
                <div style="font-size:12px; font-weight:bold;">Service Provider</div>
            @endif
            <div class="co-address">
                {{ $sellerCompany->address ?? '' }}<br>
                NTN# {{ $sellerCompany->ntn ?? '' }} &nbsp;&nbsp; STRN# {{ $sellerCompany->strn ?? '' }}
            </div>
        </div>

        {{-- RIGHT SPACER (keeps center truly centered) --}}
        <div class="header-right"></div>

    </div>

    {{-- ══ INVOICE TITLE (centered) ══ --}}
    <div class="invoice-title-row">
        <span class="inv-title">SALES TAX INVOICE</span>
    </div>

    {{-- ══ No. and Date (right aligned) ══ --}}
    <div class="invoice-meta-row">
        No.&nbsp;&nbsp; {{ $sellerCompany->invoiceno_prefix }}{{ $newsale_detail[0]->invoice_no }}<br>
        Date:&nbsp; {{ date('d-M-Y', strtotime($newsale_detail[0]->date)) }}
    </div>

    {{-- ══ CUSTOMER DETAILS ══ --}}
    <div class="customer-section">
        <span style="font-weight:bold;">
            @if(auth()->id() == 637)Service Recipient :@else Customer :@endif
        </span><br>
        <strong>{{ $newsale_detail[0]->parties->party_name }} ,</strong><br>

        @if(!empty($newsale_detail[0]->parties->address))
            @php
                $addr = $newsale_detail[0]->parties->address;
                $parts = array_map('trim', explode(',', $addr));
                if (count($parts) > 3) {
                    $line1 = implode(', ', array_slice($parts, 0, 3));
                    $line2 = implode(', ', array_slice($parts, 3));
                    $addr = $line1 . '<br>' . $line2;
                }
            @endphp
            {!! $addr !!}<br>
        @endif
        @if($newsale_detail[0]->parties->strn)
        STR No. {{ $newsale_detail[0]->parties->strn ?? '' }} , &nbsp; 
        @endif
        NTN No. {{ $newsale_detail[0]->parties->ntn ?? '' }}
        
    </div>

    {{-- ══ ITEMS TABLE (only actual rows, no fillers) ══ --}}
    @php
        $sr            = 1;
        $totalAmount   = 0;
        $totalExcValue = 0;
        $totalTax      = 0;
    @endphp

    <table class="items-table">
        <thead>
            <tr>
                <th style="width:36px;">Sr.<br>No.</th>
                <th style="text-align:left;">Description</th>
                <th>HS Code</th>
                <th>Unit</th>
                <!--<th>set/CTN</th>-->
                
                <th>Total Unit</th>
                <th>Unit price<br>Ex-Work</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($newsale_detail[0]->saletax_details as $detail)
            @php
                $totalAmount   += $detail->total;
                $totalExcValue += $detail->price;
                $totalTax      += $detail->taxvalue;
            @endphp
            <tr>
                <td class="td-center">{{ $sr++ }}</td>
                <td class="td-left">
                    @if($detail->products){{ $detail->products->product_name }}@endif
                </td>
                <td class="td-center">
                    @if($detail->products){{ $detail->products->product_code }}@endif
                </td>
                <td class="td-center">{{ $detail->remarks }}</td>
                <!--<td class="td-center"></td>-->
                <td class="td-center">{{ rtrim(rtrim(number_format($detail->quantity, 2), '0'), '.') }} 
                @if($detail->products->uom == "Numbers, pieces, units")
                Units
                @else 
                {{ $detail->products->uom }}
                @endif
                
                </td>
                <td class="td-right">PKR{{ number_format($detail->rate, 2) }}</td>
                <td class="td-right">PKR{{ number_format($detail->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- ══ TOTALS (right-aligned summary) ══ --}}
    <div class="totals-wrapper">
        <table class="totals-table">
            <tr>
                <td class="tot-label">Subtotal (Excluding GST)</td>
                <td class="tot-value">PKR{{ number_format($totalExcValue, 0) }}</td>
            </tr>
            <tr>
                <td class="tot-label">GST @ 18%</td>
                <td class="tot-value">PKR{{ number_format($totalTax, 0) }}</td>
            </tr>
            <tr>
                <td class="tot-label">Subtotal (Including GST)</td>
                <td class="tot-value">PKR{{ number_format($totalAmount, 0) }}</td>
            </tr>
            @if(!empty($newsale_detail[0]->discount_amount) && $newsale_detail[0]->discount_amount > 0)
            <tr>
                <td class="tot-label">Discount</td>
                <td class="tot-value">
                        (PKR{{ number_format($newsale_detail[0]->discount_amount, 0) }})
                    </td>
            </tr>
            @endif
            <tr class="grand-total">
                <td class="tot-label">Total amount</td>
                <td class="tot-value">PKR{{ number_format(round($totalAmount - ($newsale_detail[0]->discount_amount ?? 0)), 0) }}</td>
            </tr>
        </table>
    </div>

    {{-- ══ FBR DIGITAL INVOICING ══ --}}
    @if(!empty($newsale_detail[0]->fbr_invoice_no))
        <div class="fbr-section">
            <div class="fbr-logo-box">
                <img src="{{ asset('root/upload/logo/fbrlogo.jpg') }}" alt="FBR Logo" style="height: 80px;">
            </div>

            <div class="qr-column">
                <div class="qr-box">
                    @if(!empty($newsale_detail[0]->qr_code))
                        <img src="{{ $newsale_detail[0]->qr_code }}" alt="FBR QR">
                    @else
                        <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ $newsale_detail[0]->fbr_invoice_no }}&amp;size=80x80" alt="FBR QR">
                    @endif
                </div>
                <div class="fbr-invoice-no">
                    FBR Invoice No<br>{{ $newsale_detail[0]->fbr_invoice_no }}
                </div>
            </div>
        </div>
    @endif

    {{-- ══ FOOTER ══ --}}
    <div class="footer-note">
        This is an electronically generated invoice and is valid without a signature.
    </div>

</div>
</body>
</html>
