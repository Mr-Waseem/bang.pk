<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Production;
use App\Models\ProductionDetails;
use App\Models\Setting;
use App\Models\Catagory;
use Illuminate\Support\Facades\DB;

class ProductionReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $Heads = Product::OrderBy('product_name', 'asc')->where('company_id', session()->get('company_id'))->pluck('product_name', 'id')->prepend('Select Product', '')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('production-report.index', Compact('encrypted_token', 'Heads'));
    }

    public function create()
    {
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('production-report.all-item.create', Compact('encrypted_token'));
    }

    public function allItem(Request $request)
    {
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        $ProductionReport = $request->get('production_report');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        $company_detail = Setting::where('id', '=', 1)->get();

        if ($ProductionReport == 1) {
            $production = Production::with('products')->with('uoms')
                //->with('production_details')
                ->orderBy('date', 'asc')
                ->whereDate('productions.date', '>=', $fromDate)
                ->whereDate('productions.date', '<=', $toDate)
                ->where('company_id', session()->get('company_id'))
                ->get();


            return view('production-report.all-item.report', Compact('production', 'company_detail', 'fromDate', 'toDate'));
        }

        if ($ProductionReport == 2) {
            // $product = Catagory::with(['products' => function ($query)
            // use ($fromDate, $toDate) {
            //     $query->with(['production' => function ($query) use ($fromDate, $toDate) {
            //         // $query->whereDate('date', '>=', $fromDate);
            //         // $query->whereDate('date', '<=', $toDate);
            //         $query->where('company_id', session()->get('company_id'));
            //         $query->select(DB::raw('SUM(rates) as total'));
            //     }]);
            // }])


            //     ->OrderBy('id', 'asc')->get();


            $catagories = Catagory::OrderBy('id', 'asc')->get();
            //return $catagories;

            $product = Catagory::join('products', 'products.catagory_id', 'catagories.id')
                ->join('productions', 'productions.products_id', 'products.id')
                ->select('catagories.id', 'catagories.catagory_name', 'products.product_code', 'products.product_name', DB::raw('SUM(productions.quantitys) as quantity'), DB::raw('SUM(productions.rates) as rate'), DB::raw('SUM(productions.amounts) as amount'))
                ->whereDate('date', '>=', $fromDate)
                ->whereDate('date', '<=', $toDate)
                ->where('productions.company_id', '=', session()->get('company_id'))
                ->groupBy('productions.products_id')

                ->OrderBy('products.product_name', 'asc')->get();
            //return $product;
            return view('production-report.all-item.summary', Compact('catagories', 'company_detail', 'product', 'fromDate', 'toDate'));
        }

        if ($ProductionReport == 3) {
            //return "enter";
            $production = ProductionDetails::with('products_out')->with('uom_pro_details')->with('production')
                //->with('production_details')
                ->orderBy('created_at', 'asc')
                ->whereDate('productions_details.created_at', '>=', $fromDate)
                ->whereDate('productions_details.created_at', '<=', $toDate)
                ->where('company_id', session()->get('company_id'))
                ->get();

            //return $production;


            return view('production-report.all-item.consumed', Compact('production', 'company_detail', 'fromDate', 'toDate'));
        }

        if ($ProductionReport == 4) {
            // $product = Catagory::with(['products' => function ($query)
            // use ($fromDate, $toDate) {
            //     $query->with(['production_stockout' => function ($query) use ($fromDate, $toDate) {
            //         // $query->whereDate('date', '>=', $fromDate);
            //         // $query->whereDate('date', '<=', $toDate);
            //         $query->where('company_id', session()->get('company_id'));
            //         $query->select(DB::raw('SUM(rate) as total'));
            //     }]);
            // }])


            //     ->OrderBy('id', 'asc')->get();

            //return $product;


            $catagories = Catagory::OrderBy('id', 'asc')->get();
            //return $catagories;

            $product = Catagory::join('products', 'products.catagory_id', 'catagories.id')
                ->join('productions_details', 'productions_details.product_id', 'products.id')
                ->select('catagories.id', 'catagories.catagory_name', 'products.product_code', 'products.product_name', DB::raw('SUM(productions_details.quantity) as quantity'), DB::raw('SUM(productions_details.rate) as rate'), DB::raw('SUM(productions_details.amount) as amount'))
                ->whereDate('productions_details.created_at', '>=', $fromDate)
                ->whereDate('productions_details.created_at', '<=', $toDate)
                ->where('productions_details.company_id', '=', session()->get('company_id'))
                ->groupBy('productions_details.product_id')

                ->OrderBy('products.product_name', 'asc')->get();
            //return $product;
            return view('production-report.all-item.consumed-summary', Compact('catagories', 'company_detail', 'product', 'fromDate', 'toDate'));
        }
    }

    public function store(Request $request)
    {
        //return "j";
        $this->validate($request, [
            'product_id' => 'required',
            'from_date' => 'required',
            'to_date' => 'required'
        ]);
        $ProductID = $request->get('product_id');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        $ProductionReport = $request->get('ReportDetail');
        $Product = Product::where('id', '=', $ProductID)->where('company_id', session()->get('company_id'))->get();


        if ($ProductionReport == 1) {
            $production = Production::with('uoms')
                ->with('production_details')
                ->orderBy('date', 'asc')
                //->whereBetween('productions.date', [$fromDate, $toDate])
                ->whereDate('productions.date', '>=', $fromDate)
                ->whereDate('productions.date', '<=', $toDate)
                ->where('products_id', '=', $ProductID)
                ->get();

            //return $production;

            //return $party;
            $company_detail = Setting::where('id', '=', 1)->get();
            return view('production-report.report', Compact('production', 'company_detail', 'Product', 'fromDate', 'toDate'));
        }

        if ($ProductionReport == 2) {

            $production = ProductionDetails::with(['production' => function ($query) {
                $query->with('products');
            }])->with('uom_pro_details')->with('production')
                //->with('production_details')
                ->orderBy('created_at', 'asc')
                ->whereDate('productions_details.created_at', '>=', $fromDate)
                ->whereDate('productions_details.created_at', '<=', $toDate)
                ->where('product_id', '=', $ProductID)
                ->get();


            // $production = Production::with('uoms')
            // ->with('production_details')
            // ->orderBy('date', 'asc')
            // //->whereBetween('productions.date', [$fromDate, $toDate])
            // ->whereDate('productions.date', '>=', $fromDate)
            // ->whereDate('productions.date', '<=', $toDate)
            // ->where('products_id', '=', $ProductID)
            // ->get();

            //return $production;

            //return $party;
            $company_detail = Setting::where('id', '=', 1)->get();
            return view('production-report.consumed-singleitem', Compact('production', 'company_detail', 'Product', 'fromDate', 'toDate'));
        }
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