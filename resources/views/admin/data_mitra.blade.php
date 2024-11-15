@extends('layouts.main')
@section('title', 'Data Mitra | SIKEPNI')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.bootstrap5.min.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    
</style>

@endsection

@section('content')
<div class="content-wrapper" style="background: linear-gradient(to bottom, #80b8c7, #fff ); min-height: 100vh;">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-4" style="font-size: 50px; color: white; font-weight: bold;">Data Mitra</h1>
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
                <!-- Tombol Tambah Mitra & Jurusan -->
                <button type="button" class="btn btn-success mb-3 btn-sm" data-toggle="modal" data-target="#addMitraModal">
                    Add Mitra
                </button>
                
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
                    <table class="table table-striped table-sm" id="datamitra">
                        <thead>
                            <tr>
                                <th>No</th>
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

<!-- Modal Add Mitra -->
<div class="modal fade" id="addMitraModal" role="dialog" aria-labelledby="addMitraModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addMitraModalLabel">Add Mitra</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('store_mitra') }}" method="POST">
          @csrf
          <div class="modal-body">
            <div class="form-group">
                <label for="nama_mitra_id">Nama Mitra</label>
                <select class="form-control select2" id="nama_mitra_id" name="nama_mitra_id" required>
                  <option value="" disabled selected>Pilih Mitra</option>
                @foreach($mitrasMagang as $user)
                  <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="no_pks">No. PKS</label>
              <input type="text" class="form-control" id="no_pks" name="no_pks" required>
            </div>
            <div class="form-group">
              <label for="tgl_mulai">Tanggal Mulai</label>
              <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai" required>
            </div>
            <div class="form-group">
              <label for="tgl_selesai">Tanggal Selesai</label>
              <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai" required>
            </div>
            <div class="form-group">
              <label for="jurusan_id">Jurusan</label>
              <div class="input-group">
                <select class="form-control select2" id="jurusan_id" name="jurusan_id" required>
                  <option value="" disabled selected>Pilih Jurusan</option>
                  @foreach($jurusans as $jurusan)
                    <option value="{{ $jurusan->id }}">{{ $jurusan->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="dosen_pembimbing_id">Dosen Pendamping</label>
              <select class="form-control select2" id="dosen_pembimbing_id" name="dosen_pembimbing_id" required>
                <option value="" disabled selected>Pilih Dosen Pendamping</option>
                @foreach($dosen_pembimbing as $dosen)
                  <option value="{{ $dosen->id }}">{{ $dosen->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add Mitra</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  
  <!-- Modal Add Jurusan -->
  <div class="modal fade" id="addJurusanModal" tabindex="-1" role="dialog" aria-labelledby="addJurusanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addJurusanModalLabel">Add Jurusan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('jurusan.store') }}" method="POST">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="jurusan_name">Nama Jurusan</label>
              <input type="text" class="form-control" id="jurusan_name" name="name" placeholder="Masukkan nama jurusan" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add Jurusan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

    <!-- Modal Edit Mitra -->
<div class="modal fade" id="editMitraModal"  role="dialog" aria-labelledby="editMitraModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMitraModalLabel">Edit Mitra</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" method="POST" id="editMitraForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="editMitraId" name="id"> <!-- Menyimpan ID Mitra yang akan diedit -->
                    <div class="form-group">
                        <label for="edit_nama_mitra_id">Nama Mitra</label>
                        <select class="form-control select2" id="edit_nama_mitra_id" name="nama_mitra_id" required>
                            <option value="" disabled>Pilih Mitra</option>
                            @foreach($mitrasMagang as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_no_pks">No. PKS</label>
                        <input type="text" class="form-control" id="edit_no_pks" name="no_pks" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_tgl_mulai">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="edit_tgl_mulai" name="tgl_mulai" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_tgl_selesai">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="edit_tgl_selesai" name="tgl_selesai" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_jurusan_id">Jurusan</label>
                        <div class="input-group">
                            <select class="form-control select2" id="edit_jurusan_id" name="jurusan_id" required>
                                <option value="" disabled>Pilih Jurusan</option>
                                @foreach($jurusans as $jurusan)
                                    <option value="{{ $jurusan->id }}">{{ $jurusan->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_dosen_pembimbing_id">Dosen Pendamping</label>
                        <select class="form-control select2" id="edit_dosen_pembimbing_id" name="dosen_pembimbing_id" required>
                            <option value="" disabled>Pilih Dosen Pendamping</option>
                            @foreach($dosen_pembimbing as $dosen)
                                <option value="{{ $dosen->id }}">{{ $dosen->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Mitra</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Edit Mitra -->

    <!-- Modal Delete Mitra -->
    <div class="modal fade" id="deleteMitraModal" tabindex="-1" aria-labelledby="deleteMitraModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteMitraForm" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-header">
                <h5 class="modal-title" id="deleteMitraModalLabel">Confirm Delete</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <p>Are you sure you want to delete this Mitra?</p>
                <input type="hidden" id="deleteMitraId" name="id">
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </div>
            </form>
        </div>
        </div>
    </div>
    <!-- End Modal Delete Mitra -->
@endsection

@push('scripts')
<!-- Pastikan jQuery versi penuh dimuat sebelum skrip lainnya -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/2.1.7/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.1.7/js/dataTables.bootstrap5.min.js"></script>


<script>
    // Setup AJAX dengan CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    const routes = {
        edit: "{{ url('/admin/mitra') }}/", // Base URL untuk edit
        destroy: "{{ url('/admin/mitra') }}/", // Base URL untuk delete
    };

    $(document).ready(function() {
        $('#addMitraModal').on('shown.bs.modal', function () {
            $('.select2').select2({
            });
        });
    });

    $(document).ready(function() {
        $('#editMitraModal').on('shown.bs.modal', function () {
            $('.select2').select2({
            });
        });
    });


    $(document).ready(function () {
         var table = loadData();

         $('#filter').change(function() {
             table.ajax.reload(); // Reload tabel saat filter role diubah
         });
         // Tidak perlu menangani pencarian secara manual, DataTables mengurusnya
         $('#datamitra_filter input[type="search"]').on('keyup change', function() {
             table.ajax.reload(); // Reload tabel saat melakukan pencarian
         });

         // Refresh jurusan dropdown setelah menambah jurusan baru
          $('#addJurusanModal').on('hidden.bs.modal', function () {
              // Mengambil data jurusan terbaru via AJAX atau reload halaman
              // Berikut adalah contoh reload halaman
              location.reload();
          });


     });

     $(document).on('click', '.edit', function() {
          var id = $(this).data('id'); // Ambil ID dari atribut data-id
          editMitra(id);
      });

      $(document).on('click', '.delete', function() {
          var id = $(this).data('id'); // Ambil ID dari atribut data-id
          deleteMitra(id);
      });

    function loadData() {
         return $('#datamitra').DataTable({
             processing: true,
             pagination: true,
             responsive: true,
             serverSide: true,
             searching: true,
             ordering: false,
             ajax: {
                 url: "{{ route('data_mitra') }}",
                 data: function (d) {
                     d.filter = $('#filter').val(); // Menambahkan filter ke data yang dikirim
                     d.search = $('input[type="search"]').val();
                 }
             },
             columns: [
                 {
                     data: null,
                     name: 'no',
                     render: function (data, type, row, meta) {
                         return meta.row + meta.settings._iDisplayStart + 1;
                     },
                     orderable: false,
                     searchable: false
                 },
                 {
                     data: 'no_pks',
                     name: 'no_pks',
                 },
                 {
                     data: 'tgl_mulai',
                     name: 'tgl_mulai',
                 },
                 {
                     data: 'tgl_selesai',
                     name: 'tgl_selesai',
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
                             <button class="btn btn-primary btn-sm edit" data-id="${row.id}">Edit</button>
                             <button class="btn btn-danger btn-sm delete" data-id="${row.id}" data-toggle="modal" data-target="#deleteMitraModal">Delete</button>
                         `;
                     }
                 },
             ]
         });
     }

   function editMitra(id) {
       $.get(`${routes.edit}${id}/edit`, function (data) { // Pastikan URL sesuai
           $('#editMitraId').val(data.id);
           $('#edit_no_pks').val(data.no_pks);
           $('#edit_tgl_mulai').val(data.tgl_mulai);
           $('#edit_tgl_selesai').val(data.tgl_selesai);
           $('#edit_nama_mitra_id').val(data.nama_mitra_id);
           $('#edit_jurusan_id').val(data.jurusan_id);
           $('#edit_dosen_pembimbing_id').val(data.dosen_pembimbing_id);
           // Set action URL
           $('#editMitraForm').attr('action', `/admin/mitra/${id}`);
           // Buka modal setelah data diisi
           $('#editMitraModal').modal('show');
       }).fail(function(xhr) {
           console.error('editMitra error:', xhr.responseText);
           alert('Terjadi kesalahan saat memuat data Mitra.');
       });
   }

   function deleteMitra(id) {
       $('#deleteMitraId').val(id);
       $('#deleteMitraForm').attr('action', `/admin/mitra/${id}`);
   }

  

    
</script>
@include('layouts/footer')
@endsection
