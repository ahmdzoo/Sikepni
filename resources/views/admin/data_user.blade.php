@extends('layouts.main')
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
                    <table class="table table-striped table-sm">
                        <thead class="thead-dark">
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $index => $user)
                            <tr>
                                <td>{{ ($users->currentPage()-1) * $users->perPage() + $index + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $user->role)) }}</td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editUserModal{{ $user->id }}">
                                        Edit
                                    </button>

                                    <!-- Tombol Delete -->
                                    <form action="{{ route('delete_user', $user->id) }}" method="POST" style="display:inline-block">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">
                                            Delete
                                        </button>
                                    </form>

                                    <!-- Modal Edit User -->
                                    <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
                                      <div class="modal-dialog">
                                        <div class="modal-content">
                                          <form action="{{ route('update_user', $user->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                              <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">Edit User</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="name{{ $user->id }}">Name</label>
                                                    <input type="text" class="form-control form-control-sm" id="name{{ $user->id }}" name="name" value="{{ $user->name }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="email{{ $user->id }}">Email</label>
                                                    <input type="email" class="form-control form-control-sm" id="email{{ $user->id }}" name="email" value="{{ $user->email }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="role{{ $user->id }}">Role</label>
                                                    <select name="role" id="role{{ $user->id }}" class="form-control form-control-sm" required>
                                                        <option value="mahasiswa" {{ $user->role == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                                        <option value="dosen_pembimbing" {{ $user->role == 'dosen_pembimbing' ? 'selected' : '' }}>Dosen Pembimbing</option>
                                                        <option value="mitra_magang" {{ $user->role == 'mitra_magang' ? 'selected' : '' }}>Mitra Magang</option>
                                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="password{{ $user->id }}">Password (leave blank to keep current password)</label>
                                                    <input type="password" class="form-control form-control-sm" id="password{{ $user->id }}" name="password">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                                              <button type="submit" class="btn btn-primary btn-sm">Update User</button>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                    <!-- End Modal Edit User -->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Links dengan Kelas `pagination-sm` -->
                <div class="d-flex justify-content-center">
                    {{ $users->links('pagination::bootstrap-4') }}
                </div>
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

@endsection

<!-- Tambahkan ini di bagian bawah file untuk menyertakan skrip Bootstrap jika belum ada -->
@push('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush

{{-- @push('styles')
<style>
    /* Mengatur ukuran font dan padding untuk pagination */
    .pagination {
        font-size: 0.8rem; /* Ukuran font lebih kecil */
    }

    .pagination li.page-item a.page-link,
    .pagination li.page-item span.page-link {
        padding: 0.2rem 0.4rem; /* Padding lebih kecil */
        font-size: 0.8rem; /* Ukuran font lebih kecil */
    }

    /* Mengatur ukuran ikon jika menggunakan ikon berbasis font, misalnya Font Awesome */
    .pagination li.page-item a.page-link i,
    .pagination li.page-item span.page-link i {
        font-size: 0.8rem; /* Ukuran ikon lebih kecil */
    }

    /* Responsif pada layar sangat kecil */
    @media (max-width: 576px) {
        .content-header h1 {
            font-size: 30px !important;
        }

        .btn {
            font-size: 0.7rem;
            padding: 0.2rem 0.4rem;
        }

        .form-group label {
            font-size: 0.8rem;
        }

        .form-control {
            font-size: 0.8rem;
        }

        .modal-title {
            font-size: 1.2rem;
        }
    }
</style>
@endpush --}}
