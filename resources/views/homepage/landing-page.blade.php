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
      <title>SIKEPNI - Sistem Informasi Kerjasama Politeknik Negeri Indramayu</title>
   </head> 
   <body>
      <!--=============== HEADER ===============-->
      @include('element.header')
      <!--=============== MAIN ===============-->
      <main class="main">
      <!--=============== HOME ===============-->
      <section class="home">

            <div class="home__container container">
               <div class="home__data">
                  <h1 class="home__title"> 
                     <span class="text-reveal">Selamat Datang</span><br>
                     <span class="text-reveal">Sistem Informasi Kerjasama Politeknik Negeri Indramayu</span>
                  </h1>
                  <p class="home__description">
                     <span class="text-reveal">Aplikasi Kerjasama Mitra Perusahaan Magang</span><br>
                     <span class="text-reveal">Dengan Kampus Politeknik Negeri Indramayu.</span>
                  </p>
                  <p class="home__regist">
                     <span class="text-reveal">Masuk atau daftar dibawah ini</span>
                  </p>

                  <a href="{{ route('loginReg') }}" class="home__button">Login</a>
                  <a href="{{ route('regLogin') }}" class="home__button">Daftar</a>
               </div>

               {{-- <div class="home__images">
                  <img src="{{ url('gambar/gsc1.png') }}" alt="">
               </div> --}}
            </div>
            {{-- CURVES --}}
      </section>
      </main>
      <!-- ============== FOOTER ============ -->
       @include('element.footer')
      <!--=============== JS ===============-->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="{{ asset('js/script.js') }}"></script>
   </body>
</html>