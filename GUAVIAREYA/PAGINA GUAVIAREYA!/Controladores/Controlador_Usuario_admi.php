<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("../Modelos/inicio_sesion_admi.php");

if (isset($_POST['correo']) && isset($_POST['contrasena'])) {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    if (!empty($correo) && !empty($contrasena)) {
        $id_restaurante = Login::IniciarSesion($correo, $contrasena);

        if ($id_restaurante) {
            $_SESSION['correo'] = $correo;
            $_SESSION['id_restaurante'] = $id_restaurante;

            header("location: ../Controladores/controlador.php?seccion=ADMI_Shop_A");
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
