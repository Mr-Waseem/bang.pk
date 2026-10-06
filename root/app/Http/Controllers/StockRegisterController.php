<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SaleDetail;
use App\Models\Setting;
use App\Models\StockRegisterSpecificItem;
use App\Models\Warehouse;
use App\Models\RawMaterialStock;
use App\Models\Purchase;
use App\Models\Production;
use App\Models\RawMaterialToSalePoint;
use App\Models\SalePointStock;
use App\Models\Sales;
use App\Models\StockTransfer;
use App\Models\Wastage;
use App\Models\ProductionStock;
use Illuminate\Support\Facades\DB;

class StockRegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $products = Product::OrderBy('product_name', 'asc')->pluck('product_name', 'id')->prepend('Select Item', '')->toArray();
        $warehouse = Warehouse::OrderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('stock-register-specific-item.index', Compact('encrypted_token', 'products', 'warehouse'));
    }

    public function report(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
            'from_date' => 'required',
            'to_date' => 'required'
        ]);
        //return "d";
        $ProductID = $request->get('product_id');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');

        $product = Product::where('id', '=', $ProductID)->get();


        //return $product;
        $items = StockRegisterSpecificItem::join('products', 'products.id', '=', 'stock_register_specific_items.product_id')
            ->join('parties', 'parties.id', '=', 'stock_register_specific_items.party_id')
            ->OrderBy('stock_register_specific_items.id', 'asc')
            ->whereBetween('stock_register_specific_items.date', [$fromDate, $toDate])
            ->where('stock_register_specific_items.product_id', '=', $ProductID)->get();
        //return $items;
        $company_detail = Setting::where('id', '=', 1)->get();
        return view('stock-register-specific-item.report', Compact('items', 'company_detail', 'product'));
    }

    public function reportFifo(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required',
            // 'warehouse_id' => 'required',
            'from_date' => 'required',
            'to_date' => 'required'
        ]);
        $ProductID = $request->get('product_id');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        $WarehouseID = $request->get('warehouse_id');
        $company_detail = Setting::where('id', '=', 1)->get();
        $product = Product::where('id', '=', $ProductID)->get();

        // $items = Product::with(['party' => function($query){
        //                 $query->with('purchase_detail');
        // }])->with(['sale_detail' => function($query){
        //                 $query->with('unit');
        // }])->with(['purchase_return_detail' => function($query){
        //                 $query->with('unit');
        // }])->with(['sale_return_detail' => function($query){
        //                 $query->with('uoms');
        // }])->where('products.id', '=', $productId)->OrderBy('id', 'asc')->get();
        //return $items;
        //    $items = StockRegisterSpecificItem::join('products', 'products.id', '=', 'stock_register_specific_items.product_id')
        // ->join('parties', 'parties.id', '=', 'stock_register_specific_items.party_id')
        // ->OrderBy('stock_register_specific_items.id', 'asc')
        // ->whereBetween('stock_register_specific_items.date', [$fromDate, $toDate])
        // ->where('stock_register_specific_items.product_id', '=', $ProductID)->get(); 
        //    $product = Product::where('id', '=', $productId)->get();

        $StockReport = $request->get('stock_report');
        if ($StockReport == 1) {

            $items = StockRegisterSpecificItem::OrderBy('date', 'asc')->with('recipe_name')->with('parties')->with('products')->with('uoms')->with('shops')
                ->OrderBy('stock_register_specific_items.id', 'asc')
                //->whereBetween('stock_register_specific_items.date', [$fromDate, $toDate])
                ->whereDate('stock_register_specific_items.date', '>=', $fromDate)
                ->whereDate('stock_register_specific_items.date', '<=', $toDate)
                //
                //->where('stock_register_specific_items.warehouse_id', '=', $WarehouseID)
                ->where('stock_register_specific_items.product_id', '=', $ProductID)
                ->get();


            //  $openingStock = StockRegisterSpecificItem::
            // whereDate('date', '>=', '2019-01-01')
            // ->whereDate('date', '<', $fromDate)
            // ->where('product_id', '=', $ProductID)
            //  ->select( DB::raw('SUM(purchase_quantity) as Purchase, SUM(sale_quantity) as Sale'))
            // ->get();

            // $openingStock = RawMaterialStock::where('product_id', '=', $ProductID)
            // ->whereDate('date', '>=', '2019-01-01')
            //     ->whereDate('date', '<', $fromDate)
            //      ->select( DB::raw('SUM(stockin) as Purchase, SUM(stockout) as Sale'))
            // ->get();

            $openingStock = ProductionStock::where('product_id', '=', $ProductID)
                //->select(DB::raw('product_code, product_name, product_cost, sum(cost_amount), sum(stockin) as stockin ,sum(stockout) as stockout'))
                ->select(DB::raw('SUM(stockin) as Purchase, SUM(stockout) as Sale'))
                //->groupBy('product_id')
                //->where('warehouse_id', '=', $warehouse[0]->id)
                ->whereDate('created_at', '>=', '2019-01-01')
                ->whereDate('created_at', '<', $fromDate)
                ->get();
            //return $openingStock;
            //return $items;

            return view('stock-register-specific-item.stock-register-specific-item-fifo', Compact('items', 'company_detail', 'product', 'fromDate', 'toDate', 'openingStock'));
        }


        if ($StockReport == 2) {

            $items = RawMaterialStock::with('uoms')->with('warehouse')->where('product_id', '=', $ProductID)
                ->whereDate('date', '>=', $fromDate)
                ->whereDate('date', '<=', $toDate)
                ->OrderBy('id', 'asc')->get();

            $openingStock = RawMaterialStock::where('product_id', '=', $ProductID)
                ->whereDate('date', '>=', '2019-01-01')
                ->whereDate('date', '<', $fromDate)
                ->select(DB::raw('SUM(stockin) as stockin, SUM(stockout) as stockout'))
                ->OrderBy('date', 'asc')->get();
            //return $openingStock;

            return view('stock-register-specific-item.rawmaterial', Compact('items', 'company_detail', 'product', 'fromDate', 'toDate', 'openingStock'));
        }
    }

    public function updateDate()
    {

        //return "entr";

        $raw = RawMaterialStock::where('sale_id', '!=', null)->OrderBy('id', 'asc')->get();
        return $raw;
        $raw = RawMaterialStock::OrderBy('id', 'asc')->get();
        foreach ($raw as $data) {
            //return $data;
            if ($data->purchase_id != null) {
                $purchase = Purchase::where('id', '=', $data->purchase_id)->get();
                //return $purchase;
                $data->date = $purchase[0]->date;

                $data->save();
                //return $data;
            }

            if ($data->production_id != null) {
                $production = Production::where('id', '=', $data->production_id)->get();
                //return $production;
                $data->date = $production[0]->date;

                $data->save();
                //return $data;
            }

            if ($data->direct_transferID != null) {
                $directTrans = RawMaterialToSalePoint::where('id', '=', $data->direct_transferID)->get();
                //return $production;
                $data->date = $directTrans[0]->date;

                $data->save();
                //return $data;
            }

            if ($data->sale_id != null) {
                $sale = Sales::where('id', '=', $data->sale_id)->get();
                //return $production;
                $data->date = $sale[0]->date;
                $data->save();
            }
        }
    }


    public function updateDateSalePoint()
    {

        //return "entr";

        //$salePoint = SalePointStock::where('sale_id', '!=', null)->OrderBy('id', 'asc')->get();
        // return $salePoint;
        $salePoint = SalePointStock::OrderBy('id', 'asc')->get();
        //return $salePoint;
        foreach ($salePoint as $data) {
            //return $data;
            if ($data->sale_id != null) {
                $sales = Sales::where('id', '=', $data->sale_id)->get();
                //return $purchase;
                $data->vr_no = $sales[0]->invoice_no;
                $data->date = $sales[0]->date;
                $data->biller = $sales[0]->biller;
                $data->save();
                //return $data;
            }

            if ($data->direct_transferID != null) {
                $directTrans = RawMaterialToSalePoint::where('id', '=', $data->direct_transferID)->get();
                //return $production;
                $data->vr_no = $directTrans[0]->invoice_no;
                $data->date = $directTrans[0]->date;
                $data->biller = $directTrans[0]->biller;

                $data->save();
                //return $data;
            }

            if ($data->pro_transfer_id != null) {
                $production = StockTransfer::where('id', '=', $data->pro_transfer_id)->get();
                //return $production;
                $data->vr_no = $production[0]->invoice_no;
                $data->date = $production[0]->date;
                $data->biller = $production[0]->biller;

                $data->save();
                //return $data;
            }



            if ($data->wastage_id != null) {
                $wastage = Wastage::where('id', '=', $data->wastage_id)->get();
                //return $production;
                $data->vr_no = $wastage[0]->invoice_no;
                $data->date = $wastage[0]->date;
                $data->biller = $wastage[0]->biller;
                $data->save();
            }
        }
        return "done";
    }

    public function updateuoms()
    {
        $stock = StockRegisterSpecificItem::all();

        //return $stock;
        foreach ($stock as $stocks) {
            //return $stocks->sale_id;
            $saledetail = SaleDetail::where('sale_id', '=', $stocks->sale_id)->get();
            //return $saledetail;
            if ($stocks->voucher_type == "Sale Bill") {
                $stocks->uom_id = $saledetail[0]->uom_id;
                $stocks->save();
            }
            //$saledetail = SaleDetail::all('');

        }
        return "hel";
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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
        //
    }
}
