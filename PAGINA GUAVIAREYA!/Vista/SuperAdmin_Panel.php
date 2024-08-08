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
}?>


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

    <a href="#home" id="logo" class="logo"><i class="bx bxs-home"></i>GuaviareYa</a>

      <nav id="navmenu" class="navmenu">
        <ul>
        <li> <a href="controlador.php?seccion=SUPER_add" class="active">Agregar Restaurante </a</li>
        <li><a href="controlador.php?seccion=Perfil_SuperAdmi"><i class='bx bx-user-circle icono-grande' ></i></i></a></li>
        <li><a class="" href="../Controladores/controlador_cerrar_session.php"><i class='bx bxs-door-open icono-grande' ></i></a></li>
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
          <a href="controlador.php?seccion=SUPER_add" target="_blank"><i class='bx bx-restaurant'></i></a>
        </div>
        </div> <!-- Cierre de div col-md-8 -->
      </div> <!-- Cierre de div container -->
    </section>
    <section id="sobre">
    <div class="subcontainer">
      <div class="row">
        <div class="col-md-6 img-sobre">
          <center>
            <img src="../media/sobre-nosotros.png" alt="img sonbre guaviareYA!" width="500px" />
          </center>
        </div>
        <div class="col-md-6 sobre">
          <h3>Super <span class="color-acento">Admi!</span></h3>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla aliquam minus possimus
            impedit totam voluptatem magnam, at debitis voluptates deleniti, perspiciatis molestiae
            corporis quod? Labore assumenda sequi beatae voluptate laudantium!
          </p>
        </div>
      </div>
    </div>
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
  <script src="../css/vendor/aos/aos.js"></script>

  <!-- Main JS File -->
  <script src="../JS/main.js"></script>

</body>

</html>