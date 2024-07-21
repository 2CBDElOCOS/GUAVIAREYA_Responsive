<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Incluir el modelo
include('../Modelos/add_metodo_pago.php');

// Verificar si los datos del formulario se han enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $numero = $_POST['tarjeta'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $expiracion = $_POST['expiracion'];
    $cvv = $_POST['cvv'];
    $correo = $_SESSION['correo']; // Asumiendo que el correo del usuario está almacenado en la sesión

    // Validar y sanitizar la entrada (agrega tu validación aquí)

    // Llamar a la función del modelo para agregar el método de pago
    if (add_metodo_pago::add_metodo_pago($numero, $nombre, $apellido, $expiracion, $cvv, $correo)) {
        // Establecer el método de pago seleccionado en la sesión
        $_SESSION['metodo_pago'] = 'tarjeta';
        
        // Redirigir a facturacion.php
        header("Location: ../Controladores/controlador.php?seccion=facturacion");
        exit;
    } else {
        echo "Error al agregar el método de pago.";
        // Manejar el error
    }
} else {
    echo "Acceso no autorizado.";
}
?>
