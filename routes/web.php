<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ProfileController;
use App\Jobs\SendMessage;
use Illuminate\Support\Facades\Route;

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
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/dashboard/doctors/{id}', [DashboardController::class, 'showDoctor']);
    Route::get('/dashboard/patients', [DashboardController::class, 'showpatients']);
    Route::post('/dashboard/doctors', [DashboardController::class, 'storeDoctor']);
    Route::put('/dashboard/doctors/{id}', [DashboardController::class, 'updateDoctor']);
    Route::delete('/dashboard/doctors/{id}', [DashboardController::class, 'destroyDoctor']);
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
// SendMessage::dispatch('Hello, this is a test message!')->delay(now()->addMinutes(1));
// SendMessage::dispatch('test')->delay(now()->addMinutes(1));