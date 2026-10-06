<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttendanceDetails;
use App\Models\Setting;
use App\Models\Party;
use App\Models\Warehouse;

class AttendanceReportController extends Controller
{
    public function index()
    {

        $Heads = Party::where('account_type', '=', 'EMPLOYEES')->OrderBy('party_name', 'asc')->pluck('party_name', 'id')->prepend('Select Account', '')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('attendance.attendance-report.single-employee.index', Compact('encrypted_token', 'Heads'));
    }

    public function singleEmployee(Request $request)
    {
        $this->validate($request, [
            'head_id' => 'required',
            'from_date' => 'required',
            'to_date' => 'required'
        ]);
        $EmployeeID = $request->get('head_id');
        $shopID = $request->get('shop_id');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        $ReportDetail = $request->get('ReportDetail');
        //return $EmployeeID;


        $company_detail = Setting::where('id', '=', 1)->get();
        $party = Party::where('id', '=', $EmployeeID)->get();




        if ($ReportDetail == 1) {
            return "not used";
            $GeneralVoucher = AttendanceDetails::with('banks')
                ->orderBy('date', 'asc')
                ->OrderBy('id', 'asc')
                // ->whereBetween('general_vouchers.date', [$fromDate, $toDate])
                ->whereDate('general_vouchers.date', '>=', $fromDate)
                ->whereDate('general_vouchers.date', '<=', $toDate)
                ->where('account_head_id', '=', $EmployeeID)->get();
            //return $sales;
            return view('client-all-report.report', Compact('GeneralVoucher', 'company_detail', 'party', 'fromDate', 'toDate'));
        }

        if ($ReportDetail == 2) {
            //return "2";
            //  $items = AttendanceDetails::with('attendances')->where('employee_id', '=', $EmployeeID)

            //    ->whereDate('in_time', '>=', $fromDate)
            //     ->whereDate('in_time', '<=', $toDate)

            // ->OrderBy('vr_date', 'asc')->get();


            $items = Party::with(['attendance_details' => function ($query) use ($fromDate, $toDate, $EmployeeID) {
                $query->whereDate('in_time', '>=', $fromDate);
                $query->whereDate('in_time', '<=', $toDate);
            }])
                ->where('account_type', '=', 'EMPLOYEES')
                ->where('id', '=', $EmployeeID)
                ->OrderBy('id', 'asc')->get();

            //return $items;

            return view('attendance.attendance-report.single-employee.report', Compact('items', 'company_detail', 'party', 'fromDate', 'toDate'));
        }
    }

    public function create()
    {
        $shops = Warehouse::where('id', '!=', 1)->OrderBy('id', 'asc')->pluck('name', 'id')->toArray();
        //return $shops;
        $users = Party::where('account_type', '=', 'EMPLOYEES')->OrderBy('party_name', 'asc')->pluck('party_name', 'id')->prepend('Select Account', '')->toArray();
        return view('attendance.attendance-report.index', Compact('shops','users'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'from_date' => 'required',
            'to_date' => 'required'
        ]);
        $shopID = $request->get('shop_id');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        $datetime1 = strtotime($fromDate); // convert to timestamps
        $datetime2 = strtotime($toDate); // convert to timestamps
        $day = (int)(($datetime2 - $datetime1) / 86400); // will give the difference in days , 86400 is the timestamp difference of a day
        $days = $day + 1;


        $party = Party::with(['attendance_details' => function ($query) use ($fromDate, $toDate) {
            $query->whereDate('in_time', '>=', $fromDate);
            $query->whereDate('in_time', '<=', $toDate);
        }])
            ->where('account_type', '=', 'EMPLOYEES')
            ->where('shop_id', '=', $shopID)
            ->OrderBy('id', 'asc')->get();


        //return $party;
        $shop = Warehouse::where('id', '=', $shopID)->get();
        $company_detail = Setting::where('id', '=', 1)->get();
        return view('attendance.attendance-report.report', Compact('party', 'company_detail', 'fromDate', 'toDate', 'days', 'shop'));
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
