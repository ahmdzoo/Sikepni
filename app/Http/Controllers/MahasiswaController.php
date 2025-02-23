<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\Mitra;
use App\Models\User;
use App\Models\Laporan;
use App\Models\Lamaran;
use App\Models\Jurusan;
use App\Models\LaporanAkhir;
use Carbon\Carbon;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        $mahasiswaId = auth()->id(); // Mendapatkan ID mahasiswa yang sedang login

        // Mengambil mitra yang menerima lamaran mahasiswa
        $mitras = Mitra::whereHas('lamaran', function ($query) use ($mahasiswaId) {
            $query->where('user_id', $mahasiswaId)->where('status', 'diterima');
        })->with(['mitraUser', 'jurusan'])->get();

        $mahasiswa = auth()->user();
        $dosen = $mahasiswa->dosen; // Mengambil dosen yang berelasi dengan mahasiswa ini
        
        // Menghitung jumlah laporan
        $totalLaporan = Laporan::where('user_id', $mahasiswaId)->count();
        $totalLaporanAkhir = LaporanAkhir::where('user_id', $mahasiswaId)->count();

        // Menghitung jumlah lamaran
        $totalLamaran = Lamaran::where('user_id', $mahasiswaId)->count();
        $totalLamaranPending = Lamaran::where('user_id', $mahasiswaId)->where('status', 'pending')->count();
        $totalLamaranDiterima = Lamaran::where('user_id', $mahasiswaId)->where('status', 'diterima')->count();

        // Menghitung jumlah mitra yang ada
        $totalMitra = Mitra::count();

        return view('mahasiswa.dashboard', compact(
            'mitras', 'dosen', 'totalLaporan', 'totalLaporanAkhir', 
            'totalLamaran', 'totalMitra', 'totalLamaranPending', 'totalLamaranDiterima'
        ));
    }

    
    // Menampilkan aktivitas mahasiswa
    public function mhs_aktifitas()
    {
        return view('mahasiswa.mhs_aktifitas');
    }

    // Menampilkan daftar mitra magang
    public function mhs_lowongan()
    {
        return view('mahasiswa.mhs_lowongan');
    }

    public function showMitra(Request $request)
    {
        if ($request->ajax()) {
            // Mengambil data mitra
            $data = Mitra::with(['mitraUser', 'jurusan'])->select('mitras.*');

            // Menangani pencarian
            if ($request->has('search') && !empty($request->search)) {
                $searchValue = $request->search;
                $data->where(function ($q) use ($searchValue) {
                    $q->where('no_pks', 'like', "%{$searchValue}%")
                        ->orWhereHas('mitraUser', function ($q) use ($searchValue) {
                            $q->where('name', 'like', "%{$searchValue}%");
                        })
                        ->orWhereHas('jurusan', function ($q) use ($searchValue) {
                            $q->where('name', 'like', "%{$searchValue}%");
                        });

                });
            }

            // Mengatur filter
            if ($request->filled('filter')) {
                $data->where('jurusan_id', $request->filter);
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('no', function ($data) {
                    return $data->DT_RowIndex; // Jika Anda ingin menggunakan indeks baris
                })
                ->addColumn('no_pks', function($data) {
                    return $data->no_pks;
                })
                ->editColumn('tanggal_mulai_magang', function ($mitra) {
                    return Carbon::parse($mitra->tanggal_mulai_magang)->format('Y-m-d'); // format sesuai kebutuhan
                })
                ->editColumn('tanggal_selesai_magang', function ($mitra) {
                    return Carbon::parse($mitra->tanggal_selesai_magang)->format('Y-m-d'); // format sesuai kebutuhan
                })
                ->addColumn('mitra_user', function ($data) {
                    return $data->mitraUser->name; // Mengambil nama mitra
                })
                ->addColumn('jurusan', function ($data) {
                    return $data->jurusan->name; // Mengambil nama jurusan
                })
                ->addColumn('kuota', function($data) {
                    return $data->kuota;
                })
                ->addColumn('alamat', function($data) {
                    return $data->alamat;
                })
                ->addColumn('file_pks', function($data) {
                    return $data->file_pks;
                })
                ->addColumn('action', function ($data) {
                    return '
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#lamaranModal-' . $data->id . '">
                            Ajukan Lamaran
                        </button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // Jika bukan AJAX, kembalikan view data mitra
        return view('mahasiswa.mhs_lowongan', [
            'mitras' => Mitra::with('jurusan')->get(),
            'mitrasMagang' => User::where('role', 'mitra_magang')->get(),
            'jurusans' => Jurusan::all(),
        ]);
    }
}