<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Invoice - Thermal2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f0f0f0;
            font-family: 'Courier New', Courier, monospace;
            font-size: 13px;
            color: #000;
        }

        #receipt {
            width: 380px;
            background: #fff;
            margin: 20px auto;
            padding: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .header-logo {
            text-align: center;
        }

        .header-company-name {
            margin-top: 4px;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        .header-company-sub {
            margin-top: 4px;
            font-size: 12px;
            font-weight: 700;
        }

        .bold { font-weight: bold; }

        .solid-line {
            border-top: 1px solid #000;
            margin: 8px 0;
        }

        .items-table {
            width: 100%;
            margin-bottom: 5px;
            border-collapse: collapse;
        }

        .items-table th {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 4px 0;
            text-align: left;
            font-weight: 700;
        }

        .items-table td {
            padding: 3px 0;
            vertical-align: top;
        }

        .totals-section {
            width: 100%;
            font-size: 14px;
            margin-top: 8px;
        }

        .totals-section .row-line {
            display: flex;
            justify-content: space-between;
            margin: 3px 0;
        }

        .footer-info {
            font-size: 12px;
            line-height: 1.5;
            margin-top: 18px;
            text-align: center;
        }

        .branding {
            margin-top: 12px;
            font-size: 11px;
            text-align: center;
            line-height: 1.4;
        }

        .bottom-logos {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-top: 16px;
            padding: 0 10px;
        }

        .bottom-logos img {
            height: 55px;
            object-fit: contain;
            filter: grayscale(100%);
        }

        .qr-code {
            height: 55px !important;
            filter: grayscale(100%);
        }

        @media print {
            body { background: none; }
            #receipt { margin: 0; box-shadow: none; width: 100%; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

@php
    $sale = $newsale_detail[0];
    $headerName = $sellerCompany->CompanyName ?? session()->get('company_name');
    $companyNtn = $sellerCompany->ntn ?? session()->get('company_ntn');
    $companyAddress = $sellerCompany->address ?? session()->get('company_address');
    $companyPhone = $sellerCompany->phone ?? session()->get('company_phone');

    $quan = 0;
    $ValueExcTax = 0;
    $STValue = 0;
    $discountTotal = 0;
    $amount = 0;
    $gstPercent = null;

    foreach ($sale->saletax_details as $value) {
        $quan += (float) $value->quantity;
        $ValueExcTax += (float) $value->quantity * (float) $value->rate;
        $STValue += (float) $value->taxvalue;
        $discountTotal += (float) ($value->discount_value ?? 0) + (float) ($value->discount2_value ?? 0);
        $amount += (float) $value->total;

        if ($gstPercent === null && $value->stvalue !== null && $value->stvalue !== '' && is_numeric($value->stvalue)) {
            $gstPercent = (float) $value->stvalue;
        }
    }

    $discountTotal += (float) ($sale->discount_amount ?? 0);
    if ($gstPercent === null) {
        $gstPercent = $ValueExcTax > 0 ? round(($STValue / $ValueExcTax) * 100, 2) : 0;
    }
    $grandTotal = $ValueExcTax + $STValue - $discountTotal;

    $gstLabel = '8';
@endphp

<div id="receipt">
    <div class="header-logo">
        <div class="header-company-name">{{ $headerName }}</div>
        <div class="header-company-sub">NTN # {{ $companyNtn }}</div>
    </div>

    <div class="d-flex justify-content-between mt-3 fw-bold">
        <div>
            Bill # [ {{ $sale->invoice_no }} ]
            @if(!empty($sale->ref_usin))
                <br>C-Bill # [ {{ $sale->ref_usin }} ]
            @endif
        </div>
        <div class="text-end p-0">
            Date [ {{ date('d-M-y', strtotime($sale->date)) }} ]<br>
            Time [ {{ \Carbon\Carbon::parse($sale->created_at)->format('h:i:s A') }} ]
        </div>
    </div>

    <table class="items-table mt-2">
        <thead>
            <tr>
                <th style="width: 8%;">No</th>
                <th style="width: 44%;">Description</th>
                <th style="width: 12%;">Qty</th>
                <th style="width: 16%;">Rate</th>
                <th style="width: 20%; text-align: right;">Amnt</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sale->saletax_details as $value)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $value->products->product_name ?? '' }}</td>
                <td>{{ number_format((float) $value->quantity) }}</td>
                <td>{{ number_format((float) $value->rate) }}</td>
                <td class="text-end">{{ number_format((float) $value->price) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="solid-line"></div>

    <div class="totals-section">
        <div class="row-line">
            <span class="bold">Net Amount</span>
            <span class="bold">{{ number_format($ValueExcTax) }}</span>
        </div>
        <div class="row-line">
            <span class="bold">GST {{ $gstLabel }}%</span>
            <span class="bold">{{ number_format($STValue) }}</span>
        </div>
        @if($discountTotal > 0)
        <div class="row-line">
            <span class="bold">Discount</span>
            <span class="bold">{{ number_format($discountTotal) }}</span>
        </div>
        @endif
        <div class="row-line">
            <span class="bold">Grand Total</span>
            <span class="bold">{{ number_format($grandTotal) }}</span>
        </div>
    </div>

    <div class="footer-info">
        {{ $headerName }}<br>
        {{ $companyAddress }}<br><br>
        We Look Forward To Welcome You Again<br><br>
        PH: {{ $companyPhone }}
        @if(!empty($sale->fbr_invoice_no))
            <br><br>Invoice No {{ $sale->fbr_invoice_no }}
        @endif
    </div>

    <div class="branding">
        Digital Invoicing POS Software<br>
        Bang.pk | +92 321 4197290
    </div>

    @if(!empty($sale->fbr_invoice_no))
    <div class="bottom-logos">
        <img src="{{ asset('upload/pra.jpg') }}" alt="PRA Logo">
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ $sale->fbr_invoice_no }}" class="qr-code" alt="QR Code">
        <img src="{{ asset('upload/fbrpos.jpg') }}" alt="FBR POS Logo">
    </div>
    @endif
</div>
</body>
</html>
