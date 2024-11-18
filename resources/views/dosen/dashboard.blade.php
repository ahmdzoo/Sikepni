@extends('layouts.dosen')
@section('content')
<style>
    
</style>

<div class="content-wrapper" style="min-height: 100vh;">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-4" style="font-size: 30px; color: white; font-weight: bold;">Dashboard Dosen Pembimbing</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row m-4">
                <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                    <div class="small-box">
                        <a href="{{ route('dosen.magang_mhs') }}">
                        <div class="inner">
                            <h3>{{ $jumlahMahasiswaDiterima }}</h3>
                            <p>Mahasiswa Magang</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        </a>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                    <div class="small-box">
                        <a href="{{ route('dosen_lamaran') }}">
                        <div class="inner">
                            <h3>{{ $jumlahLamaran }}</h3>
                            <p>CV Lamaran Magang</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row m-4">
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5>Laporan Magang Terbaru</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
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
                                                <td><a href="{{ route('dosen.laporan', ['mahasiswa_id' => $laporan->mahasiswa->id]) }}" class="btn btn-primary btn-sm">Lihat</a></td>
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

                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5>Laporan Akhir Terbaru</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
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
                                                <td><a href="{{ route('dosen.LaporanAkhir', ['mahasiswa_id' => $laporan->mahasiswa->id]) }}" class="btn btn-primary btn-sm">Lihat</a></td>
                                            </tr>
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

                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h5>Mahasiswa Magang</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Mahasiswa</th>
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
                                                <td colspan="2" class="text-center">Belum Ada Mahasiswa</td>
                                            </tr>
                                        @endforelse
                                    </tbody>                                    
                                </table>
                                <a href="{{ route('dosen.magang_mhs') }}" class="small-box-footer">Lihat Semua</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@include('layouts/footer')
@endsection
