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

    <div class="container-fluid">
        @if($mitras->isEmpty())
            <div class="alert alert-warning text-center">
                Tidak Ada Mitra Dengan Mahasiswa Yang Diterima.
            </div>
        @else
        <div class="row m-4">
            @foreach ($mitras as $mitra)
                <div class="col-md-4 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-transparent text-left" style="font-size: 12px; color: #6c757d;">
                            <span>Mitra Magang</span>
                        </div>
                        <div class="card-body p-3 overflow-hidden">
                            <h6 class="card-title text-truncate" style="font-weight: 600; max-width: 100%;">
                                {{ $mitra->mitraUser->name }}
                            </h6>
                            <div class="d-flex gap-2 mt-5">
                                <a href="{{ route('kordinator.kordinator_mhs',['mitra_id' => Crypt::encrypt($mitra->id)]) }}" class="btn btn-primary">Lihat</a>
                            </div>
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
