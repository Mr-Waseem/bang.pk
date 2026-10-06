<html>

<head>
    <link href="/css/bg.css" rel="stylesheet">
</head>
<!-- <body onload="window.print();"> -->

<body>
    <button onclick="goBack()" autofocus>Go Back</button>
    <div>
        <section class="content">
            @include('/header.report')
            <center id="systemDetail">FROM:{{ date('d/m/Y', Strtotime($fromDate)) }}
                TO:{{ date('d/m/Y', Strtotime($toDate)) }}</center>
            <!-- <center id="systemDetail" >FROM:</center>	 -->
            <div style="border:2px solid;">
                <div><b id="voucherName">WORK IN PROGRESS STOCK REPORT</b></div>
                <div class="panel-body" style="border-top:2px solid;">
                    <!-- <table class="table table-striped table-bordered table-hover dataTables-example" > -->
                    <table style="width:100%;">
                        <thead>
                            <tr>
                                <th
                                    style="width:10%; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">
                                    SR#</th>
                                <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Date
                                </th>
                                <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Product&nbsp;Id
                                </th>
                                {{-- <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Product&nbsp;Name
                                </th> --}}
                                <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Voucher No#
                                </th>
                                <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">StockIn</th>
                                <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">StockOut</th>
                                {{-- <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Product&nbsp;Cost
                                </th> --}}
                                <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Rate
                                </th>
                                <th
                                    style="width:10%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;">
                                    Cost Amount</th>
                                {{-- <th
                                    style="width:10%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;">
                                    Stock&nbsp;Cost</th> --}}
                                <!--  <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;">C.Stock</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sum = 1;
                            // $stock = 0;
                            // $totalCost = 0;
                            // $totalStock = 0;
                            // $cost = 0;
                            ?>
                            @if (count($stockIssue) > 0)

                                @foreach ($stockIssue as $items)
                                    {{-- @if ($items->stockin != null) --}}
                                    @php
                                        // $stock = $items->stockin - $items->stockout;
                                        // $cost = $stock * $items->product_cost;
                                    @endphp
                                    <tr id="datafont">
                                        <td id="tabledata">{{ $sum }}</td>
                                        <td id="tabledata">{{ $items->date }}</td>
                                        <td id="tabledata">{{ $items->product_id }}</td>
                                        <td id="tabledata">{{ $items->voucher_no }}</td>
                                        <td id="tabledata">{{ number_format($items->stockin, 2) }}</td>
                                        <td id="tabledata">{{ number_format($items->stockout, 2) }}</td>

                                        <td id="tabledata">{{ number_format($items->rate, 2) }}</td>
                                        <td id="tabledata">{{ number_format($items->cost_amount, 2) }}</td>


                                    </tr>
                                    @php
                                        $sum = $sum + 1;
                                        // $totalCost = $totalCost + $cost;
                                        // $totalStock = $totalStock + $items->stockin - $items->stockout;
                                    @endphp
                                    {{-- @endif --}}
                                @endforeach
                                {{-- <tr id="datafont">
                                    <td id="tabledata" colspan="3">Total</td>
                                    <td id="tabledata">{{ number_format($totalStock, 2) }}</td>
                                    <td id="tabledata"></td>
                                    <td id="tabledata">{{ number_format($totalCost, 2) }}</td>

                                </tr> --}}
                            @else
                                <tr>
                                    <td colspan="7" style="color:#FF0000;text-align:center;">No Records found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>



</body>

</html>
<script>
    function goBack() {
        window.history.back()
    }
</script>
