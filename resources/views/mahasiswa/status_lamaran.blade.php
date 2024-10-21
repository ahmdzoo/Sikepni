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
                        <th>ID Lamaran</th>
                        <th>Mitra</th>
                        <th>Dosen Pembimbing</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($lamarans) && $lamarans->isEmpty())
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada lamaran yang tersedia.</td>
                        </tr>
                    @else
                        @foreach($lamarans as $lamaran)
                            <tr>
                                <td>{{ $lamaran->id }}</td>
                                <td>{{ $lamaran->mitra->mitraUser?->name ?? 'Belum ditentukan' }}</td>
                                <td>{{ $lamaran->mitra->dosenPembimbing?->name ?? 'Belum ditentukan' }}</td>
                                <td>{{ $lamaran->status }}</td>
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