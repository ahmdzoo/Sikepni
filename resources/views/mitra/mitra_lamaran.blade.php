@extends('layouts.mitra')

@section('content')
<div class="content-wrapper" style="background: linear-gradient(to bottom, #80b8c7, #ffffff); min-height: 100vh;">
    <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered" id="lamaranTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Mahasiswa</th>
                    <th>Email</th>
                    <th>CV</th>
                    <th>Tanggal Lamaran</th>
                    <th>Alasan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lamarans as $index => $lamaran)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $lamaran->user->name }}</td>
                        <td>{{ $lamaran->user->email }}</td>
                        <td>
                            <a href="{{ asset('storage/' . $lamaran->cv_path) }}" target="_blank">Lihat CV</a>
                        </td>
                        <td>{{ $lamaran->created_at->format('d-m-Y') }}</td>
                        <td>
                            @if($lamaran->status == 'diterima')
                                <span class="badge badge-success">{{ $lamaran->alasan_acc }}</span>
                            @elseif($lamaran->status == 'ditolak')
                                <span class="badge badge-danger">{{ $lamaran->alasan_penolakan }}</span>
                            @else
                                <span class="badge badge-warning">Pending</span>
                            @endif
                        </td>

                        <td>
                            @if($lamaran->status == 'pending')
                                <!-- Button ACC -->
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#modalAcc{{ $lamaran->id }}">ACC</button>

                                <!-- Modal untuk Menerima Lamaran -->
                                <div class="modal fade" id="modalAcc{{ $lamaran->id }}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <form action="{{ route('lamaran.acc', $lamaran->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Terima Lamaran</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="alasan_acc">Alasan Penerimaan:</label>
                                                        <textarea name="alasan_acc" id="alasan_acc" class="form-control"
                                                            required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Terima Lamaran</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Batal</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

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
                                                        <textarea name="alasan_penolakan" id="alasan_penolakan"
                                                            class="form-control" required></textarea>
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
                            @elseif($lamaran->status == 'ditolak')
                                <button class="btn btn-danger" disabled>Ditolak</button>
                            @elseif($lamaran->status == 'diterima')
                                <button class="btn btn-success" disabled>Diterima</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection