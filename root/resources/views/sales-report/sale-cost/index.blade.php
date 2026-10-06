<html>

<head>
    <link href="{{ asset('css/bg.css') }}" rel="stylesheet">
</head>

<body>
    <button onclick="goBack()" autofocus>Go Back</button>
    <div>
        <section class="content">
            @include('header.report')
            <center id="systemDetail">FROM:{{ date('d/m/Y', Strtotime($fromDate)) }}
                TO:{{ date('d/m/Y', Strtotime($toDate)) }}</center>
            <div style="border:2px solid;">
                <div><b id="voucherName">SALE COST ANALYSIS</b></div>
                <div class="panel-body" style="border-top:2px solid;">
                    <table style="width:100%;">
                        <thead>
                            <tr>
                                <th
                                    style="width:10%; border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">
                                    Serial</th>
                                <th
                                    style="width:10%; border-top: 2px solid;border-bottom: 2px solid; text-align: left;">
                                    Invoice#</th>
                                <th style="width:30%; border-top: 2px solid;border-bottom: 2px solid;text-align: left;">
                                    Product&nbsp;Name</th>
                                <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Qty</th>
                                <th style="width:00%; border-top: 2px solid;border-bottom: 2px solid;">Cost</th>
                                <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">CostAmount</th>
                                <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Rate</th>
                                <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">RateAmount</th>
                                <th
                                    style="width:10%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;">
                                    Margin</th>
                            </tr>

                        </thead>
                        <tbody>
                            <?php $sum = 1;
                            $totalMargin = 0;
                            $qty = 0;
                            $cost = 0;
                            $costAmount = 0;
                            $rate = 0;
                            $rateAmount = 0;
                            $margin = 0; ?>
                            @if (count($product) > 0)
                                @foreach ($product as $catagories)
                                    <tr id="datafont">
                                        <td id="tabledata"><?php echo $sum; ?></td>
                                        <td id="tabledata">{{ $catagories->sales->invoice_no }}</td>
                                        <td id="tabledata" style="text-align: left;">
                                            @if ($catagories->products != null)
                                                {{ $catagories->products->product_name }}
                                            @endif
                                        </td>
                                        <td id="tabledata">{{ number_format((float) $catagories->quantity, 2, '.', '') }}
                                        </td>
                                        <td id="tabledata">{{ $catagories->product_cost }}</td>
                                        <td id="tabledata">
                                            {{ number_format((float) $catagories->cost_amount, 2, '.', '') }}</td>
                                        <td id="tabledata">{{ $catagories->sale_rate }}</td>
                                        <td id="tabledata">{{ $catagories->sale_amount }}</td>
                                        @php
										$totalMargin = (int) $catagories->sale_amount - (int) $catagories->cost_amount;
                                        @endphp
                                        <td id="tabledata">{{ $totalMargin }}</td>
                                    </tr>
                                    <?php
                                    $sum = $sum + 1;
                                    $qty = $qty + (int) $catagories->quantity;
                                    $cost = $cost + (int) $catagories->product_cost;
                                    $costAmount = $costAmount + (int) $catagories->cost_amount;
                                    $rate = $rate + (int) $catagories->sale_rate;
                                    $rateAmount = $rateAmount + (int) $catagories->sale_amount;
                                    $margin = $margin + (int) $totalMargin;
                                    
                                    ?>
                                @endforeach

                                <tr id="datafont">
                                    <td colspan="3"
                                        style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">
                                        <center><b>Total</b></center>
                                    </td>
                                    <td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;">
                                        <b>{{ number_format((int) $qty) }}</b></td>
                                    <td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;">
                                        <b>{{ number_format((int) $cost) }}</b></td>
                                    <td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;">
                                        <b>{{ number_format((int) $costAmount) }}</b></td>
                                    <td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;">
                                        <b>{{ number_format((int) $rate) }}</b></td>
                                    <td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;">
                                        <b>{{ number_format((int) $rateAmount) }}</b></td>
                                    <td
                                        style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;">
                                        <b>{{ number_format((int) $margin) }}</b></td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="9" style="color:#FF0000;text-align:center;">No Records found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
	@include('include.powerdby2')
</body>

</html>
<script>
    function goBack() {
        window.history.back()
    }
</script>
