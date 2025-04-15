<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StripePaymentController;
use App\Jobs\SendMessage;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\MedecinController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\DossierMedicalController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->group(function(){

    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'store']);
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
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

    // Patient routes
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
    Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('patients.show');
    Route::get('/patients/{patient}/edit', [PatientController::class, 'edit'])->name('patients.edit');
    Route::put('/patients/{patient}', [PatientController::class, 'update'])->name('patients.update');
    Route::delete('/patients/{patient}', [PatientController::class, 'destroy'])->name('admin.patients.destroy');
    Route::get('/patients/stats', [PatientController::class, 'stats'])->name('patients.stats');

    // Routes pour les médecins
    Route::post('/doctors', [DoctorController::class, 'store'])->name('admin.doctors.store');
    Route::put('/doctors/{doctor}', [DoctorController::class, 'update'])->name('admin.doctors.update');
    Route::delete('/doctors/{doctor}', [DoctorController::class, 'destroy'])->name('admin.doctors.destroy');
    
    // Routes pour les patients
    Route::post('/patients', [PatientController::class, 'store'])->name('admin.patients.store');
    Route::put('/patients/{patient}', [PatientController::class, 'update'])->name('admin.patients.update');
});

Route::prefix('doctor')->middleware(['auth', 'doctor'])->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'index'])->name('doctor.dashboard');
    Route::get('/dashboard/patients/{id}', [DoctorController::class, 'showPatient'])->name('doctor.showPatient');
    Route::put('/dashboard/patients/{id}', [DoctorController::class, 'updatePatient'])->name('doctor.updatePatient');
    Route::get('/dashboard/appointments/{id}', [DoctorController::class, 'showAppointment'])->name('doctor.showAppointment');
    Route::put('/dashboard/appointments/{id}', [DoctorController::class, 'updateAppointment'])->name('doctor.updateAppointment');
    Route::delete('/dashboard/appointments/{id}', [DoctorController::class, 'destroyAppointment'])->name('doctor.destroyAppointment');
    Route::get('/appointments', [DoctorController::class, 'appointments'])->name('doctor.appointments');
    Route::get('/patients', [DoctorController::class, 'patients'])->name('doctor.patients');
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('doctor.profile');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('doctor.profile.update');
    
    Route::get('/pending', function () {
        return view('doctor.pending');
    })->name('doctor.pending');
});
// Route::get('/doctor/pending', function () {
//     return view('doctor.pending');
// })->name('doctor.pending')->middleware('auth');
            
// Route::get('/admin/pending', function () {
//     return view('admin.pending');
// })->name('admin.pending')->middleware('auth');

Route::get('/home', function () {
    return view('home');
})->name('home')->middleware('auth');

Route::prefix('patient')->group(function ()  {
    
Route::get('/reserver', [RendezVousController::class, 'create'])->name('patient.reserverSansAuth');
Route::post('/reserver', [RendezVousController::class, 'store'])->name('patient.reserver.store');
Route::get('/payment', [RendezVousController::class, 'payment'])->name('patient.payment');
Route::get('/appointment/{appointment_id}', [RendezVousController::class, 'showAppointmentDetails'])->name('patient.appointment.details');

Route::get('/dossiers', [DossierMedicalController::class, 'index'])->name('dossiers.index');
Route::get('/dossiers/{id}', [DossierMedicalController::class, 'show'])->name('dossiers.show');
Route::get('/dossiers/create', [DossierMedicalController::class, 'create'])->name('dossiers.create');
Route::post('/dossiers', [DossierMedicalController::class, 'store'])->name('dossiers.store');
Route::post('/payment/process', [StripePaymentController::class, 'processPayment'])->name('payment.process');
Route::post('/payment/confirm', [StripePaymentController::class, 'confirmPayment'])->name('payment.confirm');
Route::post('/payment/check-status', [StripePaymentController::class, 'checkPaymentStatus'])->name('payment.check-status');
Route::get('/payment/success', [StripePaymentController::class, 'showSuccessPage'])->name('payment.success');
Route::get('/dossiers/{id}/edit', [DossierMedicalController::class, 'edit'])->name('dossiers.edit');
Route::put('/dossiers/{id}', [DossierMedicalController::class, 'update'])->name('dossiers.update');
Route::delete('/dossiers/{id}', [DossierMedicalController::class, 'destroy'])->name('dossiers.destroy');
});

// Stripe Payment Routes

// Appointment Details after payment
Route::get('/appointment/details/{appointment_id}', [RendezVousController::class, 'showAppointmentDetails'])->name('appointment.details');
Route::put('/appointment/cancel/{appointment_id}', [RendezVousController::class, 'cancelAppointment'])->name('appointment.cancel');
Route::get('/appointment/process-after-payment/{appointment_id}', [RendezVousController::class, 'processAfterPayment'])->name('appointment.process-after-payment');

SendMessage::dispatch('Hello, this is a test message!')->delay(now()->addMinutes(1));

// Route::prefix('patient')->middleware(['auth', 'check.role:patient'])->group(function () {
//     Route::get('/dashboard', [PatientController::class, 'index'])->name('patient.dashboard');
//     // ... autres routes patient ...
// });




// // Routes protégées
// Route::middleware('auth')->group(function () {
//     // Routes communes à tous les utilisateurs
//     Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
//     Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
    
//     // Routes Admin
//     Route::middleware('admin')->group(function () {
//         Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
//         Route::resource('/admin/medecins', MedecinController::class);
//         Route::resource('/admin/patients', PatientController::class);
//         Route::get('/admin/statistiques', [AdminController::class, 'statistiques'])->name('admin.statistiques');
//     });
    
//     // Routes Médecin
//     Route::middleware('medecin')->group(function () {
//         Route::get('/medecin/dashboard', [MedecinController::class, 'dashboard'])->name('medecin.dashboard');
//         Route::get('/medecin/planning', [MedecinController::class, 'planning'])->name('medecin.planning');
//         Route::put('/medecin/planning', [MedecinController::class, 'updatePlanning']);
//         Route::get('/medecin/rendez-vous', [RendezVousController::class, 'medecinIndex'])->name('medecin.rendez-vous');
//         Route::put('/rendez-vous/{id}/confirm', [RendezVousController::class, 'confirm'])->name('rendez-vous.confirm');
//         Route::put('/rendez-vous/{id}/cancel', [RendezVousController::class, 'cancel'])->name('rendez-vous.cancel');
//         Route::resource('/dossiers', DossierMedicalController::class);
//     });
    
//     // Routes Patient
//     Route::middleware('patient')->group(function () {
//         Route::get('/patient/dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard');
//         Route::resource('/patient/rendez-vous', RendezVousController::class)->only(['index', 'create', 'store', 'destroy']);
//         Route::get('/patient/dossiers', [DossierMedicalController::class, 'patientIndex'])->name('patient.dossiers');
//         Route::get('/patient/paiements', [PaiementController::class, 'index'])->name('patient.paiements');
//     });
// });
