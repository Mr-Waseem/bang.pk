<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\Setting;
use App\Models\PurchaseDetail;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\DB;

class WarehouseStockReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $warehouse = Warehouse::OrderBy('name', 'asc')->pluck('name', 'id')->prepend('Select Warehouse', '')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('warehouse-stock-report.index', Compact('encrypted_token', 'warehouse'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'warehouse_id' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'report_type' => 'required'
        ]);
        $WarehouseID = $request->get('warehouse_id');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        $reportType = $request->get('report_type');

        $warehouse = Warehouse::where('id', '=', $WarehouseID)->get();
        
        if ($reportType == 'product_wise') {
            $product = PurchaseDetail::join('products', 'products.id', 'purchase_details.product_id')
                ->select(DB::raw('product_code, product_name,quantity,sum(unit_cost) as cost , sum(total_cost) as total_cost ,sum(quantity) as stock'))
                ->groupBy('product_id')
                ->where('warehouse_id', '=', $warehouse[0]->id)
                ->get();
        } else {
            $product = PurchaseDetail::join('products', 'products.id', 'purchase_details.product_id')
                ->select(DB::raw('product_code, sum(unit_cost) as cost , sum(total_cost) as total_cost ,sum(quantity) as stock'))
                ->groupBy('product_code')
                ->where('warehouse_id', '=', $warehouse[0]->id)
                ->get();
        }

        $company_detail = Setting::where('id', '=', 1)->get();
        return view('warehouse-stock-report.warehouse-in-pcs', Compact('product', 'company_detail', 'warehouse', 'reportType'));
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
