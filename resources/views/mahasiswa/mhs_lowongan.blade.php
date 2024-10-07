@extends('layouts.mhs')

@section('content')
<div class="content-wrapper" style="background: linear-gradient(to bottom, #80b8c7, #ffffff ); min-height: 100vh;">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-4" style="font-size: 50px; color: white; font-weight: bold;">Daftar Mitra Magang</h1>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Nama Perusahaan</th>
                  <th>Deskripsi</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($mitraMagang as $mitra)
          <tr>
            <td>{{ $mitra->nama_perusahaan }}</td>
            <td>{{ $mitra->deskripsi }}</td>
            <td>
            <form action="{{ route('kirim_cv') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <input type="file" name="cv" required />
              <input type="hidden" name="mitra_id" value="{{ $mitra->id }}" />
              <button type="submit" class="btn btn-primary">Kirim CV</button>
            </form>
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
</div>
@endsection