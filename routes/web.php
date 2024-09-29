<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenPembimbingController;
use App\Http\Controllers\MitraMagangController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;

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

#ROUTE REGISTRASI
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Rute untuk Mahasiswa
Route::group(['middleware' => ['auth', 'role:mahasiswa']], function () {
    Route::get('/mahasiswa/dashboard', [MahasiswaController::class, 'dashboard'])->name('dashboard');
    Route::get('/mahasiswa/mhs_lowongan', [MahasiswaController::class, 'mhs_lowongan'])->name('mhs_lowongan');
    Route::get('/mahasiswa/mhs_aktifitas', [MahasiswaController::class, 'mhs_aktifitas'])->name('mhs_aktifitas');
});

// Rute untuk Dosen Pembimbing
Route::group(['middleware' => ['auth', 'role:dosen_pembimbing']], function () {
    Route::get('/dosen/dashboard', [DosenPembimbingController::class, 'dashboard']);
});

// Rute untuk Mitra Magang
Route::group(['middleware' => ['auth', 'role:mitra_magang']], function () {
    Route::get('/mitra/dashboard', [MitraMagangController::class, 'dashboard']);
});

// Rute untuk Admin
Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/admin/data_mitra', [AdminController::class, 'data_mitra'])->name('data_mitra');
    Route::get('/admin/data_user', [AdminController::class, 'data_user'])->name('data_user');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');