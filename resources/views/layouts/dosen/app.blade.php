<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">
<head>
    @include('partials.dosen.header')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
</head>
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

          <!-- Sidebar -->
          @include('partials.dosen.sidebar')
    
          <div class="layout-page">
            <!-- Navbar -->
            @include('partials.dosen.navbar')
    
            <!-- Konten dinamis -->
            <div class="content-wrapper">
              <div class="container-xxl flex-grow-1 container-p-y">
                <h4 class="fw-bold py-3 mb-4">
                  <span class="text-muted fw-light">@yield('breadcumb', 'Dashboard')</span>
                  @yield('page-title', 'Dosen Pembimbing')
                </h4>

                @yield('content')
              </div>
              
              @include('partials.dosen.footer')
              
              <div class="content-backdrop fade"></div>
            </div>
            
            <div class="layout-overlay layout-menu-toggle"></div>
          </div>
          
        </div>
      </div>

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('js/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('js/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('js/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('js/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/vendor/js/menu.js') }}"></script>
    <!-- Vendors JS -->
    <script src="{{ asset('js/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <!-- Main JS -->
    <script src="{{ asset('js/main.js') }}"></script>
    <!-- Page JS -->
    <script src="{{ asset('js/dashboards-analytics.js') }}"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    @stack('scripts')
    @yield('scripts')
</body>
</html>
