
<?php
use App\Models\Companies;
$company = Companies::where('id', session()->get('company_id'))->first('system_type');
?>
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
             <!-- <a class="navbar-brand" href="{{ URL::to('dashboard') }}" id="menufont" style="height:63px;padding:3px 7px 68px;">
                 {{-- echo $quee['system_name'];  --}}
                <img src="{{ URL::asset('upload/logo/itlife_logo.png') }}"
                                    style="width: 65px;height: 65px;border-radius: 40px;border-image: solid 1px;border: solid 3px;border-color: transparent;" />
            </a> -->
            <a class="navbar-brand" href="{{ URL::to('dashboard') }}" id="menufont" style="font-size: 30px;"><?php echo $quee['system_name']; ?></a>
         </div>
         <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
             @if (session()->get('company_id') != null)
                 <ul class="nav navbar-nav" style="padding-top:9px">
                     <li class="dropdown">
                         <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                             data-target=".navbar-collapse" data-hover="dropdown" role="button"
                             aria-haspopup="true" aria-expanded="false"
                             style="font-family: sans-serif; color: black;font-weight: bold;">DEFINITION <span
                                 class="caret"></span></a>
                         <ul class="dropdown-menu" role="menu" style="border: 1px solid;">
                             <!-- <li style="font-family: sans-serif; border-bottom: 1px solid grey;"><a
                                     href="{{ URL::to('purchase-tax') }}">PURCHASE TAX INVOICE LIST</a></li> -->
                            
                            <li style="font-family: sans-serif; border-bottom: 1px solid grey;"><a href="{{ URL::to('products') }}">PRODUCTS</a></li>
                            <li style="font-family: sans-serif; border-bottom: 1px solid grey;"><a href="{{ URL::to('products/import-excel/create') }}">IMPORT PRODUCTS</a></li>
                            <li style="font-family: sans-serif; border-bottom: 1px solid grey;"><a href="{{ URL::to('parties') }}">PARTIES</a></li>
                            <li style="font-family: sans-serif; border-bottom: 1px solid grey;"><a href="{{ URL::to('parties/import-excel/create') }}">IMPORT PARTIES</a></li>
                            <li style="font-family: sans-serif; border-bottom: 1px solid grey;"><a href="{{ URL::to('salestax/import-excel/create') }}">IMPORT SALES</a></li> 
                            <li style="font-family: sans-serif; border-bottom: 1px solid grey;"><a href="{{ URL::to('opening-stock/create') }}">OPENING STOCK</a></li> 
                            <li style="font-family: sans-serif; border-bottom: 1px solid grey;"><a href="{{ URL::to('opening-stock') }}">EDIT OPENING STOCK</a></li> 
                         </ul>
                     </li>
                    <!-- <li>
                        <a href="{{ URL::to('purchase-tax/create') }}"  style="font-family: sans-serif; color: black;font-weight: bold;">
                            PURCHASE TAX INVOICE</a>
                    </li> -->
                    @if($company->system_type == "POS" || $company->system_type == "PRA" || $company->system_type == "KPRA" || $company->system_type == "SRB")
                    <li><a href="{{ URL::to('purchase-tax/create') }}"  style="font-family: sans-serif; color: black;font-weight: bold;">PURCHASE INVOICE</a></li>
                    <li><a href="{{ URL::to('pos-salestax/create') }}"  style="font-family: sans-serif; color: black;font-weight: bold;">SALES TAX INVOICE</a></li>
                    <li><a href="{{ URL::to('pos-credit-note/create') }}"  style="font-family: sans-serif; color: black;font-weight: bold;">CREDIT NOTE</a>
                    @else
                    <li><a href="{{ URL::to('purchase-tax/create') }}"  style="font-family: sans-serif; color: black;font-weight: bold;">PURCHASE INVOICE</a></li>
                    <li><a href="{{ URL::to('salestax/create') }}"  style="font-family: sans-serif; color: black;font-weight: bold;">SALES TAX INVOICE</a></li>
                    <li><a href="{{ URL::to('debit-note/create') }}"  style="font-family: sans-serif; color: black;font-weight: bold;">DEBIT NOTE</a>
                    @endif
                    
                    </li>

                     <li class="dropdown">
                         <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                             data-target=".navbar-collapse" data-hover="dropdown" role="button"
                             aria-haspopup="true" aria-expanded="false"
                             style="font-family: sans-serif; color: black;font-weight: bold;">INVOICES <span
                                 class="caret"></span></a>
                         <ul class="dropdown-menu" role="menu" style="border: 1px solid;">
                             <!-- <li style="font-family: sans-serif; border-bottom: 1px solid grey;"><a
                                     href="{{ URL::to('purchase-tax') }}">PURCHASE TAX INVOICE LIST</a></li> -->
                            @if($company->system_type == "POS" || $company->system_type == "PRA" || $company->system_type == "KPRA" || $company->system_type == "SRB")
                            <li style="font-family: sans-serif; border-bottom: 1px solid grey;"><a href="{{ URL::to('purchase-tax') }}">PURCHASE INVOICES LIST</a></li>
                            <li style="font-family: sans-serif; border-bottom: 1px solid grey;"><a href="{{ URL::to('pos-salestax') }}">SALESTAX INVOICES LIST</a></li>
                            <li style="font-family: sans-serif; border-bottom: 1px solid grey;"><a href="{{ URL::to('pos-credit-note') }}">CREDIT NOTE LIST</a></li>
                            @else
                            <li style="font-family: sans-serif; border-bottom: 1px solid grey;"><a href="{{ URL::to('purchase-tax') }}">PURCHASE INVOICES LIST</a></li>
                            <li style="font-family: sans-serif; border-bottom: 1px solid grey;"><a href="{{ URL::to('salestax') }}">SALES TAX INVOICE LIST</a></li>
                            <li style="font-family: sans-serif; border-bottom: 1px solid grey;"><a href="{{ URL::to('debit-note') }}">DEBIT NOTE LIST</a></li>
                            @endif
                            
                         </ul>
                     </li>
                     <li class="dropdown">
                         <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                             data-target=".navbar-collapse" data-hover="dropdown" role="button"
                             aria-haspopup="true" aria-expanded="false"
                             style="font-family: sans-serif; color: black;font-weight: bold;">REPORTS <span
                                 class="caret"></span></a>
                         <ul class="dropdown-menu" role="menu" style="border: 1px solid;">
                             <li style="font-family: sans-serif; border-bottom: 1px solid grey;"><a
                                     href="{{ URL::to('salestax-report/single-party/add') }}">SINGLE PARTY REPORT</a></li>
                             <li style="font-family: sans-serif; border-bottom: 1px solid grey;"><a
                                     href="{{ URL::to('salestax-report/all-party/create') }}">ALL PARTY REPORT</a></li>
                             
                             <li style="font-family: sans-serif; border-bottom: 1px solid grey;"><a
                                     href="{{  URL::to('product-report')}}">PRODUCT REPORT</a></li>
                            <li style="font-family: sans-serif; border-bottom: 1px solid grey;"><a
                                     href="{{  URL::to('raw-material')}}">STOCK REPORT</a></li>
                            <li class="dropdown" style="border-bottom: 1px solid grey;">
                            <a href="#">PURCHASE TAX LEDGER<span class="caret"></span></a>
                            <ul class="dropdown-menu dropdownhover-right">
                                <li><a href="{{ URL::to('purchasetax-report/single-party/add') }}">PURCHASE REGISTER (SINGLE PARTY)</a></li>
                                <li><a href="{{ URL::to('purchasetax-report/all-party/create') }}">PURCHASE REGISTER (ALL PARTIES)</a></li>
                            </ul>
                        </li>         
                            <!-- <li style="font-family: sans-serif; border-bottom: 1px solid grey;"><a
                                     href="{{  URL::to('raw-material')}}">STOCK REPORT</a></li> -->
                            <li style="font-family: sans-serif; border-bottom: 1px solid grey;"><a href="{{ URL::to('print-reports/create') }}">PRINT REPORTS</a></li>
                         </ul>
                     </li>
                     <!-- <li>
                        <a href="{{ URL::to('pointofsale/create') }}"  style="font-family: sans-serif; color: black;font-weight: bold;">
                            POS</a>
                    </li> -->
                     <li>
                        @if(Auth::User()->status == 'user')
                       
                        @else
                        <a href="{{ URL::to('roles') }}" 
                         {{-- style="font-family: monospace; color: black;font-weight: bold;" --}}
                         style="display:none;"
                         >
                            USERS</a>
                         @endif
                    </li>
                     <!-- <li class="dropdown">
                <a href="{{ URL::to('') }}" role="button" aria-haspopup="true" aria-expanded="false" style="font-family: monospace; color: black;font-weight: bold;">PURCHASE</a>
                </li>
                <li class="dropdown">
                <a href="{{ URL::to('') }}" role="button" aria-haspopup="true" aria-expanded="false" style="font-family: monospace; color: black;font-weight: bold;">PURCHASE TAX</a>
                </li> -->
                     {{-- <li class="dropdown">
                         <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                             data-target=".navbar-collapse" data-hover="dropdown" role="button"
                             aria-haspopup="true" aria-expanded="false"
                             style="font-family: monospace; color: black;font-weight: bold;">SALES<span
                                 class="caret"></span></a>
                         <ul class="dropdown-menu" role="menu" style="border: 1px solid;">
                             <li style="border-bottom: 1px solid grey;"><a
                                     href="{{ URL::to('sales/create') }}">SALES</a></li>
                             <li style="border-bottom: 1px solid grey;"><a
                                     href="{{ URL::to('salestax/create') }}">SALES TAX</a></li>
                         </ul>
                     </li> --}}
                     {{-- @if (session()->get('company_type') == 'Manufacturer')
                         <li class="dropdown">
                             <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                                 data-target=".navbar-collapse" data-hover="dropdown" role="button"
                                 aria-haspopup="true" aria-expanded="false"
                                 style="font-family: monospace; color: black;font-weight: bold;">PRODUCTION <span
                                     class="caret"></span></a>
                             <ul class="dropdown-menu" role="menu" style="border: 1px solid;">
                                 <li style="border-bottom: 1px solid grey;"><a
                                         href="{{ URL::to('recipe-creation/create') }}">RECIPE</a></li>
                                         <li style="border-bottom: 1px solid grey;"><a
                                     href="{{ URL::to('recipe-creation') }}">EDIT RECIPE</a></li>
                                 <li style="border-bottom: 1px solid grey;"><a
                                         href="{{ URL::to('production/create') }}">PRODUCTION</a></li>
                                         <li style="border-bottom: 1px solid grey;"><a
                                     href="{{ URL::to('production') }}">EDIT PRODUCTION</a></li>
                                         <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('stock-issue/create') }}">STOCK
                                     ISSUE</a></li>
                                     <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('stock-issue') }}">EDIT STOCK
                                     ISSUE</a></li>
                                     
                             
                             </ul>
                         </li>
                     @endif --}}
                     {{-- <li class="dropdown">
                         <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                             data-target=".navbar-collapse" data-hover="dropdown" role="button"
                             aria-haspopup="true" aria-expanded="false"
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
                             </li> --}}
                             {{-- <li class="dropdown" style="border-bottom: 1px solid grey;">
                                 <a href="#">SALES LEDGER<span class="caret"></span></a>
                                 <ul class="dropdown-menu dropdownhover-right">
                                     <li><a href="{{ URL::to('sales-report/single-party/create') }}">SALE
                                             REGISTER(SINGLE PARTY)</a></li>
                                     <li><a href="{{ URL::to('sales-report/all-party/create') }}">SALE
                                             REGISTER(ALL
                                             PARTY)</a></li> --}}
                                     {{-- <li><a href="{{ URL::to('sales-report/user-sale/create') }}">SALE REGISTER(USER WISE)</a></li> --}}
                                 {{-- </ul>
                             </li>
                             <li class="dropdown" style="border-bottom: 1px solid grey;">
                                 <a href="#">SALES TAX LEDGER<span class="caret"></span></a>
                                 <ul class="dropdown-menu dropdownhover-right">
                                     <li><a href="{{ URL::to('salestax-report/all-party/create') }}">SALESTAX
                                             REGISTER</a></li>
                                     <li><a href="{{ URL::to('salestax-report/single-party/add') }}">ST.REGISTER
                                             SINGLE PARTY</a></li>
                                 </ul> --}}
                             {{-- </li>
                             <li class="dropdown" style="border-bottom: 1px solid grey;">
                                 <a href="#">LEDGERS<span class="caret"></span></a>
                                 <ul class="dropdown-menu dropdownhover-right">
                                     <li><a href="{{ URL::to('client-all-report') }}">GENERAL LEDGER</a></li>
                                     <li><a href="{{ URL::to('ledger-all-party') }}">ALL PARTIES LEDGER</a></li>
                                 </ul>
                             </li> --}}
                             {{-- <li class="dropdown" style="border-bottom: 1px solid grey;">
                                 <a href="#">STOCK<span class="caret"></span></a>
                                 <ul class="dropdown-menu dropdownhover-right">
                                     @if (session()->get('company_type') == 'Trader')
                                         <li><a href="{{ URL::to('raw-material') }}">RAW MATERIAL STOCK</a></li>
                                     @else
                                     <li><a href="{{ URL::to('raw-material') }}">RAW MATERIAL STOCK</a></li>
                                     <li><a href="{{ URL::to('stockissue-report/create') }}">WORK IN PROCESS</a></li>
                                     <li><a href="{{ URL::to('production-stock') }}">FINISHED GOODS STOCK</a></li>
                                      --}}
                                         <!-- <li style="border-bottom: 1px solid grey;"><a
                                     href="{{ URL::to('stockissue-report/create') }}">STACKISSUE-REPORT</a>
                             </li> -->
                                     {{-- @endif
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
                             @endif --}}


                             <!-- <li style="border-bottom: 1px solid grey;"><a href="{{ URL::to('raw-material') }}">STOCK REPORT</a></li> -->
                             {{-- <li style="border-bottom: 1px solid grey;"><a
                                     href="{{ URL::to('cash-book-report') }}">CASH BOOK</a></li>
                            <li style="border-bottom: 1px solid grey;"><a
                                     href="{{ URL::to('trial-balance/create') }}">TRIAL BALANCE</a></li>
                             <li style="border-bottom: 1px solid grey;"><a
                                     href="{{ URL::to('profitloss/create') }}">PROFIT & LOSS ACCOUNT</a></li>
                             <li style="border-bottom: 1px solid grey;"><a
                                     href="{{ URL::to('salary-sheet') }}">SALARY SHEET</a></li>
                             <li style="border-bottom: 1px solid grey;"><a
                                     href="{{ URL::to('print-reports/create') }}">PRINT REPORTS</a></li>
                         </ul>
                     </li>--}}
                 </ul> 
                 <ul class="nav navbar-nav navbar-right">
                     <li class="dropdown" style="font-family: sans-serif;padding-top:9px">
                         <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                             aria-haspopup="true" aria-expanded="false"
                             style="color: black;font-weight: bold;">{{ Auth::user()->name }}<span
                                 class="caret"></span></a>
                         <ul class="dropdown-menu">
                             <li><a href="{{ URL::to('account') }}"><i
                                         class="icon-user"></i>Account Settings</a></li>
                             <li><a href="{{ URL::to('company-settings') }}"><i
                                         class="icon-cog"></i>Settings</a></li>
                             {{-- <li><a href="{{ URL::to('settings/1/edit') }}"><i class="icon-cog"></i>System
                                     settings</a></li> --}}
                             <li class="divider"></li>
                             <li>
                                 <!-- {{-- @if (session()->has('company_id') && Auth::User()->status == 'company')
                                     <a href="{{ URL::to('logout') }}"
                                         onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                                     <form id="logout-form" action="{{ URL::to('logout') }}" method="POST"
                                         style="display: none;">
                                         {{ csrf_field() }}
                                     </form>
                                 @elseif (session()->has('company_id'))
                                     <a href="{{ asset('logout-company') }}">Select Company</a>
                                 @else --}}
                                     <a href="{{ URL::to('logout') }}"
                                         onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                                     <form id="logout-form" action="{{ URL::to('logout') }}" method="POST"
                                         style="display: none;">
                                         {{ csrf_field() }}
                                     </form>
                                 {{-- @endif --}} -->
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
                         <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                             aria-haspopup="true" aria-expanded="false"
                             style="color: black;font-weight: bold;">{{ Auth::user()->name }}<span
                                 class="caret"></span></a>
                         <ul class="dropdown-menu">
                             <li><a href="{{ URL::to('account') }}"><i
                                         class="icon-user"></i>Account Settings</a></li>
                             <li><a href="{{ URL::to('company-settings') }}"><i
                                         class="icon-cog"></i>Settings</a></li>
                             {{-- <li><a href="{{ URL::to('settings/1/edit') }}"><i class="icon-cog"></i>System
                                     settings</a></li> --}}
                             <li class="divider"></li>
                             <li>
                                 {{-- @if (session()->has('company_id') && Auth::User()->status == 'company') --}}
                                     <a href="{{ URL::to('logout') }}"
                                         onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                                     <form id="logout-form" action="{{ URL::to('logout') }}" method="POST"
                                         style="display: none;">
                                         {{ csrf_field() }}
                                     </form>
                                 {{-- @elseif (session()->has('company_id'))
                                     <a href="{{ asset('logout-company') }}">Select Company</a>
                                 @else
                                     <a href="{{ URL::to('logout') }}"
                                         onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                                     <form id="logout-form" action="{{ URL::to('logout') }}" method="POST"
                                         style="display: none;">
                                         {{ csrf_field() }}
                                     </form>
                                 @endif --}}
                             </li>
                         </ul>
                     </li>
                 </ul>
             @endif
         </div>
     </div>
 </nav>
