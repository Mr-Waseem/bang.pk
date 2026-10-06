<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\PurchaseTax;
use App\Models\Setting;

class PurchaseTaxReportController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        $parties = Party::OrderBy('party_name', 'asc')->pluck('party_name', 'id')->toArray();
        //return $suppliers;
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('purchasetax-report.all-party.create', Compact('encrypted_token', 'parties'));
    }

    public function store(Request $request)
    {
        // return $request;
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        $ReportDetail = $request->get('ReportDetail');
        //return $supplier;
 
        $sales = PurchaseTax::with(['purchasetax_details' => function($que){
            $que->with('products:id,product_name');
        }])->with('parties:id,party_name,ntn')
        ->where('company_id',session()->get('company_id'))
        ->whereDate('date', '>=', $fromDate)
        ->whereDate('date', '<=', $toDate)
        ->OrderBy('id', 'asc')->get();
        //return $sales;
        //$suppliers = Supplier::OrderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $company_detail = Setting::where('id', '=', 1)->get();
        if($ReportDetail == 1){
            return view('purchasetax-report.all-party.detail', compact('sales', 'encrypted_token', 'company_detail', 'fromDate', 'toDate'));
        }else{
            return view('purchasetax-report.all-party.summary', compact('sales', 'encrypted_token', 'company_detail', 'fromDate', 'toDate'));
        }
        
    }

    public function SingleParty()
    {
        $parties = Party::OrderBy('party_name', 'asc')
            ->where('company_id', session()->get('company_id'))
            ->where('parties.account_group_id', '=', 2)
            ->pluck('party_name', 'id')
            ->toArray();
        //return $suppliers;
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('purchasetax-report.single-party.create', Compact('encrypted_token', 'parties'));
    }

    public function ShowSingleParty(Request $request)
    {
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        $partyID = $request->get('party_name');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        //return $supplier;
        $sales = PurchaseTax::with('purchasetax_details')->with('parties')
            ->where('party_id', '=', $partyID)
            // ->whereDate('date', [strtotime($fromDate), strtotime($toDate)])
            ->whereDate('date', '>=', $fromDate)
            ->whereDate('date', '<=', $toDate)
            ->OrderBy('id', 'asc')
            ->get();

        // return $sales;

        $party = Party::where('id', '=', $partyID)->get();

        //$suppliers = Supplier::OrderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $company_detail = Setting::where('id', '=', 1)->get();
        return view('purchasetax-report.single-party.index', compact('sales', 'encrypted_token', 'company_detail', 'fromDate', 'toDate', 'party'));
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
        return "hel";
    }

    public function destroy($id)
    {
        //
    }
}
