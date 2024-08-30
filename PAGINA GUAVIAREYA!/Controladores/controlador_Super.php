<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('../Modelos/add_restaurantes.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = add_restaurantes::add_restaurantes();

    if (is_string($result)) {
        // Codificar el mensaje de error para evitar problemas en la URL
        $encodedError = urlencode($result);
        // Redirigir de nuevo al formulario con el mensaje de error
        header("Location: ../Controladores/controlador.php?seccion=SUPER_add&error=$encodedError");
        exit;
    } else {
        // Si no hay error, obtener el ID del restaurante recién insertado
        $restaurante_id = $result;
        header("Location: ../Controladores/controlador.php?seccion=SUPER_add_administrador&ID_Restaurante=$restaurante_id");
        exit;
    }
} else {
    header("Location: ../Controladores/controlador.php?seccion=SUPER_add");
    exit;
}

?>
