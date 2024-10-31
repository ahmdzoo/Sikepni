<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('gambar/polindraa.png') }}" type="image/x-icon">
    <title>@yield('title', 'Dashboard Mitra | SIKEPNI')</title>


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('lte/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('lte/plugins/summernote/summernote-bs4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('css/mitra.css') }}">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>



    @yield('css')
</head>

<body class="hold-transition sidebar-mini layout-fixed" style="background-color: white;">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"
                            style="color: white"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-expanded="false" style="color:white">
                        {{ Auth::user()->email }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ubahPasswordModal">
                            <i class="fas fa-key"></i> Reset Password
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>

        </nav>
        <!-- Modal Ubah Password -->
        <div class="modal fade" id="ubahPasswordModal" tabindex="-1" role="dialog" aria-labelledby="ubahPasswordLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ubahPasswordLabel">Ubah Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="clearErrors()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
                        <div id="successMessage" class="alert alert-success" style="display: none;"></div>

                        <form id="resetPasswordForm" method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <div class="form-group">
                                <label for="currentPassword">Password Saat Ini</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="currentPassword"
                                        name="current_password" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="togglePasswordVisibility('currentPassword')">
                                            <i class="fas fa-eye" id="currentPasswordToggle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="newPassword">Password Baru</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="newPassword" name="new_password"
                                        required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="togglePasswordVisibility('newPassword')">
                                            <i class="fas fa-eye" id="newPasswordToggle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">Konfirmasi Password Baru</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirmPassword"
                                        name="new_password_confirmation" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button"
                                            onclick="togglePasswordVisibility('confirmPassword')">
                                            <i class="fas fa-eye" id="confirmPasswordToggle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Reset Password</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <a href="{{ route('mitra.dashboard') }}" class="brand-link">
                <img src="{{ URL('gambar/SIKEPNI-logo.png') }}" alt="Logo" style="width:100%; height: 40%;" />
            </a>

            <div class="sidebar mt-3 pb-3 mb-3 d-flex">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('mitra.dashboard') }}"
                                class="nav-link {{ request()->is('mitra/dashboard') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('mitra_lamaran') }}"
                                class="nav-link {{ request()->is('mitra/lamarans') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-handshake"></i>
                                <p>Lamaran Magang</p>
                            </a>
                        </li>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('mitra.laporan') }}"
                                class="nav-link {{ request()->is('mitra/mitra_laporan') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-folder-open"></i>
                                <p>Laporan Magang</p>
                            </a>
                        </li>
                    </ul>

                </nav>
            </div>
        </aside>


        <!-- Content Wrapper. Contains page content -->
        @yield('content')
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('lte/dist/js/adminlte.js') }}"></script>
    <script>
    // Fungsi untuk menampilkan/menyembunyikan password
    function togglePasswordVisibility(inputId) {
        var input = document.getElementById(inputId);
        var toggleIcon = document.getElementById(inputId + 'Toggle');

        if (input.type === "password") {
            input.type = "text";
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            input.type = "password";
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }

    // Fungsi untuk membersihkan pesan error
    function clearErrors() {
        document.getElementById('errorMessage').style.display = 'none';
        document.getElementById('successMessage').style.display = 'none';
    }

    // Fungsi untuk menampilkan pesan
    function showMessage(message, isSuccess) {
        var successMessageDiv = document.getElementById('successMessage');
        var errorMessageDiv = document.getElementById('errorMessage');

        if (isSuccess) {
            successMessageDiv.innerText = message;
            successMessageDiv.style.display = 'block';
            errorMessageDiv.style.display = 'none';
        } else {
            errorMessageDiv.innerText = message;
            errorMessageDiv.style.display = 'block';
            successMessageDiv.style.display = 'none';
        }
    }

    // Mengelola pengiriman form dan menampilkan pesan
    document.getElementById('resetPasswordForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah pengiriman form default
        clearErrors(); // Menghapus pesan sebelumnya

        // Mengambil data form
        var formData = new FormData(this);

        fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage(data.message, true);
                } else {
                    showMessage(data.message, false);
                }
            })
            .catch(error => {
                showMessage('Terjadi kesalahan. Silakan coba lagi.', false);
            });
    });
    </script>

    @stack('js')
</body>

</html>