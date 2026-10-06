<?php

namespace App\Imports;

use App\Models\Party;
use App\Models\Scenario;
use App\Models\Product;
use App\Models\SaleTax;
use App\Models\SaleTaxDetails;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SalesImport implements ToCollection, WithCalculatedFormulas
{
    public $errors = [];
    public $importedCount = 0;
    public $processedInvoices = [];
    private const DEFAULT_CATEGORY_ID = 5;

    /** @var array<string, Party> Cache parties within one import run */
    private $partyCache = [];

    /**
     * @param Collection $rows
     * @return void
     */
    public function collection(Collection $rows)
    {
        $companyId = session()->get('company_id');
        $invoiceGroups = [];
        $this->partyCache = [];

        foreach ($rows as $index => $row) {
            if ($index === 0 || empty($row[0]) || $row[0] == "Date") {
                continue;
            }

            $invoiceNo = trim((string) $row[1]);
            if (!isset($invoiceGroups[$invoiceNo])) {
                $invoiceGroups[$invoiceNo] = [];
            }
            $invoiceGroups[$invoiceNo][] = [
                'row' => $row,
                'index' => $index + 1,
            ];
        }

        DB::beginTransaction();
        try {
            foreach ($invoiceGroups as $invoiceNo => $items) {
                try {
                    $this->processInvoice($invoiceNo, $items, $companyId);
                } catch (\Exception $e) {
                    $this->errors[] = $e->getMessage();
                }
            }

            if (!empty($this->errors)) {
                DB::rollBack();
                throw new \Exception("Import failed due to validation errors:\n" . implode("\n", $this->errors));
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            if (!empty($this->errors)) {
                throw new \Exception(implode("\n", $this->errors));
            }
            throw $e;
        }

        if ($this->importedCount === 0) {
            throw new \Exception('No valid rows found to import.');
        }
    }

    private function processInvoice($invoiceNo, $items, $companyId)
    {
        $detailsData = [];
        $party = null;
        $scenario = null;
        $invoiceDate = null;
        $resolvedPartyKey = null;

        $invoiceNo = trim((string) $invoiceNo);

        $existingInvoice = SaleTax::where('invoice_no', $invoiceNo)
            ->where('company_id', $companyId)
            ->first();

        if ($existingInvoice) {
            throw new \Exception("Invoice #{$invoiceNo} already exists. Please use a unique invoice number.");
        }

        foreach ($items as $item) {
            $row = $item['row'];
            $rowNumber = $item['index'];

            if ($invoiceDate === null) {
                $invoiceDate = $this->convertDate($row[0]);
            }

            $currentPartyName = trim((string) ($row[3] ?? ''));
            $currentPartyNtn = $this->normalizeIdentityValue($row[4] ?? '');
            $currentPartyCnic = $this->normalizeIdentityValue($row[5] ?? '');

            if ($party === null) {
                $party = $this->resolvePartyFromImport(
                    $currentPartyName,
                    $currentPartyNtn,
                    $currentPartyCnic,
                    $row,
                    $companyId,
                    $rowNumber,
                    $invoiceNo
                );
                $resolvedPartyKey = $this->partyCacheKey($currentPartyName, $currentPartyNtn, $currentPartyCnic);
            } else {
                $rowKey = $this->partyCacheKey($currentPartyName, $currentPartyNtn, $currentPartyCnic);
                $expectedName = strtolower(trim($party->party_name));
                $incomingName = strtolower(trim($currentPartyName));

                $sameIdentity = ($resolvedPartyKey !== null && $rowKey === $resolvedPartyKey)
                    || ($incomingName !== '' && $incomingName === $expectedName);

                if (!$sameIdentity) {
                    $this->debugLogRow($rowNumber, $invoiceNo, $currentPartyName, $currentPartyNtn, $party, 'invoice_multiple_party_mismatch');
                    throw new \Exception(
                        "Row {$rowNumber}: Invoice '{$invoiceNo}' contains multiple customers. "
                        . "Expected '{$party->party_name}', found '{$currentPartyName}'."
                    );
                }
            }

            if ($scenario === null && !empty(trim((string) ($row[2] ?? '')))) {
                $scenarioName = trim((string) $row[2]);
                $scenario = Scenario::where('name', $scenarioName)->first();
                if (!$scenario) {
                    throw new \Exception("Row {$rowNumber}: Scenario '{$scenarioName}' not found. Please create scenario first.");
                }
            }

            $rawProductCode = $row[6] ?? '';
            $productCode = $this->normalizeProductCode($rawProductCode);
            $productName = trim((string) ($row[7] ?? ''));

            if ($productCode === '') {
                throw new \Exception("Row {$rowNumber}: HS Code (Product Code) is required.");
            }
            if ($productName === '') {
                throw new \Exception("Row {$rowNumber}: Product Description (Product Name) is required.");
            }

            $codeVariants = $this->getCodeVariants($productCode);
            $exactProduct = Product::whereIn('product_code', $codeVariants)
                ->where('product_name', $productName)
                ->where('company_id', $companyId)
                ->first();

            $product = $exactProduct ?: $this->createProductFromImport($productCode, $productName, $row, $companyId);

            $detailsData[] = [
                'row' => $row,
                'product' => $product,
                'rowNumber' => $rowNumber,
            ];
        }

        // Advance % from first filled row[21]; income tax = sum of sheet row[22]
        $advanceIncomeTaxPct = 0;
        $totalIncomeTax = 0;
        foreach ($items as $item) {
            if ($advanceIncomeTaxPct == 0 && $this->isFilled($item['row'][21] ?? null)) {
                $advanceIncomeTaxPct = (float) $item['row'][21];
            }
            if ($this->isFilled($item['row'][22] ?? null)) {
                $totalIncomeTax += (float) $item['row'][22];
            }
        }

        $saleTax = new SaleTax([
            'party_id' => $party->id,
            'unregistered_cnicntn' => $items[0]['row'][5] ?? null,
            'remarks' => $items[0]['row'][26] ?? null,
            'warehouse_id' => 1,
            'date' => $invoiceDate,
            'sale_type' => "SalesTax Invoice",
            'invoice_no' => $invoiceNo,
            'scenario_id' => $scenario->id ?? 0,
            'biller' => Auth::User()->id,
            'advance_income_tax' => $advanceIncomeTaxPct,
            'total_income_tax' => $totalIncomeTax,
            'company_id' => $companyId,
        ]);
        $saleTax->save();

        foreach ($detailsData as $detail) {
            $row = $detail['row'];
            $product = $detail['product'];
            $amounts = $this->buildLineAmounts($row);

            $saleTaxDetail = new SaleTaxDetails([
                'sale_id' => $saleTax->id,
                'sale_type1' => "SalesTax Invoice",
                'date' => $invoiceDate,
                'invoice_no' => $invoiceNo,
                'party_id' => $party->id,
                'product_id' => $product->id,
                'fbr_uom_desc' => $product->uom,
                'warehouse_id' => 1,
                'status' => "InvoiceOnly",
                'remarks' => $row[8],
                'quantity' => $amounts['quantity'],
                'rate' => $amounts['rate'],
                'stvalue' => $amounts['stvalue'],
                'taxvalue' => $amounts['taxvalue'],
                'extratax' => $amounts['extratax'],
                'extraTaxValue' => $amounts['extraTaxValue'],
                'price' => $amounts['price'],
                'discount' => $amounts['discount'],
                'discount_value' => $amounts['discount_value'],
                'discount2' => $amounts['discount2'],
                'discount2_value' => $amounts['discount2_value'],
                'total' => $amounts['total'],
                'sro_schd_no' => $row[24],
                'sro_item_no' => $row[25],
                'company_id' => $companyId,
            ]);
            $saleTaxDetail->save();

            $this->importedCount++;
        }

        $this->processedInvoices[] = $invoiceNo;
    }

    /**
     * Sheet-first amounts: use Excel values when present, else calculate.
     * Never overwrite rate with price/qty.
     */
    private function buildLineAmounts($row): array
    {
        $qty = (float) ($row[10] ?? 0);
        $rate = (float) ($row[11] ?? 0);
        $stvalue = $row[12] ?? 0;
        $extraPct = $this->isFilled($row[14] ?? null) ? (float) $row[14] : 0;

        $price = $this->isFilled($row[16] ?? null)
            ? (float) $row[16]
            : ($qty * $rate);

        $isExempt = in_array((string) $stvalue, ['Exempt', 'Zero Rated'], true);
        if ($isExempt) {
            $taxvalue = 0;
        } elseif ($this->isFilled($row[13] ?? null)) {
            $taxvalue = (float) $row[13];
        } else {
            $taxvalue = $price * ((float) $stvalue) / 100;
        }

        $extraTaxValue = $this->isFilled($row[15] ?? null)
            ? (float) $row[15]
            : ($price * $extraPct / 100);

        $discount = $this->isFilled($row[17] ?? null) ? $row[17] : 0;
        $discountValue = $this->isFilled($row[18] ?? null)
            ? (float) $row[18]
            : ($price * ((float) $discount) / 100);

        $discount2 = $this->isFilled($row[19] ?? null) ? $row[19] : 0;
        $discount2Value = $this->isFilled($row[20] ?? null)
            ? (float) $row[20]
            : ($price * ((float) $discount2) / 100);

        return [
            'quantity' => $qty,
            'rate' => $rate,
            'stvalue' => $stvalue,
            'price' => $price,
            'taxvalue' => $taxvalue,
            'extratax' => $extraPct,
            'extraTaxValue' => $extraTaxValue,
            'discount' => $discount,
            'discount_value' => $discountValue,
            'discount2' => $discount2,
            'discount2_value' => $discount2Value,
            'total' => $price + $taxvalue + $extraTaxValue,
        ];
    }

    private function resolvePartyFromImport(
        string $partyName,
        string $partyNtn,
        string $partyCnic,
        $row,
        int $companyId,
        int $rowNumber,
        string $invoiceNo
    ): Party {
        $cacheKey = $this->partyCacheKey($partyName, $partyNtn, $partyCnic);
        if (isset($this->partyCache[$cacheKey])) {
            $this->debugLogRow($rowNumber, $invoiceNo, $partyName, $partyNtn ?: $partyCnic, $this->partyCache[$cacheKey], 'used_party_cache');
            return $this->partyCache[$cacheKey];
        }

        $party = null;

        if ($partyNtn !== '') {
            if ($partyName === '') {
                throw new \Exception("Row {$rowNumber}: Customer Name is required.");
            }

            $party = $this->findPartyByNtnInCompany($partyNtn, $companyId);
            if ($party) {
                $this->debugLogRow($rowNumber, $invoiceNo, $partyName, $partyNtn, $party, 'used_existing_party_by_ntn');
            } else {
                $byName = $this->findPartyByNameInCompany($partyName, $companyId);
                if ($byName) {
                    $existingNtn = trim((string) ($byName->ntn ?? ''));
                    if ($existingNtn !== '' && $existingNtn !== $partyNtn) {
                        throw new \Exception(
                            "Row {$rowNumber}: Party '{$partyName}' already exists with NTN '{$existingNtn}'. "
                            . "Incoming NTN '{$partyNtn}' is different."
                        );
                    }
                    $party = $byName;
                    $this->debugLogRow($rowNumber, $invoiceNo, $partyName, $partyNtn, $party, 'used_existing_party_by_name');
                } else {
                    $party = $this->createPartyFromImport($partyName, $partyNtn, $row, $companyId);
                    $this->debugLogRow($rowNumber, $invoiceNo, $partyName, $partyNtn, $party, 'created_party');
                }
            }
        } elseif ($partyCnic !== '') {
            if ($partyName === '') {
                throw new \Exception("Row {$rowNumber}: Customer Name is required for unregistered customer.");
            }

            $party = $this->findPartyByNtnInCompany($partyCnic, $companyId);
            if ($party) {
                $this->debugLogRow($rowNumber, $invoiceNo, $partyName, $partyCnic, $party, 'used_existing_party_by_cnic');
            } else {
                $party = $this->findPartyByNameInCompany($partyName, $companyId);
                if ($party) {
                    $this->debugLogRow($rowNumber, $invoiceNo, $partyName, $partyCnic, $party, 'used_existing_party_by_name_blank_ntn');
                } else {
                    // Unregistered with CNIC: store CNIC as party NTN identity
                    $party = $this->createPartyFromImport($partyName, $partyCnic, $row, $companyId);
                    $this->debugLogRow($rowNumber, $invoiceNo, $partyName, $partyCnic, $party, 'created_unregistered_party_with_cnic');
                }
            }
        } elseif ($partyName !== '') {
            $party = $this->findPartyByNameInCompany($partyName, $companyId);
            if ($party) {
                $this->debugLogRow($rowNumber, $invoiceNo, $partyName, '9999999', $party, 'used_existing_party_by_name_blank_ntn');
            } else {
                $party = $this->createPartyFromImport($partyName, '9999999', $row, $companyId);
                $this->debugLogRow($rowNumber, $invoiceNo, $partyName, '9999999', $party, 'created_unregistered_party');
            }
        } else {
            $defaultName = 'Walking Customer';
            $defaultNtn = '9999999';
            $party = Party::where('ntn', $defaultNtn)
                ->where('company_id', $companyId)
                ->whereRaw('LOWER(party_name) = ?', [strtolower($defaultName)])
                ->first();
            if (!$party) {
                $party = $this->createPartyFromImport($defaultName, $defaultNtn, $row, $companyId);
                $this->debugLogRow($rowNumber, $invoiceNo, $defaultName, $defaultNtn, $party, 'created_fallback_walking_customer');
            } else {
                $this->debugLogRow($rowNumber, $invoiceNo, $defaultName, $defaultNtn, $party, 'used_fallback_walking_customer');
            }
        }

        if (!$party) {
            throw new \Exception("Row {$rowNumber}: Failed to create or find customer for this row.");
        }

        // Reuse only — never overwrite existing party name/fields
        $this->partyCache[$cacheKey] = $party;

        return $party;
    }

    private function partyCacheKey(string $name, string $ntn, string $cnic): string
    {
        return strtolower(trim($name)) . '|' . $ntn . '|' . $cnic;
    }

    private function isFilled($value): bool
    {
        if ($value === null) {
            return false;
        }
        if (is_string($value) && trim($value) === '') {
            return false;
        }
        return true;
    }

    private function normalizeIdentityValue($raw): string
    {
        $value = trim((string) ($raw ?? ''));
        if ($value === '') {
            return '';
        }
        if (preg_match('/^\d+(?:\.0+)?$/', $value)) {
            $value = preg_replace('/\.0+$/', '', $value);
        }
        return preg_replace('/[\x00-\x1F\x7F]/u', '', $value);
    }

    private function normalizeProductCode($rawProductCode): string
    {
        if (is_numeric($rawProductCode)) {
            $clean = number_format((float) $rawProductCode, 4, '.', '');
        } else {
            $clean = trim((string) $rawProductCode);
            $clean = preg_replace('/[^0-9.]/', '', $clean);
        }

        $clean = rtrim(rtrim($clean, '0'), '.');
        if ($clean === '') {
            return '';
        }

        if (strpos($clean, '.') === false) {
            $clean .= '.0000';
        }

        $parts = explode('.', $clean, 2);
        $left = str_pad($parts[0] ?? '', 4, '0', STR_PAD_LEFT);
        $right = str_pad($parts[1] ?? '', 4, '0', STR_PAD_RIGHT);

        return $left . '.' . $right;
    }

    private function getCodeVariants(string $productCode): array
    {
        $variants = [];
        $variants[] = $productCode;
        $variants[] = rtrim(rtrim($productCode, '0'), '.');

        if (strpos($productCode, '.') !== false) {
            $baseCode = explode('.', $productCode, 2)[0];
            $variants[] = $baseCode;
        }

        return array_values(array_unique(array_filter($variants)));
    }

    private function createProductFromImport(string $productCode, string $productName, $row, int $companyId): Product
    {
        $uom = trim((string) ($row[9] ?? ''));
        if ($uom === '') {
            $uom = 'Unit';
        }

        $rate = floatval($row[11] ?? 0);
        $tax = $row[12] ?? null;

        $product = new Product();
        $product->catagory_id = self::DEFAULT_CATEGORY_ID;
        $product->product_code = $productCode;
        $product->product_name = $productName;
        $product->uom = $uom;
        $product->product_cost = 0;
        $product->product_price = $rate;
        $product->tax = $tax !== null && $tax !== '' ? floatval($tax) : null;
        $product->company_id = $companyId;
        $product->save();

        return $product;
    }

    private function createPartyFromImport(string $partyName, string $partyNtn, $row, int $companyId): Party
    {
        $address = trim((string) ($row[27] ?? ''));
        $customerType = trim((string) ($row[28] ?? ''));

        $lastParty = Party::where('company_id', $companyId)->orderBy('id', 'desc')->first();
        $nextCode = $lastParty ? (int) $lastParty->code + 1 : 1;

        $party = new Party();
        $party->code = $nextCode;
        $party->party_name = $partyName;
        $party->ntn = $partyNtn;
        $party->address = $address != '' ? $address : 'N/A';
        $party->customer_type = $customerType != '' ? $customerType : 'Unregistered';
        $party->account_group_id = 1;
        $party->account_type = "DEBTOR";
        $party->company_id = $companyId;
        $party->shop_id = 1;
        $party->city = "N/A";
        $party->province = "PUNJAB";
        $party->save();

        return $party;
    }

    private function findPartyByNameInCompany(string $partyName, int $companyId): ?Party
    {
        return Party::where('company_id', $companyId)
            ->whereRaw('LOWER(TRIM(party_name)) = ?', [strtolower(trim($partyName))])
            ->first();
    }

    private function findPartyByNtnInCompany(string $ntn, int $companyId): ?Party
    {
        return Party::where('company_id', $companyId)
            ->where('ntn', $ntn)
            ->first();
    }

    private function debugLogRow($rowNumber, $invoiceNo, $excelName, $excelNtn, $party = null, $note = '')
    {
        try {
            $data = [
                'timestamp' => Carbon::now()->toDateTimeString(),
                'invoice' => $invoiceNo,
                'row' => $rowNumber,
                'excel_name' => $excelName,
                'excel_ntn' => $excelNtn,
                'matched_party_id' => $party->id ?? null,
                'matched_party_name' => $party->party_name ?? null,
                'matched_party_ntn' => $party->ntn ?? null,
                'matched_company_id' => $party->company_id ?? null,
                'note' => $note,
            ];

            $logPath = storage_path('logs/sales-import-debug.log');
            file_put_contents($logPath, json_encode($data, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND | LOCK_EX);
        } catch (\Exception $e) {
            Log::error('SalesImport: failed to write debug log: ' . $e->getMessage());
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getImportedCount(): int
    {
        return $this->importedCount;
    }

    public function getProcessedInvoices(): array
    {
        return $this->processedInvoices;
    }

    public function convertDate($value)
    {
        try {
            if (is_numeric($value)) {
                $unixDate = ($value - 25569) * 86400;
                return Carbon::createFromTimestamp($unixDate)->format('Y-m-d');
            }

            $rawValue = trim((string) $value);
            if ($rawValue === '') {
                return Carbon::today()->format('Y-m-d');
            }

            $formats = [
                'd/m/Y', 'd-m-Y',
                'd/n/Y', 'd-n-Y',
                'd/m/y', 'd-m-y',
                'Y-m-d', 'Y/m/d',
                'd/m/Y H:i:s', 'd-m-Y H:i:s',
                'Y-m-d H:i:s',
            ];

            foreach ($formats as $format) {
                $date = \DateTime::createFromFormat($format, $rawValue);
                $errors = \DateTime::getLastErrors();
                $hasNoErrors = $errors === false || (
                    $errors['warning_count'] === 0 &&
                    $errors['error_count'] === 0
                );

                if ($date !== false && $hasNoErrors) {
                    return Carbon::instance($date)->format('Y-m-d');
                }
            }

            return Carbon::parse($rawValue)->format('Y-m-d');
        } catch (\Exception $e) {
            return Carbon::today()->format('Y-m-d');
        }
    }
}
