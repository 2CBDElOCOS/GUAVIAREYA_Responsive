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
<html lang="es">

<head>
  <title>GuaviareYa!</title>
  <style>
    /* Estilos del recuadro de búsqueda */
    #search-box {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, 0.8);
      color: white;
      padding: 20px;
      z-index: 2000;
      align-items: center;
      justify-content: center;
      flex-direction: column;
    }

    #search-box input {
      width: 100%;
      max-width: 600px;
      padding: 10px;
      font-size: 16px;
    }

    #search-box button {
      background: #f44336;
      border: none;
      color: white;
      padding: 10px 20px;
      margin-top: 10px;
      cursor: pointer;
    }

    #search-box button:hover {
      background: #d32f2f;
    }

    header {
      z-index: 1000;
      position: relative;
    }

    #resultados_busqueda {
      padding: 20px;
      background: #f9f9f9;
      margin-top: 20px;
    }
  </style>
</head>

<body>
  <div class="container">
    <!-- Header -->
    <header class="fixed-top bg-dark">
      <div class="row align-items-center">
        <div class="col-6 col-md-3">
          <a href="controlador.php?seccion=home" class="logo"><i class="bx bxs-home"></i> GuaviareYa</a>
        </div>
        <div class="col-6 col-md-9 d-md-flex justify-content-md-end align-items-center">
          <nav class="navlist d-none d-md-flex">
            <a href="controlador.php?seccion=home">Inicio</a>
            <a href="controlador.php?seccion=home">Sobre nosotros</a>
            <a href="#" target="_blank" class="active">Nuestra tienda</a>
            <a href="#contactanos">Contáctanos</a>
          </nav>
          <div class="nav-icons1 d-flex">
            <a href="#" id="search-icon"><i class="bx bx-search"></i></a>
            <a href="controlador.php?seccion=carrito"><i class="bx bx-cart"></i></a>
            <a href="controlador.php?seccion=perfil"><i class="bx bx-user-circle"></i></a>
          </div>
        </div>
      </div>

      <div id="search-box">
        <form action="controlador_busqueda.php" method="post">
          <input type="text" name="search" placeholder="Buscar...">
          <button type="submit" id="search-close">X</button>
        </form>
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

  <!-- Contactanos -->
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
          <a href="controlador.php?seccion=login" target="_blank"><button style="border-radius: 30px;">Tienda</button></a>
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

  <!-- Scripts -->
  <script>
    document.getElementById('search-icon').addEventListener('click', function() {
      document.getElementById('search-box').style.display = 'flex';
    });

    document.getElementById('search-close').addEventListener('click', function() {
      document.getElementById('search-box').style.display = 'none';
    });




    document.addEventListener('DOMContentLoaded', function() {
      const forms = document.querySelectorAll('.form-agregar');

      forms.forEach(form => {
        form.addEventListener('submit', function(event) {
          const useAjax = !form.classList.contains('no-ajax'); // Clase para distinguir el método

          if (useAjax) {
            event.preventDefault();

            const formData = new FormData(form);

            fetch('controlador_carrito.php', {
                method: 'POST',
                body: formData
              })
              .then(response => response.json())
              .then(data => {
                if (data.success) {
                  // Actualiza el contador del carrito
                  const cartCounter = document.querySelector('.bx-cart span');
                  if (cartCounter) {
                    cartCounter.textContent = data.contador;
                  } else {
                    // Si no existe el span, lo crea y lo añade
                    const newCounter = document.createElement('span');
                    newCounter.textContent = data.contador;
                    document.querySelector('.bx-cart').appendChild(newCounter);
                  }
                }
              })
              .catch(error => console.error('Error:', error));
          }
        });
      });
    });
  </script>


  </script>


</body>

</html>