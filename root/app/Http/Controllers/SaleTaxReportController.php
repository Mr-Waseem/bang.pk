<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportSalesTaxReport;
use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\Tax;
use App\Models\SaleTax;
use App\Models\Setting;
use App\Models\Warehouse;

class SaleTaxReportController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        $parties = Party::where('company_id', session()->get('company_id'))
            ->where('account_group_id', '=', 1)
            ->where('party_name', '!=', 'CASH IN HAND')
            ->OrderBy('party_name', 'asc')
            ->pluck('party_name', 'id')
            ->toArray();
        $shops = Warehouse::OrderBy('name', 'asc')->pluck('name', 'id')->prepend('ALL BRANCHES', '0')->toArray();
        //return $suppliers;
       $tax = Tax::where('tax_title', '!=', 'Exempt')->OrderBy('tax_rate', 'asc')->pluck('tax_title', 'tax_rate')->prepend('All', "1000");
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('salestax-report.all-party.create', Compact('encrypted_token', 'parties', 'shops', 'tax'));
    }

    public function store(Request $request)
    {
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        $tax = $request->get('tax_p');
        $ShopID = $request->get('shop_id');
        $ReportDetail = $request->get('ReportDetail');
        $company_detail = Setting::where('id', '=', 1)->get();
        $warehouse = Warehouse::where('id', '=', $ShopID)->get();
        //return $warehouse;

        if($ReportDetail == 3)
        {
            // return "d";
            return Excel::download(new ExportSalesTaxReport($fromDate,$toDate, $tax), 'salestax-all-party-report.xlsx');
        }

        if ($ReportDetail == 1) {
            //detail
            if ($ShopID == 0) {
                // return "ds";
                $sales = SaleTax::with(['saletax_details' => function($query)use ($tax){
                    $query->with('products:id,product_name,product_code');
                     $query->where(function ($queryy) use ($tax) {
                            if ($tax != 1000) {
                                $queryy->where('stvalue', $tax);
                            }
                        });
                }])->with('parties')
                   
                    //->whereBetween('date', [$fromDate, $toDate])
                    ->where('sale_type', 'SalesTax Invoice')
                    ->where('company_id', session()->get('company_id'))
                    ->whereDate('date', '>=', $fromDate)
                    ->whereDate('date', '<=', $toDate)
                    ->OrderBy('invoice_no', 'asc')->get();

                return view('salestax-report.all-party.detail', compact('sales', 'encrypted_token', 'company_detail', 'fromDate', 'toDate', 'warehouse'));
            } else {
                $sales = SaleTax::where('warehouse_id', '=', $ShopID)->with(['saletax_details' => function($que){
                    $que->with('products:id,product_name');
                }])->with('parties')
                ->where('sale_type', 'SalesTax Invoice')
                    ->where('company_id', session()->get('company_id'))
                    ->whereDate('date', '>=', $fromDate)
                    ->whereDate('date', '<=', $toDate)
                    //->whereBetween('date', [$fromDate, $toDate])
                    ->OrderBy('invoice_no', 'asc')->get();

                return view('salestax-report.all-party.detail', compact('sales', 'encrypted_token', 'company_detail', 'fromDate', 'toDate', 'warehouse'));
            }
        } else {
            //Summary
            // return "Sum";
            if ($ShopID == 0) {
                //return $supplier;
                // $sales = SaleTax::with(['saletax_details' => function($query) use ($tax){
                //      $query->where(function ($queryy) use ($tax) {
                //             if ($tax != 1000) {
                //                 $queryy->where('stvalue', $tax);
                //             }
                //         });
                // }])->with('parties')
                //     //->whereBetween('date', [$fromDate, $toDate])
                //     ->where('sale_type', 'SalesTax Invoice')
                //     ->where('company_id', session()->get('company_id'))
                //     ->whereDate('date', '>=', $fromDate)
                //     ->whereDate('date', '<=', $toDate)
                //     ->OrderBy('id', 'asc')->get();

                $sales = SaleTax::with([
                    'saletax_details' => function($query) use ($tax) {
                        $query->when($tax != 1000, function($q) use ($tax) {
                            $q->where('stvalue', $tax);
                        });
                    },
                    'saletax_details.party',  // Assuming party is related to saletax_details
                    'saletax_details.products' // Assuming product is related to saletax_details
                ])
                ->whereHas('saletax_details', function($query) use ($tax) {
                    $query->when($tax != 1000, function($q) use ($tax) {
                        $q->where('stvalue', $tax);
                    });
                })
                ->where('sale_type', 'SalesTax Invoice')
                ->where('company_id', session('company_id'))
                ->whereBetween('date', [$fromDate, $toDate])
                ->orderBy('invoice_no', 'asc')
                ->get();

                return view('salestax-report.all-party.summary', compact('sales', 'encrypted_token', 'company_detail', 'fromDate', 'toDate', 'warehouse'));
            } else {
                $sales = SaleTax::where('warehouse_id', '=', $ShopID)->with('saletax_details')->with('parties')
                    ->where('sale_type', 'SalesTax Invoice')
                    ->where('company_id', session()->get('company_id'))
                    ->whereDate('date', '>=', $fromDate)
                    ->whereDate('date', '<=', $toDate)
                    //->whereBetween('date', [$fromDate, $toDate])
                    ->OrderBy('invoice_no', 'asc')->get();
                //return $sales;
                return view('salestax-report.all-party.summary-single', compact('sales', 'encrypted_token', 'company_detail', 'fromDate', 'toDate', 'warehouse'));
            }
        }
    }

    public function SingleParty()
    {
        // return session()->get('company_id');
        $parties = Party::OrderBy('party_name', 'asc')
            ->where('account_group_id', '=', 1)
            ->where('party_name', '!=', 'CASH IN HAND')
            ->where('company_id', session()->get('company_id'))
            ->pluck('party_name', 'id')
            ->toArray();
        //return $suppliers;
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('salestax-report.single-party.create', Compact('encrypted_token', 'parties'));
    }

    public function ShowSingleParty(Request $request)
    {
        $suppliers = "";
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        $partyID = $request->get('party_name');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        // return $partyID;
        $sales = SaleTax::with('saletax_details')
            ->with('parties')
            ->where('party_id', '=', $partyID)
            ->where('company_id', session()->get('company_id'))
            ->whereDate('date', '>=', $fromDate)
            ->whereDate('date', '<=', $toDate)
            ->OrderBy('invoice_no', 'asc')
            ->get();

        // return $sales;


        $party = Party::where('id', '=', $partyID)->where('company_id', session()->get('company_id'))->get();

        //$suppliers = Supplier::OrderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $company_detail = Setting::where('id', '=', 1)->get();
        return view('salestax-report.single-party.index', compact('sales', 'encrypted_token', 'suppliers', 'company_detail', 'fromDate', 'toDate', 'party'));
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
