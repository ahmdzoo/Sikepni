<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  

    <!--=============== REMIXICONS ===============-->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">
    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('gambar/polindraa.png') }}" type="image/x-icon">
    <title>SIKEPNI</title>
</head>
<body>
   <!-- Header -->
   @include('element.header')

    <main class="main">
        <section class="home">
            <div class="home__container container grid">
                <div class="home__data">
                    <h1 class="home__title text-reveal">Sistem Informasi Kerjasama Politeknik Negeri Indramayu</h1>
                    <p class="home__description text-reveal">Aplikasi Kerjasama Mitra Perusahaan Magang dengan Kampus Politeknik Negeri Indramayu.</p>
                    <div class="button-container">
                        <a href="{{ route('loginReg') }}" class="home__button">Login</a>
                        <a href="{{ route('regLogin') }}" class="home__button">Daftar</a>
                    </div>
                </div>
                <div class="home__image">
                    <img src="{{ asset('gambar/gsc1.png') }}" alt="Gambar Illustrasi">
                </div>
            </div>
        </section>
    </main>

   <!-- Footer -->
   @include('element.footer')
   
      <!-- JS -->
      <script src="{{ asset('js/home.js') }}"></script>
  
</body>
</html>