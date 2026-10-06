    <!-- Header -->
    @include('website.templates.pos-home3.include.header')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Become a Partner | BANG Digital Solutions</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <style>
        /* Partner Hero Section */
        .partner-hero {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.9), rgba(118, 75, 162, 0.9)),
                url('https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            padding: 120px 0 80px;
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

        .section-title {
            text-align: center;
            margin-bottom: 60px;
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

        .benefit-card {
            background: white;
            border-radius: 15px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }

        .benefit-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .benefit-card:hover::before {
            transform: scaleX(1);
        }

        .benefit-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
        }

        .benefit-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, rgba(255, 107, 53, 0.1), rgba(247, 127, 0, 0.1));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 2rem;
            color: var(--primary-color);
            transition: all 0.3s ease;
        }

        .benefit-card:hover .benefit-icon {
            transform: scale(1.1) rotate(5deg);
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
        }

        .benefit-card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            color: var(--dark-color);
        }

        .benefit-card p {
            color: var(--gray-color);
            line-height: 1.6;
            margin-bottom: 0;
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
            max-width: 1000px;
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

        .form-progress {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            position: relative;
        }

        .form-progress::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 0;
            right: 0;
            height: 2px;
            background: #e9ecef;
            z-index: 1;
        }

        .progress-step {
            position: relative;
            z-index: 2;
            text-align: center;
            flex: 1;
        }

        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e9ecef;
            color: var(--gray-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin: 0 auto 10px;
            transition: all 0.3s ease;
        }

        .progress-step.active .step-number {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
            transform: scale(1.1);
        }

        .step-label {
            font-size: 0.9rem;
            color: var(--gray-color);
            font-weight: 500;
        }

        .progress-step.active .step-label {
            color: var(--primary-color);
            font-weight: 600;
        }

        .form-step {
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .form-step.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        .form-control,
        .form-select {
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.2);
            outline: none;
        }

        .form-control.error,
        .form-select.error {
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

        .form-check {
            margin-bottom: 15px;
        }

        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-label {
            color: var(--gray-color);
        }

        .form-text {
            color: var(--gray-color);
            font-size: 0.875rem;
            margin-top: 5px;
        }

        .btn-group {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
            gap: 15px;
        }

        .btn {
            padding: 14px 35px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255, 107, 53, 0.3);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-3px);
        }

        .btn-outline {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-3px);
        }

        /* Partnership Types */
        .partnership-types {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .partnership-type {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .partnership-type:hover {
            border-color: var(--primary-color);
            transform: translateY(-5px);
        }

        .partnership-type.selected {
            border-color: var(--primary-color);
            background: rgba(255, 107, 53, 0.05);
        }

        .type-checkbox {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 2px solid #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .partnership-type.selected .type-checkbox {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        .type-checkbox::after {
            content: '✓';
            color: white;
            font-size: 12px;
            display: none;
        }

        .partnership-type.selected .type-checkbox::after {
            display: block;
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

            .section-title h2 {
                font-size: 2.5rem;
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

            .form-progress {
                flex-direction: column;
                gap: 20px;
            }

            .form-progress::before {
                display: none;
            }

            .progress-step {
                display: flex;
                align-items: center;
                gap: 15px;
            }

            .step-number {
                margin: 0;
            }

            .btn-group {
                flex-direction: column;
            }
        }

        @media (max-width: 576px) {
            .partner-hero h1 {
                font-size: 2rem;
            }

            .section-title h2 {
                font-size: 1.8rem;
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
                        <div class="stat-label">Countries</div>
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
                    <p>Complete the form below to start your partnership journey with BANG Digital Solutions.</p>
                </div>

                <!-- Form Progress -->
                <div class="form-progress">
                    <div class="progress-step active" data-step="1">
                        <div class="step-number">1</div>
                        <div class="step-label">Company Info</div>
                    </div>
                    <div class="progress-step" data-step="2">
                        <div class="step-number">2</div>
                        <div class="step-label">Contact Details</div>
                    </div>
                    <div class="progress-step" data-step="3">
                        <div class="step-number">3</div>
                        <div class="step-label">Partnership Type</div>
                    </div>
                    <div class="progress-step" data-step="4">
                        <div class="step-number">4</div>
                        <div class="step-label">Review & Submit</div>
                    </div>
                </div>

                <!-- Step 1: Company Information -->
                <div class="form-step active" id="step-1">
                    <h3 class="mb-4">Company Information</h3>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Company Name <span class="required">*</span></label>
                                <input type="text" class="form-control" id="companyName" required>
                                <div class="error-message" id="companyNameError">Please enter your company name</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Company Website</label>
                                <input type="url" class="form-control" id="companyWebsite" placeholder="https://">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Industry <span class="required">*</span></label>
                                <select class="form-select" id="industry" required>
                                    <option value="">Select Industry</option>
                                    <option value="technology">Technology & IT</option>
                                    <option value="marketing">Digital Marketing</option>
                                    <option value="design">Design & Creative</option>
                                    <option value="consulting">Business Consulting</option>
                                    <option value="software">Software Development</option>
                                    <option value="ecommerce">E-commerce</option>
                                    <option value="finance">Finance & Fintech</option>
                                    <option value="education">Education & EdTech</option>
                                    <option value="healthcare">Healthcare</option>
                                    <option value="other">Other</option>
                                </select>
                                <div class="error-message" id="industryError">Please select your industry</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Company Size <span class="required">*</span></label>
                                <select class="form-select" id="companySize" required>
                                    <option value="">Select Size</option>
                                    <option value="1-10">1-10 Employees</option>
                                    <option value="11-50">11-50 Employees</option>
                                    <option value="51-200">51-200 Employees</option>
                                    <option value="201-500">201-500 Employees</option>
                                    <option value="501-1000">501-1000 Employees</option>
                                    <option value="1000+">1000+ Employees</option>
                                </select>
                                <div class="error-message" id="companySizeError">Please select company size</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Company Description <span class="required">*</span></label>
                        <textarea class="form-control" id="companyDescription" rows="4" required placeholder="Describe your company's products/services, mission, and unique value proposition..."></textarea>
                        <div class="error-message" id="companyDescriptionError">Please provide a company description</div>
                        <div class="form-text">Minimum 100 characters</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Year Established</label>
                        <input type="number" class="form-control" id="yearEstablished" min="1900" max="2024" placeholder="e.g., 2010">
                    </div>

                    <div class="btn-group">
                        <button class="btn btn-outline" disabled>Previous</button>
                        <button class="btn btn-primary" onclick="nextStep(2)">Next: Contact Details</button>
                    </div>
                </div>

                <!-- Step 2: Contact Information -->
                <div class="form-step" id="step-2">
                    <h3 class="mb-4">Contact Information</h3>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Full Name <span class="required">*</span></label>
                                <input type="text" class="form-control" id="fullName" required>
                                <div class="error-message" id="fullNameError">Please enter your full name</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Job Title <span class="required">*</span></label>
                                <input type="text" class="form-control" id="jobTitle" required>
                                <div class="error-message" id="jobTitleError">Please enter your job title</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Email Address <span class="required">*</span></label>
                                <input type="email" class="form-control" id="email" required>
                                <div class="error-message" id="emailError">Please enter a valid email address</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Phone Number <span class="required">*</span></label>
                                <input type="tel" class="form-control" id="phone" required>
                                <div class="error-message" id="phoneError">Please enter a valid phone number</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Country <span class="required">*</span></label>
                                <select class="form-select" id="country" required>
                                    <option value="">Select Country</option>
                                    <option value="pakistan">Pakistan</option>
                                    <option value="usa">United States</option>
                                    <option value="uk">United Kingdom</option>
                                    <option value="uae">United Arab Emirates</option>
                                    <option value="saudi">Saudi Arabia</option>
                                    <option value="canada">Canada</option>
                                    <option value="australia">Australia</option>
                                    <option value="india">India</option>
                                    <option value="germany">Germany</option>
                                    <option value="france">France</option>
                                    <option value="other">Other</option>
                                </select>
                                <div class="error-message" id="countryError">Please select your country</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">City <span class="required">*</span></label>
                                <input type="text" class="form-control" id="city" required>
                                <div class="error-message" id="cityError">Please enter your city</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Preferred Communication Method</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="communication" id="commEmail" value="email" checked>
                            <label class="form-check-label" for="commEmail">
                                Email
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="communication" id="commPhone" value="phone">
                            <label class="form-check-label" for="commPhone">
                                Phone Call
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="communication" id="commBoth" value="both">
                            <label class="form-check-label" for="commBoth">
                                Both
                            </label>
                        </div>
                    </div>

                    <div class="btn-group">
                        <button class="btn btn-outline" onclick="prevStep(1)">Previous</button>
                        <button class="btn btn-primary" onclick="nextStep(3)">Next: Partnership Type</button>
                    </div>
                </div>

                <!-- Step 3: Partnership Type -->
                <div class="form-step" id="step-3">
                    <h3 class="mb-4">Partnership Type</h3>

                    <div class="form-group">
                        <label class="form-label">Select Partnership Type(s) <span class="required">*</span></label>
                        <p class="form-text">You can select multiple partnership types that best fit your business.</p>

                        <div class="partnership-types">
                            <div class="partnership-type" onclick="selectPartnershipType('reseller')">
                                <div class="type-checkbox"></div>
                                <h4>Reseller Partner</h4>
                                <p>Sell our products/services to your clients</p>
                            </div>

                            <div class="partnership-type" onclick="selectPartnershipType('referral')">
                                <div class="type-checkbox"></div>
                                <h4>Referral Partner</h4>
                                <p>Refer clients and earn commissions</p>
                            </div>

                            <div class="partnership-type" onclick="selectPartnershipType('strategic')">
                                <div class="type-checkbox"></div>
                                <h4>Strategic Partner</h4>
                                <p>Collaborate on large-scale projects</p>
                            </div>

                            <div class="partnership-type" onclick="selectPartnershipType('technology')">
                                <div class="type-checkbox"></div>
                                <h4>Technology Partner</h4>
                                <p>Integrate technologies and solutions</p>
                            </div>

                            <div class="partnership-type" onclick="selectPartnershipType('implementation')">
                                <div class="type-checkbox"></div>
                                <h4>Implementation Partner</h4>
                                <p>Implement solutions for end clients</p>
                            </div>

                            <div class="partnership-type" onclick="selectPartnershipType('other')">
                                <div class="type-checkbox"></div>
                                <h4>Other Partnership</h4>
                                <p>Custom partnership arrangement</p>
                            </div>
                        </div>
                        <div class="error-message" id="partnershipTypeError">Please select at least one partnership type</div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Expected Monthly Revenue</label>
                        <select class="form-select" id="expectedRevenue">
                            <option value="">Select Range</option>
                            <option value="0-5k">$0 - $5,000</option>
                            <option value="5k-20k">$5,000 - $20,000</option>
                            <option value="20k-50k">$20,000 - $50,000</option>
                            <option value="50k-100k">$50,000 - $100,000</option>
                            <option value="100k+">$100,000+</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Partnership Goals</label>
                        <textarea class="form-control" id="partnershipGoals" rows="3" placeholder="What do you hope to achieve through this partnership?"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Current Client Base</label>
                        <textarea class="form-control" id="clientBase" rows="2" placeholder="Describe your current client base (industries, locations, size)"></textarea>
                    </div>

                    <div class="btn-group">
                        <button class="btn btn-outline" onclick="prevStep(2)">Previous</button>
                        <button class="btn btn-primary" onclick="nextStep(4)">Next: Review & Submit</button>
                    </div>
                </div>

                <!-- Step 4: Review & Submit -->
                <div class="form-step" id="step-4">
                    <h3 class="mb-4">Review Your Application</h3>

                    <div class="review-section mb-4">
                        <h5 class="mb-3">Company Information</h5>
                        <div id="reviewCompanyInfo" class="mb-3 p-3 bg-light rounded">
                            <!-- Will be populated with JavaScript -->
                        </div>

                        <h5 class="mb-3">Contact Information</h5>
                        <div id="reviewContactInfo" class="mb-3 p-3 bg-light rounded">
                            <!-- Will be populated with JavaScript -->
                        </div>

                        <h5 class="mb-3">Partnership Details</h5>
                        <div id="reviewPartnershipInfo" class="mb-3 p-3 bg-light rounded">
                            <!-- Will be populated with JavaScript -->
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="terms" required>
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="#" class="text-primary">Terms and Conditions</a> and <a href="#" class="text-primary">Privacy Policy</a> <span class="required">*</span>
                            </label>
                        </div>
                        <div class="error-message" id="termsError">You must agree to the terms and conditions</div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="newsletter">
                            <label class="form-check-label" for="newsletter">
                                Subscribe to our partnership newsletter for updates and opportunities
                            </label>
                        </div>
                    </div>

                    <div class="btn-group">
                        <button class="btn btn-outline" onclick="prevStep(3)">Previous</button>
                        <button class="btn btn-primary" onclick="submitForm()">Submit Application</button>
                    </div>
                </div>

                <!-- Success Message -->
                <div class="success-message" id="successMessage">
                    <div class="success-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <h3>Application Submitted!</h3>
                    <p>Thank you for your partnership application. Our team will review your submission and contact you within 3-5 business days.</p>
                    <div class="mt-4">
                        <button class="btn btn-outline me-2" onclick="window.location.href='index.html'">
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

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Partnership Form Script -->
    <script>
        // Current step management
        let currentStep = 1;
        let formData = {
            companyInfo: {},
            contactInfo: {},
            partnershipInfo: {
                types: []
            }
        };

        // Form navigation functions
        function goToStep(step) {
            // Hide all steps
            document.querySelectorAll('.form-step').forEach(step => {
                step.classList.remove('active');
            });

            // Remove active class from all progress steps
            document.querySelectorAll('.progress-step').forEach(progressStep => {
                progressStep.classList.remove('active');
            });

            // Show current step
            document.getElementById(`step-${step}`).classList.add('active');

            // Activate current progress step
            document.querySelector(`.progress-step[data-step="${step}"]`).classList.add('active');

            currentStep = step;
        }

        function nextStep(next) {
            if (currentStep < 4 && validateStep(currentStep)) {
                saveStepData(currentStep);
                goToStep(next);

                // If going to review step, populate review data
                if (next === 4) {
                    populateReviewData();
                }
            } else if (currentStep === 4) {
                goToStep(next);
            }
        }

        function prevStep(prev) {
            goToStep(prev);
        }

        // Save step data to formData object
        function saveStepData(step) {
            switch (step) {
                case 1:
                    formData.companyInfo = {
                        companyName: document.getElementById('companyName').value,
                        companyWebsite: document.getElementById('companyWebsite').value,
                        industry: document.getElementById('industry').value,
                        companySize: document.getElementById('companySize').value,
                        companyDescription: document.getElementById('companyDescription').value,
                        yearEstablished: document.getElementById('yearEstablished').value
                    };
                    break;
                case 2:
                    formData.contactInfo = {
                        fullName: document.getElementById('fullName').value,
                        jobTitle: document.getElementById('jobTitle').value,
                        email: document.getElementById('email').value,
                        phone: document.getElementById('phone').value,
                        country: document.getElementById('country').value,
                        city: document.getElementById('city').value,
                        communication: document.querySelector('input[name="communication"]:checked').value
                    };
                    break;
                case 3:
                    formData.partnershipInfo = {
                        types: Array.from(document.querySelectorAll('.partnership-type.selected'))
                            .map(el => el.querySelector('h4').textContent),
                        expectedRevenue: document.getElementById('expectedRevenue').value,
                        partnershipGoals: document.getElementById('partnershipGoals').value,
                        clientBase: document.getElementById('clientBase').value
                    };
                    break;
                case 4:
                    // Save terms acceptance
                    formData.termsAccepted = document.getElementById('terms').checked;
                    formData.newsletterSubscribed = document.getElementById('newsletter').checked;
                    break;
            }
        }

        // Validate step
        function validateStep(step) {
            let isValid = true;

            switch (step) {
                case 1:
                    if (!document.getElementById('companyName').value.trim()) {
                        showError('companyNameError');
                        isValid = false;
                    } else {
                        hideError('companyNameError');
                    }

                    if (!document.getElementById('industry').value) {
                        showError('industryError');
                        isValid = false;
                    } else {
                        hideError('industryError');
                    }

                    if (!document.getElementById('companySize').value) {
                        showError('companySizeError');
                        isValid = false;
                    } else {
                        hideError('companySizeError');
                    }

                    if (!document.getElementById('companyDescription').value.trim() ||
                        document.getElementById('companyDescription').value.trim().length < 100) {
                        showError('companyDescriptionError');
                        isValid = false;
                    } else {
                        hideError('companyDescriptionError');
                    }
                    break;

                case 2:
                    if (!document.getElementById('fullName').value.trim()) {
                        showError('fullNameError');
                        isValid = false;
                    } else {
                        hideError('fullNameError');
                    }

                    if (!document.getElementById('jobTitle').value.trim()) {
                        showError('jobTitleError');
                        isValid = false;
                    } else {
                        hideError('jobTitleError');
                    }

                    const email = document.getElementById('email').value;
                    if (!email || !validateEmail(email)) {
                        showError('emailError');
                        isValid = false;
                    } else {
                        hideError('emailError');
                    }

                    const phone = document.getElementById('phone').value;
                    if (!phone || phone.length < 10) {
                        showError('phoneError');
                        isValid = false;
                    } else {
                        hideError('phoneError');
                    }

                    if (!document.getElementById('country').value) {
                        showError('countryError');
                        isValid = false;
                    } else {
                        hideError('countryError');
                    }

                    if (!document.getElementById('city').value.trim()) {
                        showError('cityError');
                        isValid = false;
                    } else {
                        hideError('cityError');
                    }
                    break;

                case 3:
                    const selectedTypes = document.querySelectorAll('.partnership-type.selected');
                    if (selectedTypes.length === 0) {
                        showError('partnershipTypeError');
                        isValid = false;
                    } else {
                        hideError('partnershipTypeError');
                    }
                    break;

                case 4:
                    // Step 4 doesn't have validation (it's the review step)
                    // Just save data and proceed
                    isValid = true;
                    break;
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

        function hideError(errorId) {
            const errorElement = document.getElementById(errorId);
            const inputElement = document.getElementById(errorId.replace('Error', ''));

            if (errorElement) {
                errorElement.classList.remove('show');
            }

            if (inputElement) {
                inputElement.classList.remove('error');
            }
        }

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        // Partnership type selection
        function selectPartnershipType(type) {
            const element = event.currentTarget;
            element.classList.toggle('selected');
        }

        // Populate review data
        function populateReviewData() {
            // Company Info
            let companyHtml = `
        <p><strong>Company Name:</strong> ${formData.companyInfo.companyName || 'Not provided'}</p>
        <p><strong>Industry:</strong> ${formData.companyInfo.industry || 'Not provided'}</p>
        <p><strong>Company Size:</strong> ${formData.companyInfo.companySize || 'Not provided'}</p>
        <p><strong>Website:</strong> ${formData.companyInfo.companyWebsite || 'Not provided'}</p>
        <p><strong>Year Established:</strong> ${formData.companyInfo.yearEstablished || 'Not specified'}</p>
        <p><strong>Description:</strong> ${formData.companyInfo.companyDescription ? formData.companyInfo.companyDescription.substring(0, 150) + '...' : 'Not provided'}</p>
    `;
            document.getElementById('reviewCompanyInfo').innerHTML = companyHtml;

            // Contact Info
            let contactHtml = `
        <p><strong>Contact Person:</strong> ${formData.contactInfo.fullName || 'Not provided'}</p>
        <p><strong>Job Title:</strong> ${formData.contactInfo.jobTitle || 'Not provided'}</p>
        <p><strong>Email:</strong> ${formData.contactInfo.email || 'Not provided'}</p>
        <p><strong>Phone:</strong> ${formData.contactInfo.phone || 'Not provided'}</p>
        <p><strong>Location:</strong> ${formData.contactInfo.city || 'Not provided'}, ${formData.contactInfo.country || 'Not provided'}</p>
        <p><strong>Preferred Communication:</strong> ${formData.contactInfo.communication || 'Not specified'}</p>
    `;
            document.getElementById('reviewContactInfo').innerHTML = contactHtml;

            // Partnership Info
            let partnershipHtml = `
        <p><strong>Partnership Types:</strong> ${formData.partnershipInfo.types.length > 0 ? formData.partnershipInfo.types.join(', ') : 'Not selected'}</p>
        <p><strong>Expected Revenue:</strong> ${formData.partnershipInfo.expectedRevenue || 'Not specified'}</p>
        <p><strong>Partnership Goals:</strong> ${formData.partnershipInfo.partnershipGoals || 'Not provided'}</p>
        <p><strong>Current Client Base:</strong> ${formData.partnershipInfo.clientBase || 'Not provided'}</p>
    `;
            document.getElementById('reviewPartnershipInfo').innerHTML = partnershipHtml;
        }

        // Submit form
        function submitForm() {
            if (!document.getElementById('terms').checked) {
                showError('termsError');
                return;
            }

            hideError('termsError');

            // Save final step data
            saveStepData(3);

            // In a real application, you would send this data to your server
            // For now, we'll just show the success message
            document.querySelector('.form-step.active').style.display = 'none';
            document.getElementById('successMessage').style.display = 'block';

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
                document.querySelector('.form-step.active').style.display = 'none';
                document.getElementById('successMessage').style.display = 'block';
            })
            .catch((error) => {
                console.error('Error:', error);
                alert('There was an error submitting your application. Please try again.');
            });
            */
        }

        // Reset form
        function resetForm() {
            // Reset all form fields
            document.querySelectorAll('input, textarea, select').forEach(element => {
                if (element.type === 'text' || element.type === 'email' || element.type === 'tel' || element.type === 'url' || element.type === 'number') {
                    element.value = '';
                } else if (element.type === 'checkbox' || element.type === 'radio') {
                    element.checked = false;
                } else if (element.tagName === 'SELECT') {
                    element.selectedIndex = 0;
                } else if (element.tagName === 'TEXTAREA') {
                    element.value = '';
                }
            });

            // Reset partnership type selections
            document.querySelectorAll('.partnership-type').forEach(el => {
                el.classList.remove('selected');
            });

            // Reset form data
            formData = {
                companyInfo: {},
                contactInfo: {},
                partnershipInfo: {
                    types: []
                }
            };

            // Reset radio buttons
            document.getElementById('commEmail').checked = true;

            // Hide success message
            document.getElementById('successMessage').style.display = 'none';

            // Go back to step 1
            goToStep(1);

            // Show step 1
            document.getElementById('step-1').style.display = 'block';
        }

        // Initialize Select2 for select elements
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize any select2 elements if needed
            if (jQuery && jQuery.fn.select2) {
                jQuery('#industry, #country, #companySize, #expectedRevenue').select2({
                    minimumResultsForSearch: 10,
                    width: '100%'
                });
            }
        });
    </script>

    <!-- Footer Script -->
    <script>
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

        // Mobile menu close on click
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 992) {
                    const navbarCollapse = document.querySelector('.navbar-collapse');
                    if (navbarCollapse.classList.contains('show')) {
                        new bootstrap.Collapse(navbarCollapse);
                    }
                }
            });
        });
    </script>

</body>

</html>