@extends('layouts.mhs')

@section('content')

<div class="content-wrapper" style=" min-height: 100vh;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-4" style="font-size: 30px; color: white; font-weight: bold;">Dashboard Mahasiswa</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row row-cols-1 row-cols-md-3 g-4 m-4 card-responsive">
                <!-- Row for Mitra Magang and Dosen Pembimbing -->
                <div class="col-md-6">
                    <div class="small-box">
                        <div class="inner">
                            <span class="h3-like">
                                @if (isset($mitras) && $mitras->isNotEmpty())
                                    {{ $mitras->first()->mitraUser->name }}
                                @else
                                    Tidak ada mitra
                                @endif
                            </span>
                            <p>
                                Mitra Magang
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="small-box">
                        <div class="inner">
                            <span class="h3-like">
                                @if (isset($mitras) && $mitras->isNotEmpty())
                                    {{ $mitras->first()->dosenPembimbing->name }}
                                @else
                                    Tidak ada dosen
                                @endif
                            </span>
                            <p>
                                Dosen Pembimbing
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Row for the remaining cards -->
            <div class="row row-cols-1 row-cols-md-3 g-4 m-4">
                
                <!-- Total Lamaran Diajukan -->
                <div class="col">
                    <div class="small-box">
                        <a href="{{ route('mhs_lowongan') }}">
                        <div class="inner">
                            <h3>{{ $totalMitra }}</h3>
                            <p>Lowongan Magang</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        </a>
                    </div>
                </div>
                
                <!-- Total Lamaran Pending -->
                <div class="col">
                    <div class="small-box">
                        <a href="{{ route('mahasiswa.status_lamaran') }}">
                        <div class="inner">
                            <h3>{{ $totalLamaranPending }}</h3>
                            <p>Pengajuan Magang</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        </a>
                    </div>
                </div>
                
                <!-- Total Lamaran Diterima -->
                <div class="col">
                    <div class="small-box">
                        <a href="{{ route('mahasiswa.status_lamaran') }}">
                        <div class="inner">
                            <h3>{{ $totalLamaranDiterima }}</h3>
                            <p>Pengajuan Magang Diterima</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        </a>
                    </div>
                </div>
                <!-- Total Laporan Magang -->
                <div class="col">
                    <div class="small-box">
                        <a href="{{ route('mahasiswa.aktifitas') }}">
                        <div class="inner">
                            <h3>{{ $totalLaporan }}</h3>
                            <p>Total Laporan Magang</p>
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

@include('layouts.footer')

@endsection

@push('styles')
<style>
   
</style>
@endpush

