<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$seccion = "home"; // Sección por defecto.

if (isset($_GET['seccion'])) {
    $seccion = $_GET['seccion'];
}
include("../Vista/plantilla.php");
?>
