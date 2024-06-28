<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("../Modelos/Inicio_sesion.php");

// Verificar si se ha enviado el formulario de inicio de sesión
if (isset($_POST['Correo']) && isset($_POST['Contrasena'])) {
    $correo = $_POST['Correo'];
    $contrasena = $_POST['Contrasena'];

    // Verificar si el usuario está bloqueado temporalmente
    if (isset($_SESSION['bloqueado_hasta']) && $_SESSION['bloqueado_hasta'] > time()) {
        $tiempoRestante = $_SESSION['bloqueado_hasta'] - time();
        // Usuario bloqueado temporalmente, redirigir con información de bloqueo
        header("location: ../Controladores/controlador.php?seccion=login&error=blocked&time=$tiempoRestante");
        exit;
    }

    // Verificar si los campos de correo y contraseña no están vacíos
    if (!empty($correo) && !empty($contrasena)) {
        // Autenticar el usuario
        $resultado = Login::IniciarSesion($correo, $contrasena);

        if ($resultado == 1) {
            $_SESSION['correo'] = $correo; // Guardar el correo en la sesión
            header("location: ../Controladores/controlador.php?seccion=shop");
            exit; // Finalizar el script después de la redirección
        } elseif ($resultado == 0) {
            // Inicio de sesión fallido
            header("location: ../Controladores/controlador.php?seccion=login&error=incorrect");
            exit; // Finalizar el script después de la redirección
        } elseif ($resultado == 2) {
            // Usuario bloqueado temporalmente
            header("location: ../Controladores/controlador.php?seccion=login&error=blocked");
            exit; // Finalizar el script después de la redirección
        }
    }
}

// Si los campos están vacíos o no se ha enviado el formulario, cargar la vista de inicio de sesión
header("location: controlador.php?seccion=login");
?>
