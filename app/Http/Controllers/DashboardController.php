<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Mendapatkan pengguna yang sedang login

        // Mengambil data berdasarkan role
        switch ($user->role) {
            case 'mahasiswa':
                return view('mahasiswa.dashboard', compact('user')); // Mengarahkan ke view mahasiswa
            case 'dosen_pembimbing':
                return view('dosen.dashboard', compact('user')); // Mengarahkan ke view dosen
            case 'mitra_magang':
                return view('mitra.dashboard', compact('user')); // Mengarahkan ke view mitra
            case 'admin':
                return view('admin.dashboard', compact('user')); // Mengarahkan ke view admin
            default:
                return redirect()->route('home'); // Redirect jika role tidak dikenali
        }
    }
}
