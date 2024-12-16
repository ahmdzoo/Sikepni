<?php
namespace App\Http\View\Composer;

use Illuminate\View\View;
use App\Models\Lamaran;
use App\Models\Mitra;
use App\Models\Laporan;
use App\Models\LaporanAkhir;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class DosenComposer
{
    public function compose(View $view)
    {
        // Ambil semua mitra yang dibimbing oleh dosen yang sedang login
        $mitras = Mitra::where('dosen_pembimbing_id', Auth::user()->id)->get();

        // Jika tidak ada mitra, kirimkan data kosong
        if ($mitras->isEmpty()) {
            $view->with([
                'lamarans' => collect([]),
                'laporanMagang' => collect([]),
                'laporanAkhir' => collect([]),
            ]);
            return;
        }

        // Ambil ID dari semua mitra
        $mitraIds = $mitras->pluck('id');

        // Ambil data lamaran yang statusnya 'pending'
        $lamarans = Lamaran::whereIn('mitra_id', $mitraIds)
            ->where('status', 'pending')
            ->where('created_at', '>=', Carbon::now()->subMonths(3))
            ->latest()
            ->get();

        // Array jenis laporan
        $jenisLaporan = ['Harian', 'Mingguan', 'Bulanan']; // Bisa juga didapatkan dari input atau database
            
        // Menentukan rentang waktu berdasarkan jenis laporan
        $tanggalBatasHarian = Carbon::now()->subDays(1); // 1 hari yang lalu
        $tanggalBatasMingguan = Carbon::now()->subDays(7); // 7 hari yang lalu
        $tanggalBatasBulanan = Carbon::now()->subMonths(1); // 1 bulan yang lalu

        // Ambil semua laporan magang berdasarkan mitra-mitra yang berelasi
        $laporanMagang = Laporan::whereIn('mitra_id', $mitraIds)
            ->latest()
            ->whereIn('jenis_laporan', $jenisLaporan)
            ->where(function ($query) use ($tanggalBatasHarian, $tanggalBatasMingguan, $tanggalBatasBulanan) {
                $query->where(function ($subQuery) use ($tanggalBatasHarian) {
                    // Filter untuk laporan harian
                    $subQuery->where('jenis_laporan', 'Harian')
                             ->where('created_at', '>=', $tanggalBatasHarian);
                })->orWhere(function ($subQuery) use ($tanggalBatasMingguan) {
                    // Filter untuk laporan mingguan
                    $subQuery->where('jenis_laporan', 'Mingguan')
                             ->where('created_at', '>=', $tanggalBatasMingguan);
                })->orWhere(function ($subQuery) use ($tanggalBatasBulanan) {
                    // Filter untuk laporan bulanan
                    $subQuery->where('jenis_laporan', 'Bulanan')
                             ->where('created_at', '>=', $tanggalBatasBulanan);
                });
            })
            ->get();

        // Ambil semua laporan akhir berdasarkan mitra-mitra yang berelasi
        $laporanAkhir = LaporanAkhir::whereIn('mitra_id', $mitraIds)
            ->where('created_at', '>=', Carbon::now()->subMonth(3))
            ->latest()
            ->get();

        // Mengirim data ke view
        $view->with([
            'lamarans' => $lamarans,
            'laporanMagang' => $laporanMagang,
            'laporanAkhir' => $laporanAkhir,
        ]);
    }
}
