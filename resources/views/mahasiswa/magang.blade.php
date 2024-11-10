@extends('layouts.mhs')
@section('title', 'Aktifitas Magang | SIKEPNI')

@section('content')
<div class="content-wrapper" style="background: linear-gradient(to bottom, #80b8c7, #ffffff); min-height: 100vh;">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-12 text-left">
                    <h1 class="m-4" style="font-size: 40px; color: #fff; font-weight: bold; text-shadow: 1px 1px 2px #333;">
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
            <div class="small-box mb-4">
                <div class="inner">
                    <h3>{{ $lamaran->mitra->mitraUser->name }}</h3>
                    <p>Dosen Pembimbing: {{ $lamaran->mitra->dosenPembimbing->name }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-graduate"></i> <!-- Anda bisa mengganti dengan ikon yang sesuai -->
                </div>
                <a href="{{ route('mahasiswa.aktifitas') }}" class="small-box-footer">Laporan Magang <i class="fas fa-arrow-circle-right"></i></a>
                <a href="{{ route('mahasiswa.LaporanAkhir') }}" class="small-box-footer">Laporan Akhir <i class="fas fa-arrow-circle-right"></i></a>

            </div>
        @endif
    </div>
</div>
@include('layouts.footer')
@endsection
