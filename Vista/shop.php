<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['correo'])) {
  header("location: ../Controladores/controlador.php?seccion=login");
  exit(); // Asegúrate de salir después de redirigir
}

if ($_SESSION['correo'] == "") {
  header("location: ../Controladores/controlador.php?seccion=login");
  exit(); // Asegúrate de salir después de redirigir
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>GuaviareYa!</title>
</head>

<body>

  <div class="container">
    <!--header-->
    <header class="fixed-top bg-dark">
      <div class="row align-items-center">
        <div class="col-md-3">
          <a href="controlador.php?seccion=home" class="logo"><i class="bx bxs-home"></i>GuaviareYa</a>
        </div>
        <div class="col-md-9 d-md-flex justify-content-md-end align-items-center">
          <nav class="navlist">
            <a href="controlador.php?seccion=home">Inicio</a>
            <a href="controlador.php?seccion=home">Sobre nosotros</a>
            <a href="#" target="_blank" class="active">Nuestra tienda</a>
            <a href="#contactanos">Contactanos</a>
          </nav>
          <div class="nav-icons1">
            <a href="#"><i class="bx bx-search"></i></a>
            <a href="#"><i class="bx bx-cart"></i></a>
            <a href="controlador.php?seccion=perfil"><i class="bx bx-user-circle"></i></a>
          </div>
        </div>
      </div>
    </header>
  </div>

  <section id="hero">
    <div class="subcontainer">
      <div class="row hero">
        <div class="col-md-12 text-hero">
          <h1 id="mensaje_dinamico">Hola <?php echo htmlspecialchars($_SESSION['Apodo'], ENT_QUOTES, 'UTF-8'); ?>, Bienvenido 😀</h1>

        </div>
        <div class="col-md-12 ico-hero">
          <a href="controlador.php?seccion=comida" target="_blank"><i class='bx bx-restaurant'></i></a>
        </div>
      </div>
    </div>
  </section>

  <!--Contactanos-->
  <section id="contactanos">
    <div class="contactanos1">
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
        <div class="col-md-2 go-store"></div>
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

</body>

</html>