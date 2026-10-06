<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\LCExpense;
use App\Models\LCExpenseDetail;
use App\Models\LCInformation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LCExpenseController extends Controller
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
        $code = LCExpense::OrderBy('id', 'asc')->get();
        //return $code;
        $codes = $code->last()->voucher_no + 1;
        // $cashAccount = Party::select(DB::raw('CONCAT(`id`, "_", `party_name`) AS `id`, `party_name`'))->where('id', '=', 4)->OrderBy('party_name', 'asc')->pluck('party_name', 'id')->prepend('CASH IN HAND', '4_CASH IN HAND')->toArray();
        $cashAccount = Party::where('id', '=', 4)->OrderBy('party_name', 'asc')->pluck('party_name', 'id')->prepend('CASH IN HAND', '4')->toArray();

        // $Accounts = Party::select(DB::raw('CONCAT(`id`, "_", `party_name`) AS `id`, `party_name`'))->OrderBy('party_name', 'asc')->pluck('party_name', 'id')->toArray();
        $Accounts = Party::select(DB::raw('CONCAT(`id`, "_", `party_name`) AS `id`, `party_name`'))->OrderBy('party_name', 'asc')->pluck('party_name', 'id')->toArray();
        $lcNo = LCInformation::OrderBy('id', 'asc')->pluck('lc_no', 'id')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('lc.lc-expense.create', Compact('encrypted_token', 'cashAccount', 'Accounts', 'codes', 'lcNo'));
    }

    public function store(Request $request)
    {
        //return $request->all();

        $lcExpense = LCExpense::create($request->all());


        $count = Count($request->account_id);
        //return $count;
        for ($i = 0; $i < $count; $i++) {
            if ($request->account_id[$i] != null) {
                $expenseDetail = new LCExpenseDetail();
                $expenseDetail->lc_expense_id = $lcExpense['id'];
                $expenseDetail->account_id =  $request->account_id[$i];
                $expenseDetail->desc =  $request->desc[$i];
                $expenseDetail->receipt =  $request->receipt[$i];
                $expenseDetail->save();
            }
        }
        Session::flash('flash_message', 'LC Expense Addad Successfully!');
        return redirect('lc-expense/create');
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
