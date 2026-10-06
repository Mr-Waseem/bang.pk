@extends("app")
@section('contents')
    @php
    use App\Models\Setting;
    $company_detail = Setting::first();
    @endphp
    <!-- <center><h1 class="page-title" style="font-size:400%; color:white;"><b>{{ $company_detail->system_name }}</b></h1></center>
    <center><h4 class="page-title" style="font-size:200%;"><b>{{ $company_detail->address }}</b></h4></center>
    <center><h4 class="page-title" style="font-size:200%;"><b>{{ $company_detail->email }}</b></h4></center>
    <center><h4 class="page-title" style="font-size:200%;"><b>{{ $company_detail->city }}</b></h4></center>
    <center><h4 class="page-title" style="font-size:200%;"><b>{{ $company_detail->phone }}</b></h4></center>


    <center><h4 class="page-title" style="font-size:200%;"><b>{{ $company_detail->state }}</b></h4></center>

    <div>
    <div class="col-sm-5">
    </div>
    <div class="col-sm-3">
    </div>
    <div class="col-sm-4">
     <h1 class="page-title" style="font-size:200%;"><b><a href="http://itlife.com.pk/" target="__blank" style="color:white;">IT Life</a></b></h1>
     <h4 class="page-title" style="font-size:100%; color:orange;"><b>Urooj Center, Near Farid Kot Road. Lahore.</b></h4>
    <h4 class="page-title" style="font-size:100%; color:orange;"><b>0321 4197290</b></h4>
    <h4 class="page-title" style="font-size:100%; color:orange;"><b>0423 7235275</b></h4>
    <h4 class="page-title" style="font-size:100%; color:orange;"><b>info@itlife.com.pk</b></h4>
    <h4 class="page-title" style="font-size:100%; color:orange;"><b><a href="http://itlife.com.pk/" target="__blank" style="color:blue;">www.itife.com.pk</a></b></h4>
    </div>
    </div> -->

    <!--  <h1 class="page-title"><b>Dashboard</b></h1> -->
    <div class="container-fluid">
        @if (Session::has('flash_message'))
            <div class="alert alert-success alert-dismissible fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close"
                    style="margin-right: 4%;">&times;</a>
                <strong>Success!</strong> {{ Session::get('flash_message') }}
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading no-border clearfix" id="subpanelbg">
                    <center>
                        <h2 class="panel-title">
                       
                            <b style="color:white;">Welcome: {{ Auth::User()->name}}</b>
                            <!-- <b style="color:white;">Welcome {{ session()->get('company_name') }}</b> -->
                            @if (Auth::user()->image != null)
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <img src="{{ URL::asset('root/upload/users/' . Auth::user()->image) }}"
                                    style="width: 40px;height: 40px;border-radius: 25px;border-image: solid 2px;border: solid 3px;border-color: #00a65a;" />
                            @else
                                <img src="{{ URL::asset('root/upload/logo/userlogo.png') }}"
                                    style="width: 40px;height: 40px;border-radius: 25px;border-image: solid 2px;border: solid 3px;border-color: #00a65a;" />
                            @endif
                            &emsp;&emsp;&emsp;&emsp;
                            <b style="color:white;">Company: {{ session()->get('company_name') }}</b>
                            
                            
                        </h2>
                    </center>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-default" style="box-shadow: 0 0 10px 0 rgb(0 0 0 / 100%);">
                <div class="panel-heading no-border clearfix" id="panelbg">
                    <center>
                        <h2 class="panel-title" style="color: white;font-weight: bold">VOUCHERS</h2>
                    </center>
                </div>
                <!-- panel body -->
                <div class="panel-body bg-light">
                    <ul class="list-group">
                        {{-- <li>	
						<div class="user-detail">
							<a href="/collection-milk/create"><b>COLLECTION MILK (CENTER)</b></a>
						</div>
					</li> --}}

                        {{-- <li>	
						<div class="user-detail">
							<a href="/purchase-milk/center-report/create"><b>COLLECTION MILK REPORT(CENTER)</b></a>
							
						</div>
					</li>
					<li>	
						<div class="user-detail">
							<a href="/purchase-milk/supplier-wise/center/create"><b>COLLECTION MILK REPORT(SUPPLIER WISE)</b></a>
							
						</div>
					</li>
					<li>
						<div class="user-detail">
							<a href="/carry-milk/create"><b>CARRY MILK (DRIVER)</b></a>
						</div>
					</li>
					<li>	
						<div class="user-detail">
							<a href="/purchase-milk/driver-report/create"><b>CARRY MILK REPORT (DRIVER)</b></a>
						</div>
					</li>
					<li>	
						<div class="user-detail">
							<a href="/purchase-milk/create"><b>PURCHASE MILK (RECEIVE)</b></a>
						</div>
					</li>
					<li>	
						<div class="user-detail">
							<a href="/purchase-milk/admin-report/create"><b>PURCHASE MILK REPORT(AUTHOR)</b></a>
						</div>
					</li> --}}
                        <li class="list-group-item">
                            <div class="user-detail">
                                <a href="{{ URL::to('cash-receipts') }}"><b style="color: black">CASH RECEIPT
                                        VOUCHER</b></a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="user-detail">
                                <a href="{{ URL::to('find-cash-receipts/create') }}"><b style="color: black">FIND CASH
                                        RECEIPT VOUCHER</b></a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="user-detail">
                                <a href="{{ URL::to('cash-payments') }}"><b style="color: black">CASH PAYMENT
                                        VOUCHER</b></a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="user-detail">
                                <a href="{{ URL::to('find-cash-payments/create') }}"><b style="color: black">FIND CASH
                                        PAYMENT VOUCHER</b></a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="user-detail">
                                <a href="{{ URL::to('bank-receipts') }}"><b style="color: black">BANK RECEIPT
                                        VOUCHER</b></a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="user-detail">
                                <a href="{{ URL::to('bank-payments') }}"><b style="color: black">BANK PAYMENT
                                        VOUCHER</b></a>
                            </div>
                        </li>

                        {{-- <li>
						<div class="user-detail">
							<a href="/settings/{{Auth::User()->id}}/edit"><b>ACCOUNT SETTING</b></a>
							<b>TOTAL SALES (RS)</b><span class="badge" style="float:right; color:#10ff00;">{{$sales+$Gstsales}}</span>
						</div>
					</li> --}}


                    </ul>

                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-default" style="box-shadow: 0 0 10px 0 rgb(0 0 0 / 100%);">
                <div class="panel-heading no-border clearfix" id="panelbg">
                    <center>
                        <h2 class="panel-title" style="color:white;font-weight: bold">SALES</h2>
                    </center>
                </div>
                <!-- panel body -->
                <div class="panel-body bg-light">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="user-detail">
                                <a href="{{ asset('sales/create') }}"><b style="color: black">ADD SALE</b></a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="user-detail">
                                <a href="{{ asset('sale-report/create') }}"><b style="color: black">DAILY SALE</b></a>
                            </div>
                        </li>
                        {{-- <li class="list-group-item">	
						<div class="user-detail">
							<a href="{{ asset('salepoint-stock/'.Auth::User()->shop_id) }}"><b style="color: black">SALEPOINT STOCK</b></a>
						</div>
					</li> --}}
                        <li class="list-group-item">
                            <div class="user-detail">
                                <a href="{{ asset('cash-book-report') }}"><b style="color: black">CASHBOOK</b></a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="user-detail">
                                <a href="{{ asset('cash-receipts/create') }}"><b style="color: black">CASH
                                        RECEIPTS</b></a>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="user-detail">
                                <a href="{{ asset('stock-transfer-report/create') }}"><b style="color: black">STOCK
                                        TRANSFER REPORT</b></a>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-default" style="box-shadow: 0 0 50px 0 rgb(0 0 0 / 100%);">
                <div class="panel-heading no-border clearfix" id="panelbg">
                    <center>
                        <h2 class="panel-title" style="color: white;font-weight: bold">CUSTOMER & PRODUCT</h2>
                    </center>
                </div>
                <!-- panel body -->
                <div class="panel-body bg-light">
                    <ul class="list-group">
                        <a href="{{ asset('client-all-report') }}">
                            <li class="list-group-item" style="color: black"><span class="badge badge-primary"><i
                                        class="fa fa-hand-o-left" aria-hidden="true"></i></span><b>CUSTOMER LEDGER</b></li>
                        </a>
                        <a href="#">
                            <li class="list-group-item" style="color: black"><span class="badge badge-primary"><i
                                        class="fa fa-hand-o-left" aria-hidden="true"></i></span><b>ALL PARTY BALANCE</b>
                            </li>
                        </a>
                        <a href="#">
                            <li class="list-group-item" style="color: black"><span class="badge badge-primary"><i
                                        class="fa fa-hand-o-left" aria-hidden="true"></i></span><b>STOCK ALL ITEMS</b></li>
                        </a>
                        <a href="#">
                            <li class="list-group-item" style="color: black"><span class="badge badge-primary"><i
                                        class="fa fa-hand-o-left" aria-hidden="true"></i></span><b>STOCK SINGLE ITEM</b>
                            </li>
                        </a>
                        <a href="{{ asset('expense-report/create') }}">
                            <li class="list-group-item" style="color: black"><span class="badge badge-primary"><i
                                        class="fa fa-hand-o-left" aria-hidden="true"></i></span><b>EXPENSE REPORT</b></li>
                        </a>
                    </ul>
                </div>
            </div>
        </div>
    </div><br><br>
    <!-- <div class="row">
     <div class="col-lg-12">
      <div class="panel panel-default">
       <div class="panel-heading no-border clearfix">
        <center><h2 class="panel-title">SALE STATUS</h2></center>
       </div>
       
      </div>
     </div>
    </div> -->

@stop
