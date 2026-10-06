<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LCIndentor;
use Illuminate\Support\Facades\Session;

class LCIndentorController extends Controller
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
        $indentors = LCIndentor::OrderBy('indentor_name', 'asc')->get();
        return view('lc.indentor-info.create', compact('indentors', 'encrypted_token'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'indentor_name' => 'required'
        ]);
        LCIndentor::create($request->all());
        Session::flash('flash_message', 'Indentor Added Successfully!');
        return redirect('indentor-info/create');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $edit = LCIndentor::findOrFail($id);
        return view('lc/indentor-info/edit', Compact('edit'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'indentor_name' => 'required'
        ]);
        $update = LCIndentor::findOrFail($id);
        $update->update($request->all());
        Session::flash('flash_message', 'Indentor Updated Successfully!');
        return redirect('indentor-info/create');
    }

    public function destroy($id)
    {
        $delete = LCIndentor::findOrFail($id);
        $delete->delete();
        return "Indentor Deleted Successfully!";
    }
}
