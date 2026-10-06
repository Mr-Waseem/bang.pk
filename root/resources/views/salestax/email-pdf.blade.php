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
        .header-line { border-bottom: 2px solid #2c3e50; padding-bottom: 8px; margin-bottom: 8px; }
        .title-box {
            border: 1px solid #000;
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            padding: 6px 10px;
            background: #f8f9fa;
        }
        .box { border: 1px solid #000; background: #f8f9fa; padding: 6px 8px; }
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
        .tot-label { text-align: right; padding-right: 8px; font-weight: bold; font-size: 10.5px; border: 0; width: 58%; }
        .tot-value {
            border: 1px solid #000;
            background: #e9f7ef;
            text-align: right;
            padding: 4px 8px;
            font-weight: bold;
            font-size: 10.5px;
            width: 42%;
        }
        .words {
            border: 1px solid #000;
            padding: 6px 8px;
            margin-top: 8px;
            font-size: 11px;
            text-transform: capitalize;
        }
        .note { margin-top: 12px; text-align: center; font-size: 10px; border-top: 1px solid #000; padding-top: 8px; }
        .empty-row td { height: 14px; }
    </style>
</head>
<body>
@php
    $sale = $newsale_detail[0];
    $party = $sale->parties;
    $logoSrc = !empty($sellerCompany->company_logo) ? \App\Services\InvoicePdfMailer::fileSrc($sellerCompany->company_logo) : '';
    $buyerLabel = auth()->id() == 637 ? 'Service Recipient' : 'Buyer/Customer';
    $showUnit = !empty($sellerCompany->show_unit);
    $showFbrQty = !empty($sellerCompany->show_fbr_qty);
    $showRetail = in_array($sale->scenario_id, [14, 28]);
    $sum = 1;
    $quantity = 0;
    $fbrqty = 0;
    $ValueExcTax = 0;
    $STValue = 0;
    $ExtraSTValue = 0;
    $totalRowDiscount = 0;
    $amount = 0;
    $colCount = 10 + ($showUnit ? 1 : 0) + ($showFbrQty ? 1 : 0) + ($showRetail ? 1 : 0);
@endphp

@if(($sellerCompany->invoice_header ?? 1) == 1)
<table class="no-border header-line">
    <tr>
        <td style="width: 72%; vertical-align: top;">
            <div class="company-name">
                @if(auth()->id() == 637) Service Provider: @endif
                {{ $sellerCompany->CompanyName }}
            </div>
            <div class="company-meta">
                <strong>NTN:</strong> {{ $sellerCompany->ntn }}
                @if(!empty($sellerCompany->strn)) &nbsp;&nbsp; <strong>STRN:</strong> {{ $sellerCompany->strn }} @endif
                <br>{{ $sellerCompany->address }}
                @if(!empty($sellerCompany->phone))<br>Tel: {{ $sellerCompany->phone }}@endif
                @if(!empty($sellerCompany->custom_heading))<br>{{ $sellerCompany->custom_heading }}@endif
            </div>
        </td>
        <td style="width: 28%; text-align: right; vertical-align: top;">
            @if($logoSrc)
                <img class="logo" src="{{ $logoSrc }}" alt="Logo">
            @endif
        </td>
    </tr>
</table>
@else
    <div style="height: 90px;"></div>
    <div style="text-align: right; font-weight: bold;">NTN: {{ $sellerCompany->ntn }}</div>
@endif

<table class="no-border" style="margin: 8px 0 10px 0;">
    <tr>
        <td style="width: 28%;"></td>
        <td class="title-box" style="width: 44%;">SALES TAX INVOICE</td>
        <td style="width: 28%;"></td>
    </tr>
</table>

@if(!empty($sellerCompany->invoice_qrcode) && !empty($sale->fbr_invoice_no))
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
                <div class="buyer-title">{{ $buyerLabel }}: {{ $party->party_name ?? ($sale->customer_name ?? '') }}
                    @if($sale->customer_name) || Name: {{ $sale->customer_name }} @endif
                </div>
                <div class="buyer-info"><strong>Address:</strong> {{ $party->address ?? '' }}</div>
                <div class="buyer-info">
                    <strong>NTN:</strong> {{ $party->ntn ?? '' }}
                    @if($sale->customer_cnic) || CNIC: {{ $sale->customer_cnic }} @endif
                    @if(!empty($party->strn)) &nbsp;&nbsp; <strong>STRN:</strong> {{ $party->strn }} @endif
                </div>
            </div>
        </td>
        <td style="width: 36%; vertical-align: top;">
            <div class="box">
                <div class="buyer-info"><strong>Invoice No.:</strong> {{ ($sellerCompany->invoiceno_prefix ?? '') . $sale->invoice_no }}</div>
                <div class="buyer-info"><strong>Invoice Date:</strong> {{ date('d/m/Y', strtotime($sale->date)) }}</div>
                @if($sale->p_order)
                    <div class="buyer-info"><strong>P.O. No:</strong> {{ $sale->p_order }}</div>
                @endif
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
            <th rowspan="2" style="width: 5%;">Sr.No.</th>
            <th rowspan="2" style="width: 10%;">HS.Code</th>
            <th rowspan="2" style="width: 22%;">Product Description</th>
            @if($showUnit)
                <th rowspan="2" style="width: 7%;">Unit</th>
            @endif
            @if($showFbrQty)
                <th rowspan="2" style="width: 7%;">Qty<br><small>As Per Po</small></th>
                <th rowspan="2" style="width: 7%;">Qty.</th>
            @else
                <th rowspan="2" style="width: 8%;">Qty.</th>
            @endif
            @if($showRetail)
                <th rowspan="2">Price</th>
            @endif
            <th rowspan="2" style="width: 8%;">{{ $showRetail ? 'Retail Price' : 'Rate' }}</th>
            <th rowspan="2" style="width: 10%;">Exc Value</th>
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
                $quantity += $details->quantity;
                $ValueExcTax += $details->price;
                $STValue += $details->taxvalue;
                $ExtraSTValue += $details->extraTaxValue;
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
                $amount += $details->total;
                if ($showFbrQty && $details->fbr_qty) {
                    $fbrqty += $details->fbr_qty;
                }
            @endphp
            <tr>
                <td class="c">{{ $sum++ }}</td>
                <td class="c">{{ $details->products->product_code ?? '' }}</td>
                <td class="l">
                    @if(($details->products->product_name ?? '') != '.')
                        {{ $details->products->product_name ?? '' }}
                    @endif
                    @if(($sellerCompany->id ?? 0) != 99 && !empty($details->remarks))
                        <br>{{ $details->remarks }}
                    @endif
                </td>
                @if($showUnit)
                    <td class="c">{{ $details->fbr_uom_desc }}</td>
                @endif
                @if($showFbrQty)
                    <td class="c">{{ rtrim(rtrim(number_format($details->quantity, 4), '0'), '.') }}</td>
                    <td class="c">{{ $details->fbr_qty ? rtrim(rtrim(number_format($details->fbr_qty, 4), '0'), '.') : '' }}</td>
                @else
                    <td class="c">{{ rtrim(rtrim(number_format($details->quantity, 4), '0'), '.') }}</td>
                @endif
                @if($showRetail)
                    <td class="r">{{ $details->quantity > 0 ? number_format($details->price / $details->quantity, 2) : '-' }}</td>
                @endif
                <td class="r">{{ rtrim(rtrim(number_format($details->rate, 4), '0'), '.') }}</td>
                <td class="r">{{ number_format($details->price, 2) }}</td>
                <td class="c">{{ number_format($details->stvalue, 2) }}</td>
                <td class="r">{{ number_format($details->taxvalue, 2) }}</td>
                <td class="r">{{ number_format($details->extraTaxValue, 2) }}</td>
                <td class="r">{{ number_format($details->total, ($details->total == (int) $details->total ? 0 : 2)) }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3" class="l"><strong>Total</strong></td>
            @if($showUnit)<td></td>@endif
            <td class="c"><strong>{{ number_format($quantity, ($quantity == (int) $quantity ? 0 : 2)) }}</strong></td>
            @if($showFbrQty)
                <td class="c"><strong>{{ number_format($fbrqty, ($fbrqty == (int) $fbrqty ? 0 : 2)) }}</strong></td>
            @endif
            @if($showRetail)<td></td>@endif
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
        <td style="width: 48%; vertical-align: top; padding-right: 10px;">
            @if(!empty($sale->remarks))
                <strong>Remarks:</strong> {{ $sale->remarks }}
            @endif
        </td>
        <td style="width: 52%; padding: 0;">
            <table>
                <tr>
                    <td class="tot-label">Total Exc SaleTax:</td>
                    <td class="tot-value">{{ number_format($ValueExcTax) }}</td>
                </tr>
                <tr>
                    <td class="tot-label">SalesTax:</td>
                    <td class="tot-value">{{ $STValue == 0 ? 'Exempt or Zero Rated' : number_format($STValue) }}</td>
                </tr>
                @if($ExtraSTValue > 0)
                <tr>
                    <td class="tot-label">Fur.SalesTax:</td>
                    <td class="tot-value">{{ number_format($ExtraSTValue) }}</td>
                </tr>
                @endif
                @if(($sale->total_income_tax ?? 0) > 0)
                <tr>
                    <td class="tot-label">Advance Income Tax 236G/236H:</td>
                    <td class="tot-value">{{ number_format($sale->total_income_tax, 0) }}</td>
                </tr>
                @endif
                @if($totalDiscount > 0)
                <tr>
                    <td class="tot-label">Discount:</td>
                    <td class="tot-value">{{ number_format($totalDiscount, 0) }}</td>
                </tr>
                @endif
                <tr>
                    <td class="tot-label">Total Amount:</td>
                    <td class="tot-value">{{ number_format($finalAmount, 0) }}</td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<div class="words">
    <strong>Amount in Words:</strong> {{ NumConvert::word($finalAmount) }} Only /--
</div>

@if(($sellerCompany->category ?? '') == 'Importer')
    @php $recipientLabel = auth()->id() == 637 ? 'Service Recipient' : 'Buyer'; @endphp
    <div class="words">
        <strong>UNDERTAKING</strong><br>
        We hereby certify that the goods supplied to above mention {{ $recipientLabel }} were imported by us on which income tax has been been paid by us U/S 148
        of the Income Tax Ordinance 2001 at import stage. We further confirm that the goods supplied are in the same condition as these were
        imported by us. We are therefore not liable to income tax deduction U/S 153 of the Income Tax Ordinance 2001.
    </div>
@endif

@if(empty($sellerCompany->invoice_qrcode) && !empty($sale->fbr_invoice_no))
    @php
        $qr = !empty($sale->qr_code)
            ? $sale->qr_code
            : 'https://api.qrserver.com/v1/create-qr-code/?data=' . urlencode($sale->fbr_invoice_no) . '&size=80x80';
    @endphp
    <table class="no-border" style="margin-top: 10px;">
        <tr>
            <td style="width: 90px;"><img src="{{ $qr }}" width="80" height="80" alt="QR"></td>
            <td style="vertical-align: middle;"><strong>FBR Invoice No:</strong><br>{{ $sale->fbr_invoice_no }}</td>
            <td style="text-align: right;"><img src="{{ \App\Services\InvoicePdfMailer::fileSrc('root/upload/logo/fbrlogo.jpg') }}" style="height: 70px;" alt="FBR"></td>
        </tr>
    </table>
@endif

<div class="note">This is an electronically generated invoice and is valid without a signature.</div>
</body>
</html>
