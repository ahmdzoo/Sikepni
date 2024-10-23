<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginRegController extends Controller
{
    // Tampilan Login
    public function ShowLogin()
    {
        return view('auth.loginReg');
    }

    // Proses login
    public function loginReg(Request $request)
    {
        // dd($request->all());
        // Validasi Input
        $credentials = $request->validate([
            'email'     => 'required|email',
            'password'  => 'required',
        ], [
            'email.required'    => 'Email tidak boleh kosong.',
            'email.email'       => 'Format email tidak sesuai.',
            'password.required' => 'Kata sandi tidak boleh kosong.',
        ]);

        // Percobaan Login
        if (Auth::attempt($credentials)) {
            // Jika berhasil, redirect ke halaman dashboard
            return redirect()->intended('dashboard');
        }

            // Pesan jika terjadi kesalahan
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('loginReg');
    }
}
