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

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Mahasiswa</th>
                        <th>Email</th>
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
                            <td>{{ $lamaran->user->email }}</td>
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

@include('layouts.footer')
@endsection