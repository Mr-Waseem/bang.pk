<?php

namespace App\Http\Controllers;

use App\Models\Party;
use App\Models\Setting;
use App\Models\GeneralVoucher;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CashBookReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $PettyCash = Party::where('account_group_id', 3)->OrderBy('party_name', 'asc')->pluck('party_name', 'id')->toArray();
         //return $shops;
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        //return "d";
        return view('cash-book-report.index', Compact('encrypted_token', 'PettyCash'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $cash_report = $request->get('cash_report');
        $HeadID = $request->get('account_id');
        //return $cash_report;
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        $LastDayDate = date('Y-m-d', strtotime($fromDate . ' -1 day'));
        $CashAccount = Party::where('id', '=', $HeadID)->first();

        $openingCash = GeneralVoucher::whereDate('date', '<', $fromDate)
        ->where('company_id', session()->get('company_id'))
        ->where('account_head_id', '=', $HeadID)
        ->select(DB::raw('SUM(debit) as OpeningDebit, SUM(credit) as OpeningCredit'))
        ->get();

        //DETAIL
        if ($cash_report == 1) {
            $Payment = GeneralVoucher::with('banks')->with('parties')->with('newparty')
            ->orderBy('date', 'asc')
            ->OrderBy('id', 'asc')
            ->whereDate('general_vouchers.date', '>=', $fromDate)
            ->whereDate('general_vouchers.date', '<=', $toDate)
            ->where('company_id', session()->get('company_id'))
            ->where('account_head_id', '=', $HeadID)
            ->get();
            // return $Payment;
            return view('cash-book-report.detail', Compact('Payment', 'fromDate', 'toDate', 'openingCash', 'CashAccount'));
        } else {
                //SUMMARY
            $Payment = DB::table('general_vouchers')
            ->join('parties', 'parties.id', '=', 'general_vouchers.head_id')
            ->where('general_vouchers.company_id', session()->get('company_id'))
            // ->where('account_head_id', '=', $HeadID)
            ->whereDate('general_vouchers.date', '>=', $fromDate)
            ->whereDate('general_vouchers.date', '<=', $toDate)
            ->selectRaw('general_vouchers.voucher_no')
            ->selectRaw('general_vouchers.v_type')
            ->selectRaw('parties.party_name')
            ->selectRaw('general_vouchers.date')
            ->selectRaw('general_vouchers.narration')
            ->selectRaw('general_vouchers.debit')
            ->selectRaw('general_vouchers.credit')
            ->selectRaw('sum(debit) as debit')
        // ->selectRaw('general_vouchers.id')
            ->selectRaw('sum(credit) as credit')
            ->where('account_head_id', '=', $HeadID)
        // ->selectRaw('general_vouchers.id')
            ->groupBy('general_vouchers.transaction_id')
            // ->OrderBy('parties.party_name')
            ->get();
                
            return view('cash-book-report.summary', Compact('Payment', 'fromDate', 'toDate', 'openingCash', 'CashAccount'));
        }
    }

    public function show(Request $request, $id)
    {
        $ShopID = $request->get('shop_id');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');

        //return "shop";
        $Payment = CashBook::join('parties', 'parties.id', '=', 'cash_books.party_id')
            ->whereBetween('cash_books.created_at', [$fromDate, $toDate])
            ->where('shop_id', '=', $ShopID)
            ->where('cash_books.company_id', session()->get('company_id'))
            ->OrderBy('cash_books.date')->get();

        $shop =  Warehouse::where('id', '=', $ShopID)->get();
        $company_detail = Setting::where('id', '=', 1)->get();
        //return $Payment;
        return view('cash-book-report.report', Compact('Payment', 'company_detail', 'fromDate', 'toDate', 'shop'));
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
