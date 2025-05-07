<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
      <a href="#" class="app-brand-link">
          <span class="app-brand-logo demo">
              <img src="{{ asset('images/img/logo/polindra.png') }}" alt="polindra" style="height: 40px;">
          </span>
          <span class="app-brand-text demo menu-text fw-bolder ms-2">Sikepni</span>
      </a>
      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
          <i class="bx bx-chevron-left bx-sm align-middle"></i>
      </a>
  </div>
    <div class="menu-inner-shadow"></div>


     <!-- Dashboard -->
  <ul class="menu-inner py-1">
    <li class="menu-item {{ Route::is('kordinator.dashboard') ? 'active' : '' }}">
      <a href="{{ route('kordinator.dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-home-circle"></i>
        <div data-i18n="Basic">Dashboard</div>
      </a>
    </li>

    <li class="menu-item {{ Route::is('kordinator.data_user') ? 'active' : '' }}">
      <a href="{{ route('kordinator.data_user') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div data-i18n="Basic">Data User</div>
      </a>
    </li>

    <li class="menu-item {{ Route::is('kordinator.data_mitra') ? 'active' : '' }}">
      <a href="{{ route('kordinator.data_mitra') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-dock-top"></i>
        <div data-i18n="Basic">Data Mitra</div>
      </a>
    </li>

    <li class="menu-item {{ Route::is('kordinator.data_dosen') ? 'active' : '' }}">
      <a href="{{ route('kordinator.data_dosen') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user-voice"></i>
        <div data-i18n="Basic">Data Dosen</div>
      </a>
    </li>

    <li class="menu-item {{ Route::is('kordinator.jurusan') ? 'active' : '' }}">
      <a href="{{ route('kordinator.jurusan') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-book-content"></i>
        <div data-i18n="Basic">Data Jurusan/Prodi</div>
      </a>
    </li>

    <li class="menu-header small text-uppercase">
      <span class="menu-header-text">Laporan</span>
    </li>

    <li class="menu-item {{ Route::is('kordinator.admin_magang') ? 'active' : '' }}">
      <a href="{{ route('kordinator.admin_magang') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-detail"></i>
        <div data-i18n="Basic">Laporan Magang</div>
      </a>
    </li>
  </ul>
  </aside>