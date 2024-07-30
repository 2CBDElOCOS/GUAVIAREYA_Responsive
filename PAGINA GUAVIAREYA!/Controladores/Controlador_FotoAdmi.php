<?php
require_once('../Modelos/DataAdmi.php');

session_start();
if (!isset($_SESSION['correo'])) {
    header("Location: ../Vista/PerfiADMI_Perfil_Al.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userEmail = $_SESSION['correo'];

    // Verificar si el archivo fue enviado y tiene el error UPLOAD_ERR_OK
    if (isset($_FILES['img_U']) && $_FILES['img_U']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['img_U'];
        $gestorUsuarios = new DataAdmi();

        // Subir la foto de perfil y actualizar la base de datos
        $result = $gestorUsuarios->subirFotoPerfil($userEmail, $file);

        if ($result === true) {
            // Redirigir al perfil del usuario con un mensaje de éxito
            header("Location: controlador.php?seccion=ADMI_Perfil_A&success=1");
        } else {
            // Redirigir al perfil del usuario con un mensaje de error
            header("Location: ../Controladores/controlador.php?seccion=ADMI_Perfil_A&error=" . urlencode($result));
        }
    } else {
        // Redirigir al perfil del usuario con un mensaje de error de archivo
        header("Location: ../Controladores/controlador.php?seccion=ADMI_Perfil_A&error=Error al subir el archivo.");
    }
    exit();
} else {
    // Redirigir al perfil si el método de solicitud no es POST
    header("Location: ../Vista/ADMI_Perfil_A.php");
    exit();
}
?>
