<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opening Stock Voucher</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        p{
            color: #000000;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            color: #000000;
            font-size: 14px;
            line-height: 1.5;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 30px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border: 1px solid #000000;
        }

        .print-controls {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8f9fa;
            border: 1px solid #000000;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .print-btn-group .btn {
            margin-left: 5px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 2px solid #2c3e50;
        }

        .company-name {
            font-size: 30px;
            font-weight: 700;
            color: #000000ff;
        }

        .invoice-title {
            font-size: 18px;
            font-weight: 700;
            background-color: #f8f9fa;
            padding: 10px 20px;
            border-radius: 4px;
            display: inline-block;
            margin: 15px 0;
            border: 1px solid #000000;
        }

        .ntn {
            font-size: 18px;
            color: #000000;
            font-weight: bolder;
        }

        .address{
        font-size: 16px;
        }

        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .stock-info {
            width: 65%;
            padding: 5px;
            border: 1px solid #000000;
            border-radius: 4px;
            background-color: #f8f9fa;
        }

        .stock-title{
        font-size: 20px;
        }
        .stock-details{
            font-size: 16px;
        }

        .voucher-meta {
            width: 32%;
            padding: 5px;
            border: 1px solid #000000;
            border-radius: 4px;
            background-color: #f8f9fa;
        }

        .info-label {
            font-weight: 600;
            color: #555;
            display: inline-block;
            width: 100px;
        }

        .table-container {
            margin-bottom: 10px;
            border: 1px solid #000000;
            border-radius: 4px;
            overflow: hidden;
        }

        .stock-table {
            width: 100%;
            border-collapse: collapse;
        }

        .stock-table th {
            color: #000000;
            text-align: center;
            border: 1px solid #444;
            font-size: 16px;
            background-color: #f8f9fa;
        }

        .stock-table td {
            border: 1px solid #000000;
            text-align: center;
            color: #000000;
        }

        .stock-table td:nth-child(2) {
            text-align: left;
        }

        .stock-table td:nth-child(4),
        .stock-table td:nth-child(5),
        .stock-table td:nth-child(6) {
            text-align: right;
        }

        .stock-table tfoot td {
            font-weight: 600;
            background-color: #f8f9fa;
            border-top: 2px solid #2c3e50;
        }

        .total-section {
            text-align: right;
        }

        .total-row {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 5px;
        }

        .total-label {
            font-weight: 600;
            width: 150px;
            text-align: right;
            padding-right: 15px;
        }

        .total-value {
            width: 180px;
            text-align: right;
            padding: 5px 10px;
            border: 1px solid #000000;
            border-radius: 4px;
        }

        .net-total {
            background-color: #e9f7ef;
            font-weight: 700;
            border: 1px solid #2c3e50 !important;
        }

        .amount-in-words {
            margin-top: 10px;
            padding: 5px;
            border: 1px solid #000000;
            border-radius: 4px;
            text-transform: capitalize;
            font-size: 16px;
        }

        .footer {
            margin-top: 10px;
            text-align: center;
            border-top: 1px solid #000000;
            padding-top: 10px;
            color: #000000;
            font-size: 16px;
        }

        .footer p {
            margin: 5px 0;
            color: #000000;
        }

        .signature-section {
            margin-top: 60px;
            display: flex;
            justify-content: flex-end;
        }

        .signature-box {
            text-align: center;
            border-top: 1px solid #333;
            width: 250px;
            padding-top: 5px;
            color: #000000;
        }

        .empty-row td {
            height: 20px;
        }

        @media print {
            @page {
                size: auto;
                margin: 5mm;
            }
            
            body {
                background-color: white;
                font-size: 12px;
            }
            
            .container {
                max-width: 100%;
                margin: 0;
                padding: 10px;
                box-shadow: none;
                border: none;
            }
            
            .print-controls {
                display: none;
            }
            
            .stock-table {
                page-break-inside: avoid;
            }
        }

        /* Landscape specific styles */
        @media print and (orientation: landscape) {
            body {
                font-size: 14px;
            }
            
            .container {
                padding: 5px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="print-controls">
            <div>
                <button class="btn btn-primary" onclick="window.print()">
                    <i class="fa fa-print"></i> Print Voucher
                </button>
            </div>
        </div>

        <div class="header">
            <div class="company-name">{{ $sellerCompany->CompanyName}}</div>
            <!-- <div class="ntn">NTN/CNIC: 1234567890</div> -->
            <div class="address">{{ $sellerCompany->address}}</div>
            <div class="invoice-title">STOCK VOUCHER</div>
        </div>

        <div class="invoice-details">
            <div class="stock-info">
                <!-- <div class="stock-title"><strong>Stock Details</strong></div>
                <div class="stock-details"><strong>Location:</strong> Main Warehouse</div>
                <div class="stock-details"><strong>Stock Type:</strong> Opening Inventory</div> -->
                <div class="stock-details"><strong>Vourcher No:</strong> {{$purchase_detail->bill_no}}</div>
            </div>
            
            <div class="voucher-meta">
                <div class="stock-details"><strong>Voucher Date:</strong> {{ date('d/m/Y', Strtotime($purchase_detail->date)) }}</div>
                <!-- <div class="stock-details"><strong>Voucher Date:</strong> 01/04/2024</div>
                <div class="stock-details"><strong>Financial Year:</strong> 2024-25</div> -->
            </div>
        </div>

        <div class="table-container">
            <table class="stock-table">
                <thead>
                    <tr>
                        <th style="width: 8%;">Sr.No.</th>
                        <th style="width: 10%;">Code</th>
                        <th style="width: 35%; text-align:left !important;">Product Description</th>
                        <th style="width: 10%;">Unit</th>
                        <th style="width: 10%;">Quantity</th>
                        <th style="width: 10%;">Unit Cost</th>
                        <th style="width: 32%;">Total Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sum = 1;
                    $totalQuantity = 0;
                    $totalValue = 0;
                    ?>
                    
                    @foreach ($purchase_detail->purchase_details as $details)
                    <tr>
                        <td>{{$sum}}</td>
                        <td>{{$details->products->product_code}}</td>
                        <td style="text-align:left;">{{$details->products->product_name}}</td>
                        <td>{{$details->unit->uom}}</td>
                        <td>{{number_format($details->quantity, 2)}}</td>
                        <td>{{number_format($details->unit_cost, 2)}}</td>
                        <td style="text-align:right;">{{number_format($details->unit_cost * $details->quantity, 2)}}</td>
                        <?php 
                        $totalQuantity = $totalQuantity + $details->quantity;
                        $totalValue = $totalValue + ($details->unit_cost * $details->quantity);
                        $sum = $sum + 1;
                        ?>
                    </tr>
                    @endforeach
                    
                    <!-- Empty rows for consistent layout -->
                    @if (isset($purchase_detail->purchase_details))
                        @if (count($purchase_detail->purchase_details) > 5)
                            @for ($i = 0; $i < 10 - count($purchase_detail->purchase_details); $i++)
                                <tr class="empty-row">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @endfor
                        @else
                            @for ($i = 0; $i < 5 - count($purchase_detail->purchase_details); $i++)
                                <tr class="empty-row">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                </tr>
                            @endfor
                        @endif
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4"><strong>Total</strong></td>
                        <td><strong style="float:right;">{{number_format($totalQuantity, ($totalQuantity == (int)$totalQuantity ? 0 : 2))}}</strong></td>
                        <td></td>
                        <td><strong>{{number_format($totalValue, ($totalValue == (int)$totalValue ? 0 : 2))}}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="total-section">
            <div class="total-row">
                <div class="total-label">Total Stock Value:</div>
                <div class="total-value net-total">{{number_format($totalValue, ($totalValue == (int)$totalValue ? 0 : 2))}}</div>
            </div>
        </div>

        <!-- <div class="amount-in-words">
            <strong>Amount in Words:</strong> {{ NumConvert::word($totalValue) }} Only /--
        </div> -->

        <div class="signature-section">
            <div class="signature-box">
                Authorized Signature
            </div>
        </div>

        <!-- <div class="footer">
            <p>This is an electronically generated voucher and is valid without a signature.</p>
        </div> -->
    </div>

    <script>
        function printWithOrientation(orientation) {
            var style = document.createElement('style');
            style.id = 'print-orientation-style';
            
            if (orientation === 'landscape') {
                style.innerHTML = `
                    @page {
                        size: landscape;
                        margin: 5mm;
                    }
                    body {
                        font-size: 11px;
                    }
                    .container {
                        padding: 5px;
                    }
                    .stock-table th, 
                    .stock-table td {
                        padding: 5px 8px;
                    }
                `;
            } else {
                style.innerHTML = `
                    @page {
                        size: portrait;
                        margin: 5mm;
                    }
                `;
            }
            
            var existingStyle = document.getElementById('print-orientation-style');
            if (existingStyle) {
                existingStyle.remove();
            }
            
            document.head.appendChild(style);
            window.print();
        }
    </script>
</body>
</html>