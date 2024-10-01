<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

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
        // Filter berdasarkan role jika ada
        $roleFilter = $request->input('role');
        $users = User::when($roleFilter, function ($query, $roleFilter) {
            return $query->where('role', $roleFilter);
        })->paginate(10);

        return view('admin.data_user', compact('users', 'roleFilter'));
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('data_user')->with('success', 'User deleted successfully');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit_user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->only('name', 'email', 'role'));
        return redirect()->route('data_user')->with('success', 'User updated successfully');
    }

    public function addUser()
    {
        return view('admin.add_user');
    }

    public function storeUser(Request $request)
    {
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

        return redirect()->route('data_user')->with('success', 'User added successfully');
    }

        
}
