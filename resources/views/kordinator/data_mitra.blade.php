@extends('layouts.admin.app')

@section('breadcumb', 'Menu /')
@section('page-title', 'Data Mitra')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .highlight-pending {
        background-color: #fff3cd !important;
    }
</style>
@endpush


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

        @if($pendingMitraCount > 0)
        <div class="alert alert-warning alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
            <strong>Perhatian!</strong> Ada {{ $pendingMitraCount }} mitra yang belum diverifikasi.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="background: none; border: none;">
                <span aria-hidden="true">&times;</span>
            </button>
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
                    <table class="table table-sm" id="datamitra">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-left">Dokumen PKS</th>
                                <th class="text-center">Tgl Mulai PKS</th>
                                <th class="text-center">Tgl Selesai PKS</th>
                                <th class="text-left">Nama Mitra</th>
                                <th class="text-left">Alamat</th>
                                <th class="text-center">Kuota</th>
                                <th class="text-left">Jurusan/Prodi</th>
                                <th class="text-center">Mulai Magang</th>
                                <th class="text-center">Selesai Magang</th>
                                <!-- <th class="text-center">Status</th> -->
                                <th class="text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
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
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>

            </div>
            <form action="{{ route('kordinator.store_mitra') }}" method="POST" enctype="multipart/form-data">
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
                        <label for="tgl_mulai">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai" required>
                    </div>
                    <div class="form-group">
                        <label for="tgl_selesai">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai" required>
                    </div>
                    <div class="form-group">
                        <label for="jurusan_id">Jurusan/Prodi</label>
                        <div class="input-group">
                            <select class="form-control select2" id="jurusan_id" name="jurusan_id" required>
                                <option value="" disabled selected>Pilih Jurusan/Prodi</option>
                                @foreach($jurusans as $jurusan)
                                <option value="{{ $jurusan->id }}">{{ $jurusan->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat <small>(Opsional)</small></label>
                        <input type="text" class="form-control" id="alamat" name="alamat">
                    </div>
                    <div class="form-group">
                        <label for="kuota">Kuota <small>(Opsional)</small></label>
                        <input type="number" class="form-control" id="kuota" name="kuota">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_mulai_magang">Mulai Magang <small>(Opsional)</small></label>
                        <input type="date" class="form-control" id="tanggal_mulai_magang" name="tanggal_mulai_magang">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_selesai_magang">Selesai Magang <small>(Opsional)</small></label>
                        <input type="date" class="form-control" id="tanggal_selesai_magang" name="tanggal_selesai_magang">
                    </div>
                    <div class="form-group">
                        <label for="file_pks">Upload File PKS</label>
                        <input type="file" class="form-control-file" id="file_pks" name="file_pks" accept=".pdf">
                        <small class="text-muted">Format file harus PDF, ukuran maksimal 5MB.</small>
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
<!-- End Modal Add Mitra -->

<!-- Modal Edit Mitra -->
<div class="modal fade" id="editMitraModal" role="dialog" aria-labelledby="editMitraModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMitraModalLabel">Edit Mitra</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="#" method="POST" id="editMitraForm" enctype="multipart/form-data">
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
                        <label for="edit_tgl_mulai">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="edit_tgl_mulai" name="tgl_mulai" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_tgl_selesai">Tanggal Selesai</label>
                        <input type="date" class="form-control" id="edit_tgl_selesai" name="tgl_selesai" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_jurusan_id">Jurusan/Prodi</label>
                        <div class="input-group">
                            <select class="form-control select2" id="edit_jurusan_id" name="jurusan_id" required>
                                <option value="" disabled>Pilih Jurusan/Prodi</option>
                                @foreach($jurusans as $jurusan)
                                <option value="{{ $jurusan->id }}">{{ $jurusan->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="edit_alamat">Alamat <small>(Opsional)</small></label>
                        <input type="text" class="form-control" id="edit_alamat" name="alamat">
                    </div>
                    <div class="form-group">
                        <label for="edit_kuota">Kuota <small>(Opsional)</small></label>
                        <input type="number" class="form-control" id="edit_kuota" name="kuota">
                    </div>
                    <div class="form-group">
                        <label for="edit_tanggal_mulai_magang">Mulai Magang <small>(Opsional)</small></label>
                        <input type="date" class="form-control" id="edit_tanggal_mulai_magang" name="tanggal_mulai_magang">
                    </div>
                    <div class="form-group">
                        <label for="edit_tanggal_selesai_magang">Selesai Magang <small>(Opsional)</small></label>
                        <input type="date" class="form-control" id="edit_tanggal_selesai_magang" name="tanggal_selesai_magang">
                    </div>
                    <div class="form-group">
                        <label for="edit_file_pks">Upload File PKS</label>
                        <small class="text-muted">Kosongkan Jika tidak ingin diperbarui</small>
                        <input type="file" class="form-control-file" id="edit_file_pks" name="file_pks" accept=".pdf">
                        <small class="text-muted">Format file harus PDF, ukuran maksimal 5MB.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
        edit: "{{ url('/kordinator/mitra') }}/", // Base URL untuk edit
        destroy: "{{ url('/kordinator/mitra') }}/", // Base URL untuk delete
    };

    $('#addMitraModal').on('shown.bs.modal', function () {
        $('#nama_mitra_id').select2({ dropdownParent: $('#addMitraModal') });
        $('#jurusan_id').select2({ dropdownParent: $('#addMitraModal') });
    });

    $('#editMitraModal').on('shown.bs.modal', function () {
        $('#edit_nama_mitra_id').select2({ dropdownParent: $('#editMitraModal') });
        $('#edit_jurusan_id').select2({ dropdownParent: $('#editMitraModal') });
    });


    $(document).ready(function() {
        var table = loadData();

        $('#filter').change(function() {
            table.ajax.reload(); // Reload tabel saat filter role diubah
        });
        // Tidak perlu menangani pencarian secara manual, DataTables mengurusnya
        $('#datamitra_filter input[type="search"]').on('keyup change', function() {
            table.ajax.reload(); // Reload tabel saat melakukan pencarian
        });

        // Refresh jurusan dropdown setelah menambah jurusan baru
        $('#addJurusanModal').on('hidden.bs.modal', function() {
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

    $(document).on('click', '.approve', function() {
        let mitraId = $(this).data('id');
        let button = $(this); // Simpan referensi tombol yang diklik
        let row = button.closest('tr'); // Ambil baris tabel terkait

        $.ajax({
            url: `/kordinator/mitra/${mitraId}/approve`,
            type: "PUT",
            data: {
                _token: "{{ csrf_token() }}",
            },
            success: function(response) {
                // Mengubah tombol menjadi teks "Approved" tanpa reload halaman
                $('#datamitra').DataTable().ajax.reload();

            },
            error: function(xhr) {
                console.error(xhr.responseText);
            }
        });
    });


    function loadData() {
        let table = $('#datamitra').DataTable({
            processing: true,
            pagination: true,
            responsive: true,
            serverSide: true,
            searching: true,
            ordering: false,
            stripeClasses: [],

            ajax: {
                url: "{{ route('kordinator.data_mitra') }}",
                data: function(d) {
                    d.filter = $('#filter').val();
                    d.search = $('input[type="search"]').val();
                },
            },
            createdRow: function(row, data, dataIndex) {
                if (data.status_verifikasi === 'pending') {
                    $(row).addClass('highlight-pending');
                }
            },

            columns: [{
                    data: null,
                    name: 'no',
                    className: 'text-center',
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'file_pks',
                    name: 'file_pks',
                    className: 'text-center',
                    render: function(data, type, row) {
                        return row.file_pks ?
                            `<a href="/storage/${row.file_pks}" target="_blank" class="action-btn btn-sm btn-info">Lihat</a>` :
                            `<span class="text-muted">Tidak ada file</span>`;
                    }
                },
                {
                    data: 'tgl_mulai',
                    name: 'tgl_mulai',
                    className: 'text-center'
                },
                {
                    data: 'tgl_selesai',
                    name: 'tgl_selesai',
                    className: 'text-center'
                },
                {
                    data: 'mitra_user',
                    name: 'mitra_user'
                },
                {
                    data: 'alamat',
                    name: 'alamat'
                },
                {
                    data: 'kuota',
                    name: 'kuota',
                    className: 'text-center'
                },
                {
                    data: 'jurusan',
                    name: 'jurusan'
                },
                {
                    data: 'tanggal_mulai_magang',
                    name: 'tanggal_mulai_magang',
                    className: 'text-center'
                },
                {
                    data: 'tanggal_selesai_magang',
                    name: 'tanggal_selesai_magang',
                    className: 'text-center'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        let approveButton = row.status_verifikasi === 'pending' ?
                            `<button class="action-btn btn-success btn-sm approve" data-id="${row.id}"><i class="fas fa-check"></i> Approve</button>` :
                            `<span class="text-muted"></span>`;

                        return `
                        ${approveButton}
                        <button class="action-btn btn-primary btn-sm edit" data-id="${row.id}"><i class="bx bx-edit"></i></button>
                        <button class="action-btn btn-danger btn-sm delete" data-id="${row.id}" data-toggle="modal" data-target="#deleteMitraModal"><i class="bx bx-trash"></i></button>
                    `;
                    }
                }
            ]
        });
    }


    function editMitra(id) {
        $.get(`${routes.edit}${id}/edit`, function(data) { // Pastikan URL sesuai
            $('#editMitraId').val(data.id);
            $('#edit_tgl_mulai').val(data.tgl_mulai);
            $('#edit_tgl_selesai').val(data.tgl_selesai);
            $('#edit_nama_mitra_id').val(data.nama_mitra_id);
            $('#edit_jurusan_id').val(data.jurusan_id);
            $('#edit_alamat').val(data.alamat);
            $('#edit_kuota').val(data.kuota);
            $('#edit_tanggal_mulai_magang').val(data.tanggal_mulai_magang);
            $('#edit_tanggal_selesai_magang').val(data.tanggal_selesai_magang);
            $('#edit_file_pks').val('');
            // Set action URL
            $('#editMitraForm').attr('action', `/kordinator/mitra/${id}`);
            // Buka modal setelah data diisi
            $('#editMitraModal').modal('show');
        }).fail(function(xhr) {
            console.error('editMitra error:', xhr.responseText);
            alert('Terjadi kesalahan saat memuat data Mitra.');
        });
    }

    function deleteMitra(id) {
        $('#deleteMitraId').val(id);
        $('#deleteMitraForm').attr('action', `/kordinator/mitra/${id}`);
    }
</script>
@endsection