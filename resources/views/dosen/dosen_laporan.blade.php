@extends('layouts.dosen')
@section('content')
<div class="content-wrapper" style="background: linear-gradient(to bottom, #80b8c7, #ffffff); min-height: 100vh;">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-4" style="font-size: 50px; color: white; font-weight: bold;">Aktivitas Magang</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        @if($laporans->isEmpty())
            <div class="alert alert-warning">
                Belum Ada Laporan Yang diUpload.
            </div>
        @else
            @foreach($laporans as $mahasiswaId => $laporanMahasiswa)
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h2 class="card-title mb-0">Laporan Magang - {{ $laporanMahasiswa->mahasiswa->name }}</h2>
                    </div>
                    <div class="card-body">
                        <!-- Filter Berdasarkan Jenis Laporan -->
                        <div class="filter-section mb-3 ml-3 text-left">
                            <form method="GET" action="{{ route('dosen.laporan', $mahasiswaId) }}" class="d-inline-block">
                                <div class="input-group" style="width: 250px; display: inline-flex;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-primary text-white"><i class="fas fa-filter"></i></span>
                                    </div>
                                    <select name="filter_jenis" id="filter_jenis" class="form-control" onchange="this.form.submit()" style="border-radius: 0 5px 5px 0;">
                                        <option value="">Semua Jenis</option>
                                        <option value="Harian" {{ request('filter_jenis') == 'Harian' ? 'selected' : '' }}>Harian</option>
                                        <option value="Mingguan" {{ request('filter_jenis') == 'Mingguan' ? 'selected' : '' }}>Mingguan</option>
                                        <option value="Bulanan" {{ request('filter_jenis') == 'Bulanan' ? 'selected' : '' }}>Bulanan</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm custom-table">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>Laporan</th>
                                        <th>Jenis Laporan</th>
                                        <th>Mitra Magang</th>
                                        <th>Tanggal Upload</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($laporans->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <div class="alert alert-warning mb-0">Belum ada laporan yang diupload.</div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($laporans as $index => $laporan)
                                            <tr>
                                                <td class="text-center">{{ $laporans->firstItem() + $index }}</td>
                                                <td><a href="{{ Storage::url($laporan->file_path) }}" target="_blank">{{ basename($laporan->file_path) }}</a></td>
                                                <td>{{ $laporan->jenis_laporan }}</td>
                                                <td>{{ $laporan->mitra->mitraUser->name }}</td>
                                                <td class="text-center">{{ $laporan->created_at->format('d M Y') }}</td>
                                                <td class="text-center">
                                                    <button class="btn btn-sm btn-info" data-toggle="collapse" data-target="#komentar-{{ $laporan->id }}" aria-expanded="false" aria-controls="komentar-{{ $laporan->id }}">
                                                        <i class="fas fa-comments"></i> Komentar
                                                    </button>
                                                </td>
                                            </tr>
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
                                                                    <form action="{{ route('laporan.komentar.destroy', ['laporan' => $laporan->id, 'komentar' => $komentar->id]) }}" method="POST" class="delete-form">
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
                                                        <form action="{{ route('laporan.komentar.store', $laporan->id) }}" method="POST">
                                                            @csrf
                                                            <div class="form-group">
                                                                <textarea name="content" class="form-control" placeholder="Tulis komentar..." required></textarea>
                                                            </div>
                                                            <button type="submit" class="btn btn-sm btn-success mt-2">Kirim</button>
                                                        </form>
                                                        <!-- Tombol untuk menutup komentar -->
                                                        <button type="button" class="btn btn-secondary mt-3" data-toggle="collapse" data-target="#komentar-{{ $laporan->id }}" aria-expanded="false" aria-controls="komentar-{{ $laporan->id }}">
                                                            Close
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                
                            </table>
                            <!-- Pagination Links -->
                            <div class="d-flex justify-content-center mt-4">
                                {{ $laporans->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@include('layouts/footer')


@endsection
