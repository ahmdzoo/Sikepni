<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lamaran;
use App\Models\Mitra;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


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
        $cvPath = $request->file('cv')->store('cv', 'public'); // Menyimpan file di public/storage/cv


        // Simpan data lamaran
        Lamaran::create([
            'user_id' => auth()->id(), // Mengambil user_id dari pengguna yang sedang login
            'mitra_id' => $request->mitra_id,
            'cv_path' => 'cv/' . basename($cvPath), // Menyimpan path relatif file CV
        ]);

        // Redirect ke halaman lowongan dengan pesan sukses
        return redirect()->route('mhs_lowongan')->with('success', 'Lamaran berhasil diajukan.');
    }

    public function accLamaran($id)
    {
        $lamaran = Lamaran::find($id);
        $lamaran->status = 'diterima';
        $lamaran->tanggal_diterima = now(); // Menambahkan tanggal diterima
        $lamaran->save();

        return redirect()->back()->with('success', 'Lamaran diterima.');
    }

    public function tolakLamaran(Request $request, $id)
    {
        $lamaran = Lamaran::find($id);
        $lamaran->status = 'ditolak';
        $lamaran->alasan_penolakan = $request->alasan_penolakan;
        $lamaran->save();

        return redirect()->back()->with('success', 'Lamaran ditolak dengan alasan.');
    }

    public function statusLamaranMahasiswa()
    {
        // Log untuk menandai method ini dieksekusi
        Log::info('Method statusLamaranMahasiswa() dipanggil.');

        // Mendapatkan user yang sedang login
        $user_id = auth()->user()->id;

        // Mengambil data lamaran mahasiswa dengan relasi mitra dan dosen pembimbing
        $lamarans = Lamaran::where('user_id', $user_id)
            ->with(['mitra.dosenPembimbing', 'mitra.mitraUser']) // Memastikan mitraUser juga di-load
            ->get();

        // Log jumlah lamaran yang ditemukan
        Log::info('Jumlah lamaran ditemukan: ' . $lamarans->count());

        // Debug setiap lamaran dan relasi mitra serta dosen pembimbing
        foreach ($lamarans as $lamaran) {
            Log::info("ID Lamaran: " . $lamaran->id);

            // Cek apakah data mitra ada
            if ($lamaran->mitra) {
                Log::info("Mitra ID: " . $lamaran->mitra->id);
                Log::info("Nama Mitra: " . ($lamaran->mitra->mitraUser ? $lamaran->mitra->mitraUser->name : 'Tidak ada mitra user'));

                // Cek apakah dosen pembimbing ada
                if ($lamaran->mitra->dosenPembimbing) {
                    Log::info("Dosen Pembimbing: " . $lamaran->mitra->dosenPembimbing->name);
                } else {
                    Log::info("Dosen Pembimbing: Tidak ada dosen pembimbing");
                }
            } else {
                Log::info("Mitra: Tidak ada mitra");
            }
        }

        // Kembalikan data lamaran ke view 'status_lamaran'
        return view('mahasiswa.status_lamaran', compact('lamarans'));
    }



    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }

    public function mitraUser()
    {
        return $this->hasOneThrough(User::class, Mitra::class, 'id', 'id', 'mitra_id', 'user_id');
    }
}
