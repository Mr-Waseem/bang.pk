<?php

namespace App\Services;

use App\Models\Companies;
use App\Models\SaleTax;
use Illuminate\Support\Facades\Log;

class KpraRimsClient
{
    public const LIVE_URL = 'https://kpra.gov.pk/api/rims-integration';
    public const LIVE_URL_ALT = 'https://api.kpra.gov.pk/rims-integration';

    /**
     * Build Live KPRA RIMS payload.
     * Live API uses: date, sales_tax (not date_time / tax_amount).
     */
    public static function buildLivePayload(
        Companies $company,
        $invoiceNo,
        $amountExTax,
        $salesTax,
        $taxRate,
        $totalAmount,
        $dateTime = null,
        $paymentMode = 1
    ) {
        $dt = self::formatDateTime($dateTime);
        $amount = round((float) $amountExTax, 2);
        $tax = round((float) $salesTax, 2);
        $rate = round((float) $taxRate, 2);
        $total = round((float) $totalAmount, 2);

        // Live docs list sales_tax + date; current endpoint also requires tax_amount.
        // Send both naming styles so either validator path accepts the payload.
        return [
            'ntn' => (string) ($company->ntn ?? ''),
            'pos_id' => (string) ($company->pos_id ?? ''),
            'key' => (string) ($company->token ?? ''),
            'invoice_no' => (string) $invoiceNo,
            'amount' => $amount,
            'sales_tax' => $tax,
            'tax_amount' => $tax,
            'tax_rate' => $rate,
            'total_amount' => $total,
            'date' => $dt,
            'date_time' => $dt,
            'payment_mode' => (int) $paymentMode,
        ];
    }

    /**
     * Build payload from a saved SaleTax + line totals.
     */
    public static function buildFromSale(Companies $company, SaleTax $sale, $amountExTax, $salesTax, $taxRate, $totalAmount, $paymentMode = 1)
    {
        return self::buildLivePayload(
            $company,
            $sale->invoice_no,
            $amountExTax,
            $salesTax,
            $taxRate,
            $totalAmount,
            $sale->date,
            $paymentMode
        );
    }

    /**
     * POST invoice to Live KPRA RIMS. Retries once on 500 / network error.
     *
     * @return array{ok:bool,http_code:int,body:mixed,raw:?string,transaction_id:?string,message:string}
     */
    public static function sendLiveInvoice(array $payload, $debug = false, $url = null)
    {
        $url = $url ?: self::LIVE_URL;
        $attempt = 0;
        $maxAttempts = 2;
        $last = [
            'ok' => false,
            'http_code' => 0,
            'body' => null,
            'raw' => null,
            'transaction_id' => null,
            'message' => 'Unknown error',
        ];

        while ($attempt < $maxAttempts) {
            $attempt++;
            $last = self::postJson($url, $payload, $debug);

            if ($last['ok']) {
                return $last;
            }

            $retryable = $last['http_code'] === 500
                || $last['http_code'] === 0
                || ($last['message'] !== '' && stripos($last['message'], 'curl') !== false);

            if (!$retryable || $attempt >= $maxAttempts) {
                return $last;
            }

            sleep(7);
        }

        return $last;
    }

    public static function verificationUrl($posId, $invoiceNo)
    {
        return 'https://kpra.gov.pk/api/?pos_id=' . rawurlencode((string) $posId)
            . '&invoice_no=' . rawurlencode((string) $invoiceNo);
    }

    public static function formatDateTime($dateTime)
    {
        if (empty($dateTime)) {
            return date('Y-m-d H:i:s');
        }

        $raw = trim((string) $dateTime);
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $raw)) {
            return $raw . ' ' . date('H:i:s');
        }

        $ts = strtotime($raw);
        if ($ts !== false) {
            return date('Y-m-d H:i:s', $ts);
        }

        return date('Y-m-d H:i:s');
    }

    protected static function postJson($url, array $payload, $debug = false)
    {
        $json = json_encode($payload);
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 5,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $json,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Accept: application/json',
            ],
        ]);

        $raw = curl_exec($curl);
        $httpCode = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curlError = curl_error($curl);
        curl_close($curl);

        if ($raw === false) {
            $result = [
                'ok' => false,
                'http_code' => 0,
                'body' => null,
                'raw' => null,
                'transaction_id' => null,
                'message' => 'CURL error: ' . $curlError,
            ];
            if ($debug) {
                Log::warning('KPRA RIMS curl failed', ['url' => $url, 'error' => $curlError, 'payload' => self::redact($payload)]);
            }
            return $result;
        }

        $body = json_decode($raw, true);
        if (!is_array($body)) {
            $body = ['raw' => $raw];
        }

        $statusField = isset($body['status']) ? (int) $body['status'] : $httpCode;
        $message = (string) ($body['message'] ?? '');
        $transactionId = null;
        if (isset($body['data']['transaction_id'])) {
            $transactionId = (string) $body['data']['transaction_id'];
        }

        $ok = ($httpCode === 201 || $statusField === 201) && !empty($transactionId);

        if ($debug) {
            Log::info('KPRA RIMS response', [
                'url' => $url,
                'http_code' => $httpCode,
                'ok' => $ok,
                'payload' => self::redact($payload),
                'response' => $body,
            ]);
        }

        if ($ok) {
            return [
                'ok' => true,
                'http_code' => $httpCode ?: 201,
                'body' => $body,
                'raw' => $raw,
                'transaction_id' => $transactionId,
                'message' => $message !== '' ? $message : 'Invoice created successfully.',
            ];
        }

        if ($message === '') {
            if ($httpCode === 401) {
                $message = 'Unauthorized: invalid POS ID or KPRA key.';
            } elseif ($httpCode === 400) {
                $message = 'Bad Request: invalid or missing KPRA parameters.';
            } elseif ($httpCode === 403) {
                $message = 'HTTPS required for KPRA Live API.';
            } elseif ($httpCode === 405) {
                $message = 'Method Not Allowed. Use POST.';
            } elseif ($httpCode === 500) {
                $message = 'KPRA server error. Please try again later.';
            } else {
                $message = 'KPRA submission failed (HTTP ' . $httpCode . ').';
            }
        }

        return [
            'ok' => false,
            'http_code' => $httpCode,
            'body' => $body,
            'raw' => $raw,
            'transaction_id' => $transactionId,
            'message' => $message,
        ];
    }

    protected static function redact(array $payload)
    {
        if (isset($payload['key'])) {
            $payload['key'] = '***';
        }
        return $payload;
    }
}
