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
        /* Narrower container for consistent A4 printing */
        .container { max-width: 820px; margin: 20px auto; padding: 22px; background-color: white; box-shadow: 0 0 6px rgba(0,0,0,0.06); border: 1px solid #e6e6e6; }
        .print-controls { margin-bottom: 20px; padding: 10px; background-color: #f8f9fa; border: 1px solid #000000; border-radius: 4px; display: flex; justify-content: space-between; align-items: center; }
        .print-btn-group .btn { margin-left: 5px; }
        .header { text-align: center; margin-bottom: 10px; border-bottom: 2px solid #2c3e50; }
        .company-name { font-size: 45px; font-weight: 700; color: #000000ff; }
        .invoice-title { font-size: 18px; font-weight: 700; background-color: #f8f9fa; padding: 10px 20px; border-radius: 4px; display: inline-block; margin: 15px 0; border: 1px solid #000000; }
        .ntn { font-size: 18px; color: #000000; font-weight: bolder; }
        .address{ font-size: 16px; }
        .custom-heading { font-size: 16px; color: #000000; }
        .invoice-details { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .customer-info { width: 65%; padding: 5px; border: 1px solid #000000; border-radius: 4px; background-color: #f8f9fa; }
        .buyer-title{ font-size: 20px; }
        .buyer-info{ font-size: 16px; }
        .invoice-meta { width: 32%; padding: 5px; border: 1px solid #000000; border-radius: 4px; background-color: #f8f9fa; }
        .info-label { font-weight: 600; color: #555; display: inline-block; width: 100px; }
        .table-container { margin-bottom: 10px; border: 1px solid #000000; border-radius: 4px; overflow: hidden; }
        .invoice-table { width: 100%; border-collapse: collapse; }
        .invoice-table th { color: #000000; text-align: center; border: 1px solid #444; font-size: 16px; }
        .invoice-table td { border: 1px solid #000000; text-align: center; color: #000000; }
        .invoice-table td:nth-child(2) { text-align: left; }
        .invoice-table td:nth-child(4), .invoice-table td:nth-child(5), .invoice-table td:nth-child(6), .invoice-table td:nth-child(7), .invoice-table td:nth-child(8), .invoice-table td:nth-child(9), .invoice-table td:nth-child(10) { text-align: right; }
        .invoice-table tfoot td { font-weight: 600; background-color: #f8f9fa; border-top: 2px solid #2c3e50; }
        .total-section { text-align: right; }
        .total-row { display: flex; justify-content: flex-end; margin-bottom: 5px; }
        .total-label { font-weight: 600; width: 150px; text-align: right; padding-right: 15px; }
        .total-value { width: 180px; text-align: right; padding: 5px 10px; border: 1px solid #000000; border-radius: 4px; }
        .net-total { background-color: #e9f7ef; font-weight: 700; border: 1px solid #2c3e50 !important; }
        .amount-in-words { margin-top: 10px; padding: 5px; border: 1px solid #000000; border-radius: 4px; text-transform: capitalize; font-size: 16px; }
        .footer { margin-top: 10px; text-align: center; border-top: 1px solid #000000; padding-top: 10px; color: #000000; font-size: 16px; }
        .signature-section { margin-top: 60px; display: flex; justify-content: flex-end; }
        .signature-box { text-align: center; border-top: 1px solid #333; width: 250px; padding-top: 5px; color: #000000; }
        /* QR and FBR logo area: keep both images aligned without overlap */
        .qr-section { display: flex; justify-content: space-between; align-items: center; text-align: left; gap: 20px; margin: 10px 0; }
        .qr-section .qr { flex: 0 0 auto; text-align: left; }
        .qr-section .qr img { width: 130px; height: auto; display: block; }
        .qr-section .qr p { margin: 6px 0 0 0; font-size: 14px; }
        .qr-section .fbr { flex: 0 0 auto; text-align: right; }
        .qr-section .fbr img { max-height: 120px; height: auto; display: block; }
        .empty-row td { height: 20px; }
        @media print { @page { size: auto; margin: 5mm; } body { background-color: white; font-size: 12px; } .container { max-width: 100%; margin: 0; padding: 10px; box-shadow: none; border: none; } .print-controls { display: none; } .invoice-table { page-break-inside: avoid; } }
        @media print and (orientation: landscape) { body { font-size: 14px; } .container { padding: 5px; } }
    </style>
</head>

<body>
    @if (isset($sales_tax_detail))
        @if (count($sales_tax_detail) > 0)
            @include('print-reports.partials.toolbar', ['printLabel' => 'Print <i class="fa fa-print"></i>'])
            @foreach ($sales_tax_detail as $value)
                @php
                    $newsale_detail = [$value];
                    $company_detail = [$sellerCompany];
                @endphp

                <div class="container">
                    {{-- Copied container markup from salestax/invoice.blade.php (uses $newsale_detail[0], $sellerCompany) --}}
                    @if($sellerCompany->invoice_header == 1)
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
                                    <div style="font-size: 15px; font-weight: 600; color: #333;">NTN: {{ $sellerCompany->ntn}}</div>
                                    <div style="font-size: 14px; color: #444; margin-top: 2px;">{{ $sellerCompany->address}}</div>
                                    <div style="font-size: 14px; color: #444;">Tel: {{ $sellerCompany->phone}}</div>
                                    @if(!empty($sellerCompany->custom_heading))
                                    <div style="font-size: 14px; color: #555; margin-top: 2px;">{{ $sellerCompany->custom_heading }}</div>
                                    @endif
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
                            <div class="company-name">
                                @if(auth()->id() == 637)
                                Service Provider:
                                @endif
                                {{ $sellerCompany->CompanyName}}
                            </div>
                            <div class="ntn">NTN: {{ $sellerCompany->ntn}}</div>
                            <div class="address">{{ $sellerCompany->address}}</div>
                            <div class="address">Tel: {{ $sellerCompany->phone}}</div>
                            @if(!empty($sellerCompany->custom_heading))
                            <div class="custom-heading">{{ $sellerCompany->custom_heading }}</div>
                            @endif
                            <div class="invoice-title">SALES TAX INVOICE</div>
                        </div>
                        @endif
                    @else
                        <br/><br/><br/><br/><br/><br/><br/><br/>
                        <br/><br/><br/><br/><br/><br/><br/><br/>
                        <br/><br/><br/><br/><br/><br/><br/><br/>
                        <div style="float: right; font-size: 18px;font-weight: 600;">NTN: {{ $sellerCompany->ntn}}</div>
                    @endif
                    @if($sellerCompany->invoice_qrcode == 1)
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
                    @endif
                    <div class="invoice-details">
                        <div class="customer-info">
                            <div class="buyer-title"><strong>
                                @if(auth()->id() == 637)
                                    Service Recipient:
                                @else
                                    Buyer/Customer:
                                @endif
                            </strong> 
                            {{ $newsale_detail[0]->parties->party_name }}
                            @if($newsale_detail[0]->customer_name) ||
                            Name: {{ $newsale_detail[0]->customer_name}}
                            @endif
                        </div>
                            <div class="buyer-info"><strong>Address:</strong> <span>{{ $newsale_detail[0]->parties->address }}<span></div>
                            <div class="buyer-info"><strong>NTN:</strong>  <span>{{ $newsale_detail[0]->parties->ntn }}
                            @if($newsale_detail[0]->customer_name) ||
                            CNIC: {{ $newsale_detail[0]->customer_cnic}}
                            @endif
                        
                    </span></div>
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
                                    @if($sellerCompany->show_fbr_qty == 1)
                                    <th rowspan="2">Qty <br/><small style="font-size: 14px;">As Per Po</small></th>
                                    <th rowspan="2">Qty.</th>
                                    @else
                                    <th rowspan="2">Qty.</th>
                                    @endif
                                    @if(in_array($newsale_detail[0]->scenario_id, [14, 28]))
                                    <th rowspan="2">Price</th>
                                    @endif
                                    <th rowspan="2">{{ in_array($newsale_detail[0]->scenario_id, [14, 28]) ? 'Retail Price' : 'Rate' }}</th>
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
                                <?php
                                $sum = 1;
                                $quantity = 0;
                                $fbrqty = 0;
                                $rate = 0;
                                $ValueExcTax = 0;
                                $STValue = 0;
                                $ExtraSTValue = 0;
                                $totalRowDiscount = 0;
                                $amount = 0;
                                ?>
                                @foreach ($newsale_detail[0]->saletax_details as $details)
                                    <tr>
                                        <td>{{ $sum }}</td>
                                        <td>
                                            @if ($details->products)
                                                {{ $details->products->product_code }}
                                            @endif
                                        </td>
                                        <td style="text-align:left;">
                                            @php
                                                $productName = optional($details->products)->product_name;
                                            @endphp
                                            @if($productName && $productName != ".")
                                                {{ $productName }}
                                            @endif
                                            @if($sellerCompany->id != 99)
                                                @if($productName && $productName != ".")
                                                <br/>
                                                @endif
                                                @if($details->remarks)
                                                    {{ $details->remarks }}
                                                @endif
                                            @endif
                                        </td>
                                        @if($sellerCompany->show_unit == 1)
                                        <td>{{ $details->fbr_uom_desc }}</td>
                                        @endif
                                        @if($sellerCompany->show_fbr_qty == 1)
                                        <td>{{ rtrim(rtrim(number_format($details->quantity, 4), '0'), '.') }}</td>
                                        <td>
                                            @if($details->fbr_qty)
                                            {{ rtrim(rtrim(number_format($details->fbr_qty, 4), '0'), '.') }}
                                            @php $fbrqty = $fbrqty + $details->fbr_qty; @endphp
                                            @endif
                                        </td>
                                        @else
                                        <td>{{ rtrim(rtrim(number_format($details->quantity, 4), '0'), '.') }}</td>
                                        @endif

                                        @if(in_array($newsale_detail[0]->scenario_id, [14, 28]))
                                        <td>{{ $details->quantity > 0 ? number_format($details->price / $details->quantity, 2) : '-' }}</td>
                                        @endif
                                        <td>{{ rtrim(rtrim(number_format($details->rate, 4), '0'), '.') }}</td>
                                        <td>{{ number_format($details->price, 2) }}</td>
                                        <td>{{ number_format($details->stvalue, 2) }}</td>
                                        <td>{{ number_format($details->taxvalue, 2) }}</td>
                                        <td>{{ number_format($details->extraTaxValue, 2) }}</td>
                                        <td style="text-align:right;">{{ number_format($details->total, ($details->total == (int)$details->total ? 0 : 2)) }}</td>
                                    </tr>
                                    <?php
                                    $quantity = $quantity + $details->quantity;
                                    $rate = $rate + $details->rate;
                                    $ValueExcTax = $ValueExcTax + $details->price;
                                    $STValue = $STValue + $details->taxvalue;
                                    $ExtraSTValue = $ExtraSTValue + $details->extraTaxValue;
                                    $rowBaseValue = floatval($details->price) + floatval($details->taxvalue) + floatval($details->extraTaxValue);

                                    $dv = floatval($details->discount_value) + floatval($details->discount2_value);
                                    if ($dv > 0 && $dv <= $rowBaseValue) {
                                        $rowDisc = $dv;
                                    } elseif ((floatval($details->discount) + floatval($details->discount2)) > 0) {
                                        $fb = floatval($details->discount) + floatval($details->discount2);
                                        $rowDisc = ($fb <= $rowBaseValue) ? $fb : 0;
                                    } else {
                                        $rowDisc = $rowBaseValue - floatval($details->total);
                                    }

                                    $totalRowDiscount = $totalRowDiscount + max($rowDisc, 0);
                                    $amount = $amount + $details->total;
                                    $sum = $sum + 1;
                                    ?>
                                @endforeach

                                @if (isset($newsale_detail[0]->saletax_details))
                                    @if (count($newsale_detail[0]->saletax_details) > 5)
                                        @for ($i = 0; $i < 10 - count($newsale_detail[0]->saletax_details); $i++)
                                            <tr class="empty-row">
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                @if($sellerCompany->show_unit == 1)
                                                <td>&nbsp;</td>
                                                @endif
                                                @if($sellerCompany->show_fbr_qty == 1)
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                @else
                                                <td>&nbsp;</td>
                                                @endif
                                                @if(in_array($newsale_detail[0]->scenario_id, [14, 28]))
                                                <td>&nbsp;</td>
                                                @endif
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        @endfor
                                    @else
                                        @for ($i = 0; $i < 5 - count($newsale_detail[0]->saletax_details); $i++)
                                            <tr class="empty-row">
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                @if($sellerCompany->show_unit == 1)
                                                <td>&nbsp;</td>
                                                @endif
                                                @if($sellerCompany->show_fbr_qty == 1)
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                @else
                                                <td>&nbsp;</td>
                                                @endif
                                                @if(in_array($newsale_detail[0]->scenario_id, [14, 28]))
                                                <td>&nbsp;</td>
                                                @endif
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        @endfor
                                    @endif
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3"><strong>Total</strong></td>
                                    @if($sellerCompany->show_unit == 1)
                                    <td></td>
                                    @endif
                                    <td><strong>{{ number_format($quantity, ($quantity == (int)$quantity ? 0 : 2)) }}</strong></td>
                                    @if($sellerCompany->show_fbr_qty == 1)
                                    <td><strong>{{ number_format($fbrqty, ($fbrqty == (int)$fbrqty ? 0 : 2)) }}</strong></td>
                                    @endif
                                    @if(in_array($newsale_detail[0]->scenario_id, [14, 28]))
                                    <td></td>
                                    @endif
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
                            <div class="column remarks-column" style="float:left;">
                                <strong>Remarks:</strong> {{ $newsale_detail[0]->remarks }}
                            </div>
                            <div class="column totals-column">
                                <div class="total-row">
                                    <div class="total-label">Total Exc SaleTax:</div>
                                    <div class="total-value net-total">{{ number_format($ValueExcTax) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="total-section">
                        <div class="two-column-layout">
                            <div class="column totals-column">
                                <div class="total-row">
                                    <div class="total-label">SalesTax:</div>
                                    <div class="total-value net-total">{{ $STValue == 0 ? 'Exempt or Zero Rated' : number_format($STValue) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($ExtraSTValue > 0)
                    <div class="total-section">
                        <div class="two-column-layout">
                            <div class="column totals-column">
                                <div class="total-row">
                                    <div class="total-label">Fur.SalesTax:</div>
                                    <div class="total-value net-total">{{ number_format($ExtraSTValue) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($newsale_detail[0]->total_income_tax > 0)
                    <div class="total-section">
                        <div class="total-row">
                            <div class="total-label">Advance Income Tax 236G/236H:</div>
                            <div class="total-value net-total">{{ number_format($newsale_detail[0]->total_income_tax, 0) }}</div>
                        </div>
                    </div>
                    @endif
                    @php
                        $grandDiscount = floatval($newsale_detail[0]->discount_amount ?? 0);
                        $totalDiscount = $totalRowDiscount + $grandDiscount;
                    @endphp
                    @if($totalDiscount > 0)
                    <div class="total-section">
                        <div class="total-row">
                            <div class="total-label">Discount:</div>
                            <div class="total-value net-total">{{ number_format($totalDiscount, 0) }}</div>
                        </div>
                    </div>
                    @endif
                    @php 
                        $finalAmount = round($ValueExcTax + $STValue + $ExtraSTValue - $totalDiscount + floatval($newsale_detail[0]->total_income_tax)); 
                    @endphp
                    <div class="total-section">
                        <div class="total-row">
                            <div class="total-label">Total Amount:</div>
                            <div class="total-value net-total">{{ number_format($finalAmount, 0) }}</div>
                        </div>
                    </div>

                    <div class="amount-in-words">
                        <strong>Amount in Words:</strong> {{ NumConvert::word($finalAmount) }} Only /--
                    </div>

                    @if($sellerCompany->category == "Importer")
                    @php $recipientLabel = ( auth()->id() == 637) ? 'Service Recipient' : 'Buyer'; @endphp
                    <div class="amount-in-words">
                        <strong>UNDERTAKING</strong> <br/>
                            We hereby certify that the goods supplied to above mention {{ $recipientLabel }} were imported by us on which income tax has been been paid by us U/S 148
                            of the Income Tax Ordinance 2001 at import stage. We further confirm that the goods supplied are in the same condition as these were
                            imported by us. We are therefore not liable to income tax deduction U/S 153 of the Income Tax Ordinance 2001.
                    </div>
                    @endif

                    @if($sellerCompany->invoice_qrcode == 0)
                        @if($newsale_detail[0]->fbr_invoice_no != null)
                            <div class="qr-section">
                                <div class="qr">
                                    <p><strong>FBR Invoice No:</strong> {{ $newsale_detail[0]->fbr_invoice_no }}</p>
                                    <img id="barcode" src="https://api.qrserver.com/v1/create-qr-code/?data={{ $newsale_detail[0]->fbr_invoice_no }}&amp;size=150x150" alt="FBR Invoice QR Code" />
                                </div>
                                <div class="fbr">
                                    <img src="{{ asset('root/upload/logo/fbrlogo.jpg') }}" alt="FBR Logo" />
                                </div>
                            </div>
                        @endif
                    @endif

                    <div class="footer">
                        <p>This is an electronically generated invoice and is valid without a signature.</p>
                    </div>
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
