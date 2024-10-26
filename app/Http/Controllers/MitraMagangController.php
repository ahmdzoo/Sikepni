<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\Mitra;
use App\Models\User;
use App\Models\Jurusan;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class MitraMagangController extends Controller
{
    public function dashboard()
    {
        return view('mitra.dashboard'); // Pastikan Anda memiliki view ini
    }


    public function mitra_lamaran()
    {
        return view('mitra.mitra_lamaran'); // Pastikan Anda memiliki view ini
    }

    public function mitra_laporan()
    {
        return view('mitra.mitra_laporan'); // Pastikan Anda memiliki view ini
    }

    public function data_mitra(Request $request)
    {
        if ($request->ajax()) {
            // Mengambil data mitra
            $data = Mitra::with(['mitraUser', 'jurusan', 'dosenPembimbing'])->select('mitras.*');
    
            // Menangani pencarian
            if ($request->has('search') && !empty($request->search)) {
                $searchValue = $request->search;
                $data->where(function($q) use ($searchValue) {
                    $q->where('no_pks', 'like', "%{$searchValue}%")
                      ->orWhereHas('mitraUser', function($q) use ($searchValue) {
                          $q->where('name', 'like', "%{$searchValue}%");
                      })
                      ->orWhereHas('jurusan', function($q) use ($searchValue) {
                          $q->where('name', 'like', "%{$searchValue}%");
                      })
                      ->orWhereHas('dosenPembimbing', function($q) use ($searchValue) {
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
                ->addColumn('no', function($data) {
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
                ->addColumn('mitra_user', function($data) {
                    return $data->mitraUser->name; // Mengambil nama mitra
                })
                ->addColumn('jurusan', function($data) {
                    return $data->jurusan->name; // Mengambil nama jurusan
                })
                ->addColumn('dosen_pembimbing', function($data) {
                    return $data->dosenPembimbing->name; // Mengambil nama dosen pembimbing
                })
                ->addColumn('action', function($data) {
                    return '
                        <a href="javascript:void(0)" class="edit btn btn-warning btn-sm" data-id="' . $data->id . '">Edit</a>
                        <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="' . $data->id . '">Delete</a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        // Jika bukan AJAX, kembalikan view data mitra
        return view('admin.data_mitra', [
            'mitras' => Mitra::with('jurusan', 'dosenPembimbing')->get(),
            'mitrasMagang' => User::where('role', 'mitra_magang')->get(),
            'jurusans' => Jurusan::all(),
            'dosen_pembimbing' => User::where('role', 'dosen_pembimbing')->get(),
        ]);
    }
    


    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_mitra_id' => 'required|exists:users,id',
            'jurusan_id' => 'required|exists:jurusans,id',
            'dosen_pembimbing_id' => 'required|exists:users,id',
            'no_pks' => 'required|string|max:255',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
        ]);

        // Membuat mitra baru
        Mitra::create($request->all());

        return redirect()->route('data_mitra')->with('success', 'Mitra Magang berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit mitra.
     */
    public function edit(Mitra $mitra)
    {
        // Pastikan tgl_mulai dan tgl_selesai tidak null
        try {
            $tgl_mulai = $mitra->tgl_mulai ? $mitra->tgl_mulai->format('Y-m-d') : null;
            $tgl_selesai = $mitra->tgl_selesai ? $mitra->tgl_selesai->format('Y-m-d') : null;

            return response()->json([
                'id' => $mitra->id,
                'no_pks' => $mitra->no_pks,
                'tgl_mulai' => $tgl_mulai,
                'tgl_selesai' => $tgl_selesai,
                'nama_mitra_id' => $mitra->nama_mitra_id,
                'jurusan_id' => $mitra->jurusan_id,
                'dosen_pembimbing_id' => $mitra->dosen_pembimbing_id,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }


    public function update(Request $request, Mitra $mitra)
    {
        // Validasi input
        $request->validate([
            'nama_mitra_id' => 'required|exists:users,id',
            'jurusan_id' => 'required|exists:jurusans,id',
            'dosen_pembimbing_id' => 'required|exists:users,id',
            'no_pks' => 'required|string|max:255',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'required|date|after_or_equal:tgl_mulai',
        ]);

        // Memperbarui mitra
        $mitra->update($request->all());

        return redirect()->route('data_mitra')->with('success', 'Mitra Magang berhasil diupdate.');
    }

    public function deleteMitra($id)
    {
        $mitra = Mitra::findOrFail($id);
        $mitra->delete();

        return redirect()->route('data_mitra')->with('success', 'Data Mitra Berhasil di Hapus');
    }


    /**
     * Menyimpan jurusan baru.
     */
    public function storeJurusan(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:jurusans,name',
        ]);

        Jurusan::create(['name' => $request->name]);

        return redirect()->route('data_mitra')->with('success', 'Jurusan berhasil ditambahkan.');
    }

    public function showMitra(Request $request)
    {
        $query = Mitra::with(['mitraUser', 'dosenPembimbing', 'jurusan']);

        // Jika jurusan_id di request
        if ($request->has('jurusan_id') && $request->jurusan_id != '') {
            $query->where('jurusan_id', $request->jurusan_id);
        }

        // Ambil data dengan pagination
        $mitras = $query->paginate(10); // Menampilkan 10 data per halaman
        $jurusanList = Jurusan::all();

        return view('mahasiswa.mhs_lowongan', compact('mitras', 'jurusanList'));
    }


}