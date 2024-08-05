<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("../Modelos/Inicio_sesion.php");
require_once("../Modelos/Cupones.php");

// Verificar si se ha enviado el formulario de inicio de sesión
if (isset($_POST['Correo']) && isset($_POST['Contrasena'])) {
    $correo = $_POST['Correo'];
    $contrasena = $_POST['Contrasena'];

    // Verificar si el usuario está bloqueado temporalmente
    if (isset($_SESSION['bloqueado_hasta']) && $_SESSION['bloqueado_hasta'] > time()) {
        $tiempoRestante = $_SESSION['bloqueado_hasta'] - time();
        header("location: ../Controladores/controlador.php?seccion=login&error=blocked&time=$tiempoRestante");
        exit;
    }

    if (!empty($correo) && !empty($contrasena)) {
        $resultado = Login::IniciarSesion($correo, $contrasena);

        if ($resultado == 1) {
            $_SESSION['correo'] = $correo;

            // Consultar si el usuario tiene un cupón que no ha sido usado
            $cupon = Cupones::ObtenerCuponPorCorreo($correo);
            if ($cupon) {
                $_SESSION['cupon'] = $cupon;
                header("location: ../Controladores/controlador.php?seccion=mostrar_cupon");
            } else {
                header("location: ../Controladores/controlador.php?seccion=shop");
            }
            exit;
        } elseif ($resultado == 0) {
            header("location: ../Controladores/controlador.php?seccion=login&error=1");
            exit;
        } elseif ($resultado == 2) {
            header("location: ../Controladores/controlador.php?seccion=login&error=blocked");
            exit;
        }
    }
} else {
    header("location: ../Controladores/controlador.php?seccion=login");
}
?>
