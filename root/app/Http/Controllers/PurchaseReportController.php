<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;

class PurchaseReportController extends Controller
{
    public function index(Request $request)
    {
        $purchase = json_decode($request->get('purchase'), true);
        return $purchase;
    }

    public function create()
    {
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        return view('purchase-report.create', Compact('encrypted_token'));
    }

    public function store(Request $request)
    {
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');

        $purchases = Purchase::with(['purchase_details' => function ($query) {
            $query->with('products');
            $query->with('party');
        }])
            ->where('company_id', session()->get('company_id'))
            ->whereBetween('date', [$fromDate, $toDate])->OrderBy('id', 'asc')->get();

        return view('purchase-report.report', compact('purchases', 'fromDate', 'toDate'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function print_purchase(Request $request)
    {
        $encrypter = app('Illuminate\Encryption\Encrypter');
        $encrypted_token = $encrypter->encrypt(csrf_token());
        $fromDate = $request->get('from_date');
        $toDate = $request->get('to_date');
        return $fromDate;

        $purchases = Purchase::with(['suppliers', 'purchase_details' => function ($query) {
            $query->with('products');
        }])
            ->where('company_id', session()->get('company_id'))
            ->whereBetween('date', [$fromDate, $toDate])->OrderBy('id', 'asc')->get();
        // return $purchases;
        return view('purchase-report.print', compact('purchases', 'encrypted_token'));
    }
}
