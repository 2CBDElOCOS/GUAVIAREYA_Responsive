<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../Modelos/DataUser.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
    $nuevaContrasena = $_POST['NuevaContrasena'];
    $confirmarContrasena = $_POST['ConfirmarContrasena'];

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Correo no válido';
        header("Location: ../Vista/olvidaste2.php?correo=" . urlencode($correo));
        exit;
    }

    if ($nuevaContrasena !== $confirmarContrasena) {
        $_SESSION['error'] = 'Las contraseñas no coinciden';
        header("Location: ../Vista/olvidaste2.php?correo=" . urlencode($correo));
        exit;
    }

    // Aquí iría el código para actualizar la contraseña en la base de datos
    $hashedPassword = md5($nuevaContrasena);
    $userData = new DataUser();
    $result = $userData->actualizarContrasena($correo, $hashedPassword);

    if ($result) {
        $_SESSION['success'] = 'Contraseña actualizada con éxito';
        header("Location: ../Controladores/controlador.php?seccion=login");
    } else {
        $_SESSION['error'] = 'Error al actualizar la contraseña';
        header("Location: ../Vista/olvidaste2.php?correo=" . urlencode($correo));
    }
} else {
    $_SESSION['error'] = 'Método de solicitud no válido';
    header("Location: ../Vista/olvidaste2.php?correo=" . urlencode($correo));
}
?>
