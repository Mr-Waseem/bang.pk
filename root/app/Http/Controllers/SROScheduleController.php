<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scenario;
use App\Models\SROSchedule;
use Illuminate\Support\Facades\Session;
use PDF;
use Auth;
use DB;

class SROScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $taxes = SROSchedule::with('scenario:id,name,sale_type')
        ->OrderBy('sro_schedule_name', 'asc')->get();
        return view('sro-schedule.index', Compact('taxes'));
    }

    public function create()
    {
        // $scenario = Scenario::OrderBy('name', 'asc')
        // ->pluck('sale_type', 'id');
        $scenario = Scenario::select('id', DB::raw('CONCAT(`name`, " - ", `sale_type`) AS `scenario_name`'))
            
               ->orderBy('name', 'asc')
               ->pluck('scenario_name', 'id')
               ->toArray();
        return view('sro-schedule.create', Compact('scenario'));
    }

    public function store(Request $request)
    {
        // return "d";
        $this->validate($request, [
            'scenario_id' => 'required',
            'sro_schedule_name' => 'required'
        ]);
        SROSchedule::create($request->all());
        Session::flash('flash_message', 'SRO Schedule Added Successfully!');
        return redirect('sro-schedules');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $edit = SROSchedule::findOrFail($id);
        $scenario = Scenario::select('id', DB::raw('CONCAT(`name`, " - ", `sale_type`) AS `scenario_name`'))
            
               ->orderBy('name', 'asc')
               ->pluck('scenario_name', 'id')
               ->toArray();
        return view('sro-schedule.edit', Compact('edit', 'scenario'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'scenario_id' => 'required',
            'sro_schedule_name' => 'required'
        ]);
        $update = SROSchedule::findOrFail($id);
        $update->update($request->all());
        Session::flash('flash_message', 'SRO Schedule Updated Successfully!');
        return redirect('sro-schedules');
    }

    public function destroy($id)
    {
        // return "3";
        $delete = SROSchedule::findOrFail($id);
        $delete->delete();
        Session::flash('flash_message', 'SRO Schedule deleted Successfully!');
        return redirect('sro-schedules');
        return "Scenario Deleted Successfully!";
    }
}
