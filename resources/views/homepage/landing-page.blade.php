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

                  <a href="{{ route('login') }}" class="home__button">Login</a>
                  <a href="{{ route('register') }}" class="home__button">Daftar</a>
               </div>

               <div class="home__images">
                  <img src="{{ url('gambar/gsc1.png') }}" alt="">
               </div>
            </div>
            {{-- CURVES --}}
            {{-- <div class="custom-shape-divider-bottom-1728268330">
               <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                  <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
               </svg>
            </div> --}}
      </section>
      </main>
      <!-- ============== FOOTER ============ -->
       @include('element.footer')
      <!--=============== JS ===============-->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" integrity="sha512-7eHRwcbYkK4d9g/6tD/mhkf++eoTHwpNM9woBxtPUBWm67zeAfFC+HrdoE2GanKeocly/VxeLvIqwvCdk7qScg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="{{ asset('js/script.js') }}"></script>
   </body>
</html>