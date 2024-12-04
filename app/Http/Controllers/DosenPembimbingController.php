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
        $laporanAkhir = LaporanAkhir::whereIn('mitra_id', $mitraIds)
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

    // Menampilkan daftar mitra magang
    public function mitra_lowongan()
    {
        return view('dosen.mitra_lowongan');
    }

    public function showMitra(Request $request)
    {
        if ($request->ajax()) {
            // Mengambil data mitra
            $data = Mitra::with(['mitraUser', 'jurusan', 'dosenPembimbing'])->select('mitras.*');

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
                        })
                        ->orWhereHas('dosenPembimbing', function ($q) use ($searchValue) {
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
                ->addColumn('dosen_pembimbing', function ($data) {
                    return $data->dosenPembimbing->name; // Mengambil nama dosen pembimbing
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
                ->make(true);
        }

        // Jika bukan AJAX, kembalikan view data mitra
        return view('dosen.mitra_lowongan', [
            'mitras' => Mitra::with('jurusan', 'dosenPembimbing')->get(),
            'mitrasMagang' => User::where('role', 'mitra_magang')->get(),
            'jurusans' => Jurusan::all(),
            'dosen_pembimbing' => User::where('role', 'dosen_pembimbing')->get(),
        ]);
    }

}
