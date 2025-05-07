@extends('layouts.mitra.app')

@section('breadcumb', 'Dashboard')
@section('page-title', 'Mitra')

@section('content')

<div class="row">
  <div class="col-lg-6 mb-4">
    <div class="card">
      <div class="d-flex align-items-end row">
        <div class="col-sm-7">
          <div class="card-body">
            <h5 class="card-title text-primary" style="font-size: 1.1rem;">Mahasiswa Magang</h5>
            <p class="mb-4">{{ $jumlahMahasiswaDiterima }}</p>
            <a href="{{ route('mitra.mahasiswa_diterima') }}" class="btn btn-sm btn-primary">Lihat Detail</a>
          </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-4">
            <img
              src="{{ asset('images/img/illustrations/14.jpg') }}"
              height="140"
              alt="View Badge User"
              data-app-dark-img="illustrations/man-with-laptop-dark.png"
              data-app-light-img="illustrations/man-with-laptop-light.png"/>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Dosen Pembimbing -->
  <div class="col-lg-6 mb-4">
    <div class="card">
      <div class="d-flex align-items-end row">
        <div class="col-sm-7">
          <div class="card-body">
            <h5 class="card-title text-primary" style="font-size: 1.1rem;">Pengajuan Magang</h5>
            <p class="mb-4">{{ $jumlahLamaran }}</p>
            <a href="{{ route('mitra_lamaran') }}" class="btn btn-sm btn-primary">Lihat Detail</a>
          </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
          <div class="card-body pb-0 px-0 px-md-4">
            <img
              src="{{ asset('images/img/illustrations/man-with-laptop-light.png') }}"
              height="140"
              alt="View Badge User"
              data-app-dark-img="illustrations/man-with-laptop-dark.png"
              data-app-light-img="illustrations/man-with-laptop-light.png"/>
          </div>
        </div>
      </div>
    </div>
  </div>

        <!-- Lowongan Magang -->
        <div class="col-md-4 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="card-title m-0 me-2">Laporan Magang Terbaru</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($laporanMagang as $index => $laporan)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $laporan->mahasiswa->name }}</td>
                                        <td>{{ $laporan->created_at->format('d-m-Y') }}</td>
                                        <td><a href="{{ route('mitra.laporan', ['mahasiswa_id' => Crypt::encrypt($laporan->mahasiswa->id)]) }}" class="btn btn-primary btn-sm">Lihat</a></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum Ada Laporan Magang</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                  </div>
                  
            </div>
        </div>

        <!-- Pengajuan Magang -->
        <div class="col-md-4 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="card-title m-0 me-2">Laporan Akhir</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($laporanAkhir as $index => $laporan)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $laporan->mahasiswa->name }}</td>
                                        <td>{{ $laporan->created_at->format('d-m-Y') }}</td>
                                        <td><a href="{{ route('mitra.LaporanAkhir', ['mahasiswa_id' => Crypt::encrypt($laporan->mahasiswa->id)]) }}" class="btn btn-primary btn-sm">Lihat</a></td>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum Ada Laporan Akhir Magang</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                  </div>
                  
            </div>
        </div>
        
  
        <!-- Pengajuan Magang diterima -->
        <div class="col-md-4 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h6 class="card-title m-0 me-2">Mahasiswa Magang</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="max-height: 200px; overflow-y: auto;">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mahasiswaDiterima as $index => $lamaran)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $lamaran->mahasiswa->name }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum Ada Mahasiswa Magang</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                  </div>
            </div>
        </div>  
      </div>
    </div>
@endsection