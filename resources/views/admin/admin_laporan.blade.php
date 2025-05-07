@extends('layouts.budede.app')

@section('breadcumb', 'Menu /Laporan Magang /')
@section('page-title', $laporans->isNotEmpty() ? $laporans->first()->mahasiswa->name : 'Laporan Mahasiswa')

@section('content')

<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-body">
            <!-- Filter Berdasarkan Jenis Laporan -->
            <div class="filter-section mb-3 ml-3 text-left">
                <form method="GET" action="{{ route('admin.laporan', ['mahasiswa_id' => Crypt::encrypt($mahasiswa_id)]) }}" class="d-inline-block">
                    <div class="input-group" style="width: 250px; display: inline-flex;">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-primary text-white">
                                <i class="bx bx-slider"></i>
                            </span>
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
                            <th>Nilai</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($laporans->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center">
                                   Belum Ada Laporan yang diupload.
                                </td>
                            </tr>
                        @else
                            @foreach($laporans as $index => $laporan)
                                <tr>
                                    <td class="text-center">{{ $laporans->firstItem() + $index }}</td>
                                    <td>
                                        <a href="{{ Storage::url($laporan->file_path) }}" target="_blank">
                                            {{ basename($laporan->file_path) }}
                                        </a>
                                    </td>
                                    <td>{{ $laporan->jenis_laporan }}</td>
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
                                    <td colspan="7" class="collapse" id="komentar-{{ $laporan->id }}">
                                        <div class="p-3">
                                            <h5>Komentar</h5>
                                            @if($laporan->komentars->isEmpty())
                                                <p>Belum ada komentar.</p>
                                            @else
                                                <ul>
                                                    @foreach($laporan->komentars as $komentar)
                                                        <li class="comment-item">
                                                            <strong>{{ $komentar->user->name }}:</strong> {{ $komentar->content }}
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

                @if($laporans->isNotEmpty())
                <div class="d-flex justify-content-center mt-4">
                    {{ $laporans->links('pagination::bootstrap-5') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
