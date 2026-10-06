<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Become a Partner | BANG Digital Solutions</title>
    
    
    <style>
        /* Partner Hero Section */
        .partner-hero {
            background: 
                linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
                url('https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            padding: 120px 0 80px;
            min-height: 70vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
            color: white;
            text-align: center;
        }

        .partner-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 50% 50%, rgba(0, 0, 0, 0.3), transparent 70%);
        }

        .partner-hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
        }

        .partner-hero h1 {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 20px;
            animation: fadeInUp 0.8s ease;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .partner-hero p {
            font-size: 1.4rem;
            margin-bottom: 30px;
            opacity: 0.95;
            animation: fadeInUp 0.8s ease 0.2s backwards;
            font-weight: 300;
        }

        .partner-stats {
            display: flex;
            justify-content: center;
            gap: 50px;
            margin-top: 50px;
            flex-wrap: wrap;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Benefits Section */
        .benefits-section {
            padding: 100px 0;
            background: white;
        }

        /* Partnership Form Section */
        .partnership-form-section {
            padding: 100px 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            position: relative;
        }

        .partnership-form-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.05), transparent);
        }

        .form-container {
            background: white;
            border-radius: 20px;
            padding: 50px;
            box-shadow: 0 25px 80px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 0, 0, 0.05);
            max-width: 800px;
            margin: 0 auto;
        }

        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .form-header h2 {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--dark-color);
            margin-bottom: 15px;
        }

        .form-header p {
            color: var(--gray-color);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }

        .form-label .required {
            color: var(--primary-color);
            margin-left: 4px;
        }

        .form-control {
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
            width: 100%;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(37, 211, 102, 0.2);
            outline: none;
        }

        .form-control.error {
            border-color: #dc3545;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 5px;
            display: none;
        }

        .error-message.show {
            display: block;
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

        /* Success Message */
        .success-message {
            text-align: center;
            padding: 60px 20px;
            display: none;
        }

        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            font-size: 3rem;
            color: white;
            animation: scaleIn 0.5s ease;
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
            }
            to {
                transform: scale(1);
            }
        }

        .success-message h3 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 20px;
        }

        .success-message p {
            color: var(--gray-color);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto 30px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .partner-hero h1 {
                font-size: 3rem;
            }

            .partner-hero p {
                font-size: 1.2rem;
            }

            .form-container {
                padding: 30px;
            }

            .form-header h2 {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 768px) {
            .partner-hero {
                padding: 80px 0 50px;
            }

            .partner-hero h1 {
                font-size: 2.5rem;
            }

            .partner-stats {
                gap: 30px;
            }

            .stat-number {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 576px) {
            .partner-hero h1 {
                font-size: 2rem;
            }

            .form-container {
                padding: 20px;
            }

            .form-header h2 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    @include('website.templates.pos-home3.include.header')

    <!-- Partner Hero Section -->
    <section class="partner-hero">
        <div class="container">
            <div class="partner-hero-content">
                <h1>Become a Partner</h1>
                <p>Join our growing network of innovative companies and expand your business opportunities through strategic partnerships with BANG Digital Solutions.</p>

                <div class="partner-stats">
                    <div class="stat-item">
                        <div class="stat-number">150+</div>
                        <div class="stat-label">Active Partners</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">40+</div>
                        <div class="stat-label">Cities</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">$2M+</div>
                        <div class="stat-label">Revenue Generated</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="benefits-section">
        <div class="container">
            <div class="section-title">
                <h2>Partnership Benefits</h2>
                <p>Experience the advantages of partnering with a leading digital solutions provider</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>Revenue Growth</h3>
                        <p>Access new revenue streams through our extensive client network and collaborative projects.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-globe-asia"></i>
                        </div>
                        <h3>Market Expansion</h3>
                        <p>Expand your reach to new markets and geographical locations with our support.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h3>Innovation Access</h3>
                        <p>Get early access to our latest technologies, tools, and innovative solutions.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>Networking</h3>
                        <p>Connect with other industry leaders through our exclusive partner events and forums.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Partnership Form Section -->
    <section class="partnership-form-section">
        <div class="container">
            <div class="form-container">
                <div class="form-header">
                    <h2>Apply for Partnership</h2>
                    <p>Complete the simple form below to start your partnership journey with BANG Digital Solutions.</p>
                </div>

                <!-- Simplified Partnership Form -->
                <form id="partnerForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Full Name <span class="required">*</span></label>
                                <input type="text" class="form-control" id="fullName" name="fullName" required placeholder="Enter your full name">
                                <div class="error-message" id="fullNameError">Please enter your full name</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Phone Number <span class="required">*</span></label>
                                <input type="tel" class="form-control" id="phone" name="phone" required placeholder="Enter your phone number">
                                <div class="error-message" id="phoneError">Please enter a valid phone number</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Email Address <span class="required">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email address">
                                <div class="error-message" id="emailError">Please enter a valid email address</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">City <span class="required">*</span></label>
                                <input type="text" class="form-control" id="city" name="city" required placeholder="Enter your city">
                                <div class="error-message" id="cityError">Please enter your city</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Complete Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter your complete address (optional)"></textarea>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="#" class="text-primary">Terms and Conditions</a> and <a href="#" class="text-primary">Privacy Policy</a> <span class="required">*</span>
                            </label>
                        </div>
                        <div class="error-message" id="termsError">You must agree to the terms and conditions</div>
                    </div>

                    <button type="submit" class="submit-btn">
                        <i class="fas fa-paper-plane me-2"></i>Submit Partnership Request
                    </button>
                </form>

                <!-- Success Message -->
                <div class="success-message" id="successMessage">
                    <div class="success-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <h3>Application Submitted!</h3>
                    <p>Thank you for your partnership application. Our team will review your submission and contact you within 3-5 business days.</p>
                    <div class="mt-4">
                        <button class="btn btn-outline me-2" onclick="window.location.href='/'">
                            <i class="fas fa-home me-2"></i>Return to Home
                        </button>
                        <button class="btn btn-primary" onclick="resetForm()">
                            <i class="fas fa-plus me-2"></i>Submit Another Application
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    @include('website.templates.pos-home3.include.footer')

    <script>
        // Form validation and submission
        document.getElementById('partnerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (validateForm()) {
                submitForm();
            }
        });

        // Validate form
        function validateForm() {
            let isValid = true;
            
            // Clear previous errors
            document.querySelectorAll('.error-message').forEach(el => {
                el.classList.remove('show');
            });
            
            document.querySelectorAll('.form-control').forEach(el => {
                el.classList.remove('error');
            });
            
            // Validate Full Name
            const fullName = document.getElementById('fullName').value.trim();
            if (!fullName) {
                showError('fullNameError');
                isValid = false;
            }
            
            // Validate Phone
            const phone = document.getElementById('phone').value.trim();
            if (!phone || phone.length < 10) {
                showError('phoneError');
                isValid = false;
            }
            
            // Validate Email
            const email = document.getElementById('email').value.trim();
            if (!email || !validateEmail(email)) {
                showError('emailError');
                isValid = false;
            }
            
            // Validate City
            const city = document.getElementById('city').value.trim();
            if (!city) {
                showError('cityError');
                isValid = false;
            }
            
            // Validate Terms
            if (!document.getElementById('terms').checked) {
                showError('termsError');
                isValid = false;
            }
            
            return isValid;
        }

        // Helper functions
        function showError(errorId) {
            const errorElement = document.getElementById(errorId);
            const inputElement = document.getElementById(errorId.replace('Error', ''));
            
            if (errorElement) {
                errorElement.classList.add('show');
            }
            
            if (inputElement) {
                inputElement.classList.add('error');
            }
        }

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        // Submit form
        function submitForm() {
            const formData = {
                fullName: document.getElementById('fullName').value.trim(),
                phone: document.getElementById('phone').value.trim(),
                email: document.getElementById('email').value.trim(),
                city: document.getElementById('city').value.trim(),
                address: document.getElementById('address').value.trim(),
                termsAccepted: document.getElementById('terms').checked,
                submittedAt: new Date().toISOString()
            };
            
            // Show loading state
            const submitBtn = document.querySelector('.submit-btn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';
            submitBtn.disabled = true;
            
            // In a real application, you would send this data to your server
            // For now, we'll simulate an API call with a timeout
            setTimeout(() => {
                // Hide form and show success message
                document.getElementById('partnerForm').style.display = 'none';
                document.getElementById('successMessage').style.display = 'block';
                
                // Scroll to success message
                document.getElementById('successMessage').scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
                
                // Reset button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                
                // You would typically send the data to your server like this:
                /*
                fetch('/api/partnership-application', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData)
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Success:', data);
                    document.getElementById('partnerForm').style.display = 'none';
                    document.getElementById('successMessage').style.display = 'block';
                    
                    // Reset button state
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                })
                .catch((error) => {
                    console.error('Error:', error);
                    alert('There was an error submitting your application. Please try again.');
                    
                    // Reset button state
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
                */
                
            }, 1500);
        }

        // Reset form
        function resetForm() {
            // Hide success message
            document.getElementById('successMessage').style.display = 'none';
            
            // Show form
            document.getElementById('partnerForm').style.display = 'block';
            
            // Reset form fields
            document.getElementById('partnerForm').reset();
            
            // Clear errors
            document.querySelectorAll('.error-message').forEach(el => {
                el.classList.remove('show');
            });
            
            document.querySelectorAll('.form-control').forEach(el => {
                el.classList.remove('error');
            });
            
            // Scroll to form
            document.getElementById('partnerForm').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    </script>
</body>
</html>