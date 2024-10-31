@extends('layouts.mitra')
@section('content')
<div class="content-wrapper" style="background: linear-gradient(to bottom, #80b8c7, #ffffff); min-height: 100vh;">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-4" style="font-size: 50px; color: white; font-weight: bold;">Mahasiswa Magang</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid text-center">
        @if($mahasiswaDiterima->isEmpty())
        <div class="no-data-container">
            <img src="{{ asset('gambar/empty.png') }}" alt="Gambar Illustrasi" class="no-data-image mb-3">
            <p class="no-data-text">Anda tidak memiliki mahasiswa magang.</p>
        </div>
        @else
            <div class="row">
                @foreach($mahasiswaDiterima as $item)
                    <div class="col-md-3 mb-4">
                        <div class="card text-center shadow-sm" style="border-radius: 15px;">
                            <div class="card-header bg-transparent text-left" style="font-size: 12px; color: #6c757d;">
                                <small>Diterima:</small>
                                <span>{{ \Carbon\Carbon::parse($item->updated_at)->format('d M, Y') }}</span>
                            </div>
                            <div class="card-body d-flex flex-column align-items-center">
                                <h5 class="card-title text-center" style="font-weight: 600; color: #333; margin-top: 10px;">{{ $item->mahasiswa->name }}</h5>
                                <p class="card-text text-muted" style="font-size: 14px;">Mahasiswa</p>
                                <a href="{{ route('mitra.laporan', ['mahasiswa_id' => $item->mahasiswa->id]) }}" class="btn btn-flip btn-flip-harian btn-block mb-2">Laporan Magang Harian &rsaquo;</a>
                                <a href="#" class="btn btn-flip btn-flip-akhir btn-block">Laporan Akhir &rsaquo;</a>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@include('layouts.footer')

<style>
    
</style>
@endsection
