<?php

namespace App\Http\Controllers;

use App\Models\AccountGroup;
use App\Models\Party;
use App\Models\CashPayment;
use App\Models\Setting;
use App\Models\GeneralVoucher;
// use App\Models\LedgerDetailWise;
use App\Models\Vouchers;
use App\Models\SystemLogo;
use App\Models\CashBook;
use App\Models\AttendanceDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CashPaymentController extends Controller
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
            ->with('billers')
            ->where('vouchers.v_type', 'Cash Payment')
            ->where('company_id', session()->get('company_id'))
            ->get();
        //return $Vouchers;
        return view('cash-payments.index', compact('encrypted_token', 'Vouchers'));
    }

    public function create()
    {
        $codes = 1;
        $code = Vouchers::where('v_type', 'Cash Payment')->where('company_id',session()->get('company_id'))
        ->OrderBy('id', 'desc')->first();
        if(isset($code)>0)
        {
            $codes = (int)$code->voucher_no + 1;
        }


        $cashAccount = Party::select(DB::raw('CONCAT(`id`, "_", `party_name`) AS `id`, `party_name`'))
            // ->where('id', '=', 1)
             ->where('account_group_id', '=', 3)
            ->where('company_id', session()->get('company_id'))
            ->OrderBy('party_name', 'asc')
            ->pluck('party_name', 'id')
            ->prepend('Select Account','')
            ->toArray();
        //return $cashAccount;
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

        $accountGroups = AccountGroup::OrderBy('name', 'asc')->pluck('name', 'id');

        return view('cash-payments.create', compact('titles', 'encrypted_token', 'cashAccount', 'Accounts', 'codes', 'accountGroups'));
    }

    public function store(Request $request)
    {
        // return $request->all();
        $voucher = json_decode($request->get('voucher'), true);

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
            // $vouchers->party_id = $voucherData['account_id'];
            // $vouchers->warehouse_id = $voucherData['shop_id'];
            // $vouchers->voucher_no = $product['voucher_no'];
            // $vouchers->voucher_type = $product['v_type'];
            // $vouchers->date = $product['date'];
            // $vouchers->other = $product['title'];
            // $vouchers->credit = $product['taxAmount'];
            // $vouchers->company_id = $product['company_id'];
            // $vouchers->tax = $product['tax'];
            // $vouchers->head_id = $product['head_id'];
            // $vouchers->save();
 
            
            // $vouchers = new LedgerDetailWise();
            // $vouchers->transaction_id = $voucherData['id'];
            // $vouchers->party_id = $product['head_id'];
            // $vouchers->warehouse_id = $voucherData['shop_id'];
            // $vouchers->voucher_no = $product['voucher_no'];
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
            // $vouchers->voucher_type = $product['v_type'];
            // $vouchers->date = $product['date'];
            // $vouchers->other = $product['title'];
            // $vouchers->debit = $product['taxAmount'];
            // $vouchers->company_id = $product['company_id'];
            // $vouchers->tax = $product['tax'];
            // $vouchers->head_id = $product['head_id'];
            // $vouchers->save();

            // $cash = new CashBook();
            // $cash->date = $product['date'];
            // $cash->vr_no =  $product['voucher_no'];
            // $cash->vr_type = $product['v_type'];
            // $cash->biller_id = $voucherData['biller'];
            // $cash->shop_id = $voucherData['shop_id'];
            // $cash->party_id = $product['head_id'];
            // $cash->cash_payment_id = $voucherData['id'];
            // $cash->description = $product['narration'];
            // $cash->out = $product['amount'];
            // $cash->company_id = $product['company_id'];
            // $cash->tax = $product['tax'];
            // $cash->save();

            // $cash = new AttendanceDetails();
            // $cash->cash_payment_id = $voucherData['id'];
            // $cash->employee_id =  $product['head_id'];
            // $cash->biller_id = Auth::User()->id;
            // $cash->shop_id = $voucherData['shop_id'];
            // $cash->vr_date = $product['date'];
            // $cash->in_time = $product['date'];
            // $cash->out_time = $product['date'];
            // $cash->cash_payment = $product['amount'];
            // $cash->company_id = $product['company_id'];
            // $cash->tax = $product['tax'];
            // $cash->save();
        }
        //return $purchaseData['id'];
        return "saved";
    }

    public function report(Request $request)
    {
        $HeadID = $request->get('head_id');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        $GeneralVoucher = CashPayment::join('parties', 'parties.id', '=', 'cash_payments.account_head_id')->where('cash_payments.account_head_id', '=', $HeadID)
            ->whereBetween('date', [$fromDate, $toDate])
            ->OrderBy('cash_payments.id')->get();

        $company_detail = Setting::where('id', '=', 1)->get();
        //return $CashReceipts;
        return view('cash-payments.report', Compact('GeneralVoucher', 'company_detail'));
    }

    public function show($id)
    {
        $newsale_detail = Vouchers::with(['voucher_details' => function ($query) {
            //$query->with('products');
            //$query->with('uoms');
            $query->where('v_type', '=', 'Cash Payment');
            $query->with('parties');
        }])
            ->with('parties')
            ->where('vouchers.id', '=', $id)
            ->where('company_id', session()->get('company_id'))
            // ->orwhere('voucher_details.credit', '!=', null)
            ->get();
        $company_detail = Setting::where('id', '=', 1)->get();
        $logo = SystemLogo::where('id', '=', 1)->get();
        //return $newsale_detail;
        return view('cash-payments.print', Compact('newsale_detail', 'company_detail', 'logo'));
    }

    public function edit($id)
    {
        $purchase = Vouchers::with(['voucher_details' => function ($query) {
            $query->with('parties');
        }])
            ->with('parties')
            ->where('vouchers.id', '=', $id)
            ->where('company_id', session()->get('company_id'))
            ->get();
        $edit = $purchase[0];
        
        $code = Vouchers::OrderBy('id', 'asc')->get();
        $codes = $code->last()->voucher_no + 1;

        $cashAccount = Party::select(DB::raw('CONCAT(`id`, "_", `party_name`) AS `id`, `party_name`'))
            ->where('account_group_id', '=', 3)
            ->where('company_id', session()->get('company_id'))
            ->OrderBy('party_name', 'asc')
            ->pluck('party_name', 'id')
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

        $accountGroups = AccountGroup::OrderBy('name', 'asc')->pluck('name', 'id');

        return view('cash-payments.edit', Compact('edit', 'codes', 'cashAccount', 'Accounts', 'encrypted_token', 'accountGroups', 'titles'));
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

        GeneralVoucher::where('transaction_id', '=', $id)->delete();
        CashBook::where('cash_payment_id', '=', $id)->delete();
        AttendanceDetails::where('cash_payment_id', '=', $id)->delete();

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
            $purchaseDetail->v_type = $product['v_type'];
            $purchaseDetail->narration = $product['title'];
            $purchaseDetail->debit = $product['taxAmount'];
            $purchaseDetail->company_id = $product['company_id'];
            $purchaseDetail->tax = $product['tax'];
            $purchaseDetail->save();

            $cash = new AttendanceDetails();
            $cash->cash_payment_id = $voucherData['id'];
            $cash->employee_id =  $product['head_id'];
            $cash->biller_id = Auth::User()->id;
            $cash->shop_id = $voucherData['shop_id'];
            $cash->vr_date = $product['date'];
            $cash->in_time = $product['date'];
            $cash->out_time = $product['date'];
            $cash->cash_payment = $product['amount'];
            $cash->company_id = $product['company_id'];
            $cash->tax = $product['tax'];
            $cash->save();
        }
        return $voucherData['id'];
    }

    public function destroy($id)
    {
        $delete = Vouchers::findOrFail($id);
        $delete->delete();
        GeneralVoucher::where('transaction_id', '=', $id)->where('v_type', 'Cash Payment')->delete();
        // LedgerDetailWise::where('transaction_id', '=', $id)->where('voucher_type', 'Cash Payment')->delete();
        CashBook::where('cash_payment_id', '=', $id)->delete();
        AttendanceDetails::where('cash_payment_id', '=', $id)->delete();
        // Ledger::where('sale_id', '=', $id)->delete();       
        return "Cash Payment has been Deleted Successfully!";
    }
}
