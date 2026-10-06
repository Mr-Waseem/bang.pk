<?php

namespace App\Http\Controllers;

use App\Models\AccountGroup;
use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\GeneralVoucher;
use App\Models\Setting;
use App\Models\LedgerDetailWise;
use App\Models\Vouchers;
use App\Models\SystemLogo;
use App\Models\CashBook;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class GeneralVoucherController extends Controller
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
        $Vouchers = Vouchers::with(['voucher_details' => function ($query) {
            //$query->with('products');
            //$query->with('uoms');
            //$query->with('discount');
        }])
            // ->with('parties')
            ->where('vouchers.v_type', 'Journal Voucher')
            ->where('company_id', session()->get('company_id'))
            ->orderBy('voucher_no', 'desc')
            ->get();

        return view('general-voucher.index', Compact('encrypted_token', 'Vouchers'));
    }

    public function create()
    {
        $codes = 1;
        // $code = Vouchers::where('company_id',session()->get('company_id'))->OrderBy('id', 'desc')->first();
        $code = Vouchers::where('v_type', 'Journal Voucher')->where('company_id',session()->get('company_id'))
        ->OrderBy('id', 'desc')->first();
        //return $code;
        if(isset($code)>0)
        {
            $codes = (int)$code->voucher_no + 1;
        }
        $Heads = Party::select(DB::raw('CONCAT(`id`, "_", `party_name`) AS `id`, `party_name`'))
            ->where('company_id', session()->get('company_id'))
            ->OrderBy('party_name', 'asc')
            ->pluck('party_name', 'id')
            ->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());

        $accountGroups = AccountGroup::OrderBy('name','asc')->pluck('name','id');


        return view('general-voucher.create', compact('encrypted_token', 'Heads', 'codes','accountGroups'));
    }

    public function store(Request $request)
    {
        // return $request->all();
        $voucher = json_decode($request->get('voucher'), true);
        //return $voucher;
        //$voucher['date'] = date('Y-m-d',strtotime($voucher['date'])); 
        $voucherData = Vouchers::create($voucher);
        $products = $request->get('product_data');
        foreach ($products as $product) {
            $purchaseDetail = new GeneralVoucher();
            $purchaseDetail->transaction_id = $voucherData['id'];
            $purchaseDetail->account_head_id = $product['head_id'];
            $purchaseDetail->date = $product['date'];
            $purchaseDetail->voucher_no = $product['voucher_no'];
            $purchaseDetail->v_type = $product['v_type'];
            $purchaseDetail->narration = $product['narration'];
            $purchaseDetail->debit = $product['debit'];
            $purchaseDetail->credit = $product['credit'];
            $purchaseDetail->company_id = $product['company_id'];
            $purchaseDetail->save();

            // $vouchers = new LedgerDetailWise();
            // $vouchers->transaction_id = $voucherData['id'];
            // $vouchers->party_id = $product['head_id'];
            // $vouchers->voucher_no = $product['voucher_no'];
            // $vouchers->voucher_type = $product['v_type'];
            // $vouchers->date = $product['date'];
            // $vouchers->other = $product['narration'];
            // $vouchers->debit = $product['debit'];
            // $vouchers->credit = $product['credit'];
            // $vouchers->company_id = $product['company_id'];
            // $vouchers->save();

            // if (($product['head_id']) == "1") {
            //     $cash = new CashBook();
            //     $cash->date = $product['date'];
            //     $cash->vr_no = $product['voucher_no'];
            //     $cash->vr_type = "OPENING BALANCE";
            //     $cash->party_id = $product['head_id'];
            //     $cash->jv_id = $voucherData['id'];
            //     $cash->in = $product['debit'];
            //     $cash->company_id = $product['company_id'];
            //     $cash->save();
            // }
        }
        //return $purchaseData['id'];
        return "saved";
    }

    public function report(Request $request)
    {
        $LedgerID = $request->get('ledger_id');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        $GeneralVoucher = GeneralVoucher::join('parties', 'parties.id', '=', 'general_vouchers.account_head_id')
            ->where('general_vouchers.account_head_id', '=', $LedgerID)
            ->whereBetween('date', [$fromDate, $toDate])
            ->where('general_vouchers.v_type', '=', 'General Voucher')
            ->where('company_id', session()->get('company_id'))
            ->OrderBy('general_vouchers.id')
            ->get();
        //return $GeneralVoucher;
        $company_detail = Setting::where('id', '=', 1)->get();
        //return $GeneralVoucher;
        return view('general-voucher.report', compact('GeneralVoucher', 'company_detail'));
    }

    public function show($id)
    {
        $newsale_detail = Vouchers::with(['voucher_details' => function ($query) {
            //$query->with('products');
            //$query->with('uoms');
            $query->where('v_type', '=', 'Journal Voucher');
            $query->with('banks');
            $query->with('parties');
        }])->with('parties')
            ->where('vouchers.id', '=', $id)
            ->where('company_id', session()->get('company_id'))
            // ->orwhere('voucher_details.credit', '!=', null)
            ->get();
        //return $newsale_detail;
        $company_detail = Setting::where('id', '=', 1)->get();
        $logo = SystemLogo::where('id', '=', 1)->get();
        //return $newsale_detail;
        return view('general-voucher.print', compact('newsale_detail', 'company_detail', 'logo'));
    }

    public function edit($id)
    {
        $purchase = Vouchers::with(['voucher_details' => function ($query) {
            //$query->with('products');
            //$query->with('uoms');
            $query->where('company_id', session()->get('company_id'));
            $query->with('parties:id,party_name,code,account_group_id');
        }])->with('parties')->where('vouchers.id', '=', $id)
            ->where('v_type', 'Journal Voucher')
            ->where('company_id', session()->get('company_id'))
            // ->orwhere('voucher_details.credit', '!=', null)
            ->get();
         $edit = $purchase[0];
        //$company_detail = Setting::where('id', '=', 1)->get();
        //$logo = SystemLogo::where('id', '=', 1)->get();
        //return $edit;
        $code = Vouchers::OrderBy('id', 'asc')->get();
        //return $code;
        $codes = $code->last()->voucher_no + 1;
        $cashAccount = Party::select(DB::raw('CONCAT(`id`, "_", `party_name`) AS `id`, `party_name`'))
            ->where('id', '=', 4)
            ->where('company_id', session()->get('company_id'))
            ->OrderBy('party_name', 'asc')
            ->pluck('party_name', 'id')
            ->prepend('CASH IN HAND', '4_CASH IN HAND')
            ->toArray();
        $Heads = Party::select(DB::raw('CONCAT(`id`, "_", `party_name`) AS `id`, `party_name`'))
            ->where('company_id', session()->get('company_id'))
            ->OrderBy('party_name', 'asc')
            ->pluck('party_name', 'id')
            ->toArray();
        $Accounts = Party::select(DB::raw('CONCAT(`id`, "_", `party_name`) AS `id`, `party_name`'))
            ->where('company_id', session()->get('company_id'))
            ->OrderBy('party_name', 'asc')
            ->pluck('party_name', 'id')
            ->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());

        $accountGroups = AccountGroup::OrderBy('name','asc')->pluck('name','id');


        return view('general-voucher.edit', compact('edit', 'codes', 'cashAccount', 'Accounts', 'encrypted_token', 'Heads','accountGroups'));
    }

    public function update(Request $request, $id)
    {
        // return $request->all();

        $voucherData = Vouchers::findOrFail($id);

        $voucherData->update($request->only([
            'voucher_no',
            'voucher_date',
            'v_type',
            'company_id',
            'account_from_id',
            'account_id',
            'shop_id',
            'postdated_id',
            'tax',
        ]));

        GeneralVoucher::where('transaction_id', $id)
            ->where('company_id', $request->company_id)
            ->delete();

        $accountHeadIds = $request->input('account_head_id', []);
        $dates = $request->input('date', []);
        $narrations = $request->input('narration', []);
        $debits = $request->input('debit', []);
        $credits = $request->input('credit', []);

        $count = count($accountHeadIds);
        for ($i = 0; $i < $count; $i++) {
            $purchaseDetail = new GeneralVoucher();
            $purchaseDetail->transaction_id = $voucherData->id;
            $purchaseDetail->account_head_id = $accountHeadIds[$i];
            $purchaseDetail->date = $dates[$i] ?? null;
            $purchaseDetail->voucher_no = $voucherData->voucher_no;
            $purchaseDetail->v_type = $voucherData->v_type;
            $purchaseDetail->narration = $narrations[$i] ?? null;
            $purchaseDetail->debit = $debits[$i] ?? 0;
            $purchaseDetail->credit = $credits[$i] ?? 0;
            $purchaseDetail->company_id = $request->company_id;
            $purchaseDetail->save();

            // $purchaseDetail = new GeneralVoucher();
            // $purchaseDetail->transaction_id = $voucherData['id'];
            // $purchaseDetail->account_head_id = $product['head_id'];
            // $purchaseDetail->date = $product['date'];
            // $purchaseDetail->voucher_no = $product['voucher_no'];
            // $purchaseDetail->v_type = $product['v_type'];
            // $purchaseDetail->narration = $product['narration'];
            // $purchaseDetail->debit = $product['debit'];
            // $purchaseDetail->credit = $product['credit'];
            // $purchaseDetail->company_id = $product['company_id'];
            // $purchaseDetail->save();

            // $vouchers = new LedgerDetailWise();
            // $vouchers->voucher_id = $voucherData['id'];
            // $vouchers->party_id = $request->account_head_id[$i];
            // $vouchers->voucher_no = $voucherData['voucher_no'];
            // $vouchers->voucher_type = $voucherData['v_type'];
            // $vouchers->date = $request->date[$i];
            // $vouchers->other = $request->narration[$i];
            // $vouchers->debit = $request->debit[$i];
            // $vouchers->credit = $request->credit[$i];
            // $vouchers->save();

            // if (($request->account_head_id[$i]) == "1") {
            //     $cash = new CashBook();
            //     $cash->date = $request->date[$i];
            //     $cash->vr_no = $voucherData['voucher_no'];
            //     $cash->vr_type = "OPENING BALANCE";
            //     $cash->party_id = $request->account_head_id[$i];
            //     $cash->jv_id = $voucherData['id'];
            //     $cash->in = $request->debit[$i];
            //     $cash->save();
            // }
        }

        Session::flash('flash_message', 'JV Updated Successfully!');
        return redirect('general-voucher');
        // return $purchaseData['id'];
        //return "inserted";
    }

    public function destroy($id)
    {
        $delete = Vouchers::findOrFail($id);
        $delete->delete();
        // GeneralVoucher::where('transaction_id', '=', $id)->delete();
        GeneralVoucher::where('transaction_id', '=', $id)
        ->where('v_type', "Journal Voucher")
        // ->where('company_id', $request->company_id)
        ->where('company_id', session()->get('company_id'))
        ->delete();
        Session::flash('flash_message', 'JV deleted Successfully!');
        return redirect()->back();
        // LedgerDetailWise::where('transaction_id', '=', $id)->delete();
        // CashBook::where('jv_id', '=', $id)->delete();
        // Ledger::where('sale_id', '=', $id)->delete();       
        return "General Voucher has been Deleted Successfully!";
    }
}
