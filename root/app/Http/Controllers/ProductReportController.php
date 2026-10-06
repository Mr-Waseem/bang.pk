<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use App\Models\SaleTax;
use App\Models\SaleTaxDetails;
use App\Models\Catagory;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {   
        $products = Product::OrderBy('product_name', 'asc')
            ->where('company_id', session()->get('company_id'))
            ->pluck('product_name', 'id')
            ->prepend('All Products', 0)
            ->toArray();
           
        return view('product-report.index', compact('products'));
    }
    public function report(Request $request)
    {
        $this->validate($request, [
            'from_date' => 'required',
            'to_date' => 'required'
        ]);
        $product = $request->product_id;
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        $company_detail = Setting::where('id', '=', 1)->get();
        $type = $request->sale_type;
        $reportType = $request->report_type ?? 'detailed';
        $saleTypeLabel = ($type == 0) ? 'SalesTax Invoice' : 'Debit Note';

        // If user requested a summary report, aggregate results by product
        if ($reportType == 'summary') {
            $query = SaleTaxDetails::where('sale_type1', $saleTypeLabel)
                ->whereDate('date', '>=', $fromDate)
                ->whereDate('date', '<=', $toDate)
                // hs_code column may not exist in products table in this schema
                ->with('products:id,product_code,product_name')
                ->where('company_id', session()->get('company_id'));

            if ($product != 0) {
                $query->where('product_id', $product);
            }

            $rows = $query->get();

            if ($rows->isEmpty()) {
                Session::flash('error_message', 'Records Do Not Exist');
                return redirect()->back();
            }

            $report = $rows->groupBy('product_id')->map(function ($items) {
                $product = $items->first()->products;
                $hs_code = isset($product->hs_code) ? $product->hs_code : (isset($product->product_code) ? $product->product_code : '');

                return (object) [
                    'hs_code' => $hs_code,
                    'product_name' => $product->product_name ?? '',
                    'qty' => $items->sum('quantity'),
                    'exclusive_value' => $items->sum(function ($i) { return ($i->total - $i->taxvalue); }),
                    'tax_value' => $items->sum('taxvalue'),
                    'total_amount' => $items->sum('total'),
                ];
            })->values();

            return view('product-report.reportsummary', compact('company_detail', 'report', 'fromDate', 'toDate', 'saleTypeLabel'));
        }
        if ($type==0)
        {
        if ($product == 0) {
            $report= SaleTaxDetails::
            where('sale_type1','SalesTax Invoice')
            ->with('sale_taxes')
            
            ->whereDate('date', '>=', $fromDate)
            ->whereDate('date', '<=', $toDate)
            ->with('products:id,product_code,product_name')
            ->where('company_id', session()->get('company_id'))
            ->OrderBy('invoice_no','asc')
            ->get();
            // return $reports[0];
            if (empty($report[0])){
                Session::flash('error_message', 'Records Do Not Exist');
                return redirect()->back();
            }
            return view('product-report.reportall', compact('company_detail','report', 'fromDate', 'toDate'));
        }
        else
        { 
            // return "dd";
            $report = SaleTaxDetails::where('sale_type1','SalesTax Invoice')
            ->with('sale_taxes')
            // ->where('sale_type',0)
            ->whereDate('date', '>=', $fromDate)
            ->whereDate('date', '<=', $toDate)
            ->with('products:id,product_code,product_name')
            ->with('party:id,party_name,ntn')
            ->where('product_id',$product)
            ->where('company_id', session()->get('company_id'))
            ->OrderBy('invoice_no','asc')
            ->get();
            //  return $report;
            if (empty($report[0])){
                Session::flash('error_message', 'Records Do Not Exist');
                return redirect()->back();
            }
            return view('product-report.reportsingle', compact('company_detail', 'report', 'fromDate', 'toDate'));
        }
    }
      else  {
        if ($product == 0) {
            $report= SaleTaxDetails::where('sale_type1','Debit Note')
            ->with('sale_taxes')
             
            ->whereDate('date', '>=', $fromDate)
            ->whereDate('date', '<=', $toDate)
            ->with('products:id,product_code,product_name')
            ->where('company_id', session()->get('company_id'))
            ->OrderBy('invoice_no','asc') 
            ->get();
            // return $reports[0];
            if (empty($report[0])){
                Session::flash('error_message', 'Records Do Not Exist');
                return redirect()->back();
            }
            return view('product-report.reportall', compact('company_detail','report', 'fromDate', 'toDate'));
        }
        else
        { 
            // return "dd";
            $report = SaleTaxDetails::where('sale_type1','Debit Note')
            ->with('sale_taxes')
            ->whereDate('date', '>=', $fromDate)
            ->whereDate('date', '<=', $toDate)
            ->with('products:id,product_code,product_name')
            ->with('party:id,party_name,ntn')
            ->where('product_id',$product)
            ->where('company_id', session()->get('company_id'))
            ->OrderBy('invoice_no','asc')
            ->get();
            //  return $report;
            if (empty($report[0])){
                Session::flash('error_message', 'Records Do Not Exist.');
                return redirect()->back();
            }
            return view('product-report.reportsingle', compact('company_detail', 'report', 'fromDate', 'toDate'));
        }
    }
    }
}
