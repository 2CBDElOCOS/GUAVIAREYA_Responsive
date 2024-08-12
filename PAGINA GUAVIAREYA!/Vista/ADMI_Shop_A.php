<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (!isset($_SESSION['correo']) || $_SESSION['correo'] == "") {
  header("location: ../Controladores/controlador.php?seccion=login");
  exit();
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?php $seccion = 'home';
  echo $seccion; ?></title>
  <meta name="description" content="">
  <meta name="keywords" content="">
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
        <i class="bx bxs-home"></i>
        <span>GuaviareYa</span>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Administrar</a></li>
          <li><a href="#contactanos">Contactanos </a></li>
          <li><a href="controlador.php?seccion=ADMI_Perfil_A"><i class="bx bx-user-circle icono-grande"></i></a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>



  <main class="main">

    <section id="hero" class="hero section dark-background text-center">
      <img src="../media/hero.jpg" alt="" data-aos="fade-in">

      <div class="container d-flex justify-content-center align-items-center">
        <div class="col-md-8">
          <div class="col-md-12 text-hero">
            <h1>Hola <?php echo $_SESSION['apodo']; ?>, Bienvenido</h1>
          </div>
          <div class="col-md-12 ico-hero">
            <a href="controlador.php?seccion=ADMI_Productos_A"><i class='bx bx-restaurant'></i></a>
          </div>
        </div> <!-- Cierre de div col-md-8 -->
      </div> <!-- Cierre de div container -->
    </section>

    <!--Contactanos-->
    <section id="contactanos">
      <div class="contactanos">
        <div class="row">
          <div class="col-md-12 tu-domi">
            <h6>¿Tu Domicilio?</h6>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 tu-domi">
            <h2>¡En Camino!</h2>
          </div>
        </div>

        <div class="row">
          <div class="col-md-5 correo">
            <h4>Guaviareya@gmail.com</h4>
          </div>
          <div class="col-md-2 go-store">
            
          </div>
          <div class="col-md-5 tlf">
            <h4>+57 3143920233</h4>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <center>
              <hr style="color: rgb(255, 255, 255); width: 50%;">
            </center>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 ico-footer">
            <a href="https://www.youtube.com/" target="_blank"><i class="fa-brands fa-youtube"></i></a>
            <a href="https://www.instagram.com/" target="_blank"><i class="fa-brands fa-instagram"></i></a>
            <a href="https://web.facebook.com/" target="_blank"><i class="fa-brands fa-facebook"></i></a>
            <a href="https://web.whatsapp.com/" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
            <a href="https://twitter.com/" target="_blank"><i class="fa-brands fa-twitter"></i></a>
          </div>
        </div>
      </div>
    </section>

  </main>
  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
      class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>

  <!-- Main JS File -->
  <script src="../JS/main.js"></script>

</body>

</html>