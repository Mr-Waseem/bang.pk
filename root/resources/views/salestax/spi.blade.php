<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sales Tax Invoice</title>
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
            margin-bottom: 10px;
            border-bottom: 2px solid #2c3e50;
            /* padding-bottom: 20px; */
        }

        .company-name {
            font-size: 30px;
            font-weight: 700;
            color: #000000ff;
            /* margin-bottom: 5px; */
            /* font-family: monospace; */
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

        .customer-info {
            width: 65%;
            padding: 5px;
            border: 1px solid #000000;
            border-radius: 4px;
            background-color: #f8f9fa;
        }

        .buyer-title{
        font-size: 20px;
        }
        .buyer-info{
            font-size: 16px;
        }

        .invoice-meta {
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

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-table th {
            /* background-color: #2c3e50; */
            color: #000000;
            text-align: center;
            /* padding: 10px; */
            border: 1px solid #444;
            font-size: 16px;
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
            /* background-color: #f8f9fa; */
            /* font-style: italic; */
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

        .qr-section {
            display: flex; justify-content: center; align-items: center; text-align: center;
            /* display: flex; justify-content: center; align-items: center; flex-direction: column; text-align: center; */
            /* justify-content: space-between;
            margin-top: 30px;
            align-items: center; */
            /* border: 1px solid #000000; */
            /* padding: 15px; */
            /* border-radius: 4px; */
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
                    <i class="fa fa-print"></i> Print Invoice
                </button>
                <a href="{{ asset('salestax/' . $id . '/pdf') }}" class="btn btn-danger" style="margin-left: 5px;">
                    <i class="fa fa-file-pdf-o"></i> Download PDF
                </a>
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

            @if(!empty($sellerCompany->company_logo))
            <div class="header" style="border-bottom: 3px solid #2c3e50; padding-bottom: 10px; margin-bottom: 15px;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="text-align: left; flex: 1;">
                        <div style="font-size: 28px; font-weight: 700; color: #1a1a1a; letter-spacing: 1px; margin-bottom: 4px;">
                            @if(auth()->id() == 637)
                                Service Provider:
                            @endif
                            {{ $sellerCompany->CompanyName}}
                        </div>
                        <div style="font-size: 15px; font-weight: 600; color: #333;">NTN/CNIC: {{ $sellerCompany->ntn}}</div>
                        <div style="font-size: 14px; color: #444; margin-top: 2px;">{{ $sellerCompany->address}}</div>
                    </div>
                <div style="flex-shrink: 0; margin-left: 20px;">
                    <img src="{{ asset($sellerCompany->company_logo) }}" alt="{{ $sellerCompany->CompanyName }}" style="max-width: 220px; max-height: 110px; object-fit: contain;">
                </div>
            </div>
            <div style="text-align: center; margin-top: 8px;">
                <span class="invoice-title">SALES TAX INVOICE</span>
            </div>
        </div>
        @else
        <div class="header">
            <div class="company-name">{{ $sellerCompany->CompanyName}}</div>
            <div class="ntn">NTN/CNIC: {{ $sellerCompany->ntn}}</div>
            <div class="address">{{ $sellerCompany->address}}</div>
            <div class="invoice-title">SALES TAX INVOICE</div>
        </div>
        @endif
        @if($newsale_detail[0]->fbr_invoice_no != null)
    <div class="qr-section" style="">
        <div style="margin-right: 50px;">
            <img id='barcode' 
                 src="https://api.qrserver.com/v1/create-qr-code/?data={{ $newsale_detail[0]->fbr_invoice_no }}&amp;size=100x100" 
                 alt="FBR Invoice QR Code" 
                 width="150" 
                 height="150" />
            <p style="font-size: 20px;"><strong>FBR Invoice No: {{ $newsale_detail[0]->fbr_invoice_no }}</strong> </p>
        </div>
        <div>
            <img src="{{ asset('root/upload/logo/fbrlogo.jpg') }}" style="height: 150px; margin-top: 0; display: block;">
        </div>
    </div>
@endif

        <div class="invoice-details">
            <div class="customer-info">
                <div class="buyer-title"><strong>
                    @if(auth()->id() == 637)
                        Service Recipient:
                    @else
                        Buyer:
                    @endif
                </strong> {{ $newsale_detail[0]->parties->party_name }}</div>
                <div class="buyer-info"><strong>Address:</strong> <span>{{ $newsale_detail[0]->parties->address }}<span></div>
                <div class="buyer-info"><strong>NTN:</strong>  <span>{{ $newsale_detail[0]->parties->ntn }}<span></div>
                @if($newsale_detail[0]->remarks)
                <div><strong>Remarks:</strong> {{ $newsale_detail[0]->remarks }}</div>
                @endif
            </div>
            
            <div class="invoice-meta">
                <div class="buyer-info"><strong>Invoice No.:</strong> {{ $newsale_detail[0]->invoice_no }}</div>
                <div class="buyer-info"><strong>Invoice Date:</strong> {{ date('d/m/Y', Strtotime($newsale_detail[0]->date)) }}</div>
                <!-- @if($newsale_detail[0]->p_order)
                <div class="buyer-info"><strong>P.O. No:</strong> {{ $newsale_detail[0]->p_order }}</div>
                 @endif -->
                @if($newsale_detail[0]->dcn_no)
                <div class="buyer-info"><strong>DC No:</strong> {{ $newsale_detail[0]->dcn_no }}</div>
                 @endif
            </div>
        </div>

        <div class="table-container">
            <table class="invoice-table">
                <thead>
                    <tr>
                        <!-- <th rowspan="2">Sr.No.</th> -->
                        <th rowspan="2">PO</th>
                        <th rowspan="2">HS.Code</th>
                        <th rowspan="2" style="text-align:left !important;">Product Description</th>
                        <th rowspan="2">Unit</th>
                        <th rowspan="2">Qty.</th>
                        <th rowspan="2">Rate</th>
                        <th rowspan="2">Exc Value</th>
                        <th colspan="2">Sales Tax</th>
                        <th rowspan="2">F.Tax</th>
                        <th rowspan="2">Inclusive<br/>Value</th>
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
                    $totalRowDiscount = 0;
                    $amount = 0;
                    ?>
                    @foreach ($newsale_detail[0]->saletax_details as $details)
                        <tr>
                            <!-- <td>{{ $sum }}</td> -->
                            <td>{{ $newsale_detail[0]->p_order }}</td>
                            <td>
                                @if ($details->products)
                                    {{ $details->products->product_code }}
                                @endif
                            </td>
                            <td style="text-align:left;">
                                @if ($details->products)
                                    {{ $details->products->product_name }}
                                @endif
                                <br/>
                                @if ($details->remarks)
                                    {{ $details->remarks }}
                                @endif
                            </td>
                            <td>{{ $details->fbr_uom_desc }}</td>
                            <td>{{ rtrim(number_format($details->quantity, 4), '0') }}</td>
                            <td>{{ rtrim(number_format($details->rate, 4), '0') }}</td>
                            <td>{{ number_format($details->price) }}</td>
                            <td>{{ number_format($details->stvalue, 2) }}</td>
                            <td>{{ number_format($details->taxvalue, 2) }}</td>
                            <td>{{ number_format($details->extraTaxValue, 2) }}</td>
                            @php
                                $grandvalue = $details->total + $details->discount_value + $details->discount2_value;
                            @endphp
                            <td style="text-align:right;">{{ number_format($grandvalue, ($grandvalue == (int)$grandvalue ? 0 : 2)) }}</td>
                        </tr>
                        <?php
                        $quantity = $quantity + $details->quantity;
                        $rate = $rate + $details->rate;
                        $ValueExcTax = $ValueExcTax + $details->quantity * $details->rate;
                        $STValue = $STValue + $details->taxvalue;
                        $ExtraSTValue = $ExtraSTValue + $details->extraTaxValue;
                        $amount = $amount + $grandvalue;

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
                        $totalRowDiscount = $totalRowDiscount + max($rowDisc, 0);
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
                                    <td>&nbsp;</td>
                                </tr>
                            @endfor
                        @endif
                    @endif
                </tbody>
                <tfoot>
                     <tr>
                        <td colspan="4"><strong>Total</strong></td>
                        <td><strong>{{ number_format($quantity, ($quantity == (int)$quantity ? 0 : 2)) }}</strong></td>
                        <!-- <td><strong>{{ number_format($quantity)}}</strong></td> -->
                        <td></td>
                        <!-- <td><strong>{{ number_format($ValueExcTax, ($ValueExcTax == (int)$ValueExcTax ? 0 : 2)) }}</strong></td> -->
                        <td><strong>{{ number_format($ValueExcTax) }}</strong></td>
                        <td></td>
                        <!-- <td><strong>{{ number_format($STValue, ($STValue == (int)$STValue ? 0 : 2)) }}</strong></td> -->
                        <td><strong>{{ number_format($STValue)}}</strong></td>
                        <!-- <td><strong>{{ number_format($ExtraSTValue, ($ExtraSTValue == (int)$ExtraSTValue ? 0 : 2)) }}</strong></td> -->
                        <td><strong>{{ number_format($ExtraSTValue) }}</strong></td>
                        <!-- <td><strong>{{ number_format($amount, ($amount == (int)$amount ? 0 : 2)) }}</strong></td> -->
                        <td><strong>{{ number_format($amount) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="total-section">
            <div class="total-row">
                <div class="total-label">Net Invoice Value:</div>
                <!-- <div class="total-value net-total">{{ number_format($amount, ($amount == (int)$amount ? 0 : 2)) }}</div> -->
                <div class="total-value net-total">{{ number_format($amount, 0) }}</div>
            </div>
        </div>
        @if($newsale_detail[0]->total_income_tax > 0)
        <div class="total-section">
            <div class="total-row">
                <div class="total-label">Advance Income Tax 236G/236H:</div>
                <div class="total-value net-total">{{ number_format($newsale_detail[0]->total_income_tax, 0) }}</div>
            </div>
        </div>
        @endif
        @php
            $grandDiscount = floatval($newsale_detail[0]->discount_amount ?? 0);
            $totalDiscount = $totalRowDiscount + $grandDiscount;
        @endphp
        @if($totalDiscount > 0)
        <div class="total-section">
            <div class="total-row">
                <div class="total-label">Discount:</div>
                <div class="total-value net-total">{{ number_format($totalDiscount, 0) }}</div>
            </div>
        </div>
        @endif
        @php 
            $finalAmount = round($ValueExcTax + $STValue + $ExtraSTValue - $totalDiscount + floatval($newsale_detail[0]->total_income_tax)); 
        @endphp
        <div class="total-section">
            <div class="total-row">
                <div class="total-label">Total Amount:</div>
                <div class="total-value net-total">{{ number_format($finalAmount, 0) }}</div>
            </div>
        </div>

        <div class="amount-in-words">
            <strong>Amount in Words:</strong> {{ NumConvert::word($finalAmount) }} Only /--
        </div>

        <!-- @if($newsale_detail[0]->fbr_invoice_no != null)
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
        @endif -->

        <!-- <div class="signature-section">
            <div class="signature-box">
                Authorized Signature
            </div>
        </div> -->

        <div class="footer">
            <!-- <p><strong>{{ session()->get('company_address') }}</strong></p>
            <p>Phone: {{ session()->get('company_phone') }}</p> -->
            <p>This is an electronically generated invoice and is valid without a signature.</p>
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