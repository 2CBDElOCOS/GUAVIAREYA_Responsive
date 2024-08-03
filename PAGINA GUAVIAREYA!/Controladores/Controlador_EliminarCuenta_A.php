<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || $_SESSION['correo'] == "") {
    header("location: ../Controladores/controlador.php?seccion=login");
    exit();
}

// Incluir el archivo del modelo
include '../Modelos/DataAdmi.php';

// Verificar si ID_Restaurante está en la sesión
if (!isset($_SESSION['ID_Restaurante']) || empty($_SESSION['ID_Restaurante'])) {
    echo "ID de restaurante no encontrado en la sesión.";
    // Mostrar el contenido de la sesión para depuración
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";
    exit();
}

$idRestaurante = $_SESSION['ID_Restaurante'];

// Eliminar el administrador asociado
if (DataAdmi::eliminarAdministrador($idRestaurante)) {
    // Eliminar el restaurante
    if (DataAdmi::eliminarRestaurante($idRestaurante)) {
        // Redirigir a una página de éxito o información
        header("location: ../Controladores/controlador.php?seccion=login");
        exit();
    } else {
        // Manejar el error de eliminación del restaurante
        echo "Error al eliminar el restaurante.";
    }
} else {
    // Manejar el error de eliminación del administrador
    echo "Error al eliminar el administrador.";
}
?>
