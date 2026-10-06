<?php

namespace App\Services;

use App\Models\Companies;
use App\Models\SaleTax;
use Illuminate\Support\Facades\DB;

class SrbInvoiceSubmission
{
    public function submit($invoiceId, Companies $company): array
    {
        $client = app(SrbPosClient::class);
        $prepared = DB::transaction(function () use ($invoiceId, $company, $client) {
            Companies::whereKey($company->id)->lockForUpdate()->firstOrFail();
            $sale = SaleTax::where('company_id', $company->id)->whereKey($invoiceId)->lockForUpdate()->firstOrFail();
            if ($sale->fbr_invoice_no) {
                return ['ok' => false, 'message' => 'Invoice is already linked to SRB and will not be sent again.'];
            }
            if (SaleTax::where('company_id', $company->id)->where('invoice_no', $sale->invoice_no)
                ->where('id', '!=', $sale->id)->whereNotNull('fbr_invoice_no')->exists()) {
                return ['ok' => false, 'message' => 'Another invoice already uses this invoice number. Resolve the duplicate locally before submitting.'];
            }
            try {
                $payload = $client->buildPayload($company, $sale);
            } catch (\InvalidArgumentException $e) {
                return ['ok' => false, 'message' => $e->getMessage()];
            }
            return ['payload' => $payload];
        });
        if (!isset($prepared['payload'])) {
            return $prepared;
        }
        $result = $client->send($prepared['payload']);

        // Same as FBR DI debug_mode: dump API response and do not link locally.
        if ($company->debug_mode == 1 || $company->debug_mode == 2) {
            return [
                'ok' => false,
                'debug_mode' => (int) $company->debug_mode,
                'raw' => $result['raw'] ?? null,
                'body' => $result['body'] ?? null,
                'message' => 'Debug mode – SRB response dump only; invoice not linked.',
            ];
        }

        if ($result['ok']) {
            DB::transaction(function () use ($invoiceId, $company, $result) {
                $sale = SaleTax::where('company_id', $company->id)->whereKey($invoiceId)->lockForUpdate()->firstOrFail();
                $sale->fbr_invoice_no = $result['id'];
                $sale->save();
            });
        }
        return $result;
    }
}
