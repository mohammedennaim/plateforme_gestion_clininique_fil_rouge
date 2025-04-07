<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ProfileController;
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
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('auth.profile');
    Route::post('/profile', [ProfileController::class, 'storeProfile'])->name('auth.profile');
    Route::post('/register', [AuthController::class, 'store']);
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
});


Route::prefix('admin')->middleware('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index']);
    Route::post('/dashboard', [AdminController::class, 'storeAppointment']);
    
    Route::put('/dashboard/appointments/{id}', [AdminController::class, 'updateAppointment'])->name('admin.appointment.update');

    Route::get('/doctors/show', [AdminController::class, 'showDoctor'])->name('admin.doctor.show');
    Route::get('/dashboard/doctors/{id}', [AdminController::class, 'showDoctor']);
    Route::get('/dashboard/patients', [AdminController::class, 'showpatients']);
    Route::post('/dashboard/doctors', [AdminController::class, 'storeDoctor']);
    Route::put('/dashboard/doctors/{id}', [AdminController::class, 'updateDoctor']);
    Route::delete('/dashboard/doctors/{id}', [AdminController::class, 'destroyDoctor']);
})->middleware('auth');

Route::prefix('doctor')->middleware('doctor')->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'index'])->middleware('doctor')->middleware('auth')->name('doctor.dashboard');
});
Route::get('/doctor/pending', function () {
    return view('doctor.pending');
})->name('doctor.pending')->middleware('auth');
            
Route::get('/admin/pending', function () {
    return view('admin.pending');
})->name('admin.pending')->middleware('auth');

Route::get('/home', function () {
    return view('home');
})->name('home')->middleware('auth');

SendMessage::dispatch('Hello, this is a test message!')->delay(now()->addMinutes(1));




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
