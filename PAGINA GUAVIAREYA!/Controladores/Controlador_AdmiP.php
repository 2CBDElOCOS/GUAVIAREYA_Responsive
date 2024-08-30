<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['correo']) || empty($_SESSION['correo'])) {
    header("location: ../Controladores/controlador.php?seccion=login");
    exit();
}

// Incluir el archivo del modelo
include '../Modelos/DataAdmi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verificar si todas las claves están definidas en $_POST
    $required_fields = ['Nombre_R', 'Telefono', 'Direccion'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            header("location: ../Controladores/controlador.php?seccion=ADMI_Editar_A");
            exit();
        }
    }

    $email = $_SESSION['correo'];
    $nombre = $_POST['Nombre_R'];
    $telefono = $_POST['Telefono'];
    $direccion = $_POST['Direccion'];

    $success = DataAdmi::updateadmi($email, $nombre, $telefono, $direccion);

    if ($success) {
        header("location: controlador.php?seccion=ADMI_Perfil_A");
        exit();
    } else {
        header("location: controlador.php?seccion=ADMI_Editar_A&Error");
    }
}

?>
