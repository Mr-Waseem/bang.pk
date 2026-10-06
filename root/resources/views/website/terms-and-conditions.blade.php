<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terms & Conditions - BANG Digital Solutions</title>
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
        .terms-hero {
            min-height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 100px 20px 60px;
            position: relative;
            background: linear-gradient(135deg, #0a1628 0%, #112a64 50%, #0d3a5c 100%);
            overflow: hidden;
        }

        /* Animated particles */
        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .particle {
            position: absolute;
            width: 6px;
            height: 6px;
            background: var(--primary);
            border-radius: 50%;
            opacity: 0.6;
            animation: floatParticle 8s infinite ease-in-out;
        }

        .particle:nth-child(1) { left: 10%; top: 20%; animation-delay: 0s; }
        .particle:nth-child(2) { left: 20%; top: 60%; animation-delay: 1s; width: 8px; height: 8px; }
        .particle:nth-child(3) { left: 35%; top: 30%; animation-delay: 2s; }
        .particle:nth-child(4) { left: 50%; top: 70%; animation-delay: 0.5s; width: 10px; height: 10px; }
        .particle:nth-child(5) { left: 65%; top: 25%; animation-delay: 1.5s; }
        .particle:nth-child(6) { left: 75%; top: 55%; animation-delay: 2.5s; width: 7px; height: 7px; }
        .particle:nth-child(7) { left: 85%; top: 35%; animation-delay: 3s; }
        .particle:nth-child(8) { left: 90%; top: 75%; animation-delay: 0.8s; }

        @keyframes floatParticle {
            0%, 100% { transform: translateY(0) scale(1); opacity: 0.6; }
            50% { transform: translateY(-30px) scale(1.2); opacity: 1; }
        }

        /* Floating geometric shapes */
        .geo-shape {
            position: absolute;
            z-index: 1;
            opacity: 0.15;
        }

        .geo-shape.circle {
            width: 300px;
            height: 300px;
            border: 3px solid var(--primary);
            border-radius: 50%;
            top: -80px;
            right: -80px;
            animation: rotateShape 20s linear infinite;
        }

        .geo-shape.square {
            width: 200px;
            height: 200px;
            border: 3px solid #fff;
            bottom: -60px;
            left: -60px;
            animation: rotateShape 25s linear infinite reverse;
        }

        .geo-shape.triangle {
            width: 0;
            height: 0;
            border-left: 80px solid transparent;
            border-right: 80px solid transparent;
            border-bottom: 140px solid rgba(37, 211, 102, 0.2);
            top: 30%;
            right: 15%;
            animation: floatShape 6s ease-in-out infinite;
        }

        @keyframes rotateShape {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes floatShape {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }

        .terms-hero .container {
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

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(37, 211, 102, 0.15);
            border: 1px solid rgba(37, 211, 102, 0.3);
            padding: 12px 24px;
            border-radius: 50px;
            color: var(--primary);
            font-weight: 600;
        }

        .hero-badge i {
            font-size: 1.2rem;
        }

        /* ===== 3D Document Animation ===== */
        .animation-container {
            width: 350px;
            height: 350px;
            perspective: 1200px;
            flex-shrink: 0;
        }

        .document-3d {
            width: 100%;
            height: 100%;
            position: relative;
            transform-style: preserve-3d;
            animation: floatDocument 6s ease-in-out infinite;
        }

        @keyframes floatDocument {
            0%, 100% { transform: rotateY(-15deg) rotateX(5deg) translateY(0); }
            50% { transform: rotateY(-15deg) rotateX(5deg) translateY(-15px); }
        }

        .doc-page {
            position: absolute;
            width: 220px;
            height: 280px;
            background: linear-gradient(180deg, #ffffff, #f8fafc);
            border-radius: 12px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4);
            padding: 25px;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        .doc-page::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            border-radius: 12px 12px 0 0;
        }

        .doc-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e5e9ef;
        }

        .doc-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
        }

        .doc-title {
            font-weight: 700;
            color: var(--dark);
            font-size: 0.95rem;
        }

        .doc-lines {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .doc-line {
            height: 8px;
            background: linear-gradient(90deg, #e0e5eb, #f0f3f6);
            border-radius: 4px;
            position: relative;
            overflow: hidden;
        }

        .doc-line::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(37, 211, 102, 0.3), transparent);
            animation: shimmer 2s infinite;
        }

        .doc-line:nth-child(1) { width: 100%; animation-delay: 0s; }
        .doc-line:nth-child(2) { width: 85%; animation-delay: 0.2s; }
        .doc-line:nth-child(3) { width: 95%; animation-delay: 0.4s; }
        .doc-line:nth-child(4) { width: 70%; animation-delay: 0.6s; }
        .doc-line:nth-child(5) { width: 90%; animation-delay: 0.8s; }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        .doc-stamp {
            position: absolute;
            bottom: 25px;
            right: 25px;
            width: 60px;
            height: 60px;
            border: 3px solid var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-weight: 800;
            font-size: 0.7rem;
            text-align: center;
            animation: stampPulse 2s ease-in-out infinite;
        }

        @keyframes stampPulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.8; }
        }

        /* Floating elements around document */
        .floating-icon {
            position: absolute;
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.3rem;
            animation: floatIcon 4s ease-in-out infinite;
        }

        .floating-icon:nth-child(1) { top: 10%; left: 0; animation-delay: 0s; }
        .floating-icon:nth-child(2) { top: 60%; left: -10%; animation-delay: 1s; }
        .floating-icon:nth-child(3) { top: 20%; right: 0; animation-delay: 0.5s; }
        .floating-icon:nth-child(4) { bottom: 10%; right: 5%; animation-delay: 1.5s; }

        @keyframes floatIcon {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-10px) rotate(5deg); }
        }

        /* ===== Content Section ===== */
        .terms-content {
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

        .terms-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
            margin-bottom: 50px;
        }

        .terms-card {
            background: linear-gradient(180deg, #fafbfc, #f5f7fa);
            border-radius: 16px;
            padding: 30px;
            border: 1px solid rgba(0, 0, 0, 0.04);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        .terms-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 0;
            background: linear-gradient(180deg, var(--primary), var(--accent));
            transition: height 0.4s ease;
        }

        .terms-card:hover::before {
            height: 100%;
        }

        .terms-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
        }

        .terms-card .card-number {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .terms-card h3 {
            font-size: 1.3rem;
            color: var(--dark);
            margin-bottom: 12px;
        }

        .terms-card p {
            color: #4a5a6a;
            line-height: 1.7;
        }

        /* Features Section */
        .features-section {
            background: linear-gradient(135deg, var(--dark), #0d3a5c);
            border-radius: 20px;
            padding: 40px;
            color: white;
        }

        .features-section h3 {
            text-align: center;
            font-size: 1.6rem;
            margin-bottom: 30px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .feature-card {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.4s ease;
        }

        .feature-card:hover {
            background: rgba(255, 255, 255, 0.12);
            transform: translateY(-5px);
        }

        .feature-card .icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary), #32e67a);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 1.8rem;
            color: white;
            box-shadow: 0 10px 30px rgba(37, 211, 102, 0.3);
        }

        .feature-card h4 {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .feature-card p {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .terms-hero .container { flex-direction: column-reverse; text-align: center; gap: 40px; }
            .hero-text h1 { font-size: 2.4rem; }
            .animation-container { width: 280px; height: 280px; }
            .terms-grid { grid-template-columns: 1fr; }
            .features-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .terms-hero { padding: 80px 15px 40px; min-height: auto; }
            .hero-text h1 { font-size: 2rem; }
            .terms-content { margin: -30px 15px 40px; padding: 30px 20px; }
            .doc-page { width: 180px; height: 230px; padding: 18px; }
        }
    </style>
</head>

<body>
    @include('website.include.header')

    <section class="terms-hero">
        <!-- Particles -->
        <div class="particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>

        <!-- Geometric Shapes -->
        <div class="geo-shape circle"></div>
        <div class="geo-shape square"></div>
        <div class="geo-shape triangle"></div>

        <div class="container">
            <div class="hero-text">
                <h1>Terms &amp; <span>Conditions</span></h1>
                <p>These terms govern your use of BANG Digital Solutions' FBR-compliant invoicing platform. Please review carefully to understand your rights, obligations, and how we protect your business data.</p>
                <div class="hero-badge">
                    <i class="fas fa-shield-alt"></i>
                    <span>FBR Compliant & Legally Binding</span>
                </div>
            </div>

            <div class="animation-container">
                <div class="document-3d">
                    <!-- Floating Icons -->
                    <div class="floating-icon"><i class="fas fa-check"></i></div>
                    <div class="floating-icon"><i class="fas fa-lock"></i></div>
                    <div class="floating-icon"><i class="fas fa-file-signature"></i></div>
                    <div class="floating-icon"><i class="fas fa-balance-scale"></i></div>

                    <!-- 3D Document -->
                    <div class="doc-page">
                        <div class="doc-header">
                            <div class="doc-icon"><i class="fas fa-file-contract"></i></div>
                            <div class="doc-title">Terms Agreement</div>
                        </div>
                        <div class="doc-lines">
                            <div class="doc-line"></div>
                            <div class="doc-line"></div>
                            <div class="doc-line"></div>
                            <div class="doc-line"></div>
                            <div class="doc-line"></div>
                        </div>
                        <div class="doc-stamp">FBR<br>VALID</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main class="terms-content">
        <div class="content-header">
            <h2>Agreement Terms</h2>
            <p>Last updated: January 2026</p>
        </div>

        <div class="terms-grid">
            <div class="terms-card">
                <div class="card-number">1</div>
                <h3>Acceptance of Terms</h3>
                <p>By accessing or using BANG Digital Solutions' platform, you agree to be bound by these terms. These govern your use of our FBR-compliant digital invoicing software and related services.</p>
            </div>

            <div class="terms-card">
                <div class="card-number">2</div>
                <h3>Use of Service</h3>
                <p>Clients must provide accurate business and tax information required for FBR compliance. Misuse or fraudulent activity may result in immediate termination of services.</p>
            </div>

            <div class="terms-card">
                <div class="card-number">3</div>
                <h3>Intellectual Property</h3>
                <p>All software, designs, logos, and content remain the exclusive property of BANG Digital Solutions. Clients receive a limited, non-transferable license for platform use.</p>
            </div>

            <div class="terms-card">
                <div class="card-number">4</div>
                <h3>Liability & Warranties</h3>
                <p>Services are provided with reasonable care. For enterprise SLA commitments, uptime guarantees, and liability specifics, please contact our sales team.</p>
            </div>
        </div>

        <div class="features-section">
            <h3>Why Trust BANG Digital Solutions?</h3>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="icon"><i class="fas fa-certificate"></i></div>
                    <h4>FBR Certified</h4>
                    <p>Fully compliant with Federal Board of Revenue standards and validations for digital invoicing.</p>
                </div>
                <div class="feature-card">
                    <div class="icon"><i class="fas fa-shield-alt"></i></div>
                    <h4>Enterprise Security</h4>
                    <p>End-to-end encryption, access controls, and comprehensive audit logging protect your data.</p>
                </div>
                <div class="feature-card">
                    <div class="icon"><i class="fas fa-headset"></i></div>
                    <h4>24/7 Support</h4>
                    <p>Dedicated partner support with SLA-backed response times and priority handling.</p>
                </div>
            </div>
        </div>
    </main>

    @include('website.include.footer')

    <script>
        // Animate cards on scroll
        const observerOptions = { threshold: 0.1, rootMargin: '0px 0px -50px 0px' };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.terms-card, .feature-card').forEach((el, i) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = `all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) ${i * 0.1}s`;
            observer.observe(el);
        });

        // Parallax effect on mouse move for hero
        const hero = document.querySelector('.terms-hero');
        const doc3d = document.querySelector('.document-3d');

        hero.addEventListener('mousemove', (e) => {
            const rect = hero.getBoundingClientRect();
            const x = (e.clientX - rect.left) / rect.width - 0.5;
            const y = (e.clientY - rect.top) / rect.height - 0.5;

            if (doc3d) {
                doc3d.style.transform = `rotateY(${-15 + x * 20}deg) rotateX(${5 + y * 10}deg)`;
            }
        });

        hero.addEventListener('mouseleave', () => {
            if (doc3d) {
                doc3d.style.transform = '';
            }
        });
    </script>
</body>

</html>