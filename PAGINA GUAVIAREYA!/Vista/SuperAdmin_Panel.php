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

<head>
  <title><?php $seccion = 'SuperAdmin_Panel';
  echo $seccion; ?></title>
</head>

<div class="container">
  <!--header-->
  <nav class="custom-nav"> <!-- Clase específica para el nav -->
    <a href="#home" id="logo" class="logo"><i class="bx bxs-home"></i>GuaviareYa</a>
    <input type="checkbox" id="hamburger" />
    <label for="hamburger">
      <i class="fa-solid fa-bars"></i>
    </label>
    <ul>

      <li> <a href="controlador.php?seccion=SUPER_add" target="_blank">Agregar Restaurante </a</li>
      <li><a href="controlador.php?seccion=Perfil_SuperAdmi"><i class='bx bx-user-circle icono-grande' ></i></i></a></li>
      <li><a class="" href="../Controladores/controlador_cerrar_session.php"><i class='bx bxs-door-open icono-grande' ></i></a></li>
    </ul>
  </nav>
</div>


<section id="hero">
    <div class="subcontainer">
      <div class="row hero">
        <div class="col-md-12 text-hero">
          <h1>Hola <?php echo $_SESSION['apodo']; ?>, Bienvenido</h1>
        </div>
        <div class="col-md-12 ico-hero">
          <a href="controlador.php?seccion=SUPER_add" target="_blank"><i class='bx bx-restaurant'></i></a>
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
        <a href="controlador.php?seccion=SUPER_add" target="_blank"><button style="border-radius: 30px;">Agregar
            Restaurante</button></a>
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
        <a href="https://twitter.com/" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
      </div>
    </div>
  </div>
</section>