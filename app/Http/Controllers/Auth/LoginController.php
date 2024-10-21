<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('auth.login'); // Ganti dengan view yang sesuai
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input dengan pesan kesalahan kustom
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email tidak boleh kosong.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Kata sandi tidak boleh kosong.',
        ]);

        if (Auth::attempt($credentials)) {
            // Dapatkan pengguna yang sedang login
            $user = Auth::user();
        
            // Redirect berdasarkan peran pengguna
            switch ($user->role) {
                case 'admin':
                    return redirect()->intended('admin/dashboard'); // Rute untuk admin
                case 'mahasiswa':
                    return redirect()->intended('mahasiswa/dashboard'); // Rute untuk mahasiswa
                case 'mitra_magang':
                    return redirect()->intended('mitra/dashboard'); // Rute untuk mitra
                case 'dosen_pembimbing':
                    return redirect()->intended('dosen/dashboard'); // Rute untuk dosen
                default:
                    return redirect()->intended('default/dashboard'); // Rute default jika peran tidak dikenali
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.', // Pesan kesalahan
        ])->withInput($request->only('email'));
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
