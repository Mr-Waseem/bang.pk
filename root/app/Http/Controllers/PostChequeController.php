<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\Banks;
use App\Models\PostDateCheque;
use App\Models\PostDated;
use App\Models\Setting;
use App\Models\SystemLogo;
use Illuminate\Support\Facades\DB;

class PostChequeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = PostDated::with('party')->OrderBy('id', 'desc')->get();
        return view('post-cheque-receipt.index', Compact('data'));
    }

    public function create()
    {
        $code = PostDated::OrderBy('id', 'asc')->get();
        //$codes = $code->last()->voucher_no + 1;

        if (count($code) > 0) {
            $codes = (int)$code->last()->voucher_no + 1;
        } else {
            $codes = 1;
        }


        $debitAccount = Party::select(DB::raw('CONCAT(`id`, "_", `party_name`) AS `id`, `party_name`'))->where('party_name', '=', "CHEQUE IN HAND")->OrderBy('party_name', 'asc')->pluck('party_name', 'id')->toArray();

        $Accounts = Party::select(DB::raw('CONCAT(`id`, "_", `party_name`) AS `id`, `party_name`'))->OrderBy('party_name', 'asc')->pluck('party_name', 'id')->toArray();
        $banks = Banks::select(DB::raw('CONCAT(`id`, "_", `name`) AS `id`, `name`'))->OrderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('post-cheque-receipt.create', Compact('encrypted_token', 'debitAccount', 'Accounts', 'banks', 'codes'));
    }

    public function store(Request $request)
    {
        $voucher = json_decode($request->get('voucher'), true);
        //return $voucher;
        $voucherData = PostDated::create($voucher);
        $products = $request->get('product_data');
        foreach ($products as $product) {
            $purchaseDetail = new PostDateCheque();
            $purchaseDetail->voucher_id = $voucherData['id'];
            $purchaseDetail->account_head_id = $product['head_id'];
            $purchaseDetail->date = $product['date'];
            $purchaseDetail->voucher_no = $product['voucher_no'];
            $purchaseDetail->cheque_no = $product['cheque_no'];
            $purchaseDetail->v_type = $product['v_type'];
            $purchaseDetail->status = $product['status'];
            $purchaseDetail->narration = $product['narration'];
            $purchaseDetail->bank_id = $product['bank_id'];
            // $purchaseDetail->debit = $product['debit'];
            $purchaseDetail->credit = $product['credit'];
            $purchaseDetail->save();
        }
        //return $purchaseData['id'];
        return "saved";
    }

    public function show($id)
    {
        $newsale_detail = PostDated::with(['cheque_details' => function ($query) {
            //$query->with('products');
            //$query->with('uoms');
            $query->with('banks');
            $query->with('party');
        }])->with('party')->where('post-dated.id', '=', $id)
            // ->orwhere('voucher_details.credit', '!=', null)
            ->get();
        //return $details;
        $company_detail = Setting::where('id', '=', 1)->get();
        $logo = SystemLogo::where('id', '=', 1)->get();
        //return $newsale_detail;
        return view('post-cheque-receipt.print', Compact('newsale_detail', 'company_detail', 'logo'));
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
        $delete = PostDated::findOrFail($id);
        $delete->delete();
        PostDateCheque::where('voucher_id', '=', $id)->delete();
        // Ledger::where('sale_id', '=', $id)->delete();       
        return "Cheque has been Deleted Successfully!";
    }
}
