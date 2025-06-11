<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRMFlow - Grow Your Business Today</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('panel-assets/img/favicon-translation.png') }}">
    <style>
        :root {
            --primary-blue: #2563eb;
            --secondary-blue: #3b82f6;
            --light-blue: #dbeafe;
            --dark-blue: #1e40af;
            --gradient: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
            --text-dark: #1f2937;
            --text-light: #6b7280;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
        }

        .gradient-bg {
            background: var(--gradient);
        }

        .btn-primary-custom {
            background: var(--gradient);
            border: none;
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);
        }

        .btn-outline-custom {
            border: 2px solid var(--primary-blue);
            color: var(--primary-blue);
            padding: 12px 30px;
            border-radius: 8px;
            font-weight: 500;
            background: transparent;
            transition: all 0.3s ease;
        }

        .btn-outline-custom:hover {
            background: var(--primary-blue);
            color: white;
            transform: translateY(-2px);
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-blue) !important;
        }

        .nav-link {
            font-weight: 500;
            color: var(--text-dark) !important;
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-blue) !important;
        }

        .hero-section {
            padding: 120px 0 80px;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="%23e2e8f0" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 1.5rem;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--text-light);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .feature-card {
            background: white;
            border-radius: 16px;
            padding: 2.5rem 2rem;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid #f1f5f9;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: var(--gradient);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .feature-icon i {
            font-size: 1.5rem;
            color: white;
        }

        .section-padding {
            padding: 80px 0;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 1rem;
        }

        .section-subtitle {
            font-size: 1.125rem;
            color: var(--text-light);
            text-align: center;
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .user-type-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            border: 1px solid #f1f5f9;
            height: 100%;
        }

        .user-type-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            background: var(--gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
        }

        .user-avatar i {
            font-size: 2rem;
            color: white;
        }

        .testimonial-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid #f1f5f9;
            height: 100%;
        }

        .stars {
            color: #fbbf24;
            margin-bottom: 1rem;
        }

        .pricing-card {
            background: white;
            border-radius: 16px;
            padding: 2.5rem 2rem;
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid #f1f5f9;
            position: relative;
            transition: all 0.3s ease;
            height: 100%;
        }

        .pricing-card.popular {
            border: 2px solid var(--primary-blue);
            transform: scale(1.05);
        }

        .pricing-card.popular::before {
            content: 'Most Popular';
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--gradient);
            color: white;
            padding: 6px 20px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .pricing-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .pricing-card.popular:hover {
            transform: scale(1.05) translateY(-5px);
        }

        .price {
            font-size: 3rem;
            font-weight: 700;
            color: var(--primary-blue);
        }

        .faq-item {
            background: white;
            border-radius: 12px;
            margin-bottom: 1rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
        }

        .faq-header {
            padding: 1.5rem;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            font-weight: 500;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .faq-content {
            padding: 0 1.5rem 1.5rem;
            color: var(--text-light);
            display: none;
        }

        .footer {
            background: var(--text-dark);
            color: white;
            padding: 60px 0 30px;
        }

        .footer-title {
            font-weight: 600;
            margin-bottom: 1rem;
            color: white;
        }

        .footer-link {
            color: #9ca3af;
            text-decoration: none;
            transition: color 0.3s ease;
            display: block;
            margin-bottom: 0.5rem;
        }

        .footer-link:hover {
            color: var(--secondary-blue);
        }

        .social-icon {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.5rem;
            transition: all 0.3s ease;
        }

        .social-icon:hover {
            background: var(--primary-blue);
            transform: translateY(-2px);
        }

        .language-selector {
            position: relative;
        }

        .language-btn {
            background: none;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 8px 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .language-btn:hover {
            border-color: var(--primary-blue);
        }

        .language-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            display: none;
            min-width: 120px;
            z-index: 1000;
        }

        .language-dropdown.show {
            display: block;
        }

        .language-option {
            padding: 10px 15px;
            cursor: pointer;
            transition: background 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .language-option:hover {
            background: #f8fafc;
        }

        .hero-image {
            max-width: 100%;
            height: auto;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .section-title {
                font-size: 2rem;
            }
            
            .pricing-card.popular {
                transform: none;
                margin-top: 2rem;
            }
            
            .hero-section {
                padding: 80px 0 60px;
            }
        }

        .animate-fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .animate-fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .integration-logos {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2rem;
            flex-wrap: wrap;
            opacity: 0.6;
        }

        .integration-logo {
            height: 40px;
            /*filter: grayscale(100%);*/
            transition: all 0.3s ease;
        }

        .integration-logo:hover {
            filter: grayscale(0%);
            opacity: 1;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#"><i class="fas fa-chart-line me-2"></i>LabelTranslate</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link" href="#pricing">Pricing</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                </ul>
                
                <div class="d-flex align-items-center gap-3">
                    <div class="language-selector">
                        <button class="language-btn" onclick="toggleLanguage()">
                            <i class="fas fa-globe"></i>
                            <span id="currentLang">EN</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div class="language-dropdown" id="languageDropdown">
                            <div class="language-option" onclick="setLanguage('EN')">
                                <span>🇺🇸</span> English
                            </div>
                            <div class="language-option" onclick="setLanguage('TR')">
                                <span>🇹🇷</span> Türkçe
                            </div>
                            <div class="language-option" onclick="setLanguage('ES')">
                                <span>🇪🇸</span> Español
                            </div>
                        </div>
                    </div>
                    <a href="{{route('login')}}" class="btn btn-outline-custom">Sign In</a>
                    <a href="{{route('register')}}" class="btn btn-primary-custom">Get Started</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="hero-title animate-fade-in">Take the first step to <span style="background: var(--gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">grow your business</span> today</h1>
                    <p class="hero-subtitle animate-fade-in">Streamline your customer relationships, boost sales, and scale your business with our powerful CRM platform designed for modern teams.</p>
                    <div class="d-flex gap-3 flex-wrap animate-fade-in">
                        <a href="#" class="btn btn-primary-custom btn-lg">
                            <i class="fas fa-rocket me-2"></i>Get Started Now
                        </a>
                        <a href="#" class="btn btn-outline-custom btn-lg">
                            <i class="fas fa-play me-2"></i>Watch Demo
                        </a>
                    </div>
                    <div class="mt-4 animate-fade-in">
                        <small class="text-muted">✨ No credit card required • Free 14-day trial</small>
                    </div>
                </div>
                <div class="col-lg-6 mt-5 mt-lg-0">
                    <div class="animate-fade-in">
                        <img src="{{asset('site-assets/img/homepage2.png')}}" alt="CRM Dashboard" class="hero-image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Value Propositions -->
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="section-title animate-fade-in">Why Choose CRMFlow?</h2>
                    <p class="section-subtitle animate-fade-in">Everything you need to manage customer relationships and grow your business</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card animate-fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h4>Fast & Easy to Use</h4>
                        <p class="text-muted">Intuitive interface that your team will love. Get started in minutes, not hours.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card animate-fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <h4>Powerful Analytics</h4>
                        <p class="text-muted">Advanced reporting and insights to make data-driven decisions for your business.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card animate-fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h4>Team Collaboration</h4>
                        <p class="text-muted">Work together seamlessly with real-time updates and shared workflows.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="feature-card animate-fade-in">
                        <div class="feature-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4>Secure Infrastructure</h4>
                        <p class="text-muted">Enterprise-grade security with 99.9% uptime guarantee and data encryption.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Target Users -->
    <section class="section-padding" style="background: #f8fafc;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="section-title animate-fade-in">Designed for Every Business</h2>
                    <p class="section-subtitle animate-fade-in">From startups to enterprises, CRMFlow scales with your needs</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="user-type-card animate-fade-in">
                        <div class="user-avatar">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <h4>Startups</h4>
                        <p class="text-muted">Perfect for growing teams who need to organize leads and track customer interactions efficiently.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="user-type-card animate-fade-in">
                        <div class="user-avatar">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <h4>Small Businesses</h4>
                        <p class="text-muted">Streamline sales processes and improve customer service with affordable, powerful tools.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="user-type-card animate-fade-in">
                        <div class="user-avatar">
                            <i class="fas fa-building"></i>
                        </div>
                        <h4>Enterprises</h4>
                        <p class="text-muted">Advanced features, custom integrations, and dedicated support for large organizations.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section id="features" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="section-title animate-fade-in">Powerful Features</h2>
                    <p class="section-subtitle animate-fade-in">Everything you need to manage your customer relationships effectively</p>
                </div>
            </div>
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="animate-fade-in">
                        <h3 class="mb-3">Smart Lead Management</h3>
                        <p class="text-muted mb-4">Capture, qualify, and nurture leads automatically. Our AI-powered system helps you identify the most promising opportunities and guides you through the sales process.</p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Automated lead scoring</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Pipeline management</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Email automation</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Activity tracking</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="animate-fade-in">
                        <img src="{{asset('site-assets/img/homepage1.png')}}" alt="Lead Management" class="img-fluid rounded-3 shadow">
                    </div>
                </div>
            </div>
            
            <div class="row g-5 align-items-center mt-5">
                <div class="col-lg-6 order-lg-2">
                    <div class="animate-fade-in">
                        <h3 class="mb-3">Advanced Analytics</h3>
                        <p class="text-muted mb-4">Get deep insights into your sales performance, customer behavior, and team productivity. Make informed decisions with real-time data and customizable reports.</p>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Real-time dashboards</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Custom reports</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Sales forecasting</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Performance metrics</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 order-lg-1">
                    <div class="animate-fade-in">
                        <img src="{{asset('site-assets/img/homepage3.png')}}" alt="Analytics Dashboard" class="img-fluid rounded-3 shadow">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Integrations -->
    <section class="section-padding" style="background: #f8fafc;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="section-title animate-fade-in">Seamless Integrations</h2>
                    <p class="section-subtitle animate-fade-in">Connect with your favorite tools and platforms</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="integration-logos animate-fade-in">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2f/Google_2015_logo.svg/1200px-Google_2015_logo.svg.png" alt="Google" class="integration-logo">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/44/Microsoft_logo.svg/1200px-Microsoft_logo.svg.png" alt="Microsoft" class="integration-logo">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b9/Slack_Technologies_Logo.svg/2560px-Slack_Technologies_Logo.svg.png" alt="Slack" class="integration-logo">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/7b/Zoom_Communications_Logo.svg/2560px-Zoom_Communications_Logo.svg.png" alt="Zoom" class="integration-logo">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/f9/Salesforce.com_logo.svg/2560px-Salesforce.com_logo.svg.png" alt="Salesforce" class="integration-logo">
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/HubSpot_Logo.svg/2560px-HubSpot_Logo.svg.png" alt="HubSpot" class="integration-logo">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="section-title animate-fade-in">What Our Customers Say</h2>
                    <p class="section-subtitle animate-fade-in">Join thousands of satisfied customers worldwide</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="testimonial-card animate-fade-in">
                        <div class="stars mb-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="mb-3">"CRMFlow transformed our sales process. We've seen a 40% increase in conversions since switching."</p>
                        <div class="d-flex align-items-center">
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=50&h=50" alt="Sarah Johnson" class="rounded-circle me-3" width="50" height="50">
                            <div>
                                <h6 class="mb-0">Sarah Johnson</h6>
                                <small class="text-muted">Sales Director, TechCorp</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-card animate-fade-in">
                        <div class="stars mb-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="mb-3">"The analytics features are incredible. We can now make data-driven decisions with confidence."</p>
                        <div class="d-flex align-items-center">
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=50&h=50" alt="Michael Chen" class="rounded-circle me-3" width="50" height="50">
                            <div>
                                <h6 class="mb-0">Michael Chen</h6>
                                <small class="text-muted">CEO, StartupXYZ</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-card animate-fade-in">
                        <div class="stars mb-3">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p class="mb-3">"Easy to use, powerful features, and excellent customer support. Highly recommended!"</p>
                        <div class="d-flex align-items-center">
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=50&h=50" alt="Emily Rodriguez" class="rounded-circle me-3" width="50" height="50">
                            <div>
                                <h6 class="mb-0">Emily Rodriguez</h6>
                                <small class="text-muted">Marketing Manager, GrowthCo</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing -->
    <section id="pricing" class="section-padding" style="background: #f8fafc;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="section-title animate-fade-in">Simple, Transparent Pricing</h2>
                    <p class="section-subtitle animate-fade-in">Choose the plan that fits your business needs</p>
                </div>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-card animate-fade-in">
                        <h4 class="text-center mb-3">Starter</h4>
                        <div class="text-center mb-4">
                            <span class="price">$19</span>
                            <span class="text-muted">/month</span>
                        </div>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Up to 1,000 contacts</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Basic reporting</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Email support</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Mobile app</li>
                        </ul>
                        <a href="#" class="btn btn-outline-custom w-100">Get Started</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-card popular animate-fade-in">
                        <h4 class="text-center mb-3">Professional</h4>
                        <div class="text-center mb-4">
                            <span class="price">$49</span>
                            <span class="text-muted">/month</span>
                        </div>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Up to 10,000 contacts</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Advanced analytics</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Priority support</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>API access</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Team collaboration</li>
                        </ul>
                        <a href="#" class="btn btn-primary-custom w-100">Get Started</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="pricing-card animate-fade-in">
                        <h4 class="text-center mb-3">Enterprise</h4>
                        <div class="text-center mb-4">
                            <span class="price">$99</span>
                            <span class="text-muted">/month</span>
                        </div>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Unlimited contacts</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Custom integrations</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>24/7 phone support</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Advanced security</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Dedicated manager</li>
                        </ul>
                        <a href="#" class="btn btn-outline-custom w-100">Contact Sales</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="section-title animate-fade-in">Frequently Asked Questions</h2>
                    <p class="section-subtitle animate-fade-in">Everything you need to know about CRMFlow</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="animate-fade-in">
                        <div class="faq-item">
                            <button class="faq-header" onclick="toggleFaq(this)">
                                How easy is it to get started with CRMFlow?
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="faq-content">
                                Getting started is incredibly simple. You can sign up in under 2 minutes, import your existing contacts, and start managing your customer relationships immediately. Our onboarding process guides you through the setup.
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <button class="faq-header" onclick="toggleFaq(this)">
                                Can I migrate my data from other CRM systems?
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="faq-content">
                                Yes! We support data migration from all major CRM platforms including Salesforce, HubSpot, Pipedrive, and more. Our migration specialists will help ensure a smooth transition with zero data loss.
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <button class="faq-header" onclick="toggleFaq(this)">
                                Is my data secure with CRMFlow?
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="faq-content">
                                Absolutely. We use enterprise-grade security with 256-bit SSL encryption, regular security audits, and comply with GDPR, SOC 2, and other industry standards. Your data is stored in secure, redundant data centers.
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <button class="faq-header" onclick="toggleFaq(this)">
                                Do you offer customer support?
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="faq-content">
                                Yes! We provide comprehensive support including email support for all plans, priority support for Professional plans, and 24/7 phone support for Enterprise customers. We also have extensive documentation and video tutorials.
                            </div>
                        </div>
                        
                        <div class="faq-item">
                            <button class="faq-header" onclick="toggleFaq(this)">
                                Can I cancel my subscription anytime?
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="faq-content">
                                Yes, you can cancel your subscription at any time. There are no long-term contracts or cancellation fees. You'll continue to have access to your account until the end of your current billing period.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section-padding gradient-bg text-white">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h2 class="mb-4 animate-fade-in">Ready to Transform Your Business?</h2>
                    <p class="mb-4 fs-5 animate-fade-in">Join thousands of businesses that trust CRMFlow to manage their customer relationships and drive growth.</p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap animate-fade-in">
                        <a href="#" class="btn btn-light btn-lg">
                            <i class="fas fa-rocket me-2"></i>Start Free Trial
                        </a>
                        <a href="#" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-calendar me-2"></i>Schedule Demo
                        </a>
                    </div>
                    <div class="mt-4 animate-fade-in">
                        <small>✨ 14-day free trial • No credit card required • Cancel anytime</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="footer-title"><i class="fas fa-chart-line me-2"></i>CRMFlow</h5>
                    <p class="text-muted mb-4">Empowering businesses to build stronger customer relationships and drive sustainable growth through intelligent CRM solutions.</p>
                    <div class="d-flex">
                        <a href="#" class="social-icon text-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon text-white"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-icon text-white"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="footer-title">Product</h6>
                    <a href="#" class="footer-link">Features</a>
                    <a href="#" class="footer-link">Pricing</a>
                    <a href="#" class="footer-link">Integrations</a>
                    <a href="#" class="footer-link">API</a>
                    <a href="#" class="footer-link">Security</a>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="footer-title">Company</h6>
                    <a href="#" class="footer-link">About Us</a>
                    <a href="#" class="footer-link">Careers</a>
                    <a href="#" class="footer-link">Blog</a>
                    <a href="#" class="footer-link">Press</a>
                    <a href="#" class="footer-link">Partners</a>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="footer-title">Support</h6>
                    <a href="#" class="footer-link">Help Center</a>
                    <a href="#" class="footer-link">Contact Us</a>
                    <a href="#" class="footer-link">System Status</a>
                    <a href="#" class="footer-link">Community</a>
                    <a href="#" class="footer-link">Training</a>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="footer-title">Legal</h6>
                    <a href="#" class="footer-link">Privacy Policy</a>
                    <a href="#" class="footer-link">Terms of Service</a>
                    <a href="#" class="footer-link">Cookie Policy</a>
                    <a href="#" class="footer-link">GDPR</a>
                    <a href="#" class="footer-link">Compliance</a>
                </div>
            </div>
            <hr class="my-4" style="border-color: #374151;">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-muted mb-0">&copy; 2024 CRMFlow. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted mb-0">Made with ❤️ for growing businesses</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Language selector
        function toggleLanguage() {
            const dropdown = document.getElementById('languageDropdown');
            dropdown.classList.toggle('show');
        }

        function setLanguage(lang) {
            document.getElementById('currentLang').textContent = lang;
            document.getElementById('languageDropdown').classList.remove('show');
        }

        // Close language dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const languageSelector = document.querySelector('.language-selector');
            if (!languageSelector.contains(event.target)) {
                document.getElementById('languageDropdown').classList.remove('show');
            }
        });

        // FAQ toggle
        function toggleFaq(button) {
            const content = button.nextElementSibling;
            const icon = button.querySelector('i');
            
            if (content.style.display === 'block') {
                content.style.display = 'none';
                icon.style.transform = 'rotate(0deg)';
            } else {
                // Close all other FAQ items
                document.querySelectorAll('.faq-content').forEach(item => {
                    item.style.display = 'none';
                });
                document.querySelectorAll('.faq-header i').forEach(icon => {
                    icon.style.transform = 'rotate(0deg)';
                });
                
                content.style.display = 'block';
                icon.style.transform = 'rotate(180deg)';
            }
        }

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Observe all elements with animate-fade-in class
        document.querySelectorAll('.animate-fade-in').forEach(el => {
            observer.observe(el);
        });

        // Add some interactive hover effects
        document.querySelectorAll('.feature-card, .user-type-card, .pricing-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px)';
            });
            
            card.addEventListener('mouseleave', function() {
                if (this.classList.contains('popular')) {
                    this.style.transform = 'scale(1.05)';
                } else {
                    this.style.transform = 'translateY(0)';
                }
            });
        });

        // Add loading animation for images
        document.querySelectorAll('img').forEach(img => {
            img.addEventListener('load', function() {
                this.style.opacity = '1';
            });
        });
    </script>
</body>
</html>