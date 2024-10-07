<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class homepageController extends Controller
{
    public function show_homepage() {
        return view('homepage.landing-page');
    }

    public function show_moa() {
        return view('homepage.moa');
    }

    public function show_mou() {
        return view('homepage.mou');
    }

    public function show_ia() {
        return view('homepage.ia');
    }
}
