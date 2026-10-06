<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sales Tax Invoice</title>
    <link rel="stylesheet" href="{{ asset('bootstrap4/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        p{ color: #000000; }
        body { margin: 0; padding: 0; font-family: 'Roboto', sans-serif; color: #000000; font-size: 14px; line-height: 1.5; background-color: #f5f5f5; }
        .container { max-width: 820px; margin: 20px auto; padding: 22px; background-color: white; box-shadow: 0 0 6px rgba(0,0,0,0.06); border: 1px solid #e6e6e6; }
        .print-controls { margin-bottom: 20px; padding: 10px; background-color: #f8f9fa; border: 1px solid #000000; border-radius: 4px; display: flex; justify-content: space-between; align-items: center; }
        .header { text-align: center; margin-bottom: 10px; border-bottom: 2px solid #2c3e50; }
        .company-name { font-size: 30px; font-weight: 700; color: #000000ff; }
        .invoice-title { font-size: 18px; font-weight: 700; background-color: #f8f9fa; padding: 10px 20px; border-radius: 4px; display: inline-block; margin: 15px 0; border: 1px solid #000000; }
        .ntn { font-size: 18px; color: #000000; font-weight: bolder; }
        .address{ font-size: 16px; }
        .invoice-details { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .customer-info { width: 65%; padding: 5px; border: 1px solid #000000; border-radius: 4px; background-color: #f8f9fa; }
        .buyer-title{ font-size: 20px; }
        .buyer-info{ font-size: 16px; }
        .invoice-meta { width: 32%; padding: 5px; border: 1px solid #000000; border-radius: 4px; background-color: #f8f9fa; }
        .table-container { margin-bottom: 10px; border: 1px solid #000000; border-radius: 4px; overflow: hidden; }
        .invoice-table { width: 100%; border-collapse: collapse; }
        .invoice-table th { color: #000000; text-align: center; border: 1px solid #444; font-size: 16px; }
        .invoice-table td { border: 1px solid #000000; text-align: center; color: #000000; }
        .invoice-table td:nth-child(2) { text-align: left; }
        .invoice-table td:nth-child(4), .invoice-table td:nth-child(5), .invoice-table td:nth-child(6), .invoice-table td:nth-child(7), .invoice-table td:nth-child(8), .invoice-table td:nth-child(9), .invoice-table td:nth-child(10) { text-align: right; }
        .invoice-table tfoot td { font-weight: 600; background-color: #f8f9fa; border-top: 2px solid #2c3e50; }
        .total-section { text-align: right; }
        .amount-in-words { margin-top: 10px; padding: 5px; border: 1px solid #000000; border-radius: 4px; text-transform: capitalize; font-size: 16px; }
        .footer { margin-top: 10px; text-align: center; border-top: 1px solid #000000; padding-top: 10px; color: #000000; font-size: 16px; }
        .empty-row td { height: 20px; }
        .qr-section { display:flex; justify-content: space-between; align-items: center; gap: 20px; margin: 10px 0; }
        .qr-section .qr img { width: 130px; height: auto; display: block; }
        .qr-section .fbr img { max-height: 120px; height: auto; display: block; }
        @media print { @page { size: auto; margin: 5mm; } body { background-color: white; font-size: 12px; } .container { max-width: 100%; margin: 0; padding: 10px; box-shadow: none; border: none; } .print-controls { display: none; } .invoice-table { page-break-inside: avoid; } }
    </style>
</head>
<body>
    @if (isset($sales_tax_detail))
        @if (count($sales_tax_detail) > 0)
            @include('print-reports.partials.toolbar', ['printLabel' => 'Print <i class="fa fa-print"></i>'])
            @foreach($sales_tax_detail as $value)
                @php $newsale_detail = [$value]; $company_detail = [$sellerCompany]; @endphp

                <div class="container">
                    {{-- content copied from salestax/spi.blade.php body (uses $newsale_detail[0], $sellerCompany) --}}
                    @if(!empty($sellerCompany->company_logo))
                    <div class="header" style="border-bottom: 3px solid #2c3e50; padding-bottom: 10px; margin-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <div style="text-align: left; flex: 1;">
                                <div style="font-size: 28px; font-weight: 700; color: #1a1a1a; letter-spacing: 1px; margin-bottom: 4px;">
                                    @if(auth()->id() == 637)
                                        Service Provider:
                                    @endif
                                    {{ $sellerCompany->CompanyName}}
                                </div>
                                <div style="font-size: 15px; font-weight: 600; color: #333;">NTN/CNIC: {{ $sellerCompany->ntn}}</div>
                                <div style="font-size: 14px; color: #444; margin-top: 2px;">{{ $sellerCompany->address}}</div>
                            </div>
                            <div style="flex-shrink: 0; margin-left: 20px;">
                                <img src="{{ asset($sellerCompany->company_logo) }}" alt="{{ $sellerCompany->CompanyName }}" style="max-width: 220px; max-height: 110px; object-fit: contain;">
                            </div>
                        </div>
                        <div style="text-align: center; margin-top: 8px;">
                            <span class="invoice-title">SALES TAX INVOICE</span>
                        </div>
                    </div>
                    @else
                    <div class="header">
                        <div class="company-name">{{ $sellerCompany->CompanyName}}</div>
                        <div class="ntn">NTN/CNIC: {{ $sellerCompany->ntn}}</div>
                        <div class="address">{{ $sellerCompany->address}}</div>
                        <div class="invoice-title">SALES TAX INVOICE</div>
                    </div>
                    @endif

                    @if($newsale_detail[0]->fbr_invoice_no != null)
                    <div class="qr-section">
                        <div class="qr">
                            <img id="barcode" src="https://api.qrserver.com/v1/create-qr-code/?data={{ $newsale_detail[0]->fbr_invoice_no }}&amp;size=150x150" alt="FBR Invoice QR Code" />
                            <p><strong>FBR Invoice No: {{ $newsale_detail[0]->fbr_invoice_no }}</strong></p>
                        </div>
                        <div class="fbr">
                            <img src="{{ asset('root/upload/logo/fbrlogo.jpg') }}" alt="FBR Logo" />
                        </div>
                    </div>
                    @endif

                    <div class="invoice-details">
                        <div class="customer-info">
                            <div class="buyer-title"><strong>
                                @if(auth()->id() == 637)
                                    Service Recipient:
                                @else
                                    Buyer:
                                @endif
                            </strong> {{ $newsale_detail[0]->parties->party_name }}</div>
                            <div class="buyer-info"><strong>Address:</strong> <span>{{ $newsale_detail[0]->parties->address }}<span></div>
                            <div class="buyer-info"><strong>NTN:</strong>  <span>{{ $newsale_detail[0]->parties->ntn }}<span></div>
                            @if($newsale_detail[0]->remarks)
                            <div><strong>Remarks:</strong> {{ $newsale_detail[0]->remarks }}</div>
                            @endif
                        </div>
                        <div class="invoice-meta">
                            <div class="buyer-info"><strong>Invoice No.:</strong> {{ $newsale_detail[0]->invoice_no }}</div>
                            <div class="buyer-info"><strong>Invoice Date:</strong> {{ date('d/m/Y', Strtotime($newsale_detail[0]->date)) }}</div>
                            @if($newsale_detail[0]->dcn_no)
                            <div class="buyer-info"><strong>DC No:</strong> {{ $newsale_detail[0]->dcn_no }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="table-container">
                        <table class="invoice-table">
                            <thead>
                                <tr>
                                    <th>PO</th>
                                    <th>HS.Code</th>
                                    <th style="text-align:left !important;">Product Description</th>
                                    <th>Unit</th>
                                    <th>Qty.</th>
                                    <th>Rate</th>
                                    <th>Exc Value</th>
                                    <th colspan="2">Sales Tax</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $sr = 1; $quantity = 0; $fbrqty = 0; $ValueExcTax = 0; $STValue = 0; $amount = 0; @endphp
                                @foreach($newsale_detail[0]->saletax_details as $details)
                                    @php $quantity += $details->quantity; $ValueExcTax += $details->price; $STValue += $details->taxvalue; $amount += $details->total; @endphp
                                    <tr>
                                        <td>{{ $sr++ }}</td>
                                        <td>@if($details->products){{ $details->products->product_code }}@endif</td>
                                        <td style="text-align:left;">@if($details->products){{ $details->products->product_name }}@endif</td>
                                        <td>{{ $details->fbr_uom_desc }}</td>
                                        <td>{{ rtrim(rtrim(number_format($details->quantity, 2), '0'), '.') }} sets</td>
                                        <td style="text-align:right;">PKR{{ number_format($details->rate, 2) }}</td>
                                        <td style="text-align:right;">PKR{{ number_format($details->price, 2) }}</td>
                                        <td style="text-align:right;">{{ number_format($details->taxvalue, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="total-section">
                        <div style="text-align:right;">
                            <strong>Subtotal (Excluding GST):</strong> PKR{{ number_format($ValueExcTax,0) }}
                        </div>
                        <div style="text-align:right;">
                            <strong>GST @ 18%:</strong> PKR{{ number_format($STValue,0) }}
                        </div>
                        <div style="text-align:right; font-weight:bold;">
                            <strong>Total amount:</strong> PKR{{ number_format(round($amount - ($newsale_detail[0]->discount_amount ?? 0), 0)) }}
                        </div>
                    </div>

                    @if(!empty($newsale_detail[0]->fbr_invoice_no) || !empty($newsale_detail[0]->qr_code))
                    <div style="margin-top:20px; text-align:right;">
                        @if(!empty($newsale_detail[0]->qr_code))
                        <img src="{{ $newsale_detail[0]->qr_code }}" alt="FBR QR" style="width:78px;height:78px;">
                        @endif
                        @if(!empty($newsale_detail[0]->fbr_invoice_no))
                        <div style="font-weight:bold;">FBR Invoice No: {{ $newsale_detail[0]->fbr_invoice_no }}</div>
                        @endif
                    </div>
                    @endif

                    <div class="footer">This is an electronically generated invoice and is valid without a signature.</div>
                </div>
                <p style="page-break-after: always;"></p>
            @endforeach
        @else
            <h1>Record Not Found</h1>
        @endif
    @endif

    <script src="{{ asset('bootstrap4/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap4/popper.min.js') }}"></script>
    <script src="{{ asset('bootstrap4/bootstrap.min.js') }}"></script>
</body>
</html>
