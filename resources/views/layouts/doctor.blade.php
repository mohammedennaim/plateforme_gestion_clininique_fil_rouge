php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="MediClinic - Doctor Dashboard">
    <meta name="author" content="MediClinic">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Doctor Dashboard') | MediClinic</title>

    <!-- Custom fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Toastr notifications -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    
    <!-- Custom styles -->
    <style>
        :root {
            --primary: #4e73df;
            --secondary: #858796;
            --success: #1cc88a;
            --info: #36b9cc;
            --warning: #f6c23e;
            --danger: #e74a3b;
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fc;
        }
        
        #wrapper {
            display: flex;
        }
        
        #content-wrapper {
            width: 100%;
            overflow-x: hidden;
            background-color: #f8f9fc;
        }
        
        #content {
            flex: 1 0 auto;
        }
        
        /* Sidebar */
        .sidebar {
            width: 225px;
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            z-index: 1;
            transition: width 0.25s ease;
        }
        
        .sidebar .sidebar-brand {
            height: 4.375rem;
            text-decoration: none;
            font-size: 1rem;
            font-weight: 800;
            padding: 1.5rem 1rem;
            text-align: center;
            letter-spacing: 0.05rem;
            z-index: 1;
        }
        
        .sidebar .sidebar-brand .sidebar-brand-icon i {
            font-size: 2rem;
        }
        
        .sidebar .sidebar-brand .sidebar-brand-text {
            display: inline;
        }
        
        .sidebar hr.sidebar-divider {
            margin: 1rem 0;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
        }
        
        .sidebar .sidebar-heading {
            text-align: left;
            padding: 0 1rem;
            font-weight: 800;
            font-size: 0.65rem;
            color: rgba(255, 255, 255, 0.4);
            letter-spacing: 0.13rem;
            text-transform: uppercase;
        }
        
        .sidebar .nav-item {
            position: relative;
        }
        
        .sidebar .nav-item .nav-link {
            display: block;
            width: 100%;
            text-align: left;
            padding: 0.75rem 1rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 600;
        }
        
        .sidebar .nav-item .nav-link i {
            margin-right: 0.5rem;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.7);
        }
        
        .sidebar .nav-item .nav-link.active {
            color: #fff;
            font-weight: 700;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar .nav-item .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar.toggled {
            width: 0 !important;
            overflow: hidden;
        }
        
        /* Topbar */
        .topbar {
            height: 4.375rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            background-color: #fff;
        }
        
        .topbar .navbar-search {
            width: 25rem;
        }
        
        .topbar .navbar-search input {
            font-size: 0.85rem;
        }
        
        .topbar .topbar-divider {
            width: 0;
            border-right: 1px solid #e3e6f0;
            height: calc(4.375rem - 2rem);
            margin: auto 1rem;
        }
        
        .topbar .nav-item .nav-link {
            position: relative;
            height: 4.375rem;
            display: flex;
            align-items: center;
            color: #3a3b45;
        }
        
        .topbar .nav-item .nav-link:focus {
            outline: none;
        }
        
        .topbar .nav-item .nav-link .badge-counter {
            position: absolute;
            transform: scale(0.7);
            transform-origin: top right;
            right: 0.25rem;
            margin-top: -0.25rem;
        }
        
        .topbar .dropdown .dropdown-menu {
            width: calc(100% - 1.5rem);
            right: 0.75rem;
        }
        
        .topbar .dropdown-list {
            padding: 0;
            border: none;
            overflow: hidden;
        }
        
        .topbar .dropdown-list .dropdown-header {
            background-color: #4e73df;
            border: 1px solid #4e73df;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
            color: #fff;
        }
        
        .topbar .dropdown-list .dropdown-item {
            white-space: normal;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            border-left: 1px solid #e3e6f0;
            border-right: 1px solid #e3e6f0;
            border-bottom: 1px solid #e3e6f0;
            line-height: 1.3rem;
        }
        
        .topbar .dropdown-list .dropdown-item .dropdown-list-image {
            position: relative;
            height: 2.5rem;
            width: 2.5rem;
        }
        
        .topbar .dropdown-list .dropdown-item .dropdown-list-image img {
            height: 2.5rem;
            width: 2.5rem;
        }
        
        .topbar .dropdown-list .dropdown-item .text-truncate {
            max-width: 10rem;
        }
        
        .topbar .dropdown-list .dropdown-item:active {
            background-color: #f8f9fc;
            color: #3a3b45;
        }
        
        /* Custom utilties */
        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }
        
        .border-bottom-primary {
            border-bottom: 0.25rem solid #4e73df !important;
        }
        
        @media (min-width: 768px) {
            .sidebar {
                width: 225px !important;
            }
            .sidebar .sidebar-heading {
                text-align: left;
            }
            .sidebar .sidebar-brand .sidebar-brand-text {
                display: inline;
            }
            .topbar .navbar-search {
                width: auto;
            }
        }
        
        /* Responsive navigation */
        #sidebarToggleTop {
            height: 2.5rem;
            width: 2.5rem;
            background-color: #f8f9fc;
        }
        
        #sidebarToggle {
            width: 2.5rem;
            height: 2.5rem;
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        #sidebarToggle:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }
        
        #sidebarToggleTop:hover,
        #sidebarToggleTop:active {
            background-color: #eaecf4;
        }
        
        /* Badge styles */
        .badge-counter {
            position: relative;
            transform: scale(0.7);
            transform-origin: top right;
            right: 0.25rem;
            margin-top: -0.25rem;
        }
        
        /* Card styles */
        .card .card-header[data-toggle="collapse"]::after {
            font-family: 'Font Awesome 5 Free';
            content: "\f107";
            font-weight: 900;
            color: #d1d3e2;
            float: right;
        }
        
        .card .card-header[data-toggle="collapse"].collapsed::after {
            content: "\f105";
        }
    </style>

    @yield('styles')
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('doctor.dashboard') }}">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <div class="sidebar-brand-text mx-3">MediClinic</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ request()->is('doctor/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('doctor.dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Patient Care
            </div>

            <!-- Nav Item - Appointments -->
            <li class="nav-item {{ request()->is('doctor/appointments*') ? 'active' : '' }}">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-calendar-check"></i>
                    <span>Appointments</span>
                </a>
            </li>

            <!-- Nav Item - Patients -->
            <li class="nav-item {{ request()->is('doctor/patients*') ? 'active' : '' }}">
                <a class="nav-link" href="">
                    <i class="fas fa-fw fa-users"></i>
                    <span>My Patients</span>
                </a>
            </li>

            <!-- Nav Item - Medical Records -->
            <li class="nav-item {{ request()->is('doctor/records*') ? 'active' : '' }}">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-file-medical"></i>
                    <span>Medical Records</span>
                </a>
            </li>

            <!-- Nav Item - Prescriptions -->
            <li class="nav-item {{ request()->is('doctor/prescriptions*') ? 'active' : '' }}">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-prescription-bottle-alt"></i>
                    <span>Prescriptions</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Communication
            </div>

            <!-- Nav Item - Messages -->
            <li class="nav-item {{ request()->is('doctor/messages*') ? 'active' : '' }}">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-comments"></i>
                    <span>Messages</span>
                    <span class="badge badge-danger badge-counter">7</span>
                </a>
            </li>

            <!-- Nav Item - Video Consultations -->
            <li class="nav-item {{ request()->is('doctor/consultations*') ? 'active' : '' }}">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-video"></i>
                    <span>Video Consultations</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Settings
            </div>

            <!-- Nav Item - Profile -->
            <li class="nav-item {{ request()->is('doctor/profile*') ? 'active' : '' }}">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-user-md"></i>
                    <span>My Profile</span>
                </a>
            </li>

            <!-- Nav Item - Availability -->
            <li class="nav-item {{ request()->is('doctor/availability*') ? 'active' : '' }}">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-clock"></i>
                    <span>My Availability</span>
                </a>
            </li>

            <!-- Nav Item - Settings -->
            <li class="nav-item {{ request()->is('doctor/settings*') ? 'active' : '' }}">
                <a class="nav-link" href="#">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Current Time -->
                    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 text-gray-800">
                        <div>
                            <i class="fas fa-clock mr-1"></i>
                            <span id="current-time">{{ date('H:i') }}</span>
                            <span class="ml-1">{{ date('D, d M Y') }}</span>
                        </div>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle notifications-btn" href="#" id="alertsDropdown" role="button">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle chat-open-btn" href="#" id="messagesDropdown" role="button">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">7</span>
                            </a>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    Dr. {{ Auth::user()->name ?? 'Jonathan Smith' }}
                                </span>
                                <img class="img-profile rounded-circle"
                                    src="{{ Auth::user()->profile_image ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name ?? 'Doctor').'&size=128&background=4e73df&color=ffffff' }}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a>
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                    @csrf
                                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>
                                </form>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                @yield('content')

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; MediClinic 2025</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Core plugin JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    
    <!-- Toastr Notifications -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Custom scripts -->
    <script>
        (function($) {
            "use strict";

            // Toggle the side navigation
            $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
                $("body").toggleClass("sidebar-toggled");
                $(".sidebar").toggleClass("toggled");
            });

            // Close any open menu accordions when window is resized below 768px
            $(window).resize(function() {
                if ($(window).width() < 768) {
                    $('.sidebar .collapse').collapse('hide');
                }
            });

            // Prevent the content wrapper from scrolling when the fixed side navigation hovered over
            $('body.fixed-nav .sidebar').on('mousewheel DOMMouseScroll wheel', function(e) {
                if ($(window).width() > 768) {
                    var e0 = e.originalEvent,
                    delta = e0.wheelDelta || -e0.detail;
                    this.scrollTop += (delta < 0 ? 1 : -1) * 30;
                    e.preventDefault();
                }
            });

            // Scroll to top button appear
            $(document).on('scroll', function() {
                var scrollDistance = $(this).scrollTop();
                if (scrollDistance > 100) {
                    $('.scroll-to-top').fadeIn();
                } else {
                    $('.scroll-to-top').fadeOut();
                }
            });

            // Smooth scrolling using jQuery easing
            $(document).on('click', 'a.scroll-to-top', function(e) {
                var $anchor = $(this);
                $('html, body').stop().animate({
                    scrollTop: ($($anchor.attr('href')).offset().top)
                }, 1000, 'easeInOutExpo');
                e.preventDefault();
            });

        })(jQuery);

        // Show success message if exists
        @if(session('success'))
            toastr.success('{{ session('success') }}');
        @endif

        // Show error message if exists
        @if(session('error'))
            toastr.error('{{ session('error') }}');
        @endif

        // Show warning message if exists
        @if(session('warning'))
            toastr.warning('{{ session('warning') }}');
        @endif
    </script>

    @yield('scripts')

</body>
</html>