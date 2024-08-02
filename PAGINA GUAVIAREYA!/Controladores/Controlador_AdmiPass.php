<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || empty($_SESSION['correo'])) {
    header("location: ../Controladores/controlador.php?seccion=login");
    exit();
}

include '../Modelos/DataAdmi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar que todos los campos necesarios están presentes
    $required_fields = ['ContrasenaAnterior', 'NuevaContrasena', 'ConfirmarContrasena'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            header("location: ../Controladores/controlador.php?seccion=ADMI_CambiarPass&error=1");
            exit();
        }
    }

    $email = $_SESSION['correo'];
    $contrasenaAnterior = $_POST['ContrasenaAnterior'];
    $nuevaContrasena = $_POST['NuevaContrasena'];
    $confirmarContrasena = $_POST['ConfirmarContrasena'];

    if ($nuevaContrasena !== $confirmarContrasena) {
        header("location: ../Controladores/controlador.php?seccion=ADMI_CambiarPass&error=2");
        exit();
    }

    // Obtener el usuario por su correo electrónico
    $usuario = DataAdmi::getUserByEmail($email);

    if (!$usuario || md5($contrasenaAnterior) !== $usuario['contrasena']) {
        header("location: ../Controladores/controlador.php?seccion=ADMI_CambiarPass&error=3");
        exit();
    }

    // Actualizar la contraseña
    $success = DataAdmi::updatePassword($email, $nuevaContrasena);

    if ($success) {
        header("location: controlador.php?seccion=ADMI_Perfil_A");
        exit();
    } else {
        header("location: ../Controladores/controlador.php?seccion=ADMI_CambiarPass&error=4");
        exit();
    }
} else {
    header("location: ../Controladores/controlador.php?seccion=ADMI_CambiarPass&error=1");
    exit();
}
?>
