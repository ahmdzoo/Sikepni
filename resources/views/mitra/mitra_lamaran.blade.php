@extends('layouts.mitra.app')

@section('breadcumb', 'Menu /')
@section('page-title', 'Pengajuan')

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
    <div>{{ session('success') }}</div>
    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close" style="background: none; border: none;">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
    <div>{{ session('error') }}</div>
    <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close" style="background: none; border: none;">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Pengajuan Dokumen Magang</h5>

            <div class="table-responsive text-nowrap">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>CV</th>
                            <th>Tanggal Lamaran</th>
                            <th>Alasan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse($lamarans as $lamaran)
                            <tr>
                                <td>{{ $loop->iteration + ($lamarans->currentPage() - 1) * $lamarans->perPage() }}</td>
                                <td>{{ $lamaran->user->name }}</td>
                                <td>{{ $lamaran->user->email }}</td>
                                <td>
                                    <a href="{{ asset('storage/' . $lamaran->cv_path) }}" target="_blank">Lihat CV</a>
                                </td>
                                <td>{{ $lamaran->created_at->format('d-m-Y') }}</td>
                                <td>
                                    @if($lamaran->status == 'diterima')
                                        <span>{{ $lamaran->alasan_acc }}</span>
                                    @elseif($lamaran->status == 'ditolak')
                                        <span>{{ $lamaran->alasan_penolakan }}</span>
                                    @else
                                        <span class="badge rounded-pill bg-warning">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    @if($lamaran->status == 'pending')
                                        <!-- Tombol Terima -->
                                        <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#modalAcc{{ $lamaran->id }}">Terima</button>

                                        <!-- Modal Terima -->
                                        <div class="modal fade" id="modalAcc{{ $lamaran->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <form action="{{ route('lamaran.acc', $lamaran->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Terima Lamaran</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="alasan_acc">Alasan Penerimaan:</label>
                                                                <textarea name="alasan_acc" id="alasan_acc" class="form-control" required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-success">Terima Lamaran</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>

                                        <!-- Tombol Tolak -->
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalTolak{{ $lamaran->id }}">Tolak</button>

                                        <!-- Modal Tolak -->
                                        <div class="modal fade" id="modalTolak{{ $lamaran->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <form action="{{ route('lamaran.tolak', $lamaran->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Tolak Lamaran</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="alasan_penolakan">Alasan Penolakan:</label>
                                                                <textarea name="alasan_penolakan" id="alasan_penolakan" class="form-control" required></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-danger">Tolak Lamaran</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
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
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Belum ada pengajuan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-end mt-3">
                {{ $lamarans->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
