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
        if (Login::IniciarSesion($correo, $contrasena)!=0) {
            $_SESSION['correo'] = $correo; // Guardar el correo en la sesión
            header("location: ../Controladores/controlador.php?seccion=ADMI_Shop_A");
        } else {
            header("location: ../Controladores/controlador.php?seccion=ADMI_login_A");
        }
    } else {
        // Si los campos están vacíos, redirigir al formulario de inicio de sesión
        header("location: ../Controladores/controlador.php?seccion=ADMI_login_A");
    }
} else {
    // Cargar la vista de inicio de sesión si no se han enviado datos
    header("location: ../Controladores/controlador.php?seccion=ADMI_login_A");

}