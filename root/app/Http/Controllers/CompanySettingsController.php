<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Companies;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CompanySettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $id = session()->get('company_id');
        $company = Companies::where('id', $id)->first();
        if (!$company) {
            Session::flash('flash_error', 'Company not found.');
            return redirect('dashboard');
        }

        return view('account.company-settings', compact('id', 'company'));
    }

    public function update(Request $request, $id = null)
    {
        $request->validate([
            'CompanyName' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'ntn' => 'nullable|string|max:50',
            'strn' => 'nullable|string|max:50',
            'province' => 'nullable|string|max:100',
            'company_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'invoice_design' => 'nullable|in:0,1,2,3,4',
        ]);

        $company = Companies::where('id', session()->get('company_id'))->first();
        if (!$company) {
            Session::flash('flash_error', 'Company not found.');
            return redirect('dashboard');
        }

        // Prevent updating another company via forged id
        if ($id !== null && (int) $id !== (int) $company->id) {
            Session::flash('flash_error', 'Unauthorized company update.');
            return redirect('company-settings');
        }

        $company->CompanyName = $request->CompanyName;
        $company->phone = $request->phone;
        $company->address = $request->address;
        $company->ntn = $request->ntn;
        $company->strn = $request->strn;
        $company->province = $request->province;
        $company->show_unit = $request->show_unit;
        $company->show_fbr_qty = $request->show_fbr_qty;
        $company->custom_heading = $request->custom_heading;
        $company->invoice_design = $request->invoice_design ?? 0;

        if (!is_null($request->file('company_logo'))) {
            $file = $request->file('company_logo');
            $extension = strtolower($file->getClientOriginalExtension());
            $name = 'company_' . $company->id . '_' . time() . '_' . mt_rand(1000, 9999) . '.' . $extension;
            $destination = base_path('../upload/company');

            try {
                $column = DB::select("SHOW COLUMNS FROM companies LIKE 'company_logo'");
                if (!empty($column) && preg_match('/varchar\\((\\d+)\\)/i', $column[0]->Type, $matches)) {
                    if ((int) $matches[1] < 255) {
                        DB::statement("ALTER TABLE companies MODIFY company_logo VARCHAR(255) NULL");
                    }
                }
            } catch (\Throwable $e) {
                // Ignore schema check issues and continue upload flow.
            }

            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            if ($company->company_logo) {
                $oldPath = base_path('../' . ltrim($company->company_logo, '/'));
                if (file_exists($oldPath)) {
                    @unlink($oldPath);
                }
            }

            $file->move($destination, $name);
            $company->company_logo = 'upload/company/' . $name;
        }

        $company->save();

        Session::flash('flash_message', 'Company Settings successfully Updated!');
        return redirect('company-settings');
    }
}
