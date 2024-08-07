<?php

include '../Vista/include_style_plantilla.php';

?>

<head>
  <title><?php  $seccion = 'home';
  echo $seccion;?></title>
</head>

<nav class="custom-nav"> <!-- Clase específica para el nav -->
    <a href="#home" id="logo" class="logo"><i class="bx bxs-home"></i>GuaviareYa</a>
    <input type="checkbox" id="hamburger" />
    <label for="hamburger">
      <i class="fa-solid fa-bars"></i>
    </label>
    <ul>

      <li><a href="#hero" class="active">Inicio</a></li>
      <li><a href="#sobre">Sobre nosotros</a></li>
      <li><a href="controlador.php?seccion=login">Nuestra tienda</a></li>
      <li><a href="#contactanos">Contactanos </a></li>
      <li><a href="../Manual_uso/Manual De Usuario Final.pdf"download="manual.pdf">Manual </a></li>
      <li><a href="https://youtu.be/ZFf1asGqP_g?si=TSlNtdGUMVBZSdx8" target="_blank">video</a></li>
    </ul>
  </nav>

<section id="hero">
  <div class="subcontainer">
    <div class="row hero">
      <div class="col-md">
        <h1>GuaviareYa</h1>
        <div id="countdown" style="font-size: 20px; color: #FFFFFF;"></div> <!-- Contenedor para el contador -->
        <a href="controlador.php?seccion=login"><button style="border-radius: 30px;">Tienda</button></a>
      </div>
    </div>
  </div>
</section>

<div class="container">
  <!--About us-->
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
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla aliquam minus possimus
            impedit totam voluptatem magnam, at debitis voluptates deleniti, perspiciatis molestiae
            corporis quod? Labore assumenda sequi beatae voluptate laudantium!
          </p>
        </div>
      </div>
    </div>
  </section>
</div>

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
        <a href="controlador.php?seccion=login"><button style="border-radius: 30px;">Tienda</button></a>
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
        <a href="https://twitter.com/" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
      </div>
    </div>
  </div>
</section>

<script src="../JS/contador_evento.js"></script>
