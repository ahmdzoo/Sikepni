<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class RegLoginController extends Controller
{
    // Tampilan Regis
    public function ShowRegistration()
    {
        $jurusans = Jurusan::all(); // Ambil semua data jurusan
        return view('auth.regLogin', compact('jurusans'));
    }

    // Proses Registrasi
    public function regLogin(Request $request)
    {
        // Menambahkan role default sebagai mahasiswa
        $request->merge(['role' => 'mahasiswa']); // Set default role jadi mahasiswa

        // Validasi input
        $this->validator($request->all())->validate();

        // Create Pengguna baru
        $user = $this->create($request->all());

        // Login pengguna setelah selesai registrasi
        auth()->login($user);

        // Flash pesan sukses
        return redirect()->route('loginReg')->with('success', 'Akun anda berhasil dibuat.');
    }

    // Validasi input registrasi
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'      => ['required', 'string', 'max:255', 'not_regex:/[<>{}]/'], // Mencegah simbol tertentu
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'string', 'min:6', 'confirmed', 'not_regex:/[<>{}]/'], // Mencegah simbol tertentu
            'jurusan'   => 'required|string|max:255', // Validasi jurusan hanya untuk mahasiswa
            'nim'       => 'required|numeric|unique:users,nim', // Validasi NIM hanya untuk mahasiswa
        ], [
            'name.not_regex' => 'Nama tidak boleh mengandung karakter khusus seperti <, >, {, atau }.',
            'password.not_regex' => 'Kata sandi tidak boleh mengandung karakter khusus seperti <, >, {, atau }.',
        ]);
    }

    // Create Pengguna baru
    protected function create(array $data)
    {
        return User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'role'      => 'mahasiswa', // Set default role to "mahasiswa"
            'jurusan'   => $data['jurusan'], // Menambahkan jurusan
            'nim'       => $data['nim'], // Menambahkan nim
        ]);
    }
}
