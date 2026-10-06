<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AccountGroup;
use Illuminate\Support\Facades\Session;

class AccountGroupController extends Controller
{
    public function index()
    {
        $groups = AccountGroup::OrderBy('name', 'asc')->get();
        return view('account-group.index', Compact('groups'));
    }

    public function create()
    {
        $code = AccountGroup::OrderBy('id', 'asc')->get();
        $codes = (int)$code->last()->code + 1;
        return view('account-group.create', Compact('codes'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
            'name' => 'required'
        ]);
        AccountGroup::create($request->all());
        Session::flash('flash_message', 'Account Group Successfully!');
        return redirect('account-group/create');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $edit = AccountGroup::findOrFail($id);
        return view('account-group.edit', Compact('edit'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'required',
            'name' => 'required'
        ]);
        $update = AccountGroup::findOrFail($id);
        $update->update($request->all());
        Session::flash('flash_message', 'Account Group Updated Successfully!');
        return redirect('account-group');
    }

    public function destroy($id)
    {
        $delete = AccountGroup::findOrFail($id);
        $delete->delete();
        return "Account Head Deleted Successfully!";
    }
}
