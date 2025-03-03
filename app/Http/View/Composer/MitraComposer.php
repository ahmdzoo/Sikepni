<?php
namespace App\Http\View\Composer;

use Illuminate\View\View;
use App\Models\Lamaran;
use App\Models\Mitra;
use App\Models\Laporan;
use App\Models\LaporanAkhir;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MitraComposer
{
    public function compose(View $view)
    {
        // Pastikan user login
        if (!Auth::check()) {
            return;
        }

        // Ambil data mitra berdasarkan pengguna yang sedang login
        $mitra = Mitra::where('nama_mitra_id', Auth::user()->id)->first();

        // Jika mitra tidak ditemukan, kirim data kosong
        if (!$mitra) {
            $view->with([
                'lamarans' => collect(),
                'laporanMagang' => collect(),
                'laporanAkhir' => collect(),
            ]);
            return;
        }

        // Ambil data lamarans (pengajuan magang) yang pending dalam 3 bulan terakhir
        $lamarans = Lamaran::where('mitra_id', $mitra->id)
            ->where('status', 'pending')
            ->where('created_at', '>=', Carbon::now()->subMonths(3))
            ->latest()
            ->get();

        // Array jenis laporan
        $jenisLaporan = ['Harian', 'Mingguan', 'Bulanan'];

        // Rentang waktu untuk filter laporan
        $tanggalBatasHarian = Carbon::now()->subDays(1);
        $tanggalBatasMingguan = Carbon::now()->subDays(7);
        $tanggalBatasBulanan = Carbon::now()->subMonths(1);

        // Query laporan magang mencakup semua jenis laporan
        $laporanMagang = Laporan::where('mitra_id', $mitra->id)
            ->whereIn('jenis_laporan', $jenisLaporan)
            ->where(function ($query) use ($tanggalBatasHarian, $tanggalBatasMingguan, $tanggalBatasBulanan) {
                $query->where(function ($subQuery) use ($tanggalBatasHarian) {
                    $subQuery->where('jenis_laporan', 'Harian')
                             ->where('created_at', '>=', $tanggalBatasHarian);
                })->orWhere(function ($subQuery) use ($tanggalBatasMingguan) {
                    $subQuery->where('jenis_laporan', 'Mingguan')
                             ->where('created_at', '>=', $tanggalBatasMingguan);
                })->orWhere(function ($subQuery) use ($tanggalBatasBulanan) {
                    $subQuery->where('jenis_laporan', 'Bulanan')
                             ->where('created_at', '>=', $tanggalBatasBulanan);
                });
            })
            ->latest()
            ->get();

        // Ambil data laporan akhir terkait mitra ini
        $laporanAkhir = LaporanAkhir::where('mitra_id', $mitra->id)
            ->where('created_at', '>=', Carbon::now()->subMonth(3))
            ->latest()
            ->get();

        // Mengirimkan data ke view
        $view->with([
            'lamarans' => $lamarans,
            'laporanMagang' => $laporanMagang,
            'laporanAkhir' => $laporanAkhir,
        ]);
    }
}
