<?php

namespace App\Http\Controllers;

use App\Models\AccountGroup;
use App\Models\Party;
use App\Models\BankPayment;
use App\Models\GeneralVoucher;
use App\Models\LedgerDetailWise;
use App\Models\Setting;
use App\Models\Vouchers;
use App\Models\SystemLogo;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BankPaymentController extends Controller
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
            ->with('parties')
            ->where('vouchers.v_type', 'Bank Payment')
            ->where('company_id', session()->get('company_id'))
            ->get();
        //return $Vouchers;
        return view('bank-payments.index', Compact('encrypted_token', 'Vouchers'));
    }

    public function create()
    {
        $code = Vouchers::where('v_type', 'Bank Payment')->where('company_id',session()->get('company_id'))
        ->OrderBy('id', 'desc')->first();
         $codes = 1;
        if(isset($code)>0)
        {
            $codes = (int)$code->voucher_no + 1;
        }

        $debitAccount = Party::select(DB::raw('CONCAT(`id`, "_", `party_name`) AS `id`, `party_name`'))
            ->where('account_group_id', '=', '6')
            ->where('company_id', session()->get('company_id'))
            ->OrderBy('party_name', 'asc')
            ->pluck('party_name', 'id')
            ->prepend('Select Account','')
            ->toArray();
        $Accounts = Party::select(DB::raw('CONCAT(`id`, "_", `party_name`) AS `id`, `party_name`'))
            ->where('account_group_id', '=', '6')
            ->where('company_id', session()->get('company_id'))
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


        return view('bank-payments.create', compact('encrypted_token', 'debitAccount', 'Accounts', 'codes', 'titles','accountGroups'));
    }

    public function store(Request $request)
    {
        $voucher = json_decode($request->get('voucher'), true);
        //return $voucher;
        //$voucher['date'] = date('Y-m-d',strtotime($voucher['date'])); 
        $voucherData = Vouchers::create($voucher);
        $products = $request->get('product_data');
        foreach ($products as $product) {
            // Top account | Credit account | Payment account
            $purchaseDetail = new GeneralVoucher();
            $purchaseDetail->transaction_id = $voucherData['id'];
            $purchaseDetail->account_head_id = $voucherData['account_id'];
            $purchaseDetail->head_id = $product['head_id'];
            $purchaseDetail->warehouse_id = $voucherData['shop_id'];
            $purchaseDetail->date = $product['date'];
            $purchaseDetail->voucher_no = $product['voucher_no'];
            $purchaseDetail->cheque_no = $product['cheque_no'];
            $purchaseDetail->v_type = $product['v_type'];
            $purchaseDetail->narration = $product['narration'];
            $purchaseDetail->credit = $product['amount'];
            $purchaseDetail->company_id = $product['company_id'];
            $purchaseDetail->tax = $product['tax'];
            $purchaseDetail->save();

            $purchaseDetail = new GeneralVoucher();
            $purchaseDetail->transaction_id = $voucherData['id'];
            $purchaseDetail->account_head_id = $voucherData['account_id'];
            $purchaseDetail->head_id = $product['head_id'];
            $purchaseDetail->warehouse_id = $voucherData['shop_id'];
            $purchaseDetail->date = $product['date'];
            $purchaseDetail->voucher_no = $product['voucher_no'];
            $purchaseDetail->cheque_no = $product['cheque_no'];
            $purchaseDetail->v_type = $product['v_type'];
            $purchaseDetail->narration = $product['title'];
            $purchaseDetail->credit = $product['taxAmount'];
            $purchaseDetail->company_id = $product['company_id'];
            $purchaseDetail->tax = $product['tax'];
            $purchaseDetail->save();
             // Below account | Debit account | Receive account
             $purchaseDetail = new GeneralVoucher();
             $purchaseDetail->transaction_id = $voucherData['id'];
             $purchaseDetail->account_head_id = $product['head_id'];
             $purchaseDetail->head_id = $voucherData['account_id'];
             $purchaseDetail->warehouse_id = $voucherData['shop_id'];
             $purchaseDetail->date = $product['date'];
             $purchaseDetail->voucher_no = $product['voucher_no'];
             $purchaseDetail->cheque_no = $product['cheque_no'];
             $purchaseDetail->v_type = $product['v_type'];
             $purchaseDetail->narration = $product['narration'];
             $purchaseDetail->debit = $product['amount'];
             $purchaseDetail->company_id = $product['company_id'];
             $purchaseDetail->tax = $product['tax'];
             $purchaseDetail->save();
            // Below account | Debit account | Receive account
            $purchaseDetail = new GeneralVoucher();
            $purchaseDetail->transaction_id = $voucherData['id'];
            $purchaseDetail->account_head_id = $product['head_id'];
            $purchaseDetail->head_id = $voucherData['account_id'];
            $purchaseDetail->warehouse_id = $voucherData['shop_id'];
            $purchaseDetail->date = $product['date'];
            $purchaseDetail->voucher_no = $product['voucher_no'];
            $purchaseDetail->cheque_no = $product['cheque_no'];
            $purchaseDetail->v_type = $product['v_type'];
            $purchaseDetail->narration = $product['title'];
            $purchaseDetail->debit = $product['taxAmount'];
            $purchaseDetail->company_id = $product['company_id'];
            $purchaseDetail->tax = $product['tax'];
            $purchaseDetail->save();

            // $vouchers = new LedgerDetailWise();
            // $vouchers->transaction_id = $voucherData['id'];
            // $vouchers->party_id = $voucherData['account_id'];
            // $vouchers->warehouse_id = $voucherData['shop_id'];
            // $vouchers->voucher_no = $product['voucher_no'];
            // $vouchers->cheque_no = $product['cheque_no'];
            // $vouchers->voucher_type = $product['v_type'];
            // $vouchers->date = $product['date'];
            // $vouchers->other = $product['narration'];
            // $vouchers->credit = $product['amount'];
            // $vouchers->company_id = $product['company_id'];
            // $vouchers->tax = $product['tax'];
            // $vouchers->head_id = $product['head_id'];
            // $vouchers->save();
            // $vouchers = new LedgerDetailWise();
            // $vouchers->transaction_id = $voucherData['id'];
            // $vouchers->party_id = $product['head_id'];
            // $vouchers->warehouse_id = $voucherData['shop_id'];
            // $vouchers->voucher_no = $product['voucher_no'];
            // $vouchers->cheque_no = $product['cheque_no'];
            // $vouchers->voucher_type = $product['v_type'];
            // $vouchers->date = $product['date'];
            // $vouchers->other = $product['narration'];
            // $vouchers->debit = $product['amount'];
            // $vouchers->company_id = $product['company_id'];
            // $vouchers->tax = $product['tax'];
            // $vouchers->head_id = $product['head_id'];
            // $vouchers->save();
            // $vouchers = new LedgerDetailWise();
            // $vouchers->transaction_id = $voucherData['id'];
            // $vouchers->party_id = $product['head_id'];
            // $vouchers->warehouse_id = $voucherData['shop_id'];
            // $vouchers->voucher_no = $product['voucher_no'];
            // $vouchers->cheque_no = $product['cheque_no'];
            // $vouchers->voucher_type = $product['v_type'];
            // $vouchers->date = $product['date'];
            // $vouchers->other = $product['title'];
            // $vouchers->debit = $product['taxAmount'];
            // $vouchers->company_id = $product['company_id'];
            // $vouchers->tax = $product['tax'];
            // $vouchers->head_id = $product['head_id'];
            // $vouchers->save();
        }
        return $voucherData['id'];
        //return "saved";
    }

    public function report(Request $request)
    {
        $HeadID = $request->get('head_id');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        $GeneralVoucher = BankPayment::join('parties', 'parties.id', '=', 'bank_payments.account_head_id')
            ->where('bank_payments.account_head_id', '=', $HeadID)
            ->whereBetween('date', [$fromDate, $toDate])
            ->where('company_id', session()->get('company_id'))
            ->OrderBy('bank_payments.id')->get();

        $company_detail = Setting::where('id', '=', 1)->get();
        //return $GeneralVoucher;
        return view('bank-payments.report', Compact('GeneralVoucher', 'company_detail'));
    }

    public function show($id)
    {
        //return $id;
        $newsale_detail = Vouchers::with(['voucher_details' => function ($query) {
            //$query->with('products');
            //$query->with('uoms');
            $query->where('v_type', '=', 'Bank Payment');
            $query->with('banks');
            $query->with('parties');
        }])->with('parties')
        ->where('id', '=', $id)
        // ->where('v_type', '=', 'Bank Payment')
            // ->orwhere('voucher_details.credit', '!=', null)
            ->where('company_id', session()->get('company_id'))
            ->get();
            //return $newsale_detail;
        $company_detail = Setting::where('id', '=', 1)->get();
        $logo = SystemLogo::where('id', '=', 1)->get();
        //return $newsale_detail;
        return view('bank-payments.print', compact('newsale_detail', 'company_detail', 'logo'));
    }

  public function edit($id)
    {
        $purchase = Vouchers::with(['voucher_details' => function ($query) {
            //$query->with('products');
            //$query->with('uoms');
            $query->with('parties:id,party_name,code,account_group_id');
        }])->with('parties')->where('vouchers.id', '=', $id)
            // ->orwhere('voucher_details.credit', '!=', null)
            ->where('company_id', session()->get('company_id'))
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

        $Accounts = Party::select(DB::raw('CONCAT(`id`, "_", `party_name`) AS `id`, `party_name`'))
            ->where('company_id', session()->get('company_id'))
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



        return view('bank-payments.edit', compact('edit', 'codes', 'cashAccount', 'Accounts', 'encrypted_token','accountGroups', 'titles'));
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

        $products = $request->get('product_data', []);
        GeneralVoucher::where('transaction_id', '=', $id)->delete();

        foreach ($products as $product) {
            // Top account | Credit account | Payment account
            $purchaseDetail = new GeneralVoucher();
            $purchaseDetail->transaction_id = $voucherData['id'];
            $purchaseDetail->account_head_id = $voucherData['account_id'];
            $purchaseDetail->head_id = $product['head_id'];
            $purchaseDetail->warehouse_id = $voucherData['shop_id'];
            $purchaseDetail->date = $product['date'];
            $purchaseDetail->voucher_no = $product['voucher_no'];
            $purchaseDetail->cheque_no = $product['cheque_no'];
            $purchaseDetail->v_type = $product['v_type'];
            $purchaseDetail->narration = $product['narration'];
            $purchaseDetail->credit = $product['amount'];
            $purchaseDetail->company_id = $product['company_id'];
            $purchaseDetail->tax = $product['tax'];
            $purchaseDetail->save();

            $purchaseDetail = new GeneralVoucher();
            $purchaseDetail->transaction_id = $voucherData['id'];
            $purchaseDetail->account_head_id = $voucherData['account_id'];
            $purchaseDetail->head_id = $product['head_id'];
            $purchaseDetail->warehouse_id = $voucherData['shop_id'];
            $purchaseDetail->date = $product['date'];
            $purchaseDetail->voucher_no = $product['voucher_no'];
            $purchaseDetail->cheque_no = $product['cheque_no'];
            $purchaseDetail->v_type = $product['v_type'];
            $purchaseDetail->narration = $product['title'];
            $purchaseDetail->credit = $product['taxAmount'] ?? 0;
            $purchaseDetail->company_id = $product['company_id'];
            $purchaseDetail->tax = $product['tax'];
            $purchaseDetail->save();

             // Below account | Debit account | Receive account
             $purchaseDetail = new GeneralVoucher();
             $purchaseDetail->transaction_id = $voucherData['id'];
             $purchaseDetail->account_head_id = $product['head_id'];
             $purchaseDetail->head_id = $voucherData['account_id'];
             $purchaseDetail->warehouse_id = $voucherData['shop_id'];
             $purchaseDetail->date = $product['date'];
             $purchaseDetail->voucher_no = $product['voucher_no'];
             $purchaseDetail->cheque_no = $product['cheque_no'];
             $purchaseDetail->v_type = $product['v_type'];
             $purchaseDetail->narration = $product['narration'];
             $purchaseDetail->debit = $product['amount'];
             $purchaseDetail->company_id = $product['company_id'];
             $purchaseDetail->tax = $product['tax'];
             $purchaseDetail->save();

            // Below account | Debit account | Receive account
            $purchaseDetail = new GeneralVoucher();
            $purchaseDetail->transaction_id = $voucherData['id'];
            $purchaseDetail->account_head_id = $product['head_id'];
            $purchaseDetail->head_id = $voucherData['account_id'];
            $purchaseDetail->warehouse_id = $voucherData['shop_id'];
            $purchaseDetail->date = $product['date'];
            $purchaseDetail->voucher_no = $product['voucher_no'];
            $purchaseDetail->cheque_no = $product['cheque_no'];
            $purchaseDetail->v_type = $product['v_type'];
            $purchaseDetail->narration = $product['title'];
            $purchaseDetail->debit = $product['taxAmount'] ?? 0;
            $purchaseDetail->company_id = $product['company_id'];
            $purchaseDetail->tax = $product['tax'];
            $purchaseDetail->save();
        }

        return $voucherData->id;
    }

    public function destroy($id)
    {
        $delete = Vouchers::findOrFail($id);
        $delete->delete();
        GeneralVoucher::where('transaction_id', '=', $id)->where('v_type', 'Bank Payment')->delete();
        // LedgerDetailWise::where('transaction_id', '=', $id)->where('voucher_type', 'Bank Payment')->delete();
        // Ledger::where('sale_id', '=', $id)->delete();       
        return "Bank Payment has been Deleted Successfully!";
    }
}
