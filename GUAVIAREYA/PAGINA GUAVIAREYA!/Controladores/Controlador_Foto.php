<?php
require_once('../Modelos/DataUser.php');

session_start();
if (!isset($_SESSION['correo'])) {
    header("location: ../Vista/Perfil.php");
    exit();
}

$userEmail = $_SESSION['correo'];
$gestorUsuarios = new DataUser();

$result = $gestorUsuarios->subirFotoPerfil($userEmail, $_FILES['img_U']);

if ($result === true) {
    // Redirigir al perfil del usuario con un mensaje de éxito
    header("location: controlador.php?seccion=perfil");
} else {
    // Redirigir al perfil del usuario con un mensaje de error
    header("location: controlador.php?seccion=perfil=" . urlencode($result));
}
exit();
