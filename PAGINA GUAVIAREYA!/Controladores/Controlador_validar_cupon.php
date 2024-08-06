<?php
require_once '../Modelos/Cupones.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Codigo_Cupon']) && !empty($_POST['Codigo_Cupon'])) {
        $codigoCupon = htmlspecialchars(trim($_POST['Codigo_Cupon']));
        $correoUsuario = $_SESSION['correo']; // Obtener el correo del usuario desde la sesión

        // Verifica si el cupón es válido
        $resultado = Cupones::validarCupon($codigoCupon, $correoUsuario);

        if ($resultado['valido']) {
            // Guarda el código y el descuento del cupón en la sesión
            $_SESSION['Codigo_Cupon'] = $codigoCupon;
            $_SESSION['cupon_descuento'] = $resultado['descuento'];
            $_SESSION['mensaje_cupon'] = "¡Cupón válido! Descuento: " . $resultado['descuento'] . "%";
        } else {
            $_SESSION['mensaje_cupon'] = "El cupón no es válido o ha expirado.";
        }
    } else {
        $_SESSION['mensaje_cupon'] = "No se ha proporcionado ningún código de cupón.";
    }
    
    header("Location: ../Controladores/controlador.php?seccion=facturacion");
    exit();
}
?>
