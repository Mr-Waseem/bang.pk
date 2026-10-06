<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductionStock;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class ProductionStockController extends Controller
{
    public function index()
    {
        return view('warehouse-stock-report.production-create');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {

        $fromDate = $request->get('from_date');
        //return $fromDate;
        $toDate = $request->get('to_date');
        $ProductionStock = ProductionStock::join('products', 'products.id', 'production_stocks.product_id')
            ->select(DB::raw('product_code, product_name, product_cost, sum(cost_amount), sum(stockin) as stockin ,sum(stockout) as stockout'))
            ->groupBy('product_id')
            //->where('warehouse_id', '=', $warehouse[0]->id)
            ->whereDate('production_stocks.created_at', '>=', $fromDate)
            ->whereDate('production_stocks.created_at', '<=', $toDate)
            ->where('production_stocks.company_id', session()->get('company_id'))
            ->get();
        $company_detail = Setting::where('id', '=', 1)->get();
        //return $ProductionStock;
        return view('warehouse-stock-report.production-stock', Compact('ProductionStock', 'company_detail', 'fromDate', 'toDate'));
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