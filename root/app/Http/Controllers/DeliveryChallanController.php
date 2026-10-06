<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Party;
use App\Models\Companies;
use App\Models\DeliveryChallan;
use App\Models\DeliveryChallanDetail;
use App\Models\PurchaseDetail;
use App\Models\StockRegisterSpecificItem;
use App\Models\LedgerDetailWise;
use App\Models\SystemLogo;
use App\Models\UOM;
use Illuminate\Support\Facades\DB;
use Auth;
use Session;
class DeliveryChallanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $purchases = DeliveryChallan::where('type', 'DC')
        ->with('challan_details')->with('parties')
        ->OrderBy('delivery_challans.id', 'desc')->get();
        //return $purchases;
        //$purchases = $produsts[0];
        return view('delivery-challan.index', Compact('purchases'));
    }

    public function print_challan($id)
    {
        $detail = DeliveryChallan::with('parties')->with(['challan_details' => function ($query) {
            // $query->with('purchase_tax');
            $query->with('products');
        }])->where('delivery_challans.id', '=', $id)
        ->where('type', 'DC')->get();
        //return $detail;
        $purchase_detail = $detail[0];
        // return $logo = SystemLogo::where('id', '=', 1)->get();
        //return $purchase_detail;
         $companyID = session()->get('company_id');
         $company = Companies::with('user')->where('id', '=', $companyID)->first();
        return view('delivery-challan.print', Compact('purchase_detail', 'company'));
    }

    public function create()
    {
        $companyID = session()->get('company_id');
        $code = DeliveryChallan::where('company_id', $companyID)
        ->where('type', 'DC')
        ->OrderBy('id', 'desc')->first();
        // $codes = $code->last()->vr_no + 1;
        $codes = 1;
         if ($code) {
            $codes = (int)$code->vr_no + 1;
        }
        //$products = Product::OrderBy('product_name', 'asc')->pluck('product_name', 'id')->prepend('Select Product', '0')->toArray();
        // $taxes = Tax::select(DB::raw('CONCAT(`id`, "_", `tax_rate`) AS `tax_rate`, `tax_title`'))->OrderBy('id', 'asc')->pluck('tax_title', 'tax_rate')->toArray();
        // $products = Product::select(DB::raw('CONCAT(`id`, "_", `product_name`) AS `id`, `product_name`'))->OrderBy('id', 'asc')
        // ->where('company_id', $companyID)->pluck('product_name', 'id')->prepend("Select Product")->toArray();
        $products = Product::select(
                DB::raw('CONCAT(id, "_", product_code, "_", product_name, "_", tax) AS id'),
                DB::raw('CONCAT(product_code, " - ", product_name) AS product_name')
            )
            ->where('company_id', session()->get('company_id'))
            ->OrderBy('id', 'asc')
            ->pluck('product_name', 'id')
            ->prepend('Select Product', '0')->toArray();
        $parties = Party::where('account_type', 'Debtor')
        ->where('company_id', $companyID)->OrderBy('party_name', 'asc')->pluck('party_name', 'id')->prepend("Select Party", "");
        $uoms = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))->OrderBy('id', 'asc')->pluck('uom', 'id')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());

        return view('delivery-challan.create', Compact('parties', 'products', 'codes', 'uoms', 'encrypted_token'));
    }

    public function store(Request $request)
    {
          $this->validate($request, [
            'date' => 'required',
            // 'product_code' => 'required',
            'vr_no' => 'required',
            'party_id' => 'required'

        ]);
        // return $request;
        $companyID = session()->get('company_id');

        $code = DeliveryChallan::where('company_id', $companyID)
        ->where('type', 'DC')
                ->OrderBy('id', 'desc')->first();
                // $codes = $code->last()->vr_no + 1;
                $codes = 1;
                if ($code) {
                    $codes = (int)$code->vr_no + 1;
                }
        // return $codes;
            $purchaseData = new DeliveryChallan();
            $purchaseData->company_id = $companyID;
            $purchaseData->party_id = $request->party_id;
            $purchaseData->vr_no = $codes;
            $purchaseData->type = "DC";
            $purchaseData->date = $request->date;
            $purchaseData->remarks = $request->remarks;
            $purchaseData->po_no = $request->po_no;
            $purchaseData->vehicle_no = $request->vehicle_no;
            $purchaseData->driver_name = $request->driver_name;
            $purchaseData->driver_phone = $request->driver_phone;
            $purchaseData->biller_id = Auth::User()->id;
            $purchaseData->save();
            $sum = "0";
            $count = count($request->product_id1);
            for ($i = 0; $i < $count; $i++) {
                $purchaseDetail = new DeliveryChallanDetail();
                $purchaseDetail->date = $purchaseData->date;
                $purchaseDetail->company_id = $companyID;
                $purchaseDetail->challan_id = $purchaseData->id;
                $purchaseDetail->product_id = $request->product_id1[$i];
                $purchaseDetail->uom_id = $request->uom_id1[$i];
                $purchaseDetail->uom = $request->uom1[$i];
                $purchaseDetail->quantity = $request->quantity1[$i];
                $purchaseDetail->pack = $request->pack1[$i];
                $purchaseDetail->pack_qty = $request->pack_qty1[$i];
                $purchaseDetail->rate = $request->price1[$i];
                $purchaseDetail->amount = $request->amount1[$i];
                $purchaseDetail->save();
            }
            Session::flash('flash_message', 'Delivery Challan Successfully Saved.');
            return redirect('delivery-challan/create');



              
        // $purchaseData = DeliveryChallan::create($purchase);
        // $sum = "0";
        // foreach ($products as $product) {
        //     $purchaseDetail = new DeliveryChallanDetail();
        //     $purchaseDetail->challan_id = $purchaseData['id'];
        //     $purchaseDetail->product_id = $product['product_id'];
        //     $purchaseDetail->uom_id = $product['uom_id'];
        //     $purchaseDetail->quantity = $product['quantity'];
        //     $purchaseDetail->rate = $product['rate'];
        //     $purchaseDetail->amount = $product['amount'];
        //     $sum = $sum + $product['amount'];
        //     $purchaseDetail->save();

        //     $vouchers = new StockRegisterSpecificItem();
        //     $vouchers->dc_id = $purchaseData['id'];
        //     $vouchers->date = $purchaseData['date'];
        //     $vouchers->party_id = $purchaseData['party_id'];
        //     $vouchers->product_id = $product['product_id'];
        //     $vouchers->voucher_type = "Delivery Challan";
        //     $vouchers->sale_quantity = $product['quantity'];
        //     $vouchers->cost_rate = $product['amount'];
        //     $vouchers->save();

        //     $ledgerDetail = new LedgerDetailWise();
        //     $ledgerDetail->dc_id = $purchaseData['id'];
        //     $ledgerDetail->party_id = $purchaseData['party_id'];
        //     $ledgerDetail->voucher_no = $purchaseData['vr_no'];
        //     $ledgerDetail->voucher_type = $purchaseData['type'];
        //     $ledgerDetail->date = $purchaseData['date'];
        //     $ledgerDetail->product_id = $product['product_id'];
        //     $ledgerDetail->quantity = $product['quantity'];
        //     $ledgerDetail->rate = $product['rate'];
        //     $ledgerDetail->debit = $product['amount'];
        //     $ledgerDetail->save();


        //     $data = PurchaseDetail::where('product_id', '=', $purchaseDetail->product_id)->where('remaining_quantity', '!=', 0)->OrderBy('id', 'asc')->first();

        //     if ($purchaseDetail->quantity > $data->remaining_quantity) {
        //         $tot = (int) $purchaseDetail->quantity - (int) $data->remaining_quantity;
        //         $data->remaining_quantity = 0;
        //         $data->save();

        //         $data = PurchaseDetail::where('product_id', '=', $purchaseDetail->product_id)->where('remaining_quantity', '!=', 0)->OrderBy('id', 'asc')->first();
        //         $tot = (int)$data->remaining_quantity - (int)$tot;
        //         $data->remaining_quantity = $tot;
        //         $data->save();
        //     } else {
        //         $data->remaining_quantity =  (int) $data->remaining_quantity - (int) $purchaseDetail->quantity;
        //         $data->save();
        //     }
        // }
        // return $purchaseData['id'];
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $companyID = session()->get('company_id');
        $challans =  DeliveryChallan::with(['challan_details' => function ($query) {
            $query->with('products');
            $query->with('unit');
        }])->with('parties')->where('delivery_challans.id', '=', $id)->get();
        $edit = $challans[0];
        //return $edit;
        $products = Product::select(
                DB::raw('CONCAT(id, "_", product_code, "_", product_name, "_", tax) AS id'),
                DB::raw('CONCAT(product_code, " - ", product_name) AS product_name')
            )
            ->where('company_id', session()->get('company_id'))
            ->OrderBy('id', 'asc')
            ->pluck('product_name', 'id')
            ->prepend('Select Product', '0')->toArray();
        $parties = Party::where('account_type', 'Debtor')
        ->where('company_id', $companyID)->OrderBy('party_name', 'asc')->pluck('party_name', 'id')->prepend("Select Party", "");
        $uoms = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))->OrderBy('id', 'asc')->pluck('uom', 'id')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('delivery-challan.edit', Compact('edit', 'products', 'parties', 'uoms', 'encrypted_token'));
    }

    public function update(Request $request, $id)
    {
        // return $request;

           $this->validate($request, [
            'date' => 'required',
            // 'product_code' => 'required',
            'vr_no' => 'required',
            'party_id' => 'required'

        ]);
        // return $request;
        $companyID = session()->get('company_id');

        // return $id;
         $purchaseData = DeliveryChallan::where('id', $id)
        ->where('type', 'DC')->first();

        $purchaseData->company_id = $companyID;
            $purchaseData->party_id = $request->party_id;
            $purchaseData->vr_no = $request->vr_no;
            $purchaseData->type = "DC";
            $purchaseData->date = $request->date;
            $purchaseData->remarks = $request->remarks;
            $purchaseData->po_no = $request->po_no;
            $purchaseData->vehicle_no = $request->vehicle_no;
            $purchaseData->driver_name = $request->driver_name;
            $purchaseData->driver_phone = $request->driver_phone;
            $purchaseData->biller_id = Auth::User()->id;
            $purchaseData->save();
// return "DONE";
 DeliveryChallanDetail::where('challan_id', '=', $id)->delete();
        // StockRegisterSpecificItem::where('dc_id', '=', $id)->delete();
        // LedgerDetailWise::where('dc_id', '=', $id)->delete();
$count = count($request->product_id1);
            for ($i = 0; $i < $count; $i++) {
                $purchaseDetail = new DeliveryChallanDetail();
                $purchaseDetail->date = $purchaseData->date;
                $purchaseDetail->company_id = $companyID;
                $purchaseDetail->challan_id = $purchaseData->id;
                $purchaseDetail->product_id = $request->product_id1[$i];
                $purchaseDetail->uom_id = $request->uom_id1[$i];
                $purchaseDetail->uom = $request->uom1[$i];
                $purchaseDetail->quantity = $request->quantity1[$i];
                $purchaseDetail->pack = $request->pack1[$i];
                $purchaseDetail->pack_qty = $request->pack_qty1[$i];
                $purchaseDetail->rate = $request->price1[$i];
                $purchaseDetail->amount = $request->amount1[$i];
                
                $purchaseDetail->save();
            }
            Session::flash('flash_message', 'Delivery Challan Successfully Updated.');
            return redirect('delivery-challan');
        // $objPurchase->party_id = $purchase['party_id'];
        // $objPurchase->type = $purchase['type'];
        // $objPurchase->vr_no = $purchase['vr_no'];
        // $objPurchase->date = date('Y-m-d', strtotime($purchase['date']));
        // $objPurchase->outward_gpn = $purchase['outward_gpn'];
        // $objPurchase->status = $purchase['status'];
        // $objPurchase->save();
       
        //GeneralVoucher::where('sale_id', '=', $id)->delete();
        // $products = $request->get('details_data');
        //return $products;        
        // $purchaseData = DeliveryChallan::create($purchase);
        // $sum = "0";
        // foreach ($products as $product) {
        //     $purchaseDetail = new DeliveryChallanDetail();
        //     $purchaseDetail->challan_id = $objPurchase['id'];
        //     $purchaseDetail->product_id = $product['product_id'];
        //     $purchaseDetail->uom_id = $product['uom_id'];
        //     $purchaseDetail->quantity = $product['quantity'];
        //     $purchaseDetail->rate = $product['rate'];
        //     $purchaseDetail->amount = $product['amount'];
        //     $sum = $sum + $product['amount'];
        //     $purchaseDetail->save();

        //     $vouchers = new StockRegisterSpecificItem();
        //     $vouchers->dc_id = $objPurchase['id'];
        //     $vouchers->date = $objPurchase['date'];
        //     $vouchers->party_id = $objPurchase['party_id'];
        //     $vouchers->product_id = $product['product_id'];
        //     $vouchers->voucher_type = "Delivery Challan";
        //     $vouchers->sale_quantity = $product['quantity'];
        //     $vouchers->cost_rate = $product['amount'];
        //     $vouchers->save();

        //     $ledgerDetail = new LedgerDetailWise();
        //     $ledgerDetail->dc_id = $objPurchase['id'];
        //     $ledgerDetail->party_id = $objPurchase['party_id'];
        //     $ledgerDetail->voucher_no = $objPurchase['vr_no'];
        //     $ledgerDetail->voucher_type = $objPurchase['type'];
        //     $ledgerDetail->date = $objPurchase['date'];
        //     $ledgerDetail->product_id = $product['product_id'];
        //     $ledgerDetail->quantity = $product['quantity'];
        //     $ledgerDetail->rate = $product['rate'];
        //     $ledgerDetail->debit = $product['amount'];
        //     $ledgerDetail->save();

        //     $data = PurchaseDetail::where('product_id', '=', $purchaseDetail->product_id)->where('remaining_quantity', '!=', 0)->OrderBy('id', 'asc')->first();

        //     if ($purchaseDetail->quantity > $data->remaining_quantity) {
        //         $tot = (int) $purchaseDetail->quantity - (int) $data->remaining_quantity;
        //         $data->remaining_quantity = 0;
        //         $data->save();

        //         $data = PurchaseDetail::where('product_id', '=', $purchaseDetail->product_id)->where('remaining_quantity', '!=', 0)->OrderBy('id', 'asc')->first();
        //         $tot = (int)$data->remaining_quantity - (int)$tot;
        //         $data->remaining_quantity = $tot;
        //         $data->save();
        //     } else {
        //         $data->remaining_quantity =  (int) $data->remaining_quantity - (int) $purchaseDetail->quantity;
        //         $data->save();
        //     }
        // }
        // return $objPurchase['id'];
    }

    public function destroy($id)
    {
        $delete = DeliveryChallan::findOrFail($id);
        $delete->delete();
        DeliveryChallanDetail::where('challan_id', '=', $id)->delete();
        Session::flash('flash_message', 'DC deleted Successfully!');
    return redirect('delivery-challan');
        // StockRegisterSpecificItem::where('dc_id', '=', $id)->delete();
        // LedgerDetailWise::where('dc_id', '=', $id)->delete();
        return "Delivery Challan Deleted Successfully!";
    }

    public function ProductKeyUp(Request $request)
    {
        // return "saleems";
        $productID = $request->get('product_id');
        // $productsArray = Product::where('product_name', '=', $productName)->get(['products.*']);
        // $productName = Input::get('product');
        $data = Product::join('purchase_details', 'purchase_details.product_id', '=', 'products.id')
            ->where('product_id', '=', $productID)
            ->where('remaining_quantity', '!=', 0)
            ->OrderBy('purchase_details.id', 'asc')
            ->first(['products.*', 'purchase_details.remaining_quantity', 'purchase_details.unit_cost', 'purchase_details.total_cost']);
        //->first();
        $test[] = $data;
        return $test;
        //return $productsArray;
    }
}