@extends('layouts.mhs')
@section('title', 'Aktifitas Magang | SIKEPNI')

@section('content')
<div class="content-wrapper" style=" min-height: 100vh;">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-12 text-left">
                    <h1 class="m-4" style="font-size: 30px; color: #fff; font-weight: bold;">
                        Aktifitas Magang
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        @if(!$lamaran)
        <div class="alert alert-warning text-center">
            Anda Belum Memiliki Mitra Magang.
        </div>
        @else
        <div class="card mb-4" style="background: #f8f9fa; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
            <div class="card-body">
                <h3 class="card-title" style="font-weight: bold; color: #333;">{{ $lamaran->mitra->mitraUser->name }}</h3>
                <p class="card-text" style="color: #555;">
                    Dosen Pembimbing:
                    @if (isset($dosen) && $dosen->isNotEmpty())
                    {{ $dosen->first()->name }}
                    @else
                    Tidak ada dosen pembimbing
                    @endif
                </p>
            </div>
            <div class="card-footer d-flex flex-wrap justify-content-center">
                <a href="{{ route('mahasiswa.aktifitas') }}" class="btn btn-primary m-2" style="flex: 1; min-width: 150px;">Laporan Magang <i class="fas fa-arrow-circle-right"></i></a>
                <a href="{{ route('mahasiswa.LaporanAkhir') }}" class="btn btn-secondary m-2" style="flex: 1; min-width: 150px;">Laporan Akhir <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        @endif
    </div>
</div>
@include('layouts.footer')
@endsection