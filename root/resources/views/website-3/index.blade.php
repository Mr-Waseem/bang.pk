<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bang.pk - Fbr Digital Invoicing</title>
    <style>
        /* Logo Section */
        .logo-container {
            text-align: center;
            margin-bottom: 40px;
            width: 100%;
        }

        .logo-container img {
            max-height: 150px;
            margin: 0 25px;
            opacity: 0.9;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            transition: all 0.4s ease;
            padding: 5px;
            background: rgba(255, 255, 255, 1);
        }

        .logo-container img:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            opacity: 1;
        }

        /* Hero Section */
        .hero-section {
            background:
                linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                url('https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            padding: 80px 0 50px;
            text-align: center;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 80%, rgba(255, 107, 53, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(0, 78, 137, 0.1) 0%, transparent 50%);
            animation: float 20s infinite linear;
        }

        @keyframes float {
            0% {
                transform: translate(0px, 0px) rotate(0deg);
            }

            25% {
                transform: translate(-10px, -20px) rotate(1deg);
            }

            50% {
                transform: translate(0px, -40px) rotate(0deg);
            }

            75% {
                transform: translate(10px, -20px) rotate(-1deg);
            }

            100% {
                transform: translate(0px, 0px) rotate(0deg);
            }
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            width: 100%;
        }

        .hero-initial-text {
            color: #25D366;
        }

        .hero-content h1 {
            font-size: 4rem;
            font-weight: 800;
            color: white;
            margin-bottom: 1.5rem;
            line-height: 1.1;
            animation: fadeInUp 1s ease;
            text-shadow: 0 2px 15px rgba(0, 0, 0, 0.5);
        }

        .hero-content p {
            font-size: 1.5rem;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 2.5rem;
            animation: fadeInUp 1s ease 0.2s backwards;
            font-weight: 300;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            padding: 18px 45px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            border: none;
            transition: all 0.3s ease;
            animation: fadeInUp 1s ease 0.4s backwards;
            position: relative;
            overflow: hidden;
            z-index: 1;
            display: inline-block;
            margin: 0 auto;
        }

        .hero-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
            transition: left 0.5s ease;
            z-index: -1;
            border-radius: 50px;
        }

        .hero-btn:hover::before {
            left: 0;
        }

        .hero-btn:hover {
            transform: translateY(-5px) scale(1.05);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* About Us Section */
        .about-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            position: relative;
            overflow: hidden;
        }

        .about-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(37, 211, 102, 0.05) 0%, transparent 70%);
            z-index: 0;
        }

        .about-content {
            position: relative;
            z-index: 1;
        }

        .about-text {
            padding-right: 40px;
        }

        .about-text h2 {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--dark-color);
            margin-bottom: 25px;
            position: relative;
        }

        .about-text h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 80px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            border-radius: 2px;
        }

        .about-text p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
            margin-bottom: 25px;
        }

        .about-stats {
            display: flex;
            gap: 40px;
            margin-top: 40px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-color);
            display: block;
            line-height: 1;
        }

        .stat-label {
            font-size: 1rem;
            color: var(--gray-color);
            font-weight: 600;
            margin-top: 5px;
        }

        .about-image {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            transform: perspective(1000px) rotateY(-5deg);
            transition: transform 0.5s ease;
        }

        .about-image:hover {
            transform: perspective(1000px) rotateY(0deg);
        }

        .about-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Team Section */
        .team-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            position: relative;
        }

        .team-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(0, 0, 0, 0.1), transparent);
        }

        .section-title {
            text-align: center;
            margin-bottom: 70px;
            position: relative;
        }

        .section-title h2 {
            font-size: 3.2rem;
            font-weight: 800;
            color: var(--dark-color);
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }

        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            border-radius: 2px;
        }

        .section-title p {
            font-size: 1.2rem;
            color: var(--gray-color);
            max-width: 600px;
            margin: 20px auto 0;
            line-height: 1.6;
        }

        .team-member {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin-bottom: 30px;
            text-align: center;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .team-member:hover {
            transform: translateY(-15px);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
        }

        .member-image {
            width: 100%;
            height: 300px;
            overflow: hidden;
            position: relative;
        }

        .member-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .team-member:hover .member-image img {
            transform: scale(1.1);
        }

        .member-info {
            padding: 30px;
        }

        .member-info h4 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 8px;
        }

        .member-info .position {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 15px;
            display: block;
        }

        .member-info p {
            color: var(--gray-color);
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .member-social {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .member-social a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(37, 211, 102, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .member-social a:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-3px);
        }

        /* Videos Section */
        .videos-section {
            padding: 100px 0;
            background: linear-gradient(to bottom, var(--light-color) 0%, #ffffff79 100%);
            position: relative;
        }

        .videos-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.05), transparent);
        }

        .video-item {
            background: rgba(0, 0, 0, 0.02);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            margin-bottom: 40px;
            height: 100%;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .video-item:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.15);
        }

        .video-thumbnail {
            position: relative;
            width: 100%;
            padding-top: 56.25%;
            overflow: hidden;
            cursor: pointer;
            background: #000;
        }

        .video-thumbnail iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        .video-thumbnail::after {
            content: '';
            position: relative;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, transparent 50%, rgba(0, 0, 0, 0.7) 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .video-item:hover .video-thumbnail::after {
            opacity: 1;
        }

        .video-info {
            padding: 30px;
        }

        .video-info h3 {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 20px;
            line-height: 1.4;
            transition: color 0.3s ease;
        }

        .video-item:hover .video-info h3 {
            color: var(--primary-color);
        }

        .speaker-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding: 15px;
            background: rgba(70, 255, 53, 0.05);
            border-radius: 12px;
        }

        .speaker-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin-right: 15px;
            object-fit: cover;
            border: 3px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .speaker-details h5 {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--dark-color);
            margin: 0 0 5px 0;
        }

        .speaker-details p {
            font-size: 0.95rem;
            color: var(--gray-color);
            margin: 0;
            font-weight: 500;
        }

        .contact-info {
            display: flex;
            align-items: center;
            color: var(--primary-color);
            font-weight: 600;
            margin-top: 15px;
            padding: 12px 15px;
            background: rgba(73, 255, 53, 0.1);
            border-radius: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .video-item:hover .contact-info {
            background: rgba(63, 255, 53, 0.15);
            transform: translateX(5px);
        }

        .contact-info i {
            margin-right: 10px;
            font-size: 1.1rem;
        }

        /* Partners Section */
        .partners-section {
            padding: 100px 0;
            background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%);
            position: relative;
        }

        .partners-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(0, 0, 0, 0.1), transparent);
        }

        .partner-logo {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 140px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 30px;
            border: 1px solid rgba(0, 0, 0, 0.03);
            position: relative;
            overflow: hidden;
        }

        .partner-logo::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(56, 255, 53, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .partner-logo:hover::before {
            left: 100%;
        }

        .partner-logo:hover {
            transform: translateY(-8px) scale(1.05);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
            border-color: rgba(37, 246, 41, 0.2);
        }

        .partner-logo img {
            max-width: 100%;
            max-height: 60px;
            object-fit: contain;
            filter: grayscale(100%) brightness(0.8);
            transition: all 0.4s ease;
        }

        .partner-logo:hover img {
            filter: grayscale(0%) brightness(1);
            transform: scale(1.1);
        }

        /* Become Partner Section */
        .become-partner-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #f2f2f2ff 0%, #00000024 100%);
            position: relative;
            overflow: hidden;
        }

        .become-partner-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }

        .become-partner-section .section-title h2,
        .become-partner-section .section-title p {
            color: black;
        }

        .partner-form-container {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 1;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            flex: 1;
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark-color);
            font-size: 1rem;
        }

        .form-control {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e1e5eb;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            background: white;
            box-shadow: 0 0 0 4px rgba(37, 211, 102, 0.2);
        }

        .form-control::placeholder {
            color: #999;
        }

        .form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23112a64' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 20px center;
            background-size: 16px;
            padding-right: 50px;
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .submit-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            border: none;
            padding: 18px 45px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            width: 100%;
            margin-top: 30px;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
            transition: left 0.5s ease;
            z-index: -1;
            border-radius: 50px;
        }

        .submit-btn:hover::before {
            left: 0;
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(37, 211, 102, 0.4);
        }

        .partner-benefits {
            background: rgba(255, 255, 255, 1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            margin-top: 40px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .partner-benefits h3 {
            color: black;
            font-size: 1.8rem;
            margin-bottom: 25px;
            text-align: center;
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
        }

        .benefit-item {
            background: rgb(23 61 245 / 10%);
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .benefit-item:hover {
            transform: translateY(-5px);
            border-color: var(--primary-color);
        }

        .benefit-item i {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 15px;
            display: block;
        }

        .benefit-item h4 {
            color: black;
            font-size: 1.3rem;
            margin-bottom: 10px;
        }

        .benefit-item p {
            color: rgba(0, 0, 0, 1);
            font-size: 0.95rem;
            line-height: 1.5;
        }

        /* Loading animation for videos */
        .video-loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top-color: var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            z-index: 1;
        }

        @keyframes spin {
            to {
                transform: translate(-50%, -50%) rotate(360deg);
            }
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .hero-content h1 {
                font-size: 3.5rem;
            }

            .section-title h2 {
                font-size: 2.8rem;
            }

            .about-text h2 {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 992px) {
            .hero-content h1 {
                font-size: 3rem;
            }

            .hero-content p {
                font-size: 1.3rem;
            }

            .section-title h2 {
                font-size: 2.5rem;
            }

            .video-info h3 {
                font-size: 1.4rem;
            }

            .about-text {
                padding-right: 0;
                margin-bottom: 40px;
            }

            .about-stats {
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 70px 0 30px;
            }

            .hero-content h1 {
                font-size: 2.5rem;
                margin-bottom: 1rem;
            }

            .hero-content p {
                font-size: 1.1rem;
            }

            .hero-btn {
                padding: 15px 35px;
                font-size: 1rem;
            }

            .section-title {
                margin-bottom: 50px;
            }

            .section-title h2 {
                font-size: 2.2rem;
            }

            .section-title p {
                font-size: 1.1rem;
                padding: 0 15px;
            }

            .video-item {
                margin-bottom: 30px;
            }

            .video-info {
                padding: 20px;
            }

            .speaker-info {
                padding: 12px;
            }

            .partner-logo {
                height: 120px;
                padding: 20px;
                margin-bottom: 20px;
            }

            .about-text h2 {
                font-size: 2.2rem;
            }

            .member-image {
                height: 250px;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }

            .partner-form-container {
                padding: 25px;
            }

            .become-partner-section {
                padding: 70px 0;
            }

            .benefits-grid {
                grid-template-columns: 1fr;
            }

            .benefit-item {
                padding: 20px;
            }
        }

        @media (max-width: 576px) {
            .hero-content h1 {
                font-size: 2rem;
            }

            .section-title h2 {
                font-size: 1.8rem;
            }

            .navbar-brand {
                font-size: 1.8rem;
            }

            .video-info h3 {
                font-size: 1.3rem;
            }

            .partner-logo {
                height: 100px;
                padding: 15px;
            }

            .logo-container img {
                margin: 10px;
            }

            .about-stats {
                gap: 20px;
                flex-wrap: wrap;
            }

            .stat-item {
                flex: 1 0 calc(50% - 20px);
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    @include('website.include.header')

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <!-- Logo Section at top -->
            <div class="logo-container">
                <img src="{{asset('root/upload/logo/fbrlogo.jpg')}}" alt="FBR Logo 1">
                <img src="{{asset('root/upload/logo/fbrlogo1.jpg')}}" alt="FBR Logo 2">
                <img src="{{asset('root/upload/logo/pra.jpg')}}" alt="FBR Logo 3">
            </div>

            <!-- Centered Hero Content -->
            <div class="hero-content">
                <h1><span class="hero-initial-text">BANG ERP</span> for FBR Digital Invoicing System</h1>
                <p>Providing FBR-compliant digital invoicing solutions all over Pakistan.</p>
                <a href="{{asset('login')}}"><button class="hero-btn">
                    <i class="fas fa-rocket me-2"></i>Login Now
                </button></a>
            </div>
        </div>
    </section>

    <!-- Videos Section -->
    <section id="videos" class="videos-section">
    <div class="container">
        <div class="section-title">
            <h2>What client says about us</h2>
            <p>Watch inspiring reviews from industry leaders and experts about their experiences with us</p>
        </div>

        <div class="row">
            <!-- Video 1 -->
            <div class="col-lg-6 mb-4">
                <div class="video-item">
                    <div class="video-thumbnail">
                        <div class="video-loading"></div>
                        <iframe src="https://www.youtube.com/embed/tC5TE10MJEs?si=8sKF4_JFzfO-l6_z"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            loading="lazy"></iframe>
                    </div>
                    <div class="video-info">
                        <h3>Tax Professional & Consultant</h3>
                        <div class="speaker-info">
                            <!-- <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&h=100&fit=crop" alt="Speaker" class="speaker-avatar"> -->
                            <div class="speaker-details">
                                <h5>Khurram Ikhlaq</h5>
                                <p>CFO at Akiza Associates</p>
                            </div>
                        </div>
                        <!-- <div class="contact-info">
                            <i class="fas fa-phone"></i>
                            <span>+92 300 1234567</span>
                        </div> -->
                    </div>
                </div>
            </div>

            <!-- Video 2 -->
            <div class="col-lg-6 mb-4">
                <div class="video-item">
                    <div class="video-thumbnail">
                        <iframe src="https://www.youtube.com/embed/YdHzFtRGRyk?si=KVUoCJLHzbEGCGgm" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <div class="video-info">
                        <h3>Tax Professional & Consultant</h3>
                        <div class="speaker-info">
                            <!-- <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100&h=100&fit=crop" alt="Speaker" class="speaker-avatar"> -->
                            <div class="speaker-details">
                                <h5>Muhammad Aoun Abbas</h5>
                                <p>Sh. Sharif Hussain & Co</p>
                            </div>
                        </div>
                        <!-- <div class="contact-info">
                            <i class="fas fa-phone"></i>
                            <span>+92 321 7654321</span>
                        </div> -->
                    </div>
                </div>
            </div>

            <!-- Video 3 -->
            <div class="col-lg-6 mb-4">
                <div class="video-item">
                    <div class="video-thumbnail">
                        <iframe src="https://www.youtube.com/embed/YfZ1_SRud0U?si=86PXV8BM-toE3QLT" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <div class="video-info">
                        <h3>CEO</h3>
                        <div class="speaker-info">
                            <!-- <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&h=100&fit=crop" alt="Speaker" class="speaker-avatar"> -->
                            <div class="speaker-details">
                                <h5>Zaid Ch</h5>
                                <p>CEO as AS Dyeing PVT LTD</p>
                            </div>
                        </div>
                        <!-- <div class="contact-info">
                            <i class="fas fa-phone"></i>
                            <span>+92 333 9876543</span>
                        </div> -->
                    </div>
                </div>
            </div>

            <!-- Video 4 -->
            <div class="col-lg-6 mb-4">
                <div class="video-item">
                    <div class="video-thumbnail">
                        <iframe src="https://www.youtube.com/embed/oNozGSXLvyQ?si=av3ADDNL0d3-19eE" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <div class="video-info">
                        <h3>Tax Professional & Consultant</h3>
                        <div class="speaker-info">
                            <!-- <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop" alt="Speaker" class="speaker-avatar"> -->
                            <div class="speaker-details">
                                <h5>Kashif Saeed</h5>
                                <!-- <p>Sabiha anees trading enterprises</p> -->
                            </div>
                        </div>
                        <!-- <div class="contact-info">
                            <i class="fas fa-phone"></i>
                            <span>+92 345 1122334</span>
                        </div> -->
                    </div>
                </div>
            </div>

            <!-- Video 5 -->
            <div class="col-lg-6 mb-4">
                <div class="video-item">
                    <div class="video-thumbnail">
                        <iframe src="https://www.youtube.com/embed/pOq1DXO3jmI?si=9UmYvJDUzmze1nPo" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <div class="video-info">
                        <h3>Tax Professional & Consultant</h3>
                        <div class="speaker-info">
                            <!-- <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop" alt="Speaker" class="speaker-avatar"> -->
                            <div class="speaker-details">
                                <h5>Muhammad Ramzan Ch</h5>
                                <p>Mindwork Law Associates</p>
                            </div>
                        </div>
                        <!-- <div class="contact-info">
                            <i class="fas fa-phone"></i>
                            <span>+92 345 1122334</span>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Partners Section -->
    <section id="partners" class="partners-section d-none" >
        <div class="container">
            <div class="section-title">
                <h2>Our Trusted Partners</h2>
                <p>Collaborating with industry leaders to deliver excellence</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="partner-logo">
                        <img src="https://images.unsplash.com/photo-1599305445671-ac291c95aaa9?w=200&h=100&fit=crop" alt="Partner 1">
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="partner-logo">
                        <img src="https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=200&h=100&fit=crop" alt="Partner 2">
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="partner-logo">
                        <img src="https://images.unsplash.com/photo-1549923746-c502d488b3ea?w=200&h=100&fit=crop" alt="Partner 3">
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="partner-logo">
                        <img src="https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=200&h=100&fit=crop" alt="Partner 4">
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="partner-logo">
                        <img src="https://images.unsplash.com/photo-1572044162444-ad60f128bdea?w=200&h=100&fit=crop" alt="Partner 5">
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="partner-logo">
                        <img src="https://images.unsplash.com/photo-1560179707-f14e90ef3623?w=200&h=100&fit=crop" alt="Partner 6">
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="partner-logo">
                        <img src="https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=200&h=100&fit=crop" alt="Partner 7">
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-6">
                    <div class="partner-logo">
                        <img src="https://images.unsplash.com/photo-1599305445671-ac291c95aaa9?w=200&h=100&fit=crop" alt="Partner 8">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Become Our Partner Section -->
    <section id="become-partner" class="become-partner-section">
        <div class="container">
            <div class="section-title">
                <h2>Become Our Partner</h2>
                <p>Join our network and grow your business with BANG ERP Solutions</p>
            </div>

            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <div class="partner-form-container">
                         @if(session('success'))
                <div class="alert alert-success" style="padding: 1rem; margin-bottom: 1.5rem; background: #d4edda; color: #155724; border-radius: 4px;">
                    {{ session('success') }}
                </div>
            @endif
            
            @if($errors->any())
                <div class="alert alert-danger" style="padding: 1rem; margin-bottom: 1.5rem; background: #f8d7da; color: #721c24; border-radius: 4px;">
                    <ul style="margin: 0; padding-left: 1.5rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                        <!-- <form id="partnerForm"> -->
                           <form action="{{ url('public_partner') }}" method="POST" id="testForm">
                        @csrf
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="fullName">Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label" for="email">Email Address *</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email address" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="phone">Phone Number *</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="city">City</label>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="Enter your city" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label" for="address">Address</label>
                                    <textarea class="form-control" id="address" name="address" placeholder="Enter your address"></textarea>
                                </div>
                            </div>

                            <button type="submit" class="submit-btn">
                                <i class="fas fa-paper-plane me-2"></i>Submit Partnership Request
                            </button>
                         </form>
                    </div>

                    <div class="partner-benefits">
                        <h3>Why Partner With Us?</h3>
                        <div class="benefits-grid">
                            <div class="benefit-item">
                                <i class="fas fa-chart-line"></i>
                                <h4>Revenue Growth</h4>
                                <p>Increase your revenue streams with our proven FBR compliance solutions</p>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-graduation-cap"></i>
                                <h4>Training & Support</h4>
                                <p>Comprehensive training and 24/7 technical support for you and your clients</p>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-tools"></i>
                                <h4>Marketing Tools</h4>
                                <p>Access to marketing materials, demos, and sales collateral</p>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-handshake"></i>
                                <h4>Dedicated Support</h4>
                                <p>Personal account manager and priority support for all your clients</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- About Us Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-text">
                        <h2>About BANG Digital Solutions</h2>
                        <p>BANG is a leading provider of FBR-compliant digital invoicing solutions across Pakistan. We specialize in helping businesses transition seamlessly to the digital economy with our state-of-the-art ERP systems.</p>
                        <p>Our mission is to simplify tax compliance for businesses of all sizes through innovative technology solutions. With years of experience in digital transformation, we understand the unique challenges faced by Pakistani businesses.</p>
                        <p>We pride ourselves on delivering reliable, secure, and user-friendly solutions that not only meet regulatory requirements but also enhance business efficiency and productivity.</p>

                        <div class="about-stats">
                            <div class="stat-item">
                                <span class="stat-number">500+</span>
                                <span class="stat-label">Clients</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">50+</span>
                                <span class="stat-label">Cities</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">24/7</span>
                                <span class="stat-label">Support</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">99%</span>
                                <span class="stat-label">Satisfaction</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-image">
                        <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="About BANG">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" class="team-section d-none">
        <div class="container">
            <div class="section-title">
                <h2>Meet Our Leadership Team</h2>
                <p>The experts behind our innovative FBR compliance solutions</p>
            </div>

            <div class="row">
                <!-- Team Member 1 -->
                <div class="col-lg-3 col-md-6">
                    <div class="team-member">
                        <div class="member-image">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=300&fit=crop" alt="CEO">
                        </div>
                        <div class="member-info">
                            <h4>Ahmed Khan</h4>
                            <span class="position">CEO & Founder</span>
                            <p>With over 15 years of experience in digital solutions and tax compliance systems.</p>
                            <div class="member-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-facebook"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Member 2 -->
                <div class="col-lg-3 col-md-6">
                    <div class="team-member">
                        <div class="member-image">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=400&h=300&fit=crop" alt="CTO">
                        </div>
                        <div class="member-info">
                            <h4>Sara Ahmed</h4>
                            <span class="position">Chief Technology Officer</span>
                            <p>Expert in ERP systems and FBR compliance with 12+ years of technical leadership.</p>
                            <div class="member-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-github"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Member 3 -->
                <div class="col-lg-3 col-md-6">
                    <div class="team-member">
                        <div class="member-image">
                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&h=300&fit=crop" alt="Head of Sales">
                        </div>
                        <div class="member-info">
                            <h4>Usman Malik</h4>
                            <span class="position">Head of Sales</span>
                            <p>Driving business growth across Pakistan with 10+ years in enterprise solutions.</p>
                            <div class="member-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-facebook"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Team Member 4 -->
                <div class="col-lg-3 col-md-6">
                    <div class="team-member">
                        <div class="member-image">
                            <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=400&h=300&fit=crop" alt="Head of Support">
                        </div>
                        <div class="member-info">
                            <h4>Fatima Raza</h4>
                            <span class="position">Head of Customer Support</span>
                            <p>Ensuring exceptional customer experience with dedicated 24/7 support teams.</p>
                            <div class="member-social">
                                <a href="#"><i class="fab fa-linkedin"></i></a>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                                <a href="#"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('website.include.footer')

    <script>
        function updateActiveNavLink() {
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('.nav-link:not(.nav-cta-btn)');

            let currentSection = '';

            sections.forEach(section => {
                const topBannerHeight = document.querySelector('.top-contact-banner').offsetHeight;
                const navbarHeight = document.querySelector('.navbar').offsetHeight;
                const offset = topBannerHeight + navbarHeight + 100;

                const sectionTop = section.offsetTop - offset;
                const sectionHeight = section.clientHeight;

                if (window.scrollY >= sectionTop && window.scrollY < sectionTop + sectionHeight) {
                    currentSection = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${currentSection}`) {
                    link.classList.add('active');
                }
            });
        }

        // Animate on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    entry.target.style.animation = 'fadeInUp 0.8s ease forwards';
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        // Observe elements for animation
        document.querySelectorAll('.video-item, .partner-logo, .team-member, .about-image').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });

        // Video loading state
        document.querySelectorAll('iframe').forEach(iframe => {
            iframe.addEventListener('load', function() {
                const loadingElement = this.parentElement.querySelector('.video-loading');
                if (loadingElement) {
                    loadingElement.style.display = 'none';
                }
            });
        });

        // Partner Form Submission
        document.getElementById('partnerForm')?.addEventListener('submit', function(e) {
            e.preventDefault();

            // Get form data
            const formData = {
                fullName: document.getElementById('fullName').value,
                email: document.getElementById('email').value,
                phone: document.getElementById('phone').value,
                city: document.getElementById('city').value,
                address: document.getElementById('address').value,
            };

            // Simple validation
            if (!formData.fullName || !formData.email || !formData.phone) {
                alert('Please fill all required fields (*)');
                return;
            }

            // Show success message (In production, this would send to a server)
            alert('Thank you for your partnership request! Our team will contact you within 24 hours.');

            // Reset form
            this.reset();

            // Scroll to top of form
            const formSection = document.getElementById('become-partner');
            const topBannerHeight = document.querySelector('.top-contact-banner').offsetHeight;
            const navbarHeight = document.querySelector('.navbar').offsetHeight;
            const offset = topBannerHeight + navbarHeight + 20;

            const targetPosition = formSection.getBoundingClientRect().top + window.pageYOffset - offset;

            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        });

        // Form field focus effects
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });

            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });

        // Get Started button functionality
        document.querySelector('.hero-btn')?.addEventListener('click', function() {
            const contactSection = document.getElementById('contact');
            const topBannerHeight = document.querySelector('.top-contact-banner').offsetHeight;
            const navbarHeight = document.querySelector('.navbar').offsetHeight;
            const offset = topBannerHeight + navbarHeight + 20;

            const targetPosition = contactSection.getBoundingClientRect().top + window.pageYOffset - offset;

            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        });

        // Add scroll event listener for active nav links
        window.addEventListener('scroll', function() {
            updateActiveNavLink();
        });

        // Initialize animations on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Add active class to home link initially
            const homeLink = document.querySelector('.nav-link[href="#home"]');
            if (homeLink) {
                homeLink.classList.add('active');
            }
        });
    </script>
</body>

</html>