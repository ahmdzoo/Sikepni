@extends('layouts.main')
@section('content')
<div class="content-wrapper" style="min-height: 100vh;">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-4" style="font-size: 30px; color: white; font-weight: bold;">Dashboard Admin</h1>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>

  @if($expiredMitra->count() > 0)
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Perhatian!</strong> <br>
        <small>Ada {{ $expiredMitra->count() }} Mitra yang Masa Kerjasamanya telah berakhir.</small>
        <ul>
            @foreach($expiredMitra as $mitra)
            <li>{{ $mitra->mitraUser->name }} - Kerjasama Berakhir pada: {{ \Carbon\Carbon::parse($mitra->tgl_selesai)->format('d M Y') }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->
      <div class="row m-4">
        <!-- Jumlah mitra -->
        <div class="col-lg-3  col-md-6">
          <!-- small box -->
          <div class="small-box">
            <a href="{{ route('data_mitra') }}">
              <div class="inner">
                <h3>{{ $jumlahMitra ?? 0 }}</h3>
                </sup></h3>
                <p>Mitra</p>
              </div>
              <div class="icon">
                <i class="fas fa-handshake"></i>
              </div>
            </a>
          </div>
        </div>
        
      </div>
    </div>
  </section>

</div>
@include('layouts/footer')
@endsection