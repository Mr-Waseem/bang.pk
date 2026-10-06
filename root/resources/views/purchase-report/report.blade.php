<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PURCHASE REPORT</title>
    <link rel="stylesheet" href="{{ asset('bootstrap4/bootstrap.min.css') }}">
    <script src="{{ asset('bootstrap4/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap4/popper.min.js') }}"></script>
    <script src="{{ asset('bootstrap4/bootstrap.min.js') }}"></script>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <style>
        tr {
            line-height: 0px;
            border: 1px solid black;
        }

        .table thead th,  .table tbody tr td{
            border: 1px solid black;
        }

    </style>
</head>

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
                                    <h2 class="text-center"><u>PURCHASE REPORT</u></h2>
                                    <p class="text-center font-italic"><b>From:</b> {{ date('d/m/Y',strtotime($fromDate)) }} && <b>To:</b> {{ date('d/m/Y',strtotime($toDate)) }}</p>
                                    <br>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Supplier</th>
                                                <th>Product Name</th>
                                                <th>Price</th>
                                                <th>Qty</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $pprice = 0;
                                            $sprice = 0;
                                            $quantity = 0;
                                            $total = 0; ?>
                                            @if (isset($purchases))
                                                @if (count($purchases) > 0)
                                                    @foreach ($purchases as $purchase)
                                                        <tr>
                                                            @foreach ($purchase->purchase_details as $products)
                                                                <td>{{ date('d/m/Y', strtotime($purchase->date)) }}
                                                                </td>
                                                                <td>{{ $products->party->party_name }}</td>
                                                                <td>
                                                                    @if ($products->products != null)
                                                                        {{ $products->products->product_name }}
                                                                        ({{ $products->products->product_code }})
                                                                    @endif
                                                                </td>
                                                                <td>{{ number_format($products->unit_cost) }}</td>
                                                                <td>{{ number_format($products->quantity) }}</td>
                                                                <td>{{ number_format($products->total_cost) }}</td>
                                                                <?php
                                                                $pprice = $pprice + $products->unit_cost;
                                                                
                                                                $quantity = $quantity + $products->quantity;
                                                                $total = $total + $products->total_cost;
                                                                ?>
                                                        </tr>
                                                        @endforeach
                                                    @endforeach
                                                    <tr>
                                                        <td colspan="3">
                                                            <center><b>Total</b></center>
                                                        </td>
                                                        <td>{{ number_format($pprice) }}</td>

                                                        <td>{{ number_format($quantity) }}</td>
                                                        <td>{{ number_format($total) }}</td>
                                                    </tr>
                                                @else
                                                <tr>
                                                    <td colspan="7" style="color:#FF0000;text-align:center;font-weight: bold;">No Purchases Found</td>
                                                </tr>
                                                @endif
                                            @else
                                            <tr>
                                                <td colspan="7" style="color:#FF0000;text-align:center;font-weight: bold;">No Purchases Found</td>
                                            </tr>
                                            @endif
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
    @include('include.powerdby')
</body>

</html>
