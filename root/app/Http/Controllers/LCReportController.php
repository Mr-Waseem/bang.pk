<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LCApproved;
use App\Models\Setting;

class LCReportController extends Controller
{
    public function index()
    {
        $lcNo = LCApproved::OrderBy('lc_no', 'asc')->pluck('lc_no', 'id')->prepend('All', '')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('lc.lc-activity-report.index', Compact('encrypted_token', 'lcNo'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'from_date' => 'required',
            'to_date' => 'required'
        ]);
        $LCID = $request->get('lc_id');
        //return $PartyID;
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');


        $lc = LCApproved::with('lc_detail')
            ->whereBetween('lc_date', [$fromDate, $toDate])
            ->where('id', '=', $LCID)
            ->get();

        //return $lc;
        $party = LCApproved::where('id', '=', $LCID)->get();
        $company_detail = Setting::where('id', '=', 1)->get();
        return view('lc.lc-activity-report.report', Compact('lc', 'company_detail'));
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
