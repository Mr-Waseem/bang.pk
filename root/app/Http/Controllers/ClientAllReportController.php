<?php

namespace App\Http\Controllers;

use App\Models\AccountGroup;
use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\GeneralVoucher;
use App\Models\Setting;
use App\Models\LedgerDetailWise;
use App\Models\Warehouse;
use Illuminate\Support\Facades\DB;

class ClientAllReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        
        $AccountGroups = AccountGroup::
                        // where('code','!=',10)
                        // ->where('code','!=',11)
                        // ->where('code','!=',12)
                        // ->
                        OrderBy('name', 'asc')
                        ->pluck('name', 'id')
                        ->prepend('Select Category','');
        $Heads = Party::OrderBy('party_name', 'asc')
            // ->where('party_name', '!=', 'CASH IN HAND')
            ->where('id', '<', 5)
            ->orwhere('company_id', session()->get('company_id'))
            ->pluck('party_name', 'id')
            ->prepend('Select Account', '')
            ->toArray();
        // $Heads = array(''=>'Select Account');
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('client-all-report.index', Compact('encrypted_token', 'Heads','AccountGroups'));
    }

    public function ledgerallpartyDetail()
    {
        
        return view('client-all-report.ledger-all-party-detail.index');
    }

    public function LedgerAllPartyReport(Request $request)
    {
        
        $this->validate($request, [
            'from_date' => 'required',
            'to_date' => 'required'
        ]);
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        $GeneralVoucher = GeneralVoucher::with('parties')->orderBy('date', 'asc')
            //->whereBetween('general_vouchers.date', [$fromDate, $toDate])
            ->where('company_id', session()->get('company_id'))
            ->whereDate('general_vouchers.date', '>=', $fromDate)
            ->whereDate('general_vouchers.date', '<=', $toDate)
            ->get();
        $items = LedgerDetailWise::with('products')->OrderBy('ledger_detail_wise.date', 'asc')
            ->where('company_id', session()->get('company_id'))
            ->whereDate('date', '>=', $fromDate)
            ->whereDate('date', '<=', $toDate)
            ->get();
        $company_detail = Setting::where('id', '=', 1)->get();
        return view('client-all-report.ledger-all-party-detail.report', Compact('GeneralVoucher', 'company_detail', 'fromDate', 'toDate'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'head_id' => 'required',
            'from_date' => 'required',
            'to_date' => 'required'
        ],[
            'head_id.required'=>'The account field is required'
        ]);
        $HeadID = $request->get('head_id');
        //return $HeadID;
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        $ReportDetail = $request->get('ReportDetail');
        $LastDayDate = date('Y-m-d', strtotime($fromDate . ' -1 day'));
        //return $fromDate;
        $company_detail = Setting::where('id', '=', 1)->get();
        $party = Party::with('shop')->where('id', '=', $HeadID)->where('company_id', session()->get('company_id'))->first();
        // return $HeadID;
        $openingBalance = GeneralVoucher::
        // whereDate('date', '>=', '2019-01-01')
        whereDate('date', '<', $fromDate)
        ->where('account_head_id', '=', $HeadID)
        ->where('company_id', session()->get('company_id'))
        ->select(DB::raw('SUM(credit) as OpeningIN, SUM(debit) as OpeningOUT'))
        ->first();
        //summary
        if ($ReportDetail == 1) {
            //return "j";
            // $GeneralVoucher = GeneralVoucher::with('banks')->with('parties')->with('newparty')
            //     ->orderBy('date', 'asc')
            //     ->OrderBy('id', 'asc')
            //     ->whereDate('general_vouchers.date', '>=', $fromDate)
            //     ->whereDate('general_vouchers.date', '<=', $toDate)
            //     ->where('company_id', session()->get('company_id'))
            //     ->where('account_head_id', '=', $HeadID)
            //     ->get();
            // return  $GeneralVoucher;

            $GeneralVoucher = DB::table('general_vouchers')
            // ->join('parties', 'parties.id', '=', 'general_vouchers.head_id')
            ->where('general_vouchers.company_id', session()->get('company_id'))
            ->where('account_head_id', '=', $HeadID)
            ->whereDate('general_vouchers.date', '>=', $fromDate)
            ->whereDate('general_vouchers.date', '<=', $toDate)
            ->orderBy('date', 'asc')
            ->OrderBy('id', 'asc')
            // ->whereDate('date', '>=', $fromDate)
            // ->whereDate('date', '<=', $toDate)
            ->selectRaw('general_vouchers.voucher_no')
            ->selectRaw('general_vouchers.v_type')
            ->selectRaw('general_vouchers.date')
            ->selectRaw('general_vouchers.narration')
            ->selectRaw('general_vouchers.invoice_no')
            ->selectRaw('general_vouchers.cheque_no')
            // ->selectRaw('parties.party_name')
            // ->selectRaw('parties.phone')
            // ->selectRaw('parties.address')
            ->selectRaw('sum(debit) as debit')
            ->selectRaw('general_vouchers.id')
            ->selectRaw('sum(credit) as credit')
            ->selectRaw('general_vouchers.id')
            ->groupBy('general_vouchers.transaction_id')
            // ->OrderBy('parties.party_name')
            ->get();
        
            return view('client-all-report.summary', Compact('GeneralVoucher', 'company_detail', 'party', 'fromDate', 'toDate', 'openingBalance'));
        }
            //detail
        if ($ReportDetail == 2) {
            //return "data";
            $GeneralVoucher = GeneralVoucher::with(['banks', 'newparty', 'sales_tax.saletax_details.products'])
            ->orderBy('date', 'asc')
            ->OrderBy('id', 'asc')
            // ->whereBetween('general_vouchers.date', [$fromDate, $toDate])
            ->whereDate('general_vouchers.date', '>=', $fromDate)
            ->whereDate('general_vouchers.date', '<=', $toDate)
            ->where('company_id', session()->get('company_id'))
            ->where('account_head_id', '=', $HeadID)
            // ->where('head_id', '=', $HeadID)
            ->get();
            //return $GeneralVoucher;


            return view('client-all-report.detail', Compact('GeneralVoucher', 'company_detail', 'party', 'fromDate', 'toDate', 'openingBalance'));
        }

    }

    public function ledgerallpartyIndex()
    {
        //return "hel";
        $group = AccountGroup::Orderby('name', 'asc')->pluck('name', 'id');
        //return $group;
        $Warehouse = Warehouse::OrderBy('name', 'asc')->pluck('name', 'id')->prepend('Select Warehouse', '')->toArray();
        return view('ledger-all-party.index', Compact('Warehouse', 'group'));
    }

    public function LedgerAllParty(Request $request)
    {
        // return "sam";
        $company_detail = Setting::where('id', '=', 1)->get();
        $saletype = $request->get('saletype');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        $groupID = $request->get('groupID');

        $party = DB::table('general_vouchers')
            ->join('parties', 'parties.id', '=', 'general_vouchers.account_head_id')
            // ->whereBetween('date', [$fromDate, $toDate])
            ->where('parties.company_id', session()->get('company_id'))
            ->where('parties.account_group_id', $groupID)
            // ->Orwhere('parties.account_group_id', '=', 1) //customer
            // ->Orwhere('parties.account_group_id', '=', 2) //supplier
            ->where(function($query) {
                $query->Orwhere('parties.account_group_id', '=', 1)
                      ->Orwhere('parties.account_group_id', '=', 2);
            })
            ->whereDate('date', '>=', $fromDate)
            ->whereDate('date', '<=', $toDate)
            ->selectRaw('parties.party_name')
            ->selectRaw('parties.phone')
            ->selectRaw('parties.address')
            ->selectRaw('sum(debit) as debit')
            ->selectRaw('general_vouchers.id')
            ->selectRaw('sum(credit) as credit')
            ->selectRaw('general_vouchers.id')
            ->groupBy('account_head_id')
            ->OrderBy('parties.party_name')
            
            // ->orwhere('parties.account_group_id', '=', 7) //both
            // ->where('v_type', '=', $saletype)
            // ->orwhere('v_type', '=', 'Bank Receipt')
            ->get();
// return "ds";
        // return $party;

        //     DB::table('general_vouchers')
        //                  ->join('parties', 'parties.id', '=', 'general_vouchers.account_head_id')
        //                  ->select('parties.party_name', 'parties.phone', DB::raw('SUM(debit) as debit'), DB::raw('SUM(credit) as credit'))
        //                  ->whereBetween('date', [$fromDate, $toDate])
        //                  ->groupBy('account_head_id')
        //                 ->where('v_type', '=', $saletype)
        //                 ->orwhere('v_type', '=', 'Bank Receipt')
        //                 ->orwhere('v_type', '=', 'Bank Payment')
        //                 ->orwhere('v_type', '=', 'Cash Receipt')
        //                 ->orwhere('v_type', '=', 'Cash Payment')
        //                 ->orwhere('v_type', '=', 'Journal Voucher')
        //                 ->orwhere('v_type', '=', 'Post Dated Cheque')
        //                  ->get()->toArray();
        //return $party;
        return view('ledger-all-party.report', Compact('party', 'company_detail', 'fromDate', 'toDate'));
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

    public function ledgerForTrialBalance($id)
    {

        $GeneralVoucher = GeneralVoucher::with('banks')
            ->orderBy('date', 'asc')
            ->where('company_id', session()->get('company_id'))
            ->where('account_head_id', '=', $id)->get();
        //Detail
        $items = LedgerDetailWise::with('products')->OrderBy('ledger_detail_wise.date', 'asc')
            ->where('ledger_detail_wise.company_id', session()->get('company_id'))
            ->where('ledger_detail_wise.party_id', '=', $id)
            //->where('ledger_detail_wise.id', '=', '53')
            ->get();

        $party = Party::where('id', '=', $id)->where('company_id', session()->get('company_id'))->get();

        $company_detail = Setting::where('id', '=', 1)->get();
        return view('client-all-report.ledger-for-trial.index', Compact('GeneralVoucher', 'company_detail', 'party'));
    }

    public function GetSelectedCategoryAccounts(Request $request)
    {
        $parties = Party::where('account_group_id',$request->account_group_id)
                ->where('company_id', session()->get('company_id'))
                ->get();
        return $parties;
    }
}
