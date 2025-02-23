<?php

namespace App\Http\Controllers;

use App\Models\Lamaran;
use App\Models\Laporan;
use App\Models\LaporanAkhir;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use App\Models\Jurusan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DosenPembimbingController extends Controller
{
    public function dashboard()
    {
        $dosenId = Auth::id();

        // Ambil mahasiswa yang berelasi dengan dosen
        $mahasiswaDibimbing = User::whereHas('dosen', function ($query) use ($dosenId) {
            $query->where('dosen_id', $dosenId);
        })->get();


        $jumlahMahasiswa = $mahasiswaDibimbing->count();


        // Ambil laporan magang terbaru
        $laporanMagang = Laporan::forDosen($dosenId)->get()->count();

        // Ambil laporan akhir terbaru
        $laporanAkhir = LaporanAkhir::forDosen($dosenId)->get()->count();




        return view('dosen.dashboard', compact('mahasiswaDibimbing', 'jumlahMahasiswa', 'laporanMagang', 'laporanAkhir'));
    }


    public function dosen_laporan()
    {
        return view('dosen.dosen_laporan'); // Pastikan Anda memiliki view ini
    }

    public function dosen_lamaran()
    {
        $dosenId = auth()->user()->id;

        // Ambil ID mahasiswa yang dibimbing oleh dosen ini
        $mahasiswaDibimbingIds = User::whereHas('dosen', function ($query) use ($dosenId) {
            $query->where('dosen_id', $dosenId);
        })->pluck('id');

        // Ambil lamaran yang dibuat oleh mahasiswa yang terkait dengan dosen ini
        $lamarans = Lamaran::whereIn('user_id', $mahasiswaDibimbingIds)
            ->with(['user', 'mitra'])
            ->get();

        return view('dosen.dosen_lamaran', compact('lamarans'));
    }




    // Menampilkan daftar mitra magang
    public function mitra_lowongan()
    {
        return view('dosen.mitra_lowongan');
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
                    $q->orWhereHas('mitraUser', function ($q) use ($searchValue) {
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
                ->addColumn('no_pks', function ($data) {
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

                ->addColumn('kuota', function ($data) {
                    return $data->kuota;
                })
                ->addColumn('alamat', function ($data) {
                    return $data->alamat;
                })
                ->addColumn('file_pks', function ($data) {
                    return $data->file_pks;
                })
                ->make(true);
        }

        // Jika bukan AJAX, kembalikan view data mitra
        return view('dosen.mitra_lowongan', [
            'mitras' => Mitra::with('jurusan', 'dosenPembimbing')->get(),
            'mitrasMagang' => User::where('role', 'mitra_magang')->get(),
            'jurusans' => Jurusan::all(),
        ]);
    }
}
