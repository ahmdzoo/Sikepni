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

        // Coba untuk login
        if (Auth::attempt($credentials)) {
            // Jika berhasil, redirect ke halaman yang diinginkan
            return redirect()->intended('dashboard'); // Ganti 'dashboard' dengan rute yang sesuai
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
