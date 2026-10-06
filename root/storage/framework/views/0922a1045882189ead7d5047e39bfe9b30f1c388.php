    <style>
        /* Footer Styles */
        .footer {
            background: var(--dark-color);
            color: white;
            padding: 80px 0 0;
            position: relative;
            overflow: hidden;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
        }

        .footer-logo {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
            display: inline-block;
        }

        .footer-description {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 30px;
            font-size: 1.05rem;
            line-height: 1.8;
        }

        .footer-heading {
            color: white;
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-heading::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            border-radius: 2px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .footer-links a:hover {
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .footer-links a i {
            margin-right: 10px;
            font-size: 0.9rem;
            transition: transform 0.3s ease;
        }

        .footer-links a:hover i {
            transform: rotate(45deg);
        }

        .footer-contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
            color: rgba(255, 255, 255, 0.7);
        }

        .footer-contact-item i {
            color: var(--primary-color);
            margin-right: 15px;
            font-size: 1.2rem;
            margin-top: 5px;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-link {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .social-link:hover {
            background: var(--primary-color);
            transform: translateY(-5px);
            border-color: var(--primary-color);
        }

        .newsletter-form {
            margin-top: 20px;
        }

        .newsletter-input {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            padding: 12px 20px;
            border-radius: 30px;
            width: 100%;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .newsletter-input:focus {
            outline: none;
            border-color: var(--primary-color);
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 0 3px rgba(73, 255, 53, 0.2);
        }

        .newsletter-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .newsletter-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .newsletter-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(53, 255, 67, 0.3);
        }

        .footer-bottom {
            background: rgba(0, 0, 0, 0.2);
            padding: 25px 0;
            margin-top: 60px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .copyright {
            color: rgba(255, 255, 255, 0.6);
            text-align: center;
            margin: 0;
        }

        .copyright a {
            color: var(--primary-color);
            text-decoration: none;
        }

        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            font-size: 1.2rem;
            opacity: 0;
            visibility: hidden;
            transform: translateY(20px);
            transition: all 0.3s ease;
            z-index: 999;
            box-shadow: 0 5px 20px rgba(26, 26, 46, 0.72);
        }

        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .back-to-top:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(26, 26, 46, 0.63);
        }

        /* Responsive footer */
        @media (max-width: 768px) {
            .footer {
                padding: 60px 0 0;
            }

            .footer-section {
                margin-bottom: 40px;
            }
        }
    </style>

    <!-- Footer -->
    <footer id="contact" class="footer">
        <div class="container">
            <div class="row">
                <!-- Company Info -->
                <div class="col-lg-5 col-md-6 mb-5">
                    <div class="footer-section">
                        <div class="footer-logo">
                            <a class="navbar-brand d-flex align-items-center" href="<?php echo e(url('/')); ?>">
                                <img src="<?php echo e(asset('root/upload/logo/bang-logo.png')); ?>" alt="Logo" class="img-fluid">
                            </a>
                        </div>
                        <p class="footer-description">
                            Transforming ideas into powerful digital experiences. We specialize in creating innovative solutions that drive business growth and digital transformation.
                        </p>
                        <!-- <div class="social-links">
                            <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                        </div> -->
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-4 col-md-6 mb-5">
                    <div class="footer-section">
                        <h4 class="footer-heading">Quick Links</h4>
                        <ul class="footer-links">
                            <li><a href="#home"><i class="fas fa-chevron-right"></i> Home</a></li>
                            <li><a href="#about"><i class="fas fa-chevron-right"></i> About Us</a></li>
                            <!-- <li><a href="#team"><i class="fas fa-chevron-right"></i> Team</a></li> -->
                            <li><a href="#videos"><i class="fas fa-chevron-right"></i> Videos</a></li>
                            <li><a href="#partners"><i class="fas fa-chevron-right"></i> Partners</a></li>
                            <li><a href="#contact"><i class="fas fa-chevron-right"></i> Contact</a></li>
                            <li><a href="<?php echo e(route('website.faq')); ?>"><i class="fas fa-chevron-right"></i> FAQ</a></li>
                            <li><a href="<?php echo e(route('website.privacy-policy')); ?>"><i class="fas fa-chevron-right"></i> Privacy Policy</a></li>
                            <li><a href="<?php echo e(route('website.terms-and-conditions')); ?>"><i class="fas fa-chevron-right"></i> Terms &amp; Conditions</a></li>
                        </ul>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-3 col-md-6 mb-5">
                    <div class="footer-section">
                        <h4 class="footer-heading">Contact Info</h4>
                        <!-- <div class="footer-contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <strong>Address</strong><br>
                                123 Creative Street, Digital City<br>
                                Karachi, Pakistan
                            </div>
                        </div> -->
                        <div class="footer-contact-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <strong>Phone</strong><br>
                                +92 321 4197290
                            </div>
                        </div>
                        <div class="footer-contact-item">
                            <i class="fas fa-envelope"></i>
                            <div>
                                <strong>Email</strong><br>
                                info@bang.pk
                            </div>
                        </div>
                        <div class="footer-contact-item">
                            <i class="fas fa-clock"></i>
                            <div>
                                <strong>Working Hours</strong><br>
                                Monday - Saturday: 24 Hours
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Newsletter (hidden) -->
                <div class="col-lg-3 col-md-6 mb-5 d-none">
                    <div class="footer-section">
                        <h4 class="footer-heading">Newsletter</h4>
                        <p class="footer-description">Subscribe to our newsletter for the latest updates and insights.</p>
                        <form class="newsletter-form">
                            <input type="email" class="newsletter-input" placeholder="Your email address" required>
                            <button type="submit" class="newsletter-btn">
                                <i class="fas fa-paper-plane me-2"></i>Subscribe
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="row">
                    <div class="col-12">
                        <p class="copyright">
                            &copy; <?php echo e(date('Y')); ?> <a href="#">BANG Digital Solutions</a>. All Rights Reserved. |
                            <a href="<?php echo e(route('website.faq')); ?>">FAQ</a> | <a href="<?php echo e(route('website.privacy-policy')); ?>">Privacy Policy</a> | <a href="<?php echo e(route('website.terms-and-conditions')); ?>">Terms &amp; Conditions</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <a href="#home" class="back-to-top" id="backToTop">
        <i class="fas fa-chevron-up"></i>
    </a>

    <script>
        // Back to top functionality
        window.addEventListener('scroll', function() {
            const backToTop = document.getElementById('backToTop');

            // Show/hide back to top button
            if (window.scrollY > 300) {
                backToTop.classList.add('visible');
            } else {
                backToTop.classList.remove('visible');
            }
        });

        // Back to top smooth scroll
        document.getElementById('backToTop')?.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Newsletter form submission
        document.querySelector('.newsletter-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('.newsletter-input').value;

            // Simple validation
            if (email && email.includes('@')) {
                alert('Thank you for subscribing to our newsletter!');
                this.querySelector('.newsletter-input').value = '';
            } else {
                alert('Please enter a valid email address.');
            }
        });

        // Footer contact links smooth scroll
        document.querySelectorAll('.footer-links a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const target = document.querySelector(targetId);
                if (target) {
                    // Calculate offset for top banner
                    const topBannerHeight = document.querySelector('.top-contact-banner')?.offsetHeight || 0;
                    const navbarHeight = document.querySelector('.navbar').offsetHeight;
                    const offset = topBannerHeight + navbarHeight + 20;

                    const targetPosition = target.getBoundingClientRect().top + window.pageYOffset - offset;

                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script><?php /**PATH D:\Axis-Coding\xampp-8.2.12\htdocs\it_life_work\digital-invoicing\root\resources\views/website/include/footer.blade.php ENDPATH**/ ?>