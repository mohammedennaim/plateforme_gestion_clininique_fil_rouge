<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Keep the existing head content -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Clinic Management System">
    <meta name="author" content="Your Name">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Clinic Management') }} - Admin Dashboard</title>

    <!-- Custom fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #4e73df;
            --secondary: #5a5c69;
            --success: #1cc88a;
            --info: #36b9cc;
            --warning: #f6c23e;
            --danger: #e74a3b;
            --light: #f8f9fc;
            --dark: #5a5c69;
            --sidebar-width: 225px;
            --sidebar-collapsed-width: 90px;
            --transition-speed: 0.35s;
        }

        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background-color: #4e73df;
            background-image: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            background-size: cover;
            position: fixed;
            z-index: 100;
            transition: width var(--transition-speed) ease;
            overflow-x: hidden;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .sidebar.toggled {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-brand {
            height: 4.375rem;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 800;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 0.05rem;
            z-index: 1;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem 1rem;
            white-space: nowrap;
        }

        .sidebar hr {
            margin: 0 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
        }

        .sidebar .nav-item {
            position: relative;
        }

        .sidebar .nav-item .nav-link {
            display: flex;
            align-items: center;
            width: 100%;
            text-align: left;
            padding: 0.75rem 1rem;
            color: rgba(255, 255, 255, 0.8);
            white-space: nowrap;
        }

        .sidebar .nav-item .nav-link:hover,
        .sidebar .nav-item .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #fff;
            padding-left: calc(1rem - 4px);
        }

        .sidebar .nav-item .nav-link i {
            margin-right: 0.5rem;
            width: 1.25rem;
            font-size: 1.1rem;
            text-align: center;
        }

        .sidebar .sidebar-heading {
            padding: 0.75rem 1rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 800;
            color: rgba(255, 255, 255, 0.5);
            white-space: nowrap;
        }

        .sidebar.toggled .sidebar-brand .sidebar-brand-text {
            display: none;
        }

        .sidebar.toggled .nav-item .nav-link span,
        .sidebar.toggled .sidebar-heading {
            width: 0;
            visibility: hidden;
            opacity: 0;
            display: none;
        }

        .sidebar.toggled .nav-item .nav-link {
            text-align: center;
            padding: 1rem;
        }

        .sidebar.toggled .nav-item .nav-link i {
            margin-right: 0;
            font-size: 1.2rem;
        }

        .sidebar.toggled #sidebarToggle::after {
            content: '\f105';
        }

        .sidebar #sidebarToggle {
            width: 2.5rem;
            height: 2.5rem;
            text-align: center;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s;
        }

        .sidebar #sidebarToggle:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.8);
        }

        .sidebar #sidebarToggle::after {
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            content: '\f104';
            transition: all 0.3s;
        }

        .content-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            background-color: #f8f9fc;
            transition: margin-left var(--transition-speed) ease;
        }

        body.sidebar-toggled .content-wrapper {
            margin-left: var(--sidebar-collapsed-width);
        }

        .topbar {
            height: 4.375rem;
            background-color: #fff;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .topbar .nav-item .nav-link {
            position: relative;
            height: 4.375rem;
            display: flex;
            align-items: center;
            color: #d1d3e2;
        }

        .topbar .nav-item .nav-link:hover {
            color: #4e73df;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .card .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
        }

        .border-left-primary {
            border-left: 0.25rem solid var(--primary) !important;
        }

        .border-left-success {
            border-left: 0.25rem solid var(--success) !important;
        }

        .border-left-info {
            border-left: 0.25rem solid var(--info) !important;
        }

        .border-left-warning {
            border-left: 0.25rem solid var(--warning) !important;
        }

        .border-left-danger {
            border-left: 0.25rem solid var(--danger) !important;
        }

        .sidebar.toggled .nav-item {
            position: relative;
        }

        .sidebar.toggled .nav-item:hover::after {
            content: attr(data-title);
            position: absolute;
            left: 100%;
            top: 0;
            background: #2e59d9;
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 0 4px 4px 0;
            white-space: nowrap;
            z-index: 99;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        /* Footer */
        footer.sticky-footer {
            padding: 2rem 0;
            flex-shrink: 0;
            background-color: #fff;
            box-shadow: 0 -0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        @media (max-width: 768px) {
            .sidebar {
                width: var(--sidebar-collapsed-width);
            }

            .sidebar .nav-item .nav-link span,
            .sidebar .sidebar-heading,
            .sidebar-brand .sidebar-brand-text {
                display: none;
            }

            .sidebar .nav-item .nav-link {
                text-align: center;
                padding: 1rem;
            }

            .sidebar .nav-item .nav-link i {
                margin-right: 0;
                font-size: 1.2rem;
            }

            .content-wrapper {
                margin-left: var(--sidebar-collapsed-width);
            }

            .sidebar #sidebarToggle::after {
                content: '\f105';
            }
        }

        .img-profile {
            height: 2rem;
            width: 2rem;
            border: 2px solid #eaecf4;
        }

        .badge-counter {
            position: absolute;
            transform: scale(0.7);
            transform-origin: top right;
            right: 0.25rem;
            top: 0.25rem;
        }

        .animated--grow-in {
            animation: growIn 0.2s ease;
        }

        @keyframes growIn {
            0% {
                transform: scale(0.9);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
    </style>

    @yield('styles')
</head>

<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/admin">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-clinic-medical"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Clinic Admin</div>
            </a>

            <hr class="sidebar-divider my-0">
            <li class="nav-item {{ request()->is('admin') ? 'active' : '' }}" data-title="Dashboard">
                <a class="nav-link" href="/admin">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading text-white-50">
                Management
            </div>

            <li class="nav-item {{ request()->is('admin/patients*') ? 'active' : '' }}" data-title="Patients">
                <a class="nav-link" href="/admin/patients">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Patients</span>
                </a>
            </li>
            <li class="nav-item {{ request()->is('admin/doctors*') ? 'active' : '' }}" data-title="Doctors">
                <a class="nav-link" href="/admin/doctors">
                    <i class="fas fa-fw fa-user-md"></i>
                    <span>Doctors</span>
                </a>
            </li>

            <li class="nav-item {{ request()->is('admin/appointments*') ? 'active' : '' }}" data-title="Appointments">
                <a class="nav-link" href="/admin/appointments">
                    <i class="fas fa-fw fa-calendar-check"></i>
                    <span>Appointments</span>
                </a>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading text-white-50">
                Reports
            </div>

            <!-- <li class="nav-item {{ request()->is('admin/reports*') ? 'active' : '' }}" data-title="Statistics">
                <a class="nav-link" href="/admin/reports">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Statistics</span>
                </a>
            </li> -->

            <hr class="sidebar-divider">
            <div class="sidebar-heading text-white-50">
                Settings
            </div>

            <!-- <li class="nav-item {{ request()->is('admin/settings*') ? 'active' : '' }}" data-title="Settings">
                <a class="nav-link" href="/admin/settings">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li> -->

            <hr class="sidebar-divider d-none d-md-block mb-4">
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle">
                </button>
            </div>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <span class="badge badge-danger badge-counter mt-2">3+</span>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-calendar-check text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">Today</div>
                                        <span>New appointment scheduled with Dr. Smith</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-user-plus text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">Yesterday</div>
                                        <span>New patient registered: John Doe</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">March 22, 2025</div>
                                        <span>Doctor availability conflict detected</span>
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                                <img class="img-profile rounded-circle"
                                    src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=4e73df&color=ffffff">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="/admin/profile">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="/admin/settings">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="/admin/logs">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                @yield('content')
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Clinic Management System {{ date('Y') }}</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarState = localStorage.getItem('sidebarState');
            if (sidebarState === 'toggled') {
                document.body.classList.add('sidebar-toggled');
                document.querySelector('.sidebar').classList.add('toggled');
            }

            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarToggleTop = document.getElementById('sidebarToggleTop');

            function toggleSidebar(e) {
                if (e) e.preventDefault();
                document.body.classList.toggle('sidebar-toggled');
                const sidebar = document.querySelector('.sidebar');
                sidebar.classList.toggle('toggled');

                if (sidebar.classList.contains('toggled')) {
                    localStorage.setItem('sidebarState', 'toggled');

                    const collapseElements = sidebar.querySelectorAll('.collapse.show');
                    collapseElements.forEach(function (element) {
                        bootstrap.Collapse.getInstance(element)?.hide();
                    });
                } else {
                    localStorage.setItem('sidebarState', 'expanded');
                }
            }

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', toggleSidebar);
            }

            if (sidebarToggleTop) {
                sidebarToggleTop.addEventListener('click', toggleSidebar);
            }

            function handleResize() {
                if (window.innerWidth < 768) {
                    const collapseElements = document.querySelectorAll('.sidebar .collapse.show');
                    collapseElements.forEach(function (element) {
                        bootstrap.Collapse.getInstance(element)?.hide();
                    });
                    document.body.classList.add('sidebar-toggled');
                    document.querySelector('.sidebar').classList.add('toggled');
                }
            }
            handleResize();

            window.addEventListener('resize', handleResize);
            const fixedSidebar = document.querySelector('body.fixed-nav .sidebar');
            if (fixedSidebar) {
                fixedSidebar.addEventListener('wheel', function (e) {
                    if (window.innerWidth > 768) {
                        const delta = e.deltaY || -e.detail;
                        this.scrollTop += (delta > 0 ? 1 : -1) * 30;
                        e.preventDefault();
                    }
                });
            }
            window.addEventListener('scroll', function () {
                const scrollDistance = window.pageYOffset || document.documentElement.scrollTop;
                const scrollTopButton = document.querySelector('.scroll-to-top');

                if (scrollTopButton) {
                    if (scrollDistance > 100) {
                        scrollTopButton.style.display = 'block';
                        setTimeout(() => scrollTopButton.style.opacity = 1, 10);
                    } else {
                        scrollTopButton.style.opacity = 0;
                        setTimeout(() => scrollTopButton.style.display = 'none', 300);
                    }
                }
            });

            const scrollTopLinks = document.querySelectorAll('a.scroll-to-top');
            scrollTopLinks.forEach(function (link) {
                link.addEventListener('click', function (e) {
                    e.preventDefault();

                    const scrollOptions = {
                        top: 0,
                        behavior: 'smooth'
                    };

                    window.scrollTo(scrollOptions);
                });
            });

            const sidebarItems = document.querySelectorAll('.nav-item');
            sidebarItems.forEach(function (item) {
                item.addEventListener('mouseenter', function () {
                    const sidebar = document.querySelector('.sidebar');
                    if (sidebar.classList.contains('toggled')) {
                        this.classList.add('sidebar-item-hover');
                    }
                });

                item.addEventListener('mouseleave', function () {
                    this.classList.remove('sidebar-item-hover');
                });
            });
        });
    </script>

    @yield('scripts')
</body>

</html>