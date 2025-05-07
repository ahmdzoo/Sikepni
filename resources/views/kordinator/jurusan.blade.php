@extends('layouts.admin.app')

@section('breadcumb', 'Menu /')
@section('page-title', 'Data Jurusan/Prodi')


@section('content')

    
    <div class="container-fluid">
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

        <div class="card">
            <div class="card-body">
                <!-- Tombol Tambah jurusan -->
                <button type="button" class="btn btn-success mb-3 btn-sm" data-toggle="modal" data-target="#addJurusanModal">
                    Add Jurusan/Prodi
                </button>

                <!-- Pembungkus Tabel Responsif -->
                <div class="table-responsive">
                    <!-- Tabel Data jurusan -->
                    <table class="table table-striped table-sm" id="jurusan">
                        <thead class="">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Links dengan Kelas `pagination-sm` -->
                
            </div>
        </div>
    </div>



<!-- Modal Add Jurusan -->
<div class="modal fade" id="addJurusanModal" tabindex="-1" role="dialog" aria-labelledby="addJurusanModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addJurusanModalLabel">Add Jurusan/Prodi</h5>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>

        </div>
        <form action="{{ route('kordinator.jurusan.store') }}" method="POST">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label for="jurusan_name">Nama Jurusan/Prodi</label>
              <input type="text" class="form-control" id="jurusan_name" name="name" placeholder="Masukkan nama jurusan" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add Jurusan/Prodi</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<!-- End Modal Add jurusan -->

<!-- Modal Edit jurusan -->
<div class="modal fade" id="editJurusanModal" tabindex="-1" aria-labelledby="editJurusanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="editJurusanForm" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-header">
            <h5 class="modal-title" id="editJurusanModalLabel">Edit Jurusan/Prodi</h5>
            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
          </div>
          
          <div class="modal-body">
              <input type="hidden" id="editJurusanId" name="id">
              <div class="form-group">
                  <label for="editName">Name</label>
                  <input type="text" class="form-control form-control-sm" id="editName" name="name" required>
              </div>
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- End Modal Edit jurusan -->
  <!-- Modal Delete jurusan -->
<div class="modal fade" id="deleteJurusanModal" tabindex="-1" aria-labelledby="deleteJurusanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="deleteJurusanForm" method="POST">
          @csrf
          @method('DELETE')
          <div class="modal-header">
            <h5 class="modal-title" id="deleteJurusanModalLabel">Confirm Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background: none; border: none;">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          
          <div class="modal-body">
              <p>Are you sure you want to delete this jurusan/prodi?</p>
              <input type="hidden" id="deleteJurusanId" name="id">
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- End Modal Delete jurusan -->
  
  

@endsection

<!-- Tambahkan ini di bagian bawah file untuk menyertakan skrip Bootstrap jika belum ada -->
@push('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush

@section('scripts')
    
<script src="https://cdn.datatables.net/2.1.7/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.1.7/js/dataTables.bootstrap5.min.js"></script>

<script>
   $(document).ready(function () {
    var table = loadData();

    // Tidak perlu menangani pencarian secara manual, DataTables mengurusnya
    $('#datajurusan_filter input[type="search"]').on('keyup change', function() {
             table.ajax.reload(); // Reload tabel saat melakukan pencarian
         });

   
});


    function loadData(){
    $('#jurusan').DataTable({
        processing: true,
        pagination: true,
        responsive: true,
        serverSide: true,
        searching: true,
        ordering: false,
        ajax: {
            url: "{{ route('kordinator.jurusan') }}",
            data: function (d) {
                
                d.search = $('input[type="search"]').val(); // Pastikan ini sesuai dengan apa yang diterima di controller
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
                data: 'name',
                name: 'name',
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-primary btn-sm" onclick="editJurusan(${row.id})" data-toggle="modal" data-target="#editJurusanModal"><i class="bx bx-edit"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="deleteJurusan(${row.id})" data-toggle="modal" data-target="#deleteJurusanModal"><i class="bx bx-trash"></i></button>
                    `;
                }
            },
        ]
    });
}

function editJurusan(id) {
    $.get('/kordinator/jurusan/' + id, function(jurusan) {
        $('#editJurusanId').val(jurusan.id);
        $('#editName').val(jurusan.name);
        $('#editJurusanForm').attr('action', '/kordinator/jurusan/' + jurusan.id);
    });
}

function deleteJurusan(id) {
    $('#deleteJurusanId').val(id);
    $('#deleteJurusanForm').attr('action', '/kordinator/jurusan/' + id);
}



</script>
@endsection