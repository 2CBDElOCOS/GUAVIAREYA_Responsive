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

    // Verificar si el correo existe en la base de datos
    if (Login::VerificarCorreoExistente($correo)) {
        $resultado = Login::IniciarSesion($correo, $contrasena);

        if ($resultado == 1) {
            $_SESSION['correo'] = $correo;

            // Consultar si el usuario tiene un cupón que no ha sido usado
            $cupon = Cupones::ObtenerCuponPorCorreo($correo);
            if ($cupon) {
                $_SESSION['cupon_codigo'] = $cupon['Codigo_Cupon']; // Guardar solo el código del cupón
                header("location: ../Controladores/controlador.php?seccion=mostrar_cupon");
            } else {
                header("location: ../Controladores/controlador.php?seccion=shop");
            }
            exit;
        } elseif ($resultado == 0) {
            header("location: ../Controladores/controlador.php?seccion=login&error=1");
            exit;
        } elseif ($resultado == 2) {
            // Bloquear temporalmente si el usuario está bloqueado
            header("location: ../Controladores/controlador.php?seccion=login&error=blocked");
            exit;
        }
    } else {
        // Correo no registrado
        header("location: ../Controladores/controlador.php?seccion=login&error=2");
        exit;
    }
} else {
    header("location: ../Controladores/controlador.php?seccion=login");
}
?>
