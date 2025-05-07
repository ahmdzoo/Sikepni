@extends('layouts.admin.app')

@section('breadcumb', 'Menu /')
@section('page-title', 'Laporan Magang')

@section('content')

@if($mitras->isEmpty())
    <div class="alert alert-warning text-center">
        Tidak Ada Mitra Dengan Mahasiswa Yang Diterima.
    </div>
@else
<!-- Mitra -->
    <div class="row">
        @foreach ($mitras as $mitra)
          <div class="col-md-4 col-lg-4 mb-4">
            <div class="card h-100">
              <div class="card-header d-flex align-items-center justify-content-between">
                <h4 class="card-title m-0 me-2">{{ $mitra->mitraUser->name }}</h4>
              </div>
              <div class="card-body">
              <a  href="{{ route('kordinator.kordinator_mhs',['mitra_id' => Crypt::encrypt($mitra->id)]) }}" class="btn btn-outline-primary w-100">Lihat Detail</a>
              </div>
            </div>
          </div>
        @endforeach       
      </div>
@endif
@endsection

