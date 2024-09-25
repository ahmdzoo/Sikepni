<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DosenPembimbingController extends Controller
{
    public function dashboard()
    {
        return view('dosen.dashboard'); // Pastikan Anda memiliki view ini
    }
}
