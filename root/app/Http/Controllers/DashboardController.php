<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SaleTax;
use App\Models\SaleTaxDetails;
use App\Models\PurchaseTaxDetails;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (!session()->has('company_id')) {
            return redirect('company');
            }

            $companyID = session()->get('company_id');
        $today = now()->toDateString();
        $month = now()->month;
        $year = now()->year;

        $stats = Cache::remember(
            "dashboard_stats_{$companyID}_{$today}_{$month}_{$year}",
            180,
            function () use ($companyID, $today, $month, $year) {
                return $this->loadDashboardStats($companyID, $today, $month, $year);
            }
        );

        $CurrentUser = User::with('roles')->find(Auth::id());
        $saleinvoices = $this->todaySaleInvoices($companyID);
        $unapproved = $this->unapprovedSaleInvoices($companyID);

        return view('dashboard.index', array_merge($stats, [
            'saleinvoices' => $saleinvoices,
            'unapproved' => $unapproved,
            'CurrentUser' => $CurrentUser,
            // Legacy compact keys kept for backward compatibility (unused in current dashboard view).
            'party' => 0,
            'product' => 0,
            'user' => 0,
            'purchases' => 0,
            'sales' => '',
            'Gstsales' => 0,
            'totalPurchase' => 0,
            'shop' => collect(),
            'company_detail' => '',
            'monthlyCashSale' => '',
            'GSTSales' => '',
            'monthlyCreditSale' => '',
            'banks' => '',
            'dailyCashSale' => '',
            'dailyCreditSale' => '',
            'dailyGSTSale' => '',
            'dailyCashReceipt' => '',
            'dailybankReceipt' => '',
            'dailyPostDatedReceipt' => '',
            'dailyCashPayment' => '',
            'dailyBankPayment' => '',
        ]));
    }

    /**
     * Aggregated today + month metrics (cached, read-only).
     */
    private function loadDashboardStats($companyID, $today, $month, $year)
    {
        $todayRow = SaleTaxDetails::where('company_id', $companyID)
            ->whereDate('created_at', $today)
            ->selectRaw("
                COALESCE(SUM(CASE WHEN sale_type1 = 'SalesTax Invoice' THEN total ELSE 0 END), 0) as todaySale,
                COALESCE(SUM(CASE WHEN sale_type1 = 'SalesTax Invoice' THEN price ELSE 0 END), 0) as todayexclusive,
                COALESCE(SUM(CASE WHEN sale_type1 = 'SalesTax Invoice' THEN taxvalue ELSE 0 END), 0) as todayTax,
                COALESCE(SUM(CASE WHEN sale_type1 = 'SalesTax Invoice' THEN extraTaxValue ELSE 0 END), 0) as todayExtraTax,
                COALESCE(SUM(CASE WHEN sale_type1 = 'Credit Note' THEN total ELSE 0 END), 0) as todaySaleReturn
            ")
            ->first();

        $monthSaleRow = SaleTaxDetails::where('company_id', $companyID)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->selectRaw("
                COALESCE(SUM(CASE WHEN sale_type1 = 'SalesTax Invoice' THEN total ELSE 0 END), 0) as currentMonthSale,
                COALESCE(SUM(CASE WHEN sale_type1 = 'SalesTax Invoice' THEN price ELSE 0 END), 0) as currentMonthexclusive,
                COALESCE(SUM(CASE WHEN sale_type1 = 'SalesTax Invoice' THEN taxvalue ELSE 0 END), 0) as currentMonthTax,
                COALESCE(SUM(CASE WHEN sale_type1 = 'SalesTax Invoice' THEN extraTaxValue ELSE 0 END), 0) as currentMonthExtraTax,
                COALESCE(SUM(CASE WHEN sale_type1 = 'Credit Note' THEN total ELSE 0 END), 0) as currentMonthSaleReturn
            ")
            ->first();

        $monthPurchaseRow = PurchaseTaxDetails::query()
            ->join('purchase_taxes', 'purchase_taxes.id', '=', 'purchase_tax_details.purchase_id')
            ->where('purchase_tax_details.company_id', $companyID)
            ->whereMonth('purchase_taxes.date', $month)
            ->whereYear('purchase_taxes.date', $year)
            ->selectRaw('
                COALESCE(SUM(purchase_tax_details.total), 0) as currentMonthPurchase,
                COALESCE(SUM(purchase_tax_details.taxvalue), 0) as currentMonthPurchaseTax
            ')
            ->first();

        return [
            'todaySale' => $todayRow->todaySale,
            'todayexclusive' => $todayRow->todayexclusive,
            'todayTax' => $todayRow->todayTax,
            'todayExtraTax' => $todayRow->todayExtraTax,
            'todaySaleReturn' => $todayRow->todaySaleReturn,
            'currentMonthSale' => $monthSaleRow->currentMonthSale,
            'currentMonthexclusive' => $monthSaleRow->currentMonthexclusive,
            'currentMonthTax' => $monthSaleRow->currentMonthTax,
            'currentMonthExtraTax' => $monthSaleRow->currentMonthExtraTax,
            'currentMonthSaleReturn' => $monthSaleRow->currentMonthSaleReturn,
            'currentMonthPurchase' => $monthPurchaseRow->currentMonthPurchase,
            'currentMonthPurchaseTax' => $monthPurchaseRow->currentMonthPurchaseTax,
        ];
    }

    private function saleInvoiceBaseQuery()
    {
        return SaleTax::select([
                'sale_taxes.id',
                'sale_taxes.date',
                'sale_taxes.dcn_no',
                'sale_taxes.invoice_no',
                'sale_taxes.sale_type',
                'parties.party_name',
                'parties.ntn',
                'users.name as biller_name',
                DB::raw('SUM(sale_tax_details.rate * sale_tax_details.quantity) as total_amount'),
                DB::raw('SUM(sale_tax_details.taxvalue) as total_tax'),
            DB::raw('SUM(sale_tax_details.total) as grand_total'),
            ])
            ->join('sale_tax_details', 'sale_taxes.id', '=', 'sale_tax_details.sale_id')
            ->leftJoin('parties', 'sale_taxes.party_id', '=', 'parties.id')
            ->leftJoin('users', 'users.id', '=', 'sale_taxes.biller');
    }

    private function saleInvoiceGroupBy()
    {
        return [
                'sale_taxes.id',
                'sale_taxes.date',
                'sale_taxes.dcn_no',
                'sale_taxes.invoice_no',
            'sale_taxes.sale_type',
                'parties.party_name',
                'parties.ntn',
            'users.name',
        ];
    }

    private function todaySaleInvoices($companyID)
    {
        return $this->saleInvoiceBaseQuery()
            ->whereDate('sale_taxes.created_at', now()->toDateString())
            ->where('sale_taxes.company_id', $companyID)
            ->where('sale_taxes.invoice_no', '!=', '0')
            ->groupBy($this->saleInvoiceGroupBy())
            ->orderByDesc('sale_taxes.id')
            ->get();
    }

    private function unapprovedSaleInvoices($companyID)
    {
        return $this->saleInvoiceBaseQuery()
            ->where('sale_taxes.company_id', $companyID)
            ->whereNull('sale_taxes.fbr_invoice_no')
            ->groupBy($this->saleInvoiceGroupBy())
            ->orderBy('sale_taxes.invoice_no', 'asc')
            ->get();
    }

    public function calender()
    {
        return view('calender.index');
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
