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
      <header class="header">
         <nav class="nav container">
            <div class="nav__data">
               <a href="#" class="nav__logo">
                  <img src="{{ url('gambar/polindraa') }}" alt="">
                  <span>Politeknik Negeri Indramayu</span>
               </a>
               
               <div class="nav__toggle" id="nav-toggle">
                  <i class="ri-menu-line nav__burger"></i>
                  <i class="ri-close-line nav__close"></i>
               </div>
            </div>

            <!--=============== NAV MENU ===============-->
            <div class="nav__menu" id="nav-menu">
               <ul class="nav__list">
                  <li><a href="#" class="nav__link">Home</a></li>
                  <li><a href="#" class="nav__link">MOA</a></li>
                  <li><a href="#" class="nav__link">MOU</a></li>
                  <li><a href="#" class="nav__link">IA</a></li>
               </ul>
            </div>
         </nav>
      </header>
      
      <!--=============== MAIN ===============-->
      <main class="main">
      <!--=============== HOME ===============-->
      <section class="home">
            <img src="assets/img/sky.png" alt="" class="home__bg">

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
                  <img src="{{ url('gambar/gsc1') }}" alt="">
               </div>
            </div>
      </section>
      </main>
      <!-- ============== FOOTER ============ -->
      <footer class="footer">
         <div class="footer__container container">
           <div>
             <a href="#" class="footer__logo">
               <i><img src="{{ url('gambar/polindraa') }}"></i>
               <span>Politeknik Negeri Indramayu</span>
             </a>
             <p class="footer__description">
               Jl. Lohbener Lama No.08, <br>
               Lohbener, Legok, <br>
               Indramayu, Kabupaten <br>
               Indramayu, Jawa Barat <br>
               Kode Pos : 45252 <br>
               Telepon : (0234) 5746464 <br>
               Fax : (0234) 5746464
             </p>
             <address class="footer__email">Email : info@polindra.ac.id</address>
           </div>
       
           <div class="footer__content">
             <div>
               <h3 class="footer__title">Pusat</h3>
               <ul class="footer__links">
                 <li><a href="#" class="footer__links">P3M</a></li>
                 <li><a href="#" class="footer__links">P2MPP</a></li>
                 <li><a href="#" class="footer__links">RISTERMAS</a></li>
                 <li><a href="#" class="footer__links">SPI</a></li>
                 <li><a href="#" class="footer__links">JURNAL</a></li>
                 <li><a href="#" class="footer__links">SEMITERA</a></li>
                 <li><a href="#" class="footer__links">PROSIDING</a></li>
               </ul>
             </div>
             <div>
               <h3 class="footer__title">Layanan</h3>
               <ul class="footer__links">
                 <li><a href="#" class="footer__links">PMB</a></li>
                 <li><a href="#" class="footer__links">PPID</a></li>
                 <li><a href="#" class="footer__links">ZI-WBK</a></li>
                 <li><a href="#" class="footer__links">SENAT</a></li>
                 <li><a href="#" class="footer__links">SIAKAD</a></li>
                 <li><a href="#" class="footer__links">LSP</a></li>
                 <li><a href="#" class="footer__links">SISTER</a></li>
                 <li><a href="#" class="footer__links">TRACER</a></li>
                 <li><a href="#" class="footer__links">ELEARNING</a></li>
                 <li><a href="#" class="footer__links">DASHBOARD</a></li>
                 <li><a href="#" class="footer__links">LAPOR</a></li>
               </ul>
             </div>
           </div>
         </div>
       
         <span class="footer__copy">
           &#169; All Rights Reserved Politeknik Negeri Indramayu
         </span>
       </footer>
       
      <!--=============== JS ===============-->
      <script src="{{ asset('js/script.js') }}"></script>
   </body>
</html>