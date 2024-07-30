<?php
// Controlador_guardar_direccion.php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['direccion'])) {
    $direccionSeleccionada = intval($_POST['direccion']);
    $_SESSION['direccion_seleccionada'] = $direccionSeleccionada;
    echo 'Direccion seleccionada correctamente';
} else {
    echo 'Fallo al seleccionar la direccion';
}


?>
