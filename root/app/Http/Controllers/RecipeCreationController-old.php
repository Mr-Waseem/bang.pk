<?php

namespace App\Http\Controllers;

use App\Models\Catagory;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Setting;
use App\Models\UOM;
use App\Models\Warehouse;
use App\Models\Production;
use App\Models\Recipe;
use App\Models\RecipeCreation;
use App\Models\RecipeCreationDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RecipeCreationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $sales = RecipeCreation::OrderBy('id', 'dsc')->with(['recipe_details' => function ($query) {
            //$query->with('products');
            // $query->with('discount');
            // $query->with('parties');
        }])->with('recipes')->with('billers')->get();
        //return $sales;

        $products = Product::OrderBy('product_name', 'asc')->pluck('product_name', 'id')->toArray();

        $uoms = UOM::OrderBy('uom', 'asc')->pluck('uom', 'id')->toArray();
        return view('recipe-creation.index', Compact('sales', 'products', 'uoms'));
    }

    public function showProductCode(Request $request)
    {
        $ProductID = $request->get('production_id');
        $data = Product::where('id', '=', $ProductID)->get();
        return $data;
    }

    public function ProductChange(Request $request)
    {
        $recipeID = $request->get('recID');
        $recipe = Recipe::where('id', '=', $recipeID)->get(['recipes.*']);
        return $recipe;
    }

    public function ProductChangeName(Request $request)
    {
        $productID = $request->get('prodID');
        //return $productID;
        $data = Product::where('id', '=', $productID)->get();
        // $test = PurchaseDetail::with('products')->where('product_id', '=', $productID)->get()->last();
        //$data[] = $test;
        return $data;
    }

    public function create()
    {
        $code = RecipeCreation::OrderBy('id', 'asc')->get();
        $codes = (int)$code->last()->vr_no + 1;
        //return $codes;
        $products = Product::select(DB::raw('CONCAT(`id`, "_", `product_code`, "_", `product_name`) AS `id`, `product_code`, `product_name`'))->OrderBy('id', 'asc')->pluck('product_name', 'id')->prepend('Select Product', '')->toArray();

        $uomss = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))->OrderBy('id', 'asc')->pluck('uom', 'id')->toArray();

        $uoms = UOM::pluck('uom', 'id')->toArray();
        $recipe = Product::where('company_id', session()->get('company_id'))->where('catagory_id', 8)->select(DB::raw('CONCAT(`id`, "_", `product_code`, "_", `product_name`) AS `id`, `product_code`, `product_name`'))->OrderBy('id', 'asc')->pluck('product_name', 'id')->prepend('Select Recipe', '')->toArray();
        //return $recipe;
        //return $uoms;
        $warehouse = Warehouse::OrderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        //return $products;
        return view('recipe-creation.create', Compact('products', 'codes', 'encrypted_token', 'uoms', 'warehouse', 'uomss', 'recipe'));
    }

    public function LoadVoucher(Request $request)
    {
        $recipeID = $request->get('recID');
        $recipe = RecipeCreation::where('recipe_id', '=', $recipeID)->get();
        if (count($recipe) == 0) {
            $code = RecipeCreation::OrderBy('id', 'desc')->first();
            $recipe[0] = new RecipeCreation([
                'vr_no' => $code['vr_no'] + 1
            ]);
        }
        return $recipe;
    }

    public function store(Request $request)
    {
        $values = 1;
        $voucher = $request->get('vr_no');
        //return $voucher;
        $data = RecipeCreation::where('vr_no', '=', $voucher)->get();

        //return $data;
        if (count($data) > 0) {
            //return "up";
            $recipe = RecipeCreation::findOrFail($data[0]->id);
            $recipe->update($request->all());
        } else {
            //return "below";
            $recipe = RecipeCreation::create($request->all());
        }
        //$recipe = RecipeCreation::create($request->all());
        //return $recipe;
        $productCode = $request->get('recipe_code');
        $RecipeID = $request->get('recipe_id');
        $TotalAmount = $request->get('TotalAmount');

        $data = Product::where('id', '=', $RecipeID)->first();
        $data->has_recipe = 1;
        $data->product_cost =  $TotalAmount;
        $data->save();


        RecipeCreationDetails::where('recipecreation_id', '=', $recipe['id'])->delete();
        $count = Count($request->product_id);
        //return $ProductID; 
        for ($i = 0; $i < $count; $i++) {
            $detail = new RecipeCreationDetails();
            $detail->recipecreation_id = $recipe['id'];
            $detail->recipe_id = $recipe['recipe_id'];
            $detail->product_id = $request->product_id[$i];
            $detail->product_code = $productCode;
            $detail->uom_id = $request->uom_id[$i];
            $detail->quantity = $request->quantity[$i];
            $detail->rate = $request->rate[$i];
            $detail->amount = $request->amount[$i];
            $detail->save();
        }

        Session::flash('flash_message', 'Record successfully added!');
        return redirect('recipe-creation/create');
    }

    public function show($id)
    {
        $newsale_detail  = RecipeCreation::OrderBy('id', 'dsc')->with(['recipe_details' => function ($query) {
            $query->with('products');
            // $query->with('discount');
            // $query->with('parties');
        }])
            ->with('recipes')->with('billers')
            ->where('id', '=', $id)
            ->get();
        //return $newsale_detail;
        $company_detail = Setting::where('id', '=', 1)->get();
        return view('recipe-creation.print', Compact('newsale_detail', 'company_detail'));
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
        $delete = RecipeCreation::findOrFail($id);
        $delete->delete();
        RecipeCreationDetails::where('recipecreation_id', '=', $id)->delete();
        //StockRegisterSpecificItem::where('production_id', '=', $id)->delete();       
        return "Recipe has been Deleted Successfully!";
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
}
