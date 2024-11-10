@extends('layouts.dosen')
@section('content')
<style>
    /* Media query untuk ukuran layar yang lebih kecil */
    @media (max-width: 768px) {
        /* Mengurangi ukuran font pada tabel */
        .table-responsive table th, 
        .table-responsive table td {
            font-size: 12px;
            padding: 8px;
        }

        /* Mengatur ulang padding pada card dan judul */
        .card-header h4 {
            font-size: 16px;
        }
        
        .card-body {
            padding: 10px;
        }
        
        /* Mengatur ulang margin pada row */
        .row.m-4 {
            margin: 0 5px;
        }

        /* Membuat tombol lebih kecil */
        .btn-sm {
            font-size: 10px;
            padding: 5px 8px;
        }

        /* Mengatur lebar card pada layar kecil */
        .col-sm-12 {
            width: 100%;
            margin-bottom: 10px;
        }
    }
</style>

<div class="content-wrapper" style="background: linear-gradient(to bottom, #80b8c7, #fff ); min-height: 100vh;">
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
                        <div class="inner">
                            <h3>{{ $jumlahMahasiswaDiterima }}</h3>
                            <p>Mahasiswa Magang</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <a href="{{ route('dosen.magang_mhs') }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                    <div class="small-box">
                        <div class="inner">
                            <h3>{{ $jumlahLamaran }}</h3>
                            <p>CV Lamaran Magang</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <a href="{{ route('dosen_lamaran') }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <div class="row m-4">
                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h4>Laporan Magang Terbaru</h4>
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
                                        @foreach($laporanMagang as $index => $laporan)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $laporan->mahasiswa->name }}</td>
                                                <td>{{ $laporan->created_at->format('d-m-Y') }}</td>
                                                <td><a href="{{ route('dosen.laporan', ['mahasiswa_id' => $laporan->mahasiswa->id]) }}" class="btn btn-primary btn-sm">Lihat</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h4>Laporan Akhir Terbaru</h4>
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
                                        @foreach($laporanAkhir as $index => $laporan)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $laporan->mahasiswa->name }}</td>
                                                <td>{{ $laporan->created_at->format('d-m-Y') }}</td>
                                                <td><a href="{{ route('dosen.LaporanAkhir', ['mahasiswa_id' => $laporan->mahasiswa->id]) }}" class="btn btn-primary btn-sm">Lihat</a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h4>Mahasiswa Magang</h4>
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
                                        @foreach($mahasiswaDiterima as $index => $lamaran)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $lamaran->mahasiswa->name }}</td>
                                            </tr>
                                        @endforeach
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
