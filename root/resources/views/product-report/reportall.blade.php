<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Report</title>
    @include('include.report-print-styles')
</head>
<body class="report-wide-print">
    <button class="print-button" onclick="window.print()">
        <i class="fas fa-print"></i> Print Report
    </button>

    <div class="date-stamp">
        {{ date('d/m/Y') }}
    </div>

    @php
        $reportTitle = strtoupper($report[0]->sale_type1 ?? 'Product') . ' REPORT';
    @endphp
    @include('include.report-print-header', compact('fromDate', 'toDate', 'reportTitle'))

    <div class="report-table-wrap">
        <table class="report-table">
            <thead>
                <tr>
                    <th class="col-sr">Sr#</th>
                    <th class="col-date">Date</th>
                    <th class="col-inv">Inv#</th>
                    <th class="col-fbr">FBR.Inv#</th>
                    <th class="col-product">Product Name</th>
                    <th class="col-code">Code</th>
                    <th class="col-num">Rate</th>
                    <th class="col-num">ST%</th>
                    <th class="col-num">Qty</th>
                    <th class="col-num">ST.Val</th>
                    <th class="col-num">Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sum = 0;
                    $qty = 0;
                    $exst = 0;
                    $st = 0;
                    $stval = 0;
                    $gtotal = 0;
                @endphp

                @if(isset($report))
                    @foreach ($report as $reports)
                        @php
                            $sum = $sum + 1;
                            $qty = $reports->quantity + $qty;
                            $st = $reports->taxvalue + $st;
                            $stval = $reports->stvalue + $stval;
                            $gtotal = $reports->total + $gtotal;
                        @endphp
                        <tr>
                            <td class="text-center col-sr">{{ $sum }}</td>
                            <td class="text-center col-date">{{ date('d/m/Y', strtotime($reports->date)) }}</td>
                            <td class="text-center col-inv">{{ $reports->invoice_no }}</td>
                            <td class="text-center col-fbr">{{ $reports->sale_taxes->fbr_invoice_no }}</td>
                            <td class="text-left col-product">{{ $reports->products->product_name }}</td>
                            <td class="text-center col-code">{{ $reports->products->product_code }}</td>
                            <td class="text-right col-num">{{ number_format($reports->rate, 2) }}</td>
                            <td class="text-right col-num">{{ number_format($reports->stvalue, 2) }}</td>
                            <td class="text-right col-num">{{ number_format($reports->quantity, 2) }}</td>
                            <td class="text-right col-num">{{ number_format($reports->taxvalue, 2) }}</td>
                            <td class="text-right col-num">{{ number_format($reports->total, 2) }}</td>
                        </tr>
                    @endforeach

                    <tr class="total-row">
                        <td colspan="8" class="text-center">Grand Total</td>
                        <td class="text-right">{{ number_format($qty, 2) }}</td>
                        <td class="text-right">{{ number_format($st, 2) }}</td>
                        <td class="text-right">{{ number_format($gtotal, 2) }}</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="11" class="text-center" style="color: #FF0000;">No Data Found</td>
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
