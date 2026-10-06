<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SaleTypes;
use App\Models\Tax;
use App\Models\Scenario;
use App\Models\Companies;
use App\Models\Party;
use App\Models\Discount;
use App\Models\Setting;
use App\Models\Ledger;
use App\Models\DeliveryChallan;
use App\Models\SaleTax;
use App\Models\SaleTaxDetails;
use App\Models\GeneralVoucher;
use App\Models\LedgerDetailWise;
use App\Models\UOM;
use App\Models\StockRegisterSpecificItem;
use App\Models\SystemLogo;
use App\Models\Warehouse;
use App\Models\RawMaterialStock;
use App\Models\ProductionStock;
use App\Models\SROItemno;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PDF;
use Illuminate\Support\Facades\Response;
class CreditNoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $sales = SaleTax::where('sale_type', 'Debit Note')->OrderBy('id', 'desc')
            ->with(['saletax_details' => function ($query) {
                //$query->with('taxes');
                //$query->with('discount');
                //$query->with('parties');
            }])
            ->with('billers')
            ->where('company_id', session()->get('company_id'))
            ->get();
        //return $sales;
        return view('credit-note.index', compact('sales'));
    }

    public function create()
    {

        $codes = 1;
        $code = SaleTax::where('company_id', session()->get('company_id'))
        ->where('sale_type', 'Debit Note')
        ->OrderBy('invoice_no', 'desc')->first();
        if ($code) {
            $codes = (int)$code->invoice_no + 1;
        }

        $CompanyID = session()->get('company_id');
        // $purchase = json_decode($request->get('purchase'), true);
        $sellerCompany = Companies::where('id', $CompanyID)->first();
        //$codes = $code->last()->invoice_no + 1;
        // $products = Product::OrderBy('product_name', 'asc')->pluck('product_name', 'product_name')->prepend('Start Typing....', '')->toArray();
        if($sellerCompany->invoice_type == "SandBox"){
            //Admin products
           $products = Product::select(
            DB::raw('CONCAT(id, "_", product_code, "_", product_name, "_", tax) AS id'),
            DB::raw('CONCAT(product_code, " - ", product_name) AS product_name')
        )
        ->where('company_id', 0)
        ->orderBy('product_name', 'asc')
        ->pluck('product_name', 'id')
        ->prepend('Select Product', '0')
        ->toArray();
            $customers = Party::where('company_id', 0)
            ->OrderBy('party_name', 'asc')
            ->pluck('party_name', 'id')
            ->prepend('Select Customer', '0');
        }else{
            $products = Product::select(
                DB::raw('CONCAT(id, "_", product_code, "_", product_name, "_", tax) AS id'),
                DB::raw('CONCAT(product_code, " - ", product_name) AS product_name')
            )
            ->where('company_id', session()->get('company_id'))
            ->OrderBy('id', 'asc')
            ->pluck('product_name', 'id')
            ->prepend('Select Product', '0')->toArray();
            $customers = Party::join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
            ->where('parties.account_group_id', '=', 1)
            ->where('parties.party_name', '!=', 'CASH IN HAND')
            // ->orwhere('parties.account_group_id', '=', '7')
            ->where('parties.company_id', session()->get('company_id'))
            ->OrderBy('party_name', 'asc')
            ->pluck('party_name', 'parties.id')
            ->prepend('Select Customer', '0');
        }
      
        //return $products;
        $taxes = Tax::select(DB::raw('CONCAT(`id`, "_", `tax_rate`) AS `tax_rate`, `tax_title`'))->OrderBy('id', 'asc')->pluck('tax_title', 'tax_rate')->toArray();
        $discounts = Discount::select(DB::raw('CONCAT(`id`, "_", `discount`) AS `discount`, `title`'))->OrderBy('id', 'asc')->pluck('title', 'discount')->toArray();
        //$discounts = Discount::OrderBy('id', 'asc')->pluck('title', 'id')->prepend('Select Discount', '0')->toArray();
        //$customers = Party::OrderBy('id', 'asc')->pluck('party_name', 'party_name');
        

        $DeliveryChallan = DeliveryChallan::where('status', '=', 0)
        ->where('type', '=', 'CN')
        ->OrderBy('vr_no', 'asc')->pluck('vr_no', 'vr_no')->prepend('Select Challan', '')->toArray();
        $uoms = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))->OrderBy('id', 'asc')->pluck('uom', 'id')->toArray();

        $warehouse = Warehouse::OrderBy('name', 'asc')->pluck('name', 'id');
        // $scenarios = Scenario::OrderBy('name', 'asc')->pluck('sale_type', 'id');

         $companyscenarios = Companies::where('id', session()->get('company_id'))->first('scenario');
         $decodedScenarios = json_decode($companyscenarios->scenario, true);
          $scenarioCodes = array_column($decodedScenarios, 'scenario');

          $scenarios = Scenario::select('id', DB::raw('CONCAT(`name`, " - ", `sale_type`) AS `scenario_name`'))
               ->whereIn('name', $scenarioCodes)
               ->orderBy('name', 'asc')
               ->pluck('scenario_name', 'id')
               ->prepend('Select Scenario', '')
               ->toArray();
        // return $scenarios = Scenario::select('id', DB::raw('CONCAT(`name`, " - ", `sale_type`) AS `scenario_name`'))
        //        ->wherein('name',  $companyscenarios)
        //         ->orderBy('name', 'asc')
        //        ->pluck('scenario_name', 'id')
        //        ->toArray();
        $sroschedule = collect(['' => 'Choose']);
        $sroitem = collect(['' => 'Choose']);
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());

        return view('credit-note.create', compact('customers', 'products', 'taxes', 'discounts', 'DeliveryChallan', 'codes', 'uoms', 'encrypted_token', 'warehouse', 'scenarios', 'sroschedule', 'sroitem', 'sellerCompany'));
    }

        public function dcChange(Request $request)
    {
        // return $request;
        $CompanyID = session()->get('company_id');
        $DeliveryChallan = DeliveryChallan::with(['challan_details' => function($query){
            $query->with('products:id,product_code,product_name,tax');
        }])
        ->where('vr_no', $request->dc)
        ->where('company_id',  $CompanyID)
        ->where('type',  "DC")
        ->first();
        return Response::json(['data' => $DeliveryChallan]);
        // $partyID = $request->get('party_ID');
        // $data = Party::where('id', '=', $partyID)->get();
        // return $DeliveryChallan;
    }

    public function edit($id)
    {
        // return SaleTax::first();
        $purchase = SaleTax::with(['saletax_details' => function ($query) {
            $query->with('products');
             $query->with('unit');
        }])
            ->with('parties')
            ->where('sale_taxes.id', '=', $id)
            ->where('company_id', session()->get('company_id'))
            ->get();
        // return $purchase[0];
        $DeliveryChallan = DeliveryChallan::where('status', '=', 0)
            ->OrderBy('vr_no', 'asc')
            ->pluck('vr_no', 'vr_no')
            ->prepend('Select Challan', '0')->toArray();
        //$customer = Party::OrderBy('id', 'asc')->pluck('party_name', 'id');
        $edit = $purchase[0];
        //return $edit;
        // $products = Product::select(DB::raw('CONCAT(`id`, "_", `product_name`) AS `id`, `product_name`'))
        //     ->where('company_id', session()->get('company_id'))
        //     ->OrderBy('id', 'asc')
        //     ->pluck('product_name', 'id')
        //     ->prepend('Select Product', '0')
        //     ->toArray();
        // //$taxes = Tax::select(DB::raw('CONCAT(`id`, "_", `tax_rate`) AS `tax_rate`, `tax_title`'))->OrderBy('id', 'asc')->pluck('tax_title', 'tax_rate')->toArray();

        // //$taxes = Tax::select(DB::raw('CONCAT(`id`, "_", `tax_rate`) AS `tax_rate`, `tax_title`'))->OrderBy('tax_title', 'asc')->pluck('tax_title', 'tax_rate')->prepend('Select Tax', '0.00')->toArray();
        // // $customers = Party::OrderBy('party_name', 'asc')->pluck('Party_name', 'id')->prepend('Select Customer', '0')->toArray();
        // $customers = Party::join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
        //     ->where('parties.account_group_id', '=', '1')
        //     // ->orwhere('parties.account_group_id', '=', '7')
        //     ->where('parties.company_id', session()->get('company_id'))
        //     ->OrderBy('party_name', 'asc')
        //     ->pluck('party_name', 'parties.id');
        $uoms = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))->OrderBy('id', 'asc')->pluck('uom', 'id')->toArray();
        $discounts = Discount::select(DB::raw('CONCAT(`id`, "_", `discount`) AS `discount`, `title`'))->OrderBy('id', 'asc')->pluck('title', 'discount')->toArray();
        $warehouse = Warehouse::pluck('name', 'id');
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        $CompanyID = session()->get('company_id');
        // $purchase = json_decode($request->get('purchase'), true);
        $sellerCompany = Companies::where('id', $CompanyID)->first();
        if($sellerCompany->invoice_type == "SandBox"){
            //Admin products
            $products = Product::select(DB::raw('CONCAT(`id`, "_", `product_code`, "_", `product_name`, "_", `tax`) AS `id`, `product_code`, `product_name`, `tax`'))
            ->where('company_id', 0)
            ->OrderBy('id', 'asc')
            ->pluck('product_name', 'id')
            ->prepend('Select Product', '0')->toArray();
            $customers = Party::where('company_id', 0)
            ->OrderBy('party_name', 'asc')
            ->pluck('party_name', 'id')
            ->prepend('Select Customer', '0');
        }else{
             $products = Product::select(DB::raw('CONCAT(`id`, "_", `product_code`, "_", `product_name`, "_", `tax`) AS `id`, `product_code`, `product_name`, `tax`'))
            ->where('company_id', session()->get('company_id'))
            ->OrderBy('id', 'asc')
            ->pluck('product_name', 'id')
            ->prepend('Select Product', '0')->toArray();
            $customers = Party::join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
            ->where('parties.account_group_id', '=', 1)
            ->where('parties.party_name', '!=', 'CASH IN HAND')
            // ->orwhere('parties.account_group_id', '=', '7')
            ->where('parties.company_id', session()->get('company_id'))
            ->OrderBy('party_name', 'asc')
            ->pluck('party_name', 'parties.id')
            ->prepend('Select Customer', '0');
        }
        $companyscenarios = Companies::where('id', session()->get('company_id'))->first('scenario');
        $decodedScenarios = json_decode($companyscenarios->scenario, true);
         $scenarioCodes = array_column($decodedScenarios, 'scenario');

         $scenarios = Scenario::select('id', DB::raw('CONCAT(`name`, " - ", `sale_type`) AS `scenario_name`'))
              ->whereIn('name', $scenarioCodes)
              ->orderBy('name', 'asc')
              ->pluck('scenario_name', 'id')
              ->prepend('Select Scenario', '')
              ->toArray();
              $sroschedule = collect(['' => 'Choose']);
        $sroitem = collect(['' => 'Choose']);
        // $DeliveryChallan = DeliveryChallan::where('status', '=', 0)->OrderBy('vr_no', 'asc')->pluck('vr_no', 'vr_no')->toArray();
        return view('credit-note.edit', compact('sroschedule', 'sroitem', 'scenarios', 'sellerCompany', 'edit', 'products', 'DeliveryChallan', 'customers', 'encrypted_token', 'uoms', 'discounts', 'warehouse'));
    }



 public function store(Request $request)
    { 
        // return $request;
        $this->validate($request, [
            'ref_usin' => 'required',
            'product_id1' => 'required',
            // 'product_code' => 'required',
            'product_name' => 'required',
            'quantity' => 'required',
            'stvalue' => 'required',
            'rate' => 'required',

        ]);
        // return $request;
         $CompanyID = session()->get('company_id');
        // $purchase = json_decode($request->get('purchase'), true);
        $sellerCompany = Companies::where('id', $CompanyID)->first();
        $saletype = SaleTypes::where('id', $sellerCompany->sale_type)->first();
        $buyerCompany = Party::where('id', $request->party_id)->first();
        $scenario = Scenario::where('id', $request->scenario_id)->first();
        $products = $request->get('product_data');
        $saleTypeData = json_decode($saletype);
        $count = count($request->product_code);
        if($sellerCompany->approval == 1){
            $codes = 1;
            $code = SaleTax::where('company_id', $CompanyID)
            ->where('sale_type', 'Debit Note')
            ->OrderBy('invoice_no', 'desc')->first();
            if ($code) {
                $codes = (int)$code->invoice_no + 1;
            }
        
            $purchaseData = new SaleTax();
            $purchaseData->party_id = $request->party_id;
            $purchaseData->warehouse_id = $request->warehouse_id;
            $purchaseData->date = date('Y-m-d', strtotime($request->date));
            $purchaseData->sale_type = $request->sale_type;
            // $purchaseData->invoice_no = $request->invoice_no;
            $purchaseData->invoice_no = $codes;
            $purchaseData->scenario_id = $request->scenario_id;
            // $purchaseData->fbr_invoice_no = $responseData['invoiceNumber'];
            $purchaseData->company_id = $CompanyID;
            $purchaseData->dcn_no = $request->dcn_no;
            $purchaseData->p_order = $request->p_order;
            $purchaseData->remarks = $request->remarks;
            $purchaseData->biller = Auth::User()->id;
            $purchaseData->ref_usin = $request->ref_usin;
            $purchaseData->advance_income_tax = $request->advance_income_tax;
            $purchaseData->total_income_tax = $request->total_income_tax;
            $purchaseData->save();
            $sum = "0";
            $count = count($request->product_code);
            for ($i = 0; $i < $count; $i++) {
                $purchaseDetail = new SaleTaxDetails();
                $purchaseDetail->sale_id = $purchaseData->id;
                $purchaseDetail->date = $purchaseData->date;
                $purchaseDetail->invoice_no = $purchaseData->invoice_no;
                // $purchaseDetail->fbr_invoice_no = $responseData['invoiceNumber']."-".$i+1;
                $purchaseDetail->sale_type1 = $request->sale_type;
                // $purchaseDetail->fbr_invoice_no = $request->fbr_invoice_no;
                $purchaseDetail->product_id = $request->product_id1[$i];
                $purchaseDetail->party_id = $request->party_id;
                $purchaseDetail->company_id = $CompanyID;
                $purchaseDetail->uom_id = $request->uom_id[$i];
                // if(isset($uomData)){
                // $purchaseDetail->fbr_uom_id = $fbr_uoms['fbr_uom_id'][$i];
                // $purchaseDetail->fbr_uom_desc = $fbr_uoms['fbr_uom_desc'][$i];
                // }else{
                $purchaseDetail->fbr_uom_id = $request->uom_id[$i];
                $purchaseDetail->fbr_uom_desc = $request->uom[$i];  
                // }
                $purchaseDetail->status = "InvoiceOnly";
                $purchaseDetail->quantity = $request->quantity[$i];
                $purchaseDetail->rate = $request->rate[$i];
                $purchaseDetail->stvalue = $request->stvalue[$i];
                $purchaseDetail->taxvalue = $request->taxvalue[$i];
                $purchaseDetail->extratax = $request->extratax[$i] ?? 0;
                $purchaseDetail->extraTaxValue = $request->extraTaxValue[$i] ?? 0;
                $purchaseDetail->price = $request->excvalue[$i];
                $purchaseDetail->total = $request->incvalue[$i];
                $purchaseDetail->sro_schd_no = $request->sro_schd_no[$i];
                $purchaseDetail->sro_item_no = $request->sro_item_no[$i];
                $sum = $sum + $request->incvalue[$i];
                $purchaseDetail->save();
            }
            $DeliveryChallan = DeliveryChallan::where('vr_no', $request->dcn_no)
             ->where('company_id',  $CompanyID)
             ->where('type',  "CN")
             ->first();
             if($DeliveryChallan){
              $DeliveryChallan->status = 1;
              $DeliveryChallan->save();
             }
            
            Session::flash('flash_message', 'Debit Note Draft Successfully Saved.');
            return redirect('debit-note/create');
        }else{
                    //  return $count;
        for ($i = 0; $i < $count; $i++) {
            //Get Unit From FBR
            // $curl = curl_init();
            // curl_setopt_array($curl, [
            //     // CURLOPT_URL => 'https://gw.fbr.gov.pk/pdi/v1/HS_UOM?hs_code=$request->product_code[$i]&annexure_id=3',
            //     CURLOPT_URL => 'https://gw.fbr.gov.pk/pdi/v1/HS_UOM?hs_code=' . urlencode($request->product_code[$i]) . '&annexure_id=3',
            //     CURLOPT_RETURNTRANSFER => true,
            //     CURLOPT_ENCODING => '',
            //     CURLOPT_MAXREDIRS => 10,
            //     CURLOPT_TIMEOUT => 0,
            //     CURLOPT_FOLLOWLOCATION => true,
            //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //     CURLOPT_CUSTOMREQUEST => 'GET',
            //     CURLOPT_HTTPHEADER => [
            //         'Authorization: Bearer "' . $sellerCompany['sandbox_token'] . '"',
            //         // 'Content-Type: application/json',
            //         'Cookie: key=value; JSESSIONID=IYFCgbVx4GhV2E-MMPlepV3DlG8b0HU4N_la2DUA.i01-irisdmz56; cookiesession1=678B2A2CB3F1FF7FD24B6E462AB80DD1'
            //     ],
            // ]);
            // $response = curl_exec($curl);
            // $uomData = json_decode($response, true);
            // return $uomData;
            //End Get Unit From FBR
            // $responseData[0]['description'];


            // if(isset($uomData)){
            //     $unit = $uomData[0]['description'];
            // }else{
            //     $unit = $request->uom[$i];
            // }
            $currentproduct = Product::where('id', $request->product_id1[$i])->first('tax');
            if($currentproduct->tax == 999){
                $taxrate = "Exempt";
            }else{
                $taxrate = $request->stvalue[$i].'%';
            }
            // return $request;
            if($sellerCompany->st_held == 1){
                //20% of tax value
                $stheld = round($request->taxvalue[$i]/100*20);
            }else{
                $stheld = 0;
            }
            if($scenario->sale_type == "3rd Schedule Goods"){
                $RetailPrice = $request->rate[$i];
            }else{
                // $RetailPrice = $request->excvalue[$i];
                $RetailPrice = 0;
            }
            // return $stheld;
            $items[] = [
                "hsCode" => $request->product_code[$i],
                "productDescription" => $request->product_name[$i],
                "rate" => $taxrate,
                "uoM" => $request->uom[$i],
                // "uoM" => $uomData[0]['uoM_ID'],
                // "uom_desc" => $uomData[0]['description'],
                "quantity" => $request->quantity[$i],
                "totalValues" => $request->incvalue[$i],
                "valueSalesExcludingST" => $request->excvalue[$i],
                "fixedNotifiedValueOrRetailPrice" => $RetailPrice,
                "salesTaxApplicable" => $request->taxvalue[$i],
                "salesTaxWithheldAtSource" => $stheld,
                "extraTax" => $request->extraTaxValue[$i] == 0 ? "" : $request->extraTaxValue[$i],
                "furtherTax" => 0,
                // "sroScheduleNo" => "6th Schd Table II",
                "sroScheduleNo" => $request->sro_schd_no[$i],
                "fedPayable" => 0,
                "discount" => 0,
                "saleType" => $scenario->sale_type,
                // "sroItemSerialNo" => "10"
                "sroItemSerialNo" => $request->sro_item_no[$i]
            ];

            // if(isset($uomData)){
            //     $fbr_uom_id[] = $uomData[0]['uoM_ID'];
            //     $fbr_uom_desc[] = $uomData[0]['description'];
            // }
            
        }
        // if(isset($uomData)){
        // $fbr_uoms = [
        //     "fbr_uom_id" => array_map('strval', $fbr_uom_id),
        //     "fbr_uom_desc" => array_map('strval', $fbr_uom_desc)
        // ];
        // }
        // $fbr_uoms = json_decode($jsonString, true);
        
        // return $fbr_uoms;

      $payload = [
        //   "invoiceType" => "Debit Note",
          "invoiceType" => "Debit Note",
          "invoiceDate" => $request->date,
          "sellerBusinessName" => $sellerCompany['CompanyName'],
          "sellerProvince" => $sellerCompany['province'],
          "sellerAddress" => $sellerCompany['address'],
          "sellerNTNCNIC" => $sellerCompany['ntn'],
          "buyerNTNCNIC" => $buyerCompany->ntn,
          "buyerBusinessName" => $buyerCompany->party_name,
          "buyerProvince" => $buyerCompany->province,
          "buyerAddress" => $buyerCompany->address,
          "buyerRegistrationType" => $buyerCompany->customer_type,
          "scenarioId" => $scenario->name,
        //   "invoiceRefNo" => $request->ref_usin,
          "invoiceRefNo" => $request->ref_usin,
          "items" => $items  // This is where your dynamic items go
      ];

    //    return $payload;
      
      $headers = [
          'Content-Type: application/json',
          'Cookie: key=value; JSESSIONID=IYFCgbVx4GhV2E-MMPlepV3DlG8b0HU4N_la2DUA.i01-irisdmz56; cookiesession1=678B2A2CB3F1FF7FD24B6E462AB80DD1'
      ];
      
      // Only modify the Authorization line with condition
      if ($sellerCompany->invoice_type == "Live") {
          // return $sellerCompany;
          $headers[] = 'Authorization: Bearer ' . $sellerCompany->token;  // Without extra quotes
          $apiUrl = 'https://gw.fbr.gov.pk/di_data/v1/di/postinvoicedata';
      } else {
          $headers[] = 'Authorization: Bearer ' . $sellerCompany->sandbox_token;  // Fallback token
          $apiUrl = 'https://gw.fbr.gov.pk/di_data/v1/di/postinvoicedata_sb';
      }
      
      $curl = curl_init();
      curl_setopt_array($curl, [
          CURLOPT_URL => $apiUrl,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => json_encode($payload),  // Convert entire payload to JSON
          CURLOPT_HTTPHEADER => $headers,
          // CURLOPT_HTTPHEADER => [
          //     'Authorization: Bearer "' . $sellerCompany['token'] . '"',
          //     'Content-Type: application/json',
          //     'Cookie: key=value; JSESSIONID=IYFCgbVx4GhV2E-MMPlepV3DlG8b0HU4N_la2DUA.i01-irisdmz56; cookiesession1=678B2A2CB3F1FF7FD24B6E462AB80DD1'
          // ],
      ]);
      
      $response = curl_exec($curl);
      curl_close($curl);
    //   return $response;
      $responseData = json_decode($response, true);
      if(isset($responseData['validationResponse']['statusCode']) && 
      $responseData['validationResponse']['statusCode'] === '00') 
      {
        if ($sellerCompany->invoice_type == "Live") 
        {
            $codes = 1;
            $code = SaleTax::where('company_id', $CompanyID)
            ->where('type', 'CN')
            ->OrderBy('invoice_no', 'desc')->first();
            if ($code) {
                $codes = (int)$code->invoice_no + 1;
            }
        
            $purchaseData = new SaleTax();
            $purchaseData->party_id = $request->party_id;
            $purchaseData->warehouse_id = $request->warehouse_id;
            $purchaseData->date = date('Y-m-d', strtotime($request->date));
            $purchaseData->sale_type = $request->sale_type;
            // $purchaseData->invoice_no = $request->invoice_no;
            $purchaseData->invoice_no = $codes;
            $purchaseData->scenario_id = $request->scenario_id;
            $purchaseData->fbr_invoice_no = $responseData['invoiceNumber'];
            $purchaseData->company_id = $CompanyID;
            $purchaseData->dcn_no = $request->dcn_no;
            $purchaseData->p_order = $request->p_order;
            $purchaseData->remarks = $request->remarks;
            $purchaseData->biller = Auth::User()->id;
            $purchaseData->ref_usin = $request->ref_usin;
            $purchaseData->advance_income_tax = $request->advance_income_tax;
            $purchaseData->total_income_tax = $request->total_income_tax;
            $purchaseData->save();
            $sum = "0";
            $count = count($request->product_code);
            for ($i = 0; $i < $count; $i++) {
                $purchaseDetail = new SaleTaxDetails();
                $purchaseDetail->sale_id = $purchaseData->id;
                $purchaseDetail->date = $purchaseData->date;
                $purchaseDetail->invoice_no = $purchaseData->invoice_no;
                $purchaseDetail->fbr_invoice_no = $responseData['invoiceNumber']."-".$i+1;
                $purchaseDetail->sale_type1 = $request->sale_type;
                // $purchaseDetail->fbr_invoice_no = $request->fbr_invoice_no;
                $purchaseDetail->product_id = $request->product_id1[$i];
                $purchaseDetail->party_id = $request->party_id;
                $purchaseDetail->company_id = $CompanyID;
                $purchaseDetail->uom_id = $request->uom_id[$i];
                // if(isset($uomData)){
                // $purchaseDetail->fbr_uom_id = $fbr_uoms['fbr_uom_id'][$i];
                // $purchaseDetail->fbr_uom_desc = $fbr_uoms['fbr_uom_desc'][$i];
                // }else{
                $purchaseDetail->fbr_uom_id = $request->uom_id[$i];
                $purchaseDetail->fbr_uom_desc = $request->uom[$i];  
                // }
                $purchaseDetail->status = "InvoiceOnly";
                $purchaseDetail->quantity = $request->quantity[$i];
                $purchaseDetail->rate = $request->rate[$i];
                $purchaseDetail->stvalue = $request->stvalue[$i];
                $purchaseDetail->taxvalue = $request->taxvalue[$i];
                $purchaseDetail->extratax = $request->extratax[$i] ?? 0;
                $purchaseDetail->extraTaxValue = $request->extraTaxValue[$i] ?? 0;
                $purchaseDetail->price = $request->excvalue[$i];
                $purchaseDetail->total = $request->incvalue[$i];
                $purchaseDetail->sro_schd_no = $request->sro_schd_no[$i];
                $purchaseDetail->sro_item_no = $request->sro_item_no[$i];
                $sum = $sum + $request->incvalue[$i];
                $purchaseDetail->save();

                $DeliveryChallan = DeliveryChallan::where('vr_no', $request->dcn_no)
             ->where('company_id',  $CompanyID)
             ->where('type',  "CN")
             ->first();
            $DeliveryChallan->status = 1;
            $DeliveryChallan->save();


                $recipe = Product::where('id', $request->product_id1[$i])->first();
                // $product['product_id'];
                if ($recipe['has_recipe'] == "1") {
                    $RawMaterial = new ProductionStock();
                    $RawMaterial->pro_transfer_id = $purchaseData->id;
                    $RawMaterial->company_id = $CompanyID;
                    $RawMaterial->warehouse_id = 1;
                    $RawMaterial->product_id = $request->product_id1[$i];
                    $RawMaterial->uom_id = $request->uom_id[$i] ?? null;
                    $RawMaterial->date = $purchaseData->date;
                    $RawMaterial->voucher_no = $purchaseData->invoice_no;
                    $RawMaterial->cost_amount = $request->incvalue[$i];
                    $RawMaterial->stockin = $request->quantity[$i];
                    $RawMaterial->save();
                } else {
                    $RawMaterial = new RawMaterialStock();
                    $RawMaterial->transction_id = $purchaseData->id;
                    $RawMaterial->type = $request->sale_type;
                    $RawMaterial->party_id = $request->party_id;
                    $RawMaterial->warehouse_id = 1;
                    // $RawMaterial->sale_id = $purchaseData['id'];
                    $RawMaterial->product_id = $request->product_id1[$i];
                    $RawMaterial->uom_id = $request->uom_id[$i] ?? null;
                    $RawMaterial->date = $purchaseData->date;
                    $RawMaterial->voucher_no = $purchaseData->invoice_no;
                    // $RawMaterial->cost_amount = $product['cost_amount'];
                    $RawMaterial->stockin = $request->quantity[$i];
                    $RawMaterial->company_id = $CompanyID;
                    $RawMaterial->save();
                }

                    $vouchers = new GeneralVoucher();
                    $vouchers->transaction_id = $purchaseData->id;
                    $vouchers->account_head_id = $purchaseData['party_id'];
                    $vouchers->warehouse_id = 1;
                    $vouchers->date = $purchaseData->date;
                    $vouchers->voucher_no = $purchaseData->invoice_no;
                    $vouchers->v_type = $request->sale_type;
                    $vouchers->company_id = $CompanyID;
                    $vouchers->credit = $request->incvalue[$i];
                    // $vouchers->debit = $sum;
                    $vouchers->save();
    
                    $vouchers = new GeneralVoucher();
                    $vouchers->transaction_id = $purchaseData->id;
                    $vouchers->account_head_id = 2;
                    $vouchers->warehouse_id = 1;
                    $vouchers->date = $purchaseData->date;
                    $vouchers->voucher_no = $purchaseData->invoice_no;
                    $vouchers->v_type = $request->sale_type;
                    $vouchers->company_id = $CompanyID;
                    $vouchers->debit = $request->incvalue[$i];
                    // $vouchers->credit = $sum;
                    $vouchers->save();

            }
        }
        // Session::flash('error_message', 'FBR portal is upgrading! Kindly try again after sometime.');
        Session::flash('flash_message', 'Record Successfully Added!');
        return redirect('debit-note/create');

      } 
      else {
        $errorMessage = $responseData['validationResponse']['error'] ?? 'Unknown API error';
        $errorCode = $responseData['validationResponse']['statusCode'] ?? 'UNKNOWN_CODE';
        // Set all error information in the session
        Session::flash('error', 'Failed with error: ' . $errorMessage);
        Session::flash('error_code', $errorCode);
        Session::flash('error_details', $responseData['validationResponse']['details'] ?? null);

        return redirect('debit-note/create')->with('error', 'Failed with error: ' . $errorMessage);
        // API Error
        return [
          'status' => 'error',
          'message' => $responseData['validationResponse']['error'] ?? 'Unknown API error',
          'code' => $responseData['validationResponse']['statusCode'] ?? 'UNKNOWN_CODE',
          'fullResponse' => $responseData // Optional: include for debugging
        ];
      }
        }



        // Session::flash('flash_message', 'Record Successfully Added!');
        // $url = "credit-note/print/" . $purchaseData->id;
        // $urlindex = "credit-note/create";

        // return "<script>window.open('" . $url . "', '_blank')</script>
        // 		<script>window.location.href='" . $urlindex . "';</script>";
    }

    public function show($id)
    {
        $newsale_detail = SaleTax::with(['saletax_details' => function ($query) {
            $query->with('unit')->with(['products' => function ($query) {
            }]);
            //$query->with('taxes');
            //$query->with('discount');
            //$query->with('ledger');
            //$query->with('publishers');
        }])->with('parties')->with('shop') //->with('billers')
            ->where('sale_taxes.id', '=', $id)
            ->where('company_id', session()->get('company_id'))
            ->get();
        $ledgers = Ledger::with('ledger_party')
            // ->where('party_id', '=', $newsale_detail[0]->parties->id)
            ->get();
        // return $newsale_detail;

        $company_detail = Setting::where('id', '=', 1)->get();
        $logo = SystemLogo::where('id', '=', 1)->get();
        // return $company_detail;

        return view('credit-note.invoice', compact('newsale_detail', 'company_detail', 'ledgers', 'logo', 'id'));
    }

    public function approve1233($id){
        // return $id;
            $sales = SaleTax::with(['saletax_details' => function ($query) {
            $query->with('products:id,product_code,product_name,uom_id,uom,tax');
             $query->with('unit');
        }])
            ->with('parties:id,party_name,ntn,province,customer_type,address')
            ->where('id', '=', $id)
            ->where('company_id', session()->get('company_id'))
            ->first();

            $CompanyID = session()->get('company_id');
            // $purchase = json_decode($request->get('purchase'), true);
            $sellerCompany = Companies::where('id', $CompanyID)->first();
            $saletype = SaleTypes::where('id', $sellerCompany->sale_type)->first();
            $buyerCompany = Party::where('id', $sales->party_id)->first();
            $scenario = Scenario::where('id', $sales->scenario_id)->first();

            foreach($sales->saletax_details as $data){
                 $currentproduct = Product::where('id', $data->product_id)->first('tax');
                if($currentproduct->tax == 999){
                    $taxrate = "Exempt";
                }else{
                    $taxrate = $data->stvalue.'%';
                }

                if($sellerCompany->st_held == 1){
                    //20% of tax value
                     $stheld = round($data->taxvalue/100*20);
                }else{
                     $stheld = 0;
                }
                if($scenario->sale_type == "3rd Schedule Goods"){
                    $RetailPrice = $data->rate;
                }else{
                    // $RetailPrice = $request->excvalue[$i];
                    $RetailPrice = 0;
                }
                // return $data;
                $items[] = [
                    "hsCode" => $data->products->product_code,
                    "productDescription" => $data->products->product_name,
                    "rate" => $taxrate,
                    "uoM" => $data->fbr_uom_desc,
                    // "uoM" => $uomData[0]['uoM_ID'],
                    // "uom_desc" => $uomData[0]['description'],
                    "quantity" => $data->quantity,
                    "totalValues" => $data->total,
                    "valueSalesExcludingST" => $data->price,
                    "fixedNotifiedValueOrRetailPrice" => $RetailPrice,
                    "salesTaxApplicable" => $data->taxvalue,
                    "salesTaxWithheldAtSource" => $stheld,
                    "extraTax" => $data->extraTaxValue == 0 ? "" : $data->extraTaxValue,
                    "furtherTax" => 0,
                    // "sroScheduleNo" => "6th Schd Table II",
                    "sroScheduleNo" => $data->sro_schd_no,
                    "fedPayable" => 0,
                    "discount" => 0,
                    "saleType" => $scenario->sale_type,
                    // "sroItemSerialNo" => "10"
                    "sroItemSerialNo" => $data->sro_item_no
                ];
                // return $items;
            }
            // return $scenario;
            $payload = [
                //   "invoiceType" => "Debit Note",
                  "invoiceType" => "Debit Note",
                  "invoiceDate" => $sales->date,
                  "sellerBusinessName" => $sellerCompany['CompanyName'],
                  "sellerProvince" => $sellerCompany['province'],
                  "sellerAddress" => $sellerCompany['address'],
                  "sellerNTNCNIC" => $sellerCompany['ntn'],
                  "buyerNTNCNIC" => $buyerCompany->ntn,
                  "buyerBusinessName" => $buyerCompany->party_name,
                  "buyerProvince" => $buyerCompany->province,
                  "buyerAddress" => $buyerCompany->address,
                  "buyerRegistrationType" => $buyerCompany->customer_type,
                  "scenarioId" => $scenario->name,
                //   "invoiceRefNo" => $request->ref_usin,
                  "invoiceRefNo" => "",
                  "items" => $items  // This is where your dynamic items go
              ];
            //   return $payload;

            $headers = [
                'Content-Type: application/json',
                'Cookie: key=value; JSESSIONID=IYFCgbVx4GhV2E-MMPlepV3DlG8b0HU4N_la2DUA.i01-irisdmz56; cookiesession1=678B2A2CB3F1FF7FD24B6E462AB80DD1'
            ];
            
            // Only modify the Authorization line with condition
            if ($sellerCompany->invoice_type == "Live") {
                // return $sellerCompany;
                $headers[] = 'Authorization: Bearer ' . $sellerCompany->token;  // Without extra quotes
                $apiUrl = 'https://gw.fbr.gov.pk/di_data/v1/di/postinvoicedata';
            } else {
                $headers[] = 'Authorization: Bearer ' . $sellerCompany->sandbox_token;  // Fallback token
                $apiUrl = 'https://gw.fbr.gov.pk/di_data/v1/di/postinvoicedata_sb';
            }
            
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $apiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($payload),  // Convert entire payload to JSON
                CURLOPT_HTTPHEADER => $headers,
                // CURLOPT_HTTPHEADER => [
                //     'Authorization: Bearer "' . $sellerCompany['token'] . '"',
                //     'Content-Type: application/json',
                //     'Cookie: key=value; JSESSIONID=IYFCgbVx4GhV2E-MMPlepV3DlG8b0HU4N_la2DUA.i01-irisdmz56; cookiesession1=678B2A2CB3F1FF7FD24B6E462AB80DD1'
                // ],
            ]);
            
            $response = curl_exec($curl);
            curl_close($curl);
            $responseData = json_decode($response, true);

        //     $response = curl_exec($curl);
        //   curl_close($curl);
        //   $responseData = json_decode($response, true);
          if(isset($responseData['validationResponse']['statusCode']) && 
          $responseData['validationResponse']['statusCode'] === '00') 
          {
            if ($sellerCompany->invoice_type == "Live") 
            {
                // $codes = 1;
                // $code = SaleTax::where('company_id', $CompanyID)
                // ->OrderBy('invoice_no', 'desc')->first();
                // if ($code) {
                //     $codes = (int)$code->invoice_no + 1;
                // }
            
                // $purchaseData = new SaleTax();
                // $purchaseData->party_id = $request->party_id;
                // $purchaseData->warehouse_id = $request->warehouse_id;
                // $purchaseData->date = date('Y-m-d', strtotime($request->date));
                // $purchaseData->sale_type = $request->sale_type;
                // $purchaseData->invoice_no = $codes;
                // $purchaseData->fbr_invoice_no = $responseData['invoiceNumber'];
                // $purchaseData->company_id = $CompanyID;
                // $purchaseData->dcn_no = $request->dcn_no;
                // $purchaseData->p_order = $request->p_order;
                // $purchaseData->remarks = $request->remarks;
                // $purchaseData->biller = Auth::User()->id;
                // $purchaseData->ref_usin = $request->ref_usin;
                // $purchaseData->save();
                $sum = 0;
                // $count = count($request->product_code);
                // for ($i = 0; $i < $count; $i++) {
                
                    foreach($sales->saletax_details as $data)
                {
                $sum = $sum + 1;
    
                    $recipe = Product::where('id', $data->product_id)->first();
                    // $product['product_id'];
                    if ($recipe['has_recipe'] == "1") {
                        $RawMaterial = new ProductionStock();
                        $RawMaterial->pro_transfer_id = $sales->id;
                        $RawMaterial->company_id = $CompanyID;
                        $RawMaterial->warehouse_id = 1;
                        $RawMaterial->product_id = $data->product_id1[$i];
                        $RawMaterial->uom_id = $data->uom_id[$i] ?? null;
                        $RawMaterial->date = $sales->date;
                        $RawMaterial->voucher_no = $sales->invoice_no;
                        $RawMaterial->cost_amount = $data->incvalue[$i];
                        $RawMaterial->stockin = $data->quantity[$i];
                        $RawMaterial->save();
                    } else {
                        $RawMaterial = new RawMaterialStock();
                        $RawMaterial->transction_id = $sales->id;
                        $RawMaterial->type = $sales->sale_type;
                        $RawMaterial->party_id = $data->party_id;
                        $RawMaterial->warehouse_id = 1;
                        // $RawMaterial->sale_id = $purchaseData['id'];
                        $RawMaterial->product_id = $data->product_id;
                        $RawMaterial->uom_id = $data->uom_id ?? null;
                        $RawMaterial->date = $sales->date;
                        $RawMaterial->voucher_no = $sales->invoice_no;
                        // $RawMaterial->cost_amount = $product['cost_amount'];
                        $RawMaterial->stockin = $data->quantity;
                        $RawMaterial->company_id = $CompanyID;
                        $RawMaterial->save();
                    }
    
                        $vouchers = new GeneralVoucher();
                        $vouchers->transaction_id = $sales->id;
                        $vouchers->account_head_id = $sales['party_id'];
                        $vouchers->warehouse_id = 1;
                        $vouchers->date = $sales->date;
                        $vouchers->voucher_no = $sales->invoice_no;
                        $vouchers->v_type = $sales->sale_type;
                        $vouchers->company_id = $CompanyID;
                        $vouchers->credit = $data->incvalue;
                        $vouchers->save();
        
                        $vouchers = new GeneralVoucher();
                        $vouchers->transaction_id = $sales->id;
                        $vouchers->account_head_id = 2;
                        $vouchers->warehouse_id = 1;
                        $vouchers->date = $sales->date;
                        $vouchers->voucher_no = $sales->invoice_no;
                        $vouchers->v_type = $sales->sale_type;
                        $vouchers->company_id = $CompanyID;
                        $vouchers->debit = $data->incvalue;
                        $vouchers->save();
                    // return $data;
                        $data->fbr_invoice_no = $responseData['invoiceNumber'].'-'. $sum;
                        $data->save();
                }
               
                // }
            }
            $sales->fbr_invoice_no = $responseData['invoiceNumber'];
            $sales->save();
            // Session::flash('error_message', 'FBR portal is upgrading! Kindly try again after sometime.');
            Session::flash('flash_message', 'Credit Note posted to fbr Successfully!');
            return redirect()->back();
            // return redirect('salestax/create');
    
          } 
          else {
            $errorMessage = $responseData['validationResponse']['error'] ?? 'Unknown API error';
            $errorCode = $responseData['validationResponse']['statusCode'] ?? 'UNKNOWN_CODE';
            // Set all error information in the session
            Session::flash('error', 'Failed with error: ' . $errorMessage);
            Session::flash('error_code', $errorCode);
            Session::flash('error_details', $responseData['validationResponse']['details'] ?? null);
    
            return redirect('credit-note/create')->with('error', 'Failed with error: ' . $errorMessage);
            // API Error
            return [
              'status' => 'error',
              'message' => $responseData['validationResponse']['error'] ?? 'Unknown API error',
              'code' => $responseData['validationResponse']['statusCode'] ?? 'UNKNOWN_CODE',
              'fullResponse' => $responseData // Optional: include for debugging
            ];
          }


            // for ($i = 0; $i < $count; $i++) {
            //     // $currentproduct = Product::where('id', $request->product_id1[$i])->first('tax');
            //     // if($currentproduct->tax == 999){
            //     //     $taxrate = "Exempt";
            //     // }else{
            //     //     $taxrate = $request->stvalue[$i].'%';
            //     // }
            //     // // return $request;
            //     // if($sellerCompany->st_held == 1){
            //     //     //20% of tax value
            //     //     $stheld = round($request->taxvalue[$i]/100*20);
            //     // }else{
            //     //     $stheld = 0;
            //     // }
            //     // if($scenario->sale_type == "3rd Schedule Goods"){
            //     //     $RetailPrice = $request->rate[$i];
            //     // }else{
            //     //     // $RetailPrice = $request->excvalue[$i];
            //     //     $RetailPrice = 0;
            //     // }
            //     // return $stheld;
            //     // $items[] = [
            //     //     "hsCode" => $request->product_code[$i],
            //     //     "productDescription" => $request->product_name[$i],
            //     //     "rate" => $taxrate,
            //     //     "uoM" => $request->uom[$i],
            //     //     // "uoM" => $uomData[0]['uoM_ID'],
            //     //     // "uom_desc" => $uomData[0]['description'],
            //     //     "quantity" => $request->quantity[$i],
            //     //     "totalValues" => $request->incvalue[$i],
            //     //     "valueSalesExcludingST" => $request->excvalue[$i],
            //     //     "fixedNotifiedValueOrRetailPrice" => $RetailPrice,
            //     //     "salesTaxApplicable" => $request->taxvalue[$i],
            //     //     "salesTaxWithheldAtSource" => $stheld,
            //     //     "extraTax" => $request->extraTaxValue[$i] == 0 ? "" : $request->extraTaxValue[$i],
            //     //     "furtherTax" => 0,
            //     //     // "sroScheduleNo" => "6th Schd Table II",
            //     //     "sroScheduleNo" => $request->sro_schd_no[$i],
            //     //     "fedPayable" => 0,
            //     //     "discount" => 0,
            //     //     "saleType" => $scenario->sale_type,
            //     //     // "sroItemSerialNo" => "10"
            //     //     "sroItemSerialNo" => $request->sro_item_no[$i]
            //     // ];
                
            // }
    
        //   $payload = [
        //     //   "invoiceType" => "Debit Note",
        //       "invoiceType" => "Sale Invoice",
        //       "invoiceDate" => $request->date,
        //       "sellerBusinessName" => $sellerCompany['CompanyName'],
        //       "sellerProvince" => $sellerCompany['province'],
        //       "sellerAddress" => $sellerCompany['address'],
        //       "sellerNTNCNIC" => $sellerCompany['ntn'],
        //       "buyerNTNCNIC" => $buyerCompany->ntn,
        //       "buyerBusinessName" => $buyerCompany->party_name,
        //       "buyerProvince" => $buyerCompany->province,
        //       "buyerAddress" => $buyerCompany->address,
        //       "buyerRegistrationType" => $buyerCompany->customer_type,
        //       "scenarioId" => $scenario->name,
        //     //   "invoiceRefNo" => $request->ref_usin,
        //       "invoiceRefNo" => "",
        //       "items" => $items  // This is where your dynamic items go
        //   ];
        //   return $payload;
          
        //   $headers = [
        //       'Content-Type: application/json',
        //       'Cookie: key=value; JSESSIONID=IYFCgbVx4GhV2E-MMPlepV3DlG8b0HU4N_la2DUA.i01-irisdmz56; cookiesession1=678B2A2CB3F1FF7FD24B6E462AB80DD1'
        //   ];
          
        //   // Only modify the Authorization line with condition
        //   if ($sellerCompany->invoice_type == "Live") {
        //       // return $sellerCompany;
        //       $headers[] = 'Authorization: Bearer ' . $sellerCompany->token;  // Without extra quotes
        //       $apiUrl = 'https://gw.fbr.gov.pk/di_data/v1/di/postinvoicedata';
        //   } else {
        //       $headers[] = 'Authorization: Bearer ' . $sellerCompany->sandbox_token;  // Fallback token
        //       $apiUrl = 'https://gw.fbr.gov.pk/di_data/v1/di/postinvoicedata_sb';
        //   }
          
        //   $curl = curl_init();
        //   curl_setopt_array($curl, [
        //       CURLOPT_URL => $apiUrl,
        //       CURLOPT_RETURNTRANSFER => true,
        //       CURLOPT_ENCODING => '',
        //       CURLOPT_MAXREDIRS => 10,
        //       CURLOPT_TIMEOUT => 0,
        //       CURLOPT_FOLLOWLOCATION => true,
        //       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //       CURLOPT_CUSTOMREQUEST => 'POST',
        //       CURLOPT_POSTFIELDS => json_encode($payload),  // Convert entire payload to JSON
        //       CURLOPT_HTTPHEADER => $headers,
        //   ]);
          
        //   $response = curl_exec($curl);
        //   curl_close($curl);
        //   $responseData = json_decode($response, true);
        //   if(isset($responseData['validationResponse']['statusCode']) && 
        //   $responseData['validationResponse']['statusCode'] === '00') 
        //   {
        //     if ($sellerCompany->invoice_type == "Live") 
        //     {
        //         $codes = 1;
        //         $code = SaleTax::where('company_id', $CompanyID)
        //         ->OrderBy('invoice_no', 'desc')->first();
        //         if ($code) {
        //             $codes = (int)$code->invoice_no + 1;
        //         }
            
        //         $purchaseData = new SaleTax();
        //         $purchaseData->party_id = $request->party_id;
        //         $purchaseData->warehouse_id = $request->warehouse_id;
        //         $purchaseData->date = date('Y-m-d', strtotime($request->date));
        //         $purchaseData->sale_type = $request->sale_type;
        //         // $purchaseData->invoice_no = $request->invoice_no;
        //         $purchaseData->invoice_no = $codes;
        //         $purchaseData->fbr_invoice_no = $responseData['invoiceNumber'];
        //         $purchaseData->company_id = $CompanyID;
        //         $purchaseData->dcn_no = $request->dcn_no;
        //         $purchaseData->p_order = $request->p_order;
        //         $purchaseData->remarks = $request->remarks;
        //         $purchaseData->biller = Auth::User()->id;
        //         $purchaseData->ref_usin = $request->ref_usin;
        //         $purchaseData->save();
        //         $sum = "0";
        //         $count = count($request->product_code);
        //         for ($i = 0; $i < $count; $i++) {
        //             $purchaseDetail = new SaleTaxDetails();
        //             $purchaseDetail->sale_id = $purchaseData->id;
        //             $purchaseDetail->date = $purchaseData->date;
        //             $purchaseDetail->invoice_no = $purchaseData->invoice_no;
        //             $purchaseDetail->fbr_invoice_no = $responseData['invoiceNumber']."-".$i+1;
        //             $purchaseDetail->sale_type1 = $request->sale_type;
        //             // $purchaseDetail->fbr_invoice_no = $request->fbr_invoice_no;
        //             $purchaseDetail->product_id = $request->product_id1[$i];
        //             $purchaseDetail->party_id = $request->party_id;
        //             $purchaseDetail->company_id = $CompanyID;
        //             $purchaseDetail->uom_id = $request->uom_id[$i];
        //             // if(isset($uomData)){
        //             // $purchaseDetail->fbr_uom_id = $fbr_uoms['fbr_uom_id'][$i];
        //             // $purchaseDetail->fbr_uom_desc = $fbr_uoms['fbr_uom_desc'][$i];
        //             // }else{
        //             $purchaseDetail->fbr_uom_id = $request->uom_id[$i];
        //             $purchaseDetail->fbr_uom_desc = $request->uom[$i];  
        //             // }
        //             $purchaseDetail->status = "InvoiceOnly";
        //             $purchaseDetail->quantity = $request->quantity[$i];
        //             $purchaseDetail->rate = $request->rate[$i];
        //             $purchaseDetail->stvalue = $request->stvalue[$i];
        //             $purchaseDetail->taxvalue = $request->taxvalue[$i];
        //             $purchaseDetail->extratax = $request->extratax[$i] ?? 0;
        //             $purchaseDetail->extraTaxValue = $request->extraTaxValue[$i] ?? 0;
        //             $purchaseDetail->price = $request->excvalue[$i];
        //             $purchaseDetail->total = $request->incvalue[$i];
        //             $sum = $sum + $request->incvalue[$i];
        //             $purchaseDetail->save();
    
    
        //             $recipe = Product::where('id', $request->product_id1[$i])->first();
        //             // $product['product_id'];
        //             if ($recipe['has_recipe'] == "1") {
        //                 $RawMaterial = new ProductionStock();
        //                 $RawMaterial->pro_transfer_id = $purchaseData->id;
        //                 $RawMaterial->company_id = $CompanyID;
        //                 $RawMaterial->warehouse_id = 1;
        //                 $RawMaterial->product_id = $request->product_id1[$i];
        //                 $RawMaterial->uom_id = $request->uom_id[$i] ?? null;
        //                 $RawMaterial->date = $purchaseData->date;
        //                 $RawMaterial->voucher_no = $purchaseData->invoice_no;
        //                 $RawMaterial->cost_amount = $request->incvalue[$i];
        //                 $RawMaterial->stockout = $request->quantity[$i];
        //                 $RawMaterial->save();
        //             } else {
        //                 $RawMaterial = new RawMaterialStock();
        //                 $RawMaterial->transction_id = $purchaseData->id;
        //                 $RawMaterial->type = $request->sale_type;
        //                 $RawMaterial->party_id = $request->party_id;
        //                 $RawMaterial->warehouse_id = 1;
        //                 // $RawMaterial->sale_id = $purchaseData['id'];
        //                 $RawMaterial->product_id = $request->product_id1[$i];
        //                 $RawMaterial->uom_id = $request->uom_id[$i] ?? null;
        //                 $RawMaterial->date = $purchaseData->date;
        //                 $RawMaterial->voucher_no = $purchaseData->invoice_no;
        //                 // $RawMaterial->cost_amount = $product['cost_amount'];
        //                 $RawMaterial->stockout = $request->quantity[$i];
        //                 $RawMaterial->company_id = $CompanyID;
        //                 $RawMaterial->save();
        //             }
    
        //                 $vouchers = new GeneralVoucher();
        //                 $vouchers->transaction_id = $purchaseData->id;
        //                 $vouchers->account_head_id = $purchaseData['party_id'];
        //                 $vouchers->warehouse_id = 1;
        //                 $vouchers->date = $purchaseData->date;
        //                 $vouchers->voucher_no = $purchaseData->invoice_no;
        //                 $vouchers->v_type = $request->sale_type;
        //                 $vouchers->company_id = $CompanyID;
        //                 $vouchers->debit = $request->incvalue[$i];
        //                 // $vouchers->debit = $sum;
        //                 $vouchers->save();
        
        //                 $vouchers = new GeneralVoucher();
        //                 $vouchers->transaction_id = $purchaseData->id;
        //                 $vouchers->account_head_id = 2;
        //                 $vouchers->warehouse_id = 1;
        //                 $vouchers->date = $purchaseData->date;
        //                 $vouchers->voucher_no = $purchaseData->invoice_no;
        //                 $vouchers->v_type = $request->sale_type;
        //                 $vouchers->company_id = $CompanyID;
        //                 $vouchers->credit = $request->incvalue[$i];
        //                 // $vouchers->credit = $sum;
        //                 $vouchers->save();
    
        //         }
        //     }
        //     // Session::flash('error_message', 'FBR portal is upgrading! Kindly try again after sometime.');
        //     Session::flash('flash_message', 'Record Successfully Added!');
        //     return redirect('salestax/create');
    
        //   } 
        //   else {
        //     $errorMessage = $responseData['validationResponse']['error'] ?? 'Unknown API error';
        //     $errorCode = $responseData['validationResponse']['statusCode'] ?? 'UNKNOWN_CODE';
        //     // Set all error information in the session
        //     Session::flash('error', 'Failed with error: ' . $errorMessage);
        //     Session::flash('error_code', $errorCode);
        //     Session::flash('error_details', $responseData['validationResponse']['details'] ?? null);
    
        //     return redirect('salestax/create')->with('error', 'Failed with error: ' . $errorMessage);
        //     // API Error
        //     return [
        //       'status' => 'error',
        //       'message' => $responseData['validationResponse']['error'] ?? 'Unknown API error',
        //       'code' => $responseData['validationResponse']['statusCode'] ?? 'UNKNOWN_CODE',
        //       'fullResponse' => $responseData // Optional: include for debugging
        //     ];
        //   }
    }



    public function update(Request $request, $id)
    {
        // return $request;
        $CompanyID = session()->get('company_id');
       
        $purchaseData = SaleTax::findOrFail($id);
        $purchaseData->party_id = $request->party_id;
        $purchaseData->warehouse_id = $request->warehouse_id;
        $purchaseData->date = date('Y-m-d', strtotime($request->date));
        $purchaseData->sale_type = $request->sale_type;
        // $purchaseData->invoice_no = $request->invoice_no;
        $purchaseData->invoice_no = $request->invoice_no;
        $purchaseData->scenario_id = $request->scenario_id;
        // $purchaseData->fbr_invoice_no = $responseData['invoiceNumber'];
        $purchaseData->company_id = $CompanyID;
        $purchaseData->dcn_no = $request->dcn_no;
        $purchaseData->p_order = $request->p_order;
        $purchaseData->remarks = $request->remarks;
        $purchaseData->biller = Auth::User()->id;
        $purchaseData->ref_usin = $request->ref_usin;
        $purchaseData->save();
        // return $request;
        // $purchase = json_decode($request->get('purchase'), true);
        // // return $purchase;
        // $purchaseData->party_id = $purchase['party_id'];
        // $purchaseData->warehouse_id = $purchase['warehouse_id'];
        // $purchaseData->date = date('Y-m-d', strtotime($purchase['date']));
        // $purchaseData->sale_type = $purchase['sale_type'];
        // $purchaseData->invoice_no = $purchase['invoice_no'];
        // $purchaseData->dcn_no = $purchase['dcn_no'];
        // $purchaseData->p_order = $purchase['p_order'];
        // $purchaseData->remarks = $purchase['remarks'];
        // $purchaseData->biller = $purchase['biller'];
        // $purchaseData->company_id = $purchase['company_id'];
        // $purchaseData->save();
        SaleTaxDetails::where('sale_id', '=', $id)
        ->where('sale_type1', 'Debit Note')
        ->where('company_id', $CompanyID)
        ->delete();
            $count = count($request->product_code);
            for($i = 0; $i < $count; $i++) {
                $purchaseDetail = new SaleTaxDetails();
                $purchaseDetail->sale_id = $purchaseData->id;
                $purchaseDetail->date = $purchaseData->date;
                $purchaseDetail->invoice_no = $purchaseData->invoice_no;
                // $purchaseDetail->fbr_invoice_no = $responseData['invoiceNumber']."-".$i+1;
                $purchaseDetail->sale_type1 = $request->sale_type;
                // $purchaseDetail->fbr_invoice_no = $request->fbr_invoice_no;
                $purchaseDetail->product_id = $request->product_id1[$i];
                $purchaseDetail->party_id = $request->party_id;
                $purchaseDetail->company_id = $CompanyID;
                $purchaseDetail->uom_id = $request->uom_id[$i];
                // if(isset($uomData)){
                // $purchaseDetail->fbr_uom_id = $fbr_uoms['fbr_uom_id'][$i];
                // $purchaseDetail->fbr_uom_desc = $fbr_uoms['fbr_uom_desc'][$i];
                // }else{
                $purchaseDetail->fbr_uom_id = $request->uom_id[$i];
                $purchaseDetail->fbr_uom_desc = $request->uom[$i];  
                // }
                $purchaseDetail->status = "InvoiceOnly";
                $purchaseDetail->quantity = $request->quantity[$i];
                $purchaseDetail->rate = $request->rate[$i];
                $purchaseDetail->stvalue = $request->stvalue[$i];
                $purchaseDetail->taxvalue = $request->taxvalue[$i];
                $purchaseDetail->extratax = $request->extratax[$i] ?? 0;
                $purchaseDetail->extraTaxValue = $request->extraTaxValue[$i] ?? 0;
                $purchaseDetail->price = $request->excvalue[$i];
                $purchaseDetail->total = $request->incvalue[$i];
                $purchaseDetail->sro_schd_no = $request->sro_schd_no[$i];
                $purchaseDetail->sro_item_no = $request->sro_item_no[$i];
                $purchaseDetail->save();
            }
            Session::flash('flash_message', 'Invoice Draft Successfully Updated.');
            return redirect('debit-note/create'); 
    }

    public function destroy($id)
    {
        $CompanyID = session()->get('company_id');
        $this->deleteInvoice($id, $CompanyID);
        Session::flash('flash_message', 'Debit Note deleted Successfully!');
        return redirect('debit-note');
        return "Sales Tax Invoice Deleted Successfully!";
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || count($ids) === 0) {
            return response()->json(['message' => 'No ids provided.'], 422);
        }

        $CompanyID = session()->get('company_id');
        $deleted = 0;
        foreach ($ids as $id) {
            $this->deleteInvoice($id, $CompanyID);
            $deleted++;
        }

        return response()->json(['deleted' => $deleted]);
    }

    protected function deleteInvoice($id, $CompanyID)
    {
        DB::beginTransaction();
        try {
            $delete = SaleTax::where('id', $id)->where('company_id', $CompanyID)->firstOrFail();

            // 1. Reset Delivery Challan Status if exists
            if (!empty($delete->dcn_no)) {
                $DeliveryChallan = DeliveryChallan::where('vr_no', $delete->dcn_no)
                    ->where('company_id', $CompanyID)
                    ->where('type', "CN")
                    ->first();
                if ($DeliveryChallan) {
                    $DeliveryChallan->status = 0;
                    $DeliveryChallan->save();
                }
            }

            // 2. Delete Child Records FIRST
            SaleTaxDetails::where('sale_id', $id)->where('company_id', $CompanyID)->delete();
            GeneralVoucher::where('transaction_id', $id)
                ->where('company_id', $CompanyID)
                ->where('v_type', 'Debit Note')
                ->delete();
            ProductionStock::where('pro_transfer_id', $id)
                ->where('company_id', $CompanyID)
                ->delete();
            RawMaterialStock::where('transction_id', $id)
                ->where('company_id', $CompanyID)
                ->where('type', 'Debit Note')
                ->delete();

            // 3. Delete Parent Record LAST
            $delete->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error deleting debit note ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }

    public function PartyChange(Request $request)
    {
        $partyID = $request->get('party_ID');
        $data = Party::where('id', '=', $partyID)->get();
        return $data;
    }

    public function productChange(Request $request)
    {
        $productID = $request->get('product_ID');
        // $data = Product::join('purchase_details', 'purchase_details.product_id', '=', 'products.id')
        // ->where('products.id', '=', $productID)
        // ->where('remaining_quantity', '!=', 0)
        // ->OrderBy('purchase_details.id', 'asc')
        // ->first(['products.*','purchase_details.remaining_quantity', 'purchase_details.unit_cost', 'purchase_details.total_cost']);
        //->first();
        $data = Product::where('id', '=', $productID)->get(['products.*']);
        //$test[] = $data;
        return $data;
    }

    public function print_sale($id)
    {

    }


    public function print_pdf($id)
    {
        $newsale_detail = SaleTax::with(['saletax_details' => function ($query) {
            $query->with(['products' => function ($query) {
            }]);
            //$query->with('taxes');
            //$query->with('discount');
            //$query->with('ledger');
            //$query->with('publishers');
        }]) //->with('parties')->with('billers')
            ->where('company_id', session()->get('company_id'))
            ->where('sale_taxes.id', '=', $id)
            ->get();
        $ledgers = Ledger::with('ledger_party')->where('party_id', '=', $newsale_detail[0]->parties->id)->get();
        //return $newsale_detail;

        $company_detail = Setting::where('id', '=', 1)->get();
        $logo = SystemLogo::where('id', '=', 1)->get();
        //return $company_detail;
        $pdf = PDF::loadView('debit-note.printpdf', ['newsale_detail' => $newsale_detail, 'company_detail' => $company_detail, 'logo' => $logo]);
        return $pdf->download('debit-note.pdf');
        //return view('salestax.print', Compact('newsale_detail', 'company_detail', 'ledgers', 'logo'));
    }


    public function print_dc($id)
    {
        $newsale_detail = SaleTax::with(['saletax_details' => function ($query) {
            $query->with(['products' => function ($query) {
            }]);
            //$query->with('taxes');
            //$query->with('discount');
            //$query->with('ledger');
            //$query->with('publishers');
        }]) //->with('parties')->with('billers')
            ->where('company_id', session()->get('company_id'))
            ->where('sale_taxes.id', '=', $id)
            ->get();
        $ledgers = Ledger::with('ledger_party')
            ->where('party_id', '=', $newsale_detail[0]->parties->id)
            ->get();
        //return $newsale_detail;

        $company_detail = Setting::where('id', '=', 1)->get();
        $logo = SystemLogo::where('id', '=', 1)->get();
        //return $company_detail;
        return view('credit-note.dcn', compact('newsale_detail', 'company_detail', 'ledgers', 'logo'));
    }

    public function getsro_item(Request $request){
        // return $request;
        $data = SROItemno::where('sro_schedule_id', $request->sro_schd_id)
        ->where('scenario_id', $request->scenario_id)->get();
        // return $data;
        return json_encode(['data' => $data]);
    }
}