@extends('layouts.mhs')
@section('title', 'Program Magang | SIKEPNI')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.bootstrap5.min.css" />
@endsection

@section('content')
<div class="content-wrapper" style="background: linear-gradient(to bottom, #80b8c7, #fff ); min-height: 100vh;">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-4" style="font-size: 50px; color: white; font-weight: bold;">Program Magang</h1>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid">
       <!-- Pesan Sukses -->
       @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Pesan Kesalahan -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


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
                                <th>No.PKS</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Nama Mitra</th>
                                <th>Jurusan</th>
                                <th>Dosen Pembimbing</th>
                                <th>Actions</th>
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

<!-- Modal Ajukan Lamaran -->
<div class="modal fade" id="ajukanLamaranModal" tabindex="-1" role="dialog" aria-labelledby="ajukanLamaranModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="ajukanLamaranModalLabel">Ajukan Lamaran untuk <span id="mitraName"></span></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <form id="ajukanLamaranForm" action="{{ route('lamaran.store') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="mitra_id" id="mitraId">
                  <div class="form-group">
                      <label for="cv">Upload CV</label>
                      <input type="file" class="form-control" id="cv" name="cv" required>
                  </div>
                  <div class="form-group">
                      <label for="catatan">Catatan (Opsional)</label>
                      <textarea class="form-control" id="catatan" name="catatan"></textarea>
                  </div>
              </form>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" id="submitAjukan">Kirim Lamaran</button>
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
                 url: "{{ route('mhs_lowongan') }}",
                 data: function (d) {
                     d.filter = $('#filter').val(); // Menambahkan filter ke data yang dikirim
                     d.search = $('input[type="search"]').val();
                 }
             },
             columns: [
                 {
                     data: 'no_pks',
                     name: 'no_pks',
                 },
                 {
                     data: 'tgl_mulai',
                     name: 'tgl_mulai',
                     className: 'text-center',
                 },
                 {
                     data: 'tgl_selesai',
                     name: 'tgl_selesai',
                     className: 'text-center',
                 },
                 {
                     data: 'mitra_user', // Mengambil nama mitra dari relasi
                     name: 'mitra_user',
                 },
                 {
                     data: 'jurusan', // Mengambil nama jurusan dari relasi
                     name: 'jurusan',
                 },
                 {
                     data: 'dosen_pembimbing', // Mengambil nama dosen pembimbing dari relasi
                     name: 'dosen_pembimbing',
                 },
                 {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return `
                            <button class="btn btn-primary btn-sm ajukan" data-id="${row.id}" data-nama="${row.mitra_user}">Ajukan Lamaran</button>
                        `;
                    },
                    className: 'text-center',
                }

             ]
         });
     }

   
  

    
</script>
@include('layouts/footer')
@endsection
