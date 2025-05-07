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

<ul class="menu-inner py-1">
    <li class="menu-item {{ Route::is('mhs.dashboard') ? 'active' : '' }}">
        <a href="{{ route('mhs.dashboard') }}" class="menu-link">
          <i class="menu-icon tf-icons bx bx-home-circle"></i>
          <div data-i18n="Basic">Dashboard</div>
        </a>
      </li>
      <li class="menu-item {{ Route::is('mhs_lowongan') ? 'active' : '' }}">
        <a href="{{ route('mhs_lowongan') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-file"></i>
        <div data-i18n="Basic">Lowongan Magang</div>
      </a>
    </li>
    <li class="menu-item {{ Route::is('mahasiswa.magang') ? 'active' : '' }}">
      <a href="{{ route('mahasiswa.magang') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-dock-top"></i>
        <div data-i18n="Basic">Aktivitas Magang</div>
      </a>
    </li>

    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Lainnya</span>
    </li>

    <li class="menu-item {{ Route::is('mahasiswa.status_lamaran') ? 'active' : '' }}">
        <a href="{{ route('mahasiswa.status_lamaran') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-detail"></i>
        <div data-i18n="Basic">Status Pengajuan</div>
      </a>
    </li>
  </ul>
  </aside>