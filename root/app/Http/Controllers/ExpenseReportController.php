<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpenseHead;
use App\Models\Setting;
use App\Models\Party;
use Illuminate\Support\Facades\DB;

class ExpenseReportController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        $ExpenseHeads = ExpenseHead::OrderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('expense-report.create', Compact('encrypted_token', 'ExpenseHeads'));
    }

    public function store(Request $request)
    {
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');

        $expenses = Party::join('general_vouchers', 'general_vouchers.account_head_id', '=', 'parties.id')

            ->whereDate('general_vouchers.date', '>=', $fromDate)
            ->whereDate('general_vouchers.date', '<=', $toDate)
            ->where('parties.account_group_id', '=', 6)
            ->select('parties.party_name', DB::raw('SUM(general_vouchers.debit) as debit'))
            ->groupBy('account_head_id')
            ->Sum('debit')
            ->get();

        $salary = Party::join('general_vouchers', 'general_vouchers.account_head_id', '=', 'parties.id')

            ->whereDate('general_vouchers.date', '>=', $fromDate)
            ->whereDate('general_vouchers.date', '<=', $toDate)
            ->where('parties.account_group_id', '=', 8)
            ->select('parties.party_name', DB::raw('SUM(general_vouchers.debit) as debit'))
            ->groupBy('account_head_id')
            ->Sum('debit')
            ->get();

        $company_detail = Setting::where('id', '=', 1)->get();
        return view('expense-report.index', Compact('expenses', 'company_detail', 'fromDate', 'toDate', 'salary'));
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
