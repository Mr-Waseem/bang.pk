<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scenario;
use Illuminate\Support\Facades\Session;
use PDF;
use Auth;
use Excel;

class ScenarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $taxes = Scenario::OrderBy('name', 'asc')->get();
        return view('scenario.index', Compact('taxes'));
    }

    public function create()
    {
        return view('scenario.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'sale_type' => 'required'
        ]);
        Scenario::create($request->all());
        Session::flash('flash_message', 'Scenario Added Successfully!');
        return redirect('scenarios');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $edit = Scenario::findOrFail($id);
        return view('scenario.edit', Compact('edit'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'sale_type' => 'required'
        ]);
        $update = Scenario::findOrFail($id);
        $update->update($request->all());
        Session::flash('flash_message', 'Scenario Updated Successfully!');
        return redirect('scenarios');
    }

    public function destroy($id)
    {
        // return ""
        $delete = Scenario::findOrFail($id);
        $delete->delete();
        Session::flash('flash_message', 'Scenario deleted Successfully!');
        return redirect('scenarios');
        return "Scenario Deleted Successfully!";
    }
}
