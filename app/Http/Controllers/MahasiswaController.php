<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\Mitra;
use App\Models\User;
use App\Models\Lamaran;
use App\Models\Jurusan;
use Carbon\Carbon;
use App\Http\Controllers\LamaranController;

class MahasiswaController extends Controller
{
    // Menampilkan dashboard mahasiswa
    public function dashboard()
    {
        $mahasiswaId = auth()->id(); // Mendapatkan ID mahasiswa yang sedang login

        // Mengambil mitra yang menerima lamaran mahasiswa
        $mitras = Mitra::whereHas('lamaran', function ($query) use ($mahasiswaId) {
            $query->where('user_id', $mahasiswaId)->where('status', 'diterima');
        })->with(['mitraUser', 'jurusan', 'dosenPembimbing'])->get(); // Menyertakan relasi

        return view('mahasiswa.dashboard', [
            'mitras' => $mitras,
        ]);
    }


    // Menampilkan daftar mitra magang

    // Menampilkan aktivitas mahasiswa
    public function mhs_aktifitas()
    {
        return view('mahasiswa.mhs_aktifitas');
    }

    public function mhs_lowongan()
    {
        return view('mahasiswa.mhs_lowongan');
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
                ->editColumn('tgl_mulai', function ($mitra) {
                    return Carbon::parse($mitra->tgl_mulai)->format('Y-m-d'); // format sesuai kebutuhan
                })
                ->editColumn('tgl_selesai', function ($mitra) {
                    return Carbon::parse($mitra->tgl_selesai)->format('Y-m-d'); // format sesuai kebutuhan
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
            'mitras' => Mitra::with('jurusan', 'dosenPembimbing')->get(),
            'mitrasMagang' => User::where('role', 'mitra_magang')->get(),
            'jurusans' => Jurusan::all(),
            'dosen_pembimbing' => User::where('role', 'dosen_pembimbing')->get(),
        ]);
    }

    
}