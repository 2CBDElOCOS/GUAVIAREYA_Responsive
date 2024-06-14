<?php
include('../Modelos/Inicio_sesion.php');

// Verificar si se ha enviado el formulario de inicio de sesión

    if (isset($_POST['Correo']) && isset($_POST['Contrasena'])) {
        $correo = $_POST['Correo'];
        $contrasena = $_POST['Contrasena'];

        // Verificar si los campos de correo y contraseña no están vacíos
        if (!empty($correo) && !empty($contrasena)) {
            // Aquí va tu código para iniciar sesión
            Login::IniciarSesion();
        } else {
            // Si los campos están vacíos, redirigir al usuario de vuelta al formulario de inicio de sesión
            header("location: /Controladores/controlador.php?seccion=login");
            exit();
        }
    }
//}


?>