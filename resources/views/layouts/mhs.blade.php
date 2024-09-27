<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Mahasiswa</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('lte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
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

  <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- CKEditor -->
  <script src="https://cdn.ckeditor.com/4.21.0/standard/ckeditor.js"></script>

  <style>
    /* Make navbar blend with the background */
    .main-header {
      background-color: #007bff !important; /* Ensure the background matches the content */
      border-bottom: none !important;
      box-shadow: none !important;
    }
    
    /* Sidebar modification */
    .main-sidebar {
      background-color: white !important;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2) !important; /* Subtle shadow effect */
      color: #333;
    }

    /* Remove the border under the Dashboard Admin in the sidebar */
    .brand-link {
      border-bottom: none !important;
      color: #333 !important;
    }
    
    /* Adjust sidebar link colors */
    .nav-sidebar .nav-link {
      color: #333 !important;
    }

    .nav-sidebar .nav-link:hover {
      background-color: #f0f0f0 !important;
    }
    
    /* Change color of active menu items */
    .nav-sidebar .nav-item .nav-link.active {
      background-color: #007bff !important;
      color: white !important;
    }

    .nav-sidebar .nav-item .nav-link.active .nav-icon {
      color: white !important; /* Warna ikon putih */
    }

    .nav-icon {
      color: gray;
    }
  </style>

  @yield('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed" style="background-color: white;">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars" style="color: white"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false" style="color:white">
          <i class="fas fa-user"></i> mahasiswa@gmail.com
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">
            <i class="fas fa-key"></i> Reset Password
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">
            <i class="fas fa-sign-out-alt"></i> Logout
          </a>
        </div>
      </li>
    </ul>
    
  </nav>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-light-primary elevation-4">
    <a href="{{ route('mhs_dashboard') }}" class="brand-link">
      <img src="{{ URL('gambar/SIKEPNI-logo.png') }}" alt="Logo" style="width:100%; height: 40%;" />
    </a>
  
    <div class="sidebar mt-3 pb-3 mb-3 d-flex">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{ route('mhs_dashboard') }}" class="nav-link {{ request()->is('admin_dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-home"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('mhs_lowongan') }}" class="nav-link {{ request()->is('mhs_lowongan') ? 'active' : '' }}">
              <i class="nav-icon fas fa-handshake"></i>
              <p>Program Magang</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('mhs_aktifitas') }}" class="nav-link {{ request()->is('mhs_aktifitas') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>Aktifitas Magang</p>
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


@stack('js')
</body>
</html>