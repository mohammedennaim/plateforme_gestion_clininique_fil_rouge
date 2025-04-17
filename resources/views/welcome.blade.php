<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediClinic - Healthcare Excellence</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        secondary: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                            300: '#cbd5e1',
                            400: '#94a3b8',
                            500: '#64748b',
                            600: '#475569',
                            700: '#334155',
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        :root {
            --primary: #1e88e5;
            --primary-dark: #1565c0;
            --secondary: #26c6da;
            --light: #f5f7fa;
            --dark: #263238;
            --gray: #757575;
        }

        body {
            font-family: 'Roboto', sans-serif;
            color: var(--dark);
        }

        .bg-primary-custom {
            background-color: var(--primary);
        }

        .btn-primary-custom {
            background-color: var(--primary);
            border-color: var(--primary);
            color: white;
            padding: 10px 25px;
            font-weight: 500;
            border-radius: 5px;
        }

        .btn-primary-custom:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            color: white;
        }

        .btn-outline-primary-custom {
            background-color: transparent;
            border-color: var(--primary);
            color: var(--primary);
            padding: 10px 25px;
            font-weight: 500;
            border-radius: 50px;
        }

        .btn-outline-primary-custom:hover {
            background-color: var(--primary);
            color: white;
        }

        /* Enhanced Hero Section Styling */
        .hero-section {
            background: linear-gradient(135deg, rgba(30, 136, 229, 0.95) 0%, rgba(21, 101, 192, 0.95) 100%),
                url('https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?ixlib=rb-4.0.3') no-repeat center center;
            background-size: cover;
            color: white;
            padding: 60px 0;
            position: relative;
            overflow: hidden;
        }

        .min-vh-75 {
            min-height: 75vh;
        }

        /* Text highlight effect */
        .text-highlight {
            position: relative;
            z-index: 1;
        }

        .text-highlight::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: -5px;
            right: -5px;
            height: 40%;
            background-color: rgba(255, 255, 255, 0.2);
            z-index: -1;
            transform: rotate(-1deg);
        }

        /* Hero badge */
        .hero-badge {
            background-color: rgba(255, 255, 255, 0.2);
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 500;
            font-size: 0.9rem;
        }

        /* Hero stats */
        .hero-stats {
            margin-top: 2rem;
        }

        .hero-stat-item {
            background-color: rgba(255, 255, 255, 0.15);
            padding: 10px 20px;
            border-radius: 10px;
            text-align: center;
            backdrop-filter: blur(5px);
        }

        .hero-stat-number {
            font-weight: 700;
            font-size: 1.8rem;
            line-height: 1;
        }

        .hero-stat-label {
            font-size: 0.8rem;
            opacity: 0.9;
        }

        /* Hero image styling */
        .hero-image-container {
            position: relative;
        }

        .hero-image {
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            transition: all 0.5s ease;
        }

        /* Floating badge */
        .hero-floating-badge {
            position: absolute;
            bottom: -20px;
            left: -20px;
            background-color: white;
            border-radius: 15px;
            padding: 15px;
            color: var(--dark);
            min-width: 220px;
            z-index: 3;
        }

        .hero-badge-icon {
            width: 50px;
            height: 50px;
            background-color: rgba(30, 136, 229, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-size: 1.5rem;
        }

        .hero-badge-title {
            font-weight: 700;
            font-size: 1rem;
            color: var(--dark);
        }

        .hero-badge-subtitle {
            font-size: 0.85rem;
            color: var(--primary);
        }

        /* Animated background elements */
        .hero-bg-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            overflow: hidden;
        }

        .bg-element {
            position: absolute;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.05);
        }

        .bg-element-1 {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -100px;
            animation: float 15s infinite alternate ease-in-out;
        }

        .bg-element-2 {
            width: 200px;
            height: 200px;
            bottom: -50px;
            right: 10%;
            animation: float 12s infinite alternate-reverse ease-in-out;
        }

        .bg-element-3 {
            width: 150px;
            height: 150px;
            top: 40%;
            right: -50px;
            animation: float 10s infinite alternate ease-in-out;
        }

        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
            }

            100% {
                transform: translateY(30px) rotate(10deg);
            }
        }

        /* Add animations - include animate.css or use these basic ones */
        .animate__animated {
            animation-duration: 1s;
        }

        .animate__fadeInUp {
            animation-name: fadeInUp;
        }

        .animate__fadeInRight {
            animation-name: fadeInRight;
        }

        .animate__delay-1s {
            animation-delay: 0.3s;
        }

        .animate__delay-2s {
            animation-delay: 0.6s;
        }

        .animate__delay-3s {
            animation-delay: 0.9s;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 40px, 0);
            }

            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translate3d(40px, 0, 0);
            }

            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        .feature-box {
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
            height: 100%;
            background-color: white;
        }

        .feature-box:hover {
            transform: translateY(-10px);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: rgba(30, 136, 229, 0.1);
            color: var(--primary);
            font-size: 28px;
            margin-bottom: 20px;
        }

        .service-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            height: 100%;
            transition: transform 0.3s ease;
        }

        .service-card:hover {
            transform: translateY(-5px);
        }

        .service-img {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .testimonial-section {
            background-color: #f5f7fa;
        }

        .testimonial-card {
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            background-color: white;
            position: relative;
            margin-top: 30px;
        }

        .testimonial-img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            position: absolute;
            top: -30px;
            left: 25px;
            border: 4px solid white;
        }

        .cta-section {
            background: linear-gradient(135deg, #26c6da 0%, #00acc1 100%);
            color: white;
        }

        .footer {
            background-color: #263238;
            color: #b0bec5;
            padding: 60px 0 30px;
        }

        .footer-heading {
            color: white;
            margin-bottom: 20px;
        }

        .footer-link {
            color: #b0bec5;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            transition: all 0.2s;
        }

        .footer-link:hover {
            color: white;
            transform: translateX(5px);
        }

        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            margin-right: 10px;
            transition: all 0.3s;
        }

        .social-icon:hover {
            background-color: var(--primary);
            transform: translateY(-3px);
        }

        .stats-counter {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .doctor-card {
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            border-radius: 12px;
            overflow: hidden;
            background-color: #fff;
            height: 100%;
            position: relative;
        }

        .doctor-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1), 0 5px 15px rgba(0, 0, 0, 0.05) !important;
        }

        .doctor-img {
            height: 280px;
            object-fit: cover;
            object-position: center 15%;
            width: 100%;
            transition: transform 0.5s ease;
        }

        .doctor-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0) 0%, rgba(19, 92, 174, 0.85) 75%);
            padding: 2rem 1rem 1.5rem;
            opacity: 0;
            transition: opacity 0.4s ease, transform 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: flex-end;
            height: 100%;
            transform: translateY(10px);
        }

        .doctor-card:hover .doctor-overlay {
            opacity: 1;
            transform: translateY(0);
        }

        .doctor-overlay .btn {
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 0.8rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            border: none;
        }

        .doctor-overlay .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            background-color: #fff;
            color: #135cae;
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            font-weight: 700;
            font-size: 1.2rem;
            margin-bottom: 0.25rem;
            color: #2c3e50;
        }

        .text-primary {
            color: #135cae !important;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .text-primary i {
            color: #135cae;
            opacity: 0.85;
        }

        .small.text-muted {
            line-height: 1.5;
            margin: 0.75rem 0;
            font-size: 0.85rem;
            color: #6c757d !important;
        }

        .doctor-details {
            background-color: #f8fafc;
            padding: 0.75rem;
            border-radius: 8px;
            margin: 1rem 0;
            border: 1px solid #eef2f7;
        }

        .doctor-detail {
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            font-size: 0.85rem;
            color: #495057;
            padding: 0.25rem 0;
        }

        .doctor-detail:last-child {
            margin-bottom: 0;
        }

        .doctor-detail i {
            width: 1.5rem;
            color: #135cae;
            margin-right: 0.5rem;
            text-align: center;
            font-size: 0.9rem;
        }

        .doctor-detail.rating {
            color: #ff9800;
        }

        .doctor-social {
            margin-top: 1rem;
        }

        .doctor-social .social-icon {
            width: 38px;
            height: 38px;
            background-color: #f5f7fa;
            color: #135cae;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            text-decoration: none;
            border: 1px solid rgba(19, 92, 174, 0.1);
        }

        .doctor-social .social-icon:hover {
            background-color: #135cae;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 10px rgba(19, 92, 174, 0.2);
        }

        .doctor-social .social-icon i {
            font-size: 0.9rem;
        }

        .specialty-tag {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            background-color: rgba(19, 92, 174, 0.1);
            color: #135cae;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.8rem;
            margin-bottom: 0.5rem;
        }

        .specialty-tag i {
            margin-right: 0.35rem;
        }

        /* Availability indicator */
        .availability {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 50px;
            padding: 0.35rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            z-index: 2;
        }

        .availability.available {
            color: #2ecc71;
        }

        .availability.available:before {
            content: "•";
            margin-right: 0.35rem;
            font-size: 1rem;
            vertical-align: middle;
        }

        /* View all doctors button styling */
        .btn-primary-custom {
            background-color: #135cae;
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(19, 92, 174, 0.2);
        }

        .btn-primary-custom:hover {
            background-color: #0d4a8f;
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(19, 92, 174, 0.3);
        }

        /* Facility Cards Styling */
.facility-card {
    transition: all 0.3s ease;
    border-radius: 12px;
    overflow: hidden;
}

.facility-card:hover {
    transform: translateY(-10px);
}

.facility-img {
    height: 220px;
    object-fit: cover;
    width: 100%;
}

.facility-overlay {
    position: absolute;
    top: 15px;
    right: 15px;
    z-index: 2;
}

.facility-icon {
    width: 50px;
    height: 50px;
    background-color: rgba(255, 255, 255, 0.9);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 1.25rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.facility-card:hover .facility-icon {
    background-color: var(--primary);
    color: white;
    transform: rotateY(180deg);
}

.badge.bg-primary-custom {
    background-color: rgba(30, 136, 229, 0.1);
    color: var(--primary);
}
    </style>
</head>

<body>
    <!-- Navigation -->
    <header class="bg-white shadow-sm py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center">
                <i class="fas fa-hospital text-primary-600 text-2xl mr-2"></i>
                <span class="text-xl font-semibold text-primary-700">MediClinic</span>
            </div>
            <nav class="hidden md:flex space-x-6">
                <a href="/" class="text-secondary-600 hover:text-primary-600 transition-colors">Accueil</a>
                <a href="#" class="text-secondary-600 hover:text-primary-600 transition-colors">Services</a>
                <a href="#" class="text-secondary-600 hover:text-primary-600 transition-colors">Médecins</a>
                <a href="{{ Route('patient.reserver.store') }}" class="text-primary-600 font-medium">Rendez-vous</a>
                <a href="#" class="text-secondary-600 hover:text-primary-600 transition-colors">Contact</a>
            </nav>
            
            <!-- User Authentication Section -->
            <div class="flex items-center space-x-4">

                
                <!-- Bouton de connexion/profil -->
                <div id="auth-buttons" class="flex items-center">
                    <a href="{{ Route('login') }}" id="login-button" class="text-sm font-medium text-primary-600 hover:text-primary-800">Se connecter</a>
                    <span class="mx-2 text-secondary-300">|</span>
                    <a href="{{ Route('logout') }}" class="text-sm font-medium text-primary-600 hover:text-primary-800">S'inscrire</a>
                </div>
                
                <!-- Profil utilisateur (caché par défaut) -->
                <div id="user-profile" class="hidden items-center">
                    <div class="relative">
                        <button id="profile-dropdown-button" class="flex items-center space-x-2 focus:outline-none">
                            <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <span class="text-sm font-medium text-secondary-700">Marie Dupont</span>
                            <i class="fas fa-chevron-down text-secondary-400 text-xs"></i>
                        </button>
                        
                        <!-- Dropdown menu (caché par défaut) -->
                        <div id="profile-dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-10 hidden">
                            <a href="#" class="block px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-50">
                                <i class="fas fa-user mr-2 text-secondary-400"></i>Mon profil
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-50">
                                <i class="fas fa-calendar-check mr-2 text-secondary-400"></i>Mes rendez-vous
                            </a>
                            <a href="#" class="block px-4 py-2 text-sm text-secondary-700 hover:bg-secondary-50">
                                <i class="fas fa-cog mr-2 text-secondary-400"></i>Paramètres
                            </a>
                            <div class="border-t border-secondary-200 my-1"></div>
                            <a href="#" id="logout-button" class="block px-4 py-2 text-sm text-red-600 hover:bg-secondary-50">
                                <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <button class="md:hidden text-secondary-600 focus:outline-none">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section position-relative">
        <!-- Animated Background Elements -->
        <div class="hero-bg-elements">
            <div class="bg-element bg-element-1"></div>
            <div class="bg-element bg-element-2"></div>
            <div class="bg-element bg-element-3"></div>
        </div>

        <div class="container position-relative">
            <div class="row align-items-center min-vh-75">
                <div class="col-lg-7 py-5">
                    <div class="hero-badge mb-3 d-inline-block">
                        <i class="fas fa-award me-2"></i> Trusted by 10,000+ Patients
                    </div>
                    <h1 class="display-4 fw-bold mb-4 animate__animated animate__fadeInUp">Your Health Is Our <span
                            class="text-highlight">Top Priority</span></h1>
                    <p class="lead mb-4 animate__animated animate__fadeInUp animate__delay-1s">Experience world-class
                        healthcare with state-of-the-art facilities and compassionate medical professionals dedicated to
                        providing personalized care for you and your family.</p>

                    <div class="d-flex flex-wrap gap-3 mb-4 animate__animated animate__fadeInUp animate__delay-2s">
                        <a href="#appointment" class="btn btn-light btn-lg shadow-sm">
                            <i class="fas fa-calendar-check me-2"></i> Book Appointment
                        </a>
                        <a href="#services" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-heartbeat me-2"></i> Our Services
                        </a>
                    </div>

                    <!-- Quick Stats -->
                    <div
                        class="row hero-stats g-3 mt-2 d-none d-md-flex animate__animated animate__fadeInUp animate__delay-3s">
                        <div class="col-auto">
                            <div class="hero-stat-item">
                                <div class="hero-stat-number">15+</div>
                                <div class="hero-stat-label">Years Experience</div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="hero-stat-item">
                                <div class="hero-stat-number">50+</div>
                                <div class="hero-stat-label">Specialists</div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="hero-stat-item">
                                <div class="hero-stat-number">24/7</div>
                                <div class="hero-stat-label">Support</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 position-relative d-none d-lg-block">
                    <div class="hero-image-container animate__animated animate__fadeInRight">
                        <img src="https://images.unsplash.com/photo-1638202993928-7267aad84c31?ixlib=rb-4.0.3"
                            alt="Medical Team" class="img-fluid rounded-4 shadow-lg hero-image">
                        <div class="hero-floating-badge shadow-lg">
                            <div class="d-flex align-items-center">
                                <div class="hero-badge-icon">
                                    <i class="fas fa-stethoscope"></i>
                                </div>
                                <div class="ms-3">
                                    <div class="hero-badge-title">Immediate Care</div>
                                    <div class="hero-badge-subtitle">Available Now</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <h4>Expert Doctors</h4>
                        <p>Our team consists of highly qualified medical professionals with years of experience in their
                            respective fields.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-hospital"></i>
                        </div>
                        <h4>Modern Facilities</h4>
                        <p>State-of-the-art equipment and facilities to provide the best possible care for all patients.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <div class="feature-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <h4>24/7 Services</h4>
                        <p>Round-the-clock medical services to ensure you receive care whenever you need it.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="py-5 bg-light" id="about">
        <div class="container">
            <div class="row align-items-center gap-5">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <img src="https://images.pexels.com/photos/3845806/pexels-photo-3845806.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2"
                        alt="Clinic Building" class="img-fluid rounded-4 shadow">
                </div>
                <div class="col-lg-5">
                    <h2 class="mb-4">About MediClinic</h2>
                    <p class="lead">Providing exceptional healthcare services for over 15 years.</p>
                    <p>MediClinic was founded with a mission to deliver accessible, high-quality healthcare to our
                        community. Our dedicated team of healthcare professionals strives to provide personalized care
                        that meets the unique needs of each patient.</p>
                    <div class="row mt-4">
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-check-circle text-primary me-2"></i>
                                <span>Qualified Doctors</span>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-check-circle text-primary me-2"></i>
                                <span>Emergency Services</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-check-circle text-primary me-2"></i>
                                <span>Online Appointments</span>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                <i class="fas fa-check-circle text-primary me-2"></i>
                                <span>Medical Counseling</span>
                            </div>
                        </div>
                    </div>
                    <a href="#contact" class="btn btn-primary-custom mt-3">Learn More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="py-5" id="services">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Our Medical Services</h2>
                <p class="text-muted">Comprehensive healthcare solutions for you and your family</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="service-card">
                        <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?ixlib=rb-4.0.3"
                            class="service-img" alt="Cardiology">
                        <div class="p-4">
                            <h4>Cardiology</h4>
                            <p>Comprehensive heart care services including diagnosis, treatment, and preventive care.
                            </p>
                            <a href="#" class="btn btn-sm btn-outline-primary-custom">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <img src="https://images.pexels.com/photos/4226264/pexels-photo-4226264.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=2"
                            class="service-img" alt="Neurology">
                        <div class="p-4">
                            <h4>Neurology</h4>
                            <p>Expert care for conditions affecting the brain, spinal cord, and nervous system.</p>
                            <a href="#" class="btn btn-sm btn-outline-primary-custom">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <img src="https://images.unsplash.com/photo-1588776814546-1ffcf47267a5?ixlib=rb-4.0.3"
                            class="service-img" alt="Pediatrics">
                        <div class="p-4">
                            <h4>Pediatrics</h4>
                            <p>Specialized healthcare for infants, children, and adolescents.</p>
                            <a href="#" class="btn btn-sm btn-outline-primary-custom">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <a href="#" class="btn btn-primary-custom">View All Services</a>
            </div>
        </div>
    </section>

    <!-- Doctors Section -->
    <section class="py-5 bg-light" id="doctors">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Meet Our Specialists</h2>
                <p class="text-muted">Experienced healthcare professionals committed to your wellbeing</p>
            </div>
            <div class="row g-4">
                <!-- Doctor 1 -->
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 doctor-card">
                        <div class="position-relative">
                            <div class="availability available">Available Today</div>
                            <img src="https://images.unsplash.com/photo-1612349317150-e413f6a5b16d?ixlib=rb-4.0.3"
                                class="card-img-top doctor-img" alt="Dr. Sarah Johnson">
                            <div class="doctor-overlay">
                                <a href="#appointment" class="btn btn-light btn-sm">Book Appointment</a>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <div class="specialty-tag"><i class="fas fa-stethoscope"></i>Cardiologist</div>
                            <h5 class="card-title mb-1">Dr. Sarah Johnson</h5>
                            <p class="text-muted mb-2">15+ years of experience</p>
                            <div class="small text-muted mb-3">Specialized in treating complex heart conditions and
                                cardiovascular diseases</div>
                            <div class="doctor-details">
                                <div class="doctor-detail"><i class="fas fa-graduation-cap"></i>Harvard Medical School
                                </div>
                                <div class="doctor-detail"><i class="fas fa-certificate"></i>Board Certified</div>
                                <div class="doctor-detail rating"><i class="fas fa-star"></i>4.9 (120+ reviews)</div>
                            </div>
                            <div class="d-flex justify-content-center gap-2 doctor-social">
                                <a href="#" class="social-icon" aria-label="Facebook"><i
                                        class="fab fa-facebook-f"></i></a>
                                <a href="#" class="social-icon" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="social-icon" aria-label="LinkedIn"><i
                                        class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Doctor 2 -->
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 doctor-card">
                        <div class="position-relative">
                            <div class="availability available">Available Today</div>
                            <img src="https://images.unsplash.com/photo-1622253692010-333f2da6031d?ixlib=rb-4.0.3"
                                class="card-img-top doctor-img" alt="Doctor">
                            <div class="doctor-overlay">
                                <a href="#appointment" class="btn btn-light btn-sm">Book Appointment</a>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <div class="specialty-tag"><i class="fas fa-brain me-2"></i>Neurologist</div>
                            <h5 class="card-title mb-1">Dr. Michael Chen</h5>
                            <p class="text-muted mb-2">15+ years of experience</p>
                            <div class="small text-muted mb-3">Specializes in brain and nervous system disorders</div>
                            <div class="doctor-details">
                                <div class="doctor-detail"><i class="fas fa-graduation-cap me-2"></i> Johns Hopkins
                                </div>
                                <div class="doctor-detail"><i class="fas fa-certificate me-2"></i> Board Certified</div>
                                <div class="doctor-detail rating"><i class="fas fa-star me-2"></i> 4.8 (95+ reviews)
                                </div>
                            </div>
                            <div class="d-flex justify-content-center gap-2 doctor-social">
                                <a href="#" class="social-icon" aria-label="Facebook"><i
                                        class="fab fa-facebook-f"></i></a>
                                <a href="#" class="social-icon" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="social-icon" aria-label="LinkedIn"><i
                                        class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Doctor 3 -->
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 doctor-card">
                        <div class="position-relative">
                            <div class="availability available">Available Tomorrow</div>
                            <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?ixlib=rb-4.0.3"
                                class="card-img-top doctor-img" alt="Dr. Amanda Park">
                            <div class="doctor-overlay">
                                <a href="#appointment" class="btn btn-light btn-sm">Book Appointment</a>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <div class="specialty-tag"><i class="fas fa-microscope me-2"></i>Dermatologist</div>
                            <h5 class="card-title mb-1">Dr. Amanda Park</h5>
                            <p class="text-muted mb-2">12+ years of experience</p>
                            <div class="small text-muted mb-3">Specialized in cosmetic dermatology and skin cancer
                                treatments</div>
                            <div class="doctor-details">
                                <div class="doctor-detail"><i class="fas fa-graduation-cap me-2"></i>Columbia University
                                </div>
                                <div class="doctor-detail"><i class="fas fa-certificate me-2"></i>Board Certified</div>
                                <div class="doctor-detail rating"><i class="fas fa-star me-2"></i>4.9 (135+ reviews)
                                </div>
                            </div>
                            <div class="d-flex justify-content-center gap-2 doctor-social">
                                <a href="#" class="social-icon" aria-label="Facebook"><i
                                        class="fab fa-facebook-f"></i></a>
                                <a href="#" class="social-icon" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="social-icon" aria-label="LinkedIn"><i
                                        class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Doctor 4 -->
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 doctor-card">
                        <div class="position-relative">
                            <img src="https://images.unsplash.com/photo-1582750433449-648ed127bb54?ixlib=rb-4.0.3"
                                class="card-img-top doctor-img" alt="Dr. Robert Williams">
                            <div class="doctor-overlay">
                                <a href="#appointment" class="btn btn-light btn-sm">Book Appointment</a>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <div class="specialty-tag"><i class="fas fa-heartbeat me-2"></i>Oncologist</div>
                            <h5 class="card-title mb-1">Dr. Robert Williams</h5>
                            <p class="text-muted mb-2">18+ years of experience</p>
                            <div class="small text-muted mb-3">Expert in innovative cancer treatments and personalized
                                cancer care</div>
                            <div class="doctor-details">
                                <div class="doctor-detail"><i class="fas fa-graduation-cap me-2"></i>Duke University
                                </div>
                                <div class="doctor-detail"><i class="fas fa-certificate me-2"></i>Double Board Certified
                                </div>
                                <div class="doctor-detail rating"><i class="fas fa-star me-2"></i>5.0 (178+ reviews)
                                </div>
                            </div>
                            <div class="d-flex justify-content-center gap-2 doctor-social">
                                <a href="#" class="social-icon" aria-label="Facebook"><i
                                        class="fab fa-facebook-f"></i></a>
                                <a href="#" class="social-icon" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="social-icon" aria-label="LinkedIn"><i
                                        class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <a href="#" class="btn btn-primary-custom">View All Doctors</a>
            </div>
        </div>
    </section>

<!-- Advanced Healthcare Technology Section -->
<section class="py-5 bg-light" id="features">
    <div class="container">
        <div class="text-center mb-5">
            <span class="badge bg-primary-custom px-3 py-2 rounded-pill mb-3">Medical Innovation</span>
            <h2 class="fw-bold">Advanced Healthcare Solutions</h2>
            <p class="text-muted col-lg-8 mx-auto">Our state-of-the-art technologies and specialized medical equipment enable precise diagnosis and effective treatment for optimal patient outcomes.</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="border-0 rounded-4 overflow-hidden position-relative">
                    <img src="https://images.unsplash.com/photo-1612886649688-ef2912f17921?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="img-fluid w-100 rounded-4" alt="Medical Technology" style="height: 500px; object-fit: cover;">
                    <div class="position-absolute" style="top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(180deg, rgba(0,0,0,0) 50%, rgba(0,0,0,0.7) 100%);"></div>
                    <div class="position-absolute bottom-0 p-4 text-white">
                        <h3 class="fw-bold">Diagnostic Excellence</h3>
                        <p class="mb-0">Advanced imaging and laboratory services for accurate diagnosis</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100 feature-card">
                            <div class="card-body p-4">
                                <div class="feature-icon mb-3">
                                    <i class="fas fa-xray"></i>
                                </div>
                                <h5 class="fw-bold">3D Imaging</h5>
                                <p class="text-muted mb-0">High-precision imaging technology for detailed visualization and diagnosis</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100 feature-card">
                            <div class="card-body p-4">
                                <div class="feature-icon mb-3">
                                    <i class="fas fa-microscope"></i>
                                </div>
                                <h5 class="fw-bold">Laboratory Services</h5>
                                <p class="text-muted mb-0">Comprehensive testing with rapid results for informed treatment decisions</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100 feature-card">
                            <div class="card-body p-4">
                                <div class="feature-icon mb-3">
                                    <i class="fas fa-heartbeat"></i>
                                </div>
                                <h5 class="fw-bold">Cardiac Monitoring</h5>
                                <p class="text-muted mb-0">Real-time heart monitoring with AI-assisted analysis</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm h-100 feature-card">
                            <div class="card-body p-4">
                                <div class="feature-icon mb-3">
                                    <i class="fas fa-brain"></i>
                                </div>
                                <h5 class="fw-bold">Neurological Assessment</h5>
                                <p class="text-muted mb-0">Advanced tools for comprehensive brain and nervous system evaluation</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mt-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="row g-0 align-items-center p-5">
                        <div class="col-lg-6">
                            <div class="p-3">
                                <h3 class="fw-bold mb-4">Patient-Centered Technology</h3>
                                <p class="mb-4">Our investment in cutting-edge medical technology is guided by one principle: improving patient outcomes and experiences.</p>
                                
                                <div class="row">
                                    <div class="col-6">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="feature-icon bg-white me-3" style="width: 50px; height: 50px;">
                                                <i class="fas fa-robot text-primary"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold mb-0">Robotic Surgery</h5>
                                                <p class="small text-muted mb-0">Precision surgery with minimal recovery time</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-6">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="feature-icon bg-white me-3" style="width: 50px; height: 50px;">
                                                <i class="fas fa-mobile-alt text-primary"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold mb-0">Digital Care</h5>
                                                <p class="small text-muted mb-0">Remote monitoring and telemedicine options</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-6">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="feature-icon bg-white me-3" style="width: 50px; height: 50px;">
                                                <i class="fas fa-database text-primary"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold mb-0">Health Records</h5>
                                                <p class="small text-muted mb-0">Secure digital health information access</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-6">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="feature-icon bg-white me-3" style="width: 50px; height: 50px;">
                                                <i class="fas fa-chart-line text-primary"></i>
                                            </div>
                                            <div>
                                                <h5 class="fw-bold mb-0">Analytics</h5>
                                                <p class="small text-muted mb-0">Data-driven personalized treatment plans</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <a href="#technology" class="btn btn-primary-custom mt-4">Discover Our Technology</a>
                            </div>
                        </div>
                        <div class="col-lg-6 p-0">
                            <div class="ratio ratio-16x9 h-100" style="min-height: 400px;">
                            <iframe class="rounded-4" width="1519" height="566" src="https://www.youtube.com/embed/P5PqnkN9bLU" title="تصوير عيادة دازل لطب الأسنان - DAZZLE" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-5 g-4">
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <span class="display-4 text-primary fw-bold me-2">98%</span>
                            <p class="mb-0 fw-bold">Diagnostic Accuracy</p>
                        </div>
                        <p class="text-muted">Our advanced diagnostic equipment achieves exceptional accuracy rates, ensuring precise treatment planning.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <span class="display-4 text-primary fw-bold me-2">45%</span>
                            <p class="mb-0 fw-bold">Faster Recovery</p>
                        </div>
                        <p class="text-muted">Patients treated with our minimally invasive technologies experience significantly quicker recovery times.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-4">
                            <span class="display-4 text-primary fw-bold me-2">24/7</span>
                            <p class="mb-0 fw-bold">Technology Support</p>
                        </div>
                        <p class="text-muted">Our technical teams ensure all medical equipment operates flawlessly around the clock for uninterrupted care.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- Appointment Section -->
    <section class="py-5 bg-primary-custom text-white" id="appointment">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <h2 class="fw-bold mb-4">Book Your Appointment Today</h2>
                    <p class="lead mb-4">Schedule a visit with our healthcare professionals quickly and easily.</p>
                    <ul class="list-unstyled mb-4">
                        <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Choose your preferred doctor</li>
                        <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Select a convenient date and time</li>
                        <li class="mb-2"><i class="fas fa-check-circle me-2"></i> Receive confirmation instantly</li>
                        <li><i class="fas fa-check-circle me-2"></i> Get reminders before your appointment</li>
                    </ul>
                    <p>Need immediate assistance? Call us at <strong>(123) 456-7890</strong></p>
                </div>
                <div class="col-lg-6">
                    <div class="card border-0 rounded-4 shadow">
                        <div class="card-body p-4">
                            <h4 class="text-center text-dark mb-4">Request an Appointment</h4>
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Full Name">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="email" class="form-control" placeholder="Email Address">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="tel" class="form-control" placeholder="Phone Number">
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-select">
                                            <option selected disabled>Select Department</option>
                                            <option>Cardiology</option>
                                            <option>Neurology</option>
                                            <option>Pediatrics</option>
                                            <option>Orthopedics</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="date" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <select class="form-select">
                                            <option selected disabled>Preferred Time</option>
                                            <option>Morning</option>
                                            <option>Afternoon</option>
                                            <option>Evening</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <textarea class="form-control" rows="3"
                                            placeholder="Brief description of your concern"></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary-custom w-100">Book
                                            Appointment</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-5" id="contact">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Get In Touch</h2>
                <p class="text-muted">We're here to help and answer any questions you might have</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <div class="feature-icon mx-auto">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <h4>Visit Us</h4>
                            </div>
                            <p class="text-center">123 Medical Center Blvd<br>Suite 500<br>Health City, CA 90210</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <div class="feature-icon mx-auto">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <h4>Call Us</h4>
                            </div>
                            <p class="text-center">Main: (123) 456-7890<br>Emergency: (123) 456-7777<br>Fax: (123)
                                456-7891</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="text-center mb-4">
                                <div class="feature-icon mx-auto">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <h4>Working Hours</h4>
                            </div>
                            <p class="text-center">Monday-Friday: 8:00 AM - 9:00 PM<br>Saturday: 9:00 AM - 5:00
                                PM<br>Sunday: 10:00 AM - 2:00 PM</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <iframe class="w-100 rounded-4 shadow-sm" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3374.3378787825227!2d-8.52476942466352!3d32.248990210783916!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xdaee2d4d7d4c337%3A0x3e72d780e0ecf09d!2sH%C3%B4pital%20Multidisciplinaire%20Youssoufia!5e0!3m2!1sfr!2sma!4v1741945956212!5m2!1sfr!2sma" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="mb-4">
                        <h5 class="footer-heading">About MediClinic</h5>
                        <p>MediClinic is a premier healthcare provider committed to delivering exceptional medical
                            services with compassion and expertise. Our state-of-the-art facilities and dedicated team
                            ensure the highest quality care for all patients.</p>
                    </div>
                    <div class="d-flex mb-4">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5 class="footer-heading">Quick Links</h5>
                    <a href="#" class="footer-link">Home</a>
                    <a href="#about" class="footer-link">About Us</a>
                    <a href="#services" class="footer-link">Services</a>
                    <a href="#doctors" class="footer-link">Doctors</a>
                    <a href="#contact" class="footer-link">Contact</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-heading">Our Services</h5>
                    <a href="#" class="footer-link">Cardiology</a>
                    <a href="#" class="footer-link">Neurology</a>
                    <a href="#" class="footer-link">Pediatrics</a>
                    <a href="#" class="footer-link">Orthopedics</a>
                    <a href="#" class="footer-link">Dermatology</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-heading">Newsletter</h5>
                    <p>Subscribe to our newsletter for health tips and updates.</p>
                    <form class="mt-3">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Your Email" aria-label="Your Email">
                            <button class="btn btn-primary" type="submit">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
            <hr class="mt-4 mb-4" style="border-color: rgba(255,255,255,0.1);">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; 2025 MediClinic. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0">
                        <a href="#" class="text-decoration-none text-muted me-2">Privacy Policy</a>
                        <span class="text-muted">|</span>
                        <a href="#" class="text-decoration-none text-muted ms-2">Terms of Service</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <a href="#" class="btn btn-primary-custom position-fixed bottom-0 end-0 m-4 rounded-circle" style="width: 45px; heigh
        t: 45px; display: flex; align-items: center; justify-content: center; z-index: 1000;">
        <i class="fas fa-arrow-up"></i>
    </a>

    <div class="modal fade" id="statsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary-custom text-white">
                    <h5 class="modal-title">Our Achievements</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row text-center g-4">
                        <div class="col-6">
                            <h2 class="stats-counter">15+</h2>
                            <p>Years of Experience</p>
                        </div>
                        <div class="col-6">
                            <h2 class="stats-counter">50+</h2>
                            <p>Medical Specialists</p>
                        </div>
                        <div class="col-6">
                            <h2 class="stats-counter">10k+</h2>
                            <p>Happy Patients</p>
                        </div>
                        <div class="col-6">
                            <h2 class="stats-counter">15+</h2>
                            <p>Medical Awards</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="#about" class="btn btn-primary-custom" data-bs-dismiss="modal">Learn More</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const backToTopBtn = document.querySelector('.btn-primary-custom.position-fixed');

            window.addEventListener('scroll', function () {
                if (window.pageYOffset > 300) {
                    backToTopBtn.style.display = 'flex';
                } else {
                    backToTopBtn.style.display = 'none';
                }
            });

            backToTopBtn.style.display = 'none';
            backToTopBtn.addEventListener('click', function (e) {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });
    </script>
</body>

</html>