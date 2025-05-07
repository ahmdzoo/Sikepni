@extends('layouts.dosen.app')

@section('breadcumb', 'Dashboard')
@section('page-title', 'Dosen Pembimbing')

@section('content')

    <!-- Mahasiswa -->
    <div class="row">
      <div class="col-md-4 col-lg-4 mb-4">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h4 class="card-title m-0 me-2">Mahasiswa</h4>
          </div>
          <div class="card-body">
            <h6 class="card-title">Mahasiswa Magang</h6>
            <p class="card-text">{{ $jumlahMahasiswa }}</p>
            <a href="{{ route('dosen.magang_mhs') }}" class="btn btn-outline-primary w-100 mt-3">Lihat Detail</a>
          </div>
        </div>
      </div>
  
      <!-- Laporan -->
      <div class="col-md-4 col-lg-4 mb-4">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h4 class="card-title m-0 me-2">Laporan</h4>
          </div>
          <div class="card-body">
            <h6 class="card-title">Laporan Magang Mahasiswa</h6>
            <p class="card-text">{{ $laporanMagang }}</p>
            <a href="{{ route('dosen.magang_mhs') }}" class="btn btn-outline-primary w-100 mt-3">Lihat Detail</a>
          </div>
        </div>
      </div>
  
      <!-- Laporan Akhir -->
      <div class="col-md-4 col-lg-4 mb-4">
        <div class="card h-100">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h4 class="card-title m-0 me-2">Laporan Akhir</h4>
          </div>
          <div class="card-body">
            <h6 class="card-title">Laporan Akhir Magang Mahasiswa</h6>
            <p class="card-text">{{ $laporanAkhir }}</p>
            <a href="{{ route('dosen.magang_mhs') }}" class="btn btn-outline-primary w-100 mt-3">Lihat Detail</a>
          </div>
        </div>
      </div>
      
    </div>
    
@endsection
