<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\UOM;
use App\Models\Warehouse;
use App\Models\StockTransfer;
use App\Models\StockTransferDetails;
use App\Models\SystemLogo;
use App\Models\Setting;
use App\Models\ProductionStock;
use App\Models\SalePointStock;
use App\Models\StockRegisterSpecificItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockTransferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $sales = StockTransfer::OrderBy('id', 'dsc')->with(['stock_transfer_details' => function ($query) {
        }])->with('warehouse_from')->with('warehouse_to')->with('billers')->get();
        //return $sales;
        return view('stock-transfer.index', Compact('sales'));
    }

    public function create()
    {
        $code = StockTransfer::OrderBy('id', 'asc')->get();
        $codes = (int)$code->last()->invoice_no + 1;

        $products = Product::where('catagory_id', '=', '6')->select(DB::raw('CONCAT(`id`, "_", `product_name`) AS `id`, `product_name`'))->OrderBy('id', 'asc')->pluck('product_name', 'id')->prepend('Select Product', '0')->toArray();


        //return $customers;
        $uoms = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))->OrderBy('id', 'asc')->pluck('uom', 'id')->prepend('KG', '1_KG')->toArray();
        //return $uoms;
        $warehouseFrom = Warehouse::where('id', '=', 1)->pluck('name', 'id')->toArray();
        $warehouseTo = Warehouse::where('id', '!=', 1)->OrderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        //return $products;
        return view('stock-transfer.create-simple', Compact('products', 'codes', 'encrypted_token', 'uoms', 'warehouseFrom', 'warehouseTo'));
    }

    public function store(Request $request)
    {
        //return "hklk";
        $purchase = json_decode($request->get('purchase'), true);
        $purchase['date'] = date('Y-m-d', strtotime($purchase['date']));
        $products = $request->get('product_data');
        //return $products;
        $purchaseData = StockTransfer::create($purchase);
        // }
        $sum = "0";
        $tot = "0";

        foreach ($products as $product) {
            $purchaseDetail = new StockTransferDetails();
            $purchaseDetail->transfer_id = $purchaseData['id'];
            $purchaseDetail->product_id = $product['product_id'];
            $purchaseDetail->uom_id = $product['uom_id'];
            $purchaseDetail->from_warehouse_id = $purchaseData['from_warehouse_id'];
            $purchaseDetail->to_warehouse_id = $purchaseData['to_warehouse_id'];
            $purchaseDetail->quantity = $product['quantity'];
            $purchaseDetail->sale_rate = $product['sale_rate'];
            $purchaseDetail->sale_amount = $product['balance'];
            $sum = $sum + $product['balance'];
            $purchaseDetail->save();

            $RawMaterial = new ProductionStock();
            $RawMaterial->pro_transfer_id = $purchaseData['id'];
            $RawMaterial->warehouse_id = $purchaseData['from_warehouse_id'];
            $RawMaterial->product_id = $product['product_id'];
            $RawMaterial->uom_id = $product['uom_id'];
            $RawMaterial->cost_amount = $product['balance'];
            $RawMaterial->stockout = $product['quantity'];
            $RawMaterial->save();

            $RawMaterial = new SalePointStock();
            $RawMaterial->pro_transfer_id = $purchaseData['id'];
            $RawMaterial->warehouse_id = $purchaseData['to_warehouse_id'];
            $RawMaterial->product_id = $product['product_id'];
            $RawMaterial->uom_id = $product['uom_id'];
            $RawMaterial->vr_no = $purchaseData['invoice_no'];
            $RawMaterial->date = $purchaseData['date'];
            $RawMaterial->biller = Auth::User()->id;
            $RawMaterial->cost_amount = $product['balance'];
            $RawMaterial->stockin = $product['quantity'];
            $RawMaterial->save();


            $stock = new StockRegisterSpecificItem();
            $stock->stock_transferID = $purchaseData['id'];
            $stock->date = $purchaseData['date'];
            // $stock->party_id = $product['party_id'];
            $stock->product_id = $product['product_id'];
            $stock->recipe_id = $product['product_id'];
            $stock->voucher_type = "Stock Transfer";
            $stock->warehouse_id = $purchaseData['to_warehouse_id'];
            $stock->uom_id = $product['uom_id'];
            $stock->sale_quantity = $product['quantity'];
            $stock->cost_rate = $product['balance'];
            $stock->save();
        }

        return $purchaseData['id'];
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $delete = StockTransfer::findOrFail($id);
        $delete->delete();
        StockTransferDetails::where('transfer_id', '=', $id)->delete();
        ProductionStock::where('pro_transfer_id', '=', $id)->delete();
        SalePointStock::where('pro_transfer_id', '=', $id)->delete();
        // Ledger::where('sale_id', '=', $id)->delete();       
        return "Stock Transfer has been Deleted Successfully!";
    }

    public function print_transfer($id)
    {
        $newsale_detail = StockTransfer::with(['stock_transfer_details' => function ($query) {
            $query->with('uoms');
            $query->with(['products' => function ($query) {
            }]);
        }])->with('warehouse_from')->with('warehouse_to')->with('billers')
            ->where('stock_transfers.id', '=', $id)
            ->get();

        $logo = SystemLogo::where('id', '=', 1)->get();
        $company_detail = Setting::where('id', '=', 1)->get();
        return view('stock-transfer.print-new', Compact('newsale_detail', 'company_detail', 'ledgers', 'logo', 'ledgers'));
    }
}
