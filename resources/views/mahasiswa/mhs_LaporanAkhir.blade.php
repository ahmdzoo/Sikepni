@extends('layouts.mahasiswa.app')

@section('breadcumb', 'Menu /Aktivitas Magang /')
@section('page-title', 'Laporan Akhir')

@section('content')


    <div class="container-fluid">
        <!-- Button to Open Modal -->
        <div class="text-center mb-4">
            <button type="button" class="btn btn-white shadow" data-bs-toggle="modal" data-bs-target="#uploadLaporanModal" 
                style="border-radius: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); color: #363535;; background-color: #ffffff; border: 1px solid #ccc;">
                <i class="fas fa-upload" style="color: #363535;"></i> Upload Laporan
            </button>
        </div>

        <!-- Modal for Upload Laporan -->
        <div class="modal fade" id="uploadLaporanModal" tabindex="-1" aria-labelledby="uploadLaporanModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="uploadLaporanModalLabel">Upload Laporan Magang</h5>
                        <button type="button" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('LaporanAkhir.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="file" class="form-label">Pilih File Laporan</label>
                                <input type="file" class="form-control" id="file" name="file" accept=".pdf" required>
                                <small>Ukuran maksimal 5MB</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload Laporan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close" style="background: none; border: none;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>
                        {{ $error }}
                        <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close" style="background: none; border: none;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </li>
                @endforeach
            </div>
        @endif

        <!-- Daftar Laporan Section -->
        <div class="card shadow-sm">
            <div class="card-body">

                @if($LaporanAkhirs->isEmpty())
                    <div class="alert alert-warning text-center">
                        Tidak ada laporan magang yang diupload.
                    </div>
                @else
                    <table class="table table-bordered table-striped table-hover mt-3">
                        <thead class="table-primary">
                            <tr>
                                <th style="width: 5%; text-align: center;">No</th>
                                <th style="width: 20%; text-align: center;">Laporan</th>
                                <th style="width: 20%; text-align: center;">Tanggal</th>
                                <th style="width: 20%; text-align: center;">Nilai</th>
                                <th style="width: 20%; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($LaporanAkhirs as $index => $laporan)
                                <tr>
                                    <td class="text-center">{{ $LaporanAkhirs->firstItem() + $index }}</td>
                                    <td>
                                        <a href="{{ asset('storage/' . $laporan->file_path) }}" target="_blank">
                                        {{ basename($laporan->file_path) }}
                                        </a>
                                    </td>
                                    <td class="text-center">{{ $laporan->created_at->format('d M Y') }}</td>
                                    <td class="text-center">{{ $laporan->nilai}}</td>
                                    <td class="text-center">
                                        <!-- Dropdown Action -->
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="dropdownMenuButton-{{ $laporan->id }}" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class='bx bx-dots-horizontal-rounded'></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton-{{ $laporan->id }}">
                                                
                                                <button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editLaporanModal-{{ $laporan->id }}">
                                                    <i class='bx bx-edit'></i> Edit
                                                </button>
                                                <form action="{{ route('LaporanAkhir.destroy', $laporan->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item">
                                                        <i class='bx bx-trash'></i> Hapus
                                                    </button>
                                                </form>
                                                <button class="dropdown-item" data-bs-toggle="collapse" data-bs-target="#komentar-{{ $laporan->id }}" aria-expanded="false" aria-controls="komentar-{{ $laporan->id }}">
                                                    <i class='bx bx-comment-dots'></i> Komentar
                                                </button>
                                            </div>
                                        </div>

                                    </td>
                                </tr>

                                <!-- Bagian Komentar Dropdown -->
                                <tr>
                                    <td colspan="6" class="collapse" id="komentar-{{ $laporan->id }}">
                                        <div class="p-3">
                                            <h5>Komentar</h5>
                                            @if($laporan->komentar_akhirs->isEmpty())
                                                <p>Belum ada komentar.</p>
                                            @else
                                            <ul>
                                                @foreach($laporan->komentar_akhirs as $komentar)
                                                    <li class="comment-item">
                                                        <div>
                                                            <strong>{{ $komentar->user->name }}:</strong> {{ $komentar->content }}
                                                        </div>
                                                        <form action="{{ route('LaporanAkhir.komentar.destroy', ['LaporanAkhir' => $laporan->id, 'komentar' => $komentar->id]) }}" method="POST" class="delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm">
                                                                <i class='bx bxs-trash-alt'></i>
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                            <form action="{{ route('LaporanAkhir.komentar.store', $laporan->id) }}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <textarea name="content" class="form-control" placeholder="Tulis komentar..." required></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-sm btn-success mt-2">Kirim</button>
                                                <button type="button" class="btn btn-sm btn-secondary mt-2" data-toggle="collapse" data-target="#komentar-{{ $laporan->id }}" aria-expanded="false" aria-controls="komentar-{{ $laporan->id }}">
                                                    Tutup
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Modal for Edit Laporan -->
                                <div class="modal fade" id="editLaporanModal-{{ $laporan->id }}" tabindex="-1" aria-labelledby="editLaporanModalLabel-{{ $laporan->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title" id="editLaporanModalLabel-{{ $laporan->id }}">Edit Laporan Magang</h5>
                                                <button type="button" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('LaporanAkhir.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="file" class="form-label">File Laporan (kosongkan jika tidak ingin mengubah)</label>
                                                        <input type="file" class="form-control" id="file" name="file" accept=".pdf">
                                                        <small>File saat ini: {{ basename($laporan->file_path) }}</small>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Update Laporan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Pagination Links -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $LaporanAkhirs->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    
</div>
@endsection
