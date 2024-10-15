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
        // Mendapatkan semua mitra untuk ditampilkan di view
        $mitras = Mitra::with('mitraUser')->get(); // Menggunakan eager loading untuk mendapatkan nama mitra

        return view('mahasiswa.mhs_lowongan', compact('mitras'));
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
