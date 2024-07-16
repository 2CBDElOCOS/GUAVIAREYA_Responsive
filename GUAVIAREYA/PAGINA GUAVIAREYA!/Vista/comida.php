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

<body class="body">

    <section id="hero3">
        <div class="subcontainer2">
            <div class="row hero2">
                <div class="col-md-12 ico-footer">
                    <a href="controlador.php?seccion=shop"><i class="fa-solid fa-tent-arrow-turn-left"></i></a>
                </div>

                <h1>RESTAURANTES</h1>

                <div class="row row-cols-1 row-cols-md-3 g-4 py-5">
                    <?php
                    include('../Modelos/mostrar_restaurantes.php');

                    $mostrarProductos = new mostrar_restaurantes();
                    $restaurantes = $mostrarProductos->obtenerRestaurantes();

                    foreach ($restaurantes as $restaurante) {
                        echo '
                        <div class="col">
                            <a style="text-decoration:none" href="controlador.php?seccion=productos&id_restaurante=' . $restaurante['ID_Restaurante'] . '">
                                <div class="card">
                                    <img style="width: 200px; height: 200px; display: block; margin-left: auto; margin-right: auto; margin-top: 20px;" src="../media_restaurantes/' . $restaurante['img_R'] . '" class="rounded float-start" alt="Imagen de ' . $restaurante['Nombre_R'] . '"> <br>
                                    <div class="card-body">
                                        <h5 class="card-title"> NOMBRE: '. $restaurante['Nombre_R'] . '</h5> 
                                        <p class="card-text"> Dirección: ' . $restaurante['Direccion'] . '</p>
                                        <p class="card-text"> Teléfono: '  . $restaurante['Telefono'] . '</p>
                                    </div>
                                </div>
                            </a>
                        </div>';
                    }
                    ?>
                </div>

            </div>
        </div>
    </section>

</body>

</html>
