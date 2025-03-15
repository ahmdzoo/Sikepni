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
use App\Http\Controllers\KordinatorController;
use App\Http\Controllers\LamaranController;
use App\Http\Controllers\LaporanAkhirController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MitraController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginRegController;
use App\Http\Controllers\MitraAdminController;
use App\Http\Controllers\RegLoginController;


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
Route::get('/homepage/landing-page', [homepageController::class, 'show_homepage'])->name('homepage.landing-page');
Route::get('/mitra-kerjasama', [homepageController::class, 'show_moa'])->name('homepage.moa');
Route::get('/mou', [homepageController::class, 'show_mou'])->name('homepage.mou');
Route::get('/ia', [homepageController::class, 'show_ia'])->name('homepage.ia');


#ROUTE LOGIN BARU
Route::get('/login', [LoginRegController::class, 'showLogin'])->name('loginReg');
Route::post('/login', [LoginRegController::class, 'loginReg']);
Route::post('/logout', [LoginRegController::class, 'logout'])->name('logout');

#ROUTE REGISTRASI BARU
Route::get('/register', [RegLoginController::class, 'showRegistration'])->name('regLogin');
Route::post('/register', [RegLoginController::class, 'regLogin']);
Route::post('/password/update', [UserController::class, 'updatePassword'])->name('password.update');


// Rute untuk Mahasiswa
Route::group(['middleware' => ['auth', 'role:mahasiswa']], function () {
    Route::get('/mahasiswa/dashboard', [MahasiswaController::class, 'dashboard'])->name('mhs.dashboard');
    Route::middleware(['auth'])->group(function () {
        Route::get('/mahasiswa/lowongan', [LamaranController::class, 'index'])->name('lamaran.index');
        Route::post('/mahasiswa/lamaran', [LamaranController::class, 'store'])->name('lamaran.store');
    });
    Route::get('/mahasiswa/lowongan_magang', [MahasiswaController::class, 'showMitra'])->name('mhs_lowongan');
    // Mengajukan lamaran
    Route::get('/mahasiswa/status_pengajuan', [LamaranController::class, 'statusLamaranMahasiswa'])->name('mahasiswa.status_lamaran');

    Route::get('/mahasiswa/laporan', [LaporanController::class, 'mahasiswaAktifitas'])->name('mahasiswa.aktifitas');
    Route::post('/mahasiswa/laporan', [LaporanController::class, 'store'])->name('laporan.store');
    Route::get('/laporan/{id}/edit', [LaporanController::class, 'edit'])->name('laporan.edit');
    Route::put('/laporan/{id}', [LaporanController::class, 'update'])->name('laporan.update');
    Route::delete('/laporan/{id}', [LaporanController::class, 'destroy'])->name('laporan.destroy');
    Route::get('mahasiswa/aktifitas_magang', [LaporanController::class, 'magang'])->name('mahasiswa.magang');

    Route::get('/mahasiswa/LaporanAkhir', [LaporanAkhirController::class, 'mhsLaporanAkhir'])->name('mahasiswa.LaporanAkhir');
    Route::post('/LaporanAkhir', [LaporanAkhirController::class, 'store'])->name('LaporanAkhir.store');
    Route::get('/LaporanAkhir/{id}/edit', [LaporanAkhirController::class, 'edit'])->name('LaporanAkhir.edit');
    Route::put('/LaporanAkhir/{id}', [LaporanAkhirController::class, 'update'])->name('LaporanAkhir.update');
    Route::delete('/LaporanAkhir/{id}', [LaporanAkhirController::class, 'destroy'])->name('LaporanAkhir.destroy');
});

// Rute untuk Dosen Pembimbing
Route::group(['middleware' => ['auth', 'role:dosen_pembimbing']], function () {
    Route::get('/dosen/dashboard', [DosenPembimbingController::class, 'dashboard'])->name('dosen.dashboard');
    Route::get('/dosen/pengajuan_magang', [DosenPembimbingController::class, 'dosen_lamaran'])->name('dosen_lamaran');
    Route::get('/dosen/dosen_laporan', [LaporanController::class, 'dosenLaporan'])->name('dosen.laporan');
    Route::get('/dosen/mahasiswa_magang', [LaporanController::class, 'magang_mhs'])->name('dosen.magang_mhs');
    Route::get('/dosen/dosen_laporan/{mahasiswa_id}', [LaporanController::class, 'dosenLaporan'])->name('dosen.laporan');
    Route::get('/dosen/dosen_LaporanAkhir/{mahasiswa_id}', [LaporanAkhirController::class, 'dosenLaporanAkhir'])->name('dosen.LaporanAkhir');
    Route::get('/dosen/daftar_mitra', [DosenPembimbingController::class, 'showMitra'])->name('mitra_lowongan');
});

// Rute untuk Mitra Magang
Route::group(['middleware' => ['auth', 'role:mitra_magang']], function () {
    Route::get('/mitra/dashboard', [MitraMagangController::class, 'dashboard'])->name('mitra.dashboard');
    Route::get('/mitra/pengajuan_magang', [MitraMagangController::class, 'mitra_lamaran'])->name('mitra_lamaran');
    Route::get('/mitra/pengajuan_magang', [LamaranController::class, 'index'])->name('mitra_lamaran');
    Route::post('/lamaran/{id}/acc', [LamaranController::class, 'accLamaran'])->name('lamaran.acc');
    Route::post('/lamaran/{id}/tolak', [LamaranController::class, 'tolakLamaran'])->name('lamaran.tolak');
    Route::post('/lamaran/acc/{id}', [LamaranController::class, 'acc'])->name('lamaran.acc');
    Route::get('/mitra/mahasiswa_magang', [LaporanController::class, 'mahasiswaDiterima'])->name('mitra.mahasiswa_diterima');
    Route::get('/mitra/laporan/{mahasiswa_id}', [LaporanController::class, 'mitraLaporan'])->name('mitra.laporan');
    Route::get('/mitra/LaporanAkhir/{mahasiswa_id}', [LaporanAkhirController::class, 'mitraLaporanAkhir'])->name('mitra.LaporanAkhir');

    Route::get('/mitra/info_kerjasama', [MitraAdminController::class, 'mitra_admin'])->name('mitra_admin');
    Route::put('/mitra/{id}', [MitraAdminController::class, 'update'])->name('mitra.mitra.update');
    Route::post('/mitra/mitra/store', [MitraAdminController::class, 'store'])->name('mitra.mitra.store');
    Route::get('/mitra/mitra/create', [MitraAdminController::class, 'create'])->name('mitra.mitra.create');

    Route::post('/mitra/laporan/{id}/nilai', [LaporanController::class, 'updateNilai'])->name('mitra.laporan.nilai');
    Route::post('/mitra/laporanAkhir/{id}/nilai', [LaporanAkhirController::class, 'updateNilai'])->name('mitra.laporanAkhir.nilai');


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

    Route::get('/admin/mahasiswa_magang/{mitra_id}', [LaporanController::class, 'admin_mhs'])->name('admin_mhs');
    Route::get('/admin/laporan/{mahasiswa_id}', [LaporanController::class, 'adminLaporan'])->name('admin.laporan');
    Route::get('/admin/LaporanAkhir/{mahasiswa_id}', [LaporanAkhirController::class, 'adminLaporanAkhir'])->name('admin.LaporanAkhir');
    Route::get('/admin/laporan_magang', [LaporanController::class, 'admin_magang'])->name('admin.admin_magang');

    Route::get('/admin/data_dosen', [AdminController::class, 'data_dosen'])->name('data_dosen');
    Route::post('/admin/assign_dosen', [AdminController::class, 'assignDosen'])->name('assign_dosen');
});

// Rute untuk Kordinator
Route::group(['middleware' => ['auth', 'role:kordinator']], function () {

    // Tampilan manajemen data
    Route::get('/kordinator/dashboard', [KordinatorController::class, 'dashboard'])->name('kordinator.dashboard');
    Route::get('/kordinator/data_mitra', [KordinatorController::class, 'data_mitra'])->name('kordinator.data_mitra');
    Route::get('/kordinator/data_user', [KordinatorController::class, 'data_user'])->name('kordinator.data_user');
    Route::get('/kordinator/jurusan', [KordinatorController::class, 'jurusan'])->name('kordinator.jurusan');

    Route::post('/kordinator/user/store', [KordinatorController::class, 'storeUser'])->name('kordinator.store_user');

    // Rute untuk Mitra
    Route::post('/kordinator/mitra/store', [KordinatorController::class, 'store'])->name('kordinator.store_mitra');
    Route::get('/kordinator/mitra/create', [KordinatorController::class, 'create'])->name('kordinator.mitra.create');
    Route::get('/kordinator/mitra/{mitra}/edit', [KordinatorController::class, 'edit'])->name('kordinator.mitra.edit');
    Route::put('/kordinator/mitra/{mitra}', [KordinatorController::class, 'update'])->name('kordinator.mitra.update');
    Route::delete('/kordinator/mitra/{mitra}', [KordinatorController::class, 'deleteMitra'])->name('kordinator.mitra.destroy');
    Route::put('/kordinator/mitra/{mitra}/approve', [KordinatorController::class, 'approve'])->name('kordinator.mitra.approve');


    // Rute untuk manajemen user
    Route::get('/kordinator/users/{id}', [KordinatorController::class, 'editUser'])->name('kordinator.edit_user');
    Route::put('/kordinator/users/{id}', [KordinatorController::class, 'updateUser'])->name('kordinator.update_user');
    Route::delete('/kordinator/users/{id}', [KordinatorController::class, 'deleteUser'])->name('kordinator.delete_user');

    // Rute untuk Menyimpan Jurusan
    Route::post('/kordinator/jurusan/store', [KordinatorController::class, 'storeJurusan'])->name('kordinator.jurusan.store');

    // Rute untuk Edit Jurusan
    Route::get('/kordinator/jurusan/{jurusan}', [KordinatorController::class, 'editJurusan'])->name('kordinator.jurusan.edit');
    Route::put('/kordinator/jurusan/{jurusan}', [KordinatorController::class, 'updateJurusan'])->name('kordinator.jurusan.update');
    Route::delete('/kordinator/jurusan/{jurusan}', [KordinatorController::class, 'deleteJurusan'])->name('kordinator.jurusan.destroy');

    Route::get('/kordinator/mahasiswa_magang/{mitra_id}', [KordinatorController::class, 'kordinator_mhs'])->name('kordinator.kordinator_mhs');
    Route::get('/kordinator/laporan/{mahasiswa_id}', [KordinatorController::class, 'kordinatorLaporan'])->name('kordinator.laporan');
    Route::get('/kordinator/LaporanAkhir/{mahasiswa_id}', [KordinatorController::class, 'kordinatorLaporanAkhir'])->name('kordinator.LaporanAkhir');
    Route::get('/kordinator/laporan_magang', [KordinatorController::class, 'kordinator_magang'])->name('kordinator.admin_magang');

    Route::get('/kordinator/data_dosen', [KordinatorController::class, 'data_dosen'])->name('kordinator.data_dosen');
    Route::post('/kordinator/assign_dosen', [KordinatorController::class, 'assignDosen'])->name('kordinator.assign_dosen');
});


Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');


Route::resource('mitras', MitraMagangController::class);



Route::get('/admin/mitra/data', [MitraController::class, 'getData'])->name('mitra.data');
Route::get('/Mitra_Kerjasama', [MitraController::class, 'index'])->name('moa.index');
Route::get('/moa/data', [MitraController::class, 'getData'])->name('mitra.data');

//COMMENT LAPORAN MAGANG
Route::post('/laporan/{laporanId}/komentar', [LaporanController::class, 'storeKomentar'])->name('laporan.komentar.store');
Route::delete('/laporan/{laporan}/komentar/{komentar}', [LaporanController::class, 'destroyKomentar'])->name('laporan.komentar.destroy');

//COMMENT LAPORAN MAGANG AKHIR
Route::post('/LaporanAkhir/{LaporanAkhirId}/komentar', [LaporanAkhirController::class, 'storeKomentar'])->name('LaporanAkhir.komentar.store');
Route::delete('/LaporanAkhir/{LaporanAkhir}/komentar/{komentar}', [LaporanAkhirController::class, 'destroyKomentar'])->name('LaporanAkhir.komentar.destroy');
