@extends('layouts.mitra')
@section('title', 'Laporan Magang | SIKEPNI')

@section('content')
<div class="content-wrapper" style="min-height: 100vh;">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-4" style="font-size: 30px; color: white; font-weight: bold;">Laporan Magang</h1>
                </div>
            </div>
        </div>
    </div>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif


    <div class="container-fluid">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h2 class="card-title mb-0">{{$laporans->first()->mahasiswa->name }}</h2>
            </div>
            <div class="card-body">
                <!-- Filter Berdasarkan Jenis Laporan -->
                <div class="filter-section mb-3 ml-3 text-left">
                    <form method="GET" action="{{ route('mitra.laporan', ['mahasiswa_id' => Crypt::encrypt($mahasiswa_id)]) }}" class="d-inline-block">
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
                                <th>Tanggal Upload</th>
                                <th>Nilai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($laporans->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center">Belum Ada Laporan yang diupload.</td>
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
                                <td class="text-center">{{ $laporan->created_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    <form action="{{ route('mitra.laporan.nilai', $laporan->id) }}" method="POST">
                                        @csrf
                                        <input type="number" name="nilai" class="form-control text-center" min="0" max="100" value="{{ $laporan->nilai ?? '' }}" required>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-info" data-toggle="collapse" data-target="#komentar-{{ $laporan->id }}" aria-expanded="false" aria-controls="komentar-{{ $laporan->id }}">
                                        <i class="fas fa-comments"></i>
                                    </button>
                                    <a href="{{ Storage::url($laporan->file_path) }}" class="btn btn-sm btn-success" download>
                                        <i class="fas fa-download"></i>
                                    </a>
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
    </div>
</div>

@include('layouts/footer')

@endsection