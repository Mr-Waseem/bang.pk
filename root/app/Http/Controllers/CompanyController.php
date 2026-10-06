<?php

namespace App\Http\Controllers;

use App\Models\SaleTypes;
use App\Models\Companies;
use App\Models\Setting;
use App\Models\Scenario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\Warehouse;
use App\Models\AccountGroup;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    { 
        
    
        $loginuser = User::where('id', Auth::User()->id)->first();
        // return $loginuser;

        //  $this->LogoutCompany();
        //   return Auth::User()->status;

        // session()->forget('company_id');
        //     session()->forget('company_name');
        //     return "ddd";
        // return Auth::User()->status;
        //  return redirect('/logout');
       
        if (Auth::User()->status == "company") {
            // return Auth::User()->name;
           return $this->AssignCompany(Auth::User()->company_id);
        }
        if (Auth::User()->status == "user") {
            return $this->AssignCompany(Auth::User()->company_id); 
        }

        // if (!session()->has('company_id')) {
            
        if(Auth::User()->status == "Admin") {
             //return "not session";
             $data = Companies::OrderBy('id', 'desc')->with(['user' => function($que){
                $que->where('status', 'company');
            }])->get();
            return view('companies.index', compact('data', 'loginuser'));
        } 
        elseif(Auth::User()->status == "Partner") {
            //return "not session";
            $data = Companies::OrderBy('id', 'asc')->with(['user' => function($que){
               $que->where('status', 'company');
           }])
           ->where('partner_id', $loginuser->id)
           ->get();
           return view('companies.index', compact('data', 'loginuser'));
       }
        else {
            return redirect('/');
        }
    }

    public function AssignCompany($id)
    {
        //  return $id;
         $data = Companies::findOrFail($id);
        //  return $data->id;
        session()->put('company_id', $data->id);
        session()->put('company_name', $data->CompanyName);
        session()->put('company_address', $data->address);
        session()->put('company_phone', $data->phone);
        session()->put('company_status', $data->status);
        session()->put('company_ntn', $data->ntn);
        session()->put('company_strn', $data->strn);
        session()->put('company_ntn_show', $data->ntn_show);
        session()->put('company_strn_show', $data->strn_show);
        session()->put('company_type', $data->type);
        session()->put('company_bill_type', $data->bill_type);
        session()->put('company_pos_id', $data->pos_id);
        session()->put('company_token', $data->token);
        session()->put('system_type', $data->system_type);
        
        return redirect('dashboard');
    }

    public function create()
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }
        // return Auth::User()->id;
  
         $shops = Warehouse::pluck('name', 'id')->toArray();
         $saletypes = SaleTypes::pluck('name', 'id')->toArray();
         $Scenario = Scenario::Orderby('name', 'asc')->pluck('name', 'name');
         
        // $location = AccountGroup::where('milk_supplier', '=', 1)->pluck('name', 'id')->prepend('Select Supplier Location', '')->toArray();
         $currentlogin = User::where('id', Auth::User()->id)->first();
        if($currentlogin->status == "Partner"){
             $partners = User::where('id', $currentlogin->id)->Orderby('name', 'asc')->pluck('name', 'id');
            // return view('companies.partner-create', compact('shops', 'saletypes', 'Scenario', 'partners'));  
           
        }else{
            $partners = User::where('status', 'Partner')->Orderby('name', 'asc')->pluck('name', 'id');
            // return view('companies.create', compact('shops', 'saletypes', 'Scenario', 'partners')); 
        }
        return view('companies.create', compact('shops', 'saletypes', 'Scenario', 'partners')); 
        
    }

    public function store(Request $request)
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }
        //  return $request;
        $this->validate($request, [
            'CompanyName' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'ntn' => 'required',
            'scenario' => ($request->system_type === 'SRB' ? 'nullable' : 'required'),
            'pos_id' => ($request->system_type === 'KPRA' ? 'required' : 'nullable'),
            'token' => ($request->system_type === 'KPRA' ? 'required' : 'nullable'),
        ]);
        $company = new Companies();
        $company->CompanyName = $request->CompanyName;
        $company->phone = $request->phone;
        $company->category = $request->category;
        $company->system_type = $request->system_type;
        $company->address = $request->address;
        $company->province = $request->province;
        $company->status = $request->status;
        $company->ntn = $request->ntn;
        $company->strn = $request->strn;
        $company->pos_id = $request->pos_id;
        $company->type = $request->Businesstype;
        $company->bill_type = $request->bill_type;
        $company->ntn_show = $request->ntn_show;
        $company->strn_show = $request->strn_show;
        $company->sandbox_token = $request->sandbox_token;
        $company->token = $request->token;
        $company->footer_show = "Yes";
        $company->discount = $request->discount;
        $company->discount2 = $request->discount2;
        $company->discount_fixed = $request->discount_fixed;
        $company->discount_fixed2 = $request->discount_fixed2;
        $company->invoiceno_prefix = $request->invoiceno_prefix;
        $company->invoice_qrcode = $request->invoice_qrcode;
        $company->invoice_serial = $request->invoice_serial;
        $company->approval = $request->approval;
        $company->extra_tax = $request->extra_tax;
        $company->start_date = $request->start_date;
        $company->expire_date = $request->expire_date;
        $company->client_payment = $request->client_payment;
        $company->payment_terms = $request->payment_terms;
        $company->invoice_type = $request->invoice_type;
        $company->number_of_invoices = $request->number_of_invoices;
        $company->partner_id = $request->partner_id;
        $company->st_held = $request->st_held;
        $company->fed_payable = $request->fed_payable;
        $company->contact_person = $request->contact_person;
        $company->contact_person_phone = $request->contact_person_phone;
        $company->contact_person_email = $request->contact_person_email;
        $company->contact_person_address = $request->contact_person_address;
        $company->is_active = $request->input('is_active', 1);
        $this->applySrbSettings($request, $company);
        $company->save();


        $users = new User();
        $users->name = $request->name;
        // $users->username = $request->username;
        $users->email = $request->email;
        $users->password = bcrypt($request->password);
        $users->show_password = $request->password;
        $users->company_id = $company->id;
        // $users->shop_id=1;
        // $users->biller_id = Auth::User()->id;
        $users->status = "company";
        $users->type = $request->input('type', 'ACTIVE');
        $users->save();
        $users->roles()->attach(Role::where('name', 'Admin')->first());
        // $users->roles()->attach(Role::where('name', 'Editor')->first());
      
        if (isset($request->scenario)) {
            if (count($request->scenario) > 0) {
                $arr = array();
                foreach ($request->scenario as $size) {
                    $arr[] = array('scenario' => $size);
                }
                $company->scenario = json_encode($arr);
                $company->save();
            }
        }

        Session::flash('flash_message', 'Company Added Successfully!');
        return redirect('company');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }
        session()->put('comp_id', $id);
        // session()->put('company_pos_id');
        //return session()->get('comp_id');
        // return Auth::User()->id;
        // $edit = Companies::findOrFail($id);
         $edit = Companies::findOrFail($id);
        //  return $edit;
         $user = User::where('company_id', $edit->id)
         ->where('status', 'company')->first();
        // $decrypt= decrypt($edit->password);
        // $decrypt= Crypt::decrypt($edit->password);
       
     
        // return $decrypt;
        // $pos=User::pluck('password');
        // return $pos;
        // $Scenario = Scenario::pluck('name', 'name')->prepend('Select Scenario', '');
        $shops = Warehouse::pluck('name', 'id')->toArray();
        $saletypes = SaleTypes::pluck('name', 'id')->toArray();
        $Scenario = Scenario::Orderby('name', 'asc')->pluck('name', 'name');
        // $partners = User::where('status', 'Partner')->Orderby('name', 'asc')->pluck('name', 'id');
        $currentlogin = User::where('id', Auth::User()->id)->first();
        if($currentlogin->status == "Partner"){
            $partners = User::where('id', $currentlogin->id)->Orderby('name', 'asc')->pluck('name', 'id');
           // return view('companies.partner-create', compact('shops', 'saletypes', 'Scenario', 'partners'));  
          
       }else{
           $partners = User::where('status', 'Partner')->Orderby('name', 'asc')->pluck('name', 'id');
           // return view('companies.create', compact('shops', 'saletypes', 'Scenario', 'partners')); 
       }
        return view('companies.edit', compact('edit', 'saletypes', 'user', 'Scenario', 'partners'));
    }

    public function update(Request $request, $id)
    {
        if ($redirect = $this->ensureAdmin()) {
            return $redirect;
        }
        //  return $request;
        $this->validate($request,[
            'pos_id' => ($request->system_type === 'KPRA' ? 'required' : 'nullable'),
            'token' => ($request->system_type === 'KPRA' ? 'required' : 'nullable'),
            'ntn' => ($request->system_type === 'KPRA' ? 'required' : 'nullable'),
        ]);
        // $edit = Companies::findOrFail($id);
        // $edit->update($request->all());

        // Session::flash('flash_message', 'Company Updated Successfully!');
        // return redirect('company');
        // $this->validate($request, [
        //     'name' => 'required',
        //     'email' => 'required'
        // ]);

        $update = Companies::findOrFail($id);
        $this->applySrbSettings($request, $update);
        // $update->update($request->session()->put('company_pos_id'));
        $update->update($request->all());
        $update->system_type = $request->system_type;
        // return $update;
        // $update->password = bcrypt($request->get('password'));
        // $update->password = $request->get('password');
        $update->type = $request->Businesstype;
        $update->is_active = $request->input('is_active', $update->is_active ?? 1);
        $update->save();

        if (isset($request->scenario)) {
            if (count($request->scenario) > 0) {
                $arr = array();
                foreach ($request->scenario as $size) {
                    $arr[] = array('scenario' => $size);
                }
                $update->scenario = json_encode($arr);
                $update->save();
            }
        }
        Session::flash('flash_message', 'Company Updated Successfully!');
        
        return redirect('company');
    }

    public function destroy($id)
    {
        User::where('company_id', $id)->delete();
        //    return $del;
        $delete = Companies::findOrFail($id);
        // return $delete;
        $delete->delete();
        Session::flash('flash_message', 'Company Deleted Successfully!');
        return redirect()->back();
    }

    private function applySrbSettings(Request $request, Companies $company): void
    {
        if ($request->system_type !== 'SRB') {
            return;
        }
        $request->validate([
            'pos_id' => 'required|integer|min:1',
            'ntn' => ['required', 'regex:/^S?\d{7}(-\d)?$/i'],
            'CompanyName' => 'required|string|max:255',
            'invoice_type' => 'required|in:SandBox,Live',
            'token' => 'required|string|max:255',
            'sandbox_token' => 'required|string|max:255',
        ]);
    }

    private function ensureAdmin()
    {
        if (!Auth::user() || Auth::user()->status !== 'Admin') {
            return redirect('dashboard');
        }

        return null;
    }



    public function LogoutCompany()
    {

        if (session()->has('company_id')) {
            session()->forget('company_id');
            session()->forget('company_name');
            Session::flash('flash_message', 'Company Successfully Logout!');
            return redirect('company');
        } else {
            return response("Insufficient Permissions. Go Back!", 401);
        }
    }
}
