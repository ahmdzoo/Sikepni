@extends('layouts.admin.app')

@section('breadcumb', 'Dashboard')
@section('page-title', 'Koordinator Magang')

@section('content')
<!-- Mitra -->
<div class="row">
  <!-- Total Mitra Magang -->
  <div class="col-md-4 col-lg-4 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h4 class="card-title m-0 me-2">{{ $jumlahMitra ?? 0 }}</h4>
      </div>
      <div class="card-body">
        <h6 class="card-title">Total Mitra Magang</h6>
        <br>
        <a href="{{ route('kordinator.data_mitra') }}" class="btn btn-outline-primary w-100">Lihat Detail</a>
      </div>
    </div>
  </div>

  <!-- Total User -->
  <div class="col-md-4 col-lg-4 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h4 class="card-title m-0 me-2">{{ $jumlahUser ?? 0 }}</h4>
      </div>
      <div class="card-body">
        <h6 class="card-title">Total User</h6>
        <br>
        <a href="{{ route('kordinator.data_user') }}" class="btn btn-outline-primary w-100">Lihat Detail</a>
      </div>
    </div>
  </div>

  <!-- Total Jurusan -->
  <div class="col-md-4 col-lg-4 mb-4">
    <div class="card h-100">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h4 class="card-title m-0 me-2">{{ $jumlahJurusan ?? 0 }}</h4>
      </div>
      <div class="card-body">
        <h6 class="card-title">Total Jurusan</h6>
        <br>
        <a href="{{ route('kordinator.jurusan') }}" class="btn btn-outline-primary w-100">Lihat Detail</a>
      </div>
    </div>
  </div>
</div>
@endsection
