<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<!-- <body onload="window.print();"> -->

<body>
    <div class="content-wrapper">
        <section class="content">
            @include("/header.report")
            <div class="panel panel-default">
                <div class="panel-heading"><b>All Products Stock</b></div>
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover dataTables-example">
                        <thead>
                            <tr>
                                <th>Serial#</th>
                                <th>Product&nbsp;Code</th>
                                <th>Product&nbsp;Name</th>
                                <th>Qty&nbsp;In&nbsp;Pack</th>
                                <th>Qty&nbsp;Out&nbsp;Pack</th>
                                <th style="border: 1px solid red;">C.Stock(Pack)</th>
                                <th>Weight&nbsp;In&nbsp;KG</th>
                                <th>Weight&nbsp;Out&nbsp;KG</th>
                                <th style="border: 1px solid blue;">C.Stock(Weight)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sum = 1; ?>
                            @foreach ($products as $product)
                                <tr>
                                    <td><?php echo $sum; ?></td>
                                    <td class="center">{{ $product->product_code }}</td>
                                    <td class="center">{{ $product->product_name }} ({{ $product->pack_weight }}
                                        {{ $product->uom }}, {{ $product->pack_type }})</td>
                                    <!--------------PACK PURCHASE--------------->
                                    <?php $KgStock1 = 0;
                                    $packStock1 = 0; ?>
                                    @foreach ($product->products_detail as $detail)
                                        @if ($detail->unit->uom == 'BAG' || $detail->unit->uom == 'CANS' || $detail->unit->uom == 'DRUM' || $detail->unit->uom == 'COTTON' || $detail->unit->uom == 'COTTON')

                                            @php $packStock1 = $packStock1+(float)$detail->quantity; @endphp
                                        @endif
                                        @if ($detail->unit->uom == 'KG')
                                            @php $KgStock1 = (float)$detail->quantity/$product->pack_weight; @endphp
                                        @endif

                                    @endforeach
                                    @php  $totalPurchase = $packStock1+$KgStock1 @endphp
                                    <td class="center">
                                        {{ number_format((float) $totalPurchase, 2) }}
                                    </td>
                                    <!--------------PACK PURCHASE--------------->
                                    <!--------------PACK SALE--------------->
                                    <?php $KgStock = 0;
                                    $packStock = 0; ?>
                                    @foreach ($product->sale_detail as $detail)
                                        @if ($detail->unit->uom == 'BAG' || $detail->unit->uom == 'CANS' || $detail->unit->uom == 'DRUM' || $detail->unit->uom == 'COTTON' || $detail->unit->uom == 'COTTON')
                                            @php $packStock = $packStock+(float)$detail->quantity; @endphp
                                        @endif
                                        @if ($detail->unit->uom == 'KG')
                                            @php $KgStock = (float)$detail->quantity/(float)$product->pack_weight; @endphp
                                        @endif

                                    @endforeach

                                    <?php $KgStockST = 0;
                                    $packStockST = 0; ?>
                                    @foreach ($product->saletax_details as $detail)
                                        @if ($detail->unit->uom == 'BAG' || $detail->unit->uom == 'CANS' || $detail->unit->uom == 'DRUM' || $detail->unit->uom == 'COTTON' || $detail->unit->uom == 'COTTON')
                                            @php $KgStockST = $KgStockST+(float)$detail->quantity; @endphp
                                        @endif
                                        @if ($detail->unit->uom == 'KG')
                                            @php $packStockST = (float)$detail->quantity/(float)$product->pack_weight; @endphp
                                        @endif

                                    @endforeach
                                    @php
                                        $totalSale = $KgStock + $packStock;
                                        $totalSaleST = $packStockST + $KgStockST;
                                        
                                    @endphp
                                    <td class="center">{{ number_format($totalSale + $totalSaleST, 2) }}
                                        {{-- {{ $totalSale }} --}}
                                    </td>
                                    <!--------------PACK SALE--------------->

                                    {{-- <td class="center">0</td> --}}
                                    <!--------------Pack Quantity--------------->
                                    <td class="center" style="border: 1px solid red;">
                                        {{ number_format($totalPurchase - $totalSale - $totalSaleST, 2) }}</td>
                                    <td class="center">
                                        @php $totalpurchase = $product->pack_weight*$totalPurchase; @endphp
                                        {{ number_format($totalpurchase, 2) }}
                                    </td>
                                    <!--------------KG PURCHASE--------------->

                                    <td class="center">
                                        @php $totalsale = $product->pack_weight*($totalSale+$totalSaleST); @endphp
                                        {{ number_format($totalsale, 2) }}

                                    </td>
                                    <!--------------PACK SALE--------------->
                                    <td class="center" style="border: 1px solid blue;">
                                        {{ number_format($totalpurchase - $totalsale, 2) }}</td>
                                </tr>
                                <?php $sum = $sum + 1; ?>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Serial#</th>
                                <th>Product&nbsp;Code</th>
                                <th>Product&nbsp;Name</th>
                                <th>Qty&nbsp;In&nbsp;Pack</th>
                                <th>Qty&nbsp;Out&nbsp;Pack</th>
                                <th style="border: 1px solid red;">C.Stock(Pack)</th>
                                <th>Weight&nbsp;In&nbsp;KG</th>
                                <th>Weight&nbsp;Out&nbsp;KG</th>
                                <!-- <th>Pack&nbsp;Quantity</th> -->

                                <th style="border: 1px solid blue;">C.Stock(Weight)</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </section>
    </div>
</body>

</html>
