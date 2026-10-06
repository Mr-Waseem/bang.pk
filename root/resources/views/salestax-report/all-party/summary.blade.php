<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Parties Sales Tax Report</title>
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
            color: #000000;
        }
        
        .report-period {
            font-weight: bold;
            margin: 10px 0;
            font-size: 13px;
        }
        
        .report-title {
            font-size: 14px;
            font-weight: bold;
            margin: 15px 0;
            text-align: center;
            /* border: 1px solid #000; */
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
            border: 1px solid #ddd;
            border-right: 1px solid #000;
            padding: 6px 5px;
        }
        
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        
        /* Totals Row */
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
            border-bottom: 2px solid #000; 
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
        
        /* Additional styles from the second template */
        #tabledata {
            border-left: 1px solid #000;
            border-bottom: 1px solid #000;
        }
        
        #tabledataright {
            text-align: right;
            border-bottom: 1px solid #000;
        }
        
        #tabledataleft {
            text-align: left;
            border-bottom: 1px solid #000;
        }
        
        .panel-body {
            border-top: 1px solid #000;
        }
    </style>
</head>
<body>
    <button class="print-button" onclick="window.print()">
        <i class="fas fa-print"></i> Print Report
    </button>

    <div class="date-stamp">
        @php
            $t = time();
            echo date('d/m/Y', $t);
        @endphp
    </div>

    <!-- Group all header content together to prevent page breaks -->
    <div class="print-header-group">
        <div class="report-header">
            @if(count($warehouse) > 0)
                <div class="company-name">{{ $warehouse[0]->name }}</div>
                <div class="company-details">{{ $warehouse[0]->address }}</div>
                <!-- <div class="company-details">PH: {{ $warehouse[0]->phone }}</div>
                <div class="company-details">Email: {{ $warehouse[0]->email }}</div> -->
            @else
                <div class="company-name">{{ session()->get('company_name') }}</div>
                <div class="company-details">{{ session()->get('company_address') }}</div>
                <!-- <div class="company-details">PH: {{ session()->get('company_phone') }}</div>
                <div class="company-details">Email: {{ session()->get('company_email') }}</div> -->
            @endif
        </div>

       

        <div class="report-title">ALL PARTIES SALES TAX REPORT</div>
        <div class="report-period text-center">
            FROM: {{ date('d/m/Y', strtotime($fromDate)) }} TO: {{ date('d/m/Y', strtotime($toDate)) }}
        </div>
    </div>

    <div class="panel-body">
        <table class="report-table">
            <thead>
                <tr>
                    <th style="width: 8%">Date</th>
                    <th style="width: 7%">Inv.No</th>
                    <th style="width: 10%">Digital.InvNO</th>
                    <th style="width: 5%">Qty</th>
                    <th style="width: 10%">Exclusive Val</th>
                    <th style="width: 10%">Tax Value</th>
                    <th style="width: 10%">F.Tax</th>
                    
                    <th style="width: 10%">Inclusive Val</th>
                    <th style="width: 27%">Party Name</th>
                    <th style="width: 13%">NTN</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $grand = 0;
                    $grandValExcST = 0;
                    $grandFurtherTax = 0;
                    $grandSTValue = 0;
                    $GrandWeight = 0;
                @endphp
                
                @if (isset($sales) && count($sales) > 0)
                    @foreach ($sales as $sale)
                        @php
                            $ValExcST = 0;
                            $FurtherTax = 0;
                            $STValue = 0;
                            $total = 0;
                            $TotalWeight = 0;
                        @endphp
                        
                        @foreach ($sale->saletax_details as $products)
                            @php
                                $TotalWeight += $products->quantity;
                                $ValExcST += $products->price;
                                $FurtherTax += $products->extraTaxValue;
                                $STValue += $products->taxvalue;
                                $total += $products->total;
                            @endphp
                        @endforeach
                        
                        <tr>
                            <td id="tabledata">{{ date('d/m/Y', strtotime($sale->date)) }}</td>
                            <td id="tabledata">{{ $sale->invoice_no }}</td>
                            <td id="tabledata">{{ $sale->fbr_invoice_no }}</td>
                            <td id="tabledataright">{{ number_format($TotalWeight, 2) }}</td>
                            <td id="tabledataright">{{ number_format($ValExcST, 2) }}</td>
                            <td id="tabledataright">{{ number_format($STValue, 2) }}</td>
                            <td id="tabledataright">{{ number_format($FurtherTax, 2) }}</td>
                            
                            <td id="tabledataright">{{ number_format($total, 2) }}</td>
                            <td id="tabledataleft">
                                @if ($sale->parties != null)
                                    {{ $sale->parties->party_name }}
                                @endif
                            </td>
                            <td id="tabledataright">
                                @if ($sale->parties != null)
                                    {{ $sale->parties->ntn }}
                                @endif
                            </td>
                        </tr>
                        
                        @php
                            $GrandWeight += $TotalWeight;
                            $grandValExcST += $ValExcST;
                            $grandFurtherTax += $FurtherTax;
                            $grandSTValue += $STValue;
                            $grand += $total;
                        @endphp
                    @endforeach
                    
                    <tr class="total-row">
                        <td colspan="3" style="border-left: 1px solid #000;">TOTAL</td>
                        <td class="text-right">{{ number_format($GrandWeight, 2) }}</td>
                        <td class="text-right">{{ number_format($grandValExcST, 2) }}</td>
                        <td class="text-right">{{ number_format($grandSTValue, 2) }}</td>
                        <td class="text-right">{{ number_format($grandFurtherTax, 2) }}</td>
                        
                        <td class="text-right">{{ number_format($grand, 2) }}</td>
                        <td colspan="2"></td>
                    </tr>
                @else
                    <tr>
                        <td colspan="10" class="text-center" style="color: #FF0000;">No sales records found</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    @if($company_detail[0]->white_label == 0)
        @include('include.powerdby2')
    @endif
</body>
</html>