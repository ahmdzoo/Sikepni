<!DOCTYPE html>
   <html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!--=============== REMIXICONS ===============-->
      <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">

      <!--=============== CSS ===============-->
      <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

      <title>SIKEPNI - Sistem Informasi Kerjasama Politeknik Negeri Indramayu</title>
   </head> 
   <body>
      <!--=============== HEADER ===============-->
      @include('element.header')
      <!--=============== MAIN ===============-->
      <main class="main">
      <!--=============== HOME ===============-->
      <section class="home">
            <img src="{{ url('gambar/sky.png') }}" alt="" class="home__bg">

            <div class="home__container container">
               <div class="home__data">
                  <h1 class="home__title">Selamat Datang <br> Sistem Informasi Kerjasama Polindra</h1>

                  <p class="home__description">
                     Aplikasi Kerjasama Mitra Perusahaan Magang
                     Dengan Kampus Politeknik Negeri Indramayu.
                  </p>

                  <a href="#" class="home__button">Login</a>
                  <a href="#" class="home__button">Daftar</a>
               </div>

               <div class="home__images">
                  <img src="{{ url('gambar/gsc1.png') }}" alt="">
               </div>
            </div>
      </section>
      </main>
      <!-- ============== FOOTER ============ -->
       @include('element.footer')
      <!--=============== JS ===============-->
      <script src="{{ asset('js/script.js') }}"></script>
   </body>
</html>