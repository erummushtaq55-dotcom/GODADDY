<?php
// index.php - ULTIMATE LUXURY VERSION
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DomainSphere Elite | Premium Domain Marketplace</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Professional Luxury Variables */
        :root {
            --primary: #0f0f23;
            --secondary: #1a1a3e;
            --accent: #FFD700;
            --accent-gradient: linear-gradient(45deg, #FFD700, #FFC107, #FFD700);
            --glass-bg: rgba(255, 255, 255, 0.08);
            --glass-border: rgba(255, 255, 255, 0.15);
            --text-primary: #ffffff;
            --text-secondary: rgba(255, 255, 255, 0.8);
            --text-muted: rgba(255, 255, 255, 0.6);
            --font-heading: 'Playfair Display', serif;
            --font-body: 'Montserrat', sans-serif;
            --shadow-lg: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            --shadow-xl: 0 35px 60px -15px rgba(0, 0, 0, 0.6);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-body);
            background: linear-gradient(135deg, #0a0a0f 0%, #151528 50%, #0a0a0f 100%);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }

        /* Animated Background */
        .bg-animation {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }

        .bg-circle {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255,215,0,0.1) 0%, transparent 70%);
            animation: float 20s infinite linear;
        }

        .bg-circle:nth-child(1) {
            width: 300px;
            height: 300px;
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        .bg-circle:nth-child(2) {
            width: 200px;
            height: 200px;
            top: 60%;
            right: 10%;
            animation-delay: -5s;
        }

        .bg-circle:nth-child(3) {
            width: 400px;
            height: 400px;
            bottom: 10%;
            left: 20%;
            animation-delay: -10s;
        }

        /* Grid Lines */
        .grid-lines {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            z-index: -1;
            opacity: 0.3;
        }

        /* Professional Header */
        .professional-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 1.5rem 0;
            background: rgba(15, 15, 35, 0.9);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .header-scrolled {
            padding: 1rem 0;
            box-shadow: var(--shadow-lg);
        }

        .header-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .brand-logo {
            width: 50px;
            height: 50px;
            background: var(--accent-gradient);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .brand-logo::before {
            content: '';
            position: absolute;
            width: 150%;
            height: 150%;
            background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 50%, transparent 70%);
            animation: shine 3s infinite;
            transform: rotate(45deg);
        }

        .brand-text h1 {
            font-family: var(--font-heading);
            font-size: 1.8rem;
            font-weight: 700;
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .brand-text span {
            font-size: 0.8rem;
            color: var(--text-muted);
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* Navigation */
        .nav-menu {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-link {
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: var(--text-primary);
            background: var(--glass-bg);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--accent-gradient);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 80%;
        }

        .cta-button {
            background: var(--accent-gradient);
            color: #000;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 10px 30px rgba(255, 215, 0, 0.3);
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(255, 215, 0, 0.4);
        }

        /* Hero Section */
        .hero-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 6rem 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .hero-content h2 {
            font-family: var(--font-heading);
            font-size: 4rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            background: linear-gradient(45deg, #ffffff, #FFD700, #ffffff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            background-size: 200% 200%;
            animation: gradient-shift 3s ease infinite;
        }

        .hero-content p {
            font-size: 1.2rem;
            color: var(--text-secondary);
            margin-bottom: 2rem;
            line-height: 1.8;
        }

        /* Search Container */
        .search-container {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 3rem;
            box-shadow: var(--shadow-xl);
            position: relative;
            overflow: hidden;
        }

        .search-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 40%, rgba(255,255,255,0.05) 50%, transparent 60%);
            animation: search-shimmer 6s infinite linear;
            z-index: 1;
        }

        .search-container > * {
            position: relative;
            z-index: 2;
        }

        .search-title {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 2rem;
            text-align: center;
        }

        .search-form {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .search-input-group {
            flex: 1;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 1.2rem 1.5rem 1.2rem 3rem;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: var(--text-primary);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 30px rgba(255, 215, 0, 0.2);
            background: rgba(255, 255, 255, 0.08);
        }

        .search-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
        }

        .search-extension {
            padding: 1.2rem 1.5rem;
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: var(--text-primary);
            font-size: 1rem;
            min-width: 120px;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='white' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
        }

        .search-button {
            padding: 1.2rem 2.5rem;
            background: var(--accent-gradient);
            border: none;
            border-radius: 12px;
            color: #000;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .search-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 215, 0, 0.4);
        }

        .extensions-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-top: 2rem;
        }

        .extension-chip {
            padding: 0.8rem 1.5rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 50px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .extension-chip:hover {
            background: rgba(255, 215, 0, 0.1);
            border-color: var(--accent);
            transform: translateY(-2px);
        }

        .extension-chip.active {
            background: var(--accent-gradient);
            color: #000;
            border-color: var(--accent);
        }

        /* Results Section */
        .results-section {
            padding: 6rem 2rem;
            position: relative;
        }

        .section-title {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-title h3 {
            font-family: var(--font-heading);
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .section-title p {
            color: var(--text-secondary);
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .results-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .domain-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 2rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .domain-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--accent-gradient);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .domain-card:hover::before {
            transform: scaleX(1);
        }

        .domain-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-xl);
        }

        .domain-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .domain-name {
            font-size: 1.8rem;
            font-weight: 700;
        }

        .domain-name .extension {
            color: var(--accent);
        }

        .domain-status {
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        .domain-status.available {
            background: linear-gradient(45deg, #10b981, #059669);
            color: white;
        }

        .domain-status.registered {
            background: linear-gradient(45deg, #ef4444, #dc2626);
            color: white;
        }

        .domain-price {
            font-size: 2.5rem;
            font-weight: 800;
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 1.5rem 0;
        }

        /* Stats Section */
        .stats-section {
            padding: 6rem 2rem;
            background: linear-gradient(135deg, rgba(15, 15, 35, 0.8) 0%, rgba(26, 26, 62, 0.8) 100%);
            position: relative;
            overflow: hidden;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 3rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .stat-card {
            text-align: center;
            padding: 2rem;
            position: relative;
        }

        .stat-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: var(--glass-bg);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--accent);
            position: relative;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        /* Features Section */
        .features-section {
            padding: 6rem 2rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            max-width: 1200px;
            margin: 4rem auto 0;
        }

        .feature-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 3rem 2rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-xl);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 2rem;
            background: var(--accent-gradient);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #000;
        }

        /* CTA Section */
        .cta-section {
            padding: 8rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255,215,0,0.1) 50%, transparent 70%);
            animation: cta-shimmer 8s infinite linear;
        }

        .cta-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
        }

        .cta-content h2 {
            font-family: var(--font-heading);
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 2rem;
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Footer */
        .footer {
            padding: 4rem 2rem 2rem;
            background: rgba(10, 10, 15, 0.95);
            border-top: 1px solid var(--glass-border);
        }

        .footer-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 3rem;
        }

        .footer-brand h3 {
            font-family: var(--font-heading);
            font-size: 1.8rem;
            margin-bottom: 1rem;
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Animations */
        @keyframes float {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        @keyframes shine {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }

        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        @keyframes search-shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        @keyframes cta-shimmer {
            0% { transform: translateX(-100%) rotate(45deg); }
            100% { transform: translateX(100%) rotate(45deg); }
        }

        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .hero-container {
                grid-template-columns: 1fr;
                text-align: center;
            }
            
            .stats-grid,
            .features-grid,
            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .hero-content h2 {
                font-size: 3rem;
            }
        }

        @media (max-width: 768px) {
            .nav-menu {
                display: none;
            }
            
            .mobile-menu-toggle {
                display: block;
            }
            
            .extensions-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .search-form {
                flex-direction: column;
            }
            
            .hero-content h2 {
                font-size: 2.5rem;
            }
            
            .stats-grid,
            .features-grid,
            .footer-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Custom Animations */
        .animate-fade-in-up {
            animation: fade-in-up 0.8s ease-out;
        }

        .animate-delay-1 {
            animation-delay: 0.2s;
        }

        .animate-delay-2 {
            animation-delay: 0.4s;
        }

        .animate-delay-3 {
            animation-delay: 0.6s;
        }

        /* Loading Animation */
        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 3px solid rgba(255, 255, 255, 0.1);
            border-top: 3px solid var(--accent);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Notification */
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1.5rem 2rem;
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            box-shadow: var(--shadow-lg);
            transform: translateX(150%);
            transition: transform 0.3s ease;
            z-index: 10000;
            display: flex;
            align-items: center;
            gap: 1rem;
            max-width: 400px;
        }

        .notification.show {
            transform: translateX(0);
        }

        /* Progress Bar */
        .progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: var(--accent-gradient);
            z-index: 1001;
            transition: width 0.3s ease;
        }

        /* Particle Container */
        .particles-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .particle {
            position: absolute;
            width: 2px;
            height: 2px;
            background: var(--accent);
            border-radius: 50%;
            animation: particle-float 15s infinite linear;
        }

        @keyframes particle-float {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100px) rotate(360deg);
                opacity: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="bg-animation">
        <div class="bg-circle"></div>
        <div class="bg-circle"></div>
        <div class="bg-circle"></div>
        <div class="grid-lines"></div>
    </div>

    <!-- Particles -->
    <div class="particles-container" id="particles"></div>

    <!-- Progress Bar -->
    <div class="progress-bar" id="progressBar"></div>

    <!-- Professional Header -->
    <header class="professional-header" id="header">
        <div class="header-container">
            <div class="brand">
                <div class="brand-logo">
                    <i class="fas fa-globe-americas"></i>
                </div>
                <div class="brand-text">
                    <h1>DomainSphere</h1>
                    <span>Elite</span>
                </div>
            </div>
            
            <nav class="nav-menu">
                <a href="#" class="nav-link active">Home</a>
                <a href="#" class="nav-link">Marketplace</a>
                <a href="#" class="nav-link">Services</a>
                <a href="#" class="nav-link">Portfolio</a>
                <a href="#" class="nav-link">Enterprise</a>
                <?php if (isLoggedIn()): ?>
                    <a href="dashboard.php" class="nav-link">
                        <i class="fas fa-chart-line"></i> Dashboard
                    </a>
                <?php else: ?>
                    <a href="login.php" class="nav-link">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                <?php endif; ?>
                <button class="cta-button">
                    <i class="fas fa-crown"></i>
                    Get Started
                </button>
            </nav>
            
            <button class="mobile-menu-toggle" id="mobileMenuToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-content animate-fade-in-up">
                <h2>Discover Digital Real Estate That Defines Excellence</h2>
                <p>Secure your premium online identity with the world's most sophisticated domain marketplace. Powered by AI-driven insights and backed by blockchain security.</p>
                
                <div class="hero-stats">
                    <div style="display: flex; gap: 3rem; margin-top: 3rem;">
                        <div>
                            <div class="stat-number">10M+</div>
                            <p style="color: var(--text-muted);">Premium Domains</p>
                        </div>
                        <div>
                            <div class="stat-number">99.9%</div>
                            <p style="color: var(--text-muted);">Uptime SLA</p>
                        </div>
                        <div>
                            <div class="stat-number">24/7</div>
                            <p style="color: var(--text-muted);">Priority Support</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="search-container animate-fade-in-up animate-delay-1">
                <h3 class="search-title">Find Your Perfect Domain</h3>
                
                <form class="search-form" id="searchForm">
                    <div class="search-input-group">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" 
                               class="search-input" 
                               id="domainInput"
                               placeholder="Enter your dream domain..."
                               required>
                    </div>
                    
                    <select class="search-extension" id="extensionSelect">
                        <option value="com">.com</option>
                        <option value="io">.io</option>
                        <option value="co">.co</option>
                        <option value="ai">.ai</option>
                        <option value="tech">.tech</option>
                        <option value="app">.app</option>
                        <option value="dev">.dev</option>
                        <option value="xyz">.xyz</option>
                    </select>
                    
                    <button type="submit" class="search-button">
                        <i class="fas fa-search"></i>
                        Search
                    </button>
                </form>
                
                <div class="extensions-grid">
                    <div class="extension-chip" data-ext="com">.com</div>
                    <div class="extension-chip" data-ext="io">.io</div>
                    <div class="extension-chip" data-ext="ai">.ai</div>
                    <div class="extension-chip" data-ext="tech">.tech</div>
                    <div class="extension-chip" data-ext="app">.app</div>
                    <div class="extension-chip" data-ext="dev">.dev</div>
                    <div class="extension-chip" data-ext="xyz">.xyz</div>
                    <div class="extension-chip" data-ext="co">.co</div>
                </div>
                
                <div id="loading" style="display: none; text-align: center; margin-top: 2rem;">
                    <div class="loading-spinner"></div>
                    <p style="margin-top: 1rem; color: var(--text-muted);">Analyzing domain availability...</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Results Section -->
    <section class="results-section" id="resultsSection">
        <div class="section-title">
            <h3>Featured Premium Domains</h3>
            <p>Curated collection of exclusive digital assets with exceptional branding potential</p>
        </div>
        
        <div class="results-grid">
            <!-- Results will be populated here -->
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="section-title">
            <h3>Why DomainSphere Elite</h3>
            <p>Trusted by Fortune 500 companies and visionary entrepreneurs worldwide</p>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card animate-fade-in-up">
                <div class="stat-icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <div class="stat-number">0.2s</div>
                <p style="color: var(--text-secondary);">Instant Search Results</p>
            </div>
            
            <div class="stat-card animate-fade-in-up animate-delay-1">
                <div class="stat-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="stat-number">256-bit</div>
                <p style="color: var(--text-secondary);">Military Grade Encryption</p>
            </div>
            
            <div class="stat-card animate-fade-in-up animate-delay-2">
                <div class="stat-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <div class="stat-number">150+</div>
                <p style="color: var(--text-secondary);">TLD Extensions Supported</p>
            </div>
            
            <div class="stat-card animate-fade-in-up animate-delay-3">
                <div class="stat-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <div class="stat-number">24/7</div>
                <p style="color: var(--text-secondary);">Dedicated Concierge</p>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section">
        <div class="section-title">
            <h3>Enterprise-Grade Features</h3>
            <p>Designed for professionals who demand excellence</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card animate-fade-in-up">
                <div class="feature-icon">
                    <i class="fas fa-brain"></i>
                </div>
                <h4 style="margin-bottom: 1rem; font-size: 1.5rem;">AI-Powered Insights</h4>
                <p style="color: var(--text-secondary);">Predictive analytics and market trends analysis powered by advanced machine learning algorithms.</p>
            </div>
            
            <div class="feature-card animate-fade-in-up animate-delay-1">
                <div class="feature-icon">
                    <i class="fas fa-lock"></i>
                </div>
                <h4 style="margin-bottom: 1rem; font-size: 1.5rem;">Blockchain Security</h4>
                <p style="color: var(--text-secondary);">Immutable ownership records and decentralized verification for ultimate domain security.</p>
            </div>
            
            <div class="feature-card animate-fade-in-up animate-delay-2">
                <div class="feature-icon">
                    <i class="fas fa-chart-network"></i>
                </div>
                <h4 style="margin-bottom: 1rem; font-size: 1.5rem;">Portfolio Management</h4>
                <p style="color: var(--text-secondary);">Comprehensive tools for managing large domain portfolios with automated renewals and transfers.</p>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="cta-content">
            <h2>Ready to Build Your Digital Empire?</h2>
            <p style="font-size: 1.2rem; color: var(--text-secondary); margin-bottom: 3rem; max-width: 600px; margin: 0 auto 3rem;">
                Join thousands of successful businesses that trust DomainSphere Elite for their online presence.
            </p>
            <button class="cta-button" style="font-size: 1.2rem; padding: 1.2rem 3rem;">
                <i class="fas fa-rocket"></i>
                Launch Your Domain Journey
            </button>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-grid">
            <div class="footer-brand">
                <h3>DomainSphere</h3>
                <p style="color: var(--text-muted); margin-bottom: 2rem;">Redefining digital excellence since 2012.</p>
                <div style="display: flex; gap: 1rem;">
                    <i class="fab fa-twitter" style="color: var(--text-muted); cursor: pointer;"></i>
                    <i class="fab fa-linkedin" style="color: var(--text-muted); cursor: pointer;"></i>
                    <i class="fab fa-instagram" style="color: var(--text-muted); cursor: pointer;"></i>
                    <i class="fab fa-github" style="color: var(--text-muted); cursor: pointer;"></i>
                </div>
            </div>
            
            <div>
                <h4 style="margin-bottom: 1.5rem; font-size: 1.2rem;">Platform</h4>
                <ul style="list-style: none;">
                    <li><a href="#" style="color: var(--text-muted); text-decoration: none; display: block; margin-bottom: 0.8rem;">Marketplace</a></li>
                    <li><a href="#" style="color: var(--text-muted); text-decoration: none; display: block; margin-bottom: 0.8rem;">Domain Auctions</a></li>
                    <li><a href="#" style="color: var(--text-muted); text-decoration: none; display: block; margin-bottom: 0.8rem;">Enterprise Solutions</a></li>
                    <li><a href="#" style="color: var(--text-muted); text-decoration: none; display: block; margin-bottom: 0.8rem;">API Access</a></li>
                </ul>
            </div>
            
            <div>
                <h4 style="margin-bottom: 1.5rem; font-size: 1.2rem;">Resources</h4>
                <ul style="list-style: none;">
                    <li><a href="#" style="color: var(--text-muted); text-decoration: none; display: block; margin-bottom: 0.8rem;">Documentation</a></li>
                    <li><a href="#" style="color: var(--text-muted); text-decoration: none; display: block; margin-bottom: 0.8rem;">Blog</a></li>
                    <li><a href="#" style="color: var(--text-muted); text-decoration: none; display: block; margin-bottom: 0.8rem;">Case Studies</a></li>
                    <li><a href="#" style="color: var(--text-muted); text-decoration: none; display: block; margin-bottom: 0.8rem;">Help Center</a></li>
                </ul>
            </div>
            
            <div>
                <h4 style="margin-bottom: 1.5rem; font-size: 1.2rem;">Legal</h4>
                <ul style="list-style: none;">
                    <li><a href="#" style="color: var(--text-muted); text-decoration: none; display: block; margin-bottom: 0.8rem;">Privacy Policy</a></li>
                    <li><a href="#" style="color: var(--text-muted); text-decoration: none; display: block; margin-bottom: 0.8rem;">Terms of Service</a></li>
                    <li><a href="#" style="color: var(--text-muted); text-decoration: none; display: block; margin-bottom: 0.8rem;">Cookie Policy</a></li>
                    <li><a href="#" style="color: var(--text-muted); text-decoration: none; display: block; margin-bottom: 0.8rem;">GDPR Compliance</a></li>
                </ul>
            </div>
        </div>
        
        <div style="text-align: center; margin-top: 4rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1);">
            <p style="color: var(--text-muted);">
                © 2024 DomainSphere Elite. All rights reserved. 
                <span style="color: var(--accent);">Digital Excellence Redefined.</span>
            </p>
        </div>
    </footer>

    <!-- Notification Container -->
    <div id="notificationContainer"></div>

    <script>
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize particles
            initParticles();
            
            // Initialize animations
            initAnimations();
            
            // Initialize event listeners
            initEventListeners();
            
            // Load featured domains
            loadFeaturedDomains();
            
            // Initialize scroll effects
            initScrollEffects();
        });

        // Initialize particles
        function initParticles() {
            const container = document.getElementById('particles');
            for (let i = 0; i < 100; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.cssText = `
                    left: ${Math.random() * 100}%;
                    animation-delay: ${Math.random() * 15}s;
                    animation-duration: ${Math.random() * 10 + 10}s;
                `;
                container.appendChild(particle);
            }
        }

        // Initialize animations
        function initAnimations() {
            // Add animation classes to elements on scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fade-in-up');
                    }
                });
            }, { threshold: 0.1 });

            // Observe all elements that should animate
            document.querySelectorAll('.stat-card, .feature-card, .domain-card').forEach(el => {
                observer.observe(el);
            });
        }

        // Initialize event listeners
        function initEventListeners() {
            // Search form submission
            document.getElementById('searchForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const domain = document.getElementById('domainInput').value.trim();
                const extension = document.getElementById('extensionSelect').value;
                
                if (domain) {
                    performDomainSearch(domain, extension);
                }
            });

            // Extension chip clicks
            document.querySelectorAll('.extension-chip').forEach(chip => {
                chip.addEventListener('click', function() {
                    const ext = this.getAttribute('data-ext');
                    document.getElementById('extensionSelect').value = ext;
                    
                    // Update active state
                    document.querySelectorAll('.extension-chip').forEach(c => {
                        c.classList.remove('active');
                    });
                    this.classList.add('active');
                });
            });

            // Mobile menu toggle
            document.getElementById('mobileMenuToggle').addEventListener('click', function() {
                document.querySelector('.nav-menu').classList.toggle('show');
            });

            // Window scroll for header effect
            window.addEventListener('scroll', function() {
                const header = document.getElementById('header');
                const progressBar = document.getElementById('progressBar');
                
                // Header scroll effect
                if (window.scrollY > 100) {
                    header.classList.add('header-scrolled');
                } else {
                    header.classList.remove('header-scrolled');
                }
                
                // Progress bar
                const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
                const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                const scrolled = (winScroll / height) * 100;
                progressBar.style.width = scrolled + "%";
            });
        }

        // Initialize scroll effects
        function initScrollEffects() {
            // Parallax effect for background circles
            window.addEventListener('scroll', function() {
                const scrolled = window.pageYOffset;
                const circles = document.querySelectorAll('.bg-circle');
                
                circles.forEach((circle, index) => {
                    const speed = 0.5 + (index * 0.1);
                    circle.style.transform = `translateY(${scrolled * speed}px)`;
                });
            });
        }

        // Load featured domains
        function loadFeaturedDomains() {
            const featuredDomains = [
                { name: 'innovation', ext: 'io', price: 49999, status: 'available' },
                { name: 'quantum', ext: 'ai', price: 79999, status: 'available' },
                { name: 'nexus', ext: 'tech', price: 34999, status: 'available' },
                { name: 'apex', ext: 'co', price: 24999, status: 'available' },
                { name: 'vortex', ext: 'app', price: 29999, status: 'available' },
                { name: 'zenith', ext: 'dev', price: 54999, status: 'available' }
            ];

            const grid = document.querySelector('.results-grid');
            grid.innerHTML = '';

            featuredDomains.forEach(domain => {
                const card = createDomainCard(domain);
                grid.appendChild(card);
            });
        }

        // Create domain card
        function createDomainCard(domain) {
            const card = document.createElement('div');
            card.className = 'domain-card';
            card.innerHTML = `
                <div class="domain-header">
                    <div class="domain-name">
                        ${domain.name}<span class="extension">.${domain.ext}</span>
                    </div>
                    <div class="domain-status ${domain.status}">
                        ${domain.status === 'available' ? 'Available' : 'Registered'}
                    </div>
                </div>
                <div class="domain-price">
                    $${domain.price.toLocaleString()}
                    <small style="font-size: 1rem; color: var(--text-muted);">/one-time</small>
                </div>
                <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">
                    Premium ${domain.ext.toUpperCase()} domain with exceptional branding potential.
                </p>
                <div style="display: flex; gap: 1rem;">
                    <button class="search-button" style="flex: 1;" onclick="inquireDomain('${domain.name}', '${domain.ext}')">
                        <i class="fas fa-info-circle"></i> Inquire
                    </button>
                    <button class="cta-button" style="flex: 1;" onclick="purchaseDomain('${domain.name}', '${domain.ext}', ${domain.price})">
                        <i class="fas fa-shopping-cart"></i> Purchase
                    </button>
                </div>
            `;
            return card;
        }

        // Perform domain search
        function performDomainSearch(domain, extension) {
            const loading = document.getElementById('loading');
            const resultsSection = document.getElementById('resultsSection');
            
            // Show loading
            loading.style.display = 'block';
            
            // Scroll to results
            resultsSection.scrollIntoView({ behavior: 'smooth' });
            
            // Simulate API call
            setTimeout(() => {
                loading.style.display = 'none';
                
                // Show notification
                showNotification('Domain analysis complete!', 'success');
                
                // Generate search result
                const isAvailable = Math.random() > 0.3;
                const price = generateDomainPrice(domain, extension);
                
                const resultCard = createSearchResultCard(domain, extension, isAvailable, price);
                const grid = document.querySelector('.results-grid');
                grid.innerHTML = '';
                grid.appendChild(resultCard);
                
                // Add animation
                resultCard.classList.add('animate-fade-in-up');
            }, 2000);
        }

        // Generate domain price
        function generateDomainPrice(domain, extension) {
            const basePrice = {
                'com': 10000,
                'io': 15000,
                'ai': 25000,
                'tech': 8000,
                'app': 12000,
                'dev': 18000,
                'xyz': 5000,
                'co': 7000
            };
            
            const lengthMultiplier = Math.max(0.5, 1 - (domain.length / 20));
            const premiumFactor = domain.includes('tech') || domain.includes('ai') ? 1.5 : 1;
            const randomFactor = 0.8 + Math.random() * 0.4;
            
            return Math.round((basePrice[extension] || 5000) * lengthMultiplier * premiumFactor * randomFactor);
        }

        // Create search result card
        function createSearchResultCard(domain, extension, isAvailable, price) {
            const card = document.createElement('div');
            card.className = 'domain-card';
            card.innerHTML = `
                <div class="domain-header">
                    <div class="domain-name">
                        ${domain}<span class="extension">.${extension}</span>
                    </div>
                    <div class="domain-status ${isAvailable ? 'available' : 'registered'}">
                        ${isAvailable ? 'Available' : 'Registered'}
                    </div>
                </div>
                
                ${isAvailable ? `
                    <div class="domain-price">
                        $${price.toLocaleString()}
                        <small style="font-size: 1rem; color: var(--text-muted);">/one-time</small>
                    </div>
                    
                    <div style="margin: 1.5rem 0;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span style="color: var(--text-muted);">Brand Score:</span>
                            <span style="color: var(--accent); font-weight: 600;">${Math.round(Math.random() * 30 + 70)}/100</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span style="color: var(--text-muted);">SEO Potential:</span>
                            <span style="color: var(--accent); font-weight: 600;">${Math.round(Math.random() * 30 + 70)}/100</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--text-muted);">Market Demand:</span>
                            <span style="color: var(--accent); font-weight: 600;">${Math.round(Math.random() * 30 + 70)}/100</span>
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 1rem;">
                        <button class="search-button" style="flex: 1;" onclick="saveDomain('${domain}', '${extension}')">
                            <i class="fas fa-bookmark"></i> Save
                        </button>
                        <button class="cta-button" style="flex: 2;" onclick="purchaseDomain('${domain}', '${extension}', ${price})">
                            <i class="fas fa-lock"></i> Secure Purchase
                        </button>
                    </div>
                ` : `
                    <div style="text-align: center; padding: 2rem 0;">
                        <i class="fas fa-lock" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
                        <p style="color: var(--text-secondary); margin-bottom: 1.5rem;">
                            This domain is currently registered. We can assist with acquisition negotiations.
                        </p>
                        <button class="cta-button" onclick="initiateNegotiation('${domain}', '${extension}')">
                            <i class="fas fa-handshake"></i> Request Acquisition
                        </button>
                    </div>
                `}
            `;
            return card;
        }

        // Show notification
        function showNotification(message, type = 'info') {
            const container = document.getElementById('notificationContainer');
            const notification = document.createElement('div');
            notification.className = 'notification';
            
            const icon = type === 'success' ? 'check-circle' : 
                         type === 'error' ? 'exclamation-circle' : 'info-circle';
            
            notification.innerHTML = `
                <i class="fas fa-${icon}" style="color: ${type === 'success' ? '#10b981' : type === 'error' ? '#ef4444' : '#3b82f6'}"></i>
                <div>
                    <strong>${message}</strong>
                </div>
            `;
            
            container.appendChild(notification);
            
            // Show notification
            setTimeout(() => notification.classList.add('show'), 100);
            
            // Remove notification after delay
            setTimeout(() => {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Domain actions
        function inquireDomain(domain, extension) {
            showNotification(`Inquiry sent for ${domain}.${extension}. Our team will contact you shortly.`, 'success');
        }

        function purchaseDomain(domain, extension, price) {
            showNotification(`Initiating secure checkout for ${domain}.${extension} - $${price.toLocaleString()}`, 'success');
            
            // Simulate purchase process
            setTimeout(() => {
                showNotification(`Purchase completed! ${domain}.${extension} is now yours.`, 'success');
            }, 1500);
        }

        function saveDomain(domain, extension) {
            showNotification(`${domain}.${extension} saved to your wishlist.`, 'success');
        }

        function initiateNegotiation(domain, extension) {
            showNotification(`Acquisition request submitted for ${domain}.${extension}. Our brokers will initiate contact.`, 'success');
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            // Focus search on Ctrl/Cmd + K
            if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                e.preventDefault();
                document.getElementById('domainInput').focus();
            }
            
            // Clear search on Escape
            if (e.key === 'Escape') {
                document.getElementById('domainInput').value = '';
            }
        });
    </script>
</body>
</html>
