@extends('layouts.mhs')
@section('content')
<div class="content-wrapper" style="background: linear-gradient(to bottom, #80b8c7, #ffffff ); min-height: 100vh;">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-4" style="font-size: 50px; color: white; font-weight: bold;">Edit Laporan Magang</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <div class="container">
        <form action="{{ route('laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="file" class="form-label">File Laporan (kosongkan jika tidak ingin mengubah)</label>
                <input type="file" class="form-control" id="file" name="file">
                <small>File saat ini: {{ basename($laporan->file_path) }}</small>
            </div>
            <button type="submit" class="btn btn-primary">Update Laporan</button>
        </form>
    </div>
</div>
@include('layouts/footer')
@endsection
