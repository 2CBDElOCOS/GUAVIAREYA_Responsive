<?php
$seccion = "home"; // Sección por defecto.

if (isset($_GET['seccion'])) {
    $seccion = $_GET['seccion'];
}
 include("../Vista/plantilla.php");
?>
