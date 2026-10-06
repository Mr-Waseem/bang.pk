<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\Attendance;
use App\Models\AttendanceDetails;
use App\Models\Warehouse;
use App\Models\GeneralVoucher;
use App\Models\LedgerDetailWise;
use Illuminate\Support\Facades\Session;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendance = Attendance::OrderBy('attendance_date', 'desc')
            ->with('shop')->with('biller')->get();
        return view('attendance.index', Compact('attendance'));
    }

    public function create()
    {
        $code = Attendance::OrderBy('id', 'asc')->get();
        if (count($code) > 0) {
            $codes = (int)$code->last()->vr_no + 1;
        } else {
            $codes = 1;
        }

        // $employees = Party::select(DB::raw('CONCAT(`id`) AS `id`, `party_name`'))->OrderBy('party_name', 'asc')
        // ->where('account_type', '=', 'EMPLOYEES')
        // ->pluck('party_name', 'id')->toArray();

        $employees = Party::where('account_type', '=', 'EMPLOYEES')
            ->OrderBy('party_name', 'asc')
            ->get(['id', 'parties.party_name']);

        $shops = Warehouse::where('id', '!=', '1')->OrderBy('id', 'asc')
            ->pluck('name', 'id')->prepend('Select Shop', '')->toArray();
        //return $shops;
        //return $employees;
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('attendance.create', Compact('encrypted_token', 'employees', 'codes', 'shops'));
    }

    public function LoadEmployees(Request $request)
    {
        $ShopID = $request->get('ShopID');
        $PartyArray = Party::where('shop_id', '=', $ShopID)
            //->orwhere('account_type', '=', 'EMPLOYEES')
            //->orwhere('account_type', '=', 'EXPENSES')

            ->Where(function ($query) {
                $query->orwhere('account_type', '=', 'EMPLOYEES')
                    ->orwhere('account_type', '=', 'SATLUJ DAIRY EMPLOYEE');
                //->orwhere('account_type', '=', 'EXPENSES');
            })
            //->where('account_type', '=', 'SATLUJ DAIRY EMPLOYEE')
            ->where('employee_status', '=', 'ACTIVE')
            ->get();
        return $PartyArray;
    }

    public function store(Request $request)
    {
        //return $request->all();
        $attendance = Attendance::create($request->all());
        $count = Count($request->employee_id);
        //return $ProductID; 
        for ($i = 0; $i < $count; $i++) {
            $detail = new AttendanceDetails();
            $detail->attendance_id = $attendance['id'];
            $detail->employee_id = $request->employee_id[$i];
            $detail->biller_id = $attendance['biller_id'];
            $detail->shop_id = $attendance['shop_id'];
            $detail->vr_date =  $attendance['vr_date'];
            //$detail->in_time = $request->date[$i];
            $detail->in_time = $attendance['attendance_date'];
            //$detail->out_time = $request->date[$i];
            $detail->out_time = $attendance['attendance_date'];
            $detail->status = $request->status[$i];
            $detail->save();

            if ($detail->status == "Present") {
                $data = Party::where('id', '=', $request->employee_id[$i])->get();
                $salary  = $data[0]->salary / 30;

                $vouchers = new GeneralVoucher();
                $vouchers->attendance_id = $attendance['id'];
                $vouchers->account_head_id = $request->employee_id[$i];
                $vouchers->date = $attendance['attendance_date'];
                $vouchers->voucher_no = $attendance['vr_no'];
                $vouchers->v_type = "Salary";
                $vouchers->credit = $salary;
                $vouchers->save();


                $vouchers = new LedgerDetailWise();
                $vouchers->attendance_id = $attendance['id'];
                $vouchers->party_id = $request->employee_id[$i];
                $vouchers->voucher_no = $attendance['vr_no'];
                $vouchers->voucher_type = "Salary";
                $vouchers->date = $attendance['attendance_date'];
                $vouchers->credit = $salary;
                $vouchers->save();
                //return $salary;
            }
        }

        Session::flash('flash_message', 'Record successfully added!');
        return redirect('attendance/create');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        // $edit = Attendance::findOrFail($id);
        $edit = Attendance::with(['attendance_details' => function ($query) {
            $query->with('employees');
        }])
            ->where('id', '=', $id)->get();
        //return $edit;
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        $shops = Warehouse::where('id', '!=', '1')->OrderBy('id', 'asc')
            ->pluck('name', 'id')->prepend('Select Shop', '')->toArray();
        return view('attendance.edit', Compact('edit', 'encrypted_token', 'shops'));
        return $edit;
    }

    public function update(Request $request, $id)
    {
        //return $id;
        //return $request->all();
        $attendance = Attendance::findOrFail($id);
        //return $update;
        $attendance->update($request->all());


        AttendanceDetails::where('attendance_id', '=', $id)->delete();
        GeneralVoucher::where('attendance_id', '=', $id)->delete();
        LedgerDetailWise::where('attendance_id', '=', $id)->delete();
        $count = Count($request->employee_id);
        //return $ProductID; 
        for ($i = 0; $i < $count; $i++) {
            $detail = new AttendanceDetails();
            $detail->attendance_id = $attendance['id'];
            $detail->employee_id = $request->employee_id[$i];
            $detail->biller_id = $attendance['biller_id'];
            $detail->shop_id = $attendance['shop_id'];
            $detail->vr_date =  $attendance['vr_date'];
            //$detail->in_time = $request->date[$i];
            $detail->in_time = $attendance['attendance_date'];
            //$detail->out_time = $request->date[$i];
            $detail->out_time = $attendance['attendance_date'];
            $detail->status = $request->status[$i];
            $detail->save();

            if ($detail->status == "Present") {
                $data = Party::where('id', '=', $request->employee_id[$i])->get();
                $salary  = $data[0]->salary / 30;

                $vouchers = new GeneralVoucher();
                $vouchers->attendance_id = $attendance['id'];
                $vouchers->account_head_id = $request->employee_id[$i];
                $vouchers->date = $attendance['attendance_date'];
                $vouchers->voucher_no = $attendance['vr_no'];
                $vouchers->v_type = "Salary";
                $vouchers->credit = $salary;
                $vouchers->save();


                $vouchers = new LedgerDetailWise();
                $vouchers->attendance_id = $attendance['id'];
                $vouchers->party_id = $request->employee_id[$i];
                $vouchers->voucher_no = $attendance['vr_no'];
                $vouchers->voucher_type = "Salary";
                $vouchers->date = $attendance['attendance_date'];
                $vouchers->credit = $salary;
                $vouchers->save();
                //return $salary;
            }
        }

        Session::flash('flash_message', 'Record successfully added!');
        return redirect('attendance/create');
    }

    public function destroy($id)
    {
        $delete = Attendance::findOrFail($id);
        $delete->delete();
        AttendanceDetails::where('attendance_id', '=', $id)->delete();
        GeneralVoucher::where('attendance_id', '=', $id)->delete();
        LedgerDetailWise::where('attendance_id', '=', $id)->delete();


        // Ledger::where('sale_id', '=', $id)->delete();       
        return "Attendance has been Deleted Successfully!";
    }
}
