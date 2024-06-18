<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('../modelos/mostrar_productos.php');

$mostrarProductos = new mostrar_productos();
$productos = $mostrarProductos->obtenerProductos();

include('../Vista/ADMI_Productos_A.php');
?>
