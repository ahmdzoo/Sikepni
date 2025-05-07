@extends('layouts.mahasiswa.app')

@section('breadcumb', 'Menu /')
@section('page-title', 'Status Pengajuan')

@section('content')
  @if($lamarans->count() > 0)
    <div class="card mb-4">
      <div class="card-body">
        <h5 class="card-title">Status Pengajuan</h5>
        <div class="table-responsive text-nowrap">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Mitra</th>
                <th>CV</th>
                <th>Tanggal Pengajuan</th>
                <th>Keterangan</th>
                <th>Alasan</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              @foreach($lamarans as $index => $lamaran)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $lamaran->user->name }}</td>
                  <td>{{ $lamaran->mitra->mitraUser->name }}</td>
                  <td>
                    <a href="{{ asset('storage/' . $lamaran->cv_path) }}" target="_blank">
                      Lihat CV
                    </a>
                  </td>
                  <td>{{ \Carbon\Carbon::parse($lamaran->created_at)->format('d-m-Y') }}</td>
                  <td>
                    @if($lamaran->status === 'diterima')
                      <span class="badge bg-success">DITERIMA</span>
                    @elseif($lamaran->status === 'ditolak')
                      <span class="badge bg-danger">DITOLAK</span>
                    @else
                      <span class="badge bg-warning text-dark">DIPROSES</span>
                    @endif
                  </td>
                  <td>
                    @if($lamaran->status === 'diterima')
                      {{ $lamaran->alasan_acc }}
                    @elseif($lamaran->status === 'ditolak')
                      {{ $lamaran->alasan_penolakan }}
                    @else
                      -
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  @else
    {{-- Jika belum memiliki pengajuan --}}
    <div class="row mb-5">
      <div class="col-md">
        <div class="card mb-3">
          <div class="row g-0">
            <div class="col-md-4">
              <img 
                class="card-img card-img-left" 
                src="{{ asset('images/img/illustrations/error.jpg') }}" 
                alt="Card image"
                style="width: 60%; display: block; margin: auto;" 
              />
            </div>
            <div class="col-md-8">
              <div class="card-body d-flex flex-column justify-content-center">
                <div class="alert alert-warning" role="alert">
                  Status Pengajuan Magang Tidak Ditemukan
                </div>
                <h3 class="card-title">Anda Belum Melakukan Pengajuan Magang</h3>
                <p class="card-text">
                  Status pengajuan magang akan tampil saat Anda sudah terverifikasi oleh Mitra Magang.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif
@endsection
