<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('gambar/polindraa.png') }}" type="image/x-icon">
    <title>Sikepni - Register</title>
    <link rel="stylesheet" href="{{ asset('css/regLogin.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  </head>
  <body>
    <main class="sign-up-mode">
      <div class="box">
        <div class="inner-box">
          <div class="forms-wrap">
            <form method="POST" action="{{ route('regLogin') }}" autocomplete="off" class="sign-up-form">
              @csrf
              <div class="heading">
                <h2>Registrasi</h2>
              </div>

              <!-- Pesan Sukses -->
        @if (session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif

      <!-- Pesan Kesalahan -->
      @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

              <div class="actual-form">
                <div class="input-wrap">
                  <input
                    type="text"
                    name="name"
                    minlength="4"
                    class="input-field"
                    autocomplete="off"
                    required
                  />
                  <label>Nama Lengkap</label>
                </div>

                <div class="input-wrap">
                  <input
                    type="email"
                    name="email"
                    class="input-field"
                    autocomplete="off"
                    required
                  />
                  <label>Email</label>
                </div>

                <small class="text-muted">Kata sandi harus terdiri dari minimal 6 karakter.</small>
                <div class="input-wrap">
                  <input
                    type="password"
                    name="password"
                    id="password"
                    minlength="4"
                    class="input-field"
                    autocomplete="off"
                    required
                  />
                  <label>Kata Sandi</label>
                  <i class="fas fa-eye toggle-icon" id="togglePassword" onclick="togglePasswordVisibility()"></i>
                </div>

                <div class="input-wrap">
                  <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    minlength="4"
                    class="input-field"
                    autocomplete="off"
                    required
                  />
                  <label>Konfirmasi Kata Sandi</label>
                  <i class="fas fa-eye toggle-icon" id="togglePassword_confirmation" onclick="togglePasswordConfirmationVisibility()"></i>
                </div>

                <div class="heading">
                  <h6>Sudah Mempunyai akun?</h6>
                <a href="{{ route('loginReg') }}" class="toggle">Login</a>
                </div>
                <input type="submit" value="Sign Up" class="sign-btn" />
              </div>
              <div>
                <div class="heading">
                  <a href="{{ route('homepage.landing-page') }}" class="toggle">
                  <i class="fa-solid fa-arrow-left"></i> Kembali
                  </a>
              </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </main>
    <!-- Javascript file -->
    <script src="{{ asset('js/login_reg.js') }}"></script>
  </body>
</html>