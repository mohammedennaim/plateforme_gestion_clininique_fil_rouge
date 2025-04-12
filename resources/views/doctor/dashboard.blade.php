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
    <!-- <style>
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
    </style> -->
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
                <h2 class="text-lg font-semibold">Dr. {{ $doctor->name }}</h2>
                <p class="text-sm text-gray-500">Cardiologue</p>
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
                    class="ml-auto bg-indigo-100 text-indigo-600 rounded-full px-2 py-0.5 text-xs font-medium">{{ $patients_count }}</span>
            </a>
            <a href="#" class="sidebar-item flex items-center p-3" data-section="appointments">
                <i class="fas fa-calendar-alt text-lg text-gray-500 w-6"></i>
                <span class="ml-3">Rendez-vous</span>
                <span
                    class="ml-auto bg-amber-100 text-amber-600 rounded-full px-2 py-0.5 text-xs font-medium">{{ $appointments_count }}</span>
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
                    <span class="notification-badge">7</span>
                </div>
            </a>

            <a href="#tab-tasks" class="sidebar-item flex items-center p-3" data-section="tasks">
                <i class="fas fa-tasks text-lg text-gray-500 w-6"></i>
                <span class="ml-3">Tâches</span>
                <span class="ml-auto bg-red-100 text-red-600 rounded-full px-2 py-0.5 text-xs font-medium">5</span>
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


            <!-- <form action="/logout" method="post" >
                @csrf
                <button type="submit" class="sidebar-item flex items-center p-3 mb-10 w-full text-left">
                    <i class="fas fa-sign-out-alt text-lg text-gray-500 w-6"></i>
                    <span class="ml-3">Déconnexion</span>
                </button>
            </form> -->
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
                        <span class="notification-badge">7</span>
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
                        <h1 class="text-2xl md:text-3xl font-bold">Bienvenue, Dr. {{ $doctor->name }}!</h1>
                        <p class="mt-2 flex items-center text-indigo-100">
                            <i class="fas fa-calendar-day mr-2"></i>
                            <span id="current-date-time">Samedi, 5 Avril 2025 | 08:49:54</span>
                        </p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <div class="bg-white/20 backdrop-blur-sm rounded-full py-2 px-4 inline-flex items-center">
                            <i class="fas fa-sun mr-2 text-yellow-300"></i>
                            <span>24°C • Casablanca</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex flex-wrap gap-2">
                    <div class="bg-white/20 backdrop-blur-sm rounded-full py-1.5 px-4 flex items-center">
                        <div class="w-2 h-2 bg-amber-400 rounded-full mr-2"></div>
                        <span>{{ $appointments_count }} rendez-vous aujourd'hui</span>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-full py-1.5 px-4 flex items-center">
                        <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                        <span>3 résultats de laboratoire urgents</span>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm rounded-full py-1.5 px-4 flex items-center">
                        <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                        <span>12 messages non lus</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4 mb-8">
                <div
                    class="bg-white rounded-xl shadow-sm p-4 flex flex-col items-center justify-center transition-all duration-300 hover:shadow-md hover:-translate-y-1 cursor-pointer">
                    <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center mb-2">
                        <i class="fas fa-user-plus text-indigo-600 text-xl"></i>
                    </div>
                    <span class="text-sm font-medium">Nouveau Patient</span>
                </div>
                <div
                    class="bg-white rounded-xl shadow-sm p-4 flex flex-col items-center justify-center transition-all duration-300 hover:shadow-md hover:-translate-y-1 cursor-pointer">
                    <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center mb-2">
                        <i class="fas fa-calendar-plus text-emerald-600 text-xl"></i>
                    </div>
                    <span class="text-sm font-medium">Nouveau RDV</span>
                </div>
                <div
                    class="bg-white rounded-xl shadow-sm p-4 flex flex-col items-center justify-center transition-all duration-300 hover:shadow-md hover:-translate-y-1 cursor-pointer">
                    <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center mb-2">
                        <i class="fas fa-file-medical text-amber-600 text-xl"></i>
                    </div>
                    <span class="text-sm font-medium">Dossiers</span>
                </div>
                <div
                    class="bg-white rounded-xl shadow-sm p-4 flex flex-col items-center justify-center transition-all duration-300 hover:shadow-md hover:-translate-y-1 cursor-pointer">
                    <div class="w-12 h-12 rounded-full bg-rose-100 flex items-center justify-center mb-2">
                        <i class="fas fa-heartbeat text-rose-600 text-xl"></i>
                    </div>
                    <span class="text-sm font-medium">Signes Vitaux</span>
                </div>
                <div
                    class="bg-white rounded-xl shadow-sm p-4 flex flex-col items-center justify-center transition-all duration-300 hover:shadow-md hover:-translate-y-1 cursor-pointer">
                    <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center mb-2">
                        <i class="fas fa-file-prescription text-purple-600 text-xl"></i>
                    </div>
                    <span class="text-sm font-medium">Ordonnances</span>
                </div>
                <div
                    class="bg-white rounded-xl shadow-sm p-4 flex flex-col items-center justify-center transition-all duration-300 hover:shadow-md hover:-translate-y-1 cursor-pointer">
                    <div class="w-12 h-12 rounded-full bg-sky-100 flex items-center justify-center mb-2">
                        <i class="fas fa-chart-pie text-sky-600 text-xl"></i>
                    </div>
                    <span class="text-sm font-medium">Analyses</span>
                </div>
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
                                            {{ $patients_count }}</div>
                                        <div class="ml-2 flex items-center text-xs font-medium text-emerald-500">
                                            <i class="fas fa-arrow-up mr-1"></i>
                                            <span>8 ce mois</span>
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
                            <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500 flex items-center">
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
                                        <div class="text-2xl font-semibold text-gray-900" id="appointment-counter">32
                                        </div>
                                        <div class="ml-2 flex items-center text-xs font-medium text-emerald-500">
                                            <i class="fas fa-arrow-up mr-1"></i>
                                            <span>14% vs hier</span>
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
                            <a href="#" class="font-medium text-emerald-600 hover:text-emerald-500 flex items-center">
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
                                        <div class="text-2xl font-semibold text-gray-900">28 MAD</div>
                                        <div class="ml-2 flex items-center text-xs font-medium text-emerald-500">
                                            <i class="fas fa-arrow-up mr-1"></i>
                                            <span>12%</span>
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
                            <a href="#" class="font-medium text-amber-600 hover:text-amber-500 flex items-center">
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
                                        <div class="text-2xl font-semibold text-gray-900">92%</div>
                                        <div class="ml-2 flex items-center text-xs font-medium text-emerald-500">
                                            <i class="fas fa-arrow-up mr-1"></i>
                                            <span>3%</span>
                                        </div>
                                    </dd>
                                </dl>
                                <div class="mt-2">
                                    <div class="progress-bar">
                                        <div class="progress-bar-fill bg-rose-600" style="width: 92%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3 flex justify-between items-center">
                        <div class="text-sm">
                            <a href="#" class="font-medium text-rose-600 hover:text-rose-500 flex items-center">
                                Voir les avis
                                <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                        <span class="text-xs text-gray-500">Basé sur 120 avis</span>
                    </div>
                </div>
            </div>

            <!-- Next appointment & Calendar -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Next appointment -->
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
                            <span id="appointment-countdown">Dans 40 minutes</span>
                        </div>
                    </div>
                    <div class="md:flex">
                        <!-- Date column -->
                        <div
                            class="bg-indigo-600 text-white p-4 md:py-6 md:px-8 flex md:flex-col justify-between items-center">
                            <div class="text-center">
                                <p class="text-indigo-200 text-sm">Aujourd'hui</p>
                                <p class="text-3xl font-bold">09:30</p>
                                <p class="text-xs">AM</p>
                            </div>
                            <div class="md:mt-4 text-center">
                                <span class="px-2 py-1 bg-indigo-700 rounded-lg text-xs">Salle 204</span>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6 flex-grow">
                            <div class="flex flex-wrap">
                                <div class="w-full lg:w-2/3">
                                    <div class="flex items-center">
                                        <img class="h-12 w-12 rounded-full mr-4"
                                            src="https://ui-avatars.com/api/?name=Mohammed+Alami&background=6366F1&color=ffffff"
                                            alt="Patient">
                                        <div>
                                            <h3 class="text-lg font-medium text-indigo-700">Mohammed Alami</h3>
                                            <div class="flex flex-wrap text-sm text-gray-600">
                                                <span class="mr-3">Homme • 42 ans</span>
                                                <span>Patient ID: #MED-12345</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                        <div>
                                            <p class="text-gray-500">Type de rendez-vous</p>
                                            <p class="font-medium flex items-center mt-1">
                                                <i class="fas fa-heartbeat text-indigo-500 mr-2"></i>
                                                Contrôle de routine
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Médecin</p>
                                            <p class="font-medium flex items-center mt-1">
                                                <i class="fas fa-user-md text-indigo-500 mr-2"></i>
                                                Dr. {{ $doctor->name }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-gray-500">Département</p>
                                            <p class="font-medium flex items-center mt-1">
                                                <i class="fas fa-stethoscope text-indigo-500 mr-2"></i>
                                                Cardiologie
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <div class="flex items-center text-sm">
                                            <div class="w-24 text-gray-500">Dernière visite:</div>
                                            <div class="font-medium">12 Mars 2025 (24 jours)</div>
                                        </div>
                                        <div class="flex items-center text-sm mt-1.5">
                                            <div class="w-24 text-gray-500">Téléphone:</div>
                                            <div class="font-medium">+212 661-234567</div>
                                        </div>
                                        <div class="flex items-center text-sm mt-1.5">
                                            <div class="w-24 text-gray-500">Email:</div>
                                            <div class="font-medium">m.alami@example.com</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="w-full lg:w-1/3 mt-4 lg:mt-0 lg:border-l lg:pl-6 border-gray-100">
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 border border-green-200">
                                        <span class="w-2 h-2 bg-green-500 rounded-full mr-1.5 pulse"></span>
                                        Confirmé
                                    </span>
                                    <div class="mt-4">
                                        <p class="text-sm font-medium text-gray-700">Notes:</p>
                                        <p class="text-sm text-gray-600 mt-1">Le patient a mentionné des douleurs
                                            thoraciques lors de la dernière visite. Suivi de l'efficacité des
                                            médicaments.</p>
                                    </div>

                                    <div class="mt-6 flex flex-wrap gap-2">
                                        <button
                                            class="flex items-center px-3 py-2 border border-gray-300 text-sm rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                            <i class="fas fa-file-medical text-indigo-500 mr-2"></i>
                                            Dossier médical
                                        </button>
                                        <button
                                            class="flex items-center px-3 py-2 border border-gray-300 text-sm rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                            <i class="fas fa-history text-amber-500 mr-2"></i>
                                            Historique
                                        </button>
                                        <button
                                            class="flex items-center px-3 py-2 border border-transparent text-sm rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition-colors">
                                            <i class="fas fa-check-circle mr-2"></i>
                                            Enregistrer
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mini Calendar -->
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900 flex items-center">
                            <i class="fas fa-calendar-alt text-indigo-500 mr-2"></i>
                            Avril 2025
                        </h3>
                        <div class="flex items-center space-x-2">
                            <button class="p-1 rounded-full text-gray-400 hover:text-gray-600 hover:bg-gray-100">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <span class="text-sm font-medium">Aujourd'hui</span>
                            <button class="p-1 rounded-full text-gray-400 hover:text-gray-600 hover:bg-gray-100">
                                <i class="fas fa-chevron-right"></i>
                            </button>
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
                            <!-- Week 1 -->
                            <div class="calendar-day text-gray-400">31</div>
                            <div class="calendar-day">1</div>
                            <div class="calendar-day">2</div>
                            <div class="calendar-day has-appointments">3</div>
                            <div class="calendar-day has-appointments">4</div>
                            <div class="calendar-day active has-appointments">5</div>
                            <div class="calendar-day">6</div>

                            <!-- Week 2 -->
                            <div class="calendar-day">7</div>
                            <div class="calendar-day has-appointments">8</div>
                            <div class="calendar-day">9</div>
                            <div class="calendar-day has-appointments">10</div>
                            <div class="calendar-day">11</div>
                            <div class="calendar-day">12</div>
                            <div class="calendar-day">13</div>

                            <!-- Week 3 -->
                            <div class="calendar-day has-appointments">14</div>
                            <div class="calendar-day has-appointments">15</div>
                            <div class="calendar-day">16</div>
                            <div class="calendar-day has-appointments">17</div>
                            <div class="calendar-day">18</div>
                            <div class="calendar-day has-appointments">19</div>
                            <div class="calendar-day">20</div>

                            <!-- Week 4 -->
                            <div class="calendar-day">21</div>
                            <div class="calendar-day has-appointments">22</div>
                            <div class="calendar-day">23</div>
                            <div class="calendar-day has-appointments">24</div>
                            <div class="calendar-day">25</div>
                            <div class="calendar-day">26</div>
                            <div class="calendar-day">27</div>

                            <!-- Week 5 -->
                            <div class="calendar-day">28</div>
                            <div class="calendar-day has-appointments">29</div>
                            <div class="calendar-day">30</div>
                            <div class="calendar-day text-gray-400">1</div>
                            <div class="calendar-day text-gray-400">2</div>
                            <div class="calendar-day text-gray-400">3</div>
                            <div class="calendar-day text-gray-400">4</div>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50 flex justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-indigo-600 rounded-full mr-1"></div>
                                <span class="text-xs text-gray-600">8 aujourd'hui</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-amber-500 rounded-full mr-1"></div>
                                <span class="text-xs text-gray-600">5 demain</span>
                            </div>
                        </div>
                        <a href="#" class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">Voir tous</a>
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
                                            class="px-3 py-1 bg-white border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50">
                                            Semaine
                                        </button>
                                        <button
                                            class="px-3 py-1 bg-indigo-600 border border-indigo-600 rounded-md text-sm text-white hover:bg-indigo-700">
                                            Mois
                                        </button>
                                        <button
                                            class="px-3 py-1 bg-white border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-50">
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
                                        <span>Total des visites ce mois: 412</span>
                                        <span class="text-emerald-600 flex items-center font-medium">
                                            <i class="fas fa-arrow-up mr-1"></i> 14% vs mois dernier
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Revenue Distribution Chart -->
                            <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                                    <h3 class="text-lg font-medium text-gray-900">Distribution des revenus</h3>
                                    <div class="flex items-center">
                                        <span class="text-sm text-gray-500 mr-3">Avril 2025</span>
                                        <button class="flex items-center text-sm text-indigo-600 hover:text-indigo-500">
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
                                        <span>Revenu total: 28 350 MAD</span>
                                        <span class="text-emerald-600 flex items-center font-medium">
                                            <i class="fas fa-arrow-up mr-1"></i> 12% vs mois dernier
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
                                    <div class="text-2xl font-semibold">18</div>
                                    <div class="text-sm text-gray-500 mb-1">minutes</div>
                                </div>
                                <div class="mt-2 text-xs flex items-center text-emerald-600">
                                    <i class="fas fa-arrow-down mr-1"></i>
                                    <span>12% de moins que l'objectif</span>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="text-sm font-medium text-gray-500">Durée moy. des consultations</div>
                                <div class="flex items-end space-x-1 mt-1">
                                    <div class="text-2xl font-semibold">24</div>
                                    <div class="text-sm text-gray-500 mb-1">minutes</div>
                                </div>
                                <div class="mt-2 text-xs flex items-center text-amber-600">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    <span>5% de plus que l'objectif</span>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="text-sm font-medium text-gray-500">Taux d'absence</div>
                                <div class="flex items-end space-x-1 mt-1">
                                    <div class="text-2xl font-semibold">8.3</div>
                                    <div class="text-sm text-gray-500 mb-1">%</div>
                                </div>
                                <div class="mt-2 text-xs flex items-center text-emerald-600">
                                    <i class="fas fa-arrow-down mr-1"></i>
                                    <span>2.1% de moins que le mois dernier</span>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="text-sm font-medium text-gray-500">Réservations en ligne</div>
                                <div class="flex items-end space-x-1 mt-1">
                                    <div class="text-2xl font-semibold">64</div>
                                    <div class="text-sm text-gray-500 mb-1">%</div>
                                </div>
                                <div class="mt-2 text-xs flex items-center text-emerald-600">
                                    <i class="fas fa-arrow-up mr-1"></i>
                                    <span>8% de plus que le mois dernier</span>
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
                            Rendez-vous d'aujourd'hui
                            <span
                                class="ml-2 px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">32
                                Total</span>
                        </h3>
                        <div>
                            <select
                                class="text-sm border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500">
                                <option>Tous les statuts</option>
                                <option>Confirmés</option>
                                <option>En attente</option>
                                <option>Terminés</option>
                                <option>Annulés</option>
                            </select>
                        </div>
                    </div>
                    <div class="max-h-80 overflow-y-auto">
                        <ul class="divide-y divide-gray-200">
                            <li class="appointment-card">
                                <div class="px-6 py-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <img class="h-10 w-10 rounded-full"
                                                    src="https://ui-avatars.com/api/?name=Mohammed+Alami&background=6366F1&color=ffffff"
                                                    alt="Patient">
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-indigo-600">Mohammed Alami</p>
                                                <p class="text-xs text-gray-500">Dr. Ahmed Lahlou • 09:30 AM</p>
                                                <div class="flex items-center mt-1">
                                                    <span class="status-indicator status-confirmed"></span>
                                                    <span class="text-xs font-medium text-green-800">Confirmé</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button
                                                class="p-1.5 rounded-full text-indigo-600 hover:bg-indigo-50 transition-colors">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button
                                                class="p-1.5 rounded-full text-green-600 hover:bg-green-50 transition-colors">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button
                                                class="p-1.5 rounded-full text-red-600 hover:bg-red-50 transition-colors">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="appointment-card">
                                <div class="px-6 py-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <img class="h-10 w-10 rounded-full"
                                                    src="https://ui-avatars.com/api/?name=Fatima+Zahra&background=6366F1&color=ffffff"
                                                    alt="Patient">
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-indigo-600">Fatima Zahra</p>
                                                <p class="text-xs text-gray-500">Dr. Leila Bouzidi • 11:00 AM</p>
                                                <div class="flex items-center mt-1">
                                                    <span class="status-indicator status-confirmed"></span>
                                                    <span class="text-xs font-medium text-green-800">Confirmé</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button
                                                class="p-1.5 rounded-full text-indigo-600 hover:bg-indigo-50 transition-colors">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button
                                                class="p-1.5 rounded-full text-green-600 hover:bg-green-50 transition-colors">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button
                                                class="p-1.5 rounded-full text-red-600 hover:bg-red-50 transition-colors">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="appointment-card">
                                <div class="px-6 py-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <img class="h-10 w-10 rounded-full"
                                                    src="https://ui-avatars.com/api/?name=Karim+Benali&background=6366F1&color=ffffff"
                                                    alt="Patient">
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-indigo-600">Karim Benali</p>
                                                <p class="text-xs text-gray-500">Dr. Omar Tazi • 02:15 PM</p>
                                                <div class="flex items-center mt-1">
                                                    <span class="status-indicator status-pending"></span>
                                                    <span class="text-xs font-medium text-amber-800">En attente</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button
                                                class="p-1.5 rounded-full text-indigo-600 hover:bg-indigo-50 transition-colors">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button
                                                class="p-1.5 rounded-full text-green-600 hover:bg-green-50 transition-colors">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button
                                                class="p-1.5 rounded-full text-red-600 hover:bg-red-50 transition-colors">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="appointment-card">
                                <div class="px-6 py-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0">
                                                <img class="h-10 w-10 rounded-full"
                                                    src="https://ui-avatars.com/api/?name=Souad+Moussaoui&background=6366F1&color=ffffff"
                                                    alt="Patient">
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm font-medium text-indigo-600">Souad Moussaoui</p>
                                                <p class="text-xs text-gray-500">Dr. Samira Chennaoui • 04:45 PM</p>
                                                <div class="flex items-center mt-1">
                                                    <span class="status-indicator status-pending"></span>
                                                    <span class="text-xs font-medium text-amber-800">En attente</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button
                                                class="p-1.5 rounded-full text-indigo-600 hover:bg-indigo-50 transition-colors">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button
                                                class="p-1.5 rounded-full text-green-600 hover:bg-green-50 transition-colors">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <button
                                                class="p-1.5 rounded-full text-red-600 hover:bg-red-50 transition-colors">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="bg-gray-50 px-6 py-3 flex justify-between items-center">
                        <span class="text-sm text-gray-700">Affichage de 4 rendez-vous sur 32</span>
                        <button class="text-indigo-600 hover:text-indigo-500 text-sm font-medium">
                            Voir tous les rendez-vous
                        </button>
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
                                    class="ml-1 px-1.5 py-0.5 bg-amber-100 text-amber-700 rounded-full text-xs">5</span>
                            </button>
                            <button id="tab-messages" class="tab-button">
                                Messages <span
                                    class="ml-1 px-1.5 py-0.5 bg-indigo-100 text-indigo-700 rounded-full text-xs">7</span>
                            </button>
                        </div>
                    </div>

                    <!-- Activity tab -->
                    <div id="panel-activity" class="panel max-h-80 overflow-y-auto">
                        <div class="px-6 py-4">
                            <div class="flow-root">
                                <ul class="relative">
                                    <li class="ml-6 mb-4 relative">
                                        <div
                                            class="absolute top-2.5 left-0 -ml-6 flex items-center justify-center w-5 h-5 bg-red-600 rounded-full">
                                            <i class="fas fa-exclamation-triangle text-white text-xs"></i>
                                        </div>
                                        <div class="ml-2 relative bg-gray-50 p-3 rounded-lg shadow-sm">
                                            <div class="text-sm font-medium text-gray-900">Résultats de laboratoire
                                                urgents reçus</div>
                                            <p class="mt-1 text-xs text-gray-500">
                                                <span class="font-medium text-red-600">Valeurs sanguines
                                                    critiques</span> détectées pour le patient #12345. Nécessite une
                                                attention immédiate.
                                            </p>
                                            <span class="text-xs text-gray-500 mt-1 block">Il y a 10 minutes</span>
                                        </div>
                                    </li>
                                    <li class="ml-6 mb-4 relative">
                                        <div
                                            class="absolute top-2.5 left-0 -ml-6 flex items-center justify-center w-5 h-5 bg-emerald-600 rounded-full">
                                            <i class="fas fa-user-plus text-white text-xs"></i>
                                        </div>
                                        <div class="ml-2 relative bg-gray-50 p-3 rounded-lg shadow-sm">
                                            <div class="text-sm font-medium text-gray-900">Nouveau patient enregistré
                                            </div>
                                            <p class="mt-1 text-xs text-gray-500">
                                                <span class="font-medium text-emerald-600">Rachid Benjelloun</span>
                                                enregistré comme nouveau patient.
                                            </p>
                                            <span class="text-xs text-gray-500 mt-1 block">Il y a 45 minutes</span>
                                        </div>
                                    </li>
                                    <li class="ml-6 mb-4 relative">
                                        <div
                                            class="absolute top-2.5 left-0 -ml-6 flex items-center justify-center w-5 h-5 bg-indigo-600 rounded-full pulse">
                                            <i class="fas fa-calendar-check text-white text-xs"></i>
                                        </div>
                                        <div class="ml-2 relative bg-gray-50 p-3 rounded-lg shadow-sm">
                                            <div class="text-sm font-medium text-gray-900">Rendez-vous reprogrammé</div>
                                            <p class="mt-1 text-xs text-gray-500">
                                                <span class="font-medium text-indigo-600">Mohammed Alami</span> a
                                                reprogrammé son rendez-vous avec Dr. Ahmed Lahlou.
                                            </p>
                                            <span class="text-xs text-gray-500 mt-1 block">Il y a 1 heure</span>
                                        </div>
                                    </li>
                                    <li class="ml-6 relative">
                                        <div
                                            class="absolute top-2.5 left-0 -ml-6 flex items-center justify-center w-5 h-5 bg-amber-500 rounded-full">
                                            <i class="fas fa-file-prescription text-white text-xs"></i>
                                        </div>
                                        <div class="ml-2 relative bg-gray-50 p-3 rounded-lg shadow-sm">
                                            <div class="text-sm font-medium text-gray-900">Ordonnance mise à jour</div>
                                            <p class="mt-1 text-xs text-gray-500">
                                                <span class="font-medium text-amber-600">Dr. Leila Bouzidi</span> a mis
                                                à jour l'ordonnance pour la patiente Fatima Zahra.
                                            </p>
                                            <span class="text-xs text-gray-500 mt-1 block">Il y a 2 heures</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Tasks tab -->


                    <!-- Messages tab -->
                    <div id="panel-messages" class="panel max-h-80 overflow-y-auto hidden">
                        <div class="divide-y divide-gray-200">
                            <div class="message-item p-4 cursor-pointer">
                                <div class="flex justify-between items-start">
                                    <div class="flex">
                                        <img class="h-10 w-10 rounded-full"
                                            src="https://ui-avatars.com/api/?name=Omar+Tazi&background=4f46e5&color=ffffff"
                                            alt="Dr. Omar Tazi">
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Dr. Omar Tazi</p>
                                            <p class="text-sm text-gray-500 line-clamp-1">À propos du patient Karim
                                                Benali: Merci de consulter les derniers résultats de laboratoire...</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <span class="text-xs text-gray-500">09:42</span>
                                        <span
                                            class="w-5 h-5 bg-indigo-600 rounded-full text-white text-xs flex items-center justify-center mt-1">1</span>
                                    </div>
                                </div>
                            </div>
                            <div class="message-item p-4 cursor-pointer">
                                <div class="flex justify-between items-start">
                                    <div class="flex">
                                        <img class="h-10 w-10 rounded-full"
                                            src="https://ui-avatars.com/api/?name=Leila+Bouzidi&background=4f46e5&color=ffffff"
                                            alt="Dr. Leila Bouzidi">
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Dr. Leila Bouzidi</p>
                                            <p class="text-sm text-gray-500 line-clamp-1">Avez-vous vu le protocole mis
                                                à jour pour les vaccinations pédiatriques?</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <span class="text-xs text-gray-500">Hier</span>
                                        <span
                                            class="w-5 h-5 bg-indigo-600 rounded-full text-white text-xs flex items-center justify-center mt-1">3</span>
                                    </div>
                                </div>
                            </div>
                            <div class="message-item p-4 cursor-pointer">
                                <div class="flex justify-between items-start">
                                    <div class="flex">
                                        <img class="h-10 w-10 rounded-full"
                                            src="https://ui-avatars.com/api/?name=Fatima+Zahra&background=6366F1&color=ffffff"
                                            alt="Fatima Zahra">
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">Fatima Zahra</p>
                                            <p class="text-sm text-gray-500 line-clamp-1">Message du patient: J'ai
                                                besoin de reprogrammer mon rendez-vous...</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end">
                                        <span class="text-xs text-gray-500">Hier</span>
                                        <span
                                            class="w-5 h-5 bg-indigo-600 rounded-full text-white text-xs flex items-center justify-center mt-1">2</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 flex justify-center">
                            <button class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-500">
                                <i class="fas fa-envelope mr-2"></i>
                                Ouvrir la boîte de réception
                            </button>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                        <button
                            class="inline-flex w-full items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm">
                            <i class="fas fa-history mr-2"></i>
                            Voir toute l'activité
                        </button>
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
                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4">
                        <div class="relative flex-grow">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text"
                                class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="Rechercher par nom, ID, numéro de téléphone...">
                        </div>
                        <button
                            class="inline-flex items-center px-4 py-2 sm:py-3 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            <i class="fas fa-search mr-2"></i>
                            Rechercher
                        </button>
                    </div>
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
                    <div class="text-3xl font-bold mb-1">{{ $patients_count }}</div>
                    <div class="text-sm text-indigo-100">8 nouveaux ce mois</div>
                </div>

                <div class="stats-card-gradient-2 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Actifs</h3>
                        <div class="bg-white/20 h-10 w-10 rounded-full flex items-center justify-center">
                            <i class="fas fa-user-check text-white"></i>
                        </div>
                    </div>
                    <div class="text-3xl font-bold mb-1">124</div>
                    <div class="text-sm text-emerald-100">80% du total</div>
                </div>

                <div class="stats-card-gradient-3 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Cette semaine</h3>
                        <div class="bg-white/20 h-10 w-10 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-week text-white"></i>
                        </div>
                    </div>
                    <div class="text-3xl font-bold mb-1">42</div>
                    <div class="text-sm text-orange-100">+12% vs sem. dernière</div>
                </div>

                <div class="stats-card-gradient-4 rounded-xl shadow-lg p-6 text-white">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Contrôles à faire</h3>
                        <div class="bg-white/20 h-10 w-10 rounded-full flex items-center justify-center">
                            <i class="fas fa-clipboard-check text-white"></i>
                        </div>
                    </div>
                    <div class="text-3xl font-bold mb-1">18</div>
                    <div class="text-sm text-red-100">5 urgents</div>
                </div>
            </div>

            <!-- Patient listing -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200 flex flex-wrap justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Liste des Patients</h3>
                    <div class="flex items-center space-x-2 mt-2 sm:mt-0">
                        <div class="relative">
                            <select
                                class="appearance-none bg-white border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:border-indigo-500">
                                <option>Récents</option>
                                <option>Alphabétique</option>
                                <option>Dernière visite</option>
                            </select>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
                    <!-- Patient card 1 -->
                    <div class="patient-card bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                        <div class="px-4 py-4 sm:px-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-12 rounded-full overflow-hidden bg-indigo-100">
                                    <img src="https://ui-avatars.com/api/?name=Mohammed+Alami&background=6366F1&color=ffffff"
                                        alt="Mohammed Alami">
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-lg font-medium text-indigo-600">Mohammed Alami</h3>
                                            <p class="text-sm text-gray-500">ID: #MED-12345</p>
                                        </div>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                                            Actif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 px-4 py-4 sm:px-6 bg-gray-50">
                            <div class="grid grid-cols-3 gap-2 text-sm">
                                <div>
                                    <p class="text-gray-500">Âge</p>
                                    <p class="font-medium">42 ans</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Genre</p>
                                    <p class="font-medium">Homme</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Téléphone</p>
                                    <p class="font-medium">+212 661-234567</p>
                                </div>
                            </div>
                            <div class="mt-3 grid grid-cols-2 gap-2 text-sm">
                                <div>
                                    <p class="text-gray-500">Dernière visite</p>
                                    <p class="font-medium">12 Mars 2025</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Prochain RDV</p>
                                    <p class="font-medium text-indigo-600">Aujourd'hui 09:30</p>
                                </div>
                            </div>
                        </div>

                        <div class="px-4 py-3 sm:px-6 flex justify-between border-t border-gray-200">
                            <div class="patient-actions flex space-x-2">
                                <button class="text-sm text-indigo-600 hover:text-indigo-500">
                                    <i class="fas fa-file-medical"></i>
                                </button>
                                <button class="text-sm text-emerald-600 hover:text-emerald-500">
                                    <i class="fas fa-calendar-plus"></i>
                                </button>
                                <button class="text-sm text-blue-600 hover:text-blue-500">
                                    <i class="fas fa-comments"></i>
                                </button>
                            </div>
                            <button class="text-sm text-indigo-600 hover:text-indigo-500 font-medium">
                                Voir détails
                            </button>
                        </div>
                    </div>

                    <!-- Patient card 2 -->
                    <div class="patient-card bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                        <div class="px-4 py-4 sm:px-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-12 rounded-full overflow-hidden bg-indigo-100">
                                    <img src="https://ui-avatars.com/api/?name=Fatima+Zahra&background=6366F1&color=ffffff"
                                        alt="Fatima Zahra">
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-lg font-medium text-indigo-600">Fatima Zahra</h3>
                                            <p class="text-sm text-gray-500">ID: #MED-12346</p>
                                        </div>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                                            Active
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 px-4 py-4 sm:px-6 bg-gray-50">
                            <div class="grid grid-cols-3 gap-2 text-sm">
                                <div>
                                    <p class="text-gray-500">Âge</p>
                                    <p class="font-medium">35 ans</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Genre</p>
                                    <p class="font-medium">Femme</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Téléphone</p>
                                    <p class="font-medium">+212 661-345678</p>
                                </div>
                            </div>
                            <div class="mt-3 grid grid-cols-2 gap-2 text-sm">
                                <div>
                                    <p class="text-gray-500">Dernière visite</p>
                                    <p class="font-medium">28 Mars 2025</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Prochain RDV</p>
                                    <p class="font-medium text-indigo-600">Aujourd'hui 11:00</p>
                                </div>
                            </div>
                        </div>

                        <div class="px-4 py-3 sm:px-6 flex justify-between border-t border-gray-200">
                            <div class="patient-actions flex space-x-2">
                                <button class="text-sm text-indigo-600 hover:text-indigo-500">
                                    <i class="fas fa-file-medical"></i>
                                </button>
                                <button class="text-sm text-emerald-600 hover:text-emerald-500">
                                    <i class="fas fa-calendar-plus"></i>
                                </button>
                                <button class="text-sm text-blue-600 hover:text-blue-500">
                                    <i class="fas fa-comments"></i>
                                </button>
                            </div>
                            <button class="text-sm text-indigo-600 hover:text-indigo-500 font-medium">
                                Voir détails
                            </button>
                        </div>
                    </div>

                    <!-- Patient card 3 -->
                    <div class="patient-card bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                        <div class="px-4 py-4 sm:px-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-12 rounded-full overflow-hidden bg-indigo-100">
                                    <img src="https://ui-avatars.com/api/?name=Karim+Benali&background=6366F1&color=ffffff"
                                        alt="Karim Benali">
                                </div>
                                <div class="ml-4 flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-lg font-medium text-indigo-600">Karim Benali</h3>
                                            <p class="text-sm text-gray-500">ID: #MED-12347</p>
                                        </div>
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full mr-1.5"></span>
                                            Suivi requis
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 px-4 py-4 sm:px-6 bg-gray-50">
                            <div class="grid grid-cols-3 gap-2 text-sm">
                                <div>
                                    <p class="text-gray-500">Âge</p>
                                    <p class="font-medium">57 ans</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Genre</p>
                                    <p class="font-medium">Homme</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Téléphone</p>
                                    <p class="font-medium">+212 661-456789</p>
                                </div>
                            </div>
                            <div class="mt-3 grid grid-cols-2 gap-2 text-sm">
                                <div>
                                    <p class="text-gray-500">Dernière visite</p>
                                    <p class="font-medium">1 Avril 2025</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Prochain RDV</p>
                                    <p class="font-medium text-indigo-600">Aujourd'hui 14:15</p>
                                </div>
                            </div>
                        </div>

                        <div class="px-4 py-3 sm:px-6 flex justify-between border-t border-gray-200">
                            <div class="patient-actions flex space-x-2">
                                <button class="text-sm text-indigo-600 hover:text-indigo-500">
                                    <i class="fas fa-file-medical"></i>
                                </button>
                                <button class="text-sm text-emerald-600 hover:text-emerald-500">
                                    <i class="fas fa-calendar-plus"></i>
                                </button>
                                <button class="text-sm text-blue-600 hover:text-blue-500">
                                    <i class="fas fa-comments"></i>
                                </button>
                            </div>
                            <button class="text-sm text-indigo-600 hover:text-indigo-500 font-medium">
                                Voir détails
                            </button>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 flex items-center justify-between border-t border-gray-200">
                    <p class="text-sm text-gray-700">
                        Affichage de 3 patients sur 154
                    </p>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center space-x-2">
                            <button class="px-2 py-1 border border-gray-300 rounded text-indigo-600 hover:bg-gray-100">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button
                                class="px-3 py-1 border border-gray-300 rounded-md bg-indigo-600 text-white">1</button>
                            <button
                                class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-100 text-gray-600">2</button>
                            <button
                                class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-100 text-gray-600">3</button>
                            <button class="px-2 py-1 border border-gray-300 rounded text-indigo-600 hover:bg-gray-100">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Other sections placeholder (hidden by default) -->
        <section id="appointments-section" class="p-4 md:p-8 dashboard-section hidden">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Gestion des Rendez-vous</h1>
            <!-- Appointments content would go here -->
            <div class="bg-white p-10 rounded-xl shadow-sm text-center">
                <p class="text-gray-500">Section en cours de développement</p>
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
                <div id="panel-tasks" class="panel max-h-80 overflow-y-auto hidden">
                    <div class="px-6 py-4">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-sm font-medium text-gray-700">Tâches prioritaires</h4>
                            <button class="text-indigo-600 text-sm hover:text-indigo-500">
                                <i class="fas fa-plus mr-1"></i> Ajouter
                            </button>
                        </div>

                        <div class="space-y-2">
                            <div class="task-item">
                                <div class="flex items-start">
                                    <div class="task-checkbox flex-shrink-0 mr-3"></div>
                                    <div class="flex-grow">
                                        <div class="task-text">Examiner les résultats de laboratoire urgents pour le
                                            patient #12345</div>
                                        <div class="text-xs text-red-500 mt-1 flex items-center">
                                            <i class="fas fa-fire-alt mr-1"></i>
                                            Haute priorité • Dû aujourd'hui à 10:00
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="task-item">
                                <div class="flex items-start">
                                    <div class="task-checkbox flex-shrink-0 mr-3"></div>
                                    <div class="flex-grow">
                                        <div class="task-text">Préparer le rapport mensuel du département</div>
                                        <div class="text-xs text-amber-500 mt-1 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            Priorité moyenne • Dû demain
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="task-item">
                                <div class="flex items-start">
                                    <div class="task-checkbox checked flex-shrink-0 mr-3"></div>
                                    <div class="flex-grow">
                                        <div class="task-text checked">Appeler le fournisseur concernant la commande
                                            d'équipement retardée</div>
                                        <div class="text-xs text-gray-400 mt-1 flex items-center">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Terminé à 08:15
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="task-item">
                                <div class="flex items-start">
                                    <div class="task-checkbox flex-shrink-0 mr-3"></div>
                                    <div class="flex-grow">
                                        <div class="task-text">Mettre à jour le planning du personnel pour la
                                            semaine prochaine</div>
                                        <div class="text-xs text-amber-500 mt-1 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            Priorité moyenne • Dû dans 2 jours
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="task-item">
                                <div class="flex items-start">
                                    <div class="task-checkbox flex-shrink-0 mr-3"></div>
                                    <div class="flex-grow">
                                        <div class="task-text">Approuver les demandes de congés</div>
                                        <div class="text-xs text-green-500 mt-1 flex items-center">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            Faible priorité • Dû dans 3 jours
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-white p-4 border-t border-gray-200 text-center md:text-left text-sm text-gray-600">
            <div class="max-w-7xl mx-auto">
                <div class="flex flex-col md:flex-row md:justify-between items-center">
                    <div class="mb-4 md:mb-0">
                        &copy; 2025 MediDash. Tous droits réservés.
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
</body>
</html>