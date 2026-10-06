@php
    $sale = $newsale_detail[0];
    $thermal = in_array($company->bill_type, ['Thermal', 'Thermal2'], true) && !isset($showDiscount);
    $gross = $sale->saletax_details->sum('price');
    $tax = $sale->saletax_details->sum('taxvalue');
    $discount = $sale->saletax_details->sum('discount_value') + $sale->discount_amount;
    $net = $sale->saletax_details->sum('total') - $sale->discount_amount;
    $srbInvoiceId = $sale->fbr_invoice_no;
    $qrUrl = $srbInvoiceId ? \App\Services\SrbPosClient::verificationUrl($srbInvoiceId) : null;
    $qrImage = $qrUrl ? \App\Services\SrbPosClient::qrImage($qrUrl) : null;
@endphp
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><title>SRB Invoice {{ ($company->invoiceno_prefix ?? '') }}{{ $sale->invoice_no }}</title>
<style>
    @page { margin: 22px; }
    body { font-family: DejaVu Sans, Arial, sans-serif; color:#111; font-size:12px; margin:20px auto; max-width: {{ $thermal ? '280px' : '760px' }}; }
    h1 { font-size:20px; margin:8px 0; } h2 { font-size:16px; }
    .center { text-align:center; } .notice { border:2px solid #222; padding:10px; margin:12px 0; font-weight:bold; }
    table { width:100%; border-collapse:collapse; margin-top:14px; } th, td { padding:7px 3px; border-bottom:1px solid #ddd; text-align:left; }
    .number { text-align:right; } .totals { margin-left:auto; width:{{ $thermal ? '100%' : '55%' }}; }
    .qr { page-break-inside:avoid; text-align:center; margin:18px 0; } .qr img { width: {{ $thermal ? '140px' : '160px' }}; height:auto; }
    .muted { color:#555; }
    @media print { .print-button { display:none; } body { margin:0 auto; } }
</style></head><body>
<div class="center"><h1>{{ $company->CompanyName }}</h1>
<div>{{ $company->address }}</div><div>NTN: {{ $company->ntn }} | POS: {{ $company->pos_id }}</div></div>
@if($company->invoice_type !== 'Live')<div class="notice center">TEST INVOICE - NOT A LIVE SRB INVOICE</div>@endif
@if($srbInvoiceId)<div class="notice center">SRB Invoice No: {{ $srbInvoiceId }}</div>@endif
<h2>Sales Tax Invoice {{ ($company->invoiceno_prefix ?? '') }}{{ $sale->invoice_no }}</h2>
<div>Date: {{ $sale->date }}</div>
<div>Customer: {{ $sale->parties->party_name ?? 'N/A' }}</div>
<div>Payment: Cash</div>
<table><thead><tr><th>Description</th><th class="number">Qty</th><th class="number">Rate</th><th class="number">Amount</th></tr></thead><tbody>
@foreach($sale->saletax_details as $line)
<tr><td>{{ $line->products->product_name ?? 'Item' }}<br><small class="muted">Tax {{ $line->stvalue }}%: {{ number_format($line->taxvalue, 2) }}</small></td><td class="number">{{ $line->quantity }}</td><td class="number">{{ number_format($line->rate, 2) }}</td><td class="number">{{ number_format($line->total, 2) }}</td></tr>
@endforeach
</tbody></table>
<table class="totals">
<tr><td>Sale value</td><td class="number">{{ number_format($gross, 2) }}</td></tr>
<tr><td>Sales tax</td><td class="number">{{ number_format($tax, 2) }}</td></tr>
<tr><td>Discount</td><td class="number">{{ number_format($discount, 2) }}</td></tr>
<tr><th>Net amount (PKR)</th><th class="number">{{ number_format($net, 2) }}</th></tr>
</table>
@if($qrImage)
<div class="qr">
    <img src="{{ $qrImage }}" alt="SRB Invoice QR">
    <div class="muted">Scan to verify on SRB</div>
</div>
@endif
<p class="center">Thank you</p>
</body></html>
