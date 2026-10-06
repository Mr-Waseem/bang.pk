<?php

namespace App\Http\Controllers;
use App\Models\Companies;
use App\Models\Party;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class CopyCustomerController extends Controller
{
        public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // $id = session()->get('company_id');
        $company = Companies::OrderBy('companyName', 'ASC')->pluck('companyName', 'id')->prepend('Select Company', '');
         $id = Auth::User()->id;

        $id = Auth::User()->id;
        // $edit = User::findOrFail($id);
        $user = DB::table('users')->where('id', $id)->get();
        //return $user;
        return view('copy-customer.index', Compact('company', 'user', 'id'));
    }

      public function store(Request $request)
    {
        // return $request;
         $id = Auth::User()->id;
        if ($request->input('parties')) {
            $this->validate($request, [
                'from_companyid' => 'required',
                'to_companyid' => 'required'
            ]);
            // return $request;

            // $id = session()->get('company_id');
            $parties = Party::where('company_id', $request->from_companyid)->get();
            foreach($parties as $party){
                $new_party = $party->replicate();
                $new_party->company_id = $request->to_companyid;
                $new_party->save();
            }
        

            Session::flash('flash_message', 'Parties successfully copied!');
            return redirect('copy-customer');
            //return redirect('account/'.$user->id.'/edit'); 
        } elseif ($request->input('products')) {
            // return $request;
              $this->validate($request, [
                'from_companyidp' => 'required',
                'to_companyidp' => 'required'
            ]);
            $products = Product::where('company_id', $request->from_companyidp)->get();
            foreach($products as $product){
                $new_party = $product->replicate();
                $new_party->company_id = $request->to_companyidp;
                $new_party->save();
            }
            Session::flash('flash_message', 'Products successfully copied!');
                return redirect('copy-customer');
        }
    }
}
