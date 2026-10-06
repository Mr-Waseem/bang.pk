<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Catagory;
use App\Models\Publisher;
use App\Models\Setting;
use App\Models\UOM;
use App\Models\Tax;
use App\Models\User;
use App\Models\Companies;
use App\Models\HScodes;
use App\Models\SaleTaxDetails;
use App\Models\PurchaseTaxDetails;
use App\Models\SaleDetail;
use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\Session;
use PDF;
use Auth;
use App\Imports\ProductImport;
use Excel;
use DB;

class ProductController extends Controller
{
  private function getSystemType(): string
  {
    $company = Companies::where('id', session()->get('company_id'))->first('system_type');
    return strtoupper((string)($company->system_type ?? ''));
  }

  private function isServiceTaxAuthority(string $systemType): bool
  {
    return in_array($systemType, ['PRA', 'KPRA', 'SRB'], true);
  }

  private function getServiceUoms()
  {
    UOM::firstOrCreate(['uom' => 'Person']);
    UOM::firstOrCreate(['uom' => 'No Unit']);

    $uoms = UOM::OrderBy('uom', 'asc')->get(['id', 'uom']);
    $mapped = collect();
    foreach ($uoms as $uom) {
      $mapped->put($uom->id . '_' . $uom->uom, $uom->uom);
    }

    return $mapped->prepend('Select Service UOM', '');
  }

  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    
    
    // return session()->get('company_id');
    // if(session()->get('company_id') == 000){
    //   $products = Product::where('company_id', session()->get('company_id'))->get();
    // }
    //Set HS Codes
    // if(session()->get('company_id') == 149){
    //    $products = Product::with('catagories')
    //   ->where('company_id', session()->get('company_id'))
    //   ->OrderBy('id', 'asc')
    //   ->get();
        
    //   foreach($products as $product){
    //     $productCode = is_numeric($product->product_code) ? 
    //         number_format($product->product_code, 4, '.', '') : 
    //         (string) $product->product_code;
    //     $product->product_code = $productCode;
    //     $product->save();
    //   }
    // }
    
    // Check if session has company_id, otherwise use 0
    $companyId = session()->get('company_id') ? session()->get('company_id') : 0;

      $products = Product::with('catagories')
      ->where('company_id', $companyId)
      ->OrderBy('product_code', 'asc')
      ->get();
    $systemType = $this->getSystemType();
    $isServiceTaxAuthority = $this->isServiceTaxAuthority($systemType);
    return view('products.index', compact('products', 'isServiceTaxAuthority', 'systemType'));
  }

  public function create()
  {

  //   $CompanyID = session()->get('company_id');
  //   $sellerCompany = Companies::where('id', $CompanyID)->first();
  //   if($sellerCompany){
  //     $token = "6a2079f8-b91b-3d0b-9271-92e8d33edc9a";
  //   }else{
  //     $token = "6a2079f8-b91b-3d0b-9271-92e8d33edc9a";
  //   }
  //   $curl = curl_init();
  //   curl_setopt_array($curl, [
  //       // CURLOPT_URL => 'https://gw.fbr.gov.pk/pdi/v1/HS_UOM?hs_code=$request->product_code[$i]&annexure_id=3',
  //       CURLOPT_URL => 'https://gw.fbr.gov.pk/pdi/v1/itemdesccode',
  //       CURLOPT_RETURNTRANSFER => true,
  //       CURLOPT_ENCODING => '',
  //       CURLOPT_MAXREDIRS => 10,
  //       CURLOPT_TIMEOUT => 0,
  //       CURLOPT_FOLLOWLOCATION => true,
  //       CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  //       CURLOPT_CUSTOMREQUEST => 'GET',
  //       CURLOPT_HTTPHEADER => [
  //           'Authorization: Bearer "' . $token . '"',
  //           'Cookie: key=value; JSESSIONID=IYFCgbVx4GhV2E-MMPlepV3DlG8b0HU4N_la2DUA.i01-irisdmz56; cookiesession1=678B2A2CB3F1FF7FD24B6E462AB80DD1'
  //       ],
  //   ]);
  //   $response = curl_exec($curl);
  //   $uomData = json_decode($response, true);

  //   // return $uomData;
  //   foreach ($uomData as $data) {
  //     HScodes::create([
  //         'hscode' => $data['hS_CODE'],
  //         'description' => $data['description']
  //     ]);
  // }
  
  // return response()->json(['message' => 'Data saved successfully'], 200);



    $codes = 0;
    //return "d0";
    $code = Product::where('company_id', session()->get('company_id'))
      ->OrderBy('product_code', 'desc')->first();
    if (isset($code) > 0) {
      $codes = $code->product_code + 1;
    } else {
      $codes = 1;
    }
    //return $codes;

    //return $code;
    //  return $party = session()->get('company_type');
    $user = User::where('id', session()->get('company_id'))->get();
    $hscodes = HScodes::OrderBy('hscode', 'asc')->pluck('hscode', 'hscode')->prepend('Choose Code', '');
    if(session()->get('company_type') == "Manufacturer"){
      $catagories = Catagory::where('id', 5)->Orwhere('id', 8)->pluck('catagory_name', 'id');
    }else{
      $catagories = Catagory::where('id', 5)->pluck('catagory_name', 'id');
    }
   
    
    //  return $catagories;
    $tax = Tax::OrderBy('tax_rate', 'asc')->pluck('tax_title', 'tax_rate');
    // $uoms = UOM::OrderBy('id', 'asc')->pluck('uom', 'uom')->prepend('Select Uom', '');
  
    // return $uoms;
    $systemType = $this->getSystemType();
    $isServiceTaxAuthority = $this->isServiceTaxAuthority($systemType);
    if ($systemType === 'POS') {
      $uoms = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))
      ->OrderBy('id', 'asc')
      ->pluck('uom', 'id')
      ->prepend('Select Uom', '');
      return view('products.pos.create', Compact('catagories', 'codes', 'uoms', 'tax', 'hscodes'));
    } elseif ($isServiceTaxAuthority) {
      $uoms = $this->getServiceUoms();
      return view('products.create', compact('catagories', 'codes', 'uoms', 'tax', 'hscodes', 'isServiceTaxAuthority', 'systemType'));
    } else {
      $uoms = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))
      ->where('id', 0)
      ->OrderBy('id', 'asc')
      ->pluck('uom', 'id');
      return view('products.create', compact('catagories', 'codes', 'uoms', 'tax', 'hscodes', 'isServiceTaxAuthority', 'systemType'));
    }
  }

  public function hsCode(Request $request){
    // return $request;

    $CompanyID = session()->get('company_id');
    // $purchase = json_decode($request->get('purchase'), true);
    $sellerCompany = Companies::where('id', $CompanyID)->first();
    if($sellerCompany){
      $token = $sellerCompany['sandbox_token'];
    }else{
      //Any company token for admin
      $token = "6a2079f8-b91b-3d0b-9271-92e8d33edc9a";
    }
    $curl = curl_init();
    curl_setopt_array($curl, [
        // CURLOPT_URL => 'https://gw.fbr.gov.pk/pdi/v1/HS_UOM?hs_code=$request->product_code[$i]&annexure_id=3',
        CURLOPT_URL => 'https://gw.fbr.gov.pk/pdi/v1/HS_UOM?hs_code=' . urlencode($request->hs_code) . '&annexure_id=3',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer "' . $token . '"',
            // 'Content-Type: application/json',
            'Cookie: key=value; JSESSIONID=IYFCgbVx4GhV2E-MMPlepV3DlG8b0HU4N_la2DUA.i01-irisdmz56; cookiesession1=678B2A2CB3F1FF7FD24B6E462AB80DD1'
        ],
    ]);
    $response = curl_exec($curl);
    $uomData = json_decode($response, true);

    return $uomData;
  }

  public function store(Request $request)
  {
    // return $request;
    $rules = [
      'product_code' => 'required',
      'product_name' => 'required',
      'tax' => 'required',
      // 'product_cost' => 'required',
      // 'product_price' => 'required'
    ];
    if ($this->isServiceTaxAuthority($this->getSystemType())) {
      $rules['uoms'] = 'required';
    }
    $this->validate($request, $rules);
    
   
    $data = $request->all();
    if($request->uoms){
        $parts = explode('_', $request->uoms);
        $data['uom_id'] = $parts[0];
        $data['uom'] = $parts[1]; 
    }
 
    // return $data;

    Product::create($data);
    $label = $this->isServiceTaxAuthority($this->getSystemType()) ? 'Service' : 'Product';
    Session::flash('flash_message', $label . ' Added Successfully!');
    return redirect('products/create');
  }

  public function show($id)
  {
    //
  }

  public function edit($id)
  {
    $user = User::where('id', session()->get('company_id'))->get();
    if(session()->get('company_type') == "Manufacturer"){
      $catagories = Catagory::where('id', 5)->Orwhere('id', 8)->pluck('catagory_name', 'id');
    }else{
      $catagories = Catagory::where('id', 5)->pluck('catagory_name', 'id');
    }
    $edit = Product::findOrFail($id);
    // $catagories = Catagory::where('id', 5)->Orwhere('id', 8)->pluck('catagory_name', 'id');
    // $uoms = UOM::OrderBy('id', 'asc')->pluck('uom', 'uom');
    $uoms = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))
            ->OrderBy('id', 'asc')
            ->pluck('uom', 'id');
            // ->prepend('Select Uom', '');
    // Ensure the saved UOM appears in the dropdown options
    if ($edit->uom_id && $edit->uom) {
        $savedUomKey = $edit->uom_id . '_' . $edit->uom;
        if (!$uoms->has($savedUomKey)) {
            $uoms[$savedUomKey] = $edit->uom;
        }
    }
    $tax = Tax::OrderBy('id', 'asc')->pluck('tax_title', 'tax_rate');
    // $publishers = Publisher::OrderBy('name', 'asc')->pluck('name', 'id');
    $systemType = $this->getSystemType();
    $isServiceTaxAuthority = $this->isServiceTaxAuthority($systemType);
    if ($isServiceTaxAuthority) {
      $uoms = $this->getServiceUoms();
    }
    $hscodes = HScodes::OrderBy('hscode', 'asc')->pluck('hscode', 'hscode');
    if($systemType === 'POS'){
      return view('products.pos.edit', Compact('catagories', 'edit', 'uoms', 'tax', 'hscodes'));
    }else{
      return view('products.edit', compact('catagories', 'edit', 'uoms', 'tax', 'hscodes', 'isServiceTaxAuthority', 'systemType'));
    }

    // return view('products.edit', Compact('edit', 'catagories', 'uoms', 'tax'));
  }

  public function update(Request $request, $id)
  {
    // return $request;
    $this->validate($request, [
      'product_code' => 'required',
      'product_name' => 'required',
      'uom' => 'required',
      //'product_english' => 'required',
      'tax' => 'required', //,
      // 'product_cost' => 'required',
      // 'product_price' => 'required'
    ]);
    $update = Product::findOrFail($id);
  
    
    $data = $request->all();
    if($request->uoms){
      $parts = explode('_', $request->uoms);
      $data['uom_id'] = $parts[0];
      $data['uom'] = $parts[1];
    }
    // return $data;
    $update->update($data);

    // Product::create($data);

    $label = $this->isServiceTaxAuthority($this->getSystemType()) ? 'Service' : 'Product';
    Session::flash('flash_message', $label . ' Updated Successfully!');
    return redirect('products');
  }

  public function destroy($id)
  {
    $isUsedInInvoice = SaleTaxDetails::where('product_id', $id)->exists()
      || PurchaseTaxDetails::where('product_id', $id)->exists()
      || SaleDetail::where('product_id', $id)->exists()
      || PurchaseDetail::where('product_id', $id)->exists();

    if ($isUsedInInvoice) {
      Session::flash('flash_error', "You can't delete this product because it is used in invoice entries.");
      return redirect('products');
    }

    $delete = Product::findOrFail($id);
    $delete->delete();
    Session::flash('flash_message', 'Product deleted Successfully!');
    return redirect('products');
    return "Prduct Deleted Successfully!";
  }

  public function stockAlert()
  {
    $products = Product::with('catagories')
      ->where('company_id', session()->get('company_id'))
      ->OrderBy('product_name', 'asc')->get();
    //return $products;
    return view('products.alertstock', Compact('products'));
  }

  public function print_books()
  {
    // return "dfd";
    $products = Product::with('catagories')
      ->where('company_id', session()->get('company_id'))
      ->OrderBy('id', 'asc')
      ->get();

    $company_detail = Setting::where('id', '=', 1)->get();
    return view('products.print', Compact('products', 'company_detail'));
  }

  public function getPDF()
  {
    $products = Product::with(['publisher_detail'])
      ->with(['products_detail'])
      ->with('sale_detail')
      ->where('company_id', session()->get('company_id'))
      ->OrderBy('product_name', 'asc')
      ->get();
    $company_detail = Setting::where('id', '=', 1)->get();
    $pdf = PDF::loadView('products.productspdf', ['products' => $products, 'company_detail' => $company_detail]);
    return $pdf->download('products.pdf');
  }

  public function ImportExcel(Request $request)
  {
    $this->validate($request, [
      'import_file' => 'required'
    ]);

    $path1 = $request->file('import_file')->store('temp'); 
    $path = storage_path('app').'/'.$path1;  
    
    $import = new ProductImport;
    Excel::import($import, $path);
    
    $failures = $import->failures;
    
    if(count($failures) > 0) {
        $errorMessages = [];
        foreach($failures as $failure) {
            $errorMessages[] = "Row {$failure->row()}: " . implode(', ', $failure->errors());
        }
        
        $successCount = \App\Models\Product::where('company_id', session()->get('company_id'))
            ->where('created_at', '>=', now()->subMinutes(1))
            ->count();
        
        if($successCount > 0) {
            return redirect()->back()
                ->with('flash_success', "{$successCount} products imported successfully!")
                ->with('flash_errors', $errorMessages);
        } else {
            return redirect()->back()
                ->with('flash_error', 'Import failed! Please check the errors below.')
                ->with('flash_errors', $errorMessages);
        }
    }
    
    return redirect()->back()->with('flash_message', 'File Imported Successfully!');

    // $path = $request->file('import_file')->getRealPath();
    // $results = Excel::load($path)->get();
    // //return $results;
    // if (!empty($results) && $results->count()) {
    //   foreach ($results as $row) {
    //     //foreach ($rows as $row) {
    //     if (($row->product_name) != null) {
    //       Product::create([
    //         'catagory_id'  => $row->catagory_id,
    //         'product_code'  => $row->product_code,
    //         'product_name'  => $row->product_name,
    //         'uom'  => $row->uom,
    //         'product_cost'  => $row->product_cost,
    //         'product_price'  => $row->product_price,
    //         'alert'  => $row->alert,
    //         'company_id' => session()->get('company_id')
    //       ]);
    //     }
    //     //}
    //   }
    // }

    Session::flash('flash_message', 'Excel Sheet Imported Successfully!');
    return redirect('products/importExcel/create');
  }


  public function createImportExcel()
  {
    return view('products.importExcel.create');
  }

  public function getExcel()
  {
    //$data = Product::with(['publisher_detail'])->with(['products_detail'])->with('sale_detail')->OrderBy('product_name', 'asc')->get(['products.product_code AS Code', 'Product_english AS Book', 'publishers.name AS Publisher', 'products.year', 'products.product_price'])->toArray();
    $data = Product::where('company_id', session()->get('company_id'))
      ->OrderBy('product_name', 'id')
      ->get(['catagory_id',  'products.product_code AS Code', 'product_name', 'products.uom', 'product_cost', 'product_price', 'products.alert'])->toArray();
    return Excel::create('products.importExport', function ($excel) use ($data) {
      $excel->sheet('mySheet', function ($sheet) use ($data) {
        $sheet->fromArray($data);
      });
    })->download();
  }

  public function UpdateName(Request $request)
  {
    $name = json_decode($request->get('name'), true);
    $id = $request->get('product_name');
    $product = Product::findOrFail($id);
    $product->product_name = $name;
    $product->save();
  }

  public function UpdateCode(Request $request)
  {
    $name = json_decode($request->get('code'), true);

    $id = $request->get('product_code');
    //return $id;
    $product = Product::findOrFail($id);
    $product->product_code = $name;
    $product->save();
  }

  public function UpdateCost(Request $request)
  {
    $cost = json_decode($request->get('cost'), true);
    $id = $request->get('product_id');
    $product = Product::findOrFail($id);
    $product->product_cost = $cost;
    $product->save();
  }

  public function UpdatePrice(Request $request)
  {
    // $cost = json_decode(Input::get('cost'), true);
    $price = json_decode($request->get('price'), true);
    //return $cost;
    $id = $request->get('product_id');
    //return $id;
    $product = Product::findOrFail($id);
    $product->product_price = $price;
    $product->save();
    // $product = Product::where('id', '=', $id);
    //return $product;
  }

  public function updateWeight(Request $request)
  {
    $weight = json_decode($request->get('weight'), true);
    //return $cost;
    $id = $request->get('product_id');
    //return $id;
    $product = Product::findOrFail($id);
    $product->pack_weight = $weight;
    $product->save();
  }

  public function updateAlert(Request $request)
  {
    $alert = json_decode($request->get('alertvalue'), true);
    //return $cost;
    $id = $request->get('product_id');
    //return $id;
    $product = Product::findOrFail($id);
    $product->alert = $alert;
    $product->save();
  }
}
