<?php

namespace App\Imports;

use App\Models\Party;
use App\Models\Scenario;
use App\Models\Product;
use App\Models\SaleTax;
use App\Models\SaleTaxDetails;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class SalesImport implements ToModel, WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // return $row;
        // if($row[0] != "Date" && $row[0] != 'null' && $row[0] != 0){
            if($row[0] != "Date" && $row[0] !=null && $row[0] !=0){
        // if (isset($row[0]) && $row[0] != 'Date') {

            $LastProduct = SaleTax::where('company_id', session()->get('company_id'))
            ->Orderby('id', 'desc')->first();
            $CalculatedCode = 1;
            if($LastProduct){
                $CalculatedCode = $LastProduct->invoice_no + 1;
            }
            // if($row[3] == "WALKING CUSTOMER" || $row[3] == "END USER" || $row[3] == "CASH CUSTOMER" || $row[3] == "UNREGISTERED CUSTOMER"){
            if($row[3] == ""){
                $party = Party::where('ntn', "9999999")
                ->where('company_id', session()->get('company_id'))->first();
            }else{
                $party = Party::where('ntn', $row[3])
                ->where('party_name', $row[2])
                ->where('company_id', session()->get('company_id'))->first();
            }
            
            $scenario = Scenario::where('name', $row[1])->first();
            $productCode = is_numeric($row[5]) ? 
            number_format($row[5], 4, '.', '') : 
            (string) $row[5];
            $product = Product::where('product_code', $productCode)
            ->where('product_name', $row[6])
            ->where('company_id', session()->get('company_id'))->first();
            
            // 1. Create and SAVE the SaleTax model first
            $saleTax = new SaleTax([ 
                'party_id'  => $party->id ?? 0,
                'unregistered_cnicntn'  => $row[4] ?? null,
                'warehouse_id'  => 1,
                'date'  => $this->convertDate($row[0]),
                'sale_type' => "SalesTax Invoice",
                'invoice_no' => $CalculatedCode,
                'scenario_id' => $scenario->id ?? 0,
                'biller'  => Auth::User()->id,
                'advance_income_tax'  => $row[17],
                'total_income_tax'  => $row[18],
                'company_id'  => session()->get('company_id')
            ]);
            $saleTax->save(); // This is CRITICAL - saves to database and generates an ID

            // 2. Now create and SAVE the SaleTaxDetails model using the generated sale_id
            $saleTaxDetail = new SaleTaxDetails([ 
                'sale_id'  => $saleTax->id, // Now this will work
                'sale_type1'  => "SalesTax Invoice", // Now this will work
                'date'  =>  $this->convertDate($row[0]), // Use the same date or appropriate column
                'invoice_no'  => $CalculatedCode,
                'party_id'  => $party->id ?? 0,
                'product_id'  => $product->id ?? 0, // You'll need to get this from your Excel data
                'fbr_uom_desc'  => $row[7], // Replace ? with appropriate column index
                'warehouse_id'  => 1,
                'status'  => "InvoiceOnly",
                'quantity'  => $row[8],
                'rate'  => $row[9],
                'stvalue'  => $row[10],
                // 'stvalue' => ($row[9] == "Exempt") ? "999" : $row[9],
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
                'company_id'  => session()->get('company_id'),
            ]);
            $saleTaxDetail->save();

            // Return the main model as required by ToModel interface
            return $saleTax;
        }

        return null; // Return null for rows that don't meet the condition
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