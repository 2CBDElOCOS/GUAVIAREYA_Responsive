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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admi Shop</title>

</head>

<body class="body">

  <nav class="custom-nav"> <!-- Clase específica para el nav -->
    <a href="#home" id="logo" class="logo"><i class="bx bxs-home"></i>GuaviareYa</a>
    <input type="checkbox" id="hamburger" />
    <label for="hamburger">
      <i class="fa-solid fa-bars"></i>
    </label>
    <ul>
      <li><a href="#hero" class="active">Administrar</a></li>
      <li><a href="#contactanos">Contactanos </a></li>
      <li><a href="controlador.php?seccion=ADMI_Perfil_A"><i class="bx bx-user-circle icono-grande"></i></a></li>
    </ul>
  </nav>

  <section id="hero">
    <div class="subcontainer">
      <div class="row hero">
        <div class="col-md-12 text-hero">
          <h1>Hola <?php echo $_SESSION['apodo']; ?>, Bienvenido</h1>
        </div>
        <div class="col-md-12 ico-hero">
          <a href="controlador.php?seccion=ADMI_Productos_A"><i class='bx bx-restaurant'></i></a>
        </div>
      </div>
    </div>
  </section>

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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
