@extends('layouts.dosen.app')
@section('breadcumb', 'Menu /')
@section('page-title', 'Mahasiswa Magang')

@section('content')

    <!-- Laporan Magang -->
    @if($mahasiswaDiterima->isEmpty())
        <div class="no-data-container">
            <img src="{{ asset('gambar/empty.png') }}" alt="Gambar Illustrasi" class="no-data-image mb-3">
            <p class="no-data-text">Anda tidak memiliki mahasiswa magang.</p>
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
                            <h6 class="card-title">{{ $item->mahasiswa->jurusan }}</h6>
                            <p class="card-text">
                                {{ $item->mahasiswa->nim }}
                            </p>
                            <br>
                            <div class="d-flex gap-2">
                                <a href="{{ route('dosen.laporan', ['mahasiswa_id' => Crypt::encrypt($item->mahasiswa->id)]) }}">
                                    <button type="button" class="btn btn-primary">Laporan Magang</button>
                                </a>
                                <a href="{{ route('dosen.LaporanAkhir', ['mahasiswa_id' => Crypt::encrypt($item->mahasiswa->id)]) }}">
                                    <button type="button" class="btn btn-secondary">Laporan Akhir</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@endsection
