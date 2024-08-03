<?php
include '../Modelos/buscar.php'; // Incluye el archivo del Modelo

// Crear una instancia del Modelo
$busqueda = new Busqueda();

if (isset($_POST['search'])) {
    $searchTerm = trim($_POST['search']);
    $resultados = $busqueda->buscarProductos($searchTerm);

    // Redirigir a la página principal con el término de búsqueda
    header('Location: ../Controladores/controlador.php?seccion=shop&search=' . urlencode($searchTerm));
    exit();
}
?>
