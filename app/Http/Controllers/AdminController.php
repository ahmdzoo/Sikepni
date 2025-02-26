<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Mitra;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $jumlahMitra = DB::table('mitras')->count(); // Menggunakan query builder
        $jumlahUser = DB::table('users')->count();
        $jumlahJurusan = DB::table('jurusans')->count();

        $mitras = Mitra::all(); // Ambil semua mitra
        $now = Carbon::now(); // Ambil tanggal hari ini

        // Cek mitra yang tanggal selesai PKS sudah habis atau mencapai batasnya
        $expiredMitra = $mitras->filter(function ($mitra) use ($now) {
            return $mitra->tgl_selesai <= $now;
        });


        return view('admin.dashboard', compact('jumlahMitra', 'jumlahUser', 'jumlahJurusan', 'expiredMitra'));
    }






    public function data_mitra()
    {
        // Logika untuk data mitra
        return view('admin.data_mitra');
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

        return view('admin.data_user', compact('jurusans'));
    }




    public function addUser()
    {
        return view('admin.add_user');
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

            return redirect()->route('data_user')->with('success', 'User added successfully');
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

        return redirect()->route('data_user')->with('success', 'User updated successfully');
    }


    public function deleteuser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('data_user')->with('success', 'user deleted successfully');
    }

    public function data_dosen()
    {
        $dosen = User::where('role', 'dosen_pembimbing')->with('mahasiswa')->get();
        $mahasiswa = User::where('role', 'mahasiswa')->whereDoesntHave('dosen')->get(); // Mahasiswa tanpa dosen

        return view('admin.data_dosen', compact('dosen', 'mahasiswa'));
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
            return redirect()->route('data_dosen')->with('error', 'Mahasiswa sudah memiliki dosen.');
        }

        $dosen->mahasiswa()->attach($mahasiswa->id);

        return redirect()->route('data_dosen')->with('success', 'Mahasiswa berhasil direlasikan dengan dosen.');
    }
}
