<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Summary Report</title>
    @include('include.report-print-styles')
</head>
<body>
    <button class="print-button" onclick="window.print()">
        <i class="fas fa-print"></i> Print Report
    </button>

    <div class="date-stamp">
        {{ date('d/m/Y') }}
    </div>

    @php
        $reportTitle = strtoupper($saleTypeLabel ?? 'Summary') . ' SUMMARY REPORT';
    @endphp
    @include('include.report-print-header', compact('fromDate', 'toDate', 'reportTitle'))

    <div class="report-table-wrap">
        <table class="report-table">
            <thead>
                <tr>
                    <th class="col-sr">Sr#</th>
                    <th class="col-hs">HS Code</th>
                    <th class="col-product">Product Name</th>
                    <th class="col-num">Qty</th>
                    <th class="col-num">Exclusive Value</th>
                    <th class="col-num">Tax value</th>
                    <th class="col-num">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 0;
                    $totalQty = 0;
                    $totalExclusive = 0;
                    $totalTax = 0;
                    $totalAmount = 0;
                @endphp

                @if(isset($report) && count($report))
                    @foreach($report as $row)
                        @php
                            $i++;
                            $totalQty += $row->qty;
                            $totalExclusive += $row->exclusive_value;
                            $totalTax += $row->tax_value;
                            $totalAmount += $row->total_amount;
                        @endphp
                        <tr>
                            <td class="text-center col-sr">{{ $i }}</td>
                            <td class="text-center col-hs">{{ $row->hs_code }}</td>
                            <td class="text-left col-product">{{ $row->product_name }}</td>
                            <td class="text-right col-num">{{ number_format($row->qty, 2) }}</td>
                            <td class="text-right col-num">{{ number_format($row->exclusive_value, 2) }}</td>
                            <td class="text-right col-num">{{ number_format($row->tax_value, 2) }}</td>
                            <td class="text-right col-num">{{ number_format($row->total_amount, 2) }}</td>
                        </tr>
                    @endforeach

                    <tr class="total-row">
                        <td colspan="3" class="text-center">Grand Total</td>
                        <td class="text-right">{{ number_format($totalQty, 2) }}</td>
                        <td class="text-right">{{ number_format($totalExclusive, 2) }}</td>
                        <td class="text-right">{{ number_format($totalTax, 2) }}</td>
                        <td class="text-right">{{ number_format($totalAmount, 2) }}</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="7" class="text-center" style="color: #FF0000;">No Data Found</td>
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
