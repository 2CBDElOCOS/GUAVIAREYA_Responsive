<?php
// Verificación de sesión
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['correo']) || $_SESSION['correo'] == "") {
  header("location: ../Controladores/controlador.php?seccion=login");
  exit(); // Asegúrate de salir después de redirigir
}

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
        <li><a href="#"class="active">Inicio</a></li>
        <li><a href="#"class="">Nuestra tienda</a></li>
        <li><a href="#contactanos">Contáctanos</a></li>
        <li><a href="#" id="search-icon"><i class="bx bx-search icono-grande"></i></a></li>
        <li><a href="controlador.php?seccion=carrito"><i class="bx bx-cart icono-grande"></i></a></a></li>
      <li><a href="controlador.php?seccion=perfil"><i class="bx bx-user-circle icono-grande"></i></a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <div id="search-box" style="display: none;">
          <form action="controlador_busqueda.php" method="post">
              <input type="text" name="search" placeholder="Buscar...">
              <button type="submit" id="search-close"style="width:20px;font-size:10px;text-align:center;">❌</button>
          </form>
      </div>

    </div>
  </header>

  

  <main class="main">

    <section id="hero" class="hero section dark-background text-center">
      <img src="../media/hero.jpg" alt="" data-aos="fade-in">

      <div class="container d-flex justify-content-center align-items-center">
        <div class="col-md-8">
          <div class="col-md-12 text-hero">
            <h1>Hola <?php echo $_SESSION['Apodo']; ?>, Bienvenido</h1>
          </div>
          <br>
          <div class="col-md-12 ico-hero">
          <a href="controlador.php?seccion=comida"><i class='bx bx-restaurant'></i></a>
        </div>
        </div>
      </div>
      
    </section>


    <?php


// Asegúrate de incluir la conexión a la base de datos y el modelo si es necesario
include('../Modelos/mostrar_productos.php');

$mostrarProductos = new mostrar_productos();

// Obtener el término de búsqueda de la URL
if (isset($_GET['search'])) {
  $searchTerm = trim($_GET['search']);
  $productos = $mostrarProductos->buscarProductos($searchTerm);

  if (count($productos) > 0) {
    echo "<h1 style='text-align: center; color: black;'>Resultados de la Búsqueda para '<strong>" . htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8') . "</strong>'</h1>";
    echo '<div class="row row-cols-1 row-cols-md-3 g-4 py-5">';
    foreach ($productos as $producto) {
      // Definir variables asegurando que existen en el producto
      $id_restaurante = isset($producto['ID_Restaurante']) ? $producto['ID_Restaurante'] : '';
      $nombre_restaurante = isset($producto['Nombre_Restaurante']) ? $producto['Nombre_Restaurante'] : '';

      echo '
            <div class="col">
              <div class="card">
                <img style="width: 200px; height: 200px; display: block; margin-left: auto; margin-right: auto; margin-top: 20px;" src="../media_productos/' . htmlspecialchars($producto['img_P']) . '" class="rounded float-start" alt="Imagen de ' . htmlspecialchars($producto['Nombre_P']) . '">
                <div class="card-body">
                  <h5 class="card-title">' . htmlspecialchars($producto['Nombre_P']) . '</h5>
                  <p class="card-text">' . htmlspecialchars($producto['Descripcion']) . '</p>
                </div>
                <div class="mb-5 d-flex justify-content-between align-items-center">
                  <h3>' . htmlspecialchars($producto['Valor_P']) . '</h3>
                  <form method="post" action="controlador_carrito.php" class="form-agregar">
                    <input type="hidden" name="ID_Producto" value="' . htmlspecialchars($producto['ID_Producto']) . '">
                    <input type="hidden" name="Nombre_P" value="' . htmlspecialchars($producto['Nombre_P']) . '">
                    <input type="hidden" name="Descripcion" value="' . htmlspecialchars($producto['Descripcion']) . '">
                    <input type="hidden" name="img_P" value="' . htmlspecialchars($producto['img_P']) . '">
                    <input type="hidden" name="Valor_P" value="' . htmlspecialchars($producto['Valor_P']) . '">
                    <input type="hidden" name="ID_Restaurante" value="' . htmlspecialchars($id_restaurante) . '">
                    <input type="hidden" name="Nombre_Restaurante" value="' . htmlspecialchars($nombre_restaurante) . '">
                    <button type="submit" class="btn btn-primary">Agregar al carrito</button>
                  </form>
                </div>
              </div>
            </div>';
    }
    echo '</div>';
  } else {
    echo "<h3>No se encontraron resultados para '<strong>" . htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8') . "</strong>'</h3>";
  }
} else {
  echo "<h3>Introduce un término de búsqueda.</h3>";
}
?>
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

  
  <script src="../JS/barra_busqueda.js"></script>
</body>

</html>