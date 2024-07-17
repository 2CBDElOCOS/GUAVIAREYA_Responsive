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
    // Verificar si todas las claves están definidas en $_POST
    $required_fields = ['Nombre', 'Apellido', 'Telefono'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            header("location: ../Controladores/controlador.php?seccion=perfil_E");
            exit();
        }
    }

    $email = $_SESSION['correo'];
    // Agregar apodo si es necesario
    $nombre = $_POST['Nombre']; 
    $apellido = $_POST['Apellido'];
    $telefono = $_POST['Telefono'];

    $success = DataUser::updateUser($email, $nombre, $apellido, $telefono);

    if ($success) {
        header("location: controlador.php?seccion=perfil");
        exit();
    } else {
        echo "Error al actualizar los datos.";
    }
} else {
    // Handle the case if the form is not submitted via POST
    header("location: controlador.php?seccion=perfil_E");
    exit();
}
?>
