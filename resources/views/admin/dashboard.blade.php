@extends('layouts.budede.app')

@section('breadcumb', 'Dashboard')
@section('page-title', 'Admin')

@section('content')

@if($expiredMitra->count() > 0)
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Perhatian!</strong> <br>
        <small>Ada {{ $expiredMitra->count() }} Mitra yang Masa Kerjasamanya telah berakhir.</small>
        <ul>
            @foreach($expiredMitra as $mitra)
            <li>{{ $mitra->mitraUser->name }} - Kerjasama Berakhir pada: {{ \Carbon\Carbon::parse($mitra->tgl_selesai)->format('d M Y') }}</li>
            @endforeach
        </ul>
    </div>
    @endif

<!-- Mitra -->
<div class="row">
          <div class="col-md-4 col-lg-4 mb-4">
            <div class="card h-100">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="card-title m-0 me-2">{{ $jumlahMitra ?? 0 }}</h4>
              </div>
              <div class="card-body">
                <h6 class="card-title">Total Mitra Magang</h6>
                <br>
              <a href="{{ route('data_mitra') }}" class="btn btn-outline-primary w-100">Lihat Detail</a>
              </div>
            </div>
          </div>
    </div>
  </div>
@endsection
