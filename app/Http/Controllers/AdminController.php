<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function data_user()
    {
        // Logika untuk data user
        return view('admin.data_user');
    }
}
