<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("../Modelos/inicio_sesion_admi.php");

// Verificar si se ha enviado el formulario de inicio de sesión
if (isset($_POST['correo']) && isset($_POST['contrasena'])) {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Verificar si los campos de correo y contraseña no están vacíos
    if (!empty($correo) && !empty($contrasena)) {
        // Autenticar el usuario
        if (Login::IniciarSesion($correo, $contrasena)) {
            // Obtener el ID_Restaurante del administrador
            $id_restaurante = Login::IniciarSesion($correo);

            // Guardar datos en la sesión
            $_SESSION['correo'] = $correo;
            $_SESSION['id_restaurante'] = $id_restaurante;

            // Redirigir al panel de administrador
            header("location: ../Controladores/controlador.php?seccion=ADMI_Shop_A");
            exit;
        } else {
            // Redirigir al formulario de inicio de sesión con mensaje de error
            header("location: ../Controladores/controlador.php?seccion=ADMI_login_A&error=Correo o contraseña incorrectos");
            exit;
        }
    } else {
        // Redirigir al formulario de inicio de sesión con mensaje de campos vacíos
        header("location: ../Controladores/controlador.php?seccion=ADMI_login_A&error=Debes completar todos los campos");
        exit;
    }
} else {
    // Redirigir al formulario de inicio de sesión si no se han enviado datos
    header("location: ../Controladores/controlador.php?seccion=ADMI_login_A");
    exit;
}
?>
