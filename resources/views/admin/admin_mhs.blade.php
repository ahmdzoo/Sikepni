@extends('layouts.main')
@section('title', 'Mahasiswa Magang | SIKEPNI')

@section('content')
<div class="content-wrapper" style="min-height: 100vh;">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-4" style="font-size: 30px; color: white; font-weight: bold;">Mahasiswa Magang</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid text-center">
        @if($mahasiswaDiterima->isEmpty())
        <div class="no-data-container">
            <img src="{{ asset('gambar/empty.png') }}" alt="Gambar Illustrasi" class="no-data-image mb-3">
            <p class="no-data-text">Tidak ada mahasiswa magang yang diterima oleh mitra ini.</p>
        </div>
        @else
            <div class="row">
                @foreach($mahasiswaDiterima as $item)
                    <div class="col-md-3 mb-4">
                        <div class="card text-center shadow-sm" style="border-radius: 15px;">
                            <div class="card-header bg-transparent text-left" style="font-size: 12px; color: #6c757d;">
                                <span>{{ $item->mitra->mitraUser->name }}</span>
                            </div>
                            <div class="card-body d-flex flex-column align-items-center">
                                <h5 class="card-title text-center" style="font-weight: 600; color: #333; margin-top: 10px;">{{ $item->mahasiswa->name }}</h5>
                                <p class="card-text text-muted" style="font-size: 14px;">Mahasiswa</p>
                                <a href="{{ route('admin.laporan', ['mahasiswa_id' => $item->mahasiswa->id]) }}" class="btn btn-flip btn-flip-harian btn-block mb-2">Laporan Magang &rsaquo;</a>
                                <a href="{{ route('admin.LaporanAkhir', ['mahasiswa_id' => $item->mahasiswa->id]) }}" class="btn btn-flip btn-flip-akhir btn-block">Laporan Akhir &rsaquo;</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@include('layouts.footer')
@endsection