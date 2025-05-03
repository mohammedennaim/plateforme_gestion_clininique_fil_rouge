<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Plateforme de gestion de clinique">
    <meta name="author" content="">
    <title>@yield('title', 'Tableau de Bord') - Administration</title>

    <!-- Custom fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#EBF4FF',
                            100: '#D1E1FD',
                            500: '#4E73DF',
                            600: '#3A66DB',
                            700: '#2653B8',
                            800: '#1E429F',
                            900: '#1A365D',
                        },
                    },
                },
            },
        }
    </script>

    <!-- Custom styles -->
    <style>
        /* Base styles */
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f3f4f6;
        }

        /* Sidebar styles */
        #sidebar {
            height: 100vh;
            width: 16rem;
            position: fixed;
            z-index: 10;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .sidebar-link {
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .sidebar-link:hover {
            background-color: rgba(78, 115, 223, 0.1);
            border-left-color: #4E73DF;
        }

        .sidebar-link.active {
            background-color: rgba(78, 115, 223, 0.2);
            border-left-color: #4E73DF;
            color: #4E73DF;
            font-weight: 600;
        }

        /* Animations */
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Card hover effects */
        .hover-card {
            transition: all 0.3s ease;
        }

        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        /* Toggle styles */
        .toggle-checkbox:checked {
            right: 0;
            border-color: #4E73DF;
        }

        .toggle-checkbox:checked+.toggle-label {
            background-color: #4E73DF;
        }

        .scroll-to-top {
            position: fixed;
            right: 1rem;
            bottom: 1rem;
            width: 2.75rem;
            height: 2.75rem;
            text-align: center;
            background: rgba(90, 92, 105, 0.5);
            line-height: 46px;
            display: none;
        }

        .scroll-to-top:hover {
            background-color: #5a5c69;
        }

        .scroll-to-top i {
            color: white;
            font-weight: 800;
        }

        /* Status indicators */
        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }

        .status-dot.status-active {
            background-color: #10B981;
        }

        .status-dot.status-inactive {
            background-color: #EF4444;
        }

        .status-dot.status-pending {
            background-color: #F59E0B;
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            #sidebar {
                transform: translateX(-100%);
            }

            #sidebar.show {
                transform: translateX(0);
            }

            #content-wrapper {
                margin-left: 0 !important;
            }
        }
    </style>
</head>

<body class="bg-gray-100">

    <div id="content-wrapper" class="flex-1 flex flex-col transition-all duration-300 ease-in-out">
        <!-- Main Content -->
        <div id="content" class="flex-1 overflow-y-auto">
            <!-- Topbar -->
            <nav class="bg-white shadow-md flex items-center justify-between p-4 sticky top-0 z-10">
                <!-- Sidebar Toggle (Topbar) -->
                <button id="sidebarToggle" class="md:hidden rounded-full p-2 focus:outline-none hover:bg-gray-100">
                    <i class="fa fa-bars"></i>
                </button>

                <!-- Page Title -->
                <div class="hidden md:block">
                    <h1 class="text-xl font-bold text-gray-800">@yield('page-title', 'Tableau de Bord')</h1>
                </div>

                <!-- Topbar Navbar -->
                <ul class="flex items-center ml-auto">
                    <!-- Search Icon (Mobile) -->
                    <li class="md:hidden relative">
                        <button class="p-2 rounded-full hover:bg-gray-100 focus:outline-none">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </li>
                    <!-- Nav Item - Alerts -->
                    <li class="relative mx-1" x-data="{ open: false }">
                        <button @click="open = !open" class="p-2 rounded-full hover:bg-gray-100 focus:outline-none">
                            <i class="fas fa-bell fa-fw"></i>
                            <!-- Counter - Alerts -->
                            <span
                                class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">3</span>
                        </button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg py-1 z-50">
                            <h6 class="px-4 py-2 font-bold text-xs text-gray-500 border-b border-gray-200">
                                CENTRE DE NOTIFICATIONS
                            </h6>
                            <div class="max-h-60 overflow-y-auto">
                                <a class="flex px-4 py-3 hover:bg-gray-100 border-b border-gray-200" href="#">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-10 h-10 rounded-full bg-primary-100 text-primary-500 flex items-center justify-center">
                                            <i class="fas fa-calendar-check"></i>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Nouveau rendez-vous</p>
                                        <p class="text-xs text-gray-500">Il y a 30 minutes</p>
                                    </div>
                                </a>
                                <a class="flex px-4 py-3 hover:bg-gray-100 border-b border-gray-200" href="#">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-10 h-10 rounded-full bg-red-100 text-red-500 flex items-center justify-center">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Annulation rendez-vous</p>
                                        <p class="text-xs text-gray-500">Il y a 2 heures</p>
                                    </div>
                                </a>
                                <a class="flex px-4 py-3 hover:bg-gray-100" href="#">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-10 h-10 rounded-full bg-green-100 text-green-500 flex items-center justify-center">
                                            <i class="fas fa-user-plus"></i>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Nouveau patient</p>
                                        <p class="text-xs text-gray-500">Il y a 3 heures</p>
                                    </div>
                                </a>
                            </div>
                            <a class="block text-center text-sm font-medium text-primary-500 py-2 border-t border-gray-200 hover:bg-gray-50"
                                href="#">
                                Voir toutes les notifications
                            </a>
                        </div>
                    </li>

                    <!-- Nav Item - Messages -->
                    <li class="relative mx-1" x-data="{ open: false }">
                        <button @click="open = !open" class="p-2 rounded-full hover:bg-gray-100 focus:outline-none">
                            <i class="fas fa-envelope fa-fw"></i>
                            <!-- Counter - Messages -->
                            <span
                                class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">7</span>
                        </button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg py-1 z-50">
                            <h6 class="px-4 py-2 font-bold text-xs text-gray-500 border-b border-gray-200">
                                CENTRE DE MESSAGES
                            </h6>
                            <div class="max-h-60 overflow-y-auto">
                                <a class="flex px-4 py-3 hover:bg-gray-100 border-b border-gray-200" href="#">
                                    <img class="h-8 w-8 rounded-full mr-3"
                                        src="https://ui-avatars.com/api/?name=Pierre+Durand&background=4e73df&color=ffffff"
                                        alt="Pierre Durand">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Pierre Durand</p>
                                        <p class="text-xs text-gray-500 truncate max-w-[15rem]">Bonjour, je voudrais
                                            confirmer mon rendez-vous</p>
                                        <p class="text-xs text-gray-400">Il y a 15 min</p>
                                    </div>
                                </a>
                                <a class="flex px-4 py-3 hover:bg-gray-100 border-b border-gray-200" href="#">
                                    <img class="h-8 w-8 rounded-full mr-3"
                                        src="https://ui-avatars.com/api/?name=Marie+Dupont&background=4e73df&color=ffffff"
                                        alt="Marie Dupont">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Marie Dupont</p>
                                        <p class="text-xs text-gray-500 truncate max-w-[15rem]">Est-ce que je dois être
                                            à jeun pour mon analyse?</p>
                                        <p class="text-xs text-gray-400">Il y a 2 h</p>
                                    </div>
                                </a>
                            </div>
                            <a class="block text-center text-sm font-medium text-primary-500 py-2 border-t border-gray-200 hover:bg-gray-50"
                                href="#">
                                Voir tous les messages
                            </a>
                        </div>
                    </li>

                    <div class="hidden sm:block mx-4 h-8 border-l border-gray-300"></div>

                    <!-- Nav Item - User Information -->
                    <li class="relative">
                        <div x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center focus:outline-none"
                                id="userDropdown">
                                <span class="mr-2 hidden lg:block text-gray-600 text-sm">{{ Auth::user()->name }}</span>
                                <img class="h-8 w-8 rounded-full border-2 border-primary-100"
                                    src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&size=64&background=4e73df&color=ffffff">
                            </button>
                            <!-- Dropdown - User Information -->
                            <div x-show="open" @click.away="open = false"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    href="{{ route('admin.profile') }}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profil
                                </a>
                                <a class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    href="{{ route('admin.settings') }}">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Paramètres
                                </a>
                                <a class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activité
                                </a>
                                <div class="border-t border-gray-100"></div>
                                <a class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Déconnexion
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </li>
                </ul>
            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="p-4 md:p-6 fade-in">
                @yield('content')
            </div>
            <!-- End of Page Content -->
        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="mt-auto bg-white py-4 px-6 border-t border-gray-200">
            <div class="container mx-auto">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="text-center md:text-left text-gray-600 text-sm">
                        <span>Copyright &copy; Clinique Admin {{ date('Y') }}</span>
                    </div>
                    <div class="mt-2 md:mt-0">
                        <ul class="flex space-x-4">
                            <li><a href="#" class="text-gray-500 hover:text-primary-500 transition-colors"><i
                                        class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#" class="text-gray-500 hover:text-primary-500 transition-colors"><i
                                        class="fab fa-twitter"></i></a></li>
                            <li><a href="#" class="text-gray-500 hover:text-primary-500 transition-colors"><i
                                        class="fab fa-linkedin-in"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->
    </div>


    <a class="scroll-to-top rounded hidden" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const contentWrapper = document.getElementById('content-wrapper');

            function toggleSidebar() {
                sidebar.classList.toggle('show');

                if (window.innerWidth >= 768) {
                    if (contentWrapper.classList.contains('ml-64')) {
                        contentWrapper.classList.remove('ml-64');
                        contentWrapper.classList.add('ml-0');
                    } else {
                        contentWrapper.classList.remove('ml-0');
                        contentWrapper.classList.add('ml-64');
                    }
                }
            }

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', toggleSidebar);
            }

            // Scroll to top button
            const scrollToTopButton = document.querySelector('.scroll-to-top');

            window.addEventListener('scroll', function () {
                if (window.pageYOffset > 100) {
                    scrollToTopButton.classList.remove('hidden');
                    scrollToTopButton.classList.add('flex');
                } else {
                    scrollToTopButton.classList.remove('flex');
                    scrollToTopButton.classList.add('hidden');
                }
            });

            scrollToTopButton.addEventListener('click', function (e) {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            // Handle responsive layout
            function handleResize() {
                if (window.innerWidth < 768) {
                    sidebar.classList.remove('show');
                    contentWrapper.classList.remove('ml-64');
                    contentWrapper.classList.add('ml-0');
                } else {
                    sidebar.classList.remove('-translate-x-full');
                    contentWrapper.classList.remove('ml-0');
                    contentWrapper.classList.add('ml-64');
                }
            }

            // Initial check on page load
            handleResize();

            // Listen for window resize events
            window.addEventListener('resize', handleResize);

            // Initialize tooltip for all elements with data-tooltip attribute
            const tooltipElements = document.querySelectorAll('[data-tooltip]');
            tooltipElements.forEach(element => {
                element.addEventListener('mouseenter', function () {
                    const tooltip = document.createElement('div');
                    tooltip.className = 'absolute bg-gray-800 text-white text-xs rounded py-1 px-2 z-50';
                    tooltip.textContent = this.getAttribute('data-tooltip');
                    tooltip.style.bottom = 'calc(100% + 5px)';
                    tooltip.style.left = '50%';
                    tooltip.style.transform = 'translateX(-50%)';
                    this.style.position = 'relative';
                    this.appendChild(tooltip);
                });

                element.addEventListener('mouseleave', function () {
                    const tooltip = this.querySelector('.absolute');
                    if (tooltip) {
                        tooltip.remove();
                    }
                });
            });
        });
    </script>

    @yield('scripts')
</body>

</html>