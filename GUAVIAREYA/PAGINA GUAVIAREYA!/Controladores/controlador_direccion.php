<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['direccion_seleccionada'])) {
        // Guardar la dirección seleccionada en la sesión
        $_SESSION['direccion_seleccionada'] = intval($_POST['direccion_seleccionada']);
        
        // Redirigir a la página de confirmación del pedido
        header("Location: ../Controladores/controlador_pedidos.php");
        exit();
    } else {
        die('No se ha seleccionado una dirección.');
    }
} else {
    die('Método de solicitud no permitido.');
}
?>
