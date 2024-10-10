<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Mitra;
use App\Models\User;
use Illuminate\Http\Request;

class MitraMagangController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function data_mitra()
    {
        // Mengambil semua mitra dengan relasi yang dibutuhkan
        $mitras = Mitra::with(['mitraUser', 'jurusan', 'dosenPembimbing'])->get();
        
        // Mengambil semua jurusan
        $jurusans = Jurusan::all();
        
        // Mengambil semua dosen pendamping dengan peran 'dosen_pembimbing'
        $dosen_pembimbing = User::where('role', 'dosen_pembimbing')->get();
        
        // Mengambil semua pengguna dengan peran 'mitra_magang' untuk dropdown Nama Mitra
        $mitrasMagang = User::where('role', 'mitra_magang')->get();
        
        return view('admin.data_mitra', compact('mitras', 'jurusans', 'dosen_pembimbing', 'mitrasMagang'));
    }

    /**
     * Menyimpan data mitra baru.
     */
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
        // Mengambil semua jurusan
        $jurusans = Jurusan::all();
        
        // Mengambil semua dosen pendamping dengan peran 'dosen_pembimbing'
        $dosen_pembimbing = User::where('role', 'dosen_pembimbing')->get();
        
        // Mengambil semua pengguna dengan peran 'mitra_magang' untuk dropdown Nama Mitra
        $mitrasMagang = User::where('role', 'mitra_magang')->get();
        
        return view('admin.edit', compact('mitra', 'jurusans', 'dosen_pembimbing', 'mitrasMagang'));
    }

    /**
     * Memperbarui data mitra.
     */
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

    /**
     * Menghapus mitra.
     */
    public function destroy(Mitra $mitra)
    {
        $mitra->delete();
        return redirect()->route('data_mitra')->with('success', 'Mitra Magang berhasil dihapus.');
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

    // public function getDataMitra(Request $request)
    // {
    //     // Mengambil data mitra dengan relasi jurusan, dosen pembimbing, dan mitra user
    //     $query = Mitra::with(['mitraUser', 'jurusan', 'dosenPembimbing']);

    //     // Filter jurusan jika ada
    //     if ($request->has('jurusan_id') && $request->jurusan_id != '') {
    //         $query->where('jurusan_id', $request->jurusan_id);
    //     }

    //     // Menjalankan query dan mengembalikan dalam format DataTables
    //     return datatables()->of($query)->make(true);
    //}



}
