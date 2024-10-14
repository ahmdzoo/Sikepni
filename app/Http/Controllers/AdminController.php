<?php

namespace App\Http\Controllers;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB; 

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard'); // Pastikan Anda memiliki view ini
    }

    public function data_mitra()
    {
        // Logika untuk data mitra
        return view('admin.data_mitra');
    }

    
    public function data_user(Request $request)
    {
        $data = User::query();
            if ($request->input('role')){
               
                $data= $data->where('role',$request->role);
            }

            // Menangani pencarian
            if ($request->has('search') && !empty($request->search)) {
                $searchValue = $request->search;
                $data->where(function($q) use ($searchValue) {
                    $q->where('name', 'like', "%{$searchValue}%")
                      ->orWhere('email', 'like', "%{$searchValue}%")
                      ->orWhere('role', 'like', "%{$searchValue}%");
                });
            }
            
        
        if($request->ajax()){
            

            return DataTables::of($data)
            
            ->addColumn('no', function($data){
                return $data->DT_RowIndex;
            })
            ->addColumn('name', function($data){
                return $data->name;
            })
            ->addColumn('email', function($data){
                return $data->email;
            })
            ->addColumn('role', function($data){
                return $data->role;
            })
            ->addColumn('action', function($data){
                return 'action';
            })
            ->make(true);
        }

        

        return view('admin.data_user');
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
                'password' => 'required|string|min:8',
            ]);
    
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => bcrypt($request->password),
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
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
        ]);

        return redirect()->route('data_user')->with('success', 'User updated successfully');
    }

    public function deleteuser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('data_user')->with('success', 'user deleted successfully');
    }
    

        
}
