<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\Lamaran;
use App\Models\Laporan;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function mahasiswaAktifitas(Request $request)
    {
        $query = Laporan::query();
    
        if ($request->has('filter_jenis') && $request->filter_jenis) {
            $query->where('jenis_laporan', $request->filter_jenis);
        }
    
        $laporans = $query->where('user_id', auth()->id())->paginate(10); // Pastikan hanya menampilkan laporan mahasiswa yang sedang login

        return view('mahasiswa.mhs_aktifitas', compact('laporans'));
    }

    public function dosenLaporan(Request $request, $mahasiswa_id)
    {
        $dosenId = auth()->user()->id; // Ambil ID dosen yang login
    
        // Ambil mitra yang terkait dengan dosen
        $mitras = Mitra::where('dosen_pembimbing_id', $dosenId)->pluck('id');
    
        // Query dasar untuk laporan sesuai mitra dan mahasiswa tertentu
            $query = Laporan::whereIn('mitra_id', $mitras)
            ->where('user_id', $mahasiswa_id)
            ->with('mahasiswa');

        // Tambahkan filter jenis laporan jika tersedia
        if ($request->has('filter_jenis') && $request->filter_jenis) {
            $query->where('jenis_laporan', $request->filter_jenis);
        }

        // Paginasi hasil dengan 10 laporan per halaman
        $laporans = $query->paginate(10);
        
        return view('dosen.dosen_laporan', compact('laporans'));
    }
    

    public function mitraLaporan(Request $request, $mahasiswa_id)
    {
        $mitraId = auth()->user()->id; // ID mitra yang login

        // Ambil mitra terkait user
        $mitras = Mitra::where('nama_mitra_id', $mitraId)->pluck('id');

        // Query dasar untuk laporan sesuai mitra dan mahasiswa tertentu
        $query = Laporan::whereIn('mitra_id', $mitras)
            ->where('user_id', $mahasiswa_id)
            ->with('mahasiswa');

        // Tambahkan filter jenis laporan jika tersedia
        if ($request->has('filter_jenis') && $request->filter_jenis) {
            $query->where('jenis_laporan', $request->filter_jenis);
        }

        // Paginasi hasil dengan 10 laporan per halaman
        $laporans = $query->paginate(10);

        return view('mitra.mitra_laporan', compact('laporans','mahasiswa_id'));
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
                    'jenis_laporan' => $request->input('jenis_laporan', 'Harian'), // Default ke 'Harian' jika tidak ada input
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
    $laporan->delete();

    // Periksa jumlah data di halaman saat ini
    $page = request()->input('page', 1); // Ambil halaman saat ini
    $laporanCount = Laporan::paginate(10, ['*'], 'page', $page)->count();

    if ($laporanCount == 0 && $page > 1) {
        return redirect()->route('mahasiswa.aktifitas', ['page' => $page - 1])
                         ->with('success', 'Laporan berhasil dihapus');
    }

    return redirect()->route('mahasiswa.aktifitas')
                     ->with('success', 'Laporan berhasil dihapus');
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
        $lamaran = $mahasiswa->lamaran()->with('mitra', 'dosenPembimbing')->where('status', 'diterima')->first(); // Ambil lamaran pertama

        return view('mahasiswa.magang', compact('lamaran'));
    }

    public function mahasiswaDiterima()
    {
        $mahasiswaDiterima = Lamaran::where('status', 'diterima')
            ->whereHas('mitra', function ($query) {
                $query->where('nama_mitra_id', auth()->id()); // Sesuaikan dengan kolom ID pengguna mitra
            })
            ->with('mahasiswa')
            ->get();

        // Debugging output ke log untuk memastikan data tidak kosong
        if ($mahasiswaDiterima->isEmpty()) {
            Log::info('Tidak ada mahasiswa diterima untuk mitra dengan ID: ' . auth()->id());
        } else {
            Log::info('Jumlah mahasiswa diterima: ' . $mahasiswaDiterima->count());
            foreach ($mahasiswaDiterima as $lamaran) {
                Log::info('Mahasiswa diterima: ' . $lamaran->mahasiswa->name);
            }
        }

        return view('mitra.mahasiswa_diterima', compact('mahasiswaDiterima'));
    }

    public function magang_mhs()
    {
        $mahasiswaDiterima = Lamaran::where('status', 'diterima')
            ->whereHas('mitra', function ($query) {
                $query->where('dosen_pembimbing_id', auth()->id()); // Sesuaikan dengan kolom ID pengguna mitra
            })
            ->with('mahasiswa')
            ->get();

        // Debugging output ke log untuk memastikan data tidak kosong
        if ($mahasiswaDiterima->isEmpty()) {
            Log::info('Tidak ada mahasiswa diterima untuk mitra dengan ID: ' . auth()->id());
        } else {
            Log::info('Jumlah mahasiswa diterima: ' . $mahasiswaDiterima->count());
            foreach ($mahasiswaDiterima as $lamaran) {
                Log::info('Mahasiswa diterima: ' . $lamaran->mahasiswa->name);
            }
        }

        return view('dosen.magang_mhs', compact('mahasiswaDiterima'));
    }




}

