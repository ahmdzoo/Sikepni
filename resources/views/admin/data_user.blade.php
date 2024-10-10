@extends('layouts.main')
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.bootstrap5.min.css" />
@endsection
@section('content')
<div class="content-wrapper" style="background: linear-gradient(to bottom, #80b8c7, #fff ); min-height: 100vh;">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-4" style="font-size: 50px; color: white; font-weight: bold;">Data User</h1>
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

        <div class="card">
            <div class="card-body">
                <!-- Tombol Tambah User -->
                <button type="button" class="btn btn-success mb-3 btn-sm" data-toggle="modal" data-target="#addUserModal">
                    Add User
                </button>
                
                <!-- Filter Role -->
                <form method="GET" action="{{ route('data_user') }}" class="mb-3">
                    <div class="form-group">
                        <label for="role">Filter by Role:</label>
                        <select name="role" id="role" class="form-control form-control-sm" onchange="this.form.submit()">
                            <option value="">All</option>
                            <option value="mahasiswa" {{ request('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="dosen_pembimbing" {{ request('role') == 'dosen_pembimbing' ? 'selected' : '' }}>Dosen Pembimbing</option>
                            <option value="mitra_magang" {{ request('role') == 'mitra_magang' ? 'selected' : '' }}>Mitra Magang</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                </form>

                <!-- Pembungkus Tabel Responsif -->
                <div class="table-responsive">
                    <!-- Tabel Data User -->
                    <table class="table table-striped table-sm" id="datauser">
                        <thead class="">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
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
</div>

<!-- Modal Add User -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('store_user') }}" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="modal-body">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control form-control-sm" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control form-control-sm" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" id="role" class="form-control form-control-sm" required>
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="dosen_pembimbing">Dosen Pembimbing</option>
                    <option value="mitra_magang">Mitra Magang</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control form-control-sm" id="password" name="password" required>
            </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btn-sm">Add User</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- End Modal Add User -->
<!-- Modal Edit User -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="editUserForm" method="POST">
          @csrf
          @method('PUT')
          <div class="modal-header">
            <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          
          <div class="modal-body">
              <input type="hidden" id="editUserId" name="id">
              <div class="form-group">
                  <label for="editName">Name</label>
                  <input type="text" class="form-control form-control-sm" id="editName" name="name" required>
              </div>
              <div class="form-group">
                  <label for="editEmail">Email</label>
                  <input type="email" class="form-control form-control-sm" id="editEmail" name="email" required>
              </div>
              <div class="form-group">
                  <label for="editRole">Role</label>
                  <select name="role" id="editRole" class="form-control form-control-sm" required>
                      <option value="mahasiswa">Mahasiswa</option>
                      <option value="dosen_pembimbing">Dosen Pembimbing</option>
                      <option value="mitra_magang">Mitra Magang</option>
                      <option value="admin">Admin</option>
                  </select>
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
  <!-- End Modal Edit User -->
  <!-- Modal Delete User -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form id="deleteUserForm" method="POST">
          @csrf
          @method('DELETE')
          <div class="modal-header">
            <h5 class="modal-title" id="deleteUserModalLabel">Confirm Delete</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          
          <div class="modal-body">
              <p>Are you sure you want to delete this user?</p>
              <input type="hidden" id="deleteUserId" name="id">
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- End Modal Delete User -->
  
  

@endsection

<!-- Tambahkan ini di bagian bawah file untuk menyertakan skrip Bootstrap jika belum ada -->
@push('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush

@section('scripts')
    
<script src="https://cdn.datatables.net/2.1.7/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.1.7/js/dataTables.bootstrap5.min.js"></script>

<script>
   $(document).ready(function () {
    var table = loadData();

    $('#role').change(function() {
        table.ajax.reload(); // Reload tabel saat filter role diubah
    });

    // Tidak perlu menangani pencarian secara manual, DataTables mengurusnya
    $('#datauser_filter input[type="search"]').on('keyup change', function() {
        table.ajax.reload(); // Reload tabel saat melakukan pencarian
    });
});


    function loadData(){
    $('#datauser').DataTable({
        processing: true,
        pagination: true,
        responsive: true,
        serverSide: true,
        searching: true,
        ordering: false,
        ajax: {
            url: "{{ route('data_user') }}",
            data: function (d) {
                d.role = $('#role').val(); // Menambahkan parameter role
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
                data: 'email',
                name: 'email',
            },
            {
                data: 'role',
                name: 'role',
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-primary btn-sm" onclick="editUser(${row.id})" data-toggle="modal" data-target="#editUserModal">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteUser(${row.id})" data-toggle="modal" data-target="#deleteUserModal">Delete</button>
                    `;
                }
            },
        ]
    });
}

function editUser(id) {
    $.get('/admin/users/' + id, function(user) {
        $('#editUserId').val(user.id);
        $('#editName').val(user.name);
        $('#editEmail').val(user.email);
        $('#editRole').val(user.role);
        $('#editUserForm').attr('action', '/admin/users/' + user.id);
    });
}

function deleteUser(id) {
    $('#deleteUserId').val(id);
    $('#deleteUserForm').attr('action', '/admin/users/' + id);
}



</script>
@include('layouts/footer')
@endsection


