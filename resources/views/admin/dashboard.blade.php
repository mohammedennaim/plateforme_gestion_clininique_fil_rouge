<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" cont</div>ent="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Système de Gestion de Clinique - Dashboard Administrateur">
    <meta name="author" content="Votre Nom">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Gestion de Clinique') }} - Dashboard Administrateur</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link
        href="https://f</div>onts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css" rel="stylesheet">
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
            --sidebar-width: 250px;
            --sidebar-collapsed-width: 90px;
            --transition-speed: 0.35s;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f</div>8f9fc;
        }

        /* Sidebar améliorée */
        .sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            position: fixed;
            z-index: 100;
            transition: width var(--transition-speed) ease;
            overflow-x: hidden;
            box-shadow: 0 0.25rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .sidebar.toggled {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar-brand {
            height: 5rem;
            text-decoration: none;
            font-size: 1.2rem;
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
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        }

        .sidebar-brand .sidebar-brand-icon {
            margin-right: 0.5rem;
            font-size: 1.5rem;
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
            padding: 1rem 1.5rem;
            color: rgba(255, 255, 255, 0.8);
            white-space: nowrap;
            border-radius: 0.25rem;
            margin: 0 0.5rem;
            transition: all 0.3s;
        }

        .sidebar .nav-item .nav-link:hover,
        .sidebar .nav-item .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 5px solid #fff;
            padding-left: calc(1.5rem - 5px);
        }

        .sidebar .nav-item .nav-link i {
            margin-right: 0.75rem;
            width: 1.25rem;
            font-size: 1.1rem;
            text-align: center;
        }

        .sidebar .sidebar-heading {
            padding: 0.75rem 1.5rem;
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
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
            margin: 1rem auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar #sidebarToggle:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.8);
        }

        .sidebar #sidebarToggle::after {
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            content: '\f104';
            transition: all 0.3s;
        }

        /* Content-wrapper amélioré */
        .content-wrapper {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            background-color: #f8f9fc;
            transition: margin-left var(--transition-speed) ease;
            display: flex;
            flex-direction: column;
        }

        body.sidebar-toggled .content-wrapper {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Topbar amélioré */
        .topbar {
            height: 4.5rem;
            background-color: #fff;
            box-shadow: 0 0.25rem 1rem 0 rgba(58, 59, 69, 0.1);
            z-index: 99;
        }

        .topbar .nav-item .nav-link {
            position: relative;
            height: 4.5rem;
            display: flex;
            align-items: center;
            color: #d1d3e2;
            padding: 0 0.75rem;
        }

        .topbar .nav-item .nav-link:hover {
            color: #4e73df;
        }

        .topbar .dropdown-menu {
            border: none;
            box-shadow: 0 0.25rem 1rem 0 rgba(58, 59, 69, 0.1);
            border-radius: 0.5rem;
            padding: 0.8rem 0;
            min-width: 16rem;
        }

        .topbar .dropdown-menu .dropdown-header {
            background-color: #4e73df;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem 0.5rem 0 0;
            font-weight: 700;
            margin-top: -0.8rem;
        }

        .topbar .dropdown-menu .dropdown-item {
            padding: 0.6rem 1.5rem;
            display: flex;
            align-items: center;
        }

        .topbar .dropdown-menu .dropdown-item:hover {
            background-color: #f8f9fc;
        }

        .topbar .dropdown-menu .dropdown-item i {
            margin-right: 0.75rem;
            width: 1.25rem;
            text-align: center;
        }

        .topbar .dropdown-list {
            width: 20rem;
            max-height: 25rem;
            overflow-y: auto;
        }

        .topbar .dropdown-item:active {
            background-color: #4e73df;
            color: white;
        }

        /* Cards améliorés */
        .card {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 0.25rem 1rem 0 rgba(58, 59, 69, 0.1);
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1.5rem 0 rgba(58, 59, 69, 0.15);
        }

        .card .card-header {
            background-color: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.25rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card .card-header h6 {
            margin: 0;
            font-size: 1rem;
            font-weight: 700;
            color: #4e73df;
        }

        .card .card-body {
            padding: 1.5rem;
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

        /* Statistiques améliorées */
        .stats-card .card-body {
            padding: 1.25rem;
        }

        .stats-card .icon-circle {
            width: 3rem;
            height: 3rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(78, 115, 223, 0.1);
            color: #4e73df;
            font-size: 1.2rem;
        }

        .stats-card h6 {
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }

        .stats-card h2 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0;
            color: #5a5c69;
        }

        /* Onglets améliorés */
        .nav-tabs {
            border-bottom: none;
            margin-bottom: 1.5rem;
        }

        .nav-tabs .nav-item {
            margin-right: 0.5rem;
        }

        .nav-tabs .nav-link {
            border: none;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            color: #5a5c69;
            background-color: white;
            box-shadow: 0 0.125rem 0.25rem 0 rgba(58, 59, 69, 0.1);
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link:hover {
            color: #4e73df;
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem 0 rgba(58, 59, 69, 0.15);
        }

        .nav-tabs .nav-link.active {
            color: white;
            background-color: #4e73df;
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem 0 rgba(78, 115, 223, 0.25);
        }

        /* Tableaux améliorés */
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #5a5c69;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #e3e6f0;
            background-color: #f8f9fc;
            padding: 1rem;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05rem;
        }

        .table tbody tr {
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background-color: rgba(78, 115, 223, 0.05);
        }

        .table td {
            padding: 1rem;
            vertical-align: middle;
            border-top: 1px solid #e3e6f0;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 0.25rem 0.5rem;
            margin-left: 0.25rem;
            border-radius: 0.35rem;
            border: 1px solid #e3e6f0;
            background-color: #fff;
            color: #5a5c69;
            transition: all 0.3s;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #f8f9fc;
            color: #4e73df !important;
            border-color: #4e73df;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background-color: #4e73df;
            color: #fff !important;
            border-color: #4e73df;
        }

        /* Badges améliorés */
        .badge {
            padding: 0.5rem 0.75rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem 0 rgba(58, 59, 69, 0.1);
        }

        .badge-success {
            background-color: rgba(28, 200, 138, 0.15);
            color: #1cc88a;
        }

        .badge-warning {
            background-color: rgba(246, 194, 62, 0.15);
            color: #f6c23e;
        }

        .badge-danger {
            background-color: rgba(231, 74, 59, 0.15);
            color: #e74a3b;
        }

        .badge-info {
            background-color: rgba(54, 185, 204, 0.15);
            color: #36b9cc;
        }

        /* Progress bars améliorés */
        .progress {
            height: 0.8rem;
            border-radius: 0.5rem;
            background-color: #eaecf4;
            overflow: hidden;
            box-shadow: inset 0 0.1rem 0.2rem rgba(0, 0, 0, 0.1);
        }

        .progress-bar {
            border-radius: 0.5rem;
            box-shadow: none;
        }

        /* Modals améliorés */
        .modal-content {
            border: none;
            border-radius: 0.75rem;
            box-shadow: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.2);
            overflow: hidden;
        }

        .modal-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            padding: 1.5rem;
        }

        .modal-header .close {
            padding: 1.5rem;
            margin: -1.5rem;
            background-color: transparent;
            border: none;
            font-size: 1.5rem;
            color: #5a5c69;
            transition: all 0.3s;
        }

        .modal-header .close:hover {
            color: #4e73df;
        }

        .modal-title {
            font-weight: 700;
            color: #4e73df;
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: 1px solid #e3e6f0;
            padding: 1.25rem 1.5rem;
        }

        /* Buttons améliorés */
        .btn {
            padding: 0.5rem 1.25rem;
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem 0 rgba(58, 59, 69, 0.1);
            transition: all 0.3s;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem 0 rgba(58, 59, 69, 0.15);
        }

        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }

        .btn-primary:hover {
            background-color: #2653d4;
            border-color: #2653d4;
        }

        .btn-success {
            background-color: #1cc88a;
            border-color: #1cc88a;
        }

        .btn-success:hover {
            background-color: #169b6b;
            border-color: #169b6b;
        }

        .btn-danger {
            background-color: #e74a3b;
            border-color: #e74a3b;
        }

        .btn-danger:hover {
            background-color: #cb2d1d;
            border-color: #cb2d1d;
        }

        .btn-info {
            background-color: #36b9cc;
            border-color: #36b9cc;
            color: white;
        }

        .btn-info:hover {
            background-color: #258391;
            border-color: #258391;
            color: white;
        }

        /* Formulaires améliorés */
        .form-control {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d3e2;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        label {
            font-weight: 600;
            color: #5a5c69;
            margin-bottom: 0.5rem;
        }

        /* Footer amélioré */
        footer.sticky-footer {
            padding: 2rem 0;
            flex-shrink: 0;
            background-color: white;
            box-shadow: 0 -0.125rem 0.5rem 0 rgba(58, 59, 69, 0.1);
        }

        /* Responsive design */
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

        /* User image */
        .img-profile {
            height: 3rem;
            width: 3rem;
            border: 3px solid #eaecf4;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Icon circles pour notifications */
        .icon-circle {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bg-primary {
            background-color: #4e73df !important;
        }

        .bg-success {
            background-color: #1cc88a !important;
        }

        .bg-warning {
            background-color: #f6c23e !important;
        }

        .bg-danger {
            background-color: #e74a3b !important;
        }

        .bg-info {
            background-color: #36b9cc !important;
        }

        /* Améliorations pour les notifications */
        .badge-counter {
            position: absolute;
            transform: scale(0.7);
            transform-origin: top right;
            right: 0.25rem;
            top: 0.25rem;
            font-size: 0.75rem;
            padding: 0.25rem 0.4rem;
            font-weight: 700;
            background-color: #e74a3b;
        }

        /* Styles spécifiques pour les graphiques */
        .chart-container {
            height: 300px;
            position: relative;
        }

        /* Styles pour les étoiles de notation */
        .text-warning {
            color: #f6c23e !important;
        }

        /* Animation pour les éléments du dashboard */
        .animated--grow-in {
            animation: growIn 0.2s ease-in-out;
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

        /* Menu contextuel pour les actions rapides */
        .action-menu {
            display: flex;
            gap: 0.5rem;
        }

        /* Tableau de bord responsive */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        /* Styles pour les statistiques détaillées */
        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0;
            color: #5a5c69;
        }

        .stat-label {
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #b7b9cc;
        }

        /* Style pour le profil médecin */
        .doctor-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .doctor-profile img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .doctor-info h6 {
            margin-bottom: 0.25rem;
            font-weight: 700;
        }

        .doctor-info span {
            font-size: 0.8rem;
            color: #858796;
        }

        /* Style pour le profil patient */
        .patient-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .patient-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .patient-info h6 {
            margin-bottom: 0.25rem;
            font-weight: 600;
        }

        .patient-info span {
            font-size: 0.8rem;
            color: #858796;
        }
    </style>

</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-clinic-medical"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Clinique <sup>Admin</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Tableau de bord</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Gestion
            </div>

            <!-- Nav Item - Patients -->
            <li class="nav-item">
                <a class="nav-link" href="">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Patients</span>
                </a>
            </li>

            <!-- Nav Item - Médecins -->
            <li class="nav-item">
                <a class="nav-link" href="">
                    <i class="fas fa-fw fa-user-md"></i>
                    <span>Médecins</span>
                </a>
            </li>

            <!-- Nav Item - Rendez-vous -->
            <li class="nav-item">
                <a class="nav-link" href="">
                    <i class="fas fa-fw fa-calendar-check"></i>
                    <span>Rendez-vous</span>
                </a>
            </li>

            <!-- Nav Item - Spécialités -->
            <li class="nav-item">
                <a class="nav-link" href="">
                    <i class="fas fa-fw fa-stethoscope"></i>
                    <span>Spécialités</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Finance
            </div>

            <!-- Nav Item - Paiements -->
            <li class="nav-item">
                <a class="nav-link" href="">
                    <i class="fas fa-fw fa-credit-card"></i>
                    <span>Paiements</span>
                </a>
            </li>

            <!-- Nav Item - Factures -->
            <li class="nav-item">
                <a class="nav-link" href="">
                    <i class="fas fa-fw fa-file-invoice"></i>
                    <span>Factures</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Système
            </div>

            <!-- Nav Item - Statistiques -->
            <li class="nav-item">
                <a class="nav-link" href="">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Statistiques</span>
                </a>
            </li>

            <!-- Nav Item - Paramètres -->
            <li class="nav-item">
                <a class="nav-link" href="">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Paramètres</span>
                </a>
            </li>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-lg rounded-bottom d-flex justify-content-between"
                    style="transition: all 0.3s ease; padding: 0.75rem 1.5rem;">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3"
                        aria-label="Ouvrir le menu latéral"
                        style="color: #4e73df; width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; box-shadow: 0 0.125rem 0.25rem rgba(78, 115, 223, 0.2);">
                        <i class="fa fa-bars fa-lg"></i>
                    </button>



                    <!-- Topbar Search - Enhanced with better styling -->
                    <!-- <form
                        class="d-none d-lg-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 navbar-search position-relative">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-transparent border-0"
                                    style="position: absolute; z-index: 10; left: 0; top: 0; height: 100%; display: flex; align-items: center; padding-left: 1rem;">
                                    <i class="fas fa-search fa-sm text-primary"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control bg-light small border-0 shadow-sm"
                                placeholder="Rechercher patients, médecins, rendez-vous..." aria-label="Rechercher"
                                aria-describedby="searchButton"
                                style="border-radius: 2rem; padding: 1.2rem 1.2rem 1.2rem 2.5rem; min-width: 300px; font-size: 0.85rem; transition: all 0.3s ease;">
                            <div class="search-dropdown position-absolute d-none"
                                style="width: 100%; top: 100%; left: 0; margin-top: 0.5rem; z-index: 1000; background: white; border-radius: 0.5rem; box-shadow: 0 0.5rem 1.5rem rgba(0,0,0,0.1); padding: 1rem; max-height: 300px; overflow-y: auto;">
                                <h6 class="dropdown-header">Résultats récents</h6>
                                <div class="quick-search-results">
                                </div>
                            </div>
                        </div>
                    </form> -->

                    <!-- Date & Time Display -->
                    <div class="d-none d-xl-flex align-items-center mr-4">
                        <div class="date-time-display text-center">
                            <div id="currentDate" class="text-gray-800 font-weight-bold" style="font-size: 0.9rem;">
                                <!-- Date will be populated via JS -->
                            </div>
                            <div id="currentTime" class="text-primary" style="font-size: 1.1rem; font-weight: 600;">
                                <!-- Time will be populated via JS -->
                            </div>
                        </div>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-inline-block d-lg-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                style="width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease;">
                                <i class="fas fa-search fa-fw" aria-hidden="true"></i>
                                <span class="sr-only">Rechercher</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown"
                                style="width: 20rem; border-radius: 0.75rem; border: none; margin-top: 1rem;">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent border-0">
                                                <i class="fas fa-search fa-sm text-primary" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Rechercher..." aria-label="Rechercher"
                                            style="border-radius: 2rem; padding-left: 2.5rem;">
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Notifications -->
                        <li class="nav-item dropdown no-arrow mx-1 mt-3">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                aria-label="Notifications (3 nouvelles)"
                                style="width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease;">
                                <i class="fas fa-bell fa-fw" aria-hidden="true"></i>
                                <span class="badge badge-pill badge-danger"
                                    style="position: absolute; top: 0.25rem; right: 0.1rem; font-size: 0.6rem; padding: 0.2rem 0.4rem; transform: scale(0.85); transition: all 0.3s ease;">3</span>
                                <span class="sr-only">3 nouvelles notifications</span>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown"
                                style="width: 22rem; border: none; border-radius: 0.75rem; overflow: hidden; margin-top: 1rem;">
                                <div class="dropdown-header d-flex justify-content-between align-items-center"
                                    style="background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); color: white; padding: 1rem 1.5rem;">
                                    <h6 class="m-0" style="font-size: 1rem; font-weight: 700;">Notifications</h6>
                                    <div class="dropdown-actions">
                                        <button class="btn btn-sm btn-light-outline text-white"
                                            style="font-size: 0.7rem; padding: 0.25rem 0.5rem; background-color: rgba(255,255,255,0.1); border-radius: 1rem; border: 1px solid rgba(255,255,255,0.2);">
                                            Tout marquer comme lu
                                        </button>
                                    </div>
                                </div>
                                <div class="notification-list" style="max-height: 350px; overflow-y: auto;">
                                    <a class="dropdown-item d-flex align-items-center p-3 unread" href="#"
                                        style="border-left: 3px solid #4e73df; transition: background-color 0.2s ease; background-color: rgba(78, 115, 223, 0.05);">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-primary"
                                                style="width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-calendar-check text-white fa-lg"
                                                    aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <div style="flex: 1;">
                                            <h6 class="font-weight-bold text-gray-800 mb-1">Nouveau rendez-vous</h6>
                                            <div class="text-truncate">Rendez-vous confirmé avec Dr. Martin</div>
                                            <div class="small text-primary">
                                                <i class="fas fa-clock mr-1" aria-hidden="true"></i> Il y a 10 minutes
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center p-3 unread" href="#"
                                        style="border-left: 3px solid #4e73df; transition: background-color 0.2s ease; background-color: rgba(78, 115, 223, 0.05);">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-success"
                                                style="width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-user-md text-white fa-lg" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <div style="flex: 1;">
                                            <h6 class="font-weight-bold text-gray-800 mb-1">Médecin disponible</h6>
                                            <div class="text-truncate">Dr. Sophie Laurent est maintenant disponible
                                            </div>
                                            <div class="small text-primary">
                                                <i class="fas fa-clock mr-1" aria-hidden="true"></i> Il y a 1 heure
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center p-3" href="#"
                                        style="border-left: 3px solid transparent; transition: background-color 0.2s ease;">
                                        <div class="mr-3">
                                            <div class="icon-circle bg-warning"
                                                style="width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-exclamation-triangle text-white fa-lg"
                                                    aria-hidden="true"></i>
                                            </div>
                                        </div>
                                        <div style="flex: 1;">
                                            <h6 class="font-weight-bold text-gray-800 mb-1">Rappel important</h6>
                                            <div class="text-truncate">N'oubliez pas la réunion d'équipe demain à 10h
                                            </div>
                                            <div class="small text-gray-500">
                                                <i class="fas fa-clock mr-1" aria-hidden="true"></i> Il y a 3 heures
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <a class="dropdown-item text-center small text-primary font-weight-bold py-3" href="#"
                                    style="background-color: #f8f9fc; transition: background-color 0.2s ease;">
                                    <i class="fas fa-angle-double-down mr-1" aria-hidden="true"></i> Voir toutes les
                                    notifications
                                </a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1 mt-3">
                            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                aria-label="Messages (5 nouveaux)"
                                style="width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.2s ease;">
                                <i class="fas fa-envelope fa-fw" aria-hidden="true"></i>
                                <span class="badge badge-pill badge-danger"
                                    style="position: absolute; top: 0.25rem; right: 0.1rem; font-size: 0.6rem; padding: 0.2rem 0.4rem; transform: scale(0.85); transition: all 0.3s ease;">5</span>
                                <span class="sr-only">5 nouveaux messages</span>
                            </a>
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown"
                                style="width: 22rem; border: none; border-radius: 0.75rem; overflow: hidden; margin-top: 1rem;">
                                <div class="dropdown-header d-flex justify-content-between align-items-center"
                                    style="background: linear-gradient(135deg, #1cc88a 0%, #13855c 100%); color: white; padding: 1rem 1.5rem;">
                                    <h6 class="m-0" style="font-size: 1rem; font-weight: 700;">Messages</h6>
                                    <div class="dropdown-actions">
                                        <button class="btn btn-sm btn-light-outline text-white"
                                            style="font-size: 0.7rem; padding: 0.25rem 0.5rem; background-color: rgba(255,255,255,0.1); border-radius: 1rem; border: 1px solid rgba(255,255,255,0.2);">
                                            <i class="fas fa-plus fa-sm mr-1" aria-hidden="true"></i> Nouveau
                                        </button>
                                    </div>
                                </div>
                                <div class="messages-list" style="max-height: 350px; overflow-y: auto;">
                                    <a class="dropdown-item d-flex align-items-center p-3 unread" href="#"
                                        style="border-left: 3px solid #1cc88a; transition: background-color 0.2s ease; background-color: rgba(28, 200, 138, 0.05);">
                                        <div class="mr-3 position-relative">
                                            <img class="rounded-circle"
                                                src="https://ui-avatars.com/api/?name=Marie+Dupont&background=4e73df&color=ffffff&size=60"
                                                alt="Marie Dupont"
                                                style="width: 45px; height: 45px; border: 2px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                            <span class="status-indicator bg-success"
                                                style="width: 10px; height: 10px; border-radius: 50%; position: absolute; bottom: 0; right: 0; border: 2px solid #fff;"></span>
                                        </div>
                                        <div style="flex: 1;">
                                            <h6 class="font-weight-bold text-gray-800 mb-1">Marie Dupont</h6>
                                            <div class="text-truncate font-weight-bold text-primary">Pouvez-vous
                                                confirmer l'heure ?</div>
                                            <div class="small text-gray-500">
                                                <i class="fas fa-clock mr-1" aria-hidden="true"></i> Il y a 15 minutes
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center p-3 unread" href="#"
                                        style="border-left: 3px solid #1cc88a; transition: background-color 0.2s ease; background-color: rgba(28, 200, 138, 0.05);">
                                        <div class="mr-3 position-relative">
                                            <img class="rounded-circle"
                                                src="https://ui-avatars.com/api/?name=Dr+Robert&background=1cc88a&color=ffffff&size=60"
                                                alt="Dr. Robert"
                                                style="width: 45px; height: 45px; border: 2px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                            <span class="status-indicator bg-success"
                                                style="width: 10px; height: 10px; border-radius: 50%; position: absolute; bottom: 0; right: 0; border: 2px solid #fff;"></span>
                                        </div>
                                        <div style="flex: 1;">
                                            <h6 class="font-weight-bold text-gray-800 mb-1">Dr. Robert</h6>
                                            <div class="text-truncate font-weight-bold text-primary">J'ai besoin des
                                                dossiers médicaux...</div>
                                            <div class="small text-gray-500">
                                                <i class="fas fa-clock mr-1" aria-hidden="true"></i> Il y a 1 heure
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item d-flex align-items-center p-3" href="#"
                                        style="border-left: 3px solid transparent; transition: background-color 0.2s ease;">
                                        <div class="mr-3 position-relative">
                                            <img class="rounded-circle"
                                                src="https://ui-avatars.com/api/?name=Support&background=36b9cc&color=ffffff&size=60"
                                                alt="Support Technique"
                                                style="width: 45px; height: 45px; border: 2px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                            <span class="status-indicator bg-warning"
                                                style="width: 10px; height: 10px; border-radius: 50%; position: absolute; bottom: 0; right: 0; border: 2px solid #fff;"></span>
                                        </div>
                                        <div style="flex: 1;">
                                            <h6 class="font-weight-bold text-gray-800 mb-1">Support Technique</h6>
                                            <div class="text-truncate">Mise à jour disponible pour le système</div>
                                            <div class="small text-gray-500">
                                                <i class="fas fa-clock mr-1" aria-hidden="true"></i> Il y a 5 heures
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <a class="dropdown-item text-center small text-primary font-weight-bold py-3" href="#"
                                    style="background-color: #f8f9fc; transition: background-color 0.2s ease;">
                                    <i class="fas fa-envelope-open mr-1" aria-hidden="true"></i> Voir tous les messages
                                </a>
                            </div>
                        </li>

                        <!-- Divider -->
                        <div class="topbar-divider d-none d-sm-block"
                            style="height: 1.5rem; margin: auto 1rem; width: 0; border-right: 1px solid #e3e6f0;"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                style="transition: all 0.2s ease;">
                                <div class="d-flex align-items-center position-relative">
                                    <div class="mr-3 d-none d-lg-block text-right pe-2">
                                        <div class="text-gray-800 font-weight-bold mb-0"
                                            style="font-size: 0.95rem; line-height: 1.2;">
                                            {{ Auth::user()->name }}
                                        </div>
                                        <div class="text-primary small"
                                            style="font-size: 0.75rem; font-weight: 600; letter-spacing: 0.02em;">
                                            Administrateur
                                        </div>
                                    </div>
                                    <div class="position-relative user-avatar-container"
                                        style="transition: all 0.3s ease;">
                                        <img class="img-profile rounded-circle border border-3 shadow-sm"
                                            style="width: 44px; height: 44px; object-fit: cover; transition: all 0.3s ease; border-color: rgba(78, 115, 223, 0.6) !important; filter: contrast(1.05);"
                                            src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=7F9CF5&background=EBF4FF' }}"
                                            alt="Photo de profil">
                                        <div class="status-indicator bg-success border border-white"
                                            style="width: 12px; height: 12px; border-radius: 50%; position: absolute; bottom: 0; right: 0; border-width: 2px !important;">
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown"
                                style="width: 16rem; border: none; border-radius: 0.75rem; overflow: hidden; margin-top: 1rem;">
                                <div class="dropdown-user-info text-center py-4 px-3 bg-gradient-light">
                                    <img class="img-profile rounded-circle mb-2 border border-3 border-white shadow"
                                        style="width: 70px; height: 70px; object-fit: cover;"
                                        src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&color=7F9CF5&background=EBF4FF' }}"
                                        alt="Photo de profil">
                                    <h6 class="font-weight-bold text-gray-800 mb-0">{{ Auth::user()->name }}</h6>
                                    <p class="text-gray-600 mb-2">{{ Auth::user()->email }}</p>
                                    <div class="badge badge-primary py-1 px-2"
                                        style="border-radius: 1rem; font-weight: 500;">
                                        Administrateur</div>
                                </div>
                                <div class="dropdown-divider my-0"></div>
                                <a class="dropdown-item d-flex align-items-center py-2 px-4"
                                    href="{{ route('admin.profile') }}">
                                    <div class="dropdown-item-icon" style="width: 2rem; text-align: center;">
                                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400" aria-hidden="true"></i>
                                    </div>
                                    <span>Mon profil</span>
                                </a>
                                <a class="dropdown-item d-flex align-items-center py-2 px-4"
                                    href="{{ route('admin.settings') }}">
                                    <div class="dropdown-item-icon" style="width: 2rem; text-align: center;">
                                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400" aria-hidden="true"></i>
                                    </div>
                                    <span>Paramètres</span>
                                </a>
                                <div class="dropdown-divider my-0"></div>
                                <a class="dropdown-item d-flex align-items-center py-2 px-4" href="#"
                                    data-bs-toggle="modal" data-bs-target="#logoutModal">
                                    <div class="dropdown-item-icon" style="width: 2rem; text-align: center;">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"
                                            aria-hidden="true"></i>
                                    </div>
                                    <span>Déconnexion</span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Prêt à partir?</h5>
                                <button class="close" type="button" data-bs-dismiss="modal" aria-label="Fermer">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body">Sélectionnez "Déconnexion" ci-dessous si vous êtes prêt à mettre fin
                                à votre session actuelle.</div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Annuler</button>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Déconnexion</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Tableau de bord administrateur</h1>
                        <div>
                            <a href="" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-2">
                                <i class="fas fa-download fa-sm text-white-50"></i> Générer un rapport
                            </a>
                            <button id="refreshDashboard"
                                class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm">
                                <i class="fas fa-sync-alt fa-sm text-white-50"></i> Actualiser
                            </button>
                        </div>
                    </div>

                    <!-- Content Row - Cards statistiques -->
                    <div class="row mb-4">
                        <!-- Card - Total Patients -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-80 py-2 stats-card">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Patients</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPatients }}
                                            </div>
                                            <div class="text-xs text-success mt-2">
                                                <i class="fas fa-arrow-up"></i> {{ rand(3, 15) }}% depuis le mois
                                                dernier
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon-circle bg-primary">
                                                <i class="fas fa-users text-white"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card - Total Médecins -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-80 py-2 stats-card">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Médecins</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalDoctors }}
                                            </div>
                                            <div class="text-xs text-success mt-2">
                                                <i class="fas fa-arrow-up"></i> {{ rand(1, 5) }}% depuis le mois dernier
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon-circle bg-success">
                                                <i class="fas fa-user-md text-white"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card - Rendez-vous aujourd'hui -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-80 py-2 stats-card">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Rendez-vous Aujourd'hui</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ count($todayAppointments) }}
                                            </div>
                                            <div class="text-xs text-info mt-2">
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon-circle bg-info">
                                                <i class="fas fa-calendar-check text-white"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card - Revenu Total -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-80 py-2 stats-card">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Revenu Total</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                {{ number_format($totalRevenue, 2) }} Dh
                                            </div>
                                            <div class="text-xs text-success mt-2">
                                                <i class="fas fa-arrow-up"></i> {{ rand(5, 20) }}% depuis le mois
                                                dernier
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon-circle bg-warning">
                                                <i class="fas fa-euro-sign text-white"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs mb-4" id="dashboardTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="patients-tab" data-bs-toggle="tab" href="#patients"
                                role="tab">
                                <i class="fas fa-users me-2"></i>Patients
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="doctors-tab" data-bs-toggle="tab" href="#doctors" role="tab">
                                <i class="fas fa-user-md me-2"></i>Médecins
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="appointments-tab" data-bs-toggle="tab" href="#appointments"
                                role="tab">
                                <i class="fas fa-calendar-check me-2"></i>Rendez-vous
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="statistics-tab" data-bs-toggle="tab" href="#statistics" role="tab">
                                <i class="fas fa-chart-line me-2"></i>Statistiques détaillées
                            </a>
                        </li>
                    </ul>

                    <!-- Tab content -->
                    <div class="tab-content" id="dashboardContent">
                        <!-- Patients Tab -->
                        <div class="tab-content" id="dashboardContent">
                            <div class="tab-pane fade show active fade-in-up delay-400" id="patients" role="tabpanel">
                                <div class="card shadow mb-4"
                                    style="border-radius: 0.75rem; overflow: hidden; border: none;">
                                    <div class="card-header py-3 d-flex justify-content-between align-items-center"
                                        style="background-color: white; border-bottom: 1px solid rgba(0, 0, 0, 0.05);">
                                        <h6 class="m-0 font-weight-bold text-primary d-flex align-items-center">
                                            <i class="fas fa-users mr-2"
                                                style="font-size: 1rem; background-color: rgba(78, 115, 223, 0.1); color: #4e73df; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; border-radius: 50%;"></i>
                                            Gestion des patients
                                        </h6>

                                        <div class="d-flex align-items-center">
                                            <div class="input-group input-group-sm mr-3" style="width: 250px;">
                                                <input type="text" class="form-control border-0 bg-light"
                                                    placeholder="Rechercher un patient..."
                                                    style="border-radius: 1.5rem 0 0 1.5rem; padding-left: 1rem;">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="button"
                                                        style="border-radius: 0 1.5rem 1.5rem 0; padding: 0.4rem 1rem;">
                                                        <i class="fas fa-search fa-sm"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <button
                                                class="btn btn-primary btn-sm rounded-pill shadow-sm d-flex align-items-center"
                                                style="padding: 0.4rem 1rem;">
                                                <i class="fas fa-plus-circle mr-1"></i>
                                                Ajouter un patient
                                            </button>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="table-responsive" style="border-radius: 0.5rem; overflow: hidden;">
                                            <table class="table table-hover" id="patientsTable" width="100%"
                                                cellspacing="0">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th style="padding: 1rem; font-weight: 600; color: #4e73df;">Nom
                                                            complet</th>
                                                        <th style="padding: 1rem; font-weight: 600; color: #4e73df;">
                                                            Email</th>
                                                        <th style="padding: 1rem; font-weight: 600; color: #4e73df;">
                                                            Téléphone</th>
                                                        <th style="padding: 1rem; font-weight: 600; color: #4e73df;">
                                                            Assurance</th>
                                                        <th style="padding: 1rem; font-weight: 600; color: #4e73df;">
                                                            Numéro d'assurance</th>
                                                        <th style="padding: 1rem; font-weight: 600; color: #4e73df;">
                                                            Groupe sanguin</th>
                                                        <th style="padding: 1rem; font-weight: 600; color: #4e73df;">
                                                            Dernière visite</th>
                                                        <th style="padding: 1rem; font-weight: 600; color: #4e73df;">
                                                            Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Exemple de ligne de patient améliorée -->
                                                    @foreach($patients as $patient)
                                                        <tr style="transition: all 0.2s ease;">
                                                            <td>
                                                                <div class="patient-profile"
                                                                    style="display: flex; align-items: center; gap: 0.75rem;">
                                                                    <div class="patient-avatar" style="position: relative;">
                                                                        <img src="{{ $patient->user->profile_photo_url ?? asset('img/default-avatar.png') }}"
                                                                            alt="patient"
                                                                            style="width: 42px; height: 42px; border-radius: 50%; object-fit: cover; border: 2px solid #fff; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                                                                        <span class="status-indicator bg-success"
                                                                            style="width: 10px; height: 10px; border-radius: 50%; position: absolute; bottom: 0; right: 0; border: 2px solid #fff;"></span>
                                                                    </div>
                                                                    <div class="patient-info">
                                                                        <h6 class="mb-0 font-weight-bold"
                                                                            style="font-size: 0.9rem;">
                                                                            {{ $patient['name'] }}
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>{{ $patient['email']  }}</td>
                                                            <td>{{ $patient['phone']  }}</td>
                                                            <td>
                                                                <span class="badge"
                                                                    style="background-color: rgba(78, 115, 223, 0.1); color: #4e73df; border-radius: 1rem; padding: 0.4rem 0.8rem; font-weight: 500;">
                                                                    {{ $patient["patient_details"]["name_assurance"] ?? 'N/A' }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $patient["patient_details"]["assurance_number"] ?? 'N/A' }}</td>
                                                            <td>
                                                                <span class="badge badge-pill"
                                                                    style="background-color: rgba(231, 74, 59, 0.1); color: #e74a3b; border-radius: 1rem; padding: 0.4rem 0.8rem; font-weight: 500;">
                                                                    {{ $patient["patient_details"]["blood_type"] ?? 'N/A' }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="badge"
                                                                    style="background-color: rgba(28, 200, 138, 0.1); color: #1cc88a; border-radius: 1rem; padding: 0.4rem 0.8rem; font-weight: 500;">
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <div class="action-menu d-flex gap-1">
                                                                    <a href="{{ route('admin.patients.show', $patient['patient_details']->id ??  'N/A') }}"
                                                                        class="btn btn-sm d-flex align-items-center justify-content-center"
                                                                        style="width: 32px; height: 32px; border-radius: 50%; background-color: rgba(78, 115, 223, 0.1); color: #4e73df; transition: all 0.2s ease;">
                                                                        <i class="fas fa-eye"></i>
                                                                    </a>
                                                                    <a href="{{ route('admin.patients.edit', $patient['patient_details']->id ??  'N/A') }}"
                                                                        class="btn btn-sm d-flex align-items-center justify-content-center"
                                                                        style="width: 32px; height: 32px; border-radius: 50%; background-color: rgba(28, 200, 138, 0.1); color: #1cc88a; transition: all 0.2s ease;">
                                                                        <i class="fas fa-edit"></i>
                                                                    </a>

                                                                    <a href="{{ route('admin.patients.delete', $patient['patient_details']->id ??  'N/A') }}"
                                                                        class="btn btn-sm d-flex align-items-center justify-content-center"
                                                                        style="width: 32px; height: 32px; border-radius: 50%; background-color: rgba(28, 200, 138, 0.1); color: #e74a3b; transition: all 0.2s ease;">
                                                                        <i class="fas fa-trash"></i>
                                                                    </a>
                                                                    <!-- <button
                                                                                class="btn btn-sm d-flex align-items-center justify-content-center deletePatientBtn"
                                                                                style="width: 32px; height: 32px; border-radius: 50%; background-color: rgba(231, 74, 59, 0.1); color: #e74a3b; transition: all 0.2s ease;"
                                                                                data-id="{{ $patient['patient_details']->id ??  'N/A' }}" data-bs-toggle="modal"
                                                                                data-bs-target="#deletePatientModal">
                                                                                <i class="fas fa-trash"></i>
                                                                            </button> -->
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <!-- Pagination améliorée -->
                                        <div class="d-flex justify-content-between align-items-center mt-4">
                                            <div class="text-muted small">
                                                Affichage de <span class="font-weight-bold">1</span> à <span
                                                    class="font-weight-bold">10</span> sur <span
                                                    class="font-weight-bold">{{ $totalPatients }}</span> patients
                                            </div>
                                            <nav aria-label="Page navigation">
                                                <ul class="pagination pagination-sm">
                                                    <li class="page-item disabled">
                                                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true"
                                                            style="border-radius: 0.5rem 0 0 0.5rem;">Précédent</a>
                                                    </li>
                                                    <li class="page-item active"><a class="page-link" href="#">1</a>
                                                    </li>
                                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                    <li class="page-item">
                                                        <a class="page-link" href="#"
                                                            style="border-radius: 0 0.5rem 0.5rem 0;">Suivant</a>
                                                    </li>
                                                </ul>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Doctors Tab -->
                        <div class="table-responsive">
                            <table class="table table-bordered" id="doctorsTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Médecin</th>
                                        <th>Spécialité</th>
                                        <th>Disponibilité</th>
                                        <th>Nombre de Cabinet</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($doctors as $doctor)
                                        <tr>
                                            <td>
                                                <div class="doctor-profile">
                                                    <img src="{{ $doctor['profile_photo_url'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($doctor['name']) . '&color=7F9CF5&background=EBF4FF' }}"
                                                        alt="Doctor Photo">
                                                    <div class="doctor-info">
                                                        <h6>Dr. {{ $doctor['name'] }}</h6>
                                                        <span>{{ $doctor['email'] }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>{{ $doctor['doctor_details']->speciality ??  'N/A' }}</div>
                                                <div>{{ $doctor['phone'] }}</div>
                                            </td>
                                            <td>
                                                @if($doctor['doctor_details']->is_available ??  'N/A')
                                                    <span class="badge badge-success">Disponible</span>
                                                @else
                                                    <span class="badge badge-warning">Non disponible</span>
                                                @endif
                                            </td>
                                            <td>{{ $doctor['doctor_details']->nombre_cabinet  ??  'N/A'}}</td>
                                            <td>
                                                <div class="action-menu">
                                                    <a href=""
                                                        class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button class="btn btn-primary btn-sm edit-doctor-btn"
                                                        data-id="{{ $doctor['doctor_details']->id  ??  'N/A'}}"
                                                        data-name="{{ $doctor['name'] }}"
                                                        data-email="{{ $doctor['email'] }}"
                                                        data-phone="{{ $doctor['phone'] }}"
                                                        data-speciality="{{ $doctor['doctor_details']->speciality  ??  'N/A'}}"
                                                        data-nombre-cabinet="{{ $doctor['doctor_details']->nombre_cabinet  ??  'N/A'}}"
                                                        data-qualification="{{ $doctor['doctor_details']->qualification  ??  'N/A'}}"
                                                        data-is-available="{{ $doctor['doctor_details']->is_available  ??  'N/A'}}"
                                                        data-bs-toggle="modal" data-bs-target="#editDoctorModal">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button class="btn btn-danger btn-sm deleteDoctorBtn"
                                                        data-id="{{ $doctor['doctor_details']->id  ??  'N/A'}}" data-bs-toggle="modal"
                                                        data-bs-target="#deleteDoctorModal">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Appointments Tab -->
                        <div class="tab-pane fade" id="appointments" role="tabpanel">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">Gestion des rendez-vous</h6>
                                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#addAppointmentModal">
                                        <i class="fas fa-plus me-1"></i> Nouveau rendez-vous
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="appointmentsTable" width="100%"
                                            cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Patient</th>
                                                    <th>Médecin</th>
                                                    <th>Date & Heure</th>
                                                    <th>Statut</th>
                                                    <th>Paiement</th>
                                                    <th>Reason</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($appointments as $appointment)

                                                    <tr>
                                                        <td>{{ $appointment->id }}</td>
                                                        <td>{{ $appointment->patient->user->name }}</td>
                                                        <td>Dr. {{ $appointment->doctor->user->name }}</td>
                                                        <td>{{ $appointment->date }}, {{ $appointment->time }}</td>
                                                        <td>
                                                            @if($appointment->statut == 'confirmed')
                                                                <span class="badge badge-success">Confirmé</span>
                                                            @elseif($appointment->status == 'pending')
                                                                <span class="badge badge-warning">En attente</span>
                                                            @elseif($appointment->status == 'cenceled')
                                                                <span class="badge badge-danger">Annulé</span>
                                                            @elseif($appointment->status == 'terminé')
                                                                <span class="badge badge-info">Terminé</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($appointment->paiement)
                                                                <span class="badge badge-success">Payé</span>
                                                            @else
                                                                <span class="badge badge-danger">Non payé</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="action-menu">
                                                                <a href="" class="btn btn-info btn-sm">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <a href="" class="btn btn-primary btn-sm">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <button class="btn btn-danger btn-sm deleteAppointmentBtn"
                                                                    data-id="{{ $appointment->id }}" data-bs-toggle="modal"
                                                                    data-bs-target="#deleteAppointmentModal">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Statistics Tab -->
                        <div class="tab-pane fade" id="statistics" role="tabpanel">
                            <!-- Graphiques -->
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                            <h6 class="m-0 font-weight-bold text-primary">Évolution des rendez-vous</h6>
                                            <div class="dropdown no-arrow">
                                                <a class="dropdown-toggle" href="#" role="button"
                                                    id="appointmentsDropdown" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                                    aria-labelledby="appointmentsDropdown">
                                                    <div class="dropdown-header">Options du graphique:</div>
                                                    <a class="dropdown-item" href="#" id="toggleChartType">Changer le
                                                        type de graphique</a>
                                                    <a class="dropdown-item" href="#" id="downloadChartPNG">Télécharger
                                                        PNG</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="#" id="refreshChart">Actualiser les
                                                        données</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-container">
                                                <canvas id="appointmentsChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">Répartition par genre</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-container">
                                                <canvas id="genderChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">Rendez-vous par spécialité
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-container">
                                                <canvas id="specialtyChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">Revenus mensuels</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-container">
                                                <canvas id="revenueChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Performance des médecins -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Performance des médecins</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Médecin</th>
                                                    <th>Spécialité</th>
                                                    <th>Rendez-vous (Mensuel)</th>
                                                    <th>Taux de complétion</th>
                                                    <th>Évaluation moyenne</th>
                                                    <th>Revenus générés</th>
                                                </tr>
                                            </thead>

                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Système de Gestion de Clinique {{ date('Y') }}</span>
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

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Prêt à partir?</h5>
                    <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Sélectionnez "Déconnexion" ci-dessous si vous êtes prêt à mettre fin à votre
                    session actuelle.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Annuler</button>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Déconnexion</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Doctor Modal -->
    <div class="modal fade" id="addDoctorModal" tabindex="-1" role="dialog" aria-labelledby="addDoctorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDoctorModalLabel">Ajouter un nouveau médecin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addDoctorForm" method="POST" action="">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="doctor_name">Nom complet</label>
                                    <input type="text" class="form-control" id="doctor_name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="doctor_email">Email</label>
                                    <input type="email" class="form-control" id="doctor_email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="doctor_telephone">Téléphone</label>
                                    <input type="tel" class="form-control" id="doctor_telephone" name="phone" required>
                                </div>
                                <div class="mb-3">
                                    <label for="speciality">Spécialité</label>
                                    <input type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nombre_cabinet">Numéro de cabinet</label>
                                    <input type="text" class="form-control" id="nombre_cabinet" name="nombre_cabinet"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="qualification">Qualifications</label>
                                    <textarea class="form-control" id="qualification" name="qualification"
                                        rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="doctor_password">Mot de passe</label>
                                    <input type="password" class="form-control" id="doctor_password" name="password"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="doctor_password_confirmation">Confirmer le mot de passe</label>
                                    <input type="password" class="form-control" id="doctor_password_confirmation"
                                        name="password_confirmation" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Ajouter le médecin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Doctor Modal -->
    <div class="modal fade" id="editDoctorModal" tabindex="-1" role="dialog" aria-labelledby="editDoctorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDoctorModalLabel">Modifier le médecin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editDoctorForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_doctor_id" name="doctor_id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_doctor_name">Nom complet</label>
                                    <input type="text" class="form-control" id="edit_doctor_name" name="name" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_doctor_email">Email</label>
                                    <input type="email" class="form-control" id="edit_doctor_email" name="email"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_doctor_telephone">Téléphone</label>
                                    <input type="tel" class="form-control" id="edit_doctor_telephone" name="phone"
                                        required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_speciality">Spécialité</label>
                                    <input type="text">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="edit_nombre_cabinet">Numéro de cabinet</label>
                                    <input type="text" class="form-control" id="edit_nombre_cabinet"
                                        name="nombre_cabinet" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_qualification">Qualifications</label>
                                    <textarea class="form-control" id="edit_qualification" name="qualification"
                                        rows="3"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_doctor_password">Mot de passe (laisser vide pour ne pas
                                        modifier)</label>
                                    <input type="password" class="form-control" id="edit_doctor_password"
                                        name="password">
                                </div>
                                <div class="mb-3">
                                    <label for="edit_doctor_password_confirmation">Confirmer le mot de passe</label>
                                    <input type="password" class="form-control" id="edit_doctor_password_confirmation"
                                        name="password_confirmation">
                                </div>
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="edit_is_available"
                                            name="is_available">
                                        <label class="form-check-label" for="edit_is_available">
                                            Disponible
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Doctor Modal -->
    <div class="modal fade" id="deleteDoctorModal" tabindex="-1" role="dialog" aria-labelledby="deleteDoctorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteDoctorModalLabel">Supprimer un médecin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteDoctorForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" id="delete_doctor_id" name="doctor_id">
                    <div class="modal-body">
                        <p>Êtes-vous sûr de vouloir supprimer ce médecin? Cette action est irréversible et supprimera
                            également tous les rendez-vous associés.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add Doctor Modal -->


    <div class="modal fade" id="editScheduleModal" tabindex="-1" role="dialog" aria-labelledby="editScheduleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editScheduleModalLabel">Modifier le rendez-vous</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.appointment.update', $appointment->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="doctor_id" class="form-label">Doctor</label>
                                <select class="form-select " id="doctor_id" name="doctor_id" required>
                                    @foreach($doctors as $doctor)
                                        <option value="{{ $doctor['doctor_details']->id }}" {{ $appointment->doctor_id == $doctor['doctor_details']->id ? 'selected' : '' }}
                                            class="color-primary">
                                            {{ $doctor['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Patient Selection -->
                            <div class="col-md-6 mb-3">
                                <label for="doctor_speciality" class="form-label">speciality</label>
                                <input type="text" class="form-control" id="doctor_speciality" name="doctor_speciality"
                                    value="{{ $appointment->doctor->speciality }}" readonly>
                            </div>

                            <!-- Date Input -->
                            <div class="col-md-6 mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control" id="date" name="date"
                                    value="{{ $appointment->date }}" required>
                            </div>

                            <!-- Time Input -->
                            <div class="col-md-6 mb-3">
                                <label for="time" class="form-label">Heure</label>
                                <input type="time" class="form-control" id="time" name="time"
                                    value="{{ $appointment->date }}" required>
                            </div>

                            <!-- Status Selection -->
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Statut</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="planned" {{ $appointment->status == 'planned' ? 'selected' : '' }}>
                                        Planifié</option>
                                    <option value="completed" {{ $appointment->status == 'completed' ? 'selected' : '' }}>
                                        Terminé</option>
                                    <option value="canceled" {{ $appointment->status == 'canceled' ? 'selected' : '' }}>
                                        Annulé</option>
                                </select>
                            </div>

                            <!-- Reason Textarea -->
                            <div class="col-12 mb-3">
                                <label for="reason" class="form-label">Motif de consultation</label>
                                <textarea class="form-control" id="reason" name="reason" rows="3"
                                    required>{{ $appointment->reason }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Doctor Modal -->


    <!-- Add Appointment Modal -->
    <div class="modal fade" id="addAppointmentModal" tabindex="-1" role="dialog"
        aria-labelledby="addAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAppointmentModalLabel">Ajouter un nouveau rendez-vous</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addAppointmentForm" method="POST" action="">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="patient_id">Patient</label>
                            <select class="form-control" id="patient_id" name="patient_id" required>
                                <option value="">Sélectionner un patient</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient['patient_details']->id  ??  'N/A'}}">{{ $patient['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="doctor_id">Médecin</label>
                            <select class="form-control" id="doctor_id" name="doctor_id" required>
                                <option value="">Sélectionner un médecin</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor['doctor_details']->id }}">Dr.
                                        {{ $doctor['doctor_details']->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="mb-3">
                            <label for="time">Heure</label>
                            <input type="time" class="form-control" id="time" name="time" required>
                        </div>
                        <div class="mb-3">
                            <label for="statut">Statut</label>
                            <select class="form-control" id="statut" name="statut" required>
                                <option value="en attente">En attente</option>
                                <option value="confirmé">Confirmé</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="reason">Notes</label>
                            <textarea class="form-control" id="reason" name="reason" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Ajouter le rendez-vous</button>
                        </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Patient Modal -->
    <div class="modal fade" id="deletePatientModal" tabindex="-1" role="dialog"
        aria-labelledby="deletePatientModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePatientModalLabel">Supprimer un patient</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deletePatientForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Êtes-vous sûr de vouloir supprimer ce patient? Cette action est irréversible et supprimera
                            également tous les rendez-vous associés.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Doctor Modal -->


    <!-- Delete Appointment Modal -->
    <div class="modal fade" id="deleteAppointmentModal" tabindex="-1" role="dialog"
        aria-labelledby="deleteAppointmentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteAppointmentModalLabel">Supprimer un rendez-vous</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="deleteAppointmentForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>Êtes-vous sûr de vouloir supprimer ce rendez-vous? Cette action est irréversible.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarToggleTop = document.getElementById('sidebarToggleTop');
            const body = document.querySelector('body');
            const sidebar = document.querySelector('.sidebar');

            function toggleSidebar() {
                body.classList.toggle('sidebar-toggled');
                sidebar.classList.toggle('toggled');
                localStorage.setItem('sidebarState', sidebar.classList.contains('toggled') ? 'toggled' : 'expanded');
            }

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', toggleSidebar);
            }

            if (sidebarToggleTop) {
                sidebarToggleTop.addEventListener('click', toggleSidebar);
            }

            const sidebarState = localStorage.getItem('sidebarState');
            if (sidebarState === 'toggled') {
                body.classList.add('sidebar-toggled');
                sidebar.classList.add('toggled');
            }

            document.querySelectorAll('.deletePatientBtn').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    document.getElementById('deletePatientForm').setAttribute('action', `/admin/patients/${id}`);
                });
            });

            document.querySelectorAll('.deleteDoctorBtn').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    document.getElementById('deleteDoctorForm').setAttribute('action', `/admin/medecins/${id}`);
                });
            });

            document.querySelectorAll('.deleteAppointmentBtn').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    document.getElementById('deleteAppointmentForm').setAttribute('action', `/admin/rendez-vous/${id}`);
                });
            });

            const genderChart = new Chart(
                document.getElementById('genderChart').getContext('2d'),
                {
                    type: 'pie',
                    data: {
                        labels: ['Hommes', 'Femmes'],
                        datasets: [{
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.7)',
                                'rgba(255, 99, 132, 0.7)'
                            ],
                            borderColor: [
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 99, 132, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                }
            );

            document.getElementById('toggleChartType').addEventListener('click', function () {
                if (appointmentsChart.config.type === 'bar') {
                    appointmentsChart.config.type = 'line';
                    appointmentsChart.data.datasets[0].tension = 0.4;
                    appointmentsChart.data.datasets[0].fill = true;
                } else {
                    appointmentsChart.config.type = 'bar';
                    appointmentsChart.data.datasets[0].tension = 0;
                    appointmentsChart.data.datasets[0].fill = false;
                }
                appointmentsChart.update();
            });

            document.getElementById('downloadChartPNG').addEventListener('click', function () {
                const link = document.createElement('a');
                link.href = appointmentsChart.toBase64Image();
                link.download = 'evolution_rendez_vous.png';
                link.click();
            });

            document.getElementById('refreshDashboard').addEventListener('click', function () {
                this.innerHTML = '<i class="fas fa-spinner fa-spin fa-sm text-white-50"></i> Actualisation...';
                this.disabled = true;

                setTimeout(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Tableau de bord actualisé',
                        text: 'Les données ont été mises à jour avec succès!',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    this.innerHTML = '<i class="fas fa-sync-alt fa-sm text-white-50"></i> Actualiser';
                    this.disabled = false;
                }, 1500);
            });

            document.getElementById('refreshChart').addEventListener('click', function () {
                const loadingToast = Swal.fire({
                    title: 'Actualisation...',
                    html: 'Mise à jour des données en cours',
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                loadingToast.then(() => {
                    const months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin'];
                    const newData = months.map(() => Math.floor(Math.random() * 50) + 50);

                    appointmentsChart.data.datasets[0].data = newData;
                    appointmentsChart.update();

                    Swal.fire({
                        icon: 'success',
                        title: 'Données actualisées',
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
            });

            document.addEventListener('click', function (e) {
                if (e.target && e.target.classList.contains('toggle-availability')) {
                    e.preventDefault();
                    const doctorId = e.target.getAttribute('data-doctor-id');
                    const currentStatus = e.target.getAttribute('data-status');
                    const newStatus = currentStatus === 'available' ? 'unavailable' : 'available';

                    // Simuler une mise à jour de la disponibilité
                    Swal.fire({
                        title: 'Changer la disponibilité?',
                        text: `Voulez-vous marquer ce médecin comme ${newStatus === 'available' ? 'disponible' : 'indisponible'}?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#1cc88a',
                        cancelButtonColor: '#e74a3b',
                        confirmButtonText: 'Oui, changer',
                        cancelButtonText: 'Annuler'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            setTimeout(() => {
                                e.target.setAttribute('data-status', newStatus);
                                e.target.textContent = newStatus === 'available' ? 'Marquer comme indisponible' : 'Marquer comme disponible';

                                const badge = document.querySelector(`#availability-badge-${doctorId}`);
                                if (badge) {
                                    badge.className = newStatus === 'available' ? 'badge badge-success' : 'badge badge-warning';
                                    badge.textContent = newStatus === 'available' ? 'Disponible' : 'Non disponible';
                                }

                                Swal.fire({
                                    title: 'Mise à jour réussie!',
                                    text: `Le médecin est maintenant ${newStatus === 'available' ? 'disponible' : 'indisponible'}.`,
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            }, 800);
                        }
                    });
                }
            });

            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });

            window.confirmAppointment = function (id) {
                Swal.fire({
                    title: 'Confirmer ce rendez-vous?',
                    text: "Cette action enverra une notification au patient.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#1cc88a',
                    cancelButtonColor: '#e74a3b',
                    confirmButtonText: 'Oui, confirmer',
                    cancelButtonText: 'Annuler'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/admin/rendez-vous/${id}/confirm`;

                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = csrfToken;

                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'PUT';

                        form.appendChild(csrfInput);
                        form.appendChild(methodInput);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            };

            window.cancelAppointment = function (id) {
                Swal.fire({
                    title: 'Annuler ce rendez-vous?',
                    text: "Cette action enverra une notification au patient et libérera ce créneau horaire.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e74a3b',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Oui, annuler',
                    cancelButtonText: 'Retour'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `/admin/rendez-vous/${id}/cancel`;

                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        const csrfInput = document.createElement('input');
                        csrfInput.type = 'hidden';
                        csrfInput.name = '_token';
                        csrfInput.value = csrfToken;

                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'PUT';

                        form.appendChild(csrfInput);
                        form.appendChild(methodInput);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            };

            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Succès!',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur!',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#4e73df'
                });
            @endif
            
            const scrollTopButton = document.querySelector('.scroll-to-top');

            window.addEventListener('scroll', function () {
                if (window.scrollY > 100) {
                    scrollTopButton.style.display = 'block';
                    setTimeout(() => scrollTopButton.style.opacity = 1, 50);
                } else {
                    scrollTopButton.style.opacity = 0;
                    setTimeout(() => {
                        if (scrollTopButton.style.opacity === '0') {
                            scrollTopButton.style.display = 'none';
                        }
                    }, 300);
                }
            });

            scrollTopButton.addEventListener('click', function (e) {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            document.getElementById('specialite_filter')?.addEventListener('change', function () {
                const specialiteId = this.value;
                const rows = document.querySelectorAll('#doctorsTable tbody tr');

                rows.forEach(row => {
                    const specialiteCell = row.querySelector('td:nth-child(2)').getAttribute('data-specialite-id');
                    if (specialiteId === '' || specialiteCell === specialiteId) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });

            document.getElementById('doctor_id')?.addEventListener('change', checkDoctorAvailability);
            document.getElementById('date')?.addEventListener('change', checkDoctorAvailability);
            document.getElementById('heure')?.addEventListener('change', checkDoctorAvailability);

            function checkDoctorAvailability() {
                const doctorId = document.getElementById('doctor_id')?.value;
                const date = document.getElementById('date')?.value;
                const time = document.getElementById('heure')?.value;
                const availabilityMessage = document.getElementById('availability_message');

                if (doctorId && date && time && availabilityMessage) {
                    availabilityMessage.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Vérification de la disponibilité...';
                    availabilityMessage.className = 'text-info mt-2';

                    setTimeout(() => {
                        const isAvailable = Math.random() > 0.3;

                        if (isAvailable) {
                            availabilityMessage.innerHTML = '<i class="fas fa-check-circle"></i> Ce créneau est disponible!';
                            availabilityMessage.className = 'text-success mt-2';
                        } else {
                            availabilityMessage.innerHTML = '<i class="fas fa-times-circle"></i> Ce créneau n\'est pas disponible. Veuillez choisir un autre horaire.';
                            availabilityMessage.className = 'text-danger mt-2';
                        }
                    }, 1000);
                }
            }
        });
        document.addEventListener('DOMContentLoaded', function () {
            function updateDateTime() {
                const now = new Date();

                const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                const dateElement = document.getElementById('currentDate');
                if (dateElement) {
                    dateElement.textContent = now.toLocaleDateString('fr-FR', options);
                }

                const timeElement = document.getElementById('currentTime');
                if (timeElement) {
                    timeElement.textContent = now.toLocaleTimeString('fr-FR', {
                        hour: '2-digit',
                        minute: '2-digit'
                    });
                }
            }

            updateDateTime();
            setInterval(updateDateTime, 60000);

            const searchInput = document.getElementById('globalSearch');
            const searchDropdown = document.querySelector('.search-dropdown');

            if (searchInput && searchDropdown) {
                searchInput.addEventListener('focus', function () {
                    searchDropdown.classList.remove('d-none');
                });

                document.addEventListener('click', function (event) {
                    if (!searchInput.contains(event.target) && !searchDropdown.contains(event.target)) {
                        searchDropdown.classList.add('d-none');
                    }
                });
            }

            const notificationItems = document.querySelectorAll('.notification-list .dropdown-item');
            notificationItems.forEach(item => {
                item.addEventListener('mouseenter', function () {
                    this.style.backgroundColor = 'rgba(78, 115, 223, 0.05)';
                    const actionButtons = this.querySelector('.action-buttons');
                    if (actionButtons) actionButtons.style.opacity = '1';
                });

                item.addEventListener('mouseleave', function () {
                    if (!this.classList.contains('unread')) {
                        this.style.backgroundColor = '';
                    }
                    const actionButtons = this.querySelector('.action-buttons');
                    if (actionButtons) actionButtons.style.opacity = '0';
                });
            });

            const quickActionButtons = document.querySelectorAll('.quick-actions .btn');
            quickActionButtons.forEach(button => {
                button.addEventListener('mouseenter', function () {
                    this.style.transform = 'translateY(-2px)';
                    this.style.boxShadow = '0 4px 8px rgba(0,0,0,0.1)';
                });

                button.addEventListener('mouseleave', function () {
                    this.style.transform = '';
                    this.style.boxShadow = '';
                });
            });

            const userMenuItems = document.querySelectorAll('.dropdown-menu .dropdown-item');
            userMenuItems.forEach(item => {
                item.addEventListener('mouseenter', function () {
                    this.style.backgroundColor = 'rgba(78, 115, 223, 0.05)';
                });

                item.addEventListener('mouseleave', function () {
                    this.style.backgroundColor = '';
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            // Configuration pour le modal d'édition des médecins
            document.querySelectorAll('.edit-doctor-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const name = this.getAttribute('data-name');
                    const email = this.getAttribute('data-email');
                    const phone = this.getAttribute('data-phone');
                    const speciality = this.getAttribute('data-speciality');
                    const nombreCabinet = this.getAttribute('data-nombre-cabinet');
                    const qualification = this.getAttribute('data-qualification');
                    const isAvailable = this.getAttribute('data-is-available');

                    // Mise à jour de l'ID dans le formulaire
                    document.getElementById('edit_doctor_id').value = id;
                    document.getElementById('editDoctorForm').action = `/admin/doctors/${id}`;

                    // Remplissage des champs du formulaire
                    document.getElementById('edit_doctor_name').value = name;
                    document.getElementById('edit_doctor_email').value = email;
                    document.getElementById('edit_doctor_telephone').value = phone;

                    // Sélection de la spécialité
                    const specialitySelect = document.getElementById('edit_speciality');
                    for (let i = 0; i < specialitySelect.options.length; i++) {
                        if (specialitySelect.options[i].text === speciality) {
                            specialitySelect.selectedIndex = i;
                            break;
                        }
                    }

                    document.getElementById('edit_nombre_cabinet').value = nombreCabinet;
                    document.getElementById('edit_qualification').value = qualification;

                    // Gestion de la disponibilité
                    document.getElementById('edit_is_available').checked = isAvailable === '1';

                    // Réinitialisation des champs de mot de passe
                    document.getElementById('edit_doctor_password').value = '';
                    document.getElementById('edit_doctor_password_confirmation').value = '';
                });
            });

            // Configuration pour le modal de suppression des médecins
            document.querySelectorAll('.deleteDoctorBtn').forEach(button => {
                button.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    document.getElementById('delete_doctor_id').value = id;
                    document.getElementById('deleteDoctorForm').action = `/admin/doctors/${id}`;
                });
            });

            // Validation des formulaires
            function validateForm(formId) {
                const form = document.getElementById(formId);
                if (!form) return true;

                let isValid = true;

                // Vérification des champs requis
                const requiredFields = form.querySelectorAll('[required]');
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('is-invalid');

                        // Création d'un message d'erreur si absent
                        let feedbackDiv = field.nextElementSibling;
                        if (!feedbackDiv || !feedbackDiv.classList.contains('invalid-feedback')) {
                            feedbackDiv = document.createElement('div');
                            feedbackDiv.className = 'invalid-feedback';
                            feedbackDiv.textContent = 'Ce champ est requis';
                            field.parentNode.insertBefore(feedbackDiv, field.nextSibling);
                        }
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                // Vérification de la correspondance des mots de passe
                if (formId === 'addDoctorForm' || formId === 'editDoctorForm') {
                    const passwordField = form.querySelector('[name="password"]');
                    const confirmField = form.querySelector('[name="password_confirmation"]');

                    if (passwordField.value && passwordField.value !== confirmField.value) {
                        isValid = false;
                        confirmField.classList.add('is-invalid');

                        let feedbackDiv = confirmField.nextElementSibling;
                        if (!feedbackDiv || !feedbackDiv.classList.contains('invalid-feedback')) {
                            feedbackDiv = document.createElement('div');
                            feedbackDiv.className = 'invalid-feedback';
                            feedbackDiv.textContent = 'Les mots de passe ne correspondent pas';
                            confirmField.parentNode.insertBefore(feedbackDiv, confirmField.nextSibling);
                        }
                    }
                }

                return isValid;
            }

            // Association de la validation aux formulaires
            const addDoctorForm = document.getElementById('addDoctorForm');
            if (addDoctorForm) {
                addDoctorForm.addEventListener('submit', function (e) {
                    if (!validateForm('addDoctorForm')) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                });
            }

            const editDoctorForm = document.getElementById('editDoctorForm');
            if (editDoctorForm) {
                editDoctorForm.addEventListener('submit', function (e) {
                    if (!validateForm('editDoctorForm')) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                });
            }

            // Réinitialisation des formulaires lors de la fermeture des modals
            document.querySelectorAll('.modal').forEach(modal => {
                modal.addEventListener('hidden.bs.modal', function () {
                    const form = this.querySelector('form');
                    if (form) {
                        form.reset();
                        form.querySelectorAll('.is-invalid').forEach(field => {
                            field.classList.remove('is-invalid');
                        });
                        form.querySelectorAll('.invalid-feedback').forEach(feedback => {
                            feedback.remove();
                        });
                    }
                });
            });
        });
    </script>



</body>

</html>