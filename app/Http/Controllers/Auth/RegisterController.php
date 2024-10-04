<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    // Menampilkan form registrasi
    public function showRegistrationForm()
    {
        return view('auth.register'); // Pastikan Anda memiliki view ini
    }

    // Proses registrasi
    public function register(Request $request)
    {
        // Validasi input
        $this->validator($request->all())->validate();

        // Buat pengguna baru
        $user = $this->create($request->all());

        // Login pengguna setelah registrasi
        auth()->login($user);

        // Flash pesan sukses
        return redirect()->route('login')->with('success', 'Akun Anda berhasil dibuat. Silahkan login.');
    }

    // Validasi input registrasi
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'], // Minimal panjang 6
            'role' => ['required', 'string'],
        ]);
    }

    // Buat pengguna baru
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'], // Menyimpan role
        ]);
    }
}
