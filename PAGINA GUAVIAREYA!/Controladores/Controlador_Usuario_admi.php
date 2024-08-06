<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("../Modelos/inicio_sesion_admi.php");

if (isset($_POST['correo']) && isset($_POST['contrasena'])) {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Verificar si el administrador está bloqueado temporalmente
    if (isset($_SESSION['bloqueado_hasta_admi']) && $_SESSION['bloqueado_hasta_admi'] > time()) {
        $tiempoRestante = $_SESSION['bloqueado_hasta_admi'] - time();
        // Administrador bloqueado temporalmente, redirigir con información de bloqueo
        header("location: ../Controladores/controlador.php?seccion=ADMI_login_A&error=blocked&time=$tiempoRestante");
        exit;
    }

    if (!empty($correo) && !empty($contrasena)) {
        $rol = Login::IniciarSesion($correo, $contrasena);

        if ($rol) {
            $_SESSION['correo'] = $correo;

            if ($rol == 'super_administrador') {
                header("location: ../Controladores/controlador.php?seccion=SuperAdmin_Panel");
            } else {
                header("location: ../Controladores/controlador.php?seccion=ADMI_Shop_A");
            }
            exit;
        } else {
            // Manejo de error de inicio de sesión fallido
            header("location: ../Controladores/controlador.php?seccion=ADMI_login_A&error=1");
            exit;
        }
    } else {
        header("location: ../Controladores/controlador.php?seccion=ADMI_login_A&error=Debes completar todos los campos");
        exit;
    }
} else {
    header("location: ../Controladores/controlador.php?seccion=ADMI_login_A");
    exit;
}
?>
