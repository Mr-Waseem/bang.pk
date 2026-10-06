<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use App\Models\Setting;
use App\Models\PurchaseDetail;
use App\Models\SaleDetail;
use App\Models\WorkingProgress;
use Illuminate\Support\Facades\DB;

class StockIssueReportController extends Controller
{
    public function index()
    {
        return view('stockissue-report.stockissue-create');
    }
    public function print_report(Request $request)
    {
        $fromDate = $request->from_date;
        $toDate = $request->to_date;
        $stockIssue = WorkingProgress::whereDate('created_at', '>=', $fromDate)
            ->whereDate('created_at', '<=', $toDate)
            // ->where('company_name', session()->get('company_name'))
            ->get();
        // return $stockIssue;
        return view('stockissue-report.stockissue-report', compact('stockIssue', 'fromDate', 'toDate'));
    }
}