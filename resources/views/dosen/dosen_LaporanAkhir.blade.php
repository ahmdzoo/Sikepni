@extends('layouts.dosen')
@section('title', 'Laporan Akhir Magang | SIKEPNI')

@section('content')
<div class="content-wrapper" style="min-height: 100vh;">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-4" style="font-size: 30px; color: white; font-weight: bold;">Laporan Akhir Magang</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        @if($LaporanAkhirs->isEmpty())
            <div class="no-data-container">
                <img src="{{ asset('gambar/empty.png') }}" alt="Gambar Illustrasi" class="no-data-image mb-3">
                <p class="no-data-text">Belum Ada Laporan yang diupload.</p>
            </div>
        @else
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h2 class="card-title mb-0">{{$LaporanAkhirs->first()->mahasiswa->name }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm custom-table">
                            <thead class="text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Laporan</th>
                                    <th>Mitra Magang</th>
                                    <th>Tanggal Upload</th>
                                    <th>Nilai</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($LaporanAkhirs->isEmpty())
                                    <tr>
                                        <td colspan="6" class="text-center">Belum Ada Laporan diupload</td>
                                    </tr>
                                @else
                                    @foreach($LaporanAkhirs as $index => $laporan)
                                        <tr>
                                            <td class="text-center">{{ $LaporanAkhirs->firstItem() + $index }}</td>
                                            <td>
                                                <a href="{{ Storage::url($laporan->file_path) }}" target="_blank">
                                                    {{ basename($laporan->file_path) }}
                                                </a>
                                            </td>
                                            <td>{{ $laporan->mitra->mitraUser->name }}</td>
                                            <td class="text-center">{{ $laporan->created_at->format('d M Y') }}</td>
                                            <td class="text-center">{{ $laporan->nilai }}</td>
                                            <td class="text-center">
                                                <button 
                                                    class="btn btn-sm btn-info" 
                                                    data-toggle="collapse" 
                                                    data-target="#komentar-{{ $laporan->id }}" 
                                                    aria-expanded="false" 
                                                    aria-controls="komentar-{{ $laporan->id }}"
                                                >
                                                    <i class="fas fa-comments"></i> Komentar
                                                </button>
                                                <!-- Tombol Download -->
                                                <a href="{{ Storage::url($laporan->file_path) }}" class="btn btn-sm btn-success" download>
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="6" class="collapse" id="komentar-{{ $laporan->id }}">
                                                <div class="p-3">
                                                    <h5>Komentar</h5>
                                                    @if($laporan->komentar_akhirs->isEmpty())
                                                        <p>Belum ada komentar.</p>
                                                    @else
                                                        <ul>
                                                            @foreach($laporan->komentar_akhirs as $komentar)
                                                                <li class="comment-item">
                                                                    <div>
                                                                        <strong>{{ $komentar->user->name }}:</strong> {{ $komentar->content }}
                                                                    </div>
                                                                    <form 
                                                                        action="{{ route('LaporanAkhir.komentar.destroy', ['LaporanAkhir' => $laporan->id, 'komentar' => $komentar->id]) }}" 
                                                                        method="POST" 
                                                                        class="delete-form"
                                                                    >
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
                                                    <form action="{{ route('LaporanAkhir.komentar.store', $laporan->id) }}" method="POST">
                                                        @csrf
                                                        <div class="form-group">
                                                            <textarea name="content" class="form-control" placeholder="Tulis komentar..." required></textarea>
                                                        </div>
                                                        <button type="submit" class="btn btn-sm btn-success mt-2">Kirim</button>
                                                        <button 
                                                            type="button" 
                                                            class="btn btn-sm btn-secondary mt-3" 
                                                            data-toggle="collapse" 
                                                            data-target="#komentar-{{ $laporan->id }}" 
                                                            aria-expanded="false" 
                                                            aria-controls="komentar-{{ $laporan->id }}"
                                                        >
                                                            Close
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <!-- Pagination Links -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $LaporanAkhirs->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@include('layouts/footer')

<!-- CSS Responsif Tambahan -->
<style>
    @media (max-width: 768px) {
        .custom-table th, .custom-table td {
            font-size: 8px;
            padding: 4px;
        }
        .custom-table .btn {
            padding: 2px 4px;
            font-size: 5px;
        }
    }
</style>
@endsection
