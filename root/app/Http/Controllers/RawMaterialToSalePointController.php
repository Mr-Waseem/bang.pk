<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RawMaterialToSalePoint;
use App\Models\RawMaterialToSalePointDetails;
use App\Models\RawMaterialStock;
use App\Models\SalePointStock;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\UOM;
use App\Models\SystemLogo;
use App\Models\Setting;
use App\Models\StockRegisterSpecificItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RawMaterialToSalePointController extends Controller
{
    public function index()
    {
        $sales = RawMaterialToSalePoint::OrderBy('id', 'dsc')->with(['stock_directtransfer_details' => function ($query) {
        }])->with('warehouse_from')->with('warehouse_to')->with('billers')->get();
        //return $sales;
        return view('rawmaterial-to-salepoint.index', Compact('sales'));
    }

    public function create()
    {
        $code = RawMaterialToSalePoint::OrderBy('id', 'asc')->get();
        $codes = (int)$code->last()->invoice_no + 1;

        $products = Product::where('catagory_id', '=', '6')->select(DB::raw('CONCAT(`id`, "_", `product_name`) AS `id`, `product_name`'))->OrderBy('id', 'asc')->pluck('product_name', 'id')->prepend('Select Product', '0')->toArray();


        //return $customers;
        $uoms = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))->OrderBy('id', 'asc')->pluck('uom', 'id')->prepend('KG', '1_KG')->toArray();
        //return $uoms;
        $warehouse = Warehouse::OrderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        //return $products;
        return view('rawmaterial-to-salepoint.create-simple', Compact('products', 'codes', 'encrypted_token', 'uoms', 'warehouse'));
    }

    public function store(Request $request)
    {

        //return "hklk";
        $purchase = json_decode($request->get('purchase'), true);
        $purchase['date'] = date('Y-m-d', strtotime($purchase['date']));
        $products = $request->get('product_data');
        //return $products;
        $purchaseData = RawMaterialToSalePoint::create($purchase);
        // }
        $sum = "0";
        $tot = "0";

        foreach ($products as $product) {
            $purchaseDetail = new RawMaterialToSalePointDetails();
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

            $RawMaterial = new RawMaterialStock();
            $RawMaterial->direct_transferID = $purchaseData['id'];
            $RawMaterial->warehouse_id = $purchaseData['to_warehouse_id'];
            $RawMaterial->product_id = $product['product_id'];
            $RawMaterial->uom_id = $product['uom_id'];
            $RawMaterial->date = $purchaseData['date'];
            $RawMaterial->voucher_no = $purchaseData['invoice_no'];
            $RawMaterial->cost_amount = $product['balance'];
            $RawMaterial->stockout = $product['quantity'];
            $RawMaterial->save();

            $RawMaterial = new SalePointStock();
            $RawMaterial->direct_transferID = $purchaseData['id'];
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
            $stock->direct_transferID = $purchaseData['id'];
            $stock->date = $purchaseData['date'];
            $stock->product_id = $product['product_id'];
            $stock->recipe_id = $product['product_id'];
            $stock->voucher_type = "Stock Direct Transfer";
            $stock->warehouse_id = "1";
            $stock->uom_id = $product['uom_id'];
            $stock->sale_quantity = $product['quantity'];
            $stock->cost_rate = $product['balance'];
            $stock->save();
        }
        return $purchaseData['id'];
    }

    public function show($id)
    {
        $newsale_detail = RawMaterialToSalePoint::with(['stock_directtransfer_details' => function ($query) {
            $query->with('uoms');
            $query->with('products');
        }])->with('warehouse_from')->with('warehouse_to')->with('billers')
            ->where('rawmaterial_to_salepoint.id', '=', $id)
            ->get();

        $logo = SystemLogo::where('id', '=', 1)->get();
        $company_detail = Setting::where('id', '=', 1)->get();
        return view('rawmaterial-to-salepoint.print-new', Compact('newsale_detail', 'company_detail', 'logo'));
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
        $delete = RawMaterialToSalePoint::findOrFail($id);
        $delete->delete();
        RawMaterialToSalePointDetails::where('transfer_id', '=', $id)->delete();
        RawMaterialStock::where('direct_transferID', '=', $id)->delete();
        SalePointStock::where('direct_transferID', '=', $id)->delete();
        //StockRegisterSpecificItem::where('direct_transferID', '=', $id)->delete(); 
        // Ledger::where('sale_id', '=', $id)->delete();       
        return "Production has been Deleted Successfully!";
    }
}
