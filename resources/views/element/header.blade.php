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

<script src="{{ asset('js/script.js') }}"></script>
