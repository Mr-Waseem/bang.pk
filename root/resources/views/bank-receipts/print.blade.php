﻿<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bank Receipt Voucher</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.4;
            color: #000;
            background: #fff;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            padding: 25px;
            border: 1px solid #ddd;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #333;
        }

        .voucher-title {
            font-size: 22px;
            font-weight: bold;
            text-decoration: underline;
            margin: 15px 0;
            text-align: center;
            color: #333;
        }

        .voucher-info {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin: 15px 0;
            padding: 12px;
            background: #f9f9f9;
            border-radius: 4px;
        }

        .party-info {
            font-size: 14px;
            font-weight: bold;
            flex: 1;
            color: #333;
        }

        .voucher-details {
            text-align: right;
            flex-shrink: 0;
        }

        .voucher-details p {
            margin: 3px 0;
        }

        .voucher-no {
            font-size: 14px;
            font-weight: bold;
            color: #333;
        }

        /* Table styles */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            border: 2px solid #333;
        }

        .table th,
        .table td {
            border: 1px solid #333;
            padding: 8px 10px;
            text-align: left;
            /* font-size: 13px; */
            line-height: 1.3;
            
        }

        .table th {
            background-color: #f5f5f5;
            font-weight: bold;
            border-bottom: 2px solid #333;
            text-align: center;
        }

        .table td:last-child {
            text-align: right;
            font-family: 'Courier New', monospace;
        }

        .total-row {
            font-weight: bold;
            background-color: #e9e9e9;
        }

        .total-row td {
            border-top: 2px solid #333;
        }

        /* Signature section */
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 35px;
            padding-top: 15px;
            border-top: 1px solid #ddd;
        }

        .signature-box {
            text-align: center;
            width: 23%;
        }

        .signature-line {
            border-top: 1px solid #333;
            width: 100%;
            height: 1px;
            margin: 25px 0 8px 0;
        }

        .signature-label {
            font-size: 12px;
            font-weight: bold;
            color: #333;
        }

        /* Powered by section */
        .powered-by {
            margin-top: 20px;
            text-align: center;
            padding-top: 15px;
            border-top: 1px solid #ddd;
            color: #666;
        }

        /* Print styles */
        @media print {
            body {
                padding: 0;
                margin: 0;
                font-size: 12px;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                background: white;
            }
            
            .container {
                max-width: 100%;
                padding: 15px;
                box-shadow: none;
                border: none;
                margin: 0;
            }
            
            .table th,
            .table td {
                padding: 5px 7px;
                font-size: 11px;
            }
            
            .voucher-title {
                font-size: 16px;
            }
            
            .party-info,
            .voucher-no {
                font-size: 12px;
            }

            .voucher-info {
                margin: 8px 0;
                padding: 8px;
            }

            @page {
                margin: 1cm;
                size: A4 portrait;
            }

            .signature-section {
                margin-top: 30px;
            }
            
            .header {
                margin-bottom: 10px;
            }
        }

        /* Screen-only styles */
        @media screen {
            body {
                background: #f0f0f0;
                padding: 30px 20px;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 15px 10px;
            }
            
            .container {
                padding: 15px;
            }
            
            .voucher-info {
                flex-direction: column;
                gap: 8px;
            }
            
            .voucher-details {
                text-align: left;
                width: 100%;
            }
            
            .signature-section {
                flex-wrap: wrap;
                gap: 20px;
            }
            
            .signature-box {
                width: 45%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header Section -->
        <div class="header">
            @include('include.header')
        </div>

        <!-- Voucher Title -->
        <h2 class="voucher-title">Bank Receipt Voucher</h2>

        <!-- Voucher Info -->
        <div class="voucher-info">
            <div class="party-info">
                <strong>ACCOUNT NAME:</strong> {{ $newsale_detail[0]->parties->party_name }}
            </div>
            <div class="voucher-details">
                <p><strong>Voucher Date:</strong> {{ date('d/m/Y', Strtotime($newsale_detail[0]->voucher_date)) }}</p>
                <p class="voucher-no"><strong>VOUCHER NO:</strong> {{ $newsale_detail[0]->voucher_no }}</p>
            </div>
        </div>

        <!-- Table -->
        <table class="table">
            <thead>
                <tr>
                    <th width="8%">Sr.#</th>
                    <th width="30%">Account Name</th>
                    <th width="15%">Cheque No</th>
                    <th width="32%">Description</th>
                    <th width="15%">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sum = 1;
                $amount = 0;
                ?>
                @foreach ($newsale_detail[0]->voucher_details as $details)
                    @if ($details->debit != null)
                        <tr>
                            <td style="text-align: center;">{{ $sum }}</td>
                            <td>{{ $details->newparty->party_name }}</td>
                            <td>{{ $details->cheque_no }}</td>
                            <td>{{ $details->narration }}</td>
                            <td style="font-weight: bolder;">{{ number_format($details->debit, 2) }}</td>
                        </tr>
                        <?php
                        $amount = $amount + $details->debit;
                        $sum = $sum + 1;
                        ?>
                    @endif
                @endforeach
                <tr class="total-row">
                    <td colspan="4" style="text-align: right; padding-right: 20px;"><strong>GRAND TOTAL</strong></td>
                    <td><strong>{{ number_format($amount, 2) }}</strong></td>
                </tr>
            </tbody>
        </table>

        <!-- Signature Section -->
        <div class="signature-section">
            <div class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-label">PREPARED BY</div>
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-label">CHECKED BY</div>
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-label">APPROVED BY</div>
            </div>
            <div class="signature-box">
                <div class="signature-line"></div>
                <div class="signature-label">RECEIVED BY</div>
            </div>
        </div>

        <!-- Powered By Section -->
        <div class="powered-by">
            @include('include.powerdby2')
        </div>
    </div>
</body>

</html>