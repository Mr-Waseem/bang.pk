<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Challan - {{ $newsale_detail[0]->shop->name }}</title>
    <style>
        @page {
            /* size: A4; */
            size: auto;
            margin: 10mm;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.5;
        }
        .action-bar {
            width: 85% !important;
            padding: 10px 20px;
            display: flex;
            justify-content: flex-end;
        }
        .print-btn {
            background-color: #f0f0f0;
            color: #1e00c6;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            font-weight: bold;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .print-btn:hover {
            background-color: #f0f0f0;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            border: 1px solid #e0e0e0;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
            border-bottom: 2px solid #1e00c6;
        }
        .company-logo {
            font-size: 24px;
            font-weight: bold;
            color: #1e00c6;
        }
        .document-meta {
            text-align: right;
        }
        .document-title {
            font-size: 22px;
            font-weight: bold;
            color: #1e00c6;
            margin-bottom: 5px;
        }
        .document-number {
            background: #1e00c6;
            color: white;
            padding: 5px 15px;
            border-radius: 4px;
            font-weight: bold;
            display: inline-block;
        }
        .company-info {
            margin-bottom: 25px;
        }
        .company-info p {
            margin: 5px 0;
        }
        .info-grid {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .info-card {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
        }
        .info-card h3 {
            margin-top: 0;
            color: #1e00c6;
            border-bottom: 1px solid #dee2e6;
        }
        .bill-to {
            background: #f0f7ff;
            padding: 15px;
            border-left: 4px solid #1e00c6;
            margin-bottom: 25px;
        }
        .bill-to h3 {
            margin-top: 0;
            color: #1e00c6;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 14px;
        }
        th {
            text-align: left;
            font-weight: 600;
            border: 2px solid black;
        }
        td {
            border: 1px solid black;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .total-row {
            background-color: #e3f2fd !important;
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            font-size: 13px;
        }
        .footer-section {
            border-top: 1px solid #e0e0e0;
            padding-top: 15px;
        }
        .footer-section h4 {
            margin-bottom: 10px;
            color: #1e00c6;
        }
        .signature-line {
            height: 1px;
            background: #333;
            width: 80%;
            margin: 30px 0 5px;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .text-bold {
            font-weight: bold;
        }
        .mb-20 {
            margin-bottom: 20px;
        }
        @media print {
            .action-bar {
                display: none;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="action-bar">
        <div class="action-bar-content">
            <button class="print-btn" onclick="window.print()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2H5zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1z"/>
                    <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2V7zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                </svg>
                Print
            </button>
        </div>
    </div>

    <div class="container">
        <div class="header">
            <div>
                <div class="company-logo">{{ $company->CompanyName }}</div>
                <div class="company-info">
                    <p>{{ $company->address }}</p>
                    <p><span class="text-bold">Phone:</span>{{ $company->phone }}</p>
                    <p><span class="text-bold">Email:</span> {{ session()->get('email') }}</p>
                </div>
            </div>
            <div class="document-meta">
                <div class="document-title">DELIVERY CHALLAN</div>
                <div class="document-number">DC NO: {{ $newsale_detail[0]->invoice_no }}</div>
                <p class="text-bold">Date: {{ date('d/m/Y', Strtotime($newsale_detail[0]->date)) }}</p>
            </div>
        </div>

        <div class="info-grid" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <div class="bill-to" style="flex: 1; padding: 5px; border-left: 3px solid #1e00c6; background-color: #f8f9fa;">
                <h3 style="margin: 5px 0; font-size: 14px; color: #1e00c6;">BILL TO</h3>
                <p style="margin: 3px 0; font-weight: bold; font-size: 13px;">{{ $newsale_detail[0]->parties->party_name }}</p>
                <p style="margin: 3px 0; font-weight: bold; font-size: 13px;">{{ $newsale_detail[0]->parties->address }}</p>
            </div>
            <div class="info-card" style="flex: 1; margin-right: 10px; padding: 5px; border: 1px solid #dee2e6; border-radius: 3px;">
                <h3 style="margin: 5px 0; font-size: 14px; color: #1e00c6; border-bottom: 1px solid #dee2e6; padding-bottom: 3px;">Shipping Information</h3>
                <p style="margin: 3px 0; font-size: 13px;"><span style="font-weight: bold;">Driver:</span> {{ $newsale_detail[0]->driver }}</p>
                <p style="margin: 3px 0; font-size: 13px;"><span style="font-weight: bold;">Vehicle:</span> {{ $newsale_detail[0]->vehicle }}</p>
                <p style="margin: 3px 0; font-size: 13px;"><span style="font-weight: bold;">Freight:</span> {{ $newsale_detail[0]->freight }}</p>
                <p style="margin: 3px 0; font-size: 13px;"><span style="font-weight: bold;">Returnable:</span> {{ $newsale_detail[0]->returnable }}</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>SR#</th>
                    <th>Item Description</th>
                    <th class="text-right">Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $sum = 1;
                    $quantity = 0;
                    $Weight = 0;
                    $TotalWeight = 0;
                ?>
                @foreach ($newsale_detail[0]->sale_details as $details)
                    <tr>
                        <td>{{ $sum }}</td>
                        <td>
                            @if ($details->products != null)
                                <span class="text-bold">{{ $details->products->product_name }}</span> {{ $details->products->uom}}
                            @endif
                        </td>
                        <td class="text-right">{{ number_format($details->quantity, 2) }}</td>
                    </tr>
                    <?php
                        $quantity += (float) $details->quantity;
                        $TotalWeight += (float) $Weight;
                        $sum++;
                    ?>
                @endforeach
                <tr class="total-row">
                    <td colspan="2">TOTAL</td>
                    <td class="text-right text-bold">{{ number_format($quantity, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="footer">
            <div class="footer-section">
                <h4>Prepared By</h4>
                <p>{{ $newsale_detail[0]->billers->name }}</p>
            </div>
            <div class="footer-section text-center">
                <h4>Checked By</h4>
                <div class="signature-line"></div>
            </div>
            <div class="footer-section text-center">
                <h4>Approved By</h4>
                <div class="signature-line"></div>
            </div>
        </div>

        <div class="text-center" style="margin-top: 40px; font-size: 12px; color: black;">
            <p>This is a computer generated document. No signature required.</p>
            <p>Developed BY iT Life. +92 321 4197290</p>
        </div>
    </div>

</body>
</html>