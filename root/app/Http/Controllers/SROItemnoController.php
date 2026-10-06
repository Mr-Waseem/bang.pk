<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SROSchedule;
use App\Models\Scenario;
use App\Models\SROItemno;
use Illuminate\Support\Facades\Session;
use PDF;
use Auth;
use DB;

class SROItemnoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $taxes = SROItemno::with('scenario:id,name,sale_type')
        ->with('sro_scredule:id,sro_schedule_name')
        ->OrderBy('sro_item_no', 'asc')->get();
        return view('sro-items.index', Compact('taxes'));
    }

    public function create()
    {
        $sroschedule = collect(['' => 'Choose Schedule']);
        $scenario = Scenario::select('id', DB::raw('CONCAT(`name`, " - ", `sale_type`) AS `scenario_name`'))
            ->orderBy('name', 'asc')
            ->pluck('scenario_name', 'id')
            ->prepend('Choose Scenario', '')
            ->toArray();
        return view('sro-items.create', Compact('scenario', 'sroschedule'));
    }

    public function store(Request $request)
    {
        // return $request;
        $this->validate($request, [
            'scenario_id' => 'required',
            'sro_schedule_id' => 'required',
            'sro_item_no' => 'required'
        ]);
        SROItemno::create($request->all());
        Session::flash('flash_message', 'SRO Item No Added Successfully!');
        return redirect('sro-items');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $edit = SROItemno::findOrFail($id);
        // $sroschedule = collect(['' => 'Choose Schedule']);
        $sroschedule = SROSchedule::OrderBy('sro_schedule_name', 'asc')
        ->pluck('sro_schedule_name', 'id')->prepend('Choose Schedule', '');
        $scenario = Scenario::select('id', DB::raw('CONCAT(`name`, " - ", `sale_type`) AS `scenario_name`'))
            ->orderBy('name', 'asc')
            ->pluck('scenario_name', 'id')
            ->prepend('Choose Scenario', '')
            ->toArray();
        return view('sro-items.edit', Compact('edit', 'scenario', 'sroschedule'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'scenario_id' => 'required',
            'sro_schedule_id' => 'required',
            'sro_item_no' => 'required'
        ]);
        $update = SROItemno::findOrFail($id);
        $update->update($request->all());
        Session::flash('flash_message', 'SRO item No Updated Successfully!');
        return redirect('sro-items');
    }

    public function destroy($id)
    {
        // return "3";
        $delete = SROItemno::findOrFail($id);
        $delete->delete();
        Session::flash('flash_message', 'SRO Item deleted Successfully!');
        return redirect('sro-items');
        return "Scenario Deleted Successfully!";
    }

    public function getsro_schedule(Request $request){
        
        $data = SROSchedule::where('scenario_id', $request->scenario_id)->get();
        // return $data;
        return json_encode(['data' => $data]);
    }
}
