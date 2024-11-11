@extends('layouts.dosen') <!-- Pastikan menggunakan layout yang sesuai dengan project Anda -->
@section('title', 'Lamaran Magang | SIKEPNI')

@section('content')
<div class="content-wrapper" style="background: linear-gradient(to bottom, #80b8c7, #ffffff); min-height: 100vh;">
    <div class="container-fluid">
        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card p-4" style="width: 100%;">
            <div class="card-header">
                <h5 class="m-0" style="font-size: 24px; font-weight: bold;">Daftar Lamaran Magang</h5>
            </div>

            <div class="mb-3">
                <input type="text" id="search" class="form-control" placeholder="Cari Lamaran..."
                    style="width: 300px;" onkeyup="searchLamaran()"> <!-- Pencarian Lamaran -->
            </div>

            @if($lamarans->isEmpty())
                <div class="alert alert-warning">
                    Tidak ada lamaran untuk mitra ini.
                </div>
            @else
                <table class="table table-bordered" id="lamaranTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Mahasiswa</th>
                            <th>Email</th>
                            <th>CV</th>
                            <th>Tanggal Lamaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lamarans as $index => $lamaran)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $lamaran->user->name }}</td> <!-- Mengakses nama mahasiswa dari relasi -->
                                <td>{{ $lamaran->user->email }}</td> <!-- Mengakses email mahasiswa -->
                                <td>
                                    <a href="{{ Storage::url($lamaran->cv_path) }}" target="_blank" class="btn btn-sm btn-primary">
                                        Lihat CV
                                    </a>
                                </td>
                                <td>{{ $lamaran->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

<!-- JavaScript untuk pencarian -->
<script>
  function searchLamaran() {
    const input = document.getElementById('search');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('lamaranTable');
    const tr = table.getElementsByTagName('tr');

    for (let i = 1; i < tr.length; i++) {
      const td = tr[i].getElementsByTagName('td');
      let txtValue = '';
      for (let j = 0; j < td.length - 1; j++) { // exclude the last column (aksi)
        if (td[j]) {
          txtValue += td[j].textContent || td[j].innerText;
        }
      }
      if (txtValue.toLowerCase().indexOf(filter) > -1) {
        tr[i].style.display = '';
      } else {
        tr[i].style.display = 'none';
      }
    }
  }
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
@include('layouts/footer')
@endsection
