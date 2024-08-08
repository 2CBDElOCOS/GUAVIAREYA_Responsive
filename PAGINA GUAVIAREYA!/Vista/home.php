<?php

include '../Vista/include_style_plantilla.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title><?php  $seccion = 'home';
  echo $seccion;?></title>
  <meta name="description" content="">
  <meta name="keywords" content="">
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid position-relative d-flex align-items-center justify-content-between">

    <a href="#home" id="logo" class="logo"><i class="bx bxs-home"></i>GuaviareYa</a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#hero" class="active">Inicio</a></li>
          <li><a href="#sobre">Sobre nosotros</a></li>
          <li><a href="controlador.php?seccion=login">Nuestra tienda</a></li>
          <li><a href="#contactanos">Contactanos </a></li>
          <li><a href="../Manual_uso/Manual De Usuario Final.pdf"download="manual.pdf">Manual </a></li>
          <li><a href="https://youtu.be/ZFf1asGqP_g?si=TSlNtdGUMVBZSdx8" target="_blank">Video</a></li>
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
          <h1 data-aos="fade-up" data-aos-delay="100">GUAVIAREYA!</h1>
          <a href="../Controladores/controlador.php?seccion=login"><button style="border-radius: 30px;">Tienda</button></a>
        </div>
      </div>
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
            <h3>Somos <span class="color-acento">GuaviareYA!</span></h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla aliquam minus possimus impedit totam
              voluptatem magnam, at debitis voluptates deleniti, perspiciatis molestiae corporis quod? Labore assumenda
              sequi beatae voluptate laudantium!</p>
          </div>
        </div>
      </div>
    </section>

    <!--Contactanos-->
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
          <a href="../Controladores/controlador.php?seccion=login"><button style="border-radius: 30px;">Tienda</button></a>
          </div>
          <div class="col-md-5 tlf">
            <h4>+57 3143920233</h4>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <center><hr style="color: rgb(255, 255, 255); width: 50%;"></center>
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
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/aos/aos.js"></script>

  <!-- Main JS File -->
  <script src="../JS/main.js"></script>
</body>

</html>