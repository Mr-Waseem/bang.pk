<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Companies;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DeveloperModeController extends Controller
{
       public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $id = session()->get('company_id');
        $company = Companies::where('id', $id)->first();
        // $edit = User::findOrFail($id);
        // $edit = User::where('company_id', $id)->first();
        return view('account.developer-mode', Compact('id', 'company'));
    }

    public function update(Request $request)
    {
        // return $request;
            $this->validate($request, [
                'debug_mode' => 'required',
            ]);
            $company = Companies::where('id', $request->id)->first();
            //return $user;
            $company->debug_mode = $request->debug_mode;
            $company->save();
            // $company->update(array(
            //     'debug_mode' => $request->debug_mode
            // ));
            // $company->save();

            Session::flash('flash_message', 'Debug successfully Updated!');
            return redirect('developer-mode');
            //return redirect('account/'.$user->id.'/edit'); 
        
    }
}
