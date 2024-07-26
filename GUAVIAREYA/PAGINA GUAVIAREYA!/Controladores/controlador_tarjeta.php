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
        // Establecer los detalles del método de pago en la sesión
        $_SESSION['metodo_pago'] = [
            'numero' => $numero,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'expiracion' => $expiracion,
            'cvv' => $cvv
        ];

        // Redirigir a facturacion.php
        header("Location: ../Controladores/controlador.php?seccion=confirmacion");
        exit;
    } else {
        echo "Error al agregar el método de pago.";
        // Manejar el error
    }
} else {
    echo "Acceso no autorizado.";
}
?>