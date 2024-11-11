<?php

namespace App\Http\Controllers;

use App\Models\Lamaran;
use App\Models\Laporan;
use App\Models\LaporanAkhir;
use App\Models\Mitra;
use Illuminate\Http\Request;

class DosenPembimbingController extends Controller
{
    public function dashboard()
    {
        $dosenId = auth()->user()->id; // ID dosen yang sedang login

        // Ambil semua ID mitra yang dibimbing oleh dosen ini
        $mitraIds = Mitra::where('dosen_pembimbing_id', $dosenId)->pluck('id');

        // Hitung jumlah total lamaran masuk yang terkait dengan mitra dari dosen pembimbing ini
        $jumlahLamaran = Lamaran::whereHas('mitra', function ($query) use ($dosenId) {
            $query->where('dosen_pembimbing_id', $dosenId);
        })->count();

        // Hitung jumlah mahasiswa yang diterima oleh mitra terkait dosen pembimbing
        $jumlahMahasiswaDiterima = Lamaran::where('status', 'diterima')
            ->whereHas('mitra', function ($query) use ($dosenId) {
                $query->where('dosen_pembimbing_id', $dosenId);
            })->count();


        // Ambil laporan magang mahasiswa yang dibimbing dosen ini, dengan limit 5 data terbaru
        $laporanMagang = Laporan::whereIn('mitra_id', $mitraIds)
            ->where('jenis_laporan', '!=', 'Akhir')
            ->with('mahasiswa')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Ambil laporan akhir magang mahasiswa yang dibimbing dosen ini, dengan limit 5 data terbaru
        $laporanAkhir = Laporan::whereIn('mitra_id', $mitraIds)
            ->where('jenis_laporan', 'Akhir')
            ->with('mahasiswa')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Ambil mahasiswa yang lamarannya diterima dan diampu oleh dosen ini
        $mahasiswaDiterima = Lamaran::whereIn('mitra_id', $mitraIds)
            ->where('status', 'diterima') // Pastikan statusnya diterima
            ->with('mahasiswa') // Mengambil data mahasiswa yang melamar
            ->orderBy('updated_at', 'desc') // Urutkan berdasarkan tanggal lamaran
            ->take(5) // Batasi 5 data terbaru
            ->get();

        return view('dosen.dashboard', compact('jumlahLamaran', 'jumlahMahasiswaDiterima', 'laporanMagang', 'laporanAkhir', 'mahasiswaDiterima'));
    }


    public function dosen_laporan()
    {
        return view('dosen.dosen_laporan'); // Pastikan Anda memiliki view ini
    }

    // Di DosenPembimbingController
    public function dosen_lamaran()
    {
        $user = auth()->user();
        // Ambil mitra yang terkait dengan dosen pembimbing
        $mitras = Mitra::where('dosen_pembimbing_id', $user->id)->pluck('id');

        // Ambil lamaran yang terkait dengan mitra
        $lamarans = Lamaran::whereIn('mitra_id', $mitras)->with('user')->get();

        return view('dosen.dosen_lamaran', compact('lamarans'));
    }

}
