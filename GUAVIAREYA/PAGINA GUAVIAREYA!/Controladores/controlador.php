<?php
$seccion = "home"; // Sección por defecto.

if (isset($_GET['seccion'])) {
    $seccion = $_GET['seccion'];
}

if (strpos($seccion, 'ADMI_') === 0) {
    // Si la sección comienza con "ADMI_", incluye la plantilla desde la ruta "../ADMI/"
    include("../ADMI/plantilla_admi.php");
} else {
    // De lo contrario, incluye la plantilla desde la ruta "../Vista/"
    include("../Vista/plantilla.php");
}
?>
