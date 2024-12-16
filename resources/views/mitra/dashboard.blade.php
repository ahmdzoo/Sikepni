@extends('layouts.mitra')
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
        .card-header h5 {
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

<div class="content-wrapper" style="min-height: 100vh;">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-4" style="font-size: 30px; color: white; font-weight: bold;">Dashboard Mitra</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row m-4">
                <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                    <div class="small-box">
                        <a href="{{ route('mitra.mahasiswa_diterima') }}"> 
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
                        <a href="{{ route('mitra_lamaran') }}">
                        <div class="inner">
                            <h3>{{ $jumlahLamaran }}</h3>
                            <p>Pengajuan Magang</p>
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
                                                <td colspan="4" class="text-center">Belum Ada Mahasiswa Magang</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <a href="{{ route('mitra.mahasiswa_diterima') }}" class="small-box-footer">Lihat Semua</a>
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
