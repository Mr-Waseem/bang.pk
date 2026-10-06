<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Companies;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    // protected function authenticated($request, $user){
    //     if($user->status =='Admin'  && $user->type == 'ACTIVE'){
    //         return redirect('company');
    //     }
    //     else if($user->status =='company'  && $user->type == 'ACTIVE'){
    //         return redirect('/dashboard');
    //     }
    //     else if($user->status =='user'  && $user->type == 'ACTIVE'){
    //         return redirect('/dashboard');
    //     }
    //     else{
    //         return redirect('/login');
    //     }
    // }

    // protected function authenticated($request, $user)
    // {
    //     try {
    //         // Debugging - uncomment to check user data
    //         // \Log::info('Authentication attempt', ['user' => $user->toArray()]);
            
    //         if ($user->type !== 'ACTIVE') {
    //             Auth::logout();
    //             return redirect('/login')->withErrors([
    //                 'account' => 'Your account is not active. Please contact administrator.'
    //             ]);
    //         }

    //         switch ($user->status) {
    //             case 'Admin':
    //                 return redirect('company');
    //             case 'company':
    //             case 'user':
    //                 return redirect('/dashboard');
    //             default:
    //                 Auth::logout();
    //                 return redirect('/login')->withErrors([
    //                     'account' => 'Invalid user role. Please contact administrator.'
    //                 ]);
    //         }
    //     } catch (\Exception $e) {
    //         \Log::error('Authentication error: ' . $e->getMessage());
    //         Auth::logout();
    //         return redirect('/login')->withErrors([
    //             'system' => 'An error occurred during login. Please try again.'
    //         ]);
    //     }
    // }

    protected function authenticated($request, $user)
    {
        // users.type = ACTIVE/INACTIVE (account status); users.status = role
        if ($user->type !== 'ACTIVE') {
            Auth::logout();
            return redirect('/login')->with('error', 'Your account is not active. Please contact administrator.');
        }

        // company/user: block login when company is deactivated or expired
        if (in_array($user->status, ['company', 'user'], true) && !empty($user->company_id)) {
            $company = Companies::find($user->company_id);
            if ($company && (int) $company->is_active === 0) {
                Auth::logout();
                return redirect('/login')->with('error', 'Your company has been suspended. Please contact the administrator.');
            }
            if ($company && !empty($company->expire_date)) {
                $expireDate = Carbon::parse($company->expire_date)->startOfDay();
                if ($expireDate->lt(Carbon::today())) {
                    Auth::logout();
                    return redirect('/login')->with('error', 'Your company subscription has expired. Please contact administrator.');
                }
            }
        }

        switch ($user->status) {
            case 'Admin':
            case 'Partner':
                return redirect('company');
            case 'company':
            case 'user':
                return redirect('/dashboard');
            default:
                Auth::logout();
                return redirect('/login')->with('error', 'Invalid user role. Please contact administrator.');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout() {
        if (session()->has('company_id')) {
            session()->forget('company_id');
            session()->forget('company_name');
            // Session::flash('flash_message', 'Company Successfully Logout!');
            // return redirect('company');
        }
        Auth::logout();
        return redirect('/login');
    }
}
