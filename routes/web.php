<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
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
    Route::post('/register', [AuthController::class, 'store']);
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
});


Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/dashboard/doctors/{id}', [DashboardController::class, 'showDoctor']);
    Route::post('/dashboard/doctors', [DashboardController::class, 'storeDoctor']);
    Route::put('/dashboard/doctors/{id}', [DashboardController::class, 'updateDoctor']);
    Route::delete('/dashboard/doctors/{id}', [DashboardController::class, 'destroyDoctor']);
})->middleware('auth');
Route::get('/home', function () {
    return view('home');
})->name('home')->middleware('auth');