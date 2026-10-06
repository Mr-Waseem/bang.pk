<?php

namespace App\Services;

use App\Models\Companies;
use App\Models\SaleTax;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;

class SrbPosClient
{
    public const URL = 'https://pos.srb.gos.pk/ePOSGateway/v1/SalesInvoiceService.api';

    public function buildPayload(Companies $company, SaleTax $sale): array
    {
        if ($company->system_type !== 'SRB' || (int) $sale->company_id !== (int) $company->id) {
            throw new InvalidArgumentException('SRB company and invoice must match.');
        }
        $mode = $company->invoice_type === 'Live' ? 'Live' : 'Test';
        $name = trim((string) $company->CompanyName);
        $ntn = preg_replace('/^S/i', '', trim((string) $company->ntn));
        $ntn = explode('-', $ntn)[0];
        if (!ctype_digit((string) $company->pos_id) || (int) $company->pos_id < 1 || !preg_match('/^\d{7}$/', $ntn)) {
            throw new InvalidArgumentException('Set the registered SRB POS ID and seven-digit NTN in company settings.');
        }
        if ($name === '' || !$company->token || !$company->sandbox_token) {
            throw new InvalidArgumentException('Company name, SRB POS username in Live TOKEN and password in SandBox Token are required.');
        }
        if ($sale->sale_type !== 'SalesTax Invoice' || !$sale->invoice_no) {
            throw new InvalidArgumentException('This flow supports normal SRB sales invoices only.');
        }
        $details = $sale->saletax_details;
        if ($details->isEmpty()) {
            throw new InvalidArgumentException('Invoice must contain at least one line.');
        }
        $rates = $details->map(function ($line) { return (string) round((float) $line->stvalue, 4); })->unique();
        if ($rates->count() !== 1) {
            throw new InvalidArgumentException('SRB requires one tax rate per invoice. Separate mixed-rate items into different invoices.');
        }
        $gross = $tax = $lineDiscount = $lineTotal = 0;
        foreach ($details as $line) {
            foreach (['price', 'taxvalue', 'discount_value', 'total', 'stvalue', 'quantity', 'rate'] as $field) {
                if (!is_numeric($line->$field ?? 0) || !is_finite((float) $line->$field) || (float) $line->$field < 0) {
                    throw new InvalidArgumentException('SRB invoice contains an invalid or negative line amount.');
                }
            }
            if ((float) $line->quantity <= 0 || abs((float) $line->extraTaxValue) > 0.001) {
                throw new InvalidArgumentException('SRB requires positive quantities and no unmapped further tax.');
            }
            $gross += (float) $line->price;
            $tax += (float) $line->taxvalue;
            $lineDiscount += (float) $line->discount_value;
            $lineTotal += (float) $line->total;
        }
        $rate = (float) $rates->first();
        $discount = round($lineDiscount + (float) $sale->discount_amount, 2);
        $gross = round($gross, 2);
        $tax = round($tax, 2);
        $net = round($lineTotal - (float) $sale->discount_amount, 2);
        if ($gross <= 0 || $rate < 0 || $discount < 0 || $net < 0 || (float) $sale->discount_amount < 0) {
            throw new InvalidArgumentException('SRB sales value must be positive; discount and net amount cannot be negative.');
        }
        if (abs(round($gross * $rate / 100, 2) - $tax) > 0.009) {
            throw new InvalidArgumentException('Stored tax does not match SRB sales value × rate. Correct invoice amounts before submitting.');
        }
        if (abs(round($gross + $tax - $discount, 2) - $net) > 0.009) {
            throw new InvalidArgumentException('Stored total/discount does not match the SRB net amount formula. Correct the invoice before submitting.');
        }
        $party = $sale->parties;
        $optional = function ($value) { return trim((string) $value) !== '' ? (string) $value : 'N/A'; };
        // Persisted creation time makes the payload stable across later approvals.
        $date = Carbon::parse($sale->date)->format('Y-m-d') . ' ' . Carbon::parse($sale->created_at)->format('H:i:s');
        return [
            'posId' => (int) $company->pos_id,
            'name' => $name, 'ntn' => $ntn,
            'invoiceDateTime' => $date, 'invoiceType' => 1,
            'invoiceId' => (string) $sale->invoice_no,
            'rateValue' => $rate, 'saleValue' => $gross, 'taxAmount' => $tax,
            'discountAmount' => $discount, 'serviceCharges' => 0, 'extraCharges' => 0,
            'netAmount' => $net,
            'consumerName' => $optional($party->party_name ?? null),
            'consumerMobile' => $optional($party->phone ?? null),
            'consumerEmail' => $optional($party->email ?? null),
            'consumerNTN' => $optional(($party->ntn ?? null) ?: ($party->cnic ?? null)),
            'address' => $optional($party->address ?? null),
            'cpcCode' => 'N/A', 'extraInf' => 'N/A',
            'modeOfPay' => 'Cash', 'transType' => $mode,
            'posUser' => (string) $company->token,
            'posPass' => (string) $company->sandbox_token,
        ];
    }

    public function send(array $payload): array
    {
        $raw = null;
        try {
            // No retry: a lost response may still represent an accepted fiscal invoice.
            $response = Http::acceptJson()->asJson()->timeout(35)
                ->withOptions(['connect_timeout' => 10, 'allow_redirects' => false])->post(self::URL, $payload);
            $raw = $response->body();
            $body = $response->json();
        } catch (\Throwable $e) {
            return [
                'ok' => false,
                'status' => 'unknown',
                'message' => 'SRB response unavailable. Reconcile this invoice with SRB before any retry.',
                'body' => null,
                'raw' => $raw,
            ];
        }
        $id = is_array($body) ? ($body['srbInvoiceId'] ?? null) : null;
        $qr = is_array($body) ? ($body['QRCodeLink'] ?? null) : null;
        $validQr = is_string($qr) && filter_var($qr, FILTER_VALIDATE_URL)
            && strtolower((string) parse_url($qr, PHP_URL_SCHEME)) === 'https'
            && preg_match('/(^|\.)srb\.gos\.pk$/i', (string) parse_url($qr, PHP_URL_HOST));
        if ($response->successful() && ($body['resCode'] ?? null) === '00' && is_string($id) && trim($id) !== '' && $validQr) {
            return [
                'ok' => true,
                'status' => 'accepted',
                'id' => $id,
                'qr' => $qr,
                'body' => $body,
                'raw' => $raw,
                'message' => 'Linked to SRB (' . $payload['transType'] . ').',
            ];
        }
        $error = is_array($body) && is_string($body['error'] ?? null) ? $body['error'] : 'Invalid or incomplete SRB response.';
        foreach (['posUser', 'posPass'] as $secret) {
            if (!empty($payload[$secret])) {
                $error = str_replace($payload[$secret], '[redacted]', $error);
            }
        }
        $unknown = !$response->successful() || !is_array($body) || !in_array($body['resCode'] ?? null, ['01', '02'], true)
            || stripos($error, 'duplicate') !== false;
        return [
            'ok' => false,
            'status' => $unknown ? 'unknown' : 'rejected',
            'body' => is_array($body) ? $body : null,
            'raw' => $raw,
            'message' => $unknown ? 'SRB result needs reconciliation before retry: ' . $error : $error,
        ];
    }

    /**
     * Build verification URL from SRB invoice id (same pattern as API QRCodeLink).
     * No extra DB column — print reconstructs QR from stored srbInvoiceId in fbr_invoice_no.
     */
    public static function verificationUrl($srbInvoiceId): string
    {
        return 'https://apps.srb.gos.pk/InvoiceVerification/MobileInvoiceStatus.jsp?invoiceVerification='
            . rawurlencode((string) $srbInvoiceId);
    }

    public static function qrImage(string $url): string
    {
        // Use the installed QR generator so printing/PDF needs no external QR service.
        ob_start();
        try {
            \QR_Code\QR_Code::png($url, false, 'M', 4, 4);
            return 'data:image/png;base64,' . base64_encode(ob_get_contents());
        } finally {
            ob_end_clean();
        }
    }
}
