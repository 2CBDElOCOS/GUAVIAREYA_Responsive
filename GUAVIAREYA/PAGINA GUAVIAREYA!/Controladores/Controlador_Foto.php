<?php
require_once('../Modelos/DataUser.php');

session_start();
if (!isset($_SESSION['correo'])) {
    header("Location: ../Controladores/controlador.php?seccion=login");
    exit();
}

$userEmail = $_SESSION['correo'];
$gestorUsuarios = new DataUser();

$result = $gestorUsuarios->subirFotoPerfil($userEmail, $_FILES['img_U']);

if ($result === true) {
    // Redirigir al perfil del usuario con un mensaje de éxito
    header("Location: ../Vista/perfil.php?mensaje=exito");
} else {
    // Redirigir al perfil del usuario con un mensaje de error
    header("Location: ../Vista/perfil.php?mensaje=" . urlencode($result));
}
exit();
?>
