<?php

namespace App\Http\Controllers;

use App\Models\InfoMitra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfoMitraController extends Controller
{
    public function index()
    {
        $mitra = InfoMitra::all();
        return view('mahasiswa.mhs_lowongan', compact('mitra'));
    }
}
// Menggunakan Eloquent untuk mengambil semua mitra
$mitraList = InfoMitra::all();
// Menggunakan Query Builder
$mitraList = DB::table('mitra')->get();

