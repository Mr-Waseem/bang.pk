<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\AccountGroup;
use App\Models\Party;
use App\Models\Warehouse;
use App\Models\Sales;
use App\Models\SaleTax;
use App\Models\PurchaseTax;
use App\Models\Purchase;
use App\Models\GeneralVoucher;
use Illuminate\Support\Facades\DB;

class ProfitLossController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return redirect('profitloss/create');
    }

    public function create()
    {
        $shops = Warehouse::OrderBy('id', 'asc')->pluck('name', 'id')->prepend('ALL BRANCHES', '0');
        //return $shops;
        return view('profitloss.create', Compact('shops'));
    }

    public function store(Request $request)
    {
        //return "stroe";
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        $ShopID = $request->get('shop_id');
        $ShopName = Warehouse::where('id', '=', $ShopID)->get();
        //return $ShopName ;
        //From Purchase table (standard)
        // $purchases = DB::table('purchase_details')
        //  ->whereDate('created_at', '>=', $fromDate)
        //  ->whereDate('created_at', '<=', $toDate)
        // ->Sum('total_cost');
        //return $purchases;
        //From sale table (Cost Amount)

        if ($ShopID == 0) {
            
            //return $purchases;

                $sales = Sales::join('sale_details', 'sale_details.sale_id', '=', 'sales.id')
                ->whereDate('sales.date', '>=', $fromDate)
                ->whereDate('sales.date', '<=', $toDate)
                ->where('sales.company_id', session()->get('company_id'))
                ->select(DB::raw('SUM(sale_details.sale_amount) as sales'))
                ->first();

                 $salesTax = SaleTax::join('sale_tax_details', 'sale_tax_details.sale_id', '=', 'sale_taxes.id')
                ->whereDate('sale_taxes.date', '>=', $fromDate)
                ->whereDate('sale_taxes.date', '<=', $toDate)
                ->where('sale_taxes.company_id', session()->get('company_id'))
                ->select(DB::raw('SUM(sale_tax_details.total) as salesTax'))
                ->first();

                $purchases = Purchase::join('purchase_details', 'purchase_details.purchase_id', '=', 'purchases.id')
                ->whereDate('purchases.date', '>=', $fromDate)
                ->whereDate('purchases.date', '<=', $toDate)
                ->where('purchases.company_id', session()->get('company_id'))
                ->select(DB::raw('SUM(purchase_details.total_cost) as purchases'))
                ->first();

                 $PurchaseTax = PurchaseTax::join('purchase_tax_details', 'purchase_tax_details.purchase_id', '=', 'purchase_taxes.id')
                ->whereDate('purchase_taxes.date', '>=', $fromDate)
                ->whereDate('purchase_taxes.date', '<=', $toDate)
                ->where('purchase_taxes.company_id', session()->get('company_id'))
                ->select(DB::raw('SUM(purchase_tax_details.total) as PurchaseTax'))
                ->first();

                $openingStock = DB::table('raw_material_stocks')
                ->whereDate('date', '<', $fromDate)
                // ->whereDate('date', '<=', $toDate)
                ->Sum('cost_amount');

                $closingStock = DB::table('raw_material_stocks')
                ->whereDate('date', '>=', $fromDate)
                ->whereDate('date', '<=', $toDate)
                ->Sum('cost_amount');

                // $directExpense = DB::table('general_vouchers')
                // ->whereDate('date', '>=', $fromDate)
                // ->whereDate('date', '<=', $toDate)
                // ->Sum('cost_amount');

                // 11 and 12 are OTHER DIRECT EXPENSES & Direct Salary
                $directExpense = GeneralVoucher::join('parties', 'parties.id', '=', 'general_vouchers.account_head_id')
                ->join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
                ->whereDate('general_vouchers.date', '>=', $fromDate)
                ->whereDate('general_vouchers.date', '<=', $toDate)
                ->where('general_vouchers.company_id', session()->get('company_id'))
                ->where('account_groups.id', 11)
                ->Orwhere('account_groups.id', 12)
                ->select(DB::raw('SUM(general_vouchers.debit) as directExpense'))
                ->first();
                // 20 for Depriciation
                $depriciation = GeneralVoucher::join('parties', 'parties.id', '=', 'general_vouchers.account_head_id')
                ->join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
                ->whereDate('general_vouchers.date', '>=', $fromDate)
                ->whereDate('general_vouchers.date', '<=', $toDate)
                ->where('general_vouchers.company_id', session()->get('company_id'))
                ->where('account_groups.id', 20)
                ->select(DB::raw('SUM(general_vouchers.debit) as depriciation'))
                ->first();

                // 9 and 10 are ADMIN EXPENSE AND DISTIRBUTION EXPENSE AND INDIRECT
                $AdminExpense = GeneralVoucher::join('parties', 'parties.id', '=', 'general_vouchers.account_head_id')
                ->join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
                ->whereDate('general_vouchers.date', '>=', $fromDate)
                ->whereDate('general_vouchers.date', '<=', $toDate)
                ->where('general_vouchers.company_id', session()->get('company_id'))
                ->where('account_groups.id', 9)
                ->Orwhere('account_groups.id', 10)
                ->Orwhere('account_groups.id', 13)
                ->select(DB::raw('SUM(general_vouchers.debit) as AdminExpense'))
                ->first();

                $Markup = GeneralVoucher::join('parties', 'parties.id', '=', 'general_vouchers.account_head_id')
                ->join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
                ->whereDate('general_vouchers.date', '>=', $fromDate)
                ->whereDate('general_vouchers.date', '<=', $toDate)
                 ->where('general_vouchers.company_id', session()->get('company_id'))
                ->where('account_groups.id', 28)
                 ->select(DB::raw('SUM(general_vouchers.credit) as Markup'))
                ->first();

                $OtherIncome = GeneralVoucher::join('parties', 'parties.id', '=', 'general_vouchers.account_head_id')
                ->join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
                ->whereDate('general_vouchers.date', '>=', $fromDate)
                ->whereDate('general_vouchers.date', '<=', $toDate)
                 ->where('general_vouchers.company_id', session()->get('company_id'))
                ->where('account_groups.id', 27)
                 ->select(DB::raw('SUM(general_vouchers.credit) as OtherIncome'))
                ->first();

                $Taxation = GeneralVoucher::join('parties', 'parties.id', '=', 'general_vouchers.account_head_id')
                ->join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
                ->whereDate('general_vouchers.date', '>=', $fromDate)
                ->whereDate('general_vouchers.date', '<=', $toDate)
                ->where('general_vouchers.company_id', session()->get('company_id'))
                ->where('account_groups.id', 26)
                ->select(DB::raw('SUM(general_vouchers.debit) as Taxation'))
                ->first();

            $expenses = Party::join('general_vouchers', 'general_vouchers.account_head_id', '=', 'parties.id')
                ->whereDate('general_vouchers.date', '>=', $fromDate)
                ->whereDate('general_vouchers.date', '<=', $toDate)
                ->where('parties.account_group_id', '=', 6)
                ->where('parties.company_id', session()->get('company_id'))
                //->Orwhere('parties.account_group_id', '=', 11)
                //->Orwhere('parties.account_group_id', '=', 12)
                //->Orwhere('parties.account_group_id', '=', 27)
                ->select('parties.party_name', DB::raw('SUM(general_vouchers.debit) as debit'))
                ->groupBy('account_head_id')
                ->OrderBy('parties.id')
                ->Sum('debit')
                ->get();

            $expensesCenters = Party::join('general_vouchers', 'general_vouchers.account_head_id', '=', 'parties.id')

                ->whereDate('general_vouchers.date', '>=', $fromDate)
                ->whereDate('general_vouchers.date', '<=', $toDate)
                ->where('parties.account_group_id', '=', 27)
                ->where('parties.company_id', session()->get('company_id'))
                //->Orwhere('parties.account_group_id', '=', 11)
                //->Orwhere('parties.account_group_id', '=', 12)
                //->Orwhere('parties.account_group_id', '=', 27)
                ->select('parties.party_name', DB::raw('SUM(general_vouchers.debit) as debit'))
                ->groupBy('account_head_id')
                ->OrderBy('parties.id')
                ->Sum('debit')
                ->get();

            $salary = Party::join('general_vouchers', 'general_vouchers.account_head_id', '=', 'parties.id')

                ->whereDate('general_vouchers.date', '>=', $fromDate)
                ->whereDate('general_vouchers.date', '<=', $toDate)
                ->where('parties.account_group_id', '=', 8)
                ->where('parties.company_id', session()->get('company_id'))
                ->select('parties.party_name', DB::raw('SUM(general_vouchers.debit) as debit'))
                ->groupBy('account_head_id')
                ->Sum('debit')
                ->get();

            //$employees = Party::where('account_type', '=', "EMPLOYEES")->get();
            // $employees = AttendanceDetails::with('employees')
            // ->whereDate('in_time', '>=', $fromDate)
            // ->whereDate('in_time', '<=', $toDate)->get();

            $employees = Party::with(['attendance_details' => function ($query) use ($fromDate, $toDate) {
                $query->whereDate('in_time', '>=', $fromDate);
                $query->whereDate('in_time', '<=', $toDate);
            }])
                //->whereDate('in_time', '>=', $fromDate)
                //->whereDate('in_time', '<=', $toDate)
                ->where('account_type', '=', "EMPLOYEES")
                ->get();
            //return $employees;
            $datetime1 = strtotime($fromDate); // convert to timestamps
            $datetime2 = strtotime($toDate); // convert to timestamps
            $day = (int)(($datetime2 - $datetime1) / 86400); // will give the difference in days , 86400 is the timestamp difference of a day
            $days = $day + 1;
            //return $days;
            //return $employees;
            // $expenses = AccountGroup::with('parties')

            //                 ->with('general_vouchers')
            //                 ->where('id', '=', 6)
            //                 ->get();
            //return $expenses;
            $company_detail = Setting::where('id', '=', 1)->get();
            //$all = $expense->expense;
            //return $expenses;
            return view('profitloss.index', Compact('purchases', 'PurchaseTax', 'sales', 'salesTax', 'openingStock', 'closingStock', 'directExpense', 'depriciation', 'AdminExpense', 'Taxation', 'Markup', 'OtherIncome', 'expenses', 'expensesCenters', 'company_detail', 'fromDate', 'toDate', 'salary', 'employees', 'days', 'ShopName'));
        } else {
            //return "g";
            $purchases = DB::table('sale_details')
                ->where('warehouse_id', '=', $ShopID)
                ->whereDate('created_at', '>=', $fromDate)
                ->whereDate('created_at', '<=', $toDate)
                ->Sum('cost_amount');
            //return $purchases;

            $sales = DB::table('sale_details')
                ->where('warehouse_id', '=', $ShopID)
                ->whereDate('created_at', '>=', $fromDate)
                ->whereDate('created_at', '<=', $toDate)
                ->Sum('sale_amount');

            $salesTax = DB::table('sale_tax_details')
                ->whereDate('created_at', '>=', $fromDate)
                ->whereDate('created_at', '<=', $toDate)
                ->Sum('total');

            $expenses = Party::join('general_vouchers', 'general_vouchers.account_head_id', '=', 'parties.id')

                ->whereDate('general_vouchers.date', '>=', $fromDate)
                ->whereDate('general_vouchers.date', '<=', $toDate)
                // ->where('general_vouchers.warehouse_id', '=', $ShopID)
                ->where('general_vouchers.company_id', '=', session()->get('company_id'))
                ->where('parties.account_group_id', '=', 6)
                ->where('parties.company_id', session()->get('company_id'))
                //->Orwhere('parties.account_group_id', '=', 11)
                //->Orwhere('parties.account_group_id', '=', 12)
                //->Orwhere('parties.account_group_id', '=', 27)
                ->select('parties.party_name', DB::raw('SUM(general_vouchers.debit) as debit'))
                ->groupBy('account_head_id')
                ->OrderBy('parties.id')
                ->Sum('debit')
                ->get();


            $expensesCenters = Party::join('general_vouchers', 'general_vouchers.account_head_id', '=', 'parties.id')

                ->whereDate('general_vouchers.date', '>=', $fromDate)
                ->whereDate('general_vouchers.date', '<=', $toDate)
                // ->where('general_vouchers.warehouse_id', '=', $ShopID)
                ->where('general_vouchers.company_id', '=', session()->get('company_id'))
                ->where('parties.account_group_id', '=', 27)
                ->where('parties.company_id', session()->get('company_id'))
                //->Orwhere('parties.account_group_id', '=', 11)
                //->Orwhere('parties.account_group_id', '=', 12)
                //->Orwhere('parties.account_group_id', '=', 27)
                ->select('parties.party_name', DB::raw('SUM(general_vouchers.debit) as debit'))
                ->groupBy('account_head_id')
                ->OrderBy('parties.id')
                ->Sum('debit')
                ->get();


            $salary = Party::join('general_vouchers', 'general_vouchers.account_head_id', '=', 'parties.id')

                ->whereDate('general_vouchers.date', '>=', $fromDate)
                ->whereDate('general_vouchers.date', '<=', $toDate)
                // ->where('general_vouchers.warehouse_id', '=', $ShopID)
                ->where('general_vouchers.company_id', '=', session()->get('company_id'))
                ->where('parties.account_group_id', '=', 8)
                ->where('parties.company_id', session()->get('company_id'))
                ->select('parties.party_name', DB::raw('SUM(general_vouchers.debit) as debit'))
                ->groupBy('account_head_id')
                ->Sum('debit')
                ->get();



            $employees = Party::with(['attendance_details' => function ($query) use ($fromDate, $toDate) {
                $query->whereDate('in_time', '>=', $fromDate);
                $query->whereDate('in_time', '<=', $toDate);
            }])
                //->whereDate('in_time', '>=', $fromDate)
                //->whereDate('in_time', '<=', $toDate)
                ->where('account_type', '=', "EMPLOYEES")
                ->where('shop_id', '=', $ShopID)
                ->get();
            //return $employees;
            $datetime1 = strtotime($fromDate); // convert to timestamps
            $datetime2 = strtotime($toDate); // convert to timestamps
            $day = (int)(($datetime2 - $datetime1) / 86400); // will give the difference in days , 86400 is the timestamp difference of a day
            $days = $day + 1;

            $company_detail = Setting::where('id', '=', 1)->get();
            //return "sgss";
            return view('profitloss.branchwise', Compact('purchases', 'sales', 'salesTax', 'expenses', 'expensesCenters', 'company_detail', 'fromDate', 'toDate', 'salary', 'employees', 'days', 'ShopName'));
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
