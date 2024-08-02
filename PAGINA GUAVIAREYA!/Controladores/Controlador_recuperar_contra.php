<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../Modelos/DataUser.php';

// Verificar que se haya enviado el formulario por POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Definir los campos obligatorios
    $required_fields = ['NuevaContrasena', 'ConfirmarContrasena'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            header("location: ../Controladores/controlador.php?seccion=Olvidaste2&error=1");
            exit();
        }
    }

    // Obtener los datos del formulario
    $nuevaContrasena = $_POST['NuevaContrasena'];
    $confirmarContrasena = $_POST['ConfirmarContrasena'];

    // Verificar que las contraseñas coincidan
    if ($nuevaContrasena !== $confirmarContrasena) {
        header("location: ../Controladores/controlador.php?seccion=Olvidaste2&error=2");
        exit();
    }

    // Obtener el correo electrónico del usuario desde la sesión (o desde un parámetro GET si se desea)
    $email = isset($_GET['correo']) ? $_GET['correo'] : ''; // Asegúrate de pasar el correo a través de GET

    if (empty($email)) {
        header("location: ../Controladores/controlador.php?seccion=Olvidaste2&error=3");
        exit();
    }

    // Hash de la nueva contraseña
    $hashedPassword = md5($nuevaContrasena);

    // Actualizar la contraseña del usuario
    $success = DataUser::updatePassword($email, $hashedPassword);

    if ($success) {
        // Redirigir a una página de éxito o inicio de sesión
        header("location: ../Controladores/controlador.php?seccion=Olvidaste2&success=1");
        exit();
    } else {
        echo "Error al actualizar la contraseña.";
    }
} else {
    // Redirigir si no se hace una solicitud POST
    header("location: ../Controladores/controlador.php?seccion=Olvidaste2&error=3");
    exit();
}
?>
