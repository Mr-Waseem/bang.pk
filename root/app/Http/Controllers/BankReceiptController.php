<?php

namespace App\Http\Controllers;

use App\Models\AccountGroup;
use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\ChequePayment;
use App\Models\GeneralVoucher;
use App\Models\LedgerDetailWise;
use App\Models\Setting;
use App\Models\Banks;
use App\Models\Vouchers;
use App\Models\SystemLogo;
use Illuminate\Support\Facades\DB;
use Session;
class BankReceiptController extends Controller
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
            ->where('vouchers.v_type', 'Bank Receipt')
            ->where('company_id', session()->get('company_id'))
            ->get();

        return view('bank-receipts.index', compact('encrypted_token', 'Vouchers'));
    }

    public function create()
    {
        
        $code = Vouchers::where('v_type', 'Bank Receipt')->where('company_id',session()->get('company_id'))
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
            ->where('company_id', session()->get('company_id'))
            ->where('account_group_id', '!=', '5')
            ->OrderBy('party_name', 'asc')
            ->pluck('party_name', 'id')
            ->toArray();
        $banks = Party::select(DB::raw('CONCAT(`id`, "_", `party_name`) AS `id`, `party_name`'))
            ->where('company_id', session()->get('company_id'))
            ->where('account_group_id', 5)
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

        return view('bank-receipts.create', compact('encrypted_token', 'debitAccount', 'Accounts', 'banks', 'codes', 'titles','accountGroups'));
    }

    public function store(Request $request)
    {
        // return $request;
        $voucher = json_decode($request->get('voucher'), true);
        //return $voucher;
        //$voucher['date'] = date('Y-m-d',strtotime($voucher['date'])); 
        $voucherData = Vouchers::create($voucher);
        $products = $request->get('product_data');
        foreach ($products as $product) {
            // Top account | Debit account | Bank receive account
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
            // $purchaseDetail->bank_id = $product['bank_id'];
            $purchaseDetail->debit = $product['amount'] + $product['taxAmount'];
            $purchaseDetail->company_id = $product['company_id'];
            $purchaseDetail->tax = $product['tax'];
            $purchaseDetail->taxAmount = $product['taxAmount'];
            $purchaseDetail->title = $product['title'];
            $purchaseDetail->save();

            // $purchaseDetail = new GeneralVoucher();
            // $purchaseDetail->transaction_id = $voucherData['id'];
            // $purchaseDetail->account_head_id = 3;
            // //$purchaseDetail->account_head_id = $voucherData['account_id'];
            // $purchaseDetail->head_id = $product['head_id'];
            // $purchaseDetail->warehouse_id = $voucherData['shop_id'];
            // $purchaseDetail->date = $product['date'];
            // $purchaseDetail->voucher_no = $product['voucher_no'];
            // $purchaseDetail->cheque_no = $product['cheque_no'];
            // $purchaseDetail->v_type = $product['v_type'];
            // $purchaseDetail->narration = $product['title'];
            // // $purchaseDetail->bank_id = $product['bank_id'];
            // $purchaseDetail->debit = $product['taxAmount'];
            // $purchaseDetail->company_id = $product['company_id'];
            // $purchaseDetail->tax = $product['tax'];
            // $purchaseDetail->taxAmount = $product['taxAmount'];
            // $purchaseDetail->save();
            // Below account | Credit account | Bank paid account
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
            // $purchaseDetail->bank_id = $product['bank_id'];
            $purchaseDetail->credit = $product['amount'];
            $purchaseDetail->company_id = $product['company_id'];
            $purchaseDetail->tax = $product['tax'];
            $purchaseDetail->taxAmount = $product['taxAmount'];
            $purchaseDetail->title = $product['title'];
            $purchaseDetail->save();
            // Below account | Credit account | Bank paid account
            if($product['tax'] > 0){
                 $purchaseDetail = new GeneralVoucher();
            $purchaseDetail->transaction_id = $voucherData['id'];
            $purchaseDetail->account_head_id = $product['head_id'];
            $purchaseDetail->head_id = 3;
            $purchaseDetail->warehouse_id = $voucherData['shop_id'];
            $purchaseDetail->date = $product['date'];
            $purchaseDetail->voucher_no = $product['voucher_no'];
            $purchaseDetail->cheque_no = $product['cheque_no'];
            $purchaseDetail->v_type = $product['v_type'];
            $purchaseDetail->narration = $product['title'];
            // $purchaseDetail->bank_id = $product['bank_id'];
            $purchaseDetail->credit = $product['taxAmount'];
            $purchaseDetail->company_id = $product['company_id'];
            $purchaseDetail->tax = $product['tax'];
            $purchaseDetail->taxAmount = $product['taxAmount'];
            $purchaseDetail->title = $product['title'];
            $purchaseDetail->save();
            }
            // $vouchers = new LedgerDetailWise();
            // $vouchers->transaction_id = $voucherData['id'];
            // $vouchers->party_id = $voucherData['account_id'];
            // $vouchers->warehouse_id = $voucherData['shop_id'];
            // // $vouchers->bank_id = $product['bank_id'];
            // $vouchers->voucher_no = $product['voucher_no'];
            // $vouchers->voucher_type = $product['v_type'];
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
            // // $vouchers->bank_id = $product['bank_id'];
            // $vouchers->voucher_no = $product['voucher_no'];
            // $vouchers->voucher_type = $product['v_type'];
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
            // // $vouchers->bank_id = $product['bank_id'];
            // $vouchers->voucher_no = $product['voucher_no'];
            // $vouchers->voucher_type = $product['v_type'];
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
            // // $vouchers->bank_id = $product['bank_id'];
            // $vouchers->voucher_no = $product['voucher_no'];
            // $vouchers->voucher_type = $product['v_type'];
            // $vouchers->date = $product['date'];
            // $vouchers->other = $product['title'];
            // $vouchers->credit = $product['taxAmount'];
            // $vouchers->company_id = $product['company_id'];
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
        $GeneralVoucher = ChequePayment::join('parties', 'parties.id', '=', 'cheque_payments.account_head_id')
            ->where('cheque_payments.account_head_id', '=', $HeadID)
            ->whereBetween('date', [$fromDate, $toDate])
            ->OrderBy('cheque_payments.id')
            ->get();

        $company_detail = Setting::where('id', '=', 1)->get();
        //return $GeneralVoucher;
        return view('cheque-payments.report', compact('GeneralVoucher', 'company_detail'));
    }

    public function show($id)
    {
        $newsale_detail = Vouchers::with(['voucher_details' => function ($query) {
            //$query->with('products');
            //$query->with('uoms');
            $query->where('v_type', '=', 'Bank Receipt')
            ->where('debit', '!=', null);
            $query->with('banks');
            $query->with('newparty');
        }])->with('parties')->where('vouchers.id', '=', $id)
            // ->orwhere('voucher_details.credit', '!=', null)
            ->where('company_id', session()->get('company_id'))
            ->get();
        $company_detail = Setting::where('id', '=', 1)->get();
        $logo = SystemLogo::where('id', '=', 1)->get();
        //return $newsale_detail;
        return view('bank-receipts.print', compact('newsale_detail', 'company_detail', 'logo'));
    }

    public function edit($id)
    {
        $purchase = Vouchers::with(['voucher_details' => function ($query) {
            //$query->with('products');
            //$query->with('uoms');
            $query->where('v_type', '=', 'Bank Receipt')
            ->where('debit', '!=', null);
            $query->with('banks');
            $query->with('newparty');
        }])->with('parties')->where('vouchers.id', '=', $id)
            // ->orwhere('voucher_details.credit', '!=', null)
            ->where('company_id', session()->get('company_id'))
            ->get();
        $edit = $purchase[0];

        //   $debitAccount = Party::select(DB::raw('CONCAT(`id`, "_", `party_name`) AS `id`, `party_name`'))
          $debitAccount = Party::select(DB::raw('CONCAT(`id`) AS `id`, `party_name`'))
            ->where('account_group_id', '=', '6')
            ->where('company_id', session()->get('company_id'))
            ->OrderBy('party_name', 'asc')
            ->pluck('party_name', 'id')
            ->toArray();
        $Accounts = Party::select(DB::raw('CONCAT(`id`, "_", `party_name`) AS `id`, `party_name`'))
            ->where('company_id', session()->get('company_id'))
            ->where('account_group_id', '!=', '5')
            ->OrderBy('party_name', 'asc')
            ->pluck('party_name', 'id')
            ->toArray();
        $banks = Party::select(DB::raw('CONCAT(`id`, "_", `party_name`) AS `id`, `party_name`'))
            ->where('company_id', session()->get('company_id'))
            ->where('account_group_id', 5)
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


        return view('bank-receipts.edit', compact('edit', 'debitAccount', 'Accounts', 'encrypted_token', 'banks','accountGroups', 'titles'));
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

        GeneralVoucher::where('transaction_id', '=', $id)
            ->where('v_type', 'Bank Receipt')->delete();

        $products = $request->get('product_data');
        foreach ($products as $product) {
            // Top account | Debit account | Bank receive account
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
            $purchaseDetail->debit = $product['amount'] + $product['taxAmount'];
            $purchaseDetail->company_id = $product['company_id'];
            $purchaseDetail->tax = $product['tax'];
            $purchaseDetail->taxAmount = $product['taxAmount'];
            $purchaseDetail->title = $product['title'];
            $purchaseDetail->save();

            // $purchaseDetail = new GeneralVoucher();
            // $purchaseDetail->transaction_id = $voucherData['id'];
            // $purchaseDetail->account_head_id = 3;
            // //$purchaseDetail->account_head_id = $voucherData['account_id'];
            // $purchaseDetail->head_id = $product['head_id'];
            // $purchaseDetail->warehouse_id = $voucherData['shop_id'];
            // $purchaseDetail->date = $product['date'];
            // $purchaseDetail->voucher_no = $product['voucher_no'];
            // $purchaseDetail->cheque_no = $product['cheque_no'];
            // $purchaseDetail->v_type = $product['v_type'];
            // $purchaseDetail->narration = $product['title'];
            // // $purchaseDetail->bank_id = $product['bank_id'];
            // $purchaseDetail->debit = $product['taxAmount'];
            // $purchaseDetail->company_id = $product['company_id'];
            // $purchaseDetail->tax = $product['tax'];
            // $purchaseDetail->taxAmount = $product['taxAmount'];
            // $purchaseDetail->save();
            // Below account | Credit account
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
            $purchaseDetail->credit = $product['amount'];
            $purchaseDetail->company_id = $product['company_id'];
            $purchaseDetail->tax = $product['tax'];
            $purchaseDetail->taxAmount = $product['taxAmount'];
            $purchaseDetail->title = $product['title'];
            $purchaseDetail->save();

            // Tax credit row
            if($product['tax'] > 0){
                $purchaseDetail = new GeneralVoucher();
                $purchaseDetail->transaction_id = $voucherData['id'];
                $purchaseDetail->account_head_id = $product['head_id'];
                $purchaseDetail->head_id = 3;
                $purchaseDetail->warehouse_id = $voucherData['shop_id'];
                $purchaseDetail->date = $product['date'];
                $purchaseDetail->voucher_no = $product['voucher_no'];
                $purchaseDetail->cheque_no = $product['cheque_no'];
                $purchaseDetail->v_type = $product['v_type'];
                $purchaseDetail->narration = $product['title'];
                $purchaseDetail->credit = $product['taxAmount'];
                $purchaseDetail->company_id = $product['company_id'];
                $purchaseDetail->tax = $product['tax'];
                $purchaseDetail->taxAmount = $product['taxAmount'];
                $purchaseDetail->title = $product['title'];
                $purchaseDetail->save();
            }
        }
         // // Top account | Debit account | Bank receive account
            // $purchaseDetail = new GeneralVoucher();
            // $purchaseDetail->transaction_id = $voucherData['id'];
            // $purchaseDetail->account_head_id = $voucherData['account_id'];
            // $purchaseDetail->head_id = $product['head_id'];
            // $purchaseDetail->warehouse_id = $voucherData['shop_id'];
            // $purchaseDetail->date = $product['date'];
            // $purchaseDetail->voucher_no = $product['voucher_no'];
            // $purchaseDetail->cheque_no = $product['cheque_no'];
            // $purchaseDetail->v_type = $product['v_type'];
            // $purchaseDetail->narration = $product['narration'];
            // $purchaseDetail->bank_id = $product['bank_id'];
            // $purchaseDetail->debit = $product['amount'];
            // $purchaseDetail->company_id = $product['company_id'];
            // $purchaseDetail->save();
            // // Below account | Credit account | Bank paid account
            // $purchaseDetail = new GeneralVoucher();
            // $purchaseDetail->transaction_id = $voucherData['id'];
            // $purchaseDetail->account_head_id = $product['head_id'];
            // $purchaseDetail->head_id = $product['head_id'];
            // $purchaseDetail->warehouse_id = $voucherData['shop_id'];
            // $purchaseDetail->date = $product['date'];
            // $purchaseDetail->voucher_no = $product['voucher_no'];
            // $purchaseDetail->cheque_no = $product['cheque_no'];
            // $purchaseDetail->v_type = $product['v_type'];
            // $purchaseDetail->narration = $product['narration'];
            // $purchaseDetail->bank_id = $product['bank_id'];
            // $purchaseDetail->credit = $product['amount'];
        //     $purchaseDetail->company_id = $product['company_id'];
        //     $purchaseDetail->save();

        // }
        return $voucherData['id'];
    }

    public function destroy($id)
    {
        $delete = Vouchers::findOrFail($id);
        $delete->delete();
        GeneralVoucher::where('transaction_id', '=', $id)->where('v_type', 'Bank Receipt')->delete();
        LedgerDetailWise::where('transaction_id', '=', $id)->where('voucher_type', 'Bank Receipt')->delete();
        // Ledger::where('sale_id', '=', $id)->delete();       
        return "Bank Receipt has been Deleted Successfully!";
    }
}
