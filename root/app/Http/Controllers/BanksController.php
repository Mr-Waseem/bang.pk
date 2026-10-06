<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banks;
use Illuminate\Support\Facades\Session;

class BanksController extends Controller
{
    public function index()
    {
        $banks = Banks::where('company_id', session()->get('company_id'))
            ->OrderBy('id', 'asc')
            ->get();
        return view('banks.index', Compact('banks'));
    }

    public function create()
    {
        return view('banks.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
            'name' => 'required'
        ]);
        Banks::create($request->all());
        Session::flash('flash_message', 'Bank Added Successfully!');
        return redirect('banks/create');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $edit = Banks::findOrFail($id);
        return view('banks.edit', Compact('edit'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'required',
            'name' => 'required'
        ]);
        $update = Banks::findOrFail($id);
        $update->update($request->all());
        Session::flash('flash_message', 'Bank Updated Successfully!');
        return redirect('banks');
    }

    public function destroy($id)
    {
        $delete = Banks::findOrFail($id);
        $delete->delete();
        return "Bank Deleted Successfully!";
    }
}
