<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sales Tax Invoice</title>
    <style>
        @page { margin: 10mm 8mm; }
        * { box-sizing: border-box; }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #000;
            margin: 0;
            padding: 0;
        }
        table { width: 100%; border-collapse: collapse; }
        .no-border td { border: 0; }
        .company-name { font-size: 16px; font-weight: bold; letter-spacing: 0.3px; }
        .company-meta { font-size: 10.5px; margin-top: 3px; line-height: 1.4; }
        .logo { max-width: 120px; max-height: 70px; }
        .title-wrap { text-align: center; margin: 8px 0 6px 0; }
        .title-table { margin: 0 auto; border-collapse: separate; border-spacing: 0; }
        .title-table td {
            border: 1px solid #000 !important;
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            padding: 7px 18px;
            background: #f8f9fa;
        }
        .header-rule { border-bottom: 3px solid #2c3e50; margin: 6px 0 10px 0; height: 0; }
        .box { border: 1px solid #000; background: #f8f9fa; padding: 6px 8px; }
        .totals-table { width: 100%; border-collapse: separate; border-spacing: 0 5px; }
        .totals-table td { border: 0; vertical-align: middle; }
        .tot-box {
            border: 1px solid #000;
            text-align: right;
            padding: 5px 8px;
            font-weight: bold;
            font-size: 10.5px;
        }
        .buyer-title { font-size: 12px; font-weight: bold; margin-bottom: 3px; }
        .buyer-info { font-size: 10.5px; line-height: 1.45; }
        .items th, .items td {
            border: 1px solid #000;
            padding: 3px 3px;
            font-size: 8.5px;
            vertical-align: middle;
        }
        .items th { background: #f2f2f2; font-weight: bold; text-align: center; }
        .items tfoot td { font-weight: bold; background: #f8f9fa; }
        .c { text-align: center; }
        .r { text-align: right; }
        .l { text-align: left; }
        .tot-label { text-align: right; padding-right: 8px; font-weight: bold; font-size: 10.5px; }
        .words {
            border: 1px solid #000;
            padding: 6px 8px;
            margin-top: 8px;
            font-size: 11px;
            text-transform: capitalize;
        }
        .note { margin-top: 12px; text-align: center; font-size: 10px; border-top: 1px solid #000; padding-top: 8px; }
    </style>
</head>
<body>
@php
    $sale = $newsale_detail[0];
    $party = $sale->parties;
    $logoSrc = !empty($sellerCompany->company_logo) ? \App\Services\InvoicePdfMailer::fileSrc($sellerCompany->company_logo) : '';
    $buyerLabel = auth()->id() == 637 ? 'Service Recipient' : 'Buyer';
    $quantity = 0;
    $ValueExcTax = 0;
    $STValue = 0;
    $ExtraSTValue = 0;
    $totalRowDiscount = 0;
    $amount = 0;
@endphp

<table class="no-border" style="margin-bottom: 4px;">
    <tr>
        <td style="width: 72%; vertical-align: top;">
            <div class="company-name">
                @if(auth()->id() == 637) Service Provider: @endif
                {{ $sellerCompany->CompanyName }}
            </div>
            <div class="company-meta">
                <strong>NTN/CNIC:</strong> {{ $sellerCompany->ntn }}
                <br>{{ $sellerCompany->address }}
            </div>
        </td>
        <td style="width: 28%; text-align: right; vertical-align: top;">
            @if($logoSrc)
                <img class="logo" src="{{ $logoSrc }}" alt="Logo">
            @endif
        </td>
    </tr>
</table>

<div class="title-wrap">
    <table class="title-table" align="center" cellpadding="0" cellspacing="0">
        <tr>
            <td>SALES TAX INVOICE</td>
        </tr>
    </table>
</div>
<div class="header-rule"></div>

@if(!empty($sale->fbr_invoice_no))
    @php
        $qr = !empty($sale->qr_code)
            ? $sale->qr_code
            : 'https://api.qrserver.com/v1/create-qr-code/?data=' . urlencode($sale->fbr_invoice_no) . '&size=80x80';
    @endphp
    <table class="no-border" style="margin-bottom: 8px;">
        <tr>
            <td style="width: 90px;"><img src="{{ $qr }}" width="80" height="80" alt="QR"></td>
            <td style="vertical-align: middle;"><strong>FBR Invoice No:</strong> {{ $sale->fbr_invoice_no }}</td>
            <td style="text-align: right;"><img src="{{ \App\Services\InvoicePdfMailer::fileSrc('root/upload/logo/fbrlogo.jpg') }}" style="height: 70px;" alt="FBR"></td>
        </tr>
    </table>
@endif

<table class="no-border" style="margin-bottom: 8px;">
    <tr>
        <td style="width: 64%; padding-right: 8px; vertical-align: top;">
            <div class="box">
                <div class="buyer-title">{{ $buyerLabel }}: {{ $party->party_name ?? ($sale->customer_name ?? '') }}</div>
                <div class="buyer-info"><strong>Address:</strong> {{ $party->address ?? '' }}</div>
                <div class="buyer-info"><strong>NTN:</strong> {{ $party->ntn ?? '' }}</div>
                @if(!empty($sale->remarks))
                    <div class="buyer-info"><strong>Remarks:</strong> {{ $sale->remarks }}</div>
                @endif
            </div>
        </td>
        <td style="width: 36%; vertical-align: top;">
            <div class="box">
                <div class="buyer-info"><strong>Invoice No.:</strong> {{ $sale->invoice_no }}</div>
                <div class="buyer-info"><strong>Invoice Date:</strong> {{ date('d/m/Y', strtotime($sale->date)) }}</div>
                @if($sale->dcn_no)
                    <div class="buyer-info"><strong>DC No:</strong> {{ $sale->dcn_no }}</div>
                @endif
            </div>
        </td>
    </tr>
</table>

<table class="items">
    <thead>
        <tr>
            <th rowspan="2" style="width: 8%;">PO</th>
            <th rowspan="2" style="width: 11%;">HS.Code</th>
            <th rowspan="2" style="width: 24%;">Product Description</th>
            <th rowspan="2" style="width: 7%;">Unit</th>
            <th rowspan="2" style="width: 8%;">Qty.</th>
            <th rowspan="2" style="width: 8%;">Rate</th>
            <th rowspan="2" style="width: 9%;">Exc Value</th>
            <th colspan="2">Sales Tax</th>
            <th rowspan="2" style="width: 8%;">F.Tax</th>
            <th rowspan="2" style="width: 10%;">Inclusive<br>Value</th>
        </tr>
        <tr>
            <th style="width: 6%;">Rate%</th>
            <th style="width: 9%;">Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach($sale->saletax_details as $details)
            @php
                $grandvalue = $details->total + $details->discount_value + $details->discount2_value;
                $quantity += $details->quantity;
                $ValueExcTax += $details->quantity * $details->rate;
                $STValue += $details->taxvalue;
                $ExtraSTValue += $details->extraTaxValue;
                $amount += $grandvalue;
                $rowBaseValue = floatval($details->price) + floatval($details->taxvalue) + floatval($details->extraTaxValue);
                $dv = floatval($details->discount_value) + floatval($details->discount2_value);
                if ($dv > 0 && $dv <= $rowBaseValue) {
                    $rowDisc = $dv;
                } elseif ((floatval($details->discount) + floatval($details->discount2)) > 0) {
                    $fb = floatval($details->discount) + floatval($details->discount2);
                    $rowDisc = ($fb <= $rowBaseValue) ? $fb : 0;
                } else {
                    $rowDisc = $rowBaseValue - floatval($details->total);
                }
                $totalRowDiscount += max($rowDisc, 0);
            @endphp
            <tr>
                <td class="c">{{ $sale->p_order }}</td>
                <td class="c">{{ $details->products->product_code ?? '' }}</td>
                <td class="l">
                    {{ $details->products->product_name ?? '' }}
                    @if(!empty($details->remarks))<br>{{ $details->remarks }}@endif
                </td>
                <td class="c">{{ $details->fbr_uom_desc }}</td>
                <td class="c">{{ rtrim(number_format($details->quantity, 4), '0') }}</td>
                <td class="r">{{ rtrim(number_format($details->rate, 4), '0') }}</td>
                <td class="r">{{ number_format($details->price) }}</td>
                <td class="c">{{ number_format($details->stvalue, 2) }}</td>
                <td class="r">{{ number_format($details->taxvalue, 2) }}</td>
                <td class="r">{{ number_format($details->extraTaxValue, 2) }}</td>
                <td class="r">{{ number_format($grandvalue, ($grandvalue == (int) $grandvalue ? 0 : 2)) }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" class="l"><strong>Total</strong></td>
            <td class="c"><strong>{{ number_format($quantity, ($quantity == (int) $quantity ? 0 : 2)) }}</strong></td>
            <td></td>
            <td class="r"><strong>{{ number_format($ValueExcTax) }}</strong></td>
            <td></td>
            <td class="r"><strong>{{ number_format($STValue) }}</strong></td>
            <td class="r"><strong>{{ number_format($ExtraSTValue) }}</strong></td>
            <td class="r"><strong>{{ number_format($amount) }}</strong></td>
        </tr>
    </tfoot>
</table>

@php
    $grandDiscount = floatval($sale->discount_amount ?? 0);
    $totalDiscount = $totalRowDiscount + $grandDiscount;
    $finalAmount = round($ValueExcTax + $STValue + $ExtraSTValue - $totalDiscount + floatval($sale->total_income_tax));
@endphp

<table class="no-border" style="margin-top: 8px;">
    <tr>
        <td style="width: 42%;"></td>
        <td style="width: 58%; padding: 0;">
            <table class="totals-table">
                <tr>
                    <td class="tot-label">Net Invoice Value:</td>
                    <td style="width: 150px;"><div class="tot-box">{{ number_format($amount, 0) }}</div></td>
                </tr>
                @if(($sale->total_income_tax ?? 0) > 0)
                <tr>
                    <td class="tot-label">Advance Income Tax 236G/236H:</td>
                    <td><div class="tot-box">{{ number_format($sale->total_income_tax, 0) }}</div></td>
                </tr>
                @endif
                @if($totalDiscount > 0)
                <tr>
                    <td class="tot-label">Discount:</td>
                    <td><div class="tot-box">{{ number_format($totalDiscount, 0) }}</div></td>
                </tr>
                @endif
                <tr>
                    <td class="tot-label">Total Amount:</td>
                    <td><div class="tot-box">{{ number_format($finalAmount, 0) }}</div></td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<div class="words">
    <strong>Amount in Words:</strong> {{ NumConvert::word($finalAmount) }} Only /--
</div>

<div class="note">This is an electronically generated invoice and is valid without a signature.</div>
</body>
</html>
