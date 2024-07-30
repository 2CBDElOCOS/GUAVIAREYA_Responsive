<?php
// Verificar si la sesión no está iniciada y comenzarla si es necesario
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Incluir el modelo para mostrar productos
include('../modelos/mostrar_productos.php');

// Crear una instancia del modelo
$mostrarProductos = new mostrar_productos();

// Verificar si hay un restaurante válido en la sesión
if (isset($_SESSION['id_restaurante'])) {
    $id_restaurante = $_SESSION['id_restaurante'];

    // Obtener el nombre del restaurante
    $nombre_restaurante = $mostrarProductos->obtenerNombreRestaurante($id_restaurante);

    // Incluir la vista para mostrar productos
    include('../Vista/ADMI_Productos_A.php');
} else {
    // Manejar el caso en que no haya restaurante válido
    echo '<h1 style="text-align: center; color: white;">No se ha especificado un restaurante válido.</h1>';
}
?>
