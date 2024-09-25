<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MitraMagangController extends Controller
{
    public function dashboard()
    {
        return view('mitra.dashboard'); // Pastikan Anda memiliki view ini
    }
}
