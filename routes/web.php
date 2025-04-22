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

Route::prefix('auth')->group(function () {

    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'store']);
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Routes pour la réinitialisation de mot de passe
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::post('/dashboard', [AdminController::class, 'storeAppointment']);
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::get('/settings', [ProfileController::class, 'showSettings'])->name('settings');
    Route::put('/dashboard/appointments/{id}', [AdminController::class, 'updateAppointment'])->name('appointment.update');

    Route::get('/doctors/show', [AdminController::class, 'showDoctor'])->name('doctor.show');
    // Route::get('/patients/{id}', [AdminController::class, 'showpatient'])->name('patients.show');
    // Route::put('/patients/{id}', [AdminController::class, 'updatePatient'])->name('patients.edit');
    // Route::delete('/patients/{id}', [AdminController::class, 'deletePatient'])->name('patients.delete');

    Route::get('/dashboard/doctors/{id}', [AdminController::class, 'showDoctor']);
    Route::put('/dashboard/doctors/{id}', [AdminController::class, 'updateDoctor']);
    Route::post('/dashboard/doctors', [AdminController::class, 'storeDoctor']);
    Route::delete('/dashboard/doctors/{id}', [AdminController::class, 'destroyDoctor']);


    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
    Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('admin.patients.show');
    Route::get('/patients/{patient}/edit', [PatientController::class, 'edit'])->name('admin.patients.edit');
    Route::put('/patients/{patient}', [PatientController::class, 'update'])->name('patients.update');
    Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])->name('admin.patients.destroy');
    Route::get('/patients/stats', [PatientController::class, 'stats'])->name('patients.stats');

    Route::post('/doctors', [DoctorController::class, 'store'])->name('admin.doctors.store');
    Route::put('/doctors/{doctor}', [DoctorController::class, 'update'])->name('admin.doctors.update');
    Route::delete('/doctors/{doctor}', [DoctorController::class, 'destroy'])->name('admin.doctors.destroy');

    // Route::post('/patients', [PatientController::class, 'store'])->name('admin.patients.store');
    // Route::put('/patients/{patient}', [PatientController::class, 'update'])->name('admin.patients.update');
});

Route::prefix('doctor')->name('doctor.')->middleware(['auth', 'doctor'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DoctorController::class, 'index'])->name('dashboard');
    
    // Patients routes
    Route::get('/patients', [DoctorController::class, 'patients'])->name('patients');
    Route::get('/search/patients', [DoctorController::class, 'searchPatients'])->name('search.patients');
    Route::put('/patients/{id}', [DoctorController::class, 'updatePatient'])->name('patients.update');
    
    // Appointments routes
    Route::get('/appointments', [DoctorController::class, 'appointments'])->name('appointments');
    Route::get('/appointments/{id}', [DoctorController::class, 'showAppointment'])->name('doctor.appointments.show');
    Route::put('/appointments/{id}', [DoctorController::class, 'updateAppointment'])->name('appointments.update');
    Route::delete('/appointments/{id}',
     [DoctorController::class, 'destroyAppointment'])->name('appointments.destroy');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    
    // API Routes for tasks and appointments
    Route::post('/api/tasks/{id}/toggle', [DoctorController::class, 'toggleTask'])->name('tasks.toggle');
    Route::post('/api/tasks', [DoctorController::class, 'storeTask'])->name('tasks.store');
    Route::post('/api/appointments/{id}/cancel', [DoctorController::class, 'cancelAppointment'])->name('api.appointments.cancel');
});

Route::get('/home', function () {
    return view('home');
})->name('home')->middleware('auth');

Route::prefix('patient')->group(function () {

    Route::get('/reserver', [RendezVousController::class, 'create'])->name('patient.reserverSansAuth');
    Route::post('/reserver', [RendezVousController::class, 'store'])->name('patient.reserver.store');
    Route::get('/appointment/{appointment_id}', [RendezVousController::class, 'showAppointmentDetails'])->name('patient.appointment.details');

    Route::get('/dossiers', [DossierMedicalController::class, 'index'])->name('dossiers.index');
    Route::get('/dossiers/{id}', [DossierMedicalController::class, 'show'])->name('dossiers.show');
    Route::get('/dossiers/create', [DossierMedicalController::class, 'create'])->name('dossiers.create');
    Route::post('/dossiers', [DossierMedicalController::class, 'store'])->name('dossiers.store');
    Route::get('/dossiers/{id}/edit', [DossierMedicalController::class, 'edit'])->name('dossiers.edit');
    Route::put('/dossiers/{id}', [DossierMedicalController::class, 'update'])->name('dossiers.update');
    Route::delete('/dossiers/{id}', [DossierMedicalController::class, 'destroy'])->name('dossiers.destroy');
});

// Routes de paiement accessibles directement à la racine
Route::prefix('payment')->group(function () {
    Route::get('/{patient}', [StripePaymentController::class, 'showPaymentPage'])->name('patient.payment');
    Route::post('/process', [StripePaymentController::class, 'processPayment'])->name('payment.process');
    Route::post('/confirm', [StripePaymentController::class, 'confirmPayment'])->name('payment.confirm');
    Route::post('/check-status', [StripePaymentController::class, 'checkPaymentStatus'])->name('payment.check-status');
    Route::get('/success', [StripePaymentController::class, 'showSuccessPage'])->name('payment.success');
});

// Add Medical Records routes - accessible to all authenticated users
Route::middleware('auth')->group(function () {
    Route::resource('medical-records', MedicalRecordController::class);
    Route::get('/medical-records/{id}/download', [MedicalRecordController::class, 'download'])->name('medical-records.download');
});

// Stripe Payment Routes

// Appointment Details after payment
Route::get('/appointment/details/{appointment_id}', [RendezVousController::class, 'showAppointmentDetails'])->name('appointment.details');
Route::put('/appointment/cancel/{appointment_id}', [RendezVousController::class, 'cancelAppointment'])->name('appointment.cancel');
Route::get('/appointment/process-after-payment/{appointment_id}', [RendezVousController::class, 'processAfterPayment'])->name('appointment.process-after-payment');

SendMessage::dispatch('Hello, this is a test message!')->delay(now()->addMinutes(1));
