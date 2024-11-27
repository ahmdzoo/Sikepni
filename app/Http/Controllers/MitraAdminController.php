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
use Illuminate\Support\Facades\Storage;

class MitraAdminController extends Controller
{

    public function mitra_admin()
{
    // Mendapatkan ID pengguna yang sedang login
    $userId = auth()->id();

    // Mengambil data mitra yang hanya terelasi dengan pengguna yang sedang login
    $mitras = Mitra::with(['jurusan', 'dosenPembimbing', 'mitraUser'])
                    ->where('nama_mitra_id', $userId)
                    ->get();
                    
    // Mengambil semua dosen pembimbing dari pengguna dengan role 'dosen_pembimbing'
    $dosenPembimbing = User::where('role', 'dosen_pembimbing')->get();

    $mitrasMagang = User::where('role', 'mitra_magang')->get();

    // Mengambil semua data jurusan
    $jurusans = Jurusan::all();

    return view('mitra.mitra_admin', compact('mitras', 'dosenPembimbing', 'jurusans', 'mitrasMagang' ));
}


public function update(Request $request, $id)
{
    $request->validate([
        // 'nama_mitra_id' => 'required|exists:users,id',
        'jurusan_id' => 'required|exists:jurusans,id',
        'dosen_pembimbing_id' => 'required|exists:users,id',
        'tanggal_mulai_magang' => 'required|date',
        'tanggal_selesai_magang' => 'required|date|after_or_equal:tanggal_mulai_magang',
        'alamat' => 'nullable|string',
        'kuota' => 'nullable|integer',
    ]);

    $mitra = Mitra::findOrFail($id);
    $mitra->update([
        // 'nama_mitra_id' => $request->nama_mitra_id,
        'jurusan_id' => $request->jurusan_id,
        'dosen_pembimbing_id' => $request->dosen_pembimbing_id,
        'tanggal_mulai_magang' => $request->tanggal_mulai_magang,
        'tanggal_selesai_magang' => $request->tanggal_selesai_magang,
        'alamat' => $request->alamat,
        'kuota' => $request->kuota,
    ]);

    return redirect()->route('mitra_admin')->with('success', 'Data mitra berhasil diperbarui.');
}

}


    


