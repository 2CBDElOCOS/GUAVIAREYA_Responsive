<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("../Modelos/Inicio_sesion.php");

// Verificar si se ha enviado el formulario de inicio de sesión

if (isset($_POST['Correo']) && isset($_POST['Contrasena'])) {
    $correo = $_POST['Correo'];
    $contrasena = $_POST['Contrasena'];


    // Verificar si los campos de correo y contraseña no están vacíos
    
    if (!empty($correo) && !empty($contrasena)) {
        // Autenticar el usuario
        if (Login::IniciarSesion($correo, $contrasena)!=0) {
            $_SESSION['correo'] = $correo; // Guardar el correo en la sesión
            header("location: ../Controladores/controlador.php?seccion=shop");
        } else {
            header("location: ../Controladores/controlador.php?seccion=login");
        }
    } else {
        // Si los campos están vacíos, redirigir al formulario de inicio de sesión
        header("location: ../Controladores/controlador.php?seccion=login");
    }
} else {
    // Cargar la vista de inicio de sesión si no se han enviado datos
    include("../Vista/login.php");
}
