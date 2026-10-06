<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Tax;
use App\Models\Party;
use App\Models\Discount;
use App\Models\LCInformation;
use App\Models\LCInformatinDetail;
use App\Models\DeliveryChallan;
use App\Models\UOM;
use App\Models\Warehouse;
use App\Models\LCIndentor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LCInformationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
    }

    public function create()
    {
        $code = LCInformation::OrderBy('id', 'asc')->get();
        $codes = $code->last()->invoice_no + 1;
        $DeliveryChallan = DeliveryChallan::where('status', '=', 'Pending')->OrderBy('dcn_no', 'asc')->pluck('dcn_no', 'dcn_no')->prepend('Select Challan', '0')->toArray();
        // return $DeliveryChallan;
        $products = Product::select(DB::raw('CONCAT(`id`, "_", `product_name`) AS `id`, `product_name`'))->OrderBy('id', 'asc')->pluck('product_name', 'id')->prepend('Select Product', '0')->toArray();
        $taxes = Tax::select(DB::raw('CONCAT(`id`, "_", `tax_rate`) AS `tax_rate`, `tax_title`'))->OrderBy('id', 'asc')->pluck('tax_title', 'tax_rate')->toArray();
        $discounts = Discount::select(DB::raw('CONCAT(`id`, "_", `discount`) AS `discount`, `title`'))->OrderBy('id', 'asc')->pluck('title', 'discount')->toArray();
        //$discounts = Discount::OrderBy('id', 'asc')->pluck('title', 'id')->prepend('Select Discount', '0')->toArray();
        $customers = Party::join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
            ->where('parties.account_group_id', '=', '1')
            ->Orwhere('parties.account_group_id', '=', '8')
            ->OrderBy('party_name', 'asc')->pluck('party_name', 'parties.id')->prepend('Cash Customer', '1');
        //return $customers;
        $uoms = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))->OrderBy('id', 'asc')->pluck('uom', 'id')->prepend('PCS', '2_PCS')->toArray();
        //return $uoms;
        $warehouse = Warehouse::OrderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $indentor = LCIndentor::OrderBy('indentor_name', 'asc')->pluck('indentor_name', 'id')->toArray();
        $banks = Party::join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
            ->where('parties.account_group_id', '=', '5')
            ->OrderBy('party_name', 'asc')->pluck('party_name', 'parties.id')->prepend('Select Bank', '1');
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        //return $products;
        return view('lc.lc-info.create', Compact('customers', 'products', 'codes', 'taxes', 'discounts', 'DeliveryChallan', 'encrypted_token', 'uoms', 'warehouse', 'banks', 'indentor'));
    }

    public function store(Request $request)
    {
        //return $request->all();
        $lcInfo = LCInformation::create($request->all());


        $count = Count($request->product_code);
        for ($i = 0; $i < $count; $i++) {
            if ($request->product_code[$i] != null) {
                $lcDetail = new LCInformatinDetail();
                $lcDetail->lc_info_id = $lcInfo['id'];
                $lcDetail->product_id =  $request->product_id[$i];
                $lcDetail->party_id =  $request->party_id[$i];
                $lcDetail->uom_id =  $request->uom_id[$i];
                $lcDetail->qty_mt =  $request->qty_mt[$i];
                $lcDetail->qty_kg =  $request->qty_kg[$i];
                $lcDetail->us_rate =  $request->us_rate[$i];
                $lcDetail->rs_rate =  $request->rs_rate[$i];
                $lcDetail->us_amount =  $request->us_amount[$i];
                $lcDetail->rs_amount =  $request->rs_amount[$i];
                $lcDetail->save();

                // $vouchers = new LedgerDetailWise();
                //  $vouchers->lc_id = $lcDetail['id'];
                //  $vouchers->party_id =  $request->bank_id;
                //  $vouchers->voucher_no = $request->voucher_no;
                //  $vouchers->voucher_type = "LC Information";
                //  $vouchers->date = $request->lc_date;
                //  $vouchers->product_id = $request->product_id[$i];
                //  $vouchers->quantity = $request->qty_kg[$i];
                //  $vouchers->rate = $request->rs_rate[$i];
                //  $vouchers->credit = $request->MarginAmount;
                //  $vouchers->save();
            }
            // $vouchers = new GeneralVoucher();
            // $vouchers->lc_id = $lcDetail['id'];
            // $vouchers->account_head_id = $request->bank_id;
            // $vouchers->date = $request->lc_date;
            // $vouchers->voucher_no = $request->voucher_no;
            // $vouchers->v_type = "LC Information";
            // $vouchers->credit = $request->MarginAmount;
            // $vouchers->save();
        }
        Session::flash('flash_message', 'LC Information Addad Successfully!');
        return redirect('lc-info/create');

        // foreach($products as $product)
        // {
        //     $lcDetail = new SaleDetail();
        //     $lcDetail->lc_info_id = $lcInfo['id'];
        //     $lcDetail->product_id = $product['product_id'];
        //     $lcDetail->party_id = $product['party_id'];
        //     $lcDetail->uom_id = $product['uom_id'];
        //     $lcDetail->qty_mt = $product['qty_mt'];
        //     $lcDetail->qty_kg = $product['qty_kg'];
        //     $lcDetail->us_rate = $product['us_rate'];
        //     $lcDetail->rs_rate = $product['rs_rate'];
        //     $lcDetail->us_amount = $purchaseData['us_amount'];
        //     $lcDetail->rs_amount = $product['rs_amount'];         
        //     $lcDetail->save();


        // }
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
