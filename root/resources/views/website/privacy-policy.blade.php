<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Privacy Policy - BANG Digital Solutions</title>
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
        .policy-hero {
            min-height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 100px 20px 60px;
            position: relative;
            background: linear-gradient(135deg, #0a1628 0%, #112a64 50%, #0d3a5c 100%);
            overflow: hidden;
        }

        /* Animated Grid Background */
        .grid-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(37, 211, 102, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(37, 211, 102, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            animation: gridMove 20s linear infinite;
        }

        @keyframes gridMove {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 50px); }
        }

        /* Glowing orbs */
        .glow-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            z-index: 1;
        }

        .glow-orb.orb1 {
            width: 400px;
            height: 400px;
            background: var(--primary);
            top: -150px;
            right: -100px;
            animation: pulseOrb 8s ease-in-out infinite;
        }

        .glow-orb.orb2 {
            width: 300px;
            height: 300px;
            background: var(--accent);
            bottom: -100px;
            left: -50px;
            animation: pulseOrb 10s ease-in-out infinite reverse;
        }

        @keyframes pulseOrb {
            0%, 100% { transform: scale(1); opacity: 0.3; }
            50% { transform: scale(1.2); opacity: 0.5; }
        }

        /* Floating security icons */
        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 2;
            pointer-events: none;
        }

        .float-icon {
            position: absolute;
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.4rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            animation: floatAround 6s ease-in-out infinite;
        }

        .float-icon:nth-child(1) { top: 15%; left: 8%; animation-delay: 0s; }
        .float-icon:nth-child(2) { top: 25%; right: 10%; animation-delay: 1s; }
        .float-icon:nth-child(3) { bottom: 30%; left: 5%; animation-delay: 2s; }
        .float-icon:nth-child(4) { bottom: 20%; right: 8%; animation-delay: 0.5s; }
        .float-icon:nth-child(5) { top: 50%; left: 15%; animation-delay: 1.5s; }

        @keyframes floatAround {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            25% { transform: translateY(-15px) rotate(5deg); }
            75% { transform: translateY(10px) rotate(-5deg); }
        }

        .policy-hero .container {
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
        }

        /* ===== 3D Shield Animation ===== */
        .animation-container {
            width: 380px;
            height: 380px;
            perspective: 1200px;
            flex-shrink: 0;
            position: relative;
        }

        .shield-3d {
            width: 100%;
            height: 100%;
            position: relative;
            transform-style: preserve-3d;
            animation: floatShield 6s ease-in-out infinite;
        }

        @keyframes floatShield {
            0%, 100% { transform: rotateY(-10deg) rotateX(5deg) translateY(0); }
            50% { transform: rotateY(-10deg) rotateX(5deg) translateY(-20px); }
        }

        .shield-main {
            position: absolute;
            width: 200px;
            height: 240px;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background: linear-gradient(180deg, #1a3a6c, #0d2444);
            border-radius: 100px 100px 20px 20px;
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
            box-shadow: 
                0 30px 60px rgba(0, 0, 0, 0.5),
                inset 0 2px 0 rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .shield-main::before {
            content: '';
            position: absolute;
            top: 4px;
            left: 4px;
            right: 4px;
            bottom: 4px;
            background: linear-gradient(180deg, rgba(37, 211, 102, 0.2), transparent);
            clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
            border-radius: inherit;
        }

        .shield-icon {
            font-size: 4rem;
            color: var(--primary);
            position: relative;
            z-index: 2;
            animation: iconPulse 2s ease-in-out infinite;
        }

        @keyframes iconPulse {
            0%, 100% { transform: scale(1); filter: drop-shadow(0 0 10px rgba(37, 211, 102, 0.5)); }
            50% { transform: scale(1.1); filter: drop-shadow(0 0 25px rgba(37, 211, 102, 0.8)); }
        }

        .shield-text {
            color: white;
            font-weight: 700;
            font-size: 0.9rem;
            margin-top: 10px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* Orbiting elements */
        .orbit {
            position: absolute;
            width: 320px;
            height: 320px;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            border: 1px dashed rgba(37, 211, 102, 0.2);
            border-radius: 50%;
            animation: orbitRotate 15s linear infinite;
        }

        .orbit-dot {
            position: absolute;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
            box-shadow: 0 5px 20px rgba(37, 211, 102, 0.4);
        }

        .orbit-dot:nth-child(1) { top: -20px; left: 50%; transform: translateX(-50%); }
        .orbit-dot:nth-child(2) { bottom: -20px; left: 50%; transform: translateX(-50%); }
        .orbit-dot:nth-child(3) { left: -20px; top: 50%; transform: translateY(-50%); }
        .orbit-dot:nth-child(4) { right: -20px; top: 50%; transform: translateY(-50%); }

        @keyframes orbitRotate {
            from { transform: translate(-50%, -50%) rotate(0deg); }
            to { transform: translate(-50%, -50%) rotate(360deg); }
        }

        /* Counter-rotate icons to keep them upright */
        .orbit-dot i {
            animation: counterRotate 15s linear infinite;
        }

        @keyframes counterRotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(-360deg); }
        }

        /* ===== Content Section ===== */
        .policy-content {
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

        .policy-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 30px;
            margin-bottom: 50px;
        }

        .policy-card {
            background: linear-gradient(180deg, #fafbfc, #f5f7fa);
            border-radius: 20px;
            padding: 35px;
            border: 1px solid rgba(0, 0, 0, 0.04);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
        }

        .policy-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .policy-card:hover::before {
            transform: scaleX(1);
        }

        .policy-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.12);
        }

        .policy-card .card-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, rgba(37, 211, 102, 0.1), rgba(0, 78, 137, 0.1));
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .policy-card h3 {
            font-size: 1.4rem;
            color: var(--dark);
            margin-bottom: 15px;
        }

        .policy-card p {
            color: #4a5a6a;
            line-height: 1.7;
        }

        /* Full width card */
        .policy-card.full-width {
            grid-column: span 2;
        }

        /* Contact Section */
        .contact-section {
            background: linear-gradient(135deg, var(--dark), #0d3a5c);
            border-radius: 20px;
            padding: 50px;
            color: white;
            display: flex;
            align-items: center;
            gap: 40px;
        }

        .contact-icon {
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
            animation: contactPulse 3s ease-in-out infinite;
        }

        @keyframes contactPulse {
            0%, 100% { box-shadow: 0 15px 40px rgba(37, 211, 102, 0.3); }
            50% { box-shadow: 0 20px 60px rgba(37, 211, 102, 0.5); }
        }

        .contact-info h3 {
            font-size: 1.6rem;
            margin-bottom: 10px;
        }

        .contact-info p {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .contact-info a {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.1);
            padding: 12px 24px;
            border-radius: 50px;
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .contact-info a:hover {
            background: var(--primary);
            border-color: var(--primary);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .policy-hero .container { flex-direction: column-reverse; text-align: center; gap: 40px; }
            .hero-text h1 { font-size: 2.4rem; }
            .hero-badges { justify-content: center; }
            .animation-container { width: 300px; height: 300px; }
            .shield-main { width: 160px; height: 190px; }
            .orbit { width: 260px; height: 260px; }
            .policy-grid { grid-template-columns: 1fr; }
            .policy-card.full-width { grid-column: span 1; }
            .contact-section { flex-direction: column; text-align: center; }
        }

        @media (max-width: 768px) {
            .policy-hero { padding: 80px 15px 40px; min-height: auto; }
            .hero-text h1 { font-size: 2rem; }
            .policy-content { margin: -30px 15px 40px; padding: 30px 20px; }
            .float-icon { display: none; }
        }
    </style>
</head>

<body>
    @include('website.include.header')

    <section class="policy-hero">
        <!-- Grid Background -->
        <div class="grid-bg"></div>

        <!-- Glowing Orbs -->
        <div class="glow-orb orb1"></div>
        <div class="glow-orb orb2"></div>

        <!-- Floating Icons -->
        <div class="floating-elements">
            <div class="float-icon"><i class="fas fa-lock"></i></div>
            <div class="float-icon"><i class="fas fa-shield-alt"></i></div>
            <div class="float-icon"><i class="fas fa-user-shield"></i></div>
            <div class="float-icon"><i class="fas fa-key"></i></div>
            <div class="float-icon"><i class="fas fa-fingerprint"></i></div>
        </div>

        <div class="container">
            <div class="hero-text">
                <h1>Privacy <span>Policy</span></h1>
                <p>Your privacy is our priority. We are committed to protecting your personal data in accordance with FBR regulations and international best practices. Learn how we collect, use, and secure your information.</p>
                <div class="hero-badges">
                    <div class="hero-badge">
                        <i class="fas fa-shield-alt"></i>
                        <span>Data Protected</span>
                    </div>
                    <div class="hero-badge">
                        <i class="fas fa-certificate"></i>
                        <span>FBR Compliant</span>
                    </div>
                    <div class="hero-badge">
                        <i class="fas fa-lock"></i>
                        <span>Encrypted</span>
                    </div>
                </div>
            </div>

            <div class="animation-container">
                <div class="shield-3d">
                    <!-- Orbiting elements -->
                    <div class="orbit">
                        <div class="orbit-dot"><i class="fas fa-check"></i></div>
                        <div class="orbit-dot"><i class="fas fa-lock"></i></div>
                        <div class="orbit-dot"><i class="fas fa-eye-slash"></i></div>
                        <div class="orbit-dot"><i class="fas fa-database"></i></div>
                    </div>

                    <!-- Main Shield -->
                    <div class="shield-main">
                        <i class="fas fa-user-shield shield-icon"></i>
                        <span class="shield-text">Secure</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main class="policy-content" id="policy">
        <div class="content-header">
            <h2>How We Protect Your Data</h2>
            <p>Last updated: January 2026</p>
        </div>

        <div class="policy-grid">
            <div class="policy-card">
                <div class="card-icon"><i class="fas fa-database"></i></div>
                <h3>Information We Collect</h3>
                <p>We collect only essential information for FBR-compliant invoicing: business names, invoice data, contact details, and transaction metadata. Sensitive payment data is processed by trusted partners and never stored in plain text.</p>
            </div>

            <div class="policy-card">
                <div class="card-icon"><i class="fas fa-cogs"></i></div>
                <h3>How We Use Data</h3>
                <p>Your data is used to generate compliant invoices, provide business reporting, and support audit requirements. Aggregated anonymized data helps us improve platform performance and reliability.</p>
            </div>

            <div class="policy-card">
                <div class="card-icon"><i class="fas fa-shield-alt"></i></div>
                <h3>Security Measures</h3>
                <p>We employ industry-standard TLS encryption for data in transit and strong encryption at rest. Access controls, comprehensive logging, and periodic audits ensure compliance with FBR and internal policies.</p>
            </div>

            <div class="policy-card">
                <div class="card-icon"><i class="fas fa-user-check"></i></div>
                <h3>Your Rights</h3>
                <p>You have the right to access, correct, or delete your personal data. Submit requests to our privacy team and we'll assist you according to applicable laws and platform policies.</p>
            </div>
        </div>

        <div class="contact-section">
            <div class="contact-icon"><i class="fas fa-envelope"></i></div>
            <div class="contact-info">
                <h3>Privacy Inquiries</h3>
                <p>For questions about FBR data handling, privacy concerns, or data access requests, our dedicated privacy team is here to help.</p>
                <a href="mailto:info@bang.pk">
                    <i class="fas fa-paper-plane"></i>
                    Contact Privacy Team
                </a>
            </div>
        </div>
    </main>

    @include('website.include.footer')

    <script>
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

        document.querySelectorAll('.policy-card').forEach((el, i) => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = `all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275) ${i * 0.15}s`;
            observer.observe(el);
        });

        // Parallax effect on mouse move for hero
        const hero = document.querySelector('.policy-hero');
        const shield3d = document.querySelector('.shield-3d');

        hero.addEventListener('mousemove', (e) => {
            const rect = hero.getBoundingClientRect();
            const x = (e.clientX - rect.left) / rect.width - 0.5;
            const y = (e.clientY - rect.top) / rect.height - 0.5;

            if (shield3d) {
                shield3d.style.transform = `rotateY(${-10 + x * 25}deg) rotateX(${5 + y * 15}deg)`;
            }
        });

        hero.addEventListener('mouseleave', () => {
            if (shield3d) {
                shield3d.style.transform = '';
            }
        });
    </script>
</body>

</html>