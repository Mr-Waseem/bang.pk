<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\AccountGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
  
    public function index()
    {
        $party = Party::join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')->where('name', 'EMPLOYEES')->OrderBy('party_name', 'asc')->get(['parties.*', 'account_groups.name']);
        return view('employees.index', Compact('party'));
    }

    public function create()
    {
        $code = Party::OrderBy('id', 'asc')->get();

        //return $code;
        if (count($code) > 0) {
            $codes = (int)$code->last()->code + 1;
        } else {
            $codes = 1;
        }
        // $AccountGroups = AccountGroup::select(DB::raw('CONCAT(`id`, "_", `name`) AS `id`, `name`'))->where('name', 'EMPLOYEES')->OrderBy('name', 'asc')->pluck('name', 'id')->prepend('Select Employee', '')->toArray();
        $AccountGroups = AccountGroup::select(DB::raw('CONCAT(`id`, "_", `name`) AS `id`, `name`'))->where('name', 'EMPLOYEES')->OrderBy('name', 'asc')->pluck('name', 'id')->prepend('Select Employee', '')->toArray();
        return view('employees.create', Compact('AccountGroups', 'codes'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'party_name' => 'required|unique:parties',
            // 'account_type' => 'required',
            // 'ntn' => 'unique:parties',
            // 'strn' => 'unique:parties',
        ]);
        Party::create($request->all());
        Session::flash('flash_message', 'Employee added Successfully!');
        return redirect('employees/create');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $edit = Party::findOrFail($id);
        //$AccountGroups = AccountGroup::OrderBy('name', 'asc')->pluck('name', 'id');
        $AccountGroups = AccountGroup::select(DB::raw('CONCAT(`id`, "_", `name`) AS `id`, `name`'))->where('name', 'EMPLOYEES')->OrderBy('name', 'asc')->pluck('name', 'id')->prepend('Select Account')->toArray();
        return view('employees.edit', Compact('edit', 'AccountGroups'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'party_name' => 'required',
            // 'ntn' => 'unique:parties',
            // 'strn' => 'unique:parties',
        ]);
        $update = Party::findOrFail($id);
        $update->update($request->all());
        Session::flash('flash_message', 'Employee Updated Successfully!');
        return redirect('employees');
    }

    public function destroy($id)
    {
        $delete = Party::findOrFail($id);
        $delete->delete();
        return ("Employee has been deleted!");
    }
}
