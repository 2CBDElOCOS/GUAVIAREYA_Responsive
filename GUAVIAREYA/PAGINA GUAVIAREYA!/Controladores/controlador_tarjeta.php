<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include the model
include('../Modelos/add_metodo_pago.php');

// Check if form data is posted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $numero = $_POST['tarjeta'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $expiracion = $_POST['expiracion'];
    $cvv = $_POST['cvv'];

    // Validate and sanitize input (add your validation here)

    // Call model function to add payment method
    if (add_metodo_pago::add_metodo_pago($numero, $nombre, $apellido, $expiracion, $cvv)) {
        echo "Método de pago agregado exitosamente.";
        // Redirect or show a success message
        header("Location: success.php");
    } else {
        echo "Error al agregar el método de pago.";
        // Handle error
    }
} else {
    echo "Acceso no autorizado.";
}
