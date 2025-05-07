@extends('layouts.admin.app')

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
                      <h6 class="card-title m-0 me-2 text-muted">{{ $item->mahasiswa->jurusan }}</h6>
                  </div>
                  <div class="card-body">
                      <h5 class="card-title">{{ $item->mahasiswa->name }}</h5>
                      <p class="card-text">{{ $item->mahasiswa->nim }}</p>
                  <br>
                  <div class="d-flex gap-2">
                  <a href="{{ route('kordinator.laporan', ['mahasiswa_id' => Crypt::encrypt($item->mahasiswa->id)]) }}" type="button" class="btn btn-primary">Laporan Magang</a>
                  <a href="{{ route('kordinator.LaporanAkhir', ['mahasiswa_id' => Crypt::encrypt($item->mahasiswa->id)]) }}" type="button" class="btn btn-secondary">Laporan Akhir</a>
                  </div>
                  </div>
              </div>
              </div>
            @endforeach       
        </div>
        @endif
@endsection

