<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LCLocation;
use Illuminate\Support\Facades\Session;

class LCLocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
    }

    public function create()
    {
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        $locations = LCLocation::OrderBy('location_name', 'asc')->get();
        return view('lc.location.create', compact('locations', 'encrypted_token'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'location_name' => 'required'
        ]);
        LCLocation::create($request->all());
        Session::flash('flash_message', 'LC Location Added Successfully!');
        return redirect('lc-location/create');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $edit = LCLocation::findOrFail($id);
        return view('lc/location/edit', Compact('edit'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'location_name' => 'required'
        ]);
        $update = LCLocation::findOrFail($id);
        $update->update($request->all());
        Session::flash('flash_message', 'LC Location Updated Successfully!');
        return redirect('lc-location/create');
    }

    public function destroy($id)
    {
        $delete = LCLocation::findOrFail($id);
        $delete->delete();
        return "LC Location Deleted Successfully!";
    }
}
