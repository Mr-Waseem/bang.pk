<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - BANG Digital Solutions | FBR Invoicing</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary: #25D366;
            --accent: #004e89;
            --bg: #f0f4f8;
            --dark: #112a64;
            --light: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--bg);
            color: #1a2b3c;
            overflow-x: hidden;
        }

        /* ===== Hero Section ===== */
        .faq-hero {
            min-height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 100px 20px 60px;
            position: relative;
            background: linear-gradient(135deg, #0a1628 0%, #112a64 50%, #0d3a5c 100%);
            overflow: hidden;
        }

        /* Animated Hexagon Grid Background */
        .hex-grid {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .hex-grid::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='52' viewBox='0 0 60 52' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 0l25.98 15v30L30 60 4.02 45V15z' fill='none' stroke='rgba(37,211,102,0.08)' stroke-width='1'/%3E%3C/svg%3E");
            background-size: 60px 52px;
            animation: hexMove 30s linear infinite;
        }

        @keyframes hexMove {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(30px, 26px) rotate(5deg); }
        }

        /* Floating Question Marks */
        .floating-questions {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 2;
            pointer-events: none;
        }

        .float-q {
            position: absolute;
            font-size: 3rem;
            color: rgba(37, 211, 102, 0.15);
            font-weight: 900;
            animation: floatQuestion 8s ease-in-out infinite;
        }

        .float-q:nth-child(1) { top: 10%; left: 5%; animation-delay: 0s; font-size: 4rem; }
        .float-q:nth-child(2) { top: 20%; right: 8%; animation-delay: 1.5s; font-size: 2.5rem; }
        .float-q:nth-child(3) { bottom: 25%; left: 10%; animation-delay: 3s; font-size: 3.5rem; }
        .float-q:nth-child(4) { bottom: 15%; right: 12%; animation-delay: 0.8s; font-size: 2rem; }
        .float-q:nth-child(5) { top: 45%; left: 3%; animation-delay: 2.2s; font-size: 2.8rem; }
        .float-q:nth-child(6) { top: 35%; right: 5%; animation-delay: 4s; font-size: 3.2rem; }

        @keyframes floatQuestion {
            0%, 100% { 
                transform: translateY(0) rotate(-10deg); 
                opacity: 0.15;
            }
            50% { 
                transform: translateY(-30px) rotate(10deg); 
                opacity: 0.25;
            }
        }

        /* Glowing Lines Animation */
        .glow-lines {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .glow-line {
            position: absolute;
            width: 2px;
            height: 150px;
            background: linear-gradient(to bottom, transparent, var(--primary), transparent);
            opacity: 0.4;
            animation: lineFall 4s linear infinite;
        }

        .glow-line:nth-child(1) { left: 10%; animation-delay: 0s; }
        .glow-line:nth-child(2) { left: 25%; animation-delay: 1s; }
        .glow-line:nth-child(3) { left: 45%; animation-delay: 2s; }
        .glow-line:nth-child(4) { left: 65%; animation-delay: 0.5s; }
        .glow-line:nth-child(5) { left: 85%; animation-delay: 1.5s; }

        @keyframes lineFall {
            0% { 
                transform: translateY(-150px);
                opacity: 0;
            }
            50% {
                opacity: 0.6;
            }
            100% { 
                transform: translateY(100vh);
                opacity: 0;
            }
        }

        .faq-hero .container {
            display: flex;
            gap: 60px;
            align-items: center;
            max-width: 1200px;
            width: 100%;
            position: relative;
            z-index: 10;
        }

        .hero-text {
            flex: 1;
        }

        .hero-text h1 {
            font-size: 3.2rem;
            font-weight: 800;
            margin-bottom: 20px;
            color: #fff;
            line-height: 1.2;
        }

        .hero-text h1 span {
            background: linear-gradient(90deg, var(--primary), #32e67a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-text p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.15rem;
            line-height: 1.8;
            margin-bottom: 30px;
        }

        .hero-badges {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(37, 211, 102, 0.15);
            border: 1px solid rgba(37, 211, 102, 0.3);
            padding: 10px 20px;
            border-radius: 50px;
            color: var(--primary);
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .hero-badge:hover {
            background: rgba(37, 211, 102, 0.25);
            transform: translateY(-3px);
        }

        /* ===== 3D Question Box Animation ===== */
        .animation-container {
            width: 380px;
            height: 380px;
            perspective: 1200px;
            flex-shrink: 0;
            position: relative;
        }

        .question-3d {
            width: 100%;
            height: 100%;
            position: relative;
            transform-style: preserve-3d;
            animation: floatBox 6s ease-in-out infinite;
        }

        @keyframes floatBox {
            0%, 100% { transform: rotateY(-15deg) rotateX(10deg) translateY(0); }
            50% { transform: rotateY(-15deg) rotateX(10deg) translateY(-25px); }
        }

        /* 3D Cube */
        .cube {
            position: absolute;
            width: 180px;
            height: 180px;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            transform-style: preserve-3d;
            animation: rotateCube 20s linear infinite;
        }

        @keyframes rotateCube {
            0% { transform: translate(-50%, -50%) rotateY(0deg) rotateX(0deg); }
            100% { transform: translate(-50%, -50%) rotateY(360deg) rotateX(360deg); }
        }

        .cube-face {
            position: absolute;
            width: 180px;
            height: 180px;
            background: linear-gradient(135deg, rgba(37, 211, 102, 0.2), rgba(0, 78, 137, 0.3));
            border: 2px solid rgba(37, 211, 102, 0.4);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: var(--primary);
            border-radius: 20px;
        }

        .cube-face.front { transform: translateZ(90px); }
        .cube-face.back { transform: rotateY(180deg) translateZ(90px); }
        .cube-face.right { transform: rotateY(90deg) translateZ(90px); }
        .cube-face.left { transform: rotateY(-90deg) translateZ(90px); }
        .cube-face.top { transform: rotateX(90deg) translateZ(90px); }
        .cube-face.bottom { transform: rotateX(-90deg) translateZ(90px); }

        /* Orbiting rings */
        .orbit-ring {
            position: absolute;
            left: 50%;
            top: 50%;
            border: 2px solid rgba(37, 211, 102, 0.2);
            border-radius: 50%;
        }

        .orbit-ring.ring1 {
            width: 280px;
            height: 280px;
            transform: translate(-50%, -50%) rotateX(70deg);
            animation: orbitRing1 8s linear infinite;
        }

        .orbit-ring.ring2 {
            width: 320px;
            height: 320px;
            transform: translate(-50%, -50%) rotateX(70deg) rotateZ(60deg);
            animation: orbitRing2 12s linear infinite reverse;
        }

        .orbit-ring.ring3 {
            width: 360px;
            height: 360px;
            transform: translate(-50%, -50%) rotateX(70deg) rotateZ(-60deg);
            animation: orbitRing3 15s linear infinite;
        }

        @keyframes orbitRing1 {
            from { transform: translate(-50%, -50%) rotateX(70deg) rotateZ(0deg); }
            to { transform: translate(-50%, -50%) rotateX(70deg) rotateZ(360deg); }
        }

        @keyframes orbitRing2 {
            from { transform: translate(-50%, -50%) rotateX(70deg) rotateZ(60deg); }
            to { transform: translate(-50%, -50%) rotateX(70deg) rotateZ(420deg); }
        }

        @keyframes orbitRing3 {
            from { transform: translate(-50%, -50%) rotateX(70deg) rotateZ(-60deg); }
            to { transform: translate(-50%, -50%) rotateX(70deg) rotateZ(300deg); }
        }

        /* Floating particles around cube */
        .particle {
            position: absolute;
            width: 8px;
            height: 8px;
            background: var(--primary);
            border-radius: 50%;
            box-shadow: 0 0 20px var(--primary);
            animation: particleFloat 5s ease-in-out infinite;
        }

        .particle:nth-child(1) { top: 10%; left: 20%; animation-delay: 0s; }
        .particle:nth-child(2) { top: 30%; right: 15%; animation-delay: 1s; }
        .particle:nth-child(3) { bottom: 25%; left: 25%; animation-delay: 2s; }
        .particle:nth-child(4) { bottom: 15%; right: 20%; animation-delay: 1.5s; }
        .particle:nth-child(5) { top: 50%; left: 10%; animation-delay: 0.5s; }
        .particle:nth-child(6) { top: 60%; right: 10%; animation-delay: 2.5s; }

        @keyframes particleFloat {
            0%, 100% { 
                transform: translate(0, 0) scale(1);
                opacity: 0.8;
            }
            50% { 
                transform: translate(20px, -20px) scale(1.5);
                opacity: 1;
            }
        }

        /* ===== FAQ Content Section ===== */
        .faq-content {
            max-width: 1100px;
            margin: -50px auto 60px;
            padding: 50px;
            background: white;
            border-radius: 24px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.08);
            position: relative;
            z-index: 20;
        }

        .content-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .content-header h2 {
            font-size: 2rem;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .content-header p {
            color: #5a6a7a;
        }

        /* Category Tabs */
        .faq-categories {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }

        .category-tab {
            padding: 12px 28px;
            background: linear-gradient(135deg, #f5f7fa, #eef2f7);
            border: 2px solid transparent;
            border-radius: 50px;
            cursor: pointer;
            font-weight: 600;
            color: var(--dark);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .category-tab:hover,
        .category-tab.active {
            background: linear-gradient(135deg, var(--primary), #32e67a);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(37, 211, 102, 0.3);
        }

        .category-tab i {
            font-size: 1.1rem;
        }

        /* FAQ Accordion */
        .faq-accordion {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .faq-item {
            background: linear-gradient(180deg, #fafbfc, #f5f7fa);
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.04);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .faq-item:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
        }

        .faq-question {
            padding: 25px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            gap: 20px;
        }

        .faq-question .question-content {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .question-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, rgba(37, 211, 102, 0.15), rgba(0, 78, 137, 0.1));
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.2rem;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .faq-item.active .question-icon {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
        }

        .faq-question h3 {
            font-size: 1.1rem;
            color: var(--dark);
            font-weight: 600;
            margin: 0;
        }

        .toggle-icon {
            width: 40px;
            height: 40px;
            background: rgba(0, 0, 0, 0.04);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark);
            font-size: 1rem;
            flex-shrink: 0;
            transition: all 0.4s ease;
        }

        .faq-item.active .toggle-icon {
            background: var(--primary);
            color: white;
            transform: rotate(180deg);
        }

        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s ease, padding 0.4s ease;
        }

        .faq-item.active .faq-answer {
            max-height: 500px;
        }

        .faq-answer-content {
            padding: 0 30px 25px 95px;
            color: #4a5a6a;
            line-height: 1.8;
        }

        .faq-answer-content ul {
            margin-top: 10px;
            padding-left: 20px;
        }

        .faq-answer-content li {
            margin-bottom: 8px;
        }

        /* Stats Section */
        .faq-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            margin-top: 50px;
            padding-top: 50px;
            border-top: 1px solid rgba(0, 0, 0, 0.06);
        }

        .stat-card {
            text-align: center;
            padding: 30px 20px;
            background: linear-gradient(135deg, #fafbfc, #f0f4f8);
            border-radius: 20px;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            transform: scaleX(0);
            transition: transform 0.4s ease;
        }

        .stat-card:hover::before {
            transform: scaleX(1);
        }

        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary), #32e67a);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin: 0 auto 15px;
        }

        .stat-number {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .stat-label {
            color: #5a6a7a;
            font-size: 0.95rem;
        }

        /* Contact CTA Section */
        .contact-cta {
            background: linear-gradient(135deg, var(--dark), #0d3a5c);
            border-radius: 20px;
            padding: 50px;
            color: white;
            display: flex;
            align-items: center;
            gap: 40px;
            margin-top: 50px;
            position: relative;
            overflow: hidden;
        }

        .contact-cta::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(37, 211, 102, 0.2), transparent 70%);
            top: -150px;
            right: -100px;
            animation: ctaPulse 4s ease-in-out infinite;
        }

        @keyframes ctaPulse {
            0%, 100% { transform: scale(1); opacity: 0.3; }
            50% { transform: scale(1.2); opacity: 0.5; }
        }

        .contact-icon-wrap {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--primary), #32e67a);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            flex-shrink: 0;
            box-shadow: 0 15px 40px rgba(37, 211, 102, 0.3);
            animation: iconBounce 3s ease-in-out infinite;
            position: relative;
            z-index: 2;
        }

        @keyframes iconBounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .contact-content {
            flex: 1;
            position: relative;
            z-index: 2;
        }

        .contact-content h3 {
            font-size: 1.6rem;
            margin-bottom: 10px;
        }

        .contact-content p {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .contact-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .contact-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 28px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .contact-btn.primary {
            background: var(--primary);
            color: white;
        }

        .contact-btn.secondary {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .contact-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .contact-btn.primary:hover {
            background: #20c55e;
        }

        .contact-btn.secondary:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .faq-hero .container { flex-direction: column-reverse; text-align: center; gap: 40px; }
            .hero-text h1 { font-size: 2.4rem; }
            .hero-badges { justify-content: center; }
            .animation-container { width: 300px; height: 300px; }
            .cube { width: 140px; height: 140px; }
            .cube-face { width: 140px; height: 140px; font-size: 3rem; }
            .cube-face.front { transform: translateZ(70px); }
            .cube-face.back { transform: rotateY(180deg) translateZ(70px); }
            .cube-face.right { transform: rotateY(90deg) translateZ(70px); }
            .cube-face.left { transform: rotateY(-90deg) translateZ(70px); }
            .cube-face.top { transform: rotateX(90deg) translateZ(70px); }
            .cube-face.bottom { transform: rotateX(-90deg) translateZ(70px); }
            .orbit-ring.ring1 { width: 220px; height: 220px; }
            .orbit-ring.ring2 { width: 250px; height: 250px; }
            .orbit-ring.ring3 { width: 280px; height: 280px; }
            .faq-stats { grid-template-columns: repeat(2, 1fr); }
            .contact-cta { flex-direction: column; text-align: center; }
        }

        @media (max-width: 768px) {
            .faq-hero { padding: 80px 15px 40px; min-height: auto; }
            .hero-text h1 { font-size: 2rem; }
            .faq-content { margin: -30px 15px 40px; padding: 30px 20px; }
            .float-q { display: none; }
            .faq-question { padding: 20px; }
            .question-icon { width: 40px; height: 40px; font-size: 1rem; }
            .faq-question h3 { font-size: 1rem; }
            .faq-answer-content { padding: 0 20px 20px 55px; }
            .faq-stats { grid-template-columns: 1fr; }
            .category-tab { padding: 10px 20px; font-size: 0.9rem; }
        }
    </style>
</head>

<body>
    @include('website.include.header')

    <section class="faq-hero">
        <!-- Hexagon Grid Background -->
        <div class="hex-grid"></div>

        <!-- Glowing Lines -->
        <div class="glow-lines">
            <div class="glow-line"></div>
            <div class="glow-line"></div>
            <div class="glow-line"></div>
            <div class="glow-line"></div>
            <div class="glow-line"></div>
        </div>

        <!-- Floating Question Marks -->
        <div class="floating-questions">
            <span class="float-q">?</span>
            <span class="float-q">?</span>
            <span class="float-q">?</span>
            <span class="float-q">?</span>
            <span class="float-q">?</span>
            <span class="float-q">?</span>
        </div>

        <div class="container">
            <div class="hero-text">
                <h1>Frequently Asked <span>Questions</span></h1>
                <p>Find answers to the most common questions about FBR-compliant invoicing, digital solutions, and our platform. We're here to help you understand everything about tax compliance.</p>
                <div class="hero-badges">
                    <div class="hero-badge">
                        <i class="fas fa-headset"></i>
                        <span>24/7 Support</span>
                    </div>
                    <div class="hero-badge">
                        <i class="fas fa-book-open"></i>
                        <span>Detailed Guides</span>
                    </div>
                    <div class="hero-badge">
                        <i class="fas fa-comments"></i>
                        <span>Quick Answers</span>
                    </div>
                </div>
            </div>

            <div class="animation-container">
                <div class="question-3d">
                    <!-- Floating Particles -->
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>
                    <div class="particle"></div>

                    <!-- Orbiting Rings -->
                    <div class="orbit-ring ring1"></div>
                    <div class="orbit-ring ring2"></div>
                    <div class="orbit-ring ring3"></div>

                    <!-- 3D Cube -->
                    <div class="cube">
                        <div class="cube-face front"><i class="fas fa-question"></i></div>
                        <div class="cube-face back"><i class="fas fa-lightbulb"></i></div>
                        <div class="cube-face right"><i class="fas fa-file-invoice"></i></div>
                        <div class="cube-face left"><i class="fas fa-shield-alt"></i></div>
                        <div class="cube-face top"><i class="fas fa-check-circle"></i></div>
                        <div class="cube-face bottom"><i class="fas fa-cog"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main class="faq-content" id="faq">
        <div class="content-header">
            <h2>How Can We Help You?</h2>
            <p>Browse through our comprehensive FAQ section for instant answers</p>
        </div>

        <!-- Category Tabs -->
        <div class="faq-categories">
            <div class="category-tab active" data-category="all">
                <i class="fas fa-th-large"></i>
                All Questions
            </div>
            <div class="category-tab" data-category="fbr">
                <i class="fas fa-landmark"></i>
                FBR & Tax
            </div>
            <div class="category-tab" data-category="invoicing">
                <i class="fas fa-file-invoice"></i>
                Invoicing
            </div>
            <div class="category-tab" data-category="account">
                <i class="fas fa-user-cog"></i>
                Account
            </div>
            <div class="category-tab" data-category="technical">
                <i class="fas fa-tools"></i>
                Technical
            </div>
        </div>

        <!-- FAQ Accordion -->
        <div class="faq-accordion">
            <!-- FBR Questions -->
            <div class="faq-item" data-category="fbr">
                <div class="faq-question">
                    <div class="question-content">
                        <div class="question-icon"><i class="fas fa-landmark"></i></div>
                        <h3>What is FBR digital invoicing and why is it mandatory?</h3>
                    </div>
                    <div class="toggle-icon"><i class="fas fa-chevron-down"></i></div>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        FBR (Federal Board of Revenue) digital invoicing is a government-mandated electronic invoicing system in Pakistan. It's designed to:
                        <ul>
                            <li>Ensure transparent tax collection</li>
                            <li>Reduce tax evasion and fraud</li>
                            <li>Digitize business transactions for better record-keeping</li>
                            <li>Enable real-time tax monitoring by FBR</li>
                        </ul>
                        All registered businesses must comply with FBR's point-of-sale (POS) integration requirements.
                    </div>
                </div>
            </div>

            <div class="faq-item" data-category="fbr">
                <div class="faq-question">
                    <div class="question-content">
                        <div class="question-icon"><i class="fas fa-certificate"></i></div>
                        <h3>How does BANG ERP ensure FBR compliance?</h3>
                    </div>
                    <div class="toggle-icon"><i class="fas fa-chevron-down"></i></div>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        BANG ERP is fully integrated with FBR's systems and automatically:
                        <ul>
                            <li>Generates invoices in FBR-required format</li>
                            <li>Transmits invoice data in real-time to FBR servers</li>
                            <li>Maintains proper audit trails for all transactions</li>
                            <li>Calculates and applies correct tax rates automatically</li>
                            <li>Provides QR codes for invoice verification</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="faq-item" data-category="fbr">
                <div class="faq-question">
                    <div class="question-content">
                        <div class="question-icon"><i class="fas fa-percentage"></i></div>
                        <h3>What tax rates are applied to FBR invoices?</h3>
                    </div>
                    <div class="toggle-icon"><i class="fas fa-chevron-down"></i></div>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Tax rates vary based on business type and products/services. Common rates include:
                        <ul>
                            <li>Standard GST: 17% on most goods and services</li>
                            <li>Reduced rates for essential items</li>
                            <li>Additional taxes for specific categories (luxury goods, tobacco, etc.)</li>
                            <li>Withholding tax where applicable</li>
                        </ul>
                        Our system automatically applies the correct rates based on your business registration and product categories.
                    </div>
                </div>
            </div>

            <!-- Invoicing Questions -->
            <div class="faq-item" data-category="invoicing">
                <div class="faq-question">
                    <div class="question-content">
                        <div class="question-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                        <h3>How do I create an FBR-compliant invoice?</h3>
                    </div>
                    <div class="toggle-icon"><i class="fas fa-chevron-down"></i></div>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Creating an FBR-compliant invoice is simple with BANG ERP:
                        <ul>
                            <li>Log into your dashboard and navigate to "Create Invoice"</li>
                            <li>Select customer or add new customer details</li>
                            <li>Add products/services with quantities and prices</li>
                            <li>System automatically calculates taxes and generates FBR invoice number</li>
                            <li>Review and submit - invoice is automatically sent to FBR</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="faq-item" data-category="invoicing">
                <div class="faq-question">
                    <div class="question-content">
                        <div class="question-icon"><i class="fas fa-undo"></i></div>
                        <h3>Can I cancel or modify an invoice after submission?</h3>
                    </div>
                    <div class="toggle-icon"><i class="fas fa-chevron-down"></i></div>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Once an invoice is submitted to FBR, it cannot be modified. However, you can:
                        <ul>
                            <li>Issue a credit note to reverse the original invoice</li>
                            <li>Create a new corrected invoice</li>
                            <li>Contact our support team for assistance with special cases</li>
                        </ul>
                        All credit notes and adjustments are also reported to FBR for complete transparency.
                    </div>
                </div>
            </div>

            <div class="faq-item" data-category="invoicing">
                <div class="faq-question">
                    <div class="question-content">
                        <div class="question-icon"><i class="fas fa-print"></i></div>
                        <h3>How can I print or share invoices with customers?</h3>
                    </div>
                    <div class="toggle-icon"><i class="fas fa-chevron-down"></i></div>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        BANG ERP offers multiple ways to share invoices:
                        <ul>
                            <li>Print directly from the system with QR code for verification</li>
                            <li>Download as PDF for email sharing</li>
                            <li>Send via WhatsApp integration</li>
                            <li>Share invoice link for online viewing</li>
                            <li>Thermal printer support for POS receipts</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Account Questions -->
            <div class="faq-item" data-category="account">
                <div class="faq-question">
                    <div class="question-content">
                        <div class="question-icon"><i class="fas fa-user-plus"></i></div>
                        <h3>How do I register my business on BANG ERP?</h3>
                    </div>
                    <div class="toggle-icon"><i class="fas fa-chevron-down"></i></div>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Registering your business is a straightforward process:
                        <ul>
                            <li>Visit our website and click "Get Started"</li>
                            <li>Provide your NTN (National Tax Number) and business details</li>
                            <li>Upload required documents (NTN certificate, CNIC)</li>
                            <li>Our team will verify and activate your account within 24-48 hours</li>
                            <li>Receive login credentials and start issuing compliant invoices</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="faq-item" data-category="account">
                <div class="faq-question">
                    <div class="question-content">
                        <div class="question-icon"><i class="fas fa-users"></i></div>
                        <h3>Can I add multiple users to my account?</h3>
                    </div>
                    <div class="toggle-icon"><i class="fas fa-chevron-down"></i></div>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Yes, BANG ERP supports multi-user access with role-based permissions:
                        <ul>
                            <li>Admin: Full access to all features and settings</li>
                            <li>Manager: Access to reports, invoices, and customer management</li>
                            <li>Cashier: Invoice creation and basic operations only</li>
                            <li>Custom roles can be configured as per your needs</li>
                        </ul>
                        Each user gets unique login credentials for accountability.
                    </div>
                </div>
            </div>

            <div class="faq-item" data-category="account">
                <div class="faq-question">
                    <div class="question-content">
                        <div class="question-icon"><i class="fas fa-key"></i></div>
                        <h3>How do I reset my password?</h3>
                    </div>
                    <div class="toggle-icon"><i class="fas fa-chevron-down"></i></div>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        To reset your password:
                        <ul>
                            <li>Click "Forgot Password" on the login page</li>
                            <li>Enter your registered email address</li>
                            <li>Check your email for the reset link</li>
                            <li>Create a new strong password</li>
                            <li>For security, we recommend changing passwords every 90 days</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Technical Questions -->
            <div class="faq-item" data-category="technical">
                <div class="faq-question">
                    <div class="question-content">
                        <div class="question-icon"><i class="fas fa-plug"></i></div>
                        <h3>Does BANG ERP integrate with other software?</h3>
                    </div>
                    <div class="toggle-icon"><i class="fas fa-chevron-down"></i></div>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Yes, BANG ERP offers various integrations:
                        <ul>
                            <li>Accounting software (QuickBooks, Xero, etc.)</li>
                            <li>E-commerce platforms (Shopify, WooCommerce)</li>
                            <li>Payment gateways for online transactions</li>
                            <li>Custom API for your existing systems</li>
                            <li>WhatsApp Business for customer communication</li>
                        </ul>
                        Contact our team for specific integration requirements.
                    </div>
                </div>
            </div>

            <div class="faq-item" data-category="technical">
                <div class="faq-question">
                    <div class="question-content">
                        <div class="question-icon"><i class="fas fa-wifi"></i></div>
                        <h3>What happens if internet connectivity is lost?</h3>
                    </div>
                    <div class="toggle-icon"><i class="fas fa-chevron-down"></i></div>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        BANG ERP has offline capabilities:
                        <ul>
                            <li>Invoices can be created in offline mode</li>
                            <li>Data is stored locally and synced when connection is restored</li>
                            <li>Automatic retry mechanism for failed FBR submissions</li>
                            <li>Real-time sync status indicator in the dashboard</li>
                        </ul>
                        However, we recommend stable internet for real-time FBR compliance.
                    </div>
                </div>
            </div>

            <div class="faq-item" data-category="technical">
                <div class="faq-question">
                    <div class="question-content">
                        <div class="question-icon"><i class="fas fa-mobile-alt"></i></div>
                        <h3>Is there a mobile app available?</h3>
                    </div>
                    <div class="toggle-icon"><i class="fas fa-chevron-down"></i></div>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-content">
                        Yes! BANG ERP is available on multiple platforms:
                        <ul>
                            <li>Web application accessible from any browser</li>
                            <li>Android app available on Google Play Store</li>
                            <li>iOS app available on Apple App Store</li>
                            <li>Full feature parity across all platforms</li>
                            <li>Real-time synchronization between devices</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Section -->
        <div class="faq-stats">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-number" data-count="5000">5,000+</div>
                <div class="stat-label">Active Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-file-invoice"></i></div>
                <div class="stat-number" data-count="1000000">1M+</div>
                <div class="stat-label">Invoices Generated</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-headset"></i></div>
                <div class="stat-number" data-count="24">24/7</div>
                <div class="stat-label">Support Available</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-star"></i></div>
                <div class="stat-number" data-count="99">99%</div>
                <div class="stat-label">Satisfaction Rate</div>
            </div>
        </div>

        <!-- Contact CTA -->
        <div class="contact-cta">
            <div class="contact-icon-wrap"><i class="fas fa-question-circle"></i></div>
            <div class="contact-content">
                <h3>Still Have Questions?</h3>
                <p>Can't find what you're looking for? Our expert support team is available 24/7 to help you with any queries about FBR compliance, invoicing, or technical issues.</p>
                <div class="contact-buttons">
                    <a href="mailto:info@bang.pk" class="contact-btn primary">
                        <i class="fas fa-envelope"></i>
                        Email Support
                    </a>
                    <a href="https://wa.me/923214197290" class="contact-btn secondary" target="_blank">
                        <i class="fab fa-whatsapp"></i>
                        WhatsApp Us
                    </a>
                </div>
            </div>
        </div>
    </main>

    @include('website.include.footer')

    <script>
        // FAQ Accordion functionality
        document.querySelectorAll('.faq-question').forEach(question => {
            question.addEventListener('click', () => {
                const item = question.parentElement;
                const isActive = item.classList.contains('active');
                
                // Close all other items
                document.querySelectorAll('.faq-item').forEach(faq => {
                    faq.classList.remove('active');
                });
                
                // Toggle current item
                if (!isActive) {
                    item.classList.add('active');
                }
            });
        });

        // Category filter functionality
        document.querySelectorAll('.category-tab').forEach(tab => {
            tab.addEventListener('click', () => {
                // Update active tab
                document.querySelectorAll('.category-tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                
                const category = tab.dataset.category;
                
                // Filter FAQ items
                document.querySelectorAll('.faq-item').forEach(item => {
                    if (category === 'all' || item.dataset.category === category) {
                        item.style.display = 'block';
                        item.style.animation = 'fadeInUp 0.5s ease forwards';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });

        // Fade in animation keyframes
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);

        // Animate cards on scroll
        const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.faq-item, .stat-card').forEach((el, i) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = `all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) ${i * 0.1}s`;
            observer.observe(el);
        });

        // Parallax effect on mouse move for hero
        const hero = document.querySelector('.faq-hero');
        const question3d = document.querySelector('.question-3d');

        hero.addEventListener('mousemove', (e) => {
            const rect = hero.getBoundingClientRect();
            const x = (e.clientX - rect.left) / rect.width - 0.5;
            const y = (e.clientY - rect.top) / rect.height - 0.5;

            if (question3d) {
                question3d.style.transform = `rotateY(${-15 + x * 20}deg) rotateX(${10 + y * 15}deg)`;
            }
        });

        hero.addEventListener('mouseleave', () => {
            if (question3d) {
                question3d.style.transform = '';
            }
        });

        // Counter animation for stats
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = counter.dataset.count;
                    let count = 0;
                    const duration = 2000;
                    const increment = target / (duration / 16);
                    
                    const updateCount = () => {
                        count += increment;
                        if (count < target) {
                            counter.textContent = Math.floor(count).toLocaleString() + (counter.textContent.includes('%') ? '%' : counter.textContent.includes('/') ? '/7' : '+');
                            requestAnimationFrame(updateCount);
                        } else {
                            counter.textContent = counter.dataset.original || counter.textContent;
                        }
                    };
                    
                    counter.dataset.original = counter.textContent;
                    updateCount();
                    counterObserver.unobserve(counter);
                }
            });
        }, { threshold: 0.5 });

        document.querySelectorAll('.stat-number').forEach(counter => {
            counterObserver.observe(counter);
        });
    </script>
</body>

</html>
