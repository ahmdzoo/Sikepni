<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\Mitra;
use App\Models\User;
use App\Models\Jurusan;
use App\Models\Lamaran;
use App\Models\Laporan;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class MitraMagangController extends Controller
{
    public function dashboard()
    {
        $dosenId = auth()->user()->id; // ID dosen yang sedang login

        // Ambil semua ID mitra yang dibimbing oleh dosen ini
        $mitraIds = Mitra::where('nama_mitra_id', $dosenId)->pluck('id');

        // Hitung jumlah total lamaran masuk yang terkait dengan mitra dari dosen pembimbing ini
        $jumlahLamaran = Lamaran::whereHas('mitra', function ($query) use ($dosenId) {
            $query->where('nama_mitra_id', $dosenId);
        })
        ->where('status', 'pending')
        ->count();

        // Hitung jumlah mahasiswa yang diterima oleh mitra terkait dosen pembimbing
        $jumlahMahasiswaDiterima = Lamaran::where('status', 'diterima')
            ->whereHas('mitra', function ($query) use ($dosenId) {
                $query->where('nama_mitra_id', $dosenId);
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

        return view('mitra.dashboard', compact('jumlahLamaran', 'jumlahMahasiswaDiterima', 'laporanMagang', 'laporanAkhir', 'mahasiswaDiterima'));
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
        try {
            $tgl_mulai = $mitra->tgl_mulai ? Carbon::parse($mitra->tgl_mulai)->format('Y-m-d') : null;
            $tgl_selesai = $mitra->tgl_selesai ? Carbon::parse($mitra->tgl_selesai)->format('Y-m-d') : null;

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

    
}
