<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountSettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $id = Auth::User()->id;
        // $edit = User::findOrFail($id);
        $edit = User::where('id', $id)->first();
        $user = DB::table('users')->where('id', $id)->get();
        //return $user;
        return view('account.edit', Compact('edit', 'user', 'id'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        // $edit = User::findOrFail($id);
        // $user = DB::table('users')->where('id', Auth::user()->id)->get();
        // //return $user;
        // return view('account.edit', Compact('edit', 'user', 'id'));
    }

    public function update(Request $request)
    {
        // return $request;
         $id = Auth::User()->id;
        if ($request->input('profile')) {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email'
            ]);
            $user = User::findOrFail($id);
            //return $user;
            if (!is_null($request->file('image'))) {
                $imageName = $request->file('image')->getClientOriginalName();
                $request->file('image')->move(
                    base_path() . '/upload/users/',
                    $imageName
                );
                // return base_path() . '/upload/users/'.$imageName;
                $user->update(array(
                    'image' => $imageName
                ));
            }
            $user->update(array(
                'name' => $request->get('name'),
                'email' => $request->get('email')
            ));
            $user->save();

            Session::flash('flash_message', 'Account successfully Updated!');
            return redirect('dashboard');
            //return redirect('account/'.$user->id.'/edit'); 
        } elseif ($request->input('PasswordSubmit')) {
            // return "ent";
            $this->validate($request, [
                'new_password' => 'required|min:6',
                'confirm_password' => 'required|same:new_password|min:6|different:old_password'
            ]);

            $currentPassword = $request->input("old_password");
            $NewPassword = $request->input("new_password");
            // return $NewPassword;
            $currentUser = User::findOrFail($id);

            if (Hash::check($currentPassword, $currentUser->password)) {
                $currentUser->fill([
                    'password' => Hash::make($NewPassword),
                    'show_password' => $NewPassword
                ])->save();

                Session::flash('flash_message', 'Password Changed successfully!');
                return redirect('dashboard');
            } else {
                Session::flash('flash_message', 'Current Password is Incorrect!');
                // return redirect('account/' . $currentUser->id . '/edit');
                return redirect('account');
            }
        }
    }

    public function destroy($id)
    {
        //
    }
}
