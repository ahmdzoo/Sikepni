<!DOCTYPE html>
   <html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!--=============== REMIXICONS ===============-->
      <link href="https://cdn.jsdelivr.net/npm/remixicon@3.2.0/fonts/remixicon.css" rel="stylesheet">

      <!--=============== CSS ===============-->
      <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

      <title>SIKEPNI - MOU</title>
   </head> 
   <body>
      <!--=============== HEADER ===============-->
      <header class="header">
         <nav class="nav container">
            <div class="nav__data">
               <a href="#" class="nav__logo">
                  <img src="{{ url('gambar/polindraa.png') }}" alt="">
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
                  <li><a href="/" class="nav__link">Home</a></li>
                  <li><a href="/moa" class="nav__link">MOA</a></li>
                  <li><a href="/mou" class="nav__link">MOU</a></li>
                  <li><a href="/ia" class="nav__link">IA</a></li>
               </ul>
            </div>
         </nav>
      </header>
      
      <!--=============== MAIN ===============-->
      <main class="main">
      <!--=============== HOME ===============-->
      <section class="home">
            <img src="{{ url('gambar/sky.png') }}" alt="" class="home__bg">

            <div class="home__container container">
               <div class="home__data">
                  <h1 class="home__title">INI PAGE MOU</h1>

                  <p class="home__description">
                     Page Informasi MOU
                  </p>
               </div>
            </div>
      </section>
      </main>
      <!-- ============== FOOTER ============ -->
      <footer class="footer">
         <div class="footer__container container">
           <div>
             <a href="#" class="footer__logo">
               <i><img src="{{ url('gambar/polindraa.png') }}"></i>
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
                 <li><a href="https://p3m.polindra.ac.id/" class="footer__links" target="_blank">P3M</a></li>
                 <li><a href="https://p2mpp.polindra.ac.id/" class="footer__links" target="_blank">P2MPP</a></li>
                 <li><a href="https://ristermas.polindra.ac.id/" class="footer__links" target="_blank">RISTERMAS</a></li>
                 <li><a href="https://spi.polindra.ac.id/" class="footer__links" target="_blank">SPI</a></li>
                 <li><a href="https://jurnal.polindra.ac.id/index.php/jtt" class="footer__links" target="_blank">JURNAL</a></li>
                 <li><a href="https://semitera.polindra.ac.id/" class="footer__links" target="_blank">SEMITERA</a></li>
                 <li><a href="https://prosiding.polindra.ac.id/index.php/semitera" class="footer__links" target="_blank">PROSIDING</a></li>
               </ul>
             </div>
             <div>
               <h3 class="footer__title">Layanan</h3>
               <ul class="footer__links">
                 <li><a href="https://pmb.polindra.ac.id/" class="footer__links" target="_blank">PMB</a></li>
                 <li><a href="https://ppid.polindra.ac.id/" class="footer__links" target="_blank">PPID</a></li>
                 <li><a href="https://zi-wbk.polindra.ac.id/" class="footer__links" target="_blank">ZI-WBK</a></li>
                 <li><a href="http://senat.polindra.ac.id/" class="footer__links" target="_blank">SENAT</a></li>
                 <li><a href="https://siakad.polindra.ac.id/" class="footer__links" target="_blank">SIAKAD</a></li>
                 <li><a href="https://lsp.polindra.ac.id/" class="footer__links" target="_blank">LSP</a></li>
                 <li><a href="http://sister.polindra.ac.id/auth/login" class="footer__links" target="_blank">SISTER</a></li>
                 <li><a href="https://tracer.polindra.ac.id/" class="footer__links" target="_blank">TRACER</a></li>
                 <li><a href="https://elearning.polindra.ac.id/" class="footer__links" target="_blank">ELEARNING</a></li>
                 <li><a href="http://dashboard.polindra.ac.id/" class="footer__links" target="_blank">DASHBOARD</a></li>
                 <li><a href="https://www.lapor.go.id/" class="footer__links" target="_blank">LAPOR</a></li>
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