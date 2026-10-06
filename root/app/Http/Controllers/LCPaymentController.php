<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\LCPayment;
use App\Models\LCPaymentDetail;
use App\Models\LCInformation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LCPaymentController extends Controller
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
        $code = LCPayment::OrderBy('id', 'asc')->get();
        //return $code;
        $codes = $code->last()->voucher_no + 1;
        // $cashAccount = Party::select(DB::raw('CONCAT(`id`, "_", `party_name`) AS `id`, `party_name`'))->where('id', '=', 4)->OrderBy('party_name', 'asc')->pluck('party_name', 'id')->prepend('CASH IN HAND', '4_CASH IN HAND')->toArray();
        $cashAccount = Party::where('id', '=', 4)->OrderBy('party_name', 'asc')->pluck('party_name', 'id')->prepend('CASH IN HAND', '4')->toArray();

        // $Accounts = Party::select(DB::raw('CONCAT(`id`, "_", `party_name`) AS `id`, `party_name`'))->OrderBy('party_name', 'asc')->pluck('party_name', 'id')->toArray();
        $Accounts = Party::select(DB::raw('CONCAT(`id`, "_", `party_name`) AS `id`, `party_name`'))->OrderBy('party_name', 'asc')->pluck('party_name', 'id')->toArray();
        //$lcNo = LCInformation::OrderBy('id', 'asc')->pluck('lc_no', 'id')->toArray();
        $lcNo = LCInformation::select(DB::raw('CONCAT(`id`, "_", `lc_no`) AS `id`, `lc_no`'))->OrderBy('lc_no', 'asc')->pluck('lc_no', 'id')->toArray();
        //return $lcNo;
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('lc.lc-payment.create', Compact('encrypted_token', 'cashAccount', 'Accounts', 'codes', 'lcNo'));
    }

    public function store(Request $request)
    {
        //return $request->all();
        $lcPayment = LCPayment::create($request->all());


        $count = Count($request->lc_id);
        //return $count;
        for ($i = 0; $i < $count; $i++) {
            if ($request->lc_id[$i] != null) {
                $expenseDetail = new LCPaymentDetail();
                $expenseDetail->lc_payment_id = $lcPayment['id'];
                $expenseDetail->lc_id = $request->lc_id[$i];
                $expenseDetail->account_id =  $request->account_id[$i];
                $expenseDetail->desc =  $request->desc[$i];
                $expenseDetail->payment =  $request->payment[$i];
                $expenseDetail->save();
            }
        }
        Session::flash('flash_message', 'LC Payment Addad Successfully!');
        return redirect('lc-payment/create');
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
