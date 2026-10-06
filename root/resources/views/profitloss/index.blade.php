<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PROFIT & LOSS ACCOUNT</title>
    <link rel="stylesheet" href="{{ asset('bootstrap4/bootstrap.min.css') }}">
    <style>
    tr {
        /* line-height: 0px; */
        border: 1px solid black;
    }

    .table thead th,
    .table tbody tr td {
        border: 1px solid black;
        padding: 0px !important;
        padding-left: 5px !important;
        /* text-align: right; */
    }
    .rightalgin{
        text-align: right;
    }
    </style>
</head>
</br>
<body>
    <div class="container">
        <div class="row flex-lg-nowrap">
            <div class="col">
                <div class="row">
                    <div class="col mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="e-profile">
                                    @include('include.header')
                                    <h2 class="text-center"><u>PROFIT & LOSS ACCOUNT</u></h2>
                                    <p class="text-center font-italic"><b>From:</b> {{
										date('d/m/Y',strtotime($fromDate)) }} && <b>To:</b> {{
										date('d/m/Y',strtotime($toDate)) }}</p>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <!-- <th>SR.NO</th> -->
                                                    <th>Description</th>
                                                    <th>Amount</th>
                                                    <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Sales</td>
                                                    <td></td>
                                                    @php $Totalsale = $sales->sales+$salesTax->salesTax; @endphp
                                                    <td class="rightalgin">{{ number_format($Totalsale) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Closing Stock</td>
                                                    <td></td>
                                                    <td class="rightalgin">{{ number_format($closingStock) }}</td>
                                                </tr>
                                                <tr>
                                                    <td><b>Total Sales</b></td>
                                                    <!-- <td class="rightalgin"></td> -->
                                                    @php $totalSalesValue = $Totalsale+$closingStock; @endphp
                                                    <td colspan="2" class="rightalgin"><b>{{ number_format($totalSalesValue) }}</b></td>
                                                </tr><hr/>
                                                <!-- <tr>
                                                    <td colspan="3">&nbsp;<hr/></td>
                                                    
                                                </tr> -->
                                                <tr>
                                                    <td colspan="3"><b>Cost of Sale</b></td>
                                                    
                                                </tr>
                                                <tr>
                                                    <td>Opening Stock</td>
                                                    <td class="rightalgin"></td>
                                                    <td class="rightalgin">{{ number_format($openingStock) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Purchases</td>
                                                    @php $Totalpurchases = $purchases->purchases+$PurchaseTax->PurchaseTax; @endphp
                                                    <td class="rightalgin">{{ number_format($Totalpurchases) }}</td>
                                                    <td class="rightalgin"></td>
                                                </tr>
                                                <tr>
                                                    <td>Direct Expense (Direct Salary, Other Direct Expense)</td>
                                                    <td class="rightalgin">{{ number_format($directExpense->directExpense) }}</td>
                                                    <td class="rightalgin"></td>
                                                </tr>
                                                <!-- <tr>
                                                    <td>Depriciation</td> 
                                                    <td class="rightalgin">{{ number_format($depriciation->depriciation) }}</td>
                                                    <td class="rightalgin"></td>
                                                </tr> -->
                                              
                                                @php 
                                                $costValue = $openingStock+$Totalpurchases+$directExpense->directExpense;
                                                @endphp
                                                <tr>
                                                    <td><b>Total Cost of Sale</b></td>
                                                    <td class="rightalgin"><b>{{ number_format($costValue) }}</b></td>
                                                    <td class="rightalgin"></td>
                                                </tr>
                                               
                                                <tr>
                                                    <td><b style="font-size: 20px;">Gross Profit</b></td>
                                                    <!-- <td class="rightalgin"></td> -->
                                                    @php $grossProfit = $totalSalesValue-$costValue; @endphp
                                                    <td colspan="2" class="rightalgin"><b>{{ number_format($grossProfit) }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3"><b  style="font-size: 20px;">Operating Expenses</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Admin & Distribution Exp</td>
                                                    <td class="rightalgin"></td>
                                                    <td class="rightalgin">{{ number_format($AdminExpense->AdminExpense) }}</td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>Depriciation</td>
                                                    <td class="rightalgin"></td>
                                                    <td class="rightalgin">{{ number_format($depriciation->depriciation) }}</td>
                                                </tr>
                                                <tr>
                                                    <td><b style="font-size: 20px;">Operating Profit</b></td>
                                                    <td class="rightalgin"></td>
                                                    @php $operatingProfit = $grossProfit - $AdminExpense->AdminExpense - $depriciation->depriciation; @endphp
                                                    <td class="rightalgin"><b>{{ number_format($operatingProfit) }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Finance Cost|Markup</td>
                                                    <td class="rightalgin"></td>
                                                    <td class="rightalgin">{{ number_format($Markup->Markup) }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Other Income</td>
                                                    <td class="rightalgin"></td>
                                                    <td class="rightalgin">{{ number_format($OtherIncome->OtherIncome) }}</td>
                                                </tr>

                                                <tr>
                                                    <td><b style="font-size: 20px;">Profit before taxation</b></td>
                                                    <td class="rightalgin"></td>
                                                    @php $ProfitBeforeTax = $operatingProfit - $Markup->Markup - $OtherIncome->OtherIncome; @endphp
                                                    <td class="rightalgin"><b>{{ number_format($ProfitBeforeTax) }}</b></td>
                                                </tr>
                                                <tr>
                                                    <td>Taxation</td>
                                                    <td class="rightalgin"></td>
                                                    <td class="rightalgin">{{ number_format($Taxation->Taxation) }}</td>
                                                </tr>
                                                <tr>
                                                    <td><b style="font-size: 20px;">Net Profit</b></td>
                                                    <td class="rightalgin"></td>
                                                    @php $NetProfit = $ProfitBeforeTax - $Taxation->Taxation; @endphp
                                                    <td class="rightalgin"><b>{{ number_format($NetProfit) }}</b></td>
                                                </tr>
                                                <!-- <tr>
                                                    <td colspan="2">
                                                        <center><b>TOTAL</b></center>
                                                    </td>
                                                    <td>
                                                        <b>{{ number_format(3333) }}</b>
                                                    </td>
                                                    <td>
                                                        <b>{{ number_format(3333) }}</b>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="color:#FF0000;text-align:center;">No
                                                        Records found</td>
                                                </tr> -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('include.powerdby2')
</body>

</html>