<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\Sales;
use App\Models\Setting;

class SinglePartySaleController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        $parties = Party::where('company_id', session()->get('company_id'))
                    ->where('account_group_id', '=',1)
			        ->where('party_name', '!=','CASH IN HAND')
                    ->OrderBy('party_name', 'asc')
                    ->pluck('party_name', 'id')
                    ->toArray();
        //return $suppliers;
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('sales-report.single-party.create', Compact('encrypted_token', 'parties'));
    }

    public function store(Request $request)
    {
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        $party = $request->get('party_name');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        //return $supplier;
        $sales = Sales::with('sale_details')
        ->with('parties')
        ->where('party_id', '=', $party)
        ->whereBetween('date', [$fromDate, $toDate])
        ->where('company_id',session()->get('company_id'))
        ->OrderBy('id', 'asc')->get();
        //return $sales;
        //$suppliers = Supplier::OrderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $party = Party::where('id', '=', $party)->where('company_id',session()->get('company_id'))->get();
        //return $party;
        $company_detail = Setting::where('id', '=', 1)->get();
        return view('sales-report.single-party.index', compact('sales', 'fromDate', 'toDate', 'encrypted_token', 'party', 'company_detail'));
    }

    public function show($id)
    {
        return "jk";
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
