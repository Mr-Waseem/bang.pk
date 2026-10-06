<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discount;
use Illuminate\Support\Facades\Session;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::OrderBy('id', 'asc')->get();
        return view('discount.index', Compact('discounts'));
    }

    public function create()
    {
        return view('discount.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'discount' => 'required',
            'type' => 'required'
        ]);
        Discount::create($request->all());
        Session::flash('flash_message', 'Discount Added Successfully!');
        return redirect('discount');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $edit = Discount::findOrFail($id);
        return view('discount.edit', Compact('edit'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'discount' => 'required',
            'type' => 'required'
        ]);
        $update = Discount::findOrFail($id);
        $update->update($request->all());
        Session::flash('flash_message', 'Discount Updated Successfully!');
        return redirect('discount');
    }

    public function destroy($id)
    {
        $delete = Discount::findOrFail($id);
        $delete->delete();
        return "Discount Deleted Successfully";
    }
}
