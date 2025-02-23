@extends('layouts.kordinator')
@section('title', 'Aktifitas Magang | SIKEPNI')

@section('content')
<div class="content-wrapper" style="min-height: 100vh;">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-4">
                <div class="col-sm-12 text-left">
                    <h1 class="m-4" style="font-size: 30px; color: #fff; font-weight: bold;">
                        Laporan Magang
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        @if($mitras->isEmpty())
            <div class="alert alert-warning text-center">
                Tidak Ada Mitra Dengan Mahasiswa Yang Diterima.
            </div>
        @else
            @foreach ($mitras as $mitra)
                <div class="card mb-4" style="background: #f8f9fa; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
                    <a href="{{ route('kordinator.kordinator_mhs',['mitra_id' => Crypt::encrypt($mitra->id)]) }}">
                    <div class="card-body">
                        <h3 class="card-title" style="font-weight: bold; color: #333;">{{ $mitra->mitraUser->name }}</h3>
                        <p class="card-text" style="color: #555;">Dosen</p>
                    </div>
                    </a>
                </div>
            @endforeach
        @endif
    </div>
</div>
@include('layouts.footer')
@endsection
