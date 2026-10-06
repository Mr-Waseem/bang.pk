<?php
use App\Models\SystemLogo;
use App\Models\Setting;

$logo = SystemLogo::first();
$settings = Setting::first();

$defaultNoticeBody = "Stay informed about FBR Digital Invoicing updates and system notices.\n\n"
    . "- Keep your NTN and token details up to date\n"
    . "- Contact support for new company registration\n"
    . "- Call " . ($settings->phone ?: '0321 4197290') . " for POS / Digital Invoicing help";

$noteTitle = trim((string) ($settings->login_note_title ?? '')) ?: 'Notice Board';
$noteBodyRaw = trim((string) ($settings->login_note_body ?? '')) ?: $defaultNoticeBody;

$renderNoticeBody = function (string $raw): string {
    $lines = preg_split("/\r\n|\n|\r/", $raw) ?: [];
    $html = '';
    $paragraphLines = [];
    $listItems = [];
    $animIndex = 0;

    $flushParagraph = function () use (&$html, &$paragraphLines, &$animIndex) {
        if (empty($paragraphLines)) {
            return;
        }
        $delay = 0.18 + ($animIndex * 0.08);
        $animIndex++;
        $html .= '<p class="notice-p notice-anim" style="--d:' . $delay . 's">' . e(implode(' ', $paragraphLines)) . '</p>';
        $paragraphLines = [];
    };

    $flushList = function () use (&$html, &$listItems, &$animIndex) {
        if (empty($listItems)) {
            return;
        }
        $html .= '<ul class="notice-list">';
        foreach ($listItems as $item) {
            $delay = 0.22 + ($animIndex * 0.09);
            $animIndex++;
            $html .= '<li class="notice-anim" style="--d:' . $delay . 's">' . e($item) . '</li>';
        }
        $html .= '</ul>';
        $listItems = [];
    };

    foreach ($lines as $line) {
        $trimmed = trim($line);
        if ($trimmed === '') {
            $flushParagraph();
            $flushList();
            continue;
        }
        if (preg_match('/^[-•]\s+(.+)$/u', $trimmed, $m)) {
            $flushParagraph();
            $listItems[] = $m[1];
            continue;
        }
        $flushList();
        $paragraphLines[] = $trimmed;
    }
    $flushParagraph();
    $flushList();

    return $html;
};

$noteBodyHtml = $renderNoticeBody($noteBodyRaw);

$brandLogo = asset('root/upload/logo/bang-logo.png');
if (!empty($logo) && !empty($logo->image)) {
    $brandLogo = asset('root/upload/logo/' . $logo->image);
}
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <title><?php echo e($settings->title); ?> - Login</title>
    
    <link rel="shortcut icon" href="<?php echo e(asset('login-form-assets/img/favicon.ico')); ?>" type="image/x-icon">
    <meta name="description" content="Login to your <?php echo e($settings->title); ?> account">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="<?php echo e(asset('login-form-assets/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <style>
        :root {
            --brand: #2f8fc4;
            --brand-bright: #5ec2ef;
            --brand-deep: #143a55;
            --ink: #142033;
            --muted: #5b6b7c;
        }

        * { box-sizing: border-box; }
        
        body {
            margin: 0;
            min-height: 100vh;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--ink);
            background: #071521;
            overflow-x: hidden;
        }
        
        .page-loader {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #071521;
        }

        .login-stage {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            overflow: hidden;
            background:
                radial-gradient(ellipse 70% 55% at 12% 18%, rgba(47, 143, 196, 0.42), transparent 55%),
                radial-gradient(ellipse 55% 45% at 88% 12%, rgba(20, 80, 120, 0.5), transparent 50%),
                radial-gradient(ellipse 50% 40% at 70% 92%, rgba(56, 178, 172, 0.18), transparent 55%),
                linear-gradient(160deg, #071521 0%, #0e2a40 48%, #0a1c2c 100%);
        }

        .fx-orb {
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
            filter: blur(1px);
            opacity: 0.55;
            animation: orbDrift 12s ease-in-out infinite;
        }

        .fx-orb.a { width: 260px; height: 260px; left: -50px; bottom: 6%; background: radial-gradient(circle, rgba(94,194,239,.55), transparent 70%); }
        .fx-orb.b { width: 200px; height: 200px; right: -30px; top: 10%; background: radial-gradient(circle, rgba(47,143,196,.5), transparent 70%); animation-delay: -4s; }
        .fx-orb.c { width: 140px; height: 140px; left: 45%; top: -30px; background: radial-gradient(circle, rgba(120,210,200,.35), transparent 70%); animation-delay: -7s; }

        @keyframes  orbDrift {
            0%, 100% { transform: translate3d(0,0,0) scale(1); }
            50% { transform: translate3d(16px,-20px,0) scale(1.08); }
        }

        .login-shell {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 1080px;
            animation: shellRise 0.75s cubic-bezier(0.22, 1, 0.36, 1) both;
        }

        @keyframes  shellRise {
            from { opacity: 0; transform: translateY(26px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        
        .login-card {
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            border-radius: 28px;
            overflow: hidden;
            background: rgba(255,255,255,0.9);
            border: 1px solid rgba(255,255,255,0.5);
            box-shadow: 0 30px 80px rgba(5, 20, 40, 0.45), 0 8px 24px rgba(5, 20, 40, 0.2);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .login-form-pane {
            padding: 2.6rem 2.4rem;
            background: linear-gradient(180deg, #fff 0%, #f7fbff 100%);
        }

        .brand-mark {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .brand-mark img {
            max-height: 70px;
            max-width: 220px;
            width: auto;
            object-fit: contain;
        }

        .brand-mark h1 {
            margin: 0;
            font-size: 1.85rem;
            font-weight: 800;
            letter-spacing: -0.03em;
        }

        .form-heading {
            text-align: center;
            font-size: 1.2rem;
            font-weight: 700;
            margin: 0 0 1.4rem;
            letter-spacing: -0.02em;
        }

        .form-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--muted);
            margin-bottom: 0.35rem;
        }
        
        .form-control {
            padding: 0.85rem 1rem;
            border-radius: 14px;
            border: 1px solid #d5e3ef;
            transition: border-color 0.25s, box-shadow 0.25s, transform 0.25s;
        }
        
        .form-control:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 4px rgba(47, 143, 196, 0.18);
            transform: translateY(-1px);
        }

        .input-group .form-control { border-radius: 14px 0 0 14px; }
        .input-group .btn {
            border-radius: 0 14px 14px 0;
            border-color: #d5e3ef;
            color: var(--muted);
        }

        .btn-login {
            width: 100%;
            border: 0;
            border-radius: 14px;
            padding: 0.95rem 1.2rem;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, #3aa0d6 0%, #1f6f9c 55%, #184f73 100%);
            box-shadow: 0 12px 28px rgba(31, 111, 156, 0.35), inset 0 1px 0 rgba(255,255,255,0.25);
            transition: transform 0.2s, box-shadow 0.2s, filter 0.2s;
        }

        .btn-login:hover {
            color: #fff;
            filter: brightness(1.06);
            transform: translateY(-2px);
            box-shadow: 0 16px 34px rgba(31, 111, 156, 0.45);
        }

        .btn-login:active { transform: translateY(0); }
        .btn-login:disabled { opacity: 0.75; }

        .social-login p { color: var(--muted); font-size: 0.88rem; }
        .social-login .btn {
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: 1px solid #cfe0ec;
            color: var(--brand-deep);
            background: #fff;
            transition: transform 0.2s, background 0.2s, color 0.2s;
        }
        .social-login .btn:hover {
            background: var(--brand);
            color: #fff;
            border-color: var(--brand);
            transform: translateY(-2px);
        }
        
        .help-block {
            text-align: center;
            margin-top: 1.4rem;
            color: var(--muted);
            font-size: 0.9rem;
        }
        .help-block a {
            color: var(--brand);
            font-weight: 700;
            text-decoration: none;
        }
        .help-block a:hover { text-decoration: underline; }

        /* ===== Premium Notice Board (right) ===== */
        .notice-pane {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.6rem;
            color: #fff;
            background:
                linear-gradient(155deg, #134866 0%, #0d3048 45%, #0a2236 100%);
            overflow: hidden;
            perspective: 1200px;
        }

        .notice-pane::before,
        .notice-pane::after {
            content: "";
            position: absolute;
            border-radius: 45% 55% 50% 50%;
            pointer-events: none;
        }

        .notice-pane::before {
            width: 300px;
            height: 300px;
            top: -90px;
            right: -80px;
            background: radial-gradient(circle, rgba(94, 194, 239, 0.4), transparent 70%);
            animation: morphBlob 9s ease-in-out infinite;
        }

        .notice-pane::after {
            width: 220px;
            height: 220px;
            bottom: -70px;
            left: -50px;
            background: radial-gradient(circle, rgba(56, 178, 172, 0.28), transparent 70%);
            animation: morphBlob 11s ease-in-out infinite reverse;
        }

        @keyframes  morphBlob {
            0%, 100% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(20deg) scale(1.12); }
        }

        .notice-particles {
            position: absolute;
            inset: 0;
            pointer-events: none;
            overflow: hidden;
        }

        .notice-particles span {
            position: absolute;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: rgba(158, 220, 255, 0.75);
            box-shadow: 0 0 10px rgba(94, 194, 239, 0.8);
            animation: particleFloat linear infinite;
        }

        .notice-particles span:nth-child(1) { left: 12%; bottom: -10px; animation-duration: 9s; animation-delay: 0s; }
        .notice-particles span:nth-child(2) { left: 28%; width: 4px; height: 4px; bottom: -10px; animation-duration: 11s; animation-delay: 1.2s; }
        .notice-particles span:nth-child(3) { left: 48%; bottom: -10px; animation-duration: 8s; animation-delay: 2.1s; }
        .notice-particles span:nth-child(4) { left: 66%; width: 5px; height: 5px; bottom: -10px; animation-duration: 12s; animation-delay: 0.6s; }
        .notice-particles span:nth-child(5) { left: 82%; bottom: -10px; animation-duration: 10s; animation-delay: 3s; }
        .notice-particles span:nth-child(6) { left: 38%; width: 3px; height: 3px; bottom: -10px; animation-duration: 13s; animation-delay: 1.8s; }

        @keyframes  particleFloat {
            0% { transform: translateY(0) translateX(0) scale(0.7); opacity: 0; }
            15% { opacity: 0.9; }
            100% { transform: translateY(-420px) translateX(18px) scale(1.1); opacity: 0; }
        }

        .notice-board {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 390px;
            padding: 1.7rem 1.55rem 1.8rem;
            border-radius: 24px;
            background:
                linear-gradient(165deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0.07) 45%, rgba(255,255,255,0.1) 100%);
            border: 1px solid rgba(255, 255, 255, 0.32);
            box-shadow:
                0 24px 55px rgba(0, 0, 0, 0.35),
                inset 0 1px 0 rgba(255, 255, 255, 0.35),
                0 0 0 1px rgba(94, 194, 239, 0.08);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            transform-style: preserve-3d;
            animation: boardFloat 5.5s ease-in-out infinite, boardIn 0.85s cubic-bezier(0.22, 1, 0.36, 1) 0.12s both;
            will-change: transform;
        }

        .notice-board.is-tilting {
            animation: boardIn 0.01s both;
        }

        @keyframes  boardFloat {
            0%, 100% { transform: translateY(0) rotateX(2deg) rotateY(-3deg); }
            50% { transform: translateY(-10px) rotateX(-2deg) rotateY(3deg); }
        }

        @keyframes  boardIn {
            from { opacity: 0; transform: translateY(28px) scale(0.94) rotateX(8deg); }
            to { opacity: 1; transform: translateY(0) scale(1) rotateX(2deg) rotateY(-3deg); }
        }

        .notice-board::before {
            content: "";
            position: absolute;
            left: 0;
            top: 16px;
            bottom: 16px;
            width: 4px;
            border-radius: 0 5px 5px 0;
            background: linear-gradient(180deg, #9ad8f5 0%, #2f8fc4 50%, #1a6a94 100%);
            box-shadow: 0 0 16px rgba(94, 194, 239, 0.65);
            animation: edgeGlow 2.8s ease-in-out infinite;
        }

        @keyframes  edgeGlow {
            0%, 100% { box-shadow: 0 0 10px rgba(94, 194, 239, 0.35); filter: brightness(0.95); }
            50% { box-shadow: 0 0 24px rgba(94, 194, 239, 0.95); filter: brightness(1.15); }
        }

        .notice-pin {
            position: absolute;
            top: -10px;
            right: 22px;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: radial-gradient(circle at 35% 30%, #b8ecff, #2f8fc4 55%, #145a82);
            box-shadow: 0 6px 14px rgba(0,0,0,0.35), 0 0 16px rgba(94,194,239,0.7);
            animation: pinPulse 2.4s ease-in-out infinite;
            z-index: 3;
        }

        .notice-pin::after {
            content: "";
            position: absolute;
            left: 50%;
            top: 18px;
            width: 2px;
            height: 14px;
            background: linear-gradient(#7ec8ea, transparent);
            transform: translateX(-50%);
            opacity: 0.7;
        }

        @keyframes  pinPulse {
            0%, 100% { transform: scale(1); box-shadow: 0 6px 14px rgba(0,0,0,0.35), 0 0 12px rgba(94,194,239,0.5); }
            50% { transform: scale(1.08); box-shadow: 0 8px 18px rgba(0,0,0,0.4), 0 0 22px rgba(94,194,239,0.95); }
        }

        .notice-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            padding: 0.38rem 0.8rem;
            border-radius: 999px;
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #eaf7ff;
            background: rgba(47, 143, 196, 0.38);
            border: 1px solid rgba(158, 220, 255, 0.45);
            margin-bottom: 0.95rem;
            animation: staggerIn 0.6s cubic-bezier(0.22, 1, 0.36, 1) 0.2s both;
        }

        .notice-badge i { color: #9ad8f5; }

        .notice-title {
            font-size: 1.7rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            margin: 0 0 1rem;
            line-height: 1.2;
            text-shadow: 0 10px 28px rgba(0,0,0,0.3);
            animation: staggerIn 0.65s cubic-bezier(0.22, 1, 0.36, 1) 0.32s both;
        }

        .notice-content {
            text-align: left;
            font-size: 0.94rem;
            line-height: 1.65;
            color: rgba(255,255,255,0.92);
        }

        .notice-anim {
            opacity: 0;
            animation: staggerIn 0.55s cubic-bezier(0.22, 1, 0.36, 1) var(--d, 0.4s) both;
        }

        @keyframes  staggerIn {
            from { opacity: 0; transform: translateY(14px) translateZ(0); }
            to { opacity: 1; transform: translateY(0) translateZ(0); }
        }

        .notice-p { margin: 0 0 0.85rem; color: rgba(255,255,255,0.88); }
        .notice-p:last-child { margin-bottom: 0; }

        .notice-list {
            list-style: none;
            margin: 0 0 0.85rem;
            padding: 0;
        }
        .notice-list:last-child { margin-bottom: 0; }

        .notice-list li {
            position: relative;
            margin-bottom: 0.42rem;
            padding: 0.5rem 0.6rem 0.5rem 1.6rem;
            border-radius: 12px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            transition: transform 0.25s, background 0.25s, border-color 0.25s;
        }

        .notice-list li:hover {
            transform: translateX(4px);
            background: rgba(94, 194, 239, 0.14);
            border-color: rgba(158, 220, 255, 0.35);
        }

        .notice-list li:last-child { margin-bottom: 0; }

        .notice-list li::before {
            content: "";
            position: absolute;
            left: 0.7rem;
            top: 0.95rem;
            width: 0.42rem;
            height: 0.42rem;
            border-radius: 50%;
            background: var(--brand-bright);
            box-shadow: 0 0 10px rgba(94, 194, 239, 0.9);
        }

        .alert { border-radius: 12px; font-size: 0.9rem; }

        @media (max-width: 991.98px) {
            .login-card {
                grid-template-columns: 1fr;
                max-width: 480px;
                margin: 0 auto;
            }
            .login-form-pane { padding: 2rem 1.3rem; }
            .notice-pane { padding: 1.4rem 1.1rem 1.7rem; }
            .notice-board {
                max-width: 100%;
                animation: boardIn 0.7s cubic-bezier(0.22, 1, 0.36, 1) both;
            }
            .notice-title { font-size: 1.4rem; }
        }

        @media (prefers-reduced-motion: reduce) {
            .login-shell, .fx-orb, .notice-board, .notice-board::before,
            .notice-pin, .notice-pane::before, .notice-pane::after,
            .notice-particles span, .notice-badge, .notice-title, .notice-anim {
                animation: none !important;
                opacity: 1 !important;
                transform: none !important;
            }
        }
    </style>
</head>

<body>
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TAGCODE" height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    
    <div class="page-loader">
        <div class="spinner-border text-light" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    
    <div class="login-stage">
        <span class="fx-orb a" aria-hidden="true"></span>
        <span class="fx-orb b" aria-hidden="true"></span>
        <span class="fx-orb c" aria-hidden="true"></span>

        <div class="login-shell">
                    <div class="login-card">
                <div class="login-form-pane">
                    <div class="brand-mark">
                        <?php if($settings->white_label == 0 || !empty($logo->image)): ?>
                            <img src="<?php echo e($brandLogo); ?>" alt="<?php echo e($settings->title); ?>">
                                    <?php else: ?>
                            <h1><?php echo e($settings->title); ?></h1>
                                    <?php endif; ?>
                    </div>
                                    
                    <h2 class="form-heading">Sign In to Your Account</h2>
                                    
                                    <?php if(session('error')): ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <?php echo e(session('error')); ?>

                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if($errors->any()): ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <ul class="mb-0">
                                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <li><?php echo e($error); ?></li>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <form method="POST" action="<?php echo e(route('login')); ?>" class="needs-validation" novalidate>
                                        <?php echo csrf_field(); ?>
                                        
                        <div class="mb-3">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" 
                                                   class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                   id="email" 
                                                   name="email" 
                                                   value="<?php echo e(old('email')); ?>" 
                                                   required 
                                                   autofocus>
                                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="password" class="form-label">Password</label>
                                            <div class="input-group">
                                                <input type="password" 
                                                       class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                                       id="password" 
                                                       name="password" 
                                                       required>
                                <button class="btn btn-outline-secondary toggle-password" type="button" aria-label="Toggle password">
                                                    <i class="far fa-eye"></i>
                                                </button>
                                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>
                                        
                        <button type="submit" class="btn btn-login mb-3">
                                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            Login
                                        </button>
                                        
                                        <?php if($settings->white_label == 0): ?>
                        <div class="social-login text-center mt-3">
                                            <p class="mb-3">Or connect with</p>
                                            <div class="d-flex justify-content-center gap-3">
                                <a href="https://bang.pk" target="_blank" class="btn" aria-label="Website"><i class="fas fa-globe"></i></a>
                                <a href="https://www.facebook.com/itlifee.net" target="_blank" class="btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                                <a href="https://www.instagram.com/it.lifee" target="_blank" class="btn" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </form>
                                    
                    <div class="help-block">
                        <p class="mb-1">Need FBR Digital Invoicing, POS service?</p>
                        <p class="mb-0"><a href="tel:<?php echo e($settings->phone); ?>"><?php echo e($settings->phone); ?></a></p>
                                </div>
                            </div>
                            
                <aside class="notice-pane" aria-label="Notice Board">
                    <div class="notice-particles" aria-hidden="true">
                        <span></span><span></span><span></span><span></span><span></span><span></span>
                                    </div>

                    <div class="notice-board" id="noticeBoard">
                        <span class="notice-pin" aria-hidden="true"></span>
                        <span class="notice-badge"><i class="fas fa-bullhorn" aria-hidden="true"></i> Notice</span>
                        <h2 class="notice-title"><?php echo e($noteTitle); ?></h2>
                        <div class="notice-content">
                            <?php echo $noteBodyHtml; ?>

                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
    
    <script src="<?php echo e(asset('login-form-assets/js/bootstrap.bundle.min.js')); ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-password').forEach(button => {
                button.addEventListener('click', function() {
                    const passwordInput = this.previousElementSibling;
                    const icon = this.querySelector('i');
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        icon.classList.replace('fa-eye', 'fa-eye-slash');
                    } else {
                        passwordInput.type = 'password';
                        icon.classList.replace('fa-eye-slash', 'fa-eye');
                    }
                });
            });
            
            document.querySelectorAll('.needs-validation').forEach(form => {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        const submitButton = form.querySelector('button[type="submit"]');
                        const spinner = submitButton.querySelector('.spinner-border');
                        submitButton.disabled = true;
                        spinner.classList.remove('d-none');
                    }
                    form.classList.add('was-validated');
                }, false);
            });
            
            window.addEventListener('load', function() {
                const loader = document.querySelector('.page-loader');
                if (loader) loader.style.display = 'none';
            });

            // Subtle interactive 3D tilt on notice board (desktop)
            const board = document.getElementById('noticeBoard');
            const pane = document.querySelector('.notice-pane');
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const isDesktop = window.matchMedia('(min-width: 992px)').matches;

            if (board && pane && isDesktop && !reduceMotion) {
                pane.addEventListener('mousemove', function(e) {
                    const rect = pane.getBoundingClientRect();
                    const x = (e.clientX - rect.left) / rect.width;
                    const y = (e.clientY - rect.top) / rect.height;
                    const rotY = (x - 0.5) * 14;
                    const rotX = (0.5 - y) * 10;
                    board.classList.add('is-tilting');
                    board.style.transform = 'rotateX(' + rotX + 'deg) rotateY(' + rotY + 'deg) translateZ(8px)';
                });
                pane.addEventListener('mouseleave', function() {
                    board.classList.remove('is-tilting');
                    board.style.transform = '';
                });
            }
        });
    </script>
</body>
</html>
<?php /**PATH D:\Axis-Coding\xampp-8.2.12\htdocs\it_life_work\digital-invoicing\root\resources\views/auth/login.blade.php ENDPATH**/ ?>