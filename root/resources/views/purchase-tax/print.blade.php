﻿<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Purchase Tax Invoice</title>
    <link rel="stylesheet" href="{{ asset('bootstrap4/bootstrap.min.css') }}">
    <script src="{{ asset('bootstrap4/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap4/popper.min.js') }}"></script>
    <script src="{{ asset('bootstrap4/bootstrap.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #000;
            background-color: #fff;
            margin: 0;
            padding: 0;
            font-size: 14px;
            line-height: 1.4;
        }

        .invoice-container {
            max-width: 1000px;
            margin: 10px auto;
            background: white;
            border: 2px solid #000;
            padding: 0;
        }

        .invoice-header {
            background: #f8f9fa;
            color: #000;
            padding: 20px 25px;
            border-bottom: 3px solid #000;
        }

        .invoice-title {
            font-size: 24px;
            font-weight: 800;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #000;
        }

        .invoice-subtitle {
            font-size: 14px;
            font-weight: 600;
            color: #555;
        }

        .company-info {
            padding: 15px 25px;
            border-bottom: 2px solid #000;
        }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #000;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #000;
        }

        .info-card {
            background: white;
            padding: 12px;
            margin-bottom: 10px;
            border: 2px solid #000;
        }

        .info-card h5 {
            font-weight: 700;
            color: #000;
            margin-bottom: 5px;
            font-size: 15px;
        }

        .info-card p {
            margin-bottom: 3px;
            color: #000;
            font-weight: 500;
        }

        .table-container {
            padding: 0 25px;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            border: 2px solid #000;
        }

        .invoice-table th {
            background: #f8f9fa;
            color: #000;
            font-weight: 700;
            padding: 12px 8px;
            text-align: center;
            border: 2px solid #000;
            font-size: 13px;
        }

        .invoice-table td {
            padding: 3px 1px;
            border: 1px solid #000;
            text-align: right;
            font-weight: 500;
        }

        .invoice-table td:first-child {
            text-align: left;
            font-weight: 600;
        }

        .invoice-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .total-row {
            background: #e9ecef !important;
            color: #000;
            font-weight: 700;
        }

        .total-row td {
            border: 2px solid #000 !important;
            font-weight: 700;
        }

        .summary-box {
            background: #e9ecef;
            padding: 12px;
            margin: 15px 0;
            border: 2px solid #000;
        }

        .signature-area {
            margin-top: 30px;
            padding: 0 25px 20px;
        }

        .signature-line {
            border-top: 2px solid #000;
            width: 200px;
            margin-bottom: 5px;
        }

        .print-btn {
            background: #f8f9fa;
            color: #000;
            border: 2px solid #000;
            padding: 10px 20px;
            font-weight: 700;
            transition: all 0.3s;
            margin-bottom: 15px;
        }

        .print-btn:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }

        .invoice-number {
            background: #f8f9fa;
            color: #000;
            padding: 6px 12px;
            font-weight: 700;
            border: 2px solid #000;
            display: inline-block;
            margin-bottom: 8px;
        }

        .text-primary {
            color: #000 !important;
            font-weight: 700;
        }

        .text-bold {
            font-weight: 700;
        }

        .text-strong {
            font-weight: 800;
        }

        /* Print-specific styles */
        @media print {
            body {
                background: white;
                margin: 0;
                padding: 0;
                font-size: 12px;
            }
            
            .invoice-container {
                box-shadow: none;
                border: 2px solid #000;
                margin: 0;
                max-width: 100%;
                width: 100%;
            }
            
            .print-btn {
                display: none !important;
            }
            
            .invoice-table {
                border: 2px solid #000 !important;
                page-break-inside: avoid;
            }
            
            .invoice-table th,
            .invoice-table td {
                border: 1px solid #000 !important;
                padding: 8px 6px;
                font-size: 11px;
            }
            
            .invoice-table th {
                background: #f8f9fa !important;
                color: #000 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .total-row {
                background: #e9ecef !important;
                color: #000 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .info-card {
                border: 2px solid #000 !important;
            }
            
            .summary-box {
                border: 2px solid #000 !important;
                background: #e9ecef !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .invoice-header {
                background: #f8f9fa !important;
                color: #000 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                border-bottom: 3px solid #000 !important;
            }
            
            /* Ensure all text is black for better print contrast */
            .info-card h5,
            .info-card p,
            .section-title,
            .invoice-table td {
                color: #000 !important;
            }
        }

        /* Screen-specific styles */
        @media screen {
            .invoice-container {
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            }
        }
    </style>
</head>

<body>
    <div class="container mt-3">
        <div class="d-flex justify-content-center">
            <button class="print-btn" onclick="printInvoice()">
                <i class="fa fa-print"></i> Print Invoice
            </button>
        </div>
    </div>

    <div class="invoice-container">
        <div class="invoice-header">
                <div class="text-center">
                    <h1 class="invoice-title">Purchase Tax Invoice</h1>
                    <!-- <p class="invoice-subtitle">Official Tax Document</p> -->
                </div>
                <!-- <div class="text-right">
                    <div class="invoice-number">
                        Invoice #: {{ $newsale_detail[0]->invoice_no1 }}
                    </div>
                </div> -->

        </div>

        <div class="company-info">
            <div class="row">
                <div class="col-md-6">
                    <div class="info-card">
                        <h5>FROM:</h5>
                        <p class="text-strong">{{ $newsale_detail[0]->parties->party_name }}</p>
                        <p>{{ $newsale_detail[0]->parties->address }}</p>
                        @if($newsale_detail[0]->parties->phone)
                        <p>Phone: {{ $newsale_detail[0]->parties->phone }}</p>
                        @endif
                        <p>NTN: {{ $newsale_detail[0]->parties->ntn }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-card">
                        <h5>TO:</h5>
                        <p class="text-strong">{{ session()->get('company_name') }}</p>
                        <p>{{ session()->get('company_address') }}</p>
                        <p>NTN: {{ session()->get('company_ntn') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="section-title">INVOICE DETAILS</h4>
                <div>
                    <p class="mb-1 text-bold">Date: {{ date('d/m/Y', Strtotime($newsale_detail[0]->date)) }}</p>
                    @if($newsale_detail[0]->p_order)
                    <p class="mb-1 text-bold">GRN: {{ $newsale_detail[0]->p_order }}</p>
                    @endif
                    <p class="mb-0 text-bold">Voucher #: {{ $newsale_detail[0]->invoice_no }}</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="invoice-table">
                    <thead>
                        <tr>
                            <th style="width: 40%;">DESCRIPTION</th>
                            <th style="width: 12%;">QTY</th>
                            <th style="width: 12%;">RATE</th>
                            <th style="width: 12%;">V.EXC.SAL.TAX</th>
                            <th style="width: 8%;">S.T%</th>
                            <th style="width: 12%;">S.T.VAL</th>
                            <th style="width: 14%;">TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $sum = 1;
                        $quantity = 0;
                        $rate = 0;
                        $ValueExcTax = 0;
                        $STValue = 0;
                        $amount = 0; 
                        ?>
                        
                        @foreach ($newsale_detail[0]->purchasetax_details as $details)
                        <tr>
                            <td class="text-bold">{{ $details->products->product_name }}</td>
                            <td>{{ number_format($details->quantity, 2) }}</td>
                            <td>{{ number_format($details->rate, 2) }}</td>
                            <td>{{ number_format($details->price, 2) }}</td>
                            <td>{{ number_format($details->stvalue, 2) }}</td>
                            <td>{{ number_format($details->taxvalue, 2) }}</td>
                            <td class="text-strong">{{ number_format($details->total, 2) }}</td>
                        </tr>
                        <?php
                        $quantity = $quantity + $details->quantity;
                        $rate = $rate + $details->rate;
                        $ValueExcTax = $ValueExcTax + $details->price;
                        $STValue = $STValue + $details->taxvalue;
                        $amount = $amount + $details->total;
                        $sum = $sum + 1;
                        ?>
                        @endforeach

                        <!-- Empty rows for consistent layout -->
                        @if (isset($newsale_detail[0]->purchasetax_details))
                            @if (count($newsale_detail[0]->purchasetax_details) > 5)
                                @for ($i = 0; $i < 10; $i++)
                                <tr>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @endfor
                            @else
                                @for ($i = 0; $i < 15; $i++)
                                <tr>
                                    <td>&nbsp;</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @endfor
                            @endif
                        @endif

                        <!-- Total Row -->
                        <tr class="total-row">
                            <td>
                                <center>
                                    @if ($newsale_detail[0]->sale_type == 'Credit Sale')
                                    <span class="text-strong">Due: {{ date('d/m/Y', strtotime($newsale_detail[0]->due_date)) }}</span> / 
                                    @endif
                                    <span class="text-strong">TOTAL</span>
                                </center>
                            </td>
                            <td class="text-strong">{{ number_format($quantity, 2) }}</td>
                            <td></td>
                            <td class="text-strong">{{ number_format($ValueExcTax, 2) }}</td>
                            <td></td>
                            <td class="text-strong">{{ number_format($STValue, 2) }}</td>
                            <td class="text-strong">{{ number_format($amount, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="summary-box">
                <div class="row">
                    <div class="col-md-9"></div>
                    <div class="col-md-3">
                        <h5 class="text-right text-strong" style="margin: 0; font-size: 16px;">TOTAL TAX: {{ number_format($STValue) }}</h5>
                    </div>
                </div>
            </div>

            <div class="signature-area">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-3"></div>
                    <div class="col-md-3 text-center">
                        <div class="signature-line"></div>
                        <span class="text-strong">SIGNATURE</span>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="signature-line"></div>
                        <span class="text-strong">NAME & DESIGNATION</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function printInvoice() {
            // Hide the print button before printing
            const printBtn = document.querySelector('.print-btn');
            if (printBtn) {
                printBtn.style.display = 'none';
            }
            
            window.print();
            
            // Show the button again after a short delay
            setTimeout(() => {
                if (printBtn) {
                    printBtn.style.display = 'block';
                }
            }, 500);
        }
        
        // Ensure proper printing on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Force black text and borders for print
            const style = document.createElement('style');
            style.innerHTML = `
                @media print {
                    * {
                        color: #000000 !important;
                        border-color: #000000 !important;
                    }
                    table, th, td {
                        border: 1px solid #000000 !important;
                    }
                }
            `;
            document.head.appendChild(style);
        });
    </script>
    
    @include('include.powerdby2')
</body>

</html>