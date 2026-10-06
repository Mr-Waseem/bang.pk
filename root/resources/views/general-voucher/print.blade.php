﻿<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GENERAL VOUCHER</title>
    <!--<link rel="stylesheet" href="{{ asset('bootstrap4/bootstrap.min.css') }}">-->
    <!--<script src="{{ asset('bootstrap4/jquery.min.js') }}"></script>-->
    <!--<script src="{{ asset('bootstrap4/popper.min.js') }}"></script>-->
    <!--<script src="{{ asset('bootstrap4/bootstrap.min.js') }}"></script>-->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">-->
    <!--<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">-->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            color: #333;
            background-color: #f8f9fa;
        }
        
        .voucher-container {
            max-width: 1000px;
            margin: 30px auto;
            background: white;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 30px;
        }
        
        .voucher-header {
            text-align: center;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #000000;
        }
        
        .voucher-title {
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 5px;
            font-size: 20px;
        }
        
        .voucher-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            background: #f8f9fa;
            padding: 5px;
            border-radius: 6px;
            border-left: 4px solid #2c3e50;
        }
        
        .info-item {
            margin-bottom: 8px;
        }
        
        .info-label {
            font-weight: 600;
            color: #000000;
        }
        
        .table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
            margin-bottom: 30px;
        }
        
        .table thead th {
            /*background-color: #2c3e50;*/
            color: black;
            font-weight: 500;
            padding: 5px 8px;
            border: none;
        }
        
        .table tbody td {
            padding: 5px 8px;
            vertical-align: top;
                font-size: 14px;
        }
        
        .table tfoot td {
            font-weight: 600;
            background-color: #f8f9fa;
            padding: 5px 8px;
        }
        
        .table-bordered thead th:not(:last-child),
        .table-bordered tbody td:not(:last-child),
        .table-bordered tfoot td:not(:last-child) {
            border: 1px solid #000000;
        }
        
        .table-bordered thead th,
        .table-bordered tbody td,
        .table-bordered tfoot td {
            border: 1px solid #000000;
        }
        
        .amount {
            text-align: right;
            font-family: 'Courier New', monospace;
            color: black;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
        }
        
        @media print {
            body {
                background: white;
            }
            .voucher-container {
                box-shadow: none;
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row flex-lg-nowrap">
            <div class="col">
                <div class="row">
                    <div class="col mb-3">
                        <div class="voucher-container">
                            <div class="voucher-header">
                                @include('include.header')
                                <h1 class="voucher-title">GENERAL VOUCHER</h1>
                            </div>
                            
                            <div class="voucher-info">
                                <div>
                                    <div class="info-item">
                                        <span class="info-label">Voucher #:</span>
                                        <span>{{ $newsale_detail[0]->voucher_no }}</span>
                                    </div>
                                </div>
                                <div>
                                    <div class="info-item">
                                        <span class="info-label">Date:</span>
                                        <span>{{ date('d/m/Y',strtotime($newsale_detail[0]->voucher_date)) }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">Sr.#</th>
                                        <th width="30%">Account Name</th>
                                        <th width="35%">Description</th>
                                        <th width="15%">Debit</th>
                                        <th width="15%">Credit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $sum = 1;
                                    $quantity = 0;
                                    $rate = 0;
                                    $ValueExcTax = 0;
                                    $STValue = 0;
                                    $debit = 0;
                                    $credit = 0; 
                                    ?>
                                    @foreach ($newsale_detail[0]->voucher_details as $details)
                                        @if ($details->credit != null)
                                            <tr>
                                                <td>{{ $sum }}</td>
                                                <td>{{ $details->parties->party_name }}</td>
                                                <td>{{ $details->narration }}</td>
                                                <td class="amount">{{ number_format($details->debit) }}</td>
                                                <td class="amount">{{ number_format($details->credit) }}</td>
                                            </tr>
                                        @endif
                                        <?php
                                        $quantity = $quantity + $details->quantity;
                                        $rate = $rate + $details->price;
                                        $ValueExcTax = $ValueExcTax + $details->quantity * $details->rate;
                                        $STValue = $STValue + $details->taxvalue;
                                        $debit = $debit + $details->debit;
                                        $credit = $credit + $details->credit;
                                        if ($details->credit != null) {
                                            $sum = $sum + 1;
                                        }
                                        ?>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" align="center"><strong>Total</strong></td>
                                        <td class="amount"><strong>{{ number_format($debit) }}</strong></td>
                                        <td class="amount"><strong>{{ number_format($credit) }}</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                            
                            <div class="footer">
                                @include('include.powerdby')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>