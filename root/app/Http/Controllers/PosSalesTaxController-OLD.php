<?php

namespace App\Http\Controllers;

use App\Models\RawMaterialStock;
use App\Models\AccountGroup;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Tax;
use App\Models\Party;
use App\Models\Discount;
use App\Models\Setting;
use App\Models\Ledger;
use App\Models\DeliveryChallan;
use App\Models\SaleTax;
use App\Models\SaleTaxDetails;
use App\Models\GeneralVoucher;
// use App\Models\LedgerDetailWise;
use App\Models\UOM;
use App\Models\User;
use App\Models\StockRegisterSpecificItem;
use App\Models\SystemLogo;
use App\Models\Companies;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PDF;
use Carbon\Carbon;
use DateTime;

class PosSalesTaxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        // $sales = SaleTax::where('sale_type', 'SalesTax Invoice')->OrderBy('id', 'desc')->with(['saletax_details' => function ($query) {
        //     //$query->with('taxes');
        //     //$query->with('discount');
        //     //$query->with('parties');
        // }])->with('billers')->get();

        // return view('salestax.index', compact('sales'));

        $sales = SaleTax::OrderBy('id', 'desc')
            ->with(['saletax_details' => function ($query) {
                //$query->with('taxes');
                //$query->with('discount');
                //$query->with('parties');
            }])
            ->with('billers')
            ->where('company_id', session()->get('company_id'))
            ->where('sale_type', 'SalesTax Invoice')
            ->take(500)->get();
        // return $sales;
        
        return view('salestax.pos.index', compact('sales'));
    }

    public function create()
    {
        //   $code = SaleTax::where('sale_type', 'SalesTax Invoice')->OrderBy('id', 'desc')->first();
        // //  $code = SaleTax::where('sale_type', 'Credit Note')->OrderBy('id', 'desc')->first();
        //  if (isset($code) > 0) {
        //      $codes = $code->invoice_no + 1;
        //  } else {
        //      $codes = 1;
        //  }
        $codes = 1;
        $code = SaleTax::where('company_id', session()->get('company_id'))
        ->where('sale_type', 'SalesTax Invoice')

            ->OrderBy('invoice_no', 'desc')
            ->first();
            // return $code;
        //return  $code;
        if (isset($code)) {
            $codes = $code->invoice_no + 1;
        }
        // $codes_new = 1;
        // $code_new = SaleTaxDetails::OrderBy('invoice_no', 'desc')
        //     ->first();
        // if (isset($code_new)) {
        //     $codes_new = $code_new->invoice_no + 1;
        // }

        $products = Product::where('company_id', session()->get('company_id'))
            // ->select(DB::raw('CONCAT(`id`, "_", `product_code`, "_", `product_name`,"_", `tax`, "_", `product_price`,"_", `uom`) AS `id`, `product_code`, `product_name`,`tax`, `product_price`, `uom`'))
            ->select(DB::raw('CONCAT(`id`, "_", `product_code`, "_", `product_name`, "_", `tax`, "_", `product_price`, "_", `uom`) AS `id`, CONCAT(`product_code`,"-",`product_name`) `product_name`'))
            ->OrderBy('id', 'asc')->pluck('product_name', 'id')
            ->prepend('Select Products', '0')
            ->toArray();
            
        // $products = Product::select(DB::raw('CONCAT(`id`, "_", `product_code`, "_", `product_name`, "_", `tax`, "_", `uom`, "_", `product_price`) AS `id`, CONCAT(`product_code`,"-",`product_name`) `product_name`'))
        // ->OrderBy('id', 'asc')->pluck('product_name', 'id')->prepend('Select Product', '0');

        $taxes = Tax::select(DB::raw('CONCAT(`id`, "_", `tax_rate`) AS `tax_rate`, `tax_title`'))->OrderBy('id', 'asc')->pluck('tax_title', 'tax_rate')->toArray();
        $discounts = Discount::select(DB::raw('CONCAT(`id`, "_", `discount`) AS `discount`, `title`'))->OrderBy('id', 'asc')->pluck('title', 'discount')->toArray();

        $customers = Party::where('company_id', session()->get('company_id'))
            // ->join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
            // ->where('parties.account_group_id', '=', '1')
            // ->orwhere('parties.account_group_id', '=', '7')
            ->OrderBy('party_name', 'asc')->pluck('party_name', 'parties.id')->prepend('Select Party', '0');
        $customers_address = Party::where('company_id', session()->get('company_id'))
            // ->join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
            ->where('parties.account_group_id', '=', '1')
            ->orwhere('parties.account_group_id', '=', '7')
            ->OrderBy('party_name', 'asc')
            // ->pluck('address', 'parties.id')
            ->first();

        $uoms = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))->OrderBy('id', 'asc')->pluck('uom', 'id')->toArray();
        // $uoms =UOM::OrderBy('id', 'asc')->get();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        // return $customers_address;
        // $discount = session()->get('company_discount');
        $extratax = session()->get('company_extra_tax');
        $CompanyID = session()->get('company_id');
        if (!$CompanyID) {
            return redirect('company')->with('error', 'Please select a company first.');
        }
        // $purchase = json_decode($request->get('purchase'), true);
        $sellerCompany = Companies::select('id', 'discount')->find($CompanyID);
        if (!$sellerCompany) {
            return redirect('company')->with('error', 'Company not found.');
        }
        if ((int) $sellerCompany->discount === 1) {
            return view('salestax.pos.create-discount', compact('extratax', 'customers','customers_address', 'products', 'taxes', 'discounts', 'codes',  'uoms', 'encrypted_token', 'sellerCompany'));
        }
        // if($extratax == 1){
        //     return view('salestax.create', compact('discount', 'extratax', 'customers','customers_address', 'products', 'taxes', 'discounts', 'codes',  'uoms', 'encrypted_token'));
        // }
        return view('salestax.pos.create', compact('extratax', 'customers','customers_address', 'products', 'taxes', 'discounts', 'codes',  'uoms', 'encrypted_token', 'sellerCompany'));
    }

    public function searchProduct(Request $request)
	{ 
       
		if ($request->get('query')) {
           
			$query = $request->get('query');
			$products = Product::
			
                whereRaw('concat(product_name," ",product_code) like ?', "%{$query}%")
                ->where('company_id', session()->get('company_id'))
				->get();
			$output = '<ul class=" dropdown-menu" style="display:block; padding:0px;width:200px; position:relative;list-style-type: none;text-decoration:none !important">';
			foreach ($products as $key => $value) {

				$output .= '<a href="javascript:void(0);" onclick="AddProductDropdown('.$key.');" class="form-control dropdown-product'.$key.'" id="'.$value->id . '_' . $value->product_name . '_' . $value->product_price . '_' . $value->tax .'_'.$value->product_code.'"><li style=" width: 196px;height:25px;font-size:100%;margin-bottom:10px"><b>&nbsp;'.$value->product_code.' - ' .$value->product_name. '&nbsp;&nbsp;&nbsp;</b></li></a>';

			}
			$output .= '</ul>';
			echo $output;
		}
	}

    public function store(Request $request)
    {
        // return $request;
        $this->validate($request, [
            // 'rate' => 'required',
            'product_id1' => 'required',
            // 'party_id' => 'required',
            // 'product_code' => 'required',
            // 'product_name' => 'required',
            'quantity' => 'required',
            'stvalue' => 'required',
            // 'price_per_unit' => 'required|numeric',

        ]);
        $CompanyID = session()->get('company_id');
        // $purchase = json_decode($request->get('purchase'), true);
        $sellerCompany = Companies::where('id', $CompanyID)->first();
        
         $codes = 1;
        $code = SaleTax::where('company_id', session()->get('company_id'))
        ->where('sale_type', 'SalesTax Invoice')
        ->OrderBy('invoice_no', 'desc')
        ->first();
            // return $code;
        //return  $code;
        if (isset($code)) {
            $codes = $code->invoice_no + 1;
        }
        
        //  return $codes;

        $data = "";
        $datetime =  $request['date'];
        $totalQty = 0;
        $totalSaleValue = 0;
        $totalTaxValue = 0;
        $totalBillAmount = 0;
        $totalFurtherTax = 0;
        $DiscountFormValue = 0;
        $totalDiscount = 0;
        $purchaseData = new SaleTax();
        $purchaseData->party_id = $request->party_id;
        $purchaseData->date = date('Y-m-d', strtotime($request->date));
        $purchaseData->sale_type = $request->sale_type;
        // $purchaseData->invoice_no = $request->invoice_no;
        $purchaseData->invoice_no = $codes;
        $purchaseData->company_id = $request->session()->get('company_id');
        $purchaseData->dcn_no = $request->dcn_no;
        $purchaseData->p_order = $request->p_order;
        $purchaseData->remarks = $request->remarks;
        $purchaseData->biller = Auth::User()->id;
        $purchaseData->save();
        $sum = "0";
        $count = count($request->product_id1);
        // return $count;
        for ($i = 0; $i < $count; $i++) {
            $totalQty += $request->quantity[$i];
            $totalSaleValue += $request->incvalue[$i];
            $totalTaxValue += $request->taxvalue[$i];
            $totalBillAmount += $request->incvalue[$i];
            $totalFurtherTax += $request->extraTaxValue[$i];
           
            $purchaseDetail = new SaleTaxDetails();
            $purchaseDetail->sale_id = $purchaseData->id;
            $purchaseDetail->date = $purchaseData->date;
            $purchaseDetail->invoice_no = $purchaseData->invoice_no;
            $purchaseDetail->sale_type1 = $request->sale_type1;
            // $purchaseDetail->fbr_invoice_no = $request->fbr_invoice_no;
            $purchaseDetail->product_id = $request->product_id1[$i];
            $purchaseDetail->party_id = $request->party_id;
            $purchaseDetail->company_id = $request->session()->get('company_id');
            $purchaseDetail->uom_id = $request->uom_id[$i];
            $purchaseDetail->status = "InvoiceOnly";
            $purchaseDetail->quantity = $request->quantity[$i];
            $purchaseDetail->rate = $request->rate[$i];
            $purchaseDetail->stvalue = $request->stvalue[$i];
            $purchaseDetail->taxvalue = $request->taxvalue[$i];
            if (empty($request->extratax[$i])) {
                $purchaseDetail->extratax = 0;
            } else {
                $purchaseDetail->extratax = $request->extratax[$i];
            }
            if (empty($request->extraTaxValue[$i])) {
                $purchaseDetail->extraTaxValue = 0;
            } else {
                $purchaseDetail->extraTaxValue = $request->extraTaxValue[$i];
            }
            $purchaseDetail->price = $request->excvalue[$i];
            if (empty($request->discount[$i])) {
                $purchaseDetail->discount = 0;
                $DiscountFormValue = 0;
            } else {
                $purchaseDetail->discount = $request->discount[$i];
                $DiscountFormValue = $request->discount[$i];
            }

            if (empty($request->discountvalue[$i])) {
                $purchaseDetail->discount_value = 0;
                $DiscountFormValue = 0;
            } else {
                $purchaseDetail->discount_value = $request->discountvalue[$i];
                $totalDiscount += $request->discountvalue[$i];
                $DiscountFormValue = $request->discount[$i];
            }
            $purchaseDetail->total = $request->incvalue[$i];
            $sum = $sum + $request->incvalue[$i];
            $purchaseDetail->save();

            $RawMaterial = new RawMaterialStock();
			$RawMaterial->transction_id = $purchaseData->id;
			$RawMaterial->type = "SalesTax Invoice";
			$RawMaterial->warehouse_id = 1;
            $RawMaterial->party_id = $request->party_id;
			$RawMaterial->product_id = $request->product_id1[$i];
			$RawMaterial->uom_id = $request->uom_id[$i];
			$RawMaterial->date = $purchaseData->date;
			$RawMaterial->voucher_no = $purchaseData->invoice_no;
			$RawMaterial->cost_amount = $request->incvalue[$i];
			$RawMaterial->stockout = $request->quantity[$i];
			$RawMaterial->company_id = $request->session()->get('company_id');
			$RawMaterial->save();


            if ($i == 0) {
                $data .= '{
                    "ItemCode": "' . $request->product_code[$i] . '",
                    "ItemName": "' . $request->product_name[$i] . '",
                    "Quantity": ' . $request->quantity[$i] . ',
                    "PCTCode": "1",
                    "TaxRate": ' . $request->stvalue[$i] . ',
                    "SaleValue": ' . $request->excvalue[$i] . ',
                    "TotalAmount": ' . $request->incvalue[$i] . ',
                    "TaxCharged": ' . $request->taxvalue[$i] . ',
                    "Discount": ' . $DiscountFormValue . ',
                    "FurtherTax": ' . $request->extraTaxValue[$i] . ',
                    "InvoiceType": 1,
                    "RefUSIN": null
                }';
            } else 
            if ($i > 0) {
                $data .= ',{
                    "ItemCode": "' . 1 . '",
                    "ItemName": "' . $request->product_name[$i] . '",
                    "Quantity": ' . $request->quantity[$i] . ',
                    "PCTCode":"1",
                    "TaxRate": ' . $request->stvalue[$i] . ',
                    "SaleValue": ' . $request->excvalue[$i] . ',
                    "TotalAmount": ' . $request->incvalue[$i] . ',
                    "TaxCharged": ' . $request->taxvalue[$i] . ',
                    "Discount": ' . $DiscountFormValue . ',
                    "FurtherTax": ' . $request->extraTaxValue[$i] . ',
                    "InvoiceType": 1,
                    "RefUSIN": null
                }';
            }
        }
        // return $data;
    $partydetails = Party::where('id',$request->party_id)->get();
        $curl = curl_init();
        if($sellerCompany->system_type == "POS") {
                $apiUrl = 'https://gw.fbr.gov.pk/imsp/v1/api/Live/PostData';
            } 
        if($sellerCompany->system_type == "PRA"){
                $apiUrl = 'https://ims.pral.com.pk/ims/production/api/Live/PostData';
            }
        curl_setopt_array($curl, array(
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CUSTOMREQUEST => 'POST',
            // "POSID": "' . session()->get('company_pos_id') . '",
            CURLOPT_POSTFIELDS => '{
            "InvoiceNumber": "' . $purchaseData->invoice_no . '",
            "POSID": "' . $sellerCompany->pos_id . '",
            "USIN": "' . $purchaseData->invoice_no . '",
            "DateTime": "' . $datetime . '",
             "BuyerNTN": "'.$partydetails[0]->ntn.'",
            "BuyerCNIC": "'.$partydetails[0]->cnic.'",
            "BuyerName": "'.$partydetails[0]->party_name.'",
            "BuyerPhoneNumber": "'.$partydetails[0]->phone.'",

            "items": [
                ' . $data . '
            ],
            "TotalBillAmount": ' . $totalBillAmount . ',
            "TotalQuantity": ' . $totalQty . ',
            "TotalSaleValue": ' . $totalSaleValue . ',
            "TotalTaxCharged": ' . $totalTaxValue . ',
            "FurtherTax": ' . $totalFurtherTax . ',
            "Discount": ' . $totalDiscount . ',
            "PaymentMode": 1,
            "RefUSIN": null,
            "InvoiceType": 1
        }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer "' . $sellerCompany->token . '"',
                'Content-Type: application/json'
            ),
        ));
        // return $curl;
        $response = curl_exec($curl);
        // if(curl_exec($curl) === false){
        //     return curl_error($curl);
        // }else{
        //     return response()->json($response);
        // }
        $fbr = json_decode($response);
        // if ($response->successful()) {
        //     return response()->json(['message' => 'Email Sent']);
        // } else {
        //     return response()->json(['error' => 'Failed to Send', 'details' => $response->body()]);
        // }
        //  if (isset($fbr->Code)) { 
        $purchaseData->fbr_invoice_no = $fbr->InvoiceNumber;
        $purchaseData->save();
        //  } else {
            //  SaleTax::where('id', $purchaseData->id)->delete();
            //  SaleTaxDetails::where('sale_id', $purchaseData->id)->delete();
            //  Session::flash('error_message', 'FBR INVOICE NOT SUBMITTED, INVALID TOKEN OR POS ID!');
            //  return redirect('salestax/create');
        //  }
          //return $purchaseData->fbr_invoice_no;
        if ($purchaseData->fbr_invoice_no == "Not Available" || $purchaseData->fbr_invoice_no == null) {
            //return 'hlo';
            SaleTax::where('id', $purchaseData->id)->delete();
            SaleTaxDetails::where('sale_id', $purchaseData->id)->delete();
            RawMaterialStock::where('transction_id', $purchaseData->id)
            ->where('type', 'SalesTax Invoice')->delete();
            Session::flash('error_message', 'FBR portal is upgrading! Kindly try again after sometime.');
            return redirect('pos-salestax/create');
        }





      

        Session::flash('flash_message', 'Record Successfully Added!');

        if($purchaseData->p_order==null)
        {
            $url = "pos-salestax/print/" . $purchaseData->id;
            $urlindex = "pos-salestax/create";
        return "<script>window.open('" . $url . "', '_blank')</script>
        		<script>window.location.href='" . $urlindex . "';</script>";
        }
        else{
            $url = "pos-salestax/print/" . $purchaseData->id;
            $urlindex = "pointofsale/create";
            
        return "<script>window.open('" . $url . "', '_blank')</script>
        <script>window.location.href='" . $urlindex . "';</script>";
        }
            }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $purchase = SaleTax::with(['saletax_details' => function ($query) {
            $query->with('products');
            $query->with('uoms');
        }])->with('parties')->where('sale_taxes.id', '=', $id)->get();

        $DeliveryChallan = DeliveryChallan::where('status', '=', 'Pending')->OrderBy('dcn_no', 'asc')->pluck('dcn_no', 'dcn_no')->prepend('Select Challan', '0')->toArray();
        $edit = $purchase[0];
        // return $edit->id;
        $products = Product::select(DB::raw('CONCAT(`id`, "_", `product_name`) AS `id`, `product_name`'))->OrderBy('id', 'asc')->pluck('product_name', 'id')->prepend('Select Product', '0')->toArray();
        $customers = Party::join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
            ->where('parties.account_group_id', '=', '1')
            ->orwhere('parties.account_group_id', '=', '7')
            ->OrderBy('party_name', 'asc')->pluck('party_name', 'parties.id');
        $uoms = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))->OrderBy('id', 'asc')->pluck('uom', 'id')->toArray();
        $discounts = Discount::select(DB::raw('CONCAT(`id`, "_", `discount`) AS `discount`, `title`'))->OrderBy('id', 'asc')->pluck('title', 'discount')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('salestax.edit', compact('edit', 'products', 'DeliveryChallan', 'customers', 'encrypted_token', 'uoms', 'discounts'));
    }

    // public function update(Request $request, $id)
    // {
    //     $objPurchase = SaleTax::findOrFail($id);

    //     $objPurchase->party_id = $request->party_id;
    //     $objPurchase->date = date('d/m/Y', strtotime($request->date));
    //     $objPurchase->sale_type = $request->sale_type;
    //     $objPurchase->invoice_no = $request->invoice_no;
    //     $objPurchase->dcn_no = $request->dcn_no;
    //     $objPurchase->p_order = $request->p_order;
    //     $objPurchase->remarks = $request->remarks;
    //     $objPurchase->biller = Auth::User()->id;
    //     $objPurchase->save();

    //     SaleTaxDetails::where('sale_id', '=', $id)->delete();
    //     GeneralVoucher::where('dc_id', '=', $id)->delete();
    //     LedgerDetailWise::where('dc_id', '=', $id)->delete();
    //     StockRegisterSpecificItem::where('dc_id', '=', $id)->delete();

    //     $sum = "0";
    //     $count = count($request->product_id1);
    //     for ($i = 0; $i < $count; $i++) {
    //         $purchaseDetail = new SaleTaxDetails();
    //         $purchaseDetail->sale_id = $objPurchase->id;
    //         $purchaseDetail->product_id = $request->product_id1[$i];
    //         $purchaseDetail->party_id = $request->party_id;
    //         $purchaseDetail->uom_id = $request->uom_id[$i];
    //         if (($request->lessCommercial) == "true") {
    //             $purchaseDetail->status = "stockin";
    //         } else {
    //             $purchaseDetail->status = "InvoiceOnly";
    //         }
    //         $purchaseDetail->quantity = $request->quantity[$i];
    //         $purchaseDetail->rate = $request->rate[$i];
    //         $purchaseDetail->stvalue = $request->stvalue[$i];
    //         $purchaseDetail->taxvalue = $request->taxvalue[$i];
    //         if (empty($request->extratax[$i])) {
    //             $purchaseDetail->extratax = 0;
    //         } else {
    //             $purchaseDetail->extratax = $request->extratax[$i];
    //         }

    //         if (empty($request->extraTaxValue[$i])) {
    //             $purchaseDetail->extraTaxValue = 0;
    //         } else {
    //             $purchaseDetail->extraTaxValue = $request->extraTaxValue[$i];
    //         }


    //         $purchaseDetail->price = $request->excvalue[$i];
    //         $purchaseDetail->total = $request->incvalue[$i];
    //         $sum = $sum + $request->incvalue[$i];
    //         $purchaseDetail->save();

    //         if (($request->lessCommercial) == "true") {
    //             $vouchers = new StockRegisterSpecificItem();
    //             $vouchers->dc_id = $objPurchase->id;
    //             $vouchers->date = $objPurchase->date;
    //             $vouchers->party_id = $request->party_id;
    //             $vouchers->product_id = $request->product_id1[$i];
    //             $vouchers->voucher_type = $objPurchase->sale_type;
    //             $vouchers->uom_id = $request->uom_id[$i];
    //             $vouchers->sale_quantity = $request->quantity[$i];
    //             $vouchers->cost_rate = $request->incvalue[$i];
    //             $vouchers->save();
    //         }

    //         $vouchers = new LedgerDetailWise();
    //         $vouchers->dc_id = $objPurchase->id;
    //         $vouchers->party_id = $request->party_id;
    //         $vouchers->voucher_no = $objPurchase->invoice_no;
    //         $vouchers->voucher_type = "SalesTax Invoice";
    //         $vouchers->date = $objPurchase->date;
    //         $vouchers->product_id = $request->product_id1[$i];
    //         $vouchers->quantity = $request->quantity[$i];
    //         $vouchers->rate = $request->rate[$i];
    //         $vouchers->other = $request->TotalTax[$i];
    //         $vouchers->debit = $request->incvalue[$i];
    //         $vouchers->save();
    //     }

    //     $vouchers = new GeneralVoucher();
    //     $vouchers->dc_id = $objPurchase->id;
    //     $vouchers->account_head_id = $objPurchase->party_id;
    //     $vouchers->date = $objPurchase->date;
    //     $vouchers->voucher_no = $objPurchase->invoice_no;
    //     $vouchers->invoice_no = $objPurchase->invoice_no;
    //     $vouchers->v_type = $objPurchase->sale_type;
    //     $vouchers->debit = $sum;
    //     $vouchers->save();

    //     Session::flash('flash_message', 'Record Successfully Updated!');
    //     return redirect('salestax');
    // }

    public function destroy($id)
    {
        $delete = SaleTax::findOrFail($id);
        $delete->delete();
        SaleTaxDetails::where('sale_id', '=', $id)->delete();
        RawMaterialStock::where('transction_id', $id)
            ->where('type', 'SalesTax Invoice')->delete();
        // GeneralVoucher::where('dc_id', '=', $id)->delete();
        // LedgerDetailWise::where('dc_id', '=', $id)->delete();
        //StockRegisterSpecificItem::where('dc_id', '=', $id)->delete();
        return redirect()->back();
    }

    public function MultiDelete(Request $request){
        $this->validate($request, [
            'Dltid' => 'required'
          ]);
        //   return $request;
        $count = Count($request->Dltid);
        // return $count; 
        for ($i = 0; $i < $count; $i++) {
            $delete = SaleTax::findOrFail($request->Dltid[$i]);
            $delete->delete();
            SaleTaxDetails::where('sale_id', '=', $request->Dltid[$i])->delete();
            //  RawMaterialStock::where('purchase_milk_id', '=', $request->SaleTaxID[$i])->delete(); 
            //  StockRegisterSpecificItem::where('purchase_milk_id', '=', $request->SaleTaxID[$i])->delete();
        }
        return redirect()->back();
    }
    public function PartyChange(Request $request)
    {
        $partyID = $request->get('party_ID');
        $data = Party::where('id', '=', $partyID)->get();
        return $data;
    }

    public function productChange(Request $request)
    {
        $productID = $request->get('product_ID');
        $data = Product::where('id', '=', $productID)->get(['products.*']);
        return $data;
    }

    public function print_sale($id)
    {
        $companyID = session()->get('company_id');
        $company = Companies::where('id', $companyID)->first('system_type');
        $newsale_detail = SaleTax::with(['saletax_details' => function ($query) {
            $query->with('uoms');
            $query->with('products');
        }])->where('sale_taxes.id', '=', $id)
            ->get();
        $company_detail = Setting::where('id', '=', 1)->get();
        // $company_detail = User::where('id', '=',session()->get('company_id'))->get();
        $logo = SystemLogo::where('id', '=', 1)->get();
        if (session()->get('company_bill_type') == 'A4') {
            $discount = session()->get('company_discount');
            if($discount == 1){
            return view('salestax.pos.discount', compact('newsale_detail', 'company_detail', 'logo', 'id', 'company'));
            }
            return view('salestax.pos.a4', compact('newsale_detail', 'company_detail', 'logo', 'id', 'company'));
        }
        else {
            $discount = session()->get('company_discount');
            if($discount == 1){
                return view('salestax.pos.thermal-discount', compact('newsale_detail', 'company_detail', 'logo', 'id'));
                }
            return view('salestax.pos.thermal', compact('newsale_detail', 'company_detail', 'logo', 'id'));
        }
    }


    public function print_pdf($id)
    {
        $newsale_detail = SaleTax::with(['saletax_details' => function ($query) {
            $query->with(['products' => function ($query) {
            }]);
            //$query->with('taxes');
            //$query->with('discount');
            //$query->with('ledger');
            //$query->with('publishers');
        }]) //->with('parties')->with('billers')
            ->where('sale_taxes.id', '=', $id)
            ->get();
        $ledgers = Ledger::with('ledger_party')->where('party_id', '=', $newsale_detail[0]->parties->id)->get();

        $company_detail = Setting::where('id', '=', 1)->get();
        $logo = SystemLogo::where('id', '=', 1)->get();

        $pdf = PDF::loadView('salestax.pos.printpdf', ['newsale_detail' => $newsale_detail, 'company_detail' => $company_detail, 'logo' => $logo]);
        return $pdf->download('salestax_invoice.pdf');
    }


    public function print_dc($id)
    {
        $newsale_detail = SaleTax::with(['saletax_details' => function ($query) {
            $query->with(['products' => function ($query) {
            }]);
            //$query->with('taxes');
            //$query->with('discount');
            //$query->with('ledger');
            //$query->with('publishers');
        }]) //->with('parties')->with('billers')
            ->where('sale_taxes.id', '=', $id)
            ->get();
        $ledgers = Ledger::with('ledger_party')->where('party_id', '=', $newsale_detail[0]->parties->id)->get();

        $company_detail = Setting::where('id', '=', 1)->get();
        $logo = SystemLogo::where('id', '=', 1)->get();

        return view('salestax.pos.dcn', compact('newsale_detail', 'company_detail', 'ledgers', 'logo'));
    }

    public function pos_create()
    {
        $products = Product::OrderBy('id')->
        where('company_id',session()->get('company_id'))->get();
        //    $products = Product::where('company_id', session()->get('company_id'))
        // ->select(DB::raw('CONCAT(`id`, "_", `product_code`, "_", `product_name`,"_", `tax`, "_", `product_price`,"_", `uom`) AS `id`, `product_code`, `product_name`,`tax`, `product_price`, `uom`'))
        // ->OrderBy('id', 'asc')->pluck('product_name', 'id')
        // // ->prepend('Select Product', '0')
        // ->toArray();
        // $sales = SaleTax::OrderBy('id','desc')->first();
        // $codes = 1;
        // if($sales)
        // {
        //     $codes = $sales->invoice_no+1;
        // }
        
        
         $codes = 1;
        $code = SaleTax::where('company_id', session()->get('company_id'))
        ->where('sale_type', 'SalesTax Invoice')

            ->OrderBy('invoice_no', 'desc')
            ->first();
            // return $code;
        //return  $code;
        if (isset($code)) {
            $codes = $code->invoice_no + 1;
        }
        
        
        $settings = Setting::where('id', 1)->get();
        $salescate = AccountGroup::OrderBy('id', 'asc')->pluck('name', 'name');
        $cate = AccountGroup::all();
        $customers = Party::where('company_id', session()->get('company_id'))
        // ->join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
        ->where('parties.account_group_id', '=', '1')
        ->orwhere('parties.account_group_id', '=', '7')
        ->OrderBy('party_name', 'asc')->pluck('party_name', 'parties.id')
        // ->prepend('Select Party', '0')
        ;
    $customers_address = Party::where('company_id', session()->get('company_id'))
        // ->join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
        ->where('parties.account_group_id', '=', '1')
        ->orwhere('parties.account_group_id', '=', '7')
        ->OrderBy('party_name', 'asc')
        // ->pluck('address', 'parties.id')
        ->first()
        ;
        // return $products[0];
        // return $sales;
        return view('pos.pos', compact('products','codes', 'settings','salescate','cate','customers','customers_address'));
    }
    public function pos_store(Request $request)
    {
        // return $request;
        $this->validate($request,[
            'product_id.0'=>'required'
        ],[
            'product_id.0.required'=>'The Product field is required'
        ]);
        
         $codes = 1;
        $code = SaleTax::where('company_id', session()->get('company_id'))
        ->where('sale_type', 'SalesTax Invoice')

            ->OrderBy('invoice_no', 'desc')
            ->first();
            // return $code;
        //return  $code;
        if (isset($code)) {
            $codes = $code->invoice_no + 1;
        }
        $data = $request->all();
        $data['invoice_no'] = $codes;
        $s = SaleTax::create($data);
        $totalQty = 0; $totalAmount =0;
        for($i=0;$i<count($request->product_id);$i++)
        {

            $sDetails = new SaleTaxDetails();
            $sDetails->sale_id = $s->id;
            $sDetails->product_id = $request->product_id[$i];
            $sDetails->party_id = 0;
            $sDetails->uom_id = 0;
            $sDetails->discount_id = 0;
            $sDetails->biller = $request->biller;
            $sDetails->customername=$request->customername;
            $sDetails->customerphone=$request->customerphone;
            $sDetails->category = $request->category;
            $sDetails->comments=$request->sale_comment[$i];
            $sDetails->warehouse_id = 0;
            $sDetails->quantity = $request->quantity[$i];
            // $sDetails->sale_rate = $request->product_price[$i];
            $sDetails->sale_rate = $request->sale_rate[$i];
            $sDetails->sale_amount = $request->sale_amount[$i];
            $sDetails->save();
            $totalQty = $totalQty + $request->quantity[$i];
            $totalAmount = $totalAmount + $request->sale_amount[$i];
        }
        $s->total_qty = $totalQty;
        $s->total_amount = $totalAmount;
        // $s->customername=$request->customername;
        // $s->customerphone=$request->customerphone;
        $s->category = $request->category;
        $s->save();
        $url = "pointofsale/print/" . $s->id;
        $urlindex = "pointofsale/create";
        return "<script>window.open('".$url."', '_blank');</script>
        <script>window.location.href='".$urlindex."';</script>";

                // <script type='text/javascript'>window.location.href='" . $urlindex . "';</script>
       // Session::flash('flash_message','Record Added Successfully');

        //return redirect()->back();
    //  return redirect('pointofsale/print/'.$s->id);
       
        
        // return redirect()->back();
        
        
		// return "<script>window.open('" . $url . "', '_blank')</script>
		// 		<script>window.location.href='" . $urlindex . "';</script>";
    }
}
