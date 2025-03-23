@extends('layouts.dosen')
@section('content')
<style>

</style>

<div class="content-wrapper" style="min-height: 100vh;">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-4" style="font-size: 30px; color: white; font-weight: bold;">Dashboard Dosen Pembimbing</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row m-4">
                <div class="col-lg-3  col-md-6">
                    <div class="small-box">
                        <a href="{{ route('dosen.magang_mhs') }}">
                            <div class="inner">
                                <h3>{{ $jumlahMahasiswa }}</h3>
                                <p>Mahasiswa</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3  col-md-6">
                    <div class="small-box">
                        <a href="{{ route('dosen.magang_mhs') }}">
                            <div class="inner">
                                <h3>{{ $laporanMagang }}</h3>
                                <p>Laporan</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3  col-md-6">
                    <div class="small-box">
                        <a href="{{ route('dosen.magang_mhs') }}">
                            <div class="inner">
                                <h3>{{ $laporanAkhir }}</h3>
                                <p>Laporan Akhir</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@include('layouts/footer')
@endsection