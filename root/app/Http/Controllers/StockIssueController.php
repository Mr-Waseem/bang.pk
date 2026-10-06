<?php

namespace App\Http\Controllers;

use Excel;
use App\Models\GRN;
use App\Models\Tax;
use App\Models\UOM;
use App\Models\Party;
use App\Models\Product;
use App\Models\Setting;
use App\Models\CashBook;
use App\Models\Purchase;
use App\Models\Warehouse;
use App\Models\GRNDetails;
use App\Models\SystemLogo;
use Illuminate\Http\Request;
use App\Models\GeneralVoucher;
use App\Models\PurchaseDetail;
use App\Models\ProductionStock;
use App\Models\WorkingProgress;
use App\Models\LedgerDetailWise;
use App\Models\RawMaterialStock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\RecipeCreationDetails;
use Illuminate\Support\Facades\Session;
use App\Models\StockRegisterSpecificItem;

class StockIssueController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //return $stockissue = WorkingProgress::all();
        $purchases = Purchase::where('purchase_type', 'Stock Issue')
            ->with(['purchase_details' => function ($query) {
                $query->with('purchase_tax');
            }])
            ->with('parties')
            ->OrderBy('purchases.id', 'desc')
            ->get();
        return view('stock-issue.index', compact('purchases'));
    }

    public function create()
    {
        $code = Purchase::OrderBy('id', 'asc')->get();
        $codes = $code->last()->bill_no + 1;

        $grns = GRN::where('status', '=', 'Pending')->OrderBy('grn_no', 'asc')->pluck('grn_no', 'grn_no')->prepend('Select Grn', '0')->toArray();

        $products = Product::select(DB::raw('CONCAT(`id`, "_", `product_name`) AS `id`, `product_name`'))
             ->where('catagory_id', 5)
            ->OrderBy('id', 'asc')
            ->where('company_id', session()->get('company_id'))
            ->pluck('product_name', 'id')
            ->prepend('Select Product', '0')
            ->toArray();

            // $products = Product::select(DB::raw('CONCAT(`id`, "_", `product_name`) AS `id`, `product_name`'))
			// ->OrderBy('id', 'asc')
			// ->where('company_id', session()->get('company_id'))
			// ->where('catagory_id', '=', '5')
			// ->pluck('product_name', 'id')
			// ->prepend('Select Product', '0')
			// ->toArray();

        $taxes = Tax::select(DB::raw('CONCAT(`id`, "_", `tax_rate`) AS `tax_rate`, `tax_title`'))->OrderBy('id', 'asc')->pluck('tax_title', 'tax_rate')->toArray();

        $Account = Party::join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
            // ->where('parties.account_group_id', '=', '13')
            ->where('company_id', session()->get('company_id'))
            ->OrderBy('party_name', 'asc')
            ->pluck('party_name', 'parties.id');


        $warehouse = Warehouse::OrderBy('name', 'asc')
            ->where('id', '=', 1)
            ->pluck('name', 'id')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        $uoms = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))->OrderBy('id', 'asc')->pluck('uom', 'id')->prepend('PCS', '2_PCS')->toArray();
        return view('stock-issue.create-simple', Compact('Account', 'products', 'codes', 'taxes', 'grns', 'encrypted_token', 'uoms', 'warehouse'));
    }

    public function store(Request $request)
    {
       // return $request;
        $this->validate($request, [
            'product_id1' => 'required',
             'quantity' => 'required',
             'unit_cost' => 'required',
        ]
    // ,[
    //     'product_id.required' => 'Product Name is required',
    //     'price_per_unit.required' => 'Rate is required'
    // ]
    );
        //return session()->get('company_name');
        $purchaseData = Purchase::create($request->all());
        $sum = "0";
        $count = count($request->quantity);
        for ($i = 0; $i < $count; $i++) {
            $purchaseDetail = new PurchaseDetail();
            $purchaseDetail->purchase_id = $purchaseData['id'];
            $purchaseDetail->party_id = $purchaseData['account_id'];
            $purchaseDetail->product_id = $request->product_id1[$i];
            $purchaseDetail->uom_id = $request->uom_id[$i];
            $purchaseDetail->warehouse_id = $purchaseData['warehouse_id'];
            $purchaseDetail->quantity = $request->quantity[$i];
            $purchaseDetail->remaining_quantity = $request->quantity[$i];
            $purchaseDetail->unit_cost = $request->unit_cost[$i];
            $purchaseDetail->total_cost = $request->total_cost[$i];
            // $purchaseDetail->purchase_type = $purchaseData->purchase_type;
            $sum = $sum + $request->total_cost[$i];
            $purchaseDetail->save();

            // $vouchers = new LedgerDetailWise();
            // $vouchers->purchase_id = $purchaseData['id'];
            // $vouchers->warehouse_id = $purchaseData['warehouse_id'];
            // $vouchers->party_id = $purchaseData['account_id'];
            // $vouchers->voucher_no = $purchaseData['bill_no'];
            // $vouchers->voucher_type = $purchaseData['purchase_type'];
            // $vouchers->date = $purchaseData['date'];
            // $vouchers->product_id = $request->product_id1[$i];
            // $vouchers->quantity = $request->quantity[$i];
            // $vouchers->rate = $request->unit_cost[$i];
            // $vouchers->credit = $request->total_cost[$i];
            // $vouchers->save();

            // $vouchers = new StockRegisterSpecificItem();
            // $vouchers->purchase_id = $purchaseData['id'];
            // $vouchers->date = $purchaseData['date'];
            // $vouchers->party_id = $purchaseData['account_id'];
            // $vouchers->product_id = $request->product_id1[$i];
            // $vouchers->voucher_type = $purchaseData['purchase_type'];
            // $vouchers->warehouse_id = $purchaseData['warehouse_id'];
            // $vouchers->uom_id = $request->uom_id[$i];
            // $vouchers->purchase_quantity = $request->quantity[$i];
            // $vouchers->cost_rate = $request->total_cost[$i];
            // $vouchers->save();

            $RawMaterial = new RawMaterialStock();
            $RawMaterial->transction_id = $purchaseData['id'];
            $RawMaterial->company_id = session()->get('company_id');
            $RawMaterial->type = "STOCK.ISSUE";
            $RawMaterial->warehouse_id = $purchaseData['warehouse_id'];
            $RawMaterial->product_id = $request->product_id1[$i];
            $RawMaterial->uom_id = $request->uom_id[$i];
            $RawMaterial->date = $purchaseData['date'];
            $RawMaterial->voucher_no = $purchaseData['bill_no'];
            $RawMaterial->cost_amount = $request->total_cost[$i];
            $RawMaterial->stockout = $request->quantity[$i];
            $RawMaterial->save();

            $stockIssue = new WorkingProgress();
            // $stockIssue->stock_issue_id = $purchaseData['id'];
            $stockIssue->warehouse_id = $purchaseData['warehouse_id'];
            $stockIssue->product_id = $request->product_id1[$i];
            $stockIssue->company_name = session()->get('company_name');
            $stockIssue->account_id = $request->account_id;
            $stockIssue->uom_id = $request->uom_id[$i];
            $stockIssue->date = $purchaseData['date'];
            $stockIssue->voucher_no = $purchaseData['bill_no'];
            $stockIssue->rate = $request->unit_cost[$i];
            $stockIssue->cost_amount = $request->total_cost[$i];
            $stockIssue->stockin = $request->quantity[$i];
            $stockIssue->save();
            //
            // $RawMaterial = new ProductionStock();
            // $RawMaterial->pro_transfer_id = $purchaseData['id'];
            // $RawMaterial->company_id = $purchaseData['company_id'];
            // $RawMaterial->warehouse_id = $purchaseData['warehouse_id'];
            // $RawMaterial->product_id = $product['product_id'];
            // $RawMaterial->uom_id = $product['uom_id'];
            // $RawMaterial->date = $purchaseData['date'];
            // $RawMaterial->voucher_no = $purchaseData['invoice_no'];
            // $RawMaterial->cost_amount = $product['cost_amount'];
            // $RawMaterial->stockout = $product['quantity'];
            // $RawMaterial->save();

            // $RawMaterial = new RawMaterialStock();
            // $RawMaterial->warehouse_id = 1;
            // $RawMaterial->production_id = $quotation['id'];
            // $RawMaterial->product_id = $request->product_id[$i];
            // $RawMaterial->uom_id = $request->uom_id[$i];
            // $RawMaterial->date = $quotation['date'];
            // $RawMaterial->voucher_no = $quotation['vr_no'];
            // $RawMaterial->cost_amount = $request->rate[$i];
            // $RawMaterial->stockout = $request->quantity[$i];
            // $RawMaterial->save();

            //Change cost of one item
            $data = Product::where('id', '=', $request->product_id1[$i])->OrderBy('id', 'asc')->first();
            //return $data;
            // 	$tot = (int)$data->remaining_quantity - (int)$tot;
            $data->product_cost = $request->unit_cost[$i];
            $data->save();

            //Change all cost of one item in recipe
            $stockless = RecipeCreationDetails::where('product_id', '=', $request->product_id1[$i])->get();

            foreach ($stockless as $stock) {
                $stock->rate = $request->unit_cost[$i];
                $stock->amount = $stock->quantity * $request->unit_cost[$i];
                $stock->save();
            }
        }

        Session::flash('flash_message', 'Record Added Successfully!');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $delete = Purchase::findOrFail($id);
        $delete->delete();
        PurchaseDetail::where('purchase_id', '=', $id)->delete();
        GeneralVoucher::where('purchase_id', '=', $id)->delete();
        LedgerDetailWise::where('purchase_id', '=', $id)->delete();
        RawMaterialStock::where('stock_issue_id', '=', $id)->delete();
        CashBook::where('purchase_id', '=', $id)->delete();
        return "Issued Stock has been Deleted Successfully!";
    }

    public function show($id)
    {
        $detail = Purchase::with(['purchase_details' => function ($query) {
            $query->with('purchase_tax');
            $query->with('products');
        }])->with('suppliers')->where('purchases.id', '=', $id)->get();

        $purchase_detail = $detail[0];
        return view('stock-issue.details', Compact('purchase_detail'));
    }

    public function edit($id)
    {
        $purchase = Purchase::with(['purchase_details' => function ($query) {
            $query->with('purchase_tax');
            $query->with('products');
            $query->with('unit');
        }])->where('purchases.id', '=', $id)->get();
        $edit = $purchase[0];
        $grns = GRN::OrderBy('grn_no', 'asc')->pluck('grn_no', 'grn_no')->prepend('Select Grn', '0')->toArray();

        $products = Product::select(DB::raw('CONCAT(`id`, "_", `product_name`) AS `id`, `product_name`'))->OrderBy('id', 'asc')->pluck('product_name', 'id')->prepend('Select Product', '0')->toArray();
        $taxes = Tax::select(DB::raw('CONCAT(`id`, "_", `tax_rate`) AS `tax_rate`, `tax_title`'))->OrderBy('tax_title', 'asc')->pluck('tax_title', 'tax_rate')->prepend('Select Tax', '0.00')->toArray();

        $Account = Party::join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')->where('parties.account_group_id', '=', '13')->OrderBy('party_name', 'asc')->pluck('party_name', 'parties.id');

        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());

        $warehouse = Warehouse::OrderBy('name', 'asc')
            ->where('id', '=', 1)
            ->pluck('name', 'id')->toArray();

        $uoms = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))->OrderBy('id', 'asc')->pluck('uom', 'id')->toArray();

        return view('stock-issue.edit', Compact('edit', 'products', 'taxes', 'Account', 'grns', 'encrypted_token', 'warehouse', 'uoms'));
    }

    public function update(Request $request, $id)
    {
        // return $request->account_id;
        $objPurchase = Purchase::findOrFail($id);
        $purchase = json_decode($request->get('purchase'), true);

        $objPurchase->account_id = $request->account_id;
        $objPurchase->date = date('Y-m-d', strtotime($request->date));
        $objPurchase->bill_no = $request->bill_no;
        //$objPurchase->grn_no = $purchase['grn_no'];
        $objPurchase->purchase_type = $request->purchase_type;
        $objPurchase->due_date = $request->due_date;
        $objPurchase->particulars = $request->particulars;
        $objPurchase->save();

        PurchaseDetail::where('purchase_id', '=', $id)->delete();
        StockRegisterSpecificItem::where('purchase_id', '=', $id)->delete();
        LedgerDetailWise::where('purchase_id', '=', $id)->delete();
        GeneralVoucher::where('purchase_id', '=', $id)->delete();
        CashBook::where('purchase_id', '=', $id)->delete();
        $products = $request->get('product_data');
        $sum = "0";
        foreach ($products as $product) {
            $purchaseDetail = new PurchaseDetail();
            $purchaseDetail->purchase_id = $objPurchase['id'];
            $purchaseDetail->party_id = $objPurchase['account_id'];
            $purchaseDetail->product_id = $product['product_id'];
            $purchaseDetail->warehouse_id = $objPurchase['warehouse_id'];
            $purchaseDetail->uom_id = $product['uom_id'];
            $purchaseDetail->quantity = $product['quantity'];
            $purchaseDetail->remaining_quantity = $product['quantity'];
            $purchaseDetail->unit_cost = $product['unit_cost'];
            $purchaseDetail->total_cost = $product['total_cost'];
            $sum = $sum + $product['total_cost'];
            $purchaseDetail->save();

            $vouchers = new LedgerDetailWise();
            $vouchers->purchase_id = $objPurchase['id'];
            $vouchers->party_id = $objPurchase['account_id'];
            $vouchers->warehouse_id = $objPurchase['warehouse_id'];
            $vouchers->voucher_no = $objPurchase['bill_no'];
            $vouchers->voucher_type = $objPurchase['purchase_type'];
            $vouchers->date = $objPurchase['date'];
            $vouchers->product_id = $product['product_id'];
            $vouchers->quantity = $product['quantity'];
            $vouchers->rate = $product['unit_cost'];
            $vouchers->credit = $product['total_cost'];
            $vouchers->save();

            $vouchers = new StockRegisterSpecificItem();
            $vouchers->purchase_id = $objPurchase['id'];
            $vouchers->date = $objPurchase['date'];
            $vouchers->party_id = $objPurchase['account_id'];
            $vouchers->product_id = $product['product_id'];
            $vouchers->voucher_type = $objPurchase['purchase_type'];
            $vouchers->warehouse_id = $objPurchase['warehouse_id'];

            $vouchers->uom_id = $product['uom_id'];
            $vouchers->purchase_quantity = $product['quantity'];
            $vouchers->cost_rate = $product['total_cost'];
            $vouchers->save();
        }
        if (($objPurchase['purchase_type']) == "Cash Purchase") {
            $vouchers = new GeneralVoucher();
            $vouchers->purchase_id = $objPurchase['id'];
            $vouchers->account_head_id = $objPurchase['account_id'];
            $vouchers->warehouse_id = $objPurchase['warehouse_id'];
            $vouchers->date = $objPurchase['date'];
            $vouchers->voucher_no = $objPurchase['bill_no'];
            $vouchers->v_type = $objPurchase['purchase_type'];
            $vouchers->credit = $sum;
            $vouchers->save();

            $cash = new CashBook();
            $cash->date = $objPurchase['date'];
            $cash->vr_no = $objPurchase['bill_no'];
            $cash->vr_type = $objPurchase['purchase_type'];
            $cash->party_id = $objPurchase['account_id'];
            $cash->purchase_id = $objPurchase['id'];
            $cash->shop_id = $objPurchase['warehouse_id'];
            $cash->out = $sum;
            $cash->save();
        }
        if (($objPurchase['purchase_type']) == "Credit Purchase") {
            $vouchers = new GeneralVoucher();
            $vouchers->purchase_id = $objPurchase['id'];
            $vouchers->account_head_id = $objPurchase['account_id'];
            $vouchers->warehouse_id = $objPurchase['warehouse_id'];
            $vouchers->date = $objPurchase['date'];
            $vouchers->voucher_no = $objPurchase['bill_no'];
            $vouchers->v_type = $objPurchase['purchase_type'];
            $vouchers->debit = $sum;
            $vouchers->save();
        }
        return $objPurchase['id'];
    }

    public function print_purchase($id)
    {
        $logo = SystemLogo::where('id', '=', 1)->get();
        $detail = Purchase::with(['purchase_details' => function ($query) {
            $query->with('unit');
            $query->with('purchase_tax');
            $query->with('products');
        }])->with('parties')->where('purchases.id', '=', $id)->get();

        $newsale_detail = $detail[0];

        $company_detail = Setting::where('id', 1)->get();
        return view('purchases.print-new', compact('newsale_detail', 'logo', 'company_detail'));
    }
}