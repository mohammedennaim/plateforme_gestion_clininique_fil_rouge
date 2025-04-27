<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Admin | MediClinic</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
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
                            950: '#082f49'
                        },
                        secondary: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            500: '#64748b',
                            700: '#334155',
                            900: '#0f172a'
                        },
                        success: {
                            50: '#ecfdf5',
                            500: '#10b981',
                            600: '#059669'
                        },
                        danger: {
                            50: '#fef2f2',
                            500: '#ef4444',
                            600: '#dc2626'
                        },
                        warning: {
                            50: '#fffbeb',
                            500: '#f59e0b',
                            600: '#d97706'
                        },
                        info: {
                            50: '#eff6ff',
                            500: '#3b82f6',
                            600: '#2563eb'
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    },
                    boxShadow: {
                        card: '0 4px 25px 0 rgba(0, 0, 0, 0.1)',
                        nav: '0 2px 10px 0 rgba(0, 0, 0, 0.05)',
                        'card-hover': '0 10px 40px 0 rgba(0, 0, 0, 0.15)'
                    },
                    borderRadius: {
                        'xl': '1rem',
                        '2xl': '1.5rem'
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
        }

        .badge {
            padding: 0.3em 0.8em;
            font-size: 0.75em;
            font-weight: 600;
            border-radius: 9999px;
            letter-spacing: 0.025em;
            text-transform: uppercase;
        }

        .card {
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-color: rgba(14, 165, 233, 0.2);
        }

        .sidebar {
            transition: all 0.3s ease;
        }

        .sidebar-item {
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .sidebar-item:hover {
            background-color: rgba(14, 165, 233, 0.1);
        }

        .sidebar-item.active {
            background-color: rgba(14, 165, 233, 0.15);
            border-left: 3px solid #0ea5e9;
        }

        .sidebar-item.active::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 3px;
            height: 100%;
            background-color: #0ea5e9;
        }

        .table-row {
            transition: all 0.2s ease;
        }

        .table-row:hover {
            background-color: #f1f5f9;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            position: absolute;
            right: 0;
            top: 100%;
            z-index: 10;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.2s ease;
        }

        .dropdown.active .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease forwards;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }

        /* Skeleton loading */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.5s infinite;
        }

        @keyframes skeleton-loading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Section transitions */
        .section {
            display: none;
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .section.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        /* Card styles */
        .doctor-card,
        .patient-card,
        .appointment-card {
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .doctor-card:hover,
        .patient-card:hover,
        .appointment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        }

        .doctor-card .card-header,
        .patient-card .card-header,
        .appointment-card .card-header {
            position: relative;
            overflow: hidden;
        }

        .doctor-card .card-header::after,
        .patient-card .card-header::after,
        .appointment-card .card-header::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right, rgba(14, 165, 233, 0.1), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .doctor-card:hover .card-header::after,
        .patient-card:hover .card-header::after,
        .appointment-card:hover .card-header::after {
            opacity: 1;
        }

        .card-actions a,
        .card-actions button {
            transition: all 0.2s ease;
        }

        .card-actions a:hover,
        .card-actions button:hover {
            transform: translateY(-2px);
        }

        /* Dark mode styles */
        .dark body {
            background-color: #0f172a;
            color: #f1f5f9;
        }

        .dark .card {
            background-color: #1e293b;
            border-color: #334155;
        }

        .dark .card:hover {
            border-color: rgba(14, 165, 233, 0.4);
        }

        .dark .sidebar {
            background-color: #1e293b;
            border-color: #334155;
        }

        .dark .sidebar-item:hover {
            background-color: rgba(14, 165, 233, 0.1);
        }

        .dark .sidebar-item.active {
            background-color: rgba(14, 165, 233, 0.15);
        }

        .dark .table-row:hover {
            background-color: #1e293b;
        }

        .dark .dropdown-menu {
            background-color: #1e293b;
            border-color: #334155;
        }

        .dark .skeleton {
            background: linear-gradient(90deg, #1e293b 25%, #334155 50%, #1e293b 75%);
            background-size: 200% 100%;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col md:flex-row">
        <!-- Sidebar -->
        <aside
            class="sidebar bg-white border-r border-gray-200 w-full md:w-64 md:fixed md:h-screen overflow-y-auto z-10">
            <!-- Logo -->
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center">
                    <div
                        class="h-8 w-8 rounded-lg bg-primary-600 flex items-center justify-center text-white font-bold text-lg mr-2">
                        M</div>
                    <h1 class="text-xl font-bold text-gray-800">MediClinic</h1>
                </div>
                <button id="mobile-menu-toggle" class="md:hidden text-gray-500 hover:text-gray-700">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="p-4" id="sidebar-nav">
                <div class="mb-6">
                    <h2 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Menu principal</h2>
                    <ul class="space-y-1">
                        <li>
                            <a href="#dashboard"
                                class="sidebar-item active flex items-center px-3 py-2 text-sm font-medium rounded-lg text-primary-700 pl-3"
                                data-section="dashboard-section">
                                <i class="fas fa-tachometer-alt w-5 h-5 mr-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="#doctors"
                                class="sidebar-item flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:text-primary-700 pl-3"
                                data-section="doctors-section">
                                <i class="fas fa-user-md w-5 h-5 mr-2"></i>
                                Médecins
                            </a>
                        </li>
                        <li>
                            <a href="#patients"
                                class="sidebar-item flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:text-primary-700 pl-3"
                                data-section="patients-section">
                                <i class="fas fa-users w-5 h-5 mr-2"></i>
                                Patients
                            </a>
                        </li>
                        <li>
                            <a href="#appointments"
                                class="sidebar-item flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:text-primary-700 pl-3"
                                data-section="appointments-section">
                                <i class="fas fa-calendar-check w-5 h-5 mr-2"></i>
                                Rendez-vous
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="mb-6">
                    <h2 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Administration</h2>
                    <ul class="space-y-1">
                        <li>
                            <a href="#settings"
                                class="sidebar-item flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:text-primary-700 pl-3"
                                data-section="settings-section">
                                <i class="fas fa-cog w-5 h-5 mr-2"></i>
                                Paramètres
                            </a>
                        </li>
                        <li>
                            <a href="#users"
                                class="sidebar-item flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:text-primary-700 pl-3"
                                data-section="users-section">
                                <i class="fas fa-user-cog w-5 h-5 mr-2"></i>
                                Utilisateurs
                            </a>
                        </li>
                        <li>
                            <a href="#logs"
                                class="sidebar-item flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:text-primary-700 pl-3"
                                data-section="logs-section">
                                <i class="fas fa-history w-5 h-5 mr-2"></i>
                                Logs d'activité
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Compte</h2>
                    <ul class="space-y-1">
                        <li>
                            <a href="#profile"
                                class="sidebar-item flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:text-primary-700 pl-3"
                                data-section="profile-section">
                                <i class="fas fa-user-circle w-5 h-5 mr-2"></i>
                                Mon profil
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}"
                                class="sidebar-item flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:text-primary-700 pl-3">
                                <i class="fas fa-sign-out-alt w-5 h-5 mr-2"></i>
                                Déconnexion
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 md:ml-64 min-h-screen">
            <!-- Header -->
            <header class="bg-white shadow-nav sticky top-0 z-10">
                <div class="px-4 py-3 flex items-center justify-between">
                    <div class="flex items-center">
                        <button id="sidebar-toggle" class="hidden md:block text-gray-500 hover:text-gray-700 mr-4">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h1 class="text-xl font-semibold text-gray-800" id="section-title">Dashboard Admin</h1>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Theme Toggle -->
                        <button id="theme-toggle"
                            class="text-gray-500 hover:text-gray-700 bg-gray-100 p-2 rounded-full">
                            <i class="fas fa-sun"></i>
                        </button>

                        <!-- Notifications -->
                        <div class="dropdown">
                            <button
                                class="dropdown-toggle text-gray-500 hover:text-gray-700 relative bg-gray-100 p-2 rounded-full">
                                <i class="fas fa-bell"></i>
                                <span
                                    class="absolute -top-1 -right-1 bg-danger-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">3</span>
                            </button>
                            <div class="dropdown-menu mt-2 bg-white rounded-lg shadow-lg border border-gray-200 w-72">
                                <div class="p-3 border-b border-gray-200">
                                    <h3 class="text-sm font-semibold text-gray-700">Notifications</h3>
                                </div>
                                <div class="max-h-60 overflow-y-auto">
                                    <a href="#" class="block p-3 hover:bg-gray-50 border-b border-gray-200">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 bg-primary-100 rounded-full p-2">
                                                <i class="fas fa-user-md text-primary-600"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">Nouveau médecin inscrit</p>
                                                <p class="text-xs text-gray-500">Dr. Martin a créé un compte</p>
                                                <p class="text-xs text-gray-400 mt-1">Il y a 10 minutes</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="block p-3 hover:bg-gray-50 border-b border-gray-200">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 bg-warning-100 rounded-full p-2">
                                                <i class="fas fa-exclamation-triangle text-warning-600"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">Alerte système</p>
                                                <p class="text-xs text-gray-500">Maintenance prévue à 22h</p>
                                                <p class="text-xs text-gray-400 mt-1">Il y a 1 heure</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#" class="block p-3 hover:bg-gray-50">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 bg-success-100 rounded-full p-2">
                                                <i class="fas fa-check-circle text-success-600"></i>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">Mise à jour terminée</p>
                                                <p class="text-xs text-gray-500">Le système a été mis à jour</p>
                                                <p class="text-xs text-gray-400 mt-1">Il y a 3 heures</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2 border-t border-gray-200 text-center">
                                    <a href="#" class="text-xs font-medium text-primary-600 hover:text-primary-800">Voir
                                        toutes les notifications</a>
                                </div>
                            </div>
                        </div>

                        <!-- User Menu -->
                        <div class="dropdown">
                            <button class="dropdown-toggle flex items-center text-gray-700 hover:text-gray-900">
                                <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="Admin"
                                    class="h-8 w-8 rounded-full object-cover mr-2 border-2 border-primary-200">
                                <span class="hidden sm:block text-sm font-medium">Admin</span>
                                <i class="fas fa-chevron-down text-xs ml-1"></i>
                            </button>
                            <div class="dropdown-menu mt-2 bg-white rounded-lg shadow-lg border border-gray-200 w-48">
                                <a href="#profile"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                    <i class="fas fa-user-circle mr-2"></i> Mon profil
                                </a>
                                <a href="#settings"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                    <i class="fas fa-cog mr-2"></i> Paramètres
                                </a>
                                <div class="border-t border-gray-200"></div>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" 
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <div class="p-6">
                <!-- Dashboard Section -->
                <section id="dashboard-section" class="section active">
                    <!-- Page Title -->
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Tableau de bord</h2>
                        <p class="text-gray-600">Aperçu général et statistiques</p>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Total Doctors -->
                        <div
                            class="bg-gradient-to-br from-white to-primary-50 rounded-xl shadow-card p-6 card animate-fade-in">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm font-medium text-gray-500">Total Médecins</h3>
                                <div class="bg-primary-100 text-primary-600 p-2 rounded-lg">
                                    <i class="fas fa-user-md"></i>
                                </div>
                            </div>
                            <div class="flex items-end">
                                <p class="text-3xl font-bold text-gray-800" id="total-doctors">124</p>
                                <p class="text-sm text-success-500 ml-2 flex items-center">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    <span>12%</span>
                                </p>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Depuis le mois dernier</p>
                        </div>

                        <!-- Active Doctors -->
                        <div
                            class="bg-gradient-to-br from-white to-success-50 rounded-xl shadow-card p-6 card animate-fade-in delay-100">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm font-medium text-gray-500">Médecins Actifs</h3>
                                <div class="bg-success-100 text-success-600 p-2 rounded-lg">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                            <div class="flex items-end">
                                <p class="text-3xl font-bold text-gray-800" id="active-doctors">98</p>
                                <p class="text-sm text-success-500 ml-2 flex items-center">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    <span>8%</span>
                                </p>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Depuis le mois dernier</p>
                        </div>

                        <!-- Pending Doctors -->
                        <div
                            class="bg-gradient-to-br from-white to-warning-50 rounded-xl shadow-card p-6 card animate-fade-in delay-200">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm font-medium text-gray-500">En attente</h3>
                                <div class="bg-warning-100 text-warning-600 p-2 rounded-lg">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                            <div class="flex items-end">
                                <p class="text-3xl font-bold text-gray-800" id="pending-doctors">18</p>
                                <p class="text-sm text-danger-500 ml-2 flex items-center">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    <span>24%</span>
                                </p>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Depuis le mois dernier</p>
                        </div>

                        <!-- Inactive Doctors -->
                        <div
                            class="bg-gradient-to-br from-white to-danger-50 rounded-xl shadow-card p-6 card animate-fade-in delay-300">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm font-medium text-gray-500">Inactifs</h3>
                                <div class="bg-danger-100 text-danger-600 p-2 rounded-lg">
                                    <i class="fas fa-ban"></i>
                                </div>
                            </div>
                            <div class="flex items-end">
                                <p class="text-3xl font-bold text-gray-800" id="inactive-doctors">8</p>
                                <p class="text-sm text-success-500 ml-2 flex items-center">
                                    <i class="fas fa-arrow-down mr-1"></i>
                                    <span>5%</span>
                                </p>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">Depuis le mois dernier</p>
                        </div>
                    </div>

                    <!-- Charts Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <!-- Status Distribution Chart -->
                        <div class="bg-white rounded-xl shadow-card p-6 card animate-fade-in">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Distribution des statuts</h3>
                            <div class="h-64">
                                <canvas id="status-chart"></canvas>
                            </div>
                        </div>

                        <!-- Registration Trend Chart -->
                        <div class="bg-white rounded-xl shadow-card p-6 card animate-fade-in delay-100">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Tendance des inscriptions</h3>
                            <div class="h-64">
                                <canvas id="registration-chart"></canvas>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Doctors Section -->
                <section id="doctors-section" class="section">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Gestion des médecins</h2>
                        <p class="text-gray-600">Liste et gestion des comptes médecins</p>
                    </div>

                    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex flex-col md:flex-row gap-3">
                            <div class="relative">
                                <input type="text" placeholder="Rechercher un médecin..."
                                    class="w-full md:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                            <div class="relative">
                                <select
                                    class="w-full md:w-40 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 appearance-none">
                                    <option value="all">Tous</option>
                                    <option value="active">Active</option>
                                    <option value="pending">En attente</option>
                                    <option value="inactive">Not active</option>
                                </select>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-filter text-gray-400"></i>
                                </div>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                        <button
                            class="bg-primary-600 text-white px-4 py-2 rounded-lg hover:bg-primary-700 transition-colors flex items-center justify-center">
                            <i class="fas fa-plus mr-2"></i>
                            Ajouter un médecin
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        <!-- Doctor Card 1 -->
                        <div
                            class="doctor-card bg-white rounded-xl overflow-hidden shadow-card hover:shadow-card-hover transition-all">
                            <div
                                class="card-header px-6 py-4 bg-gradient-to-r from-primary-50 to-white border-b border-gray-100">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-14 w-14 rounded-full overflow-hidden border-2 border-primary-100">
                                        <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Dr. Jean Dupont"
                                            class="h-full w-full object-cover">
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h3 class="text-lg font-semibold text-primary-700">Dr. Jean Dupont</h3>
                                                <p class="text-sm text-gray-600">Cardiologie</p>
                                            </div>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-50 text-success-700">
                                                <span class="w-1.5 h-1.5 bg-success-500 rounded-full mr-1.5"></span>
                                                Actif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="px-6 py-4">
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-500">Email</p>
                                        <p class="font-medium text-gray-800">jean.dupont@example.com</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Téléphone</p>
                                        <p class="font-medium text-gray-800">+33 6 12 34 56 78</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <p class="text-gray-500 text-sm">Patients</p>
                                    <div class="flex items-center mt-1">
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-primary-600 h-2.5 rounded-full" style="width: 75%"></div>
                                        </div>
                                        <span class="ml-2 text-sm font-medium text-gray-700">42</span>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                                <div class="card-actions flex space-x-3">
                                    <button class="text-primary-600 hover:text-primary-800 transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-warning-600 hover:text-warning-800 transition-colors">
                                        <i class="fas fa-exchange-alt"></i>
                                    </button>
                                    <button class="text-danger-600 hover:text-danger-800 transition-colors">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                                <a href="#"
                                    class="text-sm font-medium text-primary-600 hover:text-primary-800 transition-colors flex items-center">
                                    Voir détails
                                    <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Doctor Card 2 -->
                        <div
                            class="doctor-card bg-white rounded-xl overflow-hidden shadow-card hover:shadow-card-hover transition-all">
                            <div
                                class="card-header px-6 py-4 bg-gradient-to-r from-primary-50 to-white border-b border-gray-100">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-14 w-14 rounded-full overflow-hidden border-2 border-primary-100">
                                        <img src="https://randomuser.me/api/portraits/women/44.jpg"
                                            alt="Dr. Marie Martin" class="h-full w-full object-cover">
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h3 class="text-lg font-semibold text-primary-700">Dr. Marie Martin</h3>
                                                <p class="text-sm text-gray-600">Pédiatrie</p>
                                            </div>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-50 text-success-700">
                                                <span class="w-1.5 h-1.5 bg-success-500 rounded-full mr-1.5"></span>
                                                Actif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="px-6 py-4">
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-500">Email</p>
                                        <p class="font-medium text-gray-800">marie.martin@example.com</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Téléphone</p>
                                        <p class="font-medium text-gray-800">+33 6 23 45 67 89</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <p class="text-gray-500 text-sm">Patients</p>
                                    <div class="flex items-center mt-1">
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-primary-600 h-2.5 rounded-full" style="width: 90%"></div>
                                        </div>
                                        <span class="ml-2 text-sm font-medium text-gray-700">56</span>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                                <div class="card-actions flex space-x-3">
                                    <button class="text-primary-600 hover:text-primary-800 transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-warning-600 hover:text-warning-800 transition-colors">
                                        <i class="fas fa-exchange-alt"></i>
                                    </button>
                                    <button class="text-danger-600 hover:text-danger-800 transition-colors">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                                <a href="#"
                                    class="text-sm font-medium text-primary-600 hover:text-primary-800 transition-colors flex items-center">
                                    Voir détails
                                    <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Doctor Card 3 -->
                        <div
                            class="doctor-card bg-white rounded-xl overflow-hidden shadow-card hover:shadow-card-hover transition-all">
                            <div
                                class="card-header px-6 py-4 bg-gradient-to-r from-warning-50 to-white border-b border-gray-100">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-14 w-14 rounded-full overflow-hidden border-2 border-warning-100">
                                        <img src="https://randomuser.me/api/portraits/men/59.jpg"
                                            alt="Dr. Pierre Lefebvre" class="h-full w-full object-cover">
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h3 class="text-lg font-semibold text-primary-700">Dr. Pierre Lefebvre
                                                </h3>
                                                <p class="text-sm text-gray-600">Généraliste</p>
                                            </div>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-warning-50 text-warning-700">
                                                <span class="w-1.5 h-1.5 bg-warning-500 rounded-full mr-1.5"></span>
                                                En attente
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="px-6 py-4">
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-500">Email</p>
                                        <p class="font-medium text-gray-800">pierre.lefebvre@example.com</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Téléphone</p>
                                        <p class="font-medium text-gray-800">+33 6 34 56 78 90</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <p class="text-gray-500 text-sm">Patients</p>
                                    <div class="flex items-center mt-1">
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="bg-warning-500 h-2.5 rounded-full" style="width: 10%"></div>
                                        </div>
                                        <span class="ml-2 text-sm font-medium text-gray-700">5</span>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                                <div class="card-actions flex space-x-3">
                                    <button class="text-primary-600 hover:text-primary-800 transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-success-600 hover:text-success-800 transition-colors">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="text-danger-600 hover:text-danger-800 transition-colors">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                                <a href="#"
                                    class="text-sm font-medium text-primary-600 hover:text-primary-800 transition-colors flex items-center">
                                    Voir détails
                                    <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <a href="#"
                                class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Précédent</span>
                                <i class="fas fa-chevron-left"></i>
                            </a>
                            <a href="#"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-primary-50 text-sm font-medium text-primary-600 hover:bg-primary-100">
                                1
                            </a>
                            <a href="#"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                2
                            </a>
                            <a href="#"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                3
                            </a>
                            <span
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                ...
                            </span>
                            <a href="#"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                8
                            </a>
                            <a href="#"
                                class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Suivant</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </nav>
                    </div>
                </section>

                <!-- Patients Section -->
                <section id="patients-section" class="section">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Gestion des patients</h2>
                        <p class="text-gray-600">Liste et gestion des dossiers patients</p>
                    </div>

                    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex flex-col md:flex-row gap-3">
                            <div class="relative">
                                <input type="text" placeholder="Rechercher un patient..."
                                    class="w-full md:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                            <div class="relative">
                                <select
                                    class="w-full md:w-40 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 appearance-none">
                                    <option value="all">Tous</option>
                                    <option value="active">Actifs</option>
                                    <option value="inactive">Inactifs</option>
                                </select>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-filter text-gray-400"></i>
                                </div>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        <!-- Patient Card 1 -->
                        <div
                            class="patient-card bg-white rounded-xl overflow-hidden shadow-card hover:shadow-card-hover transition-all">
                            <div
                                class="card-header px-6 py-4 bg-gradient-to-r from-info-50 to-white border-b border-gray-100">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-14 w-14 rounded-full overflow-hidden border-2 border-info-100">
                                        <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Jean Dupont"
                                            class="h-full w-full object-cover">
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h3 class="text-lg font-semibold text-primary-700">Jean Dupont</h3>
                                                <p class="text-sm text-gray-600">ID: #12345</p>
                                            </div>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-50 text-success-700">
                                                <span class="w-1.5 h-1.5 bg-success-500 rounded-full mr-1.5"></span>
                                                Actif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="px-6 py-4">
                                <div class="grid grid-cols-3 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-500">Âge</p>
                                        <p class="font-medium text-gray-800">42 ans</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Genre</p>
                                        <p class="font-medium text-gray-800">Homme</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Téléphone</p>
                                        <p class="font-medium text-gray-800">+33 6 12 34 56 78</p>
                                    </div>
                                </div>
                                <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-500">Dernière visite</p>
                                        <p class="font-medium text-gray-800">15/04/2023</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Prochain RDV</p>
                                        <p class="font-medium text-primary-600">28/05/2023</p>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                                <div class="card-actions flex space-x-3">
                                    <button class="text-primary-600 hover:text-primary-800 transition-colors">
                                        <i class="fas fa-file-medical"></i>
                                    </button>
                                    <button class="text-success-600 hover:text-success-800 transition-colors">
                                        <i class="fas fa-calendar-plus"></i>
                                    </button>
                                    <button class="text-info-600 hover:text-info-800 transition-colors">
                                        <i class="fas fa-comments"></i>
                                    </button>
                                </div>
                                <a href="#"
                                    class="text-sm font-medium text-primary-600 hover:text-primary-800 transition-colors flex items-center">
                                    Voir détails
                                    <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Patient Card 2 -->
                        <div
                            class="patient-card bg-white rounded-xl overflow-hidden shadow-card hover:shadow-card-hover transition-all">
                            <div
                                class="card-header px-6 py-4 bg-gradient-to-r from-info-50 to-white border-b border-gray-100">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-14 w-14 rounded-full overflow-hidden border-2 border-info-100">
                                        <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Marie Martin"
                                            class="h-full w-full object-cover">
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h3 class="text-lg font-semibold text-primary-700">Marie Martin</h3>
                                                <p class="text-sm text-gray-600">ID: #12346</p>
                                            </div>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-50 text-success-700">
                                                <span class="w-1.5 h-1.5 bg-success-500 rounded-full mr-1.5"></span>
                                                Actif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="px-6 py-4">
                                <div class="grid grid-cols-3 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-500">Âge</p>
                                        <p class="font-medium text-gray-800">35 ans</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Genre</p>
                                        <p class="font-medium text-gray-800">Femme</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Téléphone</p>
                                        <p class="font-medium text-gray-800">+33 6 23 45 67 89</p>
                                    </div>
                                </div>
                                <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-500">Dernière visite</p>
                                        <p class="font-medium text-gray-800">22/04/2023</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Prochain RDV</p>
                                        <p class="font-medium text-primary-600">10/06/2023</p>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                                <div class="card-actions flex space-x-3">
                                    <button class="text-primary-600 hover:text-primary-800 transition-colors">
                                        <i class="fas fa-file-medical"></i>
                                    </button>
                                    <button class="text-success-600 hover:text-success-800 transition-colors">
                                        <i class="fas fa-calendar-plus"></i>
                                    </button>
                                    <button class="text-info-600 hover:text-info-800 transition-colors">
                                        <i class="fas fa-comments"></i>
                                    </button>
                                </div>
                                <a href="#"
                                    class="text-sm font-medium text-primary-600 hover:text-primary-800 transition-colors flex items-center">
                                    Voir détails
                                    <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Patient Card 3 -->
                        <div
                            class="patient-card bg-white rounded-xl overflow-hidden shadow-card hover:shadow-card-hover transition-all">
                            <div
                                class="card-header px-6 py-4 bg-gradient-to-r from-info-50 to-white border-b border-gray-100">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 h-14 w-14 rounded-full overflow-hidden border-2 border-info-100">
                                        <img src="https://randomuser.me/api/portraits/men/42.jpg" alt="Pierre Dubois"
                                            class="h-full w-full object-cover">
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h3 class="text-lg font-semibold text-primary-700">Pierre Dubois</h3>
                                                <p class="text-sm text-gray-600">ID: #12347</p>
                                            </div>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-danger-50 text-danger-700">
                                                <span class="w-1.5 h-1.5 bg-danger-500 rounded-full mr-1.5"></span>
                                                Inactif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="px-6 py-4">
                                <div class="grid grid-cols-3 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-500">Âge</p>
                                        <p class="font-medium text-gray-800">58 ans</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Genre</p>
                                        <p class="font-medium text-gray-800">Homme</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Téléphone</p>
                                        <p class="font-medium text-gray-800">+33 6 34 56 78 90</p>
                                    </div>
                                </div>
                                <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-500">Dernière visite</p>
                                        <p class="font-medium text-gray-800">05/03/2023</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Prochain RDV</p>
                                        <p class="font-medium text-gray-500">Non planifié</p>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                                <div class="card-actions flex space-x-3">
                                    <button class="text-primary-600 hover:text-primary-800 transition-colors">
                                        <i class="fas fa-file-medical"></i>
                                    </button>
                                    <button class="text-success-600 hover:text-success-800 transition-colors">
                                        <i class="fas fa-calendar-plus"></i>
                                    </button>
                                    <button class="text-info-600 hover:text-info-800 transition-colors">
                                        <i class="fas fa-comments"></i>
                                    </button>
                                </div>
                                <a href="#"
                                    class="text-sm font-medium text-primary-600 hover:text-primary-800 transition-colors flex items-center">
                                    Voir détails
                                    <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <a href="#"
                                class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Précédent</span>
                                <i class="fas fa-chevron-left"></i>
                            </a>
                            <a href="#"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-primary-50 text-sm font-medium text-primary-600 hover:bg-primary-100">
                                1
                            </a>
                            <a href="#"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                2
                            </a>
                            <a href="#"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                3
                            </a>
                            <span
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                ...
                            </span>
                            <a href="#"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                10
                            </a>
                            <a href="#"
                                class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Suivant</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </nav>
                    </div>
                </section>

                <!-- Appointments Section -->
                <section id="appointments-section" class="section">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Gestion des rendez-vous</h2>
                        <p class="text-gray-600">Planification et suivi des rendez-vous</p>
                    </div>

                    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex flex-col md:flex-row gap-3">
                            <div class="relative">
                                <input type="text" placeholder="Rechercher un rendez-vous..."
                                    class="w-full md:w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                            </div>
                            <div class="relative">
                                <select
                                    class="w-full md:w-40 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 appearance-none">
                                    <option value="all">Tous</option>
                                    <option value="upcoming">À venir</option>
                                    <option value="completed">Terminés</option>
                                    <option value="cancelled">Annulés</option>
                                </select>
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-filter text-gray-400"></i>
                                </div>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <i class="fas fa-chevron-down text-gray-400"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        <!-- Appointment Card 1 -->
                        <div
                            class="appointment-card bg-white rounded-xl overflow-hidden shadow-card hover:shadow-card-hover transition-all">
                            <div
                                class="card-header px-6 py-4 bg-gradient-to-r from-warning-50 to-white border-b border-gray-100">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold text-primary-700">Jean Dupont</h3>
                                        <p class="text-sm text-gray-600">Avec Dr. Marie Martin</p>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-warning-50 text-warning-700">
                                        <span class="w-1.5 h-1.5 bg-warning-500 rounded-full mr-1.5"></span>
                                        À venir
                                    </span>
                                </div>
                            </div>
                            <div class="px-6 py-4">
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-500">Date</p>
                                        <p class="font-medium text-gray-800">28/05/2023</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Heure</p>
                                        <p class="font-medium text-gray-800">10:15</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <p class="text-gray-500">Motif</p>
                                    <p class="font-medium text-gray-800">Contrôle tension artérielle</p>
                                </div>
                                <div class="mt-4 flex items-center">
                                    <div class="w-full bg-gray-200 rounded-full h-1.5">
                                        <div class="bg-warning-500 h-1.5 rounded-full" style="width: 100%"></div>
                                    </div>
                                    <span class="ml-2 text-xs font-medium text-gray-500">3 jours</span>
                                </div>
                            </div>
                            <div
                                class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                                <div class="card-actions flex space-x-3">
                                    <button class="text-primary-600 hover:text-primary-800 transition-colors">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="text-success-600 hover:text-success-800 transition-colors">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    <button class="text-danger-600 hover:text-danger-800 transition-colors">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <a href="#"
                                    class="text-sm font-medium text-primary-600 hover:text-primary-800 transition-colors flex items-center">
                                    Voir détails
                                    <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Appointment Card 2 -->
                        <div
                            class="appointment-card bg-white rounded-xl overflow-hidden shadow-card hover:shadow-card-hover transition-all">
                            <div
                                class="card-header px-6 py-4 bg-gradient-to-r from-success-50 to-white border-b border-gray-100">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold text-primary-700">Marie Martin</h3>
                                        <p class="text-sm text-gray-600">Avec Dr. Jean Dupont</p>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-50 text-success-700">
                                        <span class="w-1.5 h-1.5 bg-success-500 rounded-full mr-1.5"></span>
                                        Terminé
                                    </span>
                                </div>
                            </div>
                            <div class="px-6 py-4">
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-500">Date</p>
                                        <p class="font-medium text-gray-800">15/04/2023</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Heure</p>
                                        <p class="font-medium text-gray-800">14:30</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <p class="text-gray-500">Motif</p>
                                    <p class="font-medium text-gray-800">Consultation de suivi</p>
                                </div>
                                <div class="mt-4">
                                    <p class="text-gray-500">Notes</p>
                                    <p class="text-sm text-gray-600 line-clamp-2">Patient en bonne santé générale.
                                        Tension artérielle normale. Prochain rendez-vous dans 3 mois.</p>
                                </div>
                            </div>
                            <div
                                class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                                <div class="card-actions flex space-x-3">
                                    <button class="text-primary-600 hover:text-primary-800 transition-colors">
                                        <i class="fas fa-file-medical"></i>
                                    </button>
                                    <button class="text-info-600 hover:text-info-800 transition-colors">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </div>
                                <a href="#"
                                    class="text-sm font-medium text-primary-600 hover:text-primary-800 transition-colors flex items-center">
                                    Voir détails
                                    <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            </div>
                        </div>

                        <div
                            class="appointment-card bg-white rounded-xl overflow-hidden shadow-card hover:shadow-card-hover transition-all">
                            <div
                                class="card-header px-6 py-4 bg-gradient-to-r from-danger-50 to-white border-b border-gray-100">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-semibold text-primary-700">Pierre Dubois</h3>
                                        <p class="text-sm text-gray-600">Avec Dr. Pierre Lefebvre</p>
                                    </div>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-danger-50 text-danger-700">
                                        <span class="w-1.5 h-1.5 bg-danger-500 rounded-full mr-1.5"></span>
                                        Annulé
                                    </span>
                                </div>
                            </div>
                            <div class="px-6 py-4">
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-500">Date</p>
                                        <p class="font-medium text-gray-800">10/03/2023</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Heure</p>
                                        <p class="font-medium text-gray-800">09:00</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <p class="text-gray-500">Motif</p>
                                    <p class="font-medium text-gray-800">Consultation générale</p>
                                </div>
                                <div class="mt-4">
                                    <p class="text-gray-500">Raison d'annulation</p>
                                    <p class="text-sm text-danger-600">Annulé par le patient</p>
                                </div>
                            </div>
                            <div
                                class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                                <div class="card-actions flex space-x-3">
                                    <button class="text-primary-600 hover:text-primary-800 transition-colors">
                                        <i class="fas fa-calendar-plus"></i>
                                    </button>
                                </div>
                                <a href="#"
                                    class="text-sm font-medium text-primary-600 hover:text-primary-800 transition-colors flex items-center">
                                    Voir détails
                                    <i class="fas fa-chevron-right ml-1 text-xs"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-center">
                        <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                            <a href="#"
                                class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Précédent</span>
                                <i class="fas fa-chevron-left"></i>
                            </a>
                            <a href="#"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-primary-50 text-sm font-medium text-primary-600 hover:bg-primary-100">
                                1
                            </a>
                            <a href="#"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                2
                            </a>
                            <a href="#"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                3
                            </a>
                            <span
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                ...
                            </span>
                            <a href="#"
                                class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                5
                            </a>
                            <a href="#"
                                class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <span class="sr-only">Suivant</span>
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </nav>
                    </div>
                </section>

                <!-- Settings Section -->
                <section id="settings-section" class="section">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Paramètres</h2>
                        <p class="text-gray-600">Configuration du système</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-card p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Paramètres généraux</h3>
                        <div class="space-y-4">
                            <!-- Contenu des paramètres -->
                            <p class="text-gray-600">Cette section est en cours de développement.</p>
                        </div>
                    </div>
                </section>

                <!-- Users Section -->
                <section id="users-section" class="section">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Gestion des utilisateurs</h2>
                        <p class="text-gray-600">Administration des comptes utilisateurs</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-card p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Liste des utilisateurs</h3>
                        <div class="space-y-4">
                            <!-- Contenu des utilisateurs -->
                            <p class="text-gray-600">Cette section est en cours de développement.</p>
                        </div>
                    </div>
                </section>

                <!-- Logs Section -->
                <section id="logs-section" class="section">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Logs d'activité</h2>
                        <p class="text-gray-600">Historique des actions système</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-card p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Journal d'activité</h3>
                        <div class="space-y-4">
                            <!-- Contenu des logs -->
                            <p class="text-gray-600">Cette section est en cours de développement.</p>
                        </div>
                    </div>
                </section>

                <!-- Profile Section -->
                <section id="profile-section" class="section">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Mon profil</h2>
                        <p class="text-gray-600">Gestion de votre compte</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-card p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Informations personnelles</h3>
                        <div class="space-y-4">
                            <!-- Contenu du profil -->
                            <p class="text-gray-600">Cette section est en cours de développement.</p>
                        </div>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <!-- Toast Notification -->
    <div id="toast"
        class="fixed bottom-4 right-4 bg-white rounded-lg shadow-lg border-l-4 border-success-500 p-4 transform translate-y-10 opacity-0 transition-all duration-300 z-50 hidden">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <i id="toast-icon" class="fas fa-check-circle text-success-500 text-xl"></i>
            </div>
            <div class="ml-3">
                <p id="toast-message" class="text-sm font-medium text-gray-900">Opération réussie</p>
            </div>
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button onclick="hideToast()" class="inline-flex text-gray-400 hover:text-gray-500">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const dashboardData = {
            patients: @json($patients ?? []),
            doctors: @json($doctors ?? []),
            appointments: @json($appointments ?? []),
            totalPatients: @json($totalPatients ?? 0),
            totalDoctors: @json($totalDoctors ?? 0),
            totalAppointments: @json($totalAppointments ?? 0),
            totalRevenue: @json($totalRevenue ?? 0),
            todayAppointments: @json($todayAppointments ?? []),
            pendingRequests: @json($pendingRequests ?? [])
        };

        document.addEventListener('DOMContentLoaded', function () {
            if (document.getElementById('total-doctors')) {
                document.getElementById('total-doctors').textContent = dashboardData.totalDoctors;
            }

            if (document.getElementById('pending-doctors') && dashboardData.pendingRequests) {
                document.getElementById('pending-doctors').textContent = dashboardData.pendingRequests.length;
            }

            if (document.getElementById('inactive-doctors')) {
                const inactiveDoctors = dashboardData.doctors.filter(doctor => doctor.status === 'not active').length;
                document.getElementById('inactive-doctors').textContent = inactiveDoctors;
            }

            initStatusChart();
            initRegistrationChart();
        });

        function initStatusChart() {
            const status = document.getElementById('status-chart');
            if (!status) return;
            const statusData = {
                active: 0,
                pending: 0,
                inactive: 0
            };

            if (dashboardData.doctors && dashboardData.doctors.length > 0) {
                dashboardData.doctors.forEach(doctor => {
                    if (doctor.status === 'active') statusData.active++;
                    else if (doctor.status === 'pending') statusData.pending++;
                    else if (doctor.status === 'not active') statusData.inactive++;
                });
            }

            // Créer le graphique
            new Chart(status, {
                type: 'doughnut',
                data: {
                    labels: ['Active', 'En attente', 'Not Active'],
                    datasets: [{
                        data: [statusData.active, statusData.pending, statusData.inactive],
                        backgroundColor: [
                            'rgba(16, 185, 129, 0.8)',
                            'rgba(245, 158, 11, 0.8)',
                            'rgba(239, 68, 68, 0.8)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }

        function initRegistrationChart() {
            const registration = document.getElementById('registration-chart');
            if (!registration) return;

            // Créer des données fictives pour l'exemple
            // Dans un vrai scénario, vous devriez calculer ces données à partir de dashboardData
            const months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'];
            const currentMonth = new Date().getMonth();

            // Organiser les données par mois (pour les 6 derniers mois)
            const registrationData = {
                doctors: Array(6).fill(0),
                patients: Array(6).fill(0)
            };

            // Si vous avez des dates d'inscription dans vos données, vous pouvez les utiliser
            if (dashboardData.doctors && dashboardData.doctors.length > 0) {
                dashboardData.doctors.forEach(doctor => {
                    // Supposons que doctor_details contient une date created_at
                    if (doctor.doctor_details && doctor.doctor_details.created_at) {
                        const createdDate = new Date(doctor.doctor_details.created_at);
                        const monthDiff = currentMonth - createdDate.getMonth();
                        if (monthDiff >= 0 && monthDiff < 6) {
                            registrationData.doctors[5 - monthDiff]++;
                        }
                    }
                });
            }
            if (dashboardData.patients && dashboardData.patients.length > 0) {
                dashboardData.patients.forEach(patient => {
                    if (patient['patient_details'].created_at) {
                        const createdDate = new Date(patient['patient_details'].created_at);
                        const monthDiff = currentMonth - createdDate.getMonth();
                        if (monthDiff >= 0 && monthDiff < 6) {
                            registrationData.patients[5 - monthDiff]++;
                        }
                    }
                });
            }

            // Récupérer les 6 derniers mois
            const lastSixMonths = [];
            for (let i = 5; i >= 0; i--) {
                const monthIndex = (currentMonth - i + 12) % 12;
                lastSixMonths.push(months[monthIndex]);
            }

            // Créer le graphique
            new Chart(registration, {
                type: 'line',
                data: {
                    labels: lastSixMonths,
                    datasets: [{
                        label: 'Médecins',
                        data: registrationData.doctors,
                        borderColor: 'rgba(59, 130, 246, 0.8)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true
                    }, {
                        label: 'Patients',
                        data: registrationData.patients,
                        borderColor: 'rgba(16, 185, 129, 0.8)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        }

        // Fonction pour afficher un toast
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toast-message');
            const toastIcon = document.getElementById('toast-icon');

            if (toast && toastMessage && toastIcon) {
                toastMessage.textContent = message;

                if (type === 'success') {
                    toast.classList.remove('border-danger-500', 'border-warning-500');
                    toast.classList.add('border-success-500');
                    toastIcon.classList.remove('text-danger-500', 'text-warning-500');
                    toastIcon.classList.add('text-success-500');
                    toastIcon.classList.remove('fa-times-circle', 'fa-exclamation-circle');
                    toastIcon.classList.add('fa-check-circle');
                } else if (type === 'error') {
                    toast.classList.remove('border-success-500', 'border-warning-500');
                    toast.classList.add('border-danger-500');
                    toastIcon.classList.remove('text-success-500', 'text-warning-500');
                    toastIcon.classList.add('text-danger-500');
                    toastIcon.classList.remove('fa-check-circle', 'fa-exclamation-circle');
                    toastIcon.classList.add('fa-times-circle');
                } else if (type === 'warning') {
                    toast.classList.remove('border-success-500', 'border-danger-500');
                    toast.classList.add('border-warning-500');
                    toastIcon.classList.remove('text-success-500', 'text-danger-500');
                    toastIcon.classList.add('text-warning-500');
                    toastIcon.classList.remove('fa-check-circle', 'fa-times-circle');
                    toastIcon.classList.add('fa-exclamation-circle');
                }

                // Afficher le toast
                toast.classList.remove('hidden');
                toast.classList.remove('translate-y-10', 'opacity-0');

                // Masquer automatiquement après 3 secondes
                setTimeout(hideToast, 3000);
            }
        }

        // Fonction pour masquer le toast
        function hideToast() {
            const toast = document.getElementById('toast');
            if (toast) {
                toast.classList.add('translate-y-10', 'opacity-0');
                setTimeout(() => {
                    toast.classList.add('hidden');
                }, 300);
            }
        }

        // Gestion de la navigation via la sidebar
        document.addEventListener('DOMContentLoaded', function () {
            // Gérer les clics sur les liens de la sidebar
            const sidebarLinks = document.querySelectorAll('.sidebar-item');
            const sections = document.querySelectorAll('.section');
            const sectionTitle = document.getElementById('section-title');

            // Fonction pour activer une section
            function activateSection(sectionId) {
                // Masquer toutes les sections
                sections.forEach(section => {
                    section.classList.remove('active');
                });

                // Afficher la section sélectionnée
                const targetSection = document.getElementById(sectionId);
                if (targetSection) {
                    targetSection.classList.add('active');
                }

                // Mettre à jour le titre de la section
                if (sectionTitle) {
                    const activeLinkText = document.querySelector(`.sidebar-item[data-section="${sectionId}"]`).textContent.trim();
                    sectionTitle.textContent = activeLinkText;
                }

                // Mettre à jour la classe active dans la sidebar
                sidebarLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('data-section') === sectionId) {
                        link.classList.add('active');
                    }
                });

                // Sauvegarder la section active dans localStorage
                localStorage.setItem('activeSection', sectionId);
            }

            // Ajouter les écouteurs d'événements pour les liens de la sidebar
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    e.preventDefault();
                    const sectionId = this.getAttribute('data-section');
                    if (sectionId) {
                        activateSection(sectionId);

                        // Fermer le menu mobile si ouvert
                        const sidebar = document.querySelector('.sidebar');
                        if (sidebar && window.innerWidth < 768) {
                            sidebar.classList.add('hidden');
                        }
                    }
                });
            });

            // Vérifier s'il y a une section active sauvegardée
            const savedSection = localStorage.getItem('activeSection');
            if (savedSection) {
                activateSection(savedSection);
            } else {
                // Activer la première section par défaut
                activateSection('dashboard-section');
            }

            // Gestion du bouton toggle sidebar sur mobile
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const sidebarNav = document.getElementById('sidebar-nav');

            if (mobileMenuToggle && sidebarNav) {
                mobileMenuToggle.addEventListener('click', function () {
                    sidebarNav.classList.toggle('hidden');
                });
            }

            // Gestion du thème clair/sombre
            const themeToggle = document.getElementById('theme-toggle');


            // Gestion des dropdowns
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function (e) {
                    e.preventDefault();
                    const dropdown = this.closest('.dropdown');
                    dropdown.classList.toggle('active');

                    // Fermer les autres dropdowns
                    dropdownToggles.forEach(otherToggle => {
                        if (otherToggle !== toggle) {
                            otherToggle.closest('.dropdown').classList.remove('active');
                        }
                    });
                });
            });

            // Fermer les dropdowns quand on clique ailleurs
            document.addEventListener('click', function (e) {
                if (!e.target.closest('.dropdown')) {
                    dropdownToggles.forEach(toggle => {
                        toggle.closest('.dropdown').classList.remove('active');
                    });
                }
            });
        });
    </script>
</body>

</html>