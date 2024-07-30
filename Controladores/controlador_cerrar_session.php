<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Incluir el archivo del modelo
include '../Modelos/cerrar_sesion.php';

// Llamar a la función de cierre de sesión
CerrarSession::cerrar();

// Redirigir al usuario a la página de inicio de sesión
header("Location: ../Controladores/controlador.php?seccion=login");
exit();
?>
