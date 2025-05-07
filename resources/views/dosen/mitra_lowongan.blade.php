@extends('layouts.dosen.app')
@section('breadcumb', 'Menu /')
@section('page-title', 'Data Mitra')

@section('content') 
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Filter Mitra (Jika Ada) -->
                <div class="form-group mb-3">
                    <label for="filter">Filter by:</label>
                    <select name="filter" id="filter" class="form-control form-control-sm">
                        <option value="">All</option>
                        @foreach($jurusans as $jurusan)
                            <option value="{{ $jurusan->id }}">{{ $jurusan->name }}</option>
                        @endforeach
                    </select>
                </div>
                

                <!-- Pembungkus Tabel Responsif -->
                <div class="table-responsive">
                    <!-- Tabel Data Mitra -->
                    <table class="table table-striped table-sm" id="lowongan">
                        <thead>
                            <tr>
                                <th>Dokumen PKS</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Nama Mitra</th>
                                <th>Alamat</th>
                                <th>Kuota</th>
                                <th>Jurusan</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>



<!-- Modal View File PKS -->
<div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfModalLabel">Dokumen PKS</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <canvas id="pdfCanvas" style="width: 100%;"></canvas>
            </div>
        </div>
    </div>
</div>



@endsection

@push('scripts')
<!-- Pastikan jQuery versi penuh dimuat sebelum skrip lainnya -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush

@section('scripts')
<script src="https://cdn.datatables.net/2.1.7/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.1.7/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).on('click', '.ajukan', function() {
        var id = $(this).data('id'); // Ambil ID mitra
        var nama = $(this).data('nama'); // Ambil nama mitra
        $('#mitraId').val(id); // Set ID mitra ke input tersembunyi
        $('#mitraName').text(nama); // Set nama mitra di judul modal
        $('#ajukanLamaranModal').modal('show'); // Tampilkan modal
    });

    $('#submitAjukan').click(function() {
        $('#ajukanLamaranForm').submit(); // Kirim form ketika tombol diklik
    });


    $(document).ready(function () {
         var table = loadData();

         $('#filter').change(function() {
             table.ajax.reload(); // Reload tabel saat filter role diubah
         });
         // Tidak perlu menangani pencarian secara manual, DataTables mengurusnya
         $('#lowongan_filter input[type="search"]').on('keyup change', function() {
             table.ajax.reload(); // Reload tabel saat melakukan pencarian
         });

         // Refresh jurusan dropdown setelah menambah jurusan baru
          $('#addJurusanModal').on('hidden.bs.modal', function () {
              // Mengambil data jurusan terbaru via AJAX atau reload halaman
              // Berikut adalah contoh reload halaman
              location.reload();
          });

     });

     

    function loadData() {
         return $('#lowongan').DataTable({
             processing: true,
             pagination: true,
             responsive: true,
             serverSide: true,
             searching: true,
             ordering: false,
             ajax: {
                 url: "{{ route('mitra_lowongan') }}",
                 data: function (d) {
                     d.filter = $('#filter').val(); // Menambahkan filter ke data yang dikirim
                     d.search = $('input[type="search"]').val();
                 }
             },
             columns: [
                {
                    data: 'file_pks',
                    name: 'file_pks',
                    render: function (data, type, row) {
                    if (row.file_pks) {
                            return `<a href="javascript:void(0)" class="action-btn btn-sm btn-info" onclick="viewFile('/storage/${row.file_pks}')">Lihat</a>`;
                        } else {
                            return `<span class="text-muted">Tidak ada file</span>`;
                        }
                    }
                },
                 {
                     data: 'tanggal_mulai_magang',
                     name: 'tanggal_mulai_magang',
                     className: 'text-center',
                 },
                 {
                     data: 'tanggal_selesai_magang',
                     name: 'tanggal_selesai_magang',
                     className: 'text-center',
                 },
                 {
                     data: 'mitra_user', // Mengambil nama mitra dari relasi
                     name: 'mitra_user',
                 },
                 {
                     data: 'alamat',
                     name: 'alamat',
                 },
                 {
                     data: 'kuota',
                     name: 'kuota',
                     className: 'text-center',
                 },
                 {
                     data: 'jurusan', // Mengambil nama jurusan dari relasi
                     name: 'jurusan',
                 },
                 
                 

             ]
         });
     }

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
                    const viewport = page.getViewport({
                        scale: 1.5
                    });
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
    function viewFile(pdfUrl) {
    openPdfModal(pdfUrl);
}

    
</script>
@endsection
