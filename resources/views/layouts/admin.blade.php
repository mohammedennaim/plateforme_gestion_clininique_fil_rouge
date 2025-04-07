<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="MediClinic - Admin Dashboard">
    <meta name="author" content="MediClinic">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') | MediClinic</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            300: '#a5b4fc',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
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
                    transitionProperty: {
                        'width': 'width',
                        'spacing': 'margin, padding',
                    }
                }
            },
            variants: {
                extend: {},
            },
            plugins: [],
        }
    </script>
    
    <!-- Framer Motion -->
    <script src="https://unpkg.com/framer-motion@10.16.4/dist/framer-motion.umd.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Toastify -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    
    <style type="text/tailwindcss">
        @layer utilities {
            .sidebar-expanded {
                width: 16rem;
            }
            .sidebar-collapsed {
                width: 5rem;
            }
            .content-expanded {
                margin-left: 5rem;
            }
            .content-collapsed {
                margin-left: 16rem;
            }
        }
        
        .appointment-card {
            transition: all 0.3s ease;
        }
        
        .appointment-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        
        .stat-card {
            transition: all 0.2s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-3px);
        }
        
        .activity-timeline::before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            left: 20px;
            width: 2px;
            background-color: #e5e7eb;
        }
    </style>
    
    @yield('styles')
</head>

<body class="font-sans antialiased h-full bg-gray-50 flex overflow-x-hidden">
    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 bg-gradient-to-b from-primary-600 to-primary-800 text-white z-50 transition-width duration-300 ease-in-out sidebar-expanded">
        <div class="flex flex-col h-full">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 px-4">
                <a href="" class="flex items-center space-x-2">
                    <span class="text-2xl">
                        <i class="fas fa-clinic-medical"></i>
                    </span>
                    <span class="font-bold text-xl sidebar-text">MediClinic</span>
                </a>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 pt-5 pb-4">
                <div class="px-4">
                    <h3 class="text-xs font-semibold text-primary-100 uppercase tracking-wider pb-2">
                        Main
                    </h3>
                </div>
                <a href="" class="group flex items-center px-6 py-3 text-sm font-medium {{ request()->is('admin/dashboard') ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-700 hover:text-white' }} transition duration-150 ease-in-out">
                    <i class="fas fa-tachometer-alt w-5 h-5 mr-3"></i>
                    <span class="sidebar-text">Dashboard</span>
                </a>
                
                <div class="px-4 mt-6">
                    <h3 class="text-xs font-semibold text-primary-100 uppercase tracking-wider pb-2">
                        Management
                    </h3>
                </div>
                <a href="" class="group flex items-center px-6 py-3 text-sm font-medium {{ request()->is('admin/patients*') ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-700 hover:text-white' }} transition duration-150 ease-in-out">
                    <i class="fas fa-users w-5 h-5 mr-3"></i>
                    <span class="sidebar-text">Patients</span>
                </a>
                <a href="" class="group flex items-center px-6 py-3 text-sm font-medium {{ request()->is('admin/doctors*') ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-700 hover:text-white' }} transition duration-150 ease-in-out">
                    <i class="fas fa-user-md w-5 h-5 mr-3"></i>
                    <span class="sidebar-text">Doctors</span>
                </a>
                <a href="" class="group flex items-center px-6 py-3 text-sm font-medium relative {{ request()->is('admin/appointments*') ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-700 hover:text-white' }} transition duration-150 ease-in-out">
                    <i class="fas fa-calendar-check w-5 h-5 mr-3"></i>
                    <span class="sidebar-text">Appointments</span>
                    <span class="bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center ml-auto">12</span>
                </a>
                <a href="" class="group flex items-center px-6 py-3 text-sm font-medium {{ request()->is('admin/records*') ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-700 hover:text-white' }} transition duration-150 ease-in-out">
                    <i class="fas fa-file-medical w-5 h-5 mr-3"></i>
                    <span class="sidebar-text">Medical Records</span>
                </a>
                
                <div class="px-4 mt-6">
                    <h3 class="text-xs font-semibold text-primary-100 uppercase tracking-wider pb-2">
                        Finance
                    </h3>
                </div>
                <a href="" class="group flex items-center px-6 py-3 text-sm font-medium {{ request()->is('admin/billing*') ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-700 hover:text-white' }} transition duration-150 ease-in-out">
                    <i class="fas fa-file-invoice-dollar w-5 h-5 mr-3"></i>
                    <span class="sidebar-text">Billing</span>
                </a>
                <a href="" class="group flex items-center px-6 py-3 text-sm font-medium {{ request()->is('admin/reports*') ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-700 hover:text-white' }} transition duration-150 ease-in-out">
                    <i class="fas fa-chart-bar w-5 h-5 mr-3"></i>
                    <span class="sidebar-text">Reports</span>
                </a>
                
                <div class="px-4 mt-6">
                    <h3 class="text-xs font-semibold text-primary-100 uppercase tracking-wider pb-2">
                        System
                    </h3>
                </div>
                <a href="" class="group flex items-center px-6 py-3 text-sm font-medium {{ request()->is('admin/settings*') ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-700 hover:text-white' }} transition duration-150 ease-in-out">
                    <i class="fas fa-cog w-5 h-5 mr-3"></i>
                    <span class="sidebar-text">Settings</span>
                </a>
                <a href="" class="group flex items-center px-6 py-3 text-sm font-medium {{ request()->is('admin/users*') ? 'bg-primary-700 text-white' : 'text-primary-100 hover:bg-primary-700 hover:text-white' }} transition duration-150 ease-in-out">
                    <i class="fas fa-user-cog w-5 h-5 mr-3"></i>
                    <span class="sidebar-text">User Management</span>
                </a>
            </nav>
            
            <!-- Sidebar toggle button -->
            <div class="border-t border-primary-700 p-4">
                <button id="sidebarToggle" class="flex items-center justify-center w-full h-10 bg-primary-700 hover:bg-primary-600 text-primary-100 rounded-lg transition-colors duration-150 ease-in-out">
                    <i id="sidebarToggleIcon" class="fas fa-chevron-left"></i>
                </button>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div id="main-content" class="flex-1 ml-64 transition-all duration-300 ease-in-out">
        <!-- Header -->
        <header class="bg-white shadow-sm z-10 relative">
            <div class="flex justify-between items-center h-16 px-4 sm:px-6 lg:px-8">
                <!-- Mobile menu button -->
                <button id="mobile-menu-button" class="md:hidden rounded-md p-2 inline-flex items-center justify-center text-gray-500 hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary-500">
                    <span class="sr-only">Open sidebar</span>
                    <i class="fas fa-bars"></i>
                </button>
                
                <!-- Date and welcome message -->
                <div class="hidden md:flex items-center">
                    <div class="text-gray-600">
                        <span id="current-date" class="text-sm font-medium">Saturday, April 5, 2025</span>
                        <span class="mx-2 text-gray-400">|</span>
                        <span id="current-time" class="text-sm font-medium">08:22:33</span>
                    </div>
                </div>
                
                <!-- Search bar -->
                <div class="flex-1 max-w-lg mx-auto px-4 md:px-0">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" id="search" name="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-primary-500 focus:ring-1 focus:ring-primary-500 sm:text-sm" placeholder="Search patients, doctors, appointments...">
                    </div>
                </div>
                
                <!-- Right side navigation -->
                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <div class="relative">
                        <button aria-label="View notifications" class="relative rounded-full p-1 text-gray-500 hover:bg-gray-100 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                            <span class="sr-only">View notifications</span>
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-0 right-0 block h-4 w-4 rounded-full bg-red-500 text-xs text-white font-bold flex items-center justify-center transform -translate-y-1/2 translate-x-1/2">3</span>
                        </button>
                    </div>
                    
                    <!-- Messages -->
                    <div class="relative">
                        <button aria-label="View messages" class="relative rounded-full p-1 text-gray-500 hover:bg-gray-100 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                            <span class="sr-only">View messages</span>
                            <i class="fas fa-envelope"></i>
                            <span class="absolute top-0 right-0 block h-4 w-4 rounded-full bg-red-500 text-xs text-white font-bold flex items-center justify-center transform -translate-y-1/2 translate-x-1/2">7</span>
                        </button>
                    </div>
                    
                    <!-- Profile dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button id="user-menu-button" class="flex items-center space-x-3 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 rounded-full">
                            <span class="sr-only">Open user menu</span>
                            <div class="hidden md:block text-right">
                                <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name ?? 'Mohammed Ennaim' }}</span>
                                <p class="text-xs text-gray-500">Admin</p>
                            </div>
                            <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_image ?? 'https://ui-avatars.com/api/?name=Mohammed+Ennaim&background=6366F1&color=ffffff' }}" alt="User profile">
                            <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                        </button>
                        
                        <!-- Profile dropdown panel -->
                        <div id="user-menu-dropdown" class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Settings
                            </a>
                            <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                Activity Log
                            </a>
                            <div class="border-t border-gray-100"></div>
                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto bg-gray-50 p-4 sm:p-6 lg:p-8">
            <!-- Dashboard content -->
            @yield('content')
            
            <!-- Footer -->
            <footer class="mt-auto py-4">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <p class="text-center text-sm text-gray-500">
                        &copy; 2025 MediClinic. All rights reserved.
                    </p>
                </div>
            </footer>
        </main>
    </div>
    
    <!-- Back to top button -->
    <button id="back-to-top" aria-label="Back to top" class="hidden fixed right-4 bottom-4 rounded-full bg-primary-600 p-2 text-white shadow-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
        <span class="sr-only">Back to top</span>
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- Add appointment modal -->
    <div id="addAppointmentModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl transform transition-all">
                <!-- Modal header -->
                <div class="bg-primary-600 px-4 py-3 rounded-t-lg flex items-center justify-between">
                    <h3 class="text-lg font-medium text-white">
                        <i class="fas fa-calendar-plus mr-2"></i>Add New Appointment
                    </h3>
                    <button id="closeAppointmentModal" class="text-white hover:text-gray-200 focus:outline-none">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                
                <!-- Modal body -->
                <div class="px-4 py-5 sm:p-6">
                    <form id="appointmentForm">
                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="patient" class="block text-sm font-medium text-gray-700">Patient</label>
                                <div class="mt-1">
                                    <select id="patient" name="patient" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                        <option value="">Select Patient</option>
                                        <option value="1">John Doe</option>
                                        <option value="2">Jane Smith</option>
                                        <option value="3">Robert Johnson</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="sm:col-span-3">
                                <label for="doctor" class="block text-sm font-medium text-gray-700">Doctor</label>
                                <div class="mt-1">
                                    <select id="doctor" name="doctor" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                        <option value="">Select Doctor</option>
                                        <option value="1">Dr. Ahmed Lahlou</option>
                                        <option value="2">Dr. Leila Bouzidi</option>
                                        <option value="3">Dr. Omar Tazi</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="sm:col-span-3">
                                <label for="appointmentDate" class="block text-sm font-medium text-gray-700">Date</label>
                                <div class="mt-1">
                                    <input type="date" name="appointmentDate" id="appointmentDate" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                </div>
                            </div>
                            
                            <div class="sm:col-span-3">
                                <label for="appointmentTime" class="block text-sm font-medium text-gray-700">Time</label>
                                <div class="mt-1">
                                    <input type="time" name="appointmentTime" id="appointmentTime" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                </div>
                            </div>
                            
                            <div class="sm:col-span-6">
                                <label for="appointmentType" class="block text-sm font-medium text-gray-700">Appointment Type</label>
                                <div class="mt-1">
                                    <select id="appointmentType" name="appointmentType" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm">
                                        <option value="">Select Type</option>
                                        <option value="check-up">Check-up</option>
                                        <option value="follow-up">Follow-up</option>
                                        <option value="consultation">Consultation</option>
                                        <option value="emergency">Emergency</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="sm:col-span-6">
                                <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                                <div class="mt-1">
                                    <textarea id="notes" name="notes" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"></textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- Modal footer -->
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-lg">
                    <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Schedule Appointment
                    </button>
                    <button type="button" id="cancelAppointmentBtn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle functionality
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarToggleIcon = document.getElementById('sidebarToggleIcon');
            const sidebarTexts = document.querySelectorAll('.sidebar-text');
            
            // Initialize with animation from Framer Motion
            const { animate } = window.Motion;
            
            sidebarToggle.addEventListener('click', function() {
                const isExpanded = sidebar.classList.contains('sidebar-expanded');
                
                if (isExpanded) {
                    // Collapse sidebar
                    animate(sidebar, { width: '5rem' }, { duration: 0.3 });
                    animate(mainContent, { marginLeft: '5rem' }, { duration: 0.3 });
                    sidebarToggleIcon.classList.replace('fa-chevron-left', 'fa-chevron-right');
                    
                    // Hide text elements with animation
                    sidebarTexts.forEach(text => {
                        animate(text, { opacity: 0 }, { duration: 0.15 });
                        text.style.display = 'none';
                    });
                    
                    setTimeout(() => {
                        sidebar.classList.remove('sidebar-expanded');
                        sidebar.classList.add('sidebar-collapsed');
                        mainContent.classList.remove('content-collapsed');
                        mainContent.classList.add('content-expanded');
                    }, 300);
                } else {
                    // Expand sidebar
                    animate(sidebar, { width: '16rem' }, { duration: 0.3 });
                    animate(mainContent, { marginLeft: '16rem' }, { duration: 0.3 });
                    sidebarToggleIcon.classList.replace('fa-chevron-right', 'fa-chevron-left');
                    
                    // Show text elements with animation
                    sidebarTexts.forEach(text => {
                        text.style.display = 'inline';
                        animate(text, { opacity: 1 }, { delay: 0.1, duration: 0.2 });
                    });
                    
                    setTimeout(() => {
                        sidebar.classList.remove('sidebar-collapsed');
                        sidebar.classList.add('sidebar-expanded');
                        mainContent.classList.remove('content-expanded');
                        mainContent.classList.add('content-collapsed');
                    }, 300);
                }
            });
            
            // User menu dropdown
            const userMenuButton = document.getElementById('user-menu-button');
            const userMenuDropdown = document.getElementById('user-menu-dropdown');
            
            userMenuButton.addEventListener('click', function() {
                const isHidden = userMenuDropdown.classList.contains('hidden');
                
                if (isHidden) {
                    userMenuDropdown.classList.remove('hidden');
                    animate(userMenuDropdown, 
                        { opacity: [0, 1], scale: [0.95, 1] }, 
                        { duration: 0.2, ease: 'easeOut' }
                    );
                } else {
                    animate(userMenuDropdown, 
                        { opacity: [1, 0], scale: [1, 0.95] }, 
                        { duration: 0.15, ease: 'easeIn', onComplete: () => {
                            userMenuDropdown.classList.add('hidden');
                        }}
                    );
                }
            });
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!userMenuButton.contains(event.target) && !userMenuDropdown.contains(event.target)) {
                    if (!userMenuDropdown.classList.contains('hidden')) {
                        animate(userMenuDropdown, 
                            { opacity: [1, 0], scale: [1, 0.95] }, 
                            { duration: 0.15, ease: 'easeIn', onComplete: () => {
                                userMenuDropdown.classList.add('hidden');
                            }}
                        );
                    }
                }
            });
            
            // Mobile menu button
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            
            mobileMenuButton.addEventListener('click', function() {
                const isSidebarHidden = sidebar.classList.contains('translate-x-full');
                
                if (isSidebarHidden) {
                    sidebar.classList.remove('translate-x-full');
                    animate(sidebar, { x: ['-100%', '0%'] }, { duration: 0.3 });
                } else {
                    animate(sidebar, { x: ['0%', '-100%'] }, { 
                        duration: 0.3,
                        onComplete: () => {
                            sidebar.classList.add('translate-x-full');
                        }
                    });
                }
            });
            
            // Back to top button
            const backToTopButton = document.getElementById('back-to-top');
            
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    if (backToTopButton.classList.contains('hidden')) {
                        backToTopButton.classList.remove('hidden');
                        animate(backToTopButton, { opacity: [0, 1], scale: [0.5, 1] }, { duration: 0.3 });
                    }
                } else {
                    if (!backToTopButton.classList.contains('hidden')) {
                        animate(backToTopButton, { opacity: [1, 0], scale: [1, 0.5] }, { 
                            duration: 0.3,
                            onComplete: () => {
                                backToTopButton.classList.add('hidden');
                            }
                        });
                    }
                }
            });
            
            backToTopButton.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
            
            // Update current date and time
            const currentDate = document.getElementById('current-date');
            const currentTime = document.getElementById('current-time');
            
            function updateDateTime() {
                const now = new Date();
                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                currentDate.textContent = now.toLocaleDateString('en-US', options);
                
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                currentTime.textContent = `${hours}:${minutes}:${seconds}`;
            }
            
            updateDateTime();
            setInterval(updateDateTime, 1000);
            
            // Add appointment modal functionality
            const addAppointmentBtns = document.querySelectorAll('.add-appointment-btn');
            const addAppointmentModal = document.getElementById('addAppointmentModal');
            const closeAppointmentModal = document.getElementById('closeAppointmentModal');
            const cancelAppointmentBtn = document.getElementById('cancelAppointmentBtn');
            
            function openAppointmentModal() {
                addAppointmentModal.classList.remove('hidden');
                animate(addAppointmentModal.querySelector('.max-w-2xl'), 
                    { opacity: [0, 1], scale: [0.9, 1] }, 
                    { duration: 0.3 }
                );
            }
            
            function closeAppointmentModalFunc() {
                animate(addAppointmentModal.querySelector('.max-w-2xl'), 
                    { opacity: [1, 0], scale: [1, 0.9] }, 
                    { duration: 0.2, onComplete: () => {
                        addAppointmentModal.classList.add('hidden');
                    }}
                );
            }
            
            addAppointmentBtns.forEach(btn => {
                btn.addEventListener('click', openAppointmentModal);
            });
            
            closeAppointmentModal.addEventListener('click', closeAppointmentModalFunc);
            cancelAppointmentBtn.addEventListener('click', closeAppointmentModalFunc);
            
            // Toast notifications
            @if(session('success'))
                Toastify({
                    text: "{{ session('success') }}",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#10B981",
                    stopOnFocus: true,
                }).showToast();
            @endif
            
            @if(session('error'))
                Toastify({
                    text: "{{ session('error') }}",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#EF4444",
                    stopOnFocus: true,
                }).showToast();
            @endif
            
            @if(session('warning'))
                Toastify({
                    text: "{{ session('warning') }}",
                    duration: 3000,
                    close: true,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#F59E0B",
                    stopOnFocus: true,
                }).showToast();
            @endif
        });
    </script>
    
    @yield('scripts')
</body>
</html>