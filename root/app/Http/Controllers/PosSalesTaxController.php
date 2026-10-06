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
use App\Models\Scenario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Services\InvoicePdfMailer;
use App\Services\CompanyInvoiceGuard;
use App\Services\KpraRimsClient;
use App\Services\SrbInvoiceSubmission;
use Illuminate\Support\Facades\Log;
use PDF;
use Carbon\Carbon;
use DateTime;

class PosSalesTaxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $fromDateInput = $request->get('from_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $toDateInput = $request->get('to_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        try {
            $fromDate = Carbon::parse($fromDateInput)->startOfDay();
            $toDate = Carbon::parse($toDateInput)->endOfDay();
        } catch (\Exception $e) {
            Session::flash('error_message', 'Invalid date format.');
            return redirect('pos-salestax');
        }

        if ($fromDate->gt($toDate)) {
            Session::flash('error_message', 'From date cannot be greater than To date.');
            return redirect('pos-salestax');
        }

        $sales = SaleTax::OrderBy('id', 'desc')
            ->with(['saletax_details' => function ($query) {
                //$query->with('taxes');
                //$query->with('discount');
                //$query->with('parties');
            }])
            ->with('billers')
            ->where('company_id', session()->get('company_id'))
            ->where('sale_type', 'SalesTax Invoice')
            ->whereDate('date', '>=', $fromDate->format('Y-m-d'))
            ->whereDate('date', '<=', $toDate->format('Y-m-d'))
            ->get();

        return view('salestax.pos.index', compact('sales', 'fromDateInput', 'toDateInput'));
    }

    public function create()
    {
        $CompanyID = session()->get('company_id');
        if (!$CompanyID) {
            return redirect('company')->with('error', 'Please select a company first.');
        }

        $sellerCompany = Companies::select('id', 'discount', 'discount_fixed', 'invoice_serial', 'number_of_invoices', 'system_type', 'invoice_type')->find($CompanyID);
        if (!$sellerCompany) {
            return redirect('company')->with('error', 'Company not found.');
        }

        $limitError = CompanyInvoiceGuard::monthlyLimitError($CompanyID, date('Y-m-d'));
        if ($limitError) {
            Session::flash('error_message', $limitError);
        }

        $codes = CompanyInvoiceGuard::nextInvoiceNo($CompanyID);

        // Check if session has company_id, otherwise use 0
        $companyId = $CompanyID;
        $products = Product::where('company_id', $companyId)
            // ->select(DB::raw('CONCAT(`id`, "_", `product_code`, "_", `product_name`,"_", `tax`, "_", `product_price`,"_", `uom`) AS `id`, `product_code`, `product_name`,`tax`, `product_price`, `uom`'))
            ->select(DB::raw('CONCAT(`id`, "_", IFNULL(`product_code`, ""), "_", IFNULL(`product_name`, ""), "_", IFNULL(`tax`, "0"), "_", IFNULL(`product_price`, "0"), "_", IFNULL(`uom`, "")) AS `id`, CONCAT(IFNULL(`product_code`, ""),"-",IFNULL(`product_name`, "")) `product_name`'))
            ->OrderBy('id', 'asc')->pluck('product_name', 'id')
            ->prepend('Select Products', '0')
            ->toArray();
            
        // $products = Product::select(DB::raw('CONCAT(`id`, "_", `product_code`, "_", `product_name`, "_", `tax`, "_", `uom`, "_", `product_price`) AS `id`, CONCAT(`product_code`,"-",`product_name`) `product_name`'))
        // ->OrderBy('id', 'asc')->pluck('product_name', 'id')->prepend('Select Product', '0');

        $taxes = Tax::select(DB::raw('CONCAT(`id`, "_", `tax_rate`) AS `tax_rate`, `tax_title`'))->OrderBy('id', 'asc')->pluck('tax_title', 'tax_rate')->toArray();
        $discounts = Discount::select(DB::raw('CONCAT(`id`, "_", `discount`) AS `discount`, `title`'))->OrderBy('id', 'asc')->pluck('title', 'discount')->toArray();

        $customers = Party::where('company_id', session()->get('company_id'))
            ->whereIn('account_group_id', [1, 7])
            ->orderBy('party_name', 'asc')
            ->pluck('party_name', 'id')
            ->prepend('Select Party', '0');
        $customers_address = Party::where('company_id', session()->get('company_id'))
            ->whereIn('account_group_id', [1, 7])
            ->orderBy('party_name', 'asc')
            ->first();

        $uoms = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))->OrderBy('id', 'asc')->pluck('uom', 'id')->toArray();
        // $uoms =UOM::OrderBy('id', 'asc')->get();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        // return $customers_address;
        // $discount = session()->get('company_discount');
        $extratax = session()->get('company_extra_tax');
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
        $partyId = $request->party_id ?: $request->party_name;
        if (empty($partyId)) {
            return redirect()->back()->withInput()->with('error', 'Please select a party first.');
        }
        $partyId = (int) $partyId;

        $limitError = CompanyInvoiceGuard::monthlyLimitError($CompanyID, $request->date);
        if ($limitError) {
            Session::flash('error_message', $limitError);
            return redirect()->back()->withInput();
        }

        $codes = CompanyInvoiceGuard::nextInvoiceNo($CompanyID);
        
        //  return $codes;

        $data = "";
        $datetime =  $request['date'];
        $totalQty = 0;
        $totalSaleValue = 0;
        $totalTaxValue = 0;
        $totalBillAmount = 0;
        $totalFurtherTax = 0;
        $totalExTax = 0;
        $taxRateFirst = 0;
        $DiscountFormValue = 0;
        $totalDiscount = 0;
        $purchaseData = new SaleTax();
        $purchaseData->party_id = $partyId;
        $purchaseData->date = date('Y-m-d', strtotime($request->date));
        $purchaseData->sale_type = $request->sale_type;
        // $purchaseData->invoice_no = $request->invoice_no;
        $purchaseData->invoice_no = $codes;
        $purchaseData->company_id = $request->session()->get('company_id');
        $purchaseData->dcn_no = $request->dcn_no;
        $purchaseData->p_order = $request->p_order;
        $purchaseData->remarks = $request->remarks;
        $purchaseData->biller = Auth::User()->id;
        $purchaseData->discount_amount = $request->discount_amount ?? 0;
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
            $totalExTax += (float) ($request->excvalue[$i] ?? 0);
            if ($i === 0) {
                $taxRateFirst = (float) ($request->stvalue[$i] ?? 0);
            }
           
            $purchaseDetail = new SaleTaxDetails();
            $purchaseDetail->sale_id = $purchaseData->id;
            $purchaseDetail->date = $purchaseData->date;
            $purchaseDetail->invoice_no = $purchaseData->invoice_no;
            $purchaseDetail->sale_type1 = $request->sale_type1;
            // $purchaseDetail->fbr_invoice_no = $request->fbr_invoice_no;
            $purchaseDetail->product_id = $request->product_id1[$i];
            $purchaseDetail->party_id = $partyId;
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
            $RawMaterial->party_id = $partyId;
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
        
        // Check if approval is required (approval == 1 means dashboard approval needed)
        // If approval == 0, submit directly to POS/PRA/KPRA API
        if ($sellerCompany->approval == 0) {
            if ($sellerCompany->system_type === 'SRB') {
                $srb = app(SrbInvoiceSubmission::class)->submit($purchaseData->id, $sellerCompany);
                if (isset($srb['debug_mode'])) {
                    return $this->authorityDebugDump($sellerCompany, $srb['raw'] ?? null, $srb['body'] ?? null);
                }
                if (!$srb['ok']) {
                    Session::flash('error_message', 'Invoice ' . $purchaseData->invoice_no . ' saved. SRB: ' . $srb['message']);
                    return redirect('pos-salestax');
                }
                $purchaseData->refresh();
                Session::flash('flash_message', $srb['message']);
            } elseif ($sellerCompany->system_type === 'KPRA') {
                $kpraPayload = KpraRimsClient::buildLivePayload(
                    $sellerCompany,
                    $purchaseData->invoice_no,
                    $totalExTax,
                    $totalTaxValue,
                    $taxRateFirst,
                    $totalBillAmount,
                    $datetime,
                    1
                );
                $kpra = KpraRimsClient::sendLiveInvoice($kpraPayload, (bool) ($sellerCompany->debug_mode ?? false));

                if ($this->shouldDumpAuthorityDebug($sellerCompany)) {
                    return $this->authorityDebugDump(
                        $sellerCompany,
                        $kpra['raw'] ?? null,
                        $kpra['body'] ?? (isset($kpra['raw']) ? json_decode($kpra['raw'], true) : null)
                    );
                }

                if (!$kpra['ok']) {
                    SaleTax::where('id', $purchaseData->id)->delete();
                    SaleTaxDetails::where('sale_id', $purchaseData->id)->delete();
                    RawMaterialStock::where('transction_id', $purchaseData->id)
                        ->where('type', 'SalesTax Invoice')->delete();
                    Session::flash('error_message', 'KPRA: ' . ($kpra['message'] ?? 'Submission failed.'));
                    return redirect('pos-salestax/create');
                }

                $purchaseData->fbr_invoice_no = $kpra['transaction_id'];
                $purchaseData->save();
                Session::flash('flash_message', 'Record Successfully Added & Linked to KPRA!');
            } else {
                // Direct API submission (no dashboard approval required)
                $partydetails = Party::where('id', $partyId)->get();
                $grandDiscount = $totalDiscount + (float) ($purchaseData->discount_amount ?? 0);
                $curl = curl_init();
                if ($sellerCompany->system_type == "POS") {
                    $apiUrl = 'https://gw.fbr.gov.pk/imsp/v1/api/Live/PostData';
                }
                if ($sellerCompany->system_type == "PRA") {
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
                    CURLOPT_POSTFIELDS => '{
                    "InvoiceNumber": "' . $purchaseData->invoice_no . '",
                    "POSID": "' . $sellerCompany->pos_id . '",
                    "USIN": "' . $purchaseData->invoice_no . '",
                    "DateTime": "' . $datetime . '",
                    "BuyerNTN": "' . $partydetails[0]->ntn . '",
                    "BuyerCNIC": "' . $partydetails[0]->cnic . '",
                    "BuyerName": "' . $partydetails[0]->party_name . '",
                    "BuyerPhoneNumber": "' . $partydetails[0]->phone . '",
                    "items": [
                        ' . $data . '
                    ],
                    "TotalBillAmount": ' . $totalBillAmount . ',
                    "TotalQuantity": ' . $totalQty . ',
                    "TotalSaleValue": ' . $totalSaleValue . ',
                    "TotalTaxCharged": ' . $totalTaxValue . ',
                    "FurtherTax": ' . $totalFurtherTax . ',
                    "Discount": ' . $grandDiscount . ',
                    "DiscountAmount": ' . ($purchaseData->discount_amount ?? 0) . ',
                    "PaymentMode": 1,
                    "RefUSIN": null,
                    "InvoiceType": 1
                }',
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: Bearer "' . $sellerCompany->token . '"',
                        'Content-Type: application/json'
                    ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                $fbr = json_decode($response);

                $purchaseData->fbr_invoice_no = $fbr->InvoiceNumber ?? null;
                $purchaseData->save();

                if ($purchaseData->fbr_invoice_no == "Not Available" || $purchaseData->fbr_invoice_no == null) {
                    SaleTax::where('id', $purchaseData->id)->delete();
                    SaleTaxDetails::where('sale_id', $purchaseData->id)->delete();
                    RawMaterialStock::where('transction_id', $purchaseData->id)
                        ->where('type', 'SalesTax Invoice')->delete();
                    Session::flash('error_message', 'FBR portal is upgrading! Kindly try again after sometime.');
                    return redirect('pos-salestax/create');
                }

                Session::flash('flash_message', 'Record Successfully Added & Linked to FBR!');
            }
        } else {
            // approval == 1: Save as draft, will be approved from dashboard
            $linkLabel = in_array($sellerCompany->system_type, ['KPRA', 'SRB'], true) ? $sellerCompany->system_type : 'FBR';
            Session::flash('flash_message', 'Record Saved as Draft! Please approve from Dashboard to link with ' . $linkLabel . '.');
        }

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

    public function approve(Request $request)
    {
        $this->validate($request, [
            'invoice_id' => 'required'
        ]);

        $companyID = session()->get('company_id');
        $sale = SaleTax::with(['saletax_details' => function ($query) {
            $query->with('products');
        }])
            ->where('id', $request->invoice_id)
            ->where('company_id', $companyID)
            ->first();

        if (!$sale) {
            return redirect()->back()->with('error', 'Invoice not found.');
        }

        $sellerCompany = Companies::find($companyID);
        if (!$sellerCompany) {
            return redirect()->back()->with('error', 'Company not found.');
        }

        if ($sellerCompany->system_type === 'SRB') {
            $srb = app(SrbInvoiceSubmission::class)->submit($sale->id, $sellerCompany);
            if (isset($srb['debug_mode'])) {
                return $this->authorityDebugDump($sellerCompany, $srb['raw'] ?? null, $srb['body'] ?? null);
            }
            return redirect()->back()->with($srb['ok'] ? 'flash_message' : 'error', $srb['message']);
        }

        if (!empty($sale->fbr_invoice_no)) {
            $alreadyLabel = in_array($sellerCompany->system_type ?? '', ['KPRA', 'SRB'], true) ? $sellerCompany->system_type : 'FBR';
            return redirect()->back()->with('error', 'Invoice already linked to ' . $alreadyLabel . '.');
        }

        $party = Party::find($sale->party_id);
        if (!$party) {
            return redirect()->back()->with('error', 'Party not found.');
        }

        if ($sellerCompany->system_type === 'KPRA') {
            $totalExTax = 0;
            $totalTaxValue = 0;
            $totalBillAmount = 0;
            $taxRateFirst = 0;
            foreach ($sale->saletax_details as $index => $detail) {
                $totalExTax += (float) $detail->price;
                $totalTaxValue += (float) $detail->taxvalue;
                $totalBillAmount += (float) $detail->total;
                if ($index === 0) {
                    $taxRateFirst = (float) $detail->stvalue;
                }
            }
            $kpraPayload = KpraRimsClient::buildFromSale(
                $sellerCompany,
                $sale,
                $totalExTax,
                $totalTaxValue,
                $taxRateFirst,
                $totalBillAmount,
                1
            );
            $kpra = KpraRimsClient::sendLiveInvoice($kpraPayload, (bool) ($sellerCompany->debug_mode ?? false));
            if ($this->shouldDumpAuthorityDebug($sellerCompany)) {
                return $this->authorityDebugDump(
                    $sellerCompany,
                    $kpra['raw'] ?? null,
                    $kpra['body'] ?? (isset($kpra['raw']) ? json_decode($kpra['raw'], true) : null)
                );
            }
            if (!$kpra['ok']) {
                return redirect()->back()->with('error', 'KPRA: ' . ($kpra['message'] ?? 'Submission failed.'));
            }
            $sale->fbr_invoice_no = $kpra['transaction_id'];
            $sale->save();
            Session::flash('flash_message', 'Invoice successfully linked to KPRA.');
            return redirect()->back();
        }

        $totalQty = 0;
        $totalSaleValue = 0;
        $totalTaxValue = 0;
        $totalBillAmount = 0;
        $totalFurtherTax = 0;
        $totalDiscount = 0;
        $items = [];

        foreach ($sale->saletax_details as $index => $detail) {
            $discountRate = $detail->discount ?? 0;
            $discountValue = $detail->discount_value ?? 0;

            $totalQty += (float) $detail->quantity;
            $totalSaleValue += (float) $detail->price;
            $totalTaxValue += (float) $detail->taxvalue;
            $totalBillAmount += (float) $detail->total;
            $totalFurtherTax += (float) ($detail->extraTaxValue ?? 0);
            $totalDiscount += (float) $discountValue;

            $itemCode = $index === 0
                ? ($detail->products->product_code ?? $detail->product_id)
                : 1;

            $items[] = [
                "ItemCode" => $itemCode,
                "ItemName" => $detail->products->product_name ?? '',
                "Quantity" => (float) $detail->quantity,
                "PCTCode" => "1",
                "TaxRate" => (float) $detail->stvalue,
                "SaleValue" => (float) $detail->price,
                "TotalAmount" => (float) $detail->total,
                "TaxCharged" => (float) $detail->taxvalue,
                "Discount" => (float) $discountRate,
                "FurtherTax" => (float) ($detail->extraTaxValue ?? 0),
                "InvoiceType" => 1,
                "RefUSIN" => null
            ];
        }

        $grandDiscount = $totalDiscount + (float) ($sale->discount_amount ?? 0);

        $payload = [
            "InvoiceNumber" => (string) $sale->invoice_no,
            "POSID" => (string) $sellerCompany->pos_id,
            "USIN" => (string) $sale->invoice_no,
            "DateTime" => (string) $sale->date,
            "BuyerNTN" => (string) $party->ntn,
            "BuyerCNIC" => (string) $party->cnic,
            "BuyerName" => (string) $party->party_name,
            "BuyerPhoneNumber" => (string) $party->phone,
            "items" => $items,
            "TotalBillAmount" => $totalBillAmount,
            "TotalQuantity" => $totalQty,
            "TotalSaleValue" => $totalSaleValue,
            "TotalTaxCharged" => $totalTaxValue,
            "FurtherTax" => $totalFurtherTax,
            "Discount" => $grandDiscount,
            "DiscountAmount" => $sale->discount_amount ?? 0,
            "PaymentMode" => 1,
            "RefUSIN" => null,
            "InvoiceType" => 1
        ];

        if ($sellerCompany->system_type == "POS") {
            $apiUrl = 'https://gw.fbr.gov.pk/imsp/v1/api/Live/PostData';
        } else {
            $apiUrl = 'https://ims.pral.com.pk/ims/production/api/Live/PostData';
        }

        $curl = curl_init();
        curl_setopt_array($curl, [
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
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer "' . $sellerCompany->token . '"',
                'Content-Type: application/json'
            ],
        ]);

        $response = curl_exec($curl);
        if ($response === false) {
            $errorMessage = curl_error($curl);
            curl_close($curl);
            return redirect()->back()->with('error', 'FBR request failed: ' . $errorMessage);
        }

        if ($sellerCompany->debug_mode == 1) {
            return $response;
        }
        curl_close($curl);
        $fbr = json_decode($response);
        if ($sellerCompany->debug_mode == 2) {
            return json_decode($response, true);
        }

        $invoiceNumber = $fbr->InvoiceNumber ?? null;

        if (empty($invoiceNumber) || $invoiceNumber === "Not Available") {
            return redirect()->back()->with('error', 'FBR portal is not available. Please try again later.');
        }

        $sale->fbr_invoice_no = $invoiceNumber;
        $sale->save();

        Session::flash('flash_message', 'Invoice successfully linked to FBR.');
        return redirect()->back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $companyId = session()->get('company_id');
        if (!$companyId) {
            return redirect('company')->with('error', 'Please select a company first.');
        }

        $purchase = SaleTax::with(['saletax_details' => function ($query) {
            $query->with('products');
            $query->with('uoms');
        }])->with('parties')->where('sale_taxes.id', '=', $id)->get();

        $sellerCompany = Companies::find($companyId);
        if (!$sellerCompany) {
            return redirect('company')->with('error', 'Company not found.');
        }

        // $DeliveryChallan = DeliveryChallan::where('status', '=', 'Pending')->OrderBy('dcn_no', 'asc')->pluck('dcn_no', 'dcn_no')->prepend('Select Challan', '0')->toArray();
        if ($sellerCompany->system_type === 'SRB') {
            $sale = SaleTax::where('company_id', $companyId)->findOrFail($id);
            if ($sale->fbr_invoice_no) {
                return redirect('pos-salestax')->with('error', 'Submitted SRB invoices cannot be edited. Reconcile or issue a sales return through SRB.');
            }
            return view('salestax.pos.srb-edit', compact('sale'));
        }
        $DeliveryChallan = DeliveryChallan::where('company_id', session()->get('company_id'))
            ->where('status', '=', 0)
            ->OrderBy('vr_no', 'asc')
            ->pluck('vr_no', 'vr_no')
            ->prepend('Select Challan', '0')->toArray();
        $edit = $purchase[0];
        // return $edit->id;
        $products = Product::select(DB::raw('CONCAT(`id`, "_", `product_name`) AS `id`, `product_name`'))->OrderBy('id', 'asc')->pluck('product_name', 'id')->prepend('Select Product', '0')->toArray();
        $customers = Party::where('company_id', session()->get('company_id'))
            ->whereIn('account_group_id', [1, 7])
            ->orderBy('party_name', 'asc')
            ->pluck('party_name', 'id');
        $uoms = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))->OrderBy('id', 'asc')->pluck('uom', 'id')->toArray();
        $discounts = Discount::select(DB::raw('CONCAT(`id`, "_", `discount`) AS `discount`, `title`'))->OrderBy('id', 'asc')->pluck('title', 'discount')->toArray();

        $scenarioCodes = [];
        if (!empty($sellerCompany->scenario)) {
            $decodedScenarios = json_decode($sellerCompany->scenario, true);
            if (is_array($decodedScenarios)) {
                $scenarioCodes = array_column($decodedScenarios, 'scenario');
            }
        }

        $scenarios = Scenario::select('id', DB::raw('CONCAT(`name`, " - ", `sale_type`) AS `scenario_name`'))
            ->when(!empty($scenarioCodes), function ($query) use ($scenarioCodes) {
                $query->whereIn('name', $scenarioCodes);
            })
            ->orderBy('name', 'asc')
            ->pluck('scenario_name', 'id')
            ->prepend('Select Scenario', '')
            ->toArray();

        $sroschedule = collect(['' => 'Choose']);
        $sroitem = collect(['' => 'Choose']);

        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('salestax.edit', compact('edit', 'products', 'DeliveryChallan', 'customers', 'encrypted_token', 'uoms', 'discounts', 'sellerCompany', 'scenarios', 'sroschedule', 'sroitem'));
    }

    public function update(Request $request, $id)
    {
        $company = Companies::findOrFail(session('company_id'));
        abort_unless($company->system_type === 'SRB', 404);
        $request->validate([
            'discount_amount' => 'required|numeric|min:0',
            'lines' => 'required|array|min:1', 'lines.*.id' => 'required|integer|distinct',
            'lines.*.quantity' => 'required|numeric|gt:0', 'lines.*.rate' => 'required|numeric|gt:0',
            'lines.*.stvalue' => 'required|numeric|min:0', 'lines.*.discount_value' => 'required|numeric|min:0',
        ]);
        try {
            DB::transaction(function () use ($request, $id, $company) {
                Companies::whereKey($company->id)->lockForUpdate()->firstOrFail();
                $sale = SaleTax::where('company_id', $company->id)->lockForUpdate()->findOrFail($id);
                if ($sale->fbr_invoice_no) {
                    throw new \InvalidArgumentException('Submitted SRB invoices cannot be edited.');
                }
                if (count($request->lines) !== $sale->saletax_details()->count()) {
                    throw new \InvalidArgumentException('All original invoice lines are required.');
                }
                foreach ($request->lines as $input) {
                    $line = $sale->saletax_details()->whereKey($input['id'])->firstOrFail();
                    $line->quantity = $input['quantity']; $line->rate = $input['rate']; $line->stvalue = $input['stvalue'];
                    $line->price = round($line->quantity * $line->rate, 2);
                    $line->taxvalue = round($line->price * $line->stvalue / 100, 2);
                    $line->discount_value = $input['discount_value'];
                    $line->total = round($line->price + $line->taxvalue - $line->discount_value, 2);
                    $line->save();
                }
                $sale->discount_amount = $request->discount_amount;
                $sale->unsetRelation('saletax_details');
                app(\App\Services\SrbPosClient::class)->buildPayload($company, $sale);
                $sale->save();
                RawMaterialStock::where('transction_id', $sale->id)->where('company_id', $company->id)->where('type', 'SalesTax Invoice')->delete();
                foreach ($sale->saletax_details as $line) {
                    $stock = new RawMaterialStock();
                    $stock->transction_id = $sale->id; $stock->type = 'SalesTax Invoice'; $stock->warehouse_id = 1;
                    $stock->party_id = $sale->party_id; $stock->product_id = $line->product_id; $stock->uom_id = $line->uom_id;
                    $stock->date = $sale->date; $stock->voucher_no = $sale->invoice_no; $stock->cost_amount = $line->total;
                    $stock->stockout = $line->quantity; $stock->company_id = $company->id; $stock->save();
                }
            });
        } catch (\InvalidArgumentException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
        return redirect('dashboard')->with('flash_message', 'SRB draft updated. Approve it from the Dashboard to submit.');
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
        $CompanyID = session()->get('company_id');
        try {
            $this->deleteInvoice($id, $CompanyID);
            Session::flash('flash_message', 'Sale Invoice deleted Successfully!');
        } catch (\Exception $e) {
            Session::flash('error_message', 'Error deleting invoice: ' . $e->getMessage());
        }
        return redirect()->back();
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || count($ids) === 0) {
            return response()->json(['message' => 'No ids provided.'], 422);
        }

        $CompanyID = session()->get('company_id');
        $deleted = 0;
        foreach ($ids as $id) {
            try {
                $this->deleteInvoice($id, $CompanyID);
                $deleted++;
            } catch (\Exception $e) {
                Log::error("Bulk delete failed for ID {$id}: " . $e->getMessage());
            }
        }

        return response()->json(['deleted' => $deleted]);
    }

    protected function deleteInvoice($id, $CompanyID)
    {
        DB::beginTransaction();
        try {
            $delete = SaleTax::where('id', $id)->where('company_id', $CompanyID)->firstOrFail();
            $company = Companies::find($CompanyID);
            if ($company && $company->system_type === 'SRB' && $delete->fbr_invoice_no) {
                throw new \RuntimeException('Submitted SRB invoices must be retained. Reconcile or process an SRB sales return; local deletion is not a cancellation.');
            }

            // 1. Delete Child Records FIRST
            SaleTaxDetails::where('sale_id', $id)->where('company_id', $CompanyID)->delete();
            RawMaterialStock::where('transction_id', $id)
                ->where('company_id', $CompanyID)
                ->where('type', 'SalesTax Invoice')
                ->delete();

            // 2. Delete Parent Record LAST
            $delete->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error deleting POS invoice ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }

    public function bulkApprove(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!is_array($ids) || count($ids) === 0) {
            return response()->json(['message' => 'No ids provided.'], 422);
        }

        $companyID = session()->get('company_id');
        $sellerCompany = Companies::find($companyID);
        if (!$sellerCompany) {
            return response()->json(['message' => 'Company not found.'], 404);
        }

        $results = [];

        foreach ($ids as $index => $id) {
            $result = $this->approveSinglePosInvoice($id, $companyID, $sellerCompany);
            if (($result['status'] ?? '') === 'debug') {
                return $result['dump'] ?? null;
            }
            $results[] = $result;
            
            // Add delay between bulk requests to avoid rate limiting (1 second)
            if ($index < count($ids) - 1) {
                usleep(1000000); // 1 second delay
            }
        }

        $successCount = collect($results)->where('status', 'success')->count();
        $failCount = collect($results)->where('status', '!=', 'success')->count();

        // Set session flash so index page shows a success message after reload
        if ($successCount > 0) {
            $linkLabel = in_array($sellerCompany->system_type ?? '', ['KPRA', 'SRB'], true) ? $sellerCompany->system_type : 'FBR';
            $message = $successCount . ' invoice(s) linked to ' . $linkLabel . ' successfully!';
            if ($failCount > 0) {
                $message .= ' (' . $failCount . ' failed)';
            }
            Session::flash('flash_message', $message);
        }

        return response()->json([
            'success' => $successCount,
            'failed' => $failCount,
            'results' => $results,
        ]);
    }

    protected function approveSinglePosInvoice($invoiceId, $companyID, $sellerCompany)
    {
        try {
            if ($sellerCompany->system_type === 'SRB') {
                $srb = app(SrbInvoiceSubmission::class)->submit($invoiceId, $sellerCompany);
                if (isset($srb['debug_mode'])) {
                    return [
                        'id' => $invoiceId,
                        'status' => 'debug',
                        'debug_mode' => (int) $srb['debug_mode'],
                        'dump' => $srb['debug_mode'] == 1 ? ($srb['raw'] ?? null) : ($srb['body'] ?? null),
                        'message' => $srb['message'] ?? 'Debug dump',
                    ];
                }
                return ['id' => $invoiceId, 'status' => $srb['ok'] ? 'success' : 'error',
                    'message' => $srb['message'], 'fbr_invoice_no' => $srb['id'] ?? null];
            }
            $sale = SaleTax::with(['saletax_details' => function ($query) {
                $query->with('products');
            }])
            ->where('id', $invoiceId)
            ->where('company_id', $companyID)
            ->first();

            if (!$sale) {
                return ['id' => $invoiceId, 'status' => 'error', 'message' => 'Invoice not found.'];
            }

            if (!empty($sale->fbr_invoice_no)) {
                $alreadyLabel = in_array($sellerCompany->system_type ?? '', ['KPRA', 'SRB'], true) ? $sellerCompany->system_type : 'FBR';
                return ['id' => $invoiceId, 'status' => 'skipped', 'message' => 'Already linked to ' . $alreadyLabel . '.', 'fbr_invoice_no' => $sale->fbr_invoice_no];
            }

            $party = Party::find($sale->party_id);
            if (!$party) {
                return ['id' => $invoiceId, 'status' => 'error', 'message' => 'Party not found.'];
            }

            if ($sellerCompany->system_type === 'KPRA') {
                $totalExTax = 0;
                $totalTaxValue = 0;
                $totalBillAmount = 0;
                $taxRateFirst = 0;
                foreach ($sale->saletax_details as $index => $detail) {
                    $totalExTax += (float) $detail->price;
                    $totalTaxValue += (float) $detail->taxvalue;
                    $totalBillAmount += (float) $detail->total;
                    if ($index === 0) {
                        $taxRateFirst = (float) $detail->stvalue;
                    }
                }
                $kpraPayload = KpraRimsClient::buildFromSale(
                    $sellerCompany,
                    $sale,
                    $totalExTax,
                    $totalTaxValue,
                    $taxRateFirst,
                    $totalBillAmount,
                    1
                );
                $kpra = KpraRimsClient::sendLiveInvoice($kpraPayload, (bool) ($sellerCompany->debug_mode ?? false));
                if ($this->shouldDumpAuthorityDebug($sellerCompany)) {
                    return [
                        'id' => $invoiceId,
                        'invoice_no' => $sale->invoice_no,
                        'status' => 'debug',
                        'debug_mode' => (int) $sellerCompany->debug_mode,
                        'dump' => $sellerCompany->debug_mode == 1
                            ? ($kpra['raw'] ?? null)
                            : ($kpra['body'] ?? (isset($kpra['raw']) ? json_decode($kpra['raw'], true) : null)),
                        'message' => 'Debug mode – KPRA response dump only; invoice not linked.',
                    ];
                }
                if (!$kpra['ok']) {
                    return [
                        'id' => $invoiceId,
                        'invoice_no' => $sale->invoice_no,
                        'status' => 'error',
                        'message' => $kpra['message'] ?? 'KPRA submission failed.',
                        'code' => 'KPRA_ERROR',
                    ];
                }
                $sale->fbr_invoice_no = $kpra['transaction_id'];
                $sale->save();
                return [
                    'id' => $invoiceId,
                    'invoice_no' => $sale->invoice_no,
                    'status' => 'success',
                    'message' => 'Linked to KPRA successfully.',
                    'fbr_invoice_no' => $kpra['transaction_id'],
                ];
            }

            $totalQty = 0;
            $totalSaleValue = 0;
            $totalTaxValue = 0;
            $totalBillAmount = 0;
            $totalFurtherTax = 0;
            $totalDiscount = 0;
            $items = [];

            foreach ($sale->saletax_details as $index => $detail) {
                $discountRate = $detail->discount ?? 0;
                $discountValue = $detail->discount_value ?? 0;

                $totalQty += (float) $detail->quantity;
                $totalSaleValue += (float) $detail->price;
                $totalTaxValue += (float) $detail->taxvalue;
                $totalBillAmount += (float) $detail->total;
                $totalFurtherTax += (float) ($detail->extraTaxValue ?? 0);
                $totalDiscount += (float) $discountValue;

                $itemCode = $index === 0
                    ? ($detail->products->product_code ?? $detail->product_id)
                    : 1;

                $items[] = [
                    "ItemCode" => $itemCode,
                    "ItemName" => $detail->products->product_name ?? '',
                    "Quantity" => (float) $detail->quantity,
                    "PCTCode" => "1",
                    "TaxRate" => (float) $detail->stvalue,
                    "SaleValue" => (float) $detail->price,
                    "TotalAmount" => (float) $detail->total,
                    "TaxCharged" => (float) $detail->taxvalue,
                    "Discount" => (float) $discountRate,
                    "FurtherTax" => (float) ($detail->extraTaxValue ?? 0),
                    "InvoiceType" => 1,
                    "RefUSIN" => null
                ];
            }

            $grandDiscount = $totalDiscount + (float) ($sale->discount_amount ?? 0);

            $payload = [
                "InvoiceNumber" => (string) $sale->invoice_no,
                "POSID" => (string) $sellerCompany->pos_id,
                "USIN" => (string) $sale->invoice_no,
                "DateTime" => (string) $sale->date,
                "BuyerNTN" => (string) $party->ntn,
                "BuyerCNIC" => (string) $party->cnic,
                "BuyerName" => (string) $party->party_name,
                "BuyerPhoneNumber" => (string) $party->phone,
                "items" => $items,
                "TotalBillAmount" => $totalBillAmount,
                "TotalQuantity" => $totalQty,
                "TotalSaleValue" => $totalSaleValue,
                "TotalTaxCharged" => $totalTaxValue,
                "FurtherTax" => $totalFurtherTax,
                "Discount" => $grandDiscount,
                "DiscountAmount" => $sale->discount_amount ?? 0,
                "PaymentMode" => 1,
                "RefUSIN" => null,
                "InvoiceType" => 1
            ];

            if ($sellerCompany->system_type == "POS") {
                $apiUrl = 'https://gw.fbr.gov.pk/imsp/v1/api/Live/PostData';
            } else {
                $apiUrl = 'https://ims.pral.com.pk/ims/production/api/Live/PostData';
            }

            $curl = curl_init();
            curl_setopt_array($curl, [
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
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer "' . $sellerCompany->token . '"',
                    'Content-Type: application/json'
                ],
            ]);

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            
            if ($response === false) {
                $errorMessage = curl_error($curl);
                curl_close($curl);
                \Log::error("FBR CURL Error for Invoice {$sale->invoice_no}", ['error' => $errorMessage]);
                return ['id' => $invoiceId, 'invoice_no' => $sale->invoice_no, 'status' => 'error', 'message' => 'CURL error: ' . $errorMessage, 'code' => 'CURL_ERROR'];
            }
            curl_close($curl);

            // Log the raw response for debugging
            \Log::info("FBR Response for Invoice {$sale->invoice_no}", [
                'http_code' => $httpCode,
                'response' => $response
            ]);

            $fbr = json_decode($response, true);
            
            // Check if FBR returned an error status
            if (isset($fbr['status']) && strtolower($fbr['status']) === 'error') {
                $errorMsg = $fbr['message'] ?? $fbr['error'] ?? 'Unknown FBR error';
                \Log::error("FBR Error for Invoice {$sale->invoice_no}", ['fbr_response' => $fbr]);
                return ['id' => $invoiceId, 'invoice_no' => $sale->invoice_no, 'status' => 'error', 'message' => $errorMsg, 'code' => 'FBR_ERROR'];
            }

            // Check for error field in response
            if (isset($fbr['error'])) {
                \Log::error("FBR Error for Invoice {$sale->invoice_no}", ['fbr_response' => $fbr]);
                return ['id' => $invoiceId, 'invoice_no' => $sale->invoice_no, 'status' => 'error', 'message' => $fbr['error'], 'code' => 'FBR_ERROR'];
            }

            $invoiceNumber = $fbr['InvoiceNumber'] ?? null;

            if (empty($invoiceNumber) || $invoiceNumber === "Not Available") {
                \Log::warning("FBR InvoiceNumber Not Available for Invoice {$sale->invoice_no}", ['fbr_response' => $fbr]);
                return ['id' => $invoiceId, 'invoice_no' => $sale->invoice_no, 'status' => 'error', 'message' => 'FBR portal is not available. Please try again later.', 'code' => 'FBR_UNAVAILABLE'];
            }

            $sale->fbr_invoice_no = $invoiceNumber;
            $sale->save();

            return [
                'id' => $invoiceId,
                'invoice_no' => $sale->invoice_no,
                'status' => 'success',
                'message' => 'Linked to FBR successfully.',
                'fbr_invoice_no' => $invoiceNumber,
            ];
        } catch (\Exception $e) {
            \Log::error("Exception for Invoice {$invoiceId}", ['exception' => $e->getMessage()]);
            return ['id' => $invoiceId, 'status' => 'error', 'message' => $e->getMessage(), 'code' => 'EXCEPTION'];
        }
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
        $company = Companies::where('id', $companyID)->first();
        $newsale_detail = SaleTax::with(['saletax_details' => function ($query) {
            $query->with('uoms');
            $query->with('products');
        }])->where('sale_taxes.id', '=', $id)
            ->get();
        $company_detail = Setting::where('id', '=', 1)->get();
        // $company_detail = User::where('id', '=',session()->get('company_id'))->get();
        $logo = SystemLogo::where('id', '=', 1)->get();
        if ($company->system_type === 'SRB') {
            abort_unless(isset($newsale_detail[0]) && (int) $newsale_detail[0]->company_id === (int) $companyID, 404);
            return view('salestax.pos.srb', compact('newsale_detail', 'company'));
        }
        if (session()->get('company_bill_type') == 'A4') {
            $discount = session()->get('company_discount');
            if($discount == 1){
            return view('salestax.pos.discount', compact('newsale_detail', 'company_detail', 'logo', 'id', 'company'));
            }
            return view('salestax.pos.a4', compact('newsale_detail', 'company_detail', 'logo', 'id', 'company'));
        }
        elseif (session()->get('company_bill_type') == 'Thermal2') {
            return view('salestax.pos.thermal2', compact('newsale_detail', 'company_detail', 'logo', 'id', 'company'));
        }
        else {
            $discount = session()->get('company_discount');
            if($discount == 1){
                return view('salestax.pos.thermal-discount', compact('newsale_detail', 'company_detail', 'logo', 'id', 'company'));
                }
            return view('salestax.pos.thermal', compact('newsale_detail', 'company_detail', 'logo', 'id', 'company'));
        }
    }


    public function emailInvoice(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $companyID = session()->get('company_id');
        $company = Companies::where('id', $companyID)->first();
        $newsale_detail = SaleTax::with(['saletax_details' => function ($query) {
            $query->with('uoms');
            $query->with('products');
        }])->with('parties')
            ->where('sale_taxes.id', '=', $id)
            ->where('company_id', $companyID)
            ->get();

        if ($newsale_detail->isEmpty()) {
            return response()->json(['message' => 'Invoice not found.'], 404);
        }

        $company_detail = Setting::where('id', '=', 1)->get();
        $logo = SystemLogo::where('id', '=', 1)->get();
        $showDiscount = session()->get('company_discount') == 1;
        $html = view($company->system_type === 'SRB' ? 'salestax.pos.srb' : 'salestax.pos.email-pdf', compact('newsale_detail', 'company_detail', 'logo', 'id', 'company', 'showDiscount'))->render();

        try {
            app(InvoicePdfMailer::class)->send(
                $request->email,
                $html,
                $newsale_detail[0]->invoice_no,
                $company ? $company->CompanyName : session()->get('company_name')
            );
        } catch (\Throwable $e) {
            \Log::error('POS invoice email failed: ' . $e->getMessage());
            return response()->json(['message' => 'Unable to send invoice. Please check mail settings.'], 500);
        }

        return response()->json(['message' => 'Invoice sent successfully.']);
    }

    public function downloadPdf($id)
    {
        $companyID = session()->get('company_id');
        $company = Companies::where('id', $companyID)->first();
        $newsale_detail = SaleTax::with(['saletax_details' => function ($query) {
            $query->with('uoms');
            $query->with('products');
        }])->with('parties')
            ->where('sale_taxes.id', '=', $id)
            ->where('company_id', $companyID)
            ->get();

        if ($newsale_detail->isEmpty()) {
            Session::flash('flash_error', 'Invoice not found.');
            return redirect('pos-salestax');
        }

        $company_detail = Setting::where('id', '=', 1)->get();
        $logo = SystemLogo::where('id', '=', 1)->get();
        $showDiscount = session()->get('company_discount') == 1;
        $html = view($company->system_type === 'SRB' ? 'salestax.pos.srb' : 'salestax.pos.email-pdf', compact('newsale_detail', 'company_detail', 'logo', 'id', 'company', 'showDiscount'))->render();

        return app(InvoicePdfMailer::class)->downloadResponse($html, $newsale_detail[0]->invoice_no);
    }

    public function print_pdf($id)
    {
        return $this->downloadPdf($id);
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
        
        
         $codes = CompanyInvoiceGuard::nextInvoiceNo(session()->get('company_id'));
        
        
        $settings = Setting::where('id', 1)->get();
        $salescate = AccountGroup::OrderBy('id', 'asc')->pluck('name', 'name');
        $cate = AccountGroup::all();
        $customers = Party::where('company_id', session()->get('company_id'))
            ->whereIn('account_group_id', [1, 7])
            ->orderBy('party_name', 'asc')
            ->pluck('party_name', 'id');
        $customers_address = Party::where('company_id', session()->get('company_id'))
            ->whereIn('account_group_id', [1, 7])
            ->orderBy('party_name', 'asc')
            ->first();
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
        
        $limitError = CompanyInvoiceGuard::monthlyLimitError(session()->get('company_id'), $request->date ?? date('Y-m-d'));
        if ($limitError) {
            Session::flash('error_message', $limitError);
            return redirect()->back()->withInput();
        }

        $codes = CompanyInvoiceGuard::nextInvoiceNo(session()->get('company_id'));
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

    /**
     * Same as SalesTaxController FBR DI: debug_mode 1/2 dumps API response and stops linking.
     */
    protected function shouldDumpAuthorityDebug($company): bool
    {
        return $company->debug_mode == 1 || $company->debug_mode == 2;
    }

    /**
     * debug_mode == 1 → raw response string; == 2 → decoded array/object.
     */
    protected function authorityDebugDump($company, $raw, $decoded)
    {
        if ($company->debug_mode == 1) {
            return $raw;
        }
        if ($company->debug_mode == 2) {
            return $decoded;
        }
        return null;
    }
}
