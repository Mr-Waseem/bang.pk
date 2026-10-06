<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Companies;
use App\Models\Tax;
use App\Models\Party;
use App\Models\Discount;
use App\Models\Setting;
use App\Models\Ledger;
use App\Models\DeliveryChallan;
use App\Models\PurchaseTax;
use App\Models\PurchaseTaxDetails;
use App\Models\GeneralVoucher;
use App\Models\LedgerDetailWise;
use App\Models\UOM;
use App\Models\RawMaterialStock;
use App\Models\StockRegisterSpecificItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PDF;
use Excel;
use Illuminate\Support\Facades\Response;
class PurchaseTaxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $purchases = PurchaseTax::OrderBy('id', 'desc')
            ->with(['purchasetax_details' => function ($query) {
                //$query->with('taxes');
                //$query->with('discount');
                //$query->with('parties');
            }])
            ->with('billers')
            ->where('company_id', session()->get('company_id'))
            ->get();
        //return $sales;
        return view('purchase-tax.index', compact('purchases'));
    }

    public function create()
    {
        $codes = 0;
        $code = PurchaseTax::where('company_id', session()->get('company_id'))
            ->OrderBy('voucher_no', 'desc')
            ->first();

        if (isset($code) > 0) {
            $codes = (int)$code->voucher_no + 1;
        } else {
            $codes = 1;
        }
        // return $codes;
        //$codes = $code->last()->voucher_no + 1;
        // $products = Product::OrderBy('product_name', 'asc')->pluck('product_name', 'product_name')->prepend('Start Typing....', '')->toArray();
        $customers = ['' => 'Select Supplier'];
        $products = ['' => 'Select Product'];
        $selectedParty = null;
        $taxes = Tax::select(DB::raw('CONCAT(`id`, "_", `tax_rate`) AS `tax_rate`, `tax_title`'))->OrderBy('id', 'asc')->pluck('tax_title', 'tax_rate')->toArray();
        $uoms = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))->OrderBy('id', 'asc')->pluck('uom', 'id')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        $grn = DeliveryChallan::where('company_id', session()->get('company_id'))
            ->where('status', '=', 0)
            ->where('type', '=', 'GRN')
            ->OrderBy('vr_no', 'asc')->pluck('vr_no', 'vr_no')
            ->prepend('Select GRN', '')->toArray();
        return view('purchase-tax.create', Compact('customers', 'products', 'taxes', 'codes', 'uoms', 'encrypted_token', 'grn', 'selectedParty'));
    }

      public function grnChange(Request $request)
    {
        // return $request;
        $CompanyID = session()->get('company_id');
        $DeliveryChallan = DeliveryChallan::with('parties:id,party_name,address,ntn')->with(['challan_details' => function ($query) {
            $query->with('products:id,product_code,product_name,tax');
        }])
            ->where('vr_no', $request->dc)
            ->where('company_id',  $CompanyID)
            ->where('type',  "GRN")
            ->first();
        return Response::json(['data' => $DeliveryChallan]);
        // $partyID = $request->get('party_ID');
        // $data = Party::where('id', '=', $partyID)->get();
        // return $DeliveryChallan;
    }

    public function store(Request $request)
    {
        // return $request->all();
         $CompanyID = session()->get('company_id');
        $purchase = json_decode($request->get('purchase'), true);
        // return $purchase['p_order'];
        $purchase['date'] = date('Y/m/d', strtotime($purchase['date']));
        $products = $request->get('product_data');

        $purchaseData = PurchaseTax::create($purchase);
        $sum = "0";
        foreach ($products as $product) {
            $purchaseDetail = new PurchaseTaxDetails();
            $purchaseDetail->purchase_id = $purchaseData['id'];
            $purchaseDetail->product_id = $product['product_id'];
            $purchaseDetail->party_id = $product['party_id'];
            $purchaseDetail->uom_id = $product['uom_id'];
            if (($purchase['lessCommercial']) == "true") {
                $purchaseDetail->status = "1";
            } else {
                $purchaseDetail->status = "0";
            }
            $purchaseDetail->quantity = $product['quantity'];
            $purchaseDetail->rate = $product['rate'];
            $purchaseDetail->stvalue = $product['stvalue'];
            $purchaseDetail->taxvalue = $product['taxvalue'];
            $purchaseDetail->extratax = $product['extratax'];
            $purchaseDetail->extraTaxValue = $product['extraTaxValue'];
            $purchaseDetail->price = $product['excvalue'];
            $purchaseDetail->total = $product['incvalue'];
            $purchaseDetail->company_id = $product['company_id'];
            $sum = $sum + $product['incvalue'];
            $purchaseDetail->save();

            // $vouchers = new LedgerDetailWise();
			// $vouchers->transaction_id = $purchaseData['id'];
			// $vouchers->warehouse_id = $purchaseData['warehouse_id'];
			// $vouchers->party_id = $purchaseData['party_id'];
			// $vouchers->voucher_no = $purchaseData['invoice_no'];
			// $vouchers->voucher_type = $purchaseData['purchase_type'];
			// $vouchers->date = $purchaseData['date'];
			// $vouchers->product_id = $product['product_id'];
			// $vouchers->quantity = $product['quantity'];
			// $vouchers->rate = $product['rate'];
			// $vouchers->credit = $product['incvalue'];
			// $vouchers->company_id = $product['company_id'];
			// $vouchers->save();

			$vouchers = new GeneralVoucher();
			$vouchers->transaction_id = $purchaseData['id'];
			$vouchers->account_head_id = $purchaseData['party_id'];
			$vouchers->warehouse_id = $purchaseData['warehouse_id'];
			$vouchers->date = $purchaseData['date'];
			$vouchers->voucher_no = $purchaseData['invoice_no'];
			$vouchers->v_type = $purchaseData['purchase_type'];
			$vouchers->company_id = $product['company_id'];
			$vouchers->credit = $product['incvalue'];
			// $vouchers->credit = $sum;
			$vouchers->save();

			// $vouchers = new LedgerDetailWise();
			// $vouchers->transaction_id = $purchaseData['id'];
			// $vouchers->warehouse_id = $purchaseData['warehouse_id'];
			// $vouchers->party_id = 1;
			// $vouchers->voucher_no = $purchaseData['invoice_no'];
			// $vouchers->voucher_type = $purchaseData['purchase_type'];
			// $vouchers->date = $purchaseData['date'];
			// $vouchers->product_id = $product['product_id'];
			// $vouchers->quantity = $product['quantity'];
			// $vouchers->rate = $product['rate'];
			// $vouchers->debit = $product['incvalue'];
			// $vouchers->company_id = $product['company_id'];
			// $vouchers->save();

			$vouchers = new GeneralVoucher();
			$vouchers->transaction_id = $purchaseData['id'];
			$vouchers->account_head_id = 1;
			$vouchers->warehouse_id = $purchaseData['warehouse_id'];
			$vouchers->date = $purchaseData['date'];
			$vouchers->voucher_no = $purchaseData['invoice_no'];
			$vouchers->v_type = $purchaseData['purchase_type'];
			$vouchers->company_id = $product['company_id'];
			$vouchers->debit = $product['incvalue'];
			// $vouchers->debit = $sum;
			$vouchers->save();

            $RawMaterial = new RawMaterialStock();
			$RawMaterial->transction_id = $purchaseData['id'];
			$RawMaterial->type = "PURCHASE TAX";
			$RawMaterial->warehouse_id = 1;
            $RawMaterial->party_id = $product['party_id'];
			$RawMaterial->product_id = $product['product_id'];
			$RawMaterial->uom_id = $product['uom_id'];
			$RawMaterial->date = $purchaseData['date'];
			$RawMaterial->voucher_no = $purchaseData['invoice_no'];
			$RawMaterial->cost_amount = $product['incvalue'];
			$RawMaterial->stockin = $product['quantity'];
			$RawMaterial->company_id = $product['company_id'];
			$RawMaterial->save();

            // if (($purchase['lessCommercial']) == true) {
            //     $vouchers = new StockRegisterSpecificItem();
            //     $vouchers->purchasetax_id = $purchaseData['id'];
            //     $vouchers->date = $purchaseData['date'];
            //     $vouchers->party_id = $product['party_id'];
            //     $vouchers->product_id = $product['product_id'];
            //     $vouchers->voucher_type = $purchaseData['purchase_type'];
            //     $vouchers->uom_id = $product['uom_id'];
            //     $vouchers->sale_quantity = $product['quantity'];
            //     $vouchers->cost_rate = $product['incvalue'];
            //     $vouchers->company_id = $product['company_id'];
            //     $vouchers->save();
            // }
            // if (($purchase['autocash']) == true) {
            //     $vouchers = new LedgerDetailWise();
            //     $vouchers->transaction_id = $purchaseData['id'];
            //     $vouchers->party_id = $purchaseData['party_id'];
            //     $vouchers->voucher_no = $purchaseData['invoice_no'];
            //     $vouchers->invoice_no = $purchaseData['invoice_no'];
            //     $vouchers->voucher_type = $purchaseData['purchase_type'];
            //     $vouchers->date = $purchaseData['date'];
            //     $vouchers->product_id = $product['product_id'];
            //     $vouchers->quantity = $product['quantity'];
            //     $vouchers->rate = $product['rate'];
            //     $vouchers->other = $product['taxvalue'];
            //     $vouchers->credit = $product['incvalue'];
            //     $vouchers->company_id = $product['company_id'];
            //     $vouchers->save();
            // }

            // if (($purchase['autocash']) == false) {
            //     $vouchers = new LedgerDetailWise();
            //     $vouchers->transaction_id = $purchaseData['id'];
            //     $vouchers->party_id = $purchaseData['party_id'];
            //     $vouchers->voucher_no = $purchaseData['voucher_no'];
            //     $vouchers->invoice_no = $purchaseData['invoice_no'];
            //     $vouchers->voucher_type = $purchaseData['purchase_type'];
            //     $vouchers->date = $purchaseData['date'];
            //     $vouchers->product_id = $product['product_id'];
            //     $vouchers->quantity = $product['quantity'];
            //     $vouchers->rate = $product['rate'];
            //     $vouchers->other = $product['taxvalue'];
            //     $vouchers->credit = $product['incvalue'];
            //     $vouchers->company_id = $product['company_id'];
            //     $vouchers->save();
            // }
        }

        // if (($purchase['autocash']) == true) {
        //     $vouchers = new GeneralVoucher();
        //     $vouchers->transaction_id = $purchaseData['id'];
        //     $vouchers->account_head_id = $purchaseData['party_id'];
        //     $vouchers->date = $purchaseData['date'];
        //     $vouchers->voucher_no = $purchaseData['voucher_no'];
        //     $vouchers->invoice_no = $purchaseData['invoice_no'];
        //     $vouchers->v_type = $purchaseData['purchase_type'];
        //     $vouchers->company_id = $purchaseData['company_id'];
        //     $vouchers->credit = $sum;
        //     $vouchers->save();
        // }

        // if (($purchase['autocash']) == false) {
        //     $vouchers = new GeneralVoucher();
        //     $vouchers->transaction_id = $purchaseData['id'];
        //     $vouchers->account_head_id = $purchaseData['party_id'];
        //     $vouchers->date = $purchaseData['date'];
        //     $vouchers->voucher_no = $purchaseData['voucher_no'];
        //     $vouchers->invoice_no = $purchaseData['invoice_no'];
        //     $vouchers->v_type = $purchaseData['purchase_type'];
        //     $vouchers->company_id = $purchaseData['company_id'];
        //     $vouchers->credit = $sum;
        //     $vouchers->save();
        // }
        //return "inserted";

            $DeliveryChallan = DeliveryChallan::where('vr_no', $purchase['p_order'])
                ->where('company_id',  $CompanyID)
                ->where('type',  "GRN")
                ->first();
            if ($DeliveryChallan) {
                $DeliveryChallan->status = 1;
                $DeliveryChallan->save();
            }
        return $purchaseData['id'];
    }

    public function show($id)
    {
        $newsale_detail = PurchaseTax::with(['purchasetax_details' => function ($query) {
            $query->with(['products' => function ($query) {
            }]);
            //$query->with('taxes');
            //$query->with('discount');
            //$query->with('ledger');
            //$query->with('publishers');
        }]) //->with('parties')->with('billers')
            ->where('purchase_taxes.id', '=', $id)
            ->where('company_id', session()->get('company_id'))
            ->get();
        $ledgers = Ledger::with('ledger_party')
            ->where('party_id', '=', $newsale_detail[0]->parties->id)
            ->get();
        //return $newsale_detail;

        $company_detail = Setting::where('id', '=', 1)->get();
        //return $company_detail;
        return view('purchase-tax.print', compact('newsale_detail', 'company_detail', 'ledgers'));
    }

    public function edit($id)
    {
        $purchase = PurchaseTax::with(['purchasetax_details' => function ($query) {
            $query->with('products:id,product_code,product_name,uom');
            // $query->with('uoms');
        }])
            ->with('parties')
            ->where('purchase_taxes.id', '=', $id)
            ->get();
        //return $purchase;
        $DeliveryChallan = DeliveryChallan::where('status', '=', 'Pending')
            ->OrderBy('vr_no', 'asc')
            ->pluck('vr_no', 'vr_no')
            ->prepend('Select Challan', '0')
            ->toArray();
        //$customer = Party::OrderBy('id', 'asc')->pluck('party_name', 'id');
        $edit = $purchase[0];
        //return $edit;
        $products = Product::select(DB::raw('CONCAT(`id`, "_", `product_name`) AS `id`, `product_name`'))
            ->OrderBy('id', 'asc')
            ->where('company_id', session()->get('company_id'))
            ->pluck('product_name', 'id')
            ->prepend('Select Product', '0')
            ->toArray();

        //$taxes = Tax::select(DB::raw('CONCAT(`id`, "_", `tax_rate`) AS `tax_rate`, `tax_title`'))->OrderBy('tax_title', 'asc')->pluck('tax_title', 'tax_rate')->prepend('Select Tax', '0.00')->toArray();
        // $customers = Party::OrderBy('party_name', 'asc')->pluck('Party_name', 'id')->prepend('Select Customer', '0')->toArray();
        $customers = Party::where('parties.account_group_id', '=', '2')
            ->where('company_id', session()->get('company_id'))
            ->OrderBy('party_name', 'asc')
            ->pluck('party_name', 'id');

             
        $uoms = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))->OrderBy('id', 'asc')->pluck('uom', 'id')->toArray();
        $discounts = Discount::select(DB::raw('CONCAT(`id`, "_", `discount`) AS `discount`, `title`'))->OrderBy('id', 'asc')->pluck('title', 'discount')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('purchase-tax.edit', compact('edit', 'products', 'DeliveryChallan', 'customers', 'encrypted_token', 'uoms', 'discounts'));
    }

    public function update(Request $request, $id)
    {
        //return "in purchase";
        $purchaseData = PurchaseTax::findOrFail($id);
        $purchase = json_decode($request->get('purchase'), true);
        //return $purchase;
        $purchaseData->party_id = $purchase['party_id'];
        $purchaseData->date = date('Y-m-d', strtotime($purchase['date']));
        $purchaseData->voucher_no = $purchase['voucher_no'];
        $purchaseData->p_order = $purchase['p_order'];
        $purchaseData->purchase_type = $purchase['purchase_type'];
        $purchaseData->invoice_no = $purchase['invoice_no'];
        $purchaseData->invoice_no1 = $purchase['invoice_no1'];
        $purchaseData->remarks = $purchase['remarks'];
        // $purchaseData->p_order = $purchase['p_order'];
        $purchaseData->biller = $purchase['biller'];
        $purchaseData->company_id = $purchase['company_id'];
        $purchaseData->save();
        PurchaseTaxDetails::where('purchase_id', '=', $id)->delete();
        GeneralVoucher::where('transaction_id', '=', $id)->where('v_type', 'PurchaseTax Invoice')->delete();
        // LedgerDetailWise::where('transaction_id', '=', $id)->where('voucher_type', 'PurchaseTax Invoice')->delete();
        // StockRegisterSpecificItem::where('purchasetax_id', '=', $id)->delete();
        RawMaterialStock::where('transction_id', '=', $id)->where('type', 'PURCHASE TAX')->delete();
        $products = $request->get('product_data');
        //return $products;
        $sum = 0;
        foreach ($products as $product) {
            $purchaseDetail = new PurchaseTaxDetails();
            $purchaseDetail->purchase_id = $purchaseData['id'];
            $purchaseDetail->product_id = $product['product_id'];
            $purchaseDetail->party_id = $product['party_id'];
            $purchaseDetail->uom_id = $product['uom_id'] ?? null;
            if (($purchase['lessCommercial']) == "true") {
                $purchaseDetail->status = "1";
            } else {
                $purchaseDetail->status = "0";
            }
            $purchaseDetail->quantity = $product['quantity'];
            $purchaseDetail->rate = $product['rate'];
            $purchaseDetail->stvalue = $product['stvalue'];
            $purchaseDetail->taxvalue = $product['taxvalue'];
            $purchaseDetail->extratax = $product['extratax'];
            $purchaseDetail->extraTaxValue = $product['extraTaxValue'];
            $purchaseDetail->price = $product['excvalue'];
            $purchaseDetail->total = $product['incvalue'];
            $purchaseDetail->company_id = $product['company_id'];
            $sum = $sum + $product['incvalue'];
            $purchaseDetail->save();

            $RawMaterial = new RawMaterialStock();
			$RawMaterial->transction_id = $purchaseData['id'];
			$RawMaterial->type = "PURCHASE TAX";
			$RawMaterial->warehouse_id = 1;
            $RawMaterial->party_id = $product['party_id'];
			$RawMaterial->product_id = $product['product_id'];
			$RawMaterial->uom_id = $product['uom_id'];
			$RawMaterial->date = $purchaseData['date'];
			$RawMaterial->voucher_no = $purchaseData['invoice_no'];
			$RawMaterial->cost_amount = $product['incvalue'];
			$RawMaterial->stockin = $product['quantity'];
			$RawMaterial->company_id = $product['company_id'];
			$RawMaterial->save();

            // $vouchers = new LedgerDetailWise();
			// $vouchers->transaction_id = $purchaseData['id'];
			// $vouchers->warehouse_id = $purchaseData['warehouse_id'];
			// $vouchers->party_id = $purchaseData['party_id'];
			// $vouchers->voucher_no = $purchaseData['invoice_no'];
			// $vouchers->voucher_type = $purchaseData['purchase_type'];
			// $vouchers->date = $purchaseData['date'];
			// $vouchers->product_id = $product['product_id'];
			// $vouchers->quantity = $product['quantity'];
			// $vouchers->rate = $product['rate'];
			// $vouchers->credit = $product['incvalue'];
			// $vouchers->company_id = $product['company_id'];
			// $vouchers->save();

			$vouchers = new GeneralVoucher();
			$vouchers->transaction_id = $purchaseData['id'];
			$vouchers->account_head_id = $purchaseData['party_id'];
			$vouchers->warehouse_id = $purchaseData['warehouse_id'];
			$vouchers->date = $purchaseData['date'];
			$vouchers->voucher_no = $purchaseData['invoice_no'];
			$vouchers->v_type = $purchaseData['purchase_type'];
			$vouchers->company_id = $product['company_id'];
			$vouchers->credit = $product['incvalue'];
			// $vouchers->credit = $sum;
			$vouchers->save();

			// $vouchers = new LedgerDetailWise();
			// $vouchers->transaction_id = $purchaseData['id'];
			// $vouchers->warehouse_id = $purchaseData['warehouse_id'];
			// $vouchers->party_id = 1;
			// $vouchers->voucher_no = $purchaseData['invoice_no'];
			// $vouchers->voucher_type = $purchaseData['purchase_type'];
			// $vouchers->date = $purchaseData['date'];
			// $vouchers->product_id = $product['product_id'];
			// $vouchers->quantity = $product['quantity'];
			// $vouchers->rate = $product['rate'];
			// $vouchers->debit = $product['incvalue'];
			// $vouchers->company_id = $product['company_id'];
			// $vouchers->save();

			$vouchers = new GeneralVoucher();
			$vouchers->transaction_id = $purchaseData['id'];
			$vouchers->account_head_id = 1;
			$vouchers->warehouse_id = $purchaseData['warehouse_id'];
			$vouchers->date = $purchaseData['date'];
			$vouchers->voucher_no = $purchaseData['invoice_no'];
			$vouchers->v_type = $purchaseData['purchase_type'];
			$vouchers->company_id = $product['company_id'];
			$vouchers->debit = $product['incvalue'];
			// $vouchers->debit = $sum;
			$vouchers->save();

            // if (($purchase['autocash']) == true) {
            //     $vouchers = new LedgerDetailWise();
            //     $vouchers->transaction_id = $objPurchase['id'];
            //     $vouchers->party_id = $objPurchase['party_id'];
            //     $vouchers->voucher_no = $objPurchase['invoice_no'];
            //     $vouchers->invoice_no = $objPurchase['invoice_no'];
            //     $vouchers->voucher_type = $objPurchase['purchase_type'];
            //     $vouchers->date = $objPurchase['date'];
            //     $vouchers->product_id = $product['product_id'];
            //     $vouchers->quantity = $product['quantity'];
            //     $vouchers->rate = $product['rate'];
            //     $vouchers->other = $product['taxvalue'];
            //     $vouchers->credit = $product['incvalue'];
            //     $vouchers->company_id = $product['company_id'];
            //     $vouchers->save();
            // }

            // if (($purchase['autocash']) == false) {
            //     $vouchers = new LedgerDetailWise();
            //     $vouchers->transaction_id = $objPurchase['id'];
            //     $vouchers->party_id = $objPurchase['party_id'];
            //     $vouchers->voucher_no = $objPurchase['voucher_no'];
            //     $vouchers->invoice_no = $objPurchase['invoice_no'];
            //     $vouchers->voucher_type = $objPurchase['purchase_type'];
            //     $vouchers->date = $objPurchase['date'];
            //     $vouchers->product_id = $product['product_id'];
            //     $vouchers->quantity = $product['quantity'];
            //     $vouchers->rate = $product['rate'];
            //     $vouchers->other = $product['taxvalue'];
            //     $vouchers->debit = $product['incvalue'];
            //     $vouchers->company_id = $product['company_id'];
            //     $vouchers->save();
            // }
        }

        // if (($purchase['autocash']) == true) {
        //     $vouchers = new GeneralVoucher();
        //     $vouchers->transaction_id = $objPurchase['id'];
        //     $vouchers->account_head_id = $objPurchase['party_id'];
        //     $vouchers->date = $objPurchase['date'];
        //     $vouchers->voucher_no = $objPurchase['voucher_no'];
        //     $vouchers->invoice_no = $objPurchase['invoice_no'];
        //     $vouchers->v_type = $objPurchase['purchase_type'];
        //     $vouchers->company_id = $objPurchase['company_id'];
        //     $vouchers->credit = $sum;
        //     $vouchers->save();
        // }

        // if (($purchase['autocash']) == false) {
        //     $vouchers = new GeneralVoucher();
        //     $vouchers->transaction_id = $objPurchase['id'];
        //     $vouchers->account_head_id = $objPurchase['party_id'];
        //     $vouchers->date = $objPurchase['date'];
        //     $vouchers->voucher_no = $objPurchase['voucher_no'];
        //     $vouchers->invoice_no = $objPurchase['invoice_no'];
        //     $vouchers->v_type = $objPurchase['purchase_type'];
        //     $vouchers->company_id = $objPurchase['company_id'];
        //     $vouchers->debit = $sum;
        //     $vouchers->save();
        // }

        return $purchaseData['id'];
        //return "updated"; 
    }

    public function destroy($id)
    {
        $CompanyID = session()->get('company_id');
        $delete = PurchaseTax::findOrFail($id);
        $grn = DeliveryChallan::where('vr_no', $delete->p_order)
            ->where('company_id',  $CompanyID)
            ->where('type',  "GRN")
            ->first();
        if ($grn) {
            $grn->status = 0;
            $grn->save();
        }
        $delete->delete();
        PurchaseTaxDetails::where('purchase_id', '=', $id)->where('company_id', $CompanyID)->delete();
        GeneralVoucher::where('transaction_id', '=', $id)->where('company_id', $CompanyID)->where('v_type', 'PurchaseTax Invoice')->delete();
        // LedgerDetailWise::where('transaction_id', '=', $id)->where('company_id', $CompanyID)->where('voucher_type', 'PurchaseTax Invoice')->delete();
        // StockRegisterSpecificItem::where('purchasetax_id', '=', $id)->delete();
        RawMaterialStock::where('transction_id', '=', $id)->where('company_id', $CompanyID)->where('type', 'PURCHASE TAX')->delete();
        // return "Purchase Tax Invoice Deleted Successfully!";
         Session::flash('flash_message', 'Purchase Invoice deleted Successfully!');
        return redirect()->back();
    }


    public function productChange(Request $request)
    {
        // return "d";
        $CompanyID = session()->get('company_id');
        $sellerCompany = Companies::where('id', $CompanyID)->first('invoice_type');
        $productID = $request->get('product_ID');
        if($sellerCompany->invoice_type == "SandBox"){
            $data = Product::where('id', '=', $productID)
            ->where('company_id', 0)
            ->get(['products.*']);
            return $data;
        }else{
            $data = Product::where('id', '=', $productID)
            ->where('company_id', session()->get('company_id'))->get(['products.*']);
            return $data;
        }
        
      
    }

    public function searchSuppliersAjax(Request $request)
    {
        $companyID = session()->get('company_id');
        $term = trim($request->get('q', ''));

        $query = Party::where('account_group_id', 2)
            ->where('company_id', $companyID);

        if ($term !== '') {
            $query->where('party_name', 'like', '%' . $term . '%');
        }

        $parties = $query->orderBy('party_name')->limit(30)->get(['id', 'party_name']);

        return response()->json([
            'results' => $parties->map(function ($party) {
                return ['id' => $party->id, 'text' => $party->party_name];
            })->values(),
        ]);
    }

    public function searchProductsAjax(Request $request)
    {
        $companyID = session()->get('company_id');
        $term = trim($request->get('q', ''));

        $query = Product::where('company_id', $companyID);

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
                    'id' => $product->id . '_' . $product->product_name,
                    'text' => $product->product_name,
                ];
            })->values(),
        ]);
    }
}
