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
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\LamaranController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\UserController;

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

// Route::get('/', function () {
//     return view('welcome');

// });

#ROUTE HOMEPAGE
Route::get('/', function () {
    return view('homepage/landing-page');

});

#ROUTE LINK NAV
Route::get('/moa', [homepageController::class, 'show_moa'])->name('homepage.moa');
Route::get('/mou', [homepageController::class, 'show_mou'])->name('homepage.mou');
Route::get('/ia', [homepageController::class, 'show_ia'])->name('homepage.ia');

#ROUTE REGISTRASI
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::post('/password/update', [UserController::class, 'updatePassword'])->name('password.update');



// Rute untuk Mahasiswa
Route::group(['middleware' => ['auth', 'role:mahasiswa']], function () {
    Route::get('/mahasiswa/dashboard', [MahasiswaController::class, 'dashboard'])->name('mhs.dashboard');
    Route::get('/mahasiswa/mhs_lowongan', [MahasiswaController::class, 'mhs_lowongan'])->name('mhs_lowongan');
    Route::get('/mahasiswa/mhs_aktifitas', [MahasiswaController::class, 'mhs_aktifitas'])->name('mhs_aktifitas');
    Route::get('/mahasiswa/mhs_lowongan', [LamaranController::class, 'index'])->name('mhs_lowongan');
    Route::middleware(['auth'])->group(function () {
        Route::get('/mahasiswa/lowongan', [LamaranController::class, 'index'])->name('lamaran.index');
        Route::post('/mahasiswa/lamaran', [LamaranController::class, 'store'])->name('lamaran.store');
    });
    Route::get('/mhs-lowongan', [MitraMagangController::class, 'showMitra'])->name('mhs_lowongan');
    // Mengajukan lamaran
});

// Rute untuk Dosen Pembimbing
Route::group(['middleware' => ['auth', 'role:dosen_pembimbing']], function () {
    Route::get('/dosen/dashboard', [DosenPembimbingController::class, 'dashboard'])->name('dosen.dashboard');
    Route::get('/dosen/dosen_lamaran', [DosenPembimbingController::class, 'dosen_lamaran'])->name('dosen_lamaran');
    Route::get('/dosen/dosen_laporan', [MitraMagangController::class, 'dosen_laporan'])->name('dosen_laporan');
});

// Rute untuk Mitra Magang
Route::group(['middleware' => ['auth', 'role:mitra_magang']], function () {
    Route::get('/mitra/dashboard', [MitraMagangController::class, 'dashboard'])->name('mitra.dashboard');
    Route::get('/mitra/mitra_lamaran', [MitraMagangController::class, 'mitra_lamaran'])->name('mitra_lamaran');
    Route::get('/mitra/mitra_laporan', [MitraMagangController::class, 'mitra_laporan'])->name('mitra_laporan');
    Route::get('/mitra/lamarans', [LamaranController::class, 'index'])->name('mitra_lamaran');
});


// Rute untuk Admin
Route::group(['middleware' => ['auth', 'role:admin']], function () {

    // Tampilan manajemen data
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/data_mitra', [MitraMagangController::class, 'data_mitra'])->name('data_mitra');
    Route::get('/admin/data_user', [AdminController::class, 'data_user'])->name('data_user');
    Route::get('/admin/jurusan', [JurusanController::class, 'jurusan'])->name('jurusan');

    Route::post('/admin/user/store', [AdminController::class, 'storeUser'])->name('store_user');

    // Rute untuk Mitra
    Route::post('/admin/mitra/store', [MitraMagangController::class, 'store'])->name('store_mitra');
    Route::get('/admin/mitra/create', [MitraMagangController::class, 'create'])->name('mitra.create');
    Route::get('/admin/mitra/{mitra}/edit', [MitraMagangController::class, 'edit'])->name('mitra.edit');
    Route::put('/admin/mitra/{mitra}', [MitraMagangController::class, 'update'])->name('mitra.update');
    Route::delete('/admin/mitra/{mitra}', [MitraMagangController::class, 'deleteMitra'])->name('mitra.destroy');


    // Rute untuk manajemen user
    Route::get('/admin/users/{id}', [AdminController::class, 'editUser'])->name('edit_user');
    Route::put('/admin/users/{id}', [AdminController::class, 'updateUser'])->name('update_user');
    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])->name('delete_user');

    // Rute untuk Menyimpan Jurusan
    Route::post('/admin/jurusan/store', [JurusanController::class, 'storeJurusan'])->name('jurusan.store');

    // Rute untuk Edit Jurusan
    Route::get('/admin/jurusan/{jurusan}', [JurusanController::class, 'editJurusan'])->name('jurusan.edit');
    Route::put('/admin/jurusan/{jurusan}', [JurusanController::class, 'updateJurusan'])->name('jurusan.update');
    Route::delete('/admin/jurusan/{jurusan}', [JurusanController::class, 'deleteJurusan'])->name('jurusan.destroy');

});



Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::resource('mitras', MitraMagangController::class);



Route::get('/admin/mitra/data', [MitraController::class, 'getData'])->name('mitra.data');
Route::get('/moa', [MitraController::class, 'index'])->name('moa.index');
Route::get('/moa/data', [MitraController::class, 'getData'])->name('mitra.data');