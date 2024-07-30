<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("../Modelos/inicio_sesion_admi.php");

if (isset($_POST['correo']) && isset($_POST['contrasena'])) {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

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
            header("location: ../Controladores/controlador.php?seccion=ADMI_login_A&error=Correo o contraseña incorrectos");
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
