<?php

namespace App\Http\Controllers;

use App\Models\Lamaran;
use App\Models\Mitra;
use Illuminate\Http\Request;

class DosenPembimbingController extends Controller
{
    public function dashboard()
    {
        return view('dosen.dashboard'); // Pastikan Anda memiliki view ini
    }

    // Di DosenPembimbingController
    public function dosen_lamaran()
    {
        $user = auth()->user();
        // Ambil mitra yang terkait dengan dosen pembimbing
        $mitras = Mitra::where('dosen_pembimbing_id', $user->id)->pluck('id');

        // Ambil lamaran yang terkait dengan mitra
        $lamarans = Lamaran::whereIn('mitra_id', $mitras)->with('user')->get();

        return view('dosen.dosen_lamaran', compact('lamarans'));
    }

}
