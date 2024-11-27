@extends('layouts.mhs')
@section('title', 'Status Lamaran Magang | SIKEPNI')

@section('content')
<div class="content-wrapper" style="min-height: 100vh;">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card p-4" style="width: 100%;">
            <div class="card-header">
                <h5 class="m-0" style="font-size: 30px; font-weight: bold;">Status Pengajuan Magang</h5>
            </div>

            <div class="table-responsive">
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
                            <td>{{ $lamaran->user->name}}</td>
                            <td>{{ $lamaran->mitra->mitraUser->name  }}</td>
                            <td><a href="{{ asset('storage/' . $lamaran->cv_path) }}" target="_blank">Lihat CV</a></td>
                            <td>{{ \Carbon\Carbon::parse($lamaran->created_at)->format('d-m-Y') }}</td>
                            <td>
                                @if($lamaran->status == 'diterima')
                                    <span class="badge badge-success">DITERIMA</span>
                                @elseif($lamaran->status == 'ditolak')
                                    <span class="badge badge-danger">DITOLAK</span>
                                @else
                                    <span class="badge badge-warning">Pending</span>
                                @endif
                            </td>
                            <td>
                                @if($lamaran->status == 'diterima')
                                    {{ $lamaran->alasan_acc }} <!-- Tampilkan alasan diterima -->
                                @elseif($lamaran->status == 'ditolak')
                                    {{ $lamaran->alasan_penolakan }} <!-- Tampilkan alasan ditolak -->
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>

@include('layouts.footer')
@endsection