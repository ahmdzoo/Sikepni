@extends('layouts.budede.app')

@section('breadcumb', 'Menu /')
@section('page-title', 'Laporan Magang')

@section('content')

@if($mahasiswaDiterima->isEmpty())
        <div class="no-data-container">
            <img src="{{ asset('gambar/empty.png') }}" alt="Gambar Illustrasi" class="no-data-image mb-3">
            <p class="no-data-text">Tidak ada mahasiswa magang yang diterima oleh mitra ini.</p>
        </div>
        @else
        <div class="row">
            @foreach($mahasiswaDiterima as $item)
              <div class="col-md-4 col-lg-4 mb-4">
                <div class="card h-100">
                  <div class="card-header d-flex align-items-center justify-content-between">
                    <h4 class="card-title m-0 me-2">{{ $item->mahasiswa->name }}</h4>
                  </div>
                  <div class="card-body">
                  <a href="{{ route('admin.laporan', ['mahasiswa_id' => Crypt::encrypt($item->mahasiswa->id)]) }}" class="btn btn-outline-primary w-100">Laporan Magang</a>
                  <a href="{{ route('admin.LaporanAkhir', ['mahasiswa_id' => Crypt::encrypt($item->mahasiswa->id)]) }}" class="btn btn-outline-primary w-100">Laporan Akhir</a>
                  </div>
                </div>
              </div>
            @endforeach       
        </div>
        @endif
@endsection
