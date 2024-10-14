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
      <title>SIKEPNI - IA</title>
   </head> 
   <body>
      <!--=============== HEADER ===============-->
      @include('element.header')
      <!--=============== MAIN ===============-->
      <main class="main">
      <!--=============== HOME ===============-->
      <section class="home">
         <section class="table">
            {{-- Table header --}}
            <div class="table__header">
              <h1>Tabel data IA</h1>
              <div class="input__group">
                <input type="search" placeholder="Search Data...">
              </div>
            </div>
            {{-- Table Body --}}
            <div class="table__body">
              <table>
                <thead>
                  <tr>
                    <th> No <span class="icon-arrow">&UpArrow;</span></th>
                    <th> No PKS <span class="icon-arrow">&UpArrow;</span></th>
                    <th> Tgl Mulai <span class="icon-arrow">&UpArrow;</span></th>
                    <th> Tgl Selesai <span class="icon-arrow">&UpArrow;</span></th>
                    <th> nama mitra <span class="icon-arrow">&UpArrow;</span></th>
                    <th> jurusan <span class="icon-arrow">&UpArrow;</span></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td> 1 </td>
                    <td> Seoul </td>
                    <td> 17 Dec, 2022 </td>
                    <td> 13 Dec, 2024 </td>
                    <td> <strong> $128.90 </strong></td>
                    <td> RPL </td>
                </tr>
                <tr>
                    <td> 2 </td>
                    <td> Kathmandu </td>
                    <td> 27 Aug, 2023 </td>
                    <td> 23 Aug, 2025 </td>
                    <td> <strong>$5350.50</strong> </td>
                    <td> RPL </td>
                </tr>
                <tr>
                    <td> 3</td>
                    <td> Tokyo </td>
                    <td> 14 Mar, 2023 </td>
                    <td> 16 Mar, 2024 </td>
                    <td> <strong>$210.40</strong> </td>
                    <td> RPL </td>
                </tr>
                <tr>
                    <td> 4</td>
                    <td> New Delhi </td>
                    <td> 25 May, 2023 </td>
                    <td> 20 May, 2025 </td>
                    <td> <strong>$149.70</strong> </td>
                    <td> TI </td>
                </tr>
                <tr>
                    <td> 5</td>
                    <td> Paris </td>
                    <td> 23 Apr, 2023 </td>
                    <td> 20 Apr, 2025 </td>
                    <td> <strong>$399.99</strong> </td>
                    <td> TI </td>
                </tr>
                <tr>
                    <td> 6</td>
                    <td> London </td>
                    <td> 23 Apr, 2023 </td>
                    <td> 22 Apr, 2024 </td>
                    <td> <strong>$399.99</strong> </td>
                    <td> TI </td>
                </tr>
                <tr>
                    <td> 7</td>
                    <td> New York </td>
                    <td> 20 May, 2023 </td>
                    <td> 22 May, 2025 </td>
                    <td> <strong>$399.99</strong> </td>
                    <td> TI </td>
                </tr>
                <tr>
                    <td> 8</td>
                    <td> Islamabad </td>
                    <td> 30 Feb, 2023 </td>
                    <td> 20 Feb, 2025 </td>
                    <td> <strong>$149.70</strong> </td>
                    <td> TI </td>
                </tr>
                <tr>
                    <td> 9</td>
                    <td> Dhaka </td>
                    <td> 22 Dec, 2023 </td>
                    <td> 20 Dec, 2025 </td>
                    <td> <strong>$249.99</strong> </td>
                    <td> RPL </td>
                </tr>
                <tr>
                    <td> 9</td>
                    <td> Dhaka </td>
                    <td> 22 Dec, 2023 </td>
                    <td> 20 Dec, 2025 </td>
                    <td> <strong>$249.99</strong> </td>
                    <td> RPL </td>
                </tr>
                <tr>
                    <td> 9</td>
                    <td> Dhaka </td>
                    <td> 22 Dec, 2023 </td>
                    <td> 20 Dec, 2025 </td>
                    <td> <strong>$249.99</strong> </td>
                    <td> RPL </td>
                </tr>
                <tr>
                    <td> 9</td>
                    <td> Dhaka </td>
                    <td> 22 Dec, 2023 </td>
                    <td> 20 Dec, 2024 </td>
                    <td> <strong>$249.99</strong> </td>
                    <td> TI </td>
                </tr>
                <tr>
                    <td> 9</td>
                    <td> Dhaka </td>
                    <td> 22 Dec, 2023 </td>
                    <td> 20 Dec, 2025 </td>
                    <td> <strong>$249.99</strong> </td>
                    <td> TI </td>
                </tr>
                </tbody>
              </table>
            </div>
          </section>
      </section>
      </main>
      <!-- ============== FOOTER ============ -->
       @include('element.footer')
      <!--=============== JS ===============-->
      <script src="{{ asset('js/script.js') }}"></script>
   </body>
</html>