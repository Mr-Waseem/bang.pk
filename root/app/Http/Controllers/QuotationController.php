<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Tax;
use App\Models\Party;
use App\Models\Discount;
use App\Models\Quotation;
use App\Models\QuotationDetails;
use App\Models\Setting;
use App\Models\DeliveryChallan;
use App\Models\GeneralVoucher;
use App\Models\Sales;
use App\Models\SystemLogo;
use App\Models\UOM;
use App\Models\Warehouse;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use PDF;
use Illuminate\Support\Facades\Session;

class QuotationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $sales = Quotation::OrderBy('id', 'desc')->with('parties')->with('quotation_details')->with('billers')->get();
        return view('quotation.index', Compact('sales'));
    }

    public function create()
    {
        $code = Quotation::OrderBy('id', 'asc')->get();
        if (count($code) > 0) {
            $codes = (int)$code->last()->vr_no + 1;
        } else {
            $codes = 1;
        }

        $DeliveryChallan = DeliveryChallan::where('status', '=', 'Pending')->OrderBy('vr_no', 'asc')->pluck('vr_no', 'vr_no')->prepend('Select Challan', '0')->toArray();
        // return $DeliveryChallan;
        $products = Product::select(DB::raw('CONCAT(`id`, "_", `product_name`) AS `id`, `product_name`'))
            ->where('company_id', session()->get('company_id'))
            ->OrderBy('id', 'asc')
            ->pluck('product_name', 'id')
            ->prepend('Select Product', '0')
            ->toArray();
        $taxes = Tax::select(DB::raw('CONCAT(`id`, "_", `tax_rate`) AS `tax_rate`, `tax_title`'))->OrderBy('id', 'asc')->pluck('tax_title', 'tax_rate')->toArray();
        $discounts = Discount::select(DB::raw('CONCAT(`id`, "_", `discount`) AS `discount`, `title`'))->OrderBy('id', 'asc')->pluck('title', 'discount')->toArray();
        //$discounts = Discount::OrderBy('id', 'asc')->pluck('title', 'id')->prepend('Select Discount', '0')->toArray();
        $customers = Party::join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
            ->where('parties.account_group_id', '=', '1')
            ->where('parties.company_id', session()->get('company_id'))
            // ->Orwhere('parties.account_group_id', '=', '7')
            ->OrderBy('party_name', 'asc')->pluck('party_name', 'parties.id')->prepend('Cash Customer', '1');
        //return $customers;
        $uoms = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))->OrderBy('id', 'asc')->pluck('uom', 'id')->prepend('PCS', '2_PCS')->toArray();
        //return $uoms;
        $users = User::pluck('name', 'name')->toArray();
        $warehouse = Warehouse::OrderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        //return $products;
        return view('quotation.create', Compact('customers', 'products', 'codes', 'taxes', 'discounts', 'DeliveryChallan', 'encrypted_token', 'uoms', 'warehouse', 'users'));
    }

    public function store(Request $request)
    {
        //return $request->all();
        $quotation = Quotation::create($request->all());
        //return $quotation->id;
        $count = Count($request->product_id);
        //return $ProductID; 

        for ($i = 0; $i < $count; $i++) {
            $detail = new QuotationDetails();
            $detail->quotation_id = $quotation['id'];
            $detail->product_id = $request->product_id[$i];
            $detail->uom_id = $request->uom_id[$i];
            $detail->description = $request->description[$i];
            $detail->rate = $request->rate[$i];
            $detail->gst = $request->gst[$i];
            $detail->amount = $request->amount[$i];
            $detail->save();
        }

        Session::flash('flash_message', 'Record successfully added!');
        return redirect('quotation/create');
    }

    public function show($id)
    {
        $newsale_detail = Sales::with(['sale_details' => function ($query) {
            $query->with('products');
            //$query->with('taxes');
            //$query->with('discount');
            $query->with('parties');
        }])->with('billers')
            ->where('sales.id', '=', $id)
            ->where('sales.company_id', session()->get('company_id'))
            ->get();
        $company_detail = Setting::where('id', '=', 1)->get();
        //return $newsale_detail;
        return view('sales.details', Compact('newsale_detail', 'company_detail'));
    }

    public function edit($id)
    {
        $purchase = Quotation::with(['quotation_details' => function ($query) {
            $query->with('products');
            $query->with('uoms');
        }])->with('parties')->where('quotations.id', '=', $id)->get();
        //return $purchase;
        $edit = $purchase[0];
        //return $edit;
        $products = Product::select(DB::raw('CONCAT(`id`, "_", `product_name`) AS `id`, `product_name`'))
            ->OrderBy('id', 'asc')
            ->where('company_id', session()->get('company_id'))
            ->pluck('product_name', 'id')
            ->prepend('Select Product', '0')
            ->toArray();
        $customers = Party::OrderBy('party_name', 'asc')
            ->where('company_id', session()->get('company_id'))
            ->pluck('Party_name', 'id')
            ->prepend('Select Customer', '0')
            ->toArray();
        $customers = Party::join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
            ->where('parties.account_group_id', '=', '1')
            ->where('parties.company_id', session()->get('company_id'))
            ->Orwhere('parties.account_group_id', '=', '8')
            ->OrderBy('party_name', 'asc')->pluck('party_name', 'parties.id');
        $uoms = UOM::select(DB::raw('CONCAT(`id`, "_", `uom`) AS `id`, `uom`'))->OrderBy('id', 'asc')->pluck('uom', 'id')->toArray();
        $users = User::pluck('name', 'name')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('quotation.edit', Compact('edit', 'products', 'customers', 'encrypted_token', 'uoms', 'users'));
    }

    public function update(Request $request, $id)
    {
        //return $request->all();
        $quotation = Quotation::findOrFail($id);

        $quotation->update(array(
            'vr_no' => $request->get('vr_no'),
            'from_date' => $request->get('from_date'),
            'to_date'  => $request->get('to_date'),
            'account_id' => $request->get('account_id'),
            'reference' => $request->get('reference'),
            'best_prices' => $request->get('best_prices'),
            'note' => $request->get('note'),
            'best_regards' => $request->get('best_regards'),
            'biller' => $request->get('biller')
        ));
        $quotation->save();

        // $quotation->vr_no = $quotation['vr_no'];
        // $quotation->from_date = $quotation['from_date'];
        // $quotation->to_date = $quotation['to_date'];
        // $quotation->account_id = $quotation['account_id'];
        // $quotation->reference = $quotation['reference'];
        // $quotation->best_prices = $quotation['best_prices'];
        // $quotation->note = $quotation['note'];
        // $quotation->best_regards = $quotation['best_regards'];
        // $quotation->biller = $quotation['biller'];
        // $quotation->save();

        QuotationDetails::where('quotation_id', '=', $id)->delete();
        $count = Count($request->product_id);
        //return $ProductID; 

        for ($i = 0; $i < $count; $i++) {
            $detail = new QuotationDetails();
            $detail->quotation_id = $quotation['id'];
            $detail->product_id = $request->product_id[$i];
            $detail->uom_id = $request->uom_id[$i];
            $detail->description = $request->description[$i];
            $detail->rate = $request->rate[$i];
            $detail->gst = $request->gst[$i];
            $detail->amount = $request->amount[$i];
            $detail->save();
        }

        Session::flash('flash_message', 'Record successfully Updated!');
        return redirect('quotation');
    }

    public function destroy($id)
    {
        $delete = Quotation::findOrFail($id);
        $delete->delete();
        QuotationDetails::where('quotation_id', '=', $id)->delete();
        return "Quotation has been Deleted Successfully!";
    }


    public function FirstProduct(Request $request)
    {
        $productId = $request->get('saletab_id');
        $productArray = Product::where('product_code', '=', $productId)->get(['products.*']);
        return $productArray;
    }

    public function getProduct(Request $request)
    {
        $productCode = $request->get('code_id');
        $data = Product::join('purchase_details', 'purchase_details.product_id', '=', 'products.id')
            ->where('product_code', '=', $productCode)
            ->where('remaining_quantity', '!=', 0)
            ->OrderBy('purchase_details.id', 'asc')
            ->first(['products.*', 'purchase_details.remaining_quantity', 'purchase_details.unit_cost', 'purchase_details.total_cost']);
        //->first();
        $test[] = $data;;
        return $test;
    }

    public function ProductChange(Request $request)
    {
        $productID = $request->get('prodID');
        $test = Product::where('id', '=', $productID)->get(['products.*']);
        //        $data = Product::join('purchase_details', 'purchase_details.product_id', '=', 'products.id')
        //   ->where('products.id', '=', $productID)
        //   ->where('remaining_quantity', '!=', 0)
        //   ->OrderBy('purchase_details.id', 'asc')
        //   ->first(['products.*','purchase_details.remaining_quantity', 'purchase_details.unit_cost', 'purchase_details.total_cost']);
        // $test[] = $data;
        return $test;
    }

    public function PartyChange(Request $request)
    {
        $partyname = $request->get('party_id');
        $data = Party::where('id', '=', $partyname)->get();
        return $data;
    }

    public function print_quotation($id)
    {
        $newsale_detail = Quotation::with(['quotation_details' => function ($query) {
            $query->with('uoms');
            $query->with(['products' => function ($query) {
                $query->with('publishers');
            }]);
            //$query->with('publishers');
        }])->with('parties')->with('billers')
            ->where('quotations.id', '=', $id)
            ->get();
        //return $newsale_detail;
        //return $id;

        $ledgers = GeneralVoucher::where('account_head_id', '=', $newsale_detail[0]->parties->id)
            ->where('company_id', session()->get('company_id'))
            ->get();
        //return $ledgers;
        $logo = SystemLogo::where('id', '=', 1)->get();
        $company_detail = Setting::where('id', '=', 1)->get();


        return view('quotation.print', Compact('newsale_detail', 'company_detail', 'ledgers', 'logo', 'ledgers'));
    }

    public function getQuotationPDF($id)
    {
        $newsale_detail = Quotation::with(['quotation_details' => function ($query) {
            $query->with('uoms');
            $query->with(['products' => function ($query) {
                //$query->with('publishers');
            }]);
            //$query->with('taxes');

            //$query->with('ledger');
            //$query->with('publishers');
        }])->with('parties')->with('billers')
            ->where('quotations.id', '=', $id)
            ->paginate(1);
        //->get();
        //$newsale_detail = $dos->chunk(20);
        //$newsale_detail = $data[0];
        //return $newsale_detail;
        $company_detail = Setting::where('id', '=', 1)->get();
        $pdf = PDF::loadView('quotation.printpdf', ['newsale_detail' => $newsale_detail, 'company_detail' => $company_detail]);
        //$pdf = PDF::loadView('sales.printpdf', compact('newsale_detail','company_detail'))->setPaper('A4')->stream();
        return $pdf->download('itlife-quotation.pdf');
    }

    public function quotationindex()
    {
        $Heads = Party::OrderBy('party_name', 'asc')->where('company_id', session()->get('company_id'))->pluck('party_name', 'id')->prepend('Select Account', '')->toArray();
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('quotation-report.index', Compact('encrypted_token', 'Heads'));
    }

    public function quotationfind(Request $request)
    {
        $this->validate($request, [
            'head_id' => 'required',
            'from_date' => 'required',
            'to_date' => 'required'
        ]);
        $HeadID = $request->get('head_id');
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        $quotations = Quotation::with('parties')->with(['quotation_details' => function ($query) {
            $query->with('products');
        }])->orderBy('created_at', 'asc')
            ->whereBetween('quotations.created_at', [$fromDate, $toDate])
            ->get();
        //return $quotations;
        $company_detail = Setting::where('id', '=', 1)->get();
        $party = Party::where('id', '=', $HeadID)->where('company_id', session()->get('company_id'))->get();
        return view('quotation-report.report', Compact('quotations', 'company_detail', 'party'));
    }
}
