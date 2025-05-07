@extends('layouts.mahasiswa.app')

@section('breadcumb', 'Menu /')
@section('page-title', 'Aktivitas Magang')

@section('content')

  <div class="row">
    <div class="col-12">
      <div class="card p-4">

        @if (!$lamaran || !$lamaran->mitra || !$lamaran->mitra->mitraUser)
          <div class="alert alert-warning text-center">
            <strong>Anda belum memiliki Mitra Magang</strong>
          </div>
        @else
          <div class="d-flex align-items-center row">
            <div class="col-sm-7">
              <div class="card-body">
                <h4 class="card-title text-primary">{{ $lamaran->mitra->mitraUser->name }}</h4>
                <p class="mb-4">
                  Dosen Pembimbing:
                  @if (isset($dosen) && $dosen->isNotEmpty())
                    {{ $dosen->first()->name }}
                  @else
                    Tidak ada dosen pembimbing
                  @endif
                </p>
                <a href="{{ route('mahasiswa.aktifitas') }}" class="btn btn-primary w-100 mb-2">Laporan Magang</a>
                <a href="{{ route('mahasiswa.LaporanAkhir') }}" class="btn btn-secondary w-100">Laporan Akhir</a>
              </div>
            </div>
            <div class="col-sm-5 d-flex justify-content-end">
              <div class="card-body pb-0 px-0 text-center">
                <img
                  src="{{ asset('images/img/illustrations/activity.png') }}"
                  style="max-width: 60%; height: auto; object-fit: contain;"
                  alt="View Badge User"
                  data-app-dark-img="illustrations/man-with-laptop-dark.png"
                  data-app-light-img="illustrations/man-with-laptop-light.png"/>
              </div>
            </div>
          </div>
        @endif

      </div>
    </div>
  </div>

@endsection
