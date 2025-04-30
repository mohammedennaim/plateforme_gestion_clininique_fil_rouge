<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediDash - Tableau de Bord Médical</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <style>
        /* Base styles */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
            overflow-x: hidden;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c5c5c5;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #6366F1;
        }

        /* Sidebar animation */
        #sidebar {
            transition: transform 0.3s ease-in-out, width 0.3s ease-in-out;
        }

        .sidebar-item {
            transition: all 0.3s ease;
            border-radius: 10px;
            margin: 5px 10px;
        }

        .sidebar-item:hover {
            background-color: rgba(99, 102, 241, 0.1);
        }

        .sidebar-item.active {
            background-color: #6366F1;
            color: white;
        }

        .sidebar-item.active i {
            color: white;
        }

        .logout-item {
            transition: all 0.3s ease;
            border-radius: 10px;
            margin: 5px 10px;
            width: 92%;
        }

        .logout-item:hover {
            background-color: rgba(99, 102, 241, 0.1);
        }

        .logout-item.active {
            background-color: #6366F1;
            color: white;
        }

        .logout-item.active i {
            color: white;
        }

        /* Card animations */
        .stats-card {
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .stats-card-gradient-1 {
            background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%);
        }

        .stats-card-gradient-2 {
            background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        }

        .stats-card-gradient-3 {
            background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
        }

        .stats-card-gradient-4 {
            background: linear-gradient(135deg, #EF4444 0%, #DC2626 100%);
        }

        /* Appointments and patient cards */
        .appointment-card {
            transition: all 0.3s ease;
        }

        .appointment-card:hover {
            transform: translateX(5px);
            background-color: #f9fafb;
        }

        .patient-card {
            transition: all 0.3s ease;
        }

        .patient-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        /* Status indicators */
        .status-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }

        .status-confirmed {
            background-color: #10B981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
        }

        .status-pending {
            background-color: #F97316;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2);
        }

        .status-cancelled {
            background-color: #EF4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.2);
        }

        .status-completed {
            background-color: #6366F1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
        }

        /* Pulse animation */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.7);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(99, 102, 241, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(99, 102, 241, 0);
            }
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        /* Calendar day styles */
        .calendar-day {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .calendar-day:hover {
            background-color: #e0e7ff;
        }

        .calendar-day.active {
            background-color: #6366F1;
            color: white;
            font-weight: 600;
        }

        .calendar-day.has-appointments::after {
            content: '';
            position: absolute;
            bottom: 3px;
            width: 4px;
            height: 4px;
            border-radius: 50%;
            background-color: #6366F1;
        }

        .calendar-day.active.has-appointments::after {
            background-color: white;
        }

        /* Patient vitals card */
        .vital-card {
            transition: all 0.3s ease;
            border-radius: 10px;
            overflow: hidden;
        }

        .vital-card:hover {
            box-shadow: 0 0 15px rgba(99, 102, 241, 0.2);
        }

        /* Tab styles */
        .tab-button {
            position: relative;
            transition: all 0.3s ease;
        }

        .tab-button.active {
            color: #6366F1;
            font-weight: 500;
        }

        .tab-button.active::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: -8px;
            left: 0;
            background-color: #6366F1;
        }

        /* Analytics card styles */
        .analytics-card {
            transition: all 0.3s ease;
            border-radius: 12px;
            overflow: hidden;
        }

        .analytics-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }

        /* Task item styles */
        .task-item {
            position: relative;
            padding: 12px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .task-item:hover {
            background-color: #f9fafb;
        }

        .task-checkbox {
            width: 20px;
            height: 20px;
            border-radius: 6px;
            border: 2px solid #d1d5db;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .task-checkbox.checked {
            background-color: #6366F1;
            border-color: #6366F1;
        }

        .task-checkbox.checked::after {
            content: '✓';
            position: absolute;
            color: white;
            font-size: 12px;
            left: 19px;
            top: 14px;
        }

        .task-text {
            transition: all 0.3s ease;
        }

        .task-text.checked {
            text-decoration: line-through;
            color: #9ca3af;
        }

        /* Message styles */
        .message-item {
            transition: all 0.3s ease;
            border-radius: 10px;
        }

        .message-item:hover {
            background-color: #f9fafb;
        }

        .message-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
        }

        /* Section transitions */
        .dashboard-section {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.5s ease, transform 0.5s ease;
        }

        .dashboard-section.active {
            opacity: 1;
            transform: translateY(0);
        }

        /* Notification badge */
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background-color: #EF4444;
            color: white;
            font-size: 11px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Pills */
        .pill {
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .pill:hover {
            transform: translateY(-2px);
        }

        /* Charts */
        .chart-container {
            position: relative;
            height: 250px;
            width: 100%;
        }

        /* Custom toggle switch */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 46px;
            height: 24px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #e5e7eb;
            transition: .4s;
            border-radius: 34px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.toggle-slider {
            background-color: #6366F1;
        }

        input:focus+.toggle-slider {
            box-shadow: 0 0 1px #6366F1;
        }

        input:checked+.toggle-slider:before {
            transform: translateX(22px);
        }

        /* Progress bar */
        .progress-bar {
            height: 6px;
            border-radius: 3px;
            background-color: #e5e7eb;
            position: relative;
            overflow: hidden;
        }

        .progress-bar-fill {
            position: absolute;
            height: 100%;
            transition: width 1s ease;
            border-radius: 3px;
        }

        /* Collapses for mobile */
        @media (max-width: 768px) {
            #sidebar {
                position: fixed;
                left: -260px;
                z-index: 40;
            }

            #sidebar.open {
                left: 0;
            }

            #overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 30;
            }

            #overlay.active {
                display: block;
            }

            #main-content {
                width: 100%;
                padding-left: 0;
            }
        }

        /* Print and PDF optimizations */
        @media print {
            body {
                width: 100%;
                margin: 0;
                padding: 0;
                background-color: white;
            }

            #sidebar,
            .no-print,
            button[data-section] {
                display: none !important;
            }

            #main-content {
                margin-left: 0 !important;
                padding-left: 0 !important;
                width: 100% !important;
            }

            .dashboard-section {
                display: block !important;
                opacity: 1 !important;
                transform: none !important;
                page-break-inside: avoid;
                margin-bottom: 30px;
            }

            .dashboard-section:not(.active) {
                display: block !important;
            }

            /* Expand all charts to ensure they render properly */
            .chart-container {
                height: 300px !important;
                max-width: 100% !important;
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body class="text-gray-800">
    <!-- Overlay for mobile sidebar -->
    <div id="overlay" class="md:hidden"></div>

    <!-- Sidebar -->
    <div id="sidebar" class="bg-white w-64 fixed h-full shadow-lg overflow-y-auto z-30">
        <div class="p-4 border-b">
            <div class="flex items-center justify-center mb-6">
                <div class="text-2xl font-bold text-indigo-600 flex items-center">
                    <i class="fas fa-heartbeat mr-2"></i>
                    <span>MediDash</span>
                </div>
            </div>

            <div class="flex flex-col items-center">
                <div class="w-20 h-20 rounded-full bg-indigo-100 flex items-center justify-center mb-2">
                    <i class="fas fa-user-md text-indigo-600 text-3xl"></i>
                </div>
                <h2 class="text-lg font-semibold">Dr. {{ $details->user->name }}</h2>
                <p class="text-sm text-gray-500">{{ $speciality->name ?? 'Cardiologue' }}</p>
                <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mt-2">
                    <span class="w-2 h-2 bg-green-500 rounded-full mr-1.5 pulse"></span>
                    En ligne
                </span>
            </div>
        </div>

        <nav class="mt-6">
            <div class="px-4 mb-3">
                <p class="text-xs uppercase tracking-wider text-gray-500 font-semibold">Principal</p>
            </div>
            <a href="#" class="sidebar-item active flex items-center p-3" data-section="dashboard">
                <i class="fas fa-home text-lg text-indigo-600 w-6"></i>
                <span class="ml-3">Tableau de bord</span>
            </a>
            <a href="#" class="sidebar-item flex items-center p-3" data-section="patients">
                <i class="fas fa-users text-lg text-gray-500 w-6"></i>
                <span class="ml-3">Patients</span>
                <span
                    class="ml-auto bg-indigo-100 text-indigo-600 rounded-full px-2 py-0.5 text-xs font-medium">{{ count($appointments) }}</span>
            </a>
            <a href="#" class="sidebar-item flex items-center p-3" data-section="appointments">
                <i class="fas fa-calendar-alt text-lg text-gray-500 w-6"></i>
                <span class="ml-3">Rendez-vous</span>
                <span
                    class="ml-auto bg-amber-100 text-amber-600 rounded-full px-2 py-0.5 text-xs font-medium">{{ count($appointments)  }}</span>
            </a>
            <a href="#" class="sidebar-item flex items-center p-3" data-section="medical-records">
                <i class="fas fa-file-medical text-lg text-gray-500 w-6"></i>
                <span class="ml-3">Dossiers médicaux</span>
            </a>

            <div class="px-4 mt-6 mb-3">
                <p class="text-xs uppercase tracking-wider text-gray-500 font-semibold">Organisation</p>
            </div>
            <a href="#" class="sidebar-item flex items-center p-3" data-section="analytics">
                <i class="fas fa-chart-line text-lg text-gray-500 w-6"></i>
                <span class="ml-3">Analyses</span>
            </a>
            <a href="#" class="sidebar-item flex items-center p-3" data-section="communications">
                <i class="fas fa-comments text-lg text-gray-500 w-6"></i>
                <span class="ml-3">Communications</span>
                <div class="ml-auto relative">
                    <i class="fas fa-bell text-gray-500"></i>
                    <span class="notification-badge">{{ $unreadMessagesCount ?? 'N/A'}}</span>
                </div>
            </a>

            <a href="#tab-tasks" class="sidebar-item flex items-center p-3" data-section="tasks">
                <i class="fas fa-tasks text-lg text-gray-500 w-6"></i>
                <span class="ml-3">Tâches</span>
                <span
                    class="ml-auto bg-red-100 text-red-600 rounded-full px-2 py-0.5 text-xs font-medium">{{ $pendingTasksCount ?? 'N/A' }}</span>
            </a>

            <div class="px-4 mt-6 mb-3">
                <p class="text-xs uppercase tracking-wider text-gray-500 font-semibold">Paramètres</p>
            </div>
            <a href="#" class="sidebar-item flex items-center p-3">
                <i class="fas fa-user-circle text-lg text-gray-500 w-6"></i>
                <span class="ml-3">Mon Profil</span>
            </a>
            <a href="#" class="sidebar-item flex items-center p-3">
                <i class="fas fa-cog text-lg text-gray-500 w-6"></i>
                <span class="ml-3">Paramètres</span>
            </a>
            <a href="#" class="sidebar-item flex items-center p-3">
                <i class="fas fa-question-circle text-lg text-gray-500 w-6"></i>
                <span class="ml-3">Aide</span>
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-item flex items-center p-3 w-full text-left">
                    <i class="fas fa-sign-out-alt text-lg text-gray-500 w-6"></i>
                    <span class="ml-3">Déconnexion</span>
                </button>
            </form>
        </nav>
    </div>

    <!-- Main content -->
    <div id="main-content" class="ml-0 md:ml-64 min-h-screen transition-all duration-300">

        <!-- Mobile header -->
        <header class="bg-white shadow-sm py-4 px-4 md:hidden">
            <div class="flex items-center justify-between">
                <button id="sidebar-toggle" class="text-gray-600 focus:outline-none">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <div class="text-xl font-bold text-indigo-600 flex items-center">
                    <i class="fas fa-heartbeat mr-2"></i>
                    <span>MediDash</span>
                </div>
                <div class="relative">
                    <button class="text-gray-600 focus:outline-none relative">
                        <i class="fas fa-bell text-xl"></i>
                        <span class="notification-badge">{{ $unreadMessagesCount ?? 'N/A'}}</span>
                    </button>
                </div>
            </div>
        </header>

        <!-- Dashboard section -->
        <section id="dashboard-section" class="p-4 md:p-8 dashboard-section active">
            <!-- Header with welcome message and date -->
            <div
                class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl shadow-lg p-6 mb-8 text-white relative overflow-hidden">
                <div
                    class="absolute right-0 top-0 w-40 h-40 bg-white opacity-10 rounded-full transform translate-x-20 -translate-y-20">
                </div>
                <div
                    class="absolute left-20 bottom-0 w-20 h-20 bg-white opacity-10 rounded-full transform -translate-y-10">
                </div>

                <div class="flex flex-col md:flex-row md:items-center md:justify-between relative z-10">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold">Bienvenue, Dr. {{ $details->user->name }}!</h1>
                        <p class="mt-2 flex items-center text-indigo-100">
                            <i class="fas fa-calendar-day mr-2"></i>
                            <span id="current-date-time">{{ $currentDateTime ?? 'N/A' }}</span>
                        </p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <div class="bg-white/20 backdrop-blur-sm rounded-full py-2 px-4 inline-flex items-center">
                            <i class="fas fa-sun mr-2 text-yellow-300"></i>
                            <span>{{ $weather->temperature ?? 'N/A'}}°C • {{ $weather->city ?? 'N/A'}}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap gap-2">
                    <div class="bg-white/20 backdrop-blur-sm rounded-full py-1.5 px-4 flex items-center">
                        <div class="w-2 h-2 bg-amber-400 rounded-full mr-2"></div>
                        <span>{{ count($todayAppointments)  }} rendez-vous aujourd'hui</span>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-full py-1.5 px-4 flex items-center">
                        <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                        <span>{{ $urgentLabResultsCount ?? 'N/A'}} résultats de laboratoire urgents</span>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-full py-1.5 px-4 flex items-center">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                        <span>{{ $unreadMessagesCount ?? 'N/A'}} messages non lus</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4 mb-8">
                <a href="{{ route('doctor.patients.create') }}"
                    class="bg-white rounded-xl shadow-sm p-4 flex flex-col items-center justify-center transition-all duration-300 hover:shadow-md hover:-translate-y-1 cursor-pointer">
                    <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center mb-2">
                        <i class="fas fa-user-plus text-indigo-600 text-xl"></i>
                    </div>
                    <span class="text-sm font-medium">Nouveau Patient</span>
                </a>
                <a href="{{ route('doctor.appointments.create', auth()->user()->id) }}"
                    class="bg-white rounded-xl shadow-sm p-4 flex flex-col items-center justify-center transition-all duration-300 hover:shadow-md hover:-translate-y-1 cursor-pointer">
                    <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center mb-2">
                        <i class="fas fa-calendar-plus text-emerald-600 text-xl"></i>
                    </div>
                    <span class="text-sm font-medium">Nouveau RDV</span>
                </a>
                <a href=""
                    class="bg-white rounded-xl shadow-sm p-4 flex flex-col items-center justify-center transition-all duration-300 hover:shadow-md hover:-translate-y-1 cursor-pointer">
                    <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center mb-2">
                        <i class="fas fa-file-medical text-amber-600 text-xl"></i>
                    </div>
                    <span class="text-sm font-medium">Dossiers</span>
                </a>
                <a href=""
                    class="bg-white rounded-xl shadow-sm p-4 flex flex-col items-center justify-center transition-all duration-300 hover:shadow-md hover:-translate-y-1 cursor-pointer">
                    <div class="w-12 h-12 rounded-full bg-rose-100 flex items-center justify-center mb-2">
                        <i class="fas fa-heartbeat text-rose-600 text-xl"></i>
                    </div>
                    <span class="text-sm font-medium">Signes Vitaux</span>
                </a>
                <a href=""
                    class="bg-white rounded-xl shadow-sm p-4 flex flex-col items-center justify-center transition-all duration-300 hover:shadow-md hover:-translate-y-1 cursor-pointer">
                    <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center mb-2">
                        <i class="fas fa-file-prescription text-purple-600 text-xl"></i>
                    </div>
                    <span class="text-sm font-medium">Ordonnances</span>
                </a>
                <a href=""
                    class="bg-white rounded-xl shadow-sm p-4 flex flex-col items-center justify-center transition-all duration-300 hover:shadow-md hover:-translate-y-1 cursor-pointer">
                    <div class="w-12 h-12 rounded-full bg-sky-100 flex items-center justify-center mb-2">
                        <i class="fas fa-chart-pie text-sky-600 text-xl"></i>
                    </div>
                    <span class="text-sm font-medium">Analyses</span>
                </a>
            </div>

            <!-- Statistics cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 rounded-full bg-indigo-100 text-indigo-600">
                                <i class="fas fa-users text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Patients</dt>
                                    <dd class="flex items-center">
                                        <div class="text-2xl font-semibold text-gray-900" id="patient-counter">
                                            {{ $countPatients }}
                                        </div>
                                        <div class="ml-2 flex items-center text-xs font-medium text-emerald-500">
                                            <i class="fas fa-arrow-up mr-1"></i>
                                            <span>{{ $newPatientsThisMonth ?? 'N/A'}} ce mois</span>
                                        </div>
                                    </dd>
                                </dl>
                                <div class="mt-2">
                                    <div class="progress-bar">
                                        <div class="progress-bar-fill bg-indigo-600" style="width: 75%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3 flex justify-between items-center">
                        <div class="text-sm">
                            <a href="" class="font-medium text-indigo-600 hover:text-indigo-500 flex items-center">
                                Voir les détails
                                <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                        <span class="text-xs text-gray-500">Mis à jour à l'instant</span>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 rounded-full bg-emerald-100 text-emerald-600">
                                <i class="fas fa-calendar-check text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">RDV Aujourd'hui</dt>
                                    <dd class="flex items-center">
                                        <div class="text-2xl font-semibold text-gray-900" id="appointment-counter">
                                            {{ $todayAppointments->count() }}
                                        </div>
                                        <div class="ml-2 flex items-center text-xs font-medium text-emerald-500">
                                            <i class="fas fa-arrow-up mr-1"></i>
                                            <span>{{ $appointmentIncreasePercent ?? 'N/A'}}% vs hier</span>
                                        </div>
                                    </dd>
                                </dl>
                                <div class="mt-2">
                                    <div class="progress-bar">
                                        <div class="progress-bar-fill bg-emerald-600" style="width: 65%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3 flex justify-between items-center">
                        <div class="text-sm">
                            <a href="" class="font-medium text-emerald-600 hover:text-emerald-500 flex items-center">
                                Voir l'agenda
                                <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                        <span class="text-xs text-gray-500">Mises à jour en direct</span>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 rounded-full bg-amber-100 text-amber-600">
                                <i class="fas fa-money-bill-wave text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Revenu Mensuel</dt>
                                    <dd class="flex items-center">
                                        <div class="text-2xl font-semibold text-gray-900">
                                            {{ number_format($monthlyRevenue, 0) }} MAD
                                        </div>
                                        <div class="ml-2 flex items-center text-xs font-medium text-emerald-500">
                                            <i class="fas fa-arrow-up mr-1"></i>
                                            <span>{{ $revenueIncreasePercent }}%</span>
                                        </div>
                                    </dd>
                                </dl>
                                <div class="mt-2">
                                    <div class="progress-bar">
                                        <div class="progress-bar-fill bg-amber-600" style="width: 85%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3 flex justify-between items-center">
                        <div class="text-sm">
                            <a href="" class="font-medium text-amber-600 hover:text-amber-500 flex items-center">
                                Voir les détails
                                <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                        <span class="text-xs text-gray-500">Mis à jour aujourd'hui</span>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 rounded-full bg-rose-100 text-rose-600">
                                <i class="fas fa-smile text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Satisfaction Patients</dt>
                                    <dd class="flex items-center">
                                        <div class="text-2xl font-semibold text-gray-900">
                                            {{ $patientSatisfactionRate }}%
                                        </div>
                                        <div class="ml-2 flex items-center text-xs font-medium text-emerald-500">
                                            <i class="fas fa-arrow-up mr-1"></i>
                                            <span>{{ $satisfactionIncreasePercent }}%</span>
                                        </div>
                                    </dd>
                                </dl>
                                <div class="mt-2">
                                    <div class="progress-bar">
                                        <div class="progress-bar-fill bg-rose-600"
                                            style="width: {{ $patientSatisfactionRate }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3 flex justify-between items-center">
                        <div class="text-sm">
                            <a href="" class="font-medium text-rose-600 hover:text-rose-500 flex items-center">
                                Voir les avis
                                <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                        <span class="text-xs text-gray-500">Basé sur {{ $reviewCount }} avis</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                @if($todayAppointmentsConfirmed != null && $todayAppointmentsConfirmed)
                    <!-- Next appointment (affiché seulement s'il existe un prochain rendez-vous) -->
                    <div class="lg:col-span-2 bg-white rounded-xl shadow-lg overflow-hidden">
                        <div
                            class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white px-6 py-4 flex justify-between items-center">
                            <h2 class="text-xl font-bold flex items-center">
                                <i class="fas fa-star text-yellow-300 mr-2"></i>
                                Prochain Rendez-vous
                            </h2>
                            <div
                                class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium flex items-center">
                                <i class="fas fa-clock mr-1.5"></i>
                                <span id="appointment-countdown">{{ $stats["nextAppointment"] }}</span>
                            </div>
                        </div>
                        <div class="md:flex">
                            <!-- Date column -->
                            <div
                                class="bg-indigo-600 text-white p-4 md:py-6 md:px-8 flex md:flex-col justify-between items-center">
                                <div class="text-center">
                                    <p class="text-indigo-200 text-sm"> Aujourd'hui
                                    </p>
                                    <p class="text-3xl font-bold">{{ $todayAppointmentsConfirmed->time->format('h:i') }}</p>
                                    <p class="text-xs">{{ $todayAppointmentsConfirmed->time->format('A') }}</p>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6 flex-grow">
                                <div class="flex flex-wrap">
                                    <div class="w-full lg:w-2/3">
                                        <div class="flex items-center">
                                            <img class="h-12 w-12 rounded-full mr-4"
                                                src="{{ $todayAppointmentsConfirmed->patient->user->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($nextAppointment->patient->name ?? 'Patient') . '&background=6366F1&color=ffffff' }}"
                                                alt="{{ $todayAppointmentsConfirmed->patient->user->name ?? 'Patient' }}">
                                            <div>
                                                <h3 class="text-lg font-medium text-indigo-700">
                                                    {{ $todayAppointmentsConfirmed->patient->user->name ?? 'Mohammed Alami' }}
                                                </h3>
                                                <div class="flex flex-wrap text-sm text-gray-600">
                                                    <span class="mr-3">{{ $todayAppointmentsConfirmed->patient->user->gender ?? 'Homme' }} •
                                                        {{ $todayAppointmentsConfirmed->patient->user->age ?? '42' }} ans</span>
                                                    <span>Patient ID:
                                                        #{{ $todayAppointmentsConfirmed->patient->id ?? 'MED-12345' }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                            <div>
                                                <p class="text-gray-500">Type de rendez-vous</p>
                                                <p class="font-medium flex items-center mt-1">
                                                    <i class="fas fa-heartbeat text-indigo-500 mr-2"></i>
                                                    {{ $nextAppointment->type ?? 'Contrôle de routine' }}
                                                </p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Médecin</p>
                                                <p class="font-medium flex items-center mt-1">
                                                    <i class="fas fa-user-md text-indigo-500 mr-2"></i>
                                                    Dr. {{ $todayAppointmentsConfirmed->doctor->user->name ?? 'Ahmed El Amrani' }}
                                                </p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Département</p>
                                                <p class="font-medium flex items-center mt-1">
                                                    <i class="fas fa-stethoscope text-indigo-500 mr-2"></i>
                                                    {{$todayAppointmentsConfirmed->doctor->speciality ?? 'test'}}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="mt-4 pt-4 border-t border-gray-100">
                                            <div class="flex items-center text-sm">
                                                <div class="w-24 text-gray-500">Dernière visite:</div>
                                                <div class="font-medium">
                                                    {{ $nextAppointment->patient->last_visit_date ?? '12 Mars 2025' }}
                                                    ({{ $nextAppointment->patient->days_since_last_visit ?? '24' }} jours)
                                                </div>
                                            </div>
                                            <div class="flex items-center text-sm mt-1.5">
                                                <div class="w-24 text-gray-500">Téléphone:</div>
                                                <div class="font-medium">
                                                    {{ $nextAppointment->patient->phone ?? '+212 661-234567' }}
                                                </div>
                                            </div>
                                            <div class="flex items-center text-sm mt-1.5">
                                                <div class="w-24 text-gray-500">Email:</div>
                                                <div class="font-medium">{{ $nextAppointment->patient->email ??
                                                    'm.alami@example.com' }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="w-full lg:w-1/3 mt-4 lg:mt-0 lg:border-l lg:pl-6 border-gray-100">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 border border-green-200">
                                            <span class="w-2 h-2 bg-green-500 rounded-full mr-1.5 pulse"></span>
                                            {{ $nextAppointment->status ?? 'Confirmé' }}
                                        </span>
                                        <div class="mt-4">
                                            <p class="text-sm font-medium text-gray-700">Notes:</p>
                                            <p class="text-sm text-gray-600 mt-1">
                                                {{ $nextAppointment->notes ?? 'Le patient a mentionné des douleurs thoraciques lors de la dernière visite. Suivi de l\'efficacité des médicaments.' }}
                                            </p>
                                        </div>

                                        <div class="mt-6 flex flex-wrap gap-2">
                                            <a href=""
                                                class="flex items-center px-3 py-2 border border-gray-300 text-sm rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                                <i class="fas fa-file-medical text-indigo-500 mr-2"></i>
                                                Dossier médical
                                            </a>
                                            <a href=""
                                                class="flex items-center px-3 py-2 border border-gray-300 text-sm rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                                <i class="fas fa-history text-amber-500 mr-2"></i>
                                                Historique
                                            </a>
                                            <a href=""
                                                class="flex items-center px-3 py-2 border border-transparent text-sm rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                                                <i class="fas fa-check-circle mr-2"></i>
                                                Enregistrer
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Message quand il n'y a pas de rendez-vous aujourd'hui -->
                    <div class="lg:col-span-2 bg-white rounded-xl shadow-lg overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-4 flex items-center">
                            <h2 class="text-xl font-bold flex items-center">
                                <i class="fas fa-calendar-day text-yellow-300 mr-2"></i>
                                Aucun rendez-vous aujourd'hui
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="flex flex-col items-center justify-center py-8">
                                <div class="h-24 w-24 rounded-full bg-blue-50 flex items-center justify-center mb-4">
                                    <i class="fas fa-calendar-check text-blue-500 text-4xl"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Votre journée est libre</h3>
                                <p class="text-gray-500 text-center max-w-md mb-6">
                                    Vous n'avez pas de rendez-vous programmés pour aujourd'hui. Profitez de ce temps pour
                                    gérer vos dossiers médicaux ou planifier vos prochaines consultations.
                                </p>
                                <div class="flex gap-3">
                                    <a href=""
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <i class="fas fa-calendar-alt mr-2"></i>
                                        Voir mon agenda
                                    </a>
                                    <a href="{{ route('doctor.appointments.create', auth()->user()->id) }}"
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <i class="fas fa-user-plus mr-2"></i>
                                        Créer un rendez-vous
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Mini Calendar -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="fas fa-calendar-alt text-indigo-500 mr-2"></i>
                            {{ $currentMonth }} {{ $currentYear }}
                        </h3>
                        <div class="flex items-center space-x-2">
                            <a href="" class="p-1 rounded-full text-gray-400 hover:text-gray-600 hover:bg-gray-100">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                            <a href="" class="text-sm font-medium">Aujourd'hui</a>
                            <a href="" class="p-1 rounded-full text-gray-400 hover:text-gray-600 hover:bg-gray-100">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-7 text-center gap-1 mb-2">
                            <div class="text-xs font-medium text-gray-500">Lun</div>
                            <div class="text-xs font-medium text-gray-500">Mar</div>
                            <div class="text-xs font-medium text-gray-500">Mer</div>
                            <div class="text-xs font-medium text-gray-500">Jeu</div>
                            <div class="text-xs font-medium text-gray-500">Ven</div>
                            <div class="text-xs font-medium text-gray-500">Sam</div>
                            <div class="text-xs font-medium text-gray-500">Dim</div>
                        </div>
                        <div class="grid grid-cols-7 gap-1">
                            @foreach($calendarDays as $day)
                                <div
                                    class="calendar-day {{ $day['isCurrentMonth'] ? '' : 'text-gray-400' }} {{ $day['isToday'] ? 'active' : '' }} {{ $day['hasAppointments'] ? 'has-appointments' : '' }}">
                                    {{ $day['day'] }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50 flex justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-indigo-600 rounded-full mr-1"></div>
                                <span class="text-xs text-gray-600">{{ $stats["totalAppointments"] }} aujourd'hui</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-amber-500 rounded-full mr-1"></div>
                                <span class="text-xs text-gray-600">{{ $tomorrowAppointmentsCount }} demain</span>
                            </div>
                        </div>
                        <a href="" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">Voir tous</a>
                    </div>
                </div>
            </div>

            <!-- Analytics and patient data -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-8">
                <div class="border-b border-gray-200">
                    <nav class="flex">
                        <button class="tab-button active text-indigo-600 py-4 px-6 font-medium text-sm"
                            data-tab="dashboard-analytics">
                            Analyses du tableau de bord
                        </button>
                        <button class="tab-button text-gray-500 hover:text-gray-700 py-4 px-6 font-medium text-sm"
                            data-tab="demographics">
                            Démographie des patients
                        </button>
                        <button class="tab-button text-gray-500 hover:text-gray-700 py-4 px-6 font-medium text-sm"
                            data-tab="revenue">
                            Analyse des revenus
                        </button>
                        <button class="tab-button text-gray-500 hover:text-gray-700 py-4 px-6 font-medium text-sm"
                            data-tab="performance">
                            Performance du personnel
                        </button>
                    </nav>
                </div>

                <div class="p-6">
                    <!-- Tab content -->
                    <div id="dashboard-analytics" class="tab-content block">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Patient Visits Chart -->
                            <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                                    <h3 class="text-lg font-medium text-gray-900">Visites des patients</h3>
                                    <div class="flex space-x-2">
                                        <button
                                            class="px-3 py-1 bg-white border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50 chart-period"
                                            data-period="week">
                                            Semaine
                                        </button>
                                        <button
                                            class="px-3 py-1 bg-indigo-600 border border-indigo-600 rounded-md text-sm text-white hover:bg-indigo-700 chart-period active"
                                            data-period="month">
                                            Mois
                                        </button>
                                        <button
                                            class="px-3 py-1 bg-white border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50 chart-period"
                                            data-period="year">
                                            Année
                                        </button>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <div class="chart-container">
                                        <canvas id="patientVisitsChart"></canvas>
                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-50 text-sm">
                                    <div class="flex justify-between items-center text-gray-600">
                                        <span>Total des visites ce mois: {{ $totalVisitsThisMonth }}</span>
                                        <span class="text-emerald-600 flex items-center font-medium">
                                            <i class="fas fa-arrow-up mr-1"></i> {{ $visitsIncreasePercent }}% vs mois
                                            dernier
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Revenue Distribution Chart -->
                            <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                                    <h3 class="text-lg font-medium text-gray-900">Distribution des revenus</h3>
                                    <div class="flex items-center">
                                        <span class="text-sm text-gray-500 mr-3">{{ $currentMonth }}
                                            {{ $currentYear }}</span>
                                        <button class="flex items-center text-sm text-indigo-600 hover:text-indigo-500"
                                            id="export-revenue">
                                            <i class="fas fa-download mr-1"></i> Exporter
                                        </button>
                                    </div>
                                </div>
                                <div class="p-4">
                                    <div class="chart-container">
                                        <canvas id="revenueChart"></canvas>
                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-50 text-sm">
                                    <div class="flex justify-between items-center text-gray-600">
                                        <span>Revenu total: {{ number_format($totalRevenue, 0) }} MAD</span>
                                        <span class="text-emerald-600 flex items-center font-medium">
                                            <i class="fas fa-arrow-up mr-1"></i> {{ $revenueIncreasePercent }}% vs mois
                                            dernier
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Key performance indicators -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6">
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="text-sm font-medium text-gray-500">Temps d'attente moyen</div>
                                <div class="flex items-end space-x-1 mt-1">
                                    <div class="text-2xl font-semibold">{{ $averageWaitTime }}</div>
                                    <div class="text-sm text-gray-500 mb-1">minutes</div>
                                </div>
                                <div class="mt-2 text-xs flex items-center text-emerald-600">
                                    <i class="fas fa-arrow-down mr-1"></i>
                                    <span>{{ $waitTimeImprovement }}% de moins que l'objectif</span>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="text-sm font-medium text-gray-500">Durée moy. des consultations</div>
                                <div class="flex items-end space-x-1 mt-1">
                                    <div class="text-2xl font-semibold">{{ $averageConsultationTime }}</div>
                                    <div class="text-sm text-gray-500 mb-1">minutes</div>
                                </div>
                                <div class="mt-2 text-xs flex items-center text-amber-600">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    <span>{{ $consultationTimeVariance }}% de plus que l'objectif</span>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="text-sm font-medium text-gray-500">Taux d'absence</div>
                                <div class="flex items-end space-x-1 mt-1">
                                    <div class="text-2xl font-semibold">{{ $noShowRate }}</div>
                                    <div class="text-sm text-gray-500 mb-1">%</div>
                                </div>
                                <div class="mt-2 text-xs flex items-center text-emerald-600">
                                    <i class="fas fa-arrow-down mr-1"></i>
                                    <span>{{ $noShowRateImprovement }}% de moins que le mois dernier</span>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="text-sm font-medium text-gray-500">Réservations en ligne</div>
                                <div class="flex items-end space-x-1 mt-1">
                                    <div class="text-2xl font-semibold">{{ $onlineBookingRate }}</div>
                                    <div class="text-sm text-gray-500 mb-1">%</div>
                                </div>
                                <div class="mt-2 text-xs flex items-center text-emerald-600">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    <span>{{ $onlineBookingImprovement }}% de plus que le mois dernier</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="demographics" class="tab-content hidden">
                        <div class="text-center py-10">
                            <p class="text-gray-500">Contenu de la démographie des patients à venir</p>
                        </div>
                    </div>

                    <div id="revenue" class="tab-content hidden">
                        <div class="text-center py-10">
                            <p class="text-gray-500">Contenu de l'analyse des revenus à venir</p>
                        </div>
                    </div>

                    <div id="performance" class="tab-content hidden">
                        <div class="text-center py-10">
                            <p class="text-gray-500">Contenu de la performance du personnel à venir</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Appointments and activities section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Today's Appointments -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 flex justify-between items-center border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="fas fa-calendar-day text-indigo-500 mr-2"></i>
                            Rendez-vous en attente d'aujourd'hui
                            <span
                                class="ml-2 px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">{{ count($todayAppointments)  }}
                                Total</span>
                        </h3>
                    </div>
                    <div class="max-h-80 overflow-y-auto">
                        <ul class="divide-y divide-gray-200" id="appointments-list">
                            @forelse($todayAppointments as $appointment)
                                <li class="appointment-card" data-status="{{ $appointment->status }}">
                                    <div class="px-6 py-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0">
                                                    <img class="h-10 w-10 rounded-full"
                                                        src="{{ $appointment->patient->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($appointment->patient->name) . '&background=6366F1&color=ffffff' }}"
                                                        alt="{{ $appointment->patient->user->name }}">
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-indigo-600">
                                                        {{ $appointment->patient->name }}
                                                    </p>
                                                    <p class="text-xs text-gray-500">Mr.
                                                        {{ $appointment->patient->user->name }} • {{ $appointment->time }}
                                                    </p>
                                                    <div class="flex items-center mt-1">
                                                        <span
                                                            class="status-indicator status-{{ $appointment->status_class }}"></span>
                                                        <span
                                                            class="text-xs font-medium text-{{ $appointment->status_color }}-800">{{ $appointment->status_label }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex gap-6 bg-gray-50 p-3 rounded-lg">
                                                <span class="text-xs text-gray-500 block">Statut</span>
                                                <span class="text-sm font-medium">
                                                    @if($appointment->status == 'pending')
                                                        <span
                                                            class="px-2 py-1 bg-amber-100 text-amber-800 rounded-full text-xs">{{ $appointment->status }}</span>
                                                    @elseif($appointment->status == 'canceled')
                                                        <span
                                                            class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">{{ $appointment->status }}</span>
                                                    @elseif($appointment->status == 'completed')
                                                        <span
                                                            class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">{{ $appointment->status }}</span>
                                                    @elseif($appointment->status == 'confirmed')
                                                        <span
                                                            class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">{{ $appointment->status }}</span>
                                                    @else
                                                        <span
                                                            class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">{{ $appointment->status }}</span>
                                                    @endif
                                                </span>
                                            </div>
                                            <div class="flex space-x-2">
                                                <a href="{{ route('doctor.appointments.show', $appointment->id) }}"
                                                    class="p-1.5 rounded-full text-indigo-600 hover:bg-indigo-50 transition-colors">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <form
                                                    action="{{ route('doctor.appointments.change-status', $appointment->id) }}"
                                                    method="POST" class="inline-block">
                                                    @csrf
                                                    <input type="hidden" name="status" value="completed">

                                                    <button type="submit"
                                                        class="p-1.5 rounded-full text-green-600 hover:bg-green-50 transition-colors">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form
                                                    action="{{ route('doctor.appointments.change-status', $appointment->id) }}"
                                                    method="POST" class="inline-block">
                                                    @csrf
                                                    <input type="hidden" name="status" value="canceled">
                                                    <button type="submit"
                                                        class="p-1.5 rounded-full text-red-600 hover:bg-red-50 transition-colors cancel-appointment">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="px-6 py-4 text-center text-gray-500">
                                    Aucun rendez-vous pour aujourd'hui
                                </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="bg-gray-50 px-6 py-3 flex justify-between items-center">
                        <span class="text-sm text-gray-700">Affichage de {{ count($todayAppointments) }} rendez-vous sur
                            {{ count($todayAppointments)  }}</span>
                        <a href="" class="text-indigo-600 hover:text-indigo-500 text-sm font-medium">
                            Voir tous les rendez-vous
                        </a>
                    </div>
                </div>

                <!-- Activity tabs -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex space-x-6">
                            <button id="tab-activity" class="tab-button active">
                                Activités
                            </button>
                            <button id="tab-tasks" class="tab-button">
                                Tâches <span
                                    class="ml-1 px-1.5 py-0.5 bg-amber-100 text-amber-700 rounded-full text-xs">{{ $pendingTasksCount ?? 'N/A' }}</span>
                            </button>
                            <button id="tab-messages" class="tab-button">
                                Messages <span
                                    class="ml-1 px-1.5 py-0.5 bg-indigo-100 text-indigo-700 rounded-full text-xs">{{ $unreadMessagesCount ?? 'N/A'}}</span>
                            </button>
                        </div>
                    </div>

                    <!-- Activity tab -->
                    <div id="panel-activity" class="panel max-h-80 overflow-y-auto">
                        <div class="px-6 py-4">
                            <div class="flow-root">
                                <ul class="relative">
                                    @foreach($recentActivities as $activity)
                                        <li class="ml-6 mb-4 relative">
                                            <div
                                                class="absolute top-2.5 left-0 -ml-6 flex items-center justify-center w-5 h-5 bg-{{ $activity->color }}-600 rounded-full">
                                                <i class="fas fa-{{ $activity->icon }} text-white text-xs"></i>
                                            </div>
                                            <div class="ml-2 relative bg-gray-50 p-3 rounded-lg shadow-sm">
                                                <div class="text-sm font-medium text-gray-900">{{ $activity->title }}</div>
                                                <p class="mt-1 text-xs text-gray-500">
                                                    <span
                                                        class="font-medium text-{{ $activity->color }}-600">{{ $activity->highlight }}</span>
                                                    {{ $activity->description }}
                                                </p>
                                                <span
                                                    class="text-xs text-gray-500 mt-1 block">{{ $activity->time_ago }}</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Tasks tab -->
                    <div id="panel-tasks" class="panel max-h-80 overflow-y-auto hidden">
                        <div class="px-6 py-4">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-sm font-medium text-gray-700">Tâches prioritaires</h4>
                                <button class="text-indigo-600 text-sm hover:text-indigo-500" id="add-task-btn">
                                    <i class="fas fa-plus mr-1"></i> Ajouter
                                </button>
                            </div>

                            <div class="space-y-2">
                                @foreach($tasks as $task)
                                    <div class="task-item" data-id="{{ $task->id }}">
                                        <div class="flex items-start">
                                            <div class="task-checkbox flex-shrink-0 mr-3 {{ $task->completed ? 'checked' : '' }}"
                                                data-id="{{ $task->id }}"></div>
                                            <div class="flex-grow">
                                                <div class="task-text {{ $task->completed ? 'checked' : '' }}">
                                                    {{ $task->description }}
                                                </div>
                                                <div
                                                    class="text-xs text-{{ $task->priority_color }} mt-1 flex items-center">
                                                    <i class="fas fa-{{ $task->priority_icon }} mr-1"></i>
                                                    {{ $task->priority_label }} • {{ $task->due_label }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Messages tab -->
                    <div id="panel-messages" class="panel max-h-80 overflow-y-auto hidden">
                        <div class="divide-y divide-gray-200">
                            @foreach($messages as $message)
                                <div class="message-item p-4 cursor-pointer" data-id="{{ $message->id }}">
                                    <div class="flex justify-between items-start">
                                        <div class="flex">
                                            <img class="h-10 w-10 rounded-full"
                                                src="{{ $message->sender->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($message->sender->name) . '&background=4f46e5&color=ffffff' }}"
                                                alt="{{ $message->sender->name }}">
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-gray-900">{{ $message->sender->name }}
                                                </p>
                                                <p class="text-sm text-gray-500 line-clamp-1">{{ $message->preview }}</p>
                                            </div>
                                        </div>
                                        <div class="flex flex-col items-end">
                                            <span class="text-xs text-gray-500">{{ $message->time }}</span>
                                            @if($message->unread_count > 0)
                                                <span
                                                    class="w-5 h-5 bg-indigo-600 rounded-full text-white text-xs flex items-center justify-center mt-1">{{ $message->unread_count }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 flex justify-center">
                            <a href="" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-500">
                                <i class="fas fa-envelope mr-2"></i>
                                Ouvrir la boîte de réception
                            </a>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                        <a href=""
                            class="inline-flex w-full items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm">
                            <i class="fas fa-history mr-2"></i>
                            Voir toute l'activité
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Patients section -->
        <section id="patients-section" class="p-4 md:p-8 dashboard-section hidden">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Gestion des Patients</h1>
                <p class="text-gray-600">Consultez et gérez vos patients, accédez aux dossiers médicaux et suivez les
                    traitements.</p>
            </div>

            <!-- Search & Filters -->
            <div class="bg-white rounded-xl shadow-sm mb-6">
                <div class="p-4 md:p-6">
                    <form action="" method="GET" class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                        <div class="relative flex-grow">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" name="query"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="Rechercher par nom, ID, numéro de téléphone...">
                        </div>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 sm:py-3 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            <i class="fas fa-search mr-2"></i>
                            Rechercher
                        </button>
                    </form>
                </div>
            </div>

            <!-- Patients stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="stats-card-gradient-1 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Total Patients</h3>
                        <div class="bg-white/20 h-10 w-10 rounded-full flex items-center justify-center">
                            <i class="fas fa-users text-white"></i>
                        </div>
                    </div>
                    <div class="text-3xl font-bold mb-1">{{ $countPatients }}</div>
                    <div class="text-sm text-indigo-100">{{ $newPatientsThisMonth }} nouveaux ce mois</div>
                </div>

                <div class="stats-card-gradient-2 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Actifs</h3>
                        <div class="bg-white/20 h-10 w-10 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-check text-white"></i>
                        </div>
                    </div>
                    <div class="text-3xl font-bold mb-1">{{ $activePatientCount }}</div>
                    <div class="text-sm text-emerald-100">{{ $activePatientPercent }}% du total</div>
                </div>

                <div class="stats-card-gradient-3 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Cette semaine</h3>
                        <div class="bg-white/20 h-10 w-10 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-week text-white"></i>
                        </div>
                    </div>
                    <div class="text-3xl font-bold mb-1">{{ $patientsThisWeek }}</div>
                    <div class="text-sm text-orange-100">{{ $patientsWeeklyChangePercent }}% vs sem. dernière</div>
                </div>

                <div class="stats-card-gradient-4 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Contrôles à faire</h3>
                        <div class="bg-white/20 h-10 w-10 rounded-full flex items-center justify-center">
                            <i class="fas fa-clipboard-check text-white"></i>
                        </div>
                    </div>
                    <div class="text-3xl font-bold mb-1">{{ $followUpsCount }}</div>
                    <div class="text-sm text-red-100">{{ $urgentFollowUpsCount }} urgents</div>
                </div>
            </div>

            <!-- Patient listing -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200 flex flex-wrap justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Liste des Patients</h3>
                    <div class="flex items-center space-x-2 mt-2 sm:mt-0">
                        <div class="relative">
                            <select id="patient-sort"
                                class="appearance-none bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:border-indigo-500">
                                <option value="recent">Récents</option>
                                <option value="alphabetical">Alphabétique</option>
                                <option value="last_visit">Dernière visite</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
                    @forelse($appointments as $patient)
                        <div class="patient-card bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                            <div class="px-4 py-4 sm:px-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12 rounded-full overflow-hidden bg-indigo-100">
                                        <img src="{{ $patient->patient->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($patient->name) . '&background=6366F1&color=ffffff' }}"
                                            alt="{{ $patient->patient->name }}">
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h3 class="text-lg font-medium text-indigo-600">
                                                    {{ $patient->patient->user->name }}</h3>
                                                <p class="text-sm text-gray-500">ID: #{{ $patient->patient->id }}</p>
                                            </div>
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $patient->status_color }}-100 text-{{ $patient->status_color }}-800">
                                                <span
                                                    class="w-1.5 h-1.5 bg-{{ $patient->status_color }}-500 rounded-full mr-1.5"></span>
                                                {{ $patient->status_label }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 px-4 py-4 sm:px-6 bg-gray-50">
                                <div class="grid grid-cols-3 gap-2 text-sm">
                                    <div>
                                        <p class="text-gray-500">Âge</p>
                                        <p class="font-medium">{{ $patient->patient->user->age}} ans</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Genre</p>
                                        <p class="font-medium">{{ $patient->patient->user->gender }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Téléphone</p>
                                        <p class="font-medium">{{ $patient->patient->user->phone }}</p>
                                    </div>
                                </div>
                                <div class="mt-3 grid grid-cols-2 gap-2 text-sm">
                                    <div>
                                        <p class="text-gray-500">Dernière visite</p>
                                        <p class="font-medium">{{ $patient->patient->last_visit_date }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Prochain RDV</p>
                                        <p class="font-medium text-indigo-600">{{ $patient->next_appointment }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="px-4 py-3 sm:px-6 flex justify-between border-t border-gray-200">
                                <div class="patient-actions flex space-x-2">
                                    <a href="{{ route('medical-records.show', $patient->id) }}"
                                        class="text-sm text-indigo-600 hover:text-indigo-500">
                                        <i class="fas fa-file-medical"></i>
                                    </a>
                                    <a href="{{ route('doctor.appointments.create', auth()->user()->id) }}"
                                        class="text-sm text-emerald-600 hover:text-emerald-500">
                                        <i class="fas fa-calendar-plus"></i>
                                    </a>
                                    <a href="" class="text-sm text-blue-600 hover:text-blue-500">
                                        <i class="fas fa-comments"></i>
                                    </a>
                                </div>
                                <a href="{{ route('doctor.patients.show', $patient->id) }}"
                                    class="text-sm text-indigo-600 hover:text-indigo-500 font-medium">
                                    Voir détails
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-8 text-gray-500">
                            Aucun patient trouvé
                        </div>
                    @endforelse
                </div>

                <div class="px-6 py-4 bg-gray-50 flex items-center justify-between border-t border-gray-200">
                    @if(method_exists($patients, 'links'))
                        {{ $patients->links() }}
                    @endif
                </div>
            </div>
        </section>

        <!-- Other sections placeholder (hidden by default) -->
        <section id="appointments-section" class="p-4 md:p-8 dashboard-section hidden">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Gestion des Rendez-vous</h1>
            <!-- Appointments content would go here -->
            <div class="bg-white rounded-xl shadow-sm mb-8"></div>
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 text-white px-6 py-4 rounded-t-xl">
                <h2 class="text-xl font-bold flex items-center">
                    <i class="fas fa-calendar-check text-yellow-300 mr-2"></i>
                    Gestion des Rendez-vous
                </h2>
            </div>

            <!-- Search & Filters -->
            <div class="p-4 md:p-6 border-b border-gray-200">
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                    <div class="relative flex-grow">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" id="appointment-search"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            placeholder="Rechercher un rendez-vous par patient, date...">
                    </div>
                    <div class="flex space-x-2">
                        <select id="appointment-status-filter"
                            class="border border-gray-300 rounded-lg shadow-sm py-2 px-3 sm:text-sm">
                            <option value="all">Tous les statuts</option>
                            <option value="confirmed">Confirmés</option>
                            <option value="pending">En attente</option>
                            <option value="completed">Terminés</option>
                            <option value="canceled">Annulés</option>
                        </select>
                    </div>
                    <a href="{{ route('doctor.appointments.create', auth()->user()->id) }}"
                        class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none">
                        <i class="fas fa-plus mr-2"></i>
                        Nouveau RDV
                    </a>
                </div>
            </div>

            <!-- Appointments List -->
            <div class="overflow-hidden">
                <ul class="divide-y divide-gray-200" id="appointments-list">
                    @if (count($appointments) > 0)
                        @foreach($appointments as $appointment)
                            <li class="appointment-card p-5" data-status="{{ $appointment->status }}">
                                <div class="flex flex-col md:flex-row md:items-center">
                                    <!-- Time Column -->
                                    <div class="md:w-1/6 mb-4 md:mb-0">
                                        <div class="text-center p-3 bg-indigo-50 rounded-lg">
                                            <p class="text-xs text-indigo-600 font-medium">{{ $appointment->formatted_date }}
                                            </p>
                                            <p class="text-xl font-bold text-indigo-700">{{ $appointment->formatted_time }}</p>
                                            <p class="text-xs text-indigo-500">Durée: {{ $appointment->duration ?? '30' }} min
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Patient Info -->
                                    <div class="md:w-2/6 md:px-4">
                                        <div class="flex items-center">
                                            <div>
                                                <h3 class="text-md font-medium text-gray-800">
                                                    {{ $appointment->patient->user->name}}
                                                </h3>
                                                <div class="text-sm text-gray-500">
                                                    ID: {{ $appointment->patient->id }} |
                                                    {{ $appointment->patient->age ?? '?' }} ans
                                                </div>
                                                <div class="flex items-center mt-1">
                                                    <span
                                                        class="status-indicator status-{{ $appointment->status_class }}"></span>
                                                    <span class="text-xs font-medium text-{{ $appointment->status_color }}-800">
                                                        {{ $appointment->status_label }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Appointment Details -->
                                    <div class="md:w-2/6 mt-4 md:mt-0 md:px-4">
                                        <div class="grid grid-cols-2 gap-2 text-sm">
                                            <div>
                                                <p class="text-gray-500">Type</p>
                                                <p class="font-medium">
                                                    <i class="fas fa-stethoscope text-indigo-500 mr-1"></i>
                                                    {{ $appointment->type ?? 'Consultation' }}
                                                </p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Salle</p>
                                                <p class="font-medium">
                                                    <i class="fas fa-door-open text-emerald-500 mr-1"></i>
                                                    {{ $appointment->room ?? 'Non assignée' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <p class="text-gray-500 text-sm">Notes</p>
                                            <p class="text-sm text-gray-700 truncate">
                                                {{ $appointment->notes ?? 'Aucune note disponible' }}
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="md:w-1/6 flex md:justify-end mt-4 md:mt-0 space-x-2">
                                        <a href="{{ route('doctor.appointments.show', $appointment->id) }}"
                                            class="p-2 bg-indigo-50 text-indigo-600 rounded-full hover:bg-indigo-100 transition-colors">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($appointment->status !== 'completed')
                                            <form action="{{ route('doctor.appointments.change-status', $appointment->id) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit"
                                                    class="p-2 bg-green-50 text-green-600 rounded-full hover:bg-green-100 transition-colors">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                        @if($appointment->status !== 'canceled')
                                            <form action="{{ route('doctor.appointments.change-status', $appointment->id) }}"
                                                method="POST" class="inline-block">
                                                @csrf
                                                <input type="hidden" name="status" value="canceled">
                                                <button type="submit"
                                                    class="p-2 bg-red-50 text-red-600 rounded-full hover:bg-red-100 transition-colors">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @else
                        <li class="p-8 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                    <i class="fas fa-calendar-day text-gray-400 text-xl"></i>
                                </div>
                                <p>Aucun rendez-vous trouvé</p>
                                <a href="{{ route('doctor.appointments.create',auth()->user()->id) }}"
                                    class="mt-3 text-indigo-600 hover:text-indigo-800">
                                    + Créer un nouveau rendez-vous
                                </a>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="bg-gray-50 px-6 py-4 flex justify-between items-center rounded-b-xl border-t border-gray-200">
                <div class="text-sm text-gray-600">
                    Affichage de {{ count($todayAppointments) }} rendez-vous
                </div>
                <a href="" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                    Voir tous les rendez-vous <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
    </div>
    </section>

    <section id="medical-records-section" class="p-4 md:p-8 dashboard-section hidden">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Dossiers Médicaux</h1>
        <!-- Medical records content would go here -->
        <div class="bg-white p-10 rounded-xl shadow-sm text-center">
            <p class="text-gray-500">Section en cours de développement</p>
        </div>
    </section>

    <section id="analytics-section" class="p-4 md:p-8 dashboard-section hidden">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Analyses et Statistiques</h1>
        <!-- Analytics content would go here -->
        <div class="bg-white p-10 rounded-xl shadow-sm text-center">
            <p class="text-gray-500">Section en cours de développement</p>
        </div>
    </section>

    <section id="communications-section" class="p-4 md:p-8 dashboard-section hidden">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Communications</h1>
        <!-- Communications content would go here -->
        <div class="bg-white p-10 rounded-xl shadow-sm text-center">
            <p class="text-gray-500">Section en cours de développement</p>
        </div>
    </section>

    <section id="tasks-section" class="p-4 md:p-8 dashboard-section hidden">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Gestion des Tâches</h1>
        <!-- Tasks content would go here -->
        <div class="bg-white p-10 rounded-xl shadow-sm text-center">
            <p class="text-gray-500">Section en cours de développement</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white p-4 border-t border-gray-200 text-center md:text-left text-sm text-gray-600">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row md:justify-between items-center">
                <div class="mb-4 md:mb-0">
                    &copy; {{ date('Y') }} MediDash. Tous droits réservés.
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-500 hover:text-indigo-600">Confidentialité</a>
                    <a href="#" class="text-gray-500 hover:text-indigo-600">Conditions</a>
                    <a href="#" class="text-gray-500 hover:text-indigo-600">Aide</a>
                </div>
            </div>
        </div>
    </footer>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function updateDateTime() {
                const now = new Date();
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const dateTimeElement = document.getElementById('current-date-time');
                if (dateTimeElement) {
                    dateTimeElement.textContent = now.toLocaleDateString('fr-FR', options) + ' | ' +
                        now.toLocaleTimeString('fr-FR');
                }
            }
            updateDateTime();
            setInterval(updateDateTime, 1000);

            const sidebarToggle = document.getElementById("sidebar-toggle");
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("overlay");

            if (sidebarToggle && sidebar && overlay) {
                sidebarToggle.addEventListener("click", function () {
                    sidebar.classList.toggle("open");
                    overlay.classList.toggle("active");
                });

                overlay.addEventListener("click", function () {
                    sidebar.classList.remove("open");
                    overlay.classList.remove("active");
                });
            }

            const sidebarItems = document.querySelectorAll(".sidebar-item");
            const sections = document.querySelectorAll(".dashboard-section");

            sidebarItems.forEach(item => {
                item.addEventListener("click", function (e) {
                    if (this.getAttribute("href").startsWith("#")) {
                        e.preventDefault();
                        const targetSection = this.getAttribute("data-section");
                        sidebarItems.forEach(i => i.classList.remove("active"));
                        this.classList.add("active");

                        sections.forEach(section => {
                            if (section.id === targetSection + "-section") {
                                section.classList.remove("hidden");
                                section.classList.add("active");
                            } else {
                                section.classList.add("hidden");
                                section.classList.remove("active");
                            }
                        });

                        if (window.innerWidth < 768) {
                            sidebar.classList.remove("open");
                            overlay.classList.remove("active");
                        }
                    }
                });
            });

            const tabButtons = document.querySelectorAll(".tab-button");
            tabButtons.forEach(button => {
                button.addEventListener("click", function () {
                    const tabId = this.getAttribute("id") || this.getAttribute("data-tab");
                    const tabGroup = this.closest("div").querySelectorAll(".tab-button");
                    const panels = document.querySelectorAll(".panel");
                    tabGroup.forEach(tab => tab.classList.remove("active"));
                    this.classList.add("active");
                    panels.forEach(panel => panel.classList.add("hidden"));

                    if (tabId === "tab-activity") {
                        document.getElementById("panel-activity").classList.remove("hidden");
                    } else if (tabId === "tab-tasks") {
                        document.getElementById("panel-tasks").classList.remove("hidden");
                    } else if (tabId === "tab-messages") {
                        document.getElementById("panel-messages").classList.remove("hidden");
                    } else if (tabId === "dashboard-analytics" || tabId === "demographics" || tabId === "revenue" || tabId === "performance") {
                        document.querySelectorAll(".tab-content").forEach(content => {
                            content.classList.add("hidden");
                        });
                        document.getElementById(tabId).classList.remove("hidden");
                    }
                });
            });

            const taskCheckboxes = document.querySelectorAll(".task-checkbox");
            taskCheckboxes.forEach(checkbox => {
                checkbox.addEventListener("click", function () {
                    const taskId = this.getAttribute("data-id");
                    this.classList.toggle("checked");
                    const taskText = this.closest(".task-item").querySelector(".task-text");
                    taskText.classList.toggle("checked");

                    fetch(`/api/tasks/${taskId}/toggle`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            console.log('Task updated:', data);
                        })
                        .catch(error => {
                            console.error('Error updating task:', error);
                        });
                });
            });

            const statusFilter = document.getElementById("appointment-status-filter");
            if (statusFilter) {
                statusFilter.addEventListener("change", function () {
                    const status = this.value;
                    const appointments = document.querySelectorAll(".appointment-card");

                    appointments.forEach(appointment => {
                        if (status === "all" || appointment.getAttribute("data-status") === status) {
                            appointment.style.display = "block";
                        } else {
                            appointment.style.display = "none";
                        }
                    });
                });
            }

            const patientSort = document.getElementById("patient-sort");
            if (patientSort) {
                patientSort.addEventListener("change", function () {
                    const sortBy = this.value;
                    window.location.href = ``;
                });
            }
            initializeCharts();

            const addTaskBtn = document.getElementById("add-task-btn");
            if (addTaskBtn) {
                addTaskBtn.addEventListener("click", function () {
                    const taskDescription = prompt("Entrez la description de la tâche:");
                    if (taskDescription) {
                        fetch('/api/tasks', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                description: taskDescription,
                                priority: 'medium',
                                due_date: new Date().toISOString().split('T')[0]
                            })
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    window.location.reload();
                                } else {
                                    alert("Erreur lors de l'ajout de la tâche");
                                }
                            })
                            .catch(error => {
                                console.error('Error adding task:', error);
                            });
                    }
                });
            }

            const exportRevenueBtn = document.getElementById("export-revenue");
            if (exportRevenueBtn) {
                exportRevenueBtn.addEventListener("click", function () {
                    window.location.href = "";
                });
            }

            const chartPeriodBtns = document.querySelectorAll(".chart-period");
            chartPeriodBtns.forEach(btn => {
                btn.addEventListener("click", function () {
                    const period = this.getAttribute("data-period");
                    chartPeriodBtns.forEach(b => {
                        b.classList.remove("active", "bg-indigo-600", "text-white");
                        b.classList.add("bg-white", "text-gray-700");
                    });

                    this.classList.add("active", "bg-indigo-600", "text-white");
                    this.classList.remove("bg-white", "text-gray-700");

                    fetch(`/api/analytics/patient-visits?period=${period}`)
                        .then(response => response.json())
                        .then(data => {
                            updatePatientVisitsChart(data);
                        })
                        .catch(error => {
                            console.error('Error fetching chart data:', error);
                        });
                });
            });
        });

        function initializeCharts() {
            const patientVisitsCtx = document.getElementById('patientVisitsChart');
            if (patientVisitsCtx) {
                const patientVisitsChart = new Chart(patientVisitsCtx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($visitsChartLabels) !!},
                        datasets: [{
                            label: 'Visites',
                            data: {!! json_encode($visitsChartData) !!},
                            backgroundColor: 'rgba(99, 102, 241, 0.2)',
                            borderColor: 'rgba(99, 102, 241, 1)',
                            borderWidth: 2,
                            tension: 0.3,
                            pointBackgroundColor: 'rgba(99, 102, 241, 1)',
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                backgroundColor: 'rgba(255, 255, 255, 0.9)',
                                titleColor: '#1F2937',
                                bodyColor: '#4B5563',
                                borderColor: '#E5E7EB',
                                borderWidth: 1,
                                padding: 10,
                                boxPadding: 5,
                                usePointStyle: true,
                                callbacks: {
                                    label: function (context) {
                                        return `Visites: ${context.parsed.y}`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: 'rgba(229, 231, 235, 0.5)'
                                },
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });

                window.patientVisitsChart = patientVisitsChart;
            }

            const revenueCtx = document.getElementById('revenueChart');
            if (revenueCtx) {
                const revenueChart = new Chart(revenueCtx, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($revenueChartLabels) !!},
                        datasets: [{
                            data: {!! json_encode($revenueChartData) !!},
                            backgroundColor: [
                                'rgba(99, 102, 241, 0.8)',
                                'rgba(16, 185, 129, 0.8)',
                                'rgba(249, 115, 22, 0.8)',
                                'rgba(239, 68, 68, 0.8)',
                                'rgba(139, 92, 246, 0.8)'
                            ],
                            borderColor: 'white',
                            borderWidth: 2,
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    padding: 15,
                                    font: {
                                        size: 12
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(255, 255, 255, 0.9)',
                                titleColor: '#1F2937',
                                bodyColor: '#4B5563',
                                borderColor: '#E5E7EB',
                                borderWidth: 1,
                                padding: 10,
                                boxPadding: 5,
                                usePointStyle: true,
                                callbacks: {
                                    label: function (context) {
                                        const value = context.parsed;
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = Math.round((value / total) * 100);
                                        return `${context.label}: ${value} MAD (${percentage}%)`;
                                    }
                                }
                            }
                        },
                        cutout: '65%'
                    }
                });

                window.revenueChart = revenueChart;
            }
        }

        function updatePatientVisitsChart(data) {
            if (window.patientVisitsChart) {
                window.patientVisitsChart.data.labels = data.labels;
                window.patientVisitsChart.data.datasets[0].data = data.values;
                window.patientVisitsChart.update();

                const totalVisitsElement = document.querySelector('.text-gray-600:contains("Total des visites")');
                if (totalVisitsElement) {
                    totalVisitsElement.textContent = `Total des visites: ${data.total}`;
                }
            }
        }
    </script>
</body>

</html>