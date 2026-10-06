<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Party;
use App\Models\Setting;
use App\Models\AccountGroup;
use App\Models\Warehouse;
use App\Models\Banks;
use App\Models\GeneralVoucher;
use App\Models\Companies;
use App\Models\SaleTax;
use App\Models\PurchaseTax;
use Illuminate\Support\Facades\Session;
use PDF;
use Excel;
use App\Imports\CustomerPartyImport;
use Illuminate\Support\Facades\DB;

class PartyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function isPartyUsedInTransactions($id)
    {
        return GeneralVoucher::where('account_head_id', $id)
            ->orWhere('head_id', $id)
            ->exists()
            || SaleTax::where('party_id', $id)->exists()
            || PurchaseTax::where('party_id', $id)->exists();
    }

    public function index()
    {
        $party = Party::join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
            ->where('company_id', session()->get('company_id'))
            ->OrderBy('party_name', 'asc')
            ->get(['parties.*', 'account_groups.name']);

        return view('parties.index', Compact('party'));
    }

    public function createImportExcel()
    {
        return view('parties.importExcel.create');
    }


    public function ImportExcel(Request $request)
    {
        //return "d";
        $this->validate($request, [
            'import_file' => 'required'
        ]);

        $path1 = $request->file('import_file')->store('temp'); 
         $path = storage_path('app').'/'.$path1;  
        $data = Excel::import(new CustomerPartyImport, $path);
        // $data1 = Excel::import(new CustomerUserImport, $path,  $data);
        return redirect()->back()->with('flash_message', 'File Imported Successfully!');

        //   if($request->hasFile('import_file'))
        //     {
        //         $path = $request->file('import_file')->getRealPath();
        //         return $data= Excel::load($path, function($reader) {})->get();
        //         if(!empty($data) && $data->count())
        //         {
        //             foreach($data->toArray() as $key=>$value)
        //             {
        //                 if(!empty($value))
        //                 {
        //                     Employee::insert($value);
        //                 }
        //             }
        //         }
        //     }
        // $path = $request->file('import_file')->getRealPath();
        // return $results = Excel::load($path)->get();
        // //return $results;
        // if (!empty($results) && $results->count()) {
        //     $sum = 1;
        //     foreach ($results as $row) {
        //         //return $row->party_name;
        //         //foreach ($rows as $row) {
        //         $sum = $sum + 1;
        //         if (($row->party_name) != null) {
        //             Party::create([
        //                 'code'  => $sum,
        //                 'account_group_id'  => 1,
        //                 'shop_id'  => 1,
        //                 'account_type'  => "CUSTOMER",
        //                 'party_name'  => $row->party_name,
        //                 'phone'  => $row->phone,
        //                 'city'  => "LAHORE",
        //                 'address'  => $row->address,

        //             ]);
        //         }
        //         //}
        //     }
        // }

        Session::flash('flash_message', 'Parties Imported Successfully!');
        return redirect('parties/importExcel/create');
    }

    public function create()
    {
        //$AccountGroups = AccountGroup::OrderBy('name', 'asc')->pluck('name', 'id');
        $AccountGroups = AccountGroup::select(DB::raw('CONCAT(`id`, "_", `name`) AS `id`, `name`'))
            // ->where('code', '!=', 10)
            // ->where('code', '!=', 11)
            // ->where('code', '!=', 12)
            ->OrderBy('name', 'asc')
            ->pluck('name', 'id')
            ->toArray();
        // $Supplier = AccountGroup::where('milk_supplier', '=', 1)->select(DB::raw('CONCAT(`milk_supplier`, "_", `name`) AS `milk_supplier`, `name`'))->OrderBy('name', 'asc')->pluck('name', 'milk_supplier')->toArray();
        // $Supplier = AccountGroup::where('milk_supplier', '=', 1)->pluck('name', 'id')->toArray();
        $banks = Banks::pluck('name', 'id')->prepend('No Bank')->toArray();
        $shop = Warehouse:: //where('id', '!=', 1)->
            OrderBy('name', 'asc')->pluck('name', 'id')->prepend('Select Shop', '0')->toArray();
        //return $shop;
        $code = Party::where('company_id', session()->get('company_id'))
            ->OrderBy('id', 'desc')
            ->get();
        // return $code;

        $codes = 0;
        // $codes = (int)$code->last()->code + 1;
        if (count($code) > 0) {
            $codes = (int)$code[0]->code + 1;
        } else {
            $codes = 1;
        }

        $designations = array('Accountant' => 'Accountant', 'Admin' => 'Admin', 'Director' => 'Director', 'Labour' => 'Labour', 'Selling' => 'Selling');
        $status = array('BTL' => 'BTL', 'TAXABLE' => 'TAXABLE');
        $salary_status = array('DIRECT' => 'DIRECT', 'IN DIRECT' => 'IN DIRECT');
        $showstrn = Companies::where('id', session()->get('company_id'))->first('strn_show');

        $debtorGroup = AccountGroup::where('name', 'DEBTOR')->first();
        $defaultAccountShowId = $debtorGroup ? $debtorGroup->id . '_' . $debtorGroup->name : null;
        $defaultAccountGroupId = $debtorGroup?->id;
        $defaultAccountType = $debtorGroup?->name;

        return view('parties.create', Compact(
            'AccountGroups',
            'codes',
            'shop',
            'banks',
            'designations',
            'status',
            'salary_status',
            'showstrn',
            'defaultAccountShowId',
            'defaultAccountGroupId',
            'defaultAccountType'
        ));
    }

    public function store(Request $request)
    {
         //return $request->all();
        $this->validate($request, [
            'code' => 'required',
            'party_name' => 'required',
            'account_type' => 'required',
            'ntn' => 'required',
            'address' => 'required',
            // 'ntn' => 'unique:parties',
            // 'strn' => 'unique:parties',
        ]);
        Party::create($request->all());
        Session::flash('flash_message', 'Account added Successfully!');
        return redirect('parties/create');
    }

    public function show($id)
    {
        $party = Party::with(['party' => function ($query) {
            $query->with('products');
        }])
            ->where('id', '=', $id)
            ->where('company_id', session()->get('company_id'))
            ->OrderBy('party_name', 'asc')
            ->get();
        $company_detail = Setting::where('id', '=', 1)->get();
        //return $party;
        return view('parties.details', Compact('party', 'company_detail'));
    }

    public function edit($id)
    {
        $edit = Party::findOrFail($id);
        //return $edit;
        //$AccountGroups = AccountGroup::OrderBy('name', 'asc')->pluck('name', 'id');
        $AccountGroups = AccountGroup::select(DB::raw('CONCAT(`id`, "_", `name`) AS `id`, `name`'))
            ->where('code', '!=', 10)
            ->where('code', '!=', 11)
            ->where('code', '!=', 12)
            ->OrderBy('name', 'asc')
            ->pluck('name', 'id')
            ->prepend('Select Account')
            ->toArray();
        $shop = Warehouse:: //where('id', '!=', 1)->
            OrderBy('name', 'asc')->pluck('name', 'id')->toArray();
        $banks = Banks::pluck('name', 'id')->prepend('No Bank')->toArray();
        // $Supplier = AccountGroup::where('milk_supplier', '=', 1)->pluck('name', 'id')->toArray();

        $designations = array('Accountant' => 'Accountant', 'Admin' => 'Admin', 'Director' => 'Director', 'Labour' => 'Labour', 'Selling' => 'Selling');
        $status = array('BTL' => 'BTL', 'TAXABLE' => 'TAXABLE');
        $salary_status = array('DIRECT' => 'DIRECT', 'IN DIRECT' => 'IN DIRECT');
        $showstrn = Companies::where('id', session()->get('company_id'))->first('strn_show');
        return view('parties.edit', Compact('edit', 'AccountGroups', 'shop', 'banks', 'designations', 'status', 'salary_status', 'showstrn'));
    }

    public function update(Request $request, $id)
    {
        // return $request;
        $this->validate($request, [
            'code' => 'required',
            'party_name' => 'required',
            'account_type' => 'required',
            'ntn' => 'required',
            'address' => 'required',
            // 'ntn' => 'unique:parties',
            // 'strn' => 'unique:parties',
        ]);
        $update = Party::findOrFail($id);
        $update->update($request->all());
        Session::flash('flash_message', 'Account Updated Successfully!');
        return redirect('parties');
    }

    public function destroy($id)
    {
        if ($this->isPartyUsedInTransactions($id)) {
            Session::flash('flash_error', "You can't delete this party because it is used in invoice or voucher entries.");
            return redirect('parties');
        }

        $delete = Party::findOrFail($id);
        $delete->delete();
        Session::flash('flash_message', 'Account deleted Successfully!');
        return redirect('parties');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->ids;
        if (empty($ids)) {
            Session::flash('flash_error', 'No parties selected for deletion.');
            return redirect('parties');
        }

        $usedParties = [];
        $deletedCount = 0;

        foreach ($ids as $id) {
            if ($this->isPartyUsedInTransactions($id)) {
                $party = Party::find($id);
                $usedParties[] = $party ? $party->party_name : "ID: $id";
            } else {
                $party = Party::find($id);
                if ($party) {
                    $party->delete();
                    $deletedCount++;
                }
            }
        }

        if (count($usedParties) > 0) {
            $message = "Deleted $deletedCount parties. The following parties could not be deleted because they are used in invoices/vouchers: " . implode(', ', $usedParties);
            Session::flash('flash_error', $message);
        } else {
            Session::flash('flash_message', "$deletedCount parties deleted successfully!");
        }

        return redirect('parties');
    }

    public function print_parties()
    {
        $party = Party::join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
            ->where('company_id', session()->get('company_id'))
            ->OrderBy('party_name', 'asc')
            ->get(['parties.*', 'account_groups.name']);
        $company_detail = Setting::where('id', '=', 1)->get();
        return view('parties.print', Compact('party', 'company_detail'));
    }

    public function print_customers()
    {
        $party = Party::join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
            ->where('company_id', session()->get('company_id'))
            ->where('account_type', 'DEBTOR')
            ->OrderBy('party_name', 'asc')
            ->get(['parties.*', 'account_groups.name']);
        $company_detail = Setting::where('id', '=', 1)->get();
        return view('parties.print', Compact('party', 'company_detail'));
    }

        public function print_suppliers()
    {
        $party = Party::join('account_groups', 'account_groups.id', '=', 'parties.account_group_id')
            ->where('company_id', session()->get('company_id'))
            ->where('account_type', 'CREDITOR')
            ->OrderBy('party_name', 'asc')
            ->get(['parties.*', 'account_groups.name']);
        $company_detail = Setting::where('id', '=', 1)->get();
        return view('parties.print', Compact('party', 'company_detail'));
    }

    public function getPDF()
    {
        $parties = Party::where('company_id', session()->get('company_id'))
            ->OrderBy('party_name', 'asc')
            ->get();
        $company_detail = Setting::where('id', '=', 1)->get();
        $pdf = PDF::loadView('parties.partypdf', ['parties' => $parties, 'company_detail' => $company_detail]);
        return $pdf->download('parties.pdf');
    }

    public function getExcel()
    {
        $data = Party::where('company_id', session()->get('company_id'))
            ->OrderBy('party_name', 'asc')
            ->get(['parties.id', 'parties.party_name', 'parties.phone', 'parties.ntn', 'parties.strn', 'parties.city', 'parties.address'])->toArray();
        return Excel::create('parties', function ($excel) use ($data) {
            $excel->sheet('mySheet', function ($sheet) use ($data) {
                $sheet->fromArray($data);
            });
        })->download();
    }
}
