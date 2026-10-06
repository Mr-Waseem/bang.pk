<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Tax;
use App\Models\SystemLogo;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\GRN;
use App\Models\GRNDetails;
use App\Models\Party;
use App\Models\GeneralVoucher;
use App\Models\StockRegisterSpecificItem;
use App\Models\LedgerDetailWise;
use App\Models\UOM;
use App\Models\Warehouse;
use App\Models\RawMaterialStock;
use App\Models\CashBook;
use App\Models\RecipeCreationDetails;
use Illuminate\Support\Facades\DB;
use Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$purchases = Purchase::where('purchase_type', '=', 'Credit Purchase')
			->with(['purchase_details' => function ($query) {
				$query->with('purchase_tax');
			}])->with('parties')
			->where('company_id', session()->get('company_id'))
			->OrderBy('purchases.id', 'desc')
			->get();
		//return $purchases;
		return view('purchases.index', compact('purchases'));
	}

	public function create()
	{
		// $code = Purchase::OrderBy('id', 'desc')->where('company_id', session()->get('company_id'))->first();
		
		$code = Purchase::where('purchase_type', 'Credit Purchase')->where('company_id', session()->get('company_id'))
            ->OrderBy('id','desc')->first();
		//return $code;
		if (isset($code) > 0) {
			$codes = (int)$code->bill_no + 1;
		} else {
			$codes = 1;
		}
		$grns = GRN::where('status', '=', 'Pending')->OrderBy('grn_no', 'asc')->pluck('grn_no', 'grn_no')->prepend('Select Grn', '0')->toArray();
		//return $grns;
		// $products = Product::OrderBy('product_name', 'asc')->pluck('product_name', 'product_name')->prepend('Select Product', '0')->toArray();
		$products = Product::select(DB::raw('CONCAT(`id`, "_", `product_name`) AS `id`, `product_name`'))
			->OrderBy('id', 'asc')
			->where('company_id', session()->get('company_id'))
			->where('catagory_id', '=', '5')
			->pluck('product_name', 'id')
			->prepend('Select Product', '0')
			->toArray();
		// $taxes = Tax::select(DB::raw('CONCAT(`id`, "_", `tax_rate`) AS `tax_rate`, `tax_title`'))->OrderBy('id', 'asc')->pluck('tax_title', 'tax_rate')->toArray();
		//$suppliers = Supplier::OrderBy('id', 'asc')->pluck('name', 'id');
		$Account = Party::join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
			// ->where('parties.account_group_id', '=', '2')
			// ->Orwhere('parties.account_group_id', '=', '3')
			->where('parties.account_group_id', '=', '2')
			->where('parties.company_id', session()->get('company_id'))
			->OrderBy('party_name', 'asc')
			->pluck('party_name', 'parties.id')
			->prepend('Select Supplier', '');
		$warehouse = Warehouse::OrderBy('name', 'asc')
			->where('id', '=', 1)
			->pluck('name', 'id')
			->toArray();
		$encrypter = app('Illuminate\Encryption\Encrypter');
		$encrypted_token = $encrypter->encrypt(csrf_token());
		$uoms = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))->OrderBy('id', 'asc')->pluck('uom', 'id')->prepend('PCS', '2_PCS')->toArray();
		return view('purchases.create-simple', compact('Account', 'products', 'codes', 'grns', 'encrypted_token', 'uoms', 'warehouse'));
	}

	public function store(Request $request)
	{
		// return $request->all();
		$purchase = json_decode($request->get('purchase'), true);
		$purchase['date'] = date('Y-m-d', strtotime($purchase['date']));
		$products = $request->get('product_data');
		$purchaseData = Purchase::create($purchase);
		// if($purchaseData->grn_no != 	"0"){
		// $project = GRN::where("grn_no", $purchaseData->grn_no)->first();
		// $project->status = "Added";
		// $project->save();
		// }	
		$sum = "0";
		$rate = "0";
		foreach ($products as $product) {
			$purchaseDetail = new PurchaseDetail();
			$purchaseDetail->purchase_id = $purchaseData['id'];
			$purchaseDetail->party_id = $purchaseData['account_id'];
			$purchaseDetail->product_id = $product['product_id'];
			$purchaseDetail->uom_id = $product['uom_id'];
			$purchaseDetail->warehouse_id = $purchaseData['warehouse_id'];
			$purchaseDetail->quantity = $product['quantity'];
			$purchaseDetail->remaining_quantity = $product['quantity'];
			$purchaseDetail->unit_cost = $product['unit_cost'];
			$purchaseDetail->total_cost = $product['total_cost'];
			$purchaseDetail->company_id = $product['company_id'];

			$sum = $sum + $product['total_cost'];
			$purchaseDetail->save();

			$vouchers = new LedgerDetailWise();
			$vouchers->transaction_id = $purchaseData['id'];
			$vouchers->warehouse_id = $purchaseData['warehouse_id'];
			$vouchers->party_id = $purchaseData['account_id'];
			$vouchers->voucher_no = $purchaseData['bill_no'];
			$vouchers->voucher_type = $purchaseData['purchase_type'];
			$vouchers->date = $purchaseData['date'];
			$vouchers->product_id = $product['product_id'];
			$vouchers->quantity = $product['quantity'];
			$vouchers->rate = $product['unit_cost'];
			$vouchers->credit = $product['total_cost'];
			$vouchers->company_id = $product['company_id'];
			$vouchers->save();

			$vouchers = new GeneralVoucher();
			$vouchers->transaction_id = $purchaseData['id'];
			$vouchers->account_head_id = $purchaseData['account_id'];
			$vouchers->warehouse_id = $purchaseData['warehouse_id'];
			$vouchers->date = $purchaseData['date'];
			$vouchers->voucher_no = $purchaseData['bill_no'];
			$vouchers->v_type = $purchaseData['purchase_type'];
			$vouchers->company_id = $product['company_id'];
			$vouchers->credit = $product['total_cost'];
			// $vouchers->credit = $sum;
			$vouchers->save();

			$vouchers = new LedgerDetailWise();
			$vouchers->transaction_id = $purchaseData['id'];
			$vouchers->warehouse_id = $purchaseData['warehouse_id'];
			$vouchers->party_id = 1;
			$vouchers->voucher_no = $purchaseData['bill_no'];
			$vouchers->voucher_type = $purchaseData['purchase_type'];
			$vouchers->date = $purchaseData['date'];
			$vouchers->product_id = $product['product_id'];
			$vouchers->quantity = $product['quantity'];
			$vouchers->rate = $product['unit_cost'];
			$vouchers->debit = $product['total_cost'];
			$vouchers->company_id = $product['company_id'];
			$vouchers->save();

			$vouchers = new GeneralVoucher();
			$vouchers->transaction_id = $purchaseData['id'];
			$vouchers->account_head_id = 1;
			$vouchers->warehouse_id = $purchaseData['warehouse_id'];
			$vouchers->date = $purchaseData['date'];
			$vouchers->voucher_no = $purchaseData['bill_no'];
			$vouchers->v_type = $purchaseData['purchase_type'];
			$vouchers->company_id = $product['company_id'];
			$vouchers->debit = $product['total_cost'];
			// $vouchers->debit = $sum;
			$vouchers->save();

			$RawMaterial = new RawMaterialStock();
			$RawMaterial->transction_id = $purchaseData['id'];
			$RawMaterial->type = "PURCHASE";
			$RawMaterial->party_id = $purchaseData['account_id'];
			$RawMaterial->warehouse_id = $purchaseData['warehouse_id'];
			$RawMaterial->product_id = $product['product_id'];
			$RawMaterial->uom_id = $product['uom_id'];
			$RawMaterial->date = $purchaseData['date'];
			$RawMaterial->voucher_no = $purchaseData['bill_no'];
			$RawMaterial->cost_amount = $product['total_cost'];
			$RawMaterial->stockin = $product['quantity'];
			$RawMaterial->company_id = $product['company_id'];
			$RawMaterial->save();
			//Change cost of one item
			$data = Product::where('id', '=', $product['product_id'])
				->where('company_id', session()->get('company_id'))
				->OrderBy('id')
				->first();
			//return $data;
			// 	$tot = (int)$data->remaining_quantity - (int)$tot;
			$data->product_cost = $product['unit_cost'];
			$data->save();

			//Change all cost of one item in recipe
			$stockless = RecipeCreationDetails::where('product_id', '=', $product['product_id'])->get();
			foreach ($stockless as $stock) {
				$stock->rate = $product['unit_cost'];
				$stock->amount = $stock->quantity * $product['unit_cost'];
				$stock->save();
			}

		}

		return $purchaseData['id'];
		//return "inserted";
	}

	public function destroy($id)
	{
		$delete = Purchase::findOrFail($id);
		$delete->delete();
		PurchaseDetail::where('purchase_id', '=', $id)->delete();
		GeneralVoucher::where('transaction_id', '=', $id)->where('v_type', 'Credit Purchase')->delete();
        LedgerDetailWise::where('transaction_id', '=', $id)->where('voucher_type', 'Credit Purchase')->delete();
		// StockRegisterSpecificItem::where('purchase_id', '=', $id)->delete();
		RawMaterialStock::where('transction_id', '=', $id)->where('type', 'PURCHASE')->delete();
		// CashBook::where('purchase_id', '=', $id)->delete();
		return Redirect('purchases');
		// return "Purchase has been Deleted Successfully!";
	}

	public function unit_cost(Request $request)
	{
		$purchaseId = $request->get('purchasetab_id');
		$productsArray = Product::where('id', '=', $purchaseId)->get();
		return $productsArray;
	}

	public function purchase_json(Request $request)
	{
		$productId = $request->get('purchase_id');
		$productsArray = Product::where('id', '=', $productId)->get(['products.product_cost AS product_newcost']);
		return $productsArray;
	}

	public function quantity_json(Request $request)
	{
		$productId = $request->get('quantity_id');
		$productsArray = Product::where('id', '=', $productId)->get(['products.product_cost AS product_newcost']);
		return $productsArray;
	}

	public function show($id)
	{
		$detail = Purchase::with(['purchase_details' => function ($query) {
			$query->with('purchase_tax');
			$query->with('products');
		}])->with('suppliers')
			->where('purchases.id', '=', $id)
			->where('company_id', session()->get('company_id'))
			->get();
		//return $detail;
		$purchase_detail = $detail[0];
		return view('purchases.details', compact('purchase_detail'));
	}

	public function edit($id)
	{
		$purchase = Purchase::with(['purchase_details' => function ($query) {
			$query->with('purchase_tax');
			$query->with('products');
			$query->with('unit');
		}])
			->where('company_id', session()->get('company_id'))
			->where('purchases.id', '=', $id)
			->get();
		$edit = $purchase[0];
		$grns = GRN::OrderBy('grn_no', 'asc')->pluck('grn_no', 'grn_no')->prepend('Select Grn', '0')->toArray();
		// $products = Product::OrderBy('product_name', 'asc')->pluck('product_name', 'product_name')->prepend('Select Product', '0')->toArray();
		$products = Product::select(DB::raw('CONCAT(`id`, "_", `product_name`) AS `id`, `product_name`'))
			->where('company_id', session()->get('company_id'))
			->OrderBy('id', 'asc')
			->pluck('product_name', 'id')
			->prepend('Select Product', '0')
			->toArray();
		$taxes = Tax::select(DB::raw('CONCAT(`id`, "_", `tax_rate`) AS `tax_rate`, `tax_title`'))->OrderBy('tax_title', 'asc')->pluck('tax_title', 'tax_rate')->prepend('Select Tax', '0.00')->toArray();
		//$suppliers =Party::where('type', 'Buyer')->OrderBy('party_name', 'asc')->pluck('party_name', 'id');
		//$Account = Party::OrderBy('party_name', 'asc')->pluck('party_name', 'id')->prepend('Select Account', '0');
		$Account = Party::join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
			->where('parties.account_group_id', '=', '2')
			// ->Orwhere('parties.account_group_id', '=', '3')
			// ->Orwhere('parties.account_group_id', '=', '7')
			->where('parties.company_id', session()->get('company_id'))
			->OrderBy('party_name', 'asc')
			->pluck('party_name', 'parties.id');
		$encrypter = app('Illuminate\Encryption\Encrypter');
		$encrypted_token = $encrypter->encrypt(csrf_token());
		$warehouse = Warehouse::OrderBy('name', 'asc')
			->where('id', '=', 1)
			->pluck('name', 'id')->toArray();
		//return $edit;
		$uoms = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))->OrderBy('id', 'asc')->pluck('uom', 'id')->toArray();
		return view('purchases.edit', compact('edit', 'products', 'taxes', 'Account', 'grns', 'encrypted_token', 'warehouse', 'uoms'));
	}

	public function update(Request $request, $id)
	{
		$purchaseData = Purchase::findOrFail($id);
		$purchase = json_decode($request->get('purchase'), true);
		$purchaseData->account_id = $purchase['account_id'];
		$purchaseData->date = date('Y-m-d', strtotime($purchase['date']));
		$purchaseData->bill_no = $purchase['bill_no'];
		//$purchaseData->grn_no = $purchase['grn_no'];
		$purchaseData->purchase_type = $purchase['purchase_type'];
		$purchaseData->due_date = $purchase['due_date'];
		$purchaseData->particulars = $purchase['particulars'];
		$purchaseData->company_id = $purchase['company_id'];
		$purchaseData->save();

		PurchaseDetail::where('purchase_id', '=', $id)->delete();
		// StockRegisterSpecificItem::where('purchase_id', '=', $id)->delete();
		GeneralVoucher::where('transaction_id', '=', $id)->where('v_type', 'Credit Purchase')->delete();
        LedgerDetailWise::where('transaction_id', '=', $id)->where('voucher_type', 'Credit Purchase')->delete();
		// CashBook::where('purchase_id', '=', $id)->delete();
		RawMaterialStock::where('transction_id', '=', $id)->where('type', 'PURCHASE')->delete();

		$products = $request->get('product_data');
		$sum = "0";
		foreach ($products as $product) {
			$purchaseDetail = new PurchaseDetail();
			$purchaseDetail->purchase_id = $purchaseData['id'];
			$purchaseDetail->party_id = $purchaseData['account_id'];
			$purchaseDetail->product_id = $product['product_id'];
			$purchaseDetail->warehouse_id = $purchaseData['warehouse_id'];
			$purchaseDetail->uom_id = $product['uom_id'];
			$purchaseDetail->quantity = $product['quantity'];
			$purchaseDetail->remaining_quantity = $product['quantity'];
			$purchaseDetail->unit_cost = $product['unit_cost'];
			$purchaseDetail->total_cost = $product['total_cost'];
			$purchaseDetail->company_id = $product['company_id'];
			$sum = $sum + $product['total_cost'];
			$purchaseDetail->save();

			$vouchers = new LedgerDetailWise();
			$vouchers->transaction_id = $purchaseData['id'];
			$vouchers->warehouse_id = $purchaseData['warehouse_id'];
			$vouchers->party_id = $purchaseData['account_id'];
			$vouchers->voucher_no = $purchaseData['bill_no'];
			$vouchers->voucher_type = $purchaseData['purchase_type'];
			$vouchers->date = $purchaseData['date'];
			$vouchers->product_id = $product['product_id'];
			$vouchers->quantity = $product['quantity'];
			$vouchers->rate = $product['unit_cost'];
			$vouchers->credit = $product['total_cost'];
			$vouchers->company_id = $product['company_id'];
			$vouchers->save();

			$vouchers = new GeneralVoucher();
			$vouchers->transaction_id = $purchaseData['id'];
			$vouchers->account_head_id = $purchaseData['account_id'];
			$vouchers->warehouse_id = $purchaseData['warehouse_id'];
			$vouchers->date = $purchaseData['date'];
			$vouchers->voucher_no = $purchaseData['bill_no'];
			$vouchers->v_type = $purchaseData['purchase_type'];
			$vouchers->company_id = $product['company_id'];
			$vouchers->credit = $product['total_cost'];
			// $vouchers->credit = $sum;
			$vouchers->save();

			$vouchers = new LedgerDetailWise();
			$vouchers->transaction_id = $purchaseData['id'];
			$vouchers->warehouse_id = $purchaseData['warehouse_id'];
			$vouchers->party_id = 1;
			$vouchers->voucher_no = $purchaseData['bill_no'];
			$vouchers->voucher_type = $purchaseData['purchase_type'];
			$vouchers->date = $purchaseData['date'];
			$vouchers->product_id = $product['product_id'];
			$vouchers->quantity = $product['quantity'];
			$vouchers->rate = $product['unit_cost'];
			$vouchers->debit = $product['total_cost'];
			$vouchers->company_id = $product['company_id'];
			$vouchers->save();

			$vouchers = new GeneralVoucher();
			$vouchers->transaction_id = $purchaseData['id'];
			$vouchers->account_head_id = 1;
			$vouchers->warehouse_id = $purchaseData['warehouse_id'];
			$vouchers->date = $purchaseData['date'];
			$vouchers->voucher_no = $purchaseData['bill_no'];
			$vouchers->v_type = $purchaseData['purchase_type'];
			$vouchers->company_id = $product['company_id'];
			$vouchers->debit = $product['total_cost'];
			// $vouchers->debit = $sum;
			$vouchers->save();


			$RawMaterial = new RawMaterialStock();
			// $RawMaterial->purchase_id = $purchaseData['id'];
			$RawMaterial->transction_id = $purchaseData['id'];
			$RawMaterial->type = "PURCHASE";
			$RawMaterial->party_id = $purchaseData['account_id'];
			$RawMaterial->warehouse_id = $purchaseData['warehouse_id'];
			$RawMaterial->product_id = $product['product_id'];
			$RawMaterial->uom_id = $product['uom_id'];
			$RawMaterial->date = $purchaseData['date'];
			$RawMaterial->voucher_no = $purchaseData['bill_no'];
			$RawMaterial->cost_amount = $product['total_cost'];
			$RawMaterial->stockin = $product['quantity'];
			$RawMaterial->company_id = $product['company_id'];
			$RawMaterial->save();
		}


		return $purchaseData['id'];
	}

	public function codeMouseUp(Request $request)
	{
		$productId = $request->get('entered_code');
		//return $productId;
		$productsArray = Product::where('product_code', '=', $productId)->get(['products.*']);
		return $productsArray;
	}

	public function ProductKeyUp(Request $request)
	{
		$productID = $request->get('product_ID');
		$productsArray = Product::where('id', '=', $productID)->get(['products.*']);
		//$productsArray = Product::where('product_name', 'like', '%'.$productName.'%')->get(['products.*']);
		return $productsArray;
	}

	public function print_purchase($id)
	{
		$logo = SystemLogo::where('id', '=', 1)->get();
		$detail = Purchase::with(['purchase_details' => function ($query) {
			$query->with('unit');
			$query->with('purchase_tax');
			$query->with('products');
		}])
			->with('parties')
			->where('purchases.id', '=', $id)
			->get();
		//return $detail;
		$purchase_detail = $detail[0];
		//return $purchase_detail;
		return view('purchases.print', compact('purchase_detail', 'logo'));
	}

	public function grnMouseUp(Request $request)
	{
		$grnNo = $request->get('grn_no');
		$purchases = GRNDetails::join('grns', 'grns.id', '=', 'grn_details.grn_id')
			->join('products', 'products.id', '=', 'grn_details.product_id')
			->join('parties', 'parties.id', '=', 'grns.account_id')
			//->join('taxes', 'taxes.id', '=', 'grn_details.tax_id')
			->where('grns.grn_no', '=', $grnNo)->get();
		return $purchases;
	}

	public function ImportExcel(Request $request)
	{
		$this->validate($request, [
			'import_file' => 'required'
		]);
		$path = $request->file('import_file')->getRealPath();
		$results = Excel::load($path)->get();
		//return $results;
		if (!empty($results) && $results->count()) {
			foreach ($results as $row) {
				//foreach ($rows as $row) {
				if (($row->product_name) != null) {
					PurchaseDetail::create([
						'purchase_id'  => $row->purchase_id,
						'party_id'  => $row->party_id,
						'product_id'  => $row->product_id,
						'uom_id'  => $row->uom_id,
						'warehouse_id'  => $row->warehouse_id,
						'quantity'  => $row->quantity,
						'remaining_quantity'  => $row->remaining_quantity,
						'unit_cost'  => $row->unit_cost,
						'expiry'  => $row->expiry,
						'total_cost'  => $row->total_cost,
					]);
				}
				//}
			}
		}

		Session::flash('flash_message', 'Stock Sheet Imported Successfully!');
		return redirect('purchases/import-stock/create');
	}


	public function createImportExcel()
	{
		return view('purchases.import-stock.create');
	}
}