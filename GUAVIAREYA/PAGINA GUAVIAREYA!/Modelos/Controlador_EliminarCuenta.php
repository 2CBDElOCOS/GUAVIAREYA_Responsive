<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('../Modelos/DataUser.php');


// Verificar que el usuario esté logueado
if (isset($_SESSION['correo'])) {
    $userEmail = $_SESSION['correo'];

    // Llamar a la función para eliminar la cuenta
    $resultado = DataUser::eliminarCuenta($userEmail);
    
    // Manejar el resultado de la eliminación
    if ($resultado === true) {
        // Cerrar sesión y redirigir al inicio de sesión
        session_destroy();
        header("Location: ../Controladores/controlador.php?seccion=login&mensaje=cuenta_eliminada");
        exit();
    } else {
        $_SESSION['error'] = $resultado;
        header("Location: ../Controladores/controlador.php?seccion=Perfil");
        exit();
    }
} else {
    $_SESSION['error'] = "No se ha iniciado sesión.";
    header("Location: ../Controladores/controlador.php?seccion=login");
    exit();
}
?>
