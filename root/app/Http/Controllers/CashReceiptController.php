<?php

namespace App\Http\Controllers;

use App\Models\AccountGroup;
use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\CashReceipt;
use App\Models\Vouchers;
use App\Models\Setting;
use App\Models\GeneralVoucher;
use App\Models\LedgerDetailWise;
use App\Models\SystemLogo;
use App\Models\CashBook;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CashReceiptController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $Heads = Party::OrderBy('party_name', 'asc')
            ->where('company_id', session()->get('company_id'))
            ->pluck('party_name', 'id')
            ->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());

        // return session()->get('company_id');

        $Vouchers = Vouchers::with(['voucher_details' => function ($query) {
            //$query->with('products');
            //$query->with('uoms');
            //$query->with('discount');
            // $query->where('company_id', session()->get('company_id'))->get();
        }])
            ->with(['parties'])
            ->with('billers')
            ->where('company_id', session()->get('company_id'))
            ->where('vouchers.v_type', 'Cash Receipt')
            ->get();


        return view('cash-receipts.index', compact('encrypted_token', 'Vouchers'));
    }

    public function create()
    {
        $codes = 1;
        // return $code;
        $code = Vouchers::where('v_type', 'Cash Receipt')->where('company_id',session()->get('company_id'))
        ->OrderBy('id', 'desc')->first();
        if(isset($code)>0)
        {
            $codes = (int)$code->voucher_no + 1;
        }

        $cashAccount = Party::select(DB::raw('CONCAT(`id`, "_", `party_name`) AS `id`, `party_name`'))
             ->where('account_group_id', '=', 3)
            // ->where('party_name', '=', 'CASH IN HAND')
            ->where('company_id', session()->get('company_id'))
            ->OrderBy('party_name', 'asc')
            ->pluck('party_name', 'id')
            ->prepend('Select Account','')
            ->toArray();

        $Accounts = Party::select(DB::raw('CONCAT(`id`, "_", `party_name`) AS `id`, `party_name`'))
            ->where('company_id', session()->get('company_id'))
            ->where('id', '!=', 1)
            ->OrderBy('party_name', 'asc')
            ->pluck('party_name', 'id')
            ->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());

        $titles = array(
            'Income Tax' => 'Income Tax', 'W.H Tax' => 'W.H Tax', 'Exempt' => 'Exempt',
            'Commercial importer' => 'Commercial importer', 'Zero Rated' => 'Zero Rated', 'Undertaking' => 'Undertaking', 'Not Deducted' => 'Not Deducted'
        );

        $accountGroups = AccountGroup::OrderBy('name','asc')->pluck('name','id');


        return view('cash-receipts.create', compact('encrypted_token', 'cashAccount', 'Accounts', 'codes', 'titles','accountGroups'));
    }

    public function store(Request $request)
    {
        $voucher = json_decode($request->get('voucher'), true);
        //return $voucher;
        //$voucher['date'] = date('Y-m-d',strtotime($voucher['date'])); 
        $voucherData = Vouchers::create($voucher);
        $products = $request->get('product_data');
        foreach ($products as $product) {
            // Cash Account value without tax
            $purchaseDetail = new GeneralVoucher();
            $purchaseDetail->transaction_id = $voucherData['id'];
            $purchaseDetail->account_head_id = $voucherData['account_id'];
            $purchaseDetail->head_id = $product['head_id'];
            $purchaseDetail->warehouse_id = $voucherData['shop_id'];
            $purchaseDetail->date = $product['date'];
            $purchaseDetail->voucher_no = $product['voucher_no'];
            $purchaseDetail->v_type = $product['v_type'];
            $purchaseDetail->narration = $product['narration'];
            $purchaseDetail->debit = $product['amount'];
            $purchaseDetail->tax = $product['tax'];
            $purchaseDetail->company_id = $product['company_id'];
            $purchaseDetail->save();
            // Cash Account tax value
            $purchaseDetail = new GeneralVoucher();
            $purchaseDetail->transaction_id = $voucherData['id'];
            // $purchaseDetail->account_head_id = $voucherData['account_id'];
            $purchaseDetail->account_head_id = 3;
            $purchaseDetail->head_id = $product['head_id'];
            $purchaseDetail->warehouse_id = $voucherData['shop_id'];
            $purchaseDetail->date = $product['date'];
            $purchaseDetail->voucher_no = $product['voucher_no'];
            $purchaseDetail->v_type = $product['v_type'];
            $purchaseDetail->narration = $product['title'];
            $purchaseDetail->debit = $product['taxAmount'];
            $purchaseDetail->tax = $product['tax'];
            $purchaseDetail->company_id = $product['company_id'];
            $purchaseDetail->save();

            // Below Account value without tax
            $purchaseDetail = new GeneralVoucher();
            $purchaseDetail->transaction_id = $voucherData['id'];
            $purchaseDetail->account_head_id = $product['head_id'];
            $purchaseDetail->head_id = $voucherData['account_id'];
            $purchaseDetail->warehouse_id = $voucherData['shop_id'];
            $purchaseDetail->date = $product['date'];
            $purchaseDetail->voucher_no = $product['voucher_no'];
            $purchaseDetail->v_type = $product['v_type'];
            $purchaseDetail->narration = $product['narration'];
            $purchaseDetail->credit = $product['amount'];
            $purchaseDetail->tax = $product['tax'];
            $purchaseDetail->company_id = $product['company_id'];
            $purchaseDetail->save();
            // Below Account tax value
            $purchaseDetail = new GeneralVoucher();
            $purchaseDetail->transaction_id = $voucherData['id'];
            $purchaseDetail->account_head_id = $product['head_id'];
            $purchaseDetail->head_id = 3;
            $purchaseDetail->warehouse_id = $voucherData['shop_id'];
            $purchaseDetail->date = $product['date'];
            $purchaseDetail->voucher_no = $product['voucher_no'];
            $purchaseDetail->v_type = $product['v_type'];
            $purchaseDetail->narration = $product['title'];
            $purchaseDetail->credit = $product['taxAmount'];
            $purchaseDetail->tax = $product['tax'];
            $purchaseDetail->company_id = $product['company_id'];
            $purchaseDetail->save();



            // $vouchers = new LedgerDetailWise();
            // $vouchers->transaction_id = $voucherData['id'];
            // $vouchers->party_id = $voucherData['account_id'];
            // $vouchers->warehouse_id = $voucherData['shop_id'];
            // $vouchers->voucher_no = $product['voucher_no'];
            // $vouchers->voucher_type = "Cash Receipt";
            // $vouchers->date = $product['date'];
            // $vouchers->other = $product['narration'];
            // $vouchers->debit = $product['amount'];
            // $vouchers->company_id = $product['company_id'];
            // $vouchers->head_id = $product['head_id'];
            // $vouchers->save();


            // $vouchers = new LedgerDetailWise();
            // $vouchers->transaction_id = $voucherData['id'];
            // $vouchers->party_id = 3;
            // $vouchers->warehouse_id = $voucherData['shop_id'];
            // $vouchers->voucher_no = $product['voucher_no'];
            // $vouchers->voucher_type = "Cash Receipt";
            // $vouchers->date = $product['date'];
            // $vouchers->other = $product['title'];
            // $vouchers->debit = $product['taxAmount'];
            // $vouchers->company_id = $product['company_id'];
            // $vouchers->head_id = $product['head_id'];
            // $vouchers->save();

            // $vouchers = new LedgerDetailWise();
            // $vouchers->transaction_id = $voucherData['id'];
            // $vouchers->party_id = $product['head_id'];
            // $vouchers->warehouse_id = $voucherData['shop_id'];
            // $vouchers->voucher_no = $product['voucher_no'];
            // $vouchers->voucher_type = "Cash Receipt";
            // $vouchers->date = $product['date'];
            // $vouchers->other = $product['narration'];
            // $vouchers->credit = $product['amount'];
            // $vouchers->company_id = $product['company_id'];
            // $vouchers->head_id = $product['head_id'];
            // $vouchers->save();

            // $vouchers = new LedgerDetailWise();
            // $vouchers->transaction_id = $voucherData['id'];
            // $vouchers->party_id = $product['head_id'];
            // $vouchers->warehouse_id = $voucherData['shop_id'];
            // $vouchers->voucher_no = $product['voucher_no'];
            // $vouchers->voucher_type = "Cash Receipt";
            // $vouchers->date = $product['date'];
            // $vouchers->other = $product['title'];
            // $vouchers->credit = $product['taxAmount'];
            // $vouchers->company_id = $product['company_id'];
            // $vouchers->head_id = $product['head_id'];
            // $vouchers->save();

            // $cash = new CashBook();
            // $cash->date = $product['date'];
            // $cash->vr_no =  $product['voucher_no'];
            // $cash->vr_type = $product['v_type'];
            // $cash->biller_id = Auth::User()->id;
            // // $cash->shop_id = Auth::User()->shop_id;
            // $cash->shop_id = $voucherData['shop_id'];
            // $cash->party_id = $product['head_id'];
            // $cash->cash_receipt_id = $voucherData['id'];
            // $cash->description = $product['narration'];
            // $cash->in = $product['amount'];
            // $cash->company_id = $product['company_id'];
            // $cash->save();
        }
        //return $purchaseData['id'];
        return $voucherData['id'];
    }

    public function report(Request $request)
    {
        $HeadID = $request->get('head_id');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        $GeneralVoucher = CashReceipt::join('parties', 'parties.id', '=', 'cash_receipts.account_head_id')
            ->where('cash_receipts.account_head_id', '=', $HeadID)
            ->whereBetween('date', [$fromDate, $toDate])
            ->OrderBy('cash_receipts.id')
            ->get();

        $company_detail = Setting::where('id', '=', 1)->get();
        //return $GeneralVoucher;
        return view('cash-receipts.report', compact('GeneralVoucher', 'company_detail'));
    }

    public function show($id)
    {
        $newsale_detail = Vouchers::with(['voucher_details' => function ($query) {
            //$query->with('products');
            //$query->with('uoms');
            $query->where('v_type', '=', 'Cash Receipt');
            $query->with('parties');
        }])
            ->with('parties')
            ->where('vouchers.id', '=', $id)
            // ->where('company_id', session()->get('company_id'))
            // ->orwhere('voucher_details.credit', '!=', null)
            ->get();
        $company_detail = Setting::where('id', '=', 1)->get();
        $logo = SystemLogo::where('id', '=', 1)->get();
        //return $newsale_detail;
        return view('cash-receipts.print', compact('newsale_detail', 'company_detail', 'logo'));
    }

    public function edit($id)
    {
        $purchase = Vouchers::with(['voucher_details' => function ($query) {
            $query->with('parties:id,party_name,code,account_group_id');
        }])
            ->with('parties')
            ->where('vouchers.id', '=', $id)
            ->where('company_id', '=', session()->get('company_id'))
            ->get();
        $edit = $purchase[0];
        $code = Vouchers::OrderBy('id', 'asc')->get();
        $codes = $code->last()->voucher_no + 1;
        $cashAccount = Party::select(DB::raw('CONCAT(`id`, "_", `party_name`) AS `id`, `party_name`'))->where('id', '=', 1)->OrderBy('party_name', 'asc')->pluck('party_name', 'id')->toArray();

        $Accounts = Party::select(DB::raw('CONCAT(`id`, "_", `party_name`) AS `id`, `party_name`'))->where('id', '!=', 1)->OrderBy('party_name', 'asc')->pluck('party_name', 'id')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());

        $titles = array(
            'Income Tax' => 'Income Tax', 'W.H Tax' => 'W.H Tax', 'Exempt' => 'Exempt',
            'Commercial importer' => 'Commercial importer', 'Zero Rated' => 'Zero Rated', 'Undertaking' => 'Undertaking', 'Not Deducted' => 'Not Deducted'
        );

        $accountGroups = AccountGroup::OrderBy('name','asc')->pluck('name','id');

        return view('cash-receipts.edit', compact('edit', 'codes', 'cashAccount', 'Accounts', 'encrypted_token','accountGroups', 'titles'));
    }

    public function update(Request $request, $id)
    {
        $voucherData = Vouchers::findOrFail($id);
        $voucher = json_decode($request->get('voucher'), true);
        $voucherData->account_id = $voucher['account_id'];
        $voucherData->voucher_date = date('Y-m-d', strtotime($voucher['voucher_date']));
        $voucherData->voucher_no = $voucher['voucher_no'];
        $voucherData->company_id = $voucher['company_id'];
        $voucherData->save();
        GeneralVoucher::where('transaction_id', '=', $id)->where('v_type', 'Cash Receipt')->delete();
        $products = $request->get('product_data', []);
        
        foreach ($products as $product) {
            // Cash Account value without tax
            $purchaseDetail = new GeneralVoucher();
            $purchaseDetail->transaction_id = $voucherData->id;
            $purchaseDetail->account_head_id = $voucherData->account_id;
            $purchaseDetail->head_id = $product['head_id'];
            $purchaseDetail->warehouse_id = $voucherData->shop_id;
            $purchaseDetail->date = $product['date'];
            $purchaseDetail->voucher_no = $product['voucher_no'];
            $purchaseDetail->v_type = $product['v_type'];
            $purchaseDetail->narration = $product['narration'];
            $purchaseDetail->debit = $product['amount'];
            $purchaseDetail->tax = $product['tax'] ?? 0;
            $purchaseDetail->company_id = $product['company_id'];
            $purchaseDetail->save();
            // Cash Account tax value
            $purchaseDetail = new GeneralVoucher();
            $purchaseDetail->transaction_id = $voucherData->id;
            $purchaseDetail->account_head_id = 3;
            $purchaseDetail->head_id = $product['head_id'];
            $purchaseDetail->warehouse_id = $voucherData->shop_id;
            $purchaseDetail->date = $product['date'];
            $purchaseDetail->voucher_no = $product['voucher_no'];
            $purchaseDetail->v_type = $product['v_type'];
            $purchaseDetail->narration = $product['title'];
            $purchaseDetail->debit = $product['taxAmount'] ?? 0;
            $purchaseDetail->tax = $product['tax'] ?? 0;
            $purchaseDetail->company_id = $product['company_id'];
            $purchaseDetail->save();

            // Below Account value without tax
            $purchaseDetail = new GeneralVoucher();
            $purchaseDetail->transaction_id = $voucherData->id;
            $purchaseDetail->account_head_id = $product['head_id'];
            $purchaseDetail->head_id = $voucherData->account_id;
            $purchaseDetail->warehouse_id = $voucherData->shop_id;
            $purchaseDetail->date = $product['date'];
            $purchaseDetail->voucher_no = $product['voucher_no'];
            $purchaseDetail->v_type = $product['v_type'];
            $purchaseDetail->narration = $product['narration'];
            $purchaseDetail->credit = $product['amount'];
            $purchaseDetail->tax = $product['tax'] ?? 0;
            $purchaseDetail->company_id = $product['company_id'];
            $purchaseDetail->save();
            // Below Account tax value
            $purchaseDetail = new GeneralVoucher();
            $purchaseDetail->transaction_id = $voucherData->id;
            $purchaseDetail->account_head_id = $product['head_id'];
            $purchaseDetail->head_id = 3;
            $purchaseDetail->warehouse_id = $voucherData->shop_id;
            $purchaseDetail->date = $product['date'];
            $purchaseDetail->voucher_no = $product['voucher_no'];
            $purchaseDetail->v_type = $product['v_type'];
            $purchaseDetail->narration = $product['title'];
            $purchaseDetail->credit = $product['taxAmount'] ?? 0;
            $purchaseDetail->tax = $product['tax'] ?? 0;
            $purchaseDetail->company_id = $product['company_id'];
            $purchaseDetail->save();
        }
        return $voucherData['id'];
    }

    public function destroy($id)
    {
        $delete = Vouchers::findOrFail($id);
        $delete->delete();
        GeneralVoucher::where('transaction_id', '=', $id)->where('v_type', 'Cash Receipt')->delete();
        // LedgerDetailWise::where('transaction_id', '=', $id)->where('voucher_type', 'Cash Receipt')->delete();
        CashBook::where('cash_receipt_id', '=', $id)->delete();
        // Ledger::where('sale_id', '=', $id)->delete();       
        return "Cash Receipt has been Deleted Successfully!";
    }

    public function GetAccountGroupParties(Request $request)
    {
        $accountGroupId = $request->id;
        $accountGroup = AccountGroup::find($accountGroupId);
        // return $accountGroup->name;
        $parties = Party::
        where(function($query) use($accountGroupId, $accountGroup){
            $query->where('account_group_id', $accountGroupId);
            $query->where('company_id',session()->get('company_id'));
          if($accountGroup->name == "PURCHASES"){
            $query->Orwhere('account_type', 'PURCHASES');
          }
          if($accountGroup->name == "SALES"){
            $query->Orwhere('account_type', 'SALES');
          }
          if($accountGroup->name == "ADVANCE INCOME TAX"){
            $query->Orwhere('account_type', 'ADVANCE INCOME TAX');
          }
          if($accountGroup->name == "STOCK INVENTORY"){
            $query->Orwhere('account_type', 'STOCK INVENTORY');
          }
           
        })
        ->get();
        return response()->json($parties);


        //  $accountGroupId = $request->id;
        // $accountGroup = AccountGroup::find($accountGroupId);
        // $parties = Party::
        // where(function($query) use($accountGroup){
        //     if($accountGroup->name=="PURCHASES")
        //     {
        //         $query->where('account_group_id',$accountGroup->id)
        //         ->where('company_id',session()->get('company_id'))
        //         ->OrwhereIN('account_type',['PURCHASES']);
        //     }
        //     else{
        //         $query->where('account_group_id',$accountGroup->id)
        //         ->where('company_id',session()->get('company_id'))
        //         ->where('account_type','!=','PURCHASES');
                
        //     }
        // })
        // ->get();
        // return response()->json($parties);
    }
}
