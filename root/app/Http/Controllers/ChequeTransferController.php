<?php

namespace App\Http\Controllers;

use App\Models\PostDateCheque;
use App\Models\Vouchers;
use App\Models\Party;
use App\Models\PostDated;
use App\Models\GeneralVoucher;
use App\Models\LedgerDetailWise;
use App\Models\Setting;
use App\Models\SystemLogo;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ChequeTransferController extends Controller
{
    public function index()
    {
        $data = Vouchers::with('party_from')
            ->where('v_type', '=', 'Cheque Transfer')
            ->OrderBy('id', 'desc')->get();
        //return $data;
        return view('cheque-transfer.index', Compact('data'));
    }

    public function create()
    {

        $code = Vouchers::OrderBy('id', 'asc')->get();
        //$codes = $code->last()->voucher_no + 1;

        if (count($code) > 0) {
            $codes = (int)$code->last()->voucher_no + 1;
        } else {
            $codes = 1;
        }



        $Heads = Party::select(DB::raw('CONCAT(`id`, "_", `party_name`) AS `id`, `party_name`'))->OrderBy('party_name', 'asc')->pluck('party_name', 'id')->toArray();

        $encrypter = app('Illuminate\Encryption\Encrypter');
        // $cheques = PostDated::with(['cheque_details'=> function($query){
        //     $query->with('party');
        //     $query->with('banks');
        // }])->get();
        $cheques = PostDateCheque::with('post_dated')->get();
        //return $cheques;
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('cheque-transfer.create', Compact('encrypted_token', 'codes', 'Heads', 'cheques'));
    }

    public function store(Request $request)
    {
        $voucher = json_decode($request->get('voucher'), true);
        $products = $request->get('product_data');
        //return $products;
        //$voucherData = Vouchers::create($voucher);



        // if($voucherData->voucher_no !="0"){
        //     $project = PostDateCheque::where("voucher_no", $voucherData->voucher_no)->first();
        //     $project->status = "Clear";
        //     $project->save();
        // }
        //return $products;
        foreach ($products as $product) {
            if (($product['checkedValue']) == "true") {

                $voucherData = new Vouchers();
                $voucherData->account_from_id = $voucher['account_from_id'];
                $voucherData->account_id = $voucher['account_id'];
                //$voucherData->shop_id = $voucher['shop_id'];
                $voucherData->postdated_id = $product['postdated_id'];
                $voucherData->voucher_no = $voucher['voucher_no'];
                $voucherData->voucher_date = $voucher['voucher_date'];
                $voucherData->v_type = $voucher['v_type'];
                $voucherData->biller = $voucher['biller'];
                $voucherData->save();
                //return "entered";
                $purchaseDetail = new GeneralVoucher();
                $purchaseDetail->voucher_id = $voucherData['id'];
                $purchaseDetail->account_head_id = $voucherData['account_from_id'];
                $purchaseDetail->bank_id = $product['bank_id'];
                $purchaseDetail->cheque_id = $product['cheque_id'];
                $purchaseDetail->date = $voucherData['voucher_date'];
                $purchaseDetail->voucher_no = $product['voucher_no'];
                $purchaseDetail->cheque_no = $product['cheque_no'];
                $purchaseDetail->v_type = $product['v_type'];
                $purchaseDetail->narration = $product['narration'];
                $purchaseDetail->credit = $product['amount'];
                $purchaseDetail->save();

                $purchaseDetail = new GeneralVoucher();
                $purchaseDetail->voucher_id = $voucherData['id'];
                $purchaseDetail->account_head_id = $voucherData['account_id'];
                $purchaseDetail->bank_id = $product['bank_id'];
                $purchaseDetail->cheque_id = $product['cheque_id'];
                $purchaseDetail->date = $voucherData['voucher_date'];
                $purchaseDetail->voucher_no = $product['voucher_no'];
                $purchaseDetail->cheque_no = $product['cheque_no'];
                $purchaseDetail->v_type = $product['v_type'];
                $purchaseDetail->narration = $product['narration'];
                $purchaseDetail->debit = $product['amount'];
                $purchaseDetail->save();

                $vouchers = new LedgerDetailWise();
                $vouchers->voucher_id = $voucherData['id'];
                $vouchers->party_id = $voucherData['account_from_id'];
                $vouchers->bank_id = $product['bank_id'];
                $vouchers->cheque_id = $product['cheque_id'];
                $vouchers->voucher_no = $product['voucher_no'];
                $vouchers->voucher_type = $product['v_type'];
                $vouchers->date = $voucherData['voucher_date'];
                $vouchers->other = $product['narration'];
                $vouchers->credit = $product['amount'];
                $vouchers->save();

                $vouchers = new LedgerDetailWise();
                $vouchers->voucher_id = $voucherData['id'];
                $vouchers->party_id = $voucherData['account_id'];
                $vouchers->bank_id = $product['bank_id'];
                $vouchers->cheque_id = $product['cheque_id'];
                $vouchers->voucher_no = $product['voucher_no'];
                $vouchers->voucher_type = $product['v_type'];
                $vouchers->date = $voucherData['voucher_date'];
                $vouchers->other = $product['narration'];
                $vouchers->debit = $product['amount'];
                $vouchers->save();

                if ($voucherData->voucher_no != "0") {

                    //Details
                    $project = PostDateCheque::where("id", $product['cheque_id'])->first();
                    $project->status = "Clear";
                    $project->save();
                    //PostDated
                    $project = PostDated::where("id", $project['voucher_id'])->first();
                    $project->status = "Clear";
                    $project->save();
                }

                return $voucherData['id'];
            }
            // else{
            //   echo "<alert>Select Cheque First!</alert>";
            // }

            // if(($product['checkedValue']) == false){
            //        return "not entered";
            //    }

        }
        //return $purchaseData['id'];
        //return $voucherData['id'];
    }

    public function show($id)
    {
        $newsale_detail = Vouchers::with(['voucher_details' => function ($query) {
            //$query->with('products');
            //$query->with('uoms');
            $query->with('banks');
            $query->with('parties');
        }])->with('party_from')->with('parties')->where('vouchers.id', '=', $id)
            // ->orwhere('voucher_details.credit', '!=', null)
            ->get();
        //return $details;
        $company_detail = Setting::where('id', '=', 1)->get();
        $logo = SystemLogo::where('id', '=', 1)->get();
        //return $newsale_detail;
        return view('cheque-transfer.print', Compact('newsale_detail', 'company_detail', 'logo'));
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
        $vouchers = Vouchers::findOrFail($id);
        $postdated = PostDated::where("id", $vouchers->postdated_id)->first();
        $postdated->status = "NotClear";
        $postdated->save();

        $postdatedCheque = PostDateCheque::where("voucher_id", $postdated['id'])->first();
        $postdatedCheque->status = "NotClear";
        $postdatedCheque->save();

        //return $delete->postdated_id;
        //return $delete;
        //$project = PostDated::where("id", $id)->first();
        //$project->status = "NotClear";
        //$project->save();

        GeneralVoucher::where('voucher_id', '=', $id)->delete();
        LedgerDetailWise::where('voucher_id', '=', $id)->delete();
        $delete = Vouchers::findOrFail($id);
        //return $delete;
        $delete->delete();


        //PostDateCheque::where('voucher_id', '=', $id)->delete();       
        return "Cheque Transfer has been Deleted Successfully!";
    }
}
