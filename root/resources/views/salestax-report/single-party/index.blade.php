<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Tax Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Base Styles */
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            line-height: 1.3;
            color: #333;
            margin: 0;
            padding: 15px;
        }
        
        /* Header Styles */
        .report-header {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }
        
        .company-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .company-details {
            font-size: 12px;
            margin: 3px 0;
        }
        
        .report-period {
            font-weight: bold;
            margin: 10px 0;
            font-size: 13px;
        }
        
        .report-title {
            font-size: 16px;
            font-weight: bold;
            margin: 15px 0;
            text-align: center;
            /* border: 2px solid #000; */
            padding: 5px;
        }
        
        /* Table Styles */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 11px;
        }
        
        .report-table th {
            background-color: #f5f5f5;
            border: 1px solid #000;
            padding: 8px 5px;
            text-align: center;
            font-weight: bold;
        }
        
        .report-table td {
            border: 1px solid #000;
            /* border-right: 1px solid #000; */
            padding: 6px 5px;
        }
        
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        /* Totals Row */
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        
        /* Print Button */
        .print-button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 8px 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
            margin: 10px 0;
            cursor: pointer;
            border-radius: 4px;
        }
        
        /* Print-specific Styles */
        @media print {
            @page {
                size: auto;
                margin: 10mm;
            }
            
            body {
                font-size: 10pt;
                padding: 0;
                margin: 0;
                background: white;
            }
            
            .print-button {
                display: none;
            }
            
            /* Prevent page breaks in these elements */
            .print-header-group {
                page-break-after: avoid;
                page-break-inside: avoid;
            }
            
            .report-table {
                page-break-inside: auto;
                font-size: 9pt;
            }
            
            .report-table th,
            .report-table td {
                padding: 4px 3px;
            }
            
            /* Ensure table rows aren't split across pages */
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            
            /* Keep header with first row */
            thead {
                display: table-header-group;
            }
            
            tfoot {
                display: table-footer-group;
            }
        }
        
        /* Date Stamp */
        .date-stamp {
            float: right;
            margin-top: -40px;
            font-size: 11px;
        }
        
        /* Container to keep header and first table row together */
        .print-header-group {
            margin-bottom: 0;
        }
        
        /* Additional styles for this specific report */
        .party-name {
            font-weight: bold;
            margin: 10px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <button class="print-button" onclick="window.print()">
        <i class="fas fa-print"></i> Print Report
    </button>

    <div class="date-stamp">
        {{ date('d/m/Y') }}
    </div>

    <!-- Group all header content together to prevent page breaks -->
    <div class="print-header-group">
        <div class="report-header">
            <div class="company-name">{{ session()->get('company_name') }}</div>
            <div class="company-details">{{ session()->get('company_address') }}</div>
            <!-- @if(session()->get('company_phone'))
                <div class="company-details">PH: {{ session()->get('company_phone') }}</div>
            @endif
            @if(session()->get('company_email'))
                <div class="company-details">Email: {{ session()->get('company_email') }}</div>
            @endif -->
        </div>

        @include('header.supplier-info')

        <!-- <div class="report-period text-center">
            FROM: {{ date('d/m/Y', strtotime($fromDate)) }} TO: {{ date('d/m/Y', strtotime($toDate)) }}
        </div> -->

        <div class="report-title">SALES TAX REGISTER</div>
        <div class="party-name">FROM: {{ date('d/m/Y', strtotime($fromDate)) }} TO: {{ date('d/m/Y', strtotime($toDate)) }}</div>
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th style="width: 8%">Date</th>
                <th style="width: 5%">Inv.No</th>
                <th style="width: 8%">Digital.InvNO</th>
                <th style="width: 5%">HS Code</th>
                <th style="width: 20%; text-align: left">Product Name</th>
                <th style="width: 5%">Qty</th>
                <th style="width: 5%">Rate</th>
                <th style="width: 10%">Exc.ST</th>
                <th style="width: 5%">ST%</th>
                <th style="width: 5%">S.Tax</th>
                <th style="width: 5%">F.Tax</th>
                <th style="width: 10%">Total Value</th>
                <th style="width: 15%; text-align: left">Party Name</th>
                <th style="width: 15%"> NTN </th>
            </tr>
        </thead>
        <tbody>
            @php 
                $rate = 0; 
                $quantity = 0; 
                $ValExcST = 0; 
                $STValue = 0; 
                $FurtherTax = 0; 
                $total = 0; 
            @endphp
            
            @if (isset($sales) && count($sales) > 0)
                @foreach ($sales as $sale)
                    @foreach ($sale->saletax_details as $products)
                        <tr>
                            <td class="text-center">{{ date('d/m/Y', strtotime($sale->date)) }}</td>
                            <td class="text-center">{{ $sale->invoice_no }}</td>
                            <td class="text-center">{{ $sale->fbr_invoice_no }}</td>
                            <td class="text-left">{{ $products->products->product_code }}</td>
                            <td class="text-left">{{ $products->products->product_name }}</td>
                            <td class="text-right">{{ number_format($products->quantity, 2) }}</td>
                            <td class="text-right">{{ number_format($products->rate, 2) }}</td>
                            <td class="text-right">{{ number_format($products->price, 2) }}</td>
                            <td class="text-right">{{ number_format($products->stvalue, 2) }}</td>
                            <td class="text-right">{{ number_format($products->taxvalue, 2) }}</td>
                            <td class="text-right">{{ number_format($products->extraTaxValue, 2) }}</td>
                            <td class="text-right">{{ number_format($products->total, 2) }}</td>
                            <td class="text-left">{{ $sale->parties->party_name }}</td>
                            <td class="text-center">{{ $sale->parties->ntn }}</td>
                        </tr>
                        @php
                            $rate += $products->rate;
                            $quantity += $products->quantity;
                            $ValExcST += $products->price;
                            $STValue += $products->taxvalue;
                            $FurtherTax += $products->extraTaxValue;
                            $total += $products->total;
                        @endphp
                    @endforeach
                @endforeach
                
                <tr class="total-row">
                    <td colspan="5" class="text-center">TOTAL</td>
                    <td class="text-right">{{ number_format($quantity, 2) }}</td>
                    <td class="text-right"></td>
                    <td class="text-right">{{ number_format($ValExcST, 2) }}</td>
                    <td class="text-right"></td>
                    <td class="text-right">{{ number_format($STValue, 2) }}</td>
                    <td class="text-right">{{ number_format($FurtherTax, 2) }}</td>
                    <td class="text-right">{{ number_format($total, 2) }}</td>
                    <td colspan="2"></td>
                </tr>
            @else
                <tr>
                    <td colspan="14" class="text-center" style="color: #FF0000;">No sales records found</td>
                </tr>
            @endif
        </tbody>
    </table>

    @if($company_detail[0]->white_label == 0)
        @include('include.powerdby2')
    @endif
</body>
</html>