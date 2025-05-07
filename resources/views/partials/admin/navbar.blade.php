<nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center" id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>
            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

        <!-- Notifikasi -->
        <ul class="navbar-nav flex-row align-items-center ms-auto gap-2 gap-md-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" 
              data-bs-toggle="dropdown" data-bs-auto-close="outside">
              <button type="button" class="btn rounded-pill btn-icon btn-outline-secondary">
                <span class="bx bx-bell me"></span>
                @if($lamarans->count() + $laporanMagang->count() + $laporanAkhir->count() > 0)
                <span class="badge badge-warning navbar-badge">
                  {{ $lamarans->count() + $laporanMagang->count() + $laporanAkhir->count() }}
                </span>
                @endif
              </button>
            </a>
            <ul class="dropdown-menu dropdown-menu-end p-3" style="width: 320px; max-height: 400px; overflow-y: auto;">
                <h6 class="dropdown-header text-center">Notifikasi</h6>
                <div class="accordion" id="notifAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#notif1">
                                📄 {{$lamarans->count()}} Pengajuan Magang
                            </button>
                        </h2>
                        <div id="notif1" class="accordion-collapse collapse">
                          @forelse ($lamarans as $lamaran)
                          <a class="dropdown-item" href="{{ route('mitra_lamaran', $lamaran->id) }}">
                            <small><b>{{ $lamaran->user->name }}</b> Mengirim Pengajuan Magang</small>
                            <small class="text-muted d-block">{{ $lamaran->created_at->format('d M Y') }}</small>
                          </a>
                          <a class="dropdown-item text-wrap" href="{{ route('mitra_lamaran', $lamaran->id) }}" style="white-space: normal; word-break: break-word;">
                            <small class="d-block text-wrap" style="white-space: normal; word-break: break-word;">
                              <b>{{ $lamaran->user->name }}</b>
                            </small>
                            <small class="text-muted d-block">{{ $lamaran->created_at->format('d M Y') }}</small>
                          </a>
                          @empty
                          <span class="dropdown-item text-muted">Tidak ada Notifikasi</span>
                          @endforelse
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#notif2">
                                📄 {{$laporanMagang->count()}} Laporan Magang
                            </button>
                        </h2>
                        <div id="notif2" class="accordion-collapse collapse">
                          @forelse ($laporanMagang as $laporan)
                          <a class="dropdown-item text-wrap" href="{{ route('mitra.laporan', ['mahasiswa_id' => Crypt::encrypt($laporan->mahasiswa->id)]) }}" style="white-space: normal; word-break: break-word;">
                            <small class="d-block text-wrap" style="white-space: normal; word-break: break-word;">
                              <b>{{ $laporan->mahasiswa->name }}</b> Mengunggah Laporan Magang {{ $laporan->jenis_laporan }} : {{ basename($laporan->file_path) }}
                            </small>
                            <small class="text-muted d-block">{{ $laporan->created_at->format('d M Y') }}</small>
                          </a>
                          @empty
                          <span class="dropdown-item text-muted">Tidak ada Notifikasi</span>
                          @endforelse
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#notif3">
                                📄 {{$laporanAkhir->count()}} Laporan Akhir Magang
                            </button>
                        </h2>
                        <div id="notif3" class="accordion-collapse collapse">
                            <div class="accordion-body">
                              @forelse ($laporanAkhir as $laporan)
                              <a class="dropdown-item text-wrap" href="{{ route('mitra.LaporanAkhir', ['mahasiswa_id' => Crypt::encrypt($laporan->mahasiswa->id)]) }}" style="white-space: normal; word-break: break-word;">
                                <small class="d-block text-wrap" style="white-space: normal; word-break: break-word;">
                                  <b>{{ $laporan->mahasiswa->name }}</b> Mengunggah Laporan Akhir {{ $laporan->jenis_laporan }} : {{ basename($laporan->file_path) }}
                                </small>
                                <small class="text-muted d-block">{{ $laporan->created_at->format('d M Y') }}</small>
                              </a>
                              @empty
                              <span class="dropdown-item text-muted">Tidak ada Notifikasi</span>
                              @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </ul>
        </li>
        <!-- End Notifikasi -->


                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <button type="button" class="btn rounded-pill btn-icon btn-outline-secondary">
                      <span class="bx bx-user me"></span>
                    </button>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">{{ Auth::user()->email }}</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#ubahPasswordModal">
                        <i class="bx bx-cog me-2"></i>
                        <span class="align-middle">Reset Password</span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                      </form>
                    </li>
                  </ul>
                </li>
                <!-- End User -->
            </ul>
          </div>
        </nav>
        <!-- End Navbar -->
        <!-- Modal Ubah Password -->
    <div class="modal fade" id="ubahPasswordModal" tabindex="-1" role="dialog" aria-labelledby="ubahPasswordLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="ubahPasswordLabel">Ubah Password</h5>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" onclick="clearErrors()">
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
                  <input type="password" class="form-control" id="currentPassword" name="current_password" required>
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('currentPassword')">
                      <i class="bx bx-show" id="currentPasswordToggle"></i>
                    </button>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="newPassword">Password Baru</label>
                <div class="input-group">
                  <input type="password" class="form-control" id="newPassword" name="new_password" required>
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('newPassword')">
                      <i class="bx bx-show" id="newPasswordToggle"></i>
                    </button>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="confirmPassword">Konfirmasi Password Baru</label>
                <div class="input-group">
                  <input type="password" class="form-control" id="confirmPassword" name="new_password_confirmation" required>
                  <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('confirmPassword')">
                      <i class="bx bx-show" id="confirmPasswordToggle"></i>
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
  
      $(document).ready(function() {
        // Mengaktifkan dropdown
        $('.dropdown-toggle').dropdown();
      });
  
      $(document).ready(function() {
  
  
      });
  
      $(document).ready(function() {
        // Mencegah dropdown ditutup saat mengklik elemen di dalamnya
        $('#notifikasi').on('click', function(event) {
          event.stopPropagation();
        });
  
        // Toggle konten dropdown child saat diklik
        $('.dropdown-item .dropdown-toggle').on('click', function(e) {
          const content = $(this).next('.dropdown-content');
          content.toggle();
          e.preventDefault();
        });
      });
  
      $(document).ready(function() {
        // Fungsi untuk menampilkan dropdown
        $('#pengajuanDropdown').click(function() {
          $('#pengajuanContent').toggle();
        });
  
        $('#laporanMagangDropdown').click(function() {
          $('#laporanMagangContent').toggle();
        });
  
        $('#laporanAkhirDropdown').click(function() {
          $('#laporanAkhirContent').toggle();
        });
  
  
      });
    </script>
  