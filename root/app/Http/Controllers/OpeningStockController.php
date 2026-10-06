<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Companies;
use App\Models\Tax;
use App\Models\SystemLogo;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\GRN;
use App\Models\Party;
use App\Models\StockRegisterSpecificItem;
use App\Models\UOM;
use App\Models\Warehouse;
use App\Models\Setting;
use App\Models\RawMaterialStock;
use App\Models\Sales;
use App\Models\SaleDetail;
use App\Models\GeneralVoucher;
use App\Models\LedgerDetailWise;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class OpeningStockController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // $purchases = Purchase::with(['purchase_details'=>function($query){
        //                         $query->with('purchase_tax');
        //                         }])->with('parties')->OrderBy('purchases.id', 'desc')->get();
        // //return $purchases;
        // return view('opening-stock.index', Compact('purchases'));

        $purchases = Purchase::where('purchase_type', '=', 'ADJUST')
            ->with(['purchase_details' => function ($query) {
                $query->with('purchase_tax');
            }])->with('parties')
            ->where('company_id', session()->get('company_id'))
            ->OrderBy('purchases.id', 'desc')->get();
        //return $purchases;
        return view('opening-stock.index', compact('purchases'));
    }

    public function create()
    {
        $codes = 1;
        $code = Purchase::where('purchase_type', 'ADJUST')->where('company_id', session()->get('company_id'))
            ->OrderBy('id','desc')->first();
         //return $code;
        // $codes = $code->last()->bill_no + 1;
        if (isset($code) > 0) {
            $codes = (int)$code->bill_no + 1;
        }

        $grns = GRN::where('status', '=', 'Pending')->OrderBy('grn_no', 'asc')->pluck('grn_no', 'grn_no')->prepend('Select Grn', '0')->toArray();
        $products = ['' => 'Select Product'];
        $taxes = Tax::select(DB::raw('CONCAT(`id`, "_", `tax_rate`) AS `tax_rate`, `tax_title`'))->OrderBy('id', 'asc')->pluck('tax_title', 'tax_rate')->toArray();
        //$suppliers = Supplier::OrderBy('id', 'asc')->pluck('name', 'id');
        // $Account = Party::join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
        //     ->where('parties.account_group_id', '=', '8')
        //     ->Orwhere('parties.account_group_id', '=', '')
        //     ->OrderBy('party_name', 'asc')->pluck('party_name', 'parties.id')->prepend('Select Account', '0');
        $Account = Party::where('id', '=', 8)
            ->where('company_id', session()->get('company_id'))
            ->pluck('party_name', 'id')->toArray();
        $warehouse = Warehouse::OrderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        $uoms = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))->OrderBy('id', 'asc')->pluck('uom', 'id')->prepend('PCS', '2_PCS')->toArray();
        return view('opening-stock.create', compact('Account', 'products', 'codes', 'taxes', 'grns', 'encrypted_token', 'uoms', 'warehouse'));
    }

    public function store(Request $request)
    {
         //return $request;
        $this->validate($request, [
            'products_id' => 'required',
            'quantity' => 'required',
            'price' => 'required',
        ]
    ,[
        'products_id.required' => 'Product Name is required'
    ]
    );
        //return $request->all();
        if ($request->purchase_type == "ADJUST") {
            $purchaseData = Purchase::create($request->all());

            $count = Count($request->products_id);
            //return $count;
            $sum = "0";
            for ($i = 0; $i < $count; $i++) {
                $stock = new PurchaseDetail();
                $stock->purchase_id = $purchaseData['id'];
                $stock->party_id = $purchaseData['account_id'];
                $stock->product_id = $request->products_id[$i];
                $stock->uom_id = $request->uoms_id[$i];
                $stock->warehouse_id = $purchaseData['warehouse_id'];
                $stock->quantity = $request->quantity[$i];
                $stock->remaining_quantity = $request->quantity[$i];
                $stock->unit_cost = $request->price[$i];
                $stock->total_cost = $request->total[$i];
                $stock->company_id = session()->get('company_id');
                $sum = $sum + $request->total[$i];
                $stock->save();

                $purchaseDetail = new GeneralVoucher();
                $purchaseDetail->transaction_id = $purchaseData['id'];
                $purchaseDetail->account_head_id = 4;
                $purchaseDetail->date = $purchaseData['date'];
                $purchaseDetail->voucher_no = $purchaseData['bill_no'];
                $purchaseDetail->v_type = $purchaseData['purchase_type'];
                $purchaseDetail->narration = "OPENING STOCK";
                $purchaseDetail->credit = $request->total[$i];
                $purchaseDetail->company_id = session()->get('company_id');
                $purchaseDetail->save();

                // $vouchers = new LedgerDetailWise();
                // $vouchers->transaction_id = $purchaseData['id'];
                // $vouchers->party_id = 4;
                // $vouchers->voucher_no = $purchaseData['bill_no'];
                // $vouchers->voucher_type = $purchaseData['purchase_type'];
                // $vouchers->date = $purchaseData['date'];
                // $vouchers->other = "OPENING STOCK";
                // $vouchers->credit = $request->total[$i];
                // $vouchers->company_id = session()->get('company_id');
                // $vouchers->save();

                $RawMaterial = new RawMaterialStock();
                $RawMaterial->transction_id = $purchaseData['id'];
                $RawMaterial->type = "OPENING STOCK";
                $RawMaterial->party_id = 0;
                $RawMaterial->warehouse_id = $purchaseData['warehouse_id'];
                $RawMaterial->product_id = $request->products_id[$i];
                $RawMaterial->uom_id = $request->uoms_id[$i];
                $RawMaterial->date = $purchaseData['date'];
                $RawMaterial->voucher_no = $purchaseData['bill_no'];
                $RawMaterial->cost_amount = $request->total[$i];
                $RawMaterial->stockin = $request->quantity[$i];
                $RawMaterial->company_id = session()->get('company_id');
                $RawMaterial->save();

             

            }
        } else {
            //return "WASTE";

            // $SaleData = Sales::create($request->all());
            $SaleData = new Sales();
            $SaleData->date = $request->get('date');
            $SaleData->invoice_no = $request->get('bill_no');
            $SaleData->sale_type = $request->get('purchase_type');
            $SaleData->sale_list = $request->get('purchase_type');
            $SaleData->warehouse_id = $request->get('warehouse_id');
            $SaleData->party_id = $request->get('account_id');
            $SaleData->company_id = session()->get('company_id');
            $SaleData->biller = Auth::User()->id;
            $SaleData->save();

            $count = Count($request->products_id);
            //return $count;
            $sum = "0";
            for ($i = 0; $i < $count; $i++) {
                $saleDetail = new SaleDetail();
                $saleDetail->sale_id = $SaleData['id'];
                $saleDetail->product_id = $request->products_id[$i];
                $saleDetail->party_id = $request->get('account_id');
                $saleDetail->uom_id = $request->uoms_id[$i];
                $saleDetail->quantity = $request->quantity[$i];
                $saleDetail->product_cost = $request->price[$i];
                $saleDetail->cost_amount = $request->total[$i];
                $saleDetail->discount_id = 1;
                $saleDetail->warehouse_id = $SaleData['warehouse_id'];
                $saleDetail->biller = Auth::User()->id;
                $saleDetail->sale_rate = 0;
                $saleDetail->sale_amount = 0;
                // $purchaseDetail->product_cost = $product['product_cost'];
                $saleDetail->product_cost = $request->price[$i];
                // $purchaseDetail->cost_amount = $product['cost_amount'];
                $saleDetail->cost_amount = $request->total[$i];
                $saleDetail->company_id = session()->get('company_id');
                //$sum = $sum + $product['balance'];      
                $saleDetail->save();

                // $vouchers = new StockRegisterSpecificItem();
                // $vouchers->purchase_id = $SaleData['id'];
                // $vouchers->date = $SaleData['date'];
                // $vouchers->party_id = $SaleData['account_id'];
                // $vouchers->product_id = $request->products_id[$i];
                // $vouchers->voucher_type = $request->get('purchase_type');
                // $vouchers->warehouse_id = $SaleData['warehouse_id'];
                // $vouchers->uom_id = $request->uoms_id[$i];
                // $vouchers->purchase_quantity = $request->quantity[$i];
                // $vouchers->cost_rate = $request->total[$i];
                // $vouchers->company_id = $request->company_id[$i];
                // $vouchers->save();

               

            }
        }

        Session::flash('flash_message', 'Opening Stock Added Successfully!');
        return redirect('opening-stock/create');
        // return $purchaseData['id'];
        //return "inserted";     
    }

    public function show($id)
    {
        $logo = SystemLogo::where('id', '=', 1)->get();
        $detail = Purchase::with(['purchase_details' => function ($query) {
            $query->with('unit');
            $query->with('purchase_tax');
            $query->with('products');
        }])
            ->with('parties')
            ->where('purchases.id', '=', $id)
            ->where('company_id', session()->get('company_id'))
            ->get();
        //return $detail;
        $purchase_detail = $detail[0];
        $company_detail = Setting::where('id', '=', 1)->get();
        //return $purchase_detail;
        $CompanyID = session()->get('company_id');
        // $purchase = json_decode($request->get('purchase'), true);
        $sellerCompany = Companies::where('id', $CompanyID)->first();
        return view('opening-stock.print', compact('purchase_detail', 'logo', 'company_detail', 'sellerCompany'));
    }

    public function edit($id)
    {
        $purchase = Purchase::with(['purchase_details' => function ($query) {
            $query->with('purchase_tax');
            $query->with('products');
            $query->with('unit');
        }])
            ->where('purchases.id', '=', $id)
            ->where('company_id', session()->get('company_id'))
            ->get();
        $edit = $purchase[0];
        $grns = GRN::OrderBy('grn_no', 'asc')->pluck('grn_no', 'grn_no')->prepend('Select Grn', '0')->toArray();
        $products = ['' => 'Select Product'];
        $taxes = Tax::select(DB::raw('CONCAT(`id`, "_", `tax_rate`) AS `tax_rate`, `tax_title`'))->OrderBy('tax_title', 'asc')->pluck('tax_title', 'tax_rate')->prepend('Select Tax', '0.00')->toArray();
        //$suppliers =Party::where('type', 'Buyer')->OrderBy('party_name', 'asc')->pluck('party_name', 'id');
        //$Account = Party::OrderBy('party_name', 'asc')->pluck('party_name', 'id')->prepend('Select Account', '0');
        $Account = Party::join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
            ->where('parties.account_group_id', '=', '2')
            ->Orwhere('parties.account_group_id', '=', '8')
            ->where('company_id', session()->get('company_id'))
            ->OrderBy('party_name', 'asc')
            ->pluck('party_name', 'parties.id');
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        $warehouse = Warehouse::OrderBy('name', 'asc')->pluck('name', 'id')->toArray();
        //return $edit;
        $uoms = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))->OrderBy('id', 'asc')->pluck('uom', 'id')->toArray();
        return view('opening-stock.edit', compact('edit', 'products', 'taxes', 'Account', 'grns', 'encrypted_token', 'uoms', 'warehouse'));
    }

    public function update(Request $request, $id)
    {
        // return $request->all();
        $this->validate($request, [
            'account_id' => 'required',
            'account_id' => 'required'
        ]);
        //return $request->all();
        $purchaseData = Purchase::findOrFail($id);
        $purchaseData->update($request->all());

        PurchaseDetail::where('purchase_id', '=', $id)->delete();
        // StockRegisterSpecificItem::where('purchase_id', '=', $id)->delete();
        RawMaterialStock::where('transction_id', '=', $id)->where('type', 'OPENING STOCK')->delete();
        $count = Count($request->products_id);
        //return $count;
        $sum = "0";
        for ($i = 0; $i < $count; $i++) {
            $stock = new PurchaseDetail();
            $stock->purchase_id = $purchaseData['id'];
            $stock->party_id = $purchaseData['account_id'];
            $stock->product_id = $request->products_id[$i];
            $stock->uom_id = $request->uoms_id[$i];
            $stock->warehouse_id = $purchaseData['warehouse_id'];
            $stock->quantity = $request->quantity[$i];
            $stock->remaining_quantity = $request->quantity[$i];
            $stock->unit_cost = $request->price[$i];
            $stock->total_cost = $request->total[$i];
            $stock->company_id = $request->company_id;
            $sum = $sum + $request->total[$i];
            $stock->save();

            $RawMaterial = new RawMaterialStock();
            $RawMaterial->transction_id = $purchaseData['id'];
            $RawMaterial->type = "OPENING STOCK";
            $RawMaterial->party_id = 0;
            $RawMaterial->warehouse_id = $purchaseData['warehouse_id'];
            $RawMaterial->product_id = $request->products_id[$i];
            $RawMaterial->uom_id = $request->uoms_id[$i];
            $RawMaterial->date = $purchaseData['date'];
            $RawMaterial->voucher_no = $purchaseData['bill_no'];
            $RawMaterial->cost_amount = $request->total[$i];
            $RawMaterial->stockin = $request->quantity[$i];
            $RawMaterial->company_id = $request->company_id;
            $RawMaterial->save();
        }

        Session::flash('flash_message', 'Opening Stock Updated Successfully!');
        return redirect('opening-stock');
        // return $purchaseData['id'];
        //return "inserted";
    }

    public function destroy($id)
    {
        $purchaseData = Purchase::findOrFail($id);
        $purchaseData->delete();
        PurchaseDetail::where('purchase_id', '=', $id)->delete();
        GeneralVoucher::where('transaction_id', '=', $id)->where('v_type', 'ADJUST')->delete();
        LedgerDetailWise::where('transaction_id', '=', $id)->where('voucher_type', 'ADJUST')->delete();
        // StockRegisterSpecificItem::where('purchase_id', '=', $id)->delete();
        RawMaterialStock::where('transction_id', '=', $id)->where('type', 'OPENING STOCK')->delete();
        //Session::flash('flash_message', 'Record Deleted Successfully!');
        return 'Record Deleted Successfully!';
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
                    'id' => $product->id . '_' . $product->product_code . '_' . $product->product_name,
                    'text' => $product->product_code . ' - ' . $product->product_name,
                ];
            })->values(),
        ]);
    }
}
