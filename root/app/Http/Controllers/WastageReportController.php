<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\Setting;
use App\Models\Warehouse;
use App\Models\WastageDetails;

class WastageReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    }

    public function create()
    {
        $parties = Party::OrderBy('party_name', 'asc')
            ->where('company_id', session()->get('company_id'))
            ->pluck('party_name', 'id')
            ->toArray();
        $shops = Warehouse::OrderBy('name', 'asc')->pluck('name', 'id')->prepend('ALL BRANCHES', '0')->toArray();
        //return $suppliers;
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('wastage.wastage-report.create', Compact('encrypted_token', 'parties', 'shops'));
    }

    public function store(Request $request)
    {
        $ShopID = $request->get('shop_id');
        //return $ShopID;
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        $Type = $request->get('sale_report');

        $company_detail = Setting::where('id', '=', 1)->get();
        $shops = Warehouse::where('id', '=', $ShopID)->get();
        //return $shops;
        // $data = Product::join('wastage_details', 'wastage_details.product_id', '=', 'products.id')
        //                  ->join('wastages', 'wastages.id', '=', 'wastage_details.product_id')
        // ->whereDate('wastages.date', '>=', $fromDate)
        // ->whereDate('wastages.date', '<=', $toDate)
        // ->select('products.product_name', DB::raw('SUM(wastage_details.quantity) as quantity'))
        // ->groupBy('wastages.sale_list')
        // ->get();
        if ($Type == 1) {
            if ($ShopID == 0) {
                $sales = WastageDetails::with('wastages')->with('products')
                    //->where('warehouse_id', '=', $ShopID)
                    ->OrderBy('id', 'asc')->get();
                return view('wastage.wastage-report.index', Compact('sales', 'company_detail', 'shops', 'fromDate', 'toDate'));
            }
            if ($ShopID != 0) {
                $sales = WastageDetails::with('wastages')->with('products')
                    ->where('warehouse_id', '=', $ShopID)
                    ->OrderBy('id', 'asc')->get();
                return view('wastage.wastage-report.index', Compact('sales', 'company_detail', 'shops', 'fromDate', 'toDate'));
            }
        } else {
            if ($ShopID == 0) {
                $sales = WastageDetails::join('wastages', 'wastages.id', '=', 'wastage_details.wastage_id')
                    ->join('products', 'products.id', '=', 'wastage_details.product_id')
                    //->where('warehouse_id', '=', $ShopID)
                    ->selectRaw('products.product_name')
                    //->selectRaw('wastages.sale_list')
                    ->selectRaw('sum(quantity) as quantity')
                    //->groupBy('wastage_details.type')
                    ->groupBy('wastage_details.product_id')
                    //->groupBy('wastage_details.type')
                    //->OrderBy('id', 'asc')
                    ->get();
                return $sales;
                return view('wastage.wastage-report.index', Compact('sales', 'company_detail', 'shops', 'fromDate', 'toDate'));
            }
        }
        return $data;
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
