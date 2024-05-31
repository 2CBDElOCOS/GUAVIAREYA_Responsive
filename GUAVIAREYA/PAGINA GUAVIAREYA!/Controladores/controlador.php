<?php
$seccion = "home"; // Sección por defecto.

if (isset($_GET['seccion'])) {
    $seccion = $_GET['seccion'];
}

// Incluye la plantilla principal y la sección correspondiente
include("../Vista/plantilla.php");
?>
