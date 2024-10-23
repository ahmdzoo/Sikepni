<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\Mitra;
use App\Models\User;
use App\Models\Jurusan;
use Carbon\Carbon;

class MitraController extends Controller
{
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $query = Mitra::with(['mitraUser', 'jurusan']);

            if ($request->jurusan_id) {
                $query->where('jurusan_id', $request->jurusan_id);
            }

            $mitras = $query->get();

            return DataTables::of($mitras)
                ->addIndexColumn()
                ->addColumn('no_pks', function($data) {
                    return $data->no_pks;
                })
                ->editColumn('tgl_mulai', function ($mitra) {
                    return Carbon::parse($mitra->tgl_mulai)->format('Y-m-d');
                })
                ->editColumn('tgl_selesai', function ($mitra) {
                    return Carbon::parse($mitra->tgl_selesai)->format('Y-m-d');
                })
                ->addColumn('nama_mitra', function ($mitra) {
                    return $mitra->mitraUser ? $mitra->mitraUser->name : '-';
                })
                ->addColumn('jurusan', function ($mitra) {
                    return $mitra->jurusan ? $mitra->jurusan->name : '-';
                })
                ->make(true);
        }

        return abort(404);
    }

        public function index()
    {
        $jurusans = Jurusan::all(); // Ambil data semua jurusan
        return view('homepage.moa', compact('jurusans'));
    }



}
