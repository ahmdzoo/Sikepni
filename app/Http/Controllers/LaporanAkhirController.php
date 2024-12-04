<?php

namespace App\Http\Controllers;

use App\Models\KomentarAkhir;
use App\Models\Lamaran;
use App\Models\LaporanAkhir;
use App\Models\Mitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LaporanAkhirController extends Controller
{
    public function mhsLaporanAkhir(Request $request)
    {
        $query = LaporanAkhir::query();
    
    
        $LaporanAkhirs = $query->where('user_id', auth()->id())->paginate(10); // Pastikan hanya menampilkan LaporanAkhir mahasiswa yang sedang login

        return view('mahasiswa.mhs_LaporanAkhir', compact('LaporanAkhirs'));
    }

    public function dosenLaporanAkhir(Request $request, $mahasiswa_id)
    {
        $dosenId = auth()->user()->id; // Ambil ID dosen yang login
    
        // Ambil mitra yang terkait dengan dosen
        $mitras = Mitra::where('dosen_pembimbing_id', $dosenId)->pluck('id');
    
        // Query dasar untuk LaporanAkhir sesuai mitra dan mahasiswa tertentu
            $query = LaporanAkhir::whereIn('mitra_id', $mitras)
            ->where('user_id', $mahasiswa_id)
            ->with('mahasiswa');

        // Paginasi hasil dengan 10 LaporanAkhir per halaman
        $LaporanAkhirs = $query->paginate(10);
        
        return view('dosen.dosen_LaporanAkhir', compact('LaporanAkhirs','mahasiswa_id'));
    }
    

    public function mitraLaporanAkhir(Request $request, $mahasiswa_id)
    {
        $mitraId = auth()->user()->id; // ID mitra yang login

        // Ambil mitra terkait user
        $mitras = Mitra::where('nama_mitra_id', $mitraId)->pluck('id');

        // Query dasar untuk LaporanAkhir sesuai mitra dan mahasiswa tertentu
        $query = LaporanAkhir::whereIn('mitra_id', $mitras)
            ->where('user_id', $mahasiswa_id)
            ->with('mahasiswa');

        // Paginasi hasil dengan 10 LaporanAkhir per halaman
        $LaporanAkhirs = $query->paginate(10);

        return view('mitra.mitra_LaporanAkhir', compact('LaporanAkhirs','mahasiswa_id'));
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|file|mimes:pdf|max:5120',
            ]);
    
            // Ambil nama asli file
            $originalName = $request->file('file')->getClientOriginalName();
    
            // Simpan file di storage dengan nama asli
            $path = $request->file('file')->storeAs('LaporanAkhir', $originalName, 'public');
    
            // Ambil mitra dari lamaran yang diterima oleh mahasiswa
            $lamaran = Lamaran::where('user_id', auth()->id())
                ->where('status', 'diterima') // Pastikan hanya mengambil lamaran yang diterima
                ->first();
    
            if (!$lamaran) {
                return redirect()->back()->with('error', 'Anda belum diterima oleh mitra.');
            }
    
            LaporanAkhir::create([
                'user_id' => auth()->id(),
                'mitra_id' => $lamaran->mitra_id, // Simpan ID mitra yang menerima lamaran
                'file_path' => $path,
            ]);
    
            return redirect()->back()->with('success', 'Laporan berhasil diupload.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat upload. Silakan coba lagi.');
        }
    }


    public function edit($id)
    {
        $LaporanAkhir = LaporanAkhir::findOrFail($id);
        return view('mahasiswa.edit_LaporanAkhir', compact('LaporanAkhir'));
    }

    public function update(Request $request, $id)
    {
        $LaporanAkhir = LaporanAkhir::findOrFail($id);

        $request->validate([
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            Storage::disk('public')->delete($LaporanAkhir->file_path);

            // Simpan file dengan nama asli
            $originalName = $request->file('file')->getClientOriginalName();
            $path = $request->file('file')->storeAs('LaporanAkhir', $originalName, 'public');
            
            // Update path di database dengan nama file asli
            $LaporanAkhir->file_path = 'LaporanAkhir/' . $originalName;
        }

        $LaporanAkhir->save();

        return redirect()->route('mahasiswa.LaporanAkhir')->with('success', 'LaporanAkhir berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $LaporanAkhir = LaporanAkhir::findOrFail($id);
        $LaporanAkhir->delete();

        // Periksa jumlah data di halaman saat ini
        $page = request()->input('page', 1); // Ambil halaman saat ini
        $LaporanAkhirCount = LaporanAkhir::paginate(10, ['*'], 'page', $page)->count();

        if ($LaporanAkhirCount == 0 && $page > 1) {
            return redirect()->route('mahasiswa.aktifitas', ['page' => $page - 1])
                            ->with('success', 'LaporanAkhir berhasil dihapus');
        }

        return redirect()->route('mahasiswa.aktifitas')
                        ->with('success', 'LaporanAkhir berhasil dihapus');
    }

    public function storeKomentar(Request $request, $laporanAkhirId)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        KomentarAkhir::create([
            'laporan_akhir_id' => $laporanAkhirId,
            'user_id' => auth()->id(),
            'content' => $request->input('content'),
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
    }


    public function destroyKomentar($LaporanAkhirId, $komentarAkhirId)
    {
        $komentar = KomentarAkhir::findOrFail($komentarAkhirId);

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

    public function adminLaporanAkhir(Request $request, $mahasiswa_id)
{
    // Query dasar untuk laporan magang mahasiswa
    $query = LaporanAkhir::with(['mahasiswa', 'mitra']);
    
    // Jika $mahasiswa_id diberikan, tambahkan filter untuk mahasiswa tertentu
    if ($mahasiswa_id) {
        $query->where('user_id', $mahasiswa_id);
    }


    // Paginasi hasil dengan 10 laporan per halaman
    $LaporanAkhirs = $query->paginate(10);

    return view('admin.admin_LaporanAkhir', compact('LaporanAkhirs', 'mahasiswa_id'));
}




}

