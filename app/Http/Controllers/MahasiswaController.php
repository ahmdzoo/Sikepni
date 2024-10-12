<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InfoMitra; // Mengimpor model InfoMitra
use App\Models\Lamaran;   // Mengimpor model Lamaran
use Illuminate\Support\Facades\DB;
class MahasiswaController extends Controller
{
    // Menampilkan dashboard mahasiswa
    public function dashboard()
    {
        return view('mahasiswa.dashboard'); // Pastikan Anda memiliki view ini
    }

    // Menampilkan halaman dashboard mahasiswa lainnya jika diperlukan
    public function mhs_dashboard()
    {
        return view('mahasiswa.mhs_dashboard');
    }

    // Menampilkan daftar mitra magang

    // Menampilkan aktivitas mahasiswa
    public function mhs_aktifitas()
    {
        return view('mahasiswa.mhs_aktifitas');
    }

    public function mhs_lowongan()
    {
        return view('mahasiswa.mhs_lowongan');
    }    
    
}
