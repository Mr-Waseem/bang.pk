<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sales Tax Invoice</title>
    <style>
        @page { margin: 12mm 10mm; }
        * { box-sizing: border-box; }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #000;
            margin: 0;
            padding: 0;
        }
        table { width: 100%; border-collapse: collapse; }
        .no-b > tr > td,
        .no-b > tbody > tr > td { border: 0; }
        .company-name { font-size: 16px; font-weight: bold; }
        .company-meta { font-size: 11px; margin-top: 4px; line-height: 1.45; }
        .logo { max-width: 130px; max-height: 70px; }
        .header-rule { border-bottom: 3px solid #2c3e50; margin: 6px 0 10px 0; height: 0; }
        .title {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin: 0 0 14px 0;
            text-transform: uppercase;
        }
        .buyer { font-size: 12px; line-height: 1.55; padding-right: 10px; }
        .buyer .label { font-weight: bold; }
        .meta td {
            border: 1px solid #000;
            padding: 5px 6px;
            font-size: 11px;
        }
        .meta .k { width: 40%; font-weight: bold; background: #eee; }
        .items th, .items td {
            border: 1px solid #000;
            padding: 5px 4px;
            font-size: 9.5px;
            vertical-align: middle;
        }
        .items th { background: #eee; font-weight: bold; text-align: center; }
        .c { text-align: center; }
        .r { text-align: right; }
        .l { text-align: left; }
        .totals { width: 100%; }
        .totals td {
            border: 1px solid #000;
            padding: 5px 6px;
            font-size: 11px;
        }
        .totals .k { width: 50%; font-weight: bold; background: #eee; }
        .sign-tbl td { border: 0; padding: 0; }
        .sign-label {
            border: 2px solid #000;
            background: #eee;
            font-weight: bold;
            font-size: 12px;
            padding: 8px 10px;
            width: 28%;
        }
        .sign-line {
            border-bottom: 2px solid #000;
            height: 28px;
        }
        .thanks-rule { border-bottom: 1px solid #999; margin: 18px 0 8px 0; height: 0; }
        .thanks {
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 0.35em;
            text-transform: uppercase;
        }
        .dev { margin-top: 8px; text-align: right; font-size: 9px; }
        .fbr td { border: 0; vertical-align: middle; padding: 8px 8px 0 0; }
    </style>
</head>
<body>
@php
    $sale = $newsale_detail[0];
    $party = $sale->parties;
    $showDiscount = !empty($showDiscount);
    $headerSystem = $company->system_type ?? session()->get('system_type');
    $buyerLabel = ($headerSystem == 'PRA' || auth()->id() == 637) ? 'Service Recipient' : 'BUYER NAME';
    $logoSrc = !empty($company->company_logo) ? \App\Services\InvoicePdfMailer::fileSrc($company->company_logo) : '';
    $quantity = 0; $ValueExcTax = 0; $STValue = 0; $discountTotal = 0; $amount = 0;
@endphp

<table class="no-b">
    <tr>
        <td style="width: 72%; vertical-align: top;">
            <div class="company-name">{{ session()->get('company_name') ?: ($company->CompanyName ?? '') }}</div>
            <div class="company-meta">
                @php
                    $pdfStrn = trim((string) (session()->get('company_strn') ?? ''));
                    $pdfNtn = trim((string) (session()->get('company_ntn') ?? ''));
                    $pdfAddress = trim((string) (session()->get('company_address') ?: ($company->address ?? '')));
                @endphp
                @if(filled($pdfStrn) || filled($pdfNtn))
                    @if(filled($pdfStrn))STRN: {{ $pdfStrn }}@endif
                    @if(filled($pdfStrn) && filled($pdfNtn)) &nbsp;&nbsp; @endif
                    @if(filled($pdfNtn))NTN: {{ $pdfNtn }}@endif
                    @if(filled($pdfAddress))<br>@endif
                @endif
                @if(filled($pdfAddress)){{ $pdfAddress }}@endif
            </div>
        </td>
        <td style="width: 28%; text-align: right; vertical-align: top;">
            @if($logoSrc)
                <img class="logo" src="{{ $logoSrc }}" alt="Logo">
            @endif
        </td>
    </tr>
</table>
<div class="header-rule"></div>
<div class="title">SALES TAX INVOICE</div>

<table class="no-b" style="margin-bottom: 12px;">
    <tr>
        <td class="buyer" style="width: 62%; vertical-align: top;">
            <div><span class="label">{{ $buyerLabel }}:</span> {{ $party->party_name ?? ($sale->customer_name ?? '') }}</div>
            @php
                $partyAddress = trim((string) ($party->address ?? ''));
                $partyNtn = trim((string) ($party->ntn ?? ''));
                $partyStrn = trim((string) ($party->strn ?? ''));
            @endphp
            @if(filled($partyAddress))
            <div><span class="label">Address:</span> {{ $partyAddress }}</div>
            @endif
            @if((session()->get('company_ntn_show') == 1 && filled($partyNtn)) || (session()->get('company_strn_show') == 1 && filled($partyStrn)))
            <div>
                @if(session()->get('company_ntn_show') == 1 && filled($partyNtn))
                    <span class="label">NTN:</span> {{ $partyNtn }}
                @endif
                @if(session()->get('company_ntn_show') == 1 && filled($partyNtn) && session()->get('company_strn_show') == 1 && filled($partyStrn))
                    &nbsp;&nbsp;&nbsp;&nbsp;
                @endif
                @if(session()->get('company_strn_show') == 1 && filled($partyStrn))
                    <span class="label">STRN:</span> {{ $partyStrn }}
                @endif
            </div>
            @endif
        </td>
        <td style="width: 38%; vertical-align: top;">
            <table class="meta">
                <tr>
                    <td class="k">Invoice #</td>
                    <td>{{ ($company->invoiceno_prefix ?? '') }}{{ $sale->invoice_no }}</td>
                </tr>
                <tr>
                    <td class="k">Date</td>
                    <td>{{ date('d/m/Y', strtotime($sale->date)) }}</td>
                </tr>
                @if($sale->dcn_no)
                <tr>
                    <td class="k">DC No</td>
                    <td>{{ $sale->dcn_no }}</td>
                </tr>
                @endif
                @if($sale->p_order)
                <tr>
                    <td class="k">PO No</td>
                    <td>{{ $sale->p_order }}</td>
                </tr>
                @endif
                @if($sale->remarks)
                <tr>
                    <td class="k">Remarks</td>
                    <td>{{ $sale->remarks }}</td>
                </tr>
                @endif
            </table>
        </td>
    </tr>
</table>

<table class="items">
    <thead>
        <tr>
            <th style="width: 12%;">Qty</th>
            <th style="width: 28%;">Description</th>
            <th style="width: 10%;">Rate</th>
            <th style="width: 14%;">Value Exc. Sales Tax</th>
            @if($showDiscount)
                <th style="width: 12%;">S.T Value</th>
                <th style="width: 12%;">Value Inc.ST</th>
                <th style="width: 10%;">Discount</th>
                <th style="width: 12%;">Total Amount</th>
            @else
                <th style="width: 8%;">S.T%</th>
                <th style="width: 12%;">S.T Value</th>
                <th style="width: 16%;">Value Inc.ST &amp; Rate</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($sale->saletax_details as $details)
            @php
                $uom = $details->products->uom ?? '';
                $quantity += $details->quantity;
                $ValueExcTax += $details->quantity * $details->rate;
                $STValue += $details->taxvalue;
                $discountTotal += $details->discountvalue ?? 0;
                $amount += $details->total;
            @endphp
            <tr>
                <td class="c">{{ $details->quantity }} {{ $uom }}</td>
                <td class="c">{{ $details->products->product_name ?? '' }}</td>
                <td class="c">{{ $details->rate }}</td>
                <td class="c">{{ number_format((int) $details->quantity * $details->rate) }}</td>
                @if($showDiscount)
                    <td class="c">{{ number_format($details->taxvalue, 2) }} || {{ number_format($details->stvalue) }}%</td>
                    <td class="c">{{ number_format($details->price + $details->taxvalue, 2) }}</td>
                    <td class="c">{{ number_format($details->discountvalue, 2) }}</td>
                    <td class="c">{{ number_format($details->total, 2) }}</td>
                @else
                    <td class="c">{{ $details->stvalue }}</td>
                    <td class="c">{{ number_format($details->taxvalue, 2) }}</td>
                    <td class="c">{{ number_format($details->total, 2) }}</td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>

<table class="no-b" style="margin-top: 8px;">
    <tr>
        <td style="width: 52%;"></td>
        <td style="width: 48%; padding: 0;">
            <table class="totals">
                <tr>
                    <td class="k">Total Exc. ST</td>
                    <td class="r">Rs: {{ number_format($ValueExcTax, 2) }}</td>
                </tr>
                <tr>
                    <td class="k">Total Tax</td>
                    <td class="r">Rs: {{ number_format($STValue, 2) }}</td>
                </tr>
                @if($showDiscount)
                <tr>
                    <td class="k">Discount</td>
                    <td class="r">Rs: {{ number_format($discountTotal, 2) }}</td>
                </tr>
                @endif
                <tr>
                    <td class="k">Total Amount</td>
                    <td class="r">Rs: {{ number_format($amount, 2) }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<table class="sign-tbl" style="margin-top: 16px; width: 70%;">
    <tr>
        <td class="sign-label">SIGNATURE:</td>
        <td class="sign-line"></td>
    </tr>
</table>

@if(!empty($sale->fbr_invoice_no))
    @php
        $sysType = $company->system_type ?? '';
        if ($sysType === 'KPRA') {
            $fbrLabel = 'KPRA Transaction ID';
            $badge = null;
            $qrData = \App\Services\KpraRimsClient::verificationUrl($company->pos_id, $sale->invoice_no);
        } elseif ($sysType === 'PRA') {
            $fbrLabel = 'PRA Invoice No';
            $badge = 'root/upload/logo/pra.png';
            $qrData = $sale->fbr_invoice_no;
        } else {
            $fbrLabel = 'FBR Invoice No';
            $badge = 'root/upload/logo/fbrlogo.jpg';
            $qrData = $sale->fbr_invoice_no;
        }
        $qr = !empty($sale->qr_code)
            ? $sale->qr_code
            : 'https://api.qrserver.com/v1/create-qr-code/?data=' . urlencode($qrData) . '&size=80x80';
    @endphp
    <table class="fbr">
        <tr>
            <td style="width: 90px;"><img src="{{ $qr }}" width="80" height="80" alt="QR"></td>
            <td><strong>{{ $fbrLabel }}:</strong><br>{{ $sale->fbr_invoice_no }}</td>
            @if($badge)
            <td style="text-align: right;"><img src="{{ \App\Services\InvoicePdfMailer::fileSrc($badge) }}" style="height: 70px;" alt="Badge"></td>
            @endif
        </tr>
    </table>
@endif

<div class="thanks-rule"></div>
<div class="thanks">THANK YOU FOR YOUR BUSINESS</div>
@if(session()->get('company_footer_show') == 'Yes')
    <div class="dev">DEVELOPED BY IT LIFE | +92 321 4197290 | www.itlifee.net</div>
@endif
</body>
</html>
