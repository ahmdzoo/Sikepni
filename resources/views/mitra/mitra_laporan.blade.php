@extends('layouts.mitra')
@section('content')
<div class="content-wrapper" style="background: linear-gradient(to bottom, #80b8c7, #ffffff); min-height: 100vh;">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-4" style="font-size: 50px; color: white; font-weight: bold;">Aktifitas Magang</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <!-- Card Header -->
            <div class="card-header bg-primary text-white">
                <h2 class="card-title mb-0">Daftar Laporan Magang</h2>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                @if($laporans->isEmpty())
                <div class="alert alert-warning">
                    Tidak ada laporan magang yang tersedia.
                </div>
                @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Mahasiswa</th>
                            <th>Mitra Magang</th> <!-- Kolom Nama Mitra -->
                            <th>Nama Laporan</th>
                            <th>Tanggal Upload</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laporans as $index => $laporan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $laporan->mahasiswa->name }}</td>
                            <td>{{ $laporan->mitra->mitraUser->name  }}</td> <!-- Data Nama Mitra -->
                            <td>{{ basename($laporan->file_path) }}</td>
                            <td>{{ $laporan->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ asset('storage/' . $laporan->file_path) }}" target="_blank"
                                    class="btn btn-sm btn-primary">Lihat Laporan</a>
                                <button class="btn btn-sm btn-info" data-toggle="collapse"
                                    data-target="#komentar-{{ $laporan->id }}" aria-expanded="false"
                                    aria-controls="komentar-{{ $laporan->id }}">
                                    <i class="fas fa-comments"></i> Komentar
                                </button>

                            </td>
                        </tr>

                        <!-- Bagian Komentar Dropdown -->
                        <tr>
                            <td colspan="6" class="collapse" id="komentar-{{ $laporan->id }}">
                                <div class="p-3">
                                    <h5>Komentar</h5>
                                    @if($laporan->komentars->isEmpty())
                                    <p>Belum ada komentar.</p>
                                    @else
                                    <ul>
                                        @foreach($laporan->komentars as $komentar)
                                        <li class="comment-item">
                                            <div>
                                                <strong>{{ $komentar->user->name }}:</strong> {{ $komentar->content }}
                                            </div>
                                            <form
                                                action="{{ route('laporan.komentar.destroy', ['laporan' => $laporan->id, 'komentar' => $komentar->id]) }}"
                                                method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete-icon">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </li>
                                        @endforeach
                                    </ul>


                                    @endif

                                    <!-- Form untuk Menambahkan Komentar -->
                                    <form action="{{ route('laporan.komentar.store', $laporan->id) }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <textarea name="content" class="form-control"
                                                placeholder="Tulis komentar..." required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-success mt-2">Kirim
                                            Komentar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</div>
@include('layouts/footer')
@endsection