<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('gambar/polindraa.png') }}" type="image/x-icon">
    <title>Sikepni - Login</title>
    <link rel="stylesheet" href="{{ asset('css/loginReg.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  </head>
  <body>
    <main class="sign-in-mode">
      <div class="box">
        {{-- Logo --}}
    <div class="logo">
      <img src="{{ asset('gambar/polindraa.png') }}" alt="">
    </div>
        <div class="inner-box">
          <div class="forms-wrap">
            {{-- Forms Login --}}
            <form method="POST" action="{{ route('loginReg') }}" autocomplete="off" class="sign-in-form">
              @csrf
              <div class="heading">
                <h2>Login</h2>
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
                      name="email"
                      minlength="4"
                      class="input-field"
                      autocomplete="off"
                      required
                      oninput="removeSpecialChars(this)"
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
                    oninput="removeSpecialChars(this)"

                  />
                  <label>Password</label>
                </div>
                <div class="heading">
                  <h6>Belum memiliki akun?</h6>
                  <a href="{{ route('regLogin') }}" class="toggle">Registrasi</a>
                </div>

                <input type="submit" value="Sign In" class="sign-btn" />
                <div>
                  <div class="heading">
                    <a href="/" class="toggle">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                  </div>                  
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