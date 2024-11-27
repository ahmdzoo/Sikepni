@extends('layouts.dosen')
@section('title', 'Program Magang | SIKEPNI')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.bootstrap5.min.css" />
@endsection

@section('content')
<div class="content-wrapper" style=" min-height: 100vh;">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-4" style="font-size: 30px; color: white; font-weight: bold;">Daftar Mitra</h1>
                </div>
            </div>
        </div>
    </div>
    
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
                                <th>Dosen Pembimbing</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>
</div>


<!-- Modal untuk Menampilkan File PDF 2 -->
<div id="fileModal" class="modal fade" tabindex="-1" aria-labelledby="fileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fileModalLabel">DOKUMEN PKS</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Tombol Zoom -->
                <div class="zoom-controls">
                    <button id="zoomIn" class="btn btn-primary">+</button>
                    <button id="zoomOut" class="btn btn-primary">-</button>
                </div>

                <!-- Tempat PDF ditampilkan -->
                <div id="pdfCanvas" style="width: 100%; height: auto; overflow: auto; transform-origin: center center;">
                    <!-- PDF content akan ditampilkan di sini -->
                </div>
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
                 {
                     data: 'dosen_pembimbing', // Mengambil nama dosen pembimbing dari relasi
                     name: 'dosen_pembimbing',
                 }
                 

             ]
         });
     }

     $(document).on('click', '.lihat-file', function () {
        var filePath = $(this).data('file');
        var fileUrl = `/storage/${filePath}`; // Path ke file

        $('#previewFrame').attr('src', fileUrl); // Set file ke iframe
        $('#previewFileModal').modal('show'); // Tampilkan modal
    });

    let zoomLevel = 1;  // Menyimpan tingkat zoom default

    // Fungsi untuk melakukan zoom in
    document.getElementById('zoomIn').addEventListener('click', function() {
        zoomLevel += 0.1;  // Menambah zoom level
        updateZoom();      // Memperbarui tampilan zoom pada PDF
    });

    // Fungsi untuk melakukan zoom out
    document.getElementById('zoomOut').addEventListener('click', function() {
        if (zoomLevel > 0.1) {  // Menjamin agar zoom level tidak menjadi terlalu kecil
            zoomLevel -= 0.1;  // Mengurangi zoom level
            updateZoom();      // Memperbarui tampilan zoom pada PDF
        }
    });

    // Fungsi untuk memperbarui zoom dan memuat ulang konten PDF
    function updateZoom() {
        const viewerContainer = document.getElementById('pdfCanvas');
        viewerContainer.innerHTML = ""; // Hapus konten PDF lama

        // Ambil URL PDF yang akan ditampilkan
        const url = document.getElementById('fileModal').getAttribute('data-file-url');

        // Muat ulang PDF dengan zoom yang baru
        pdfjsLib.getDocument(url).promise.then(function(pdfDoc_) {
            var pdfDoc = pdfDoc_;
            var totalPages = pdfDoc.numPages;

            // Loop untuk memuat ulang halaman PDF dengan zoom yang baru
            for (var pageNum = 1; pageNum <= totalPages; pageNum++) {
                pdfDoc.getPage(pageNum).then(function(page) {
                    var canvas = document.createElement('canvas');
                    var context = canvas.getContext('2d');
                    var viewport = page.getViewport({ scale: zoomLevel });  // Gunakan zoom level yang sudah diperbarui
                    canvas.height = viewport.height;
                    canvas.width = viewport.width;

                    // Render halaman PDF ke dalam canvas
                    page.render({
                        canvasContext: context,
                        viewport: viewport
                    });

                    // Tambahkan canvas ke dalam viewer container
                    viewerContainer.appendChild(canvas);
                });
            }
        }).catch(function(error) {
            console.error('Error loading PDF: ', error);
            alert('Terjadi kesalahan saat memuat file PDF.');
        });
    }

    // Fungsi untuk menampilkan PDF di dalam modal
    function viewFile(filePath) {
        var viewerContainer = document.getElementById('pdfCanvas');
        var url = filePath;

        // Pastikan modal terbuka terlebih dahulu
        $('#fileModal').modal('show');

        // Set URL file PDF ke atribut data-file-url modal
        $('#fileModal').attr('data-file-url', url);

        // Delay kecil untuk memastikan modal terbuka sepenuhnya
        setTimeout(function() {
            updateZoom();  // Memperbarui tampilan PDF setelah modal terbuka
        }, 500); // Waktu delay 500ms (sesuaikan sesuai kebutuhan)
    }

  

    
</script>
@include('layouts/footer')
@endsection
