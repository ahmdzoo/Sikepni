<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- DATA TABLE -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">

    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">

    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="{{ asset('css/moa.css') }}">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('gambar/polindraa.png') }}" type="image/x-icon">

    <title>SIKEPNI - Mitra Kerjasama</title>
    
</head>
<body>
    <!--=============== HEADER ===============-->
    @include('element.header')

    <!--=============== MAIN ===============-->
    <main class="main">
        <section class="card">
            <section class="card-body">
                <p>Data Mitra Kerjasama Politeknik Negeri Indramayu</p>
                <div class="table__header">
                    <div class="filter-section">
                        <i class="ri-filter-3-line" style="font-size: 1.5rem; margin-right: 10px;"></i>
                        <select id="filter-jurusan" class="form-control">
                            <option value="">Semua Jurusan</option>
                            @foreach($jurusans as $jurusan)
                                <option value="{{ $jurusan->id }}">{{ $jurusan->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="table__body">
                    <table id="mitra-table-body" class="display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tgl Mulai</th>
                                <th>Tgl Selesai</th>
                                <th>Nama Mitra</th>
                                <th>Jurusan</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </section>
        </section>
    </main>

    <!--=============== FOOTER ===============-->
    <footer>
        @include('element.footer')
    </footer>

    <!--=============== JS ===============-->
    <script src="{{ asset('js/menu.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>

    <script>
    $(document).ready(function() {
    var table = $('#mitra-table-body').DataTable({
        processing: true,
        pagination: true,
        responsive: true,
        serverSide: true,
        searching: true,
        ordering: false,
        ajax: {
            url: '{{ route("mitra.data") }}',
            data: function(d) {
                d.jurusan_id = $('#filter-jurusan').val();
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'tgl_mulai', name: 'tgl_mulai' },
            { data: 'tgl_selesai', name: 'tgl_selesai' },
            { data: 'nama_mitra', name: 'nama_mitra' },
            { data: 'jurusan', name: 'jurusan' },
        ],
        lengthChange: false,
        drawCallback: function(settings) {
            // Set background color and border for all table body rows
            $('#mitra-table-body tbody tr').each(function() {
                $(this).find('td').css({
                    'background-color': '#fff',  // Warna latar belakang
                    'color': '#6c757d',  // Warna teks abu-abu
                    'border-bottom': '1px solid #d3d3d3'  // Garis tipis abu-abu
                });
            });

            // Set background color for header rows
            $('#mitra-table-body thead th').css({
                'background-color': '#fff',  // Warna latar belakang header
                'color': '#6c757d',  // Warna teks abu-abu
                'border-bottom': '1px solid #d3d3d3'  // Garis tipis abu-abu di bawah header
            });
        }
    });

    $('.dataTables_filter input').attr('placeholder', 'Search...');

    $('.dataTables_filter label').contents().filter(function() {
        return this.nodeType === 3;
    }).remove();

    $('#filter-jurusan').on('change', function() {
        table.draw();
    });
});

    </script>
</body>
</html>
