<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || empty($_SESSION['correo'])) {
    header("location: ../Controladores/controlador.php?seccion=login");
    exit();
}

include '../Modelos/DataSuperAdmi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $required_fields = ['ContrasenaAnterior', 'NuevaContrasena', 'ConfirmarContrasena'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            header("location: ../Controladores/controlador.php?seccion=CambiarClave_SuperAdmi&error=1");
            exit();
        }
    }

    $email = $_SESSION['correo'];
    $contrasenaAnterior = $_POST['ContrasenaAnterior'];
    $nuevaContrasena = $_POST['NuevaContrasena'];
    $confirmarContrasena = $_POST['ConfirmarContrasena'];

    // Verificar que la nueva contraseña y su confirmación coincidan
    if ($nuevaContrasena !== $confirmarContrasena) {
        header("location: ../Controladores/controlador.php?seccion=CambiarClave_SuperAdmi&error=2");
        exit();
    }

    // Obtener el usuario por su correo electrónico
    $usuario = DataSuperAdmi::obteneremail($email);

    // Comparar la contraseña sin cifrado
    if (!$usuario || $contrasenaAnterior !== $usuario['contrasena']) {
        header("location: ../Controladores/controlador.php?seccion=CambiarClave_SuperAdmi&error=3");
        exit();
    }

    // Actualizar la contraseña
    $success = DataSuperAdmi::updatePassword($email, $nuevaContrasena);

    if ($success) {
        header("location: controlador.php?seccion=Perfil_SuperAdmi");
        exit();
    } else {
        header("location: ../Controladores/controlador.php?seccion=CambiarClave_SuperAdmi&error=4");
        exit();
    }
} else {
    header("location: ../Controladores/controlador.php?seccion=CambiarClave_SuperAdmi&error=5");
    exit();
}

?>
