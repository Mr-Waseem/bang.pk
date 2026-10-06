
<?php
use App\Models\Companies;
use App\Models\User;
$user = User::where('id', Auth::User()->id)->first();
$currentUserRole = $user ? $user->roles->first() : null;

$company = Companies::where('id', session()->get('company_id'))->first('system_type');
?>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" media="print" onload="this.media='all'">
<noscript><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"></noscript>

<style>
/* ===== PREMIUM NAVBAR ANIMATIONS (optimized - only used keyframes) ===== */
@keyframes navGradientShift {
    0%   { background-position: 0% 50%; }
    50%  { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
@keyframes navSlideDown {
    from { opacity: 0; transform: translateY(-20px); }
    to   { opacity: 1; transform: translateY(0); }
}
@keyframes navBrandPulse {
    0%, 100% { text-shadow: 0 0 10px rgba(255,255,255,0.1); }
    50%      { text-shadow: 0 0 20px rgba(255,255,255,0.25); }
}
@keyframes navFloatIcon {
    0%, 100% { transform: translateY(0); }
    50%      { transform: translateY(-2px); }
}
@keyframes navShimmer {
    0%   { left: -100%; }
    100% { left: 200%; }
}
@keyframes navStatusPulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(34,197,94,0.5); }
    50%      { box-shadow: 0 0 0 5px rgba(34,197,94,0); }
}
@keyframes navBorderFlow {
    0%   { background-position: 0% 50%; }
    100% { background-position: 200% 50%; }
}

/* ========================================================
   FIX: Override Bootstrap .navbar-default .open gradient
   ======================================================== */
.navbar-default.premium-navbar .navbar-nav > .open > a,
.navbar-default.premium-navbar .navbar-nav > .open > a:focus,
.navbar-default.premium-navbar .navbar-nav > .open > a:hover {
    color: #ffffff !important;
    background: rgba(99,102,241,0.18) !important;
    background-image: none !important;
}
.navbar-default.premium-navbar .navbar-nav > li > a:hover,
.navbar-default.premium-navbar .navbar-nav > li > a:focus {
    background-image: none !important;
}
@media (max-width:767px) {
    .navbar-default.premium-navbar .navbar-nav .open .dropdown-menu > li > a {
        color: rgba(255,255,255,0.7) !important;
    }
    .navbar-default.premium-navbar .navbar-nav .open .dropdown-menu > li > a:focus,
    .navbar-default.premium-navbar .navbar-nav .open .dropdown-menu > li > a:hover {
        color: #ffffff !important;
        background-color: rgba(99,102,241,0.12) !important;
    }
}

/* ===== GLOBAL OVERFLOW FIX ===== */
html, body {
    overflow-x: hidden !important;
    max-width: 100vw !important;
}
*, *::before, *::after {
    box-sizing: border-box;
}

/* ===== PREMIUM NAVBAR BASE ===== */
.premium-navbar {
    background: linear-gradient(135deg, #0a0e27 0%, #1a1a4e 15%, #0d1b3e 30%, #162447 50%, #1a1a4e 70%, #0f0c29 85%, #0a0e27 100%) !important;
    background-size: 400% 400% !important;
    animation: navGradientShift 15s ease infinite, navSlideDown 0.6s cubic-bezier(.22,1,.36,1) both !important;
    border: none !important;
    border-bottom: none !important;
    box-shadow:
        0 4px 40px rgba(10, 14, 39, 0.6),
        0 1px 3px rgba(0,0,0,0.3),
        inset 0 1px 0 rgba(255,255,255,0.04),
        inset 0 -1px 0 rgba(255,255,255,0.02) !important;
    margin-bottom: 0 !important;
    min-height: 62px !important;
    position: relative;
    z-index: 1050;
    transition: all 0.5s cubic-bezier(.22,1,.36,1);
    overflow: visible;
    will-change: transform;
}

/* Ensure dropdowns always appear above page content */
.premium-navbar .dropdown {
    position: relative;
    z-index: 1060;
}
.premium-navbar .dropdown-menu {
    z-index: 1070 !important;
    position: absolute !important;
}
.premium-navbar .navbar-collapse {
    z-index: 1055;
}

/* Reduced motion preference */
@media (prefers-reduced-motion: reduce) {
    .premium-navbar,
    .premium-navbar *,
    .premium-navbar::before,
    .premium-navbar::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
    }
}

/* Animated rainbow top border */
.premium-navbar::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, #6366f1, #06b6d4, #a855f7, #ec4899, #f59e0b, #22c55e, #6366f1);
    background-size: 300% 100%;
    animation: navBorderFlow 4s linear infinite;
    z-index: 10;
}

/* Subtle aurora sweep across navbar - static gradient for performance */
.premium-navbar::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, transparent 0%, rgba(99,102,241,0.06) 30%, rgba(6,182,212,0.04) 50%, rgba(168,85,247,0.06) 70%, transparent 100%);
    pointer-events: none;
    z-index: 0;
    overflow: hidden;
}

/* Canvas particle background */
.premium-navbar #nav-particle-canvas {
    position: absolute;
    inset: 0;
    z-index: 0;
    pointer-events: none;
    opacity: 0.5;
}

/* Container inside navbar */
.premium-navbar .container-fluid {
    position: relative;
    z-index: 2;
}

/* ===== BRAND ===== */
.premium-navbar .navbar-brand {
    font-family: 'Inter', sans-serif !important;
    font-weight: 800 !important;
    font-size: 22px !important;
    letter-spacing: -0.3px !important;
    color: #ffffff !important;
    padding: 15px 18px !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 12px !important;
    position: relative !important;
    transition: all 0.4s cubic-bezier(.22,1,.36,1) !important;
    animation: navBrandPulse 4s ease-in-out infinite;
    background: linear-gradient(135deg, #ffffff 0%, #e0e7ff 30%, #c7d2fe 60%, #a5b4fc 100%) !important;
    -webkit-background-clip: text !important;
    -webkit-text-fill-color: transparent !important;
    background-clip: text !important;
}
.premium-navbar .navbar-brand:hover {
    filter: brightness(1.25) drop-shadow(0 0 15px rgba(99,102,241,0.3));
}

/* Brand icon decoration */
.premium-navbar .navbar-brand::before {
    content: '\f1c0';
    font-family: FontAwesome;
    -webkit-text-fill-color: transparent;
    background: linear-gradient(135deg, #6366f1, #06b6d4, #a855f7);
    background-size: 200% 200%;
    animation: navGradientShift 3s ease infinite, navFloatIcon 4s ease-in-out infinite;
    -webkit-background-clip: text;
    background-clip: text;
    font-size: 20px;
    filter: drop-shadow(0 0 8px rgba(99,102,241,0.3));
}

/* Brand shimmer sweep */
.premium-navbar .navbar-brand::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 50%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.08), transparent);
    animation: navShimmer 5s ease-in-out infinite;
    pointer-events: none;
}

/* ===== NAV LINKS ===== */
.premium-navbar .nav > li > a {
    font-family: 'Inter', sans-serif !important;
    font-weight: 600 !important;
    font-size: 12.5px !important;
    letter-spacing: 0.8px !important;
    text-transform: uppercase !important;
    color: rgba(255,255,255,0.72) !important;
    padding: 20px 16px !important;
    position: relative !important;
    transition: all 0.35s cubic-bezier(.22,1,.36,1) !important;
    border-radius: 0 !important;
    background: transparent !important;
    background-image: none !important;
}
.premium-navbar .nav > li > a i.fa {
    margin-right: 3px;
    font-size: 13px;
    transition: all 0.4s cubic-bezier(.22,1,.36,1);
    filter: drop-shadow(0 0 0 transparent);
}

.premium-navbar .nav > li > a:hover,
.premium-navbar .nav > li > a:focus,
.premium-navbar .nav > li.open > a {
    color: #ffffff !important;
    background: rgba(99,102,241,0.12) !important;
    background-image: none !important;
    text-shadow: 0 0 25px rgba(99,102,241,0.35);
}
.premium-navbar .nav > li:hover > a i.fa {
    filter: drop-shadow(0 0 6px rgba(99,102,241,0.5));
    color: #a5b4fc;
    transform: scale(1.15);
}

/* Active link glow underline */
.premium-navbar .nav > li > a::after {
    content: '';
    position: absolute;
    bottom: 6px;
    left: 50%;
    transform: translateX(-50%) scaleX(0);
    width: 60%;
    height: 2.5px;
    background: linear-gradient(90deg, #6366f1, #06b6d4, #a855f7);
    border-radius: 3px;
    transition: transform 0.35s cubic-bezier(.22,1,.36,1);
    box-shadow: 0 0 10px rgba(99,102,241,0.4);
}

.premium-navbar .nav > li:hover > a::after,
.premium-navbar .nav > li.open > a::after {
    transform: translateX(-50%) scaleX(1);
}

/* Active page indicator dot */
.premium-navbar .nav > li.active > a {
    color: #ffffff !important;
}
.premium-navbar .nav > li.active > a::before {
    content: '';
    position: absolute;
    top: 8px;
    left: 50%;
    transform: translateX(-50%);
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background: #22c55e;
    box-shadow: 0 0 8px rgba(34,197,94,0.6);
    animation: navStatusPulse 2s ease-in-out infinite;
}
.premium-navbar .nav > li.active > a::after {
    transform: translateX(-50%) scaleX(1);
    background: linear-gradient(90deg, #22c55e, #06b6d4);
    box-shadow: 0 0 12px rgba(34,197,94,0.4);
}

/* Caret upgrade */
.premium-navbar .caret {
    border-top-color: rgba(255,255,255,0.45) !important;
    transition: all 0.35s cubic-bezier(.22,1,.36,1);
    margin-left: 5px !important;
}
.premium-navbar .nav > li:hover .caret,
.premium-navbar .nav > li.open .caret {
    border-top-color: #a5b4fc !important;
    transform: rotate(180deg);
}

/* ===== DROPDOWN MENUS ===== */
.premium-navbar .dropdown-menu {
    background: rgba(12, 17, 38, 0.98) !important;
    backdrop-filter: blur(16px) !important;
    -webkit-backdrop-filter: blur(16px) !important;
    border: 1px solid rgba(99,102,241,0.12) !important;
    border-radius: 14px !important;
    box-shadow:
        0 15px 50px rgba(0,0,0,0.4),
        0 4px 16px rgba(0,0,0,0.2),
        inset 0 1px 0 rgba(255,255,255,0.06) !important;
    padding: 6px 0 !important;
    margin-top: 2px !important;
    min-width: 240px !important;
    overflow: hidden;
    transform-origin: top center;
    z-index: 1070 !important;
}

/* Dropdown top glow line */
.premium-navbar .dropdown-menu::before {
    content: '';
    position: absolute;
    top: 0;
    left: 8%;
    right: 8%;
    height: 2px;
    background: linear-gradient(90deg, transparent, #6366f1 30%, #06b6d4 50%, #a855f7 70%, transparent);
    border-radius: 2px;
    box-shadow: 0 0 15px rgba(99,102,241,0.3);
}

/* Dropdown subtle inner glow */
.premium-navbar .dropdown-menu::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 50px;
    background: linear-gradient(180deg, rgba(99,102,241,0.04), transparent);
    pointer-events: none;
    border-radius: 16px 16px 0 0;
}

.premium-navbar .dropdown-menu > li > a {
    font-family: 'Inter', sans-serif !important;
    font-weight: 500 !important;
    font-size: 13px !important;
    color: rgba(255,255,255,0.68) !important;
    padding: 12px 22px !important;
    transition: all 0.3s cubic-bezier(.22,1,.36,1) !important;
    border-bottom: 1px solid rgba(255,255,255,0.03) !important;
    position: relative;
    letter-spacing: 0.3px !important;
    z-index: 1;
    background: transparent !important;
}
.premium-navbar .dropdown-menu > li > a i.fa {
    width: 22px;
    text-align: center;
    margin-right: 6px;
    font-size: 13px;
    color: rgba(165,180,252,0.6);
    transition: all 0.3s ease;
}

/* Left accent bar on hover */
.premium-navbar .dropdown-menu > li > a::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 3px;
    background: linear-gradient(180deg, #6366f1, #06b6d4);
    border-radius: 0 3px 3px 0;
    transform: scaleY(0);
    transition: transform 0.25s cubic-bezier(.22,1,.36,1);
}

.premium-navbar .dropdown-menu > li > a:hover,
.premium-navbar .dropdown-menu > li > a:focus {
    background: linear-gradient(135deg, rgba(99,102,241,0.12), rgba(6,182,212,0.06)) !important;
    color: #ffffff !important;
    padding-left: 28px !important;
    text-shadow: 0 0 15px rgba(99,102,241,0.2);
}
.premium-navbar .dropdown-menu > li > a:hover i.fa {
    color: #a5b4fc;
    transform: scale(1.2);
    filter: drop-shadow(0 0 4px rgba(99,102,241,0.4));
}

.premium-navbar .dropdown-menu > li > a:hover::before {
    transform: scaleY(1);
}

.premium-navbar .dropdown-menu > li:last-child > a {
    border-bottom: none !important;
}

/* ===== DIVIDER ===== */
.premium-navbar .dropdown-menu .divider {
    background: linear-gradient(90deg, transparent, rgba(99,102,241,0.18), transparent) !important;
    margin: 4px 0 !important;
    height: 1px !important;
}

/* ===== RIGHT SIDE USER DROPDOWN ===== */
.premium-navbar .navbar-right > li > a {
    display: flex !important;
    align-items: center !important;
    gap: 10px !important;
}

.premium-navbar .navbar-right > li > a::before {
    content: '\f007';
    font-family: FontAwesome;
    width: 34px;
    height: 34px;
    border-radius: 12px;
    background: linear-gradient(135deg, rgba(99,102,241,0.35), rgba(168,85,247,0.25));
    border: 1.5px solid rgba(99,102,241,0.3);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    color: #a5b4fc;
    -webkit-text-fill-color: #a5b4fc;
    transition: all 0.4s cubic-bezier(.22,1,.36,1);
    flex-shrink: 0;
    box-shadow: 0 2px 10px rgba(99,102,241,0.15);
}

.premium-navbar .navbar-right > li:hover > a::before {
    background: linear-gradient(135deg, rgba(99,102,241,0.55), rgba(168,85,247,0.4));
    box-shadow: 0 4px 20px rgba(99,102,241,0.35), 0 0 0 3px rgba(99,102,241,0.1);
    transform: scale(1.1) rotate(5deg);
    border-color: rgba(99,102,241,0.5);
}

/* Logout link style in dropdown */
.premium-navbar .dropdown-menu > li > a[onclick*="logout"],
.premium-navbar .dropdown-menu > li a[onclick*="logout"] {
    color: rgba(248,113,113,0.8) !important;
}
.premium-navbar .dropdown-menu > li > a[onclick*="logout"]:hover,
.premium-navbar .dropdown-menu > li a[onclick*="logout"]:hover {
    color: #f87171 !important;
    background: rgba(248,113,113,0.08) !important;
}
.premium-navbar .dropdown-menu > li > a[onclick*="logout"]::before,
.premium-navbar .dropdown-menu > li a[onclick*="logout"]::before {
    background: linear-gradient(180deg, #f87171, #ef4444) !important;
}

/* ===== HAMBURGER TOGGLE ===== */
.premium-navbar .navbar-toggle {
    border: 1px solid rgba(255,255,255,0.12) !important;
    background: rgba(255,255,255,0.04) !important;
    border-radius: 12px !important;
    padding: 9px 11px !important;
    margin-top: 13px !important;
    transition: all 0.4s cubic-bezier(.22,1,.36,1) !important;
    backdrop-filter: blur(10px);
}
.premium-navbar .navbar-toggle:hover,
.premium-navbar .navbar-toggle:focus {
    background: rgba(99,102,241,0.15) !important;
    border-color: rgba(99,102,241,0.35) !important;
    box-shadow: 0 2px 15px rgba(99,102,241,0.2) !important;
}
.premium-navbar .navbar-toggle .icon-bar {
    background-color: rgba(255,255,255,0.8) !important;
    border-radius: 2px !important;
    height: 2.5px !important;
    width: 22px !important;
    transition: all 0.35s cubic-bezier(.22,1,.36,1) !important;
}
.premium-navbar .navbar-toggle:hover .icon-bar {
    background-color: #a5b4fc !important;
}

/* ===== MOBILE RESPONSIVE ===== */
@media (max-width: 767px) {
    .premium-navbar {
        min-height: 52px !important;
        position: fixed !important;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1050 !important;
    }
    /* Push page content below fixed navbar */
    body {
        padding-top: 55px !important;
    }

    .premium-navbar .container-fluid {
        padding-left: 10px;
        padding-right: 10px;
    }

    .premium-navbar .navbar-collapse {
        background: rgba(10, 14, 39, 0.99) !important;
        backdrop-filter: blur(20px) !important;
        -webkit-backdrop-filter: blur(20px) !important;
        border-top: 1px solid rgba(99,102,241,0.12) !important;
        box-shadow: 0 15px 50px rgba(0,0,0,0.5) !important;
        padding: 8px 0 !important;
        max-height: 80vh !important;
        overflow-x: hidden !important;
        overflow-y: auto !important;
        -webkit-overflow-scrolling: touch;
        position: absolute !important;
        top: 100% !important;
        left: 0 !important;
        right: 0 !important;
        width: 100% !important;
        z-index: 1060 !important;
    }

    /* Fix Bootstrap negative margins pushing nav links outside viewport */
    .premium-navbar .navbar-nav {
        margin: 0 !important;
        padding: 0 !important;
        float: none !important;
    }
    .premium-navbar .navbar-right {
        margin: 0 !important;
        float: none !important;
    }

    .premium-navbar .nav > li > a {
        padding: 13px 20px !important;
        border-bottom: 1px solid rgba(255,255,255,0.04) !important;
        font-size: 13px !important;
        display: flex !important;
        align-items: center !important;
    }
    .premium-navbar .nav > li > a i.fa {
        width: 24px;
        text-align: center;
        margin-right: 10px;
        font-size: 14px;
    }

    /* Dropdown inside mobile collapse - full width, flat style */
    .premium-navbar .dropdown-menu {
        position: static !important;
        float: none !important;
        width: 100% !important;
        background: rgba(18, 24, 48, 0.97) !important;
        border: none !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        padding: 0 0 0 16px !important;
        margin: 0 !important;
        min-width: 0 !important;
        display: none;
        animation: none !important;
    }
    .premium-navbar .dropdown.open > .dropdown-menu,
    .premium-navbar .open > .dropdown-menu {
        display: block !important;
    }
    .premium-navbar .dropdown-menu > li > a {
        padding: 11px 18px !important;
        font-size: 12.5px !important;
    }
    .premium-navbar .dropdown-menu::before,
    .premium-navbar .dropdown-menu::after {
        display: none !important;
    }

    .premium-navbar .navbar-brand {
        font-size: 16px !important;
        padding: 12px 10px !important;
    }
    .premium-navbar .navbar-brand::before {
        font-size: 14px;
    }
    .premium-navbar .navbar-brand::after {
        display: none;
    }

    .premium-navbar .navbar-toggle {
        margin-top: 9px !important;
        margin-bottom: 9px !important;
        margin-right: 6px !important;
    }

    /* Hide aurora & reduce animations on mobile */
    .premium-navbar::after {
        display: none;
    }
    .premium-navbar #nav-particle-canvas {
        display: none !important;
    }

    /* Caret fix on mobile */
    .premium-navbar .caret {
        float: right;
        margin-top: 8px;
    }

    /* Right nav items */
    .premium-navbar .navbar-right {
        margin-right: 0;
    }
    .premium-navbar .navbar-right > li > a::before {
        width: 28px;
        height: 28px;
        font-size: 12px;
        border-radius: 8px;
    }

    /* Active underline - hide on mobile as it doesn't make sense */
    .premium-navbar .nav > li > a::after {
        display: none;
    }
    .premium-navbar .nav > li.active > a {
        background: rgba(99,102,241,0.12) !important;
        border-left: 3px solid #6366f1;
    }
    .premium-navbar .nav > li.active > a::before {
        display: none;
    }
}

/* Tablet adjustments */
@media (min-width: 768px) and (max-width: 1199px) {
    .premium-navbar .nav > li > a {
        padding: 20px 10px !important;
        font-size: 11px !important;
        letter-spacing: 0.5px !important;
    }
    .premium-navbar .navbar-brand {
        font-size: 18px !important;
        padding: 15px 12px !important;
    }
    .premium-navbar .navbar-brand::before {
        font-size: 16px;
    }
    /* Ensure dropdowns don't go behind content on tablet */
    .premium-navbar .dropdown-menu {
        z-index: 1070 !important;
    }
}

/* Small desktop adjustments */
@media (min-width: 768px) and (max-width: 991px) {
    .premium-navbar .nav > li > a {
        padding: 20px 8px !important;
        font-size: 10.5px !important;
    }
    .premium-navbar .navbar-brand {
        font-size: 16px !important;
    }
    .premium-navbar .dropdown-menu {
        min-width: 200px !important;
    }
}

/* Extra small phones */
@media (max-width: 480px) {
    .premium-navbar .navbar-brand {
        font-size: 14px !important;
        padding: 12px 8px !important;
        gap: 8px !important;
    }
    .premium-navbar .navbar-brand::before {
        font-size: 13px;
    }
    .premium-navbar .nav > li > a {
        padding: 12px 14px !important;
        font-size: 11.5px !important;
    }
    .premium-navbar .dropdown-menu > li > a {
        padding: 10px 14px !important;
        font-size: 12px !important;
    }
    .premium-navbar .navbar-toggle {
        padding: 7px 9px !important;
    }
    .premium-navbar .navbar-toggle .icon-bar {
        width: 18px !important;
    }
}

/* ===== NAVBAR SHRINK ON SCROLL ===== */
.premium-navbar.nav-scrolled {
    min-height: 50px !important;
    box-shadow:
        0 8px 40px rgba(10, 14, 39, 0.75),
        0 2px 10px rgba(0,0,0,0.35),
        inset 0 -1px 0 rgba(99,102,241,0.06) !important;
}
.premium-navbar.nav-scrolled::before {
    height: 2px;
}
.premium-navbar.nav-scrolled .navbar-brand {
    font-size: 18px !important;
    padding: 10px 15px !important;
}
.premium-navbar.nav-scrolled .navbar-brand::before {
    font-size: 16px;
}
.premium-navbar.nav-scrolled .nav > li > a {
    padding: 14px 13px !important;
    font-size: 11.5px !important;
}

/* ===== ICON STYLE INSIDE LINKS ===== */
.premium-navbar .nav > li > a i.fa {
    position: relative;
    top: 0;
}

/* ===== TOOLTIP BADGE FOR ACTIVE ===== */
.premium-navbar .nav > li.active::before {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 50%;
    transform: translateX(-50%);
    width: 0;
    height: 0;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-bottom: 6px solid rgba(99,102,241,0.15);
    z-index: 10;
}
</style>

<nav class="navbar navbar-default premium-navbar" id="premium-nav">
     <div class="container-fluid" id="menubg" style="background: transparent !important;">
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
            <a class="navbar-brand" href="{{ URL::to('dashboard') }}"><?php echo $quee['system_name']; ?></a>
         </div>
         <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
             @if (session()->get('company_id') != null)
                @if($currentUserRole && ($currentUserRole->name == "Author" || $currentUserRole->name == "Admin"))
                 <ul class="nav navbar-nav">
                    <li><a href="{{ URL::to('dashboard') }}"><i class="fa fa-home"></i> HOME</a></li>
                     <li class="dropdown">
                         <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                             data-target=".navbar-collapse" data-hover="dropdown" role="button"
                             aria-haspopup="true" aria-expanded="false"><i class="fa fa-cogs"></i> DEFINITION <span
                                 class="caret"></span></a>
                         <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ URL::to('products') }}"><i class="fa fa-cubes"></i> PRODUCTS</a></li>
                            <li><a href="{{ URL::to('products/import-excel/create') }}"><i class="fa fa-upload"></i> IMPORT PRODUCTS</a></li>
                            <li><a href="{{ URL::to('parties') }}"><i class="fa fa-users"></i> PARTIES</a></li>
                            <li><a href="{{ URL::to('parties/import-excel/create') }}"><i class="fa fa-cloud-upload"></i> IMPORT PARTIES</a></li>
                            <li><a href="{{ URL::to('salestax/import-excel/create') }}"><i class="fa fa-file-excel-o"></i> IMPORT SALES</a></li> 
                         </ul>
                     </li>
                    
                    @if($company->system_type == "POS" || $company->system_type == "PRA" || $company->system_type == "KPRA" || $company->system_type == "SRB")
                    <li><a href="{{ URL::to('pos-salestax/create') }}"><i class="fa fa-file-text-o"></i> SALES TAX INVOICE</a></li>
                    <li><a href="{{ URL::to('pos-credit-note/create') }}"><i class="fa fa-reply"></i> CREDIT NOTE</a>
                    @else
                    <li><a href="{{ URL::to('salestax/create') }}"><i class="fa fa-file-text-o"></i> SALES TAX INVOICE</a></li>
                    <li><a href="{{ URL::to('debit-note/create') }}"><i class="fa fa-file-o"></i> DEBIT NOTE</a></li>
                    @endif
                     <li class="dropdown">
                         <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                             data-target=".navbar-collapse" data-hover="dropdown" role="button"
                             aria-haspopup="true" aria-expanded="false"><i class="fa fa-list-alt"></i> INVOICES <span
                                 class="caret"></span></a>
                         <ul class="dropdown-menu" role="menu">
                            @if($company->system_type == "POS" || $company->system_type == "PRA" || $company->system_type == "KPRA" || $company->system_type == "SRB")
                            <li><a href="{{ URL::to('pos-salestax') }}"><i class="fa fa-files-o"></i> SALES TAX INVOICE LIST</a></li>
                            <li><a href="{{ URL::to('pos-credit-note') }}"><i class="fa fa-list"></i> CREDIT NOTE LIST</a></li>
                            @else
                            <li><a href="{{ URL::to('salestax') }}"><i class="fa fa-files-o"></i> SALES TAX INVOICE LIST</a></li>
                            <li><a href="{{ URL::to('debit-note') }}"><i class="fa fa-list"></i> DEBIT NOTE LIST</a></li>
                            @endif
                            
                         </ul>
                     </li>
                     <li class="dropdown">
                         <a href="#" class="dropdown-toggle" data-toggle="dropdown"
                             data-target=".navbar-collapse" data-hover="dropdown" role="button"
                             aria-haspopup="true" aria-expanded="false"><i class="fa fa-bar-chart"></i> REPORTS <span
                                 class="caret"></span></a>
                         <ul class="dropdown-menu" role="menu">
                             <li><a href="{{ URL::to('salestax-report/single-party/add') }}"><i class="fa fa-user"></i> SINGLE PARTY REPORT</a></li>
                             <li><a href="{{ URL::to('salestax-report/all-party/create') }}"><i class="fa fa-users"></i> ALL PARTY REPORT</a></li>
                             <li><a href="{{  URL::to('product-report')}}"><i class="fa fa-cube"></i> PRODUCT REPORT</a></li>
                             <li><a href="{{ URL::to('print-reports/create') }}"><i class="fa fa-print"></i> PRINT REPORTS</a></li>
                         </ul>
                     </li>

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
                     <li class="dropdown">
                         <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                             aria-haspopup="true" aria-expanded="false">{{ Auth::user()->name }}<span
                                 class="caret"></span></a>
                         <ul class="dropdown-menu">
                             <li><a href="{{ URL::to('account') }}"><i
                                         class="fa fa-user-circle"></i> Account Settings</a></li>
                             <li><a href="{{ URL::to('company-settings') }}"><i
                                         class="fa fa-cog"></i> Settings</a></li>
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
                <ul class="nav navbar-nav">
                    <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-target=".navbar-collapse"
                        data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false"
                        ><i class="fa fa-ticket"></i> VOUCHERS <span
                            class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ URL::to('products') }}"><i class="fa fa-cubes"></i> PRODUCTS</a></li>
                            <li><a href="{{ URL::to('delivery-challan/create') }}"><i class="fa fa-plus-circle"></i> DELIVERY CHALLAN CREATE</a></li>
                            <li><a href="{{ URL::to('delivery-challan') }}"><i class="fa fa-truck"></i> DELIVERY CHALLANS</a></li>
                            <li><a href="{{ URL::to('grn/create') }}"><i class="fa fa-plus-square"></i> GRN CREATE</a></li>
                            <li><a href="{{ URL::to('grn') }}"><i class="fa fa-archive"></i> GRN'S</a></li>
                        </ul>
                    </li>
                </ul>
           
                 @endif
                @else
                 <ul class="nav navbar-nav navbar-right">
                     <li class="dropdown">
                         <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                             aria-haspopup="true" aria-expanded="false"
                             >{{ Auth::user()->name }}<span
                                 class="caret"></span></a>
                         <ul class="dropdown-menu">
                             <li><a href="{{ URL::to('account') }}"><i
                                         class="fa fa-user-circle"></i> Account Settings</a></li>
                             <li><a href="{{ URL::to('company-settings') }}"><i
                                         class="fa fa-cog"></i> Settings</a></li>
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

<script>
(function() {
    'use strict';
    var nav = document.getElementById('premium-nav');
    if (!nav) return;

    /* ── Utility: check if mobile ── */
    var isMobile = window.innerWidth < 768;
    var prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    /* ══════════════════════════════════════════
       LIGHTWEIGHT CANVAS PARTICLES (desktop only)
       ══════════════════════════════════════════ */
    if (!isMobile && !prefersReducedMotion) {
        (function initParticles() {
            var canvas = document.createElement('canvas');
            canvas.id = 'nav-particle-canvas';
            nav.insertBefore(canvas, nav.firstChild);
            var ctx = canvas.getContext('2d');
            var particles = [];
            var PARTICLE_COUNT = 18; /* Reduced from 35 for performance */
            var isVisible = true;
            var animId;

            function resize() {
                canvas.width = nav.offsetWidth;
                canvas.height = nav.offsetHeight;
            }
            resize();
            var resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(resize, 200);
            }, { passive: true });

            for (var i = 0; i < PARTICLE_COUNT; i++) {
                particles.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height,
                    vx: (Math.random() - 0.5) * 0.3,
                    vy: (Math.random() - 0.5) * 0.2,
                    r: Math.random() * 1.2 + 0.5,
                    alpha: Math.random() * 0.3 + 0.1
                });
            }

            function animate() {
                if (!isVisible) return;
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                for (var i = 0; i < particles.length; i++) {
                    var p = particles[i];
                    p.x += p.vx;
                    p.y += p.vy;
                    if (p.x < 0) p.x = canvas.width;
                    if (p.x > canvas.width) p.x = 0;
                    if (p.y < 0) p.y = canvas.height;
                    if (p.y > canvas.height) p.y = 0;
                    ctx.beginPath();
                    ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                    ctx.fillStyle = 'rgba(99,102,241,' + p.alpha + ')';
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

    /* ══════════════════════════════════════════
       SCROLL SHRINK EFFECT
       ══════════════════════════════════════════ */
    var scrollTicking = false;
    window.addEventListener('scroll', function() {
        if (!scrollTicking) {
            window.requestAnimationFrame(function() {
                nav.classList.toggle('nav-scrolled', window.scrollY > 30);
                scrollTicking = false;
            });
            scrollTicking = true;
        }
    }, { passive: true });

    /* ══════════════════════════════════════════
       ACTIVE LINK HIGHLIGHT
       ══════════════════════════════════════════ */
    var currentPath = window.location.pathname.replace(/\/+$/, '') || '/';

    function normalizePath(path) {
        return (path || '/').replace(/\/+$/, '') || '/';
    }

    var topLevelItems = nav.querySelectorAll('.nav.navbar-nav > li, .nav.navbar-nav.navbar-right > li');
    topLevelItems.forEach(function(li) { li.classList.remove('active'); });

    var bestMatchItem = null;
    var bestScore = -1;

    topLevelItems.forEach(function(li) {
        li.querySelectorAll('a[href]').forEach(function(link) {
            var rawHref = link.getAttribute('href');
            if (!rawHref || rawHref === '#' || rawHref.indexOf('javascript:') === 0) return;
            try {
                var url = new URL(rawHref, window.location.origin);
                var linkPath = normalizePath(url.pathname);
                var score = -1;
                if (linkPath === currentPath) {
                    score = 1000 + linkPath.length;
                } else if (currentPath.indexOf(linkPath + '/') === 0) {
                    score = linkPath.length;
                }
                if (score > bestScore) {
                    bestScore = score;
                    bestMatchItem = li;
                }
            } catch (e) {}
        });
    });

    if (bestMatchItem) {
        bestMatchItem.classList.add('active');
    }

    /* ══════════════════════════════════════════
       SIMPLE DROPDOWN ANIMATION (desktop only)
       ══════════════════════════════════════════ */
    if (!isMobile) {
        nav.querySelectorAll('.dropdown').forEach(function(dd) {
            var menu = dd.querySelector('.dropdown-menu');
            if (!menu) return;
            dd.addEventListener('mouseenter', function() {
                menu.style.opacity = '0';
                menu.style.transform = 'translateY(6px)';
                menu.style.transition = 'opacity 0.2s ease, transform 0.2s ease';
                requestAnimationFrame(function() {
                    menu.style.opacity = '1';
                    menu.style.transform = 'translateY(0)';
                });
            });
            dd.addEventListener('mouseleave', function() {
                menu.style.transition = 'opacity 0.15s ease, transform 0.15s ease';
                menu.style.opacity = '0';
                menu.style.transform = 'translateY(6px)';
            });
        });
    }

    /* ══════════════════════════════════════════
       STAGGERED ENTRANCE (one-time, fast)
       ══════════════════════════════════════════ */
    if (!prefersReducedMotion) {
        nav.querySelectorAll('.nav.navbar-nav > li').forEach(function(li, idx) {
            li.style.opacity = '0';
            li.style.transform = 'translateY(-8px)';
            setTimeout(function() {
                li.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                li.style.opacity = '1';
                li.style.transform = 'translateY(0)';
            }, 50 + idx * 40);
        });
    }

    /* ══════════════════════════════════════════
       RIPPLE KEYFRAME (only inject once)
       ══════════════════════════════════════════ */
    if (!document.getElementById('nav-ripple-style')) {
        var s = document.createElement('style');
        s.id = 'nav-ripple-style';
        s.textContent = '@keyframes navRipple{to{width:200px;height:200px;opacity:0;}}';
        document.head.appendChild(s);
    }

    /* Simple click ripple - no mousemove handlers */
    nav.querySelectorAll('.dropdown-menu a, .nav > li > a').forEach(function(link) {
        link.addEventListener('click', function(e) {
            var ripple = document.createElement('span');
            ripple.style.cssText = 'position:absolute;border-radius:50%;background:rgba(99,102,241,0.25);width:0;height:0;transform:translate(-50%,-50%);pointer-events:none;animation:navRipple 0.5s ease-out forwards;';
            var rect = link.getBoundingClientRect();
            ripple.style.left = (e.clientX - rect.left) + 'px';
            ripple.style.top = (e.clientY - rect.top) + 'px';
            link.style.position = 'relative';
            link.style.overflow = 'hidden';
            link.appendChild(ripple);
            setTimeout(function() { ripple.remove(); }, 500);
        });
    });

})();
</script>
