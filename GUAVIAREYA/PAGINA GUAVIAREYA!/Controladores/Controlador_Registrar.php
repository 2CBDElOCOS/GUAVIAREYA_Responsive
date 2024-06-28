<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once("../Modelos/Registrar.php");

// Verificar si se han enviado los datos del formulario de registro
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    Registrar::registrarUsuario();
} else {
    // Cargar la vista de registro si no se han enviado datos
    include("../Vista/registro.php");
}
?>
