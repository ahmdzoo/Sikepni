<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\DosenPembimbingController;
use App\Http\Controllers\MitraMagangController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\homepageController;

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

#ROUTE HOMEPAGE
Route::get('/', function () {
    return view('homepage/landing-page');
});

#ROUTE LINK NAV
Route::get('/moa',[homepageController::class, 'show_moa'])->name('homepage.moa');
Route::get('/mou', [homepageController::class, 'show_mou'])->name('homepage.mou');
Route::get('/ia', [homepageController::class, 'show_ia'])->name('homepage.ia');

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
    
    Route::post('/admin/user/store', [AdminController::class, 'storeUser'])->name('store_user');
    // Route::post('/admin/user/update/{id}', [AdminController::class, 'updateUser'])->name('update_user');
    // Route::post('/admin/user/delete/{id}', [AdminController::class, 'deleteUser'])->name('delete_user');

    Route::get('/admin/users/{id}', [AdminController::class, 'editUser'])->name('edit_user');
    Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('update_user');
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('delete_user');

});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');