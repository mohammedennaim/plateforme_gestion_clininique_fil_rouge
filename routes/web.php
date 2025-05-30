<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripePaymentController;
use App\Jobs\SendMessage;
use App\Models\Appointment;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\DossierMedicalController;
use App\Http\Controllers\MedicalRecordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class ,'welcome'])->name('welcome');
Route::get('/about', [HomeController::class ,'about'])->name('about');
Route::get('/contact', [HomeController::class ,'contact'])->name('contact');
Route::get('/services', [HomeController::class ,'services'])->name('services');
Route::get('/doctors', [HomeController::class ,'doctors'])->name('doctors');

Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'store']);
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::post('/dashboard', [AdminController::class, 'storeAppointment']);
    Route::put('/dashboard/appointments/{id}', [AdminController::class, 'updateAppointment'])->name('appointment.update');

    
    // Route::get('/dashboard/doctors/{id}', [AdminController::class, 'showDoctor']);
    Route::put('/dashboard/doctors/{id}', [AdminController::class, 'updateDoctor']);
    Route::post('/dashboard/doctors', [AdminController::class, 'storeDoctor']);
    Route::delete('/dashboard/doctors/{id}', [AdminController::class, 'destroyDoctor']);
    Route::post('dashboard/doctors/{id}',[AdminController::class, 'updateStatus'])->name('doctors.change-status');
    
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
    Route::get('/patients/{id}', [AdminController::class, 'showPatient'])->name('patients.show');
    Route::get('/patients/{patient}/edit', [PatientController::class, 'edit'])->name('patients.edit');
    Route::put('/patients/{patient}', [PatientController::class, 'update'])->name('patients.update');
    Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])->name('patients.destroy');
    Route::get('/patients/stats', [PatientController::class, 'stats'])->name('patients.stats');
    
    Route::get('/doctors/show/{id}', [AdminController::class, 'showDoctor'])->name('doctors.show');
    Route::get('/doctor', [AdminController::class, 'createDoctor'])->name('doctors.create');
    Route::post('/doctor', [AdminController::class, 'storeDoctor'])->name('doctors.store');
    Route::get('/doctor/{id}', [AdminController::class, 'editDoctor'])->name('doctors.edit');
    Route::put('/doctor/{id}', [AdminController::class, 'updateDoctor'])->name('doctors.update');
    Route::delete('/doctor/{id}', [AdminController::class, 'destroyDoctor'])->name('doctors.destroy');
});

Route::prefix('doctor')->name('doctor.')->middleware(['auth', 'doctor'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DoctorController::class, 'index'])->name('dashboard');
    
    // Patients routes
    Route::get('/patients', [DoctorController::class, 'patients'])->name('patients');
    Route::get('/search/patients', [DoctorController::class, 'searchPatients'])->name('search.patients');
    Route::get('/patients/create', [DoctorController::class, 'createPatient'])->name('patients.create');
    Route::post('/patients/create', [DoctorController::class, 'storePatient'])->name('patients.store');
    Route::put('/patients/{id}', [DoctorController::class, 'updatePatient'])->name('patients.update');
    Route::get('/patients/{id}', [DoctorController::class, 'editPatient'])->name('patients.edit');
    
    // Appointments routes
    Route::get('/appointments/create/{doctor}', [DoctorController::class, 'createAppointment'])->name('appointments.create');
    Route::post('/appointments', [DoctorController::class, 'storeAppointment'])->name('appointments.store');
    Route::get('/appointments/{id}', [DoctorController::class, 'showAppointment'])->name('appointments.show');
    Route::get('/appointments/{id}/edit', [DoctorController::class, 'edit'])->name('appointments.edit');
    Route::put('/appointments/{id}', [DoctorController::class, 'updateAppointment'])->name('appointments.update');
    Route::get('/appointments/check/{id}', [DoctorController::class, 'checkInAppointment'])->name('appointments.check');
    Route::post('/appointments/{id}', [DoctorController::class, 'changeStatus'])->name('appointments.change-status');
    Route::delete('/appointments/{id}', [DoctorController::class, 'destroyAppointment'])->name('appointments.destroy');
    Route::post('/appointments/{id}/cancel', [DoctorController::class, 'cancelAppointment'])->name('appointments.cancel');
    

    Route::get('/patient/show/{id}', [DoctorController::class, 'showPatient'])->name('patients.show');
    // Profile routes

    // Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
    // Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');

    Route::get('/pending',[DoctorController::class, 'pending'])->name('pending');
});

Route::prefix('patient')->group(function () {
    Route::get('/reserver', [RendezVousController::class, 'create'])->name('patient.reserverSansAuth');
    Route::post('/reserver', [RendezVousController::class, 'store'])->name('patient.reserver.store');
    Route::prefix('payment')->group(function () {
        Route::get('/{patient}', [StripePaymentController::class, 'showPaymentPage'])->name('patient.payment');
        Route::get('/appointment/{appointment_id}', [StripePaymentController::class, 'showAppointmentDetails'])->name('payment.appointment-details');
        Route::post('/process', [StripePaymentController::class, 'processPayment'])->name('payment.process');
        Route::post('/confirm', [StripePaymentController::class, 'confirmPayment'])->name('payment.confirm');
        Route::post('/check-status', [StripePaymentController::class, 'checkPaymentStatus'])->name('payment.check-status');
        Route::get('/success', [StripePaymentController::class, 'showSuccessPage'])->name('payment.success');
    });
});


Route::get('/appointment/details/{appointment_id}', [RendezVousController::class, 'showAppointmentDetails'])->name('appointment.details');
Route::put('/appointment/cancel/{appointment_id}', [RendezVousController::class, 'cancelAppointment'])->name('appointment.cancel');
Route::get('/appointment/process-after-payment/{appointment_id}', [RendezVousController::class, 'processAfterPayment'])->name('appointment.process-after-payment');

Route::get('/home', function () {
    return view('home');
})->name('home')->middleware('auth');

// SendMessage::dispatch('Hello, this is a test message!')->delay(now()->addMinutes(1));

// Route::middleware('auth')->group(function () {
//     Route::resource('medical-records', MedicalRecordController::class);
//     Route::get('/medical-records/{id}/download', [MedicalRecordController::class, 'download'])->name('medical-records.download');
// });
// Route::prefix('patient')->group(function () {
//     Route::get('/appointment/{appointment_id}', [RendezVousController::class, 'showAppointmentDetails'])->name('patient.appointment.details');

//     Route::get('/dossiers', [DossierMedicalController::class, 'index'])->name('dossiers.index');
//     Route::get('/dossiers/{id}', [DossierMedicalController::class, 'show'])->name('dossiers.show');
//     Route::get('/dossiers/create', [DossierMedicalController::class, 'create'])->name('dossiers.create');
//     Route::post('/dossiers', [DossierMedicalController::class, 'store'])->name('dossiers.store');
//     Route::get('/dossiers/{id}/edit', [DossierMedicalController::class, 'edit'])->name('dossiers.edit');
//     Route::put('/dossiers/{id}', [DossierMedicalController::class, 'update'])->name('dossiers.update');
//     Route::delete('/dossiers/{id}', [DossierMedicalController::class, 'destroy'])->name('dossiers.destroy');
// })->middleware('patient');