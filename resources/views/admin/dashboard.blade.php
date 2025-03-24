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

</head>

<body id="page-top">
    <div id="wrapper">
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


                <div class="container-fluid">
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Total Patients</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">154</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Total Doctors</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">12</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-md fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Appointments Today</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">32</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Pending Appointments</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-tabs mb-4" id="dashboardTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="patients-tab" data-toggle="tab" href="#patients"
                                role="tab">Patients</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="doctors-tab" data-toggle="tab" href="#doctors"
                                role="tab">Doctors</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="appointments-tab" data-toggle="tab" href="#appointments"
                                role="tab">Appointments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="statistics-tab" data-toggle="tab" href="#statistics"
                                role="tab">Detailed Statistics</a>
                        </li>
                    </ul>

                    <div class="tab-content" id="dashboardContent">
                        <div class="tab-pane fade show active" id="patients" role="tabpanel">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">Patient Management</h6>

                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="patientsTable" width="100%"
                                            cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Assurance</th>
                                                    <th>Date of Birth</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($patients as $patient)
                                                    <tr>
                                                        <td>{{ $patient->user["name"] }}</td>
                                                        <td>{{ $patient->user["email"] }}</td>
                                                        <td>{{ $patient->phone }}</td>
                                                        <td>{{ $patient->assurance }}</td>
                                                        <td>{{ $patient->date_of_birth }}</td>
                                                        <td>
                                                            <button class="btn btn-info btn-sm editPatientBtn"
                                                                data-id="{{ $patient->id }}"
                                                                data-name="{{ $patient->name }}"
                                                                data-email="{{ $patient->email }}"
                                                                data-phone="{{ $patient->phone }}"
                                                                data-dob="{{ $patient->dob }}" data-toggle="modal"
                                                                data-target="#editPatientModal">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button class="btn btn-danger btn-sm deletePatientBtn"
                                                                data-id="{{ $patient->id }}" data-toggle="modal"
                                                                data-target="#deletePatientModal">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="doctors" role="tabpanel">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">Doctor Management</h6>
                                    <button class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#addDoctorModal">
                                        <i class="fas fa-plus"></i> Add Doctor
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="doctorsTable" width="100%"
                                            cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Name</th>
                                                    <th>Specialty</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Dr. Ahmed Lahlou</td>
                                                    <td>Cardiology</td>
                                                    <td>a.lahlou@example.com</td>
                                                    <td>+212 661-234567</td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm editDoctorBtn" data-id="1"
                                                            data-name="Dr. Ahmed Lahlou" data-specialty="Cardiology"
                                                            data-email="a.lahlou@example.com"
                                                            data-phone="+212 661-234567" data-toggle="modal"
                                                            data-target="#editDoctorModal">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-danger btn-sm deleteDoctorBtn"
                                                            data-id="1" data-toggle="modal"
                                                            data-target="#deleteDoctorModal">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Dr. Leila Bouzidi</td>
                                                    <td>Pediatrics</td>
                                                    <td>l.bouzidi@example.com</td>
                                                    <td>+212 667-345678</td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm editDoctorBtn" data-id="2"
                                                            data-name="Dr. Leila Bouzidi" data-specialty="Pediatrics"
                                                            data-email="l.bouzidi@example.com"
                                                            data-phone="+212 667-345678" data-toggle="modal"
                                                            data-target="#editDoctorModal">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-danger btn-sm deleteDoctorBtn"
                                                            data-id="2" data-toggle="modal"
                                                            data-target="#deleteDoctorModal">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Dr. Omar Tazi</td>
                                                    <td>Neurology</td>
                                                    <td>o.tazi@example.com</td>
                                                    <td>+212 673-456789</td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm editDoctorBtn" data-id="3"
                                                            data-name="Dr. Omar Tazi" data-specialty="Neurology"
                                                            data-email="o.tazi@example.com" data-phone="+212 673-456789"
                                                            data-toggle="modal" data-target="#editDoctorModal">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-danger btn-sm deleteDoctorBtn"
                                                            data-id="3" data-toggle="modal"
                                                            data-target="#deleteDoctorModal">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Dr. Samira Chennaoui</td>
                                                    <td>Dermatology</td>
                                                    <td>s.chennaoui@example.com</td>
                                                    <td>+212 684-567890</td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm editDoctorBtn" data-id="4"
                                                            data-name="Dr. Samira Chennaoui"
                                                            data-specialty="Dermatology"
                                                            data-email="s.chennaoui@example.com"
                                                            data-phone="+212 684-567890" data-toggle="modal"
                                                            data-target="#editDoctorModal">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-danger btn-sm deleteDoctorBtn"
                                                            data-id="4" data-toggle="modal"
                                                            data-target="#deleteDoctorModal">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="appointments" role="tabpanel">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                    <h6 class="m-0 font-weight-bold text-primary">Appointment Management</h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="appointmentsTable" width="100%"
                                            cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Patient</th>
                                                    <th>Doctor</th>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Mohammed Alami</td>
                                                    <td>Dr. Ahmed Lahlou</td>
                                                    <td>2025-03-25</td>
                                                    <td>09:30</td>
                                                    <td>
                                                        <span class="badge badge-success">Confirmed</span>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm editAppointmentBtn"
                                                            data-id="1" data-patient="1" data-doctor="1"
                                                            data-date="2025-03-25" data-time="09:30"
                                                            data-status="confirmed" data-toggle="modal"
                                                            data-target="#editAppointmentModal">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-danger btn-sm deleteAppointmentBtn"
                                                            data-id="1" data-toggle="modal"
                                                            data-target="#deleteAppointmentModal">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Fatima Zahra</td>
                                                    <td>Dr. Leila Bouzidi</td>
                                                    <td>2025-03-25</td>
                                                    <td>11:00</td>
                                                    <td>
                                                        <span class="badge badge-success">Confirmed</span>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm editAppointmentBtn"
                                                            data-id="2" data-patient="2" data-doctor="2"
                                                            data-date="2025-03-25" data-time="11:00"
                                                            data-status="confirmed" data-toggle="modal"
                                                            data-target="#editAppointmentModal">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-danger btn-sm deleteAppointmentBtn"
                                                            data-id="2" data-toggle="modal"
                                                            data-target="#deleteAppointmentModal">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Karim Benali</td>
                                                    <td>Dr. Omar Tazi</td>
                                                    <td>2025-03-26</td>
                                                    <td>10:15</td>
                                                    <td>
                                                        <span class="badge badge-warning">Pending</span>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm editAppointmentBtn"
                                                            data-id="3" data-patient="3" data-doctor="3"
                                                            data-date="2025-03-26" data-time="10:15"
                                                            data-status="pending" data-toggle="modal"
                                                            data-target="#editAppointmentModal">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-danger btn-sm deleteAppointmentBtn"
                                                            data-id="3" data-toggle="modal"
                                                            data-target="#deleteAppointmentModal">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Souad Moussaoui</td>
                                                    <td>Dr. Samira Chennaoui</td>
                                                    <td>2025-03-26</td>
                                                    <td>14:45</td>
                                                    <td>
                                                        <span class="badge badge-warning">Pending</span>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm editAppointmentBtn"
                                                            data-id="4" data-patient="4" data-doctor="4"
                                                            data-date="2025-03-26" data-time="14:45"
                                                            data-status="pending" data-toggle="modal"
                                                            data-target="#editAppointmentModal">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-danger btn-sm deleteAppointmentBtn"
                                                            data-id="4" data-toggle="modal"
                                                            data-target="#deleteAppointmentModal">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>Younes El Amrani</td>
                                                    <td>Dr. Ahmed Lahlou</td>
                                                    <td>2025-03-27</td>
                                                    <td>10:30</td>
                                                    <td>
                                                        <span class="badge badge-warning">Pending</span>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm editAppointmentBtn"
                                                            data-id="5" data-patient="5" data-doctor="1"
                                                            data-date="2025-03-27" data-time="10:30"
                                                            data-status="pending" data-toggle="modal"
                                                            data-target="#editAppointmentModal">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-danger btn-sm deleteAppointmentBtn"
                                                            data-id="5" data-toggle="modal"
                                                            data-target="#deleteAppointmentModal">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="statistics" role="tabpanel">
                            <div class="row ">
                                <div class="col-lg-7 ml-5">
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">Appointments by Month</h6>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="appointmentsChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 ml-5">
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">Patient Demographics</h6>
                                        </div>
                                        <div class="card-body">
                                            <canvas id="patientDemographicsChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card shadow mb-4">
                                        <div class="card-header py-3">
                                            <h6 class="m-0 font-weight-bold text-primary">Doctor Performance</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" width="100%" cellspacing="0">
                                                    <thead>
                                                        <tr>
                                                            <th>Doctor</th>
                                                            <th>Specialty</th>
                                                            <th>Appointments (Monthly)</th>
                                                            <th>Completion Rate</th>
                                                            <th>Average Patient Rating</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Dr. Ahmed Lahlou</td>
                                                            <td>Cardiology</td>
                                                            <td>42</td>
                                                            <td>
                                                                <div class="progress">
                                                                    <div class="progress-bar bg-success"
                                                                        role="progressbar" style="width: 92%"
                                                                        aria-valuenow="92" aria-valuemin="0"
                                                                        aria-valuemax="100">92%</div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="text-warning">
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star-half-alt"></i>
                                                                    (4.6)
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Dr. Leila Bouzidi</td>
                                                            <td>Pediatrics</td>
                                                            <td>38</td>
                                                            <td>
                                                                <div class="progress">
                                                                    <div class="progress-bar bg-success"
                                                                        role="progressbar" style="width: 89%"
                                                                        aria-valuenow="89" aria-valuemin="0"
                                                                        aria-valuemax="100">89%</div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="text-warning">
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    (4.8)
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Dr. Omar Tazi</td>
                                                            <td>Neurology</td>
                                                            <td>25</td>
                                                            <td>
                                                                <div class="progress">
                                                                    <div class="progress-bar bg-primary"
                                                                        role="progressbar" style="width: 85%"
                                                                        aria-valuenow="85" aria-valuemin="0"
                                                                        aria-valuemax="100">85%</div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="text-warning">
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="far fa-star"></i>
                                                                    (4.2)
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Dr. Samira Chennaoui</td>
                                                            <td>Dermatology</td>
                                                            <td>35</td>
                                                            <td>
                                                                <div class="progress">
                                                                    <div class="progress-bar bg-info" role="progressbar"
                                                                        style="width: 78%" aria-valuenow="78"
                                                                        aria-valuemin="0" aria-valuemax="100">78%</div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="text-warning">
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star-half-alt"></i>
                                                                    <i class="far fa-star"></i>
                                                                    (3.7)
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="addDoctorModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Add New Doctor</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="addDoctorForm" method="POST" action="/doctors">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Specialty</label>
                                        <select class="form-control" name="specialty" required>
                                            <option value="">Select Specialty</option>
                                            <option value="Cardiology">Cardiology</option>
                                            <option value="Dermatology">Dermatology</option>
                                            <option value="Endocrinology">Endocrinology</option>
                                            <option value="Gastroenterology">Gastroenterology</option>
                                            <option value="Neurology">Neurology</option>
                                            <option value="Obstetrics">Obstetrics</option>
                                            <option value="Ophthalmology">Ophthalmology</option>
                                            <option value="Orthopedics">Orthopedics</option>
                                            <option value="Pediatrics">Pediatrics</option>
                                            <option value="Psychiatry">Psychiatry</option>
                                            <option value="Urology">Urology</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" name="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="tel" class="form-control" name="phone" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Qualification</label>
                                        <input type="text" class="form-control" name="qualification">
                                    </div>
                                    <div class="form-group">
                                        <label>Experience (Years)</label>
                                        <input type="number" class="form-control" name="experience" min="1">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Add Doctor</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="editDoctorModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Doctor</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="editDoctorForm" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <input type="hidden" id="edit_doctor_id" name="doctor_id">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" id="edit_doctor_name" name="name"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label>Specialty</label>
                                        <select class="form-control" id="edit_doctor_specialty" name="specialty"
                                            required>
                                            <option value="Cardiology">Cardiology</option>
                                            <option value="Dermatology">Dermatology</option>
                                            <option value="Endocrinology">Endocrinology</option>
                                            <option value="Gastroenterology">Gastroenterology</option>
                                            <option value="Neurology">Neurology</option>
                                            <option value="Obstetrics">Obstetrics</option>
                                            <option value="Ophthalmology">Ophthalmology</option>
                                            <option value="Orthopedics">Orthopedics</option>
                                            <option value="Pediatrics">Pediatrics</option>
                                            <option value="Psychiatry">Psychiatry</option>
                                            <option value="Urology">Urology</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" id="edit_doctor_email" name="email"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="tel" class="form-control" id="edit_doctor_phone" name="phone"
                                            required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update Doctor</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="deleteDoctorModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Delete Doctor</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="deleteDoctorForm" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-body">
                                    <input type="hidden" id="delete_doctor_id" name="doctor_id">
                                    <p>Are you sure you want to delete this doctor? This action cannot be undone and
                                        will also remove all associated appointments.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete Doctor</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="editPatientModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Patient</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="editPatientForm" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <input type="hidden" id="edit_patient_id" name="patient_id">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" id="edit_patient_name" name="name"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control" id="edit_patient_email" name="email"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="tel" class="form-control" id="edit_patient_phone" name="phone"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label>Date of Birth</label>
                                        <input type="date" class="form-control" id="edit_patient_dob" name="dob"
                                            required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update Patient</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="deletePatientModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Delete Patient</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="deletePatientForm" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-body">
                                    <input type="hidden" id="delete_patient_id" name="patient_id">
                                    <p>Are you sure you want to delete this patient? This action cannot be undone.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete Patient</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="editAppointmentModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Appointment</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="editAppointmentForm" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <input type="hidden" id="edit_appointment_id" name="appointment_id">
                                    <div class="form-group">
                                        <label>Patient</label>
                                        <select class="form-control" id="edit_appointment_patient" name="patient_id"
                                            required>
                                            <option value="1">Mohammed Alami</option>
                                            <option value="2">Fatima Zahra</option>
                                            <option value="3">Karim Benali</option>
                                            <option value="4">Souad Moussaoui</option>
                                            <option value="5">Younes El Amrani</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Doctor</label>
                                        <select class="form-control" id="edit_appointment_doctor" name="doctor_id"
                                            required>
                                            <option value="1">Dr. Ahmed Lahlou (Cardiology)</option>
                                            <option value="2">Dr. Leila Bouzidi (Pediatrics)</option>
                                            <option value="3">Dr. Omar Tazi (Neurology)</option>
                                            <option value="4">Dr. Samira Chennaoui (Dermatology)</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="date" class="form-control" id="edit_appointment_date" name="date"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label>Time</label>
                                        <input type="time" class="form-control" id="edit_appointment_time" name="time"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" id="edit_appointment_status" name="status"
                                            required>
                                            <option value="pending">Pending</option>
                                            <option value="confirmed">Confirmed</option>
                                            <option value="canceled">Canceled</option>
                                            <option value="completed">Completed</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Update Appointment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="deleteAppointmentModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Delete Appointment</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="deleteAppointmentForm" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-body">
                                    <input type="hidden" id="delete_appointment_id" name="appointment_id">
                                    <p>Are you sure you want to delete this appointment? This action cannot be undone.
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete Appointment</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof DataTable !== 'undefined') {
                new DataTable(document.getElementById('patientsTable'));
                new DataTable(document.getElementById('doctorsTable'));
                new DataTable(document.getElementById('appointmentsTable'));
            } else {
                if (typeof $.fn.DataTable !== 'undefined') {
                    $('#patientsTable').DataTable();
                    $('#doctorsTable').DataTable();
                    $('#appointmentsTable').DataTable();
                }
            }

            const editPatientBtns = document.querySelectorAll('.editPatientBtn');
            editPatientBtns.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    document.getElementById('edit_patient_id').value = this.getAttribute('data-id');
                    document.getElementById('edit_patient_name').value = this.getAttribute('data-name');
                    document.getElementById('edit_patient_email').value = this.getAttribute('data-email');
                    document.getElementById('edit_patient_phone').value = this.getAttribute('data-phone');
                    document.getElementById('edit_patient_dob').value = this.getAttribute('data-dob');
                    document.getElementById('editPatientForm').setAttribute('action', '/patients/' + this.getAttribute('data-id'));
                });
            });

            const deletePatientBtns = document.querySelectorAll('.deletePatientBtn');
            deletePatientBtns.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    document.getElementById('delete_patient_id').value = this.getAttribute('data-id');
                    document.getElementById('deletePatientForm').setAttribute('action', '/patients/' + this.getAttribute('data-id'));
                });
            });
=
            const editDoctorBtns = document.querySelectorAll('.editDoctorBtn');
            editDoctorBtns.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    document.getElementById('edit_doctor_id').value = this.getAttribute('data-id');
                    document.getElementById('edit_doctor_name').value = this.getAttribute('data-name');
                    document.getElementById('edit_doctor_specialty').value = this.getAttribute('data-specialty');
                    document.getElementById('edit_doctor_email').value = this.getAttribute('data-email');
                    document.getElementById('edit_doctor_phone').value = this.getAttribute('data-phone');
                    document.getElementById('editDoctorForm').setAttribute('action', '/doctors/' + this.getAttribute('data-id'));
                });
            });

            const deleteDoctorBtns = document.querySelectorAll('.deleteDoctorBtn');
            deleteDoctorBtns.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    document.getElementById('delete_doctor_id').value = this.getAttribute('data-id');
                    document.getElementById('deleteDoctorForm').setAttribute('action', '/doctors/' + this.getAttribute('data-id'));
                });
            });
=
            const editAppointmentBtns = document.querySelectorAll('.editAppointmentBtn');
            editAppointmentBtns.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    document.getElementById('edit_appointment_id').value = this.getAttribute('data-id');
                    document.getElementById('edit_appointment_patient').value = this.getAttribute('data-patient');
                    document.getElementById('edit_appointment_doctor').value = this.getAttribute('data-doctor');
                    document.getElementById('edit_appointment_date').value = this.getAttribute('data-date');
                    document.getElementById('edit_appointment_time').value = this.getAttribute('data-time');
                    document.getElementById('edit_appointment_status').value = this.getAttribute('data-status');
                    document.getElementById('editAppointmentForm').setAttribute('action', '/appointments/' + this.getAttribute('data-id'));
                });
            });

            const deleteAppointmentBtns = document.querySelectorAll('.deleteAppointmentBtn');
            deleteAppointmentBtns.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    document.getElementById('delete_appointment_id').value = this.getAttribute('data-id');
                    document.getElementById('deleteAppointmentForm').setAttribute('action', '/appointments/' + this.getAttribute('data-id'));
                });
            });

            const appointmentsCtx = document.getElementById('appointmentsChart').getContext('2d');
            const appointmentsChart = new Chart(appointmentsCtx, {
                type: 'bar',
                data: {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                    datasets: [{
                        label: 'Number of Appointments',
                        data: [65, 78, 90, 81, 86, 95],
                        backgroundColor: 'rgba(78, 115, 223, 0.5)',
                        borderColor: 'rgba(78, 115, 223, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const demographicsCtx = document.getElementById('patientDemographicsChart').getContext('2d');
            const demographicsChart = new Chart(demographicsCtx, {
                type: 'pie',
                data: {
                    labels: ['Male', 'Female'],
                    datasets: [{
                        label: 'Patient Gender Distribution',
                        data: [85, 69],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.5)',
                            'rgba(255, 99, 132, 0.5)'
                        ],
                        borderColor: [
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                }
            });
        });
    </script>
</body>

</html>