<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Purchase Tax Invoice</title>
    <link rel="stylesheet" href="{{ asset('bootstrap4/bootstrap.min.css') }}">
    <script src="{{ asset('bootstrap4/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap4/popper.min.js') }}"></script>
    <script src="{{ asset('bootstrap4/bootstrap.min.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        tr {
            line-height: 0px;
            border: 2px solid black;
        }

        .table thead th {
            border-bottom: 2px solid black;
        }

        .table tbody tr td {
            border: 2px solid black;
        }

    </style>
</head>

<body>
    @if (isset($purchase_tax_detail))
        @if (count($purchase_tax_detail) > 0)
            @include('print-reports.partials.toolbar', ['printOnclick' => 'printInvoice()', 'printLabel' => 'Print <i class="fa fa-print"></i>'])
            @foreach ($purchase_tax_detail as $value)
                <div class="container">
                    <div class="row flex-lg-nowrap">
                        <div class="col">
                            <div class="row">
                                <div class="col mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="e-profile">
                                                @include('include.header-new')
                                                <h3 class="text-center"><u>Purchase Tax Invoice</u></h3>
                                                <p class="text-right"><i><b>Date:</b>
                                                        {{ date('d/m/Y', Strtotime($value->date)) }}</i></p>
                                                <p class="text-right" style="margin-top:-20px"><i><b>PO.No:</b>
                                                        {{ $value->p_order }}</i></p>
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <h5>To: {{ session()->get('company_name') }}</h5>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <h5 class="text-right">Invoice No:
                                                            {{ $value->invoice_no }}</h5>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <h5 class="text-left">Address:
                                                            {{ $value->parties->address }}</h5>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <h5 class="text-right">NTN: {{ $value->parties->ntn }}
                                                        </h5>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <h5 class="text-left">Del Challan: {{ $value->dcn_no }}
                                                        </h5>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                                        <h5 class="text-right">Phone No:
                                                            {{ $value->parties->phone }}</h5>
                                                    </div>
                                                </div>
                                                <br>
                                                <table class="table">
                                                    <tr style="background: grey;text-align: center;">
                                                        <th style="border:2px solid; width:1350px;">Description</th>
                                                        <th style="border:2px solid; width:50px;">Qty</th>
                                                        <th style="border:2px solid; width:30px;">Rate</th>
                                                        <th style="border:2px solid; width:50px;">V.Exc.Sal.Tax</th>
                                                        <th style="border:2px solid; width:50px;">S.T%</th>
                                                        <th style="border:2px solid; width:100px;">S.T.Val</th>
                                                        <th style="border:2px solid; width:100px;">Total</th>
                                                    </tr>
                                                    <?php $sum = 1;
                                                    $quantity = 0;
                                                    $rate = 0;
                                                    $ValueExcTax = 0;
                                                    $STValue = 0;
                                                    $amount = 0; ?>
                                                    @foreach ($value->purchasetax_details as $details)
                                                        <tr style="text-align: center;">
                                                            <td style="width:50px;">
                                                                <center>{{ $details->products->product_name }}
                                                                </center>
                                                            </td>
                                                            <td style="width:50px;">
                                                                <center>{{ number_format($details->quantity) }}
                                                                </center>
                                                            </td>
                                                            <td style="width:30px;">
                                                                {{ number_format($details->rate) }}</td>
                                                            <td style="width:100px;">
                                                                <center>
                                                                    <?php ?>
                                                                    {{ number_format($details->price) }}</center>
                                                            </td>
                                                            <td style="width:30px;">
                                                                <center>{{ number_format($details->stvalue) }}
                                                                </center>
                                                            </td>
                                                            <td style="width:30px;">
                                                                <center>{{ number_format($details->taxvalue) }}
                                                                </center>
                                                            </td>

                                                            <td style="width:30px;">
                                                                <center>{{ number_format($details->total) }}</center>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        
                                                        $quantity = $quantity + $details->quantity;
                                                        $rate = $rate + $details->rate;
                                                        $ValueExcTax = $ValueExcTax + $details->price;
                                                        $STValue = $STValue + $details->taxvalue;
                                                        $amount = $amount + $details->total;
                                                        $sum = $sum + 1;
                                                        ?>
                                                    @endforeach

                                                    @if (isset($value->purchasetax_details))
                                                        @if (count($value->purchasetax_details) > 5)
                                                            @for ($i = 0; $i < 10; $i++)
                                                                <tr>
                                                                    <td style="width:50px;">
                                                                        <center>-</center>
                                                                    </td>
                                                                    <td style="width:50px;">
                                                                        <center></center>
                                                                    </td>
                                                                    <td style="width:340px;">
                                                                        <center></center>
                                                                    </td>
                                                                    <td style="width:100px;">
                                                                        <center></center>
                                                                    </td>
                                                                    <td style="width:100px;">
                                                                        <center></center>
                                                                    </td>
                                                                    <td style="width:100px;">
                                                                        <center></center>
                                                                    </td>
                                                                    <td style="width:100px;">
                                                                        <center></center>
                                                                    </td>
                                                                </tr>
                                                            @endfor
                                                        @else
                                                            @for ($i = 0; $i < 15; $i++)
                                                                <tr>
                                                                    <td style=" width:50px;">
                                                                        <center>-</center>
                                                                    </td>
                                                                    <td style="width:50px;">
                                                                        <center></center>
                                                                    </td>
                                                                    <td style="width:340px;">
                                                                        <center></center>
                                                                    </td>
                                                                    <td style="width:100px;">
                                                                        <center></center>
                                                                    </td>
                                                                    <td style="width:100px;">
                                                                        <center></center>
                                                                    </td>
                                                                    <td style="width:100px;">
                                                                        <center></center>
                                                                    </td>
                                                                    <td style="width:100px;">
                                                                        <center></center>
                                                                    </td>
                                                                </tr>
                                                            @endfor
                                                        @endif
                                                    @endif


                                                    <tr style="background: grey;">
                                                        <td style="border:2px solid black!important; width:50px;">
                                                            <center>
                                                                @if ($value->sale_type == 'Credit Sale')
                                                                    Payment Due Date:
                                                                    <u>{{ date('d/m/Y', strtotime($value->due_date)) }}</u>
                                                                    </h5>
                                                                    /
                                                                @endif
                                                                <b>Total</b>
                                                            </center>
                                                        </td>

                                                        <th style="border:2px solid; width:100px;">
                                                            <center>{{ number_format($quantity) }}</center>
                                                        </th>
                                                        <th style="border:2px solid; width:100px;">
                                                            <center>
                                                                <!-- {{ $rate }} -->
                                                            </center>
                                                        </th>
                                                        <th style="border:2px solid; width:100px;">
                                                            <center>{{ number_format($ValueExcTax) }}</center>
                                                        </th>
                                                        <th style="border:2px solid; width:100px;">
                                                            <center></center>
                                                        </th>
                                                        <th style="border:2px solid; width:100px;">
                                                            <center>{{ number_format($STValue) }}</center>
                                                        </th>
                                                        <th style="border:2px solid; width:100px;">
                                                            <center>{{ number_format($amount) }}</center>
                                                        </th>
                                                    </tr>

                                                </table>
                                                <div class="row mt-3">
                                                    <div class="col-lg-9 col-md-9 col-sm-12"></div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                                        <h5 class="text-center"
                                                            style="border: 2px solid black;padding:5px;">
                                                            Total Tax: {{ number_format($STValue) }}</h5>
                                                    </div>
                                                </div>
                                                <div class="row mt-5">
                                                    <div class="col-lg-3 col-md-3 col-sm-12"></div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12"></div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                                        <span>&emsp;&emsp;&emsp;</span><br>
                                                        <hr
                                                            style="float:left;width:200px;background:black;margin-top:0px;">
                                                        <br>
                                                        <span
                                                            style="position: relative;top:-10px;font-weight:bold">Signature</span>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-12">
                                                        <br>
                                                        <hr
                                                            style="float:left;width:200px;background:black;margin-top:0px;">
                                                        <br>
                                                        <span style="position: relative;top:-10px;font-weight:bold">Name
                                                            &
                                                            Designation</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('include.powerdby3')
                <p style="page-break-after: always;"></p>
            @endforeach
        @else
            <h1>Record Not Found</h1>
        @endif
    @endif
</body>

</html>
