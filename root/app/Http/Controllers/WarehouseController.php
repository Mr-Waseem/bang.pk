<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Session;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::OrderBy('id', 'asc')->get();
        return view('warehouses.index', Compact('warehouses'));
    }

    public function create()
    {
        return view('warehouses.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
            'name' => 'required'
        ]);
        Warehouse::create($request->all());
        Session::flash('flash_message', 'Warehouses Added Successfully!');
        return redirect('warehouses/create');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $edit = Warehouse::findOrFail($id);
        return view('warehouses.edit', Compact('edit'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'code' => 'required',
            'name' => 'required'
        ]);
        $update = Warehouse::findOrFail($id);
        $update->update($request->all());
        Session::flash('flash_message', 'Warehouse Updated Successfully!');
        return redirect('warehouses');
    }

    public function destroy($id)
    {
        $delete = Warehouse::findOrFail($id);
        $delete->delete();
        return "Warehouse Deleted Successfully!";
    }
}
