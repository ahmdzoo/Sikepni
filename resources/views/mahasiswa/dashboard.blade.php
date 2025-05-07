@extends('layouts.mahasiswa.app')

@section('breadcumb', 'Dashboard')
@section('page-title', 'Mahasiswa')

@section('content')

<div class="row">
  <div class="col-lg-6 mb-4">
    <div class="card">
      <div class="d-flex align-items-end row">
        <div class="col-sm-7">
          <div class="card-body">
            <h5 class="card-title text-primary" style="font-size: 1rem;">
                @if (isset($mitras) && $mitras->isNotEmpty())
                {{ $mitras->first()->mitraUser->name }}
                @else
                Tidak ada mitra
                @endif
            </h5>
            <p class="mb-4">Mitra Magang</p>
            <a href="javascript:;" class="btn btn-sm btn-primary">Lihat Detail</a>
          </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-4">
            <img
              src="{{ asset('images/img/illustrations/14.jpg') }}"
              height="140"
              alt="View Badge User"
              data-app-dark-img="illustrations/man-with-laptop-dark.png"
              data-app-light-img="illustrations/man-with-laptop-light.png"/>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Dosen Pembimbing -->
  <div class="col-lg-6 mb-4">
    <div class="card">
      <div class="d-flex align-items-end row">
        <div class="col-sm-7">
          <div class="card-body">
            <h5 class="card-title text-primary" style="font-size: 1rem;">
                @if (isset($dosen) && $dosen->isNotEmpty())
                {{ $dosen->first()->name }}
                @else
                Tidak ada dosen pembimbing
                @endif
            </h5>
            <p class="mb-4">Dosen Pembimbing</p>
            <a href="javascript:;" class="btn btn-sm btn-primary">Lihat Detail</a>
          </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-4">
            <img
              src="{{ asset('images/img/illustrations/13.png') }}"
              height="140"
              alt="View Badge User"
              data-app-dark-img="illustrations/man-with-laptop-dark.png"
              data-app-light-img="illustrations/man-with-laptop-light.png"/>
          </div>
        </div>
      </div>
    </div>
  </div>


        <!-- Lowongan Magang -->
          <div class="col-md-4 col-lg-4 mb-4">
            <div class="card h-100">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="card-title m-0 me-2">{{ $totalMitra }}</h4>
              </div>
              <div class="card-body">
                <h6 class="card-title">Lowongan Magang</h6>
                <br>
              <a href="{{ route('mhs_lowongan') }}" class="btn btn-outline-primary w-100">Lihat Detail</a>
              </div>
            </div>
          </div>
                
        <!-- Pengajuan Magang -->
        <div class="col-md-4 col-lg-4 mb-4">
          <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
              <h4 class="card-title m-0 me-2">{{ $totalLamaranPending }}</h4>
            </div>
            <div class="card-body">
              <h6 class="card-title">Pengajuan Magang</h6>
              <br>
            <a href="{{ route('mahasiswa.status_lamaran') }}" class="btn btn-outline-primary w-100">Lihat Detail</a>
            </div>
          </div>
        </div>
  
        <!-- Pengajuan Magang diterima -->
        <div class="col-md-4 col-lg-4 mb-4">
          <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between">
              <h4 class="card-title m-0 me-2">{{ $totalLamaranDiterima }}</h4>
            </div>
          <div class="card-body">
            <h6 class="card-title">Pengajuan magang diterima</h6>
              <br>
            <a href="{{ route('mahasiswa.status_lamaran') }}" class="btn btn-outline-primary w-100">Lihat Detail</a>
          </div>
        </div>
      </div>

      <!-- Total Laporan Magang -->
      <div class="col-md-4 col-lg-4 mb-4">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h4 class="card-title m-0 me-2">{{ $totalLaporan }}</h4>
          </div>
        <div class="card-body">
          <h6 class="card-title">Total Laporan Magang</h6>
            <br>
          <a href="{{ route('mahasiswa.aktifitas') }}" class="btn btn-outline-primary w-100">Lihat Detail</a>
        </div>
      </div>
    </div>
    <!-- Total Laporan Magang -->
    <div class="col-md-4 col-lg-4 mb-4">
      <div class="card h-100">
        <div class="card-header d-flex align-items-center justify-content-between">
          <h4 class="card-title m-0 me-2">{{ $totalLaporanAkhir }}</h4>
        </div>
      <div class="card-body">
        <h6 class="card-title">Laporan Akhir Magang</h6>
          <br>
        <a href="{{ route('mahasiswa.LaporanAkhir') }}" class="btn btn-outline-primary w-100">Lihat Detail</a>
      </div>
    </div>
  </div>
@endsection