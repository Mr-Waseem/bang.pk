<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Companies;
use App\Models\Product;
use App\Models\Tax;
use App\Models\Party;
use App\Models\Discount;
use App\Models\Sales;
use App\Models\SaleDetail;
use App\Models\Setting;
use App\Models\DeliveryChallan;
use App\Models\DeliveryChallanDetail;
use App\Models\GeneralVoucher;
use App\Models\StockRegisterSpecificItem;
use App\Models\LedgerDetailWise;
use App\Models\SystemLogo;
use App\Models\UOM;
use App\Models\Warehouse;
use App\Models\SalePointStock;
use App\Models\CashBook;
use App\Models\ProductRateDetails;
use App\Models\RawMaterialStock;
use App\Models\ProductionStock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PDF;
use PDFMerger;

class SalesController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
	 $sales = Sales::OrderBy('id', 'desc')->with(['sale_details' => function ($query) {
			//$query->with('taxes');
			$query->with('discount');
			$query->with('parties');
		}])->with('billers')
			->where('company_id', session()->get('company_id'))
			->get();
		//return $sales;
		return view('sales.index', compact('sales'));
	}

	public function create()
	{
		$codes = 0;
		$code = Sales::OrderBy('id', 'desc')->where('company_id', session()->get('company_id'))->first();
		//return $code;
		//$codes = (int)$code->last()->invoice_no + 1;
		if (isset($code) > 0) {
			$codes = (int)$code->invoice_no + 1;
		} else {
			$codes = 1;
		}
		//return $codes;
		$DeliveryChallan = DeliveryChallan::where('status', '=', 'Pending')->OrderBy('vr_no', 'asc')->pluck('vr_no', 'vr_no')->prepend('Select Challan', '0')->toArray();
		// return $DeliveryChallan;
		$products = Product:: //where('catagory_id', '=', '6')->
			select(DB::raw('CONCAT(`id`, "_", `product_name`) AS `id`, `product_name`'))
			->OrderBy('id', 'asc')
			->where('company_id', session()->get('company_id'))
			->pluck('product_name', 'id')
			->prepend('Select Product', '0')
			->toArray();
		//return $products;
		$taxes = Tax::select(DB::raw('CONCAT(`id`, "_", `tax_rate`) AS `tax_rate`, `tax_title`'))->OrderBy('id', 'asc')->pluck('tax_title', 'tax_rate')->toArray();
		$discounts = Discount::select(DB::raw('CONCAT(`id`, "_", `discount`) AS `discount`, `title`'))->OrderBy('id', 'asc')->pluck('title', 'discount')->toArray();
		//$discounts = Discount::OrderBy('id', 'asc')->pluck('title', 'id')->prepend('Select Discount', '0')->toArray();
		$shop = Auth::User()->shop_id;
		$customers = Party::join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
			// ->where('parties.shop_id', '=', $shop)
			->where('parties.account_group_id', '=', 1)
			->where('parties.party_name', '!=', 'CASH IN HAND')
			// ->Orwhere('parties.account_group_id', '=', '7')
			->where('parties.company_id', session()->get('company_id'))
			->OrderBy('party_name', 'asc')->pluck('party_name', 'parties.id')->prepend('Select Customer', '');
		$warehouse = Warehouse::OrderBy('id', 'asc')->pluck('name', 'id');
		$encrypter = app('Illuminate\Encryption\Encrypter');
		$encrypted_token = $encrypter->encrypt(csrf_token());
		return view('sales.create', compact('customers', 'products', 'codes', 'taxes', 'discounts', 'DeliveryChallan', 'encrypted_token', 'warehouse'));
	}

	public function store(Request $request)
	{
		// $this->validate($request, [
        //     'product_id' => 'required'
        //  ]);
		$purchase = json_decode($request->get('purchase'), true);
		// return $purchase;
		//$purchase['date'] = date('Y-m-d', strtotime($request->input('date')));
		$products = $request->get('product_data');
		
		// if (!isset($products)) {
		// 	echo "<script> alert('dssa')  </script>";
        //     return "dd";
        // }
		//return $products;
		$purchaseData = Sales::create($purchase);
		// }
		$sum = "0";
		$tot = "0";
		$Code = "0";
		foreach ($products as $product) {
			//return $Code;
			//Save Sale Recipe Cost in Sale Details From Recipe Details
			$purchaseDetail = new SaleDetail();
			$purchaseDetail->sale_id = $purchaseData['id'];
			$purchaseDetail->product_id = $product['product_id'];
			$purchaseDetail->party_id = $product['party_id'];
			$purchaseDetail->uom_id = $product['uom_id'];
			$purchaseDetail->quantity = $product['quantity'];
			$purchaseDetail->product_cost = $product['product_cost'];
			$purchaseDetail->cost_amount = $product['cost_amount'];
			$purchaseDetail->discount_id = $product['discount_id'];
			$purchaseDetail->warehouse_id = $purchaseData['warehouse_id'];
			$purchaseDetail->biller = $purchaseData['biller'];
			$purchaseDetail->sale_rate = $product['sale_rate'];
			$purchaseDetail->sale_amount = $product['balance'];
			// $purchaseDetail->product_cost = $product['product_cost'];
			$purchaseDetail->product_cost = $product['product_cost'];
			// $purchaseDetail->cost_amount = $product['cost_amount'];
			$purchaseDetail->cost_amount = $product['cost_amount'];
			$purchaseDetail->company_id = $purchaseData['company_id'];
			$sum = $sum + $product['balance'];
			$purchaseDetail->save();

			//$pro = $product['product_id'];
			$recipe = Product::where('id', $product['product_id'])->first();
			if ($recipe['has_recipe'] == "1") {
				$RawMaterial = new ProductionStock();
				$RawMaterial->pro_transfer_id = $purchaseData['id'];
				$RawMaterial->company_id = $purchaseData['company_id'];
				$RawMaterial->warehouse_id = $purchaseData['warehouse_id'];
				$RawMaterial->product_id = $product['product_id'];
				$RawMaterial->uom_id = $product['uom_id'];
				$RawMaterial->date = $purchaseData['date'];
				$RawMaterial->voucher_no = $purchaseData['invoice_no'];
				$RawMaterial->cost_amount = $product['cost_amount'];
				$RawMaterial->stockout = $product['quantity'];
				$RawMaterial->save();
			} else {
				$RawMaterial = new RawMaterialStock();
				$RawMaterial->transction_id = $purchaseData['id'];
				$RawMaterial->type = "SALE";
				$RawMaterial->party_id = $product['party_id'];
				$RawMaterial->warehouse_id = $purchaseData['warehouse_id'];
				// $RawMaterial->sale_id = $purchaseData['id'];
				$RawMaterial->product_id = $product['product_id'];
				$RawMaterial->uom_id = $product['uom_id'];
				$RawMaterial->date = $purchaseData['date'];
				$RawMaterial->voucher_no = $purchaseData['invoice_no'];
				$RawMaterial->cost_amount = $product['cost_amount'];
				$RawMaterial->stockout = $product['quantity'];
				$RawMaterial->company_id = $purchaseData['company_id'];
				$RawMaterial->save();
			}

			if (($purchaseData['sale_type']) == "Credit Sale") {
				$vouchers = new LedgerDetailWise();
				$vouchers->transaction_id = $purchaseData['id'];
				$vouchers->party_id = $product['party_id'];
				$vouchers->warehouse_id = $purchaseData['warehouse_id'];
				$vouchers->voucher_no = $purchaseData['invoice_no'];
				$vouchers->voucher_type = $purchaseData['sale_type'];
				$vouchers->date = $purchaseData['date'];
				$vouchers->product_id = $product['product_id'];
				$vouchers->quantity = $product['quantity'];
				$vouchers->rate = $product['sale_rate'];
				$vouchers->debit = $product['balance'];
				$vouchers->company_id = $purchaseData['company_id'];
				$vouchers->save();

				$vouchers = new GeneralVoucher();
				$vouchers->transaction_id = $purchaseData['id'];
				$vouchers->account_head_id = $purchaseData['party_id'];
				$vouchers->warehouse_id = $purchaseData['warehouse_id'];
				$vouchers->date = $purchaseData['date'];
				$vouchers->voucher_no = $purchaseData['invoice_no'];
				$vouchers->v_type = $purchaseData['sale_type'];
				$vouchers->company_id = $purchaseData['company_id'];
				$vouchers->debit = $product['balance'];
				// $vouchers->debit = $sum;
				$vouchers->save();

				$vouchers = new LedgerDetailWise();
				$vouchers->transaction_id = $purchaseData['id'];
				$vouchers->party_id = 2;
				$vouchers->warehouse_id = $purchaseData['warehouse_id'];
				$vouchers->voucher_no = $purchaseData['invoice_no'];
				$vouchers->voucher_type = $purchaseData['sale_type'];
				$vouchers->date = $purchaseData['date'];
				$vouchers->product_id = $product['product_id'];
				$vouchers->quantity = $product['quantity'];
				$vouchers->rate = $product['sale_rate'];
				$vouchers->credit = $product['balance'];
				$vouchers->company_id = $purchaseData['company_id'];
				$vouchers->save();

				$vouchers = new GeneralVoucher();
				$vouchers->transaction_id = $purchaseData['id'];
				$vouchers->account_head_id = 2;
				$vouchers->warehouse_id = $purchaseData['warehouse_id'];
				$vouchers->date = $purchaseData['date'];
				$vouchers->voucher_no = $purchaseData['invoice_no'];
				$vouchers->v_type = $purchaseData['sale_type'];
				$vouchers->company_id = $purchaseData['company_id'];
				$vouchers->credit = $product['balance'];
				// $vouchers->credit = $sum;
				$vouchers->save();
			}
		}
		return $purchaseData['id'];
	}

	public function show($id)
	{
		// return "jhj";
		$newsale_detail = Sales::with(['sale_details' => function ($query) {
			$query->with('uoms');
			$query->with(['products' => function ($query) {
				// $query->with('publishers');
			}]);
			$query->with('taxes');
			$query->with('discount');
			$query->with('ledger');
			//$query->with('publishers');
		}])
			->with('parties')
			->with('billers')->with('shop')
			->where('sales.id', '=', $id)
			->where('company_id', session()->get('company_id'))
			->get();
		//return $newsale_detail;
		//return $id;

		// $ledgers = GeneralVoucher::where('account_head_id', '=', $newsale_detail[0]->parties->id)->get();
		// $ledgers = GeneralVoucher::where('account_head_id', '=', $newsale_detail[0]->parties->id)
		//  ->whereBetween('general_vouchers.date', ['2019-01-01', $newsale_detail[0]->date])
		//  ->get();
		//return $ledgers;
		$ledgers = GeneralVoucher::where('account_head_id', '=', $newsale_detail[0]->parties->id)
			->whereBetween('general_vouchers.date', ['2019-01-01', $newsale_detail[0]->date])
			->get();
		$logo = SystemLogo::where('id', '=', 1)->get();
		$company_detail = Setting::where('id', '=', 1)->get();

		$company = Companies::where('id', session()->get('company_id'))->first();
		return view('sales.dc', compact('newsale_detail', 'company_detail', 'ledgers', 'logo', 'ledgers', 'company'));


		$newsale_detail = Sales::with(['sale_details' => function ($query) {
			$query->with('products');
			//$query->with('taxes');
			//$query->with('discount');
			$query->with('parties');
		}])->with('billers')
			->where('sales.id', '=', $id)
			->where('company_id', session()->get('company_id'))
			->get();
		$company_detail = Setting::where('id', '=', 1)->get();
		//return $newsale_detail;
		return view('sales.details', compact('newsale_detail', 'company_detail'));
	}

	public function edit($id)
	{
		$purchase = Sales::with(['sale_details' => function ($query) {
			$query->with('products');
			$query->with('uoms');
			$query->with('discount');
		}])
			->with('parties')
			->where('sales.id', '=', $id)
			->where('company_id', session()->get('company_id'))
			->get();
		$shop = Warehouse::where('id', '=', $purchase[0]->warehouse_id)->get();
		//return $shop;
		//return $purchase;
		$DeliveryChallan = DeliveryChallan::where('status', '=', 'Pending')->OrderBy('vr_no', 'asc')->pluck('vr_no', 'vr_no')->prepend('Select Challan', '0')->toArray();
		//$customer = Party::OrderBy('id', 'asc')->pluck('party_name', 'id');
		$edit = $purchase[0];
		//return $edit;
		$products = Product:: //where('catagory_id', '=', '6')->
		where('company_id', session()->get('company_id'))
			->select(DB::raw('CONCAT(`id`, "_", `product_name`) AS `id`, `product_name`'))->OrderBy('id', 'asc')->pluck('product_name', 'id')->prepend('Select Product', '0')->toArray();
		//$taxes = Tax::select(DB::raw('CONCAT(`id`, "_", `tax_rate`) AS `tax_rate`, `tax_title`'))->OrderBy('id', 'asc')->pluck('tax_title', 'tax_rate')->toArray();

		//$taxes = Tax::select(DB::raw('CONCAT(`id`, "_", `tax_rate`) AS `tax_rate`, `tax_title`'))->OrderBy('tax_title', 'asc')->pluck('tax_title', 'tax_rate')->prepend('Select Tax', '0.00')->toArray();
		$customers = Party::where('company_id', session()->get('company_id'))->OrderBy('party_name', 'asc')->pluck('Party_name', 'id')->toArray();
		$customers = Party::join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
			->where('parties.account_group_id', '=', '1')
			// ->Orwhere('parties.account_group_id', '=', '7')
			->where('parties.company_id', session()->get('company_id'))
			->OrderBy('party_name', 'asc')->pluck('party_name', 'parties.id');
		$uoms = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))->OrderBy('id', 'asc')->pluck('uom', 'id')->toArray();
		$discounts = Discount::select(DB::raw('CONCAT(`id`, "_", `discount`) AS `discount`, `title`'))->OrderBy('id', 'asc')->pluck('title', 'discount')->toArray();
		$warehouse = Warehouse::OrderBy('name', 'asc')->pluck('name', 'id')->toArray();
		$encrypter = app('Illuminate\Encryption\Encrypter');
		$encrypted_token = $encrypter->encrypt(csrf_token());
		return view('sales.edit', compact('edit', 'products', 'DeliveryChallan', 'customers', 'encrypted_token', 'uoms', 'discounts', 'warehouse', 'shop'));
	}

	public function update(Request $request, $id)
	{
		$purchaseData = Sales::findOrFail($id);
		$purchase = json_decode($request->get('purchase'), true);
		//return $purchase;
		$purchaseData->date = date('Y-m-d', strtotime($purchase['date']));
		$purchaseData->invoice_no = $purchase['invoice_no'];
		$purchaseData->localExport = $purchase['localExport'];
		$purchaseData->biller = $purchase['biller'];
		$purchaseData->sale_type = $purchase['sale_type'];
		$purchaseData->sale_list = $purchase['sale_list'];
		$purchaseData->sample_description = $purchase['sample_description'];
		//$purchaseData->dcn_no = $purchase['dcn_no'];
		$purchaseData->warehouse_id = $purchase['warehouse_id'];
		$purchaseData->party_id = $purchase['party_id'];
		$purchaseData->due_date = $purchase['due_date'];
		$purchaseData->particulars = $purchase['particulars'];
		//return $purchaseData;
		$purchaseData->save();

		SaleDetail::where('sale_id', '=', $id)->delete();
		GeneralVoucher::where('transaction_id', '=', $id)->where('v_type', 'Credit Sale')->delete();
		LedgerDetailWise::where('transaction_id', '=', $id)->where('voucher_type', 'Credit Sale')->delete();
		// StockRegisterSpecificItem::where('sale_id', '=', $id)->delete();
		RawMaterialStock::where('transction_id', '=', $id)->where('type', 'SALE')->delete();
		// CashBook::where('sale_id', '=', $id)->delete();
		$products = $request->get('product_data');
		$sum = 0;
		foreach ($products as $product) {
			$purchaseDetail = new SaleDetail();
			$purchaseDetail->sale_id = $purchaseData['id'];
			$purchaseDetail->product_id = $product['product_id'];
			$purchaseDetail->party_id = $product['party_id'];
			$purchaseDetail->uom_id = $product['uom_id'];
			$purchaseDetail->quantity = $product['quantity'];
			$purchaseDetail->product_cost = $product['product_cost'];
			$purchaseDetail->cost_amount = $product['cost_amount'];
			$purchaseDetail->discount_id = $product['discount_id'];
			$purchaseDetail->biller = $purchaseData['biller'];
			$purchaseDetail->warehouse_id = $purchaseData['warehouse_id'];
			$purchaseDetail->sale_rate = $product['sale_rate'];
			$purchaseDetail->sale_amount = $product['balance'];
			$purchaseDetail->company_id = $product['company_id'];
			$sum = $sum + $product['balance'];
			$purchaseDetail->save();

			$recipe = Product::where('id', $product['product_id'])->first();
			if ($recipe['has_recipe'] == "1") {
				$RawMaterial = new ProductionStock();
				$RawMaterial->pro_transfer_id = $purchaseData['id'];
				$RawMaterial->company_id = $purchaseData['company_id'];
				$RawMaterial->warehouse_id = $purchaseData['warehouse_id'];
				$RawMaterial->product_id = $product['product_id'];
				$RawMaterial->uom_id = $product['uom_id'];
				$RawMaterial->date = $purchaseData['date'];
				$RawMaterial->voucher_no = $purchaseData['invoice_no'];
				$RawMaterial->cost_amount = $product['cost_amount'];
				$RawMaterial->stockout = $product['quantity'];
				$RawMaterial->save();
			} else {
				$RawMaterial = new RawMaterialStock();
				$RawMaterial->transction_id = $purchaseData['id'];
				$RawMaterial->type = "SALE";
				$RawMaterial->party_id = $product['party_id'];
				$RawMaterial->warehouse_id = $purchaseData['warehouse_id'];
				// $RawMaterial->sale_id = $purchaseData['id'];
				$RawMaterial->product_id = $product['product_id'];
				$RawMaterial->uom_id = $product['uom_id'];
				$RawMaterial->date = $purchaseData['date'];
				$RawMaterial->voucher_no = $purchaseData['invoice_no'];
				$RawMaterial->cost_amount = $product['cost_amount'];
				$RawMaterial->stockout = $product['quantity'];
				$RawMaterial->company_id = $purchaseData['company_id'];
				$RawMaterial->save();
			}

			$RawMaterial = new RawMaterialStock();
			$RawMaterial->transction_id = $purchaseData['id'];
			$RawMaterial->type = "SALE";
			$RawMaterial->party_id = $product['party_id'];
			$RawMaterial->warehouse_id = $purchaseData['warehouse_id'];
			// $RawMaterial->sale_id = $purchaseData['id'];
			$RawMaterial->product_id = $product['product_id'];
			$RawMaterial->uom_id = $product['uom_id'];
			$RawMaterial->date = $purchaseData['date'];
			$RawMaterial->voucher_no = $purchaseData['invoice_no'];
			$RawMaterial->cost_amount = $product['cost_amount'];
			$RawMaterial->stockout = $product['quantity'];
			$RawMaterial->company_id = $purchaseData['company_id'];
			$RawMaterial->save();

			if (($purchaseData['sale_type']) == "Credit Sale") {

				$vouchers = new LedgerDetailWise();
				$vouchers->transaction_id = $purchaseData['id'];
				$vouchers->party_id = $product['party_id'];
				$vouchers->warehouse_id = $purchaseData['warehouse_id'];
				$vouchers->voucher_no = $purchaseData['invoice_no'];
				$vouchers->voucher_type = $purchaseData['sale_type'];
				$vouchers->date = $purchaseData['date'];
				$vouchers->product_id = $product['product_id'];
				$vouchers->quantity = $product['quantity'];
				$vouchers->rate = $product['sale_rate'];
				$vouchers->debit = $product['balance'];
				$vouchers->company_id = $purchaseData['company_id'];
				$vouchers->save();

				$vouchers = new GeneralVoucher();
				$vouchers->transaction_id = $purchaseData['id'];
				$vouchers->account_head_id = $purchaseData['party_id'];
				$vouchers->warehouse_id = $purchaseData['warehouse_id'];
				$vouchers->date = $purchaseData['date'];
				$vouchers->voucher_no = $purchaseData['invoice_no'];
				$vouchers->v_type = $purchaseData['sale_type'];
				$vouchers->company_id = $purchaseData['company_id'];
				$vouchers->debit = $product['balance'];
				// $vouchers->debit = $sum;
				$vouchers->save();



				$vouchers = new LedgerDetailWise();
				$vouchers->transaction_id = $purchaseData['id'];
				$vouchers->party_id = 2;
				$vouchers->warehouse_id = $purchaseData['warehouse_id'];
				$vouchers->voucher_no = $purchaseData['invoice_no'];
				$vouchers->voucher_type = $purchaseData['sale_type'];
				$vouchers->date = $purchaseData['date'];
				$vouchers->product_id = $product['product_id'];
				$vouchers->quantity = $product['quantity'];
				$vouchers->rate = $product['sale_rate'];
				$vouchers->credit = $product['balance'];
				$vouchers->company_id = $purchaseData['company_id'];
				$vouchers->save();

				$vouchers = new GeneralVoucher();
				$vouchers->transaction_id = $purchaseData['id'];
				$vouchers->account_head_id = 2;
				$vouchers->warehouse_id = $purchaseData['warehouse_id'];
				$vouchers->date = $purchaseData['date'];
				$vouchers->voucher_no = $purchaseData['invoice_no'];
				$vouchers->v_type = $purchaseData['sale_type'];
				$vouchers->company_id = $purchaseData['company_id'];
				$vouchers->credit = $product['balance'];
				// $vouchers->credit = $sum;
				$vouchers->save();
			}
		}

		// }
		// if (($purchaseData['sale_type']) == "Cash Sale") {
		// 	$vouchers = new GeneralVoucher();
		// 	$vouchers->transaction_id = $purchaseData['id'];
		// 	$vouchers->account_head_id = $purchaseData['party_id'];
		// 	$vouchers->warehouse_id = $purchaseData['warehouse_id'];
		// 	$vouchers->date = $purchaseData['date'];
		// 	$vouchers->voucher_no = $purchaseData['invoice_no'];
		// 	$vouchers->v_type = $purchaseData['sale_type'];
		// 	$vouchers->credit = $sum;
		// 	$vouchers->save();

		// 	$cash = new CashBook();
		// 	$cash->date = $purchaseData['date'];
		// 	$cash->vr_no = $purchaseData['invoice_no'];
		// 	$cash->vr_type = $purchaseData['sale_type'];
		// 	$cash->party_id = $purchaseData['party_id'];
		// 	$cash->shop_id = $purchaseData['warehouse_id'];
		// 	$cash->sale_id = $purchaseData['id'];
		// 	$cash->in = $sum;
		// 	$cash->save();
		// }
		return $purchaseData['id'];
		//return "updated";        
	}

	public function destroy($id)
	{
		$delete = Sales::findOrFail($id);
		$delete->delete();
		SaleDetail::where('sale_id', '=', $id)->delete();
		GeneralVoucher::where('transaction_id', '=', $id)->where('v_type', 'Credit Sale')->delete();
		LedgerDetailWise::where('transaction_id', '=', $id)->where('voucher_type', 'Credit Sale')->delete();
		// StockRegisterSpecificItem::where('sale_id', '=', $id)->delete();
		// SalePointStock::where('sale_id', '=', $id)->delete();
		ProductionStock::where('pro_transfer_id', '=', $id)->delete();
		// CashBook::where('sale_id', '=', $id)->delete();
		RawMaterialStock::where('transction_id', '=', $id)->where('type', 'SALE')->delete();
		// Ledger::where('sale_id', '=', $id)->delete();       
		return "Sale has been Deleted Successfully!";
	}


	public function FirstProduct(Request $request)
	{
		$productId = $request->get('saletab_id');
		$productArray = Product::where('product_code', '=', $productId)->get(['products.*']);
		return $productArray;
	}

	public function getProduct(Request $request)
	{
		$productCode = $request->get('code_id');
		$data = Product::join('purchase_details', 'purchase_details.product_id', '=', 'products.id')
			->where('product_code', '=', $productCode)
			->where('remaining_quantity', '!=', 0)
			->OrderBy('purchase_details.id', 'asc')
			->first(['products.*', 'purchase_details.remaining_quantity', 'purchase_details.unit_cost', 'purchase_details.total_cost']);
		//->first();
		$test[] = $data;;
		return $test;
	}

	public function ProductChange(Request $request)
	{
		$productID = $request->get('prodCode');
		//$CustomerID = Input::get('Customerid');
		//return $CustomerID;
		$test = Product::where('product_code', '=', $productID)->get();
		//        $data = Product::join('purchase_details', 'purchase_details.product_id', '=', 'products.id')
		// 	->where('products.id', '=', $productID)
		// 	->where('remaining_quantity', '!=', 0)
		// 	->OrderBy('purchase_details.id', 'asc')
		// 	->first(['products.*','purchase_details.remaining_quantity', 'purchase_details.unit_cost', 'purchase_details.total_cost']);
		// $test[] = $data;
		// $test = ProductRateDetails::with('product')
		// ->where('product_code', '=', $productID)
		// ->where('customer_id', '=', $CustomerID)
		// ->get();



		return $test;
	}

	public function ProductSearch(Request $request)
	{
		//return "d";
		$productID = $request->get('prodID');
		$test = Product::where('id', '=', $productID)->get();
		return $test;
	}

	public function ProductRate(Request $request)
	{
		$productID = $request->get('prodCode');
		//return $productID;
		$CustomerID = $request->get('Customerid');
		$test = ProductRateDetails::with('product')
			->where('product_code', '=', $productID)
			->where('customer_id', '=', $CustomerID)
			->get();

		//$test = Product::where('product_code', '=', $productID)->get();



		return $test;
	}

	public function search(Request $request)
	{
		// return "hel";
		$product = $request->get('product_name');
		$data = Product::where('name', 'like', '%' . $product . '%')->get();
		echo json_encode($data);
	}

	public function ProductChangeName(Request $request)
	{
		$productID = $request->get('prodID');
		$test = Product::where('id', '=', $productID)->get();

		return $test;
	}

	public function PartyChange(Request $request)
	{
		$partyname = $request->get('party_id');
		$data = Party::where('id', '=', $partyname)->get();
		return $data;
	}

	public function print_sale($id)
	{
		$company = Companies::where('id', session()->get('company_id'))->first();
		$newsale_detail = Sales::with(['sale_details' => function ($query) {
			$query->with('uoms');
			$query->with('products');

			$query->with('taxes');
			$query->with('discount');
			$query->with('ledger');
			//$query->with('publishers');
		}])->with('parties')->with('billers')->with('shop')
			->where('sales.id', '=', $id)
			->get();
		$ledgers = GeneralVoucher::where('account_head_id', '=', $newsale_detail[0]->parties->id)
			->whereBetween('general_vouchers.date', ['2019-01-01', $newsale_detail[0]->date])
			->get();
		$logo = SystemLogo::where('id', '=', 1)->get();
		$company_detail = Setting::where('id', '=', 1)->get();


		return view('sales.invoice', compact('newsale_detail', 'company_detail', 'ledgers', 'logo', 'ledgers', 'company'));
	}

	public function getOrderPDF($id)
	{
		$pdfMerger = PDFMerger::init();
		$i = 0;
		//return "getOrderPDF";
		$newsale_detail = Sales::with(['sale_details' => function ($query) {
			$query->with('uoms');
			$query->with(['products' => function ($query) {
				//$query->with('publishers');
			}]);
			//$query->with('taxes');
			$query->with('discount');
			//$query->with('ledger');
			//$query->with('publishers');
		}])->with('parties')->with('billers')
			->where('sales.id', '=', $id)
			->get();
		//$newsale_detail = $dos->chunk(20);
		//$newsale_detail = $data[0];
		//return $newsale_detail;

		$company_detail = Setting::where('id', '=', 1)->get();

		$pdf = PDF::loadView('sales.thermalpdf', ['newsale_detail' => $newsale_detail, 'company_detail' => $company_detail]);
		return $pdf->download('SaleBill.pdf');
	}

	public function DCMouseUp(Request $request)
	{
		$DC_No = $request->get('dc_no');
		//return $DC_No;
		$purchases = DeliveryChallanDetail::join('delivery_challans', 'delivery_challans.id', '=', 'delivery_challan_details.challan_id')
			->join('products', 'products.id', '=', 'delivery_challan_details.product_id')
			->join('parties', 'parties.id', 'delivery_challans.party_id')
			//->join('taxes', 'taxes.id', '=', 'grn_details.tax_id')
			->where('delivery_challans.dcn_no', '=', $DC_No)->get();
		return $purchases;
	}

	public function UpdateCost()
	{
		$products = Product::Orderby('id', 'asc')->get();
		$SalesDetail = SaleDetail::Orderby('id', 'asc')->get();
		foreach ($SalesDetail as $detail) {
			$products = Product::where('id', '=', $detail->product_id)->get();
			//return $products[0]->product_cost;
			if ($detail->product_id != "0") {
				$detail->product_cost = $products[0]->product_cost;
				$detail->save();
				$detail->cost_amount = $products[0]->product_cost * $detail->quantity;
				$detail->save();
			}
			//  return $detail->product_id;
		}
		return "done";
	}

	public function LoadProducts()
	{
		$output = "";
		$sum = 0;
		$amount = 0;
		//return $ID;
		// $data = ProductDetails::where('product_id', '=', $ID)->get();
		// $data = Products::with(['recipe_details'=>function($query){
		// 							$query->with('products');
		// 				$query->with('uoms');
		// 				//$query->with('taxes');
		// 		}])->get();
		$data = Product::where('catagory_id', '=', 6)->OrderBy('product_code')->get();
		//return $data;
		if ($data) {
			foreach ($data as $overallstocke) {
				$sum = $sum + 1;
				$output .= '<tr>' .
					'<td style="padding-top:20px; display:none;"><input id="master_id" name="master_id[]" value="' . $overallstocke->id . '" type="text" class="form-control"></td>' .

					'<td style="padding-top:20px;"><input id="test" value="' . $overallstocke->product_code . '" type="text" class="form-control" style="margin-left: 7%; width: 80%;" disabled></td>' .

					// '<td style="padding-top:20px;"><input id="trackingNo" name="trackingNo[]" value="'.$sum.'" type="text" class="form-control" disabled></td>'.

					'<td style="padding-top:20px;"><input id="test" value="' . $overallstocke->product_name . '" type="text" class="form-control" style="margin-left: -4%;
    width: 144%;" disabled></td>' .

					'<td style="display:none;"><input id="test" value="2" type="text" class="form-control" style="margin-left: -25%;
    width: 120%;"></td>' .

					'<td style="padding-top:20px;"><input id="test" value="' . $overallstocke->uom . '" type="text" class="form-control" style="margin-left: 50%;
     width: 72%;" disabled></td>' .
					// '<td style="padding-top:20px;">
					//         <select id="discount_id" name="discount_id[]" class="form-control" style="margin-left: 50%; width: 72%;">'.

					//         '<option value="1">No Discount</option>'.

					//         '</select>
					//         </td>'.

					'<td style="padding-top:20px;"><input id="test" value="' . $overallstocke->product_cost . '" type="text" class="form-control" style="margin-left: 32%; width: 76%;" disabled></td>' .
					//quantity
					'<td style="padding-top:20px;"><input id="test" value="1"  type="text" class="form-control" onkeyup="QtyChange($(this).val(), $(this).closest(\'tr\').index());" style="margin-left: 17%; width: 73%;"></td>' .
					//cost amount
					'<td style="padding-top:20px;"><input id="test" value="' . $overallstocke->product_cost . '" type="text" class="form-control" style="width:74%; margin-left: -1%;" disabled></td>' .

					//
					'<td style="display:none;"><input id="test" value="1" type="text" class="form-control"  style="" disabled></td>' .

					//         '<td style="padding-top:20px;"><input id="test" value="${discount}%" type="text" class="form-control" style="margin-left: 8%;
					// width: 79%;" disabled></td>'.
					'<td style="padding-top:20px;">
            <select id="discount_id" name="discount_id[]" class="form-control" style="margin-left: -28%; width: 120%;">' .

					'<option value="1">No Discount</option>' .

					'</select>
            </td>' .

					'<td style="padding-top:20px;"><input id="test" value="' . $overallstocke->product_price . '" type="text" class="form-control" onkeyup="salerate($(this).val(), $(this).closest(\'tr\').index());" style="margin-left:4%; width: 73%;"></td>' .

					'<td style="padding-top:20px;"><input id="test" value="' . $overallstocke->product_price . '" type="text" class="form-control" style="margin-left: -13%;
    width: 73%;" disabled></td>' .
					'<td onclick="javascript:myDeleteFunction($(this).closest(\'tr\'));" style="padding-top: 20px;"><button class="btn btn-red" type="button" style="margin-left: -80%;"> <i  class="icon-trash" title="Delete Row"></i></button></td>' .

					// '<td style="padding-top:20px;">
					// <select id="destination_id" name="destination_id[]" class="form-control" disabled>'.



					// '</select>
					// </td>'.

					'</tr></br>';
			}
			return response()->json($output);
		}
		return $data;
		return "enter";
	}
}