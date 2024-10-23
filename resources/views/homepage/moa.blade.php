<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="heigh=device-width, initial-scale=1.0">

    <!-- DATA TABLE -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('gambar/polindraa.png') }}" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">


    <title>SIKEPNI - Mitra Kerjasama</title>

  
</head>
<body>
    <!--=============== HEADER ===============-->
    @include('element.header')
    <!--=============== MAIN ===============-->
    <main class="main">
        <!--=============== HOME ===============-->
        <section class="home">
            <section class="table">
                <h1>Data Mitra Kerjasama Politeknik Negeri Indramayu</h1>
                {{-- Table header --}}
                <div class="table__header">
                    
                    <div class="filter-section" style="display: flex; align-items: center; margin-top: 10px;">
                        <!-- Icon Filter -->
                        <i class="ri-filter-3-line" style="font-size: 1.5rem; margin-right: 10px;"></i>
                
                        <!-- Dropdown Filter -->
                        <select id="filter-jurusan" class="form-control" style="width: 200px;">
                            <option value="">Semua Jurusan</option>
                            @foreach($jurusans as $jurusan)
                                <option value="{{ $jurusan->id }}">{{ $jurusan->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                
                {{-- Table Body --}}
                <div class="table__body">
                    <table id="mitra-table-body">
                        <thead>
                            <tr>
                                <th>No <span class="icon-arrow">&UpArrow;</span></th>
                                <th>No PKS <span class="icon-arrow">&UpArrow;</span></th>
                                <th>Tgl Mulai <span class="icon-arrow">&UpArrow;</span></th>
                                <th>Tgl Selesai <span class="icon-arrow">&UpArrow;</span></th>
                                <th>Nama Mitra <span class="icon-arrow">&UpArrow;</span></th>
                                <th>Jurusan <span class="icon-arrow">&UpArrow;</span></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </section>
        </section>
    </main>
    <!-- ============== FOOTER ============ -->
    @include('element.footer')
    <!--=============== JS ===============-->
    <script src="{{ asset('js/script.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <script>
$(document).ready(function() {
    var table = $('#mitra-table-body').DataTable({
        processing: false,
        pagination: true,
        responsive: true,
        serverSide: true,
        searching: true,
        ordering: true,
        ajax: {
            url: '{{ route("mitra.data") }}',
            data: function(d) {
                d.jurusan_id = $('#filter-jurusan').val(); // Tambahkan filter jurusan ke parameter AJAX
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'no_pks', name: 'no_pks' },
            { data: 'tgl_mulai', name: 'tgl_mulai' },
            { data: 'tgl_selesai', name: 'tgl_selesai' },
            { data: 'nama_mitra', name: 'nama_mitra' },
            { data: 'jurusan', name: 'jurusan' },
        ],
        lengthChange: false // Menonaktifkan "Show entries"
    });

    // Menambahkan placeholder ke input pencarian
    $('.dataTables_filter input').attr('placeholder', 'Search...');

    // Menghapus teks "Search" dari label tanpa menyembunyikan label
    $('.dataTables_filter label').contents().filter(function() {
        return this.nodeType === 3; // Teks node
    }).remove(); // Hapus hanya teks

    // // Tambahkan ikon kaca pembesar di samping input pencarian
    // $('.dataTables_filter').append('<span class="search-icon"><i class="ri-search-line"></i></span>');


    // Event listener untuk filter jurusan
    $('#filter-jurusan').on('change', function() {
        table.draw(); // Perbarui tabel berdasarkan jurusan yang dipilih
    });
});



    </script>
</body>


</html>
