<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class BalanceSheetController extends Controller
{
    public function index()
    {
        // $data = AccountGroup::with('general_vouchers')->where('name', '=', 'ASSET')->get();
        // $data = AccountGroup::with(['parties'=> function($query){
        //             $query->with('general_vouchers');
        //             }])->where('name', '=', 'ASSET')->get();
        // return $data;
        $asset = DB::table('general_vouchers')
            //->join('account_groups', 'account_groups.id', '=', 'general_vouchers.account_head_id')
            ->join('parties', 'parties.id', '=', 'general_vouchers.account_head_id')
            ->select('parties.id', 'parties.party_name', DB::raw('SUM(debit) as total'))
            ->groupBy('account_head_id')
            ->where('parties.account_group_id', '=', '3')
            ->where('parties.company_id', session()->get('company_id'))
            // ->whereBetween('sale_details.created_at', [$fromDate, $toDate])
            ->get()->toArray();
        //return $asset;
        $liabilitity = DB::table('general_vouchers')
            ->join('parties', 'parties.id', '=', 'general_vouchers.account_head_id')
            ->select('parties.id', 'parties.party_name', DB::raw('SUM(credit) as total'))
            ->groupBy('account_head_id')
            ->where('parties.account_group_id', '=', '4')
            ->where('parties.company_id', session()->get('company_id'))
            // ->whereBetween('sale_details.created_at', [$fromDate, $toDate])
            ->get()->toArray();
        // return $liabilitity;
        $company_detail = Setting::where('id', '=', 1)->get();
        //return $asset;
        return view('balance-sheet.index', Compact('asset', 'liabilitity', 'company_detail'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
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
