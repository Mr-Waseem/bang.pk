<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vouchers;
use App\Models\GeneralVoucher;
use App\Models\Party;
use App\Models\LedgerDetailWise;
use Illuminate\Support\Facades\Session;

class VouchersEditController extends Controller
{
    public function index()
    {
        //$Vouchers = GeneralVoucher::OrderBy('voucher_no')->get();
        $Vouchers = Vouchers::with(['voucher_details' => function ($query) {
            //$query->with('products');
            //$query->with('uoms');
            //$query->with('discount');
        }])->with('parties')->get();
        // return $purchase;
        return view('vouchers.index', Compact('Vouchers'));
    }

    public function create()
    {
        //
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
 
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
        $delete = GeneralVoucher::findOrFail($id);
        $delete->delete();
        LedgerDetailWise::where('voucher_id', '=', $id)->delete();
        return "Voucher Delted Successfully!";
    }

    public function print_voucher($id)
    {
        $purchase = Vouchers::with(['voucher_details' => function ($query) {
            //$query->with('products');
            //$query->with('uoms');
            //$query->with('discount');
        }])->with('parties')->where('vouchers.id', '=', $id)->get();
        return $purchase;
    }
}
