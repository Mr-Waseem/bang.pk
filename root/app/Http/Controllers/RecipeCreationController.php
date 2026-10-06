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
        $sales = RecipeCreation::where('company_id', session()->get('company_id'))->OrderBy('id', 'desc')
            ->with(['recipe_details' => function ($query) {
            }])->with('recipes')->with('billers')->get();

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
        $data = Product::where('id', '=', $productID)->get();
        return $data;
        
    }

    public function create()
    {
        $code = RecipeCreation::where('company_id', session()->get('company_id'))->Orderby('id', 'desc')->first();
        //return $code;
        $codes=1;
        if(isset($code)>0)
        {
            $codes = (int)$code->vr_no + 1;
        }

        $products = Product::where('company_id', session()->get('company_id'))->where('catagory_id', 5)->select(DB::raw('CONCAT(`id`, "_", `product_code`, "_", `product_name`) AS `id`, `product_code`, `product_name`'))->OrderBy('product_name', 'asc')->pluck('product_name', 'id')->prepend('Select Product', '')->toArray();
        $uomss = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))->OrderBy('id', 'asc')->pluck('uom', 'id')->toArray();
        $uoms = UOM::pluck('uom', 'id')->toArray();
        $recipe = Product::where('company_id', session()->get('company_id'))->where('catagory_id', 8)->select(DB::raw('CONCAT(`id`, "_", `product_code`, "_", `product_name`) AS `id`, `product_code`, `product_name`'))->OrderBy('id', 'asc')->pluck('product_name', 'id')->prepend('Select Recipe', '')->toArray();
        $warehouse = Warehouse::OrderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('recipe-creation.create', Compact('products', 'codes', 'encrypted_token', 'uoms', 'warehouse', 'uomss', 'recipe'));
    }

    public function LoadVoucher(Request $request)
    {
        $recipeID = $request->get('recID');
       
        $recipe = RecipeCreation::where('company_id', session()->get('company_id'))->where('recipe_id', '=', $recipeID)->get();
        //return $recipe;
        if (count($recipe) == 0) {
            
            $code = RecipeCreation::where('company_id', session()->get('company_id'))->latest()->first();
            return $code;
            $recipe[0] = new RecipeCreation([
                'vr_no' => $code['vr_no'] + 1
            ]);

        }
        return $recipe;
    }

    public function store(Request $request)
    {
        //return $request;

        $this->validate($request, [
            'product_id' => 'required',
            'quantity' => 'required',
            'price_per_unit' => 'required',
        ]
    ,[
        'product_id.required' => 'Product Name is required',
        'price_per_unit.required' => 'Rate is required'
    ]
    );
        $values = 1;
        $voucher = $request->get('vr_no');
        $data = RecipeCreation::where('company_id', session()->get('company_id'))->where('vr_no', '=', $voucher)->get();

        if (count($data) > 0) {
            $recipe = RecipeCreation::findOrFail($data[0]->id);
            $recipe->update($request->all());
        } else {
            $recipe = RecipeCreation::create($request->all());
        }

        $productCode = $request->get('recipe_code');
        $RecipeID = $request->get('recipe_id');
        $TotalAmount = $request->get('TotalAmount');

        $data = Product::where('id', '=', $RecipeID)->first();
        $data->has_recipe = 1;
        $data->product_cost =  $TotalAmount;
        $data->save();


        RecipeCreationDetails::where('company_id', session()->get('company_id'))->where('recipecreation_id', '=', $recipe['id'])->delete();
        $count = count($request->product_id);
        for ($i = 0; $i < $count; $i++) {
            $detail = new RecipeCreationDetails();
            $detail->recipecreation_id = $recipe['id'];
            $detail->company_id = $recipe['company_id'];
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
        $newsale_detail  = RecipeCreation::OrderBy('id', 'desc')->with(['recipe_details' => function ($query) {
            $query->with('products');
        }])
            ->with('recipes')->with('billers')
            ->where('id', '=', $id)
            ->get();
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
        RecipeCreationDetails::where('company_id', session()->get('company_id'))->where('recipecreation_id', '=', $id)->delete();
        return "Recipe has been Deleted Successfully!";
    }

    public function editProducts(Request $request)
    {
        $output = "";
        $ProductId = $request->get('production_id');
        $purchase = Production::with(['production_details' => function ($query) {
        }])
            ->OrderBy('products.id', 'desc')
            ->with('products')->with('uoms')
            ->with('billers')
            ->where('id', '=', $ProductId)
            ->get();
        return $purchase;
        $catagories = Catagory::OrderBy('id', 'asc')->pluck('catagory_name', 'id');

        if ($purchase) {
            foreach ($purchase[0]->products_details as $key => $overallstocke) {
                $output .= '<tr>' .
                    '<td style="padding-top:20px;"><input id="trackingNo" name="trackingNo[]" value="' . $overallstocke->trackingNo . '" type="text" class="form-control" style="margin-left: 7%; width: 53%;"></td>' .
                    '<td style="padding-top:20px;"><input id="sender" name="sender[]" value="' . $overallstocke->sender . '" type="text" class="form-control" style="margin-left: -26%;width: 106%;"></td>' .

                    '<td style="padding-top:20px;"><input id="delivery" name="delivery[]" value="' . $overallstocke->delivery . '" type="text" class="form-control" style="margin-left: -7%;width: 107%;"></td>' .

                    '<td style="padding-top:20px;">
            <select id="destination_id" name="destination_id[]" class="form-control" style="margin-left: 13%;width: 107%;">' .

                    '<option value="' . $overallstocke->destination_id . '">' . $overallstocke->destinations->catagory_name . '</option>' .

                    '</select>
            </td>' .

                    '<td style="padding-top:20px;"><input id="weight" name="weight[]" value="' . $overallstocke->weight . '" type="text" class="form-control" style="margin-left: 33%;width: 53%;"></td>' .

                    '<td style="padding-top:20px;"><input id="pieces" name="pieces[]" value="' . $overallstocke->pieces . '" type="text" class="form-control" style="width: 53%;"></td>' .
                    '<td style="padding-top: 20px;"><button class="btn btn-red" type="button" style="margin-left: -195%;"> <i onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" class="icon-trash" title="Delete Row"></i></button></td>' .
                    '</tr></br>';
            }

            return response()->json($output);
        }
    }
}
