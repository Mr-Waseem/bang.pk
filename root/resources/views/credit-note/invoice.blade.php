<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Debit Note</title>
    <link rel="stylesheet" href="{{ asset('bootstrap4/bootstrap.min.css') }}">
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
            margin-bottom: 30px;
            border-bottom: 2px solid #2c3e50;
            padding-bottom: 20px;
        }

        .company-name {
            font-size: 24px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
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
            font-size: 14px;
            color: #000000;
        }

        .invoice-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .customer-info {
            width: 65%;
            padding: 15px;
            border: 1px solid #000000;
            border-radius: 4px;
            background-color: #f8f9fa;
        }

        .invoice-meta {
            width: 32%;
            padding: 15px;
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
            margin-bottom: 30px;
            border: 1px solid #000000;
            border-radius: 4px;
            overflow: hidden;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-table th {
            /* background-color: #2c3e50; */
            color: #000000;
            text-align: center;
            padding: 10px;
            border: 1px solid #444;
        }

        .invoice-table td {
            /* padding: 8px 10px; */
            border: 1px solid #000000;
            text-align: center;
            color: #000000;
        }

        .invoice-table td:nth-child(2) {
            text-align: left;
        }

        .invoice-table td:nth-child(4),
        .invoice-table td:nth-child(5),
        .invoice-table td:nth-child(6),
        .invoice-table td:nth-child(7),
        .invoice-table td:nth-child(8),
        .invoice-table td:nth-child(9),
        .invoice-table td:nth-child(10) {
            text-align: right;
        }

        .invoice-table tfoot td {
            font-weight: 600;
            background-color: #f8f9fa;
            border-top: 2px solid #2c3e50;
        }

        .total-section {
            /* margin-top: 20px; */
            text-align: right;
        }

        .total-row {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 10px;
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
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #000000;
            border-radius: 4px;
            background-color: #f8f9fa;
            font-style: italic;
            text-transform: capitalize;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            border-top: 1px solid #000000;
            padding-top: 20px;
            color: #666;
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

        .qr-section {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            align-items: center;
            border: 1px solid #000000;
            padding: 15px;
            border-radius: 4px;
        }

        .empty-row td {
            height: 20px;
        }

        @media print {
            @page {
                size: auto; /* auto is the initial value */
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
            
            .invoice-table {
                page-break-inside: avoid;
            }
        }

        /* Landscape specific styles */
        @media print and (orientation: landscape) {
            body {
                font-size: 11px;
            }
            
            .container {
                padding: 5px;
            }
            
            .invoice-table th, 
            .invoice-table td {
                padding: 5px 8px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="print-controls">
            <div>
                <button class="btn btn-primary" onclick="window.print()">
                    <i class="fa fa-print"></i> Print Debit Note
                </button>
            </div>
            <!-- <div class="print-btn-group">
                <button class="btn btn-outline-secondary" onclick="printWithOrientation('portrait')">
                    <i class="fa fa-file-text"></i> Portrait
                </button>
                <button class="btn btn-outline-secondary" onclick="printWithOrientation('landscape')">
                    <i class="fa fa-file-text"></i> Landscape
                </button>
            </div> -->
        </div>

        <div class="header">
            <div class="company-name">{{ session()->get('company_name') }}</div>
            <div class="ntn">NTN #: {{ session()->get('company_ntn') }}</div>
            <div class="invoice-title">DEBIT NOTE</div>
        </div>

        <div class="invoice-details">
            <div class="customer-info">
                <div><strong>Invoice to:</strong> {{ $newsale_detail[0]->parties->party_name }}</div>
                <div><strong>Address:</strong> {{ $newsale_detail[0]->parties->address }}</div>
                <div><strong>NTN:</strong> {{ $newsale_detail[0]->parties->ntn }}</div>
            </div>
            
            <div class="invoice-meta">
                <div><strong>Invoice No.:</strong> {{ $newsale_detail[0]->invoice_no }}</div>
                <div><strong>Invoice Date:</strong> {{ date('d/m/Y', Strtotime($newsale_detail[0]->date)) }}</div>
                <div><strong>FBR Invoice No:</strong> {{ $newsale_detail[0]->ref_usin }}</div>
                <div><strong>P.O. No.:</strong> {{ $newsale_detail[0]->p_order }}</div>
                <div><strong>DC No.:</strong> {{ $newsale_detail[0]->dcn_no }}</div>
                
            </div>
        </div>

        <div class="table-container">
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th rowspan="2">Sr.No.</th>
                        <th rowspan="2">Description</th>
                        <th rowspan="2">Unit</th>
                        <th rowspan="2">Qty.</th>
                        <th rowspan="2">Unit Price</th>
                        <th rowspan="2">Amount Excl. Tax</th>
                        <th colspan="2">SALES TAX</th>
                        <th rowspan="2">F.TAX</th>
                        <th rowspan="2">Total Inclusive Tax</th>
                    </tr>
                    <tr>
                        <th>Rate%</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sum = 1;
                    $quantity = 0;
                    $rate = 0;
                    $ValueExcTax = 0;
                    $STValue = 0;
                    $ExtraSTValue = 0;
                    $amount = 0;
                    ?>
                    @foreach ($newsale_detail[0]->saletax_details as $details)
                        <tr>
                            <td>{{ $sum }}</td>
                            <td>
                                @if ($details->products)
                                {{ $details->products->product_code }}<br/>
                                    {{ $details->products->product_name }}
                                @endif
                            </td>
                            <td>{{ $details->fbr_uom_desc }}</td>
                            <td>{{ number_format($details->quantity, 2) }}</td>
                            <td>{{ number_format($details->rate, 2) }}</td>
                            <td>{{ number_format($details->quantity * $details->rate) }}</td>
                            <td>{{ number_format((int) $details->stvalue) }}</td>
                            <td>{{ number_format($details->taxvalue) }}</td>
                            <td>{{ number_format($details->extraTaxValue) }}</td>
                            <td>{{ number_format($details->total) }}</td>
                        </tr>
                        <?php
                        $quantity = $quantity + $details->quantity;
                        $rate = $rate + $details->rate;
                        $ValueExcTax = $ValueExcTax + $details->quantity * $details->rate;
                        $STValue = $STValue + $details->taxvalue;
                        $ExtraSTValue = $ExtraSTValue + $details->extraTaxValue;
                        $amount = $amount + $details->total;
                        $sum = $sum + 1;
                        ?>
                    @endforeach
                    
                    @if (isset($newsale_detail[0]->saletax_details))
                        @if (count($newsale_detail[0]->saletax_details) > 5)
                            @for ($i = 0; $i < 10 - count($newsale_detail[0]->saletax_details); $i++)
                                <tr class="empty-row">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
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
                            @for ($i = 0; $i < 5 - count($newsale_detail[0]->saletax_details); $i++)
                                <tr class="empty-row">
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
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
                        <td colspan="3"><strong>Total</strong></td>
                        <td><strong>{{ number_format($quantity, 2) }}</strong></td>
                        <td></td>
                        <td><strong>{{ number_format($ValueExcTax) }}</strong></td>
                        <td></td>
                        <td><strong>{{ number_format($STValue) }}</strong></td>
                        <td><strong>{{ number_format($ExtraSTValue) }}</strong></td>
                        <td><strong>{{ number_format($amount) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="total-section">
            <div class="total-row">
                <div class="total-label">Net Invoice Value:</div>
                <div class="total-value net-total">{{ number_format($amount) }}</div>
            </div>
        </div>
        <div class="total-section">
            <div class="total-row">
                <div class="total-label">Advance Income Tax:</div>
                <div class="total-value net-total">{{ number_format($newsale_detail[0]->total_income_tax, 2) }}</div>
            </div>
        </div>
        <div class="total-section">
            <div class="total-row">
                <div class="total-label">Total Amount:</div>
                <div class="total-value net-total">{{ number_format($amount + $newsale_detail[0]->total_income_tax) }}</div>
            </div>
        </div>

        <div class="amount-in-words">
            <strong>Amount in Words:</strong> {{ NumConvert::word($amount) }}
        </div>

        @if($newsale_detail[0]->fbr_invoice_no != null)
            <div class="qr-section">
                <div>
                    <p><strong>FBR Invoice No:</strong> {{ $newsale_detail[0]->fbr_invoice_no }}</p>
                    <img id='barcode' 
                         src="https://api.qrserver.com/v1/create-qr-code/?data={{ $newsale_detail[0]->fbr_invoice_no }}&amp;size=100x100" 
                         alt="FBR Invoice QR Code" 
                         width="100" 
                         height="100" />
                </div>
                <div>
                    <img src="{{ asset('root/upload/logo/fbrlogo.jpg') }}" style="height: 80px;">
                </div>
            </div>
        @endif

        <div class="signature-section">
            <div class="signature-box">
                Authorized Signature
            </div>
        </div>

        <div class="footer">
            <p><strong>{{ session()->get('company_address') }}</strong></p>
            <p>Phone: {{ session()->get('company_phone') }}</p>
            <p>This is a system generated invoice - no signature required</p>
        </div>
    </div>

    @if($company_detail[0]->white_label == 0)
        @include('include.powerdby2')
    @endif

    <script src="{{ asset('bootstrap4/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap4/popper.min.js') }}"></script>
    <script src="{{ asset('bootstrap4/bootstrap.min.js') }}"></script>
    
    <!-- <script>
        function printWithOrientation(orientation) {
            // Create a style element for print-specific CSS
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
                    .invoice-table th, 
                    .invoice-table td {
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
            
            // Remove existing orientation style if it exists
            var existingStyle = document.getElementById('print-orientation-style');
            if (existingStyle) {
                existingStyle.remove();
            }
            
            // Add the new style to the head
            document.head.appendChild(style);
            
            // Trigger print
            window.print();
        }
    </script> -->
</body>

</html>