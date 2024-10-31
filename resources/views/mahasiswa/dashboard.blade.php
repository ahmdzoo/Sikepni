@extends('layouts.mhs')

@section('content')
<div class="content-wrapper" style="background: linear-gradient(to bottom, #80b8c7, #fff); min-height: 100vh;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-4" style="font-size: 50px; color: white; font-weight: bold;">Dashboard Mahasiswa</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row m-4">
                <!-- Nama Mitra -->
                <div class="col-lg-4 col-md-6 mb-4 mx-auto">
                    <div class="small-box">
                        <div class="inner">
                            <h2>
                                @if ($mitras->isNotEmpty())
                                {{ $mitras->first()->mitraUser->name }}
                                <!-- Menampilkan nama mitra pertama -->
                                @else
                                Tidak ada mitra
                                @endif
                            </h2>
                            <p>Nama Mitra</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-handshake"></i>
                        </div>
                        <a href="" class="small-box-footer"><i class="fa fa-minus"></i></a>
                    </div>
                </div>

                <!-- Nama Dosen Pembimbing -->
                <div class="col-lg-4 col-md-6 mb-4 mx-auto">
                    <div class="small-box">
                        <div class="inner">
                            <h2>
                                @if ($mitras->isNotEmpty())
                                {{ $mitras->first()->dosenPembimbing->name }}
                                <!-- Menampilkan nama dosen pembimbing pertama -->
                                @else
                                Tidak ada dosen
                                @endif
                            </h2>
                            <p>Dosen Pembimbing</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <a href="" class="small-box-footer"><i class="fa fa-minus"></i></a>
                    </div>
                </div>

                <!-- Log Magang -->
                <div class="col-lg-4 col-md-6 mb-4 mx-auto">
                    <div class="small-box">
                        <div class="inner">
                            <h2>Log Magang</h2>
                            <p>Tampilkan log magang di sini</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <a href="#" class="small-box-footer">Lihat <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@include('layouts.footer')
@endsection