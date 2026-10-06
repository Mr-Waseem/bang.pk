@extends("app")
@section('head')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    /* Prevent FOUC: keep animated blocks hidden until CSS + boot ready */
    .fade-in-up, .fade-in-left, .scale-in { opacity: 0; }
</style>
@endsection
@section('contents')
@php
use App\Models\Setting;
use App\Models\Companies;
$company_detail = Setting::first();
$company = Companies::where('id', session()->get('company_id') )->first();
$isPraCompany = ($company->system_type ?? '') === 'PRA';
$isKpraCompany = ($company->system_type ?? '') === 'KPRA';
$linkAuthority = ($company->system_type ?? '') === 'SRB' ? 'SRB' : ($isKpraCompany ? 'KPRA' : ($isPraCompany ? 'PRA' : 'FBR'));
@endphp
<!-- session()->get('company_id')  -->
<!-- session()->get('company_id')  -->
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

{{-- <link  href="{{ URL::asset('css/sep/bootstrap.min.css') }}" rel="stylesheet"> --}}
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> --}}
<!--  <h1 class="page-title"><b>Dashboard</b></h1> -->
<style>
    /* ===== GLOBAL OVERFLOW & RESPONSIVE FIX ===== */
    html, body {
        overflow-x: hidden !important;
        max-width: 100vw !important;
        -webkit-overflow-scrolling: touch;
    }
    *, *::before, *::after {
        box-sizing: border-box;
    }
    /* Reduced motion preference */
    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }
    /* GPU acceleration hints for animated elements */
    .welcome-panel, .metric-card, .welcome-aurora, .welcome-canvas {
        will-change: auto;
    }
    .page-container,
    .main-container,
    .main-content {
        overflow-x: hidden;
        max-width: 100%;
    }
    /* Scope overflow-x only to dashboard's own .container-fluid, NOT the navbar's */
    .main-content .container-fluid {
        overflow-x: hidden;
        max-width: 100%;
    }
    .main-content {
        padding: 20px 15px !important;
    }
    /* Fix Bootstrap row negative margins causing overflow */
    .sales-dashboard .row {
        margin-left: 0;
        margin-right: 0;
    }
    .sales-dashboard .row > [class*="col-"] {
        padding-left: 8px;
        padding-right: 8px;
    }
    /* Fix page-container table layout overflow — keep below navbar z-index */
    .page-container {
        table-layout: fixed;
        width: 100% !important;
        max-width: 100vw !important;
        z-index: 1 !important;
    }
    .main-container {
        overflow-x: hidden !important;
        max-width: 100vw;
    }

    .bg-info {
        text-decoration: none;
        height: 160px;
        background: linear-gradient(to right, #BF953F, #FCF6BA, #B38728, #FBF5B7, #AA771C);
        margin-bottom: 30px;
    }

    .mt-3 {
        text-decoration: none;
        padding: 1.8em;
        font-size: 27px;
        color: black;
    }

    .font-weight-bold {
        text-decoration: none;
        color: black;
    }

    a:hover {
        text-decoration: none;
    }

    .panel-title {
        padding: 0.7em;
        height: 100px;
        font-size: 30px;
        /* margin-bottom: 10px; */

    }
</style>

<style>
    .wrimagecard {
        margin-top: 0;
        margin-bottom: 1.5rem;
        text-align: left;
        position: relative;
        background: #fff;
        box-shadow: 12px 15px 20px 0px rgba(46, 61, 73, 0.15);
        border-radius: 4px;
        transition: all 0.3s ease;
    }

    .wrimagecard .fa {
        position: relative;
        font-size: 70px;
    }

    .wrimagecard-topimage_header {
        padding: 20px;
    }

    a.wrimagecard:hover,
    .wrimagecard-topimage:hover {
        box-shadow: 2px 4px 8px 0px rgba(46, 61, 73, 0.2);
    }

    .wrimagecard-topimage a {
        width: 100%;
        height: 100%;
        display: block;
    }

    .wrimagecard-topimage_title {
        padding: 20px 24px;
        height: 80px;
        padding-bottom: 0.75rem;
        position: relative;
    }

    .wrimagecard-topimage a {
        border-bottom: none;
        text-decoration: none;
        color: #525c65;
        transition: color 0.3s ease;
    }
</style>
<div class="container-fluid">
    @if (Session::has('flash_message'))
    <div class="alert alert-success alert-dismissible fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right: 4%;">&times;</a>
        <strong>Success!</strong> {{ Session::get('flash_message') }}
    </div>
    @endif
    <div id="bulk-delete-flash"></div>
</div>

<div class="welcome-panel-container fade-in-up">
    <div class="welcome-panel">
        <canvas id="welcome-particles" class="welcome-canvas"></canvas>
        <div class="welcome-aurora"></div>
        <div class="welcome-noise"></div>
        <div class="welcome-header">
            <div class="welcome-user">
                <div class="user-avatar-wrap">
                    <div class="avatar-ring"></div>
                    <div class="avatar-ring avatar-ring-2"></div>
                    @if (Auth::user()->image != null)
                    <img src="{{ URL::asset('root/upload/users/' . Auth::user()->image) }}" class="avatar-image"
                        alt="User Avatar" />
                    @else
                    <img src="{{ URL::asset('root/upload/logo/userlogo.png') }}" class="avatar-image"
                        alt="Default Avatar" />
                    @endif
                    <div class="avatar-status"></div>
                </div>
                <div class="user-info">
                    <span class="welcome-text">Welcome back,</span>
                    <span class="user-name">{{Auth::User()->name}}</span>
                    <span class="user-role-badge"><i class="fa fa-shield"></i> {{ $CurrentUser->roles->first()->name ?? 'User' }}</span>
                </div>
            </div>

            <div class="welcome-center">
                <div class="live-clock-wrap">
                    <div class="clock-icon"><i class="fa fa-clock-o"></i></div>
                    <div class="clock-display">
                        <span class="clock-time" id="live-clock">--:--:--</span>
                        <span class="clock-date">{{ now()->format('l, d M Y') }}</span>
                    </div>
                </div>
            </div>

            <div class="welcome-right">
                <div class="company-info">
                    <div class="company-icon-wrap">
                        <i class="fa fa-building-o"></i>
                    </div>
                    <div>
                        <span class="company-label">Company</span>
                        <span class="company-name">{{ session()->get('company_name') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ===== PREMIUM FONT ===== */
    * { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }

    /* ===== GLOBAL ANIMATIONS ===== */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(28px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInLeft {
        from { opacity: 0; transform: translateX(-28px); }
        to   { opacity: 1; transform: translateX(0); }
    }
    @keyframes slideInScale {
        from { opacity: 0; transform: scale(0.92) translateY(16px); }
        to   { opacity: 1; transform: scale(1) translateY(0); }
    }
    @keyframes gradientShift {
        0%   { background-position: 0% 50%; }
        50%  { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50%      { transform: translateY(-6px); }
    }
    @keyframes shimmer {
        0%   { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
    @keyframes spinRing {
        0%   { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    @keyframes spinRingReverse {
        0%   { transform: rotate(360deg); }
        100% { transform: rotate(0deg); }
    }
    @keyframes auroraMove {
        0%   { transform: translateX(-30%) rotate(0deg) scale(1.2); opacity: 0.5; }
        33%  { transform: translateX(10%) rotate(120deg) scale(1.5); opacity: 0.35; }
        66%  { transform: translateX(-10%) rotate(240deg) scale(1.1); opacity: 0.55; }
        100% { transform: translateX(-30%) rotate(360deg) scale(1.2); opacity: 0.5; }
    }
    @keyframes borderGlow {
        0%, 100% { opacity: 0.5; filter: hue-rotate(0deg); }
        50%      { opacity: 1;   filter: hue-rotate(60deg); }
    }
    @keyframes statusPulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(46,204,113,0.6); }
        50%      { box-shadow: 0 0 0 5px rgba(46,204,113,0); }
    }
    @keyframes gradientBorderSpin {
        0%   { --angle: 0deg; }
        100% { --angle: 360deg; }
    }
    @keyframes ripple {
        0%   { transform: scale(0); opacity: 0.5; }
        100% { transform: scale(4); opacity: 0; }
    }

    .fade-in-up  { animation: none; opacity: 0; }
    .fade-in-left{ animation: none; opacity: 0; }
    .scale-in    { animation: none; opacity: 0; }
    html.app-ready .fade-in-up  { animation: fadeInUp 0.7s cubic-bezier(.22,1,.36,1) both; }
    html.app-ready .fade-in-left{ animation: fadeInLeft 0.7s cubic-bezier(.22,1,.36,1) both; }
    html.app-ready .scale-in    { animation: slideInScale 0.6s cubic-bezier(.22,1,.36,1) both; }

    /* ===== WELCOME PANEL ===== */
    .welcome-panel-container {
        margin-bottom: 32px;
    }

    .welcome-panel {
        position: relative;
        background: linear-gradient(135deg, #0a0e27 0%, #1a1a4e 25%, #16213e 50%, #0f3460 75%, #0a0e27 100%);
        background-size: 400% 400%;
        animation: gradientShift 15s ease infinite;
        border-radius: 20px;
        box-shadow:
            0 20px 60px rgba(10, 14, 39, 0.5),
            0 4px 16px rgba(0,0,0,0.15),
            inset 0 1px 0 rgba(255,255,255,0.08);
        padding: 32px 36px;
        color: white;
        overflow: hidden;
        border: 1px solid rgba(255,255,255,0.06);
        max-width: 100%;
    }

    .welcome-canvas {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: 0;
    }

    .welcome-aurora {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(ellipse at 20% 50%,
            rgba(99, 102, 241, 0.15) 0%,
            transparent 50%),
            radial-gradient(ellipse at 80% 50%,
            rgba(6, 182, 212, 0.12) 0%,
            transparent 50%),
            radial-gradient(ellipse at 50% 80%,
            rgba(168, 85, 247, 0.10) 0%,
            transparent 40%);
        animation: auroraMove 20s ease-in-out infinite;
        pointer-events: none;
        z-index: 0;
        overflow: hidden;
    }

    .welcome-noise {
        position: absolute;
        inset: 0;
        opacity: 0.03;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
        background-size: 200px;
        pointer-events: none;
        z-index: 0;
    }

    .welcome-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        position: relative;
        z-index: 1;
    }

    .welcome-user {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    /* Avatar with animated spinning rings */
    .user-avatar-wrap {
        position: relative;
        width: 76px;
        height: 76px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .avatar-ring {
        position: absolute;
        inset: -4px;
        border-radius: 50%;
        border: 2px solid transparent;
        border-top-color: rgba(99, 102, 241, 0.7);
        border-right-color: rgba(6, 182, 212, 0.4);
        animation: spinRing 3s linear infinite;
    }
    .avatar-ring-2 {
        inset: -9px;
        border-top-color: rgba(168, 85, 247, 0.5);
        border-right-color: transparent;
        border-left-color: rgba(59, 130, 246, 0.3);
        animation: spinRingReverse 4s linear infinite;
    }

    .avatar-image {
        width: 66px;
        height: 66px;
        border-radius: 50%;
        border: 3px solid rgba(255, 255, 255, 0.2);
        object-fit: cover;
        transition: all 0.5s cubic-bezier(.22,1,.36,1);
        box-shadow: 0 4px 24px rgba(0,0,0,0.35), 0 0 20px rgba(99,102,241,0.15);
        position: relative;
        z-index: 1;
    }
    .avatar-image:hover {
        border-color: rgba(99,102,241,0.6);
        transform: scale(1.08);
        box-shadow: 0 6px 32px rgba(99,102,241,0.35);
    }

    .avatar-status {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background: #22c55e;
        border: 2.5px solid #0a0e27;
        z-index: 2;
        animation: statusPulse 2s ease infinite;
    }

    .user-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .welcome-text {
        font-size: 12px;
        opacity: 0.55;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        font-weight: 500;
    }
    .user-name {
        font-size: 26px;
        font-weight: 800;
        letter-spacing: -0.5px;
        background: linear-gradient(135deg, #ffffff, #c7d2fe, #a5b4fc);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .user-role-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 11px;
        font-weight: 600;
        padding: 3px 12px;
        border-radius: 20px;
        background: linear-gradient(135deg, rgba(99,102,241,0.25), rgba(168,85,247,0.2));
        border: 1px solid rgba(99,102,241,0.3);
        color: #c7d2fe;
        width: fit-content;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .user-role-badge .fa {
        font-size: 10px;
        color: #a5b4fc;
    }

    /* Live clock */
    .welcome-center {
        display: flex;
        align-items: center;
    }
    .live-clock-wrap {
        display: flex;
        align-items: center;
        gap: 14px;
        background: rgba(255,255,255,0.04);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        padding: 14px 24px;
        border-radius: 16px;
        border: 1px solid rgba(255,255,255,0.08);
    }
    .clock-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(99,102,241,0.3), rgba(6,182,212,0.2));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #a5b4fc;
    }
    .clock-display {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .clock-time {
        font-size: 22px;
        font-weight: 800;
        letter-spacing: 1px;
        font-variant-numeric: tabular-nums;
        background: linear-gradient(135deg, #fff, #c7d2fe);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    .clock-date {
        font-size: 11px;
        opacity: 0.45;
        font-weight: 500;
    }

    .welcome-right {
        display: flex;
        align-items: center;
        gap: 14px;
    }
    .company-info {
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        padding: 14px 24px;
        border-radius: 16px;
        border: 1px solid rgba(255,255,255,0.08);
        display: flex;
        align-items: center;
        gap: 14px;
        transition: all 0.4s cubic-bezier(.22,1,.36,1);
    }
    .company-info:hover {
        background: rgba(255,255,255,0.1);
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.2), 0 0 20px rgba(99,102,241,0.1);
        border-color: rgba(99,102,241,0.2);
    }
    .company-icon-wrap {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: linear-gradient(135deg, rgba(168,85,247,0.3), rgba(99,102,241,0.2));
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #c4b5fd;
    }
    .company-info > div {
        display: flex;
        flex-direction: column;
    }
    .company-label {
        font-size: 10px;
        opacity: 0.45;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        font-weight: 600;
    }
    .company-name {
        font-size: 15px;
        font-weight: 700;
        color: #e0e7ff;
    }

    @media (max-width: 992px) {
        .welcome-center { display: none; }
    }
    @media (max-width: 768px) {
        .welcome-header {
            flex-direction: column;
            gap: 20px;
            text-align: center;
        }
        .welcome-user { flex-direction: column; }
        .welcome-panel { padding: 24px 20px; }
        .welcome-center { display: none; }
        .user-role-badge { margin: 0 auto; }
    }
    .section-label {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
        color: #f1f1f1 !important;
    }
</style>

<!-- <div class="container-fluid">
    <div class="row">
        <div class="col-md-3 col-sm-4">
            <div class="wrimagecard wrimagecard-topimage">
                <a href="{{ asset('products') }}">
                    <div class="wrimagecard-topimage_header" style="background-color:rgba(187, 120, 36, 0.1) ">
                        <center><i class="fa fa-cubes" style="color:#BB7824"></i></center>
                    </div>
                    <div class="wrimagecard-topimage_title text-center">
                        <h4>Products</h4>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-4">
            <div class="wrimagecard wrimagecard-topimage">
                <a href="{{ asset('parties') }}">
                    <div class="wrimagecard-topimage_header" style="background-color: rgba(22, 160, 133, 0.1)">
                        <center><i class="fa fa-users" style="color:#16A085"></i></center>
                    </div>
                    <div class="wrimagecard-topimage_title text-center">
                        <h4>Parties
                            <div class="pull-right badge" id="WrControls"></div>
                        </h4>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-md-3 col-sm-4">
            <div class="wrimagecard wrimagecard-topimage">
                <a href="{{ asset('sales/create') }}">
                    <div class="wrimagecard-topimage_header" style="background-color:  rgba(51, 105, 232, 0.1)">
                        <center><i class="fa fa-pencil-square-o " style="color:#3369e8"> </i></center>
                    </div>
                    <div class="wrimagecard-topimage_title text-center">
                        <h4>Add Sale
                            <div class="pull-right badge" id="WrGridSystem"></div>
                        </h4>
                    </div>

                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-4">
            <div class="wrimagecard wrimagecard-topimage">
                <a href="{{ asset('salestax/create') }}">
                    <div class="wrimagecard-topimage_header" style="background-color:  rgba(213, 15, 37, 0.1)">
                        <center><i class="fa fa-pencil-square-o" style="color:#d50f25"> </i></center>
                    </div>
                    <div class="wrimagecard-topimage_title text-center">
                        <h4>SalesTax Invoice
                            <div class="pull-right badge" id="WrForms"></div>
                        </h4>
                    </div>

                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-4">
            <div class="wrimagecard wrimagecard-topimage">
                <a href="{{ asset('cash-receipts/create') }}">
                    <div class="wrimagecard-topimage_header" style="background-color:  rgba(250, 188, 9, 0.1)">
                        <center><i class="fa fa-user" style="color:#fabc09"> </i></center>
                    </div>
                    <div class="wrimagecard-topimage_title text-center">
                        <h4>Cash Receipt
                            <div class="pull-right badge" id="WrInformation"></div>
                        </h4>
                    </div>

                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-4">
            <div class="wrimagecard wrimagecard-topimage">
                <a href="{{ asset('cash-payments/create') }}">
                    <div class="wrimagecard-topimage_header" style="background-color: rgba(121, 90, 71, 0.1)">
                        <center><i class="fa fa-table" style="color:#115480"> </i></center>
                    </div>
                    <div class="wrimagecard-topimage_title small-box bg-white text-center pt-4 pb-2">
                        <h4>Cash Payment
                            <div class="pull-right badge" id="WrNavigation"></div>
                        </h4>
                    </div>

                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-4">
            <div class="wrimagecard wrimagecard-topimage">
                <a href="{{ asset('purchases/create') }}">
                    <div class="wrimagecard-topimage_header" style="background-color: rgba(130, 93, 9, 0.1)">
                        <center><i class="fa fa-area-chart " style="color:#825d09"></i></center>
                    </div>
                    <div class="wrimagecard-topimage_title text-center">
                        <h4>Add Purchase
                            <div class="pull-right badge" id="WrThemesIcons"></div>
                        </h4>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-4">
            <div class="wrimagecard wrimagecard-topimage">
                <a href="{{ asset('purchase-tax/create') }}">
                    <div class="wrimagecard-topimage_header" style="background-color: rgba(130, 93, 9, 0.1)">
                        <center><i class="fa fa-magic" style="color:#825d09"></i></center>
                    </div>
                    <div class="wrimagecard-topimage_title text-center">
                        <h4>Add Purchase Tax
                            <div class="pull-right badge" id="WrThemesIcons"></div>
                        </h4>
                    </div>
                </a>
            </div>
        </div>

    </div>
</div> -->
@if(Session::has('error'))
<div class="alert alert-danger">
    <strong>Error!</strong> {{ Session::get('error') }}
    @if(Session::has('error_details'))
    <br>Details: {{ Session::get('error_details') }}
    @endif
    @if(Session::has('error'))
    <br>Code: {{ Session::get('error') }}
    @endif
</div>
@endif

@if(request()->has('error'))
<div class="alert alert-danger alert-dismissible show">
    Sale Invoice could not be Submitted. Check HS Code, Product Name, Party CNIC / NTN etc.
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

{{-- Add this new section for validation response errors --}}
@if(isset($responseData) && isset($responseData['validationResponse']) && $responseData['validationResponse']['statusCode'] !== '00')
@php
$validationResponse = $responseData['validationResponse'];
$statusCode = $validationResponse['statusCode'] ?? 'Unknown';
$status = $validationResponse['status'] ?? 'Error';
@endphp

<div class="alert alert-danger alert-dismissible show">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>

    <h5 class="alert-heading">Validation Error!</h5>
    <p class="mb-2"><strong>Code:</strong> {{ $statusCode }} | <strong>Status:</strong> {{ $status }}uuuuuuu</p>

    @if(isset($validationResponse['invoiceStatuses']) && is_array($validationResponse['invoiceStatuses']))
    <hr>
    <h6>Detailed Errors:</h6>
    <ul class="mb-0 pl-3">
        @foreach($validationResponse['invoiceStatuses'] as $error)
        <li>
            <strong>Item {{ $error['itemSNo'] ?? '' }}:</strong>
            {{ $error['error'] ?? 'Unknown error' }}
            @if(isset($error['errorCode']))
            (Error Code: {{ $error['errorCode'] }})kkkkkkkk
            @endif
        </li>
        @endforeach
    </ul>
    @elseif(isset($validationResponse['error']) && !empty($validationResponse['error']))
    <hr>
    <p class="mb-0"><strong>Error:</strong> {{ $validationResponse['error'] }}jjjjjjj</p>
    @endif
</div>
@endif

{{-- Optional: Success message for validation --}}
@if(isset($responseData) && isset($responseData['validationResponse']) && $responseData['validationResponse']['statusCode'] === '00')
<div class="alert alert-success alert-dismissible show">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <strong>Success!</strong> Validation completed successfully.
</div>
@endif
@include('errors.validation')
@php
    $currentUserRole = $CurrentUser->roles->first();
@endphp
@if($currentUserRole && $currentUserRole->name == "Admin")
<div class="sales-dashboard">
    <!-- Section: Today -->
    <div class="section-label fade-in-left"><i class="fa fa-sun-o"></i> Today's Overview</div>
    <div class="row summary-cards">
        <div class="col-md-3 scale-in" style="animation-delay:.1s">
            <div class="metric-card sales tilt-card">
                <div class="card-glow"></div>
                <div class="card-icon"><i class="fa fa-line-chart"></i></div>
                <div class="card-content">
                    <h3>Total Sales</h3>
                    <div class="amount counter" data-target="{{$todayexclusive}}">{{number_format($todayexclusive)}}</div>
                    <div class="compare"><span class="period-badge">Today</span></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 scale-in" style="animation-delay:.2s">
            <div class="metric-card tax tilt-card">
                <div class="card-glow"></div>
                <div class="card-icon"><i class="fa fa-percent"></i></div>
                <div class="card-content">
                    <h3>Total Tax</h3>
                    <div class="amount counter" data-target="{{$todayTax}}">{{number_format($todayTax)}}</div>
                    <div class="compare"><span class="period-badge">Today</span></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 scale-in" style="animation-delay:.3s">
            <div class="metric-card extra tilt-card">
                <div class="card-glow"></div>
                <div class="card-icon"><i class="fa fa-plus-circle"></i></div>
                <div class="card-content">
                    <h3>Further & Extra Tax</h3>
                    {{-- <div class="amount">{{number_format($todaySale-$todayexclusive-$todayTax)}}</div> --}}
                    <div class="amount counter">{{ number_format($todayExtraTax) }}</div>
                    <div class="compare"><span class="period-badge">Today</span></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 scale-in" style="animation-delay:.4s">
            <div class="metric-card returns tilt-card">
                <div class="card-glow"></div>
                <div class="card-icon"><i class="fa fa-money"></i></div>
                <div class="card-content">
                    <h3>Sale Amount</h3>
                    <div class="amount counter" data-target="{{$todaySale}}">{{number_format($todaySale)}}</div>
                    <div class="compare"><span class="period-badge">Today</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="sales-dashboard">
    @if($company->type != "Invoice Only")
    <div class="section-label fade-in-left" style="animation-delay:.15s"><i class="fa fa-shopping-cart"></i> Purchase Overview — Current Month</div>
    <div class="row summary-cards">
        <div class="col-md-4 scale-in" style="animation-delay:.2s">
            <div class="metric-card purchase tilt-card">
                <div class="card-glow"></div>
                <div class="card-icon"><i class="fa fa-truck"></i></div>
                <div class="card-content">
                    <h3>Total Purchase</h3>
                    <div class="amount counter" data-target="{{$currentMonthPurchase-$currentMonthPurchaseTax}}">{{number_format($currentMonthPurchase-$currentMonthPurchaseTax)}}</div>
                    <div class="compare"><span class="period-badge month">This Month</span></div>
                </div>
            </div>
        </div>
        <div class="col-md-4 scale-in" style="animation-delay:.3s">
            <div class="metric-card tax tilt-card">
                <div class="card-glow"></div>
                <div class="card-icon"><i class="fa fa-percent"></i></div>
                <div class="card-content">
                    <h3>Purchase Tax</h3>
                    <div class="amount counter" data-target="{{$currentMonthPurchaseTax}}">{{number_format($currentMonthPurchaseTax)}}</div>
                    <div class="compare"><span class="period-badge month">This Month</span></div>
                </div>
            </div>
        </div>
        <div class="col-md-4 scale-in" style="animation-delay:.4s">
            <div class="metric-card returns tilt-card">
                <div class="card-glow"></div>
                <div class="card-icon"><i class="fa fa-archive"></i></div>
                <div class="card-content">
                    <h3>Purchase Amount</h3>
                    <div class="amount counter" data-target="{{$currentMonthPurchase}}">{{number_format($currentMonthPurchase)}}</div>
                    <div class="compare"><span class="period-badge month">This Month</span></div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="section-label fade-in-left" style="animation-delay:.2s"><i class="fa fa-calendar"></i> Sales Overview — Current Month</div>
    <div class="row summary-cards">
        <div class="col-md-3 scale-in" style="animation-delay:.25s">
            <div class="metric-card sales tilt-card">
                <div class="card-glow"></div>
                <div class="card-icon"><i class="fa fa-line-chart"></i></div>
                <div class="card-content">
                    <h3>Total Sales</h3>
                    <div class="amount counter" data-target="{{$currentMonthexclusive}}">{{number_format($currentMonthexclusive)}}</div>
                    <div class="compare"><span class="period-badge month">This Month</span></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 scale-in" style="animation-delay:.35s">
            <div class="metric-card tax tilt-card">
                <div class="card-glow"></div>
                <div class="card-icon"><i class="fa fa-percent"></i></div>
                <div class="card-content">
                    <h3>Total Tax</h3>
                    <div class="amount counter" data-target="{{$currentMonthTax}}">{{number_format($currentMonthTax)}}</div>
                    <div class="compare"><span class="period-badge month">This Month</span></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 scale-in" style="animation-delay:.45s">
            <div class="metric-card extra tilt-card">
                <div class="card-glow"></div>
                <div class="card-icon"><i class="fa fa-plus-circle"></i></div>
                <div class="card-content">
                    <h3>Further & Extra Tax</h3>
                    {{-- <div class="amount counter">{{number_format($currentMonthSale-$currentMonthexclusive-$currentMonthTax)}}</div> --}}
                    <div class="amount counter">{{ number_format($currentMonthExtraTax) }}</div>
                    <div class="compare"><span class="period-badge month">This Month</span></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 scale-in" style="animation-delay:.55s">
            <div class="metric-card returns tilt-card">
                <div class="card-glow"></div>
                <div class="card-icon"><i class="fa fa-money"></i></div>
                <div class="card-content">
                    <h3>Total Amount</h3>
                    <div class="amount counter" data-target="{{$currentMonthSale}}">{{number_format($currentMonthSale)}}</div>
                    <div class="compare"><span class="period-badge month">This Month</span></div>
                </div>
            </div>
        </div>
    </div>

    <div class="sales-table-container scale-in" style="animation-delay:.3s">
        <div class="table-header">
            <div class="table-title-wrap">
                <h3 class="table-title"><i class="fa fa-clock-o"></i> Unapproved Invoices</h3>
                <span class="table-subtitle">Pending {{ $linkAuthority }} linkage — select and manage in bulk</span>
            </div>
            <div class="table-actions">
                <div class="table-search">
                    <i class="fa fa-search"></i>
                    <input type="text" id="unapproved-search" placeholder="Search invoices, customer, amount...">
                </div>
                <button type="button" class="bulk-delete-btn" onclick="confirmBulkDelete()">
                    <i class="fa fa-trash"></i>
                    Bulk Delete
                </button>
                <button type="button" class="bulk-delete-btn" style="background:linear-gradient(135deg,#22c55e,#16a34a);border-color:rgba(22,163,74,0.3);" onclick="confirmBulkApprove()">
                    <i class="fa fa-link"></i>
                    Bulk Link to {{ $linkAuthority }}
                </button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="sales-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Inv#</th>
                        <th>Type</th>
                        <th>Customer</th>
                        <th class="text-right">Amount</th>
                        <th class="text-right">Tax</th>
                        <th>Actions</th>
                        <th>Approve</th>
                        <th class="text-center">Created By</th>
                        <th class="text-center">
                            <span class="select-all-text">Select All</span>
                            <label class="select-all-wrap" title="Select all">
                                <input type="checkbox" id="select-all-unapproved" class="select-all-checkbox" />
                                <span class="checkmark"></span>
                            </label>
                        </th>
                    </tr>
                </thead>
                @if(count($unapproved) > 0)
                <tbody>
                    @php $totalamount = 0; $totalTax = 0; @endphp
                    @php
                        $isPosCompany = in_array($company->system_type ?? '', ['POS', 'PRA', 'KPRA', 'SRB'], true);
                    @endphp
                    @foreach($unapproved as $invoice)
                    <tr>
                        <td>{{ date('d/m/Y', strtotime($invoice->date)) }}</td>
                        <td>{{$company->invoiceno_prefix}}{{ $invoice->invoice_no }}
                        </td>
                        <td class="type-badge-cell">
                            @if($invoice->sale_type == "SalesTax Invoice")
                            <span class="status completed"><i class="fa fa-file-text-o"></i>{{ $invoice->sale_type }}</span>
                            @else
                            <span class="status" style="background:linear-gradient(135deg,#fef3c7,#fde68a);color:#92400e;border-color:rgba(217,119,6,0.25);"><i class="fa fa-file-o"></i>{{ $invoice->sale_type }}</span>
                            @endif
                        </td>
                        <td>{{ $invoice->party_name }}</td>
                        <td style="text-align: right;">{{ number_format($invoice->grand_total) }}</td>
                        <td style="text-align: right;">{{ number_format($invoice->total_tax) }}</td>
                        @if($invoice->sale_type == "SalesTax Invoice")
                            @php
                                $salesTaxRoute = $isPosCompany ? 'pos-salestax' : 'salestax';
                                $approveUrl = $isPosCompany
                                    ? asset('pos-salestax/approved/sale-invoice')
                                    : asset('salestax/approved/sale-invoice');
                            @endphp
                        <td>
                            <div class="action-btn-group">
                                @if($isPosCompany)
                                    <a href="{{ asset($salesTaxRoute . '/print/' . $invoice->id) }}" target="__blank"><span class="status info"><i class="fa fa-eye"></i> View</span></a>
                                @else
                                    <a href="{{ asset($salesTaxRoute . '/' . $invoice->id) }}" target="__blank"><span class="status info"><i class="fa fa-eye"></i> View</span></a>
                                @endif
                                <button type="button" class="status mail js-email-invoice"
                                    data-url="{{ asset($salesTaxRoute . '/' . $invoice->id . '/email') }}"
                                    data-invoice="{{ $invoice->invoice_no }}"
                                    title="Email Invoice">
                                    <i class="fa fa-envelope"></i> Mail
                                </button>
                                <a href="{{ asset($salesTaxRoute . '/' . $invoice->id . '/edit') }}" target="__blank"><span class="status pending"><i class="fa fa-pencil"></i> Edit</span></a>
                                <a href="{{ asset($salesTaxRoute . '/' . $invoice->id . '/destroy') }}" onclick="confirmActiondel(event)"><span class="status returned"><i class="fa fa-trash-o"></i> Del</span></a>
                            </div>
                        </td>

                        <td class="approve-cell">
                            <form action="{{ $approveUrl }}" method="POST" style="display:inline-flex;">
                                @csrf
                                <input type="hidden" id="invoice_id" name="invoice_id" value="{{ $invoice->id }}">
                                <!-- <a href="{{ asset('salestax/approved') }}/{{ $invoice->id }}" onclick="confirmAction(event)"><span class="status fbr">Link to FBR</span></a> -->
                                <button type="submit" class="status fbr" onclick="return confirmFormAction(event)"><i class="fa fa-link"></i>Link to {{ $linkAuthority }}</button>
                            </form>
                        </td>
                        @else
                        <td>
                            <div class="action-btn-group">
                                <a href="{{ asset('debit-note') }}/{{ $invoice->id }}" target="__blank"><span class="status info"><i class="fa fa-eye"></i> View</span></a>
                                <a href="{{ asset('debit-note/' . $invoice->id . '/edit') }}" target="__blank"><span class="status pending"><i class="fa fa-pencil"></i> Edit</span></a>
                                <a href="{{ asset('debit-note/' . $invoice->id . '/destroy') }}" onclick="confirmActiondel(event)"><span class="status returned"><i class="fa fa-trash-o"></i> Del</span></a>
                            </div>
                        </td>

                        <td class="approve-cell">
                            @php
                                $isPosCompany = in_array($company->system_type ?? '', ['POS', 'PRA', 'KPRA', 'SRB'], true);
                                $approveUrl = ($isPosCompany && $invoice->sale_type == 'SalesTax Invoice')
                                    ? asset('pos-salestax/approved/sale-invoice')
                                    : asset('salestax/approved/sale-invoice');
                            @endphp
                            <form action="{{ $approveUrl }}" method="POST" style="display:inline-flex;">
                                @csrf
                                <input type="hidden" id="invoice_id" name="invoice_id" value="{{ $invoice->id }}">
                                <!-- <a href="{{ asset('salestax/approved') }}/{{ $invoice->id }}" onclick="confirmAction(event)"><span class="status fbr">Link to FBR</span></a> -->
                                <button type="submit" class="status fbr" onclick="return confirmFormAction(event)"><i class="fa fa-link"></i>Link to {{ $linkAuthority }}</button>
                            </form>
                        </td>

                        @endif
                        <td class="text-center">
                            <span>{{ $invoice->biller_name }}</span>
                        </td>
                        <td class="checkbox-cell">
                            <label class="row-select-wrap" title="Select for bulk delete">
                                <input type="checkbox" class="bulk-delete-checkbox"
                                    data-id="{{ $invoice->id }}"
                                    data-type="{{ $invoice->sale_type == 'SalesTax Invoice' ? (in_array($company->system_type ?? '', ['POS','PRA','KPRA','SRB']) ? 'pos-salestax' : 'salestax') : 'debit-note' }}" />
                                <span class="checkmark"></span>
                            </label>
                        </td>
                    </tr>
                    @php
                    $totalamount += $invoice->grand_total;
                    $totalTax += $invoice->total_tax;
                    @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4"><strong>Total:</strong></td>
                        <td style="text-align: right;"><strong>{{number_format($totalamount)}}</strong></td>
                        <td style="text-align: right;"><strong>{{number_format($totalTax)}}</strong></td>
                        <td colspan="4"></td>
                    </tr>
                </tfoot>
                @else
                <tbody>
                    <tr>
                        <td class="text-center" colspan="10">No Records Found!</td>
                    </tr>
                </tbody>
                @endif
            </table>
        </div>
        <div class="table-empty" id="unapproved-empty" style="display:none;">No matching invoices found.</div>
    </div>
    <div class="sales-table-container scale-in" style="animation-delay:.4s">
        <h3 class="table-title"><i class="fa fa-bar-chart"></i> Today Sales Breakdown</h3>
        <div class="table-responsive">
            <table class="sales-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Invoice #</th>
                        <th>Customer</th>
                        <th class="text-right">Amount</th>
                        <th class="text-right">Tax</th>
                        <th class="text-right">Actions</th>
                        <th class="text-right">Created By</th>
                    </tr>
                </thead>
                @if(count($saleinvoices) > 0)
                <tbody>
                    @php $totalamount = 0; $totalTax = 0; @endphp
                    @php
                        $isPosCompany = in_array($company->system_type ?? '', ['POS', 'PRA', 'KPRA', 'SRB'], true);
                        $salesTaxRoute = $isPosCompany ? 'pos-salestax' : 'salestax';
                    @endphp
                    @foreach($saleinvoices as $invoice)
                    <tr>
                        <td>{{ date('d/m/Y', strtotime($invoice->date)) }}</td>
                        <td>{{ $invoice->invoice_no }}
                        </td>
                        <td>{{ $invoice->party_name }}</td>
                        <td style="text-align: right;">{{ number_format($invoice->grand_total) }}</td>
                        <td style="text-align: right;">{{ number_format($invoice->total_tax) }}</td>
                        <td>
                            @if($isPosCompany)
                                <a href="{{ asset($salesTaxRoute . '/print/' . $invoice->id) }}" target="__blank"><span class="status completed">view</span></a>
                            @else
                                <a href="{{ asset($salesTaxRoute . '/' . $invoice->id) }}" target="__blank"><span class="status completed">view</span></a>
                            @endif
                        </td>
                        <td>{{ $invoice->biller_name }}</td>
                    </tr>
                    @php
                    $totalamount += $invoice->grand_total;
                    $totalTax += $invoice->total_tax;
                    @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><strong>Total:</strong></td>
                        <td style="text-align: right;"><strong>{{number_format($totalamount)}}</strong></td>
                        <td style="text-align: right;"><strong>{{number_format($totalTax)}}</strong></td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
                @else
                <tbody>
                    <tr>
                        <td class="text-center" colspan="7">No Records Found!</td>
                    </tr>
                </tbody>
                @endif
            </table>
        </div>
    </div>
    @endif
</div>

<style>
    /* ===== DASHBOARD LAYOUT ===== */
    .sales-dashboard {
        padding: 0 0 10px;
        background-color: transparent;
    }

    /* ===== SECTION LABELS (PREMIUM) ===== */
    .section-label {
        font-size: 14px;
        font-weight: 700;
        color: #1a2942;
        margin-bottom: 20px;
        padding: 12px 20px;
        background: linear-gradient(135deg, rgba(99,102,241,0.06), rgba(6,182,212,0.04), rgba(168,85,247,0.03));
        border-left: 4px solid transparent;
        border-image: linear-gradient(180deg, #6366f1, #06b6d4) 1;
        border-radius: 0 14px 14px 0;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        position: relative;
        overflow: hidden;
    }
    .section-label::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(99,102,241,0.08), transparent);
        animation: shimmer 3s ease-in-out infinite;
    }
    .section-label .fa {
        color: #6366f1;
        font-size: 15px;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: linear-gradient(135deg, rgba(99,102,241,0.12), rgba(6,182,212,0.08));
    }

    /* ===== SUMMARY CARDS ===== */
    .summary-cards {
        margin-bottom: 28px;
    }
    .summary-cards [class*="col-"] {
        margin-bottom: 16px;
    }

    /* --- 3D Tilt Card --- */
    .tilt-card {
        transform-style: preserve-3d;
        perspective: 800px;
        will-change: transform;
    }

    /* Animated gradient border wrapper */
    .metric-card {
        background: rgba(255,255,255,0.9);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: 18px;
        padding: 24px 22px;
        box-shadow:
            0 4px 30px rgba(0,0,0,0.06),
            0 1px 3px rgba(0,0,0,0.04),
            inset 0 1px 0 rgba(255,255,255,0.8);
        border: 1px solid rgba(255,255,255,0.6);
        display: flex;
        align-items: center;
        height: 100%;
        position: relative;
        overflow: hidden;
        transition: all 0.45s cubic-bezier(.22,1,.36,1);
    }
    .metric-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        opacity: 0.04;
        transition: all 0.5s ease;
        pointer-events: none;
    }
    .metric-card:hover {
        transform: translateY(-8px);
        box-shadow:
            0 20px 50px rgba(0,0,0,0.10),
            0 8px 20px rgba(0,0,0,0.06),
            inset 0 1px 0 rgba(255,255,255,0.9);
    }
    .metric-card:hover::before {
        opacity: 0.08;
        transform: scale(1.3);
    }

    /* Card glow effect on hover - upgraded */
    .card-glow {
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle at 30% 30%, rgba(99,102,241,0.08), transparent 60%);
        opacity: 0;
        transition: opacity 0.5s ease;
        pointer-events: none;
    }
    .metric-card:hover .card-glow {
        opacity: 1;
    }

    /* Sparkline decoration */
    .metric-card .card-sparkline {
        position: absolute;
        bottom: 8px;
        right: 12px;
        opacity: 0.08;
        transition: opacity 0.4s ease;
    }
    .metric-card:hover .card-sparkline {
        opacity: 0.15;
    }

    /* Card type borders - gradient left accent */
    .metric-card.sales {
        border-left: 4px solid #22c55e;
        border-top: none;
    }
    .metric-card.sales::before { background: radial-gradient(circle, #22c55e, transparent 70%); }

    .metric-card.tax {
        border-left: 4px solid #6366f1;
        border-top: none;
    }
    .metric-card.tax::before { background: radial-gradient(circle, #6366f1, transparent 70%); }

    .metric-card.extra {
        border-left: 4px solid #a855f7;
        border-top: none;
    }
    .metric-card.extra::before { background: radial-gradient(circle, #a855f7, transparent 70%); }

    .metric-card.returns {
        border-left: 4px solid #ef4444;
        border-top: none;
    }
    .metric-card.returns::before { background: radial-gradient(circle, #ef4444, transparent 70%); }

    .metric-card.purchase {
        border-left: 4px solid #f59e0b;
        border-top: none;
    }
    .metric-card.purchase::before { background: radial-gradient(circle, #f59e0b, transparent 70%); }

    /* Icon - upgraded with depth */
    .card-icon {
        width: 56px;
        height: 56px;
        min-width: 56px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 18px;
        font-size: 22px;
        color: white;
        position: relative;
        transition: all 0.45s cubic-bezier(.22,1,.36,1);
    }
    .metric-card:hover .card-icon {
        transform: scale(1.15) rotate(-6deg);
        box-shadow: 0 10px 28px var(--icon-shadow-color, rgba(0,0,0,0.2));
    }
    .metric-card.sales .card-icon {
        background: linear-gradient(145deg, #22c55e, #16a34a);
        box-shadow: 0 8px 22px rgba(34,197,94,0.35);
        --icon-shadow-color: rgba(34,197,94,0.45);
    }
    .metric-card.tax .card-icon {
        background: linear-gradient(145deg, #6366f1, #4f46e5);
        box-shadow: 0 8px 22px rgba(99,102,241,0.35);
        --icon-shadow-color: rgba(99,102,241,0.45);
    }
    .metric-card.extra .card-icon {
        background: linear-gradient(145deg, #a855f7, #9333ea);
        box-shadow: 0 8px 22px rgba(168,85,247,0.35);
        --icon-shadow-color: rgba(168,85,247,0.45);
    }
    .metric-card.returns .card-icon {
        background: linear-gradient(145deg, #ef4444, #dc2626);
        box-shadow: 0 8px 22px rgba(239,68,68,0.35);
        --icon-shadow-color: rgba(239,68,68,0.45);
    }
    .metric-card.purchase .card-icon {
        background: linear-gradient(145deg, #f59e0b, #d97706);
        box-shadow: 0 8px 22px rgba(245,158,11,0.35);
        --icon-shadow-color: rgba(245,158,11,0.45);
    }
    .card-icon .fa {
        animation: float 3s ease-in-out infinite;
        filter: drop-shadow(0 2px 3px rgba(0,0,0,0.2));
    }

    /* Card content */
    .card-content h3 {
        margin: 0 0 6px 0;
        font-size: 12px;
        color: #94a3b8;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }
    .amount {
        font-size: 28px;
        font-weight: 800;
        margin-bottom: 8px;
        color: #0f172a;
        letter-spacing: -0.5px;
        line-height: 1.1;
    }
    .compare {
        font-size: 12px;
        color: #94a3b8;
    }
    .period-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 20px;
        background: linear-gradient(135deg, rgba(99,102,241,0.08), rgba(6,182,212,0.06));
        color: #6366f1;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.3px;
    }
    .period-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #6366f1;
        animation: statusPulse 2s ease infinite;
    }
    .period-badge.month {
        background: linear-gradient(135deg, rgba(168,85,247,0.08), rgba(99,102,241,0.06));
        color: #a855f7;
    }
    .period-badge.month::before {
        background: #a855f7;
    }

    /* ===== TABLE CONTAINER (PREMIUM) ===== */
    .sales-table-container {
        background: rgba(255,255,255,0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border-radius: 20px;
        border: 1px solid rgba(255,255,255,0.6);
        box-shadow:
            0 4px 30px rgba(0,0,0,0.06),
            0 1px 3px rgba(0,0,0,0.03);
        padding: 28px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
        max-width: 100%;
    }
    .sales-table-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #6366f1, #06b6d4, #a855f7, #22c55e);
        background-size: 300% 100%;
        animation: gradientShift 4s ease infinite;
    }

    .table-title {
        color: #0f172a;
        margin-bottom: 16px;
        padding-bottom: 14px;
        border-bottom: 2px solid transparent;
        border-image: linear-gradient(to right, #6366f1, #06b6d4, transparent) 1;
        font-size: 17px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .table-title .fa {
        color: #6366f1;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: linear-gradient(135deg, rgba(99,102,241,0.1), rgba(6,182,212,0.06));
    }

    .sales-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: white;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 2px 16px rgba(0,0,0,0.04);
    }

    .sales-table thead {
        position: sticky;
        top: 0;
        z-index: 2;
    }

    .sales-table th {
        background: linear-gradient(135deg, #0f172a, #1e293b);
        color: #e2e8f0;
        padding: 14px 16px;
        text-align: left;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 1px;
        border-bottom: 2px solid #6366f1;
    }
    .sales-table th:first-child {
        border-radius: 14px 0 0 0;
    }
    .sales-table th:last-child {
        border-radius: 0 14px 0 0;
    }

    .table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .table-title-wrap {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .table-subtitle {
        font-size: 12px;
        color: #64748b;
        font-weight: 500;
    }

    .table-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .table-search {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 11px 18px;
        background: rgba(255,255,255,0.95);
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
        color: #94a3b8;
        transition: all 0.35s cubic-bezier(.22,1,.36,1);
    }
    .table-search:focus-within {
        border-color: #6366f1;
        box-shadow: 0 4px 24px rgba(99,102,241,0.12), 0 0 0 3px rgba(99,102,241,0.08);
        transform: translateY(-1px);
    }
    .table-search .fa { font-size: 14px; }
    .table-search input {
        border: none;
        outline: none;
        font-size: 13px;
        color: #0f172a;
        min-width: 230px;
        background: transparent;
        font-weight: 500;
    }
    .table-search input::placeholder {
        color: #cbd5e1;
        font-weight: 400;
    }

    .bulk-delete-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: 1.5px solid #fecaca;
        background: linear-gradient(135deg, #fff5f5, #fef2f2);
        color: #dc2626;
        padding: 11px 18px;
        border-radius: 14px;
        font-weight: 700;
        font-size: 13px;
        transition: all 0.35s cubic-bezier(.22,1,.36,1);
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(239, 68, 68, 0.08);
    }
    .bulk-delete-btn:hover {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        transform: translateY(-2px);
        box-shadow: 0 8px 28px rgba(239, 68, 68, 0.16);
        border-color: #fca5a5;
    }
    .bulk-delete-btn:active {
        transform: translateY(0);
    }

    /* Checkboxes - upgraded */
    .select-all-checkbox,
    .bulk-delete-checkbox {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }
    .select-all-wrap,
    .row-select-wrap {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        border-radius: 6px;
        background: rgba(255,255,255,0.15);
        border: 1.5px solid rgba(255,255,255,0.3);
        cursor: pointer;
        transition: all 0.3s cubic-bezier(.22,1,.36,1);
    }
    .row-select-wrap {
        background: #f1f5f9;
        border-color: #e2e8f0;
    }
    .select-all-wrap:hover,
    .row-select-wrap:hover {
        border-color: #6366f1;
        box-shadow: 0 4px 14px rgba(99,102,241,0.18);
        transform: scale(1.1);
    }
    .checkmark {
        width: 12px;
        height: 12px;
        border-radius: 3px;
        background: transparent;
        transition: all 0.25s ease;
    }
    .select-all-checkbox:checked + .checkmark,
    .bulk-delete-checkbox:checked + .checkmark {
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        box-shadow: inset 0 0 0 2px #fff, 0 2px 8px rgba(99,102,241,0.3);
    }
    .select-all-text {
        margin-right: 8px;
        font-size: 11px;
        font-weight: 600;
        color: #e2e8f0;
        text-transform: none;
    }

    .created-by-cell {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        text-align: center;
    }
    .checkbox-cell {
        text-align: center;
    }

    /* Table rows - premium hover */
    .sales-table td {
        padding: 13px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 13px;
        transition: all 0.25s ease;
        font-weight: 450;
    }
    .sales-table tbody tr {
        transition: all 0.3s cubic-bezier(.22,1,.36,1);
    }
    .sales-table tbody tr:hover {
        background: linear-gradient(135deg, rgba(99,102,241,0.03), rgba(6,182,212,0.02));
        transform: scale(1.003);
        box-shadow: 0 2px 12px rgba(99,102,241,0.06);
    }
    .sales-table tbody tr:nth-child(even) {
        background: rgba(248,250,252,0.5);
    }
    .sales-table tbody tr:nth-child(even):hover {
        background: linear-gradient(135deg, rgba(99,102,241,0.04), rgba(6,182,212,0.03));
    }
    .sales-table tbody tr:last-child td {
        border-bottom: none;
    }

    .sales-table tfoot {
        background: linear-gradient(135deg, #f8fafc, #eef2ff);
        font-weight: 700;
    }
    .sales-table tfoot td {
        padding: 16px;
        font-size: 14px;
        color: #0f172a;
        border-top: 2px solid #e2e8f0;
    }

    .text-right { text-align: right; }

    /* Status badges - premium pill style */
    .status {
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.3px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        transition: all 0.3s cubic-bezier(.22,1,.36,1);
        cursor: pointer;
        text-transform: uppercase;
        position: relative;
        white-space: nowrap;
        line-height: 1.4;
        border: 1px solid transparent;
    }
    .status:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        filter: brightness(1.05);
    }
    .status:active {
        transform: translateY(0);
    }

    .status.completed {
        background: linear-gradient(135deg, #dcfce7, #bbf7d0);
        color: #15803d;
        border-color: rgba(34,197,94,0.25);
        box-shadow: 0 1px 4px rgba(34,197,94,0.15);
    }
    .status.pending {
        background: linear-gradient(135deg, #fef9c3, #fde68a);
        color: #92400e;
        border-color: rgba(245,158,11,0.25);
        box-shadow: 0 1px 4px rgba(245,158,11,0.15);
    }
    .status.returned {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #b91c1c;
        border-color: rgba(239,68,68,0.25);
        box-shadow: 0 1px 4px rgba(239,68,68,0.15);
    }
    .status.fbr {
        background: linear-gradient(135deg, #ede9fe, #ddd6fe);
        color: #6d28d9;
        border: 1px solid rgba(139,92,246,0.3);
        box-shadow: 0 1px 4px rgba(139,92,246,0.15);
        font-size: 10px;
    }
    .status.fbr:hover {
        background: linear-gradient(135deg, #ddd6fe, #c4b5fd);
        box-shadow: 0 4px 14px rgba(139,92,246,0.25);
    }
    .status.info {
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        color: #1e40af;
        border-color: rgba(59,130,246,0.25);
        box-shadow: 0 1px 4px rgba(59,130,246,0.15);
    }
    .status.mail {
        background: linear-gradient(135deg, #dcfce7, #bbf7d0);
        color: #166534;
        border: 1px solid rgba(22,163,74,0.28);
        box-shadow: 0 1px 4px rgba(22,163,74,0.15);
        cursor: pointer;
        font-family: inherit;
        appearance: none;
        -webkit-appearance: none;
    }
    .status.mail:hover {
        background: linear-gradient(135deg, #bbf7d0, #86efac);
        box-shadow: 0 4px 14px rgba(22,163,74,0.25);
    }

    /* ===== ACTION BUTTONS GROUP - Keep in one row ===== */
    .action-btn-group {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        flex-wrap: nowrap;
        white-space: nowrap;
    }
    .action-btn-group .status {
        padding: 4px 8px;
        font-size: 9px;
        border-radius: 5px;
        min-width: 0;
    }

    /* Type badge - no wrap */
    .type-badge-cell {
        white-space: nowrap;
    }
    .type-badge-cell .status {
        font-size: 9px;
        padding: 4px 8px;
        white-space: nowrap;
    }

    /* Approve cell */
    .approve-cell {
        white-space: nowrap;
    }
    .approve-cell .status.fbr {
        white-space: nowrap;
        padding: 5px 10px;
    }

    .table-empty {
        text-align: center;
        padding: 28px;
        color: #94a3b8;
        font-size: 14px;
        font-weight: 500;
    }

    /* ===== CUSTOM SCROLLBAR ===== */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        width: 100%;
    }
    .table-responsive::-webkit-scrollbar {
        height: 6px;
    }
    .table-responsive::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }
    .table-responsive::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #6366f1, #06b6d4);
        border-radius: 3px;
    }

    /* ===== RESPONSIVE - ALL SCREENS ===== */
    
    /* Extra large screens (1400px+) */
    @media (min-width: 1400px) {
        .main-content {
            padding: 30px 25px !important;
        }
        .welcome-panel {
            padding: 36px 40px;
        }
    }

    /* Large tablets / small desktops (992-1199px) */
    @media (max-width: 1199px) {
        .summary-cards .col-md-3 {
            width: 50%;
            float: left;
        }
        .summary-cards .col-md-4 {
            width: 50%;
            float: left;
        }
        .amount {
            font-size: 22px;
        }
        .card-content h3 {
            font-size: 11px;
        }
        .card-icon {
            width: 48px;
            height: 48px;
            min-width: 48px;
            font-size: 20px;
            margin-right: 14px;
        }
        .welcome-panel {
            padding: 24px 20px;
        }
        .user-name {
            font-size: 22px;
        }
        .clock-time {
            font-size: 18px;
        }
        .company-name {
            font-size: 13px;
        }
    }

    /* Tablets (768-991px) */
    @media (max-width: 991px) {
        .main-content {
            padding: 15px 10px !important;
        }
        .summary-cards .col-md-3,
        .summary-cards .col-md-4 {
            width: 50%;
            float: left;
        }
        .welcome-header {
            flex-direction: column;
            gap: 16px;
            text-align: center;
        }
        .welcome-user {
            flex-direction: column;
        }
        .welcome-center {
            display: none;
        }
        .welcome-right {
            justify-content: center;
        }
        .user-role-badge {
            margin: 0 auto;
        }
        .user-name {
            font-size: 20px;
        }
        .welcome-panel {
            padding: 20px 16px;
        }
        .table-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
        }
        .table-actions {
            width: 100%;
            flex-direction: column;
        }
        .table-search {
            width: 100%;
        }
        .table-search input {
            min-width: 0;
            width: 100%;
        }
        .bulk-delete-btn {
            width: 100%;
            justify-content: center;
        }
        .sales-table-container {
            padding: 16px;
            border-radius: 14px;
        }
        .sales-table th,
        .sales-table td {
            padding: 10px 8px;
            font-size: 12px;
        }
        .status {
            padding: 4px 10px;
            font-size: 10px;
        }
    }

    /* Small tablets / large phones (576-767px) */
    @media (max-width: 767px) {
        .main-content {
            padding: 10px 8px !important;
        }
        .summary-cards .col-md-3,
        .summary-cards .col-md-4,
        .summary-cards .col-sm-6 {
            width: 100%;
            float: none;
        }
        .metric-card {
            flex-direction: row;
            text-align: left;
            padding: 16px 14px;
            border-radius: 14px;
        }
        .card-icon {
            width: 46px;
            height: 46px;
            min-width: 46px;
            font-size: 18px;
            margin-right: 14px;
            margin-bottom: 0;
            border-radius: 12px;
        }
        .amount {
            font-size: 20px;
        }
        .card-content h3 {
            font-size: 11px;
            margin-bottom: 4px;
        }
        .period-badge {
            font-size: 10px;
            padding: 3px 8px;
        }
        .summary-cards {
            margin-bottom: 16px;
        }
        .summary-cards [class*="col-"] {
            margin-bottom: 10px;
        }

        /* Welcome panel mobile */
        .welcome-panel {
            padding: 18px 14px;
            border-radius: 14px;
        }
        .welcome-panel-container {
            margin-bottom: 20px;
        }
        .user-avatar-wrap {
            width: 56px;
            height: 56px;
        }
        .avatar-image {
            width: 48px;
            height: 48px;
        }
        .user-name {
            font-size: 18px;
        }
        .user-role-badge {
            font-size: 10px;
            margin: 0 auto;
        }

        /* Tables - card-like mobile layout */
        .sales-table-container {
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 16px;
        }
        .table-title {
            font-size: 14px;
            gap: 8px;
            margin-bottom: 12px;
            padding-bottom: 10px;
        }
        .table-title .fa {
            width: 28px;
            height: 28px;
            font-size: 13px;
        }
        .table-subtitle {
            font-size: 11px;
        }
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin: 0 -12px;
            padding: 0 12px;
        }
        .sales-table {
            min-width: 850px;
        }
        .sales-table th {
            font-size: 10px;
            padding: 10px 8px;
            letter-spacing: 0.5px;
            white-space: nowrap;
        }
        .sales-table td {
            padding: 10px 8px;
            font-size: 12px;
            white-space: nowrap;
        }
        .status {
            padding: 3px 6px;
            font-size: 9px;
            white-space: nowrap;
        }
        .action-btn-group {
            gap: 3px;
        }
        .action-btn-group .status {
            padding: 3px 5px;
            font-size: 8px;
        }
        .type-badge-cell .status {
            font-size: 8px;
            padding: 3px 6px;
        }
        .approve-cell .status.fbr {
            font-size: 9px;
            padding: 4px 7px;
        }

        /* Section labels */
        .section-label {
            font-size: 11px;
            padding: 10px 12px;
            margin-bottom: 14px;
            gap: 8px;
        }
        .section-label .fa {
            width: 26px;
            height: 26px;
            font-size: 12px;
        }

        /* Search and actions */
        .table-search {
            padding: 9px 14px;
            border-radius: 10px;
        }
        .table-search input {
            min-width: 0;
            width: 100%;
            font-size: 12px;
        }
        .bulk-delete-btn {
            padding: 9px 14px;
            font-size: 12px;
            border-radius: 10px;
        }

        /* Alert fixes */
        .alert {
            font-size: 13px;
            padding: 12px 14px;
            margin-bottom: 12px;
        }
    }

    /* Extra small phones (below 480px) */
    @media (max-width: 480px) {
        .main-content {
            padding: 8px 6px !important;
        }
        .metric-card {
            padding: 14px 12px;
        }
        .card-icon {
            width: 40px;
            height: 40px;
            min-width: 40px;
            font-size: 16px;
            margin-right: 12px;
            border-radius: 10px;
        }
        .amount {
            font-size: 18px;
        }
        .card-content h3 {
            font-size: 10px;
        }

        .welcome-panel {
            padding: 14px 10px;
            border-radius: 12px;
        }
        .user-avatar-wrap {
            width: 48px;
            height: 48px;
        }
        .avatar-image {
            width: 42px;
            height: 42px;
        }
        .user-name {
            font-size: 16px;
        }
        .welcome-text {
            font-size: 10px;
        }
        .company-info {
            padding: 10px 14px;
            border-radius: 10px;
            gap: 10px;
        }
        .company-icon-wrap {
            width: 34px;
            height: 34px;
            font-size: 14px;
        }
        .company-name {
            font-size: 12px;
        }
        .company-label {
            font-size: 9px;
        }

        .sales-table-container {
            padding: 10px;
            border-radius: 10px;
        }
        .table-title {
            font-size: 13px;
        }
        .sales-table {
            min-width: 600px;
        }
        .sales-table th {
            font-size: 9px;
            padding: 8px 6px;
        }
        .sales-table td {
            font-size: 11px;
            padding: 8px 6px;
        }
        .status {
            padding: 2px 5px;
            font-size: 8px;
        }
        .action-btn-group {
            gap: 2px;
        }
        .action-btn-group .status {
            padding: 2px 4px;
            font-size: 7.5px;
        }
        .action-btn-group .status .fa {
            font-size: 8px;
        }
        .type-badge-cell .status {
            font-size: 7.5px;
            padding: 2px 5px;
        }
        .approve-cell .status.fbr {
            font-size: 8px;
            padding: 3px 6px;
        }

        .section-label {
            font-size: 10px;
            padding: 8px 10px;
        }
        .section-label .fa {
            width: 22px;
            height: 22px;
            font-size: 10px;
            border-radius: 6px;
        }

        /* Fix select all header */
        .select-all-text {
            display: none;
        }
    }

    /* ===== PRINT MEDIA ===== */
    @media print {
        .premium-navbar,
        .table-search,
        .bulk-delete-btn,
        .welcome-panel-container { display: none !important; }
        .sales-table-container { box-shadow: none; border: 1px solid #ddd; }
    }
</style>

<!-- <div class="row">
     <div class="col-lg-12">
      <div class="panel panel-default">
       <div class="panel-heading no-border clearfix">
        <center><h2 class="panel-title">SALE STATUS</h2></center>
       </div>
       
      </div>
     </div>
    </div> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const linkAuthority = @json($linkAuthority);

    function confirmFormAction(event) {
        event.preventDefault(); // Prevent immediate form submission

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to link this invoice with " + linkAuthority + "!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28c800ff',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, proceed!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, disable the page and submit the form
                disablePage();
                event.target.closest('form').submit();
            }
        });

        return false; // Prevent default form submission
    }

    function disablePage() {
        // Create overlay to block all actions
        const overlay = document.createElement('div');
        overlay.style.position = 'fixed';
        overlay.style.top = 0;
        overlay.style.left = 0;
        overlay.style.width = '100%';
        overlay.style.height = '100%';
        overlay.style.backgroundColor = 'rgba(255,255,255,0.6)';
        overlay.style.zIndex = 9999;
        // overlay.innerHTML = '<div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);font-size:18px;">Please wait... Don\'t Close this page!</div>';
        document.body.appendChild(overlay);
    }


    function confirmActiondel(event) {
        event.preventDefault();
        const originalUrl = event.currentTarget.href;

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to delete this invoice draft permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // If confirmed, disable the page and redirect
                disablePagedel(event);
                window.location.href = originalUrl;
            }
        });
    }

    function disablePagedel(event) {
        // Your existing disable page logic
        event.preventDefault();
        document.body.style.opacity = '0.5';
        document.body.style.pointerEvents = 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const selectAll = document.getElementById('select-all-unapproved');
        const checkboxes = document.querySelectorAll('.bulk-delete-checkbox');
        const searchInput = document.getElementById('unapproved-search');
        const emptyState = document.getElementById('unapproved-empty');
        const unapprovedRows = Array.from(document.querySelectorAll('.sales-table tbody tr'));
        const totalsFooter = document.querySelector('.sales-table tfoot');
        
        if (searchInput) {
            searchInput.addEventListener('input', function(event) {
                const term = event.target.value.toLowerCase().trim();
                let visibleCount = 0;
                unapprovedRows.forEach(function(row) {
                    const text = row.textContent.toLowerCase();
                    const match = text.indexOf(term) !== -1;
                    row.style.display = match ? '' : 'none';
                    if (match) {
                        visibleCount += 1;
                    }
                });
                if (emptyState) {
                    emptyState.style.display = visibleCount === 0 && term ? 'block' : 'none';
                }
                if (totalsFooter) {
                    totalsFooter.style.display = term ? 'none' : '';
                }
            });
        }

        const flashPayload = localStorage.getItem('bulkDeleteFlash');
        if (flashPayload) {
            try {
                const data = JSON.parse(flashPayload);
                const container = document.getElementById('bulk-delete-flash');
                if (container && data && data.message) {
                    container.innerHTML =
                        '<div class="alert alert-success alert-dismissible fade in">' +
                        '<a href="#" class="close" data-dismiss="alert" aria-label="close" style="margin-right: 4%;">&times;</a>' +
                        '<strong>Success!</strong> ' + data.message +
                        '</div>';
                }
            } catch (error) {
            }
            localStorage.removeItem('bulkDeleteFlash');
        }

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                checkboxes.forEach(function(box) {
                    box.checked = selectAll.checked;
                });
            });
        }

        checkboxes.forEach(function(box) {
            box.addEventListener('change', function() {
                if (!selectAll) {
                    return;
                }
                const allChecked = Array.from(checkboxes).every(function(cb) { return cb.checked; });
                selectAll.checked = allChecked;
            });
        });
    });

    function confirmBulkDelete() {
        const selected = Array.from(document.querySelectorAll('.bulk-delete-checkbox:checked'));
        if (selected.length === 0) {
            Swal.fire({
                title: 'No selection',
                text: 'Please select at least one invoice to delete.',
                icon: 'info'
            });
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete selected invoices permanently!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete them!'
        }).then((result) => {
            if (!result.isConfirmed) {
                return;
            }

            disablePage();
            const payload = buildBulkPayload(selected);
            bulkDeletePost(payload)
                .then(function() {
                    const totalDeleted = payload.salestax.length + payload.posSalestax.length + payload.debitNote.length;
                    localStorage.setItem('bulkDeleteFlash', JSON.stringify({
                        message: totalDeleted + ' invoice(s) deleted successfully.'
                    }));
                    window.location.reload();
                })
                .catch(function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Some invoices could not be deleted. Please refresh and try again.',
                        icon: 'error'
                    });
                });
        });
    }

    function buildBulkPayload(selected) {
        const payload = {
            salestax: [],
            posSalestax: [],
            debitNote: []
        };

        selected.forEach(function(box) {
            const id = box.getAttribute('data-id');
            const type = box.getAttribute('data-type');
            if (type === 'salestax') {
                payload.salestax.push(id);
            } else if (type === 'pos-salestax') {
                payload.posSalestax.push(id);
            } else {
                payload.debitNote.push(id);
            }
        });

        return payload;
    }

    function bulkDeletePost(payload) {
        const csrfToken = '{{ csrf_token() }}';
        const requests = [];

        if (payload.salestax.length > 0) {
            requests.push(fetch('{{ asset('salestax/bulk-destroy') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                credentials: 'same-origin',
                body: JSON.stringify({ ids: payload.salestax })
            }));
        }

        if (payload.posSalestax.length > 0) {
            requests.push(fetch('{{ asset('pos-salestax/bulk-destroy') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                credentials: 'same-origin',
                body: JSON.stringify({ ids: payload.posSalestax })
            }));
        }

        if (payload.debitNote.length > 0) {
            requests.push(fetch('{{ asset('debit-note/bulk-destroy') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                credentials: 'same-origin',
                body: JSON.stringify({ ids: payload.debitNote })
            }));
        }

        return Promise.all(requests).then(function(responses) {
            const hasError = responses.some(function(response) { return !response.ok; });
            if (hasError) {
                return Promise.reject(new Error('Bulk delete failed'));
            }
            return responses;
        });
    }

    /* ===== BULK LINK TO FBR ===== */
    function confirmBulkApprove() {
        const selected = Array.from(document.querySelectorAll('.bulk-delete-checkbox:checked'));
        if (selected.length === 0) {
            Swal.fire({
                title: 'No selection',
                text: 'Please select at least one invoice to link to ' + linkAuthority + '.',
                icon: 'info'
            });
            return;
        }

        Swal.fire({
            title: 'Link to ' + linkAuthority + '?',
            html: 'You are about to link <strong>' + selected.length + '</strong> invoice(s) to ' + linkAuthority + '.<br>This may take a moment for each invoice.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#22c55e',
            cancelButtonColor: '#6b7280',
            confirmButtonText: '<i class="fa fa-link"></i> Yes, Link All!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (!result.isConfirmed) return;

            const payload = buildBulkPayload(selected);
            const totalCount = payload.salestax.length + payload.posSalestax.length + payload.debitNote.length;

            // Show progress
            Swal.fire({
                title: 'Linking to ' + linkAuthority + '...',
                html: '<div id="fbr-bulk-progress">Processing 0 / ' + totalCount + ' invoices...</div>' +
                      '<div style="margin-top:12px;"><div id="fbr-progress-bar" style="height:6px;border-radius:3px;background:#e5e7eb;overflow:hidden;">' +
                      '<div id="fbr-progress-fill" style="height:100%;width:0%;background:linear-gradient(90deg,#22c55e,#16a34a);transition:width 0.3s;border-radius:3px;"></div></div></div>' +
                      '<div id="fbr-bulk-results" style="margin-top:16px;max-height:200px;overflow-y:auto;text-align:left;font-size:13px;"></div>',
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: function() {
                    Swal.showLoading();
                    bulkApproveSequential(payload).then(function(allResults) {
                        const successCount = allResults.filter(function(r) { return r.status === 'success'; }).length;
                        const skippedCount = allResults.filter(function(r) { return r.status === 'skipped'; }).length;
                        const failedCount = allResults.filter(function(r) { return r.status === 'error'; }).length;

                        Swal.close();

                        if (failedCount === 0) {
                            localStorage.setItem('bulkDeleteFlash', JSON.stringify({
                                message: successCount + ' invoice(s) linked to ' + linkAuthority + ' successfully!' + (skippedCount > 0 ? ' (' + skippedCount + ' already linked)' : '')
                            }));
                            window.location.reload();
                        } else {
                            let detailHtml = '<div style="text-align:left;max-height:300px;overflow-y:auto;font-size:13px;">';
                            allResults.forEach(function(r) {
                                const icon = r.status === 'success' ? '✅' : (r.status === 'skipped' ? '⏭️' : '❌');
                                const invLabel = r.invoice_no ? ('Inv# ' + r.invoice_no) : ('ID ' + r.id);
                                detailHtml += '<div style="padding:4px 0;border-bottom:1px solid #f3f4f6;">' + icon + ' ' + invLabel + ' — ' + r.message + '</div>';
                            });
                            detailHtml += '</div>';

                            Swal.fire({
                                title: 'Bulk Link Complete',
                                html: '<p><strong>' + successCount + '</strong> linked, <strong>' + failedCount + '</strong> failed' + (skippedCount > 0 ? ', <strong>' + skippedCount + '</strong> skipped' : '') + '</p>' + detailHtml,
                                icon: failedCount > 0 ? 'warning' : 'success',
                                confirmButtonText: 'OK',
                                width: '550px'
                            }).then(function() {
                                if (successCount > 0) {
                                    localStorage.setItem('bulkDeleteFlash', JSON.stringify({
                                        message: successCount + ' invoice(s) linked to ' + linkAuthority + ' successfully!' + (failedCount > 0 ? ' (' + failedCount + ' failed)' : '')
                                    }));
                                    window.location.reload();
                                }
                            });
                        }
                    });
                }
            });
        });
    }

    function bulkApproveSequential(payload) {
        const csrfToken = '{{ csrf_token() }}';
        const allIds = [];

        // Combine all IDs with their type/route info
        payload.salestax.forEach(function(id) { allIds.push({ id: id, type: 'salestax' }); });
        payload.posSalestax.forEach(function(id) { allIds.push({ id: id, type: 'pos-salestax' }); });
        // Debit notes also go through salestax/bulk-approve
        payload.debitNote.forEach(function(id) { allIds.push({ id: id, type: 'salestax' }); });

        // Group by type for batch API calls
        const salestaxIds = allIds.filter(function(item) { return item.type === 'salestax'; }).map(function(item) { return item.id; });
        const posSalestaxIds = allIds.filter(function(item) { return item.type === 'pos-salestax'; }).map(function(item) { return item.id; });

        const requests = [];
        const totalCount = allIds.length;

        function updateProgress(text) {
            const el = document.getElementById('fbr-bulk-progress');
            if (el) el.textContent = text;
        }

        function updateBar(percent) {
            const el = document.getElementById('fbr-progress-fill');
            if (el) el.style.width = percent + '%';
        }

        updateProgress('Sending ' + totalCount + ' invoice(s) to ' + linkAuthority + '...');
        updateBar(10);

        if (salestaxIds.length > 0) {
            requests.push(
                fetch('{{ asset("salestax/bulk-approve") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    credentials: 'same-origin',
                    body: JSON.stringify({ ids: salestaxIds })
                }).then(function(res) { return res.json(); })
            );
        }

        if (posSalestaxIds.length > 0) {
            requests.push(
                fetch('{{ asset("pos-salestax/bulk-approve") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    credentials: 'same-origin',
                    body: JSON.stringify({ ids: posSalestaxIds })
                }).then(function(res) { return res.json(); })
            );
        }

        if (requests.length === 0) {
            return Promise.resolve([]);
        }

        updateBar(30);

        return Promise.all(requests).then(function(responses) {
            updateBar(100);
            updateProgress('Done!');

            let allResults = [];
            responses.forEach(function(resp) {
                if (resp.results && Array.isArray(resp.results)) {
                    allResults = allResults.concat(resp.results);
                }
            });
            return allResults;
        });
    }
</script>

{{-- ===== PARTICLE CANVAS + 3D TILT + COUNTERS + LIVE CLOCK ===== --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    var isMobile = window.innerWidth < 768;
    var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ===== LIGHTWEIGHT PARTICLE CANVAS (desktop only) ===== */
    if (!isMobile && !prefersReducedMotion) {
        (function() {
            var canvas = document.getElementById('welcome-particles');
            if (!canvas) return;
            var ctx = canvas.getContext('2d');
            var particles = [];
            var particleCount = 25; /* Reduced from 60 */
            var isVisible = true;
            var animId;

            function resize() {
                var rect = canvas.parentElement.getBoundingClientRect();
                canvas.width = rect.width;
                canvas.height = rect.height;
            }
            resize();
            var resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(resize, 200);
            }, { passive: true });

            function Particle() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.vx = (Math.random() - 0.5) * 0.3;
                this.vy = (Math.random() - 0.5) * 0.3;
                this.radius = Math.random() * 1.8 + 0.5;
                this.opacity = Math.random() * 0.35 + 0.1;
                this.color = Math.random() > 0.5 ? '99,102,241' : '6,182,212';
            }

            for (var i = 0; i < particleCount; i++) {
                particles.push(new Particle());
            }

            function animate() {
                if (!isVisible) return;
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                for (var i = 0; i < particles.length; i++) {
                    var p = particles[i];
                    p.x += p.vx;
                    p.y += p.vy;
                    if (p.x < 0 || p.x > canvas.width) p.vx *= -1;
                    if (p.y < 0 || p.y > canvas.height) p.vy *= -1;
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                    ctx.fillStyle = 'rgba(' + p.color + ',' + p.opacity + ')';
                    ctx.fill();
                }
                animId = requestAnimationFrame(animate);
            }
            animate();

            /* Pause when tab is hidden */
            document.addEventListener('visibilitychange', function() {
                if (document.hidden) {
                    isVisible = false;
                    cancelAnimationFrame(animId);
                } else {
                    isVisible = true;
                    animate();
                }
            });
        })();
    }

    /* ===== LIVE CLOCK ===== */
    (function() {
        var clockEl = document.getElementById('live-clock');
        if (!clockEl) return;
        function tick() {
            var now = new Date();
            var hours = now.getHours();
            var period = hours >= 12 ? 'PM' : 'AM';
            var h = String(hours % 12 || 12).padStart(2, '0');
            var m = String(now.getMinutes()).padStart(2, '0');
            var s = String(now.getSeconds()).padStart(2, '0');
            clockEl.textContent = h + ':' + m + ':' + s + ' ' + period;
        }
        tick();
        setInterval(tick, 1000);
    })();

    /* ===== CSS-ONLY TILT EFFECT ON METRIC CARDS ===== */
    if (!isMobile) {
        document.querySelectorAll('.tilt-card').forEach(function(card) {
            card.addEventListener('mouseenter', function() {
                card.style.transform = 'translateY(-4px)';
                card.style.transition = 'transform 0.3s ease, box-shadow 0.3s ease';
                card.style.boxShadow = '0 12px 40px rgba(0,0,0,0.15)';
            });
            card.addEventListener('mouseleave', function() {
                card.style.transform = 'translateY(0)';
                card.style.boxShadow = '';
            });
        });
    }

    /* ===== ANIMATED NUMBER COUNTER ===== */
    function animateCounter(el) {
        var finalText = el.textContent.trim();
        var numericString = finalText.replace(/[^0-9.-]/g, '');
        var target = parseFloat(numericString);
        if (isNaN(target) || target === 0) return;

        var duration = 1000; /* Faster */
        var startTime = null;

        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            var progress = Math.min((timestamp - startTime) / duration, 1);
            var ease = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
            var current = Math.round(target * ease);
            el.textContent = current.toLocaleString('en-US');
            if (progress < 1) {
                requestAnimationFrame(step);
            } else {
                el.textContent = finalText;
            }
        }
        requestAnimationFrame(step);
    }

    /* Intersection Observer to trigger counters */
    var counterElements = document.querySelectorAll('.counter');
    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.3 });

        counterElements.forEach(function(el) {
            observer.observe(el);
        });
    } else {
        counterElements.forEach(function(el) {
            animateCounter(el);
        });
    }
});
</script>
@stop

@section('scripts')
@include('partials.email-invoice-modal')
@stop
