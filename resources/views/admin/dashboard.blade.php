@extends('layouts.admin')

@section('content')
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
            <a class="nav-link active" id="patients-tab" data-toggle="tab" href="#patients" role="tab">Patients</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="doctors-tab" data-toggle="tab" href="#doctors" role="tab">Doctors</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="appointments-tab" data-toggle="tab" href="#appointments" role="tab">Appointments</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="statistics-tab" data-toggle="tab" href="#statistics" role="tab">Detailed Statistics</a>
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
                        <table class="table table-bordered" id="patientsTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Date of Birth</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Mohammed Alami</td>
                                    <td>m.alami@example.com</td>
                                    <td>+212 612-345678</td>
                                    <td>1985-07-15</td>
                                    <td>
                                        <button class="btn btn-info btn-sm editPatientBtn" 
                                                data-id="1"
                                                data-name="Mohammed Alami"
                                                data-email="m.alami@example.com"
                                                data-phone="+212 612-345678"
                                                data-dob="1985-07-15"
                                                data-toggle="modal" 
                                                data-target="#editPatientModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm deletePatientBtn" 
                                                data-id="1"
                                                data-toggle="modal" 
                                                data-target="#deletePatientModal">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Fatima Zahra</td>
                                    <td>f.zahra@example.com</td>
                                    <td>+212 623-456789</td>
                                    <td>1990-03-22</td>
                                    <td>
                                        <button class="btn btn-info btn-sm editPatientBtn" 
                                                data-id="2"
                                                data-name="Fatima Zahra"
                                                data-email="f.zahra@example.com"
                                                data-phone="+212 623-456789"
                                                data-dob="1990-03-22"
                                                data-toggle="modal" 
                                                data-target="#editPatientModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm deletePatientBtn" 
                                                data-id="2"
                                                data-toggle="modal" 
                                                data-target="#deletePatientModal">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Karim Benali</td>
                                    <td>k.benali@example.com</td>
                                    <td>+212 634-567890</td>
                                    <td>1978-11-08</td>
                                    <td>
                                        <button class="btn btn-info btn-sm editPatientBtn" 
                                                data-id="3"
                                                data-name="Karim Benali"
                                                data-email="k.benali@example.com"
                                                data-phone="+212 634-567890"
                                                data-dob="1978-11-08"
                                                data-toggle="modal" 
                                                data-target="#editPatientModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm deletePatientBtn" 
                                                data-id="3"
                                                data-toggle="modal" 
                                                data-target="#deletePatientModal">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Souad Moussaoui</td>
                                    <td>s.moussaoui@example.com</td>
                                    <td>+212 645-678901</td>
                                    <td>1992-05-17</td>
                                    <td>
                                        <button class="btn btn-info btn-sm editPatientBtn" 
                                                data-id="4"
                                                data-name="Souad Moussaoui"
                                                data-email="s.moussaoui@example.com"
                                                data-phone="+212 645-678901"
                                                data-dob="1992-05-17"
                                                data-toggle="modal" 
                                                data-target="#editPatientModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm deletePatientBtn" 
                                                data-id="4"
                                                data-toggle="modal" 
                                                data-target="#deletePatientModal">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Younes El Amrani</td>
                                    <td>y.elamrani@example.com</td>
                                    <td>+212 656-789012</td>
                                    <td>1983-09-30</td>
                                    <td>
                                        <button class="btn btn-info btn-sm editPatientBtn" 
                                                data-id="5"
                                                data-name="Younes El Amrani"
                                                data-email="y.elamrani@example.com"
                                                data-phone="+212 656-789012"
                                                data-dob="1983-09-30"
                                                data-toggle="modal" 
                                                data-target="#editPatientModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm deletePatientBtn" 
                                                data-id="5"
                                                data-toggle="modal" 
                                                data-target="#deletePatientModal">
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
        <div class="tab-pane fade" id="doctors" role="tabpanel">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Doctor Management</h6>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addDoctorModal">
                        <i class="fas fa-plus"></i> Add Doctor
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="doctorsTable" width="100%" cellspacing="0">
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
                                        <button class="btn btn-info btn-sm editDoctorBtn" 
                                                data-id="1"
                                                data-name="Dr. Ahmed Lahlou"
                                                data-specialty="Cardiology"
                                                data-email="a.lahlou@example.com"
                                                data-phone="+212 661-234567"
                                                data-toggle="modal" 
                                                data-target="#editDoctorModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm deleteDoctorBtn" 
                                                data-id="1"
                                                data-toggle="modal" 
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
                                        <button class="btn btn-info btn-sm editDoctorBtn" 
                                                data-id="2"
                                                data-name="Dr. Leila Bouzidi"
                                                data-specialty="Pediatrics"
                                                data-email="l.bouzidi@example.com"
                                                data-phone="+212 667-345678"
                                                data-toggle="modal" 
                                                data-target="#editDoctorModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm deleteDoctorBtn" 
                                                data-id="2"
                                                data-toggle="modal" 
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
                                        <button class="btn btn-info btn-sm editDoctorBtn" 
                                                data-id="3"
                                                data-name="Dr. Omar Tazi"
                                                data-specialty="Neurology"
                                                data-email="o.tazi@example.com"
                                                data-phone="+212 673-456789"
                                                data-toggle="modal" 
                                                data-target="#editDoctorModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm deleteDoctorBtn" 
                                                data-id="3"
                                                data-toggle="modal" 
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
                                        <button class="btn btn-info btn-sm editDoctorBtn" 
                                                data-id="4"
                                                data-name="Dr. Samira Chennaoui"
                                                data-specialty="Dermatology"
                                                data-email="s.chennaoui@example.com"
                                                data-phone="+212 684-567890"
                                                data-toggle="modal" 
                                                data-target="#editDoctorModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm deleteDoctorBtn" 
                                                data-id="4"
                                                data-toggle="modal" 
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
                        <table class="table table-bordered" id="appointmentsTable" width="100%" cellspacing="0">
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
                                                data-id="1"
                                                data-patient="1"
                                                data-doctor="1"
                                                data-date="2025-03-25"
                                                data-time="09:30"
                                                data-status="confirmed"
                                                data-toggle="modal" 
                                                data-target="#editAppointmentModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm deleteAppointmentBtn" 
                                                data-id="1"
                                                data-toggle="modal" 
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
                                                data-id="2"
                                                data-patient="2"
                                                data-doctor="2"
                                                data-date="2025-03-25"
                                                data-time="11:00"
                                                data-status="confirmed"
                                                data-toggle="modal" 
                                                data-target="#editAppointmentModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm deleteAppointmentBtn" 
                                                data-id="2"
                                                data-toggle="modal" 
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
                                                data-id="3"
                                                data-patient="3"
                                                data-doctor="3"
                                                data-date="2025-03-26"
                                                data-time="10:15"
                                                data-status="pending"
                                                data-toggle="modal" 
                                                data-target="#editAppointmentModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm deleteAppointmentBtn" 
                                                data-id="3"
                                                data-toggle="modal" 
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
                                                data-id="4"
                                                data-patient="4"
                                                data-doctor="4"
                                                data-date="2025-03-26"
                                                data-time="14:45"
                                                data-status="pending"
                                                data-toggle="modal" 
                                                data-target="#editAppointmentModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm deleteAppointmentBtn" 
                                                data-id="4"
                                                data-toggle="modal" 
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
                                                data-id="5"
                                                data-patient="5"
                                                data-doctor="1"
                                                data-date="2025-03-27"
                                                data-time="10:30"
                                                data-status="pending"
                                                data-toggle="modal" 
                                                data-target="#editAppointmentModal">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm deleteAppointmentBtn" 
                                                data-id="5"
                                                data-toggle="modal" 
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
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 92%" aria-valuenow="92" aria-valuemin="0" aria-valuemax="100">92%</div>
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
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 89%" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100">89%</div>
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
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">85%</div>
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
                                                    <div class="progress-bar bg-info" role="progressbar" style="width: 78%" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100">78%</div>
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
                        <input type="text" class="form-control" id="edit_doctor_name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Specialty</label>
                        <select class="form-control" id="edit_doctor_specialty" name="specialty" required>
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
                        <input type="email" class="form-control" id="edit_doctor_email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="tel" class="form-control" id="edit_doctor_phone" name="phone" required>
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
                    <p>Are you sure you want to delete this doctor? This action cannot be undone and will also remove all associated appointments.</p>
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
                        <input type="text" class="form-control" id="edit_patient_name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" id="edit_patient_email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="tel" class="form-control" id="edit_patient_phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label>Date of Birth</label>
                        <input type="date" class="form-control" id="edit_patient_dob" name="dob" required>
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
                        <select class="form-control" id="edit_appointment_patient" name="patient_id" required>
                            <option value="1">Mohammed Alami</option>
                            <option value="2">Fatima Zahra</option>
                            <option value="3">Karim Benali</option>
                            <option value="4">Souad Moussaoui</option>
                            <option value="5">Younes El Amrani</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Doctor</label>
                        <select class="form-control" id="edit_appointment_doctor" name="doctor_id" required>
                            <option value="1">Dr. Ahmed Lahlou (Cardiology)</option>
                            <option value="2">Dr. Leila Bouzidi (Pediatrics)</option>
                            <option value="3">Dr. Omar Tazi (Neurology)</option>
                            <option value="4">Dr. Samira Chennaoui (Dermatology)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" class="form-control" id="edit_appointment_date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label>Time</label>
                        <input type="time" class="form-control" id="edit_appointment_time" name="time" required>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control" id="edit_appointment_status" name="status" required>
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
                    <p>Are you sure you want to delete this appointment? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Appointment</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
        editPatientBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.getElementById('edit_patient_id').value = this.getAttribute('data-id');
                document.getElementById('edit_patient_name').value = this.getAttribute('data-name');
                document.getElementById('edit_patient_email').value = this.getAttribute('data-email');
                document.getElementById('edit_patient_phone').value = this.getAttribute('data-phone');
                document.getElementById('edit_patient_dob').value = this.getAttribute('data-dob');
                document.getElementById('editPatientForm').setAttribute('action', '/patients/' + this.getAttribute('data-id'));
            });
        });

        const deletePatientBtns = document.querySelectorAll('.deletePatientBtn');
        deletePatientBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.getElementById('delete_patient_id').value = this.getAttribute('data-id');
                document.getElementById('deletePatientForm').setAttribute('action', '/patients/' + this.getAttribute('data-id'));
            });
        });
=
        const editDoctorBtns = document.querySelectorAll('.editDoctorBtn');
        editDoctorBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.getElementById('edit_doctor_id').value = this.getAttribute('data-id');
                document.getElementById('edit_doctor_name').value = this.getAttribute('data-name');
                document.getElementById('edit_doctor_specialty').value = this.getAttribute('data-specialty');
                document.getElementById('edit_doctor_email').value = this.getAttribute('data-email');
                document.getElementById('edit_doctor_phone').value = this.getAttribute('data-phone');
                document.getElementById('editDoctorForm').setAttribute('action', '/doctors/' + this.getAttribute('data-id'));
            });
        });

        const deleteDoctorBtns = document.querySelectorAll('.deleteDoctorBtn');
        deleteDoctorBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.getElementById('delete_doctor_id').value = this.getAttribute('data-id');
                document.getElementById('deleteDoctorForm').setAttribute('action', '/doctors/' + this.getAttribute('data-id'));
            });
        });
=
        const editAppointmentBtns = document.querySelectorAll('.editAppointmentBtn');
        editAppointmentBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
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
        deleteAppointmentBtns.forEach(function(btn) {
            btn.addEventListener('click', function() {
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
@endsection