<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\Product;
use App\Models\Tax;
use App\Models\Party;
use App\Models\Discount;
use App\Models\Sales;
use App\Models\SaleDetail;
use App\Models\Setting;
use App\Models\Ledger;
use DB;
class SalesController extends Controller
{
	public function __construct()
	{
	$this->middleware('auth');
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	$sales = Sales::OrderBy('id', 'dsc')->with(['sale_details'=>function($query){
					//$query->with('taxes');
					$query->with('discount');
					$query->with('parties');
					}])->with('billers')->get();
	//return $sales;
	return view('sales.index', Compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function create()
    {
		$products = Product::OrderBy('product_english', 'asc')->pluck('product_english', 'id')->toArray();
		$taxes = Tax::select(DB::raw('CONCAT(`id`, "_", `tax_rate`) AS `tax_rate`, `tax_title`'))->OrderBy('id', 'asc')->pluck('tax_title', 'tax_rate')->toArray();
		$discounts = Discount::select(DB::raw('CONCAT(`id`, "_", `discount`) AS `discount`, `title`'))->OrderBy('id', 'asc')->pluck('title', 'discount')->toArray();
		//$discounts = Discount::OrderBy('id', 'asc')->pluck('title', 'id')->prepend('Select Discount', '0')->toArray();
		$customers = Party::OrderBy('id', 'asc')->pluck('party_name', 'id');
		
		$encrypter = app('Illuminate\Encryption\Encrypter');
		$encrypted_token = $encrypter->encrypt(csrf_token());
		
        return view('sales.create', Compact('customers', 'products', 'taxes', 'discounts', 'encrypted_token'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
       public function store(Request $request)
    {
    	return "elll";
		$purchase = json_decode(Input::get('purchase'), true);
		$purchase['date'] = date('Y-m-d',strtotime($purchase['date']));
		$products = Input::get('product_data');	

		$purchaseData = Sales::create($purchase);
		
		foreach($products as $product)
		{
			$purchaseDetail = new SaleDetail();
			$purchaseDetail->sale_id = $purchaseData['id'];
			$purchaseDetail->product_id = $product['product_id'];
			$purchaseDetail->party_id = $product['party_id'];
			$purchaseDetail->quantity = $product['quantity'];
			$purchaseDetail->discount_id = $product['discount_id'];
			$purchaseDetail->unit_cost = $product['unit_cost'];
			$purchaseDetail->total_cost = $product['total_cost'];
			$purchaseDetail->save();
		}
		//return "inserted";
		return $purchaseData['id'];
		
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$newsale_detail = Sales::with(['sale_details'=>function($query){
								$query->with('products');
								//$query->with('taxes');
								//$query->with('discount');
								$query->with('parties');
								}])->with('billers')
								->where('sales.id', '=', $id)
								->get();
		$company_detail = Setting::where('id', '=', 1)->get();
		//return $newsale_detail;
		return view('sales.details', Compact('newsale_detail', 'company_detail'));
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   public function edit($id)
    {
		$purchase = Sales::with(['sale_details'=>function($query){
									//$query->with('taxes');
							}])->where('sales.id', '=', $id)->get();
		$edit = $purchase[0];
        //return $edit;
		$products = Product::OrderBy('product_name', 'asc')->pluck('product_name', 'id')->prepend('Select Product', '0')->toArray();
		//$taxes = Tax::select(DB::raw('CONCAT(`id`, "_", `tax_rate`) AS `tax_rate`, `tax_title`'))->OrderBy('id', 'asc')->pluck('tax_title', 'tax_rate')->toArray();
		//$discount = Discount::select(DB::raw('CONCAT(`id`, "_", `discount`) AS `discount`, `title`'))->OrderBy('id', 'asc')->pluck('title', 'discount')->toArray();
		//$discount = Discount::select(DB::raw('CONCAT(`id`, "_", `discount`) AS `discount`, `title`'))->OrderBy('title', 'asc')->pluck('title', 'discount')->prepend('Select Discount', '0.00')->toArray();
		//$taxes = Tax::select(DB::raw('CONCAT(`id`, "_", `tax_rate`) AS `tax_rate`, `tax_title`'))->OrderBy('tax_title', 'asc')->pluck('tax_title', 'tax_rate')->prepend('Select Tax', '0.00')->toArray();
		$customer = Party::OrderBy('Party_name', 'asc')->pluck('Party_name', 'id')->prepend('Select Customer', '0')->toArray();
        return view('sales.edit', Compact('edit', 'products', 'customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		$objPurchase = Sales::findOrFail($id);
		$purchase = json_decode(Input::get('purchase'), true);
		$objPurchase->party_id = $purchase['party_id'];
		$objPurchase->reference_no = $purchase['reference_no'];
		$objPurchase->biller = $purchase['biller'];
		//return $objPurchase;
		$objPurchase->date = date('Y-m-d',strtotime($purchase['date']));
		
		$objPurchase->save();

		SaleDetail::where('sale_id', '=', $id)->delete();
		
		$products = Input::get('product_data');		
		
		foreach($products as $product)
		{
			$purchaseDetail = new SaleDetail();
			$purchaseDetail->sale_id = $objPurchase->id;
			$purchaseDetail->product_id = $product['product_id'];
			$purchaseDetail->party_id = $product['party_id'];
			$purchaseDetail->discount_id = $product['discount_id'];
			$purchaseDetail->quantity = $product['quantity'];
			$purchaseDetail->unit_cost = $product['unit_cost'];
			$purchaseDetail->total_cost = $product['total_cost'];
			$purchaseDetail->save();
		}
		return "updated";        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
	
	public function purchase_json()
	{
		$productId = Input::get('purchase_id');
		return "Jallo3";
		$productsArray = Product::where('id', '=', $productId)->get(['products.product_cost AS product_newcost']);
		return $productsArray;
	}
	
	public function unit_price()
	{
		$productId = Input::get('ProductID');
		$productsArray = Product::where('id', '=', $productId)->get();
		return $productsArray;
	}
	
	public function FirstProduct()
	{
	$productId = Input::get('saletab_id');
	$productArray = Product::where('product_code', '=', $productId)->get(['products.*']);
	return $productArray;
	}
	
	public function getProduct()
	{

	$productId = Input::get('code_id');
	//return $productId;
	//$productArray = Product::with('products_detail')->with('sale_detail')->OrderBy('id', 'asc')->where('product_code', '=', $productId)->get();
	$SaleArray = Product::join('sale_details', 'sale_details.product_id', '=', 'products.id')->orderBy('sale_details.id', 'asc')->where('product_code', '=', $productId)->get(['products.id', 'sale_details.*']);
	$PurchaseArray = Product::join('purchase_details', 'purchase_details.product_id', '=', 'products.id')->orderBy('purchase_details.id', 'asc')->where('product_code', '=', $productId)->get(['products.*', 'purchase_details.*']);
	return $PurchaseArray;

	$SaleQuantity = 0;
	$PurchaseQuantity = 0;
	foreach($SaleArray As $SaleArrays){
			$SaleQuantity = $SaleQuantity + $SaleArrays->quantity;		
	}
	return $SaleQuantity; //9

	foreach($PurchaseArray As $PurchaseArrays){
			$PurchaseQuantity = $PurchaseQuantity + $PurchaseArrays->quantity; //5
			return $PurchaseQuantity; //4

			if($SaleQuantity<=$PurchaseQuantity){
			return $PurchaseQuantity;
			}
			if($SaleQuantity>$PurchaseQuantity){
				exit;
				//$PurchaseQuantity = $PurchaseQuantity + $PurchaseArrays->quantity;
			//return $PurchaseQuantity;
			}
	}
	return $SaleQuantity;


	}

	 public function productChange()
    {
        $productName = Input::get('product_name');
        //return $productName;
        $productsArray = Product::where('product_english', '=', $productName)->get(['products.*']);
        return $productsArray;
    }
	
	public function print_sale($id)
    {
		$newsale_detail = Sales::with(['sale_details'=>function($query){
								$query->with(['products'=>function($query){
								$query->with('publishers');
								}]);
								$query->with('taxes');
								$query->with('discount');
								$query->with('ledger');
								//$query->with('publishers');
						}])->with('parties')->with('billers')
						->where('sales.id', '=', $id)
						->get();
		//return $newsale_detail;					
		//$ledgers = Ledger::join('parties', 'parties.id',  'ledgers.party_id')
						  //->where('party_id', '=', 5)->OrderBy('id', 'asc')->get(['ledgers.*', 'parties.party_name as partyname, parties.phone, parties.city']);
		
		//$ledgers = Party::with('ledgers')->get();
		//return $ledgers;
		//return $newsale_detail[0]->parties->id;
		$ledgers = Ledger::with('ledger_party')->where('party_id', '=', $newsale_detail[0]->parties->id)->get();
		//return $ledgers;
		
		$company_detail = Setting::where('id', '=', 1)->get();
		return view('sales.print', Compact('newsale_detail', 'company_detail', 'ledgers'));
	}

}
