<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || empty($_SESSION['correo'])) {
    header("location: ../Controladores/controlador.php?seccion=login");
    exit();
}

include '../Modelos/DataUser.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $required_fields = ['ContrasenaAnterior', 'NuevaContrasena', 'ConfirmarContrasena'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            header("location: ../Controladores/controlador.php?seccion=Cambiar_clave&error=1");
            exit();
        }
    }

    $email = $_SESSION['correo'];
    $contrasenaAnterior = md5($_POST['ContrasenaAnterior']);  // Encriptar contraseña anterior
    $nuevaContrasena = md5($_POST['NuevaContrasena']);  // Encriptar nueva contraseña
    $confirmarContrasena = md5($_POST['ConfirmarContrasena']);  // Encriptar confirmación de contraseña

    if ($nuevaContrasena !== $confirmarContrasena) {
        header("location: ../Controladores/controlador.php?seccion=Cambiar_clave&error=2");
        exit();
    }

    $usuario = DataUser::getUserByEmail($email);

    if (!$usuario) {
        header("location: ../Controladores/controlador.php?seccion=Cambiar_clave&error=3");
        exit();
    }

    if ($contrasenaAnterior !== $usuario['Contrasena']) {
        header("location: ../Controladores/controlador.php?seccion=Cambiar_clave&error=3");
        exit();
    }

    $success = DataUser::updatePassword($email, $nuevaContrasena);

    if ($success) {
        header("location: controlador.php?seccion=perfil");
        exit();
    } else {
        echo "Error al actualizar la contraseña.";
    }
} else {
    header("location: ../Controladores/controlador.php?seccion=Cambiar_clave&error=3");
    exit();
}
?>
