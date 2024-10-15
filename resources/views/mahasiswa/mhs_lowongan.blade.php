@extends('layouts.mhs')

@section('content')
<div class="content-wrapper" style="background: linear-gradient(to bottom, #80b8c7, #ffffff); min-height: 100vh;">
  <div class="container-fluid">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

    <div class="card p-4" style="width: 100%;">
      <div class="card-header">
        <h5 class="m-0" style="font-size: 24px; font-weight: bold;">Informasi Mitra</h5>
      </div>

      <div class="mb-3">
        <input type="text" id="search" class="form-control" placeholder="Cari Mitra..." onkeyup="searchMitra()"
          style="width: 300px;"> <!-- Menyesuaikan lebar input -->
      </div>

      <table class="table" id="mitraTable">
        <thead>
          <tr>
            <th>Nama Mitra</th>
            <th>No PKS</th>
            <th>Nama Dosen Pembimbing</th>
            <th>Jurusan</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @if(isset($mitras) && $mitras->isEmpty())
        <tr>
        <td colspan="7" class="text-center">Tidak ada mitra yang tersedia.</td>
        </tr>
      @else
      @foreach($mitras as $mitra)
      <tr>
      <td>{{ $mitra->mitraUser->name }}</td>
      <td>{{ $mitra->no_pks }}</td>
      <td>{{ $mitra->dosenPembimbing->name ?? 'Belum ditentukan' }}</td>
      <td>{{ $mitra->jurusan->name ?? 'Belum ditentukan' }}</td>
      <td>{{ $mitra->tgl_mulai->format('Y-m-d') }}</td>
      <td>{{ $mitra->tgl_selesai->format('Y-m-d') }}</td>
      <td>
      <!-- Button untuk membuka modal -->
      <button type="button" class="btn btn-primary" data-bs-toggle="modal"
      data-bs-target="#lamaranModal-{{ $mitra->id }}">
      Ajukan Lamaran
      </button>

      <!-- Modal -->
      <div class="modal fade" id="lamaranModal-{{ $mitra->id }}" tabindex="-1" aria-labelledby="modalLabel"
      aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Ajukan Lamaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('lamaran.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
        <input type="hidden" name="mitra_id" value="{{ $mitra->id }}">
        <div class="form-group">
          <label for="cv">Unggah CV (PDF saja)</label>
          <input type="file" class="form-control" id="cv" name="cv" accept=".pdf" required>
        </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Kirim Lamaran</button>
        </div>
        </form>
        </div>
      </div>
      </div>
      </td>
      </tr>
    @endforeach
    @endif
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- JavaScript untuk pencarian -->
<script>
  function searchMitra() {
    const input = document.getElementById('search');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('mitraTable');
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

@endsection