<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lamaran;
use App\Models\Mitra;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LamaranController extends Controller
{
    public function index()
    {
        // Ambil data mitra berdasarkan nama_mitra_id yang sesuai dengan user_id yang login
        $mitra = Mitra::where('nama_mitra_id', Auth::user()->id)->first(); // Ganti 'user_id' dengan 'nama_mitra_id'

        // Cek apakah mitra ditemukan
        if ($mitra) {
            // Ambil semua lamaran yang terkait dengan mitra_id tersebut
            $lamarans = Lamaran::where('mitra_id', $mitra->id)->whereHas('mahasiswa')->get();
        } else {
            // Jika mitra tidak ditemukan, set lamarans sebagai koleksi kosong
            $lamarans = collect(); // Membuat Collection kosong
        }

        // Kembalikan ke view 'mitra.mitra_lamaran'
        return view('mitra.mitra_lamaran', compact('lamarans'));
    }

    public function store(Request $request)
    {
        $mahasiswa_id = auth()->user()->id;

        // Validasi input
        $request->validate([
            'mitra_id' => 'required|exists:mitras,id',
            'cv' => 'required|file|mimes:pdf|max:5120',
        ], [
            'cv.required' => 'File CV wajib diunggah.',
            'cv.file' => 'CV harus berupa file yang valid.',
            'cv.mimes' => 'Format CV harus berupa PDF.',
            'cv.max' => 'Ukuran CV maksimal 5MB.',
        ]);
        

        // Simpan file CV ke dalam folder public/cv
        $cvPath = $request->file('cv')->store('cv', 'public'); // Menyimpan file di public/storage/cv

        // Cek apakah mahasiswa sudah memiliki lamaran dengan status pending atau diterima
        $existingLamaran = Lamaran::where('user_id', $mahasiswa_id)
            ->whereIn('status', ['pending', 'diterima'])
            ->exists();

        if ($existingLamaran) {
            return redirect()->back()->with('error', 'Anda sudah memiliki pengajuan magang yang masih diproses atau sudah diterima.');
        }

        // Simpan lamaran baru jika belum ada yang pending atau diterima
        Lamaran::create([
            'user_id' => $mahasiswa_id,
            'mitra_id' => $request->mitra_id,
            'cv_path' => 'cv/' . basename($cvPath),
            'status' => 'pending', // Default status
        ]);

        return redirect()->back()->with('success', 'Lamaran magang berhasil diajukan.');
    }


    public function accLamaran(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'alasan_acc' => 'required|string|max:255', // Alasan ACC harus diisi, bertipe string, dan maksimal 255 karakter
            'mitra_id' => 'required|exists:mitras,id', // Pastikan mitra_id juga valid
        ]);

        $lamaran = Lamaran::findOrFail($id);
        $lamaran->status = 'diterima';
        $lamaran->alasan_acc = $request->alasan_acc; // Simpan alasan penerimaan
        $lamaran->tanggal_diterima = now(); // Menambahkan tanggal diterima
        $lamaran->save();

        return redirect()->back()->with('success', 'Lamaran diterima.');
    }

    public function acc(Request $request, $id)
    {
        $lamaran = Lamaran::find($id);
        $lamaran->status = 'diterima';
        $lamaran->alasan_acc = $request->input('alasan_acc');
        $lamaran->save();

        return redirect()->back()->with('success', 'Lamaran diterima!');
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
            ->with(['mitra.mitraUser']) // Memastikan mitraUser juga di-load
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
}
