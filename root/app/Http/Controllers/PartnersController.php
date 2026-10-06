<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Session;
use Auth;
class PartnersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // $taxes = User::where('status', 'Partner')->OrderBy('id', 'asc')->get();
        // return view('partners.index', Compact('taxes'));

         $userID = Auth::User()->id;
        $admin = User::where('id', $userID)->first();
        if($admin->status == "Admin"){
        $taxes = User::where('status', 'Partner')->OrderBy('id', 'asc')->get();
        return view('partners.index', Compact('taxes'));
        }else{
        return redirect()->back()->with([
            'error' => 'Failed to Access Page.',
            'warning' => 'Please review your access.'
        ]);
        }
    }

    public function create()
    {
        return view('partners.create');
    }

    public function store(Request $request)
    {
        // return "d";
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'city' => 'required',
            'address' => 'required',
        ]);
        // $random8Digit = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        // $requestData = $request->all();
        // $requestData['partnercode'] = $random8Digit;
        $users = new User();
        $users->name = $request->name;
        $users->email = $request->email;
        $users->password = bcrypt($request->password);
        $users->show_password = $request->password;
        $users->company_id = session()->get('company_id') ?? null;
        $users->phone = $request->phone ?? null;
        $users->city = $request->city ?? null;
        $users->address = $request->address;
        $users->status = $request->status;
        $users->type = $request->type;
        // $users->shop_id=1;
        $users->biller_id = Auth::User()->id;
        $users->save();
        $users->roles()->attach(Role::where('name', 'Admin')->first());
        return redirect()->back()->with('success', 'Record created successfully.');
        Session::flash('flash_message', 'User Added Successfully!');
        return redirect('roles/create');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $edit = User::findOrFail($id);
        return view('partners.edit', Compact('edit'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'city' => 'required',
            'address' => 'required',
        ]);
        $update = User::findOrFail($id);
        $update->update($request->all());
        Session::flash('flash_message', 'Partner Updated Successfully!');
        return redirect('partners');
    }

    public function destroy($id)
    {
        $delete = User::findOrFail($id);
        $delete->delete();
        Session::flash('flash_message', 'Partner Deleted Successfully!');
        return redirect('partners');
        return "Partner Deleted Successfully!";
    }
}
