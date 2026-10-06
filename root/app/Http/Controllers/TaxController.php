<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tax;
use Illuminate\Support\Facades\Session;

class TaxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $taxes = Tax::OrderBy('id', 'asc')->get();
        return view('taxes.index', Compact('taxes'));
    }

    public function create()
    {
        return view('taxes.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'tax_title' => 'required',
            'tax_rate' => 'required',
            'tax_type' => 'required'
        ]);
        Tax::create($request->all());
        Session::flash('flash_message', 'Tax Rate Added Successfully!');
        return redirect('taxes');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $edit = Tax::findOrFail($id);
        return view('taxes.edit', Compact('edit'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'tax_title' => 'required',
            'tax_rate' => 'required',
            'tax_type' => 'required'
        ]);
        $update = Tax::findOrFail($id);
        $update->update($request->all());
        Session::flash('flash_message', 'Tax Rate Updated Successfully!');
        return redirect('taxes');
    }

    public function destroy($id)
    {
        $delete = Tax::findOrFail($id);
        $delete->delete();
        return "Tax Rate Deleted Successfully!";
    }
}
