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
    <title>SIKEPNI - MOA</title>

  
</head>
<body>
    <!--=============== HEADER ===============-->
    @include('element.header')
    <!--=============== MAIN ===============-->
    <main class="main">
        <!--=============== HOME ===============-->
        <section class="home">
            <section class="table">
                {{-- Table header --}}
                <div class="table__header">
                    <h1>Tabel data MOA</h1>
                    {{-- <div class="input__group">
                        <input type="search" placeholder="Search Data...">
                    </div> --}}
                </div>
                {{-- Table Body --}}
                <div class="table__body">
                    <table id="mitra-table-body">
                        <thead>
                            <tr>
                                <th> No <span class="icon-arrow">&UpArrow;</span></th>
                                <th> No PKS <span class="icon-arrow">&UpArrow;</span></th>
                                <th> Tgl Mulai <span class="icon-arrow">&UpArrow;</span></th>
                                <th> Tgl Selesai <span class="icon-arrow">&UpArrow;</span></th>
                                <th> nama mitra <span class="icon-arrow">&UpArrow;</span></th>
                                <th> jurusan <span class="icon-arrow">&UpArrow;</span></th>
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
    $('#mitra-table-body').DataTable({
        processing: false,
        pagination: true,
        responsive: true,
        serverSide: true,
        searching: true,
        ordering: false,
        ajax: '{{ route("mitra.data") }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'no_pks', name: 'no_pks' },
            { data: 'tgl_mulai', name: 'tgl_mulai' },
            { data: 'tgl_selesai', name: 'tgl_selesai' },
            { data: 'nama_mitra', name: 'nama_mitra' },
            { data: 'jurusan', name: 'jurusan' },
        ],
        //lengthChange: false // Menonaktifkan "Show entries"
    });
});

    </script>

</body>
</html>
