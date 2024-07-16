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
        <div class="col-md-12 ico-carro">
            <a href="controlador.php?seccion=shop"><i class="bx bxs-home"></i></a>
        </div>

        <div class="subcontainer4">
            <h1 style="text-align: center;">Gracias por tu compra</h1>
            <center><img src="../media/check.png" alt="listo" width="400px"></center>
            
        </div>
    </div>



</body>

</html>