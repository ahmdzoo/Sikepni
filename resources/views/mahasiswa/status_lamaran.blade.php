@extends('layouts.mhs')

@section('content')
<div class="content-wrapper" style="background: linear-gradient(to bottom, #80b8c7, #ffffff); min-height: 100vh;">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card p-4" style="width: 100%;">
            <div class="card-header">
                <h5 class="m-0" style="font-size: 24px; font-weight: bold;">Status Lamaran</h5>
            </div>

            <table class="table" id="lamaranTable">
                <thead>
                    <tr>
                        <th>Tanggal Lamaran</th> <!-- Ganti ID Lamaran dengan Tanggal Lamaran -->
                        <th>Mitra</th>
                        <th>Dosen Pembimbing</th>
                        <th>Status</th>
                        <th>Tanggal Diterima</th> <!-- Tambahkan kolom Tanggal Diterima -->
                    </tr>
                </thead>
                <tbody>
                    @if(isset($lamarans) && $lamarans->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada lamaran yang tersedia.</td>
                        </tr>
                    @else
                        @foreach($lamarans as $lamaran)
                            <tr>
                                <td>{{ $lamaran->created_at->format('d-m-Y') }}</td> <!-- Menampilkan tanggal lamaran -->
                                <td>{{ $lamaran->mitra->mitraUser?->name ?? 'Belum ditentukan' }}</td>
                                <td>{{ $lamaran->mitra->dosenPembimbing?->name ?? 'Belum ditentukan' }}</td>
                                <td>{{ $lamaran->status }}</td>
                                <td>{{ $lamaran->tanggal_diterima ? $lamaran->tanggal_diterima->format('d-m-Y') : '-' }}</td>
                                <!-- Tanggal diterima -->
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('layouts.footer')
@endsection