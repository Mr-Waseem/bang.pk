<?php

namespace App\Services;

use App\Models\Companies;
use App\Models\SaleTax;
use Carbon\Carbon;

class CompanyInvoiceGuard
{
    public const SALE_TYPE_INVOICE = 'SalesTax Invoice';

    /**
     * Next invoice number for a company.
     * No invoices yet: first number = invoice_serial (default 1).
     * After invoices exist: max(last invoice_no, serial) + 1.
     * Example: serial 100 with no invoices → first is 100; then 101, 102...
     */
    public static function nextInvoiceNo($companyId, $saleType = self::SALE_TYPE_INVOICE)
    {
        $company = Companies::find($companyId);
        $serial = (int) ($company->invoice_serial ?? 1);
        if ($serial < 1) {
            $serial = 1;
        }

        $last = SaleTax::where('company_id', $companyId)
            ->where('sale_type', $saleType)
            ->orderByRaw('CAST(invoice_no AS UNSIGNED) DESC')
            ->value('invoice_no');

        $lastNo = (int) $last;
        if ($lastNo <= 0) {
            return $serial;
        }

        return max($lastNo, $serial) + 1;
    }

    /**
     * Count SalesTax invoices for the company in the invoice date's calendar month.
     */
    public static function monthlyInvoiceCount($companyId, $invoiceDate, $saleType = self::SALE_TYPE_INVOICE)
    {
        $date = self::parseDate($invoiceDate);

        return SaleTax::where('company_id', $companyId)
            ->where('sale_type', $saleType)
            ->whereYear('date', $date->year)
            ->whereMonth('date', $date->month)
            ->count();
    }

    /**
     * Return error message if monthly limit is reached; otherwise null.
     * number_of_invoices <= 0 means no limit.
     */
    public static function monthlyLimitError($companyId, $invoiceDate, $saleType = self::SALE_TYPE_INVOICE)
    {
        $company = Companies::find($companyId);
        if (!$company) {
            return 'Company not found.';
        }

        $limit = (int) ($company->number_of_invoices ?? 0);
        if ($limit <= 0) {
            return null;
        }

        $date = self::parseDate($invoiceDate);
        $count = self::monthlyInvoiceCount($companyId, $date, $saleType);

        if ($count >= $limit) {
            return 'Monthly invoice limit (' . $limit . ') reached for '
                . $date->format('F Y')
                . '. Cannot create more invoices for this month.';
        }

        return null;
    }

    protected static function parseDate($invoiceDate)
    {
        try {
            return Carbon::parse($invoiceDate ?: 'now')->startOfDay();
        } catch (\Exception $e) {
            return Carbon::now()->startOfDay();
        }
    }
}
