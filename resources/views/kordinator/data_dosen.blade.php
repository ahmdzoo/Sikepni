@extends('layouts.kordinator')
@section('title', 'Data Dosen | SIKEPNI')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.7/css/dataTables.bootstrap5.min.css" />
@endsection

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-4 text-white font-weight-bold">Daftar Dosen</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Table Dosen -->
        <div class="card">
            <div class="card-body">
                <button class="btn btn-success" data-toggle="modal" data-target="#relasiModal">
                    Tambah
                </button>
                <table class="table table-bordered" id="dosenTable">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Dosen</th>
                            <th>Mahasiswa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dosen as $index => $d)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $d->name }}</td>
                            <td>
                                @if($d->mahasiswa->isEmpty())
                                <span class="badge bg-warning">Belum ada mahasiswa</span>
                                @else
                                <ul>
                                    @foreach($d->mahasiswa as $m)
                                    <li>{{ $m->name }}</li>
                                    @endforeach
                                </ul>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Modal Tambah Relasi -->
        <div class="modal fade" id="relasiModal" tabindex="-1" aria-labelledby="relasiModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="relasiModalLabel">Tambah Relasi Dosen - Mahasiswa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('kordinator.assign_dosen') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="dosen_id" class="form-label">Pilih Dosen</label>
                                <br>
                                <select class="form-select" name="dosen_id" required>
                                    <option value="">-- Pilih Dosen --</option>
                                    @foreach($dosen as $d)
                                    <option value="{{ $d->id }}">{{ $d->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="mahasiswa_id" class="form-label">Pilih Mahasiswa</label>
                                <br>
                                <select class="form-select" name="mahasiswa_id" required>
                                    <option value="">-- Pilih Mahasiswa --</option>
                                    @foreach($mahasiswa as $m)
                                    <option value="{{ $m->id }}">{{ $m->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.datatables.net/2.1.7/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.1.7/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#dosenTable').DataTable();
    });
</script>
@endsection