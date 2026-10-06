<html>

<head>
    <link href="{{ asset('css/bg.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div>
        <button class="btn btn-primary" onclick="this.style.display='none';window.print()">Print <i
                class="fa fa-print"></i></button>
        @if (Count($warehouse) > 0)
            <section class="content">
                <center>
                    <h3><u><b id="systemTitle">{{ $warehouse[0]->name }}</b></u></h3>
                </center>
                <center><b id="systemDetail">{{ $warehouse[0]->address }}</b></center>
                <center><b id="systemDetail">PH :{{ $warehouse[0]->phone }}</b>
                    <center>
                        <center><b id="systemDetail">Email :{{ $warehouse[0]->email }}</b>
                            <center>
                                <br>
                                <span style="float: right;margin-top: -19px " id="systemDetail">@php
                                    $t = time();
                                    $t . '<br>';
                                    echo date('d/m/Y', $t);
                                @endphp
                                </span>
                            @else
                                <section class="content">
                                    <center>
                                        {{-- <h3><u><b id="systemTitle">ALL BRANCHES</b></u></h3> --}}
                                        <h3><u><b id="systemTitle">{{ session()->get('company_name') }}</b></u></h3>
                                        <p id="systemTitle">{{ session()->get('company_address') }}</p>
                                        <p id="systemTitle" style="margin-top: -10px">PH
                                            :{{ session()->get('company_phone') }}</p>
                                        <p id="systemTitle" style="margin-top: -10px">Email
                                            :{{ session()->get('company_email') }}</p>
                                    </center>

                                    <br>
                                    <span style="float: right;margin-top: -19px " id="systemDetail">@php
                                        $t = time();
                                        $t . '<br>';
                                        echo date('d/m/Y', $t);
                                    @endphp
                                    </span>
        @endif
        <center id="systemDetail">FROM:{{ date('d/m/Y', Strtotime($fromDate)) }}
            TO:{{ date('d/m/Y', Strtotime($toDate)) }}</center>
        <div style="border:2px solid;">
            <div><b id="voucherName">
                    <center>All Parties SaleTax Report</center>
                </b></div>
            <div class="panel-body" style="border-top:2px solid;">
                <table>
                    <thead>
                        <tr>
                            <th style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">Sr.</th>
                            <th style="width:10%;border-top: 2px solid;border-bottom: 2px solid;">DATE</th>
                            <th style="width:5%; border-top: 2px solid;border-bottom: 2px solid;">INV.NO</th>
                            <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">NTN</th>
                            <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;">Ex.Value</th>
                            <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid;">En.Value</th>
                            <th style="width:40%; border-top: 2px solid;border-bottom: 2px solid;">Party&nbsp;Name</th>
                            <th style="width:20%; border-top: 2px solid;border-bottom: 2px solid;display:none;">Product&nbsp;Name
                            </th>

                            <!-- <th>Purchase&nbsp;Price</th> -->
                            <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;display:none;">Rate</th>
                            <th style="width:5%; border-top: 2px solid;border-bottom: 2px solid;">Qty</th>
                            
                            <th style="width:10%; border-top: 2px solid;border-bottom: 2px solid;display:none;">ST%</th>
                            
                            <th
                                style="width:20%; border-top: 2px solid;border-bottom: 2px solid; border-right:2px solid;display:none;">
                                Total&nbsp;Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sum=1; 
                        $rate = 0;
                        $quantity = 0;
                        $ValExcST = 0;
                        $STValue = 0;
                        $total = 0; 
                        ?>
                        @if (isset($sales))
                            @if (count($sales) > 0)
                                @foreach ($sales as $sale)
                                    @foreach ($sale->saletax_details as $products)
                                        <tr id="datafont">
                                            <td id="tabledata">{{ $sum }}</td>
                                            <td id="tabledata">{{ date('d/m/Y', strtotime($sale->date)) }}</td>
                                            <td id="tabledata">{{ $sale->invoice_no }}</td>
                                            <td id="tabledata">
                                                @if ($sale->parties != null)
                                                    {{ $sale->parties->ntn }}
                                                @endif
                                            </td>
                                            <td id="tabledata">{{ number_format($products->price,2) }}</td>
                                            <td id="tabledata">{{ number_format($products->taxvalue) }}</td>
                                            <td id="tabledata">
                                                @if ($sale->parties != null)
                                                    {{ $sale->parties->party_name }}
                                                @endif
                                            </td>
                                            <td id="tabledata" style="display:none;">
                                                @if ($products->products != null)
                                                    {{ $products->products->product_name }}
                                                    ({{ $products->products->product_code }})
                                                @endif
                                            </td>

                                            <td id="tabledata" style="display:none;">{{ $products->rate }}</td>
                                            <td id="tabledata">{{ number_format($products->quantity) }}</td>
                                            
                                            <td id="tabledata" style="display:none;">{{ (int) $products->stvalue }}</td>
                                            
                                            <td id="tabledata" style="display:none;">{{ (int) $products->total }}</td>
                                            <?php
                                            //$pprice = $pprice + $products->products->product_cost;
                                            $rate = $rate + (int) $products->rate;
                                            $quantity = $quantity + (int) $products->quantity;
                                            $ValExcST = $ValExcST + (int) $products->price;
                                            $STValue = $STValue + (int) $products->taxvalue;
                                            $total = $total + (int) $products->total;
                                            $sum+=1;
                                            ?>
                                        </tr>
                                    @endforeach
                                @endforeach
                                <tr id="datafont">
                                    <td colspan="4"
                                        style="border-top: 2px solid;border-left: 2px solid;border-bottom: 2px solid;">
                                        <center><b>Total</b></center>
                                    </td>
                                    <td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;">
                                        <b>{{ number_format($ValExcST) }}</b>
                                    </td>
                                    <td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;">
                                        <b>{{ number_format($STValue) }}</b>
                                    </td>
                                    <td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;"></td>
                                    <td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;">
                                        <b>{{ number_format($quantity) }}</b>
                                    </td>
                                    {{-- <td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;">
                                        <b>{{ (int) $ValExcST }}</b>
                                    </td>
                                    <td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;">
                                    </td>
                                    <td style="border-top: 2px solid; border-bottom: 2px solid; text-align:center;">
                                        <b>{{ (int) $STValue }}</b>
                                    </td> --}}
                                    {{-- <td
                                        style="border-top: 2px solid;border-right: 2px solid;border-bottom: 2px solid; text-align:center;">
                                        <b>{{ (int) $total }}</b>
                                    </td> --}}
                                </tr>
                            @endif
                        @else
                            <tr>
                                <td colspan="7" style="color:#FF0000;text-align:center;">No Sales found</td>
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
