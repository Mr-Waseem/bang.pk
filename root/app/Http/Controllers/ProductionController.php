<?php

namespace App\Http\Controllers;

use App\Models\UOM;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Catagory;
use App\Models\Warehouse;
use App\Models\Production;
use Illuminate\Http\Request;
use App\Models\ProductionStock;
use App\Models\WorkingProgress;
use App\Models\RawMaterialStock;
use App\Models\ProductionDetails;
use Illuminate\Support\Facades\DB;
use App\Models\RecipeCreationDetails;
use Illuminate\Support\Facades\Session;
use App\Models\StockRegisterSpecificItem;

class ProductionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $sales = Production::OrderBy('id', 'desc')->with(['production_details' => function ($query) {
            //$query->with('products');
            // $query->with('discount');
            // $query->with('parties');
        }])->with('products')->with('uoms')->with('billers')->get();
        //return $sales;

        $products = Product::OrderBy('product_name', 'asc')->pluck('product_name', 'id')->toArray();

        $uoms = UOM::OrderBy('uom', 'asc')->pluck('uom', 'id')->toArray();
        return view('production.index', Compact('sales', 'products', 'uoms'));
    }



    public function showProductCode(Request $request)
    {
        $ProductID = $request->get('production_id');
        $data = Product::where('id', '=', $ProductID)->get();
        return $data;
    }

    public function create()
    {
        // $code = Production::OrderBy('id', 'asc')->get();
        // $codes = (int)$code->last()->vr_no + 1;

        $code = Production::where('company_id', session()->get('company_id'))->latest()->get();
        //return $code;
        if (count($code) > 0) {
            $codes = (int)$code[0]->vr_no + 1;
        } else {
            $codes = 1;
        }
        //return $codes;
        $products = Product:: //where('has_recipe', '=', 1)->
            where('catagory_id', 8)->where('company_id', session()->get('company_id'))->select(DB::raw('CONCAT(`id`, "_", `product_code`, "_", `product_cost`, "_", `product_name`, "_", `uom`) AS `id`, `product_code`, `product_cost`, "_", `product_name`, "_", `uom`'))->OrderBy('id', 'asc')->pluck('product_name', 'id')->prepend('Select Product', '')->toArray();

        $Rawproducts = Product:: //where('has_recipe', '=', 1)->
            where('catagory_id', 5)->where('company_id', session()->get('company_id'))->select(DB::raw('CONCAT(`id`, "_", `product_code`, "_", `product_cost`, "_", `product_name`) AS `id`, `product_code`, `product_cost`, "_", `product_name`'))->OrderBy('id', 'asc')->pluck('product_name', 'id')->prepend('Select Product', '')->toArray();
        //return $Rawproducts;
        $uomss = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))->OrderBy('id', 'asc')->pluck('uom', 'id')->toArray();

        $uoms = UOM::pluck('uom', 'id')->toArray();
        //return $uoms;
        $warehouse = Warehouse::OrderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        //return $products;
        return view('production.create-searchable', Compact('products', 'codes', 'encrypted_token', 'uoms', 'warehouse', 'uomss', 'Rawproducts'));
    }

    public function RecipePrint()
    {
        $code = Production::OrderBy('id', 'asc')->get();
        $codes = (int)$code->last()->vr_no + 1;
        //return $codes;
        $products = Product::where('has_recipe', '=', 1)->select(DB::raw('CONCAT(`id`, "_", `product_code`, "_", `product_cost`, "_", `product_name`) AS `id`, `product_code`, `product_cost`, "_", `product_name`'))->OrderBy('id', 'asc')->pluck('product_name', 'id')->prepend('Select Recipe', '')->toArray();

        $uomss = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))->OrderBy('id', 'asc')->pluck('uom', 'id')->toArray();

        $uoms = UOM::pluck('uom', 'id')->toArray();
        //return $uoms;
        $warehouse = Warehouse::OrderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        //return $products;
        return view('production.print-recipe', Compact('products', 'codes', 'encrypted_token', 'uoms', 'warehouse', 'uomss'));
    }

    public function PrintOnly()
    {
        $code = Production::OrderBy('id', 'asc')->get();
        $codes = (int)$code->last()->vr_no + 1;
        //return $codes;
        $products = Product::where('has_recipe', '=', 1)->select(DB::raw('CONCAT(`id`, "_", `product_code`, "_", `product_cost`, "_", `product_name`) AS `id`, `product_code`, `product_cost`, "_", `product_name`'))->OrderBy('id', 'asc')->pluck('product_name', 'id')->prepend('Select Product', '')->toArray();

        $uomss = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))->OrderBy('id', 'asc')->pluck('uom', 'id')->toArray();

        $uoms = UOM::pluck('uom', 'id')->toArray();
        //return $uoms;
        $warehouse = Warehouse::OrderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        //return $products;
        return view('production.print-only', Compact('products', 'codes', 'encrypted_token', 'uoms', 'warehouse', 'uomss'));
    }

    public function store(Request $request)
    {
        //return $request->all();
        $quotation = Production::create($request->all());
        //return $quotation;
        $count = Count($request->product_id);
        //return $count; 
        for ($i = 0; $i < $count; $i++) {
            $detail = new ProductionDetails();
            $detail->production_id = $quotation['id'];
            $detail->company_id = $quotation['company_id'];
            $detail->product_id = $request->product_id[$i];
            $detail->uom_id = $request->uom_id[$i];
            $detail->quantity = $request->quantity[$i];
            $detail->rate = $request->rate[$i];
            $detail->amount = $request->amount[$i];
            $detail->save();

            // $stock = new StockRegisterSpecificItem();
            // $stock->production_id = $quotation['id'];
            // $stock->date = $quotation['date'];
            // $stock->product_id = $request->product_id[$i];
            // $stock->recipe_id = $quotation['products_id'];
            // $stock->voucher_type = "Production StockOut";
            // $stock->warehouse_id = "1";
            // $stock->uom_id = $request->uom_id[$i];
            // $stock->sale_quantity = $request->quantity[$i];
            // $stock->cost_rate = $request->amount[$i];
            // $stock->save();

            $StockProduct = Product::where('id', '=', $request->product_id[$i])->get();
            // return $StockProduct;
            if (($StockProduct[0]->has_recipe) == 1) {

                // $RawMaterial = new RawMaterialStock();
                // $RawMaterial = new ProductionStock();
                // $RawMaterial->warehouse_id = 1;
                // $RawMaterial->production_id = $quotation['id'];
                // $RawMaterial->product_id = $request->product_id[$i];
                // $RawMaterial->uom_id = $request->uom_id[$i];
                // $RawMaterial->date = $quotation['date'];
                // $RawMaterial->voucher_no = $quotation['vr_no'];
                // $RawMaterial->cost_amount = $request->rate[$i];
                // $RawMaterial->stockout = $request->quantity[$i];
                // $RawMaterial->save();
            }

            if ($StockProduct[0]->has_recipe == "0") {

                $RawMaterial = new RawMaterialStock();
                $RawMaterial->warehouse_id = 1;
                $RawMaterial->transction_id = $quotation['id'];
                $RawMaterial->type = "PRODUCTION";
                $RawMaterial->product_id = $request->product_id[$i];
                $RawMaterial->uom_id = $request->uom_id[$i];
                $RawMaterial->date = $quotation['date'];
                $RawMaterial->voucher_no = $quotation['vr_no'];
                $RawMaterial->cost_amount = $request->rate[$i];
                $RawMaterial->stockout = $request->quantity[$i];
                $RawMaterial->company_id = $quotation['company_id'];
                $RawMaterial->save();

                $RawMaterial = new RawMaterialStock();
                $RawMaterial->warehouse_id = 1;
                $RawMaterial->transction_id = $quotation['id'];
                $RawMaterial->type = "PRODUCTION";
                $RawMaterial->product_id = $quotation['products_id'];
                $RawMaterial->uom_id = $quotation['uoms_id'];
                $RawMaterial->date = $quotation['date'];
                $RawMaterial->voucher_no = $quotation['vr_no'];
                $RawMaterial->cost_amount = $quotation['rates'];
                $RawMaterial->stockin = $quotation['quantitys'];
                $RawMaterial->company_id = $quotation['company_id'];
                $RawMaterial->save();
            }
        }
        $data = Product::where('id', '=', $quotation['products_id'])->first();
        $data->product_cost = $quotation['rates'];
        $data->save();
        $RawMaterial = new ProductionStock();
        $RawMaterial->warehouse_id = 1;
        $RawMaterial->production_id = $quotation['id'];
        $RawMaterial->company_id = $quotation['company_id'];
        $RawMaterial->product_id = $quotation['products_id'];
        $RawMaterial->uom_id = $quotation['uoms_id'];
        $RawMaterial->date = $quotation['date'];
        $RawMaterial->voucher_no = $quotation['vr_no'];
        $RawMaterial->cost_amount = $quotation['amounts'];
        $RawMaterial->stockin = $quotation['quantitys'];
        $RawMaterial->save();
        ///stockissue
        $stockIssue = new WorkingProgress();
        // $stockIssue->stock_issue_id = $purchaseData['id'];
        $stockIssue->warehouse_id = 1;
        $stockIssue->product_id = $quotation['products_id'];
        $stockIssue->company_name = session()->get('company_name');
        $stockIssue->account_id = $quotation['company_id'];
        $stockIssue->uom_id = $quotation['uoms_id'];
        $stockIssue->date = $quotation['date'];
        $stockIssue->voucher_no = $quotation['vr_no'];
        $stockIssue->rate = $quotation['amounts'];
        $stockIssue->cost_amount = $quotation['amounts'];
        $stockIssue->stockout = $quotation['quantitys'];
        $stockIssue->save();
        Session::flash('flash_message', 'Record successfully added!');
        return redirect('production/create');
    }

    public function show($id)
    {
        $newsale_detail  = Production::OrderBy('id', 'desc')->with('uoms')->with(['production_details' => function ($query) {
            $query->with('products_out');
            $query->with('uom_pro_details');
            // $query->with('discount');
            // $query->with('parties');
        }])
            ->with('products')->with('billers')
            ->where('id', '=', $id)
            ->get();
        //return $newsale_detail;
        $company_detail = Setting::where('id', '=', 1)->get();
        return view('production.print', Compact('newsale_detail', 'company_detail'));
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
        $delete = Production::findOrFail($id);
        $delete->delete();
        ProductionDetails::where('production_id', '=', $id)->delete();
        // StockRegisterSpecificItem::where('production_id', '=', $id)->delete();
        RawMaterialStock::where('production_id', '=', $id)->delete();
        ProductionStock::where('production_id', '=', $id)->delete();
        // Ledger::where('sale_id', '=', $id)->delete();       
        return "Production has been Deleted Successfully!";
    }

    public function editProducts(Request $request)
    {
        $output = "";
        $ProductId = $request->get('production_id');
        //return $ProductId;
        $purchase = Production::with(['production_details' => function ($query) {
            // $query->with('destinations');
        }])->OrderBy('products.id', 'desc')->with('products')->with('uoms')->with('billers')->where('id', '=', $ProductId)->get();
        return $purchase;
        $catagories = Catagory::OrderBy('id', 'asc')->pluck('catagory_name', 'id');
        //return $catagories;

        if ($purchase) {
            foreach ($purchase[0]->products_details as $key => $overallstocke) {
                $output .= '<tr>' .
                    '<td style="padding-top:20px;"><input id="trackingNo" name="trackingNo[]" value="' . $overallstocke->trackingNo . '" type="text" class="form-control" style="margin-left: 7%; width: 53%;"></td>' .
                    '<td style="padding-top:20px;"><input id="sender" name="sender[]" value="' . $overallstocke->sender . '" type="text" class="form-control" style="margin-left: -26%;width: 106%;"></td>' .

                    '<td style="padding-top:20px;"><input id="delivery" name="delivery[]" value="' . $overallstocke->delivery . '" type="text" class="form-control" style="margin-left: -7%;width: 107%;"></td>' .

                    // '<td style="padding-top:20px; display:none;"><input id="destination_id" name="destination_id[]" value="'.$overallstocke->destination_id.'" type="text" class="form-control"></td>'.

                    '<td style="padding-top:20px;">
            <select id="destination_id" name="destination_id[]" class="form-control" style="margin-left: 13%;width: 107%;">' .

                    '<option value="' . $overallstocke->destination_id . '">' . $overallstocke->destinations->catagory_name . '</option>' .

                    '</select>
            </td>' .

                    // '<td style="padding-top:20px;"><input id="destination" name="destination[]" value="'.$overallstocke->destinations->catagory_name.'" type="text" class="form-control" style="margin-left: 13%;width: 107%;"></td>'.

                    '<td style="padding-top:20px;"><input id="weight" name="weight[]" value="' . $overallstocke->weight . '" type="text" class="form-control" style="margin-left: 33%;width: 53%;"></td>' .

                    '<td style="padding-top:20px;"><input id="pieces" name="pieces[]" value="' . $overallstocke->pieces . '" type="text" class="form-control" style="width: 53%;"></td>' .
                    '<td style="padding-top: 20px;"><button class="btn btn-red" type="button" style="margin-left: -195%;"> <i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-trash" title="Delete Row"></i></button></td>' .
                    '</tr></br>';
            }
            //echo $output;
            return response()->json($output);
        }
    }

    public function ProductChange(Request $request)
    {
        $productID = $request->get('prodID');
        // $test = Product::where('id', '=', $productID)->get(['products.*']);
        // $data = RecipeCreation::with('recipes')->with(['recipe_details' => function($query){
        //     $query->with('products');
        // }])
        // ->where('recipe_id', '=', $productID)->get();
        $data = RecipeCreationDetails::with('products')
            ->where('recipe_id', '=', $productID)
            ->OrderBy('id', 'asc')
            ->get();
        return $data;
    }

    public function ProductChangePrint(Request $request)
    {
        $productID = $request->get('prodID');
        // $test = Product::where('id', '=', $productID)->get(['products.*']);
        // $data = RecipeCreation::with('recipes')->with(['recipe_details' => function($query){
        //     $query->with('products');
        // }])
        // ->where('recipe_id', '=', $productID)->get();
        $data = RecipeCreationDetails::with(['products' => function ($query) {
            // $query->with(['rawmaterial_stock' => function($query){
            //     $query->sum('stockin');
            // }]);
            $query->with('rawmaterial_stock');
        }])
            ->where('recipe_id', '=', $productID)
            ->OrderBy('id', 'asc')
            ->get();

        return $data;
    }
}