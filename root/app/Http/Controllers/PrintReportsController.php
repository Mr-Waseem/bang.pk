<?php

namespace App\Http\Controllers;

use App\Models\AccountGroup;
use App\Models\Party;
use App\Models\PurchaseTax;
use App\Models\SaleTax;
use App\Models\Vouchers;
use App\Models\Companies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrintReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $AccountGroups = AccountGroup::where('code','!=',10)
                        ->where('code','!=',11)
                        ->where('code','!=',12)
                        ->OrderBy('name', 'asc')
                        ->pluck('name', 'id')
                        ->prepend('Select Category','');
        $Heads = Party::OrderBy('party_name', 'asc')
                        ->where('party_name', '!=', 'CASH IN HAND')
                        ->where('company_id', session()->get('company_id'))
                        ->pluck('party_name', 'id')
                        ->prepend('Select Account', '')
                        ->toArray();

        $currentWarehouseId = Auth::check() ? Auth::user()->shop_id : null;
        $currentWarehouseParties = Party::where('company_id', session()->get('company_id'))
                        ->whereRaw('UPPER(account_type) = ?', ['DEBTOR'])
                        ->when($currentWarehouseId, function ($query) use ($currentWarehouseId) {
                            return $query->where('shop_id', $currentWarehouseId);
                        })
                        ->OrderBy('party_name', 'asc')
                        ->pluck('party_name', 'id')
                        ->prepend('All Parties', '');

        return view('print-reports.create', compact('AccountGroups', 'Heads', 'currentWarehouseParties'));
    }

    public function findReport(Request $request)
    {
        $fromDate = $request->from_date;
        $toDate = $request->to_date;
        $HeadID = $request->head_id;
        $partyId = $request->party_id;

        if($request->report_type=='cr'){
            $cash_receipt_detail = Vouchers::with(['voucher_details' => function ($query){
                $query->with('parties');
            }])
                ->with('parties')
                ->whereDate('created_at','>=',$fromDate)
                ->whereDate('created_at','<=',$toDate)
                ->where('company_id', session()->get('company_id'))
                ->where('v_type','Cash Receipt')
                ->OrderBy('id','desc')
                ->get();



            return view('print-reports.cash-reciept-report',compact('cash_receipt_detail','fromDate','toDate','HeadID'));
        }
        else 
        if($request->report_type=='cp'){
            $cash_payment_detail = Vouchers::with(['voucher_details' => function ($query) {
                $query->with('parties');
            }])
                ->with('parties')
                ->whereDate('created_at','>=',$fromDate)
                ->whereDate('created_at','<=',$toDate)
                ->where('company_id', session()->get('company_id'))
                ->where('v_type','Cash Payment')
                ->get();

            return view('print-reports.cash-payment-report',compact('cash_payment_detail','fromDate','toDate'));
        }
        else 
        if($request->report_type=='br'){
            $bank_receipt_detail = Vouchers::with(['voucher_details' => function ($query) {
                $query->with('banks');
                $query->with('parties');
            }])->with('parties')
                ->whereDate('created_at','>=',$fromDate)
                ->whereDate('created_at','<=',$toDate)
                ->where('company_id', session()->get('company_id'))
                ->where('v_type','Bank Receipt')
                ->get();

            return view('print-reports.bank-receipt-report',compact('bank_receipt_detail','fromDate','toDate'));
        }
        else 
        if($request->report_type=='bp'){
            $bank_payment_detail = Vouchers::with(['voucher_details' => function ($query) {
                $query->with('banks');
                $query->with('parties');
            }])->with('parties')
                ->whereDate('created_at','>=',$fromDate)
                ->whereDate('created_at','<=',$toDate)
                ->where('company_id', session()->get('company_id'))
                ->where('v_type','Bank Payment')
                ->get();

            return view('print-reports.bank-payment-report',compact('bank_payment_detail','fromDate','toDate'));
        }
        else 
        if($request->report_type=='pt'){
            $purchase_tax_detail = PurchaseTax::with(['purchasetax_details' => function ($query) {
                $query->with('products');
            }])->whereDate('created_at','>=',$fromDate)
                ->whereDate('created_at','<=',$toDate)
                ->where('company_id', session()->get('company_id'))
                ->get();

            return view('print-reports.purchase-tax-report',compact('purchase_tax_detail','fromDate','toDate'));
        }
        else 
        if($request->report_type=='st'){
            $currentWarehouseId = Auth::check() ? Auth::user()->shop_id : null;

            $sales_tax_detail = SaleTax::with(['saletax_details' => function ($query) {
                $query->with('unit')->with('products');
            }])->with('parties')->with('shop')
                ->where('company_id', session()->get('company_id'))
                ->whereDate('date','>=',$fromDate)
                ->whereDate('date','<=',$toDate)
                ->when($currentWarehouseId, function ($query) use ($currentWarehouseId) {
                    return $query->where('warehouse_id', $currentWarehouseId);
                });

            if (!empty($partyId)) {
                $sales_tax_detail = $sales_tax_detail->where('party_id', $partyId);
            }

            $sales_tax_detail = $sales_tax_detail->get();

            $sellerCompany = Companies::where('id', session()->get('company_id'))->first();

            // choose print view based on company's invoice_design
            $view = 'print-reports.paktraders';
            if ($sellerCompany) {
                if ($sellerCompany->invoice_design == 1) {
                    $view = 'print-reports.invoice';
                } elseif ($sellerCompany->invoice_design == 2) {
                    $view = 'print-reports.spi';
                } elseif ($sellerCompany->invoice_design == 3) {
                    $view = 'print-reports.topnotch-template';
                } elseif ($sellerCompany->invoice_design == 4) {
                    $view = 'print-reports.ashoes-template';
                } else {
                    $view = 'print-reports.paktraders';
                }
            }

            return view($view, compact('sales_tax_detail','fromDate','toDate','sellerCompany'));
        }
        else 
        if($request->report_type=='jv'){
            $general_voucher =  Vouchers::with(['voucher_details' => function ($query) {
                $query->with('banks');
                $query->with('parties');
            }])->with('parties')
                ->whereDate('created_at','>=',$fromDate)
                ->whereDate('created_at','<=',$toDate)
                ->where('company_id', session()->get('company_id'))
                ->where('v_type','Journal Voucher')
                ->get();

            return view('print-reports.jv-report',compact('general_voucher','fromDate','toDate'));
        }else{
            abort(404);
        }
    }
}
