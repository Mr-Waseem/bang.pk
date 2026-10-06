<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\GeneralVoucher;
use Illuminate\Support\Facades\DB;

class OpeningBalanceVoucher extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //$Heads = AccountHead::OrderBy('title', 'asc')->pluck('title', 'id')->prepend('Select Account Head', '0')->toArray();
        // $Heads = AccountHead::select(DB::raw('CONCAT(`id`, "_", `title`) AS `id`, `title`'))->OrderBy('title', 'asc')->pluck('title', 'id')->toArray();
        $code = GeneralVoucher::OrderBy('id', 'asc')->get();
        $codes = $code->last()->voucher_no + 1;

        $Heads = Party::select(DB::raw('CONCAT(`id`, "_", `party_name`) AS `id`, `party_name`'))->OrderBy('party_name', 'asc')->pluck('party_name', 'id')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('opening-balance.create', Compact('encrypted_token', 'Heads', 'codes'));
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
