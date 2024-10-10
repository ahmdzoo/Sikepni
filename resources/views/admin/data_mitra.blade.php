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
                <!-- Tombol Tambah Mitra dan Tambah Jurusan -->
                <button type="button" class="btn btn-success mb-3 btn-sm" data-toggle="modal" data-target="#addMitraModal">
                    Add Mitra
                </button>
                <button type="button" class="btn btn-info mb-3 btn-sm" data-toggle="modal" data-target="#addJurusanModal">
                    Add Jurusan
                </button>

                <!-- Pembungkus Tabel Responsif -->
                <div class="table-responsive">
                    <!-- Tabel Data Mitra -->
                    <table class="table table-striped table-sm" id="datamitra">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No. PKS</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Nama Mitra</th>
                                <th>Jurusan</th>
                                <th>Dosen Pembimbing</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mitras as $mitra)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $mitra->no_pks }}</td>
                                    <td>{{ \Carbon\Carbon::parse($mitra->tgl_mulai)->format('d-m-Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($mitra->tgl_selesai)->format('d-m-Y') }}</td>
                                    <td>{{ $mitra->mitraUser->name }}</td>
                                    <td>{{ $mitra->jurusan->name }}</td>
                                    <td>{{ $mitra->dosenPembimbing->name }}</td>
                                    <td>
                                        <!-- Tombol Edit Mitra -->
                                        <a href="javascript:void(0)" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editMitraModal{{ $mitra->id }}">Edit</a>
                                        
                                        <!-- Modal Edit Mitra -->
                                        <div class="modal fade" id="editMitraModal{{ $mitra->id }}" tabindex="-1" role="dialog" aria-labelledby="editMitraModalLabel{{ $mitra->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editMitraModalLabel{{ $mitra->id }}">Edit Mitra</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ route('mitras.update', $mitra->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label for="nama_mitra_id">Nama Mitra</label>
                                                                <select class="form-control" id="nama_mitra_id" name="nama_mitra_id" required>
                                                                    <option value="" disabled>Pilih Mitra</option>
                                                                    @foreach($mitrasMagang as $user)
                                                                        <option value="{{ $user->id }}" {{ $mitra->nama_mitra_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="no_pks">No. PKS</label>
                                                                <input type="text" class="form-control" id="no_pks" name="no_pks" value="{{ $mitra->no_pks }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="tgl_mulai">Tanggal Mulai</label>
                                                                <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai" value="{{ \Carbon\Carbon::parse($mitra->tgl_mulai)->format('Y-m-d') }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="tgl_selesai">Tanggal Selesai</label>
                                                                <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai" value="{{ \Carbon\Carbon::parse($mitra->tgl_selesai)->format('Y-m-d') }}" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="jurusan_id">Jurusan</label>
                                                                <div class="input-group">
                                                                    <select class="form-control" id="jurusan_id" name="jurusan_id" required>
                                                                        <option value="" disabled>Pilih Jurusan</option>
                                                                        @foreach($jurusans as $jurusan)
                                                                            <option value="{{ $jurusan->id }}" {{ $mitra->jurusan_id == $jurusan->id ? 'selected' : '' }}>{{ $jurusan->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div class="input-group-append">
                                                                        <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#addJurusanModal">
                                                                            Tambah Jurusan
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="dosen_pembimbing_id">Dosen Pendamping</label>
                                                                <select class="form-control" id="dosen_pembimbing_id" name="dosen_pembimbing_id" required>
                                                                    <option value="" disabled>Pilih Dosen Pendamping</option>
                                                                    @foreach($dosen_pembimbing as $dosen)
                                                                        <option value="{{ $dosen->id }}" {{ $mitra->dosen_pembimbing_id == $dosen->id ? 'selected' : '' }}>{{ $dosen->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tombol Delete Mitra -->
                                        <a href="javascript:void(0)" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteMitraModal{{ $mitra->id }}">Delete</a>

                                        <!-- Modal Delete Mitra -->
                                        <div class="modal fade" id="deleteMitraModal{{ $mitra->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteMitraModalLabel{{ $mitra->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteMitraModalLabel{{ $mitra->id }}">Delete Mitra</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus mitra ini?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="{{ route('mitras.destroy', $mitra->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Mitra -->
<div class="modal fade" id="addMitraModal" tabindex="-1" role="dialog" aria-labelledby="addMitraModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addMitraModalLabel">Add Mitra</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('mitras.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="nama_mitra_id">Nama Mitra</label>
            <select class="form-control" id="nama_mitra_id" name="nama_mitra_id" required>
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
              <select class="form-control" id="jurusan_id" name="jurusan_id" required>
                <option value="" disabled selected>Pilih Jurusan</option>
                @foreach($jurusans as $jurusan)
                  <option value="{{ $jurusan->id }}">{{ $jurusan->name }}</option>
                @endforeach
              </select>
              <div class="input-group-append">
                <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#addJurusanModal">
                  Tambah Jurusan
                </button>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="dosen_pembimbing_id">Dosen Pendamping</label>
            <select class="form-control" id="dosen_pembimbing_id" name="dosen_pembimbing_id" required>
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

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush

@section('scripts')
<script src="https://cdn.datatables.net/2.1.7/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.1.7/js/dataTables.bootstrap5.min.js"></script>

<script>
   $(document).ready(function () {
    $('#datamitra').DataTable({
        // Konfigurasi DataTables jika diperlukan
    });

    // Refresh jurusan dropdown setelah menambah jurusan baru
    $('#addJurusanModal').on('hidden.bs.modal', function () {
        // Mengambil data jurusan terbaru via AJAX atau reload halaman
        // Berikut adalah contoh reload halaman
        location.reload();
    });
});
</script>
@endsection
