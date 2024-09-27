<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        return view('mahasiswa.dashboard'); // Pastikan Anda memiliki view ini
    }

    public function mhs_dashboard()
    {
        // Logika untuk admin dashboard
        return view('mhs.mhs_dashboard');
    }

    public function mhs_lowongan()
    {
        // Logika untuk data mitra
        return view('mhs.mhs_lowongan');
    }

    public function mhs_aktifitas()
    {
        // Logika untuk data user
        return view('mhs.mhs_aktifitas');
    }
}
