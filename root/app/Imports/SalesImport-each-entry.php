<?php

namespace App\Imports;

use App\Models\Party;
use App\Models\Scenario;
use App\Models\Product;
use App\Models\SaleTax;
use App\Models\SaleTaxDetails;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SalesImport implements ToModel, WithCalculatedFormulas
{
    protected $rowNumber = 0;
    public $errors = [];
    public $importedCount = 0;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $this->rowNumber++;
        
        // Skip header row
        if($row[0] != "Date" && $row[0] != null && $row[0] != 0){
            
            $errors = [];
            $companyId = session()->get('company_id');
            
            // ==========================================
            // PARTY VALIDATION (Customer Name & NTN)
            // ==========================================
            $partyName = trim($row[3] ?? '');
            $partyNtn = trim($row[4] ?? '');
            $party = null;
            
            // Check if it's an unregistered/walking customer (empty NTN)
            if(empty($partyNtn) || $partyNtn == ""){
                $party = Party::where('ntn', "9999999")
                    ->where('company_id', $companyId)->first();
                    
                if(!$party){
                    $errors[] = "Row {$this->rowNumber}: Default unregistered customer (NTN: 9999999) not found. Please create it first.";
                }
            } else {
                // Validate Party Name - Required
                if(empty($partyName)){
                    $errors[] = "Row {$this->rowNumber}: Customer Name is required.";
                }
                
                // Validate NTN - Required
                if(empty($partyNtn)){
                    $errors[] = "Row {$this->rowNumber}: Customer NTN is required.";
                }
                
                // If both are provided, check existence and matching
                if(!empty($partyName) && !empty($partyNtn)){
                    // Check if party exists with this NTN
                    $partyByNtn = Party::where('ntn', $partyNtn)
                        ->where('company_id', $companyId)->first();
                    
                    if(!$partyByNtn){
                        $errors[] = "Row {$this->rowNumber}: Customer with NTN '{$partyNtn}' not found in your company. Please create party first.";
                    } else {
                        // Check if party name matches
                        if(strtolower(trim($partyByNtn->party_name)) != strtolower(trim($partyName))){
                            $errors[] = "Row {$this->rowNumber}: Customer Name '{$partyName}' does not match with NTN '{$partyNtn}'. Expected: '{$partyByNtn->party_name}'.";
                        } else {
                            $party = $partyByNtn;
                        }
                    }
                }
            }
            
            // ==========================================
            // PRODUCT VALIDATION (HS Code & Product Name)
            // ==========================================
            // Format HS Code properly - handle both numeric and string values
            $rawProductCode = $row[6] ?? '';
            if(is_numeric($rawProductCode)){
                $productCode = number_format((float)$rawProductCode, 4, '.', '');
            } else {
                $productCode = trim((string) $rawProductCode);
            }
            // Remove any trailing zeros after decimal if needed, but keep 4 decimal places for matching
            $productCode = rtrim(rtrim($productCode, '0'), '.');
            if(strpos($productCode, '.') !== false){
                $parts = explode('.', $productCode);
                $productCode = $parts[0] . '.' . str_pad($parts[1] ?? '', 4, '0', STR_PAD_RIGHT);
            }
            
            $productName = trim($row[7] ?? '');
            $product = null;
            
            // Validate Product Code (HS Code) - Required
            if(empty($productCode)){
                $errors[] = "Row {$this->rowNumber}: HS Code (Product Code) is required.";
            }
            
            // Validate Product Name - Required
            if(empty($productName)){
                $errors[] = "Row {$this->rowNumber}: Product Description (Product Name) is required.";
            }
            
            // If both are provided, check existence and matching
            if(!empty($productCode) && !empty($productName)){
                // Normalizer function for matching
                $normalize = function($s){
                    $s = mb_strtolower(trim((string) $s));
                    $s = preg_replace('/\s+/u', ' ', $s); // collapse multiple spaces
                    $s = preg_replace('/[^a-z0-9 ]+/u', '', $s); // remove special chars
                    return trim($s);
                };
                
                $normRowName = $normalize($productName);
                
                // Try to find product by HS Code AND Product Name match
                // First, get all products with this HS code for the company
                $products = Product::where('product_code', $productCode)
                    ->where('company_id', $companyId)->get();
                
                // If no exact code match, try with different decimal formats
                if($products->isEmpty()){
                    // Try without trailing zeros
                    $codeVariant1 = rtrim(rtrim($productCode, '0'), '.');
                    $products = Product::where('product_code', $codeVariant1)
                        ->where('company_id', $companyId)->get();
                }
                
                // Also try LIKE search for HS code if still empty
                if($products->isEmpty()){
                    $baseCode = explode('.', $productCode)[0];
                    $products = Product::where('product_code', 'LIKE', $baseCode . '%')
                        ->where('company_id', $companyId)->get();
                }

                if($products->isEmpty()){
                    $errors[] = "Row {$this->rowNumber}: Product with HS Code '{$productCode}' not found in your company. Please create product first.";
                } else {
                    $matched = null;

                    // Try exact normalized match first
                    foreach($products as $p){
                        if($normalize($p->product_name) === $normRowName){
                            $matched = $p;
                            break;
                        }
                    }

                    // If no exact match, try partial/contain match (either direction)
                    if(!$matched){
                        foreach($products as $p){
                            $normDb = $normalize($p->product_name);
                            if($normDb === '') continue;
                            // Check if one contains the other
                            if(strpos($normDb, $normRowName) !== false || strpos($normRowName, $normDb) !== false){
                                $matched = $p;
                                break;
                            }
                        }
                    }
                    
                    // If still no match, try word-based matching (all words from DB name should exist in row name)
                    if(!$matched){
                        foreach($products as $p){
                            $normDb = $normalize($p->product_name);
                            if($normDb === '') continue;
                            $dbWords = array_filter(explode(' ', $normDb));
                            $rowWords = array_filter(explode(' ', $normRowName));
                            
                            // Check if all significant words from DB exist in row name
                            $matchCount = 0;
                            foreach($dbWords as $word){
                                if(strlen($word) > 2 && in_array($word, $rowWords)){
                                    $matchCount++;
                                }
                            }
                            // If more than 70% words match, consider it a match
                            if(count($dbWords) > 0 && ($matchCount / count($dbWords)) >= 0.7){
                                $matched = $p;
                                break;
                            }
                        }
                    }

                    if($matched){
                        $product = $matched;
                    } else {
                        $names = $products->pluck('product_name')->unique()->values()->all();
                        $expected = implode("', '", $names);
                        $errors[] = "Row {$this->rowNumber}: Product Name '{$productName}' does not match with HS Code '{$productCode}'. Expected one of: '{$expected}'.";
                    }
                }
            }
            
            // ==========================================
            // SCENARIO VALIDATION
            // ==========================================
            $scenarioName = trim($row[2] ?? '');
            $scenario = null;
            
            if(!empty($scenarioName)){
                $scenario = Scenario::where('name', $scenarioName)->first();
                if(!$scenario){
                    $errors[] = "Row {$this->rowNumber}: Scenario '{$scenarioName}' not found. Please create scenario first.";
                }
            }
            
            // ==========================================
            // IF ERRORS EXIST, THROW EXCEPTION
            // ==========================================
            if(!empty($errors)){
                $this->errors = array_merge($this->errors, $errors);
                throw new \Exception(implode("\n", $errors));
            }
            
            // ==========================================
            // PROCEED WITH IMPORT (All validations passed)
            // ==========================================
            $LastProduct = SaleTax::where('company_id', $companyId)
                ->Orderby('id', 'desc')->first();
            $CalculatedCode = 1;
            if($LastProduct){
                $CalculatedCode = $LastProduct->invoice_no + 1;
            }

            // 1. Create and SAVE the SaleTax model first
            $saleTax = new SaleTax([ 
                'party_id'  => $party->id,
                'unregistered_cnicntn'  => $row[5] ?? null,
                'warehouse_id'  => 1,
                'date'  => $this->convertDate($row[0]),
                'sale_type' => "SalesTax Invoice",
                // 'invoice_no' => $CalculatedCode,
                'invoice_no' => $row[1],
                'scenario_id' => $scenario->id ?? 0,
                'biller'  => Auth::User()->id,
                'advance_income_tax'  => $row[18],
                'total_income_tax'  => $row[19],
                'company_id'  => $companyId
            ]);
            $saleTax->save();

            // 2. Now create and SAVE the SaleTaxDetails model using the generated sale_id
            $saleTaxDetail = new SaleTaxDetails([ 
                'sale_id'  => $saleTax->id,
                'sale_type1'  => "SalesTax Invoice",
                'date'  =>  $this->convertDate($row[0]),
                // 'invoice_no'  => $CalculatedCode,
                'invoice_no'  => $row[1],
                'party_id'  => $party->id,
                'product_id'  => $product->id,
                // 'fbr_uom_desc'  => $row[8],
                'fbr_uom_desc'  => $product->uom,
                'warehouse_id'  => 1,
                'status'  => "InvoiceOnly",
                'quantity'  => $row[9],
                'rate'  => $row[10],
                'stvalue'  => $row[11],
                'taxvalue'  => $row[12],
                'extratax'  => $row[13],
                'extraTaxValue'  => $row[14],
                'price'  => $row[15] ?? 0,
                'discount'  => $row[16],
                'discount_value'  => $row[17],
                'discount2'  => $row[18],
                'discount2_value'  => $row[19],
                'total'  => $row[22],
                'sro_schd_no'  => $row[23],
                'sro_item_no'  => $row[24],
                'company_id'  => $companyId,
            ]);
            $saleTaxDetail->save();

            $this->importedCount++;
            
            // Return the main model as required by ToModel interface
            return $saleTax;
        }

        return null; // Return null for rows that don't meet the condition
    }
    
    /**
     * Get all validation errors
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
    
    /**
     * Get imported count
     */
    public function getImportedCount(): int
    {
        return $this->importedCount;
    }

        public function convertDate($value)
    {
        try {
            // If it's an Excel serial number (numeric)
            if (is_numeric($value)) {
                $unixDate = ($value - 25569) * 86400; // Convert to Unix timestamp
                return Carbon::createFromTimestamp($unixDate)->format('Y-m-d');
            }
            
            // If it's already a date string, try to parse it
            return Carbon::parse($value)->format('Y-m-d');
            
        } catch (\Exception $e) {
            // Return today's date if conversion fails
            return Carbon::today()->format('Y-m-d');
        }
    }
}