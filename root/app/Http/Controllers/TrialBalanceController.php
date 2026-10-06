<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\AccountGroup;

class TrialBalanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return redirect('trial-balance/create');
    }


    public function Receiveables()
    {
        $debit = AccountGroup::with('parties')->with('general_vouchers')
            //$query->groupBy('account_group_id');
            ->where('account_groups.id', '=', 1)
            ->OrderBy('account_groups.name')->get();
        $company_detail = Setting::where('id', '=', 1)->get();
        //return $debit; 
        return view('trial-balance.receiveable', Compact('debit', 'credit', 'company_detail'));
    }

    public function create()
    {
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('trial-balance.create', Compact('encrypted_token'));
    }

    public function store(Request $request)
    {
        // return $request;
        $ReportDetail = $request->get('ReportDetail');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
// return "Ddd";

        //$debit = AccountGroup::with('parties')->with('general_vouchers')
        //$query->groupBy('account_group_id');
        //->get();

        if($ReportDetail==1){
        // return session()->get('company_id');
            $debit = AccountGroup::with(['parties' => function ($query)
            use ($fromDate, $toDate) {
                // $query->where('parties.company_id', session()->get('company_id'));
                $query->with(['general_vouchers' => function ($query) use ($fromDate, $toDate) {
                    $query->where('company_id', session()->get('company_id'));
                    $query->whereDate('date', '>=', $fromDate);
                    $query->whereDate('date', '<=', $toDate);
                }]);
            }])
                ->OrderBy('id', 'asc')->get();
    
            //return $debit;
           
            $company_detail = Setting::where('id', '=', 1)->get();
    
            return view('trial-balance.summary.index', Compact('debit', 'company_detail', 'fromDate', 'toDate'));
        }

    if($ReportDetail==2){
        // return "s";
        $debit = AccountGroup::with(['parties' => function ($query)
        use ($fromDate, $toDate) {
            $query->where('parties.company_id', session()->get('company_id'));
            $query->with(['general_vouchers' => function ($query) use ($fromDate, $toDate) {
                $query->whereDate('date', '>=', $fromDate);
                $query->whereDate('date', '<=', $toDate);
            }]);
        }])
            ->OrderBy('id', 'asc')->get();

        // return $debit;
       
        $company_detail = Setting::where('id', '=', 1)->get();

        return view('trial-balance.detail.index', Compact('debit', 'company_detail', 'fromDate', 'toDate'));

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
