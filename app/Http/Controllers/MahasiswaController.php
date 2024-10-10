<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InfoMitra; // Mengimpor model InfoMitra
use App\Models\Lamaran;   // Mengimpor model Lamaran

class MahasiswaController extends Controller
{
    // Menampilkan dashboard mahasiswa
    public function dashboard()
    {
        return view('mahasiswa.dashboard'); // Pastikan Anda memiliki view ini
    }

    // Menampilkan halaman dashboard mahasiswa lainnya jika diperlukan
    public function mhs_dashboard()
    {
        return view('mahasiswa.mhs_dashboard');
    }

    // Menampilkan daftar mitra magang
    public function mhs_lowongan()
    {
        // Mengambil data mitra magang dari database
        $mitraMagang = InfoMitra::all();
        return view('mahasiswa.mhs_lowongan', compact('mitraMagang'));
    }

    // Menampilkan aktivitas mahasiswa
    public function mhs_aktifitas()
    {
        return view('mahasiswa.mhs_aktifitas');
    }

    // Method untuk mengirim CV ke perusahaan
    public function kirimCV(Request $request)
    {
        // Validasi file input
        $request->validate([
            'cv' => 'required|mimes:pdf,doc,docx|max:2048', // Validasi file harus PDF atau DOC, maksimal 2MB
            'mitra_id' => 'required|exists:info_mitra,id', // Pastikan mitra_id valid
        ]);

        // Simpan file CV ke dalam folder 'cv' di storage
        $path = $request->file('cv')->store('cv', 'public'); // Menyimpan di 'storage/app/public/cv'

        // Ambil ID user yang sedang login
        $userId = auth()->user()->id; // Ambil ID mahasiswa yang login

        // Simpan ke tabel terkait, misal tabel 'lamaran'
        \DB::table('lamaran')->insert([
            'user_id' => $userId,      // Gunakan 'user_id' untuk mahasiswa
            'mitra_id' => $request->mitra_id,
            'cv_path' => $path,        // Path CV disimpan
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Redirect kembali ke halaman daftar mitra dengan pesan sukses
        return redirect()->route('mhs_lowongan')->with('success', 'CV berhasil dikirim!');
    }

    // Method untuk membuat laporan harian
    public function buatLaporanHarian(Request $request)
    {
        // Validasi dan logika untuk membuat laporan harian
        $request->validate([
            'laporan_harian' => 'required|string',
            'tanggal' => 'required|date',
        ]);

        // Proses penyimpanan laporan harian
        // Tambahkan logika penyimpanan laporan harian di sini
    }

    // Method untuk membuat laporan akhir
    public function buatLaporanAkhir(Request $request)
    {
        // Validasi dan logika untuk membuat laporan akhir
        $request->validate([
            'laporan_akhir' => 'required|string',
        ]);

        // Proses penyimpanan laporan akhir
        // Tambahkan logika penyimpanan laporan akhir di sini
    }
}
