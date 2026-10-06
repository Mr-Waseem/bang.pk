<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Invoice</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet"> -->
    
    <style>
        body {
            background-color: #f0f0f0;
            font-family: 'Courier New', Courier, monospace; /* Thermal printers usually use monospaced fonts */
            font-size: 13px;
            color: #000;
        }

        #receipt {
            width: 380px; /* Standard 80mm width */
            background: #fff;
            margin: 20px auto;
            padding: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .header-logo {
            text-align: center;
        }

        .header-logo-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            min-height: 72px;
            padding: 10px 14px;
            border: 1px dashed #999;
            border-radius: 8px;
            background: #fcfcfc;
        }

        .header-logo-box img {
            max-width: 230px;
            max-height: 62px;
            width: auto;
            height: auto;
            object-fit: contain;
        }

        .header-company-name {
            margin-top: 8px;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: 0.3px;
            text-transform: uppercase;
        }

        .header-company-sub {
            margin-top: 4px;
            font-size: 12px;
            font-weight: 700;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }

        .dashed-line {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .info-table, .items-table {
            width: 100%;
            margin-bottom: 5px;
        }

        .items-table th {
            border-bottom: 1px solid #000;
            /* padding: 5px 0; */
            text-align: left;
        }

        .items-table td {
            padding: 3px 0;
            vertical-align: top;
        }

        .totals-section {
            width: 100%;
            font-size: 15px;
        }

        .footer-info {
            font-size: 12px;
            line-height: 1.4;
            margin-top: 15px;
        }

        .bottom-logos {
            display: flex;
            justify-content: space-around;
            align-items: center;
            margin-top: 20px;
            padding: 0 20px;
        }

        .bottom-logos img {
            height: 60px;
            object-fit: contain;
            filter: grayscale(100%);
        }

        .qr-code {
            height: 60px !important;
            filter: grayscale(100%);
        }

        /* Print Settings */
        @media print {
            body { background: none; }
            #receipt { margin: 0; box-shadow: none; width: 100%; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>

<div id="receipt">
    <!-- Brand Logo Section -->
    <div class="header-logo">
        @if(!empty($company->company_logo ?? null))
        <div class="header-logo-box">
            <img src="{{ asset($company->company_logo) }}" alt="{{ session()->get('company_name') }}">
        </div>
        @endif
        @php
            $headerName = $company->CompanyName ?? session()->get('company_name');
            $headerSystem = $company->system_type ?? session()->get('system_type');
            $headerNtn = $company->ntn ?? session()->get('company_ntn');
        @endphp
        <div class="header-company-name">
            @if(auth()->id() == 637) 
                Service Provider:
            @endif
            {{ $headerName }} 
        </div>
        <div class="header-company-sub">NTN # {{ $headerNtn }}</div>
    </div>
    
    <!-- Bill Details -->
    <div class="d-flex justify-content-between mt-3 fw-bold">
        <div>
            Bill # [ {{ ($company->invoiceno_prefix ?? '') }}{{$newsale_detail[0]->invoice_no}} ]<br>
            <!-- Table # [  ] -->
        </div>
        <div class="text-end p-0">
            Date [ {{date("d-M-y", strtotime($newsale_detail[0]->date))}}]<br>
            Time [ {{ \Carbon\Carbon::parse($newsale_detail[0]->created_at)->format('h:i:s A') }} ]
        </div>
    </div>
    @if($newsale_detail[0]->dcn_no || $newsale_detail[0]->p_order || $newsale_detail[0]->remarks)
    <div class="mt-1 fw-bold" style="font-size: 11px;">
        @if($newsale_detail[0]->dcn_no)
        DC No: {{ $newsale_detail[0]->dcn_no }}<br>
        @endif
        @if($newsale_detail[0]->p_order)
        PO No: {{ $newsale_detail[0]->p_order }}<br>
        @endif
        @if($newsale_detail[0]->remarks)
        Remarks: {{ $newsale_detail[0]->remarks }}
        @endif
    </div>
    @endif

    <!-- Items Table -->
    <table class="items-table mt-2">
        <thead>
            <tr>
                <th style="width: 10%;">No</th>
                <th style="width: 50%;">Description</th>
                <th style="width: 10%;">Qty</th>
                <th style="width: 15%;">Rate</th>
                <th style="width: 15%; text-align: right;">Amnt</th>
            </tr>
        </thead>
        <tbody>
             @php
                //  $sum = 1;
                $quan = 0;
                $rate = 0;
                $price=0;
                $discount=0;
                $ValueExcTax = 0;
                $STValue = 0;
                $amount = 0;
               
                @endphp
                @foreach ($newsale_detail[0]->saletax_details as $value)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{ $value->products->product_name  }}</td>
                <td>{{ number_format($value->quantity) }}</td>
                <td>{{ number_format($value->rate) }}</td>
                <td class="text-end">{{ number_format($value->price) }}</td>
            </tr>
            @php
                    $quan = $quan + $value->quantity;
                    $rate = $rate + $value->rate;
                    $price = $price + $value->price;
                    $discount = $discount + $value->discount_value;
                    $ValueExcTax = $ValueExcTax + $value->quantity * $value->rate;
                    $STValue = $STValue + $value->taxvalue;
                    $amount = $amount + $value->total;
                // $sum = $sum + 1;
                @endphp
           @endforeach
        </tbody>
    </table>

    <!-- Totals Section -->
    <div class="totals-section mt-2">
        <div class="d-flex justify-content-between">
            <span class="bold">Grand Total</span>
            <span class="bold">{{number_format($ValueExcTax)}}</span>
        </div>
        <div class="d-flex justify-content-between">
            <span class="bold">GST</span>
            <span class="bold">{{number_format($STValue)}}</span>
        </div>
        @if($discount > 0)
         <div class="d-flex justify-content-between">
            <span class="bold">Discount</span>
            <span class="bold">{{number_format($discount)}}</span>
        </div>
        @endif
        <!-- <div class="d-flex justify-content-between">
            <span class="bold">FBR Tax</span>
            <span class="bold">1</span>
        </div> -->
        <div class="d-flex justify-content-between">
            <span class="bold">Net Amount</span>
            <span class="bold">{{number_format($amount)}}</span>
        </div>
        <!-- <div class="d-flex justify-content-between">
            <span class="bold">Received</span>
            <span class="bold">8,133</span>
        </div> -->
    </div>

    <!-- Payment & Info Section -->
    <div class="text-center mt-4">
        <!-- <p class="bold mb-1">Payment Mode [Cash]</p>
        <p class="bold mb-3">Covers [ 1 ]</p> -->
        
        <div class="footer-info">
            {{session()->get('company_name')}}<br>
            {{session()->get('company_address')}}<br><br>
            We Look Forward To Welcome You Again<br><br>
            PH: {{session()->get('company_phone')}}<br><br>
            @if($newsale_detail[0]->fbr_invoice_no)
             {{session()->get('system_type')}} Invoice No {{ $newsale_detail[0]->fbr_invoice_no }}
            @endif
        </div>
    </div>

    <!-- Bottom Logos Section -->
     @if($newsale_detail[0]->fbr_invoice_no)
    <div class="bottom-logos">
        <!-- PRA Logo -->
        <img src="{{asset('upload/pra.jpg')}}" alt="PRA Logo">
        
        <!-- QR Code Placeholder (Standard for POS) -->
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data={{ $newsale_detail[0]->fbr_invoice_no }}" class="qr-code" alt="QR Code">
        
        <!-- FBR POS Logo -->
        <img src="{{asset('upload/fbrpos.jpg')}}" alt="FBR POS Logo">
    </div>
    @endif
     <div class="text-center mt-4">
        <!-- <p class="bold mb-1">Payment Mode [Cash]</p>
        <p class="bold mb-3">Covers [ 1 ]</p> -->
        
        <div class="footer-info">
        <b>Digital Invoicing POS Software</b><br/>
        <b>Bang.pk | +92 321 4197290</b>
        </div>
    </div>
</div>
</body>
</html>