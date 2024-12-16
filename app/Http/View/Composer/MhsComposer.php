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
        // Ambil data mitra berdasarkan pengguna yang sedang login
        $mitra = Mitra::where('nama_mitra_id', Auth::user()->id)->first();

        // Ambil data lamarans (pengajuan magang) yang pending dalam 3 bulan terakhir
        $lamarans = Lamaran::where('mitra_id', $mitra->id)
            ->where('status', 'diterima')
            ->where('created_at', '>=', Carbon::now()->subMonths(3))
            ->latest()
            ->get();

            // Array jenis laporan
            $jenisLaporan = ['Harian', 'Mingguan', 'Bulanan']; // Bisa juga didapatkan dari input atau database
            
            // Menentukan rentang waktu berdasarkan jenis laporan
            $tanggalBatasHarian = Carbon::now()->subDays(1); // 1 hari yang lalu
            $tanggalBatasMingguan = Carbon::now()->subDays(7); // 7 hari yang lalu
            $tanggalBatasBulanan = Carbon::now()->subMonths(1); // 1 bulan yang lalu
            
            // Query laporan magang mencakup semua jenis laporan
            $laporanMagang = Laporan::where('mitra_id', $mitra->id)
                ->whereIn('jenis_laporan', $jenisLaporan) // Filter berdasarkan semua jenis laporan
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