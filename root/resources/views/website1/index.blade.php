<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bang.pk - Bangerp.com - Bangerp.pk - Bang ERP - FBR Digital Invoicing System – e-Invoicing & Fast Tax Compliance </title>
    <meta name="description" content="FBR-approved digital invoicing system for Pakistan. Generate compliant e-invoices, file GST & sales tax fast, and meet FBR tax regulations seamlessly.">
    <meta name="keywords" content="Bang.pk, Bangerp.com, Bangerp.pk, Bang ERP, FBR Digital Invoice, FBR e-Invoicing, Pakistan tax compliance, FBR invoice system, sales tax filing, GST invoicing, FBR registered invoice, digital tax invoice Pakistan">
    <style>
        :root {
            --fbr-blue: #005baa;
            --fbr-green: #2e7d32;
            --fbr-orange: #25D366;
            --text-light: #ffffff;
            --text-dark: #333333;
            --topbar-bg: #003366;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        /* TOP CONTACT BAR */
        .top-contact-bar {
            background-color: var(--topbar-bg);
            color: var(--text-light);
            padding: 0.5rem 0;
            font-size: 0.9rem;
        }
        
        .contact-container {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            flex-wrap: wrap;
            gap: 1.5rem;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
        }
        
        .contact-item i {
            margin-right: 0.5rem;
            color: var(--fbr-orange);
        }
        
        .contact-item a {
            color: var(--text-light);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .contact-item a:hover {
            color: var(--fbr-orange);
        }
        
        /* Floating Buttons */
        .float-btn {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 40px;
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            z-index: 100;
            transition: all 0.3s ease;
        }
        
        .float-btn:hover {
            transform: scale(1.1);
        }
        
        .whatsapp-btn {
            right: 40px;
            background-color: #25D366;
            color: white;
        }
        
        .contact-btn {
            left: 40px;
            background-color: var(--fbr-orange);
            color: white;
        }
        
        body {
            line-height: 1.6;
            color: var(--text-dark);
            background-color: #f5f5f5;
        }
        
        header {
            background: linear-gradient(135deg, #ffffff, #005baa);
            color: var(--text-light);
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .logo {
            height: 70px;
        }
        
        nav ul {
            display: flex;
            list-style: none;
            flex-wrap: wrap;
        }
        
        nav ul li {
            margin-left: 1.5rem;
        }
        
        nav ul li a {
            color: var(--text-light);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        nav ul li a:hover {
            color: var(--fbr-orange);
        }
        
        /* HERO */
        .hero {
            background: url('root/upload/banner.jpg');
            height: 400px;
            display: flex;
            align-items: center;
            text-align: center;
            color: var(--text-light);
            position: relative;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
            width: 100%;
            padding: 2rem;
        }
        
        .hero h1 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .hero-images-row {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .hero-image {
            width: 120px;
            height: auto;
            border-radius: 6px;
        }

        .btn {
            display: inline-block;
            background-color: var(--fbr-orange);
            color: var(--text-light);
            padding: 0.8rem 1.8rem;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            margin-top: 1rem;
            transition: all 0.3s ease;
            width: 30%;
        }

        .btn:hover {
            background-color: #08a642ff;
            transform: translateY(-2px);
        }

        section {
            padding: 3rem 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 2rem;
            color: var(--fbr-blue);
        }

        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin: 2rem 0;
        }

        .feature-card {
            background: var(--text-light);
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .compliance-section {
            background-color: var(--fbr-blue);
            color: var(--text-light);
            padding: 3rem 0;
        }

        .compliance-content {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
        }
        
        /* VIDEO STYLES FOR DEMO SECTION */
        .video-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .demo-video-wrapper {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            height: 0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .demo-video-wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        /* MOBILE RESPONSIVE FIXES */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                text-align: center;
            }

            nav ul {
                justify-content: center;
                margin-top: 10px;
                gap: 10px;
            }

            nav ul li {
                margin: 0;
            }

            .hero {
                height: auto;
                padding: 50px 0;
            }

            .hero h1 {
                font-size: 1.7rem;
                line-height: 2.2rem;
            }

            .hero-image {
                width: 90px;
            }

            .btn {
                width: 80%;
            }

            /* Partner Form Fixes */
            #registration form div[style*="grid"] {
                grid-template-columns: 1fr !important;
            }

            /* Footer */
            .footer-links {
                flex-direction: column;
                gap: 10px;
            }

            .float-btn {
                width: 50px;
                height: 50px;
                font-size: 20px;
                bottom: 20px;
            }

            .whatsapp-btn { right: 20px; }
            .contact-btn { left: 20px; }

            .contact-container {
                justify-content: center;
                gap: 0.7rem;
            }
        }
        
        /* TESTIMONIAL CAROUSEL STYLES */
        .testimonials-container {
            position: relative;
            padding: 2rem 0;
        }
        
        .testimonial-carousel {
            display: flex;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            min-height: 700px;
        }
        
        .testimonial-slide {
            min-width: 100%;
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: transform 0.5s ease;
        }
        
        .testimonial-slide.active {
            display: flex !important;
        }
        
        /* Video thumbnail styles for testimonial */
        .testimonial-video-wrapper {
            position: relative;
            width: 100%;
            /* max-width: 800px; */
            margin-bottom: 0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            background: #000;
        }
        
        .video-thumbnail {
            position: relative;
            width: 100%;
            height: 100%;
            display: block;
            transition: opacity 0.3s ease;
        }
        
        .video-thumbnail.active {
            display: none;
        }
        
        .thumbnail-image {
            width: 100%;
            /* height: 400px; */
            object-fit: cover;
            display: block;
        }
        
        /* Play button overlay */
        .play-button-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.3);
            transition: background 0.3s ease;
        }
        
        .video-thumbnail:hover .play-button-overlay {
            background: rgba(0, 0, 0, 0.5);
        }
        
        .play-button {
            width: 80px;
            height: 80px;
            background: rgba(52, 152, 219, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: scale(1);
            transition: transform 0.3s ease, background 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        
        .video-thumbnail:hover .play-button {
            transform: scale(1.1);
            background: rgba(41, 128, 185, 0.9);
        }
        
        .play-button i {
            font-size: 2.5rem;
            color: white;
            margin-left: 5px;
        }
        
        /* YouTube iframe styles for testimonial */
        .youtube-video {
            width: 100%;
            height: 400px;
            display: block;
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            border: none;
            transition: opacity 0.5s ease;
        }
        
        .youtube-video.active {
            opacity: 1;
            position: relative;
        }
        
        /* Extra space below video */
        .spacer {
            height: 2rem;
            width: 100%;
        }
        
        .testimonial-info {
            text-align: center;
            max-width: 800px;
            padding: 0 1rem;
        }
        
        .client-title {
            font-size: 1.8rem;
            color: #2c3e50;
            margin-bottom: 1.2rem;
            font-weight: 600;
            line-height: 1.4;
            padding: 0 1rem;
        }
        
        .client-name {
            font-size: 1.1rem;
            color: #7f8c8d;
            margin-bottom: 2rem;
            font-style: italic;
            padding: 0 1rem;
        }
        
        .contact-info {
            display: inline-flex;
            align-items: center;
            background: #f8f9fa;
            padding: 1rem 2rem;
            border-radius: 50px;
            border: 1px solid #e9ecef;
            margin-top: 0.5rem;
        }
        
        .contact-info i {
            color: #3498db;
            margin-right: 0.7rem;
            font-size: 1.1rem;
        }
        
        .contact-number {
            font-size: 1.1rem;
            font-weight: 600;
            color: #2c3e50;
        }
        
        /* Navigation buttons */
        .carousel-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.9);
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: #2c3e50;
            cursor: pointer;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 10;
        }
        
        .carousel-btn:hover {
            background: #3498db;
            color: white;
            transform: translateY(-50%) scale(1.1);
        }
        
        .prev-btn {
            left: 10px;
        }
        
        .next-btn {
            right: 10px;
        }
        
        /* Dots indicator */
        .carousel-dots {
            display: flex;
            justify-content: center;
            margin-top: 2.5rem;
            gap: 12px;
        }
        
        .dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: #ddd;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        
        .dot.active {
            background-color: #3498db;
            transform: scale(1.3);
        }
        
        /* Responsive adjustments for testimonial carousel */
        @media (max-width: 992px) {
            .testimonial-carousel {
                min-height: 650px;
            }
            
            .thumbnail-image,
            .youtube-video {
                height: 350px;
            }
            
            .play-button {
                width: 70px;
                height: 70px;
            }
            
            .play-button i {
                font-size: 2rem;
            }
            
            .client-title {
                font-size: 1.6rem;
            }
            
            .testimonial-slide {
                padding: 2.5rem 2rem;
            }
        }
        
        @media (max-width: 768px) {
            .testimonial-carousel {
                min-height: 600px;
            }
            
            .testimonial-slide {
                padding: 2rem 1.5rem;
            }
            
            .thumbnail-image,
            .youtube-video {
                height: 300px;
            }
            
            .play-button {
                width: 60px;
                height: 60px;
            }
            
            .play-button i {
                font-size: 1.8rem;
            }
            
            .client-title {
                font-size: 1.4rem;
                margin-bottom: 1rem;
            }
            
            .client-name {
                margin-bottom: 1.5rem;
            }
            
            .contact-info {
                padding: 0.8rem 1.5rem;
            }
            
            .carousel-btn {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
            
            .spacer {
                height: 1.5rem;
            }
        }
        
        @media (max-width: 576px) {
            .section-title {
                font-size: 2rem;
            }
            
            .testimonial-carousel {
                min-height: 550px;
            }
            
            .thumbnail-image,
            .youtube-video {
                height: 250px;
            }
            
            .play-button {
                width: 50px;
                height: 50px;
            }
            
            .play-button i {
                font-size: 1.5rem;
            }
            
            .client-title {
                font-size: 1.3rem;
            }
            
            .client-name {
                font-size: 1rem;
            }
            
            .contact-number {
                font-size: 1rem;
            }
            
            .spacer {
                height: 1.2rem;
            }
            
            .testimonial-slide {
                padding: 1.5rem 1rem;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Top Contact Bar -->
    <div class="top-contact-bar">
        <div class="container contact-container">
            <div class="contact-item">
                <i class="fas fa-phone-alt"></i>
                <a href="tel:+92123456789">+92 321 4197290</a>
            </div>
            <div class="contact-item">
                <i class="fab fa-whatsapp"></i>
                <a href="https://wa.me/923214197290" target="_blank">+92 321 4197290</a>
            </div>
            <div class="contact-item">
                <i class="fas fa-envelope"></i>
                <a href="mailto:info@bang.pk">info@bang.pk</a>
            </div>
        </div>
    </div>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/923214197290" class="float-btn whatsapp-btn" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>

    <header>
        <div class="container header-content">
            <a href="{{asset('/')}}"><img src="{{ URL::asset('root/upload/logo/'.$logo->image) }}" alt="FBR Logo" class="logo" style="height: 50px;"></a>
            <nav>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#registration">Become our Partner</a></li>
                    <li><a href="#features">Features</a></li>
                    <li><a href="#compliance">Compliance</a></li>
                    <li><a href="#demo">Demo</a></li>
                    <li><a href="#contact">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section id="home" class="hero">
        <div class="hero-content">
            <!-- Three Images Row -->
            <div class="hero-images-row">
                <img src="root/upload/logo/fbrlogo.jpg" alt="FBR Logo 1" class="hero-image">
                <img src="root/upload/logo/fbrlogo1.jpg" alt="FBR Logo 2" class="hero-image">
                <img src="root/upload/logo/pra.jpg" alt="FBR Logo 3" class="hero-image">
            </div>

            <h1><span style="color: var(--fbr-orange);">BANG ERP</span> for FBR Digital Invoicing System</h1>
            <p>Providing FBR-compliant digital invoicing solutions all over Pakistan.</p>
            <a href="{{asset('login')}}" class="btn">Login Now</a>
        </div>
    </section>

    <br/>
    
    <!-- CLIENT TESTIMONIALS CAROUSEL (IFRAME 1) -->
    <section id="client-testimonials" class="container">
        <h2 class="section-title">What Our Client Says</h2>
        <div class="testimonials-container">
            <div class="testimonial-carousel">
                <!-- Slide 1 -->
                <div class="testimonial-slide active">
                    <div class="testimonial-video-wrapper">
                        <div class="video-thumbnail">
                            <img src="root/upload/azika.png" 
                                 alt="Client Testimonial Preview" 
                                 class="thumbnail-image">
                            <div class="play-button-overlay">
                                <div class="play-button">
                                    <i class="fas fa-play"></i>
                                </div>
                            </div>
                        </div>
                        
                        <!-- YouTube Video Iframe (hidden by default) -->
                        <iframe src="https://www.youtube.com/embed/tC5TE10MJEs?si=anljmWCXIGySfc3H" 
                                title="Client Testimonial - TechCorp Solutions" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen
                                class="youtube-video">
                        </iframe>
                    </div>
                    
                    <div class="spacer"></div>
                    <div class="testimonial-info">
                        <h3 class="client-title">Tax Professional</h3>
                        <p class="client-name">Khurram Ikhlaq, CFO at Akiza Associates</p>
                        <!-- <div class="contact-info">
                            <i class="fas fa-phone"></i>
                            <span class="contact-number">+92 300 9404155</span>
                        </div> -->
                    </div>
                </div>
                
                <!-- Slide 2 (add more slides as needed) -->
                <div class="testimonial-slide">
                    <div class="testimonial-video-wrapper">
                        <div class="video-thumbnail">
                            <img src="root/upload/sharif.png" 
                                 alt="Client Testimonial Preview" 
                                 class="thumbnail-image">
                            <div class="play-button-overlay">
                                <div class="play-button">
                                    <i class="fas fa-play"></i>
                                </div>
                            </div>
                        </div>
                        
                        <iframe src="https://www.youtube.com/embed/YdHzFtRGRyk?si=CPY6pQNZem8MN8i4" 
                                title="Client Testimonial - Another Company" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen
                                class="youtube-video">
                        </iframe>
                    </div>
                    
                    <div class="spacer"></div>
                    <div class="testimonial-info">
                        <h3 class="client-title">Tax Professional & Consultant</h3>
                        <p class="client-name">Sh. Sharif Hussain & Co</p>
                        <!-- <div class="contact-info">
                            <i class="fas fa-phone"></i>
                            <span class="contact-number">+92 321 4516050</span>
                        </div> -->
                    </div>
                </div>

                <!-- Slide 3 (add more slides as needed) -->
                <div class="testimonial-slide">
                    <div class="testimonial-video-wrapper">
                        <div class="video-thumbnail">
                            <img src="root/upload/sabiha.png" 
                                 alt="Client Testimonial Preview" 
                                 class="thumbnail-image">
                            <div class="play-button-overlay">
                                <div class="play-button">
                                    <i class="fas fa-play"></i>
                                </div>
                            </div>
                        </div>
                        
                        <iframe src="https://www.youtube.com/embed/oNozGSXLvyQ?si=sY_omnyt7O478IGp" 
                                title="Client Testimonial - Another Company" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen
                                class="youtube-video">
                        </iframe>
                    </div>
                    
                    <div class="spacer"></div>
                    <div class="testimonial-info">
                        <h3 class="client-title">Tax Consultant</h3>
                        <p class="client-name">Sabiha anees trading enterprises</p>
                        <!-- <div class="contact-info">
                            <i class="fas fa-phone"></i>
                            <span class="contact-number">+92 321 4516050</span>
                        </div> -->
                    </div>
                </div>

                <!-- Slide 4 (add more slides as needed) -->
                <div class="testimonial-slide">
                    <div class="testimonial-video-wrapper">
                        <div class="video-thumbnail">
                            <img src="root/upload/as.png" 
                                 alt="Client Testimonial Preview" 
                                 class="thumbnail-image">
                            <div class="play-button-overlay">
                                <div class="play-button">
                                    <i class="fas fa-play"></i>
                                </div>
                            </div>
                        </div>
                        
                        <iframe src="https://www.youtube.com/embed/YfZ1_SRud0U?si=upKDTRbnROtxnpLS" 
                                title="Client Testimonial - Another Company" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen
                                class="youtube-video">
                        </iframe>
                    </div>
                    
                    <div class="spacer"></div>
                    <div class="testimonial-info">
                        <h3 class="client-title">CFO</h3>
                        <p class="client-name">AS DYEING PVT</p>
                        <!-- <div class="contact-info">
                            <i class="fas fa-phone"></i>
                            <span class="contact-number">+92 321 4516050</span>
                        </div> -->
                    </div>
                </div>
            </div>
            
            <!-- Navigation arrows -->
            <button class="carousel-btn prev-btn" aria-label="Previous testimonial">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="carousel-btn next-btn" aria-label="Next testimonial">
                <i class="fas fa-chevron-right"></i>
            </button>
            
            <!-- Dots indicator -->
            <div class="carousel-dots">
                <span class="dot active" data-slide="0"></span>
                <!-- <span class="dot" data-slide="1"></span> -->
                <!-- Add more dots for more slides -->
            </div>
        </div>
    </section>

    <!-- CLIENT TESTIMONIALS GRID -->
<section id="client-testimonials" class="container">
    <h2 class="section-title">What Our Client Says</h2>
    <div class="testimonials-grid">
        <!-- Row 1 -->
        <div class="testimonials-row">
            <!-- Video 1 -->
            <div class="testimonial-card">
                <div class="testimonial-video-wrapper">
                    <div class="video-thumbnail">
                        <img src="root/upload/azika.png" 
                             alt="Client Testimonial Preview" 
                             class="thumbnail-image">
                        <div class="play-button-overlay">
                            <div class="play-button">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- YouTube Video Iframe (hidden by default) -->
                    <iframe src="https://www.youtube.com/embed/tC5TE10MJEs?si=anljmWCXIGySfc3H" 
                            title="Client Testimonial - TechCorp Solutions" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen
                            class="youtube-video">
                    </iframe>
                </div>
                
                <div class="testimonial-info">
                    <h3 class="client-title">Tax Professional</h3>
                    <p class="client-name">Khurram Ikhlaq, CFO at Akiza Associates</p>
                </div>
            </div>
            
            <!-- Video 2 -->
            <div class="testimonial-card">
                <div class="testimonial-video-wrapper">
                    <div class="video-thumbnail">
                        <img src="root/upload/sharif.png" 
                             alt="Client Testimonial Preview" 
                             class="thumbnail-image">
                        <div class="play-button-overlay">
                            <div class="play-button">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                    </div>
                    
                    <iframe src="https://www.youtube.com/embed/YdHzFtRGRyk?si=CPY6pQNZem8MN8i4" 
                            title="Client Testimonial - Another Company" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen
                            class="youtube-video">
                    </iframe>
                </div>
                
                <div class="testimonial-info">
                    <h3 class="client-title">Tax Professional & Consultant</h3>
                    <p class="client-name">Sh. Sharif Hussain & Co</p>
                </div>
            </div>
        </div>
        
        <!-- Row 2 -->
        <div class="testimonials-row">
            <!-- Video 3 -->
            <div class="testimonial-card">
                <div class="testimonial-video-wrapper">
                    <div class="video-thumbnail">
                        <img src="root/upload/sabiha.png" 
                             alt="Client Testimonial Preview" 
                             class="thumbnail-image">
                        <div class="play-button-overlay">
                            <div class="play-button">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                    </div>
                    
                    <iframe src="https://www.youtube.com/embed/oNozGSXLvyQ?si=sY_omnyt7O478IGp" 
                            title="Client Testimonial - Another Company" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen
                            class="youtube-video">
                    </iframe>
                </div>
                
                <div class="testimonial-info">
                    <h3 class="client-title">Tax Consultant</h3>
                    <p class="client-name">Sabiha anees trading enterprises</p>
                </div>
            </div>
            
            <!-- Video 4 -->
            <div class="testimonial-card">
                <div class="testimonial-video-wrapper">
                    <div class="video-thumbnail">
                        <img src="root/upload/as.png" 
                             alt="Client Testimonial Preview" 
                             class="thumbnail-image">
                        <div class="play-button-overlay">
                            <div class="play-button">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                    </div>
                    
                    <iframe src="https://www.youtube.com/embed/YfZ1_SRud0U?si=upKDTRbnROtxnpLS" 
                            title="Client Testimonial - Another Company" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen
                            class="youtube-video">
                    </iframe>
                </div>
                
                <div class="testimonial-info">
                    <h3 class="client-title">CFO</h3>
                    <p class="client-name">AS DYEING PVT LTD</p>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Rest of your content remains the same -->
    <section id="registration" class="container">
        <h2 class="section-title">Become our valued Partner</h2>
        <p style="margin-bottom: 1.5rem; text-align: center;">We invite experienced tax consultants, chartered accountants, and financial professionals to join us as valued partners in delivering FBR-compliant digital invoicing solutions to your clients across Pakistan.</p>
        <div style="margin: 0 auto; background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            <h3 style="color: var(--fbr-blue); margin-bottom: 1.5rem; text-align: center;">A Premium Opportunity for Tax & Legal Professionals, Solicitors, and CAs</h3>
            
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
            {!! Form::open(['url' => 'public_partner', 'class' => 'form-horizontal', 'files' => 'true', 'enctype' => 'multipart/form-data']) !!}
            @csrf
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <!-- Column 1 -->
                <div>
                    <div style="margin-bottom: 1rem;">
                        <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Name</label>
                        <input type="text" id="name" name="name" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 4px;" required>
                    </div>
                    
                    <div style="margin-bottom: 1rem;">
                        <label for="phone" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Phone</label>
                        <input type="text" id="phone" name="phone" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 4px;" required>
                    </div>
                </div>
                
                <!-- Column 2 -->
                <div>
                    <div style="margin-bottom: 1rem;">
                        <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Email</label>
                        <input type="email" id="email" name="email" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 4px;" required>
                    </div>
                    
                    <div style="margin-bottom: 1.5rem;">
                        <label for="city" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">City</label>
                        <input type="text" id="city" name="city" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 4px;" required>
                    </div>
                </div>
            </div>
            <div style="margin-bottom: 1.5rem;">
                <label for="address" style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Address</label>
                <input type="text" id="address" name="address" style="width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 4px;"
                    required>
            </div>
            <button type="submit" style="background-color: var(--fbr-orange); color: white; border: none; padding: 1rem 2rem; border-radius: 4px; font-weight: bold; cursor: pointer; width: 100%;">Submit Registration</button>
            {!! Form::close() !!}
        </div>
    </section>

    <!-- DEMO VIDEO (IFRAME 2) -->
    <section id="demo" class="container">
        <h2 class="section-title">Digital Invoicing Software Demo</h2>
        <div class="video-container">
            <div class="demo-video-wrapper">
                <iframe src="https://www.youtube.com/embed/daaEluGl9RI?si=DJv32gJ-n9g9q3DB" 
                        title="Digital Invoicing Software Demo" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                </iframe>
            </div>
        </div>
    </section>

    <section id="features" class="container">
        <h2 class="section-title">Key Features</h2>
        <div class="features">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <h3>Real-Time Invoicing</h3>
                <p>Automatically transmit invoice data to FBR in real-time for seamless tax compliance.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Secure & Tamper-Proof</h3>
                <p>Digitally signed invoices with unique QR codes and cryptographic security to prevent fraud.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-calculator"></i>
                </div>
                <h3>Automated Tax Calculations</h3>
                <p>Auto-populated tax fields reduce manual errors.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-check"></i>
                </div>
                <h3>Buyer-Seller Verification</h3>
                <p>NTN validation for both parties during invoice creation.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-bar-chart"></i>
                </div>
                <h3>Analytics Dashboard</h3>
                <p>Real-time sales tax reporting for business insights.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3>Mobile Friendly</h3>
                <p>Generate invoices from anywhere using Web portal or mobile-responsive platform.</p>
            </div>
        </div>
    </section>

    <section id="compliance" class="compliance-section">
        <div class="container compliance-content">
            <div class="compliance-text">
                <h2>FBR Compliance Made Simple</h2>
                <p>The FBR Digital Invoicing System is fully compliant with Pakistan's Sales Tax Act and Income Tax Ordinance. Our platform ensures you meet all regulatory requirements effortlessly.</p>
                
                <div class="steps">
                    <div class="step">
                        <div class="step-number">1</div>
                        <div>
                            <h3>Registration On Iris</h3>
                            <p>Enroll your business with FBR and obtain your unique digital invoicing Sandbox token first<a href="https://youtu.be/NZF1MkAyB2I?si=rcDs4VD8G472Nvm-" target="__blank" style="color:red;"> Watch Video.</a></p>
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-number">2</div>
                        <div>
                            <h3>Integration</h3>
                            <p>Connect fbr digital invoicing software to iris using token. </p>
                            <p>How to do? watch video </p>
                        </div>
                    </div>
                    <div class="step">
                        <div class="step-number">3</div>
                        <div>
                            <h3>Compliance</h3>
                            <p>Generate FBR-approved invoices that automatically report to tax authorities.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="compliance-image">
                <img src="root/upload/login.jpg" 
                    alt="Tax Compliance Concept"
                    class="fbr-compliance-img">
            </div> -->
        </div>
    </section>
   <br/>
    <footer id="contact">
        <div class="container">
            <img src="{{ asset('images/fbrlogo.jpg') }}" alt="FBR Logo" style="height: 50px; margin-bottom: 1rem;">
            <p style="margin-top: 1rem;"><a href="tel:+923214197290" style="color:rgba(0, 0, 0, 1); text-decoration: none;">+92 321 4197290</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="mailto:info@bang.pk" style="color:rgba(0, 0, 0, 1); text-decoration: none;">info@bang.pk</a></p>
            <p>©2025 FBR Digital Invoicing System. All rights reserved. Developed By <a href="https://itlifee.net" style="color:rgba(0, 0, 0, 1);">iT Life</a></p>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Testimonial Carousel Functionality
            const slides = document.querySelectorAll('.testimonial-slide');
            const dots = document.querySelectorAll('.dot');
            const prevBtn = document.querySelector('.prev-btn');
            const nextBtn = document.querySelector('.next-btn');
            let currentSlide = 0;
            
            // Function to update carousel
            function updateCarousel() {
                // Hide all slides
                slides.forEach(slide => {
                    slide.classList.remove('active');
                    slide.style.display = 'none';
                });
                
                // Remove active class from all dots
                dots.forEach(dot => {
                    dot.classList.remove('active');
                });
                
                // Show current slide
                slides[currentSlide].classList.add('active');
                slides[currentSlide].style.display = 'flex';
                dots[currentSlide].classList.add('active');
                
                // Move slides
                const slideWidth = slides[0].clientWidth;
                document.querySelector('.testimonial-carousel').style.transform = `translateX(-${currentSlide * slideWidth}px)`;
            }
            
            // Next slide
            if (nextBtn) {
                nextBtn.addEventListener('click', function() {
                    currentSlide = (currentSlide + 1) % slides.length;
                    updateCarousel();
                });
            }
            
            // Previous slide
            if (prevBtn) {
                prevBtn.addEventListener('click', function() {
                    currentSlide = (currentSlide - 1 + slides.length) % slides.length;
                    updateCarousel();
                });
            }
            
            // Dot click navigation
            dots.forEach(dot => {
                dot.addEventListener('click', function() {
                    currentSlide = parseInt(this.getAttribute('data-slide'));
                    updateCarousel();
                });
            });
            
            // Initialize carousel
            updateCarousel();
            
            // Video Play Functionality for Testimonials
            const videoWrappers = document.querySelectorAll('.testimonial-video-wrapper');
            
            videoWrappers.forEach(wrapper => {
                const thumbnail = wrapper.querySelector('.video-thumbnail');
                const video = wrapper.querySelector('.youtube-video');
                const playButton = wrapper.querySelector('.play-button');
                
                // Add click event to play video
                wrapper.addEventListener('click', function() {
                    thumbnail.classList.add('active');
                    video.classList.add('active');
                    
                    // Add autoplay parameter to YouTube URL
                    const currentSrc = video.getAttribute('src');
                    if (!currentSrc.includes('autoplay=1')) {
                        const newSrc = currentSrc.includes('?') 
                            ? `${currentSrc}&autoplay=1`
                            : `${currentSrc}?autoplay=1`;
                        video.setAttribute('src', newSrc);
                    }
                });
                
                // Add click event specifically to play button
                if (playButton) {
                    playButton.addEventListener('click', function(e) {
                        e.stopPropagation();
                        thumbnail.classList.add('active');
                        video.classList.add('active');
                        
                        const currentSrc = video.getAttribute('src');
                        if (!currentSrc.includes('autoplay=1')) {
                            const newSrc = currentSrc.includes('?') 
                                ? `${currentSrc}&autoplay=1`
                                : `${currentSrc}?autoplay=1`;
                            video.setAttribute('src', newSrc);
                        }
                    });
                }
            });
            
            // Handle window resize
            window.addEventListener('resize', function() {
                updateCarousel();
            });
        });
    </script>
</body>
</html>