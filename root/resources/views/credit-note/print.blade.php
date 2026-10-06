﻿<!DOCTYPE html>
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
        }

        .table td, .table td {
            border-top: 0px!important;
			border-right: 1px solid black;
        }
		.table td, .table td:first-child{
			border-top: 0px!important;
			border-left: 2px solid black;
			border-right: 2px solid black;
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
                                    

                                    <div class="row" style="border-bottom: 2px solid;">
                                      <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                        <div class="text-center text-sm-left mb-2 mb-sm-0">
                                          <h3 class="pt-sm-2 pb-1 mb-0 text-nowrap" style="color:black;">From: {{ $newsale_detail[0]->parties->party_name }}</h3>
                                          <p class="mb-0" style="color:black; font-weight: 700;">Phone: {{ session()->get('company_phone') }}</p>
                                          <p class="mb-0" style="color:black; font-weight: 700;">Email: {{ session()->get('company_email') }}</p>
                                    
                                        </div>
                                        <div class="text-center text-sm-right">
                                          <button class="btn btn-info" onclick="printInvoice()">Print <i class="fa fa-print"></i></button>
                                          <br/>
                                          <div><small style="color:black; font-weight: 700;">Address: 
                                            {{ session()->get('company_address') }}</small></div>
                                          <div><small style="color:black; font-weight: 999; font-size:16px;">NTN: {{ session()->get('company_ntn') }}</small></div>
                                        </div>
                                      </div>
                                    </div>
                                    <script>
                                      function printInvoice()
                                      {
                                        document.querySelector('.btn-info').style.display='none';
                                        window.print();
                                      }
                                    </script>




                                    <h3 class="text-center"><u>Purchase Tax Invoice</u></h3>
                                    <p class="text-right"><i><b>Date:</b>
                                            {{ date('d/m/Y', Strtotime($newsale_detail[0]->date)) }}</i></p>
                                    <p class="text-right" style="margin-top:-20px"><i><b>PO.No:</b>
                                            {{ $newsale_detail[0]->p_order }}</i></p>
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <h5>To: {{ session()->get('company_name') }}</h5>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <h5 class="text-right">Invoice No:
                                                {{ $newsale_detail[0]->invoice_no }}</h5>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <h5 class="text-left">Address:
                                                {{ $newsale_detail[0]->parties->address }}</h5>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <h5 class="text-right">NTN: {{ $newsale_detail[0]->parties->ntn }}
                                            </h5>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <h5 class="text-left">Del Challan: {{ $newsale_detail[0]->dcn_no }}
                                            </h5>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <h5 class="text-right">Phone No:
                                                {{ $newsale_detail[0]->parties->phone }}</h5>
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
                                        @foreach ($newsale_detail[0]->purchasetax_details as $details)
                                            <tr style="text-align: center;">
                                                <td
                                                    style="width:50px;">
                                                    <center>{{ $details->products->product_name }}</center>
                                                </td>
                                                <td
                                                    style="width:50px;">
                                                    <center>{{ number_format($details->quantity) }}</center>
                                                </td>
                                                <td
                                                    style="width:30px;">
                                                    {{ number_format($details->rate) }}</td>
                                                <td
                                                    style="width:100px;">
                                                    <center>
                                                        <?php ?>
                                                        {{ number_format($details->price) }}</center>
                                                </td>
                                                <td
                                                    style="width:30px;">
                                                    <center>{{ number_format($details->stvalue) }}</center>
                                                </td>
                                                <td
                                                    style="width:30px;">
                                                    <center>{{ number_format($details->taxvalue) }}</center>
                                                </td>

                                                <td
                                                    style="width:30px;">
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

                                        @if (isset($newsale_detail[0]->purchasetax_details))
                                            @if (count($newsale_detail[0]->purchasetax_details) > 5)
                                                @for ($i = 0; $i < 10; $i++)
                                                    <tr>
                                                        <td
                                                            style="width:50px;">
                                                            <center>-</center>
                                                        </td>
                                                        <td
                                                            style="width:50px;">
                                                            <center></center>
                                                        </td>
                                                        <td
                                                            style="width:340px;">
                                                            <center></center>
                                                        </td>
                                                        <td
                                                            style="width:100px;">
                                                            <center></center>
                                                        </td>
                                                        <td
                                                            style="width:100px;">
                                                            <center></center>
                                                        </td>
                                                        <td
                                                            style="width:100px;">
                                                            <center></center>
                                                        </td>
                                                        <td
                                                            style="width:100px;">
                                                            <center></center>
                                                        </td>
                                                    </tr>
                                                @endfor
                                            @else
                                                @for ($i = 0; $i < 15; $i++)
                                                    <tr>
                                                        <td
                                                            style=" width:50px;">
                                                            <center>-</center>
                                                        </td>
                                                        <td
                                                            style="width:50px;">
                                                            <center></center>
                                                        </td>
                                                        <td
                                                            style="width:340px;">
                                                            <center></center>
                                                        </td>
                                                        <td
                                                            style="width:100px;">
                                                            <center></center>
                                                        </td>
                                                        <td
                                                            style="width:100px;">
                                                            <center></center>
                                                        </td>
                                                        <td
                                                            style="width:100px;">
                                                            <center></center>
                                                        </td>
                                                        <td
                                                            style="width:100px;">
                                                            <center></center>
                                                        </td>
                                                    </tr>
                                                @endfor
                                            @endif
                                        @endif


                                        <tr style="background: grey;">
                                            <td style="border:2px solid black!important; width:50px;">
                                                <center>
                                                    @if ($newsale_detail[0]->sale_type == 'Credit Sale')
                                                        Payment Due Date:
                                                        <u>{{ date('d/m/Y', strtotime($newsale_detail[0]->due_date)) }}</u>
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
                                            <h5 class="text-center" style="border: 2px solid black;padding:5px;">
                                                Total Tax: {{ number_format($STValue) }}</h5>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-lg-3 col-md-3 col-sm-12"></div>
                                        <div class="col-lg-3 col-md-3 col-sm-12"></div>
                                        <div class="col-lg-3 col-md-3 col-sm-12">
                                            <span>&emsp;&emsp;&emsp;</span><br>
                                            <hr style="float:left;width:200px;background:black;margin-top:0px;">
                                            <br>
                                            <span style="position: relative;top:-10px;font-weight:bold">Signature</span>
                                        </div>
                                        <div class="col-lg-3 col-md-3 col-sm-12">
                                            <br>
                                            <hr style="float:left;width:200px;background:black;margin-top:0px;">
                                            <br>
                                            <span style="position: relative;top:-10px;font-weight:bold">Name &
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
    @include('include.powerdby2')
</body>

</html>
