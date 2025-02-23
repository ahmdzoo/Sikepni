<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Lamaran;
use App\Models\Laporan;
use App\Models\LaporanAkhir;
use App\Models\Mitra;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class KordinatorController extends Controller
{
    public function dashboard()
    {
        $jumlahMitra = DB::table('mitras')->count(); // Menggunakan query builder
        $jumlahUser = DB::table('users')->count();
        $jumlahJurusan = DB::table('jurusans')->count();


        return view('kordinator.dashboard', compact('jumlahMitra', 'jumlahUser', 'jumlahJurusan'));
    }


    public function data_user(Request $request)
    {
        $data = User::query();
        if ($request->input('role')) {
            $data = $data->where('role', $request->role);
        }

        // Menangani pencarian
        if ($request->has('search') && !empty($request->search)) {
            $searchValue = $request->search;
            $data->where(function ($q) use ($searchValue) {
                $q->where('name', 'like', "%{$searchValue}%")
                    ->orWhere('email', 'like', "%{$searchValue}%")
                    ->orWhere('role', 'like', "%{$searchValue}%");
            });
        }

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addColumn('no', function ($data) {
                    return $data->DT_RowIndex;
                })
                ->addColumn('name', function ($data) {
                    return $data->name;
                })
                ->addColumn('email', function ($data) {
                    return $data->email;
                })
                ->addColumn('role', function ($data) {
                    return $data->role;
                })
                ->addColumn('jurusan', function ($data) {
                    return $data->role == 'mahasiswa' ? $data->jurusan : '-'; // Tampilkan jurusan jika mahasiswa
                })
                ->addColumn('nim', function ($data) {
                    return $data->role == 'mahasiswa' ? $data->nim : '-'; // Tampilkan NIM jika mahasiswa
                })
                ->addColumn('action', function ($data) {
                    return 'action'; // Tindakan untuk setiap baris (misalnya tombol edit/hapus)
                })
                ->make(true);
        }

        $jurusans = Jurusan::all();

        return view('kordinator.data_user', compact('jurusans'));
    }




    public function addUser()
    {
        return view('kordinator.add_user');
    }



    public function storeUser(Request $request)
    {
        // Mulai transaksi
        DB::beginTransaction();

        try {
            // Validasi data
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'role' => 'required|string',
                'password' => 'required|string|min:6',
            ]);

            // Validasi tambahan jika role adalah mahasiswa
            if ($request->role == 'mahasiswa') {
                $request->validate([
                    'jurusan' => 'required|string|max:255',
                    'nim' => 'required|numeric|unique:users,nim',
                ]);
            }

            // Menyimpan data user
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => bcrypt($request->password),
                'jurusan' => $request->jurusan ?? null, // Menyimpan jurusan jika ada
                'nim' => $request->nim ?? null, // Menyimpan nim jika ada
            ]);

            DB::commit();

            return redirect()->route('kordinator.data_user')->with('success', 'User added successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menambahkan user.'])->withInput();
        }
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|string',
            'password' => 'nullable|min:6', // Password optional
        ]);

        // Validasi tambahan jika role adalah mahasiswa
        if ($request->role == 'mahasiswa') {
            $request->validate([
                'jurusan' => 'required|string|max:255',
                'nim' => 'required|numeric|unique:users,nim,' . $id,
            ]);
        }

        // Update data
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        // Perbarui jurusan dan nim jika role adalah mahasiswa
        if ($request->role == 'mahasiswa') {
            $user->jurusan = $request->jurusan;
            $user->nim = $request->nim;
        }

        // Perbarui password jika diisi
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('kordinator.data_user')->with('success', 'User updated successfully');
    }


    public function deleteuser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('kordinator.data_user')->with('success', 'user deleted successfully');
    }

    public function kordinator_mhs($encrypted_mitra_id)
    {
        $mitra_id = Crypt::decrypt($encrypted_mitra_id);

        // Ambil data mitra berdasarkan mitra_id
        $mitra = Mitra::findOrFail($mitra_id);

        // Ambil data mahasiswa yang diterima oleh mitra ini
        $mahasiswaDiterima = Lamaran::where('mitra_id', $mitra_id)
            ->where('status', 'diterima')
            ->whereHas('mahasiswa') // Pastikan ada relasi mahasiswa di model Lamaran
            ->get();

        // Kembalikan tampilan dengan data mitra dan mahasiswa
        return view('kordinator.kordinator_mhs', compact('mitra', 'mahasiswaDiterima'));
    }

    public function kordinatorLaporan(Request $request, $encrypted_mahasiswa_id)
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

        return view('kordinator.kordinator_laporan', compact('laporans', 'mahasiswa_id'));
    }

    public function kordinator_magang()
    {
        // Ambil semua mitra yang memiliki mahasiswa dengan status 'diterima'
        $mitras = Mitra::whereHas('lamaran', function ($query) {
            $query->where('status', 'diterima');
        })->with(['lamaran' => function ($query) {
            $query->where('status', 'diterima')->whereHas('mahasiswa');
        }])->get();

        return view('kordinator.kordinator_magang', compact('mitras'));
    }

    public function kordinatorLaporanAkhir(Request $request, $encrypted_mahasiswa_id)
    {
        $mahasiswa_id = Crypt::decrypt($encrypted_mahasiswa_id);

        // Query dasar untuk laporan magang mahasiswa
        $query = LaporanAkhir::with(['mahasiswa', 'mitra']);

        // Jika $mahasiswa_id diberikan, tambahkan filter untuk mahasiswa tertentu
        if ($mahasiswa_id) {
            $query->where('user_id', $mahasiswa_id);
        }


        // Paginasi hasil dengan 10 laporan per halaman
        $LaporanAkhirs = $query->paginate(10);

        return view('kordinator.kordinator_LaporanAkhir', compact('LaporanAkhirs', 'mahasiswa_id'));
    }

    public function data_mitra(Request $request)
    {
        if ($request->ajax()) {
            // Mengambil data mitra
            $data = Mitra::with(['mitraUser', 'jurusan'])->select('mitras.*');

            // Menangani pencarian
            if ($request->has('search') && !empty($request->search)) {
                $searchValue = $request->search;
                $data->where(function ($q) use ($searchValue) {
                    $q->orWhereHas('mitraUser', function ($q) use ($searchValue) {
                        $q->where('name', 'like', "%{$searchValue}%");
                    })
                        ->orWhereHas('jurusan', function ($q) use ($searchValue) {
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

                ->addColumn('file_pks', function ($data) {
                    return $data->file_pks;
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

                ->addColumn('alamat', function ($data) {
                    return $data->alamat;
                })
                ->addColumn('kuota', function ($data) {
                    return $data->kuota;
                })
                ->editColumn('tanggal_mulai_magang', function ($mitra) {
                    return Carbon::parse($mitra->tanggal_mulai_magang)->format('Y-m-d'); // format sesuai kebutuhan
                })
                ->editColumn('tanggal_selesai_magang', function ($mitra) {
                    return Carbon::parse($mitra->tanggal_selesai_magang)->format('Y-m-d'); // format sesuai kebutuhan
                })
                ->addColumn('action', function ($data) {
                    return '
                        <a href="javascript:void(0)" class="edit btn btn-warning btn-sm" data-id="' . $data->id . '">Edit</a>
                        <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="' . $data->id . '">Delete</a>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // Jika bukan AJAX, kembalikan view data mitra
        return view('kordinator.data_mitra', [
            'mitras' => Mitra::with('jurusan')->get(),
            'mitrasMagang' => User::where('role', 'mitra_magang')->get(),
            'jurusans' => Jurusan::all(),
        ]);
    }

    public function jurusan(Request $request)
    {
        $data = Jurusan::query();



        if ($request->ajax()) {


            return DataTables::of($data)

                ->addColumn('no', function ($data) {
                    return $data->DT_RowIndex;
                })
                ->addColumn('name', function ($data) {
                    return $data->name;
                })
                ->addColumn('action', function ($data) {
                    return 'action';
                })
                ->make(true);
        }



        return view('kordinator.jurusan');
    }

    public function storeJurusan(Request $request)
    {
        // Mulai transaksi
        DB::beginTransaction();

        try {
            // Validasi data
            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            Jurusan::create([
                'name' => $request->name,
            ]);


            DB::commit();

            return redirect()->route('kordinator.jurusan')->with('success', 'Jurusan added successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menambahkan Jurusan.'])->withInput();
        }
    }






    // Metode untuk mendapatkan list jurusan
    public function list()
    {
        $jurusans = Jurusan::all();
        return response()->json($jurusans);
    }

    public function editJurusan($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return response()->json($jurusan);
    }

    public function updateJurusan(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $jurusan = Jurusan::findOrFail($id);
        $jurusan->update([
            'name' => $request->name,
        ]);

        return redirect()->route('kordinator.jurusan')->with('success', 'Jurusan updated successfully');
    }

    public function deleteJurusan($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();

        return redirect()->route('kordinator.jurusan')->with('success', 'Jurusan deleted successfully');
    }

    public function data_dosen()
    {
        $dosen = User::where('role', 'dosen_pembimbing')->with('mahasiswa')->get();
        $mahasiswa = User::where('role', 'mahasiswa')->whereDoesntHave('dosen')->get(); // Mahasiswa tanpa dosen

        return view('kordinator.data_dosen', compact('dosen', 'mahasiswa'));
    }

    public function assignDosen(Request $request)
    {
        $request->validate([
            'dosen_id' => 'required|exists:users,id',
            'mahasiswa_id' => 'required|exists:users,id',
        ]);

        $dosen = User::findOrFail($request->dosen_id);
        $mahasiswa = User::findOrFail($request->mahasiswa_id);

        // Cek apakah mahasiswa sudah memiliki dosen
        if ($mahasiswa->dosen()->exists()) {
            return redirect()->route('kordinator.data_dosen')->with('error', 'Mahasiswa sudah memiliki dosen.');
        }

        $dosen->mahasiswa()->attach($mahasiswa->id);

        return redirect()->route('kordinator.data_dosen')->with('success', 'Mahasiswa berhasil direlasikan dengan dosen.');
    }
}
