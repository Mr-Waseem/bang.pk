<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\FbrInvoice;
use App\Models\Clients;
use App\Models\Rating;
use App\Models\Setting;
use App\Models\Role;
use App\Models\SystemLogo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Auth;
class FbrInvoiceController extends Controller
{

    public function index()
    {
        $setting = Setting::first('profile');
        $logo = SystemLogo::first();
        $ratings = Rating::Orderby('id', 'desc')->get();
        $clients = Clients::Orderby('id', 'desc')->get();
        
        if($setting->profile == 0){
            Auth::logout();
            return redirect('/login');
        }else{
            return view('website.index', Compact('logo', 'ratings', 'clients'));
        }
        
    }

    public function publicPartner(Request $request){
        // return $request;
        try{
            $validated = $request->validate([
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
            $users->password = bcrypt($request->email);
            $users->show_password = $request->email;
            $users->company_id = session()->get('company_id') ?? null;
            $users->phone = $request->phone ?? null;
            $users->city = $request->city ?? null;
            $users->address = $request->address;
            $users->status = "Partner";
            $users->type = "INACTIVE";
            // $users->shop_id=1;
            $users->biller_id = 0;
            $users->save();
            $users->roles()->attach(Role::where('name', 'Editor')->first());
            return redirect()->back()->with('success', 'We’ve received your registration details. Thank you for your interest and our team will be in touch shortly.')->withFragment('registration');
            return redirect()->back()->with('success', 'Record created successfully.');
        }
        catch (ValidationException $e) {
            return "D";
            return redirect()
                   ->back()
                   ->withErrors($e->validator)
                   ->withFragment('registration')
                   ->withInput();
        }
 
        // Session::flash('flash_message', 'User Added Successfully!');
        // return redirect('roles/create');
    }

    public function faq()
    {
        return view('website.faq');
    }

    public function privacyPolicy()
    {
        return view('website.privacy-policy');
    }

    public function termsAndConditions()
    {
        return view('website.terms-and-conditions');
    }

    public function submitForm(Request $request)
    {
        $validatedData = $request->validate([
            'business_name' => 'required|string|max:255',
            'ntn_number' => 'required|string|max:50',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
        ]);
        // dd($validatedData);
        Mail::to('example@gmail.com')->send(new FbrInvoice($validatedData));

        return back()->with('success', 'Your registration for FBR Digital Invoicing has been submitted successfully!');
    }
}
