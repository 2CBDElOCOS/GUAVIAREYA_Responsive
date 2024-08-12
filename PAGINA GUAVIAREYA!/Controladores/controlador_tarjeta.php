<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Incluir el modelo
include('../Modelos/add_metodo_pago.php');
require_once '../Modelos/Cupones.php';  
$cupon = Cupones::ObtenerCuponPorCorreo($_SESSION['correo']);
// Verifica si el cupón se ha obtenido correctamente
if ($cupon) {
// Guarda el cupón en la sesión
$_SESSION['cupon'] = $cupon;
echo '<p>Código del cupón obtenido: ' . htmlspecialchars($cupon['codigo']) . '</p>';
} else {
echo '<p>No se encontró ningún cupón para el correo: ' . htmlspecialchars($_SESSION['correo']) . '</p>';
}
$_SESSION['cupon_descuento'] = $cupon;

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
        header("Location: ../Controladores/controlador.php?seccion=verificacion");
        exit;
    } else {
        header("Location: ../Controladores/controlador.php?seccion=tarjeta&error");
        // Manejar el error
    }
} else {
    header("Location: ../Controladores/controlador.php?seccion=tarjeta&error1");
}
?>
