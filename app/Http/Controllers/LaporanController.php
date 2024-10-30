<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\Lamaran;
use App\Models\Laporan;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function mahasiswaAktifitas()
    {
        $laporans = Laporan::where('user_id', auth()->id())->get(); // Hanya ambil laporan milik mahasiswa yang login
        return view('mahasiswa.mhs_aktifitas', compact('laporans'));
    }

    public function dosenLaporan()
    {
        $dosenId = auth()->user()->id; // Ambil ID dosen yang login
    
        // Ambil mitra yang terkait dengan dosen
        $mitras = Mitra::where('dosen_pembimbing_id', $dosenId)->pluck('id');
    
        $laporans = Laporan::with('mahasiswa')
            ->whereIn('mitra_id', $mitras) // Ambil laporan dari mitra yang diawasi oleh dosen
            ->get();
        
        return view('dosen.dosen_laporan', compact('laporans'));
    }
    

    public function mitraLaporan()
{
    $mitraId = auth()->user()->id; // Ambil ID mitra yang login

    // Ambil mitra yang terkait dengan dosen
    $mitras = Mitra::where('nama_mitra_id', $mitraId)->pluck('id');

    $laporans = Laporan::with('mahasiswa')
        ->where('mitra_id', $mitras) // Ambil laporan yang terkait dengan mitra
        ->get();
    return view('mitra.mitra_laporan', compact('laporans'));
}



    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:2048',
        ]);

    // Ambil nama asli file
        $originalName = $request->file('file')->getClientOriginalName();

        // Simpan file di storage dengan nama asli
        $path = $request->file('file')->storeAs('laporan', $originalName,'public' );
        

        // Ambil mitra dari lamaran yang diterima oleh mahasiswa
        $lamaran = Lamaran::where('user_id', auth()->id())
            ->where('status', 'diterima') // Pastikan hanya mengambil lamaran yang diterima
            ->first();

            if ($lamaran) {
                Laporan::create([
                    'user_id' => auth()->id(),
                    'mitra_id' => $lamaran->mitra_id, // Simpan ID mitra yang menerima lamaran
                    'file_path' => $path,
                ]);
            }
            
         else {
            return redirect()->back()->with('error', 'Anda belum diterima oleh mitra.');
        }

        return redirect()->back()->with('success', 'Laporan berhasil diupload.');
    }


    public function edit($id)
    {
        $laporan = Laporan::findOrFail($id);
        return view('mahasiswa.edit_laporan', compact('laporan'));
    }

    public function update(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        $request->validate([
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            Storage::disk('public')->delete($laporan->file_path);

            // Simpan file dengan nama asli
            $originalName = $request->file('file')->getClientOriginalName();
            $path = $request->file('file')->storeAs('laporan', $originalName, 'public');
            
            // Update path di database dengan nama file asli
            $laporan->file_path = 'laporan/' . $originalName;
        }

        $laporan->save();

        return redirect()->route('mahasiswa.aktifitas')->with('success', 'Laporan berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);
        Storage::delete($laporan->file_path); // Hapus file dari storage
        $laporan->delete();

        return redirect()->back()->with('success', 'Laporan berhasil dihapus.');
    }

    public function storeKomentar(Request $request, $laporanId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        Komentar::create([
            'laporan_id' => $laporanId,
            'user_id' => auth()->id(),
            'content' => $request->input('content'),
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    public function destroyKomentar($laporanId, $komentarId)
    {
        $komentar = Komentar::findOrFail($komentarId);

        // Cek apakah user yang login adalah pemilik komentar
        if ($komentar->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus komentar ini.');
        }

        $komentar->delete();

        return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
    }

    public function magang()
    {
        $mahasiswa = auth()->user(); // Ambil pengguna yang sedang login
        $lamaran = $mahasiswa->lamaran()->with('mitra', 'dosenPembimbing')->first(); // Ambil lamaran pertama

        return view('mahasiswa.magang', compact('lamaran'));
    }



}

