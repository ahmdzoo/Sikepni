@extends('layouts.mhs')
@section('title', 'Status Lamaran Magang | SIKEPNI')

@section('content')
<div class="content-wrapper" style="min-height: 100vh;">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-4" style="font-size: 30px; color: white; font-weight: bold;">Pengajuan Magang</h1>
        </div>
    </div>
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card p-4" style="width: 100%;">
            <div class="card-header">
                <h5 class="m-0" style="font-size: 20px; font-weight: bold;">Status Pengajuan Magang</h5>
            </div>

            <div class="table-responsive">
                @if($lamarans->isEmpty())
                    <div class="text-center py-4">
                        <h5 class="text-muted">ANDA BELUM MELAKUKAN PENGAJUAN MAGANG</h5>
                    </div>
                @else
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Mahasiswa</th>
                                <th>Perusahaan</th>
                                <th>CV</th>
                                <th>Tanggal Lamaran</th>
                                <th>Keterangan</th>
                                <th>Alasan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lamarans as $index => $lamaran)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $lamaran->user->name }}</td>
                                    <td>{{ $lamaran->mitra->mitraUser->name }}</td>
                                    <td>
                                        <a href="{{ asset('storage/' . $lamaran->cv_path) }}" target="_blank">
                                            Lihat CV
                                        </a>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($lamaran->created_at)->format('d-m-Y') }}</td>
                                    <td>
                                        @if($lamaran->status == 'diterima')
                                            <span class="badge badge-success">DITERIMA</span>
                                        @elseif($lamaran->status == 'ditolak')
                                            <span class="badge badge-danger">DITOLAK</span>
                                        @else
                                            <span class="badge badge-warning">DIPROSES</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($lamaran->status == 'diterima')
                                            {{ $lamaran->alasan_acc }}
                                        @elseif($lamaran->status == 'ditolak')
                                            {{ $lamaran->alasan_penolakan }}
                                        @else
                                            -
                                        @endif
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

@include('layouts.footer')
@endsection
