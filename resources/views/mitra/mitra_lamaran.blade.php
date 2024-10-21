@extends('layouts.mitra')

@section('content')
<div class="container">
    <h1>Daftar Lamaran</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered" id="lamaranTable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mahasiswa</th>
                <th>Email</th>
                <th>CV</th>
                <th>Tanggal Lamaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lamarans as $index => $lamaran)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $lamaran->user->name }}</td> <!-- Mengakses nama mahasiswa dari relasi -->
                    <td>{{ $lamaran->user->email }}</td> <!-- Mengakses email mahasiswa -->
                    <td>
                        <a href="{{ asset('storage/' . $lamaran->cv_path) }}" target="_blank">Lihat CV</a>
                    </td>
                    <td>
                        @if($lamaran->status == 'diterima')
                            <span class="badge badge-success">Diterima</span>
                        @elseif($lamaran->status == 'ditolak')
                            <span class="badge badge-danger">Ditolak - Alasan: {{ $lamaran->alasan_penolakan }}</span>
                        @else
                            <span class="badge badge-warning">Pending</span>
                        @endif
                    </td>
                    <td>
                        @if($lamaran->status == 'pending')
                            <form action="{{ route('lamaran.acc', $lamaran->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success">ACC</button>
                            </form>

                            <!-- Tombol Tolak -->
                            <button class="btn btn-danger" data-toggle="modal"
                                data-target="#modalTolak{{ $lamaran->id }}">Tolak</button>

                            <!-- Modal untuk Menolak Lamaran -->
                            <div class="modal fade" id="modalTolak{{ $lamaran->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <form action="{{ route('lamaran.tolak', $lamaran->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Tolak Lamaran</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="alasan_penolakan">Alasan Penolakan:</label>
                                                    <textarea name="alasan_penolakan" id="alasan_penolakan" class="form-control"
                                                        required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger">Tolak Lamaran</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Batal</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection