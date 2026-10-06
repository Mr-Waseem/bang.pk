<?php

namespace App\Http\Controllers;

use App\Models\GeneralVoucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPSTORM_META\map;

class SalarySheetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('salary-sheet.create');
    }

    public function findReport(Request $request)
    {
        $fromDate = $request->from_date;
        $toDate = $request->to_date;

        $data = GeneralVoucher::join('parties','parties.id','=','general_vouchers.account_head_id')
        ->where('parties.company_id',session()->get('company_id'))
        ->where('parties.account_group_id','8')
        ->whereDate('general_vouchers.created_at','>=',$fromDate)
        ->whereDate('general_vouchers.created_at','<=',$toDate)
        ->groupBy('general_vouchers.account_head_id')
        ->get([
            'parties.party_name',
            'parties.cnic',
            'parties.designation',
            // 'parties.deduction',
            'parties.basic_salary',
            'parties.allowance',
            'parties.status',
            DB::raw('SUM(general_vouchers.debit) as net_salary'),
            'general_vouchers.debit as deduction'
        ]);


        return view('salary-sheet.index',compact('fromDate','toDate','data'));
    }
}
