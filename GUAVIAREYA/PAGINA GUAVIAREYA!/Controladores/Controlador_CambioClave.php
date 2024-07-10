<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || empty($_SESSION['correo'])) {
    header("location: ../Controladores/controlador.php?seccion=login");
    exit();
}

// Incluir el archivo del modelo
include '../Modelos/DataUser.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si todas las claves están definidas en $_POST y no están vacías
    $required_fields = ['ContrasenaAnterior', 'NuevaContrasena', 'ConfirmarContrasena'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            header("location: ../Controladores/controlador.php?seccion=Cambiar_clave");
            exit();
        }
    }

    // Obtener datos del formulario
    $email = $_SESSION['correo'];
    $contrasenaAnterior = $_POST['ContrasenaAnterior'];
    $nuevaContrasena = $_POST['NuevaContrasena'];
    $confirmarContrasena = $_POST['ConfirmarContrasena'];

    // Verificar si las nuevas contraseñas coinciden
    if ($nuevaContrasena !== $confirmarContrasena) {
        header("location: ../Controladores/controlador.php?seccion=Cambiar_clave");
        exit();
    }

    // Verificar si la contraseña anterior coincide con la almacenada en la base de datos
    $usuario = DataUser::getUserByEmail($email);
    if (!$usuario || !password_verify($contrasenaAnterior, $usuario['Contrasena'])) {
        header("location: ../Controladores/controlador.php?seccion=Cambiar_clave");
        exit();
    }

    // Generar hash de la nueva contraseña
    $hashNuevaContrasena = password_hash($nuevaContrasena, PASSWORD_DEFAULT);

    // Actualizar la contraseña en la base de datos
    $success = DataUser::updatePassword($email, $hashNuevaContrasena);

    if ($success) {
        header("location: controlador.php?seccion=perfil");
        exit();
    } else {
        echo "Error al actualizar la contraseña.";
    }
} else {
    // Redirigir si no se reciben datos por POST
    header("location: ../Controladores/controlador.php?seccion=Cambiar_clave");
    exit();
}
?>
