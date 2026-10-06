<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Tax Invoice</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f0f0f0;
            color: #000;
            font-size: 12px;
            line-height: 1.45;
        }

        .page-wrapper {
            max-width: 900px;
            margin: 20px auto;
            background: #fff;
            padding: 28px 36px 24px 36px;
            box-shadow: 0 0 12px rgba(0,0,0,0.12);
        }

        .print-controls { margin-bottom: 12px; }
        .print-controls button {
            background: #333; color: #fff; border: none;
            padding: 6px 14px; cursor: pointer; font-size: 12px;
            border-radius: 3px;
        }

        .seller-block { text-align: right; margin-bottom: 18px; }
        .seller-block .seller-name {
            font-size: 28px;
            font-weight: 700;
            line-height: 1.15;
            margin-bottom: 4px;
        }
        .seller-block .seller-address {
            font-size: 12px;
            line-height: 1.4;
            max-width: 420px;
            margin-left: auto;
        }
        .seller-block .seller-ntn { font-size: 12px; margin-top: 2px; }

        .digital-block {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 8px 0 22px 0;
        }
        .digital-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
        }
        .fbr-logo { height: 72px; width: auto; object-fit: contain; }
        .qr-box {
            width: 78px; height: 78px;
            display: flex; align-items: center; justify-content: center;
        }
        .qr-box img { width: 78px; height: 78px; }
        .digital-invoice-no {
            margin-top: 8px;
            font-size: 12px;
            text-align: center;
            letter-spacing: 0.2px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 24px;
            margin-bottom: 18px;
        }
        .buyer-col { flex: 1 1 60%; min-width: 0; }
        .buyer-col .inv-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .buyer-col .buyer-name {
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 2px;
        }
        .buyer-col .buyer-address,
        .buyer-col .buyer-ntn {
            font-size: 12px;
            line-height: 1.45;
        }
        .meta-col {
            flex: 0 0 34%;
            text-align: left;
            font-size: 12px;
            line-height: 1.7;
            padding-top: 2px;
        }
        .meta-col .meta-line { white-space: nowrap; }
        .meta-col .meta-label { display: inline-block; min-width: 88px; }

        .items-table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            font-size: 10px;
            margin-bottom: 8px;
        }
        .items-table thead tr th {
            border: 1px solid #000;
            background: #e8e8e8;
            padding: 3px 2px;
            text-align: center;
            font-weight: 700;
            font-size: 10px;
            vertical-align: middle;
            line-height: 1.2;
            word-wrap: break-word;
        }
        .items-table tbody tr td {
            border: 1px solid #000;
            padding: 3px 2px;
            vertical-align: middle;
            font-size: 10px;
            line-height: 1.2;
            word-wrap: break-word;
            overflow-wrap: anywhere;
        }
        .td-center { text-align: center; }
        .td-right { text-align: right; white-space: nowrap; }
        .td-left { text-align: left; }

        .totals-wrap {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
            margin-bottom: 40px;
        }
        .totals-block { width: 260px; font-size: 12px; }
        .totals-block .tot-row {
            display: flex;
            justify-content: space-between;
            padding: 3px 0;
            line-height: 1.5;
        }
        .totals-block .tot-row .tot-value {
            text-align: right;
            min-width: 110px;
        }
        .totals-block .tot-grand {
            margin-top: 4px;
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            padding: 5px 0;
            font-weight: 700;
            font-size: 13px;
        }

        .footer-note {
            text-align: center;
            font-size: 11px;
            color: #333;
            margin-top: 28px;
        }

        @media print {
            @page { size: A4; margin: 10mm; }
            body { background: white; }
            .page-wrapper {
                margin: 0;
                padding: 8px 10px;
                box-shadow: none;
                max-width: none;
            }
            .print-controls { display: none !important; }
        }
    </style>
</head>
<body>
@if(isset($sales_tax_detail))
    @if(count($sales_tax_detail) > 0)
        @include('print-reports.partials.toolbar', ['printLabel' => 'Print Invoice'])
        @foreach($sales_tax_detail as $value)
            @php
                $newsale_detail = [$value];
                $sale = $newsale_detail[0];
                $party = $sale->parties ?? null;
                $invoiceDate = !empty($sale->date) ? date('d/m/Y', strtotime($sale->date)) : '';
                $fbrNo = $sale->fbr_invoice_no ?? null;
            @endphp
            <div class="page-wrapper">
                <div class="seller-block">
                    <div class="seller-name">{{ $sellerCompany->CompanyName }}</div>
                    <div class="seller-address">{{ $sellerCompany->address ?? '' }}</div>
                    <div class="seller-ntn">NTN : {{ $sellerCompany->ntn ?? '' }}</div>
                </div>

                @if(!empty($fbrNo))
                <div class="digital-block">
                    <div class="digital-row">
                        <img class="fbr-logo" src="{{ asset('root/upload/logo/fbrlogo.jpg') }}" alt="FBR Digital Invoicing System">
                        <div class="qr-box">
                            @if(!empty($sale->qr_code))
                                <img src="{{ $sale->qr_code }}" alt="QR">
                            @else
                                <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ urlencode($fbrNo) }}&amp;size=78x78" alt="QR">
                            @endif
                        </div>
                    </div>
                    <div class="digital-invoice-no">Digital Invoice #: {{ $fbrNo }}</div>
                </div>
                @endif

                <div class="info-row">
                    <div class="buyer-col">
                        <div class="inv-title">Sales Tax Invoice11</div>
                        <div class="buyer-name">{{ $party->party_name ?? '' }}</div>
                        <div class="buyer-address">{{ $party->address ?? '' }}</div>
                        <div class="buyer-ntn">NTN {{ $party->ntn ?? '' }}</div>
                    </div>
                    <div class="meta-col">
                        <div class="meta-line"><span class="meta-label">Date:</span> {{ $invoiceDate }}</div>
                        <div class="meta-line"><span class="meta-label">Due Date:</span> {{ $invoiceDate }}</div>
                        <div class="meta-line"><span class="meta-label">Invoice No:</span> {{ $sale->invoice_no }}</div>
                        <div class="meta-line"><span class="meta-label">Account No:</span> {{ $party->code ?? '' }}</div>
                    </div>
                </div>

                <table class="items-table">
                    <thead>
                        <tr>
                            <th style="width:4%;">SrNo</th>
                            <th style="width:9%;">HSCode</th>
                            <th style="width:22%;">Product Name</th>
                            <th style="width:7%;">Item ID</th>
                            <th style="width:8%;">PO No</th>
                            <th style="width:8%; white-space:nowrap;">UM Unit</th>
                            <th style="width:8%; white-space:nowrap;">UM Qty</th>
                            <th style="width:8%; white-space:nowrap;">UM Rate</th>
                            <th style="width:13%;">Amount</th>
                            <th style="width:13%;">Sales Tax</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sr = 1;
                            $subTotal = 0;
                            $gstTotal = 0;
                        @endphp
                        @foreach ($sale->saletax_details as $details)
                            @php
                                $subTotal += floatval($details->price);
                                $gstTotal += floatval($details->taxvalue);
                                $uom = $details->fbr_uom_desc
                                    ?? (optional($details->unit)->uom_desc ?? optional($details->unit)->uom ?? '');
                            @endphp
                            <tr>
                                <td class="td-center">{{ $sr++ }}</td>
                                <td class="td-center">{{ optional($details->products)->product_code }}</td>
                                <td class="td-left">{{ optional($details->products)->product_name }}</td>
                                <td class="td-center">{{ optional($details->products)->id }}</td>
                                <td class="td-center">{{ $sale->p_order }}</td>
                                <td class="td-center">{{ $uom }}</td>
                                <td class="td-center">{{ rtrim(rtrim(number_format($details->quantity, 4, '.', ''), '0'), '.') }}</td>
                                <td class="td-right">{{ rtrim(rtrim(number_format($details->rate, 4, '.', ''), '0'), '.') }}</td>
                                <td class="td-right">{{ number_format($details->price, 2) }}</td>
                                <td class="td-right">{{ number_format($details->taxvalue, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @php
                    $incomeTax = floatval($sale->total_income_tax ?? 0);
                    $grandTotal = $subTotal + $gstTotal + $incomeTax;
                @endphp

                <div class="totals-wrap">
                    <div class="totals-block">
                        <div class="tot-row">
                            <span class="tot-label">Sub Total:</span>
                            <span class="tot-value">{{ number_format($subTotal, 2) }}</span>
                        </div>
                        <div class="tot-row">
                            <span class="tot-label">GST:</span>
                            <span class="tot-value">{{ number_format($gstTotal, 2) }}</span>
                        </div>
                        <div class="tot-row">
                            <span class="tot-label">Advance I.tax 236H:</span>
                            <span class="tot-value">{{ number_format($incomeTax, 2) }}</span>
                        </div>
                        <div class="tot-row tot-grand">
                            <span class="tot-label">Total:</span>
                            <span class="tot-value">Rs. {{ number_format($grandTotal, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="footer-note">This is a system generated invoice and does not require any signatures.</div>
            </div>
            <p style="page-break-after: always;"></p>
        @endforeach
    @else
        <h1>Record Not Found</h1>
    @endif
@endif
</body>
</html>
