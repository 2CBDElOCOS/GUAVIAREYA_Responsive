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
<html lang="es">

<head>

    <title>PERFIL PEDIDOS</title>

</head>

<body>
    
    <div class="container">
        <div class="main-body">
            <div class="col-md-12 ico-footer1">
                <a href="controlador.php?seccion=shop"><i class="fa-solid fa-tent-arrow-turn-left"></i></a>
            </div>
            <div class="">
                <h4>Tus Pedidos</h4>
            </div>

            <!-- /Migajas de pan -->

            <div class="row gutters-sm">
                    <div class="row gutters-sm">
                        <div class="col-sm-12 mb-12">
                            <div class="card h-100">
                                <div class="card-body"><br>
                                    <h6 class="d-flex align-items-center mb-3">¡No tienes ningún pedido! ¡Cambiemos eso!
                                    </h6>
                                    <a href="controlador.php?seccion=shop"><button class="btn btn-primary" type="submit">¡Ordena
                                            ya!</button></a>
                                </div>
                            </div>
                        </div>

                    </div>



                </div>
            </div>

        </div>
    </div>


    


</body>

</html>