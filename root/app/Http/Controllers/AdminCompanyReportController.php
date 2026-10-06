<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\RawMaterialStock;
use App\Models\Setting;
use App\Models\User;
use App\Models\Companies;
use Illuminate\Support\Facades\DB;
use Auth;
class AdminCompanyReportController extends Controller
{
       public function index()
    {

        $userID = Auth::User()->id;
        $admin = User::where('id', $userID)->first();
        if($admin->status == "Admin"){
            $partners = User::where('status', 'Partner')->where('type', 'ACTIVE')->pluck('name', 'id')->prepend('All Partners', '0')->toArray();
            $encrypter = app('Illuminate\Encryption\Encrypter');
            $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('companies.report.create', Compact('partners','encrypted_token'));
        }else{
        return redirect()->back()->with([
            'error' => 'Failed to Access Page.',
            'warning' => 'Please review your access.'
        ]);
        }


        
        // $partners = User::where('status', 'Partner')->where('type', 'ACTIVE')->pluck('name', 'id')->prepend('All Partners', '0')->toArray();
        // $encrypter = app('Illuminate\Encryption\Encrypter');
        // $encrypted_token = $encrypter->encrypt(csrf_token());
        // return view('companies.report.create', Compact('partners','encrypted_token'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // return $request;
        $partnerID = $request->get('partner_id');
        $type = $request->get('type');
        //return $ProductID;
        $fromDate = $request->get('from_date');
        //return $fromDate;
        $toDate = $request->get('to_date');
        $company_detail = Setting::where('id', '=', 1)->get();
        if($request->report_type == 1){
            $companies = Companies::with('partner:id,name')
             ->where(function ($query) use ($type) {
                    if ($type) {
                        $query->where('payment_terms', '=', $type);
                    }
                })
                ->where(function ($query) use ($partnerID) {
                    if ($partnerID != 0) {
                        $query->where('partner_id', '=', $partnerID);
                    }
                })
                ->whereDate('created_at', '>=', $fromDate)
                ->whereDate('created_at', '<=', $toDate)
                ->get();

            return view('companies.report.all', Compact('companies', 'company_detail', 'fromDate', 'toDate'));
        }else{
            $companies = Companies::with('partner:id,name')
            ->withCount(['sales' => function($que) use ($fromDate, $toDate){
                 $que->whereDate('date', '>=', $fromDate)
                ->whereDate('date', '<=', $toDate);
            }])
             ->where(function ($query) use ($type) {
                    if ($type) {
                        $query->where('payment_terms', '=', $type);
                    }
                })
                ->where(function ($query) use ($partnerID) {
                    if ($partnerID != 0) {
                        $query->where('partner_id', '=', $partnerID);
                    }
                })
                // ->whereDate('created_at', '>=', $fromDate)
                // ->whereDate('created_at', '<=', $toDate)
                ->get();

            return view('companies.report.invoices', Compact('companies', 'company_detail', 'fromDate', 'toDate'));
        }

       
    }
}
