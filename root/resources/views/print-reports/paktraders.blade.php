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
        /* print-friendly container */
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
        /* QR/FBR layout */
        .qr-section { display: flex; justify-content: space-between; align-items: center; gap: 20px; margin: 10px 0; }
        .qr-section .qr img { width: 130px; height: auto; display: block; }
        .qr-section .fbr img { max-height: 120px; height: auto; display: block; }
        @media print { @page { size: auto; margin: 5mm; } body { background-color: white; font-size: 12px; } .container { max-width: 100%; margin: 0; padding: 10px; box-shadow: none; border: none; } .print-controls { display: none; } .invoice-table { page-break-inside: avoid; } }
    </style>
</head>

<body>
    @if (isset($sales_tax_detail))
        @if (count($sales_tax_detail) > 0)
            @include('print-reports.partials.toolbar', ['printLabel' => 'Print <i class="fa fa-print"></i>'])
            @foreach ($sales_tax_detail as $value)
                @php $newsale_detail = [$value]; $company_detail = [$sellerCompany]; @endphp

                <div class="container">
                    {{-- content copied from salestax/paktraders.blade.php (uses $newsale_detail[0], $sellerCompany) --}}
                    @if(!empty($sellerCompany->company_logo))
                    <div style="display: flex; width: 100%;">
                        <div style="flex: 1; padding: 15px; margin-right: 10px;">
                            <div style="font-size: 34px; font-weight: bold; margin-bottom: 10px;">
                                @if(auth()->id() == 637)
                                    Service Provider:
                                @endif
                                {{ $sellerCompany->CompanyName }}
                            </div>
                            <div style="font-size: 16px; margin-bottom: 5px;"><strong>NTN:</strong> {{ $sellerCompany->ntn }}</div>
                            <div style="font-size: 16px; color: #000000;"><b>Address</b>: {{ $sellerCompany->address }}</div>
                        </div>
                        <div style="flex-shrink: 0; padding: 15px; display: flex; align-items: center;">
                            <img src="{{ asset($sellerCompany->company_logo) }}" alt="{{ $sellerCompany->CompanyName }}" style="max-width: 220px; max-height: 110px; object-fit: contain;">
                        </div>
                    </div>
                    @if($sellerCompany->invoice_qrcode == 1 && $newsale_detail[0]->fbr_invoice_no != null)
                    <div class="qr-section">
                        <div class="fbr">
                            <img src="{{ asset('root/upload/logo/fbrlogo.jpg') }}" alt="FBR Logo" />
                        </div>
                        <div class="qr" style="text-align:center;">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ $newsale_detail[0]->fbr_invoice_no }}&size=150x150" alt="QR Code" />
                            <div style="font-size: 16px; margin-top: 6px; font-weight: bold;">FBR Invoice No: {{ $newsale_detail[0]->fbr_invoice_no }}</div>
                        </div>
                    </div>
                    @endif
                    <div class="header"><div class="invoice-title">SALES TAX INVOICE</div></div>
                    @else
                    <div style="display: flex; width: 100%;">
                        <div style="flex: 1; padding: 15px; border-right: 2px solid; margin-right: 10px;">
                            <div style="font-size: 34px; font-weight: bold; margin-bottom: 10px;">{{ $sellerCompany->CompanyName }}</div>
                            <div style="font-size: 16px; margin-bottom: 5px;"><strong>NTN:</strong> {{ $sellerCompany->ntn }}</div>
                            <div style="font-size: 16px; color: #000000;"><b>Address</b>: {{ $sellerCompany->address }}</div>
                        </div>
                        @if($sellerCompany->invoice_qrcode == 1 && $newsale_detail[0]->fbr_invoice_no != null)
                        <div style="flex: 1; padding: 15px; margin-left: 10px;">
                            <div class="qr-section">
                                <div class="fbr">
                                    <img src="{{ asset('root/upload/logo/fbrlogo.jpg') }}" alt="FBR" />
                                </div>
                                <div class="qr" style="text-align:center;">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ $newsale_detail[0]->fbr_invoice_no }}&size=150x150" alt="QR" />
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="header"><div class="invoice-title">SALES TAX INVOICE</div></div>
                    @endif

                    <div class="invoice-details">
                        <div class="customer-info">
                            <div class="buyer-title"><strong>@if(auth()->id() == 637)Service Recipient:@else Buyer:@endif</strong> {{ $newsale_detail[0]->parties->party_name }} @if($newsale_detail[0]->customer_name) || Name: {{ $newsale_detail[0]->customer_name}} @endif</div>
                            <div class="buyer-info"><strong>Address:</strong> <span>{{ $newsale_detail[0]->parties->address }}<span></div>
                            <div class="buyer-info"><strong>NTN:</strong>  <span>{{ $newsale_detail[0]->parties->ntn }} @if($newsale_detail[0]->customer_name) || CNIC: {{ $newsale_detail[0]->customer_cnic}} @endif</span></div>
                        </div>
                        <div class="invoice-meta">
                            <div class="buyer-info"><strong>Invoice No.:</strong> {{ $sellerCompany->invoiceno_prefix}}{{ $newsale_detail[0]->invoice_no }}</div>
                            <div class="buyer-info"><strong>Invoice Date:</strong> {{ date('d/m/Y', Strtotime($newsale_detail[0]->date)) }}</div>
                            @if($newsale_detail[0]->p_order)
                            <div class="buyer-info"><strong>P.O. No:</strong> {{ $newsale_detail[0]->p_order }}</div>
                            @endif
                            @if($newsale_detail[0]->dcn_no)
                            <div class="buyer-info"><strong>DC No:</strong> {{ $newsale_detail[0]->dcn_no }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="table-container">
                        <table class="invoice-table">
                            <thead>
                                <tr>
                                    <th rowspan="2">Sr.No.</th>
                                    <th rowspan="2">HS.Code</th>
                                    <th rowspan="2" style="text-align:left !important;">Product Description</th>
                                    @if($sellerCompany->show_unit == 1)
                                    <th rowspan="2">Unit</th>
                                    @endif
                                    <th rowspan="2">Qty.</th>
                                    <th rowspan="2">Rate</th>
                                    <th rowspan="2">Exc Value</th>
                                    <th colspan="2">Sales Tax</th>
                                    <th rowspan="2">F.Tax</th>
                                    <th rowspan="2">Inclusive<br/>Value</th>
                                </tr>
                                <tr>
                                    <th>Rate%</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sum = 1; $quantity = 0; $rate = 0; $ValueExcTax = 0; $STValue = 0; $ExtraSTValue = 0; $discount1 = 0; $discount2 = 0; $amount = 0; ?>
                                @foreach ($newsale_detail[0]->saletax_details as $details)
                                    <tr>
                                        <td>{{ $sum }}</td>
                                        <td>@if ($details->products){{ $details->products->product_code }}@endif</td>
                                        <td style="text-align:left;">@if ($details->products){{ $details->products->product_name }}@endif @if($sellerCompany->id != 99)<br/>@if($details->remarks){{ $details->remarks }}@endif @endif</td>
                                        @if($sellerCompany->show_unit == 1)
                                        <td>{{ $details->fbr_uom_desc }}</td>
                                        @endif
                                        <td>{{ rtrim(number_format($details->quantity, 4), '0') }}</td>
                                        <td>{{ rtrim(number_format($details->rate, 4), '0') }}</td>
                                        <td>{{ number_format($details->price, 2) }}</td>
                                        <td>{{ number_format($details->stvalue, 2) }}</td>
                                        <td>{{ number_format($details->taxvalue, 2) }}</td>
                                        <td>{{ number_format($details->extraTaxValue, 2) }}</td>
                                        <td style="text-align:right;">{{ number_format($details->total, ($details->total == (int)$details->total ? 0 : 2)) }}</td>
                                    </tr>
                                    <?php
                                    $quantity = $quantity + $details->quantity;
                                    $rate = $rate + $details->rate;
                                    $ValueExcTax = $ValueExcTax + $details->quantity * $details->rate;
                                    $STValue = $STValue + $details->taxvalue;
                                    $ExtraSTValue = $ExtraSTValue + $details->extraTaxValue;
                                    $discount1 = $discount1 + $details->discount_value;
                                    $discount2 = $discount2 + $details->discount2_value;
                                    $amount = $amount + $details->total;
                                    $sum = $sum + 1;
                                    ?>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    @if($sellerCompany->show_unit == 1)
                                    <td colspan="4"><strong>Total</strong></td>
                                    @else
                                    <td colspan="3"><strong>Total</strong></td>
                                    @endif
                                    <td><strong>{{ number_format($quantity, ($quantity == (int)$quantity ? 0 : 2)) }}</strong></td>
                                    <td></td>
                                    <td><strong>{{ number_format($ValueExcTax) }}</strong></td>
                                    <td></td>
                                    <td><strong>{{ number_format($STValue)}}</strong></td>
                                    <td><strong>{{ number_format($ExtraSTValue) }}</strong></td>
                                    <td><strong>{{ number_format($amount) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="total-section">
                        <div class="two-column-layout">
                            <div class="column remarks-column" style="float:left;"><strong>Remarks:</strong> {{ $newsale_detail[0]->remarks }}</div>
                            <div class="column totals-column"><div class="total-row"><div class="total-label">Total Exc SaleTax:</div><div class="total-value net-total">{{ number_format($ValueExcTax) }}</div></div></div>
                        </div>
                    </div>

                    <div class="total-section"><div class="total-row"><div class="total-label">SalesTax:</div><div class="total-value net-total">{{ $STValue == 0 ? 'Exempt or Zero Rated' : number_format($STValue) }}</div></div></div>
                    @if($ExtraSTValue > 0)
                    <div class="total-section"><div class="total-row"><div class="total-label">Fur.SalesTax:</div><div class="total-value net-total">{{ number_format($ExtraSTValue) }}</div></div></div>
                    @endif

                    @if($newsale_detail[0]->total_income_tax > 0)
                    <div class="total-section"><div class="total-row"><div class="total-label">Advance Income Tax 236G/236H:</div><div class="total-value net-total">{{ number_format($newsale_detail[0]->total_income_tax) }}</div></div></div>
                    @endif
                    @if($discount1 > 0 || $discount2 > 0)
                    <div class="total-section"><div class="total-row"><div class="total-label">Discount:</div><div class="total-value net-total">{{ number_format($discount1+$discount2, 2) }}</div></div></div>
                    @endif
                    <div class="total-section"><div class="total-row"><div class="total-label">Total Amount:</div><div class="total-value net-total">{{ number_format($amount + $newsale_detail[0]->total_income_tax) }}</div></div></div>

                    <div class="amount-in-words"><strong>Amount in Words:</strong> {{ NumConvert::word($amount) }} Only /--</div>

                    @if($sellerCompany->invoice_qrcode == 0)
                        @if($newsale_detail[0]->fbr_invoice_no != null)
                            <div class="qr-section">
                                <div class="qr"><p><strong>FBR Invoice No:</strong> {{ $newsale_detail[0]->fbr_invoice_no }}</p><img id="barcode" src="https://api.qrserver.com/v1/create-qr-code/?data={{ $newsale_detail[0]->fbr_invoice_no }}&amp;size=150x150" alt="FBR Invoice QR Code" /></div>
                                <div class="fbr"><img src="{{ asset('root/upload/logo/fbrlogo.jpg') }}" alt="FBR Logo" /></div>
                            </div>
                        @endif
                    @endif

                    <div class="footer"><p>This is an electronically generated invoice and is valid without a signature.</p></div>
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
