<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use App\Models\Mitra;
use App\Models\Lamaran;
use App\Models\Laporan;
use App\Models\User;
use Illuminate\Support\Facades\Crypt; // Menambahkan Crypt
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
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

    public function dosenLaporan(Request $request, $encrypted_mahasiswa_id)
    {
        // Dekripsi ID mahasiswa
        $mahasiswa_id = Crypt::decrypt($encrypted_mahasiswa_id);

        $dosenId = auth()->user()->id; // Ambil ID dosen yang login

        // Query dasar untuk laporan sesuai mitra dan mahasiswa tertentu
        $query = Laporan::forDosen($dosenId)
        ->where('user_id', $mahasiswa_id)
            ->whereHas('mahasiswa');

        // Tambahkan filter jenis laporan jika tersedia
        if ($request->has('filter_jenis') && $request->filter_jenis) {
            $query->where('jenis_laporan', $request->filter_jenis);
        }

        // Paginasi hasil dengan 10 laporan per halaman
        $laporans = $query->paginate(10);

        return view('dosen.dosen_laporan', compact('laporans', 'mahasiswa_id'));
    }

    public function mitraLaporan(Request $request, $encrypted_mahasiswa_id)
    {
        // Dekripsi ID mahasiswa
        $mahasiswa_id = Crypt::decrypt($encrypted_mahasiswa_id);

        $mitraId = auth()->user()->id; // ID mitra yang login

        // Ambil mitra terkait user
        $mitras = Mitra::where('nama_mitra_id', $mitraId)->pluck('id');

        // Query dasar untuk laporan sesuai mitra dan mahasiswa tertentu
        $query = Laporan::whereIn('mitra_id', $mitras)
            ->where('user_id', $mahasiswa_id)
            ->whereHas('mahasiswa');

        // Tambahkan filter jenis laporan jika tersedia
        if ($request->has('filter_jenis') && $request->filter_jenis) {
            $query->where('jenis_laporan', $request->filter_jenis);
        }

        // Paginasi hasil dengan 10 laporan per halaman
        $laporans = $query->paginate(10);

        return view('mitra.mitra_laporan', compact('laporans', 'mahasiswa_id'));
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
            $path = $request->file('file')->storeAs('laporan', $originalName, 'public');

            // Ambil mitra dari lamaran yang diterima oleh mahasiswa
            $lamaran = Lamaran::where('user_id', auth()->id())
                ->where('status', 'diterima') // Pastikan hanya mengambil lamaran yang diterima
                ->first();

            if (!$lamaran) {
                return redirect()->back()->with('error', 'Anda belum diterima oleh mitra.');
            }

            Laporan::create([
                'user_id' => auth()->id(),
                'mitra_id' => $lamaran->mitra_id, // Simpan ID mitra yang menerima lamaran
                'file_path' => $path,
                'jenis_laporan' => $request->input('jenis_laporan', 'Harian'), // Default ke 'Harian' jika tidak ada input
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
        $laporan = Laporan::findOrFail($id);
        return view('mahasiswa.edit_laporan', compact('laporan'));
    }

    public function update(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        $request->validate([
            'file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'jenis_laporan' => 'nullable|string',
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

        // Update jenis laporan jika ada perubahan
        $laporan->jenis_laporan = $request->input('jenis_laporan');

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
        $mahasiswaId = auth()->user()->id; // Ambil ID mahasiswa yang sedang login

        // Ambil lamaran dengan status 'diterima'
        $lamaran = Lamaran::with('mitra')->where('user_id', $mahasiswaId)->where('status', 'diterima')->first();

        // Ambil data mahasiswa beserta dosennya
        $mahasiswa = User::with('dosen')->find($mahasiswaId);
        $dosen = $mahasiswa ? $mahasiswa->dosen : collect(); // Pastikan dosen berupa koleksi agar tidak error

        return view('mahasiswa.magang', compact('lamaran', 'dosen'));
    }

    public function mahasiswaDiterima()
    {
        $mahasiswaDiterima = Lamaran::where('status', 'diterima')
            ->whereHas('mitra', function ($query) {
                $query->where('nama_mitra_id', auth()->id()); // Sesuaikan dengan kolom ID pengguna mitra
            })
            ->orderBy('updated_at', 'desc')
            ->whereHas('mahasiswa')
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
        $dosenId = auth()->user()->id;

        // Ambil ID mahasiswa yang dibimbing oleh dosen ini
        $mahasiswaDibimbingIds = User::whereHas('dosen', function ($query) use ($dosenId) {
            $query->where('dosen_id', $dosenId);
        })->pluck('id');

        // Ambil lamaran mahasiswa yang diterima dan berelasi dengan dosen ini
        $mahasiswaDiterima = Lamaran::whereIn('user_id', $mahasiswaDibimbingIds)
            ->where('status', 'diterima') // Hanya yang diterima
            ->with(['user', 'mitra'])
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('dosen.magang_mhs', compact('mahasiswaDiterima'));
    }

    public function admin_mhs($encrypted_mitra_id)
    {
        $mitra_id = Crypt::decrypt($encrypted_mitra_id);

        // Ambil data mitra berdasarkan mitra_id
        $mitra = Mitra::findOrFail($mitra_id);

        // Ambil data mahasiswa yang diterima oleh mitra ini beserta dosennya
        $mahasiswaDiterima = Lamaran::where('mitra_id', $mitra_id)
            ->where('status', 'diterima')
            ->whereHas('mahasiswa') // Pastikan ada relasi mahasiswa di model Lamaran
            ->with(['mahasiswa.dosen']) // Ambil juga data dosen dari relasi mahasiswa
            ->get();

        // Kembalikan tampilan dengan data mitra dan mahasiswa
        return view('admin.admin_mhs', compact('mitra', 'mahasiswaDiterima'));
    }

    public function adminLaporan(Request $request, $encrypted_mahasiswa_id)
    {
        $mahasiswa_id = Crypt::decrypt($encrypted_mahasiswa_id);

        // Query dasar untuk laporan magang mahasiswa
        $query = Laporan::with(['mahasiswa', 'mitra']);

        // Jika $mahasiswa_id diberikan, tambahkan filter untuk mahasiswa tertentu
        if ($mahasiswa_id) {
            $query->where('user_id', $mahasiswa_id);
        }

        // Tambahkan filter jenis laporan jika tersedia
        if ($request->has('filter_jenis') && $request->filter_jenis) {
            $query->where('jenis_laporan', $request->filter_jenis);
        }

        // Paginasi hasil dengan 10 laporan per halaman
        $laporans = $query->paginate(10);

        return view('admin.admin_laporan', compact('laporans', 'mahasiswa_id'));
    }

    public function admin_magang()
    {
        // Ambil semua mitra yang memiliki mahasiswa dengan status 'diterima'
        $mitras = Mitra::whereHas('lamaran', function ($query) {
            $query->where('status', 'diterima');
        })->with(['lamaran' => function ($query) {
            $query->where('status', 'diterima')->whereHas('mahasiswa');
        }])->get();

        return view('admin.admin_magang', compact('mitras'));
    }

    public function updateNilai(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100', // Pastikan nilai dalam rentang 0-100
        ]);

        try {
            // Cari laporan berdasarkan ID
            $laporan = Laporan::findOrFail($id);

            // Perbarui nilai laporan
            $laporan->nilai = $request->input('nilai');
            $laporan->save();

            // Redirect kembali ke halaman laporan mitra dengan pesan sukses
            return redirect()->back()->with('success', 'Nilai berhasil diperbarui.');
        } catch (\Exception $e) {
            // Jika terjadi error, tampilkan pesan gagal
            return redirect()->back()->with('error', 'Gagal memperbarui nilai. Silakan coba lagi.');
        }
    }
}
