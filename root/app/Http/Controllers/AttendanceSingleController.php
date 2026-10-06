<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Party;
use App\Models\Warehouse;

class AttendanceSingleController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        $shops = Warehouse::where('id', '!=', 1)->OrderBy('id', 'asc')->pluck('name', 'id')->toArray();
        //return $shops;
        return view('attendance.attendance-single.index', Compact('shops'));
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'from_date' => 'required'
        ]);
        $shopID = $request->get('shop_id');
        $fromDate = $request->get('from_date');
        $datetime1 = strtotime($fromDate); // convert to timestamps
        $day = (int)(($datetime1) / 86400); // will give the difference in days , 86400 is the timestamp difference of a day
        $days = $day + 1;


        $party = Party::with(['attendance_details' => function ($query) use ($fromDate) {
            $query->whereDate('in_time', '=', $fromDate);
        }])
            ->where('account_type', '=', 'EMPLOYEES')
            ->where('shop_id', '=', $shopID)
            ->OrderBy('id', 'asc')->get();


        //return $party;
        $shop = Warehouse::where('id', '=', $shopID)->get();
        $company_detail = Setting::where('id', '=', 1)->get();
        return view('attendance.attendance-single.report', Compact('party', 'company_detail', 'fromDate', 'days', 'shop'));
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
