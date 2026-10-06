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
    protected $importedProducts = []; // Track imported product combinations

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
            $partyName = trim($row[2] ?? '');
            $partyNtn = trim($row[3] ?? '');
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
            $productCode = is_numeric($row[5]) ? 
                number_format($row[5], 4, '.', '') : 
                trim((string) $row[5]);
            $productName = trim($row[6] ?? '');
            $product = null;
            
            // Validate Product Code (HS Code) - Required
            if(empty($productCode)){
                $errors[] = "Row {$this->rowNumber}: HS Code (Product Code) is required.";
            }
            
            // Validate Product Name - Required
            if(empty($productName)){
                $errors[] = "Row {$this->rowNumber}: Product Description (Product Name) is required.";
            }
            
            // If both are provided, check for duplicates and existence
            if(!empty($productCode) && !empty($productName)){
                // Create unique key for combination
                $productKey = strtolower($productCode . '|' . $productName);
                
                // Check if this exact combination was already imported in this file
                if(isset($this->importedProducts[$productKey])){
                    $previousRow = $this->importedProducts[$productKey];
                    $errors[] = "Row {$this->rowNumber}: Duplicate entry - HS Code '{$productCode}' with Product Name '{$productName}' was already imported in Row {$previousRow}.";
                } else {
                    // Check if product exists in database with this exact combination
                    $productByCodeAndName = Product::where('product_code', $productCode)
                        ->where('product_name', $productName)
                        ->where('company_id', $companyId)->first();
                    
                    if(!$productByCodeAndName){
                        // Check if code exists with different name
                        $productByCode = Product::where('product_code', $productCode)
                            ->where('company_id', $companyId)->first();
                        
                        // Check if name exists with different code
                        $productByName = Product::where('product_name', $productName)
                            ->where('company_id', $companyId)->first();
                        
                        if($productByCode && $productByName){
                            // Both exist separately - combination doesn't match
                            $errors[] = "Row {$this->rowNumber}: Product mismatch - HS Code '{$productCode}' belongs to '{$productByCode->product_name}' and Product Name '{$productName}' has HS Code '{$productByName->product_code}'. Please verify data.";
                        } elseif($productByCode){
                            // Code exists with different name
                            $errors[] = "Row {$this->rowNumber}: HS Code '{$productCode}' exists but with different Product Name '{$productByCode->product_name}'. Expected: '{$productName}'.";
                        } elseif($productByName){
                            // Name exists with different code
                            $errors[] = "Row {$this->rowNumber}: Product Name '{$productName}' exists but with different HS Code '{$productByName->product_code}'. Expected: '{$productCode}'.";
                        } else {
                            // Neither exists - product not found at all
                            $errors[] = "Row {$this->rowNumber}: Product with HS Code '{$productCode}' and Name '{$productName}' not found in your company. Please create product first.";
                        }
                    } else {
                        $product = $productByCodeAndName;
                        // Track this combination as imported
                        $this->importedProducts[$productKey] = $this->rowNumber;
                    }
                }
            }
            
            // ==========================================
            // SCENARIO VALIDATION
            // ==========================================
            $scenarioName = trim($row[1] ?? '');
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
                'unregistered_cnicntn'  => $row[4] ?? null,
                'warehouse_id'  => 1,
                'date'  => $this->convertDate($row[0]),
                'sale_type' => "SalesTax Invoice",
                'invoice_no' => $CalculatedCode,
                'scenario_id' => $scenario->id ?? 0,
                'biller'  => Auth::User()->id,
                'advance_income_tax'  => $row[17],
                'total_income_tax'  => $row[18],
                'company_id'  => $companyId
            ]);
            $saleTax->save();

            // 2. Now create and SAVE the SaleTaxDetails model using the generated sale_id
            $saleTaxDetail = new SaleTaxDetails([ 
                'sale_id'  => $saleTax->id,
                'sale_type1'  => "SalesTax Invoice",
                'date'  =>  $this->convertDate($row[0]),
                'invoice_no'  => $CalculatedCode,
                'party_id'  => $party->id,
                'product_id'  => $product->id,
                'fbr_uom_desc'  => $row[7],
                'warehouse_id'  => 1,
                'status'  => "InvoiceOnly",
                'quantity'  => $row[8],
                'rate'  => $row[9],
                'stvalue'  => $row[10],
                'taxvalue'  => $row[11],
                'extratax'  => $row[12],
                'extraTaxValue'  => $row[13],
                'price'  => $row[14] ?? 0,
                'discount'  => $row[15],
                'discount_value'  => $row[16],
                'discount2'  => $row[17],
                'discount2_value'  => $row[18],
                'total'  => $row[21],
                'sro_schd_no'  => $row[22],
                'sro_item_no'  => $row[23],
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