@extends('layouts.budede.app')

@section('breadcumb', 'Menu /Laporan Akhir /')
@section('page-title', $LaporanAkhirs->isNotEmpty() ? $LaporanAkhirs->first()->mahasiswa->name : 'Laporan Mahasiswa')

@section('content')


<div class="container-fluid">
    <div class="card mb-4">
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
                                <td colspan="6" class="text-center">
                                    <p class="mb-0">Belum Ada Laporan Akhir yang diupload.</p>
                                </td>
                            </tr>
                        @else
                            @foreach($LaporanAkhirs as $index => $laporan)
                                <tr>
                                    <td class="text-center">{{ $LaporanAkhirs->firstItem() + $index }}</td>
                                    <td><a href="{{ Storage::url($laporan->file_path) }}" target="_blank">{{ basename($laporan->file_path) }}</a></td>
                                    <td>{{ $laporan->mitra->mitraUser->name }}</td>
                                    <td class="text-center">{{ $laporan->created_at->format('d M Y') }}</td>
                                    <td class="text-center">{{ $laporan->nilai }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-info"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#komentar-{{ $laporan->id }}"
                                            aria-expanded="false"
                                            aria-controls="komentar-{{ $laporan->id }}">
                                            <i class="bx bx-comment"></i>
                                        </button>
                                        <a href="{{ Storage::url($laporan->file_path) }}" class="btn btn-sm btn-success" download>
                                            <i class="bx bx-download"></i>
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
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

                <!-- Pagination Links -->
                @if($LaporanAkhirs->isNotEmpty())
                <div class="d-flex justify-content-center mt-4">
                    {{ $LaporanAkhirs->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>



@endsection
