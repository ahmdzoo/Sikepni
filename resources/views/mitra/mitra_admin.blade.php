@extends('layouts.mitra')
@section('title', 'Data Mitra | Admin')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<div class="content-wrapper" style="min-height: 100vh;">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-4" style="font-size: 30px; color: white; font-weight: bold;">Informasi Kerjasama Magang</h1>
        </div>
    </div>

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Tambahkan class table-responsive di sini -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center">Dokumen PKS</th>
                                <th>Nama Mitra</th>
                                <th>Jurusan</th>
                                <th>Dosen Pembimbing</th>
                                <th class="text-center">Mulai Magang</th>
                                <th class="text-center">Selesai Magang</th>
                                <th>Alamat</th>
                                <th class="text-center">Kuota</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mitras as $key => $mitra)
                            <tr>
                                <td class="text-center">
                                    @if($mitra->file_pks)
                                    <button class="btn btn-sm btn-success" onclick="openPdfModal('{{ asset('storage/' . $mitra->file_pks) }}')">
                                        Lihat
                                    </button>
                                    
                                    @else
                                        <span class="text-muted">Tidak Ada File</span>
                                    @endif
                                </td>
                                
                                <td>{{ $mitra->mitraUser->name ?? '-' }}</td>
                                <td>{{ $mitra->jurusan->name ?? '-' }}</td>
                                <td>{{ $mitra->dosenPembimbing->name ?? '-' }}</td>
                                <td class="text-center">{{ $mitra->tanggal_mulai_magang }}</td>
                                <td class="text-center">{{ $mitra->tanggal_selesai_magang }}</td>
                                <td>{{ $mitra->alamat ?? '-' }}</td>
                                <td class="text-center">{{ $mitra->kuota ?? '-' }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal{{ $mitra->id }}">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Akhir table-responsive -->
            </div>
        </div>
    </div>

   <!-- Modal Edit Mitra -->
    <div class="modal fade" id="editModal{{ $mitra->id }}" aria-labelledby="editModalLabel{{ $mitra->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('mitra.mitra.update', $mitra->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{ $mitra->id }}">Edit Data Mitra</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="jurusan_id" class="form-label">Jurusan</label>
                            <select id="jurusan_id" name="jurusan_id" class="form-select select2 w-100" required>
                                @foreach ($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}" 
                                        {{ old('jurusan_id', $mitra->jurusan->id ?? '') == $jurusan->id ? 'selected' : '' }}>
                                        {{ $jurusan->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="dosen_pembimbing_id" class="form-label">Dosen Pembimbing</label>
                            <select id="dosen_pembimbing_id" name="dosen_pembimbing_id" class="form-select select2 w-100" required>
                                @foreach ($dosenPembimbing as $dosen)
                                    <option value="{{ $dosen->id }}" 
                                        {{ old('dosen_pembimbing_id', $mitra->dosenPembimbing->id ?? '') == $dosen->id ? 'selected' : '' }}>
                                        {{ $dosen->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="tanggal_mulai_magang" class="form-label">Tanggal Mulai Magang</label>
                            <input type="date" id="tanggal_mulai_magang" name="tanggal_mulai_magang" class="form-control" 
                                value="{{ old('tanggal_mulai_magang', $mitra->tanggal_mulai_magang) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_selesai_magang" class="form-label">Tanggal Selesai Magang</label>
                            <input type="date" id="tanggal_selesai_magang" name="tanggal_selesai_magang" class="form-control" 
                                value="{{ old('tanggal_selesai_magang', $mitra->tanggal_selesai_magang) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea id="alamat" name="alamat" class="form-control">{{ old('alamat', $mitra->alamat) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="kuota" class="form-label">Kuota</label>
                            <input type="number" id="kuota" name="kuota" class="form-control" 
                                value="{{ old('kuota', $mitra->kuota) }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">Tutup</span>
                        </button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal View File PKS -->
    <div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pdfModalLabel">Dokumen PKS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <canvas id="pdfCanvas" style="width: 100%;"></canvas>
                </div>
            </div>
        </div>
    </div>
    

</div>
@include('layouts/footer')

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Pilih",
            allowClear: false
        });
    });

    function openPdfModal(pdfUrl) {
        const modal = new bootstrap.Modal(document.getElementById('pdfModal'));
        modal.show();

        const container = document.createElement('div');
        container.style.display = 'flex';
        container.style.flexDirection = 'column';
        container.style.gap = '20px';

        const modalBody = document.querySelector('#pdfModal .modal-body');
        modalBody.innerHTML = ''; // Hapus konten sebelumnya
        modalBody.appendChild(container);

        const loadingTask = pdfjsLib.getDocument(pdfUrl);
        loadingTask.promise.then((pdf) => {
            for (let pageNumber = 1; pageNumber <= pdf.numPages; pageNumber++) {
                const canvas = document.createElement('canvas');
                container.appendChild(canvas);

                pdf.getPage(pageNumber).then((page) => {
                    const viewport = page.getViewport({ scale: 1.5 });
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    const context = canvas.getContext('2d');
                    const renderContext = {
                        canvasContext: context,
                        viewport: viewport,
                    };
                    page.render(renderContext);
                });
            }
        }).catch((error) => {
            console.error('Error loading PDF:', error);
            modalBody.innerHTML = `<p class="text-danger">Error loading PDF: ${error.message}</p>`;
        });
    }

</script>
@endsection
