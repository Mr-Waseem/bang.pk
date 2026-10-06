<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Warehouse;
use App\Models\AccountGroup;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {
        $CurrentUser = User::where('id', Auth::User()->id)->first();
        if($CurrentUser->roles[0]->name == "Admin"){
        $users = User::where('company_id', session()->get('company_id'))->orderBy('id', 'asc')->get();
        return view('roles.index', Compact('users'));
        } else {
            Session::flash('flash_message', 'No are not an Admin. So you have insufficient permissions to access this page!');
            return redirect('dashboard');
        }

    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        // return "dd";
        $user = User::where('email', $request['email'])->first();
        $user->roles()->detach();

        if ($request['role_supervisor']) {
            $user->roles()->attach(Role::where('name', 'Supervisor')->first());
        }

        if ($request['role_center']) {
            $user->roles()->attach(Role::where('name', 'Center')->first());
        }

        if ($request['role_driver']) {
            $user->roles()->attach(Role::where('name', 'Driver')->first());
        }

        if ($request['role_editor']) {
            $user->roles()->attach(Role::where('name', 'Editor')->first());
        }
        if ($request['role_author']) {
            $user->roles()->attach(Role::where('name', 'Author')->first());
        }
        if ($request['role_admin']) {
            $user->roles()->attach(Role::where('name', 'Admin')->first());
        }
        return redirect()->back();
    }

    public function addUser(Request $request)
    {
        // return session()->get('company_id');
    //    return $request;
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);
        $users = new User();
        $users->name = $request->name;
        $users->email = $request->email;
        $users->password = bcrypt($request->password);
        $users->show_password = $request->password;
        $users->company_id = session()->get('company_id');
        $users->phone = $request->phone ?? null;
        $users->city = $request->city ?? null;
        $users->status = $request->status;
        $users->type = $request->type;
        // $users->shop_id=1;
        $users->biller_id = Auth::User()->id;
        $users->save();
        $users->roles()->attach(Role::where('name', 'Editor')->first());
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
        $shops = Warehouse::pluck('name', 'id')->toArray();
        return view('roles.edit', Compact('edit', 'shops'));
        // return $user;
    }

    public function update(Request $request, $id)
    {
        // return $request;
        // return session()->get('company_id');
        
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'show_password' => 'required',
        ]);

        $users = User::findOrFail($id);
        // $update->update($request->all());

        // $users = new User();
        $users->name = $request->name;
        $users->email = $request->email;
        $users->password = bcrypt($request->show_password);
        $users->show_password = $request->show_password;
        $users->company_id = session()->get('company_id');
        $users->status = $users->status;
        $users->type = $request->type;
        // $users->shop_id=1;
        $users->biller_id = Auth::User()->id;
        $users->save();


        Session::flash('flash_message', 'User Updated Successfully!');
        return redirect('roles');
    }

    public function destroy($id)
    {
        $delete = User::findOrFail($id);
        $delete->delete();
        Session::flash('flash_message', 'User Deleted Successfully!');
        return redirect()->back();
    }
}
