<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sikepni - Login</title>
    <link rel="stylesheet" href="{{ asset('css/login_reg.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  </head>
  <body>
    <main class="sign-up-mode">
      <div class="box">
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
        <div class="inner-box">
          <div class="forms-wrap">
            <form method="POST" action="{{ route('regLogin') }}" autocomplete="off" class="sign-up-form">
              @csrf
              <div class="heading">

                <h2>Registrasi</h2>
                <h6>Sudah Mempunyai akun?</h6>
                <a href="#" class="toggle">Login</a>
              </div>

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

                <div class="input-wrap">
                  <select name="role" id="role" class="input-field" required>
                    <option value="" disabled selected hidden></option>
                    <option value="mahasiswa">Mahasiswa</option>
                    <option value="dosen_pembimbing">Dosen Pembimbing</option>
                    <option value="mitra_magang">Mitra Magang</option>
                    <option value="admin">Admin</option>
                  </select>
                  <label>Pilih Role</label>
                </div>

                <input type="submit" value="Sign Up" class="sign-btn" />
              </div>
            </form>

            <form method="POST" action="{{ route('loginReg') }}" autocomplete="off" class="sign-in-form">
              @csrf
              <div class="heading">



                <h2>Login</h2>
                <h6>Belum memiliki akun?</h6>
                <a href="#" class="toggle">Registrasi Sekarang</a>
              </div>

              <div class="actual-form">
                <div class="input-wrap">
                  <input
                    type="text"
                    name="email"
                    minlength="4"
                    class="input-field"
                    autocomplete="off"
                    required
                  />
                  <label>Email</label>
                </div>

                <div class="input-wrap">
                  <input
                    type="password"
                    name="password"
                    minlength="4"
                    class="input-field"
                    autocomplete="off"
                    required
                  />
                  <label>Password</label>
                </div>

                <input type="submit" value="Sign In" class="sign-btn" />
                <div>

                </div>
                <p class="text">
                  Lupa Password?
                  <a href="#">Get help</a> signing in
                </p>
              </div>
            </form>
          </div>

          <div class="carousel">
            <div class="images-wrapper">
              <img src="./img/image1.png" class="image img-1 show" alt="" />
            </div>

            <div class="text-slider">
              <div class="text-wrap">
                <div class="text-group">
                  <h2>Selamat Datang</h2>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <!-- Javascript file -->
    <script src="{{ asset('js/login_reg.js') }}"></script>
  </body>
</html>