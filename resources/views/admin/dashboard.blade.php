@extends('layouts.main')
@section('content')
<div class="content-wrapper" style="background: linear-gradient(to bottom,#80b8c7, #fff ); min-height: 100vh;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-4" style="font-size: 50px; color: white; font-weight: bold;">Dashboard Admin</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row m-4">
          <!-- Jumlah mitra -->
          <div class="col-lg-3  col-md-6">
            <!-- small box -->
            <div class="small-box">
              <div class="inner">
                <h3>{{ $jumlahMitra ?? 0 }}</h3>
              </sup></h3>
                <p>Jumlah Mitra</p>
              </div>
              <div class="icon">
                <i class="fas fa-handshake"></i>
              </div>
              <a href="{{ route('data_mitra') }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- Data user -->
          <div class="col-lg-3  col-md-6">
            <!-- small box -->
            <div class="small-box">
              <div class="inner">
                <h3>{{ $jumlahUser ?? 0 }}</sup></h3>
                <p>Jumlah User</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="{{ route('data_user') }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- Data jurusan -->
          <div class="col-lg-3  col-md-6">
            <!-- small box -->
            <div class="small-box">
              <div class="inner">
                <h3>{{ $jumlahJurusan ?? 0 }}</sup></h3>
                <p>Jumlah Jurusan</p>
              </div>
              <div class="icon">
                <i class="fas fas fa-cogs"></i>
              </div>
              <a href="{{ route('jurusan') }}" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </section>
   
</div>
@include('layouts/footer')
@endsection
