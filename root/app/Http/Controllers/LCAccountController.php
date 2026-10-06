<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LCAccount;
use Illuminate\Support\Facades\Session;

class LCAccountController extends Controller
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
        $accounts = LCAccount::OrderBy('account_name', 'asc')->get();
        return view('lc.lc-account.create', compact('accounts', 'encrypted_token'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'account_name' => 'required'
        ]);
        LCAccount::create($request->all());
        Session::flash('flash_message', 'LC Account Added Successfully!');
        return redirect('lc-account/create');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $edit = LCAccount::findOrFail($id);
        return view('lc/lc-account/edit', Compact('edit'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'account_name' => 'required'
        ]);
        $update = LCAccount::findOrFail($id);
        $update->update($request->all());
        Session::flash('flash_message', 'LC Account Updated Successfully!');
        return redirect('lc-account/create');
    }

    public function destroy($id)
    {
        $delete = LCAccount::findOrFail($id);
        $delete->delete();
        return "LC Account Deleted Successfully!";
    }
}
