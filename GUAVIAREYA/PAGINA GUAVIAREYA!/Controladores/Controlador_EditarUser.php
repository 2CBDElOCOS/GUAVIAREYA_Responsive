<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../Modelos/DataUser.php';

    // Obtener datos del formulario
    $correo = $_POST['Correo'];
    $nombre = isset($_POST['Nombre']) ? $_POST['Nombre'] : null;
    $apellido = isset($_POST['Apellido']) ? $_POST['Apellido'] : null;
    $telefono = isset($_POST['Telefono']) ? $_POST['Telefono'] : null;

    // Crear instancia de DataUser
    $dataUser = new DataUser();

    // Actualizar solo los campos que no son null
    if ($nombre) {
        $dataUser->updateUser($correo, $nombre, $apellido, $telefono);
    } elseif ($apellido) {
        $dataUser->updateUser($correo, $nombre, $apellido, $telefono);
    } elseif ($telefono) {
        $dataUser->updateUser($correo, $nombre, $apellido, $telefono);
    }

    // Redirigir a la página de perfil o a donde desees
    header("Location: controlador.php?seccion=perfil");
    exit();
}
