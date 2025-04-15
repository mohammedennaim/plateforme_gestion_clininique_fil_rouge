<!DOCTYPE html>
<html lang="en">
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                    }
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
      .sidebar-item {
        @apply flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-primary-100 hover:text-primary-700 transition-colors;
      }
      .sidebar-item.active {
        @apply bg-primary-100 text-primary-700 font-medium;
      }
      .tab {
        @apply px-4 py-2 font-medium text-gray-600 border-b-2 border-transparent hover:text-primary-600 cursor-pointer;
      }
      .tab.active {
        @apply text-primary-600 border-primary-600;
      }
      .btn {
        @apply px-4 py-2 rounded-md font-medium transition-colors;
      }
      .btn-primary {
        @apply bg-primary-600 text-white hover:bg-primary-700;
      }
      .btn-outline {
        @apply border border-gray-300 text-gray-700 hover:bg-gray-50;
      }
      .card {
        @apply bg-white rounded-lg shadow p-4;
      }
      .form-input {
        @apply w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent;
      }
      .form-label {
        @apply block text-sm font-medium text-gray-700 mb-1;
      }
    }
  </style>
    <title>Doctor Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                    }
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
      .sidebar-item {
        @apply flex items-center gap-3 px-3 py-2 rounded-md text-gray-700 hover:bg-primary-100 hover:text-primary-700 transition-colors;
      }
      .sidebar-item.active {
        @apply bg-primary-100 text-primary-700 font-medium;
      }
      .tab {
        @apply px-4 py-2 font-medium text-gray-600 border-b-2 border-transparent hover:text-primary-600 cursor-pointer;
      }
      .tab.active {
        @apply text-primary-600 border-primary-600;
      }
      .btn {
        @apply px-4 py-2 rounded-md font-medium transition-colors;
      }
      .btn-primary {
        @apply bg-primary-600 text-white hover:bg-primary-700;
      }
      .btn-outline {
        @apply border border-gray-300 text-gray-700 hover:bg-gray-50;
      }
      .card {
        @apply bg-white rounded-lg shadow p-4;
      }
      .form-input {
        @apply w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent;
      }
      .form-label {
        @apply block text-sm font-medium text-gray-700 mb-1;
      }
    }
  </style>
</head>

<body class="bg-gray-50 text-gray-800">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-white border-r border-gray-200 h-full flex-shrink-0 hidden md:block">
            <div class="p-4 border-b border-gray-200">
                <h1 class="text-xl font-bold text-primary-700">MediDash</h1>
            </div>
            <div class="p-4">
                <div class="flex items-center gap-3 mb-6">
                    <div
                        class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-700">
                        <i class="fas fa-user-md"></i>
                    </div>
                    <div>
                        <p class="font-medium">Dr. Sarah Johnson</p>
                        <p class="text-xs text-gray-500">Cardiologist</p>
                    </div>
                </div>
                <nav class="space-y-1">
                    <a href="#dashboard" class="sidebar-item active" data-section="dashboard">
                        <i class="fas fa-home w-5"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="#patients" class="sidebar-item" data-section="patients">
                        <i class="fas fa-users w-5"></i>
                        <span>Patients</span>
                    </a>
                    <a href="#appointments" class="sidebar-item" data-section="appointments">
                        <i class="fas fa-calendar-alt w-5"></i>
                        <span>Appointments</span>
                    </a>
                    <a href="#invoices" class="sidebar-item" data-section="invoices">
                        <i class="fas fa-file-invoice-dollar w-5"></i>
                        <span>Invoices</span>
                    </a>
                    <a href="#settings" class="sidebar-item" data-section="settings">
                        <i class="fas fa-cog w-5"></i>
                        <span>Settings</span>
                    </a>
                    <a class="sidebar-item" href="{{ route('logout') }}">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw w-5" aria-hidden="true"></i>
                        <span>Déconnexion</span>
                    </a>
                </nav>
            </div>
        </aside>


        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 p-4 flex items-center justify-between">
                <button id="sidebar-toggle" class="md:hidden text-gray-600 hover:text-gray-900">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="relative w-64 md:w-80">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Search..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                <div class="relative w-64 md:w-80">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Search..."
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
                <div class="flex items-center gap-4">
                    <button class="relative text-gray-600 hover:text-gray-900">
                        <i class="fas fa-bell"></i>
                        <span
                            class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                <div class="flex items-center gap-4">
                    <button class="relative text-gray-600 hover:text-gray-900">
                        <i class="fas fa-bell"></i>
                        <span
                            class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                    </button>
                    <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700">
                        <i class="fas fa-user-md"></i>
                    </div>
                </div>
            </header>
                    <div class="w-8 h-8 rounded-full bg-primary-100 flex items-center justify-center text-primary-700">
                        <i class="fas fa-user-md"></i>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto p-4">
                <!-- Dashboard Section -->
                <section id="dashboard-section" class="section active">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold">Dashboard</h2>
                        <div class="flex gap-2">
                            <button class="btn btn-outline">
                                <i class="fas fa-download mr-2"></i>
                                Export
                            </button>
                            <button class="btn btn-primary">
                                <i class="fas fa-plus mr-2"></i>
                                New Patient
                            </button>
                        </div>
                    </div>
            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto p-4">
                <!-- Dashboard Section -->
                <section id="dashboard-section" class="section active">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold">Dashboard</h2>
                        <div class="flex gap-2">
                            <button class="btn btn-outline">
                                <i class="fas fa-download mr-2"></i>
                                Export
                            </button>
                            <button class="btn btn-primary">
                                <i class="fas fa-plus mr-2"></i>
                                New Patient
                            </button>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                        <div class="card bg-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Total Patients</p>
                                    <p class="text-2xl font-bold">{{ count($patients) }}</p>
                                </div>
                                <div
                                    class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <p class="text-xs text-green-600 mt-2">
                                <i class="fas fa-arrow-up mr-1"></i>
                                <span>4.75% increase</span>
                            </p>
                        </div>
                        <div class="card bg-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Today's Appointments</p>
                                    <p class="text-2xl font-bold">{{ count($todayAppointments) }}</p>
                                </div>
                                <div
                                    class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                            </div>
                            <p class="text-xs text-green-600 mt-2">
                                <i class="fas fa-arrow-up mr-1"></i>
                                <span>2.5% increase</span>
                            </p>
                        </div>
                        <div class="card bg-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Today's Patients</p>
                                    <p class="text-2xl font-bold">8</p>
                                </div>
                                <div
                                    class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                                    <i class="fas fa-user-clock"></i>
                                </div>
                            </div>
                            <p class="text-xs text-red-600 mt-2">
                                <i class="fas fa-arrow-down mr-1"></i>
                                <span>1.2% decrease</span>
                            </p>
                        </div>
                        <div class="card bg-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Revenue</p>
                                    <p class="text-2xl font-bold">{{ $revenue }}</p>
                                </div>
                                <div
                                    class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                            </div>
                            <p class="text-xs text-green-600 mt-2">
                                <i class="fas fa-arrow-up mr-1"></i>
                                <span>8.2% increase</span>
                            </p>
                        </div>
                    </div>

                    <!-- Recent Activity and Upcoming Appointments -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Upcoming Appointments -->
                        <div class="card">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="font-bold text-lg">Today's Appointments</h3>
                                <a href="#appointments" class="text-sm text-primary-600 hover:underline">View All</a>
                    <!-- Recent Activity and Upcoming Appointments -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Upcoming Appointments -->
                        <div class="card">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="font-bold text-lg">Today's Appointments</h3>
                                <a href="#appointments" class="text-sm text-primary-600 hover:underline">View All</a>
                            </div>
                            <div class="space-y-4">
                                @forelse ($todayAppointments as $appointment)
                                    <div class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-md transition-colors">
                                        <div
                                            class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                            <i class="fas fa-user"></i>
                            <div class="space-y-4">
                                @forelse ($todayAppointments as $appointment)
                                    <div class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-md transition-colors">
                                        <div
                                            class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="font-medium">
                                                {{ $appointment->patient->user->name ?? 'Patient inconnu' }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ $appointment->reason ?? 'Aucune raison spécifiée' }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-medium">{{ $appointment->time ?? '--:--' }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ $appointment->duration ?? 'Durée inconnue' }}
                                            </p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500">Aucun rendez-vous pour aujourd'hui.</p>
                                @endforelse
                            </div>

                        </div>
                                        <div class="flex-1">
                                            <p class="font-medium">
                                                {{ $appointment->patient->user->name ?? 'Patient inconnu' }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ $appointment->reason ?? 'Aucune raison spécifiée' }}
                                            </p>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-medium">{{ $appointment->time ?? '--:--' }}</p>
                                            <p class="text-xs text-gray-500">
                                                {{ $appointment->duration ?? 'Durée inconnue' }}
                                            </p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500">Aucun rendez-vous pour aujourd'hui.</p>
                                @endforelse
                            </div>

                        </div>

                        <!-- Recent Activity -->
                        <div class="card">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="font-bold text-lg">Recent Activity</h3>
                                <button class="text-sm text-primary-600 hover:underline">View All</button>
                        <!-- Recent Activity -->
                        <div class="card">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="font-bold text-lg">Recent Activity</h3>
                                <button class="text-sm text-primary-600 hover:underline">View All</button>
                            </div>
                            <div class="space-y-4">
                                <div class="flex gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                                        <i class="fas fa-file-medical"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Patient file updated</p>
                                        <p class="text-sm text-gray-500">You updated John Smith's medical records</p>
                                        <p class="text-xs text-gray-400 mt-1">Today, 08:34 AM</p>
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                        <i class="fas fa-calendar-plus"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">New appointment scheduled</p>
                                        <p class="text-sm text-gray-500">Emily Johnson booked an appointment</p>
                                        <p class="text-xs text-gray-400 mt-1">Yesterday, 03:15 PM</p>
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 flex-shrink-0">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Invoice paid</p>
                                        <p class="text-sm text-gray-500">Michael Brown paid invoice #INV-2023-042</p>
                                        <p class="text-xs text-gray-400 mt-1">Yesterday, 11:20 AM</p>
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 flex-shrink-0">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">New patient registered</p>
                                        <p class="text-sm text-gray-500">Sarah Davis registered as a new patient</p>
                                        <p class="text-xs text-gray-400 mt-1">Apr 12, 2023</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Patients Section -->
                <section id="patients-section" class="section hidden">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold">Patients</h2>
                        <div class="flex gap-2">
                            <button class="btn btn-outline">
                                <i class="fas fa-filter mr-2"></i>
                                Filter
                            </button>
                            <button class="btn btn-primary" id="add-patient-btn">
                                <i class="fas fa-plus mr-2"></i>
                                Add Patient
                            </button>
                            <div class="space-y-4">
                                <div class="flex gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                                        <i class="fas fa-file-medical"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Patient file updated</p>
                                        <p class="text-sm text-gray-500">You updated John Smith's medical records</p>
                                        <p class="text-xs text-gray-400 mt-1">Today, 08:34 AM</p>
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                        <i class="fas fa-calendar-plus"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">New appointment scheduled</p>
                                        <p class="text-sm text-gray-500">Emily Johnson booked an appointment</p>
                                        <p class="text-xs text-gray-400 mt-1">Yesterday, 03:15 PM</p>
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600 flex-shrink-0">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Invoice paid</p>
                                        <p class="text-sm text-gray-500">Michael Brown paid invoice #INV-2023-042</p>
                                        <p class="text-xs text-gray-400 mt-1">Yesterday, 11:20 AM</p>
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 flex-shrink-0">
                                        <i class="fas fa-user-plus"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">New patient registered</p>
                                        <p class="text-sm text-gray-500">Sarah Davis registered as a new patient</p>
                                        <p class="text-xs text-gray-400 mt-1">Apr 12, 2023</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Patients Section -->
                <section id="patients-section" class="section hidden">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold">Patients</h2>
                        <div class="flex gap-2">
                            <button class="btn btn-outline">
                                <i class="fas fa-filter mr-2"></i>
                                Filter
                            </button>
                            <button class="btn btn-primary" id="add-patient-btn">
                                <i class="fas fa-plus mr-2"></i>
                                Add Patient
                            </button>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div class="border-b border-gray-200 mb-6">
                        <div class="flex space-x-8">
                            <button class="tab active" data-tab="all-patients">All Patients</button>
                            <button class="tab" data-tab="recent">Recent</button>
                            <button class="tab" data-tab="archived">Archived</button>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div class="border-b border-gray-200 mb-6">
                        <div class="flex space-x-8">
                            <button class="tab active" data-tab="all-patients">All Patients</button>
                            <button class="tab" data-tab="recent">Recent</button>
                            <button class="tab" data-tab="archived">Archived</button>
                        </div>
                    </div>

                    <!-- Patient List -->
                    <div class="card overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Patient
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Contact
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Last Visit
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($patients as $patient)
                                                                        <tr class="hover:bg-gray-50">
                                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                                <div class="flex items-center">
                                                                                    <div
                                                                                        class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                                                                        <i class="fas fa-user"></i>
                                                                                    </div>
                                                                                    <div class="ml-4">
                                                                                        <div class="text-sm font-medium text-gray-900">
                                                                                            {{ $patient->name ?? 'Nom inconnu' }}
                                                                                        </div>
                                                                                        <div class="text-sm text-gray-500">
                                                                                            {{ $patient->age ?? '--' }} ans,
                                                                                            {{ $patient->gender ?? 'Genre inconnu' }}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </td>

                                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                                <div class="text-sm text-gray-900">
                                                                                    {{ $patient->email ?? 'Email non fourni' }}
                                                                                </div>
                                                                                <div class="text-sm text-gray-500">
                                                                                    {{ $patient->phone ?? 'Téléphone non fourni' }}
                                                                                </div>
                                                                            </td>

                                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                                <div class="text-sm text-gray-900">
                                                                                    {{ $patient->last_appointment_date ?? 'Date inconnue' }}
                                                                                </div>
                                                                                <div class="text-sm text-gray-500">
                                                                                    {{ $patient->last_appointment_reason ?? 'Raison non spécifiée' }}
                                                                                </div>
                                                                            </td>

                                                                            <td class="px-6 py-4 whitespace-nowrap">
                                                                                @php
                                                                                    $status = $patient->status ?? 'inactif';
                                                                                    $statusColors = [
                                                                                        'actif' => 'bg-green-100 text-green-800',
                                                                                        'inactif' => 'bg-gray-100 text-gray-600',
                                                                                        'en attente' => 'bg-yellow-100 text-yellow-800',
                                                                                    ];
                                                                                    $statusClass = $statusColors[strtolower($status)] ?? 'bg-gray-100 text-gray-600';
                                                                                @endphp
                                                                                <span
                                                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                                                                    {{ ucfirst($status) }}
                                                                                </span>
                                                                            </td>

                                                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                                                <div class="flex space-x-2">
                                                                                    <button class="text-primary-600 hover:text-primary-900">
                                                                                        <i class="fas fa-eye"></i>
                                                                                    </button>
                                                                                    <button class="text-yellow-600 hover:text-yellow-900">
                                                                                        <i class="fas fa-edit"></i>
                                                                                    </button>
                                                                                    <button class="text-red-600 hover:text-red-900">
                                                                                        <i class="fas fa-trash"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-gray-500 py-4">Aucun patient trouvé.
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                        <div class="bg-gray-50 px-6 py-3 flex items-center justify-between border-t border-gray-200">
                            <div class="flex-1 flex justify-between sm:hidden">
                                <a href="#"
                                    class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Previous
                                </a>
                                <a href="#"
                                    class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Next
                                </a>
                            </div>
                            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                                <div>
                                    <p class="text-sm text-gray-700">
                                        Showing <span class="font-medium">1</span> to <span class="font-medium">5</span>
                                        of <span class="font-medium">42</span> results
                                    </p>
                                </div>
                                <div>
                                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                                        aria-label="Pagination">
                                        <a href="#"
                                            class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <span class="sr-only">Previous</span>
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                        <a href="#" aria-current="page"
                                            class="z-10 bg-primary-50 border-primary-500 text-primary-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                            1
                                        </a>
                                        <a href="#"
                                            class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                            2
                                        </a>
                                        <a href="#"
                                            class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 hidden md:inline-flex relative items-center px-4 py-2 border text-sm font-medium">
                                            3
                                        </a>
                                        <span
                                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                                            ...
                                        </span>
                                        <a href="#"
                                            class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                            8
                                        </a>
                                        <a href="#"
                                            class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                                            9
                                        </a>
                                        <a href="#"
                                            class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                            <span class="sr-only">Next</span>
                                            <i class="fas fa-chevron-right"></i>
                                        </a>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Appointments Section -->
                <section id="appointments-section" class="section hidden">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold">Appointments</h2>
                        <div class="flex gap-2">
                            <button class="btn btn-outline">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                Calendar View
                            </button>
                            <button class="btn btn-primary" id="add-appointment-btn">
                                <i class="fas fa-plus mr-2"></i>
                                New Appointment
                            </button>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div class="border-b border-gray-200 mb-6">
                        <div class="flex space-x-8">
                            <button class="tab active" data-tab="upcoming">Upcoming</button>
                            <button class="tab" data-tab="past">Past</button>
                            <button class="tab" data-tab="cancelled">Cancelled</button>
                        </div>
                    </div>

                    <!-- Calendar View -->
                    <div class="card mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-lg">April 2023</h3>
                            <div class="flex gap-2">
                                <button class="btn btn-outline py-1 px-2">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="btn btn-outline py-1 px-2">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                        <div class="grid grid-cols-7 gap-2">
                            <div class="text-center font-medium text-gray-500 py-2">Sun</div>
                            <div class="text-center font-medium text-gray-500 py-2">Mon</div>
                            <div class="text-center font-medium text-gray-500 py-2">Tue</div>
                            <div class="text-center font-medium text-gray-500 py-2">Wed</div>
                            <div class="text-center font-medium text-gray-500 py-2">Thu</div>
                            <div class="text-center font-medium text-gray-500 py-2">Fri</div>
                            <div class="text-center font-medium text-gray-500 py-2">Sat</div>

                            <!-- Calendar days -->
                            <div class="text-center py-2 text-gray-400">26</div>
                            <div class="text-center py-2 text-gray-400">27</div>
                            <div class="text-center py-2 text-gray-400">28</div>
                            <div class="text-center py-2 text-gray-400">29</div>
                            <div class="text-center py-2 text-gray-400">30</div>
                            <div class="text-center py-2 text-gray-400">31</div>
                            <div class="text-center py-2">1</div>

                            <div class="text-center py-2">2</div>
                            <div class="text-center py-2">3</div>
                            <div class="text-center py-2">4</div>
                            <div class="text-center py-2">5</div>
                            <div class="text-center py-2">6</div>
                            <div class="text-center py-2">7</div>
                            <div class="text-center py-2">8</div>

                            <div class="text-center py-2">9</div>
                            <div class="text-center py-2">10</div>
                            <div class="text-center py-2">11</div>
                            <div class="text-center py-2">12</div>
                            <div class="text-center py-2">13</div>
                            <div class="text-center py-2">14</div>
                            <div class="text-center py-2">15</div>

                            <div class="text-center py-2">16</div>
                            <div class="text-center py-2 bg-primary-100 rounded-md font-medium text-primary-700">17
                            </div>
                            <div class="text-center py-2">18</div>
                            <div class="text-center py-2">19</div>
                            <div class="text-center py-2">20</div>
                            <div class="text-center py-2">21</div>
                            <div class="text-center py-2">22</div>

                            <div class="text-center py-2">23</div>
                            <div class="text-center py-2">24</div>
                            <div class="text-center py-2">25</div>
                            <div class="text-center py-2">26</div>
                            <div class="text-center py-2">27</div>
                            <div class="text-center py-2">28</div>
                            <div class="text-center py-2">29</div>

                            <div class="text-center py-2">30</div>
                            <div class="text-center py-2 text-gray-400">1</div>
                            <div class="text-center py-2 text-gray-400">2</div>
                            <div class="text-center py-2 text-gray-400">3</div>
                            <div class="text-center py-2 text-gray-400">4</div>
                            <div class="text-center py-2 text-gray-400">5</div>
                            <div class="text-center py-2 text-gray-400">6</div>
                        </div>
                    </div>

                    <!-- Appointment List -->
                    <div class="card">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Patient
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date & Time
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Type
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">John Smith</div>
                                                    <div class="text-sm text-gray-500">42 years, Male</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Apr 17, 2023</div>
                                            <div class="text-sm text-gray-500">09:00 AM - 09:15 AM</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">General Checkup</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Confirmed
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex space-x-2">
                                                <button class="text-primary-600 hover:text-primary-900">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="text-yellow-600 hover:text-yellow-900">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="text-red-600 hover:text-red-900">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">Emily Johnson</div>
                                                    <div class="text-sm text-gray-500">35 years, Female</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Apr 17, 2023</div>
                                            <div class="text-sm text-gray-500">10:30 AM - 11:00 AM</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Follow-up</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Confirmed
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex space-x-2">
                                                <button class="text-primary-600 hover:text-primary-900">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="text-yellow-600 hover:text-yellow-900">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="text-red-600 hover:text-red-900">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">Michael Brown</div>
                                                    <div class="text-sm text-gray-500">28 years, Male</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Apr 17, 2023</div>
                                            <div class="text-sm text-gray-500">01:15 PM - 02:00 PM</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Consultation</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex space-x-2">
                                                <button class="text-primary-600 hover:text-primary-900">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="text-yellow-600 hover:text-yellow-900">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="text-red-600 hover:text-red-900">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
                    <!-- Calendar View -->
                    <div class="card mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-bold text-lg">April 2023</h3>
                            <div class="flex gap-2">
                                <button class="btn btn-outline py-1 px-2">
                                    <i class="fas fa-chevron-left"></i>
                                </button>
                                <button class="btn btn-outline py-1 px-2">
                                    <i class="fas fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                        <div class="grid grid-cols-7 gap-2">
                            <div class="text-center font-medium text-gray-500 py-2">Sun</div>
                            <div class="text-center font-medium text-gray-500 py-2">Mon</div>
                            <div class="text-center font-medium text-gray-500 py-2">Tue</div>
                            <div class="text-center font-medium text-gray-500 py-2">Wed</div>
                            <div class="text-center font-medium text-gray-500 py-2">Thu</div>
                            <div class="text-center font-medium text-gray-500 py-2">Fri</div>
                            <div class="text-center font-medium text-gray-500 py-2">Sat</div>

                            <!-- Calendar days -->
                            <div class="text-center py-2 text-gray-400">26</div>
                            <div class="text-center py-2 text-gray-400">27</div>
                            <div class="text-center py-2 text-gray-400">28</div>
                            <div class="text-center py-2 text-gray-400">29</div>
                            <div class="text-center py-2 text-gray-400">30</div>
                            <div class="text-center py-2 text-gray-400">31</div>
                            <div class="text-center py-2">1</div>

                            <div class="text-center py-2">2</div>
                            <div class="text-center py-2">3</div>
                            <div class="text-center py-2">4</div>
                            <div class="text-center py-2">5</div>
                            <div class="text-center py-2">6</div>
                            <div class="text-center py-2">7</div>
                            <div class="text-center py-2">8</div>

                            <div class="text-center py-2">9</div>
                            <div class="text-center py-2">10</div>
                            <div class="text-center py-2">11</div>
                            <div class="text-center py-2">12</div>
                            <div class="text-center py-2">13</div>
                            <div class="text-center py-2">14</div>
                            <div class="text-center py-2">15</div>

                            <div class="text-center py-2">16</div>
                            <div class="text-center py-2 bg-primary-100 rounded-md font-medium text-primary-700">17
                            </div>
                            <div class="text-center py-2">18</div>
                            <div class="text-center py-2">19</div>
                            <div class="text-center py-2">20</div>
                            <div class="text-center py-2">21</div>
                            <div class="text-center py-2">22</div>

                            <div class="text-center py-2">23</div>
                            <div class="text-center py-2">24</div>
                            <div class="text-center py-2">25</div>
                            <div class="text-center py-2">26</div>
                            <div class="text-center py-2">27</div>
                            <div class="text-center py-2">28</div>
                            <div class="text-center py-2">29</div>

                            <div class="text-center py-2">30</div>
                            <div class="text-center py-2 text-gray-400">1</div>
                            <div class="text-center py-2 text-gray-400">2</div>
                            <div class="text-center py-2 text-gray-400">3</div>
                            <div class="text-center py-2 text-gray-400">4</div>
                            <div class="text-center py-2 text-gray-400">5</div>
                            <div class="text-center py-2 text-gray-400">6</div>
                        </div>
                    </div>

                    <!-- Appointment List -->
                    <div class="card">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Patient
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date & Time
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Type
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">John Smith</div>
                                                    <div class="text-sm text-gray-500">42 years, Male</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Apr 17, 2023</div>
                                            <div class="text-sm text-gray-500">09:00 AM - 09:15 AM</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">General Checkup</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Confirmed
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex space-x-2">
                                                <button class="text-primary-600 hover:text-primary-900">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="text-yellow-600 hover:text-yellow-900">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="text-red-600 hover:text-red-900">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">Emily Johnson</div>
                                                    <div class="text-sm text-gray-500">35 years, Female</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Apr 17, 2023</div>
                                            <div class="text-sm text-gray-500">10:30 AM - 11:00 AM</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Follow-up</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Confirmed
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex space-x-2">
                                                <button class="text-primary-600 hover:text-primary-900">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="text-yellow-600 hover:text-yellow-900">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="text-red-600 hover:text-red-900">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">Michael Brown</div>
                                                    <div class="text-sm text-gray-500">28 years, Male</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Apr 17, 2023</div>
                                            <div class="text-sm text-gray-500">01:15 PM - 02:00 PM</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Consultation</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex space-x-2">
                                                <button class="text-primary-600 hover:text-primary-900">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="text-yellow-600 hover:text-yellow-900">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="text-red-600 hover:text-red-900">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- Invoices Section -->
                <section id="invoices-section" class="section hidden">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold">Invoices</h2>
                        <div class="flex gap-2">
                            <button class="btn btn-outline">
                                <i class="fas fa-download mr-2"></i>
                                Export
                            </button>
                            <button class="btn btn-primary" id="create-invoice-btn">
                                <i class="fas fa-plus mr-2"></i>
                                Create Invoice
                            </button>
                        </div>
                    </div>
                <!-- Invoices Section -->
                <section id="invoices-section" class="section hidden">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold">Invoices</h2>
                        <div class="flex gap-2">
                            <button class="btn btn-outline">
                                <i class="fas fa-download mr-2"></i>
                                Export
                            </button>
                            <button class="btn btn-primary" id="create-invoice-btn">
                                <i class="fas fa-plus mr-2"></i>
                                Create Invoice
                            </button>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div class="border-b border-gray-200 mb-6">
                        <div class="flex space-x-8">
                            <button class="tab active" data-tab="all-invoices">All Invoices</button>
                            <button class="tab" data-tab="paid">Paid</button>
                            <button class="tab" data-tab="unpaid">Unpaid</button>
                        </div>
                    </div>
                    <!-- Tabs -->
                    <div class="border-b border-gray-200 mb-6">
                        <div class="flex space-x-8">
                            <button class="tab active" data-tab="all-invoices">All Invoices</button>
                            <button class="tab" data-tab="paid">Paid</button>
                            <button class="tab" data-tab="unpaid">Unpaid</button>
                        </div>
                    </div>

                    <!-- Invoice List -->
                    <div class="card">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Invoice
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Patient
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Amount
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-primary-600">#INV-2023-042</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900">John Smith</div>
                    <!-- Invoice List -->
                    <div class="card">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Invoice
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Patient
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Amount
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-primary-600">#INV-2023-042</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900">John Smith</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">$150.00</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Paid
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Apr 15, 2023</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex space-x-2">
                                                <button class="text-primary-600 hover:text-primary-900">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="text-gray-600 hover:text-gray-900">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                                <button class="text-gray-600 hover:text-gray-900">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-primary-600">#INV-2023-041</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900">Emily Johnson</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">$150.00</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Paid
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Apr 15, 2023</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex space-x-2">
                                                <button class="text-primary-600 hover:text-primary-900">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="text-gray-600 hover:text-gray-900">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                                <button class="text-gray-600 hover:text-gray-900">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-primary-600">#INV-2023-041</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900">Emily Johnson</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">$250.00</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Paid
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Apr 10, 2023</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex space-x-2">
                                                <button class="text-primary-600 hover:text-primary-900">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="text-gray-600 hover:text-gray-900">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                                <button class="text-gray-600 hover:text-gray-900">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-primary-600">#INV-2023-040</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900">Michael Brown</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">$250.00</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Paid
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Apr 10, 2023</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex space-x-2">
                                                <button class="text-primary-600 hover:text-primary-900">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="text-gray-600 hover:text-gray-900">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                                <button class="text-gray-600 hover:text-gray-900">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-primary-600">#INV-2023-040</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900">Michael Brown</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">$350.00</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Unpaid
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Apr 5, 2023</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex space-x-2">
                                                <button class="text-primary-600 hover:text-primary-900">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="text-gray-600 hover:text-gray-900">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                                <button class="text-gray-600 hover:text-gray-900">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-primary-600">#INV-2023-039</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900">Sarah Davis</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">$350.00</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Unpaid
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Apr 5, 2023</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex space-x-2">
                                                <button class="text-primary-600 hover:text-primary-900">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="text-gray-600 hover:text-gray-900">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                                <button class="text-gray-600 hover:text-gray-900">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-primary-600">#INV-2023-039</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900">Sarah Davis</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">$200.00</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Mar 28, 2023</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex space-x-2">
                                                <button class="text-primary-600 hover:text-primary-900">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="text-gray-600 hover:text-gray-900">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                                <button class="text-gray-600 hover:text-gray-900">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- Settings Section -->
                <section id="settings-section" class="section hidden">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold">Settings</h2>
                        <button class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>
                            Save Changes
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">$200.00</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">Mar 28, 2023</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <div class="flex space-x-2">
                                                <button class="text-primary-600 hover:text-primary-900">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                <button class="text-gray-600 hover:text-gray-900">
                                                    <i class="fas fa-print"></i>
                                                </button>
                                                <button class="text-gray-600 hover:text-gray-900">
                                                    <i class="fas fa-download"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                <!-- Settings Section -->
                <section id="settings-section" class="section hidden">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold">Settings</h2>
                        <button class="btn btn-primary">
                            <i class="fas fa-save mr-2"></i>
                            Save Changes
                        </button>
                    </div>
                    </div>

                    <!-- Tabs -->
                    <div class="border-b border-gray-200 mb-6">
                        <div class="flex space-x-8">
                            <button class="tab active" data-tab="profile">Profile</button>
                            <button class="tab" data-tab="account">Account</button>
                            <button class="tab" data-tab="notifications">Notifications</button>
                            <button class="tab" data-tab="billing">Billing</button>
                    <!-- Tabs -->
                    <div class="border-b border-gray-200 mb-6">
                        <div class="flex space-x-8">
                            <button class="tab active" data-tab="profile">Profile</button>
                            <button class="tab" data-tab="account">Account</button>
                            <button class="tab" data-tab="notifications">Notifications</button>
                            <button class="tab" data-tab="billing">Billing</button>
                        </div>
                    </div>

                    <!-- Settings Form -->
                    <div class="card">
                        <div class="p-4">
                            <h3 class="text-lg font-medium mb-4">Personal Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="first-name" class="form-label">First Name</label>
                                    <input type="text" id="first-name" class="form-input" value="Sarah" />
                                </div>
                                <div>
                                    <label for="last-name" class="form-label">Last Name</label>
                                    <input type="text" id="last-name" class="form-input" value="Johnson" />
                                </div>
                                <div>
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" id="email" class="form-input"
                                        value="sarah.johnson@example.com" />
                                </div>
                                <div>
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" id="phone" class="form-input" value="(123) 456-7890" />
                                </div>
                                <div>
                                    <label for="specialty" class="form-label">Specialty</label>
                                    <input type="text" id="specialty" class="form-input" value="Cardiologist" />
                                </div>
                                <div>
                                    <label for="license" class="form-label">License Number</label>
                                    <input type="text" id="license" class="form-input" value="MED-12345-CA" />
                                </div>
                            </div>
                    <!-- Settings Form -->
                    <div class="card">
                        <div class="p-4">
                            <h3 class="text-lg font-medium mb-4">Personal Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="first-name" class="form-label">First Name</label>
                                    <input type="text" id="first-name" class="form-input" value="Sarah" />
                                </div>
                                <div>
                                    <label for="last-name" class="form-label">Last Name</label>
                                    <input type="text" id="last-name" class="form-input" value="Johnson" />
                                </div>
                                <div>
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" id="email" class="form-input"
                                        value="sarah.johnson@example.com" />
                                </div>
                                <div>
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="tel" id="phone" class="form-input" value="(123) 456-7890" />
                                </div>
                                <div>
                                    <label for="specialty" class="form-label">Specialty</label>
                                    <input type="text" id="specialty" class="form-input" value="Cardiologist" />
                                </div>
                                <div>
                                    <label for="license" class="form-label">License Number</label>
                                    <input type="text" id="license" class="form-input" value="MED-12345-CA" />
                                </div>
                            </div>

                            <h3 class="text-lg font-medium mt-6 mb-4">Clinic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="clinic-name" class="form-label">Clinic Name</label>
                                    <input type="text" id="clinic-name" class="form-input"
                                        value="HeartCare Medical Center" />
                                </div>
                                <div>
                                    <label for="clinic-address" class="form-label">Address</label>
                                    <input type="text" id="clinic-address" class="form-input"
                                        value="123 Medical Plaza, Suite 456" />
                                </div>
                                <div>
                                    <label for="clinic-city" class="form-label">City</label>
                                    <input type="text" id="clinic-city" class="form-input" value="San Francisco" />
                                </div>
                                <div>
                                    <label for="clinic-state" class="form-label">State</label>
                                    <input type="text" id="clinic-state" class="form-input" value="CA" />
                            <h3 class="text-lg font-medium mt-6 mb-4">Clinic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="clinic-name" class="form-label">Clinic Name</label>
                                    <input type="text" id="clinic-name" class="form-input"
                                        value="HeartCare Medical Center" />
                                </div>
                                <div>
                                    <label for="clinic-address" class="form-label">Address</label>
                                    <input type="text" id="clinic-address" class="form-input"
                                        value="123 Medical Plaza, Suite 456" />
                                </div>
                                <div>
                                    <label for="clinic-city" class="form-label">City</label>
                                    <input type="text" id="clinic-city" class="form-input" value="San Francisco" />
                                </div>
                                <div>
                                    <label for="clinic-state" class="form-label">State</label>
                                    <input type="text" id="clinic-state" class="form-input" value="CA" />
                                </div>
                                <div>
                                    <label for="clinic-zip" class="form-label">ZIP Code</label>
                                    <input type="text" id="clinic-zip" class="form-input" value="94107" />
                                </div>
                                <div>
                                    <label for="clinic-phone" class="form-label">Clinic Phone</label>
                                    <input type="tel" id="clinic-phone" class="form-input" value="(415) 555-1234" />
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>
                                <div>
                                    <label for="clinic-zip" class="form-label">ZIP Code</label>
                                    <input type="text" id="clinic-zip" class="form-input" value="94107" />
                                </div>
                                <div>
                                    <label for="clinic-phone" class="form-label">Clinic Phone</label>
                                    <input type="tel" id="clinic-phone" class="form-input" value="(415) 555-1234" />
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
        </div>
    </div>

    <!-- Add Patient Modal -->
    <div id="add-patient-modal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-4">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-medium">Add New Patient</h3>
                <button class="text-gray-500 hover:text-gray-700 close-modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4">
                <form id="add-patient-form">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="patient-first-name" class="form-label">First Name</label>
                            <input type="text" id="patient-first-name" class="form-input" required />
                        </div>
                        <div>
                            <label for="patient-last-name" class="form-label">Last Name</label>
                            <input type="text" id="patient-last-name" class="form-input" required />
                        </div>
                        <div>
                            <label for="patient-email" class="form-label">Email</label>
                            <input type="email" id="patient-email" class="form-input" required />
                        </div>
                        <div>
                            <label for="patient-phone" class="form-label">Phone</label>
                            <input type="tel" id="patient-phone" class="form-input" required />
                        </div>
                        <div>
                            <label for="patient-dob" class="form-label">Date of Birth</label>
                            <input type="date" id="patient-dob" class="form-input" required />
                        </div>
                        <div>
                            <label for="patient-gender" class="form-label">Gender</label>
                            <select id="patient-gender" class="form-input" required>
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
    <!-- Add Patient Modal -->
    <div id="add-patient-modal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-4">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-medium">Add New Patient</h3>
                <button class="text-gray-500 hover:text-gray-700 close-modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4">
                <form id="add-patient-form">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="patient-first-name" class="form-label">First Name</label>
                            <input type="text" id="patient-first-name" class="form-input" required />
                        </div>
                        <div>
                            <label for="patient-last-name" class="form-label">Last Name</label>
                            <input type="text" id="patient-last-name" class="form-input" required />
                        </div>
                        <div>
                            <label for="patient-email" class="form-label">Email</label>
                            <input type="email" id="patient-email" class="form-input" required />
                        </div>
                        <div>
                            <label for="patient-phone" class="form-label">Phone</label>
                            <input type="tel" id="patient-phone" class="form-input" required />
                        </div>
                        <div>
                            <label for="patient-dob" class="form-label">Date of Birth</label>
                            <input type="date" id="patient-dob" class="form-input" required />
                        </div>
                        <div>
                            <label for="patient-gender" class="form-label">Gender</label>
                            <select id="patient-gender" class="form-input" required>
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label for="patient-address" class="form-label">Address</label>
                            <input type="text" id="patient-address" class="form-input" required />
                        </div>
                        <div class="md:col-span-2">
                            <label for="patient-address" class="form-label">Address</label>
                            <input type="text" id="patient-address" class="form-input" required />
                        </div>
                        <div>
                            <label for="patient-city" class="form-label">City</label>
                            <input type="text" id="patient-city" class="form-input" required />
                        </div>
                        <div>
                            <label for="patient-state" class="form-label">State</label>
                            <input type="text" id="patient-state" class="form-input" required />
                        </div>
                        <div>
                            <label for="patient-zip" class="form-label">ZIP Code</label>
                            <input type="text" id="patient-zip" class="form-input" required />
                        </div>
                        <div>
                            <label for="patient-insurance" class="form-label">Insurance Provider</label>
                            <input type="text" id="patient-insurance" class="form-input" />
                        </div>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" class="btn btn-outline close-modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Patient</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
                        <div>
                            <label for="patient-city" class="form-label">City</label>
                            <input type="text" id="patient-city" class="form-input" required />
                        </div>
                        <div>
                            <label for="patient-state" class="form-label">State</label>
                            <input type="text" id="patient-state" class="form-input" required />
                        </div>
                        <div>
                            <label for="patient-zip" class="form-label">ZIP Code</label>
                            <input type="text" id="patient-zip" class="form-input" required />
                        </div>
                        <div>
                            <label for="patient-insurance" class="form-label">Insurance Provider</label>
                            <input type="text" id="patient-insurance" class="form-input" />
                        </div>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" class="btn btn-outline close-modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Patient</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Appointment Modal -->
    <div id="add-appointment-modal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-4">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-medium">Schedule Appointment</h3>
                <button class="text-gray-500 hover:text-gray-700 close-modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4">
                <form id="add-appointment-form">
                    <div class="grid grid-cols-1 gap-4 mb-4">
                        <div>
                            <label for="appointment-patient" class="form-label">Patient</label>
                            <select id="appointment-patient" class="form-input" required>
                                <option value="">Select Patient</option>
                                <option value="1">John Smith</option>
                                <option value="2">Emily Johnson</option>
                                <option value="3">Michael Brown</option>
                                <option value="4">Sarah Davis</option>
                                <option value="5">Robert Wilson</option>
                            </select>
    <!-- Add Appointment Modal -->
    <div id="add-appointment-modal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md mx-4">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-medium">Schedule Appointment</h3>
                <button class="text-gray-500 hover:text-gray-700 close-modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4">
                <form id="add-appointment-form">
                    <div class="grid grid-cols-1 gap-4 mb-4">
                        <div>
                            <label for="appointment-patient" class="form-label">Patient</label>
                            <select id="appointment-patient" class="form-input" required>
                                <option value="">Select Patient</option>
                                <option value="1">John Smith</option>
                                <option value="2">Emily Johnson</option>
                                <option value="3">Michael Brown</option>
                                <option value="4">Sarah Davis</option>
                                <option value="5">Robert Wilson</option>
                            </select>
                        </div>
                        <div>
                            <label for="appointment-type" class="form-label">Appointment Type</label>
                            <select id="appointment-type" class="form-input" required>
                                <option value="">Select Type</option>
                                <option value="checkup">General Checkup</option>
                                <option value="followup">Follow-up</option>
                                <option value="consultation">Consultation</option>
                                <option value="test">Test Results</option>
                                <option value="procedure">Procedure</option>
                            </select>
                        </div>
                        <div>
                            <label for="appointment-date" class="form-label">Date</label>
                            <input type="date" id="appointment-date" class="form-input" required />
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="appointment-time" class="form-label">Time</label>
                                <input type="time" id="appointment-time" class="form-input" required />
                            </div>
                            <div>
                                <label for="appointment-duration" class="form-label">Duration</label>
                                <select id="appointment-duration" class="form-input" required>
                                    <option value="15">15 minutes</option>
                                    <option value="30">30 minutes</option>
                                    <option value="45">45 minutes</option>
                                    <option value="60">1 hour</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label for="appointment-notes" class="form-label">Notes</label>
                            <textarea id="appointment-notes" class="form-input" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" class="btn btn-outline close-modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
                        <div>
                            <label for="appointment-type" class="form-label">Appointment Type</label>
                            <select id="appointment-type" class="form-input" required>
                                <option value="">Select Type</option>
                                <option value="checkup">General Checkup</option>
                                <option value="followup">Follow-up</option>
                                <option value="consultation">Consultation</option>
                                <option value="test">Test Results</option>
                                <option value="procedure">Procedure</option>
                            </select>
                        </div>
                        <div>
                            <label for="appointment-date" class="form-label">Date</label>
                            <input type="date" id="appointment-date" class="form-input" required />
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="appointment-time" class="form-label">Time</label>
                                <input type="time" id="appointment-time" class="form-input" required />
                            </div>
                            <div>
                                <label for="appointment-duration" class="form-label">Duration</label>
                                <select id="appointment-duration" class="form-input" required>
                                    <option value="15">15 minutes</option>
                                    <option value="30">30 minutes</option>
                                    <option value="45">45 minutes</option>
                                    <option value="60">1 hour</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label for="appointment-notes" class="form-label">Notes</label>
                            <textarea id="appointment-notes" class="form-input" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" class="btn btn-outline close-modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Create Invoice Modal -->
    <div id="create-invoice-modal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl mx-4">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-medium">Create New Invoice</h3>
                <button class="text-gray-500 hover:text-gray-700 close-modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4">
                <form id="create-invoice-form">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="invoice-patient" class="form-label">Patient</label>
                            <select id="invoice-patient" class="form-input" required>
                                <option value="">Select Patient</option>
                                <option value="1">John Smith</option>
                                <option value="2">Emily Johnson</option>
                                <option value="3">Michael Brown</option>
                                <option value="4">Sarah Davis</option>
                                <option value="5">Robert Wilson</option>
                            </select>
                        </div>
                        <div>
                            <label for="invoice-date" class="form-label">Invoice Date</label>
                            <input type="date" id="invoice-date" class="form-input" required />
                        </div>
                        <div>
                            <label for="invoice-due-date" class="form-label">Due Date</label>
                            <input type="date" id="invoice-due-date" class="form-input" required />
                        </div>
                        <div>
                            <label for="invoice-number" class="form-label">Invoice Number</label>
                            <input type="text" id="invoice-number" class="form-input" value="#INV-2023-043" readonly />
                        </div>
                    </div>
    <!-- Create Invoice Modal -->
    <div id="create-invoice-modal"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl mx-4">
            <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                <h3 class="text-lg font-medium">Create New Invoice</h3>
                <button class="text-gray-500 hover:text-gray-700 close-modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-4">
                <form id="create-invoice-form">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="invoice-patient" class="form-label">Patient</label>
                            <select id="invoice-patient" class="form-input" required>
                                <option value="">Select Patient</option>
                                <option value="1">John Smith</option>
                                <option value="2">Emily Johnson</option>
                                <option value="3">Michael Brown</option>
                                <option value="4">Sarah Davis</option>
                                <option value="5">Robert Wilson</option>
                            </select>
                        </div>
                        <div>
                            <label for="invoice-date" class="form-label">Invoice Date</label>
                            <input type="date" id="invoice-date" class="form-input" required />
                        </div>
                        <div>
                            <label for="invoice-due-date" class="form-label">Due Date</label>
                            <input type="date" id="invoice-due-date" class="form-input" required />
                        </div>
                        <div>
                            <label for="invoice-number" class="form-label">Invoice Number</label>
                            <input type="text" id="invoice-number" class="form-input" value="#INV-2023-043" readonly />
                        </div>
                    </div>

                    <h4 class="font-medium mb-2">Items</h4>
                    <div class="overflow-x-auto mb-4">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Description
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Quantity
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Unit Price
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="invoice-items">
                                <tr>
                                    <td class="px-4 py-2">
                                        <input type="text" class="form-input" placeholder="Item description" />
                                    </td>
                                    <td class="px-4 py-2">
                                        <input type="number" class="form-input" value="1" min="1" />
                                    </td>
                                    <td class="px-4 py-2">
                                        <input type="number" class="form-input" value="0.00" min="0" step="0.01" />
                                    </td>
                                    <td class="px-4 py-2">
                                        <input type="number" class="form-input" value="0.00" readonly />
                                    </td>
                                    <td class="px-4 py-2">
                                        <button type="button" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="flex justify-between mb-4">
                        <button type="button" class="btn btn-outline" id="add-invoice-item">
                            <i class="fas fa-plus mr-2"></i>
                            Add Item
                        </button>
                        <div class="text-right">
                            <div class="flex justify-between mb-2">
                                <span class="font-medium mr-4">Subtotal:</span>
                                <span>$0.00</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="font-medium mr-4">Tax (10%):</span>
                                <span>$0.00</span>
                            </div>
                            <div class="flex justify-between font-bold">
                                <span class="mr-4">Total:</span>
                                <span>$0.00</span>
                            </div>
                    <h4 class="font-medium mb-2">Items</h4>
                    <div class="overflow-x-auto mb-4">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Description
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Quantity
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Unit Price
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total
                                    </th>
                                    <th scope="col"
                                        class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" id="invoice-items">
                                <tr>
                                    <td class="px-4 py-2">
                                        <input type="text" class="form-input" placeholder="Item description" />
                                    </td>
                                    <td class="px-4 py-2">
                                        <input type="number" class="form-input" value="1" min="1" />
                                    </td>
                                    <td class="px-4 py-2">
                                        <input type="number" class="form-input" value="0.00" min="0" step="0.01" />
                                    </td>
                                    <td class="px-4 py-2">
                                        <input type="number" class="form-input" value="0.00" readonly />
                                    </td>
                                    <td class="px-4 py-2">
                                        <button type="button" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="flex justify-between mb-4">
                        <button type="button" class="btn btn-outline" id="add-invoice-item">
                            <i class="fas fa-plus mr-2"></i>
                            Add Item
                        </button>
                        <div class="text-right">
                            <div class="flex justify-between mb-2">
                                <span class="font-medium mr-4">Subtotal:</span>
                                <span>$0.00</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span class="font-medium mr-4">Tax (10%):</span>
                                <span>$0.00</span>
                            </div>
                            <div class="flex justify-between font-bold">
                                <span class="mr-4">Total:</span>
                                <span>$0.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" class="btn btn-outline close-modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Invoice</button>
                    </div>
                </form>
                    <div class="flex justify-end gap-2">
                        <button type="button" class="btn btn-outline close-modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Invoice</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebar-toggle').addEventListener('click', function () {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
        });

        // Navigation
        const sidebarItems = document.querySelectorAll('.sidebar-item');
        const sections = document.querySelectorAll('.section');

        sidebarItems.forEach(item => {
            item.addEventListener('click', function (e) {
                e.preventDefault();
                const targetSection = this.getAttribute('data-section');

                // Update active sidebar item
                sidebarItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');

                // Show target section, hide others
                sections.forEach(section => {
                    if (section.id === targetSection + '-section') {
                        section.classList.remove('hidden');
                        section.classList.add('active');
                    } else {
                        section.classList.add('hidden');
                        section.classList.remove('active');
                    }
                });

                // Hide sidebar on mobile after navigation
                if (window.innerWidth < 768) {
                    document.getElementById('sidebar').classList.add('hidden');
                }
            });
        });

        // Tab switching
        const tabs = document.querySelectorAll('.tab');
        tabs.forEach(tab => {
            tab.addEventListener('click', function () {
                const tabGroup = this.parentElement.querySelectorAll('.tab');
                tabGroup.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Modal handling
        const modals = {
            'add-patient-btn': 'add-patient-modal',
            'add-appointment-btn': 'add-appointment-modal',
            'create-invoice-btn': 'create-invoice-modal'
        };

        // Open modals
        Object.keys(modals).forEach(btnId => {
            const btn = document.getElementById(btnId);
            if (btn) {
                btn.addEventListener('click', function () {
                    document.getElementById(modals[btnId]).classList.remove('hidden');
                });
            }
        });

        // Close modals
        document.querySelectorAll('.close-modal').forEach(btn => {
            btn.addEventListener('click', function () {
                this.closest('[id$="-modal"]').classList.add('hidden');
            });
        });

        // Close modal when clicking outside
        window.addEventListener('click', function (e) {
            document.querySelectorAll('[id$="-modal"]').forEach(modal => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });

        // Form submissions
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                // Here you would normally send the data to a server
                // For this demo, we'll just close the modal
                this.closest('[id$="-modal"]').classList.add('hidden');

                // Show a success message
                alert('Form submitted successfully!');
            });
        });
    </script>
        </div>
    </div>

    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebar-toggle').addEventListener('click', function () {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
        });

        // Navigation
        const sidebarItems = document.querySelectorAll('.sidebar-item');
        const sections = document.querySelectorAll('.section');

        sidebarItems.forEach(item => {
            item.addEventListener('click', function (e) {
                e.preventDefault();
                const targetSection = this.getAttribute('data-section');

                // Update active sidebar item
                sidebarItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');

                // Show target section, hide others
                sections.forEach(section => {
                    if (section.id === targetSection + '-section') {
                        section.classList.remove('hidden');
                        section.classList.add('active');
                    } else {
                        section.classList.add('hidden');
                        section.classList.remove('active');
                    }
                });

                // Hide sidebar on mobile after navigation
                if (window.innerWidth < 768) {
                    document.getElementById('sidebar').classList.add('hidden');
                }
            });
        });

        // Tab switching
        const tabs = document.querySelectorAll('.tab');
        tabs.forEach(tab => {
            tab.addEventListener('click', function () {
                const tabGroup = this.parentElement.querySelectorAll('.tab');
                tabGroup.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Modal handling
        const modals = {
            'add-patient-btn': 'add-patient-modal',
            'add-appointment-btn': 'add-appointment-modal',
            'create-invoice-btn': 'create-invoice-modal'
        };

        // Open modals
        Object.keys(modals).forEach(btnId => {
            const btn = document.getElementById(btnId);
            if (btn) {
                btn.addEventListener('click', function () {
                    document.getElementById(modals[btnId]).classList.remove('hidden');
                });
            }
        });

        // Close modals
        document.querySelectorAll('.close-modal').forEach(btn => {
            btn.addEventListener('click', function () {
                this.closest('[id$="-modal"]').classList.add('hidden');
            });
        });

        // Close modal when clicking outside
        window.addEventListener('click', function (e) {
            document.querySelectorAll('[id$="-modal"]').forEach(modal => {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });

        // Form submissions
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                // Here you would normally send the data to a server
                // For this demo, we'll just close the modal
                this.closest('[id$="-modal"]').classList.add('hidden');

                // Show a success message
                alert('Form submitted successfully!');
            });
        });
    </script>
</body>


</html>