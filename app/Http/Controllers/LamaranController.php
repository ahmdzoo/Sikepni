<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lamaran;
use App\Models\Mitra;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LamaranController extends Controller
{
    public function index()
    {
        // Ambil data mitra berdasarkan nama_mitra_id yang sesuai dengan user_id yang login
        $mitra = Mitra::where('nama_mitra_id', Auth::user()->id)->first(); // Ganti 'user_id' dengan 'nama_mitra_id'

        // Cek apakah mitra ditemukan
        if ($mitra) {
            // Ambil semua lamaran yang terkait dengan mitra_id tersebut
            $lamarans = Lamaran::where('mitra_id', $mitra->id)->get();
        } else {
            // Jika mitra tidak ditemukan, set lamarans sebagai koleksi kosong
            $lamarans = collect(); // Membuat Collection kosong
        }

        // Kembalikan ke view 'mitra.mitra_lamaran'
        return view('mitra.mitra_lamaran', compact('lamarans'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'mitra_id' => 'required|exists:mitras,id',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Simpan file CV ke dalam folder public/cv
        $cvPath = $request->file('cv')->store('cv', 'public'); // Menggunakan 'public' disk

        // Simpan data lamaran
        Lamaran::create([
            'user_id' => auth()->id(), // Mengambil user_id dari pengguna yang sedang login
            'mitra_id' => $request->mitra_id,
            'cv_path' => 'cv/' . basename($cvPath), // Menyimpan path relatif file CV
        ]);

        // Redirect ke halaman lowongan dengan pesan sukses
        return redirect()->route('mhs_lowongan')->with('success', 'Lamaran berhasil diajukan.');
    }
}
