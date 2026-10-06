<?php

use App\Models\Companies;
use App\Models\User;
$user = User::where('id', Auth::User()->id)->first();
$company = Companies::where('id', session()->get('company_id'))->first('system_type');
?>
<style>
    .nav {
        font-size: 18px;
    }

    .nav ul li {
        font-size: 16px;
    }
</style>
<nav class="navbar navbar-default" style="margin-bottom: 0px;">
    <div class="container-fluid" id="menubg">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ URL::to('dashboard') }}" id="menufont"
                style="font-size: 30px;"><?php echo $quee['system_name']; ?></a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            @if (session()->get('company_id') != null)
          @if($user->roles[0]->name == "Editor")
           
            <ul class="nav navbar-nav">
               
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-target=".navbar-collapse"
                        data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false"
                        style="font-family: monospace; color: black;font-weight: bold;">VOUCHERS <span
                            class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu" style="border: 1px solid;">
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('products') }}">PRODUCTS</a></li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('delivery-challan/create') }}">DELIVERY CHALLAN CREATE</a></li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('delivery-challan') }}">DELIVERY CHALLANS</a></li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('grn/create') }}">GRN CREATE</a></li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('grn') }}">GRN'S</a></li>
                    </ul>
                </li>
            </ul>
            </li>
            </ul>
            @else
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-target=".navbar-collapse"
                        data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false"
                        style="font-family: monospace; color: black;font-weight: bold;">DEFINATION<span
                            class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('parties') }}">ACCOUNTS</a></li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('parties/import-excel/create') }}">IMPORT ACCOUNTS</a></li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('products') }}">PRODUCTS</a></li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('products/import-excel/create') }}">IMPORT PRODUCTS</a></li>
                        <li style="border-bottom: 1px solid grey;"><a
                                href="{{ URL::to('general-voucher/create') }}">OPENING BALANCE VOUCHER</a></li>
                        <li style="border-bottom: 1px solid grey;"><a
                                href="{{ URL::to('opening-stock/create') }}">OPENING STOCK VOUCHER</a></li>

                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-target=".navbar-collapse"
                        data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false"
                        style="font-family: monospace; color: black;font-weight: bold;">EDIT <span
                            class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu" style="border: 1px solid;">
                        <!-- <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('purchases') }}">PURCHASES</a> -->
                        <!-- </li> -->
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('purchase-tax') }}">PURCHASE TAX</a></li>
                        <!-- <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('sales') }}">SALES</a></li> -->
                        @if($company->system_type == "POS" || $company->system_type == "PRA" || $company->system_type == "KPRA" || $company->system_type == "SRB")
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('pos-salestax') }}">SALES TAX</a></li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('pos-credit-note') }}">CREDIT NOTE</a></li>
                        @else
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('delivery-challan') }}">DELIVERY CHALLAN</a></li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('grn') }}">GRN</a></li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('salestax') }}">SALES TAX</a></li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('debit-note') }}">DEBIT NOTE</a></li>
                        @endif
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('find-sale/create') }}">FIND SALE</a></li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('opening-stock') }}">OPENING STOCK</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-target=".navbar-collapse"
                        data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false"
                        style="font-family: monospace; color: black;font-weight: bold;">EDIT FINANCIALS <span
                            class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu" style="border: 1px solid;">
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('cash-receipts') }}">CASH
                                RECEIPT VOUCHER</a></li>
                        <li style="border-bottom: 1px solid grey;"><a
                                href="{{ URL::to('find-cash-receipts/create') }}">FIND CASH RECEIPT VOUCHER</a>
                        </li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('cash-payments') }}">CASH
                                PAYMENT VOUCHER</a></li>
                        <li style="border-bottom: 1px solid grey;"><a
                                href="{{ URL::to('find-cash-payments/create') }}">FIND CASH PAYMENT VOUCHER</a>
                        </li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('bank-receipts') }}">BANK
                                RECEIPT VOUCHER</a></li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('bank-payments') }}">BANK
                                PAYMENT VOUCHER</a></li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('general-voucher') }}">JOURNAL
                                VOUCHER</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-target=".navbar-collapse"
                        data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false"
                        style="font-family: monospace; color: black;font-weight: bold;">FINANCIALS <span
                            class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu" style="border: 1px solid;">
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('cash-receipts/create') }}">CASH
                                RECEIPT VOUCHER</a></li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('cash-payments/create') }}">CASH
                                PAYMENT VOUCHER</a></li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('bank-receipts/create') }}">BANK
                                RECEIPT VOUCHER</a></li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('bank-payments/create') }}">BANK
                                PAYMENT VOUCHER</a></li>
                        <li style="border-bottom: 1px solid grey;"><a
                                href="{{ URL::to('general-voucher/create') }}">JOURNAL VOUCHER</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-target=".navbar-collapse"
                        data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false"
                        style="font-family: monospace; color: black;font-weight: bold;">PURCHASES <span
                            class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu" style="border: 1px solid;">
                        <!-- <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('purchases/create') }}">PURCHASE</a></li> -->
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('grn/create') }}">GRN</a></li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('purchase-tax/create') }}">PURCHASE TAX</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-target=".navbar-collapse"
                        data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false"
                        style="font-family: monospace; color: black;font-weight: bold;">SALES<span
                            class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu" style="border: 1px solid;">
                        <!-- <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('sales/create') }}">SALES</a>
                        </li> -->
                        @if($company->system_type == "POS" || $company->system_type == "PRA" || $company->system_type == "KPRA" || $company->system_type == "SRB")
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('pos-salestax/create') }}">SALES TAX</a></li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('pos-credit-note/create') }}">CREDIT NOTE</a></li>
                        @else
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('delivery-challan/create') }}">DELIVERY CHALLAN</a></li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('salestax/import-excel/create') }}">IMPORT SALES</a></li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('salestax/create') }}">SALES TAX</a></li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('debit-note/create') }}">DEBIT NOTE</a></li>
                        @endif
                    </ul>
                </li>
                @if (session()->get('company_type') == 'Manufacturer')
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-target=".navbar-collapse"
                        data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false"
                        style="font-family: monospace; color: black;font-weight: bold;">PRODUCTION <span
                            class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu" style="border: 1px solid;">
                        <li style="border-bottom: 1px solid grey;"><a
                                href="{{ URL::to('recipe-creation/create') }}">RECIPE</a></li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('recipe-creation') }}">EDIT
                                RECIPE</a></li>
                        <li style="border-bottom: 1px solid grey;"><a
                                href="{{ URL::to('production/create') }}">PRODUCTION</a></li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('production') }}">EDIT
                                PRODUCTION</a></li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('stock-issue/create') }}">STOCK
                                ISSUE</a></li>
                        <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('stock-issue') }}">EDIT STOCK
                                ISSUE</a></li>


                    </ul>
                </li>
                @endif
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-target=".navbar-collapse"
                        data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false"
                        style="font-family: monospace; color: black;font-weight: bold;">REPORTS<span
                            class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li class="dropdown" style="border-bottom: 1px solid grey;">
                            <a href="#">PURCHASE LEDGER<span class="caret"></span></a>
                            <ul class="dropdown-menu dropdownhover-right">
                                <li><a href="{{ URL::to('purchase-report/create') }}">PURCHASE LEDGER</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown" style="border-bottom: 1px solid grey;">
                            <a href="#">PURCHASE TAX LEDGER<span class="caret"></span></a>
                            <ul class="dropdown-menu dropdownhover-right">
                                <li><a href="{{ URL::to('purchasetax-report/single-party/add') }}">PURCHASE
                                        TAX
                                        LEDGER (Single Party)</a></li>
                                <li><a href="{{ URL::to('purchasetax-report/all-party/create') }}">PURCHASE
                                        TAX
                                        LEDGER (All Party)</a></li>
                            </ul>
                        </li>
                        <li class="dropdown" style="border-bottom: 1px solid grey;">
                            <a href="#">SALES LEDGER<span class="caret"></span></a>
                            <ul class="dropdown-menu dropdownhover-right">
                                <li><a href="{{ URL::to('sales-report/single-party/create') }}">SALE
                                        REGISTER(SINGLE PARTY)</a></li>
                                <li><a href="{{ URL::to('sales-report/all-party/create') }}">SALE
                                        REGISTER(ALL
                                        PARTY)</a></li>
                                {{-- <li><a href="{{ URL::to('sales-report/user-sale/create') }}">SALE REGISTER(USER
                                WISE)</a>
                        </li> --}}
                    </ul>
                </li>
                <li class="dropdown" style="border-bottom: 1px solid grey;">
                    <a href="#">SALES TAX LEDGER<span class="caret"></span></a>
                    <ul class="dropdown-menu dropdownhover-right">
                        <li><a href="{{ URL::to('salestax-report/all-party/create') }}">SALESTAX
                                REGISTER</a></li>
                        <li><a href="{{ URL::to('salestax-report/single-party/add') }}">ST.REGISTER
                                SINGLE PARTY</a></li>
                    </ul>
                </li>
                <li class="dropdown" style="border-bottom: 1px solid grey;">
                    <a href="#">LEDGERS<span class="caret"></span></a>
                    <ul class="dropdown-menu dropdownhover-right">
                        <li><a href="{{ URL::to('client-all-report') }}">GENERAL LEDGER</a></li>
                        <li><a href="{{ URL::to('ledger-all-party') }}">ALL PARTIES LEDGER</a></li>
                    </ul>
                </li>
                <li class="dropdown" style="border-bottom: 1px solid grey;">
                    <a href="#">STOCK<span class="caret"></span></a>
                    <ul class="dropdown-menu dropdownhover-right">
                        @if (session()->get('company_type') == 'Trader')
                        <li><a href="{{ URL::to('raw-material') }}">RAW MATERIAL STOCK</a></li>
                        @else
                        <li><a href="{{ URL::to('raw-material') }}">RAW MATERIAL STOCK</a></li>
                        <li><a href="{{ URL::to('stockissue-report/create') }}">WORK IN PROCESS</a></li>
                        <li><a href="{{ URL::to('production-stock') }}">FINISHED GOODS STOCK</a></li>

                        <!-- <li style="border-bottom: 1px solid grey;"><a
                                     href="{{ URL::to('stockissue-report/create') }}">STACKISSUE-REPORT</a>
                             </li> -->
                        @endif
                    </ul>
                </li>
                @if (session()->get('company_type') == 'Manufacturer')
                <li class="dropdown" style="border-bottom: 1px solid grey;">
                    <a href="#">PRODUCTION REPORT<span class="caret"></span></a>
                    <ul class="dropdown-menu dropdownhover-right">
                        <li><a href="{{ URL::to('production-report/create') }}">ALL ITEMS</a></li>
                        <li><a href="{{ URL::to('production-report') }}">SINGLE ITEM</a></li>
                    </ul>
                </li>
                @endif


                <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('cash-book-report') }}">CASH BOOK</a>
                </li>
                <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('product-report') }}">PRODUCT REPORT</a>
                </li>
                
                <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('trial-balance/create') }}">TRIAL
                        BALANCE</a></li>
                <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('profitloss/create') }}">PROFIT & LOSS
                        ACCOUNT</a></li>
                <!-- <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('salary-sheet') }}">SALARY SHEET</a></li> -->
                <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('print-reports/create') }}">PRINT REPORTS</a></li>
            </ul>
            </li>
            </ul>
            @endif
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown" style="font-family: monospace;">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                        aria-expanded="false" style="color: black;font-weight: bold;">{{ Auth::user()->name }}<span
                            class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ URL::to('account') }}"><i
                                    class="icon-user"></i>Account Setting</a></li>
                        <li><a href="{{ URL::to('company-settings') }}"><i
                                    class="icon-cog"></i>Settings</a></li>
                        <!-- <li><a href="{{ URL::to('settings/1/edit') }}"><i class="icon-cog"></i>Account Setting</a></li> -->
                        <!-- <li><a href="{{ URL::to('settings/1/edit') }}"><i class="icon-cog"></i>System
                                     settings</a></li> -->
                        <li class="divider"></li>
                        <li>
                            @if (session()->has('company_id') && Auth::User()->status == 'company' || Auth::User()->status == 'user')
                            <a href="{{ URL::to('logout') }}"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ URL::to('logout') }}" method="POST"
                                style="display: none;">
                                {{ csrf_field() }}
                            </form>
                            @elseif (session()->has('company_id'))
                            <a href="{{ asset('logout-company') }}">Select Company</a>
                            @else
                            <a href="{{ URL::to('logout') }}"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ URL::to('logout') }}" method="POST"
                                style="display: none;">
                                {{ csrf_field() }}
                            </form>
                            @endif
                        </li>
                    </ul>
                </li>
            </ul>
            @else
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown" style="font-family: monospace;">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                        aria-expanded="false" style="color: black;font-weight: bold;">{{ Auth::user()->name }}<span
                            class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ URL::to('account') }}"><i
                                    class="icon-user"></i>Account Setting</a></li>
                        <li><a href="{{ URL::to('company-settings') }}"><i
                                    class="icon-cog"></i>Settings</a></li>
                        <li class="divider"></li>
                        <li>
                            @if (session()->has('company_id') && Auth::User()->status == 'company')
                            <a href="{{ URL::to('logout') }}"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ URL::to('logout') }}" method="POST"
                                style="display: none;">
                                {{ csrf_field() }}
                            </form>
                            @elseif (session()->has('company_id'))
                            <a href="{{ asset('logout-company') }}">Select Company</a>
                            @else
                            <a href="{{ URL::to('logout') }}"
                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                            <form id="logout-form" action="{{ URL::to('logout') }}" method="POST"
                                style="display: none;">
                                {{ csrf_field() }}
                            </form>
                            @endif
                        </li>
                    </ul>
                </li>
            </ul>
            @endif
        </div>
    </div>
</nav>