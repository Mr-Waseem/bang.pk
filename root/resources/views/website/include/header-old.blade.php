<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #25d366ff;
            --secondary-color: #004e89;
            --accent-color: #25D366;
            --dark-color: #112a64ff;
            --light-color: #f8f9fa;
            --gray-color: #6c757d;
            --nav-bg-color: #ffffff;
            --whatsapp-green: #25D366;
            --email-green: #34A853;
            --phone-green: #25D366;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* header.css */
        /* Top Contact Banner */
        .top-contact-banner {
            background: linear-gradient(135deg, var(--dark-color), #112a64ff);
            color: white;
            padding: 1px 0;
            font-size: 0.9rem;
            position: relative;
            z-index: 1001;
            border-bottom: 1px solid var(--gray-color);
        }

        .top-contact-banner .container {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            flex-wrap: wrap;
        }

        .top-contact-banner a {
            text-decoration: none !important;
            color: inherit;
        }

        .top-contact-banner a:hover {
            text-decoration: none !important;
        }

        .contact-info-wrapper {
            display: flex;
            align-items: center;
            margin-top: 10px;
            gap: 30px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            padding: 8px 15px;
            border-radius: 6px;
            cursor: pointer;
        }

        .contact-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
        }

        /* Green Icons for specific platforms */
        .contact-item i.fa-phone {
            color: var(--phone-green) !important;
        }

        .contact-item i.fa-whatsapp {
            color: var(--whatsapp-green) !important;
        }

        .contact-item i.fa-envelope {
            color: var(--email-green) !important;
        }

        .contact-item span {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            font-size: 0.95rem;
        }

        /* Navbar */
        .navbar-wrapper {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: var(--nav-bg-color);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border-bottom: 2px solid rgba(53, 255, 90, 0.1);
        }

        .navbar {
            background: var(--nav-bg-color) !important;
            padding: 12px 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .navbar.scrolled {
            padding: 8px 0;
            background: var(--nav-bg-color) !important;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-size: 2.4rem;
            font-weight: 900;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -0.5px;
            position: relative;
            padding-right: 15px;
        }

        .navbar-brand::after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 30px;
            border-radius: 2px;
        }

        .navbar-brand img {
            height: 40px;
            object-fit: contain;
        }

        .navbar-toggler {
            border: none;
            padding: 8px 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 3px rgba(90, 255, 53, 0.2);
            outline: none;
            border-color: var(--primary-color);
        }

        .navbar-toggler-icon {
            transition: all 0.3s ease;
        }

        .navbar-nav {
            gap: 5px;
            align-items: center;
        }

        .nav-item {
            position: relative;
        }

        .nav-link {
            color: var(--dark-color) !important;
            font-weight: 600;
            font-size: 1rem;
            padding: 10px 20px !important;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 107, 53, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .nav-link:hover::before {
            left: 100%;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            border-radius: 2px;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 80%;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-color) !important;
            transform: translateY(-2px);
        }

        .nav-cta-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white !important;
            padding: 12px 28px !important;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1rem;
            margin-left: 10px;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 5px 20px var(--dark-color);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .nav-cta-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            transition: left 0.5s ease;
            z-index: -1;
            border-radius: 10px;
        }

        .nav-cta-btn:hover::before {
            left: 0;
        }

        .nav-cta-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px var(--dark-color);
            color: white !important;
        }

        /* Floating Buttons Container */
        .floating-buttons {
            position: fixed;
            bottom: 40px;
            left: 40px;
            display: flex;
            flex-direction: column;
            gap: 15px;
            z-index: 1000;
        }

        .float-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            color: white;
            text-align: center;
            font-size: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            text-decoration: none;
            position: relative;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .float-btn:hover {
            transform: scale(1.15) translateX(5px);
            color: white;
        }

        .float-btn::before {
            content: attr(data-tooltip);
            position: absolute;
            left: 75px;
            background: rgba(0, 0, 0, 0.85);
            color: white;
            padding: 8px 15px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        .float-btn:hover::before {
            opacity: 1;
            visibility: visible;
        }

        /* WhatsApp Button */
        .whatsapp-float {
            background: linear-gradient(135deg, #25D366, #128C7E);
            animation: pulse-whatsapp 2s infinite;
        }

        .whatsapp-float:hover {
            background: linear-gradient(135deg, #128C7E, #075E54);
            box-shadow: 0 12px 35px rgba(37, 211, 102, 0.5);
        }

        @keyframes pulse-whatsapp {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(37, 211, 102, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
            }
        }

        /* Call Button */
        .call-float {
            background: linear-gradient(135deg, #4285F4, #0d47a1);
            animation: pulse-call 2s infinite;
            animation-delay: 0.5s;
        }

        .call-float:hover {
            background: linear-gradient(135deg, #0d47a1, #1565c0);
            box-shadow: 0 12px 35px rgba(66, 133, 244, 0.5);
        }

        @keyframes pulse-call {
            0% {
                box-shadow: 0 0 0 0 rgba(66, 133, 244, 0.7);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(66, 133, 244, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(66, 133, 244, 0);
            }
        }

        /* Email Button */
        .email-float {
            background: linear-gradient(135deg, #EA4335, #c62828);
            animation: pulse-email 2s infinite;
            animation-delay: 1s;
        }

        .email-float:hover {
            background: linear-gradient(135deg, #c62828, #b71c1c);
            box-shadow: 0 12px 35px rgba(234, 67, 53, 0.5);
        }

        @keyframes pulse-email {
            0% {
                box-shadow: 0 0 0 0 rgba(234, 67, 53, 0.7);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(234, 67, 53, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(234, 67, 53, 0);
            }
        }

        /* Responsive adjustments for header */
        @media (max-width: 992px) {
            /* Hide top contact banner on mobile */
            .top-contact-banner {
                display: none;
            }

            .nav-item .nav-cta-btn {
                display: none;
            }

            .navbar-wrapper {
                position: fixed;
                width: 100%;
                top: 0;
            }

            .navbar {
                padding: 10px 0;
            }

            .navbar-brand {
                font-size: 1.8rem;
            }

            .navbar-brand img {
                height: 35px;
            }

            .navbar-toggler {
                padding: 5px 8px;
                border: 2px solid var(--primary-color);
                border-radius: 8px;
            }

            .navbar-toggler:focus {
                box-shadow: 0 0 0 3px rgba(37, 211, 102, 0.3);
            }

            .navbar-toggler-icon {
                width: 25px;
                height: 20px;
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(37, 211, 102, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='3' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
            }

            .navbar-collapse {
                background: white;
                margin-top: 15px;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
                padding: 20px;
                animation: slideDown 0.3s ease-out;
            }

            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .navbar-nav {
                gap: 5px;
                padding: 10px 0;
            }

            .nav-item {
                width: 100%;
            }

            .nav-link {
                padding: 15px 20px !important;
                border-radius: 10px;
                margin: 5px 0;
                background: linear-gradient(135deg, rgba(37, 211, 102, 0.05), rgba(37, 211, 102, 0.1));
                border-left: 4px solid transparent;
                transition: all 0.3s ease;
            }

            .nav-link:hover,
            .nav-link.active {
                background: linear-gradient(135deg, rgba(37, 211, 102, 0.1), rgba(37, 211, 102, 0.2));
                border-left-color: var(--primary-color);
                transform: translateX(5px);
            }

            .nav-link::after {
                display: none;
            }

            .nav-cta-btn {
                margin: 15px 0 5px 0 !important;
                padding: 15px 28px !important;
                text-align: center;
                width: 100%;
                font-size: 1.1rem;
                box-shadow: 0 8px 20px rgba(37, 211, 102, 0.4);
            }

            .floating-buttons {
                left: 20px;
                bottom: 80px;
                gap: 12px;
            }

            .float-btn {
                width: 50px;
                height: 50px;
                font-size: 22px;
            }

            .float-btn::before {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.6rem;
            }

            .navbar-brand img {
                height: 32px;
            }

            .navbar {
                padding: 8px 0;
            }

            .nav-link {
                font-size: 0.95rem;
                padding: 12px 18px !important;
            }

            .nav-cta-btn {
                padding: 14px 24px !important;
                font-size: 1rem;
            }

            .floating-buttons {
                left: 15px;
                bottom: 70px;
                gap: 10px;
            }

            .float-btn {
                width: 48px;
                height: 48px;
                font-size: 20px;
            }
        }

        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1.4rem;
            }

            .navbar-brand img {
                height: 28px;
            }

            .navbar {
                padding: 6px 0;
            }

            .navbar-collapse {
                padding: 15px;
                margin-top: 12px;
            }

            .nav-link {
                font-size: 0.9rem;
                padding: 12px 15px !important;
            }

            .nav-cta-btn {
                padding: 13px 20px !important;
                font-size: 0.95rem;
            }

            .floating-buttons {
                left: 10px;
                bottom: 60px;
                gap: 8px;
            }

            .float-btn {
                width: 45px;
                height: 45px;
                font-size: 18px;
            }
        }

        @media (max-width: 375px) {
            .navbar-brand {
                font-size: 1.2rem;
            }

            .navbar-brand img {
                height: 26px;
            }

            .container {
                padding-left: 12px;
                padding-right: 12px;
            }

            .navbar-collapse {
                padding: 12px;
            }

            .nav-link {
                font-size: 0.85rem;
                padding: 10px 12px !important;
            }

            .nav-cta-btn {
                padding: 12px 18px !important;
                font-size: 0.9rem;
            }

            .floating-buttons {
                left: 8px;
                bottom: 50px;
                gap: 8px;
            }

            .float-btn {
                width: 42px;
                height: 42px;
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <!-- Top Contact Banner -->
    <div class="top-contact-banner">
        <div class="container">
            <div class="contact-info-wrapper">
                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    <a href="tel:+92123456789"><span>+92 321 4197290</span></a>
                </div>
                <div class="contact-item">
                    <i class="fab fa-whatsapp"></i>
                    <a href="https://wa.me/923214197290" target="_blank"><span>+92 321 4197290</span></a>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <a href="mailto:info@bang.pk"><span>info@bang.pk</span></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Buttons -->
    <div class="floating-buttons">
        <a href="tel:+923214197290" class="float-btn call-float" data-tooltip="Call Now">
            <i class="fas fa-phone-alt"></i>
        </a>
        <a href="https://wa.me/923214197290" class="float-btn whatsapp-float" target="_blank" data-tooltip="WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>        
        <a href="mailto:info@bang.pk" class="float-btn email-float" data-tooltip="Email Us">
            <i class="fas fa-envelope"></i>
        </a>
    </div>

    <!-- Navbar -->
    <div class="navbar-wrapper">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <img src="{{ asset('root/upload/logo/bang-logo.png') }}" alt="Logo" class="img-fluid">
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#videos">Videos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#partners">Partners</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#become-partner">
                                Become Our Partner
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about">About Us</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="#team">Team</a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link nav-cta-btn" href="{{asset('login')}}">
                                <i class="fas fa-handshake me-2"></i>Login Now
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            const navbarWrapper = document.querySelector('.navbar-wrapper');

            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
                navbarWrapper.style.boxShadow = '0 8px 40px rgba(0, 0, 0, 0.12)';
            } else {
                navbar.classList.remove('scrolled');
                navbarWrapper.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.08)';
            }
        });

        // Smooth scrolling for nav links with offset for top banner
        document.querySelectorAll('.navbar .nav-link').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                if (this.getAttribute('href').startsWith('#')) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;

                    const target = document.querySelector(targetId);
                    if (target) {
                        // Update active nav link
                        document.querySelectorAll('.nav-link').forEach(link => {
                            link.classList.remove('active');
                        });
                        this.classList.add('active');

                        // Calculate offset for top banner
                        const topBannerHeight = document.querySelector('.top-contact-banner')?.offsetHeight || 0;
                        const navbarHeight = document.querySelector('.navbar').offsetHeight;
                        const offset = topBannerHeight + navbarHeight + 20;

                        const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - offset;

                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });

                        // Close mobile menu if open
                        if (window.innerWidth < 992) {
                            const navbarCollapse = document.querySelector('.navbar-collapse');
                            if (navbarCollapse.classList.contains('show')) {
                                const bsCollapse = new bootstrap.Collapse(navbarCollapse);
                                bsCollapse.hide();
                            }
                        }
                    }
                }
            });
        });

        // Mobile menu close on click
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 992) {
                    const navbarCollapse = document.querySelector('.navbar-collapse');
                    if (navbarCollapse.classList.contains('show')) {
                        const bsCollapse = new bootstrap.Collapse(navbarCollapse);
                        bsCollapse.hide();
                    }
                }
            });
        });
    </script>
