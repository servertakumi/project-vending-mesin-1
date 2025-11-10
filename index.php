<?php include('./config/db.php'); ?>
<?php
if (isset($_SESSION['admin'])) {
  header('Location: app');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Index - Selecao Bootstrap Template</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Selecao
  * Template URL: https://bootstrapmade.com/selecao-bootstrap-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">RIFASTECH</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Home</a></li>

          <li><a href="#contact">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">
      <div id="hero"
        class="hero section dark-background text-white d-flex align-items-center justify-content-center vh-100"
        style="
          background-image: url('assets/images/curved-images/curved14.jpg');
          background-size: cover;
          background-position: center;
          background-repeat: no-repeat;
          background-attachment: fixed;
          width: 100% ;
          margin-top : -80px;
          position: relative;
        ">
        <div id="hero-carousel" data-bs-interval="5000" class="container carousel carousel-fade" data-bs-ride="carousel">

          <!-- Slide 1 -->
          <div class="carousel-item active">
            <div class="carousel-container">
              <h2 class="animate__animated animate__fadeInDown">Welcome to <span>admin</span></h2>
              <p class="animate__animated animate__fadeInUp">"Hidup ini seperti mesin vending — kamu harus tahu apa yang kamu mau, berani memasukkan 'usaha' sebagai koinnya, dan bersabar menunggu hasilnya keluar. Kadang produk yang kamu pilih tersangkut di tengah, tapi itu bukan berarti gagal, hanya butuh sedikit dorongan lagi."</p>
              <a href="login?page" class="btn-get-started animate__animated animate__fadeInUp scrollto">admin</a>
            </div>
          </div>

          <!-- Slide 2 -->
          <div class="carousel-item">
            <div class="carousel-container">
              <h2 class="animate__animated animate__fadeInDown">Welcome to <span>vending</span></h2>
              <p class="animate__animated animate__fadeInUp">"Setiap pilihanmu di sini punya rasa, setiap sentuhan punya cerita.
                Yuk, pilih camilan favoritmu dan biarkan mesin ini bikin harimu sedikit lebih manis!"</p>
              <a href="mesin?page" class="btn-get-started animate__animated animate__fadeInUp scrollto">pembeli</a>
            </div>
          </div>
        </div>

        <!-- Slide 3 -->

        <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
          <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
        </a>

        <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
          <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
        </a>

      </div>


      <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28 " preserveAspectRatio="none" style="position: relative; margin-top: -50px;">
        <defs>
          <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>
        </defs>
        <g class="wave1">
          <use xlink:href="#wave-path" x="50" y="3"></use>
        </g>
        <g class="wave2">
          <use xlink:href="#wave-path" x="50" y="0"></use>
        </g>
        <g class="wave3">
          <use xlink:href="#wave-path" x="50" y="9"></use>
        </g>
      </svg>


    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>About</h2>
        <p>TVM(Takumi Vending Machine)</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
            <p>
              Takumi Vending Machine adalah mesin penjual otomatis modern yang menghadirkan kemudahan dan kecepatan dalam berbelanja. Dilengkapi dengan sistem pembayaran digital dan desain elegan, Takumi memberikan pengalaman praktis bagi pengguna untuk membeli minuman atau camilan kapan saja dan di mana saja.
            </p>
            <ul>
              <li><i class="bi bi-check2-circle"></i> <span>Praktis & Cepat: Belanja hanya dengan beberapa sentuhan, tanpa antre dan tanpa kasir.</span></li>
              <li><i class="bi bi-check2-circle"></i> <span>Pembayaran Modern: Mendukung transaksi digital seperti e-wallet</span></li>
              <li><i class="bi bi-check2-circle"></i> <span>Desain Elegan: Tampilan modern dengan sistem pendingin hemat energi dan pencahayaan menarik.</span></li>
            </ul>
          </div>

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <p>Mulailah Belanja Barang Lewat Masa Depan.............</p>
            <a href="#" class="read-more" style="color:white ; background-color: blue;"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
          </div>

        </div>

      </div>

    </section><!-- /About Section -->

    <!-- Features Section -->
    <section id="features" class="features section">

      <div class="container">





      </div>

    </section><!-- /Features Section -->

    <!-- Call To Action Section -->


  </main>

  <footer id="footer" class="footer dark-background">
    <div class="container">
      <h3 class="sitename">RIFASTECH</h3>
      <p>“Automate the Future with RifasTech.”</p>
      <div class="social-links d-flex justify-content-center">
        <a href=""><i class="bi bi-twitter-x"></i></a>
        <a href=""><i class="bi bi-facebook"></i></a>
        <a href=""><i class="bi bi-instagram"></i></a>
        <a href=""><i class="bi bi-skype"></i></a>
        <a href=""><i class="bi bi-linkedin"></i></a>
      </div>
      <div class="container">
        <div class="copyright">
          <span>Copyright</span> <strong class="px-1 sitename">Selecao</strong> <span>All Rights Reserved</span>
        </div>
        <div class="credits">
          <!-- All the links in the footer should remain intact. -->
          <!-- You can delete the links only if you've purchased the pro version. -->
          <!-- Licensing information: https://bootstrapmade.com/license/ -->
          <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
          Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> Distributed By <a href="https://themewagon.com">ThemeWagon</a>
        </div>
      </div>
    </div>
  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>