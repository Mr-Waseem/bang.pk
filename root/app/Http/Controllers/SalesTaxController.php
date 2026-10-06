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
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Services\CompanyInvoiceGuard;
use Carbon\Carbon;
use App\Services\InvoicePdfMailer;
use PDF;
use Excel;
use Log;
use App\Imports\SalesImport;
use Illuminate\Support\Facades\Response;

class SalesTaxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function saleTaxHasColumn($column)
    {
        static $cache = [];

        if (!array_key_exists($column, $cache)) {
            $cache[$column] = Schema::hasColumn('sale_taxes', $column);
        }

        return $cache[$column];
    }

    private function applySaleTaxWithheldAndLevyFields($purchaseData, Request $request)
    {
        if (isset($request->withheld_at_source) && (int) $request->withheld_at_source === 1) {
            $purchaseData->withheld_at_source = 1;
        } else {
            $purchaseData->withheld_at_source = 0;
        }

        if ($this->saleTaxHasColumn('withheld_at_source_amount')) {
            $purchaseData->withheld_at_source_amount = $request->withheld_at_source_amount ?? 0;
        }

        if ($this->saleTaxHasColumn('petroleum_levy_rate')) {
            $purchaseData->petroleum_levy_rate = $request->petroleum_levy_rate ?: null;
        }
    }

    private function resolveSalesTaxWithheldAtSource($withheldAtSource, $taxValue, $manualAmount = 0)
    {
        // FUTURE: when checkbox ON, return round(((float) $taxValue) / 100 * 20);
        // if ((int) $withheldAtSource === 1) {
        //     return round(((float) $taxValue) / 100 * 20);
        // }

        // Manual amount only (checkbox UI disabled for now)
        return (float) ($manualAmount ?? 0);
    }

    private function hydrateInvoiceDisplayFallbacks($sale)
    {
        if (!$sale) {
            return;
        }

        $party = $sale->parties;
        if (!$party) {
            $party = new Party();
            $party->id = $sale->party_id;
            $party->party_name = $sale->customer_name ?: '';
            $party->ntn = $sale->customer_cnic ?: '';
            $party->province = '';
            $party->customer_type = '';
            $party->address = '';
            $sale->setRelation('parties', $party);
        } elseif (empty($party->party_name)) {
            $party->party_name = $sale->customer_name ?: '';
        }

        if ($sale->relationLoaded('saletax_details') && $sale->saletax_details) {
            foreach ($sale->saletax_details as $detail) {
                $product = $detail->products;
                if (!$product) {
                    $product = new Product();
                    $product->id = $detail->product_id;
                    $product->product_code = $detail->product_id ? ('P-' . $detail->product_id) : 'N/A';
                    $product->product_name = '';
                    $product->uom = $detail->fbr_uom_desc ?: '';
                    $product->tax = $detail->stvalue ?? 0;
                    $detail->setRelation('products', $product);
                } else {
                    if (empty($product->product_name)) {
                        $product->product_name = '';
                    }
                    if (empty($product->product_code)) {
                        $product->product_code = $detail->product_id ? ('P-' . $detail->product_id) : 'N/A';
                    }
                }
            }
        }
    }

    /**
     * Determine which tables to save based on company type.
     * invoice only  => SaleTax + SaleTaxDetails
     * inventory     => SaleTax + SaleTaxDetails + Stock (RawMaterialStock / ProductionStock)
     * trader        => SaleTax + SaleTaxDetails + Stock + GeneralVoucher
     * others        => All tables (same as current full flow)
     */
    private function getTablePermissions($companyType)
    {
        $type = strtolower(trim($companyType ?? ''));

        return [
            'saveStock'   => $type !== 'invoice only',
            'saveVoucher' => !in_array($type, ['invoice only', 'inventory']),
        ];
    }

    public function index(Request $request)
    {
        // // if(session()->get('company_id') == 147){
        //      $st = SaleTaxDetails:: 
        //     where('company_id', session()->get('company_id'))
        //     ->where('extraTaxValue', '=', null)
        //     ->get();
        //     foreach($st as $data){
        //         $data->extratax = 0;
        //         $data->extraTaxValue = 0;
        //         $data->save();
        //     }
        // }

        //code to change general voucher debit credit values
        //  $sales = SaleTax::with('saletax_details')
        // ->with('general_vouchers')
        // ->where('sale_type', 'SalesTax Invoice')
        // ->where('fbr_invoice_no', '!=', null)
        // // ->where('id', '=', $id)
        // // ->where('company_id', session()->get('company_id'))
        // // ->orderby('invoice_no', 'asc')
        // ->get();
        // foreach($sales as $sale){
        //     // return $sale;
        // $gv = GeneralVoucher::where('transaction_id', $sale->id)
        // ->where('v_type', 'SalesTax Invoice')
        // // ->where('company_id', session()->get('company_id'))
        // ->delete();

        // foreach($sale->saletax_details as $data){
        //        $vouchers = new GeneralVoucher();
        //         $vouchers->transaction_id = $data->sale_id;
        //         $vouchers->account_head_id = $data->party_id;
        //         $vouchers->warehouse_id = 1;
        //         $vouchers->date = $data->date;
        //         $vouchers->voucher_no = $data->invoice_no;
        //         $vouchers->v_type = $data->sale_type1;
        //         $vouchers->company_id = $data->company_id;
        //         // $vouchers->debit = $data->incvalue;
        //         $vouchers->debit = $data->total;
        //         $vouchers->save();
        //         $vouchers = new GeneralVoucher();
        //         $vouchers->transaction_id = $data->sale_id;
        //         $vouchers->account_head_id = 2;
        //         $vouchers->warehouse_id = 1;
        //         $vouchers->date = $data->date;
        //         $vouchers->voucher_no = $data->invoice_no;
        //         $vouchers->v_type = $data->sale_type1;
        //         $vouchers->company_id = $data->company_id;
        //         // $vouchers->credit = $data->incvalue;
        //         $vouchers->credit = $data->total;
        //         $vouchers->save();

        // }
        // }



        $defaultFrom = Carbon::now()->startOfMonth()->format('d/m/Y');
        $defaultTo = Carbon::now()->endOfMonth()->format('d/m/Y');

        $fromDateInput = $request->get('from_date', $defaultFrom);
        $toDateInput = $request->get('to_date', $defaultTo);
        $hasSearched = $request->has('find');
        $sales = collect();

        if ($hasSearched) {
            try {
                $fromDate = Carbon::createFromFormat('d/m/Y', trim($fromDateInput))->startOfDay();
                $toDate = Carbon::createFromFormat('d/m/Y', trim($toDateInput))->endOfDay();
            } catch (\Exception $e) {
                Session::flash('error_message', 'Invalid date format. Please use dd/mm/yyyy.');
                return redirect('salestax');
            }

            if ($fromDate->gt($toDate)) {
                Session::flash('error_message', 'From date cannot be greater than To date.');
                return redirect('salestax');
            }

            $sales = SaleTax::where('sale_type', 'SalesTax Invoice')
                ->where('company_id', session()->get('company_id'))
                ->whereDate('date', '>=', $fromDate->format('Y-m-d'))
                ->whereDate('date', '<=', $toDate->format('Y-m-d'))
                ->orderBy('id', 'desc')
                ->with(['saletax_details' => function ($query) {
                    //$query->with('taxes');
                    //$query->with('discount');
                    //$query->with('parties');
                }])
                ->with('billers')
                ->get();
            //return $sales;
        }
        return view('salestax.index', compact('sales', 'fromDateInput', 'toDateInput', 'hasSearched'));
    }

    public function create()
    {
        $CompanyID = session()->get('company_id');
        if (!$CompanyID) {
            return redirect('company')->with('error', 'Please select a company first.');
        }
        // $purchase = json_decode($request->get('purchase'), true);
        $sellerCompany = Companies::find($CompanyID);
        if (!$sellerCompany) {
            return redirect('company')->with('error', 'Company not found.');
        }

        $limitError = CompanyInvoiceGuard::monthlyLimitError($CompanyID, date('Y-m-d'));
        if ($limitError) {
            Session::flash('error_message', $limitError);
        }

        $codes = CompanyInvoiceGuard::nextInvoiceNo($CompanyID);

        //$codes = $code->last()->invoice_no + 1;
        // $products = Product::OrderBy('product_name', 'asc')->pluck('product_name', 'product_name')->prepend('Start Typing....', '')->toArray();
        $customers = ['' => 'Select Customer'];
        $products = ['' => 'Select Product'];
        $selectedParty = null;

        //return $products;
        $taxes = Tax::select(DB::raw('CONCAT(`id`, "_", `tax_rate`) AS `tax_rate`, `tax_title`'))->OrderBy('id', 'asc')->pluck('tax_title', 'tax_rate')->toArray();
        $discounts = Discount::select(DB::raw('CONCAT(`id`, "_", `discount`) AS `discount`, `title`'))->OrderBy('id', 'asc')->pluck('title', 'discount')->toArray();
        //$discounts = Discount::OrderBy('id', 'asc')->pluck('title', 'id')->prepend('Select Discount', '0')->toArray();
        //$customers = Party::OrderBy('id', 'asc')->pluck('party_name', 'party_name');


        $DeliveryChallan = DeliveryChallan::where('company_id', session()->get('company_id'))
            ->where('status', '=', 0)
            ->where('type', '=', 'DC')
            ->OrderBy('vr_no', 'asc')->pluck('vr_no', 'vr_no')
            ->prepend('Select Challan', '')->toArray();
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

        return view('salestax.create', compact('customers', 'products', 'taxes', 'discounts', 'DeliveryChallan', 'codes', 'uoms', 'encrypted_token', 'warehouse', 'scenarios', 'sroschedule', 'sroitem', 'sellerCompany', 'selectedParty'));
    }

    public function createImportExcel()
    {
        return view('salestax.importExcel.create');
    }


    // public function ImportExcel(Request $request)
    // {
    //     //  return session()->get('company_id');
    //     $this->validate($request, [
    //         'import_file' => 'required'
    //     ]);

    //     $path1 = $request->file('import_file')->store('temp');
    //     $path = storage_path('app') . '/' . $path1;
    //     $data = Excel::toArray([], $path);
    //     $data = Excel::import(new SalesImport, $path);
    //     // $data1 = Excel::import(new CustomerUserImport, $path,  $data);
    //     return redirect()->back()->with('flash_message', 'Sales File Imported Successfully!');

    //     //   if($request->hasFile('import_file'))
    //     //     {
    //     //         $path = $request->file('import_file')->getRealPath();
    //     //         return $data= Excel::load($path, function($reader) {})->get();
    //     //         if(!empty($data) && $data->count())
    //     //         {
    //     //             foreach($data->toArray() as $key=>$value)
    //     //             {
    //     //                 if(!empty($value))
    //     //                 {
    //     //                     Employee::insert($value);
    //     //                 }
    //     //             }
    //     //         }
    //     //     }
    //     // $path = $request->file('import_file')->getRealPath();
    //     // return $results = Excel::load($path)->get();
    //     // //return $results;
    //     // if (!empty($results) && $results->count()) {
    //     //     $sum = 1;
    //     //     foreach ($results as $row) {
    //     //         //return $row->party_name;
    //     //         //foreach ($rows as $row) {
    //     //         $sum = $sum + 1;
    //     //         if (($row->party_name) != null) {
    //     //             Party::create([
    //     //                 'code'  => $sum,
    //     //                 'account_group_id'  => 1,
    //     //                 'shop_id'  => 1,
    //     //                 'account_type'  => "CUSTOMER",
    //     //                 'party_name'  => $row->party_name,
    //     //                 'phone'  => $row->phone,
    //     //                 'city'  => "LAHORE",
    //     //                 'address'  => $row->address,

    //     //             ]);
    //     //         }
    //     //         //}
    //     //     }
    //     // }

    //     Session::flash('flash_message', 'Parties Imported Successfully!');
    //     return redirect('parties/importExcel/create');
    // }


    public function ImportExcel(Request $request)
    {
        //  return session()->get('company_id');
        $this->validate($request, [
            'import_file' => 'required'
        ]);

        $import = new SalesImport();

        try {
            $path1 = $request->file('import_file')->store('temp');
            $path = storage_path('app') . '/' . $path1;

            Excel::import($import, $path);

            $message = "Sales File Imported Successfully! Imported: {$import->importedCount} records.";
            $validationErrors = $import->getErrors();

            $redirect = redirect()->back()->with('flash_message', $message);

            if (!empty($validationErrors)) {
                $redirect = $redirect
                    ->with('error', 'Some records failed validation and were skipped:')
                    ->with('error_details', $validationErrors);
            }

            return $redirect;
        } catch (\Exception $e) {
            Log::error('Sales Import failed', ['error' => $e->getMessage()]);

            // Parse error message for display
            $errorMessage = $e->getMessage();
            $errorLines = explode("\n", $errorMessage);

            return redirect()->back()
                ->with('error', 'Import failed due to validation errors:')
                ->with('error_details', $errorLines);
        }
    }

    public function dcChange(Request $request)
    {
        // return $request;
        $CompanyID = session()->get('company_id');
        $DeliveryChallan = DeliveryChallan::with('parties:id,party_name,address,ntn')->with(['challan_details' => function ($query) {
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
        $DeliveryChallan = DeliveryChallan::where('company_id', session()->get('company_id'))
            ->where('status', '=', 0)
            ->OrderBy('vr_no', 'asc')
            ->pluck('vr_no', 'vr_no')
            ->prepend('Select Challan', '0')->toArray();
        //$customer = Party::OrderBy('id', 'asc')->pluck('party_name', 'id');
        if ($purchase->isEmpty()) {
            Session::flash('flash_error', 'Invoice not found.');
            return redirect('salestax');
        }

        $edit = $purchase[0];
        $this->hydrateInvoiceDisplayFallbacks($edit);
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
        $sellerCompany = Companies::where('id', $CompanyID)->first();
        $customers = ['' => 'Select Customer'];
        $products = ['' => 'Select Product'];
        $selectedParty = null;
        if ($edit->parties) {
            $selectedParty = [
                'id' => $edit->party_id,
                'text' => $edit->parties->party_name,
            ];
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
        return view('salestax.edit', compact('sroschedule', 'sroitem', 'scenarios', 'sellerCompany', 'edit', 'products', 'DeliveryChallan', 'customers', 'encrypted_token', 'uoms', 'discounts', 'warehouse', 'selectedParty'));
    }



    public function store(Request $request)
    {
        // return $request;
        $this->validate($request, [
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
        //  if ($CompanyID == 357) {
        //     return $request;
        //  }

        $limitError = CompanyInvoiceGuard::monthlyLimitError($CompanyID, $request->date);
        if ($limitError) {
            Session::flash('error_message', $limitError);
            return redirect('salestax/create');
        }

        $codes = CompanyInvoiceGuard::nextInvoiceNo($CompanyID);
        $saletype = SaleTypes::where('id', $sellerCompany->sale_type)->first();
        $buyerCompany = Party::where('id', $request->party_id)->first();
        $scenario = Scenario::where('id', $request->scenario_id)->first();
        $products = $request->get('product_data');
        $saleTypeData = json_decode($saletype);
        $count = count($request->product_code);

        //Draft Save
        if ($sellerCompany->approval == 1) {
            // $codes = 1;
            //Check invoice exist or note
            $code = SaleTax::where('invoice_no', $request->invoice_no)
                ->where('company_id', $CompanyID)
                ->where('sale_type', 'SalesTax Invoice')->first();
            // return $code = SaleTax::where('company_id', $CompanyID)
            //     ->where('sale_type', 'SalesTax Invoice')
            //     ->OrderBy('invoice_no', 'desc')->first();
            if ($code) {
                Session::flash('error_message', 'Invoice number ' . $request->invoice_no . ' already exists!.');
                return redirect('salestax/create');
                // return "s";
                $codes = (int)$code->invoice_no + 1;
            } else {
                // user input invoice no;
                $codes = (int)$request->invoice_no;
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
            if ($this->saleTaxHasColumn('discount_amount')) {
                $purchaseData->discount_amount = $request->discount_amount ?? 0;
            }
            $this->applySaleTaxWithheldAndLevyFields($purchaseData, $request);
            $purchaseData->customer_name = $request->customer_name;
            $purchaseData->customer_cnic = $request->customer_cnic;
            $purchaseData->save();
            $permissions = $this->getTablePermissions($sellerCompany->type);
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
                $purchaseDetail->fbr_qty = $request->fbr_qty[$i] ?? null;
                $purchaseDetail->rate = $request->rate[$i];
                $purchaseDetail->stvalue = $request->stvalue[$i];
                $purchaseDetail->taxvalue = $request->taxvalue[$i];
                $purchaseDetail->extratax = $request->extratax[$i] ?? 0;
                $purchaseDetail->extraTaxValue = $request->extraTaxValue[$i] ?? 0;
                $purchaseDetail->price = $request->excvalue[$i];
                $purchaseDetail->discount = $request->discount[$i] ?? null;
                $purchaseDetail->discount_value = $request->discount_value[$i] ?? null;
                $purchaseDetail->discount2 = $request->discount2[$i] ?? null;
                $purchaseDetail->discount2_value = $request->discount2_value[$i] ?? null;
                $purchaseDetail->total = $request->incvalue[$i];
                $purchaseDetail->sro_schd_no = $request->sro_schd_no[$i] ?? null;
                $purchaseDetail->sro_item_no = $request->sro_item_no[$i] ?? null;
                $purchaseDetail->remarks = $request->remarks1[$i] ?? null;
                $sum = $sum + $request->incvalue[$i];
                $purchaseDetail->save();

                if ($permissions['saveStock']) {
                $recipe = Product::where('id', $request->product_id1[$i])->first();

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
                    $RawMaterial->stockout = $request->quantity[$i];
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
                    $RawMaterial->stockout = $request->quantity[$i];
                    $RawMaterial->company_id = $CompanyID;
                    $RawMaterial->save();
                }
                }

                if ($permissions['saveVoucher']) {
                $vouchers = new GeneralVoucher();
                $vouchers->transaction_id = $purchaseData->id;
                $vouchers->account_head_id = $request->party_id;
                $vouchers->warehouse_id = 1;
                $vouchers->date = $purchaseData->date;
                $vouchers->voucher_no = $purchaseData->invoice_no;
                $vouchers->v_type = $request->sale_type;
                $vouchers->company_id = $CompanyID;
                $vouchers->debit = $request->incvalue[$i];
                $vouchers->save();

                $vouchers = new GeneralVoucher();
                $vouchers->transaction_id = $purchaseData->id;
                $vouchers->account_head_id = 2;
                $vouchers->warehouse_id = 1;
                $vouchers->date = $purchaseData->date;
                $vouchers->voucher_no = $purchaseData->invoice_no;
                $vouchers->v_type = $request->sale_type;
                $vouchers->company_id = $CompanyID;
                $vouchers->credit = $request->incvalue[$i];
                $vouchers->save();
                }
            }
            $DeliveryChallan = DeliveryChallan::where('vr_no', $request->dcn_no)
                ->where('company_id',  $CompanyID)
                ->where('type',  "DC")
                ->first();
            if ($DeliveryChallan) {
                $DeliveryChallan->status = 1;
                $DeliveryChallan->save();
            }

            Session::flash('flash_message', 'Invoice Draft Successfully Saved.');
            return redirect('salestax/create');
        }
        //Live
        else {
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
                if ($currentproduct->tax == 999) {
                    $taxrate = "Exempt";
                } else {
                    $taxrate = $request->stvalue[$i] . '%';
                }
                // return "df";
                // if ($sellerCompany->st_held == 1) {
                $stheld = $this->resolveSalesTaxWithheldAtSource(
                    $request->withheld_at_source,
                    $request->taxvalue[$i],
                    $request->withheld_at_source_amount ?? 0
                );
                if ($scenario->sale_type == "3rd Schedule Goods") {
                    $RetailPrice = (int)$request->rate[$i];
                } else {
                    // $RetailPrice = $request->excvalue[$i];
                    $RetailPrice = 0;
                }
                // 3rd Schedule: totalValues is already net of disc (from UI); send row discount amount too
                $itemDiscount = 0;
                if ($scenario->sale_type == "3rd Schedule Goods") {
                    $itemDiscount = (float) ($request->discount_value[$i] ?? 0) + (float) ($request->discount2_value[$i] ?? 0);
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
                    "extraTax" => "",
                    "furtherTax" => $request->extraTaxValue[$i],
                    // "sroScheduleNo" => "6th Schd Table II",
                    "sroScheduleNo" => $request->sro_schd_no[$i],
                    "fedPayable" => 0,
                    "discount" => $itemDiscount,
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

            // Sum row-level discount values + grand discount_amount for API
            $rowDiscountTotal = array_sum(array_map('floatval', $request->discount_value ?? []));
            $rowDiscount2Total = array_sum(array_map('floatval', $request->discount2_value ?? []));
            $grandDiscountAmount = (float) ($request->discount_amount ?? 0);
            $totalDiscountAmount = $rowDiscountTotal + $rowDiscount2Total + $grandDiscountAmount;

            $payload = [
                //   "invoiceType" => "Debit Note",
                "invoiceType" => "Sale Invoice",
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
                "invoiceRefNo" => "",
                "petroleumLevyOn" => $request->petroleum_levy_rate,
                "discountAmount" => $totalDiscountAmount,
                "items" => $items  // This is where your dynamic items go
            ];
            if ($sellerCompany->invoice_type == "Live") {
                $payload["sourceInvoiceNo"] = "$request->invoice_no";
            }
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
                CURLOPT_CONNECTTIMEOUT => 300,   // wait up to 300s for connection
                CURLOPT_TIMEOUT => 300,
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
            if (
                isset($responseData['validationResponse']['statusCode']) &&
                $responseData['validationResponse']['statusCode'] === '00'
            ) {
                if ($sellerCompany->invoice_type == "Live") {
                    $codes = CompanyInvoiceGuard::nextInvoiceNo($CompanyID);

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
                    if ($this->saleTaxHasColumn('discount_amount')) {
                        $purchaseData->discount_amount = $request->discount_amount ?? 0;
                    }
                    $this->applySaleTaxWithheldAndLevyFields($purchaseData, $request);
                    $purchaseData->save();
                    $permissions = $this->getTablePermissions($sellerCompany->type);
                    $sum = "0";
                    $count = count($request->product_code);
                    for ($i = 0; $i < $count; $i++) {
                        $purchaseDetail = new SaleTaxDetails();
                        $purchaseDetail->sale_id = $purchaseData->id;
                        $purchaseDetail->date = $purchaseData->date;
                        $purchaseDetail->invoice_no = $purchaseData->invoice_no;
                        $purchaseDetail->fbr_invoice_no = $responseData['invoiceNumber'] . "-" . $i + 1;
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
                        $purchaseDetail->discount = $request->discount[$i] ?? null;
                        $purchaseDetail->discount_value = $request->discount_value[$i] ?? null;
                        $purchaseDetail->discount2 = $request->discount2[$i] ?? null;
                        $purchaseDetail->discount2_value = $request->discount2_value[$i] ?? null;
                        $purchaseDetail->total = $request->incvalue[$i];
                        $purchaseDetail->sro_schd_no = $request->sro_schd_no[$i];
                        $purchaseDetail->sro_item_no = $request->sro_item_no[$i];
                        $purchaseDetail->remarks = $request->remarks1[$i];
                        $sum = $sum + $request->incvalue[$i];
                        $purchaseDetail->save();

                        $DeliveryChallan = DeliveryChallan::where('vr_no', $request->dcn_no)
                            ->where('company_id',  $CompanyID)
                            ->where('type',  "DC")
                            ->first();
                        if ($DeliveryChallan) {
                            $DeliveryChallan->status = 1;
                            $DeliveryChallan->save();
                        }



                        if ($permissions['saveStock']) {
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
                            $RawMaterial->stockout = $request->quantity[$i];
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
                            $RawMaterial->stockout = $request->quantity[$i];
                            $RawMaterial->company_id = $CompanyID;
                            $RawMaterial->save();
                        }
                        }

                        if ($permissions['saveVoucher']) {
                        $vouchers = new GeneralVoucher();
                        $vouchers->transaction_id = $purchaseData->id;
                        $vouchers->account_head_id = $request->party_id;
                        $vouchers->warehouse_id = 1;
                        $vouchers->date = $purchaseData->date;
                        $vouchers->voucher_no = $purchaseData->invoice_no;
                        $vouchers->v_type = $request->sale_type;
                        $vouchers->company_id = $CompanyID;
                        $vouchers->debit = $request->incvalue[$i];
                        $vouchers->save();

                        // $vouchers = new GeneralVoucher();
                        // $vouchers->transaction_id = $purchaseData->id;
                        // $vouchers->account_head_id = 2;
                        // $vouchers->warehouse_id = 1;
                        // $vouchers->date = $purchaseData->date;
                        // $vouchers->voucher_no = $purchaseData->invoice_no;
                        // $vouchers->v_type = $request->sale_type;
                        // $vouchers->company_id = $CompanyID;
                        // $vouchers->credit = $request->incvalue[$i];
                        // $vouchers->save();
                        
                        $vouchers = new GeneralVoucher();
                        $vouchers->transaction_id = $purchaseData->id;
                        $vouchers->account_head_id = 2;
                        $vouchers->warehouse_id = 1;
                        $vouchers->date = $purchaseData->date;
                        $vouchers->voucher_no = $purchaseData->invoice_no;
                        $vouchers->v_type = $request->sale_type;
                        $vouchers->company_id = $CompanyID;
                        $vouchers->credit = $request->excvalue[$i];
                        $vouchers->save();
                        
                        $vouchers = new GeneralVoucher();
                        $vouchers->transaction_id = $purchaseData->id;
                        $vouchers->account_head_id = 863;
                        $vouchers->warehouse_id = 1;
                        $vouchers->date = $purchaseData->date;
                        $vouchers->voucher_no = $purchaseData->invoice_no;
                        $vouchers->v_type = $request->sale_type;
                        $vouchers->company_id = $CompanyID;
                        $vouchers->credit = $request->taxvalue[$i];
                        $vouchers->save();
                        
                        }
                    }
                }
                // Session::flash('error_message', 'FBR portal is upgrading! Kindly try again after sometime.');
                Session::flash('flash_message', 'Record Successfully Added!');
                return redirect('salestax/create');
            } else {
                $errorMessage = $responseData['validationResponse']['error'] ?? 'Unknown API error';
                $errorCode = $responseData['validationResponse']['statusCode'] ?? 'UNKNOWN_CODE';
                // Set all error information in the session
                Session::flash('error', 'Failed with error: ' . $errorMessage);
                Session::flash('error_code', $errorCode);
                Session::flash('error_details', $responseData['validationResponse']['details'] ?? null);

                return redirect('salestax/create')->with('error', 'Failed with error: ' . $errorMessage);
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
            $query->with('unit')->with(['products' => function ($query) {}]);
            //$query->with('taxes');
            //$query->with('discount');
            //$query->with('ledger');
            //$query->with('publishers');
        }])->with('parties')->with('shop') //->with('billers')
            ->where('sale_taxes.id', '=', $id)
            ->where('company_id', session()->get('company_id'))
            ->get();
        if ($newsale_detail->isEmpty()) {
            Session::flash('flash_error', 'Invoice not found.');
            return redirect('salestax');
        }
        $this->hydrateInvoiceDisplayFallbacks($newsale_detail[0]);

        $ledgers = Ledger::with('ledger_party')
            // ->where('party_id', '=', $newsale_detail[0]->parties->id)
            ->get();
        // return $newsale_detail;
        $CompanyID = session()->get('company_id');
        // $purchase = json_decode($request->get('purchase'), true);
        $sellerCompany = Companies::where('id', $CompanyID)->first();
        $company_detail = Setting::where('id', '=', 1)->get();
        $logo = SystemLogo::where('id', '=', 1)->get();
        // return $sellerCompany;
        if ($sellerCompany->bill_type == "A4") {
            if ($sellerCompany->invoice_design == 1) {
                return view('salestax.invoice', compact('newsale_detail', 'company_detail', 'ledgers', 'logo', 'id', 'sellerCompany'));
            }
            if ($sellerCompany->invoice_design == 2) {
                return view('salestax.spi', compact('newsale_detail', 'company_detail', 'ledgers', 'logo', 'id', 'sellerCompany'));
            }
            if ($sellerCompany->invoice_design == 3) {
                return view('salestax.topnotch-template', compact('newsale_detail', 'company_detail', 'ledgers', 'logo', 'id', 'sellerCompany'));
            }
            if ($sellerCompany->invoice_design == 4) {
                return view('salestax.ashoes-template', compact('newsale_detail', 'company_detail', 'ledgers', 'logo', 'id', 'sellerCompany'));
            }

            // default / standard layout
            return view('salestax.paktraders', compact('newsale_detail', 'company_detail', 'ledgers', 'logo', 'id', 'sellerCompany'));
        }
        if ($sellerCompany->bill_type == "Thermal") {
            // return "e";a
            return view('salestax.thermal', compact('newsale_detail', 'company_detail', 'ledgers', 'logo', 'id', 'sellerCompany'));
        }
        // if ($sellerCompany->bill_type == "Thermal1") {
        //     return view('salestax.thermal1', compact('newsale_detail', 'company_detail', 'ledgers', 'logo', 'id', 'sellerCompany'));
        // }
        if ($sellerCompany->bill_type == "Thermal2") {
            return view('salestax.thermal2', compact('newsale_detail', 'company_detail', 'ledgers', 'logo', 'id', 'sellerCompany'));
        }
    }

    public function approve(Request $request)
    {
        // return $request;
        $sales = SaleTax::with(['saletax_details' => function ($query) {
            $query->with('products:id,product_code,product_name,uom_id,uom,tax');
            $query->with('unit');
        }])
            ->with('parties:id,party_name,ntn,province,customer_type,address')
            ->where('id', '=', $request->invoice_id)
            ->where('company_id', session()->get('company_id'))
            ->first();
        $CompanyID = session()->get('company_id');
        // $purchase = json_decode($request->get('purchase'), true);
        $sellerCompany = Companies::where('id', $CompanyID)->first();
        $saletype = SaleTypes::where('id', $sellerCompany->sale_type)->first();

        $buyerCompany = Party::where('id', $sales->party_id)->first();
        // if ($sales->unregistered_cnicntn) {
        //for unregistered person
        if ($sales->customer_name) {
            // $buyeresNtn = $sales->unregistered_cnicntn;
            $buyeresName = $sales->customer_name;
        } else {
            $buyeresName = $buyerCompany->party_name;
        }
        if ($sales->customer_cnic) {
            // $buyeresNtn = $sales->unregistered_cnicntn;
            $buyeresNtn = $sales->customer_cnic;
        } else {
            $buyeresNtn = $buyerCompany->ntn;
        }
        $scenario = Scenario::where('id', $sales->scenario_id)->first();

        foreach ($sales->saletax_details as $data) {
            $currentproduct = Product::where('id', $data->product_id)->first('tax');
            if ($currentproduct->tax == 999) {
                $taxrate = "Exempt";
            } else {
                $taxrate = $data->stvalue . '%';
            }

            // if ($sellerCompany->st_held == 1) {
            $stheld = $this->resolveSalesTaxWithheldAtSource(
                $sales->withheld_at_source,
                $data->taxvalue,
                $sales->withheld_at_source_amount ?? 0
            );
            if ($scenario->sale_type == "3rd Schedule Goods") {
                $RetailPrice = round($data->rate, 2);
                // $RetailPrice = 0;
            } else {
                // $RetailPrice = $request->excvalue[$i];
                $RetailPrice = 0;
            }
            $discountsval = 0;
            if ($data->discount_value) {
                $discountsval = $data->discount_value;
            }
            if ($data->discount2_value) {
                $discountsval = $data->discount_value + $data->discount2_value;
            }

            if ($data->products->product_name == ".") {
                $productdesc = $data->remarks;
            } else {
                // $productdesc = $data->products->product_name .' '.$data->remarks; 
                $productdesc = str_replace('"', '', $data->products->product_name) . ' ' . $data->remarks;
            }
            if ($sellerCompany->show_fbr_qty == 1) {
                // return "fbrqty";
                $qtymanage = $data->fbr_qty;
            } else {
                $qtymanage = $data->quantity;
            }
            //  return $qtymanage;
            $items[] = [
                "hsCode" => $data->products->product_code,
                // "productDescription" => $data->products->product_name,
                "productDescription" => $productdesc,
                "rate" => $taxrate,
                "uoM" => $data->fbr_uom_desc,
                // "uoM" => $uomData[0]['uoM_ID'],
                // "uom_desc" => $uomData[0]['description'],
                // "quantity" => $data->quantity,
                "quantity" => $qtymanage,
                "totalValues" => $data->total,
                "valueSalesExcludingST" => $data->price,
                "fixedNotifiedValueOrRetailPrice" => $RetailPrice,
                "salesTaxApplicable" => $data->taxvalue,
                // "salesTaxApplicable" => 39878.33,
                "salesTaxWithheldAtSource" => $stheld,
                "extraTax" => "",
                "furtherTax" => $data->extraTaxValue,
                // "sroScheduleNo" => "6th Schd Table II",
                "sroScheduleNo" => $data->sro_schd_no,
                "fedPayable" => 0,
                "discount" => $discountsval,
                "saleType" => $scenario->sale_type,
                // "sroItemSerialNo" => "10"
                "sroItemSerialNo" => $data->sro_item_no,
                "reason" => "Others",
                "reasonRemarks" => "Duplicate invoice added mistakenly",
            ];
            // return $items;
        }
        // return $scenario;

        // Sum row-level discount values + grand discount_amount for API
        $rowDiscountTotal = $sales->saletax_details->sum('discount_value');
        $rowDiscount2Total = $sales->saletax_details->sum('discount2_value');
        $grandDiscountAmount = (float) ($sales->discount_amount ?? 0);
        $totalDiscountAmount = $rowDiscountTotal + $rowDiscount2Total + $grandDiscountAmount;

        if ($sales->sale_type == "SalesTax Invoice") {
            // $invoicetypes = "Sale Invoice";
            // $refusin = "";

            $payload = [
                //   "invoiceType" => "Debit Note",
                "invoiceType" => "Sale Invoice",
                "invoiceDate" => $sales->date,
                "sellerBusinessName" => $sellerCompany['CompanyName'],
                "sellerProvince" => $sellerCompany['province'],
                "sellerAddress" => $sellerCompany['address'],
                "sellerNTNCNIC" => $sellerCompany['ntn'],
                "buyerNTNCNIC" => $buyeresNtn,
                // "buyerBusinessName" => $buyerCompany->party_name,
                "buyerBusinessName" => $buyeresName,
                "buyerProvince" => $buyerCompany->province,
                "buyerAddress" => $buyerCompany->address,
                "buyerRegistrationType" => $buyerCompany->customer_type,
                "scenarioId" => $scenario->name,
                //   "invoiceRefNo" => $request->ref_usin,
                // "invoiceRefNo" => "",
                "invoiceRefNo" => "",
                "petroleumLevyOn" => $sales->petroleum_levy_rate,
                "discountAmount" => $totalDiscountAmount,
                "items" => $items  // This is where your dynamic items go
            ];
        }

        if ($sales->sale_type == "Debit Note") {
            // $invoicetypes = "Debit Note";
            // $refusin = $sales->ref_usin;
            $payload = [
                "invoiceType" => "Debit Note",
                // "invoiceType" => "Sale Invoice",
                // "invoiceType" => $invoicetypes,
                "invoiceDate" => $sales->date,
                // "sellerBusinessName" => $sellerCompany['CompanyName'],
                // "sellerProvince" => $sellerCompany['province'],
                // "sellerAddress" => $sellerCompany['address'],
                // "sellerNTNCNIC" => $sellerCompany['ntn'],
                // "buyerNTNCNIC" => $buyeresNtn,
                // // "buyerBusinessName" => $buyerCompany->party_name,
                // "buyerBusinessName" => $buyeresName,
                // "buyerProvince" => $buyerCompany->province,
                // "buyerAddress" => $buyerCompany->address,
                // "buyerRegistrationType" => $buyerCompany->customer_type,
                "sellerBusinessName" => $buyerCompany->party_name,
                "sellerProvince" => $buyerCompany->province,
                "sellerAddress" => $buyerCompany->address,
                "sellerNTNCNIC" => $buyeresNtn,

                "buyerNTNCNIC" => $sellerCompany['ntn'],
                "buyerBusinessName" => $sellerCompany['CompanyName'],
                "buyerProvince" => $sellerCompany['province'],
                "buyerAddress" => $sellerCompany['address'],
                "buyerRegistrationType" => "Registered",

                "scenarioId" => $scenario->name,
                //   "invoiceRefNo" => $request->ref_usin,
                // "invoiceRefNo" => "",
                "invoiceRefNo" => $sales->ref_usin,
                "petroleumLevyOn" => $sales->petroleum_levy_rate,
                "reason" => "Others",
                "reasonRemarks" => "Duplicate invoice added mistakenly",
                "discountAmount" => $totalDiscountAmount,
                "items" => $items  // This is where your dynamic items go
            ];
        }
        if ($sellerCompany->invoice_type == "Live") {
            $payload = array_merge($payload, [
                "sourceInvoiceNo" => "$sales->invoice_no",
            ]);
        }
        //  if($sales->sale_type == "Debit Note"){
        //     return $payload;
        // }
        //   return $payload;
        // return $invoicetypes;

        // $payload = [
        //     //   "invoiceType" => "Debit Note",
        //     // "invoiceType" => "Sale Invoice",
        //     "invoiceType" => $invoicetypes,
        //     "invoiceDate" => $sales->date,
        //     "sellerBusinessName" => $sellerCompany['CompanyName'],
        //     "sellerProvince" => $sellerCompany['province'],
        //     "sellerAddress" => $sellerCompany['address'],
        //     "sellerNTNCNIC" => $sellerCompany['ntn'],
        //     "buyerNTNCNIC" => $buyeresNtn,
        //     "buyerBusinessName" => $buyerCompany->party_name,
        //     "buyerProvince" => $buyerCompany->province,
        //     "buyerAddress" => $buyerCompany->address,
        //     "buyerRegistrationType" => $buyerCompany->customer_type,
        //     "scenarioId" => $scenario->name,
        //     //   "invoiceRefNo" => $request->ref_usin,
        //     // "invoiceRefNo" => "",
        //     "invoiceRefNo" => $refusin,
        //     "items" => $items  // This is where your dynamic items go
        // ];
        //   return $payload;

        $headers = [
            'Content-Type: application/json',
            'Cookie: key=value; JSESSIONID=IYFCgbVx4GhV2E-MMPlepV3DlG8b0HU4N_la2DUA.i01-irisdmz56; cookiesession1=678B2A2CB3F1FF7FD24B6E462AB80DD1'
        ];

        // Only modify the Authorization line with condition
        // $sellerCompany->invoice_type;
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
            CURLOPT_CONNECTTIMEOUT => 300,   // wait up to 300s for connection
            CURLOPT_TIMEOUT => 300,          // wait up to 300s for execution
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
        if (!empty($sales->fbr_invoice_no)) {
            Session::flash('error_message', 'Invoice already posted to FBR!');
            return redirect()->back();
        }
        // return "dd";
        $response = curl_exec($curl);

        if ($sellerCompany->debug_mode == 1) {
            return $response;
        }
        curl_close($curl);
        $responseData = json_decode($response, true);
        if ($sellerCompany->debug_mode == 2) {
            return $responseData;
        }
        //     $response = curl_exec($curl);
        //   curl_close($curl);
        //   $responseData = json_decode($response, true);
        if (
            isset($responseData['invoiceNumber']) &&
            isset($responseData['validationResponse']['statusCode']) &&
            $responseData['validationResponse']['statusCode'] === '00'
        ) {
            // if ($sellerCompany->invoice_type == "Live") {
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
            // $sum = 0;
            // $count = count($request->product_code);
            // for ($i = 0; $i < $count; $i++) {

            // foreach ($sales->saletax_details as $data) {
            //     $sum = $sum + 1;
            //     $recipe = Product::where('id', $data->product_id)->first();
            //     if ($recipe['has_recipe'] == "1") {
            //         $RawMaterial = new ProductionStock();
            //         $RawMaterial->pro_transfer_id = $sales->id;
            //         $RawMaterial->company_id = $CompanyID;
            //         $RawMaterial->warehouse_id = 1;
            //         $RawMaterial->product_id = $data->product_id1[$i];
            //         $RawMaterial->uom_id = $data->uom_id[$i] ?? null;
            //         $RawMaterial->date = $sales->date;
            //         $RawMaterial->voucher_no = $sales->invoice_no;
            //         $RawMaterial->cost_amount = $data->incvalue[$i];
            //         $RawMaterial->stockout = $data->quantity[$i];
            //         $RawMaterial->save();
            //     } else {
            //         $RawMaterial = new RawMaterialStock();
            //         $RawMaterial->transction_id = $sales->id;
            //         $RawMaterial->type = $sales->sale_type;
            //         $RawMaterial->party_id = $data->party_id;
            //         $RawMaterial->warehouse_id = 1;
            //         // $RawMaterial->sale_id = $purchaseData['id'];
            //         $RawMaterial->product_id = $data->product_id;
            //         $RawMaterial->uom_id = $data->uom_id ?? null;
            //         $RawMaterial->date = $sales->date;
            //         $RawMaterial->voucher_no = $sales->invoice_no;
            //         // $RawMaterial->cost_amount = $product['cost_amount'];
            //         $RawMaterial->stockout = $data->quantity;
            //         $RawMaterial->company_id = $CompanyID;
            //         $RawMaterial->save();
            //     }

            //     $vouchers = new GeneralVoucher();
            //     $vouchers->transaction_id = $sales->id;
            //     $vouchers->account_head_id = $sales['party_id'];
            //     $vouchers->warehouse_id = 1;
            //     $vouchers->date = $sales->date;
            //     $vouchers->voucher_no = $sales->invoice_no;
            //     $vouchers->v_type = $sales->sale_type;
            //     $vouchers->company_id = $CompanyID;
            //     // $vouchers->debit = $data->incvalue;
            //     $vouchers->debit = $data->total;
            //     $vouchers->save();

            //     $vouchers = new GeneralVoucher();
            //     $vouchers->transaction_id = $sales->id;
            //     $vouchers->account_head_id = 2;
            //     $vouchers->warehouse_id = 1;
            //     $vouchers->date = $sales->date;
            //     $vouchers->voucher_no = $sales->invoice_no;
            //     $vouchers->v_type = $sales->sale_type;
            //     $vouchers->company_id = $CompanyID;
            //     // $vouchers->credit = $data->incvalue;
            //     $vouchers->credit = $data->total;
            //     $vouchers->save();
            //     // return $data;
            //     $data->fbr_invoice_no = $responseData['invoiceNumber'] . '-' . $sum;
            //     $data->save();
            // }

            // }
            // }
            $sales->fbr_invoice_no = $responseData['invoiceNumber'];
            $sales->save();
            // Session::flash('error_message', 'FBR portal is upgrading! Kindly try again after sometime.');
            Session::flash('flash_message', 'Invoice posted to fbr Successfully!');
            return redirect()->back();
            // return redirect('salestax/create');

        } else {
            // $errorMessage = $responseData['validationResponse']['error'] ?? 'Unknown API error';
            // $errorCode = $responseData['validationResponse']['statusCode'] ?? 'UNKNOWN_CODE';
            // // Set all error information in the session
            // Session::flash('error', 'Failed with error: ' . $errorMessage);
            // Session::flash('error_code', $errorCode);
            // Session::flash('error_details', $responseData['validationResponse']['details'] ?? null);
            //----------------------------------------------------
            // $errorCode = $responseData['validationResponse']['statusCode'] ?? 'UNKNOWN_CODE';
            // $errorMessages = [];

            // // First, try to get the main error
            // if (!empty($responseData['validationResponse']['error'])) {
            //     $errorMessages[] = $responseData['validationResponse']['error'];
            // }

            // // Then add all invoice errors
            // if (
            //     isset($responseData['validationResponse']['invoiceStatuses']) &&
            //     is_array($responseData['validationResponse']['invoiceStatuses'])
            // ) {

            //     foreach ($responseData['validationResponse']['invoiceStatuses'] as $invoiceError) {
            //         if (!empty($invoiceError['error'])) {
            //             $errorMessages[] = "Item {$invoiceError['itemSNo']}: {$invoiceError['error']}";
            //         }
            //     }
            // }

            // // Combine error messages
            // $errorMessage = !empty($errorMessages) ? implode(' | ', $errorMessages) : 'Unknown API error';

            // // Set all error information in the session
            // Session::flash('error', 'Failed with error: ' . $errorMessage);
            // Session::flash('error_code', $errorCode);
            // Session::flash('error_details', $responseData['validationResponse']['details'] ?? null);
            $errorCode = $responseData['validationResponse']['statusCode'] ?? 'UNKNOWN_CODE';
            $errorMessage = 'Unknown API error';

            // Check for invoice-specific errors first (they are more detailed)
            if (
                isset($responseData['validationResponse']['invoiceStatuses']) &&
                is_array($responseData['validationResponse']['invoiceStatuses'])
            ) {

                // Use the first invoice error found
                foreach ($responseData['validationResponse']['invoiceStatuses'] as $invoiceError) {
                    if (!empty($invoiceError['error'])) {
                        $errorMessage = $invoiceError['error'];
                        break;
                    }
                }
            }
            // Fallback to main error if no invoice errors found
            elseif (!empty($responseData['validationResponse']['error'])) {
                $errorMessage = $responseData['validationResponse']['error'];
            }

            // Set all error information in the session
            Session::flash('error', 'Validation Failed');
            Session::flash('error_code', $errorCode);
            Session::flash('error_details', $errorMessage); // This will now show the "Buyer province" error
            return redirect()->back()->with('error', 'Failed with error: ' . $errorMessage);
            // return redirect('salestax/create')->with('error', 'Failed with error: ' . $errorMessage);
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
        $purchaseData->advance_income_tax = $request->advance_income_tax;
        $purchaseData->total_income_tax = $request->total_income_tax;
        if ($this->saleTaxHasColumn('discount_amount')) {
            $purchaseData->discount_amount = $request->discount_amount ?? 0;
        }
        $this->applySaleTaxWithheldAndLevyFields($purchaseData, $request);
        $purchaseData->customer_name = $request->customer_name;
        $purchaseData->customer_cnic = $request->customer_cnic;
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
        $sellerCompany = Companies::find($CompanyID);
        $permissions = $this->getTablePermissions($sellerCompany->type);
        SaleTaxDetails::where('sale_id', '=', $id)
            ->where('sale_type1', 'SalesTax Invoice')
            ->where('company_id', $CompanyID)
            ->delete();
        if ($permissions['saveVoucher']) {
        GeneralVoucher::where('transaction_id', '=', $id)->where('v_type', 'SalesTax Invoice')->delete();
        }
        if ($permissions['saveStock']) {
        ProductionStock::where('pro_transfer_id', '=', $id)->where('company_id', $CompanyID)->delete();
        RawMaterialStock::where('transction_id', '=', $id)
            ->where('company_id', $CompanyID)->where('type', 'SalesTax Invoice')->delete();
        }
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
            $purchaseDetail->fbr_qty = $request->fbr_qty[$i] ?? null;
            $purchaseDetail->rate = $request->rate[$i];
            $purchaseDetail->stvalue = $request->stvalue[$i];
            $purchaseDetail->taxvalue = $request->taxvalue[$i];
            $purchaseDetail->extratax = $request->extratax[$i] ?? 0;
            $purchaseDetail->extraTaxValue = $request->extraTaxValue[$i] ?? 0;
            $purchaseDetail->price = $request->excvalue[$i];
            $purchaseDetail->discount = $request->discount[$i] ?? null;
            $purchaseDetail->discount_value = $request->discount_value[$i] ?? null;
            $purchaseDetail->discount2 = $request->discount2[$i] ?? null;
            $purchaseDetail->discount2_value = $request->discount2_value[$i] ?? null;
            $purchaseDetail->total = $request->incvalue[$i];
            $purchaseDetail->sro_schd_no = $request->sro_schd_no[$i] ?? null;
            $purchaseDetail->sro_item_no = $request->sro_item_no[$i] ?? null;
            $purchaseDetail->remarks = $request->remarks1[$i] ?? null;
            $purchaseDetail->save();





            if ($permissions['saveStock']) {
            $recipe = Product::where('id', $request->product_id1[$i])->first();
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
                $RawMaterial->stockout = $request->quantity[$i];
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
                $RawMaterial->stockout = $request->quantity[$i];
                $RawMaterial->company_id = $CompanyID;
                $RawMaterial->save();
            }
            }

            if ($permissions['saveVoucher']) {
            $vouchers = new GeneralVoucher();
            $vouchers->transaction_id = $purchaseData->id;
            $vouchers->account_head_id = $request->party_id;
            $vouchers->warehouse_id = 1;
            $vouchers->date = $purchaseData->date;
            $vouchers->voucher_no = $purchaseData->invoice_no;
            $vouchers->v_type = $request->sale_type;
            $vouchers->company_id = $CompanyID;
            $vouchers->debit = $request->incvalue[$i];
            $vouchers->save();
            // $vouchers = new GeneralVoucher();
            // $vouchers->transaction_id = $purchaseData->id;
            // $vouchers->account_head_id = 2;
            // $vouchers->warehouse_id = 1;
            // $vouchers->date = $purchaseData->date;
            // $vouchers->voucher_no = $purchaseData->invoice_no;
            // $vouchers->v_type = $request->sale_type;
            // $vouchers->company_id = $CompanyID;
            // $vouchers->credit = $request->incvalue[$i];
            // $vouchers->save();
            $vouchers = new GeneralVoucher();
            $vouchers->transaction_id = $purchaseData->id;
            $vouchers->account_head_id = 2;
            $vouchers->warehouse_id = 1;
            $vouchers->date = $purchaseData->date;
            $vouchers->voucher_no = $purchaseData->invoice_no;
            $vouchers->v_type = $request->sale_type;
            $vouchers->company_id = $CompanyID;
            $vouchers->credit = $request->excvalue[$i];
            $vouchers->save();
                
            $vouchers = new GeneralVoucher();
            $vouchers->transaction_id = $purchaseData->id;
            $vouchers->account_head_id = 863;
            $vouchers->warehouse_id = 1;
            $vouchers->date = $purchaseData->date;
            $vouchers->voucher_no = $purchaseData->invoice_no;
            $vouchers->v_type = $request->sale_type;
            $vouchers->company_id = $CompanyID;
            $vouchers->credit = $request->taxvalue[$i];
            $vouchers->save();
            }
        }
        Session::flash('flash_message', 'Invoice Draft Successfully Updated.');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $CompanyID = session()->get('company_id');
        $this->deleteInvoice($id, $CompanyID);
        Session::flash('flash_message', 'Sale Invoice deleted Successfully!');
        return redirect()->back();
        // return redirect('salestax');
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

    public function bulkApprove(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || count($ids) === 0) {
            return response()->json(['message' => 'No ids provided.'], 422);
        }

        $CompanyID = session()->get('company_id');
        $sellerCompany = Companies::where('id', $CompanyID)->first();
        if (!$sellerCompany) {
            return response()->json(['message' => 'Company not found.'], 404);
        }

        $results = [];

        foreach ($ids as $index => $id) {
            $result = $this->approveSingleInvoice($id, $CompanyID, $sellerCompany);
            $results[] = $result;
            
            // Add delay between bulk requests to avoid rate limiting (1 second)
            if ($index < count($ids) - 1) {
                usleep(1000000); // 1 second delay
            }
        }

        $successCount = collect($results)->where('status', 'success')->count();
        $failCount = collect($results)->where('status', '!=', 'success')->count();

        // Set session flash so index page shows a success message after reload
        if ($successCount > 0) {
            $message = $successCount . ' invoice(s) linked to FBR successfully!';
            if ($failCount > 0) {
                $message .= ' (' . $failCount . ' failed)';
            }
            Session::flash('flash_message', $message);
        }

        return response()->json([
            'success' => $successCount,
            'failed' => $failCount,
            'results' => $results,
        ]);
    }

    protected function approveSingleInvoice($invoiceId, $CompanyID, $sellerCompany)
    {
        try {
            $sales = SaleTax::with(['saletax_details' => function ($query) {
                $query->with('products:id,product_code,product_name,uom_id,uom,tax');
                $query->with('unit');
            }])
            ->with('parties:id,party_name,ntn,province,customer_type,address')
            ->where('id', '=', $invoiceId)
            ->where('company_id', $CompanyID)
            ->first();

            if (!$sales) {
                return ['id' => $invoiceId, 'status' => 'error', 'message' => 'Invoice not found.'];
            }

            if (!empty($sales->fbr_invoice_no)) {
                return ['id' => $invoiceId, 'status' => 'skipped', 'message' => 'Already linked to FBR.', 'fbr_invoice_no' => $sales->fbr_invoice_no];
            }

            $saletype = SaleTypes::where('id', $sellerCompany->sale_type)->first();
            $buyerCompany = Party::where('id', $sales->party_id)->first();

            if ($sales->customer_name) {
                $buyeresName = $sales->customer_name;
            } else {
                $buyeresName = $buyerCompany->party_name;
            }
            if ($sales->customer_cnic) {
                $buyeresNtn = $sales->customer_cnic;
            } else {
                $buyeresNtn = $buyerCompany->ntn;
            }

            $scenario = Scenario::where('id', $sales->scenario_id)->first();
            $items = [];

            foreach ($sales->saletax_details as $data) {
                $currentproduct = Product::where('id', $data->product_id)->first('tax');
                if ($currentproduct->tax == 999) {
                    $taxrate = "Exempt";
                } else {
                    $taxrate = $data->stvalue . '%';
                }

                $stheld = $this->resolveSalesTaxWithheldAtSource(
                    $sales->withheld_at_source,
                    $data->taxvalue,
                    $sales->withheld_at_source_amount ?? 0
                );

                if ($scenario->sale_type == "3rd Schedule Goods") {
                    $RetailPrice = round($data->rate, 2);
                } else {
                    $RetailPrice = 0;
                }

                $discountsval = 0;
                if ($data->discount_value) {
                    $discountsval = $data->discount_value;
                }
                if ($data->discount2_value) {
                    $discountsval = $data->discount_value + $data->discount2_value;
                }

                if ($data->products->product_name == ".") {
                    $productdesc = $data->remarks;
                } else {
                    $productdesc = str_replace('"', '', $data->products->product_name) . ' ' . $data->remarks;
                }

                if ($sellerCompany->show_fbr_qty == 1) {
                    $qtymanage = $data->fbr_qty;
                } else {
                    $qtymanage = $data->quantity;
                }

                $items[] = [
                    "hsCode" => $data->products->product_code,
                    "productDescription" => $productdesc,
                    "rate" => $taxrate,
                    "uoM" => $data->fbr_uom_desc,
                    "quantity" => $qtymanage,
                    "totalValues" => $data->total,
                    "valueSalesExcludingST" => $data->price,
                    "fixedNotifiedValueOrRetailPrice" => $RetailPrice,
                    "salesTaxApplicable" => $data->taxvalue,
                    "salesTaxWithheldAtSource" => $stheld,
                    "extraTax" => "",
                    "furtherTax" => $data->extraTaxValue,
                    "sroScheduleNo" => $data->sro_schd_no,
                    "fedPayable" => 0,
                    "discount" => $discountsval,
                    "saleType" => $scenario->sale_type,
                    "sroItemSerialNo" => $data->sro_item_no,
                    "reason" => "Others",
                    "reasonRemarks" => "Duplicate invoice added mistakenly",
                ];
            }

            $rowDiscountTotal = $sales->saletax_details->sum('discount_value');
            $rowDiscount2Total = $sales->saletax_details->sum('discount2_value');
            $grandDiscountAmount = (float) ($sales->discount_amount ?? 0);
            $totalDiscountAmount = $rowDiscountTotal + $rowDiscount2Total + $grandDiscountAmount;

            if ($sales->sale_type == "SalesTax Invoice") {
                $payload = [
                    "invoiceType" => "Sale Invoice",
                    "invoiceDate" => $sales->date,
                    "sellerBusinessName" => $sellerCompany['CompanyName'],
                    "sellerProvince" => $sellerCompany['province'],
                    "sellerAddress" => $sellerCompany['address'],
                    "sellerNTNCNIC" => $sellerCompany['ntn'],
                    "buyerNTNCNIC" => $buyeresNtn,
                    "buyerBusinessName" => $buyeresName,
                    "buyerProvince" => $buyerCompany->province,
                    "buyerAddress" => $buyerCompany->address,
                    "buyerRegistrationType" => $buyerCompany->customer_type,
                    "scenarioId" => $scenario->name,
                    "invoiceRefNo" => "",
                    "petroleumLevyOn" => $sales->petroleum_levy_rate,
                    "discountAmount" => $totalDiscountAmount,
                    "items" => $items
                ];
            } elseif ($sales->sale_type == "Debit Note") {
                $payload = [
                    "invoiceType" => "Debit Note",
                    "invoiceDate" => $sales->date,
                    "sellerBusinessName" => $buyerCompany->party_name,
                    "sellerProvince" => $buyerCompany->province,
                    "sellerAddress" => $buyerCompany->address,
                    "sellerNTNCNIC" => $buyeresNtn,
                    "buyerNTNCNIC" => $sellerCompany['ntn'],
                    "buyerBusinessName" => $sellerCompany['CompanyName'],
                    "buyerProvince" => $sellerCompany['province'],
                    "buyerAddress" => $sellerCompany['address'],
                    "buyerRegistrationType" => "Registered",
                    "scenarioId" => $scenario->name,
                    "invoiceRefNo" => $sales->ref_usin,
                    "petroleumLevyOn" => $sales->petroleum_levy_rate,
                    "reason" => "Others",
                    "reasonRemarks" => "Duplicate invoice added mistakenly",
                    "discountAmount" => $totalDiscountAmount,
                    "items" => $items
                ];
            } else {
                return ['id' => $invoiceId, 'status' => 'error', 'message' => 'Unknown sale type: ' . $sales->sale_type];
            }
            if ($sellerCompany->invoice_type == "Live") {
                $payload = array_merge($payload, [
                    "sourceInvoiceNo" => "$sales->invoice_no",
                ]);
            }

            $headers = [
                'Content-Type: application/json',
                'Cookie: key=value; JSESSIONID=IYFCgbVx4GhV2E-MMPlepV3DlG8b0HU4N_la2DUA.i01-irisdmz56; cookiesession1=678B2A2CB3F1FF7FD24B6E462AB80DD1'
            ];

            if ($sellerCompany->invoice_type == "Live") {
                $headers[] = 'Authorization: Bearer ' . $sellerCompany->token;
                $apiUrl = 'https://gw.fbr.gov.pk/di_data/v1/di/postinvoicedata';
            } else {
                $headers[] = 'Authorization: Bearer ' . $sellerCompany->sandbox_token;
                $apiUrl = 'https://gw.fbr.gov.pk/di_data/v1/di/postinvoicedata_sb';
            }

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $apiUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_CONNECTTIMEOUT => 300,
                CURLOPT_TIMEOUT => 300,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_HTTPHEADER => $headers,
            ]);

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            
            if ($response === false) {
                $errorMessage = curl_error($curl);
                curl_close($curl);
                \Log::error("FBR CURL Error for Invoice {$sales->invoice_no}", ['error' => $errorMessage, 'http_code' => $httpCode]);
                return ['id' => $invoiceId, 'invoice_no' => $sales->invoice_no, 'status' => 'error', 'message' => 'CURL error: ' . $errorMessage, 'code' => 'CURL_ERROR'];
            }
            curl_close($curl);

            $responseData = json_decode($response, true);

            // Log response for debugging
            \Log::info("FBR Response for Invoice {$sales->invoice_no}", [
                'http_code' => $httpCode,
                'status_code' => $responseData['validationResponse']['statusCode'] ?? 'N/A',
                'has_invoice_number' => isset($responseData['invoiceNumber'])
            ]);

            if (
                isset($responseData['invoiceNumber']) &&
                isset($responseData['validationResponse']['statusCode']) &&
                $responseData['validationResponse']['statusCode'] === '00'
            ) {
                $sales->fbr_invoice_no = $responseData['invoiceNumber'];
                $sales->save();
                
                return [
                    'id' => $invoiceId,
                    'invoice_no' => $sales->invoice_no,
                    'status' => 'success',
                    'message' => 'Linked to FBR successfully.',
                    'fbr_invoice_no' => $responseData['invoiceNumber'],
                ];
            } else {
                $errorCode = $responseData['validationResponse']['statusCode'] ?? 'UNKNOWN_CODE';
                $errorMessage = 'Unknown API error';

                if (
                    isset($responseData['validationResponse']['invoiceStatuses']) &&
                    is_array($responseData['validationResponse']['invoiceStatuses'])
                ) {
                    foreach ($responseData['validationResponse']['invoiceStatuses'] as $invoiceError) {
                        if (!empty($invoiceError['error'])) {
                            $errorMessage = $invoiceError['error'];
                            break;
                        }
                    }
                } elseif (!empty($responseData['validationResponse']['error'])) {
                    $errorMessage = $responseData['validationResponse']['error'];
                }

                \Log::error("FBR API Error for Invoice {$sales->invoice_no}", [
                    'error_code' => $errorCode,
                    'error_message' => $errorMessage,
                    'full_response' => $responseData
                ]);

                return [
                    'id' => $invoiceId,
                    'invoice_no' => $sales->invoice_no,
                    'status' => 'error',
                    'message' => $errorMessage,
                    'code' => $errorCode,
                ];
            }
        } catch (\Exception $e) {
            return ['id' => $invoiceId, 'status' => 'error', 'message' => $e->getMessage()];
        }
    }

    protected function deleteInvoice($id, $CompanyID)
    {
        DB::beginTransaction();
        try {
            $sellerCompany = Companies::find($CompanyID);
            $permissions = $this->getTablePermissions($sellerCompany->type);
            $delete = SaleTax::findOrFail($id);

            // 1. Reset Delivery Challan Status if exists
            if (!empty($delete->dcn_no)) {
                $DeliveryChallan = DeliveryChallan::where('vr_no', $delete->dcn_no)
                    ->where('company_id', $CompanyID)
                    ->where('type', "DC")
                    ->first();
                if ($DeliveryChallan) {
                    $DeliveryChallan->status = 0;
                    $DeliveryChallan->save();
                }
            }

            // 2. Delete Child Records FIRST
            SaleTaxDetails::where('sale_id', $id)->where('company_id', $CompanyID)->delete();

            if ($permissions['saveVoucher']) {
                GeneralVoucher::where('transaction_id', $id)
                    ->where('company_id', $CompanyID)
                    ->where('v_type', 'SalesTax Invoice')
                    ->delete();
            }

            if ($permissions['saveStock']) {
                ProductionStock::where('pro_transfer_id', $id)
                    ->where('company_id', $CompanyID)
                    ->delete();

                RawMaterialStock::where('transction_id', $id)
                    ->where('company_id', $CompanyID)
                    ->where('type', 'SalesTax Invoice')
                    ->delete();
            }

            // 3. Delete Parent Record LAST
            $delete->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error deleting invoice ID {$id}: " . $e->getMessage());
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

    public function emailInvoice(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $newsale_detail = SaleTax::with(['saletax_details' => function ($query) {
            $query->with('unit')->with(['products' => function ($query) {}]);
        }])->with('parties')->with('shop')
            ->where('sale_taxes.id', '=', $id)
            ->where('company_id', session()->get('company_id'))
            ->get();

        if ($newsale_detail->isEmpty()) {
            return response()->json(['message' => 'Invoice not found.'], 404);
        }

        $this->hydrateInvoiceDisplayFallbacks($newsale_detail[0]);

        $ledgers = Ledger::with('ledger_party')->get();
        $sellerCompany = Companies::where('id', session()->get('company_id'))->first();
        $company_detail = Setting::where('id', '=', 1)->get();
        $logo = SystemLogo::where('id', '=', 1)->get();

        $view = 'salestax.email-pdf';
        if ($sellerCompany && (int) $sellerCompany->invoice_design === 2) {
            $view = 'salestax.email-pdf-spi';
        } elseif ($sellerCompany && (int) $sellerCompany->invoice_design === 4) {
            $view = 'salestax.ashoes-template';
        }

        $isPdf = true;
        $html = view($view, compact('newsale_detail', 'company_detail', 'ledgers', 'logo', 'id', 'sellerCompany', 'isPdf'))->render();

        try {
            app(InvoicePdfMailer::class)->send(
                $request->email,
                $html,
                $newsale_detail[0]->invoice_no,
                $sellerCompany ? $sellerCompany->CompanyName : session()->get('company_name')
            );
        } catch (\Throwable $e) {
            \Log::error('Sales tax invoice email failed: ' . $e->getMessage());
            return response()->json(['message' => 'Unable to send invoice. Please check mail settings.'], 500);
        }

        return response()->json(['message' => 'Invoice sent successfully.']);
    }

    public function downloadPdf($id)
    {
        $newsale_detail = SaleTax::with(['saletax_details' => function ($query) {
            $query->with('unit')->with(['products' => function ($query) {}]);
        }])->with('parties')->with('shop')
            ->where('sale_taxes.id', '=', $id)
            ->where('company_id', session()->get('company_id'))
            ->get();

        if ($newsale_detail->isEmpty()) {
            Session::flash('flash_error', 'Invoice not found.');
            return redirect('salestax');
        }

        $this->hydrateInvoiceDisplayFallbacks($newsale_detail[0]);

        $ledgers = Ledger::with('ledger_party')->get();
        $sellerCompany = Companies::where('id', session()->get('company_id'))->first();
        $company_detail = Setting::where('id', '=', 1)->get();
        $logo = SystemLogo::where('id', '=', 1)->get();

        $view = 'salestax.email-pdf';
        if ($sellerCompany && (int) $sellerCompany->invoice_design === 2) {
            $view = 'salestax.email-pdf-spi';
        } elseif ($sellerCompany && (int) $sellerCompany->invoice_design === 4) {
            $view = 'salestax.ashoes-template';
        }

        $isPdf = true;
        $html = view($view, compact('newsale_detail', 'company_detail', 'ledgers', 'logo', 'id', 'sellerCompany', 'isPdf'))->render();

        return app(InvoicePdfMailer::class)->downloadResponse($html, $newsale_detail[0]->invoice_no);
    }

    public function print_sale($id) {}

    public function print_pdf($id)
    {
        return $this->downloadPdf($id);
    }

    public function print_dc($id)
    {
        $newsale_detail = SaleTax::with(['saletax_details' => function ($query) {
            $query->with(['products' => function ($query) {}]);
            //$query->with('taxes');
            //$query->with('discount');
            //$query->with('ledger');
            //$query->with('publishers');
        }])->with('parties') //->with('billers')
            ->where('company_id', session()->get('company_id'))
            ->where('sale_taxes.id', '=', $id)
            ->get();
        if ($newsale_detail->isEmpty()) {
            Session::flash('flash_error', 'Invoice not found.');
            return redirect('salestax');
        }
        $this->hydrateInvoiceDisplayFallbacks($newsale_detail[0]);

        $ledgers = Ledger::with('ledger_party')
            ->where('party_id', '=', $newsale_detail[0]->parties->id)
            ->get();
        //return $newsale_detail;

        $company_detail = Setting::where('id', '=', 1)->get();
        $logo = SystemLogo::where('id', '=', 1)->get();
        //return $company_detail;
        return view('salestax.dcn', compact('newsale_detail', 'company_detail', 'ledgers', 'logo'));
    }

    public function getsro_item(Request $request)
    {
        // return $request;
        $data = SROItemno::where('sro_schedule_id', $request->sro_schd_id)
            ->where('scenario_id', $request->scenario_id)->get();
        // return $data;
        return json_encode(['data' => $data]);
    }

    public function searchPartiesAjax(Request $request)
    {
        $companyID = session()->get('company_id');
        $sellerCompany = Companies::find($companyID);
        $term = trim($request->get('q', ''));

        if ($sellerCompany && $sellerCompany->invoice_type == 'SandBox') {
            $query = Party::where('company_id', 0);
        } else {
            $query = Party::join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
                ->where('parties.account_group_id', 1)
                ->where('parties.party_name', '!=', 'CASH IN HAND')
                ->where('parties.company_id', $companyID)
                ->select('parties.id', 'parties.party_name');
        }

        if ($term !== '') {
            $query->where('party_name', 'like', '%' . $term . '%');
        }

        $parties = $query->orderBy('party_name')->limit(30)->get();

        return response()->json([
            'results' => $parties->map(function ($party) {
                return ['id' => $party->id, 'text' => $party->party_name];
            })->values(),
        ]);
    }

    public function searchProductsAjax(Request $request)
    {
        $companyID = session()->get('company_id');
        $sellerCompany = Companies::find($companyID);
        $term = trim($request->get('q', ''));

        $companyFilter = ($sellerCompany && $sellerCompany->invoice_type == 'SandBox') ? 0 : $companyID;

        $query = Product::where('company_id', $companyFilter);

        if ($term !== '') {
            $query->where(function ($q) use ($term) {
                $q->where('product_name', 'like', '%' . $term . '%')
                    ->orWhere('product_code', 'like', '%' . $term . '%');
            });
        }

        $products = $query->orderBy('product_name')->limit(30)->get();

        return response()->json([
            'results' => $products->map(function ($product) {
                return [
                    'id' => $product->id . '_' . $product->product_code . '_' . $product->product_name . '_' . $product->tax,
                    'text' => $product->product_code . ' - ' . $product->product_name,
                ];
            })->values(),
        ]);
    }
}
